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
Route::get('/encode','Test\TestController@encode');
Route::get('/decode','Test\TestController@decode');
Route::get('/code','Test\TestController@code');
Route::get('/feicode','Test\TestController@feicode');
Route::get('/fcode','Test\TestController@fcode');
Route::get('/testsign','Test\TestController@testsign');



//考试
Route::get('/reg','Reg\LoginController@reg');
Route::post('/regdo','Reg\LoginController@regdo');

Route::get('/ajax','Reg\LoginController@ajax');
