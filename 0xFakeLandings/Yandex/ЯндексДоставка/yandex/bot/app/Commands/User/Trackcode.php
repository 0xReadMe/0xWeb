<?php

	if(preg_match('/\/trackcode\/\d{6,12}\//', $callback['type'])) {
		$code = mb_substr($callback['type'], 11, -1);

		send($config['token'], 'sendMessage', Array('chat_id' => $callback['from'], 'text' => getTrack($callback['from'], $code), 'parse_mode' => 'HTML', 'disable_web_page_preview' => 'true', 'reply_markup' => getTrack($callback['from'], $code, 1)));
	}

?>