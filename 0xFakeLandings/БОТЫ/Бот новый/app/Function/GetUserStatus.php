<?php

if(!function_exists('getUserStatus')) {
	function getUserStatus($user_id) {
		global $connection;
		$query = mysqli_query($connection, "SELECT `access` FROM `accounts` WHERE `telegram` = '$user_id'");
		
		if(mysqli_num_rows($query) > 0) {
			$user = mysqli_fetch_assoc($query);
			
			if($user['access'] == -1) $status = 'Заблокирован';
			if($user['access'] == 0) $status = 'Неактивирован';
			if($user['access'] == 1) $status = 'Воркер';
			if($user['access'] == 25) $status = 'Sugar Daddy';
			if($user['access'] == 100) $status = 'Помощник';
			if($user['access'] >= 666) $status = 'Модератор';
			
			return $status;
		}
		
		mysqli_close($connection);
		unset($connection);
	}
}

?>