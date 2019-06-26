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

Route::get('/', function () { return view('index');});
Route::get('recruitment', 'RecruitmentController@index' );
Route::get('dataUser','RecruitmentController@dataUser');
Route::get('ajaxdata/fetchdata', 'RecruitmentController@fetchdata')->name('ajaxdata.fetchdata');
Route::post('ajaxdata/postdata', 'RecruitmentController@postdata')->name('ajaxdata.postdata');
Route::get('ajaxdata/removedata', 'RecruitmentController@removedata')->name('ajaxdata.removedata');


