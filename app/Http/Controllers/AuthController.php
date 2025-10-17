<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    //
    /**
     * Summary of register
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Contracts\Routing\ResponseFactory|\Illuminate\Http\Response
     */
    public function register(Request $request)
    {
        $request->validate([
            "name" => "required|string",
            "email" => "required|email|unique:users,email",
            "password" => "required|string",
        ]);
        $password = Hash::make($request->password);
        $user = User::create([
            "name" => $request->name,
            "email" => $request->email,
            "password" => $password
        ]);
        if ($user) {
            return response([
                $user
            ], 201);
        }
    }
    /**
     * Summary of login
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Contracts\Routing\ResponseFactory|\Illuminate\Http\Response
     */
    public function login(Request $request)
    {
        $request->validate([
            "email" => "required|email|exists:users,email",
            "password" => "required|string",
        ]);
        if (Auth::attempt(["email" => $request->email, "password" => $request->password])) {
            $user = User::where(["email" => $request->email])->first();
            $token = $request->user()->createToken($user->email);
            return response([
                "token" => $token->plainTextToken,
                "user_id" => $user->id
            ], 200);
        } else {
            return response([
                "message" => "Invalid email or password"
            ], 400);
        }
    }
}
