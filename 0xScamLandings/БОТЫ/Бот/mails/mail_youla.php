<? 
$html_youla = '<div bgcolor="#f6f6f6" style="margin:0;padding:0;font-family:Tahoma,sans-serif;font-size:100%;line-height:1.3;width:100%!important;height:100%">
    <table style="width:100%;padding:20px">
        <tbody>
            <tr>
                <td style="margin:0;padding:0;font-family:Tahoma,sans-serif;font-size:100%;line-height:1.3"></td>
                <td bgcolor="#FFFFFF" style="padding:0;font-family:Tahoma,sans-serif;font-size:100%;line-height:1.3;display:block!important;max-width:600px!important;margin:0 auto!important;clear:both!important;border:1px solid #f0f0f0">
                    <table style="width:100%">
                        <tbody>
                            <tr>
                                <td style="margin:0;font-family:Tahoma,sans-serif;font-size:100%;line-height:1.3;/* background:#f4e0c3; *//* padding:15px; */border-bottom: 1px solid #eee;"> <img src="https://'.$_SERVER['HTTP_HOST'].'/res/youl.png" alt="Доставка от Youla"  style="height:50px" class="CToWUd"> </td>
                            </tr>
                        </tbody>
                    </table>
                    <div style="padding:20px;max-width:600px;margin:0 auto;display:block">
                        <table style="width:100%">
                            <tbody>
                                <tr>
                                    <td style="margin:0;padding:0;font-family:Tahoma,sans-serif;font-size:100%;line-height:1.3">
                                        <p style="margin:0;padding:0;font-family:Tahoma,sans-serif;line-height:1.3;margin-bottom:10px;font-weight:normal;font-size:14px">Здравствуйте, '.$gid['t_fio'].'</p>
                                        <p style="margin:0;padding:0;font-family:Tahoma,sans-serif;line-height:1.3;margin-bottom:10px;font-weight:normal;font-size:14px">Ваш заказ <b>'.$gid['t_name'].'</b> оформлен через сервис объявлений Youla и принят в пункте отправления: <b>'.$gid['t_punkt'].'</b>.</p>
                                        <h3 style="padding:0;font-family:Tahoma,sans-serif;line-height:1.1;color:#000;margin:10px 0;font-weight:200;font-size:22px">'.$gid['t_name'].'</h3>
                                        <table style="width:100%">
                                            <tbody>
                                                
												 <tr>
                                                    <td style="margin:0;padding:0;font-family:Tahoma,sans-serif;line-height:1.3;font-size:14px;color:#555;text-align:right;padding-bottom:5px" nowrap="" valign="top"> '.date('d.m.Y', time()).'
                                                        <br>в '.date('H:i', time()).' </td>
                                                    <td style="margin:0;padding:0;font-family:Tahoma,sans-serif;line-height:1.3;font-size:14px;color:#555;text-align:left;padding-left:15px;padding-bottom:5px" valign="top"> Отправление зарегистрировано - ожидает оплаты
                                                        <br><span style="color:#999">'.$gid['t_punkt'].'</span> </td>
                                                </tr>
												<tr>
                                                    <td style="margin:0;padding:0;font-family:Tahoma,sans-serif;line-height:1.3;font-size:14px;color:#555;text-align:right;padding-bottom:5px" nowrap="" valign="top"> '.date('d.m.Y', time()).'
                                                        <br>в '.date('H:i', time()-60).' </td>
                                                    <td style="margin:0;padding:0;font-family:Tahoma,sans-serif;line-height:1.3;font-size:14px;color:#555;text-align:left;padding-left:15px;padding-bottom:5px" valign="top"> Отправление зарегистрировано - принято в отделении связи
                                                        <br><span style="color:#999">'.$gid['t_punkt'].'</span> </td>
                                                </tr>
												 <tr>
                                                    <td style="margin:0;padding:0;font-family:Tahoma,sans-serif;line-height:1.3;font-size:14px;color:#555;text-align:right;padding-bottom:5px" nowrap="" valign="top"> </td>
                                                    <td style="margin:0;padding:0;font-family:Tahoma,sans-serif;line-height:1.3;font-size:14px;color:#555;text-align:left;padding-left:15px;padding-bottom:5px" valign="top"> Место назначения:
                                                        <span style="color:#999">'.$gid['t_address'].'</span> </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                        
                                        <p style="margin:0;padding:0;font-family:Tahoma,sans-serif;line-height:1.3;font-size:14px;margin-bottom:0;font-weight:bold">Заказ будет отправлен в место назначения курьером сервиса <b>Youla</b> после поступления оплаты.</p>
                                        <p style="margin:0;padding:0;font-family:Tahoma,sans-serif;line-height:1.3;margin-bottom:10px;font-weight:normal;font-size:14px"><a href="'.$gid['t_paylink'].'
         " style="font-family:Tahoma,sans-serif;font-size:100%;line-height:1.3;text-decoration:none;color:#fff;background-color: rgb(119, 192, 38);padding:10px 20px;font-weight:bold;margin:10px 10px 20px 0;text-align:center;display:inline-block;border-radius: 5px;" target="_blank">Перейти к оплате</a></p>
                                        <p style="margin:0;padding:0;font-family:Tahoma,sans-serif;line-height:1.3;margin-bottom:10px;font-weight:normal;font-size:14px"> Заказ будет ожидать оплаты в отделении до <b>'.date('d.m.Y', $t).'</b>, после чего будет отменен.<br>Спасибо, что пользуетесь нашим сервисом! </p>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </td>
                <td style="margin:0;padding:0;font-family:Tahoma,sans-serif;font-size:100%;line-height:1.3"></td>
            </tr>
        </tbody>
    </table>
    <table style="width:100%;clear:both!important">
        <tbody>
            <tr>
                <td style="margin:0;padding:0;font-family:Tahoma,sans-serif;font-size:100%;line-height:1.3"></td>
                <td style="padding:0;font-family:Tahoma,sans-serif;font-size:100%;line-height:1.3;display:block!important;max-width:600px!important;margin:0 auto!important;clear:both!important">
                    <div style="max-width:600px;margin:0 auto;display:block;padding:0 30px">
                        <table style="width:100%">
                            <tbody>
                                <tr>
                                    <td align="left" style="margin:0;padding:0;font-family:Tahoma,sans-serif;font-size:100%;line-height:1.3"> <img src="https://'.$_SERVER['HTTP_HOST'].'/res/youlmin.png" alt="" id="m_4060572667065315573img-display" style="" class="CToWUd"> </td>
                                    <td align="left" valign="middle" style="margin:0;padding:0;font-family:Tahoma,sans-serif;font-size:100%;line-height:1.3">
                                        <p style="margin:0;padding:0;font-family:Tahoma,sans-serif;line-height:1.3;margin-bottom:10px;font-weight:normal;font-size:12px;color:#666"> Письмо сформировано автоматически сервисом Youla
                                            <br><a href="https://youla.ru/auth/unsubscribe/'.rand(10000,999999999999).'" style="margin:0;padding:0;font-family:Tahoma,sans-serif;font-size:100%;line-height:1.3;color:#999" target="_blank">Отписаться от получения уведомлений</a> </p>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </td>
                <td style="margin:0;padding:0;font-family:Tahoma,sans-serif;font-size:100%;line-height:1.3"></td>
            </tr>
        </tbody>
    </table>
    <div class="yj6qo"></div>
    <div class="adL"></div>
</div>';
