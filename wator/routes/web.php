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
Route::get('/rsaauth/login', 'RsaAuth\LoginController@index');
Route::post('/rsaauth/login', 'RsaAuth\LoginController@store');
Route::get('/rsaauth/fix', 'RsaAuth\FixController@index');
Route::post('/rsaauth/fix', 'RsaAuth\FixController@store');
Route::get('/rsaauth/access', 'RsaAuth\AccessController@index');
Route::post('/rsaauth/access', 'RsaAuth\AccessController@store');
Route::get('/rsaauth/language', 'RsaAuth\LanguageController@index');
Route::post('/rsaauth/language', 'RsaAuth\LanguageController@store');
Route::get('/rsaauth', 'RsaAuth\LoginController@index');



Route::get('/wai/', 'Wai\WelcomeController@index');
Route::get('/wai/audio/share', 'Wai\AudioShareController@index');
Route::get('/wai/text/participle', 'Wai\ParticipleController@index');
Route::post('/wai/text/participle', 'Wai\ParticipleController@store');
Route::get('/wai/text/train/crawler/summary', 'Wai\CrawlerTrainController@summary');
Route::get('/wai/text/train/crawler', 'Wai\CrawlerTrainController@fetch');
Route::post('/wai/text/train/crawler', 'Wai\CrawlerTrainController@update');
Route::get('/wai/text/train/ostrich/summary', 'Wai\OstrichTrainController@summary');
Route::get('/wai/text/train/ostrich/{task}', 'Wai\OstrichTrainController@fetch');
Route::post('/wai/text/train/ostrich/{task}', 'Wai\OstrichTrainController@update');
Route::get('/wai/text/train/parrot/summary', 'Wai\ParrotTrainController@summary');
Route::get('/wai/text/train/parrot/{task}', 'Wai\ParrotTrainController@fetch');
Route::post('/wai/text/train/parrot/{task}', 'Wai\ParrotTrainController@update');
Route::get('/wai/text/train/phoenix/summary', 'Wai\PhoenixTrainController@summary');
Route::get('/wai/text/train/phoenix/{task}', 'Wai\PhoenixTrainController@fetch');
Route::post('/wai/text/train/phoenix/{task}', 'Wai\PhoenixTrainController@update');


Route::get('/aibot/twitter', 'AIBot\TwitterController@index');
Route::get('/aibot/weibo', 'AIBot\WeiboController@index');
Route::get('/aibot/weibo/cancel', 'AIBot\WeiboController@cancel');


Route::get('/ppio/', 'PPio\AboutController@index');
Route::get('/ppio/about', 'PPio\AboutController@index');

Route::get('/ppio/keys', 'PPio\KeysController@index');
Route::get('/ppio/cast', 'PPio\CastController@index');
Route::get('/ppio/catch', 'PPio\CatchController@index');

Route::get('/ppio/ble/search', 'PPio\BLESearchController@index');
Route::get('/ppio/ble/dbc', 'PPio\BLEDualBoxCarController@index');
Route::get('/ppio/ble/chart', 'PPio\BLEChartController@index');

Route::get('/ppio/cloud/gofuro', 'PPio\CloudGoFuroController@index');

Route::get('/ppio/msgchain/entry', 'PPio\WorldEntryController@index');
Route::post('/ppio/msgchain/entry', 'PPio\WorldEntryController@store');
Route::delete('/ppio/msgchain/entry/{node}', 'PPio\WorldEntryController@destroy');


Route::get('/story/slip/{chapter?}', 'Story\SlipController@index');
Route::get('/story/home/{position?}', 'Story\HomeController@index');
Route::get('/story/', 'Story\HomeController@index');

