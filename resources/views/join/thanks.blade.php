@extends('layouts.kakeibotemp')

@section('title','登録完了｜')

@section('main')
<div class="main-input">
  <h2>登録が完了しました。</h2>
  <a href="{{route('main.login')}}">ログインする</a>

</div>

@endsection