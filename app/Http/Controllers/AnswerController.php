<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\AnswerModel;
use App\Models\QuestionModel;
use App\Models\VoteQuestionModel;
use App\Models\VoteAnswerModel;
use App\Models\RepPointModel;

class AnswerController extends Controller 
{
	public function index($id){
		$ses = 3;
		$data['question'] = QuestionModel::get_single_data($id);
		$data['point'] = RepPointModel::get_point_by_id($ses);

		//$question = json_decode(json_encode($question), true);
		$data['answer'] = AnswerModel::get_data_with_vote($id);
		//$question['answer'] = json_decode(json_encode($answer), true);
		$data['count'] = AnswerModel::get_data($id)->count();

		$data['like'] = VoteQuestionModel::get_count_like($id)->count();
		$data['dislike'] = VoteQuestionModel::get_count_dislike($id)->count();

		$data['check'] = VoteQuestionModel::check_data($id,$ses);
		return view('crud.single',compact('data'));
	}

	public function store(Request $request,$id){
		$ses = 3;
    	$description = $request->input('description');
    	$data = array(
    		'id_question'=>$id,
    		'description'=>$description,
    		'id_user' => $ses
    	);
    	$question = AnswerModel::save($data);
    	return redirect()->action('AnswerController@index',$id);
    }
}
