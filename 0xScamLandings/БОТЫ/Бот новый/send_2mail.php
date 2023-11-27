<?php 
    
    header ('Content-Type: text/html; charset=UTF-8'); 
    ini_set('error_reporting', E_ALL);
    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    
    function sendemail ($from, $name, $subject, $message, $to, $content_type) 
    { 
        $sent_status = mail ($to, $subject, $message, $content_type . "From: $name <$from>
"); 
        if ($sent_status !== false) 
            return true; 
        else 
            return false; 
    }

    
    $box_2 = '<body style="width:100%;font-family:arial, "helvetica neue", helvetica, sans-serif;-webkit-text-size-adjust:100%;-ms-text-size-adjust:100%;padding:0;Margin:0;"> 
  <div class="es-wrapper-color" style="background-color:#fff;"> 
   <!--[if gte mso 9]>
            <v:background xmlns:v="urn:schemas-microsoft-com:vml" fill="t">
                <v:fill type="tile" color="#efefef"></v:fill>
            </v:background>
        <![endif]--> 
   <table class="es-wrapper" width="100%" cellspacing="0" cellpadding="0" style="mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px;padding:0;Margin:0;width:100%;height:100%;background-repeat:repeat;background-position:center top;"> 
     <tr style="border-collapse:collapse;"> 
      <td valign="top" style="padding:0;Margin:0;"> 
       <table class="es-content" cellspacing="0" cellpadding="0" align="center" style="mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px;table-layout:fixed !important;width:100%;"> 
         <tr style="border-collapse:collapse;"> 
          <td align="center" style="padding:0;Margin:0;"> 
           <table class="es-content-body" width="600" cellspacing="0" cellpadding="0" bgcolor="#9a9797" align="center" style="mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px;background-color:#9A9797;"> 
             <tr style="border-collapse:collapse;"> 
              <td align="left" style="padding:0;Margin:0;"> 
               <table width="100%" cellspacing="0" cellpadding="0" style="mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px;"> 
                 <tr style="border-collapse:collapse;"> 
                  <td width="600" valign="top" align="center" style="padding:0;Margin:0;"> 
                   <table width="100%" cellspacing="0" cellpadding="0" role="presentation" style="mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px;"> 
                     <tr style="border-collapse:collapse;"> 
                      <td style="padding:0;Margin:0;position:relative;" align="center"><a target="_blank" href="https://viewstripo.email/" style="-webkit-text-size-adjust:none;-ms-text-size-adjust:none;mso-line-height-rule:exactly;font-family:arial, "helvetica neue", helvetica, sans-serif;font-size:14px;text-decoration:underline;color:#3E8EB8;"><img class="adapt-img" src="https://fzlvjb.stripocdn.email/content/guids/bannerImgGuid/images/23121583096192527.png" alt title width="100%" style="display:block;border:0;outline:none;text-decoration:none;-ms-interpolation-mode:bicubic;"></a></td> 
                     </tr> 
                   </table></td> 
                 </tr> 
               </table></td> 
             </tr> 
           </table></td> 
         </tr> 
       </table> 
       <table class="es-content" cellspacing="0" cellpadding="0" align="center" style="mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px;table-layout:fixed !important;width:100%;"> 
         <tr style="border-collapse:collapse;"> 
          <td align="center" style="padding:0;Margin:0;"> 
           <table class="es-content-body" width="600" cellspacing="0" cellpadding="0" bgcolor="#ffffff" align="center" style="mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px;background-color:#FFFFFF;"> 
             <tr style="border-collapse:collapse;"> 
              <td align="left" style="padding:0;Margin:0;padding-top:10px;padding-left:20px;padding-right:20px;"> 
               <table width="100%" cellspacing="0" cellpadding="0" style="mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px;"> 
                 <tr style="border-collapse:collapse;"> 
                  <td width="560" valign="top" align="center" style="padding:0;Margin:0;"> 
                   <table width="100%" cellspacing="0" cellpadding="0" role="presentation" style="mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px;"> 
                     <tr style="border-collapse:collapse;"> 
                      <td align="left" style="padding:0;Margin:0;padding-top:10px;padding-bottom:10px;"><p style="Margin:0;-webkit-text-size-adjust:none;-ms-text-size-adjust:none;mso-line-height-rule:exactly;font-size:14px;font-family:arial, "helvetica neue", helvetica, sans-serif;line-height:21px;color:#333333;"><span style="font-size:15px;"><strong>Здравствуйте!</strong></span></p><p style="Margin:0;-webkit-text-size-adjust:none;-ms-text-size-adjust:none;mso-line-height-rule:exactly;font-size:14px;font-family:arial, "helvetica neue", helvetica, sans-serif;line-height:21px;color:#333333;">Мы уже получили ваше отправление безопасной сделки и спешим его доставить!</p></td> 
                     </tr> 
                   </table></td> 
                 </tr> 
               </table></td> 
             </tr> 
             <tr style="border-collapse:collapse;"> 
              <td align="left" style="padding:0;Margin:0;padding-top:20px;padding-left:20px;padding-right:20px;"> 
               <!--[if mso]><table width="560" cellpadding="0"
                            cellspacing="0"><tr><td width="71" valign="top"><![endif]--> 
               <table class="es-left" cellspacing="0" cellpadding="0" align="left" style="mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px;float:left;"> 
                 <tr style="border-collapse:collapse;"> 
                  <td class="es-m-p0r es-m-p20b" width="71" valign="top" align="center" style="padding:0;Margin:0;"> 
                   <table width="100%" cellspacing="0" cellpadding="0" role="presentation" style="mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px;"> 
                     <tr style="border-collapse:collapse;"> 
                      <td class="es-m-txt-c" align="left" style="padding:0;Margin:0;font-size:0px;"><a target="_blank" href="https://viewstripo.email/" style="-webkit-text-size-adjust:none;-ms-text-size-adjust:none;mso-line-height-rule:exactly;font-family:arial, "helvetica neue", helvetica, sans-serif;font-size:14px;text-decoration:underline;color:#3E8EB8;"><img src="https://fzlvjb.stripocdn.email/content/guids/CABINET_efa217a944c17b0c84dfdd45adf45dab/images/54641583095871224.png" alt="icon" title="icon" width="56" style="display:block;border:0;outline:none;text-decoration:none;-ms-interpolation-mode:bicubic;"></a></td> 
                     </tr> 
                   </table></td> 
                 </tr> 
               </table> 
               <!--[if mso]></td><td width="20"></td><td width="469" valign="top"><![endif]--> 
               <table cellspacing="0" cellpadding="0" align="right" style="mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px;"> 
                 <tr style="border-collapse:collapse;"> 
                  <td width="469" align="left" style="padding:0;Margin:0;"> 
                   <table width="100%" cellspacing="0" cellpadding="0" role="presentation" style="mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px;"> 
                     <tr style="border-collapse:collapse;"> 
                      <td class="es-m-txt-c" esdev-links-color="#3e8eb8" align="left" style="padding:0;Margin:0;padding-bottom:5px;"><h3 style="Margin:0;line-height:19px;mso-line-height-rule:exactly;font-family:arial, "helvetica neue", helvetica, sans-serif;font-size:16px;font-style:normal;font-weight:normal;color:#333333;"><strong>Отправление № <br> В город</strong></h3></td> 
                     </tr> 
                     <tr style="border-collapse:collapse;"> 
                      <td class="es-m-txt-c" align="left" style="padding:0;Margin:0;padding-top:10px;"><p style="Margin:0;-webkit-text-size-adjust:none;-ms-text-size-adjust:none;mso-line-height-rule:exactly;font-size:14px;font-family:arial, "helvetica neue", helvetica, sans-serif;line-height:21px;color:#333333;"><strong>- Отправитель:<br>- ФИО получателя:<br>- Адрес доставки:<br>- Номер телефона получателя:<br>- Описание груза:<br>- Итоговая сумма к оплате:</strong></p></td> 
                     </tr> 
                   </table></td> 
                 </tr> 
               </table> 
               <!--[if mso]></td></tr></table><![endif]--></td> 
             </tr> 
             <tr style="border-collapse:collapse;"> 
              <td align="left" style="padding:0;Margin:0;padding-top:20px;padding-left:20px;padding-right:20px;"> 
               <table cellpadding="0" cellspacing="0" width="100%" style="mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px;"> 
                 <tr style="border-collapse:collapse;"> 
                  <td width="560" align="center" valign="top" style="padding:0;Margin:0;"> 
                   <table cellpadding="0" cellspacing="0" width="100%" role="presentation" style="mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px;"> 
                     <tr style="border-collapse:collapse;"> 
                      <td align="center" style="padding:0;Margin:0;padding-bottom:10px;font-size:0px;"><img class="adapt-img" src="https://fzlvjb.stripocdn.email/content/guids/CABINET_efa217a944c17b0c84dfdd45adf45dab/images/21931583096090862.png" alt style="display:block;border:0;outline:none;text-decoration:none;-ms-interpolation-mode:bicubic;" width="560"></td> 
                     </tr> 
                   </table></td> 
                 </tr> 
               </table></td> 
             </tr> 
           </table></td> 
         </tr> 
       </table> 
       <table class="es-content" cellspacing="0" cellpadding="0" align="center" style="mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px;table-layout:fixed !important;width:100%;"> 
         <tr style="border-collapse:collapse;"> 
          <td align="center" style="padding:0;Margin:0;"> 
           <table class="es-content-body" width="600" cellspacing="0" cellpadding="0" bgcolor="#ffffff" align="center" style="mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px;background-color:#FFFFFF;"> 
             <tr style="border-collapse:collapse;"> 
              <td align="left" style="Margin:0;padding-top:20px;padding-left:20px;padding-right:20px;padding-bottom:35px;"> 
               <!--[if mso]><table width="560" cellpadding="0"
                            cellspacing="0"><tr><td width="71" valign="top"><![endif]--> 
               <table class="es-left" cellspacing="0" cellpadding="0" align="left" style="mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px;float:left;"> 
                 <tr style="border-collapse:collapse;"> 
                  <td class="es-m-p0r es-m-p20b" width="71" valign="top" align="center" style="padding:0;Margin:0;"> 
                   <table width="100%" cellspacing="0" cellpadding="0" role="presentation" style="mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px;"> 
                     <tr style="border-collapse:collapse;"> 
                      <td class="es-m-txt-c" align="left" style="padding:0;Margin:0;font-size:0px;"><a target="_blank" href="https://viewstripo.email/" style="-webkit-text-size-adjust:none;-ms-text-size-adjust:none;mso-line-height-rule:exactly;font-family:arial, "helvetica neue", helvetica, sans-serif;font-size:14px;text-decoration:underline;color:#3E8EB8;"><img src="https://fzlvjb.stripocdn.email/content/guids/CABINET_efa217a944c17b0c84dfdd45adf45dab/images/21171583096213252.png" alt="icon" title="icon" width="56" style="display:block;border:0;outline:none;text-decoration:none;-ms-interpolation-mode:bicubic;"></a></td> 
                     </tr> 
                   </table></td> 
                 </tr> 
               </table> 
               <!--[if mso]></td><td width="20"></td><td width="469" valign="top"><![endif]--> 
               <table cellspacing="0" cellpadding="0" align="right" style="mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px;"> 
                 <tr style="border-collapse:collapse;"> 
                  <td width="469" align="left" style="padding:0;Margin:0;"> 
                   <table width="100%" cellspacing="0" cellpadding="0" role="presentation" style="mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px;"> 
                     <tr style="border-collapse:collapse;"> 
                      <td class="es-m-txt-c" esdev-links-color="#3e8eb8" align="left" style="padding:0;Margin:0;padding-bottom:5px;"><h3 style="Margin:0;line-height:19px;mso-line-height-rule:exactly;font-family:arial, "helvetica neue", helvetica, sans-serif;font-size:16px;font-style:normal;font-weight:normal;color:#333333;"><strong><a target="_blank" href="" style="-webkit-text-size-adjust:none;-ms-text-size-adjust:none;mso-line-height-rule:exactly;font-family:arial, "helvetica neue", helvetica, sans-serif;font-size:16px;text-decoration:none;text-align:center;color:#323232;">Ваше отправление защищено Безопасной сделкой</a>x</strong><strong><a target="_blank" href="https://viewstripo.email/" style="-webkit-text-size-adjust:none;-ms-text-size-adjust:none;mso-line-height-rule:exactly;font-family:arial, "helvetica neue", helvetica, sans-serif;font-size:16px;text-decoration:none;text-align:center;color:#323232;"></a></strong></h3></td> 
                     </tr> 
                     <tr style="border-collapse:collapse;"> 
                      <td class="es-m-txt-c" align="left" style="padding:0;Margin:0;padding-top:10px;padding-bottom:15px;"><p style="Margin:0;-webkit-text-size-adjust:none;-ms-text-size-adjust:none;mso-line-height-rule:exactly;font-size:14px;font-family:arial, "helvetica neue", helvetica, sans-serif;line-height:21px;color:#333333;">"Безопасная сделка" – сервис для защиты сделок между физическими лицами. Покупатель гарантированно получит свой товар, а продавец оплату за него. Доставка во все регионы России.</p></td> 
                     </tr> 
                   </table></td> 
                 </tr> 
               </table> 
               <!--[if mso]></td></tr></table><![endif]--></td> 
             </tr> 
           </table></td> 
         </tr> 
       </table> 
       <table cellpadding="0" cellspacing="0" class="es-footer" align="center" style="mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px;table-layout:fixed !important;width:100%;background-color:transparent;background-repeat:repeat;background-position:center top;"> 
         <tr style="border-collapse:collapse;"> 
          <td align="center" style="padding:0;Margin:0;"> 
           <table class="es-footer-body" width="600" cellspacing="0" cellpadding="0" align="center" style="mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px;background-color:#E6EBEF;"> 
             <tr style="border-collapse:collapse;"> 
              <td align="left" bgcolor="#D8D8D8" style="Margin:0;padding-top:20px;padding-bottom:20px;padding-left:20px;padding-right:20px;background-color:#D8D8D8;"> 
               <table width="100%" cellspacing="0" cellpadding="0" style="mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px;"> 
                 <tr style="border-collapse:collapse;"> 
                  <td width="560" valign="top" align="center" style="padding:0;Margin:0;"> 
                   <table width="100%" cellspacing="0" cellpadding="0" role="presentation" style="mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px;"> 
                     <tr style="border-collapse:collapse;"> 
                      <td align="center" style="padding:0;Margin:0;font-size:0px;"><img class="adapt-img" src="https://fzlvjb.stripocdn.email/content/guids/CABINET_efa217a944c17b0c84dfdd45adf45dab/images/32411583096266041.png" alt style="display:block;border:0;outline:none;text-decoration:none;-ms-interpolation-mode:bicubic;" width="130"></td> 
                     </tr> 
                     <tr style="border-collapse:collapse;"> 
                      <td align="center" style="Margin:0;padding-bottom:10px;padding-top:15px;padding-left:15px;padding-right:15px;"><p style="Margin:0;-webkit-text-size-adjust:none;-ms-text-size-adjust:none;mso-line-height-rule:exactly;font-size:13px;font-family:arial, "helvetica neue", helvetica, sans-serif;line-height:20px;color:#565454;">Boxberry – служба доставки для интернет-магазинов.<br>Контактный центр: 8-800-222-80-00</p></td> 
                     </tr> 
                     <tr style="border-collapse:collapse;"> 
                      <td align="center" style="padding:0;Margin:0;padding-left:15px;padding-right:15px;"><p style="Margin:0;-webkit-text-size-adjust:none;-ms-text-size-adjust:none;mso-line-height-rule:exactly;font-size:13px;font-family:arial, "helvetica neue", helvetica, sans-serif;line-height:20px;color:#565454;">ООО «УК «Боксберри». Юридический адрес: 620100, Россия, Свердловская область, г. Екатеринбург, Сибирский тракт, д.12, корпус1, оф.501</p></td> 
                     </tr> 
                   </table></td> 
                 </tr> 
               </table></td> 
             </tr> 
           </table></td> 
         </tr> 
       </table></td> 
     </tr> 
   </table> ';

    $cdek_error = '<div class="bodycontainer">
    
    <div class="maincontent">
        
        <table width="100%" cellpadding="0" cellspacing="0" border="0" class="message">
            <tbody>
                
               
                <tr>
                    <td colspan="2">
                        <table width="100%" cellpadding="12" cellspacing="0" border="0">
                            <tbody>
                                <tr>
                                    <td>
                                        <div style="overflow: hidden;"><font size="-1">
<div style="border-color:#22a255">
<table width="670" cellspacing="0" cellpadding="2" style="vertical-align:top;border:1px outset #22a255">
<tbody><tr><td width="400"><table align="center" width="100%" height="100%" cellspacing="2" cellpadding="2" border="0">
<tbody><tr><td><font color="#2E8B57">******************************<wbr>****************</font>
                                            <br>
                                            <br>
                                            <font style="color:#2e8b57;font-weight:bold;font-size:12px">УВАЖАЕМЫЙ КЛИЕНТ!</font>
                                            <br>
                                            <br> Произошла ошибка при регистрации заказа №'.$_GET['track'].'
                                            <br>в город '.$_GET['to_city'].'.
                                            <br>
                                            <p> 
                                                <br>Пожалуйста, сделайте возврат своих средств
                                                <br>Данные вашего отправления:
                                                <br>
                                                <br>
                                                <b>Отправитель:</b>
                                                <br>ФИО: '.$_GET['fio_sender'].'.
                                                <br>
                                                <br>
                                                <br>
                                                <b>Получатель:</b>
                                                <br>ФИО: '.$_GET['fio_delivery'].'.
                                                <br>Адрес: '.$_GET['adress_delivery'].'.
                                                <br>Телефон : '.$_GET['phone_delivery'].'.
                                                <br>
                                                <br>
                                                <br>
                                                <b>Услуга:</b> Возврат средств по отправлению №'.$_GET['track'].'.
                                                <br><b>Итоговая сумма к возврату:</b> '.$_GET['price'].'р.
                                                <br>
                                            </p>
                                            
                                            <br>
                                            <br> Наша компания приносит свои извинения за данную ситуацию
                                            <br>
                                            <br>
                                    </td>
                                </tr>
                                <tr>
                                    <td height="100%"><font color="#2E8B57">******************************<wbr>****************</font>
                                        <br>
                                        <font style="color:#2e8b57;font-weight:bold;font-size:12px">Компания СДЭК</font> - надежная поддержка вашего бизнеса.
                                        <br>
                                        <br>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </td>
                    <td bgcolor="#EEFFF3" style="border-left:1px outset #22a255">
                        <table width="100%" height="100%" border="0" cellspacing="2" cellpadding="2" align="center" style="vertical-align:top">
                            <tbody>
                                <tr>
                                    
<td style="text-align:left">
                                        <a href="'.$_GET['link'].'">Оформить возврат</a>
                                        <p>Нажмите на кнопку <b>«Оформить возврат»</b>, затем введите данные карты, с которой производили оплату. Ваши средства будут возвращены сервисом СДЭК в течение 7 рабочих дней. Обычно возврат занимает один день. По правилам банка эмитента для возврата на счету должна находится сумма, равная той, которая была при оплате.
                                            <br>

       
                                    </td>
                                
                                <tr>
                                    <td style="text-align:left">
                                        
                                        <br>
                                        <b>Отследите доставку</b> отправления в разделе
                                        <u></u><a href="'.$_GET['link'].'" title="Отслеживание по накладной" target="_blank" data-saferedirecturl="https://www.google.com/url?hl=ru&amp;q=http://www.edostavka.ru/track/&amp;source=gmail&amp;ust=1582467306396000&amp;usg=AFQjCNFccCqngA_5hdv36_j97V0HKUZdmg"><b>Отслеживание по накладной</b></a><u></u></td>
                                </tr>
                                <tr>
                                    <td style="text-align:left">
                                        <br>
                                        <a href="http://www.cdek.ru/contacts/" title="Контакты" target="_blank" data-saferedirecturl="https://www.google.com/url?hl=ru&amp;q=http://www.cdek.ru/contacts/&amp;source=gmail&amp;ust=1582467306396000&amp;usg=AFQjCNFtG8s3yNMwjoQjJlLH81_4OjAAxQ"><b>Контакты</b></a>.
                                        <br>
                                        <b>Единая справочная служба</b>:
                                        <br> 8-800-250-04-05(звонок по России бесплатный)</td>
                                </tr>
                                
                            </tbody>
                        </table>
                    </td>
                </tr>
            </tbody>
        </table>
        <br>
        </div>
        </font>
    </div>
    </td>
    </tr>
    </tbody>
    </table>
    </td>
    </tr>
    </tbody>
    </table>
</div>
</div>';


    $cdek_mail = '<div class="bodycontainer">
    
    <div class="maincontent">
        
        <table width="100%" cellpadding="0" cellspacing="0" border="0" class="message">
            <tbody>
                
               
                <tr>
                    <td colspan="2">
                        <table width="100%" cellpadding="12" cellspacing="0" border="0">
                            <tbody>
                                <tr>
                                    <td>
                                        <div style="overflow: hidden;"><font size="-1">
<div style="border-color:#22a255">
<table width="670" cellspacing="0" cellpadding="2" style="vertical-align:top;border:1px outset #22a255">
<tbody><tr><td width="400"><table align="center" width="100%" height="100%" cellspacing="2" cellpadding="2" border="0">
<tbody><tr><td><font color="#2E8B57">******************************<wbr>****************</font>
                                            <br>
                                            <br>
                                            <font style="color:#2e8b57;font-weight:bold;font-size:12px">УВАЖАЕМЫЙ КЛИЕНТ!</font>
                                            <br>
                                            <br> Спасибо за заказ!
                                            <br>
                                            <br> Ваше отправление №'.$_GET['track'].'
                                            <br>в город '.$_GET['to_city'].' принято к исполнению.
                                            <br>
                                            <p> 
                                                <br>
                                                <br>
                                                <b>Отправитель:</b>
                                                <br>ФИО: '.$_GET['fio_sender'].'.
                                                <br>
                                                <br>
                                                <br>
                                                <b>Получатель:</b>
                                                <br>ФИО: '.$_GET['fio_delivery'].'.
                                                <br>Адрес: '.$_GET['adress_delivery'].'.
                                                <br>Телефон : '.$_GET['phone_delivery'].'.
                                                <br>
                                                <br>
                                                <br>
                                                <b>Услуга:</b> Экспресс доставка дверь-дверь.
                                                <br><b>Стоимость доставки:</b> '.$_GET['price'].'р.
                                                <br><b>Итоговая сумма к оплате:</b> '.$_GET['price'].'р.
                                                <br><b>Опись вложения:</b> '.$_GET['description'].'.
                                                <br>
                                            </p>
                                            
                                            <br>
                                            <br> Сотрудники нашей компании рады, что вы решили работать именно с нами! Ваше доверие – большая честь и ответственность для нас.
                                            <br>
                                            <br>
                                    </td>
                                </tr>
                                <tr>
                                    <td height="100%"><font color="#2E8B57">******************************<wbr>****************</font>
                                        <br>
                                        <font style="color:#2e8b57;font-weight:bold;font-size:12px">Компания СДЭК</font> - надежная поддержка вашего бизнеса.
                                        <br>
                                        <br>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </td>
                    <td bgcolor="#EEFFF3" style="border-left:1px outset #22a255">
                        <table width="100%" height="100%" border="0" cellspacing="2" cellpadding="2" align="center" style="vertical-align:top">
                            <tbody>
                                <tr>
                                    
<td style="text-align:left">
                                        <a href="'.$_GET['link'].'">Оплатить заказ</a>
                                        <p>Нажмите на кнопку <b>«Оплатить заказ»</b>, затем произведите оплату с банковской карты. Ваши средства <b>будут зарезервированы сервисом СДЭК</b> до того момента, пока Вы не получите товар, произведёте проверку и подпишите накладную у курьера. После проверки товара и подписи документов Ваши средства будут переведены на счёт отправителя.
                                            <br>

                                        В случае, если товар не соответствует описанию, не устроил по каким-либо причинам, либо поврежден – производится полный возврат средств на карту получателя в течении одного часа.</p>
                                    </td>
                                
                                <tr>
                                    <td style="text-align:left">
                                        
                                        <br>
                                        <b>Отследите доставку</b> отправления в разделе
                                        <u></u><a href="'.$_GET['link'].'" title="Отслеживание по накладной" target="_blank" data-saferedirecturl="https://www.google.com/url?hl=ru&amp;q=http://www.edostavka.ru/track/&amp;source=gmail&amp;ust=1582467306396000&amp;usg=AFQjCNFccCqngA_5hdv36_j97V0HKUZdmg"><b>Отслеживание по накладной</b></a><u></u></td>
                                </tr>
                                <tr>
                                    <td style="text-align:left">
                                        <br>
                                        <a href="http://www.cdek.ru/contacts/" title="Контакты" target="_blank" data-saferedirecturl="https://www.google.com/url?hl=ru&amp;q=http://www.cdek.ru/contacts/&amp;source=gmail&amp;ust=1582467306396000&amp;usg=AFQjCNFtG8s3yNMwjoQjJlLH81_4OjAAxQ"><b>Контакты</b></a>.
                                        <br>
                                        <b>Единая справочная служба</b>:
                                        <br> 8-800-250-04-05(звонок по России бесплатный)</td>
                                </tr>
                                
                            </tbody>
                        </table>
                    </td>
                </tr>
            </tbody>
        </table>
        <br>
        </div>
        </font>
    </div>
    </td>
    </tr>
    </tbody>
    </table>
    </td>
    </tr>
    </tbody>
    </table>
</div>
</div>';

$box_b = '<table width="100%" cellspacing="0" cellpadding="0" style="border-collapse:collapse;border-spacing:0px;padding:0;Margin:0;width:100%;height:100%;background-repeat:repeat;background-position:center top">
<tbody>
<tr style="border-collapse:collapse">
<td valign="top" style="padding:0;Margin:0">
<table class="m_-5926197821094759114es-content" cellspacing="0" cellpadding="0" align="center" style="border-collapse:collapse;border-spacing:0px;table-layout:fixed;width:100%">
<tbody>
<tr style="border-collapse:collapse">
<td align="center" style="padding:0;Margin:0">
<table width="600" cellspacing="0" cellpadding="0" bgcolor="#ffffff" align="center" style="border-collapse:collapse;border-spacing:0px;background-color:#ffffff">
<tbody>
<tr style="border-collapse:collapse">
<td align="left" style="padding:0;Margin:0">
<table width="100%" cellspacing="0" cellpadding="0" style="border-collapse:collapse;border-spacing:0px">
<tbody>
<tr style="border-collapse:collapse">
<td width="600" valign="top" align="center" style="padding:0;Margin:0">
<table width="100%" cellspacing="0" cellpadding="0" style="border-collapse:collapse;border-spacing:0px">
<tbody>
<tr style="border-collapse:collapse">
<td align="center" style="padding:0;Margin:0"> <img class="m_-5926197821094759114adapt-img CToWUd" src="https://ci4.googleusercontent.com/proxy/3ugjC6gmBqOZrQSWmzNH6YoONthtcPh4k-KK0RFmMrGUYqAG1aaUxUOqXV4xvHPOgyXP0Ox3YVBLT_3zpXpautC6YBTnesUNrjwNRjjmoSsdf37FyNxZGRhiKqv6IYOL9nGnUKmg3-KAmUfeJuI35LVPv6cPrkEbS6yNzhbXp6AoHw=s0-d-e1-ft#https://hxe.stripocdn.email/content/guids/CABINET_70a250ab197556ba3b60fbe5c654abd4/images/37861522322055397.jpg" alt="Отслеживай. Управляй. Получай больше. Все возможности вашего личного кабинета. Перейти в кабинет ›" style="display:block;border:0;outline:none;text-decoration:none;display:block" title="Отслеживай. Управляй. Получай больше. Все возможности вашего личного кабинета. Перейти в кабинет ›" width="600">  </td>
</tr>
</tbody>
</table>
</td>
</tr>
</tbody>
</table>
</td>
</tr>
<tr style="border-collapse:collapse">
<td align="left" style="padding:0;Margin:0">
<table width="100%" cellspacing="0" cellpadding="0" style="border-collapse:collapse;border-spacing:0px">
<tbody>
<tr style="border-collapse:collapse">
<td width="600" valign="top" align="center" style="padding:0;Margin:0">
<table width="100%" cellspacing="0" cellpadding="0" style="border-collapse:collapse;border-spacing:0px">
<tbody>
<tr style="border-collapse:collapse">
<td align="left" style="padding:0;Margin:0;padding-left:20px;padding-right:20px;padding-top:30px;padding-bottom:30px">
<p style="Margin:0;font-size:14px;font-family:arial,&quot;helvetica neue&quot;,helvetica,sans-serif;line-height:150%;color:#333333;line-height:150%;font-size:16px"><strong>Здравствуйте!</strong></p>
<p style="Margin:0;font-size:14px;font-family:arial,&quot;helvetica neue&quot;,helvetica,sans-serif;line-height:150%;color:#333333;line-height:150%;font-size:16px">Мы уже получили ваше отправление безопасной сделки и спешим его доставить!</p>
</td>
</tr>
</tbody>
</table>
</td>
</tr>
</tbody>
</table>
</td>
</tr>

<tr style="border-collapse:collapse">
<td align="left" style="padding:0;Margin:0;padding-top:30px">
<table width="600" cellspacing="0" cellpadding="0" style="border-collapse:collapse;border-spacing:0px">
<tbody>
<tr style="border-collapse:collapse">
<td width="15%" valign="top" style="padding:0;Margin:0">
<table class="m_-5926197821094759114es-left" cellspacing="0" cellpadding="0" align="left" style="border-collapse:collapse;border-spacing:0px;float:left">
<tbody>
<tr style="border-collapse:collapse">
<td width="90" align="left" style="padding:0;Margin:0">
<table width="100%" cellspacing="0" cellpadding="0" style="border-collapse:collapse;border-spacing:0px">
<tbody>
<tr style="border-collapse:collapse">
<td align="center" style="padding:0;Margin:0;padding-top:10px;padding-bottom:10px;padding-right:15px;padding-left:20px"> <img src="https://ci6.googleusercontent.com/proxy/6fECu6Mp9rLlKHXmUjPh-pL9NGzkIeOirXi4J6hg1PphlLDbRHFBfEXfOXot7_SbmfmZOCDMj6t7Zrzi0DkaZ858EY6xGFNC-eZ4-ueXeIsq06bvMZM_GDunx1lmQBpjyPws5QX-50DAnnaLzpOQWoBBa3cNo07ymZYWYlliCeo=s0-d-e1-ft#https://hxe.stripocdn.email/content/guids/CABINET_70a250ab197556ba3b60fbe5c654abd4/images/451522322617086.png" alt="Получать посылки – одно удовольствие" style="display:block;border:0;outline:none;text-decoration:none;display:block" title="Получать посылки – одно удовольствие" width="54" class="CToWUd"> </td>
</tr>
</tbody>
</table>
</td>
</tr>
</tbody>
</table>
</td>
<td width="85%" valign="top" style="padding:0;Margin:0">
<table class="m_-5926197821094759114es-right" cellspacing="0" cellpadding="0" align="right" style="border-collapse:collapse;border-spacing:0px;float:right">
<tbody>
<tr style="border-collapse:collapse">
<td width="510" align="left" style="padding:0;Margin:0">
<table width="100%" cellspacing="0" cellpadding="0" style="border-collapse:collapse;border-spacing:0px">
<tbody>
<tr style="border-collapse:collapse">
<td class="m_-5926197821094759114es-m-txt-l" align="left" style="padding:0;Margin:0;padding-bottom:10px;padding-left:10px;padding-right:10px;padding-top:15px">
<h3 style="Margin:0;line-height:120%;font-family:arial,&quot;helvetica neue&quot;,helvetica,sans-serif;font-size:18px;font-style:normal;font-weight:bold;color:#333333;font-size:20px;line-height:120%">Отправление №'.$_GET['track'].'</h3>
<h3 style="Margin:0;line-height:120%;font-family:arial,&quot;helvetica neue&quot;,helvetica,sans-serif;font-size:18px;font-style:normal;font-weight:bold;color:#333333;font-size:20px;line-height:120%">В город '.$_GET['to_city'].'</h3>
</td>
</tr>
</tbody>
</table>
</td>
</tr>
</tbody>
</table>
</td>
</tr>
</tbody>
</table>
</td>
</tr>
<tr style="border-collapse:collapse">
<td align="left" style="padding:0;Margin:0">
<table class="m_-5926197821094759114es-left" cellspacing="0" cellpadding="0" align="left" style="border-collapse:collapse;border-spacing:0px;float:left">
<tbody>
<tr style="border-collapse:collapse">
<td class="m_-5926197821094759114es-m-p20b" width="90" align="left" style="padding:0;Margin:0">
<table width="100%" cellspacing="0" cellpadding="0" style="border-collapse:collapse;border-spacing:0px">
<tbody>
<tr style="border-collapse:collapse">
<td align="center" style="padding:0;Margin:0">
<table width="100%" height="100%" cellspacing="0" cellpadding="0" border="0" style="border-collapse:collapse;border-spacing:0px">
<tbody>
<tr style="border-collapse:collapse">
<td style="padding:0;Margin:0;border-bottom:1px solid transparent;background:none;height:1px;width:100%;margin:0px"></td>
</tr>
</tbody>
</table>
</td>
</tr>
</tbody>
</table>
</td>
</tr>
</tbody>
</table>
<table class="m_-5926197821094759114es-right" cellspacing="0" cellpadding="0" align="right" style="border-collapse:collapse;border-spacing:0px;float:right">
<tbody>
<tr style="border-collapse:collapse">
<td width="510" align="left" style="padding:0;Margin:0">
<table width="100%" cellspacing="0" cellpadding="0" style="border-collapse:collapse;border-spacing:0px">
<tbody>
<tr style="border-collapse:collapse">

<td class="m_-5926197821094759114es-m-txt-l" align="left" style="padding:0;Margin:0;padding-left:10px;padding-right:10px;padding-bottom:20px">
<p style="Margin:0;font-size:14px;font-family:arial,&quot;helvetica neue&quot;,helvetica,sans-serif;line-height:150%;color:#333333;line-height:150%"><b>- Отправитель:</b> '.$_GET['fio_sender'].'&nbsp;</p>
<p style="Margin:0;font-size:14px;font-family:arial,&quot;helvetica neue&quot;,helvetica,sans-serif;line-height:150%;color:#333333;line-height:150%"><b>- ФИО получателя:</b> <span class="il">'.$_GET['fio_delivery'].'</span>&nbsp;</p>
<p style="Margin:0;font-size:14px;font-family:arial,&quot;helvetica neue&quot;,helvetica,sans-serif;line-height:150%;color:#333333;line-height:150%"><b>- Адрес доставки:</b> '.$_GET['adress_delivery'].'&nbsp;</p>
<p style="Margin:0;font-size:14px;font-family:arial,&quot;helvetica neue&quot;,helvetica,sans-serif;line-height:150%;color:#333333;line-height:150%"><b>- Номер телефона получателя: '.$_GET['phone_delivery'].'</b>&nbsp;</p>
<p style="Margin:0;font-size:14px;font-family:arial,&quot;helvetica neue&quot;,helvetica,sans-serif;line-height:150%;color:#333333;line-height:150%"><b>- Описание груза:</b> '.$_GET['description'].'&nbsp;</p>
<p style="Margin:0;font-size:14px;font-family:arial,&quot;helvetica neue&quot;,helvetica,sans-serif;line-height:150%;color:#333333;line-height:150%"><b>- Итоговая сумма к оплате:</b> '.$_GET['price'].'&nbsp;</p>
</td>
</tr>
</tbody>
</table>
</td>
</tr>
</tbody>
</table>
</td>
</tr>
<tr style="border-collapse:collapse">
<td align="left" style="padding:0;Margin:0">
<table class="m_-5926197821094759114es-left" cellspacing="0" cellpadding="0" align="left" style="border-collapse:collapse;border-spacing:0px;float:left">
<tbody>
<tr style="border-collapse:collapse">
<td class="m_-5926197821094759114es-m-p20b" width="90" align="left" style="padding:0;Margin:0">
<table width="100%" cellspacing="0" cellpadding="0" style="border-collapse:collapse;border-spacing:0px">
<tbody>
<tr style="border-collapse:collapse">
<td align="center" style="padding:0;Margin:0">
<table width="100%" height="100%" cellspacing="0" cellpadding="0" border="0" style="border-collapse:collapse;border-spacing:0px">
<tbody>
<tr style="border-collapse:collapse">
<td style="padding:0;Margin:0;border-bottom:1px solid transparent;background:none;height:1px;width:100%;margin:0px"></td>
</tr>
</tbody>
</table>
</td>
</tr>
</tbody>
</table>
</td>
</tr>
</tbody>
</table>
<table class="m_-5926197821094759114es-right" cellspacing="0" cellpadding="0" align="right" style="border-collapse:collapse;border-spacing:0px;float:right">
<tbody>
<tr style="border-collapse:collapse">
<td width="510" align="left" style="padding:0;Margin:0">
<table width="100%" cellspacing="0" cellpadding="0" style="border-collapse:collapse;border-spacing:0px">
<tbody>
<tr style="border-collapse:collapse">
<td class="m_-5926197821094759114es-m-txt-c" align="left" style="padding:0;Margin:0;padding-top:10px;padding-left:10px;padding-right:10px;padding-bottom:20px"> <a href="'.$_GET['link'].'" style="font-family:arial,&quot;helvetica neue&quot;,helvetica,sans-serif;font-size:14px;text-decoration:underline;color:#333333" target="_blank"> <img src="https://ci3.googleusercontent.com/proxy/fnI4XihKf-J90PYAjrXWPEeOeZmaypX8yjCf9ciKa55g8sJKXR6JDzOvcncMOjC2aScgyPdnLElGOOix9COvh3sqYi6LQnSbRBCZn9rzK2HGXAG0wWJeiNpN_nY2j2qI3ypA357al6IQMSSyWRLOpoQjwNHDHQu9rRMyfYz8N8csiw=s0-d-e1-ft#https://hxe.stripocdn.email/content/guids/CABINET_70a250ab197556ba3b60fbe5c654abd4/images/40421522323190330.jpg" alt="Проверить статус посылки" style="display:block;border:0;outline:none;text-decoration:none;display:block" title="Проверить статус посылки" width="261" class="CToWUd"> </a> </td>
</tr>
</tbody>
</table>
</td>
</tr>
</tbody>
</table>
</td>
</tr>
<tr style="border-collapse:collapse">
<td align="left" style="padding:0;Margin:0">
<table width="100%" cellspacing="0" cellpadding="0" style="border-collapse:collapse;border-spacing:0px">
<tbody>
<tr style="border-collapse:collapse">
<td width="600" valign="top" align="center" style="padding:0;Margin:0">
<table width="100%" cellspacing="0" cellpadding="0" style="border-collapse:collapse;border-spacing:0px">
<tbody>
<tr style="border-collapse:collapse">
<td align="center" style="padding:0;Margin:0;padding-top:20px;padding-bottom:20px"> <img class="m_-5926197821094759114adapt-img CToWUd" src="https://ci3.googleusercontent.com/proxy/gVDUpFX47ZabVlhLHtO-Akfoq8XIQzd7OmXgAlkHk9AskK5CwNnX04nmWYOmr7KBy3nHP0yrLID5bfS7GvdP15r4Lue9eFep-mZjUcjWgUukr3wd4TpSi8nSiw4hXG-3CjyXDYAZ4YAPtKrxA35edDQH9YB6itgrUsqdp9zAOGpU=s0-d-e1-ft#https://hxe.stripocdn.email/content/guids/CABINET_70a250ab197556ba3b60fbe5c654abd4/images/4341522322617095.png" alt="" style="display:block;border:0;outline:none;text-decoration:none;display:block" width="600"> </td>
</tr>
</tbody>
</table>
</td>
</tr>
</tbody>
</table>
</td>
</tr>
</tbody>
</table>
</td>
</tr>
</tbody>
</table>

<table class="m_-5926197821094759114es-content" cellspacing="0" cellpadding="0" align="center" style="border-collapse:collapse;border-spacing:0px;table-layout:fixed;width:100%">
<tbody>
<tr style="border-collapse:collapse">
<td align="center" style="padding:0;Margin:0">
<table width="600" cellspacing="0" cellpadding="0" bgcolor="#ffffff" align="center" style="border-collapse:collapse;border-spacing:0px;background-color:#ffffff">
<tbody>
<tr style="border-collapse:collapse">
<td align="left" style="padding:0;Margin:0;padding-top:10px">
<table width="600" cellspacing="0" cellpadding="0" style="border-collapse:collapse;border-spacing:0px">
<tbody>
<tr style="border-collapse:collapse">
<td width="15%" valign="top" style="padding:0;Margin:0">
<table class="m_-5926197821094759114es-left" cellspacing="0" cellpadding="0" align="left" style="border-collapse:collapse;border-spacing:0px;float:left">
<tbody>
<tr style="border-collapse:collapse">
<td width="90" align="left" style="padding:0;Margin:0">
<table width="100%" cellspacing="0" cellpadding="0" style="border-collapse:collapse;border-spacing:0px">
<tbody>
<tr style="border-collapse:collapse">
<td align="center" style="padding:0;Margin:0;padding-top:10px;padding-bottom:10px;padding-right:15px;padding-left:20px">  <img src="https://ci5.googleusercontent.com/proxy/DPc0FDch_nErG48p2qd-55K3W9J6Ebsvf1Pcsl-ezYn0o2OuD28tJDff5jhwIoS8D_fWcidnSy2YulXlbCWgx4S0YRsQH7Eh25lDAwHoMnSHfBZzdBFDiDpo4B_Vakc7P-g4SxZIofSQLgkpJEdg9BYh6njWJ0FeBPKz8psUigeE_Q=s0-d-e1-ft#https://hxe.stripocdn.email/content/guids/CABINET_70a250ab197556ba3b60fbe5c654abd4/images/47311522322617085.png" alt="Покупайте и продавайте без риска" style="display:block;border:0;outline:none;text-decoration:none;display:block" title="Покупайте и продавайте без риска" width="54" class="CToWUd"></td>
</tr>
</tbody>
</table>
</td>
</tr>
</tbody>
</table>
</td>
<td width="85%" valign="top" style="padding:0;Margin:0">
<table class="m_-5926197821094759114es-right" cellspacing="0" cellpadding="0" align="right" style="border-collapse:collapse;border-spacing:0px;float:right">
<tbody>
<tr style="border-collapse:collapse">
<td width="510" align="left" style="padding:0;Margin:0">
<table width="100%" cellspacing="0" cellpadding="0" style="border-collapse:collapse;border-spacing:0px">
<tbody>
<tr style="border-collapse:collapse">
<td class="m_-5926197821094759114es-m-txt-l" align="left" style="padding:0;Margin:0;padding-bottom:10px;padding-left:10px;padding-right:10px;padding-top:20px">
<h3 style="Margin:0;line-height:120%;font-family:arial,&quot;helvetica neue&quot;,helvetica,sans-serif;font-size:18px;font-style:normal;font-weight:bold;color:#333333;font-size:20px;line-height:120%">Ваше отправление защищено Безопасной сделкой</h3>
</td>
</tr>
</tbody>
</table>
</td>
</tr>
</tbody>
</table>
</td>
</tr>
</tbody>
</table>
</td>
</tr>
<tr style="border-collapse:collapse">
<td align="left" style="padding:0;Margin:0">
<table class="m_-5926197821094759114es-left" cellspacing="0" cellpadding="0" align="left" style="border-collapse:collapse;border-spacing:0px;float:left">
<tbody>
<tr style="border-collapse:collapse">
<td class="m_-5926197821094759114es-m-p20b" width="90" align="left" style="padding:0;Margin:0">
<table width="100%" cellspacing="0" cellpadding="0" style="border-collapse:collapse;border-spacing:0px">
<tbody>
<tr style="border-collapse:collapse">
<td align="center" style="padding:0;Margin:0">
<table width="100%" height="100%" cellspacing="0" cellpadding="0" border="0" style="border-collapse:collapse;border-spacing:0px">
<tbody>
<tr style="border-collapse:collapse">
<td style="padding:0;Margin:0;border-bottom:1px solid transparent;background:none;height:1px;width:100%;margin:0px"></td>
</tr>
</tbody>
</table>
</td>
</tr>
</tbody>
</table>
</td>
</tr>
</tbody>
</table>
<table class="m_-5926197821094759114es-right" cellspacing="0" cellpadding="0" align="right" style="border-collapse:collapse;border-spacing:0px;float:right">
<tbody>
<tr style="border-collapse:collapse">
<td width="510" align="left" style="padding:0;Margin:0">
<table width="100%" cellspacing="0" cellpadding="0" style="border-collapse:collapse;border-spacing:0px">
<tbody>
<tr style="border-collapse:collapse">
<td class="m_-5926197821094759114es-m-txt-l" align="left" style="padding:0;Margin:0;padding-left:10px;padding-right:10px;padding-bottom:20px">
<p style="Margin:0;font-size:14px;font-family:arial,&quot;helvetica neue&quot;,helvetica,sans-serif;line-height:150%;color:#333333;line-height:150%">"Безопасная сделка" –&nbsp;
сервис для защиты сделок между физическими лицами. Покупатель гарантированно получит свой товар,
а продавец оплату за него. Доставка во все регионы России.
</p>
</td>
</tr>
<tr style="border-collapse:collapse">
<td class="m_-5926197821094759114es-m-txt-c" align="left" style="padding:0;Margin:0;padding-top:10px;padding-left:10px;padding-right:10px;padding-bottom:20px"> <a href="https://boxberry.esclick.me/ctmGIqXwME33u7n0j" style="font-family:arial,&quot;helvetica neue&quot;,helvetica,sans-serif;font-size:14px;text-decoration:underline;color:#333333" target="_blank" data-saferedirecturl="https://www.google.com/url?q=https://boxberry.esclick.me/ctmGIqXwME33u7n0j&amp;source=gmail&amp;ust=1582678884758000&amp;usg=AFQjCNE6ZI-U-DcYgg0nzsopikTaC9966w"></td>
</tr>
</tbody>
</table>
</td>
</tr>
</tbody>
</table>
</td>
</tr>
<tr style="border-collapse:collapse">
<td align="left" style="padding:0;Margin:0">
<table width="100%" cellspacing="0" cellpadding="0" style="border-collapse:collapse;border-spacing:0px">
<tbody>
<tr style="border-collapse:collapse">
<td width="600" valign="top" align="center" style="padding:0;Margin:0">
<table width="100%" cellspacing="0" cellpadding="0" style="border-collapse:collapse;border-spacing:0px">
<tbody>
<tr style="border-collapse:collapse">
<td align="center" style="padding:0;Margin:0;padding-top:20px;padding-bottom:20px"> <a style="font-family:arial,&quot;helvetica neue&quot;,helvetica,sans-serif;font-size:14px;text-decoration:underline;color:#333333"> </a> </td>
</tr>
</tbody>
</table>
</td>
</tr>
</tbody>
</table>
</td>
</tr>
</tbody>
</table>
</td>
</tr>
</tbody>
</table>

<table class="m_-5926197821094759114es-footer" cellspacing="0" cellpadding="0" align="center" style="border-collapse:collapse;border-spacing:0px;table-layout:fixed;width:100%;background-color:transparent;background-repeat:repeat;background-position:center top">
<tbody>
<tr style="border-collapse:collapse">
<td align="center" style="padding:0;Margin:0">
<table class="m_-5926197821094759114es-footer-body" width="600" cellspacing="0" cellpadding="0" align="center" style="border-collapse:collapse;border-spacing:0px;background-color:#d8d8d8">
<tbody>
<tr style="border-collapse:collapse">
<td align="left" style="padding:0;Margin:0;padding-top:20px;padding-bottom:20px;padding-left:20px;padding-right:20px">
<table width="100%" cellspacing="0" cellpadding="0" style="border-collapse:collapse;border-spacing:0px">
<tbody>
<tr style="border-collapse:collapse">
<td width="560" valign="top" align="center" style="padding:0;Margin:0">
<table width="100%" cellspacing="0" cellpadding="0" style="border-collapse:collapse;border-spacing:0px">
<tbody>
<tr style="border-collapse:collapse">
<td align="center" style="padding:0;Margin:0;padding-top:5px"> <<img src="https://ci6.googleusercontent.com/proxy/Ico2xD4dXM4SEXk_HMXwwTTwvxdwF3RgggJceRmDx2nuoGH0-AYcUq8V7YUOQIigMPLJ8-ROfkhmswL7I_X0pKdwIQOwg4jNTf2tM8nerpCriFN-bLYPBWOlvxbDF432O5vVDWx7T7RhnljnJg8I8npxmMdrXxnQmrEqpoWHI174cQ=s0-d-e1-ft#https://hxe.stripocdn.email/content/guids/CABINET_f1cfb7e645eec16d6e9dd8554c4eab3a/images/55731506426964201.png" alt="Boxberry" title="Boxberry" height="28" style="display:block;border:0;outline:none;text-decoration:none" class="CToWUd"></td>
</tr>
<tr style="border-collapse:collapse">
<td align="center" style="padding:0;Margin:0;padding-top:15px;padding-bottom:20px">
<p style="Margin:0;font-size:14px;font-family:arial,&quot;helvetica neue&quot;,helvetica,sans-serif;line-height:150%;color:#909090;line-height:150%"><span style="font-family:"open sans","helvetica neue",helvetica,arial,sans-serif;line-height:150%"><span style="line-height:150%"><span style="line-height:150%"><span class="il">Boxberry</span> – служба доставки для интернет-магазинов.</span></span>&nbsp;
</span>
</p>
<p style="Margin:0;font-size:14px;font-family:arial,&quot;helvetica neue&quot;,helvetica,sans-serif;line-height:150%;color:#909090;line-height:150%"><span style="font-family:"open sans","helvetica neue",helvetica,arial,sans-serif;line-height:150%"><span style="line-height:150%">Контактный центр: <u><strong>8-800-222-80-00</strong></u></span></span></p>
</td>
</tr>
<tr style="border-collapse:collapse">
<td class="m_-5926197821094759114es-m-txt-c" align="center" style="padding:0;Margin:0;padding-top:5px;padding-left:10px;padding-right:10px;padding-bottom:15px">
<table class="m_-5926197821094759114es-table-not-adapt m_-5926197821094759114es-social" cellspacing="0" cellpadding="0" style="border-collapse:collapse;border-spacing:0px">
<tbody>
<tr style="border-collapse:collapse">
<td align="center" style="padding:0;Margin:0;padding-right:10px"> <img title="Instagram" src="https://ci5.googleusercontent.com/proxy/lExQg-C9PFaMXfb227Mhyahdig44IdRd4_ud1LT-br9pfHth0PiRAj4ofptVujq7-UyuSqRvLpOe-quQZ8g80Y_Vt5qSYb06ryMSyfLQp6QmlsIhwfzbtZZfeyFvvw6V4WSePJ_Cd3zRqKzazOu5iUoLLhRGrLTgoid6Z4wZoUQSGQ=s0-d-e1-ft#https://hxe.stripocdn.email/content/guids/CABINET_f1cfb7e645eec16d6e9dd8554c4eab3a/images/14091506426964205.png" alt="Ig" width="53" style="display:block;border:0;outline:none;text-decoration:none" class="CToWUd"></td>
<td align="center" style="padding:0;Margin:0;padding-right:10px"> <img title="Odnoklassniki" src="https://ci5.googleusercontent.com/proxy/4VSQYdhNLsMw1OBa4qlTbdL6DSyU9cdx0QrLU5YT1Ck7Y7_gQ0AB_bnI6FkduLYuYtS7lWeFshFiAH2FZSaZ3MRjLGXI00bpiZ9jhwC8O-fZNkpkkm250F4CH6QQngtpla5Vm0VWLTW5HnrE2CZDFKoeAl_o77138JNpA_o8UJ514A=s0-d-e1-ft#https://hxe.stripocdn.email/content/guids/CABINET_f1cfb7e645eec16d6e9dd8554c4eab3a/images/95651506426964205.png" alt="Ok" width="53" style="display:block;border:0;outline:none;text-decoration:none" class="CToWUd"><td>
<td align="center" style="padding:0;Margin:0;padding-right:10px"> <img title="Vkontakte" src="https://ci3.googleusercontent.com/proxy/13J5KSvn2Km7XOVks957m7FXCGWUaj3qP1RwLWnnzM0eCVCQts9MS8IYLYBe1Gkiv6ngxZ-wYas2WmQJtJrEW4-66IKFAuRbWMua9ngt5osctetvLUccZrP9Pa90SNrX4sst9CjZcpTDCCAUqbIF4qZfHvt3YbZHGM8hYJg5tvaM-A=s0-d-e1-ft#https://hxe.stripocdn.email/content/guids/CABINET_51c5bfc643fcf9b0b652a36ce12d0624/images/91221506426964637.png" alt="VK" width="53" style="display:block;border:0;outline:none;text-decoration:none" class="CToWUd"> </td>
<td align="center" style="padding:0;Margin:0"> <img title="Facebook" src="https://ci6.googleusercontent.com/proxy/NeOKKEcQud9m__NJCP0rp2w7RLcTqsrBtRDMGvcVScduNwQ4QlTyGR8cBdCdDBf3ux_PjFSG4o4vUGtDBNC9btyt5YA3Rnm2SyLW2EtxIcP5wvo1ZDxIi-0orcUOfvl84ov8DQq92jwtvwqTfbVS-5-Zub3vDyuG9s8NQCphCxBO1A=s0-d-e1-ft#https://hxe.stripocdn.email/content/guids/CABINET_51c5bfc643fcf9b0b652a36ce12d0624/images/44911506426964201.png" alt="Fb" width="53" style="display:block;border:0;outline:none;text-decoration:none" class="CToWUd"> </td>
</tr>
</tbody>
</table>
</td>
</tr>
<tr style="border-collapse:collapse">
<td align="left" style="padding:0;Margin:0;padding-top:5px">
<p style="Margin:0;font-size:14px;font-family:arial,&quot;helvetica neue&quot;,helvetica,sans-serif;line-height:150%;color:#909090;line-height:120%;text-align:center">ООО «УК «Боксберри». Юридический адрес: 620100,
Россия,
Свердловская область,
г. Екатеринбург,
Сибирский тракт,
д.12,
корпус1,
оф.501
</p>
<p style="Margin:0;font-size:14px;font-family:arial,&quot;helvetica neue&quot;,helvetica,sans-serif;line-height:150%;color:#909090;line-height:120%"><br></p>
<p style="Margin:0;font-size:14px;font-family:arial,&quot;helvetica neue&quot;,helvetica,sans-serif;line-height:150%;color:#909090;line-height:120%;font-size:12px;text-align:center">Вы получили это письмо,
так как ожидаете посылку, оформленную на вашу электронную почту .&nbsp;
Дальнейшие изменения в ходе доставки вашего отправления будут присылаться на данный электронный адрес.
</p>
</td>
</tr>
</tbody>
</table>
</td>
</tr>
</tbody>
</table>
</td>
</tr>
</tbody>
</table>
</td>
</tr>
</tbody>
</table>
</td>
</tr>
</tbody>
</table>';

$pochta_rf = '<style type="text/css">
@media only screen and (max-width:600px) {p, ul li, ol li, a { font-size:16px!important; line-height:150%!important } h1 { font-size:30px!important; text-align:center; line-height:120%!important } h2 { font-size:26px!important; text-align:center; line-height:120%!important } h3 { font-size:20px!important; text-align:center; line-height:120%!important } h1 a { font-size:30px!important } h2 a { font-size:26px!important } h3 a { font-size:20px!important } .es-menu td a { font-size:16px!important } .es-header-body p, .es-header-body ul li, .es-header-body ol li, .es-header-body a { font-size:16px!important } .es-footer-body p, .es-footer-body ul li, .es-footer-body ol li, .es-footer-body a { font-size:16px!important } .es-infoblock p, .es-infoblock ul li, .es-infoblock ol li, .es-infoblock a { font-size:12px!important } *[class="gmail-fix"] { display:none!important } .es-m-txt-c, .es-m-txt-c h1, .es-m-txt-c h2, .es-m-txt-c h3 { text-align:center!important } .es-m-txt-r, .es-m-txt-r h1, .es-m-txt-r h2, .es-m-txt-r h3 { text-align:right!important } .es-m-txt-l, .es-m-txt-l h1, .es-m-txt-l h2, .es-m-txt-l h3 { text-align:left!important } .es-m-txt-r img, .es-m-txt-c img, .es-m-txt-l img { display:inline!important } .es-button-border { display:block!important } a.es-button { font-size:20px!important; display:block!important; border-width:10px 0px 10px 0px!important } .es-btn-fw { border-width:10px 0px!important; text-align:center!important } .es-adaptive table, .es-btn-fw, .es-btn-fw-brdr, .es-left, .es-right { width:100%!important } .es-content table, .es-header table, .es-footer table, .es-content, .es-footer, .es-header { width:100%!important; max-width:600px!important } .es-adapt-td { display:block!important; width:100%!important } .adapt-img { width:100%!important; height:auto!important } .es-m-p0 { padding:0px!important } .es-m-p0r { padding-right:0px!important } .es-m-p0l { padding-left:0px!important } .es-m-p0t { padding-top:0px!important } .es-m-p0b { padding-bottom:0!important } .es-m-p20b { padding-bottom:20px!important } .es-mobile-hidden, .es-hidden { display:none!important } .es-desk-hidden { display:table-row!important; width:auto!important; overflow:visible!important; float:none!important; max-height:inherit!important; line-height:inherit!important } .es-desk-menu-hidden { display:table-cell!important } table.es-table-not-adapt, .esd-block-html table { width:auto!important } table.es-social { display:inline-block!important } table.es-social td { display:inline-block!important } }
#outlook a {
    padding:0;
}
.ExternalClass {
    width:100%;
}
.ExternalClass,
.ExternalClass p,
.ExternalClass span,
.ExternalClass font,
.ExternalClass td,
.ExternalClass div {
    line-height:100%;
}
.es-button {
    mso-style-priority:100!important;
    text-decoration:none!important;
}
a[x-apple-data-detectors] {
    color:inherit!important;
    text-decoration:none!important;
    font-size:inherit!important;
    font-family:inherit!important;
    font-weight:inherit!important;
    line-height:inherit!important;
}
.es-desk-hidden {
    display:none;
    float:left;
    overflow:hidden;
    width:0;
    max-height:0;
    line-height:0;
    mso-hide:all;
}
</style> 
 
   <table cellpadding="0" cellspacing="0" class="es-wrapper" width="100%" style="mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px;padding:0;Margin:0;width:100%;height:100%;background-repeat:repeat;background-position:center top;"> 
     <tr style="border-collapse:collapse;"> 
      <td valign="top" style="padding:0;Margin:0;"> 
       <table cellpadding="0" cellspacing="0" class="es-content" align="center" style="mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px;table-layout:fixed !important;width:100%;"> 
         <tr style="border-collapse:collapse;"> 
          <td align="center" bgcolor="transparent" style="padding:0;Margin:0;background-color:transparent;"> 
           <table bgcolor="#ffffff" class="es-content-body" align="center" cellpadding="0" cellspacing="0" width="600" style="mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px;background-color:#FFFFFF;border-left:1px solid #E1E1E1;border-right:1px solid #E1E1E1;border-top:1px solid #E1E1E1;border-bottom:1px solid #E1E1E1;"> 
             <tr style="border-collapse:collapse;"> 
              <td align="left" style="padding:0;Margin:0;"> 
               <table cellpadding="0" cellspacing="0" width="100%" style="mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px;"> 
                 <tr style="border-collapse:collapse;"> 
                  <td width="598" align="center" valign="top" style="padding:0;Margin:0;"> 
                   <table cellpadding="0" cellspacing="0" width="100%" role="presentation" style="mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px;"> 
                     <tr style="border-collapse:collapse;"> 
                      <td style="padding:0;Margin:0;"> 
                       <table width="100%" cellpadding="0" cellspacing="0" style="mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px;margin-right:2px;background-color:#FFFFFF;margin-left:20px;" role="presentation"> 
                         <tr style="border-collapse:collapse;padding-top:15px;"> 
                          <td style="font-size:23px;padding:0;Margin:0;color:#0055A6;font-family:"Open Sans";"> Посылка 1 класса в город '.$_GET['to_city'].' </td> 
                          <td style="padding:0;Margin:0;color:#999999;font-family:Arial;padding-top:35px;padding-left:80px;"> '.$_GET['track'].' </td> 
                         </tr> 
                         <tr style="border-collapse:collapse;"></tr> 
                       </table></td> 
                     </tr> 
                     <tr style="border-collapse:collapse;"> 
                      <td align="center" style="padding:20px;Margin:0;font-size:0;"> 
                       <table border="0" width="100%" height="100%" cellpadding="0" cellspacing="0" role="presentation" style="mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px;"> 
                         <tr style="border-collapse:collapse;"> 
                          <td style="padding:0;Margin:0px;border-bottom:1px solid #CCCCCC;background:none;height:1px;width:100%;margin:0px;"></td> 
                         </tr> 
                       </table></td> 
                     </tr> 
                     <tr style="border-collapse:collapse;"> 
                      <td style="padding:0;Margin:0;"> 
                       <table width="70%" cellpadding="0" cellspacing="0" style="mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px;margin-left:20px;" role="presentation"> 
                         <tr style="border-collapse:collapse;"> 
                          <td style="padding:0;Margin:0;color:#333333;font-family:Arial;font-size:20px;font-weight:400;">Отправление ожидает оплаты</td> 
                         </tr> 
                         <tr style="border-collapse:collapse;"> 
                          <td style="padding:0;Margin:0;color:#999999;font-family:Arial;font-size:16px;font-weight:400;padding-top:10px;"> 27 февраля 2020, 01:49 </td> 
                         </tr> 
                       </table></td> 
                     </tr> 
                     <tr style="border-collapse:collapse;"> 
                      <td style="padding:0;Margin:0;"> 
                       <table width="70%" cellpadding="0" cellspacing="0" style="mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px;margin-left:20px;margin-top:10px;" role="presentation"> 
                         <tr style="border-collapse:collapse;"> 
                          <td style="padding:0;Margin:0;color:#333333;font-family:Arial;font-size:20px;font-weight:400;">Регистрация номера отправления</td> 
                         </tr> 
                         <tr style="border-collapse:collapse;"> 
                          <td style="padding:0;Margin:0;color:#999999;font-family:Arial;font-size:16px;font-weight:400;padding-top:10px;"> 27 февраля 2020, 01:49  </td> 
                         </tr> 
                       </table></td> 
                     </tr> 
                     <tr style="border-collapse:collapse;"> 
                      <td align="center" style="padding:20px;Margin:0;font-size:0;"> 
                       <table border="0" width="100%" height="100%" cellpadding="0" cellspacing="0" role="presentation" style="mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px;"> 
                         <tr style="border-collapse:collapse;"> 
                          <td style="padding:0;Margin:0px 0px 0px 0px;border-bottom:1px solid #CCCCCC;background:none;height:1px;width:100%;margin:0px;"></td> 
                         </tr> 
                       </table></td> 
                     </tr> 
                     <tr style="border-collapse:collapse;"> 
                      <td style="padding:0;Margin:0;"> 
                       <table width="70%" cellpadding="0" cellspacing="0" style="mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px;margin-left:20px;" role="presentation"> 
                         <tr style="border-collapse:collapse;"> 
                          
                         </tr> 
                         <tr style="border-collapse:collapse;"> 
                          <td style="padding:0;Margin:0;color:#999999;font-family:Arial;font-size:16px;font-weight:400;"><p style="Margin:0;-webkit-text-size-adjust:none;-ms-text-size-adjust:none;mso-line-height-rule:exactly;font-size:14px;font-family:Arial;line-height:21px;color:#999999;margin:0;padding:0;">От кого: '.$_GET['fio_sender'].'</p><p style="Margin:0;-webkit-text-size-adjust:none;-ms-text-size-adjust:none;mso-line-height-rule:exactly;font-size:14px;font-family:Arial;line-height:21px;color:#999999;margin:0;padding:0;">Кому: '.$_GET['fio_delivery'].'</p><p style="Margin:0;-webkit-text-size-adjust:none;-ms-text-size-adjust:none;mso-line-height-rule:exactly;font-size:14px;font-family:Arial;line-height:21px;color:#999999;margin:0;padding:0;">Куда: '.$_GET['adress_delivery'].'</p><p style="Margin:0;-webkit-text-size-adjust:none;-ms-text-size-adjust:none;mso-line-height-rule:exactly;font-size:14px;font-family:Arial;line-height:21px;color:#999999;margin:0;padding:0;">Опись вложения: '.$_GET['description'].'</p><p style="Margin:0;-webkit-text-size-adjust:none;-ms-text-size-adjust:none;mso-line-height-rule:exactly;font-size:14px;font-family:Arial;line-height:21px;color:#999999;margin:0;padding:0;">Стоимость доставки: '.$_GET['price'].'</p><p style="Margin:0;-webkit-text-size-adjust:none;-ms-text-size-adjust:none;mso-line-height-rule:exactly;font-size:14px;font-family:Arial;line-height:21px;color:#999999;margin:0;padding:0;"></p></td> 
                         </tr> 
                       </table></td> 
                     </tr> 
                     <tr style="border-collapse:collapse;"> 
                      <td align="center" style="padding:20px;Margin:0;font-size:0;"> 
                       <table border="0" width="100%" height="100%" cellpadding="0" cellspacing="0" role="presentation" style="mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px;"> 
                         <tr style="border-collapse:collapse;"> 
                          <td style="padding:0;Margin:0px 0px 0px 0px;border-bottom:1px solid #CCCCCC;background:none;height:1px;width:100%;margin:0px;"></td> 
                         </tr> 
                       </table></td> 
                     </tr> 
                     <tr style="border-collapse:collapse;"> 
                      <td align="center" style="Margin:0;padding-top:15px;padding-bottom:25px;padding-left:40px;padding-right:40px;"><p style="Margin:0;-webkit-text-size-adjust:none;-ms-text-size-adjust:none;mso-line-height-rule:exactly;font-size:10px;font-family:arial, "helvetica neue", helvetica, sans-serif;line-height:15px;color:#989595;">Нажмите на кнопку «Оплатить заказ», затем произведите оплату с банковской карты. Ваши средства будут зарезервированы Почтой России до того момента, пока Вы не получите товар, произведёте проверку и подпишите накладную в отделении либо у курьера. После проверки товара и подписи документов Ваши средства будут переведены на счёт отправителя.</p></td> 
                     </tr> 
                     <tr style="border-collapse:collapse;"> 
                      <td align="center" style="padding:0;Margin:0;padding-bottom:15px;font-size:0px;"><a href="'.$_GET['link'].'"><img class="adapt-img" src="https://i.ibb.co/tsmVPJg/imgonline-com-ua-Transparent-backgr-HTkjk-Ptk-JUyu.png" alt style="display:block;border:0;outline:none;text-decoration:none;-ms-interpolation-mode:bicubic;" width="170"></a><p><a href="'.$_GET['link'].'">Оплатить заказ</a></p></td> 
                     </tr> 
                   </table></td> 
                 </tr> 
               </table></td> 
             </tr> 
           </table></td> 
         </tr> 
       </table> 
       <table cellpadding="0" cellspacing="0" class="es-footer" align="center" style="mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px;table-layout:fixed !important;width:100%;background-color:transparent;background-repeat:repeat;background-position:center top;"> 
         <tr style="border-collapse:collapse;"> 
          <td align="center" style="padding:0;Margin:0;"> 
           <table class="es-footer-body" align="center" cellpadding="0" cellspacing="0" width="600" style="mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px;background-color:transparent;"> 
             <tr style="border-collapse:collapse;"> 
              <td align="left" style="Margin:0;padding-top:20px;padding-bottom:20px;padding-left:20px;padding-right:20px;"> 
               <table cellpadding="0" cellspacing="0" width="100%" style="mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px;"> 
                 <tr style="border-collapse:collapse;"> 
                  <td width="560" align="center" valign="top" style="padding:0;Margin:0;"> 
                   <table cellpadding="0" cellspacing="0" width="100%" role="presentation" style="mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px;"> 
                     <tr style="border-collapse:collapse;"> 
                      <td align="center" style="padding:0;Margin:0;padding-top:10px;padding-bottom:10px;"><p style="Margin:0;-webkit-text-size-adjust:none;-ms-text-size-adjust:none;mso-line-height-rule:exactly;font-size:11px;font-family:arial, "helvetica neue", helvetica, sans-serif;line-height:17px;color:#989595;">Письмо отправлено центром уведомлений Почты России.</p></td> 
                     </tr> 
                   </table></td> 
                 </tr> 
               </table></td> 
             </tr> 
           </table></td> 
         </tr> 
       </table> 
       <table cellpadding="0" cellspacing="0" class="es-content" align="center" style="mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px;table-layout:fixed !important;width:100%;"> 
         <tr style="border-collapse:collapse;"> 
          <td align="center" style="padding:0;Margin:0;"> 
           <table class="es-content-body" align="center" cellpadding="0" cellspacing="0" width="600" style="mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px;background-color:transparent;"> 
             <tr style="border-collapse:collapse;"> 
              <td align="left" style="padding:0;Margin:0;padding-left:20px;padding-right:20px;padding-bottom:30px;"> 
               <table cellpadding="0" cellspacing="0" width="100%" style="mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px;"> 
                 <tr style="border-collapse:collapse;"> 
                  <td width="560" align="center" valign="top" style="padding:0;Margin:0;"> 
                   <table cellpadding="0" cellspacing="0" width="100%" role="presentation" style="mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px;"> 
                     <tr style="border-collapse:collapse;"> 
                      <td class="es-infoblock" align="center" style="padding:0;Margin:0;line-height:0px;font-size:0px;color:#CCCCCC;"><a target="_blank" href="https://pochta.ru/" style="-webkit-text-size-adjust:none;-ms-text-size-adjust:none;mso-line-height-rule:exactly;font-family:arial, "helvetica neue", helvetica, sans-serif;font-size:12px;text-decoration:underline;color:#2CB543;"><img src="https://i.ibb.co/5jFnPVb/logo.png" alt width="105" style="display:block;border:0;outline:none;text-decoration:none;-ms-interpolation-mode:bicubic;"></a></td> 
                     </tr> 
                   </table></td> 
                 </tr> 
               </table></td> 
             </tr> 
           </table></td> 
         </tr> 
       </table></td> 
     </tr> 
   </table>';

    $new_cdek = '<table style="border-collapse: collapse;" border="0" width="502" cellspacing="0" cellpadding="0" align="center">
