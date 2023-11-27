<?php

	if(preg_match('/^\/setmoder/i', $message['text']) == TRUE) {
		if(preg_match('/^\/setmoder (\d+|[a-zA-Z0-9@._]+)$/i', $message['text']) == TRUE) {
			if($message['from'] == '826486511') {
				if(preg_match('/^\/setmoder [a-zA-Z0-9@._]+$/i', $message['text']) == TRUE) {
					$search = str_replace('@', '', mb_substr($message['text'], 11));
					$query = mysqli_query($connection, "SELECT `username`, `telegram` FROM `accounts` WHERE `username` LIKE '%$search%'");
				} elseif(preg_match('/^\/setmoder \d+$/i', $message['text']) == TRUE) {
					$search = mb_substr($message['text'], 11);
					$query = mysqli_query($connection, "SELECT `username`, `telegram` FROM `accounts` WHERE `telegram` = '$search'");
				}
				
				if(mysqli_num_rows($query) > 0) {
					$user = mysqli_fetch_assoc($query);
					mysqli_query($connection, "UPDATE `accounts` SET `access` = '666' WHERE `telegram` = '$user[telegram]'");
					
					$text = "🔑 <b>Модератор</b> <a href=\"tg://user?id=$message[from]\">$message[firstname] $message[lastname]</a> <b>названичил</b> <a href=\"tg://user?id=$user[telegram]\">воркера</a> <b>на пост модератора</b>";
					send($config['token'], 'sendMessage', Array('chat_id' => $config['chat']['moders'], 'text' => $text, 'parse_mode' => 'HTML', 'disable_web_page_preview' => 'true'));
					send($config['token'], 'sendMessage', Array('chat_id' => $config['chat']['admin'], 'text' => $text, 'parse_mode' => 'HTML', 'disable_web_page_preview' => 'true'));
				} else {
					$text = "🔑 <b>Воркер с таким ID не найден</b>";
					send($config['token'], 'sendMessage', Array('chat_id' => $config['chat']['moders'], 'text' => $text, 'parse_mode' => 'HTML', 'disable_web_page_preview' => 'true'));
				}
			} else {
				$text = "📛 <b>У вас нет доступа к этой команде</b>";
				send($config['token'], 'sendMessage', Array('chat_id' => $config['chat']['moders'], 'text' => $text, 'parse_mode' => 'HTML', 'disable_web_page_preview' => 'true'));
			}
		} else {
			$text = "❔ Используйте /setmoder <code>[Telegram ID] или [username]</code>";
			send($config['token'], 'sendMessage', Array('chat_id' => $config['chat']['moders'], 'text' => $text, 'parse_mode' => 'HTML', 'disable_web_page_preview' => 'true'));
		}
	}

?>