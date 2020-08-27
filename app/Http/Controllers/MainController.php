<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\LoginRequest;

use App\Users;
use Illuminate\Support\Facades\Auth;

class MainController extends Controller
{
    public function login(Request $request){
        
        //クッキーemailが存在しない場合
        if(isset($_COOKIE['email'])){
            
            if($_COOKIE['email']!==''){
                //oldヘルパと重複しないように
                if(old('email')==NULL){
                    $email = $_COOKIE['email'];
                }else{
                    $email=NULL;
                }
            }
        }else{
            $email = "";
        }
         
          $data=[
              'email'=>$email,
          ];
        return view('main.login',$data);
    }

    public function index(LoginRequest $request){
        
        
        $email=$request->email;
        $password = $request->password;

        $e_array=array();   //DB中のemailを纏めた配列
        $pass_array=array();
        $users = Users::all();
        foreach($users as $user){
            array_push($e_array,$user->email);
            array_push($pass_array,$user->password);
        }
        
        //・email,passwordが両方DB上に存在するとき、
        // dd(in_array($request->email,$e_array)&&in_array($request->password,$pass_array));
        if(in_array($request->email,$e_array)&&in_array($request->password,$pass_array)){
            //入力したemail,passwordの文字列から一致したレコードのidを取得しセッションに保存し取得
            $id = Users::where('email', $request->email)->where('password', $request->password)->value('id');
            $request->session()->put('id',$id);
            $request->session()->put('time',time());
            $ses_id = $request->session()->get('id');
            $ses_time=$request->session()->get('time');
            

            //次回から自動的にログインにチェックを入れたら
            if($request->save=='on'){
                setcookie('email',$request->email,time()+60*60*24*14);
            }
            $cookie = $request->cookie('email');
            
            //ses_idを用いてUsersテーブルのレコードの値を取得
            //name
            $name = Users::where('id',$ses_id)->value('name');
            /*アイコン 
            概要：変数にパスの文字列を代入
            文字列"mem_pic/$ses_id/icon.xx"を送る
            asset('mem_pic/$ses_id/ファイル名')
            */
            //1.idフォルダまでのパスを取得(後のif文で使う)
            $pass_id='\\mem_pic\\'.$ses_id;
            //2."mem_pic/$ses_id/"にicon.jpg(jpeg,png)が存在するか？存在したら画像ファイル名の変数に代入
            if(file_exists(public_path().$pass_id.'\\icon.jpg')){
                $icon_name='icon.jpg';
            }elseif(file_exists(public_path().$pass_id.'\\icon.png')){
                $icon_name='icon.png';
            }elseif(file_exists(public_path().$pass_id.'\\icon.jpeg')){
                $icon_name='icon.jpeg';
            }
            //3.idまでのパスとファイル名が揃ったら連結し、送るパスが完成
            $icon_pass="mem_pic/".$ses_id."/".$icon_name;

            /*
            ユーザーページの日付の初期値を今日にしたい
            */
            $date=date("Y-m-d");
            if($request->isMethod('post')){
                $date=$request->date;
            }

            $data=[
                'ses_id'=>$ses_id,
                'time'=>$ses_time,
                'name'=>$name,
                'icon'=>$icon_pass,
                'date'=>$date,
            ];

            return view('main.index',$data);

            

        }else{
            return redirect('/login')->with('msg','* ログインに失敗しました');
        }
        /*
        ・●email,passwordが両方DB上に存在するとき、
        ・●入力したemail,passwordの文字列から一致したレコードを取り出す　入力値を挿入したSQL文
        ・レコードを変数に代入
        ・その変数を使い、$_SESSION['id']や$_SESSION['time']=time()に当たるものを作成
        ・「次回自動的にログイン」のinputの処理
            $_POST['save']がonのとき、emailのクッキーを作成し、有効期限内であれば自動的にログインできる

            入力したemailやpasswordがDBに無かったら、ログインページに飛ばす
        */

    }

    //ログアウト
    public function logout(Request $request){
        $session=$request->session()->flush();
        // dd($session);
        if(ini_set('session.use_cookies',0)){
            $params=session_get_cookie_params();
            setcookie(session_name().'',time()-42000,
              $params['path'],$params['domain'],$params['secure'],$params['httponly']
          );
          }

          setcookie('email','',time()-3600);
        return redirect()->route('main.login');
    } 
}
