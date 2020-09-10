<!-- 新規登録（確認画面） -->
@extends('layouts.kakeibotemp')

@section('title','ログイン｜')

@section('main')
<div class="main-input">
<ul>
	            @foreach ($errors->all() as $error)
	                <li>{{ $error }}</li>
	            @endforeach
	        </ul>
    <p class="error">{{session('msg')}}</p>
    <h2 class="main-input__title">ログイン</h2>
    <p class="error"></p>
    <form action="{{route('main.loginpost')}}" method="post">
    @csrf
      <dl>
        <dt class="main-input__headline">●メールアドレス</dt>
        <dd>
          <input type="text" name="email" id="" class="main-input__form" maxlength="255" value="{{$email}}{{old('email')}}">
          
        </dd>
  
        <dt class="main-input__headline">●パスワード</dt>
        <dd>
          <input type="password" name="password" id="" class="main-input__form" maxlength="100" value="{{old('password')}}">
          @if($errors->has('email'))
          <p class="error">{{$errors->first('email')}}</p>
          @endif
          @if($errors->has('password'))
          <p class="error">{{$errors->first('password')}}</p>
          @endif
        </dd>
  
        <dt class="main-input__headline"></dt>
        <dd>
          <input type="checkbox" name="save" value="on">
          <label for="save">次回から自動的にログインする</label>
        </dd>
      </dl>
      <button class="button button--login">ログイン</button>
    </form>

    <a href="{{route('join.index')}}">新規登録はこちら</a>
  </div>

@endsection