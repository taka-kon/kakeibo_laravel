<?php

namespace App\Http\Middleware;

use Closure;
use App\Users;
use App\Expense;
class Graph6mMiddleware
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
        $now_route = \Route::currentRouteName();    //現在のルート取得
        if($now_route=="main.index"){
            $id = Users::where('email', $request->email)->where('password', $request->password)->value('id');
            $request->session()->put('id',$id);
        }

        $ses_id = $request->session()->get('id');

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
            $sum6m_array+=
            [$genre=>$genre_sum];
        }            

        $request->merge(['sum6m'=>$sum6m_array,'sum_header'=>$sum_header]);
        return $next($request);
    }
}
