<?
ob_start();
session_start();

header('content-type:TEXT/XML; charset=UTF-8');
####################################
##
##	File create dinamic xml file for client site flash
##	
##	
####################################

require_once('/home/ilan123/domains/ilbiz.co.il/public_html/global_func/vars.php');

mysql_query("SET NAMES 'utf-8'");
 

$zone_area_data['table'] = ( !empty($_GET['table']) ) ? $_GET['table'] : $_POST['table'];
$zone_area_data['limit'] = ( !empty($_GET['limit']) ) ? $_GET['limit'] : $_POST['limit'];
$zone_area_data['cat'] = ( !empty($_GET['cat']) ) ? $_GET['cat'] : $_POST['cat'];
$zone_area_data['type'] = ( !empty($_GET['type']) ) ? $_GET['type'] : $_POST['type'];
$zone_area_data['id'] = ( !empty($_GET['id']) ) ? $_GET['id'] : $_POST['id'];
$zone_area_data['pageNum'] = ( !empty($_GET['pageNum']) ) ? $_GET['pageNum'] : $_POST['pageNum'];
$zone_area_data['BitemID'] = ( !empty($_GET['itemID']) ) ? $_GET['itemID'] : $_POST['itemID'];
$zone_area_data['unickSES'] = ( !empty($_GET['unickSES']) ) ? $_GET['unickSES'] : $_POST['unickSES'];


$unk = ( !empty($_GET['unk']) ) ? $_GET['unk'] : $_POST['unk'];

define( 'UNK' , $unk );


// LANG select
$sql = "select lang_id from users where unk = '".UNK."' and deleted = '0'";
$res_UserLang = mysql_db_query(DB,$sql);
$data_UserLang = mysql_fetch_array($res_UserLang);

$sql = "select * from users where unk = '".UNK."' and deleted = '0'";
$res_site_settings = mysql_db_query(DB,$sql);
$user_site_settings = mysql_fetch_array($res_site_settings);

$sql_lang = "select * from site_langs where id = '".$data_UserLang['lang_id']."'";
$res_lang = mysql_db_query(DB,$sql_lang);
$data_lang = mysql_fetch_array($res_lang);

if( !empty($data_lang['lang']) )
{
	define('LANG',$data_lang['lang']);
	$lang_page_name = $data_lang['lang'];
}
else
{
	define('LANG',"he");
	$lang_page_name = "he";
}

require_once('/home/ilan123/domains/ilbiz.co.il/public_html/lang/lang.'.$lang_page_name.'.php');
require_once("/home/ilan123/domains/ilbiz.co.il/public_html/global_func/global_functions.php");

$xml_file = run_query_create_xml($zone_area_data);




