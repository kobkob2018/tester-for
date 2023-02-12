<?

header('content-type:TEXT/HTML; charset=UTF-8');
####################################
##
##	File create dinamic xml file for client site flash
##	
##	
####################################

require('/home/ilan123/domains/ilbiz.co.il/public_html/global_func/vars.php');

mysql_query("SET NAMES 'utf-8'");

/*
**
**
	The page will call by micropay server by GET url
	if you want to change the url PATH u can do it in micropay admin
**
	the page is used utf-8
**
**
	the page will recive:
		code - which service
		sms - what client wrote in his message
		phone
		net - 97250 - Pelephone, 97252 - Cellcom, 97254 - Orange, 97257 - Mirs.
		cid - micropay message id.
		msgid - uniqe msg id
		md5 - md5 uniqe code his "ASDas356jB34Abs2MSH5422XZCDVsc"
		key - is ASDas356jB34Abs2MSH5422XZCDVsc
**
**
**
	what you echo in this page will send to client
	echo 0 - is error.
**
**
	if u want castum error message the syntaks:
		echo "this is my error message[]error";
		
**
**
*/

// ** You can turn the md5 check only if you send the request from a form or url
//if( $_GET['md5'] == md5($_GET['key']) )
//{
	switch( $_GET['code'] )
	{
		case "הטבה" :
			if( isset($_GET["sms"]) )
			{
				$sms = trim($_GET["sms"]);
				
				$sql = "SELECT sms_content FROM products_kupons WHERE id = '".$sms."' ";
				$res = mysql_db_query(DB,$sql);
				$data = mysql_fetch_array($res);
				
				if( $data['sms_content'] != '' )
					echo stripslashes($data['sms_content']);
				else
					echo "שגיאה - לא נמצא מוצר []error";		// error message
			}
		break;
		
		default : echo "שגיאה []error";
	}
//}
//else
//	echo "error 1[]error";		// error message