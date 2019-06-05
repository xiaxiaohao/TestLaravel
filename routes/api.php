<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});





$api = app('Dingo\Api\Routing\Router');

$api->version('v1', function ($api) {

});

$api->version(['v1', 'v2'], function ($api) {

});

$api->version('v1', ['middleware' => 'foo'], function ($api) {

});

$api->version('v1', function ($api) {
    $api->get('users/{id}', 'App\Api\Controllers\UserController@show');
});

$api->version('v1', function ($api) {
    $api->get('users/{id}', 'App\Api\V1\Controllers\UserController@show');
});

$api->version('v2', function ($api) {
    $api->get('users/{id}', 'App\Api\V2\Controllers\UserController@show');
});

$api->get('users/{id}', ['as' => 'users.index', 'uses' => 'Api\V1\UserController@show']);

app('Dingo\Api\Routing\UrlGenerator')->version('v1')->route('users.index');