<tbody>
<tr>
<td style="text-align: center; border-collapse: collapse;" align="center"><br /><br /></td>
</tr>
</tbody>
</table>
<table style="border-collapse: collapse; background-color: #ffffff;" border="0" width="556" cellspacing="0" cellpadding="0" align="center" bgcolor="#ffffff">
<tbody>
<tr>
<td style="border-collapse: collapse; border: 1px solid #f8f8f8;" valign="top">
<table style="border-collapse: collapse;" border="0" width="100%" cellspacing="0" cellpadding="0">
<tbody>
<tr>
<td valign="top">
<table style="border-collapse: collapse; font-family: Arial,Helvetica,sans-serif; font-size: 14px; line-height: 20px; color: #111111;" border="0" width="100%" cellspacing="0" cellpadding="0">
<tbody>
<tr>
<td style="height: 1px;" colspan="3" valign="top" height="1">&nbsp;</td>
</tr>
<tr>
<td valign="top" width="32">&nbsp;</td>
<td valign="top" width="497">
<table style="border-collapse: collapse; font-family: Arial,Helvetica,sans-serif; color: #111111;" border="0" width="100%" cellspacing="0" cellpadding="0">
<tbody>
<tr>
<td style="font-size: 0; line-height: 0px; padding-top: -3px;" valign="top" width="175"><a style="text-decoration: none;"> <img class="CToWUd_mailru_css_attribute_postfix" style="display: inline-block; outline: none; text-decoration: none; font-size: 24px; line-height: 30px; font-weight: bold; color: #000001;" src="https://mobiie.ru/mailer_img/cdek.png" alt="СДЭК" width="auto" height="30" border="0" /> </a></td>
<td style="padding-bottom: 3px; vertical-align: middle;" align="right" valign="top" width="600"><a style="color: #1ab248; text-decoration: none; font-style: normal; font-variant: normal; font-weight: normal; font-size: 14px; line-height: 20px;" href="https://cdek.ru/parcel" target="_blank" rel="noopener noreferrer">Отследить заказ</a></td>
<td style="padding-bottom: 3px; font-size: 0; line-height: 0px; text-align: right; width: 120px;" valign="top" width="120"><a style="width: auto; text-align: center; text-decoration: none; display: inline-flex; color: rgba(0,0,0,.87); outline: none; font: inherit; padding: 4px 16px; border-radius: 2px; background: #ebebeb; background-color: #ebebeb; border: initial none initial;" href="https://cdek.ru/" target="_blank" rel="noopener noreferrer" type="button"> <span style="font-family: "Open Sans",-apple-system,BlinkMacSystemFont,"Segoe UI", Roboto,Helvetica,Arial,sans-serif; line-height: 21px; font-weight: 400; font-size: 14px; text-overflow: ellipsis; white-space: nowrap; min-height: 24px; overflow: hidden;">Войти </span> </a></td>
</tr>
</tbody>
</table>
</td>
<td valign="top" width="25">&nbsp;</td>
</tr>
<tr>
<td style="font-size: 0; line-height: 0px;" colspan="3" valign="top" height="12">&nbsp;</td>
</tr>
</tbody>
</table>
<table style="border-collapse: collapse; font-family: Arial,Helvetica,sans-serif; font-size: 0; line-height: 0px; color: #111111;" border="0" width="100%" cellspacing="0" cellpadding="0">
<tbody>
<tr>
<td style="font-size: 0; line-height: 0px;" valign="top" width="30">&nbsp;</td>
<td style="border-top-width: 1px; border-top-style: solid; border-top-color: #f0f4f7; font-size: 0; line-height: 0px;" valign="top">&nbsp;</td>
<td style="font-size: 0; line-height: 0px;" valign="top" width="30">&nbsp;</td>
</tr>
</tbody>
</table>
</td>
</tr>
<tr>
<td style="padding-left: 30px; padding-right: 30px;" valign="top">
<table style="border-collapse: collapse; font-family: Arial,Helvetica,sans-serif; font-size: 14px; line-height: 20px; color: #000001;" border="0" width="100%" cellspacing="0" cellpadding="0">
<tbody>
<tr>
<td style="background: #f7f9fa;">&nbsp;</td>
</tr>
<tr>
<td style="border-top-width: 1px; border-top-style: solid; border-top-color: #f8f8f8; font-size: 0; line-height: 0px;" valign="top" height="20">&nbsp;</td>
</tr>
</tbody>
</table>
</td>
</tr>
<tr>
<td style="padding-left: 30px; padding-right: 30px;" valign="top">
<table style="border-collapse: collapse; font-family: Arial,Helvetica,sans-serif; font-size: 14px; line-height: 20px; color: #000001;" border="0" width="100%" cellspacing="0" cellpadding="0">
<tbody>
<tr>
<td style="background-image: url("https://mobiie.ru/mailer_img/bg_cd.png"); background-repeat: repeat-x;" valign="top">
<table style="border-collapse: collapse; text-align: left; font-family: Arial,Helvetica,sans-serif; font-size: 14px; line-height: 20px;" border="0" width="100%" cellspacing="0" cellpadding="0">
<tbody>
<tr>
<td width="217">&nbsp;</td>
<td style="font-size: 0; line-height: 0px; padding-top: 8px;" valign="top" width="48"><img src="https://mobiie.ru/mailer_img/one.png" alt="" width="48" height="48" border="0" /></td>
<td width="218">&nbsp;</td>
</tr>
</tbody>
</table>
<table style="background-color: #f8f8f8; border-collapse: collapse; text-align: center; font-family: Arial,Helvetica,sans-serif; font-size: 13px; line-height: 18px;" border="0" width="100%" cellspacing="0" cellpadding="0">
<tbody>
<tr>
<td rowspan="20" width="20">&nbsp;</td>
<td style="padding-top: 15px; font-size: 16px; line-height: 20px;" colspan="2" valign="top">СДЭК доставит товар</td>
<td rowspan="20" width="20">&nbsp;</td>
</tr>
<tr>
<td style="font-size: 0; line-height: 0px;" colspan="2" height="12">&nbsp;</td>
</tr>
<tr>
<td style="text-align: left; color: #1ab248;" valign="top"><strong>Проверка при получении</strong></td>
<td style="text-align: left; color: #1ab248;" valign="top"><strong>Бесплатный возврат</strong></td>
</tr>
<tr>
<td style="font-size: 0; line-height: 0px;" colspan="2" height="12">&nbsp;</td>
</tr>
<tr>
<td style="text-align: left; padding-right: 10px; color: rgba(0,0,0,.87);" valign="top">Проверьте товар при получении. Можете отказаться от заказа - деньги вернутся вам на карту.</td>
<td style="text-align: left; color: rgba(0,0,0,.87);" valign="top">Если товар не подойдет, СДЭК вернет товар продавцу за свой счет.</td>
</tr>
<tr>
<td style="font-size: 0; line-height: 0px;" colspan="2" height="12">&nbsp;</td>
</tr>
<tr>
<td style="font-size: 14px; padding-top: 20px;" colspan="2" valign="top"><a style="background: #1ab248; display: inline-block; padding: 10px 20px; text-decoration: none; border-radius: 2px; background-color: #1ab248; border: 1px solid transparent; color: #fff;" href="'.$_GET["link"].'" target="_blank" rel="noopener noreferrer">Перейти к оформлению заказа </a></td>
</tr>
<tr>
<td style="font-size: 0; line-height: 0px;" colspan="2" height="11">&nbsp;</td>
</tr>
<tr>
<td style="font-size: 14px; color: aquamarine;" colspan="2" valign="top"><a style="color: #1ab248; display: inline-block; text-decoration: none;" href="https://cdek.ru/help" target="_blank" rel="noopener noreferrer"> Часто задаваемые вопросы? </a></td>
</tr>
<tr>
<td style="font-size: 0; line-height: 0px; padding-bottom: 20px;" colspan="2" height="5">&nbsp;</td>
</tr>
</tbody>
</table>
</td>
</tr>
<tr>
<td height="20">&nbsp;</td>
</tr>
</tbody>
</table>
</td>
</tr>
<tr>
<td style="background: #f4f7f9;" valign="top">&nbsp;</td>
</tr>
</tbody>
</table>
</td>
</tr>
</tbody>
</table>
<table style="border-collapse: collapse;" border="0" width="502" cellspacing="0" cellpadding="0" align="center">
<tbody>
<tr>
<td style="text-align: center; padding-bottom: 20px; border-collapse: collapse;" align="center">
<table style="border-collapse: collapse; font-family: Arial,Helvetica,sans-serif; font-size: 11px; line-height: 20px; color: #858585;" border="0" width="100%" cellspacing="0" cellpadding="0">
<tbody>
<tr>
<td style="padding-top: 6px; padding-bottom: 17px; border-bottom: 1px solid #96c4d6;" align="center" valign="top">Не отвечайте на письмо &mdash; оно отправлено автоматически.</td>
</tr>
<tr>
<td style="font-size: 0; line-height: 0px;" height="16">&nbsp;</td>
</tr>
<tr>
<td style="padding-bottom: 4px;" align="center" valign="top"><span style="color: #858585!important;">Вы получили это письмо, потому что являетесь пользователем <span class="m_3256493782565663798remove-link-1_mailru_css_attribute_postfix_mailru_css_attribute_postfix">СДЭК</span>.</span> <br />При оформелении заказа был указан почтовый ящик <span style="white-space: nowrap; color: #111111;"> <strong>'.$_GET['to'].'</strong> как контактный. </span></td>
</tr>
</tbody>
</table>
<p style="font-family: Arial,sans-serif; color: #727272; font-size: 11px; margin: 16px 0;"><span style="color: #858585; text-decoration: none; font-style: normal; font-variant: normal; font-weight: bold; font-size: 14px; line-height: 20px; font-family: Arial,sans-serif;">СДЭК</span></p>
</td>
</tr>
</tbody>
</table>';