function run_query_create_xml($zone_area_data, $request_id="")
{
	$db_table = $zone_area_data['table'];
	$db_limit = $zone_area_data['limit'];
	$db_cat = $zone_area_data['cat'];
	$db_type = $zone_area_data['type'];
	$db_id = $zone_area_data['id'];
	$pageNum = $zone_area_data['pageNum'];
	$BitemID = $zone_area_data['BitemID'];
	$unickSES = $zone_area_data['unickSES'];
	
	
	$db_limit = ( empty($db_limit) ) ? "3" : $db_limit;
	
	$sql_domain = "select domain from users where unk = '".UNK."'";
	$res_domain = mysql_db_query(DB,$sql_domain);
	$data_domain = mysql_fetch_array($res_domain);
	
	$user_domain = $data_domain['domain'];
	
	define( 'SERVER_PATH' , "/home/ilan123/domains/".$user_domain."/public_html" );
	
	switch( $db_table )
	{	
		case "articels" :
			create_xml_articels($db_table, $user_domain, $db_limit);
		break;
		
		case "s_art" :
			create_xml_s_art($user_domain, $db_id);
		break;
		
		case "sites" :
			create_xml_users();
		break;
		
		case "gallery_pages" :
			create_xml_gallery_pages($db_table, $user_domain, $db_limit, $db_cat);
		break;
		
		case "gallery_cat" :
			create_xml_gallery_cat($db_table, $user_domain, $db_limit, $db_cat);
		break;
		
		case "gallery" :
			create_xml_galley($db_table, $user_domain, $db_limit, $db_cat, $pageNum);
		break;
		
		case "top_slice" :
			create_xml_top_slice($user_domain);
		break;
		
		case "menu" :
			create_xml_menu($user_domain);
		break;
		
		case "text" :
			create_xml_text($db_type);
		break;
		
		case "yad2" :										create_xml_yad2($user_domain);									break;
		case "sales" :									create_xml_sales($user_domain);									break;
		case "products" :								create_xml_products($user_domain, $db_cat);									break;
		case "products_cat" :								create_xml_products_cat($user_domain, $db_cat);									break;
		case "video" :									create_xml_video($user_domain, $db_cat);									break;
		
		
		case "castum_interpool_news" :									castum_interpool_news($user_domain, $db_cat);									break;
		
		
		# ECOM functions
		case "addToBasket" :										addToBasket( $BitemID , $unickSES );											break;
		case "removeFromBasket" :								removeFromBasket( $BitemID , $unickSES );									break;
		case "removeQuantity" :									removeQuantity( $BitemID , $unickSES );										break;
		case "getAllItemsInBasket" :						getAllItemsInBasket( $unickSES );												break;
		
		
		default :
  		  $xml_str .= "<error>table na</error>";
			
	}
	
	echo $xml_str;
}


function create_xml_articels($db_table, $user_domain, $db_limit)
{
	$xml_str;
	
	$sql = "select id,headline,summary,img from user_".$db_table." where unk = '".UNK."' and status = '0' and deleted = '0' order by id desc limit ".$db_limit;
	$res = mysql_db_query(DB,$sql);
	
	$xml_str .= "<articels>";
		while( $data = mysql_fetch_array($res) )
		{
				$xml_str .= "<articel_detail>";
				$xml_str .= "<art_id>".$data['id']."</art_id>";
				$xml_str .= "<art_headline>".optimize_text($data['headline'])."</art_headline>";
				$xml_str .= "<art_summary>".optimize_text($data['summary'])."</art_summary>";
				
				$abpath_temp = SERVER_PATH."/articels/".$data['img'];
				
				if( file_exists($abpath_temp) && !is_dir($abpath_temp) )
				{
					$xml_str .= "<art_img_src>http://".$user_domain."/articels/".$data['img']."</art_img_src>";
				}
			$xml_str .= "</articel_detail>";
		}
	$xml_str .= "</articels>";
	
	echo $xml_str;
}

function create_xml_s_art($user_domain, $db_id)
{
	global $word;
	$xml_str;
	
	$art_id = ( $db_id != "" ) ? "and id = '".$db_id."'" : "";
	
	$sql = "select * from user_articels where unk = '".UNK."' and status = '0' ".$art_id." and deleted = '0' order by id desc limit 1";
	$res = mysql_db_query(DB,$sql);
	$data = mysql_fetch_array($res);
	
	$abpath_temp = SERVER_PATH."/articels/".$data['img'];
	
	$xml_str .= "<articel>";
		$xml_str .= "<headline>".optimize_text($data['headline'])."</headline>";
		$xml_str .= "<summary>".optimize_text($data['summary'])."</summary>";
		$xml_str .= "<content><![CDATA[".optimize_text($data['content'],"1")."]]></content>";
		
		if( file_exists($abpath_temp) && !is_dir($abpath_temp) )
			$xml_str .= "<img>http://".$user_domain."/articels/".$data['img']."</img>";
		
		$xml_str .= "<insert_date>".optimize_text($word[LANG]['1_1_articels_first_adv'], "1").GlobalFunctions::show_dateTime_field($data['date_in'])."</insert_date>";
		
		if( $data['date_in'] != $data['date_update'] )
			$xml_str .= "<update_date>".optimize_text($word[LANG]['1_1_articels_last_update'], "1").GlobalFunctions::show_dateTime_field($data['date_update'])."</update_date>";
		
	$xml_str .= "</articel>";
	
	echo $xml_str;
}

