<?php

function calender_events()
{
	$date = getDate();
	$choose_month = ( $_GET['mon'] == "" ) ? date('m') : $_GET['mon'];
	$choose_year = ( $_GET['year'] == "" ) ? $date['year'] : $_GET['year'];
	
	$sql = "SELECT event_name, content, id, event_date FROM user_calender_events WHERE deleted=0 AND event_date LIKE '".$choose_year."-".$choose_month."%' AND unk='".UNK."' ORDER BY event_date";
	$res = mysql_db_query(DB,$sql);
	
	$sql2 = "SELECT title FROM users_calendar_headline WHERE unk = '".UNK."'";
	$res2 = mysql_db_query(DB,$sql2);
	$data_title = mysql_fetch_array($res2);
	
	$value_title = ($data_title['title'] == "" ) ? "לוח אירועים" : stripslashes($data_title['title']);
	
	echo "<table border=\"0\" cellspacing=\"0\" cellpadding=\"0\" class=\"maintext\">";
		
		echo "<tr>";
			echo "<td>
				<table border=\"0\" cellspacing=\"0\" cellpadding=\"0\" class=\"maintext\">
				<form action='index.php' method=GET name='formi_name_cal'>
				<input type='hidden' name='main' value='Update_calendar_headline'>
				<input type='hidden' name='unk' value='".UNK."'>
				<input type='hidden' name='sesid' value='".SESID."'>
				<input type='hidden' name='mon' value='".$_GET['mon']."'>
				<input type='hidden' name='year' value='".$_GET['year']."'>

					<tr>
						<td>כותרת לוח השנה</td>
						<td width='10'></td>
						<td><input type=text name='calendar_headline' value='".$value_title."' class='input_style'></td>
						<td width='10'></td>
						<td><input type=submit value='שלח' class='submit_style'></td>
					</tr>
				</form>
				</table>
			</td>";
		echo "</tr>";
		
		echo "<tr><td height=15></td></tr>";
		
		
		echo "<tr>";
			echo "<td><a href='index.php?main=calender_events_edit&type=events&unk=".UNK."&sesid=".SESID."' class='maintext'>הוסף אירוע חדש</a></td>";
		echo "</tr>";
		
		echo "<tr><td height=10></td></tr>";
		
		echo "<tr>";
			echo "<td>";
				echo "<table border=\"0\" cellspacing=\"0\" cellpadding=\"0\" class=\"maintext\">";
				echo "<form action='index.php' name='search_month' method='GET'>";
				echo "<input type='hidden' name='main' value='calender_events'>";
				echo "<input type='hidden' name='unk' value='".UNK."'>";
				echo "<input type='hidden' name='sesid' value='".SESID."'>";
					
					$selected1 = ( $choose_month == "1" ) ? "selected" : "";
					$selected2 = ( $choose_month == "2" ) ? "selected" : "";
					$selected3 = ( $choose_month == "3" ) ? "selected" : "";
					$selected4 = ( $choose_month == "4" ) ? "selected" : "";
					$selected5 = ( $choose_month == "5" ) ? "selected" : "";
					$selected6 = ( $choose_month == "6" ) ? "selected" : "";
					$selected7 = ( $choose_month == "7" ) ? "selected" : "";
					$selected8 = ( $choose_month == "8" ) ? "selected" : "";
					$selected9 = ( $choose_month == "9" ) ? "selected" : "";
					$selected10 = ( $choose_month == "10" ) ? "selected" : "";
					$selected11 = ( $choose_month == "11" ) ? "selected" : "";
					$selected12 = ( $choose_month == "12" ) ? "selected" : "";
					
					echo "<tr>";
						echo "<td>
							<select name='mon' class='input_style' style='width: 75px;'>
								<option value='01' ".$selected1.">ינואר</option>
								<option value='02' ".$selected2.">פברואר</option>
								<option value='03' ".$selected3.">מרץ</option>
								<option value='04' ".$selected4.">אפריל</option>
								<option value='05' ".$selected5.">מאי</option>
								<option value='06' ".$selected6.">יוני</option>
								<option value='07' ".$selected7.">יולי</option>
								<option value='08' ".$selected8.">אוגוסט</option>
								<option value='09' ".$selected9.">ספטמבר</option>
								<option value='10' ".$selected10.">אוקטובר</option>
								<option value='11' ".$selected11.">נובמבר</option>
								<option value='12' ".$selected12.">דצמבר</option>
							</select>
						</td>";
						echo "<td width=20></td>";
						echo "<td>";
							echo "<select name='year' class='input_style' style='width: 55px;'>";
								for( $i=($date['year']-1 ) ; $i<=($date['year']+3) ; $i++ )
								{
									$selected = ( $i == $choose_year ) ? "selected" : ""; 
									echo "<option value='".$i."' ".$selected.">".$i."</option>";
								}
								
							echo "</select>";
						echo "</td>";
						echo "<td width=20></td>";
						echo "<td><input type='submit' value='חפש' class='submit_style' style='width: 40px;'></td>";
					echo "</tr>";
					
				echo "</form>";
				echo "</table>";
			echo "</td>";
		echo "</tr>";
		
		echo "<tr><td height=10></td></tr>";
		
		echo "<tr>";
			echo "<td>";
				echo "<table border=\"0\" cellspacing=\"0\" cellpadding=\"0\" class=\"maintext\" width=350>";
					
					while( $data = mysql_fetch_array($res) )
					{
						echo "<tr>";
							echo "<td><b>".stripslashes($data['event_name'])."</b></td>";
							echo "<td align=left>".GlobalFunctions::show_dateTime_field($data['event_date'])."</td>";
						echo "</tr>";
						
						echo "<tr>";
							echo "<td colspan=2>".nl2br(stripslashes($data['content']))."</td>";
						echo "</tr>";
						
						echo "<tr>";
							echo "<td colspan=2 align=left><a href='index.php?main=calender_events_edit&event_id=".$data['id']."&mon=".$_GET['mon']."&year=".$_GET['year']."&type=events&unk=".UNK."&sesid=".SESID."' class='maintext'>עריכה</a>&nbsp;&nbsp;|&nbsp;&nbsp;<a href='index.php?main=calender_events_del&event_id=".$data['id']."&mon=".$_GET['mon']."&year=".$_GET['year']."&unk=".UNK."&sesid=".SESID."' class='maintext' onclick='return can_i_del()'>מחיקה</a></td>";
						echo "</tr>";
						
						echo "<tr><td colspan=2 height=3></td></tr>";
						echo "<tr><td colspan=2><hr color=000000 size=1 width=100%></td></tr>";
						echo "<tr><td colspan=2 height=3></td></tr>";
					}
				echo "</table>";
			echo "</td>";
		echo "</tr>";
		
	echo "</table>";
}


