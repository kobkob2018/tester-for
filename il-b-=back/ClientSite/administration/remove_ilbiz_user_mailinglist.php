<?

header('Content-Type:text/html; charset=windows-1255');
require('/home/ilan123/domains/ilbiz.co.il/public_html/global_func/vars.php');

$decrypted = base64_decode($_GET['u']);

if( $_GET['u']  != "" )
{
	$sql = "SELECT id,unk FROM users WHERE unk = '".$decrypted."'";
	$res = mysql_db_query(DB, $sql );
	$unk = mysql_fetch_array($res);
	
	if( $unk['unk'] == $decrypted )
	{
		$sql = "UPDATE users SET active_send_email = '1' WHERE unk = '".$decrypted."' limit 1";
		$res = mysql_db_query(DB, $sql );
		
		echo "הוסרת מן רשימת התפוצה בהצלחה!";
	}
	else
		echo "(פעולה נכשלה (2<br>יש ללחוץ שוב על קישור האימות";
}
else
	echo "(פעולה נכשלה (1<br>יש ללחוץ שוב על קישור האימות";


?>