<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\VoteQuestionModel;
use App\Models\RepPointModel;

class VoteQuestionController extends Controller {

    public function __construct(){
        $this->middleware('auth');
    }
    
    public function store(Request $request,$id_question){
        $user = Auth::user();
        $id_voter = Auth::id();

        $id_user = $request->input('id');
        if ($request->input('val') == 'up') {
            $value = 1;
        }elseif($request->input('val') == 'down'){
            $value = 0;
        }elseif($request->input('val') == 'clear_like'){ //jika val = clear
            $value = -1;
            $clearvote = VoteQuestionModel::delete_by_voter($id_question,$id_voter);
            $rp = array(
                'transaction'=> "Undo like by in question:". $id_question,
                'point'=> -10,
                'id' => $request->input('id'),
                'created_at' => date("Y-m-d H:i:s"),
                'updated_at' => date("Y-m-d H:i:s")
            );
        }else{
            $value = -2;
            $clearvote = VoteQuestionModel::delete_by_voter($id_question,$id_voter);
            $rp = array(
                'transaction'=> "Undo dislike by in question:". $id_question,
                'point'=> 1,
                'id' => $id_voter,
                'created_at' => date("Y-m-d H:i:s"),
                'updated_at' => date("Y-m-d H:i:s")
            );
        }

        $data = array(
          'id_voter'=>$id_voter,
          'id_question'=>$id_question,
          'value' => $value);

        //cek untuk menghindari redundansi
        $check = VoteQuestionModel::check_data($id_question,$id_voter);

        if (!isset($check)) {
            if ($value == 1) {
                $addvote = VoteQuestionModel::save($data);
                $rp = array(
                    'transaction'=> "Liked in question:". $id_question,
                    'point'=> 10,
                    'id' => $request->input('id'),
                    'created_at' => date("Y-m-d H:i:s"),
                    'updated_at' => date("Y-m-d H:i:s")
                );
            }elseif ($value == 0){
                $addvote = VoteQuestionModel::save($data);
                $rp = array(
                    'transaction'=> "Disliked in question:". $id_question,
                    'point'=> -1,
                    'id' => $id_voter,
                    'created_at' => date("Y-m-d H:i:s"),
                    'updated_at' => date("Y-m-d H:i:s")
                );
            }
        }else{
            if ($check->value != $value) {
                if ($value == 1) {
                    $vote = VoteQuestionModel::update($data);
                    $rp = array(
                        [
                            'transaction'=> "Change to liked in question:". $id_question,
                            'point'=> 10,
                            'id' => $request->input('id'),
                            'created_at' => date("Y-m-d H:i:s"),
                            'updated_at' => date("Y-m-d H:i:s")
                        ],
                        [
                            'transaction'=> "Change to liked in question:". $id_question,
                            'point'=> 1,
                            'id' => $id_voter,
                            'created_at' => date("Y-m-d H:i:s"),
                            'updated_at' => date("Y-m-d H:i:s")
                        ]
                    );
                }elseif($value == 0){
                    $vote = VoteQuestionModel::update($data);
                    $rp = array(
                        [
                            'transaction'=> "Change to disliked in question:". $id_question,
                            'point'=> -10,
                            'id' => $request->input('id'),
                            'created_at' => date("Y-m-d H:i:s"),
                            'updated_at' => date("Y-m-d H:i:s")
                        ],
                        [
                            'transaction'=> "Change to disliked in question:". $id_question,
                            'point'=> -1,
                            'id' => $id_voter,
                            'created_at' => date("Y-m-d H:i:s"),
                            'updated_at' => date("Y-m-d H:i:s")
                        ]
                    );
                }
            }
        }
        
        $save_point = RepPointModel::save($rp);
        return redirect()->action('AnswerController@index',$id_question);
    }
}
