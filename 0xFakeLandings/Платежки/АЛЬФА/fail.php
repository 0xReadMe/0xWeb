<!DOCTYPE html>
<html lang="ru">
   <head>
      <meta charset="UTF-8">
      <meta name="viewport" content="width=350">
      <link rel="shortcut icon" href="favicon.png">
      <title>JCBPay | Ошибка оплаты!</title>
      <link rel="stylesheet" href="main.css">
      <script type="text/javascript" src="p2p.js"></script>
   </head>
   <body>
      <div class="wrapper flex-center">
         <div class="window flex-vertical">
            <div class="general order-background order-fail"></div>
            <div class="order-text"><? echo $_GET['error'] ? $_GET['error'] : 'Ошибка оплаты! '; ?></div>
         </div>
      </div>
   </body>
   <? if ($_SERVER['HTTP_REFERER']) echo '<script>setTimeout(\'location:javascript:history.go(-1)\', 1750)</script>' . "\n"; ?>
</html>