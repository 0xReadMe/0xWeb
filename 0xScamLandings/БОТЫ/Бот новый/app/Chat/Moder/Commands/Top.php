<?php

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

?>