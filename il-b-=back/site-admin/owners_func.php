<?php

function owners_list()
{
	$sql = "select * from sites_owner where deleted = '0'";
	$res = mysql_db_query(DB,$sql);
	
	echo "<table border=\"0\" cellspacing=\"0\" cellpadding=\"3\" class=\"maintext\" bgcolor=\"#cccccc\">";
		
		echo "<tr>
			<td colspan=\"20\"><A href=\"?&sesid=".SESID."\" class=\"maintext\">חזרה לתפריט הראשי</a></td>
		</tr>";
		echo "<tr><td colspan=\"20\" height=\"7\"></td></tr>";
		echo "<tr>
			<td colspan=\"20\"><A href=\"?main=owners_profile&sesid=".SESID."\" class=\"maintext\">יצירת משתמש חדש</a></td>
		</tr>";
		echo "<tr><td colspan=\"20\" height=\"11\"></td></tr>";
		echo "<tr>";
			echo "<td><strong>שם העסק</strong></td>";
			echo "<td width=\"15\"></td>";
			echo "<td><strong>שם הלקוח</strong></td>";
			echo "<td width=\"15\"></td>";
			echo "<td><strong>שם משתמש</strong></td>";
			echo "<td width=\"15\"></td>";
			echo "<td><strong>סיסמא</strong></td>";
			echo "<td width=\"15\"></td>";
			echo "<td><strong>מספר אתרים</strong></td>";
			echo "<td width=\"15\"></td>";
			echo "<td><strong>פעיל ברשת</strong></td>";
			echo "<td width=\"15\"></td>";
			echo "<td><strong>עובד אילביז?</strong></td>";
			echo "<td width=\"15\"></td>";
			echo "<td><strong>סיום חוזה</strong></td>";
			echo "<td width=\"15\"></td>";
			echo "<td><strong>עדכון</strong></td>";
			echo "<td width=\"15\"></td>";
			echo "<td><strong>מחיקה</strong></td>";
		echo "</tr>";
		
		$count = 0;
		while( $data = mysql_fetch_array($res) )	
		{
			$temp_date = getDate();
			$year = $temp_date['year'];
			$mon = $temp_date['mon'];
			$day = $temp_date['mday'];
			
			$temp_date = $year."-".$mon."-".$day;
			$sql2 = "select id from users where owner_id = '{$data['id']}' and status = '0' and end_date >= '".$temp_date."' and deleted = '0'";
			$res2 = mysql_db_query(DB,$sql2);
			$num_owners_sites = mysql_num_rows($res2);
			
			$status_name = ( $data['status'] == "0" ) ? "פעיל" : "לא פעיל";
			$ilbiz_worker = ( $data['ilbiz_worker'] == "0" ) ? "לא" : "כן";
			
			
			$temp = explode( "-" , $data['end_date']);
			if( $data['end_date'] <= $temp_date )
				$end_date = "<b>".$temp[2]."-".$temp[1]."-".$temp[0]."</b>";
			else
				$end_date = $temp[2]."-".$temp[1]."-".$temp[0];
			
			$bg = ( $count%2 == 0 ) ? "eeeeee" : "ffffff";
			echo "<tr><Td colspan=\"20\" height=\"5\" height=\"5\"></TD></tr>";
			echo "<tr bgcolor=\"#{$bg}\"><Td colspan=\"20\" height=\"5\"></TD></tr>";
			echo "<tr bgcolor=\"#{$bg}\">";
				echo "<td>".stripslashes($data['company'])."</td>";
				echo "<td width=\"10\"></td>";
				echo "<td>".stripslashes($data['client_name'])."</td>";
				echo "<td width=\"10\"></td>";
				echo "<td>".stripslashes($data['username'])."</td>";
				echo "<td width=\"10\"></td>";
				echo "<td>".stripslashes($data['password'])."</td>";
				echo "<td width=\"10\"></td>";
				echo "<td>".$num_owners_sites."</td>";
				echo "<td width=\"10\"></td>";
				echo "<td>".$status_name."</td>";
				echo "<td width=\"10\"></td>";
				echo "<td>".$ilbiz_worker."</td>";
				echo "<td width=\"10\"></td>";
				echo "<td>".$end_date."</td>";
				echo "<td width=\"10\"></td>";
				echo "<td><a href=\"?main=owners_profile&record_id=".$data['id']."&sesid=".SESID."\" class=\"maintext\">עדכון</a></td>";
				echo "<td width=\"10\"></td>";
				echo "<td><a href=\"?main=del_DB_owner&record_id=".$data['id']."&sesid=".SESID."\" class=\"maintext\" onclick=\"return can_i_del();\"><strong style=\"color:red;\">מחיקה</strong></a></td>";
			echo "</tr>";
			echo "<tr bgcolor=\"#{$bg}\"><Td colspan=\"20\" height=\"5\"></TD></tr>";
			$count++;
		}
		echo "<tr><Td colspan=\"20\" height=\"5\" height=\"5\"></TD></tr>";
		
	echo "</table>";
}

