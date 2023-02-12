<?
require('../../global_func/vars.php');
	
	mysql_query("SET NAMES 'utf-8'");
 	header("Content-Type: application/vnd.ms-excel; charset=UTF-8");
 
	define('UNK',$_REQUEST['unk']);
	define('SESID',$_REQUEST['sesid']);
	
	//check if the user login and if the session its ok
	if( UNK == "" || SESID == "" )	{
		die;
	}
	
	
	// cheake when the session start and end 

	$sql = "select user,date from login_trace where session_idd ='".SESID."' and user = '".UNK."' ";
	$res = mysql_db_query(DB,$sql);
	$data_login_trace = mysql_fetch_array($res);
	
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
		$sql = "update login_trace set date = '".$page_expi."' where session_idd ='".SESID."'";
		$res = mysql_db_query(DB,$sql);
	}
	else	{
		die;
	}
	
	
	
	// Send Header
	header("Content-Type: application/force-download");
  header("Content-Type: application/download");
	header("Content-Disposition: attachment; filename=\"Users list ".date(H)." ".date(i)." ".date(j)."-".date(M)."-".date(y).".xls\"");
  
  $sql = "SELECT * , DATE_FORMAT(insert_date, '%d/%m/%Y') as newDate , DATE_FORMAT(birthday, '%d/%m/%Y') as newbirthday FROM custom_netanya_users WHERE
		deleted=0 AND
		unk = '".UNK."'";
	$result = mysql_db_query( DB, $sql );
	
	
  echo "ID\t";
  echo enco("תאריך הצטרפות")."\t";
  echo enco("שם פרטי")."\t";
  echo enco("שם משפחה")."\t";
  echo enco("תעודת זהות")."\t";
  echo enco("תאריך לידה")."\t";
 	echo enco("אימייל")."\t";
  echo enco("סלולרי")."\t";
  echo enco("כתובת")."\t";
  echo enco("עיר")."\t";
	echo enco("מיקוד")."\t";
	echo enco("תרומה חד פעמית על סך")."\t";
	echo enco("סוג חברות לעמותה")."\t";
	echo enco("אישור קבלת מידע שוטף באימייל בנושאי העמותה")."\t";
	echo enco("בעל מנוי?")."\t";
	echo enco("תרכוש מנוי גם בעונה הבאה")."\t";
	echo enco("מעוניין לקחת חלק פעיל בעמותה")."\t";
	
  echo "\n";
  
		
		while($data=mysql_fetch_array($result))
		{
			echo $data['id']."\t";
			echo enco(stripslashes($data['newDate']))."\t";
			echo enco(stripslashes($data['fname']))."\t";
			echo enco(stripslashes($data['lname']))."\t";
			echo enco(stripslashes($data['tz']))."\t";
			echo enco(stripslashes($data['newbirthday']))."\t";
			echo enco(stripslashes($data['email']))."\t";
			echo enco(stripslashes($data['mobile']))."\t";
			echo enco(stripslashes($data['address']))."\t";
			echo enco(stripslashes($data['city']))."\t";
			echo enco(stripslashes($data['zip']))."\t";
			
			echo enco(stripslashes($data['zip']))."\t";
			
			if( $data['ngo_type'] == "1" )	echo enco("חבר עמותה");
			elseif( $data['ngo_type'] == "2" )	echo enco("חבר עמותה צעיר");
			echo "\t";
			
			echo enco(stripslashes($data['ngo_price']))."\t";
			
			echo ( $data['check1'] == "0" ) ? enco("לא") : enco("כן");
			echo "\t";
			echo ( $data['check2'] == "0" ) ? enco("לא") : enco("כן");
			echo "\t";
			echo ( $data['check3'] == "0" ) ? enco("לא") : enco("כן");
			echo "\t";
			echo ( $data['check4'] == "0" ) ? enco("לא") : enco("כן");
			echo "\n";
		}
	exit;


function enco($str)
{
	return iconv("windows-1255", "UTF-8", $str);
}
