<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function index()
    {
        return User::all();
    }

    public function store(Request $request)
    {

        try {
            $user = auth()->userOrFail();
        }
        catch (\Tymon\JWTAuth\Exceptions\UserNotDefinedException $e) {
            return response([
                'message' => $e->getMessage()
            ], 401);
        }

        if (User::where('login', $user->login)->first()['role'] == 'user') {
            return response([
                'message' => 'Permission denied'
            ], 400);
        }

        $request->validate([
            'login' => 'required',
            'name' => 'required',
            'email' => 'required',
            'password' => 'required',
        ]);

        return User::create([
            'name' => $request['name'],
            'email' => $request['email'],
            'login' => $request['login'],
            'password' => Hash::make($request['password']),
            'api_token' => Str::random(60),
        ]);
    }

    public function show($id)
    {
        return User::find($id);
    }

    public function update(Request $request, $id)
    {
        $user = User::find($id);

        if (!$user) {
            return response([
                "user is not exist"
            ]);
        }

        $user['name'] = $request['name'];
        $user['login'] = $request['login'];
        $user['password'] = $request['password'];
        $user['email'] = $request['email'];
        $user['role'] = $request['role'];


        $user->save();

        return $user;
    }

    public function destroy($id)
    {
        try {
            $admin = auth()->userOrFail();
        }
        catch (\Tymon\JWTAuth\Exceptions\UserNotDefinedException $e) {
            return response([
                'message' => $e->getMessage()
            ], 401);
        }

        if (User::where('login', $admin->login)->first()['role'] == 'user') {
            return response([
                'message' => 'Permission denied'
            ], 400);
        }


        $user = User::find($id);
        if (!$user) {
            return response([
                'message' => "user is not exist"
            ]);
        }
        $user->delete();

        return response([
            'message' => "user deleted"
        ]);
    }

    public function upload_avatar(Request $request)
    {
        try {
            $user = auth()->userOrFail();
        }
        catch (\Tymon\JWTAuth\Exceptions\UserNotDefinedException $e) {
            return response([
                'message' => $e->getMessage()
            ], 401);
        }

        if (!$request->file('avatar')) {
            return response([
                "message" => "avatar is not uploaded"
            ]);
        }

        return response([
            "message" => "avatar uploaded"
        ]);
    }
}
