<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\CommentAnswerModel;
use App\Models\AnswerModel;

class CommentAnswerController extends Controller 
{
	public function __construct(){
		$this->middleware('auth');
	}

	public function store(Request $request, $id_answer){
        $user = Auth::user();
        // dd($request->all());
        $id_user = Auth::id();
        $id_question = $request->input('id_question');
    	$content = $request->input('content');
    	$data = array(
    		'id_answer'=>$id_answer,
    		'content'=>$content,
    		'id' => $id_user
    	);
    	$comment = CommentAnswerModel::save($data);
    	return redirect()->action('AnswerController@index',$id_question);
    }

    public function destroy(Request $request) {
        $data = $request->all();
        $deleted = CommentAnswerModel::destroy($data['id_comment']);
        return redirect()->action('AnswerController@index', $data['id_question']);
    }
}
