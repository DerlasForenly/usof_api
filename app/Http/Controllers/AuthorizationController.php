<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;
use Tymon\JWTAuth\Facades\JWTAuth;

class AuthorizationController extends Controller
{
    public function login(Request $request)
    {
        $credentials = [
            'email' => $request['email'],
            'password' => $request['password']
        ];

        if (! $token = auth()->attempt($credentials)) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        return $this->respondWithToken($token);
    }

    public function registration(Request $request)
    {
        User::create([
            'name' => $request['name'],
            'email' => $request['email'],
            'login' => $request['login'],
            'password' => Hash::make($request['password']),
        ]);

        return response([
            'message' => "OK"
        ], 200);
    }

    public function me()
    {
        return response()->json(auth()->user());
    }

    public function logout()
    {
        auth()->logout();

        return response()->json(['message' => 'Successfully logged out'], 200);
    }

    public function refresh()
    {
        return $this->respondWithToken(auth()->refresh());
    }

    protected function respondWithToken($token)
    {
        return response()->json([
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => auth()->factory()->getTTL() * 60
        ]);
    }

    public function password_reset(Request $request)
    {
        $user = User::where('email', $request['email'])->get()->first();
        if (!$user) {
            return response([
                'message' => "Not found"
            ], 404);
        }

        $request->validate([
            'email' => 'required'
        ]);

        $user->update([
            'remember_token' => Str::random(15)
        ]);

        mail(
            $user['email'],
            'Password reset',
            'Use this token to reset password: ' . $user['remember_token']
        );

        return response([
            'message' => 'OK'
        ], 200);
    }

    public function token(Request $request, $token)
    {
        $user = User::where('remember_token', $token)->get()->first();
        if (!$user) {
            return response([
                'message' => 'Not found'
            ], 404);
        }

        if ($user['remember_token'] != $token) {
            return response([
                'message' => 'Permission denied'
            ], 403);
        }

        $request->validate([
            'password' => 'required'
        ]);

        $user->update([
            'remebmer_token' => null,
            'password' => Hash::make($request['password'])
        ]);

        return response([
            'message' => 'OK'
        ], 200);
    }
}
