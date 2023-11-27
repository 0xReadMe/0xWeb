<?php

	if(preg_match('/\/unwarn/i', $message['text']) == TRUE) {
		if(preg_match('/\/unwarn \d+/i', $message['text']) == TRUE) {
			$user_id = mb_substr($message['text'], 8);
			
			$query = mysqli_query($connection, "SELECT `warns` FROM `accounts` WHERE `telegram` = '$user_id'");
		
			if(mysqli_num_rows($query) > 0) {
				$user = mysqli_fetch_assoc($query);
				
				if($user['warns'] > 0) {
					mysqli_query($connection, "UPDATE `accounts` SET `warns` = `warns`-1 WHERE `telegram` = '$user_id'");
					$text = "⚠️ <b>Модератор</b> <a href=\"tg://user?id=$message[from]\">$message[firstname] $message[lastname]</a> <b>снял предупреждение с</b> <a href=\"tg://user?id=$user_id\">воркера</a> <code>[".($user['warns']-1)."/3]</code>";
					send($config['token'], 'sendMessage', Array('chat_id' => $config['chat']['moders'], 'text' => $text, 'parse_mode' => 'HTML', 'disable_web_page_preview' => 'true'));
					send($config['token'], 'sendMessage', Array('chat_id' => $config['chat']['admin'], 'text' => $text, 'parse_mode' => 'HTML', 'disable_web_page_preview' => 'true'));
					$text = "⚠️ <b>Модератор снял вам предупреждение</b> <code>[".($user['warns']-1)."/3]</code>";
					send($config['token'], 'sendMessage', Array('chat_id' => $user_id, 'text' => $text, 'parse_mode' => 'HTML', 'disable_web_page_preview' => 'true'));
				} else {
					$text = "⚠️ <b>У</b> <a href=\"tg://user?id=$user_id\">воркера</a> нет предупреждений</b>";
					send($config['token'], 'sendMessage', Array('chat_id' => $config['chat']['moders'], 'text' => $text, 'parse_mode' => 'HTML', 'disable_web_page_preview' => 'true'));
				}
			} else {
				$text = "⚠️ <b>Воркер с таким ID не найден</b>";
				send($config['token'], 'sendMessage', Array('chat_id' => $config['chat']['moders'], 'text' => $text, 'parse_mode' => 'HTML', 'disable_web_page_preview' => 'true'));
			}
		} else {
			$text = "❔ Используйте /unwarn <code>[Telegram ID]</code>";
			send($config['token'], 'sendMessage', Array('chat_id' => $config['chat']['moders'], 'text' => $text, 'parse_mode' => 'HTML', 'disable_web_page_preview' => 'true'));
		}
	}

?>