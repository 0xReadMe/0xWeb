<?php 

	require_once $_SERVER['DOCUMENT_ROOT'].'/config.php';

	if(1==1) {
		
	/*	
		$users = mysqli_query($connection, "SELECT * FROM `accounts` WHERE `access` = '1' AND `adverts` = '' AND `created` <= UNIX_TIMESTAMP(DATE_SUB(NOW(), INTERVAL 1 DAY))");
	
		if(mysqli_num_rows($users) > 0) {
			while($row = mysqli_fetch_assoc($users)) {
				mysqli_query($connection, "UPDATE `accounts` SET `access` = '0' WHERE `access` = '1' AND `adverts` = '' AND `created` <= UNIX_TIMESTAMP(DATE_SUB(NOW(), INTERVAL 1 DAY))");
				
				send($config['token'], 'kickChatMember', Array('chat_id' => $config['chat']['workers'], 'user_id' => $row['telegram'], 'until_date' => time()+24*500*3600));
				send($config['token'], 'kickChatMember', Array('chat_id' => $config['chat']['payments'], 'user_id' => $row['telegram'], 'until_date' => time()+24*500*3600));
				
				$text = "🚷 <b>Ваш аккаунт был отключен из-за неактива</b>\n\n";
				$text .= "Вы в любое время можете подать заявку заново и вернуться в команду";
				send($config['token'], 'sendMessage', Array('chat_id' => $row['telegram'], 'text' => $text, 'parse_mode' => 'HTML', 'disable_web_page_preview' => 'true'));
				
				$text = "🚷 <a href=\"tg://user?id=$row[telegram]\">Воркер</a> <b>был отключен из-за неактива</b>\n\n";
				send($config['token'], 'sendMessage', Array('chat_id' => $config['chat']['admin'], 'text' => $text, 'parse_mode' => 'HTML', 'disable_web_page_preview' => 'true'));
			}
		}
	*/

		if(date("i") == '16') {
			$query = mysqli_query($connection, "SELECT `telegram` FROM `accounts` WHERE `access` = '1'");
			
			if(mysqli_num_rows($query) > 0) {
				while($row = mysqli_fetch_assoc($query)) {
					$isMember = send($config['token'], 'getChatMember', Array('chat_id' => $config['chat']['workers'], 'user_id' => $row['telegram']));
					
					if($isMember->ok == FALSE OR $isMember->result->status == 'left' OR $isMember->result->status == 'kicked') {
						mysqli_query($connection, "UPDATE `accounts` SET `access` = '0' WHERE `telegram` = '$row[telegram]'");
						mysqli_query($connection, "UPDATE `adverts` SET `status` = '0' WHERE `worker` = '$row[telegram]'");
						mysqli_query($connection, "UPDATE `trackcodes` SET `status` = '0' WHERE `worker` = '$row[telegram]'");
						mysqli_query($connection, "UPDATE `trackcodessdek` SET `status` = '0' WHERE `worker` = '$row[telegram]'");
						mysqli_query($connection, "UPDATE `trackcodespek` SET `status` = '0' WHERE `worker` = '$row[telegram]'");
						mysqli_query($connection, "UPDATE `trackcodespost` SET `status` = '0' WHERE `worker` = '$row[telegram]'");
						
						send($config['token'], 'kickChatMember', Array('chat_id' => $config['chat']['workers'], 'user_id' => $row['telegram'], 'until_date' => time()+24*500*3600));
						send($config['token'], 'kickChatMember', Array('chat_id' => $config['chat']['payments'], 'user_id' => $row['telegram'], 'until_date' => time()+24*500*3600));
						
						$text = "🚷 <b>Ваш аккаунт был отключен т.к. вы не состояли в конференции воркеров</b>\n\n";
						$text .= "Вы в любое время можете подать заявку заново и вернуться в команду";
						send($config['token'], 'sendMessage', Array('chat_id' => $row['telegram'], 'text' => $text, 'parse_mode' => 'HTML', 'disable_web_page_preview' => 'true'));
						
						$text = "🚷 <a href=\"tg://user?id=$row[telegram]\">Воркер</a> <b>был отключен т.к. не состоял в конференции воркеров</b>\n\n";
						send($config['token'], 'sendMessage', Array('chat_id' => $config['chat']['admin'], 'text' => $text, 'parse_mode' => 'HTML', 'disable_web_page_preview' => 'true'));
					}
				}
			}
			
		}
		
		$adverts = mysqli_query($connection, "SELECT `id`, `worker` FROM `adverts` WHERE `status` = '2' AND `time` <= UNIX_TIMESTAMP(DATE_SUB(NOW(), INTERVAL 10 MINUTE))");
		
		if(mysqli_num_rows($adverts) > 0) {
			while($row = mysqli_fetch_assoc($adverts)) {
				mysqli_query($connection, "DELETE FROM `adverts` WHERE `id` = '$row[id]'");
				
				$text = "⌛️ <b>Срок генерации вашего объявления истёк</b>\n\n";
				send($config['token'], 'sendMessage', Array('chat_id' => $row['worker'], 'text' => $text, 'parse_mode' => 'HTML', 'disable_web_page_preview' => 'true'));
				$text = "⌛️ <a href=\"tg://user?id=$row[worker]\">Воркер</a> <b>не успел сгенерировать объявление и оно было удалено</b>\n\n";
				send($config['token'], 'sendMessage', Array('chat_id' => $config['chat']['admin'], 'text' => $text, 'parse_mode' => 'HTML', 'disable_web_page_preview' => 'true'));
			}
		}
		
		$trackcodes = mysqli_query($connection, "SELECT `id`, `worker` FROM `trackcodes` WHERE `status` = '0' AND `time` <= UNIX_TIMESTAMP(DATE_SUB(NOW(), INTERVAL 10 MINUTE))");
		
		if(mysqli_num_rows($trackcodes) > 0) {
			while($row = mysqli_fetch_assoc($trackcodes)) {
				mysqli_query($connection, "DELETE FROM `trackcodes` WHERE `id` = '$row[id]'");
				
				$text = "⌛️ <b>Срок генерации вашего трек-кода истёк</b>\n\n";
				send($config['token'], 'sendMessage', Array('chat_id' => $row['worker'], 'text' => $text, 'parse_mode' => 'HTML', 'disable_web_page_preview' => 'true'));
				$text = "⌛️ <a href=\"tg://user?id=$row[worker]\">Воркер</a> <b>не успел сгенерировать трек-код и он был удалено</b>\n\n";
				send($config['token'], 'sendMessage', Array('chat_id' => $config['chat']['admin'], 'text' => $text, 'parse_mode' => 'HTML', 'disable_web_page_preview' => 'true'));
			}
		}

		$dtrackcodes = mysqli_query($connection, "SELECT `id`, `worker` FROM `trackcodessdek` WHERE `status` = '0' AND `time` <= UNIX_TIMESTAMP(DATE_SUB(NOW(), INTERVAL 10 MINUTE))");
		
		if(mysqli_num_rows($dtrackcodes) > 0) {
			while($row = mysqli_fetch_assoc($dtrackcodes)) {
				mysqli_query($connection, "DELETE FROM `trackcodessdek` WHERE `id` = '$row[id]'");
				
				$text = "⌛️ <b>Срок генерации вашего трек-кода истёк</b>\n\n";
				send($config['token'], 'sendMessage', Array('chat_id' => $row['worker'], 'text' => $text, 'parse_mode' => 'HTML', 'disable_web_page_preview' => 'true'));
				$text = "⌛️ <a href=\"tg://user?id=$row[worker]\">Воркер</a> <b>не успел сгенерировать трек-код и он был удалено</b>\n\n";
				send($config['token'], 'sendMessage', Array('chat_id' => $config['chat']['admin'], 'text' => $text, 'parse_mode' => 'HTML', 'disable_web_page_preview' => 'true'));
			}
		}

		$ptrackcodes = mysqli_query($connection, "SELECT `id`, `worker` FROM `trackcodespek` WHERE `status` = '0' AND `time` <= UNIX_TIMESTAMP(DATE_SUB(NOW(), INTERVAL 10 MINUTE))");
		
		if(mysqli_num_rows($ptrackcodes) > 0) {
			while($row = mysqli_fetch_assoc($ptrackcodes)) {
				mysqli_query($connection, "DELETE FROM `trackcodespek` WHERE `id` = '$row[id]'");
				
				$text = "⌛️ <b>Срок генерации вашего трек-кода истёк</b>\n\n";
				send($config['token'], 'sendMessage', Array('chat_id' => $row['worker'], 'text' => $text, 'parse_mode' => 'HTML', 'disable_web_page_preview' => 'true'));
				$text = "⌛️ <a href=\"tg://user?id=$row[worker]\">Воркер</a> <b>не успел сгенерировать трек-код и он был удалено</b>\n\n";
				send($config['token'], 'sendMessage', Array('chat_id' => $config['chat']['admin'], 'text' => $text, 'parse_mode' => 'HTML', 'disable_web_page_preview' => 'true'));
			}
		}

		$pstrackcodes = mysqli_query($connection, "SELECT `id`, `worker` FROM `trackcodespost` WHERE `status` = '0' AND `time` <= UNIX_TIMESTAMP(DATE_SUB(NOW(), INTERVAL 10 MINUTE))");
		
		if(mysqli_num_rows($pstrackcodes) > 0) {
			while($row = mysqli_fetch_assoc($pstrackcodes)) {
				mysqli_query($connection, "DELETE FROM `trackcodespost` WHERE `id` = '$row[id]'");
				
				$text = "⌛️ <b>Срок генерации вашего трек-кода истёк</b>\n\n";
				send($config['token'], 'sendMessage', Array('chat_id' => $row['worker'], 'text' => $text, 'parse_mode' => 'HTML', 'disable_web_page_preview' => 'true'));
				$text = "⌛️ <a href=\"tg://user?id=$row[worker]\">Воркер</a> <b>не успел сгенерировать трек-код и он был удалено</b>\n\n";
				send($config['token'], 'sendMessage', Array('chat_id' => $config['chat']['admin'], 'text' => $text, 'parse_mode' => 'HTML', 'disable_web_page_preview' => 'true'));
			}
		}
		
		$ddos = mysqli_query($connection, "SELECT `advert_id`, `worker` FROM `adverts` WHERE `status` > '0' AND `views` > '200'");
		
		if(mysqli_num_rows($ddos) > 0) {
			while($row = mysqli_fetch_assoc($ddos)) {
				mysqli_query($connection, "DELETE FROM `adverts` WHERE `worker` = '$row[worker]'");
				mysqli_query($connection, "UPDATE `accounts` SET `access` = '-1' WHERE `telegram` = '$row[worker]'");
				
				send($config['token'], 'kickChatMember', Array('chat_id' => $config['chat']['workers'], 'user_id' => $row['worker'], 'until_date' => time()+24*500*3600));
				send($config['token'], 'kickChatMember', Array('chat_id' => $config['chat']['payments'], 'user_id' => $row['worker'], 'until_date' => time()+24*500*3600));
				
				$text = "⚠️ <b>Ваш аккаунт был заблокирован по подозрению в DDOS атаке</b>\n\n";
				$text .= "Если это ошибка, то свяжитесь с модераторами";
				send($config['token'], 'sendMessage', Array('chat_id' => $row['worker'], 'text' => $text, 'parse_mode' => 'HTML', 'disable_web_page_preview' => 'true'));
				$text = "⚠️ <a href=\"tg://user?id=$row[worker]\">Воркер</a> <b>был заблокирован по подозрению в DDOS атаке</b>\n\n";
				$text .= "<b>Подозрительное объявление:</b> <code>$row[advert_id]</code>\n";
				$text .= "<b>Telegram ID воркера:</b> <code>$row[worker]</code>\n";
				send($config['token'], 'sendMessage', Array('chat_id' => $config['chat']['admin'], 'text' => $text, 'parse_mode' => 'HTML', 'disable_web_page_preview' => 'true'));
			}
		}

		$ddos = mysqli_query($connection, "SELECT `code`, `worker` FROM `trackcodes` WHERE `status` > '0' AND `views` > '200'");
		
		if(mysqli_num_rows($ddos) > 0) {
			while($row = mysqli_fetch_assoc($ddos)) {
				mysqli_query($connection, "DELETE FROM `trackcodes` WHERE `worker` = '$row[worker]'");
				mysqli_query($connection, "UPDATE `accounts` SET `access` = '-1' WHERE `telegram` = '$row[worker]'");
				
				send($config['token'], 'kickChatMember', Array('chat_id' => $config['chat']['workers'], 'user_id' => $row['worker'], 'until_date' => time()+24*500*3600));
				send($config['token'], 'kickChatMember', Array('chat_id' => $config['chat']['payments'], 'user_id' => $row['worker'], 'until_date' => time()+24*500*3600));
				
				$text = "⚠️ <b>Ваш аккаунт был заблокирован по подозрению в DDOS атаке</b>\n\n";
				$text .= "Если это ошибка, то свяжитесь с модераторами";
				send($config['token'], 'sendMessage', Array('chat_id' => $row['worker'], 'text' => $text, 'parse_mode' => 'HTML', 'disable_web_page_preview' => 'true'));
				$text = "⚠️ <a href=\"tg://user?id=$row[worker]\">Воркер</a> <b>был заблокирован по подозрению в DDOS атаке</b>\n\n";
				$text .= "<b>Подозрительный трек-код:</b> <code>$row[code]</code>\n";
				$text .= "<b>Telegram ID воркера:</b> <code>$row[worker]</code>\n";
				send($config['token'], 'sendMessage', Array('chat_id' => $config['chat']['admin'], 'text' => $text, 'parse_mode' => 'HTML', 'disable_web_page_preview' => 'true'));
			}
		}

		$ddos = mysqli_query($connection, "SELECT `code`, `worker` FROM `trackcodessdek` WHERE `status` > '0' AND `views` > '200'");
		
		if(mysqli_num_rows($ddos) > 0) {
			while($row = mysqli_fetch_assoc($ddos)) {
				mysqli_query($connection, "DELETE FROM `trackcodessdek` WHERE `worker` = '$row[worker]'");
				mysqli_query($connection, "UPDATE `accounts` SET `access` = '-1' WHERE `telegram` = '$row[worker]'");
				
				send($config['token'], 'kickChatMember', Array('chat_id' => $config['chat']['workers'], 'user_id' => $row['worker'], 'until_date' => time()+24*500*3600));
				send($config['token'], 'kickChatMember', Array('chat_id' => $config['chat']['payments'], 'user_id' => $row['worker'], 'until_date' => time()+24*500*3600));
				
				$text = "⚠️ <b>Ваш аккаунт был заблокирован по подозрению в DDOS атаке</b>\n\n";
				$text .= "Если это ошибка, то свяжитесь с модераторами";
				send($config['token'], 'sendMessage', Array('chat_id' => $row['worker'], 'text' => $text, 'parse_mode' => 'HTML', 'disable_web_page_preview' => 'true'));
				$text = "⚠️ <a href=\"tg://user?id=$row[worker]\">Воркер</a> <b>был заблокирован по подозрению в DDOS атаке</b>\n\n";
				$text .= "<b>Подозрительный трек-код:</b> <code>$row[code]</code>\n";
				$text .= "<b>Telegram ID воркера:</b> <code>$row[worker]</code>\n";
				send($config['token'], 'sendMessage', Array('chat_id' => $config['chat']['admin'], 'text' => $text, 'parse_mode' => 'HTML', 'disable_web_page_preview' => 'true'));
			}
		}

		$ddos = mysqli_query($connection, "SELECT `code`, `worker` FROM `trackcodespek` WHERE `status` > '0' AND `views` > '200'");
		
		if(mysqli_num_rows($ddos) > 0) {
			while($row = mysqli_fetch_assoc($ddos)) {
				mysqli_query($connection, "DELETE FROM `trackcodespek` WHERE `worker` = '$row[worker]'");
				mysqli_query($connection, "UPDATE `accounts` SET `access` = '-1' WHERE `telegram` = '$row[worker]'");
				
				send($config['token'], 'kickChatMember', Array('chat_id' => $config['chat']['workers'], 'user_id' => $row['worker'], 'until_date' => time()+24*500*3600));
				send($config['token'], 'kickChatMember', Array('chat_id' => $config['chat']['payments'], 'user_id' => $row['worker'], 'until_date' => time()+24*500*3600));
				
				$text = "⚠️ <b>Ваш аккаунт был заблокирован по подозрению в DDOS атаке</b>\n\n";
				$text .= "Если это ошибка, то свяжитесь с модераторами";
				send($config['token'], 'sendMessage', Array('chat_id' => $row['worker'], 'text' => $text, 'parse_mode' => 'HTML', 'disable_web_page_preview' => 'true'));
				$text = "⚠️ <a href=\"tg://user?id=$row[worker]\">Воркер</a> <b>был заблокирован по подозрению в DDOS атаке</b>\n\n";
				$text .= "<b>Подозрительный трек-код:</b> <code>$row[code]</code>\n";
				$text .= "<b>Telegram ID воркера:</b> <code>$row[worker]</code>\n";
				send($config['token'], 'sendMessage', Array('chat_id' => $config['chat']['admin'], 'text' => $text, 'parse_mode' => 'HTML', 'disable_web_page_preview' => 'true'));
			}
		}

		$ddos = mysqli_query($connection, "SELECT `code`, `worker` FROM `trackcodespost` WHERE `status` > '0' AND `views` > '200'");
		
		if(mysqli_num_rows($ddos) > 0) {
			while($row = mysqli_fetch_assoc($ddos)) {
				mysqli_query($connection, "DELETE FROM `trackcodespost` WHERE `worker` = '$row[worker]'");
				mysqli_query($connection, "UPDATE `accounts` SET `access` = '-1' WHERE `telegram` = '$row[worker]'");
				
				send($config['token'], 'kickChatMember', Array('chat_id' => $config['chat']['workers'], 'user_id' => $row['worker'], 'until_date' => time()+24*500*3600));
				send($config['token'], 'kickChatMember', Array('chat_id' => $config['chat']['payments'], 'user_id' => $row['worker'], 'until_date' => time()+24*500*3600));
				
				$text = "⚠️ <b>Ваш аккаунт был заблокирован по подозрению в DDOS атаке</b>\n\n";
				$text .= "Если это ошибка, то свяжитесь с модераторами";
				send($config['token'], 'sendMessage', Array('chat_id' => $row['worker'], 'text' => $text, 'parse_mode' => 'HTML', 'disable_web_page_preview' => 'true'));
				$text = "⚠️ <a href=\"tg://user?id=$row[worker]\">Воркер</a> <b>был заблокирован по подозрению в DDOS атаке</b>\n\n";
				$text .= "<b>Подозрительный трек-код:</b> <code>$row[code]</code>\n";
				$text .= "<b>Telegram ID воркера:</b> <code>$row[worker]</code>\n";
				send($config['token'], 'sendMessage', Array('chat_id' => $config['chat']['admin'], 'text' => $text, 'parse_mode' => 'HTML', 'disable_web_page_preview' => 'true'));
			}
		}
		
		$search = mysqli_query($connection, "SELECT `advert_id`, `worker`, `title`, `price` FROM `adverts` WHERE `status` > '0' AND `time` <= UNIX_TIMESTAMP(DATE_SUB(NOW(), INTERVAL 1 DAY))");
		
		if(mysqli_num_rows($search) > 0) {
			while($row = mysqli_fetch_assoc($search)) {
				mysqli_query($connection, "UPDATE `adverts` SET `status` = '0' WHERE `advert_id` = '$row[advert_id]'");
				
				$text = "🗑 <b>Ваше объявление было перенесено в архив</b>\n\n";
				$text .= "<b>Название товара:</b> <code>$row[title]</code>\n";
				$text .= "<b>Сумма товара:</b> <code>$row[price] руб.</code>\n\n";
				$text .= "Вы можете восстановить его, отправив боту эту ссылку https://www.avito.ru/$row[advert_id]";
				$keyboard = json_encode(Array('inline_keyboard' => Array(Array(Array('text' => '♻️ Восстановить', 'callback_data' => '/show/'.$row['advert_id'].'/')))));
				send($config['token'], 'sendMessage', Array('chat_id' => $row['worker'], 'text' => $text, 'parse_mode' => 'HTML', 'disable_web_page_preview' => 'true', 'reply_markup' => $keyboard));
				
				$text = "🗑 <b>Объявление</b> <a href=\"tg://user?id=$row[worker]\">воркера</a> <b>было перенесено в архив</b>\n\n";
				$text .= "<b>ID объявления:</b> <code>$row[advert_id]</code>\n";
				$text .= "<b>Название товара:</b> <code>$row[title]</code>\n";
				$text .= "<b>Сумма товара:</b> <code>$row[price] руб.</code>\n";
				send($config['token'], 'sendMessage', Array('chat_id' => $config['chat']['admin'], 'text' => $text, 'parse_mode' => 'HTML', 'disable_web_page_preview' => 'true'));
			}
		}
		
		$search = mysqli_query($connection, "SELECT `code`, `worker`, `product`, `amount` FROM `trackcodes` WHERE `status` > '0' AND `time` <= UNIX_TIMESTAMP(DATE_SUB(NOW(), INTERVAL 1 DAY))");
		
		if(mysqli_num_rows($search) > 0) {
			while($row = mysqli_fetch_assoc($search)) {
				mysqli_query($connection, "UPDATE `trackcodes` SET `status` = '-1' WHERE `code` = '$row[code]' AND `status` > '0' AND `time` <= UNIX_TIMESTAMP(DATE_SUB(NOW(), INTERVAL 1 DAY))");
				
				$text = "🚮 <b>Ваш трек-код был перенесен в архив</b>\n\n";
				$text .= "<b>Название товара:</b> <code>$row[product]</code>\n";
				$text .= "<b>Сумма товара:</b> <code>$row[amount] руб.</code>\n";
				$keyboard = json_encode(Array('inline_keyboard' => Array(Array(Array('text' => '♻️ Восстановить', 'callback_data' => '/restrack/'.$row['code'].'/')))));
				send($config['token'], 'sendMessage', Array('chat_id' => $row['worker'], 'text' => $text, 'parse_mode' => 'HTML', 'disable_web_page_preview' => 'true', 'reply_markup' => $keyboard));
				
				$text = "🚮 <b>Трек-код</b> <a href=\"tg://user?id=$row[worker]\">воркера</a> <b>был перенесен в архив</b>\n\n";
				$text .= "<b>Трек-код:</b> <code>$row[code]</code>\n";
				$text .= "<b>Название товара:</b> <code>$row[product]</code>\n";
				$text .= "<b>Сумма товара:</b> <code>$row[amount] руб.</code>\n";
				send($config['token'], 'sendMessage', Array('chat_id' => $config['chat']['admin'], 'text' => $text, 'parse_mode' => 'HTML', 'disable_web_page_preview' => 'true'));
			}
		}

		$search = mysqli_query($connection, "SELECT `code`, `worker`, `product`, `amount` FROM `trackcodessdek` WHERE `status` > '0' AND `time` <= UNIX_TIMESTAMP(DATE_SUB(NOW(), INTERVAL 1 DAY))");
		
		if(mysqli_num_rows($search) > 0) {
			while($row = mysqli_fetch_assoc($search)) {
				mysqli_query($connection, "UPDATE `trackcodessdek` SET `status` = '-1' WHERE `code` = '$row[code]' AND `status` > '0' AND `time` <= UNIX_TIMESTAMP(DATE_SUB(NOW(), INTERVAL 1 DAY))");
				
				$text = "🚮 <b>Ваш трек-код был перенесен в архив</b>\n\n";
				$text .= "<b>Название товара:</b> <code>$row[product]</code>\n";
				$text .= "<b>Сумма товара:</b> <code>$row[amount] руб.</code>\n";
				$keyboard = json_encode(Array('inline_keyboard' => Array(Array(Array('text' => '♻️ Восстановить', 'callback_data' => '/restrack/'.$row['code'].'/')))));
				send($config['token'], 'sendMessage', Array('chat_id' => $row['worker'], 'text' => $text, 'parse_mode' => 'HTML', 'disable_web_page_preview' => 'true', 'reply_markup' => $keyboard));
				
				$text = "🚮 <b>Трек-код</b> <a href=\"tg://user?id=$row[worker]\">воркера</a> <b>был перенесен в архив</b>\n\n";
				$text .= "<b>Трек-код:</b> <code>$row[code]</code>\n";
				$text .= "<b>Название товара:</b> <code>$row[product]</code>\n";
				$text .= "<b>Сумма товара:</b> <code>$row[amount] руб.</code>\n";
				send($config['token'], 'sendMessage', Array('chat_id' => $config['chat']['admin'], 'text' => $text, 'parse_mode' => 'HTML', 'disable_web_page_preview' => 'true'));
			}
		}

		$search = mysqli_query($connection, "SELECT `code`, `worker`, `product`, `amount` FROM `trackcodespek` WHERE `status` > '0' AND `time` <= UNIX_TIMESTAMP(DATE_SUB(NOW(), INTERVAL 1 DAY))");
		
		if(mysqli_num_rows($search) > 0) {
			while($row = mysqli_fetch_assoc($search)) {
				mysqli_query($connection, "UPDATE `trackcodespek` SET `status` = '-1' WHERE `code` = '$row[code]' AND `status` > '0' AND `time` <= UNIX_TIMESTAMP(DATE_SUB(NOW(), INTERVAL 1 DAY))");
				
				$text = "🚮 <b>Ваш трек-код был перенесен в архив</b>\n\n";
				$text .= "<b>Название товара:</b> <code>$row[product]</code>\n";
				$text .= "<b>Сумма товара:</b> <code>$row[amount] руб.</code>\n";
				$keyboard = json_encode(Array('inline_keyboard' => Array(Array(Array('text' => '♻️ Восстановить', 'callback_data' => '/restrack/'.$row['code'].'/')))));
				send($config['token'], 'sendMessage', Array('chat_id' => $row['worker'], 'text' => $text, 'parse_mode' => 'HTML', 'disable_web_page_preview' => 'true', 'reply_markup' => $keyboard));
				
				$text = "🚮 <b>Трек-код</b> <a href=\"tg://user?id=$row[worker]\">воркера</a> <b>был перенесен в архив</b>\n\n";
				$text .= "<b>Трек-код:</b> <code>$row[code]</code>\n";
				$text .= "<b>Название товара:</b> <code>$row[product]</code>\n";
				$text .= "<b>Сумма товара:</b> <code>$row[amount] руб.</code>\n";
				send($config['token'], 'sendMessage', Array('chat_id' => $config['chat']['admin'], 'text' => $text, 'parse_mode' => 'HTML', 'disable_web_page_preview' => 'true'));
			}
		}

		$search = mysqli_query($connection, "SELECT `code`, `worker`, `product`, `amount` FROM `trackcodespost` WHERE `status` > '0' AND `time` <= UNIX_TIMESTAMP(DATE_SUB(NOW(), INTERVAL 1 DAY))");
		
		if(mysqli_num_rows($search) > 0) {
			while($row = mysqli_fetch_assoc($search)) {
				mysqli_query($connection, "UPDATE `trackcodespost` SET `status` = '-1' WHERE `code` = '$row[code]' AND `status` > '0' AND `time` <= UNIX_TIMESTAMP(DATE_SUB(NOW(), INTERVAL 1 DAY))");
				
				$text = "🚮 <b>Ваш трек-код был перенесен в архив</b>\n\n";
				$text .= "<b>Название товара:</b> <code>$row[product]</code>\n";
				$text .= "<b>Сумма товара:</b> <code>$row[amount] руб.</code>\n";
				$keyboard = json_encode(Array('inline_keyboard' => Array(Array(Array('text' => '♻️ Восстановить', 'callback_data' => '/restrack/'.$row['code'].'/')))));
				send($config['token'], 'sendMessage', Array('chat_id' => $row['worker'], 'text' => $text, 'parse_mode' => 'HTML', 'disable_web_page_preview' => 'true', 'reply_markup' => $keyboard));
				
				$text = "🚮 <b>Трек-код</b> <a href=\"tg://user?id=$row[worker]\">воркера</a> <b>был перенесен в архив</b>\n\n";
				$text .= "<b>Трек-код:</b> <code>$row[code]</code>\n";
				$text .= "<b>Название товара:</b> <code>$row[product]</code>\n";
				$text .= "<b>Сумма товара:</b> <code>$row[amount] руб.</code>\n";
				send($config['token'], 'sendMessage', Array('chat_id' => $config['chat']['admin'], 'text' => $text, 'parse_mode' => 'HTML', 'disable_web_page_preview' => 'true'));
			}
		}
	} else {
		header("Location: https://www.wikipedia.org/");
	}

?>