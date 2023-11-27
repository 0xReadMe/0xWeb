<?php
session_start();
if(isset($_GET['logout'])) {
  unset($_SESSION['uid']);
  unset($_SESSION['name']);
  unset($_SESSION['photo']);
  session_destroy();
  header("Location: /");
  exit();
}
if(isset($_GET['ref'])) {
  $_SESSION['ref'] = $_GET['ref'];
  $char_id = strripos($_SERVER['REQUEST_URI'], '?');
  $redirect = substr($_SERVER['REQUEST_URI'], 0, $char_id);
  header("Location: ".$redirect);
  exit();
}
require("./engine/db_connect.php");

if(isset($_SESSION['uid'])) {
  $now = time();
  $uid = $_SESSION['uid'];
  $db->query("UPDATE users SET last_act='$now' WHERE uid='$uid'");
}
$delay = time()-300;
$online = $db->query("SELECT COUNT(*) FROM users WHERE last_act>$delay")->fetch()[0];
$users = $db->query("SELECT COUNT(*) FROM users")->fetch()[0];
require("./includes/noti_func.php");
require("./engine/vk_auth.php");
require("./engine/payment.php");
?>
<!DOCTYPE html>
<html lang="ru">
<head>
  <meta charset="UTF-8">
<meta http-equiv="x-ua-compatible" content="ie=edge">
<meta name="description" content="<?=$site_description?>">
<meta property="vk:title" content="<?=$vk_title?>">
<meta property="vk:description" content="<?=$vk_description?>">
<meta property="vk:text" content="<?=$vk_text?>">
<meta property="vk:url" content="<?=$vk_url?>">
<meta property="vk:image" content="<?=$vk_image?>">
<meta property="og:type" content="website">
<meta property="og:title" content="<?=$og_title?>">
<meta property="og:description" content="<?=$og_description?>">
<meta property="og:site_name" content="<?=$og_site_name?>">
<meta property="og:url" content="<?=$og_url?>">
<meta property="og:image" content="<?=$og_image?>">
<title><?=$site_title?></title>
<link rel="image_src" href="/images/logo.png">
<link rel="icon" type="image/x-icon" href="/img/favicon.ico">
<meta name="subject" content="<?=$site_subject?>">
<link rel="shortcut icon" href="/img/favicon.ico">
<meta name="category" content="<?=$site_category?>">
<link rel="stylesheet" type="text/css" href="/css/slick.css">
<link rel="stylesheet" href="<?="css/app.css?".rand();?>">


</head>
<body>
<div class="filter" id="filter" style="display: none;"></div>
<div id="prize" class="success indicator" style="display: none;">
  <button onclick="document.getElementById('prize').style = 'display:none';document.getElementById('filter').style = 'display:none'" class="modal__close">×</button>
  <span id="success_message">
  <div class="modal__title" id="game-name"></div>
  <div class="refill__content">
 <div class="refill__desc"> <span id="modal-img"><img id="prize-img" src=""></span></div>
<div class="refill__promocode-wrapper">
  <span id="prize-product"></span></div>
<a href="#" onclick="document.getElementById('prize').style = 'display:none';document.getElementById('filter').style = 'display:none'" class="refill__btn"><span id="btn-text">Продолжить</span></a>
<div class="refill__footer-text">Все ключи валидные, но если это не так, напишите нам на почту support@keyshop, указав подробные данные покупки.</div></div>
</span>
</div>
  <?php include("./includes/noti.php");  ?>
 <div class="wrapper">
