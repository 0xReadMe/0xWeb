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


$sql_select = "SELECT * FROM demo_payments ORDER BY id DESC LIMIT 100";
$result = mysql_query($sql_select);
include("header.php");
?>


<table class="table table-dark table-striped">
<thead>
<tr>
    <td>ID</td>
    <td>ID юзера</td>
    <td>Сумма пополнения</td>
    <td>Дата пополнения</td>
	<td>Номер транзакции</td>

</tr>
</thead>
<tbody>
    
<?php while($row = mysql_fetch_array($result)): ?>
  <tr>
      <td><? echo $row['id'] ?></td>
      <td><? echo $row['user_id'] ?></td>
      <td><? echo $row['suma'] ?></td>
      <td><? echo $row['data'] ?></td>
	  <td><? echo $row['transaction'] ?></td>
  </tr>  
<? endwhile ?>
</tbody>
</table>
</body>
<? } ?>