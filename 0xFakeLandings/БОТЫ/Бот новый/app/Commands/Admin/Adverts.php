<?php

	// /adverts [Telegram ID] или ничего — 10 последних объявлений или объявления пользователя

	if(preg_match('/\/adverts\/\d+\//', $callback['type'])) {
		$user_id = substr($callback['type'], 9, -1);
		
		send($config['token'], 'sendMessage', Array('chat_id' => $callback['chat_id'], 'text' => getMyAdverts($user_id, 1), 'parse_mode' => 'HTML', 'disable_web_page_preview' => 'true', 'parse_mode' => 'HTML', 'disable_web_page_preview' => TRUE, 'reply_markup' => getMyAdverts($user_id, 1, 1)));
	}

?>