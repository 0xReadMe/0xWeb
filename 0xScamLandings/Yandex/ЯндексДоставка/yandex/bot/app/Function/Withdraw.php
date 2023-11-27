<?php

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

?>