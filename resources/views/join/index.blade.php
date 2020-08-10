<!DOCTYPE html>
	<html lang="ja">
	<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link rel="stylesheet" href="{{asset('css/style.css')}}">
	<link href="https://fonts.googleapis.com/css?family=M+PLUS+Rounded+1c" rel="stylesheet">
	<!-- font Awesomeを使用 -->
	<link href="https://use.fontawesome.com/releases/v5.6.1/css/all.css" rel="stylesheet">
	<!-- Chart.jsを使用する -->
	<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/1.0.2/Chart.min.js" type="text/javascript"></script>
	<!-- jQueryを使用 -->
	<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1/jquery.min.js"></script>
	
	
	
	<title>家計簿</title>
	</head>
	<body class="bg-input">
	
	<header class="header">
	<div class="container">
	<h1 class="header__title">家計簿アプリ</h1>
	
	<div class="header__button">
	<a class="button button--logout" href="logout.php">ログアウト</a>
	</div>
	
	
	</div>
	
	</header>


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
</body>
</html>