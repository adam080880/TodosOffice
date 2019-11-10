<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use App\User;

class AuthControllerJWT extends Controller
{
    public function __construct()
    {
        
    }

    public function login(Request $req)
    {
        $credentials = $req->only(['email', 'password']);

        if($token = $this->guard()->attempt($credentials)) {
            return $this->getResponseToken($token);
        }
    }

    public function register()
    {

    }

    public function me()
    {
        return reponse()->json($this->guard())->user();
    }

    public function logout()
    {
        $this->guard()->logout();

        return response()->json([
            'message' => 'Logout Success'
        ]);
    }

    public function refresh()
    {
        return $this->getResponseToken($this->guard()->refresh());
    }

    public function getResponseToken($token)
    {
        return response()->json([
            'token' => $token,
            'token_type' => 'bearer',
            'expires_in' => $this->guard()->factory()->getTTL() * 60
        ]);
    }

    public function guard()
    {
        return Auth::guard();
    }
}