function create_xml_users()
{
	$xml_str;
	
	$sql = "select unk,domain from users where status = '0' and deleted = '0' order by rand() limit 50";
	$res = mysql_db_query(DB,$sql);
	
	$xml_str .= "<users>";
		while( $data = mysql_fetch_array($res) )
		{
			$xml_str .= "<site>";
				$xml_str .= "<site_domain>".$data['domain']."</site_domain>";
				$xml_str .= "<site_unk>".$data['unk']."</site_unk>";
			$xml_str .= "</site>";
		}
	$xml_str .= "</users>";
	
	echo $xml_str;
}


function create_xml_gallery_pages($db_table, $user_domain, $db_limit, $db_cat)
{
	$xml_str;
	
	$cat = ( $db_cat != "0" && $db_cat != "" ) ? "AND id = '".$db_cat."'" : "" ;
	$sql = "select id from user_gallery_cat where unk = '".UNK."' and active = '0' and deleted = '0' ".$cat." order by name";
	$res = mysql_db_query(DB,$sql);
	
	$xml_str .= "<galleyPages>";
		while( $data = mysql_fetch_array($res) )
		{
			$sql_imgs = "select id,img,content from user_gallery_images where unk = '".UNK."' and cat = '".$data['id']."' and deleted = '0' order by place";
			$res_imgs = mysql_db_query(DB,$sql_imgs);
			$num_rows = mysql_num_rows($res_imgs);
			
			$pageNum = "0";
			for($i=0 ; $i < $num_rows ; $i++)
				if($i % $db_limit == 0)
					$pageNum = $pageNum + 1;
			
			$xml_str .= "<pages cat=\"".optimize_text($data['id'])."\" pageNum=\"".$pageNum."\" sumPics=\"".$num_rows."\">";
				
			$xml_str .= "</pages>";
		}
	$xml_str .= "</galleyPages>";
	
	echo $xml_str;
}

function create_xml_gallery_cat($db_table, $user_domain, $db_limit, $db_cat)
{
	$xml_str;
	
	$sql = "select id,name from user_gallery_cat where unk = '".UNK."' and active = '0' and deleted = '0' order by name";
	$res = mysql_db_query(DB,$sql);
	
	$xml_str .= "<gallery_cat>";
		while( $data = mysql_fetch_array($res) )
		{
			$xml_str .= "<gallery_cat_detail>";
				$xml_str .= "<gallery_cat_id>".optimize_text($data['id'])."</gallery_cat_id>";
				$xml_str .= "<gallery_cat_title>".optimize_text($data['name'])."</gallery_cat_title>";
				
				$sql_imgs = "select id from user_gallery_images where unk = '".UNK."' and cat = '".$data['id']."' and deleted = '0' order by place";
				$res_imgs = mysql_db_query(DB,$sql_imgs);
				$data_num = mysql_num_rows($res_imgs);
				
				$xml_str .= "<gallery_cat_pic_sum>".$data_num."</gallery_cat_pic_sum>";
			$xml_str .= "</gallery_cat_detail>";
		}
	$xml_str .= "</gallery_cat>";
	
	echo $xml_str;
}

