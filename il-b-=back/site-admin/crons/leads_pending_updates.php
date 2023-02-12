<?php
require_once ('../../global_func/vars.php');
require_once('/home/ilan123/domains/ilbiz.co.il/public_html/global_func/class.phpmailer.php');
require_once('/home/ilan123/domains/ilbiz.co.il/public_html/global_func/global_functions.php');
//mail("ilan@il-biz.com","cron check","cron was initiated!!!");
//mail("yacov.avr@gmail.com","cron check","cron was initiated!!!");
$unk_ok_to_send = array();
$pending_user_contact_forms_sql = "SELECT * FROM user_contact_forms WHERE send_type = 'pending' AND (show_time = '' OR show_time IS NULL)";
$pending_user_contact_forms_res = mysql_db_query(DB, $pending_user_contact_forms_sql);
echo "pending contact forms: <br/>";
while($pending_user_contact_form = mysql_fetch_array($pending_user_contact_forms_res)){
	echo $pending_user_contact_form['id']."<br/>";
	$user_unk = $pending_user_contact_form['unk'];
	if(!isset($unk_ok_to_send[$user_unk])){
		$unk_ok_to_send[$user_unk] = set_unk_ok_to_send($user_unk);
	}
	if($unk_ok_to_send[$user_unk]){
		$form_id = $pending_user_contact_form['id'];
		$update_sql = "UPDATE user_contact_forms SET show_time = NOW() WHERE id = $form_id";
		$update_res = mysql_db_query(DB,$update_sql);
		if($pending_user_contact_form['lead_billed'] == '1'){
			$leadqry_sql = "UPDATE user_lead_settings SET leadQry = leadQry - 1 WHERE unk = '".$user_unk."'";
			$leadqry_res = mysql_db_query(DB,$leadqry_sql);			
		}
	}
}

$pending_user_lead_sent_sql = "SELECT * FROM user_lead_sent_pending";
$pending_user_lead_sent_res = mysql_db_query(DB, $pending_user_lead_sent_sql);
while($pending_user_lead_sent = mysql_fetch_array($pending_user_lead_sent_res)){
	$user_unk = $pending_user_lead_sent['sendToUnk'];
	if(!isset($unk_ok_to_send[$user_unk])){
		$unk_ok_to_send[$user_unk] = set_unk_ok_to_send($user_unk);
	}
	if($unk_ok_to_send[$user_unk]){
		$lead_sent_sql = "INSERT INTO user_lead_sent ( estimateFormID, sendToUnk, sendBy, date ) values ( '".$pending_user_lead_sent['estimateFormID']."' , '".$pending_user_lead_sent['sendToUnk']."', '".$pending_user_lead_sent['sendBy']."', NOW())";
		$lead_sent_res = mysql_db_query(DB,$lead_sent_sql);
		$sentID = mysql_insert_id();
		$oldSentId = $pending_user_lead_sent['id'];
		$sms_update_sql = "UPDATE system_pending_sms SET sentID = $sentID WHERE sentID = $oldSentId";
		$sms_update_res = mysql_db_query(DB,$sms_update_sql);
		$pending_delete_sql = "DELETE FROM user_lead_sent_pending WHERE id = ".$pending_user_lead_sent['id']."";
		$pending_delete_res = mysql_db_query(DB,$pending_delete_sql);
	}
}

$system_pending_sms_sql = "SELECT * FROM system_pending_sms";
$system_pending_sms_res = mysql_db_query(DB, $system_pending_sms_sql);
while($system_pending_sms = mysql_fetch_array($system_pending_sms_res)){
	$user_unk = $system_pending_sms['sendToUnk'];
	if(!isset($unk_ok_to_send[$user_unk])){
		$unk_ok_to_send[$user_unk] = set_unk_ok_to_send($user_unk);
	}
	if($unk_ok_to_send[$user_unk]){
		$msg = $system_pending_sms['msg'];
		$phone = $system_pending_sms['phone'];
		$sentID = $system_pending_sms['sentID'];
		$url = "http://www.micropay.co.il/ExtApi/ScheduleSms.php"; 
		$param = "?get=1&uid=1565&un=ilbiz&msg=".urlencode($msg)."&charset=iso-8859-8&from=086233226&list=".$phone."&nu=http://mysave.co.il/other/smsLeadsSendStatus.php"; 
		
		$trans_id = sendPendingSmsByCurl($url.$param,$sentID);
		
		if( eregi( "OK" , $trans_id ) )
		{
			$trans_xp = explode( " " , $trans_id );
			
			$sql = "UPDATE user_lead_sent SET transID = '".$trans_xp[1]."' WHERE id = '".$sentID."'";
			$res = mysql_db_query(DB,$sql);
		}
		else{
			$sql = "UPDATE user_lead_sent SET viewedStatus = '3' WHERE id = '".$sentID."'";
			$res = mysql_db_query(DB,$sql);
		}
		$pending_delete_sql = "DELETE FROM system_pending_sms WHERE id = ".$system_pending_sms['id']."";
		$pending_delete_res = mysql_db_query(DB,$pending_delete_sql);
	}
}

