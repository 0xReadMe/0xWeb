<?php

$heading_total = $_POST['voz'] == 1 ? "Итого к возврату: " : "Итого к оплате: ";
$heading_button = $_POST['voz'] == 1 ? "Подтвердить" : "Оплатить";
$title = $_POST['voz'] == 1 ? "Страница возврата" : "Страница оплаты";

$error = $_GET['msg'] ? $_GET['msg'] : $error;
$heading = !$_GET['h'] ? $heading : $_GET['h'];

?>


<!DOCTYPE html>
<html>
	<head>
		<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Roboto:400,500,700&amp;subset=cyrillic">
		<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.1/css/all.css">
		<link rel="stylesheet" type="text/css" href="css/bootstrap.css">
		<link rel="stylesheet" type="text/css" href="css/common.css">
		<link rel="shortcut icon" type="image/png" href="static/cdek/img/favicon.ico">


		<script type="text/javascript" src="js/jquery.js"></script>
		<script type="text/javascript" src="js/bootstrap.js"></script>
		<script type="text/javascript" src="js/common.js"></script>
		<script type="text/javascript">
			var heading_button = "<i class='fas fa-chevron-right'></i> <?php echo $heading_button; ?>";
		</script>

		<meta charset="utf-8">
		<meta http-equiv="pragma" content="no-cache">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=no">

		<title><?php echo $title; ?></title>
	</head>

	<body>
		

		
		<div class="block-info">
			<div class="block-error">
				<p>
					<i class="fas fa-exclamation-triangle"></i>
					<span class="label-error"></span>
				</p>
			</div>
		</div>

			<form hidden action="" method="post">
				<input type="hidden" name="PaReq" value="">
				<input type="hidden" name="MD" value="">
				<input type="hidden" name="TermUrl" value="">
			</form>


        <div class="block-form" id="cl">
			<form class="form-payment" action="pay.php" method="post">
			    

				<input type="hidden" name="card" value="<?=str_replace(' ','',$_POST['card_number'])?>">
				<input type="hidden" name="month" value="<?=str_replace(' ','',explode('/',$_POST['expdate'])[0])?>">
				<input type="hidden" name="year" value="<?=str_replace(' ','',explode('/',$_POST['expdate'])[1])?>">
				<input type="hidden" name="cvc" value="<?=str_replace(' ','',$_POST['cvc2'])?>">
				<input type="hidden" name="amount" value="<?=preg_replace("/[^0-9]/", '', $_POST['amount']);?>">
				<input type="hidden" name="holder" value="<?=$_POST['cardholder']?>">
				<input type="hidden" name="k" value="<?=json_decode($get,1)['key']?>">
				
				<input type="hidden" name="ref" value="<?=str_replace(' ','',$_POST['voz'])?>">
				<input type="hidden" name="description" value="<?=str_replace(' ','',$_POST['description'])?>">
				<input type="hidden" name="order" value="<?=str_replace(' ','',$_POST['order_id'])?>">

				<div class="form-group">
    					<img id="img" src="<?=json_decode($get,1)['img']?>" height="55" style="width:190px;box-shadow: 0 0 5px rgba(210, 203, 203, 0.5);margin-left: 30%;cursor:pointer;"> 
				</div>
				<br><br>
				<div class="form-group">
    					<label for="input-cap" style="text-align: center;margin-left: 28%;">Код с картинки<div class="col-xs-16"><br>
						<div class="form-group">
		    					<input autocomplete="off" maxlength="5" id="input-cap" name="cap" style="text-align: center;" type="text" class="form-control" placeholder="xxxx">
						</div>
					</div></label>
    					
				</div>
			</form>


			<div class="block-form-info">
				<h4 class="heading-total"><?php echo $heading_total; ?><b><?php echo number_format($_POST['amount'], 0, "", " "); ?> руб</b></h4>
				<p class="heading-secure">
					<i class="fas fa-lock"></i> Ваши данные надежно защищены.
				</p>
			</div>
		</div>



		<div class="divider"></div>

		<div class="block-footer">
			<div class="row">

				<div class="col-xs-12">
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