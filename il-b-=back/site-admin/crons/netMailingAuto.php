<?php
/* 
**	the page will send to the client mail
**	the cron will run every day and every hour
*
*/

require('../../global_func/vars.php');
require('../../global_func/class.phpmailer.php');
require('../../global_func/global_functions.php');


// send for users that receive the mailing first time
$sql = "SELECT user_id , mailing_id FROM net_mailing_queue_users WHERE sent = 0";
$res = mysql_db_query(DB,$sql);

$arrDoNetSend = array();
while( $data = mysql_fetch_array($res) )
{
	$mailIdTemp = sendMailNow( $data['mailing_id'] , $data['user_id'] , "1" );
	
	$arrDoNetSend[] = $mailIdTemp;
}


// send for users that recive more then 1 mail and that see the mail.
$sql = "SELECT id, user_id , mailing_id , mail_id FROM net_mailing_users_received_msg WHERE ( view_url = 1 OR temp_view_url = 1 ) AND finishProcess = 0";
$res = mysql_db_query(DB,$sql);

while( $data = mysql_fetch_array($res) )
{
	// check the next mail from mailing that the user need to recevie
	$sql = "SELECT mail_number FROM net_mailing_msg_mails WHERE mailing_id = '".$data['mailing_id']."' AND deleted=0 AND id = '".$data['mail_id']."'";
	$resCheckExist = mysql_db_query(DB,$sql);
 	$dataCheckExist = mysql_fetch_array($resCheckExist);
 	
 	$next_mailNumber = 1 + $dataCheckExist['mail_number'];
 	
 	$sql = "SELECT id FROM net_mailing_msg_mails WHERE mailing_id = '".$data['mailing_id']."' AND deleted=0 AND mail_number = '".$next_mailNumber."'";
	$resCheckExist2 = mysql_db_query(DB,$sql);
 	$dataCheckExist2 = mysql_fetch_array($resCheckExist2);
 	
 	$sql = "SELECT COUNT(id) as nums FROM net_mailing_users_received_msg WHERE mailing_id = '".$data['mailing_id']."' AND user_id = '".$data['user_id']."' AND mail_id = '".$dataCheckExist2['id']."'";
	$resCheckCount3 = mysql_db_query(DB,$sql);
	$dataCheckCount3 = mysql_fetch_array($resCheckCount3);
	
	if( $dataCheckCount3['nums'] == "0" )
	{
	 	if( $dataCheckExist2['id'] != "" )
			sendMailNow( $data['mailing_id'] , $data['user_id'] , $next_mailNumber );
		else
		{
			$sql = "UPDATE net_mailing_users_received_msg SET finishProcess=1 WHERE mailing_id = '".$data['mailing_id']."' AND user_id = '".$data['user_id']."'";
			$resFinish = mysql_db_query(DB,$sql);
		}
		
		$arrDoNetSend[] = $data['id'];
	}
	
}



// send for users that receive the mail but not entry for mail
$sql = "SELECT id, user_id , mailing_id , mail_id FROM net_mailing_users_received_msg AS r WHERE view_url = 0 and temp_view_url = 0 AND block = 0 AND finishProcess = 0";
$res = mysql_db_query(DB,$sql);

