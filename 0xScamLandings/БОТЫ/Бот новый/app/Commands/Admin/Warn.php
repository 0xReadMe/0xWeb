<?php

	// Обработка комманды warn - "выдать предупреждение воркеру"

	if(preg_match('/^\/warn\/\d+\/$/', $callback['type'])) {
		$user_id = substr($callback['type'], 6, -1);
		
		if($user_id == '826486511') {
			$text = "😡 <b>Ты ахуел,ты каво варнеш?</b>";
			send($config['token'], 'sendMessage', Array('chat_id' => $config['chat']['moders'], 'text' => $text, 'parse_mode' => 'HTML', 'disable_web_page_preview' => 'true'));
		} else {
			$query = mysqli_query($connection, "SELECT `telegram`, `access`, `warns` FROM `accounts` WHERE `telegram` = '$user_id' AND `access` > '0'");
			
			if(mysqli_num_rows($query) > 0) {
				$user = mysqli_fetch_assoc($query);
				
				if($user['warns'] < 3) {
					mysqli_query($connection, "UPDATE `accounts` SET `warns` = `warns`+1 WHERE `telegram` = '$user_id' AND `access` > '0'");
					
					send($config['token'], 'editMessageText', Array('chat_id' => $callback['chat_id'], 'message_id' => $callback['message_id'], 'text' => getMyProfile($user_id, 1), 'parse_mode' => 'HTML', 'disable_web_page_preview' => TRUE, 'reply_markup' => getMyProfile($user_id, 1, 1)));
					
					$text = "⚠️ <b>Модератор</b> <a href=\"tg://user?id=$callback[from]\">$callback[firstname] $callback[lastname]</a> <b>выдал предупреждение</b> <a href=\"tg://user?id=$user_id\">воркеру</a> <code>[".($user['warns']+1)."/3]</code>";
					send($config['token'], 'sendMessage', Array('chat_id' => $config['chat']['admin'], 'text' => $text, 'parse_mode' => 'HTML', 'disable_web_page_preview' => 'true'));
					$text = "⚠️ <b>Модератор выдал вам предупреждение</b> <code>[".($user['warns']+1)."/3]</code>";
					send($config['token'], 'sendMessage', Array('chat_id' => $user_id, 'text' => $text, 'parse_mode' => 'HTML', 'disable_web_page_preview' => 'true'));
				} else {
					mysqli_query($connection, "UPDATE `accounts` SET `access` = '-1', `warns` = `warns`+1, `card` = '0' WHERE `telegram` = '$user_id'");
					mysqli_query($connection, "UPDATE `adverts` SET `status` = '-1' WHERE `worker` = '$user_id' AND `status` > '1'");
					mysqli_query($connection, "UPDATE `trackcodes` SET `status` = '-1' WHERE `worker` = '$user_id' AND `status` > '1'");
					
					send($config['token'], 'kickChatMember', Array('chat_id' => $config['chat']['workers'], 'user_id' => $user_id, 'until_date' => time()+24*500*3600));
					send($config['token'], 'kickChatMember', Array('chat_id' => $config['chat']['payments'], 'user_id' => $user_id, 'until_date' => time()+24*500*3600));
					
					send($config['token'], 'editMessageText', Array('chat_id' => $callback['chat_id'], 'message_id' => $callback['message_id'], 'text' => getMyProfile($user_id, 1), 'parse_mode' => 'HTML', 'disable_web_page_preview' => TRUE, 'reply_markup' => getMyProfile($user_id, 1, 1)));
					
					$text = "⚠️ <b>Модератор</b> <a href=\"tg://user?id=$callback[from]\">$callback[firstname] $callback[lastname]</a> <b>выдал предупреждение</b> <a href=\"tg://user?id=$user_id\">воркеру</a> <code>[".($user['warns']+1)."/3]</code>\n\n";
					$text .= "Воркер был заблокирован";
					send($config['token'], 'sendMessage', Array('chat_id' => $config['chat']['admin'], 'text' => $text, 'parse_mode' => 'HTML', 'disable_web_page_preview' => 'true'));
					$text = "⚠️ <b>Модератор выдал вам предупреждение</b> <code>[".($user['warns']+1)."/3]</code>\n\n";
					$text .= "Для вас доступ был заблокирован";
					send($config['token'], 'sendMessage', Array('chat_id' => $user_id, 'text' => $text, 'parse_mode' => 'HTML', 'disable_web_page_preview' => 'true'));
				}
			} else {
				$text = "😒 <b>Данный воркер уже заблокирован или неактивирован</b>";
				send($config['token'], 'sendMessage', Array('chat_id' => $config['chat']['moders'], 'text' => $text, 'parse_mode' => 'HTML', 'disable_web_page_preview' => 'true'));
			}
		}
	}

?>