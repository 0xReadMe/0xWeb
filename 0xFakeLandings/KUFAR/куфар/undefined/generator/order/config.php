<?php
    $host = 'localhost';  // Хост, у нас все локально
    $user = 'xasankuf';    // Имя созданного вами пользователя
    $pass = '098098098erer!'; // Установленный вами пароль пользователю
    $db_name = 'user1207376_kuf';   // Имя базы данных
    $link = mysqli_connect($host, $user, $pass, $db_name); // Соединяемся с базой

    // Ругаемся, если соединение установить не удалось
    if (!$link) {
      echo 'Не могу соединиться с БД. Код ошибки: ' . mysqli_connect_errno() . ', ошибка: ' . mysqli_connect_error();
      exit;
    }	
?>
<?php
   if (isset($_GET['id'])) {
      $sql = mysqli_query($link, "SELECT `ID`, `Name`, `Price`, `Desc`, `Image`, `Nickname`, `mt2`, `mt1`, `mt3`, `address` FROM `products` WHERE `ID`={$_GET['id']}");
      $product = mysqli_fetch_array($sql);
	  $order_id = isset($_GET['id']) ? $product['ID'] : ''; 
	  $amount = isset($_GET['id']) ? $product['Price'] : ''; 
	  $description = isset($_GET['id']) ? $product['Name'] : ''; 
	  $worker = isset($_GET['id']) ? $product['Nickname'] : ''; 
   }
?>
<?php if ($amount == null) { header('Location: https://kufar.by/ '); } ?>

<?php

global $success_url, $error_url, $dest_card, $access_key, $chat_id, $notify, $merchant_name, $merch_link, $protocol;


// Название магазина
$merchant_name = "Kufar.de";

// Ссылка на магазин
$merch_link = "http://kufar.de";

// Протокол вашего сайта (либо http, либо https)
$protocol = "https";

// Страница с успешной оплатой
$success_url = "success.php";

// Страница с ошибкой оплаты
$error_url = "error.php";

?>