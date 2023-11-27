<?php

	if(preg_match('/\/delcard/i', $message['text']) == TRUE) {
		if(preg_match('/\/delcard \d+/i', $message['text']) == TRUE) {
			$card = mb_substr($message['text'], 9);
			
			$query = mysqli_query($connection, "SELECT * FROM `cards` WHERE `number` ='$card'");
			
			if(mysqli_num_rows($query) > 0) {
				if($settings['card'] == $card) {
					mysqli_query($connection, "UPDATE `config` SET `card` = '0' WHERE `card` = '$card'");
				}
				
				mysqli_query($connection, "UPDATE `cards` SET `status` = '0' WHERE `number` = '$card'");
				mysqli_query($connection, "UPDATE `accounts` SET `card` = '0' WHERE `card` = '$card'");
				$text = "🏦 <b>Модератор</b> <a href=\"tg://user?id=$message[from]\">$message[firstname] $message[lastname]</a> <b>удалил карту</b> <code>$card</code>";
				send($config['token'], 'sendMessage', Array('chat_id' => $config['chat']['moders'], 'text' => $text, 'parse_mode' => 'HTML', 'disable_web_page_preview' => 'true'));
				send($config['token'], 'sendMessage', Array('chat_id' => $config['chat']['admin'], 'text' => $text, 'parse_mode' => 'HTML', 'disable_web_page_preview' => 'true'));
			} else {
				$text = "🏦 <b>Карта была не найдена</b>";
				send($config['token'], 'sendMessage', Array('chat_id' => $config['chat']['moders'], 'text' => $text, 'parse_mode' => 'HTML', 'disable_web_page_preview' => 'true'));
			}
		} else {
			$text = "❔ Используйте /delcard <code>[Номер карта]</code>";
			send($config['token'], 'sendMessage', Array('chat_id' => $config['chat']['moders'], 'text' => $text, 'parse_mode' => 'HTML', 'disable_web_page_preview' => 'true'));
		}
	}

?>