function owners_profile()	{

	if($_GET['record_id'] != "" )	{
		$sql = "select * from sites_owner where deleted = '0' and id = '".$_GET['record_id']."'";
		$res = mysql_db_query(DB,$sql);
		$data = mysql_fetch_array($res);
	}
	
	$temp_date = getDate();
	$year = $temp_date['year'];
	$mon = $temp_date['mon'];
	$day = $temp_date['mday'];
			
	$insert_date_temp = $year."-".$mon."-".$day;

	$status[0] = "חשבון פעיל";
	$status[1] = "חשבון לא פעיל";
	
	$ilbiz_worker[0] = "לא";
	$ilbiz_worker[1] = "כן";
	
	$auth[0] = "אל תציג לפניו כלום";
	$auth[1] = "משתמש בעל אתרים";
	$auth[2] = "משתמש בעל אתרים ופורטל";
	$auth[3] = "הרשאה מיוחדת רמה 3";
	$auth[4] = "הרשאה מיוחדת רמה 4";	
	$auth[5] = "הרשאה מיוחדת רמה 5";
	$auth[6] = "הרשאה מיוחדת רמה 6";
	$auth[7] = "הרשאה מיוחדת רמה 7";
	$auth[8] = "הרשאה מיוחדת רמה 8";
	$auth[9] = "הרשאה מיוחדת רמה 9";



	
	$insert_date = ( $data['date'] == "" ) ? $insert_date_temp : $data['date'] ;
	
	$goto_main = ( $_GET['record_id'] ) ? "update_DB_owner" : "new_DB_owner";
	$form_arr = array(
		array("hidden","main",$goto_main),
		array("hidden","record_id",$data['id']),
		array("hidden","sesid",SESID),
		
		
		
		array("text","data_arr[username]",$data['username'],"* שם משתמש", "class='input_style'","","1"),
		array("text","data_arr[password]",$data['password'],"* סיסמא", "class='input_style'","","1"),
		
		array("text","data_arr[client_name]",$data['client_name'],"* שם לקוח", "class='input_style'","","1"),
		array("text","data_arr[company]",$data['company'],"חברה", "class='input_style'","","1"),
		array("text","data_arr[email]",$data['email'],"* אימייל", "class='input_style'","","1"),
		array("text","data_arr[phone]",$data['phone'],"* טלפון", "class='input_style'","","1"),
		array("text","data_arr[fax]",$data['fax'],"פקס", "class='input_style'","","1"),
		array("text","data_arr[homesite]",$data['homesite'],"אתר כולל //:http", "class='input_style'","","1"),
		
		array("select","auth[]",$auth,"הרשאה",$data['auth'],"data_arr[auth]", "class='input_style''"),
		array("select","status[]",$status,"סטטוס",$data['status'],"data_arr[status]", "class='input_style''"),
		array("select","ilbiz_worker[]",$ilbiz_worker,"עובד אילביז?",$data['ilbiz_worker'],"data_arr[ilbiz_worker]", "class='input_style'"),
		
		array("date","end_date",$data['end_date'],"תאריך סיום חוזה <font style=\"font-size:9px;\" class=\"maintext_small\">dd-mm-yyyy</font>", "class='input_style'"),
		
		array("date","date",$insert_date,"תאריך הכנסה", "class='input_style'","hidden"),
				
		array("submit","submit","שמירה", "class='submit_style'")
	);
	
// שדות חובה
$mandatory_fields = array("data_arr[username]","data_arr[password]","data_arr[client_name]","data_arr[email]","data_arr[phone]");
$more = "class='maintext'";

echo "<table border=\"0\" cellspacing=\"0\" cellpadding=\"0\" class=\"maintext\">";
		
		echo "<tr>";
			echo "<td><A href=\"?&sesid=".SESID."\" class=\"maintext\">חזרה לתפריט הראשי</a></td>";
		echo "</tr>";
		echo "<tr><td height=\"7\"></td></tr>";
		echo "<tr>";
			echo "<td><A href=\"?main=owners_list&sesid=".SESID."\" class=\"maintext\">לרשימת הבעלים</a></td>";
		echo "</tr>";
		
		echo "<tr><td height=\"11\"></td></tr>";
		
		echo "<tr>";
			echo "<td>".FormCreator::create_form($form_arr,"index.php", $more, $mandatory_fields)."</td>";
		echo "</tr>";
		
		
	echo "</table>";
}

function new_DB_owner()	{

	$image_settings = array(
		after_success_goto=>"?main=owners_list&sesid=".SESID."",
		table_name=>"sites_owner",
		flip_date_to_original_format=>array("date" , "end_date"),
	);
	  
	$data_arr = ($_POST['data_arr'])? $_POST['data_arr'] : $_GET['data_arr'];
	insert_to_db($data_arr, $image_settings);
}

function update_DB_owner()	{

	$image_settings = array(
		after_success_goto=>"?main=owners_list&sesid=".SESID."",
		table_name=>"sites_owner",
		flip_date_to_original_format=>array("date" , "end_date"),
	);
	$data_arr = ($_POST['data_arr'])? $_POST['data_arr'] : $_GET['data_arr'];
	update_db($data_arr, $image_settings);
}

function del_DB_owner()	{

	$sql = "update sites_owner set deleted = '1' where id = '".$_GET['record_id']."' limit 1";
	$res = mysql_db_query(DB,$sql);
	
	echo "<script>window.location.href='?main=owners_list&sesid=".SESID."'</script>";
		exit;
}







/***********************************************************************************************/

