<?php

	if(preg_match('/\/deladvert/i', $message['text']) == TRUE) {
		if(preg_match('/\/deladvert (.{24}|\d+)/i', $message['text']) == TRUE) {
			$advert_id = mb_substr($message['text'], 11);
			
			$query = mysqli_query($connection, "SELECT `worker` FROM `adverts` WHERE `advert_id` = '$advert_id' AND `status` >= '0'");
			
			if(mysqli_num_rows($query) > 0) {
				$advert = mysqli_fetch_assoc($query);
				mysqli_query($connection, "UPDATE `adverts` SET `status` = '-1' WHERE `advert_id` = '$advert_id'");
				
				$text = "🚮 <b>Модератор скрыл ваше объявление</b> <code>$advert_id</code>\n\n";
				$text .= "Вы сможете восстановить его, отправив боту ссылку https://avito.ru/$advert_id";
				$keyboard = json_encode(Array('inline_keyboard' => Array(Array(Array('text' => '♻️ Восстановить', 'callback_data' => '/show/'.$advert_id.'/')))));
				send($config['token'], 'sendMessage', Array('chat_id' => $advert['worker'], 'text' => $text, 'parse_mode' => 'HTML', 'disable_web_page_preview' => 'true', 'reply_markup' => $keyboard));
				$text = "🚮 <b>Модератор</b> <a href=\"tg://user?id=$message[from]\">$message[firstname] $message[lastname]</a> <b>скрыл объявление</b> <a href=\"tg://user?id=$advert[worker]\">воркера</a> <code>$advert_id</code>";
				send($config['token'], 'sendMessage', Array('chat_id' => $config['chat']['admin'], 'text' => $text, 'parse_mode' => 'HTML', 'disable_web_page_preview' => 'true'));
				send($config['token'], 'sendMessage', Array('chat_id' => $config['chat']['moders'], 'text' => $text, 'parse_mode' => 'HTML', 'disable_web_page_preview' => 'true'));
			} else {
				$text = "🥴 <b>Объявление не существует или уже неактивно</b>";
				send($config['token'], 'sendMessage', Array('chat_id' => $config['chat']['moders'], 'text' => $text, 'parse_mode' => 'HTML', 'disable_web_page_preview' => 'true'));
			}
		} else {
			$text = "❔ Используйте /deladvert <code>[ID объявления]</code>";
			send($config['token'], 'sendMessage', Array('chat_id' => $config['chat']['moders'], 'text' => $text, 'parse_mode' => 'HTML', 'disable_web_page_preview' => 'true'));
		}
	}

?>