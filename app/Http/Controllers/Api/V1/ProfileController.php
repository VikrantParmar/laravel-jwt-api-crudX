<?php
namespace App\Http\Controllers\Api\V1;
use App\Http\Controllers\Controller;
use App\Http\Responses\Api\ApiResponse;
use Tymon\JWTAuth\Facades\JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;
class ProfileController extends Controller
{
    public function __construct()
    {
    }
    public function getProfile()
    {
        // Retrieve the authenticated user using JWT
        $user = JWTAuth::parseToken()->authenticate();
        return ApiResponse::success([
            'user' => $user
        ], '');

    }
}
