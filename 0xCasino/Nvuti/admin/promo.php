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

$sql_select = "SELECT * FROM demo_promo";
$result = mysql_query($sql_select);
include("header.php");
?>

<!-- Modal -->
<table class="table table-dark table-striped">
<thead>
<tr>
    <td>ID</td>
    <td>Название</td>
    <td>Количество (Использовано)</td>
    <td>Количество (Всего)</td>
    <td>Сумма</td>
</tr>
</thead>
<tbody>
    
<?php while($row = mysql_fetch_array($result)): ?>
  <tr>
      <td><? echo $row['id'] ?></td>
      <td><? echo $row['promo'] ?></td>
      <td><? echo $row['active'] ?></td>
      <td><? echo $row['activelimit'] ?></td>
      <td><? echo $row['summa'] ?></td>
	  <td>
        <td>
        <form action="promoHandler.php" method="POST">
            <input type="hidden" name="id" value="<? echo $row['id'] ?> ">
            <input type="hidden" name="type" value="delete">
            <button type="submit" class="btn btn-danger">X</button>
        </form>      
      </td>
</td>		
  </tr>  
<? endwhile ?>
</tbody>
Чтобы добавить промокод на страницу с промокодами, уберите самый первый промокод, тем самым появится ваш 2 промокод
</table>
<script src="http://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js"></script>
</body>
        <div class="modal-body">
        <form action="promoHandler.php" method="POST" >
            <div class="form-group">
                <label for="promo">Название</label>
                <input type="text" name="promo" class="form-control" required>
            </div>
            <div class="form-group">
                <label for="promo">Количество</label>
                <input type="integer" name="activelimit" class="form-control" required>
            </div>
            <div class="form-group">
                <label for="promo">Сумма</label>
                <input type="integer" name="summa" class="form-control" required>
            </div>
            <input type="hidden" name="type" value="add">
            <button type="submit" class="btn btn-primary">Добавить</button>
         </form>
      </div>
<? } ?>