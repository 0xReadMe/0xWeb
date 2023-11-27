<?php

	if(preg_match('/\/stats/i', $message['text']) == TRUE) {
		$total['workers'] = mysqli_num_rows(mysqli_query($connection, "SELECT `id` FROM `accounts` WHERE `access` > '0'"));
		$total['users'] = mysqli_num_rows(mysqli_query($connection, "SELECT `id` FROM `accounts` WHERE `access` = '0'"));
		$total['banned'] = mysqli_num_rows(mysqli_query($connection, "SELECT `id` FROM `accounts` WHERE `access` < '0'"));
		$total['withCard'] = mysqli_num_rows(mysqli_query($connection, "SELECT `id` FROM `accounts` WHERE `access` > '0' AND `card` != '0'"));
		$total['withOutCard'] = mysqli_num_rows(mysqli_query($connection, "SELECT `id` FROM `accounts` WHERE `access` > '0' AND `card` = '0'"));
		$total['today'] = mysqli_num_rows(mysqli_query($connection, "SELECT `id` FROM `accounts` WHERE `access` > '0' AND DATE_FORMAT(FROM_UNIXTIME(`created`), '%d.%m.%Y') = '".date("d.m.Y")."'"));
		
		$payments = mysqli_fetch_assoc(mysqli_query($connection, "SELECT COUNT(`id`) AS `count`, SUM(`amount`) AS `total` FROM `payments` WHERE `status` = '1'"));
		$mpayments = mysqli_fetch_assoc(mysqli_query($connection, "SELECT COUNT(`id`) AS `count`, SUM(`amount`) AS `total` FROM `payments` WHERE `status` = '1' AND DATE_FORMAT(FROM_UNIXTIME(`time`), '%m.%Y') = '".date("m.Y")."'"));
		$tpayemnts = mysqli_fetch_assoc(mysqli_query($connection, "SELECT COUNT(`id`) AS `count`, SUM(`amount`) AS `today` FROM `payments` WHERE `status` = '1' AND DATE_FORMAT(FROM_UNIXTIME(`time`), '%d.%m.%Y') = '".date("d.m.Y")."'"));
		if(empty($tpayemnts['today'])) $tpayemnts['today'] = '0';
		
		$total['adverts'] = mysqli_num_rows(mysqli_query($connection, "SELECT `id` FROM `adverts`"));
		$total['activeAdverts'] = mysqli_num_rows(mysqli_query($connection, "SELECT `id` FROM `adverts` WHERE `status` = '1'"));
		$total['deletedAdverts'] = mysqli_num_rows(mysqli_query($connection, "SELECT `id` FROM `adverts` WHERE `status` = '-1'"));
		
		$text = "🐔 <b>Статистика проекта</b>\n\n";
		$text .= "<b>Активных:</b> <code>".Endings($total['workers'], "воркер", "воркера", "воркеров")."</code>\n";
		$text .= "<b>Неактивированных:</b> <code>".Endings($total['users'], "воркер", "воркера", "воркеров")."</code>\n";
		$text .= "<b>Заблокировано:</b> <code>".Endings($total['banned'], "воркер", "воркера", "воркеров")."</code>\n";
		$text .= "<b>С привязанной картой:</b> <code>".Endings($total['withCard'], "воркер", "воркера", "воркеров")."</code>\n";
		$text .= "<b>Без карты:</b> <code>".Endings($total['withOutCard'], "воркер", "воркера", "воркеров")."</code>\n";
		$text .= "<b>Сегодня одобрено:</b> <code>".Endings($total['today'], "воркер", "воркера", "воркеров")."</code>\n\n";
		$text .= "<b>Успешных оплат:</b> <code>$payments[count]</code>\n";
		$text .= "<b>Общий профит:</b> <code>$payments[total] руб.</code>\n\n";
		$text .= "<b>Оплат за месяц:</b> <code>$mpayments[count]</code>\n";
		$text .= "<b>Профит за месяц:</b> <code>$mpayments[total] руб.</code>\n\n";
		$text .= "<b>Оплат сегодня:</b> <code>$tpayemnts[count]</code>\n";
		$text .= "<b>Профит сегодня:</b> <code>$tpayemnts[today] руб.</code>\n\n";
		$text .= "<b>Сгенерировано:</b> <code>".Endings($total['adverts'], "объявление", "объявления", "объявлений")."</code>\n";
		$text .= "<b>Активных:</b> <code>".Endings($total['activeAdverts'], "объявление", "объявления", "объявлений")."</code>\n";
		$text .= "<b>Неактивных:</b> <code>".Endings($total['deletedAdverts'], "объявление", "объявления", "объявлений")."</code>\n";
		
		send($config['token'], 'sendMessage', Array('chat_id' => $config['chat']['moders'], 'text' => $text, 'parse_mode' => 'HTML', 'disable_web_page_preview' => 'true'));
	}

?>