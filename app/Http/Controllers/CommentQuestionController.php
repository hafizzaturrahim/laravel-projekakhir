<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\CommentQuestionModel;
use App\Models\QuestionModel;

class CommentQuestionController extends Controller 
{
	public function __construct(){
		$this->middleware('auth');
	}

	public function store(Request $request, $id){
        $user = Auth::user();
        $id_user = Auth::id();
    	$content = $request->input('content');
    	$data = array(
    		'id_question'=>$id,
    		'content'=>$content,
    		'id' => $id_user
    	);
    	$comment = CommentQuestionModel::save($data);
    	return redirect()->action('AnswerController@index',$id);
    }
}
