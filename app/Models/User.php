<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [

        'nim',
        'nama',
        'password',
        'role'

    ];

    protected $hidden = [

        'password',
        'remember_token'

    ];

    protected function casts(): array
    {
        return [

            'password' => 'hashed',

        ];
    }

    public function posts()
    {
        return $this->hasMany(Post::class);
    }
}