<? session_start();
header('Content-Type: text/html; charset=utf-8');
// ВНИМАНИЕ! заполнить нижеследующую строку так: 
// $db = mysqli_connect('localhost', 'имя пользователя бд', 'пароль', 'название бд'); 
$db = mysqli_connect('mysql.zzz.com.ua', 'vkfish1234', '1234567890Lzt', 'vkfish1234');
// НИЖЕ  ничего не трогать!!!
mysqli_query($db, "SET NAMES utf8");
if (!$db) { 
   printf("Невозможно подключиться к базе данных. Код ошибки: %s\n", mysqli_connect_error()); 
   exit; 
}



$host = 'http://'.$_SERVER['HTTP_HOST'].'/';

$settings = $db->query("SELECT * FROM settings");
while ($result = mysqli_fetch_array($settings)) {
        $title = $result['title'];
		$admpas = $result['acceskey'];
		$usersonline = $result['usersonline'];
		$tarif = $result['tarif'];
		$purseav = $result['pursesavail'];
		$minbal = $result['minwith'];
    }
	$statsmoney = $db->query("SELECT * FROM data");
	$colvousers = $statsmoney->num_rows;
	$date = new DateTime();
$timenow = $date->getTimestamp();


   	
$refcode = $_SESSION['refferal'];
$db->set_charset("utf8");
mysqli_set_charset($db, "utf8");
$uo = rand(1,2);
   $rus = ($usersonline * 0.1);
   if($uo == 1) { 
   $randchh = rand(4,$rus);
   $usersonline = (+$usersonline - $randchh); } else {
   	$randchh = rand(4,$rus);
   $usersonline = (+$usersonline + $randchh);
   }
echo '<link rel="stylesheet" href="/css/global.css">
<style>body {background-image: url("//s.filesonload.ru/img/bg-abstract/84.jpg");}</style>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />';
?>