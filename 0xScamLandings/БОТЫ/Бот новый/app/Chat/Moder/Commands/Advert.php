<?php

	if(preg_match('/^\/advert/i', $message['text']) == TRUE AND preg_match('/\/adverts/i', $message['text']) == FALSE) {
		if(preg_match('/^\/advert ([a-z0-9]{24}|\d+)$/i', $message['text']) == TRUE) {
			$advert_id = mb_substr($message['text'], 8);
			
			$query = mysqli_query($connection, "SELECT * FROM `adverts` WHERE `advert_id` = '$advert_id'");
			
			if(mysqli_num_rows($query) > 0) {
				$advert = mysqli_fetch_assoc($query);
				
				if($advert['type'] == 0) $url = "https://avito.ru/$advert[advert_id]" AND $platform = 'Авито';
				if($advert['type'] == 1) $url = "https://youla.ru/p$advert[advert_id]" AND $platform = 'Юла';
				
				if($advert['delivery'] == 0) $advert['delivery'] = $settings['delivery'];
				if($advert['status'] == -1) $status = 'Скрыто';
				if($advert['status'] == 0) $status = 'В обработке';
				if($advert['status'] == 1) $status = 'Активно';
				
				$payments = mysqli_fetch_assoc(mysqli_query($connection, "SELECT COUNT(`id`) AS `count`, SUM(`amount`) AS `total` FROM `payments` WHERE `advert_id` = '$advert_id' AND `status` = '1'"));
				
				$text = "💼 <b>Информация об объявлении</b> <a href=\"$url\">$advert_id</a>\n\n";
				$text .= "<b>Платформа:</b> <code>$platform</code>\n";
				$text .= "<b>Название товара:</b> <code>$advert[title]</code>\n";
				$text .= "<b>Сумма товара:</b> <code>$advert[price] руб.</code>\n";
				$text .= "<b>Сумма доставки:</b> <code>$advert[delivery] руб.</code>\n";
				$text .= "<b>Автор объявления:</b> <a href=\"tg://user?id=$advert[worker]\">$advert[worker]</a>\n";
				$text .= "<b>Просмотров объявления:</b> <code>".Endings($advert['views'], "просмотр", "просмотра", "просмоторв")."</code>\n";
				$text .= "<b>Статус:</b> <code>$status</code>\n";
				$text .= "<b>Успешных профитов:</b> <code>$payments[count]</code>\n";
				$text .= "<b>Общая сумма профита:</b> <code>".number_format($payments['total'])." руб.</code>\n";
				$text .= "<b>Дата генерации:</b> <code>".date("d.m.Y в H:i:s", $advert['time'])."</code>\n";
				
				if($advert['type'] == 0) {
					$keyboard = Array('inline_keyboard' => Array(Array(Array('text' => 'Страница оплаты', 'url' => 'https://'.$domains['avito'].'/buy?id='.$advert['advert_id']), Array('text' => 'Страница возврата', 'url' => 'https://'.$domains['avito'].'/refund?id='.$advert['advert_id']))));
				} elseif($advert['type'] == 1) {
					$keyboard = Array('inline_keyboard' => Array(Array(Array('text' => 'Страница оплаты', 'url' => 'https://'.$domains['youla'].'/product/'.$advert_id.'/buy/delivery'), Array('text' => 'Страница возврата', 'url' => 'https://'.$domains['youla'].'/refund/'.$advert_id))));
				} else {
					$keyboard = Array('inline_keyboard' => Array(Array()));
				}
				
				if($advert['status'] == -1) {
					array_push($keyboard['inline_keyboard'], Array(Array('text' => 'Восстановить объявление', 'callback_data' => '/show/'.$advert_id.'/')));
				} elseif($advert['status'] > 0) {
					array_push($keyboard['inline_keyboard'], Array(Array('text' => 'Скрыть объявление', 'callback_data' => '/hide/'.$advert_id.'/')));
				}
				
				send($config['token'], 'sendMessage', Array('chat_id' => $config['chat']['moders'], 'text' => $text, 'parse_mode' => 'HTML', 'disable_web_page_preview' => 'true', 'reply_markup' => $keyboard));
			} else {
				$text = "🔎 <b>Объявление с таким ID не было найдено</b>";
				send($config['token'], 'sendMessage', Array('chat_id' => $config['chat']['moders'], 'text' => $text, 'parse_mode' => 'HTML', 'disable_web_page_preview' => 'true'));
			}
		} else {
			$text = "❔ Используйте /advert <code>[ID объявления]</code>";
			send($config['token'], 'sendMessage', Array('chat_id' => $config['chat']['moders'], 'text' => $text, 'parse_mode' => 'HTML', 'disable_web_page_preview' => 'true'));
		}
	}

?>