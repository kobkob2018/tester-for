<?php
	//error_reporting(E_ALL);
	//ini_set("display_errors", 1);
	if(isset($_GET['clearses'])){
		foreach($_SESSION as $key=>$val){
			echo "v1-".$key.",";
			if($_GET['clearses'] == '1'){
				unset($_SESSION[$key]);
			}
		}
		exit("session is clear");
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

	require_once('/home/ilan123/domains/ilbiz.co.il/public_html/lang/lang.'.$lang_page_name.'.php');

	// class
	require_once("/home/ilan123/domains/ilbiz.co.il/public_html/global_func/DB.php");
	require_once("/home/ilan123/domains/ilbiz.co.il/public_html/global_func/global_functions.php");
	require_once("/home/ilan123/domains/ilbiz.co.il/public_html/global_func/forms_creator.php");
	require_once("/home/ilan123/domains/ilbiz.co.il/public_html/global_func/images_resize.php");
	require_once("/home/ilan123/domains/ilbiz.co.il/public_html/global_func/class.phpmailer.php");

	require_once("/home/ilan123/domains/ilbiz.co.il/public_html/global_func/classes/class.ilbiz_net.php");


	require_once('functions/functions.php');
	require_once("functions/strac_func.php");
	require_once('functions/userStatView.php');
	require_once("/home/ilan123/domains/ilbiz.co.il/public_html/ClientSite/functions_08.php");
	require_once("functions/functions_09.php");
	require_once("/home/ilan123/domains/ilbiz.co.il/public_html/ClientSite/functions_10.php");
	require_once("functions/client_castum_functions.php");
	require_once("/home/ilan123/domains/ilbiz.co.il/public_html/ClientSite/client_castum_functions2.php");
	require_once("/home/ilan123/domains/ilbiz.co.il/public_html/ClientSite/castum_functions.php");
	require_once("functions/functions_12.php");
	require_once("/home/ilan123/domains/ilbiz.co.il/public_html/ClientSite/functions_14.php");
	require_once("functions/modules.php");
	require_once("functions/sidebars.php");
	require_once("functions/modules/products.php");
	require_once("functions/modules/video.php");
	require_once("functions/net_user.php");
	require_once("functions/modules/header_functions.php");

	###  define coin type in the site  ####
	$coin_type = "₪";
	define('COIN',$coin_type);




	require_once("functions/facebook-php-sdk/src/facebook.php");

	$facebook = new Facebook(array(
	  'appId'  => '374144012621766',
	  'secret' => 'eac5525200a0ede67595c01c3c052e0e',
	));

	setup_t_for_friendly_page_url();

	$browser_is_mobile =  preg_match("/(android|avantgo|blackberry|bolt|boost|cricket|docomo|fone|hiptop|mini|mobi|palm|phone|pie|tablet|up\.browser|up\.link|webos|wos)/i", $_SERVER["HTTP_USER_AGENT"]);
	if(isset($_GET['be_mobile'])){
		$browser_is_mobile =  true;
	}
	$browser_is_mobile_str = "false";
	if($browser_is_mobile){
		$browser_is_mobile_str = "true";
	}
	$body_mobile_class = "desktop_body";

	if($browser_is_mobile){
		$body_mobile_class = "mobile_body";
	}
	if(isset($_SESSION['gl_source'])){
		if($_SESSION['gl_source']['gclid'] == "kobibodek"){
			//exit("kobibodek");
		}
		$gl_source = $_SESSION['gl_source'];
	}
	else{
		$gl_source = array(
			'entry_row'=>'0',
			'gclid'=>'0',
			'sites_page_id'=>'0',
			'has_gclid'=>'0',
			'is_mobile'=>'0',
		);
	}
	if(isset($_GET['gclid'])){
		if($_GET['gclid'] != $gl_source['gclid']){
			$gl_source['gclid'] = $_GET['gclid'];
			$gl_source['has_gclid'] = '1';
			$gl_source['entry_row'] = '0';
		}
	}
	if(isset($_GET['fblid'])){
		if($_GET['fblid'] != $gl_source['gclid']){
			$gl_source['gclid'] = $_GET['fblid'];
			$gl_source['has_gclid'] = '2';
			$gl_source['entry_row'] = '0';
		}
	}
	if($browser_is_mobile){
		$gl_source['is_mobile'] = '1';
	}
	$_SESSION['gl_source'] = $gl_source;
	// LANG select
	$main_settings_sql = "SELECT * FROM main_settings WHERE id = 1";
	$main_settings_res = mysql_db_query(DB,$main_settings_sql);
	$main_settings_data = mysql_fetch_array($main_settings_res);

	$cache_version = "5.4";
	if($main_settings_data['cache_version'] != ""){
		$cache_version =$main_settings_data['cache_version'];
	}

	// session for estimate stats
	if( $_SESSION['estimate_stats_referer'] == "" )
	{
		$_SESSION['estimate_stats_referer'] = ( isset($_SERVER['HTTP_REFERER']) ) ? $_SERVER['HTTP_REFERER'] : "";
	}
	$_SESSION['estimate_stats___current_referer'] = ( isset($_SERVER['HTTP_REFERER']) ) ? $_SERVER['HTTP_REFERER'] : "";
	$_SESSION['estimate_stats___agent'] = ( isset($_SERVER['HTTP_USER_AGENT']) ) ? $_SERVER['HTTP_USER_AGENT'] : "";

	//func found at client_custom_functions.php only for specific UNK..
	$domain_sql = "SELECT domain FROM users WHERE unk = '".UNK."'";
	$domain_res = mysql_db_query(DB,$domain_sql);
	$domain_data = mysql_fetch_array($domain_res);
	$site_domain = $domain_data['domain'];
	check_if_is_site_by_unk_need_do_301();
	check_if_item_need_do_301();

	if( $_GET['m'] == "text" )
	{
		$sql = "SELECT redierct_301 FROM content_pages WHERE unk = '".UNK."' AND type = '".$_GET['t']."' ";
		$resR301 = mysql_db_query(DB,$sql);
		$dataR301 = mysql_fetch_array($resR301);
		
		if( $dataR301['redierct_301'] != "" )
		{
			$redirect_url = $dataR301['redierct_301'];
			if(preg_match('/'.$site_domain.'/',$redirect_url)){
				$redirect_url = str_replace("http://",HTTP_S."://",$redirect_url);
			}		
			header( "HTTP/1.1 301 Moved Permanently" );
			header( "location: ".stripslashes($redirect_url)."" ); 
		}
	}


	// for settigns about the colors
	$sql = "select * from user_site_settings where unk = '".UNK."' and deleted = '0' and status = '0'";
	$res_settings = mysql_db_query(DB,$sql);
	$data_settings = mysql_fetch_array($res_settings);


	$sql = "SELECT * FROM user_extra_settings where unk = '".UNK."'";
	$res_extra_settings = mysql_db_query(DB,$sql);
	$data_extra_settings = mysql_fetch_array($res_extra_settings);


	if(eregi( "www." , $_SERVER['HTTP_HOST'] ) )
	{
			$new_url = str_replace("www.","",$_SERVER['HTTP_HOST']);
			$redirect_url = "http://".$new_url.$_SERVER['REQUEST_URI'];
			header("HTTP/1.1 301 Moved Permanently");
			header("Location: ".$redirect_url);
			exit;
		
	}


	if( $data_extra_settings['estimateSite'] == "1" && $_POST['m'] != "insert_contact" )
	{
		if( !eregi( "www." , $_SERVER['HTTP_HOST'] ) )
		{
			/*
			$temp_xp = explode( "." , $_SERVER['HTTP_HOST'] );
			if( count($temp_xp) < 3  )
			{
				
				header("HTTP/1.1 301 Moved Permanently");
				if( $_SERVER['QUERY_STRING'] != "" )	$query_sting = $_SERVER['SCRIPT_NAME']."?".$_SERVER['QUERY_STRING'];
				header("Location: http://www.".$_SERVER['HTTP_HOST'].$query_sting);
					exit;
			}
			*/
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


	if( $data_extra_settings['domainGoto10serviceMinisite'] == "1" )
	{
		$sql = "SELECT page_id FROM suppliers_10service WHERE user_id = '".$data_name['id']."' ";
		$res_goto = mysql_db_query(DB,$sql);
		$data_goto = mysql_fetch_array($res_goto);
		
		if( $data_goto['page_id'] != "0" || $data_goto['page_id'] != "" )
		{
			header( 'location:http://www.10service.co.il/index.php?m=text&t=' . $data_goto['page_id'] );
				exit;
		}
	}

	$with_out_RightMenu = 0;

	// all color on the page
	$sql = "select * from user_colors_set where unk = '".UNK."'";
	$res_colors = mysql_db_query(DB,$sql);
	$data_colors = mysql_fetch_array($res_colors);

	if( $data_extra_settings['haveLandingPage'] == 1 && $um == "" && $data_colors['home_portal_version'] != '1')
	{ 
		
		if($data_extra_settings['products_version']== '1'){
			
			require_once('functions/version_1_landing.php'); 
			
		}
		else{	
			//header("location:landing.php");
			require_once('functions/landing.php');
			
		}
		die;
	}
	elseif( $data_extra_settings['indexSite'] == "1")
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


	$pre_type = $_GET['t'];
	if($m == "hp" && $pre_type == ""){
		$pre_type = "text";
	}
	$pre_data_estimate = get_data_estimate($pre_type);
	$videoPic = $pre_data_estimate['videoPic'];
	$abpath_temp = SERVER_PATH."/new_images/";
	$og_image = false;
	if( file_exists($abpath_temp.$videoPic) && !is_dir($abpath_temp.$videoPic) ){
		$og_image = HTTP_S."://".$_SERVER['HTTP_HOST']."/new_images/".$videoPic;
	}

	$table_border = ( $data_colors['border_color_active'] == 0 && $data_extra_settings['estimateSite'] != "1" ) ? "class=\"site_border\"" : "";


	// get the name of the pages - empty name => not exits in the list
		
	$sql = "select * from user_words where unk = '".UNK."'";
	$res_words = mysql_db_query(DB,$sql);
	$data_words = mysql_fetch_array($res_words);
	
	$temp_word_hp = $word[LANG]['1_2_chapter_name_hp'];
	$temp_word_about_title = ( $data_words['id'] == "" ) ? "" : stripslashes($data_words['word_about_title']);
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
	
	$blue_title = "";
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
		"hp" => $temp_word_about,
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
		if( $imageWidth < '140' )
			$imageWidth = "140"; 
		else
			$imageWidth = $im_size[0]; 
		$imageHeight = $im_size[1];
		
		$new_esek_name = str_replace('"' , '' , stripslashes($data_name['name']));
		
		if( is_file(SERVER_PATH.'/image.php') && !is_dir(SERVER_PATH.'/image.php')  && false){
			$img_logo = "<img src=\"image.php?image=/tamplate/".stripslashes($data_settings['logo'])."\" border=\"0\" alt=\"".$new_esek_name."\" />";
			$site_logo = "<img src=\"image.php?image=/tamplate/".stripslashes($data_settings['logo'])."\" border=\"0\" alt=\"".$new_esek_name."\" />";
			$site_logo_url = "image.php?image=/tamplate/".stripslashes($data_settings['logo']);
		}
		else{
			$img_logo = "<img src=\"".HTTP_PATH."/tamplate/".stripslashes($data_settings['logo'])."\" width=\"".$imageWidth."\" border=\"0\" alt=\"".$new_esek_name."\" />";
			$site_logo = "<img src=\"".HTTP_PATH."/tamplate/".stripslashes($data_settings['logo'])."\" width=\"".$imageWidth."\" border=\"0\" alt=\"".$new_esek_name."\" />";
			$site_logo_url = HTTP_PATH."/tamplate/".stripslashes($data_settings['logo']);
		}
		if( is_file(SERVER_PATH.'/image.php') && !is_dir(SERVER_PATH.'/image.php') && false ){
			$img_mobile_logo = "<img src=\"image.php?image=/tamplate/".stripslashes($data_settings['mobile_logo'])."\" border=\"0\" alt=\"".$new_esek_name."\" />";
			$site_mobile_logo = "<img src=\"image.php?image=/tamplate/".stripslashes($data_settings['mobile_logo'])."\" border=\"0\" alt=\"".$new_esek_name."\" />";
			$site_mobile_logo_url = "image.php?image=/tamplate/".stripslashes($data_settings['mobile_logo']);
		}
		else{
			$img_mobile_logo = "<img src=\"".HTTP_PATH."/tamplate/".stripslashes($data_settings['mobile_logo'])."\" width=\"".$imageWidth."\" border=\"0\" alt=\"".$new_esek_name."\" />";
			$site_mobile_logo = "<img src=\"".HTTP_PATH."/tamplate/".stripslashes($data_settings['mobile_logo'])."\" width=\"".$imageWidth."\" border=\"0\" alt=\"".$new_esek_name."\" />";
			$site_mobile_logo_url = HTTP_PATH."/tamplate/".stripslashes($data_settings['mobile_logo']);
		}		
	}
	
	
	$abpath_temp2 = SERVER_PATH."/tamplate/".stripslashes($data_colors['top_slice']);
		
	if( file_exists($abpath_temp2) && !is_dir($abpath_temp2) )	{
		$temp_test = explode( "." , $data_colors['top_slice'] );
		$im_size = GetImageSize ($abpath_temp2); 
		$imageWidth = $im_size[0]; 
		$imageHeight = $im_size[1];
		
		$img_top_slice_style = "background-image: url('".HTTP_PATH."/tamplate/".stripslashes($data_colors['top_slice'])."');";
		
	}
	else 
		$img_top_slice_style = "";
	
	
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

		require_once ('zoomFiles/axZm/zoomInc.inc.php');
	}
	$nice_header = 0;
	$nice_header_type = 0;
	$has_nice_header = false;
	$no_nice_header = true;
	$custom_header = $data_extra_settings['head_free_html'];
	$has_custom_header = false;
	$no_custom_header = true;	
	if($custom_header != ""){
		$has_custom_header = true;
		$no_custom_header = false;
	}	
	if($m == "text" || $m == "hp"){
		$page_type = "text";
		if(isset($_GET['t'])){
			$page_type = $_GET['t'];
			$sql = "SELECT type,ld_page_add FROM content_pages WHERE id='".ifint($page_type)."' AND unk='".UNK."' AND deleted=0";
		}
		else{
			$sql = "SELECT type,ld_page_add FROM content_pages WHERE type='text' AND unk='".UNK."' AND deleted=0";
		}
		$res = mysql_db_query(DB,$sql);
		$data_ld = mysql_fetch_array($res);	
		if($data_ld['ld_page_add'] != "" && $data_ld['ld_page_add'] != "0"){
			$has_nice_header = true;
			$no_nice_header = false;
			$nice_header = $data_ld['ld_page_add'];
			$nice_header_type = $data_ld['type'];
		}
	}		
	$net_banner_for_content = "";

//if( $_SERVER[REMOTE_ADDR] == "84.228.118.133" )

ob_start();
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
	<head>
		<?php if (strpos($_SERVER['HTTP_USER_AGENT'],'WhatsApp') === false): ?>
			<meta HTTP-EQUIV="Content-Type" CONTENT="text/html; charset=<?php echo $site_charset?>">
		<?php endif; ?>
		<?php if(isset($_GET['ftype'])): if($_GET['ftype']=='furl'): //friendly urls in .htaccess ?>
			<BASE href="<?php echo HTTP_PATH; ?>/">
		<?php endif; endif; ?>
		<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1" />
		<?php if($og_image): ?>
			<meta property="og:image" content="<?php echo $og_image; ?>" />
		<?php endif; ?>
<?php	
	$page_title = '';
	if( $data_extra_settings['indexSite'] == "1" )
	{
		$headlinesTitle = "";
		switch( $m )
		{
			case "KgBm" :	
				$headlinesTitleC = "";
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
				
				if ( ifint($_GET['city']) != "" && ifint($_GET['city']) != "0" )
				{
					$sql = "SELECT city_name FROM user_guide_cities WHERE id = '".ifint($_GET['city'])."'";
					$res_c = mysql_db_query(DB, $sql);
					$data_c = mysql_fetch_array($res_c);
					
					$headlinesTitleC = stripslashes($data_c['city_name']).", ";
				}
				
				if( $headlinesTitle == '' )
					$headlinesTitle = $headlinesTitleC . indexSite__global_settings("headTitle1");
				else
					$headlinesTitle .= $headlinesTitleC;
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
		if($m == "hp"){
				$headlinesTitle = "---".$temp_word_about_title;
		}
		if( $headlinesTitle != '' )
			$page_title = substr($headlinesTitle , 0 , -2 );
		else
			$page_title = $addMoreTitle;
		
	}
	else{
		if($m == "hp"){
			$page_title = $temp_word_about_title;
		}
		else{
			$page_title = $addMoreTitle;
		}
	}
	if (strpos($_SERVER['HTTP_USER_AGENT'],'WhatsApp') !== false){
		$page_title = iconv("windows-1255","UTF-8", $page_title);
		echo '<meta property="og:title" content="'.$page_title.'" />';	
		echo '<title>'.$page_title.'</title>';		
		echo '</head><body></body></html>';
		exit;
	}
	$put_no_index = false;
	if($m == "s_products" || $m == "s.pr"){
		if(isset($_GET['ud'])){
			$product_sql = "select id from user_products where unk = '".UNK."' and deleted = '0' and active = '0' and id = '".ifint($_GET['ud'])."' limit 1";
			$product_res = mysql_db_query(DB,$product_sql);
			$product_data = mysql_fetch_array($product_res);
			if($product_data['id'] == ""){
				$put_no_index = true;
			}
		}
	}	
	echo '<title>'.$page_title.'</title>';
	$fb_audience_code = "";
	$gl_faq_code = "";
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
		 		$sql = "SELECT description,keywords,fb_audience_code,gl_faq_code FROM content_pages WHERE id='".ifint($type)."' AND unk='".UNK."' AND deleted=0";
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
				
				if( $data_content['fb_audience_code'] != "" )
					$fb_audience_code = $data_content['fb_audience_code'];
				
				if( $data_content['gl_faq_code'] != "" )
					$gl_faq_code = $data_content['gl_faq_code'];

				
				
			break;
			
			default:
				if($m == 'hp'){
					$keywords = str_replace("\"" , "" , stripslashes($data_settings['keywords']) );
					$description = str_replace("\"" , "" , stripslashes($data_settings['description']) );
					$sql = "SELECT description,keywords,fb_audience_code, gl_faq_code FROM content_pages WHERE type='text' AND unk='".UNK."' AND deleted=0";
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
					
					if( $data_content['fb_audience_code'] != "" )
						$fb_audience_code = $data_content['fb_audience_code'];		
					
					if( $data_content['gl_faq_code'] != "" )
						$gl_faq_code = $data_content['gl_faq_code'];		
				}

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
		
	if( $_GET['t'] == "23021" )
		echo '<META NAME="ROBOTS" CONTENT="NOINDEX, NOFOLLOW">';
	if($put_no_index){
		echo '<META NAME="ROBOTS" CONTENT="NOINDEX, NOFOLLOW">';
	}	
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
	
	?>
	
	
<?php /* use param csh to update style.php cash */ ?> 	
<link rel="stylesheet" type="text/css" media="screen" href="/style.php?v=1&m=<?=$m;?>&csh=<?php echo $cache_version; ?>" />
<link rel="stylesheet" href="<?php echo HTTP_S; ?>://ilbiz.co.il/ClientSite/other/popup/dhtmlwindow.css" type="text/css" />

<script type="text/javascript" src="/script.php?m=<?=$m;?>"></script>

<script type="text/javascript" src="<?php echo HTTP_S; ?>://www.ilbiz.co.il/ClientSite/js/ajax.js"></script>
<script src="<?php echo HTTP_S; ?>://ilbiz.co.il/ClientSite/version_1/style/bootstrap_2.3.2/jquery.min.js"></script>
<script type="text/javascript">
	
	var browser_is_mobile = "<?php echo $browser_is_mobile_str; ?>";
	jQuery.noConflict();

</script>	

<script src="<?php echo HTTP_S; ?>://ilbiz.co.il/ClientSite/version_1/style/js/negishut.js"></script>

<script src="<?php echo HTTP_S; ?>://ilbiz.co.il/ClientSite/version_1/style/js/estimate_form.js?v=<?php echo $cache_version; ?>" type="text/javascript"></script>

<?
if( $_GET['m'] == "einYahav_price_page" || $_GET['m'] == "einYahav_login_page")
{
	echo '<link rel="stylesheet" href="'.HTTP_S.'://www.ilbiz.co.il/ClientSite/js/calendarview.css">';
	echo '<script type="text/javascript" src="'.HTTP_S.'://www.ilbiz.co.il/ClientSite/js/calendarview.js"></script>';
	
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



if( $data_name['flex_galleryType'] == "6" && HTTP_S != "https")
{
	echo '<script type="text/javascript" src="'.HTTP_S.'://www.ilbiz.co.il/ClientSite/js/scriptaculous.js?load=effects,builder"></script>';
	
	echo '<script type="text/javascript" src="'.HTTP_S.'://www.ilbiz.co.il/ClientSite/js/lightbox.php?lang='.LANG.'"></script>';
	echo '<link rel="stylesheet" href="'.HTTP_S.'://www.ilbiz.co.il/ClientSite/js/lightbox_css.php?lang='.LANG.'" type="text/css" media="screen">';
}

if( $m == "jo" || $m == "jobs" )
	echo '<script type="text/javascript" src="'.HTTP_S.'://www.ilbiz.co.il/ClientSite/js/catsScriptJobs.php?unk='.UNK.'&STcat='.$_GET['STcat'].'&Sspec='.$_GET['Sspec'].'"></script>';


	if( file_exists(SERVER_PATH."/favicon.ico") && !is_dir(SERVER_PATH."/favicon.ico") )
		echo '<link rel="shortcut icon" type="image/x-icon" href="/favicon.ico">';
?>



<?php echo $fb_audience_code; ?>

<?php echo $gl_faq_code; ?>

<script type="text/javascript" src="<?php echo HTTP_S; ?>://ilbiz.co.il/ClientSite/other/popup/dhtmlwindow.js"></script>

<script type="text/javascript" src="https://apis.google.com/js/plusone.js"  async defer>
  {lang: 'iw'}
</script>


<script type="text/javascript" src="<?php echo HTTP_S; ?>://ilbiz.co.il/ClientSite/other/flash/FABridge.js"></script>
	
	<?
		$sql = "select id from user_news where deleted = '0' and unk = '".UNK."' ORDER BY id DESC";
		$res = mysql_db_query(DB,$sql);
		$num_rows = mysql_num_rows($res);
		
		if( $num_rows > 0 )
			echo "<script type=\"text/javascript\" src=\"js.js\"></script>";
			
	if( $data_extra_settings['head_free_code'] != "" )
	{
		echo str_replace("´","'",stripslashes($data_extra_settings['head_free_code']));
	}
	
	?>
	<link rel="stylesheet" href="<?php echo HTTP_S; ?>://ilbiz.co.il/ClientSite/version_1/style/bootstrap_2.3.2/bootstrap.min.css" type="text/css">
	<link rel="stylesheet" href="<?php echo HTTP_S; ?>://ilbiz.co.il/ClientSite/version_1/style/bootstrap_2.3.2/bootstrap.rtl.css" type="text/css">
	
	<link rel="stylesheet" href="<?php echo HTTP_S; ?>://ilbiz.co.il/ClientSite/version_1/style/bootstrap_2.3.2/bootstrap-responsive.min.css" type="text/css">
	<link rel="stylesheet" href="<?php echo HTTP_S; ?>://ilbiz.co.il/ClientSite/version_1/style/bootstrap_2.3.2/bootstrap-responsive.rtl.css" type="text/css">
	<link rel="stylesheet" href="<?php echo HTTP_S; ?>://ilbiz.co.il/ClientSite/version_1/style/bootstrap_2.3.2/rtl-xtra.min.css" type="text/css">	
	<link rel="stylesheet" href="<?php echo HTTP_S; ?>://ilbiz.co.il/ClientSite/version_1/style/version_1.css?v=<?php echo $cache_version; ?>" type="text/css" />	
	<link rel="stylesheet" href="<?php echo HTTP_S; ?>://fonts.googleapis.com/css?family=Open+Sans:300italic,400italic,600italic,700italic,800italic,400,300,600,700,800&subset=latin,latin-ext" type="text/css" media="all" />
	<link rel="stylesheet" href="//fonts.googleapis.com/earlyaccess/alefhebrew.css" type="text/css" media="all" />
	<script type="text/javascript" src="<?php echo HTTP_S; ?>://www.ilbiz.co.il/ClientSite/version_1/style/js/stickybars.js"></script>	
	
</head>

<?
$COLORconent_bg_color = ( !empty($data_colors['conent_bg_color']) ) ? "style=\"background-color: #".$data_colors['conent_bg_color'].";\"" : "";
$COLORmenus_color = ( !empty($data_colors['menus_color']) ) ? "style=\"background-color: #".$data_colors['menus_color'].";\"" : "";
$top_bg_color_style = ( !empty($data_colors['menus_color']) ) ? "background-color: #".$data_colors['menus_color'].";" : "";

 
$top_bg_style = "style=\"".$img_top_slice_style.$top_bg_color_style."\"";

$COLORimg_bg_txt_area_bottom_color = ( !empty($data_colors['img_bg_txt_area_bottom_color']) ) ? "bgcolor=\"#".$data_colors['img_bg_txt_area_bottom_color']."\"" : "";
$estimate_form_displayed = false;
$right_menu_html = "";
?>

<body class="<?php echo $body_mobile_class; ?>">


	<div id="fb-root"></div>
	<script>(function(d, s, id) {
	  var js, fjs = d.getElementsByTagName(s)[0];
	  if (d.getElementById(id)) return;
	  js = d.createElement(s); js.id = id;
	  js.src = "//connect.facebook.net/he_IL/sdk.js#xfbml=1&version=v2.5";
	  fjs.parentNode.insertBefore(js, fjs);
	}(document, 'script', 'facebook-jssdk'));</script>

	<?php if($_GET['m'] == 'logOut'): ?>
		<?php marketing_partners_logout(); ?>
	<?php endif; ?>
	<?php 
		global $m;
		$type = $_GET['t'];
		if($m == "hp" && $type == ""){
			$type = "text";
		}
		ob_start();
		$user_ip = $_SERVER[REMOTE_ADDR];

		$estimate_form_data = estimate_form_html($_GET['t']);
		$c_tracking_on = false;
		$c_track_sql = "SELECT c_tracking_on from main_settings";
		$c_track_res = mysql_db_query(DB,$c_track_sql);
		$c_track_data = mysql_fetch_array($c_track_res);
		if($c_track_data['c_tracking_on'] == '1'){
			$c_tracking_on = true;
		}
		if($c_tracking_on){
			$tmp = time();
			$tracking_id = $user_ip.$tmp;
			$tracking_id = str_replace(".","",$tracking_id);
			
			$tracking_arr = array("unk"=>UNK,"cat_f"=>'0',"cat_s"=>'0',"cat_spec"=>'0',"page_id"=>$estimate_form_data['page_data']['id'],"page_type"=>'1',"page_m"=>$m,"ip"=>$user_ip,'gclid'=>$gl_source['gclid'],'has_gclid'=>$gl_source['has_gclid'],'is_mobile'=>$gl_source['is_mobile'],"uniq_track"=>$tracking_id,"s_term"=>"");
			if($estimate_form_data['page_data']['type'] == 'text' && $m == 'text'){
				$tracking_arr['page_type'] = '0';
			}
			if(isset($estimate_form_data['form_data'])){
				$tracking_form_data = $estimate_form_data['form_data'];
				if(isset($tracking_form_data['primeryCat'])){
					$tracking_arr['cat_f'] = $tracking_form_data['primeryCat'];
				}
				if(isset($tracking_form_data['subCat'])){
					$tracking_arr['cat_s'] = $tracking_form_data['subCat'];
				}
				if(isset($tracking_form_data['cat_spec'])){
					$tracking_arr['cat_spec'] = $tracking_form_data['cat_spec'];
				}			
			}
			if($m == "search" && $_REQUEST['search_val'] != ''){
				$tracking_arr['s_term'] = $_REQUEST['search_val'];
			}
			$tracking_url_q = "t=1"; 
			foreach($tracking_arr as $key=>$val){
				$tracking_url_q.="&$key=$val";
			}
			$tracking_url = "https://ilbiz.co.il/c_tracking/?".$tracking_url_q;
			$form_tracking_url = $tracking_url."&f_sent=1";
		}
		
		$estimate_form_state = $estimate_form_data['form_on'];
		$estimate_form_print =  ob_get_clean();	
		$campaign_type = '0';
		if($gl_source['has_gclid'] != '0'){
			$campaign_type = $gl_source['has_gclid'];
		}	
		if($main_settings_data['show_phone_bar'] == '2'){
			if($estimate_form_data['form_data']['cat_spec'] == '0' && $estimate_form_data['form_data']['subCat'] == '0' && $estimate_form_data['form_data']['primeryCat'] == '0'){
				$data_name['phone_to_show'] = $data_name['phone'];
				if($campaign_type == '1'){
					if( $data_name['gl_campaign_phone'] != ""){
						$data_name['phone_to_show'] = $data_name['gl_campaign_phone'];
					}
				}
				if($campaign_type == '2'){
					if( $data_name['fb_campaign_phone'] != ""){
						$data_name['phone_to_show'] = $data_name['fb_campaign_phone'];
					}
				}			
			}
			else{
				$data_name['phone_to_show'] = $estimate_form_data['cat_phone'];
				if($campaign_type == '1'){
					if( $estimate_form_data['gl_campaign_phone'] != ""){
						$data_name['phone_to_show'] = $estimate_form_data['gl_campaign_phone'];
					}
				}
				if($campaign_type == '2'){
					if( $estimate_form_data['fb_campaign_phone'] != ""){
						$data_name['phone_to_show'] = $estimate_form_data['fb_campaign_phone'];
					}
				}				
			}
		}
		else{
			$data_name['phone_to_show'] = $data_name['phone'];
		}
		$show_phone = ($data_name['have_top_address'] == "0" && $data_name['phone_to_show'] != "" && $main_settings_data['show_phone_bar'] != '0'); 
		if($show_phone && $main_settings_data['show_phone_bar'] == '2'){
			if($estimate_form_data['show_phone'] == '0'){
				$show_phone = false; 
			}
		}

		$data_estimate = get_data_estimate($type);
		$getCurrectCat2 = ( $data_estimate['subCat'] > 0 ) ? $data_estimate['subCat'] : $data_estimate['primeryCat'];
		$getCurrectCat = ( $data_estimate['cat_spec'] > 0 ) ? $data_estimate['cat_spec'] : $getCurrectCat2;
		
		/*
		 // check if whatsapp button need to show. if parent category, subcat or spec_cat set to no, so dont show 
		*/
		$cat_tree_all_arr = array($data_estimate['primeryCat'],$data_estimate['subCat'],$data_estimate['cat_spec']);
		$cat_tree_arr = array();
		$cat_show_whatsapp_button = true;
		foreach($cat_tree_all_arr as $cat_id){
			if($cat_id > 0){
				$cat_tree_arr[] = $cat_id;
			}
		}
		if(!empty($cat_tree_arr)){
			$cat_tree_sql_in = implode(",",$cat_tree_arr);
		}
		
		$whatsapp_sql = "select id, show_whatsapp_button from biz_categories where id IN (".$cat_tree_sql_in.")";
		$whatsapp_res = mysql_db_query(DB,$whatsapp_sql);
		while( $cat_whatsapp_data = mysql_fetch_array($whatsapp_res)){
			if($cat_whatsapp_data['show_whatsapp_button'] == '0'){
				$cat_show_whatsapp_button = false;
			}
		}
		
		/*
		 // end of whatsapp button check
		*/
		$sqlCatsSet = "SELECT googleADSense FROM biz_categories WHERE id = '".$getCurrectCat."' ";
		$resCatsSet = mysql_db_query(DB,$sqlCatsSet);
		$dataCatsSet = mysql_fetch_array($resCatsSet);
		
		if( $data_estimate['formActive'] != "0" || $dataCatsSet['googleADSense'] != ""){
			$show_phone = false;
		}
		$get_nav_to_top = false;
		if($data_colors['top_menu_version'] == '2' || $has_nice_header){
			$get_nav_to_top = true;
		}

	?>
<?php if($browser_is_mobile && $_GET['m'] != 'ecom_form'): ?>
	<?php if( $data_extra_settings['estimateSite'] == "1" && $no_nice_header && $estimate_form_data['form_active']): ?>	
		<?php if($estimate_form_state): ?>	
			<div style="display:none;" id="mobile_estimate_form_wrap">	
				<?php echo $estimate_form_print; ?>
			</div>
			<div id="mobile_estimate_form_open_button_wrap"  class='closed'>
				<div id="mobile_estimate_form_open_button" class="well">
					<a onclick="open_mobile_estimate_form(this)" class='closed' rel='closed' >
						<span class="mobile_estimate_form_open_button_text">
							<?php if($estimate_form_data['form_data']['mobile_button_text'] !=""){echo $estimate_form_data['form_data']['mobile_button_text'];} else{echo $estimate_form_data['top_form_headline'];} ?>
						</span>
					</a>
				</div>
			</div>
		<?php endif; ?>
	<?php endif; ?>						
<?php endif; ?>	
<div id="page_outer_wrap">
		<?php if($no_custom_header): ?>
			<div id="page_fixed_top" class="navbar navbar-inverse navbar-fixed-top">
						

					<?php if($get_nav_to_top || $show_phone): ?>
						<div class="navbar-inner" id="top-header">

							<div class="thinner-width">
								<div class="container">

									<?php if($show_phone): ?>	
										<?php $phone_slogen = ($data_settings['phone_slogen'] == "")? "שירות לקוחות": stripslashes($data_settings['phone_slogen']); ?>
										<div id="et-info">						
											
											<img src="<?php echo HTTP_S; ?>://ilbiz.co.il/ClientSite/version_1/style/image/phone.png" width="23px" alt="" /><?php echo $phone_slogen; ?>: 
											<a class="service-phone-link" href="tel:<?php echo $data_name['phone_to_show'];?>">
												<?php echo $data_name['phone_to_show'];?>
											</a>
											
										</div>
									<?php endif; ?>	
							
									<?php if($get_nav_to_top):?>
										<button type="button" class="btn btn-navbar right-btn-navbar" data-toggle="collapse" data-target=".nav-collapse">
											<div style="float:right;margin: 4px;">
												<span class="icon-bar"></span>
												<span class="icon-bar"></span>
												<span class="icon-bar"></span>
											</div>
											<div style="float:left; font-size:18px;">תפריט</div>
										</button>					
										<div class="navigation navigation-v2 nav-collapse collapse">				
											<?php
												if( $data_name['have_topmenu'] == 1)
												{
													get_topMenu_html();
												}			
											?>
										</div>
									<?php endif; ?>					

								</div>
							</div>
						</div>			
							
					<?php endif; ?>
					
					
					<?php if($no_nice_header): ?>
						<div class="navbar-inner" <?php echo $top_bg_style; ?>>
							<div class="container">
								<?php if(!$get_nav_to_top): ?>
									  <button type="button" class="btn btn-navbar" data-toggle="collapse" data-target=".nav-collapse">
										<div style="float:right;margin: 4px;">
											<span class="icon-bar"></span>
											<span class="icon-bar"></span>
											<span class="icon-bar"></span>
										</div>
										<div style="float:left; font-size:18px;">תפריט</div>
									  </button>
							  <?php endif; ?>
							  <a id="logobrand" class="brand" href="http://<?php echo $_SERVER['HTTP_HOST']; ?>">
								<?php echo $img_logo; ?>	  

							  </a>
							  <?php $classname = "nav-collapse collapse"; if($get_nav_to_top){$classname = "";} ?>
							  <div class="<?php echo $classname; ?>">
								<div class="site-title span3">
									<?php if($data_colors['show_name_in_title'] == "1"): ?>
										<h4>
											<?php echo stripslashes($data_name['name']); ?>
										</h4>
									<?php endif; ?>
									<p>
										<?php echo stripslashes($data_settings['slogen']); ?>
									</p>
								</div>

								<?php if(!$get_nav_to_top): ?>
								<div class="navigation navigation-v1">
								<?php
												if( $data_name['have_topmenu'] == 1)
												{
													get_topMenu_html();
												}			
								?>
								

								</div>
								<?php endif; ?>
							  </div><!--/.nav-collapse -->
							</div>
						</div>
					<?php endif; ?>
			</div>
		<?php else: ?>
			<?php require_once("functions/modules/custom_header.php"); ?>

		<?php endif; ?>
		<?php if(!$show_phone): ?>
			<style type="text/css">
				.phone-hours{display:none !important;}
			</style>
		<?php endif; ?>
		<?php
		if($has_nice_header){
			$sql = "SELECT * FROM sites_landingPage_settings WHERE id = '".$nice_header."'";
			$resSetting = mysql_db_query(DB,$sql);
			$dataLDSetting = mysql_fetch_array($resSetting);
			$dataLDSetting['content_type'] = $nice_header_type;
			require_once("functions/modules/nice_header.php");
		} 	

		?>

			<div class="main-title">
				<div class="thinner-width">
					<div class="container" id="main_title_container">
						<?php
						
							$add_h1 = true;
							if($browser_is_mobile){
								if($m == "text" || (($m=="ar" || $m=="articels")&& isset($_GET['artd']) && false)){
									$add_h1 = false;
								}
							}
						?>
						<?php if( $data_name['have_headline'] == "0" && $add_h1 && !$browser_is_mobile): ?>
							<?php get_page_headline(); ?>
						<?php endif; ?>
					
						<?php if( $data_extra_settings['have_share_button'] == "1" && (!$browser_is_mobile)): ?>
							<div class="addthis-group">		
										
										<script type="text/javascript">
											var addthis_config = {
												data_track_clickback: true
											}
										</script>
										
										<!-- AddThis Button BEGIN -->
								<div class="addthis_toolbox addthis_32x32_style">
								
									<div class="share-item twiter">
										<a class="addthis_button_twitter"></a>
									</div>
									<div class="share-item whatsapp">
										<a href="whatsapp://send?text=http://<?php echo $_SERVER[HTTP_HOST].str_replace("%20","_",$_SERVER[REQUEST_URI]); ?>"><img width="30px;" src='<?php echo HTTP_S; ?>://ilbiz.co.il/ClientSite/version_1/style/image/whatsaap_share.png' alt='' /></a>							
									</div>
									
									<div class="share-item adthis2">
									<?php 
										$url = HTTP_S."://".$_SERVER['HTTP_HOST'];
										$friendly_url = false;
										if(isset($_GET['ftype'])){
											if($_GET['ftype']=='furl'){
												$friendly_url = true;
											}
										}
										if($friendly_url){
											$url.="/".iconv("UTF-8","windows-1255", $_GET['name'])."/";
										}
										else{
											$url_params = "";
											$param_i = 0;
											foreach($_GET as $key=>$val){
												if($key != "gclid"){
													if($param_i == 0){
														$url_params .= "?";
													}
													else{
														$url_params .= "&";
													}
													$url_params .= "$key=$val";
													$param_i++;
												}
											}
											$url.="/index.php".$url_params;
										}
									?>
										<?php /*
											<script type="text/javascript" src="<?php echo HTTP_S; ?>://s7.addthis.com/js/250/addthis_widget.js#username=ilbiz"></script>
										
											  <!-- Your like button code -->
										  <div class="fb-like" 
											data-href="<?php echo $url; ?>" 
											data-layout="button" 
											data-action="like" 
											data-show-faces="false">
										  </div>
										  */ ?>
									</div>
									
									<!-- AddThis Button END -->
									<?php /*
									<div class="share-item higher-fix gplus">
										<g:plusone size='medium'></g:plusone>	
									</div>
									
									<div class="share-item higher-fix adthis">
										<a href="<?php echo HTTP_S; ?>://www.addthis.com/bookmark.php?v=250&amp;username=ilbiz" class="addthis_button_compact"><font class="maintext" ><?php echo $word[LANG]['1_2_facebook_share']; ?></font></a>
									</div>
									
									<div class="share-item higher-fix fblikebutton">
										<a class="addthis_button_facebook_like" fb:like:layout="button_count"></a>
									</div>
									*/ ?>
								</div>	
								
							</div>				
										
						<?php endif; ?>
					
					
					</div>
				</div>
			</div>
			<?php if( $data_name['have_headline'] == "0" && $add_h1 && $browser_is_mobile): ?>
				<div class="mobile_headline">
					<?php get_page_headline(); ?>
					<div style="clear:both;"></div>
				</div>
			<?php endif; ?>
		<?php if( $data_extra_settings['estimateSite'] == "1" && (!isset($_GET['m']) || $_GET['m']=='text')): ?>	
		<div class="full-width">	
			<div id="top_banner_placeholder" class="estimate-top-slice">

				<?php echo estimate_site_top_banner($_GET['t']); ?>
			</div>
		</div>	
		<?php endif; ?>	
			
		<div class="thinner-width">	
			<div id="main_content_container" class="container main-content">
				<?php
					
						ob_start();
					
				?>
				<div class="row-fluid">
					<?php if( $data_name['have_rightmenu'] == "0" && $with_out_RightMenu == "0" ): ?>	
						<?php $have_right_bar = true; ?>
						<?php $right_menu_width = "2"; //( $data_extra_settings['right_menu_width'] == "" ) ? "2" : $data_extra_settings['right_menu_width']; ?>
						<?php $width_content = $site_width - $right_menu_width; ?>								
					<?php else: ?>
						<?php $have_right_bar = false; ?>
						<?php $width_content = "12"; ?>
					<?php endif; ?>			


					<?php if( $have_right_bar ): ?>
						<div id="leftbar" class="span3  opp leftbar">
							<?php if( $data_extra_settings['estimateSite'] == "1" && $no_nice_header && !$estimate_form_state): ?>	
									<?php echo $estimate_form_print; ?>
									
							<?php endif; ?>	
							<?php if(!$browser_is_mobile && $_GET['m'] != 'ecom_form'): ?>
								<?php if( $data_extra_settings['estimateSite'] == "1" && $no_nice_header && $estimate_form_state): ?>	
										<?php echo $estimate_form_print; ?>
										
								<?php endif; ?>						
								<?php put_leftbar_items(); /* sidebars.php */ ?>
							<?php endif; ?>
						</div>
					
					<?php endif; ?>		
				
						
					<div id="centerbar" class="span7  opp centerbar">	

						<?php if($m == "hp" && $data_extra_settings['have_topSliceHtml'] == "1" && $data_extra_settings['topSliceHtml'] != "" ): ?>
						
							<?php
								if( $data_extra_settings['indexSite'] == "1" && false)
								{
									$temp_topslice = top_slice_search_kolnegev();
									$temp_topslice2 = top_slice_search_kolnegev_free_text();
									
									$arrTOP1 = array( "!!!CODE_SERACH_ENGING_NOT_DELETE!!!" , "!!!CODE_SERACH_ENGING_2_NOT_DELETE!!!" );
									$arrTOP12 = array( $temp_topslice , $temp_topslice2 );
									
									$topSliceHtml = str_replace( $arrTOP1 , $arrTOP12 , $data_extra_settings['topSliceHtml'] );;
								}
								else
									$topSliceHtml = stripslashes($data_extra_settings['topSliceHtml']);
							?>
							<div class="row-fluid top-slice top-slice-html">
								<?php echo $topSliceHtml.$topSliceHtml2; ?>
							</div>
						<?php endif; ?>

						<span id="center_main_content"></span>
						<?php if($m == "net_mail_remove"): ?>
							<style type="text/css">
								.net-mail-remove p{display: none;}
							</style>
							<div class="net-mail-remove" style="padding: 0px; margin: 0px 0px 20px; font-size: 18px;color: #2ea3f2;">
								<?php echo get_content($m); ?>
							</div>
							
						<?php endif; ?>				


						<div  id="center_main_content" class="row-fluid">
										<?php if(!$has_nice_header && $data_extra_settings['estimateSite'] == "1"  && (!isset($_GET['m']) || $_GET['m']=='text')): ?>	
							
							<div class="estimate-top-slice">

								<?php echo estimate_site_main_block($_GET['t']); ?>
							</div>
							
						<?php endif; ?>
							<?
							if( $net_mailing__set_user_loginNet == "1" )
								echo "<iframe src ='".HTTP_S."://www.ilbiz.co.il/newsite/net_system/banner.php?unk=".UNK."&amp;b1=&amp;cnu=yes_regIT&amp;b2=' width='140' height='185' id='loginPage2' frameborder=0 scrolling=no allowtransparency='true'></iframe>";
							elseif( $net_mailing__string != "" )
								echo $net_mailing__string;
							else
								echo get_content($m);
							
							if( $data_extra_settings['products_top_banner'] != "" && ( $_GET['m'] == "pr" || $_GET['m'] == "products" ) )
							{
								echo "<div class='row-fluid'>";
									echo '<img width="100%" src="/tamplate/'.$data_extra_settings['products_top_banner'].'" border="0" >';
								echo "</div>";
							}
							
							?>
						</div>		

					</div><!--/span-->

					<?php if( $have_right_bar && $browser_is_mobile): ?>
						<?php put_leftbar_items(); /* sidebars.php */ ?>
					<?php endif; ?>	
							
					<?php if($have_right_bar ): ?>				
						<div id="rightbar" class="span<?php echo $right_menu_width; ?> opp rightbar">
							<?php if( $data_name['have_searchEng'] == "0" ): ?>			
								<div class="right-item well search-form">
									<form action="index.php" method="get" name="search_form" id="search_form">
										<input type="hidden" name="m" value="search" />
											<input type="text" name="search_val" class="search-input" />
											<input type="submit" value="<?php echo $word[LANG]['1_3_search_submit']; ?>" class="search-submit" />
									</form>
								</div>
							<?php endif; ?>
								<?php if( $m == "hp" && $data_colors['home_portal_version'] == '1' ): ?>
									<div class="right-item well" id="scroll_news">
										<div id="scroll_news_inner"> 
											<?php if($data_extra_settings['news_version'] == '1'): ?>
												<?php echo version_1_scroll_news(); ?>
											<?php else: ?>
												<?php echo scroll_news(); ?>	
											<?php endif; ?>
										</div>
									</div>
								<?php endif; ?> 					
							<?php if($data_name['have_ilbiz_net'] == "1"): ?>
								<div class="right-item well" id="net_users">
									<?php user_rightbar_section(); ?>		
								</div>	
								<?php if($_COOKIE['net_user_s'] != "" && $_GET['m'] != 'NetMess' && $_GET['m'] != 'logOut'): ?>
									<div class="right-item well" id="marketing_partners">
										<?php marketing_partners("1"); ?>		
									</div>				
								<?php endif; ?>	
							<?php endif; ?>
							<?php if( $data_name['have_google_search'] == "0" ): ?>
							
								<div class="right-item well" id="google_search">
									<?php echo google_search(); ?>
								</div>
							<?php endif; ?>
							<?php if( $data_extra_settings['RightSliceHtml'] != "" && !$estimate_form_displayed ): ?>
								<div class="right-item">
									<?php echo stripslashes($data_extra_settings['RightSliceHtml']); ?>
								</div>
							<?php endif; ?>			
							<div class="right-item " id="right_nav">	
								<?php echo get_right_menu_html(); ?>
							</div>
							<?php if( $data_name['scrollNewsOrder'] == "1" ): ?>
								<?php if( $m != "hp" ): ?>
									<div class="right-item well" id="scroll_news">
										<div id="scroll_news_inner"> 
											<?php if($data_extra_settings['news_version'] == '1'): ?>
												<?php echo version_1_scroll_news(); ?>
											<?php else: ?>
												<?php echo scroll_news(); ?>	
											<?php endif; ?>
										</div>
									</div>
								<?php endif; ?> 
							<?php endif; ?>		


							<?php if( $data_name['have_add_favi'] == "1" && $data_extra_settings['estimateSite'] == "0" ): ?>
								<div class="right-item well" id="add_to_favorite">
									<?php echo add_to_favorite(); ?>
								</div>
							<?php endif; ?>	
							
							<?php if( $data_name['have_print'] == "1" && $m != "gallery"  ): ?>
								<?php rightMenu__print_link(); ?>
							<?php endif; ?>	
							

							
							
							<?php if( $data_name['have_ecom'] == "1" ): ?>
								<div class="right-item well" id="ecom_table">
									<?php version_1_ecom_table(); ?>
								</div>
							<?php endif; ?>	
							





							<?php if( $data_name['have_calender_events'] == "1" && $data_name['place_calender_events'] == "1"): ?>
							
								<div class="right-item well" id="user_calendar">
														
									<?php if( $_GET['y'] != "" && $_GET['mon'] != "" && $_GET['d'] != ""  ): ?>
										<?php user_calendar(GlobalFunctions::if_is_int($_GET['d'])."-".GlobalFunctions::if_is_int($_GET['mon'])."-".GlobalFunctions::if_is_int($_GET['y'])); ?>
									<?php else: ?>
										<?php user_calendar(); ?>
									<?php endif; ?>
								</div>
							<?php endif; ?>

							
							

							
							<?php if( $data_name['scrollNewsOrder'] == "0" ): ?>
								<?php if( $m != "hp" ): ?>
									<div class="right-item well" id="scroll_news">
										<div id="scroll_news_inner"> 
											<?php if($data_extra_settings['news_version'] == '1'): ?>
												<?php echo version_1_scroll_news(); ?>
											<?php else: ?>
												<?php echo scroll_news(); ?>	
											<?php endif; ?>	
										</div>
									</div>
								<?php endif; ?> 
							<?php endif; ?>


							<?php if( $data_name['have_calender_events'] == "1" && $data_name['place_calender_events'] == "0"): ?>

								<div class="right-item well" id="user_calendar">
														
									<?php if( $_GET['y'] != "" && $_GET['mon'] != "" && $_GET['d'] != ""  ): ?>
										<?php user_calendar(GlobalFunctions::if_is_int($_GET['d'])."-".GlobalFunctions::if_is_int($_GET['mon'])."-".GlobalFunctions::if_is_int($_GET['y'])); ?>
									<?php else: ?>
										<?php user_calendar(); ?>
									<?php endif; ?>
								</div>
							<?php endif; ?>

						</div><!--/span-->	
					<?php endif; ?>	
							
				
						
						
					
				</div><!--/.fluid-container-->
				<?php 
					
						$main_content = ob_get_clean();
						$ef_button_replace = "";
						if($browser_is_mobile && $_GET['m'] != 'ecom_form'){
							if( $data_extra_settings['estimateSite'] == "1" && $no_nice_header && $estimate_form_data['form_active']){
								if($estimate_form_state){
									$ef_button_text = "בקש הצעת מחיר";
									if($estimate_form_data['form_data']['mobile_button_text'] !=""){
										$ef_button_text = $estimate_form_data['form_data']['mobile_button_text'];
									} else{
										$ef_button_text = $estimate_form_data['top_form_headline'];
									} 
									$ef_button_replace = "<a onclick='estimate_form_button_click()' class='ef_open_button'>".$ef_button_text."</a>";
								}
							}
						}
						ob_start();
						$main_content = str_replace("{{net_banner}}",$net_banner_for_content,$main_content);
						$main_content = str_replace("{{ef_button}}",$ef_button_replace,$main_content);
						$main_content_arr = explode("{{service_offers",$main_content);
						if(!isset($main_content_arr[1])){
							echo $main_content_arr[0];
							
						}
						else{
							require_once("functions/modules/service_offers.php");
							$offer_block_id = 0;
							foreach($main_content_arr as $main_content_part){
								$main_content_part_arr =  explode("service_offers}}",$main_content_part);
								if(!isset($main_content_part_arr[1])){
									echo $main_content_part_arr[0];
								}
								else{
									$offer_cat_temp = $main_content_part_arr[0];
									$offer_cat = trim($offer_cat_temp);
									add_service_offer_cat($offer_cat,$offer_block_id);
									echo $main_content_part_arr[1]; 
								}
								$offer_block_id++;
							}
							add_service_offers_js();
						}
						$main_content = ob_get_clean();
						$main_content_arr = explode("{{custom_posts",$main_content);
						if(!isset($main_content_arr[1])){
							echo $main_content_arr[0];
							
						}
						else{
							require_once("functions/modules/custom_posts.php");
							$post_block_id = 0;
							foreach($main_content_arr as $main_content_part){
								$main_content_part_arr =  explode("custom_posts}}",$main_content_part);
								if(!isset($main_content_part_arr[1])){
									echo $main_content_part_arr[0];
								}
								else{
									$post_cat_temp = $main_content_part_arr[0];
									$post_cat = trim($post_cat_temp);
									add_custom_post_cat($post_cat,$post_block_id);
									echo $main_content_part_arr[1]; 
								}
								$post_block_id++;
							}
							add_custom1_posts_style();
						}						
					
				?>
			</div>
		</div>

		<style>
		 @media(min-width: 360px) {footer .adsbygoogle { width: 336px;  } }
		 @media(min-width: 500px) {footer .adsbygoogle { width: 468px;  } }
		 @media(min-width: 800px) {footer .adsbygoogle { width: 728px; } }
		</style>
		<?php
			$with_ecom_class = "";
			if( $data_name['have_ecom'] == "1" ){
				$with_ecom_class = "ecom-clear";
			} 
		 ?>
		<div id="footer_wrap" class="thinner-width footer-wrap <?php echo $with_ecom_class; ?>">
			<div class="container">
				<footer>
					
					
					<?php
					echo "<table id=\"footer_table\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\" align=\"center\" >";
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
							$bottom_slice = stripslashes($data_extra_settings['BottomSliceHtml']);
							$bottom_slice = str_replace("http://",HTTP_S."://",$bottom_slice);
							$bottom_slice_replace_blocks = array();
							$bottom_slice_replace_blocks['bottom_menu'] = get_html_function("get_bottomMenu_html");
							$bottom_slice_replace_blocks['side_menu'] = "<div id='bottom_side_menu'>".$right_menu_html."<div style='clear:both;'></div></div>";
							$bottom_slice_replace_blocks['bottom_copyright'] = get_html_function("bottom_copyright");
							$bottom_slice_replace_blocks['cat_phone'] = $data_name['phone_to_show'];
							ob_start();
							?>
								<div id="google-ads-1"></div>

								<script type="text/javascript"> 

									/* Calculate the width of available ad space */
									ad = document.getElementById('google-ads-1');

									if (ad.getBoundingClientRect().width) {
										adWidth = ad.getBoundingClientRect().width; // for modern browsers 
									} else {
										adWidth = ad.offsetWidth; // for old IE 
									}

									/* Replace ca-pub-XXX with your AdSense Publisher ID */ 
									google_ad_client = "ca-pub-5037108574233722";

									/* Replace 1234567890 with the AdSense Ad Slot ID */ 
									google_ad_slot = "5698196284";
								  
									/* Do not change anything after this line */
									if ( adWidth >= 900 ){
										document.write (
										 '<ins class="adsbygoogle" style="display:inline-block;width:' 
										   + '100%;height:' 
										   + '200px" data-ad-client="' 
										  + google_ad_client + '" data-ad-slot="' 
										  + google_ad_slot + '"></ins>'
										);						
									}
									else{ 
										if ( adWidth >= 728 )
										  google_ad_size = ["728", "90"];  /* Leaderboard 728x90 */
										else if ( adWidth >= 468 )
										  google_ad_size = ["468", "60"];  /* Banner (468 x 60) */
										else if ( adWidth >= 336 )
										  google_ad_size = ["336", "280"]; /* Large Rectangle (336 x 280) */
										else if ( adWidth >= 300 )
										  google_ad_size = ["300", "250"]; /* Medium Rectangle (300 x 250) */
										else if ( adWidth >= 250 )
										  google_ad_size = ["250", "250"]; /* Square (250 x 250) */
										else if ( adWidth >= 200 )
										  google_ad_size = ["200", "200"]; /* Small Square (200 x 200) */
										else if ( adWidth >= 180 )
										  google_ad_size = ["180", "150"]; /* Small Rectangle (180 x 150) */
										else
										  google_ad_size = ["125", "125"]; /* Button (125 x 125) */

										document.write (
										 '<ins class="adsbygoogle" style="display:inline-block;width:' 
										  + google_ad_size[0] + 'px;height:' 
										  + google_ad_size[1] + 'px" data-ad-client="' 
										  + google_ad_client + '" data-ad-slot="' 
										  + google_ad_slot + '"></ins>'
										);
									}
									(adsbygoogle = window.adsbygoogle || []).push({});

								</script>

								<script async src="http://pagead2.googlesyndication.com/pagead/js/adsbygoogle.js">
								</script>
							<?php

							$bottom_slice_replace_blocks['gl_add'] = ob_get_clean();
							foreach($bottom_slice_replace_blocks as $seach=>$replace){
								$bottom_slice = str_replace("{{".$seach."}}",$replace,$bottom_slice);
							}
							echo "<tr>";
								echo "<td valign=bottom>".$bottom_slice."</td>";
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

					if( $data_extra_settings['wibiyaAnalytics'] != '' ){
						echo str_replace("´","'",stripslashes($data_extra_settings['wibiyaAnalytics']))."<br><br>";
					}
					echo str_replace("´","'",stripslashes($data_name['googleAnalytics']));
					echo str_replace("´","'",$data_extra_settings['remartiking_code']);
					if( $data_extra_settings['zopim_script'] != "" ){
						echo str_replace("´","'",stripslashes($data_extra_settings['zopim_script']));
					}



					$sekindo1='0';

					?>
					<?php if($estimate_form_state): ?>	
						<div id="mobile_estimate_form_placeholder"></div>
					<?php endif; ?>
				</footer>

			</div>
		</div>
			
		<script src="<?php echo HTTP_S; ?>://ilbiz.co.il/ClientSite/version_1/style/bootstrap_2.3.2/jquery.validate.min.js"></script>
		<script src="<?php echo HTTP_S; ?>://ilbiz.co.il/ClientSite/version_1/style/bootstrap_2.3.2/bootstrap.min.js"></script>
		

		
		<link rel="stylesheet" href="<?php echo HTTP_S; ?>://ilbiz.co.il/ClientSite/version_1/style/bootstrap_2.3.2/bootstrap-datepicker.min.css" type="text/css">	
		<script src="<?php echo HTTP_S; ?>://ilbiz.co.il/ClientSite/version_1/style/bootstrap_2.3.2/bootstrap-datepicker.min.js"></script>
		<script src="<?php echo HTTP_S; ?>://ilbiz.co.il/ClientSite/version_1/style/bootstrap_2.3.2/bootstrap-datepicker.he.min.js"></script>	
		
		<?php if( $data_name['have_ecom'] == "1" ): ?>
			<script type="text/javascript" src="<?php echo HTTP_S; ?>://www.ilbiz.co.il/ClientSite/version_1/style/js/fly-to-basket.min.js"></script>
		<?php endif; ?>
		<?php if( $data_extra_settings['have_share_button'] == "1" && $browser_is_mobile): ?>
			<div class="mobile-share-item-whatsapp" >
				<a href="whatsapp://send?text=http://<?php echo $_SERVER[HTTP_HOST].str_replace("%20","_",$_SERVER[REQUEST_URI]); ?>"><img width="30px;" src='<?php echo HTTP_S; ?>://ilbiz.co.il/ClientSite/version_1/style/image/whatsaap_share.png' alt='' /></a>							
			</div>
			<style type="text/css">
			.mobile-share-item-whatsapp{position:fixed;top:160px;left:0px;}
			</style>
		<?php endif; ?>

		<?php if($cat_show_whatsapp_button && $data_extra_settings['whatsapp_number'] != "" && $browser_is_mobile && $estimate_form_state && ($main_settings_data['whatsapp_on']==1)): ?>
			<div class="mobile-contact-item-whatsapp" >
				<a href="whatsapp://send?text=<?php echo $data_extra_settings['whatsapp_text']; ?>&phone=<?php echo $data_extra_settings['whatsapp_number']; ?>"><img height="30px;" src='<?php echo HTTP_S; ?>://ilbiz.co.il/ClientSite/version_1/style/image/whatsaap_contact.png' alt='' /></a>						
			</div>
			<style type="text/css">
			.mobile-contact-item-whatsapp{position:fixed;bottom:120px;left:0px;}
			</style>
		<?php endif; ?>
		
		<div id="negishut_wrap" class="negishut-wrap" style="display:none" >
			<div id="negishut_door">
				<a href="javascript://" onclick="open_negishut_menu()" title="נגישות">
				<?php /*	<span id="negishut_door_text">נגישות</span> */ ?>
				</a>
			</div>
			<div id="negishut-content">
				<div id="close_negishut_x">
					<a href="javascript://" onclick="open_negishut_menu()">סגור תפריט נגישות</a>
				</div>
				<div id="negishut-content-inner">
					<h4>תפריט נגישות</h4>
					<ul id="negishut_options">
						<li class="negishut-title">גודל פונט</li>
						<li id="negishut_font_bigger" class="negishut-item">
							<a href="javascript://" onclick="negishut_font_bigger()">הגדל פונט</a>
						</li>
						<li id="negishut_font_smaller" class="negishut-item">
							<a href="javascript://" onclick="negishut_font_smaller()">הקטן פונט</a>
						</li>
						<li class="negishut-title">ניגודיות צבעים</li>
						<li id="negishut_contrast_0" class="negishut-item">
							<a href="javascript://" onclick="negishut_contrast(0)">ניגודיות ברירת מחדל</a>
						</li>
						<li id="negishut_contrast_2" class="negishut-item">
							<a href="javascript://" onclick="negishut_contrast(2)">ניגודיות גבוהה</a>
						</li>
						<li id="negishut_contrast_1" class="negishut-item">
							<a href="javascript://" onclick="negishut_contrast(1)">ניגודיות הפוכה</a>
						</li>
						<li class="negishut-title">קיצורי דרך לאזורי תוכן</li>
						<li id="negishut_goto_main" class="negishut-item">
							<a href="javascript://" onclick="negishut_goto('center_main_content')">עבור לאזור תוכן מרכזי</a>
						</li>	
						<li id="negishut_goto_top_menu" class="negishut-item">
							<a href="javascript://" onclick="negishut_goto('page_fixed_top')">עבור לתפריט עליון</a>
						</li>
						<li id="negishut_goto_top_menu" class="negishut-item">
							<a href="javascript://" onclick="negishut_goto('search_form')">עבור לחיפוש</a>
						</li>	
						<li id="negishut_goto_top_menu" class="negishut-item">
							<a href="javascript://" onclick="negishut_goto('right_nav')">עבור לתפריט משני</a>
						</li>				
						
						<li class="negishut-title">הבהובים ותנועה</li>
						<li id="stop_news_marquee" class="negishut-item">
							<a href="javascript://" onclick="stop_news_marquee()">הפסקת הבהובים ותנועה</a>
						</li>	
						<li id="run_news_marquee" class="negishut-item">
							<a href="javascript://" onclick="run_news_marquee()">הפעלת הבהובים ותנועה</a>
						</li>					
					</ul>
				</div>
			</div>
		</div>
		<?php if(isset($tracking_url) && $c_tracking_on): ?>
			<iframe src="<?php echo $tracking_url; ?>" scrolling="no" frameborder="0" width="1" height="1" data-ontrack='1' ></iframe>
			<p id="tracking_iframe_holder"></p>
			<script type="text/javascript">
				function tracking_form_send(estimateFormId,customer_send){
					<?php if($c_tracking_on): ?>
						var form_tracking_pixel = '<iframe src="<?php echo $form_tracking_url; ?>&estimateFormId='+estimateFormId+'&c_send='+customer_send+'" scrolling="no" frameborder="0" width="1" height="1"></iframe>'; 
						
						var track_holder = document.createElement('span');
						track_holder.innerHTML = form_tracking_pixel;
						var holder_wrap = document.getElementById("tracking_iframe_holder");
						holder_wrap.appendChild(track_holder);
					<?php else: ?>
						return;
					<?php endif; ?>
				}
				function tracking_phone_send(){
					<?php if($c_tracking_on): ?>
						var phone_tracking_pixel = '<iframe src="<?php echo $tracking_url; ?>&phone_called=1" scrolling="no" frameborder="0" width="1" height="1"></iframe>'; 
						
						var track_holder = document.createElement('span');
						track_holder.innerHTML = phone_tracking_pixel;
						var holder_wrap = document.getElementById("tracking_iframe_holder");
						holder_wrap.appendChild(track_holder);
					<?php else: ?>
						return;
					<?php endif; ?>
				}
				jQuery(document).ready(function(){
					jQuery('a[href^="tel:"]').click(function(){
						tracking_phone_send();
					});
				});
				
			</script>
		<?php endif; ?>
			<?php if($data_extra_settings['negishut_version'] == '1'): ?>
				<script type="text/javascript">
					var negishut_date = new Date();
					negishut_date.setMonth(negishut_date.getMonth() + 12);
					var negishut_domain = "<?php echo $_SERVER['HTTP_HOST']; ?>";
					show_negishut();
				</script>	
			<?php endif; ?>
			<script type="text/javascript">
				jQuery(document).ready(function ($) {
					$('.bs-example-tooltips').children().each(function () {
						$(this).tooltip();
					});
					$('.bs-example-popovers').children().each(function () {
							$(this).popover();
					});
					
					
				});



				jQuery(document).ready(function($){
					  $('body').append('<div id="toTop" class="btn btn-info"><i class="fa fa-arrow-up"></i>^</div>');
						$(window).scroll(function () {
							if ($(this).scrollTop() > 100) {
								$('#toTop').fadeIn();
							} else {
								
								$('#toTop').fadeOut();
							}
						}); 
					$('#toTop').click(function(){
						$("html, body").animate({ scrollTop: 0 }, 600);
						return false;
					});
					$('body').animate({paddingTop: $('#page_fixed_top').height() + 5}, 600);
					
				});

				function get_ajax_login_form(){
					jQuery(function($){
						if ($('#rightbar_fb_login').length > 0) {
							$("#ajax_login_form_holder").html("");
						   $('#rightbar_fb_login').appendTo("#ajax_login_form_holder");
						   $('#rightbar_fb_login').prepend("<br/><br/><b>התחברות בקליק</b><br/><br/><br/>");
						}			
					});
				}
				<?php if($_GET['m'] == 'regNetF'): ?>
					jQuery(document).ready(function($){
						//alert($(window).width());
						if($(".page_headline").length == 0 && $(window).width()>975){
								$("#main_content_title_tr").each(function(){
									var h3title = $(this).find("h3");
									if(h3title.length >0){
										var titleHtml = h3title.html();
										$('#main_title_container').append("<div class='headline-item'><h1 class='page_headline'>"+titleHtml+"</h1></div>");
									}
									$(this).remove();
								});
								$("#main_content_top_margin_tr").each(function(){
									$(this).remove();
								});
							}
						});	
				<?php endif; ?>
				<?php if($browser_is_mobile): ?>
					jQuery(document).ready(function($){
						if ($(".suplier-cube")[0] && $(".white-cube")[0]){
							var suplier_cubes_arr = $(".suplier-cube").toArray();
							var white_cubes_arr = $(".white-cube").toArray();							
							for( var i = 0; i < suplier_cubes_arr.length; i++ ){									
								$(white_cubes_arr[(i+1)*2-1]).after($(suplier_cubes_arr[i]));
							}
						}
					});						
				<?php endif; ?>
			</script>
<!--to here -->	
		</div>
	</body>
</html>

<?php
$full_content = ob_get_clean();
$full_content = str_replace("http://",HTTP_S."://",$full_content);
echo $full_content;

mysql_close($connect);
?>
