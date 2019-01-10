<?php
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
Route::post('login', 'Api\AuthController@login');

Route::post('register', 'Api\AuthController@register');


Route::group(['middleware' => 'auth:api'], function () {
    Route::post('logout', 'Api\AuthController@logout');

Route::prefix('user')->group(function () {
        Route::get("filter", 'Api\UserController@filter');
        Route::post("upload", 'Api\UserController@upload');
        Route::post('profile', 'Api\UserController@profile');
        Route::get('current', 'Api\UserController@current');
        Route::get('/', 'Api\UserController@index');
        Route::get('/{id}', 'Api\UserController@details');
        Route::post('/', 'Api\UserController@store');
        Route::put('/{id}', 'Api\UserController@update');
        Route::delete('/{id}', 'Api\UserController@destroy');
    });    

    Route::resource('branches', 'Api\BranchController');

    Route::prefix('roles')->group(function () {
        Route::get('/menu', 'Api\RoleController@menu');
        Route::get('{id}/actions', 'Api\RoleController@actions');
        Route::post('{id}/actions', 'Api\RoleController@save_actions');
    });

    Route::resource('roles', 'Api\RoleController');


    Route::resource('branches', 'Api\BranchController');
    Route::resource('table-columns', 'Api\TableColumnsController');
    Route::get("table/all", "Api\TableController@all");
    Route::get("table/{name}/columns", "Api\TableController@getTableColumns");
    Route::resource('table', 'Api\TableController');

    Route::resource('sales', 'Api\SalesSheetController');
    Route::resource("fitters", "Api\FitterController");
    Route::get("fitters/{id}/jobs", "Api\FitterController@jobs");
    Route::resource('jobs', 'Api\JobController');

    Route::put('developers/site/{id}', 'Api\DeveloperController@updateSite');
    Route::post('developers/site/{id}', 'Api\DeveloperController@deleteSite');
    Route::post('developers/{id}/site', 'Api\DeveloperController@site');
    Route::resource('developers', 'Api\DeveloperController');
//    Route::resource("fitter-rates", "Api\FitterRatesController");
    Route::get('getRatePrice','Api\JobsController@getRatePrice');


});

Route::get("users-numbers", 'Api\UserController@numbers');
Route::get("branches-numbers", 'Api\BranchController@numbers');




//by solayman


Route::resource("ratename", "Api\RateNameController");
Route::resource("fitters", "Api\FitterController");
Route::resource("company_rates", "Api\CompanyRatesController");
Route::resource("fitter_rates", "Api\FitterRatesController");
Route::resource("site_rates", "Api\SiteRatesController");
Route::get('getSiteName/{site_id}',"Api\SiteRatesController@getSiteName");