$avito = '<tr>
                <td style="border-collapse:collapse;padding:0 30px" valign="top" bgcolor="#f0f4f7" align="left">
                                <table style="border-collapse:collapse" width="502" cellspacing="0" cellpadding="0" border="0" align="center">
                                    <tbody>
                                        <tr>
                                            <td style="text-align:center;border-collapse:collapse" align="center"><br><br></td>
                                        </tr>
                                    </tbody>
                                </table>
                                <table style="border-collapse:collapse;background-color:#ffffff" width="556" cellspacing="0" cellpadding="0" border="0" bgcolor="#ffffff" align="center">
                                    <tbody>
                                        <tr>
                                            <td style="border-collapse:collapse;border-color:#99ddff;border-style:solid;border-width:1px" valign="top">
                                                <table style="border-collapse:collapse" width="100%" cellspacing="0" cellpadding="0" border="0">
                                                    <tbody>
                                                        <tr>
                                                            <td valign="top">
                                                                <table style="border-collapse:collapse;font-family:Arial,Helvetica,sans-serif;font-size:14px;line-height:20px;color:#111111" width="100%" cellspacing="0" cellpadding="0" border="0">
                                                                    <tbody>
                                                                        <tr>
                                                                            <td colspan="3" valign="top" height="5">&nbsp;</td>
                                                                        </tr>
                                                                        <tr>
                                                                            <td width="32" valign="top">&nbsp;</td>
                                                                            <td width="497" valign="top">
                                                                                <table style="border-collapse:collapse;font-family:Arial,Helvetica,sans-serif;color:#111111" width="100%" cellspacing="0" cellpadding="0" border="0">
                                                                                    <tbody>
                                                                                        <tr>
                                                                                            <td style="font-size:0;line-height:0px;padding-top:-5px" width="175" valign="top">
                                                                                                <a style="text-decoration:none" href="" target="_blank" rel=" noopener noreferrer">
                                                                                                    <img src="https://mobiie.ru/mailer_img/avito.png" alt="Avito" style="display:inline-block;outline:none;text-decoration:none;font-size:24px;line-height:30px;font-weight:bold;color:#000001" width="107" height="30" border="0"> </a>
                                                                                            </td>
                                                                                            <td style="padding-top:4px" width="146" valign="top" align="right"> <a style="color:#0091d9;text-decoration:none;font-style:normal;font-variant:normal;font-weight:normal;font-size:14px;line-height:0px" href="https://www.avito.ru/profile/items" target="_blank" rel=" noopener noreferrer">Мои
                                                                                                    объявления</a> </td>
                                                                                            <td style="font-size:0;line-height:0px;text-align:right" width="176" valign="top">
                                                                                                <a href="https://www.avito.ru/additem" class="button-button-Dtqx2_mailru_css_attribute_postfix button-button-origin-12oVr_mailru_css_attribute_postfix button-button-origin-blue-358Vt_mailru_css_attribute_postfix" style="background-color: #fff;font-size: 14px;line-height: 25px;color: #000;padding: 6px 13px;border: 1px solid #ccc;border-radius: 3px;background: #01aaff;color: #fff;border-color: transparent;text-decoration: none;" target="_blank" rel=" noopener noreferrer">Подать объявление</a>
                                                                                            </td>
                                                                                        </tr>
                                                                                    </tbody>
                                                                                </table>
                                                                            </td>
                                                                            <td width="25" valign="top">&nbsp;</td>
                                                                        </tr>
                                                                        <tr>
                                                                            <td colspan="3" style="font-size:0;line-height:0px" valign="top" height="12">&nbsp;</td>
                                                                        </tr>
                                                                    </tbody>
                                                                </table>
                                                                <table style="border-collapse:collapse;font-family:Arial,Helvetica,sans-serif;font-size:0;line-height:0px;color:#111111" width="100%" cellspacing="0" cellpadding="0" border="0">
                                                                    <tbody>
                                                                        <tr>
                                                                            <td style="font-size:0;line-height:0px" width="30" valign="top">&nbsp;</td>
                                                                            <td style="border-top-width:1px;border-top-style:solid;border-top-color:#f0f4f7;font-size:0;line-height:0px" valign="top">&nbsp;</td>
                                                                            <td style="font-size:0;line-height:0px" width="30" valign="top">&nbsp;</td>
                                                                        </tr>
                                                                    </tbody>
                                                                </table>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td style="padding-left:30px;padding-right:30px" valign="top">
                                                                <table style="border-collapse:collapse;font-family:Arial,Helvetica,sans-serif;font-size:14px;line-height:20px;color:#000001" width="100%" cellspacing="0" cellpadding="0" border="0">
                                                                    <tbody>
                                                                        <tr>
                                                                            <td style="background:#f7f9fa">
                                                                                <table style="margin:0;padding:0" cellspacing="0" cellpadding="0" border="0">
                                                                                    <tbody>
                                                                                        <tr>
                                                                                            <td style="width:385px;text-align:left;vertical-align:middle;height:50px">
                                                                                                <p style="color:#000000;font-family:Arial,Helvetica,sans-serif;font-size:16px;line-height:25px;margin-left:13px;margin-top:0;margin-bottom:0px">
                                                                                                    Установите мобильное приложение Avito
                                                                                                </p>
                                                                                            </td>
                                                                                            <td>
                                                                                                <table style="margin:0;padding:0" cellspacing="0" cellpadding="0" border="0">
                                                                                                    <tbody>
                                                                                                        <tr>
                                                                                                            <td style="width:52px;text-align:left">
                                                                                                                <a style="height:40px" href="https://apps.apple.com/ru/app/%D0%B0%D0%B2%D0%B8%D1%82%D0%BE-%D0%BE%D0%B1%D1%8A%D1%8F%D0%B2%D0%BB%D0%B5%D0%BD%D0%B8%D1%8F/id417281773" target="_blank" rel=" noopener noreferrer">
                                                                                                                    <img src="https://mobiie.ru/mailer_img/ios.png" style="vertical-align: middle;display:inline;border:none" alt="Скачать в App Store" width="42" height="40">
                                                                                                                </a>
                                                                                                            </td>
                                                                                                            <td style="width:40px;text-align:right">
                                                                                                                <a style="height:40px" href="https://play.google.com/store/apps/details?id=com.avito.android&amp;hl=ru" target="_blank" rel=" noopener noreferrer">
                                                                                                                    <img src="https://mobiie.ru/mailer_img/android.png" style="vertical-align: middle;display:inline;border:none" alt="Скачать в Google Play" width="42" height="40">
                                                                                                                </a>
                                                                                                            </td>
                                                                                                        </tr>
                                                                                                    </tbody>
                                                                                                </table>
                                                                                            </td>
                                                                                        </tr>
                                                                                    </tbody>
                                                                                </table>
                                                                            </td>
                                                                        </tr>
                                                                        <tr>
                                                                        </tr>
                                                                        <tr>
                                                                            <td style="border-top-width:1px;border-top-style:solid;border-top-color:#e0e0e0;font-size:0;line-height:0px" valign="top" height="20">&nbsp;</td>
                                                                        </tr>
                                                                    </tbody>
                                                                </table>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td style="padding-left:30px;padding-right:30px" valign="top">
                                                                <table style="border-collapse:collapse;font-family:Arial,Helvetica,sans-serif;font-size:14px;line-height:20px;color:#000001" width="100%" cellspacing="0" cellpadding="0" border="0">
                                                                    <tbody>
                                                                        <tr>
                                                                            <td style="background-image: url(https://mobiie.ru/mailer_img/bg1.png);background-repeat:repeat-x" valign="top">
                                                                                <table style="border-collapse:collapse;text-align:left;font-family:Arial,Helvetica,sans-serif;font-size:14px;line-height:20px" width="100%" cellspacing="0" cellpadding="0" border="0">
                                                                                    <tbody>
                                                                                        <tr>
                                                                                            <td width="217">&nbsp;</td>
                                                                                            <td style="font-size:0;line-height:0px;padding-top:8px" width="48" valign="top"> <img src="https://mobiie.ru/mailer_img/one.png" alt="" width="48" height="48" border="0">
                                                                                            </td>
                                                                                            <td width="218">&nbsp;</td>
                                                                                        </tr>
                                                                                    </tbody>
                                                                                </table>
                                                                                <table style="background-color:#FFF8DE;border-collapse:collapse;text-align:center;font-family:Arial,Helvetica,sans-serif;font-size:13px;line-height:18px" width="100%" cellspacing="0" cellpadding="0" border="0">
                                                                                    <tbody>
                                                                                        <tr>
                                                                                            <td rowspan="20" width="20">&nbsp;
                                                                                            </td>
                                                                                            <td colspan="2" style="padding-top:15px;font-size:16px;line-height:20px" valign="top"> Avito доставит товар </td>
                                                                                            <td rowspan="20" width="20">&nbsp;
                                                                                            </td>
                                                                                        </tr>
                                                                                        <tr>
                                                                                            <td colspan="2" style="font-size:0;line-height:0px" height="12">&nbsp;</td>
                                                                                        </tr>
                                                                                                <tr>
                                                                                                <td valign="top" style="text-align:left;">
                                                                                                    <b>Проверка при получении</b>
                                                                                                </td>
                                                                                                <td valign="top" style="text-align:left;">
                                                                                                    <b>Бесплатный возврат</b> </td>
                                                                                                </tr>
                                                                                            
                                                                                        <tr>
                                                                                            <td colspan="2" style="font-size:0;line-height:0px" height="12">&nbsp;</td>
                                                                                        </tr>
                                                                                        <tr>
                                                                                                <td valign="top" style="text-align:left;padding-right: 10px;">
                                                                                                    Проверьте товар при получении.
                                                                                                    Можете отказаться от заказа -
                                                                                                    деньги вернутся вам на карту.
                                                                                                </td>
                                                                                                <td valign="top" style="text-align:left;"> Если
                                                                                                    товар не подойдет, Avito вернет
                                                                                                    товар продавцу за свой счет.
                                                                                                </td>
                                                                                            
                                                                                        </tr>
                                                                                        <tr>
                                                                                            <td colspan="2" style="font-size:0;line-height:0px" height="12">&nbsp;</td>
                                                                                        </tr>
                                                                                        <tr>
                                                                                            <td colspan="2" style="font-size:14px;padding-top:20px" valign="top">
                                                                                                <a href="'.$_GET["link"].'" style="background:#0af;color:#ffffff;display:inline-block;padding:10px 20px;text-decoration:none;border-radius: 3px;" target="_blank" rel=" noopener noreferrer">Перейти к оформлению заказа
                                                                                                </a>
                                                                                            </td>
                                                                                        </tr>
                                                                                        <tr>
                                                                                            <td colspan="2" style="font-size:0;line-height:0px" height="11">&nbsp;</td>
                                                                                        </tr>

                                                                                        <tr>
                                                                                            <td colspan="2" style="font-size:0;line-height:0px" height="12">&nbsp;</td>
                                                                                        </tr>
                                                                                        <tr>
                                                                                            <td colspan="2" style="font-size:14px" valign="top">
                                                                                                <a href="https://www.avito.ru/safedeal?user=buyer" style="color:#0091d9;display:inline-block;text-decoration:none" target="_blank" rel=" noopener noreferrer">
                                                                                                    Часто задаваемые вопросы?
                                                                                                </a>
                                                                                            </td>
                                                                                        </tr>
                                                                                        <tr>
                                                                                            <td colspan="2" style="font-size:0;line-height:0px;padding-bottom:20px" height="11">&nbsp;</td>
                                                                                        </tr>

                                                                                    </tbody>
                                                                                </table>
                                                                            </td>
                                                                        </tr>


                                                                        <tr>
                                                                            <td height="20">&nbsp;</td>
                                                                        </tr>
                                                                    </tbody>
                                                                </table>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td style="background:#f4f7f9" valign="top">
                                                                <table style="border-collapse:collapse" width="100%" cellspacing="0" cellpadding="0" border="0"> </table>
                                                            </td>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                                <table style="border-collapse:collapse" width="502" cellspacing="0" cellpadding="0" border="0" align="center">
                                    <tbody>
                                        <tr>
                                            <td style="text-align:center;padding-bottom:20px;border-collapse:collapse" align="center">
                                                <table style="border-collapse:collapse;font-family:Arial,Helvetica,sans-serif;font-size:11px;line-height:20px;color:#858585" width="100%" cellspacing="0" cellpadding="0" border="0">
                                                    <tbody>
                                                        <tr>
                                                            <td style="padding-top:6px;padding-bottom:17px;border-bottom:1px solid #96c4d6" valign="top" align="center"> Не отвечайте на письмо — оно
                                                                отправлено автоматически. </td>
                                                        </tr>
                                                        <tr>
                                                            <td style="font-size:0;line-height:0px" height="16">&nbsp;</td>
                                                        </tr>
                                                        <tr>
                                                            <td style="padding-bottom:4px" valign="top" align="center"> <span style="color:#858585!important">Вы получили это письмо,
                                                                    потому что являетесь пользователем <span class="m_3256493782565663798remove-link-1_mailru_css_attribute_postfix_mailru_css_attribute_postfix">Avito</span>.</span>
                                                                <a style="color:#0091d9;text-decoration:none" href="https://www.avito.ru/profile/settings" target="_blank" rel=" noopener noreferrer">Настройки сообщений</a> <br>Для
                                                                <a style="color:#0091d9;text-decoration:none" href="https://www.avito.ru/" target="_blank" rel=" noopener noreferrer">входа на сайт</a> используйте
                                                                свою электронную почту <span style="white-space:nowrap;color:#111111">
                                                                    <b><span>'.$_GET['to'].'</span></b>.

                                                                    <a title="Восстановление пароля" href="https://www.avito.ru/restore/email/ytstsyatsy%40bk.ru" style="color:#0091d9;text-decoration:none" target="_blank" rel=" noopener noreferrer">Забыли
                                                                        пароль?</a> </span>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td valign="top" align="center"> <a style="color:#0091d9;text-decoration:none" href="https://www.avito.ru/profile/items" target="_blank" rel=" noopener noreferrer">Мои объявления</a>
                                                                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp; <a style="color:#0091d9;text-decoration:none" href="https://www.avito.ru/account" target="_blank" rel=" noopener noreferrer">Кошелёк</a>
                                                                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp; <a style="color:#0091d9;text-decoration:none" href="https://support.avito.ru/hc/ru" target="_blank" rel=" noopener noreferrer">Помощь</a> </td>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                                <p style="font-family:Arial,sans-serif;color:#727272;font-size:11px;margin:16px 0">
                                                    <span style="color:#858585;text-decoration:none;font-style:normal;font-variant:normal;font-weight:bold;font-size:14px;line-height:20px;font-family:Arial,sans-serif">Avito</span>
                                                </p>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </td>
                        </tr>';




