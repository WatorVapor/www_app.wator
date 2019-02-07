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
Route::get('/search/link', 'Home\SearchLinkController@index');


Route::get('/secauth/signup', 'SecAuth\SignUpController@index');
Route::post('/secauth/signup', 'SecAuth\SignUpController@store');
Route::get('/secauth/import', 'SecAuth\ImportController@index');
Route::post('/secauth/import', 'SecAuth\ImportController@store');
Route::get('/secauth/profile', 'SecAuth\ProfileController@index');
Route::post('/secauth/profile', 'SecAuth\ProfileController@store');
Route::get('/secauth/login', 'SecAuth\LoginController@index');
Route::post('/secauth/login', 'SecAuth\LoginController@store');
Route::get('/secauth/logout', 'SecAuth\LogoutController@index');
Route::post('/secauth/logout', 'SecAuth\LogoutController@store');
Route::get('/secauth/fix', 'SecAuth\FixController@index');
Route::post('/secauth/fix', 'SecAuth\FixController@store');
Route::get('/secauth/access', 'SecAuth\AccessController@index');
Route::post('/secauth/access', 'SecAuth\AccessController@store');
Route::get('/secauth/language', 'SecAuth\LanguageController@index');
Route::post('/secauth/language', 'SecAuth\LanguageController@store');
Route::get('/secauth', 'SecAuth\LoginController@index');



Route::get('/wai/', 'Wai\WelcomeController@index');
Route::get('/wai/audio/share', 'Wai\AudioShareController@index');

Route::get('/wai/text/participle', 'Wai\ParticipleController@index');
Route::post('/wai/text/participle', 'Wai\ParticipleController@store');
Route::post('/wai/text/participle/sns', 'Wai\ParticipleController@sns');


Route::get('/wai/text/record_voice/{name?}', 'Wai\RecordVoiceController@index');
Route::post('/wai/text/record_voice/{name?}', 'Wai\RecordVoiceController@store');

Route::get('/wai/text/record_continue/{name?}', 'Wai\RecordContinueController@index');
Route::post('/wai/text/record_continue/{name?}', 'Wai\RecordContinueController@store');

Route::get('/wai/text/recognition', 'Wai\RecognitionVoiceController@index');
Route::get('/wai/text/recognition_fix', 'Wai\RecognitionVoiceController@index_fix');


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
Route::get('/aibot/weibo/auth', 'AIBot\WeiboController@auth');
Route::get('/aibot/weibo/cancel', 'AIBot\WeiboController@cancel');


Route::get('/starbian/', 'StarBian\AboutController@index');
Route::get('/starbian/about', 'StarBian\AboutController@index');

Route::get('/starbian/keys', 'StarBian\KeysController@index');
Route::get('/starbian/cast', 'StarBian\CastController@index');
Route::get('/starbian/catch', 'StarBian\CatchController@index');

Route::get('/starbian/ble/search', 'StarBian\BLESearchController@index');
Route::get('/starbian/ble/dbc', 'StarBian\BLEDualBoxCarController@index');
Route::get('/starbian/ble/chart', 'StarBian\BLEChartController@index');

Route::get('/starbian/cloud/gofuro', 'StarBian\CloudGoFuroController@index');

Route::get('/starbian/cloud/videocam/{remote?}', 'StarBian\CloudVideocamController@index');
Route::get('/starbian/cloud/videocam_cast/{remote?}', 'StarBian\CloudVideocamController@index_cast');
Route::get('/starbian/cloud/videocam_recv/{remote?}', 'StarBian\CloudVideocamController@index_recv');
Route::get('/starbian/cloud/videocam_monitor', 'StarBian\CloudVideocamController@monitor');
Route::get('/starbian/cloud/m/videocam/{remote?}', 'StarBian\CloudVideocamController@index_m');
Route::get('/starbian/cloud/m/videocam_cast/{remote?}', 'StarBian\CloudVideocamController@index_cast_m');
Route::get('/starbian/cloud/m/videocam_recv/{remote?}', 'StarBian\CloudVideocamController@index_recv_m');
Route::get('/starbian/cloud/m/videocam_monitor', 'StarBian\CloudVideocamController@monitor_m');

Route::get('/starbian/cloud/videocam_cast_opencv/{remote?}', 'StarBian\CloudVideocamController@index_cast_opencv');
Route::get('/starbian/cloud/m/videocam_cast_opencv/{remote?}', 'StarBian\CloudVideocamController@index_cast_opencv_m');
Route::get('/starbian/cloud/l/videocam_cast_opencv/{remote?}', 'StarBian\CloudVideocamController@index_cast_opencv_l');
Route::get('/starbian/cloud/l/videocam_cast_capture/{remote?}', 'StarBian\CloudVideocamController@index_cast_capture');



Route::get('/starbian/msgchain/entry', 'StarBian\WorldEntryController@index');
Route::post('/starbian/msgchain/entry', 'StarBian\WorldEntryController@store');
Route::delete('/starbian/msgchain/entry/{node}', 'StarBian\WorldEntryController@destroy');


Route::get('/story/slip/{chapter?}', 'Story\SlipController@index');
Route::get('/story/home/{position?}', 'Story\HomeController@index');
Route::get('/story/', 'Story\HomeController@index');

Route::get('/ethereum/', 'Ethereum\EthereumController@index');

 

