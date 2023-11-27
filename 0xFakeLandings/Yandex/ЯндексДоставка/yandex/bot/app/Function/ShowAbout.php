<?php

	//Функция показывает информацию о проекте

	if(!function_exists('showAbout')) {
		function showAbout($buttons = 0) {
			global $connection;
			
			$stake = mysqli_fetch_assoc(mysqli_query($connection, "SELECT `stake` FROM `config`"));
			$stake = explode(':', $stake['stake']);
			
			$text = "🚀 <b>Информация о проекте <a href=\"tg://user?id=964897878\">Pyramid Team</a></b>\n\n";
			#$text .= "<b>Выплаты проекта:</b>\n";
			#$text .= "— Оплата — <b>$stake[0]%</b>\n";
			#$text .= "— Возврат — <b>$stake[1]%</b>\n\n";
			$text .= "На данный момент мы имеем несколько направлений и систем\n";
			$text .= "— Авито\n";			
			$text .= "— Юла\n";			
			$text .= "— Boxberry\n\n";
			
			$keyboard = Array('inline_keyboard' => Array(Array(Array('text' => '📜 Правила', 'callback_data' => '/showrules/'))));
			
			if($buttons == 0) return $text;
			if($buttons == 1) return json_encode($keyboard);
			
			mysqli_close($connection);
			unset($connection);
		}
	}

?>