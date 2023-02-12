<?php

function link_select_sql($sql){
	$link_user = "sqluser6";
	$link_pass = "user6@1331";	
	$link_server = "62.90.6.141";
	$link_port = "3306";
	$link_server_with_port = $link_server.":".$link_port;
	$link_db = "test";
	

	$link_con = mysql_connect($link_server_with_port,$link_user, $link_pass);
	if (!$link_con) {
		die('Could not connect: ' . mysql_error());
	}
	mysql_select_db($link_db, $link_con);
	$link_result = mysql_query($sql);  
	$return_arr = array();
	while ($row = mysql_fetch_array($link_result)) {  
		$return_arr[] = $row;
	}  	
	mysql_close($link_con);
	return $return_arr;
}

function close_main_connect(){
	global $connect;
	mysql_close($connect);
}

function open_main_connect(){
	global $connect;
	$connect = mysql_connect(DB_SERVER,DB_USER,DB_PASS);	
	
}

//error_reporting(E_ALL);
//ini_set("display_errors", 1);

require ('../../global_func/vars.php');
require('/home/ilan123/domains/ilbiz.co.il/public_html/global_func/classes/class.estimate_stats.php');

$estimate_stats = new estimate_stats;

$last_lead_sql = "SELECT link_sys_id FROM sites_leads_stat WHERE answer = 'ANSWERED' ORDER BY link_sys_id desc LIMIT 1";
$last_lead_res = mysql_db_query(DB, $last_lead_sql);
$last_lead_arr = mysql_fetch_array($last_lead_res);
$last_lead_id_answered = $last_lead_arr['link_sys_id'];

$last_lead_sql = "SELECT link_sys_id FROM sites_leads_stat WHERE answer = 'NO ANSWER' ORDER BY link_sys_id desc LIMIT 1";
$last_lead_res = mysql_db_query(DB, $last_lead_sql);
$last_lead_arr = mysql_fetch_array($last_lead_res);
$last_lead_id_no_answer = $last_lead_arr['link_sys_id'];

$last_lead_sql = "SELECT link_sys_id FROM sites_leads_stat WHERE answer = 'MESSEGE' ORDER BY link_sys_id desc LIMIT 1";
$last_lead_res = mysql_db_query(DB, $last_lead_sql);
$last_lead_arr = mysql_fetch_array($last_lead_res);
$last_lead_id_messege = ($last_lead_arr['link_sys_id'] == "")?"0":$last_lead_arr['link_sys_id'];


close_main_connect();
$new_leads_arr = array();
$new_leads_res = link_select_sql("select * from in1331 WHERE CallId > $last_lead_id_answered");
foreach($new_leads_res as $lead){
	$lead['answer'] = "ANSWERED";
	$new_leads_arr[$lead['CallId']] = $lead;
}
$new_leads_ua_res = link_select_sql("select * from abdn1331 WHERE CallId > $last_lead_id_no_answer");
foreach($new_leads_ua_res as $lead){
	$lead['answer'] = "NO ANSWER";
	$lead['src'] = $lead['callerid'];
	$lead['dst'] = $lead['did'];
	$new_leads_arr[$lead['CallId']] = $lead;
}

