<?php
/* 
* Copyright ן¿½ 2006 ILbiz. All Rights Reserved
* email:	webmaster@ilbiz.co.il
* 
* unk = user_id
* sesid = user session that change per log
*/

ob_start();
session_start();

require('../../global_func/vars.php');

setcookie("panelAdmin", "provide_insert_to_user_admin", time()-3600 , '/' );

if( $_GET['change_lang'] == "1" )
{
	setcookie("managerLang" , "" , time()- 3600 );
	setcookie("managerLang" , $_GET['admin_lang'] , time()+60*60*24*30 );
	$_COOKIE['managerLang'] = $_GET['admin_lang'];
}



$cookie_lang = ( $_COOKIE['managerLang'] == "" ) ? "he" : $_COOKIE['managerLang'];
define('LANG',$cookie_lang);
require('/home/ilan123/domains/ilbiz.co.il/public_html/lang/administration.lang.'.$cookie_lang.'.php');

if( LANG != "he" )
{
	$site_charset = "windows-1255";
	$settings['dir'] = "ltr";
	$settings['re_dir'] = "rtl";
	$settings['align'] = "left";
	$settings['re_align'] = "right";
}
else
{
	$site_charset = "windows-1255";
	$settings['dir'] = "rtl";
	$settings['re_dir'] = "ltr";
	$settings['align'] = "right";
	$settings['re_align'] = "left";
}


if( isset($_POST['username']) && isset($_POST['password']) )
{

	if($_POST['username'] != "" && $_POST['password'] != "")	{
	$_username = str_replace("'","--",$_POST['username']);
	$_password = str_replace("'","--",$_POST['password']);	
	$temp_date = getDate();
	$year = $temp_date['year'];
	$mon = $temp_date['mon'];
	$day = $temp_date['mday'];
	
	$end_date = $year."-".$mon."-".$day;
	
		$sql = "select id,unk from users where 
		username = '".$_username."' and 
		password = '".$_password."' and 
		deleted = '0' and 
		active_manager = '0'";
		
		$res = mysql_db_query($db,$sql);
		$data = mysql_fetch_array($res);
		$unk = $data['unk'];
		$the_key = $data['id'];
		
		
		$sql_auth = "select usa.id, usa.unk from users as u , user_site_auth as usa where 
		usa.username = '".$_username."' AND 
		usa.password = '".$_password."' AND 
		usa.deleted = '0' AND 
		usa.status = '0' AND 
		usa.unk = u.unk AND
		u.active_manager = '0' AND 
		u.deleted = '0' AND 
		u.status = '0'";
		
		$res_auth = mysql_db_query($db,$sql_auth);
		$data_auth = mysql_fetch_array($res_auth);
		$unk_auth = $data_auth['unk'];
		$the_key_auth = $data_auth['id'];
		
		
			if($the_key != "")	{
				$ss1  = time("H:m:s",1000000000);
				$ss1 = str_replace(":",3,$ss1); 
				$ss2 = $_SERVER[REMOTE_ADDR];
				$ss2 = str_replace(".",3,$ss2); 
				$sesid = "$ss2$ss1";
				
				$sql = "insert into login_trace(user,session_idd,ip) values('".$data['unk']."','".$sesid."','".$_SERVER['REMOTE_ADDR']."')";
				$res = mysql_db_query($db,$sql);
				
				
				echo "<form action='../myleads/' method='post' name='formi'>";
				echo "<input type='hidden' name='sesid' value='".$sesid."'>";
				echo "<input type='hidden' name='unk' value='".$unk."'>";
				echo "</form>";
				echo "a<script>formi.submit()</script>";
			}
			elseif($the_key_auth != "")	{
				$ss11  = time("H:m:s",1000000000);
				$ss11 = str_replace(":",3,$ss11); 
				$ss21 = $_SERVER[REMOTE_ADDR];
				$ss21 = str_replace(".",3,$ss21); 
				$sesids = "$ss21$ss11";
				
				$sql = "insert into login_trace(user,session_idd,ip,auth_id) values('".$data_auth['unk']."','".$sesids."','".$_SERVER['REMOTE_ADDR']."' , '".$the_key_auth."')";
				$res2 = mysql_db_query($db,$sql);
				
				
				echo "<form action='../myleads/' method='post' name='formi'>";
				echo "<input type='hidden' name='sesid' value='".$sesids."'>";
				echo "<input type='hidden' name='unk' value='".$unk_auth."'>";
				echo "</form>";
				echo "Loading...<script>formi.submit()</script>";
			}
		else
			{
				echo "<script>alert('".$word[LANG]['login_error_1']."');</script>";
			}
	}
}

$message = "<script>alert('".$word[LANG]['login_error_2']."');</script>";

