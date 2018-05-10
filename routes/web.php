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

/** 
*   This is an example of route and function. Dont make function on this file.
*   It will make this file big and unreadable. Make it in Controller, e.g ExampleController,
*   1.  Create controller via terminal "php artisan make:controller ExampleController". 
*       You can found this controller on App/Http/Controller/ directory.
*   2.  Make a public function there, e.g ExampleFunction(){}
*   3.  Call it here using syntax: ExampleController@ExampleFunction, and replace function(){..} below.
*/
/** EXAMPLE START */
Route::get('/example', function(){
    $head = (object) array();
    $head->title = "Example Page";
    $head->subtitle = "Example Subtitle";
    return view('pages.example', compact('head'));
});
/** END OF EXAMPLE */


Route::get('/', function () {
    return view('templates.index');
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Route::group(['middleware'=>['auth', 'role:admin']], function(){
    Route::prefix('item')->name('item.')->group(function(){
        Route::post('add', 'ItemController@create')->name('add');
    });
});

//Experimental