<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\Comment;
use App\Models\Like;
use App\Models\Category;
use App\Models\CategoryPost;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;

class PostController extends Controller
{
    public function index()
    {
        try {
            $user = auth()->userOrFail();
        }
        catch (\Tymon\JWTAuth\Exceptions\UserNotDefinedException $e) {
            return response([
                'message' => $e->getMessage()
            ], 401);
        }

        if (!Post::all()) {
            return response([
                'message' => "Not found"
            ], 404);
        }

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
            'categories' => 'required|array'
        ]);

        foreach($request['categories'] as $category_id) {
            $category = Category::find($category_id);
            if (!$category) {
                return response([
                    'message' => "Not found"
                ], 404);
            }
        }

        $post = Post::create([
            'user_id' => $user->id,
            'title' => $request['title'],
            'content' => $request['content'],
            'categories' => $request['categories'],
        ]);

        foreach($request['categories'] as $category_id) {
            CategoryPost::create([
                'post_id' => $post->id,
                'category_id' => $category_id
            ]);
        }

        return $post;
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

        if (!Post::find($id)) {
            return response([
                'message' => "Not found"
            ], 404);
        }

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

        if (!Post::find($id)) {
            return response([
                'message' => "Not found"
            ], 404);
        }

        Comment::create([
            'login' => $user['login'],
            'user_id' => $user['id'],
            'post_id' => $id,
            'content' => $request['content'],
        ]);

        return response([
            'message' => "OK"
        ], 200);
    }

    public function get_all_comments($id)
    {
        try {
            $user = auth()->userOrFail();
        }
        catch (\Tymon\JWTAuth\Exceptions\UserNotDefinedException $e) {
            return response([
                'message' => $e->getMessage()
            ], 401);
        }

        if (!Post::find($id)) {
            return response([
                'message' => "Not found"
            ], 404);
        }

        return Comment::where('post_id', $id)->get();
    }

    public function create_like(Request $request, $post_id)
    {
        try {
            $user = auth()->userOrFail();
        }
        catch (\Tymon\JWTAuth\Exceptions\UserNotDefinedException $e) {
            return response([
                'message' => $e->getMessage()
            ], 401);
        }

        if (!Post::find($post_id)) {
            return response([
                'message' => 'Not found'
            ], 404);
        }

        if (Like::where('post_id', $post_id)->where('user_id', $user->id)->get()->first()) {
            return response([
                'message' => 'Something went wrong'
            ], 401);
        }

        Like::create([
            'like' => $request->like,
            'user_id' => $user->id,
            'post_id' => $post_id
        ]);

        return response([
            'message' => 'OK'
        ], 200);
    }

    public function delete_like(Request $request, $post_id)
    {
        try {
            $user = auth()->userOrFail();
        }
        catch (\Tymon\JWTAuth\Exceptions\UserNotDefinedException $e) {
            return response([
                'message' => $e->getMessage()
            ], 401);
        }

        if (!Post::find($post_id)) {
            return response([
                'message' => 'Not found'
            ], 404);
        }

        $like = Like::where('post_id', $post_id)->where('user_id', $user->id)->get()->first();
        if (!$like) {
            return response([
                'message' => 'Not found'
            ], 404);
        }
        $like->delete();

        return response([
            'message' => 'OK'
        ], 200);
    }

    public function get_all_likes($post_id)
    {
        try {
            $user = auth()->userOrFail();
        }
        catch (\Tymon\JWTAuth\Exceptions\UserNotDefinedException $e) {
            return response([
                'message' => $e->getMessage()
            ], 401);
        }

        if (!Post::find($post_id)) {
            return response([
                'message' => 'Not found'
            ], 404);
        }

        return Like::where('post_id', $post_id)->get();
    }

    public function get_categories($post_id)
    {
        try {
            $user = auth()->userOrFail();
        }
        catch (\Tymon\JWTAuth\Exceptions\UserNotDefinedException $e) {
            return response([
                'message' => $e->getMessage()
            ], 401);
        }

        if (!Post::find($post_id)) {
            return response([
                'message' => 'Not found'
            ], 404);
        }

        $category_post = CategoryPost::where('post_id', $post_id)->get();

        $categories = [];
        foreach ($category_post as $element) {
            array_push($categories, Category::find($element->id));
        }

        return $categories;
    }
}
