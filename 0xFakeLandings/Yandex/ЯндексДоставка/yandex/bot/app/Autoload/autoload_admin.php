<?php

	/*
	* Root path command files:
	* /app/Commands/Admin
	* Admin
	*/
	
	// /warn - "выдать предупреждение воркеру"
	require_once $_SERVER['DOCUMENT_ROOT'].'/app/Commands/Admin/Warn.php';

	// /ban — заблокировать воркера
	require_once $_SERVER['DOCUMENT_ROOT'].'/app/Commands/Admin/Ban.php';
	
	// /unban [Telegram ID] — разаблокировать воркера
	require_once $_SERVER['DOCUMENT_ROOT'].'/app/Commands/Admin/Unban.php';
	
	// /adverts [Telegram ID] или ничего — 10 последних объявлений или объявления пользователя
	require_once $_SERVER['DOCUMENT_ROOT'].'/app/Commands/Admin/Adverts.php';

	// /cards — Показать информацию о картах
	require_once $_SERVER['DOCUMENT_ROOT'].'/app/Commands/Admin/Cards.php';

	// /advert [ID объявления] — Подробная информация об объявлении
	require_once $_SERVER['DOCUMENT_ROOT'].'/app/Commands/Admin/Advert.php';

	// Отправляет информацию о восстановленном пользователем объявлении
	//require_once $_SERVER['DOCUMENT_ROOT'].'/app/Commands/Admin/Show.php';

	// Относиться и к пользователю, показывает информацию о восстановлении трек-кода
	require_once $_SERVER['DOCUMENT_ROOT'].'/app/Commands/Admin/Trackshow.php';

	// Относиться и к пользователю, показывает информацию о изминении своего статуса трек-кода
	require_once $_SERVER['DOCUMENT_ROOT'].'/app/Commands/Admin/Trackwait.php';

	// Относиться и к пользователю, показывает информацию о изминении своего статуса трек-кода на "Оплачено"
	require_once $_SERVER['DOCUMENT_ROOT'].'/app/Commands/Admin/Trackpay.php';

	// Относиться и к пользователю, показывает информацию о изминении своего статуса трек-кода на "Возврат средств"
	require_once $_SERVER['DOCUMENT_ROOT'].'/app/Commands/Admin/Trackref.php';

	// Отправляет сообщения когда пользователь восстановил свой трек-код
	//require_once $_SERVER['DOCUMENT_ROOT'].'/app/Commands/Admin/Restrack.php';

	// Отправляет сообщения когда пользователь скрыл свой трек-код
	//require_once $_SERVER['DOCUMENT_ROOT'].'/app/Commands/Admin/Trackhide.php';

	require_once $_SERVER['DOCUMENT_ROOT'].'/app/Commands/Admin/Profithide.php';
	require_once $_SERVER['DOCUMENT_ROOT'].'/app/Commands/Admin/Getaccount.php';








