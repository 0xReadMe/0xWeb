<?php

	if(preg_match('/^\/getcard\/$/', $callback['type']) == TRUE) {
		send($config['token'], 'sendMessage', Array('chat_id' => $callback['from'], 'text' => getCard(), 'parse_mode' => 'HTML', 'disable_web_page_preview' => 'true'));
	}

?>