function Update_calendar_headline()
{
	
	$sql2 = "SELECT title FROM users_calendar_headline WHERE unk = '".UNK."'";
	$res2 = mysql_db_query(DB,$sql2);
	$data_title = mysql_fetch_array($res2);
	
	if( $data_title['title'] == "" )
	{
		$sql = "INSERT INTO users_calendar_headline (title,unk) VALUES ( '".mysql_r_e_s($_GET['calendar_headline'])."' , '".UNK."' )";
	}
	else
	{
		$sql = "UPDATE users_calendar_headline set title = '".mysql_r_e_s($_GET['calendar_headline'])."' WHERE unk = '".UNK."'";
	}
	$res = mysql_db_query(DB,$sql);
	
	echo "<script>window.location.href='index.php?main=calender_events&type=".$_GET['type']."&mon=".$_GET['mon']."&year=".$_GET['year']."&sesid=".SESID."&unk=".UNK."';</script>";
		exit;
}


function calender_events_edit()
{
	if( $_GET['event_id'] )
	{
		$sql = "select * from user_calender_events where deleted = '0' and id = '".ifint($_GET['event_id'])."' and unk = '".UNK."'";
		$res = mysql_db_query(DB,$sql);
		$data = mysql_fetch_array($res);
	}
	
	$status[0] = "פעיל באתר";
	$status[1] = "לא פעיל באתר";
	
	if( $data['event_date'] != "" )
	{
		$explode_date_time = explode( " " , $data['event_date']);
		$explode_date = explode( "-" , $explode_date_time[0] );
		$temp_date = $explode_date[2]."-".$explode_date[1]."-".$explode_date[0];
		$explode_time = explode( ":" , $explode_date_time[1] );
	}
	$time_input = "
	<table border=\"0\" cellspacing=\"0\" cellpadding=\"0\" class=\"maintext\">
		<tr>
			<td><input type='text' name='time_mins' value='".$explode_time[1]."' class='input_style' style='width: 20px;' maxlength='2'></td>
			<td width=2></td>
			<td>:</td>
			<td width=2></td>
			<td><input type='text' name='time_hour' value='".$explode_time[0]."' class=\"input_style\" onKeyup=\"autotab(this, document.main_form.time_mins)\" style='width: 20px;' maxlength='2'></td>
			<td width=20></td>
			<td style='font-size:10px;'>hh:mm</td>
		</tr>
	</table>
	";
	
	$form_arr = array(
				array("hidden","main","calender_events_edit_DB"),
				array("hidden","type",$_GET['type']),
				array("hidden","record_id",$_GET['event_id']),
				array("hidden","sesid",SESID),
				array("hidden","data_arr[unk]",UNK),
				array("hidden","unk",UNK),
				array("hidden","mon",$_GET['mon']),
				array("hidden","year",$_GET['year']),
				
				array("text","event_date_only",$temp_date,"* תאריך האירוע", "class='input_style' onClick=\"getCalendarFor(document.main_form.event_date_only);return false\""),
				array("castum_input",$time_input,"","* שעת האירוע"),
				array("text","data_arr[event_name]",$data['event_name'],"* כותרת האירוע", "class='input_style'"),
				array("textarea","data_arr[content]",$data['content'],"תיאור האירוע", "class='input_style' style='width: 300px; height: 100px;'"),
				
				array("text","data_arr[link_name]",$data['link_name'],"שם קישור מצורף", "class='input_style'"),
				array("text","data_arr[link_url]",$data['link_url'],"כתובת קישור מצורף", "class='input_style'"),
				
				array("select","status[]",$status,"סטטוס פעילות",$data['status'],"data_arr[status]", "class='input_style'"),
				
				array("submit","submit","שלח טופס", "class='submit_style'")
	);
	
	$mandatory_fields = array("data_arr[event_name]","event_date_only","time_hour");
	$more = "class='maintext'";
	
		
	echo "<table border=\"0\" cellspacing=\"0\" cellpadding=\"0\" class=\"maintext\">";
	
		echo "<tr>";
			echo "<td>".FormCreator::create_form($form_arr,"index.php", $more, $mandatory_fields)."</td>";
		echo "</tr>";
		
	echo "</table>";
}


