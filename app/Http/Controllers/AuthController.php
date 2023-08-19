<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\User;
use Firebase\JWT\JWT;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Exceptions\HttpResponseException;

class AuthController extends Controller
{
    public function register(Request $request)
    {
        $validator = Validator::make($request->all(),[
            'nama' => 'required', 
            'email' => 'required| email|unique:user,email', 
            'password' => 'required|min:8', 
            'confimation_password' => 'required|samepassword' 
        ]);

        if($validator->fails()) {
            return messagesError($validator->messages()->toArray());
        }

        $user = $validator->validated();

        User::create($user);

        $playload = [
            'nama' => $user['nama'],
            'role' => 'user',
            'iat' => now()->timestamp,
            'exp' => now()->timestamp + 7200,
        ];

        $token = JWT::encode($playload,env('JWT_SECRET_KEY'), 'HS256');

        Log::create([
            'module' =>'login',
            'action' =>'login akun',
            'useraccess' => $user['email']
        ]);

        return response()->json([
            "data" => [
                'msg' => "berhasil login",
                'nama' => $user['nama'],
                'email' => $user['email'],
                'role' => 'User',
            ],
            "token" => "Bearer {$token}"
        ],200);
    }
}