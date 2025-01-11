<?php
namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\ApiController;
use App\Http\Requests\CategoryRequest;
use App\Http\Requests\UpdatePasswordRequest;
use App\Http\Requests\UpdateProfileRequest;
use Illuminate\Http\Request;
use App\Http\Responses\Api\ApiResponse;
use Symfony\Component\HttpFoundation\Response;

use Tymon\JWTAuth\Facades\JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;
use Illuminate\Support\Facades\Validator;
use App\Models\User;

class ProfileController extends ApiController
{
    public function __construct()
    {
        parent::__construct();

    }
    public function getProfile()
    {
        // Retrieve the authenticated user using JWT
        $user = JWTAuth::parseToken()->authenticate();
        return ApiResponse::success([
            'user' => $user
        ], '');

    }

    public function updateProfile(UpdateProfileRequest $request)
    {
        try {
            $user = auth()->user();
            $user->update([
                'first_name' => $request->first_name,
                'last_name' => $request->last_name,
                'phone_number' => $request->phone_number,
            ]);
                 return ApiResponse::success([
                     'user' => $user->fresh()
                 ], __('auth.msg.profile_update_success'));
        }catch (\Exception $e) {
            // Handle the exception, log it if necessary
            \Log::error('Error : ' . $e->getMessage());
            // You can also choose to return an error response here
            return ApiResponse::error(__('messages.something_went_wrong') . " | ".$e->getMessage()  , [], Response::HTTP_INTERNAL_SERVER_ERROR);
        }

    }

    public function updatePassword(UpdatePasswordRequest $request)
    {
        try {
            $user = auth()->user();
            // Check if the current password matches
            if (!\Hash::check($request->current_password, $user->password)) {
                return ApiResponse::error(__('auth.msg.current_password_invalid'), [], Response::HTTP_UNPROCESSABLE_ENTITY);
            }

            // Update the password
            $user->password = $request->password;
            $user->save();
            return ApiResponse::success([], __('auth.msg.password_update_success'));
        } catch (\Exception $e) {
            // Log and handle the exception
            \Log::error('Error updating password: ' . $e->getMessage());
            return ApiResponse::error(__('messages.something_went_wrong') . " | ".$e->getMessage()  , [], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

}