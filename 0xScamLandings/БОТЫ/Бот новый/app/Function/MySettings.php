<?php

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

?>