?>
<!DOCTYPE html>
<html>
<head>
	<meta HTTP-EQUIV='Content-Type' CONTENT='text/html; charset=windows-1255'/>
	<title>..::  <?=$word[LANG]['browser_title'];?>  ::..</title>
	<script src="script.js" type="text/javascript"></script>
	
	<link rel="stylesheet" href="../js/colorbox.css" />
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.8.3/jquery.min.js"></script>
	<script src="../js/jquery.colorbox-min.js"></script>
	
	<style>
		BODY	{
			BACKGROUND-COLOR: #ffffff;
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
		
		.ilbizHeadline	{
			text-decoration: none; color:#19274C; font-size: 14px; font-family: arial,sans-serif;
			font-weight: bold;
		}

		.input_style	{
			color: #000000;
			font-family: sans-serif;
			font-size: 12px;
			text-decoration: none;
			border: 1px solid #666666;
			background-color: #eaeaea;
			width: 200px;
			height: 19px;
		}
		
		.submit_style	{
			color: #000000;
			font-family: sans-serif;
			font-size: 12px;
			text-decoration: none;
			border: 1px solid #666666;
			background-color: #eaeaea;
			width: 100px;
			height: 19px;
		}
		
</style>

		<script>
			$(document).ready(function(){
				//Examples of how to assign the ColorBox event to elements
				$("#forgetPass").colorbox({inline:true, width:"50%"});
				
				var frm = $('#forget_pass_form');
				;
		    frm.submit(function () {
		    	if( ValidateEmail( $("#email_forget").val() ) )	{
		        $.ajax({
		            type: frm.attr('method'),
		            url: frm.attr('action'),
		            data: frm.serialize(),
		            success: function (data) {
		            	$("#inline_forgetPass").html(data);
		            }
		        });
		        return false;
		      }
		      else	{
		      	alert("יש להזין אימייל תקין");
		      	return false;
		      }
		    });
				
			});
			
			function ValidateEmail(email) 
			{
			 if (/^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/.test(email))
			    return (true)
			  else
			    return (false)
			}
			


			
		</script>
		
</head>

<body leftmargin="0" topmargin="20" rightmargin="0" bottommargin="0" marginwidth="0" marginheight="0">


<table border="0" cellspacing="0" cellpadding="0" class="right_menu" align="center" dir="<?=$settings['dir'];?>">

	
	<tr>
		<td>
			<table border="0" cellspacing="0" cellpadding="0" class="maintext" align="<?=$settings['align'];?>">
				<tr>
					<td><a href='http://www.il-biz.com' target='_blank'><img src='http://www.ilbiz.co.il/sn/images/il-biz_logo.jpg' border='0' alt='<?=$word[LANG]['login_logo_alt'];?>'></a></td>
				</tr>
				<tr><tD height=3></td></tR>
				<tr>
					<td align=center style='text-decoration: none; color:#19274C; font-size: 14px; font-family: arial,sans-serif;'><a href='http://www.il-biz.co.il' style='text-decoration: none; color:#19274C; font-size: 14px; font-family: arial,sans-serif;' target='_blank' title='<?=$word[LANG]['login_logo_alt'];?>'><b><?=$word[LANG]['login_logo_alt2'];?></b></a></td>
				</tr>
			</table>
			
			</tD>
	</tr>
	<tr><tD height=30></td></tR>
	<tr>
		<td>
			<fieldset id="dims">
                <legend class="headline"> <?=$word[LANG]['login_title'];?> </legend>
				<table class="maintext" align="<?=$settings['re_align'];?>" width="400">
					<tr>
						<td>
							<table border="0" cellspacing="0" cellpadding="0" class="maintext" align="center">
								<tr><td colspan="3" height="40"></td></tr>
								<?
								
								echo "<form action='loginMobile.php' name='changeLang' method='get'>
								<input type='hidden' name='change_lang' value='1'>
								<tr>
									<td>".$word[LANG]['language']."</td>
									<td width='10'></td>
									<td><select name='admin_lang' class='input_style' onchange='changeLang.submit()'>";
										$selected_1 = ( LANG == "he" ) ? "selected" : "";
										$selected_2 = ( LANG == "en" ) ? "selected" : "";
											echo "<option value='he' ".$selected_1.">עברית</option>
											<option value='en' ".$selected_2.">English</option>
										</select></td>
								</tr>
								<tr><td colspan='3' height='10'></td></tr>
								</form>";
								
								?>
								<form action="loginMobile.php" name="login_form" method="post">
								<tr>
									<td><?=$word[LANG]['username'];?></td>
									<td width="10"></td>
									<td><input type="Text" name="username" class="input_style"></td>
								</tr>
								<tr><td colspan="3" height="10"></td></tr>
								<tr>
									<td><?=$word[LANG]['password'];?></td>
									<td width="10"></td>
									<td><input type="Password" name="password" class="input_style"></td>
								</tr>
								<tr><td colspan="3" height="10"></td></tr>
								<tr>
									<td>&nbsp;</td>
									<td width="10"></td>
									<td align=left><input type="Submit" value="<?=$word[LANG]['login_submit'];?>" class="submit_style"></td>
								</tr>
								</form>
								<tr><td colspan="3" height="10"></td></tr>
								<tr>
									<td>&nbsp;</td>
									<td width="10"></td>
									<td align=left><a href='#inline_forgetPass' id="forgetPass" class='maintext'>שכחתי סיסמא</a></td>
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
	<tr><tD height=30></td></tR>
	<tr>
		<td>
			<table border="0" cellspacing="0" cellpadding="0" class="maintext" align="<?=$settings['re_align'];?>">
				<tr>
					<td><?=$word[LANG]['login_buttom_text'];?></td>
				</tr>
			</table>
			
			</tD>
	</tr>


</table>

<div style='display:none'>
	<div id="inline_forgetPass" style="padding:10px; background:#fff;">
	<form action='forgetPassAj.php' name='forget_pass_form' id='forget_pass_form' method='post'>
	<table border=0 cellpadding=0 cellspacing=0 dir=rtl align=center class='maintext'>
		<tr>
			<td>אנא הכנס את כתובת האימייל שלך</td>
			<td width=10></td>
			<td><input type='text' name='email_forget' id='email_forget' dir=ltr class='input_style'></td>
			<td width=10></td>
			<td align=left><input type="Submit" value="שלח" class="submit_style"></td>
		</tr>
	</table>
	</form>
	</div>
</div>
</body>
</html>
