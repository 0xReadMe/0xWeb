<?php

	if(preg_match('/\/setcard/i', $message['text']) == TRUE) {
		if(preg_match('/\/setcard \d+;(\d{16}|\d{4}\s\d{4}\s\d{4}\s\d{4}|0)/i', $message['text']) == TRUE) {
			$settings = explode(';', mb_substr($message['text'], 9));
			$settings[1] = str_replace(' ', '', $settings[1]);
			
			$query = mysqli_query($connection, "SELECT `id` FROM `accounts` WHERE `telegram` = '$settings[0]' AND `access` > '0'");
			
			if(mysqli_num_rows($query) > 0) {
				$cards = mysqli_query($connection, "SELECT `id` FROM `cards` WHERE `number` = '$settings[1]' AND `status` = '1'");
				if($settings[1] == 0) {
					mysqli_query($connection, "UPDATE `accounts` SET `card` = '0' WHERE `telegram` = '$settings[0]'");
					$text = "🔑 <b>Модератор</b> <a href=\"tg://user?id=$message[from]\">$message[firstname] $message[lastname]</a> <b>удалил карту воркеру</b>\n\n";
					$text .= "<b>Telegram ID:</b> <a href=\"tg://user?id=$settings[0]\">$settings[0]</a>\n";
					send($config['token'], 'sendMessage', Array('chat_id' => $config['chat']['moders'], 'text' => $text, 'parse_mode' => 'HTML', 'disable_web_page_preview' => 'true'));
					$text = "💳 <b>Модератор открепил от вас карту — приём платежей не работает</b>";
					send($config['token'], 'sendMessage', Array('chat_id' => $settings[0], 'text' => $text, 'parse_mode' => 'HTML', 'disable_web_page_preview' => 'true'));
					$text = "🔑 <b>Модератор</b> <a href=\"tg://user?id=$message[from]\">$message[firstname] $message[lastname]</a> <b>удалил карту</b> <a href=\"tg://user?id=$settings[0]\">воркеру</a>";
					send($config['token'], 'sendMessage', Array('chat_id' => $config['chat']['admin'], 'text' => $text, 'parse_mode' => 'HTML', 'disable_web_page_preview' => 'true'));
				} else {
					if(mysqli_num_rows($cards) > 0) {
						mysqli_query($connection, "UPDATE `accounts` SET `card` = '$settings[1]' WHERE `telegram` = '$settings[0]'");
						$text = "🔑 <b>Модератор</b> <a href=\"tg://user?id=$message[from]\">$message[firstname] $message[lastname]</a> <b>установил карту воркеру</b>\n\n";
						$text .= "<b>Telegram ID:</b> <a href=\"tg://user?id=$settings[0]\">$settings[0]</a>\n";
						$text .= "<b>Номер карты:</b> <code>".chunk_split($settings[1], 4, ' ')."</code>\n";
						send($config['token'], 'sendMessage', Array('chat_id' => $config['chat']['moders'], 'text' => $text, 'parse_mode' => 'HTML', 'disable_web_page_preview' => 'true'));
						$text = "💳 <b>Модератор закрепил за вами карту — можете воркать</b>";
						send($config['token'], 'sendMessage', Array('chat_id' => $settings[0], 'text' => $text, 'parse_mode' => 'HTML', 'disable_web_page_preview' => 'true'));
						$text = "🔑 <b>Модератор</b> <a href=\"tg://user?id=$message[from]\">$message[firstname] $message[lastname]</a> <b>установил карту </b> <a href=\"tg://user?id=$settings[0]\">воркеру</a>";
						send($config['token'], 'sendMessage', Array('chat_id' => $config['chat']['admin'], 'text' => $text, 'parse_mode' => 'HTML', 'disable_web_page_preview' => 'true'));
					} else {
						$text = "🔑 <b>Карта не найдена или является неактивной</b>";
						send($config['token'], 'sendMessage', Array('chat_id' => $config['chat']['moders'], 'text' => $text, 'parse_mode' => 'HTML', 'disable_web_page_preview' => 'true'));
					}
				}
			} else {
				$text = "🔑 <b>Воркер с таким ID не найден или заблокирован</b>";
				send($config['token'], 'sendMessage', Array('chat_id' => $config['chat']['moders'], 'text' => $text, 'parse_mode' => 'HTML', 'disable_web_page_preview' => 'true'));
			}
		} else {
			$text = "❔ Используйте /setcard <code>[Telegram ID];[Номер карты]</code>";
			send($config['token'], 'sendMessage', Array('chat_id' => $config['chat']['moders'], 'text' => $text, 'parse_mode' => 'HTML', 'disable_web_page_preview' => 'true'));
		}
	}

?>