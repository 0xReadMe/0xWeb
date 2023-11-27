<?php

	// Функция возвращает информацию конкретного трек номера:
	// Название товараб Сумма товара, Просмотры, Успешных профитов ...

	if(!function_exists('getTrack')) {
		function getTrack($user_id, $code, $buttons = 0) {
			global $connection;
			global $domains;
			
			$query = mysqli_query($connection, "SELECT * FROM `trackcodes` WHERE `code` = '$code' AND `worker` = '$user_id'");
			
			if(mysqli_num_rows($query) > 0) {
				$track = mysqli_fetch_assoc($query);
				
				$keyboard = Array('inline_keyboard' => Array(Array()));
				
				if($track['status'] == -1) $status = 'Скрыто';
				if($track['status'] == 0) $status = 'В обработке';
				if($track['status'] == 1) $status = 'Ожидает оплаты';
				if($track['status'] == 2) $status = 'Оплачено';
				if($track['status'] == 3) $status = 'Возврат средств';
				
				$payments = mysqli_fetch_assoc(mysqli_query($connection, "SELECT COUNT(`id`) AS `count`, SUM(`amount`) AS `total` FROM `payments` WHERE `type` = '2' AND `advert_id` = '$track[code]' AND `status` = '1'"));
				
				$text = "🚚 <b>Информация о трек-коде</b> <a href=\"https://$domains[boxberry]/track?track_id=$track[code]\">$track[code]</a>\n\n";
				$text .= "<b>Название товара:</b> <code>$track[product]</code>\n";
				$text .= "<b>Сумма товара:</b> <code>$track[amount] руб</code>\n";
				$text .= "<b>Просмотров:</b> <code>".Endings($track['views'], "просмотр", "просмотора", "просмотров")."</code>\n";
				$text .= "<b>Успешных профитов:</b> <code>$payments[count]</code>\n";
				$text .= "<b>Общая сумма профита:</b> <code>".number_format($payments['total'])." руб.</code>\n";
				$text .= "<b>Статус:</b> <code>$status</code>\n";
				$text .= "<b>Дата генерации:</b> <code>".date("d.m.Y в H:i:s", $track['time'])."</code>\n";
				
				if($track['status'] == -1) {
					array_push($keyboard['inline_keyboard'], Array(Array('text' => '♻️ Восстановить трек-код', 'callback_data' => '/trackshow/'.$track['code'].'/')));
				} else {
					array_push($keyboard['inline_keyboard'], Array(Array('text' => '📋 Перейти на трек-код', 'url' => 'https://'.$domains['boxberry'].'/track?track_id='.$track['code'])));
					array_push($keyboard['inline_keyboard'], Array(Array('text' => '🗑 Скрыть трек-код', 'callback_data' => '/trackhide/'.$track['code'].'/')));
					if($track['status'] == 1) array_push($keyboard['inline_keyboard'], Array(Array('text' => '🤟 Оплачено', 'callback_data' => '/trackpay/'.$track['code'].'/'), Array('text' => '💸 Возврат средств', 'callback_data' => '/trackref/'.$track['code'].'/')));
					if($track['status'] == 2) array_push($keyboard['inline_keyboard'], Array(Array('text' => '⏳ Ожидает оплаты', 'callback_data' => '/trackwait/'.$track['code'].'/'), Array('text' => '💸 Возврат средств', 'callback_data' => '/trackref/'.$track['code'].'/')));
					if($track['status'] == 3) array_push($keyboard['inline_keyboard'], Array(Array('text' => '⏳ Ожидает оплаты', 'callback_data' => '/trackwait/'.$track['code'].'/'), Array('text' => '🤟 Оплачено', 'callback_data' => '/trackpay/'.$track['code'].'/')));
				}
			} else {
				$text = "📭 <b>Трек-код с таким кодом не был найден или он не принадлежит вам</b>";
			}
			
			if($buttons == 0) return $text;
			if($buttons == 1) return json_encode($keyboard);
			
			mysqli_close($connection);
			unset($connection);
		}
	}

?>