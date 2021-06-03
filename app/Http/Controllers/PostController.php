<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\Comment;
use App\Models\Comment;
use Illuminate\Http\Request;

class PostController extends Controller
{
    public function index()
    {
        return Post::all();
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

        $request->validate([
            'title' => 'required',
            'content' => 'required',
            'tags' => 'required',
            'slug' => 'required'
        ]);

        return Post::create([
            'user_id' => $user->id,
            'title' => $request['title'],
            'slug' => $request['slug'],
            'content' => $request['content'],
            'tags' => $request['tags'],
        ]);
    }

    public function show($id)
    {
        return Post::find($id);
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

        $post = Post::find($id);
        if ($user->id != $post['user_id']) {
            return response([
                'message' => 'Permission denied'
            ]);
        }

        $post->update($request->all());
        return $post;
    }

    public function destroy($id)
    {
        try {
            $user = auth()->userOrFail();
        }
        catch (\Tymon\JWTAuth\Exceptions\UserNotDefinedException $e) {
            return response([
                'message' => $e->getMessage()
            ], 401);
        }

        $post = Post::find($id);
        if ($user->id != $post['user_id'] || $user->role != "admin") {
            return response([
                'message' => 'Permission denied'
            ]);
        }

        return Post::destroy($id);
    }

    public function create_comment(Request $request, $id)
    {
        try {
            $user = auth()->userOrFail();
        }
        catch (\Tymon\JWTAuth\Exceptions\UserNotDefinedException $e) {
            return response([
                'message' => $e->getMessage()
            ], 401);
        }

        return Comment::create([
            'login' => $user['login'],
            'user_id' => $user->id,
            'post_id' => $id,
            'content' => $request['content'],
        ]);
    }

    public function get_all_comments($id)
    {
        return Comment::where('post_id', $id)->get();
    }

    public function create_like(Request $request)
    {

    }
}
