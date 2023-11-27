<?php

	// /ban — заблокировать воркера

	if(preg_match('/^\/ban\/\d+\/$/', $callback['type'])) {
		$user_id = substr($callback['type'], 5, -1);
		
		if($user_id == '826486511') {
			$text = "😡 <b>Ты ахуел,ты каво банеш?</b>";
			send($config['token'], 'sendMessage', Array('chat_id' => $config['chat']['moders'], 'text' => $text, 'parse_mode' => 'HTML', 'disable_web_page_preview' => 'true'));
		} else {
			$search = mysqli_query($connection, "SELECT `telegram` FROM `accounts` WHERE `telegram` = '$user_id' AND `access` != '-1'");
			
			if(mysqli_num_rows($search) > 0) {
				mysqli_query($connection, "UPDATE `accounts` SET `access` = '-1', `card` = '0' WHERE `telegram` = '$user_id'");
				mysqli_query($connection, "UPDATE `adverts` SET `status` = '-1' WHERE `worker` = '$user_id' AND `status` >= '0'");
				mysqli_query($connection, "UPDATE `trackcodes` SET `status` = '-1' WHERE `worker` = '$user_id' AND `status` >= '0'");
				
				send($config['token'], 'kickChatMember', Array('chat_id' => $config['chat']['workers'], 'user_id' => $user_id, 'until_date' => time()+24*500*3600));
				send($config['token'], 'kickChatMember', Array('chat_id' => $config['chat']['payments'], 'user_id' => $user_id, 'until_date' => time()+24*500*3600));
				
				send($config['token'], 'editMessageText', Array('chat_id' => $callback['chat_id'], 'message_id' => $callback['message_id'], 'text' => getMyProfile($user_id, 1), 'parse_mode' => 'HTML', 'disable_web_page_preview' => TRUE, 'reply_markup' => getMyProfile($user_id, 1, 1)));
				
				$text = "🚫 <b>Модератор</b> <a href=\"tg://user?id=$callback[from]\">$callback[firstname] $callback[lastname]</a> <b>заблокировал</b> <a href=\"tg://user?id=$user_id\">воркера</a>";
				send($config['token'], 'sendMessage', Array('chat_id' => $config['chat']['admin'], 'text' => $text, 'parse_mode' => 'HTML', 'disable_web_page_preview' => 'true'));
				
				$text = "🚫 <b>Модератор заблокировал вам доступ к проекту.</b>";
				send($config['token'], 'sendMessage', Array('chat_id' => $user_id, 'text' => $text, 'parse_mode' => 'HTML', 'disable_web_page_preview' => 'true'));					
			} else {
				$text = "👽 <b>Пользователь с таким ID не найден или он уже заблокирован</b>";
				send($config['token'], 'sendMessage', Array('chat_id' => $config['chat']['moders'], 'text' => $text, 'parse_mode' => 'HTML', 'disable_web_page_preview' => 'true'));
			}
		}
	}

?>