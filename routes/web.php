<?php

use Illuminate\Support\Facades\Route;
use App\Http\Middleware\DisplayIconMiddleware;
use App\Http\Middleware\Graph3mMiddleware;
use App\Http\Middleware\Graph6mMiddleware;
use App\Http\Middleware\AddExpenseMiddleware;
use App\Http\Middleware\DeleteExpenseMiddleware;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

//登録ページ
Route::get('signup',[
    'uses' => 'JoinController@index',
    'as'=>'join.index'
]);
//登録確認
Route::post('signup/check',[
    'uses'=>'JoinController@post',
    'as'=>'join.check'
]);
//登録完了
Route::post('signup/finish',[
    'uses'=>'JoinController@finish',
    'as'=>'join.thanks'
]);
Route::get('page/setting',[
    'uses'=>'JoinController@set',
    'as'=>'join.setting'
]);
//ログイン
Route::get('login',[
    'uses'=>'MainController@login',
    'as'=>'main.login'
]);

//管理画面
Route::post('page',[
    'uses'=>'MainController@index',
    'as'=>'main.index'
])->middleware('icon','graph3m','graph6m');
//記録更新
Route::post('page/inputed',[
    'uses'=>'MainController@post',
    'as'=>'main.post'
])->middleware('add','icon','graph3m','graph6m');
//expensesテーブルのレコード削除（取消ボタン）
Route::get('page/delete/{id}',[
    'uses'=>'MainController@delete',
    'as'=>'main.delete'
])->middleware('delete','icon','graph3m','graph6m');
//ログアウト
Route::get('logout',[
    'uses'=>'MainController@logout',
    'as'=>'main.logout'
]);
