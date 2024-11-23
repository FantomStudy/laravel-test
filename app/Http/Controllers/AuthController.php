<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginUserRequest;
use App\Http\Requests\StoreUserRequest;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    //
    public function register(StoreUserRequest $request){
        $user = User::create($request->all());
        return  
    }
    public function login(LoginUserRequest $request){
        if(!Auth::attempt($request->only('email', 'password'))){
            return response()->json(['message' => 'Wrong email or password'], 401);
        }
        $user = Auth::user();
        $user->tokens()->delete();
        return response()->json([
            'user' => $user,
            'token' => $user->createToken("Token of {$user->name}")->plainTextToken
        ]);
    }
    public function logout(){
        Auth::user()->currentAccessToken()->delete();
        return response()->json([
            'message' => "Logged out successfully"
        ]);
    }
}
