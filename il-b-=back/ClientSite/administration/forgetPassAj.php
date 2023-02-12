<?php

header('Content-type: text/html; charset=windows-1255');
ob_start();
session_start();

require('../../global_func/vars.php');
require("../../global_func/global_functions.php");
require("../../global_func/class.phpmailer.php");


$email = mysql_real_escape_string($_POST['email_forget']);

$sql = "SELECT id, status , username , password, active_manager , name , email FROM users WHERE email LIKE '%".$email."%' AND deleted=0 LIMIT 1";
$res = mysql_db_query(DB,$sql);
$data = mysql_fetch_array($res);

if( $data['status'] == "0" && $data['active_manager'] == "0" && $data['id'] > '0' )
{
	sendMail($data , $email);
	$text = "הפרטים נשלחו בהצלחה לכתובת האימייל שציינת";
}
else{
	echo "<html><head><script>window.setTimeout(function(){window.location.reload(true);},2000)</script></head>";
	$text = "פרטים אינם נכונים, אנא נסה שנית ";
}

echo "<p style='font-family: arial; font-size: 13px; color:#000000; padding:0; margin:0;' dir=rtl align=center>".$text."</p>";


function sendMail($data , $sendToMail)
{
	if( GlobalFunctions::validate_email_address($sendToMail) )
	{
		$fromEmail = "support@ilbiz.co.il"; 
		$fromTitle = "IL-BIZ"; 
		
		$content = "
		שלום ".stripslashes($data['name']).",<br><br>
		בהמשך לבקשתך לשחזור סיסמה, להלן פרטיך:<br><br>
		שם משתמש: ".stripslashes($data['username'])."<br>
		סיסמה: ".stripslashes($data['password'])."<br>
		";
		
		$content .= "<br>
		בברכה,<br>
		איי אל ביז קידום עסקים באינטרנט<br>";
		
		$header= "שחזור סיסמה";
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
				<p class='textt' dir=rtl align=right>".$content."</p>
			</body>
			</html>";
		
		$ClientMail = $sendToMail;
		GlobalFunctions::send_emails_with_phpmailer($fromEmail, $fromTitle, $header, $content_send_to_Client, $content_send_to_Client, $ClientMail, $fromTitle );
	}
}