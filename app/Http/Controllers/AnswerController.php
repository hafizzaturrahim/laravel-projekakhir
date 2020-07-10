<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\AnswerModel;
use App\Models\QuestionModel;
use App\Models\CommentQuestionModel;
use App\Models\CommentAnswerModel;
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
		$data['comment_question'] = CommentQuestionModel::get_by_id_question($id);
		$data['point'] = RepPointModel::get_point_by_id($id_user);

		//$question = json_decode(json_encode($question), true);
		$data['answer'] = AnswerModel::get_data_with_vote($id);
        $data['best_answer'] = AnswerModel::get_best_answer($id);
		$data['comment_answer'] = CommentAnswerModel::get_all($data);

		$data['count'] = AnswerModel::get_data($id)->count();

		$data['like'] = VoteQuestionModel::get_count_like($id)->count();
		$data['dislike'] = VoteQuestionModel::get_count_dislike($id)->count();

		$data['check'] = VoteQuestionModel::check_data($id,$id_user);
		$data['id'] = $id_user;
		// dd($data);
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

    public function edit($id){
    	$answer = AnswerModel::get_single_data($id);
    	return view('crud.edit-answer',compact('answer'));
    }

    public function update(Request $request,$id){
        $answer = AnswerModel::update($id, $request->all());    
        return redirect()->action('AnswerController@index',$request->input('id_question'));
    }

    public function destroy($id){
    	$deleteVote = VoteAnswerModel::delete($id);
        $answer = AnswerModel::delete($id);
        return redirect()->action('AnswerController@index',$id);
    }

    public function set_best_answer(Request $request,$id_answer){
        $user = Auth::user();
        $id_voter = Auth::id();

        $data = array('best_answer' => $request->input('best'));
        $best_answer = AnswerModel::update_best_answer($id_answer, $data);

        $id_question = $request->input('id_question');
        if ($request->input('val') == 'up') {
            $value = 15;
        }else{
            $value = 0;
        }

        // kondisi dalam memberikan nilai reputasi
        if ($value != 0) {  
            $data = array(
                'transaction'=> "Best answer:". $id_answer,
                'point'=> $value,
                'id' => $request->input('id')
            );
            $rep = RepPointModel::save($data);
        } else {
            $data = array( 'transaction' => "Best answer:". $id_answer );
            $save_point = RepPointModel::delete($data);
        }

        return redirect()->action('AnswerController@index',$id_question);
    }

}
