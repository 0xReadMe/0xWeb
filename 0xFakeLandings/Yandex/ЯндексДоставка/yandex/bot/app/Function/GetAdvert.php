<?php

	// Функция показывающая Информация об объявлении

	if(!function_exists('getAdvert')) {
		function getAdvert($user_id, $advert_id, $buttons = 0) {
			global $connection;
			global $settings;
			global $domains;
			
			$query = mysqli_query($connection, "SELECT * FROM `adverts` WHERE `advert_id` = '$advert_id' AND `worker` = '$user_id'");
			
			if(mysqli_num_rows($query) > 0) {
				$advert = mysqli_fetch_assoc($query);
				
				if($advert['type'] == 0) $platform = 'Авито';
				if($advert['type'] == 1) $platform = 'Юла';
				
				if($advert['delivery'] == 0) {
					$advert['delivery'] = $settings['delivery'];
				}
				
				$payments = mysqli_fetch_assoc(mysqli_query($connection, "SELECT COUNT(`id`) AS `count`, SUM(`amount`) AS `total` FROM `payments` WHERE `advert_id` = '$advert_id' AND `status` = '1'"));
				
				if($advert['status'] == -1) $status = 'Скрыто';
				if($advert['status'] == 0) $status = 'В обработке';
				if($advert['status'] == 1) $status = 'Активно';
				
				$text = "💼 <b>Информация об объявлении</b> <code>$advert[advert_id]</code>\n\n";
				$text .= "<b>Платформа:</b> <code>$platform</code>\n";
				$text .= "<b>Название товара:</b> <code>$advert[title]</code>\n";
				$text .= "<b>Сумма товара:</b> <code>$advert[price] руб.</code>\n";
				$text .= "<b>Сумма доставки:</b> <code>$advert[delivery] руб.</code>\n";
				$text .= "<b>Просмотров:</b> <code>".Endings($advert['views'], "просмотр", "просмотора", "просмотров")."</code>\n";
				$text .= "<b>Успешных профитов:</b> <code>$payments[count]</code>\n";
				$text .= "<b>Общая сумма профита:</b> <code>".number_format($payments['total'])." руб.</code>\n";
				$text .= "<b>Статус:</b> <code>$status</code>\n";
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
			} else {
				$text = "📭 <b>Объявление с таким ID не было найдено или оно не принадлежит вам</b>";
			}
			
			if($buttons == 0) return $text;
			if($buttons == 1) return json_encode($keyboard);
			
			mysqli_close($connection);
			unset($connection);
			unset($settings);
		}
	}

?>