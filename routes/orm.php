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
Route::get('models', 'ORMManager\MetaModelController@showModels')->name("models");
Route::get('api/models', 'ORMManager\MetaModelController@getModels');


