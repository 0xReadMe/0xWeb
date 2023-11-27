<?php

define ( 'DATALIFEENGINE', true );
define ( 'ROOT_DIR', substr( dirname(  __FILE__ ), 0, -12 ) );
define ( 'ENGINE_DIR', ROOT_DIR . '/engine' );
@include (ENGINE_DIR . '/data/config.php');
require_once ENGINE_DIR . '/classes/respond.php';
require_once ENGINE_DIR . '/modules/functions.php';
$GLOBALS["obj"] = new core;
$GLOBALS["mess"] = $_mess;


$seller_id = '669049';
$info_goods["resp_block_dt"] = "good";
$info_goods["resp_block_row"] = '13';
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

?>
			<!-- Список товаров -->
			<div class="digiseller-reviewList">
				
<?php
$page = $_REQUEST["page"];

$result = "";

$answer_resp = $GLOBALS["obj"] -> goods_responses($GLOBALS["seller_id"],$GLOBALS["id_goods"],$GLOBALS["type_responses"],$_REQUEST["page"],$GLOBALS["rows"]);
$answer_resp = $GLOBALS["obj"] -> parse_xml($answer_resp);
	if($answer_resp -> retval != 0){
	$result .= "<p>".$answer_resp -> retdesc."</p>\n";}
	else{
		$url = "";
			if(!empty($answer_resp -> product -> id)){
			$url .= "&amp;id_goods=".$answer_resp -> product -> id;}
		if((int)($answer_resp -> pages["cnt"]) == 0){
		$result .= "<p>".$GLOBALS["mess"]["resp_not_found"]."</p>\n";}
		elseif((int)($answer_resp -> pages -> num) > (int)($answer_resp -> pages["cnt"])){
		$result .= "<p>".$GLOBALS["mess"]["page_not_found"]."</p>\n";}
		else{
			
			foreach($answer_resp -> reviews -> review as $review){
				switch($review -> type){
				case "good":
				$html_class = "good";
				$type_sym = "+";
				break;
				
				case "bad":
				$html_class = "bad";
				$type_sym = "-";
				break;}
			$result .= "<div class=\"response-loop\">
							<div class=\"response-cont\">
								<div class=\"response-det\">
									<div class=\"rcol\">".$review -> date."</div>
								</div>
								<span class=\"digiseller-review$html_class\">$type_sym</span>
								<span style=\"display:inline-block\">".nl2br($review -> info)."</span> 
							</div>\n";
				
				if(!empty($review -> comment)){
				$comment = $review -> comment;
				$comment = nl2br($comment);
					$result .= "<div class=\"lcol\">
						<div class=\"response-arrow\"></div>
						<span class=\"digiseller-reviewcommentadmintxt\">
							<span class=\"green\">Комментарий администратора: </span>
							".$comment."
						</span>
						</div>\n";}						

			$result .= "</div>
					<div class=\"digiseller-both\"></div>\n";}
			// вывод номерации страниц
			if((int)($answer_resp -> pages["cnt"]) > 1){
			$result .= "<div class=\"digiseller-paging\">\n";
			$cp = (int)($answer_resp -> pages -> num);
			$ap = (int)($answer_resp -> pages["cnt"]);
			$result .= show_num_page($cp,$ap,$GLOBALS["count_page"],"javascript:responses",$GLOBALS["id_goods"]);
			$result .= "</div>\n";}
					
			}}
echo $result;

?>
				</div>
			<!-- end.Список товаров -->				