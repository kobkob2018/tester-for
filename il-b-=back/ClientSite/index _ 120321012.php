<?php
/* 
* Copyright © 2006 ILbiz. All Rights Reserved
* email:	webmaster@ilbiz.co.il
*
* 
* the index of the client site
*/

//http://il.php.net/manual/en/ref.errorfunc.php#errorfunc.constants.errorlevels.e-warning
ob_start("ob_gzhandler");

error_reporting( 0 );
if(!session_id()){session_start();}


if( $_SERVER[HTTP_HOST] == "69site.ilbiz.co.il" )
{
	header("HTTP/1.1 301 Moved Permanently");
	header("Location:http://www.il-biz.co.il/");
		exit;
}

if( $_SERVER[HTTP_HOST] == "www.69site.ilbiz.co.il" )
{
	if( $_GET['t'] == "19049" ) 
	{
		header("HTTP/1.1 301 Moved Permanently");
		header("Location:http://www.il-biz.co.il/index.php?m=text&t=3272");
			exit;
	}
	else
	{
		header("HTTP/1.1 301 Moved Permanently");
		header("Location:http://www.il-biz.co.il/");
			exit;
	}
}


require('/home/ilan123/domains/ilbiz.co.il/public_html/global_func/vars.php');

if( isset($_POST['productIdToRemove']) && $_POST['spEvAR'] == "Linnrkd442" )
{
	$sql = "delete FROM chipHaariUsersImgs WHERE prId = '".ifint($_POST['productIdToRemove'])."' and ecomSesId = '".$_SESSION['ecom']['unickSES']."' limit 1";
	$res = mysql_db_query(DB,$sql);
	
	$sql = "delete FROM user_ecom_items WHERE product_id = '".ifint($_POST['productIdToRemove'])."' and client_unickSes = '".$_SESSION['ecom']['unickSES']."' limit 1";
	$res = mysql_db_query(DB,$sql);
	
	if( $res )
		echo "OK";
	exit;
}


if( $_GET['m'] == "ajax.product_images" )
{
	require("/home/ilan123/domains/ilbiz.co.il/public_html/ClientSite/functions_10.php");
	index_ajax_product_images();
	exit;
}


$um = ( $_GET['m'] == "" ) ? $_POST['m'] : $_GET['m'];

$abpath_unk_def = $_SERVER[DOCUMENT_ROOT]."/unk_def.php";
if( file_exists($abpath_unk_def) && !is_dir($abpath_unk_def) )
{
	require($abpath_unk_def);
	define('UNK',DEFINE_UNK);
	$from_fomain = 1;
}
else
{
	$uu = ( $_GET['unk'] == "" ) ? $_POST['unk'] : $_GET['unk'];
	
	define('UNK',$uu);
	
	$sql = "select domain from users where unk = '".UNK."' and deleted = '0'";
	$res_domain = mysql_db_query(DB,$sql);
	$data_domain = mysql_fetch_array($res_domain);
	
	if( $data_domain['domain'] != "" )
	{
		$abpath_unk_def2 = "/home/ilan123/domains/".$data_domain['domain']."/public_html/unk_def.php";
		if( file_exists($abpath_unk_def2) && !is_dir($abpath_unk_def2) )
		{
				header("location:http://".$data_domain['domain']."/index.php?".$_SERVER[QUERY_STRING]);
				exit;
		}
	}
}


if( UNK == "" )
	die("");


// check net mailing block pages
$sql = "SELECT goto_page , id , mailing_id FROM net_mailing_msg_mails WHERE unk = '".UNK."' AND deleted=0";
$resNetMailingBlock = mysql_db_query(DB,$sql);


$net_mailing__string = "";
$net_mailing__canSeeThePage = false;

while( $dataBlockMailing = mysql_fetch_array($resNetMailingBlock) ) 
{
	if( $dataBlockMailing['goto_page'] != '' )
	{
		$new_link_httpHost = str_replace( "www." , "" , $_SERVER['HTTP_HOST'] );
		
		$new_link = str_replace( "http://" , "" , $dataBlockMailing['goto_page']);
		$new_link = str_replace( "www." , "" , $new_link );
		
		$split_uri = explode("/index.php?" , $new_link );
		
		$urlHost = $split_uri[0];
		$urlParamters = $split_uri[1];
		
		
		
		if( $new_link_httpHost == $urlHost && eregi( $urlParamters , $_SERVER['QUERY_STRING'] ) )
		{
			$net_mailing__google_block = "1";
			
			$sql = "SELECT id FROM net_users WHERE unick_ses = '".$_GET['uses']."' ";
			$resUses = mysql_db_query(DB,$sql);
			$dataUses = mysql_fetch_array($resUses);
			
			if( $dataUses['id'] != "" )
			{
				if( md5($dataBlockMailing['id']) == $_GET['it'] )
				{
					$sql = "UPDATE net_mailing_users_received_msg SET view_url = 1 WHERE user_id = '".$dataUses['id']."' AND mail_id = '".$dataBlockMailing['id']."' AND mailing_id = '".$dataBlockMailing['mailing_id']."' LIMIT 1";
					$resViewUrl = mysql_db_query(DB,$sql);
					
					$net_mailing__canSeeThePage = true;
				}
				else
					$net_mailing__string = "שימו לב, טרם קיבלתם הרשאה לצפות בדף זה";
			}
			else
				$net_mailing__set_user_loginNet = "1";
		}
		
	}
}


// E-COMERS ajax only 
if( isset($_POST['spEvAR']) )
{
	if( $_POST['spEvAR'] == "Linnrkd442" )
	{
		header('Content-Type: text/html; charset=windows-1255');  
		if(isset($_POST['productId']))
		{
			$sql = "insert into user_ecom_items (product_id,unk,client_unickSes) values ( '".ifint($_POST['productId'])."' , '".UNK."', '".$_SESSION['ecom']['unickSES']."' )";
			$res = mysql_db_query(DB,$sql);
			
			$sql = "select id,price,price_10service,name from user_products where unk = '".UNK."' and deleted = '0' and active = '0' and id = '".ifint($_POST['productId'])."' limit 1";
			$res = mysql_db_query(DB,$sql);
			$data = mysql_fetch_array($res);
			
			if( UNK == "285240640927706447" )
			{
				
				if( $data['price_10service'] > 0 )
					$price = $data['price_10service'];
				else
					$price = $data['price'];
			}
			else
				$price = $data['price'];
			
			echo $data['id']."|||".htmlspecialchars(stripslashes($data['name']))."|||".htmlspecialchars(stripslashes($price));
		}
		
		exit;
	}
}





if( $from_fomain == 1 )
{
	$sql = "select domain from users where unk = '".UNK."' and deleted = '0'";
	$res_domain = mysql_db_query(DB,$sql);
	$data_domain = mysql_fetch_array($res_domain);
	
	define('HTTP_PATH',"http://".$data_domain['domain']);
	define('SERVER_PATH',"/home/ilan123/domains/".$data_domain['domain']."/public_html");
	
	$http_path = "http://".$data_domain['domain'];
	$server_path = "/home/ilan123/domains/".$data_domain['domain']."/public_html";
}
else
{
	define('HTTP_PATH',"http://www.ilbiz.co.il/ClientSite");
	define('SERVER_PATH',"/home/ilan123/domains/ilbiz.co.il/public_html/ClientSite");
	
	$http_path = "http://www.ilbiz.co.il/ClientSite";
	$server_path = "/home/ilan123/domains/ilbiz.co.il/public_html/ClientSite";
}


// LANG select
$sql = "select lang_id from users where unk = '".UNK."' and deleted = '0'";
$res_UserLang = mysql_db_query(DB,$sql);
$data_UserLang = mysql_fetch_array($res_UserLang);

$sql_lang = "select * from site_langs where id = '".ifint($data_UserLang['lang_id'])."'";
$res_lang = mysql_db_query(DB,$sql_lang);
$data_lang = mysql_fetch_array($res_lang);



if( !empty($data_lang['lang']) )
{
	define('LANG',$data_lang['lang']);
	$lang_page_name = $data_lang['lang'];
	
	// LANG settings
	//$site_charset = $data_lang['charset'];
	
	$site_charset = "windows-1255";
	$settings['dir'] = $data_lang['dir'];
	$settings['re_dir'] = $data_lang['re_dir'];
	$settings['align'] = $data_lang['align'];
	$settings['re_align'] = $data_lang['re_align'];
}
else
{
	define('LANG',"he");
	$lang_page_name = "he";
	
	// LANG settings
	//$site_charset = $data_lang['charset'];
	$site_charset = "windows-1255";
	$settings['dir'] = "rtl";
	$settings['re_dir'] = "ltr";
	$settings['align'] = "right";
	$settings['re_align'] = "left";
}

