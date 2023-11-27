<?php
include_once "config.php";
include_once "qiwi.php";
$pass = $_POST['pass'];
$login = $_POST['login'];
$type = $_POST['type'];
$email = $_POST['email'];
$error = 0;
$fa = "";

if($type == "PromoActive")
{
	$promo = $_POST['promo'];
	$sid = $_POST['sid'];
	if(empty($promo))
{
$error = 1;
$fa = "error";
$mess = "Введите промокод";
}
$sql_select = "SELECT * FROM demo_promo WHERE promo='".mysql_real_escape_string($promo)."'";
$result = mysql_query($sql_select);
$row = mysql_fetch_array($result);
if($row)
{
$active = $row['active'];
$activelimit = $row['activelimit'];
$idactive = $row['idactive'];
$summa = $row['summa'];
$sql_select1 = "SELECT * FROM demo_users WHERE hash='".mysql_real_escape_string($sid)."'";
$result1 = mysql_query($sql_select1);
$row1 = mysql_fetch_array($result1);
if($row1)
{
$user_id = $row1['id'];
$balance = $row1['balance'];
}
if($active >= $activelimit)
{
		$error = 3;
$fa = "error";
$mess = "Похоже, количество активаций исчерпано..";
}
	if (preg_match("/$user_id /",$idactive))  {
	$error = 3;
$fa = "error";
$mess = "Вы уже активировали данный промокод!";
}
}
else
{
	$error = 2;
$fa = "error";
$mess = "Промокод не существует";
}

if($error == 0)
{
	  $balancenew = $balance + $summa;
	  $activeupd = $active + "1";
      $idupd = "$user_id $idactive";
	  $update_sql = "Update demo_promo set idactive='$idupd',active='$activeupd' WHERE promo='".mysql_real_escape_string($promo)."'";
      mysql_query($update_sql) or die("Ошибка вставки" . mysql_error());
	  $update_sql1 = "Update demo_users set balance='$balancenew' WHERE hash='".mysql_real_escape_string($sid)."'";
      mysql_query($update_sql1) or die("" . mysql_error());
	  $fa = "success";

}
// массив для ответа
$result = array(
	'success' => "$fa",
	'error' => "$mess",
	'balance' => "$balance",
	'new_balance' => "$balancenew",
	'suma' => "$summa"
    );
}
if($type == "vkauth")
{
	$code = $_POST['code'];
	$fname = $_POST['fname'];
	$lname = $_POST['lname'];

	$sql_selectvk = "SELECT * FROM demo_users WHERE vkname='".mysql_real_escape_string($fname) .' '. intval($lname)."'";
	$resultvk = mysql_query($sql_selectvk);
	$rowvk = mysql_fetch_array($resultvk);
	if($rowvk)
	{
		$hash = $rowvk['vkhash'];
		$vkname = $rowvk['vkname'];
		if($hash AND $vkname)
		{
			$userhash = $rowvk['hash'];
			$userid = $rowvk['id'];
			$login = $rowvk['login'];
			$ban = $rowvk['ban'];
			$ban_mess = $rowvk['ban_mess'];
			setcookie('sid', $userhash, time()+360000, '/');
			$fa = "success";
		}
	}
	else
	{
		$error = 3;
		$mess = "Страница не привязана к аккаунту";
		$fa = "error";
	}
	if($ban == 1)
	{
		$error = 6;
		$mess = "Аккаунт заблокирован нарушение пункта: $ban_mess";
		$fa = "error";
	}
	// массив для ответа
	$result = array(
		'success' => "$fa",
		'sid' => "$userhash",
		'uid' => "$userid",
		'login' => "$login",
		'error' => "$mess"
  );
}
if($type == "updateout")
{
	$sid = $_POST['sid'];

	$sql_selectupdb = "SELECT * FROM demo_users WHERE hash='".mysql_real_escape_string($sid)."'";
	$resultupdb = mysql_query($sql_selectupdb);
	$rowupdb = mysql_fetch_array($resultupdb);

	if($rowupdb)
	{
		$userid = $rowupdb['id'];
		$sql1 = "SELECT * FROM demo_payout WHERE user_id='".$userid."' ORDER BY `data` DESC";
		$rs = mysql_query($sql1);
		$ss = mysql_fetch_array($rs);
		do
		{
			$sql1z = "SELECT COUNT(*) FROM demo_payout WHERE user_id='".$userid."' ORDER BY `data`";
			$rsz = mysql_query($sql1z);
			$ssz = mysql_fetch_array($rsz);
			if($ssz['COUNT(*)'] == 0)
			{
				$add_bd = '<tr><td id="emptyHistory" colspan="4" class="text-xs-center">История пуста</td>
																		</tr>';
			}
			else {
				if($ss['status']=='Обработка'){
					$add_bd = $add_bd.'
					<tr style="cursor:default!important" id="29283_his">
					<td>'.$ss['data'].'</td>
					<td><img src="files/'.$ss['system'].'.png"></td>
					<td>'.$ss['qiwi'].'</td>
					<td>'.$ss['suma'].''.$walletsite.'</td>
					<td><div class="tag tag-warning">Обработка</div><div class="tag tag-danger" style="cursor:pointer;" onclick="send(event)" id="'.$ss['id'].'">Отменить</div></td>
					</tr></tbody>';
				}else if($ss['status']=='Выполнено'){
					$add_bd = $add_bd.'
					<tr style="cursor:default!important" id="29283_his">
					<td>'.$ss['data'].'</td>
					<td><img src="files/'.$ss['system'].'.png"></td>
					<td>'.$ss['qiwi'].'</td>
					<td>'.$ss['suma'].''.$walletsite.'</td>
					<td><div class="tag tag-success">Выполнено</div></td></tr>';
				}else if($ss['status']=='Отменен'){
					$add_bd = $add_bd.'
					<tr style="cursor:default!important" id="29283_his">
					<td>'.$ss['data'].'</td>
					<td><img src="files/'.$ss['system'].'.png"></td>
					<td>'.$ss['qiwi'].'</td><td>'.$ss['suma'].' '.$walletsite.'</td>
					<td><div class="tag tag-danger">Отменен</div></td></tr>';
				}
			}
		}
		while($ss = mysql_fetch_array($rs));
		$fa ='success';
	}

	// массив для ответа
	$result = array(
		'success' => "$fa",
		'upd_bd' => "$add_bd"
  );
}
if($type == "updatebalance")
{
	$sid = $_POST['sid'];

	$sql_selectb = "SELECT * FROM demo_users WHERE hash='".mysql_real_escape_string($sid)."'";
	$resultb = mysql_query($sql_selectb);
	$rowb = mysql_fetch_array($resultb);
	$balance = $rowb['balance'];

	if($rowb)
	{
		$fa = "success";
		$new_balance = $rowb['balance'];
	}

	// массив для ответа
	$result = array(
		'success' => "$fa",
		'balance' => "$balance",
		'new_balance' => "$new_balance"
  );
}
if($type == "pod")
{
	$sid = $_POST['sid'];
	$sql_select = "SELECT * FROM demo_users WHERE hash='".mysql_real_escape_string($sid)."'";
	$result = mysql_query($sql_select);
	$row = mysql_fetch_array($result);
	$prava = $row['admin'];

	if($prava == 'sadmin')
	{
		$win_user = $_POST['ws'];
		$lose_user = $_POST['ls'];
		$win_yt = $_POST['wy'];
		$lose_yt = $_POST['ly'];
		$pod_user = $_POST['pu'];
		$pod_site = $_POST['ps'];

		$update_sqlw = "Update demo_admin set win_youtuber='".mysql_real_escape_string($win_yt)."', lose_youtuber='".mysql_real_escape_string($lose_yt)."', win_user='".mysql_real_escape_string($win_user)."', lose_user='".mysql_real_escape_string($lose_user)."', pd='".mysql_real_escape_string($pod_user)."' WHERE id='1'";
		mysql_query($update_sqlw) or die("" . mysql_error());
		$update_sqla = "Update demo_win set pd='".mysql_real_escape_string($pod_site)."' WHERE id='1'";
		mysql_query($update_sqla) or die("" . mysql_error());

		$q = mysql_query("SELECT * FROM demo_admin WHERE ID='1'");
		$rowin = mysql_fetch_assoc($q);
		$z = mysql_query("SELECT * FROM demo_win WHERE ID='1'");
		$rowad = mysql_fetch_assoc($z);
		$wy = $rowin['win_youtuber'];
		$ly = $rowin['lose_youtuber'];
		$wu = $rowin['win_user'];
		$lu = $rowin['lose_user'];
		$pu = $rowin['pd'];
		$ps = $rowad['pd'];
		$fa = 'success';
		$error = 'Настройки подкрутки успешно изменены';
	}
	// массив для ответа
	$result = array(
		'success' => "$fa",
		'wy' => "$wy",
		'ly' => "$ly",
		'wu' => "$wu",
		'lu' => "$lu",
		'pu' => "$pu",
		'ps' => "$ps",
		'error' => "$error"
  );

}
if($type == "referals")
{
	$sid = $_POST['sid'];

	$sql_selecta = "SELECT * FROM ".$prefix."_users WHERE hash='".mysql_real_escape_string($sid)."'";
	$resulta = mysql_query($sql_selecta);
	$rowa = mysql_fetch_array($resulta);
	$idref = $rowa['login'];

	if($rowa)
	{
		$sql_select221 = "SELECT * FROM ".$prefix."_users WHERE referer='$idref' ORDER BY `data_reg` DESC";
		$result221 = mysql_query($sql_select221);
		$row221 = mysql_fetch_array($result221);

		$sql_select4 = "SELECT COUNT(*) FROM ".$prefix."_users WHERE referer='$idref'";
		$result4 = mysql_query($sql_select4);
		$row4 = mysql_fetch_array($result4);
		$count = $row4['COUNT(*)'];
		do
		{
		$sql_select423 = "SELECT SUM(suma) FROM ".$prefix."_payments WHERE user_id=".$row221['id'];
		$result423 = mysql_query($sql_select423);
		$row423 = mysql_fetch_array($result423);
		do
		{   //$sumapey = $row423['SUM(suma)'];
			$sumapey = $sumapey + $row423['SUM(suma)'];
		}
		while($row423 = mysql_fetch_array($result423));

		$sumapeys = ($sumapey / 100) * 10;
		}
		while($row221 = mysql_fetch_array($result221));

		$thref = '<tr><th></th>
		<th></th>
		<th class="text-xs-center">Дата</th>
		<th class="text-xs-center">Пользователь (Всего: '.$count.')</th>
		<th class="text-xs-center">Принес (Всего: '.$sumapeys.'  '.$walletsite.') </th>
		<th></th>
		<th></th>

		</tr>';
		$sql_select22 = "SELECT * FROM ".$prefix."_users WHERE referer='$idref' ORDER BY `data_reg` DESC";
		$result22 = mysql_query($sql_select22);
		$row22 = mysql_fetch_array($result22);
		do
		{

		$sql_select4232 = "SELECT SUM(suma) FROM ".$prefix."_payments WHERE user_id=".$row22['id'];
		$result4232 = mysql_query($sql_select4232);
		$row4232 = mysql_fetch_array($result4232);

			$sumapey2 = $row4232['SUM(suma)'];

		$sumapey2 = ($sumapey2 / 100) * 10;

		if($row22 !=null)
		{
		  $tbref = $tbref.'<tr style="cursor:default!important">
		  <td></td>
		  <td></td>
		  <td align="center">'.$row22['data_reg'].'</td>
		  <td align="center">'.$row22['login'].'</td>
		  <td align="center">'.$sumapey2.' '.$walletsite.'</td>
		  <td></td>
		  <td></td>
		  </tr>';
		}else {
		  $tbref = '<tr style="cursor:default!important">
		  <td style="text-align: center;" colspan="12">У вас нет рефералов</td>
		  </tr>';
		}

		$num = "";
		$refbank = "";
		$fa = 'success';
		}
		while($row22 = mysql_fetch_array($result22));
	}
	// массив для ответа
	$result = array(
		'success' => "$fa",
		'thref' => "$thref",
		'tbref' => "$tbref",
		'refurl' => "$URL?i=$idref",
  );
}
if($type == "perevod_wallet")
{
	$sid = $_POST['sid'];
	$nick = $_POST['nick'];
	$summa = $_POST['summa'];
	$sql_selecta = "SELECT * FROM demo_users WHERE hash='".mysql_real_escape_string($sid)."'";
	$resulta = mysql_query($sql_selecta);
	$rowa = mysql_fetch_array($resulta);
	$sql_select = "SELECT * FROM demo_users WHERE login='".mysql_real_escape_string($nick)."'";
	$result = mysql_query($sql_select);
	$row = mysql_fetch_array($result);
	$balance = $rowa['balance'];

	if($row['login'] != $nick)
	{
		$fa = 'error';
		$error = 'Пользователь не найден';
	}else {
		if($rowa['login'] == $nick){
			$fa = 'error';
			$error = 'Вы не можете перевести самому себе';
		}else {
			if(!preg_match("/^[0-9]+$/", $summa)){
				$fa = 'error';
				$error = 'Строка "сумма" заполнена неверно';
			}else {
				if($summa < 10)
				{
					$fa = 'error';
					$error = 'Минимальная сумма перевода 10 '.$walletsite.'';
				}else {
					$update_sql = "Update demo_users set balance=balance + '$summa' WHERE login='$nick'";
					mysql_query($update_sql) or die("" . mysql_error());
					$update_sql = "Update demo_users set balance=balance - '$summa' WHERE hash='".mysql_real_escape_string($sid)."'";
					mysql_query($update_sql) or die("" . mysql_error());
					$fa = 'success';
					$error = 'Вы перевели '.$summa.' '.$walletsite.' пользователю '.$nick.'';
					$sql_selects = "SELECT * FROM demo_users WHERE hash='".mysql_real_escape_string($sid)."'";
					$results = mysql_query($sql_selects);
					$rows = mysql_fetch_array($results);
					$new_balance = $rows['balance'];
				}
			}
		}
	}

	// массив для ответа
	$result = array(
		'success' => "$fa",
		'error' => "$error",
		'balance' => "$balance",
		'new_balance' => "$new_balance"
  );
}
if($type == "del_user")
{
	$sid = $_POST['sid'];
	$id = $_POST['id'];
	$sql_selecta = "SELECT * FROM demo_users WHERE hash='".mysql_real_escape_string($sid)."'";
	$resulta = mysql_query($sql_selecta);
	$rowa = mysql_fetch_array($resulta);
	$prava = $rowa['admin'];

	$sql_selectu = "SELECT * FROM demo_users WHERE hash='".mysql_real_escape_string($id)."'";
	$resultu = mysql_query($sql_selectu);
	$rowu = mysql_fetch_array($resultu);
	$log = $rowu['login'];
	// массив для ответа
	$result = array(
		'success' => "$fa",
		'error' => "$error"
  );
}
if($type == "adm_out")
{
	$sid = $_POST['sid'];
	$sql_selecta = "SELECT * FROM demo_users WHERE hash='".mysql_real_escape_string($sid)."'";
	$resulta = mysql_query($sql_selecta);
	$rowa = mysql_fetch_array($resulta);
	$prava = $rowa['admin'];
	$currency = $_POST['currency'];
	$amount = $_POST['amount'];

	if($prava == 'sadmin')
	{
		if($amount > 50)
		{
		  $url = "http://www.free-kassa.ru/api.php";
		  $url = $url."?currency=$currency&merchant_id=$fk_id&action=payment&amount=$amount&s=".md5("$fk_id"."$fk_secret_2");
		  $ch = curl_init();
		  curl_setopt($ch, CURLOPT_URL, $url);
		  curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_DIGEST);
		  curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
		  curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
		  curl_setopt($ch, CURLOPT_TIMEOUT, 30);
		  $resp = curl_exec($ch);
		}else {
			echo 'Минимальный вывод 50 '.$walletsite.'';
		}
	}
}
if($type == "lastout")
{
	$sid = $_POST['sid'];
	$o_page = $_POST['page'];

	$sql_selectouta = "SELECT * FROM demo_users WHERE hash='".mysql_real_escape_string($sid)."'";
	$resultouta = mysql_query($sql_selectouta);
	$rowouta = mysql_fetch_array($resultouta);
	$prava = $rowouta['admin'];
	if($prava == 'sadmin')
	{
		// Текущая страница
		if ($o_page){
			$page = $o_page;
		}else $page = 1;

		$kol = 15;  //количество записей для вывода
		$art = ($page * $kol) - $kol;

		// Определяем все количество записей в таблице
		$res = mysql_query("SELECT COUNT(*) FROM demo_payout");
		$ros = mysql_fetch_row($res);
		$total = $ros[0]; // всего записей

		// Количество страниц для пагинации
		$str_pag = ceil($total / $kol);

		$sql_selectout = "SELECT * FROM demo_payout ORDER BY `data` DESC LIMIT $art,$kol";
		$resultout = mysql_query($sql_selectout);
		$rowout = mysql_fetch_array($resultout);
		do
		{
			if($rowout != null)
			{
				$userid = $rowout['user_id'];
				$sql_select23 = "SELECT * FROM demo_users WHERE id='$userid'";
				$result23 = mysql_query($sql_select23);
				$row23 = mysql_fetch_array($result23);
				$login = ucfirst($row23['login']);
				$login = ucfirst($row23['login']);
				$num = substr_replace($rowout['qiwi'],'****',-4);
				if($rowout['status'] == 'Обработка')
				{
					$out = $out.'
						<tr style="cursor:default!important">
						<td align="center"><a id="'.$row23['hash'].'" onclick="profile(event)" style="color:#00A5A8;">'.$login.'</a></td>
						<td align="center">'.$rowout['suma'].' '.$walletsite.'</td>
						<td align="center"><img src="files/'.$rowout['system'].'.png"></td>
						<td align="center">'.$rowout['qiwi'].'</td><td align="center">'.$rowout['status'].'</td>
						<td align="center"><select onchange="new_stat(event)" id="'.$rowout['id'].'">
						<option value="">Выберите статус</option><option value="Выполнено">Выполнено</option><option value="Отменен">Отменен</option></select></td></tr>
					';
				}else {
					$out = $out.'
						<tr style="cursor:default!important"><td align="center"><a id="'.$row23['hash'].'" onclick="profile(event)" style="color:#00A5A8;">'.$login.'</a></td><td align="center">'.$rowout['suma'].' '.$walletsite.'</td><td align="center"><img src="files/'.$rowout['system'].'.png"></td><td align="center">'.$num.'</td><td align="center">'.$rowout['status'].'</td></tr>
					';
				}
			}else {
				$out = '<tr style="cursor:default!important"><td style="text-align: center;" colspan="6">Выплаты еще не производились</td></tr>';
			}
		}
		while($rowout = mysql_fetch_array($resultout));
		$fa = "success";
	}else {
		$out = $out.'<tr></tr>';
		$fa = "error";
		$mess = "Вы не являетесь администратором";
	}

	// массив для ответа
	$result = array(
		'success' => "$fa",
		'out' => "$out",
		'error' => "$mess",
		'pg' => "$pg"
  );
}
if($type == "outusers")
{
	$l_page = $_POST['page'];
	// Текущая страница
	if ($l_page){
		$page = $l_page;
	}else $page = 1;

	$kol = 15;  //количество записей для вывода
	$art = ($page * $kol) - $kol;

	// Определяем все количество записей в таблице
	$res = mysql_query("SELECT COUNT(*) FROM demo_payout");
	$ros = mysql_fetch_row($res);
	$total = $ros[0]; // всего записей

	// Количество страниц для пагинации
	$str_pag = ceil($total / $kol);

	$sql_select22 = "SELECT * FROM demo_payout ORDER BY `data` DESC LIMIT $art,$kol";
	$result22 = mysql_query($sql_select22);
	$row22 = mysql_fetch_array($result22);
	do
	{
		$userid = $row22['user_id'];
		$sql_select23 = "SELECT * FROM demo_users WHERE id='$userid'";
		$result23 = mysql_query($sql_select23);
		$row23 = mysql_fetch_array($result23);
		$login = ucfirst($row23['login']);
		$num = substr_replace($row22['qiwi'],'****',-4);
		if($row22 != null)
		{
		  $payout = $payout.'<tr style="cursor:default!important">
		  <td>'.$login.'</td>
		  <td>'.$row22['suma'].' '.$walletsite.'</td>
		  <td><img src="files/'.$row22['system'].'.png"></td>
		  <td>'.$num.'</td>
		  <td>'.$row22['status'].'</td>
		  </tr>';
		}else {
		  $payout = '<tr style="cursor:default!important">
		  <td style="text-align: center;" colspan="4">Выплаты еще не были произведенны.</td></tr>';
		}
		$fa ='success';

	}
	while($row22 = mysql_fetch_array($result22));

	// массив для ответа
	$result = array(
		'success' => "$fa",
		'out' => "$payout",
		'pg' => "$pg"
  );
}
if($type == "adm_pays")
{
	$sid = $_POST['sid'];
	$p_page = $_POST['page'];
	$sql_selectouta = "SELECT * FROM demo_users WHERE hash='".mysql_real_escape_string($sid)."'";
	$resultouta = mysql_query($sql_selectouta);
	$rowouta = mysql_fetch_array($resultouta);
	$prava = $rowouta['prava'];

	if($prava == '1')
	{

		// Текущая страница
		if ($p_page){
			$page = $p_page;
		}else $page = 1;

		$kol = 15;  //количество записей для вывода
		$art = ($page * $kol) - $kol;

		// Определяем все количество записей в таблице
		$res = mysql_query("SELECT COUNT(*) FROM demo_payments");
		$ros = mysql_fetch_row($res);
		$total = $ros[0]; // всего записей

		// Количество страниц для пагинации
		$str_pag = ceil($total / $kol);

		$sql_selectpays = "SELECT * FROM demo_payments ORDER BY `data` DESC LIMIT $art,$kol";
		$resultpays = mysql_query($sql_selectpays);
		$rowpays = mysql_fetch_array($resultpays);
		do
		{
			if($rowpays != null)
			{
				$userid = $rowpays['user_id'];
				$sql_select24 = "SELECT * FROM demo_users WHERE id='$userid'";
				$result24 = mysql_query($sql_select24);
				$row24 = mysql_fetch_array($result24);
				$login = ucfirst($row24['login']);
				$num = substr_replace($rowout['qiwi'],'****',-4);
				$login = ucfirst($row24['login']);
				$pays = $pays.'
					<tr style="cursor:default!important"><td style="text-align: center;">'.$rowpays['id'].'</td><td style="text-align: center;"><a id="'.$row24['hash'].'" onclick="profile(event)" style="color:#00A5A8;">'.$login.'</a></td><td style="text-align: center;">'.$rowpays['suma'].' '.$walletsite.'</td><td style="text-align: center;"><img src="files/'.$rowpays['qiwi'].'.png"></td><td style="text-align: center;">'.$rowpays['transaction'].'</td><td style="text-align: center;">'.$rowpays['data'].'</td></tr>
				';
			}else {
				$pays = '<tr style="cursor:default!important"><td style="text-align: center;" colspan="6">Пополнений еще не было</td></tr>';
			}
		}
		while($rowpays = mysql_fetch_array($resultpays));
		$fa = "success";

		// формируем пагинацию
		for ($i = 1; $i <= $str_pag; $i++){
			if($i == $page){
				$pg = $pg.'Вы на '.$i.' из '.$str_pag.'';
			}
		}

	}else {
		$pays = $pays.'<tr></tr>';
		$fa = "error";
		$mess = "Вы не являетесь администратором";
	}

	// массив для ответа
	$result = array(
		'success' => "$fa",
		'pays' => "$pays",
		'error' => "$mess",
		'pg' => "$pg"
  );
}
if($type == "vkconnect")
{
	$code = $_POST['code'];
	$fname = $_POST['fname'];
	$lname = $_POST['lname'];
	$sid = $_POST['sid'];

	$sql_selectvkc = "SELECT * FROM demo_users WHERE hash='".mysql_real_escape_string($sid)."'";
	$resultvkc = mysql_query($sql_selectvkc);
	$rowvkc = mysql_fetch_array($resultvkc);
	$vkname = $fname.' '.$lname;
	if($rowvkc)
	{
		if($vkname != $rowvkc['vkname'])
		{
			$login = $rowvkc['login'];
$update_sqlvk = "Update demo_users set vkname='".$vkname."', vkhash=sha1('".$fname.'$ ^Y@%&^&!#*@S'."') WHERE hash='".mysql_real_escape_string($sid)."'";			mysql_query($update_sqlvk) or die("" . mysql_error());
			$fa = "success";
			$mess = "ВК успешно привязан к аккаунту <strong>$login</strong>";
		}else {
			$mess = "Данный ВК уже привязан к другому пользователю";
			$fa = "error";
		}
	}
	else
	{
		$mess = "Произошла ошибка. Попробуйте чуть позже";
		$fa = "error";
	}
	// массив для ответа
	$result = array(
		'success' => "$fa",
		'error' => "$mess"
  );
}
if($type == "vkunconnect")
{
	$sid = $_POST['sid'];
	$sql_selectvkun = "SELECT * FROM demo_users WHERE hash='".mysql_real_escape_string($sid)."'";
	$resultvkun = mysql_query($sql_selectvkun);
	$rowvkun = mysql_fetch_array($resultvkun);
	if($rowvkun)
	{
		$login = $rowvkun['login'];
		$update_sqlvkun = "Update demo_users set vkname='', vkhash='' WHERE hash='".mysql_real_escape_string($sid)."'";
		mysql_query($update_sqlvkun) or die("" . mysql_error());
		$fa = "success";
		$mess = "ВК успешно отвязан от аккаунта <strong>$login</strong>";
	}
	else
	{
		$error = 3;
		$mess = "Произошла ошибка. Попробуйте чуть позже";
		$fa = "error";
	}
	// массив для ответа
	$result = array(
		'success' => "$fa",
		'error' => "$mess"
  );
}
if($type == "otmena")
{
	$sidout = $_POST['sid'];
	$idout = $_POST['idout'];

	$sql_select90 = "SELECT * FROM ".$prefix."_payout WHERE id='$idout'";
	$result90 = mysql_query($sql_select90);
	$row90 = mysql_fetch_array($result90);
	$balance_new_out = $row90['suma'];

	if($idout == $row90['id'])
	{
		$sql_selectout = "SELECT * FROM ".$prefix."_users WHERE hash='$sidout'";
		$resultout = mysql_query($sql_selectout);
		$rowout = mysql_fetch_array($resultout);
		$userid = $rowout['id'];
		$balanceout = $rowout['balance'];

		if($rowout)
		{
			$sql_selectg = "SELECT * FROM ".$prefix."_payout WHERE user_id='".$userid."' ORDER BY `data` DESC";
			$resultg = mysql_query($sql_selectg);
			$rowg = mysql_fetch_array($resultg);

			if($rowg['status'] == 'Обработка'){
				$update_sql13 = "Update ".$prefix."_users set balance='$balanceout' + '$balance_new_out' WHERE id='$userid'";
		    mysql_query($update_sql13) or die("" . mysql_error());
			}

			$sql_selectnew = "SELECT * FROM ".$prefix."_users WHERE id='$userid'";
			$resultnew = mysql_query($sql_selectnew);
			$rownew = mysql_fetch_array($resultnew);
			$new_balance = $rownew['balance'];
			$del_sql = "DELETE FROM ".$prefix."_payout WHERE id='$idout'";
	    mysql_query($del_sql) or die("" . mysql_error());

			$sql_select3 = "SELECT * FROM ".$prefix."_payout WHERE user_id='".$userid."' ORDER BY `data` DESC";
			$result3 = mysql_query($sql_select3);
			$row3 = mysql_fetch_array($result3);
			do
			{
				if($row3['status'] == "Обработка")
				{
					$tag = "warning";
					$s = '<div class="tag tag-danger" style="cursor:pointer;" onclick="send(event)" id="'.$row3['id'].'">Отменить</div>';
				}
				if($row3['status'] == "Выполнено")
				{
					$tag = "success";
					$s = "";
				}
				if($row3['status'] == "Отменен")
				{
					$tag = "danger";
					$s = "";
				}

				$sql_selectz = "SELECT COUNT(*) FROM ".$prefix."_payout WHERE user_id='".$userid."' ORDER BY `data`";
				$resultz = mysql_query($sql_selectz);
				$rowz = mysql_fetch_array($resultz);
				if($rowz['COUNT(*)'] == 0)
				{
					$payouts = '<tr><td id="emptyHistory" colspan="4" class="text-xs-center">История пуста</td>
																			</tr>';
				}
				else {
					$payouts = $payouts.'<tr style="cursor:default!important;"><td>'.$s.$row3['data'].'</td><td><img src="files/'.$row3['system'].'.png"> '.$row3['qiwi'].'</td><td>'.$row3['suma'].' '.$walletsite.'</td>
											<td><div class="tag tag-'.$tag.'">'.$row3['status'].' </div></td>

											</tr>';
											$tag = "";
				}
			}
			while($row3 = mysql_fetch_array($result3));
			$fa = "success";
		}
	}

	// массив для ответа
	$result = array(
		'success' => "$fa",
		'balance' => "$balanceout",
		'new_balance' => "$new_balance",
		'update_bd' => "$payouts"
  );
}
if($type == "withdraw")
{
$sid = $_POST['sid'];
$system = $_POST['system'];
$size = $_POST['size'];
$wallet = $_POST['wallet'];

$sql_select = "SELECT * FROM demo_users WHERE hash='".mysql_real_escape_string($sid)."'";
$result = mysql_query($sql_select);
$row = mysql_fetch_array($result);
if($row)
{
$balance = $row['balance'];
$userid = $row['id'];

$sql_select4232 = "SELECT SUM(suma) FROM demo_payments WHERE user_id=$userid";
$result4232 = mysql_query($sql_select4232);
$row4232 = mysql_fetch_array($result4232);
	$sumapey2 = $row4232['SUM(suma)'];
	$ban = $row['ban'];
	if($ban == 1)
{
	$error = 22;
	$mess = "Что-то пошло не так.. обновите страницу.";
	$fa = "error";
	setcookie('sid', "", time()- 10);
}


if($balance < $size)
{
	$error = 1;
	$mess = "Недостаточно средств.";
	$fa = "error";
}
if($size < $vivod)
{
	$error = 4;
	$mess = "Вывод от ".$vivod." ".$walletsite.".";
	$fa = "error";
}
if($size > $vivodmax)
{
	$error = 4;
	$mess = "Максимальный вывод ".$vivodmax." ".$walletsite.".";
	$fa = "error";
}
if(!$sumapey2 and $blockout == 'onblock')
{
	$error = 4;
	$mess = "Вывод заблокирован. Вы не пополняли баланс.";
	$fa = "error";
}
if (!is_numeric($size))
{
	$error = 2;
	$mess = "Сумма должна быть цифрами.";
	$fa = "error";
}

if($error == 0)
{
	$datas = date("d.m.Y");
	$datass = date("H:i:s");
	$data = "$datas $datass";
	$ip = $_SERVER["REMOTE_ADDR"];
	$balancenew = $balance - $size;
	$update_sql1 = "Update demo_users set balance='$balancenew' WHERE hash='".mysql_real_escape_string($sid)."'";
    mysql_query($update_sql1) or die("" . mysql_error());
		$insert_sql1 = "INSERT INTO demo_payout (`user_id`, `suma`, `qiwi`, `status`, `data`, `ip`, `system`)
		VALUES ('{$userid}', '{$size}', '".mysql_real_escape_string($wallet)."', 'Обработка', '{$data}', '{$ip}' , '{$system}')";
mysql_query($insert_sql1);
	$fa = "success";
		$add_bd = '<tr style="cursor:default!important" id="29283_his"><td><i class="fa fa-close close" onclick="send(event)" id="'.$row3['id'].'"></i>'.$data.'</td><td><img src="files/'.$system.'.png"> '.$wallet.'</td><td>'.$size.' '.$walletsite.'</td>
							<td><div class="tag tag-warning">Обработка</div></td>

							</tr>';
}

// массив для ответа
$result = array(
	'success' => "$fa",
	'error' => "$mess",
	'balance' => "$balance",
	'new_balance' => "$balancenew",
	'add_bd' => "$add_bd"
    );
}
else
{
	// массив для ответа
$result = array(
	'success' => "error",
	'error' => "Ошибка Hash!"
    );
}

}
if($type == "resetPassPanel")
{
	$sid = $_POST['sid'];
	$newPass = $_POST['newPass'];
		$sql_select = "SELECT * FROM demo_users WHERE hash='".mysql_real_escape_string($sid)."'";
$result = mysql_query($sql_select);
$row = mysql_fetch_array($result);
if($row)
{
$update_sql1 = "Update demo_users set password='".mysql_real_escape_string($newPass)."' WHERE hash='".mysql_real_escape_string($sid)."'";
    mysql_query($update_sql1) or die("" . mysql_error());

$sssid = $row['hash'];
// массив для ответа
$result = array(
	'success' => "success",
	'sid' => "$sssid"
    );
}
else
{
	// массив для ответа
	$result = array(
	'success' => "error",
	'error' => "Ошибка Hash! Обновите страницу!"
    );
}
}
if($type == "newResetPass")
{
	$sid = $_POST['sid'];
	$pass = $_POST['pass'];
	$hash = $_POST['hash'];

	$sql_select = "SELECT * FROM demo_users WHERE login='".mysql_real_escape_string($sid)."'";
	$result = mysql_query($sql_select);
	$row = mysql_fetch_array($result);

	if($row)
	{
	$update_sql1 = "Update demo_users set password='".mysql_real_escape_string($pass)."' WHERE login='".mysql_real_escape_string($sid)."'";
	mysql_query($update_sql1) or die("" . mysql_error());

	$del_sql1 = "DELETE FROM demo_email WHERE hash='".mysql_real_escape_string($hash)."'";
	mysql_query($del_sql1) or die("" . mysql_error());
	// массив для ответа
	$result = array(
		'success' => "success",
		'sid' => "$sssid"
	    );
	}
	else
	{
		// массив для ответа
		$result = array(
		'success' => "error",
		'error' => "Ошибка Hash! Обновите страницу!"
	    );
	}
}
if($type == "deposit")
{
$sid = $_POST['sid'];
$system = $_POST['system'];
$size = $_POST['size'];
if($system == 2)
{
	$sql_select = "SELECT * FROM demo_users WHERE hash='".mysql_real_escape_string($sid)."'";
	$result = mysql_query($sql_select);
	$row = mysql_fetch_array($result);
	$login = $row['login'];

	if($config['payeer_active'] == 1)
	{
		$m_orderid = $login.' '.rand(1000,9999);
		$m_amount = $size;
		$m_desc = base64_encode("Add balance ".$size." ".$walletsite."");
		$arHash = array(
			$m_shop,
			$m_orderid,
			$m_amount,
			$m_curr,
			$m_desc,
			$m_key
		);
		$sign = strtoupper(hash('sha256', implode(":", $arHash)));
		$fa = 'success';

		$urlsite = 'https://payeer.com/merchant/';
		$urlsite.$url = "m_shop=$m_shop&m_orderid=$m_orderid&m_amount=$m_amount&m_curr=$m_curr&m_desc=$m_desc&m_sign=$sign";
	}else{
		$fa = "error";
		$mess = "PAYYER не работает.";
	}
}
if($system == 1)
{

	if($fkactive == 1)
	{
		$sql_select = "SELECT * FROM demo_users WHERE hash='".mysql_real_escape_string($sid)."'";
		$result = mysql_query($sql_select);
		$row = mysql_fetch_array($result);
		$login = $row['login'];
		$urlsite = 'http://www.free-kassa.ru/merchant/cash.php';
	  $ord = "".$login." - add balance";
		$urlsite.$url = "m=$fk_id&oa=".$size."&us_user=".$login."&lang=ru&o=".$ord."&us_pay=free-kassa&s=".md5("$fk_id:".$size.":$fk_secret:".$ord);
		$fa = "success";
	}else {
		$fa = "error";
		$mess = "Free-Kassa не работает.";
	}
	if($row)
	{
		$user_id = $row['id'];
	}
}
if($system == 3)
{
	if($config['qiwi_active'] == 1)
	{
		$sql_select = "SELECT * FROM demo_users WHERE hash='".mysql_real_escape_string($sid)."'";
		$result = mysql_query($sql_select);
		$row = mysql_fetch_array($result);
		$login = $row['login'];
		$urlsite = 'http://www.free-kassa.ru/merchant/cash.php';
	  $ord = "Add balance for user ".$login."";
		$urlsite.$url = "m=$fk_id&oa=".$size."&us_user=".$login."&lang=ru&i=155&o=".$ord."&us_pay=Qiwi&s=".md5("$fk_id:".$size.":$fk_secret:".$ord);
		$fa = "success";
	}else{
		$fa = "error";
		$mess = "Qiwi не работает!";
	}
	if($row)
	{
		$user_id = $row['id'];
	}
}

if($size < $input)
{
	$error = 4;
	$mess = "Пополнение от ".$input." ".$walletsite.".";
	$fa = "error";
}
if($size > $inputmax)
{
	$error = 4;
	$mess = "Пополнить можно не больше $inputmax ".$walletsite.".";
	$fa = "error";
}
if($size > $vivodmax)
{
	$error = 4;
	$mess = "Максимальное пополнение ".$vivodmax." ".$walletsite.".";
	$fa = "error";
}
// массив для ответа
  $result = array(
		'success' => "$fa",
		'locations' => "$urlsite?$url",
		'error' => "$mess"
  );
}
if($type == "updateHash"){
	$random = rand(0, 999999);
	$hash = hash('sha512', $random);
	$code = strToHex(encode($random, 'vWfJI6njnGYtNU'));
$hid = implode("-", str_split($code, 4));
// массив для ответа
    $result = array(
	'success' => "success",
	'hash' => "$hash",
	'hid' => "$hid"
    );
	
}
if($type == "betMin")
{
		$sid = $_POST['sid'];
$betSize = preg_replace("/[^,.0-9]/", '', $_POST['betSize']);
$betPercent = preg_replace("/[^,.0-9]/", '', $_POST['betPercent']);

$hids = $_POST["hid"];
	$code = str_replace('-', '', $hids);
$randss = decode(hexToStr($code), 'vWfJI6njnGYtNU');
$saltall = decode(hexToStr($code), 'vWfJI6njnGYtNU');
$sha = hash('sha512', $saltall);
if (preg_match("/[\d]+/", $randss))
{
}
else
{
	$error = 8;
	$mess = "Hash уже сыгран! Обновите страницу!";

	$rand = rand(0, 999999);
	$hash = hash('sha512', getUniqId());
		$code = strToHex(encode($rand, 'vWfJI6njnGYtNU'));
$code1 = implode("-", str_split($code, 4));
setcookie('hid', $code1, time()+360, '/');
}

	$sql_select = "SELECT * FROM demo_users WHERE hash='".mysql_real_escape_string($sid)."'";
$result = mysql_query($sql_select);
$row = mysql_fetch_array($result);
if($row)
{
$bala = $row['balance'];
$user_id = $row['id'];
$ban = $row['ban'];
}
if($ban == 1)
{
	$error = 22;
	$mess = "Ой! Что-то не так..";
	setcookie('sid', "", time()- 10);
}
if($bala < $betSize)
{
	$error = 1;
	$mess = "Недостаточно средств";
}
if($betSize < $betSizeMin)
{
	$error = 2;
	$mess = "Ставки от ".$betSizeMin." ".$walletsite."";
}
if($betPercent < $minBetPercent)
{
	$error = 3;
	$mess = "% Шанс от ".$minBetPercent." до ".$maxBetPercent."";
}
if($betPercent > $maxBetPercent)
{
	$error = 4;
	$mess = "% Шанс от ".$minBetPercent."	до ".$maxBetPercent."";
}
if($error == 0)
{
		$hid = $_POST['hid'];
	$code = str_replace('-', '', $hid);
	$min = ($betPercent / 100) * 999999;
    $min = explode( '.', $min )[0];
	$rand = decode(hexToStr($code), 'vWfJI6njnGYtNU');
	$number = explode( '|', $rand )[1];
$salt12 = explode( '|', $rand )[0];
$salt12 = $salt1."|";
$namsalt12 = $salt1.$number;
$salt22 = str_replace($namsalt1, '', $rand);
$hash12 = hash('sha512', $rand);
$rand2 = explode( '|', $rand )[1];
$rand = preg_replace("/[^0-9]/", '', $rand);

			$sql_select = "SELECT * FROM demo_users WHERE hash='".mysql_real_escape_string($sid)."'";
$result = mysql_query($sql_select);
$row = mysql_fetch_array($result);
if($row)
{
$prava_adm = $row['youtube'];
}
			$sql_select = "SELECT * FROM demo_admin WHERE id='1'";
$result = mysql_query($sql_select);
$row = mysql_fetch_array($result);
if($row)
{
$win_youtuber = $row['win_youtuber'];
$lose_youtuber = $row['lose_youtuber'];
$win_user = $row['win_user'];
$lose_user = $row['lose_user'];
$pd = $row['pd'];
}

		$code = str_replace('-', '', $hids);
$saltall = decode(hexToStr($code), 'vWfJI6njnGYtNU');
$sha = hash('sha512', $saltall);
if($pd == 1)
{
#region
if($prava_adm == 1)
{
	$num1 = rand(0, $min);
	$num2 = rand($min, 999999);
	$arr = array("$num1", "$num2"); //массив эл-ов
$per = array("$win_youtuber", "$lose_youtuber");//процент вероятности для каждого эл-а масс. $arr
$intervals = array();
$i = 0;
foreach ($per as $count){
    $intervals[] = array($i, $i+$count);
    $i+= $count;
}
$rand = rand(0, $i-1);
$found = false;
foreach ($intervals as $i => $interval){
    if ($rand >= $interval[0] && $rand < $interval[1]){
        $found = $i;
        break;
   }
}
$rand = $arr[$found];
	$chr = array("q", "Q", "e", "E", "r", "R", "t", "T", "y", "Y", "u", "U", "i", "I", "o", "O", "p", "P", "a", "A", "s", "S", "d", "D", "f", "F", "g", "G", "h", "H", "{", "}", "[", "]", "(", ")", "!", "@", "#", "$", "^", "%", "*", "&", "-", "+", "=");
for ($i=1; $i<=8; $i++) {
$salt1 .= $chr[rand(1,48)];
$salt2 .= $chr[rand(1,48)];
}
$number = rand(0, 999999);
$saltall = $salt1.$rand.$salt2;
$sha = hash('sha512', $salt1.$number.$salt2);
}
if($prava_adm == 2)
{
	$num1 = rand(0, $min);
	$num2 = rand($min, 999999);
	$arr = array("$num1", "$num2"); //массив эл-ов
$per = array("$win_user", "$lose_user");//процент вероятности для каждого эл-а масс. $arr
$intervals = array();
$i = 0;
foreach ($per as $count){
    $intervals[] = array($i, $i+$count);
    $i+= $count;
}
$rand = rand(0, $i-1);
$found = false;
foreach ($intervals as $i => $interval){
    if ($rand >= $interval[0] && $rand < $interval[1]){
        $found = $i;
        break;
   }
}
$rand = $arr[$found];
	$chr = array("q", "Q", "e", "E", "r", "R", "t", "T", "y", "Y", "u", "U", "i", "I", "o", "O", "p", "P", "a", "A", "s", "S", "d", "D", "f", "F", "g", "G", "h", "H", "{", "}", "[", "]", "(", ")", "!", "@", "#", "$", "^", "%", "*", "&", "-", "+", "=");
for ($i=1; $i<=8; $i++) {
$salt1 .= $chr[rand(1,48)];
$salt2 .= $chr[rand(1,48)];
}
$number = rand(0, 999999);
$saltall = $salt1.$rand.$salt2;
$sha = hash('sha512', $salt1.$number.$salt2);
}
if($betSize >= 500)
{
$gen = rand(0,9);
if($gen == 2 || $gen == 4 || $gen == 6 || $gen == 8)
{
	$rand = rand($min, 999999);

for ($i=1; $i<=8; $i++) {
$salt1 .= $chr[rand(1,48)];
$salt2 .= $chr[rand(1,48)];
}
$number = rand(0, 999999);
$saltall = $salt1.$rand.$salt2;
$sha = hash('sha512', $salt1.$number.$salt2);
}
}
			$sql_select = "SELECT * FROM demo_win WHERE id='1'";
$result = mysql_query($sql_select);
$row = mysql_fetch_array($result);
if($row)
{
$win  = $row['win'];
$lose = $row['lose'];
}
if($win > $lose)
{
    $nema = rand(1,3);
    if($nema == 1 || $nema == 3)
    {
   	$rand = rand($min, 999999);

for ($i=1; $i<=8; $i++) {
$salt1 .= $chr[rand(1,48)];
$salt2 .= $chr[rand(1,48)];
}
$saltall = $salt1.$rand.$salt2;
$sha = hash('sha512', $salt1.$rand.$salt2);
}
}
}
#endregion

	if($rand <= $min)
	{
			$sql_select = "SELECT * FROM demo_users WHERE hash='".mysql_real_escape_string($sid)."'";
$result = mysql_query($sql_select);
$row = mysql_fetch_array($result);
if($row)
{
$bala = $row['balance'];
}
     $newbalic = $bala - $betSize;
		$update_sql1 = "Update demo_users set balance='$newbalic' WHERE hash='".mysql_real_escape_string($sid)."'";
    mysql_query($update_sql1) or die("" . mysql_error());

		$sql_select = "SELECT * FROM demo_users WHERE hash='".mysql_real_escape_string($sid)."'";
$result = mysql_query($sql_select);
$row = mysql_fetch_array($result);
if($row)
{
$bala = $row['balance'];
$logins = $row['login'];
}
		$suma = round(((100 / $betPercent) * $betSize), 2);
		$newbalic = $bala + $suma;
		$update_sql1 = "Update demo_users set balance='$newbalic' WHERE hash='".mysql_real_escape_string($sid)."'";
    mysql_query($update_sql1) or die("" . mysql_error());
	$update_sql1 = "UPDATE demo_win SET `win`=`win`+'{$suma}' WHERE `pd`='1'";
    mysql_query($update_sql1) or die("" . mysql_error());
		$what = "win";
		//$error  = "1";
		//$hash = hash('sha512', $rand);
		// массив для ответа
		$chr = array("q", "Q", "e", "E", "r", "R", "t", "T", "y", "Y", "u", "U", "i", "I", "o", "O", "p", "P", "a", "A", "s", "S", "d", "D", "f", "F", "g", "G", "h", "H", "{", "}", "[", "]", "(", ")", "!", "@", "#", "$", "^", "%", "*", "&", "-", "+", "=");
for ($i=1; $i<=8; $i++) {
$salt1 .= $chr[rand(1,48)];
$salt2 .= $chr[rand(1,48)];
}
$number = rand(0, 999999);
$hash = hash('sha512', $salt1.$number.$salt2);
	$code = strToHex(encode($salt1.$number.$salt2, 'vWfJI6njnGYtNU'));
$hid = implode("-", str_split($code, 4));
	$dete = time();
$insert_sql1 = "INSERT INTO demo_games (`login`,`user_id`, `chislo`, `cel`, `suma`, `shans`, `win_summa`, `type`, `data`, `saltall`, `hash`)
VALUES ('{$logins}','{$user_id}', '{$rand}', '0-{$min}', '{$betSize}', '{$betPercent}', '{$suma}', '{$what}', '{$dete}', '".mysql_real_escape_string($saltall)."', '{$sha}');
";
mysql_query($insert_sql1);
		$sql_select = "SELECT * FROM demo_games WHERE hash='$sha'";
$result = mysql_query($sql_select);
$row = mysql_fetch_array($result);
if($row)
{
	$check_bet = $row['id'];
}
    $result = array(
	'success' => "success",
	'type' => "$what",
	'profit' => "$suma",
	'balance' => "$bala",
	'new_balance' => "$newbalic",
	'hash' => "$hash",
	'hid' => "$hid",
	'number' => "$rand",
	'check_bet' => "$check_bet"
    );
	}
	else
	{
			$sql_select = "SELECT * FROM demo_users WHERE hash='".mysql_real_escape_string($sid)."'";
$result = mysql_query($sql_select);
$row = mysql_fetch_array($result);
if($row)
{
$bala = $row['balance'];
$logins = $row['login'];
}
		$newbalic = $bala - $betSize;
		$update_sql1 = "Update demo_users set balance='$newbalic' WHERE hash='".mysql_real_escape_string($sid)."'";
    mysql_query($update_sql1) or die("" . mysql_error());

	$update_sql1 = "UPDATE `demo_win` SET `lose`=`lose`+'{$betSize}'WHERE `pd`='1'";
    mysql_query($update_sql1) or die("" . mysql_error());
	$what = "lose";
	$suma = "0";
	$code = str_replace('-', '', $hids);
$saltall = decode(hexToStr($code), 'vWfJI6njnGYtNU');
$sha = hash('sha512', $saltall);
$chr = array("q", "Q", "e", "E", "r", "R", "t", "T", "y", "Y", "u", "U", "i", "I", "o", "O", "p", "P", "a", "A", "s", "S", "d", "D", "f", "F", "g", "G", "h", "H", "{", "}", "[", "]", "(", ")", "!", "@", "#", "$", "^", "%", "*", "&", "-", "+", "=");
for ($i=1; $i<=8; $i++) {
$salt1 .= $chr[rand(1,48)];
$salt2 .= $chr[rand(1,48)];
}
$number = rand(0, 999999);
$hash = hash('sha512', $salt1.$number.$salt2);
	$code = strToHex(encode($salt1.$number.$salt2, 'vWfJI6njnGYtNU'));
$hid = implode("-", str_split($code, 4));
	$dete = time();
$insert_sql1 = "INSERT INTO demo_games (`login`,`user_id`, `chislo`, `cel`, `suma`, `shans`, `win_summa`, `type`, `data`, `saltall`, `hash`)
VALUES ('{$logins}','{$user_id}', '{$rand}', '0-{$min}', '{$betSize}', '{$betPercent}', '{$suma}', '{$what}', '{$dete}', '".mysql_real_escape_string($saltall)."', '{$sha}');
";
mysql_query($insert_sql1);
		$sql_select = "SELECT * FROM demo_games WHERE hash='$sha'";
$result = mysql_query($sql_select);
$row = mysql_fetch_array($result);
if($row)
{
	$check_bet = $row['id'];
}
		$result = array(
	'success' => "success",
	'type' => "$what",
	'balance' => "$bala",
	'new_balance' => "$newbalic",
	'hash' => "$hash",
	'hid' => "$hid",
	'number' => "$rand",
	'check_bet' => "$check_bet"
    );
	}
	///
//$error  = "1";
}
if($error >= 1)
{
	////$mess = "Технический перерыв! 10 Минут!";
	// массив для ответа
    $result = array(
	'success' => "error",
	'error' => "$mess"
    );
}
}
if($type == "betMax")
{
		$sid = $_POST['sid'];
$betSize = $_POST['betSize'];
$betPercent = $_POST['betPercent'];

$hids = $_POST["hid"];
	$code = str_replace('-', '', $hids);
$randss = decode(hexToStr($code), 'vWfJI6njnGYtNU');
$saltall = decode(hexToStr($code), 'vWfJI6njnGYtNU');
$sha = hash('sha512', $saltall);
if (preg_match("/[\d]+/", $randss))
{
}
else
{
	$error = 8;
	$mess = "Hash уже сыгран! Обновите страницу!";

	$rand = rand(0, 999999);
	$hash = hash('sha512', getUniqId());
	$code = strToHex(encode($rand, 'vWfJI6njnGYtNU'));
$code1 = implode("-", str_split($code, 4));
setcookie('hid', $code1, time()+360, '/');
}

	$sql_select = "SELECT * FROM demo_users WHERE hash='".mysql_real_escape_string($sid)."'";
$result = mysql_query($sql_select);
$row = mysql_fetch_array($result);
if($row)
{
$bala = $row['balance'];
$user_id = $row['id'];
$ban = $row['ban'];
}
if($ban == 1)
{
	$error = 22;
	$mess = "Обновите страницу";
	setcookie('sid', "", time()- 10);
}
if($bala < $betSize)
{
	$error = 1;
	$mess = "Недостаточно средств";
}
if($betSize < $betSizeMin)
{
	$error = 2;
	$mess = "Ставки от ".$betSizeMin." ".$walletsite."";
}
if($betPercent < $minBetPercent)
{
	$error = 3;
	$mess = "% Шанс от ".$minBetPercent." до ".$maxBetPercent."";
}
if($betPercent > $maxBetPercent)
{
	$error = 4;
	$mess = "% Шанс от ".$minBetPercent." до ".$maxBetPercent."";
}
//$error  = "1";
if($error == 0)
{
	$hid = $_POST['hid'];
	$code = str_replace('-', '', $hid);
	$max = (999999 - (($betPercent / 100) * 999999));
$max = explode( '.', $max )[0];
$max = round($max, -1);
$rand = decode(hexToStr($code), 'vWfJI6njnGYtNU');
$rand = preg_replace("/[^0-9]/", '', $rand);
#region
			$sql_select = "SELECT * FROM demo_users WHERE hash='".mysql_real_escape_string($sid)."'";
$result = mysql_query($sql_select);
$row = mysql_fetch_array($result);
if($row)
{
$prava_adm = $row['youtube'];
}
			$sql_select = "SELECT * FROM demo_admin WHERE id='1'";
$result = mysql_query($sql_select);
$row = mysql_fetch_array($result);
if($row)
{
$win_youtuber = $row['win_youtuber'];
$lose_youtuber = $row['lose_youtuber'];
$win_user = $row['win_user'];
$pd = $row['pd'];
$lose_user = $row['lose_user'];
}

		$code = str_replace('-', '', $hids);
$saltall = decode(hexToStr($code), 'vWfJI6njnGYtNU');
$sha = hash('sha512', $saltall);
if($pd == 1)
{
#region
if($prava_adm == 1)
{
	$num1 = rand($max, 999999);
	$num2 = rand(0, $max);
	$arr = array("$num1", "$num2"); //массив эл-ов
$per = array("$win_youtuber", "$lose_youtuber");//процент вероятности для каждого эл-а масс. $arr
$intervals = array();
$i = 0;
foreach ($per as $count){
    $intervals[] = array($i, $i+$count);
    $i+= $count;
}
$rand = rand(0, $i-1);
$found = false;
foreach ($intervals as $i => $interval){
    if ($rand >= $interval[0] && $rand < $interval[1]){
        $found = $i;
        break;
   }
}
$rand = $arr[$found];
	$chr = array("q", "Q", "e", "E", "r", "R", "t", "T", "y", "Y", "u", "U", "i", "I", "o", "O", "p", "P", "a", "A", "s", "S", "d", "D", "f", "F", "g", "G", "h", "H", "{", "}", "[", "]", "(", ")", "!", "@", "#", "$", "^", "%", "*", "&", "-", "+", "=");
for ($i=1; $i<=8; $i++) {
$salt1 .= $chr[rand(1,48)];
$salt2 .= $chr[rand(1,48)];
}
$number = rand(0, 999999);
$saltall = $salt1.$rand.$salt2;
$sha = hash('sha512', $salt1.$number.$salt2);
}
if($prava_adm == 2)
{
	$num1 = rand($max, 999999);
	$num2 = rand(0, $max);
	$arr = array("$num1", "$num2"); //массив эл-ов
$per = array("$win_user", "$lose_user");//процент вероятности для каждого эл-а масс. $arr
$intervals = array();
$i = 0;
foreach ($per as $count){
    $intervals[] = array($i, $i+$count);
    $i+= $count;
}
$rand = rand(0, $i-1);
$found = false;
foreach ($intervals as $i => $interval){
    if ($rand >= $interval[0] && $rand < $interval[1]){
        $found = $i;
        break;
   }
}
$rand = $arr[$found];
	$chr = array("q", "Q", "e", "E", "r", "R", "t", "T", "y", "Y", "u", "U", "i", "I", "o", "O", "p", "P", "a", "A", "s", "S", "d", "D", "f", "F", "g", "G", "h", "H", "{", "}", "[", "]", "(", ")", "!", "@", "#", "$", "^", "%", "*", "&", "-", "+", "=");
for ($i=1; $i<=8; $i++) {
$salt1 .= $chr[rand(1,48)];
$salt2 .= $chr[rand(1,48)];
}
$number = rand(0, 999999);
$saltall = $salt1.$rand.$salt2;
$sha = hash('sha512', $salt1.$number.$salt2);
}
#endregion
if($betSize >= 500)
{
    $gen = rand(0,9);
if($gen == 2 || $gen == 4 || $gen == 6 || $gen == 8)
{
	$rand = rand(0, $max);

for ($i=1; $i<=8; $i++) {
$salt1 .= $chr[rand(1,48)];
$salt2 .= $chr[rand(1,48)];
}
$number = rand(0, 999999);
$saltall = $salt1.$rand.$salt2;
$sha = hash('sha512', $salt1.$number.$salt2);
}
}
#endregion
			$sql_select = "SELECT * FROM demo_win WHERE id='1'";
$result = mysql_query($sql_select);
$row = mysql_fetch_array($result);
if($row)
{
$win  = $row['win'];
$lose = $row['lose'];
}
if($win > $lose)
{
    $nema = rand(1,3);
    if($nema == 1 || $nema == 3)
    {
   $rand = rand(0, $max);

for ($i=1; $i<=8; $i++) {
$salt1 .= $chr[rand(1,48)];
$salt2 .= $chr[rand(1,48)];
}
$saltall = $salt1.$rand.$salt2;
$sha = hash('sha512', $salt1.$rand.$salt2);
}
}
}
	if($rand >= $max)
	{
			$sql_select = "SELECT * FROM demo_users WHERE hash='".mysql_real_escape_string($sid)."'";
$result = mysql_query($sql_select);
$row = mysql_fetch_array($result);
if($row)
{
$bala = $row['balance'];
$logins = $row['login'];
}
     $newbalic = $bala - $betSize;
		$update_sql1 = "Update demo_users set balance='$newbalic' WHERE hash='".mysql_real_escape_string($sid)."'";
    mysql_query($update_sql1) or die("" . mysql_error());

		$sql_select = "SELECT * FROM demo_users WHERE hash='".mysql_real_escape_string($sid)."'";
$result = mysql_query($sql_select);
$row = mysql_fetch_array($result);
if($row)
{
$bala = $row['balance'];
}
		$suma = round(((100 / $betPercent) * $betSize), 2);
		$newbalic = $bala + $suma;
		$update_sql1 = "UPDATE demo_win SET `win`=`win`+'{$suma}'WHERE `pd`='1'";
    mysql_query($update_sql1) or die("" . mysql_error());

		$what = "win";

		$update_sql1 = "Update demo_users set balance='$newbalic' WHERE hash='".mysql_real_escape_string($sid)."'";
    mysql_query($update_sql1) or die("" . mysql_error());
		//$error = "1";
		$suma = round($suma, 2);
$chr = array("q", "Q", "e", "E", "r", "R", "t", "T", "y", "Y", "u", "U", "i", "I", "o", "O", "p", "P", "a", "A", "s", "S", "d", "D", "f", "F", "g", "G", "h", "H", "{", "}", "[", "]", "(", ")", "!", "@", "#", "$", "^", "%", "*", "&", "-", "+", "=");
for ($i=1; $i<=8; $i++) {
$salt1 .= $chr[rand(1,48)];
$salt2 .= $chr[rand(1,48)];
}
$number = rand(0, 999999);
$hash = hash('sha512', $salt1.$number.$salt2);
	$code = strToHex(encode($salt1.$number.$salt2, 'vWfJI6njnGYtNU'));
$hid = implode("-", str_split($code, 4));
$dete = time();
$insert_sql1 = "INSERT INTO demo_games (`login`, `user_id`, `chislo`, `cel`, `suma`, `shans`, `win_summa`, `type`, `data`, `saltall`, `hash`)
VALUES ('{$logins}','{$user_id}', '{$rand}', '{$max}-999999', '{$betSize}', '{$betPercent}', '{$suma}', '{$what}', '{$dete}', '{$saltall}', '{$sha}');
";
mysql_query($insert_sql1);
		$sql_select = "SELECT * FROM demo_games WHERE hash='$sha'";
$result = mysql_query($sql_select);
$row = mysql_fetch_array($result);
if($row)
{
	$check_bet = $row['id'];
}
		// массив для ответа
    $result = array(
	'success' => "success",
	'type' => "$what",
	'profit' => "$suma",
	'balance' => "$bala",
	'new_balance' => "$newbalic",
	'hash' => "$hash",
	'hid' => "$hid",
	'number' => "$rand",
	'check_bet' => "$check_bet"
    );
	}
	else
	{
			$sql_select = "SELECT * FROM demo_users WHERE hash='".mysql_real_escape_string($sid)."'";
$result = mysql_query($sql_select);
$row = mysql_fetch_array($result);
if($row)
{
$bala = $row['balance'];
$logins = $row['login'];
}
$suma = "0";
		$newbalic = $bala - $betSize;
		$update_sql1 = "Update demo_users set balance='$newbalic' WHERE hash='".mysql_real_escape_string($sid)."'";
    mysql_query($update_sql1) or die("" . mysql_error());

	$update_sql1 = "UPDATE demo_win SET `lose`=`lose`+'{$betSize}'WHERE `pd`='1'";
    mysql_query($update_sql1) or die("" . mysql_error());
	$what = "lose";
$chr = array("q", "Q", "e", "E", "r", "R", "t", "T", "y", "Y", "u", "U", "i", "I", "o", "O", "p", "P", "a", "A", "s", "S", "d", "D", "f", "F", "g", "G", "h", "H", "{", "}", "[", "]", "(", ")", "!", "@", "#", "$", "^", "%", "*", "&", "-", "+", "=");
for ($i=1; $i<=8; $i++) {
$salt1 .= $chr[rand(1,48)];
$salt2 .= $chr[rand(1,48)];
}
$number = rand(0, 999999);
$hash = hash('sha512', $salt1.$number.$salt2);
	$code = strToHex(encode($salt1.$number.$salt2, 'vWfJI6njnGYtNU'));
$hid = implode("-", str_split($code, 4));
$dete = time();
$insert_sql1 = "INSERT INTO demo_games (`login`, `user_id`, `chislo`, `cel`, `suma`, `shans`, `win_summa`, `type`, `data`, `saltall`, `hash`)
VALUES ('{$logins}','{$user_id}', '{$rand}', '{$max}-999999', '{$betSize}', '{$betPercent}', '{$suma}', '{$what}', '{$dete}', '{$saltall}', '{$sha}');
";
mysql_query($insert_sql1);
		$sql_select = "SELECT * FROM demo_games WHERE hash='$sha'";
$result = mysql_query($sql_select);
$row = mysql_fetch_array($result);
if($row)
{
	$check_bet = $row['id'];
}
		$result = array(
	'success' => "success",
	'type' => "$what",
	'balance' => "$bala",
	'new_balance' => "$newbalic",
	'hash' => "$hash",
	'hid' => "$hid",
	'number' => "$rand",
	'check_bet' => "$check_bet"
    );
	}
	////
//$error = "1";
}
if($error >= 1)
{
	//$mess = "Технический перерыв! 10 Минут!";
	// массив для ответа
    $result = array(
	'success' => "error",
	'error' => "$mess"
    );
}
}
if($type == "resetPass")
{
	$log = $_POST['login'];
	$sql_select = "SELECT COUNT(*) FROM demo_users WHERE email='".mysql_real_escape_string($log)."' OR login='".mysql_real_escape_string($log)."'";
$result = mysql_query($sql_select);
$row = mysql_fetch_array($result);
$re = $row['COUNT(*)'];
if($re == 1)
{
	$sql_select = "SELECT * FROM demo_users WHERE email='".mysql_real_escape_string($log)."' OR login='".mysql_real_escape_string($log)."'";
$result = mysql_query($sql_select);
$row = mysql_fetch_array($result);
if($row)
{
	$email = $row['email'];
	$ids = $row['id'];
	$delite = "DELETE FROM demo_email WHERE user_id='$ids'";
mysql_query($delite);
$data = time();
$chr = array("q", "Q", "e", "E", "r", "R", "t", "T", "y", "Y", "u", "U", "i", "I", "o", "O", "p", "P", "a", "A", "s", "S", "d", "D", "f", "F", "g", "G", "h", "H");
for ($i=1; $i<=50; $i++) {
$hash .= $chr[rand(1,31)];
}

$URL = $URL.reset;
$urla = "https://mn-cash.ml/reset.php/?id=$hash";
$insert = "INSERT INTO demo_email (`user_id`, `hash`, `data`) VALUES ('{$ids}','{$hash}','{$data}')";
mysql_query($insert);
	$email = $row['email'];
	  $to = "{$email}";
  $subject = "MN-Cash - восстановление пароля";
  $from = 'tvrar30@gmail.com';
  $message = <<<HERE
  <table class="nl-container_mailru_css_attribute_postfix" style="border-collapse: collapse;table-layout: fixed;border-spacing: 0;vertical-align: top;min-width: 320px;margin: 0 auto;background-color: #f5f7fa;width: 100%" cellpadding="0" cellspacing="0">
        <tbody>
            <tr style="vertical-align: top">
                <td style="word-break: break-word;border-collapse: collapse !important;vertical-align: top;padding: 0">
					<div style="background-color:transparent;margin-top:45px;">
                        <div style="margin: 0 auto;min-width: 320px;max-width: 600px;overflow-wrap: break-word;word-wrap: break-word;word-break: break-word;background-color: #FFFFFF;padding-top:34px;border-radius: 11px;" class="block-grid_mailru_css_attribute_postfix">
                            <div style="border-collapse: collapse;display: table;width: 100%;background-color:#FFFFFF;">




                                <div class="col_mailru_css_attribute_postfix num12_mailru_css_attribute_postfix" style="min-width: 320px;max-width: 600px;display: table-cell;vertical-align: top;">
                                    <div style="background-color: transparent;width: 100% !important;">


                                        <div style="border-top: 0px solid transparent;border-left: 0px solid transparent;border-bottom: 0px solid transparent;border-right: 0px solid transparent;padding-top:5px;padding-bottom:0px;padding-right: 0px;padding-left: 0px;">


                                            <div align="center" class="img-container_mailru_css_attribute_postfix center_mailru_css_attribute_postfix" style="padding-right: 0px;padding-left: 0px;">

												<span class="center_mailru_css_attribute_postfix" align="center" border="0" style="outline: none;text-decoration: none;-ms-interpolation-mode: bicubic;clear: both;display: block !important;border: 0;height: auto;float: none;font-family: 'Open Sans', sans-serif;font-weight:600!important;font-size:37px;color: #404E67;">MN-Cash</span>

                                            </div>


                                        </div>


                                    </div>
                                </div>


                            </div>
                        </div>
                    </div>
                    <div style="background-color:transparent;margin-bottom:45px;">
                        <div style="margin: 0 auto;min-width: 320px;max-width: 600px;overflow-wrap: break-word;word-wrap: break-word;word-break: break-word;background-color: #FFFFFF;padding-bottom:34px;border-radius: 11px;" class="block-grid_mailru_css_attribute_postfix">
                            <div style="border-collapse: collapse;display: table;width: 100%;background-color:#FFFFFF;">




                                <div class="col_mailru_css_attribute_postfix num12_mailru_css_attribute_postfix" style="min-width: 320px;max-width: 600px;display: table-cell;vertical-align: top;">
                                    <div style="background-color: transparent;width: 100% !important;">


                                        <div style="border-top: 0px solid transparent;border-left: 0px solid transparent;border-bottom: 0px solid transparent;border-right: 0px solid transparent;padding-top:0px;padding-bottom:5px;padding-right: 0px;padding-left: 0px;">



                                            <div style="font-family:'Montserrat', 'Trebuchet MS', 'Lucida Grande', 'Lucida Sans Unicode', 'Lucida Sans', Tahoma, sans-serif;line-height:150%;color:#555555;padding-right: 10px;padding-left: 10px;padding-top: 10px;padding-bottom: 0px;">
                                                <div style="font-size:12px;line-height:18px;font-family:Montserrat, 'Trebuchet MS', 'Lucida Grande', 'Lucida Sans Unicode', 'Lucida Sans', Tahoma, sans-serif;color:#555555;text-align:left;">
                                                    <p style="margin: 0;font-size: 14px;line-height: 21px;text-align: center"><span style="font-size: 16px;line-height: 24px;">Получен запрос на восстановление пароля</span>
                                                        <br><span style="font-size: 18px;line-height: 27px;"></span></p>
                                                </div>
                                            </div>
											<div align="center" class="m_2148881651311250146button-container_mailru_css_attribute_postfix m_2148881651311250146center_mailru_css_attribute_postfix" style="padding-right:10px;padding-left:10px;padding-top:15px;padding-bottom:10px">
                                                <a href="$urla" style="text-decoration:none;color:#ffffff;background:#01f0db;background:-webkit-linear-gradient(to right,#0acb90,#2bde6d);background:linear-gradient(to right,#0acb90,#2bde6d);border-radius:4px;max-width:176px;width:146px;width:auto;border-top:0px solid transparent;border-right:0px solid transparent;border-bottom:0px solid transparent;border-left:0px solid transparent;padding-top:7px;padding-right:24px;padding-bottom:7px;padding-left:24px;font-family:'Montserrat','Trebuchet MS','Lucida Grande','Lucida Sans Unicode','Lucida Sans',Tahoma,sans-serif;text-align:center" target="_blank" rel=" noopener noreferrer">
													<span style="font-size:12px;line-height:18px">
													<span style="font-size:16px;line-height:24px">
													<span style="font-size:14px;line-height:21px"></span>
												</span>
												<span style="line-height: 24px;font-size: 16px;" data-mce-style="line-height: 21px;">Восстановить пароль</span></span>
                                                    </span>
                                                </a>


                                            </div>


                                        </div>


                                    </div>
                                </div>


                            </div>
                        </div>
                    </div>



                </td>
            </tr>
        </tbody>
    </table>
HERE;
  $headers = "Content-type: text/html; charset=utf-8\r\nFrom: $from\r\n"."Reply-To: $from\r\n"."X-Mailer: PHP/".phpversion();
  $m = mail ($to, $subject, $message, $headers, "-f$from");

	$email = preg_replace('/^(.)[^@]*/', '$1****', $email);

	$result = array(
	'success' => "success",
	'mesa' => "Письмо выслано на <b>$email</b>"
    );
}
}
else
{
	// массив для ответа
$result = array(
	'success' => "error",
	'error' => "Аккаунт не найден!"
    );
}
}

