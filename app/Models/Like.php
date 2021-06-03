<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Like extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'type',
        'post_id',
        'login'
    ];

    protected $casts = [
        'user_id' => 'integer',
        'post_id' => 'integer',
    ];
}
