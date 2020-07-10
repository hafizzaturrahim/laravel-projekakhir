<?php
namespace App\Models;
use Illuminate\Support\Facades\DB;

class VoteQuestionModel{
	public static function get_count_like($id_question){
		$vote_question = DB::table('vote_questions')->where([
			['value',1],
			['id_question', $id_question]
		])->get();
		return $vote_question;
	}

	public static function get_count_dislike($id_question){
		$vote_question = DB::table('vote_questions')->where([
			['value',0],
			['id_question', $id_question]
		])->get();
		return $vote_question;
	}

	public static function check_data($id_question,$id_voter){
		$result = DB::table('vote_questions')
		->where([
			['id_voter', $id_voter],
			['id_question', $id_question]
		])->first();
		return $result;
	}

	public static function save($data){
		$new_vote_question = DB::table('vote_questions')->insert($data);
		return $new_vote_question;
	}

	public static function update($request){
		$vote_question = DB::table('vote_questions')
		->where([
			['id_voter', $request['id_voter']],
			['id_question', $request['id_question']]
		])
		->update([
			'value'	=> $request['value']
		]);
		return $vote_question;
	}

	public static function delete_by_voter($id_question,$id_voter){
		$deleted = DB::table('vote_questions')
		->where([
			['id_voter', $id_voter],
			['id_question', $id_question]
		])
		->delete();
		return $deleted;
	}

	public static function delete($id_question){
		$deleted = DB::table('vote_questions')
		->where('id_question', $id_question)
		->delete();
		return $deleted;
	}


}
?>