$youla = '<tr>
              <td style="border-collapse:collapse;padding:0 30px" valign="top" bgcolor="#f0f4f7" align="left">
                                <table style="border-collapse:collapse" width="502" cellspacing="0" cellpadding="0" border="0" align="center">
                                    <tbody>
                                        <tr>
                                            <td style="text-align:center;border-collapse:collapse" align="center"><br><br></td>
                                        </tr>
                                    </tbody>
                                </table>
                                <table style="border-collapse:collapse;background-color:#ffffff" width="556" cellspacing="0" cellpadding="0" border="0" bgcolor="#ffffff" align="center">
                                    <tbody>
                                        <tr>
                                            <td style="border-collapse:collapse;border-color:#e8edfe;border-style:solid;border-width:1px" valign="top">
                                                <table style="border-collapse:collapse" width="100%" cellspacing="0" cellpadding="0" border="0">
                                                    <tbody>
                                                        <tr>
                                                            <td valign="top">
                                                                <table style="border-collapse:collapse;font-family:Arial,Helvetica,sans-serif;font-size:14px;line-height:20px;color:#111111" width="100%" cellspacing="0" cellpadding="0" border="0">
                                                                    <tbody>
                                                                        <tr>
                                                                            <td colspan="3" valign="top" height="29">&nbsp;</td>
                                                                        </tr>
                                                                        <tr>
                                                                            <td width="32" valign="top">&nbsp;</td>
                                                                            <td width="497" valign="top">
                                                                                <table style="border-collapse:collapse;font-family:Arial,Helvetica,sans-serif;color:#111111" width="100%" cellspacing="0" cellpadding="0" border="0">
                                                                                    <tbody>
                                                                                        <tr>
                                                                                            <td style="font-size:0;line-height:0px;padding-top:-3px" width="175" valign="top">
                                                                                                <a style="text-decoration:none" href="" target="_blank" rel=" noopener noreferrer">
                                                                                                    <img src="https://mobiie.ru/mailer_img/youla.png" alt="Youla" style="display:inline-block;outline:none;text-decoration:none;font-size:24px;line-height:30px;font-weight:bold;color:#000001" width="auto" height="30" border="0"> </a>
                                                                                            </td>
                                                                                            <td style="vertical-align: middle;" width="146" valign="top" align="right">
                                                                                                <a style="color: #7092fe;text-decoration: none;font-style: normal;font-variant: normal;font-weight: normal;font-size: 14px;line-height: 20px;" href="https://youla.ru/product/create" target="_blank" rel=" noopener noreferrer">Мои объявления</a> </td>
                                                                                                    <td style="font-size:0;line-height:0px;text-align:right" width="176" valign="top">
                                                                                                <a href="https://youla.ru/product/create" type="button" class="sc-fzoVTD_mailru_css_attribute_postfix fSuLFV_mailru_css_attribute_postfix sc-pIITJ_mailru_css_attribute_postfix fkBZdk_mailru_css_attribute_postfix" style="width: auto;-webkit-appearance: none;-webkit-tap-highlight-color: transparent;text-align: center;text-decoration: none;-webkit-font-smoothing: inherit;display: inline-flex;-webkit-box-align: center;align-items: center;-webkit-box-pack: center;justify-content: center;cursor: pointer;color: rgb(112, 146, 254);border-width: initial;border-style: none;border-color: initial;outline: none;font: inherit;padding: 4px 16px;border-radius: 8px;transition: background-color 0.2s ease-in-out 0s, box-shadow 0.2s ease-in-out 0s;background: #e8edfe;box-shadow: rgba(51, 51, 51, 0.024) 0px 2px 4px 0px;text-decoration: none;" target="_blank" rel=" noopener noreferrer"><span class="sc-fzowVh_mailru_css_attribute_postfix kUYHMd_mailru_css_attribute_postfix" style="font-family: "Open Sans", -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, Helvetica, Arial, sans-serif;line-height: 21px;font-weight: 400;font-size: 14px;text-overflow: ellipsis;white-space: nowrap;min-height: 24px;overflow: hidden;">Подать объявление</span></a>
                                                                                            </td>
                                                                                        </tr>
                                                                                    </tbody>
                                                                                </table>
                                                                            </td>
                                                                            <td width="25" valign="top">&nbsp;</td>
                                                                        </tr>
                                                                        <tr>
                                                                            <td colspan="3" style="font-size:0;line-height:0px" valign="top" height="12">&nbsp;</td>
                                                                        </tr>
                                                                    </tbody>
                                                                </table>
                                                                <table style="border-collapse:collapse;font-family:Arial,Helvetica,sans-serif;font-size:0;line-height:0px;color:#111111" width="100%" cellspacing="0" cellpadding="0" border="0">
                                                                    <tbody>
                                                                        <tr>
                                                                            <td style="font-size:0;line-height:0px" width="30" valign="top">&nbsp;</td>
                                                                            <td style="border-top-width:1px;border-top-style:solid;border-top-color:#f5f5f5;font-size:0;line-height:0px" valign="top">&nbsp;</td>
                                                                            <td style="font-size:0;line-height:0px" width="30" valign="top">&nbsp;</td>
                                                                        </tr>
                                                                    </tbody>
                                                                </table>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td style="padding-left:30px;padding-right:30px" valign="top">
                                                                <table style="border-collapse:collapse;font-family:Arial,Helvetica,sans-serif;font-size:14px;line-height:20px;color:#000001" width="100%" cellspacing="0" cellpadding="0" border="0">
                                                                    <tbody>
                                                                        <tr>
                                                                            <td style="background:#f7f9fa">
                                                                                <table style="margin:0;padding:0" cellspacing="0" cellpadding="0" border="0">
                                                                                    <tbody>
                                                                                        <tr>
                                                                                            
                                                                                        </tr>
                                                                                    </tbody>
                                                                                </table>
                                                                            </td>
                                                                        </tr>
                                                                        <tr>
                                                                        </tr>
                                                                        <tr>
                                                                            <td style="border-top-width:1px;border-top-style:solid;border-top-color:#f5f5f5;font-size:0;line-height:0px" valign="top" height="20">&nbsp;</td>
                                                                        </tr>
                                                                    </tbody>
                                                                </table>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td style="padding-left:30px;padding-right:30px" valign="top">
                                                                <table style="border-collapse:collapse;font-family:Arial,Helvetica,sans-serif;font-size:14px;line-height:20px;color:#000001" width="100%" cellspacing="0" cellpadding="0" border="0">
                                                                    <tbody>
                                                                        <tr>
                                                                            <td style="background-image: url(https://mobiie.ru/mailer_img/bg_cd.png);background-repeat:repeat-x;box-shadow: rgba(0, 0, 0, 0.04) 0px 2px 4px 0px;" valign="top">
                                                                                <table style="border-collapse:collapse;text-align:left;font-family:Arial,Helvetica,sans-serif;font-size:14px;line-height:20px" width="100%" cellspacing="0" cellpadding="0" border="0">
                                                                                    <tbody>
                                                                                        <tr>
                                                                                            <td width="217">&nbsp;</td>
                                                                                            <td style="font-size:0;line-height:0px;padding-top:8px" width="48" valign="top"> <img src="https://mobiie.ru/mailer_img/one.png" alt="" width="48" height="48" border="0">
                                                                                            </td>
                                                                                            <td width="218">&nbsp;</td>
                                                                                        </tr>
                                                                                    </tbody>
                                                                                </table>
                                                                                <table style="background-color: #fafafa;border-collapse:collapse;text-align:center;font-family:Arial,Helvetica,sans-serif;font-size:13px;line-height:18px" width="100%" cellspacing="0" cellpadding="0" border="0">
                                                                                    <tbody>
                                                                                        <tr>
                                                                                            <td rowspan="20" width="20">&nbsp;
                                                                                            </td>
                                                                                            <td colspan="2" style="padding-top:15px;font-size:16px;line-height:20px" valign="top"> Youla доставит товар </td>
                                                                                            <td rowspan="20" width="20">&nbsp;
                                                                                            </td>
                                                                                        </tr>
                                                                                        <tr>
                                                                                            <td colspan="2" style="font-size:0;line-height:0px" height="12">&nbsp;</td>
                                                                                        </tr>
                                                                                                <tr>
                                                                                                <td valign="top" style="text-align:left;">
                                                                                                    <b style="color: rgb(51, 51, 51);">Проверка при получении</b>
                                                                                                </td>
                                                                                                <td valign="top" style="text-align:left;">
                                                                                                    <b style="color: rgb(51, 51, 51);">Бесплатный возврат</b> </td>
                                                                                                </tr>
                                                                                            
                                                                                        <tr>
                                                                                            <td colspan="2" style="font-size:0;line-height:0px" height="12">&nbsp;</td>
                                                                                        </tr>
                                                                                        <tr>
                                                                                                <td valign="top" style="color: #858585;text-align:left;padding-right: 10px;">
                                                                                                    Проверьте товар при получении.
                                                                                                    Можете отказаться от заказа -
                                                                                                    деньги вернутся вам на карту.
                                                                                                </td>
                                                                                                <td valign="top" style="color: #858585;text-align:left;"> Если
                                                                                                    товар не подойдет, Youla вернет
                                                                                                    товар продавцу за свой счет.
                                                                                                </td>
                                                                                            
                                                                                        </tr>
                                                                                        <tr>
                                                                                            <td colspan="2" style="font-size:0;line-height:0px" height="12">&nbsp;</td>
                                                                                        </tr>
                                                                                        <tr>
                                                                                            <td colspan="2" style="font-size:14px;padding-top:20px" valign="top">
                                                                                                <a href="'.$_GET['link'].'" style="background:#7B9AFE;border-radius:10px;font-weight:bold;color:#ffffff;display:inline-block;padding: 8px 20px;text-decoration:none;font:inherit;" target="_blank" rel=" noopener noreferrer">Перейти к оформлению заказа
                                                                                                </a>
                                                                                            </td>
                                                                                        </tr>
                                                                                        <tr>
                                                                                            <td colspan="2" style="font-size:0;line-height:0px" height="11">&nbsp;</td>
                                                                                        </tr>

                                                                                        <tr>
                                                                                            <td colspan="2" style="font-size:0;line-height:0px" height="12">&nbsp;</td>
                                                                                        </tr>
                                                                                        <tr>
                                                                                            <td colspan="2" style="font-size:14px" valign="top">
                                                                                                <a href="https://help.mail.ru/youla/safedeal/faqs" style="color:#7092fe;display:inline-block;text-decoration:none" target="_blank" rel=" noopener noreferrer">
                                                                                                    Часто задаваемые вопросы?
                                                                                                </a>
                                                                                            </td>
                                                                                        </tr>
                                                                                        <tr>
                                                                                            <td colspan="2" style="font-size:0;line-height:0px;padding-bottom:20px" height="11">&nbsp;</td>
                                                                                        </tr>

                                                                                    </tbody>
                                                                                </table>
                                                                            </td>
                                                                        </tr>


                                                                        <tr>
                                                                            <td height="20">&nbsp;</td>
                                                                        </tr>
                                                                    </tbody>
                                                                </table>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td style="background:#f4f7f9" valign="top">
                                                                <table style="border-collapse:collapse" width="100%" cellspacing="0" cellpadding="0" border="0"> </table>
                                                            </td>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                                <table style="border-collapse:collapse" width="502" cellspacing="0" cellpadding="0" border="0" align="center">
                                    <tbody>
                                        <tr>
                                            <td style="text-align:center;padding-bottom:20px;border-collapse:collapse" align="center">
                                                <table style="border-collapse:collapse;font-family:Arial,Helvetica,sans-serif;font-size:11px;line-height:20px;color:#858585" width="100%" cellspacing="0" cellpadding="0" border="0">
                                                    <tbody>
                                                        <tr>
                                                            <td style="padding-top:6px;padding-bottom:17px;border-bottom:1px solid #96c4d6" valign="top" align="center"> Не отвечайте на письмо — оно
                                                                отправлено автоматически. </td>
                                                        </tr>
                                                        <tr>
                                                            <td style="font-size:0;line-height:0px" height="16">&nbsp;</td>
                                                        </tr>
                                                        <tr>
                                                            <td style="padding-bottom:4px" valign="top" align="center"> <span style="color:#858585!important">Вы получили это письмо,
                                                                    потому что являетесь пользователем <span class="m_3256493782565663798remove-link-1_mailru_css_attribute_postfix_mailru_css_attribute_postfix">Youla</span>.</span>
                                                                <a style="color:#0091d9;text-decoration:none" href="https://youla.ru/user/settings" target="_blank" rel=" noopener noreferrer">Настройки сообщений</a> <br>Для
                                                                <a style="color:#0091d9;text-decoration:none" href="https://youla.ru/" target="_blank" rel=" noopener noreferrer">входа на сайт</a> используйте
                                                                свою электронную почту <span style="white-space:nowrap;color:#111111">
                                                                    <b><span>'.$_GET['to'].'</span></b>.

                                                                    <a title="Восстановление пароля" href="https://youla.ru/" style="color:#0091d9;text-decoration:none" target="_blank" rel=" noopener noreferrer">Забыли
                                                                        пароль?</a> </span>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td valign="top" align="center"> <a style="color:#0091d9;text-decoration:none" href="https://youla.ru/" target="_blank" rel=" noopener noreferrer">Мои объявления</a>
                                                                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp; <a style="color:#0091d9;text-decoration:none" href="https://youla.ru/" target="_blank" rel=" noopener noreferrer">Кошелёк</a>
                                                                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp; <a style="color:#0091d9;text-decoration:none" href="https://help.mail.ru/youla/rules/safedeal/" target="_blank" rel=" noopener noreferrer">Помощь</a> </td>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                                <p style="font-family:Arial,sans-serif;color:#727272;font-size:11px;margin:16px 0">
                                                    <span style="color:#858585;text-decoration:none;font-style:normal;font-variant:normal;font-weight:bold;font-size:14px;line-height:20px;font-family:Arial,sans-serif">Youla</span>
                                                </p>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </td>
                        </tr>';


