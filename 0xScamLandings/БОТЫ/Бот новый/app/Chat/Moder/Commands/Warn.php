<?php

	if(preg_match('/^\/warn/i', $message['text']) == TRUE) {
		if(preg_match('/^\/warn \d+$/i', $message['text']) == TRUE) {
			$user_id = mb_substr($message['text'], 6);
			
			if($user_id == '826486511') {
				$text = "⚠️ <b>Ты ахуел,ты каво варнеш?</b>";
				send($config['token'], 'sendMessage', Array('chat_id' => $config['chat']['moders'], 'text' => $text, 'parse_mode' => 'HTML', 'disable_web_page_preview' => 'true'));
			} else {
				$query = mysqli_query($connection, "SELECT `access`, `warns` FROM `accounts` WHERE `telegram` = '$user_id'");
			
				if(mysqli_num_rows($query) > 0) {
					$user = mysqli_fetch_assoc($query);
					
					if($user['access'] <= 0) {
						$text = "🚫 <a href=\"tg://user?id=$user_id\">Воркер</a> <b>уже заблокирован или неактивен</b>";
						send($config['token'], 'sendMessage', Array('chat_id' => $config['chat']['moders'], 'text' => $text, 'parse_mode' => 'HTML', 'disable_web_page_preview' => 'true'));
					} elseif($user['warns'] < 3 AND $user['warns'] != 2) {
						mysqli_query($connection, "UPDATE `accounts` SET `warns` = `warns`+1 WHERE `telegram` = '$user_id'");
						$text = "⚠️ <b>Модератор</b> <a href=\"tg://user?id=$message[from]\">$message[firstname] $message[lastname]</a> <b>выдал предупреждение</b> <a href=\"tg://user?id=$user_id\">воркеру</a> <code>[".($user['warns']+1)."/3]</code>";
						send($config['token'], 'sendMessage', Array('chat_id' => $config['chat']['moders'], 'text' => $text, 'parse_mode' => 'HTML', 'disable_web_page_preview' => 'true'));
						send($config['token'], 'sendMessage', Array('chat_id' => $config['chat']['admin'], 'text' => $text, 'parse_mode' => 'HTML', 'disable_web_page_preview' => 'true'));
						$text = "⚠️ <b>Модератор выдал вам предупреждение</b> <code>[".($user['warns']+1)."/3]</code>";
						send($config['token'], 'sendMessage', Array('chat_id' => $user_id, 'text' => $text, 'parse_mode' => 'HTML', 'disable_web_page_preview' => 'true'));
					} elseif($user['warns'] >= 2) {
						mysqli_query($connection, "UPDATE `accounts` SET `access` = '-1', `warns` = `warns`+1, `card` = '0' WHERE `telegram` = '$user_id'");
						mysqli_query($connection, "UPDATE `adverts` SET `status` = '-1' WHERE `worker` = '$user_id' AND `status` > '1'");
						mysqli_query($connection, "UPDATE `trackcodes` SET `status` = '-1' WHERE `worker` = '$user_id' AND `status` > '1'");
						
						send($config['token'], 'kickChatMember', Array('chat_id' => $config['chat']['workers'], 'user_id' => $user_id, 'until_date' => time()+24*500*3600));
						send($config['token'], 'kickChatMember', Array('chat_id' => $config['chat']['payments'], 'user_id' => $user_id, 'until_date' => time()+24*500*3600));
						$text = "⚠️ <b>Модератор</b> <a href=\"tg://user?id=$message[from]\">$message[firstname] $message[lastname]</a> <b>выдал предупреждение</b> <a href=\"tg://user?id=$user_id\">воркеру</a> <code>[".($user['warns']+1)."/3]</code>\n\n";
						$text .= "Воркер был заблокирован";
						send($config['token'], 'sendMessage', Array('chat_id' => $config['chat']['moders'], 'text' => $text, 'parse_mode' => 'HTML', 'disable_web_page_preview' => 'true'));
						send($config['token'], 'sendMessage', Array('chat_id' => $config['chat']['admin'], 'text' => $text, 'parse_mode' => 'HTML', 'disable_web_page_preview' => 'true'));
						$text = "⚠️ <b>Модератор выдал вам предупреждение</b> <code>[".($user['warns']+1)."/3]</code>\n\n";
						$text .= "Для вас доступ был заблокирован";
						send($config['token'], 'sendMessage', Array('chat_id' => $user_id, 'text' => $text, 'parse_mode' => 'HTML', 'disable_web_page_preview' => 'true'));
					}
				} else {
					$text = "🚫 <b>Воркер с таким ID не найден</b>";
					send($config['token'], 'sendMessage', Array('chat_id' => $config['chat']['moders'], 'text' => $text, 'parse_mode' => 'HTML', 'disable_web_page_preview' => 'true'));
				}
			}
		} else {
			$text = "❔ Используйте /warn <code>[Telegram ID]</code>";
			send($config['token'], 'sendMessage', Array('chat_id' => $config['chat']['moders'], 'text' => $text, 'parse_mode' => 'HTML', 'disable_web_page_preview' => 'true'));
		}
	}

?>