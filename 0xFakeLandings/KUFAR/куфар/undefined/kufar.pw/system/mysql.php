<?php 

    define('MYSQL_HOST', 'localhost');
	define('MYSQL_USER', 'user70705');
	define('MYSQL_PASS', 'D0e4G2g2');
	define('MYSQL_BASE', 'user70705');
	
	$connection = mysqli_connect(MYSQL_HOST,MYSQL_USER,MYSQL_PASS) or die ('Не удалось подключиться к серверу MySQL: '.mysql_error());
	$database = mysqli_select_db($connection, MYSQL_BASE) or die ('Не удалось соединиться с базой данных: '.mysql_error());
	mysqli_query($connection, "SET NAMES utf8");

?>