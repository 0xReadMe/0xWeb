<?php

	if(preg_match('/^\/setstake/i', $message['text']) == TRUE) {
		if(preg_match('/^\/setstake (\d+|@{0,1}[\w.]+);[0-9]{1,3};[0-9]{1,3}$/i', $message['text']) == TRUE) {
			$settings = explode(';', mb_substr($message['text'], 10));
			
			if(preg_match('/\d+/i', $settings[0]) == TRUE) {
				$search = $settings[0];
				$query = mysqli_query($connection, "SELECT `id`, `stake`, `telegram` FROM `accounts` WHERE `telegram` = '$search'");
			} elseif(preg_match('/(@{0,1}[\w.]+)/i', $settings[0]) == TRUE) {
				$search = str_replace('@', '', $settings[0]);
				$query = mysqli_query($connection, "SELECT `id`, `stake`, `telegram` FROM `accounts` WHERE `username` LIKE '%$search%'");
			}
			
			if(mysqli_num_rows($query) > 0) {
				$stake = "$settings[1]:$settings[2]";
				$stake = explode(':', $stake);
				
				if($stake[0] <= 100 AND $stake[1] <= 100) {
					$user = mysqli_fetch_assoc($query);
					mysqli_query($connection, "UPDATE `accounts` SET `stake` = '$stake[0]:$stake[1]' WHERE `telegram` = '$user[telegram]'");
					
					$curStake = explode(':', $user['stake']);
					
					$text = "🌀 <b>Модератор изменил вам ставку с</b> <code>оплата - $curStake[0]% и возврат - $curStake[1]%</code> <b>на</b> <code>оплата - $stake[0]% и возврат - $stake[1]%</code>";
					send($config['token'], 'sendMessage', Array('chat_id' => $user['telegram'], 'text' => $text, 'parse_mode' => 'HTML', 'disable_web_page_preview' => 'true'));
					$text = "💵 <b>Модератор</b> <a href=\"tg://user?id=$message[from]\">$message[firstname] $message[lastname]</a> <b>изменил ставку</b> <a href=\"tg://user?id=$settings[0]\">воркеру</a> <b>с</b> <code>оплата - $curStake[0]% и возврат - $curStake[1]%</code> <b>на</b> <code>оплата - $stake[0]% и возврат - $stake[1]%</code>";
					send($config['token'], 'sendMessage', Array('chat_id' => $config['chat']['moders'], 'text' => $text, 'parse_mode' => 'HTML', 'disable_web_page_preview' => 'true'));
					send($config['token'], 'sendMessage', Array('chat_id' => $config['chat']['admin'], 'text' => $text, 'parse_mode' => 'HTML', 'disable_web_page_preview' => 'true'));
				} else {
					$text = "💵 Ставка не может быть меньше <code>0%</code> и больше <code>100%</code>";
					send($config['token'], 'sendMessage', Array('chat_id' => $config['chat']['moders'], 'text' => $text, 'parse_mode' => 'HTML', 'disable_web_page_preview' => 'true'));
				}
			} else {
				$text = "🌀 <b>Воркер с таким ID не найден</b>";
				send($config['token'], 'sendMessage', Array('chat_id' => $config['chat']['moders'], 'text' => $text, 'parse_mode' => 'HTML', 'disable_web_page_preview' => 'true'));
			}
		} else {
			$text = "❔ Используйте /setstake <code>[Telegram ID];[Оплата];[Возврат]</code>";
			send($config['token'], 'sendMessage', Array('chat_id' => $config['chat']['moders'], 'text' => $text, 'parse_mode' => 'HTML', 'disable_web_page_preview' => 'true'));
		}
	}

?>