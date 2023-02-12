<?php
$starttime = microtime();
$startarray = explode(" ", $starttime);
$starttime = $startarray[1] + $startarray[0];

$sesid = ( $_GET['sesid'] != "" ) ? $_GET['sesid'] : $_POST['sesid'];
define('SESID',$sesid);

if( SESID == "" )	exit;

session_start();
header('Content-Type: text/html; charset=windows-1255');  

require('../global_func/vars.php');
require("../global_func/global_functions.php");
require("ajax_functions.php");

// cheake when the session start and end 

	$sql = "select user,date,ip from login_trace where session_idd = '".SESID."'";
	$res = mysql_db_query(DB,$sql);
	$data_login_trace = mysql_fetch_array($res);
	
	define('WORKERID',$data_login_trace['user']);
	
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
		echo "<script>alert('התראת אבטחה מספר 4517 יש ליצור קשר עם ההנהלה, או לנסות להתחבר שנית\n ".$data_login_trace['ip']." \n ".$_SERVER['REMOTE_ADDR']."');</script>";
		echo "<script>window.location.href='login.php'</script>";
		exit;
	}

$main = ($_GET['main'] != "" ) ? $_GET['main'] : $_POST['main'];
	switch($main)
	{
		case "net_banners" :
		
			switch($_GET['todo'])
			{
				case "select_banner" :
					select_banner($_GET['storge_type']);
				break;
				
				case "select_site" :
					select_banner($_GET['storge_type'], $_GET['bannaer_id']);
					
					select_site($_GET['storge_type'], $_GET['bannaer_id']);
					
				break;
			}
			
		break;
		
		case "net_del_belong_banner" :
			$sql = "DELETE FROM net_client_belong_banners WHERE ";
				$sql .= "banner_id = '" . $_GET['banner_id'] . "' AND unk = '".$_GET['user_unk']."';"; 
			$res = mysql_db_query(DB, $sql);
			
			echo "<b>מחוק</b>";
					
		break;
		
		case "createMysaveForm" :
			$sql2 = "select cat_name, id, father from biz_categories where father = '".$_GET['cat']."' and status = '1' order by place,cat_name";
			$res_tatcat = mysql_db_query(DB, $sql2);
			echo "<br />";
			echo "<br />";
			echo "<form action='javascript:createMysaveFinel()' name='createMysaveForm_form' method='GET' style='padding:0; margin:0;'>";
			echo "<input type='hidden' name='sesid' value='".$_GET['sesid']."'>";
			echo "<input type='hidden' name='cat' value='".$_GET['cat']."'>";
			echo "<input type='hidden' name='city' value='".$_GET['city']."'>";
			echo "<input type='hidden' name='color' value='".$_GET['color']."'>";
			
			echo "<p class='maintext'>בחר שירות, לא חובה: </p>";
			echo "<select name='tatcat' class='input_style'>";
				echo "<option value=''>בחירה</option>";
				while( $data = mysql_fetch_array($res_tatcat) )
				{
					echo "<option value='".$data['id']."'>".stripslashes($data['cat_name'])."</option>";
				}
			echo "</select>";
			echo "<br /><br />";
			echo "<input type='submit' value='סיים' class='input_style'>";
			echo "</form>";
		break;
		
		case "createMysaveFinel" :
			
			echo createMysaveFinel();
			
		break;
		
		
		
		case "lead__update_user_tashlom" :
			$GlobalFunctions = new GlobalFunctions();
			
			if( $_GET['new_paid'] == "0" )
			{
				$sql = "UPDATE user_lead_tashlom SET payDate = '' , paid = '".$_GET['new_paid']."' WHERE id = '".$_GET['tashlom_id']."' AND unk = '".$_GET['unk']."' ";
				$res = mysql_db_query(DB, $sql);
			}
			elseif( $_GET['new_paid'] == "1" )
			{
				$sql = "UPDATE user_lead_tashlom SET payDate = NOW() , paid = '".$_GET['new_paid']."' WHERE id = '".$_GET['tashlom_id']."' AND unk = '".$_GET['unk']."' ";
				$res = mysql_db_query(DB, $sql);
			}
			$sql = "SELECT payDate FROM user_lead_tashlom WHERE id = '".$_GET['tashlom_id']."' AND unk = '".$_GET['unk']."'";
			$res = mysql_db_query(DB, $sql);
			$data = mysql_fetch_array($res);
			
			echo $GlobalFunctions->show_dateTime_field($data['payDate']);
		break;
		
		case "lead__new_user_tashlom" :
			if( $_GET['paid'] == "0" )
			{
				$sql = "INSERT INTO user_lead_tashlom SET insertDate = now() , total = '".$_GET['price']."', unk = '".$_GET['unk']."' ";
				$res = mysql_db_query(DB, $sql);
			}
			elseif( $_GET['paid'] == "1" )
			{
				$sql = "INSERT INTO user_lead_tashlom SET insertDate = now() , payDate = now() , paid = '".$_GET['paid']."' , total = '".$_GET['price']."', unk = '".$_GET['unk']."' ";
				$res = mysql_db_query(DB, $sql);
			}
			
			echo "<b>בוצע</b>";
		break;
		
		case "close" :
			echo "";
			if( !empty($_SESSION['tasks']['last_user_task_id_open']) )
			{
				$_SESSION['tasks']['last_user_task_id_open'] = "";
			}
		break;
		
		case "task_home" :
			echo "<table border=\"0\" cellspacing=\"0\" cellpadding=\"0\" class=\"maintext\" width=500>";
			
				echo "<tr>";
					echo "<td><a href='javascript:void(0)' onclick='addNew_tesk_mission(\"".SESID."\")' class='maintext'>הוספת משימה חדשה</a></td>";
				echo "</tr>";
				
				echo "<tr>";
					echo "<td><div id='task_homepage__new_task'></div></td>";
				echo "</tr>";
				
				/*
				echo "<tr>";
					echo "<td>";
						echo "<form action='' method='post' name='searchMission'>";
						echo "<table border=\"0\" cellspacing=\"0\" cellpadding=\"0\" class=\"maintext\">";
							
							echo "<tr>";
								echo "<td><h4>אפשרויות סינון:</h4></td>";
							echo "</tr>";
							
							echo "<tr>";
							
								echo "<td></td>";
								echo "<td></td>";
								echo "<td></td>";
								
							echo "</tr>";
						echo "</table>";
						echo "</form>";
					echo "</td>";
				echo "</tr>";
				*/
				echo "<tr><td height=10></td></tr>";
				$task_id = ( $_SESSION['tasks']['last_user_work_status'] == "" ) ? "0" : $_SESSION['tasks']['last_user_work_status'];
				echo "<tr>";
					echo "<td>";
						echo "<div id='showTaskesList'><script>showTaskesList(\"".SESID."\" , \"".$task_id."\" )</script></div>";
					echo "</td>";
				echo "</tr>";
				
			echo "</table>";
		break;
		
		case "addNewTask" :
			echo tasks___addNewTask();
		break;
		
		case "addNewTaskDB" :
			if( empty($_POST['recored_id']) ) 
				echo tasks___addNewTaskDB();
			else
				echo tasks___editTaskDB();
		break;
		
		case "showTaskesList" :
			$work_status_temp = ( $_GET['work_status'] != "" ) ? $_GET['work_status'] : $_POST['work_status'];
			$work_status = ( $work_status_temp != "" ) ? $work_status_temp : "0";
			
			$_SESSION['tasks']['last_user_work_status'] = $work_status;
			
			
			$sql = "SELECT wt.* FROM workers_task as wt , workers_task_owners_choosen  as wtw WHERE
				 wtw.task_id=wt.id AND 
				 ( wtw.owner_id='".WORKERID."' OR sender_owner = '".WORKERID."' ) AND
				 wt.deleted=0 AND
				 work_status='".$work_status."'
				 GROUP BY wt.id
				 ORDER BY deadline_date 
				";
			$res = mysql_db_query(DB, $sql);
			
			$status0_s = ( $work_status == "0" ) ? "<b>" : "<a href='javascript:void(0)' onclick='showTaskesList(\"".SESID."\" , \"0\")' class='maintext'>";
			$status0_e = ( $work_status == "0" ) ? "</b>" : "</a>";
			
			$status1_s = ( $work_status == "1" ) ? "<b>" : "<a href='javascript:void(0)' onclick='showTaskesList(\"".SESID."\" , \"1\")' class='maintext'>";
			$status1_e = ( $work_status == "1" ) ? "</b>" : "</a>";
			
			$status2_s = ( $work_status == "2" ) ? "<b>" : "<a href='javascript:void(0)' onclick='showTaskesList(\"".SESID."\" , \"2\")' class='maintext'>";
			$status2_e = ( $work_status == "2" ) ? "</b>" : "</a>";
			
			$status3_s = ( $work_status == "3" ) ? "<b>" : "<a href='javascript:void(0)' onclick='showTaskesList(\"".SESID."\" , \"3\")' class='maintext'>";
			$status3_e = ( $work_status == "3" ) ? "</b>" : "</a>";
			
			$status4_s = ( $work_status == "4" ) ? "<b>" : "<a href='javascript:void(0)' onclick='showTaskesList(\"".SESID."\" , \"4\")' class='maintext'>";
			$status4_e = ( $work_status == "4" ) ? "</b>" : "</a>";
			
			$status5_s = ( $work_status == "5" ) ? "<b>" : "<a href='javascript:void(0)' onclick='showTaskesList(\"".SESID."\" , \"5\")' class='maintext'>";
			$status5_e = ( $work_status == "5" ) ? "</b>" : "</a>";
			
			$status6_s = ( $work_status == "6" ) ? "<b>" : "<a href='javascript:void(0)' onclick='showTaskesList(\"".SESID."\" , \"6\")' class='maintext'>";
			$status6_e = ( $work_status == "6" ) ? "</b>" : "</a>";
			
			$status7_s = ( $work_status == "7" ) ? "<b>" : "<a href='javascript:void(0)' onclick='showTaskesList(\"".SESID."\" , \"7\")' class='maintext'>";
			$status7_e = ( $work_status == "7" ) ? "</b>" : "</a>";
			
			
			$div_row_work_status_0 = "<div id='taskWorkStatusNewMsg_0' style='display: inline'>0<script>taskWorkStatusNewMsg(\"0\" , \"".SESID."\")</script></div>";
			$div_row_work_status_1 = "<div id='taskWorkStatusNewMsg_1' style='display: inline'>0<script>taskWorkStatusNewMsg(\"1\" , \"".SESID."\")</script></div>";
			$div_row_work_status_2 = "<div id='taskWorkStatusNewMsg_2' style='display: inline'>0<script>taskWorkStatusNewMsg(\"2\" , \"".SESID."\")</script></div>";
			$div_row_work_status_3 = "<div id='taskWorkStatusNewMsg_3' style='display: inline'>0<script>taskWorkStatusNewMsg(\"3\" , \"".SESID."\")</script></div>";
			$div_row_work_status_4 = "<div id='taskWorkStatusNewMsg_4' style='display: inline'>0<script>taskWorkStatusNewMsg(\"4\" , \"".SESID."\")</script></div>";
			$div_row_work_status_5 = "<div id='taskWorkStatusNewMsg_5' style='display: inline'>0<script>taskWorkStatusNewMsg(\"5\" , \"".SESID."\")</script></div>";
			$div_row_work_status_6 = "<div id='taskWorkStatusNewMsg_6' style='display: inline'>0<script>taskWorkStatusNewMsg(\"6\" , \"".SESID."\")</script></div>";
			$div_row_work_status_7 = "<div id='taskWorkStatusNewMsg_7' style='display: inline'>0<script>taskWorkStatusNewMsg(\"7\" , \"".SESID."\")</script></div>";
			
			
			
			echo "<table border=\"0\" cellspacing=\"0\" cellpadding=\"0\" class=\"maintext\" width=800>";
				echo "<tr>";
					echo "<td colspan=11>";
						echo "<table border=\"0\" cellspacing=\"0\" cellpadding=\"0\" class=\"maintext\">";
							echo "<tr>";
								echo "<td>".$status0_s."משימות חדשות (".$div_row_work_status_0.")".$status0_e."</td>";
								echo "<td width=10></td>";
								echo "<td>".$status1_s."משימות בטיפול (".$div_row_work_status_1.")".$status1_e."</td>";
								echo "<td width=10></td>";
								echo "<td>".$status2_s."משימות מוכנות (".$div_row_work_status_2.")".$status2_e."</td>";
								echo "<td width=10></td>";
								echo "<td>".$status3_s."משימות לאחר אישור (".$div_row_work_status_3.")".$status3_e."</td>";
								echo "<td width=10></td>";
								
								echo "<td>".$status5_s."חובות לגבייה (".$div_row_work_status_5.")".$status5_e."</td>";
								echo "<td width=10></td>";
								echo "<td>".$status6_s."תשלומים לחיוב (".$div_row_work_status_6.")".$status6_e."</td>";
								echo "<td width=10></td>";
								echo "<td>".$status4_s."תשלומים סגור (".$div_row_work_status_4.")".$status4_e."</td>";
								
								echo "<td width=10></td>";
								echo "<td>".$status7_s."הזמנת עבודה (".$div_row_work_status_7.")".$status7_e."</td>";
								
								
								
								
							echo "</tr>";
						echo "</table>";
					echo "</td>";
				echo "</tr>";
				echo "<tr><td colspan=11 height=10></td></tr>";
				echo "<tr>";
					echo "<td width=10></td>";
					echo "<td width=10></td>";
					echo "<td width=80><b>תאריך הוספה</b></td>";
					echo "<td width=180><b>כותרת</b></td>";
					echo "<td width=80><b>נוסף על ידי</b></td>";
					echo "<td width=100><b>אחראי משימה</b></td>";
					echo "<td width=90><b>תאריך יעד</b></td>";
					echo "<td width=100><b>עדכון סטטוס</b></td>";
					echo "<td width=5></td>";
					echo "<td width=15></td>";
					echo "<td width=5></td>";
					echo "<td width=15></td>";
				echo "</tr>";
				
				while( $data = mysql_fetch_array($res) )
				{
					$ex_date2 = explode(" " , $data['insert_date'] );
					$ex_date = explode("-" , $ex_date2[0] );
					$date_insert = $ex_date[2]."/".$ex_date[1]."/".$ex_date[0];
					
					$ex_date1 = explode(" " , $data['deadline_date'] );
					$ex_date12 = explode("-" , $ex_date1[0] );
					$deadline_date = $ex_date12[2]."/".$ex_date12[1]."/".$ex_date12[0];
					
					$sql = "SELECT client_name FROM sites_owner WHERE id = '".$data['sender_owner']."' AND ilbiz_worker=1 ";
					$resWorker = mysql_db_query(DB, $sql);
					$dataWorker = mysql_fetch_array($resWorker);
					
					$sqlReciver = "SELECT client_name FROM sites_owner WHERE id = '".$data['reciver_owner']."' AND ilbiz_worker=1 ";
					$resReciver = mysql_db_query(DB, $sqlReciver);
					$dataReciver = mysql_fetch_array($resReciver);
					
					$selected0 = ( $data['work_status'] == "0" ) ? "selected" : "";
					$selected1 = ( $data['work_status'] == "1" ) ? "selected" : "";
					$selected2 = ( $data['work_status'] == "2" ) ? "selected" : "";
					$selected3 = ( $data['work_status'] == "3" ) ? "selected" : "";
					$selected4 = ( $data['work_status'] == "4" ) ? "selected" : "";
					$selected5 = ( $data['work_status'] == "5" ) ? "selected" : "";
					$selected6 = ( $data['work_status'] == "6" ) ? "selected" : "";
					$selected7 = ( $data['work_status'] == "7" ) ? "selected" : "";
					
					$more_to_selected3 = ( $data['sender_owner'] != WORKERID && $selected3 != "" ) ? "readonly" : "";
					
					
					if( $_SESSION['tasks']['last_user_task_id_open'] == $data['id'] )
					{
						echo "<script>task_moreDate(\"title_".$data['id']."\" , \"TaskMoreData_".$data['id']."\" , \"".SESID."\" , \"".$data['id']."\")</script>";
					}
					$task_clicker = "onclick='task_moreDate(\"title_".$data['id']."\" , \"TaskMoreData_".$data['id']."\" , \"".SESID."\" , \"".$data['id']."\")' style='cursor: pointer;'";
					
					$sql = "SELECT view , owner_id FROM workers_task_owners_choosen WHERE task_id = '".$data['id']."' AND owner_id = '".WORKERID."'";
					$res_icon = mysql_db_query(DB,$sql);
					$data_icon = mysql_fetch_array($res_icon);
					
					if( $data_icon['view'] == 0 && $data_icon['owner_id'] == WORKERID ){
						$view_icon = "<img src='images/small_msg_icon.png' border=0><br/>";
					}
					else{
						$signSql = "SELECT * FROM workers_task_discassion WHERE task_id = '".$data['id']."' ORDER BY id desc LIMIT 1 ";

						$signRes = mysql_db_query(DB,$signSql);
						$signData = mysql_fetch_array($signRes);
						$signNew = false;
						if($signData['id'] != ""){
							$sign2Sql = "SELECT * FROM workers_task_discassion_owners_choosen WHERE discasstion_id = '".$signData['id']."'";
							$sign2Res = mysql_db_query(DB,$sign2Sql);
							$sign2Data = mysql_fetch_array($sign2Res);
							if($signData['owner_id'] != WORKERID ){
								
								$signNew = true;
								if($sign2Data['view'] == '0'){
									$view_icon = "<img style='width:30px;' src='images/small_msg_icon.png' border=0>"; 
								}
								else{
									$view_icon = "<img style='width:30px;' src='images/small_msg_icon_3.png' border=0>";
								}
							}
							else{
								$view_icon = "<img style='width:25px;' src='images/small_msg_icon_2.png' border=0>";
							}
						}
						else{
							$ownerSql = "SELECT sender_owner FROM workers_task WHERE id = '".$data['id']."'";
							$ownerRes = mysql_db_query(DB,$ownerSql);
							$ownerData = mysql_fetch_array($ownerRes);
							if($ownerData['sender_owner'] == WORKERID){
								$view_icon = "<img style='width:25px;' src='images/small_msg_icon_2.png' border=0>";
							}
							else{							
							$view_icon = "<img style='width:20px;' src='images/small_msg_icon_3.png' border=0>";
							}
						}
					}
					
					$today = date('d-m-Y');
					$deadline_datett = $ex_date12[2]."-".$ex_date12[1]."-".$ex_date12[0];
					
					if( dateDiff($today,$deadline_datett) < 0 )
						$style = "style='color: red; font-weight: bold;'";
					elseif( dateDiff($today,$deadline_datett) <= 3 )
						$style = "style='color: orange; font-weight: bold;'";
					else
						$style = "";
					
					echo "<tr>";
						echo "<td colspan=11 class='tesk_subject_tr_close' id='title_".$data['id']."'>";
							echo "<table border=\"0\" cellspacing=\"0\" cellpadding=\"0\" class=\"maintext\" width=700>";
								echo "<tr height=25>";
									echo "<td width=10 ".$task_clicker."><div id='msg_viewed_icon_".$data['id']."'>".$view_icon."</div></td>";
									echo "<td width=10></td>";
									echo "<td width=80 ".$task_clicker.">".$date_insert. "</td>";
									echo "<td width=300 ".$task_clicker.">".stripslashes($data['subject'])."</td>";
									echo "<td width=100 ".$task_clicker.">".stripslashes($dataWorker['client_name'])."</td>";
									echo "<td width=100 ".$task_clicker.">".stripslashes($dataReciver['client_name'])."</td>";
									echo "<td width=90 ".$task_clicker." ".$style.">".$deadline_date."</td>";
									echo "<td width=100>";
									echo "<form action='javascript:updateTaskStatus(\"".SESID."\" , \"".$data['id']."\")' name='updateTaskStatusForm_".$data['id']."' id='updateTaskStatusForm_".$data['id']."' method='post' style='padding:0; margin:0;'>";
									echo "<input type='hidden' name='sesid' value='".SESID."'>";
									echo "<input type='hidden' name='task_id' value='".$data['id']."'>";
									echo "<input type='hidden' name='work_status' value='".$work_status."'>";
									echo "<input type='hidden' name='main' value='updateTaskStatus'>";
										echo "<select name='new_work_status' class='input_style' style='width:100px;' onchange='updateTaskStatusForm_".$data['id'].".submit()' ".$more_to_selected3.">";
											echo "<option value='0' ".$selected0.">חדש</option>";
											echo "<option value='1' ".$selected1.">בטיפול</option>";
											echo "<option value='2' ".$selected2.">משימה מוכנה</option>";
											if( $data['sender_owner'] == WORKERID OR $selected3 != '' )
												echo "<option value='3' ".$selected3.">לאחר אישור</option>";
											echo "<option value='5' ".$selected5.">חובות לגבייה</option>";
											echo "<option value='6' ".$selected6.">תשלומים לחיוב</option>";
											echo "<option value='4' ".$selected4.">תשלומים סגור</option>";
											echo "<option value='7' ".$selected7.">הזמנת עבודה</option>";
										echo "</select>";
									echo "</form>";
									echo "</td>";
									echo "<td width=5></td>";
									echo "<td width=15>";
										if( $data['sender_owner'] == WORKERID )
											echo "<a href='javascript:void(0)' onclick='task_edit_data(\"title_".$data['id']."\" , \"TaskMoreData_".$data['id']."\" , \"".SESID."\" , \"".$data['id']."\")'><img src='images/small_edit_icon.png' width=15 alt='עריכה' border=0>";
										else
											echo "<img src='images/small_empty_icon.png' border=0>";
									echo "</td>";
									echo "<td width=5></td>";
									echo "<td width=15>";
										if( $data['sender_owner'] == WORKERID )
											echo "<a href='javascript:delete_task(\"".SESID."\" , \"".$data['id']."\" )' onclick='return can_i_del()'><img src='images/small_delete_icon.png' width=15 alt='מחיקה' border=0></a>";
										else
											echo "<img src='images/small_empty_icon.png' border=0>";
									echo "</td>";
								echo "</tr>";
							echo "</table>";
						echo "</td>";
					echo "</tr>";
					
					echo "<tr>";
						echo "<td colspan=11 class='tesk_content_tr'><div id='TaskEditData_".$data['id']."'></div><div id='TaskMoreData_".$data['id']."'></div></td>";
					echo "</tr>";
					echo "<tr><td colspan=11 height=1></td></tr>";
				}
				
			echo "</table>";
			echo "<div id='updateTaskStatus'></div>";
			echo "<div id='DeleteTask'></div>";

			
		break;
		
		case "taskWorkStatusNewMsg" :
			$sql_w_s = "SELECT COUNT(wtw.view) as counter FROM workers_task as wt , workers_task_owners_choosen  as wtw WHERE
				 wtw.task_id=wt.id AND 
				 ( wtw.owner_id='".WORKERID."' OR sender_owner = '".WORKERID."' ) AND wt.deleted=0 AND
				 work_status='".$_GET['work_status']."' AND ( wtw.view=0 AND wtw.owner_id='".WORKERID."')
				 
				";
			$res_w_s = mysql_db_query(DB, $sql_w_s);
			$data_w_s = mysql_fetch_array($res_w_s);
			
			echo $data_w_s['counter'];
		break;
		
		case "taskViewedMsgIcon" :
			$sql = "SELECT view , owner_id FROM workers_task_owners_choosen WHERE task_id = '".$_GET['task_id']."' AND owner_id = '".WORKERID."'";
			$res = mysql_db_query(DB,$sql);
			$data = mysql_fetch_array($res);
			
			if( $data_icon['view'] == 0 && $data_icon['owner_id'] == WORKERID ){
				echo "<img src='images/small_msg_icon.png' border=0><br/>";
			} 
			else{
				$signSql = "SELECT * FROM workers_task_discassion WHERE task_id = '".$_GET['task_id']."' ORDER BY id desc LIMIT 1 ";

				$signRes = mysql_db_query(DB,$signSql);
				$signData = mysql_fetch_array($signRes);
				$signNew = false;
				if($signData['id'] != ""){
					$sign2Sql = "SELECT * FROM workers_task_discassion_owners_choosen WHERE discasstion_id = '".$signData['id']."'";
					$sign2Res = mysql_db_query(DB,$sign2Sql);
					$sign2Data = mysql_fetch_array($sign2Res);
					if($signData['owner_id'] != WORKERID ){
						
						$signNew = true;
						if($sign2Data['view'] == '0'){
							echo "<img style='width:30px;' src='images/small_msg_icon.png' border=0>"; 
						}
						else{
							echo "<img style='width:30px;' src='images/small_msg_icon_3.png' border=0>";
						}
					}
					else{
						echo "<img style='width:25px;' src='images/small_msg_icon_2.png' border=0>";
					}
				}
				else{
					$ownerSql = "SELECT sender_owner FROM workers_task WHERE id = '".$_GET['task_id']."'";
					$ownerRes = mysql_db_query(DB,$ownerSql);
					$ownerData = mysql_fetch_array($ownerRes);
					if($ownerData['sender_owner'] == WORKERID){
						echo "<img style='width:25px;' src='images/small_msg_icon_2.png' border=0>";
					}
					else{
						echo "<img style='width:20px;' src='images/small_msg_icon_3.png' border=0>"; 
					}
				}
			}
		break;
		
		
		case "TaskMoreData";
			$sql = "SELECT * FROM workers_task WHERE id = '".$_GET['task_id']."' ";
			$res = mysql_db_query(DB,$sql);
			$data = mysql_fetch_array($res);
			
			$_SESSION['tasks']['last_user_task_id_open'] = $_GET['task_id'];
			
			$ex_date2 = explode(" " , $data['insert_date'] );
			
			echo "<table border=\"0\" cellspacing=\"0\" cellpadding=\"0\" style='padding: 10px;'>";
				echo "<tr>";
					echo "<td>";
						echo "<table border=\"0\" cellspacing=\"0\" cellpadding=\"0\" class=\"maintext\">";
							
							$sql = "SELECT owner_id FROM workers_task_owners_choosen WHERE task_id = '".$data['id']."'";
							$res_discassion_owners = mysql_db_query(DB, $sql);
							$n_o = "";
							
							while( $dataWorker = mysql_fetch_array($res_discassion_owners) )
							{
								if( $dataWorker['owner_id'] != $data['sender_owner'] )
								{
									$sql = "SELECT client_name FROM sites_owner WHERE id = '".$dataWorker['owner_id']."' AND ilbiz_worker=1 ORDER BY client_name";
									$resWorker = mysql_db_query(DB, $sql);
									$dataWorker = mysql_fetch_array($resWorker);
									
									$n_o .= stripslashes($dataWorker['client_name']) . ", ";
								}
							}
							$n_o = substr( $n_o , 0 , -2 );
							
							echo "<tr>";
								echo "<td><b>לכבוד:</b> ".$n_o."</td>";
							echo "</tr>";
							echo "<tr><td colspan=5 height=10></td></tr>";
							echo "<tr>";
								echo "<td><b>שעת הוספת המשימה:</b> ".$ex_date2[1]."</td>";
							echo "</tr>";
							echo "<tr><td colspan=5 height=5></td></tr>";
							echo "<tr>";
								echo "<td><b>תיאור המשימה:</b></td>";
							echo "</tr>";
							echo "<tr><td colspan=5 height=5></td></tr>";
							echo "<tr>";
								echo "<td>".nl2br(stripslashes($data['content']))."</td>";
							echo "</tr>";
							if( !empty($data['free_link']) )
							{
								echo "<tr><td colspan=5 height=5></td></tr>";
								echo "<tr>";
									echo "<td><b>קישור חופשי:</b> <a href='".stripslashes($data['free_link'])."' target='_blank' class='maintext'>".stripslashes($data['free_link'])."</a></td>";
								echo "</tr>";
							}
							echo "<tr><td colspan=5 height=25></td></tr>";
							
							
							echo "<tr>";
								echo "<td><div id='showDiscassionList_".$data['id']."'><script>showDiscassionList(\"".SESID."\" , \"".$data['id']."\" )</script></div></td>";
							echo "</tr>";
							
							echo "<tr><td colspan=5 height=10></td></tr>";
							
							$sql = "SELECT client_name , id FROM sites_owner WHERE ilbiz_worker=1 AND deleted=0 AND status=0 AND end_date >= NOW() ORDER BY client_name ";
							$resWorker = mysql_db_query(DB, $sql);
							
							echo "<tr>";
								echo "<td>";
									echo "<a href='javascript:void(0)' onclick='open_close_div(\"hide_add_new_Discassion_".$data['id']."\")' class='maintext'>צור הערה חדשה</a><br><br>";
									echo "<div id='hide_add_new_Discassion_".$data['id']."' style='display:none;'>";
									echo "<form action='javascript:AddTaskesDiscassion(\"".SESID."\" , \"".$data['id']."\")' name='AddTaskesDiscassion_".$data['id']."' id='AddTaskesDiscassion_".$data['id']."' method='post' style='padding:0; margin:0;'>";
									echo "<input type=hidden name='sesid' value='".SESID."'>";
									echo "<input type=hidden name='main' value='AddTaskesDiscassion'>";
									echo "<input type=hidden name='task_id' value='".$data['id']."'>";
									echo "<table border=\"0\" cellspacing=\"0\" cellpadding=\"0\" class=\"maintext\">";
										echo "<tr>";
											echo "<td valign=top>";
											while( $dataWorker = mysql_fetch_array($resWorker) )
											{
												echo "<label><input type='checkbox' name='task_owners[".$dataWorker['id']."]' value='1'> ".stripslashes($dataWorker['client_name'])."</label>&nbsp;&nbsp;";
											}
											echo "</td>";
										echo "</tr>";
										echo "<tr><td colspan=3 height=10></td></tr>";
										echo "<tr>";
											echo "<td><textarea name='add_discassion' cols='' rows='' class='input_style' style='width: 400px; height: 150px;'></textarea></td>";
										
										echo "</tr>";
										echo "<tr><td height=10></td></tr>";
										echo "<tr>";
											echo "<td align=right>
											<input type='button' onclick='open_close_div(\"hide_add_new_Discassion_".$data['id']."\")' class='input_style' style='width: 50px;' value='ביטול'>&nbsp;&nbsp;
											<input type='submit' class='input_style' style='width: 50px;' value='שמירה'></td>";
										echo "</tr>";
									echo "</table>";
									echo "</form>";
									echo "</div>";
								echo "</td>";
							echo "</tr>";
							
							echo "<tr><td colspan=5 height=25></td></tr>";
							
							
							echo "<tr>";
								echo "<td><div id='showTaskesHoursList_".$data['id']."'><script>showTaskesHoursList(\"".SESID."\" , \"".$data['id']."\" )</script></div></td>";
							echo "</tr>";
							echo "<tr><td colspan=5 height=10></td></tr>";
							echo "<tr>";
								echo "<td>";
									echo "<a href='javascript:void(0)' onclick='open_close_div(\"hide_add_new_hours_".$data['id']."\")' class='maintext'>דווח על שעות עבודה במשימה</a><br><br>";
									echo "<div id='hide_add_new_hours_".$data['id']."' style='display:none;'>";
									echo "<form action='javascript:AddTaskesHours(\"".SESID."\" , \"".$data['id']."\")' name='AddTaskesHours_".$data['id']."' id='AddTaskesHours_".$data['id']."' method='post' style='padding:0; margin:0;'>";
									echo "<input type=hidden name='sesid' value='".SESID."'>";
									echo "<input type=hidden name='main' value='AddTaskesHours'>";
									echo "<input type=hidden name='task_id' value='".$data['id']."'>";
									echo "<table border=\"0\" cellspacing=\"0\" cellpadding=\"0\" class=\"maintext\">";
										echo "<tr>";
											echo "<td>שעות עבודה:</td>";
											echo "<td width='3'></td>";
											echo "<td><input type='text' name='add_hours' id='add_hours' class='input_style' style='width: 30px;' ></td>";
											echo "<td width='10'></td>";
											echo "<td>מחיר:</td>";
											echo "<td width='3'></td>";
											echo "<td><input type='text' name='add_price' id='add_price' class='input_style' style='width: 30px;' ></td>";
											echo "<td width='10'></td>";
											echo "<td>הערות:</td>";
											echo "<td width='3'></td>";
											echo "<td><input type='text' name='add_note' id='add_note' class='input_style' style='width: 200px;' ></td>";
											echo "<td width='10'></td>";
											echo "<td><input type='submit' class='input_style' style='width: 50px;' value='שמירה'></td>";
											echo "<td width='10'></td>";
											echo "<td><input type='button' onclick='open_close_div(\"hide_add_new_hours_".$data['id']."\")' class='input_style' style='width: 50px;' value='ביטול'></td>";
										echo "</tr>";
									echo "</table>";
									echo "</form>";
									echo "</div>";
								echo "</td>";
							echo "</tr>";
							
							
						echo "</table>";
					echo "</td>";
				echo "</tr>";
			echo "</table>";
			echo "<div id='reset_AddHour_Form_".$data['id']."'></div>";
			echo "<div id='reset_AddDiscass_Form_".$data['id']."'></div>";
			
			$sql = "UPDATE workers_task_owners_choosen SET view=1 WHERE task_id = '".$data['id']."' AND owner_id = '".WORKERID."' ";
			$res = mysql_db_query(DB,$sql);
			
			echo "<script>taskViewedMsgIcon(\"".SESID."\" , \"".$data['id']."\")</script>";
		break;
		
		case "AddTaskesDiscassion" :
			echo tasks___AddTaskesDiscassion();
		break;
		
		case "showDiscassionList" :
			$viewdSql = "UPDATE workers_task_discassion_owners_choosen SET view = '1' WHERE owner_id = '".WORKERID."' AND discasstion_id IN(SELECT id FROM workers_task_discassion WHERE task_id = '".$_GET['task_id']."')";
			$viewdRes = mysql_db_query(DB,$viewdSql);
			echo tasks___showDiscassionList();
		break;
		
		case "updateTaskStatus" :
			$sql = "UPDATE workers_task SET work_status = '".$_POST['new_work_status']."' WHERE id = '".$_POST['task_id']."' ";
			$res = mysql_db_query(DB, $sql);
			echo "<script>showTaskesList(\"".SESID."\" , \"".$_POST['work_status']."\" )</script>";
			exit;
		break;
		
		
		case "showTaskesHoursList" :
			echo tasks___showTaskesHoursList();
		break;
		
		case "AddTaskesHours" :
			echo tasks___AddTaskesHours();
		break;
		
		case "DELTaskesHours" :
			$sql = "UPDATE workers_task_price SET deleted=1 WHERE task_id = '".$_GET['task_id']."' AND id = '".$_GET['hour_id']."' ";
			$res = mysql_db_query(DB,$sql);
			echo "<script>showTaskesHoursList(\"".SESID."\" , \"".$_GET['task_id']."\" )</script>";
			exit;
		break;
		 
		case "delete_task" :
			$sql = "UPDATE workers_task SET deleted=1 WHERE id = '".$_GET['task_id']."' and sender_owner = '".WORKERID."'";
			$res = mysql_db_query(DB,$sql);
			echo "<script>showTaskesList(\"".SESID."\" , \"".$_SESSION['tasks']['last_user_work_status']."\" )</script>";
				exit;
		break;
		
		case "TaskEditData" :
			echo tasks___addNewTask($_GET['task_id']);
		break;
		
		
		
		case "load_user_ilbiz_products" : 
			$sql = "SELECT pro_name , price , monthly , need_to_check FROM ilbiz_products WHERE id = '".(int)$_GET['pid']."' ";
			$res = mysql_db_query(DB,$sql);
			$data_products = mysql_fetch_array($res , MYSQL_ASSOC);
		
			if( $_GET['unk'] != "" )	{
				$sql = "SELECT p.price , p.monthly , p.need_to_check FROM	users_ilbiz_products as p 
									INNER JOIN users as u ON u.id = p.user_id WHERE 
									product_id = '".(int)$_GET['pid']."' and u.unk = '".mysql_real_escape_string($_GET['unk'])."'";
				$res = mysql_db_query(DB,$sql);
				$data_user_products = mysql_fetch_array($res , MYSQL_ASSOC );
			}
			
			if( $data_user_products['price'] != '' )
				$data = $data_user_products;
			else
				$data = $data_products;
				
				if( (int)$_GET['pid'] > '0' )
				{
					
					echo "<table cellpadding=0 cellspacing=0 border=0>";
						echo "<tr>";
							echo "<td width=200>".stripslashes($data_products['pro_name'])."</td>";
							echo "<td width=20></td>";
							echo "<td width=50 align=center><input type='text' name='price' id='price' value='".$data['price']."' class='inputStyleNew' style='width: 50px;'></td>";
							echo "<td width=20></td>";
							echo "<td width=60 align=center>";
								$selected0 = ( $data['monthly'] == "0" ) ? "selected" : "";
								$selected1 = ( $data['monthly'] == "1" ) ? "selected" : "";
								echo "<select name='monthly' id='monthly' class='inputStyleNew'>";
									echo "<option value='0' ".$selected0.">לא</option>";
									echo "<option value='1' ".$selected1.">כן</option>";
								echo "</select>";
							echo "</td>";
							echo "<td width=20></td>";
							echo "<td width=110 align=center>";
								$selected0 = ( $data['need_to_check'] == "0" ) ? "selected" : "";
								$selected1 = ( $data['need_to_check'] == "1" ) ? "selected" : "";
								echo "<select name='need_to_check' id='need_to_check' class='inputStyleNew'>";
									echo "<option value='0' ".$selected0.">לא</option>";
									echo "<option value='1' ".$selected1.">כן</option>";
								echo "</select>";
							echo "</td>";
						echo "</tr>";
						echo "<tr><td colspan=7 height=10></td></tr>";
					echo "</table>";
				}
				else
				{
					echo "<table cellpadding=0 cellspacing=0 border=0>";
						echo "<tr>";
							echo "<td>לא נמצא שירות \ מוצר: ".iconv("utf-8","windows-1255",$_GET['prodName'])."</td>";
						echo "</tr>";
						echo "<tr><td colspan=7 height=10></td></tr>";
					echo "</table>";
				}
		break;
		case "anf" : //additional_new_func
			$sql = "select auth,client_name from sites_owner where id = '".OID."'";
			$res_auth = mysql_db_query(DB,$sql);
			$date_auth = mysql_fetch_array($res_auth);

			define('AUTH',$date_auth['auth']);			
			
			$file_name = $_REQUEST['gf']; //get_file
			if(isset($_REQUEST['gfunc'])){
				$func_name = $_REQUEST['gfunc']; //get_function
			}
			else{
				$func_name = $file_name;
			}
			require_once($file_name.'.php');
			$func_name();
			
		break;		
	}


$endtime = microtime();
$endarray = explode(" ", $endtime);
$endtime = $endarray[1] + $endarray[0];
$totaltime = $endtime - $starttime; 
$totaltime = round($totaltime,5);
//echo "This page loaded in $totaltime seconds.";



function microtime_float()
{
    list($usec, $sec) = explode(" ", microtime());
    return ((float)$usec + (float)$sec);
}

function dateDiff($startDate, $endDate) 
{ 
    // Parse dates for conversion 
    $startArry = date_parse($startDate); 
    $endArry = date_parse($endDate); 

    // Convert dates to Julian Days 
    $start_date = gregoriantojd($startArry["month"], $startArry["day"], $startArry["year"]); 
    $end_date = gregoriantojd($endArry["month"], $endArry["day"], $endArry["year"]); 

    // Return difference 
    return round(($end_date - $start_date), 0); 
} 
