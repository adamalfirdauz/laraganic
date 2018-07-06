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

Route::post('login', 'API\PassportController@login');
Route::post('register', 'API\PassportController@register');
Route::post('profile/update', 'API\PassportController@update')->middleware('auth:api');
Route::post('logout', 'API\PassportController@logout')->middleware('auth:api');

Route::group(['middleware' => ['auth:api','role:user']], function(){
    Route::post('get-user-details', 'API\PassportController@getDetails')->middleware('scope:user-detail');
    Route::post('add-item-to-cart', 'CartController@add');
    Route::post('get-cart-content', 'CartController@content');
});
Route::group(['middleware' => ['auth:api','role:user']], function(){
    Route::post('transaction/create', 'TransactionAPIController@create');
    Route::get('transaction/getAll', 'TransactionAPIController@getAll');
    Route::post('transaction/update', 'TransactionAPIController@update');
    Route::get('transaction/get/{code}', 'TransactionAPIController@get');
});
Route::prefix('product')->group(function(){
    Route::get('getAll', 'ProductApiController@getAll');
    Route::get('get/category/{category}', 'ProductApiController@getCategory');
    Route::post('search', 'ProductApiController@search');
});


// eksperimental
// Route::post('add-item', 'ItemController@create')->middleware(['auth:api', 'role:admin']);