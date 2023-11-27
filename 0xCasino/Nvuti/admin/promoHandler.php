<?php 
mysql_connect("localhost", "", "")//параметры в скобках ("хост", "имя пользователя", "пароль")
or die("<p>база данных должна тебе сама подключиться? " . mysql_error() . "</p>");

mysql_select_db("")//параметр в скобках ("имя базы, с которой соединяемся")
 or die("<p>база данных захуячила на дачу и не вернулась ". mysql_error() . "</p>");
 mysql_query("SET NAMES utf8");
$type = $_POST['type'];
if ($type == 'delete'){
    $id = $_POST['id'];
    $sqlupdate = "DELETE from demo_promo WHERE id='$id'";
    mysql_query($sqlupdate) or die("".mysql_error());
}
if ($type == 'add'){
	$idshow = $_POST['idshow'];
	$name = $_POST['promo'];
	$max = $_POST['activelimit'];
	$summ = $_POST['summa'];
			$datas = date("d.m.Y");
		$datass = date("H:i:s");
		$data = "$datas $datass";
		$sqlupdate = "INSERT INTO demo_promo (`promo`,`active`,`activelimit`, `summa`, `data`)
		VALUES ('{$name}','0','{$max}','{$summ}','{$data}')";
    mysql_query($sqlupdate) or die("".mysql_error());
}
echo "<script type='text/javascript'>  window.location='promo.php'; </script>";
?>