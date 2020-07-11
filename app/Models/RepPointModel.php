<?php
namespace App\Models;
use Illuminate\Support\Facades\DB;

class RepPointModel{

	public static function get_point_by_id($id){
		$question = DB::table('rep_points')->where('id',$id)->sum('point');
		return $question;
	}

	public static function save($data){
		$new_question = DB::table('rep_points')->insert($data);
		return $new_question;
	}

	public static function update($request){
		$rep = DB::table('rep_points')
		->where([
			['id_voter', $request['id_voter']],
			['id_answer', $request['id_answer']]
		])
		->update([
			'value'	=> $request['value'],
			'updated_at' => date("Y-m-d H:i:s")
		]);
		return $rep;
	}

	public static function delete($transaction){
		$deleted = DB::table('rep_points')
		->where('transaction', $transaction)
		->delete();
		return $deleted;
	}

}