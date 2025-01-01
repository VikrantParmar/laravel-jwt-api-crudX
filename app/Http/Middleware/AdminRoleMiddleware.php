<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Http\Responses\Api\ApiResponse;
class AdminRoleMiddleware
{

    public function handle(Request $request, Closure $next)
    {
        // Assuming the role ID for admin is 1
        $user = auth()->user();
        if (!$user || $user->role_id !== 1) {
            return ApiResponse::error(__('messages.unauthorized_api'), null , Response::HTTP_FORBIDDEN);

        }

        return $next($request);
    }
}
