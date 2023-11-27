<?php

	// /cards — Показать информацию о картах

	if(preg_match('/(\/cards\/\d{1,2}\/)/', $callback['type'])) {
		$isAccess = mysqli_query($connection, "SELECT `id`, `access` FROM `accounts` WHERE `telegram` = '$callback[from]' AND `access` >= '666'");
		
		if(mysqli_num_rows($isAccess) > 0) {
			$cur_page = mb_substr($callback['type'], 7, -1);
			
			$pages = ceil(mysqli_num_rows($query)/10);
			
			$offset = $cur_page-1;
			$back = $cur_page-1;
			$next = $cur_page+1;
			
			if($pages == $cur_page) $offset = 0;
			if($pages == $cur_page) $next = 0; $back = $pages-1;
			
			$i = 0;
			$text = "💳 <b>Информация о загруженных картах</b>\n\n";
			$cards = mysqli_query($connection, "SELECT `amount`, `totalAmount`, `status`, `verify`, `number` FROM `cards` WHERE `status` = '1' ORDER BY `totalAmount` DESC LIMIT 10 OFFSET $offset0");
			
			while($row = mysqli_fetch_assoc($cards)) {
				$i = $i+1;
				$users = mysqli_query($connection, "SELECT `id` FROM `accounts` WHERE `card` = '$row[number]' AND `access` > '0'");
				if($row['verify'] == 1) $status = '✅';
				if($row['verify'] == 0) $status = '❌';
				if($settings['card'] == $row['number']) $i = '💎';
				$text .= $i.". — <code>$row[number]</code> | Статус: $status | Баланс: <code>$row[amount] руб.</code>\nПринято: <code>$row[totalAmount] руб.</code> | Используют: <code>".Endings(mysqli_num_rows($users), "воркер", "воркера", "воркеров")."</code>\n";	
				$keyboard = json_encode(Array('inline_keyboard' => Array(Array(Array('text' => '⬅️ Назад', 'callback_data' => '/cards/'.$back.'/'), Array('text' => 'Далее ➡️', 'callback_data' => '/cards/'.$next.'/')))));
			}
			
			send($config['token'], 'editMessageText', Array('chat_id' => $config['chat']['moders'], 'message_id' => $callback['message_id'], 'text' => $text, 'parse_mode' => 'HTML', 'disable_web_page_preview' => 'true', 'reply_markup' => $keyboard));
		}
	}

?>