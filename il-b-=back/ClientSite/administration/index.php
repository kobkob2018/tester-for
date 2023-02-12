<?php

/* 
* Copyright © 2006 ILbiz. All Rights Reserved
* email:	webmaster@ilbiz.co.il
* 
* its the index, the right menu, function for rigth menu,
* style, scripts and all the function that site required
*/

ob_start();
session_start();
error_reporting(0);
ini_set('display_errors', 0);


require_once('../../global_func/vars.php');
$http_s = "http";
if((!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') || $_SERVER['SERVER_PORT'] == 443){
	$http_s = "https";
}
//http://www.ilbiz.co.il/ClientSite/administration/mobile/index.php?row_id=183784&token=b4b2f9904ffa5162939ca1c50f941674c9affb2d
if(isset($_GET['row_id']) && isset($_GET['token'])){

	$sql = "select unk from user_contact_forms where 
			id = '".$_REQUEST['row_id']."' and 
			auth_token = '".$_REQUEST['token']."'";
	$res = mysql_db_query(DB,$sql);
	
	$data = mysql_fetch_array($res);

	if(isset($data['unk']) && $data['unk'] != ""){
				$ss1  = time("H:m:s",1000000000);
				$ss1 = str_replace(":",3,$ss1); 
				$ss2 = $_SERVER[REMOTE_ADDR];
				$ss2 = str_replace(".",3,$ss2); 
				$sesid = "$ss2$ss1";				
				$sql = "insert into login_trace(user,session_idd,ip) values('".$data['unk']."','".$sesid."','".$_SERVER['REMOTE_ADDR']."')";
				$res = mysql_db_query($db,$sql);	
		$_REQUEST['unk'] = $data['unk'];
		session_id($sesid);
		$_REQUEST['sesid'] = $sesid;
		$return_info['current_screen'] = 'get_lead';
		$return_info['row_id'] = $_REQUEST['row_id'];
		//remove token
		
		$sql = "update user_contact_forms SET auth_token  = '' where 
				id = '".$_REQUEST['row_id']."' and 
				auth_token = '".$_REQUEST['token']."'";
		$res = mysql_db_query(DB,$sql);
		echo "<form action='index.php?main=get_create_form&type=contact&row_id=".$return_info['row_id']."' method='post' name='formi'>";
		echo "<input type='hidden' name='sesid' value='".$sesid."'>";
		echo "<input type='hidden' name='unk' value='".$data['unk']."'>";
		echo "</form>";
		echo "<script>formi.submit()</script>";	
		exit();
	}
		
}

if(isset($_GET['qty_unk']) && isset($_GET['qty_token'])){

	$sql = "select unk from lead_qty_reminders where 
			unk = '".$_REQUEST['qty_unk']."' and 
			auth_token = '".$_REQUEST['qty_token']."'";
	$res = mysql_db_query(DB,$sql);
	
	$data = mysql_fetch_array($res);

	if(isset($data['unk']) && $data['unk'] != ""){
				$ss1  = time("H:m:s",1000000000);
				$ss1 = str_replace(":",3,$ss1); 
				$ss2 = $_SERVER[REMOTE_ADDR];
				$ss2 = str_replace(".",3,$ss2); 
				$sesid = "$ss2$ss1";				
				$sql = "insert into login_trace(user,session_idd,ip) values('".$data['unk']."','".$sesid."','".$_SERVER['REMOTE_ADDR']."')";
				$res = mysql_db_query($db,$sql);	
		$_REQUEST['unk'] = $data['unk'];
		session_id($sesid);
		$_REQUEST['sesid'] = $sesid;
		$return_info['current_screen'] = 'get_lead';
		$return_info['row_id'] = $_REQUEST['row_id'];
		//remove token
		
		$sql = "update lead_qty_reminders SET auth_token  = '' where 
				unk = '".$data['unk']."' and 
				auth_token = '".$_REQUEST['qty_token']."'";
		$res = mysql_db_query(DB,$sql);
		echo "<form action='index.php?main=buy_leads&type=buy_leads' method='post' name='formi'>";
		echo "<input type='hidden' name='sesid' value='".$sesid."'>";
		echo "<input type='hidden' name='unk' value='".$data['unk']."'>";
		echo "</form>";
		echo "<script>formi.submit()</script>";	
		exit();
	}
		
}

//check if the user login and if the session its ok
if( $_REQUEST['unk'] == "" || $_REQUEST['sesid'] == "" )	{
	echo "<script>alert('".$word[LANG]['must_connect']."')</script>";
	echo "<script>window.location.href='login.php';</script>";
		exit;
}


// cheake when the session start and end 


$cookie_lang = ( $_COOKIE['managerLang'] == "" ) ? "he" : $_COOKIE['managerLang'];
define('LANG',$cookie_lang);
require('/home/ilan123/domains/ilbiz.co.il/public_html/lang/administration.lang.'.$cookie_lang.'.php');


if( LANG != "he" )
{
	$site_charset = "windows-1255";
	$settings['dir'] = "ltr";
	$settings['re_dir'] = "rtl";
	$settings['align'] = "left";
	$settings['re_align'] = "right";
}
else
{
	$site_charset = "windows-1255";
	$settings['dir'] = "rtl";
	$settings['re_dir'] = "ltr";
	$settings['align'] = "right";
	$settings['re_align'] = "left";
}

	if( $_COOKIE['panelAdmin'] == "provide_insert_to_user_admin" )
	{
		$sql = "select user,date,ip from login_trace where session_idd = '".$_REQUEST['sesid']."'";
		$res = mysql_db_query(DB,$sql);
		$data_login_trace = mysql_fetch_array($res);
	}
	else
	{
		$sql = "select user,date,ip,auth_id from login_trace where session_idd = '".$_REQUEST['sesid']."' and user = '".$_REQUEST['unk']."'";
		$res = mysql_db_query(DB,$sql);
		$data_login_trace = mysql_fetch_array($res);
	}
	
	if( $data_login_trace['user'] != "" )
	{
		DEFINE( 'AUTH_ID' , $data_login_trace['auth_id'] );
		
		$data_login_trace_temp = explode("-",$data_login_trace['date']);
		$year = $data_login_trace_temp[0];
		$month =$data_login_trace_temp[1];
		
		$data_login_trace_temp2 = explode(" ",$data_login_trace_temp[2]);
		$day = $data_login_trace_temp2[0];
		
		$data_login_trace_temp3 = explode(":",$data_login_trace_temp2[1]);
		$hour = $data_login_trace_temp3[0];
		$minute = $data_login_trace_temp3[1];
		$secound = $data_login_trace_temp3[2];
		
		//$expiTime = time() + (1 * 24 * 60 * 60);
		//$DB_time2 = date("YmdHis",$expiTime);
		$DB_time1 = mktime($hour+24, $minute, $secound, $month, $day,  $year);
		$DB_time2 = date("YmdHis",$DB_time1);
		
		$page_expi = date("YmdHis");
		
		// check the date that is -30 min
		if($DB_time2 > $page_expi)	{
			$sql = "update login_trace set date = '".$page_expi."' where session_idd ='".$_REQUEST['sesid']."'";
			$res = mysql_db_query(DB,$sql);
		}
		else	{
			echo "<script>alert('".$word[LANG]['must_last_30_min_action']."');</script>";
			echo "<script>window.location.href='login.php'</script>";
			exit;
		}
	}
	else
	{
		echo "<script>alert('".$word[LANG]['must_connect']."');</script>";
		echo "<script>window.location.href='login.php'</script>";
	}
	
	if( $data_login_trace['ip'] != $_SERVER['REMOTE_ADDR'] )
	{
		echo "<script>alert('".$word[LANG]['alert_4517']."');</script>";
		echo "<script>window.location.href='login.php'</script>";
		exit;
	}

$sql = "select domain from users where unk = '".$_REQUEST['unk']."' and deleted = '0'";
$res_domain = mysql_db_query(DB,$sql);
$data_domain = mysql_fetch_array($res_domain);

$premmissions_arr = array();
$premmissions_sql = "select premmission_key, premmission_val from user_extra_premmissions where user_id = (SELECT id FROM users WHERE unk = '".$_REQUEST['unk']."')";

$res_premmissions = mysql_db_query(DB,$premmissions_sql);
while($data_premmissions = mysql_fetch_array($res_premmissions)){
	if($data_premmissions['premmission_val'] == '1'){
		$premmissions_arr[$data_premmissions['premmission_key']] = '1';
	}
}


$temp_date = getDate();
$year = $temp_date['year'];
$mon = $temp_date['mon'];
$day = $temp_date['mday'];

$end_date = $year."-".$mon."-".$day;

$sql = "select id from users where 
unk = '".$_REQUEST['unk']."' AND
end_date < '".$end_date."' and 
deleted = '0' and 
active_manager = '0' and 
status = '0'";
$res_ENDDate = mysql_db_query(DB,$sql);
$data_ENDDate = mysql_fetch_array($res_ENDDate);

if( $data_ENDDate['id'] != ""  )
	$_SESSION['endDate_userAcount'] = "21k";
else
	$_SESSION['endDate_userAcount'] = "";


define('HTTP_PATH',"http://".$data_domain['domain']);
define('SERVER_PATH',"/home/ilan123/domains/".$data_domain['domain']."/public_html");

define('UNK',$_REQUEST['unk']);
define('SESID',$_REQUEST['sesid']);

$http_path = "http://".$data_domain['domain'];
$server_path = "/home/ilan123/domains/".$data_domain['domain']."/public_html";

define('DEVELOP_IP',"62.90.201.122");

// Class
require("../../global_func/DB.php");
require("../../global_func/global_functions.php");
require("../../global_func/class.phpmailer.php");
require("../../global_func/forms_creator.php");
require("../../global_func/new_images_resize.php");

require('get_content.php');
require('site_settings_functions.php');

load_editor_file();

// functions
require('general_functions.php');
require('functions.php');
require('gallery_functions.php');
require('site_auth_functions.php');
require('net_functions.php');
require('net_functions2.php');
require('calender_events_functions.php');
require('functions_10service.php');
require("/home/ilan123/domains/10service.co.il/public_html/include/userStatView.php");
require("/home/ilan123/domains/10service.co.il/public_html/class.creditMoney.10service.php");
require('functions_10service_2.php');
require('functions_10.php');
require('functions_11.php');
require('functions_14.php');
require("/home/ilan123/domains/ilbiz.co.il/public_html/global_func/classes/class.ilbiz_net.php");
require("/home/ilan123/domains/ilbiz.co.il/public_html/global_func/classes/class.lead.sys.php");

if( UNK == "285240640927706447" )
	require("/home/ilan123/domains/ilbiz.co.il/public_html/global_func/classes/class.ten_stock.php");

$_SESSION['SESSIOSunk'] = UNK;
$_SESSION['SESSIOSN_domain'] = $data_domain['domain'];


// change to upload folder to 777 primtion for ckeditor
change_premition_for_upload_pics();


$main = ( $_REQUEST['main'] == "" ) ? "menu" : $_REQUEST['main'];
//font-weight: bold;
$do_this = "style=\"color: #232323; text-decoration: underline;\"";


// pages that needed bold when you are in there
$temp_type = $_REQUEST['type'];
$temp_var = "this_link_text_".$temp_type;
$$temp_var = ( $_REQUEST['type'] == $temp_type ) ? $do_this : "";
	


$sql = "select * from user_extra_settings where unk = '".UNK."'";
$res_extra_settings = mysql_db_query(DB,$sql);
$data_extra_settings = mysql_fetch_array($res_extra_settings);


$sql_last_id = "select id from content_pages order by id desc limit 1";
$res_last_id = mysql_db_query(DB,$sql_last_id);
$data_last_id = mysql_fetch_array($res_last_id);
$content_new_id = 1+$data_last_id[id];


// create tat link for firet link
switch( $_REQUEST['type'] )	{
	// --------------- Genral
	case "sales" :
	case "wanted" :
	case "yad2" :
	case "news" :
		$tat_main_link_arr = array(
			"name1" => "&nbsp;&nbsp;&nbsp;&nbsp;<a href=\"?main=get_create_form&type=".$_REQUEST['type']."&unk=".UNK."&sesid=".SESID."\" class=\"right_menu\">".$word[LANG]['add_new_post']."</a></td>",
		);
	break;
	
	case "update_pages" :
	case "text_libs" :
		$tat_main_link_arr = array(
			"name1" => "&nbsp;&nbsp;&nbsp;&nbsp;<a href=\"?main=text&type=".$content_new_id."&unk=".UNK."&sesid=".SESID."\" class=\"right_menu\">".$word[LANG]['add_new_page']."</a></td>",
			"name2" => "&nbsp;&nbsp;&nbsp;&nbsp;<a href=\"?main=get_create_form&type=text_libs&unk=".UNK."&sesid=".SESID."\" class=\"right_menu\">".$word[LANG]['add_new_folder']."</a></td>",
			"name3" => "&nbsp;&nbsp;&nbsp;&nbsp;<a href=\"?main=List_View_Rows&type=text_libs&unk=".UNK."&sesid=".SESID."\" class=\"right_menu\">".$word[LANG]['folder_list']."</a></td>",
		);
	break;
	
	case "products" :
	case "products_cat" :
	case "products_subject" :
		if( UNK == "285240640927706447" )
		{
			$tat_main_link_arr = array(
				"name1" => "&nbsp;&nbsp;&nbsp;&nbsp;<a href=\"?main=get_create_form&type=products&unk=".UNK."&sesid=".SESID."\" class=\"right_menu\">".$word[LANG]['add_new_product']."</a></td>",
				"name2" => "&nbsp;&nbsp;&nbsp;&nbsp;<a href=\"?main=ten_products_stock&type=products&unk=".UNK."&sesid=".SESID."\" class=\"right_menu\">מלאי מוצרים</a></td>",
				"name3" => "&nbsp;&nbsp;&nbsp;&nbsp;<a href=\"?main=ten_products_stock_log&type=products&unk=".UNK."&sesid=".SESID."\" class=\"right_menu\">לוג מלאי מוצרים</a></td>",
			);
		}
		else
		{
			if( AUTH_ID == 0 )
			{
				$tat_main_link_arr = array(
					"name1" => "&nbsp;&nbsp;&nbsp;&nbsp;<a href=\"?main=get_create_form&type=products&unk=".UNK."&sesid=".SESID."\" class=\"right_menu\">".$word[LANG]['add_new_product']."</a></td>",
					"name2" => "&nbsp;&nbsp;&nbsp;&nbsp;<a href=\"?main=get_create_form&type=products_cat&unk=".UNK."&sesid=".SESID."\" class=\"right_menu\">".$word[LANG]['add_new_subtopic']."</a></td>",
					"name3" => "&nbsp;&nbsp;&nbsp;&nbsp;<a href=\"?main=List_View_Rows&type=products_cat&unk=".UNK."&sesid=".SESID."\" class=\"right_menu\">".$word[LANG]['subtopic_list']."</a></td>",
					"name4" => "&nbsp;&nbsp;&nbsp;&nbsp;<a href=\"?main=get_create_form&type=products_subject&unk=".UNK."&sesid=".SESID."\" class=\"right_menu\">".$word[LANG]['add_new_topic']."</a></td>",
					"name5" => "&nbsp;&nbsp;&nbsp;&nbsp;<a href=\"?main=List_View_Rows&type=products_subject&unk=".UNK."&sesid=".SESID."\" class=\"right_menu\">".$word[LANG]['topic_list']."</a></td>",
					"name6" => "&nbsp;&nbsp;&nbsp;&nbsp;<a href=\"?main=prices_update&type=products&unk=".UNK."&sesid=".SESID."\" class=\"right_menu\">עדכון מחירים</a></td>",
				);
			}
			else
			{
				$tat_main_link_arr = array(
					"name1" => "&nbsp;&nbsp;&nbsp;&nbsp;<a href=\"?main=get_create_form&type=products&unk=".UNK."&sesid=".SESID."\" class=\"right_menu\">".$word[LANG]['add_new_product']."</a></td>",
				);
			}
		}
	break;
	
	case "10service_product" :
		$tat_main_link_arr = array(
			"name1" => "&nbsp;&nbsp;&nbsp;&nbsp;<a href=\"?main=get_create_form&type=10service_product&unk=".UNK."&sesid=".SESID."\" class=\"right_menu\">".$word[LANG]['add_new_product']."</a></td>",
		);
	break;
	
	case "articels" :
	case "articels_cat" :
		if( UNK == "285240640927706447" )
		{
			$tat_main_link_arr = array(
				"name1" => "&nbsp;&nbsp;&nbsp;&nbsp;<a href=\"?main=get_create_form&type=articels&unk=".UNK."&sesid=".SESID."\" class=\"right_menu\">".$word[LANG]['add_new_article']."</a></td>",
			);
		}
		else
		{
			if( AUTH_ID == 0 )
			{
				$tat_main_link_arr = array(
					"name1" => "&nbsp;&nbsp;&nbsp;&nbsp;<a href=\"?main=get_create_form&type=articels&unk=".UNK."&sesid=".SESID."\" class=\"right_menu\">".$word[LANG]['add_new_article']."</a></td>",
					"name2" => "&nbsp;&nbsp;&nbsp;&nbsp;<a href=\"?main=get_create_form&type=articels_cat&unk=".UNK."&sesid=".SESID."\" class=\"right_menu\">".$word[LANG]['add_new_category']."</a></td>",
					"name3" => "&nbsp;&nbsp;&nbsp;&nbsp;<a href=\"?main=List_View_Rows&type=articels_cat&unk=".UNK."&sesid=".SESID."\" class=\"right_menu\">".$word[LANG]['categories_list']."</a></td>",
				);
			}
			else
			{
				$tat_main_link_arr = array(
					"name1" => "&nbsp;&nbsp;&nbsp;&nbsp;<a href=\"?main=get_create_form&type=articels&unk=".UNK."&sesid=".SESID."\" class=\"right_menu\">".$word[LANG]['add_new_article']."</a></td>",
				);
			}
		}
	break;
	
	case "gallery" :
	case "gallery_cat" :
	case "gallery_subject" :
	if( UNK == "285240640927706447" )
	{
		$tat_main_link_arr = array(
			"name1" => "&nbsp;&nbsp;&nbsp;&nbsp;<a href=\"?main=edit_picture&type=gallery&unk=".UNK."&sesid=".SESID."\" class=\"right_menu\">".$word[LANG]['add_new_picture']."</a></td>",
		);
	}
	else
	{
		if( AUTH_ID == 0 )
		{
			$tat_main_link_arr = array(
				"name1" => "&nbsp;&nbsp;&nbsp;&nbsp;<a href=\"?main=edit_picture&type=gallery&unk=".UNK."&sesid=".SESID."\" class=\"right_menu\">".$word[LANG]['add_new_picture']."</a></td>",
				"name2" => "&nbsp;&nbsp;&nbsp;&nbsp;<a href=\"?main=upload_multi_img&type=gallery&unk=".UNK."&sesid=".SESID."\" class=\"right_menu\">הוספת תמונות מרובות</a></td>",
				//"name2" => "&nbsp;&nbsp;&nbsp;&nbsp;<a href=\"?main=add_5_pics&type=gallery&unk=".UNK."&sesid=".SESID."\" class=\"right_menu\">".$word[LANG]['add_new_5_images']."</a></td>",
				"name3" => "&nbsp;&nbsp;&nbsp;&nbsp;<a href=\"?main=get_create_form&type=gallery_cat&unk=".UNK."&sesid=".SESID."\" class=\"right_menu\">".$word[LANG]['add_new_subtopic']."</a></td>",
				"name4" => "&nbsp;&nbsp;&nbsp;&nbsp;<a href=\"?main=List_View_Rows&type=gallery_cat&unk=".UNK."&sesid=".SESID."\" class=\"right_menu\">".$word[LANG]['subtopic_list']."</a></td>",
				"name5" => "&nbsp;&nbsp;&nbsp;&nbsp;<a href=\"?main=get_create_form&type=gallery_subject&unk=".UNK."&sesid=".SESID."\" class=\"right_menu\">".$word[LANG]['add_new_topic']."</a></td>",
				"name6" => "&nbsp;&nbsp;&nbsp;&nbsp;<a href=\"?main=List_View_Rows&type=gallery_subject&unk=".UNK."&sesid=".SESID."\" class=\"right_menu\">".$word[LANG]['topic_list']."</a></td>",
				
			);
		}
		else
		{
			$tat_main_link_arr = array(
				"name1" => "&nbsp;&nbsp;&nbsp;&nbsp;<a href=\"?main=edit_picture&type=gallery&unk=".UNK."&sesid=".SESID."\" class=\"right_menu\">".$word[LANG]['add_new_picture']."</a></td>",
			);
		}
	}
	break;
	
	case "video" :
	case "video_cat" :
		if( AUTH_ID == 0 )
		{
			$tat_main_link_arr = array(
				"name1" => "&nbsp;&nbsp;&nbsp;&nbsp;<a href=\"?main=get_create_form&type=video&unk=".UNK."&sesid=".SESID."\" class=\"right_menu\">".$word[LANG]['add_new_post']."</a></td>",
				"name2" => "&nbsp;&nbsp;&nbsp;&nbsp;<a href=\"?main=get_create_form&type=video_cat&unk=".UNK."&sesid=".SESID."\" class=\"right_menu\">".$word[LANG]['add_new_category']."</a></td>",
				"name3" => "&nbsp;&nbsp;&nbsp;&nbsp;<a href=\"?main=List_View_Rows&type=video_cat&unk=".UNK."&sesid=".SESID."\" class=\"right_menu\">".$word[LANG]['categories_list']."</a></td>",
			);
		}
		else
		{
			$tat_main_link_arr = array(
				"name1" => "&nbsp;&nbsp;&nbsp;&nbsp;<a href=\"?main=get_create_form&type=".$_REQUEST['type']."&unk=".UNK."&sesid=".SESID."\" class=\"right_menu\">".$word[LANG]['add_new_post']."</a></td>",
			);
		}
	break;
	
	// --------------- Contact
	case "contact" :
	case "contact_subjects" :
		if( AUTH_ID == 0 )
		{
			$tat_main_link_arr = array(
				"name1" => "&nbsp;&nbsp;&nbsp;&nbsp;<a href=\"?main=text&type=contact&unk=".UNK."&sesid=".SESID."\" class=\"right_menu\">".$word[LANG]['add_txt_adove_form']."</a></td>",
				"name2" => "&nbsp;&nbsp;&nbsp;&nbsp;<a href=\"?main=get_create_form&type=contact_subjects&unk=".UNK."&sesid=".SESID."\" class=\"right_menu\">".$word[LANG]['add_new_topic_form']."</a></td>",
				"name3" => "&nbsp;&nbsp;&nbsp;&nbsp;<a href=\"?main=List_View_Rows&type=contact_subjects&unk=".UNK."&sesid=".SESID."\" class=\"right_menu\">".$word[LANG]['list_topic_form']."</a></td>",
				//"name4" => "&nbsp;&nbsp;&nbsp;&nbsp;<a href=\"?main=user_lead_send_hours&unk=".UNK."&sesid=".SESID."\" class=\"right_menu\">ניהול שעות לשליחת לידים</a></td>",				
			);
		}
	break;
	
	case "gb" :
		$tat_main_link_arr = array(
			"name1" => "&nbsp;&nbsp;&nbsp;&nbsp;<a href=\"?main=text&type=gb&unk=".UNK."&sesid=".SESID."\" class=\"right_menu\">".$word[LANG]['add_txt_adove_rection']."</a></td>",
		);
	break;
	
	case "site_auth" :
		$tat_main_link_arr = array(
			"name1" => "&nbsp;&nbsp;&nbsp;&nbsp;<a href=\"?main=site_authForm&type=site_auth&unk=".UNK."&sesid=".SESID."\" class=\"right_menu\">".$word[LANG]['add_permission']."</a></td>",
		);
	break;
	
	case "design_page" :
	case "design_page_cat" :
		$tat_main_link_arr = array(
			"name1" => "&nbsp;&nbsp;&nbsp;&nbsp;<a href=\"?main=get_create_form&type=design_page&unk=".UNK."&sesid=".SESID."\" class=\"right_menu\">".$word[LANG]['add_new_post']."</a></td>",
			"name2" => "&nbsp;&nbsp;&nbsp;&nbsp;<a href=\"?main=get_create_form&type=design_page_cat&unk=".UNK."&sesid=".SESID."\" class=\"right_menu\">".$word[LANG]['add_new_category']."</a></td>",
			"name3" => "&nbsp;&nbsp;&nbsp;&nbsp;<a href=\"?main=List_View_Rows&type=design_page_cat&unk=".UNK."&sesid=".SESID."\" class=\"right_menu\">".$word[LANG]['categories_list']."</a></td>",
		);
	break;
	
	case "net" :
		$tat_main_link_arr = array(
			"name1" => "&nbsp;&nbsp;&nbsp;&nbsp;<a href=\"?main=text&type=net&unk=".UNK."&sesid=".SESID."\" class=\"right_menu\">".$word[LANG]['add_txt_adove_form']."</a></td>",
			"name2" => "&nbsp;&nbsp;&nbsp;&nbsp;<a href=\"?main=net_massg_edit&type=net&unk=".UNK."&sesid=".SESID."\" class=\"right_menu\">".$word[LANG]['snd_msg_customers']."</a></td>",
			"name3" => "&nbsp;&nbsp;&nbsp;&nbsp;<a href=\"?main=net_massg_list&type=net&unk=".UNK."&sesid=".SESID."\" class=\"right_menu\">".$word[LANG]['list_msg_sent']."</a></td>",
		);
	break;
	
	
	case "guide" :
	case "guide_business" :
	case "guide_cats" :
	case "guide_cities" :
		$tat_main_link_arr = array(
			"name1" => "&nbsp;&nbsp;&nbsp;&nbsp;<a href=\"?main=get_create_form&type=guide&unk=".UNK."&sesid=".SESID."\" class=\"right_menu\">הוסף מדריך</a></td>",
			"name2" => "&nbsp;&nbsp;&nbsp;&nbsp;<a href=\"?main=get_create_form&type=guide_business&unk=".UNK."&sesid=".SESID."\" class=\"right_menu\">הוסף עסק למדריך</a></td>",
			"name3" => "&nbsp;&nbsp;&nbsp;&nbsp;<a href=\"?main=List_View_Rows&type=guide_business&unk=".UNK."&sesid=".SESID."\" class=\"right_menu\">רשימת עסקים</a></td>",
			"name4" => "&nbsp;&nbsp;&nbsp;&nbsp;<a href=\"?main=get_create_form&type=guide_cats&unk=".UNK."&sesid=".SESID."\" class=\"right_menu\">הוסף קטגוריה</a></td>",
			"name5" => "&nbsp;&nbsp;&nbsp;&nbsp;<a href=\"?main=List_View_Rows&type=guide_cats&unk=".UNK."&sesid=".SESID."\" class=\"right_menu\">רשימת קטגוריות</a></td>",
			"name6" => "&nbsp;&nbsp;&nbsp;&nbsp;<a href=\"?main=get_create_form&type=guide_cities&unk=".UNK."&sesid=".SESID."\" class=\"right_menu\">הוסף עיר</a></td>",
			"name7" => "&nbsp;&nbsp;&nbsp;&nbsp;<a href=\"?main=List_View_Rows&type=guide_cities&unk=".UNK."&sesid=".SESID."\" class=\"right_menu\">רשימת ערים</a></td>",
			
		);
	break;
	
	case "banners_guide" :
		$tat_main_link_arr = array(
			"name1" => "&nbsp;&nbsp;&nbsp;&nbsp;<a href=\"?main=get_create_form&type=banners_guide&unk=".UNK."&sesid=".SESID."\" class=\"right_menu\">הוסף באנר</a></td>",
		);
	break;
	
	case "net_mailing" :
		$tat_main_link_arr = array(
			"name3" => "&nbsp;&nbsp;&nbsp;&nbsp;<a href=\"?main=net_mailing_settings_edit&type=net_mailing&unk=".UNK."&sesid=".SESID."\" class=\"right_menu\">הוסף דיוור אוטומטי</a></td>",
			"name1" => "&nbsp;&nbsp;&nbsp;&nbsp;<a href=\"?main=net_mailing_settings&type=net_mailing&unk=".UNK."&sesid=".SESID."\" class=\"right_menu\">רשימת דיוורים אוטומטים</a></td>",
			"name4" => "&nbsp;&nbsp;&nbsp;&nbsp;<a href=\"?main=net_mailing_qa_anw_edit&type=net_mailing&unk=".UNK."&sesid=".SESID."\" class=\"right_menu\">הוסף שאלה \ תשובה</a></td>",
			"name5" => "&nbsp;&nbsp;&nbsp;&nbsp;<a href=\"?main=net_mailing_qa_anw&type=net_mailing&unk=".UNK."&sesid=".SESID."\" class=\"right_menu\">מאגר שאלות תשובות</a></td>",
			"name6" => "&nbsp;&nbsp;&nbsp;&nbsp;<a href=\"?main=net_mailing_report&type=net_mailing&unk=".UNK."&sesid=".SESID."\" class=\"right_menu\">דוחות מעקב</a></td>",
			
		);
	break;
	
	
	case "LandingPage" :
		$tat_main_link_arr = array(
			"name1" => "&nbsp;&nbsp;&nbsp;&nbsp;<a href=\"?main=LandingPage_edit&type=LandingPage&unk=".UNK."&sesid=".SESID."\" class=\"right_menu\">הוסף דף נחיתה</a></td>",
		);
	break;
	
	case "usresTZ" :
		$tat_main_link_arr = array(
			"name1" => "&nbsp;&nbsp;&nbsp;&nbsp;<a href=\"?main=get_create_form&type=usresTZ&unk=".UNK."&sesid=".SESID."\" class=\"right_menu\">הוסף תעודת זהות</a></td>",
			"name2" => "&nbsp;&nbsp;&nbsp;&nbsp;<a href=\"?main=get_create_form_Multi&type=usresTZ&unk=".UNK."&sesid=".SESID."\" class=\"right_menu\">הוסף רשימת תעודות זהות</a></td>",
		);
	break;
	
	
	case "einYahav" :
	case "einYahav_products" :
	case "einYahav_sizes" :
		$tat_main_link_arr = array(
			"name1" => "&nbsp;&nbsp;&nbsp;&nbsp;<a href=\"?main=get_create_form&type=einYahav&sub_type=0&unk=".UNK."&sesid=".SESID."\" class=\"right_menu\">עדכון מחירים</a></td>",
			"name2" => "&nbsp;&nbsp;&nbsp;&nbsp;<a href=\"?main=get_create_form&type=einYahav_products&unk=".UNK."&sesid=".SESID."\" class=\"right_menu\">הוסף מוצר חדש</a></td>",
			"name3" => "&nbsp;&nbsp;&nbsp;&nbsp;<a href=\"?main=List_View_Rows&type=einYahav_products&unk=".UNK."&sesid=".SESID."\" class=\"right_menu\">רשימת מוצרים</a></td>",
			"name4" => "&nbsp;&nbsp;&nbsp;&nbsp;<a href=\"?main=get_create_form&type=einYahav_sizes&unk=".UNK."&sesid=".SESID."\" class=\"right_menu\">הוסף גודל חדש</a></td>",
			"name5" => "&nbsp;&nbsp;&nbsp;&nbsp;<a href=\"?main=List_View_Rows&type=einYahav_sizes&unk=".UNK."&sesid=".SESID."\" class=\"right_menu\">רשימת גדלים</a></td>",
			
			"name6" => "&nbsp;&nbsp;&nbsp;&nbsp;<a href=\"?main=List_View_Rows&type=einYahav&sub_type=1&unk=".UNK."&sesid=".SESID."\" class=\"right_menu\">מחירי הערכת מכירה</a></td>",
			"name7" => "&nbsp;&nbsp;&nbsp;&nbsp;<a href=\"?main=get_create_form&type=einYahav&sub_type=1&unk=".UNK."&sesid=".SESID."\" class=\"right_menu\">עדכון מחירי הערכה</a></td>",
		);
	break;
	
	case "group_buy" :
		$tat_main_link_arr = array(
			"name1" => "&nbsp;&nbsp;&nbsp;&nbsp;<a href=\"?main=get_create_form&type=group_buy&unk=".UNK."&sesid=".SESID."\" class=\"right_menu\">הוסף מוצר</a></td>",
		);
	break;
	
	case "deal_coupon" :
		$tat_main_link_arr = array(
			"name1" => "&nbsp;&nbsp;&nbsp;&nbsp;<a href=\"?main=get_create_form&type=deal_coupon&unk=".UNK."&sesid=".SESID."\" class=\"right_menu\">הוסף מוצר</a></td>",
		);
	break;
	
	case "realty" :
		$tat_main_link_arr = array(
			"name1" => "&nbsp;&nbsp;&nbsp;&nbsp;<a href=\"?main=get_create_form&type=realty&unk=".UNK."&sesid=".SESID."\" class=\"right_menu\">הוסף רשומה</a></td>",
		);
	break;
}

// function that create tat links to the menu
	if( is_array($tat_main_link_arr) )	{
		foreach( $tat_main_link_arr as $key )	{
			$tat_main .= "<tr><td height=\"3\" colspan=\"3\"></td></tr>";
			$tat_main .= "<tr>";
				$tat_main .= "<td width=\"1\"></td>";
				$tat_main .= "<td style='background-color: #ffffff;'>".$key."</td>";
			$tat_main .= "</tr>";
		}
	}
	
	

	
	// get the name of the pages - empty name => not exits in the list
	
	$sql_AUTH = "SELECT model FROM user_site_auth_belong WHERE unk = '".UNK."' AND auth_id = '".AUTH_ID."'";
	$res_AUTH = mysql_db_query(DB,$sql_AUTH);
	
	$string_auth = "";
	while( $data_AUTH = mysql_fetch_array($res_AUTH) )
	{
		$string_auth .= "@".$data_AUTH['model']."@";
	}
	DEFINE( 'STRING_AUTH' , $string_auth );
	
	$sql = "select * from user_words where unk = '".UNK."'";
	$res = mysql_db_query(DB,$sql);
	$data = mysql_fetch_array($res);
	
	if( eregi( "@ab@" , STRING_AUTH ) || AUTH_ID == 0 )
		$temp_word_about = ( $data['id'] == "" ) ? $word[LANG]['chapter_name_about'] : stripslashes($data['word_about']);
	if( eregi( "@ar@" , STRING_AUTH ) || AUTH_ID == 0 )
		$temp_word_articels = ( $data['id'] == "" ) ? $word[LANG]['chapter_name_articels'] : stripslashes($data['word_articels']);
	if( eregi( "@pr@" , STRING_AUTH ) || AUTH_ID == 0 )
		$temp_word_products = ( $data['id'] == "" ) ? $word[LANG]['chapter_name_products'] : stripslashes($data['word_products']);
	if( eregi( "@ya@" , STRING_AUTH ) || AUTH_ID == 0 )
		$temp_word_yad2 = ( $data['id'] == "" ) ? $word[LANG]['chapter_name_yad2'] : stripslashes($data['word_yad2']);
	if( eregi( "@sa@" , STRING_AUTH ) || AUTH_ID == 0 )
		$temp_word_sales = ( $data['id'] == "" ) ? $word[LANG]['chapter_name_sales'] : stripslashes($data['word_sales']);
	if( eregi( "@vi@" , STRING_AUTH ) || AUTH_ID == 0 )
		$temp_word_video = ( $data['id'] == "" ) ? $word[LANG]['chapter_name_video'] : stripslashes($data['word_video']);
	if( eregi( "@jo@" , STRING_AUTH ) || AUTH_ID == 0 )
		$temp_word_wanted = ( $data['id'] == "" ) ? $word[LANG]['chapter_name_jobs'] : stripslashes($data['word_wanted']);
	if( eregi( "@ga@" , STRING_AUTH ) || AUTH_ID == 0 )
		$temp_word_gallery = ( $data['id'] == "" ) ? $word[LANG]['chapter_name_gallery'] : stripslashes($data['word_gallery']);
	
	if( UNK == "263512086634836547" )
	{
		if( AUTH_ID == 0 )
			$temp_word_contact = ( $data['id'] == "" ) ? $word[LANG]['chapter_name_contact'] : stripslashes($data['word_contact']);
	}
	else
	{
		if( eregi( "@co@" , STRING_AUTH ) || AUTH_ID == 0 )
			$temp_word_contact = ( $data['id'] == "" ) ? $word[LANG]['chapter_name_contact'] : stripslashes($data['word_contact']);
	}
	
	$temp_word_gb = ( $data['id'] == "" ) ? "" : stripslashes($data['word_gb']);
	
	$sql = "select * from content_pages where unk = '".UNK."' and type = '".$_REQUEST['type']."' and deleted = '0'";
	$res_content_ewe = mysql_db_query(DB,$sql);
	$data_content_ewe = mysql_fetch_array($res_content_ewe);
	
	$sql = "select have_homepage,have_topmenu,max_free_text,have_ecom,have_users_auth,have_event_board,have_ilbiz_net,have_calender_events from users where unk = '".UNK."' and deleted = '0'";
	$res_content_ewe = mysql_db_query(DB,$sql);
	$data_have_hp = mysql_fetch_array($res_content_ewe);
	
	$agreement_path = "/home/ilan123/domains/ilbiz.co.il/public_html/site-admin/clients/eskemim/";
	$path2 = $agreement_path.$data_extra_settings['agreement_10service_products'];
		if( is_file($path2) && !is_dir($path2) )
			define( 'agreement_have_2' , '1' );
		else
			define( 'agreement_have_2' , '0' );
	
	if( AUTH_ID != 0 )
	{
		switch( $_REQUEST['type'] )
		{
			case "articels" :			if( !eregi( "@ar@" , STRING_AUTH ) )	exit;			break;
			case "sales" :				if( !eregi( "@sa@" , STRING_AUTH ) )	exit;			break;
			case "wanted" :				if( !eregi( "@jo@" , STRING_AUTH ) )	exit;			break;
			case "video" :				if( !eregi( "@vi@" , STRING_AUTH ) )	exit;			break;
			case "yad2" :					if( !eregi( "@ya@" , STRING_AUTH ) )	exit;			break;
			case "products" :			if( !eregi( "@pr@" , STRING_AUTH ) )	exit;			break;
			case "contact" :			if( !eregi( "@co@" , STRING_AUTH ) )	exit;			break;
			
			case "video_cat" :
			case "products_cat" :
			case "products_subject" :
			case "gallery_cat" :
			case "gallery_subject" :
			case "gb" :	
			case "news" :	
			case "update_pages" :
			case "myClients" :
			case "text_libs" :
			case "design_page_cat" :
			case "design_page" :
					if( AUTH_ID != 0 )	exit;			break;
		}
	}
	
	$auth_qry_str = ( AUTH_ID != 0 ) ? " AND auth_id = '".AUTH_ID."'" : "";
	DEFINE( 'AUTH_QUERY_STR' , $auth_qry_str );
	
	
?>
<html xmlns="http://www.w3.org/1999/xhtml">
<html>
<head>
	<meta HTTP-EQUIV='Content-Type' CONTENT='text/html; charset=windows-1255'/>
	<title>..::  <?=$word[LANG]['browser_title'];?>  ::..</title>
	<script src="script.js" type="text/javascript"></script>
	<link rel="stylesheet" href="style.css" type="text/css">
	
	<link href="jquery-ui-1.8.1.custom.css" rel="stylesheet" type="text/css">
	<script type="text/javascript" src="<?php echo $http_s; ?>://ajax.googleapis.com/ajax/libs/jquery/1.4/jquery.min.js"></script>
	<script type="text/javascript" src="<?php echo $http_s; ?>://ajax.googleapis.com/ajax/libs/jqueryui/1.8/jquery-ui.min.js"></script>
	
	<?
	setcookie("COOCKIE_domain", "", time() - 3600);
	setcookie("COOCKIE_domain", $data_domain['domain'], time() + 3600 , "/" );
	
	if( $main == "calender_events_edit" )
		echo "<script src=\"http://www.ilbiz.co.il/global_func/scripts/calendar_pupdate.js\" type=\"text/javascript\"></script>";
	elseif( $_GET['type'] == "group_buy" || $_GET['type'] == "deal_coupon" )
		echo "<script type=\"text/javascript\" src=\"jquery-ui-timepicker-addon.js\"></script>";
	
	if( $main == "user_portal_cats" || $main == "user_portal_newCities" )	{
		echo "<script src=\"options.fiels/htmldb_html_elements.js\" type=\"text/javascript\"></script>
		<link rel=\"stylesheet\" href=\"options.fiels/css_1.css\" type=\"text/css\" />
		<link rel=\"stylesheet\" href=\"options.fiels/css_2.css\" type=\"text/css\" />";
	}
	
	if( $_GET['main'] == "upload_multi_img" )
	{
		?>
		<!-- Bootstrap CSS Toolkit styles -->
		<link rel="stylesheet" href="uploadImages/css/bootstrap.min.css">
		<!-- Bootstrap styles for responsive website layout, supporting different screen sizes -->
		<link rel="stylesheet" href="https://netdna.bootstrapcdn.com/twitter-bootstrap/2.1.0/css/bootstrap-responsive.min.css">
		<!-- Bootstrap CSS fixes for IE6 -->
		<!--[if lt IE 7]><link rel="stylesheet" href="https://raw.github.com/blueimp/Bootstrap-Image-Gallery/master/css/bootstrap-ie6.min.css"><![endif]-->
		<!-- Bootstrap Image Gallery styles -->
		<link rel="stylesheet" href="https://raw.github.com/blueimp/Bootstrap-Image-Gallery/master/css/bootstrap-image-gallery.min.css">
		<!-- CSS to style the file input field as button and adjust the Bootstrap progress bars -->
		<link rel="stylesheet" href="uploadImages/css/jquery.fileupload-ui.css">
		<!-- Shim to make HTML5 elements usable in older Internet Explorer versions -->
		<!--[if lt IE 9]><script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script><![endif]-->
		<?
	}
	?>
	
	
	
	<script>
		function can_i_del()  {
			aa = confirm("<?=$word[LANG]['are_you_sure'];?>");
			if(aa == true)
				return true;
			else
				return false;
		}	
		
		function can_view_contact()  {
			aa = confirm("האם ברצונך לפתוח פניה זו ולהשתמש ביתרת ההודעות?");
			if(aa == true)
				return true;
			else
				return false;
		}
		
		function can_view_contact_2()  {
			aa = confirm("האם ברצונך לפתוח פניה זו ולהשתמש ביתרת הקרדיטים?");
			if(aa == true)
				return true;
			else
				return false;
		}
		
		function textCounter(field,cntfield,maxlimit) {
			if (field.value.length > maxlimit) // if too long...trim it!
				field.value = field.value.substring(0, maxlimit);
			// otherwise, update 'characters left' counter
			else
				cntfield.value = maxlimit - field.value.length;
			
		}
	</script>
	
</head>


<body leftmargin="0" topmargin="5" rightmargin="0" bottommargin="0" marginwidth="0" marginheight="0">

<table border="0" cellspacing="0" cellpadding="0" class="right_menu" dir="<?=$settings['dir'];?>" align="center">
	<tr>
		<td valign="top">
<?php
		if ( $_SESSION['endDate_userAcount'] != "21k" )
		{
			echo "<table border=\"0\" cellspacing=\"0\" cellpadding=\"0\" width=\"150\" class=\"right_menu\" dir=\"".$settings['dir']."\" align=\"right\">";
				
				echo "<tr><td height=\"7\" colspan=\"3\"></td></tr>";
				
				echo "<tr>";
					echo "<td width=\"1\"></td>";
					echo "<td><a href=\"?main=menu&unk=".UNK."&sesid=".SESID."\" class=\"right_menu\"><img src='images/icons/news.png' width=20 border=0 alt='' style='padding-left: 6px;'> הודעות מחברת il-biz</a></td>";
				echo "</tr>";
				echo "<tr><td height=\"5\" ></td></tr>";
				
				if(AUTH_ID == 0 )	{
					
					echo "<tr>";
						echo "<td width=\"1\"></td>";
						echo "<td><a href=\"?main=payments_list&unk=".UNK."&sesid=".SESID."\" class=\"right_menu\"><img src='images/icons/news.png' width=20 border=0 alt='' style='padding-left: 6px;'>  ".$word[LANG]['payments_list']."</a></td>";
					echo "</tr>";
					
					echo "<tr><td height=\"5\" ></td></tr>";
				}

				
				echo "<tr><td height=\"5\" ></td></tr>";				
				if( $temp_word_contact ||  AUTH_ID == 0 )	{
					
					echo "<tr>";
						echo "<td width=\"1\"></td>";
						echo "<td><a href=\"?main=List_View_Rows&type=contact&status=0&unk=".UNK."&sesid=".SESID."\" class=\"right_menu\" ".$this_link_text_contact."><img src='images/icons/top_contact.png' width=20 border=0 alt='' style='padding-left: 6px;'>  ".$word[LANG]['rm_view_forms']." ".$temp_word_contact."</a></td>";
					echo "</tr>";
					
					if( $_REQUEST['type'] == "contact" || $_REQUEST['type'] == "contact_subjects" )
						echo $tat_main;
					
					echo "<tr><td height=\"5\" ></td></tr>";
				}
				
				if( $data_have_hp['have_ecom'] == "1" && AUTH_ID == 0 )
				{
					echo "<tr>";
						echo "<td width=\"1\"></td>";
						echo "<td><a href=\"?main=users_ecom_buy&type=users_ecom_buy&unk=".UNK."&sesid=".SESID."\" class=\"right_menu\" ".$this_link_text_users_ecom_buy."><img src='images/icons/ecom.png' width=20 border=0 alt='' style='padding-left: 6px;'>  הזמנות מחנות אלקטרונית</a></td>";
					echo "</tr>";
					echo "<tr><td height=\"5\" ></td></tr>";
				}
				
				
				/*echo "<tr height=20>";
					echo "<td width=\"1\"></td>";
					echo "<td align=center><a href=\"http://www.10service.co.il\" class=\"right_menu\" target=\"_blank\" style='font-size: 14px;'><img src='images/120x120.jpg' border=0 alt=''></a></td>";
				echo "</tr>";*/
				echo "<tr><td height=\"15\" ></td></tr>";
				
				echo "<tr>";
					echo "<td width=\"1\"></td>";
					echo "<td><a href=\"http://sherut10.co.il\" class=\"right_menu\" target=\"_blank\"><img src='images/logoOnly.png' border=0 alt='' width=149></a></td>";
				echo "</tr>";
				
				echo "<tr><td height=\"5\" ></td></tr>";
				
				$sqlPageUser = "SELECT cp.type FROM content_pages AS cp , users AS u WHERE cp.unk = '285240640927706447' AND cp.name = u.name AND u.unk = '".UNK."' ";
				$resPageUser = mysql_db_query( DB , $sqlPageUser );
				$dataPageUser = mysql_fetch_array($resPageUser);
				
				if( $dataPageUser['type'] != "" ){
					$url = "http://www.10service.co.il/index.php?m=text&amp;t=".$dataPageUser['type']."";
					$txt = "הדף שלי בשירות 10";
				}
				else{
					$url = "http://www.10service.co.il/landing.php?ld=48";
					$txt = "לא מנוי בשירות הלידים";
				}
				
				echo "<tr height=20>";
					echo "<td width=\"1\"></td>";
					echo "<td align=center><a href=\"".$url."\" class=\"right_menu\" target=\"_blank\">".$txt."</td>";
				echo "</tr>";
				echo "<tr><td height=\"5\" ></td></tr>";
				
				if((false && $data_extra_settings['belongTo10service'] == "1") || UNK == "285240640927706447" )
				{
					echo "<tr>";
						echo "<td width=\"1\"></td>";
						echo "<td><a href=\"?main=List_View_Rows&type=deal_coupon&unk=".UNK."&sesid=".SESID."\" class=\"right_menu\" ".$this_link_text_deal_coupon."><img src='images/icons/setup.png' width=20 border=0 alt='' style='padding-left: 6px;'> דיל קופון</a></td>";
					echo "</tr>";
					echo "<tr><td height=\"5\" colspan=2></td></tr>";
					if( $_REQUEST['type'] == "deal_coupon" && agreement_have_2 == "1" )
					{
						echo $tat_main;
						echo "<tr><td height=\"5\" colspan=2></td></tr>";
					}
				}
				
				if( $data_extra_settings['belongTo10service'] == "1" && AUTH_ID == 0 )
				{
					echo "<tr>";
						echo "<td width=\"1\"></td>";
						echo "<td><a title='למידע נוסף' target='_new' href=\"http://www.10service.co.il/landing.php?ld=42\" class=\"right_menu\" ".$this_link_text_10service_product."> 
						<img src='images/icons/setup.png' width=20 border=0 alt='' style='padding-left: 6px;'>
						</a>
						<a href=\"?main=List_View_Rows&type=10service_product&unk=".UNK."&sesid=".SESID."\" class=\"right_menu\" ".$this_link_text_10service_product."> הדילים שלי</a></td>";
					echo "</tr>";
					echo "<tr><td height=\"5\" colspan=2></td></tr>";
					
					if( $_REQUEST['type'] == "10service_product" && agreement_have_2 == "1" )
					{
						echo $tat_main;
						echo "<tr><td height=\"5\" colspan=2></td></tr>";
					}
				}
				
				if( ($data_extra_settings['belongTo10service'] == "1" && AUTH_ID == 0) || UNK == "285240640927706447" )
				{
					echo "<tr>";
						echo "<td width=\"1\"></td>";
						echo "<td><a href=\"?main=purchase_tracking_list&type=purchase_tracking&unk=".UNK."&sesid=".SESID."\" class=\"right_menu\" ".$this_link_text_purchase_tracking."><img src='images/icons/admin.png' width=20 border=0 alt='' style='padding-left: 6px;'> מעקב הזמנות</a></td>";
					echo "</tr>";
					echo "<tr><td height=\"5\" colspan=2></td></tr>";
				}
				
				
				
				/*if( ($data_extra_settings['belongTo10service'] == "1" && AUTH_ID == 0) || UNK == "285240640927706447" )
				{
					echo "<tr><td height=\"7\" colspan=2></td></tr>";
					
					echo "<tr style='background-color: #E6E8E3;'>";
						echo "<td width=\"1\"></td>";
						echo "<td><a href=\"?main=List_View_Rows&type=group_buy&unk=".UNK."&sesid=".SESID."\" class=\"right_menu\" ".$this_link_text_List_View_Rows."><b>הנחות חברתיות בשירות 10</b></a></td>";
					echo "</tr>";
					
					if( $_REQUEST['type'] == "group_buy" )
						echo $tat_main;
				}
				
				
				if( ($data_extra_settings['belongTo10service'] == "1" && AUTH_ID == 0) || UNK == "285240640927706447" )
				{
					echo "<tr><td height=\"7\" colspan=2></td></tr>";
					
					echo "<tr style='background-color: #E6E8E3;'>";
						echo "<td width=\"1\"></td>";
						echo "<td><a href=\"?main=group_buy_sent_form&type=group_buy_sent&unk=".UNK."&sesid=".SESID."\" class=\"right_menu\" ".$this_link_text_group_buy_sent."><b>רשימת גולשים להנחות חברתיות</b></a></td>";
					echo "</tr>";
					
					if( $_REQUEST['type'] == "group_buy_sent" )
						echo $tat_main;
				}*/
				
				
				if( ($data_extra_settings['belongTo10service'] == "1" && AUTH_ID == 0) )
				{
					echo "<tr>";
						echo "<td width=\"1\"></td>";
						echo "<td><a href=\"?main=stat_summery_10service&type=stat_summery_10service&unk=".UNK."&sesid=".SESID."\" class=\"right_menu\" ".$this_link_text_stat_summery_10service."><img src='images/icons/stat.png' width=20 border=0 alt='' style='padding-left: 6px;'> סטטיסטיקות בשירות 10</a></td>";
					echo "</tr>";
					echo "<tr><td height=\"5\" colspan=2></td></tr>";
					/*
					echo "<tr>";
						echo "<td width=\"1\"></td>";
						echo "<td><a href=\"http://www.10service.co.il/landing.php?ld=58\" class=\"right_menu\" target='_blank'><img src='images/icons/setup.png' width=20 border=0 alt='' style='padding-left: 6px;'> שדרג דף לאתר</a></td>";
					echo "</tr>";
					*/
					echo "<tr><td height=\"5\" colspan=2></td></tr>";
					
				}
				
				
				//if( $data_extra_settings['belongTo10service'] == "1" )
				//{
					echo "<tr height=20>";
						echo "<td width=\"1\"></td>";
						echo "<td align=center>";
							echo right_menu_summery_leads();
						echo "</td>";
					echo "</tr>";
					echo "<tr><td height=\"5\" ></td></tr>";
				//}
				
				////////////////////
				// helpdesc - support
				////////////////////
				
				echo "<tr><td height=\"15\" ></td></tr>";
if( $data_domain['domain'] != "" )
{
				echo "<tr>";
					echo "<td width=\"1\"></td>";
					echo "<td align=center>";
						echo "
						<table border=\"0\" cellspacing=\"0\" cellpadding=\"0\" class=\"maintext\" align=\"right\" width=100%>
							<tr>
								<td align=center><a href='http://il-biz.co.il/בניית-אתרים-לעסקים/' target='_blank'><img src='".$http_s."://www.ilbiz.co.il/sn/images/il-biz_logo.jpg' border='0' alt='קידום עסקים באינטרנט'></a></td>
							</tr>
							<tr><tD height=3></td></tR>
			
							<tr>
								<td align=center style='text-decoration: none; color:#19274C; font-size: 14px; font-family: arial,sans-serif;'><a href='http://www.il-biz.com' style='text-decoration: none; color:#19274C; font-size: 14px; font-family: arial,sans-serif;' target='_blank' title='קידום עסקים באינטרנט'><b>קידום עסקים באינטרנט</b></a></td>
							</tr>
						</table>
						";
					echo "</td>";
				echo "</tr>";
				////////////////////
				
				echo "<tr><td height=\"5\" ></td></tr>";
					echo "<tr>";
						echo "<td width=\"1\"></td>";
						echo "<td>";
						if($data_domain['domain']!=""){
							echo "<a href=\"http://".$data_domain['domain']."\" class=\"right_menu\" target='_blank'>האתר שלי (".$data_domain['domain'].")</a>";
						}
						else{
							echo "<a href=\"http://il-biz.co.il/בניית-אתרים-לעסקים/\" class=\"right_menu\" target='_blank'>אין לך אתר אצלנו</a>";
						}
						echo "</td>";
					echo "</tr>";
				
				
				////////////////////
				// Homepage
				////////////////////
				
				if( UNK == "375411241406803999" )
				{
					echo "<tr><td height=\"5\" ></td></tr>";
					echo "<tr style='background-color: #E6E8E3;'>";
						echo "<td width=\"1\"></td>";
						echo "<td><a href=\"?main=getIfream&path=homePage__qikong&domain=develop&type=homepage&unk=".UNK."&sesid=".SESID."\" class=\"right_menu\" ".$this_link_text_homepage.">".$word[LANG]['rm_update_homepage']."</a></td>";
					echo "</tr>";
				}
				
				if( $data_have_hp['have_homepage'] == 1 && AUTH_ID == 0 )	{
					echo "<tr><td height=\"5\" ></td></tr>";
					echo "<tr style='background-color: #E6E8E3;'>";
						echo "<td width=\"1\"></td>";
						echo "<td><a href=\"?main=homepage&type=homepage&unk=".UNK."&sesid=".SESID."\" class=\"right_menu\" ".$this_link_text_homepage.">".$word[LANG]['rm_home']."</a></td>";
					echo "</tr>";
					
					if( $_REQUEST['type'] == "text" )
						echo $tat_main;
				}
				
				////////////////////
				// about us
				////////////////////
				
				if( $temp_word_about )	{
					echo "<tr><td height=\"5\" ></td></tr>";
					echo "<tr style='background-color: #E6E8E3;'>";
						echo "<td width=\"1\"></td>";
						echo "<td><a href=\"?main=text&type=text&unk=".UNK."&sesid=".SESID."\" class=\"right_menu\" ".$this_link_text_text.">".$temp_word_about."</a></td>";
					echo "</tr>";
					
					if( $_REQUEST['type'] == "text" )
						echo $tat_main;
					
					/*if( $data_extra_settings['estimateSite'] == "1" )
					{
						echo "<tr><td height=\"5\" ></td></tr>";
						echo "<tr style='background-color: #E6E8E3;'>";
							echo "<td width=\"1\"></td>";
							echo "<td><a href=\"?main=duplicateCityiesPages&type=duplicateCityiesPages&unk=".UNK."&sesid=".SESID."\" class=\"right_menu\" ".$this_link_text_duplicateCityiesPages.">יצירת דפי ערים</a></td>";
						echo "</tr>";
					}*/
				}
				
				
				
				////////////////////
				// articels
				////////////////////
				
				if( $temp_word_articels )	{
					echo "<tr><td height=\"7\" colspan=\"3\"></td></tr>";
					echo "<tr style='background-color: #E6E8E3;'>";
						echo "<td width=\"1\"></td>";
						echo "<td><a href=\"?main=List_View_Rows&type=articels&unk=".UNK."&sesid=".SESID."\" class=\"right_menu\" ".$this_link_text_articels.">".$temp_word_articels."</a></td>";
					echo "</tr>";
					
					if( $_REQUEST['type'] == "articels" || $_REQUEST['type'] == "articels_cat" )
						echo $tat_main;
				}
				
				
				////////////////////
				// products
				////////////////////
				
				if( $temp_word_products )	{
					echo "<tr><td height=\"7\" colspan=\"3\"></td></tr>";
					echo "<tr style='background-color: #E6E8E3;'>";
						echo "<td width=\"1\"></td>";
						echo "<td><a href=\"?main=List_View_Rows&type=products&unk=".UNK."&sesid=".SESID."\" class=\"right_menu\" ".$this_link_text_products." ".$this_link_text_products2.">".$temp_word_products."</a></td>";
					echo "</tr>";
					
					if( $_REQUEST['type'] == "products" || $_REQUEST['type'] == "products_cat" || $_REQUEST['type'] == "products_subject")
						echo $tat_main;
				}
				
				////////////////////
				// gallery images
				////////////////////
				
				if( $temp_word_gallery )	{
					echo "<tr><td height=\"7\" colspan=\"3\"></td></tr>";
					echo "<tr style='background-color: #E6E8E3;'>";
						echo "<td width=\"1\"></td>";
						echo "<td><a href=\"?main=gallery_grid&type=gallery&unk=".UNK."&sesid=".SESID."\" class=\"right_menu\" ".$this_link_text_gallery." ".$this_link_text_gallery2.">".$temp_word_gallery."</a></td>";
					echo "</tr>";
					
					if( $_REQUEST['type'] == "gallery" || $_REQUEST['type'] == "gallery_subject" || $_REQUEST['type'] == "gallery_cat" )
						echo $tat_main;
				}
				
				////////////////////
				// yad 2
				////////////////////
				
				if( $temp_word_yad2 )	{
					echo "<tr><td height=\"7\" colspan=\"3\"></td></tr>";
					echo "<tr style='background-color: #E6E8E3;'>";
						echo "<td width=\"1\"></td>";
						echo "<td><a href=\"?main=List_View_Rows&type=yad2&unk=".UNK."&sesid=".SESID."\" class=\"right_menu\" ".$this_link_text_yad2.">".$temp_word_yad2."</a></td>";
					echo "</tr>";
					
					if( $_REQUEST['type'] == "yad2" )
						echo $tat_main;
				}
				
				////////////////////
				// sales
				////////////////////
				
				if( $temp_word_sales )	{
					echo "<tr><td height=\"7\" colspan=\"3\"></td></tr>";
					echo "<tr style='background-color: #E6E8E3;'>";
						echo "<td width=\"1\"></td>";
						echo "<td><a href=\"?main=List_View_Rows&type=sales&unk=".UNK."&sesid=".SESID."\" class=\"right_menu\" ".$this_link_text_sales.">".$temp_word_sales."</a></td>";
					echo "</tr>";
					
					if( $_REQUEST['type'] == "sales" )
						echo $tat_main;
				}
				
				////////////////////
				// gallery video
				////////////////////
				
				if( $temp_word_video )	{
					echo "<tr><td height=\"7\" colspan=\"3\"></td></tr>";
					echo "<tr style='background-color: #E6E8E3;'>";
						echo "<td width=\"1\"></td>";
						echo "<td><a href=\"?main=List_View_Rows&type=video&unk=".UNK."&sesid=".SESID."\" class=\"right_menu\" ".$this_link_text_video.">".$temp_word_video."</a></td>";
					echo "</tr>";
					
					if( $_REQUEST['type'] == "video" || $_REQUEST['type'] == "video_cat" )
						echo $tat_main;
				}
				
				
				////////////////////
				// jobs
				////////////////////
				
				if( $temp_word_wanted )	{
					echo "<tr><td height=\"7\" colspan=\"3\"></td></tr>";
					echo "<tr style='background-color: #E6E8E3;'>";
						echo "<td width=\"1\"></td>";
						echo "<td><a href=\"?main=List_View_Rows&type=wanted&unk=".UNK."&sesid=".SESID."\" class=\"right_menu\" ".$this_link_text_wanted.">".$temp_word_wanted."</a></td>";
					echo "</tr>";
					
					if( $_REQUEST['type'] == "wanted" ){
						echo $tat_main;
						echo "<tr><td height=\"7\" colspan=\"3\"></td></tr>";
						echo "<tr style='background-color: #E6E8E3;'>";
							echo "<td width=\"1\"></td>";
							$this_link_text_wanted_filters = "";
							if(isset($_GET['edit'])){
								if($_GET['edit'] == "filters"){
									$this_link_text_wanted_filters = "style='color: #232323; text-decoration: underline;'";
								}
							}
							echo "<td style='background-color: #ffffff;'>&nbsp;&nbsp;&nbsp;&nbsp;<a href=\"?main=wanted&type=wanted&edit=filters&unk=".UNK."&sesid=".SESID."\" class=\"right_menu\" ".$this_link_text_wanted_filters.">מסננים</a></td>";
						echo "</tr>";
					}
				}
				
				
				////////////////////
				// goust book
				////////////////////
				
				if( $temp_word_gb && AUTH_ID == 0 )	{
					echo "<tr><td height=\"7\" colspan=\"3\"></td></tr>";
					echo "<tr style='background-color: #E6E8E3;'>";
						echo "<td width=\"1\"></td>";
						echo "<td><a href=\"?main=List_View_Rows&type=gb&unk=".UNK."&sesid=".SESID."\" class=\"right_menu\" ".$this_link_text_gb.">".$temp_word_gb."</a></td>";
					echo "</tr>";
					
					if( $_REQUEST['type'] == "gb" )
						echo $tat_main;
					}
					
				echo "<tr><td height=\"7\" colspan=\"3\"></td></tr>";
				echo "<tr style='background-color: #E6E8E3;'>";
					echo "<td width=\"1\"></td>";
					echo "<td><a href=\"http://".$data_domain['domain']."/stats/\" class=\"right_menu\" target='_blank'><img src='images/icons/stat.png' width=20 border=0 alt='' style='padding-left: 6px;'> סטטיסטיקות אתר</a></td>";
				echo "</tr>";


				echo "<tr><td height=\"7\" colspan=\"3\"></td></tr>";
				echo "<tr style='background-color: #E6E8E3;'>";
					echo "<td width=\"1\"></td>";
					echo "<td><a href=\"?main=manage_user_service_offers&scope=cat&unk=".UNK."&sesid=".SESID."\" class=\"right_menu\">מודול הצעות מחיר</a></td>";
				echo "</tr>";				
				////////////////////
				// headline - more tools
				////////////////////

				if( AUTH_ID == 0 )
				{
					echo "<tr><td height=\"17\" ></td></tr>";
					echo "<tr style='background-color: #D3D3D3;'>";
						echo "<td width=\"1\"></td>";
						echo "<td class=\"right_headline\">".$word[LANG]['rm_more_accessories']."</td>";
					echo "</tr>";
				}
				
				
				
				////////////////////
				// update cat's text on 10service homepage 
				////////////////////
				
				if( AUTH_ID == 0 )
				{
					if( UNK == "285240640927706447" )
					{
						echo "<tr><td height=\"7\" colspan=\"3\"></td></tr>";
						echo "<tr style='background-color: #E6E8E3;'>";
							echo "<td width=\"1\"></td>";
							echo "<td><a href=\"?main=updateCats10Servcats&type=updateCats10Servcats&unk=".UNK."&sesid=".SESID."\" class=\"right_menu\" ".$this_link_text_updateCats10Servcats.">עדכון טקסטים של קטגוריות</a></td>";
						echo "</tr>";
						
						echo "<tr><td height=\"7\" colspan=\"3\"></td></tr>";
						echo "<tr style='background-color: #E6E8E3;'>";
							echo "<td width=\"1\"></td>";
							echo "<td><a href=\"https://us2.admin.mailchimp.com/\" target='_blank' class=\"right_menu\">MailChimp</a></td>";
						echo "</tr>";
					}
				}
				
				
				////////////////////
				// run news
				////////////////////
				if( AUTH_ID == 0 )
				{
					if( UNK != "142565799492397124" )
					{
						echo "<tr><td height=\"7\" colspan=\"3\"></td></tr>";
						echo "<tr style='background-color: #E6E8E3;'>";
							echo "<td width=\"1\"></td>";
							echo "<td><a href=\"?main=List_View_Rows&type=news&unk=".UNK."&sesid=".SESID."\" class=\"right_menu\" ".$this_link_text_news.">".$word[LANG]['rm_new_running']."</a></td>";
						echo "</tr>";
						
						if( $_REQUEST['type'] == "news" )
							echo $tat_main;
					}
				}
				
				////////////////////
				// links menu
				////////////////////
				if( AUTH_ID == 0 )
				{
					echo "<tr><td height=\"7\" colspan=\"3\"></td></tr>";
					echo "<tr style='background-color: #E6E8E3;'>";
						echo "<td width=\"1\"></td>";
						echo "<td><a href=\"?main=more_link&type=more_link&unk=".UNK."&sesid=".SESID."\" class=\"right_menu\" ".$this_link_text_more_link.">".$word[LANG]['rm_link_side_menu']."</a></td>";
					echo "</tr>";
					
					if( $_REQUEST['type'] == "more_link" )
						echo $tat_main;
				}
				
				////////////////////
				// links top menu with sub catgory
				////////////////////
				
				if( $data_have_hp['have_topmenu'] == 1 && AUTH_ID == 0 )
				{
					echo "<tr><td height=\"7\" colspan=\"3\"></td></tr>";
					echo "<tr style='background-color: #E6E8E3;'>";
						echo "<td width=\"1\"></td>";
						echo "<td><a href=\"?main=topMenu_link&type=topMenu_link&unk=".UNK."&sesid=".SESID."\" class=\"right_menu\" ".$this_link_text_topMenu_link.">".$word[LANG]['rm_link_top_menu']."</a></td>";
					echo "</tr>";
					
					if( $_REQUEST['type'] == "topMenu_link" )
						echo $tat_main;
				}

				////////////////////
				// links bottom menu with sub catgory
				////////////////////
				
				if( $data_have_hp['have_topmenu'] == 1 && AUTH_ID == 0 )
				{
					echo "<tr><td height=\"7\" colspan=\"3\"></td></tr>";
					echo "<tr style='background-color: #E6E8E3;'>";
						echo "<td width=\"1\"></td>";
						echo "<td><a href=\"?main=bottomMenu_link&type=bottomMenu_link&unk=".UNK."&sesid=".SESID."\" class=\"right_menu\" ".$this_link_text_bottomMenu_link.">".$word[LANG]['rm_link_bottom_menu']."</a></td>";
					echo "</tr>";
					
					if( $_REQUEST['type'] == "bottomMenu_link" )
						echo $tat_main;
				}				
				////////////////////
				// desgein pages
				////////////////////
				
				if( UNK == "819413848591511341" && AUTH_ID == 0 )
				{
					echo "<tr><td height=\"7\" colspan=\"3\"></td></tr>";
					echo "<tr style='background-color: #E6E8E3;'>";
						echo "<td width=\"1\"></td>";
						echo "<td><a href=\"?main=List_View_Rows&type=design_page&unk=".UNK."&sesid=".SESID."\" class=\"right_menu\" ".$this_link_text_design_page.">".$word[LANG]['rm_pags_desgin']."</a></td>";
					echo "</tr>";
					
					if( $_REQUEST['type'] == "design_page" || $_REQUEST['type'] == "design_page_cat" )
						echo $tat_main;
				}
				
				////////////////////
				// site settings
				////////////////////
				
				if( AUTH_ID == 0 )
				{
					echo "<tr><td height=\"7\" colspan=\"3\"></td></tr>";
					echo "<tr style='background-color: #E6E8E3;'>";
						echo "<td width=\"1\"></td>";
						echo "<td><a href=\"?main=site_settings_form&type=site_setting&unk=".UNK."&sesid=".SESID."\" class=\"right_menu\" ".$this_link_text_site_setting.">".$word[LANG]['rm_site_settings']."</a></td>";
					echo "</tr>";
				}
				
				
				////////////////////
				// add new pages
				////////////////////
				
				if( AUTH_ID == 0 )
				{
					$sql_free_text = "select COUNT(id) as num_rows from content_pages where deleted = 0 and type != 'text' and type != 'contact' and unk = '".UNK."' order by id";
					$res_free_text = mysql_db_query(DB,$sql_free_text);
					$data_free_text = mysql_fetch_array($res_free_text);
					
					$temp_link_free_text = ( $data_free_text['num_rows'] < $data_have_hp['max_free_text'] ) ? $word[LANG]['rm_add_update_site'] : $word[LANG]['rm_update_website_pages'];
					
					echo "<tr><td height=\"7\" colspan=\"3\"></td></tr>";
					echo "<tr style='background-color: #E6E8E3;'>";
						echo "<td width=\"1\"></td>";
						echo "<td><a href=\"?main=List_View_Rows&type=update_pages&unk=".UNK."&sesid=".SESID."\" class=\"right_menu\" ".$this_link_text_update_pages.">".$temp_link_free_text."</a></td>";
					echo "</tr>";
						
						if( ( $_REQUEST['type'] == "update_pages" || $_REQUEST['type'] == "text_libs" ) && $data_free_text['num_rows'] < $data_have_hp['max_free_text'] )
							echo $tat_main;
				}
				
				
				////////////////////
				// update guides
				////////////////////

				if( AUTH_ID == 0 )
				{
					if( $data_extra_settings['indexSite'] == "1" )
					{
						echo "<tr><td height=\"7\" colspan=\"3\"></td></tr>";
						echo "<tr style='background-color: #E6E8E3;'>";
							echo "<td width=\"1\"></td>";
							echo "<td><a href=\"?main=List_View_Rows&type=guide&unk=".UNK."&sesid=".SESID."\" class=\"right_menu\" ".$this_link_text_guide." ".$this_link_text_guide_business." ".$this_link_text_guide_cats." ".$this_link_text_guide_cities." >מדריכים</a></td>";
						echo "</tr>";
						
						if( $_REQUEST['type'] == "guide" || $_REQUEST['type'] == "guide_business" || $_REQUEST['type'] == "guide_cats"  || $_REQUEST['type'] == "guide_cities" )
							echo $tat_main;
						
						
						echo "<tr><td height=\"7\" colspan=\"3\"></td></tr>";
						echo "<tr style='background-color: #E6E8E3;'>";
							echo "<td width=\"1\"></td>";
							echo "<td><a href=\"?main=List_View_Rows&type=banners_guide&unk=".UNK."&sesid=".SESID."\" class=\"right_menu\" ".$this_link_text_banners_guide." >באנרים</a></td>";
						echo "</tr>";
						
						if( $_REQUEST['type'] == "banners_guide" )
							echo $tat_main;
							
					}
				}
				
				
				if( UNK == "559357400644528143" )
				{
					echo "<tr><td height=\"7\" colspan=\"3\"></td></tr>";
					echo "<tr style='background-color: #E6E8E3;'>";
						echo "<td width=\"1\"></td>";
						echo "<td><a href=\"?main=List_View_Rows&type=einYahav&unk=".UNK."&sesid=".SESID."\" class=\"right_menu\" ".$this_link_text_einYahav." ".$this_link_text_einYahav_products." ".$this_link_text_einYahav_sizes." >מחירי מוצרים לפרסום</a></td>";
					echo "</tr>";
					
					if( $_REQUEST['type'] == "einYahav" || $_REQUEST['type'] == "einYahav_products" || $_REQUEST['type'] == "einYahav_sizes" )
						echo $tat_main;
				}
				
				
				if( $data_extra_settings['links_menu_more_settings_active'] == "1" )
				{
					echo "<tr><td height=\"7\" colspan=\"3\"></td></tr>";
					echo "<tr style='background-color: #E6E8E3;'>";
						echo "<td width=\"1\"></td>";
						echo "<td><a href=\"?main=link_menu_adv_settings&type=link_menu_adv_settings&unk=".UNK."&sesid=".SESID."\" class=\"right_menu\" ".$this_link_text_link_menu_adv_settings." >הגדרות מתקדמות לתפריט הקישורים הצידי</a></td>";
					echo "</tr>";
				}
				
				
				if( $data_extra_settings['have_realty'] == "1" )
				{
					echo "<tr><td height=\"7\" colspan=\"3\"></td></tr>";
					echo "<tr style='background-color: #E6E8E3;'>";
						echo "<td width=\"1\"></td>";
						echo "<td><a href=\"?main=List_View_Rows&type=realty&unk=".UNK."&sesid=".SESID."\" class=\"right_menu\" ".$this_link_text_realty." >רשימת נכנסים לתיווך</a></td>";
					echo "</tr>";
					
					if( $_REQUEST['type'] == "realty" )
					{
						echo $tat_main;
						echo "<tr><td height=\"5\" colspan=2></td></tr>";
					}
				}
				
				if( UNK == "625420717714095702" )
				{
					echo "<tr><td height=\"7\" colspan=2></td></tr>";
					
					echo "<tr style='background-color: #E6E8E3;'>";
						echo "<td width=\"1\"></td>";
						echo "<td><a href=\"?main=List_View_Rows&type=fmnUsers&unk=".UNK."&sesid=".SESID."\" class=\"right_menu\" ".$this_link_text_fmnUsers."><b>טפסי הצטרפות</b></a></td>";
					echo "</tr>";
					
					if( $_REQUEST['type'] == "fmnUsers" )
						echo $tat_main;
					
					echo "<tr><td height=\"7\" colspan=2></td></tr>";
					
					echo "<tr style='background-color: #E6E8E3;'>";
						echo "<td width=\"1\"></td>";
						echo "<td><a href=\"?main=List_View_Rows&type=usresTZ&unk=".UNK."&sesid=".SESID."\" class=\"right_menu\" ".$this_link_text_usresTZ."><b>רשימת ת.ז למקבלי הנחה</b></a></td>";
					echo "</tr>";
					
					if( $_REQUEST['type'] == "usresTZ" )
						echo $tat_main;
					
				}
				
}
				////////////////////
				// coustemrs network
				////////////////////
				
				if( UNK == "285240640927706447" )
				{
					echo "<tr><td height=\"7\" colspan=2></td></tr>";
					
					echo "<tr style='background-color: #E6E8E3;'>";
						echo "<td width=\"1\"></td>";
						echo "<td><a href=\"?main=suppliers_10service_list&type=suppliers_10service&unk=".UNK."&sesid=".SESID."\" class=\"right_menu\" ".$this_link_text_suppliers_10service."><b>ספקי שירות</b></a></td>";
					echo "</tr>";
				}
				
				
				
				if( $data_have_hp['have_ilbiz_net'] == "1" && AUTH_ID == 0 )
				{
					echo "<tr><td height=\"7\" colspan=2></td></tr>";
					
					echo "<tr style='background-color: #E6E8E3;'>";
						echo "<td width=\"1\"></td>";
						echo "<td><a href=\"?main=net_list&type=net&unk=".UNK."&sesid=".SESID."\" class=\"right_menu\" ".$this_link_text_net."><b>".$word[LANG]['rm_customer_club']."</b></a></td>";
					echo "</tr>";
					
					if( $_REQUEST['type'] == "net" )
						echo $tat_main;
					
					if( $data_extra_settings['haveMailingNet'] == "1" && AUTH_ID == 0 )
					{
					echo "<tr><td height=\"7\" colspan=2></td></tr>";
					
					echo "<tr style='background-color: #E6E8E3;'>";
						echo "<td width=\"1\"></td>";
						echo "<td><a href=\"?main=net_mailing&type=net_mailing&unk=".UNK."&sesid=".SESID."\" class=\"right_menu\" ".$this_link_text_net_mailing."><b>מערכת דיוור</b></a></td>";
					echo "</tr>";
					
					if( $_REQUEST['type'] == "net_mailing" )
						echo $tat_main;
					}
				}
				
				if( $data_extra_settings['haveLandingPage'] == "1" && AUTH_ID == 0 )
				{
					$sql = "select COUNT(id) as num_rows from sites_landingPage_settings where deleted = 0 AND unk = '".UNK."'";
					$res_max_landing = mysql_db_query(DB,$sql);
					$data_max_landing = mysql_fetch_array($res_max_landing);
					
					echo "<tr><td height=\"7\" colspan=2></td></tr>";
					
					echo "<tr style='background-color: #E6E8E3;'>";
						echo "<td width=\"1\"></td>";
						echo "<td><a href=\"?main=LandingPage&type=LandingPage&unk=".UNK."&sesid=".SESID."\" class=\"right_menu\" ".$this_link_text_LandingPage."><b>דפי נחיתה</b></a></td>";
					echo "</tr>";
					
					if( $_REQUEST['type'] == "LandingPage" && $data_max_landing['num_rows'] < $data_extra_settings['maxLandingPage'] )
						echo $tat_main;
				}
				
				
				
				////////////////////
				// shop settings
				////////////////////
				if( $data_have_hp['have_ecom'] == "1" && AUTH_ID == 0 )
				{
					echo "<tr><td height=\"7\" colspan=\"3\"></td></tr>";
					echo "<tr style='background-color: #E6E8E3;'>";
						echo "<td width=\"1\"></td>";
						echo "<td><a href=\"?main=ecom_settings&type=ecom_settings&unk=".UNK."&sesid=".SESID."\" class=\"right_menu\" ".$this_link_text_ecom_settings.">".$word[LANG]['rm_sotre_settings']."</a></td>";
					echo "</tr>";
				}
				
				////////////////////
				// order from shop
				////////////////////
				/*if( $data_have_hp['have_ecom'] == "1" && AUTH_ID == 0 )
				{
					echo "<tr><td height=\"7\" colspan=\"3\"></td></tr>";
					echo "<tr style='background-color: #E6E8E3;'>";
						echo "<td width=\"1\"></td>";
						echo "<td><a href=\"?main=ecomOrders&type=ecomOrders&unk=".UNK."&sesid=".SESID."\" class=\"right_menu\" ".$this_link_text_ecomOrders.">".$word[LANG]['rm_reservations_store']."</a></td>";
					echo "</tr>";
				}*/
				
				
				
				////////////////////
				// mailinglist
				////////////////////
				/*echo "<tr><td height=\"7\" colspan=\"3\"></td></tr>";
				echo "<tr style='background-color: #E6E8E3;'>";
					echo "<td width=\"1\"></td>";
					echo "<td><a href=\"?main=mailinglist&type=mailinglist&unk=".UNK."&sesid=".SESID."\" class=\"right_menu\" ".$this_link_text_mailinglist.">".$word[LANG]['rm_distribution_sys']."</a></td>";
				echo "</tr>";
				*/
				////////////////////
				// site registers
				////////////////////
if( $data_domain['domain'] != "" )
{
				if( AUTH_ID == 0 )
				{
					echo "<tr><td height=\"7\" colspan=\"3\"></td></tr>";
					echo "<tr style='background-color: #E6E8E3;'>";
						echo "<td width=\"1\"></td>";
						echo "<td><a href=\"?main=List_View_Rows&type=myClients&unk=".UNK."&sesid=".SESID."\" class=\"right_menu\" ".$this_link_text_myClients.">".$word[LANG]['rm_listed_on_the_site']."</a></td>";
					echo "</tr>";
				}
				
				////////////////////
				// edit profile
				////////////////////
				if( AUTH_ID == 0 )
				{
					echo "<tr><td height=\"7\" colspan=\"3\"></td></tr>";
					echo "<tr style='background-color: #E6E8E3;'>";
						echo "<td width=\"1\"></td>";
						echo "<td><a href=\"?main=update_profile&type=update_profile&unk=".UNK."&sesid=".SESID."\" class=\"right_menu\" ".$this_link_text_update_profile.">".$word[LANG]['rm_update_profile']."</a></td>";
					echo "</tr>";
				}
				elseif( UNK == "263512086634836547" )
				{
					echo "<tr><td height=\"7\" colspan=\"3\"></td></tr>";
					echo "<tr style='background-color: #E6E8E3;'>";
						echo "<td width=\"1\"></td>";
						echo "<td><a href=\"?main=update_profile&type=update_profile&unk=".UNK."&sesid=".SESID."\" class=\"right_menu\" ".$this_link_text_update_profile.">".$word[LANG]['rm_update_profile']."</a></td>";
					echo "</tr>";
				}
				
				
}
				
				////////////////////
				// Permissions system
				////////////////////
				
				if( $data_have_hp['have_users_auth'] == "1" && AUTH_ID == 0 )
				{
					echo "<tr><td height=\"7\" colspan=\"3\"></td></tr>";
					echo "<tr style='background-color: #E6E8E3;'>";
						echo "<td width=\"1\"></td>";
						echo "<td><a href=\"?main=site_authList&type=site_auth&unk=".UNK."&sesid=".SESID."\" class=\"right_menu\" ".$this_link_text_site_auth.">".$word[LANG]['rm_sys_privileges']."</a></td>";
					echo "</tr>";
					
					if( $_REQUEST['type'] == "site_auth" )
						echo $tat_main;
				}
if( $data_domain['domain'] != "" )
{
	if( AUTH_ID == 0 )
	{
		echo "<tr><td height=\"7\" colspan=\"3\"></td></tr>";
		echo "<tr style='background-color: #E6E8E3;'>";
			echo "<td width=\"1\"></td>";
			echo "<td><a href=\"?main=ftpAccount&type=ftpAccount&unk=".UNK."&sesid=".SESID."\" class=\"right_menu\" ".$this_link_text_ftpAccount.">אחסון קבצים</a></td>";
		echo "</tr>";
	}
}	
if(isset($premmissions_arr['edit_cats'])){
	if( AUTH_ID == 0 )
	{
		echo "<tr><td height=\"7\" colspan=\"3\"></td></tr>";
		echo "<tr style='background-color: #E6E8E3;'>";
			echo "<td width=\"1\"></td>";
			echo "<td><a href=\"?main=user_portal_cats&type=user_portal_cats&unk=".UNK."&sesid=".SESID."\" class=\"right_menu\" ".$this_link_text_user_portal_cats.">עדכון קטגוריות לאתר</a></td>";
		echo "</tr>";
	}	
	
}
if(isset($premmissions_arr['edit_cities'])){	
	if( AUTH_ID == 0 )
	{
		echo "<tr><td height=\"7\" colspan=\"3\"></td></tr>";
		echo "<tr style='background-color: #E6E8E3;'>";
			echo "<td width=\"1\"></td>";
			echo "<td><a href=\"?main=user_portal_newCities&type=user_portal_newCities&unk=".UNK."&sesid=".SESID."\" class=\"right_menu\" >שיוך לערים בארץ</a></td>";
		echo "</tr>";
	}	
}
if($data_extra_settings['have_contracts'] == '1'){
	echo "<tr><td height=\"7\" colspan=\"3\"></td></tr>";
	echo "<tr  style='background-color: #E6E8E3; font-weight:bold;'>";
		echo "<td width=\"1\"></td>";
		echo "<td><a style='font-size:18px;' href=\"?main=work_contracts&unk=".UNK."&sesid=".SESID."\" class=\"right_menu\">הסכמי עבודה</a></td>";
	echo "</tr>";
	echo "<tr  style='background-color: #ffffff; font-weight:bold;'>";
		echo "<td width=\"1\"></td>";
		echo "<td><a style='font-size:18px;' href=\"?main=work_contracts&editor=list&unk=".UNK."&sesid=".SESID."\" class=\"right_menu\">הסכמי עבודה ניהול חוזים</a></td>";
	echo "</tr>";
}

echo "<tr><td height=\"7\" colspan=\"3\"></td></tr>";				
echo "<tr>";
	echo "<td width=\"1\"></td>";
	echo "<td><a target='_blank' href=\"https://10card.co.il\" class=\"right_menu\"><img src='images/10Card_logo.png' width='149' border=0 alt='' style='padding-left: 6px;'></td>";
echo "</tr>";

echo "<tr><td height=\"7\" colspan=\"3\"></td></tr>";				
echo "<tr style='background-color: #E6E8E3; text-align:center;'>";
	echo "<td width=\"1\"></td>";
	echo "<td><a style='font-size:18px;' href=\"?main=manage_user_e_card&unk=".UNK."&sesid=".SESID."\" class=\"right_menu\">ניהול כרטיס</a></td>";
echo "</tr>";
echo "<tr><td height=\"7\" colspan=\"3\"></td></tr>";
echo "<tr  style='background-color: #ffffff; text-align:center;'>";
	echo "<td width=\"1\"></td>";
	echo "<td><a style='font-size:15px;' href=\"?main=List_View_Rows&type=e_card_forms&unk=".UNK."&sesid=".SESID."\" class=\"right_menu\">הודעות מלקוחות 10card</a></td>";
echo "</tr>";


echo "<tr><td height=\"7\" colspan=\"3\"></td></tr>";
if( AUTH_ID == 0 && false)
{
	echo "<tr><td height=\"7\" colspan=\"3\"></td></tr>";
	echo "<tr style='background-color: #E6E8E3;'>";
		echo "<td width=\"1\"></td>";
		echo "<td><a href=\"?main=site_301_redirections&type=site_301_redirections&unk=".UNK."&sesid=".SESID."\" class=\"right_menu\" >הפניות301</a></td>";
	echo "</tr>";
}				////////////////////


if( $data_domain['domain'] != "" )
{				
				echo "<tr><td height=\"17\" colspan=\"3\"></td></tr>";
				
				if( $data_have_hp['have_event_board'] == "1" && AUTH_ID == 0 )
				{
					echo "<tr style='background-color: #E6E8E3;'>";
						echo "<td width=\"1\"></td>";
						echo "<td><a href=\"diary.php?type=11&unk=".UNK."&sesid=".SESID."\" class=\"right_menu\" target='_blank'>".$word[LANG]['rm_calendar']."</a></td>";
					echo "</tr>";
					echo "<tr><td height=\"7\" colspan=\"3\"></td></tr>";
				}
				
				if( $data_have_hp['have_calender_events'] == "1" && AUTH_ID == 0 )
				{
					echo "<tr style='background-color: #E6E8E3;'>";
						echo "<td width=\"1\"></td>";
						echo "<td><a href=\"index.php?main=calender_events&unk=".UNK."&sesid=".SESID."\" class=\"right_menu\">".$word[LANG]['rm_events_site']."</a></td>";
					echo "</tr>";
					echo "<tr><td height=\"7\" colspan=\"3\"></td></tr>";
				}
				
				if( UNK == "335551847124265442" )
				{
					echo "<tr style='background-color: #E6E8E3;'>";
						echo "<td width=\"1\"></td>";
						echo "<td><a href=\"shapiroContactList/index.php?main=contantList&status=0&unk=".UNK."&sesid=".SESID."\" class=\"right_menu\">".$word[LANG]['rm_list_secure_forms']."</a></td>";
					echo "</tr>";
					echo "<tr><td height=\"7\" colspan=\"3\"></td></tr>";
				}
}


				//} // if AUTH_ID == 0
			echo "</table>";
		}
?>
		</td>
		<td width="20"></td>
		<td valign="top">
			<table border="0" cellspacing="0" cellpadding="0" class="right_menu" align="right">
				<tr>
					<td>
						<table border="0" cellspacing="0" cellpadding="0" class="right_menu">
							<tr>
								<?
								echo "<td><a href=\"?main=menu&unk=".UNK."&sesid=".SESID."\" class=\"right_menu\"><img src='images/icons/top_home.png' width=20 border=0 alt='' style='padding-left: 6px;'> ".$word[LANG]['rm_home_system_admin']."</a></td>";
								echo "<td width=15></td>";
								echo "<td><a href=\"/helpdesk/index.php?unk=".UNK."&sesid=".SESID."\" class=\"right_menu\" target=\"_blank\"><img src='images/icons/receptionist.png' width=20 border=0 alt='' style='padding-left: 6px;'> ".$word[LANG]['rm_support']."</a></td>";
								echo "<td width=15></td>";
								echo "<td><a href=\"http://il-biz.co.il/%D7%9E%D7%93%D7%A8%D7%99%D7%9A-%D7%9C%D7%A7%D7%99%D7%93%D7%95%D7%9D-%D7%90%D7%AA%D7%A8%D7%99%D7%9D-%D7%95%D7%94%D7%A6%D7%9C%D7%97%D7%94-%D7%91%D7%A2%D7%A1%D7%A7%D7%99%D7%9D/\" class=\"right_menu\" target=\"_blank\"><img src='images/icons/vid_galle.png' width=20 border=0 alt='' style='padding-left: 6px;'> המדריך להצלחה בעסקים</a></td>";
								echo "<td width=15></td>";
								echo "<td><a href=\"http://cms.ilbiz.co.il/\" class=\"right_menu\" target=\"_blank\"><img src='images/icons/setup.png' width=20 border=0 alt='' style='padding-left: 6px;'> מדריך ניהול אתר</a></td>";
				
								?>
							</tr>
						</table>
					</td>
				</tr>
				<tr>
					<td>
						<fieldset id="dims" style="color:#ffffff;  height:100%; background-color: #fafafa;">
			                <legend class="headline"><?=headline();?></legend>
							<table class="maintext" align="left" width="600">
								<tr><td height="5" colspan=3></td></tr>
								<tr>
									<td width="5"></td>
									<td>
		<!--	
			<ul>
			<li></li>
			<li></li>
			</ul>-->
											<?
											echo get_content($main);
											?>
											
									</td>
									<td width="5"></td>
								</tr>
								<tr><td height="5" colspan=3></td></tr>
			         </table>
					</fieldset>
				</td>
				</tr>
				

				
			</table>
		</td>
	</tr>
</table>



<?

	if( $main == "calender_events_edit" )
	{
		?>
<script type="text/javascript">
if (document.all) {
 document.writeln("<div id=\"PopUpCalendar\" style=\"position:absolute; left:0px; top:0px; z-index:7; width:200px; height:77px; overflow: visible; visibility: hidden; background-color: #FFFFFF; border: 1px none #000000\" onMouseOver=\"if(ppcTI){clearTimeout(ppcTI);ppcTI=false;}\" onMouseOut=\"ppcTI=setTimeout(\'hideCalendar()\',500)\">");
 document.writeln("<div id=\"monthSelector\" style=\"position:absolute; left:0px; top:0px; z-index:9; width:181px; height:27px; overflow: visible; visibility:inherit\">");}
else if (document.layers) {
 document.writeln("<layer id=\"PopUpCalendar\" pagex=\"0\" pagey=\"0\" width=\"200\" height=\"200\" z-index=\"100\" visibility=\"hide\" bgcolor=\"#FFFFFF\" onMouseOver=\"if(ppcTI){clearTimeout(ppcTI);ppcTI=false;}\" onMouseOut=\"ppcTI=setTimeout('hideCalendar()',500)\">");
 document.writeln("<layer id=\"monthSelector\" left=\"0\" top=\"0\" width=\"181\" height=\"27\" z-index=\"9\" visibility=\"inherit\">");}
else {
 document.writeln("<p><font color=\"#FF0000\"><b>Error ! The current browser is either too old or too modern (usind DOM document structure).</b></font></p>");}
</script>
<noscript><p><font color="#FF0000"><b>JavaScript is not activated !</b></font></p></noscript>
<table border="1" cellspacing="1" cellpadding="2" width="200" bordercolorlight="#000000" bordercolordark="#000000" vspace="0" hspace="0" dir=<?=$settings['dir'];?>><form name="ppcMonthList"><tr><td align="center" bgcolor="#D3D3D3"><a href="javascript:moveMonth('Back')" onMouseOver="window.status=' ';return true;"><font face="Arial, Helvetica, sans-serif" size="2" color="#000000"><b>< </b></font></a><font face="MS Sans Serif, sans-serif" size="1"> 
<select name="sItem" onMouseOut="if(ppcIE){window.event.cancelBubble = true;}" onChange="switchMonth(this.options[this.selectedIndex].value)" style="font-family: 'MS Sans Serif', sans-serif; font-size: 9pt"><option value="0" selected>2000 • January</option><option value="1">2000 • February</option><option value="2">2000 • March</option><option value="3">2000 • April</option><option value="4">2000 • May</option><option value="5">2000 • June</option><option value="6">2000 • July</option><option value="7">2000 • August</option><option value="8">2000 • September</option><option value="9">2000 • October</option><option value="10">2000 • November</option><option value="11">2000 • December</option><option value="0">2001 • January</option></select></font><a href="javascript:moveMonth('Forward')" onMouseOver="window.status=' ';return true;"><font face="Arial, Helvetica, sans-serif" size="2" color="#000000"><b> ></b></font></a></td></tr></form></table>
<table border="1" cellspacing="1" cellpadding="2" bordercolorlight="#000000" bordercolordark="#000000" width="200" vspace="0" hspace="0" dir=<?=$settings['dir'];?>><tr align="center" bgcolor="#D3D3D3"><td width="20"><b><font face="MS Sans Serif, sans-serif" size="1">א</font></b></td><td width="20"><b><font face="MS Sans Serif, sans-serif" size="1">ב</font></b></td><td width="20"><b><font face="MS Sans Serif, sans-serif" size="1">ג</font></b></td><td width="20"><b><font face="MS Sans Serif, sans-serif" size="1">ד</font></b></td><td width="20"><b><font face="MS Sans Serif, sans-serif" size="1">ה</font></b></td><td width="20"><b><font face="MS Sans Serif, sans-serif" size="1">ו</font></b></td><td width="20" bgcolor="#FFFFCC"><b><font face="MS Sans Serif, sans-serif" size="1">ש</font></b></td></tr></table>
<script language="JavaScript">
if (document.all) {
 document.writeln("</div>");
 document.writeln("<div id=\"monthDays\" style=\"position:absolute; left:0px; top:52px; z-index:8; width:200px; height:17px; overflow: visible; visibility:inherit; background-color: #FFFFFF; border: 1px none #000000\"> </div></div>");}
else if (document.layers) {
 document.writeln("</layer>");
 document.writeln("<layer id=\"monthDays\" left=\"0\" top=\"52\" width=\"200\" height=\"17\" z-index=\"8\" bgcolor=\"#FFFFFF\" visibility=\"inherit\"> </layer></layer>");}
else {/*NOP*/}
</script>
		<?
	}
		
?>

</body>


</html>