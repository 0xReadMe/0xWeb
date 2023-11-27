<?php

	if(preg_match('/^\/ban/i', $message['text']) == TRUE) {
		if(preg_match('/^\/ban \d+$/i', $message['text']) == TRUE) {
			$user_id = mb_substr($message['text'], 5);
			
			if($user_id == '826486511') {
				$text = "😡 <b>Ты ахуел,ты каво банеш?</b>";
				send($config['token'], 'sendMessage', Array('chat_id' => $config['chat']['moders'], 'text' => $text, 'parse_mode' => 'HTML', 'disable_web_page_preview' => 'true'));
			} else {
				$query = mysqli_query($connection, "SELECT `id` FROM `accounts` WHERE `telegram` = '$user_id'");
			
				if(mysqli_num_rows($query) > 0) {
					mysqli_query($connection, "UPDATE `accounts` SET `access` = '-1', `card` = '0' WHERE `telegram` = '$user_id'");
					mysqli_query($connection, "UPDATE `adverts` SET `status` = '-1' WHERE `worker` = '$user_id' AND `status` >= '0'");
					mysqli_query($connection, "UPDATE `trackcodes` SET `status` = '-1' WHERE `worker` = '$user_id' AND `status` >= '0'");
					
					send($config['token'], 'kickChatMember', Array('chat_id' => $config['chat']['workers'], 'user_id' => $user_id, 'until_date' => time()+24*500*3600));
					send($config['token'], 'kickChatMember', Array('chat_id' => $config['chat']['payments'], 'user_id' => $user_id, 'until_date' => time()+24*500*3600));
					
					$text = "🚫 <b>Модератор</b> <a href=\"tg://user?id=$message[from]\">$message[firstname] $message[lastname]</a> <b>заблокировал</b> <a href=\"tg://user?id=$user_id\">воркера</a>";
					send($config['token'], 'sendMessage', Array('chat_id' => $config['chat']['moders'], 'text' => $text, 'parse_mode' => 'HTML', 'disable_web_page_preview' => 'true'));
					$text = "🚫 <b>Модератор</b> <a href=\"tg://user?id=$message[from]\">$message[firstname] $message[lastname]</a> <b>заблокировал</b> <a href=\"tg://user?id=$user_id\">воркера</a>";
					send($config['token'], 'sendMessage', Array('chat_id' => $config['chat']['admin'], 'text' => $text, 'parse_mode' => 'HTML', 'disable_web_page_preview' => 'true'));
					$text = "🚫 <b>Модератор заблокировал вам доступ к проекту.</b>";
					send($config['token'], 'sendMessage', Array('chat_id' => $user_id, 'text' => $text, 'parse_mode' => 'HTML', 'disable_web_page_preview' => 'true'));
				} else {
					mysqli_query($connection, "INSERT INTO `accounts` (`username`, `telegram`, `access`, `stake`, `card`, `created`) VALUES ('username', '$user_id', '-1', '0', '0', '".time()."')");
					send($config['token'], 'kickChatMember', Array('chat_id' => $config['chat']['workers'], 'user_id' => $user_id, 'until_date' => time()+24*500*3600));
					send($config['token'], 'kickChatMember', Array('chat_id' => $config['chat']['payments'], 'user_id' => $user_id, 'until_date' => time()+24*500*3600));
					$text = "🚫 <b>Воркер с таким ID не найден, но был заблокирован</b>";
					send($config['token'], 'sendMessage', Array('chat_id' => $config['chat']['moders'], 'text' => $text, 'parse_mode' => 'HTML', 'disable_web_page_preview' => 'true'));
					$text = "🚫 <b>Модератор</b> <a href=\"tg://user?id=$message[from]\">$message[firstname] $message[lastname]</a> <b>заблокировал</b> <a href=\"tg://user?id=$user_id\">пользователя</a> <b>с Telegram ID:</b> <code>$user_id</code>";
					send($config['token'], 'sendMessage', Array('chat_id' => $config['chat']['admin'], 'text' => $text, 'parse_mode' => 'HTML', 'disable_web_page_preview' => 'true'));
				}
			}
		} else {
			$text = "❔ Используйте /ban <code>Telegram ID воркера</code>";
			send($config['token'], 'sendMessage', Array('chat_id' => $config['chat']['moders'], 'text' => $text, 'parse_mode' => 'HTML', 'disable_web_page_preview' => 'true'));
		}
	}

?>