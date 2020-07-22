<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

/**
 * 認証関連のルーティング
 */
Route::group([
    'middleware' => 'api',
    'prefix' => 'auth',
    'namespace' => 'Api'
], function () {
    Route::post('token', 'AuthController@token');
    Route::post('logout', 'AuthController@logout');
    Route::post('refresh', 'AuthController@refresh');
    Route::get('me', 'AuthController@me');
    Route::post('register', 'AuthController@register');
    Route::put('update/{id}', 'AuthController@update');
});

/**
 * 認証後のルーティング
 */
Route::group([
    'middleware' => 'auth:api',
    'namespace' => 'Api'
], function () {
    Route::resource('clients', 'ClientController');
    Route::get('projects/statuses', 'ProjectController@getStatuses');
    Route::post('projects/statuses', 'ProjectController@updateStatuses');
    Route::resource('projects', 'ProjectController');
    Route::get('labels/project', 'LabelController@getProjectLabels');
    Route::resource('labels', 'LabelController', ['only' => ['index']]);
    Route::resource('memos', 'MemoController');
    Route::get('todos/current', 'TodoController@current');
    Route::post('todos/toggle-status/{id}', 'TodoController@toggleStatus');
    Route::resource('todos', 'TodoController');

    Route::resource('sales', 'SaleController', ['only' => ['store', 'update', 'destroy']]);
    Route::group(['prefix' => 'sales'], function() {
        Route::get('client/{year}', 'SaleController@getSalesByClient');
        Route::get('year/{year}', 'SaleController@getSalesByYear');
        Route::get('month/{year}/{month}', 'SaleController@getSalesByMonth');
        Route::get('statuses', 'SaleController@getStatuses');
        Route::post('statuses', 'SaleController@updateStatuses');
    });

    Route::post('file/upload', 'FileController@upload');
    Route::resource('project-records', 'ProjectRecordController', ['only' => ['store', 'update', 'destroy']]);

});
