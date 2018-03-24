<?php

namespace App\Http\Controllers\Api\V1;

use Illuminate\Http\Request;

use App\Models\Post;
use App\Models\Author;

use Validator;

use Illuminate\Support\Facades\Redis;

class PostsController extends BaseController
{
    protected $model = \App\Models\Post::class;


    /**
     * Post listing.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $posts = Redis::get('posts');
        if (! $posts) {
            $posts = Post::with('author')->all();
        }

        return $this->response->array([
            'status' => 'success',
            'message' => '',
            'data' => [
                'posts' => $posts,
            ],
        ]);
    }

    /**
     * Get post by ID.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $post = Redis::get('posts:'.$id);
        if (! $post) {
            $post = Post::with('author')->findOrFail($id);
        }

        return $this->response->array([
            'status' => 'success',
            'message' => '',
            'data' => [
                'post' => $post,
            ],
        ]);
    }


    /**
     * Save a new post.
     *
     * @return \Illuminate\Http\Response
     */
    public function store()
    {
        $validator = $this->validator($this->requests);
        if ($validator->fails()) {
            throw new \Dingo\Api\Exception\StoreResourceFailedException(
                'Could not create new resource.',
                $validator->errors()
            );
        }

        $post = $this->model::with('author')->create($this->requests->toArray());

        // cache it
        Redis::set('posts:'.$post->id, $post);
        Redis::set('posts:authors:'.$post->id, $post->author);
        Redis::append('posts', $post);
        Redis::append('posts:authors', $post->author);

        return $this->response->array($post);
    }


    /**
     * Get post author.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function author($id)
    {
        $author = Redis::get('posts:authors:'.$id);
        if (! $author) {
            $author = Post::findOrFail($id)->author;
        }

        return $this->response->array($author);
    }


    /**
     * Get post images.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function images($id)
    {
        $images = Redis::get('posts:images:'.$id);
        if (! $images) {
            $images = Post::findOrFail($id)->images;
        }

        $images = Post::with('images')->findOrFail($id)->images;

        return $this->response->array($images);
    }

    /**
     * Delete a post.
     *
     * @return \Illuminate\Http\Response
     */
    public function delete($id)
    {
        $post = $this->model::findOrFail($id);
        $post->delete();

        // remove cache
        Redis::del('posts:'.$id);
        Redis::del('posts:authors:'.$id);
        Redis::del('posts:images:'.$id);

        return $this->response->array([
            'status' => 'success',
            'message' => 'Resource deleted.',
        ]);
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
