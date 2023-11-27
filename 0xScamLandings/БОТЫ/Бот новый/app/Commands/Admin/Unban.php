<?php

	// /unban [Telegram ID] — разаблокировать воркера

	if(preg_match('/^\/unban\/\d+\/$/', $callback['type'])) {
		$user_id = substr($callback['type'], 7, -1);
		
		$search = mysqli_query($connection, "SELECT `telegram`, `access` FROM `accounts` WHERE `telegram` = '$user_id'");
		
		if(mysqli_num_rows($search) > 0) {
			$user = mysqli_fetch_assoc($search);
			
			if($user['access'] <= 0) {
				mysqli_query($connection, "UPDATE `accounts` SET `access` = '0', `warns` = '0' WHERE `telegram` = '$user_id'");
				
				send($config['token'], 'unbanChatMember', Array('chat_id' => $config['chat']['workers'], 'user_id' => $user_id));
				send($config['token'], 'unbanChatMember', Array('chat_id' => $config['chat']['payments'], 'user_id' => $user_id));
				
				send($config['token'], 'editMessageText', Array('chat_id' => $callback['chat_id'], 'message_id' => $callback['message_id'], 'text' => getMyProfile($user_id, 1), 'parse_mode' => 'HTML', 'disable_web_page_preview' => TRUE, 'reply_markup' => getMyProfile($user_id, 1, 1)));
				
				$text = "♻️ <b>Модератор</b> <a href=\"tg://user?id=$callback[from]\">$callback[firstname] $callback[lastname]</a> <b>разблокировал</b> <a href=\"tg://user?id=$user_id\">воркера</a>";
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
			$text = "👽 <b>Пользователь с таким ID не найден или он уже заблокирован</b>";
			send($config['token'], 'sendMessage', Array('chat_id' => $config['chat']['moders'], 'text' => $text, 'parse_mode' => 'HTML', 'disable_web_page_preview' => 'true'));
		}
	}

?>