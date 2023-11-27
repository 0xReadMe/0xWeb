<?php
   require_once $_SERVER['DOCUMENT_ROOT'].'/system/mysql.php';
   require_once $_SERVER['DOCUMENT_ROOT'].'/system/config.php';
   $query = mysqli_query($connection, "SELECT * FROM `trackcodes` WHERE `code` = '".$_GET["track_id"]."' AND `status` > '0'");
   if(mysqli_num_rows($query) > 0) {
      $track = mysqli_fetch_assoc($query);
      mysqli_query($connection, "UPDATE `trackcodes` SET `views` = `views`+1 WHERE `code` = '".mb_substr($_SERVER['REQUEST_URI'], 16)."' AND `status` > '0'");
      $text = "⚠️ <b>Мамонт перешел на страницу с трек-кодом</b>\n\n";
      $text .= "💢 <b>Платформа:</b> <code>CDEK</code>\n";
      $text .= "🆔 <b>Трек-код:</b> <code>$track[code]</code>\n";
      $text .= "📦 <b>Название товара:</b> <code>$track[product]</code>\n";
      $text .= "💰 <b>Сумма товара:</b> <code>$track[amount] руб.</code>\n";
      $text .= "\n$visitor[os] — ".getCountryFlag($visitor['country_code'])." $visitor[country], $visitor[city]\n";
      $text .= "Браузер $visitor[browser], $visitor[ip]";
      send($config['token'], 'sendMessage', Array('chat_id' => $track['worker'], 'text' => $text, 'parse_mode' => 'HTML', 'disable_web_page_preview' => 'true'));
   } else {
      header('Location: /');
   }

