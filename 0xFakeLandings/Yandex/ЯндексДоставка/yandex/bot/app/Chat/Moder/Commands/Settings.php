<?php

	if(preg_match('/\/settings/i', $message['text']) == TRUE) {
		if($settings['card'] == 0) $settings['card'] = 'Не установлена';
		
		$stake = explode(':', $settings['stake']);
		
		$avito = mysqli_fetch_assoc(mysqli_query($connection, "SELECT COUNT(*) AS `count` FROM `free` WHERE `type` = '0'"));
		$youla = mysqli_fetch_assoc(mysqli_query($connection, "SELECT COUNT(*) AS `count` FROM `free` WHERE `type` = '1'"));
		
		$text = "🔧 <b>Настройки</b>\n\n";
		$text .= "<b>Карта по умолчанию:</b> <code>$settings[card]</code>\n";
		$text .= "<b>Текущая ставка:</b> <code>оплата - $stake[0]% и возврат - $stake[1]%</code>\n";
		$text .= "<b>Минимальная сумма товара:</b> <code>$settings[min_price] руб.</code>\n";
		$text .= "<b>Максимальная сумма товара:</b> <code>$settings[max_price] руб.</code>\n";
		$text .= "<b>Сумма доставки:</b> <code>$settings[delivery] руб.</code>\n\n";
		$text .= "🎁 <b>Бесплатные аккаунты</b>\n";
		$text .= "<b>Авито:</b> <code>$avito[count] шт.</code> | <b>Юла:</b> <code>$youla[count] шт.</code>";
		
		send($config['token'], 'sendMessage', Array('chat_id' => $config['chat']['moders'], 'text' => $text, 'parse_mode' => 'HTML', 'disable_web_page_preview' => 'true'));
	}

?>