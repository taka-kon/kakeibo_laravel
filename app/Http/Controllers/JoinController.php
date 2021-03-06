<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\SignupRequest;

use App\Users;
use App\Expense;

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
            $key="njn393neicniebs3d67dnh8yh8t6btv6r56rrf";
            $user = new Users;
            $user->name = $request->name;
            $user->email = $request->email;
            $user->password = openssl_encrypt($request->password, 'AES-128-ECB', $key);
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
            $data=[
                'email'=>$request->email,
                'password'=>$request->password,
            ];
    
            //$request->icon = /temp/....jpg
            return view('join.thanks',$data);

        }
    }
    public function set(Request $request){
        $ses_id = $request->session()->get('id');
        $icon_pass=$request->icon_pass;
        // dump($ses_id);
        if(empty($ses_id)){
            return redirect()->route('main.login');
        }
        $data=[
            'icon'=>$icon_pass,
        ];
        return view('join.setting',$data);
    }

    public function change(Request $request){
        //処理後、アカウント設定ページに戻り、「変更しました」の趣旨のメッセージ表示
        $ses_id = $request->session()->get('id');
        if(!empty($request->name) || !empty($request->image)){
            if(!empty($request->name)){
                $user=Users::find($ses_id);
                $form=$request->name;
                $user->fill(['name'=>$form])->save();

                
            }
            if(!empty($request->image)){

                /*
                ファイルを消してから挿入する
                */
                // ファイル削除
                if(file_exists(public_path()."\\mem_pic\\".$ses_id."\\icon.jpg")){
                    unlink(public_path()."\\mem_pic\\".$ses_id."\\icon.jpg");

                }elseif(file_exists(public_path()."\\mem_pic\\".$ses_id."\\icon.png")){
                    unlink(public_path()."\\mem_pic\\".$ses_id."\\icon.png");

                }elseif(file_exists(public_path()."\\mem_pic\\".$ses_id."\\icon.jpeg")){
                    unlink(public_path()."\\mem_pic\\".$ses_id."\\icon.jpeg");
                }
                //ファイル挿入
                $icon_name = uniqid("ICON_") . "." . $request->file('image')->guessExtension(); // TMPファイル名
                $request->file('image')->move(public_path() . "/temp", $icon_name);
                $icon = "/temp/".$icon_name;
                rename(public_path().$icon,public_path()."/mem_pic/".$ses_id."/icon.".pathinfo($icon,PATHINFO_EXTENSION));
            }

            $msg="アカウント設定を変更しました。";
                return redirect()->route('join.setting')->with('msg',$msg);
        }
        return redirect()->route('join.setting');
    }
    public function delete_user(Request $request){
        /**
         * アイコンが保存されているディレクトリを削除
         * usersテーブルの内、ログインユーザのidのレコードと、同じ値のexpensesテーブルのuser_idカラムのレコードを全て取得
         * まずexpensesテーブルのレコードを削除、次にusersテーブルのレコードを削除
         * ログアウトでセッションも削除
         */
        $ses_id = $request->session()->get('id');
        //ディレクトリ中にあるアイコン画像を削除
        if(file_exists(public_path()."\\mem_pic\\".$ses_id."\\icon.jpg")){
            unlink(public_path()."\\mem_pic\\".$ses_id."\\icon.jpg");

        }elseif(file_exists(public_path()."\\mem_pic\\".$ses_id."\\icon.png")){
            unlink(public_path()."\\mem_pic\\".$ses_id."\\icon.png");

        }elseif(file_exists(public_path()."\\mem_pic\\".$ses_id."\\icon.jpeg")){
            unlink(public_path()."\\mem_pic\\".$ses_id."\\icon.jpeg");
        }
        //画像が無くなったところでディレクトリも削除
        rmdir(public_path()."\\mem_pic\\".$ses_id);
        // dump(public_path()."\\mem_pic\\".$ses_id);
        //$ses_idを取得、Expenseモデルでuser_idカラムが$ses_idのレコードを取り出して削除
        Expense::where('user_id',$ses_id)->delete();

        //Usersモデルでidカラムが$ses_idのレコードを取り出す。
        Users::where('id',$ses_id)->delete();
        //削除後、ログアウトにリダイレクトしてセッションも消す
        return redirect()->route('main.logout');
    }


}
