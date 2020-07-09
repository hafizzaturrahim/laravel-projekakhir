<?php
namespace App\Models;
use Illuminate\Support\Facades\DB;

class VoteAnswerModel{
	public static function get_count_like($id_answer){
		$question = DB::table('vote_answers')->where([
			['value',1],
			['id_answer', $id_answer]
		])->get();
		return $question;
	}

	public static function get_count_dislike($id_answer){
		$question = DB::table('vote_answers')->where([
			['value',0],
			['id_answer', $id_answer]
		])->get();
		return $question;
	}

	public static function check_data($id_answer,$id_voter){
		$result = DB::table('vote_answers')
		->where([
			['id_voter', $id_voter],
			['id_answer', $id_answer]
		])->first();
		return $result;
	}

	public static function save($data){
		$new_question = DB::table('vote_answers')->insert($data);
		return $new_question;
	}

	public static function update($request){
		$question = DB::table('vote_answers')
		->where([
			['id_voter', $request['id_voter']],
			['id_answer', $request['id_answer']]
		])
		->update([
			'value'	=> $request['value']
		]);
		return $question;
	}

	public static function delete($id_answer,$id_voter){
		$deleted = DB::table('vote_answers')
		->where([
			['id_voter', $id_voter],
			['id_answer', $id_answer]
		])
		->delete();
		return $deleted;
	}


}
?>