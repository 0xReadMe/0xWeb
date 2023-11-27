<?php
require_once("../inc/bd.php");
$hash = $_COOKIE['sid'];
$sql_select = "SELECT * FROM demo_users WHERE hash='$hash'";
$result = mysql_query($sql_select);
$row = mysql_fetch_array($result);
if($row['prava'] != 1)
{
echo "<script type='text/javascript'>  window.location='/'; </script>";
}
else{
	$sql_select = "SELECT MAX(id) FROM demo_games";
$result = mysql_query($sql_select);
$row = mysql_fetch_array($result);

$games = $row['MAX(id)'];

	$sql_select = "SELECT SUM(balance) FROM demo_users";
$result = mysql_query($sql_select);
$row = mysql_fetch_array($result);
$summoney = $row['SUM(balance)'];
$summoney = round($summoney,2);

	$sql_select = "SELECT SUM(suma) FROM demo_payout";
$result = mysql_query($sql_select);
$row = mysql_fetch_array($result);

$sumpayout = $row['SUM(suma)'];
$sumpayout = round($sumpayout,2);

	$sql_select = "SELECT SUM(suma) FROM demo_payments";
$result = mysql_query($sql_select);
$row = mysql_fetch_array($result);

$sumpayments = $row['SUM(suma)'];
$sumpayments = round($sumpayments,2);
	$sql_select = "SELECT COUNT(*) FROM demo_users WHERE balance > 10";
$result = mysql_query($sql_select);
$row = mysql_fetch_array($result);

$cont = $row['COUNT(*)'];
include("header.php");
}
?>
<style>
    .error{
        color: red;
    }
    .success{
        color: green;
    }
</style>
<div class="container mt-5">

<table class="tbl" align="center" style="border: 1px solid #ccc; border-radius: 4px; padding: 10px; background-color: #fff;" width="875" cellpadding="5" cellspacing="0"><tbody><tr>
<td style="border-bottom: 1px solid #cccccc; border-left: 1px solid #cccccc; border-top: 1px solid #cccccc;" bgcolor="#ffffff" class="sm2" align="center">Параметр</td>
<td style="border-bottom: 1px solid #cccccc; border-left: 1px solid #cccccc; border-top: 1px solid #cccccc; border-right: 1px solid #cccccc;" bgcolor="#ffffff" class="sm2" align="center">Значение</td></tr>
<tr>
</tr>
<tr>
<td style="border-bottom: 1px solid #cccccc; border-left: 1px solid #cccccc;" align="center" width="300">Кол-во игр</td>
<td style="border-bottom: 1px solid #cccccc; border-left: 1px solid #cccccc; border-right: 1px solid #cccccc;" align="center" width="300"><?php echo $games; ?></td>
</tr>
<tr>
<td style="border-bottom: 1px solid #cccccc; border-left: 1px solid #cccccc;" align="center" width="300">Денег на счетах</td>
<td style="border-bottom: 1px solid #cccccc; border-left: 1px solid #cccccc; border-right: 1px solid #cccccc;" align="center" width="300"><?php echo $summoney; ?> N</td>
</tr>
<tr>
<td style="border-bottom: 1px solid #cccccc; border-left: 1px solid #cccccc;" align="center" width="300">Пользователей с балансом &gt;=10 MN</td>
<td style="border-bottom: 1px solid #cccccc; border-left: 1px solid #cccccc; border-right: 1px solid #cccccc;" align="center" width="300"><?php echo $cont; ?></td>
</tr>
<tr>
<td style="border-bottom: 1px solid #cccccc; border-left: 1px solid #cccccc;" align="center" width="300">Выплат на сумму</td>
<td style="border-bottom: 1px solid #cccccc; border-left: 1px solid #cccccc; border-right: 1px solid #cccccc;" align="center" width="300"><?php echo $sumpayout; ?> N</td>
</tr>
<tr>
<td style="border-bottom: 1px solid #cccccc; border-left: 1px solid #cccccc;" align="center" width="300">Пополнений на сумму</td>
<td style="border-bottom: 1px solid #cccccc; border-left: 1px solid #cccccc; border-right: 1px solid #cccccc;" align="center" width="300"><?php echo $sumpayments; ?> N</td>
</tr>
</tbody></table>
</div>