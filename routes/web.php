<?php

/** @var \Laravel\Lumen\Routing\Router $router */

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

$router->group(['prefix' => 'api'], function () use ($router) {
    $router->post('register', 'AuthController@register');
    $router->post('login', 'AuthController@login');
    $router->get('logout', ['middleware' => 'auth', 'uses' => 'AuthController@logout']);
    $router->group(['prefix' => 'posts'], function () use ($router) {
        $router->get('', 'PostController@list');
        $router->get('{id:[0-9]+}', 'PostController@get');
        $router->group(['middleware' => 'auth'], function () use ($router) {
            $router->post('', 'PostController@create');
            $router->put('{id:[0-9]+}', 'PostController@edit');
            $router->delete('{id:[0-9]+}', 'PostController@delete');
            $router->post('{id:[0-9]+}/like', 'PostController@like');
            $router->delete('{id:[0-9]+}/like', 'PostController@unlike');
            $router->get('{id:[0-9]+}/react', 'PostUserReactionController@react');
            $router->post('{id:[0-9]+}/images', 'ImageController@create');
            $router->get('{id:[0-9]+}/images', 'ImageController@list');
        });
        $router->get('{id:[0-9]+}/comments', 'PostCommentController@list');
    });
        $router->group(['prefix' => 'comments', 'middleware' => 'auth'], function () use ($router) {
        $router->post('', 'PostCommentController@create');
        $router->delete('{id:[0-9]+}', 'PostCommentController@delete');
    });
    $router->group(['prefix' => 'complains', 'middleware' => 'auth'], function () use ($router) {
        $router->post('', 'PostCommentComplainController@create');
        $router->get('', 'PostCommentComplainController@list');
        $router->post('{id:[0-9]+}/process', 'PostCommentComplainController@process');
    });
    $router->group(['prefix' => 'user', 'middleware' => 'auth'], function () use ($router) {
        $router->get('favourites', 'UserController@favourites');
    });
    $router->group(['prefix' => 'categories'], function () use ($router) {
        $router->get('', 'CategoryController@list');
        $router->get('{id:[0-9]+}', 'CategoryController@get');
        $router->group(['middleware' => 'auth'], function () use ($router) {
            $router->post('', 'CategoryController@create');
            $router->put('{id:[0-9]+}', 'CategoryController@edit');
            $router->delete('{id:[0-9]+}', 'CategoryController@delete');
        });
    });
});
