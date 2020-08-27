<?php

use Illuminate\Support\Facades\Route;

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
//ログイン
Route::get('login',[
    'uses'=>'MainController@login',
    'as'=>'main.login'
]);
//管理画面
Route::get('page',[
    'uses'=>'MainController@index',
    'as'=>'main.index'
]);
//記録更新
Route::post('page',[
    'uses'=>'MainController@index',
    'as'=>'main.index'
]);

//ログアウト
Route::get('logout',[
    'uses'=>'MainController@logout',
    'as'=>'main.logout'
]);
