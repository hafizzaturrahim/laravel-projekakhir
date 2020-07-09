<?php
namespace App\Models;
use Illuminate\Support\Facades\DB;

class AnswerModel{
	public static function save($data){
		$new_answer = DB::table('answer')->insert($data);
		return $new_answer;
	}

	public static function get_data($id){
		$result = DB::table('answer')->where('id_question',$id)->get();
		return $result;
	}

	public static function delete($id){
		$deleted = DB::table('answer')->where('id_question',$id)->delete();
		return $deleted;
	}


}
?>