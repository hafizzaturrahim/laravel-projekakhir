<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\VoteAnswerModel;
use App\Models\RepPointModel;

class VoteAnswerController extends Controller
{

	public function __construct(){
		$this->middleware('auth');
	}
    
	public function store(Request $request,$id_answer){
		$user = Auth::user();
        $id_voter = Auth::id();

		$id_question = $request->input('id_q');
		if ($request->input('val') == 'up') {
			$value = 1;
		}else{
			$value = 0;
		}
		$data = array(
			'id_voter'=> $id_voter,
			'id_answer'=>$id_answer,
			'value' => $value
		);

    	//cek untuk menghindari redundansi
		$check = VoteAnswerModel::check_data($id_answer,$id_voter);
		if (!isset($check)) {
			$question = VoteAnswerModel::save($data);
			if ($value == 1) {
				$rp = array(
					'transaction'=> "Liked in answer:". $id_answer,
					'point'=> 10,
					'id' => $request->input('id')
				);
			}else{
				$rp = array(
					'transaction'=> "Disliked in answer:". $id_answer,
					'point'=> -1,
					'id' => $id_voter
				);
			}
			$save_point = RepPointModel::save($rp);
		}else{
			if ($check->value != $value) {
				$question = VoteAnswerModel::update($data);
				if ($value == 1) {
					$rp = array(
						[
						'transaction'=> "Change to liked in answer:". $id_answer,
						'point'=> 10,
						'id' => $request->input('id')
						],
						[
						'transaction'=> "Change to liked in answer:". $id_answer,
						'point'=> 1,
						'id' => $id_voter
						]
					);
				}else{
					$rp = array(
						[
						'transaction'=> "Change to disliked by:in answer:". $id_answer,
						'point'=> -10,
						'id' => $request->input('id')
						],
						[
						'transaction'=> "Change to disliked by:in answer:". $id_answer,
						'point'=> -1,
						'id' => $id_voter
						]
					);
				}
				$save_point = RepPointModel::save($rp);
			}
		}
		return redirect()->action('AnswerController@index',$id_question);
	}
}