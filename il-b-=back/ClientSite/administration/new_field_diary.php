<?php


//check if the user login and if the session its ok
if( $_REQUEST['unk'] == "" || $_REQUEST['sesid'] == "" )	{
	echo "<script>alert('יש להתחבר למערכת')</script>";
	echo "<script>window.location.href='login.php';</script>";
		exit;
}


require('../../global_func/vars.php');


// cheake when the session start and end 
	$sql = "select user,date,ip from login_trace where session_idd = '".$_REQUEST['sesid']."' and user = '".$_REQUEST['unk']."'";
	$res = mysql_db_query(DB,$sql);
	$data_login_trace = mysql_fetch_array($res);
	
	if( $data_login_trace['user'] != "" )
	{
		$data_login_trace_temp = explode("-",$data_login_trace['date']);
		$year = $data_login_trace_temp[0];
		$month =$data_login_trace_temp[1];
		
		$data_login_trace_temp2 = explode(" ",$data_login_trace_temp[2]);
		$day = $data_login_trace_temp2[0];
		
		$data_login_trace_temp3 = explode(":",$data_login_trace_temp2[1]);
		$hour = $data_login_trace_temp3[0];
		$minute = $data_login_trace_temp3[1];
		$secound = $data_login_trace_temp3[2];
		
		
		$DB_time1 = mktime($hour+24, $minute, $secound, $month, $day,  $year);
		$DB_time2 = date("YmdHis",$DB_time1);
		
		$expi = mktime(date("H"), date("i"), date("s"), date("m"), date("d"),  date("Y"));
		$page_expi = date("YmdHis",$expi);
		
		// check the date that is -30 min
		if($DB_time2 > $page_expi)	{
			$sql = "update login_trace set date = '".$page_expi."' where session_idd ='".$_REQUEST['sesid']."'";
			$res = mysql_db_query(DB,$sql);
		}
		else	{
			echo "<script>alert('לא נגעת בכילי המערכת במשך 30 דקות, יש להתחבר שוב');</script>";
			echo "<script>window.location.href='login.php'</script>";
			exit;
		}
	}
	else
	{
		echo "<script>alert('יש להתחבר למערכת');</script>";
		echo "<script>window.location.href='login.php'</script>";
	}
	
	if( $data_login_trace['ip'] != $_SERVER['REMOTE_ADDR'] )
	{
		echo "<script>alert('התראת אבטחה מספר 4517 יש ליצור קשר עם ההנהלה, או לנסות להתחבר שנית');</script>";
		echo "<script>window.location.href='login.php'</script>";
		exit;
	}


$type = $_GET['type'];

