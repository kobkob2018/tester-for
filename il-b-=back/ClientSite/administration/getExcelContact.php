<?
require('../../global_func/vars.php');
require("/home/ilan123/domains/ilbiz.co.il/public_html/global_func/classes/class.lead.sys.php");
	
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
		$sql = "update login_trace set date = '".$page_expi."' where session_idd ='".$_REQUEST['sesid']."'";
		$res = mysql_db_query(DB,$sql);
	}
	else	{
		die;
	}
	
	$status = ( $_REQUEST['status'] == "" ) ? "0" :  $_REQUEST['status'];
	$deleted = ( $_REQUEST['deleted'] != "1" ) ? "0" :  "1";
	$deleted_status = ( $_REQUEST['deleted'] != "1" && $status != "s" ) ? " and status = '".$status."' " :  "";
	
	if( $status == "s" )
	{
		$ex = explode( "-" , $_GET['sd'] );
		$where = ($_GET['sd'] != "" ) ? " AND date_in >= '".$ex[2]."-".$ex[1]."-".$ex[0]."' " : "";
		$ex2 = explode( "-" , $_GET['ed'] );
		$where .= ($_GET['ed'] != "" ) ? " AND date_in <= '".$ex2[2]."-".$ex2[1]."-".$ex2[0]."' " : "";
		$where .= ($_GET['val'] != "" ) ? " AND ( ( name LIKE '%".mysql_r_e_s($_GET['val'])."%' ) OR ( content LIKE '%".mysql_r_e_s($_GET['val'])."%' ) )" : "";
		
		$array_s = $_GET['s'];
		$where_status="";
		if( is_array($array_s) )
		{
			
			foreach( $array_s as $key => $val )
			{
				$where_status .= ($array_s[$key] == "1" ) ? " status = '".$key."' OR" : "";
			}
		}
		if( $where_status != "" )
		{
			$where .= " AND (".substr( $where_status, 0, -2 ).")";
		}
		
		
	}
	
	// Send Header
	header("Content-Type: application/force-download");
  header("Content-Type: application/download");
	header("Content-Disposition: attachment; filename=\"contact list ".date(H)." ".date(i)." ".date(j)."-".date(M)."-".date(y).".xls\"");
  
	$sql = "select * from user_contact_forms where deleted = ".$deleted." and unk = '".UNK."' ".$deleted_status.$where." order by id";
	$result=mysql_db_query(DB,$sql);
	
	$lead = new leadSys();

	
  echo "ID\t";
  echo "Date\t";
  echo "Full name\t";
  echo "Email\t";
  echo "Phone\t";
  echo "Mobile\t";
  echo "Content\t";
  echo "Status\t";
  
  echo "\n";
  
		
		while($data=mysql_fetch_array($result))
		{
			
			echo $data['id']."\t";
			echo enco(stripslashes($data['date_in']))."\t";
			echo enco(stripslashes($data['name']))."\t";
			
			if( $lead->cheackLeadSentToContact(UNK) != 6 || ( !eregi("MySave", $data['name']) && !eregi("10service", $data['name']) && !eregi("uri4u", $data['name']) ) )
			{
				echo enco(stripslashes($data['email']))."\t";
				echo enco(stripslashes($data['phone']))."\t";
				echo enco(stripslashes($data['mobile']))."\t";
			}
			else
			{
				if( $data['payByPassword'] == "1" )
				{
					echo enco(stripslashes($data['email']))."\t";
					echo enco(stripslashes($data['phone']))."\t";
					echo enco(stripslashes($data['mobile']))."\t";
				}
				else
					echo "\t\t\t";
			}
			
			echo str_replace(array("\r\n", "\r", "\n")," ",enco(stripslashes($data['content'])))."\t";
			echo enco(stripslashes($data['status']))."\t";
			
			echo "\n";
		}
	exit;


function enco($str)
{
	return iconv("windows-1255", "UTF-8", $str);
}
