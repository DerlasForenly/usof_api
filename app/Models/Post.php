<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'content',
        'likes',
        'user_id',
        'categories',
        'status'
    ];

    protected $casts = [
        'title' => 'string',
        'content' => 'string',
        'likes' => 'integer',
        'user_id' => 'integer',
        'categories' => 'array',
        'status' => 'string'
    ];
}
