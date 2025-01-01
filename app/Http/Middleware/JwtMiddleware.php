<?php

namespace App\Http\Middleware;

use Closure;
use Tymon\JWTAuth\Facades\JWTAuth;
use Tymon\JWTAuth\Exceptions\TokenExpiredException;
use Tymon\JWTAuth\Exceptions\TokenInvalidException;
use Tymon\JWTAuth\Exceptions\JWTException;
use Symfony\Component\HttpFoundation\Response;
class JwtMiddleware
{

    public function handle($request, Closure $next)
    {
        try {
            $user = JWTAuth::parseToken()->authenticate();
        } catch (TokenExpiredException $e) {
            return response()->json([
                'status' => false,
                'status_code' => Response::HTTP_UNAUTHORIZED,
                'message' => __('messages.token_expired'),
                'errors' => []
            ], Response::HTTP_UNAUTHORIZED);
        } catch (TokenInvalidException $e) {
            return response()->json([
                'status' => false,
                'status_code' => Response::HTTP_UNAUTHORIZED,
                'message' => __('messages.token_invalid'),
                'errors' => []
            ], Response::HTTP_UNAUTHORIZED);
        } catch (JWTException $e) {
            return response()->json([
                'status' => false,
                'status_code' => Response::HTTP_UNAUTHORIZED,
                'message' => __('messages.token_error'),
                'errors' => []
            ], Response::HTTP_UNAUTHORIZED);
        }
        return $next($request);
    }
}
