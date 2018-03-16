<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Author extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'first_name', 'last_name', 'about',
    ];

    public function posts()
    {
        return $this->hasMany(Post::class, 'author_id');
    }
}
