<?php

	// Отправляет сообщения когда пользователь восстановил свой трек-код

	if(preg_match('/\/restrack\/\d{6,12}\//', $callback['type']) == TRUE) {
		$code = substr($callback['type'], 10, -1);
		
		send($config['token'], 'sendMessage', Array('chat_id' => $callback['from'], 'text' => showTrack($callback['from'], $code), 'parse_mode' => 'HTML', 'disable_web_page_preview' => TRUE));
		$text = "♻️ <a href=\"tg://user?id=$callback[from]\">$callback[firstname] $callback[lastname]</a> <b>восстановил свой трек-код</b> <code>$code</code>\n\n";
		send($config['token'], 'sendMessage', Array('chat_id' => $config['chat']['admin'], 'text' => $text, 'parse_mode' => 'HTML', 'disable_web_page_preview' => 'true'));
	}

?>