if( $_POST['todo'] == "DB_action" )
{
	if( !$_POST['update_id'] )
	{
		if( $_POST['type'] == 1 )
		{
			$insert_array = array(
				day=> $_POST['day'],
				mon=> $_POST['mon'],
				year=> $_POST['year'],
				hour=> $_POST['hour'],
				min=> $_POST['min'],
				unk=> $_POST['unk'],
				headline=> $_POST['headline'],
				content=> $_POST['content'],
				public_type=> $_POST['public_type'],
				sales_agent=> $_POST['sales_agent'],
				until_hour=> $_POST['until_hour'],
				url_link=> $_POST['url_link'],
				wday=> $_POST['wday'],
				type=> $_POST['type'],
			);
		}
		elseif( $_POST['type'] == 10 || $_POST['type'] == 11 )
		{
			$insert_array = array(
				day=> $_POST['day'],
				mon=> $_POST['mon'],
				year=> $_POST['year'],
				hour=> $_POST['hour'],
				min=> $_POST['min'],
				unk=> $_POST['unk'],
				headline=> $_POST['headline'],
				content=> $_POST['content'],
				public_type=> $_POST['public_type'],
				sales_agent=> $_POST['sales_agent'],
				until_hour=> $_POST['until_hour'],
				url_link=> $_POST['url_link'],
				wday=> $_POST['wday'],
				type=> $_POST['type'],
			);
		}
		
		$counter = 1;
		$sql = "insert into users_diary ( ";
		foreach ( $insert_array as $val => $key )
		{
			$psik = ( $counter == sizeof($insert_array) ) ? ") values( " : ",";
			$sql .= $val.$psik;
			$counter++;
		}
		$counter = 1;
		foreach ( $insert_array as $val => $key )
		{
			$psik = ( $counter == sizeof($insert_array) ) ?")" : ",";
			$sql .= "'".$key."'".$psik;
			$counter++;
		}
		$res = mysql_db_query($db,$sql);
		
		echo "<script>window.close();</script>";
		exit;
	}
	else
	{
		if( $_POST['type'] == 1 )
			$sql = "update users_diary set unk = '".$_POST['unk']."' , public_type = '".$_POST['public_type']."' , sales_agent = '".addslashes($_POST['sales_agent'])."' , headline = '".addslashes($_POST['headline'])."' , content = '".addslashes($_POST['content'])."' , url_link = '".addslashes($_POST['url_link'])."' where id = '".$_POST['update_id']."' limit 1";
		elseif( $_POST['type'] == 10 || $_POST['type'] == 11 )
			$sql = "update users_diary set unk = '".$_POST['unk']."' , public_type = '".$_POST['public_type']."' , sales_agent = '".addslashes($_POST['sales_agent'])."' , headline = '".addslashes($_POST['headline'])."' , content = '".addslashes($_POST['content'])."' , url_link = '".addslashes($_POST['url_link'])."' where id = '".$_POST['update_id']."' limit 1";
		
		$res = mysql_db_query($db,$sql);
		
		echo "<script>window.close();</script>";
		exit;
	}
}
if( $_GET['todo'] == "del" )
{
	$sql = "update users_diary set deleted = '1' where id = '".$_GET['del_id']."' limit 1";
	$res = mysql_db_query($db,$sql);
	
	echo "<script>window.close();</script>";
	exit;
}

	switch($_GET['wd'])
	{
		case "0" :	$day_name = "ראשון";	break;
		case "1" :	$day_name = "שני";	break;
		case "2" :	$day_name = "שלישי";	break;
		case "3" :	$day_name = "רביעי";	break;
		case "4" :	$day_name = "חמישי";	break;
		case "5" :	$day_name = "שישי";	break;
		case "6" :	$day_name = "שבת";	break;
	}
	
	$sql = "select * from users_diary where id = '".$_GET['update_id']."' limit 1";
	$res_update = mysql_db_query($db,$sql);
	$data_update = mysql_fetch_array($res_update);
	
	$code_id_field = ( $_GET['update_id'] ) ? $data_update['user_id'] : $_GET['user_id'] ;
?>

<html>

<head>
	
	<META HTTP-EQUIV='Content-Type' CONTENT='text/html; charset=windows-1255'>
	<title>יומן - הוסף פגישה חדשה</title>
	
	<style>
		
		.style_new_field_diary {
			border-left:1px solid #656565;border-right:1px solid #656565;
			border-top:1px solid #656565;border-bottom:1px solid #656565;
			font-family:Arial;
			font-size:11px;
			text-decoration:none;
			color:#000000;
			width:130px;
		}
		
		.submit_style_add{
			border-left:1px solid #656565;border-right:1px solid #656565;
			border-top:1px solid #656565;border-bottom:1px solid #656565;
			font-family:Arial;
			font-size:11px;
			text-decoration:none;
			color:#000000;
			width:59px;
			background-color: #e6e6e6;
			font-weight : bold;
		}
		
		.maintext	{
			color: #000000;
			font-family: sans-serif;
			font-size: 12px;
			text-decoration: none;
		}
		
	</style>
	
	<script>
		function can_i_del()  {
			aa = confirm("?האם את/ה בטוח/ה");
			if(aa == true)
				return true;
			else
				return false;
		}
	</script>
</head>

<body bgcolor="#e6e6e6">