$new_leads_msg_res = link_select_sql("select * from cb1331 WHERE CallId > $last_lead_id_messege");
foreach($new_leads_msg_res as $lead){
	$lead['answer'] = "MESSEGE";
	$lead['src'] = $lead['callerid'];
	$lead['dst'] = $lead['did'];
	$new_leads_arr[$lead['CallId']] = $lead;
}
open_main_connect();
$missing_dst = array();
$tracking_phones = array();
foreach ($new_leads_arr as $lead) {

	$dst = $lead['dst'];
	$did = $lead['did'];
	
	$campaign_type = '0';
	
	//search phone in users_phones by did(072) - connected to campaign types
	$sql = "select unk,campaign_type,campaign_name,bill_normal,misscall_return_sms,misscall_return_sms_txt,answeredcall_return_sms,answeredcall_return_sms_txt from users_phones where phone = '$did'";
	$res = mysql_db_query($db, $sql);
	$users = mysql_fetch_assoc($res);
	if(isset($users['campaign_type'])){
		$campaign_type = $users['campaign_type'];
	}	
	$campaign_name = '';
	if(isset($users['campaign_name'])){
		$campaign_name = $users['campaign_name'];
	}
	$bill_normal = true;
	if($users['bill_normal'] == '0'){
		$bill_normal = false;
	}
	$misscall_return_sms_arr = array('return_sms'=>'0','sms_txt'=>$users['misscall_return_sms_txt'],'phone'=>$lead['src']);
	if($lead['answer'] == "NO ANSWER" && $users['misscall_return_sms'] == '1'){
		$misscall_return_sms_arr['return_sms'] = '1';
	}

	$answeredcall_return_sms_arr = array('return_sms'=>'0','sms_txt'=>$users['answeredcall_return_sms_txt'],'phone'=>$lead['src']);
	if($lead['answer'] == "ANSWERED" && $users['answeredcall_return_sms'] == '1'){
		$answeredcall_return_sms_arr['return_sms'] = '1';
	}	
	//if not found by did, search in main phone at users table
	if (!isset($users) || empty($users)) {
		$sql = "select unk,id as uid from users where phone = '$dst'";
		$res = mysql_db_query($db, $sql);
		$users = mysql_fetch_assoc($res);
		//if not found, seach in users_phones by dst(finat destination), the did might not be connected to user yet
		if (!isset($users) || empty($users)) {
			$sql = "select unk from users_phones where phone = '$dst'";
			$res = mysql_db_query($db, $sql);
			$users = mysql_fetch_assoc($res);
		}
	}
	if (!isset($users) || empty($users)) {
		if(isset($missing_dst[$dst])){
			$missing_dst[$dst] = $missing_dst[$dst]+1;
			echo $dst."<br>";
		}
		else{
			$missing_dst[$dst] = 1;
		}
	}
	if (isset($users) && ! empty($users)) {

		$unk = $users['unk'];
		if(isset($users['uid'])){
			$uid = $users['uid'];
		}
		else{
			$sqlu = "select id from users where unk = '$unk'";
			$resu = mysql_db_query($db, $sqlu);
			$useru = mysql_fetch_assoc($resu);
			$uid = $useru['id'];	
		}		
		$src = $lead['src'];
		$dst = $lead['dst'];
		$answer = $lead['answer'];
		$sms_send = $lead['sms_sent'];
		$call_date = $lead['time'];
		$billsec = $lead['duration'];
		$uniqueid  = $lead['CallId'];
		$link_sys_identity = $lead['uniqueid'];
		$recordingfile  = $lead['filename'];
		$did = $lead['did'];
		$extra = "";
		if($answer == "MESSEGE"){
			$extra = $lead['number'];  
		}
		$sql = "insert into sites_leads_stat (unk, call_from, call_to,did, answer, sms_send, call_date,billsec,uniqueid,link_sys_id,link_sys_identity,recordingfile,extra) values('$unk', '$src', '$dst','$did', '$answer', '$sms_send', '$call_date','$billsec','0','$uniqueid','$link_sys_identity','$recordingfile','$extra')";
		$res = mysql_db_query($db, $sql);
		$insertId = mysql_insert_id();
		/*
			if($answer != "ANSWERED" || true){
				$mailSql = "SELECT email,name FROM users WHERE unk = '$unk'";
				$mailRes = mysql_db_query(DB,$mailSql);
				$mailData = mysql_fetch_array($mailRes);
				$biz_name = iconv("windows-1255","UTF-8", $mailData['name']);
				if($mailData['email'] != ""){
					$messege = "
						שם העסק: $biz_name\n
						זמן: $call_date\n
						טלפון: $src\n
						סטטוס: $answer
					";
					mail($mailData['email'],'incoming call from website',$messege);
				}
			}
		*/
		$estimate_data = array(
			'unk'=>$unk,
			'date_in'=>$call_date,
			'payByPassword'=>'1',
			'phone'=>$src,
			'estimateFormID'=>'0',
			'lead_recource'=>'phone',
			'lead_billed'=>'1',
			'lead_billed_id'=>'0',
			'phone_lead_id'=>$insertId,
			'phone_campaign_type'=>$campaign_type,
			'phone_campaign_name'=>$campaign_name,
			
		);
		$bill_sql = "SELECT id as billed_id FROM user_contact_forms WHERE phone = '".$estimate_data['phone']."' AND lead_billed = 1 AND unk = '".$estimate_data['unk']."' AND date_in > (CAST(DATE_FORMAT(NOW() ,'%Y-%m-01') as DATE)) LIMIT 1";
		$bill_res = mysql_db_query(DB,$bill_sql);	
		$bill_data = mysql_fetch_array($bill_res);
		if(isset($bill_data['billed_id'])){
			$estimate_data['lead_billed'] = '0';
			$estimate_data['lead_billed_id'] = $bill_data['billed_id'];
		}
		elseif(!$bill_normal){
			$estimate_data['lead_billed'] = '0';
		}
		else{
			$sql2 = "UPDATE user_lead_settings SET leadQry = leadQry - 1 WHERE unk = '".$unk."'";
			$res = mysql_db_query(DB,$sql2);
		}
		$vals_i = 0;
		$vals_str = "";
		$keys_str = "";
		foreach($estimate_data as $key=>$val){
			if($vals_i > 0){
				$vals_str .= ",";
				$keys_str .= ",";							
			}
			$vals_str .= "'".$val."'";
			$keys_str .= $key;		
			$vals_i++; 
		}
		
		
		$contact_form_sql = "INSERT INTO user_contact_forms (".$keys_str.") VALUES(".$vals_str.")";
		$contact_form_res = mysql_db_query(DB,$contact_form_sql);
		$contact_form_id = mysql_insert_id();
		$check_track_sql = "SELECT COUNT(id) as times_called_count FROM sites_leads_stat WHERE did='".$did."' AND call_from = '".$src."' AND id != ".$insertId."";
		$check_track_res = mysql_db_query(DB,$check_track_sql);
		$check_track_data = mysql_fetch_array($check_track_res);
		$tracked = "0";
		$times_called_count = $check_track_data['times_called_count'];
		if($times_called_count== '0'){
			 $tracked = "1";
		}
		else{
			$check_track_sql = "UPDATE sites_leads_stat SET times_called = ".$times_called_count." WHERE id = ".$insertId."";
			//$msg_to_email = "\n\n\n".$check_track_sql;
			$check_track_res = mysql_db_query(DB,$check_track_sql);
				
		}
		$tracking_phones[] = array("p"=>$did,"r"=>$insertId,"c"=>$contact_form_id,"t"=>$tracked,"tc"=>$times_called_count); 
		//'$did'
		$sql = "SELECT * FROM user_phone_api WHERE user_id = $uid AND phone IN('0','$did')";		
		$res = mysql_db_query(DB,$sql);
		$mail_msg = "";
		while($api_send = mysql_fetch_array($res)){
			$mail_msg.="\n".$api_send['api'];
			$api_send_url = $api_send['api'];
			if(!isset($lead['time'])){
				$lead['time'] = "";
			}
			foreach($lead as $search=>$replace){
				$api_send_url = str_replace("{".$search."}",$replace,$api_send_url);
			}
			foreach($estimate_data as $search=>$replace){
				$api_send_url = str_replace("{".$search."}",$replace,$api_send_url);
			}			
			$url_arr = explode("?",$api_send_url);
			$url = $url_arr[0];
			$params = "";
			for($i=1;$i<count($url_arr);$i++){
				if($i!=1){
					$params.="?";
				}
				$params.=$url_arr[$i];
			}
			
			$ch = curl_init(); 
			curl_setopt( $ch, CURLOPT_URL,$url ); 
			curl_setopt($ch, CURLOPT_HEADER, 0);
			curl_setopt( $ch, CURLOPT_POST, 1 ); 
			curl_setopt( $ch, CURLOPT_POSTFIELDS, $params ); 
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
			curl_setopt($ch, CURLOPT_FOLLOWLOCATION, TRUE);
			$resualt = curl_exec ($ch); 
			
			curl_close ($ch);
			
		}		
		$call_date_ex = explode(" " , $call_date);
		$call_date_hour_t = explode(":" , $call_date_ex[1]);
		$call_date_hour = ($call_date_hour_t[0]{0} == "0" ) ? $call_date_hour_t[0]{1} : $call_date_hour_t[0];
		
		$params_stats = array();
		$params_stats['receive_type'] = '1';
		$params_stats['date'] = $call_date_ex[0];
		$params_stats['hour'] = $call_date_hour;
		$params_stats['client_unk'] = $unk;
		$estimate_stats->update("2",$params_stats);
	}
	if($misscall_return_sms_arr['return_sms'] == '1'){
		$url = "http://www.micropay.co.il/ExtApi/ScheduleSms.php";
		$phone = $misscall_return_sms_arr['phone'];
		$msg = $misscall_return_sms_arr['sms_txt'];
		$msg = iconv("windows-1255","UTF-8",$msg);
		$param = "?get=1&uid=1565&un=ilbiz&charset=iso-8859-8&from=086233226&list=".$phone."&nu=http://mysave.co.il/other/sms_misscal_return_msg.php&msg=".urlencode($msg).""; 
		$curlSend = curl_init(); 
		$url_params = $url.$param;
		curl_setopt($curlSend, CURLOPT_URL, $url_params); 
		curl_setopt($curlSend, CURLOPT_RETURNTRANSFER, 1); 
		
		$curlResult = curl_exec ($curlSend); 
		curl_close ($curlSend); 
		if(strpos($curlResult, "OK") === false){
			mail("ilan@il-biz.com","sms after misscall not sent","please che phone:".$did."\n\n error messege:".$curlResult);
		}
	}


	if($answeredcall_return_sms_arr['return_sms'] == '1'){
		$url = "http://www.micropay.co.il/ExtApi/ScheduleSms.php";
		$phone = $answeredcall_return_sms_arr['phone'];
		$msg = $answeredcall_return_sms_arr['sms_txt'];
		$msg = iconv("windows-1255","UTF-8",$msg);
		$param = "?get=1&uid=1565&un=ilbiz&charset=iso-8859-8&from=086233226&list=".$phone."&nu=http://mysave.co.il/other/sms_misscal_return_msg.php&msg=".urlencode($msg).""; 
		$curlSend = curl_init(); 
		$url_params = $url.$param;
		curl_setopt($curlSend, CURLOPT_URL, $url_params); 
		curl_setopt($curlSend, CURLOPT_RETURNTRANSFER, 1); 
		
		$curlResult = curl_exec ($curlSend); 
		curl_close ($curlSend); 
		if(strpos($curlResult, "OK") === false){
			mail("ilan@il-biz.com","sms after answered call not sent","please che phone:".$did."\n\n error messege:".$curlResult);
		}
	}
	
}

