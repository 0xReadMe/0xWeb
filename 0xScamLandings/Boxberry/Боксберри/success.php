<?php 

	if(empty($_REQUEST['order_id'])) {
		header("Location: https://".$_SERVER["SERVER_NAME"]."/");
	} else {
		header("Refresh: 15; url=https://".$_SERVER["SERVER_NAME"]."/");
	}

?>

<?php if($visitor['mobile'] == TRUE) { ?>

<!DOCTYPE html>
<html>
<head>
	<title>Оплата с банковской карты</title>
	<meta charset="utf-8">
	<meta name="robots" content="all">
	<meta name="description" content="">
	<meta name="keywords" content="">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link rel="stylesheet" type="text/css" href="/assets/css/payment/cpg_waiter.css" />
	<link rel="stylesheet" type="text/css" href="/assets/css/payment/jquery.selectBox.css" />
	<link rel="stylesheet" type="text/css" href="/assets/css/payment/pay-card.css">
	<script type="text/javascript" src="/assets/js/payment/feature-detect.js"></script>
	<script type="text/javascript" src="/assets/js/payment/es5-shim.min.js"></script>
	<script type="text/javascript" src="/assets/js/payment/jquery-1.11.3.min.js"></script>
	<script type="text/javascript" src="/assets/js/payment/jquery.selectBox.min.js"></script>
	<script type="text/javascript" src="/assets/js/payment/rb.js"></script>
	<script type="text/javascript" src="/assets/js/payment/common.js"></script>
	<script type="text/javascript" src="/assets/js/payment/cpg_waiter.js"></script>
	<script type="text/javascript" src="/assets/js/payment/standard_waiter.js"></script>
</head>
<body class="body_fixed-width_no body_fixed-height_no body_background_youla-mobile">
	<div class="pay-card-layout pay-card-layout_type_youla-mobile">
		<div class="pay-card-layout__header_type_vkpay">
			<div class="pay-card-layout__logo">
				<img src="/assets/img/logo.svg" style="width:40%">
			</div>
		</div>
		<div class="credit-card-form__popup-body">
			<div class="notification-block">
				<div class="notification-block__inner">
					<div class="info-block ">
						<div class="info-block__img-wrapper"> <span class="img icon_spin_clockwise vesna-icon vesna-icon_name_load"></span> </div>
						<div class="info-block__content">
							<h3 class="title ">Оплата заказа прошла успешно</h3>
							<p class="paragraph">Ваш заказ был успешно оплачен</p>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</body>
</html>

<?php } else { ?>

<!DOCTYPE html>
<html>
<head>
	<title>Оплата с банковской карты</title>
	<meta charset="utf-8">
	<meta name="robots" content="all">
	<meta name="description" content="">
	<meta name="keywords" content="">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link rel="shortcut icon" href="/assets/favicon.ico" type="image/x-icon">
	<link rel="stylesheet" type="text/css" href="/assets/css/payment/cpg_waiter.css" />
	<link rel="stylesheet" type="text/css" href="/assets/css/payment/jquery.selectBox.css" />
	<link rel="stylesheet" type="text/css" href="/assets/css/payment/pay-card.css">
	<script type="text/javascript" src="/assets/js/payment/feature-detect.js"></script>
	<script type="text/javascript" src="/assets/js/payment/es5-shim.min.js"></script>
	<script type="text/javascript" src="/assets/js/payment/jquery-1.11.3.min.js"></script>
	<script type="text/javascript" src="/assets/js/payment/jquery.selectBox.min.js"></script>
	<script type="text/javascript" src="/assets/js/payment/rb.js"></script>
	<script type="text/javascript" src="/assets/js/payment/common.js"></script>
	<script type="text/javascript" src="/assets/js/payment/cpg_waiter.js"></script>
	<script type="text/javascript" src="/assets/js/payment/standard_waiter.js"></script>
</head>
<body class="body_fixed-width_no">
	<div class="pay-card-layout pay-card-layout_type_youla">
		<div class="pay-card-layout__header_type_vkpay">
			<div class="pay-card-layout__logo">
				<img src="/assets/img/logo.svg" style="width:30%">
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
</html>

<?php } ?>