<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\AnswerModel;
use App\Models\QuestionModel;
use App\Models\VoteQuestionModel;
use App\Models\VoteAnswerModel;
use App\Models\RepPointModel;

class AnswerController extends Controller 
{
	public function __construct(){
		$this->middleware('auth');
	}
	
	public function index($id){
        $user = Auth::user();
        $id_user = Auth::id();

		$data['question'] = QuestionModel::get_single_data($id);
		$data['point'] = RepPointModel::get_point_by_id($id_user);

		//$question = json_decode(json_encode($question), true);
		$data['answer'] = AnswerModel::get_data_with_vote($id);
		//$question['answer'] = json_decode(json_encode($answer), true);
		$data['count'] = AnswerModel::get_data($id)->count();

		$data['like'] = VoteQuestionModel::get_count_like($id)->count();
		$data['dislike'] = VoteQuestionModel::get_count_dislike($id)->count();

		$data['check'] = VoteQuestionModel::check_data($id,$id_user);
		$data['id'] = $id_user;
		return view('crud.single',compact('data'));
	}

	public function store(Request $request,$id){
        $user = Auth::user();
        $id_user = Auth::id();

    	$description = $request->input('description');
    	$data = array(
    		'id_question'=>$id,
    		'description'=>$description,
    		'id' => $id_user
    	);
    	$question = AnswerModel::save($data);
    	return redirect()->action('AnswerController@index',$id);
    }
}
