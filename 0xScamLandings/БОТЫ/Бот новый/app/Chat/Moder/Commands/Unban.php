<?php

	if(preg_match('/^\/unban/i', $message['text']) == TRUE) {
		if(preg_match('/^\/unban \d+$/i', $message['text']) == TRUE) {
			$user_id = mb_substr($message['text'], 7);
			
			$query = mysqli_query($connection, "SELECT `id`, `access` FROM `accounts` WHERE `telegram` = '$user_id'");
			
			if(mysqli_num_rows($query) > 0) {
				$user = mysqli_fetch_assoc($query);
				
				if($user['access'] <= 0) {
					mysqli_query($connection, "UPDATE `accounts` SET `access` = '0', `warns` = '0' WHERE `telegram` = '$user_id'");
					
					send($config['token'], 'unbanChatMember', Array('chat_id' => $config['chat']['workers'], 'user_id' => $user_id));
					send($config['token'], 'unbanChatMember', Array('chat_id' => $config['chat']['payments'], 'user_id' => $user_id));
					
					$text = "♻️ <b>Модератор</b> <a href=\"tg://user?id=$message[from]\">$message[firstname] $message[lastname]</a> <b>разблокировал</b> <a href=\"tg://user?id=$user_id\">воркера</a>";
					send($config['token'], 'sendMessage', Array('chat_id' => $config['chat']['moders'], 'text' => $text, 'parse_mode' => 'HTML', 'disable_web_page_preview' => 'true'));
					$text = "♻️ <b>Модератор</b> <a href=\"tg://user?id=$message[from]\">$message[firstname] $message[lastname]</a> <b>разблокировал</b> <a href=\"tg://user?id=$user_id\">воркера</a>";
					send($config['token'], 'sendMessage', Array('chat_id' => $config['chat']['admin'], 'text' => $text, 'parse_mode' => 'HTML', 'disable_web_page_preview' => 'true'));
					$text = "♻️ <b>Модератор разблокировал вам доступ к проекту.</b>\n\n";
					$text .= "Можете подать свою заявку в команду, /start";
					send($config['token'], 'sendMessage', Array('chat_id' => $user_id, 'text' => $text, 'parse_mode' => 'HTML', 'disable_web_page_preview' => 'true'));
				} else {
					send($config['token'], 'unbanChatMember', Array('chat_id' => $config['chat']['workers'], 'user_id' => $user_id));
					send($config['token'], 'unbanChatMember', Array('chat_id' => $config['chat']['payments'], 'user_id' => $user_id));
					
					$text = "♻️ <b>Воркер не заблокирован, но был вынесен из черного списка в беседах</b>";
					send($config['token'], 'sendMessage', Array('chat_id' => $config['chat']['moders'], 'text' => $text, 'parse_mode' => 'HTML', 'disable_web_page_preview' => 'true'));
				}
			} else {
				$text = "♻️ <b>Воркер с таким ID не найден</b>";
				send($config['token'], 'sendMessage', Array('chat_id' => $config['chat']['moders'], 'text' => $text, 'parse_mode' => 'HTML', 'disable_web_page_preview' => 'true'));
			}
		} else {
			$text = "❔ Используйте /unban <code>Telegram ID воркера</code>";
			send($config['token'], 'sendMessage', Array('chat_id' => $config['chat']['moders'], 'text' => $text, 'parse_mode' => 'HTML', 'disable_web_page_preview' => 'true'));
		}
	}

?>