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

//Route::middleware('auth:api')->get('/user', function (Request $request) {
//    return $request->user();
//});

Route::group(['middleware'=>'cors'], function(){
    Route::post('register','UserController@registerUser');
    Route::post('login','UserController@authenticate');
    Route::group(['middleware'=> 'jwt.auth'],function (){
        Route::get('todo/sorted','ToDoListController@getDataSorted');
        Route::get('todo/done','ToDoListController@showDoneToDoList');
        Route::get('todo/incomplete','ToDoListController@inCompleteToDoList');
        Route::resource('todo','ToDoListController',['except'=> 'create','edit']);
//        Route::get('todo/sorted','ToDoListController@getDataSorted');
//        Route::get('todo/done','ToDoListController@showDoneToDoList');
//        Route::get('todo/incomplete','ToDoListController@inCompleteToDoList');
        Route::post('logout','UserController@logout');
//        Route::get('getToDo','ToDoListController@getDataSorted');
//        Route::get('getDoneToDo','ToDoListController@showDoneToDoList');
//        Route::get('getInCompleteTodo','ToDoListController@inCompleteToDoList');
    });
});


//Route::post('register','UserController@registerUser');
//Route::post('login','UserController@authenticate');
//Route::group(['middleware'=> 'jwt.auth'],function (){
//    Route::resource('toDos','ToDoListController');
//    Route::post('logout','UserController@logout');
//});
