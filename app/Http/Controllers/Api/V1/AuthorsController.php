<?php

namespace App\Http\Controllers\Api\V1;

use Illuminate\Http\Request;

use App\Models\Post;
use App\Models\Author;

use Validator;

class AuthorsController extends BaseController
{
    protected $model = \App\Models\Author::class;


    /**
     * Get author by ID w/ its posts.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function posts($id) 
    {
        $author = Author::with('posts')->findOrFail($id);

        return $author;
    }

    protected function validator(Request $request)
    {
        return Validator::make($request->all(), [
            'author_id' => 'required|integer|exists:authors,id',
            'title' => 'required|unique:posts|max:255',
        ]);
    }
}
