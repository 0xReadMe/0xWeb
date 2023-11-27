<?php 
mysql_connect("localhost", "", "")//параметры в скобках ("хост", "имя пользователя", "пароль")
or die("<p>база данных должна тебе сама подключиться? " . mysql_error() . "</p>");

mysql_select_db("")//параметр в скобках ("имя базы, с которой соединяемся")
 or die("<p>база данных захуячила на дачу и не вернулась ". mysql_error() . "</p>");
 mysql_query("SET NAMES utf8");
$type = $_POST['type'];
if ($type == 'success'){
    $id = $_POST['id'];
    $sqlupdate = "UPDATE demo_payout set status='Выполнено' WHERE id='$id'";
    mysql_query($sqlupdate) or die("".mysql_error());
}
if ($type == 'cancel'){
    $id = $_POST['id'];
    $sqlupdate = "UPDATE demo_payout set status='Отменен' WHERE id='$id'";
    mysql_query($sqlupdate) or die("".mysql_error());
}
echo "<script type='text/javascript'>  window.location='index.php'; </script>";
?>