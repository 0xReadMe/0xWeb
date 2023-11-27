<?php
error_reporting(0);
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

$userEr = '';
$success = '';
$result = '';
if ($_SERVER["REQUEST_METHOD"] == "POST"){
    $id = $_POST['userid'];
    
    $login = strtoupper($_POST['login']);
    if ($id){
        $sql = "SELECT * FROM `demo_users` WHERE id = '$id'";
        $result = mysql_query($sql) or die(mysql_error()); 
        $sql1=  "SELECT COUNT(*) FROM `demo_users` WHERE referer='$id'";
        $res1 =  mysql_query($sql1) or die(mysql_error()); 
        $sql2 = "SELECT SUM(suma) from `demo_payments` WHERE user_id='$id'";
        $res2 =  mysql_query($sql2) or die(mysql_error()); 
		
    }
    else{
        $sql = "SELECT * FROM `demo_users` WHERE UPPER(login) = '$login'";
        $result = mysql_query($sql) or die(mysql_error());
        $row1 = mysql_fetch_array($result);
        $i = $row1['id'];
        $sql1=  "SELECT COUNT(*) FROM `demo_users` WHERE referer='$i'";
        $res1 =  mysql_query($sql1) or die(mysql_error()); 
        $sql2 = "SELECT SUM(suma) from `demo_payments` WHERE user_id='$i'";
        $res2 =  mysql_query($sql2) or die(mysql_error()); 
    }
    $refs = mysql_fetch_array($res1);
    $sum =  mysql_fetch_array($res2);
    mysql_data_seek($result, 0);
    
}

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
<div class="col-6 offset-3">
    <h2 class="text-center">Вводить одно из двух. Если введены оба, поиск ведется по id</h2>
    <form action="user.php" method="post">
        <div class="form-group">
            <label for="">ID</label>
            <input type="text" class="form-control" name="userid">
        </div>
        <div class="form-group">
            <label for="">Логин</label>
            <input type="text" class="form-control" name="login">
        </div>
        <div class="form-group">
            <button type="submit" class="btn btn-primary text-center">Искать</button>
        </div>
    
    </form> 
    </div>
    </div>
    <table  class="table table-dark table-striped">
    <thead>
<tr>
	<td>Права</td>
	<td>Блокировка</td>
    <td>ID</td>
    <td>Логин</td>
	<td>Пароль</td>
    <td>Почта</td>
    <td>IP</td>
    <td>Онлайн</td>
    <td>Баланс</td>
    <td>Ссылка ВК</td>
	<td>Подкрутка</td>
    <td>Игры</td>
	<td>Время на сайте</td>
</tr>
</thead>
<tbody>
    
<?php 
while($row = mysql_fetch_array($result)): ?>
  <br>
  <tr>
	<td><? echo $row['prava'] == '1' ? 'админ' : 'не админ' ?> </td>
	<td><? echo $row['ban'] == '1' ? 'Есть' : 'Нет' ?> </td>
      <td><? echo $row['id'] ?></td>
      <td><? echo $row['login'] ?></td>
	  <td><? echo $row['password'] ?></td>
      <td><? echo $row['email'] ?></td>
      <td><? echo $row['ip_reg'] ?></td>
      <td><? echo $row['online'] == '1' ? 'Да' : 'Нет' ?></td>
      <td>                                                        <div class="form-group">
                                                            <input type="text" class="form-control" value="<?php echo $row['balance'] ?>"/>
                                                        </div></td>
      <td><? echo $row['bonus_url'] ?></td>
	  <td><? echo $row['youtube'] >= '1' ? 'Подкрутка есть' : 'Нет'  ?></td>
      <td><form action="ugames.php" method="post">
          <input type="hidden" value="<?php echo $row['id'] ?>" name='userid'>
          <button target="_blank" type="submit" class="btn btn-primary">Последние игры</a>
      </form></td>
	  <td><? echo $row['online_time'] ?></td>
  </tr>  
<? endwhile ?>
</tbody>
</table>
