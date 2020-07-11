<?php
namespace App\Models;
use Illuminate\Support\Facades\DB;

class VoteAnswerModel{
	public static function get_count_like($id_answer){
		$vote_answer = DB::table('vote_answers')->where([
			['value',1],
			['id_answer', $id_answer]
		])->get();
		return $vote_answer;
	}

	public static function get_count_dislike($id_answer){
		$vote_answer = DB::table('vote_answers')->where([
			['value',0],
			['id_answer', $id_answer]
		])->get();
		return $vote_answer;
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
		$new_vote_answer = DB::table('vote_answers')->insertOrIgnore($data);
		return $new_vote_answer;
	}

	public static function update($request){
		$vote_answer = DB::table('vote_answers')
		->where([
			['id_voter', $request['id_voter']],
			['id_answer', $request['id_answer']]
		])
		->update([
			'value'	=> $request['value']
		]);
		return $vote_answer;
	}

	public static function delete_by_voter($id_answer,$id_voter){
		$deleted = DB::table('vote_answers')
		->where([
			['id_voter', $id_voter],
			['id_answer', $id_answer]
		])
		->delete();
		return $deleted;
	}

	public static function delete($id_answer){
		$deleted = DB::table('vote_answers')
		->where('id_answer', $id_answer)
		->delete();
		return $deleted;
	}


}
?>