<header class="header">
            <div class="header__first">
				<div class="header__logo-wrapper">
					<a class="header__logo-link" title="Перейти на главную" href="/"><div class="hf-logo">KEYSHOP.COM</div></a>
				</div>
               <nav class="header__menu">
                  <ul class="header__menu-list">
                     <li class="header__menu-item">
                        <a class="header__menu-link" href="/faq"><span class="header__menu-img"><img class="auth__image" src="/img/hicon/how-buy.svg" alt=""></span>FAQ</a>
                     </li>
                     <li class="header__menu-item">
                        <a class="header__menu-link" href="/guarantee"><span class="header__menu-img"><img class="auth__image" src="/img/hicon/garant.svg" alt=""></span>Гарантии</a>
                     </li>
					 <li class="header__menu-item">
                        <a class="header__menu-link" href="/contacts"><span class="header__menu-img"><img class="auth__image" src="/img/hicon/contact.svg" alt=""></span>Контакты</a>
                     </li>
                  </ul>
               </nav>
 
            <?php if(!isset($_SESSION['uid'])) {?> 
				<div class="header-auth">
				   <a href=<?="https://oauth.vk.com/authorize?client_id=".$vk_id."&display=page&redirect_uri=".$ssl."://".$_SERVER['SERVER_NAME']."/&response_type=code&v=5.0"?> class="case-err__btn case-err__btn--steam auth">Войти через VK</a>
				
				</div>
			<?php } ?>
			<?php if(isset($_SESSION['uid'])) {
      $uid = $_SESSION['uid'];
      $user_info = $db->query("SELECT * FROM users WHERE uid='$uid'")->fetch();
      ?>
	  <div class="header-auth">
            <div class="mini-profile clear">
                <div class="avatar"><a href="/profile"><img src="<?=$_SESSION['photo']?>" alt=""></a></div>
                <div class="info">
                   <div class="balance"> <a href="/profile" class="name"><?=$_SESSION['name']?></a></div>
                    <div class="action"><a href="#modal-payed" rel="popup">Пополнить</a></div>
                    <div class="points" ><span id="balance"><?=$user_info['balance']?> </span><div class="ico-ruble small"></div></div>
                </div>
                <a href="/?logout" class="btn-exit"></a>
            </div>
        </div>
			<?php } ?>
			</div>

	  
      <?php 
		   $all = $db->query("SELECT COUNT(*) FROM output")->fetch()[0];
        $time = getdate();
        $day = time() - ($second_passed = $time['seconds'] + 60*$time['minutes'] + 3600*$time['hours']);
        $today = $db->query("SELECT COUNT(*) FROM output WHERE date>$day")->fetch()[0];
      ?>               
			<div class="header__second">
               <div class="header__socials">
                  <a href="https://vk.com/" class="header__vk-link" target="_blank"><svg xmlns="http://www.w3.org/2000/svg" width="27" height="15"><path fill-rule="evenodd" fill="#62626A" d="M23.236 9.537c.896.858 1.841 1.666 2.645 2.611.354.42.69.853.947 1.341.364.692.035 1.455-.598 1.496l-3.934-.002c-1.014.083-1.823-.318-2.504-.999-.544-.544-1.048-1.124-1.572-1.687a3.763 3.763 0 0 0-.708-.618c-.537-.342-1.003-.237-1.31.313-.312.559-.383 1.178-.414 1.801-.042.91-.322 1.149-1.252 1.19-1.989.093-3.876-.203-5.629-1.188-1.545-.868-2.744-2.093-3.787-3.481C3.089 7.613 1.534 4.644.136 1.593-.178.905.052.536.824.523 2.108.498 3.391.5 4.675.521c.522.008.867.301 1.068.785.695 1.676 1.544 3.27 2.61 4.748.284.393.574.787.986 1.064.456.307.804.205 1.018-.294.136-.316.196-.657.227-.996.101-1.165.115-2.329-.064-3.49-.109-.725-.525-1.194-1.262-1.331-.376-.07-.32-.208-.138-.418.316-.364.614-.59 1.207-.59h4.445c.7.136.855.445.951 1.136l.004 4.847c-.008.268.136 1.062.627 1.239.393.127.652-.182.888-.427 1.064-1.109 1.824-2.419 2.502-3.777.301-.596.56-1.216.811-1.835.186-.46.478-.686 1.005-.676l4.279.004c.126 0 .255.002.377.023.721.12.919.425.696 1.116-.35 1.084-1.033 1.988-1.701 2.895-.713.97-1.476 1.906-2.184 2.881-.65.89-.598 1.339.209 2.112z"></path></svg></a>
               </div>
			   
			   
				
               <div class="header__stats-wrapper">
			   <div class="search-div">

                    <div class="search-wr" data-delay="1000">
                        <form action="/search" class="search-wr__main" method="post">
                            <input value="" type="search" name="serth-req" class="search-wr__input" placeholder="Поиск игр..." id="game-search-input" required>
                            <div class="search-wr__btns-pair">
                                <button type="submit" class="iconic iconic--lupa search_submit"></button>
                            </div>
                        </form> 
                    </div>
                </div>
                  <ul class="header__stats">
                     <li class="header__stats-item header__stats-item--opens">
                        <div class="header__stats-count"><?=$all?></div>
                        <div class="header__stats-info">Куплено игр</div>
                     </li>
                     <li class="header__stats-item header__stats-item--users">
                        <div class="header__stats-count"><?=$users?></div>
                        <div class="header__stats-info">Пользователей</div>
                     </li>
                     <li class="header__stats-item header__stats-item--online">
                        <div class="header__stats-count"><?=$online?></div>
                        <div class="header__stats-info">Онлайн</div>
                     </li>
                  </ul>
               </div>
            </div>
			
