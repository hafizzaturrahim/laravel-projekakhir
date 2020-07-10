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

/*Route::get('/', function () {
    return view('welcome');
});*/
Route::redirect('/', '/pertanyaan');
/*Route::get('/master', function () {
    return view('master');
});

Route::get('/data-tables', function () {
    return view('data-tables');
});
*/

// Route pertanyaan
Route::get('/pertanyaan','QuestionController@index'); // daftar pertanyaan
Route::get('/pertanyaan/create','QuestionController@create'); // buat pertanyaan
Route::post('/pertanyaan','QuestionController@store'); // store pertanyaan baru
Route::get('/pertanyaan/{id}/edit','QuestionController@edit'); // edit pertanyaan
Route::put('/pertanyaan/{id}','QuestionController@update'); // store pertanyaan telah diedit
Route::delete('/pertanyaan/{id}','QuestionController@destroy'); // hapus pertanyaan

Route::get('/jawaban/{id}','AnswerController@index'); // daftar jawaban berdasar pertanyaan tertentu
Route::post('/jawaban/{id}','AnswerController@store'); // buat jawaban baru

Route::put('/komentar/pertanyaan/{id}','CommentQuestionController@store'); // buat komentar pertanyaan
Route::put('/komentar/jawaban/{id}','CommentAnswerController@store'); // buat komentar jawaban

Route::put('/pertanyaan/{id_question}/vote','VoteQuestionController@store');
Route::put('/jawaban/{id_answer}/vote','VoteAnswerController@store');



Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

// text editor
Route::group(['prefix' => 'laravel-filemanager', 'middleware' => ['web', 'auth']], function () {
     \UniSharp\LaravelFilemanager\Lfm::routes();
 });