if(!empty($tracking_phones)){
	$c_tracking_on = false;
	$c_track_sql = "SELECT c_tracking_on from main_settings";
	$c_track_res = mysql_db_query(DB,$c_track_sql);
	$c_track_data = mysql_fetch_array($c_track_res);
	if($c_track_data['c_tracking_on'] == '1'){
		$c_tracking_on = true;
	}
	else{
		return;
	}	
	$tracking_phones_json = json_encode($tracking_phones);
	
	$track_params = "?phones_tracked=".$tracking_phones_json;
	$track_url = "https://ilbiz.co.il/c_tracking/".$track_params;  
	$track_ch = curl_init(); 
	curl_setopt( $track_ch, CURLOPT_URL,$track_url ); 
	curl_setopt($track_ch, CURLOPT_HEADER, 0);
	curl_setopt( $track_ch, CURLOPT_POST, 1 ); 
	curl_setopt( $track_ch, CURLOPT_POSTFIELDS, $track_params ); 
	curl_setopt($track_ch, CURLOPT_RETURNTRANSFER, true);
	curl_setopt($track_ch, CURLOPT_FOLLOWLOCATION, TRUE);
	$resualt = curl_exec ($track_ch); 
	//mail("yacov.avr@gmail.com","check phones_37 ",$msg_to_email."\n\n\n\n".$tracking_phones_json."----".$resualt);  
	curl_close ($track_ch);
}

