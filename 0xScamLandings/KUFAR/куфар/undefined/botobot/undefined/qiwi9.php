<?php 

	require_once $_SERVER['DOCUMENT_ROOT'].'/config.php';
	

		require_once $_SERVER['DOCUMENT_ROOT'].'/qiwi/api.php';

		$i = 0;
		$solution = NULL;

		$cards = mysqli_query($connection, "SELECT `id`, `login`, `token` FROM `cards` WHERE `status` = '1' AND `token` != '0' LIMIT 5 OFFSET 40");

		while($row = mysqli_fetch_assoc($cards)) {
			$i = $i+1;
			$query = mysqli_query($connection, "SELECT `id`, `amount`, `blocked`, `verify`, `number`, `status`, `ip` FROM `cards` WHERE `login` = '$row[login]' AND `status` = '1'");

			$qiwi = new Qiwi($row['login'], $row['token']);
			$amount = floor($qiwi->getBalance()['accounts'][0]['balance']['amount']);

			if($qiwi->getAccount()['contractInfo']['blocked'] == false) $status = '0';
			if($qiwi->getAccount()['contractInfo']['blocked'] != false) $status = '1';
			
			if($qiwi->getAccount()['contractInfo']['identificationInfo'][0]['identificationLevel'] == 'VERIFIED') $verify = "1";
			if($qiwi->getAccount()['contractInfo']['identificationInfo'][0]['identificationLevel'] != 'VERIFIED') $verify = "0";

			if(mysqli_num_rows($query) > 0) {
				$card = mysqli_fetch_assoc($query);
				if($card['amount'] < $amount) {
					$totalAmount = ($amount-$card['amount']);
				} else {
					$totalAmount = 0;
				}
				
				if($card['ip'] != $qiwi->getAccount()['authInfo']['ip']) {
					$text = "🚪 <b>На карту</b> <code>$card[number]</code> <b>зашли с нового IP адреса</b> <code>".$qiwi->getAccount()['authInfo']['ip']."</code>";
					send($config['token'], 'sendMessage', Array('chat_id' => $config['chat']['admin'], 'text' => $text, 'parse_mode' => 'HTML', 'disable_web_page_preview' => 'true'));
				}
				
				if($card['amount'] < $amount) {
					$balance = $amount-$card['amount'];
					$text = "🏧 <b>На карту</b> <code>$card[number]</code> <b>поступило</b> <code>$balance руб.</code>";
					send($config['token'], 'sendMessage', Array('chat_id' => $config['chat']['admin'], 'text' => $text, 'parse_mode' => 'HTML', 'disable_web_page_preview' => 'true'));
				} elseif($card['amount'] > $amount) {
					$balance = $card['amount']-$amount;
					$text = "🏧 <b>С карты</b> <code>$card[number]</code> <b>было снято</b> <code>$balance руб.</code>";
					send($config['token'], 'sendMessage', Array('chat_id' => $config['chat']['admin'], 'text' => $text, 'parse_mode' => 'HTML', 'disable_web_page_preview' => 'true'));
				}
				
				if($card['blocked'] == 0 AND $status == 1) {
					$solution = 0;
					
					$text = "⛔️ <b>QIWI кошелёк заблокирован!</b>\n\n";
					$text .= "<b>Номер кошелька:</b> <code>+$row[login]</code>\n";
					$text .= "<b>Баланс кошелька:</b> <code>$card[amount] руб.</code>\n";
					$text .= "<b>Номер карты:</b> <code>".chunk_split($card['number'], 4, ' ')."</code>\n";
					
					$send = json_decode(curl_get_contents("https://api.telegram.org/bot$token/sendMessage?chat_id=-1001335996045&text=".urlencode($text)."&parse_mode=HTML&disable_web_page_preview=true"));
				}
				
				if($card['verify'] == 1 AND $verify == 0) {
					$solution = 0;
					
					$text = "⛔️ <b>У QIWI кошелька слетела верификация!</b>\n\n";
					$text .= "<b>Номер кошелька:</b> <code>+$row[login]</code>\n";
					$text .= "<b>Баланс кошелька:</b> <code>$card[amount] руб.</code>\n";
					$text .= "<b>Номер карты:</b> <code>".chunk_split($card['number'], 4, ' ')."</code>\n";
					
					$send = json_decode(curl_get_contents("https://api.telegram.org/bot$token/sendMessage?chat_id=-1001335996045&text=".urlencode($text)."&parse_mode=HTML&disable_web_page_preview=true"));
				}
				
				if(empty($solution)) {
					$solution = $card['status'];
				}
				
				mysqli_query($connection, "UPDATE `cards` SET `amount` = '$amount', `totalAmount` = `totalAmount`+$totalAmount, `blocked` = '$status', `verify` = '$verify', `status` = '$solution', `ip` = '".$qiwi->getAccount()['authInfo']['ip']."', `lastCheck` = '".time()."' WHERE `login` = '".$row['login']."'");
			}
		}


?>