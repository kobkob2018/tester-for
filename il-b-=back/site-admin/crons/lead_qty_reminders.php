<?php
/*
 * * the page will send to the client mail or something else, to remaind im to pay to domain / host
 * * the cron will run every 24 hours in 00:00
 *
 */

require ('../../global_func/vars.php');

$date_reported = date('m-Y', strtotime('-1 month', strtotime(date('Y-m-01'))));
lead_qty_reminders();

function lead_qty_reminders()
{
	$show_on_page = false;
	if(isset($_GET['show_on_page'])){
		$show_on_page = true;
	}
	if($show_on_page){
		echo "<meta charset='UTF-8'>";
	}
	
	global $date_reported;
	$sql = "SELECT unk,leadQry FROM user_lead_settings WHERE leadQry IN(0,1,2,3) AND open_mode = '1' AND freeSend = '0' AND autoSendLeadContact = '1'";
	$res = mysql_db_query(DB,$sql);
	
	while($unk_data = mysql_fetch_array($res)){
		
		$send_reminder = true;
		$user_updated = false;
		$unk = $unk_data['unk'];
		$new_auth_token = md5(time().$unk);
		$reminder_sql = "SELECT * FROM lead_qty_reminders WHERE unk = '$unk'";
		$reminder_res = mysql_db_query(DB,$reminder_sql);
		$reminder_data = mysql_fetch_array($reminder_res);
		if($reminder_data['unk'] == ''){
			$insert_sql = "INSERT INTO lead_qty_reminders (unk,last_reminder_time,last_reminder_qty,auth_token) VALUES('$unk',now(),".$unk_data['leadQry'].",'$new_auth_token')";
			$insert_res = mysql_db_query(DB,$insert_sql);
			$user_updated = true;
		}
		else{
			if($reminder_data['auth_token'] != ""){
				$new_auth_token = $reminder_data['auth_token'];
			}
			if($reminder_data['last_reminder_qty'] == $unk_data['leadQry']){
				$time_check_sql = "SELECT unk FROM lead_qty_reminders WHERE unk = '$unk' AND last_reminder_time < NOW() - INTERVAL 1 WEEK";
				$time_check_res = mysql_db_query(DB,$time_check_sql);
				$time_check_data = mysql_fetch_array($time_check_res);
				if($time_check_data['unk'] == ""){
					$send_reminder = false;
				}
			}
		}
		$user_sql = "SELECT id,email,full_name,name FROM users WHERE unk = '$unk' AND status = '0' AND active_manager = '0' AND end_date > now()";
		$user_res = mysql_db_query(DB,$user_sql);
		$user_data = mysql_fetch_array($user_res);
		if($user_data['email'] == ""){
			$send_reminder = false;
		}
		if($send_reminder && !$user_updated){
				$update_sql = "UPDATE lead_qty_reminders SET last_reminder_time = NOW(), last_reminder_qty = '".$unk_data['leadQry']."' WHERE unk = '$unk'";
				$update_res = mysql_db_query(DB,$update_sql);			
		}
		if($send_reminder){
			
			$full_name = iconv("windows-1255","utf-8",stripslashes($user_data['full_name']));
			$biz_name =  iconv("windows-1255","utf-8",stripslashes($user_data['name']));
			$email_to = $user_data['email'];
			$lead_qty = $unk_data['leadQry'];
			$auth_token = $new_auth_token;
			$title = "יתרת הלידים שלך מגיעה לסיומה";
			
			$admin_link = "https://ilbiz.co.il/myleads/?qty_unk=$unk&qty_token=$auth_token";
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
						<b>שלום " . $full_name.", ".$biz_name. ",</b><br><br>
						 
						סך הכל לידים שנותרו לך: ".$lead_qty."<br>
						באפשרותך לרכוש לידים על-ידי לחיצה על הלינק הבא:.<br>
						<a href='$admin_link'>$admin_link</a>
						<br>
						בברכה,<br>
						צוות איי אל ביז קידום עסקים באינטרנט, 03-6449369
						</p>
					</body>
					</html>
				";
			if(!$show_on_page){
				$ilan_content_mail = str_replace($admin_link,'https://ilbiz.co.il/myleads/',$content_mail);
				send_reminder_mail($ilan_content_mail, "ilan@il-biz.com" ,$title);
				send_reminder_mail($content_mail, $email_to ,$title);
			}
			else{
				//send_reminder_mail($content_mail, "ilan@il-biz.com" ,$title );
				//send_reminder_mail($content_mail, "yacov.avr@gmail.com" ,$title );
				echo $content_mail;
				echo "<hr/>";
				$uid = $user_data['id'];
				
				echo "http://ilbiz.co.il/site-admin/index.php?main=user_profile&unk=$unk&record_id=$uid&sesid=84322936932515291502793221";
				echo "</hr/>";
			}
		}
	}
} 
 

function send_reminder_mail ($message, $mailto, $subject, $from_name = 'ilan@il-biz.com'){

	global $date_reported;
	$uid = md5(uniqid(time()));

	
	$subject = '=?UTF-8?B?'.base64_encode($subject).'?=';
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
	$nmessage .= "--".$uid."--";

	if (mail($mailto, $subject, $nmessage, $header)) {
		return true; // Or do something here
	} else {
	  return false;
	}
}



?>