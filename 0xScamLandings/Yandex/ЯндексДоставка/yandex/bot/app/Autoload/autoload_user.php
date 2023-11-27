<?php

	/*
	* Root path command files:
	* /app/Commands/User
	* User
	*/
	
	// Комманды для нового пользователя
	require_once $_SERVER['DOCUMENT_ROOT'].'/app/Commands/User/Join.php';

	require_once $_SERVER['DOCUMENT_ROOT'].'/app/Commands/User/Trackcode.php';
	require_once $_SERVER['DOCUMENT_ROOT'].'/app/Commands/User/Getcard.php';

	// Скрывает объявление по ID
	require_once $_SERVER['DOCUMENT_ROOT'].'/app/Commands/User/Hide.php';