function messagesSinon()
{
	
	$sql = "select * from usersMessageSinon where deleted = '0'";
	$res = mysql_db_query(DB,$sql);
	
	echo "<table border=\"0\" cellspacing=\"0\" cellpadding=\"3\" class=\"maintext\" bgcolor=\"#cccccc\">";
		
		echo "<tr>
			<td colspan=\"20\"><A href=\"?&sesid=".SESID."\" class=\"maintext\">חזרה לתפריט הראשי</a></td>
		</tr>";
		echo "<tr><td colspan=\"20\" height=\"7\"></td></tr>";
		echo "<tr>
			<td colspan=\"20\"><A href=\"?main=edit_messagesSinon&sesid=".SESID."\" class=\"maintext\">יצירת הודעה חדשה חדש</a></td>
		</tr>";
		echo "<tr><td colspan=\"20\" height=\"11\"></td></tr>";
		echo "<tr>";
			echo "<td><strong>תאריך שליחה</strong></td>";
			echo "<td width=\"15\"></td>";
			echo "<td><strong>נושא</strong></td>";
			echo "<td width=\"15\"></td>";
			echo "<td><strong>מספר תיאורטי של מקבלי ההודעה</strong></td>";
			echo "<td width=\"15\"></td>";
			echo "<td><strong>מספר מקבלי ההודעה בפועל</strong></td>";
			echo "<td width=\"15\"></td>";			
			echo "<td><strong>פעיל</strong></td>";
			echo "<td width=\"15\"></td>";
			echo "<td><strong>שלח הודעה לאימייל</strong></td>";
			echo "<td width=\"15\"></td>";
			echo "<td><strong>ערוך</strong></td>";
			if( AUTH >= 9 )
			{
			echo "<td width=\"15\"></td>";
			echo "<td><strong>מחק</strong></td>";
			}
		echo "</tr>";
		
		$count = 0;
		while( $data = mysql_fetch_array($res) )	
		{
			$sin_city = ( $data['send_city'] != "0" ) ? " AND u.city = '".$data['send_city']."' " : "";
			$sin_gender = ( $data['send_gender'] != "0" ) ? " AND u.gender = '".$data['send_gender']."' " : "";
			$sin_birthday = ( $data['send_birthday_start'] != "0000-00-00" ) ? " AND u.birthday <= '".$data['send_birthday_start']."' " : "";
			$sin_birthday .= ( $data['send_birthday_end'] != "0000-00-00" ) ? " AND u.birthday >= '".$data['send_birthday_end']."' " : "";
			switch( $data['client_10service'] )
			{
				case "1" :		$client_10service = " AND uxs.unk = u.unk AND uxs.belongTo10service = '1' ";	$more_Table = "user_extra_settings as uxs , ";	break;
				case "2" :		$client_10service = " AND uxs.unk = u.unk AND uxs.belongTo10service = '0' "; 	$more_Table = "user_extra_settings as uxs , ";	break;
				case "3" :					
					$client_10service = " AND u.unk IN(SELECT unk FROM user_e_card_settings WHERE active = '1') ";
				break;
				default:  $client_10service = ""; $more_Table = "";
			}
	
			$temp_date = getDate();
			$year = $temp_date['year'];
			$mon = $temp_date['mon'];
			$day = $temp_date['mday'];
			
			$temp_date = $year."-".$mon."-".$day;
			
			$sql_checkCat = "SELECT cat_id FROM usersMessageSinon_x_cat WHERE sinon_id = '".$data['id']."' LIMIT 1";
			$res_checkCat = mysql_db_query(DB,$sql_checkCat);
			$data_checkCat = mysql_fetch_array($res_checkCat);
			$date_where = " and u.end_date >= '".$temp_date."' and u.status = '0' ";
			if( $data['client_10service'] == '3'){
				$date_where = "";
			}
			if( $data_checkCat['cat_id'] == "" )
				$sql2 = "select u.id from ".$more_Table." users as u where u.email != '' and u.active_send_email = 0 ".$date_where." and u.deleted = '0'".$sin_city.$sin_gender.$sin_birthday.$client_10service;
			else	{
				$sql2 = "select u.id from ".$more_Table." users as u INNER JOIN user_cat AS uc ON uc.user_id = u.id 
									INNER JOIN usersMessageSinon_x_cat AS c ON uc.cat_id = c.cat_id AND c.sinon_id = '".$data['id']."' 
									where u.email != '' and u.active_send_email = 0 ".$date_where." and u.deleted = '0'".$sin_city.$sin_gender.$sin_birthday.$client_10service." group by u.id";
			}
			$res2 = mysql_db_query(DB,$sql2);
			$num_owners_sites = mysql_num_rows($res2);
			
			$status_name = ( $data['status'] == "0" ) ? "<b style='color: green;'>פעיל</b>" : "<b style='color: red;'>לא פעיל</b>";
			$sent_mails_value = ( $data['sent_mails'] == "1" ) ? "<b style='color: green;'>שלח אימייל לסינון (נשלח)</b>" : "שלח אימייל לסינון";
			
			$sent_mails_confirm = ( $data['sent_mails'] == "1" ) ? "onclick='aa = confirm(\"?האימייל נשלח בעבר, ברצונך לשלוח שוב\"); if(aa == true )  return true;		else			return false;'" : "onclick='aa = confirm(\"?אתה הולך לשלוח ".$num_owners_sites." מיילים, האם אתה בטוח\"); if(aa == true )  return true;		else			return false;'";
				
		
			
			
			$bg = ( $count%2 == 0 ) ? "eeeeee" : "ffffff";
			echo "<tr><Td colspan=\"20\" height=\"5\" height=\"5\"></TD></tr>";
			echo "<tr bgcolor=\"#{$bg}\"><Td colspan=\"20\" height=\"5\"></TD></tr>";
			echo "<tr bgcolor=\"#{$bg}\">";
				echo "<td>".GlobalFunctions::show_dateTime_field(stripslashes($data['date_sent']))."</td>";
				echo "<td width=\"10\"></td>";
				echo "<td>".stripslashes($data['subject'])."</td>";
				echo "<td width=\"10\"></td>";
				echo "<td>".$num_owners_sites."</td>";
				echo "<td width=\"10\"></td>";
				echo "<td>";
				$sent_emails_list = str_replace(",","<br/>",$data['sent_emails_list']);
				$sent_names_list = str_replace(",","<br/>",$data['sent_names_list']);
					echo "<a href='javascript://' onclick='open_container(\"sent_list_holder_".$data['id']."\");' >".$data['sent_mails_total']."</a>";
					echo "<div style='display:none;' id='sent_list_holder_".$data['id']."'>".$sent_emails_list."<br/><br/>".$sent_names_list."</div>";
				echo "</td>";				
				echo "<td width=\"10\"></td>";
				echo "<td>".$status_name."</td>";
				echo "<td width=\"10\"></td>";
				echo "<td><a href=\"?main=messagesSinon_send_mail&record_id=".$data['id']."&sesid=".SESID."\" ".$sent_mails_confirm." class=\"maintext\" target=\"_blank\">".$sent_mails_value."</a></td>";
				echo "<td width=\"10\"></td>";
				echo "<td><a href=\"?main=edit_messagesSinon&record_id=".$data['id']."&sesid=".SESID."\" class=\"maintext\">עריכה</a></td>";
				if( AUTH >= 9 )
				{	
				echo "<td width=\"10\"></td>";
				echo "<td><a href=\"?main=del_messagesSinon&record_id=".$data['id']."&sesid=".SESID."\" class=\"maintext\" onclick=\"return can_i_del();\"><strong style=\"color:red;\">מחיקה</strong></a></td>";
				}
			echo "</tr>";
			echo "<tr bgcolor=\"#{$bg}\"><Td colspan=\"20\" height=\"5\"></TD></tr>";
			$count++;
		}
		echo "<tr><Td colspan=\"20\" height=\"5\" height=\"5\"></TD></tr>";
		
	echo "</table>";
	echo "<script type='text/javascript'>function open_container(cont_name){jQuery(\"#\"+cont_name).show();}</script>"; 
}

