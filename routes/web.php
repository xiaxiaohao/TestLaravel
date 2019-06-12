<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::get('category',['uses'=>'Api\V1\CategoryController@manageCategory']);
Route::post('add-category',['as'=>'add.category','uses'=>'Api\V1\CategoryController@addCategory']);

Route::get('view',['uses'=>'Api\V1\CategoryController@manageCategory']);
Route::post('add-tag',['as'=>'add-tag','uses'=>'Api\V1\TagController@UpdateOne']);

Route::get('list',['uses'=>'Api\V1\TagController@findAll']);