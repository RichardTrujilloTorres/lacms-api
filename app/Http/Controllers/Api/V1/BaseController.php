<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use Dingo\Api\Routing\Helpers;

use Validator;

class BaseController extends Controller
{
    use Helpers;

    protected $model;

    protected $requests;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(Request $request)
    {
        $this->requests = $request;
    }

    /**
     * Yield resource listing.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $resource = $this->model::all();

        return $this->response->array($resource->toArray());
    }

    /**
     * Yield ID specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id) 
    {
        $resource = $this->model::findOrFail($id);

        return $this->response->array($resource->toArray());
    }

    /**
     * Create a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function store() 
    {
        $validator = Validator::make($this->requests->toArray(), [
            'author_id' => 'required|integer|exists:authors',
            'title' => 'required|unique:posts|max:255',
            'title' => 'required',
        ]);

        if ($validator->fails()) {
            throw new \Dingo\Api\Exception\StoreResourceFailedException(
                'Could not create new resource.', 
                $validator->errors()
            );
        }

        $resource = $this->model::create($this->requests->toArray());

        return $this->response->array($resource->toArray());
    }
        

}
