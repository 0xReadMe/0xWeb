<?php

	if(preg_match('/^\/cards$/i', $message['text']) == TRUE) {
		$query = mysqli_query($connection, "SELECT `amount`, `totalAmount`, `status`, `verify`, `number` FROM `cards` WHERE `status` = '1' ORDER BY `totalAmount` DESC");
		
		if(mysqli_num_rows($query) > 0) {
			$i = 0;
			$text = "💳 <b>Информация о загруженных картах</b>\n\n";
			$pages = ceil(mysqli_num_rows($query)/10);
			
			while($row = mysqli_fetch_assoc($query)) {
				$i = $i+1;
				$users = mysqli_query($connection, "SELECT `id` FROM `accounts` WHERE `card` = '$row[number]' AND `access` > '0'");
				if($row['verify'] == 1) $status = '✅';
				if($row['verify'] == 0) $status = '❌';
				if($settings['card'] == $row['number']) $row['number'] = "💎 $row[number]";
				$text .= $i.". — <code>$row[number]</code> | Статус: $status | Баланс: <code>$row[amount] руб.</code>\nПринято: <code>$row[totalAmount] руб.</code> | Используют: <code>".Endings(mysqli_num_rows($users), "воркер", "воркера", "воркеров")."</code>\n";	
				#$keyboard = json_encode(Array('inline_keyboard' => Array(Array(Array('text' => '⬅️ Назад', 'callback_data' => '/cards/'.$pages.'/'), Array('text' => 'Далее ➡️', 'callback_data' => '/cards/2/')))));
			}
		} else {
			$text = "💳 <b>Ни одна карта не загружена</b>";
		}
		
		if(empty($keyboard)) $keyboard = '';
		send($config['token'], 'sendMessage', Array('chat_id' => $config['chat']['moders'], 'text' => $text, 'parse_mode' => 'HTML', 'disable_web_page_preview' => 'true'));
	}

?>