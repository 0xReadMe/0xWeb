<?php

define ( 'DATALIFEENGINE', true );
define ( 'ROOT_DIR', substr( dirname(  __FILE__ ), 0, -12 ) );
define ( 'ENGINE_DIR', ROOT_DIR . '/engine' );
@include (ENGINE_DIR . '/data/config.php');
require_once ENGINE_DIR . '/classes/Digiseller.php';
require_once ENGINE_DIR . '/modules/functions.php';
$GLOBALS["obj"] = new core;
$GLOBALS["mess"] = $_mess;


$seller_id = '425051';
$info_goods["resp_block_dt"] = "good";
$info_goods["resp_block_row"] = '30';
$info_goods["resp_block_pages"] = '5';

$GLOBALS["type_responses"] = $info_goods["resp_block_dt"];
$GLOBALS["seller_id"] = $seller_id;

// ID товара
if(isset($_REQUEST["id_goods"]) && !empty($_REQUEST["id_goods"])){
$GLOBALS["id_goods"] = $_REQUEST["id_goods"];}
else{$GLOBALS["id_goods"] = "";}


// количество строк и количество страниц
$GLOBALS["type_responses"] = $info_goods["resp_block_dt"];
$GLOBALS["rows"] = $info_goods["resp_block_row"];
$GLOBALS["count_page"] = $info_goods["resp_block_pages"];

$answer_resp = $GLOBALS["obj"] -> goods_responses($GLOBALS["seller_id"],$GLOBALS["id_goods"],$GLOBALS["type_responses"],$_REQUEST["page"],$GLOBALS["rows"]);
$answer_resp = $GLOBALS["obj"] -> parse_xml($answer_resp);
print_r($answer_resp);
?>