function create_xml_galley($db_table, $user_domain, $db_limit, $db_cat, $pageNum)
{
	$xml_str;
	
	$cat = ( $db_cat != "0" && $db_cat != "" ) ? "AND id = '".$db_cat."'" : "" ;
	$pageNum = ( $pageNum != "0" && $pageNum != "" ) ? $pageNum : "0" ;
	$pageNum = ( $pageNum == "0" ) ? $pageNum : $pageNum-1;

	
	$pageNum = ($pageNum*$db_limit);
	
	
	$sql = "select id from user_gallery_cat where unk = '".UNK."' and active = '0' and deleted = '0' ".$cat." order by name";
	$res = mysql_db_query(DB,$sql);
	
	$xml_str .= "<cats>";
		while( $data = mysql_fetch_array($res) )
		{
			$xml_str .= "<gallery cat=\"".optimize_text($data['id'])."\">";
				$sql_imgs = "select id,img,content from user_gallery_images where unk = '".UNK."' and cat = '".$data['id']."' and deleted = '0' order by place limit ".$pageNum.",".$db_limit."";
				$res_imgs = mysql_db_query(DB,$sql_imgs);
				$xml_str .= "<sql>".$sql_imgs."</sql>";
				while( $data_imgs = mysql_fetch_array($res_imgs) )
				{
						$xml_str .= "<images id=\"".optimize_text($data_imgs['id'])."\">";
							$xml_str .= "<text>".optimize_text($data_imgs['content'])."</text>";
							
							$abpath_temp = SERVER_PATH."/gallery/".$data_imgs['img'];
							$abpath_tempL = SERVER_PATH."/gallery/L".$data_imgs['img'];
							$abpath_tempXL = SERVER_PATH."/gallery/EX".$data_imgs['img'];
							
							if( file_exists($abpath_temp) && !is_dir($abpath_temp) )
								$xml_str .= "<small>/gallery/".$data_imgs['img']."</small>";
							if( file_exists($abpath_tempL) && !is_dir($abpath_tempL) )
								$xml_str .= "<large>/gallery/L".$data_imgs['img']."</large>";
							if( file_exists($abpath_tempXL) && !is_dir($abpath_tempXL) )
								$xml_str .= "<extra_large>/gallery/EX".$data_imgs['img']."</extra_large>";	
						$xml_str .= "</images>";
				}
			$xml_str .= "</gallery>";
		}
	$xml_str .= "</cats>";
	
	echo $xml_str;
}


function create_xml_top_slice($user_domain)
{
	
	$xml_str;

	$sql = "select * from user_colors_set where unk = '".UNK."'";
	$res = mysql_db_query(DB,$sql);
	$data = mysql_fetch_array($res);
	
	$abpath_temp2 = SERVER_PATH."/tamplate/".stripslashes($data['top_slice']);
	
	$xml_str .= "<top_slice>";
		if( file_exists($abpath_temp2) && !is_dir($abpath_temp2) )
		{
			$temp_test = explode( "." , $data['top_slice'] );
			
			if( $temp_test[1] == "swf" )
			{
				$xml_str .= "<type>flash</type>";
				$xml_str .= "<width>775</width>";
				$xml_str .= "<height>".$data['top_slice_flash_height']."</height>";
				$xml_str .= "<bgcolor>".$data['top_slice_flash_color']."</bgcolor>";
				$xml_str .= "<src>http://".$user_domain."/tamplate/".optimize_text($data['top_slice'])."</src>";
			}
			else
			{
				$im_size = GetImageSize ($abpath_temp2); 
				$imageWidth = $im_size[0]; 
				$imageHeight = $im_size[1];
				
				$xml_str .= "<type>".$temp_test[1]."</type>";
				$xml_str .= "<width>".$imageWidth."</width>";
				$xml_str .= "<height>".$imageHeight."</height>";
				$xml_str .= "<src>http://".$user_domain."/tamplate/".optimize_text($data['top_slice'])."</src>";
			}
		}
		else
		{
			$xml_str .= "<error>top slice not exist</error>";
		}
		
	$xml_str .= "</top_slice>";

	echo $xml_str;
}



