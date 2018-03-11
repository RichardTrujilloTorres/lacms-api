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
     * Posts
     */
    $api->group([
        // 'middleware' => 'foo',
        'prefix' => 'posts',
        'namespace' => 'App\Http\Controllers\Api\V1',
    ], function ($api) {

        $api->get('/', 'PostsController@index');
        $api->get('/{id}', 'PostsController@show');
        $api->post('/', 'PostsController@store');
    });
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
        $api->get('/{id}', 'AuthorsController@show');
        /*
        $api->post('/', 'AuthorsController@store');
         */

        $api->get('/{id}/posts', 'AuthorsController@posts');
    });
});




