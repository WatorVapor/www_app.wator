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

Route::get('/about', 'Home\AboutController@index');
Route::get('/welcome', 'Home\WelcomeController@index');
Route::get('/', 'Home\WelcomeController@index');


Route::get('/rsaauth/signup', 'RsaAuth\SignUpController@index');
Route::post('/rsaauth/signup', 'RsaAuth\SignUpController@store');
Route::get('/rsaauth/import', 'RsaAuth\ImportController@index');
Route::post('/rsaauth/import', 'RsaAuth\ImportController@store');
Route::get('/rsaauth/profile', 'RsaAuth\ProfileController@index');
Route::post('/rsaauth/profile', 'RsaAuth\ProfileController@store');
Route::get('/rsaauth/login/{auto?}' 'RsaAuth\LoginController@index');
Route::post('/rsaauth/login', 'RsaAuth\LoginController@store');
Route::get('/rsaauth/fix', 'RsaAuth\FixController@index');
Route::post('/rsaauth/fix', 'RsaAuth\FixController@store');
Route::get('/rsaauth/access', 'RsaAuth\AccessController@index');
Route::post('/rsaauth/access', 'RsaAuth\AccessController@store');
Route::get('/rsaauth/language', 'RsaAuth\LanguageController@index');
Route::post('/rsaauth/language', 'RsaAuth\LanguageController@store');
Route::get('/rsaauth/debug', 'RsaAuth\DebugController@index');
Route::get('/rsaauth/error', 'RsaAuth\DebugController@index');
Route::get('/rsaauth', 'RsaAuth\LoginController@index');
