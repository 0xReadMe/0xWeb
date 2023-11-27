<?php

	//Функция возвращает информацию по мануалу проекта

	if(!function_exists('showHelp')) {
		function showHelp($buttons = 0) {
			global $config;
			
			$text = "📕 <b>Ознакомьтесь с нашими мануалами:</b>\n\n";
			$text .= "<a href=\"https://telegra.ph/Manual-po-vyvodu-c-BTC-BANKERa-01-07\">💰 Мануал по выводу с BTC banker</a>\n";
			$text .= "<a href=\"https://telegra.ph/Manual-po-skamu-na-avito-ot-WEBSCAM-01-07\">📦 Мануал по скаму на Авито</a>\n";
			$text .= "<a href=\"https://telegra.ph/Gajd-pro-anonimnost-01-07-2\">🌚 Гайд по анонимности</a>\n";
			$text .= "<a href=\"https://telegra.ph/Rabota-so-Sphere-01-07-2\">👻 Мануал по Sphere (браузер)</a>\n";
			$text .= "<a href=\"https://telegra.ph/CHto-luchshe-vystavlyat-na-prodazhu-01-07\">⭐️ Что лучше выставлять на продажу?</a>\n";
			$text .= "<a href=\"https://telegra.ph/Novaya-platforma-skama-Boxberry-01-07\">🚚 Мануал по скаму на Boxberry</a>\n";
			$text .= "<a href=\"https://telegra.ph/Instrukciya-po-bezopasnosti-s-telefona-01-10\">📱 Инструкция по безопасности с телефона</a>\n\n";
			$text .= "<a href=\"".$config['invites']['payments']."\">➡️ Наш канал с залётами 💸</a>\n";
			
			$keyboard = Array('inline_keyboard' => Array(Array(Array('text' => '🤖 Показать список команд', 'callback_data' => '/showCommands/')), Array(Array('text' => '🔹 Получить аккаунт Авито', 'callback_data' => '/getaccount/avito/'), Array('text' => '🔸 Получить аккаунт Юлы', 'callback_data' => '/getaccount/youla/')), Array(Array('text' => '📰 Скриншоты от тех.поддержки', 'url' => 'http://pussysquad.ru/pages/avito-delivery.html')), Array(Array('text' => '💳 Карта прямого приема', 'callback_data' => '/getcard/'))));
			
			if($buttons == 0) return $text;
			if($buttons == 1) return json_encode($keyboard);
			
			
			unset($config);
		}
	}

?>