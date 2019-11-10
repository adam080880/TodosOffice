<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

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

    public function register(Request $req)
    {        
        $validated = Validator::make($req->all(), [
            'email' => 'required|unique:users|min:8|max:190|email',
            'name' => 'required|min:5|max:190',
            'password' => 'min:8|required'
        ]);  

        if($validated->fails()) {
            return response()->json([
                'data' => $req->all(),
                'errors' => $validated->errors(),
                'status' => false
            ], 400);
        }

        $user = new User;
        $user->name = $req->name;
        $user->password = Hash::make($req->password);
        $user->email = $req->email;
        $user->role_id = 2;
        
        if($user->save()) {
            return response()->json([
                'data' => $user,
                'errors' => [],
                'status' => true
            ], 200);
        } else {
            return response()->json([
                'data' => $user,
                'errors' => [
                    'main' => 'Error Internal Server'
                ],
                'status' => false
            ], 500);
        }
    }

    public function me()
    {
        return response()->json($this->guard()->user());
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
