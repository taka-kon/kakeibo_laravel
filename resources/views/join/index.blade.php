<!-- 新規登録（入力ページ） -->
@extends('layouts.kakeibotemp')

@section('title','登録｜')

@section('main')
<div class="main-input">
  @if (count($errors)>0)
    <p class="error">* 入力に誤りがあります。</p>
  @endif
    <h2 class="main-input__title">新規登録</h2>
    <p>「※」は必須項目です。</p>

  <form action="{{route('join.check')}}" method="post" class="main-input__forms" enctype="multipart/form-data">
  {{ csrf_field() }}
    <dl>
      <dt class="main-input__headline">※ニックネーム</dt>
      <dd class="main-input__tag-dd">
        <input type="text" name="name" id="" class="main-input__form" maxlength="255" value="{{old ('name') }}">
        @if($errors->has('name'))
          <p class="error">{{$errors->first('name')}}</p>
        @endif
      </dd>

      <dt class="main-input__headline">※メールアドレス</dt>
      <dd class="main-input__tag-dd">
        <input type="text" name="email" id="" class="main-input__form" maxlength="255" value="{{ old('email') }}">
        @if($errors->has('email'))
          <p class="error">{{$errors->first('email')}}</p>
        @endif
      </dd>

      <dt class="main-input__headline">※パスワード</dt>
      <dd class="main-input__tag-dd">
        <input type="password" name="password" id="" class="main-input__form" maxlength="100" value="{{ old('password') }}">
        @if($errors->has('password'))
          <p class="error">{{$errors->first('password')}}</p>
        @endif
      </dd>

      <dt class="main-input__headline">※性別</dt>
      <dd class="main-input__tag-dd">
        <input type="radio" name="sex" id="" value="男性" {{ old('sex') == '男性' ? 'checked' : ''}}>男性
        <input type="radio" name="sex" id="" value="女性" {{ old('sex') == '女性' ? 'checked' : ''}}>女性
        <input type="radio" name="sex" id="" value="その他"{{ old('sex') == 'その他' ? 'checked' : ''}}>その他
        @if($errors->has('sex'))
          <p class="error">{{$errors->first('sex')}}</p>
        @endif
        
      </dd>

      <dt class="main-input__headline">※生年月日</dt>
      <dd class="main-input__tag-dd">
      

      <select name="year" class="main-input__select">
        <option value="">-----年</option>
        @for($i=1960;$i<=date("Y");$i++)
        <option value="{{$i}}" {{ old('year') == $i ? 'selected' : ''}}>{{$i}}年</option>
        @endfor
      </select>
      <select name="month" class="main-input__select">
        <option value="">--月</option>
        @for($i=1;$i<=12;$i++)
        <option value="{{$i}}" {{ old('month') == $i ? 'selected' : ''}}>{{$i}}月</option>
        @endfor
      </select>
      <select name="day" class="main-input__select">
        <option value="">--日</option>
        @for($i=1;$i<=31;$i++)
        <option value="{{$i}}" {{ old('day') == $i ? 'selected' : ''}}>{{$i}}日</option>
        @endfor
      </select>
      @if($errors->has('year'))
          <p class="error">{{$errors->first('year')}}</p>
      @endif
      @if($errors->has('month'))
          <p class="error">{{$errors->first('month')}}</p>
      @endif
      @if($errors->has('day'))
          <p class="error">{{$errors->first('day')}}</p>
      @endif

      </dd>
      <dt>●アイコン画像</dt>
      <dd>
        <input type="file" name="image" value="test" class="main-input__file"/>
        @if($errors->has('image'))
          <p class="error">{{$errors->first('image')}}</p>
      @endif
      </dd>

    </dl>

    <button class="button button--register">確認画面へ</button>
  </form>

  <a href="{{route('main.login')}}">ログインページへ</a>
  </div>

@endsection