<?php

define ( 'DATALIFEENGINE', true );
define ( 'ROOT_DIR', substr( dirname(  __FILE__ ), 0, -12 ) );
define ( 'ENGINE_DIR', ROOT_DIR . '/engine' );
@include (ENGINE_DIR . '/data/config.php');
require_once ENGINE_DIR . '/classes/Digiseller.php';
require_once ENGINE_DIR . '/modules/functions.php';


require_once ENGINE_DIR . '/classes/mysql.php';
require_once ENGINE_DIR . '/data/dbconfig.php';
require_once ENGINE_DIR . '/modules/functions.php';
require_once ENGINE_DIR . '/classes/templates.class.php';

dle_session();

if (!defined('DATALIFEENGINE')) die("Go fuck yourself!");

$GLOBALS["obj"] = new core;
$GLOBALS["mess"] = $_mess;
$result = "";

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

$answer_resp = $GLOBALS["obj"] -> goods_responses($GLOBALS["seller_id"],$GLOBALS["id_goods"],$GLOBALS["type_responses"],$_REQUEST["page"],$GLOBALS["rows"]);
$answer_resp = $GLOBALS["obj"] -> parse_xml($answer_resp);
$sql = "SELECT * FROM " . USERPREFIX . "_post ";
if(isset($_POST['filter'])){
	$filter = json_decode($_POST['filter']);
	switch($filter->sort_type){
		case "name_a-z":{$sql .= "ORDER BY title";break;}
		case "name_z-a":{$sql .= "ORDER BY title DESC";break;}
		case "top_down":{$sql .= "ORDER BY date";break;}
		default:{$sql .= "ORDER BY date DESC";break;}
	}
	$db->query( $sql );
}else{
	$db->query( "SELECT * FROM " . USERPREFIX . "_post ORDER BY date DESC");
}
$row = $db->get_row();	
	
	while ( $row = $db->get_row() ) {
	
if( ! $row['category'] ) {
			$my_cat = "---";
			$my_cat_link = "---";
		} else {
			
			$my_cat = array ();
			$my_cat_link = array ();
			$cat_list = explode( ',', $row['category'] );

			if ($config['category_separator'] != ',') $config['category_separator'] = ' '.$config['category_separator'];
			 
			if( count( $cat_list ) == 1 OR ($view_template == "rss" AND $config['rss_format'] == 2)) {
				
				$my_cat[] = $cat_info[$cat_list[0]]['name'];
				
				$my_cat_link = get_categories( $cat_list[0], $config['category_separator']);
			
			} else {
				
				foreach ( $cat_list as $element ) {
					if( $element ) {
						$my_cat[] = $cat_info[$element]['name'];
						if( $config['allow_alt_url'] ) $my_cat_link[] = "<a href=\"" . $config['http_home_url'] . get_url( $element ) . "/\">{$cat_info[$element]['name']}</a>";
						else $my_cat_link[] = "<a href=\"$PHP_SELF?do=cat&category={$cat_info[$element]['alt_name']}\">{$cat_info[$element]['name']}</a>";
					}
				}

				$my_cat_link = implode( "{$config['category_separator']} ", $my_cat_link );
			}
			
			$my_cat = implode( "{$config['category_separator']} ", $my_cat );
		}

		$url_cat = $category_id;
	
		if (stripos ( $tpl->copy_template, "[category=" ) !== false) {
			$tpl->copy_template = preg_replace_callback ( "#\\[(category)=(.+?)\\](.*?)\\[/category\\]#is", "check_category", $tpl->copy_template );
		}
		
		if (stripos ( $tpl->copy_template, "[not-category=" ) !== false) {
			$tpl->copy_template = preg_replace_callback ( "#\\[(not-category)=(.+?)\\](.*?)\\[/not-category\\]#is", "check_category", $tpl->copy_template );
		}
	
		$category_id = $row['category'];
	
		if( strpos( $tpl->copy_template, "[catlist=" ) !== false ) {
			$tpl->copy_template = preg_replace_callback ( "#\\[(catlist)=(.+?)\\](.*?)\\[/catlist\\]#is", "check_category", $tpl->copy_template );
		}
								
		if( strpos( $tpl->copy_template, "[not-catlist=" ) !== false ) {
			$tpl->copy_template = preg_replace_callback ( "#\\[(not-catlist)=(.+?)\\](.*?)\\[/not-catlist\\]#is", "check_category", $tpl->copy_template );
		}
	
		$category_id = $url_cat;
		
		$row['category'] = intval( $row['category'] );
		
		if( $config['allow_alt_url'] ) {
			
			if( $config['seo_type'] == 1 OR $config['seo_type'] == 2  ) {
				
				if( $row['category'] and $config['seo_type'] == 2 ) {
					
					$full_link = $config['http_home_url'] . get_url( $row['category'] ) . "/" . $row['id'] . "-" . $row['alt_name'] . ".html";
				
				} else {
					
					$full_link = $config['http_home_url'] . $row['id'] . "-" . $row['alt_name'] . ".html";
				
				}
			
			} else {
				
				$full_link = $config['http_home_url'] . date( 'Y/m/d/', $row['date'] ) . $row['alt_name'] . ".html";
			}
		
		} else {
			
			$full_link = $config['http_home_url'] . "index.php?newsid=" . $row['id'];
		
		}
		$row['full-link'] = $full_link;
		
		
		$xfields = 	explode("||",$row['xfields']);	
		foreach($xfields as $k=>$fields){
			$values = explode("|",$fields);
			$row[$values[0]] = $values[1];
		}	
		
		$all_posts[$row['id']] = array ();
		
		foreach ( $row as $key => $value ) {
			$all_posts[$row['id']][$key] = stripslashes($value);
		}
	
	}
	$db->free();
	
	
		/*	$filter = json_decode($_POST['filter']);
	print_r($filter->active[0]);
	exit();
	*/
	

	
	switch($filter->sort_type){
		case "data_old":{
				for ($x = 0; $x < count($all_posts); $x++) {
				  for ($y = 0; $y < count($all_posts); $y++) {
					if ((int)$all_posts[$x]["year"] > (int)$all_posts[$y]["year"]) {
					  $hold = $all_posts[$x];
					  $all_posts[$x] = $all_posts[$y];
					  $all_posts[$y] = $hold;
					}
				  }
				}
				break;
			}
		case "data_new":{
				for ($x = 0; $x < count($all_posts); $x++) {
				  for ($y = 0; $y < count($all_posts); $y++) {
					if ((int)$all_posts[$x]["year"] < (int)$all_posts[$y]["year"]) {
					  $hold = $all_posts[$x];
					  $all_posts[$x] = $all_posts[$y];
					  $all_posts[$y] = $hold;
					}
				  }
				}
				break;
			}
		case "price_low":{
				for ($x = 0; $x < count($all_posts); $x++) {
				  for ($y = 0; $y < count($all_posts); $y++) {
					if ((int)$all_posts[$x]["price"] > (int)$all_posts[$y]["price"]) {
					  $hold = $all_posts[$x];
					  $all_posts[$x] = $all_posts[$y];
					  $all_posts[$y] = $hold;
					}
				  }
				}
				break;
			}
		case "price_high":{
				for ($x = 0; $x < count($all_posts); $x++) {
				  for ($y = 0; $y < count($all_posts); $y++) {
					if ((int)$all_posts[$x]["price"] > (int)$all_posts[$y]["price"]) {
					  $hold = $all_posts[$x];
					  $all_posts[$x] = $all_posts[$y];
					  $all_posts[$y] = $hold;
					}
				  }
				}
				break;
			}
		case "economy_high":{
				for ($x = 0; $x < count($all_posts); $x++) {
				  for ($y = 0; $y < count($all_posts); $y++) {
					if ((int)$all_posts[$x]["economy"] > (int)$all_posts[$y]["economy"]) {
					  $hold = $all_posts[$x];
					  $all_posts[$x] = $all_posts[$y];
					  $all_posts[$y] = $hold;
					}
				  }
				}
				break;
			}
		case "economy_low":{
				for ($x = 0; $x < count($all_posts); $x++) {
				  for ($y = 0; $y < count($all_posts); $y++) {
					if ((int)$all_posts[$x]["economy"] > (int)$all_posts[$y]["economy"]) {
					  $hold = $all_posts[$x];
					  $all_posts[$x] = $all_posts[$y];
					  $all_posts[$y] = $hold;
					}
				  }
				}
				break;
			}
		default:break;
	}
	$result = filter($filter,$all_posts);
	print_r($result);
?>