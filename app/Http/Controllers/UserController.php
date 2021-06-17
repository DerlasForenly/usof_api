<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Post;
use App\Models\Comment;
use App\Models\Like;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function index()
    {
        // try {
        //     $user = auth()->userOrFail();
        // }
        // catch (\Tymon\JWTAuth\Exceptions\UserNotDefinedException $e) {
        //     return response([
        //         'message' => $e->getMessage()
        //     ], 401);
        // }

        if (User::where('login', $user->login)->first()['role'] == 'user') {
            return response([
                'message' => 'Permission denied'
            ], 403);
        }

        $users = User::all();

        foreach ($users as $user) {
            $rating = 0;
            $posts = Post::where('user_id', $user->id)->get();
            foreach ($posts as $post) {
                $rating += $post['like'];
            }
            $comments = Comment::where('user_id', $user->id)->get();
            foreach ($comments as $comment) {
                $rating += $comment['like'];
            }
            $user->update([
                'rating' => $rating
            ]);
        }

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
            ], 403);
        }

        $request->validate([
            'login' => 'required',
            'name' => 'required',
            'email' => 'required',
            'password' => 'required',
        ]);

        User::create([
            'name' => $request['name'],
            'email' => $request['email'],
            'login' => $request['login'],
            'password' => Hash::make($request['password']),
            'api_token' => Str::random(60),
        ]);

        return response([
            'message' => 'OK'
        ], 200);
    }

    public function show($id)
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
            ], 403);
        }

        $user = User::find($id);
        if (!$user) {
            return response([
                'message' => "Not found"
            ], 404);
        }

        $rating = 0;
        $posts = Post::where('user_id', $user->id)->get();
        foreach ($posts as $post) {
            $rating += $post['like'];
        }
        $comments = Comment::where('user_id', $user->id)->get();
        foreach ($comments as $comment) {
            $rating += $comment['like'];
        }
        $user->update([
            'rating' => $rating
        ]);

        return $user;
    }

    public function update(Request $request, $id)
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
            ], 403);
        }

        $user = User::find($id);
        if (!$user) {
            return response([
                'message' => "Not found"
            ], 404);
        }

        $request->validate([
            'login' => 'required',
            'name' => 'required',
            'email' => 'required',
            'password' => 'required',
            'role' => 'required'
        ]);

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
            ], 403);
        }

        $user = User::find($id);
        if (!$user) {
            return response([
                'message' => "Not found"
            ], 404);
        }
        $user->delete();

        return response([
            'message' => "OK"
        ], 200);
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

        if (!$request->file('picture')) {
            return response([
                "message" => "avatar is not uploaded"
            ]);
        }

        User::find($user->id)->update([
            'picture' => $image = explode(
                '/',
                $request->file('picture')->storeAs(
                    'avatars',
                    $user->login . '.' . $request->file('picture')->getClientOriginalExtension(),
                    'public'
                )
            )[1]
        ]);
        User::find($user->id)->update([
            'picture' => $user->login . '.' . $request->file('picture')->getClientOriginalExtension()
        ]);


        return response([
            "message" => "OK",
            "image" => $image
        ], 200);
    }

    public function download_avatar($id)
    {
        try {
            $user = auth()->userOrFail();
        }
        catch (\Tymon\JWTAuth\Exceptions\UserNotDefinedException $e) {
            return response([
                'message' => $e->getMessage()
            ], 401);
        }

        $user_ = User::find($id);
        if (!$user_) {
            return response([
                'message' => 'Not found'
            ], 404);
        }

        $filepath = storage_path('app/public/avatars/').$user_->picture;
        $headers = [];

        return response()->download($filepath, $user_->picture, $headers);
    }
}
