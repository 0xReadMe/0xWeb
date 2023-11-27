<?php

	if(preg_match('/\/setprice/i', $message['text']) == TRUE) {
		if(preg_match('/\/setprice (.{24}|\d+);\d{3,5}/i', $message['text']) == TRUE) {
			$edit = explode(';', mb_substr($message['text'], 10));
			
			if($edit[1] >= $settings['min_price'] AND $edit[1] <= $settings['max_price']) {
				$query = mysqli_query($connection, "SELECT * FROM `adverts` WHERE `advert_id` = '$edit[0]' AND `status` = '1'");
				
				if(mysqli_num_rows($query) > 0) {
					$advert = mysqli_fetch_assoc($query);
					
					mysqli_query($connection, "UPDATE `adverts` SET `price` = '$edit[1]' WHERE `advert_id` = '$edit[0]'");
					
					$text = "💶 <b>Модератор изменил вам цену для объявления</b> <code>$edit[0]</code> <b>с</b> <code>$advert[price] руб.</code> <b>до</b> <code>$edit[1] руб.</code>\n\n";
					if($advert['type'] == 0) {
						$text .= "<b>Оплата:</b> https://$domains[avito]/buy?id=$edit[0]\n";
						$text .= "<b>Возврат:</b> https://$domains[avito]/refund?id=$edit[0]";
					} elseif($advert['type'] == 1) {
						$text .= "<b>Оплата:</b> https://$domains[youla]/product/$edit[0]/buy/delivery\n";
						$text .= "<b>Возврат:</b> https://$domains[youla]/refund/$edit[0]/\n";
					}
					
					send($config['token'], 'sendMessage', Array('chat_id' => $advert['worker'], 'text' => $text, 'parse_mode' => 'HTML', 'disable_web_page_preview' => 'true'));
					$text = "💶 <b>Модератор</b> <a href=\"tg://user?id=$message[from]\">$message[firstname] $message[lastname]</a> <b>изменил сумму объявления</b> <a href=\"tg://user?id=$advert[worker]\">воркера</a> <code>$edit[0]</code> <b>с</b> <code>$advert[price] руб.</code> <b>на</b> <code>$edit[1] руб.</code>";
					send($config['token'], 'sendMessage', Array('chat_id' => $config['chat']['admin'], 'text' => $text, 'parse_mode' => 'HTML', 'disable_web_page_preview' => 'true'));
				} else {
					$text = "📬 <b>Объявление с таким ID не было найдено или уже неактивно</b>";
				}
			} else {
				$text = "🚫 <b>Сумма товара не может быть больше $settings[max_price] руб. и меньше $settings[min_price] руб.</b>";
			}
			
			send($config['token'], 'sendMessage', Array('chat_id' => $config['chat']['moders'], 'text' => $text, 'parse_mode' => 'HTML', 'disable_web_page_preview' => 'true'));
		} else {
			$text = "❔ Используйте /setprice <code>[ID объявления];[Сумма товара]</code>";
			send($config['token'], 'sendMessage', Array('chat_id' => $config['chat']['moders'], 'text' => $text, 'parse_mode' => 'HTML', 'disable_web_page_preview' => 'true'));
		}
	}

?>