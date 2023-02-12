<?php

	require('../../global_func/vars.php');
	
	mysql_query("SET NAMES 'utf-8'");
 
 
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
	
	if($DB_time2 > $page_expi)	{
		$sql = "update login_trace set date = '".$page_expi."' where session_idd ='".SESID."'";
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
	
	$sql = "select * from user_contact_forms where deleted = ".$deleted." and unk = '".UNK."' ".$deleted_status.$where." order by id";
	$result=mysql_db_query(DB,$sql);
	
	

	// Send Header
  header("Pragma: public");
  header("Expires: 0");
  header("Cache-Control: must-revalidate, post-check=0, pre-check=0"); 
  header("Content-Type: application/force-download");
  header("Content-Type: application/octet-stream");
  header("Content-Type: application/download");
  header("Content-Type: application/msexcel; charset=UTF-8; name=dd.xls");
  header("Content-Disposition: attachment;filename=dd.xls");
  header("Content-Transfer-Encoding: binary ");
  

  
	// XLS Data Cell
	
	xlsBOF(); 
		xlsWriteLabel(0,0,$sql);
		xlsWriteLabel(0,1,utf8_encode("תאריך"));
		xlsWriteLabel(0,2,enco("שם מלא"));
		xlsWriteLabel(0,3,iconv("UTF-8", "windows-1255","אימייל"));
		xlsWriteLabel(0,4,"טלפון");
		xlsWriteLabel(0,5,"&HA6");
		xlsWriteLabel(0,6,"&ugrave;&ugrave;&ugrave;");
		xlsWriteLabel(0,7,"%D7%AA%D7%AA%D7%AA");
		
		$xlsRow = 1;
		
		while($data=mysql_fetch_array($result))
		{
			++$i;
			
			xlsWriteNumber($xlsRow,0,$data['id']);
			xlsWriteLabel($xlsRow,2,enco(stripslashes($data['date_in'])));
			xlsWriteLabel($xlsRow,3,enco(stripslashes($data['name'])));
			xlsWriteLabel($xlsRow,4,enco(stripslashes($data['email'])));
			xlsWriteLabel($xlsRow,4,enco(stripslashes($data['phone'])));
			xlsWriteLabel($xlsRow,4,enco(stripslashes($data['mobile'])));
			xlsWriteLabel($xlsRow,4,enco(stripslashes($data['content'])));
			xlsWriteLabel($xlsRow,4,enco(stripslashes($data['status'])));
			
			$xlsRow++;
		}
	xlsEOF();
	
	exit;


function xlsBOF() { 
    echo pack("ssssss", 0x809, 0x8, 0x0, 0x10, 0x0, 0x0);  
    return; 
} 

function xlsEOF() { 
    echo pack("ss", 0x0A, 0x00); 
    return; 
} 

function xlsWriteNumber($Row, $Col, $Value) { 
    echo pack("sssss", 0x203, 14, $Row, $Col, 0x0); 
    echo pack("d", $Value); 
    return; 
} 

function xlsWriteLabel($Row, $Col, $Value ) { 
    $L = strlen($Value); 
    echo pack("ssssss", 0x204, 8 + $L, $Row, $Col, 0x0, $L); 
    echo $Value; 
return; 
} 

function enco($str)
{
	return iconv("windows-1255", "UTF-8", $str);
}