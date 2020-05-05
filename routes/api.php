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
});

/**
 * 認証後のルーティング
 */
Route::group([
    'middleware' => 'auth:api',
    'namespace' => 'Api'
], function () {
    Route::resource('clients', 'ClientController', ['only' => ['index', 'show']]);
    Route::resource('products', 'ProductController', ['only' => ['index', 'show']]);
    Route::get('projects/statuses', 'ProjectController@getStatuses');
    Route::resource('projects', 'ProjectController', ['only' => ['index', 'show']]);
    Route::get('labels/project', 'LabelController@getProjectLabels');
    Route::resource('labels', 'LabelController', ['only' => ['index']]);
    Route::resource('memos', 'MemoController', ['only' => ['index']]);
    Route::resource('todos', 'TodoController', ['only' => ['index']]);
    Route::get('sales/client/{year}', 'SaleController@getSalesByClient');
    Route::get('sales/year/{year}', 'SaleController@getSalesByYear');
    Route::get('sales/month/{year}/{month}', 'SaleController@getSalesByMonth');
    Route::get('sales/statuses', 'SaleController@getStatuses');
});
