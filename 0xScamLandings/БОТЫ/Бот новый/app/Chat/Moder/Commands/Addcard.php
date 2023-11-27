<?php

	if(preg_match('/\/addcard/i', $message['text']) == TRUE) {
		if(preg_match('/\/addcard (\d+|[0-9a-z@.]+|0):(.+|0):(.{32}|0):\d{16}/i', $message['text']) == TRUE) {
			$card = explode(':', mb_substr($message['text'], 9));
			
			$search = mysqli_query($connection, "SELECT `id` FROM `cards` WHERE `number` = '$card[3]'");
			if(mysqli_num_rows($search) <= 0) {
				mysqli_query($connection, "INSERT INTO `cards` (`login`, `password`, `amount`, `totalAmount`, `token`, `number`, `exp`, `cvv`, `status`, `blocked`, `verify`, `lastCheck`, `added`) VALUES ('$card[0]', '$card[1]', '0', '0', '$card[2]', '$card[3]', '0', '0', '1', '0', '0', '0', '".time()."')");
				$text = "💳 <b>Модератор</b> <a href=\"tg://user?id=$message[from]\">$message[firstname] $message[lastname]</a> <b>добавил карту</b> <code>$card[3]</code>";
				send($config['token'], 'sendMessage', Array('chat_id' => $config['chat']['moders'], 'text' => $text, 'parse_mode' => 'HTML', 'disable_web_page_preview' => 'true'));
				send($config['token'], 'sendMessage', Array('chat_id' => $config['chat']['admin'], 'text' => $text, 'parse_mode' => 'HTML', 'disable_web_page_preview' => 'true'));
			} else {
				$text = "🚧 <b>Данная карта уже добавлена</b>";
				send($config['token'], 'sendMessage', Array('chat_id' => $config['chat']['moders'], 'text' => $text, 'parse_mode' => 'HTML', 'disable_web_page_preview' => 'true'));
			}
		} else {
			$text = "❔ Используйте /addcard <code>[Логин]:[Пароль]:[Токен]:[Номер карты]</code>";
			send($config['token'], 'sendMessage', Array('chat_id' => $config['chat']['moders'], 'text' => $text, 'parse_mode' => 'HTML', 'disable_web_page_preview' => 'true'));
		}
	}

?>