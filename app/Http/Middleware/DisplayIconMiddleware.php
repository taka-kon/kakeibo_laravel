<?php

namespace App\Http\Middleware;

use Closure;

use App\Users;

class DisplayIconMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        /*
        セッションを保存する処理
        /page/のとき　必要(main.index)
        /page/inputed/のとき　いらない
        */
        $now_route = \Route::currentRouteName();    //現在のルート取得
        // if($now_route=="main.index"){
        //     $id = Users::where('email', $request->email)->where('password', $request->password)->value('id');
        //     $request->session()->put('id',$id);
        // }

        $ses_id = $request->session()->get('id');
        // dump($ses_id);
        // dd("iconミドルウェアです");
        /*アイコン 
        概要：変数にパスの文字列を代入
        文字列"mem_pic/$ses_id/icon.xx"を送る
        asset('mem_pic/$ses_id/ファイル名')
        */
        //1.idフォルダまでのパスを取得(後のif文で使う)
        $pass_id='\\mem_pic\\'.$ses_id;
        // dd($ses_id);
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

        $request->merge(['icon_pass'=>$icon_pass]);
        return $next($request);
    }
}
