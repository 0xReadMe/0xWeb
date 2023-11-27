<?php

	// Функция показует информацию трек-номера

	if(!function_exists('showTrack')) {
		function showTrack($user_id, $code, $buttons = 0) {
			global $connection;
			
			$query = mysqli_query($connection, "SELECT `code`, `product`, `worker`, `amount`, `status` FROM `trackcodes` WHERE `code` = '$code' AND `worker` = '$user_id'");
			
			if(mysqli_num_rows($query) > 0) {
				$track = mysqli_fetch_assoc($query);
				
				if($track['status'] == -1) {
					mysqli_query($connection, "UPDATE `trackcodes` SET `status` = '1', `time` = '".time()."' WHERE `code` = '$code' AND `worker` = '$user_id' AND `status` = '-1'");
					
					$text = "💎 <b>Ваш трек-код был восстановлен</b>\n\n";
					$text .= "<b>Трек-код:</b> <code>$code</code>\n";
					$text .= "<b>Название товара:</b> <code>$track[product]</code>\n";
					$text .= "<b>Сумма товара:</b> <code>$track[amount] руб.</code>\n";
				} else {
					$text = "🧨 <b>Данный трек-код не скрыт</b>";
				}
			} else {
				$text = "🔎 <b>Данный трек-код не принадлежит вам или он ещё не создан</b>";
			}
			
			if($buttons == 0) return $text;
			
			mysqli_close($connection);
			unset($connection);
		}
	}

?>