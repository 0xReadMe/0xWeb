<?php

	// Комманды для нового пользователя

	if(preg_match('/\/join\/(\w+\/\d+|\w+\/|)/', $callback['type'])) {
		if($callback['type'] == '/join/') {
			$query = mysqli_query($connection, "SELECT `id`, `value1`, `value2`, `value3`, `value4`, `status` FROM `requests` WHERE `telegram` = '$callback[from]' AND `status` >= '0' AND `status` < '3' ORDER BY `id` DESC");
			
			if(mysqli_num_rows($query) > 0) {
				$request = mysqli_fetch_assoc($query);
				
				if($request['status'] == 1) {
					$text = "📨 <b>Ваша заявка готова к отправке, провьте её:</b>\n\n";
					$text .= "<b>Где нашли:</b> <i>$request[value1]</i>\n";
					$text .= "<b>Опыт работы:</b> <i>$request[value2]</i>\n";
					$text .= "<b>Время работы:</b> <i>$request[value3]</i>\n";
					if($request['value4'] == 0) {
						$text .= "<b>Кто вас пригласил:</b> <i>Никто</i>\n";
					} else {
						$text .= "<b>Кто вас пригласил:</b> <a href=\"tg://user?id=$request[value4]\">$request[value4]</a>\n";
					}
					$keyboard = json_encode(Array('inline_keyboard' => Array(Array(Array('text' => '✔️ Отправить', 'callback_data' => '/join/send'), Array('text' => '🗑 Отменить', 'callback_data' => '/join/cancel/')))));
					send($config['token'], 'sendMessage', Array('chat_id' => $callback['from'], 'text' => $text, 'parse_mode' => 'HTML', 'disable_web_page_preview' => 'true', 'reply_markup' => $keyboard));
				} elseif($request['status'] == 2) {
					$text = "⏱ <b>Ваша заявка находится на проверке у модераторов</b>\n\n";
					send($config['token'], 'sendMessage', Array('chat_id' => $callback['from'], 'text' => $text, 'parse_mode' => 'HTML', 'disable_web_page_preview' => 'true'));
				} elseif(empty($request['value1']) AND empty($request['value2']) AND empty($request['value3'])) {
					$text = "Откуда вы узнали о нас?";
					send($config['token'], 'sendMessage', Array('chat_id' => $callback['from'], 'text' => $text, 'parse_mode' => 'HTML', 'disable_web_page_preview' => 'true'));
				} elseif(isset($request['value1']) AND empty($request['value2']) AND empty($request['value3'])) {
					$text = "Есть ли опыт в подобной сфере, если да, то какой?";
					send($config['token'], 'sendMessage', Array('chat_id' => $callback['from'], 'text' => $text, 'parse_mode' => 'HTML', 'disable_web_page_preview' => 'true'));
				} elseif(isset($request['value1']) AND isset($request['value2']) AND empty($request['value3'])) {
					$text = "Сколько времени вы готовы уделять работе и какого результата вы хотите добиться?";
					send($config['token'], 'sendMessage', Array('chat_id' => $callback['from'], 'text' => $text, 'parse_mode' => 'HTML', 'disable_web_page_preview' => 'true'));
				} elseif(isset($request['value1']) AND isset($request['value2']) AND isset($request['value3'])) {
					$text = "Кто вас пригласил?";
					send($config['token'], 'sendMessage', Array('chat_id' => $callback['from'], 'text' => $text, 'parse_mode' => 'HTML', 'disable_web_page_preview' => 'true'));
				}
			} else {
				mysqli_query($connection, "INSERT INTO `requests` (`username`, `name`, `telegram`, `rules`, `status`, `time`) VALUES ('$callback[username]', '$callback[firstname] $callback[lastname]', '$callback[from]', '0', '0', '".time()."')");
				$text = "<b>Перед началом регистрации удалите смайлы из ника, бот их не распознаёт</b>\n\n";
				$text .= "1. Запрещено медиа с некорректным содержанием (порно, насилие, убийства, призывы к экстремизму, реклама наркотиков)\n";
				$text .= "2. Запрещен спам, флуд, пересылки с других каналов, ссылки на сторонние ресурсы\n";
				$text .= "3. Запрещено узнавать у друг друга персональную информацию\n";
				$text .= "4. Запрещено оскорблять администрацию\n";
				$text .= "5. Запрещено попрошайничество в беседе работников\n";
				$text .= "6. Администрация не несёт ответственности за блокировку ваших кошельков/карт\n";
				$text .= "\nВы подтверждаете, что ознакомились и согласны с условиями и правилами нашего проекта?";
				$keyboard = json_encode(Array('inline_keyboard' => Array(Array(Array('text' => '✅ Полностью согласен', 'callback_data' => '/join/accept/')))));
				send($config['token'], 'editMessageText', Array('chat_id' => $callback['chat_id'], 'message_id' => $callback['message_id'], 'text' => $text, 'reply_markup' => $keyboard));
			}
		} elseif($callback['type'] == '/join/accept/') {
			mysqli_query($connection, "UPDATE `requests` SET `rules` = '1' WHERE `telegram` = '$callback[from]' AND `status` = '0'");
			$text = "<b>Перед началом регистрации удалите смайлы из ника, бот их не распознаёт</b>\n\n";
			$text = "1. Запрещено медиа с некорректным содержанием (порно, насилие, убийства, призывы к экстремизму, реклама наркотиков)\n";
			$text .= "2. Запрещен спам, флуд, пересылки с других каналов, ссылки на сторонние ресурсы\n";
			$text .= "3. Запрещено узнавать у друг друга персональную информацию\n";
			$text .= "4. Запрещено оскорблять администрацию\n";
			$text .= "5. Запрещено попрошайничество в беседе работников\n";
			$text .= "6. Администрация не несёт ответственности за блокировку ваших кошельков/карт\n";
			$text .= "\n✅ Вы приняли наши правила";
			send($config['token'], 'editMessageText', Array('chat_id' => $callback['chat_id'], 'message_id' => $callback['message_id'], 'text' => $text, 'reply_markup' => ''));
			$text = "Откуда вы узнали о нас?";
			send($config['token'], 'sendMessage', Array('chat_id' => $callback['from'], 'text' => $text, 'parse_mode' => 'HTML', 'disable_web_page_preview' => 'true'));
			$text = "➕ <a href=\"tg://user?id=$callback[from]\">$callback[firstname] $callback[lastname]</a> <b>начал заполнение заявки в команду</b>\n";
			send($config['token'], 'sendMessage', Array('chat_id' => $config['chat']['admin'], 'text' => $text, 'parse_mode' => 'HTML', 'disable_web_page_preview' => 'true'));
		} elseif($callback['type'] == '/join/send/') {
			$query = mysqli_query($connection, "SELECT `id`, `value1`, `value2`, `value3`, `value4` FROM `requests` WHERE `telegram` = '$callback[from]' AND `status` = '1' ORDER BY `id` DESC");
			
			if(mysqli_num_rows($query) > 0) {
				$request = mysqli_fetch_assoc($query);
				mysqli_query($connection, "UPDATE `requests` SET `status` = '2' WHERE `id` = '$request[id]'");
				$text = "🐣 <b>Новая заявка в команду</b>\n\n";
				$text .= "<b>Никнейм:</b> <a href=\"tg://user?id=$callback[from]\">$callback[firstname] $callback[lastname]</a>\n";
				$text .= "<b>Telegram ID:</b> <code>$callback[from]</code>\n";
				$text .= "<b>Где нашел:</b> <i>$request[value1]</i>\n";
				$text .= "<b>Опыт работы:</b> <i>$request[value2]</i>\n";
				$text .= "<b>Время работы:</b> <i>$request[value3]</i>\n";
				if($request['value4'] == 0) {
					$text .= "<b>Кто вас пригласил:</b> <i>Никто</i>\n";
				} else {
					$text .= "<b>Кто пригласил:</b> <a href=\"tg://user?id=$request[value4]\">$request[value4]</a>\n\n";
				}
				$keyboard = json_encode(Array('inline_keyboard' => Array(Array(Array('text' => '✔️ Одобрить', 'callback_data' => '/join/approve/'.$request['id']), Array('text' => '❌ Отклонить', 'callback_data' => '/join/reject/'.$request['id'])))));
				send($config['token'], 'sendMessage', Array('chat_id' => $config['chat']['moders'], 'text' => $text, 'parse_mode' => 'HTML', 'disable_web_page_preview' => 'true', 'reply_markup' => $keyboard));
				$text = "💌 <b>Ваша заявка была отправлена модераторам</b>\n\n";
				$text .= "Ответ вам придёт после решения модераторов\n";
				send($config['token'], 'editMessageReplyMarkup', Array('chat_id' => $callback['chat_id'], 'message_id' => $callback['message_id'], 'reply_markup' => ''));
				send($config['token'], 'sendMessage', Array('chat_id' => $callback['from'], 'text' => $text, 'parse_mode' => 'HTML', 'disable_web_page_preview' => 'true'));
				$text = "➕ <a href=\"tg://user?id=$callback[from]\">$callback[firstname] $callback[lastname]</a> <b>отправил свою заявку на проверку модераторам</b>\n";
				send($config['token'], 'sendMessage', Array('chat_id' => $config['chat']['admin'], 'text' => $text, 'parse_mode' => 'HTML', 'disable_web_page_preview' => 'true'));
			} 
		} elseif($callback['type'] == '/join/cancel/') {
			$query = mysqli_query($connection, "SELECT `id` FROM `requests` WHERE `telegram` = '$callback[from]' AND `status` >= '0' AND `status` < '3' ORDER BY `id` DESC");
			
			if(mysqli_num_rows($query) > 0) {
				$request = mysqli_fetch_assoc($query);
				
				mysqli_query($connection, "UPDATE `requests` SET `status` = '-1' WHERE `id` = '$request[id]'");
				$text = "🗑 <b>Ваша заявка была удалена</b>";
				send($config['token'], 'editMessageReplyMarkup', Array('chat_id' => $callback['chat_id'], 'message_id' => $callback['message_id'], 'reply_markup' => ''));
				send($config['token'], 'sendMessage', Array('chat_id' => $callback['from'], 'text' => $text, 'parse_mode' => 'HTML', 'disable_web_page_preview' => 'true'));
				$text = "🗑 <a href=\"tg://user?id=$callback[from]\">$callback[firstname] $callback[lastname]</a> <b>отменил свою заявку в команду</b>\n";
				send($config['token'], 'sendMessage', Array('chat_id' => $config['chat']['admin'], 'text' => $text, 'parse_mode' => 'HTML', 'disable_web_page_preview' => 'true'));
			}
		} elseif(preg_match('/\/join\/approve\/\d{0,9}/', $callback['type'])) {
			$isAccess = mysqli_query($connection, "SELECT `id`, `access` FROM `accounts` WHERE `telegram` = '$callback[from]' AND `access` >= '100'");
			
			if(mysqli_num_rows($isAccess) > 0) {
				$request_id = substr($callback['type'], 14);
				
				$access = mysqli_fetch_assoc($isAccess);
				if($access['access'] >= 100) $rank = 'Помощник';
				if($access['access'] >= 500) $rank = 'Модератор';
				
				$query = mysqli_query($connection, "SELECT `username`, `name`, `telegram`, `value1`, `value2`, `value3`, `value4`, `msg` FROM `requests` WHERE `id` = '$request_id' AND `status` = '2'");
				
				if(mysqli_num_rows($query) > 0) {
					$request = mysqli_fetch_assoc($query);
					$users = mysqli_query($connection, "SELECT `id` FROM `accounts` WHERE `telegram` = '$request[telegram]'");
					$msg = array_diff(explode(',', trim($request['msg'])), Array(NULL));
					if(mysqli_num_rows($users) > 0) {
						mysqli_query($connection, "UPDATE `requests` SET `status` = '3' WHERE `id` = '$request_id'");
						mysqli_query($connection, "UPDATE `accounts` SET `username` = '$request[username]', `access` = '1', `stake` = '$settings[stake]', `card` = '0' WHERE `telegram` = '$request[telegram]'");
					} else {
						mysqli_query($connection, "UPDATE `requests` SET `status` = '3' WHERE `id` = '$request_id'");
						mysqli_query($connection, "INSERT INTO `accounts` (`username`, `telegram`, `wallet`, `access`, `stake`, `card`, `inviter`, `created`) VALUES ('$request[username]', '$request[telegram]', '0', '1', '$settings[stake]', '0', '$request[value4]', '".time()."')");
					}
					
					send($config['token'], 'unbanChatMember', Array('chat_id' => $config['chat']['workers'], 'user_id' => $request['telegram']));
					send($config['token'], 'unbanChatMember', Array('chat_id' => $config['chat']['payments'], 'user_id' => $request['telegram']));
					
					if($request['value4'] != 0) {
						#$text = "👔 <b>У вас новый реферал</b>";
						send($config['token'], 'sendMessage', Array('chat_id' => $request['value4'], 'text' => $text, 'parse_mode' => 'HTML', 'disable_web_page_preview' => 'true'));
					}
					
					$text = "🐣 <b>Новая заявка в команду</b>\n\n";
					$text .= "<b>Никнейм:</b> <a href=\"tg://user?id=$request[telegram]\">$request[name]</a>\n";
					$text .= "<b>Telegram ID:</b> <code>$request[telegram]</code>\n";
					$text .= "<b>Где нашел:</b> <i>$request[value1]</i>\n";
					$text .= "<b>Опыт работы:</b> <i>$request[value2]</i>\n";
					$text .= "<b>Время работы:</b> <i>$request[value3]</i>\n";
					if($request['value4'] == 0) {
						$text .= "<b>Кто вас пригласил:</b> <i>Никто</i>\n\n";
					} else {
						$text .= "<b>Кто вас пригласил:</b> <a href=\"tg://user?id=$request[value4]\">$request[value4]</a>\n\n";
					}
					$text .= "<b>$rank</b> <a href=\"tg://user?id=$callback[from]\">$callback[firstname] $callback[lastname]</a> <b>одобрил заявку</b>";
					send($config['token'], 'editMessageText', Array('chat_id' => $config['chat']['moders'], 'message_id' => $callback['message_id'], 'text' => $text, 'parse_mode' => 'HTML', 'disable_web_page_preview' => 'true', 'reply_markup' => ''));
					$text = "🙂 <b>Модераторы одобрили вашу заявку</b>\n\n";
					$text .= "Теперь вам доступен дополнительный функционал бота!\n\n";
					$text .= "Введите /help, чтобы отобразить список команд";
					$text .= "<b>\n\nЧат воркеров:</b>" . $config['invites']['workers'];
					$keyboard = json_encode(Array('keyboard' => Array(Array('👤 Мой профиль', '🗂 Мои объявления'),  Array('📦 Авито/Юла', '🚚 Boxberry')), 'resize_keyboard' => TRUE, 'one_time_keyboard' => FALSE));
					send($config['token'], 'sendMessage', Array('chat_id' => $request['telegram'], 'text' => $text, 'parse_mode' => 'HTML', 'disable_web_page_preview' => 'true', 'reply_markup' => $keyboard));
					$text = "➕ <b>$rank</b> <a href=\"tg://user?id=$callback[from]\">$callback[firstname] $callback[lastname]</a> <b>принял заявку в команду от </b> <a href=\"tg://user?id=$request[telegram]\">$request[name]</a>\n";
					send($config['token'], 'sendMessage', Array('chat_id' => $config['chat']['admin'], 'text' => $text, 'parse_mode' => 'HTML', 'disable_web_page_preview' => 'true'));
				}
			}
		} elseif(preg_match('/\/join\/reject\/\d{0,9}/', $callback['type'])) {
			$isAccess = mysqli_query($connection, "SELECT `id`, `access` FROM `accounts` WHERE `telegram` = '$callback[from]' AND `access` >= '100'");
			
			if(mysqli_num_rows($isAccess) > 0) {
				$request_id = substr($callback['type'], 13);
				
				$access = mysqli_fetch_assoc($isAccess);
				if($access['access'] >= 100) $rank = 'Помощник';
				if($access['access'] >= 500) $rank = 'Модератор';
				
				$query = mysqli_query($connection, "SELECT `name`, `telegram`, `value1`, `value2`, `value3`, `value4`, `msg` FROM `requests` WHERE `id` = '$request_id' AND `status` = '2'");

				if(mysqli_num_rows($query) > 0) {
					$request = mysqli_fetch_assoc($query);
					$msg = array_diff(explode(',', trim($request['msg'])), Array(NULL));
					mysqli_query($connection, "UPDATE `requests` SET `status` = '-1' WHERE `id` = '$request_id'");
					$text = "🐣 <b>Новая заявка в команду</b>\n\n";
					$text .= "<b>Никнейм:</b> <a href=\"tg://user?id=$request[telegram]\">$request[name]</a>\n";
					$text .= "<b>Telegram ID:</b> <code>$request[telegram]</code>\n";
					$text .= "<b>Где нашел:</b> <i>$request[value1]</i>\n";
					$text .= "<b>Опыт работы:</b> <i>$request[value2]</i>\n";
					$text .= "<b>Время работы:</b> <i>$request[value3]</i>\n";
					if($request['value4'] == 0) {
						$text .= "<b>Кто вас пригласил:</b> <i>Никто</i>\n\n";
					} else {
						$text .= "<b>Кто вас пригласил:</b> <a href=\"tg://user?id=$request[value4]\">$request[value4]</a>\n\n";
					}
					$text .= "<b>$rank</b> <a href=\"tg://user?id=$callback[from]\">$callback[firstname] $callback[lastname]</a> <b>отклонил заявку</b>\n";

					send($config['token'], 'editMessageText', Array('chat_id' => $config['chat']['moders'], 'message_id' => $callback['message_id'], 'text' => $text, 'parse_mode' => 'HTML', 'disable_web_page_preview' => 'true', 'reply_markup' => ''));
					$text = "🙁 <b>Модераторы отклонили вашу заявку</b>\n\n";
					$text .= "Попробуйте подать заявку в следующий раз\n";
					send($config['token'], 'sendMessage', Array('chat_id' => $request['telegram'], 'text' => $text, 'parse_mode' => 'HTML', 'disable_web_page_preview' => 'true'));
					$text = "➕ <b>$rank</b> <a href=\"tg://user?id=$callback[from]\">$callback[firstname] $callback[lastname]</a> <b>отклонил заявку в команду от </b> <a href=\"tg://user?id=$request[telegram]\">$request[name]</a>\n";
					send($config['token'], 'sendMessage', Array('chat_id' => $config['chat']['admin'], 'text' => $text, 'parse_mode' => 'HTML', 'disable_web_page_preview' => 'true'));
				}
			}
		}
	}

?>