<?php

	require_once $_SERVER['DOCUMENT_ROOT'].'/config.php';


	// Обработчики функций бота
	/*
	* DOCUMENT_ROOT:
	* /app/Function
	*/
	require_once $_SERVER['DOCUMENT_ROOT'].'/app/Function/Withdraw.php';
	require_once $_SERVER['DOCUMENT_ROOT'].'/app/Function/GetUserStatus.php';
	require_once $_SERVER['DOCUMENT_ROOT'].'/app/Function/GetMyProfile.php';
	require_once $_SERVER['DOCUMENT_ROOT'].'/app/Function/MySettings.php';
	require_once $_SERVER['DOCUMENT_ROOT'].'/app/Function/GetMyAdverts.php';
	require_once $_SERVER['DOCUMENT_ROOT'].'/app/Function/ShowTrack.php';
	require_once $_SERVER['DOCUMENT_ROOT'].'/app/Function/GetTrack.php';
	require_once $_SERVER['DOCUMENT_ROOT'].'/app/Function/GetAdvert.php';
	require_once $_SERVER['DOCUMENT_ROOT'].'/app/Function/ShowRules.php';
	require_once $_SERVER['DOCUMENT_ROOT'].'/app/Function/ShowAbout.php';
	require_once $_SERVER['DOCUMENT_ROOT'].'/app/Function/ShowHelp.php';
	require_once $_SERVER['DOCUMENT_ROOT'].'/app/Function/GetCard.php';
	require_once $_SERVER['DOCUMENT_ROOT'].'/app/Function/ShowCommands.php';
	require_once $_SERVER['DOCUMENT_ROOT'].'/app/Function/RefferalInfo.php';