function edit_messagesSinon()
{
	if($_GET['record_id'] != "" )	{
		$sql = "select * from usersMessageSinon where deleted = '0' and id = '".$_GET['record_id']."'";
		$res = mysql_db_query(DB,$sql);
		$data = mysql_fetch_array($res);
	}
	
	$temp_date = getDate();
	$year = $temp_date['year'];
	$mon = $temp_date['mon'];
	$day = $temp_date['mday'];
			
	$insert_date_temp = $year."-".$mon."-".$day;

	$status[0] = "הודעה פעיל";
	$status[1] = "הודעה לא פעילה";
	
	$gender[1] = "זכר";
	$gender[2] = "נקבה";
	
	$client_10service[0] = "שלח לכולם";
	$client_10service[1] = "שלח ללקוחות שירות 10 בלבד";
	$client_10service[2] = "שלח ללקוחות שלא מינויים לשירות 10";
	$client_10service[3] = "שלח ללקוחות 10card";
	
	$city_combo = "<table border=\"0\" cellspacing=\"0\" cellpadding=\"0\" class=\"maintext\">
			<tr>
				<td>עיר</td>
				<td width=\"149\"></td>
				<td>";
					$city_combo .= "<span style=\"behavior:url(options.htc); width:1px;\">";
							$city_combo .= "<select name=\"data_arr[send_city]\" class=\"input_style\">";
							$city_combo .= "<option value=\"\">בחירת עיר</option>";
								
								$sql = "select id,name from cities order by name";
								$res_city = mysql_db_query(DB,$sql);
								
								while($data_city = mysql_fetch_array($res_city))	{
									$checked_city = ($data['send_city'] == $data_city['id'])? " selected" : "";
									$city_combo .= "<option value=\"".$data_city['id']."\"".$checked_city.">".stripslashes($data_city['name'])."</option>";
								}
							$city_combo .= "</select>";
						$city_combo .= "</span>
					</td>
				</tr>
			</table>";
	
	
	$sql = "select cat_name,id from biz_categories where father = 0 and status = 1";
	$res_father = mysql_db_query(DB,$sql);
	
	$cat_list = "<table border=\"0\" cellpadding=\"0\" cellspacing=\"0\">";
		$cat_list .= "<tr>";
			$cat_list .= "<td>";
			
				$cat_list .= "<ul style=\"list-style:none\" class=\"dhtmlTree\">";
					while( $data_father = mysql_fetch_array($res_father) )
					{
						
						$sql = "select cat_id from usersMessageSinon_x_cat where sinon_id = '".$data['id']."' and cat_id = '".$data_father['id']."'";
						$res_cat_id = mysql_db_query(DB,$sql);
						$data_cat_id = mysql_fetch_array($res_cat_id);
						
						if( $data_cat_id['cat_id'] == $data_father['id'] )	{
							$selected1 = "checked";
							$checked_cats[] = $data_father['cat_name'];
						}	else	{
							$selected1 = "";
						}
						
						$cat_list .= "<li><img src=\"options.fiels/plus.jpg\" onclick=\"htmldb_ToggleWithImage(this,'treeCAT".$data_father['id']."')\" class=\"pseudoButtonInactive\" />
						<input type=\"checkbox\" name=\"select_cat[".$data_father['id']."]\" value=\"1\" ".$selected1.">
						".stripslashes($data_father['cat_name'])."
						</li>";
						
						$sql = "select cat_name,id from biz_categories where father = ".$data_father['id']." and status = 1";
						$res_father_cat = mysql_db_query(DB,$sql);
						
						$cat_list .= "<ul id=\"treeCAT".$data_father['id']."\" htmldb:listlevel=\"2\" style=\"padding-right:15px;list-style:none;display:none;\" class=\"dhtmlTree\">";
							while( $data_father_cat = mysql_fetch_array($res_father_cat) )
							{
								$sql = "select cat_id from usersMessageSinon_x_cat where sinon_id = '".$data['id']."' and cat_id = '".$data_father_cat['id']."'";
								$res_cat_id = mysql_db_query(DB,$sql);
								$data_cat_id = mysql_fetch_array($res_cat_id);
								
								if( $data_cat_id['cat_id'] == $data_father_cat['id'] )	{
									$selected2 = "checked";
									$checked_cats[] = "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;".$data_father_cat['cat_name'];
								}	else	{
									$selected2 = "";
								}
						
								$sql = "select cat_name,id from biz_categories where father = '".$data_father_cat['id']."' and status = '1'";
								$res_father_tat_cat = mysql_db_query(DB,$sql);
								$num_father_tat_cat = mysql_num_rows($res_father_tat_cat);
								
								if( $num_father_tat_cat > 0 )
								{
									$cat_list .= "<li>
									<img src=\"options.fiels/plus.jpg\" onclick=\"htmldb_ToggleWithImage(this,'treeF_CAT".$data_father_cat['id']."')\" class=\"pseudoButtonInactive\" />
									<input type=\"checkbox\" name=\"select_cat[".$data_father_cat['id']."]\" value=\"1\" ".$selected2.">
									".$data_father_cat['cat_name']."
									</li>";
									
									$cat_list .= "<ul id=\"treeF_CAT".$data_father_cat['id']."\" htmldb:listlevel=\"3\" style=\"padding-right:15px;list-style:none;display:none;\" class=\"dhtmlTree\">";
									while( $data_father_tat_cat = mysql_fetch_array($res_father_tat_cat) )
									{
										$sql = "select cat_id from usersMessageSinon_x_cat where sinon_id = '".$data['id']."' and cat_id = '".$data_father_tat_cat['id']."'";
										$res_cat_id = mysql_db_query(DB,$sql);
										$data_cat_id = mysql_fetch_array($res_cat_id);
										
										if( $data_cat_id['cat_id'] == $data_father_tat_cat['id'] )	{
											$selected3 = "checked";
											$checked_cats[] = "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;".$data_father_tat_cat['cat_name'];
										}	else	{
											$selected3 = "";
										}
										
										$cat_list .= "<li><img src=\"options.fiels/node.jpg\" /><input type=\"checkbox\" name=\"select_cat[".$data_father_tat_cat['id']."]\" value=\"1\" ".$selected3.">".$data_father_tat_cat['cat_name']."</li>";
									}
									$cat_list .= "</ul>";
								}
								else
								{
									$cat_list .= "<li><img src=\"options.fiels/node.jpg\" />
									<input type=\"checkbox\" name=\"select_cat[".$data_father_cat['id']."]\" value=\"1\" ".$selected2.">".$data_father_cat['cat_name']."</li>";
								}
							}
						$cat_list .= "</ul>";
					}
				$cat_list .= "</ul>";
			$cat_list .= "</td>";
		$cat_list .= "</tr>";
	$cat_list .= "</table>";
	
	
	$form_arr = array(
		array("hidden","main","edit_messagesSinon_DB"),
		array("hidden","record_id",$data['id']),
		array("hidden","sesid",SESID),
		
		
		
		array("text","data_arr[subject]",$data['subject'],"* כותרת", "class='input_style'","","1"),
		array("textarea","data_arr[content]",$data['content'],"* תוכן ההודעה", "class='input_style' style='height: 200px;'","","1"),
		
		array("text","data_arr[name_link_togo]",$data['name_link_togo'],"שם הקישור לפרטים נוספים", "class='input_style'","","1"),
		array("text","data_arr[href_link_togo]",$data['href_link_togo'],"כתובת אינטרנט מלאה של לפרטים נוספים", "class='input_style'","","1"),
		
		array("blank",$city_combo),
		
		array("date","send_birthday_start",$data['send_birthday_start'],"תאריך לידה מתאריך <font style=\"font-size:9px;\" class=\"maintext_small\">dd-mm-yyyy</font>", "class='input_style'"),
		array("date","send_birthday_end",$data['send_birthday_end'],"תאריך לידה עד לתאריך <font style=\"font-size:9px;\" class=\"maintext_small\">dd-mm-yyyy</font>", "class='input_style'"),
		array("select","gender[]",$gender,"מין",$data['send_gender'],"data_arr[send_gender]", "class='input_style''"),
		
		array("select","status[]",$status,"פעיל",$data['status'],"data_arr[status]", "class='input_style''"),
		array("select","client_10service[]",$client_10service,"שלח ללקוחות שירות 10",$data['client_10service'],"data_arr[client_10service]", "class='input_style''"),
		
		array("blank",$cat_list),
		
		array("submit","submit","שמירה", "class='submit_style'")
	);
	
// שדות חובה
$mandatory_fields = array("data_arr[subject]","data_arr[content]");
$more = "class='maintext'";

echo "<table border=\"0\" cellspacing=\"0\" cellpadding=\"0\" class=\"maintext\">";
		
		echo "<tr>";
			echo "<td><A href=\"?&sesid=".SESID."\" class=\"maintext\">חזרה לתפריט הראשי</a></td>";
		echo "</tr>";
		echo "<tr><td height=\"7\"></td></tr>";
		echo "<tr>";
			echo "<td><A href=\"?main=messagesSinon&sesid=".SESID."\" class=\"maintext\">לרשימת ההודעות</a></td>";
		echo "</tr>";
		
		echo "<tr><td height=\"11\"></td></tr>";
		
		echo "<tr>";
			echo "<td>".FormCreator::create_form($form_arr,"index.php", $more, $mandatory_fields)."</td>";
		echo "</tr>";
		
		
	echo "</table>";
}

