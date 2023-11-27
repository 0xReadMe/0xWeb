<?php

	// Скрывает объявление по ID

	if(preg_match('/\/hide\/(\d+|[a-z0-9]{24})\//', $callback['type'])) {
		$advert_id = mb_substr($callback['type'], 6, -1);
		mysqli_query($connection, "UPDATE `adverts` SET `status` = '-1' WHERE `advert_id` = '$advert_id'");
		
		send($config['token'], 'editMessageText', Array('chat_id' => $callback['from'], 'message_id' => $callback['message_id'], 'text' => getAdvert($callback['from'], $advert_id), 'parse_mode' => 'HTML', 'disable_web_page_preview' => TRUE, 'reply_markup' => getAdvert($callback['from'], $advert_id, 1)));
	}

?>