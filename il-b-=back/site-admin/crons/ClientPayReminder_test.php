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
 
function auto_user_contact_form()
{
	global $date_reported;
    $timestamp = time();
    
    if (date('j', $timestamp) == '1') { // Check if it's the first day on the month.
                                      // get only user that need to get the report.
        $sql = "SELECT DISTINCT u.unk,u.full_name, u.email from user_bookkeeping as ub inner join users as u on (u.unk = ub.unk) where ub.sendReport =1";
        $resUnk = mysql_db_query(DB, $sql);
        
        while ($dataBig = mysql_fetch_assoc($resUnk)) {  // loop over all the relevant users 
            $unk = $dataBig['unk'];
            $full_name = stripslashes($dataBig['full_name']);
            $email = $data['email'];
            $leadCounter=0;
            $row_leads_arr = array();

		  // SQL query that get by the user unk - the user contact forms between the date of the date right now -1 , and the the day before a month.
		  $sql2 = "SELECT  distinct unk,phone,email,name,content,status,lead_recource,date_in FROM user_contact_forms WHERE unk = '" . $unk . "' AND date_in >= DATE_FORMAT(CURRENT_DATE - INTERVAL 1 MONTH, '%Y-%m-01') AND date_in <= DATE_FORMAT(CURRENT_DATE, '%Y-%m-01')";
		  $result = mysql_db_query(DB, $sql2);
		  
		  // SQL query that get the phones call
		  $sql3 = "SELECT distinct sms_send,call_from,answer,call_date,billsec  FROM sites_leads_stat WHERE unk = '".$unk."' AND `call_date` >= DATE_FORMAT(CURRENT_DATE - INTERVAL 1 MONTH, '%Y-%m-01') AND `call_date` <= DATE_FORMAT(CURRENT_DATE, '%Y-%m-01')";
		  $res = mysql_db_query(DB, $sql3);
		  $phones_refunded = array();
		  $refund_total = 0;
		  $leads_doubled = array();
		  $leadCounter_all = 0;
		  $leads_doubled_counter = 0;
		  $row_leads_arr[] = array('רשימת טופסי צור קשר:');
		  $row_leads_arr[] = array('תאריך', 'שם מלא', 'דוא"ל', 'טלפון', 'תוכן' , 'מקור הליד','קיבל זיכוי' );
		  $phones = array(); 
		  while ($data = mysql_fetch_assoc($result)) {
			  if($data['status'] == '6'){
				  $phones_refunded[$data['phone']] = '1';
				  $refund_total++;
			  }
			  if($data['lead_recource'] != 'form'){
				  continue;
			  }
			  if (! isValidPhone($data['phone'])) { // phone validation.
				  continue; 
			  }
			  $leadCounter_all++;
			
			  if(in_array($data['phone'], $phones)){ // Verify uniq phone call 
				  $leads_doubled_counter++;
				  $leads_doubled[] = $data;
				  continue;
			  }
			  $phones[] = $data['phone'];
			  $refunded = "לא";
			  if(isset($phones_refunded[$data['phone']])){
				  $refunded = "כן";
			  }
			  $row_leads_arr[] = array( stripslashes($data['date_in']) , stripslashes($data['name']) , stripslashes($data['email']) , stripslashes($data['phone']) , stripslashes($data['content']) , 'טופס באתר',$refunded );
			  $leadCounter++;
		  }
		  $row_leads_arr[] = array("----");
		  $phones_doubled = array();
		  $row_leads_arr[] = array('רשימת טלפונים שהתקבלו:');
		  while ($data = mysql_fetch_assoc($res)) {
			  $leadCounter_all++;
			  if(in_array($data['call_from'], $phones)){ // Verify uniq phone call 
				 $leads_doubled_counter++;
				$phones_doubled[] = $data;
				  continue;
			  }
			  $refunded = "לא";
			  if(isset($phones_refunded[$data['call_from']])){
				  $refunded = "כן";
			  }
			  $answ = ( $data['billsec'] == '0' ) ? "ללא מענה" : "שיחה של ".$data['billsec']." שניות";
			  $row_leads_arr[] = array( stripslashes($data['call_date']) , '' , '' , stripslashes($data['call_from'])  , $answ , 'מערכת טלפונייה',$refunded );
			  $phones[] = $data['call_from'];
			  $leadCounter++;
		  }
		  $row_leads_arr[] = array("----");
		  $row_leads_arr[] = array('כפילויות בטפסים');
		  foreach($leads_doubled as $data){
			  $row_leads_arr[] = array( stripslashes($data['date_in']) , stripslashes($data['name']) , stripslashes($data['email']) , stripslashes($data['phone']) , stripslashes($data['content']) , 'טופס באתר',$refunded );
		  }
		  $row_leads_arr[] = array("----");
		  $row_leads_arr[] = array('כפילויות טלפונים');
		  foreach($phones_doubled as $data){
			 $row_leads_arr[] = array( stripslashes($data['call_date']) , '' , '' , stripslashes($data['call_from'])  , $answ , 'מערכת טלפונייה',$refunded );
		  }
		$row_leads_arr[] = array("----");  
		  $row_leads_arr[] = array('סך הכל פניות' , $leadCounter_all );
		  $row_leads_arr[] = array('לידים כפולים' , $leads_doubled_counter );
		  $row_leads_arr[] = array('פניות שחויבו' , $leadCounter );
		  $row_leads_arr[] = array('סך הכל זיכויים' , $refund_total );
		  $row_leads_arr[] = array('סך הכל לחיוב' , ($leadCounter - $refund_total) );
            // Check if the user need to pay about the leads by period payment
            $sql = "SELECT ub.unk, ub.advertisingPeriod , ub.leadPrice, ub.leadPercentOff, ub.domainEndDate,  ub.advertisingPrice , ub.advertisingStartDate, u.owner_id , u.email , u.full_name FROM user_bookkeeping as ub, users as u WHERE ub.unk=u.unk AND u.unk = '" . $unk ."' AND ub.advertisingPeriod > 0 AND ub.leadPrice > 0";
            $resDOMAINS = mysql_db_query(DB, $sql);
            
            if($data = mysql_fetch_array($resDOMAINS)){
                // Calculate the payment per lead
                if (isset($data['leadPercentOff']) && $data['leadPercentOff'] > 0) {
                    $leadPrice = $data['leadPrice'] - ($data['leadPrice'] * $data['leadPercentOff'] / 100);
                } else {
                    $leadPrice = $data['leadPrice'];
                }    
                // Send payment request to user           
                launch_fee_to_client_DB_custom($data['owner_id'], $unk, $leadPrice*$leadCounter, 1, $leadCounter.' לידים מאתר שירות 10 לתאריך '. $date_reported, $until_date, $leadCounter, $data['email'] , $data['full_name'] );
            }
            // Send report to user
            
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
                       	סך הכל לידים שקבלת בחודש שעבר: ".$leadCounter."<br>
                       	תוכל למצוא את הדוח מצורף לאימייל.<br><br>
                       	בברכה,<br>
                       	צוות איי אל ביז קידום עסקים באינטרנט
                        </p>
                    </body>
                    </html>
                ";
            
            if( $leadCounter > 0 )
            {

echo "---------";
				//send_csv_mail($row_leads_arr, $content_mail,"yacov.avr@gmail.com","דוח לידים ל ".$date_reported );
				
				//send_csv_mail($row_leads_arr, $content_mail,"ilan@il-biz.com","דוח לידים ל ".$date_reported );
			}
        }
    }
} 
 
