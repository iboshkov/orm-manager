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

use App\Http\Controllers\ORMManager;

Route::get('dashboard', 'ORMManager\MetaModelController@showDashboard')->name("dashboard");
Route::get('/', 'ORMManager\MetaModelController@showModels')->name("models");

Route::group(["prefix" => "api"], function($router) {
    // Metadata API
    Route::group(["prefix" => "meta"], function($router) {
        Route::get('/', 'ORMManager\MetaModelController@getModelMetaRoute');
        Route::get('/list', 'ORMManager\MetaModelController@getModels');
    });

    // CRUD API
    Route::group(["prefix" => "data"], function($router) {
        Route::get('/', 'ORMManager\ModelDataController@getAll');
        Route::post('/', 'ORMManager\ModelDataController@createEntry');
        Route::put('/', 'ORMManager\ModelDataController@updateEntry');
        Route::delete('/', 'ORMManager\ModelDataController@deleteEntry');
    });
});



