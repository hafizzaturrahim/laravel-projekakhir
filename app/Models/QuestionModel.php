<?php
namespace App\Models;
use Illuminate\Support\Facades\DB;

class QuestionModel{
	public static function get_all(){
		$question = DB::table('question')->get();
		return $question;
	}

	public static function save($data){
		$new_question = DB::table('question')->insert($data);
		return $new_question;
	}

	public static function get_single_data($id){
		$result = DB::table('question')->where('id_question',$id)->first();
		return $result;
	}

	public static function update($id, $request){
		$question = DB::table('question')
						->where('id_question',$id)
						->update([
							'title'			=> $request['title'],
							'description' 	=> $request['description']
						]);
		return $question;
	}

	public static function delete($id){
		$deleted = DB::table('question')->where('id_question',$id)->delete();
		return $deleted;
	}


}
?>