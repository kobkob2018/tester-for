<?php

error_reporting(E_ALL);
ini_set("display_errors", 1);
/**
 * ** need to make new table sites_leads_stat ***
 */
require ('../../global_func/vars.php');
require('/home/ilan123/domains/ilbiz.co.il/public_html/global_func/classes/class.estimate_stats.php');

  $contextOptions = array(
  'http' => array(
  'method' => 'GET',
  ),
 );

 $sslContext = stream_context_create($contextOptions);

$estimate_stats = new estimate_stats;

$allLeadsSend = array();
$response = file_get_contents("http://212.143.60.5/index.php?menu=monitoring&action=display_record&id=1479813140.15362&rawmode=yes",false,$sslContext);



echo $response;
exit("***");

$response = file_get_contents("http://212.143.60.5/index.php?menu=monitoring&action=display_record&id=1479813140.15362&rawmode=yes",false,$sslContext);
exit();
$leadsSendYesterday = unserialize($response);
foreach($leadsSendYesterday as $lead){
	$allLeadsSend[] = $lead;
}
$response = file_get_contents("http://212.143.60.5/reports/export_cdr.php?date=".date("Y-m-d",strtotime("today")),false,$sslContext);
$leadsSendToday = unserialize($response);
foreach($leadsSendToday as $lead){
	$allLeadsSend[] = $lead;
}
$leads_sql_in = "";
$leads_sql_in_i = 0;
foreach($allLeadsSend as $lead){
	if($leads_sql_in_i > 0){
		$leads_sql_in .= ", ";
		
	}
	$leads_sql_in .= "'".$lead['uniqueid']."'";
	$leads_sql_in_i++;
}
$checkSql = "SELECT uniqueid FROM sites_leads_stat WHERE uniqueid IN(".$leads_sql_in.")";
$checkRes = mysql_db_query($db, $checkSql);
$existingLeads = array();
while($checkData = mysql_fetch_array($checkRes)){
	$existingLeads[$checkData['uniqueid']] = 1;
}
$leadsSend = array();
foreach($allLeadsSend as $lead){
	if(!isset($existingLeads[$lead['uniqueid']])){
		$leadsSend[] = $lead;
	}
}

$users = array();

if (isset($leadsSend) && ! empty($leadsSend)) {
    foreach ($leadsSend as $leads) {
		$i = 0;
        foreach ($leads as $key => $val) {
			$i++;
            if ($key == 'dst') {
                
                $sql = "select unk from users where phone = '$val'";
                $res = mysql_db_query($db, $sql);
                $users = mysql_fetch_assoc($res);
                
                if ($i < 8) {
                    $unk = '344051510855310738';
                    $src = $leads['src'];
                    $dst = $leads['dst'];
                    $answer = $leads['disposition'];
                    $sms_send = $leads['sms_sent'];
                    $call_date = $leads['calldate'];
                    $billsec = $leads['billsec'];
					$uniqueid  = $leads['uniqueid'];
					$recordingfile  = $leads['recordingfile'];
                    
                    $sql = "insert into sites_leads_stat (unk, call_from, call_to, answer, sms_send, call_date,billsec,uniqueid,recordingfile) values('$unk', '$src', '$dst', '$answer', '$sms_send', '$call_date','$billsec','$uniqueid','$recordingfile')";
                    $res = mysql_db_query($db, $sql);
					$insertId = mysql_insert_id();

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
					);
					$bill_sql = "SELECT id as billed_id FROM user_contact_forms WHERE phone = '".$estimate_data['phone']."' AND lead_billed = 1 AND unk = '".$estimate_data['unk']."' AND date_in > (CAST(DATE_FORMAT(NOW() ,'%Y-%m-01') as DATE)) LIMIT 1";
					$bill_res = mysql_db_query(DB,$bill_sql);	
					$bill_data = mysql_fetch_array($bill_res);
					if(isset($bill_data['billed_id'])){
						$estimate_data['lead_billed'] = '0';
						$estimate_data['lead_billed_id'] = $bill_data['billed_id'];
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
            }
        }
    }
}

echo "*";