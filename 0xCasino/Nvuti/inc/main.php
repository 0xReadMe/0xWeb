<?
//скрипт от Sarry13 (https://vk.com/xyecoc_syka) 
mysql_connect("localhost", "", "")//параметры в скобках ("хост", "имя пользователя", "пароль")
or die("<p>база данных должна тебе сама подключиться? " . mysql_error() . "</p>");
error_reporting(0);
mysql_select_db("")//параметр в скобках ("имя базы, с которой соединяемся")
 or die("<p>база данных захуячила на дачу и не вернулась ". mysql_error() . "</p>"); 
$sql_select = "SELECT COUNT(*) FROM demo_users WHERE online='1'";
$result = mysql_query($sql_select);
$row = mysql_fetch_array($result);
$online = $row['COUNT(*)'];
$hashh = mysql_real_escape_string($_COOKIE["sid"]);
$sql_selectadmin = "SELECT * FROM demo_users WHERE hash='".mysql_real_escape_string($hashh)."'";
$resultadmin = mysql_query($sql_selectadmin);
$rowadmin = mysql_fetch_array($resultadmin);
$prava = $rowadmin['prava'];
if($_GET['i'])
{
setcookie('ref', $_GET['i'], time()+360000, '/');
}
if($_COOKIE["sid"] == "")
{
$go = <<<HERE
<script> 
$( document ).ready(function() { 
$('#agreeAge').modal('show');
});
</script>
	<div class="modal fade text-xs-left in" style="pointer-events: none;" id="agreeAge" tabindex="-1" style="padding-right: 14px;" >
							
									<div style="pointer-events: auto;" class="modal-dialog" role="document">
										<div class="modal-content">
										  <div class="modal-header" style="background-color:#f5f7fa;border-radius:6px">
											<center><font face="Rubik"><h4 class="modal-title" style="font-weight:800; color:#303030;">ПОДТВЕРЖДЕНИЕ НА ВОЗРАСТНОЙ РЕЙТИНГ</h4></font></center>
										  </div>
										  <div class="modal-body">
										  <div class="row">
											<div class="col-lg-10 offset-lg-1" style="margin-top:8px">
											<h5 class="text-xs-center">Услуги сайта - являются имитатором (симулятором), позволяющий получить психо-эмоциональное удовлетворение без каких бы то ни было рисков для пользователя, в связи с чем услучи сайта относятся к аттракционным.</h5>
                                            <br>
											<h5 class="text-xs-center">Зайдя на сайт MN-Cash, вы принимаете условия <span data-toggle="modal" data-target="#large" style="cursor:pointer">"<b>Лицензионного соглашения</b>".</span></h5>
										  </div>

<center>
										<a class="btn btn-outline-success" style="color:#0F0;" data-dismiss="modal" aria-label="Close"><b> МНЕ ЕСТЬ 18 ЛЕТ</b></a>
								   		<a href="https://ya.ru" class="btn btn-outline-danger" style="color:#fff;"><b style="color:#F00"> ПОКИНУТЬ САЙТ</b></a>
                          </center>
										  </div>
										  
										  </div>
										 
										</div>
									  </div>
									</div>		
					                         <div class="row">
                            <div class="col-xs-12">
                                <div class="card">
                                    <div class="card-body" style="margin-top:-10px;border-radius: 10px!important;">
																			  <div class="row">
                                            <div class="col-lg-12 col-md-12 col-sm-12">
                                                <div id="what-is" class="card">
                                                    <div class="card-body collapse in">
                                                        <div class="card-block">
                                                            <div class="card-text">
                                                                <center><h6 class="card-title"><b>Что такое MN-Cash?</b></h6></center>
																<center><h6>$site_info</h6></center>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-lg-12 offset-lg-0">
													<div style="margin-top:-20px;" id="login">
                                                    <div class="col-lg-8 offset-lg-2">
													<div style="margin: -40px 0 0px;">
                                                        <h6 class="card-subtitle line-on-side text-muted text-xs-center font-small-3 pt-2"><span style="font-size:17px"> Авторизация </span></h6>
                                                    </div>
                                                            <div style="margin-top:-20px;" class="card-block">
                                                                <form class="form-horizontal">
												<fieldset class="form-group position-relative has-icon-left">
													<input class="form-control form-control-md input-md" id="userLogin" placeholder="Логин" type="text" value="">
													<div class="form-control-position">
														<h5 class="fas fa-user"></h5>
													</div>
												</fieldset>
												<fieldset class="form-group position-relative has-icon-left">
													<input class="form-control form-control-md input-md" id="userPass" placeholder="Пароль" type="password">
													<div class="form-control-position">
														<h5 class="fas fa-lock"></h5>
													</div>
												</fieldset>
												
																	<center><div style="transform: scale(0.80);" class="g-recaptcha" data-sitekey="$gcaptcha"></div></center>
																	
                                                                    <a id="error_enter" class="btn  btn-block btnError" style="color:#fff;display:none"></a>

                                                                    <a id="enter_but" onclick="login()" class="btn   btn-block" style="background-color: #000000;color:#fff;margin-bottom:5px;border-radius:10px;">
                                                                        <center><span id="text_enter"> <h9 class="fas fa-unlock"></h9>  Войти</span>

                                                                            <div id="loader" style="position:absolute">
                                                                                <div id='dot-container' style='display:none'>
                                                                                    <div id="left-dot" class='white-dot'></div>
                                                                                    <div id='middle-dot' class='white-dot'></div>
                                                                                    <div id='right-dot' class='white-dot'></div>
                                                                                </div>
                                                                            </div>
                                                                        </center>
                                                                    </a>
                                                                </form>
                                                            </div>

                                                        <div style="margin-top:-20x">
                                                            <p class="float-sm-right text-xs-center"><a onclick="register_show()" class="card-link">Регистрация</a></p>
															<p class="float-sm-left text-xs-center"><a onclick="reset_show()" class="card-link">Забыли пароль? </a></p>
                                                        </div>
                                                    </div>
                                                </div>
												<div class="col-lg-12 offset-lg-0">
                                                <div id="register" style="display:none">
												<div class="col-lg-8 offset-lg-2">
													<div class="" style="margin: -50px 0 0px;">
                                                        <h6  class="card-subtitle line-on-side text-muted text-xs-center font-small-3 pt-2"><span style="font-size:17px">Регистрация </span></h6>
                                                    </div>
                                                        <div class="card-body collapse in">
                                                            <div style="margin-top:-20px;" class="card-block">
                                                                <form class="form-horizontal" >
                                                                    <fieldset class="form-group position-relative has-icon-left">
                                                                        <input type="text" class="form-control form-control-md input-md" id="userLoginRegister" placeholder="Логин">
                                                                        <div class="form-control-position">
                                                                           <h5 class="fas fa-user"></h5>
                                                                        </div>
                                                                    </fieldset>
                                                                    <fieldset class="form-group position-relative has-icon-left">
                                                                        <input type="email" class="form-control form-control-md input-md" id="userEmailRegister" placeholder="E-mail">
                                                                        <div class="form-control-position">
                                                                            <h5 class="fas fa-envelope"></h5>
                                                                        </div>
                                                                    </fieldset>
                                                                    <fieldset class="form-group position-relative has-icon-left">
                                                                        <input type="password" class="form-control form-control-md input-md" id="userPassRegister" placeholder="Пароль">
                                                                        <div class="form-control-position">
                                                                            <h5 class="fas fa-lock"></h5>
                                                                        </div>
                                                                    </fieldset>
																																		<fieldset class="form-group position-relative has-icon-left">
                                                                        <input type="password" class="form-control form-control-md input-md" id="userPassRegister1" placeholder="Повторите пароль">
                                                                        <div class="form-control-position">
                                                                            <h5 class="fas fa-lock"></h5>
                                                                        </div>
                                                                    </fieldset>
																	<fieldset style="padding-bottom: 7px;">
																		<label class="check1">
																		  <input id="rulesagree" type="checkbox"/>
																		  <div class="box1"></div>


																		</label>
																		 <div style="display:inline-block;padding-left:10px;position:absolute">Согласен c <u data-toggle="modal" data-target="#large" style="cursor:pointer">правилами</u></div>
																	</fieldset>
																	<center><div style="transform: scale(0.80);"  class="g-recaptcha" data-sitekey="$gcaptcha"></div></center>
                                                                    <a id="error_register" class="btn  btn-block btnError" style="color:#fff;display:none"></a>
                                                                    <a onclick="register1()" class="btn   btn-block" style="background-color: #000000;color:#fff;margin-bottom:5px;border-radius:10px;">

                                                                        <center><span id="text_register"><h7 class="fas fa-check"></h7> Зарегистрироваться</span>

                                                                            <div id="loader_register" style="position:absolute">
                                                                                <div id='dot-container_register' style='display:none'>
                                                                                    <div id="left-dot_register" class='white-dot'></div>
                                                                                    <div id='middle-dot_register' class='white-dot'></div>
                                                                                    <div id='right-dot_register' class='white-dot'></div>
                                                                                </div>
                                                                            </div>

                                                                        </center>
                                                                    </a>
                                                                </form>
                                                            </div>
                                                        </div>
			
                                                        <div style="margin-top:-12px">
                                                            <p class="float-sm-right text-xs-center"><a onclick="login_show()" class="card-link">Есть аккаунт</a></p>
															<p class="float-sm-left text-xs-center"><a onclick="reset_show()" class="card-link">Забыли пароль?</a></p>
                                                        </div>
                                                    </div>
                                                </div>
												<div class="col-lg-12 offset-lg-0">
                                                <div id="reset" style="display:none">
												<div class="col-lg-8 offset-lg-2">
													<div style="margin: -60px 0 0px;">
                                                        <h6 class="card-subtitle line-on-side text-muted text-xs-center font-small-3 pt-2"><span style="font-size:17px">Вспомнить пароль</span></h6>
                                                    </div>
                                                        <div class="card-body collapse in">
                                                            <div style="margin-top:-20px;" class="card-block">

                                                                    <fieldset class="form-group position-relative has-icon-left">
                                                                        <input type="text" class="form-control form-control-md input-md" id="loginemail" placeholder="Логин или E-mail">
                                                                        <div class="form-control-position">
                                                                            <h5 class="fas fa-search"></h5>
                                                                        </div>
                                                                    </fieldset>
																		<center><div style="transform: scale(0.80);"  class="g-recaptcha" data-sitekey="$gcaptcha"></div></center>
                                                                    <a id="error_reset" class="btn  btn-block btnError" style="color:#fff;display:none;margin-bottom:5px"></a>
                                                                    <a id="reset_success" class="btn  btn-block btnSuccess" style="color:#fff;display:none;"></a>
																																		<center id="gtt" style="margin-top: 10px;display:none">Возможно попадание в спам</center>
                                                                    <a  id="reset_but" onclick="reset_password()" class="btn   btn-block" style="background-color: #000000;color:#fff;margin-bottom:5px;border-radius:10px;">
                                                                        <center><span id="text_reset"><h7 class="fas fa-check"></h7> Вспомнить</span>

                                                                            <div id="loader_reset" style="position:absolute">
                                                                                <div id='dot-container_reset' style='display:none'>
                                                                                    <div id="left-dot_reset" class='white-dot'></div>
                                                                                    <div id='middle-dot_reset' class='white-dot'></div>
                                                                                    <div id='right-dot_reset' class='white-dot'></div>
                                                                                </div>
                                                                            </div>

                                                                        </center>
                                                                    </a>
                                                            </div>
                                                        </div>

                                                        <div class="card-footer no-border" style="margin-top:-25px">
                                                            <p class="float-sm-left text-xs-center"><a onclick="login_show()" class="card-link">Есть аккаунт</a></p>
                                                            <p class="float-sm-right text-xs-center"><a onclick="register_show()" class="card-link">Регистрация </a></p>
                                                        </div>
                                                    </div>
                                                </div>

                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
HERE;
$panel = <<<HERE

<div data-menu="menu-container" style="" class="navbar-container main-menu-content container ">
                    <!-- include ../../../includes/mixins-->
                    <ul  style="height: 3rem;" id="main-menu-navigation" data-menu="menu-navigation" class="nav navbar-nav">
					<li class="dropdown nav-item" style="top: 2.5rem; transform: translateY(-50%); -webkit-transform: translateY(-50%); cursor: pointer; width: 11.5rem; position: relative; display: list-item; height: 3rem; background-image: url(/img/logo.png); background-position: center; background-size: 84%; background-repeat: no-repeat; padding: 0; float: left; margin-right: 0px;" onclick="location.href = '/';"></li>
                        <li class="dropdown nav-item active" onclick="$('.dsec').hide();$('#lastBets').show();$(document.body).removeClass('menu-open');">
                            <a class="dropdown-toggle nav-link"><span><i class="fa fa-home"></i>Главная</span></a>

                        </li>
                        <li class="dropdown nav-item " id="gg" onclick="$('.dsec').hide();$('#realGame').show();$(document.body).removeClass('menu-open');">
                            <a class="dropdown-toggle nav-link"><span><i class="fas fa-industry"></i>Честная игра</span></a>

                        </li>
                        <li class="dropdown nav-item " onclick="$('.dsec').hide();$('#rules').show();$(document.body).removeClass('menu-open');">
                            <a class="dropdown-toggle nav-link"><span style="color:#454545"><i class="fa fa-question"></i>FAQ</span></a>
						
                        </li>
						<li class="dropdown nav-item " onclick="$('.dsec').hide();$('#comment').show();$(document.body).removeClass('menu-open');">
                            <a class="dropdown-toggle nav-link"><span><i class="fas fa-address-book"></i>Отзывы</span></a>
                        </li>

						<li class="dropdown nav-item " onclick="last_out();$('.dsec').hide();$('#lastWithdraw').show();$(document.body).removeClass('menu-open');">
                            <a class="dropdown-toggle nav-link"><span style="color:#454545"><i class="fas fa-dollar"></i>Выплаты</span></a>
                        </li>
		<script>
		$(function() {
			$("#main-menu-navigation li").click(function() {
				$('#menu-mob').removeClass('ft-x').addClass('ft-menu');
				if($(this).attr('id') !== 'setPop' && $(this).attr('id') !== 'exit'){
					$("#main-menu-navigation li").removeClass("active");
					$(this).toggleClass("active");
				}
			});
		});
		
		$('#userLogin').on('input', function() {
			if(this.value.match(/[^a-zA-Z0-9]/g)){
				this.value = this.value.replace(/[^a-zA-Z0-9]/g, "");
			};
		});
		
		$('#userLogin').keydown(function(event) {
			if(event.which === 13) {
				login();
			}
		});
		
		$('#userPass').keydown(function(event) {
			if(event.which === 13) {
				login();
			}
		});
		</script>
                        


						<button style="margin-top:20px;float:right;background-color: #000000;color:#fff;border-radius:5px;" class="flat_button logo_button  color3_bg" onclick="window.open('https://vk.com/$grid');"><b>ВКонтакте</b></button>
                    </ul>
					
                </div>

HERE;

}
else
{
	$hashh = mysql_real_escape_string($_COOKIE["sid"]);
	$sql_select = "SELECT * FROM ".$prefix."_users WHERE hash='$hashh'";
$result = mysql_query($sql_select);
$row = mysql_fetch_array($result);
if($row)
{
$userhash = $row['hash'];
$userid = $row['id'];
$idref = $row['login'];
$balance = $row['balance'];
$login = $row['login'];
$email = mysql_real_escape_string($_POST['email']);
$bon = $row['bonus'];
$hashvk = $row['vkhash'];
$vkname = $row['vkname'];
	$chr = array("q", "Q", "e", "E", "r", "R", "t", "T", "y", "Y", "u", "U", "i", "I", "o", "O", "p", "P", "a", "A", "s", "S", "d", "D", "f", "F", "g", "G", "h", "H", "{", "}", "[", "]", "(", ")", "!", "@", "#", "$", "^", "%", "*", "&", "-", "+", "=");
for ($i=1; $i<=8; $i++) {
$salt1 .= $chr[rand(1,48)];
$salt2 .= $chr[rand(1,48)];
}
$number = rand(0, 999999);
$hash = hash('sha512', $salt1.$number.$salt2);
	$code = strToHex(encode($salt1.$number.$salt2, '123456'));
$hid = implode("-", str_split($code, 2));
setcookie('hid', $hid, time()+31536000, '/');
$everybon = $balance + 200;
if($bon == 0)
{
	
	$bonusrow = <<<HERE
<div class="col-xs-16" id="bonusRow">
                                        <div class="card" style="border-radius: 6px!important;">
										
										<div class="card-header" style="border-radius: 4px!important;">
													<div class="heading-elements">
                                                        <ul class="list-inline mb-0 font-medium-2">
                                                            <li onclick="hideBonus()" data-toggle="tooltip" data-placement="top" title="" data-original-title="Больше не показывать"><a><i class="fa fa-close"></i></a></li>
                                                        </ul>
                                                    </div>

                                                </div>
                                            <div class="card-body" style="border-radius: 5px!important;margin-top:-35px">
                                                <div class="row">
													<div class="p-2 text-xs-center ">

													<h5>Для получения денежного бонуса, нужно сделать 2 простых этапа:</h5>
													1. Подписаться на наш паблик, <a target="_blank" href="https://vk.com/nvuti_mashkina">ссылка</a><br>
													2. Введите ссылку на Вашу страницу для проверки
													<center><input class="form-control text-xs-center" id="vkPage" style="width:240px;margin-top:6px" placeholder="https://vk.com/ebanat_natriya">
													<a id="error_bonus" class="btn  btn-block btnError" style="border-radius:20px!important;color: rgb(255, 255, 255); display: none;width:240px;margin-top:6px"></a>
													<a id="success_bonus" class="btn  btn-block btnSuccess" style="color: rgb(255, 255, 255); display: none;width:240px;margin-top:6px"></a>
													<a id="enter_but" onclick="getBonus()" class="btn btn-block btnEnter" style="margin-top:7px;color:#fff;border-radius:20px!important;width:240px;">
                                                                        Получить бонус</a></center>


													</div>
												</div>

											</div>
										</div>
									</div>
HERE;
}
//go
$modal = <<<HERE
<div class="modal fade text-xs-left in" id="coinsflip" tabindex="-1" role="dialog" aria-labelledby="myModalLabel30" style="display: hide; padding-right: 13px;">
			<div class="modal-dialog" role="document">
				<div class="modal-content">
					<div class="modal-header" style="background-color: #F5F7FA; border-radius: 6px;">
						<button type="button" class="close" data-dismiss="modal" aria-label="Close">
							<span aria-hidden="true"><i class="fa fa-close"></i></span>
						</button>
						<h4 class="modal-title" style="font-weight: 600;">50% на 50%</h4>
					</div>
					<div class="modal-body">
						<div class="row">
							<div class="col-lg-12">
								<center>
									<h5 class="text-xs-center" style="color: #000;">Игра 50x50 - загадывается число от 0 до 999999. </h5>
									<h5 class="text-xs-center" style="color: #000;">Вы должны угадать диапазон. </h5>
									<h5 class="text-xs-center" style="color: #000;">Тоже самое, что игра Dice, только чутка переделанный и</h5>
									<h5 class="text-xs-center" style="color: #000;">без возможной подкрутки.</h5>
									<h5 class="text-xs-center" style="color: #000;">Все зависит от тебя! Коэффициент - <b>2x</b></h5>
																		<div>
									<h2 id="setPopMob"><b>Ваш баланс: $balance MN</b></h2></div>
									<br>
									<div>
									 <h5 class="blue-grey darken-1 text-xs-center">Шанс на победу:</h5>
                                     <input readonly type="tel" class="form-control text-xs-center" value="50" style="max-width: 300px;">
									 </div>
									 </br>
									<h5 class="text-xs-center">Сумма ставки:</h5>
									<input id="BetSize1" value="10" onkeyup="validateBetSize(this);" class="form-control text-xs-center" style="max-width: 300px;">
									<br>
									<div id="cflipButton">
										<h5 class="text-xs-center">Ваш выбор:</h5>
										<button style="width: 120px;" type="button" class="mr-1 mb-1 btn btn-danger" onclick="bet1('betMin');">0-499999</button>
										<button style="width: 130px;" type="button" class="mr-1 mb-1 btn btn-info" onclick="bet1('betMax');">500000-999999</button>
										</br>
									</div>
								</center>
							</div>
							<div class="col-lg-8 offset-lg-2">
								<a id="error1_bet" class="btn btn-block btnError" style="color: #fff; margin-top: 15px; display: none;"></a>
								<a id="succes1_coin" class="btn btn-block btnError" style="color: #fff; margin-top: 15px; display: none;"></a>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div><div class="modal fade text-xs-left" id="deposit" tabindex="-1" role="dialog" aria-labelledby="myModalLabel2" style="display: none;" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header" style="background-color:#F5F7FA;border-radius:6px">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true"><i class="fa fa-close"></i></span>
                        </button>
                        <h4 class="modal-title" style="font-weight:800">ПОПОЛНЕНИЕ СЧЕТА</h4>
                    </div>
                    <div class="modal-body">
										<div class="row" style="padding-bottom:15px">
											<div class="text-xs-center" style="padding-bottom:5px">

											<h5> Для продолжения щелкните на иконку Free-Kassa:</h5>
											<br>
														</div>
														
														<input id="systemPay" style="display:none">
												<div id="fkPay" onclick="$('#qiwiInfo').hide();$('#systemPay').val('1'); $('#payeerPayActive').hide();$('#payeerPay').css('opacity','0.25');$('#qiwiPayActive').hide();$('#qiwiPay').css('opacity','0.25'); $('#fkPay').css('opacity','1');deposit();" style="cursor:pointer;margin-bottom:15px;" class="col-lg-12 text-xs-center">
													 <img src="img/free-kassa.png" width="180px"> <img id="fkPayActive" src="files/checked.png" style="position:absolute;display:none;    margin-left: 96px;margin-top: -44px" width="16px">
												</div>
											</div>
                    <div class="row">
                            <div class="col-lg-8 offset-lg-2">
                                <h6>Cумма: </h6><h6>
								<input name="sum" onkeyup="validateWithdrawSize(this)" id="depositSize" placeholder="Сумма..." class="form-control" value="100">
								<a id="error_deposit" class="btn  btn-block btnError" style="color:#fff;margin-top:15px;display:none"></a>
								</h6></div>

								</div>

								 <div class="row">
							<div class="col-lg-4 offset-lg-4">
							<div class="text-xs-center">
                                <svg id="depositLoad" xmlns="https://www.w3.org/2000/svg" xmlns:xlink="https://www.w3.org/1999/xlink" width="40px" height="40px" viewBox="0 0 100 100" style="background: none;display:none">
                                    <g transform="translate(50,50)">
                                        <circle cx="0" cy="0" r="7.142857142857143" fill="none" stroke="#31444f" stroke-width="2" stroke-dasharray="22.43994752564138 22.43994752564138" transform="rotate(337.283)">
                                            <animateTransform attributeName="transform" type="rotate" values="0 0 0;360 0 0" times="0;1" dur="1.6s" calcMode="spline" keySplines="0.2 0 0.8 1" begin="0" repeatCount="indefinite"></animateTransform>
                                        </circle>
                                        <circle cx="0" cy="0" r="14.285714285714286" fill="none" stroke="#465e6b" stroke-width="2" stroke-dasharray="44.87989505128276 44.87989505128276" transform="rotate(359.621)">
                                            <animateTransform attributeName="transform" type="rotate" values="0 0 0;360 0 0" times="0;1" dur="1.6s" calcMode="spline" keySplines="0.2 0 0.8 1" begin="-0.16666666666666666" repeatCount="indefinite"></animateTransform>
                                        </circle>
                                        <circle cx="0" cy="0" r="21.428571428571427" fill="none" stroke="#4c6470" stroke-width="2" stroke-dasharray="67.31984257692413 67.31984257692413" transform="rotate(15.8588)">
                                            <animateTransform attributeName="transform" type="rotate" values="0 0 0;360 0 0" times="0;1" dur="1.6s" calcMode="spline" keySplines="0.2 0 0.8 1" begin="-0.3333333333333333" repeatCount="indefinite"></animateTransform>
                                        </circle>
                                        <circle cx="0" cy="0" r="28.571428571428573" fill="none" stroke="#546E7A" stroke-width="2" stroke-dasharray="89.75979010256552 89.75979010256552" transform="rotate(50.6171)">
                                            <animateTransform attributeName="transform" type="rotate" values="0 0 0;360 0 0" times="0;1" dur="1.6s" calcMode="spline" keySplines="0.2 0 0.8 1" begin="-0.5" repeatCount="indefinite"></animateTransform>
                                        </circle>
                                        <circle cx="0" cy="0" r="35.714285714285715" fill="none" stroke="#fff" stroke-width="2" stroke-dasharray="112.1997376282069 112.1997376282069" transform="rotate(92.2943)">
                                            <animateTransform attributeName="transform" type="rotate" values="0 0 0;360 0 0" times="0;1" dur="1.6s" calcMode="spline" keySplines="0.2 0 0.8 1" begin="-0.6666666666666666" repeatCount="indefinite"></animateTransform>
                                        </circle>
                                        <circle cx="0" cy="0" r="42.857142857142854" fill="none" stroke="#fff" stroke-width="2" stroke-dasharray="134.63968515384826 134.63968515384826" transform="rotate(137.453)">
                                            <animateTransform attributeName="transform" type="rotate" values="0 0 0;360 0 0" times="0;1" dur="1.6s" calcMode="spline" keySplines="0.2 0 0.8 1" begin="-0.8333333333333334" repeatCount="indefinite"></animateTransform>
                                        </circle>
                                    </g>
                                </svg>
                            </div>
                            </div>
                            </div>
                    </div>
                </div>
            </div>
        </div>
		<div class="modal fade text-xs-left" id="profile" tabindex="-1" role="dialog" aria-labelledby="myModalLabel2" style="display: none;" aria-hidden="true">
<div class="modal-dialog" role="document">
				<div class="modal-content">
					<div class="modal-header" style="background-color: #F5F7FA; border-radius: 6px;">
						<button type="button" class="close" data-dismiss="modal" aria-label="Close">
							<span aria-hidden="true"><i class="fa fa-close"></i></span>
						</button>
						<center><h4 class="modal-title" style="font-weight: 600;">Профиль пользователя <b>$login</b></h4></center>
					</div>
					<div class="modal-body">
						<div class="row">
							<div class="col-lg-8 offset-lg-2" style="margin-top: 8px;"></center>
							<center><img style="width:200px; height:130px" src="img/default.png"></center>
												<br>
							<center><h5>E-mail: <b>$row[email]</b></h5></center>
							<center><h5>Дата регистрации: <b>$row[data_reg]</b></h5></center>
							<center><h5>Текущий баланс: <b>$balance</b><b>MN</b></h5></center>
							<center><h5>IP на момент регистрации: <b>$row[ip_reg]</b></h5></center>
							<center><h5>IP на данный момент: <b>$row[ip]</b></h5></center>
							<center><h5>Ваш ID в системе: <b>$row[id]</b></h5></center>
							
							</div>
							<!--<div class="col-lg-4 offset-lg-4" style="margin-top: 15px; margin-bottom: 18px;">
								<a class="btn btn-block" style="color: #fff; background: #6c7a89 !important;" onclick="clearWager();">
									<center><span>Обнулить вагер</span></center>
								</a>
							</div>
							<div class="col-lg-8 offset-lg-2">
								<a id="error_wager" class="btn btn-block btnError" style="color: #fff; display: none; margin-top: 15px;"></a>
								<a id="succes_wager" class="btn btn-block btnSuccess" style="color: #fff; cursor: default;  margin-top: 15px; display: none;"></a>
							</div>-->
						</div>
					</div>
				</div>
			</div>
			</div>
									</div>
									
        <div class="modal fade text-xs-left" id="promomodal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel1" style="display: none;" aria-hidden="true">
									  <div class="modal-dialog" role="document">
										<div class="modal-content">
										  <div class="modal-header" style="background-color:#F5F7FA;border-radius:6px">
											<button type="button" class="close" data-dismiss="modal" aria-label="Close">
											  <span aria-hidden="true"><i class="fa fa-close"></i></span>
											</button>
											<h4 class="modal-title" style="font-weight:800">ВВОД ПРОМОКОДОВ</h4>
										  </div>
										  <div class="modal-body">
										  <div class="row">
										  										  								<h6 class="text-xs-center" style="font-weight:800">ПРОМОКОДЫ ВЫ МОЖЕТЕ НАЙТИ ЗДЕСЬ: <a href="promo">ПРОМОКОДЫ</a> </h6>

											<div class="col-lg-8 offset-lg-2" style="margin-top:8px">
                                <h6>Промокод:</h6>
                                <input type="text" id="promo" class="form-control">

                            </div>

                            <div class="col-lg-8 offset-lg-2">
                                <a id="error_promo" class="btn  btn-block btnError" style="color:#fff;margin-top:15px;display:none"></a>
								<a id="succes_promo" class="btn  btn-block btnSuccess" style="color:#fff; cursor:default;  margin-top:15px;display:none;"></a>
								</div>

							<div class="col-lg-4 offset-lg-4" style="margin-top:15px;margin-bottom:18px">
                                <a class="btn  btn-block  " style="color:#fff;background: #000000!important;" onclick="active()">
                                   <span>  Активировать</span>
                                </a>
                            </div>
										  </div>										  </div>
										</div>
									  </div>
									</div>
		<div class="modal fade text-xs-left" id="default" tabindex="-1" role="dialog" aria-labelledby="myModalLabel1" style="display: none;" aria-hidden="true">
									  <div class="modal-dialog" role="document">
										<div class="modal-content">
										  <div class="modal-header" style="background-color:#F5F7FA;border-radius:6px">
											<button type="button" class="close" data-dismiss="modal" aria-label="Close">
											  <span aria-hidden="true"><i class="fa fa-close"></i></span>
											</button>
											<h4 class="modal-title" style="font-weight:800">НАСТРОЙКИ</h4>
										  </div>
										  <div class="modal-body">
										  <div class="row">
											<div class="col-lg-8 offset-lg-2" style="margin-top:8px">
												<fieldset class="form-group position-relative has-icon-left">
												  <h6>Новый пароль:</h6>
														<input type="password" class="form-control form-control-md input-md" id="resetPass" placeholder="Новый пароль">
														<div style="top:27px;" class="form-control-position">
																<h4 class="fa fa-lock"></h4>
														</div>
												</fieldset>
                      </div>
											<div class="col-lg-8 offset-lg-2" style="margin-top:8px">
												<fieldset class="form-group position-relative has-icon-left">
												  <h6>Повторите пароль:</h6>
														<input type="password" class="form-control form-control-md input-md" id="resetPassRepeat" placeholder="Повторите пароль">
														<div style="top:27px;" class="form-control-position">
																<h4 class="fa fa-lock"></h4>
														</div>
												</fieldset>
	                    </div>
											<div class="card-body pt-0 text-center">
													<center id="vkupd">$vk</center>
											</div>

                            <div class="col-lg-8 offset-lg-2">
                                <a id="error_resetPass" class="btn  btn-block btnError" style="color:#fff;margin-top:15px;display:none"></a>
								<a id="succes_resetPass" class="btn  btn-block btnSuccess" style="color:#fff; cursor:default;  margin-top:15px;display:none;">Пароль изменен</a>
								</div>

							<div class="col-lg-4 offset-lg-4" style="margin-top:15px;margin-bottom:18px">
                                <a class="btn  btn-block  " style="color:#fff;background: #000000!important;" onclick="resetPass()">
                                   <span>  Изменить</span>
                                </a>
                            </div>
							<div class="col-lg-4 offset-lg-4" style="margin-bottom:5px">
                                <a class="btn  btn-block  " style="color:#fff;background: #000000!important;" onclick="Cookies.set('sid', '');location.href = '/';">
                                   <span>  Выйти из аккаунта</span>
                                </a>
                            </div>
										  </div>
										  </div>

										</div>
									  </div>
									</div>

<div class="modal fade text-xs-left" id="withdraw" tabindex="-1" role="dialog" aria-labelledby="myModalLabel2" style="display: none;" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header" style="background-color:#F5F7FA;border-radius:6px">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true"><i class="fa fa-close"></i></span>
                        </button>
                        <h4 class="modal-title" style="font-weight:800">ВЫВОД СРЕДСТВ</h4>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-lg-8 offset-lg-2">
							<br>
                                <h6>Cумма: </h6><h6>
								<input type="text" placeholder="" onkeyup="validateWithdrawSize(this)" id="WithdrawSize" class="form-control">
								</h6></div>
								</div>
								<div class="row">

<div class="col-lg-8 offset-lg-2">
											<h6>Платежная система:</h6>
                                <select class="hide-search form-control select2-hidden-accessible" id="hide_search" onchange="withdrawSelect()" tabindex="-1" aria-hidden="true">
																<optgroup label="Платежные системы">
																		<option value="Qiwi">QIWI</option>
                                </select>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-8 offset-lg-2" style="margin-top:8px">
                              <h6 id="nameWithdraw">Номер кошелька:</h6>
                              <input type="tel" id="walletNumber" class="form-control">
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-8 offset-lg-2">
                                <a id="error_withdraw" class="btn  btn-block btnError" style="color:#fff;display:none;margin-top:15px;"></a>
                                <a id="succes_withdraw" class="btn  btn-block btnSuccess" style="color:#fff; cursor:default;  margin-top:15px;display:none;">Выплата успешно создана</a>
                            </div>
                            <div class="col-lg-4 offset-lg-4" style="margin-top:15px;margin-bottom:18px">
                                <a class="btn  btn-block  " style="color:#fff;background: #000000!important;" onclick="withdraw()">
                                    <center><span id="withdrawB">  Выплата</span>

                                        <div id="loader" style="display:none">
                                            <div id="dot-container">
                                                <div id="left-dot" class="white-dot"></div>
                                                <div id="middle-dot" class="white-dot"></div>
                                                <div id="right-dot" class="white-dot"></div>
                                            </div>
                                        </div>

                                    </center>
                                </a>
                            </div>
                        </div>

						<div class="table-responsive">
                        <table class="table mb-0" id="withdrawTable">
                            <thead>
                                <tr style="cursor:default">
                                    <th style="width:1%">Дата</th>
                                    <th style="width: 5%;">Система</th>
									<th style="width: 62%;">Счет</th>
                                    <th style="width:50%">Сумма</th>
                                    <th style="width:1%">Статус</th>
                                </tr>
                            </thead>
                            <tbody id="withdrawT">


$payouts
                         </tbody>
                        </table>						</div>
						<div id="sh"></div>

                            <div class="text-xs-center">
                                <svg id="withdrawHistoryLoad" xmlns="https://www.w3.org/2000/svg" xmlns:xlink="https://www.w3.org/1999/xlink" width="40px" height="40px" viewBox="0 0 100 100" style="background: none;display:none">
                                    <g transform="translate(50,50)">
                                        <circle cx="0" cy="0" r="7.142857142857143" fill="none" stroke="#31444f" stroke-width="2" stroke-dasharray="22.43994752564138 22.43994752564138" transform="rotate(15.8588)">
                                            <animateTransform attributeName="transform" type="rotate" values="0 0 0;360 0 0" times="0;1" dur="1.6s" calcMode="spline" keySplines="0.2 0 0.8 1" begin="0" repeatCount="indefinite"></animateTransform>
                                        </circle>
                                        <circle cx="0" cy="0" r="14.285714285714286" fill="none" stroke="#465e6b" stroke-width="2" stroke-dasharray="44.87989505128276 44.87989505128276" transform="rotate(50.6171)">
                                            <animateTransform attributeName="transform" type="rotate" values="0 0 0;360 0 0" times="0;1" dur="1.6s" calcMode="spline" keySplines="0.2 0 0.8 1" begin="-0.16666666666666666" repeatCount="indefinite"></animateTransform>
                                        </circle>
                                        <circle cx="0" cy="0" r="21.428571428571427" fill="none" stroke="#4c6470" stroke-width="2" stroke-dasharray="67.31984257692413 67.31984257692413" transform="rotate(92.2943)">
                                            <animateTransform attributeName="transform" type="rotate" values="0 0 0;360 0 0" times="0;1" dur="1.6s" calcMode="spline" keySplines="0.2 0 0.8 1" begin="-0.3333333333333333" repeatCount="indefinite"></animateTransform>
                                        </circle>
                                        <circle cx="0" cy="0" r="28.571428571428573" fill="none" stroke="#546E7A" stroke-width="2" stroke-dasharray="89.75979010256552 89.75979010256552" transform="rotate(137.453)">
                                            <animateTransform attributeName="transform" type="rotate" values="0 0 0;360 0 0" times="0;1" dur="1.6s" calcMode="spline" keySplines="0.2 0 0.8 1" begin="-0.5" repeatCount="indefinite"></animateTransform>
                                        </circle>
                                        <circle cx="0" cy="0" r="35.714285714285715" fill="none" stroke="#fff" stroke-width="2" stroke-dasharray="112.1997376282069 112.1997376282069" transform="rotate(184.948)">
                                            <animateTransform attributeName="transform" type="rotate" values="0 0 0;360 0 0" times="0;1" dur="1.6s" calcMode="spline" keySplines="0.2 0 0.8 1" begin="-0.6666666666666666" repeatCount="indefinite"></animateTransform>
                                        </circle>
                                        <circle cx="0" cy="0" r="42.857142857142854" fill="none" stroke="#fff" stroke-width="2" stroke-dasharray="134.63968515384826 134.63968515384826" transform="rotate(230.652)">
                                            <animateTransform attributeName="transform" type="rotate" values="0 0 0;360 0 0" times="0;1" dur="1.6s" calcMode="spline" keySplines="0.2 0 0.8 1" begin="-0.8333333333333334" repeatCount="indefinite"></animateTransform>
                                        </circle>
                                    </g>
                                </svg>
                            </div>

                    </div>

                </div>
            </div>

        </div>
						<div class="modal fade text-xs-left" id="next-money" tabindex="-1" role="dialog" aria-labelledby="myModalLabel6" style="display: none;" aria-hidden="true">
				  <div class="modal-dialog" role="document">
				      <div class="modal-content">
				          <div class="modal-header" style="background-color:#F5F7FA;border-radius:6px">
				              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
				                  <span aria-hidden="true"><i class="fa fa-close"></i></span>
				              </button>
				              <h4 class="modal-title" style="font-weight:800">ПЕРЕВЕСТИ $walletsite</h4>
				          </div>
				          <div class="modal-body">
									<div class="row" style="padding-bottom:15px">
										<div class="col-lg-8 offset-lg-2" style="padding-bottom:5px">
										<h6>Логин: </h6><h6>
										<input type="text" id="nick_user" placeholder="Кому?" class="form-control">
											$usersall
										</select>
										</div>

										</div>
							<div class="row">
								<div class="col-lg-8 offset-lg-2">
                <h6>Cумма: </h6><h6>
								<input type="text" id="suma_perevoda" placeholder="Сумма.." class="form-control">
								<a id="success_perevod" class="btn  btn-block btnSuccess" style="color:#fff;margin-top:15px;display:none"></a>
								<a id="error_perevod" class="btn  btn-block btnError" style="color:#fff;margin-top:15px;display:none"></a>
								</div>
							</div>
							<div class="row">
							<div class="col-lg-4 offset-lg-4" style="margin-top:15px;margin-bottom:18px">
									<a class="btn  btn-block  " style="color:#fff;background: #000000!important;" onclick="perevod_wallet()">
											<center><span id="perevod_btn">Перевести</span>

													<div id="loader3" style="display:none">
															<div id="dot-container3">
																	<div id="left-dot" class="white-dot"></div>
																	<div id="middle-dot" class="white-dot"></div>
																	<div id="right-dot" class="white-dot"></div>
															</div>
													</div>

											</center>
									</a>
							</div>
							</div>
							</h6>
						</div>
					</div>
				</div>
				


													<div id="loader3" style="display:none">
															<div id="dot-container3">
																	<div id="left-dot" class="white-dot"></div>
																	<div id="middle-dot" class="white-dot"></div>
																	<div id="right-dot" class="white-dot"></div>
															</div>
													</div>

											</center>
									</a>
							</div>
							</div>
							</h6>
						</div>
					</div>
				</div>

HERE;
$hashh = mysql_real_escape_string($_COOKIE["sid"]);
	$sql_select = "SELECT * FROM ".$prefix."_users WHERE hash='$hashh'";
$result = mysql_query($sql_select);
$row = mysql_fetch_array($result);
$prava = $row['prava'];


if($prava == '1')
{
$panel = <<<HERE
<div data-menu="menu-container" class="navbar-container main-menu-content container center-layout">
                    <!-- include ../../../includes/mixins-->
					                   <ul id="main-menu-navigation" data-menu="menu-navigation" class="nav navbar-nav">
					<li class="dropdown nav-item" style="top: 2.5rem; transform: translateY(-50%); -webkit-transform: translateY(-50%); cursor: pointer; width: 11.5rem; position: relative; display: list-item; height: 3rem; background-image: url(/img/logo.png); background-position: center; background-size: 84%; background-repeat: no-repeat; padding: 0; float: left; margin-right: 20px;" onclick="location.href = '/';"></li>
                        <li class="dropdown nav-item active" onclick="$('.dsec').hide();$('#lastBets').show();$(document.body).removeClass('menu-open');">
                            <a class="dropdown-toggle nav-link"><span>Главная</span></a>
												<li class="dropdown nav-item ">
															<li id="setPop" data-toggle="modal" data-target="#default" class="dropdown nav-item " style="float:right!impotant">
																<a class="dropdown-toggle nav-link"><span>Настройки аккаунта</span></a>
															</li>
														
												</li>
                        </li> <li class="dropdown nav-item " style="float:right!impotant" onclick="location.href = 'https://mn-cash.ml/admin'"">
                            <a class="dropdown-toggle nav-link"><span>ADM-Panel</span></a>
                        </li>
						<li class="dropdown nav-item " style="float:right!impotant" onclick="location.href = 'https://mn-cash.ml/promo'"">
                            <a class="dropdown-toggle nav-link"><span>промокоды</span></a>
                        </li>
						<li class="dropdown nav-item " onclick="$('.dsec').hide();$('#contact').show();$(document.body).removeClass('menu-open');">
                            <a class="dropdown-toggle nav-link"><span><i class="fas fa-address-book"></i>test</span></a>
                        </li>
						<li class="dropdown nav-item " onclick="$('.dsec').hide();$('#comment').show();$(document.body).removeClass('menu-open');">
                            <a class="dropdown-toggle nav-link"><span><i class="fas fa-address-book"></i>Отзывы</span></a>
                        </li>
						<li class="dropdown nav-item " style="float:right!impotant" onclick="my_referal();$('.dsec').hide();$('#referals').show();$(document.body).removeClass('menu-open');">
                            <a class="dropdown-toggle nav-link"><span><i class="fa fa-users" aria-hidden="true"></i>Реф. система</span></a>
                        </li>
                        </li> 
						<button style="margin-top:20px;float:right;background-color: #000000;color:#fff;border-radius:5px;" class="flat_button logo_button  color3_bg" onclick="window.open('https://vk.com/$grid');"><b>ВКонтакте</b></button>
                    </ul>
                </div>
HERE;
}else {
	$panel = <<<HERE

	<div data-menu="menu-container" class="navbar-container main-menu-content container center-layout">
                    <!-- include ../../../includes/mixins-->
                    <ul id="main-menu-navigation" data-menu="menu-navigation" class="nav navbar-nav">
					<li class="dropdown nav-item" style="top: 2.5rem; transform: translateY(-50%); -webkit-transform: translateY(-50%); cursor: pointer; width: 11.5rem; position: relative; display: list-item; height: 5rem; background-image: url(/img/logo.png); background-position: center; background-size: 84%; background-repeat: no-repeat; padding: 0; float: left;margin-right:-5px;" onclick="location.href = '/';"></li>
                                                <li class="dropdown nav-item active" onclick="$('.dsec').hide();$('#lastBets').show();$(document.body).removeClass('menu-open');">
                            <a class="dropdown-toggle nav-link"><span><i class="fa fa-home"></i>Главная</span></a>
                        </li>
                        <li class="dropdown nav-item " id="gg" onclick="$('.dsec').hide();$('#realGame').show();$(document.body).removeClass('menu-open');">
                            <a class="dropdown-toggle nav-link"><span><i class="fas fa-industry"></i>Честная игра</span></a>
                        </li>
                        <li class="dropdown nav-item " onclick="$('.dsec').hide();$('#rules').show();$(document.body).removeClass('menu-open');">
                            <a class="dropdown-toggle nav-link"><span style="color:#454545"><i class="fa fa-question"></i>FAQ</span></a>
                        </li>
						<!--<li class="dropdown nav-item " style="float:right!impotant" onclick="my_referal();$('.dsec').hide();$('#referals').show();$(document.body).removeClass('menu-open');">
                            <a class="dropdown-toggle nav-link"><span><i class="fa fa-users" aria-hidden="true"></i>Реф. система</span></a>
                        </li>-->
						<li id="setPop" data-toggle="modal" data-target="#default" class="dropdown nav-item " style="float:right!impotant">
														<a class="dropdown-toggle nav-link"><span><i class="fas fa-cog"></i>Настройки</span></a>
                        </li>
                        </li>
<li class="dropdown nav-item " onclick="$('.dsec').hide();$('#comment').show();$(document.body).removeClass('menu-open');">
                            <a class="dropdown-toggle nav-link"><span><i class="fas fa-address-book"></i>Отзывы</span></a>
                        </li>
						<li class="dropdown nav-item " onclick="last_out();$('.dsec').hide();$('#lastWithdraw').show();$(document.body).removeClass('menu-open');">
                            <a class="dropdown-toggle nav-link"><span style="color:#454545"><i class="fas fa-dollar"></i>Выплаты</span></a>
                        </li>
						<li class="dropdown nav-item " onclick="location.href='promo'"">
                            <a class="nav-link"><span style="color:#454545"><i class="fa fa-gift" aria-hidden="true"></i>Промокоды</span></a>
                        </li>
						<button style="margin-top:20px;float:right;background-color: #000000;color:#fff;border-radius:5px;" class="flat_button logo_button  color3_bg" onclick="window.open('https://vk.com/$grid');"><b>ВКонтакте</b></button>
					</ul>
                </div>

HERE;
}
$go = <<<HERE
<script>
function autoclick()
{
	myVar = setInterval(function(){ click1() }, 900);
}

					
function click1()
{
$('#autoclick').hide();	
$('#stopauto').show();
$('#buttonMax').click();
}

function autoclickstop()
{
$('#autoclick').show();	
$('#stopauto').hide();		
clearInterval(myVar);
}
</script>
<div id="fsi" style="margin-top:10px;border-radius: 5px!important;background-color: #000000!important;" class="alert bg-info alert-dismissible " role="alert">
									<button type="button" class="close" data-dismiss="alert" aria-label="Close">  
										<span aria-hidden="true">×</span>
									</button>
									<center>$glavinfo</center></div>
										$bonusrow
									<div class="col-xs-16">
                                        <div class="card">
                                            <div class="card-body" style="margin-left:0px;margin-top:10px;border-radius: 5px!important;">
                                                <div class="row">
                                                    <div class="col-lg-16 col-md-12 col-sm-12">
<font face="Rubik">
                                                        <div style="margin-top:10px;" class="p-1 text-xs-center ">
														<a data-toggle="modal" data-target="#default" id="setPopMob" class="dropdown-toggle nav-link"><span>Настройки</span></a>
                                                            <h2 data-toggle="modal" data-target="#profile" class="display-6 blue-grey darken-1" style="margin-right:13px;cursor:pointer;text-transform: capitalize!important;">
															$login </h2>
															</font>
                                                            <h3 class="display-4 blue-grey darken-1"><span class="odometer odometer-auto-theme" id="userBalance" mybalance="$balance"><div class="odometer-inside"><span class="odometer-digit"><span class="odometer-digit-spacer">8</span><span class="odometer-digit-inner"><span class="odometer-ribbon"><span class="odometer-ribbon-inner"><span class="odometer-value">0</span></span></span></span></span></div></span> $walletsite</h3>
										
										<div style="" class="card-body">
											<button style="width: 130px;" type="button" class="mr-1 mb-1 btn btn-secondary btn-sm" data-toggle="modal" data-target="#promomodal"><i class="fa fa-money"></i> Промокод</button>
											<button style="width: 130px;" type="button" class="mr-1 mb-1 btn btn-secondary btn-sm" data-toggle="modal" data-target="#next-money"><i class="fa fa-exchange"></i> Перевести</button>
											<button style="width: 130px;" type="button" class="mr-1 mb-1 btn btn-secondary btn-sm" data-toggle="modal" data-target="#deposit"><i class="fa fa-plus-circle"></i> Пополнить</button>
											<button style="width: 130px;" type="button" class="mr-1 mb-1 btn btn-secondary btn-sm" data-toggle="modal" data-target="#withdraw"><i class="fa fa-minus-circle"></i> Вывод</button>
											<button id="autoclick" onclick="autoclick()" class="mr-1 mb-1 btn btn-secondary btn-sm" style="width: 130px;cursor: pointer"><i class="fab fa-cloudscale"></i> Вкл. автоклик</button>	
											<button id="stopauto" onclick="autoclickstop()" class="mr-1 mb-1 btn btn btn-secondary btn-sm" style="width: 130px;display: none;cursor: pointer;"><i class="fas fa-times-circle"></i> Откл. автоклик</button>
								<button style="width: 130px;" type="button" class="mr-1 mb-1 btn btn-secondary btn-sm" data-toggle="modal" data-target="#coinsflip"><i class="fas fa-coins"></i> 50% на 50%</button></div>																					<center style="margin-top: 5px; ">

				</center>
																																									<div style="padding-top:0px;">
																																																		</center>
															</div>
                                                        </div>
                                                    </div>
															</div>
                                                        </div>
                                                    </div>
																						<div class="col-xs-16">
                                        <div class="card">
                                            <div class="card-body" style="margin-top:10px;border-radius: 5px!important;">
                                                <div class="row">
													                                                    <div class="col-lg-4 col-md-6 col-sm-12 border-right-blue-grey border-right-lighten-5">
                                                        <div class="p-1">

                                                            <div class="card-body" style="margin-top:2px;">
<font face="Rubik">
                                                                <div id="controlBet" class="row">
                                                                    <div class="col-md-6 col-xs-6">
                                                                        <div class="form-group">
                                                                            <span class="blue-grey darken-1 text-xs-center">Ставка:</span>
                                                                            <input id="BetSize" onkeyup="validateBetSize(this);" type="tel" class="form-control text-xs-center" value="1">
<div style="margin-top:10px;-webkit-user-select: none;" class="text-xs-center">
																<div style="width: 60px;cursor:pointer;background:linear-gradient(to right, #000000,#000000); color:#fff;" onclick="var x = ($('#BetSize').val()*2);$('#BetSize').val(parseFloat(x.toFixed(2)));updateProfit()" class="tag tag-default">
																	<span style="font-weight:600;font-size: 10px">Удвоить</span>
																</div>
																<div onclick="$('#BetSize').val(Math.max(($('#BetSize').val()/2).toFixed(2), 1));updateProfit()" class="tag tag-default" style="cursor:pointer;margin-top:2px;width: 60px;background:linear-gradient(to right, #000000,#000000); display:inline-block">
																	<span style="font-weight:600;font-size: 10px">Половина</span>
																</div>
																<div onclick="$('#BetSize').val(1);updateProfit()" class="tag tag-default" style="margin-top:2px;width: 60px;cursor:pointer;background:linear-gradient(to right, #000000,#000000); display:inline-block">
																	<span style="font-weight:600;font-size: 10px">Минимум</span>
																</div>
																<div onclick="var max = $('#userBalance').attr('myBalance');$('#BetSize').val(Math.max(max));updateProfit()" class="tag tag-default" style="cursor:pointer;margin-top:2px;width: 60px;background:linear-gradient(to right, #000000,#000000); display:inline-block">
																	<span style="font-weight:600;font-size: 10px">Максимум</span>
																</font>
																</div>
															</div>
                                                                            <script>
                                                                                function validateBetSize(inp) {
																																									if($('#BetSize').val() == 0 || $('#BetSize').val() == ''){
																																										inp.value = inp.value.replace(/[,]/g, '.')
																																												.replace(/[^\d,.]*/g, '')
																																												.replace(/([,.])[,.]+/g, '$1')
																																												.replace(/^[^\d]*(\d+([.,]\d{0,2})?).*$/g, '$1');
																																									}else {
																																										inp.value = inp.value.replace(/[,]/g, '.')
																																												.replace(/[^\d,.]*/g, '')
																																												.replace(/([,.])[,.]+/g, '$1')
																																												.replace(/^[^\d]*(\d+([.,]\d{0,2})?).*$/g, '$1');
																																										updateProfit();
																																									}
                                                                                }
                                                                            </script>
                                                                        </div>
                                                                    </div>
																	<font face="Rubik">
                                                                    <div class="col-md-6 col-xs-6">
                                                                        <div class="form-group">
                                                                            <span class="blue-grey darken-1 text-xs-center">Шанс на победу:</span>
                                                                            <input id="BetPercent" onkeyup="validateBetPercent(this);" type="tel" class="form-control text-xs-center" value="80">

<div style="margin-top:10px;-webkit-user-select: none;" class="text-xs-center">
<font face="Rubik">
																<div style="width: 60px;cursor:pointer;background:linear-gradient(to right, #000000,#000000); " onclick="$('#BetPercent').val(Math.min(($('#BetPercent').val()*2).toFixed(2), 85));updateProfit()" class="tag tag-default">
																	<span style="font-weight:600;font-size: 10px">Удвоить</span>
																</div>
																<div onclick="$('#BetPercent').val(Math.max(($('#BetPercent').val()/2).toFixed(2).replace(/.00/g, ''), 1));updateProfit()" class="tag tag-default" style="background:linear-gradient(to right, #000000,#000000); cursor:pointer;margin-top:2px;width: 60px;background: linear-gradient(to right, rgb(99, 107, 116))!important, rgb(122, 134, 148));display:inline-block">
																	<span style="font-weight:600;font-size: 10px">Половина</span>
																</div>
																<div onclick="$('#BetPercent').val(1);updateProfit()" class="tag tag-default" style="cursor:pointer;margin-top:2px;width: 60px;background:linear-gradient(to right, #000000,#000000); display:inline-block">
																	<span style="font-weight:600;font-size: 10px">Минимум</span>
																</div>
																<div onclick="$('#BetPercent').val(85);updateProfit()" class="tag tag-default" style="background:linear-gradient(to right, #000000,#000000); cursor:pointer;margin-top:2px;width: 60px;display:inline-block">
																	<span style="font-weight:600;font-size: 10px">Максимум</span>
																</div>
															</div>
															

                                                                            <script>
                                                                                function validateBetPercent(inp) {
																																									if (inp.value > $maxBetPercent) {
																																											inp.value = $maxBetPercent;
																																									}

																																									if($('#BetPercent').val() == 0 || $('#BetPercent').val() == ''){
																																										inp.value = inp.value.replace(/[,]/g, '.')
																																												.replace(/[^\d,.]*/g, '')
																																												.replace(/([,.])[,.]+/g, '$1')
																																												.replace(/^[^\d]*(\d+([.,]\d{0,2})?).*$/g, '$1');
																																									}else {
																																										inp.value = inp.value.replace(/[,]/g, '.')
																																												.replace(/[^\d,.]*/g, '')
																																												.replace(/([,.])[,.]+/g, '$1')
																																												.replace(/^[^\d]*(\d+([.,]\d{0,2})?).*$/g, '$1');
																																										updateProfit();
																																									}
                                                                                }
                                                                            </script>
                                                                        </div>
                                                                    </div>
                                                                </div>
																<div class="hidden-xs-down">
                                                                <div class="card-subtitle line-on-side text-muted text-xs-center font-small-3 mx-1 my-1 ">
                                                                    <span><b>Hash игры </b></span>
                                                                </div>

                                                                <center style="word-wrap:break-word;padding-bottom:5px"><a id="hashBet" hid="$hid">
																$hash																	</a>
																
                                                                    <div id="loader_hash" style="position:relative;display:none">
                                                                        <div id="dot-container_hash">
                                                                            <div id="left-dot_hash" class="black-dot"></div>
                                                                            <div id="middle-dot_hash" class="black-dot"></div>
                                                                            <div id="right-dot_hash" class="black-dot"></div>
                                                                        </div>
                                                                    </div>
																	<center>
																													<a style="cursor: pointer;" onclick="$('.dsec').hide(); $('#realGame').show(); $('#main-menu-navigation li').removeClass('active'); $('#gg').addClass('active');">Что это?</a>

                                                                </center>																</div>
                                                            </div>
                                                        </div>
                                                    </div>
													</font>
													</font>
													 <div id="betStart" class="col-lg-8 col-md-6 col-sm-12">
                                                        <div class="p-1 text-xs-center" style="margin-top:0px;"> 
                                                            <div>
																<h3 class="blue-grey darken-1 " style="">Ваш возможный выигрыш:</h3>
																 <div class="row text-xs-center" style="padding-top:0px">
                                                                <h3 class="display-4 success1 " style="word-wrap:break-word;"><span id="BetProfit">1.25</span> $walletsite</h3>
                                                            </div>
														<div id="xxx" style="margin-top:-23px;" >
                                                        <div class="p-1 text-xs-center"> 
															<div>
                                                                <h3 style="word-wrap:break-word;">Коэффициент: <span style="color:#2BDE6D" id="BetX">1.25</span><span style="color:#2BDE6D">x</span></h3> 
                                                            </div>
                                                        </div>
                                                    </div>

                                                            <div style="margin-top:-15px;" class="card-body">
															      <span style="-webkit-user-select: none;-moz-user-select: none;" class="blue-grey darken-1  "><span id="MaxRange">200000</span> - 999999</span>
                                                                    <div class="col-xs-6">
                                                                        <div class="form-group">
                                                                            <span style="-webkit-user-select: none;-moz-user-select: none;" class="blue-grey darken-1 ">0 - <span id="MinRange">799999</span></span>
                                                                            <button onclick="bet('betMin')" id="buttonMin" style="margin-top:5px;color:#fff;border-radius:5px!important; background:linear-gradient(to right, #7b2666,#000000); border: 0px solid;" type="button" class="bg-blue-grey bg-lighten-2  btn btn-block mr-1 mb-1"><a style="font-weight:800">Меньше</a></button>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-xs-6">
                                                                        <div class="form-group">
                                                                            <button onclick="bet('betMax')" type="button" id="buttonMax" style="margin-top:5px;color:#fff;border-radius:5px!important; background:linear-gradient(to right, #7b2666,#000000); border: 0px solid " class="bg-blue-grey bg-lighten-2  btn  btn-block mr-1 mb-1"><a style="font-weight:800">Больше</a></button>
                                                                        </div>
                                                                    </div>

                                                                </div>
														<div id="betLoad1" style="background: none; margin-top: 5px; display: none;">
														<svg xmlns:svg="http://www.w3.org/2000/svg" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" version="1.0" width="34px" height="34px" viewBox="0 0 128 128" xml:space="preserve"><rect x="0" y="0" width="100%" height="100%" fill="none"></rect><g style="transform-origin: 0% 0% !important;" transform="rotate(169.394 64 64)"><path d="M10.96 28.9C12.46 26.14 28.4.5 63.76.24c37.1-.26 53.48 29.12 54.03 30.38 2.44 5.63 1.4 12.86-3.77 15.44-5.93 2.96-12.13 1.18-15.44-3.5-6.83-9.6-7.58-21.7-25.15-28.87-38.08-15.57-64.03 18-62.5 15.2zM117 99.06c-1.48 2.74-17.42 28.4-52.78 28.63-37.1.25-53.5-29.1-54.04-30.4-2.48-5.6-1.43-12.82 3.72-15.4 5.94-2.96 12.15-1.17 15.45 3.5 6.84 9.62 7.58 21.7 25.16 28.88 38.1 15.54 64.06-18 62.5-15.2z" fill="#626E82" fill-opacity="1"></path><animateTransform attributeName="transform" type="rotate" from="0 64 64" to="180 64 64" dur="900ms" repeatCount="indefinite"></animateTransform></g></svg>
													</div>
                                                                <a id="error_bet" class="btn  btn-block btnError" style="border-radius:5px;color:#fff;display:none"></a>
                                                                <a id="succes_bet" class="btn  btn-block btnSuccess" style="border-radius:5px;color:#fff; cursor:default;   margin-top: 0rem; display:none"></a>
                                                            </div>
															                                                            <center style="padding: 0.4rem!important;">

                                                                <a id="checkBet" style="display:none;-webkit-user-select: none;-moz-user-select: none;" class="blue-grey darken-1 " href="" target="_blank">Проверить игру</a>
                                                            </center>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
								
HERE;
}

else
{
	setcookie('sid', "", time()- 10000);
	//setcookie('login', "", time()- 10000);

$go = <<<HERE
<center><h2>Ой! Что-то пошло не так!</h2></center>
						
HERE;

}
}

?>
