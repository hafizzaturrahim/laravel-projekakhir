<?php
namespace App\Models;
use Illuminate\Support\Facades\DB;

class RepPointModel{

	public static function get_point_by_id($id){
		$question = DB::table('rep_points')->where('id',$id)->sum('point');
		return $question;
	}

	public static function save($data){
		$data['created_at'] = date("Y-m-d H:i:s");
		$data['updated_at'] = date("Y-m-d H:i:s");
		$new_question = DB::table('rep_points')->insert($data);
		return $new_question;
	}

	public static function update($request){
		$question = DB::table('rep_points')
		->where([
			['id_voter', $request['id_voter']],
			['id_answer', $request['id_answer']]
		])
		->update([
			'value'	=> $request['value'],
			'updated_at' => date("Y-m-d H:i:s")
		]);
		return $question;
	}

	public static function delete($id_answer,$id_voter){
		$deleted = DB::table('rep_points')
		->where([
			['id_voter', $id_voter],
			['id_answer', $id_answer]
		])
		->delete();
		return $deleted;
	}


}
?>