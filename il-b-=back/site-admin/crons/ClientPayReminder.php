<?php
/*
 * * the page will send to the client mail or something else, to remaind im to pay to domain / host
 * * the cron will run every 24 hours in 00:00
 *
 */
require ('../../global_func/vars.php');
require ('../../global_func/class.phpmailer.php');
require ('../../global_func/global_functions.php');

require ("../../global_func/classes/class.lead.sys.php");

define('ROUND_HALF_DOWN', 1);
define('ROUND_HALF_EVEN', 2);
define('ROUND_HALF_UP', 3);

$date_reported = date('m-Y', strtotime('-1 month', strtotime(date('Y-m-01'))));
$day_checked = date('d-m-Y');
//mail("yacov.avr@gmail.com","cron test for file ClientPayReminder.php at the date: ".$day_checked."","working fine");
if(isset($_GET['test'])){
	auto_user_contact_form();
	exit();
}

for ($type = 0; $type <= 2; $type ++) {
    for ($days = 0; $days <= 30; $days ++) {
        $continue = check_mkDate_continue($days);
		
		$mkDate = get_mkDate($days);
        $andemail = "  AND email!='' ";

        $anduemail = "  AND u.email!='' ";
		
        if ($continue == true) {
            if ($type == 0) // check hosting
			{
               $notest_sending = true; 
				if(isset($_GET['test'])){
					$notest_sending = false;
					if($days == 30){
						$notest_sending = true;
					}
					$sql = "SELECT unk,email,domain,full_name FROM users WHERE unk = '358388408164915383' AND deleted=0 AND status=0 $andemail";
					echo "<br>using test";
				}
				else{
					echo "<br>-----------------------------";
					$sql = "SELECT unk,email,domain,full_name FROM users WHERE end_date = '" . $mkDate . "' AND deleted=0 AND status=0 $andemail";
                }
				$usersRes = mysql_db_query(DB, $sql);

                while ($data = mysql_fetch_array($usersRes)) {
					if($notest_sending){
						// send email to client
						$temp1_params['type'] = $type;
						$temp1_params['days'] = $days;
						$temp1_params['unk'] = $data['unk'];
						$temp1_params['sendTOemail'] = $data['email'];
						$temp1_params['full_name'] = $data['full_name'];
						$temp1_params['domain'] = $data['domain'];
						send_email($temp1_params);
						
						// send email to ilan
						if ($days <= 5 || $days == 30  || $days == 14 ) {
							// send email to client
							$temp2_params['type'] = $type;
							$temp2_params['days'] = $days;
							$temp2_params['unk'] = $data['unk'];
							$temp2_params['sendTOemail'] = "ilan@il-biz.com";
							$temp2_params['full_name'] = $data['full_name'];
							$temp2_params['domain'] = $data['domain'];
							send_email($temp2_params);
						}
					}
                }
            } // END check hosting

            elseif ($type == 1) // check domain
			{
				$notest_sending = true; 
				if(isset($_GET['test'])){
					$notest_sending = false;
					if($days == 30){
						$notest_sending = true;
					}
					$sql = "SELECT ub.domainEndDate,u.unk,u.full_name,u.email, u.domain FROM user_bookkeeping as ub, users as u WHERE ub.unk=u.unk AND u.unk = '358388408164915383' AND u.deleted=0 AND u.status=0 $anduemail ";
					echo "<br>using domain test";
				}
				else{
					echo "<br>-----------------------------";
					$sql = "SELECT ub.domainEndDate,u.unk,u.full_name,u.email, u.domain FROM user_bookkeeping as ub, users as u WHERE ub.unk=u.unk AND ub.domainEndDate = '" . $mkDate . "' AND u.deleted=0 AND u.status=0 $anduemail ";
                }
                
                
                $resDOMAINS = mysql_db_query(DB, $sql);
               
                while ($data = mysql_fetch_array($resDOMAINS)) {
					if($notest_sending){
						// send email to client
						$temp1_params['type'] = $type;
						$temp1_params['days'] = $days;
						$temp1_params['unk'] = $data['unk'];
						$temp1_params['sendTOemail'] = $data['email'];
						$temp1_params['full_name'] = $data['full_name'];
						$temp1_params['domain'] = $data['domain'];
						send_email($temp1_params);
						
						// send email to ilan
						if ($days <= 5 || $days == 30  || $days == 14 ) {
							// send email to client
							$temp2_params['type'] = $type;
							$temp2_params['days'] = $days;
							$temp2_params['unk'] = $data['unk'];
							$temp2_params['sendTOemail'] = "ilan@il-biz.com";
							$temp2_params['full_name'] = $data['full_name'];
							$temp2_params['domain'] = $data['domain'];
							send_email($temp2_params);
						}
					}
                } // END check domain
            } elseif ($type == 2) { // check advertising
            }
            
        } // if continue
    } // for days
} // for type
if(isset($_GET['test'])){
	exit();
}
auto_advertising_send();
auto_user_contact_form();

/**
 * Function: auto_user_contact_form()
 * Description: Getting all the unk of users.
 * iterate through all the users.
 *
 * for each user:
 * build a string table.
 * query user_contact_forms table - by the user unk and and date right now and a month before - the user conact forms between the date of the date right now -1 , and the the day before a month.
 * validate if the email is fine
 */
 
function get_mkDate($days){
	return $mkDate = date("Y-m-d", mktime(0, 0, 0, date(m), date(d) + $days, date(Y)));	
}
 
