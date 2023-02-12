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
	$where = ($_GET['sd'] != "" ) ? " AND o.insert_date >= '".$ex[2]."-".$ex[1]."-".$ex[0]."' " : "";
	$ex2 = explode( "-" , $_GET['ed'] );
	$where .= ($_GET['ed'] != "" ) ? " AND o.insert_date <= '".$ex2[2]."-".$ex2[1]."-".$ex2[0]."' " : "";
	
	$where .= ($_GET['prod_val'] != "" ) ? " AND p.name LIKE '%".$_GET['prod_val']."%' " : "";
	
	$where .= ($_GET['s_id'] != "" ) ? " AND o.id = '".$_GET['s_id']."' " : "";
	
	// Send Header
	header("Content-Type: application/force-download");
  header("Content-Type: application/download");
	header("Content-Disposition: attachment; filename=\"Ecom Orders ".date(H)." ".date(i)." ".date(j)."-".date(M)."-".date(y).".xls\"");
  
  $sql = "select o.* FROM user_ecom_orders as o , user_ecom_items as i , user_products as p  WHERE 
		o.unk = '".$_REQUEST['unk']."' and 
		o.client_unickSes=i.client_unickSes AND
		o.unk=i.unk AND
		i.product_id=p.id AND
		o.deleted = '0' ".$where."
		GROUP BY o.id ORDER BY id DESC ";
	$result = mysql_db_query(DB,$sql);
	
	
  echo enco("מספר הזמנה")."\t";
  echo enco("תאריך")."\t";
  echo enco("שם מלא")."\t";
  echo enco("סך הכל שולם")."\t";
  echo enco("סטטוס")."\t";
  
  echo "\n";
  
		
		while($data=mysql_fetch_array($result))
		{
			
			$total_price_to_pay = 0;
			
			if( $data['netEcomSyncId'] != "0" )
			{
				$sql = "SELECT userSes from net_ecomCards_users_belong WHERE id = '".$data['netEcomSyncId']."' AND ecomSes = '".$data['client_unickSes']."' ";
				$resCleint = mysql_db_query(DB,$sql);
				$dataCleint2 = mysql_fetch_array($resCleint);
				
				$sql = "select id,CONCAT( fname, ' ' , lname) AS full_name from net_users where unick_ses = '".$dataCleint2['userSes']."'";
				$resCleint = mysql_db_query(DB,$sql);
				$dataCleint = mysql_fetch_array($resCleint);
			}
			else
			{
				$sql = "select id,full_name from user_clients where unk = '".UNK."' and id = '".$data['client_id']."'";
				$resCleint = mysql_db_query(DB,$sql);
				$dataCleint = mysql_fetch_array($resCleint);
			}
			
			$sql = "select product_id from user_ecom_items where unk = '".UNK."' and status=0 AND client_unickSes = '".$data['client_unickSes']."' GROUP BY product_id";
			$resItems = mysql_db_query(DB,$sql);
			
			while( $dataItems = mysql_fetch_array($resItems) )
			{
				$sql = "select price from user_products where id = '".$dataItems['product_id']."'";
				$resPrice = mysql_db_query(DB,$sql);
				$dataPrice = mysql_fetch_array($resPrice);
				
				$sql = "select id from user_ecom_items where unk = '".UNK."' and status=0 AND client_unickSes = '".$data['client_unickSes']."' and product_id = '".$dataItems['product_id']."'";
				$resQry = mysql_db_query(DB,$sql);
				$qry_nm = mysql_num_rows($resQry);
				
				$total_price_to_pay = $total_price_to_pay + ( $dataPrice['price'] * $qry_nm );
			}
			
			
			$work_status = ( $data['status'] == "0" ) ? "New order": "";
			$work_status = ( $data['status'] == "1" ) ? "Watting to Phone": $work_status;
			$work_status = ( $data['status'] == "2" ) ? "In treatment": $work_status;
			$work_status = ( $data['status'] == "3" ) ? "Close - watting for product": $work_status;
			$work_status = ( $data['status'] == "4" ) ? "Close - recive product": $work_status;
			$work_status = ( $data['status'] == "5" ) ? "Cancelled": $work_status;
			$work_status = ( $data['status'] == "6" ) ? "Not relevant": $work_status;
			
			
			echo $data['id']."\t";
			echo enco(stripslashes($data['insert_date']))."\t";
			echo enco(stripslashes($dataCleint['full_name']))."\t";
			echo enco($total_price_to_pay)."\t";
			echo enco($work_status)."\t";
			
			echo "\n";
		}
	exit;


function enco($str)
{
	return iconv("windows-1255", "UTF-8", $str);
}
