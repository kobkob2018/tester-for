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


//check if the user login and if the session its ok
if( $_REQUEST['unk'] == "" || $_REQUEST['sesid'] == "" )	{
	echo "<script>alert('".$word[LANG]['must_connect']."')</script>";
	echo "<script>window.location.href='login.php';</script>";
		exit;
}

require('../../global_func/vars.php');
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
		
		$expiTime = time() + (1 * 24 * 60 * 60);

		$DB_time2 = date("YmdHis",$expiTime);
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

define('HTTP_PATH',"http://".$data_domain['domain']);
define('SERVER_PATH',"/home/ilan123/domains/".$data_domain['domain']."/public_html");

define('UNK',$_REQUEST['unk']);
define('SESID',$_REQUEST['sesid']);

$http_path = "http://".$data_domain['domain'];
$server_path = "/home/ilan123/domains/".$data_domain['domain']."/public_html";



// Class
require("../../global_func/DB.php");
require("../../global_func/global_functions.php");
require("../../global_func/class.phpmailer.php");
require("../../global_func/forms_creator.php");
require("../../global_func/new_images_resize.php");
include("fckeditor/fckeditor.php") ;

// functions
require('get_content.php');
require('general_functions.php');
require('functions.php');
require('site_settings_functions.php');
require('gallery_functions.php');
require('site_auth_functions.php');
require('net_functions.php');
require('calender_events_functions.php');
require('functions_10service.php');
require('functions_10.php');
require('functions_11.php');
require("/home/ilan123/domains/ilbiz.co.il/public_html/global_func/classes/class.ilbiz_net.php");
require("/home/ilan123/domains/ilbiz.co.il/public_html/global_func/classes/class.lead.sys.php");


$_SESSION['SESSIOSunk'] = UNK;
$_SESSION['SESSIOSN_domain'] = $data_domain['domain'];








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
	
	<?
	setcookie("COOCKIE_domain", "", time() - 3600);
	setcookie("COOCKIE_domain", $data_domain['domain'], time() + 3600 , "/" );
	
	if( $main == "calender_events_edit" )
		echo "<script src=\"http://www.ilbiz.co.il/global_func/scripts/calendar_pupdate.js\" type=\"text/javascript\"></script>";
	
	?>
	
	<script>
		function can_i_del()  {
			aa = confirm("<?=$word[LANG]['are_you_sure'];?>");
			if(aa == true)
				return true;
			else
				return false;
		}	
	</script>
	
	<style>
		body{
			BACKGROUND-COLOR: #ffffff;
		}
	</style>
</head>


<body leftmargin="0" topmargin="5" rightmargin="0" bottommargin="0" marginwidth="0" marginheight="0">

<table border="0" cellspacing="0" cellpadding="0" class="right_menu" dir="<?=$settings['dir'];?>" align="center">
	<tr>
		<td valign="top">
			<table border="0" cellspacing="0" cellpadding="0" class="right_menu" align="right">

				<tr>
					<td>
							<table class="maintext" align="left" width="600">
								<tr><td height="5" colspan=3></td></tr>
								<tr>
									<td width="5"></td>
									<td>
											<?
											echo get_content($main);
											?>
									</td>
									<td width="5"></td>
								</tr>
								<tr><td height="5" colspan=3></td></tr>
			         </table>
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
<table border="1" cellspacing="1" cellpadding="2" bordercolorlight="#000000" bordercolordark="#000000" width="200" vspace="0" hspace="0" dir=<?=$settings['dir'];?>><tr align="center" bgcolor="#D3D3D3"><td width="20"><b><font face="MS Sans Serif, sans-serif" size="1">à</font></b></td><td width="20"><b><font face="MS Sans Serif, sans-serif" size="1">á</font></b></td><td width="20"><b><font face="MS Sans Serif, sans-serif" size="1">â</font></b></td><td width="20"><b><font face="MS Sans Serif, sans-serif" size="1">ã</font></b></td><td width="20"><b><font face="MS Sans Serif, sans-serif" size="1">ä</font></b></td><td width="20"><b><font face="MS Sans Serif, sans-serif" size="1">å</font></b></td><td width="20" bgcolor="#FFFFCC"><b><font face="MS Sans Serif, sans-serif" size="1">ù</font></b></td></tr></table>
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

<script>
	window.print();
</script>