function edit_messagesSinon_DB()
{

	$image_settings = array(
		after_success_goto=>"DO_NOTHING",
		table_name=>"usersMessageSinon",
		flip_date_to_original_format=>array("send_birthday_start" , "send_birthday_end"),
	);
	  
	$data_arr = ($_POST['data_arr'])? $_POST['data_arr'] : $_GET['data_arr'];
	if( $_POST['record_id'] == "" )
	{
		insert_to_db($data_arr, $image_settings);
		
		$sql = "update usersMessageSinon set date_sent = NOW() where id = '".$GLOBALS['mysql_insert_id']."' limit 1";
		$res = mysql_db_query(DB,$sql);
		$sinon_id = $GLOBALS['mysql_insert_id'];
	}
	else	{
		update_db($data_arr, $image_settings);
		$sinon_id = $_POST['record_id'];
	}
	
	
	$sql = "delete from usersMessageSinon_x_cat where sinon_id = '".(int)$sinon_id."'";
	$res_del = mysql_db_query(DB,$sql);
	
	foreach( $_POST['select_cat'] as $val => $key )
	{
		if( $key == "1" )
		{
			$sql = "insert into usersMessageSinon_x_cat ( sinon_id , cat_id ) values ( '".$sinon_id."' , '".$val."' )";
			$res_insert = mysql_db_query(DB,$sql);
		}
	}
	
	echo "<META HTTP-EQUIV=Refresh CONTENT=\"0; URL=?main=messagesSinon&sesid=".SESID."\">";
}

