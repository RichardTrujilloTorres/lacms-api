<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Image extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'url', 'slug', 'post_id',
    ];

    public function posts()
    {
        return $this->belongsTo(Post::class);
    }


    // @todo
    // slug generator
    // url generator (could use the URL shortener API)
}