<table border="0" cellpadding="0" cellspacing="0" align="center" dir="rtl" width="204" >
<form action="?" method="POST">
<input type="hidden" name="todo" value="DB_action">
<input type="hidden" name="type" value="<?=$_GET['type']?>">
<input type="hidden" name="day" value="<?=$_GET['d']?>">
<input type="hidden" name="mon" value="<?=$_GET['m']?>">
<input type="hidden" name="year" value="<?=$_GET['y']?>">
<input type="hidden" name="unk" value="<?=$_GET['unk']?>">
<input type="hidden" name="sesid" value="<?=$_GET['sesid']?>">
<input type="hidden" name="hour" value="<?=$_GET['hour']?>">
<input type="hidden" name="min" value="<?=$_GET['min']?>">
<input type="hidden" name="wday" value="<?=$_GET['wd']?>">
<input type="hidden" name="update_id" value="<?=$_GET['update_id']?>">

	<tr>
		<td>
			<table border="0" cellpadding="0" cellspacing="0" class="maintext">
			<? if( $type == 1 || $type == 10 || $type == 11 )	{ ?>
				<tr>
					<td>כותרת</a></td>
					<td width="10"></td>
					<td><input type="text" name="headline" value="<?=$data_update['headline'] ?>" class="style_new_field_diary"></td>
				</tr>
				<tr><td colspan="3" height="2"></tr>
				<tr>
					<td><nobr>איש מכירות</nobr></td>
					<td width="10"></td>
					<td><input type="text" name="sales_agent" value="<?=$data_update['sales_agent'] ?>" class="style_new_field_diary"></td>
				</tr>
				<tr><td colspan="3" height="2"></tr>
				<tr>
					<td><nobr>הודעה מסוג</nobr></td>
					<td width="10"></td>
					<?
						$selected1 = ( $data_update['public_type'] == "1" ) ? "selected" : "";
						$selected2 = ( $data_update['public_type'] == "2" ) ? "selected" : "";
					?>
						<td>
							<select name="public_type" class="style_new_field_diary">
								<option style="background-color : #007495; color:#ffffff;" value="1" <?=$selected1?>>פומבי</option>
								<option style="background-color : #004080; color:#ffffff;" value="2" <?=$selected2?>>פרטי</option>
							</select>
						</td>
				</tr>
				
				<tr><td colspan="3" height="2"></tr>
				<tr>
					<td><nobr>עד לשעה</nobr></td>
					<td width="10"></td>
					<td>
						<select name='until_hour' class='style_new_field_diary'>
							<?php
								echo "<option value=''>בחר</option>";
								for( $i=9 ; $i<=21 ; $i++ )
								{
										$new_i = 1+$i;
										$seleted = ( $data_update['until_hour'] == $i ) ? "selected" : "";
										$seleted22 = ( $seleted == "" && $i == ($_GET['hour']) ) ? "selected" : $seleted;
										echo "<option value='".$new_i.":00' ".$seleted22 .">".$new_i.":00</option>";
								}
							?>
						</select>	
					</td>
				</tr>
				<tr><td colspan="3" height="2"></tr>
				<tr>
					<td><nobr>קישור מצורף</nobr></td>
					<td width="10"></td>
					<td><input type="text" name="url_link" value="<?=$data_update['url_link'] ?>" class="style_new_field_diary"></td>
				</tr>
				<tr><td colspan="3" height="2"></tr>
				<tr><td colspan="3">פרטים</tr>
				<tr><td colspan="3" height="2"></tr>
				<tr>
					<td colspan="3"><textarea rows='' cols='' name="content" class="style_new_field_diary" style='width:204px; height:50px;'><?=stripslashes($data_update['content']) ?></textarea></td>
				</tr>
				
				<?
				}
				?>
				
				<tr><td colspan="3" height="7"></tr>
				<tr>
					<td colspan="3">
						הפגישה תתקיים בתאריך:
						<b><?=$_GET['d']?>/<?=$_GET['m']?>/<?=$_GET['y']?></b> 
						ביום: <b><?=$day_name?></b>
						בשעה: <b><?=$_GET['hour']?>:<?=$_GET['min']?></b><br>
					</td>
				</tr>
				<tr><td colspan="3" height="5"></tr>
				<tr>
					<td colspan="3">
						<table border="0" cellpadding="0" cellspacing="0" class="maintext" width="100%">
							<tr>
								<td align="right"><input type="submit" value="אישור" class="submit_style_add"></td>
								<td width="10"></td>
								<td align="center">
										<table border="0" cellpadding="0" cellspacing="0">
												<tr>
														<td align="center"><a href="?todo=del&del_id=<?=$data_update['id']."&unk=".$_REQUEST['unk']."&sesid=".$_REQUEST['sesid'];?>" class="submit_style_add" style="height:19;" onclick='return can_i_del()'>מחק</a></td>
												</tr>
										</table>
								</td>
								<td align="left">
										<table border="0" cellpadding="0" cellspacing="0">
												<tr>
														<td align="center"><a href="javascript:window.close()" class="submit_style_add" style="height:19;">ביטול</a></td>
												</tr>
										</table>
								</td>
							</tr>
						</table>
					</td>
				</tr>
			</table>
		</td>
	</tr>
	
</form>
</table>

</body>

</html>