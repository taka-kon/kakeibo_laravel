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
            /*
                expensesテーブルのレコードを新しい順に取得
            */
            $items=Expense::where('user_id',$ses_id)->orderBy('created_at','desc')->get();
            $sum3m="";
            $sum3m_eat="";
            $sum3m_live="";
            $sum3m_reja="";
            $sum3m_kotu="";
            $sum3m_kote="";
            $sum3m_other="";
            /*
            更に省略できそうか
            for文をforeachで囲う
            上の配列変数をジャンル名をキーとした配列にする
             */
            $genres=[
                '合計'=>$sum3m,
                '食費'=>$sum3m_eat,
                '日用品費'=>$sum3m_live,
                'レジャー費'=>$sum3m_reja,
                '交通費'=>$sum3m_kotu,
                '固定費'=>$sum3m_kote,
                'その他'=>$sum3m_other,
            ];
            $sum3m_array=[
            ];
            foreach($genres as $genre => $genre_sum){
                for($i=-2;$i<=0;$i++){
                    $now=date("Y-m",strtotime("$i month"));
                    //自分のidに絞り、今月と等しい月のレコードを取得
                    if($genre=="合計"){
                        $record=Expense::where('user_id',$ses_id)->where('day','like','%'.$now.'%')->get(['minus'])->toArray();
                    }else{
                        $record=Expense::where('user_id',$ses_id)->where('genre',$genre)->where('day','like','%'.$now.'%')->get(['minus'])->toArray();
                    }
                    // dd($record);
                    $sum=0;
                    for($j=0;$j<count($record);$j++){
                        $sum+=$record[$j]['minus'];
                    }
                    // dump($sum);
                    $genre_sum.=$sum.",";
                    if($genre=="合計" &&  $i==0){
                        //マイページ上部に表示する今月合計出費額を格納する
                        $sum_header=$sum;
                    }
                }
                // dd($sum);
                // dump($genre_sum);
                $sum3m_array+=
                    [$genre=>$genre_sum];
                
            }        
            
            

            $sum6m="";
            $sum6m_eat="";
            $sum6m_live="";
            $sum6m_reja="";
            $sum6m_kotu="";
            $sum6m_kote="";
            $sum6m_other="";
            /*
            更に省略できそうか
            for文をforeachで囲う
            上の配列変数をジャンル名をキーとした配列にする
             */
            $genres=[
                '合計'=>$sum6m,
                '食費'=>$sum6m_eat,
                '日用品費'=>$sum6m_live,
                'レジャー費'=>$sum6m_reja,
                '交通費'=>$sum6m_kotu,
                '固定費'=>$sum6m_kote,
                'その他'=>$sum6m_other,
            ];
            $sum6m_array=[
            ];
            foreach($genres as $genre => $genre_sum){
                for($i=-5;$i<=0;$i++){
                    $now=date("Y-m",strtotime("$i month"));
                    //自分のidに絞り、今月と等しい月のレコードを取得
                    if($genre=="合計"){
                        $record=Expense::where('user_id',$ses_id)->where('day','like','%'.$now.'%')->get(['minus'])->toArray();
                    }else{
                        $record=Expense::where('user_id',$ses_id)->where('genre',$genre)->where('day','like','%'.$now.'%')->get(['minus'])->toArray();
                    }
                    // dd($record);
                    $sum=0;
                    for($j=0;$j<count($record);$j++){
                        $sum+=$record[$j]['minus'];
                    }
                    // dump($sum);
                    $genre_sum.=$sum.",";
                    if($genre=="合計" &&  $i==0){
                        //マイページ上部に表示する今月合計出費額を格納する
                        $sum_header=$sum;
                    }
                }
                // dd($sum);
                // dump($genre_sum);
                $sum6m_array+=
                    [$genre=>$genre_sum];
            }            
    
            

            
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
    public function post(Request $request){
        $ses_id=$request->session()->get('id');
        // dd($request->date);
        $input = new Expense;
        $input->user_id = $ses_id;
        $input->day = $request->date;
        $input->genre = $request->genre;
        $input->minus = $request->minus;
        $input->save();

        // $sql = "SELECT * FROM expenses WHERE DATE_FORMAT(day,'%Y%m')=DATE_FORMAT(NOW(),'%Y%m') and user_id=?";
        // $now_mon= $db->prepare($sql);
        // $now_mon->execute(array(
        // $ses_id,
        // ));
        // $now_month=$now_mon->fetchAll();
        // dd($now_month);

        //ログインユーザid取得
      $name = Users::where('id',$ses_id)->value('name');

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
    $items=Expense::where('user_id',$ses_id)->orderBy('created_at','desc')->get();

    //以下は今月分の出費合計を算出する処理
    $now=now();
    $n=$now->format('Y-m');
    //自分のidに絞り、今月と等しい月のレコードを取得
    $record=Expense::where('user_id',$ses_id)->where('day','like','%'.$n.'%')->get(['minus'])->toArray();
    $sum=0;
    for($i=0;$i<count($record);$i++){
        $sum+=$record[$i]['minus'];
    }

    $sum3m="";
            $sum3m_eat="";
            $sum3m_live="";
            $sum3m_reja="";
            $sum3m_kotu="";
            $sum3m_kote="";
            $sum3m_other="";
            /*
            更に省略できそうか
            for文をforeachで囲う
            上の配列変数をジャンル名をキーとした配列にする
             */
            $genres=[
                '合計'=>$sum3m,
                '食費'=>$sum3m_eat,
                '日用品費'=>$sum3m_live,
                'レジャー費'=>$sum3m_reja,
                '交通費'=>$sum3m_kotu,
                '固定費'=>$sum3m_kote,
                'その他'=>$sum3m_other,
            ];
            $sum3m_array=[
            ];
            foreach($genres as $genre => $genre_sum){
                for($i=-2;$i<=0;$i++){
                    $now=date("Y-m",strtotime("$i month"));
                    //自分のidに絞り、今月と等しい月のレコードを取得
                    if($genre=="合計"){
                        $record=Expense::where('user_id',$ses_id)->where('day','like','%'.$now.'%')->get(['minus'])->toArray();
                    }else{
                        $record=Expense::where('user_id',$ses_id)->where('genre',$genre)->where('day','like','%'.$now.'%')->get(['minus'])->toArray();
                    }
                    // dd($record);
                    $sum=0;
                    for($j=0;$j<count($record);$j++){
                        $sum+=$record[$j]['minus'];
                    }
                    // dump($sum);
                    $genre_sum.=$sum.",";
                    if($genre=="合計" &&  $i==0){
                        //マイページ上部に表示する今月合計出費額を格納する
                        $sum_header=$sum;
                    }
                }
                // dd($sum);
                // dump($genre_sum);
                $sum3m_array+=
                    [$genre=>$genre_sum];
                
            }        
            
            

            $sum6m="";
            $sum6m_eat="";
            $sum6m_live="";
            $sum6m_reja="";
            $sum6m_kotu="";
            $sum6m_kote="";
            $sum6m_other="";
            /*
            更に省略できそうか
            for文をforeachで囲う
            上の配列変数をジャンル名をキーとした配列にする
             */
            $genres=[
                '合計'=>$sum6m,
                '食費'=>$sum6m_eat,
                '日用品費'=>$sum6m_live,
                'レジャー費'=>$sum6m_reja,
                '交通費'=>$sum6m_kotu,
                '固定費'=>$sum6m_kote,
                'その他'=>$sum6m_other,
            ];
            $sum6m_array=[
            ];
            foreach($genres as $genre => $genre_sum){
                for($i=-5;$i<=0;$i++){
                    $now=date("Y-m",strtotime("$i month"));
                    //自分のidに絞り、今月と等しい月のレコードを取得
                    if($genre=="合計"){
                        $record=Expense::where('user_id',$ses_id)->where('day','like','%'.$now.'%')->get(['minus'])->toArray();
                    }else{
                        $record=Expense::where('user_id',$ses_id)->where('genre',$genre)->where('day','like','%'.$now.'%')->get(['minus'])->toArray();
                    }
                    // dd($record);
                    $sum=0;
                    for($j=0;$j<count($record);$j++){
                        $sum+=$record[$j]['minus'];
                    }
                    // dump($sum);
                    $genre_sum.=$sum.",";
                    if($genre=="合計" &&  $i==0){
                        //マイページ上部に表示する今月合計出費額を格納する
                        $sum_header=$sum;
                    }
                }
                // dd($sum);
                // dump($genre_sum);
                $sum6m_array+=
                    [$genre=>$genre_sum];
            }            
    

      $data=[
        'icon'=>$icon_pass,
        'name'=>$name,
        'date'=>$date,
        'items'=>$items,
        'sum'=>$sum_header,
        'sum3m'=>$sum3m_array,
        'sum6m'=>$sum6m_array,
      ];
        return view("main.index",$data);
    }


    //更新の取消
    public function delete(Request $request,$id){
        Expense::find($id)->delete();

        $ses_id=$request->session()->get('id');
          //ログインユーザid取得
      $name = Users::where('id',$ses_id)->value('name');

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
    $items=Expense::where('user_id',$ses_id)->orderBy('created_at','desc')->get();

    //以下は今月分の出費合計を算出する処理
    $now=now();
    $n=$now->format('Y-m');
    //自分のidに絞り、今月と等しい月のレコードを取得
    $record=Expense::where('user_id',$ses_id)->where('day','like','%'.$n.'%')->get(['minus'])->toArray();
    $sum=0;
    for($i=0;$i<count($record);$i++){
        $sum+=$record[$i]['minus'];
    }


    $sum3m="";
    $sum3m_eat="";
    $sum3m_live="";
    $sum3m_reja="";
    $sum3m_kotu="";
    $sum3m_kote="";
    $sum3m_other="";
    /*
    更に省略できそうか
    for文をforeachで囲う
    上の配列変数をジャンル名をキーとした配列にする
        */
    $genres=[
        '合計'=>$sum3m,
        '食費'=>$sum3m_eat,
        '日用品費'=>$sum3m_live,
        'レジャー費'=>$sum3m_reja,
        '交通費'=>$sum3m_kotu,
        '固定費'=>$sum3m_kote,
        'その他'=>$sum3m_other,
    ];
    $sum3m_array=[
    ];
    foreach($genres as $genre => $genre_sum){
        for($i=-2;$i<=0;$i++){
            $now=date("Y-m",strtotime("$i month"));
            //自分のidに絞り、今月と等しい月のレコードを取得
            if($genre=="合計"){
                $record=Expense::where('user_id',$ses_id)->where('day','like','%'.$now.'%')->get(['minus'])->toArray();
            }else{
                $record=Expense::where('user_id',$ses_id)->where('genre',$genre)->where('day','like','%'.$now.'%')->get(['minus'])->toArray();
            }
            // dd($record);
            $sum=0;
            for($j=0;$j<count($record);$j++){
                $sum+=$record[$j]['minus'];
            }
            // dump($sum);
            $genre_sum.=$sum.",";
            if($genre=="合計" &&  $i==0){
                //マイページ上部に表示する今月合計出費額を格納する
                $sum_header=$sum;
            }
        }
        // dd($sum);
        // dump($genre_sum);
        $sum3m_array+=
            [$genre=>$genre_sum];
        
    }        
    
    

    $sum6m="";
    $sum6m_eat="";
    $sum6m_live="";
    $sum6m_reja="";
    $sum6m_kotu="";
    $sum6m_kote="";
    $sum6m_other="";
    /*
    更に省略できそうか
    for文をforeachで囲う
    上の配列変数をジャンル名をキーとした配列にする
        */
    $genres=[
        '合計'=>$sum6m,
        '食費'=>$sum6m_eat,
        '日用品費'=>$sum6m_live,
        'レジャー費'=>$sum6m_reja,
        '交通費'=>$sum6m_kotu,
        '固定費'=>$sum6m_kote,
        'その他'=>$sum6m_other,
    ];
    $sum6m_array=[
    ];
    foreach($genres as $genre => $genre_sum){
        for($i=-5;$i<=0;$i++){
            $now=date("Y-m",strtotime("$i month"));
            //自分のidに絞り、今月と等しい月のレコードを取得
            if($genre=="合計"){
                $record=Expense::where('user_id',$ses_id)->where('day','like','%'.$now.'%')->get(['minus'])->toArray();
            }else{
                $record=Expense::where('user_id',$ses_id)->where('genre',$genre)->where('day','like','%'.$now.'%')->get(['minus'])->toArray();
            }
            // dd($record);
            $sum=0;
            for($j=0;$j<count($record);$j++){
                $sum+=$record[$j]['minus'];
            }
            // dump($sum);
            $genre_sum.=$sum.",";
            if($genre=="合計" &&  $i==0){
                //マイページ上部に表示する今月合計出費額を格納する
                $sum_header=$sum;
            }
        }
        // dd($sum);
        // dump($genre_sum);
        $sum6m_array+=
            [$genre=>$genre_sum];
    }      

      $data=[
        'icon'=>$icon_pass,
        'name'=>$name,
        'date'=>$date,
        'items'=>$items,
        'sum'=>$sum_header,
        'sum3m'=>$sum3m_array,
        'sum6m'=>$sum6m_array,
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
