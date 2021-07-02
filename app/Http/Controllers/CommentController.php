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
        // try {
        //     $user = auth()->userOrFail();
        // }
        // catch (\Tymon\JWTAuth\Exceptions\UserNotDefinedException $e) {
        //     return response([
        //         'message' => $e->getMessage()
        //     ], 401);
        // }

        $comment = Comment::find($id);
        if (!$comment) {
            return response([
                'message' => "Not found"
            ], 404);
        }

        $rating = 0;
        $likes = Like::where('comment_id', $id)->get();
        foreach ($likes as &$like) {
            $rating += $like->like;
            $rating -= $like->dislike;
        }
        $comment->update([
            'likes' => $rating
        ]);

        return $comment;
    }

    public function get_likes($id)
    {
        // try {
        //     $user = auth()->userOrFail();
        // }
        // catch (\Tymon\JWTAuth\Exceptions\UserNotDefinedException $e) {
        //     return response([
        //         'message' => $e->getMessage()
        //     ], 401);
        // }

        $like = Like::where('comment_id', $id)->get();
        if (!$like) {
            return response([
                'message' => 'Not found'
            ], 404);
        }

        return $like;
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
                'message' => 'Not found'
            ], 404);
        }

        $like = Like::where('comment_id', $comment->id)->where('user_id', $user->id)->get()->first();
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

        // if ($request['like'] == 1 && $request['dislike'] == 1) {
        //     return response([
        //         'message' => 'Something went wrong'
        //     ], 401);
        // }

        Like::create([
            'like' => $request['like'],
            'dislike' => $request['dislike'],
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

        if ($user->role != "admin" && $user->id != $comment->user_id)
        {
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

        $like = Like::where('comment_id', $id)->where('user_id', $user->id)->get()->first();
        if (!$like) {
            return response([
                'message' => "Not found"
            ], 404);
        }
        $like->delete();

        return response([
            'message' => "OK"
        ], 200);
    }
}
