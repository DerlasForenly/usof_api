<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use App\Models\Like;
use App\Models\Post;
use Illuminate\Http\Request;

class CommentController extends Controller
{
    public function get($id)
    {
        try {
            $user = auth()->userOrFail();
        }
        catch (\Tymon\JWTAuth\Exceptions\UserNotDefinedException $e) {
            return response([
                'message' => $e->getMessage()
            ], 401);
        }

        return Comment::find($id);
    }

    public function get_likes($id)
    {
        try {
            $user = auth()->userOrFail();
        }
        catch (\Tymon\JWTAuth\Exceptions\UserNotDefinedException $e) {
            return response([
                'message' => $e->getMessage()
            ], 401);
        }

        return Like::where('post_id', $id)->get();
    }

    public function create_like(Request $request, $id)
    {
        try {
            $user = auth()->userOrFail();
        }
        catch (\Tymon\JWTAuth\Exceptions\UserNotDefinedException $e) {
            return response([
                'message' => $e->getMessage()
            ], 401);
        }

        $comment = Comment::find($id);
        if (!$comment) {
            return response([
                'message' => 'Post does not exist'
            ]);
        }

        if (Like::where('comment_id', $comment->id)->where('user_id', $user->id)->get()->first()) {
            return response([
                'message' => 'Something went wrong'
            ], 401);
        }

        Like::create([
            'like' => $request['like'],
            'comment_id' => $comment->id,
            'user_id' => $user->id
        ]);

        return response([
            'message' => "OK"
        ], 200);
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

        $comment = Comment::find($id);
        if (!$comment) {
            return response([
                'message' => 'Not found'
            ], 404);
        }

        if ($comment->user_id != $user->id) {
            return response([
                'message' => 'Permission denied'
            ], 403);
        }

        $comment->update($request->all());

        return $comment;
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

        $comment = Comment::find($id);
        if (!$comment) {
            return response([
                'message' => "Not found"
            ], 404);
        }

        if ($user->id != $comment->user_id) {
            return response([
                'message' => "Permission denied"
            ], 403);
        }

        $comment->delete();

        return response([
            'message' => "OK"
        ], 200);
    }

    public function delete_like($id)
    {
        try {
            $user = auth()->userOrFail();
        }
        catch (\Tymon\JWTAuth\Exceptions\UserNotDefinedException $e) {
            return response([
                'message' => $e->getMessage()
            ], 401);
        }

        $like = Like::where('post_id', $id)->delete();

        return response([
            'message' => "like deleted"
        ]);
    }
}
