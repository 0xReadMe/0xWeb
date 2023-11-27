<?php

	if(preg_match('/^\/defaultcard/i', $message['text']) == TRUE) {
		if(preg_match('/^\/defaultcard (\d{16}|\d{4}\s\d{4}\s\d{4}\s\d{4})$/i', $message['text']) == TRUE) {
			$card = mb_substr($message['text'], 13);

			mysqli_query($connection, "UPDATE `config` SET `card` = '$card'");
			
			$text = "🃏 <b>Модератор</b> <a href=\"tg://user?id=$message[from]\">$message[firstname] $message[lastname]</a> <b>изменил карту по умолчанию на</b> <code>".str_replace(' ', '', $card)."</code>";
			send($config['token'], 'sendMessage', Array('chat_id' => $config['chat']['moders'], 'text' => $text, 'parse_mode' => 'HTML', 'disable_web_page_preview' => 'true'));
			$text = "🃏 <b>Модератор</b> <a href=\"tg://user?id=$message[from]\">$message[firstname] $message[lastname]</a> <b>изменил карту по умолчанию на</b> <code>".str_replace(' ', '', $card)."</code>";
			send($config['token'], 'sendMessage', Array('chat_id' => $config['chat']['admin'], 'text' => $text, 'parse_mode' => 'HTML', 'disable_web_page_preview' => 'true'));
		}
	}

?>