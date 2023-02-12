<?php
ob_start();
session_start();

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
		
		$expiTime = time() + (1 * 24 * 60 * 60);
		
		//$DB_time1 = mktime($hour, $minute+30, $secound, $month, $day,  $year);
		$DB_time2 = date("YmdHis",$expiTime);
		
		//$expi = mktime(date("H"), date("i"), date("s"), date("m"), date("d"),  date("Y"));
		$page_expi = date("YmdHis");
		
		// check the date that is -30 min
		if($DB_time2 > $page_expi)	{
			$sql = "update login_trace set date = '".$page_expi."' where session_idd ='".$_REQUEST['sesid']."'";
			$res = mysql_db_query(DB,$sql);
		}
		else	{
			echo "<script>alert('המערכת התנתקה באופן אוטומטי - יש להתחבר שוב, המערכת מתנתקת לאחר שעה ללא תנועה במערכת ניהול');</script>";
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

	if( $_GET['date'] )
	{
		$temp_new_date = explode("-", $_GET['date']);
		$date_func[wday] = $_GET['day'];
		$date_func[mday] = $temp_new_date[0];
		$date_func[mon] = $temp_new_date[1];
		$date_func[year] = $temp_new_date[2];
	}
	else
	{	
		$date_func = getdate();
		
		$_SESSION['real_date'] = $date_func;
		
	}
	

		
		switch($date_func[wday])
		{
			case "0" :
				$next_w = 7 + $date_func[mday];
				$pre_w = $date_func[mday] - 1;
			break;
			
			case "1" :
				$next_w = 6 + $date_func[mday];
				$pre_w = $date_func[mday] - 2;
			break;
			
			case "2" :
				$next_w = (5 + $date_func[mday]);
				$pre_w = ( $date_func[mday] - 3);
			break;
			
			case "3" :
				$next_w = 4 + $date_func[mday];
				$pre_w = $date_func[mday] - 4;
			break;
			
			case "4" :
				$next_w = 3 + $date_func[mday];
				$pre_w = $date_func[mday] - 5;
			break;
			
			case "5" :
				$next_w = 2 + $date_func[mday];
				$pre_w = $date_func[mday] - 6;
			break;
			
			case "6" :
				$next_w = 1 + $date_func[mday];
				$pre_w = $date_func[mday] - 7;
			break;
		}
						
	
					
		$day_date_next_w = date("d-m-Y", mktime(0, 0, 0, $date_func[mon], $next_w, $date_func[year]));
		$day_date_pre_w = date("d-m-Y", mktime(0, 0, 0, $date_func[mon], $pre_w, $date_func[year]));



function search_for_type_1()
{
	global $db;
	
	echo "<tr>
			<td colspan=\"2\">
				<table border=\"0\" cellspacing=\"0\" cellpadding=\"0\" width=\"100%\" dir=\"rtl\" align=\"center\" class=\"maintext\">";
				echo "<form action='diary.php' method='GET' name='search_form'>";
				echo "<input type='hidden' name='unk' value='".$_GET['unk']."'>";
				echo "<input type='hidden' name='sesid' value='".$_GET['sesid']."'>";
				echo "<input type='hidden' name='type' value='".$_GET['type']."'>";
				echo "<input type='hidden' name='from_search' value='1'>";
				
						echo "<tr><td height='3' colspan='5'></td></tr>";
						echo "<tr><td colspan='5'><Hr width='100%' size='1' color='#000000'></td></tr>";
						echo "<tr><td height='3' colspan='5'></td></tr>";
						
						echo "<tr>";
							echo "<td colspan='5'><b>חיפוש</b></td>";
						echo "</tr>";
						
						echo "<tr><td height='10' colspan='5'></td></tr>";
						
						echo "<tr>";
							echo "<td colspan='5'>";
								echo "<table border=\"0\" cellspacing=\"0\" cellpadding=\"0\" class=\"maintext\">";
									echo "<tr>";
										echo "<td>כותרת</td>";
										echo "<td width='10'></td>";
										echo "<td><input type='text' name='headline' value='".$_GET['headline']."' style='width:75px;'></td>";
										echo "<td width='40'></td>";
										echo "<td>תוכן</td>";
										echo "<td width='10'></td>";
										echo "<td><input type='text' name='content' value='".$_GET['content']."' style='width:100px;'></td>";
										
										echo "<td width='40'></td>";
										echo "<td>איש מכירות</td>";
										echo "<td width='10'></td>";
										echo "<td><input type='text' name='sales_agent' value='".$_GET['sales_agent']."' style='width:100px;'></td>";
										
										echo "<td width='40'></td>";
										echo "<td>מתאריך</td>";
										echo "<td width='10'></td>";
										echo "<td><input type='text' name='s_date_start' value='".$_GET['s_date_start']."' style='width:90px;'></td>";
										
										echo "<td width='40'></td>";
										echo "<td>עד התאריך</td>";
										echo "<td width='10'></td>";
										echo "<td><input type='text' name='s_date_end' value='".$_GET['s_date_end']."' style='width:90px;'></td>";
										
										echo "<td width='40'></td>";
										
										echo "<td><input type='submit' value='חפש'></td>";
									echo "</tr>";
								echo "</table>";
							echo "</td>";
						echo "</tr>";
						
						if( $_GET['from_search'] == 1 )
						{
							$temp_s_date_start = explode("-",$_GET['s_date_start']);
							$temp_s_date_end = explode("-",$_GET['s_date_end']);
							
							if( $_GET['headline'] != "" )
							{
								$s_headline = ( $_GET['headline'] != "" ) ? " headline like '%".$_GET['headline']."%' and" : "";
								$s_date_start = ( $_GET['s_date_start'] != "" ) ? " day >= '".$temp_s_date_start[0]."' and mon >= '".$temp_s_date_start[1]."' and year >= '".$temp_s_date_start[2]."' and" : "";
								$s_date_end = ( $_GET['s_date_end'] != "" ) ? " day <= '".$temp_s_date_end[0]."' and mon <= '".$temp_s_date_end[1]."' and year <= '".$temp_s_date_end[2]."' and" : "";
								$s_content = "";
								$s_sales_agent = "";
								$ok_sql = 1;
							}
							elseif( $_GET['content'] != "" )
							{
								$s_content = ( $_GET['content'] != "" ) ? " content like '%".$_GET['content']."%' and" : "";
								$s_date_start = ( $_GET['s_date_start'] != "" ) ? " day >= '".$temp_s_date_start[0]."' and mon >= '".$temp_s_date_start[1]."' and year >= '".$temp_s_date_start[2]."' and" : "";
								$s_date_end = ( $_GET['s_date_end'] != "" ) ? " day <= '".$temp_s_date_end[0]."' and mon <= '".$temp_s_date_end[1]."' and year <= '".$temp_s_date_end[2]."' and" : "";
								$s_headline = "";
								$s_sales_agent = "";
								$ok_sql = 1;
							}
							elseif( $_GET['sales_agent'] != "" )
							{
								$s_sales_agent = ( $_GET['sales_agent'] != "" ) ? " sales_agent = '".$_GET['sales_agent']."' and" : "";
								$s_date_start = ( $_GET['s_date_start'] != "" ) ? " day >= '".$temp_s_date_start[0]."' and mon >= '".$temp_s_date_start[1]."' and year >= '".$temp_s_date_start[2]."' and" : "";
								$s_date_end = ( $_GET['s_date_end'] != "" ) ? " day <= '".$temp_s_date_end[0]."' and mon <= '".$temp_s_date_end[1]."' and year <= '".$temp_s_date_end[2]."' and" : "";
								$s_headline = "";
								$s_content = "";
								$ok_sql = 1;
							}
							else
							{
								$notno = "לא ניתן לבצע חיפוש - יש למלאות את אחד השדות: כותרת, תוכן, תאריכים";
								$s_name_tele = "";
								$s_name_sales = "";
								$s_code_id = "";
								$s_date_start = "";
								$s_date_end = "";
								$ok_sql = 0;
							}
							$all_searches = $s_headline.$s_content.$s_sales_agent.$s_date_start.$s_date_end;
							$all_searches = substr($all_searches, 0, -3);
							
							if( $ok_sql == 1 )
							{
								$sql = "select id from bamarom_diary where ".$all_searches." and unk = '".$_GET['unk']."' and deleted = '0' and type = '".$_GET['type']."'";
								$res = mysql_db_query($db,$sql);
							
								while( $data = mysql_fetch_array($res) )
								{
									if( $_GET['s_code_id'] )
									{
										echo "<tr><td height='10' colspan='5'></td></tr>";
										
										echo "<tr>";
											echo "<td colspan='5'>";
												echo "<table border=\"0\" cellspacing=\"0\" cellpadding=\"0\" class=\"maintext\">";
													
													$sql_history = "select * from bamarom_diary where user_id = '".$_GET['s_code_id']."' and type = '".$type."' and deleted = '0' order by id desc";
													$res_history = mysql_db_query($db,$sql_history);
													
													$sql_history_name = "select field_12,field_8,status from table_for_all where id = '".$_GET['s_code_id']."'";
													$res_history_name = mysql_db_query($db,$sql_history_name);
													$data_history_name = mysql_fetch_array($res_history_name);
													
													echo "<tr><td height='10' colspan='5'></td></tr>";
													echo "<tr>";
														echo "<td><b>תאריך</b></td>";
														echo "<td width='10'></td>";
														echo "<td><b>יום</b></td>";
														echo "<td width='10'></td>";
														echo "<td><b>שעה</b></td>";
													echo "</tr>";
													
													while( $data_history = mysql_fetch_array($res_history) )
													{
														switch($data_history['wday'])
														{
															case "0" :	$day_name = "ראשון";	break;
															case "1" :	$day_name = "שני";	break;
															case "2" :	$day_name = "שלישי";	break;
															case "3" :	$day_name = "רביעי";	break;
															case "4" :	$day_name = "חמישי";	break;
															case "5" :	$day_name = "שישי";	break;
															case "6" :	$day_name = "שבת";	break;
														}
														
														echo "<tr><td height='5' colspan='5'></td></tr>";
														echo "<tr>";
															echo "<td>".$data_history['day']."-".$data_history['mon']."-".$data_history['year']."</td>";
															echo "<td width='10'></td>";
															echo "<td>".$day_name."</td>";
															echo "<td width='10'></td>";
															echo "<td>".$data_history['hour'].":".$data_history['min']."</td>";
														echo "</tr>";
													}
												echo "</table>";
											echo "</td>";
										echo "</tr>";
									}
									elseif( $_GET['s_name_tele'] || $_GET['s_name_sales'] )
									{
										$sql = "select status from table_for_all where id = '".$data['user_id']."'";
										$res_statuss = mysql_db_query($db,$sql);
										$data_statuss = mysql_fetch_array($res_statuss);
										
										$count_status_sum++;
										switch($data_statuss['status'])
										{
											case "0" :	$count_status_0++;	break;
											case "1" :	$count_status_1++;	break;
											case "2" :	$count_status_2++;	break;
											case "3" :	$count_status_3++;	break;
											case "4" :	$count_status_4++;	break;
											case "5" :	$count_status_5++;	break;
											case "6" :	$count_status_6++;	break;
											case "7" :	$count_status_7++;	break;
											case "8" :	$count_status_8++;	break;
											case "9" :	$count_status_9++;	break;
										}
									}
								}
							}
							else
							{
								echo "<tr><td height='10' colspan='5'></td></tr>";
								echo "<tr>";
									echo "<td colspan='5'>".$notno."</td>";
								echo "</tr>";
							}
							if( $_GET['s_name_tele'] || $_GET['s_name_sales'] )
							{
								echo "<tr><td height='10' colspan='5'></td></tr>";
								echo "<tr>";
									echo "<td colspan='5'>";
										echo "<table border=\"0\" cellspacing=\"0\" cellpadding=\"0\" class=\"maintext\">";
											
												echo "<tr>";
													echo "<td>חדש: ".$count_status_0."</td>";
												echo "</tr>";
												echo "<tr><td height='5'></td></tr>";
												echo "<tr>";
													echo "<td>מנוי מקצועי: ".$count_status_1."</td>";
												echo "</tr>";
												echo "<tr><td height='5'></td></tr>";
												echo "<tr>";
													echo "<td>בהמתנה: ".$count_status_2."</td>";
												echo "</tr>";
												echo "<tr><td height='5'></td></tr>";
												echo "<tr>";
													echo "<td>מנוי לא בתוקף: ".$count_status_3."</td>";
												echo "</tr>";
												echo "<tr><td height='5'></td></tr>";
												echo "<tr>";
													echo "<td>בטיפול: ".$count_status_4."</td>";
												echo "</tr>";
												echo "<tr><td height='5'></td></tr>";
												echo "<tr>";
													echo "<td>מסלול sms: ".$count_status_5."</td>";
												echo "</tr>";
												echo "<tr><td height='5'></td></tr>";
												echo "<tr>";
													echo "<td>מנוי חובבים: ".$count_status_6."</td>";
												echo "</tr>";
												echo "<tr><td height='5'></td></tr>";
												echo "<tr>";
													echo "<td>סוכנות אופק: ".$count_status_7."</td>";
												echo "</tr>";
												echo "<tr><td height='5'></td></tr>";
												echo "<tr>";
													echo "<td>ניצבים: ".$count_status_8."</td>";
												echo "</tr>";
												echo "<tr><td height='5'></td></tr>";
												echo "<tr>";
													echo "<td>ממתין לפגישה: ".$count_status_9."</td>";
												echo "</tr>";
												echo "<tr><td height='20'></td></tr>";
												
												echo "<tr>";
													echo "<td>סך הכל: ".$count_status_sum."</td>";
												echo "</tr>";
										echo "</table>";
									echo "</td>";
								echo "</tr>";
							}
							
							
						}
				echo "</form>";
				echo "</table>
			</td>
		</tr>";
}

?>

<html>
<head>
	<META HTTP-EQUIV='Content-Type' CONTENT='text/html; charset=windows-1255'>
	<title>יומן</title>
	
	<style>
		BODY	{
			BACKGROUND-COLOR: #eeeeee;
		}
		
		.right_headline	{
			color: #343434;
			font-family: sans-serif;
			font-size: 12px;
			text-decoration: none;
			font-weight: bold;
		}
		
		.right_menu	{
			color: #6b6b6b;
			font-family: sans-serif;
			font-size: 12px;
			text-decoration: none;
		}
		
		.right_menu a:link {text-decoration:none;color:#6b6b6b;}
		.right_menu a:active{text-decoration:underline;color:#000000;}
		.right_menu a:visited{text-decoration:none;color:#6b6b6b;}
		.right_menu a:hover{text-decoration:underline;color:#000000;}
		
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
		
		.maintext_small	{
			color: #000000;
			font-family: sans-serif;
			font-size: 10px;
			text-decoration: none;
		}

		.maintext_small a:link {text-decoration:underline;color:#000000;}
		.maintext_small a:active{text-decoration:underline;color:#000000;}
		.maintext_small a:visited{text-decoration:underline;color:#000000;}
		.maintext_small a:hover{text-decoration:underline;color:#000000;}
		
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
			/**background-color: #eaeaea;*/
			background-color: #ffffff;
			width: 300px;
			height: 19px;
		}
		
		.textarea_style	{
			color: #000000;
			font-family: sans-serif;
			font-size: 12px;
			text-decoration: none;
			border-bottom: 1px solid #666666;
			border-top: 1px solid #666666;
			border-right: 1px solid #666666;
			border-left: 1px solid #666666;
			background-color: #ffffff;
			width: 450px;
			height: 250px;
		}
		
		.textarea_style_summary	{
			color: #000000;
			font-family: sans-serif;
			font-size: 12px;
			text-decoration: none;
			border-bottom: 1px solid #666666;
			border-top: 1px solid #666666;
			border-right: 1px solid #666666;
			border-left: 1px solid #666666;
			background-color: #ffffff;
			width: 450px;
			height: 100px;
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
			background-color: #ffffff;
			width: 100px;
			height: 19px;
		}
</style>

	
	<style>
		.submit_style_add{
			border-left:0px solid #656565;border-right:0px solid #656565;
			border-top:0px solid #656565;border-bottom:0px solid #656565;
			font-family:tahoma,Arial;
			font-size:11px;
			text-decoration:none;
			color:#000000;
			width:120px;
			background-color: #e6e6e6;
			font-weight : bold;
			height : 16px;
		
		}
		
		.headline_u_d{
			font-family:tahoma,Arial;
			font-size:12px;
			text-decoration:none;
			color:#000000;
			font-weight : bold;	
		}
		
	</style>
	
	
</head>

<body>

	<table border="0" cellspacing="0" cellpadding="0" dir="rtl" align="center">
		
		<tr>
			<td colspan="10" class="headline_u_d" align="center">
				<u style='color:#740603'>
				<?
				switch($_GET['type'])
				{
					case "1" :		echo "יומן פגישות"; 			break;
					case "10" : 	echo "חדר ישיבות"; 	break;
					case "11" : 	echo "לוח אירועים"; 	break;
				}
				?>
				</u>
			</tD>
		</tr>
		
		<tr><td colspan="2" height="10"></td></tr>
			
		<tr>
			<td align="right">
				<table border="0" cellspacing="0" cellpadding="0" dir="rtl">
					<form action="diary.php" name="next_w_form" method="GET">
					<input type="hidden" name="unk" value="<?=$_GET['unk']?>">
					<input type="hidden" name="sesid" value="<?=$_GET['sesid']?>">
					<input type="hidden" name="day" value="6">
					<input type="hidden" name="date" value="<?=$day_date_pre_w;?>">
					<input type="hidden" name="type" value="<?=$_GET['type']?>">
					<input type="hidden" name="sales_agent" value="<?=$_GET['sales_agent']?>">
					<input type="hidden" name="headline" value="<?=$_GET['headline']?>">
					<input type="hidden" name="content" value="<?=$_GET['content']?>">
					<tr>
						<td><input type="submit" value="שבוע הקודם" class="submit_style"></td>
					</tr>
					</form>
				</table>
			</td>
			<td align="left">
				<table border="0" cellspacing="0" cellpadding="0" dir="rtl">
					<form action="diary.php" name="pre_w_form" method="GET">
					<input type="hidden" name="unk" value="<?=$_GET['unk']?>">
					<input type="hidden" name="sesid" value="<?=$_GET['sesid']?>">
					<input type="hidden" name="day" value="0">
					<input type="hidden" name="date" value="<?=$day_date_next_w;?>">
					<input type="hidden" name="type" value="<?=$_GET['type']?>">
					<input type="hidden" name="sales_agent" value="<?=$_GET['sales_agent']?>">
					<input type="hidden" name="headline" value="<?=$_GET['headline']?>">
					<input type="hidden" name="content" value="<?=$_GET['content']?>">
					<tr>
						<td><input type="submit" value="שבוע הבא" class="submit_style"></td>
					</tr>
					</form>	
				</table>
			</td>
		</tr>
		
		<tr><td colspan="2" height="10"></td></tr>

		<tr>
			<td colspan="2">
			<?
				$today_date = $date_func[mday]."/".$date_func[mon]."/".$date_func[year];
				echo "<table border=\"1\" cellspacing=\"0\" cellpadding=\"1\" class=\"maintext\">";
					echo "<tr dir=ltr>";
						
						echo "<td></td>";
						echo "<td width=\"30\"></td>";
						
						for( $i=0 ; $i<=6 ; $i++ )
						{	
							
							if( $date_func[wday] != $i )
							{
								$wtd = $i - $date_func[wday];
								$new_day = ($wtd + $date_func[mday])*1;
							}
							else
								$new_day = $date_func[mday];
							
							
							$day_date = date("d/m/Y", mktime(0, 0, 0, $date_func[mon], $new_day, $date_func[year]));
							$temp_the_date = explode("/",$day_date);
							
							
							$bold_s = ( $i == $_SESSION['real_date']['wday'] && $temp_the_date[0] == $_SESSION['real_date']['mday'] && $temp_the_date[1] == $_SESSION['real_date']['mon'] ) ? "<b>" : "";
							$bold_e = ( $i == $_SESSION['real_date']['wday'] && $temp_the_date[0] == $_SESSION['real_date']['mday'] && $temp_the_date[1] == $_SESSION['real_date']['mon'] ) ? "</b>" : "";
							
							
							switch($i)
							{
								case "0" :	$day_name = "ראשון";	break;
								case "1" :	$day_name = "שני";	break;
								case "2" :	$day_name = "שלישי";	break;
								case "3" :	$day_name = "רביעי";	break;
								case "4" :	$day_name = "חמישי";	break;
								case "5" :	$day_name = "שישי";	break;
								case "6" :	$day_name = "שבת";	break;
							}
							
							echo "<td align=\"center\">".$bold_s.$day_name.$bold_e." &nbsp; ".$bold_s.$day_date.$bold_e."</td>";
							echo "<td width=\"10\"></td>";
						}
						
					echo "</tr>";
					echo "<tr><td colspan=\"4\" height=\"10\"></td></tr>";
			
					for( $j=9 ; $j<=22 ; $j++ )
					{
						$count_min = 0;
						
						$min_temp = 0;
						$temp_t = 0;
						
						
						for( $t=0 ; $t<=$temp_t ; $t++ )
						{
							
							$min = $count_min*$min_temp;
							
							$min = ( $min == 0 ) ? "00" : $min;
							echo "<tr>";
								echo "<td>{$j}:{$min}</td>";
								echo "<td width=\"20\"></td>";
								
								for( $i=0 ; $i<=6 ; $i++ )
								{
										if( $date_func[wday] != $i )
										{
											$wtd = $i - $date_func[wday];
											$new_day = ($wtd + $date_func[mday])*1;
										}
										else
											$new_day = $date_func[mday];
										
									$day_date2 = date("d/m/Y", mktime(0, 0, 0, $date_func[mon], $new_day, $date_func[year]));
									$temp_the_date2 = explode("/",$day_date2);
									
									$SEARCH_sales_agent = ( $_GET['sales_agent'] != "" ) ? " sales_agent like '%".$_GET['sales_agent']."%' and" : "";
									$SEARCH_headline = ( $_GET['headline'] != "" ) ? " headline like '%".$_GET['headline']."%' and" : "";
									$SEARCH_content = ( $_GET['content'] != "" ) ? " content like '%".$_GET['content']."%' and" : "";
									
									
									//if( $_GET['type'] == 1 )
									//	$sql = "select id,sales_agent,headline,public_type from users_diary where ".$SEARCH_sales_agent.$SEARCH_headline.$SEARCH_content." unk = '".$_GET['unk']."' and wday = '".$i."' and min = '".$min."' and hour = '".$j."' and day = '".$temp_the_date2[0]."' and mon = '".$temp_the_date2[1]."' and year = '".$temp_the_date2[2]."' and type = '".$type."' and deleted = '0' limit 1";
									//elseif( $_GET['type'] == 10 || $_GET['type'] == 11 ) 
										$sql = "select id,until_hour,sales_agent,headline,public_type from users_diary where ".$SEARCH_sales_agent.$SEARCH_headline.$SEARCH_content."  unk = '".$_GET['unk']."' and wday = '".$i."' and hour <= '".$j."' and day = '".$temp_the_date2[0]."' and mon = '".$temp_the_date2[1]."' and year = '".$temp_the_date2[2]."' and until_hour > '".$j."' and type = '".$type."' and deleted = '0' limit 1";
									
									$res22 = mysql_db_query($db,$sql);
									$data2 = mysql_fetch_array($res22);
									
									
									if( $_GET['type'] == 1 )
									{
										if( !$data2['id'] )
										{
											echo "<td align=\"center\">";
												echo "<table border=\"0\" cellspacing=\"0\" cellpadding=\"0\" class=\"maintext\">";
												echo "<form action=\"new_field_diary.php\" target=\"_blank\" method=\"GET\">";
													echo "<tr>";
														echo "<td><input type=\"button\" value=\"\" class=\"submit_style_add\" onClick=\"window.open('new_field_diary.php?d=".$temp_the_date2[0]."&m=".$temp_the_date2[1]."&y=".$temp_the_date2[2]."&unk=".$_GET['unk']."&sesid=".$_GET['sesid']."&type=".$type."&hour=".$j."&min=".$min."&wd=".$i."','mywindow','width=220,height=250')\"></td>";
													echo "</tr>";
												echo "</form>";
												echo "</table>"; 
											echo "</td>";
											echo "<td width=\"10\"></td>";
										}
										else{
											switch( $data2['public_type'] )
											{
												case "0" :	$style = "background-color : #b6cefc; color: #ffffff;";	break;
												case "1" :	$style = "background-color : #007495; color:#ffffff;";	break;
												case "2" :	$style = "background-color : #004080; color:#ffffff;";	break;
											}
											
											echo "<td align=\"center\">";
												echo "<table border=\"0\" cellspacing=\"0\" cellpadding=\"0\" class=\"maintext\">";
												echo "<form action=\"new_field_diary.php\" target=\"_blank\" method=\"GET\">";
													echo "<tr>";
														echo "<td><input type=\"button\" style=\"font-size:10px; font-family:arial; ".$style."\" value=\"".$data2['headline']."\" class=\"submit_style_add\"  onClick=\"window.open('new_field_diary.php?d=".$temp_the_date2[0]."&m=".$temp_the_date2[1]."&y=".$temp_the_date2[2]."&unk=".$_GET['unk']."&sesid=".$_GET['sesid']."&type=".$type."&hour=".$j."&min=".$min."&wd=".$i."&update_id=".$data2['id']."','mywindow','width=220,height=250')\"></td>";
													echo "</tr>";
												echo "</form>";
												echo "</table>"; 
											echo "</td>";
											echo "<td width=\"10\"></td>";
										}
									}
									elseif( $_GET['type'] == 10 || $_GET['type'] == 11 )
									{
										
										if( !$data2['id'] )
										{
											echo "<td align=\"center\">";
												echo "<table border=\"0\" cellspacing=\"0\" cellpadding=\"0\" class=\"maintext\">";
												echo "<form action=\"new_field_diary.php\" target=\"_blank\" method=\"GET\">";
													echo "<tr>";
														echo "<td><input type=\"button\" value=\"\" class=\"submit_style_add\"  onClick=\"window.open('new_field_diary.php?d=".$temp_the_date2[0]."&m=".$temp_the_date2[1]."&y=".$temp_the_date2[2]."&unk=".$_GET['unk']."&sesid=".$_GET['sesid']."&type=".$type."&hour=".$j."&min=".$min."&wd=".$i."','mywindow','width=220,height=250')\"></td>";
													echo "</tr>";
												echo "</form>";
												echo "</table>"; 
											echo "</td>";
											echo "<td width=\"10\"></td>";
										}
										else{
											
											switch( $data2['public_type'] )
											{
												case "0" :	$style = "background-color : #b6cefc; color: #ffffff;";	break;
												case "1" :	$style = "background-color : #007495; color:#ffffff;";	break;
												case "2" :	$style = "background-color : #004080; color:#ffffff;";	break;
												
												default :
													$style = "background-color : #d0a0fc; color: #000000;";
											}
											
											
											echo "<td align=\"center\">";
												echo "<table border=\"0\" cellspacing=\"0\" cellpadding=\"0\" class=\"maintext\">";
												echo "<form action=\"new_field_diary.php\" target=\"_blank\" method=\"GET\">";
													echo "<tr>";
														echo "<td><input type=\"button\" style=\"font-size:10px; font-family:arial; ".$style."\" value=\"".stripslashes($data2['headline'])."\" class=\"submit_style_add\"  onClick=\"window.open('new_field_diary.php?d=".$temp_the_date2[0]."&m=".$temp_the_date2[1]."&y=".$temp_the_date2[2]."&unk=".$_GET['unk']."&sesid=".$_GET['sesid']."&type=".$type."&hour=".$j."&min=".$min."&wd=".$i."&update_id=".$data2['id']."','mywindow','width=220,height=250')\"></td>";
													echo "</tr>";
												echo "</form>";
												echo "</table>"; 
											echo "</td>";
											echo "<td width=\"10\"></td>";
										}
									}
								}
								
							echo "</tr>";
							
							echo "<tr><td colspan=\"4\" height=\"10\"></td></tr>";
							
							$count_min++;
						}
					}
					
				echo "</table>";
			?>
			</td>
		</tr>
		
		<?
		/*if( $type == 1  )
		{
		//	if( $_GET['user_id'] != "" )
			//{
				echo "<tr>
					<td colspan=\"2\">
						<table border=\"0\" cellspacing=\"0\" cellpadding=\"0\" dir=\"rtl\" align=\"center\" class=\"maintext\">";
							
								$sql_history = "select * from users_diary where unk = '".$_GET['unk']."' and type = '".$type."' and deleted = '0' order by id desc";
								$res_history = mysql_db_query($db,$sql_history);
								
								echo "<tr><td height='10' colspan='5'></td></tr>";
								echo "<tr>";
									echo "<td colspan='5'>היסטורית הפגישות</td>";
								echo "</tr>";
								echo "<tr><td height='10' colspan='5'></td></tr>";
								echo "<tr>";
									echo "<td><b>תאריך</b></td>";
									echo "<td width='10'></td>";
									echo "<td><b>יום</b></td>";
									echo "<td width='10'></td>";
									echo "<td><b>שעה</b></td>";
								echo "</tr>";
								
								while( $data_history = mysql_fetch_array($res_history) )
								{
									switch($data_history['wday'])
									{
										case "0" :	$day_name = "ראשון";	break;
										case "1" :	$day_name = "שני";	break;
										case "2" :	$day_name = "שלישי";	break;
										case "3" :	$day_name = "רביעי";	break;
										case "4" :	$day_name = "חמישי";	break;
										case "5" :	$day_name = "שישי";	break;
										case "6" :	$day_name = "שבת";	break;
									}
									
									echo "<tr><td height='5' colspan='5'></td></tr>";
									echo "<tr>";
										echo "<td>".$data_history['day']."-".$data_history['mon']."-".$data_history['year']."</td>";
										echo "<td width='10'></td>";
										echo "<td>".$day_name."</td>";
										echo "<td width='10'></td>";
										$mints = ( strlen($data_history['min']) == 1 ) ? $data_history['min']."0" : $data_history['min'];
										echo "<td>".$data_history['hour'].":".$mints."</td>";
									echo "</tr>";
								}
							
						echo "</table>
					</td>
				</tr>";
		//	}
		}*/
		
		
		//if( $type == 1 )
			//echo search_for_type_1();
		?>
	</table>

</body>
</html>
