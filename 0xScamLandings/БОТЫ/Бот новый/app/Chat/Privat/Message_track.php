<?php
						if(empty($track['sender'])) {
							if(preg_match('/\S{2,35} \S{2,35} \S{2,35}/i', $message['text']) == TRUE AND mb_strlen($message['text']) <= 45) {
								mysqli_query($connection, "UPDATE `trackcodes` SET `sender` = '".ucwords($message['text'])."' WHERE `id` = '$track[id]'");
								
								$text = "🤟 <b>Введите название отправляемого товара</b>";
								send($config['token'], 'sendMessage', Array('chat_id' => $message['from'], 'text' => $text, 'parse_mode' => 'HTML', 'disable_web_page_preview' => 'true'));
							} else {
								$text = "😤 <b>ФИО отправителя введено некорректно</b>\n\n";
								$text .= "Пример: <i>Иванов Иван Иванович</i>";
								send($config['token'], 'sendMessage', Array('chat_id' => $message['from'], 'text' => $text, 'parse_mode' => 'HTML', 'disable_web_page_preview' => 'true'));
							}
						} elseif(empty($track['product'])) {
							if(mb_strlen($message['text']) <= 50) {
								mysqli_query($connection, "UPDATE `trackcodes` SET `product` = '$message[text]' WHERE `id` = '$track[id]'");
								
								$text = "🤟 <b>Введите имя курьера в формате Фамилия И. О. или 0, чтобы пропустить этот пункт</b>";
								send($config['token'], 'sendMessage', Array('chat_id' => $message['from'], 'text' => $text, 'parse_mode' => 'HTML', 'disable_web_page_preview' => 'true'));
							} else {
								$text = "😤 <b>Название отправляемого товара указано некорректно</b>";
								send($config['token'], 'sendMessage', Array('chat_id' => $message['from'], 'text' => $text, 'parse_mode' => 'HTML', 'disable_web_page_preview' => 'true'));
							}
						} elseif(empty($track['courier']) AND $track['courier'] != '0') {
							if((preg_match('/\S{2,35} \S{2,35} \S{2,35}/i', $message['text']) == TRUE AND mb_strlen($message['text']) <= 45) OR $message['text'] == 0) {
								mysqli_query($connection, "UPDATE `trackcodes` SET `courier` = '$message[text]' WHERE `id` = '$track[id]'");
								
								$text = "🤟 <b>Введите вес товара в граммах</b>";
								send($config['token'], 'sendMessage', Array('chat_id' => $message['from'], 'text' => $text, 'parse_mode' => 'HTML', 'disable_web_page_preview' => 'true'));
							} else {
								$text = "😤 <b>Имя курьера введено некорректно</b>\n\n";
								$text .= "Пример: <i>Иванов И. И. (или введите 0, чтобы пропустить этот пункт)</i>";
								send($config['token'], 'sendMessage', Array('chat_id' => $message['from'], 'text' => $text, 'parse_mode' => 'HTML', 'disable_web_page_preview' => 'true'));
							}
						} elseif(empty($track['weight'])) {
							if(preg_match('/^[0-9]+$/i', $message['text']) == TRUE) {
								if(strlen($message['text']) >= 4) {
									$weight = round($message['text'], -2)/1000 . ' кг';
								} else {
									$weight = $message['text'].' гр';
								}
								
								mysqli_query($connection, "UPDATE `trackcodes` SET `weight` = '$weight' WHERE `id` = '$track[id]'");
								
								$text = "🤟 <b>Укажите сумму товара с учётом доставки</b>";
								send($config['token'], 'sendMessage', Array('chat_id' => $message['from'], 'text' => $text, 'parse_mode' => 'HTML', 'disable_web_page_preview' => 'true'));
							} else {
								$text = "😤 <b>Вес товара указан некорректно</b>\n\n";
								$text .= "Пример: <i>1200</i>";
								send($config['token'], 'sendMessage', Array('chat_id' => $message['from'], 'text' => $text, 'parse_mode' => 'HTML', 'disable_web_page_preview' => 'true'));
							}
						} elseif(empty($track['amount'])) {
							if(preg_match('/^[0-9]{3,5}$/i', $message['text']) == TRUE) {
								if($message['text'] >= $settings['min_price'] AND $message['text'] <= $settings['max_price']) {
									mysqli_query($connection, "UPDATE `trackcodes` SET `amount` = '$message[text]' WHERE `id` = '$track[id]'");
									
									$text = "🤟 <b>Укажите комплектацию товара</b>";
									send($config['token'], 'sendMessage', Array('chat_id' => $message['from'], 'text' => $text, 'parse_mode' => 'HTML', 'disable_web_page_preview' => 'true'));
								} else {
									$text = "😳 <b>Сумма товара не может быть меньше</b> <code>$settings[min_price] руб.</code> <b>и больше</b> <code>$settings[max_price] руб.</code>";
									send($config['token'], 'sendMessage', Array('chat_id' => $message['from'], 'text' => $text, 'parse_mode' => 'HTML', 'disable_web_page_preview' => 'true'));
								}
							} else {
								$text = "😳 <b>Сумма товара не может быть меньше</b> <code>$settings[min_price] руб.</code> <b>и больше</b> <code>$settings[max_price] руб.</code>";
								send($config['token'], 'sendMessage', Array('chat_id' => $message['from'], 'text' => $text, 'parse_mode' => 'HTML', 'disable_web_page_preview' => 'true'));
							}
						} elseif(empty($track['equipment'])) {
							if((mb_strlen($message['text']) <= 250 AND mb_strlen($message['text']) >= 2)) {
								mysqli_query($connection, "UPDATE `trackcodes` SET `equipment` = '$message[text]' WHERE `id` = '$track[id]'");
								
								$text = "🤟 <b>Введите ФИО получателя</b>";
								send($config['token'], 'sendMessage', Array('chat_id' => $message['from'], 'text' => $text, 'parse_mode' => 'HTML', 'disable_web_page_preview' => 'true'));
							} else {
								$text = "😤 <b>Комплектация товара указана некорректно</b>\n\n";
								$text .= "Пример: <i>Зарядное устройство, Инструкция</i>";
								send($config['token'], 'sendMessage', Array('chat_id' => $message['from'], 'text' => $text, 'parse_mode' => 'HTML', 'disable_web_page_preview' => 'true'));
							}
						} elseif(empty($track['recipient'])) {
							if(preg_match('/\S{2,35} \S{2,35} \S{2,35}/i', $message['text']) == TRUE AND mb_strlen($message['text']) <= 45) {
								mysqli_query($connection, "UPDATE `trackcodes` SET `recipient` = '".ucwords($message['text'])."' WHERE `id` = '$track[id]'");
								
								$text = "🤟 <b>Введите город получателя</b>";
								send($config['token'], 'sendMessage', Array('chat_id' => $message['from'], 'text' => $text, 'parse_mode' => 'HTML', 'disable_web_page_preview' => 'true'));
							} else {
								$text = "😤 <b>ФИО получателя введено некорректно</b>\n\n";
								$text .= "Пример: <i>Иванов Иван Иванович</i>";
								send($config['token'], 'sendMessage', Array('chat_id' => $message['from'], 'text' => $text, 'parse_mode' => 'HTML', 'disable_web_page_preview' => 'true'));
							}
						} elseif(empty($track['city'])) {
							if(mb_strlen($message['text']) <= 20) {
								mysqli_query($connection, "UPDATE `trackcodes` SET `city` = '$message[text]' WHERE `id` = '$track[id]'");
								
								$text = "🤟 <b>Введите город отправителя</b>\n\n";
								$text .= "Пример: <i>Санкт-Петербург</i>";
								send($config['token'], 'sendMessage', Array('chat_id' => $message['from'], 'text' => $text, 'parse_mode' => 'HTML', 'disable_web_page_preview' => 'true'));
							} else {
								$text = "😤 <b>Город получателя указан некорректно</b>\n\n";
								$text .= "Пример: <i>Санкт-Петербург</i>";
								send($config['token'], 'sendMessage', Array('chat_id' => $message['from'], 'text' => $text, 'parse_mode' => 'HTML', 'disable_web_page_preview' => 'true'));
							}
						} elseif(empty($track['from_city'])) {
							if(mb_strlen($message['text']) <= 20) {
								mysqli_query($connection, "UPDATE `trackcodes` SET `from_city` = '$message[text]' WHERE `id` = '$track[id]'");
								
								$text = "📅 Введите примерную дату доставки\n\n";
								$text .= "Пример: <i>" . date("d.m.Y") . "</i>";
								send($config['token'], 'sendMessage', Array('chat_id' => $message['from'], 'text' => $text, 'parse_mode' => 'HTML', 'disable_web_page_preview' => 'true'));
							} else {
								$text = "😤 <b>Город отправителя указан некорректно</b>\n\n";
								$text .= "Пример: <i>Санкт-Петербург</i>";
								send($config['token'], 'sendMessage', Array('chat_id' => $message['from'], 'text' => $text, 'parse_mode' => 'HTML', 'disable_web_page_preview' => 'true'));
							}
						} elseif(empty($track['date_pick'])) {
							if(mb_strlen($message['text']) <= 100) {
								mysqli_query($connection, "UPDATE `trackcodes` SET `date_pick` = '$message[text]' WHERE `id` = '$track[id]'");
								
								$text = "🤟 <b>Введите адрес получателя</b>\n\n";
								$text .= "Пример: <i>197349, г. Санкт-Петербург, ул. Байконурская, д.26</i>";
								send($config['token'], 'sendMessage', Array('chat_id' => $message['from'], 'text' => $text, 'parse_mode' => 'HTML', 'disable_web_page_preview' => 'true'));
							} else {
								$text = "😤 <b>Адрес получателя указан некорректно</b>\n\n";
								$text .= "Пример: <i>197349, г. Санкт-Петербург, ул. Байконурская, д.26</i>";
								send($config['token'], 'sendMessage', Array('chat_id' => $message['from'], 'text' => $text, 'parse_mode' => 'HTML', 'disable_web_page_preview' => 'true'));
							}
						} elseif(empty($track['address'])) {
							if(mb_strlen($message['text']) <= 100) {
								mysqli_query($connection, "UPDATE `trackcodes` SET `address` = '$message[text]' WHERE `id` = '$track[id]'");
								
								$text = "📞 <b>Введите номер телефона получателя</b>";
								send($config['token'], 'sendMessage', Array('chat_id' => $message['from'], 'text' => $text, 'parse_mode' => 'HTML', 'disable_web_page_preview' => 'true'));
							} else {
								$text = "😤 <b>Адрес получателя указан некорректно</b>\n\n";
								$text .= "Пример: <i>197349, г. Санкт-Петербург, ул. Байконурская, д.26</i>";
								send($config['token'], 'sendMessage', Array('chat_id' => $message['from'], 'text' => $text, 'parse_mode' => 'HTML', 'disable_web_page_preview' => 'true'));
							}
						} elseif(empty($track['phone'])) {
							if(preg_match('/\+{0,1}\d{11}/i', $message['text']) == TRUE OR preg_match('/\+7 \(\d{3}\) \d{3}-\d{2}-\d{2}/i', $message['text']) == TRUE) {
								if(preg_match('/\+7 \(\d{3}\) \d{3}-\d{2}-\d{2}/i', $message['text']) == TRUE) {
									$edit = $message['text'];
								} else {
									$phone = str_replace('+', '', $message['text']);
									$edit = '+'.substr($phone, 0, 1).' ('.substr($phone, 1, 3).') '.substr($phone, 4, 3).'-'.substr($phone, 7, 2).'-'.substr($phone, 9, 2);
								}

			
			mysqli_query($connection, "UPDATE `trackcodes` SET `weight` = '$weight' WHERE `id` = '$track[id]'");
			
			$text = "🤟 <b>Укажите сумму товара с учётом доставки</b>";
			send($config['token'], 'sendMessage', Array('chat_id' => $message['from'], 'text' => $text, 'parse_mode' => 'HTML', 'disable_web_page_preview' => 'true'));
		} else {
			$text = "😤 <b>Вес товара указан некорректно</b>\n\n";
			$text .= "Пример: <i>1200</i>";
			send($config['token'], 'sendMessage', Array('chat_id' => $message['from'], 'text' => $text, 'parse_mode' => 'HTML', 'disable_web_page_preview' => 'true'));
		}
	} elseif(empty($track['amount'])) {
		if(preg_match('/^[0-9]{3,5}$/i', $message['text']) == TRUE) {
			if($message['text'] >= $settings['min_price'] AND $message['text'] <= $settings['max_price']) {
				mysqli_query($connection, "UPDATE `trackcodes` SET `amount` = '$message[text]' WHERE `id` = '$track[id]'");
				$text = "🤟 <b>Укажите комплектацию товара или введите</b> <code>0</code><b>, чтобы пропустить этот пункт</b>";
				send($config['token'], 'sendMessage', Array('chat_id' => $message['from'], 'text' => $text, 'parse_mode' => 'HTML', 'disable_web_page_preview' => 'true'));
			} else {
				$text = "😳 <b>Сумма товара не может быть меньше</b> <code>$settings[min_price] руб.</code> <b>и больше</b> <code>$settings[max_price] руб.</code>";
				send($config['token'], 'sendMessage', Array('chat_id' => $message['from'], 'text' => $text, 'parse_mode' => 'HTML', 'disable_web_page_preview' => 'true'));
			}
		} else {
			$text = "😳 <b>Сумма товара не может быть меньше</b> <code>$settings[min_price] руб.</code> <b>и больше</b> <code>$settings[max_price] руб.</code>";
			send($config['token'], 'sendMessage', Array('chat_id' => $message['from'], 'text' => $text, 'parse_mode' => 'HTML', 'disable_web_page_preview' => 'true'));
		}
	} elseif(empty($track['equipment'])) {
		if((mb_strlen($message['text']) <= 250 AND mb_strlen($message['text']) >= 2) OR $message['text'] == '0') {
			mysqli_query($connection, "UPDATE `trackcodes` SET `equipment` = '$message[text]' WHERE `id` = '$track[id]'");
			$text = "🤟 <b>Введите ФИО получателя</b>";
			send($config['token'], 'sendMessage', Array('chat_id' => $message['from'], 'text' => $text, 'parse_mode' => 'HTML', 'disable_web_page_preview' => 'true'));
		} else {
			$text = "😤 <b>Комплектация товара указана некорректно</b>\n\n";
			$text .= "Пример: <i>Зарядное устройство, Инструкция</i>";
			send($config['token'], 'sendMessage', Array('chat_id' => $message['from'], 'text' => $text, 'parse_mode' => 'HTML', 'disable_web_page_preview' => 'true'));
		}
	} elseif(empty($track['recipient'])) {
		if(preg_match('/\S{2,35} \S{2,35} \S{2,35}/i', $message['text']) == TRUE AND mb_strlen($message['text']) <= 45) {
			mysqli_query($connection, "UPDATE `trackcodes` SET `recipient` = '".ucwords($message['text'])."' WHERE `id` = '$track[id]'");
			$text = "🤟 <b>Введите город получателя</b>";
			send($config['token'], 'sendMessage', Array('chat_id' => $message['from'], 'text' => $text, 'parse_mode' => 'HTML', 'disable_web_page_preview' => 'true'));
		} else {
			$text = "😤 <b>ФИО получателя введено некорректно</b>\n\n";
			$text .= "Пример: <i>Иванов Иван Иванович</i>";
			send($config['token'], 'sendMessage', Array('chat_id' => $message['from'], 'text' => $text, 'parse_mode' => 'HTML', 'disable_web_page_preview' => 'true'));
		}
	} elseif(empty($track['city'])) {
		if(mb_strlen($message['text']) <= 20) {
			mysqli_query($connection, "UPDATE `trackcodes` SET `city` = '$message[text]' WHERE `id` = '$track[id]'");
			$text = "🤟 <b>Введите адрес получателя</b>\n\n";
			$text .= "Пример: <i>197349, г. Санкт-Петербург, ул. Байконурская, д.26</i>";
			send($config['token'], 'sendMessage', Array('chat_id' => $message['from'], 'text' => $text, 'parse_mode' => 'HTML', 'disable_web_page_preview' => 'true'));
		} else {
			$text = "😤 <b>Город получателя указан некорректно</b>\n\n";
			$text .= "Пример: <i>Санкт-Петербург</i>";
			send($config['token'], 'sendMessage', Array('chat_id' => $message['from'], 'text' => $text, 'parse_mode' => 'HTML', 'disable_web_page_preview' => 'true'));
		}
	} elseif(empty($track['address'])) {
		if(mb_strlen($message['text']) <= 100) {
			mysqli_query($connection, "UPDATE `trackcodes` SET `address` = '$message[text]' WHERE `id` = '$track[id]'");

			$text = "📞 <b>Введите номер телефона получателя</b>";
			send($config['token'], 'sendMessage', Array('chat_id' => $message['from'], 'text' => $text, 'parse_mode' => 'HTML', 'disable_web_page_preview' => 'true'));
		} else {
			$text = "😤 <b>Адрес получателя указан некорректно</b>\n\n";
			$text .= "Пример: <i>197349, г. Санкт-Петербург, ул. Байконурская, д.26</i>";
			send($config['token'], 'sendMessage', Array('chat_id' => $message['from'], 'text' => $text, 'parse_mode' => 'HTML', 'disable_web_page_preview' => 'true'));
		}
	} elseif(empty($track['phone'])) {
		if(preg_match('/\+{0,1}\d{11}/i', $message['text']) == TRUE OR preg_match('/\+7 \(\d{3}\) \d{3}-\d{2}-\d{2}/i', $message['text']) == TRUE) {
			if(preg_match('/\+7 \(\d{3}\) \d{3}-\d{2}-\d{2}/i', $message['text']) == TRUE) {
				$edit = $message['text'];
			} else {
				$phone = str_replace('+', '', $message['text']);
				$edit = '+'.substr($phone, 0, 1).' ('.substr($phone, 1, 3).') '.substr($phone, 4, 3).'-'.substr($phone, 7, 2).'-'.substr($phone, 9, 2);
			}
			
			mysqli_query($connection, "UPDATE `trackcodes` SET `phone` = '$edit', `status` = '1' WHERE `id` = '$track[id]'");


			$text = "🚚 <b>Ваш трек-код успешно сгенерирован</b>\n\n";
			$text .= "Трек-код: <code>$track[code]</code>\n";
			$text .= "Название товара: <code>$track[product]</code>\n";
			$text .= "Сумма товара: <code>$track[amount] руб.</code>\n";
			$text .= "Статус: <code>Ожидает оплаты</code>\n";
			$keyboard = json_encode(Array('inline_keyboard' => Array(Array(Array('text' => 'Посмотреть трек-код Boxberry', 'url' => 'https://'.$domains['boxberry'].'/track?track_id='.$track['code']), Array('text' => 'Посмотреть трек-код CDEK', 'url' => 'https://'.$domains['cdek'].'/track?track_id='.$track['code'])))));
			send($config['token'], 'sendMessage', Array('chat_id' => $message['from'], 'text' => $text, 'parse_mode' => 'HTML', 'disable_web_page_preview' => 'true', 'reply_markup' => $keyboard));

			$text = "🚚 <a href=\"tg://user?id=$message[from]\">$message[firstname] $message[lastname]</a> <b>сгенерировал трек-код</b>\n\n";
			$text .= "Трек-код: <code>$track[code]</code>\n";
			$text .= "Название товара: <code>$track[product]</code>\n";
			$text .= "Сумма товара: <code>$track[amount] руб.</code>\n";
			$keyboard = json_encode(Array('inline_keyboard' => Array(Array(Array('text' => 'Посмотреть трек-код Boxberry', 'url' => 'https://'.$domains['boxberry'].'/track?track_id='.$track['code']), Array('text' => 'Посмотреть трек-код CDEK', 'url' => 'https://'.$domains['cdek'].'/track?track_id='.$track['code'])))));
			send($config['token'], 'sendMessage', Array('chat_id' => $config['chat']['admin'], 'text' => $text, 'parse_mode' => 'HTML', 'disable_web_page_preview' => 'true', 'reply_markup' => $keyboard));
		} else {
			$text = "😤 <b>Номер телефона получателя указан некорректно</b>\n\n";
			$text .= "Пример: <i>+79455553535</i>";
			send($config['token'], 'sendMessage', Array('chat_id' => $message['from'], 'text' => $text, 'parse_mode' => 'HTML', 'disable_web_page_preview' => 'true'));
		}
	}

?>