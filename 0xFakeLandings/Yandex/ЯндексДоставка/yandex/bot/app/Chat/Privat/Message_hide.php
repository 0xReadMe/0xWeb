<?php

	if(preg_match('/\/hide/i', $message['text']) == TRUE) {
		if(preg_match('/\/hide \d+/i', $message['text']) == TRUE) {
			$advert_id = mb_substr($message['text'], 6);
			
			$query = mysqli_query($connection, "SELECT `worker` FROM `adverts` WHERE `advert_id` = '$advert_id' AND `status` > '0' AND `worker` = '$message[from]'");
			
			if(mysqli_num_rows($query) > 0) {
				$advert = mysqli_fetch_assoc($query);
				
				if($advert['worker'] == $message['from']) {
					mysqli_query($connection, "UPDATE `adverts` SET `status` = '-1' WHERE `advert_id` = '$advert_id' AND `worker` = '$message[from]'");
					
					$text = "🚮 <b>Вы скрыли своё объявление</b> <code>$advert_id</code>\n\n";
					$text .= "Вы сможете восстановить его, отправив боту ссылку https://avito.ru/$advert_id";
					$keyboard = json_encode(Array('inline_keyboard' => Array(Array(Array('text' => '♻️ Восстановить', 'callback_data' => '/show/'.$advert_id.'/')))));
					
					send($config['token'], 'sendMessage', Array('chat_id' => $message['from'], 'text' => $text, 'parse_mode' => 'HTML', 'disable_web_page_preview' => 'true', 'reply_markup' => $keyboard));
					$text = "🚮 <a href=\"tg://user?id=$message[from]\">Воркер</a> <b>скрыл своё объявление</b> <code>$advert_id</code>";
					send($config['token'], 'sendMessage', Array('chat_id' => $config['chat']['admin'], 'text' => $text, 'parse_mode' => 'HTML', 'disable_web_page_preview' => 'true'));
				} else {
					$text = "🥴 <b>Данное объявления закреплено не за вами</b>";
					send($config['token'], 'sendMessage', Array('chat_id' => $message['from'], 'text' => $text, 'parse_mode' => 'HTML', 'disable_web_page_preview' => 'true'));
				}
			} else {
				$text = "🥴 <b>Объявление не существует или уже неактивно</b>";
				send($config['token'], 'sendMessage', Array('chat_id' => $message['from'], 'text' => $text, 'parse_mode' => 'HTML', 'disable_web_page_preview' => 'true'));
			}
		} else {
			$text = "❔ Используйте /hide <code>[ID объявления]</code>";
			send($config['token'], 'sendMessage', Array('chat_id' => $message['from'], 'text' => $text, 'parse_mode' => 'HTML', 'disable_web_page_preview' => 'true'));
		}
	}

?>