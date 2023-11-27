<?php

function telegram_send($message, $receiver) {
	include "config.php";
	
	if (isset($message) && $message !== "") {
		switch ($receiver) {
			case "personal": $receiver = $bot_receiver; break;
			case "group": $receiver = $bot_receiver_add; break;
			default: $receiver = $bot_receiver; break;
		}

		file_get_contents("https://api.telegram.org/bot" . $bot_token . "/sendMessage?parse_mode=markdown&chat_id=" . $receiver . "&text=" . urlencode($message));
		sleep(1);
	}
}

?>