<?php

	// Приветствие в чате воркеров

	if(isset($data->{'message'}->{'new_chat_member'})) {
		$query = mysqli_query($connection, "SELECT `id` FROM `accounts` WHERE `telegram` = '$message[from]' AND `access` > '0'");
		
		if(mysqli_num_rows($query) > 0) {
			$stake = explode(':', $settings['stake']);
			
			$text = "🖐🏿 <b>Добро пожаловать в чат,</b> <a href=\"tg://user?id=$message[from]\">$message[firstname] $message[lastname]</a><b>!</b>\n\n";
			$text .= "🤖 Наш бот — @Vacumscript_bot\n";
			$text .= "<a href=\"".$config['invites']['payments']."\">➡️ Наш канал с оплатами 💸</a>\n";
			$text .= "➖➖➖➖\n";
			$text .= "🔥 Выплаты — <b>$stake[0]%</b> и возвраты — <b>$stake[1]%</b> для всех <i>+ комиссия банкера</i>\n";
			$text .= "💳 Принимаем от $settings[min_price] руб до $settings[max_price] руб\n";
			$text .= "➖➖➖➖\n";
			$text .= "<b>Ознакомься с нашими мануалами:</b>\n";
			$text .= "<a href=\"https://telegra.ph/Kak-polzovatsya-BTC-BANKER-02-04-2\">💰 Мануал по выводу с BTC banker</a>\n";
			$text .= "<a href=\"https://telegra.ph/Manualy-po-Avito-02-18\">📦 Мануал по скаму на Авито</a>\n";
			$text .= "<a href=\"https://telegra.ph/Gajd-pro-anonimnost-01-07-2\">🌚 Гайд по анонимности</a>\n";
			$text .= "<a href=\"https://telegra.ph/Rabota-so-Sphere-01-07-2\">👻 Мануал по Sphere (браузер)</a>\n";
			$text .= "<a href=\"https://telegra.ph/CHto-luchshe-vystavlyat-na-prodazhu-01-07\">⭐️ Что лучше выставлять на продажу?</a>\n";
			$text .= "<a href=\"https://telegra.ph/Novaya-platforma-skama-Boxberry-01-07\">🚚 Мануал по скаму на Boxberry</a>\n";
			$text .= "<a href=\"https://telegra.ph/Instrukciya-po-bezopasnosti-s-telefona-01-10\">📱 Инструкция по безопасности с телефона</a>\n";
			$text .= "<a href=\"https://telegra.ph/Manual-Airbnb-01-20\">🏠 Мануал по работе с AIRBNB</a>\n";
			$text .= "➖➖➖➖\n";
			$text .= "<a href=\"https://t.me/AVITOHELPER_BOT\">🔥 Бот в котором можно купить аккаунты и прочее</a>\n";
			$text .= "➖➖➖➖\n";
			send($config['token'], 'sendMessage', Array('chat_id' => $config['chat']['workers'], 'text' => $text, 'parse_mode' => 'HTML', 'disable_web_page_preview' => 'true'));
			
			$text = "🐣 <b>К чату воркеров присоединился</b> <a href=\"tg://user?id=$message[from]\">$message[firstname] $message[lastname]</a>\n";
			send($config['token'], 'sendMessage', Array('chat_id' => $config['chat']['admin'], 'text' => $text, 'parse_mode' => 'HTML', 'disable_web_page_preview' => 'true'));
		} else {
			if($message['from'] != 771170005) {
				send($config['token'], 'kickChatMember', Array('chat_id' => $config['chat']['workers'], 'user_id' => $message['from'], 'until_date' => time()+24*500*3600));
				send($config['token'], 'kickChatMember', Array('chat_id' => $config['chat']['payments'], 'user_id' => $message['from'], 'until_date' => time()+24*500*3600));
				
				$text = "🚷 <b>Бот исключил</b> <a href=\"tg://user?id=$message[from]\">$message[firstname] $message[lastname]</a> <b>из беседы воркеров</b>\n\n";
				$text .= "<b>Причина:</b> <code>Пользователь не имеет доступа к данному чату или был заблокирован.</code>\n";
				send($config['token'], 'sendMessage', Array('chat_id' => $config['chat']['admin'], 'text' => $text, 'parse_mode' => 'HTML', 'disable_web_page_preview' => 'true'));
			}
		}
	}

?>