if(!empty($missing_dst)){
	$missing_str = "phones not belong to customerts: \n";
	foreach($missing_dst as $key=>$counter){
		$missing_str.= "\n missing: ".$key."($counter)";
	}
	mail("ilan@il-biz.com","phones without user",$missing_str);
}


//take all todays phone leads with campaign and check if they turned to form leads, then mark the form leads with same campaign 
$campaign_sql = "SELECT * FROM user_contact_forms WHERE lead_recource = 'phone' AND phone_campaign_type != '0' AND date_in > (CAST(DATE_FORMAT(NOW() ,'%Y-%m-%d') as DATE))";
$campaign_res = mysql_db_query(DB,$campaign_sql);	
while($campaign_data = mysql_fetch_array($campaign_res)){
	$idfrom = $campaign_data['id'];
	$phone = $campaign_data['phone'];
	$date_in = $campaign_data['date_in'];
	$type_update = $campaign_data['phone_campaign_type'];
	$date_in_arr = explode(" ",$date_in);
	$date_like = $date_in_arr[0];
	
	
	$form_sql = "SELECT * FROM user_contact_forms WHERE lead_recource = 'form' AND phone_campaign_type = '0' AND phone='$phone' AND date_in LIKE(\"%$date_like%\")";
	$form_res = mysql_db_query(DB,$form_sql);
	$lastestimateFormID = 0;
	while($form_data = mysql_fetch_array($form_res)){
		$form_id = $form_data['id'];
		$update_sql = "UPDATE user_contact_forms SET phone_campaign_type = '$type_update' WHERE id = $form_id";
		$update_res = mysql_db_query(DB,$update_sql);
		$estimateFormID = $form_data['estimateFormID'];
		if($estimateFormID != $lastestimateFormID && $estimateFormID != '0'){
			$lastestimateFormID = $estimateFormID;
			$update2_sql = "UPDATE estimate_form SET campaign_type = '$type_update' WHERE id = $estimateFormID AND campaign_type = '0'";
			$update2_res = mysql_db_query(DB,$update2_sql);
			//echo "====$update2_sql====";
		}
		echo $form_data['date_in'].":".$form_data['id'];
	}
	//echo "]";	
}

