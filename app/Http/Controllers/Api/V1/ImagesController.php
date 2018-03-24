<?php

namespace App\Http\Controllers\Api\V1;

use Illuminate\Http\Request;

use App\Models\Post;
use App\Models\Author;
use App\Models\Image;

use Validator;

class ImagesController extends BaseController
{
    protected $model = \App\Models\Image::class;

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
            'name' => 'required|max:255',
            //
        ]);
    }
}
