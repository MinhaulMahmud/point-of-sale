<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Firebase\JWT\JWT;
use App\Models\User;
use App\Helper\JWTToken;

class TokenVerificationMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    // public function handle(Request $request, Closure $next): Response
    // {
    //     //recieve token from header
    //     $token = $request->header('token');
    //     $result = JWTToken::VerifyToken($token); 

    //     if ($result == "Unauthorized") {
    //         return response()->json(['status' => 'Failed', 'message' => 'Unauthorized'], 401);
    //     }
    //     else {
    //         $request->header->set('email' , $result);
    //         return $next($request);
    //     }

    // }
    public function handle(Request $request, Closure $next): Response
    {
        $token = $request->header('token');
        $result = JWTToken::VerifyToken($token);

        if ($result == "Unauthorized") {
            return response()->json(['status' => 'Failed', 'message' => 'Unauthorized'], 401);
        } elseif ($result == "TokenExpired") {
            return response()->json(['status' => 'Failed', 'message' => 'Token Expired'], 401);
        } else {
            $request->headers->set('email', $result);
            return $next($request);
        }
    }

}
