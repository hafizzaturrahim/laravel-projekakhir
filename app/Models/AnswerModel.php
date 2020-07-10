<?php
namespace App\Models;
use Illuminate\Support\Facades\DB;

class AnswerModel{
	public static function save($data){
		$data['created_at'] = date("Y-m-d H:i:s");
		$data['updated_at'] = date("Y-m-d H:i:s");
		$new_answer = DB::table('answers')->insert($data);
		return $new_answer;
	}

	public static function get_data($id){
		$result = DB::table('answers')->where('id_question',$id)->get();
		return $result;
	}

	public static function get_single_data($id){
		$result = DB::table('answers')->where('id_answer',$id)->first();
		return $result;
	}

	public static function get_best_answer($id){
		$result = DB::table('answers')->where([['id_question',$id],['best_answer',1]])->first();
		return $result;
	}

	public static function delete($id){
		$deleted = DB::table('answers')->where('id_answer',$id)->delete();
		return $deleted;
	}
	public static function delete_by_id_question($id){
		$deleted = DB::table('answers')->where('id_question',$id)->delete();
		return $deleted;
	}

	public static function get_data_with_vote($id){
		$results = DB::select( DB::raw("
			SELECT a.*, e.name, ifnull(b.like,0) as 'like',ifnull(c.dislike,0) as 'dislike',point from answers a left join (select id_answer,count(*) as 'like' from vote_answers where value = 1 group by id_answer) b on a.id_answer = b.id_answer left join (select id_answer,count(*) as 'dislike' from vote_answers where value = 0 group by id_answer) c on a.id_answer = c.id_answer left join show_point d on a.id = d.id join users e on a.id = e.id where id_question = :id_question"), array(
				'id_question' => $id,
			));

		return $results;
	}

	public static function update($id, $request){
		$question = DB::table('answers')
						->where('id_answer',$id)
						->update([
							'description' => $request['description'],
							'updated_at' => date("Y-m-d H:i:s")
						]);
		return $question;
	}

	public static function update_best_answer($id, $data){
		$question = DB::table('answers')
						->where('id_answer',$id)
						->update([
							'best_answer' => $data['best_answer'],
							'updated_at' => date("Y-m-d H:i:s")
						]);
		return $question;
	}


}
?>