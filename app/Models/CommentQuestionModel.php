<?php
namespace App\Models;
use Illuminate\Support\Facades\DB;

class CommentQuestionModel{

	public static function get_by_id_question($id){
		$comments = DB::table('comment_questions')->get()->where('id_question',$id);
		return $comments;
	}

	public static function save($data){
		$data['created_at'] = date("Y-m-d H:i:s");
		$new_comment = DB::table('comment_questions')->insert($data);
		return $new_comment;
	}

	public static function delete($id){
		$deleted = DB::table('comment_questions')->where('id_question',$id)->delete();
		return $deleted;
	}

}
?>