function create_xml_menu($user_domain)
{
	global $word;
	
	$xml_str;

	// get the name of the pages - empty name => not exits in the list
	
	$sql = "select * from user_words where unk = '".UNK."'";
	$res_words = mysql_db_query(DB,$sql);
	$data_words = mysql_fetch_array($res_words);
	
	$temp_word_hp = $word[LANG]['1_2_chapter_name_hp'];
	
	$temp_word_about = ( $data_words['id'] == "" ) ? $word[LANG]['1_2_chapter_name_about'] : stripslashes($data_words['word_about']);
	$temp_word_articels = ( $data_words['id'] == "" ) ? $word[LANG]['1_2_chapter_name_articels'] : stripslashes($data_words['word_articels']);
	$temp_word_products = ( $data_words['id'] == "" ) ? $word[LANG]['1_2_chapter_name_products'] : stripslashes($data_words['word_products']);
	$temp_word_gallery = ( $data_words['id'] == "" ) ? $word[LANG]['1_2_chapter_name_gallery'] : stripslashes($data_words['word_gallery']);
	$temp_word_yad2 = ( $data_words['id'] == "" ) ? $word[LANG]['1_2_chapter_name_yad2'] : stripslashes($data_words['word_yad2']);
	$temp_word_sales = ( $data_words['id'] == "" ) ? $word[LANG]['1_2_chapter_name_sales'] : stripslashes($data_words['word_sales']);
	$temp_word_video = ( $data_words['id'] == "" ) ? $word[LANG]['1_2_chapter_name_video'] : stripslashes($data_words['word_video']);
	$temp_word_wanted = ( $data_words['id'] == "" ) ? $word[LANG]['1_2_chapter_name_jobs'] : stripslashes($data_words['word_wanted']);
	$temp_word_contact = ( $data_words['id'] == "" ) ? $word[LANG]['1_2_chapter_name_contact'] : stripslashes($data_words['word_contact']);
	$temp_word_gb = ( $data_words['id'] == "" ) ? "" : stripslashes($data_words['word_gb']);
	
	
	if( $data_name['have_homepage'] == 1)
		$arr_main_text = array(	hp=>$temp_word_hp, text=>$temp_word_about);
	else
		$arr_main_text = array(	text=>$temp_word_about);
	
	$arr_main = array(
		articels=>$temp_word_articels,
		products=>$temp_word_products,
		gallery=>$temp_word_gallery,
		yad2=>$temp_word_yad2,
		sales=>$temp_word_sales,
		video=>$temp_word_video,
		jobs=>$temp_word_wanted,
		gb=>$temp_word_gb,
		contact=>$temp_word_contact,
	);


	$sql_links_list_content = "select name,type,hide_page from content_pages where type != 'text' and name != '' and type != 'contact' and type != 'gb' and deleted = '0' and unk = '".UNK."'";
	$res_links_list_content = mysql_db_query(DB,$sql_links_list_content);
	
	$xml_str .= "<menu>";
		foreach( $arr_main_text as $val => $key )
		{
			$tmp_hidde_name = "hidde_about";
			if( $data_words[$tmp_hidde_name] == "0" )
			{
				$xml_str .= "<link title=\"".optimize_text($key)."\" href=\"m=".$val."\"></link>";
			}
		}
			
		while( $data_links_list_content = mysql_fetch_array($res_links_list_content) )
		{
			if( $data_links_list_content['hide_page'] == "0" )
				$xml_str .= "<link title=\"".optimize_text($data_links_list_content['name'])."\" href=\"m=text&amp;t=".$data_links_list_content['type']."\"></link>";
		}
		
		foreach( $arr_main as $val => $key )
		{
			if( $key != "" )
			{
				$val_or_wanted = ( $val == "jobs" ) ? "wanted" : $val;
				$tmp_hidde_name = "hidde_".$val_or_wanted;
				if( $data_words[$tmp_hidde_name] == "0" )
				{
					$xml_str .= "<link title=\"".optimize_text($key)."\" href=\"m=".$val."\"></link>";
				}
			}
		}
		
	$xml_str .= "</menu>";

	echo $xml_str;
}


function create_xml_text($db_type)
{
	global $word;
	
	$xml_str;
	
	$db_type = ( $db_type == "" ) ? "text" : $db_type;
	
	$sql = "select name,content from content_pages where unk = '".UNK."' and type = '".$db_type."' and deleted = '0'";
	$res = mysql_db_query(DB,$sql);
	$data = mysql_fetch_array($res);
	
	$sql = "select id,word_about from user_words where unk = '".UNK."'";
	$res_words = mysql_db_query(DB,$sql);
	$data_words = mysql_fetch_array($res_words);
	
	$temp_word_about = ( $data_words['id'] == "" ) ? optimize_text($word[LANG]['1_2_chapter_name_about'], "1") : optimize_text($data_words['word_about'], "1");
	
	$temp_headline = ( $db_type == "text" ) ? $temp_word_about : optimize_text($data['name'], "1");
	
	$content = string_rplace_func($data['content']);
	
	$xml_str .= "<page>";
		$xml_str .= "<content>";
			$xml_str .= "<![CDATA[".optimize_text($content,"1")."]]>";
				//$xml_str .= optimize_text($content,"&") ;
		$xml_str .= "</content>";
		$xml_str .= "<title>";
			$xml_str .= $temp_headline;
		$xml_str .= "</title>";
	$xml_str .= "</page>";

	echo $xml_str;
}

