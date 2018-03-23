<?php

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
*/

$api = app('Dingo\Api\Routing\Router');
$api->version('v1', function ($api) {

    /**
     * Welcome message.
     */
    $api->get('/', function () {
        return 'LaCMS API';
    });

    /**
     * Images.
     */
    $api->group([
        // 'middleware' => 'api:auth', // @todo
        'prefix' => 'images',
        'namespace' => 'App\Http\Controllers\Api\V1',
    ], function ($api) {
        $api->get('/', 'ImagesController@index');
        $api->post('/', 'ImagesController@store');
        $api->get('/{id}', 'ImagesController@show');
        $api->put('/{id}', 'ImagesController@update');
        $api->delete('/{id}', 'ImagesController@delete');
    });



    /**
     * Posts.
     */
    $api->group([
        // 'middleware' => 'foo',
        'prefix' => 'posts',
        'namespace' => 'App\Http\Controllers\Api\V1',
    ], function ($api) {
        $api->get('/', 'PostsController@index');
        $api->post('/', 'PostsController@store');
        $api->get('/{id}', 'PostsController@show');
        $api->put('/{id}', 'PostsController@update');
        $api->delete('/{id}', 'PostsController@delete');


        // images
        $api->get('/{id}/images', 'PostsController@images');
        $api->get('/{id}/author', 'PostsController@author');
    });

    /**
     * Authors
     */
    $api->group([
        // 'middleware' => 'foo',
        'prefix' => 'authors',
        'namespace' => 'App\Http\Controllers\Api\V1',
    ], function ($api) {
        $api->get('/', 'AuthorsController@index');
        $api->post('/', 'AuthorsController@store');
        $api->get('/{id}', 'AuthorsController@show');
        $api->put('/{id}', 'AuthorsController@update');
        $api->delete('/{id}', 'AuthorsController@delete');

        $api->get('/{id}/posts', 'AuthorsController@posts');
    });
});
