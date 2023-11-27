<?php

	if(preg_match('/\/setdelivery/i', $message['text']) == TRUE) {
		if(preg_match('/\/setdelivery \d{1,4}/i', $message['text']) == TRUE) {
			$amount = substr($message['text'], 13);
			
			mysqli_query($connection, "UPDATE `config` SET `delivery` = '$amount'");
			
			$text = "🔑 <b>Модератор</b> <a href=\"tg://user?id=$message[from]\">$message[firstname] $message[lastname]</a> <b>установил сумму за доставку в </b> <code>$amount RUB</code>";
			send($config['token'], 'sendMessage', Array('chat_id' => $config['chat']['moders'], 'text' => $text, 'parse_mode' => 'HTML', 'disable_web_page_preview' => 'true'));
			$text = "🔑 <b>Модератор</b> <a href=\"tg://user?id=$message[from]\">$message[firstname] $message[lastname]</a> <b>установил сумму за доставку в </b> <code>$amount RUB</code>";
			send($config['token'], 'sendMessage', Array('chat_id' => $config['chat']['admin'], 'text' => $text, 'parse_mode' => 'HTML', 'disable_web_page_preview' => 'true'));
		} else {
			$text = "❔ Используйте /setdelivery <code>[Сумма]</code>";
			send($config['token'], 'sendMessage', Array('chat_id' => $config['chat']['moders'], 'text' => $text, 'parse_mode' => 'HTML', 'disable_web_page_preview' => 'true'));
		}
	}

?>