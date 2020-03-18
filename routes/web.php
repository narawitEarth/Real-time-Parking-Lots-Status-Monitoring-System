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
Route::get('/','tarcontroller@view')->name('project.view');;
Route::get('view2','tarcontroller@view2')->name('project.view2');;

// Route::get('/fetch-data','tarcontroller@fetchData')->name('project.fetchData');;
Route::get('/post-data','tarcontroller@postData')->name('postData');
Route::get('/post-data2','tarcontroller@postData2')->name('postData2');
Route::get('/log-data','tarcontroller@logData')->name('logData');
// Route::post('/post-data','tarcontroller@postData')->name('postData');
// Route::resource('/view','tarcontroller');

