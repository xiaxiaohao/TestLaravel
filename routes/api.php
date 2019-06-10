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


Route::get('view',['uses'=>'Api\V1\CategoryController@manageCategory']);
Route::post('add-category',['as'=>'add.category','uses'=>'Api\V1\CategoryController@addCategory']);

//dingo路由
$api = app('Dingo\Api\Routing\Router');

$api->version('v1', ['namespace' => 'App\Http\Controllers\Api\V1'], function ($api) {

    $api->get('testapi', 'UserController@FindAll');

    $api->get('testapi/{id}', 'UserController@FindOne');


    $api->get('delete','UserController@DeleteOne');

    $api->post('update','UserController@UpdateOne');



    $api->get('list', 'TagController@FindAll');

    $api->get('find/{id}', 'TagController@FindOne');

    $api->post('updatetag','TagController@UpdateOne');

    $api->post('del','TagController@DeleteOne');



});






