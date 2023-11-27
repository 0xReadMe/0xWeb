<? 
include "config.php";
?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta http-equiv="X-UA-Compatible" content="ie=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
	<meta property="og:title" content="">
	<meta property="og:description" content="">
	<meta property="og:url" content="">
	<meta property="og:image" content="path/to/image.jpg">
	<meta name="theme-color" content="#000">
	<link rel="icon" href="img/favicon/favicon.ico">
	<link rel="apple-touch-icon" sizes="180x180" href="img/favicon/apple-touch-icon-180x180.png">
	<link rel="stylesheet" href="css/libs.min.css">
	<link rel="stylesheet" href="css/main.css">
	<title>Main | <?=$name;?></title>
</head>
<body>

	<!-- Header-->
	<div class="header">
		<div class="header__top">
			<div class="header__wrap">
				<div class="header__top-right"><a class="header__logo" href="#"> <img src="img/logo.png" alt=""></a>
					<nav class="nav" id="menu">
						<div class="nav__closed">X</div>
						<ul class="nav__ul">
							<li><a class="nav__link" href="#about"> About </a></li>
							<li><a class="nav__link" href="#features">Features </a></li>
							<li><a class="nav__link" href="#testimonials">Testimations </a></li>
							<li><a class="nav__link" href="#download">Download </a></li>
						</ul>
					</nav>
				</div>
				<div class="header__button"><a href="download.php">Download </a></div>
				<div class="gam"> <i class="icon-line"> </i><i class="icon-line"> </i><i class="icon-line"></i></div>
			</div>
		</div>
		<div class="header__block">
			<div class="header__container-block">
				<div class="header__bg"><img src="img/header-bg.png" alt=""></div>
				<div class="header__block-info">
					<h1 class="header__title">Save your data storage here.</h1>
					<p class="header__text"> <?=$name;?> is a data storage area that has been tested for security, so you can store your data here safely but not be afraid of being stolen by others. </p>
					<div class="header__btn" id="menu1"><a href="#features">Learn more</a></div>
				</div>
			</div>
		</div>
	</div><!-- Section-->
	<div class="about" id="about">
		<div class="container">
			<div class="about__content">
				<div class="about__img"><img src="img/about-1.png" alt="about"></div>
				<div class="about__info">
					<h3 class="about__title">We are a high-level data storage bank</h3>
					<p class="about__text">The place to store various data that you can access at any time through the internet and where you can carry it. This very flexible storage area has a high level of security. To enter into your own data you must enter the password that you created when you registered in this <?=$name;?>.</p>
				</div>
			</div>
		</div>
	</div>
	<div class="features" id="features">
		<div class="container">
			<div class="features__title">Features</div>
			<div class="features__text">Some of the features and advantages that we provide for those of you who store data in this <?=$name;?>. </div>
			<div class="features__items">
				<div class="features__item item_1">
					<div class="features__img"><img src="img/features-1.png" alt=""></div>
					<div class="features__content">
						<h3 class="features__item-title">Search Data</h3>
						<p class="features__item-text">Don’t worry if your data is very large, the <?=$name;?> provides a search engine, which is useful for making it easier to find data effectively saving time.</p>
					</div>
				</div>
				<div class="features__item item_2">
					<div class="features__img"><img src="img/features-2.png" alt=""></div>
					<div class="features__content">
						<h3 class="features__item-title">24 Hours Access</h3>
						<p class="features__item-text">Access is given 24 hours a full morning to night and meet again in the morning, giving you comfort when you need data when urgent.</p>
					</div>
				</div>
				<div class="features__item item_2">
					<div class="features__img"><img src="img/features-3.png" alt=""></div>
					<div class="features__content">
						<h3 class="features__item-title">Print OutDo</h3>
						<p class="features__item-text"> Print out service gives you convenience if someday you need print data, just edit it all and just print it.</p>
					</div>
				</div>
				<div class="features__item item_1">
					<div class="features__img"><img src="img/features-4.png" alt=""></div>
					<div class="features__content">
						<h3 class="features__item-title">Security Code </h3>
						<p class="features__item-text">Data Security is one of our best facilities. Allows for your files to be safer. The file can be secured with a code or password that you created, so only you can open the file.</p>
					</div>
				</div>
			</div>
		</div>
	</div>
	<div class="testimonials" id="testimonials">
		<div class="container-slider">
			<div class="testimonials__title">Testimonials</div>
			<div class="testimonials__slider">
				<div class="testimonials__slider-item">
					<div class="testimonials__slider-item__wrap">
						<div class="testimonials__img"><img src="img/slider-1.png" alt=""></div>
						<div class="testimonials__content">
							<p class="testimonials__content-autor">John Fang</p>
							<p class="testimonials__content-dsc">wordfaang.com</p>
							<p class="testimonials__content-text">Great design and very user-friendly interface, these qualities make <?=$name;?> the best program of its kind</p>
						</div>
					</div>
				</div>
				<div class="testimonials__slider-item">
					<div class="testimonials__slider-item__wrap">
						<div class="testimonials__img"><img src="img/slider-2.png" alt=""></div>
						<div class="testimonials__content">
							<p class="testimonials__content-autor">Jeny Doe</p>
							<p class="testimonials__content-dsc">UX Engineer</p>
							<p class="testimonials__content-text">There are no decent analogues of <?=$name;?> on the Internet </p>
						</div>
					</div>
				</div>
				<div class="testimonials__slider-item">
					<div class="testimonials__slider-item__wrap">
						<div class="testimonials__img"><img src="img/slider-3.png" alt=""></div>
						<div class="testimonials__content">
							<p class="testimonials__content-autor">William</p>
							<p class="testimonials__content-dsc">Web Designer</p>
							<p class="testimonials__content-text">This is the best program for storing files in the cloud.</p>
						</div>
					</div>
				</div>
				<div class="testimonials__slider-item">
					<div class="testimonials__slider-item__wrap">
						<div class="testimonials__img"><img src="img/slider-1.png" alt=""></div>
						<div class="testimonials__content">
							<p class="testimonials__content-autor">John Fang</p>
							<p class="testimonials__content-dsc">wordfaang.com</p>
							<p class="testimonials__content-text">Great design and very user-friendly interface, these qualities make <?=$name;?> the best program of its kind</p>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>

	<!-- Footer-->
	<footer class="footer">
		<div class="container-footer">
			<div class="footer__top" id="download">
				<div class="footer__top-left">
					<h3 class="footer__top-title">Try for free!</h3>
					<p class="footer__text">Get limited 1 week free try our features! </p>
				</div>
				<div class="footer__top-right">
					<div class="footer__button-1" id="menu2"><a href="#features">Learn more</a></div>
					<div class="footer__button-2"><a href="download.php">Download </a></div>
				</div>
			</div>
			<div class="footer__wrap">
				<div class="footer__info">
					<div class="footer__info-logo"><a class="logo" href=""> <img src="img/logo.png" alt=""><?=$name;?></a></div>
					<p><?=$name;?> Society, 234 <br>Bahagia Ave Street PRBW 29281</p><a href="tel:0383205700">T 03 8320 5700 (Main) </a>
				</div>
				<div class="footer__about">
					<ul class="footer__ul">
						<li class="footer__style"><a class="footer__link" href="#about">About </a></li>
						<li><a class="footer__link" href="#testimonials">Reviews </a></li>
						<li><a class="footer__link" href="#features">Features </a></li>
						<li><a class="footer__link" href="download.php">Try the programm </a></li>
					</ul>
				</div>
				<div class="footer__help">
					<ul class="footer__ul">
						<li class="footer__style"> <a class="footer__link" href="#">Help (soon)</a></li>
						<li><a class="footer__link" href="#">Support Guide Reports(soon) </a></li>
						<li><a class="footer__link" href="#">Guide (soon)</a></li>
						<li><a class="footer__link" href="#">Reports(soon)</a></li>
					</ul>
				</div>
			</div>
			<div class="footer__copy">
				<p>© <?=$name;?>™, 2020. All rights reserved. </p>
				<p>Company Registration Number: 21479524.</p>
			</div>
		</div>
	</footer>

	<!-- Request popup-->
	<div class="mfp mfp--request-popup zoom-anim-dialog mfp-hide" id="request">
		<div class="mfp__form">
			<div class="mfp__form-title">Рассчитать стоимость услуги</div>
			<div class="mfp__form-text">Оставте свою заявку и мы вам перезвоним</div>
			<form action=""><input type="text" data-name="Имя" name="name" placeholder="Имя"><input type="tel" data-name="Телефон" name="tel" placeholder="Телефон" required><button class="btn-style">Рассчитать стоимость</button><input class="check" type="checkbox" value="igree" name="" checked="checked" required><label for="igree">Согласен на обработку персональных данных</label></form>
		</div>
		<div class="form-result">
			<div class="mess">
				<div class="mess__title">Success!</div>
				<div class="mess__desc">We will contact with you soon</div>
			</div>
		</div>
	</div>

	<!-- Success popup-->
	<div class="mfp mfp--succes-popup zoom-anim-dialog mfp-hide" id="success">
		<div class="form-result form-result--success">
			<div class="mess">
				<div class="mess__title">Success!</div>
				<div class="mess__desc">We will contact with you soon</div>
			</div>
		</div>
	</div>

	<!-- Scripts-->
	<script src="js/libs.min.js"></script>
	<script src="js/main.min.js"></script>
</body>
</html>