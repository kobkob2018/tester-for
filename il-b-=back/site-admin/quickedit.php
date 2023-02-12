<?php

$return_result = array("success"=>'1',"msg"=>'',"err_msg"=>'',"user"=>null,"data"=>null);

$starttime = microtime();
$startarray = explode(" ", $starttime);
$starttime = $startarray[1] + $startarray[0];

$sesid = ( $_GET['sesid'] != "" ) ? $_GET['sesid'] : $_POST['sesid'];
define('SESID',$sesid);

if( SESID == "" ){
	$return_result['success'] = '0';
	$return_result['err_msg'] = iconv("UTF-8","Windows-1255",'יש להתחבר למערכת');
}

if($return_result['success'] == '1'){
	session_start();
	header('Content-Type: text/html; charset=windows-1255');  

	require('../global_func/vars.php');
	require("../global_func/global_functions.php");


	// cheake when the session start and end 

	$sql = "select user,date,ip from login_trace where session_idd = '".SESID."'";
	$res = mysql_db_query(DB,$sql);
	$data_login_trace = mysql_fetch_array($res);
	
	define('WORKERID',$data_login_trace['user']);
	
	if( $data_login_trace['user'] != "" )
	{
		$return_result['user'] = $data_login_trace;
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
			$return_result['success'] = '0';
			$return_result['err_msg'] = iconv("UTF-8","Windows-1255",'לא נגעת בכילי המערכת במשך 30 דקות, יש להתחבר שוב');
		}
	}
	else
	{
		$return_result['success'] = '0';
		$return_result['err_msg'] = iconv("UTF-8","Windows-1255",'יש להתחבר למערכת');
	}
	
	if( $data_login_trace['ip'] != $_SERVER['REMOTE_ADDR'] )
	{
		$return_result['success'] = '0';
		$return_result['err_msg'] = iconv("UTF-8","Windows-1255",'התראת אבטחה מספר 4517 יש ליצור קשר עם ההנהלה, או לנסות להתחבר שנית ----'.$data_login_trace['ip']." \n ".$_SERVER['REMOTE_ADDR'].''); 
	}
}
$use_params_in_main = array("success","msg","err_msg");
if($return_result['success'] == '1'){

	if(isset($_REQUEST['controller'])){
		require($_REQUEST['controller'].".php");
	}

	if(isset($_REQUEST['func'])){

		$func_eval = $_REQUEST['func'];
		$return_data = $func_eval();
		foreach($return_data['data'] as $key=>$val){
			$return_data['data'][$key] = iconv("Windows-1255","UTF-8",$val);
		}
		
		foreach($use_params_in_main as $param_key){
			if(isset($return_data[$param_key])){
				$return_result[$param_key] = $return_data[$param_key];
			}
		}
		$return_result['data'] = $return_data['data'];
	}
}
foreach($use_params_in_main as $key){
	$return_result[$key] = iconv("Windows-1255","UTF-8",$return_result[$key]);
}
//$encodedArray =  array_map(utf8_encode, $return_result);
echo json_encode($return_result);
exit();