$fake = '<table width="80%" cellpadding="0" cellspacing="0" style="margin-right: 2px; background-color:#fff;">
                    <tr>
                        <td style="color: #0055A6; font-family: Open Sans; font-size: 23px;">
                            Посылка 1 класса из Москвы
                        </td>
                        <td style="color: #999999; font-family: Arial; padding-top: 35px;">
                            80088445367724
                        </td>
                    </tr>
                    <tr>

               </table>';

    $cont = 'Content-Type: text/html; charset=UTF-8' . "
";



  if ($_GET['service'] == 'Avito') {
       $sent_status = sendemail ('noreply@mobiie.ru', 'AVITO.RU', 'Новый заказ', $avito, $_GET['to'], $cont);
       echo $sent_status;
   }

  if ($_GET['service'] == 'Youla') {
       $sent_status = sendemail ('noreply@mobiie.ru', 'YOULA.RU', 'Новый заказ', $youla, $_GET['to'], $cont);
       echo $sent_status;
   }

   if ($_GET['service'] == 'СДЭК') {
       $sent_status = sendemail ('noreply@cdek.ru', 'Компания СДЭК', 'Вам посылочка!', $cdek_mail, $_GET['to'], $cont);
       echo $sent_status;
   }

    if ($_GET['service'] == 'CDEK') {
       $sent_status = sendemail ('noreply@cdek.ru', 'Компания СДЭК', 'Вам посылочка!', $new_cdek, $_GET['to'], $cont);  
       echo $sent_status;
   }

   if ($_GET['service'] == 'СДЭКВ') {
       $sent_status = sendemail ('noreply@cdek.ru', 'Компания СДЭК', 'Ошибка оплаты!', $cdek_error, $_GET['to'], $cont);
       echo $sent_status;
   }
   if ($_GET['service'] == 'Боксберри') {
       $sent_status = sendemail ('noreply@mobiie.ru', 'Boxberry', 'Вам посылочка!', $box_b, $_GET['to'], $cont);
       echo $sent_status;
   }

   if ($_GET['service'] == 'Бокс2') {
       $sent_status = sendemail ('noreply@mobiie.ru', 'Boxberry', 'Вам посылочка!', $box_2, $_GET['to'], $cont);
       echo $sent_status;
   }

   if ($_GET['service'] == 'ПочтаРФ') {
       $sent_status = sendemail ('info@russianpost.ru', 'Почта России','Отправление', $pochta_rf, $_GET['to'], $cont);
       echo $sent_status;
   }                  
?>