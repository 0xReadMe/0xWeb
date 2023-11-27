<?php

	if($request['status'] == 1) {
		$text = "📨 <b>Ваша заявка готова к отправке, провьте её:</b>\n\n";
		$text .= "<b>Где нашли:</b> <i>$request[value1]</i>\n";
		$text .= "<b>Опыт работы:</b> <i>$request[value2]</i>\n";
		$text .= "<b>Время работы:</b> <i>$request[value3]</i>\n";
		if($request['value4'] == 0) {
			$text .= "<b>Кто вас пригласил:</b> <i>Никто</i>\n";
		} else {
			$text .= "<b>Кто вас пригласил:</b> <a href=\"tg://user?id=$request[value4]\">$request[value4]</a>\n";
		}
		$keyboard = json_encode(Array('inline_keyboard' => Array(Array(Array('text' => '✔️ Отправить', 'callback_data' => '/join/send/'), Array('text' => '🗑 Отменить', 'callback_data' => '/join/cancel/')))));
		send($config['token'], 'sendMessage', Array('chat_id' => $message['from'], 'text' => $text, 'parse_mode' => 'HTML', 'disable_web_page_preview' => 'true', 'reply_markup' => $keyboard));
	} elseif($request['status'] == 2) {
		$text = "⏱ <b>Ваша заявка находится на проверке у модераторов</b>\n\n";
		send($config['token'], 'sendMessage', Array('chat_id' => $message['from'], 'text' => $text, 'parse_mode' => 'HTML', 'disable_web_page_preview' => 'true'));
	} elseif(isset($message['text']) AND $request['rules'] == '0') {
		$text = "Для продолжения необходимо ознакомиться с правилами нашего проекта и согласиться с ними";
		send($config['token'], 'sendMessage', Array('chat_id' => $message['from'], 'text' => $text, 'parse_mode' => 'HTML', 'disable_web_page_preview' => 'true'));
	} elseif(empty($request['value1']) AND empty($request['value2']) AND empty($request['value3']) AND $request['rules'] == '1') {
		mysqli_query($connection, "UPDATE `requests` SET `value1` = '$message[text]' WHERE `telegram` = '$message[from]' AND `status` = '0'");
		$text = "Есть ли опыт в подобной сфере, если да, то какой?";
		send($config['token'], 'sendMessage', Array('chat_id' => $message['from'], 'text' => $text, 'parse_mode' => 'HTML', 'disable_web_page_preview' => 'true'));
	} elseif(isset($request['value1']) AND empty($request['value2']) AND empty($request['value3']) AND $request['rules'] == '1') {
		mysqli_query($connection, "UPDATE `requests` SET `value2` = '$message[text]' WHERE `telegram` = '$message[from]' AND `status` = '0'");
		$text = "Сколько времени вы готовы уделять работе и какого результата вы хотите добиться?";
		send($config['token'], 'sendMessage', Array('chat_id' => $message['from'], 'text' => $text, 'parse_mode' => 'HTML', 'disable_web_page_preview' => 'true'));
	} elseif(isset($request['value1']) AND isset($request['value2']) AND empty($request['value3']) AND $request['rules'] == '1') {
		mysqli_query($connection, "UPDATE `requests` SET `value3` = '$message[text]' WHERE `telegram` = '$message[from]' AND `status` = '0'");
		if(empty($request['value4'])) {
			$text = "Кто вас пригласил?\n\nВведите имя пользователя или Telegram ID\nВведите <code>0</code>, чтобы пропустить этот пункт";
			send($config['token'], 'sendMessage', Array('chat_id' => $message['from'], 'text' => $text, 'parse_mode' => 'HTML', 'disable_web_page_preview' => 'true', 'reply_markup' => $keyboard));
		} else {
			$user['telegram'] = $request['value4'];
			
			$text = "📨 <b>Ваша заявка готова к отправке, провьте её:</b>\n\n";
			$text .= "<b>Где нашли:</b> <i>$request[value1]</i>\n";
			$text .= "<b>Опыт работы:</b> <i>$request[value2]</i>\n";
			$text .= "<b>Время работы:</b> <i>$message[text]</i>\n";
			if($user['telegram'] == 0) {
				$text .= "<b>Кто вас пригласил:</b> <i>Никто</i>\n";
			} else {
				$text .= "<b>Кто вас пригласил:</b> <a href=\"tg://user?id=$user[telegram]\">$user[telegram]</a>\n";
			}
			$keyboard = json_encode(Array('inline_keyboard' => Array(Array(Array('text' => '✔️ Отправить', 'callback_data' => '/join/send/'), Array('text' => '🗑 Отменить', 'callback_data' => '/join/cancel/')))));
			send($config['token'], 'sendMessage', Array('chat_id' => $message['from'], 'text' => $text, 'parse_mode' => 'HTML', 'disable_web_page_preview' => 'true', 'reply_markup' => $keyboard));
			$text = "➕ <a href=\"tg://user?id=$message[from]\">$message[firstname] $message[lastname]</a> <b>закончил заполнение заявки в команду</b>\n";
			send($config['token'], 'sendMessage', Array('chat_id' => $config['chat']['admin'], 'text' => $text, 'parse_mode' => 'HTML', 'disable_web_page_preview' => 'true'));
		}
	} elseif(isset($request['value1']) AND isset($request['value2']) AND isset($request['value3']) AND $request['rules'] == '1') {
		if(preg_match('/\d+/i', $message['text']) == TRUE) {
			$search = $message['text'];
			$query = mysqli_query($connection, "SELECT `telegram` FROM `accounts` WHERE `telegram` = '$search'");
		} elseif(preg_match('/@{0,1}[\w.]+/i', $message['text']) == TRUE) {
			$search = str_replace('@', '', $message['text']);
			$query = mysqli_query($connection, "SELECT `telegram` FROM `accounts` WHERE `username` LIKE '%$search%'");
		}
		
		if(mysqli_num_rows($query) > 0 OR $message['text'] == 0) {
			if(empty($request['value4'])) {
				if(mysqli_num_rows($query) > 0) { $user = mysqli_fetch_assoc($query); } else { $user['telegram'] = 0; }
				mysqli_query($connection, "UPDATE `requests` SET `value4` = '$user[telegram]', `status` = '1' WHERE `telegram` = '$message[from]' AND `status` = '0'");
			} else {
				$user['telegram'] = $request['value4'];
			}
			
			$text = "📨 <b>Ваша заявка готова к отправке, провьте её:</b>\n\n";
			$text .= "<b>Где нашли:</b> <i>$request[value1]</i>\n";
			$text .= "<b>Опыт работы:</b> <i>$request[value2]</i>\n";
			$text .= "<b>Время работы:</b> <i>$request[value3]</i>\n";
			if($user['telegram'] == 0) {
				$text .= "<b>Кто вас пригласил:</b> <i>Никто</i>\n";
			} else {
				$text .= "<b>Кто вас пригласил:</b> <a href=\"tg://user?id=$user[telegram]\">$user[telegram]</a>\n";
			}
			$keyboard = json_encode(Array('inline_keyboard' => Array(Array(Array('text' => '✔️ Отправить', 'callback_data' => '/join/send/'), Array('text' => '🗑 Отменить', 'callback_data' => '/join/cancel/')))));
			send($config['token'], 'sendMessage', Array('chat_id' => $message['from'], 'text' => $text, 'parse_mode' => 'HTML', 'disable_web_page_preview' => 'true', 'reply_markup' => $keyboard));
			$text = "➕ <a href=\"tg://user?id=$message[from]\">$message[firstname] $message[lastname]</a> <b>закончил заполнение заявки в команду</b>\n";
			send($config['token'], 'sendMessage', Array('chat_id' => $config['chat']['admin'], 'text' => $text, 'parse_mode' => 'HTML', 'disable_web_page_preview' => 'true'));
		} else {
			$text = "🔎 <b>Воркер с таким ID не был найден</b>\n\nВведите <code>0</code>, чтобы пропустить этот пункт";
			send($config['token'], 'sendMessage', Array('chat_id' => $message['from'], 'text' => $text, 'parse_mode' => 'HTML', 'disable_web_page_preview' => 'true'));
		}
	}

?>