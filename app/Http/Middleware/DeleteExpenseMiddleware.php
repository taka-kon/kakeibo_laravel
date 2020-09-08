<?php

namespace App\Http\Middleware;

use Closure;
use App\Expense;
class DeleteExpenseMiddleware
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
        //ルートパラメータを取得
        $id= $request->route()->parameter('id');
        Expense::find($id)->delete();
        return $next($request);
    }
}
