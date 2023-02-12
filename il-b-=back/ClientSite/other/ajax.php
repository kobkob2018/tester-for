<?php

$unkt = ( !empty($_GET['unk']) ) ? $_GET['unk'] : $_POST['unk'];
$sesidt = ( !empty($_GET['sesid']) ) ? $_GET['sesid'] : $_POST['sesid'];
define( "UNK" , $unkt );
define( "SES" , $sesidt );

//check if the user login and if the session its ok
if( UNK == "" || SES == "" )	{
	echo "<script>alert('יש להתחבר למערכת')</script>";
	echo "<script>window.location.href='/ClientSite/administration/login.php';</script>";
		exit;
}

require('/home/ilan123/domains/ilbiz.co.il/public_html/global_func/vars.php');

header('Content-Type: text/html; charset=windows-1255');  

	// cheake when the session start and end 
	$sql = "select user,date,ip from login_trace where session_idd = '".SES."' and user = '".UNK."'";
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
		
		
		$DB_time1 = mktime($hour, $minute+30, $secound, $month, $day,  $year);
		$DB_time2 = date("YmdHis",$DB_time1);
		
		$expi = mktime(date("H"), date("i"), date("s"), date("m"), date("d"),  date("Y"));
		$page_expi = date("YmdHis",$expi);
		
		// check the date that is -30 min
		if($DB_time2 > $page_expi)	{
			$sql = "update login_trace set date = '".$page_expi."' where session_idd ='".SES."'";
			$res = mysql_db_query(DB,$sql);
		}
		else	{
			echo "<script>alert('לא נגעת בכילי המערכת במשך 30 דקות, יש להתחבר שוב');</script>";
			echo "<script>window.location.href='/ClientSite/administration/login.php'</script>";
			exit;
		}
	}
	else
	{
		echo "<script>alert('יש להתחבר למערכת');</script>";
		echo "<script>window.location.href='/ClientSite/administration/login.php'</script>";
	}
	
	if( $data_login_trace['ip'] != $_SERVER['REMOTE_ADDR'] )
	{
		echo "<script>alert('התראת אבטחה מספר 4517 יש ליצור קשר עם ההנהלה, או לנסות להתחבר שנית');</script>";
		echo "<script>window.location.href='/ClientSite/administration/login.php'</script>";
		exit;
	}


// defined the domain of user
$sql = "select domain from users where unk = '".UNK."' and deleted = '0'";
$res_domain = mysql_db_query(DB,$sql);
$data_domain = mysql_fetch_array($res_domain);

define('HTTP_PATH',"http://".$data_domain['domain']);
define('SERVER_PATH',"/home/ilan123/domains/".$data_domain['domain']."/public_html");



require('/home/ilan123/domains/ilbiz.co.il/public_html/global_func/classes/class.helpdesk.php');
require('/home/ilan123/domains/ilbiz.co.il/public_html/global_func/global_functions.php');
require('/home/ilan123/domains/ilbiz.co.il/public_html/global_func/forms_creator.php');





		switch($_GET['main'])
		{
			// NEW help
			case "sendNewHelp" :						helpdesk::sendNewHelp();												break;
			case "InsertDataSucceed" :			helpdesk::InsertDataSucceed();									break;
			case "InsertData" :							helpdesk::InsertData();													break;
			
			
			case "newReply" :								helpdesk::messagList(1);											break;
			case "closeReply" :						break;
			
			
		}

?>