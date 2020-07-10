<?php
namespace App\Models;
use Illuminate\Support\Facades\DB;

class CommentAnswerModel{

	public static function get_all($id){
		$comments = DB::table('comment_answers')->get();
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

}
?>