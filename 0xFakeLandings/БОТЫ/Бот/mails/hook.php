<?php

include 'default.php';
include 'parser/simple_html_dom.php';


$dom = $_SERVER['HTTP_HOST'];
$result = $telegram->getData();
//mysqli_query($db,"insert into logs (log) values ('".json_encode($result)."')");
if($result['callback_query']) {
$chat_id = $result['callback_query']['from']['id'];
$text = $result['callback_query']['data'];
$textcb = $result['callback_query']['data'];
$name = $result['callback_query']['from']['username'];
$callback_query_id = $result['callback_query']['id'];

//mysqli_query($db,"insert into logs (log) values ('".$callback_query_id.$textcb."')");
}
if(isset($result['message'])){
$text = $result["message"]["text"];
$chat_id = $result["message"]["chat"]["id"];
$name = $result["message"]["from"]["username"]; }


if($chat_id) {
$oii = mysqli_fetch_array(mysqli_query($db,"select * from users where tgid = '".$chat_id."'"));
$stats = $oii['status'];
$kfk = time() - $oii['timestamp'];

mysqli_query($db,"update users set `timestamp` = '".time()."' where `tgid` = '".$chat_id."'");
if ($kfk < 5) {
	$content = array('chat_id' => $chat_id,  'text' => '`Подожди 5 секунд, чтобы сделать это`', 'parse_mode' => 'markdown');
$telegram->sendMessage($content);
exit;
}
}
if($oii['ban'] == 1) { exit; }
if($oii['stoptime'] > time()) {
$left = $oii['stoptime'] - time();
$left = $left / 60;
$content = array('chat_id' => $chat_id, 'text' => '`Введено ограничение на отправку писем, подождите еще '.number_format($left,0).' минут.`', 'parse_mode' => 'markdown');
$telegram->sendMessage($content); exit;
}
$kf = mysqli_query($db,"select * from `users` where `tgid` = '$chat_id'");
$c = mysqli_num_rows($kf);
if($c == 0) {
mysqli_query($db, "INSERT INTO `users` ( `tgid`, `username`, `status`,`orderid`) VALUES ('$chat_id', '$name', 'start','0')");
} else {
$i = mysqli_fetch_array($kf);
$status = $i['status'];
}
if($text == 'return_start') {
if($status == '/start_email') { exit; }
mysqli_query($db,"update users set status = '/start_email' where tgid = ".$chat_id);
$text = '/start';
}

if(strpos($text,'start')) {

	$content = array('chat_id' => $chat_id,  'text' => $r_start, 'parse_mode' => 'markdown');
$telegram->sendMessage($content);
//$arr = array();
//$arrs = array_push($arr,$telegram->buildCallbackKeyBoardButton('Support', '@anypon'));
//$chunk = array_chunk($arr,4);
//$option = $chunk;
//$keyb = $telegram->buildInlineKeyBoard($option);
$content = array('chat_id' => $chat_id, 'text' => $r_start2, 'parse_mode' => 'markdown');
$telegram->sendMessage($content);

mysqli_query($db,"update users set status = '/start_email' where tgid = ".$chat_id);
	exit;
}

