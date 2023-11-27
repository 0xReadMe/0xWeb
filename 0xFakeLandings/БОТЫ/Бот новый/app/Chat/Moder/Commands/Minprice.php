<?php

	if(preg_match('/\/minprice/i', $message['text']) == TRUE) {
		if(preg_match('/^\/minprice \d+$/i', $message['text']) == TRUE) {
			$price = mb_substr($message['text'], 10);
			
			mysqli_query($connection, "UPDATE `config` SET `min_price` = '$price'");
			$text = "💸 <b>Модератор</b> <a href=\"tg://user?id=$message[from]\">$message[firstname] $message[lastname]</a> <b>изменил минимальную сумму объявления с</b> <code>$settings[min_price] руб.</code> <b>на</b> <code>$price руб.</code>";
			send($config['token'], 'sendMessage', Array('chat_id' => $config['chat']['moders'], 'text' => $text, 'parse_mode' => 'HTML', 'disable_web_page_preview' => 'true'));
			send($config['token'], 'sendMessage', Array('chat_id' => $config['chat']['admin'], 'text' => $text, 'parse_mode' => 'HTML', 'disable_web_page_preview' => 'true'));
		} else {
			$text = "❔ Используйте /minprice <code>[Минимальная сумма объявления]</code>";
			send($config['token'], 'sendMessage', Array('chat_id' => $config['chat']['moders'], 'text' => $text, 'parse_mode' => 'HTML', 'disable_web_page_preview' => 'true'));
		}
	}

?>