function create_xml_yad2($user_domain)
{
	
	$sql = "select * from user_yad2 where unk = '".UNK."' and deleted = '0' and active = '0' order by id desc";
	$res = mysql_db_query(DB,$sql);
	
	product_genrator("yad2", $user_domain, $res);
}

function create_xml_sales($user_domain)
{
	
	$sql = "select * from user_sales where unk = '".UNK."' and end_date > '".GlobalFunctions::get_date()."' and deleted = '0' and status = '0' order by id desc";
	$res = mysql_db_query(DB,$sql);
	
	product_genrator("sales", $user_domain, $res);
}

function create_xml_products($user_domain, $db_cat="")
{
	$sql = "select * from user_products_cat where unk = '".UNK."' and deleted = '0' and status = '0' order by id limit 1";
	$res_cat = mysql_db_query(DB,$sql);
	$data_cat = mysql_fetch_array($res_cat);
	
	$temp_cat = ( $db_cat ) ? $db_cat : $data_cat['id'];
	
	$sql = "select * from user_products where unk = '".UNK."' and deleted = '0' and active = '0' and cat = '".$temp_cat."' order by id desc";
	$res = mysql_db_query(DB,$sql);
	
	product_genrator("products", $user_domain, $res, $temp_cat);
}


function create_xml_video($user_domain, $db_cat)
{
	
	$temp_cat = ( $db_cat ) ? " and cat='".$db_cat."'" : "";
	$sql = "select * from user_video where unk = '".UNK."' ".$temp_cat." and deleted = '0' and active = '0' order by id desc";
	$res = mysql_db_query(DB,$sql);
	
	product_genrator("video", $user_domain, $res);
}


function product_genrator($from_func, $user_domain, $res, $db_cat="")
{
	global $word, $user_site_settings;
	
	$xml_str .= "<items>";
	
		while( $data = mysql_fetch_array($res) )
		{
			$item_cat = ( !empty($db_cat) && !empty($data['cat']) ) ? " cat=\"".$data['cat']."\"" : "";
			$xml_str .= "<item id=\"".optimize_text($data['id'])."\"".$item_cat.">";
			
				$abpath_temp = SERVER_PATH."/".$from_func."/".$data['img'];
				if( file_exists($abpath_temp) && !is_dir($abpath_temp) )
					$xml_str .= "<img>http://".$user_domain."/".$from_func."/".$data['img']."</img>";
			
				$xml_str .= "<title>".optimize_text($data['name'])."</title>";
				$xml_str .= "<summary>".optimize_text($data['summary'])."</summary>";
				
				if( $data['price'] != "" )
				{
					$word_price = "1_1_".$from_func."_price";
					$xml_str .= "<price>".optimize_text($word[LANG][$word_price], "1")." ".optimize_text($data['price'])."</price>";
				}
				
				if( $data['sale_price'] != "" && $from_func == "sales" )
					$xml_str .= "<sale_price>".optimize_text($word[LANG]['1_1_sales_price_sale'], "1")." ".optimize_text($data['sale_price'])."</sale_price>";
				
				if( $from_func == "products" )
					if( !empty($data['url_name']) && !empty($data['url_link']) )
						$xml_str .= "<url_link>".optimize_text($word[LANG]['1_1_products_url_link'])." <![CDATA[<a href='".optimize_text($data['url_link'])."' class='maintext' target='_blank'><b><u>".optimize_text($data['url_name'])."</u></b></a>]]></url_link>";
				
				if( $from_func == "products" )
					if( $user_site_settings['have_ecom'] == "1" && $data['active_ecom'] == "1" )
						$xml_str .= "<add_basket>".optimize_text($word[LANG]['1_1_products_add_to_cart'])."</add_basket>";
				
				if( $from_func == "video" )
				{
					if( $data['video_flash'] )
						$xml_str .= "<video_code><![CDATA[".optimize_text($data['video_flash'],"1")."]]></video_code>";
					elseif( $data['video_url'] )
						$xml_str .= "<video_code><![CDATA[<embed src=\"".$data['video_url']."\" loop=\"0\" autostart=\"true\"></embad>]]></video_code>";
					
					$xml_str .= "<content>".optimize_text($data['content'])."</content>";
				}
				
			$xml_str .= "</item>";
		}
	$xml_str .= "</items>";
	
	echo $xml_str;
}


