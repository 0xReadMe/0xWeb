<?php
require("bd.php");
$betSize = rand(100, 3000); 
$betPercent = rand(30, 75); 
$suma = $suma = round(((100 / $betPercent) * $betSize), 2); 
$dete = time(); 
$rand = rand($min, 999999); 
 
for ($i=1; $i<=8; $i++) 
{ 
    $salt1 .= $chr[rand(1,48)];
    $salt2 .= $chr[rand(1,48)];
	
}
    $sha = hash('sha512', $salt1.$number.$salt2);
 
 $quotes = array(); 
 $quotes[] = "399999";
 $quotes[] = "499999";
 $quotes[] = "200000"; 
 $quotes[] = "799999"; 
 $quotes[] = "300000"; 
 $quotes[] = "500000"; 
 $quotes[] = "100000"; 
 $number = mt_rand(0, count($quotes) - 1); 
 $mis = $quotes[$number]; 
 
 $quotes = array(); 
 $quotes[] = "win"; 
 $quotes[] = "lose"; 
 $number = mt_rand(0, count($quotes) - 1); 
 $bots = $quotes[$number]; 
 if($bots == "lose") 
 { 
  $suma = 0; 
 } 
 $ls = rand(1000, 5000); 
 $ras = $mis + $ls; 
 $randas = rand($ras, 999999); 
 
 
 $list = file("bots.txt"); //достаём контент файла и помещаем его в массив. 
 $rand = rand(1, count($list)); //берём любое число от 1 до размера массива. count($list) - узнаём размер массива. 
 $login = $list[$rand]; //выводим строчку $rand в массиве $list 

$insert_sql1 = "INSERT INTO `demo_games` (`login`,`user_id`, `chislo`, `cel`, `suma`, `shans`, `win_summa`, `type`, `data`, `saltall`, `hash`) 
VALUES ('{$login}','{$id}', '{$randas}', '{$mis}-999999', '{$betSize}', '{$betPercent}', '{$suma}', '{$bots}', '{$dete}', '{$saltall}', '{$sha}')"; 
mysql_query($insert_sql1);
$login = ucfirst($row['login']);
?>