<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\SignupRequest;

use App\Users;

class JoinController extends Controller
{
    //フォーム表示
    public function index(Request $request){
        // $data=[
        //     'action'=>$request->action,
        // ];
        return view('join.index');
    }

    //確認画面
    public function post(SignupRequest $request){

        if(isset($request->image)){
            $icon_name = uniqid("ICON_") . "." . $request->file('image')->guessExtension(); // TMPファイル名
            $request->file('image')->move(public_path() . "/temp", $icon_name);
            $icon = "/temp/".$icon_name;
            
        }else{
            $icon='';
        }
        $data=[
            'name'=>$request->name,
            'email'=>$request->email,
            'password'=>$request->password,
            'sex'=>$request->sex,
            'year'=>$request->year,
            'month'=>$request->month,
            'day'=>$request->day,
            'image'=>$request->image,
            'icon' => $icon,
        ];
        
        return view('join.check')->with($data);
    }

    //登録完了画面
    public function finish(Request $request){
        //戻るボタンを押したら入力ページに戻る
        if ($request->get('back')) {
            return redirect('/signup')->withInput();
        }
        //メールアドレスの配列
        $email_db = Users::get(['email'])->toArray();
        
        //完了画面から確認画面に戻り、再度登録ボタンを押したとき、フォームに飛ばす
        if(in_array(['email'=>$request->email],$email_db)){
            return redirect('/signup');
        }else{
            $user = new Users;
            $user->name = $request->name;
            $user->email = $request->email;
            $user->password = $request->password;
            $user->sex = $request->sex;
    
            $year = $request->year;
            $month = $request->month;
            $day = $request->day;
            $birthday = array($year,$month,$day);
            $user->birthday = implode("-",$birthday);
            
            $user->save();
            
    
            //レコードを挿入したときのIDを取得
            $lastInsertedId = $user->id;
    
            //ディレクトリを作成
            if(!file_exists(public_path()."/mem_pic/".$lastInsertedId)){
                mkdir(public_path()."/mem_pic/".$lastInsertedId,0777);
            }
    
            /*
            本番の格納場所へ移動
            rename()...指定したファイル名を変更する（変更したいファイル名,変更後のファイル名）
            pathinfo()...ファイルパスに関する情報（調べたいパス,どの要素で返すか）、拡張子を返す
            '/temp/...jpg'→'/mem_pic/id/icon.jpg'
            ''→'/mem_pic/id/'
            */
            if(!empty($request->icon)){
                rename(public_path().$request->icon,public_path()."/mem_pic/".$lastInsertedId."/icon.".pathinfo($request->icon,PATHINFO_EXTENSION));
            }else{
                copy(public_path()."/mem_pic/noImage.png",public_path()."/mem_pic/".$lastInsertedId."/icon.png");
    
            }
    
            //$request->icon = /temp/....jpg
            return view('join.thanks');

        }
    }
    public function set(Request $request){
        $ses_id = $request->session()->get('id');
        dump($ses_id);
        if(empty($ses_id)){
            return redirect()->route('main.login');
        }
        return view('join.setting');
    }


}
