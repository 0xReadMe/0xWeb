<?php

	if(preg_match('/^\/stake/i', $message['text']) == TRUE) {
		if(preg_match('/^\/stake [0-9]{1,3};[0-9]{1,3}$/i', $message['text']) == TRUE) {
			$stake = explode(';', mb_substr($message['text'], 7));
			
			if($stake[0] <= 100 AND $stake[1] <= 100) {
				$curStake = explode(':', $settings['stake']);
				mysqli_query($connection, "UPDATE `config` SET `stake` = '$stake[0]:$stake[1]'");
				mysqli_query($connection, "UPDATE `accounts` SET `stake` = '$stake[0]:$stake[1]' WHERE `stake` = '$settings[stake]'");
				
				$text = "💯 <b>Модераторы изменили текущую ставку</b>\n\n";
				$text .= "Оплата — <b>$stake[0]%</b> и вовзрат <b>$stake[1]%</b>";
				send($config['token'], 'sendMessage', Array('chat_id' => $config['chat']['workers'], 'text' => $text, 'parse_mode' => 'HTML', 'disable_web_page_preview' => 'true'));
				$text = "💯 <b>Модератор</b> <a href=\"tg://user?id=$message[from]\">$message[firstname] $message[lastname]</a> <b>изменил ставку с</b> <code>оплата - $curStake[0]% и вовзрат - $curStake[1]</code> <b>на</b> <code>оплата - $stake[0]% и вовзрат - $stake[1]</code>";
				send($config['token'], 'sendMessage', Array('chat_id' => $config['chat']['moders'], 'text' => $text, 'parse_mode' => 'HTML', 'disable_web_page_preview' => 'true'));
				send($config['token'], 'sendMessage', Array('chat_id' => $config['chat']['admin'], 'text' => $text, 'parse_mode' => 'HTML', 'disable_web_page_preview' => 'true'));
			} else {
				$text = "❗💯 Ставка не может быть больше 100%";
				send($config['token'], 'sendMessage', Array('chat_id' => $config['chat']['moders'], 'text' => $text, 'parse_mode' => 'HTML', 'disable_web_page_preview' => 'true'));
			}
		} else {
			$text = "❔ Используйте /stake <code>[Оплата];[Возврат]</code>";
			send($config['token'], 'sendMessage', Array('chat_id' => $config['chat']['moders'], 'text' => $text, 'parse_mode' => 'HTML', 'disable_web_page_preview' => 'true'));
		}
	}

?>