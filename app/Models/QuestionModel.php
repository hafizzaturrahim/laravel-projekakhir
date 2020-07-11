<?php
namespace App\Models;
use Illuminate\Support\Facades\DB;

class QuestionModel{
	public static function get_all(){
		$question = DB::table('questions')
					->join('users', 'users.id', '=', 'questions.id')
					->leftJoin('answers', 'answers.id_question', '=', 'questions.id_question')
					->select('questions.*', 'name', 'photo', DB::raw('IFNULL(count(id_answer),0) as `jumlah_jawaban`'))
					->groupBy('questions.id_question')
					->get();
		return $question;
	}

	public static function get_data_by_tags($key){
		$result = DB::table('questions')
					->join('users', 'users.id', '=', 'questions.id')
					->leftJoin('answers', 'answers.id_question', '=', 'questions.id_question')
					->select('questions.*', 'name', 'photo', DB::raw('IFNULL(count(id_answer),0) as `jumlah_jawaban`'))
					->groupBy('questions.id_question')
					->where('tags','like','%'.$key.'%')
					->get();
		//$result->tags = explode(" ",$result->tags);
		return $result;
	}

	public static function save($data){
		$data['created_at'] = date("Y-m-d H:i:s");
		$data['updated_at'] = date("Y-m-d H:i:s");
		$new_question = DB::table('questions')->insert($data);
		return $new_question;
	}

	public static function get_single_data($id){
		$result = DB::table('questions')
					->join('users', 'users.id', '=', 'questions.id')
					->leftJoin('rep_points', 'users.id', '=', 'rep_points.id')
					->select('questions.*', 'name', 'photo', DB::raw('IFNULL(sum(rep_points.point),0) as `point`'))
					->where('id_question',$id)
					->groupBy('users.id')
					->first();
		$result->tags = explode(" ",$result->tags);
		return $result;
	}

	public static function update($id, $request){
		$question = DB::table('questions')
						->where('id_question',$id)
						->update([
							'title'			=> $request['title'],
							'description' 	=> $request['description'],
							'tags' 	=> $request['tags'],
							'updated_at' => date("Y-m-d H:i:s")
						]);
		return $question;
	}

	public static function delete($id){
		$deleted = DB::table('questions')->where('id_question',$id)->delete();
		return $deleted;
	}


}
?>