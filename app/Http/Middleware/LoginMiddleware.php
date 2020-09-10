<?php

namespace App\Http\Middleware;

use Closure;
use App\Users;
class LoginMiddleware
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
        $ses_idが空のときはログインページに飛ばす
        値が存在するときは処理を続ける
        */
        $ses_id = $request->session()->get('id');
        $ses_time = $request->session()->get('time');
        if(empty($ses_id)){
            return redirect()->route('main.login');
        }
        //この先、$ses_idが存在しているとき
        //ログインしている状態が1時間続くと自動的にログアウト
        if($ses_time+3600<=time()){
            return redirect()->route('main.login');
        }
        $user=Users::where('id',$ses_id)->first();
        $name=$user->getName();
        $request->merge(['name'=>$name]);

        return $next($request);
    }
}
