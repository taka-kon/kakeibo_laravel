<?php

use Illuminate\Support\Facades\Route;

use App\Http\Middleware\LoginMiddleware;
use App\Http\Middleware\DisplayIconMiddleware;
use App\Http\Middleware\Graph3mMiddleware;
use App\Http\Middleware\Graph6mMiddleware;

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
//アカウント設定画面
Route::get('page/setting',[
    'uses'=>'JoinController@set',
    'as'=>'join.setting'
])->middleware('login','icon');
//アカウントデータ変更
Route::post('page/setting/change',[
    'uses'=>'JoinController@change',
    'as'=>'join.change'
]);
//アカウント削除
Route::post('page/account-remove',[
    'uses'=>'JoinController@delete_user',
    'as'=>'join.remove'
]);
//ログイン画面
Route::get('login',[
    'uses'=>'MainController@login',
    'as'=>'main.login'
]);
//ログイン処理
Route::post('login/post',[
    'uses'=>'MainController@loginpost',
    'as'=>'main.loginpost'
]);
//管理画面
Route::get('page',[
    'uses'=>'MainController@index',
    'as'=>'main.index'
])->middleware('login','icon','graph3m','graph6m');
//記録更新
Route::post('page/inputed',[
    'uses'=>'MainController@post',
    'as'=>'main.post'
]);
//expensesテーブルのレコード削除（取消ボタン）
Route::get('page/delete/{id}',[
    'uses'=>'MainController@delete',
    'as'=>'main.delete'
]);
//ログアウト
Route::get('logout',[
    'uses'=>'MainController@logout',
    'as'=>'main.logout'
]);
