<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    use HasFactory;

    protected $fillable = [
        'login',
        'user_id',
        'post_id',
        'content',
        'likes',
        'dislikes'
    ];

    protected $casts = [
        'user_id' => 'integer',
        'post_id' => 'integer',
        'likes' => 'integer',
        'dislikes' => 'integer',
    ];
}
