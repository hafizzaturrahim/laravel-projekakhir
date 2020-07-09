<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\VoteAnswerModel;
use App\Models\RepPointModel;

class VoteAnswerController extends Controller
{
	public function store(Request $request,$id_answer){
		$ses = 4;
		$id_question = $request->input('id_q');
		$id_user = $request->input('id');
		if ($request->input('val') == 'up') {
			$value = 1;
		}else{
			$value = 0;
		}
		$data = array(
			'id_voter'=> $ses,
			'id_answer'=>$id_answer,
			'id_user' => $request->input('id'),
			'value' => $value
		);

    	//cek untuk menghindari redundansi
		$check = VoteAnswerModel::check_data($id_answer,$data['id_voter']);
		if (!isset($check)) {
			$question = VoteAnswerModel::save($data);
			if ($value == 1) {
				$rp = array(
					'transaction'=> "Liked by:". $ses. ":in answer:". $id_answer,
					'point'=> 10,
					'id_user' => $request->input('id')
				);
			}else{
				$rp = array(
					'transaction'=> "Liked by:". $ses. ":in answer:". $id_answer,
					'point'=> -1,
					'id_user' => $request->input('id')
				);
			}
			$save_point = RepPointModel::save($rp);
		}else{
			if ($check->value != $value) {
				$question = VoteAnswerModel::update($data);
				if ($value == 1) {
					$rp = array(
						'transaction'=> "Change to liked by:". $ses. ":in answer:". $id_answer,
						'point'=> 11,
						'id_user' => $request->input('id')
					);
				}else{
					$rp = array(
						'transaction'=> "Change to disliked by:". $ses. ":in answer:". $id_answer,
						'point'=> -11,
						'id_user' => $request->input('id')
					);
				}
				$save_point = RepPointModel::save($rp);
			}
		}
		return redirect()->action('AnswerController@index',$id_question);
	}
}