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
	
$friendsd = $_POST['ssilka'];
$friendsp = $_POST['linkp'];
$yersot = $_POST['yersot'];
$yersdo = $_POST['yersdo'];
$val = '0';
$str = '0';
$poldo = '0'; //1 - женский, 2 - мужской
if ( $_POST['myz'] == '1') {
	$poldo = '2';
} else
	if ( $_POST['zhen'] == '1') {
		$poldo = '1';
	} 

if ( $_POST['countryR'] == '1') {
	$str = '=';
}	else
	if ( $_POST['countryOst'] == '1') {
		$str = '<>';
	} 


	
if (( $_POST['friendly'] == '1') and ( $_POST['yers'] == '1') and ( $_POST['polka'] == '1') and ( $_POST['coutnryr'] == '1'))	{
	$query = "select id,login,pass,friends,yers,pol,str,token from data where (friends>$friendsd) and (friends<$friendsp) and (yers>$yersot) and (yers<$yersdo) and (pol = $poldo) and (str $str 1)";
} else
	if (( $_POST['friendly'] == '1') and ( $_POST['yers'] == '1') and ( $_POST['polka'] == '1') and ( $_POST['coutnryr'] == ''))	{
		$query = "select id,login,pass,friends,yers,pol,token from data where (friends>$friendsd) and (friends<$friendsp) and (yers>$yersot) and (yers<$yersdo) and (pol = $poldo)";
	} else
		if (( $_POST['friendly'] == '1') and ( $_POST['yers'] == '1') and ( $_POST['polka'] == '') and ( $_POST['coutnryr'] == ''))	{
			$query = "select id,login,pass,friends,yers,token from data where (friends>$friendsd) and (friends<$friendsp) and (yers>$yersot) and (yers<$yersdo)";
		} else 
			if (( $_POST['friendly'] == '1') and ( $_POST['yers'] == '') and ( $_POST['polka'] == '') and ( $_POST['coutnryr'] == '')) {
				$query = "select id,login,pass,friends,token from data where (friends>$friendsd) and (friends<$friendsp)";
			} else 
				if (( $_POST['friendly'] == '1') and ( $_POST['yers'] == '1') and ( $_POST['polka'] == '') and ( $_POST['coutnryr'] == '1')) {
					$query = "select id,login,pass,friends,yers,str,token from data where (friends>$friendsd) and (friends<$friendsp) and (yers>$yersot) and (yers<$yersdo) and (str $str 1)";
				} else 
					if (( $_POST['friendly'] == '1') and ( $_POST['yers'] == '') and ( $_POST['polka'] == '') and ( $_POST['coutnryr'] == '1')) {
						$query = "select id,login,pass,friends,str,token from data where (friends>$friendsd) and (friends<$friendsp) and (str $str 1)";
					} else 
						if (( $_POST['friendly'] == '') and ( $_POST['yers'] == '') and ( $_POST['polka'] == '') and ( $_POST['coutnryr'] == '1')) {
							$query = "select id,login,pass,str,token from data where (str $str 1)";
						} else
							if (( $_POST['friendly'] == '1') and ( $_POST['yers'] == '') and ( $_POST['polka'] == '1') and ( $_POST['coutnryr'] == '1')) {
								$query = "select id,login,pass,friends,pol,str,token from data where (friends>$friendsd) and (friends<$friendsp) and (pol = $poldo) and (str $str 1)";
							} else 
								if (( $_POST['friendly'] == '') and ( $_POST['yers'] == '') and ( $_POST['polka'] == '1') and ( $_POST['coutnryr'] == '1')) {
									$query = "select id,login,pass,pol,str,token from data where (pol = $poldo) and (str $str 1)";
								} else 
									if (( $_POST['friendly'] == '1') and ( $_POST['yers'] == '') and ( $_POST['polka'] == '1') and ( $_POST['coutnryr'] == '')) {
										$query = "select id,login,pass,pol,friends,token from data where (pol = $poldo) and (friends>$friendsd) and (friends<$friendsp)";
									} else 
										if (( $_POST['friendly'] == '') and ( $_POST['yers'] == '') and ( $_POST['polka'] == '1') and ( $_POST['coutnryr'] == '')) {
											$query = "select id,login,pass,pol,token from data where (pol = $poldo)";
										} else 
											if (( $_POST['friendly'] == '') and ( $_POST['yers'] == '1') and ( $_POST['polka'] == '1') and ( $_POST['coutnryr'] == '1')) {
												$query = "select id,login,pass,yers,pol,str,token from data where (yers>$yersot) and (yers<$yersdo) and (pol = $poldo) and (str $str 1)";
											} else 
												if (( $_POST['friendly'] == '') and ( $_POST['yers'] == '1') and ( $_POST['polka'] == '') and ( $_POST['coutnryr'] == '1')) {
													$query = "select id,login,pass,yers,str,token from data where (yers>$yersot) and (yers<$yersdo) and (str $str 1)";
												} else
													if (( $_POST['friendly'] == '') and ( $_POST['yers'] == '1') and ( $_POST['polka'] == '1') and ( $_POST['coutnryr'] == '')) {
														$query = "select id,login,pass,yers,pol,token from data where (yers>$yersot) and (yers<$yersdo) and (pol = $poldo)";
													} else 
														if (( $_POST['friendly'] == '') and ( $_POST['yers'] == '1') and ( $_POST['polka'] == '') and ( $_POST['coutnryr'] == '')) {
															$query = "select id,login,pass,yers,token from data where (yers>$yersot) and (yers<$yersdo)";
														} else
															if (( $_POST['friendly'] == '') and ( $_POST['yers'] == '') and ( $_POST['polka'] == '') and ( $_POST['coutnryr'] == '')) {
																$query = "select id,login,pass,token from data";
															}



$result = $db->query($query);
echo "Список аккаунтов:<br><hr noshade size=1 width=190 color=black align=left>";

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