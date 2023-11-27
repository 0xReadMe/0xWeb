<?php

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
						$text .= "<b>Получатель:</b> <i>$row[recipient]</i>";
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

?>