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
	
	
	
	$ex = explode( "-" , $_GET['sd'] );
	$where = ($_GET['sd'] != "" ) ? " AND ub.join_date >= '".$ex[2]."-".$ex[1]."-".$ex[0]."' " : "";
	$ex2 = explode( "-" , $_GET['ed'] );
	$where .= ($_GET['ed'] != "" ) ? " AND ub.join_date <= '".$ex2[2]."-".$ex2[1]."-".$ex2[0]."' " : "";
	
	$where .= ($_GET['val'] != "" ) ? " AND ( ( u.fname LIKE '%".mysql_r_e_s($_GET['val'])."%' ) OR ( u.lname LIKE '%".mysql_r_e_s($_GET['val'])."%' ) )" : "";
	
	
	// Send Header
	header("Content-Type: application/force-download");
  header("Content-Type: application/download");
	header("Content-Disposition: attachment; filename=\"Users list ".date(H)." ".date(i)." ".date(j)."-".date(M)."-".date(y).".xls\"");
  
  $sql = "SELECT CONCAT(u.fname, ' ' , u.lname) as full_name, u.date_in, u.birthday, u.city, u.id, ub.status, ub.join_date, u.mobile , u.email FROM net_users as u , net_users_belong as ub WHERE
		u.deleted=0 AND
		ub.net_user_id = u.id AND
		ub.unk = '".UNK."' ".$where." ";
	$result = mysql_db_query( DB, $sql );
	
	
  echo "ID\t";
  echo "Join Date\t";
  echo "Full name\t";
  echo "Birthday\t";
  echo "City\t";
  echo "Email\t";
  echo "Mobile\t";
  
  echo "\n";
  
		
		while($data=mysql_fetch_array($result))
		{
			$sql2 = "SELECT name FROM cities WHERE id = '".$data['city']."' ";
			$res2 = mysql_db_query( DB, $sql2 );
			$data2 = mysql_fetch_array($res2);
			
			$birthday = ( $data['birthday'] == "0000-00-00" ) ? "" : $data['birthday'];
			
			if( eregi( "0000-00-00" , $data['join_date'] ) )
				$join = $data['date_in'];
			else
				$join = $data['join_date'];
			
			echo $data['id']."\t";
			echo enco(stripslashes($join))."\t";
			echo enco(stripslashes($data['full_name']))."\t";
			echo enco($birthday)."\t";
			echo enco(stripslashes($data2['name']))."\t";
			echo enco(stripslashes($data['email']))."\t";
			echo enco(stripslashes($data['mobile']))."\t";
			
			echo "\n";
		}
	exit;


function enco($str)
{
	return iconv("windows-1255", "UTF-8", $str);
}
