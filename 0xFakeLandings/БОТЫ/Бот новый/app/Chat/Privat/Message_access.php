<?php

	if($users['access'] == '-1') {
		$text = "🚫 <b>Ваш аккаунт заблокирован</b>\n\n";
		$text .= "Если это ошибка, то обратитесь к @cat_avito";
		send($config['token'], 'sendMessage', Array('chat_id' => $message['from'], 'text' => $text, 'parse_mode' => 'HTML', 'disable_web_page_preview' => 'true'));
	} elseif(preg_match('/^\/start ref\d+$/i', $message['text']) == TRUE) {
		$referral_id = mb_substr($message['text'], 10);
		
		mysqli_query($connection, "INSERT INTO `requests` (`username`, `name`, `telegram`, `value4`, `rules`, `status`, `time`) VALUES ('$message[username]', '$message[firstname] $message[lastname]', '$message[from]', '$referral_id', '0', '0', '".time()."')");
	
	    $text = "ДЛЯ ПОДАЧИ ЗАЯВКИ ОБЯЗАТЕЛЬНО УДАЛИТЕ ВСЕ СМАЙЛЫ ИЗ НИКА\n";
		$text = "1. Запрещено медиа с некорректным содержанием (порно, насилие, убийства, призывы к экстремизму, реклама наркотиков)\n";
		$text .= "2. Запрещен спам, флуд, пересылки с других каналов, ссылки на сторонние ресурсы\n";
		$text .= "3. Запрещено узнавать у друг друга персональную информацию\n";
		$text .= "4. Запрещено оскорблять администрацию\n";
		$text .= "5. Запрещено попрошайничество в беседе работников\n";
		$text .= "6. Администрация не несёт ответственности за блокировку ваших кошельков/карт\n";
		$text .= "\nВы подтверждаете, что ознакомились и согласны с условиями и правилами нашего проекта?";
		$keyboard = json_encode(Array('inline_keyboard' => Array(Array(Array('text' => '✅ Полностью согласен', 'callback_data' => '/join/accept/')))));
		
		send($config['token'], 'sendMessage', Array('chat_id' => $message['from'], 'text' => $text, 'parse_mode' => 'HTML', 'disable_web_page_preview' => 'true', 'reply_markup' => $keyboard));
	} else {
		$text = "🤨 <b>Здравствуйте. Что бы начать работать</b>\n\n";
		$text .= "Просто подайте заявку 👇🏿";
		$keyboard = json_encode(Array('inline_keyboard' => Array(Array(Array('text' => '➕ Подать заявку', 'callback_data' => '/join/')))));
		send($config['token'], 'sendMessage', Array('chat_id' => $message['from'], 'text' => $text, 'parse_mode' => 'HTML', 'disable_web_page_preview' => 'true', 'reply_markup' => $keyboard));
	}

?>