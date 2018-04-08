<?php

namespace App\Http\Controllers\Api\V1;

use Illuminate\Http\Request;

use Validator;

class UsersController extends BaseController
{
    protected $model = \App\Models\User::class;

    /**
     * Get user by slug.
     *
     * @param string $slug
     * @return \Illuminate\Http\Response
     */
    public function getBySlug($slug)
    {
        $user = $this->model::where('slug', $slug)->firstOrFail();

        return $this->response->array([
            'status' => 'success',
            'message' => '',
            'data' => [
                'user' => $user,
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
            'email' => 'required|unique:users',
            'name' => 'required|alpha|max:255',
            'password' => 'required|alpha_num|max:255|confirmed',
        ]);
    }
}
