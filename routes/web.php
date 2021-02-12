<?php

use Illuminate\Support\Facades\Route;

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

Route::get('{slug?}', 'FormController@index')->where('slug','.+');
Route::post('search-zip', 'FormController@searchZip');
Route::post('search-make', 'FormController@searchMake');
Route::post('search-model', 'FormController@searchModel');
Route::post('request', 'FormController@request');
