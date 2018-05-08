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

Route::group(['middleware' => ['auth:api','role:user']], function(){
    Route::post('get-user-details', 'API\PassportController@getDetails')->middleware('scope:user-detail');
    Route::post('add-item-to-cart', 'CartController@add');
    Route::post('get-cart-content', 'CartController@content');
});


// eksperimental
// Route::post('add-item', 'ItemController@create')->middleware(['auth:api', 'role:admin']);