<div class="header_catalog">
		<div class="header_catalog-wrapper">
		<div class="catalog-list">
		
		  <div class="cats-list__col">
                            <a href="/catalog?genre=action" class="category">
                                <div class="category__ico">
                                    <span class="iconic iconic--cat-action hedsize_ico"></span>
                                </div>
                                <p class="category__name">Экшн</p>
                            </a>
                        </div>

                        <div class="cats-list__col">
                            <a href="/catalog?genre=adventure" class="category">
                                <div class="category__ico">
                                    <span class="iconic iconic--cat-adventure"></span>
                                </div>
                                <p class="category__name">приключения</p>
                            </a>
                        </div>

                        <div class="cats-list__col">
                            <a href="/catalog?genre=rpg" class="category">
                                <div class="category__ico">
                                    <span class="iconic iconic--cat-rpg"></span>
                                </div>
                                <p class="category__name">ролевые (rpg)</p>
                            </a>
                        </div>

                        <div class="cats-list__col">
                            <a href="/catalog?genre=simulator" class="category">
                                <div class="category__ico">
                                    <span class="iconic iconic--cat-sim"></span>
                                </div>
                                <p class="category__name">симуляторы</p>
                            </a>
                        </div>

                        <div class="cats-list__col">
                            <a href="/catalog?genre=strategy" class="category">
                                <div class="category__ico">
                                    <span class="iconic iconic--cat-strategy"></span>
                                </div>
                                <p class="category__name">стратегии</p>
                            </a>
                        </div>

                        <div class="cats-list__col">
                            <a href="/catalog?genre=mmo" class="category">
                                <div class="category__ico">
                                    <span class="iconic iconic--cat-mmo"></span>
                                </div>
                                <p class="category__name">MMO</p>
                            </a>
                        </div>

                        <div class="cats-list__col">
                            <a href="/catalog?genre=indie" class="category">
                                <div class="category__ico">
                                    <span class="iconic iconic--cat-indie"></span>
                                </div>
                                <p class="category__name">инди</p>
                            </a>
                        </div>

                        <div class="cats-list__col">
                            <a href="/catalog?genre=sport-racing" class="category">
                                <div class="category__ico">
                                    <span class="iconic iconic--cat-sport"></span>
                                </div>
                                <p class="category__name">спорт и гонки</p>
                            </a>
                        </div>
		
		</div>
			</div>
			</div>
</header>
<main>
	<div>
        <?php require("./engine/router.php"); ?>
	</div>
