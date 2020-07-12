<?php
namespace App\Models;
use Illuminate\Support\Facades\DB;

class CommentQuestionModel{

	public static function get_by_id_question($id){
		$comments = DB::table('comment_questions')->join('users', 'users.id', '=', 'comment_questions.id')->where('id_question',$id)->select('comment_questions.*', 'name', 'photo')->orderBy('id_comment')->get();
		return $comments;
	}

	public static function save($data){
		$data['created_at'] = date("Y-m-d H:i:s");
		$new_comment = DB::table('comment_questions')->insert($data);
		return $new_comment;
	}

	public static function destroy($id_comment){
		$deleted = DB::table('comment_questions')->where('id_comment',$id_comment)->delete();
		return $deleted;
	}
	public static function destroy_by_id_question($id){
		$deleted = DB::table('comment_questions')->where('id_question',$id)->delete();
		return $deleted;
	}

}
?>