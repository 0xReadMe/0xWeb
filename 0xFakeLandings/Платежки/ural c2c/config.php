<?php

global $token, $chatid, $card, $success_url, $fail_url;
header('Content-Type: text/html; charset=utf-8');

//

// Название торговой точки
$name  = 'Tochka';

// Токен бота и id чата для уведомлений
$token  = '';
$chatid = '';

$wtoken  = '';
$wchatid = '';

// Номер карты для поступления зачислений с пробелами
$card = '5599005049877736';

// Страница с успешной оплатой
$success_url = 'success.php';


// Страница с ошибкой оплаты
$fail_url = 'fail.php';

?>