function create_xml_products_cat($user_domain, $db_cat)
{
	$xml_str;
	
	$sql = "select id,name from user_products_cat where unk = '".UNK."' and status = '0' and deleted = '0' order by name";
	$res = mysql_db_query(DB,$sql);
	
	$xml_str .= "<products_cat>";
		while( $data = mysql_fetch_array($res) )
		{
			$xml_str .= "<products_cat_detail cat=\"".optimize_text($data['id'])."\">";
				$xml_str .= "<products_cat_title>".optimize_text($data['name'])."</products_cat_title>";
				
				$sql_imgs = "select id from user_products where unk = '".UNK."' and cat = '".$data['id']."' and deleted = '0'";
				$res_imgs = mysql_db_query(DB,$sql_imgs);
				$data_num = mysql_num_rows($res_imgs);
				
				$xml_str .= "<products_cat_sum_pro>".$data_num."</products_cat_sum_pro>";
			$xml_str .= "</products_cat_detail>";
		}
	$xml_str .= "</products_cat>";
	
	echo $xml_str;
}



function castum_interpool_news($user_domain, $db_cat)
{
	$xml_str;
	
	$sql = "select * from user_news where unk = '".UNK."' and deleted = '0' order by id desc";
	$res = mysql_db_query(DB,$sql);
	
	$xml_str .= "<news_list>";
		while( $data = mysql_fetch_array($res) )
		{
			$xml_str .= "<news_detail id=\"".optimize_text($data['id'])."\">";
				$xml_str .= "<news_title>".optimize_text($data['headline'])."</news_title>";
				$xml_str .= "<news_content>".optimize_text($data['content'])."</news_content>";
				$xml_str .= "<news_link>".optimize_text($data['link'])."</news_link>";
				$xml_str .= "<news_url_img>".optimize_text($data['url_img'])."</news_url_img>";
			$xml_str .= "</news_detail>";
		}
	$xml_str .= "</news_list>";
	
	echo $xml_str;
}


function optimize_text($string, $no_str="" )
{
	$str = stripslashes($string);
	
	if( $no_str == "" )
	{
		$str = str_replace( "<" , "&lt;" , $str);
		$str = str_replace( ">" , "&gt;" , $str);
		$str = str_replace( "&" , "&amp;" , $str);
		$str = str_replace( "'" , "&apos;" , $str);
		$str = str_replace( "\"" , "&quot;" , $str);
	}
	elseif( $no_str == "&" )
	{
		$str = str_replace( "&" , "&amp;" , $str);
	}
	
	return iconv("windows-1255", "UTF-8", $str);
}

function string_rplace_func($content)
{
	$content = str_replace( "<table" , "<table class=\"maintext\"" , $content );
	$content = str_replace( "<tbody" , "<tbody class=\"maintext\"" , $content );
	
	$content = str_replace( "http://www.ilbiz.co.il/ClientSite/upload_pics/" , "/ClientSite/upload_pics/" , $content );
	$content = str_replace( "http://ilbiz.co.il/ClientSite/upload_pics/" , "/ClientSite/upload_pics/" , $content );
	$content = str_replace( "/ClientSite/upload_pics/" , "http://ilbiz.co.il/ClientSite/upload_pics/" , $content );
	
	$content = str_replace( "http://ilbiz.co.il/ClientSite/administration/fckeditor/editor/images" , "/ClientSite/administration/fckeditor/editor/images" , $content );
	$content = str_replace( "http://www.ilbiz.co.il/ClientSite/administration/fckeditor/editor/images" , "/ClientSite/administration/fckeditor/editor/images" , $content );
	$content = str_replace( "/ClientSite/administration/fckeditor/editor/images" , "http://ilbiz.co.il/ClientSite/administration/fckeditor/editor/images" , $content );
	
	return $content;
}


