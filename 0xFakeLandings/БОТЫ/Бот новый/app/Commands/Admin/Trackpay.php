<?php
	
	// Относиться и к пользователю, показывает информацию о изминении своего статуса трек-кода на "Оплачено"

	if(preg_match('/\/trackpay\/\d{6,12}\//', $callback['type'])) {
		$code = substr($callback['type'], 10, -1);
		
		$search = mysqli_query($connection, "SELECT `id` FROM `trackcodes` WHERE `code` = '$code' AND `worker` = '$callback[from]' AND `status` > '0'");
		
		if(mysqli_num_rows($search) > 0) {
			mysqli_query($connection, "UPDATE `trackcodes` SET `status` = '2' WHERE `code` = '$code' AND `worker` = '$callback[from]' AND `status` > '0'");
			
			send($config['token'], 'editMessageText', Array('chat_id' => $callback['from'], 'message_id' => $callback['message_id'], 'text' => getTrack($callback['from'], $code), 'parse_mode' => 'HTML', 'disable_web_page_preview' => TRUE, 'reply_markup' => getTrack($callback['from'], $code, 1)));
			$text = "📋 <a href=\"tg://user?id=$callback[from]\">$callback[firstname] $callback[lastname]</a> <b>изменил статус своего трек-код</b> <code>$code</code> <b>на</b> <code>Оплачено</code>";
			send($config['token'], 'sendMessage', Array('chat_id' => $config['chat']['admin'], 'text' => $text, 'parse_mode' => 'HTML', 'disable_web_page_preview' => 'true'));
		} else {
			$text = "📭 <b>Объявление ещё не создано или не скрыто</b>";
			send($config['token'], 'sendMessage', Array('chat_id' => $callback['from'], 'text' => $text, 'parse_mode' => 'HTML', 'disable_web_page_preview' => 'true'));
		}
	}

?>