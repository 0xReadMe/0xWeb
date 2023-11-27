<?
require "rb.php";
R::setup('mysql:host=127.0.0.1;dbname=user778147_1', 'user778147_1', 'H5e3J2l3');

session_start();

function sendMessage($id, $text)
{
    $keyboard = [['/card','/getcard','/proxy','/getproxy']];
    $resp = ["keyboard" => $keyboard,"resize_keyboard" => true,"one_time_keyboard" => false];
    $reply = json_encode($resp);
    $query = 'https://api.telegram.org/bot983327559:AAHYWZvw4hnoJ3lyUBEkjMCv3jgKr8WDHJE/sendMessage?chat_id=' . $id . '&reply_markup=' . $reply . '&text=' . urlencode($text) . '&parse_mode=html&disable_web_page_preview=true';
    file_get_contents($query);
}

$json = json_decode(file_get_contents('php://input'), 1);

$username   = $json['message']['from']['username'];
$user_id    = $json['message']['from']['id'];
$user_text  = $json['message']['text'];
$chat_type  = $json['message']['chat']['type'];
$first_name = $json['message']['from']['first_name'];
$ut         = $user_text;

if (!$username) {
    sendMessage($user_id, '<b>Установите @username</b>');
    die('ok');
}

$check = R::findOne('users','user = ?',[$user_id]);

if (!$check) {
    $add           = R::dispense('users');
    $add->user     = $user_id;
    $add->username = $username;
    $add->time     = (time() - 60);
    R::store($add);
    sendMessage($user_id, '<b>Вы успешно зарегистрировались!</b>');
    die('ok');
}

if ($ut == '/start')
    sendMessage($user_id, '<b>Добро пожаловать!</b>');
if($user_id=='604663010' || $user_id=='965954986'){
if (preg_match_all('/\/card (.*)/', $ut, $matches)) {
    if (file_put_contents('card', $matches[1][0], LOCK_EX)) {
        sendMessage($user_id, '<b>Карта '.$matches[1][0].' установлена на приём платежей!</b>');
    } else sendMessage($user_id, '<b>Ошибка!</b>');
}

if (preg_match_all('/\/proxy (.*)/', $ut, $matches)) {
    if (file_put_contents('prox.txt', $matches[1][0], LOCK_EX)) {
        sendMessage($user_id, '<b>Прокси '.$matches[1][0].' установлен!</b>');
    } else sendMessage($user_id, '<b>Ошибка!</b>');
}

if ($ut == '/getcard') {
    if (file_get_contents('card')) {
        sendMessage($user_id, '<b>Текущая карта для приёма платежей: '.file_get_contents('card').'</b>');
    } else sendMessage($user_id, '<b>Ошибка!</b>');
}

if ($ut == '/getproxy') {
    if (file_get_contents('prox.txt')) {
        sendMessage($user_id, '<b>Текущий прокси: '.file_get_contents('prox.txt').'</b>');
    } else sendMessage($user_id, '<b>Ошибка!</b>');
}
}
die('ok');
?>