function del_messagesSinon()	{

	$sql = "update usersMessageSinon set deleted = '1' where id = '".$_GET['record_id']."' limit 1";
	$res = mysql_db_query(DB,$sql);
	
	echo "<script>window.location.href='?main=messagesSinon&sesid=".SESID."'</script>";
		exit;
}

function messagesSinon_send_mail()
{
	if( $_GET['record_id'] == "" )
	{
		die("לא התקבל מספר הודעה");
	}
	$sql = "select * from usersMessageSinon where deleted = '0' and id = '".$_GET['record_id']."' AND status=0";
	$res = mysql_db_query(DB,$sql);
	$data = mysql_fetch_array($res);
	
	if( $data['status'] != "0" )
	{
		die("הודעה לא פעילה");
	}
	
	$sin_city = ( $data['send_city'] != "0" ) ? " AND u.city = '".$data['send_city']."' " : "";
	$sin_gender = ( $data['send_gender'] != "0" ) ? " AND u.gender = '".$data['send_gender']."' " : "";
	$sin_birthday = ( $data['send_birthday_start'] != "0000-00-00" ) ? " AND u.birthday <= '".$data['send_birthday_start']."' " : "";
	$sin_birthday .= ( $data['send_birthday_end'] != "0000-00-00" ) ? " AND u.birthday >= '".$data['send_birthday_end']."' " : "";
	
	switch( $data['client_10service'] )
	{
		case "1" :		$client_10service = " AND uxs.unk = u.unk AND uxs.belongTo10service = '1' ";	$more_Table = "user_extra_settings as uxs , ";	break;
		case "2" :		$client_10service = " AND uxs.unk = u.unk AND uxs.belongTo10service = '0' "; 	$more_Table = "user_extra_settings as uxs , ";	break;
		case "3" :					
			$client_10service = " AND u.unk IN(SELECT unk FROM user_e_card_settings WHERE active = '1') ";
		break;
		
		default:  $client_10service = ""; $more_Table = "";
	}
	
	$temp_date = getDate();
	$year = $temp_date['year'];
	$mon = $temp_date['mon'];
	$day = $temp_date['mday'];
	
	$temp_date = $year."-".$mon."-".$day;
	
	
	$sql_checkCat = "SELECT cat_id FROM usersMessageSinon_x_cat WHERE sinon_id = '".$data['id']."' LIMIT 1";
	$res_checkCat = mysql_db_query(DB,$sql_checkCat);
	$data_checkCat = mysql_fetch_array($res_checkCat);
	$date_where = " and u.end_date >= '".$temp_date."' and u.status = '0' ";
	if( $data['client_10service'] == '3'){
		$date_where = "";
	}	
	if( $data_checkCat['cat_id'] == "" )
		$sql2 = "select u.id,u.email,u.name,u.unk from ".$more_Table." users as u where u.email != '' and u.active_send_email = 0 ".$date_where." and u.deleted = '0'".$sin_city.$sin_gender.$sin_birthday.$client_10service;
	else	{
		$sql2 = "select u.id,u.email,u.name,u.unk from ".$more_Table." users as u INNER JOIN user_cat AS uc ON uc.user_id = u.id 
							INNER JOIN usersMessageSinon_x_cat AS c ON uc.cat_id = c.cat_id AND c.sinon_id = '".$data['id']."' 
							where u.email != '' and u.active_send_email = 0 ".$date_where." and u.deleted = '0'".$sin_city.$sin_gender.$sin_birthday.$client_10service." group by u.id";
	}
	
	$res2 = mysql_db_query(DB,$sql2);
	
	
	
	$fromEmail = "info@ilbiz.co.il"; 
	$fromTitle = "רשת אתרי IL-BIZ"; 
	
	
	$header_send_to_Client= stripslashes($data['subject']);
	
	
	$counter=0;
	$sent_emails_arr = array();
	$sent_names_arr = array();
	while( $data2 = mysql_fetch_array($res2) )
	{
		if( GlobalFunctions::validate_email_address($data2['email']) )
		{
			$content_send_to_Client = "
					<html dir=rtl>
					<head>
							<title>".stripslashes($data['subject'])."</title>
							<style>
								.textt{font-family: arial; font-size:12px; color: #000000}
								.text_link{font-family: arial; font-size:12px; color: navy}
							</style>
					</head>
					
					<body>
						<p class='textt' dir=rtl align=right>
שלום,<br><br>".nl2br(stripslashes($data['content']))."<br><br>";

if( $data['href_link_togo'] != "" && $data['name_link_togo'] != "" )
{
	if( eregi("http://",$data['href_link_togo']) || eregi("https://",$data['href_link_togo']) )
		$goto = $data['href_link_togo'];
	else
		$goto = "http://".$data['href_link_togo'];
	
	$content_send_to_Client .= "<br><br>
		<a href='".$goto."' class='text_link' target='_blank'><u>".stripslashes($data['name_link_togo'])."</u></a><br><br>";
}
$encrypted = base64_encode($data2['unk']);

$content_send_to_Client .= "
לניהול התוכן בחר את אחת ממערכות הניהול הרלוונטיות עבורך : 
<br/><br/>
<a href='https://ilbiz.co.il/myleads/' style='font-family:arial; font-size: 12px; color: #000000;' target='_blank'><u>מערכת ניהול לידים</u></a><br><br>
<a href='https://www.ilbiz.co.il/ClientSite/administration/login.php' style='font-family:arial; font-size: 12px; color: #000000;' target='_blank'><u>מערכת ניהול אתר אינטרנט</u></a><br><br>
<a href='https://ilbiz.co.il/mycard/' style='font-family:arial; font-size: 12px; color: #000000;' target='_blank'><u>מערכת ניהול כרטיס דיגיטלי 10card</u></a><br><br>
<br><br>
בברכה,<br>
IL-BIZ קידום עסקים באינטרנט<br><br>
<a href='http://www.ilbiz.co.il/ClientSite/administration/remove_ilbiz_user_mailinglist.php?u=".$encrypted."' style='font-family:arial; font-size: 11px; color: #000000;' target='_blank'>הסרה מרשימת תפוצה</a>
						</p>
					</body>
					</html>";
					
			$ClientMail = $data2['email'];
			GlobalFunctions::send_emails_with_phpmailer($fromEmail, $fromTitle, $header_send_to_Client, $content_send_to_Client, $content_send_to_Client, $ClientMail, $data2['name'] );
			$sent_emails_arr[] = $ClientMail;
			$sent_names_arr[] = $data2['name'];
			$counter++;
		}
	}
	$sent_emails_list = str_replace("'","",implode(",",$sent_emails_arr));
	$sent_names_list = str_replace("'","",implode(",",$sent_names_arr));
	$sql = "update usersMessageSinon set sent_mails = '1' where id = '".$_GET['record_id']."' limit 1";
	$res = mysql_db_query(DB,$sql);
	//try to put the full list of emails. sometimes not work bcoz of for,ating issues
	$sql = "update usersMessageSinon set sent_mails = '1',sent_mails_total = ".$counter.", sent_emails_list='".$sent_emails_list."',sent_names_list='".$sent_names_list."' where id = '".$_GET['record_id']."' limit 1";
	$res = mysql_db_query(DB,$sql);
		
	echo "<p align=center>סך הכל נשלחו ".$counter." מיילים. <a href='javascript:window.close();'>סגור עמוד</a></p>";
}


function delete_site_domain()
{
	
	$form_arr = array(
		array("hidden","main","delete_site_domain_DB"),
		array("hidden","record_id",$data['id']),
		array("hidden","sesid",SESID),
		
		array("text","domain",$data['subject'],"דומיין:", "class='input_style'"),
		
		array("submit","submit","שמירה", "class='submit_style'")
	);
	
// שדות חובה
$mandatory_fields = array("domain","");
$more = "class='maintext'";

echo "<table border=\"0\" cellspacing=\"0\" cellpadding=\"0\" class=\"maintext\">";
		
		echo "<tr>";
			echo "<td><A href=\"?&sesid=".SESID."\" class=\"maintext\">חזרה לתפריט הראשי</a></td>";
		echo "</tr>";
		echo "<tr><td height=\"7\"></td></tr>";
		echo "<tr>";
			echo "<td>
שים לב, פעולה הזאת תמחק אתר לצמיתות ללא אפשרות לשחזור .<br>
<ol>
<li>יש למחוק את <b>הדומיין</b> דרך מערכת direct Admin</li>
<li>יש להכניס את הדומיין כאן - הפעולה תימשך כמה דקות ותמחק לצמיתות את כל הנתונים של האתר .</li>
</ol>
			</td>";
		echo "</tr>";
		
		echo "<tr><td height=\"11\"></td></tr>";
		
		echo "<tr>";
			echo "<td>".FormCreator::create_form($form_arr,"index.php", $more, $mandatory_fields)."</td>";
		echo "</tr>";
		
		
	echo "</table>";
	
}

function delete_site_domain_DB()
{
	$path = "/home/ilan123/domains/";
	$domain = $_POST['domain'];
	
	if( is_dir($path.$domain) )
	{
		echo "<script>alert('יש תחילה למחוק את הדומיין דרך מערכת direct admin');</script>";
		echo "<META HTTP-EQUIV=Refresh CONTENT=\"0; URL=?main=delete_site_domain&sesid=".SESID."\">";
			die();
	}
	else
	{
		$sql = "SELECT unk FROM users WHERE domain = '".$domain."' and deleted=0 LIMIT 1";
		$res = mysql_db_query(DB,$sql);
		$data = mysql_fetch_array($res);
		
		if( $data['unk'] != "" )
		{
			$sql = "UPDATE users SET deleted=1 WHERE domain = '".$domain."' AND unk = '".$data['unk']."'";
			$res = mysql_db_query(DB,$sql);
			
			echo "<script>alert('האתר נמחק לצמיתות !');</script>";
			echo "<META HTTP-EQUIV=Refresh CONTENT=\"0; URL=?main=delete_site_domain&sesid=".SESID."\">";
				die();
		}
		else
		{
			echo "<script>alert('האתר הינו קיים - הוא מחוק');</script>";
			echo "<META HTTP-EQUIV=Refresh CONTENT=\"0; URL=?main=delete_site_domain&sesid=".SESID."\">";
				die();
		}
	}
}


function search_value_at_site()
{
	global $word;
	
	echo "<form action=\"index.php\" method=\"get\" name=\"search_form\" style='padding:0; margin:0;'>";
	echo "<input type=\"hidden\" name=\"main\" value=\"search_value_at_site_prosses\">";
	echo "<input type=\"hidden\" name=\"sesid\" value=\"".SESID."\">";
	echo "<table border=\"0\" cellspacing=\"0\" cellpadding=\"0\" class=\"rightMemu\" align=center>";
		echo "<tr>";
			echo "<td colspan=\"5\"><h3>חיפוש ערך בכל האתרים</h3></td>";
		echo "</tr>";
		echo "<tr>";
			echo "<td colspan=\"5\"><A href=\"?&sesid=".SESID."\" class=\"maintext\">חזרה לתפריט הראשי</a></td>";
		echo "</tr>";
		echo "<tr><td colspan=\"5\" height=\"15\"></td></tr>";
		echo "<tr>";
			echo "<td width=\"5\"></td>";
			echo "<td><input type=\"text\" name=\"search_val\" class=\"input_style\" style=\"width:200px;\"></td>";
			echo "<td width=\"2\"></td>";
			echo "<td><input type=\"submit\" value=\"חפש!\" class=\"submit_style\" style=\"width:43px;\"></td>";
			echo "<td width=\"5\"></td>";
		echo "</tr>";
	echo "</table>";
	echo "</form>";
}

function search_value_at_site_prosses()
{
	
	echo "<h1>חיפוש בכל האתרים</h1>";
	echo "<A href=\"?&sesid=".SESID."\" class=\"maintext\">חזרה לתפריט הראשי</a><br>";
	echo "<A href=\"?main=search_value_at_site&sesid=".SESID."\" class=\"maintext\">חזרה לחיפוש</a><br><br>";
	$temp_word_content_pages = "דפים חופשיים";
	$temp_word_articels = "דפי מאמרים";
	$temp_word_sales = "דפי מבצעים";
	$temp_word_products = "דפי מוצרים";
	$temp_word_yad2 = "דפי יד2";
	$temp_word_video = "דפי וידיאו";

	$temp_word_wanted = "דפי דרושים";
	
	
	$arr_search = array(
		content_pages => array("content"),
		user_articels => array("content","summary","headline","status"),
		
		user_sales => array("content","name","summary","status","end_date"),
		user_products => array("content","name","summary","active"),
		user_video => array("content","name","summary","active"),
		user_yad2 => array("content","name","summary","active"),
		
		user_wanted => array("content","name"),
	);
	
	$count_search = 0;
	foreach( $arr_search as $val => $key )
	{
		$val2 = $val;
		$key2 = $key;
		
			$sql = "select * from {$val} where deleted = '0' and ( ";
				$counter = 0;
				foreach ( $key as $kkey )
				{
					$or_parametr = ( $counter == 0 ) ? "" : "or";
					switch($kkey)
					{
						case "summary" :
						case "name" :
						case "content" : $sql .= "{$or_parametr} {$kkey} like '%".$_GET['search_val']."%' ";	break;
						
						case "status" :
						case "active" : $sql .= ") and ( {$kkey} = '0' ";	break;
						
						case "end_date" : $sql .= "and {$kkey} > '".GlobalFunctions::get_date()."' ";	break;
					}
					$counter++;
				}
			$sql .= ")";
		
		$res = mysql_db_query(DB,$sql);
		$num_rows = mysql_num_rows($res);
		
		if( $num_rows > 0)
		{
			
			if( $val2 == "content_pages" )
				$val2 = "user_content_pages";
			$temp_headline_exp = explode("user_", $val2);
			$temp_headline = "temp_word_".$temp_headline_exp[1];
			
			if( $$temp_headline != "" )
			{
				$counter = 0 ;
				while( $data = mysql_fetch_array($res))
				{
					$sql_domain = "SELECT domain FROM users WHERE unk = '".$data['unk']."'";
					$res_domain = mysql_db_query(DB,$sql_domain);
					$data_domain = mysql_fetch_array($res_domain);
					
					if( $counter == 0 )
						echo "<h3>{$$temp_headline}</h3>";
					
					switch($val2)
					{
						case "user_content_pages" :
							if( $data['type'] == "text" )
								$data['name'] = "דף אודות";
							echo "<font style='font-size: 11px;'>".$data_domain['domain']."</font><br>";
							echo "<a href='http://".$data_domain['domain']."/index.php?m=text&t=".$data['type']."' class='maintext'><b><u>".nl2br(htmlspecialchars(stripslashes($data['name'])))."</u></b></a>";
							echo "<br><br>";
							$count_search++;
						break;
						
						case "user_articels" :
							echo "<font style='font-size: 11px;'>".$data_domain['domain']."</font><br>";
							echo "<a href='http://".$data_domain['domain']."/index.php?m=ar&artd=".$data['id']."' class='maintext'><b><u>".nl2br(htmlspecialchars(stripslashes($data['headline'])))."</u></b></a><br>";
							echo nl2br(htmlspecialchars(stripslashes($data['summary'])))."<br><br>";
							$count_search++;
						break;
						
						case "user_sales" :
						case "user_products" :
						case "user_video" :
						case "user_yad2" :
							echo "<font style='font-size: 11px;'>".$data_domain['domain']."</font><br>";
							echo "<a href='http://".$data_domain['domain']."/index.php?m=s_".$temp_headline_exp[1]."&ud=".$data['id']."' class='maintext'><b><u>".nl2br(htmlspecialchars(stripslashes($data['name'])))."</u></b></a><br>";
							echo nl2br(htmlspecialchars(stripslashes($data['summary'])))."<br><br>";
							$count_search++;
						break;
						
						case "user_wanted" :
							echo "<font style='font-size: 11px;'>".$data_domain['domain']."</font><br>";
							echo "<a href='http://".$data_domain['domain']."/index.php?m=jo' class='maintext'><b><u>".nl2br(htmlspecialchars(stripslashes($data['name'])))."</u></b></a><br>";
							echo stripslashes($data['content'])."<br><br>";
							$count_search++;
						break;
					}	//switch
					$counter++;
				} //	while
				
				echo "<hr width='100%' size='1' color='#000000'>";
			}	// if
		}	// if
	}	//	foreach
	
	if( $count_search == 0 )
	{
		echo "<p>לא מצאו תוצאות עבור: <b>".$_GET['search_val']."</b></p>";
	}
}