<?php
mysql_connect("localhost", "", "")//параметры в скобках ("хост", "имя пользователя", "пароль")
or die("<p>база данных должна тебе сама подключиться? " . mysql_error() . "</p>");

mysql_select_db("")//параметр в скобках ("имя базы, с которой соединяемся")
 or die("<p>база данных захуячила на дачу и не вернулась ". mysql_error() . "</p>");
 mysql_query("SET NAMES utf8");
?>
