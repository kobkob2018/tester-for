<?php
require ('../../global_func/vars.php');
require ('../../global_func/class.phpmailer.php');
require ('../../global_func/global_functions.php');

require ("../../global_func/classes/class.lead.sys.php");

define('ROUND_HALF_DOWN', 1);
define('ROUND_HALF_EVEN', 2);
define('ROUND_HALF_UP', 3);

$user_sql = "SELECT full_name,email from users where email = '".$_GET['test']."'";
$user_res = mysql_db_query(DB, $user_sql);
	
$user_data = mysql_fetch_assoc($user_res));
if($user_data['email'] == ""){
	exit("no user found");
}
$full_name = $user_data['full_name'];
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
			 זוהי בדיקה לפורמט תקין "
			 .$date_reported."<br>
			בדיקה לפורמט: "
			.$sum_total_leads_to_pay."<br>
			בדיקה.
			<br><br>
			בברכה,
			<br>
			צוות איי אל ביז קידום עסקים באינטרנט
			</p>
		</body>
	</html>
";
$row_leads_arr = array();
$row_leads_arr[] = array('רשימת טופסי צור קשר:');
$row_leads_arr[] = array('תאריך', 'שם מלא', 'דוא"ל', 'טלפון','פתוח' , 'מקור הליד','קיבל זיכוי', 'תוכן' );
send_csv_mail($row_leads_arr, $content_mail,"yacov.avr@gmail.com","בדיקת פורמט עם לקוח ".$full_name."(".time()")" );

exit();



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