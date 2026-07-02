<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    protected $fillable = [

        'user_id',

        'category_id',

        'isi',

        'gambar',

        'video'

    ];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function reactions()
    {
        return $this->hasMany(Reaction::class);
    }

    public function comments()
    {
        return $this->hasMany(Comment::class);
    }
}