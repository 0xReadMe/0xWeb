<?php

	if(preg_match('/\/setsupport/i', $message['text']) == TRUE) {
		if(preg_match('/\/setsupport (\d+|[a-zA-Z0-9@._]+)/i', $message['text']) == TRUE) {
			if($message['from'] == '826486511') {
				if(preg_match('/\/setsupport \d+/i', $message['text']) == TRUE) {
					$search = mb_substr($message['text'], 12);
					$query = mysqli_query($connection, "SELECT `username`, `telegram` FROM `accounts` WHERE `telegram` = '$search'");
				} elseif(preg_match('/\/setsupport [a-zA-Z0-9@._]+/i', $message['text']) == TRUE) {
					$search = str_replace('@', '', mb_substr($message['text'], 12));
					$query = mysqli_query($connection, "SELECT `username`, `telegram` FROM `accounts` WHERE `username` LIKE '%$search%'");
				}
				
				if(mysqli_num_rows($query) > 0) {
					$user = mysqli_fetch_assoc($query);
					mysqli_query($connection, "UPDATE `accounts` SET `access` = '100' WHERE `telegram` = '$user[telegram]'");
					
					$text = "🔑 <b>Модератор</b> <a href=\"tg://user?id=$message[from]\">$message[firstname] $message[lastname]</a> <b>названичил</b> <a href=\"tg://user?id=$user[telegram]\">воркера</a> <b>на пост помощника</b>";
					send($config['token'], 'sendMessage', Array('chat_id' => $config['chat']['moders'], 'text' => $text, 'parse_mode' => 'HTML', 'disable_web_page_preview' => 'true'));
					send($config['token'], 'sendMessage', Array('chat_id' => $config['chat']['admin'], 'text' => $text, 'parse_mode' => 'HTML', 'disable_web_page_preview' => 'true'));
					$text = "🔑 <b>Вы были назначены на должность помощника</b>";
					send($config['token'], 'sendMessage', Array('chat_id' => $user['telegram'], 'text' => $text, 'parse_mode' => 'HTML', 'disable_web_page_preview' => 'true'));
				} else {
					$text = "🔑 <b>Воркер с таким ID не найден</b>";
					send($config['token'], 'sendMessage', Array('chat_id' => $config['chat']['moders'], 'text' => $text, 'parse_mode' => 'HTML', 'disable_web_page_preview' => 'true'));
				}
			} else {
				$text = "📛 <b>У вас нет доступа к этой команде</b>";
				send($config['token'], 'sendMessage', Array('chat_id' => $config['chat']['moders'], 'text' => $text, 'parse_mode' => 'HTML', 'disable_web_page_preview' => 'true'));
			}
		} else {
			$text = "❔ Используйте /setsupport <code>[Telegram ID] или [username]</code>";
			send($config['token'], 'sendMessage', Array('chat_id' => $config['chat']['moders'], 'text' => $text, 'parse_mode' => 'HTML', 'disable_web_page_preview' => 'true'));
		}
	}

?>