// ECOM FUNCTIONS

function addToBasket( $BitemID , $unickSES)
{
	$sql = "insert into user_ecom_items (product_id,unk,client_unickSes) values ( '".$BitemID."' , '".UNK."', '".$unickSES."' )";
	$res = mysql_db_query(DB,$sql);
	
	if( $res )
		echo "<mass>OK</mass>";
	else
		echo "<mass>ERROR</mass>";
}

function removeFromBasket( $BitemID , $unickSES )
{
	$sql = "delete FROM user_ecom_items WHERE product_id = '".$BitemID."' and client_unickSes = '".$unickSES."' and unk = '".UNK."'";
	$res = mysql_db_query(DB,$sql);
	
	if( $res )
		echo "<mass>OK</mass>";
	else
		echo "<mass>ERROR</mass>";
}

function removeQuantity( $BitemID , $unickSES )
{
	$sql = "delete FROM user_ecom_items WHERE product_id = '".$BitemID."' and client_unickSes = '".$unickSES."' and unk = '".UNK."' limit 1";
	$res = mysql_db_query(DB,$sql);
	
	if( $res )
		echo "<done>OK</done>";
	else
		echo "<done>ERROR</done>";
}

function getAllItemsInBasket($unickSES)
{
	global $word;
	
	$xml_str;
	
	$sql = "select product_id from user_ecom_items where unk = '".UNK."' and status=0 AND client_unickSes = '".$unickSES."' GROUP BY product_id";
	$res = mysql_db_query(DB,$sql);
	$num_rows = mysql_num_rows($res);
	
		$xml_str .= "<basket>";
			$xml_str .= "<basket_words>";
				$xml_str .= "<basket_words_qry>".optimize_text($word[LANG]['1_3_ecom_table_qry'])."</basket_words_qry>";
				$xml_str .= "<basket_words_product>".optimize_text($word[LANG]['1_3_ecom_table_product'])."</basket_words_product>";
				$xml_str .= "<basket_words_price>".optimize_text($word[LANG]['1_3_ecom_table_price'])."</basket_words_price>";
			$xml_str .= "</basket_words>";
			
			
		
		
				$total_price_to_pay = 0;
				while( $data = mysql_fetch_array($res) )
				{
					$sql = "select name,price from user_products where id = '".$data['product_id']."'";
					$res2 = mysql_db_query(DB,$sql);
					$data2 = mysql_fetch_array($res2);
					
					$sql = "select id from user_ecom_items where unk = '".UNK."' and status=0 AND client_unickSes = '".$unickSES."' and product_id = '".$data['product_id']."'";
					$res3 = mysql_db_query(DB,$sql);
					$qry_nm = mysql_num_rows($res3);
					
					$xml_str .= "<basket_item id=\"".$data['product_id']."\">";
						$xml_str .= "<basket_item_qry>".$qry_nm."</basket_item_qry>";
						$xml_str .= "<basket_item_title>".optimize_text($data2['name'])."</basket_item_title>";
						$xml_str .= "<basket_item_price>".optimize_text($data2['price'])."</basket_item_price>";
					$xml_str .= "</basket_item>";
					
					$total_price_to_pay = $total_price_to_pay + ( $data2['price'] * $qry_nm );
				}
						
			$xml_str .= "<basket_total_sum>".optimize_text($word[LANG]['1_3_ecom_table_total'])." ".$total_price_to_pay."</basket_total_sum>";
		$xml_str .= "</basket>";
	echo $xml_str;
}

?>