$custom_leads_sql = "SELECT * FROM sites_leads_stat_custom ";
$custom_leads_res = mysql_db_query(DB,$custom_leads_sql);	
while($custom_leads_data = mysql_fetch_array($custom_leads_res)){	
	$custom_id = $custom_leads_data['link_sys_identity'];
	$sql = "SELECT id FROM sites_leads_stat WHERE link_sys_identity = $custom_id";
	$res = mysql_db_query(DB,$sql);
	$data = mysql_fetch_array($res);
	if(isset($data['id'])){
		$sql2 = "SELECT id,unk FROM user_contact_forms WHERE phone_lead_id = ".$data['id']."";
		$res2 = mysql_db_query(DB,$sql2);
		$data2 = mysql_fetch_array($res2);
		if(isset($data2['id'])){
			$lead_id = $data2['id'];
			$unk = $data2['unk'];
			$comment = "system automatic";
			$mark_color = "#c9c9c9";
			$lead_by_phone = $custom_leads_data['phone_selected'];
			$check_sql = "SELECT * FROM misscalls_comments WHERE lead_id = $lead_id";
			$check_res = mysql_db_query(DB,$check_sql);
			$check_data = mysql_fetch_array($check_res);
			if($check_data['lead_id'] == ""){
				$update_sql = "INSERT INTO misscalls_comments(unk,lead_id,comment,last_comment_by_user,lead_by_phone,mark_color) values('".$unk."',$lead_id,'".$comment."','0','".$lead_by_phone."','".$mark_color."')";
			}
			else{
				$update_sql = "UPDATE misscalls_comments SET comment = '".$comment."',last_comment_by_user = '0',lead_by_phone='".$lead_by_phone."',mark_color = '".$mark_color."'  WHERE lead_id = $lead_id";
			}
			$update_res = mysql_db_query(DB,$update_sql);
			$custom_id = $custom_leads_data['id'];
			$delete_custom_leads_sql = "DELETE FROM sites_leads_stat_custom WHERE id = $custom_id";
			$delete_custom_leads_res = mysql_db_query(DB,$delete_custom_leads_sql);
		}
	}
}

$custom_leads_sql = "DELETE FROM sites_leads_stat_custom WHERE call_date < DATE_SUB( NOW( ) , INTERVAL 4 HOUR )";
$custom_leads_res = mysql_db_query(DB,$custom_leads_sql);