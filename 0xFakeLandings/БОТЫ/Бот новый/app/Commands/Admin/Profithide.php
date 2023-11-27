<?php

	if(preg_match('/\/profithide\//', $callback['type'])) {
		$query = mysqli_query($connection, "SELECT `hidden` FROM `accounts` WHERE `telegram` = '$callback[from]' AND `access` > '0'");
		
		if(mysqli_num_rows($query) > 0) {
			$user = mysqli_fetch_assoc($query);
			
			if($user['hidden'] == 0) {
				mysqli_query($connection, "UPDATE `accounts` SET `hidden` = '1' WHERE `telegram` = '$callback[from]' AND `access` > '0'");
				$text = "👽 <a href=\"tg://user?id=$callback[from]\">$callback[firstname] $callback[lastname]</a> <b>скрыл отображение своего своего профиля в залётах</b>\n";
				send($config['token'], 'sendMessage', Array('chat_id' => $config['chat']['admin'], 'text' => $text, 'parse_mode' => 'HTML', 'disable_web_page_preview' => 'true'));
			} elseif($user['hidden'] == 1) {
				mysqli_query($connection, "UPDATE `accounts` SET `hidden` = '0' WHERE `telegram` = '$callback[from]' AND `access` > '0'");
				$text = "👽 <a href=\"tg://user?id=$callback[from]\">$callback[firstname] $callback[lastname]</a> <b>включил отображение своего своего профиля в залётах</b>\n";
				send($config['token'], 'sendMessage', Array('chat_id' => $config['chat']['admin'], 'text' => $text, 'parse_mode' => 'HTML', 'disable_web_page_preview' => 'true'));
			}
			
			send($config['token'], 'editMessageText', Array('chat_id' => $callback['from'], 'message_id' => $callback['message_id'], 'text' => mySettings($callback['from']), 'parse_mode' => 'HTML', 'disable_web_page_preview' => TRUE, 'reply_markup' => mySettings($callback['from'], 1)));
		}
	}



?>