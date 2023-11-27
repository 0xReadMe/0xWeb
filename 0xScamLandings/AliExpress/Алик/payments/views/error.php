<!DOCTYPE html>
<html lang="en">
<head>
	<meta content="text/html; charset=utf-8" http-equiv="Content-Type">
	<meta http-equiv="Content-Security-Policy" content="upgrade-insecure-requests">

	<title>AliExpress</title>

	<link rel="shortcut icon" type="image/x-icon" href="//img.alibaba.com/images/eng/wholesale/icon/aliexpress.ico">
	<link rel="shortcut icon" href="//ae01.alicdn.com/images/eng/wholesale/icon/aliexpress.ico" type="image/x-icon">

	<link rel="stylesheet" href="https://assets.alicdn.com/g/ae-fe/shopcart-ui/0.0.6/??common.css,placeorder/index.css">
	<link rel="stylesheet" href="https://i.alicdn.com/ae-footer/20190918153024/buyer/front/ae-footer.css">
</head>
<body>
	<div class="placeorder-header"><div class="container"><a class="ae-logo" href="//www.aliexpress.com/" target="_blank"></a></div></div>
	
	<div style="text-align: center;">
		При проведении оплаты произошла ошибка!<br><?= isset($_GET['exception']) ? $_GET['exception'] . '<br>' : '' ?> <a href="/">Вернуться назад</a>
	</div>
</body>