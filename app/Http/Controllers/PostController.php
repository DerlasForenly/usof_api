<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\Comment;
use App\Models\Like;
use App\Models\User;
use App\Models\Category;
use App\Models\CategoryPost;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;

class PostController extends Controller
{
    public function index()
    {
        return Post::paginate(3);
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

        //sort($request['categories'], SORT_NUMERIC);

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
        // try {
        //     $user = auth()->userOrFail();
        // }
        // catch (\Tymon\JWTAuth\Exceptions\UserNotDefinedException $e) {
        //     return response([
        //         'message' => $e->getMessage()
        //     ], 401);
        // }

        $post = Post::find($id);

        if (!$post) {
            return response([
                'message' => "Not found"
            ], 404);
        }

        $post = [
            'id' => $post->id,
            'title' => $post->title,
            'content' => $post->content,
            'categories' => $post->categories,
            'likes' => 0,
            'status' => $post->status,
            'created_at' => $post->created_at,
            'updated_at' => $post->updated_at,
            'user_id' => $post->user_id,
            'login' => User::find($post->user_id)->login,
        ];

        foreach (Like::where('post_id', $post['id'])->get() as $like) {
            $post['likes'] += $like['like'];
            $post['likes'] -= $like['dislike'];
        }

        return $post;
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
        if (!$post) {
            return response([
                'message' => 'Not found'
            ], 404);
        }

        if (User::where('login', $user->login)->first()['role'] == 'admin') {
            $post->update($request->all());
        }
        else {
            if ($user->id != $post['user_id']) {
                return response([
                    'message' => 'Permission denied'
                ], 403);
            }
            $post->update($request->all());
        }

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
        if ($user->role != "admin") {
            if ($user->id != $post['user_id']) {
                return response([
                    'message' => 'Permission denied'
                ], 403);
            }
        }

        Post::destroy($id); 

        return response([
            'user' => $user->login,
            'role' => $user->role,
            'post_id' => $id,
            'description' => 'Post has beed'
        ], 200);
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

        if (strlen($request['content']) >= 255) {
            return response([
                'message' => 'Content too long'
            ], 400);
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
        // try {
        //     $user = auth()->userOrFail();
        // }
        // catch (\Tymon\JWTAuth\Exceptions\UserNotDefinedException $e) {
        //     return response([
        //         'message' => $e->getMessage()
        //     ], 401);
        // }

        if (!Post::find($id)) {
            return response([
                'message' => "Not found"
            ], 404);
        }

        $comments = Comment::where('post_id', $id)->get();
        $new_comments = [];

        foreach ($comments as &$comment) {
            $likes = Like::where('comment_id', $comment->id)->get();
            $rating = 0;
            foreach ($likes as &$like) {
                $rating += $like->like;
                $rating -= $like->dislike;
            }
            $comment->update([
                'likes' => $rating
            ]);
            array_push($new_comments, [
                'id' => $comment->id,
                'post_id' => $comment->post_id,
                'user_id' => $comment->user_id,
                'login' => User::find($comment->user_id)->login,
                'content' => $comment->content,
                'likes' => $comment->likes,
                'created_at' => $comment->created_at,
                'updated_at' => $comment->updated_at,
            ]);
        }

        return $new_comments;
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

        $like = Like::where('post_id', $post_id)->where('user_id', $user->id)->get()->first();
        if ($like) {
            if ($request['like'] === $like['like'] && $request['dislike'] === $like['dislike'])
                return response([
                    'message' => 'Something went wrong'
                ], 401);
            else {
                $like->update([
                    'like' => $request['like'],
                    'dislike' => $request['dislike'],
                ]);
                return response([
                    'message' => 'OK'
                ], 200);
            }
        }

        if ($request['like'] > 1 || $request['dislike'] > 1) {
            return response([
                'message' => 'Something went wrong'
            ], 401);
        }

        Like::create([
            'like' => $request->like,
            'dislike' => $request->dislike,
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
        // try {
        //     $user = auth()->userOrFail();
        // }
        // catch (\Tymon\JWTAuth\Exceptions\UserNotDefinedException $e) {
        //     return response([
        //         'message' => $e->getMessage()
        //     ], 401);
        // }

        if (!Post::find($post_id)) {
            return response([
                'message' => 'Not found'
            ], 404);
        }

        return response(Like::where('post_id', $post_id)->get(), 200);
    }

    public function get_categories($post_id)
    {
        if (!Post::find($post_id)) {
            return response([
                'message' => 'Not found'
            ], 404);
        }

        $category_post = CategoryPost::where('post_id', $post_id)->get();

        $categories = [];
        foreach ($category_post as $element) {
            array_push($categories, Category::find($element->category_id));
        }

        return $categories;
    }
}
