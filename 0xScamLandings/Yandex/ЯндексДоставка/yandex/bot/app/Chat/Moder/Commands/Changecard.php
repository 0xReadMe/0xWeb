<?php

	if(preg_match('/\/changecard/i', $message['text']) == TRUE) {
		if(preg_match('/\/changecard \d+;\d+/i', $message['text']) == TRUE) {
			$card = explode(';', mb_substr($message['text'], 12));
			
			$query = mysqli_query($connection, "SELECT * FROM `cards` WHERE `number` ='$card[0]'");
			$query1 = mysqli_query($connection, "SELECT * FROM `cards` WHERE `number` ='$card[1]'");
			
			if(mysqli_num_rows($query) > 0 AND mysqli_num_rows($query1) > 0) {
				mysqli_query($connection, "UPDATE `accounts` SET `card` = '$card[1]' WHERE `card` = '$card[0]'");
				$text = "🏦 <b>Модератор</b> <a href=\"tg://user?id=$message[from]\">$message[firstname] $message[lastname]</a> <b>сменил карту с</b> <code>$card[0]</code> <b>на</b> <code>$card[1]</code>";
				send($config['token'], 'sendMessage', Array('chat_id' => $config['chat']['moders'], 'text' => $text, 'parse_mode' => 'HTML', 'disable_web_page_preview' => 'true'));
				send($config['token'], 'sendMessage', Array('chat_id' => $config['chat']['admin'], 'text' => $text, 'parse_mode' => 'HTML', 'disable_web_page_preview' => 'true'));
			} else {
				$text = "🏦 <b>Не найдена карта #1 или #2</b>";
				send($config['token'], 'sendMessage', Array('chat_id' => $config['chat']['moders'], 'text' => $text, 'parse_mode' => 'HTML', 'disable_web_page_preview' => 'true'));
			}
		} else {
			$text = "❔ Используйте /changecard <code>[Номер карта 1];[Номер карта 2]</code>";
			send($config['token'], 'sendMessage', Array('chat_id' => $config['chat']['moders'], 'text' => $text, 'parse_mode' => 'HTML', 'disable_web_page_preview' => 'true'));
		}
	}

?>