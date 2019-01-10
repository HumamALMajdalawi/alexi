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


Route::get('t', function () {
//    \App\Models\Site::truncate();
    $sites = [
        "FUGGLESTON RED",
        "WOODLEY",
        "QUEENSGATE",
        "HARTLEY WINTNEY",
        "SALISBURY",
        "FORGEWOOD",
        "AYLESFORD",
        "BRISTOL",
        "HEADLEY FIELDS",
        "EPSOM",
        "FARNHAM",
        "MERTON RISE",
        "WINKFIELD",
        "ODIHAM",
    ];
    foreach ($sites as $site)
        \App\Models\Site::create(['name' => $site]);
});



Route::get('/home', 'HomeController@index')->name('home');
