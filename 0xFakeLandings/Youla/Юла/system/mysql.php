<?php 

    define('MYSQL_HOST', 'localhost');
	define('MYSQL_USER', 'vacumscr_usr');
	define('MYSQL_PASS', '7L3i1T6r');
	define('MYSQL_BASE', 'vacumscr_usr');
	$connection = mysqli_connect(MYSQL_HOST,MYSQL_USER,MYSQL_PASS) or die ('Не удалось подключиться к серверу MySQL: '.mysql_error());
	$database = mysqli_select_db($connection, MYSQL_BASE) or die ('Не удалось соединиться с базой данных: '.mysql_error());
	mysqli_query($connection, "SET NAMES utf8");

?>