<?php

	if(preg_match('/^\/qiwipay/i', $message['text']) == TRUE) {
		if(preg_match('/^\/qiwipay [0-9]{11};([0-9]{11}|[0-9]{16});\d+(;.+|)$/i', $message['text']) == TRUE) {
			if($message['from'] == '826486511') {
				$money = explode(';', mb_substr($message['text'], 9));
				
				$query = mysqli_query($connection, "SELECT * FROM `cards` WHERE `login` = '$money[0]'");
					
				if(mysqli_num_rows($query) > 0) {
					$wallet = mysqli_fetch_assoc($query);
					
					require_once $_SERVER['DOCUMENT_ROOT'].'/qiwi/api.php';
					
					$qiwi = new Qiwi($wallet['login'], $wallet['token']);
					$amount = floor($qiwi->getBalance()['accounts'][0]['balance']['amount']);
					
					if($money[2] >= 1 AND $amount > ($money[2]+$money[2]*0.02) AND ($money[2]+$money[2]*0.02) < 60000) {
						if(preg_match('/^[0-9]{11}$/i', $money[1])) {
							$sendMoney = $qiwi->sendMoneyToQiwi([
												'id' => time()*1005+5 . 99,
												'sum' => [
													'amount'   => $money[2],
													'currency' => '643'
												], 
												'paymentMethod' => [
													'type' => 'Account',
													'accountId' => '643'
												],
												'comment' => $money[3],
												'fields' => [
													'account' => '+'.$money[1]
												]
											]);
											
							$money[1] = '+'.$money[1];
						} elseif(preg_match('/^[0-9]{16}$/i', $money[1])) {
							if(mb_substr($money[1], 0, 1) == 2) $providerId = 31652;
							if(mb_substr($money[1], 0, 1) == 4) $providerId = 1963;
							if(mb_substr($money[1], 0, 1) == 5) $providerId = 21013;
							if(mb_substr($money[1], 0, 6) == 489049) $providerId = 22351;
							
							$sendMoney = $qiwi->sendMoneyToCard($providerId, [
												'id' => time()*1005+5 . 99,
												'sum' => [
													'amount'   => $money[2],
													'currency' => '643'
												], 
												'paymentMethod' => [
													'type' => 'Account',
													'accountId' => '643'
												],
												'fields' => [
													'account' => $money[1]
												]
											]);
						}
										
						if($sendMoney['transaction']['state']['code'] == 'Accepted') {
							$text = "🏧 <b>Вы успешно перевели с</b> <code>+$money[0]</code> <b>на</b> <code>$money[1]</code> <b>$money[2] руб.</b>\n\n";
							send($config['token'], 'sendMessage', Array('chat_id' => $config['chat']['moders'], 'text' => $text, 'parse_mode' => 'HTML', 'disable_web_page_preview' => 'true'));
							$text = "🏧 <b>Модератор</b> <a href=\"tg://user?id=$message[from]\">$message[firstname] $message[lastname]</a> <b>перевел деньги с QIWI кошелька</b>\n\n";
							$text .= "<b>Кошелёк:</b> <code>$money[0]</code>\n";
							$text .= "<b>Получатель:</b> <code>$money[1]</code>\n";
							$text .= "<b>Сумма:</b> <code>$money[2] руб.</code>\n";
							send($config['token'], 'sendMessage', Array('chat_id' => $config['chat']['admin'], 'text' => $text, 'parse_mode' => 'HTML', 'disable_web_page_preview' => 'true'));
						} elseif(isset($sendMoney['message'])) {
							$text = "🏧 <b>Ошибка при переводе с</b> <code>+$money[0]</code> <b>на</b> <code>$money[1]</code> <b>$money[2] руб.</b>\n\n";
							$text .= "<b>Ошибка:</b> <i>$sendMoney[message]</i>";
							send($config['token'], 'sendMessage', Array('chat_id' => $config['chat']['moders'], 'text' => $text, 'parse_mode' => 'HTML', 'disable_web_page_preview' => 'true'));
						} else {
							$text = "🏧 <b>Ошибка при переводе с</b> <code>+$money[0]</code> <b>на</b> <code>$money[1]</code> <b>$money[2] руб.</b>\n\n";
							$text .= "<b>Ошибка:</b> <i>Неизвестная ошибка</i>";
							send($config['token'], 'sendMessage', Array('chat_id' => $config['chat']['moders'], 'text' => $text, 'parse_mode' => 'HTML', 'disable_web_page_preview' => 'true'));
						}
					} else {
						$text = "⛔️ <b>На QIWI кошельке недостаточно средств</b>";
						send($config['token'], 'sendMessage', Array('chat_id' => $config['chat']['moders'], 'text' => $text, 'parse_mode' => 'HTML', 'disable_web_page_preview' => 'true'));
					}
				} else {
					$text = "⛔️ <b>QIWI кошелек с таким номером не найден или неактивен</b>";
					send($config['token'], 'sendMessage', Array('chat_id' => $config['chat']['moders'], 'text' => $text, 'parse_mode' => 'HTML', 'disable_web_page_preview' => 'true'));
				}
			} else {
				$text = "📛 <b>У вас нет доступа к этой команде</b>";
				send($config['token'], 'sendMessage', Array('chat_id' => $config['chat']['moders'], 'text' => $text, 'parse_mode' => 'HTML', 'disable_web_page_preview' => 'true'));
			}
		} else {
			$text = "❔ Используйте /qiwipay <code>[Номер QIWI];[Получатель];[Сумма];[Комментарий]</code>";
			send($config['token'], 'sendMessage', Array('chat_id' => $config['chat']['moders'], 'text' => $text, 'parse_mode' => 'HTML', 'disable_web_page_preview' => 'true'));
		}
	}

?>