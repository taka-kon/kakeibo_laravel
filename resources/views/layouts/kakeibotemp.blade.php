<!-- テンプレート -->
<!DOCTYPE html>
	<html lang="ja">
	<head>
	<meta charset="UTF-8">
	<link rel="shortcut icon" href="{{asset('img/logo.png')}}" type="image/x-icon">
	<meta http-equiv="Pragma" content="no-cache">
  <meta http-equiv="Cache-Control" content="no-cache">
  <meta http-equiv="Expires" content="0">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link rel="stylesheet" href="{{asset('css/style.css')}}">
	<link href="https://fonts.googleapis.com/css?family=M+PLUS+Rounded+1c" rel="stylesheet">
	<!-- font Awesomeを使用 -->
	<link href="https://use.fontawesome.com/releases/v5.6.1/css/all.css" rel="stylesheet">
	<!-- Chart.jsを使用する -->
	<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/1.0.2/Chart.min.js" type="text/javascript"></script>
	<!-- jQueryを使用 -->
	<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1/jquery.min.js"></script>
	
	
	
	<title>@yield('title')家計ボット</title>
	</head>
	@php 
		$url=$_SERVER['REQUEST_URI'];
	@endphp
	<body class="bg-index">

	
	
	<header class="header">
	<div class="container">
		
		<h1 class="header__title">家計ボット</h1>
	
	@if(strpos($url,"/page")!==false)
	<div class="header__right">
		<div class="header__button">
		<a class="button button--logout" href="{{route('main.logout')}}">ログアウト</a>
		</div>
		<a href="{{route('join.setting')}}" class="header__setlink"><i class="fas fa-cog header__set-icon"></i></a>
	</div>
	@endif
	
	
	</div>
	
	</header>
  @yield('main')
	<script src="{{asset('/js/sample.js?p=(new Date()).getTime()')}}"></script>
	<script type="text/javascript" src="{{asset('/js/script.js')}}"></script>
</script>
</body>
</html>