while( $data = mysql_fetch_array($res) )
{
	if( !in_array( $data['id'] , $arrDoNetSend ) )
	{
		$canSend = true;
		
		$sql = "SELECT COUNT(id) as nums FROM net_mailing_users_received_msg WHERE mailing_id = '".$data['mailing_id']."' AND user_id = '".$data['user_id']."' AND mail_id = '".$data['mail_id']."' AND view_url = 1";
		$resCheckCount5 = mysql_db_query(DB,$sql);
	 	$dataCheckCount5 = mysql_fetch_array($resCheckCount5);
		
		if( $dataCheckCount5['nums'] > 0 )
			$canSend = false;
		
		// count how match mails send for user
		$sql = "SELECT COUNT(id) as nums FROM net_mailing_users_received_msg WHERE mailing_id = '".$data['mailing_id']."' AND user_id = '".$data['user_id']."' AND mail_id = '".$data['mail_id']."'";
		$resCheckCount = mysql_db_query(DB,$sql);
	 	$dataCheckCount = mysql_fetch_array($resCheckCount);
	 	
	 	$sql = "SELECT reminder_total_send , reminder_period_day_send FROM net_mailing_msg_mails WHERE  mailing_id = '".$data['mailing_id']."' AND id = '".$data['mail_id']."'";
		$resCheckCount2 = mysql_db_query(DB,$sql);
	 	$dataCheckCount2 = mysql_fetch_array($resCheckCount2);
		
		if( $dataCheckCount2['reminder_total_send'] < $dataCheckCount['nums'] )
		{
			$canSend = false;
			
			$sql = "UPDATE net_mailing_users_received_msg SET block=1 WHERE mailing_id = '".$data['mailing_id']."' AND user_id = '".$data['user_id']."'";
			$resFinish = mysql_db_query(DB,$sql);
			
			$sql = "UPDATE net_mailing_users_received_msg SET temp_view_url=1 WHERE mailing_id = '".$data['mailing_id']."' AND user_id = '".$data['user_id']."' and mail_id = '".$data['mail_id']."' ";
			$resFinish = mysql_db_query(DB,$sql);
		}
		
		// check period per mails
		$sql = "SELECT date_send FROM net_mailing_users_received_msg WHERE mailing_id = '".$data['mailing_id']."' AND user_id = '".$data['user_id']."' AND mail_id = '".$data['mail_id']."' ORDER BY id DESC";
		$resCheckCount3 = mysql_db_query(DB,$sql);
	 	$dataCheckCount3 = mysql_fetch_array($resCheckCount3);
	 	
	 	$exp1 = explode( " " , $dataCheckCount3['date_send'] );
	 	$exp2 = explode( "-" , $exp1[0] );
	 	
		$mkdate1 = date('Y-m-d' , mktime( 0 , 0 , 0 , $exp2[1] , $exp2[2]+$dataCheckCount2['reminder_period_day_send'] , $exp2[0] ) );
		
		if( $mkdate1 >= date('Y-m-d') )
			$canSend = false;
		
		if( $canSend == true )
		{
			$sql = "SELECT mail_number FROM net_mailing_msg_mails WHERE mailing_id = '".$data['mailing_id']."' AND deleted=0 AND id = '".$data['mail_id']."'";
			$resCheckExist4 = mysql_db_query(DB,$sql);
	 		$dataCheckExist4 = mysql_fetch_array($resCheckExist4);
			
			sendMailNow( $data['mailing_id'] , $data['user_id'] , $dataCheckExist4['mail_number'] , "1" );
		}
	}
}


