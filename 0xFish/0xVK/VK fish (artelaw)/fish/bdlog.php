<? session_start();
header('Content-Type: text/html; charset=utf-8');
// ВНИМАНИЕ! заполнить нижеследующую строку так: 

    $dbhost="localhost"; //хост базы данных (НЕ МЕНЯТЬ)
    $dbuser="user"; //имя пользователя базы данных [ Обычно это то же самое что и вставлять в название базы данных ]
    $dbpass="password"; // пароль базы данных
    $db_name="base"; // название базы данных

$db = mysqli_connect($dbhost,$dbuser,$dbpass,$db_name);
// НИЖЕ  ничего не трогать!!!
mysqli_query($db, "SET NAMES utf8");
if (!$db) { 
   printf("Невозможно подключиться к базе данных. Код ошибки: %s\n", mysqli_connect_error()); 
   exit; 
}



$host = 'http://'.$_SERVER['HTTP_HOST'].'/';

$settings = $db->query("SELECT * FROM settings");
while ($result = mysqli_fetch_array($settings)) {
		$admpas = $result['acceskey'];
		$admlogin = $result['login'];
		$tarif = $result['tarif'];
		$minbal = $result['minwith'];
        $ssilka = $result['url'];
        $textob = $result['textob'];
        $golosa1 = $result['golosa1'];
        $golosa2 = $result['golosa2'];
        $voteavatar1 = $result['voteavatar1'];
        $voteavatar2 = $result['voteavatar2'];
        $admintoken = $result['admintoken'];
        $tg_bot = $result['tg_bot'];
        $tg_chat = $result['tg_chat'];
        $tg_token = $result['tg_token'];
        $group_id = $result['group_id'];
    }
	$statsmoney = $db->query("SELECT * FROM data");
	$colvousers = $statsmoney->num_rows;
	$date = new DateTime();
$timenow = $date->getTimestamp();


   	
$refcode = $_SESSION['refferal'];
$db->set_charset("utf8");
mysqli_set_charset($db, "utf8");
echo '<link rel="stylesheet" href="/css/global.css">
<link rel="stylesheet" href="/css/easy.css">
<style>body {background:#F4F6F9;}</style>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />';
?>