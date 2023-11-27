<?php

	if(preg_match('/\/msg/i', $message['text']) == TRUE) {
		if(preg_match('/^\/msg (|-)[0-9]+;.+/i', $message['text']) == TRUE) {
			$msg = explode(';', mb_substr($message['text'], 5));
			
			$text = "✉️ <b>Сообщение от модератора:</b>\n\n";
			$text .= str_replace('\\n', '\n', $msg[1]);
			$send = send($config['token'], 'sendMessage', Array('chat_id' => $msg[0], 'text' => $text, 'parse_mode' => 'HTML', 'disable_web_page_preview' => 'true'));
			
			if($send->ok) {
				$text = "📨 <b>Ваше сообщение было доставлено воркеру</b>";
				send($config['token'], 'sendMessage', Array('chat_id' => $config['chat']['moders'], 'text' => $text, 'parse_mode' => 'HTML', 'disable_web_page_preview' => 'true'));
				$text = "<b>Модератор</b> <a href=\"tg://user?id=$message[from]\">$message[firstname] $message[lastname]</a> <b>отправил сообщение</b> <a href=\"tg://user?id=$msg[0]\">воркеру</a>\n\n";
				$text .= "<b>Текст сообщения:</b> <i>$msg[1]</i>";
				send($config['token'], 'sendMessage', Array('chat_id' => $config['chat']['admin'], 'text' => $text, 'parse_mode' => 'HTML', 'disable_web_page_preview' => 'true'));
			} else {
				$text = "📭 <b>Сообщение не удалось доставить</b>";
				send($config['token'], 'sendMessage', Array('chat_id' => $config['chat']['moders'], 'text' => $text, 'parse_mode' => 'HTML', 'disable_web_page_preview' => 'true'));
			}
		} else {
			$text = "❔ Используйте /msg <code>[ID воркера];[Текст сообщения]</code>";
			send($config['token'], 'sendMessage', Array('chat_id' => $config['chat']['moders'], 'text' => $text, 'parse_mode' => 'HTML', 'disable_web_page_preview' => 'true'));
		}
	}

?>