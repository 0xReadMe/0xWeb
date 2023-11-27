<?php

$link = mysql_connect("localhost", "vkgift", "Vkgift132"); // 1 - Оставляем localhost. 2 - Имя пользователя. 3 - Пароль пользователя.
mysql_select_db("alex01", $link); // Название Базы Данных

mysql_query("DELETE FROM test", $link);
mysql_close();
header('Location: admin.php');
?>