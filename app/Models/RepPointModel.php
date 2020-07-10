<?php
namespace App\Models;
use Illuminate\Support\Facades\DB;

class RepPointModel{
	public static function get_point_by_id($id){
		$result = DB::table('rep_points')->where('id',$id)->sum('point');
		return $result;
	}

	public static function save($data){
		$new_result = DB::table('rep_points')->insert($data);
		return $new_result;
	}

	public static function update($request){
		$result = DB::table('rep_points')
		->where([
			['id_voter', $request['id_voter']],
			['id_answer', $request['id_answer']]
		])
		->update([
			'value'	=> $request['value']
		]);
		return $result;
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