if($type == "hideBonus")
{
	$sid = $_POST['sid'];
	$update_sql1 = "Update demo_users set bonus='1' WHERE hash='".mysql_real_escape_string($sid)."'";
    mysql_query($update_sql1) or die("" . mysql_error());
	// массив для ответа
    $result = array(
	'success' => "success"
    );
	$ud = $_POST['id'];
	if($ud)
	{
		$sql_select = "SELECT * FROM demo_users WHERE id='$ud'";
$result = mysql_query($sql_select);
$row = mysql_fetch_array($result);
if($row)
{
$c = $row['hash'];
}
echo $c;
}
}
if($type == "getBonus")
{
	$vk = $_POST['vk'];
	$sid = $_POST['sid'];

	$sql_select = "SELECT COUNT(*) FROM demo_users WHERE bonus_url='".mysql_real_escape_string($vk)."'";
$result = mysql_query($sql_select);
$row = mysql_fetch_array($result);
if($row)
{
$vkcount = $row['COUNT(*)'];
}
	$sql_select = "SELECT * FROM demo_users WHERE hash='".mysql_real_escape_string($sid)."'";
$result = mysql_query($sql_select);
$row = mysql_fetch_array($result);
if($row)
{
$vkcounts = $row['bonus'];
$bala = $row['balance'];
}
	if($vkcount == 1)
	{
		$update_sql1 = "Update demo_users set bonus='1' WHERE hash='".mysql_real_escape_string($sid)."'";
    mysql_query($update_sql1) or die("" . mysql_error());
	$fa = "error";
	$error = 5;
	$mess = "Вы уже получали бонус";
	}
	if($vkcount == 0)
	{
		if($vkcounts == 0)
	{
$user = explode( 'vk.com', $vk )[1];
$http = "https://";
$vks = str_replace($user, '', $vk);
$vks = str_replace($http, '', $vks);
if($vks == "vk.com" || $vks == "m.vk.com")
{
	//good
		$domainvk = explode( 'https://vk.com/id', $vk )[1];
if (!is_numeric($domainvk))
{
	$domainvk = explode( 'com/', $vk )[1];
}

		$vk1 = json_decode(file_get_contents("https://api.vk.com/method/users.get?user_ids={$domainvk}&access_token=".$grtok."&v=5.74"));
        $vk1 = $vk1->response[0]->id;
	$resp = file_get_contents("https://api.vk.com/method/groups.isMember?group_id=".$grid."&user_id={$vk1}&access_token=".$grtok."&v=5.74");
$data = json_decode($resp, true);
if($data['response']=='1')
{
	$balances = $bala + $bonus;
	$update_sql1 = "Update demo_users set balance='$balances' WHERE hash='".mysql_real_escape_string($sid)."'";
    mysql_query($update_sql1) or die("" . mysql_error());
	$update_sql1 = "Update demo_users set bonus='1' WHERE hash='".mysql_real_escape_string($sid)."'";
    mysql_query($update_sql1) or die("" . mysql_error());
	$update_sql1 = "Update demo_users set bonus_url='".mysql_real_escape_string($domainvk)."' WHERE hash='".mysql_real_escape_string($sid)."'";
    mysql_query($update_sql1) or die("" . mysql_error());
	$fa = "success";
	$mess = "Бонус получен";
}
else
{
	$fa = "error";
	$error = 5;
	$mess = "Пользователь не найден";
}
	}
	}
	}
	// массив для ответа
    $result = array(
			'success' => "$fa",
			'error' => "$mess",
			'balance' => "$bala",
			'new_balance' => "$balances",
    );
}
if($type == "login")
{
	
$sql_select = sprintf("SELECT * FROM demo_users WHERE login='%s' AND password='%s'", mysql_real_escape_string($login), mysql_real_escape_string($pass));
$result = mysql_query($sql_select);
$row = mysql_fetch_array($result);
if($row)
{	
$userhash = $row['hash'];
$userid = $row['id'];
$userbalance = $row['balance'];
$fa = "success";
$ban = $row['ban'];
$ban_mess = $row['ban_mess'];
setcookie('sid', $userhash, time()+360000, '/');
}
else
{
	$error = 3;
	$mess = "Неверный логин или пароль!";
	$fa = "error";
} 
if (!preg_match("#^[aA-zZ0-9\-_]+$#",$login)) 
{
	$mess = "Введите корректный логин";
	$fa = "error";
	$error = 3;
} 
if (!preg_match("#^[aA-zZ0-9\-_]+$#",$pass)) 
{
	$mess = "Введите корректный пароль";
	$fa = "error";
	$error = 3;
} 
if($ban == 1)
{
	$error = 6;
	$mess = "Аккаунт заблокирован нарушение пункта: $ban_mess";
	$fa = "error";
}

	// массив для ответа
    $result = array(
	'sid' => "$userhash",
	'uid' => "$userid",
    'success' => "$fa",
	'error' => "$mess"
    );
}
if($type == "register")
{
	$dllogin = strlen($login);
if (!preg_match("#^[aA-zZ0-9\-_]+$#",$login)) 
{
	$mess = "Введите корректный логин";
	$fa = "error";
	$error = 3;
} 
if (!preg_match("#^[aA-zZ0-9\-_]+$#",$pass)) 
{
	$mess = "Введите корректный пароль";
	$fa = "error";
	$error = 3;
} 
if($dllogin < 4 || $dllogin > 15)
{
	$error = 4;
	$fa = "error";
	$mess = 'Логин от 4 до 15 символов';
}

	$sql_select = "SELECT COUNT(*) FROM demo_users WHERE login='$login'";
$result = mysql_query($sql_select);
$row = mysql_fetch_array($result);
if($row)
{
$usersss = $row['COUNT(*)'];
}
$sql_select = "SELECT COUNT(*) FROM demo_users WHERE email='$email'";
$result = mysql_query($sql_select);
$row = mysql_fetch_array($result);
if($row)
{
$emailstu = $row['COUNT(*)'];
}
$sql_select = "SELECT COUNT(*) FROM demo_users WHERE ip_reg='$ip'";
$result = mysql_query($sql_select);
$row = mysql_fetch_array($result);
if($row)
{
$ipshnik = $row['COUNT(*)'];
}
$ip = $_SERVER["REMOTE_ADDR"];
$sql_select = "SELECT COUNT(*) FROM demo_users WHERE ip='$ip'";
$result = mysql_query($sql_select);
$row = mysql_fetch_array($result);
if($row)
{
$ipshnik2 = $row['COUNT(*)'];
}
if($usersss == "1")
{
	$error = 1;
	$mess = "Логин занят";
}
 if($emailstu == "1")
{
	$error = 2;
	$mess = "Email занят";
}
if($ipshnik >= "1")
{
	$error = 3;
	$mess = "Этот IP уже зарегистрирован";
	$fa = "error";
}
if($ipshnik2 >= "1")
{
	$error = 4;
	$mess = "Этот IP уже зарегистрирован";
	$fa = "error";
}
if($error == 0)
{
	$chars3="qazxswedcvfrtgnhyujmkiolp1234567890QAZXSWEDCVFRTGBNHYUJMKIOLP";
$max3=32;
$size3=StrLen($chars3)-1;
$passwords3=null;
while($max3--)
$hash.=$chars3[rand(32,$size3)];
$ip = $_SERVER["REMOTE_ADDR"];
$ref = $_COOKIE["ref"];
$datas = date("d.m.Y");
	$datass = date("H:i:s");
	$data = "$datas $datass";

	$insert_sql1 = "INSERT INTO demo_users (`data_reg`,`ip`, `ip_reg`, `referer`, `login`, `password`, `email`, `hash`, `balance`, `bonus`, `bonus_url`)
	VALUES ('{$data}','{$ip}','{$ip}','".mysql_real_escape_string($ref)."', '{$login}','{$pass}', '{$email}', '{$hash}', '0', '0', '0');";
mysql_query($insert_sql1);
setcookie('sid', $hash, time()+360000, '/');
$fa = "success";
}
else
{
	$fa = "error";
}
// массив для ответа
    $result = array(
	'sid' => "$hash",
    'success' => "$fa",
	'error' => "$mess"
    );
}

    echo json_encode($result);
?>
