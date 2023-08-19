<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Firebase\JWT\JWT;
use Firebase\JWT\Key;

class AuthMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        $jwt = $request->bearerToken();

        if($jwt == 'null' || $jwt == ''){
            return response()->json([
                'msg' => 'Akses ditolak, token tidak memenuhi'
            ],401);
        } else {
            $jwtDecode = JWT::decode($jwt, new Key(enc('JWT_SECRET_KEY'), 'HS256'));

            if($jwtDecode->role == 'admin') {
                return $next($request);
            }

            return response()->json([
                'msg' => 'Akses ditolak, token tidak memenuhi'
            ],401);
        }
    }
}