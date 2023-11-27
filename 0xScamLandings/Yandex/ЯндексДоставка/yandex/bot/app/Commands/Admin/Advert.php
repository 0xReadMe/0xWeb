<?php

	// /advert [ID объявления] — Подробная информация об объявлении

	if(preg_match('/\/advert\/(\d+|[a-z0-9]{24})\//', $callback['type'])) {
		$advert_id = mb_substr($callback['type'], 8, -1);
		
		send($config['token'], 'sendMessage', Array('chat_id' => $callback['chat_id'], 'text' => getAdvert($callback['from'], $advert_id), 'parse_mode' => 'HTML', 'disable_web_page_preview' => 'true', 'reply_markup' => getAdvert($callback['from'], $advert_id, 1)));
	}

?>