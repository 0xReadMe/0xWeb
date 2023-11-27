<?php

	// Функция возвращает номер банковской карты для примого приёма

	if(!function_exists('getCard')) {
		function getCard() {
			global $connection;
			
			$card = '5272690008620047';
			
			$query = mysqli_query($connection, "SELECT `status` FROM `cards` WHERE `number` = '$card' AND `status` = '1'");
			
			if(mysqli_num_rows($query) > 0) {
				$text = "💳 <b>Карта прямого приёма</b>\n\n";
				$text .= "<b>Номер карты:</b> <code>".chunk_split($card, 4, ' ')."</code>\n";
				$text .= "<b>Банк:</b> <code>Санкт-Петербург</code>\n";
				$text .= "<b>Имя получателя:</b> <code>Надикто Тимофей Сергеевич</code>\n";
			} else {
				$text = "🥺 <b>На данный момент карта для прямого приема средств не привязана</b>";
			}
			
			return $text;
			
			mysqli_close($connection);
			unset($connection);
		}
	}

?>