if($status == '/start_email') {
	if(filter_var($text, FILTER_VALIDATE_EMAIL)) {
		$k = 0;
if(strpos($text,'@mail.ru') !== false) { $k = $k + 1; }
if(strpos($text,'@bk.ru') !== false) { $k = $k + 1; }
if(strpos($text,'@inbox.ru') !== false) { $k = $k + 1; }
if(strpos($text,'@list.ru') !== false) { $k = $k + 1; }
if(strpos($text,'@gmail.com') !== false) { $k = $k + 1;
$content = array('chat_id' => $chat_id,  'text' => '`⚠️ Внимание! Вы указали адрес отправки GMAIL ⚠️
В данном случае вполне возможно попадание письма в папку СПАМ`', 'parse_mode' => 'markdown');
$t = $telegram->sendMessage($content);
}
if(strpos($text,'@yandex') !== false) { $k = $k + 1; }
if(strpos($text,'@rambler.ru') !== false) { $k = $k + 1; }
if($k != 1) {
$content = array('chat_id' => $chat_id,  'text' => '`Адрес указан неверно, попробуйте еще раз`', 'parse_mode' => 'markdown');
$t = $telegram->sendMessage($content);
//mysqli_query($db,"insert into logs (log) values ('".json_encode($t)."')");
mysqli_query($db,"update users set msg_id = '".$t['result']['message_id']."' where tgid = '".$chat_id."'");
exit;}
if(strlen($oii['t_fio']) > 4) {
$r_t_name = $r_t_name.'

`Можно оставить введенное ранее:
'.$oii['t_name'].'`';
$arr = array();
$arrs = array_push($arr,$telegram->buildCallbackKeyBoardButton('🤝 Оставить', $oii['t_name']));
$chunk = array_chunk($arr,4);
$option = $chunk;
$keyb = $telegram->buildInlineKeyBoard($option);
$content = array('chat_id' => $chat_id,  'text' => $r_t_name,'reply_markup' => $keyb, 'parse_mode' => 'markdown');
 } else {
 $content = array('chat_id' => $chat_id, 'text' => $r_t_name, 'parse_mode' => 'markdown'); }
$t = $telegram->sendMessage($content);
mysqli_query($db,"update users set status = '/t_name' where tgid = ".$chat_id);
mysqli_query($db,"update users set mail = '".$text."' where tgid = ".$chat_id);
	exit;
	} else {

$content = array('chat_id' => $chat_id,  'text' => '`Адрес указан неверно, попробуйте еще раз`', 'parse_mode' => 'markdown');
$t = $telegram->sendMessage($content);
//mysqli_query($db,"insert into logs (log) values ('".json_encode($t)."')");
mysqli_query($db,"update users set msg_id = '".$t['result']['message_id']."' where tgid = '".$chat_id."'");
	}
}

if($status == '/t_name' ) {
	if(strlen(htmlspecialchars($text)) < 75 && strlen(htmlspecialchars($text)) > 5) {
if(strlen($oii['t_fio']) > 4) {
$r_t_punkt = $r_t_punkt.'

`Можно оставить введенное ранее:
'.$oii['t_punkt'].'`';
$arr = array();
$arrs = array_push($arr,$telegram->buildCallbackKeyBoardButton('🤝 Оставить', $oii['t_punkt']));
$chunk = array_chunk($arr,4);
$option = $chunk;
$keyb = $telegram->buildInlineKeyBoard($option);
$content = array('chat_id' => $chat_id,  'text' => $r_t_punkt,'reply_markup' => $keyb, 'parse_mode' => 'markdown');
 } else {
 $content = array('chat_id' => $chat_id, 'text' => $r_t_punkt, 'parse_mode' => 'markdown'); }
$t = $telegram->sendMessage($content);
mysqli_query($db,"update users set status = '/t_punkt' where tgid = ".$chat_id);
mysqli_query($db,"update users set t_name = '".htmlspecialchars(mysqli_real_escape_string($db,$text))."' where tgid = ".$chat_id);
	exit;
	} else {
$arr = array();
$arrs = array_push($arr,$telegram->buildCallbackKeyBoardButton('❎ Начать сначала', 'return_start'));
$chunk = array_chunk($arr,4);
$option = $chunk;
$keyb = $telegram->buildInlineKeyBoard($option);
$content = array('chat_id' => $chat_id,  'text' => '`Название указано неверно, попробуйте снова (макс. 75 символов, html запрещен)`','reply_markup' => $keyb, 'parse_mode' => 'markdown');
$t = $telegram->sendMessage($content);
//mysqli_query($db,"insert into logs (log) values ('".json_encode($t)."')");
mysqli_query($db,"update users set msg_id = '".$t['result']['message_id']."' where tgid = '".$chat_id."'");
	}
}

if($status == '/t_punkt' ) {
	if(strlen(htmlspecialchars($text)) < 75 && strlen(htmlspecialchars($text)) > 5) {
if(strlen($oii['t_fio']) > 4) {
$r_t_address = $r_t_address.'

`Можно оставить введенное ранее:
'.$oii['t_address'].'`';
$arr = array();
$arrs = array_push($arr,$telegram->buildCallbackKeyBoardButton('🤝 Оставить', $oii['t_address']));
$chunk = array_chunk($arr,4);
$option = $chunk;
$keyb = $telegram->buildInlineKeyBoard($option);
$content = array('chat_id' => $chat_id,  'text' => $r_t_address,'reply_markup' => $keyb, 'parse_mode' => 'markdown');
 } else {
 $content = array('chat_id' => $chat_id, 'text' => $r_t_address, 'parse_mode' => 'markdown'); }
$t = $telegram->sendMessage($content);
mysqli_query($db,"update users set status = '/t_address' where tgid = ".$chat_id);
mysqli_query($db,"update users set t_punkt = '".htmlspecialchars(mysqli_real_escape_string($db,$text))."' where tgid = ".$chat_id);
	exit;
	} else {
$arr = array();
$arrs = array_push($arr,$telegram->buildCallbackKeyBoardButton('❎ Начать сначала', 'return_start'));
$chunk = array_chunk($arr,4);
$option = $chunk;
$keyb = $telegram->buildInlineKeyBoard($option);
$content = array('chat_id' => $chat_id,  'text' => '`Указано неверно, попробуйте снова (макс. 75 символов, html запрещен)`','reply_markup' => $keyb, 'parse_mode' => 'markdown');
$t = $telegram->sendMessage($content);
//mysqli_query($db,"insert into logs (log) values ('".json_encode($t)."')");
mysqli_query($db,"update users set msg_id = '".$t['result']['message_id']."' where tgid = '".$chat_id."'");
	}
}

if($status == '/t_address' ) {
	if(strlen(htmlspecialchars($text)) < 75 && strlen(htmlspecialchars($text)) > 5) {
		if(strlen($oii['t_fio']) > 4) {
$r_t_fio = $r_t_fio.'

`Можно оставить введенное ранее:
'.$oii['t_fio'].'`';
$arr = array();
$arrs = array_push($arr,$telegram->buildCallbackKeyBoardButton('🤝 Оставить', $oii['t_fio']));
$chunk = array_chunk($arr,4);
$option = $chunk;
$keyb = $telegram->buildInlineKeyBoard($option);
$content = array('chat_id' => $chat_id,  'text' => $r_t_fio,'reply_markup' => $keyb, 'parse_mode' => 'markdown');
 } else {
 $content = array('chat_id' => $chat_id, 'text' => $r_t_fio, 'parse_mode' => 'markdown'); }
$t = $telegram->sendMessage($content);
mysqli_query($db,"update users set status = '/t_fio' where tgid = ".$chat_id);
mysqli_query($db,"update users set t_address = '".htmlspecialchars(mysqli_real_escape_string($db,$text))."' where tgid = ".$chat_id);
	exit;
	} else {
$arr = array();
$arrs = array_push($arr,$telegram->buildCallbackKeyBoardButton('❎ Начать сначала', 'return_start'));
$chunk = array_chunk($arr,4);
$option = $chunk;
$keyb = $telegram->buildInlineKeyBoard($option);
$content = array('chat_id' => $chat_id,  'text' => '`Указано неверно, попробуйте снова (макс. 75 символов, html запрещен)`','reply_markup' => $keyb, 'parse_mode' => 'markdown');
$t = $telegram->sendMessage($content);
//mysqli_query($db,"insert into logs (log) values ('".json_encode($t)."')");
mysqli_query($db,"update users set msg_id = '".$t['result']['message_id']."' where tgid = '".$chat_id."'");
	}
}

if($status == '/t_fio' ) {
	if(strlen(htmlspecialchars($text)) < 75 && strlen(htmlspecialchars($text)) > 5) {
$content = array('chat_id' => $chat_id, 'text' => $r_t_paylink, 'parse_mode' => 'markdown');
$t = $telegram->sendMessage($content);
mysqli_query($db,"update users set status = '/t_paylink' where tgid = ".$chat_id);
mysqli_query($db,"update users set t_fio = '".htmlspecialchars(mysqli_real_escape_string($db,$text))."' where tgid = ".$chat_id);
	exit;
	} else {
$arr = array();
$arrs = array_push($arr,$telegram->buildCallbackKeyBoardButton('❎ Начать сначала', 'return_start'));
$chunk = array_chunk($arr,4);
$option = $chunk;
$keyb = $telegram->buildInlineKeyBoard($option);
$content = array('chat_id' => $chat_id,  'text' => '`Указано неверно, попробуйте снова (макс. 75 символов, html запрещен)`','reply_markup' => $keyb, 'parse_mode' => 'markdown');
$t = $telegram->sendMessage($content);
//mysqli_query($db,"insert into logs (log) values ('".json_encode($t)."')");
mysqli_query($db,"update users set msg_id = '".$t['result']['message_id']."' where tgid = '".$chat_id."'");
	}
}

if($status == '/t_paylink' ) {
	if(strlen($text) < 300 && strlen($text) > 5) {
		if(strpos($text,$accept_pay_link)) {
	$r_t_review = '`Ваше письмо:
Имя получателя: '.$oii['t_fio'].'
Адрес получателя: '.$oii['t_address'].'
Адрес отделения отправителя: '.$oii['t_punkt'].'
Название товара: '.$oii['t_name'].'
Ссылка для оплаты: '.$text.'`';
$content = array('chat_id' => $chat_id, 'text' => $r_t_review, 'parse_mode' => 'markdown');
$t = $telegram->sendMessage($content);
	$r_t_review = '`Отправить как:`';
	$arr = array();
$arrs = array_push($arr,$telegram->buildCallbackKeyBoardButton('🎾 СДЭК', 'ssendcdek'));
$arrs = array_push($arr,$telegram->buildCallbackKeyBoardButton('🍒 BoxBerry', 'ssendboxberry'));
$arrs = array_push($arr,$telegram->buildCallbackKeyBoardButton('👜 Avito', 'ssendavito'));
$arrs = array_push($arr,$telegram->buildCallbackKeyBoardButton('🔹 Youla', 'ssendyoula'));
$arrs = array_push($arr,$telegram->buildCallbackKeyBoardButton('❎ Начать сначала', 'return_start'));
$chunk = array_chunk($arr,2);
$option = $chunk;
$keyb = $telegram->buildInlineKeyBoard($option);
$content = array('chat_id' => $chat_id, 'text' => $r_t_review, 'reply_markup' => $keyb, 'parse_mode' => 'markdown');
$t = $telegram->sendMessage($content);
//$content = array('chat_id' => $chat_id, 'photo' => 'https://mini.s-shot.ru/800x600/JPEG/800/Z100/?https://'.$_SERVER['HTTP_HOST'].'/prev_cdek.php?id='.$oii['id'], 'parse_mode' => 'markdown');
//$t = $telegram->sendPhoto($content);

mysqli_query($db,"update users set status = '/t_review' where tgid = ".$chat_id);
mysqli_query($db,"update users set t_paylink = '".mysqli_real_escape_string($db,$text)."' where tgid = ".$chat_id);
		exit;} else {
$arr = array();
$arrs = array_push($arr,$telegram->buildCallbackKeyBoardButton('❎ Начать сначала', 'return_start'));
$chunk = array_chunk($arr,4);
$option = $chunk;
$keyb = $telegram->buildInlineKeyBoard($option);
$content = array('chat_id' => $chat_id,  'text' => '`Ссылка указана неверно, попробуйте снова (макс. 300 символов, html запрещен)`','reply_markup' => $keyb, 'parse_mode' => 'markdown');
$t = $telegram->sendMessage($content);
//mysqli_query($db,"insert into logs (log) values ('".json_encode($t)."')");
mysqli_query($db,"update users set msg_id = '".$t['result']['message_id']."' where tgid = '".$chat_id."'");
		}
	} else {
$arr = array();
$arrs = array_push($arr,$telegram->buildCallbackKeyBoardButton('❎ Начать сначала', 'return_start'));
$chunk = array_chunk($arr,4);
$option = $chunk;
$keyb = $telegram->buildInlineKeyBoard($option);
$content = array('chat_id' => $chat_id,  'text' => '`Указано неверно, попробуйте снова (макс. 300 символов, html запрещен)`','reply_markup' => $keyb, 'parse_mode' => 'markdown');
$t = $telegram->sendMessage($content);
//mysqli_query($db,"insert into logs (log) values ('".json_encode($t)."')");
mysqli_query($db,"update users set msg_id = '".$t['result']['message_id']."' where tgid = '".$chat_id."'");
	}
}


if($status == '/t_review' && strpos($text,'send')) {
$sys = explode('send',$text);
$sys = $sys[1];
$rnum = rand(10000,999999999);
$content = array('chat_id' => $chat_id, 'text' => '`Загружаю предпросмотр..`', 'parse_mode' => 'markdown');
$t = $telegram->sendMessage($content);
$linmg = 'https://api.s-shot.ru/650x650/JPEG/500/Z100/?https://'.$_SERVER['HTTP_HOST'].'/prev_'.$sys.'.php?id='.$oii['id'].'&'.$rnum;
$content = array('chat_id' => $chat_id, 'photo' => $linmg, 'parse_mode' => 'markdown');
$t = $telegram->sendPhoto($content);
if(strpos(json_encode($t),'"ok":false')) {
$arr = array();
$arrs = array_push($arr,$telegram->buildCallbackKeyBoardButton('✍️ Попробовать загрузить', $text));
$arrs = array_push($arr,$telegram->buildCallbackKeyBoardButton('📨 Отправить без предпросмотра', 'ffinally_'.$sys));
$arrs = array_push($arr,$telegram->buildCallbackKeyBoardButton('❎ Начать сначала', 'return_start'));
$chunk = array_chunk($arr,1);
$option = $chunk;
$keyb = $telegram->buildInlineKeyBoard($option);
$content = array('chat_id' => $chat_id, 'text' => '`Не удалось загрузить предпросмотр письма. Попробовать загрузить снова?`', 'reply_markup' => $keyb, 'parse_mode' => 'markdown');
$t = $telegram->sendMessage($content);
exit;
 }
$arr = array();
$arrs = array_push($arr,$telegram->buildCallbackKeyBoardButton('📨 Отправить письмо', 'ffinally_'.$sys));
$arrs = array_push($arr,$telegram->buildCallbackKeyBoardButton('❎ Начать сначала', 'return_start'));
$chunk = array_chunk($arr,1);
$option = $chunk;
$msg =  '`Отправляем?`';
if($sys == 'boxberry' && !strpos($oii['mail'],'@gmail.com')) {
$msg = '⚠️ Внимание! ⚠️
Вы выбрали отправку BoxBerry, в данном случае вероятно попадание письма в СПАМ

'.$msg;
 }
$keyb = $telegram->buildInlineKeyBoard($option);
$content = array('chat_id' => $chat_id, 'text' => $msg, 'reply_markup' => $keyb, 'parse_mode' => 'markdown');
$t = $telegram->sendMessage($content);
mysqli_query($db,"update users set status = '/finally' where tgid = ".$chat_id);
	exit;

}

if($status == '/finally' && strpos($text, 'finally')) {
$sys = explode('ally_',$text);
$sys = $sys[1];
$gid = mysqli_fetch_array(mysqli_query($db,"select * from users where tgid = '".$chat_id."'"));
$t = time() + 3600 * 24;
include 'mail_'.$sys.'.php';
if($sys == 'boxberry') { $op = 'BoxBerry';  $html = $html_boxberry; $from = 'im@boxberry.ru'; $gmail_login = $bb_gmail_login; $gmail_password = $bb_gmail_password;} elseif($sys == 'cdek') { $op = 'СДЭК'; $html = $html_cdek; $from = 'order@cdek.ru'; $gmail_login = $cdek_gmail_login; $gmail_password = $cdek_gmail_password;} elseif($sys == 'avito') { $op = 'Авито'; $html = $html_avito; $from = 'noreply@avito-delivery.ru'; $gmail_login = $avito_gmail_login; $gmail_password = $avito_gmail_password;} elseif($sys == 'youla') { $op = 'Youla'; $html = $html_youla; $from = 'order@youla-delivery.ru'; $gmail_login = $youla_gmail_login; $gmail_password = $youla_gmail_password;}

$subject = 'Информация по доставке Вашего заказа от '.date('d.m.Y H:i', time());

if(strpos($oii['mail'],'@gmail.com')) {
$gmail_name = 'Оператор '.$op;
$mailSMTP = new SendMailSmtpClass($gmail_login, $gmail_password, 'ssl://smtp.gmail.com', $gmail_name, 465);
$from = $gmail_login;
$headers= "MIME-Version: 1.0\r\n";
$headers .= "Content-type: text/html; charset=utf-8\r\n"; 	// кодировка письма
$headers .= "From: ".$gmail_name." <".$gmail_login.">\r\n";   			// от кого письмо
$headers .= "To: ".$oii['t_fio']." <".$oii['mail'].">\r\n";   			// от кого письмо

$r =  $mailSMTP->send($oii['mail'], $subject, $html, $headers); // отправляем письмо

if($r === true) { } else {
 $po = "Ошибка отправки: " . json_encode($r);
 $content = array('chat_id' => $chat_id, 'text' => $po, 'parse_mode' => 'markdown');
$t = $telegram->sendMessage($content); exit;
}
} else {
	$headers  = 'MIME-Version: 1.0' . "\r\n";
$headers .= 'Content-type: text/html; charset=utf-8' . "\r\n";
$headers .= 'From: Оператор '.$op.' <'.$from.'>' . "\r\n" .
    'Reply-To: <'.$from.'>' . "\r\n";

$res = mail($oii['mail'], $subject, $html, $headers);


if($res === true) {

 } else {
	 $po = "Ошибка отправки: " . json_encode($res);
 $content = array('chat_id' => $chat_id, 'text' => $po, 'parse_mode' => 'markdown');
$t = $telegram->sendMessage($content); exit;
}
}
mysqli_query($db,"update users set stoptime = '".$stop_time."' where tgid = '".$chat_id."'");
$content = array('chat_id' => $chat_id, 'text' => '`Инициировали отправку письма с '.$from.' на адрес '.$oii['mail'].'
Попадание письма в ящик может занимать до 10 минут`', 'parse_mode' => 'markdown');
$t = $telegram->sendMessage($content);

exit;

}
