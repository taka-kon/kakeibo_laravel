<!-- 新規登録（入力ページ） -->
@extends('layouts.kakeibotemp')

@section('title','アカウント設定｜')

@section('main')
<div class="main-input">
  @if(Session::has('msg'))
    <div class="main-input__msg" id="main-input__msg">
    {{session('msg')}}
    </div>
  @endif
  <h2 class="main-input__title">アカウント設定</h2>
  <form action="{{route('join.change')}}" method="post" enctype="multipart/form-data">
  @csrf
    <dl>
      <dt class="main-input__headline">ニックネーム変更</dt>
      <dd class="main-input__tag-dd">
        <input type="text" name="name" id="" class="main-input__form" maxlength="255" >
      </dd>
      <dt class="main-input__headline">アイコン変更</dt>
      <img class="main-input__icon-change" src="{{asset($icon)}}" alt="" id="now">
      <dd>
        <input type="file" name="image" value="test"  class="main-input__file"  />
      </dd>
    </dl>
  
    <button class="main-input__button button button--register">変更</button>
  </form>

  
  <div class="main-input__popup" id="js-popup">
    <div class="main-input__popup-inner">
      <div class="main-input__close-btn" id="js-close-btn"><i class="fas fa-times"></i></div>
      <p>削除するとデータは二度と戻らなくなります。<br>本当にアカウントを削除しますか？</p>
      <div class="main-input__buttons">
        <form action="{{route('join.remove')}}" method="post">
          @csrf
          <button class="main-input__button button button--delete-user2">削除</button>
        </form>
          <button class="main-input__button button button--cancel" id="js-close-btn2">キャンセル</button>
        </div>
      </div>
      <div class="main-input__black-background" id="js-black-bg"></div>
  </div>

  <div class="main-input__user-delete">
    <dl class="main-input__line">
      <dt class="main-input__headline-delete main-input__left-dt">アカウント削除</dt>
      <dd class="main-input__right-dd"><button class="main-input__button button button--delete-user" id="js-show-popup">削除する</button></dd>
    </dl>
  </div>
  <a href="{{route('main.index')}}">マイページに戻る</a>
</div>

@endsection