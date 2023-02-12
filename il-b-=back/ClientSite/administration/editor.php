<?php
/* 
* Copyright © 2006 ILbiz. All Rights Reserved
* email:	webmaster@ilbiz.co.il
* 
* its the index, the right menu, function for rigth menu,
* style, scripts and all the function that site required
*/

ob_start();

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
define('UNK',$_REQUEST['unk']);
require('/home/ilan123/domains/ilbiz.co.il/public_html/lang/administration.lang.'.$cookie_lang.'.php');


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



// Class
require("../../global_func/DB.php");
require("../../global_func/global_functions.php");
require("../../global_func/forms_creator.php");
require("../../global_func/new_images_resize.php");

require('get_content.php');
require('site_settings_functions.php');

load_editor_file();

// functions
require('general_functions.php');
require('functions.php');
require('gallery_functions.php');




$main = ( $_REQUEST['main'] == "" ) ? "menu" : $_REQUEST['main'];

?>
<html xmlns="http://www.w3.org/1999/xhtml">
<html>
<head>
	<meta HTTP-EQUIV='Content-Type' CONTENT='text/html; charset=windows-1255'/>
	<title>..::  עדכון תוכן  ::..</title>
	<script src="script.js" type="text/javascript"></script>
	
	
	<style>
		BODY	{
			BACKGROUND-COLOR: #eeeeee;
		}
		
		.right_headline	{
			color: #343434;
			font-family: sans-serif;
			font-size: 12px;
			text-decoration: none;
			font-weight: bold;
		}
		
		.right_menu	{
			color: #6b6b6b;
			font-family: sans-serif;
			font-size: 12px;
			text-decoration: none;
		}
		
		.right_menu a:link {text-decoration:none;color:#6b6b6b;}
		.right_menu a:active{text-decoration:underline;color:#000000;}
		.right_menu a:visited{text-decoration:none;color:#6b6b6b;}
		.right_menu a:hover{text-decoration:underline;color:#000000;}
		
		.maintext	{
			color: #000000;
			font-family: sans-serif;
			font-size: 12px;
			text-decoration: none;
		}

		.maintext a:link {text-decoration:underline;color:#000000;}
		.maintext a:active{text-decoration:underline;color:#000000;}
		.maintext a:visited{text-decoration:underline;color:#000000;}
		.maintext a:hover{text-decoration:underline;color:#000000;}
		
		.maintext_small	{
			color: #000000;
			font-family: sans-serif;
			font-size: 10px;
			text-decoration: none;
		}

		.maintext_small a:link {text-decoration:underline;color:#000000;}
		.maintext_small a:active{text-decoration:underline;color:#000000;}
		.maintext_small a:visited{text-decoration:underline;color:#000000;}
		.maintext_small a:hover{text-decoration:underline;color:#000000;}
		
		.headline	{
			color: #000000;
			font-family: sans-serif;
			font-size: 13px;
			text-decoration: none;
			font-weight: bold;
		}

		.input_style	{
			color: #000000;
			font-family: sans-serif;
			font-size: 12px;
			text-decoration: none;
			border-bottom: 1px solid #666666;
			border-top: 1px solid #666666;
			border-right: 1px solid #666666;
			border-left: 1px solid #666666;
			/**background-color: #eaeaea;*/
			background-color: #ffffff;
			width: 300px;
			height: 19px;
		}
		
		.textarea_style	{
			color: #000000;
			font-family: sans-serif;
			font-size: 12px;
			text-decoration: none;
			border-bottom: 1px solid #666666;
			border-top: 1px solid #666666;
			border-right: 1px solid #666666;
			border-left: 1px solid #666666;
			background-color: #ffffff;
			width: 450px;
			height: 250px;
		}
		
		.textarea_style_summary	{
			color: #000000;
			font-family: sans-serif;
			font-size: 12px;
			text-decoration: none;
			border-bottom: 1px solid #666666;
			border-top: 1px solid #666666;
			border-right: 1px solid #666666;
			border-left: 1px solid #666666;
			background-color: #ffffff;
			width: 450px;
			height: 100px;
		}
		
		.submit_style	{
			color: #000000;
			font-family: sans-serif;
			font-size: 12px;
			text-decoration: none;
			border-bottom: 1px solid #666666;
			border-top: 1px solid #666666;
			border-right: 1px solid #666666;
			border-left: 1px solid #666666;
			background-color: #ffffff;
			width: 100px;
			height: 19px;
		}
</style>
</head>
<script>
	function colors(name,page){
		popup = window.open("choose_color.php?page="+page+"&name="+name+"","","height=400,width=583,scrollbars=yes");
	}
	
	function AddText(AT)	{
		document.text_update_form.content.focus(); 
		document.selection.createRange().text=AT;
	}
	
	function can_i_del()  {
		aa = confirm("?האם את/ה בטוח/ה");
		if(aa == true)
			return true;
		else
			return false;
	}

</script>


<body leftmargin="0" topmargin="5" rightmargin="0" bottommargin="0" marginwidth="0" marginheight="0">

<table border="0" cellspacing="0" cellpadding="0" class="right_menu" dir="rtl" align="center" width='550'>
	<tr>
		<td valign="top">
<?
	$sql = "select * from user_".$_REQUEST['type']." where deleted = '0' and id = '".$_REQUEST['row_id']."' and unk = '".$_REQUEST['unk']."'";
	$res = mysql_db_query(DB,$sql);
	$data = mysql_fetch_array($res);
	
	echo "<table border=\"0\" cellspacing=\"0\" cellpadding=\"0\" class=\"maintext\" width='100%'>";
	echo "<form action=\"index.php\" name=\"editorhtml\" id=\"editorhtml\" method=\"POST\">";
	echo "<input type=\"hidden\" name=\"main\" value=\"update_new_row\">";
	echo "<input type=\"hidden\" name=\"type\" value=\"".$_REQUEST['type']."\">";
	echo "<input type=\"hidden\" name=\"record_id\" value=\"".$_REQUEST['row_id']."\">";
	echo "<input type=\"hidden\" name=\"table\" value=\"user_".$_REQUEST['type']."\">";
	if( $_REQUEST['type'] != "design_page" )
	echo "<input type=\"hidden\" name=\"data_arr[date_update]\" value=\"".GlobalFunctions::get_timestemp()."\">";
	echo "<input type=\"hidden\" name=\"unk\" value=\"".$_REQUEST['unk']."\">";
	echo "<input type=\"hidden\" name=\"sesid\" value=\"".$_REQUEST['sesid']."\">";
	echo "<input type=\"hidden\" name=\"from_editor\" value=\"1\">";
		
		load_editor_text( "data_arr[content]" , stripcslashes($data['content']) );
		
		echo "<tr><Td height=\"7\"></TD></tr>";
		echo "<tr>";
			echo "<td align=\"left\"><input type=\"submit\" value=\"שמירה\" class=\"submit_style\"></td>";
		echo "</tr>";
	
	echo "</form>";
	echo "</table>";
?>
		</td>
	</tr>
</table>

</body>
</html>