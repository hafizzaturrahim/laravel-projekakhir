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
Route::get('/jawaban/{id}/edit','AnswerController@edit'); //edit jawaban
Route::put('/jawaban/{id}','AnswerController@update'); //store jawaban yang telah diedit
Route::delete('/jawaban/{id}','AnswerController@destroy'); // hapus jawaban

Route::put('/jawaban/{id}/best','AnswerController@set_best_answer'); //store jawaban yang telah diedit

Route::put('/komentar/pertanyaan/{id}','CommentQuestionController@store'); // buat komentar pertanyaan
Route::put('/komentar/jawaban/{id}','CommentAnswerController@store'); // buat komentar jawaban

Route::put('/pertanyaan/{id_question}/vote','VoteQuestionController@store'); //beri vote untuk pertanyaan
Route::put('/jawaban/{id_answer}/vote','VoteAnswerController@store'); //beri vote untuk jawaban

Route::get('/tags/{key}','QuestionController@get_tags'); //pencarian berdasarkan tags



Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

// text editor
Route::group(['prefix' => 'laravel-filemanager', 'middleware' => ['web', 'auth']], function () {
     \UniSharp\LaravelFilemanager\Lfm::routes();
 });