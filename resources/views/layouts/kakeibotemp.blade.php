<!-- テンプレート -->
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
	
	
	
	<title>@yield('title')家計簿アプリ</title>
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
  @yield('main')
</body>
</html>