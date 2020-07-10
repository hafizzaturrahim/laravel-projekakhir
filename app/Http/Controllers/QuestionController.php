<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\QuestionModel;
use App\Models\AnswerModel;
use App\Models\CommentQuestionModel;
use App\Models\VoteQuestionModel;
use App\Models\VoteAnswerModel;


class QuestionController extends Controller
{
    public function __construct(){
        $this->middleware('auth');
    }
    
    public function index(){
    	$question = QuestionModel::get_all();
    	return view('crud.index',compact('question'));
    }

    public function create(){
    	return view('crud.form-question');
    }

    public function store(Request $request){
        $user = Auth::user();
        $id_user = Auth::id();

    	$title = $request->input('title');
    	$description = $request->input('description');
    	$data = array(
            'title'=>$title,
            'description'=>$description,
            'id'=>$id_user,
            'tags' => $request->input('tags')
        );
    	$question = QuestionModel::save($data);
    	return redirect()->action('QuestionController@index');
    }

    public function show($id) {
        $question = QuestionModel::get_single_data($id);
        $answer = AnswerModel::get_data($id);
        return view('crud.show', compact('question', 'answer'));
    }

    public function edit($id){
        $question = QuestionModel::get_single_data($id);
        return view('crud.form-edit-question',compact('question'));
        //dd(compact('question'));
    }

    public function update(Request $request,$id){
        $question = QuestionModel::update($id, $request->all());    
        return redirect('/pertanyaan');
    }

    public function destroy($id){
        $deleteVote = VoteAnswerModel::delete($id);
        $deleteVoteQ = VoteQuestionModel::delete($id);
        $answer = AnswerModel::delete_by_id_question($id);
        $comment = CommentQuestionModel::delete($id);
        $question = QuestionModel::delete($id);
        return redirect('/pertanyaan');
    }
}
