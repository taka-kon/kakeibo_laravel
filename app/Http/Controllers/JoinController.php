<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\SignupRequest;

class JoinController extends Controller
{
    public function index(Request $request){
        return view('join.index',['msg'=>'フォームを入力']);
    }

    public function post(SignupRequest $request){
        return view('join.index',['msg'=>'正しく入力されました！']);
    }
}
