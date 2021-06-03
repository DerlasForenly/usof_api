<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'slug',
        'content',
        'likes',
        'dislikes',
        'user_id',
        'tags',
        'status'
    ];

    protected $casts = [
        'likes' => 'integer',
        'dislikes' => 'integer',
    ];
}