function check_mkDate_continue($days){
	//return true;
	$days_to_check = array(
		"30","21","14","10","7","5","4","3","2","1","0"
	);
	if(in_array($days,$days_to_check)){
		return true;
	}
	return false;
}
function auto_user_contact_form()
{
	
	global $date_reported;
    $timestamp = time();
    
    if (date('j', $timestamp) == '1' || isset($_GET['test'])) { // Check if it's the first day on the month.
                                      // get only user that need to get the report.
        $sql = "SELECT DISTINCT u.unk,u.full_name, u.email,ub.leadPrice,ub.advReport from user_bookkeeping as ub inner join users as u on (u.unk = ub.unk) where ub.sendReport =1";
        $resUnk = mysql_db_query(DB, $sql);
        
        while ($dataBig = mysql_fetch_assoc($resUnk)) {  // loop over all the relevant users 
            $unk = $dataBig['unk'];
			$advanced_report = false;
			if($dataBig['advReport'] == '1'){
				$advanced_report = true;
			}
            $full_name = $name = iconv("windows-1255","utf-8",stripslashes($dataBig['full_name']));

			$lead_price = $dataBig['leadPrice'];
            $email = $data['email'];
            $leadCounter=0;
            $row_leads_arr = array();
			$leadCounter=0;
			$row_leads_arr = array();

			

			$total_form_leads = 0;
			
			$total_form_leads_paybypswd = 0;
			$total_form_leads_paybypswd_closed = 0;
			
			$total_form_leads_billed = 0;
			$total_form_leads_doubled = 0;
			$total_form_leads_refunded = 0;

			$total_phone_leads = 0;
			$total_phone_leads_paybypswd = 0;
			$total_phone_leads_paybypswd_closed = 0;
			$total_phone_leads_billed = 0;
			$total_phone_leads_doubled = 0;
			$total_phone_leads_refunded = 0;
			
			$total_to_pay = 0;
			$form_leads_arr = array();
			$phone_leads_arr = array();
			$form_leads_paybypswd_arr = array();
			$phone_leads_paybypswd_arr = array();
			$form_leads_doubled_arr = array();
			$phone_leads_doubled_arr = array();
			$doubled_phones_found_arr = array();
			$phones_found_arr = array();
			$sql_check_u1 = "SELECT  * FROM user_contact_forms WHERE unk = '" . $unk . "'  AND date_in >= DATE_FORMAT(CURRENT_DATE - INTERVAL 1 MONTH, '%Y-%m-01') AND date_in <= DATE_FORMAT(CURRENT_DATE, '%Y-%m-01')";
			$res_check_u1 = mysql_db_query(DB, $sql_check_u1);			
			while ($data_check_u1 = mysql_fetch_assoc($res_check_u1)) {
				$date_in = $data_check_u1['date_in'];
				$month_check_arr = explode("-",$date_in);
				$month_check = $month_check_arr[1];
				$data_check_u1['month_check'] = $month_check;
				if ($data_check_u1['lead_recource'] == 'form') {
					
					$form_leads_arr[] = $data_check_u1;
				}
				else{
					$phone_leads_arr[] = $data_check_u1;
				}
			}
			foreach($form_leads_arr as $form_lead){
				$total_form_leads++;
				$is_doubled = false;
				$doubled_found = false;
				
				$form_lead['opened_str'] = "לא";
				$form_lead['refunded_str'] = "לא";
				if($form_lead['payByPassword'] == '1'){
					$total_form_leads_paybypswd++;
					$form_lead['opened_str'] = "כן";
					if($form_lead['lead_billed'] == '1'){
						$total_form_leads_billed++;
						if(isset($phones_found_arr[$form_lead['month_check']][$form_lead['phone']])){
							
							$doubled_phones_found_arr[$form_lead['phone']] = $form_lead;
						}
						else{
							$phones_found_arr[$form_lead['month_check']][$form_lead['phone']] = $form_lead;
						}
					}
					else{
						if($form_lead['lead_billed_id'] != '' && $form_lead['lead_billed_id'] != '0'){
							
							$is_doubled = true;
							$total_form_leads_doubled++;
						}
						elseif($form_lead['payByPassword'] == "1" && $form_lead['estimateFormID'] == "0"){
							$total_form_leads_billed++;
						}
					}					
				}
				else{
					$total_form_leads_paybypswd_closed++;
					$form_lead['phone'] = "*****";
				}

				if($form_lead['status'] == '6'){
					$total_form_leads_refunded++;
					$form_lead['refunded_str'] = "כן";
				}
				
				if($is_doubled){
					$form_leads_doubled_arr[] = $form_lead;
				}
				else{
					$form_leads_paybypswd_arr[] = $form_lead;
				}
			}
			$total_form_leads_to_pay = $total_form_leads_billed - $total_form_leads_refunded;
			foreach($phone_leads_arr as $phone_lead){
				$total_phone_leads++;
				$is_doubled = false;
				$phone_lead['refunded_str'] = "לא";
				$phone_lead['opened_str'] = "לא";
				if($phone_lead['payByPassword'] == '1'){
					$total_phone_leads_paybypswd++;
					$phone_lead['opened_str'] = "כן";
					if($phone_lead['lead_billed'] == '1'){
						$total_phone_leads_billed++;
						if(isset($phones_found_arr[$phone_lead['month_check']][$phone_lead['phone']])){
							$doubled_phones_found_arr[$phone_lead['phone']] = $phone_lead;
						}
						else{
							$phones_found_arr[$phone_lead['month_check']][$phone_lead['phone']] = $phone_lead;
						}				
					}
					else{
						if($phone_lead['lead_billed_id'] != '' && $phone_lead['lead_billed_id'] != '0'){
							
							$is_doubled = true;
							$total_phone_leads_doubled++;
						}
						elseif($phone_lead['payByPassword'] == "1" && $phone_lead['estimateFormID'] == "0"){
							$total_phone_leads_billed++;
						}
					}					
				}
				else{
					$total_phone_leads_paybypswd_closed++;
					$phone_lead['phone'] = "*****";
				}

				if($phone_lead['status'] == '6'){
					$total_phone_leads_refunded++;
					$phone_lead['refunded_str'] = "כן";
				}
				
				if($is_doubled){
					$phone_leads_doubled_arr[] = $phone_lead;
				}
				else{
					$phone_leads_paybypswd_arr[] = $phone_lead;
				}
			}
			
			if($advanced_report){
				$customer_types_str = array("new"=>"חדש","new_back"=>"חדש חוזר","back"=>"קיים חוזר","shimur"=>"שימור");
				$customer_type_phones = array();
				$customer_types_count = array("new"=>0,"new_back"=>0,"back"=>0,"shimur"=>0);
				foreach($form_leads_paybypswd_arr as $key=>$lead){
					$lead['previous_sends'] = array();
					$phone_check = stripslashes(trim($lead['phone']));
					if($phone_check == ""){
						continue;
					}
					$sql_prev = "SELECT  * FROM user_contact_forms WHERE unk = '$unk'  AND phone = '$phone_check' AND id != ".$lead['id']."";
					$res_prev = mysql_db_query(DB, $sql_prev);			
					while ($prev_lead = mysql_fetch_assoc($res_prev)){
						$lead['previous_sends'][] = $prev_lead;
					}	
					$lead['previous_imports'] = array();
					$sql_prev = "SELECT  * FROM private_contacts_imports WHERE unk = '$unk'  AND phone = '$phone_check'";
					$res_prev = mysql_db_query(DB, $sql_prev);			
					while ($prev_lead = mysql_fetch_assoc($res_prev)){
						$prev_lead['shimur'] = "shimur";
						$prev_lead_date = $prev_lead['update_time'];
						$sql_shimur = "SELECT * FROM user_contact_forms WHERE  unk = '$unk' AND phone = '$phone_check' AND date_in BETWEEN '$prev_lead_date' AND DATE_ADD('$prev_lead_date', INTERVAL 4 MONTH) LIMIT 1";
						$res_shimur = mysql_db_query(DB, $sql_shimur);			
						while ($shimur_lead = mysql_fetch_assoc($res_shimur)){
							$prev_lead['shimur'] = "back";
						}
						$lead['previous_imports'][] = $prev_lead;
					}
					if(!isset($customer_type_phones[$lead['phone']])){
						$customer_type_phones[$lead['phone']] = "new";
						if(!empty($lead['previous_sends'])){
							$customer_type_phones[$lead['phone']] = "new_back";
						}
						if(!empty($lead['previous_imports'])){
							$customer_type_phones[$lead['phone']] = $lead['previous_imports'][0]['shimur'];
						}
						$customer_types_count[$customer_type_phones[$lead['phone']]]++;
					}
					$form_leads_paybypswd_arr[$key] = $lead;
				}
				foreach($phone_leads_paybypswd_arr as $key=>$lead){
					$phone_check = stripslashes(trim($lead['phone']));
					if($phone_check == ""){
						continue;
					}
					$lead['previous_sends'] = array();
					$sql_prev = "SELECT  * FROM user_contact_forms WHERE unk = '$unk'  AND phone = '$phone_check' AND id != ".$lead['id']."";
					$res_prev = mysql_db_query(DB, $sql_prev);			
					while ($prev_lead = mysql_fetch_assoc($res_prev)){
						$lead['previous_sends'][] = $prev_lead;
					}	
					$lead['previous_imports'] = array();
					$sql_prev = "SELECT  * FROM private_contacts_imports WHERE unk = '$unk'  AND phone = '$phone_check'";
					$res_prev = mysql_db_query(DB, $sql_prev);			
					while ($prev_lead = mysql_fetch_assoc($res_prev)){
						$prev_lead['shimur'] = "shimur";
						$prev_lead_date = $prev_lead['update_time'];
						$sql_shimur = "SELECT * FROM user_contact_forms WHERE  unk = '$unk' AND phone = '$phone_check' AND date_in BETWEEN '$prev_lead_date' AND DATE_ADD('$prev_lead_date', INTERVAL 4 MONTH) LIMIT 1";
						$res_shimur = mysql_db_query(DB, $sql_shimur);			
						while ($shimur_lead = mysql_fetch_assoc($res_shimur)){
							$prev_lead['shimur'] = "back";
						}
						$lead['previous_imports'][] = $prev_lead;
					}
					if(!isset($customer_type_phones[$lead['phone']])){
						$customer_type_phones[$lead['phone']] = "new";
						if(!empty($lead['previous_sends'])){
							$customer_type_phones[$lead['phone']] = "new_back";
						}
						if(!empty($lead['previous_imports'])){
							$customer_type_phones[$lead['phone']] = $lead['previous_imports'][0]['shimur'];
						}
						$customer_types_count[$customer_type_phones[$lead['phone']]]++;
					}
					$phone_leads_paybypswd_arr[$key] = $lead;
				}	
			}			
			$total_phone_leads_to_pay = $total_phone_leads_billed - $total_phone_leads_refunded;

			
			$sum_total_leads = $total_form_leads + $total_phone_leads;
			$sum_total_leads_paybypswd_closed = $total_form_leads_paybypswd_closed + $total_phone_leads_paybypswd_closed;
			$sum_total_leads_paybypswd = $total_form_leads_paybypswd + $total_phone_leads_paybypswd;
			$sum_total_leads_billed = $total_form_leads_billed + $total_phone_leads_billed;
			$sum_total_leads_refunded = $total_form_leads_refunded + $total_phone_leads_refunded;
			$sum_total_leads_doubled = $total_form_leads_doubled + $total_phone_leads_doubled;
			$sum_total_leads_to_pay = $total_form_leads_to_pay + $total_phone_leads_to_pay;

			
			$row_leads_arr[] = array('רשימת טופסי צור קשר:');
			$lead_h_list =  array('תאריך', 'שם מלא', 'דוא"ל', 'טלפון','פתוח' , 'מקור הליד','קיבל זיכוי', 'תוכן' );
			if($advanced_report){
				$lead_h_list[] = "סוג לקוח";
			}
			$row_leads_arr[] = $lead_h_list;

			foreach($form_leads_paybypswd_arr as $lead){
				$content = iconv("windows-1255","utf-8",$lead['content']);
				$name = iconv("windows-1255","utf-8",$lead['name']);
				$email = iconv("windows-1255","utf-8",$lead['email']);
				$phone = iconv("windows-1255","utf-8",$lead['phone']);
				$lead_row = array( stripslashes($lead['date_in']) , stripslashes($name) , stripslashes($email) , stripslashes($phone), $lead['opened_str']  , 'טופס באתר',$lead['refunded_str'] , stripslashes($content));
				if($advanced_report){
					$lead_row[] = $customer_types_str[$customer_type_phones[$lead['phone']]];
				}	
				$row_leads_arr[] = $lead_row;
				if(isset($lead['previous_sends'])){
					
					if(!empty($lead['previous_sends'])){
						$row_leads_arr[] = array("פניות קודמות","פניות קודמות","פניות קודמות");
						foreach($lead['previous_sends'] as $prev_lead){
							$prev_content = iconv("windows-1255","utf-8",$prev_lead['content']);
							$prev_name = iconv("windows-1255","utf-8",$prev_lead['name']);
							$prev_email = iconv("windows-1255","utf-8",$prev_lead['email']);
							$prev_phone = iconv("windows-1255","utf-8",$prev_lead['phone']);
							$billed_str = "לא חוייב";
							if($prev_lead['lead_billed'] == '1'){
								$billed_str = "חוייב";
							}
							if($prev_lead['lead_recource'] == 'form'){
								$prev_lead_row = array( stripslashes($prev_lead['date_in']) , stripslashes($prev_name) , stripslashes($prev_email) ,$billed_str, $prev_lead['opened_str']  ,'טופס באתר',$prev_lead['refunded_str'] , stripslashes($prev_content));					
							}
							else{
								$prev_resource = 'טלפון';
								$sql3 = "SELECT sms_send,call_from,answer,call_date,billsec  FROM sites_leads_stat WHERE id = ".$prev_lead['phone_lead_id']."";
								$res = mysql_db_query(DB, $sql3);
								$call_data = mysql_fetch_assoc($res); 
								$answ = ( $call_data['billsec'] == '0' ) ? "ללא מענה" : "שיחה של ".$call_data['billsec']." שניות";
								$prev_lead_row = array( stripslashes($call_data['call_date']) , '' , '' ,$billed_str,''  , 'מערכת טלפונייה',$prev_lead['refunded_str']  , $answ);
							}
							$row_leads_arr[] = $prev_lead_row;
						}
						$row_leads_arr[] = array("---","----","----");
					}
				}

				if(isset($lead['previous_imports'])){
					
					if(!empty($lead['previous_imports'])){
						$row_leads_arr[] = array("ייבוא טלפון","ייבוא טלפון","ייבוא טלפון");
						foreach($lead['previous_imports'] as $prev_lead){
							
							$prev_lead_row = array( stripslashes($prev_lead['update_time']) , "-----" , "-----" ,"-----", "------"  ,'ייבוא מהלקוח',"----" , "------");

							$row_leads_arr[] = $prev_lead_row;
						}
						$row_leads_arr[] = array("---","----","----");
					}
				}
			}
			$row_leads_arr[] = array("----");
			$row_leads_arr[] = array('כפילויות בטפסים');
			foreach($form_leads_doubled_arr as $lead){	
				$content = iconv("windows-1255","utf-8",$lead['content']);
				$name = iconv("windows-1255","utf-8",$lead['name']);
				$email = iconv("windows-1255","utf-8",$lead['email']);
				$phone = iconv("windows-1255","utf-8",$lead['phone']);
				$row_leads_arr[] = array( stripslashes($lead['date_in']) , stripslashes($name) , stripslashes($email) , stripslashes($phone), $lead['opened_str']  , 'טופס באתר',$lead['refunded_str'] , stripslashes($content));
			}

			
			$row_leads_arr[] = array("----");
			$row_leads_arr[] = array('רשימת טלפונים שהתקבלו:');
			foreach($phone_leads_paybypswd_arr as $lead){				
				//$row_leads_arr[] = array( stripslashes($lead['date_in']) , stripslashes($lead['name']) , stripslashes($lead['email']) , stripslashes($lead['phone']), $lead['opened_str'] , stripslashes($lead['content']) , 'טופס באתר',$lead['refunded_str'] );
				$sql3 = "SELECT sms_send,call_from,answer,call_date,billsec  FROM sites_leads_stat WHERE id = ".$lead['phone_lead_id']."";
				$res = mysql_db_query(DB, $sql3);
				$call_data = mysql_fetch_assoc($res); 
				$answ = ( $call_data['billsec'] == '0' ) ? "ללא מענה" : "שיחה של ".$call_data['billsec']." שניות";
				$lead_row = array( stripslashes($call_data['call_date']) , '' , '' , stripslashes($call_data['call_from']),''  , 'מערכת טלפונייה',$lead['refunded_str']  , $answ);
				if($advanced_report){
					$lead_row[] = $customer_types_str[$customer_type_phones[$lead['phone']]];
				}				
				$row_leads_arr[] = $lead_row;
				if(isset($lead['previous_sends'])){
					
					if(!empty($lead['previous_sends'])){
						$row_leads_arr[] = array("פניות קודמות","פניות קודמות","פניות קודמות");
						foreach($lead['previous_sends'] as $prev_lead){
						$prev_content = iconv("windows-1255","utf-8",$prev_lead['content']);
						$prev_name = iconv("windows-1255","utf-8",$prev_lead['name']);
						$prev_email = iconv("windows-1255","utf-8",$prev_lead['email']);
						$prev_phone = iconv("windows-1255","utf-8",$prev_lead['phone']);
							$billed_str = "לא חוייב";
							if($prev_lead['lead_billed'] == '1'){
								$billed_str = "חוייב";
							}
							if($prev_lead['lead_recource'] == 'form'){
								$prev_lead_row = array( stripslashes($prev_lead['date_in']) , stripslashes($prev_name) , stripslashes($prev_email) ,$billed_str, $prev_lead['opened_str']  ,'טופס באתר',$prev_lead['refunded_str'] , stripslashes($prev_content));					
							}
							else{
								$prev_resource = 'טלפון';
								$sql3 = "SELECT sms_send,call_from,answer,call_date,billsec  FROM sites_leads_stat WHERE id = ".$prev_lead['phone_lead_id']."";
								$res = mysql_db_query(DB, $sql3);
								$call_data = mysql_fetch_assoc($res); 
								$answ = ( $call_data['billsec'] == '0' ) ? "ללא מענה" : "שיחה של ".$call_data['billsec']." שניות";
								$prev_lead_row = array( stripslashes($call_data['call_date']) , '' , '' ,$billed_str,''  , 'מערכת טלפונייה',$prev_lead['refunded_str']  , $answ);
							}
							$row_leads_arr[] = $prev_lead_row;
						}
						$row_leads_arr[] = array("---","----","----");
					}
				}

				if(isset($lead['previous_imports'])){
					
					if(!empty($lead['previous_imports'])){
						$row_leads_arr[] = array("ייבוא טלפון","ייבוא טלפון","ייבוא טלפון");
						foreach($lead['previous_imports'] as $prev_lead){
							
							$prev_lead_row = array( stripslashes($prev_lead['update_time']) , "-----" , "-----" ,"-----", "------"  ,'ייבוא מהלקוח',"----" , "------");

							$row_leads_arr[] = $prev_lead_row;
						}
						$row_leads_arr[] = array("---","----","----");
					}
				}				
			}			
			$row_leads_arr[] = array("----");
			$row_leads_arr[] = array('כפילויות טלפונים');
			foreach($phone_leads_doubled_arr as $lead){				
				//$row_leads_arr[] = array( stripslashes($lead['date_in']) , stripslashes($lead['name']) , stripslashes($lead['email']) , stripslashes($lead['phone']), $lead['opened_str'] , stripslashes($lead['content']) , 'טופס באתר',$lead['refunded_str'] );
				$sql3 = "SELECT sms_send,call_from,answer,call_date,billsec  FROM sites_leads_stat WHERE id = ".$lead['phone_lead_id']."";
				$res = mysql_db_query(DB, $sql3);
				$call_data = mysql_fetch_assoc($res); 
				$answ = ( $call_data['billsec'] == '0' ) ? "ללא מענה" : "שיחה של ".$call_data['billsec']." שניות";
				$row_leads_arr[] = array( stripslashes($call_data['call_date']) , '' , '' , stripslashes($call_data['call_from']) ,''  , 'מערכת טלפונייה',$lead['refunded_str'], $answ );				
			}	

			$row_leads_arr[] = array("----");  
			$row_leads_arr[] = array("סיכום פניות"); 
			$row_leads_arr[] = array("מקור הפנייה","נשלחו","מצב פתוח","(לא מחוייב)מצב סגור","חוייבו","כפילויות","זוכו","סך הכל לחיוב"); 
			$row_leads_arr[] = array("טופס",$total_form_leads,$total_form_leads_paybypswd,$total_form_leads_paybypswd_closed,$total_form_leads_billed,$total_form_leads_doubled,$total_form_leads_refunded,$total_form_leads_to_pay); 
			$row_leads_arr[] = array("טלפון",$total_phone_leads,$total_phone_leads_paybypswd,$total_phone_leads_paybypswd_closed,$total_phone_leads_billed,$total_phone_leads_doubled,$total_phone_leads_refunded,$total_phone_leads_to_pay); 
			$row_leads_arr[] = array("");
			$row_leads_arr[] = array("");  
			$row_leads_arr[] = array("סך הכל",$sum_total_leads,$sum_total_leads_paybypswd,$sum_total_leads_paybypswd_closed,$sum_total_leads_billed,$sum_total_leads_doubled,$sum_total_leads_refunded,$sum_total_leads_to_pay); 
			if($advanced_report){
				$row_leads_arr[] = array("מספור"," לקוחות","לפי סוג לקוח","חדש","קיים-חוזר","חדש-חוזר","שימור");
				$row_leads_arr[] = array("","","",$customer_types_count['new'],$customer_types_count['back'],$customer_types_count['new_back'],$customer_types_count['shimur']);
			}			
			if($lead_price > 0){
				$row_leads_arr[] = array("מחיר ליד",$lead_price);
				$row_leads_arr[] = array("סך הכל לתשלום",$lead_price * $sum_total_leads_to_pay);
			}
            // Check if the user need to pay about the leads by period payment
            $sql = "SELECT ub.unk, ub.advertisingPeriod , ub.leadPrice, ub.leadPercentOff, ub.domainEndDate,  ub.advertisingPrice , ub.advertisingStartDate, u.owner_id , u.email , u.full_name FROM user_bookkeeping as ub, users as u WHERE ub.unk=u.unk AND u.unk = '" . $unk ."' AND ub.advertisingPeriod > 0 AND ub.leadPrice > 0";
           
			$resDOMAINS = mysql_db_query(DB, $sql);

            if($data = mysql_fetch_array($resDOMAINS)){
				if($sum_total_leads_to_pay > 0){
					// Calculate the payment per lead
					if (isset($data['leadPercentOff']) && $data['leadPercentOff'] > 0) {
						$leadPrice = $data['leadPrice'] - ($data['leadPrice'] * $data['leadPercentOff'] / 100);
					} else {
						$leadPrice = $data['leadPrice'];
					}    
					// Send payment request to user    
					if(isset($_GET['test']) && false){
						echo "<pre>";
							print_r(array($data['owner_id'], $unk, $leadPrice*$sum_total_leads_to_pay, 1, $sum_total_leads_to_pay.' לידים מאתר שירות 10 לתאריך '. $date_reported, $until_date, $sum_total_leads_to_pay, $data['email'] , $data['full_name'] ));
						echo "<pre/>";
					}
					else{
						launch_fee_to_client_DB_custom($data['owner_id'], $unk, $leadPrice*$sum_total_leads_to_pay, 1, $sum_total_leads_to_pay.' לידים מאתר שירות 10 לתאריך '. $date_reported, $until_date, $sum_total_leads_to_pay, $data['email'] , $data['full_name'] );
					}
				}
            }
            // Send report to user
            if(isset($_GET['test'])){
				//echo iconv("utf-8","windows-1255",$full_name)."<hr/>";
				//continue;
			}
            $content_mail = "
            			<html dir=rtl>
                    <head>
                        <title></title>
                        <style>
                            .textt{font-family: arial; font-size:12px; color: #000000}
                            .text_link{font-family: arial; font-size:12px; color: navy}
                        </style>
                    </head>
                    
                    <body>
                        <p class='textt' dir=rtl align=right>
                        <b>שלום " . $full_name . ",</b><br><br>
                       	 לנוחיותך מצורף דוח הלידים לתאריך ".$date_reported."<br>
                       	סך הכל לידים שקבלת בחודש שעבר: ".$sum_total_leads_to_pay."<br>
                       	תוכל למצוא את הדוח מצורף לאימייל.<br><br>
                       	בברכה,<br>
                       	צוות איי אל ביז קידום עסקים באינטרנט
                        </p>
                    </body>
                    </html>
                ";
            //$content_mail = iconv("utf-8","windows-1255",$content_mail);
            if( $sum_total_leads_to_pay > 0)
            {	
				$test_title = "";
				if(!isset($_GET['test'])){
					send_csv_mail($row_leads_arr, $content_mail, $dataBig['email'] ,"דוח לידים ל ".$date_reported );
				}
				else{
					$test_id = $_GET['test'];
					$test_title = "($test_id)";
				}
				if(!isset($_GET['test'])){
					send_csv_mail($row_leads_arr, $content_mail,"ilan@il-biz.com","דוח לידים ל ".$date_reported.$test_title );
					send_csv_mail($row_leads_arr, $content_mail,"yacov.avr@gmail.com","דוח לידים ל ".$date_reported.$test_title );
				}
				if(isset($_GET['test'])){
					
					echo "<meta charset='UTF-8'>";
					foreach($row_leads_arr as $arr){
						$content_mail.= "<div style='clear:both;'></div>";
						foreach($arr as $col){
							$content_mail.= "<div style='float:left; width:150px; overflow:auto; height:80px; margin:2px; border:1px solid;'>".$col."</div>";
						}
					}
					//$content_mail = iconv("utf-8","windows-1255",$content_mail);
					echo "<hr/>SENT TO ".$dataBig['email']."-".$full_name.": <br/><br/>".$content_mail."<br/><br/>";
				
				}
			}
        }
    }
	if(isset($_GET['test'])){
	echo "ended fine";
	}
} 
 



function create_csv_string($data)
{
	// Open temp file pointer
	if (!$fp = fopen('php://temp', 'w+')) return FALSE;
	
	// Loop data and write to file pointer
	foreach ($data as $line) fputcsv($fp, $line);

	// Place stream pointer at beginning
	rewind($fp);
	
	// Return the data
	return stream_get_contents($fp);
}

function send_csv_mail ($csvData, $message, $mailto, $subject, $from_name = 'ilan@il-biz.com'){
	
	
	global $date_reported;
	$uid = md5(uniqid(time()));
	$name = "ilbiz-report-".$date_reported;

	
	$subject = '=?UTF-8?B?'.base64_encode($subject).'?=';
	$content = chunk_split(base64_encode(create_csv_string($csvData))); 
	// header
	$header = "From: ".$from_name." <".$from_name.">\r\n";
	$header .= "Reply-To: ".$from_name."\r\n";
	$header .= "MIME-Version: 1.0\r\n";
	$header .= "Content-Type: multipart/mixed; boundary=\"".$uid."\"\r\n\r\n";

	// message & attachment
	$nmessage = "--".$uid."\r\n";
	$nmessage .= "Content-type:text/html; charset=UTF-8\r\n";
	$nmessage .= "Content-Transfer-Encoding: base64\r\n\r\n";
	$nmessage .=  base64_encode($message)."\r\n\r\n";
	$nmessage .= "--".$uid."\r\n";
	$nmessage .= "Content-Type: application/octet-stream; name=\"".$name.".csv\"\r\n";
	$nmessage .= "Content-Transfer-Encoding: base64\r\n";
	$nmessage .= "Content-Disposition: attachment; filename=\"".$name.".csv\"\r\n\r\n";
	$nmessage .= $content."\r\n\r\n";
	$nmessage .= "--".$uid."--";

	if (mail($mailto, $subject, $nmessage, $header)) {
		return true; // Or do something here
	} else {
	  return false;
	}	
}

function send_csv_mail_old ($csvData, $body, $to, $subject, $from = 'ilbiz@ilbiz.com')
{
	global $date_reported;
	// This will provide plenty adequate entropy
	$multipartSep = '-----'.md5(time()).'-----';

	// Arrays are much more readable
	$headers = array(
		"From: $from",
		"Reply-To: $from",
		"Content-Type: multipart/mixed; boundary=\"$multipartSep\""
	);

	// Make the attachment
	$attachment = chunk_split(base64_encode(create_csv_string($csvData))); 

	// Make the body of the message
	$body = "--$multipartSep\r\n"
				. "Content-Type: text/html; charset=windows-1255-1; format=flowed\r\n"
				. "Content-Transfer-Encoding: 7bit\r\n"
				. "\r\n"
				. "$body\r\n"
				. "--$multipartSep\r\n"
				. "Content-Type: text/csv\r\n"
				. "Content-Transfer-Encoding: base64\r\n"
				. "Content-Disposition: attachment; filename=\"ilbiz-report-".$date_reported.".csv\"\r\n"
				. "\r\n"
				. "$attachment\r\n"
				. "--$multipartSep--";

	// Send the email, return the result
	return @mail($to, $subject, $body, implode("\r\n", $headers)); 
}





/**
 * Function: auto_advertising_send()
 * Description: getting the users and hes bookkeeping.
 *
 * taking the timestamp for a month before the advertising date.
 * checking if the advertising period that left is the time distance, by module. *
 */
function auto_advertising_send()
{
    // Get the current time
    $timestamp = time();
    
    // Get all payment date on users
    $sql = "SELECT ub.unk, ub.advertisingPeriod , ub.leadPrice, ub.leadPercentOff, ub.domainEndDate,  ub.advertisingPrice , ub.advertisingStartDate, u.owner_id , u.email , u.full_name FROM user_bookkeeping as ub, users as u WHERE ub.unk=u.unk AND ub.advertisingPeriod > 0 AND ub.advertisingPrice > 0 ";
    $resDOMAINS = mysql_db_query(DB, $sql);
    
    while ($data = mysql_fetch_array($resDOMAINS)) {
        // send email to client
        $oid = $data['owner_id'];
        $unk = $data['unk'];
        $advertisingPeriod = $data['advertisingPeriod'];
        $advertisingPrice = $data['advertisingPrice'];
        $until_date = $data['advertisingStartDate'];
        
        $email_to_send = $data['email'];
        

        // Get the current day and month
        $nowDay = intval(date('j', $timestamp));
        $nowMonth = intval(date('m', $timestamp));
        $nowYear = intval(date('Y', $timestamp));
        
        // Get The start Advertising day and month
        $parts = explode('-', $until_date);
        $adDay = intval($parts[2]);
        $adMonth = intval($parts[1]);
        $adYear = intval($parts[0]);
        
        $diff = abs($nowMonth - $adMonth);
        $module = $diff % $advertisingPeriod; // months diff % period.
        $content = 'פרסום באינטרנט באתרי שירות 10 ל- '. $advertisingPeriod .' חודשים הבאים';

        // check if the period is over by module and today is as start day, if so send payment request
        if (($module == 0) && ($nowDay == $adDay || ($nowDay+2) == $adDay || ($nowDay+7) == $adDay) && ($adYear < $nowYear || $nowMonth != $adMonth)) { // module exists and is 0, months diff are more than 0 , same days.     
			launch_fee_to_client_DB_custom($oid, $unk, $advertisingPrice * $advertisingPeriod, $advertisingPeriod, $content, $nowYear.'-'. $nowMonth .'-'.$nowDay, $leadsToPay, $email_to_send , $data['full_name'] );
        }
    }
}
// END check domain
function send_email($params)
{
    $type = $params['type'];
    $days = $params['days'];
    $unk = $params['unk'];
    $sendTOemail = $params['sendTOemail'];
    $full_name = $params['full_name'];
    $CTDomain = $params['domain'];
    $from_name = "IL-BIZ קידום עסקים באינטרנט";
    $from_email = "ilan@il-biz.com";
    $subject = "תזכורת חשובה"." (".$params['days']." ימים) ";
    
    $sql = "SELECT hostPriceMon, domainPrice FROM user_bookkeeping WHERE unk = '" . $unk . "'";
    $res = mysql_db_query(DB, $sql);
    $dataPrice = mysql_fetch_array($res);
    
    if ($type == 0) {
        $month = $dataPrice['hostPriceMon'];
        $totalYear_whitoutMAAM = $dataPrice['hostPriceMon'] * 12;
        $maam = (MAAM * $totalYear_whitoutMAAM) / 100;
        $totalYear = $totalYear_whitoutMAAM + $maam;
        // $nikoiMas = ( $totalYear_whitoutMAAM + $maam ) * 0.02 ;
        // $totalYear_NEW = $totalYear - $nikoiMas;
        
        $content = "
שלום רב " . stripslashes(iconv("windows-1255","utf-8",$full_name)) . "<br><br>
בעוד <b>" . $days . "</b> ימים יפוג תוקף האתר <a href='http://" . $CTDomain . "'>" . $CTDomain . "</a>.<br>
<br>
כדי שהמערכת האוטומטית לא תוריד את אתרך מהאינטרנט בתאריך הנ\"ל  יש לבצע תשלום <br>
 <br>
פירוט תשלום :<br>
 <br>
עלות אחסון חודשית " . myround($month) . " ₪ + מע\"מ <br>
סה\"כ תשלום <b>" . myround($totalYear) . " ₪</b> כולל מע\"מ<br>
 <br>
 <br>
ניתן לחדש את אחסון האתר באחת מהדרכים הבאות  :
<ol>

<li>באמצעות כרטיס אשראי, עד 12 תשלומים ללא רבית והצמדה, <a href='http://www.ilbiz.co.il/ClientSite/administration/index.php?main=payWithCC&payToType=1&unk=" . $unk . "&sesid='><b>לחץ כאן לטופס סליקה</b></a> <b>*</b> &nbsp;&nbsp; <a href='http://www.ilbiz.co.il/ClientSite/administration/index.php?main=payWithCC&payToType=1&unk=" . UNK . "&sesid=" . SESID . "'><img src='http://www.ilbiz.co.il/ClientSite/administration/images/paypage_61.gif' border=0></a></li>
<li>צ'ק לכתובת : פארק אופיר 50, באר שבע , מיקוד : 84887 </li>
<li>הפקדה לחשבון בנק ע\"ש איי. אל. ביז קידום עסקים באינטרנט בע\"מ, בנק הפועלים, סניף 160 , מספר חשבון 71732</li>
</ol>
<b>* לאחר התשלום ישלח לאימייל שיצויין בטופס, חשבונית מס קבלה מקורית עם חתימה דגיטלית</b><br><br>
<b>*** עלות החזרת אתר שהורד על ידי המערכת האוטומטית מהאינטרנט  – 250 ₪ + מע\"מ</b>
";
    } elseif ($type == 1) {
		echo "<br/>sending to: ".$sendTOemail;
        $maam = (MAAM * $dataPrice['domainPrice']) / 100;
        $domainYear = $dataPrice['domainPrice'] + $maam;
        
        // $nikoiMas = ( $domainYear ) * 0.02 ;
        // $domainYear_NEW = $domainYear - $nikoiMas;
        
        $content = "
שלום רב " . stripslashes(iconv("windows-1255","utf-8",$full_name)) . "<br><br>
בעוד <b>" . $days . "</b> ימים יפוג תוקף הדומיין <a href='http://" . $CTDomain . "'>" . $CTDomain . "</a>.<br>
<br>
פירוט תשלום :<br>
 <br>
עלות דומיין כולל מע\"מ <b>" . myround($domainYear) . " ₪</b> לשנה
 <br>
 <br>
ניתן לחדש את הדומיין באחת מהדרכים הבאות :
<ol>
<li>באמצעות כרטיס אשראי, עד 12 תשלומים ללא רבית והצמדה, <a href='http://www.ilbiz.co.il/ClientSite/administration/index.php?main=payWithCC&payToType=2&unk=" . $unk . "&sesid='><b>לחץ כאן לטופס סליקה</b></a> <b>*</b> &nbsp;&nbsp; <a href='http://www.ilbiz.co.il/ClientSite/administration/index.php?main=payWithCC&payToType=2&unk=" . UNK . "&sesid=" . SESID . "'><img src='http://www.ilbiz.co.il/ClientSite/administration/images/paypage_61.gif' border=0></a></li>
<li>צ'ק לכתובת : פארק אופיר 50, באר שבע , מיקוד : 84887 </li>
<li>הפקדה לחשבון בנק ע\"ש איי. אל. ביז קידום עסקים באינטרנט בע\"מ, בנק הפועלים, סניף 160 , מספר חשבון 71732</li>
</ol>
<b>* לאחר התשלום ישלח לאימייל שיצויין בטופס, חשבונית מס קבלה מקורית עם חתימה דגיטלית</b><br><br>
";
    }
    
    $content_send_to_Client = "
                    <html dir=rtl>
                    <head>
                        <title></title>
                        <style>
                            .textt{font-family: arial; font-size:12px; color: #000000}
                            .text_link{font-family: arial; font-size:12px; color: navy}
                        </style>
                    </head>
                    
                    <body>
                        <p class='textt' dir=rtl align=right>" . $content . "</p>
                    </body>
                    </html>";
 


	global $date_reported;
	$uid = md5(uniqid(time()));
	$name = "ilbiz-report-".$date_reported;

	
	$subject = '=?UTF-8?B?'.base64_encode($subject).'?=';
	$from_name = '=?UTF-8?B?'.base64_encode($from_name).'?=';
	// header
	$header = 'MIME-Version: 1.0' . "\r\n" .
				'Content-type: text/html; charset=UTF-8'."\r\n" .
				'Content-Transfer-Encoding: base64' . "\r\n"; 	
	$header .= "From: ".$from_name." <".$from_email.">\r\n";
	$header .= "Reply-To: ".$from_email."\r\n";


	// message & attachment

	$nmessage .=  base64_encode($content_send_to_Client)."\r\n\r\n";
	
	

	if (mail($sendTOemail, $subject, $nmessage, $header)) {
		return true; // Or do something here
	} else {
	  return false;
	}	

 
    //GlobalFunctions::send_emails_with_phpmailer($from_email, $from_name, $subject, $content_send_to_Client, $content_send_to_Client, $sendTOemail, $full_name );
}

function myround($value, $prec = 0, $rounding = 1)
{
    list ($b, $f) = explode('.', (string) $value);
    $b = (int) $b;
    
    if (($prec - strlen($f)) > 0) {
        $f *= pow(10, ($prec - strlen($f)));
    }
    
    if (strlen($f) > $prec) {
        $f1 = (int) substr($f, 0, $prec);
        $f2 = (int) substr($f, $prec, 1);
        $f3 = (int) substr($f, $prec - 1, 1);
        
        if ($rounding === ROUND_HALF_DOWN || ($rounding === ROUND_HALF_EVEN && (($f3 & 1) === 0))) {
            $f = ($f2 >= 6) ? $f1 + 1 : $f1;
        } elseif ($rounding === ROUND_HALF_UP || ($rounding === ROUND_HALF_EVEN && (($f3 & 1) === 1))) {
            $f = ($f2 >= 5) ? $f1 + 1 : $f1;
        }
        if ($f === pow(10, $prec)) {
            ++ $b;
            $f = 0;
        }
    }
    
    $f = sprintf("%0{$prec}d", $f);
    
    return (float) ((string) $b . '.' . (string) $f);
}

/**
 * By: sysBind.
 * Description: save data on the db + sending mail to the customer.
 * Result: re-location.
 */
function launch_fee_to_client_DB_custom($oid, $unk, $price, $tash, $details, $until_date, $leadsToPay, $email_to_send , $full_name )
{
	echo "sending to:".$email_to_send;
    if (isset($email_to_send)) { // Make the process only if the customer mail is available.
        $untilDate1 = explode("-", $until_date);
        $untilDate = $untilDate1[2] . "-" . $untilDate1[1] . "-" . $untilDate1[0];
        
        $uniqueSes = md5($_SERVER[REMOTE_ADDR] . "-" . date('dmyHis'));
		$details_for_db = $details;
		
        if(mb_detect_encoding($details) == "UTF-8"){
			$details_for_db = iconv("utf-8","windows-1255",$details);
		}
        // Enter payment request to DB and client will see it in is admin Panel
        $sql = "INSERT INTO ilbiz_launch_fee ( owner_id , unk , price , tash , details , until_date , email_to_send , uniqueSes ) VALUES (
         '" . $oid . "' , '" . $unk . "' , '" . myround($price) . "' , '" . $tash . "' , '" . $details_for_db . "' ,
         '" . $untilDate . "' , '" . $email_to_send . "' , '" . $uniqueSes . "' )";
        $res = mysql_db_query(DB, $sql);
        
        $fullmsg = "<html dir=rtl>
                    <head>
                        <title></title>
                        <style>
                            .textt{font-family: arial; font-size:12px; color: #000000}
                            .text_link{font-family: arial; font-size:12px; color: navy}
                        </style>
                    </head>
                    
                    <body>
                        <p class='textt' dir=rtl align=right>
                        שלום רב ".stripslashes(iconv("windows-1255","utf-8",$full_name)).",<br><br>
			קיבלת הודעת תשלום עבור: " . $details . "<br>
			על סך " . myround($price) . " ש\"ח כולל מע\"מ.<br><br>
			<a href='http://www.ilbiz.co.il/ClientSite/administration/pay.php?uniqueSes=" . $uniqueSes . "' class='text_link'><u>לחץ כאן</u></a> בתשלום מיידי בכרטיס אשראי.<br><br>
			בברכה,<br>
			איי אל ביז קידום עסקים באינטרנט
                        </p>
                    </body>
                    </html>";

		global $date_reported;
		$uid = md5(uniqid(time()));
		$name = "ilbiz-report-".$date_reported;
		$from_name = "IL-BIZ קידום עסקים באינטרנט";
		$from_email = "ilan@il-biz.com";
		$subject_extra = "";
		if(isset($_GET['test'])){
			$subject_extra = "(".$_GET['test'].")";
		}
		$subject = "בקשה לתשלום אוטומטי".$subject_extra;
		$subject = '=?UTF-8?B?'.base64_encode($subject).'?=';
		$from_name = '=?UTF-8?B?'.base64_encode($from_name).'?=';
		// header
		$header = 'MIME-Version: 1.0' . "\r\n" .
					'Content-type: text/html; charset=UTF-8'."\r\n" .
					'Content-Transfer-Encoding: base64' . "\r\n"; 	
		$header .= "From: ".$from_name." <".$from_email.">\r\n";
		$header .= "Reply-To: ".$from_email."\r\n";
		   

		// message & attachment

		$nmessage .=  base64_encode($fullmsg)."\r\n\r\n";
		
		

		if (mail($email_to_send, $subject, $nmessage, $header)) {
			mail("beer7.biz@gmail.com", $subject, $nmessage, $header);
			//mail($email_to_send, "בקשה לתשלום אוטומטי", $fullmsg, $headers); 
			return true; // Or do something here
		} else {
		  return false;
		}	
			
		   // mail($email_to_send, "בקשה לתשלום אוטומטי", $fullmsg, $headers);
		   // mail("ilan@il-biz.com", "בקשה לתשלום אוטומטי", $fullmsg, $headers);
		   // mail("yacov.avr@gmail.com", "בקשה לתשלום אוטומטי", $fullmsg, $headers);
    }
}

function isValidEmail($email)
{
    $pattern = "^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,3})$";
    
    if (eregi($pattern, $email) || empty($email)) {
        return true;
    } else {
        return false;
    }
}

function isValidPhone($phone)
{
    $pattern = '/^(0)+([0-9])/';
    
    if (preg_match($pattern, $phone) && (strlen($phone) > 5)) {
        return true;
    } else {
        return false;
    }
}

?>