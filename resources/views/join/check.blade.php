<!-- 新規登録（確認画面） -->
@extends('layouts.kakeibotemp')

@section('title','確認画面｜')

@section('main')
<div class="main-input">
      <h2>確認画面</h2>
  
      <form action="{{route('join.thanks')}}" method="post">
      {{ csrf_field() }}
      <!-- hiddenがない場合の問題点
            check.phpの「登録する」ボタンを押して初めてDBに格納
            ↑を確認するため///register.phpではif(!empty($_POST))でPOSTしているか確認できる
            確認画面のcheck.phpではフォームの内容がないのでPOSTがあるかどうかの判断が難しい
            下のhiddenは「送信しています」という合図→確認画面でも「登録」をクリックしたかどうかを簡単に判断できる
       -->
        <input type="hidden" name="action" value="submit">
        <input type="hidden" name="name" value="{{$name}}">
        <input type="hidden" name="email" value="{{$email}}">
        <input type="hidden" name="password" value="{{$password}}">
        <input type="hidden" name="sex" value="{{$sex}}">
        <input type="hidden" name="year" value="{{$year}}">
        <input type="hidden" name="month" value="{{$month}}">
        <input type="hidden" name="day" value="{{$day}}">
        <input type="hidden" name="image" value="{{$image}}">
        <input type="hidden" name="icon" value="{{$icon}}">
        <dl>
          <dt>●ニックネーム</dt>
          <dd>{{$name}}</dd>
          <dt>●メールアドレス</dt>
          <dd>{{$email}}</dd>
          <dt>●パスワード</dt>
          <dd>表示されません</dd>
          <dt>●性別</dt>
          <dd>{{$sex}}</dd>
          <dt>●生年月日</dt>
          <dd>{{$year}}年{{$month}}月{{$day}}日</dd>
          <dt>●アイコン</dt>
          <dd>
          @if($icon=='')
              <img class="main-input__check-image" src="{{asset('mem_pic/noImage.png')}}">
          @elseif($icon!='')
              <img class="main-input__check-image" src="{{asset($icon)}}">
          @endif
          </dd>
        </dl>
        <!-- <a href="/signup?action=rewrite" class="button button--rewrite">書き直す</a> -->
        <input name="back" type="submit" value="戻る" class="main-input__button button button--rewrite">
        <button class="main-input__button button button--register">登録する</button>
  
      </form>

    </div>

@endsection