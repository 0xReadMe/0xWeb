<?php
// файл ядра магазина
class core{
// url xml-интерфейсов
private $xml_api = array("goods_info" => "http://shop.digiseller.ru/xml/shop_product_info.asp",
"responses" => "http://shop.digiseller.ru/xml/shop_reviews.asp",
"goods_group" => "http://shop.digiseller.ru/xml/shop_categories.asp",
"goods_list" => "http://shop.digiseller.ru/xml/shop_products.asp",
"search" => "http://shop.digiseller.ru/xml/shop_search.asp",
"check_code" => "http://shop.digiseller.ru/xml/check_unique_code.asp",
"agent_req_num" => "http://shop.digiseller.ru/xml/agent_get.asp",
"agent_check" => "http://shop.digiseller.ru/xml/agent_check.asp",
"products_form" => "http://shop.digiseller.ru/xml/products_forms.asp",
"last_sale" => "http://shop.digiseller.ru/xml/last_sale.asp",
"last_sales" => "http://shop.digiseller.ru/xml/shop_last_sales.asp",
"oplata_check" => "https://www.oplata.info/xml/check_unique_code.asp",
"seller_goods" => "https://api.digiseller.ru/api/seller-goods",
"oplata_check_rezerv" => "http://shop.digiseller.ru/xml/check_unique_code.asp");

// функция получения ответа от xml-интерфейса
private function request($act,$req){
// Инициализируем сеанс CURL
$ch = curl_init($act);
// В выводе CURL http-заголовки не нужны
curl_setopt($ch,CURLOPT_HEADER,0);
// Возвращать результат, а не выводить его в браузер
curl_setopt($ch,CURLOPT_RETURNTRANSFER,1);
// Метод http-запроса - POST
curl_setopt($ch,CURLOPT_POST,1);
// Что передаем?
curl_setopt($ch,CURLOPT_POSTFIELDS, $req);
// Выполняем запрос, ответ помещаем в переменную $result;
$result = @curl_exec($ch);
if(curl_errno($ch))  echo "<!-- Curl Error number = ".curl_errno($ch).", Error desc = ".curl_error($ch)." -->";
curl_close($ch);
return $result;}

function parse_xml($xml){
$result = simplexml_load_string($xml,"SimpleXMLElement",LIBXML_NOCDATA);
if(!$result){
echo "<p><span class=\"warning\">".$GLOBALS["mess"]["service_disable"]."</span></p>";}
else{
return $result;}}

private function clear($text,$tmp){
$text = preg_replace("/".$tmp."/","",$text);
return $text;}

// проверка уникального кода
function oplata_check($id_seller,$code,$sign){
$id_seller = $this -> clear($id_seller,"[^0-9]");
$request = "<digiseller.request>
<id_seller>".$id_seller."</id_seller>
<unique_code>".$code."</unique_code>
<sign>".$sign."</sign>
</digiseller.request>";	
$answer = $this -> request($this -> xml_api["oplata_check"],$request);
return $answer;
}






//НОРМАЛИЗАЦИЯ ЭКРАНИЗАЦИИ
function normalizeHTML($text){
 $text=str_replace("&amp;quot;","&quot;",$text);
 $text=str_replace("&amp;lt;","&lt;",$text);
 $text=str_replace("&amp;gt;","&gt;",$text);
 $text=str_replace("&amp;acute;","&acute;",$text);
 $text=str_replace("&amp;#","&#",$text);
 return $text;
}

// функция получения ответа от api-интерфейса
private function request_api($act,$req){
// Инициализируем сеанс CURL
$ch = curl_init($act);
// В выводе CURL http-заголовки не нужны
curl_setopt($ch,CURLOPT_HEADER,0);

curl_setopt( $ch, CURLOPT_HTTPHEADER, array('Content-Type:text/xml'));
// Возвращать результат, а не выводить его в браузер
curl_setopt($ch,CURLOPT_RETURNTRANSFER,1);
// Метод http-запроса - POST
curl_setopt($ch,CURLOPT_POST,1);
// Что передаем?
curl_setopt($ch,CURLOPT_POSTFIELDS, $req);
// Выполняем запрос, ответ помещаем в переменную $result;
$result = @curl_exec($ch);
if(curl_errno($ch))  echo "<!-- Curl Error number = ".curl_errno($ch).", Error desc = ".curl_error($ch)." -->";
curl_close($ch);
return $this->normalizeHTML($result);}



// Товары продавца
function seller_goods($id_seller){
$id_seller = $this -> clear($id_seller,"[^0-9]");
$request = "<digiseller.request><id_seller>".$id_seller."</id_seller><order_col>cntsell</order_col><order_dir>desc</order_dir><rows>2000</rows><page>1</page><currency>RUR</currency><lang>ru-RU</lang></digiseller.request>";
$answer = $this -> request_api($this -> xml_api["seller_goods"],$request);

return $answer;}






// получение информации о товаре
function goods_info($id_goods){
$id_goods = $this -> clear($id_goods,"[^0-9]");
$request = "<digiseller.request><product><id>".$id_goods."</id></product></digiseller.request>";
return $this -> request($this -> xml_api["goods_info"],$request);
return $answer;}

// получение отзывов о товаре
function goods_responses($id_seller,$id_goods,$type_response,$page,$rows){
$id_seller = $this -> clear($id_seller,"[^0-9]");
$id_goods = $this -> clear($id_goods,"[^0-9]");
$type_response = $this -> clear($type_response,"[^a-z]");
$page = $this -> clear($page,"[^0-9]");
$rows = $this -> clear($rows,"[^0-9]");
$request = "<digiseller.request><seller><id>".$id_seller."</id></seller><product><id>".$id_goods."</id></product><reviews><type>".$type_response."</type></reviews><pages><num>".$page."</num><rows>".$rows."</rows></pages></digiseller.request>";
$answer = $this -> request($this -> xml_api["responses"],$request);
return $answer;}

// получение групп товаров
function goods_group($id_seller){
$id_seller = $this -> clear($id_seller,"[^0-9]");
$request = "<digiseller.request><seller><id>".$id_seller."</id></seller></digiseller.request>";
$answer = $this -> request($this -> xml_api["goods_group"],$request);
return $answer;}

// получение товаров из списка
function goods_list($id_seller,$id_group,$page,$rows,$currency,$order){
$id_seller = $this -> clear($id_seller,"[^0-9]");
$id_group = $this -> clear($id_group,"[^0-9]");
$page = $this -> clear($page,"[^0-9]");
$rows = $this -> clear($rows,"[^0-9]");
$currency = $this -> clear($currency,"[^A-Z]");
$order = $this -> clear($order,"[^a-zA-Z]");
$request = "<digiseller.request><category><id>".$id_group."</id></category><seller><id>".$id_seller."</id></seller><pages><num>".$page."</num><rows>".$rows."</rows></pages><products><order>".$order."</order><currency>".$currency."</currency></products></digiseller.request>";
$answer = $this -> request($this -> xml_api["goods_list"],$request);
return $answer;}

// получение результатов поиска товаров
function search($id_seller,$search_str,$page,$rows,$currency){
$id_seller = $this -> clear($id_seller,"[^0-9]");
$page = $this -> clear($page,"[^0-9]");
$rows = $this -> clear($rows,"[^0-9]");
$currency = $this -> clear($currency,"[^A-Z]");
$request = "<digiseller.request><seller><id>".$id_seller."</id></seller><products><search>".$search_str."</search><currency>".$currency."</currency></products><pages><num>".$page."</num><rows>".$rows."</rows></pages></digiseller.request>";
$answer = $this -> request($this -> xml_api["search"],$request);
return $answer;}

// проверка уникального 16-значного кода DS
function check_code($id_seller,$unique_code,$ds_pass){
$id_seller = $this -> clear($id_seller,"[^0-9]");
$unique_code = $this -> clear($unique_code,"[^0-9A-Z]");
$sign = md5($id_seller.":".$unique_code.":".$ds_pass);
$request = "<digiseller.request><id_seller>".$id_seller."</id_seller><unique_code>".$unique_code."</unique_code><sign>".$sign."</sign></digiseller.request>";
$answer = $this -> request($this -> xml_api["check_code"],$request);
return $answer;}

// получение номера запроса и картинки для проверки ID агента
function agent_req_num($id_seller){
$id_seller = $this -> clear($id_seller,"[^0-9]");
$request = "<digiseller.request><id_seller>".$id_seller."</id_seller></digiseller.request>";
$answer = $this -> request($this -> xml_api["agent_req_num"],$request);
return $answer;}

// проверка ID агента по его email. В случае отсутствия email автоматическая регистрация агента
function agent_check($id_seller,$id_request,$turing_num,$email,$redirect_url){
$id_seller = $this -> clear($id_seller,"[^0-9]");
$id_request = $this -> clear($id_request,"[^0-9]");
$turing_num = $this -> clear($turing_num,"[^0-9]");
$request = "<digiseller.request><id_seller>".$id_seller."</id_seller><id_request>".$id_request."</id_request><turing_num>".$turing_num."</turing_num><email>".$email."</email><redirect_url>".$redirect_url."</redirect_url></digiseller.request>";
$answer = $this -> request($this -> xml_api["agent_check"],$request);
return $answer;}

// получение форм продуктов(Pin-коды, Электронные книги, Цифровые товары, Программное обеспечение)
function get_products_form(){
$answer = $this -> request($this -> xml_api["products_form"],"");
return $answer;}

// получение данных о последней продажи
function get_last_sale($id_seller){
$id_seller = $this -> clear($id_seller,"[^0-9]");
$request = "<digiseller.request><id_seller>".$id_seller."</id_seller></digiseller.request>";
$answer = $this -> request($this -> xml_api["last_sale"],$request);
return $answer;}
// получение данных о последних продажах
function get_last_sales($id_seller,$uid){
$id_seller = $this -> clear($id_seller,"[^0-9]");
$request = "<digiseller.request><seller><id>".$id_seller."</id><uid>8A8FC88ACDE946F98D9D1788454267D4</uid></seller><group>false</group><lang></lang></digiseller.request>";
$answer = $this -> request($this -> xml_api["last_sales"],$request);
return $answer;}}
?>