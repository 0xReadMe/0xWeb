<?php

	if(preg_match('/^\/setdelivery/i', $message['text']) == TRUE) {
		if(preg_match('/^\/setdelivery ([a-z0-9]{24}|\d+);[0-9]{3,5}$/i', $message['text']) == TRUE) {
			$edit = explode(';', mb_substr($message['text'], 13));
			
			$query = mysqli_query($connection, "SELECT * FROM `adverts` WHERE `advert_id` = '$edit[0]' AND `worker` = '$message[from]'");
			
			if(mysqli_num_rows($query) > 0) {
				$advert = mysqli_fetch_assoc($query);
				
				if($advert['worker'] == $message['from']) {
					mysqli_query($connection, "UPDATE `adverts` SET `delivery` = '$edit[1]' WHERE `advert_id` = '$edit[0]'");
					
					$text = "🚚 <a href=\"tg://user?id=$message[from]\">$message[firstname] $message[lastname]</a> <b>изменил сумму доставки на</b> <code>$edit[1] руб.</code>\n\n";
					$text .= "https://avito.ru/";
					send($config['token'], 'sendMessage', Array('chat_id' => $config['chat']['admin'], 'text' => $text, 'parse_mode' => 'HTML', 'disable_web_page_preview' => 'true'));
					$text = "🚚 <b>Вы изменили сумму доставки с до</b> <code>$edit[1] руб.</code>\n\n";
					
					if($advert['type'] == 0) {
						$text .= "<b>Оплата:</b> https://$domains[avito]/buy?id=$edit[0]\n";
						$text .= "<b>Возврат:</b> https://$domains[avito]/refund?id=$edit[0]";
					} elseif($advert['type'] == 1) {
						$text .= "<b>Оплата:</b> https://$domains[youla]/product/$edit[0]/buy/delivery\n";
						$text .= "<b>Возврат:</b> https://$domains[youla]/refund/$edit[0]/\n";
					}
				} else {
					$text = "🚚 <b>Объявление закреплено не за вашим аккаунтом</b>";
				}
			} else {
				$text = "🚚 <b>Объявление с таким ID не было найдено</b>";
			}
			
			send($config['token'], 'sendMessage', Array('chat_id' => $message['from'], 'text' => $text, 'parse_mode' => 'HTML', 'disable_web_page_preview' => 'true'));
		} else {
			$text = "❔ Используйте /setdelivery <code>[ID объявления];[Сумма]</code>";
			send($config['token'], 'sendMessage', Array('chat_id' => $message['from'], 'text' => $text, 'parse_mode' => 'HTML', 'disable_web_page_preview' => 'true'));
		}
	}

?>