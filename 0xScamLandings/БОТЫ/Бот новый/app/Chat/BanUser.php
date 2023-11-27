<?php

	// Сообщения в чат когда пользователя банят или блокируют

	if($message['chat_id'] == $config['chat']['workers'] AND isset($data->{'message'}->{'left_chat_member'})) {
		if($message['from'] != '771170005') {
			mysqli_query($connection, "UPDATE `accounts` SET `access` = '0' WHERE `telegram` = '$message[from]'");
			$text .= "🚷 <a href=\"tg://user?id=$message[from]\">$message[firstname] $message[lastname]</a> <b>покинул чат воркеров и был заблокирован</b>\n";
			send($config['token'], 'sendMessage', Array('chat_id' => $config['chat']['admin'], 'text' => $text, 'parse_mode' => 'HTML', 'disable_web_page_preview' => 'true'));
		} else {
			$text .= "🚷 <b>Модератор</b> <a href=\"tg://user?id=$message[from]\">$message[firstname] $message[lastname]</a> <b>исключил пользотвалея из чата воркеров</b>\n";
			send($config['token'], 'sendMessage', Array('chat_id' => $config['chat']['admin'], 'text' => $text, 'parse_mode' => 'HTML', 'disable_web_page_preview' => 'true'));
		}
	}

?>