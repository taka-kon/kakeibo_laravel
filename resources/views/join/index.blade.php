<!-- 新規登録（入力ページ） -->
@extends('layouts.kakeibotemp')

@section('title','登録｜')

@section('main')
<div class="main-input">
    <h2 class="main-input__title">新規登録</h2>
    

  <form action="" method="post" class="form" enctype="multipart/form-data">
    <dl>
      <dt class="main-input__headline">●ニックネーム</dt>
      <dd class="main-input__tag-dd">
        <input type="text" name="name" id="" class="main-input__form" maxlength="255" value="">
      </dd>

      <dt class="main-input__headline">●メールアドレス</dt>
      <dd class="main-input__tag-dd">
        <input type="text" name="email" id="" class="main-input__form" maxlength="255" value="">
      </dd>

      <dt class="main-input__headline">●パスワード</dt>
      <dd class="main-input__tag-dd">
        <input type="password" name="password" id="" class="main-input__form" maxlength="100" value="">
      </dd>

      <dt class="main-input__headline">●性別</dt>
      <dd class="main-input__tag-dd">
        
        <input type="radio" name="sex" id="" value="1" >男性
        <input type="radio" name="sex" id="" value="2" >女性
        <input type="radio" name="sex" id="" value="3" >その他
        
      </dd>

      <dt class="main-input__headline">生年月日</dt>
      <dd class="main-input__tag-dd">

      <select name="year" class="main-input__select">'
        <option value="0">-----年</option>
        <option value="1960">1960年</option>
      </select>
      <select name="month" class="main-input__select">
        <option value="0">--月</option>
        <option value="1">1月</option>
      </select>
      <select name="day" class="main-input__select">
        <option value="0">--日</option>
        <option value="1">1日</option>
      </select>

      </dd>
      <dt>●アイコン画像</dt>
      <dd>
        <input type="file" name="image" value="test" />
      </dd>

    </dl>
    <button class="button button--register">確認画面へ</button>
  </form>

  <a href="login.php">ログインページへ</a>
  </div>

@endsection