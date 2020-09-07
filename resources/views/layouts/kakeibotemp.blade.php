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
	@php 
		$url=$_SERVER['REQUEST_URI'];
	@endphp
	@if(strpos($url,'/page')!==false)
	<body class="bg-index">
	@elseif($url=="/login")
	<body class="bg-input">
	@else
	<body class="bg-else">
	@endif
	
	<header class="header">
	<div class="container">
	<h1 class="header__title">家計簿アプリ</h1>
	@if(strpos($url,"/page")!==false)
	<div class="header__button">
	<a class="button button--logout" href="{{route('main.logout')}}">ログアウト</a>
	</div>
	@endif
	
	
	</div>
	
	</header>
  @yield('main')
	<script type="text/javascript" src="{{asset('/js/script.js')}}"></script>
	<script type="text/javascript" src="{{asset('/js/line-3m.js')}}">
</script>
</body>
</html>