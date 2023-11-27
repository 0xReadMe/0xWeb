<?php

	if(empty($advert['title'])) {
		if(preg_match("/http/", $message['text']) == FALSE AND $message['text'] != '🛍 Юла' AND $message['text'] != '📦 Авито') {
			if(mb_strlen($message['text']) >= 5 AND mb_strlen($message['text'] <= 90)) {
				mysqli_query($connection, "UPDATE `adverts` SET `title` = '$message[text]' WHERE `id` = '$advert[id]'");
				
				$text = "🤑 <b>Введите сумму вашего товара</b>";
				send($config['token'], 'sendMessage', Array('chat_id' => $message['from'], 'text' => $text, 'parse_mode' => 'HTML', 'disable_web_page_preview' => 'true'));
			} else {
				$text = "👺 <b>Название объявления не может быть короче 5 и длинее 90 символов</b>";
				send($config['token'], 'sendMessage', Array('chat_id' => $message['from'], 'text' => $text, 'parse_mode' => 'HTML', 'disable_web_page_preview' => 'true'));
			}
		} else {
			$text = "👺 <b>Введите корректное название объявления</b>";
			send($config['token'], 'sendMessage', Array('chat_id' => $message['from'], 'text' => $text, 'parse_mode' => 'HTML', 'disable_web_page_preview' => 'true'));
		}
	} elseif(empty($advert['price'])) {
		if(preg_match('/^[0-9]{3,5}$/i', $message['text']) == TRUE) {
			if($message['text'] >= $settings['min_price'] AND $message['text'] <= $settings['max_price']) {
				mysqli_query($connection, "UPDATE `adverts` SET `price` = '$message[text]' WHERE `id` = '$advert[id]'");
				
				$text = "📷 <b>Укажите ссылку на изображение вашего товара</b>\n\n";
				$text .= "Вы можете воспользоваться ботом для загрузки изображения со своего устройства и получения ссылки на него, бот: <b>@imgurbot_bot</b>";
				send($config['token'], 'sendMessage', Array('chat_id' => $message['from'], 'text' => $text, 'parse_mode' => 'HTML', 'disable_web_page_preview' => 'true'));
			} else {
				$text = "👺 <b>Сумма товара не может быть меньше $settings[min_price] RUB и больше $settings[max_price] RUB</b>";
				send($config['token'], 'sendMessage', Array('chat_id' => $message['from'], 'text' => $text, 'parse_mode' => 'HTML', 'disable_web_page_preview' => 'true'));
			}
		} else {
			$text = "👺 <b>Сумма товара не может быть меньше $settings[min_price] RUB и больше $settings[max_price] RUB</b>";
			send($config['token'], 'sendMessage', Array('chat_id' => $message['from'], 'text' => $text, 'parse_mode' => 'HTML', 'disable_web_page_preview' => 'true'));
		}
	} elseif(empty($advert['image'])) {
		if(preg_match('/(http|https):\/\/cache\d.youla.io\/files\/images\/.+.jpg/i', $message['text']) == TRUE OR preg_match('/(http|https):\/\/\d{1,3}.img.avito.st\/\d{3,4}x\d{3,4}\/\d+.jpg/i', $message['text']) == TRUE OR preg_match('/(http|https):\/\/i.imgur.com\/.+.jpg/i', $message['text']) == TRUE) {
			mysqli_query($connection, "UPDATE `adverts` SET `image` = '$message[text]', `status` = '1', `time` = '".time()."' WHERE `id` = '$advert[id]'");
			
			$text = "📎 <b>Ваше объявление было сгенерировано</b>\n\n";
			$text .= "ID объявления: <code>$advert[advert_id]</code>\n";
			$text .= "Название товара: <code>$advert[title]</code>\n";
			$text .= "Сумма товара: <code>$advert[price] руб.</code>\n";
			$text .= "Сумма доставки: <code>$settings[delivery] руб.</code>";
			
			if($advert['type'] == 0) {
				$keyboard = Array('inline_keyboard' => Array(Array(Array('text' => 'Страница оплаты', 'url' => 'https://'.$domains['avito'].'/buy?id='.$advert['advert_id']), Array('text' => 'Страница возврата', 'url' => 'https://'.$domains['avito'].'/refund?id='.$advert['advert_id']))));
			} elseif($advert['type'] == 1) {
				$keyboard = Array('inline_keyboard' => Array(Array(Array('text' => 'Страница оплаты', 'url' => 'https://'.$domains['youla'].'/product/'.$advert['advert_id'].'/buy/delivery'), Array('text' => 'Страница возврата', 'url' => 'https://'.$domains['youla'].'/refund/'.$advert['advert_id']))));
			} else {
				$keyboard = Array('inline_keyboard' => Array(Array()));
			}
			
			send($config['token'], 'sendMessage', Array('chat_id' => $message['from'], 'text' => $text, 'parse_mode' => 'HTML', 'disable_web_page_preview' => 'true', 'reply_markup' => json_encode($keyboard)));
		
			$text = "📋 <a href=\"tg://user?id=$message[from]\">$message[firstname] $message[lastname]</a> <b>сгенерировал своё объявление</b>\n\n";
			$text .= "ID объявления: <code>$advert[advert_id]</code>\n";
			$text .= "Название товара: <code>$advert[title]</code>\n";
			$text .= "Сумма товара: <code>$advert[price] руб.</code>\n";
			$text .= "Сумма доставки: <code>$settings[delivery] руб.</code>";
			
			send($config['token'], 'sendMessage', Array('chat_id' => $config['chat']['admin'], 'text' => $text, 'parse_mode' => 'HTML', 'disable_web_page_preview' => 'true', 'reply_markup' => json_encode($keyboard)));
		} else {
			$text = "👺 <b>Указана некорректная ссылка на изображение</b>\n\n";
			$text .= "Вставьте URL на своё изображение с вашего объявления на Авито или Юле, или воспользуйтесь ботом для загрузки изображения с вашего устройства, бот: <b>@imgurbot_bot</b>";
			send($config['token'], 'sendMessage', Array('chat_id' => $message['from'], 'text' => $text, 'parse_mode' => 'HTML', 'disable_web_page_preview' => 'true'));
		}
	}

?>