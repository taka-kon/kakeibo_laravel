<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use App\Http\Requests\LoginRequest;

use App\Users;
use App\Expense;

class MainController extends Controller
{
    public function login(Request $request){
        $ses_id = $request->session()->get('id');
        dump($ses_id);
        
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
            
            // dd($request->icon_pass);
            //ses_idを用いてUsersテーブルのレコードの値を取得
            //name
            $name = Users::where('id',$ses_id)->value('name');
            //アイコン画像をパス
            $icon_pass=$request->icon_pass;

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
            
            
            $data=[
                'ses_id'=>$ses_id,
                'time'=>$ses_time,
                'name'=>$name,
                'icon'=>$icon_pass,
                'date'=>$date,
                'items'=>$items,
                'sum'=>$sum_header,
                'sum3m'=>$sum3m_array,
                'sum6m'=>$sum6m_array,
            ];

            return view('main.index',$data);

            

        }else{
            return redirect('/login')->with('msg','* ログインに失敗しました');
        }
       

    }
    public function post(Request $request){
        $ses_id=$request->session()->get('id');


        //ログインユーザid取得
      $name = Users::where('id',$ses_id)->value('name');

    $icon_pass=$request->icon_pass;

      /*
    ユーザーページの日付の初期値を今日にしたい
    */
    $date=date("Y-m-d");
    $items=Expense::where('user_id',$ses_id)->orderBy('created_at','desc')->limit(5)->get();

    //以下は今月分の出費合計を算出する処理
    $now=now();
    $n=$now->format('Y-m');
    //自分のidに絞り、今月と等しい月のレコードを取得
    $record=Expense::where('user_id',$ses_id)->where('day','like','%'.$n.'%')->get(['minus'])->toArray();
    $sum=0;
    for($i=0;$i<count($record);$i++){
        $sum+=$record[$i]['minus'];
    }

    $sum3m_array=$request->sum3m;
    $sum6m_array=$request->sum6m;
    $sum_header=$request->sum_header; 
    $message = "出費を追加しました！";

      $data=[
        'icon'=>$icon_pass,
        'name'=>$name,
        'date'=>$date,
        'items'=>$items,
        'sum'=>$sum_header,
        'sum3m'=>$sum3m_array,
        'sum6m'=>$sum6m_array,
        'msg'=>$message,
      ];
        return view("main.index",$data);
    }


    //更新の取消
    public function delete(Request $request,$id){
        $ses_id=$request->session()->get('id');
          //ログインユーザid取得
      $name = Users::where('id',$ses_id)->value('name');

    $icon_pass=$request->icon_pass;

      /*
    ユーザーページの日付の初期値を今日にしたい
    */
    $date=date("Y-m-d");
    $items=Expense::where('user_id',$ses_id)->orderBy('created_at','desc')->limit(5)->get();

    //以下は今月分の出費合計を算出する処理
    $now=now();
    $n=$now->format('Y-m');
    //自分のidに絞り、今月と等しい月のレコードを取得
    $record=Expense::where('user_id',$ses_id)->where('day','like','%'.$n.'%')->get(['minus'])->toArray();
    $sum=0;
    for($i=0;$i<count($record);$i++){
        $sum+=$record[$i]['minus'];
    }

    $sum3m_array=$request->sum3m;
    $sum6m_array=$request->sum6m;
    $sum_header=$request->sum_header; 
    $message = "データを取り消しました！";

    

      $data=[
        'icon'=>$icon_pass,
        'name'=>$name,
        'date'=>$date,
        'items'=>$items,
        'sum'=>$sum_header,
        'sum3m'=>$sum3m_array,
        'sum6m'=>$sum6m_array,
        'msg'=>$message,
      ];
      
        return view('main.index',$data);
        // return redirect()->action('MainController@index');
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