function sendMailNow( $mailing_id , $user_id , $mail_number , $remainder="" )
{

	$sendFlag = true;
	
	$sql = "SELECT id , days , send_hour, unk FROM net_mailing_settings WHERE id = '".$mailing_id."' AND deleted=0";
	$resSetting = mysql_db_query(DB,$sql);
	$dataSetting = mysql_fetch_array($resSetting);
	
	if( $dataSetting['id'] == "" )
		$sendFlag = false;
	
	//$currectTime = date("H:00:00");
	//if( $dataSetting['send_hour'] <= $currectTime )
	//	$sendFlag = false;
	
	$currectWday = date("w");
	if( !eregi($currectWday , $dataSetting['days'] ) )
		$sendFlag = false;
	
	if( $sendFlag == true )
	{
		
		$sql = "SELECT * FROM net_mailing_msg_mails WHERE mailing_id = '".$mailing_id."' AND mail_number = '".$mail_number."' AND deleted=0";
		$resMsg = mysql_db_query(DB,$sql);
		$dataMsg = mysql_fetch_array($resMsg);
		
		if( $dataMsg['id'] != "" )
		{
			
			$from_name = stripslashes($dataMsg['from_name']);
			$from_email = stripslashes($dataMsg['from_email']);
			
			if( $remainder == "1" ) 
				$subject = stripslashes($dataMsg['reminder_subject']);
			else
				$subject = stripslashes($dataMsg['subject']);
			
			$sql = "SELECT u.id, u.fname , u.lname , u.email , u.password , u.unick_ses FROM net_users as u , net_users_belong as ub WHERE u.id = '".$user_id."' AND u.verify = 1 AND u.sendMailActive = 0 AND u.id=ub.net_user_id  AND ub.unk = '".$dataSetting['unk']."' AND ub.sendMailActive=0 AND ub.status=0 ";
			$resUser = mysql_db_query(DB,$sql);
			$dataUser = mysql_fetch_array($resUser);
			
			if( $dataUser['id'] != "" )
			{
				$sql = "SELECT domain FROM users WHERE unk = '".$dataSetting['unk']."' ";
				$resDomain = mysql_db_query(DB,$sql);
				$dataDomain = mysql_fetch_array($resDomain);
				
				
				$sendTOemail = stripslashes($dataUser['email']);
				$full_name = stripslashes($dataUser['fname']) . " " . stripslashes($dataUser['lname']);
				
				$content = "<p class=texttRed>".stripslashes($dataMsg['summary'])."</p>";
				$content .= "<p class=textt>".stripslashes($dataMsg['body'])."</p>";
				
				$new_content = str_replace("#שםפרטי#" , stripslashes($dataUser['fname']) , $content );
				$new_content = str_replace("#שםמשפחה#" , stripslashes($dataUser['lname']) , $new_content );
				$new_content = str_replace("#אימייל#" , stripslashes($dataUser['email']) , $new_content );
				$new_content = str_replace("#סיסמה#" , stripslashes($dataUser['password']) , $new_content );
				$new_content = str_replace("#קישור#" , "<a href='".stripslashes($dataMsg['goto_page'])."&uses=".$dataUser['unick_ses']."&it=".md5($dataMsg['id'])."' class='text_link'>".stripslashes($dataMsg['goto_page'])."</a>" , $new_content );
				
				
				$sql = "INSERT INTO net_mailing_users_received_msg ( user_id , mail_id , mailing_id , date_send ) VALUES ( '".$user_id."' , '".$dataMsg['id']."' , '".$mailing_id."' , NOW() )";
				$resSaveRecevied = mysql_db_query(DB,$sql);
				$mailIdTemp = mysql_insert_id();
				
				
				$content_send_to_Client = "
				<html dir=rtl>
				<head>
						<title>".$subject."</title>
						<style>
							.textt{font-family: arial; font-size:12px; color: #000000}
							.texttRed{font-family: arial; font-size:12px; color: red}
							.text_link{font-family: arial; font-size:12px; color: navy}
						</style>
				</head>
				
				<body>
					<p class='textt' dir=rtl align=right>".$new_content."</p>
					<p class='textt' style='font-size: 11px;'><a href='http://".$dataDomain['domain']."?m=net_mail_removeChossen&s=".$dataUser['unick_ses']."' class='text_link' target='_blank'>לחץ כאן להסרה מרשימת לתפוצה</a></p>
				
					<img src='http://www.ilbiz.co.il/newsite/net_system/track_newMailing.php?mail_id=".$dataMsg['id']."&mailing_id=".$mailing_id."&tid=".$mailIdTemp."' width=1 height=1>
				</body>
				</html>";
				
				GlobalFunctions::send_emails_with_phpmailer($from_email, $from_name, $subject, $content_send_to_Client, $content_send_to_Client, $sendTOemail, $full_name );
				//GlobalFunctions::send_emails_with_phpmailer($from_email, $from_name, $subject, $content_send_to_Client, $content_send_to_Client, "vladi03@gmail.com", $full_name );
				
			
				if( $mail_number == "1" )
				{
					$sql = "UPDATE net_mailing_queue_users set sent=1 WHERE user_id = '".$user_id."' AND mailing_id = '".$mailing_id."' ";
					$resSent = mysql_db_query(DB,$sql);
					
					return $mailIdTemp;
				}
			}
		}
	}
	
}

