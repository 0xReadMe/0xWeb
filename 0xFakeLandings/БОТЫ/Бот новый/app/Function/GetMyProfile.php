<?php
	
	if(!function_exists('getMyProfile')) {
		function getMyProfile($user_id, $admin = 0, $buttons = 0) {
			global $connection;
			if($admin == 0) $query = mysqli_query($connection, "SELECT `username`, `telegram`, `wallet`, `balance`, `referral`, `access`, `warns`, `stake`, `card`, `inviter`, `created` FROM `accounts` WHERE `telegram` = '$user_id' AND `access` > '0'");
			if($admin == 1) $query = mysqli_query($connection, "SELECT `username`, `telegram`, `wallet`, `balance`, `referral`, `access`, `warns`, `stake`, `card`, `inviter`, `created` FROM `accounts` WHERE `telegram` = '$user_id'");
			
			if(mysqli_num_rows($query) > 0) {
				$user = mysqli_fetch_assoc($query);
				$tadverts = mysqli_query($connection, "SELECT `id` FROM `adverts` WHERE `worker` = '$user_id'");
				$ttracks = mysqli_query($connection, "SELECT `id` FROM `trackcodes` WHERE `worker` = '$user_id'");
				$adverts = mysqli_query($connection, "SELECT `id` FROM `adverts` WHERE `worker` = '$user_id' AND `status` = '1'");
				$tracks = mysqli_query($connection, "SELECT `id` FROM `trackcodes` WHERE `worker` = '$user_id' AND `status` > '0'");
				$profit = mysqli_fetch_assoc(mysqli_query($connection, "SELECT COUNT(`id`) AS `count`, SUM(`amount`) AS `total` FROM `payments` WHERE `worker` = '$user_id' AND `status` = '1'"));
				$invites = mysqli_fetch_assoc(mysqli_query($connection, "SELECT COUNT(`id`) AS `count` FROM `accounts` WHERE `inviter` = '$user_id'"));
				
				$stake = explode(':', $user['stake']);
				
				if($profit['total'] == NULL) $profit['total'] = '0';
				
				if($admin == 1) {
					$text = "👤 <b>Информация о работнике</b> <a href=\"tg://user?id=$user[telegram]\">$user[username]</a>\n\n";
				} else {
					$text = "👤 <b>Ваш профиль</b>\n\n";
				}
				
				if($user['wallet'] == 0) $user['wallet'] = 'Не закреплен';
				
				$text .= "🆔 <b>Telegram ID:</b> <code>$user[telegram]</code>\n";
				#$text .= "💵 <b>Баланс:</b> <code>$user[balance] руб.</code>\n";
				#$text .= "💸 <b>Текущая ставка:</b> <code>оплата - $stake[0]% и возврат - $stake[1]%</code>\n";
				if($admin == 1) $text .= "🗂 <b>Всего объявлений:</b> <code>".(mysqli_num_rows($tadverts)+mysqli_num_rows($ttracks))."</code>\n";
				$text .= "🧾 <b>Активных объявлений:</b> <code>".(mysqli_num_rows($adverts)+mysqli_num_rows($tracks))."</code>\n";
				#$text .= "💼 <b>BTC кошелёк:</b> <code>$user[wallet]</code>\n";
				
				$text .= "\n🐘 <b>Успешных заявок:</b> <code>$profit[count]</code>\n";
				$text .= "💰 <b>Общая сумма заработка:</b> <code>$profit[total] руб.</code>\n";
				if($admin == 1 AND $user['card'] != '0') $text .= "💳 <b>Карта:</b> <code>$user[card]</code>\n";
				if($admin == 1 AND $user['card'] == '0') $text .= "💳 <b>Карта:</b> <i>Не привязана</i>\n";
				
				#$text .= "\n🤝 <b>Приглашено:</b> <code>".Endings($invites['count'], "воркер", "воркера", "воркеров")."</code>\n";
				#$text .= "🤑 <b>Заработано на рефералах:</b> <code>".number_format($user['referral'])." руб.</code>\n";
				#if($user['inviter'] != 0) $text .= "👹 <b>Пригласил:</b> <a href=\"tg://user?id=$user[inviter]\">$user[inviter]</a>\n";
				
				#$text .= "\n💎 <b>Статус:</b> <i>".getUserStatus($user_id)."</i>\n";
				$text .= "\n⚠️ <b>Предупреждений:</b> <code>[$user[warns]/3]</code>\n";
				$text .= "🤝 <b>В команде:</b> <code>".Endings(floor((time()-$user['created'])/86400), "день", "дня", "дней")."</code>\n";
				
				#if($user['card'] == 0) $text .= "\n💳 <b>Карта не привязана, свяжитесь с модераторами!</b>\n";
				#if($user['card'] != 0) $text .= "\n💳 <b>Карта привязана — можно воркать!</b>\n";
				
				if($admin == 1) {
					$keyboard = Array('inline_keyboard' => Array(Array(Array('text' => '🗂 Показать объявления', 'callback_data' => '/adverts/'.$user['telegram'].'/'))));
					
					if($user['access'] == '-1') {
						array_push($keyboard['inline_keyboard'], Array(Array('text' => '♻️ Разблокировать', 'callback_data' => '/unban/'.$user['telegram'].'/')));
					} else {
						array_push($keyboard['inline_keyboard'], Array(Array('text' => '🚫 Заблокировать', 'callback_data' => '/ban/'.$user['telegram'].'/')));
						array_push($keyboard['inline_keyboard'], Array(Array('text' => '⚠️ Выдать предупреждение ['.$user['warns'].'/3]', 'callback_data' => '/warn/'.$user['telegram'].'/')));
					}
				} else {
					$keyboard = Array('inline_keyboard' => Array(Array(Array('text' => '🔧 Настройки', 'callback_data' => '/mysettings/'))));
				}
				
				if($buttons == 0) return $text;
				if($buttons == 1) return json_encode($keyboard);
			}
			
			mysqli_close($connection);
			unset($connection);
		}
	}

?>