function calender_events_edit_DB()
{
	
	$data_arr = $_POST['data_arr'];
	
	$image_settings = array(
			"table_name" => "user_calender_events",
			"after_success_goto" => "DO_NOTHING",
	);
	
	$temp_date = explode( "-" , $_POST['event_date_only'] );
	$event_date_time = $temp_date[2]."-".$temp_date[1]."-".$temp_date[0]." ".$_POST['time_hour'].":".$_POST['time_mins'];
	
		if( $_POST['record_id'] == "" )
		{
			insert_to_db($data_arr, $image_settings);
			
			$mysql_insert_id = $GLOBALS['mysql_insert_id'];
			
			$sql = "UPDATE user_calender_events SET insert_date = NOW() , event_date = '".$event_date_time."' WHERE id = '".$mysql_insert_id."' AND unk = '".UNK."'";
			$res = mysql_db_query(DB, $sql);
		}
		else
		{
			update_db($data_arr, $image_settings);
			
			$sql = "UPDATE user_calender_events SET event_date = '".$event_date_time."' WHERE id = '".$_POST['record_id']."' AND unk = '".UNK."'";
			$res = mysql_db_query(DB, $sql);
		}
			
		echo "<script>window.location.href='index.php?main=calender_events&type=".$_POST['type']."&mon=".$_POST['mon']."&year=".$_POST['year']."&sesid=".SESID."&unk=".UNK."';</script>";
			exit;
}


function calender_events_del()
{
	
	$sql = "UPDATE user_calender_events SET deleted=1 WHERE unk = '".UNK."' AND id = '".$_GET['event_id']."' LIMIT 1";
	$res = mysql_db_query(DB, $sql);
	
	echo "<script>window.location.href='index.php?main=calender_events&mon=".$_GET['mon']."&year=".$_GET['year']."&sesid=".SESID."&unk=".UNK."';</script>";
			exit;
}

?>