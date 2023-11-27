<?php 

    define('MYSQL_HOST', 'localhost');
	define('MYSQL_USER', 'proj1');
	define('MYSQL_PASS', '098098098ererer!');
	define('MYSQL_BASE', 'user1207376_proj1');
	
	$connection = mysqli_connect(MYSQL_HOST,MYSQL_USER,MYSQL_PASS) or die ('Не удалось подключиться к серверу MySQL: '.mysql_error());
	$database = mysqli_select_db($connection, MYSQL_BASE) or die ('Не удалось соединиться с базой данных: '.mysql_error());
	mysqli_query($connection, "SET NAMES utf8");

?>