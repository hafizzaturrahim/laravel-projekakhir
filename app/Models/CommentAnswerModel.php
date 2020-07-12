<?php
namespace App\Models;
use Illuminate\Support\Facades\DB;

class CommentAnswerModel{

	public static function get_all($id){
		$comments = DB::table('comment_answers')->join('users', 'users.id', '=', 'comment_answers.id')->select('comment_answers.*', 'name', 'photo')->get();
		return $comments;
	}

	public static function save($data){
		$data['created_at'] = date("Y-m-d H:i:s");
		$new_comment = DB::table('comment_answers')->insert($data);
		return $new_comment;
	}

	public static function destroy($id_comment){
		$deleted = DB::table('comment_answers')->where('id_comment',$id_comment)->delete();
		return $deleted;
	}

	public static function destroy_by_id_answer($id){
		$deleted = DB::table('comment_answers')->where('id_answer',$id)->delete();
		return $deleted;
	}

	public static function destroy_by_id_question($id_question){
		$answers = DB::table('answers')->where('id_question',$id_question)->get();
		foreach ($answers as $item) {
			$deleted = DB::table('comment_answers')->where('id_answer',$item->id_answer)->delete();
		}
		return $answers;
	}


}
?>