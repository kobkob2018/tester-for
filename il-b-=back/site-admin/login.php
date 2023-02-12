<?
/* 
* Copyright © 2006 ILbiz. All Rights Reserved
* email:	webmaster@ilbiz.co.il
* 
*/

ob_start();
session_start();

require('../global_func/vars.php');



if($_POST['username'] != "" && $_POST['password'] != "" )	{
$_POST['username'] = str_replace("'","''",$_POST['username']);
$_POST['password'] = str_replace("'","''",$_POST['password']);
$temp_date = getDate();
$year = $temp_date['year'];
$mon = $temp_date['mon'];
$day = $temp_date['mday'];

$end_date = $year."-".$mon."-".$day;

	$sql = "select id from sites_owner where 
	username = '".$_POST['username']."' and 
	password = '".$_POST['password']."' and 
	deleted = '0' and 
	status = '0' and 
	end_date >= '".$end_date."'";
	$res = mysql_db_query($db,$sql);
	$data = mysql_fetch_array($res);
	
	$the_key = $data['id'];

		if($the_key != "")	{
			$ss1  = time("H:m:s",1000000000);
			$ss1 = str_replace(":",3,$ss1); 
			$ss2 = $_SERVER[REMOTE_ADDR];
			$ss2 = str_replace(".",3,$ss2); 
			$sesid = $ss2."529".$ss1;
			
			
			$sql = "insert into login_trace(user,session_idd,ip) values('".$data['id']."','".$sesid."','".$_SERVER['REMOTE_ADDR']."')";

			$res = mysql_db_query($db,$sql);
			
			//notify ilan about login
			$to = "ilan@il-biz.com";
			$subject = "בוצעה כניסה למערכת ניהול ראשית";
			$message = "username:".$_POST['username']."\n user ID:".$data['id']."\n sesid: ".$sesid."\n ip:".$_SERVER['REMOTE_ADDR']."";
			mail ($to ,$subject ,$message);
			
			echo "<form action='index.php' method='post' name='formi'>";
			echo "<input type='hidden' name='sesid' value='".$sesid."'>";
			echo "</form>loading...";
			echo "<script>formi.submit()</script>";
		}
	else
		{
			echo "<script>alert('הפרטים שהזנתם אינם נכונים, נסו שוב');</script>";
		}
}

$message = ($message == "")? "<script>alert('אנא מלאו את שם המשתמש והסיסמא שלכם');</script>" : $message;

?>

<html>
<head>
	<meta HTTP-EQUIV='Content-Type' CONTENT='text/html; charset=windows-1255'/>
	<title>..::  SITE - ADMIN  ::..</title>
	<script src="script.js" type="text/javascript"></script>
	
	<style>
		BODY	{
			BACKGROUND-COLOR: #f4f4f4;
		}
		
		.maintext	{
			color: #000000;
			font-family: sans-serif;
			font-size: 12px;
			text-decoration: none;
		}

		.maintext a:link {text-decoration:underline;color:#000000;}
		.maintext a:active{text-decoration:underline;color:#000000;}
		.maintext a:visited{text-decoration:underline;color:#000000;}
		.maintext a:hover{text-decoration:underline;color:#000000;}
		
		.headline	{
			color: #000000;
			font-family: sans-serif;
			font-size: 13px;
			text-decoration: none;
			font-weight: bold;
		}

		.input_style	{
			color: #000000;
			font-family: sans-serif;
			font-size: 12px;
			text-decoration: none;
			border-bottom: 1px solid #666666;
			border-top: 1px solid #666666;
			border-right: 1px solid #666666;
			border-left: 1px solid #666666;
			background-color: #eaeaea;
			width: 200px;
			height: 19px;
		}
		
		.submit_style	{
			color: #000000;
			font-family: sans-serif;
			font-size: 12px;
			text-decoration: none;
			border-bottom: 1px solid #666666;
			border-top: 1px solid #666666;
			border-right: 1px solid #666666;
			border-left: 1px solid #666666;
			background-color: #eaeaea;
			width: 100px;
			height: 19px;
		}
</style>
</head>

<body leftmargin="0" topmargin="20" rightmargin="0" bottommargin="0" marginwidth="0" marginheight="0">


<table border="0" cellspacing="0" cellpadding="0" class="right_menu" align="center" dir="rtl">
<form action="login.php" name="login_form" method="POST">
	<tr>
		<td>
			<fieldset id="dims">
                <legend class="headline">התחברות למערכת</legend>
				<table class="maintext" align="left" width="400">
					<tr>
						<td>
							<table border="0" cellspacing="0" cellpadding="0" class="maintext" align="center">
								<tr><td colspan="3" height="40"></td></tr>
								<tr>
									<td>שם משתמש</td>
									<td width="10"></td>
									<td><input type="Text" name="username" class="input_style"></td>
								</tr>
								<tr><td colspan="3" height="10"></td></tr>
								<tr>
									<td>סיסמא</td>
									<td width="10"></td>
									<td><input type="Password" name="password" class="input_style"></td>
								</tr>
								<tr><td colspan="3" height="10"></td></tr>
								<tr>
									<td>&nbsp;</td>
									<td width="10"></td>
									<td><input type="Submit" value="התחבר" class="submit_style"></td>
								</tr>
								<tr><td colspan="3" height="20"></td></tr>
							</table>
						</td>
						<td width="5"></td>
					</tr>
					<tr><td height="5"></td></tr>
                </table>
		</fieldset>
	</td>
	</tr>

</form>
</table>

</body>
</html>
