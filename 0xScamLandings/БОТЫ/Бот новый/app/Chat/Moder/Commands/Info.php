<?php

	if(preg_match('/\/info/i', $message['text']) == TRUE) {
		if(preg_match('/\/info (\d+|@{0,1}[\w.]+)/i', $message['text']) == TRUE) {
			if(preg_match('/\/info \d+/i', $message['text']) == TRUE) {
				$search = mb_substr($message['text'], 6);
				$query = mysqli_query($connection, "SELECT `username`, `telegram`, `stake`, `card`, `balance`, `access`, `inviter`, `warns`, `created` FROM `accounts` WHERE `telegram` = '$search'");
			} elseif(preg_match('/\/info @{0,1}[\w.]+/i', $message['text']) == TRUE) {
				$search = str_replace('@', '', mb_substr($message['text'], 6));
				$query = mysqli_query($connection, "SELECT `username`, `telegram`, `stake`, `card`, `balance`, `access`, `inviter`, `warns`, `created` FROM `accounts` WHERE `username` LIKE '%$search%'");
			}
			
			if(mysqli_num_rows($query) > 0) {
				$user = mysqli_fetch_assoc($query);
				
				send($config['token'], 'sendMessage', Array('chat_id' => $config['chat']['moders'], 'text' => getMyProfile($user['telegram'], 1), 'parse_mode' => 'HTML', 'disable_web_page_preview' => 'true', 'reply_markup' => getMyProfile($user['telegram'], 1, 1)));
			} else {
				$text = "🥺 <b>Воркера с таким ником или ID не найдено</b> $search";
				send($config['token'], 'sendMessage', Array('chat_id' => $config['chat']['moders'], 'text' => $text, 'parse_mode' => 'HTML', 'disable_web_page_preview' => 'true'));
			}
		} else {
			$text = "❔ Используйте /info <code>Telegram ID или никнейм воркера</code>";
			send($config['token'], 'sendMessage', Array('chat_id' => $config['chat']['moders'], 'text' => $text, 'parse_mode' => 'HTML', 'disable_web_page_preview' => 'true'));
		}
	}

?>