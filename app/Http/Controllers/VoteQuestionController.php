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
        }else{
            $value = 0;
        }
        $data = array(
          'id_voter'=>$id_voter,
          'id_question'=>$id_question,
          'value' => $value
        );

        //cek untuk menghindari redundansi
        $check = VoteQuestionModel::check_data($id_question,$data['id_voter']);
        if (!isset($check)) {
            $question = VoteQuestionModel::save($data);
            if ($value == 1) {
                $rp = array(
                    'transaction'=> "Liked in question:". $id_question,
                    'point'=> 10,
                    'id' => $request->input('id'),
                    'created_at' => date("Y-m-d H:i:s"),
                    'updated_at' => date("Y-m-d H:i:s")
                );
            }else{
                $rp = array(
                    'transaction'=> "Disliked by in question:". $id_question,
                    'point'=> -1,
                    'id' => $id_voter,
                    'created_at' => date("Y-m-d H:i:s"),
                    'updated_at' => date("Y-m-d H:i:s")
                );
            }
            $save_point = RepPointModel::save($rp);

        }else{
         if ($check->value != $value) {
            $question = VoteQuestionModel::update($data);
            if ($value == 1) {
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
                }else{
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
            $save_point = RepPointModel::save($rp);
        }
    }
    return redirect()->action('AnswerController@index',$id_question);
}
}
