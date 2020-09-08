<?php

namespace App\Http\Middleware;

use Closure;
use App\Expense;
class AddExpenseMiddleware
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
        $ses_id = $request->session()->get('id');
        
        $input = new Expense;
        $input->user_id = $ses_id;
        $input->day = $request->date;
        $input->genre = $request->genre;
        $input->minus = $request->minus;
        $input->save();
        return $next($request);
    }
}
