<?php

namespace App\Http\Controllers\Api\V1;
use App\Enums\UserStatus;
use App\Http\Controllers\Controller;
use App\Http\Responses\Api\ApiResponse;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Tymon\JWTAuth\Facades\JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Password;
use App\Http\Requests\AuthRequest;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Validation\ValidationException;
use App\Notifications\UserCreatedNotification;
use App\Notifications\AdminUserCreatedNotification;
use App\Notifications\CustomResetPasswordNotification;
class AuthController extends Controller
{
    public function __construct()
    {
        // Middleware can be applied here if needed
    }
    /**
     * Register a new user
     */
    public function register(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'first_name' => 'required|string|max:255',
                'last_name' => 'required|string|max:255',
                'phone_number' => 'required|string|min:10|max:14|regex:/^\+?[0-9]+$/',
                'email' => 'required|string|email|max:255|unique:users',
                'password' => 'required|string|min:8|confirmed',
            ]);
            if ($validator->fails()) {
                $errorMsg = collect($validator->errors())->flatten()->join("\n");
                return ApiResponse::error($errorMsg , $validator->errors(), Response::HTTP_UNPROCESSABLE_ENTITY);
            }
            $user = User::create([
                'first_name' => $request->first_name,
                'last_name' => $request->last_name,
                'email' => $request->email,
                'password' => $request->password,
                'phone_number' => $request->phone_number,
                'status' => UserStatus::Active,
                'role_id' => 2, //User Roles
            ]);
            $user->notify(new UserCreatedNotification());
            // Notify admin about the new user
            $admin = User::GetAdminOnly()->first();
            if ($admin) {
                $admin->notify(new AdminUserCreatedNotification($user));
            }
            return ApiResponse::success([], __('auth.msg.register_success'));
        }catch (\Exception $e) {
            // Handle the exception, log it if necessary
            \Log::error('Error : ' . $e->getMessage());
            // You can also choose to return an error response here
            return ApiResponse::error(__('messages.something_went_wrong') . " | ".$e->getMessage()  , [], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * Log in and generate a JWT token.
     */
    public function login(AuthRequest $request)
    {
        // Step 1: Retrieve the credentials from the request
        $credentials = $request->only('email', 'password');
        // Step 2: Implement Rate Limiting
        $key = strtolower($request->input('email')) . '|' . $request->ip();
        if (RateLimiter::tooManyAttempts($key, 5)) {
            $seconds = RateLimiter::availableIn($key);
            return ApiResponse::error( __('auth.msg.too_many_attempts', ['seconds' => $seconds]),[],  Response::HTTP_UNPROCESSABLE_ENTITY);
        }

        // Step 3: Attempt to create a token for the user
        try {
            $token = JWTAuth::attempt($credentials);
            if (!$token) {
                RateLimiter::hit($key); // Increment attempt count on failure
                return ApiResponse::error(__('auth.msg.invalid_credentials'), [], Response::HTTP_UNAUTHORIZED);
            }
            // Step 4: Retrieve the user details
            $user = JWTAuth::user();
            if ($user->status !== UserStatus::Active) {
                if(JWTAuth::setToken($token)->check()){
                    JWTAuth::invalidate($token);
                }
                return ApiResponse::error(__('auth.msg.account_not_active'), [], Response::HTTP_FORBIDDEN);
            }

        } catch (JWTException $e) {
            \Log::error('Error : ' . $e->getMessage());
            return ApiResponse::error(__('messages.something_went_wrong_contact_us')." | Code:100", [], Response::HTTP_UNAUTHORIZED);
        }catch (\Exception $e) {
            \Log::error('Error : ' . $e->getMessage());
            return ApiResponse::error(__('messages.something_went_wrong'), [], Response::HTTP_INTERNAL_SERVER_ERROR);
        }

        // Step 5: Return the token and user details
        return ApiResponse::success([
            'token' => $token,
            'user' => $user
        ], __('auth.msg.login_success'));
    }
    /**
     * Send a password reset link to the user's email.
     */
    public function forgotPassword(Request $request)
    {
        $validator = Validator::make($request->all(), ['email' => 'required|email']);

        if ($validator->fails()) {
            return ApiResponse::error('', $validator->errors(), Response::HTTP_UNPROCESSABLE_ENTITY);
        }
        // Instead of using Password::sendResetLink(), use the custom notification
        $user = User::where('email', $request->email)->first();
        if ($user) {
            // Generate the reset token
            $token = Password::broker()->createToken($user);
            $user->notify(new CustomResetPasswordNotification($token));
            return ApiResponse::success([], __('auth.msg.fp_send_reset_link_success'));
        }

        return ApiResponse::error(__('auth.msg.fp_send_reset_link_success'), [], Response::HTTP_OK);

    }

    /**
     * Reset the password.
     */
    public function resetPassword(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'token' => 'required|string',
            'email' => 'required|string|email',
            'password' => 'required|string|min:8|confirmed',
        ]);

        if ($validator->fails()) {
            return ApiResponse::error('', $validator->errors(), Response::HTTP_UNPROCESSABLE_ENTITY);
        }
        $status = Password::broker()->reset(
            $request->only('email', 'password','token'),
            function ($user, $password) {
                $user->password = $password;
                $user->save();
            }
        );
        if ($status === Password::PASSWORD_RESET) {
            return ApiResponse::success([], __('auth.msg.password_reset_success'));
        }

        return ApiResponse::error(__('auth.msg.password_reset_error'), [], Response::HTTP_BAD_REQUEST);
    }


    /**
     * Refresh JWT Token
     */
    public function refreshToken(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'refresh_token' => 'required|string',
        ]);

        if ($validator->fails()) {
            return ApiResponse::error('', $validator->errors(), Response::HTTP_UNPROCESSABLE_ENTITY);
        }

        $refreshToken = $request->input('refresh_token') ?? $request->bearerToken();
        try {
            $newToken = JWTAuth::refresh($refreshToken);

            return ApiResponse::success([
                'token' => $newToken
            ], __('auth.msg.token_refreshed_successfully'));

        } catch (JWTException $e) {
            \Log::error('Error refreshing token: ' . $e->getMessage());
            return ApiResponse::error(__('auth.msg.token_refresh_error'), [], Response::HTTP_UNAUTHORIZED);
        }
    }
}
