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
    return redirect('/dashboard');
    // return view('templates.index');
})->middleware('auth');

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
Route::get('/test', function(){
    return view('pages.login');
})->name('test');

Route::group(['middleware'=>['auth']], function(){
    Route::prefix('dashboard')->name('dashboard.')->group(function(){
        Route::get('/', 'DashboardController@dashboard')->name('index');
    });
    Route::prefix('product')->name('product.')->group(function(){
        Route::get('page-add', 'ProductController@pageAdd')->name('page.add');
        Route::post('new-product', 'ProductController@createProduct')->name('new');
        Route::get('page-update', 'ProductController@pageUpdate')->name('page.update');
    });
    Route::prefix('transaction')->name('transaction.')->group(function(){
        Route::get('page-enter', 'TransactionController@pageEnter')->name('page.enter');
        Route::get('page-sending', 'TransactionController@pageSending')->name('page.sending');
        Route::get('page-accepted', 'TransactionController@pageAccepted')->name('page.accepted');
        Route::get('page-archive', 'TransactionController@pageArchive')->name('page.archive');
    });
});

//Experimental
