<?php
namespace App\Models;
use Illuminate\Support\Facades\DB;

class QuestionModel{
	public static function get_all(){
		$question = DB::table('questions')->get();
		return $question;
	}

	public static function save($data){
		$new_question = DB::table('questions')->insert($data);
		return $new_question;
	}

	public static function get_single_data($id){
		$result = DB::table('questions')
					->join('users', 'users.id_user', '=', 'questions.id_user')
					->leftJoin('rep_points', 'users.id_user', '=', 'rep_points.id_user')
					->select('questions.*', 'fullname', 'photo', DB::raw('IFNULL(sum(rep_points.point),0) as `point`'))
					->where('id_question',$id)
					->groupBy('users.id_user')
					->first();
		return $result;
	}

	public static function update($id, $request){
		$question = DB::table('questions')
						->where('id_question',$id)
						->update([
							'title'			=> $request['title'],
							'description' 	=> $request['description']
						]);
		return $question;
	}

	public static function delete($id){
		$deleted = DB::table('questions')->where('id_question',$id)->delete();
		return $deleted;
	}


}
?>