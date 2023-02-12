<?php
/*
 * * the page will send to the client sms, to remaind him to update a lead status at his lead system
 * * the cron will run every 24 hours in 09:00
 * todo:: for spd - please set up cron for file: /domains/ilbiz.co.il/public_html/site-admin/crons/check_leads_alerts.php to work every day at 09:00
 
 */
require ('../../global_func/vars.php');
require ('../../global_func/class.phpmailer.php');
require ('../../global_func/global_functions.php');


$sql = "SELECT unk FROM user_lead_settings WHERE leads_status_alert = '1'";
$res = mysql_db_query(DB,$sql);
$unk_in_arr = array();
$unk_sent = array();
while($data = mysql_fetch_array($res)){
	$unk_in_arr[] = "'".$data['unk']."'";
	$unk_sent[$data['unk']] = 0;
}	
if(empty($unk_in_arr)){
	exit("empty list!");
}
$unk_in = implode(",",$unk_in_arr);
$last_24 = date('Y-m-d H:i:s',strtotime('-24 hours'));
$last_48 = date('Y-m-d H:i:s',strtotime('-48 hours'));
$unk_in_sql = " AND unk IN($unk_in) ";
if(isset($_GET['test'])){
	//$unk_in_sql = " ";
}
$sql = "SELECT * FROM user_contact_forms WHERE 1 ".$unk_in_sql." AND status = '0' AND deleted = '0' AND tag = '0' AND date_in > '".$last_48."' AND date_in < '".$last_24."'";
//$sql = "SELECT * FROM user_contact_forms WHERE id = '450414' OR id = '450413'";
$res = mysql_db_query(DB,$sql);
while($lead = mysql_fetch_array($res)){

	$lead_unk = $lead['unk'];
	if(isset($unk_sent[$lead_unk])){
		if($unk_sent[$lead_unk] == 2){
			continue;
		}
		$unk_sent[$lead_unk]++;
	}
	else{
		continue;
	}
	
	$phone_sql = "SELECT phone FROM users WHERE unk = '".$lead['unk']."'";
	$phone_res = mysql_db_query(DB,$phone_sql);
	$phone_data = mysql_fetch_array($phone_res);
	if($phone_data['phone'] == ''){
		continue;
	}		
	$phone = $phone_data['phone'];
	$token = "";
	if($lead['auth_token'] != ""){
		$token = $lead['auth_token'];
	}
	else{
		$token = sha1(UNK.(time()));
		$update_token_sql = "UPDATE user_contact_forms SET auth_token = '".$token."' WHERE id = '".$lead['id']."'";
		$update_token_res = mysql_db_query(DB,$update_token_sql);
	}
	$msg = "לא עדכנת סטטוס ליד. \n 
	לחץ על הלינק הבא לכניסה למערכת ועדכון הליד
	https://ilbiz.co.il/myleads/?row_id=".$lead['id']."&token=".$token."";
	

	
	$msg = str_replace("'","''",$msg);
	$phone = str_replace("'","''",$phone);
	
	

		$param = "?get=1&uid=1565&un=ilbiz&msg=".urlencode($msg)."&charset=iso-8859-8&from=086233226&list=".$phone."&nu=http://mysave.co.il/other/smsLeadsSendStatus_alerts.php"; 
		$url = "http://www.micropay.co.il/ExtApi/ScheduleSms.php"; 
		$url_params = $url.$param;
		$curlSend = curl_init(); 
		
		curl_setopt($curlSend, CURLOPT_URL, $url_params); 
		curl_setopt($curlSend, CURLOPT_RETURNTRANSFER, 1); 
	
	$curlResult = curl_exec ($curlSend); 
	curl_close ($curlSend); 	

}
?>