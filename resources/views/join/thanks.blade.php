@extends('layouts.kakeibotemp')

@section('title','登録完了｜')

@section('main')
<div class="main-input">
  <h2>登録が完了しました。</h2>
  <form action="{{route('main.loginpost')}}" method="post">
    @csrf
    <input type="hidden" name="email" value="{{$email}}">
    <input type="hidden" name="password" value="{{$password}}">
    <button class="main-input__button button button--try">早速使ってみる！</button>

  </form>

</div>

@endsection