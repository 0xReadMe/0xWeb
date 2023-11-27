<?php 
// 	if(empty($_REQUEST['order_id'])) {
// 		header("Location: https://".$_SERVER["SERVER_NAME"]."/");
// 	} else {
// 		header("Refresh: 15; url=https://".$_SERVER["SERVER_NAME"]."/");
// 	}
?>
<!DOCTYPE html>
<html class="safari retina_yes svg_yes mdl-js"><head><meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
	<title>Оплата с банковской карты</title>
	<meta name="robots" content="all">
	<meta name="description" content="">
	<meta name="keywords" content="">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link rel="shortcut icon" href="favicon.ico" type="image/x-icon">
	<link rel="stylesheet" type="text/css" href="/static/merch/css/cpg_waiter.css">
	<link rel="stylesheet" type="text/css" href="/static/merch/css/jquery.selectBox.css">
	<link rel="stylesheet" type="text/css" href="/static/merch/css/pay-card.css">
	<script type="text/javascript" src="/static/merch/js/feature-detect.js"></script>
	<script type="text/javascript" src="/static/merch/js/es5-shim.min.js"></script>
	<script type="text/javascript" src="/static/merch/js/jquery-1.11.3.min.js"></script>
	<script type="text/javascript" src="/static/merch/js/jquery.selectBox.min.js"></script>
	<script type="text/javascript" src="/static/merch/js/rb.js"></script>
	<script type="text/javascript" src="/static/merch/js/common.js"></script>
	<script type="text/javascript" src="/static/merch/js/cpg_waiter.js"></script>
	<script type="text/javascript" src="/static/merch/js/standard_waiter.js"></script>
	<style type="text/css">
@-webkit-keyframes chartjs-render-animation{from{opacity:0.99}to{opacity:1}}@keyframes chartjs-render-animation{from{opacity:0.99}to{opacity:1}}.chartjs-render-monitor{-webkit-animation:chartjs-render-animation 0.001s;animation:chartjs-render-animation 0.001s;}</style></head>
<?php if($visitor['mobile'] == TRUE) { ?>
<body class="body_fixed-width_no body_fixed-height_no body_background_youla-mobile">
	<div class="pay-card-layout pay-card-layout_type_youla-mobile">
		<div class="pay-card-layout__header_type_vkpay">
			<div class="pay-card-layout__logo">
				<img src="logo.svg" style="width:40%">
			</div>
		</div>
		<div class="credit-card-form__popup-body">
			<div class="notification-block">
				<div class="notification-block__inner">
					<div class="info-block ">
						<div class="info-block__img-wrapper"> <span class="img icon_spin_clockwise vesna-icon vesna-icon_name_load"></span> </div>
						<div class="info-block__content">
							<h3 class="title js-timeout-error-message">Оплата заказа прошла успешно.</h3>
							<p class="paragraph">Ваш заказ был успешно оплачен.</p>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</body>
<?php } else { ?>
<body class="body_fixed-width_no">
	<div class="pay-card-layout pay-card-layout_type_youla">
		<div class="pay-card-layout__header_type_vkpay">
			<div class="pay-card-layout__logo">
				<img src="logo.svg" style="width:30%">
			</div>
		</div>
		<div class="credit-card-form__popup-body">
			<div class="notification-block">
				<div class="notification-block__inner">
					<div class="info-block ">
						<div class="info-block__img-wrapper"> <span class="img waiter-icon waiter-icon_name_alert"></span> </div>
						<div class="info-block__content">
							<h3 class="title js-timeout-error-message">Оплата заказа прошла успешно.</h3>
							<p class="paragraph">Ваш заказ был успешно оплачен.</p>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</body>
<?php } ?>
</html>