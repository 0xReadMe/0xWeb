<?php

	// Функция возвращает список комманд бота

	if(!function_exists('showCommands')) {
		function showCommands($buttons = 0) {
			global $config;
			
			$text = "⚙️ Список команд бота:\n\n";
			$text .= "/help — Показать список команд\n";
			$text .= "/info — Показать информацию о себе\n";
			$text .= "/adverts — Посмотреть свои активные объявления\n";
			$text .= "/setdelivery <code>[ID объявления];[Сумма]</code> — Установить сумму за доставку\n";
			$text .= "/setprice <code>[ID объявления];[Сумма]</code> — Изменить сумму объявления\n";
			$text .= "/settitle <code>[ID объявления];[Название]</code> — Изменить название объявления\n";
			$text .= "/setimage <code>[ID объявления];[URL изображения]</code> — Изменить изображение товара\n";
			$text .= "/hide <code>[ID объявления]</code> — Скрыть объявление\n";
			
			$keyboard = Array('inline_keyboard' => Array(
					Array(Array('text' => '💬 Чат воркеров', 'url' => $config['invites']['workers']), Array('text' => '💸 Чат с залётами', 'url' => $config['invites']['payments'])), 
				));
				
			if($buttons == 0) return $text;
			if($buttons == 1) return json_encode($keyboard);
			
			unset($config);
		}		
	}

?>