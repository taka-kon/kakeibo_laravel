@extends('layouts.kakeibotemp')

@section('title','マイページ｜')

@section('main')
<div class="main-index">
    
    <img class="main-index__icon" src="{{asset($icon)}}" alt="">
    <h2 class="main-index__top-text1"><span class="main-index__name">{{$name}}</span></h2>
    <div class="main-index__top-expense">
      <h2 class="main-index__top-text1">今月の出費額 </h2>
      <p class="main-index__top-text2"><span class="main-index__price" id = "price">{{$sum}}</span>円</p>

    </div>



    <form action="{{route('main.post')}}" class="main-index__form" method="post">
      @csrf

      <p class="main-index__form-label">日付</p>
      <input type="date" name="date" class="main-index__select" value="{{$date}}">
      <p class="main-index__form-label">ジャンル</p>
     
      <select name="genre" class="main-index__select">
      <option value="食費" >食費</option>
      <option value="日用品費" >日用品費</option>
      <option value="レジャー費" >レジャー費</option>
      <option value="交通費" >交通費</option>
      <option value="固定費" >固定費</option>
      <option value="その他" >その他</option>
  
      </select>
      <p class="main-index__form-label">出費</p>
      <input type="number" min="0" name="minus" value="0" class="main-index__text">

      
      <br>
      <div class="main-index__button-post">
        <button class="button button--post">追加する</button>
      </div>
    </form>
    <!-- グラフを表示 -->
    <div class="main-index__graphs">
      
    
      <h2 class="main-index__head">3か月</h2>
      <canvas id="graph-area-3m" class="main-index__graph"></canvas> 
      <div class="main-index__g-item">
        <div class="g-item">
          <ul class="g-item__parts">
          <li class="g-item__part"><div class="g-item__box g-item__box--all"></div>合計</li>
            <li class="g-item__part"><div class="g-item__box g-item__box--0"></div>食費</li>
            <li class="g-item__part"><div class="g-item__box g-item__box--1"></div>日用品費</li>
            <li class="g-item__part"><div class="g-item__box g-item__box--2"></div>レジャー費</li>
            <li class="g-item__part"><div class="g-item__box g-item__box--3"></div>交通費</li>
            <li class="g-item__part"><div class="g-item__box g-item__box--4"></div>固定費</li>
            <li class="g-item__part"><div class="g-item__box g-item__box--5"></div>その他</li>
          </ul>
        </div>
      </div>
      <h2 class="main-index__head">6か月</h2>
      <canvas id="graph-area-6m" class="main-index__graph"></canvas> 
      <div class="main-index__g-item">
        <div class="g-item">
          <ul class="g-item__parts">
            <li class="g-item__part"><div class="g-item__box g-item__box--all"></div>合計</li>
            <li class="g-item__part"><div class="g-item__box g-item__box--0"></div>食費</li>
            <li class="g-item__part"><div class="g-item__box g-item__box--1"></div>日用品費</li>
            <li class="g-item__part"><div class="g-item__box g-item__box--2"></div>レジャー費</li>
            <li class="g-item__part"><div class="g-item__box g-item__box--3"></div>交通費</li>
            <li class="g-item__part"><div class="g-item__box g-item__box--4"></div>固定費</li>
            <li class="g-item__part"><div class="g-item__box g-item__box--5"></div>その他</li>
          </ul>
        </div>
      </div>


    </div>
  
    
    <!-- 以下、更新情報 -->
    
    <div class="main-index__posts">
      <h2 class="main-index__head">更新履歴</h2>
      @foreach($items as $item)
    
    
        <p>{{$item->getCreated()}}追加</p>
        <span class="main-index__msg-name">{{$item->getUserName()}}</span>は、
          <b class="main-index__italic">{{$item->getDay()}}</b>に<b>{{$item->getMinus()}}</b>を<b>{{$item->getGenre()}}</b>で使いました。
        <div class="main-index__button-delete">
          <a href="{{route('main.delete',['id'=>$item->getId()])}}" class="button button--delete">取消</a>

        </div>
        <hr>
        @endforeach
    </div>
    
  </div>

@endsection