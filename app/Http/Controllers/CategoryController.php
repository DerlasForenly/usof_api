<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\Post;
use App\Models\User;
use App\Models\CategoryPost;

class CategoryController extends Controller
{
    public function get_all()
    {
        try {
            $admin = auth()->userOrFail();
        }
        catch (\Tymon\JWTAuth\Exceptions\UserNotDefinedException $e) {
            return response([
                'message' => $e->getMessage()
            ], 401);
        }

        // if (User::where('login', $admin->login)->first()['role'] == 'user') {
        //     return response([
        //         'message' => 'Permission denied'
        //     ], 403);
        // }

        return Category::all();
    }

    public function create(Request $request)
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

        $request->validate([
            'title' => 'required|unique:categories,title',
            'description' => 'required',
        ]);

        return Category::create($request->all());
    }

    public function get_one($id)
    {
        try {
            $user = auth()->userOrFail();
        }
        catch (\Tymon\JWTAuth\Exceptions\UserNotDefinedException $e) {
            return response([
                'message' => $e->getMessage()
            ], 401);
        }

        $category = Category::find($id);
        if (!$category) {
            return response([
                'message' => "Not found"
            ], 404);
        }

        return $category;
    }

    public function update(Request $request, $id)
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

        $category = Category::find($id);
        if (!$category) {
            return response([
                'message' => "Not found"
            ], 404);
        }

        $category->update($request->all());

        return $category;

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

        $category = Category::find($id);
        if (!$category) {
            return response([
                'message' => "Not found"
            ], 404);
        }
        $category->delete();

        return response([
            'message' => "OK"
        ], 200);
    }

    public function get_all_posts($category_id)
    {
        try {
            $user = auth()->userOrFail();
        }
        catch (\Tymon\JWTAuth\Exceptions\UserNotDefinedException $e) {
            return response([
                'message' => $e->getMessage()
            ], 401);
        }

        $category = Category::find($category_id);
        if (!$category) {
            return response([
                'message' => "Not found"
            ], 404);
        }

        return CategoryPost::where('category_id', $category_id)->get();
    }
}
