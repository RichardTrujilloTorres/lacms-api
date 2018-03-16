<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It is a breeze. Simply tell Lumen the URIs it should respond to
| and give it the Closure to call when that URI is requested.
|
*/

$router->get('/', function () use ($router) {
    return $router->app->version();
});


$api = app('Dingo\Api\Routing\Router');
$api->version('v1', function ($api) {


    /**
     * Images
     */
    $api->group([
        // 'middleware' => 'foo',
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
     * Posts
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
