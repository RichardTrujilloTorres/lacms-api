<?php

namespace App\Http\Controllers\Api\V1;

use Illuminate\Http\Request;

use App\Models\Post;
use App\Models\Author;
use App\Models\Image;

use Dingo\Api\Routing\Helpers;

use Validator;
use Illuminate\Support\Facades\Storage;

class ImagesController extends BaseController
{
    protected $model = \App\Models\Image::class;

    // @todo replace w/ cloud path (url shortener)
    protected $urlRootPath = '/api/images';

    /**
     * Download an image by slug.
     *
     * @return \Illuminate\Http\Response 
     */
    public function downloadBySlug($slug)
    {
        $image = Image::where('slug', $slug)->firstOrFail();

        return Storage::disk('local')->download($image->filename);
    }

    /**
     * Get an image by slug.
     *
     * @return \Illuminate\Http\Response 
     */
    public function getBySlug($slug)
    {
        $image = Image::where('slug', $slug)->firstOrFail();

        return $this->response->array([
            'status' => 'success',
            'message' => '',
            'data' => [
                'image' => $image,
            ],
        ]);
    }






    /**
     * Store a new image.
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

        if (! $this->requests->hasFile('file')) {
            return $this->response->array([
                'status' => 'error',
                'message' => 'Invalid request',
                'errors' => ['Invalid file.',],
            ]);
        }

        if (! $this->requests->file('file')->isValid()) {
            return $this->response->array([
                'status' => 'error',
                'message' => 'Invalid request',
                'errors' => ['Invalid file upload.',],
            ]);
        }

        $slug = uniqid().'_'.str_slug(explode('.', $this->requests->file->getClientOriginalName())[0]);
        $filename = $slug.'.'.$this->requests->file->extension();

        // move image
        $this->requests->file->move(
            storage_path('app'), 
            $filename
        );

        $image = Image::create([
            'slug' => $slug,
            'url' => $this->urlRootPath.'/'.$slug,
            'filename' => $filename,
            'post_id' => $this->requests->post_id,
        ]);

        return $this->response->array([
            'status' => 'success',
            'message' => 'Image saved.',
            'data' => [
                'image' => $image,
            ],
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
            'file' => 'required|file',
            'post_id' => 'required|exists:posts,id',
            //
        ]);
    }
}
