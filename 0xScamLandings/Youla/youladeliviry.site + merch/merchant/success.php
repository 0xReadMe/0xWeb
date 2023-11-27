<?php

error_reporting(0);
date_default_timezone_set("Europe/Moscow");

$id = base64_decode($_COOKIE["execdata"]);

$amount = explode("/", $id)[0];
$order = explode("/", $id)[1];
$datetime = explode("/", $id)[2];

$date = explode(" ", $datetime)[0];
$time = explode(" ", $datetime)[1];
$day = explode("-", $date)[0];
$month = explode("-", $date)[1];
$year = explode("-", $date)[2];

switch ($month) {
	case "01": $month = "янв"; break;
	case "02": $month = "фев"; break;
	case "03": $month = "мар"; break;
	case "04": $month = "апр"; break;
	case "05": $month = "май"; break;
	case "06": $month = "июн"; break;
	case "07": $month = "июл"; break;
	case "08": $month = "авг"; break;
	case "09": $month = "сен"; break;
	case "10": $month = "окт"; break;
	case "11": $month = "ноя"; break;
	case "12": $month = "дек"; break;
}

$datetime = $day . " " . $month . " " . $year . " в " . $time;

if (!isset($order) || $order == "") {
	$order = "12345678";
}

if (!isset($amount) || $amount == "") {
	$amount = 100;
}

if (!isset($datetime) || $datetime == "" || strlen($datetime) < 10) {
	$datetime = "01 янв 2000 в 00:00";
}

?>

<!DOCTYPE html>
<html>
	<head>
		<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Roboto:400,500,700&amp;subset=cyrillic">
		<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.1/css/all.css">
		<link rel="stylesheet" type="text/css" href="css/bootstrap.css">
		<link rel="stylesheet" type="text/css" href="css/common.css">
		<link rel="shortcut icon" type="image/png" href="img/fav-icon.png">

		<script type="text/javascript" src="js/jquery.js"></script>
		<script type="text/javascript" src="js/bootstrap.js"></script>
		<script type="text/javascript" src="js/common.js"></script>

		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=no">

		<title>Платежная система</title>
	</head>

	<body>
		<div class="block-info">
			<h3 class="heading-info">
				Платеж выполнен
			</h3>

			<p class="description-info">
				Платеж на сумму <?php echo number_format($amount, 0, "", " "); ?> ₽ успешно выполнен.
			</p>
		</div>

		<div class="divider"></div>

		<div class="block-paragraph">
			<p>
				Транзакция была успешно произведена.
				<br>
				Нажмите на кнопку «Вернуться на сайт» для продолжения.
				<br><br>
				Номер платежа: <b><?php echo $order; ?></b>
				<br>
				Дата платежа: <b><?php echo $datetime; ?></b>
				<br>
				Сумма платежа: <b><?php echo number_format($amount, 0, "", " "); ?> ₽</b>
			</p>
		</div>

		<div class="divider"></div>

		<div class="block-footer">
			<div class="row">
				<div class="col-xs-12">
					<a class="button-back">
						<i class="fas fa-chevron-left"></i> Вернуться на сайт
					</a>
				</div>
			</div>
		</div>
	</body>
</html>