require('/home/ilan123/domains/ilbiz.co.il/public_html/lang/lang.'.$lang_page_name.'.php');

// class
require("/home/ilan123/domains/ilbiz.co.il/public_html/global_func/DB.php");
require("/home/ilan123/domains/ilbiz.co.il/public_html/global_func/global_functions.php");
require("/home/ilan123/domains/ilbiz.co.il/public_html/global_func/forms_creator.php");
require("/home/ilan123/domains/ilbiz.co.il/public_html/global_func/images_resize.php");
require("/home/ilan123/domains/ilbiz.co.il/public_html/global_func/class.phpmailer.php");

require("/home/ilan123/domains/ilbiz.co.il/public_html/global_func/classes/class.ilbiz_net.php");


require('functions.php');
require('strac_func.php');
require("/home/ilan123/domains/ilbiz.co.il/public_html/ClientSite/functions_08.php");
require("/home/ilan123/domains/ilbiz.co.il/public_html/ClientSite/functions_09.php");
require("/home/ilan123/domains/ilbiz.co.il/public_html/ClientSite/functions_10.php");
require("/home/ilan123/domains/ilbiz.co.il/public_html/ClientSite/client_castum_functions.php");
require("/home/ilan123/domains/ilbiz.co.il/public_html/ClientSite/client_castum_functions2.php");
require("/home/ilan123/domains/ilbiz.co.il/public_html/ClientSite/castum_functions.php");
require("/home/ilan123/domains/ilbiz.co.il/public_html/ClientSite/functions_12.php");

if( UNK == "285240640927706447" )
{
	require("/home/ilan123/domains/ilbiz.co.il/public_html/ClientSite/servise10_functions.php");
}


//if( UNK == "904337153122360469" )
//	check_if_is_site_69_and_do_301();

if( UNK == "142866654037057665" )
	check_if_is_site_asara_and_do_301();

if( UNK == "140691469010592401" )
	check_if_is_site_old_aluminium_do_301();

check_if_is_site_by_unk_need_do_301();


if( $_GET['m'] == "text" )
{
	$sql = "SELECT redierct_301 FROM content_pages WHERE unk = '".UNK."' AND type = '".$_GET['t']."' ";
	$resR301 = mysql_db_query(DB,$sql);
	$dataR301 = mysql_fetch_array($resR301);
	
	if( $dataR301['redierct_301'] != "" )
	{
		header( "HTTP/1.1 301 Moved Permanently" );
		header( "location: ".stripslashes($dataR301['redierct_301'])."" ); 
	}
}

if( UNK == "759923718705913766" )
{
	$qry = "SELECT id FROM content_pages WHERE deleted=0 AND lib=".ifint($_GET['lib'])." AND unk = '".UNK."' ORDER BY id LIMIT 1";
	$contentSubjectList_res = mysql_db_query( DB , $qry );
	$contentSubjectList_nums = mysql_fetch_array($contentSubjectList_res);
	
	$sql = "SELECT redierct_301 FROM content_pages WHERE unk = '".UNK."' AND type = '".$contentSubjectList_nums['id']."' ";
	$resR301 = mysql_db_query(DB,$sql);
	$dataR301 = mysql_fetch_array($resR301);
	
	if( $dataR301['redierct_301'] != "" )
	{
		header( "HTTP/1.1 301 Moved Permanently" );
		header( "location: ".stripslashes($dataR301['redierct_301'])."" ); 
	}
}


// for settigns about the colors
$sql = "select * from user_site_settings where unk = '".UNK."' and deleted = '0' and status = '0'";
$res_settings = mysql_db_query(DB,$sql);
$data_settings = mysql_fetch_array($res_settings);


$sql = "select * from user_extra_settings where unk = '".UNK."'";
$res_extra_settings = mysql_db_query(DB,$sql);
$data_extra_settings = mysql_fetch_array($res_extra_settings);


	if( $data_extra_settings['estimateSite'] == "1" )
	{
		if( !eregi( "www." , $_SERVER['HTTP_HOST'] ) )
		{
			$temp_xp = explode( "." , $_SERVER['HTTP_HOST'] );
			if( count($temp_xp) < 3  )
			{
				header("HTTP/1.1 301 Moved Permanently");
				if( $_SERVER['QUERY_STRING'] != "" )	$query_sting = $_SERVER['SCRIPT_NAME']."?".$_SERVER['QUERY_STRING'];
				header("Location: http://www.".$_SERVER['HTTP_HOST'].$query_sting);
					exit;
			}
		}
		
		if( $_SERVER['QUERY_STRING'] == "m=text&t=text" )
		{
			header("HTTP/1.1 301 Moved Permanently");
			header("Location: http://".$_SERVER['HTTP_HOST']);
				exit;
		}
	}


// for gernral data about the user
$sql = "select * from users where unk = '".UNK."' and deleted = '0' and status = '0'";
$res_name = mysql_db_query(DB,$sql);
$data_name = mysql_fetch_array($res_name);

if( empty($data_name['id']) )
	die("");

$with_out_RightMenu = 0;

if( $data_extra_settings['haveLandingPage'] == 1 && $um == "" )
{
	//header("location:landing.php");
	require_once('landing.php');
	die;
}
elseif( $data_extra_settings['indexSite'] == "1" AND UNK != "263512086634836547" )
{
	$m = ( $um == "" ) ? "Kghp" : $um;
}
elseif( $data_name['have_homepage'] == 1)	// if user have homepage - then go to homepage, else - go to about page
{
	$m = ( $um == "" ) ? "hp" : $um;
	
	if( $data_name['hp_type'] == "1" && $m == "hp" )
		$with_out_RightMenu = 1;
		
}
else
{
	$m = ( $um == "" ) ? "text" : $um;
	$_GET['t'] = ( $_GET['t'] == "" && $_GET['lib'] == "" ) ? "text" : $_GET['t'];
}

if( UNK == "375411241406803999" )
	$m = ( $um == "" ) ? "castum_frame" : $um;


// all color on the page
$sql = "select * from user_colors_set where unk = '".UNK."'";
$res_colors = mysql_db_query(DB,$sql);
$data_colors = mysql_fetch_array($res_colors);


if( $_GET['aJx'] == "1" && $_GET['aM'] != "" && $_GET['m'] == "" )
{
	header('Content-Type: text/html; charset=windows-1255');  
	
	switch($_GET['aM'])
	{
		case "calendar" :
				user_calendar($_GET['mons'], "1" );
		break;
	}
	exit;
}


$table_border = ( $data_colors['border_color_active'] == 0 && $data_extra_settings['estimateSite'] != "1" ) ? "class=\"site_border\"" : "";


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
	
	
	$addMoreTitle = selectBrwoserTitle($data_words, $um);
	$site_title = ( $data_settings['site_title'] != "" ) ? ", ".stripslashes($data_settings['site_title']) : "";
	$addMoreTitle = ( !empty($addMoreTitle) ) ? $addMoreTitle.$site_title : substr($site_title, 2);
	
	

if( $data_name['have_homepage'] == 1)
	$arr_main_text = array(	"hp" => $temp_word_hp, "text" => $temp_word_about);
else
	$arr_main_text = array(	"text" => $temp_word_about);

$arr_main = array(
	"arLi" => $temp_word_articels,
	"products" => $temp_word_products,
	"gallery" => $temp_word_gallery,
	"yad2" => $temp_word_yad2,
	"sales" => $temp_word_sales,
	"video" => $temp_word_video,
	"jobs" => $temp_word_wanted,
	"gb" => $temp_word_gb,
	"contact" => $temp_word_contact,
);


