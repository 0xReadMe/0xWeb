<?php 

    define('MYSQL_HOST', 'localhost');
	define('MYSQL_USER', 'baxberru_baza');
	define('MYSQL_PASS', '2E4a8D0v');
	define('MYSQL_BASE', 'baxberru_baza');
	$connection = mysqli_connect(MYSQL_HOST,MYSQL_USER,MYSQL_PASS) or die ('Не удалось подключиться к серверу MySQL: '.mysql_error());
	$database = mysqli_select_db($connection, MYSQL_BASE) or die ('Не удалось соединиться с базой данных: '.mysql_error());
	mysqli_query($connection, "SET NAMES utf8");

?>