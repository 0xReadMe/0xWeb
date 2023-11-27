<?php

	if($message['chat_id'] == $config['chat']['moders'] /*OR $message['chat_id'] == $config['chat']['supports']*/) {
		$isAccess = mysqli_query($connection, "SELECT `id` FROM `accounts` WHERE `telegram` = '$message[from]' AND `access` > '100'");
			
		if(mysqli_num_rows($isAccess) > 0) {
			if(preg_match('/\/adverts (\d+|@{0,1}[\w.]+)/i', $message['text']) == TRUE OR $message['text'] == '/adverts') {
				if($message['text'] == '/adverts') {
					$query = mysqli_query($connection, "SELECT `type`, `advert_id`, `worker`, `title`, `price`, `views` FROM `adverts` WHERE `status` = '1' ORDER BY `id` DESC LIMIT 10");
				} elseif(preg_match('/\/adverts \d+/', $message['text']) == TRUE) {
					$worker['telegram'] = mb_substr($message['text'], 9);
				} elseif(preg_match('/\/adverts @{0,1}[\w.]+/i', $message['text']) == TRUE) {
					$search = str_replace('@', '', mb_substr($message['text'], 9));
					$worker = mysqli_fetch_assoc(mysqli_query($connection, "SELECT `telegram` FROM `accounts` WHERE `username` LIKE '%$search%'"));
				}
				
				if($message['text'] == '/adverts') {
					$text = "🗂 <b>10 последних объявлений:</b>\n\n";
					
					while($row = mysqli_fetch_assoc($query)) {
						$x = $x+1;
						if(mb_strlen($row['title']) > 18) $row['title'] = mb_substr($row['title'], 0, 18) .'[...]';
						if($row['type'] == 0) $type = 'Авито' AND $url = 'https://'.$domains['avito'].'/buy?id='.$row['advert_id']; if($row['type'] == 1) $type = 'Юла' AND $url = 'https://'.$domains['youla'].'/product/'.$row['advert_id'].'/buy/delivery';
						$text .= "<b>".$x.".</b> <a href=\"https://avito.ru/$row[advert_id]\">$row[title]</a> — <b>Сумма:</b> <code>$row[price] руб.</code> | <a href=\"tg://user?id=$row[worker]\">Воркер</a>\n<i>$type</i> <b>| Оплата:</b> <a href=\"$url\">$row[advert_id]</a> | <b>Переходов:</b> <code>$row[views]</code>\n";
					}
					send($config['token'], 'sendMessage', Array('chat_id' => $message['chat_id'], 'text' => $text, 'parse_mode' => 'HTML', 'disable_web_page_preview' => 'true'));
				} else {
					send($config['token'], 'sendMessage', Array('chat_id' => $message['chat_id'], 'text' => getMyAdverts($worker['telegram'], 1), 'parse_mode' => 'HTML', 'disable_web_page_preview' => 'true', 'reply_markup' => getMyAdverts($worker['telegram'], 1, 1)));
				}
			}
		}
	}

?>