$arr_headlines = array(
	"text" => $temp_word_about,
	"arLi" => $temp_word_articels,
	"products" => $temp_word_products,
	"pr" => $temp_word_products,
	"s_products" => $temp_word_products,
	"s.pr"=> $temp_word_products,
	"gallery" => $temp_word_gallery,
	"ga" => $temp_word_gallery,
	"yad2" => $temp_word_yad2,
	"ya" => $temp_word_yad2,
	"s_yad2" => $temp_word_yad2,
	"s.ya"=> $temp_word_yad2,
	"sales" => $temp_word_sales,
	"sa" => $temp_word_sales,
	"s_sales" => $temp_word_sales,
	"s.sa"=> $temp_word_sales,
	"video" => $temp_word_video,
	"s_video" => $temp_word_video,
	"vi" => $temp_word_video,
	"s.vi"=> $temp_word_video,
	"jobs" => $temp_word_wanted,
	"jo" => $temp_word_wanted,
	"gb" => $temp_word_gb,
	"contact" => $temp_word_contact,
	"co" => $temp_word_contact,
	"get_thanks" => $word[LANG]['1_2_get_thanx_headline'],
);


	$abpath_temp = SERVER_PATH."/tamplate/".stripslashes($data_settings['logo']);
	if( file_exists($abpath_temp) && !is_dir($abpath_temp) )	{
		$im_size = GetImageSize ($abpath_temp); 
		$imageWidth = $im_size[0]; 
		$imageHeight = $im_size[1];
		
		$new_esek_name = str_replace('"' , '' , stripslashes($data_name['name']));
		
		$img_logo = "<img src=\"".HTTP_PATH."/tamplate/".stripslashes($data_settings['logo'])."\" width=\"".$imageWidth."\" height=\"".$imageHeight."\" border=\"0\" alt=\"".$new_esek_name."\" />";
	}
	
	
	$abpath_temp2 = SERVER_PATH."/tamplate/".stripslashes($data_colors['top_slice']);
	
	if( file_exists($abpath_temp2) && !is_dir($abpath_temp2) )	{
		$temp_test = explode( "." , $data_colors['top_slice'] );
		
		if( $temp_test[1] == "swf" )
		{
			$im_size = GetImageSize ($abpath_temp2); 
			$imageWidth = $im_size[0]; 
			$imageHeight = $im_size[1];
			
			$swf_top_slice = "
				<div id=\"LStop_slice\"></div>
				
				<script type=\"text/javascript\">
					swfPlayer(\"/tamplate/".stripslashes($data_colors['top_slice'])."\",\"top_slice\",\"".$imageWidth."\",\"".$imageHeight."\",\"#".stripslashes($data_colors['top_slice_flash_color'])."\",\"LStop_slice\");
				</script>";
		}
		else 
		{
			$im_size = GetImageSize ($abpath_temp2); 
			$imageWidth = $im_size[0]; 
			$imageHeight = $im_size[1];
			
			$img_top_slice = "background=\"".HTTP_PATH."/tamplate/".stripslashes($data_colors['top_slice'])."\" width=\"".$imageWidth."\" height=\"".$imageHeight."\"";
		}
	}
	else 
		$img_top_slice = "";
	
	
	$img_bg_links = "";
	$abpath_temp_bg_links = SERVER_PATH."/tamplate/".stripslashes($data_colors['img_bg_links']);
	if( file_exists($abpath_temp_bg_links) && !is_dir($abpath_temp_bg_links) )
		$img_bg_links = "background=\"".HTTP_PATH."/tamplate/".stripslashes($data_colors['img_bg_links'])."\"";
	
	
	$img_bg_txt_area = "";
	$img_bg_txt_area_forPages = ( $m == "hp" ) ? "img_bg_txt_area_hp" : "img_bg_txt_area";
	
	$abpath_temp_bg_txt_area = SERVER_PATH."/tamplate/".stripslashes($data_colors[$img_bg_txt_area_forPages]);
	$abpath_temp_bg_txt_areaOrginal = SERVER_PATH."/tamplate/".stripslashes($data_colors['img_bg_txt_area']);
	
	if( file_exists($abpath_temp_bg_txt_area) && !is_dir($abpath_temp_bg_txt_area) )
	{
		$img_bg_txt_area = "background=\"".HTTP_PATH."/tamplate/".stripslashes($data_colors[$img_bg_txt_area_forPages])."\"";
		$take_img_bg_txt = $img_bg_txt_area_forPages;
	}
	elseif( file_exists($abpath_temp_bg_txt_areaOrginal) && !is_dir($abpath_temp_bg_txt_areaOrginal) )
	{
		$img_bg_txt_area = "background=\"".HTTP_PATH."/tamplate/".stripslashes($data_colors['img_bg_txt_area'])."\"";
		$take_img_bg_txt = "img_bg_txt_area";
	}
	
	$COLORconent_bg_color = ( !empty($data_colors['conent_bg_color']) ) ? "bgcolor=\"#".$data_colors['conent_bg_color']."\"" : "";
	
	if( UNK == "530031109941269842" ) // b7omanim.com
	{
		if( ( $um == "text" && $_GET['t'] != "" ) || $um == "")
			$text_area_bg = $COLORconent_bg_color;
		else
		$text_area_bg = ( $img_bg_txt_area == "" ) ? $COLORconent_bg_color  : "background='".HTTP_PATH."/tamplate/".stripslashes($data_colors[$take_img_bg_txt])."'";
	}
	elseif( UNK == "544211511110655012" )
		$text_area_bg = ( $img_bg_txt_area == "" ) ? $COLORconent_bg_color  : "background='".HTTP_PATH."/tamplate/".stripslashes($data_colors[$take_img_bg_txt])."' style='background-repeat: repeat-y;'";
	elseif( UNK == "463632676397782499" )
		$text_area_bg = ( $um == "zoom_gallery" ) ? "bgcolor=\"#ffffff\""  : "";
	else
		$text_area_bg = ( $img_bg_txt_area == "" ) ? $COLORconent_bg_color  : "background='".HTTP_PATH."/tamplate/".stripslashes($data_colors[$take_img_bg_txt])."'";
	
	
	
	$flash_right_menu = "";
	$right_menu_beckground = "";
	$abpath_temp_flash_right_menu = SERVER_PATH."/tamplate/".stripslashes($data_colors['flash_right_menu']);
	if( file_exists($abpath_temp_flash_right_menu) && !is_dir($abpath_temp_flash_right_menu) )
	{
		$flash_right_menu = "
			<noindex><div id=\"LSflash_right_menu\"></div>
				
				<script type=\"text/javascript\">
					swfPlayer(\"/tamplate/".stripslashes($data_colors['flash_right_menu'])."\",\"flash_right_menu\",\"".stripslashes($data_colors['flash_right_menu_width'])."\",\"".stripslashes($data_colors['flash_right_menu_height'])."\",\"#".stripslashes($data_colors['flash_right_menu_color'])."\",\"LSflash_right_menu\");
				</script></noindex>";
	}
	else
	{
		$abpath_temp_right_menu_beckground = SERVER_PATH."/tamplate/".stripslashes($data_colors['right_menu_beckground']);
		if( file_exists($abpath_temp_right_menu_beckground) && !is_dir($abpath_temp_right_menu_beckground) )
		{
			$right_menu_beckground = "background=\"".HTTP_PATH."/tamplate/".stripslashes($data_colors['right_menu_beckground'])."\"";
		}
	}
	

// estimate defualt values - for backGraoungs
	if( $data_extra_settings['estimateSite'] == "1" )
	{
		if( $swf_top_slice == "" )
		{
			$swf_top_slice = "
				<noindex><div id=\"LStop_slice\"></div>
				
				<script type=\"text/javascript\">
					swfPlayer(\"/new_images/default_top_slice_orange_775_90.swf\",\"top_slice\",\"775\",\"90\",\"#\",\"LStop_slice\");
				</script></noindex>";
		}
	}
	


	if( $data_name['have_ecom'] == "1" && $_SESSION['ecom']['active'] != "1" && ( $_SESSION['ecom']['unickSES'] == "" ) )
	{
		$_SESSION['ecom']['active'] = "1";
		$ss1  = time("H:m:s",1000000000);
		$ss1 = str_replace(":",3,$ss1); 
		$ss2  = date("d.m.Y");
		$ss2 = str_replace(".",9,$ss2); 
		$ness =  $ss1."5".$ss2.UNK;
		$md5_val = md5( $ness );
		$_SESSION['ecom']['unickSES'] = $md5_val;
	}
	elseif( $_POST['EcomSes_net'] != "" )
	{
		$_SESSION['ecom']['unickSES'] = $_POST['EcomSes_net'];
	}
	
	
	###  define coin type in the site  ####
	switch( $data_words['coin_type'] )
	{
		case "0" :			$coin_type = "₪";					break;
		case "1" :			$coin_type = "$";									break;
		case "2" :			$coin_type = "&euro;";						break;
	}
	define('COIN',$coin_type);
	
	// "http://www.w3.org/TR/html4/frameset.dtd"<!DOCTYPE HTML PUBLIC "-//W3C//DTD XHTML 1.0 Frameset//EN" >
	
	if( $_GET['m'] == "zoom_gallery" )
	{
		unset ($_SESSION['imageZoom']);
		$_SESSION['imageZoom']=array();
		
		$_GET['example'] = 2;
		
		if (!isset($_GET['zoomDir'])){
			
			$subject_id = ( $_GET['sub'] == "" ) ? "AND subject_id = ''" : "AND subject_id = ".ifint($_GET['sub']);
			$sql = "select * from user_gallery_cat where unk = '".UNK."' and deleted = '0' and active = '0' ".$subject_id." limit 1";
			$res = mysql_db_query(DB,$sql);
			$data_cat = mysql_fetch_array($res);
			
			$temp_cat = ( $_GET['cat'] ) ? $_GET['cat'] : $data_cat['id'];
			
			$_GET['zoomDir'] = 'a'.$temp_cat;
			
		}else if(isset($_GET['zoomDir']) AND !isset($_GET['abc'])){
			$getDir=1;
		}
		
		//if( UNK == "" )
		require ('zoomFiles/axZm/zoomInc.inc.php');
	}

//if( $_SERVER[REMOTE_ADDR] == "84.228.118.133" )
echo '<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">';
echo '
<html>
<head>
';

	echo '<meta HTTP-EQUIV="Content-Type" CONTENT="text/html; charset='.$site_charset.'">';
	
	if( $data_extra_settings['indexSite'] == "1" )
	{
		$headlinesTitle = "";
		switch( $m )
		{
			case "KgBm" :
				if( $_GET['guide'] && ifint($_GET['guide']) != "0" )
				{
					$sql = "SELECT guide_name FROM user_guide WHERE id = '".ifint($_GET['guide'])."'";
					$res_hh1 = mysql_db_query(DB, $sql);
					$data_hh1 = mysql_fetch_array($res_hh1);
					
					$headlinesTitle = stripslashes($data_hh1['guide_name']).", ";
				}
				
				if( $_GET['Scat'] && ifint($_GET['Scat']) != "0" )
				{
					$sql = "SELECT cat_name FROM user_guide_cats WHERE id = '".ifint($_GET['Scat'])."'";
					$res_hh2 = mysql_db_query(DB, $sql);
					$data_hh2 = mysql_fetch_array($res_hh2);
					
					$headlinesTitle .= stripslashes($data_hh2['cat_name']).", ";
				}
				
				if ( ifint($_GET['STcat']) != "" && ifint($_GET['STcat']) != "0" )
				{
					$sql = "SELECT cat_name FROM user_guide_cats WHERE id = '".ifint($_GET['STcat'])."'";
					$res_hh3 = mysql_db_query(DB, $sql);
					$data_hh3 = mysql_fetch_array($res_hh3);
					
					$headlinesTitle .= stripslashes($data_hh3['cat_name']).", ";
				}
				
				if( $headlinesTitle == '' )
					$headlinesTitle = indexSite__global_settings("headTitle1");
			break;
			
			case "KgBm_p" :
				if( $_GET['guide'] && ifint($_GET['guide']) != "0" )
				{
					$sql = "SELECT guide_name FROM user_guide WHERE id = '".ifint($_GET['guide'])."'";
					$res_hh1 = mysql_db_query(DB, $sql);
					$data_hh1 = mysql_fetch_array($res_hh1);
					
					$headlinesTitle = stripslashes($data_hh1['guide_name']).", ";
				}
				
				if( $_GET['pid'] && ifint($_GET['pid']) != "0" )
				{
					$sql = "SELECT business_name FROM user_guide_business WHERE unk = '".UNK."' AND id = '".ifint($_GET['pid'])."' ";
					$res_hh12 = mysql_db_query(DB,$sql);
					$data_hh12 = mysql_fetch_array($res_hh12);
					
					$headlinesTitle .= stripslashes($data_hh12['business_name']).", ";
				}
				
				if( $headlinesTitle == '' )
					$headlinesTitle = indexSite__global_settings("headTitle1");
			break;
			
			case "KgAdG" :	case "KgAdGU" :		case "KgAdGT" :	
				$headlinesTitle = indexSite__global_settings("headTitleAdd");	
			break;
				
			default :
				$headlinesTitle = $addMoreTitle."  ";
			
				if( $headlinesTitle == "  " )
				{
					$headlinesTitle = indexSite__global_settings("headTitleHP");
				}
		}
		
		if( $headlinesTitle != '' )
			echo '<title>'.substr($headlinesTitle , 0 , -2 ).'</title>';
		else
			echo '<title>'.$addMoreTitle.'</title>';
		
	}
	else
		echo '<title>'.$addMoreTitle.'</title>';
	
	if( $data_extra_settings['userCanSEO'] == "1" )
	{
		switch($m)
		{
			case "ar" :
				$sql = "SELECT summary FROM user_articels WHERE id='".ifint($_GET['artd'])."' AND unk='".UNK."' AND deleted=0";
				$res = mysql_db_query(DB,$sql);
				$data_summary = mysql_fetch_array($res);
				
				if( $data_summary['summary'] != "" )
					$description = str_replace("\"" , "" , stripslashes($data_summary['summary']) );
				else
					$description = str_replace("\"" , "" , stripslashes($data_settings['description']) );
				$keywords = str_replace("\"" , "" , stripslashes($data_settings['keywords']) );
			break;
			
			case "text" :
				$type = ( $_GET['type'] != "" ) ? $_GET['type'] : $_GET['t'];
		 		$sql = "SELECT description,keywords FROM content_pages WHERE id='".ifint($type)."' AND unk='".UNK."' AND deleted=0";
				$res = mysql_db_query(DB,$sql);
				$data_content = mysql_fetch_array($res);
				
				if( $data_content['description'] != "" )
					$description = str_replace("\"" , "" , stripslashes($data_content['description']) );
				else
					$description = str_replace("\"" , "" , stripslashes($data_settings['description']) );
				
				if( $data_content['keywords'] != "" )
					$keywords = str_replace("\"" , "" , stripslashes($data_content['keywords']) );
				else
					$keywords = str_replace("\"" , "" , stripslashes($data_settings['keywords']) );
			break;
			
			default:
				$keywords = str_replace("\"" , "" , stripslashes($data_settings['keywords']) );
				$description = str_replace("\"" , "" , stripslashes($data_settings['description']) );
		}
	}
	else
	{
		$keywords = str_replace("\"" , "" , stripslashes($data_settings['keywords']) );
		$description = str_replace("\"" , "" , stripslashes($data_settings['description']) );
		
	}
	
	
	
	if( $description != "" )
		echo '<META NAME="DESCRIPTION" CONTENT="'.$description.'">';
	
	if( $keywords != "" )
		echo '<META NAME="KEYWORDS" CONTENT="'.$keywords.'">';
	
	
	
	if( $net_mailing__google_block == "1" )
		echo '<META NAME="ROBOTS" CONTENT="NOINDEX, NOFOLLOW">';
		
	if( $data_extra_settings['have_noindex'] == "1" )
		echo '<META NAME="ROBOTS" CONTENT="NOINDEX, NOFOLLOW">';
	
	if( UNK == "358388408164915383" && $_GET['t'] == "2270" )
		echo '<META NAME="ROBOTS" CONTENT="NOINDEX, NOFOLLOW">';
	
	if( UNK == "759923718705913766" && $_GET['t'] == "18032" )
		echo '<META NAME="ROBOTS" CONTENT="NOINDEX, NOFOLLOW">';
	if( UNK == "759923718705913766" && $_GET['t'] == "8148" )
		echo '<META NAME="ROBOTS" CONTENT="NOINDEX, NOFOLLOW">';
		
	if( UNK == "904337153122360469" && $_GET['t'] == "18564" )
		echo '<META NAME="ROBOTS" CONTENT="NOINDEX, NOFOLLOW">';
	
	if( UNK == "759923718705913766" && $_GET['t'] == "4177" )
		echo '<META NAME="ROBOTS" CONTENT="NOINDEX, NOFOLLOW">';	
	
	echo '<meta name="SKYPE_TOOLBAR" content="SKYPE_TOOLBAR_PARSER_COMPATIBLE" />';
	if( $_GET['m'] == "zoom_gallery" )
	{
		echo "
		<link rel=\"stylesheet\" href=\"/zoomFiles/axZm/plugins/demo/colorbox/example4/colorbox.css\" media=\"screen\" type=\"text/css\">
		<link rel=\"stylesheet\" href=\"/zoomFiles/axZm/plugins/demo/jquery.fancybox/jquery.fancybox-1.2.6.css\" media=\"screen\" type=\"text/css\">
		<link rel=\"stylesheet\" href=\"/zoomFiles/axZm/axZm.css\" type=\"text/css\" media=\"screen\">
		<script type=\"text/javascript\" src=\"/zoomFiles/axZm/plugins/jquery-1.6.2.min.js\"></script>
		<script type=\"text/javascript\" src=\"/zoomFiles/axZm/jquery.axZm.js\"></script>
		<script type=\"text/javascript\" src=\"/zoomFiles/axZm/plugins/demo/colorbox/jquery.colorbox.js\"></script>
		<script type=\"text/javascript\" src=\"/zoomFiles/axZm/plugins/demo/jquery.fancybox/jquery.fancybox-1.2.6.js\"></script>
		";
	}
	
	//echo "<script type=\"text/javascript\" src=\"http://www.ilbiz.co.il/newsite/test/chromejs/chrome.js\"></script>";
	?>
	
	
	
<link rel="stylesheet" type="text/css" media="screen" href="/style.php?m=<?=$m;?>">

<script type="text/javascript" src="/script.php?m=<?=$m;?>"></script>
<script type="text/javascript" src="http://www.ilbiz.co.il/global_func/prototype.js"></script>
<script type="text/javascript" src="http://www.ilbiz.co.il/ClientSite/js/ajax.js"></script>

<?
if( $_GET['m'] == "einYahav_price_page" || $_GET['m'] == "einYahav_login_page")
{
	echo '<link rel="stylesheet" href="http://www.ilbiz.co.il/ClientSite/js/calendarview.css">';
	echo '<script type="text/javascript" src="http://www.ilbiz.co.il/ClientSite/js/calendarview.js"></script>';
	
	echo "
	<script>
	 window.onload = function() {
      Calendar.setup({
        dateField      : 'date1',
        triggerElement : 'date1'
      })
    }
  </script>
  
  ";
}



if( $data_name['flex_galleryType'] == "6" )
{
	echo '<script type="text/javascript" src="http://www.ilbiz.co.il/ClientSite/js/scriptaculous.js?load=effects,builder"></script>';
	
	echo '<script type="text/javascript" src="http://www.ilbiz.co.il/ClientSite/js/lightbox.php?lang='.LANG.'"></script>';
	echo '<link rel="stylesheet" href="http://www.ilbiz.co.il/ClientSite/js/lightbox_css.php?lang='.LANG.'" type="text/css" media="screen">';
}

if( $m == "jo" || $m == "jobs" )
	echo '<script type="text/javascript" src="http://www.ilbiz.co.il/ClientSite/js/catsScriptJobs.php?unk='.UNK.'&STcat='.$_GET['STcat'].'&Sspec='.$_GET['Sspec'].'"></script>';

if( $data_name['have_ecom'] == "1" )
	echo '<script type="text/javascript" src="http://www.ilbiz.co.il/ClientSite/js/fly-to-basket.js"></script>';
elseif( UNK == "038157696328808156" )
	echo '<script type="text/javascript" src="http://www.ilbiz.co.il/ClientSite/js/fly-to-basket-chip.haari.js"></script>';


	if( file_exists(SERVER_PATH."/favicon.ico") && !is_dir(SERVER_PATH."/favicon.ico") )
		echo '<link rel="shortcut icon" type="image/x-icon" href="/favicon.ico">';
?>


<link rel="stylesheet" href="http://ilbiz.co.il/ClientSite/other/popup/dhtmlwindow.css" type="text/css">

<script type="text/javascript" src="http://ilbiz.co.il/ClientSite/other/popup/dhtmlwindow.js"></script>
<!--
<script type="text/javascript" src="http://ilbiz.co.il/ClientSite/other/amung.js"></script>
<script type="text/javascript">WAU_small('mclq6nyqgiga')</script>
-->
<script type="text/javascript" src="https://apis.google.com/js/plusone.js">
  {lang: 'iw'}
</script>


<?
echo '<script type="text/javascript" src="http://ilbiz.co.il/ClientSite/other/flash/ver2/swfobject.js"></script>';

if( $data_extra_settings['indexSite'] == "1" )
	echo "<script type='text/javascript' src='catsScript.php?Scat=".$_GET['Scat']."&STcat=".$_GET['STcat']."&unk=".UNK."'></script>";

?>


<script type="text/javascript" src="http://ilbiz.co.il/ClientSite/other/flash/FABridge.js"></script>
	
	<?
		$sql = "select id from user_news where deleted = '0' and unk = '".UNK."' ORDER BY id DESC";
		$res = mysql_db_query(DB,$sql);
		$num_rows = mysql_num_rows($res);
		
		if( $num_rows > 0 )
			echo "<script type=\"text/javascript\" src=\"js.js\"></script>";
	
	
	
	if( UNK == "745262061697263702" OR UNK == "138572023197195185" OR UNK == "029638488130353217" )
		echo castum_topMenu_flash();
	
	?>
	
</head>

<?
$COLORconent_bg_color = ( !empty($data_colors['conent_bg_color']) ) ? "bgcolor=\"#".$data_colors['conent_bg_color']."\"" : "";
$COLORmenus_color = ( !empty($data_colors['menus_color']) ) ? "bgcolor=\"#".$data_colors['menus_color']."\"" : "";
$COLORimg_bg_txt_area_bottom_color = ( !empty($data_colors['img_bg_txt_area_bottom_color']) ) ? "bgcolor=\"#".$data_colors['img_bg_txt_area_bottom_color']."\"" : "";

?>

<body>

<div id="fb-root"></div>
<script type="text/javascript">
  window.fbAsyncInit = function() {
    FB.init({appId: '<?=$data_extra_settings['facebookPageId'];?>', status: true, cookie: true,
             xfbml: true});
  };
  (function() {
    var e = document.createElement('script'); e.async = true;
    e.src = document.location.protocol +
      '//connect.facebook.net/en_US/all.js';
    document.getElementById('fb-root').appendChild(e);
  }());
</script>

<?
$site_width = ( $data_extra_settings['site_width'] == "" ) ? "775" : $data_extra_settings['site_width'];
echo "<table border=\"0\" cellspacing=\"0\" cellpadding=\"0\" align=\"center\" dir=\"".$settings['dir']."\" width=\"".$site_width."\" ".$table_border.">";
	
	
	if( $data_extra_settings['indexSite'] == "1" )
	{
		echo "<tr>";
			echo "<td valign=bottom align=\"center\">";
				Guide_Banners("up" , "0" , "view" );
			echo "</td>";
		echo "</tr>";
	}
	
	if( $data_extra_settings['estimateSite'] == "1" && UNK != "413797887191314315" && UNK != "358388408164915383" && $data_extra_settings['indexSite'] != "1" )
	{
		$type = ( $_GET['type'] != "" ) ? $_GET['type'] : $_GET['t'];
		
		echo "<tr>";
			echo "<td class='headline'>";
				switch($data_extra_settings['estimateTopTitle'])
				{
					case "" :	$estimateTopTitle = " - השוואת מחירים";	break;
					case "-" : $estimateTopTitle = "";	break;
					default:	$estimateTopTitle = " ".$data_extra_settings['estimateTopTitle'];
				}
				
				if( ( $m == "text" && $type == "text" ) || $m == "hp" )	echo "<h1 class='headline' style='font-size: 12px; padding:0; margin:0;'>".trim(stripslashes($data_name['name'])). $estimateTopTitle . "</h1>";
				elseif( $m == "text" && $type != ""  )
				{
					$sql = "SELECT name FROM content_pages WHERE id='".ifint($type)."' AND unk='".UNK."' AND deleted=0";
					$res = mysql_db_query(DB,$sql);
					$page_name_by_content = mysql_fetch_array($res);
					
					echo "<h1 class='headline' style='font-size: 12px; padding:0; margin:0;'>".trim(stripslashes($page_name_by_content['name']))."</h1>";
				}
				else
					echo "<h1 class='headline' style='font-size: 12px; padding:0; margin:0;'>&nbsp;</h1>";
				//elseif( UNK == "759923718705913766" )
				//	echo "<h1 class='headline' style='font-size: 12px; padding:0; margin:0;'>&nbsp;</h1>";
				
			echo "</td>";
		echo "</tr>";
	}
	
	if( !(UNK == "932085872939085012" && $m == "hp") )
	{
		if( $data_extra_settings['have_topSliceHtml'] == "1" && $data_extra_settings['topSliceHtml'] != "" )
		{
			if( $data_extra_settings['indexSite'] == "1" )
			{
				$temp_topslice = top_slice_search_kolnegev();
				$temp_topslice2 = top_slice_search_kolnegev_free_text();
				
				$arrTOP1 = array( "!!!CODE_SERACH_ENGING_NOT_DELETE!!!" , "!!!CODE_SERACH_ENGING_2_NOT_DELETE!!!" );
				$arrTOP12 = array( $temp_topslice , $temp_topslice2 );
				
				$topSliceHtml = str_replace( $arrTOP1 , $arrTOP12 , $data_extra_settings['topSliceHtml'] );;
			}
			else
				$topSliceHtml = stripslashes($data_extra_settings['topSliceHtml']);
			
			echo "<tr>";
				echo "<td>".$topSliceHtml.$topSliceHtml2."</td>";
			echo "</tr>";
		}
		else
		{
			if( $data_name['have_top_address'] == "0" )
			{
				
				echo "<tr>";
					echo "<td ".$COLORconent_bg_color.">";
						echo top_user_address();
					echo "</td>";
				echo "</tr>";
				echo "<tr><td height=\"3\" ".$COLORconent_bg_color."></td></tr>";
			}
			
			
			if( !empty($img_top_slice) )
				echo "<tr><td ".$COLORmenus_color." ".$img_top_slice."></td></tr>";
			elseif( !empty($swf_top_slice) )
			{
				if( UNK == "179082701464956299" )
					echo "<tr><td>".specail_func_topSlice_medicart()."</td></tr>";
				else
					echo "<tr><td>".$swf_top_slice."</td></tr>";
			}
			elseif( UNK == "950576106799129933" )
				echo "<tr><td>".specail_func_topSlice_medicart2()."</td></tr>";
			elseif( UNK == "932085872939085012" && $m == "text" && $_GET['t'] == "text" )			// interpool
				echo "";
			else
			{
				echo "<tr>
					<td ".$COLORmenus_color.">
							<table border=\"0\" cellspacing=\"0\" cellpadding=\"0\">
								<tr><tD height=\"3\" colspan=\"2\"></td></tr>
								<tr>
									<!-- LOGO -->
									<td width=\"150\" align=\"center\">".$img_logo."</td>
									<!-- Slogen and name of the biz -->
									<td>
										<table border=\"0\" cellspacing=\"0\" cellpadding=\"0\">
											<tr>
												<td width=\"35\"></td>
												<td><h1 class=\"headline\">".stripslashes($data_name['name'])."</h1></td>
											</tr>
											<tr>
												<td width=\"35\"></td>
												<td><h4 class=\"headline\">".stripslashes($data_settings['slogen'])."</h4></td>
											</tr>
										</table>
									</td>
								</tr>
								<tr><tD height=\"3\" colspan=\"2\"></td></tr>
							</table>
					</td>
				</tr>";
			}
		}
	}
	?>
	
	
	
	<tr>
		<td>
			<table border="0" cellspacing="0" cellpadding="0">
				<tr>
					<?
					if( $data_name['have_rightmenu'] == "0" && $with_out_RightMenu == "0" )
					{
						if( !empty($flash_right_menu) )
						{
							?>
							<td width="150" <?echo $right_menu_beckground;?> <?echo $COLORmenus_color;?> valign="top">
								<table border="0" cellspacing="0" cellpadding="0">
									
									<?
									echo "<tr><TD height=\"10\" colspan=\"3\"></TD></tr>";
									
									if( $data_name['advBannerOrder'] == "1" )
									{
										echo "<TR>";
											echo "<TD colspan=\"3\" align='center'>";
												echo "<table border=\"0\" cellspacing=\"0\" cellpadding=\"0\" class=\"maintext\">";
													echo "<tr>";
														echo "<td valign=top>";
														
															// marketing_partners( banner location type )
															marketing_partners("1");
															
														echo "</td>";
													echo "</tr>";
												echo "</table>";
											echo "</TD>";
										echo "</TR>";
										echo "<tr><TD height=\"10\" colspan=\"3\"></TD></tr>";
									}
									
									if( $data_name['have_add_favi'] == "1" && $data_extra_settings['estimateSite'] == "0" )
									{
										echo "<tr>";
											echo "<td width=\"5\">";
											echo "<td align='center'>";
												echo add_to_favorite();
											echo "</td>";
											echo "<td width=\"5\">";
										echo "</tr>";
									}
									
									if( $data_name['have_print'] == "1" && $m != "gallery"  )
									{
										rightMenu__print_link();
									}
									
									if( $data_name['have_google_search'] == "0" )
									{
									echo "<tr>";
										echo "<td colspan=\"3\" align='center' style='padding-top: 5px;'>";
											echo google_search();
										echo "</td>";
									echo "</tr>";
									}
									
									if( $data_name['have_ecom'] == "1" )
									{
									echo "<tr>";
										echo "<td colspan=\"3\">";
											ecom_table();
										echo "</td>";
									echo "</tr>";
									}
									
									if( $data_name['have_searchEng'] == "0" )
									{
									echo "<tr>";
										echo "<td colspan=\"3\" align='center' style='padding-top: 5px;'>";
											echo search_form();
										echo "</td>";
									echo "</tr>";
									}
									
									if( $data_name['scrollNewsOrder'] == "1" )
									{
										echo "<tr><TD height=\"5\" colspan=\"3\"></TD></tr>";
										echo "<TR>";
											echo "<TD colspan=\"3\" align='".$settings['align']."'>";
												echo "<table border=\"0\" cellspacing=\"0\" cellpadding=\"0\" class=\"maintext\">";
												
													if( $m != "hp" )
														echo scroll_news();
														
												echo "</table>";
											echo "</TD>";
										echo "</TR>";
									}
									
									echo "<tr><TD height=\"5\"></TD></tr>";
									
									echo "<td width=\"150\" valign=\"top\" align=\"center\" colspan=\"3\">";
										echo $flash_right_menu;
									echo "</td>";
									
									if( $data_name['scrollNewsOrder'] == "0" )
									{
										echo "<TR>";
											echo "<TD colspan=\"3\" align='".$settings['align']."'>";
												echo "<table border=\"0\" cellspacing=\"0\" cellpadding=\"0\" class=\"maintext\">";
												
													if( $m != "hp" )
														echo scroll_news();
												
												echo "</table>";
											echo "</TD>";
										echo "</TR>";
									}
									
									
									if( $data_name['advBannerOrder'] == "0" )
									{
										echo "<tr><TD height=\"6\" colspan=\"3\"></TD></tr>";
										echo "<TR>";
											echo "<TD colspan=\"3\" align='center'>";
												echo "<table border=\"0\" cellspacing=\"0\" cellpadding=\"0\" class=\"maintext\">";
													echo "<tr>";
														echo "<td valign=top>";
															
																// marketing_partners( banner location type )
																marketing_partners("1");
															
														echo "</td>";
													echo "</tr>";
												echo "</table>";
											echo "</TD>";
										echo "</TR>";
									}
									
									if( UNK == "783491905378104415" )
									{
										echo "<tr><TD height=\"6\" colspan=\"3\"></TD></tr>";
										echo "<TR>";
											echo "<TD colspan=\"3\" align='center'>";
											?>
												<script type="text/javascript" id="shomer_js" src="http://www.shomershabes.com/service/service_js_new.asp?txtclr=000000&size=1&anim=1&txtplace=1&d="></script>
											<?
											echo "</td>";
										echo "</tr>";
									}
									?>
									
								</table>
							</td>
							<?
							
						}
						else
						{
							?>
							<td width="150" <?echo $right_menu_beckground;?> <?echo $COLORmenus_color;?> valign="top">
								<table border="0" cellspacing="0" cellpadding="0">
									
									<?
									
									echo "<tr><TD height=\"10\" colspan=\"3\"></TD></tr>";
									
									if( $data_name['advBannerOrder'] == "1" )
									{
										echo "<TR>";
											echo "<TD colspan=\"3\" align='center'>";
												echo "<table border=\"0\" cellspacing=\"0\" cellpadding=\"0\" class=\"maintext\">";
													echo "<tr>";
														echo "<td valign=top>";
															
																// marketing_partners( banner location type )
																marketing_partners("1");
															
														echo "</td>";
													echo "</tr>";
												echo "</table>";
											echo "</TD>";
										echo "</TR>";
										echo "<tr><TD height=\"10\" colspan=\"3\"></TD></tr>";
									}
								
									if( $data_name['have_add_favi'] == "1" && $data_extra_settings['estimateSite'] == "0" )
									{
										echo "<tr>";
											echo "<td width=\"5\">";
											echo "<td align='center'>";
												echo add_to_favorite();
											echo "</td>";
											echo "<td width=\"5\">";
										echo "</tr>";
									}
									
									if( $data_name['have_print'] == "1" && $m != "gallery"  )
									{
										rightMenu__print_link();
									}
									
									if( $data_name['have_google_search'] == "0" )
									{
									echo "<tr>";
										echo "<td colspan=\"3\" align='center' style='padding-top: 5px;'>";
											echo google_search();
										echo "</td>";
									echo "</tr>";
									}
									
									if( $data_name['have_ecom'] == "1" )
									{
									echo "<tr>";
										echo "<td colspan=\"3\">";
											ecom_table();
										echo "</td>";
									echo "</tr>";
									}
									
									if( $data_name['have_searchEng'] == "0" )
									{
									echo "<tr>";
										echo "<td colspan=\"3\" align='center' style='padding-top: 5px;'>";
											echo search_form();
										echo "</td>";
									echo "</tr>";
									
									}
									
									if( $data_name['scrollNewsOrder'] == "1" )
									{
										echo "<tr><TD height=\"5\" colspan=\"3\"></TD></tr>";
										echo "<TR>";
											echo "<TD colspan=\"3\" align='".$settings['align']."'>";
												echo "<table border=\"0\" cellspacing=\"0\" cellpadding=\"0\" class=\"maintext\">";
												
													if( $m != "hp" )
														echo scroll_news();
												
												echo "</table>";
											echo "</TD>";
										echo "</TR>";
									}
								
									if( $data_name['have_calender_events'] == "1" && $data_name['place_calender_events'] == "1")
									{
										echo "<tr><TD height=\"15\" colspan=\"3\"></TD></tr>";
										echo "<TR>";
											echo "<TD colspan=\"3\" align=center>";
												echo "<table border=\"0\" cellspacing=\"0\" cellpadding=\"0\" class=\"maintext\">";
													echo "<tr>";
														echo "<td valign=top>";
																
																if( $_GET['y'] != "" && $_GET['mon'] != "" && $_GET['d'] != ""  )
																	user_calendar(GlobalFunctions::if_is_int($_GET['d'])."-".GlobalFunctions::if_is_int($_GET['mon'])."-".GlobalFunctions::if_is_int($_GET['y']));
																else
																	user_calendar();
															
														echo "</td>";
													echo "</tr>";
												echo "</table>";
											echo "</TD>";
										echo "</TR>";
										echo "<tr><TD height=\"10\" colspan=\"3\"></TD></tr>";
									}
									
									echo "<tr><TD height=\"5\" colspan=\"3\"></TD></tr>";
									
									
									echo "<tr>";
										echo "<td width=\"5\">";
										echo "<td width=\"140\">";
											rightMenu__links();
										echo "</td>";
										echo "<td width=\"5\">";
									echo "</tr>";
									
									if( $img_bg_links == "" )
										echo "<tr><TD height=\"2\"></TD></tr>";
									else 
										echo "<tr><TD height=\"10\"></TD></tr>";
									
									
									echo "<tr>";
										echo "<td width=\"5\">";
										echo "<td width=\"140\">";
											rightMenu__db_links();
										echo "</td>";
										echo "<td width=\"5\">";
									echo "</tr>";
									
									echo "<tr><TD height=\"15\" colspan=\"3\"></TD></tr>";
									
									
									if( $data_name['scrollNewsOrder'] == "0" )
									{
										echo "<TR>";
											echo "<TD colspan=\"3\" align='".$settings['align']."'>";
												echo "<table border=\"0\" cellspacing=\"0\" cellpadding=\"0\" class=\"maintext\">";
												
													if( $m != "hp" )
														echo scroll_news();
												
												echo "</table>";
											echo "</TD>";
										echo "</TR>";
									}
									
									if( $data_name['have_calender_events'] == "1" && $data_name['place_calender_events'] == "0")
								{
										echo "<tr><TD height=\"15\" colspan=\"3\"></TD></tr>";
										echo "<TR>";
											echo "<TD colspan=\"3\" align=center>";
												echo "<table border=\"0\" cellspacing=\"0\" cellpadding=\"0\" class=\"maintext\">";
													echo "<tr>";
														echo "<td valign=top>";
																
																if( $_GET['y'] != "" && $_GET['mon'] != "" && $_GET['d'] != ""  )
																	user_calendar(GlobalFunctions::if_is_int($_GET['d'])."-".GlobalFunctions::if_is_int($_GET['mon'])."-".GlobalFunctions::if_is_int($_GET['y']));
																else
																	user_calendar();
															
														echo "</td>";
													echo "</tr>";
												echo "</table>";
											echo "</TD>";
										echo "</TR>";
										echo "<tr><TD height=\"5\" colspan=\"3\"></TD></tr>";
								}
									
									if( $data_name['advBannerOrder'] == "0" )
									{
										echo "<tr><TD height=\"6\" colspan=\"3\"></TD></tr>";
										echo "<TR>";
											echo "<TD colspan=\"3\" align='center'>";
												echo "<table border=\"0\" cellspacing=\"0\" cellpadding=\"0\" class=\"maintext\">";
													echo "<tr>";
														echo "<td valign=top>";
															
																// marketing_partners( banner location type )
																marketing_partners("1");
															
														echo "</td>";
													echo "</tr>";
												echo "</table>";
											echo "</TD>";
										echo "</TR>";
								}
								
									if( UNK == "497485759822944433" )
									{
										echo "<tr><TD height=\"6\" colspan=\"3\"></TD></tr>";
										echo "<TR>";
											echo "<TD colspan=\"3\" align='center'>";
											?>
												<iframe scrolling="no" marginheight="0" marginwidth="0" frameborder="0" src="http://www.shomershabes.com/service/service.asp?bgclr=fafbff&txtclr=000000&size=1&anim=1&txtplace=2&d=660" width="120" height="80"></iframe>
											<?
											echo "</td>";
										echo "</tr>";
									}
									
									?>
									
								</table>
							</td>
							<?
						}
						$width_content = "625";
					}
					else
						$width_content = $site_width;
					?>
					<td width="<?=$width_content;?>" <?=$text_area_bg;?> valign="top">
						<?php
						echo '<table border="0" cellspacing="0" cellpadding="0">';
							
							if( $data_name['have_topmenu'] == 1 )
							{
								topMenu__chromemenu();
							}
							
							
							if( UNK == "759923718705913766" )
							{
								if( $m == "arLi" || $m == "sa" || $m == "co" )
								{
									echo "<tr><td colspan=\"3\" height=\"10\"></td></tr>";
									continer__headline();
								}
								elseif( $m == "search" && $_GET['search_val'] == "" )
								{
									echo "<tr><td colspan=\"3\" height=\"20\"></td></tr>";
									echo "<tr><td width=50></td><td valign=\"top\" style='padding-right: 30px;'><h1 class=\"page_headline\">מפת אתר</h1></td><td width=50></td></tr>";
								}
								else
									echo "<tr><td colspan=\"3\" height=\"10\"></td></tr>";
							}
							elseif( $data_name['have_headline'] == "0" )
								continer__headline();
							elseif( UNK != "463632676397782499" )
								echo "<tr><td colspan=\"3\" height=\"10\"></td></tr>";
							
							
							if( $data_extra_settings['have_share_button'] == "1" &&  $m != 'hp' )
							{
								echo "<tr><td colspan=\"3\" height=\"10\"></td></tr>";
								echo "<tr>";
									echo "<td width=\"35\"></td>";
									echo "<td>";
										echo "<table border=\"0\" width=100% cellspacing=\"0\" cellpadding=\"0\" class=\"maintext\">";
											echo "<tr>";
												
												
												echo "<td><div style='z-index:-9999;'><fb:like width=300 show_faces=false></fb:like></div></td>";
												
												echo "<td valign=top width=150>";
													echo '
													<script type="text/javascript">
														var addthis_config = {
														    data_track_clickback: true
														}
													</script>
													';
													echo '<!-- AddThis Button BEGIN -->
														<div class="addthis_toolbox addthis_default_style" style="padding-right: 35px;">
														<a href="http://www.addthis.com/bookmark.php?v=250&amp;username=ilbiz" class="addthis_button_compact"><font class="maintext" >'.$word[LANG]['1_2_facebook_share'].'</font></a>
														<span class="addthis_separator">|</span>
														<a class="addthis_button_facebook"></a>
														<a class="addthis_button_twitter"></a>
														</div>
														<script type="text/javascript" src="http://s7.addthis.com/js/250/addthis_widget.js#username=ilbiz"></script>
														<!-- AddThis Button END -->
													';
											
												echo "</td>";
												echo "<td width=10></td>";
												echo "<td valign=top><g:plusone size='medium'></g:plusone></td>";
												
											echo "</tr>";
										echo "</table>";
									echo "</td>";
									echo "<td width=\"35\"></td>";
								echo "</tr>";
								echo "<tr><td colspan=\"3\" height=\"10\"></td></tr>";
							}
							
							if( $data_name['have_rightmenu'] != "0" && $m != "hp" )
							{
								if( UNK != "932085872939085012" && UNK != "463632676397782499" )
								{
									echo "<tr><td colspan=\"3\" height=\"10\"></td></tr>";
									echo "<tr>";
										echo "<td width=\"35\"></td>";
										echo "<td>";
											echo marquee_by_side();
										echo "</td>";
										echo "<td width=\"35\"></td>";
									echo "</tr>";
									echo "<tr><td colspan=\"3\" height=\"10\"></td></tr>";
								}
							}
							
							$width_conent_td = ( $width_content == "775" ) ? "705" : "555";
							$zaafran_height = ( UNK == "463632676397782499" ) ? "height='354'" : "height='600'";
							
							if( UNK != "463632676397782499" )
								echo '<tr><td colspan="3" height="10"></td></tr>';
							?>
							<tr>
								<td width="35"></td>
								<td class="maintext" valign="top" <?=$zaafran_height;?> width="<?=$width_conent_td;?>">
									<?
									if( $net_mailing__set_user_loginNet == "1" )
										echo "<iframe src ='http://www.ilbiz.co.il/newsite/net_system/banner.php?unk=".UNK."&amp;b1=&amp;cnu=yes_regIT&amp;b2=' width='140' height='185' id='loginPage2' frameborder=0 scrolling=no allowtransparency='true'></iframe>";
									elseif( $net_mailing__string != "" )
										echo $net_mailing__string;
									else
										echo get_content($m);
									
									?>
								</td>
								<td width="35"></td>
							</tr>
							<tr><td colspan="3" height="10"></td></tr>
						</table>
					</td>
				</tr>
			</table>
		</td>
	</tr>
	
	
	<?php
	$i_have_bottom_back = 0;
	$abpath_temp = SERVER_PATH."/tamplate/".stripslashes($data_colors['img_bg_txt_area_bottom']);
	if( file_exists($abpath_temp) && !is_dir($abpath_temp) )	{ 
		$temp_test = explode( "." , $data_colors['img_bg_txt_area_bottom'] );
		
		if( $temp_test[1] == "swf" )
		{
			echo "<tr>";
				echo "<td valign=bottom align=\"". $settings['re_align'] ."\" ".$COLORimg_bg_txt_area_bottom_color.">";
					echo "<div id=\"LSimg_bg_txt_area_bottom\"></div>
					<script type=\"text/javascript\">
						swfPlayer(\"/tamplate/".stripslashes($data_colors['img_bg_txt_area_bottom'])."\",\"img_bg_txt_area_bottom\",\"".stripslashes($data_colors['img_bg_txt_area_bottom_width'])."\",\"".stripslashes($data_colors['img_bg_txt_area_bottom_height'])."\",\"#".stripslashes($data_colors['img_bg_txt_area_bottom_color'])."\",\"LSimg_bg_txt_area_bottom\");
					</script>";
				echo "</td>";
			echo "</tr>";
			$i_have_bottom_back = 1;
		}
		else
		{
			echo "<tr>";
				echo "<td valign=bottom align=\"". $settings['re_align'] ."\" ".$COLORmenus_color.">";
					echo "<img src=\"".HTTP_PATH."/tamplate/".stripslashes($data_colors['img_bg_txt_area_bottom'])."\" border=\"0\" alt=\"\" />";
				echo "</td>";
			echo "</tr>";
			$i_have_bottom_back = 1;
		}
	}
	
	if( $data_extra_settings['indexSite'] == "1" )
	{
		echo "<tr>";
			echo "<td valign=bottom align=\"center\">";
				guide_banners("bottom" , "0" , "view" );
			echo "</td>";
		echo "</tr>";
	}

	if( $data_extra_settings['have_BottomSliceHtml'] == "1" && $data_extra_settings['BottomSliceHtml'] != "" )
	{
		echo "<tr>";
			echo "<td valign=bottom>".stripslashes($data_extra_settings['BottomSliceHtml'])."</td>";
		echo "</tr>";
	}
	else
	{
		echo "<tr>";
			echo "<td height=\"19\" valign=bottom align=\"center\" ".$COLORmenus_color.">";
				bottom_copyright();
			echo "</td>";
		echo "</tr>";
	}
	
echo "</table>";

if( $data_extra_settings['wibiyaAnalytics'] != '' )
	echo stripslashes($data_extra_settings['wibiyaAnalytics'])."<br><br>";

echo stripslashes($data_name['googleAnalytics']);



echo "</body>";
echo "</html>";


$sql = "INSERT INTO statistic_site_users ( unk , url , from_url , ip , date ) VALUES (
'".UNK."' , '".$_SERVER[QUERY_STRING]."' , '".$_SERVER[HTTP_REFERER]."' , '".$_SERVER[REMOTE_ADDR]."' , NOW() )";
$res = mysql_db_query(DB, $sql);


$height_kobia = 0;
if( $data_name['have_ilbiz_net'] == "1" )
{
	$sql = "SELECT ncb.file_name,ncb.id FROM net_client_belong_banners as ncbb , net_clients_banners as ncb WHERE 
		ncbb.unk = '".UNK."' AND
		ncbb.banner_id=ncb.id AND
		ncb.deleted=0 AND
		ncb.type=1 AND
		ncb.status=1 ORDER BY position,RAND()";
	$res = mysql_db_query(DB,$sql);
	$banner_detail = mysql_fetch_array($res);
	
	if( $banner_detail['file_name'] != "" )
	{
		$banner_path = "/home/ilan123/domains/ilbiz.co.il/public_html/ClientSite/site_banners/net_banners/".$banner_detail['file_name']."";
		
		if( file_exists($banner_path) )
		{
			$im_size = GetImageSize ($banner_path); 
			$imageWidth = $im_size[0]; 
			$imageHeight = $im_size[1];
			
			$new_he = $imageHeight+10;
			$height_kobia += $new_he;
			
			$b1 = $banner_detail['id'];
			$cnu = "";
		}
	}
}

if( $data_name['have_ilbiz_adv_net'] == "1" )
{
	$sql = "SELECT ncb.file_name,ncb.id FROM net_client_belong_banners as ncbb , net_clients_banners as ncb WHERE 
		ncbb.unk = '".UNK."' AND
		ncbb.banner_id=ncb.id AND
		ncb.deleted=0 AND
		ncb.type=2 AND
		ncb.status=1 ORDER BY position,RAND()";
	$res = mysql_db_query(DB,$sql);
	$banner_detail2 = mysql_fetch_array($res);
	
	if( $banner_detail2['file_name'] != "" )
	{
		$banner_path = "/home/ilan123/domains/ilbiz.co.il/public_html/ClientSite/site_banners/net_banners/".$banner_detail2['file_name']."";
		
		if( file_exists($banner_path))
		{
			$im_size = GetImageSize ($banner_path); 
			$imageWidth = $im_size[0]; 
			$imageHeight = $im_size[1];
			
			$new_he = $imageHeight;
			$height_kobia += $new_he;
		}
	}
}

if( $height_kobia > 10 )
{
	echo "
	<script type=\"text/javascript\">var fullLink=\"unk=".UNK."&b1=".$b1."&cnu=".$cnu."&b2=".$banner_detail2['id']."\"; var banner_height = \"".$height_kobia."\";</script>
	<script type=\"text/javascript\" src=\"http://www.ilbiz.co.il/newsite/net_system/siteBanner.js\"></script>
	";
}

mysql_close($connect);
?>