<div></div>
</main>
<footer class="footer">
            <div class="footer__container">
               <div class="footer__logo-wrapper"><div class="hf-logo">KEY SHOP</div></div>
               <div class="footer__copyright">
                  <div class="footer__copyright-title">© 2019 KEYSHOP.COM</div>
                  <div class="footer__copyright-text">Все продаваемые ключи закупаются у официальных дистрибьюторов и издателей. В том числе у 1C-СофтКлаб, Бука, Новый Диск и Enaza.</div>
               </div>
               <nav class="footer__nav">
                  <ul class="footer__nav-list">
                     <li class="footer__nav-item"><a class="footer__nav-link" href="/agreement">Пользовательское соглашение</a></li>
                     <li class="footer__nav-item"><a class="footer__nav-link" href="/contacts">Контакты</a></li>
                     <li class="footer__nav-item"><a class="footer__nav-link" href="/faq">FAQ</a></li>
                     <li class="footer__nav-item"><a href="#" target="_blank" class="footer__nav-link">Отзывы</a></li>
                  </ul>
               </nav>
               <div class="footer__partner">
                  <a href="https://vk.com/" target="_blank" class="footer__partner-link">
                     <span class="footer__partner-image">
                        <svg xmlns="http://www.w3.org/2000/svg" width="70" height="53">
                           <path fill-rule="evenodd" fill="#ffc607" d="M54.012 23.982a.657.657 0 0 0-.802-.463l-4.967 1.315a.669.669 0 0 0-.312.187l-2.941 3.155c-.053-.041-.099-.087-.155-.123l-10.311-6.655a1.796 1.796 0 0 0-1.802-.085l-4.792 2.496a.48.48 0 0 1-.695-.359.472.472 0 0 1 .094-.354l2.256-2.922a2.54 2.54 0 0 1 1.551-.947l2.646-.489a11.31 11.31 0 0 1 4.392.05l2.814.589c.347.073.706.042 1.036-.091a.674.674 0 0 0 .139-.077l5.594-4.031a.651.651 0 0 0 .146-.912.656.656 0 0 0-.915-.146l-5.514 3.975a.482.482 0 0 1-.217.005l-2.813-.589a12.612 12.612 0 0 0-4.901-.056l-2.647.489a3.863 3.863 0 0 0-1.919.965l-2.464-.389a.523.523 0 0 1-.096-.026l-5.386-4.352a.657.657 0 0 0-.922.096.651.651 0 0 0 .096.918l5.449 4.402a.658.658 0 0 0 .111.072c.171.089.354.149.543.179l1.698.269-1.716 2.223a1.762 1.762 0 0 0-.354 1.323c.064.474.31.894.693 1.183a1.803 1.803 0 0 0 1.908.158l4.792-2.495a.48.48 0 0 1 .482.023l10.311 6.655a.997.997 0 0 1 .44.639 1.012 1.012 0 0 1-1.51 1.071l-5.576-3.323a.657.657 0 0 0-.899.225.65.65 0 0 0 .226.895l4.461 2.658v.001l.538.32a.638.638 0 0 1 .206.9 1.196 1.196 0 0 1-1.56.388l-4.359-2.366a.658.658 0 0 0-.889.261.652.652 0 0 0 .262.886l3.148 1.708.775.471a.592.592 0 0 1 .168.866l-.027.038a1.071 1.071 0 0 1-1.389.377l-3.375-1.707a.658.658 0 0 0-.881.287.65.65 0 0 0 .288.877l2.808 1.42a2.868 2.868 0 0 1-1.951.401l-2.537-.387.18-.257a1.932 1.932 0 0 0-.338-2.574l-.021-.018a1.935 1.935 0 0 0-.821-.385 2.12 2.12 0 0 0-.692-2.246 2.135 2.135 0 0 0-1.264-.465 2.068 2.068 0 0 0-.032-.52 2.1 2.1 0 0 0-.926-1.361 2.143 2.143 0 0 0-2.901.561 2.112 2.112 0 0 0-3.23-.358l-2.39-3.139a.66.66 0 0 0-.324-.227l-4.866-1.537a.654.654 0 1 0-.396 1.244l4.667 1.474 2.495 3.277-.694.989a2.097 2.097 0 0 0 .503 2.908l.037.026c.352.25.762.38 1.184.387a2.123 2.123 0 0 0 2.507 2.094c.119-.021.232-.057.343-.097a2.115 2.115 0 0 0 1.978 1.366c.323 0 .642-.076.933-.218.209.389.544.697.963.87a1.922 1.922 0 0 0 2.264-.602l3.18.484a4.16 4.16 0 0 0 3.573-1.157 2.376 2.376 0 0 0 2.218-1.066c.242-.332.363-.734.358-1.141l.03.002c.818 0 1.622-.398 2.096-1.116.192-.29.29-.618.31-.954.053.003.106.01.159.01.755 0 1.492-.367 1.938-1.041a2.284 2.284 0 0 0 .335-1.747c-.019-.089-.053-.171-.081-.256l2.999-3.217 4.784-1.267a.652.652 0 0 0 .465-.798zM22.2 32.357a.792.792 0 0 1-.19-1.098l1.248-1.776a.787.787 0 0 1 .648-.336.83.83 0 0 1 .434.125.785.785 0 0 1 .36.507.776.776 0 0 1-.095.563l-1.307 1.907a.783.783 0 0 1-.462.268.793.793 0 0 1-.599-.134l-.037-.026zm2.733 2.286a.817.817 0 0 1-.824-1.263l.268-.391c.017-.023.039-.042.056-.066.387-.564.845-1.234 1.232-1.803.01-.014.015-.031.025-.045l1.049-1.53a.822.822 0 0 1 1.477.3.805.805 0 0 1-.126.619l-.359.524c-.008.011-.019.02-.027.031l-1.971 2.853c-.035.051-.058.108-.088.162l-.183.267a.811.811 0 0 1-.529.342zm2.165 1.149a.806.806 0 0 1-.407-.527.8.8 0 0 1 .037-.496l2.082-3.042a.813.813 0 0 1 1.162-.139c.33.266.4.747.159 1.095l-.593.859c-.014.018-.031.033-.044.051l-.96 1.372c-.033.047-.052.099-.081.148l-.292.423a.819.819 0 0 1-1.063.256zm2.786.849a.62.62 0 0 1-.344-.798l1.076-1.558a.613.613 0 0 1 .468-.213c.138 0 .271.046.382.132l.013.011c.25.204.3.571.115.836l-.96 1.371a.62.62 0 0 1-.75.219z"></path>
                        </svg>
                     </span>
                     Сотрудничество
                  </a>
               </div>
               <div class="footer__up"><button class="footer__up-btn"><img src="/img/up.svg" alt="Наверх"></button></div>
            </div>
         </footer>
      </div>
      <div></div>

  <script src="https://code.jquery.com/jquery-2.2.4.js" type="text/javascript"></script>
<script src="/js/slick.min.js" type="text/javascript" charset="utf-8"></script>
<script src="/js/jquery.magnific-popup.min.js" type="text/javascript" type="text/javascript"></script>
<script src="/js/main.js" type="text/javascript" type="text/javascript"></script>
</body>
</html>