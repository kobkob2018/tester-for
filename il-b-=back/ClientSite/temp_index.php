<?php
/* 
* Copyright © 2006 ILbiz. All Rights Reserved
* email:	webmaster@ilbiz.co.il
*
* 
* the index of the client site
*/


//http://il.php.net/manual/en/ref.errorfunc.php#errorfunc.constants.errorlevels.e-warning
error_reporting( 0 );

ob_start();
session_start();

require('/home/ilan123/domains/ilbiz.co.il/public_html/global_func/vars.php');



if( isset($_POST['productIdToRemove']) && $_POST['spEvAR'] == "Linnrkd442" )
{
	$sql = "delete FROM chipHaariUsersImgs WHERE prId = '".$_POST['productIdToRemove']."' and ecomSesId = '".$_SESSION['ecom']['unickSES']."' limit 1";
	$res = mysql_db_query(DB,$sql);
	
	$sql = "delete FROM user_ecom_items WHERE product_id = '".$_POST['productIdToRemove']."' and client_unickSes = '".$_SESSION['ecom']['unickSES']."' limit 1";
	$res = mysql_db_query(DB,$sql);
	
	if( $res )
		echo "OK";
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




// E-COMERS ajax only 
if( isset($_POST['spEvAR']) )
{
	if( $_POST['spEvAR'] == "Linnrkd442" )
	{
		header('Content-Type: text/html; charset=windows-1255');  
		if(isset($_POST['productId']))
		{
			$sql = "insert into user_ecom_items (product_id,unk,client_unickSes) values ( '".$_POST['productId']."' , '".UNK."', '".$_SESSION['ecom']['unickSES']."' )";
			$res = mysql_db_query(DB,$sql);
			
			$sql = "select id,price,name from user_products where unk = '".UNK."' and deleted = '0' and active = '0' and id = '".$_POST['productId']."' limit 1";
			$res = mysql_db_query(DB,$sql);
			$data = mysql_fetch_array($res);
			
			echo $data['id']."|||".htmlspecialchars(stripslashes($data['name']))."|||".htmlspecialchars(stripslashes($data['price']));
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

$sql_lang = "select * from site_langs where id = '".$data_UserLang['lang_id']."'";
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
require("/home/ilan123/domains/ilbiz.co.il/public_html/ClientSite/client_castum_functions.php");



// for settigns about the colors
$sql = "select * from user_site_settings where unk = '".UNK."' and deleted = '0' and status = '0'";
$res_settings = mysql_db_query(DB,$sql);
$data_settings = mysql_fetch_array($res_settings);


$sql = "select * from user_extra_settings where unk = '".UNK."'";
$res_extra_settings = mysql_db_query(DB,$sql);
$data_extra_settings = mysql_fetch_array($res_extra_settings);

// for gernral data about the user
$sql = "select * from users where unk = '".UNK."' and deleted = '0' and status = '0'";
$res_name = mysql_db_query(DB,$sql);
$data_name = mysql_fetch_array($res_name);

if( empty($data_name['id']) )
	die("");

$with_out_RightMenu = 0;

// if user have homepage - then go to homepage, else - go to about page
if( $data_name['have_homepage'] == 1)
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


$table_border = ( $data_colors['border_color_active'] == 0 ) ? "class=\"site_border\"" : "";


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
	$site_title = ( $data_settings['site_title'] != "" ) ? stripslashes($data_settings['site_title']) : "";
	$addMoreTitle = ( !empty($addMoreTitle) ) ? $addMoreTitle.", ".$site_title : $site_title;
	
	

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
			$swf_top_slice = "
				<div id=\"LStop_slice\"></div>
				
				<script type=\"text/javascript\">
					loadSWF(\"/tamplate/".stripslashes($data_colors['top_slice'])."\",\"top_slice\",\"775\",\"".stripslashes($data_colors['top_slice_flash_height'])."\",\"#".stripslashes($data_colors['top_slice_flash_color'])."\",\"LStop_slice\");
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
	
	$img_g_site_bg = "";
	$abpath_temp_bll_all_site = SERVER_PATH."/tamplate/".stripslashes($data_colors['img_all_site_bg']);
	if( file_exists($abpath_temp_bll_all_site) && !is_dir($abpath_temp_bll_all_site) )
	{
		$img_g_site_bg_repeat = ( $data_colors['img_g_site_bg_repeat'] == "1" ) ? "background-repeat: no-repeat;" : "";
		$img_g_site_bg = "style=\"background: url(".HTTP_PATH."/tamplate/".stripslashes($data_colors['img_all_site_bg']).") scroll center; background-position: top; ".$img_g_site_bg_repeat."\" ";
	}
	
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
	else
	$text_area_bg = ( $img_bg_txt_area == "" ) ? $COLORconent_bg_color  : "background='".HTTP_PATH."/tamplate/".stripslashes($data_colors[$take_img_bg_txt])."'";
	
	
	
	$flash_right_menu = "";
	$right_menu_beckground = "";
	$abpath_temp_flash_right_menu = SERVER_PATH."/tamplate/".stripslashes($data_colors['flash_right_menu']);
	if( file_exists($abpath_temp_flash_right_menu) && !is_dir($abpath_temp_flash_right_menu) )
	{
		$flash_right_menu = "
			<div id=\"LSflash_right_menu\"></div>
				
				<script type=\"text/javascript\">
					loadSWF(\"/tamplate/".stripslashes($data_colors['flash_right_menu'])."\",\"flash_right_menu\",\"".stripslashes($data_colors['flash_right_menu_width'])."\",\"".stripslashes($data_colors['flash_right_menu_height'])."\",\"#".stripslashes($data_colors['flash_right_menu_color'])."\",\"LSflash_right_menu\");
				</script>";
	}
	else
	{
		$abpath_temp_right_menu_beckground = SERVER_PATH."/tamplate/".stripslashes($data_colors['right_menu_beckground']);
		if( file_exists($abpath_temp_right_menu_beckground) && !is_dir($abpath_temp_right_menu_beckground) )
		{
			$right_menu_beckground = "background=\"".HTTP_PATH."/tamplate/".stripslashes($data_colors['right_menu_beckground'])."\"";
		}
	}
	
	
	if( $data_name['have_ecom'] == "1" && $_SESSION['ecom']['active'] != "1" && $_SESSION['ecom']['unickSES'] == "" )
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
	
	
	
	###  define coin type in the site  ####
	switch( $data_words['coin_type'] )
	{
		case "0" :			$coin_type = "¤";					break;
		case "1" :			$coin_type = "$";									break;
		case "2" :			$coin_type = "&euro;";						break;
	}
	define('COIN',$coin_type);
?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Frameset//EN">
<html>
<head>
	
	<meta HTTP-EQUIV="Content-Type" CONTENT="text/html; charset=<?=$site_charset ?>" >
	<title><?=$addMoreTitle;?></title>
	
	<?
	if( $data_extra_settings['userCanSEO'] == "1" )
	{
		switch($m)
		{
			case "ar" :
				$sql = "SELECT summary FROM user_articels WHERE id='".$_GET['artd']."' AND unk='".UNK."' AND deleted=0";
				$res = mysql_db_query(DB,$sql);
				$data_summary = mysql_fetch_array($res);
				
				if( $data_summary['summary'] != "" )
					$description = str_replace("\"" , "" , stripslashes($data_summary['summary']) );
				else
					$description = str_replace("\"" , "" , stripslashes($data_settings['description']) );
				$keywords = str_replace("\"" , "" , stripslashes($data_settings['keywords']) );
			break;
			
			case "text" :
		 		$sql = "SELECT description,keywords FROM content_pages WHERE id='".$_GET['type']."' AND unk='".UNK."' AND deleted=0";
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
	
	?>
	
	
	
<?
// creat CSS file
echo generat_css_code();		
?>

<script type="text/javascript">
	function get_word_txt_totalPrice()
	{
		return "<?echo $word[LANG]['1_3_ecom_table_total']." "; ?>";
	}
	function get_word_COIN_type()
	{
		return "<?echo COIN; ?>";
	}
	function ajax_calendar(mons)
	{
		var url = "index.php?aJx=1&aM=calendar&mons="+mons;  
		new Ajax.Updater("user_calendar", url, {asynchronous:true});
	}
</script>


<script type="text/javascript" src="http://www.ilbiz.co.il/newsite/test/chromejs/chrome.js"></script>

<script type="text/javascript" src="http://www.ilbiz.co.il/global_func/prototype.js"></script>
<script type="text/javascript" src="http://www.ilbiz.co.il/ClientSite/js/ajax.js"></script>
<?
if( UNK == "038157696328808156" )
	echo '<script type="text/javascript" src="http://www.ilbiz.co.il/ClientSite/js/fly-to-basket-chip.haari.js"></script>';
else
	echo '<script type="text/javascript" src="http://www.ilbiz.co.il/ClientSite/js/fly-to-basket.js"></script>';
?>


<link rel="stylesheet" href="http://ilbiz.co.il/ClientSite/other/popup/dhtmlwindow.css" type="text/css">

<script type="text/javascript" src="http://ilbiz.co.il/ClientSite/other/popup/dhtmlwindow.js">
	/***********************************************
	* DHTML Window Widget- © Dynamic Drive (www.dynamicdrive.com)
	* This notice must stay intact for legal use.
	* Visit http://www.dynamicdrive.com/ for full source code
	***********************************************/
</script>

<?

	echo "<script type=\"text/javascript\" src=\"http://ilbiz.co.il/ClientSite/other/flash/swfobject.js\"></script>";
	echo "<script type=\"text/javascript\" src=\"http://ilbiz.co.il/ClientSite/other/flash/FABridge.js\"></script>";
	
if( $data_name['flex_gallery'] == "1" )
{
	switch( $data_name['flex_galleryType'] )
	{
		case "2" :
			echo "
				<script type=\"text/javascript\">
				// <![CDATA[
				function loadGallery(params){
					var galleryDiv = document.getElementById(params.parentName);
					if (galleryDiv.firstChild){
						var flexApp = FABridge.flash.root();
						flexApp.setCat(params.cat);
		   			} else {
						var so = new SWFObject(\"images.swf\", \"gallery\", \"600\", \"600\", \"9\",\"#FFFFFF\");
						so.addVariable(\"unk\", params.unk); 
						so.addVariable(\"cat\", params.cat); 
						so.addVariable(\"url\", params.url); 
						so.addParam(\"wmode\", \"transparent\"); 
						so.addParam(\"allowScriptAccess\", \"always\");
						//so.useExpressInstall('http://ilbiz.co.il/ClientSite/other/flash/expressinstall.swf');
						so.write(params.parentName);	
					}	
				}
				// ]]>
			</script>";
		break;
		
		case "5" :
		case "4" :
			switch(UNK)
			{
				case "235414525040051953" :
				case "438418905102508493" : 	$choosen_swf_name = "shelf.swf";			break;
				
				default:
					$choosen_swf_name = "images.swf";
			}
			echo "
				<script type=\"text/javascript\">
				// <![CDATA[
				function loadGallery(unk,url,cat,parentName){
						var so = new SWFObject(\"".$choosen_swf_name."\", \"gallery\", \"600\", \"600\", \"9\",\"#FFFFFF\");
						so.addVariable(\"unk\", unk); 
						so.addVariable(\"url\", url);
						so.addVariable(\"cat\", cat);  
						so.addParam(\"wmode\", \"transparent\"); 
						so.addParam(\"allowScriptAccess\", \"always\");
						//so.useExpressInstall('http://ilbiz.co.il/ClientSite/other/flash/expressinstall.swf');
						so.write(parentName);	
				}
				// ]]>
			</script>";
		break;
		
		default :
			echo "
				<script type=\"text/javascript\">
				// <![CDATA[
				function loadFlexGallery(unk,cat,url,parentName){
					var galleryDiv = document.getElementById(parentName);
					if (galleryDiv.firstChild){
						var flexApp = FABridge.flash.root();
						flexApp.setGallery(unk,url);
		   			} else {
						var so = new SWFObject(\"images.swf\", \"images\", \"600\", \"600\", \"9\",\"#FFFFFF\");
						so.addVariable(\"unk\", unk); 
						so.addVariable(\"url\", url); 
						so.addVariable(\"cat\", cat); 
						so.addParam(\"wmode\", \"transparent\"); 
						so.addParam(\"allowScriptAccess\", \"always\");
						//so.useExpressInstall('http://ilbiz.co.il/ClientSite/other/flash/expressinstall.swf');
						so.write(parentName);	
					}	
				}
				// ]]>
			</script>";
	}
	
}

if( UNK == "932085872939085012" )
{
		echo "
			<script type=\"text/javascript\">
				// <![CDATA[
				function loadHPnews(unk,url,parentName){
						var so = new SWFObject(\"/upload_pics/news.swf\", \"gallery\", \"501\", \"315\", \"9\",\"#FFFFFF\");
						so.addVariable(\"unk\", unk); 
						so.addVariable(\"url\", url);
						so.addParam(\"wmode\", \"transparent\"); 
						//so.useExpressInstall('http://ilbiz.co.il/ClientSite/other/flash/expressinstall.swf');
						so.write(parentName);	
				}
				// ]]>
			</script>";
}

?>

	<script type="text/javascript">
		function addIEFavorite() 
		{
		   if (window.external) 
			 {
		      external.AddFavorite(location.href, window.document.title)
		      }
		   else 
			 {
		      alert("Oops, your browser doesn't support this feature.\n" +
		      "If you are using Netscape Navigator, click Bookmarks\n" +
		      "and then Add Bookmark to add this site to your favorites.");
		      }
		}
		
		function loadSWF(swf,name,width,height,bgColor,parentName)
		{
			var so = new SWFObject(swf, name, width, height, "9",bgColor);
			if( bgColor.length == 1 )
				so.addParam("wmode", "transparent"); 
				//so.addParam("allowScriptAccess", "always");
				//so.addParam("base", "$data_domain['domain'];");
			//so.useExpressInstall('http://ilbiz.co.il/ClientSite/other/flash/expressinstall.swf');
			so.write(parentName);		
		}
		
		function loadSWFwithBase(swf,name,width,height,bgColor,parentName)
		{
			var so = new SWFObject(swf, name, width, height, "9",bgColor);
			if( bgColor.length == 1 )
				so.addParam("wmode", "transparent"); 
				so.addParam("allowScriptAccess", "always");
				so.addParam("base", "$data_domain['domain'];");
			//so.useExpressInstall('http://ilbiz.co.il/ClientSite/other/flash/expressinstall.swf');
			so.write(parentName);		
		}
		
		
		function added_to_cart()
		{
			return "<b><u><?=$word[LANG]['1_2_ecom_added_to_cart'];?></u></b>";
		}
		
		function AfterAddedToCart( productId )
		{
			<?
			$abpath_temp = SERVER_PATH."/tamplate/".stripslashes($data_extra_settings['cartAddImg']);
			if( file_exists($abpath_temp) && !is_dir($abpath_temp) )
			{
			?>
				return "<div id='addToBasketButton" + productId + "'><a href='javascript:void(0)' onclick=\"addToBasket(" + productId + ");return false\"><img src='/tamplate/<?=stripslashes($data_extra_settings['cartAddImg']);?>' border=\"0\" alt=\"\" /></a></div>";
			<?
			}
			else
			{
			?>
				return "<div id='addToBasketButton" + productId + "'><a href='javascript:void(0)' onclick=\"addToBasket(" + productId + ");return false\"><?=$word[LANG]['1_1_products_add_to_cart'];?></a></div>";
			<?
			}
			?>
		}
		
				
	</script>
</head>

<?
$COLORconent_bg_color = ( !empty($data_colors['conent_bg_color']) ) ? "bgcolor=\"#".$data_colors['conent_bg_color']."\"" : "";
$COLORsite_bg_color = ( !empty($data_colors['site_bg_color']) ) ? "bgcolor=\"#".$data_colors['site_bg_color']."\"" : "";
$COLORmenus_color = ( !empty($data_colors['menus_color']) ) ? "bgcolor=\"#".$data_colors['menus_color']."\"" : "";
$COLORimg_bg_txt_area_bottom_color = ( !empty($data_colors['img_bg_txt_area_bottom_color']) ) ? "bgcolor=\"#".$data_colors['img_bg_txt_area_bottom_color']."\"" : "";

?>

<body <?echo $img_g_site_bg;?> <?echo $COLORsite_bg_color;?> leftmargin=0 topmargin=0 rightmargin=0 bottommargin=0 marginwidth=0 marginheight=0>

<?

echo "<table border=\"0\" cellspacing=\"0\" cellpadding=\"0\" align=\"center\" dir=\"".$settings['dir']."\" width=\"775\" ".$table_border.">";
	
	if( !(UNK == "932085872939085012" && $m == "hp") )
	{
		if( $data_extra_settings['have_topSliceHtml'] == "1" && $data_extra_settings['topSliceHtml'] != "" )
		{
			echo "<tr>";
				echo "<td>".stripslashes($data_extra_settings['topSliceHtml'])."</td>";
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
								
									if( $data_name['have_add_favi'] == "1" )
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
										echo "<td colspan=\"3\" align='center'>";
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
										echo "<td colspan=\"3\" align='center'>";
											echo search_form();
										echo "</td>";
									echo "</tr>";
									}
									
									if( $data_name['scrollNewsOrder'] == "1" )
									{
										echo "<tr><TD height=\"5\" colspan=\"3\"></TD></tr>";
										echo "<TR>";
											echo "<TD colspan=\"3\" align=center>";
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
											echo "<TD colspan=\"3\" align=center>";
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
								
									if( $data_name['have_add_favi'] == "1" )
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
										echo "<td colspan=\"3\" align='center'>";
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
										echo "<td colspan=\"3\" align='center'>";
											echo search_form();
										echo "</td>";
									echo "</tr>";
									}
									
									if( $data_name['scrollNewsOrder'] == "1" )
									{
										echo "<tr><TD height=\"5\" colspan=\"3\"></TD></tr>";
										echo "<TR>";
											echo "<TD colspan=\"3\" align=center>";
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
											echo "<TD colspan=\"3\" align=center>";
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
									
									?>
									
								</table>
							</td>
							<?
						}
						$width_content = "625";
					}
					else
						$width_content = "775";
					?>
					<td width="<?=$width_content;?>" <?=$text_area_bg;?> valign="top">
						<table border="0" cellspacing="0" cellpadding="0">
							<?php
							
							if( $data_name['have_topmenu'] == 1 )
							{
								topMenu__chromemenu();
							}
							
							
							if( $data_name['have_headline'] == "0" )
							{
								continer__headline();
							}
							else
							{
								echo "<tr><td colspan=\"3\" height=\"10\"></td></tr>";
							}
							
							
							if( $data_name['have_rightmenu'] != "0" && $m != "hp" )
							{
								if( UNK != "932085872939085012" )
								{
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
							?>
							<tr>
								<td width="35"></td>
								<td class="maintext" valign="top" height='600' width="555">
									<?echo get_content($m);?>
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
	
	$abpath_temp = SERVER_PATH."/tamplate/".stripslashes($data_colors['img_bg_txt_area_bottom']);
	if( file_exists($abpath_temp) && !is_dir($abpath_temp) )	{ 
		$temp_test = explode( "." , $data_colors['img_bg_txt_area_bottom'] );
		
		if( $temp_test[1] == "swf" )
		{
			echo "<tr>";
				echo "<td valign=bottom align=\"". $settings['re_align'] ."\" ".$COLORimg_bg_txt_area_bottom_color.">";
					echo "<div id=\"LSimg_bg_txt_area_bottom\"></div>
					<script type=\"text/javascript\">
						loadSWF(\"/tamplate/".stripslashes($data_colors['img_bg_txt_area_bottom'])."\",\"img_bg_txt_area_bottom\",\"".stripslashes($data_colors['img_bg_txt_area_bottom_width'])."\",\"".stripslashes($data_colors['img_bg_txt_area_bottom_height'])."\",\"#".stripslashes($data_colors['img_bg_txt_area_bottom_color'])."\",\"LSimg_bg_txt_area_bottom\");
					</script>";
				echo "</td>";
			echo "</tr>";
		}
		else
		{
			echo "<tr>";
				echo "<td valign=bottom align=\"". $settings['re_align'] ."\" ".$COLORmenus_color.">";
					echo "<img src=\"".HTTP_PATH."/tamplate/".stripslashes($data_colors['img_bg_txt_area_bottom'])."\" border=\"0\" alt=\"\" />";
				echo "</td>";
			echo "</tr>";
			
			//echo "<tr><td height=\"\"></td></tr>";
		}
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


?>
