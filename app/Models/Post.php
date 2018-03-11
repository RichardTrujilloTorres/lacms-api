<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

use App\Models\Author;

class Post extends Model 
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'title', 'body', 'author_id',
    ];

    public function author()
    {
        return $this->hasOne(Author::class, 'id', 'author_id');
    }
}
