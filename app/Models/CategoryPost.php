<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CategoryPost extends Model
{
    use HasFactory;

    protected $fillable = [
        'post_id',
        'category_id',
    ];

    protected $casts = [
        'post_id' => 'integer',
        'category_id' => 'integer'
    ];
}
