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
header('Content-Type: text/html; charset=utf-8');


//check if the user login and if the session its ok
if( $_REQUEST['unk'] == "" || $_REQUEST['sesid'] == "" )	{
	echo "<script>alert('יש להתחבר למערכת')</script>";
	echo "<script>window.location.href='../login.php';</script>";
		exit;
}

require('../../../global_func/vars.php');
mysql_query("SET NAMES 'utf8'");

	$sql = "select user,date,ip,auth_id from login_trace where session_idd = '".$_REQUEST['sesid']."' and user = '".$_REQUEST['unk']."'";
	$res = mysql_db_query(DB,$sql);
	$data_login_trace = mysql_fetch_array($res);
	
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
		
		$expiTime = time() + (1 * 1 * 30 * 60);

		$DB_time2 = date("YmdHis",$expiTime);
		$page_expi = date("YmdHis");
		
		// check the date that is -30 min
		if($DB_time2 > $page_expi)	{
			$sql = "update login_trace set date = '".$page_expi."' where session_idd ='".$_REQUEST['sesid']."'";
			$res = mysql_db_query(DB,$sql);
		}
		else	{
			echo "<script>alert('לא נגעת בכילי המערכת יותר מ 30 דקות, יש להתחבר למערכת');</script>";
			echo "<script>window.location.href='../login.php'</script>";
			exit;
		}
	}
	else
	{
		echo "<script>alert('יש להתחבר למערכת');</script>";
		echo "<script>window.location.href='../login.php'</script>";
	}
	
	if( $data_login_trace['ip'] != $_SERVER['REMOTE_ADDR'] )
	{
		echo "<script>alert('התראת אבטחה');</script>";
		echo "<script>window.location.href='../login.php'</script>";
		exit;
	}


define('UNK',$_REQUEST['unk']);
define('SESID',$_REQUEST['sesid']);


if( UNK != "335551847124265442" )
{
	echo "<script>alert('התראת אבטחה מספר 554211');</script>";
	echo "<script>window.location.href='../login.php'</script>";
		exit;
}



// Class
require("../../../global_func/DB.php");
require("../../../global_func/global_functions.php");
require("../../../global_func/class.phpmailer.php");
require("../../../global_func/forms_creator.php");
require("../../../global_func/new_images_resize.php");
include("../fckeditor/fckeditor.php") ;

// functions
require('get_content.php');
require('functions.php');


?>
<html xmlns="http://www.w3.org/1999/xhtml">
<html>
<head>
	<meta HTTP-EQUIV='Content-Type' CONTENT='text/html; charset=utf-8'/>
	<title>..:: מערכת ניהול - שפירו ::..</title>
	<script src="../script.js" type="text/javascript"></script>
	<link rel="stylesheet" href="../style.css" type="text/css">
	
</head>


<body leftmargin="0" topmargin="5" rightmargin="0" bottommargin="0" marginwidth="0" marginheight="0">

<table border="0" cellspacing="0" cellpadding="0" width=775 class="right_menu" dir="rtl" align="center">
	<tr>
		<td valign="top">
<?php
			echo "<table border=\"0\" cellspacing=\"0\" cellpadding=\"0\" width=\"150\" class=\"right_menu\" dir=\"rtl\" align=\"right\">";
				echo "<tr><td height=\"7\" colspan=\"3\"></td></tr>";
				echo "<tr style='background-color: #c7dbfa;' height=20>";
					echo "<td width=\"1\"></td>";
					echo "<td align=center><a href=\"../index.php?unk=".UNK."&sesid=".SESID."\" class=\"right_menu\" style='color: orange; font-size: 14px;'><b>חזרה למערכת ניהול</b></a></td>";
				echo "</tr>";
			echo "</table>";
?>
		</td>
		<td width="20"></td>
		<td valign="top">
			<table border="0" cellspacing="0" cellpadding="0" class="right_menu" align="right">

				<tr>
					<td>
						<fieldset id="dims" style="color:#ffffff; height:450; background-color: #fafafa;">
			      	<legend class="headline">רשימת טפסים מאובטחים</legend>
								<table class="maintext" align="left" width="600">
								<tr><td height="5" colspan=3></td></tr>
								<tr>
									<td width="5"></td>
									<td>
										<?
											echo get_content($_GET['main']);
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

</body>


</html>
