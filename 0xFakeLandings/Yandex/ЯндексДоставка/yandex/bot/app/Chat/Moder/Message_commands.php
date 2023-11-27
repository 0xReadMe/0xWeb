<?php

	if($message['text'] == '/help') {
		$text = "⚙️ <b>Основные команды</b>\n";
		$text .= "/help — Показать список команд\n";
		$text .= "/stats — Показать статистику проекта\n";
		$text .= "/info <code>[Telegram ID] или [username]</code> — Показать информацию о воркере\n";
		$text .= "/setdelivery <code>[Сумма]</code> — Установить сумму за доставку по умолчанию\n";
		$text .= "/warn <code>[Telegram ID]</code> — выдать предупреждение воркеру\n";
		$text .= "/unwarn <code>[Telegram ID]</code> — снять предупреждение воркеру\n";
		$text .= "/ban <code>[Telegram ID]</code> — заблокировать воркера\n";
		$text .= "/unban <code>[Telegram ID]</code> — разаблокировать воркера\n";
		$text .= "/checkip <code>[IP адрес]</code> — информация об IP адресе\n";
		$text .= "/stake <code>[Оплата];[Возврат]</code> — изменить ставку по умолчанию\n";
		$text .= "/setstake <code>[Telegram ID];[Оплата];[Возврат]</code> — изменить ставку воркеру\n";
		$text .= "/setbalance <code>[Telegram ID];[Сумма]</code> — изменить баланс воркеру\n";
		$text .= "/minprice <code>[Сумма]</code> — изменить минимальную сумму объявления\n";
		$text .= "/maxprice <code>[Сумма]</code> — изменить максимальную сумму объявления\n";
		$text .= "/msg <code>[Telegram ID];[Текст сообщения]</code> — отправить сообщение\n";
		$text .= "\n🗂 <b>Работа с объявлениями</b>\n";
		$text .= "/advert <code>[ID объявления]</code> — Подробная информация об объявлении\n";
		$text .= "/adverts <code>[Telegram ID] или ничего</code> — 10 последних объявлений или объявления пользователя\n";
		$text .= "/create <code>[Telegram ID];[ID объявления];[Название];[Цена]</code> — сгенерировать объявление\n";
		$text .= "/settitle <code>[ID объявления];[Название товара]</code> — Изменить название объявления\n";
		$text .= "/setimage <code>[ID объявления];[URL изображения]</code> — Изменить изображение объявления\n";
		$text .= "/setprice <code>[ID объявления];[Сумма]</code> — Изменить сумму объявления\n";
		$text .= "/deladvert <code>[ID объявления]</code> — скрыть объявление\n";
		$text .= "/resadvert <code>[ID объявления]</code> — восстановить объявление\n";
		$text .= "\n💳 <b>Работа с картами</b>\n";
		$text .= "/cards — Показать информацию о картах\n";
		$text .= "/setcard <code>[Telegram ID];[Карта]</code> — Установить карту воркеру\n";
		$text .= "/addcard <code>[Логин]:[Пароль]:[Токен]:[Номер карты]</code> — Добавить карту\n";
		$text .= "/delcard <code>[Номер карты]</code> — Удалить карту из списка\n";
		$text .= "/changecard <code>[Текущая карта];[Новая карта]</code> — Перекинуть всех воркеров с одной карты на другую\n";
		$text .= "/qiwipay <code>[Номер QIWI];[Получатель];[Сумма];[Комментарий]</code> — Перевести деньги на QIWI кошелёк\n";
		$text .= "/defaultcard <code>[Номер карты]</code> — Сделать картой по умолчанию\n";
		
		send($config['token'], 'sendMessage', Array('chat_id' => $config['chat']['moders'], 'text' => $text, 'parse_mode' => 'HTML', 'disable_web_page_preview' => 'true'));
	}

?>