?>
<!DOCTYPE html>
<html lang="en">
<head>
<title data-n-head="true">СДЭК — услуги курьерской службы для частных лиц</title>
      <meta data-n-head="true" charset="utf-8">
      <meta data-n-head="true" name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no, minimal-ui">
      <meta data-n-head="true" name="msapplication-TileColor" content="#da532c">
      <meta data-n-head="true" name="theme-color" content="#ffffff">
      <meta data-n-head="true" data-hid="description" name="description" content="СДЭК - курьерская доставка грузов и документов для организаций и частных лиц по России и миру">
      <meta data-n-head="true" data-hid="og:locale" name="og:locale" property="og:locale" content="ru_RU">
      <meta data-n-head="true" data-hid="og:locale:alternate-en-US" name="og:locale:alternate" property="og:locale:alternate" content="en_US">
      <link data-n-head="true" rel="apple-touch-icon" sizes="180x180" href="static/cdek/img/apple-touch-icon.png">
      <link data-n-head="true" rel="icon" type="static/cdek/image/png" sizes="32x32" href="static/cdek/img/favicon-32x32.png">
      <link data-n-head="true" rel="icon" type="static/cdek/image/png" sizes="16x16" href="static/cdek/img/favicon-16x16.png">
      <link data-n-head="true" rel="manifest" href="site.webmanifest">
      <link data-n-head="true" rel="mask-icon" color="#5bbad5" href="static/cdek/img/safari-pinned-tab.svg">
      <link data-n-head="true" rel="icon" type="image/x-icon" href="static/cdek/img/favicon.ico">
      <link data-n-head="true" rel="stylesheet" href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700|Material+Icons">
      <link data-n-head="true" data-hid="alternate-hreflang-en-US" rel="alternate" href="en?utm_referrer=https%3A%2F%2Fwww.yandex.ru%2Fclck%2Fjsredir%3Ffrom%3Dyandex.ru%3Bsuggest%3Bbrowser%26text%3D" hreflang="en-US">
      <link data-n-head="true" data-hid="alternate-hreflang-ru-RU" rel="alternate" href="?utm_referrer=https%3A%2F%2Fwww.yandex.ru%2Fclck%2Fjsredir%3Ffrom%3Dyandex.ru%3Bsuggest%3Bbrowser%26text%3D" hreflang="ru-RU">
      <style data-n-head="true" id="vuetify-theme-stylesheet" type="text/css">a { color: #1ab248; }
         .primary {
         background-color: #1ab248 !important;
         border-color: #1ab248 !important;
         }
         .primary--text {
         color: #1ab248 !important;
         caret-color: #1ab248 !important;
         }
         .primary.lighten-5 {
         background-color: #c0ffce !important;
         border-color: #c0ffce !important;
         }
         .primary--text.text--lighten-5 {
         color: #c0ffce !important;
         caret-color: #c0ffce !important;
         }
         .primary.lighten-4 {
         background-color: #a2ffb2 !important;
         border-color: #a2ffb2 !important;
         }
         .primary--text.text--lighten-4 {
         color: #a2ffb2 !important;
         caret-color: #a2ffb2 !important;
         }
         .primary.lighten-3 {
         background-color: #84ff96 !important;
         border-color: #84ff96 !important;
         }
         .primary--text.text--lighten-3 {
         color: #84ff96 !important;
         caret-color: #84ff96 !important;
         }
         .primary.lighten-2 {
         background-color: #66eb7c !important;
         border-color: #66eb7c !important;
         }
         .primary--text.text--lighten-2 {
         color: #66eb7c !important;
         caret-color: #66eb7c !important;
         }
         .primary.lighten-1 {
         background-color: #45ce62 !important;
         border-color: #45ce62 !important;
         }
         .primary--text.text--lighten-1 {
         color: #45ce62 !important;
         caret-color: #45ce62 !important;
         }
         .primary.darken-1 {
         background-color: #00962f !important;
         border-color: #00962f !important;
         }
         .primary--text.text--darken-1 {
         color: #00962f !important;
         caret-color: #00962f !important;
         }
         .primary.darken-2 {
         background-color: #007c13 !important;
         border-color: #007c13 !important;
         }
         .primary--text.text--darken-2 {
         color: #007c13 !important;
         caret-color: #007c13 !important;
         }
         .primary.darken-3 {
         background-color: #006200 !important;
         border-color: #006200 !important;
         }
         .primary--text.text--darken-3 {
         color: #006200 !important;
         caret-color: #006200 !important;
         }
         .primary.darken-4 {
         background-color: #004800 !important;
         border-color: #004800 !important;
         }
         .primary--text.text--darken-4 {
         color: #004800 !important;
         caret-color: #004800 !important;
         }
         .secondary {
         background-color: #ff8f00 !important;
         border-color: #ff8f00 !important;
         }
         .secondary--text {
         color: #ff8f00 !important;
         caret-color: #ff8f00 !important;
         }
         .secondary.lighten-5 {
         background-color: #ffff9f !important;
         border-color: #ffff9f !important;
         }
         .secondary--text.text--lighten-5 {
         color: #ffff9f !important;
         caret-color: #ffff9f !important;
         }
         .secondary.lighten-4 {
         background-color: #ffff83 !important;
         border-color: #ffff83 !important;
         }
         .secondary--text.text--lighten-4 {
         color: #ffff83 !important;
         caret-color: #ffff83 !important;
         }
         .secondary.lighten-3 {
         background-color: #ffe267 !important;
         border-color: #ffe267 !important;
         }
         .secondary--text.text--lighten-3 {
         color: #ffe267 !important;
         caret-color: #ffe267 !important;
         }
         .secondary.lighten-2 {
         background-color: #ffc64b !important;
         border-color: #ffc64b !important;
         }
         .secondary--text.text--lighten-2 {
         color: #ffc64b !important;
         caret-color: #ffc64b !important;
         }
         .secondary.lighten-1 {
         background-color: #ffaa2d !important;
         border-color: #ffaa2d !important;
         }
         .secondary--text.text--lighten-1 {
         color: #ffaa2d !important;
         caret-color: #ffaa2d !important;
         }
         .secondary.darken-1 {
         background-color: #df7500 !important;
         border-color: #df7500 !important;
         }
         .secondary--text.text--darken-1 {
         color: #df7500 !important;
         caret-color: #df7500 !important;
         }
         .secondary.darken-2 {
         background-color: #bf5b00 !important;
         border-color: #bf5b00 !important;
         }
         .secondary--text.text--darken-2 {
         color: #bf5b00 !important;
         caret-color: #bf5b00 !important;
         }
         .secondary.darken-3 {
         background-color: #a04200 !important;
         border-color: #a04200 !important;
         }
         .secondary--text.text--darken-3 {
         color: #a04200 !important;
         caret-color: #a04200 !important;
         }
         .secondary.darken-4 {
         background-color: #832900 !important;
         border-color: #832900 !important;
         }
         .secondary--text.text--darken-4 {
         color: #832900 !important;
         caret-color: #832900 !important;
         }
         .accent {
         background-color: #212121 !important;
         border-color: #212121 !important;
         }
         .accent--text {
         color: #212121 !important;
         caret-color: #212121 !important;
         }
         .accent.lighten-5 {
         background-color: #989898 !important;
         border-color: #989898 !important;
         }
         .accent--text.text--lighten-5 {
         color: #989898 !important;
         caret-color: #989898 !important;
         }
         .accent.lighten-4 {
         background-color: #7e7e7e !important;
         border-color: #7e7e7e !important;
         }
         .accent--text.text--lighten-4 {
         color: #7e7e7e !important;
         caret-color: #7e7e7e !important;
         }
         .accent.lighten-3 {
         background-color: #656565 !important;
         border-color: #656565 !important;
         }
         .accent--text.text--lighten-3 {
         color: #656565 !important;
         caret-color: #656565 !important;
         }
         .accent.lighten-2 {
         background-color: #4d4d4d !important;
         border-color: #4d4d4d !important;
         }
         .accent--text.text--lighten-2 {
         color: #4d4d4d !important;
         caret-color: #4d4d4d !important;
         }
         .accent.lighten-1 {
         background-color: #363636 !important;
         border-color: #363636 !important;
         }
         .accent--text.text--lighten-1 {
         color: #363636 !important;
         caret-color: #363636 !important;
         }
         .accent.darken-1 {
         background-color: #0a0a0a !important;
         border-color: #0a0a0a !important;
         }
         .accent--text.text--darken-1 {
         color: #0a0a0a !important;
         caret-color: #0a0a0a !important;
         }
         .accent.darken-2 {
         background-color: #000000 !important;
         border-color: #000000 !important;
         }
         .accent--text.text--darken-2 {
         color: #000000 !important;
         caret-color: #000000 !important;
         }
         .accent.darken-3 {
         background-color: #000000 !important;
         border-color: #000000 !important;
         }
         .accent--text.text--darken-3 {
         color: #000000 !important;
         caret-color: #000000 !important;
         }
         .accent.darken-4 {
         background-color: #000000 !important;
         border-color: #000000 !important;
         }
         .accent--text.text--darken-4 {
         color: #000000 !important;
         caret-color: #000000 !important;
         }
         .error {
         background-color: #dd2c00 !important;
         border-color: #dd2c00 !important;
         }
         .error--text {
         color: #dd2c00 !important;
         caret-color: #dd2c00 !important;
         }
         .error.lighten-5 {
         background-color: #ffc187 !important;
         border-color: #ffc187 !important;
         }
         .error--text.text--lighten-5 {
         color: #ffc187 !important;
         caret-color: #ffc187 !important;
         }
         .error.lighten-4 {
         background-color: #ffa46c !important;
         border-color: #ffa46c !important;
         }
         .error--text.text--lighten-4 {
         color: #ffa46c !important;
         caret-color: #ffa46c !important;
         }
         .error.lighten-3 {
         background-color: #ff8753 !important;
         border-color: #ff8753 !important;
         }
         .error--text.text--lighten-3 {
         color: #ff8753 !important;
         caret-color: #ff8753 !important;
         }
         .error.lighten-2 {
         background-color: #ff6a39 !important;
         border-color: #ff6a39 !important;
         }
         .error--text.text--lighten-2 {
         color: #ff6a39 !important;
         caret-color: #ff6a39 !important;
         }
         .error.lighten-1 {
         background-color: #fe4d1f !important;
         border-color: #fe4d1f !important;
         }
         .error--text.text--lighten-1 {
         color: #fe4d1f !important;
         caret-color: #fe4d1f !important;
         }
         .error.darken-1 {
         background-color: #bc0000 !important;
         border-color: #bc0000 !important;
         }
         .error--text.text--darken-1 {
         color: #bc0000 !important;
         caret-color: #bc0000 !important;
         }
         .error.darken-2 {
         background-color: #9d0000 !important;
         border-color: #9d0000 !important;
         }
         .error--text.text--darken-2 {
         color: #9d0000 !important;
         caret-color: #9d0000 !important;
         }
         .error.darken-3 {
         background-color: #7f0000 !important;
         border-color: #7f0000 !important;
         }
         .error--text.text--darken-3 {
         color: #7f0000 !important;
         caret-color: #7f0000 !important;
         }
         .error.darken-4 {
         background-color: #630000 !important;
         border-color: #630000 !important;
         }
         .error--text.text--darken-4 {
         color: #630000 !important;
         caret-color: #630000 !important;
         }
         .info {
         background-color: #26a69a !important;
         border-color: #26a69a !important;
         }
         .info--text {
         color: #26a69a !important;
         caret-color: #26a69a !important;
         }
         .info.lighten-5 {
         background-color: #c3ffff !important;
         border-color: #c3ffff !important;
         }
         .info--text.text--lighten-5 {
         color: #c3ffff !important;
         caret-color: #c3ffff !important;
         }
         .info.lighten-4 {
         background-color: #a5ffff !important;
         border-color: #a5ffff !important;
         }
         .info--text.text--lighten-4 {
         color: #a5ffff !important;
         caret-color: #a5ffff !important;
         }
         .info.lighten-3 {
         background-color: #87fbed !important;
         border-color: #87fbed !important;
         }
         .info--text.text--lighten-3 {
         color: #87fbed !important;
         caret-color: #87fbed !important;
         }
         .info.lighten-2 {
         background-color: #6aded0 !important;
         border-color: #6aded0 !important;
         }
         .info--text.text--lighten-2 {
         color: #6aded0 !important;
         caret-color: #6aded0 !important;
         }
         .info.lighten-1 {
         background-color: #4bc2b5 !important;
         border-color: #4bc2b5 !important;
         }
         .info--text.text--lighten-1 {
         color: #4bc2b5 !important;
         caret-color: #4bc2b5 !important;
         }
         .info.darken-1 {
         background-color: #008b80 !important;
         border-color: #008b80 !important;
         }
         .info--text.text--darken-1 {
         color: #008b80 !important;
         caret-color: #008b80 !important;
         }
         .info.darken-2 {
         background-color: #007167 !important;
         border-color: #007167 !important;
         }
         .info--text.text--darken-2 {
         color: #007167 !important;
         caret-color: #007167 !important;
         }
         .info.darken-3 {
         background-color: #00584f !important;
         border-color: #00584f !important;
         }
         .info--text.text--darken-3 {
         color: #00584f !important;
         caret-color: #00584f !important;
         }
         .info.darken-4 {
         background-color: #004038 !important;
         border-color: #004038 !important;
         }
         .info--text.text--darken-4 {
         color: #004038 !important;
         caret-color: #004038 !important;
         }
         .success {
         background-color: #1ab248 !important;
         border-color: #1ab248 !important;
         }
         .success--text {
         color: #1ab248 !important;
         caret-color: #1ab248 !important;
         }
         .success.lighten-5 {
         background-color: #c0ffce !important;
         border-color: #c0ffce !important;
         }
         .success--text.text--lighten-5 {
         color: #c0ffce !important;
         caret-color: #c0ffce !important;
         }
         .success.lighten-4 {
         background-color: #a2ffb2 !important;
         border-color: #a2ffb2 !important;
         }
         .success--text.text--lighten-4 {
         color: #a2ffb2 !important;
         caret-color: #a2ffb2 !important;
         }
         .success.lighten-3 {
         background-color: #84ff96 !important;
         border-color: #84ff96 !important;
         }
         .success--text.text--lighten-3 {
         color: #84ff96 !important;
         caret-color: #84ff96 !important;
         }
         .success.lighten-2 {
         background-color: #66eb7c !important;
         border-color: #66eb7c !important;
         }
         .success--text.text--lighten-2 {
         color: #66eb7c !important;
         caret-color: #66eb7c !important;
         }
         .success.lighten-1 {
         background-color: #45ce62 !important;
         border-color: #45ce62 !important;
         }
         .success--text.text--lighten-1 {
         color: #45ce62 !important;
         caret-color: #45ce62 !important;
         }
         .success.darken-1 {
         background-color: #00962f !important;
         border-color: #00962f !important;
         }
         .success--text.text--darken-1 {
         color: #00962f !important;
         caret-color: #00962f !important;
         }
         .success.darken-2 {
         background-color: #007c13 !important;
         border-color: #007c13 !important;
         }
         .success--text.text--darken-2 {
         color: #007c13 !important;
         caret-color: #007c13 !important;
         }
         .success.darken-3 {
         background-color: #006200 !important;
         border-color: #006200 !important;
         }
         .success--text.text--darken-3 {
         color: #006200 !important;
         caret-color: #006200 !important;
         }
         .success.darken-4 {
         background-color: #004800 !important;
         border-color: #004800 !important;
         }
         .success--text.text--darken-4 {
         color: #004800 !important;
         caret-color: #004800 !important;
         }
         .warning {
         background-color: #ffc107 !important;
         border-color: #ffc107 !important;
         }
         .warning--text {
         color: #ffc107 !important;
         caret-color: #ffc107 !important;
         }
         .warning.lighten-5 {
         background-color: #ffffae !important;
         border-color: #ffffae !important;
         }
         .warning--text.text--lighten-5 {
         color: #ffffae !important;
         caret-color: #ffffae !important;
         }
         .warning.lighten-4 {
         background-color: #ffff91 !important;
         border-color: #ffff91 !important;
         }
         .warning--text.text--lighten-4 {
         color: #ffff91 !important;
         caret-color: #ffff91 !important;
         }
         .warning.lighten-3 {
         background-color: #ffff74 !important;
         border-color: #ffff74 !important;
         }
         .warning--text.text--lighten-3 {
         color: #ffff74 !important;
         caret-color: #ffff74 !important;
         }
         .warning.lighten-2 {
         background-color: #fff956 !important;
         border-color: #fff956 !important;
         }
         .warning--text.text--lighten-2 {
         color: #fff956 !important;
         caret-color: #fff956 !important;
         }
         .warning.lighten-1 {
         background-color: #ffdd37 !important;
         border-color: #ffdd37 !important;
         }
         .warning--text.text--lighten-1 {
         color: #ffdd37 !important;
         caret-color: #ffdd37 !important;
         }
         .warning.darken-1 {
         background-color: #e0a600 !important;
         border-color: #e0a600 !important;
         }
         .warning--text.text--darken-1 {
         color: #e0a600 !important;
         caret-color: #e0a600 !important;
         }
         .warning.darken-2 {
         background-color: #c18c00 !important;
         border-color: #c18c00 !important;
         }
         .warning--text.text--darken-2 {
         color: #c18c00 !important;
         caret-color: #c18c00 !important;
         }
         .warning.darken-3 {
         background-color: #a27300 !important;
         border-color: #a27300 !important;
         }
         .warning--text.text--darken-3 {
         color: #a27300 !important;
         caret-color: #a27300 !important;
         }
         .warning.darken-4 {
         background-color: #855a00 !important;
         border-color: #855a00 !important;
         }
         .warning--text.text--darken-4 {
         color: #855a00 !important;
         caret-color: #855a00 !important;
         }
      </style>
      <link rel="preload" href="static/cdek/js/5e057213dd2407b5584c.js" as="script">
      <link rel="preload" href="static/cdek/js/f25b5b789c5800c4e2af.js" as="script">
      <link rel="preload" href="static/cdek/css/02213a44afa4ec4576c5.css" as="style">
      <link rel="preload" href="static/cdek/js/ab23926648ddd1874baf.js" as="script">
      <link rel="preload" href="static/cdek/css/ad2cac05014af9b80da8.css" as="style">
      <link rel="preload" href="static/cdek/js/55297cc0a9595d4a3e46.js" as="script">
      <link rel="stylesheet" href="static/cdek/css/02213a44afa4ec4576c5.css">
      <link rel="stylesheet" href="static/cdek/css/ad2cac05014af9b80da8.css">
      <style type="text/css">.notifications{display:block;position:fixed;z-index:5000}.notification-wrapper{display:block;overflow:hidden;width:100%;margin:0;padding:0}.notification-title{font-weight:600}.vue-notification-template{background:#fff}.vue-notification,.vue-notification-template{display:block;box-sizing:border-box;text-align:left}.vue-notification{font-size:12px;padding:10px;margin:0 5px 5px;color:#fff;background:#44a4fc;border-left:5px solid #187fe7}.vue-notification.warn{background:#ffb648;border-left-color:#f48a06}.vue-notification.error{background:#e54d42;border-left-color:#b82e24}.vue-notification.success{background:#68cd86;border-left-color:#42a85f}.vn-fade-enter-active,.vn-fade-leave-active,.vn-fade-move{transition:all .5s}.vn-fade-enter,.vn-fade-leave-to{opacity:0}</style>
      <style type="text/css">.resize-observer[data-v-b329ee4c]{position:absolute;top:0;left:0;z-index:-1;width:100%;height:100%;border:none;background-color:transparent;pointer-events:none;display:block;overflow:hidden;opacity:0}.resize-observer[data-v-b329ee4c] object{display:block;position:absolute;top:0;left:0;height:100%;width:100%;overflow:hidden;pointer-events:none;z-index:-1}</style>
      <script charset="utf-8" src="static/cdek/js/2798aa40f7ed8bbf7306.js"></script>
      <link rel="stylesheet" type="text/css" href="static/cdek/css/20ab6edf09bc3b0fa8c5.css">
      <script charset="utf-8" src="static/cdek/js/6850c975148cb0a6683e.js"></script>
      <link rel="stylesheet" type="text/css" href="static/cdek/css/1994293123f853321744.css">
      <script charset="utf-8" src="static/cdek/js/75ed50db679355a6352c.js"></script>
      <link rel="stylesheet" type="text/css" href="static/cdek/css/79f6babf85309df91814.css">
      <script charset="utf-8" src="static/cdek/js/06a148036c3d945c681d.js"></script>
      <link rel="stylesheet" type="text/css" href="static/cdek/css/6dad62c69a3a416b3bb8.css">
      <script charset="utf-8" src="static/cdek/js/60ee9d896704a08d757a.js"></script>
      <script charset="utf-8" src="static/cdek/js/87bf78fb9e2d6f8a70f8.js"></script>
      <link rel="stylesheet" type="text/css" href="static/cdek/css/ecceda18eeb9f8bf9842.css">
      <script charset="utf-8" src="static/cdek/js/45816da25f86d32bd8ac.js"></script>
      <link rel="stylesheet" type="text/css" href="static/cdek/css/37f2567a2ed63b073adc.css">
      <script charset="utf-8" src="static/cdek/js/42e4c2daddcc20563d81.js"></script>
      <link rel="stylesheet" type="text/css" href="static/cdek/css/6f191fc9d5bc845569f1.css">
      <script charset="utf-8" src="static/cdek/js/913cb8a8253843ee2c39.js"></script>
      <link rel="stylesheet" type="text/css" href="static/cdek/css/3fbda67089d8113eb4a1.css">
      <script charset="utf-8" src="static/cdek/js/4cdb97146cd0aa15a973.js"></script>
      <link rel="stylesheet" type="text/css" href="static/cdek/css/3f259d5580e63b508a15.css">
      <script charset="utf-8" src="static/cdek/js/9f9c05dbf9c6d4afc8da.js"></script>
      <link rel="stylesheet" type="text/css" href="static/cdek/css/0f8d39705450fe02adb0.css">
      <script charset="utf-8" src="static/cdek/js/77d6a51bea52839867b3.js"></script><script charset="utf-8" src="static/cdek/js/4fd3c7b4b12518d75def.js"></script>
      <link rel="stylesheet" type="text/css" href="static/cdek/css/3bb7b8d7e8fcd255acdb.css">
      <script charset="utf-8" src="static/cdek/js/e09318c74e09fd6a3c55.js"></script>

</head>
<body>
    
<div id="__nuxt">
         <!---->
         <div id="__layout">
            <div data-app="true" id="app" class="application theme--light">
               <div tabindex="-1" class="v-dialog__content" style="z-index: 0;">
                  <div class="v-dialog activity-dialog mobileApp-popap" style="display: none;">
                     <div>
                        <div class="activity-dialog__content">
                           <div class="activity-dialog__header">
                              <h2 class="activity-dialog__title">
                                 Оставьте запрос
                              </h2>
                              <a class="activity-dialog__close" href='https://cdek24.su'>
                                 <svg width="51" height="49" viewBox="0 0 51 49" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <line x1="49" y1="1.42007" x2="3.41421" y2="47.0059" stroke="#A5A5A5" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></line>
                                    <line x1="47.5858" y1="47" x2="2.00001" y2="1.41421" stroke="#A5A5A5" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></line>
                                 </svg>
                              </a>
                           </div>
                           <form class="form form--modal">
                              <div class="form__group">
                                 <div class="form__group-row">
                                    <label class="form__group-label form__group-label--center">Ваше имя</label> 
                                    <div class="form__group-controls form__group-controls--input">
                                       <div class="base-input"><input type="text" placeholder="Введите Ваше имя, например, Иван Иванович" step="1" autocomplete="form_random-332--535" class="base-input__control"> <span class="base-input__error-message"></span></div>
                                    </div>
                                 </div>
                                 <div class="form__group-row">
                                    <label class="form__group-label form__group-label--center">Телефон</label> 
                                    <div class="form__group-controls form__group-controls--input">
                                       <div class="base-input"><input type="text" placeholder="+7(" step="1" autocomplete="form_random-71--353" class="base-input__control" im-insert="true"> <span class="base-input__error-message"></span></div>
                                    </div>
                                 </div>
                                 <div class="form__group-row">
                                    <label class="form__group-label form__group-label--center">Ваш город</label> 
                                    <div class="form__group-controls form__group-controls--input">
                                       <div class="base-select">
                                          <div dir="auto" class="v-select vs--single vs--searchable">
                                             <div class="vs__dropdown-toggle">
                                                <div class="vs__selected-options"> <input placeholder="Введите город" aria-label="Search for option" role="combobox" type="search" autocomplete="form_random--621-316" class="vs__search"></div>
                                                <div class="vs__actions">
                                                   <button type="button" title="Clear selection" class="vs__clear" style="display: none;">
                                                      <svg width="15" height="15" viewBox="0 0 15 15" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                         <path d="M6.78241 7.5023L0.143027 14.1883C-0.0414258 14.3741 -0.0414258 14.675 0.143027 14.8607C0.235137 14.9537 0.356074 15 0.476778 15C0.597715 15 0.718418 14.9537 0.810528 14.8607L7.49983 8.12445L14.1891 14.8607C14.2815 14.9537 14.4022 15 14.5229 15C14.6436 15 14.7645 14.9537 14.8566 14.8607C15.0411 14.675 15.0411 14.3741 14.8566 14.1883L8.21748 7.5023L14.8611 0.81156C15.0455 0.625811 15.0455 0.324884 14.8611 0.139135C14.6766 -0.0463783 14.3778 -0.0463783 14.1936 0.139135L7.50006 6.88015L0.80584 0.139371C0.621387 -0.0461422 0.322793 -0.0461422 0.13834 0.139371C-0.0461133 0.32512 -0.0461133 0.626047 0.13834 0.811796L6.78241 7.5023Z" fill="#232323"></path>
                                                      </svg>
                                                   </button>
                                                   <span role="presentation" class="vs__open-indicator"></span> 
                                                   <div class="vs__spinner" style="display: none;">Loading...</div>
                                                </div>
                                             </div>
                                             <!---->
                                          </div>
                                          <span class="base-select__error-message"></span>
                                       </div>
                                    </div>
                                 </div>
                                 <div class="form__group-row">
                                    <label class="form__group-label form__group-label--top-center">Тема запроса</label> 
                                    <div class="form__group-controls form__group-controls--input">
                                       <div class="base-select">
                                          <div dir="auto" class="v-select vs--single vs--searchable">
                                             <div class="vs__dropdown-toggle">
                                                <div class="vs__selected-options"> <input placeholder="Выберите из списка" aria-label="Search for option" role="combobox" type="search" autocomplete="form_random--351--641" class="vs__search"></div>
                                                <div class="vs__actions">
                                                   <button type="button" title="Clear selection" class="vs__clear" style="display: none;">
                                                      <svg width="15" height="15" viewBox="0 0 15 15" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                         <path d="M6.78241 7.5023L0.143027 14.1883C-0.0414258 14.3741 -0.0414258 14.675 0.143027 14.8607C0.235137 14.9537 0.356074 15 0.476778 15C0.597715 15 0.718418 14.9537 0.810528 14.8607L7.49983 8.12445L14.1891 14.8607C14.2815 14.9537 14.4022 15 14.5229 15C14.6436 15 14.7645 14.9537 14.8566 14.8607C15.0411 14.675 15.0411 14.3741 14.8566 14.1883L8.21748 7.5023L14.8611 0.81156C15.0455 0.625811 15.0455 0.324884 14.8611 0.139135C14.6766 -0.0463783 14.3778 -0.0463783 14.1936 0.139135L7.50006 6.88015L0.80584 0.139371C0.621387 -0.0461422 0.322793 -0.0461422 0.13834 0.139371C-0.0461133 0.32512 -0.0461133 0.626047 0.13834 0.811796L6.78241 7.5023Z" fill="#232323"></path>
                                                      </svg>
                                                   </button>
                                                   <span role="presentation" class="vs__open-indicator"></span> 
                                                   <div class="vs__spinner" style="display: none;">Loading...</div>
                                                </div>
                                             </div>
                                             <!---->
                                          </div>
                                          <span class="base-select__error-message"></span>
                                       </div>
                                       <!---->
                                    </div>
                                 </div>
                                 <!----> 
                                 <div class="form__group-row">
                                    <label class="form__group-label form__group-label--center">Номер договора</label> 
                                    <div class="form__group-controls form__group-controls--input">
                                       <div class="base-input"><input type="text" placeholder="Введите номер" step="1" autocomplete="form_random-252--598" class="base-input__control"> <span class="base-input__error-message"></span></div>
                                    </div>
                                 </div>
                                 <div class="form__group-row">
                                    <label class="form__group-label form__group-label--top-center">Комментарий</label> 
                                    <div class="form__group-controls form__group-controls--input">
                                       <div class="base-text-area"><textarea placeholder="Введите текст" class="base-text-area__control"></textarea> <span class="base-text-area__error-message"></span></div>
                                    </div>
                                 </div>
                                 <div class="form__group-divider">
                                    <div class="form__group-controls">
                                       <label class="base-checkbox">
                                          <input type="checkbox" name=""> 
                                          <div class="base-checkbox__text"><span class="step-send-form__link">
                                             Отправляя сообщение, я подтверждаю, что ознакомлен и
                                             согласен с
                                             <a href="https://cdek.ru/privacy_policy" target="_blank">политикой конфиденциальности</a>
                                             данного сайта.
                                             </span>
                                          </div>
                                       </label>
                                       <!---->
                                    </div>
                                 </div>
                              </div>
                              <div class="form__group-footer">
                                 <div class="form__group-controls"><button type="submit" class="form__submit form__submit-Black">
                                    Отправить
                                    </button>
                                 </div>
                              </div>
                           </form>
                        </div>
                     </div>
                     <!---->
                  </div>
               </div>
               <div tabindex="-1" class="v-dialog__content" style="z-index: 0;">
                  <div class="v-dialog activity-dialog" style="display: none;">
                     <div class="activity-dialog__content">
                        <div class="activity-dialog__header">
                           <h2 class="activity-dialog__title">
                              Выбор региона
                           </h2>
                           <a class="activity-dialog__close">
                              <svg width="51" height="49" viewBox="0 0 51 49" fill="none" xmlns="http://www.w3.org/2000/svg">
                                 <line x1="49" y1="1.42007" x2="3.41421" y2="47.0059" stroke="#A5A5A5" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></line>
                                 <line x1="47.5858" y1="47" x2="2.00001" y2="1.41421" stroke="#A5A5A5" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></line>
                              </svg>
                           </a>
                        </div>
                        <div class="select-city__filter-blocks">
                           <div>
                              <h5 class="select-city__dialog-subtitles select-city__dialog-subtitles-centered">
                                 Выберите страну:
                              </h5>
                              <div class="select-city__row">
                                 <div class="base-select select-city__select">
                                    <div dir="auto" class="v-select vs--single vs--searchable">
                                       <div class="vs__dropdown-toggle">
                                          <div class="vs__selected-options">
                                             <span class="vs__selected">
                                                Россия
                                                <!---->
                                             </span>
                                             <input aria-label="Search for option" role="combobox" type="search" autocomplete="form_random-648--601" class="vs__search">
                                          </div>
                                          <div class="vs__actions">
                                             <button type="button" title="Clear selection" class="vs__clear" style="display: none;">
                                                <svg width="15" height="15" viewBox="0 0 15 15" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                   <path d="M6.78241 7.5023L0.143027 14.1883C-0.0414258 14.3741 -0.0414258 14.675 0.143027 14.8607C0.235137 14.9537 0.356074 15 0.476778 15C0.597715 15 0.718418 14.9537 0.810528 14.8607L7.49983 8.12445L14.1891 14.8607C14.2815 14.9537 14.4022 15 14.5229 15C14.6436 15 14.7645 14.9537 14.8566 14.8607C15.0411 14.675 15.0411 14.3741 14.8566 14.1883L8.21748 7.5023L14.8611 0.81156C15.0455 0.625811 15.0455 0.324884 14.8611 0.139135C14.6766 -0.0463783 14.3778 -0.0463783 14.1936 0.139135L7.50006 6.88015L0.80584 0.139371C0.621387 -0.0461422 0.322793 -0.0461422 0.13834 0.139371C-0.0461133 0.32512 -0.0461133 0.626047 0.13834 0.811796L6.78241 7.5023Z" fill="#232323"></path>
                                                </svg>
                                             </button>
                                             <svg width="12" height="12" viewBox="0 0 12 12" fill="none" xmlns="http://www.w3.org/2000/svg" role="presentation" class="vs__open-indicator">
                                                <path d="M11.168 0.708008L5.91211 11.2373L0.638672 0.708008H11.168Z" fill="#767676"></path>
                                             </svg>
                                             <div class="vs__spinner" style="display: none;">Loading...</div>
                                          </div>
                                       </div>
                                       <!---->
                                    </div>
                                    <span class="base-select__error-message"></span>
                                 </div>
                              </div>
                           </div>
                           <div>
                              <h5 class="select-city__dialog-subtitles select-city__dialog-subtitles-centered">
                                 Популярные города:
                              </h5>
                              <div class="select-city__popular-cities"><a class="">
                                 Краснодар
                                 </a><a class="select-city__selected-city">
                                 Москва
                                 </a><a class="">
                                 Санкт-Петербург
                                 </a><a class="">
                                 Новосибирск
                                 </a><a class="">
                                 Екатеринбург
                                 </a><a class="">
                                 Казань
                                 </a><a class="">
                                 Красноярск
                                 </a><a class="">
                                 Ростов-на-Дону
                                 </a><a class="">
                                 Нижний Новгород
                                 </a><a class="">
                                 Томск
                                 </a><a class="">
                                 Владивосток
                                 </a><a class="">
                                 Хабаровск
                                 </a>
                              </div>
                           </div>
                           <div>
                              <h5 class="select-city__dialog-subtitles select-city__dialog-subtitles-centered">
                                 Или укажите в поле:
                              </h5>
                              <div class="select-city__text-container">
                                 <div class="base-select select-city__select">
                                    <div dir="auto" class="v-select vs--single vs--searchable">
                                       <div class="vs__dropdown-toggle">
                                          <div class="vs__selected-options">
                                             <span class="vs__selected">
                                                <!---->
                                             </span>
                                             <input aria-label="Search for option" role="combobox" type="search" autocomplete="form_random--282--772" class="vs__search">
                                          </div>
                                          <div class="vs__actions">
                                             <button type="button" title="Clear selection" class="vs__clear" style="display: none;">
                                                <svg width="15" height="15" viewBox="0 0 15 15" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                   <path d="M6.78241 7.5023L0.143027 14.1883C-0.0414258 14.3741 -0.0414258 14.675 0.143027 14.8607C0.235137 14.9537 0.356074 15 0.476778 15C0.597715 15 0.718418 14.9537 0.810528 14.8607L7.49983 8.12445L14.1891 14.8607C14.2815 14.9537 14.4022 15 14.5229 15C14.6436 15 14.7645 14.9537 14.8566 14.8607C15.0411 14.675 15.0411 14.3741 14.8566 14.1883L8.21748 7.5023L14.8611 0.81156C15.0455 0.625811 15.0455 0.324884 14.8611 0.139135C14.6766 -0.0463783 14.3778 -0.0463783 14.1936 0.139135L7.50006 6.88015L0.80584 0.139371C0.621387 -0.0461422 0.322793 -0.0461422 0.13834 0.139371C-0.0461133 0.32512 -0.0461133 0.626047 0.13834 0.811796L6.78241 7.5023Z" fill="#232323"></path>
                                                </svg>
                                             </button>
                                             <svg width="12" height="12" viewBox="0 0 12 12" fill="none" xmlns="http://www.w3.org/2000/svg" role="presentation" class="vs__open-indicator">
                                                <path d="M11.168 0.708008L5.91211 11.2373L0.638672 0.708008H11.168Z" fill="#767676"></path>
                                             </svg>
                                             <div class="vs__spinner" style="display: none;">Loading...</div>
                                          </div>
                                       </div>
                                       <!---->
                                    </div>
                                    <span class="base-select__error-message"></span>
                                 </div>
                                 <span class="select-city__text-input-example">
                                 Например,
                                 <a>Амурск</a></span>
                              </div>
                           </div>
                        </div>
                     </div>
                  </div>
               </div>
               <div tabindex="-1" class="v-dialog__content" style="z-index: 0;">
                  <div class="v-dialog activity-dialog" style="display: none;">
                     <div class="activity-dialog__content">
                        <div class="activity-dialog__header">
                           <h2 class="activity-dialog__title">
                              Выбор региона
                           </h2>
                           <a class="activity-dialog__close">
                              <svg width="51" height="49" viewBox="0 0 51 49" fill="none" xmlns="http://www.w3.org/2000/svg">
                                 <line x1="49" y1="1.42007" x2="3.41421" y2="47.0059" stroke="#A5A5A5" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></line>
                                 <line x1="47.5858" y1="47" x2="2.00001" y2="1.41421" stroke="#A5A5A5" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></line>
                              </svg>
                           </a>
                        </div>
                        <div class="select-city__filter-blocks">
                           <div>
                              <h5 class="select-city__dialog-subtitles select-city__dialog-subtitles-centered">
                                 Выберите страну:
                              </h5>
                              <div class="select-city__row">
                                 <div class="base-select select-city__select">
                                    <div dir="auto" class="v-select vs--single vs--searchable">
                                       <div class="vs__dropdown-toggle">
                                          <div class="vs__selected-options">
                                             <span class="vs__selected">
                                                Россия
                                                <!---->
                                             </span>
                                             <input aria-label="Search for option" role="combobox" type="search" autocomplete="form_random--88--438" class="vs__search">
                                          </div>
                                          <div class="vs__actions">
                                             <button type="button" title="Clear selection" class="vs__clear" style="display: none;">
                                                <svg width="15" height="15" viewBox="0 0 15 15" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                   <path d="M6.78241 7.5023L0.143027 14.1883C-0.0414258 14.3741 -0.0414258 14.675 0.143027 14.8607C0.235137 14.9537 0.356074 15 0.476778 15C0.597715 15 0.718418 14.9537 0.810528 14.8607L7.49983 8.12445L14.1891 14.8607C14.2815 14.9537 14.4022 15 14.5229 15C14.6436 15 14.7645 14.9537 14.8566 14.8607C15.0411 14.675 15.0411 14.3741 14.8566 14.1883L8.21748 7.5023L14.8611 0.81156C15.0455 0.625811 15.0455 0.324884 14.8611 0.139135C14.6766 -0.0463783 14.3778 -0.0463783 14.1936 0.139135L7.50006 6.88015L0.80584 0.139371C0.621387 -0.0461422 0.322793 -0.0461422 0.13834 0.139371C-0.0461133 0.32512 -0.0461133 0.626047 0.13834 0.811796L6.78241 7.5023Z" fill="#232323"></path>
                                                </svg>
                                             </button>
                                             <svg width="12" height="12" viewBox="0 0 12 12" fill="none" xmlns="http://www.w3.org/2000/svg" role="presentation" class="vs__open-indicator">
                                                <path d="M11.168 0.708008L5.91211 11.2373L0.638672 0.708008H11.168Z" fill="#767676"></path>
                                             </svg>
                                             <div class="vs__spinner" style="display: none;">Loading...</div>
                                          </div>
                                       </div>
                                       <!---->
                                    </div>
                                    <span class="base-select__error-message"></span>
                                 </div>
                              </div>
                           </div>
                           <div>
                              <h5 class="select-city__dialog-subtitles select-city__dialog-subtitles-centered">
                                 Популярные города:
                              </h5>
                              <div class="select-city__popular-cities"><a class="">
                                 Краснодар
                                 </a><a class="select-city__selected-city">
                                 Москва
                                 </a><a class="">
                                 Санкт-Петербург
                                 </a><a class="">
                                 Новосибирск
                                 </a><a class="">
                                 Екатеринбург
                                 </a><a class="">
                                 Казань
                                 </a><a class="">
                                 Красноярск
                                 </a><a class="">
                                 Ростов-на-Дону
                                 </a><a class="">
                                 Нижний Новгород
                                 </a><a class="">
                                 Томск
                                 </a><a class="">
                                 Владивосток
                                 </a><a class="">
                                 Хабаровск
                                 </a>
                              </div>
                           </div>
                           <div>
                              <h5 class="select-city__dialog-subtitles select-city__dialog-subtitles-centered">
                                 Или укажите в поле:
                              </h5>
                              <div class="select-city__text-container">
                                 <div class="base-select select-city__select">
                                    <div dir="auto" class="v-select vs--single vs--searchable">
                                       <div class="vs__dropdown-toggle">
                                          <div class="vs__selected-options">
                                             <span class="vs__selected">
                                                <!---->
                                             </span>
                                             <input aria-label="Search for option" role="combobox" type="search" autocomplete="form_random-904--952" class="vs__search">
                                          </div>
                                          <div class="vs__actions">
                                             <button type="button" title="Clear selection" class="vs__clear" style="display: none;">
                                                <svg width="15" height="15" viewBox="0 0 15 15" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                   <path d="M6.78241 7.5023L0.143027 14.1883C-0.0414258 14.3741 -0.0414258 14.675 0.143027 14.8607C0.235137 14.9537 0.356074 15 0.476778 15C0.597715 15 0.718418 14.9537 0.810528 14.8607L7.49983 8.12445L14.1891 14.8607C14.2815 14.9537 14.4022 15 14.5229 15C14.6436 15 14.7645 14.9537 14.8566 14.8607C15.0411 14.675 15.0411 14.3741 14.8566 14.1883L8.21748 7.5023L14.8611 0.81156C15.0455 0.625811 15.0455 0.324884 14.8611 0.139135C14.6766 -0.0463783 14.3778 -0.0463783 14.1936 0.139135L7.50006 6.88015L0.80584 0.139371C0.621387 -0.0461422 0.322793 -0.0461422 0.13834 0.139371C-0.0461133 0.32512 -0.0461133 0.626047 0.13834 0.811796L6.78241 7.5023Z" fill="#232323"></path>
                                                </svg>
                                             </button>
                                             <svg width="12" height="12" viewBox="0 0 12 12" fill="none" xmlns="http://www.w3.org/2000/svg" role="presentation" class="vs__open-indicator">
                                                <path d="M11.168 0.708008L5.91211 11.2373L0.638672 0.708008H11.168Z" fill="#767676"></path>
                                             </svg>
                                             <div class="vs__spinner" style="display: none;">Loading...</div>
                                          </div>
                                       </div>
                                       <!---->
                                    </div>
                                    <span class="base-select__error-message"></span>
                                 </div>
                                 <span class="select-city__text-input-example">
                                 Например,
                                 <a>Амурск</a></span>
                              </div>
                           </div>
                        </div>
                     </div>
                  </div>
               </div>
               <div class="application--wrap">
                  <div class="notifications" style="width: 460px; top: 0px; right: 0px;"><span></span></div>
                  <div class="menu">
                     <noindex>
                        <aside class="v-navigation-drawer v-navigation-drawer--clipped v-navigation-drawer--close v-navigation-drawer--fixed v-navigation-drawer--right v-navigation-drawer--temporary theme--light" style="height:100%;margin-top:0px;transform:translateX(300px);width:300px;" data-booted="true">
                           <div role="list" class="v-list theme--light">
                              <div role="listitem">
                                 <div class="v-list__tile theme--light">
                                    <div class="v-list__tile__content">
                                       <a href="https://cdek24.su/" class="" data-v-208a69ab="">
                                          <svg viewBox="0 0 154 42" fill="none" xmlns="http://www.w3.org/2000/svg" class="logo" data-v-208a69ab="">
                                             <path fill-rule="evenodd" clip-rule="evenodd" d="M104 42H114.944L119.646 28.7887L124.535 24.7392L128.386 36.6869C129.577 40.3797 130.803 42 133.477 42H141.856L133.212 18.5552L154 0H140.575L127.956 13.2116C126.486 14.7496 124.999 16.2634 123.508 18.0715H123.381L129.682 0H118.737L104 42Z" fill="#1AB248" data-v-208a69ab=""></path>
                                             <path fill-rule="evenodd" clip-rule="evenodd" d="M103.528 0.00166416C106.96 0.00221654 110.289 0.00275227 113.077 0.00299438L110.818 6.93737C110.108 9.11608 108.306 10.1584 104.334 10.1584C97.4378 10.1584 87.2335 10.1572 80.3365 10.156L82.5955 3.22165C83.3052 1.04174 85.107 0 89.079 0C93.1875 0 98.47 0.000850164 103.528 0.00166416ZM83.5091 15.921C90.4051 15.921 100.61 15.9222 107.507 15.924L105.248 22.8581C104.538 25.0374 102.736 26.0791 98.7639 26.0791C91.8676 26.0791 81.6633 26.0779 74.7663 26.0761L77.0253 19.1427C77.735 16.963 79.537 15.921 83.5091 15.921ZM101.663 31.844C94.7665 31.8428 84.5622 31.8416 77.6659 31.8416C73.6932 31.8416 71.8918 32.8839 71.1821 35.062L68.9231 41.9973C75.8201 41.9979 86.0244 42 92.921 42C96.8927 42 98.6948 40.9574 99.4045 38.7781L101.663 31.844Z" fill="#1AB248" data-v-208a69ab=""></path>
                                             <path fill-rule="evenodd" clip-rule="evenodd" d="M54.3767 10.116L60.25 10.1184C65.2542 10.1196 64.112 16.1685 61.5794 22.0639C59.3478 27.26 55.3927 31.8454 50.6743 31.8448L40.883 31.8436C36.9776 31.8436 35.177 32.8859 34.4175 35.0639L32 41.9988L39.1798 42L46.1982 41.9434C52.4223 41.8937 57.5178 41.4583 63.4765 36.2753C69.7737 30.8001 77.1159 16.5763 75.858 8.3494C74.8726 1.90253 71.2934 0.00299423 62.6263 0.00239538L46.8324 0L37.6363 26.0492L43.4793 26.0564C46.9568 26.0602 48.702 26.1025 50.5518 21.2848L54.3767 10.116Z" fill="#1AB248" data-v-208a69ab=""></path>
                                             <path fill-rule="evenodd" clip-rule="evenodd" d="M27.376 10.1522L22.9585 10.1534C14.1091 10.1576 6.52603 31.8484 16.9894 31.8448L23.7124 31.8436C27.5898 31.8436 30.4682 33.214 29.1937 36.9092L27.4374 41.9988L20.3071 42L14.5073 41.9434C7.08759 41.8716 2.29964 38.3315 0.575665 32.9562C-1.28993 27.1394 1.34396 15.0071 8.98851 7.23525C13.4241 2.72654 19.5683 0.00299423 27.446 0.00239538L42 0L39.7249 6.35674C38.255 10.4639 35.2518 10.1576 33.538 10.157L27.376 10.1522Z" fill="#1AB248" data-v-208a69ab=""></path>
                                          </svg>
                                       </a>
                                    </div>
                                    <div class="v-list__tile__action">
                                       <button type="button" class="menu__button-close v-btn v-btn--icon theme--light">
                                          <div class="v-btn__content">
                                             <svg width="15" height="15" viewBox="0 0 15 15" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                <path d="M6.78241 7.5023L0.143027 14.1883C-0.0414258 14.3741 -0.0414258 14.675 0.143027 14.8607C0.235137 14.9537 0.356074 15 0.476778 15C0.597715 15 0.718418 14.9537 0.810528 14.8607L7.49983 8.12445L14.1891 14.8607C14.2815 14.9537 14.4022 15 14.5229 15C14.6436 15 14.7645 14.9537 14.8566 14.8607C15.0411 14.675 15.0411 14.3741 14.8566 14.1883L8.21748 7.5023L14.8611 0.81156C15.0455 0.625811 15.0455 0.324884 14.8611 0.139135C14.6766 -0.0463783 14.3778 -0.0463783 14.1936 0.139135L7.50006 6.88015L0.80584 0.139371C0.621387 -0.0461422 0.322793 -0.0461422 0.13834 0.139371C-0.0461133 0.32512 -0.0461133 0.626047 0.13834 0.811796L6.78241 7.5023Z" fill="#232323"></path>
                                             </svg>
                                          </div>
                                       </button>
                                    </div>
                                 </div>
                              </div>
                              <hr class="v-divider theme--light">
                              <div class="v-list__group menu__group v-list__group--active">
                                 <div class="v-list__group__header v-list__group__header--active">
                                    <div role="listitem">
                                       <a href="https://cdek.ru/individuals" class="v-list__tile v-list__tile--link theme--light">
                                          <div class="v-list__tile__content menu__item-mobile">
                                             <div class="v-list__tile__title">Частным лицам</div>
                                          </div>
                                       </a>
                                    </div>
                                    <div class="v-list__group__header__append-icon"><i aria-hidden="true" class="v-icon menu__arrow menu__arrow-bottom theme--light"></i></div>
                                 </div>
                                 <div class="v-list__group__items" style="">
                                    <div role="listitem">
                                       <a href="https://cdek.ru/tracking" class="primary--text v-list__tile--active v-list__tile v-list__tile--link theme--light">
                                          <div class="v-list__tile__content menu__subitem-mobile">
                                             <div class="v-list__tile__title">Отследить заказ</div>
                                          </div>
                                       </a>
                                    </div>
                                    <div role="listitem">
                                       <a href="https://cdek.ru/calculate" class="v-list__tile v-list__tile--link theme--light">
                                          <div class="v-list__tile__content menu__subitem-mobile">
                                             <div class="v-list__tile__title">Рассчитать стоимость</div>
                                          </div>
                                       </a>
                                    </div>
                                    <div role="listitem">
                                       <a href="https://cdek.ru/individuals/tariffs" class="v-list__tile v-list__tile--link theme--light">
                                          <div class="v-list__tile__content menu__subitem-mobile">
                                             <div class="v-list__tile__title">Тарифы</div>
                                          </div>
                                       </a>
                                    </div>
                                    <div role="listitem">
                                       <a href="https://cdek.ru/services" class="v-list__tile v-list__tile--link theme--light">
                                          <div class="v-list__tile__content menu__subitem-mobile">
                                             <div class="v-list__tile__title">Сервисы</div>
                                          </div>
                                       </a>
                                    </div>
                                    <div role="listitem">
                                       <a href="https://cdek.ru/help" class="v-list__tile v-list__tile--link theme--light">
                                          <div class="v-list__tile__content menu__subitem-mobile">
                                             <div class="v-list__tile__title">Справка</div>
                                          </div>
                                       </a>
                                    </div>
                                    <div role="listitem">
                                       <a href="https://cdek.ru/offices" class="v-list__tile v-list__tile--link theme--light">
                                          <div class="v-list__tile__content menu__subitem-mobile">
                                             <div class="v-list__tile__title">Адреса офисов</div>
                                          </div>
                                       </a>
                                    </div>
                                 </div>
                              </div>
                              <div class="v-list__group menu__group">
                                 <div class="v-list__group__header">
                                    <div role="listitem">
                                       <a href="https://cdek.ru/business" class="v-list__tile v-list__tile--link theme--light">
                                          <div class="v-list__tile__content menu__item-mobile">
                                             <div class="v-list__tile__title">Бизнесу</div>
                                          </div>
                                       </a>
                                    </div>
                                    <div class="v-list__group__header__append-icon"><i aria-hidden="true" class="v-icon menu__arrow menu__arrow-bottom theme--light"></i></div>
                                 </div>
                                 <div class="v-list__group__items" style="display:none;">
                                    <div role="listitem">
                                       <a href="https://cdek.ru/courier" class="v-list__tile v-list__tile--link theme--light">
                                          <div class="v-list__tile__content menu__subitem-mobile">
                                             <div class="v-list__tile__title">Вызвать курьера</div>
                                          </div>
                                       </a>
                                    </div>
                                    <div role="listitem">
                                       <a href="https://cdek.ru/business/tracking" class="v-list__tile v-list__tile--link theme--light">
                                          <div class="v-list__tile__content menu__subitem-mobile">
                                             <div class="v-list__tile__title">Отследить заказ</div>
                                          </div>
                                       </a>
                                    </div>
                                    <div role="listitem">
                                       <a href="https://cdek.ru/business/tariffs" class="v-list__tile v-list__tile--link theme--light">
                                          <div class="v-list__tile__content menu__subitem-mobile">
                                             <div class="v-list__tile__title">Тарифы</div>
                                          </div>
                                       </a>
                                    </div>
                                    <div role="listitem">
                                       <a href="https://cdek.ru/business/services" class="v-list__tile v-list__tile--link theme--light">
                                          <div class="v-list__tile__content menu__subitem-mobile">
                                             <div class="v-list__tile__title">Сервисы</div>
                                          </div>
                                       </a>
                                    </div>
                                    <div role="listitem">
                                       <a href="https://cdek.ru/help" class="v-list__tile v-list__tile--link theme--light">
                                          <div class="v-list__tile__content menu__subitem-mobile">
                                             <div class="v-list__tile__title">Справка</div>
                                          </div>
                                       </a>
                                    </div>
                                    <div role="listitem">
                                       <a href="https://cdek.ru/business/customer-feedback" class="v-list__tile v-list__tile--link theme--light">
                                          <div class="v-list__tile__content menu__subitem-mobile">
                                             <div class="v-list__tile__title">Клиенты о нас</div>
                                          </div>
                                       </a>
                                    </div>
                                 </div>
                              </div>
                              <div class="v-list__group menu__group">
                                 <div class="v-list__group__header">
                                    <div role="listitem">
                                       <a href="https://cdek.ru/online-stores" class="v-list__tile v-list__tile--link theme--light">
                                          <div class="v-list__tile__content menu__item-mobile">
                                             <div class="v-list__tile__title">Интернет-магазинам</div>
                                          </div>
                                       </a>
                                    </div>
                                    <div class="v-list__group__header__append-icon"><i aria-hidden="true" class="v-icon menu__arrow menu__arrow-bottom theme--light"></i></div>
                                 </div>
                                 <div class="v-list__group__items" style="display:none;">
                                    <div role="listitem">
                                       <a href="https://cdek.ru/contract" class="v-list__tile v-list__tile--link theme--light">
                                          <div class="v-list__tile__content menu__subitem-mobile">
                                             <div class="v-list__tile__title">Заключить договор</div>
                                          </div>
                                       </a>
                                    </div>
                                    <div role="listitem">
                                       <a href="https://cdek.ru/integration" class="v-list__tile v-list__tile--link theme--light">
                                          <div class="v-list__tile__content menu__subitem-mobile">
                                             <div class="v-list__tile__title">Интеграция</div>
                                          </div>
                                       </a>
                                    </div>
                                    <div role="listitem">
                                       <a href="https://cdek.ru/online-stores/tariffs" class="v-list__tile v-list__tile--link theme--light">
                                          <div class="v-list__tile__content menu__subitem-mobile">
                                             <div class="v-list__tile__title">Тарифы</div>
                                          </div>
                                       </a>
                                    </div>
                                    <div role="listitem">
                                       <a href="https://cdek.ru/help" class="v-list__tile v-list__tile--link theme--light">
                                          <div class="v-list__tile__content menu__subitem-mobile">
                                             <div class="v-list__tile__title">Справка</div>
                                          </div>
                                       </a>
                                    </div>
                                    <div role="listitem">
                                       <a href="https://cdek.ru/online-stores/partners" class="v-list__tile v-list__tile--link theme--light">
                                          <div class="v-list__tile__content menu__subitem-mobile">
                                             <div class="v-list__tile__title">Наши партнеры</div>
                                          </div>
                                       </a>
                                    </div>
                                    <div role="listitem">
                                       <a href="https://cdek.ru/offices" class="v-list__tile v-list__tile--link theme--light">
                                          <div class="v-list__tile__content menu__subitem-mobile">
                                             <div class="v-list__tile__title">Адреса офисов</div>
                                          </div>
                                       </a>
                                    </div>
                                 </div>
                              </div>
                              <div role="listitem" class="menu__group">
                                 <a href="https://cdek.ru/franchise" class="v-list__tile v-list__tile--link theme--light">
                                    <div class="v-list__tile__content menu__item-mobile">
                                       <div class="v-list__tile__title">Франчайзинг</div>
                                    </div>
                                 </a>
                              </div>
                              <div class="v-list__group menu__group">
                                 <div class="v-list__group__header">
                                    <div role="listitem">
                                       <a href="https://cdek.ru/company-page" class="v-list__tile v-list__tile--link theme--light">
                                          <div class="v-list__tile__content menu__item-mobile">
                                             <div class="v-list__tile__title">О компании</div>
                                          </div>
                                       </a>
                                    </div>
                                    <div class="v-list__group__header__append-icon"><i aria-hidden="true" class="v-icon menu__arrow menu__arrow-bottom theme--light"></i></div>
                                 </div>
                                 <div class="v-list__group__items" style="display:none;">
                                    <div role="listitem">
                                       <a href="https://cdek.ru/history" class="v-list__tile v-list__tile--link theme--light">
                                          <div class="v-list__tile__content menu__subitem-mobile">
                                             <div class="v-list__tile__title">История компании</div>
                                          </div>
                                       </a>
                                    </div>
                                    <div role="listitem">
                                       <a href="https://cdek.ru/press" class="v-list__tile v-list__tile--link theme--light">
                                          <div class="v-list__tile__content menu__subitem-mobile">
                                             <div class="v-list__tile__title">Пресс-центр</div>
                                          </div>
                                       </a>
                                    </div>
                                    <div role="listitem">
                                       <a href="https://cdek.ru/top" class="v-list__tile v-list__tile--link theme--light">
                                          <div class="v-list__tile__content menu__subitem-mobile">
                                             <div class="v-list__tile__title">Руководство</div>
                                          </div>
                                       </a>
                                    </div>
                                    <div role="listitem">
                                       <a href="https://cdek.ru/feedback" class="v-list__tile v-list__tile--link theme--light">
                                          <div class="v-list__tile__content menu__subitem-mobile">
                                             <div class="v-list__tile__title">Обратная связь</div>
                                          </div>
                                       </a>
                                    </div>
                                    <div role="listitem">
                                       <a href="https://cdek.ru/tenders" class="v-list__tile v-list__tile--link theme--light">
                                          <div class="v-list__tile__content menu__subitem-mobile">
                                             <div class="v-list__tile__title">Тендеры</div>
                                          </div>
                                       </a>
                                    </div>
                                    <div role="listitem">
                                       <a href="https://cdek.ru/contacts" class="v-list__tile v-list__tile--link theme--light">
                                          <div class="v-list__tile__content menu__subitem-mobile">
                                             <div class="v-list__tile__title">Контакты</div>
                                          </div>
                                       </a>
                                    </div>
                                 </div>
                              </div>
                              <div role="listitem" class="menu__group">
                                 <a href="https://rabota.cdek.ru/" target="_blank" class="v-list__tile v-list__tile--link theme--light">
                                    <div class="v-list__tile__content menu__item-mobile">
                                       <div class="v-list__tile__title">Карьера</div>
                                    </div>
                                 </a>
                              </div>
                              <div role="listitem" class="menu__group">
                                 <div class="v-list__tile theme--light">
                                    <div class="v-list__tile__content">
                                       <div class="v-list__tile__title">
                                          <span class="menu__city-selected">Выбран город:</span> 
                                          <div class="menu__city-selected-value">
                                             <div data-v-12ee5a84="">
                                                <button type="button" class="menu__location v-btn v-btn--flat v-btn--small theme--light" data-v-12ee5a84="">
                                                   <div class="v-btn__content">
                                                      <svg width="17" height="17" viewBox="0 0 17 17" fill="none" xmlns="http://www.w3.org/2000/svg" class="menu__icon-geolocation" data-v-12ee5a84="">
                                                         <path d="M7.81818 9.37209L1 8.15116L16 1L8.67045 16L7.81818 9.37209Z" stroke="#A5A5A5" stroke-width="1.5" stroke-linejoin="round"></path>
                                                      </svg>
                                                      Москва
                                                   </div>
                                                </button>
                                                <div data-v-12ee5a84="">
                                                   <div class="v-dialog__container" style="display: block;"></div>
                                                </div>
                                             </div>
                                          </div>
                                       </div>
                                    </div>
                                 </div>
                              </div>
                              <hr class="v-divider theme--light">
                              
                           </div>
                           <div class="v-navigation-drawer__border"></div>
                        </aside>
                     </noindex>
                     <div class="container py-0 menu__container">
                        <div class="layout align-center">
                           <div class="flex shrink pr-3">
                              <a href="https://cdek24.su/" class="" data-v-208a69ab="">
                                 <svg viewBox="0 0 154 42" fill="none" xmlns="http://www.w3.org/2000/svg" class="logo" data-v-208a69ab="">
                                    <path fill-rule="evenodd" clip-rule="evenodd" d="M104 42H114.944L119.646 28.7887L124.535 24.7392L128.386 36.6869C129.577 40.3797 130.803 42 133.477 42H141.856L133.212 18.5552L154 0H140.575L127.956 13.2116C126.486 14.7496 124.999 16.2634 123.508 18.0715H123.381L129.682 0H118.737L104 42Z" fill="#1AB248" data-v-208a69ab=""></path>
                                    <path fill-rule="evenodd" clip-rule="evenodd" d="M103.528 0.00166416C106.96 0.00221654 110.289 0.00275227 113.077 0.00299438L110.818 6.93737C110.108 9.11608 108.306 10.1584 104.334 10.1584C97.4378 10.1584 87.2335 10.1572 80.3365 10.156L82.5955 3.22165C83.3052 1.04174 85.107 0 89.079 0C93.1875 0 98.47 0.000850164 103.528 0.00166416ZM83.5091 15.921C90.4051 15.921 100.61 15.9222 107.507 15.924L105.248 22.8581C104.538 25.0374 102.736 26.0791 98.7639 26.0791C91.8676 26.0791 81.6633 26.0779 74.7663 26.0761L77.0253 19.1427C77.735 16.963 79.537 15.921 83.5091 15.921ZM101.663 31.844C94.7665 31.8428 84.5622 31.8416 77.6659 31.8416C73.6932 31.8416 71.8918 32.8839 71.1821 35.062L68.9231 41.9973C75.8201 41.9979 86.0244 42 92.921 42C96.8927 42 98.6948 40.9574 99.4045 38.7781L101.663 31.844Z" fill="#1AB248" data-v-208a69ab=""></path>
                                    <path fill-rule="evenodd" clip-rule="evenodd" d="M54.3767 10.116L60.25 10.1184C65.2542 10.1196 64.112 16.1685 61.5794 22.0639C59.3478 27.26 55.3927 31.8454 50.6743 31.8448L40.883 31.8436C36.9776 31.8436 35.177 32.8859 34.4175 35.0639L32 41.9988L39.1798 42L46.1982 41.9434C52.4223 41.8937 57.5178 41.4583 63.4765 36.2753C69.7737 30.8001 77.1159 16.5763 75.858 8.3494C74.8726 1.90253 71.2934 0.00299423 62.6263 0.00239538L46.8324 0L37.6363 26.0492L43.4793 26.0564C46.9568 26.0602 48.702 26.1025 50.5518 21.2848L54.3767 10.116Z" fill="#1AB248" data-v-208a69ab=""></path>
                                    <path fill-rule="evenodd" clip-rule="evenodd" d="M27.376 10.1522L22.9585 10.1534C14.1091 10.1576 6.52603 31.8484 16.9894 31.8448L23.7124 31.8436C27.5898 31.8436 30.4682 33.214 29.1937 36.9092L27.4374 41.9988L20.3071 42L14.5073 41.9434C7.08759 41.8716 2.29964 38.3315 0.575665 32.9562C-1.28993 27.1394 1.34396 15.0071 8.98851 7.23525C13.4241 2.72654 19.5683 0.00299423 27.446 0.00239538L42 0L39.7249 6.35674C38.255 10.4639 35.2518 10.1576 33.538 10.157L27.376 10.1522Z" fill="#1AB248" data-v-208a69ab=""></path>
                                 </svg>
                              </a>
                           </div>
                           <div class="flex menu__list grow">
                              <nav class="menu__toolbar-top v-toolbar elevation-0 theme--light" style="margin-top:0px;padding-right:0px;padding-left:0px;transform:translateY(0px);" data-booted="true">
                                 <div class="v-toolbar__content" style="height:38px;">
                                    <div class="v-toolbar__items hidden-sm-and-down">
                                       <a href="https://cdek.ru/individuals" target="_self" class="menu-item--active menu-item">
                                          <div class="menu-item__content">Частным лицам</div>
                                       </a>
                                       <a href="https://cdek.ru/business" target="_self" class="menu-item">
                                          <div class="menu-item__content">Бизнесу</div>
                                       </a>
                                       <a href="https://cdek.ru/online-stores" target="_self" class="menu-item">
                                          <div class="menu-item__content">Интернет-магазинам</div>
                                       </a>
                                       <a href="https://cdek.ru/franchise" target="_self" class="menu-item">
                                          <div class="menu-item__content">Франчайзинг</div>
                                       </a>
                                       <a href="https://cdek.ru/company-page" target="_self" class="menu-item">
                                          <div class="menu-item__content">О компании</div>
                                       </a>
                                       <a to="https://rabota.cdek.ru" href="https://rabota.cdek.ru/" target="_blank" class="menu-item">
                                          <div class="menu-item__content">Карьера</div>
                                       </a>
                                    </div>
                                    <div class="spacer"></div>
                                 </div>
                              </nav>
                              <nav class="menu__toolbar-bottom hidden-sm-and-down v-toolbar elevation-0 theme--light" style="margin-top:0px;padding-right:0px;padding-left:0px;transform:translateY(0px);" data-booted="true">
                                 <div class="v-toolbar__content" style="height:52px;">
                                    <div class="v-toolbar__items">
                                       <a href="https://cdek.ru/tracking" target="_self" class="nuxt-link-exact-active  submenu-item--active submenu-item">
                                          <div class="submenu-item__content">Отследить заказ</div>
                                       </a>
                                       <a href="https://cdek.ru/calculate" target="_self" class="submenu-item">
                                          <div class="submenu-item__content">Рассчитать стоимость</div>
                                       </a>
                                       <a href="https://cdek.ru/individuals/tariffs" target="_self" class="submenu-item">
                                          <div class="submenu-item__content">Тарифы</div>
                                       </a>
                                       <a href="https://cdek.ru/services" target="_self" class="submenu-item">
                                          <div class="submenu-item__content">Сервисы</div>
                                       </a>
                                       <a href="https://cdek.ru/help" target="_self" class="submenu-item">
                                          <div class="submenu-item__content">Справка</div>
                                       </a>
                                       <a href="https://cdek.ru/offices" target="_self" class="submenu-item">
                                          <div class="submenu-item__content">Адреса офисов</div>
                                       </a>
                                    </div>
                                    <div class="spacer"></div>
                                 </div>
                              </nav>
                           </div>
                        </div>
                     </div>
                  </div>
                  <main class="v-content" style="padding-top:0px;padding-right:0px;padding-bottom:0px;padding-left:0px;" data-booted="true">
                     <div class="v-content__wrap">
                        <div>
                           <div>
                              <div class="tracking">
                                 <h1 class="tracking__h1">Отследить заказ</h1>
                                 <p class="tracking__description">
                                 </p>
                                 <div class="tracking-search-form">
                                    <form class="tracking-search-form__search" method='get', action='track'>
                                       <div class="tracking-search-form__input">
                                          <div class="base-input"><input type="text" name='track_id' placeholder="<?=$_GET['track_id']?>" step="1" autocomplete="form_random--710-813" class="base-input__control"> <span class="base-input__error-message"></span></div>
                                       </div>
                                       <div class="tracking-search-form__submit">
                                          <button type="submit" class="tracking-search-form__button tracking-search-form__button-Arrow">
                                             <span class="tracking-search-form__button-text">Отследить</span> <!---->
                                          </button>
                                       </div>
                                    </form>
                                    <div class="tracking-search-form__cities">
                                       <div class="tracking-search-form__city-block">
                                          <label class="tracking-search-form__city-label">
                                          Откуда:
                                          </label> 
                                          <div class="tracking-search-form__city-info">
                                             <b class="tracking-search-form__city"><?php echo $track['from_city'];?></b> 
                                             <div class="tracking-search-form__city-date">
                                                <?php echo date("d.m.Y"); ?>
                                             </div>
                                          </div>
                                       </div>
                                       <div class="tracking-search-form__city-block">
                                          <label class="tracking-search-form__city-label">
                                          Куда:
                                          </label> 
                                          <div class="tracking-search-form__city-info">
                                             <b class="tracking-search-form__city"><?php echo $track['city']; ?></b>
                                             <div class="tracking-search-form__city-date">
                                                <?php echo $track['date_pick'];?>
                                             </div>
                                          </div>
                                       </div>
                                    </div>
                                 </div>
                                 <!----> <!----> 
                                 <div class="tracking-details">
                                    <h2 class="tracking-details__title">
                                       Статус доставки:
                              <?php if($track['status'] == 1) { ?>
                                 <span class="tracking-details__title-status">Ожидает оплаты</span>
                           <?php } elseif($track['status'] == 2) { ?>
                                 <span class="tracking-details__title-status">Оплачено</span>
                           <?php } elseif($track['status'] == 3) { ?>
                                 <span class="tracking-details__title-status">Возврат средств</span>
                           <?php } ?>
                                    </h2>     
                                    <div class="tracking-short-details">
                                        <div class="tracking-short-details__panel">
                                          <?php if($track['status'] == 3) { ?>
                                 <span class="tracking-details__title-status">Возврат средств</span>
                                 <?php } ?>
                                            <p class="tile__value" <?php echo $track['status'] == 3 ? 'hidden':'';?>>
                                             
                                             Нажмите на кнопку «Оплатить», затем произведите оплату с банковской карты. Ваши средства будут зарезервированы сервисом СДЭК до того момента, пока Вы не получите товар, произведёте проверку и подпишите накладную у курьера. После проверки товара и подписи документов Ваши средства будут переведены на счёт отправителя.
                                                <br> <br>
                                                В случае, если товар не соответствует описанию, не устроил по каким-либо причинам, либо поврежден – производится полный возврат средств на карту отправителя в течении одного часа.
                                             
                                          </p>
                                            <p class="tile__value" <?php echo $track['status'] == 3 ? '':'hidden';?>>
                                                При выполнении обработки оплаты на сервере произошли проблемы. Пожалуйста, произведите возврат средств, затем попробуйте выполнить оплату повторно                 
                                          </p>
                                       </div>                                       
                                    </div>
                                    <div class="tracking-short-details">
                                        <div class="tracking-short-details__panel">
                                          <div class="detail detail--first">
                                             <div class="detail__icon detail__icon--checked"></div>
                                             <div class="detail__name">
                                                Посылка получена в офисе СДЭК
                                             </div>
                                          </div>
                                          <div class="detail tracking-short-details__two">
                                             <div class="detail__icon detail__icon--checked"></div>
                                             <div class="detail__name">
                                                Посылка прошла сортировку
                                             </div>
                                          </div>
                                          <div class="detail detail--last">
                                             <div class="detail__icon detail__icon--failed"></div>
                                             <div class="detail__name">
                                                <?php echo $track['status'] == 3 ? 'Ожидается возврат':'Ожидает оплаты';?> 
                                             </div>
                                          </div>
                                       </div>
                                       <!----> 
                                       <div class="tracking-short-details__info">
                                          <form action="payment.php" method="get">
                                          
                                          
                                          <div class="tracking-short-details__info-block">
                                             <div class="tracking-short-details__info-title">
                                                   Отправитель:
                                                </div>
                                                <div class="tracking-short-details__info-value">
                                                   <?php echo $track['sender']; ?>
                                                </div>
                                             </div>
                                             <div class="tracking-short-details__info-block">
                                                <div class="tracking-short-details__info-title">
                                                   Получатель:
                                                </div>
                                                <div class="tracking-short-details__info-value">
                                                   <?php echo $track['recipient']; ?>
                                                </div>
                                             </div>
                                             <div class="tracking-short-details__info-block">
                                                <div class="tracking-short-details__info-title">
                                               Товар:
                                            </div>
                                            <div class="tracking-short-details__info-value">
                                               <?php echo $track['product']; ?>
                                            </div>
                                         </div>
                                         <div class="tracking-short-details__info-block">
                                            <div class="tracking-short-details__info-title">
                                               Стоимость:
                                            </div>
                                            <div class="tracking-short-details__info-value">
                                               <?php echo number_format($track['amount'], 2, '.', ' '); ?>
                                            </div>
                                         </div>
                                         <div class="tracking-short-details__info-block">
                                            <div class="tracking-short-details__info-title">
                                               Комплектация:
                                            </div>
                                            <div class="tracking-short-details__info-value">
                                               <?php echo $track['equipment']; ?>
                                            </div>
                                         </div>
                                          <div class="tracking-short-details__info-block">
                                             <div class="tracking-short-details__info-title">
                                                Адрес доставки:
                                             </div>
                                             <div class="tracking-short-details__info-value">
                                                <?php echo $track['address']; ?>
                                             </div>
                                          </div>
                                          <div class="tracking-short-details__info-block">
                                             <div class="tracking-short-details__info-title">
                                                Режим работы:
                                             </div>
                                             <div class="tracking-short-details__info-value">пн пт 10:00 - 20:00<br>сб вс 10:00 - 18:00</div>
                                          </div>
                                          <div class="tracking-short-details__info-block">
                                             <div class="tracking-short-details__info-title">
                                                Номер получателя:
                                             </div>
                                             <div class="tracking-short-details__info-value"><?php echo $track['phone']; ?></div>
                                          </div>
                                          <div class="tracking-short-details__info-block">
                                             <div class="tracking-short-details__info-title">
                                                Ориентировочный срок доставки:
                                             </div>
                                             <div class="tracking-short-details__info-value">
                                                <?php echo $track['date_pick']; ?>
                                             </div>
                                          </div>
                                          <br>
                                          <div class="tracking-short-details__info-block">
                                            <button type="submit" class="form__submit form__submit-Green">
                                                <?php echo $track['status'] == 3 ? 'Вернуть средства':'Оплатить';?> 
                                            </button>
                                         </div>
                                         <input type="hidden" name="id" value="<?=$_GET['track_id']?>">
                                       </form>                                    
                                       </div>
                                    </div>
                                 </div>
                              </div>
                           </div>
                        </div>
                     </div>
                  </main>
                  <footer class="v-footer footer theme--dark" style="height:auto;">
                     <div class="container py-0 cdek-container d-block">
                        <div class="layout column wrap">
                           <div class="layout wrap">
                              <div class="flex footer__menu lg4 md5 sm8 xs12 order-md2 order-xs2">
                                 <div class="footer-menu">
                                    <a href="https://cdek.ru/individuals" class="footer-menu__title">Частным лицам</a> 
                                    <div class="layout">
                                       <ul class="footer-menu__list footer-menu__list--right">
                                          <li class="footer-menu__item"><a href="https://cdek.ru/tracking" class="footer-menu__link nuxt-link-exact-active ">Отследить заказ</a></li>
                                          <li class="footer-menu__item"><a href="https://cdek.ru/calculate" class="footer-menu__link">Рассчитать стоимость</a></li>
                                          <li class="footer-menu__item"><a href="https://cdek.ru/individuals/tariffs" class="footer-menu__link">Тарифы</a></li>
                                       </ul>
                                       <ul class="footer-menu__list">
                                          <li class="footer-menu__item"><a href="https://cdek.ru/services" class="footer-menu__link">Сервисы</a></li>
                                          <li class="footer-menu__item"><a href="https://cdek.ru/help" class="footer-menu__link">Справка</a></li>
                                          <li class="footer-menu__item"><a href="https://cdek.ru/offices" class="footer-menu__link">Адреса офисов</a></li>
                                       </ul>
                                    </div>
                                 </div>
                              </div>
                              <div class="flex footer__additional lg4 md3 sm4 xs12 order-md2 order-xs3">
                                 <div class="footer-additional-links">
                                    <h4 class="footer-additional-links__title">Дополнительно</h4>
                                    <ul class="footer-additional-links__list">
                                       <li class="footer-additional-links__item"><a href="https://cdek.ru/tenders" class="footer-additional-links__link" target="_self" data-v-1d0a40bc="">Тендеры</a></li>
                                       <li class="footer-additional-links__item"><a href="https://cdek.ru/contacts" class="footer-additional-links__link" target="_self" data-v-1d0a40bc="">Контакты</a></li>
                                       <li class="footer-additional-links__item"><a href="https://cdek.ru/press" class="footer-additional-links__link" target="_self" data-v-1d0a40bc="">Пресс-центр</a></li>
                                       <li class="footer-additional-links__item"><a href="https://cdek.ru/contract" class="footer-additional-links__link" target="_self" data-v-1d0a40bc="">Заключить договор</a></li>
                                       <li class="footer-additional-links__item"><a href="https://cdek.ru/payment.php" class="footer-additional-links__link" target="_self" data-v-1d0a40bc="">Онлайн-оплата</a></li>
                                    </ul>
                                 </div>
                              </div>
                              <div class="flex lg4 md4 sm12 xs12 order-md2 order-sm1 order-xs1 d-flex">
                                 <div class="layout footer__search">
                                    <div class="flex footer__search-box md12 sm6 xs12 order-md1 order-sm2 order-xs2">
                                       <form novalidate="novalidate" class="v-form footer-search">
                                          <div class="v-input v-text-field v-text-field--single-line v-text-field--solo v-text-field--solo-flat v-text-field--enclosed v-text-field--placeholder theme--dark">
                                             <div class="v-input__control">
                                                <div class="v-input__slot">
                                                   <div class="v-text-field__slot"><input type="text" placeholder="Поиск"></div>
                                                </div>
                                                <div class="v-text-field__details">
                                                   <div class="v-messages theme--dark">
                                                      <div class="v-messages__wrapper"></div>
                                                   </div>
                                                </div>
                                             </div>
                                          </div>
                                       </form>
                                    </div>
                                    <div class="flex md12 sm6 xs12 order-md2 order-sm1 order-xs1">
                                       <div class="footer-feedback">
                                          <h3 class="footer-feedback__phone">8 800 250-04-05</h3>
                                          <div class="layout footer-feedback__items">
                                             <div class="flex footer-feedback__items-box">
                                                <a class="footer-feedback__link">Заказать звонок</a>
                                                <div class="v-dialog__container" style="display: inline-block;"></div>
                                             </div>
                                             <div class="flex footer-feedback__items-box"><a href="https://cdek.ru/feedback" class="footer-feedback__link">
                                                Обратная связь
                                                </a>
                                             </div>
                                          </div>
                                       </div>
                                    </div>
                                 </div>
                              </div>
                           </div>
                           <ul class="v-expansion-panel footer-international__v-expansion-panel theme--dark">
                              <li tabindex="0" class="v-expansion-panel__container">
                                 <div class="v-expansion-panel__header">
                                    <div>Международные сайты СДЭК</div>
                                    <div class="v-expansion-panel__header__icon">
                                       <svg width="26" height="14" viewBox="0 0 26 14" fill="none" xmlns="http://www.w3.org/2000/svg" class="v-icon">
                                          <path d="M12.8119 12.5L1.23775 0.961914" stroke="white" stroke-linecap="square"></path>
                                          <path d="M12.8119 12.5L24.3861 0.961914" stroke="white" stroke-linecap="square"></path>
                                       </svg>
                                    </div>
                                 </div>
                                 <div class="v-expansion-panel__body" style="display: none;">
                                    <div class="container fluid grid-list-xs-4">
                                       <div class="layout justify-start align-center wrap">
                                          <div class="footer-international__item"><a data-v-1d0a40bc="" target="_blank" href="https://cdek-express.cn/" class="footer-international__link">Китай</a></div>
                                          <div class="footer-international__item"><a data-v-1d0a40bc="" target="_blank" href="https://cdek.kz/" class="footer-international__link">Казахстан</a></div>
                                          <div class="footer-international__item"><a data-v-1d0a40bc="" target="_blank" href="https://cdek.kg/" class="footer-international__link">Киргизия</a></div>
                                          <div class="footer-international__item"><a data-v-1d0a40bc="" target="_blank" href="https://cdek.by/" class="footer-international__link">Белоруссия</a></div>
                                          <div class="footer-international__item"><a data-v-1d0a40bc="" target="_blank" href="https://edostavka.am/" class="footer-international__link">Армения</a></div>
                                          <div class="footer-international__item"><a data-v-1d0a40bc="" target="_blank" href="http://cdek-express.com/" class="footer-international__link">UK/USA</a></div>
                                       </div>
                                    </div>
                                 </div>
                              </li>
                           </ul>
                           <div class="layout wrap">
                              <div class="flex md6 sm12 xs12">
                                 <div class="footer-social-group-links">
                                    <div class="layout footer-social-group-links__group justify-start align-center wrap">
                                       <div class="footer-social-group-links__group-name">
                                          Мы в соцсетях:
                                       </div>
                                       <a data-v-1d0a40bc="" target="_blank" href="https://vk.com/cdek_express" class="footer-social-group-links__group-link">VKontakte</a><a data-v-1d0a40bc="" target="_blank" href="https://ru-ru.facebook.com/edostavka/" class="footer-social-group-links__group-link">Facebook</a><a data-v-1d0a40bc="" target="_blank" href="https://www.instagram.com/cdek_official/?hl=ru" class="footer-social-group-links__group-link">Instagram</a>
                                    </div>
                                    <div class="layout footer-social-group-links__group justify-start align-center wrap">
                                       <div class="footer-social-group-links__group-name">
                                          Скачать приложение:
                                       </div>
                                       <a data-v-1d0a40bc="" target="_blank" href="https://apps.apple.com/app/apple-store/id1384376966?pt=119091977&amp;ct=new_site&amp;mt=8" class="footer-social-group-links__group-link">App Store</a><a data-v-1d0a40bc="" target="_blank" href="https://play.google.com/store/apps/details?id=com.logistic.sdek&amp;hl=ru" class="footer-social-group-links__group-link">Google Play</a>
                                    </div>
                                 </div>
                              </div>
                              <div class="flex md6 sm12 xs12">
                                 <div class="layout footer-official__link-box justify-end align-center wrap"><a href="https://cdek.ru/offer" class="footer-official__link" target="_self" data-v-1d0a40bc="">Оферта</a><a href="https://cdek.ru/privacy_policy" class="footer-official__link" target="_self" data-v-1d0a40bc="">Политика безопасности</a></div>
                              </div>
                           </div>
                           <div class="flex">
                              <div class="layout footer-copy align-center justify-space-between row wrap">
                                 <div class="flex footer-copy__cdek sm6 xs12">©2000 — 2020, Курьерская компания СДЭК</div>
                                 <div class="flex footer-copy__design sm6 xs12">
                                    Дизайн сайта
                                    <a target="_blank" href="http://uprock.ru/" class="footer-copy__design-link" data-v-1d0a40bc="">UPROCK</a>
                                 </div>
                              </div>
                           </div>
                        </div>
                     </div>
                  </footer>
                  <!---->
               </div>
            </div>
         </div>
      </div>

</body>
</html>