$system_pending_email_sql = "SELECT * FROM system_pending_email";
$system_pending_email_res = mysql_db_query(DB, $system_pending_email_sql);
while($system_pending_email = mysql_fetch_array($system_pending_email_res)){
	$user_unk = $system_pending_email['sendToUnk'];
	if(!isset($unk_ok_to_send[$user_unk])){
		$unk_ok_to_send[$user_unk] = set_unk_ok_to_send($user_unk);
	}
	if($unk_ok_to_send[$user_unk]){
		
		$fromEmail = $system_pending_email['fromEmail'];
		$fromTitle = $system_pending_email['fromTitle'];
		$header_send_to_Client = $system_pending_email['header_send_to_Client'];
		$content_send_to_Client = $system_pending_email['content_send_to_Client'];
		$ClientMail = $system_pending_email['ClientMail'];
		GlobalFunctions::send_emails_with_phpmailer($fromEmail, $fromTitle, $header_send_to_Client, $content_send_to_Client, $content_send_to_Client, $ClientMail, $fromTitle );		
		$pending_delete_sql = "DELETE FROM system_pending_email WHERE id = ".$system_pending_email['id']."";
		$pending_delete_res = mysql_db_query(DB,$pending_delete_sql);
	}
}

function sendPendingSmsByCurl($url_params,$sentID)
{
	$curlSend = curl_init(); 
	
	curl_setopt($curlSend, CURLOPT_URL, $url_params); 
	curl_setopt($curlSend, CURLOPT_RETURNTRANSFER, 1); 
	
	$curlResult = curl_exec ($curlSend); 
	curl_close ($curlSend); 
	
	if (isset($curlResult) ) 
		return $curlResult; 
	else 
		return 0; 
}

function set_unk_ok_to_send($user_unk){
	echo "check unk: $user_unk - ";

	$ok_to_send = false;
	$user_lead_send_hours_sql = "SELECT * FROM user_lead_send_hours WHERE unk = '$user_unk'";
	$user_lead_send_hours_res = mysql_db_query(DB,$user_lead_send_hours_sql);
	$user_lead_send_hours_data = mysql_fetch_array($user_lead_send_hours_res);
	$user_send_lead_type = "send";
	if($user_lead_send_hours_data['display'] == "1"){
		$time_groups = json_decode($user_lead_send_hours_data['time_groups'],true);
		$wday = date('w');
		$now_day = $wday+1;
		$hour = date('H');
		$minute = date('i');
		$fit_time_found = false;
		foreach($time_groups as $time_group){
			if($fit_time_found){
				continue;
			}
			if(in_array($now_day,$time_group['cd'])){
				$time_off = false;
				if($hour < $time_group['hf']){
					$time_off = true;
				}
				elseif($hour == $time_group['hf']){
					if($minute < $time_group['mf']){
						$time_off = true;
					}
				}
				if(!$time_off){
					if($hour > $time_group['ht']){
						$time_off = true;
					}
					elseif($hour == $time_group['ht']){
						if($minute > $time_group['mt']){
							$time_off = true;
						}									
					}
				}
				if(!$time_off){
					$fit_time_found = true;
				}
			}
		}
		if($fit_time_found){
			$ok_to_send = true;
		}				
	}
	elseif($user_lead_send_hours_data['display'] == ""){
		$user_sql = "SELECT id FROM users WHERE unk = '$user_unk'";
		$user_res = mysql_db_query(DB,$user_sql);
		$user_data = mysql_fetch_array($user_res);
		if($user_data['id'] != ""){
			$ok_to_send = true;
		}
	}
	else{
		$ok_to_send = true;
	}
	if($ok_to_send){
		echo "ok";
	}
	else{
		echo "not yet";
	}
	echo "<br>";
	return $ok_to_send;
}
