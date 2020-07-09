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
    return view('home');
});

Route::get('/master', function () {
    return view('master');
});

Route::get('/data-tables', function () {
    return view('data-tables');
});

Route::get('/pertanyaan','QuestionController@index');
Route::get('/pertanyaan/create','QuestionController@create');
Route::post('/pertanyaan','QuestionController@store');
Route::get('/jawaban/{id}','AnswerController@index');
Route::post('/jawaban/{id}','AnswerController@store');

Route::get('/pertanyaan/{id}/edit','QuestionController@edit');
Route::put('/pertanyaan/{id}','QuestionController@update');
Route::delete('/pertanyaan/{id}','QuestionController@destroy');


Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
