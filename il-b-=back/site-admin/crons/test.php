<?php

$link_messege = "msg check: ";
	$msg = $link_messege;//urlencode(iconv("Windows-1255","UTF-8",$link_messege));
	$url = "http://www.micropay.co.il/ExtApi/ScheduleSms.php"; 
	$param = "?get=1&uid=1565&un=ilbiz&msg=".$msg."&charset=iso-8859-8&from=086233226&list=0542393397&nu=http://mysave.co.il/other/smsLeadsSendStatus.php"; 
	$curlSend = curl_init(); 
	
	curl_setopt($curlSend, CURLOPT_URL, $url.$param); 
	curl_setopt($curlSend, CURLOPT_RETURNTRANSFER, 1); 
	
	$curlResult = curl_exec ($curlSend); 
	curl_close ($curlSend);	

/*-----------------  WARNING!!!! --------------------*/
/*-----------------  WARNING!!!! --------------------*/
/*-----------------  WARNING!!!! --------------------*/
//this file will send SMS
/*
require ('../../global_func/vars.php');
$sql = "SELECT id,misscall_return_sms_txt
FROM `users_phones`
WHERE phone = '36449369'";
$res = mysql_db_query(DB,$sql);
$data = mysql_fetch_array($res);
	$url = "http://www.micropay.co.il/ExtApi/ScheduleSms.php";
	$phone = 'no-phone!!!';
	$msg = "check";  
	$msg =  iconv("windows-1255","UTF-8", $msg );

	$param = "?get=1&uid=1565&un=ilbiz&msg=".urlencode($msg)."&charset=iso-8859-8&from=086233226&list=".$phone."&nu=http://mysave.co.il/other/sms_misscal_return_msg.php"; 

	$curlSend = curl_init(); 
	$url_params = $url.$param;
	curl_setopt($curlSend, CURLOPT_URL, $url_params); 
	curl_setopt($curlSend, CURLOPT_RETURNTRANSFER, 1); 
	
	$curlResult = curl_exec ($curlSend); 
	curl_close ($curlSend);
	
	var_dump( $curlResult);
		
		*/