<?php
/* 
* Copyright © 2006 ILbiz. All Rights Reserved
* email: webmaster@ilbiz.co.il
*
*/

ob_start();

$sesid = ( !empty($_GET['sesid']) ) ? $_GET['sesid'] : $_POST['sesid'];

define('SESID',$sesid);

if( SESID == "" )	{
	echo "<script>alert('יש להתחבר למערכת')</script>";
	echo "<script>window.location.href='login.php';</script>";
		exit;
}


require('../global_func/vars.php');


// cheake when the session start and end 

	$sql = "select user,date,ip from login_trace where session_idd = '".SESID."'";
	$res = mysql_db_query(DB,$sql);
	$data_login_trace = mysql_fetch_array($res);
	
	if( $data_login_trace['user'] != "" )
	{
		$data_login_trace_temp = explode("-",$data_login_trace['date']);
		$year = $data_login_trace_temp[0];
		$month =$data_login_trace_temp[1];
		
		$data_login_trace_temp2 = explode(" ",$data_login_trace_temp[2]);
		$day = $data_login_trace_temp2[0];
		
		$data_login_trace_temp3 = explode(":",$data_login_trace_temp2[1]);
		$hour = $data_login_trace_temp3[0];
		$minute = $data_login_trace_temp3[1];
		$secound = $data_login_trace_temp3[2];
		
		
		$DB_time1 = mktime($hour+24, $minute, $secound, $month, $day,  $year);
		$DB_time2 = date("YmdHis",$DB_time1);
		
		$expi = mktime(date("H"), date("i"), date("s"), date("m"), date("d"),  date("Y"));
		$page_expi = date("YmdHis",$expi);
		
		// check the date that is -30 min
		if($DB_time2 > $page_expi)	{
			$sql = "update login_trace set date = '".$page_expi."' where session_idd ='".$_REQUEST['sesid']."'";
			$res = mysql_db_query(DB,$sql);
		}
		else	{
			echo "<script>alert('לא נגעת בכילי המערכת במשך 30 דקות, יש להתחבר שוב');</script>";
			echo "<script>window.location.href='login.php'</script>";
			exit;
		}
	}
	else
	{
		echo "<script>alert('יש להתחבר למערכת');</script>";
		echo "<script>window.location.href='login.php'</script>";
	}
	
	if( $data_login_trace['ip'] != $_SERVER['REMOTE_ADDR'] )
	{
		echo "<script>alert('התראת אבטחה מספר 4517 יש ליצור קשר עם ההנהלה, או לנסות להתחבר שנית');</script>";
		echo "<script>window.location.href='login.php'</script>";
		exit;
	}

define('OID',$data_login_trace['user']);

$sql = "select auth from sites_owner where id = '".OID."'";
$res_auth = mysql_db_query(DB,$sql);
$date_auth = mysql_fetch_array($res_auth);

define('AUTH',$date_auth['auth']);


// Class
require("../global_func/DB.php");
require("../global_func/global_functions.php");
require("../global_func/forms_creator.php");
require("../global_func/images_resize.php");

require('/home/ilan123/domains/ilbiz.co.il/public_html/global_func/classes/class.helpdesk.php');

include("/home/ilan123/domains/ilbiz.co.il/public_html/ClientSite/administration/fckeditor/fckeditor.php") ;



$main = ( $_REQUEST['main'] == "" ) ? "menu" : $_REQUEST['main'];


?>
<html>
<head>
	<meta HTTP-EQUIV='Content-Type' CONTENT='text/html; charset=windows-1255'/>
	<title>מערכת ניהול אתרים - שירות לקוחות</title>
	
	
	
	<style>
		.border1{
			border : 1px solid #000000;
		}
		
		.maintext	{
			color: #000000;
			font-family: sans-serif;
			font-size: 12px;
			text-decoration: none;
		}

		.maintext a:link {text-decoration:underline;color:navy;}
		.maintext a:active{text-decoration:underline;color:#800000;}
		.maintext a:visited{text-decoration:underline;color:navy;}
		.maintext a:hover{text-decoration:underline;color:#800000;}
		
		.headline	{
			color: #000000;
			font-family: sans-serif;
			font-size: 14px;
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
			background-color: #eaeaea;
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
			background-color: #eaeaea;
			width: 300px;
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
			background-color: #eaeaea;
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
			background-color: #eaeaea;
			width: 100px;
			height: 19px;
		}
	</style>
	<script>
		function can_i_del()  {
			aa = confirm("?האם את/ה בטוח/ה");
			if(aa == true)
				return true;
			else
				return false;
		}
		
		function moreDate(id1,id2)
		{
				obj = document.getElementById(id2).style.display;		
				document.getElementById(id2).style.display=(obj?"":"none")		
				
				if (obj)
					document.getElementById(id1).className='maintextBold';	
				else
					document.getElementById(id1).className='maintext';			
		}
	
	</script>
</head>

<body leftmargin="0" topmargin="10" rightmargin="0" bottommargin="0" marginwidth="0" marginheight="0">

<table border="0" cellspacing="0" cellpadding="0" align="center" dir="rtl">
	<tr>
		<td class="maintext"><a href='index.php?sesid=<?=SESID?>' class='maintext'>חזרה לתפריט</a></td>
	</tr>
	
	<tr><td height='10'></td></tr>
	<tr>
		<td>
			<?php
				echo helpdeskAdmin::TopSlice();
			?>	
		</td>
	</tr>
	
	<tr><td height='10'></td></tr>
	<tr>
		<td>
			<?php
				echo helpdeskAdmin::GOTO($main);
			?>	
		</td>
	</tr>
	
</table>

</body>
</html>
