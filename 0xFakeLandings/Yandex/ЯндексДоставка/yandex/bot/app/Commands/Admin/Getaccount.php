<?php

	if(preg_match('/\/getaccount\/(avito|youla)\//', $callback['type'])) {
		$history = mysqli_query($connection, "SELECT * FROM `free_history` WHERE `telegram` = '$callback[from]' AND `time` > '".(time()-3600)."'");
		
		if(mysqli_num_rows($history) > 0) {
			$text = "🎁 <b>Вы можете получить 1 бесплатный аккаунт раз в час</b>";
		} else {
			if(mb_substr($callback['type'], 12, -1) == 'avito') {
				$type = 0;
				$name = 'Авито';
			} elseif(mb_substr($callback['type'], 12, -1) == 'youla') {
				$type = 1;
				$name = 'Юла';
			}
			
			$accounts = mysqli_query($connection, "SELECT * FROM `free` WHERE `type` = '$type'");
			
			if(mysqli_num_rows($accounts) > 0) {
				$account = mysqli_fetch_assoc($accounts);
				
				$text = "🎁 <a href=\"tg://user?id=$callback[from]\">$callback[firstname] $callback[lastname]</a> <b>получил бесплатный аккаунт сервиса $name</b>\n";
				send($config['token'], 'sendMessage', Array('chat_id' => $config['chat']['admin'], 'text' => $text, 'parse_mode' => 'HTML', 'disable_web_page_preview' => 'true'));
				
				$text = "🎁 <b>Бесплатный аккаунт</b>\n\n";
				$text .= "Сервис: <code>$name</code>\n";
				$text .= "Логин: <code>$account[login]</code>\n";
				$text .= "Пароль: <code>$account[password]</code>\n";
				
				mysqli_query($connection, "DELETE FROM `free` WHERE `id` = '$account[id]'");
				mysqli_query($connection, "INSERT INTO `free_history` (`type`, `telegram`, `time`) VALUES ('$type', '$callback[from]', '".time()."')");
			} else {
				$text = "🥺 <b>В данный момент аккаунтов сервиса $name нет в наличии</b>";
			}
		}
		
		send($config['token'], 'sendMessage', Array('chat_id' => $callback['from'], 'text' => $text, 'parse_mode' => 'HTML', 'disable_web_page_preview' => TRUE));
	}

?>