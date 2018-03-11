<?php

namespace App\Http\Controllers\Api\V1;

use Illuminate\Http\Request;

use App\Models\Post;
use App\Models\Author;

use Validator;

class PostsController extends BaseController
{
    protected $model = \App\Models\Post::class;


    /**
     * Get post by ID.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id) 
    {
        $post = Post::with('author')->findOrFail($id);

        return $this->response->array($post->toArray());
    }

    /**
     * Get store validator.
     * 
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Validation\Validator
     */
    protected function validator(Request $request)
    {
        return Validator::make($request->all(), [
            'author_id' => 'required|integer|exists:authors,id',
            'title' => 'required|unique:posts|max:255',
        ]);
    }
}
