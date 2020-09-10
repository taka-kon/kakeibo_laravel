<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use App\Http\Requests\LoginRequest;
use App\Http\Requests\InputRequest;

use App\Users;
use App\Expense;

class MainController extends Controller
{
    public function login(Request $request){
        $ses_id = $request->session()->get('id');
        
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
    //ログイン処理
    public function loginpost(LoginRequest $request){
        $email=$request->email;
        $password = $request->password;
        $e_array=array();   //DB中のemailを纏めた配列
        $pass_array=array();
        $users = Users::all();
        foreach($users as $user){
            array_push($e_array,$user->email);
            array_push($pass_array,$user->password);
        }

          //・email,passwordが両方DB上に存在するとき、ユーザ画面にリダイレクト
        if(in_array($request->email,$e_array)&&in_array($request->password,$pass_array)){
            //入力したemail,passwordの文字列からユーザidを取得しセッションに保存し取得
            $id = Users::where('email', $request->email)->where('password', $request->password)->value('id');
            $request->session()->put('id',$id); //ユーザidをセッションに保存
            $request->session()->put('time',time());    //ログインした時刻も保存

            //次回から自動的にログインにチェックを入れたら
            if($request->save=='on'){
                setcookie('email',$request->email,time()+60*60*24*14);
            }

            return redirect()->route('main.index');
        }else{
            return redirect()->route('main.login');
        }
    }

    public function index(Request $request){
        $ses_id = $request->session()->get('id');
        //アイコン画像のパス
        $icon_pass=$request->icon_pass;
        $name=$request->name;   //名前
        /*
        ユーザーページの日付の初期値を今日にしたい
        */
        $date=date("Y-m-d");
        /*
            expensesテーブルのレコードを新しい順に取得
        */
        $items=Expense::where('user_id',$ses_id)->orderBy('created_at','desc')->limit(5)->get();

        $sum3m_array=$request->sum3m;
        $sum6m_array=$request->sum6m;
        $sum_header=$request->sum_header;
        // dump($ses_id);
        // dd("ユーザ画面です");
        
        
        $data=[
            'ses_id'=>$ses_id,
            // 'time'=>$ses_time,
            'name'=>$name,
            'icon'=>$icon_pass,
            'date'=>$date,
            'items'=>$items,
            'sum'=>$sum_header,
            'sum3m'=>$sum3m_array,
            'sum6m'=>$sum6m_array,
        ];

        return view('main.index',$data);
    }

    public function post(InputRequest $request){
        $ses_id = $request->session()->get('id');
        
        $input = new Expense;
        $input->user_id = $ses_id;
        $input->day = $request->date;
        $input->genre = $request->genre;
        $input->minus = $request->minus;
        $input->save();
        $msg="データを追加しました";
        return redirect()->route('main.index')->with('msg',$msg);
    }


    //更新の取消
    public function delete(Request $request,$id){
        //ルートパラメータを取得
        $id= $request->route()->parameter('id');
        Expense::find($id)->delete();
        $msg="データを削除しました";
        return redirect()->route('main.index')->with('msg',$msg);
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