function auto_user_contact_form_old()
{
	global $date_reported;
    $timestamp = time();
    
    if (date('j', $timestamp) == '1') { // Check if it's the first day on the month.
                                      // get only user that need to get the report.
        /*$sql = "SELECT DISTINCT u.unk,u.full_name, u.email from user_bookkeeping as ub inner join users as u on (u.unk = ub.unk) where ub.sendReport =1";
        $resUnk = mysql_db_query(DB, $sql);
        $headers = "MIME-Version: 1.0\r\n";
        $headers .= "Content-type: text/html; charset=windows-1255-1\r\n";
        $headers .= "From:ilbiz@ilbiz.com<ilbiz@ilbiz.com>\r\n";
        while ($data = mysql_fetch_assoc($resUnk)) {  // loop over all the relevant users 
            $unk = $data['unk'];
            $full_name = $data['full_name'];
            $email = $data['email'];
            $leadCounter=0;
            $content = "
                <style>
                    body{
                        text-align:right;
                    }
                    h1{
                        font-size: 14px;
                        margin: 0px;
                        padding: 0px;
                    }
                    table { border:1px solid black; border-collapse:collapse; float:right; text-align:right}
                    th,td { border: 1px solid #BDBABA; }
                    td {width: 140px;}
                </style>   
                <h1>שלום " . $full_name . ",</h1>
                <h1>רשימת אנשי קשר אשר התקבלו בחודש האחרון:</h1>
                <br/>
                <table border='1'>
                    <thead>
                        <tr style='background-color: rgb(221, 221, 221);'>               
                            <td>שם מלא</td>
                            <td>דוא\"ל</td>
                            <td>נשלח SMS</td>
                            <td>סלולארי</td>
                            <td>טלפון</td>
                            <td width='170'>תוכן</td>
                            <td>מקור הליד</td>
                            <td>תאריך</td>
                        </tr>
                    </thead>
                    <tbody>
                ";
            
            // SQL query that get by the user unk - the user contact forms between the date of the date right now -1 , and the the day before a month.
            $sql2 = "SELECT  distinct unk,phone,email,name,content,date_in FROM user_contact_forms WHERE unk = '" . $unk . "' AND user_contact_forms.date_in between  DATE_ADD( now( ) , INTERVAL -1 MONTH ) and DATE_ADD( now( ) , INTERVAL -1 DAY )";
            $result = mysql_db_query(DB, $sql2);
            // SQL query that get the phones call
            $sql3 = "SELECT distinct sms_send,call_from,answer,call_date,billsec  FROM sites_leads_stat WHERE unk = '$unk' AND `date` between DATE_SUB(NOW(), INTERVAL 1 MONTH) and DATE_SUB( now( ) , INTERVAL 1 DAY ) order by id";
            $res = mysql_db_query(DB, $sql3);
            
            while ($data = mysql_fetch_assoc($result)) {
                if (! isValidPhone($data['phone'])) { // phone validation.
                    continue; 
                }
                $content .= "
                    <tr>
                        <td>
                            " . stripslashes($data['name']) . "
                        </td>
                        <td>
                            " . stripslashes($data['email']) . "
                        </td>
                        <td>
                            לא רלוונטי    
                        </td>
                        <td>
                            " . stripslashes($data['mobile']) . "
                        </td>
                        <td>
                            " . stripslashes($data['phone']) . "
                        </td>
                        <td>
                            " . stripslashes($data['content']) . "
                        </td>
                        <td>
                         טופס באתר          
                        </td>
                        <td>
                            " . stripslashes($data['date_in']) . "
                        </td>
                    </tr>
                    ";
                $leadCounter++;
            }
           $phones = array(); 
            while ($data = mysql_fetch_assoc($res)) {
                if(in_array($data['call_from'], $phones)){ // Verify uniq phone call 
                    continue;
                }
                $phones[] = $data['call_from'];
                $content .= "
                    <tr>
                        <td>
                           לא רלוונטי
                        </td>
                        <td>
                           לא רלוונטי
                        </td>
                       
                        <td>
                          " . stripslashes($data['sms_send']) . "    
                        </td>
                        <td>
                            " . stripslashes($data['call_from']) . "
                        </td>
                        
                        <td>
                            לא רלוונטי      
                        </td>      
                       <td>
                            " . stripslashes($data['answer']) . " - ".$data['billsec']." דקות שיחה
                        </td>
                        <td>
                            מערכת טלפונייה
                        </td>
                        <td>
                             " . stripslashes($data['call_date']) . "
                        </td>
                    </tr>
                    ";
                $leadCounter++;
            }
            // add the total and close the table
            $content .= "
                </tbody>
                <tfooter>
                    <tr><td>סה\"כ פניות</td><td colspan=\"7\">$leadCounter</td></tr> 
                </tfooter>
            </table>
        <br/>";
            
            // Check if the user need to pay about the leads by period payment
            $sql = "SELECT ub.unk, ub.advertisingPeriod , ub.leadPrice, ub.leadPercentOff, ub.domainEndDate,  ub.advertisingPrice , ub.advertisingStartDate, u.owner_id , u.email FROM user_bookkeeping as ub, users as u WHERE ub.unk=u.unk AND unk = " . $unk ." AND ub.advertisingPeriod > 0 AND (ub.advertisingPrice > 0 OR ub.leadPrice > 0)";
            $resDOMAINS = mysql_db_query(DB, $sql);
            if($data = mysql_fetch_array($resDOMAINS)){
                // Calculate the payment per lead
                if (isset($data['leadPercentOff']) && $data['leadPercentOff'] > 0) {
                    $leadPrice = $data['leadPrice'] * $data['leadPercentOff'] / 100;
                } else {
                    $leadPrice = $data['leadPrice'];
                }    
                // Send payment request to user           
                //launch_fee_to_client_DB_custom($data['owner_id'], $unk, $leadPrice*$leadCounter, 1, 'לידים משירות 10 לחודש '. date('m', $timestamp), $until_date, $leadCounter, $data['email']);
            }
            // Send report to user
            //mail($data['email'], "דוח קבלת פרטי משתמשים", $content, $headers); // sending mail.
            mail("vladi03@gmail.com", "דוח קבלת פרטי משתמשים", $content, $headers); // sending mail.
        }
        */
       	
        $sql = "SELECT DISTINCT u.unk,u.full_name, u.email from user_bookkeeping as ub inner join users as u on (u.unk = ub.unk) where ub.sendReport =1";
        $resUnk = mysql_db_query(DB, $sql);
        
        while ($dataBig = mysql_fetch_assoc($resUnk)) {  // loop over all the relevant users 
            $unk = $dataBig['unk'];
            $full_name = stripslashes($dataBig['full_name']);
            $email = $data['email'];
            $leadCounter=0;
            $row_leads_arr = array();
   
            // SQL query that get by the user unk - the user contact forms between the date of the date right now -1 , and the the day before a month.
            $sql2 = "SELECT  distinct unk,phone,email,name,content,date_in FROM user_contact_forms WHERE unk = '" . $unk . "' AND user_contact_forms.date_in >= DATE_FORMAT(CURRENT_DATE - INTERVAL 1 MONTH, '%Y-%m-01') AND user_contact_forms.date_in < DATE_FORMAT(CURRENT_DATE, '%Y-%m-01')";
            $result = mysql_db_query(DB, $sql2);
            
            // SQL query that get the phones call
            $sql3 = "SELECT distinct sms_send,call_from,answer,call_date,billsec  FROM sites_leads_stat WHERE unk = '".$unk."' AND `call_date` >= DATE_FORMAT(CURRENT_DATE - INTERVAL 1 MONTH, '%Y-%m-01') AND `call_date` < DATE_FORMAT(CURRENT_DATE, '%Y-%m-01') order by id";
            $res = mysql_db_query(DB, $sql3);
            
            $row_leads_arr[] = array('רשימת טופסי צור קשר:');
            $row_leads_arr[] = array('תאריך', 'שם מלא', 'דוא"ל', 'טלפון', 'תוכן' , 'מקור הליד' );
            $phones = array(); 
            while ($data = mysql_fetch_assoc($result)) {
                if (! isValidPhone($data['phone'])) { // phone validation.
                    continue; 
                }
                if(in_array($data['phone'], $phones)){ // Verify uniq phone call 
                    continue;
                }
                $phones[] = $data['phone'];
                $row_leads_arr[] = array( stripslashes($data['date_in']) , stripslashes($data['name']) , stripslashes($data['email']) , stripslashes($data['phone']) , stripslashes($data['content']) , 'טופס באתר' );
                
                $leadCounter++;
            }
            
            $row_leads_arr[] = array('רשימת טלפונים שהתקבלו:');
            while ($data = mysql_fetch_assoc($res)) {
                if(in_array($data['call_from'], $phones)){ // Verify uniq phone call 
                    continue;
                }
                $answ = ( $data['billsec'] == '0' ) ? "ללא מענה" : "שיחה של ".$data['billsec']." שניות";
                $row_leads_arr[] = array( stripslashes($data['call_date']) , '' , '' , stripslashes($data['call_from'])  , $answ , 'מערכת טלפונייה' );
                $phones[] = $data['call_from'];
                $leadCounter++;
            }
            
            $row_leads_arr[] = array('סך הכל פניות' , $leadCounter );
            
            // Check if the user need to pay about the leads by period payment
            $sql = "SELECT ub.unk, ub.advertisingPeriod , ub.leadPrice, ub.leadPercentOff, ub.domainEndDate,  ub.advertisingPrice , ub.advertisingStartDate, u.owner_id , u.email , u.full_name FROM user_bookkeeping as ub, users as u WHERE ub.unk=u.unk AND u.unk = '" . $unk ."' AND ub.advertisingPeriod > 0 AND ub.leadPrice > 0";
            $resDOMAINS = mysql_db_query(DB, $sql);
            
            if($data = mysql_fetch_array($resDOMAINS)){
                // Calculate the payment per lead
                if (isset($data['leadPercentOff']) && $data['leadPercentOff'] > 0) {
                    $leadPrice = $data['leadPrice'] - ($data['leadPrice'] * $data['leadPercentOff'] / 100);
                } else {
                    $leadPrice = $data['leadPrice'];
                }    
                // Send payment request to user           
                launch_fee_to_client_DB_custom($data['owner_id'], $unk, $leadPrice*$leadCounter, 1, $leadCounter.' לידים מאתר שירות 10 לתאריך '. $date_reported, $until_date, $leadCounter, $data['email'] , $data['full_name'] );
            }
            // Send report to user
            
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
                       	סך הכל לידים שקבלת בחודש שעבר: ".$leadCounter."<br>
                       	תוכל למצוא את הדוח מצורף לאימייל.<br><br>
                       	בברכה,<br>
                       	צוות איי אל ביז קידום עסקים באינטרנט
                        </p>
                    </body>
                    </html>
                ";
            
            if( $leadCounter > 0 )
            {
							//send_csv_mail($row_leads_arr, $content_mail,"ilan@il-biz.com","דוח לידים ל ".$date_reported );
							send_csv_mail($row_leads_arr, $content_mail, $dataBig['email'] ,"דוח לידים ל ".$date_reported );
							send_csv_mail($row_leads_arr, $content_mail,"ilan@il-biz.com","דוח לידים ל ".$date_reported );
							send_csv_mail($row_leads_arr, $content_mail,"vladi03@gmail.com","דוח לידים ל ".$date_reported );
						}
        }
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


function send_csv_mail ($csvData, $body, $to, $subject, $from = 'ilbiz@ilbiz.com')
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
        if (($module == 0) && ($nowDay == $adDay) && ($adYear < $nowYear || $nowMonth != $adMonth)) { // module exists and is 0, months diff are more than 0 , same days.     
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
    $subject = "תזכורת חשובה";
    
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
שלום רב " . stripslashes($full_name) . "<br><br>
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
<li>הפקדה לחשבון בנק ע\"ש איי. אל. ביז קידום עסקים באינטרנט בע\"מ, בנק הפועלים, סניף 477 , מספר חשבון 71732</li>
</ol>
<b>* לאחר התשלום ישלח לאימייל שיצויין בטופס, חשבונית מס קבלה מקורית עם חתימה דגיטלית</b><br><br>
<b>*** עלות החזרת אתר שהורד על ידי המערכת האוטומטית מהאינטרנט  – 250 ₪ + מע\"מ</b>
";
    } elseif ($type == 1) {
        $maam = (MAAM * $dataPrice['domainPrice']) / 100;
        $domainYear = $dataPrice['domainPrice'] + $maam;
        
        // $nikoiMas = ( $domainYear ) * 0.02 ;
        // $domainYear_NEW = $domainYear - $nikoiMas;
        
        $content = "
שלום רב " . stripslashes($full_name) . "<br><br>
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
<li>הפקדה לחשבון בנק ע\"ש איי. אל. ביז קידום עסקים באינטרנט בע\"מ, בנק הפועלים, סניף 477 , מספר חשבון 71732</li>
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
   
     GlobalFunctions::send_emails_with_phpmailer($from_email, $from_name, $subject, $content_send_to_Client, $content_send_to_Client, $sendTOemail, $full_name );
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
    if (isset($email_to_send)) { // Make the process only if the customer mail is available.
        $untilDate1 = explode("-", $until_date);
        $untilDate = $untilDate1[2] . "-" . $untilDate1[1] . "-" . $untilDate1[0];
        
        $uniqueSes = md5($_SERVER[REMOTE_ADDR] . "-" . date('dmyHis'));
        
        // Enter payment request to DB and client will see it in is admin Panel
        $sql = "INSERT INTO ilbiz_launch_fee ( owner_id , unk , price , tash , details , until_date , email_to_send , uniqueSes ) VALUES (
         '" . $oid . "' , '" . $unk . "' , '" . myround($price) . "' , '" . $tash . "' , '" . $details . "' ,
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
                        שלום רב ".$full_name.",<br><br>
			קיבלת הודעת תשלום עבור: " . $details . "<br>
			על סך " . myround($price) . " ש\"ח כולל מע\"מ.<br><br>
			<a href='http://www.ilbiz.co.il/ClientSite/administration/pay.php?uniqueSes=" . $uniqueSes . "' class='text_link'><u>לחץ כאן</u></a> בתשלום מיידי בכרטיס אשראי.<br><br>
			בברכה,<br>
			איי אל ביז קידום עסקים באינטרנט
                        </p>
                    </body>
                    </html>";

        $headers = "MIME-Version: 1.0\r\n";
        $headers .= "Content-type: text/html; charset=windows-1255-1\r\n";
        $headers .= "From:ilbiz@ilbiz.co.il<ilbiz@ilbiz.co.il>\r\n";
        
        mail($email_to_send, "בקשה לתשלום אוטומטי", $fullmsg, $headers);
        mail("ilan@il-biz.com", "בקשה לתשלום אוטומטי", $fullmsg, $headers);
        mail("vladi03@gmail.com", "בקשה לתשלום אוטומטי", $fullmsg, $headers);
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