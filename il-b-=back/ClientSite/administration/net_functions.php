<?php


/**************************************************************************************************/

function net_list()
{
	
	$limitCount = ( $_GET['limit'] == "" ) ? "0" : $_GET['limit'];
	
	$ex = explode( "-" , $_GET['sd'] );
	$where = ($_GET['sd'] != "" ) ? " AND ub.join_date >= '".$ex[2]."-".$ex[1]."-".$ex[0]."' " : "";
	$ex2 = explode( "-" , $_GET['ed'] );
	$where .= ($_GET['ed'] != "" ) ? " AND ub.join_date <= '".$ex2[2]."-".$ex2[1]."-".$ex2[0]."' " : "";
	
	$where .= ($_GET['val'] != "" ) ? " AND ( ( u.fname LIKE '%".mysql_r_e_s($_GET['val'])."%' ) OR ( u.lname LIKE '%".mysql_r_e_s($_GET['val'])."%' ) )" : "";
	
	
	$sql = "SELECT CONCAT(u.fname, ' ' , u.lname) as full_name, u.date_in, u.birthday, u.verify, u.city, u.id, ub.status, ub.sendMailActive as 'aproved_mail_send', ub.join_date FROM net_users as u , net_users_belong as ub WHERE
		u.deleted=0 AND
		ub.net_user_id = u.id AND
		ub.unk = '".UNK."' ".$where." ORDER BY ub.join_date DESC LIMIT ".$limitCount.",50";
	$res = mysql_db_query( DB, $sql );
	
	$sql = "SELECT u.id FROM net_users as u , net_users_belong as ub WHERE
		u.deleted=0 AND
		ub.net_user_id = u.id AND
		ub.unk = '".UNK."' ".$where." ";
	$resAll = mysql_db_query( DB, $sql );
	$num_rows = mysql_num_rows($resAll);
	
	echo "<table border='0' cellspacing='0' cellpadding='0' class='maintext'>";
		
		echo "<tr>";
			echo "<td colspan=15>";
				echo "<form action='index.php' name='conatct_search' method='get' style=''padding:0; margin:0;>";
					echo "<input type='hidden' name='main' value='net_list'>";
					echo "<input type='hidden' name='type' value='net'>";
					echo "<input type='hidden' name='unk' value='".UNK."'>";
					echo "<input type='hidden' name='sesid' value='".SESID."'>";
					echo "<table border=\"0\" cellspacing=\"0\" cellpadding=\"0\" class=\"maintext\">";
						echo "<tr>";
							echo "<td>מתאריך (כולל):</td>";
							echo "<td width='10'></td>";
							echo "<td><input type=text name='sd' value='".$_GET['sd']."' class='input_style' style='width: 80px;'> mm-dd-yyy</td>";
							echo "<td width='30'></td>";
							echo "<td>עד לתאריך (לא כולל):</td>";
							echo "<td width='10'></td>";
							echo "<td><input type=text name='ed' value='".$_GET['ed']."' class='input_style' style='width: 80px;'> mm-dd-yyy</td>";
						echo "</tr>";
						echo "<tr><td colspan=7 height=5></td></tr>";
						echo "<tr>";
							echo "<td>שם פרטי או משפחה:</td>";
							echo "<td width='10'></td>";
							echo "<td><input type=text name='val' value='".$_GET['val']."' class='input_style' style='width: 80px;'></td>";
							echo "<td width='30'></td>";
							echo "<td></td>";
							echo "<td width='10'></td>";
							echo "<td><input type='submit' class='submit_style' value='חפש!' style='width: 80px;'></td>";
						echo "</tr>";
						echo "<tr>";
							echo "<td align=left colspan=7><a href='getExcelNetUsers.php?unk=".$_GET['unk']."&sesid=".$_GET['sesid']."&sd=".$_GET['sd']."&ed=".$_GET['ed']."&val=".$_GET['val']."' target='_blank'><img src='images/Excel_32.png' border=0 alt='יצוא לאקסל' /></td>";
						echo "</tr>";
					echo "</table>";
					echo "</form>";
			echo "</td>";
		echo "</tr>";
		
		
		echo "<tr>";
			echo "<td><b>תאריך הצטרפות</b></td>";
			echo "<td width=15></td>";
			echo "<td><b>שם מלא</b></td>";
			echo "<td width=15></td>";
			echo "<td><b>תאריך לידה</b></td>";
			echo "<td width=15></td>";
			echo "<td><b>עיר</b></td>";
			echo "<td width=15></td>";
			echo "<td><b>אישור אימייל</b></td>";
			echo "<td width=15></td>";
			echo "<td><b>אישור כניסה למועדון</b></td>";
			echo "<td width=15></td>";
			echo "<td><b>אישור שליחת מיילים</b></td>";
			echo "<td width=15></td>";			
			echo "<td><b>צפיה פרטים</b></td>";
		echo "</tr>";
		
		while( $data = mysql_fetch_array($res) )
		{
			$sql2 = "SELECT name FROM cities WHERE id = '".$data['city']."' ";
			$res2 = mysql_db_query( DB, $sql2 );
			$data2 = mysql_fetch_array($res2);
			
			echo "<tr><td colspan=15 height=3></td></tr>";
			echo "<tr><td colspan=15><hr width=100% size=1 color=#000000></td></tr>";
			echo "<tr><td colspan=15 height=3></td></tr>";
			
			$mail_verify = ( $data['verify'] == "1" ) ? "<font color='green'>אישר מייל</font>" : "<font color='red'>לא אישר מייל</font>";
			$status_color = ( $data['status'] == "0" ) ? "<font color='green'>מאושר</font>" : "<font color='red'>לא מאושר</font>";
			$send_emails = ( $data['aproved_mail_send'] == "0" ) ? "<font color='green'>מאושר</font>" : "<font color='red'>לא מאושר</font>";
						
			$birthdayTemp = GlobalFunctions::date_fliper(stripslashes($data['birthday']));
			$birthday = ( $birthdayTemp == "00-00-0000" ) ? "" : $birthdayTemp;
			
			if( eregi( "0000-00-00" , $data['join_date'] ) )
				$join = $data['date_in'];
			else
				$join = $data['join_date'];
			
			echo "<tr>";
				echo "<td>".GlobalFunctions::show_dateTime_field(stripslashes($join))."</td>";
				echo "<td width=15></td>";
				echo "<td>".stripslashes($data['full_name'])."</td>";
				echo "<td width=15></td>";
				echo "<td>".$birthday."</td>";
				echo "<td width=15></td>";
				echo "<td>".stripslashes($data2['name'])."</td>";
				echo "<td width=15></td>";
				echo "<td>".$mail_verify."</td>";
				echo "<td width=15></td>";
				echo "<td>".$status_color."</td>";
				echo "<td width=15></td>";
				echo "<td>".$send_emails."</td>";
				echo "<td width=15></td>";				
				echo "<td><a href='index.php?main=net_user_details&type=net&user_id=".$data['id']."&sesid=".SESID."&unk=".UNK."' class='maintext'>צפיה פרטים</a></td>";
			echo "</tr>";
			
		}
		
		echo "<tr><td colspan=15 height=15></td></tr>";
		echo "<tr>";
			echo "<td colspan=15 align=center>סך הכל חברים: ".$num_rows."</td>";
		echo "</tr>";
		echo "<tr><td colspan=15 height=15></td></tr>";
		echo "<tr>";
			echo "<td colspan=15 align=center style=\"border-top: 1px solid #".$data_colors['border_color'].";\">";	
				$params['limitInPage'] = "50";
				$params['numRows'] = $num_rows;
				$params['limitcount'] = $limitCount;
				$params['main'] = $_GET['main'];
				$params['type'] = $_GET['type'];
				
				getLimitPagentionAdmin( $params );
				
			echo "</td>";
		echo "</tr>";
	echo "</table>";
	
	
	
	
}
/**************************************************************************************************/

function net_user_details()
{
	$sql = "SELECT CONCAT(u.fname, ' ' , u.lname) as full_name, u.*, ub.status FROM net_users as u , net_users_belong as ub WHERE
		u.deleted=0 AND
		u.id = ".$_GET['user_id']." AND
		ub.net_user_id = u.id AND
		ub.unk = '".UNK."' ORDER BY id desc
		";
	$res = mysql_db_query( DB, $sql );
	$data = mysql_fetch_array($res);
	
	$birthdayTemp = GlobalFunctions::date_fliper(stripslashes($data['birthday']));
	$birthday = ( $birthdayTemp == "00-00-0000" ) ? "-" : $birthdayTemp;
	
	$sql2 = "SELECT name FROM cities WHERE id = '".$data['city']."' ";
	$res2 = mysql_db_query( DB, $sql2 );
	$data2 = mysql_fetch_array($res2);
	
	$city = ( $data2['name'] == "" ) ? "-" : $data2['name'];
	
	$sql = "SELECT fieldName, inputType, id, adminField FROM dynamic_client_form WHERE unk = '".UNK."' AND active=0 ORDER BY place";
	$res_fields =	mysql_db_query(DB, $sql);
	
	switch( $data['gender'] )
	{
		case "0" :			$gender = "-";		break;
		case "1" :			$gender = "זכר";		break;
		case "2" :			$gender = "נקבה";		break;
	}
	
	$mail_verify = ( $data['verify'] == "1" ) ? "<font color='green'>אישר מייל</font>" : "<font color='red'>לא אישר מייל</font>";

	$selected_status_0 = ( $data['status'] == "0" ) ? "selected" : "";
	$selected_status_1 = ( $data['status'] == "1" ) ? "selected" : "";
	
	echo "<table border='0' cellspacing='0' cellpadding='0' class='maintext'>";
		echo "<tr>";
			echo "<td>תאריך הרשמה: </td>";
			echo "<td width='10'></td>";
			echo "<td><b>".GlobalFunctions::show_dateTime_field(stripslashes($data['date_in']))."</b></td>";
		echo "</tr>";
		echo "<tr><td colspan=3 height=7></td></tr>";
		echo "<tr>";
			echo "<td colspan=3><b>".$mail_verify."</b></td>";
		echo "</tr>";
		echo "<tr><td colspan=3 height=10></td></tr>";
		
		echo "<tr>";
			echo "<td>שם מלא: </td>";
			echo "<td width='10'></td>";
			echo "<td><b>".htmlspecialchars(stripslashes($data['full_name']))."</b></td>";
		echo "</tr>";
		echo "<tr><td colspan=3 height=7></td></tr>";
		echo "<tr>";
			echo "<td>תאריך לידה: </td>";
			echo "<td width='10'></td>";
			echo "<td><b>".$birthday."</b></td>";
		echo "</tr>";
		echo "<tr><td colspan=3 height=7></td></tr>";
		echo "<tr>";
			echo "<td>עיר: </td>";
			echo "<td width='10'></td>";
			echo "<td><b>".$city."</b></td>";
		echo "</tr>";
		echo "<tr><td colspan=3 height=7></td></tr>";
		echo "<tr>";
			echo "<td>מין: </td>";
			echo "<td width='10'></td>";
			echo "<td><b>".$gender."</b></td>";
		echo "</tr>";
		echo "<tr><td colspan=3 height=7></td></tr>";
		echo "<tr>";
			echo "<td>אימייל: </td>";
			echo "<td width='10'></td>";
			echo "<td><b>".htmlspecialchars(stripslashes($data['email']))."</b></td>";
		echo "</tr>";
		echo "<tr><td colspan=3 height=7></td></tr>";
		echo "<tr>";
			echo "<td>טלפון: </td>";
			echo "<td width='10'></td>";
			echo "<td><b>".htmlspecialchars(stripslashes($data['mobile']))."</b></td>";
		echo "</tr>";
		echo "<tr><td colspan=3 height=10></td></tr>";
		
		echo "<form action='index.php' name='form_change_active' method='POST'>";
		echo "<input type='hidden' name='main' value='net_change_user_status'>";
		echo "<input type='hidden' name='type' value='net'>";
		echo "<input type='hidden' name='ui' value='".$_GET['user_id']."'>";
		echo "<input type='hidden' name='unk' value='".UNK."'>";
		echo "<input type='hidden' name='sesid' value='".SESID."'>";
		
		while( $data_fields = mysql_fetch_array($res_fields) )
		{
			switch( $data_fields['inputType'] )
			{
				case "1" :
				case "2" :
				case "4" :
					switch( $data_fields['inputType'] )
					{
						case "1" :	$selected_value = "valueText";		break;
						case "2" :	$selected_value = "valueSelect";		break;
						case "4" :	$selected_value = "valueRadio";		break;
					}
					$sql = "SELECT ".$selected_value." FROM dynamic_client_form_users_values WHERE unk = '".UNK."' AND dynamicFormId = '".$data_fields['id']."' AND netUserId = '".$_GET['user_id']."' ";
					
				break;
				
				case "5" :
					$selected_value = "userValueText";
					$sql = "SELECT userValueText FROM dynamic_client_form_values_text WHERE unk = '".UNK."' AND dynamicId = '".$data_fields['id']."' AND netUserId = '".$_GET['user_id']."' ";
				break;
			}
			
			$res = mysql_db_query(DB,$sql);
			$data_field_value = mysql_fetch_array($res);
			
			
				$params = array();
				$params['inputType'] = $data_fields['inputType'];
				$params['class'] = "input_style";
				$params['name'] = "field_".$data_fields['id'];
		
				$params['unk'] = UNK;
				$params['dynamicId'] = $data_fields['id'];
		
				$params['maxlenght'] = $data_fields['maxlenght'];
				$params['style'] = "";
				$params['style_textarea'] = "height: 100px;";
				$params['value'] = stripslashes($data_field_value[$selected_value]);
				
				if( $data_fields['adminField'] != "1" )
					$params['readonly'] = 1;
				else
					$can_updated = "<br><span style='font-size:10px;'>שדה מנהל בלבד</span>";
				
				echo "<tr>";
					echo "<td valign=top>".stripslashes($data_fields['fieldName']).": ".$can_updated."</td>";
					echo "<td width=10></td>";
					echo "<td valign=top>".ilbizNet::siteInputType($params)."</td>";
				echo "</tr>";
				echo "<tr><td height=\"7\" colspan=3></td></tr>";
			
		}
		
		
		echo "<tr>";
			echo "<td>אישור כניסה למועדון: </td>";
			echo "<td width='10'></td>";
			echo "<td>
				<table border='0' cellspacing='0' cellpadding='0' class='maintext'>
					<tr>
						<td>
							<select name=new_status class='input_style' style='width: 75px;'>
								<option value='0' style='background-color: green; color: #ffffff;' ".$selected_status_0.">מאושר</option>
								<option value='1' style='background-color: red; color: #ffffff;' ".$selected_status_1.">לא מאושר</option>
							</select>
						</td>
						<td width=10></td>
						<td><input type='submit' value='שמירה' class='input_style' style='width: 50px;'></td>
					</tr>
				</table>
			</td>";
		echo "</tr>";
		echo "</form>";
		echo "<tr><td colspan=3 height=10></td></tr>";
		
	echo "</table>";
}


function net_change_user_status()
{
	
	$sql = "UPDATE net_users_belong SET status = '".$_POST['new_status']."' WHERE net_user_id = '".$_POST['ui']."' AND unk = '".UNK."' ";
	$res = mysql_db_query( DB, $sql );
	
	$params['unk'] = UNK;
	$params['adminField'] = '2';
	$params['getValues'] = $_POST;
	$params['user_id'] = $_POST['ui'];
	ilbizNet::InsertUpdate( $params );
	
	
	if( $res ) 
		echo "<script>alert('עדכון בוצע בהצלחה');</script>";
	else
		echo "<script>alert('לא ניתן לעדכן - יש לנסות שוב');</script>";
	
	echo "<script>window.location.href='index.php?main=net_list&type=net&sesid=".SESID."&unk=".UNK."'</script>";
		exit;
}


function net_massg_list()
{
	$sql = "SELECT * FROM net_users_client_messg WHERE unk = '".UNK."' AND deleted=0";
	$res = mysql_db_query( DB , $sql );
	
	echo "<table border='0' cellspacing='0' cellpadding='0' class='maintext'>";
		echo "<tr>";
			echo "<td><b>נושא</b></td>";
			echo "<td width=10></td>";
			echo "<td><b>נשלח ל</b></td>";
			echo "<td width=10></td>";
			echo "<td><b>מספר קוראים</b></td>";
			echo "<td width=10></td>";
			echo "<td><b>עריכה</b></td>";
			echo "<td width=10></td>";
			echo "<td><b>שלח אימייל</b></td>";
		echo "</tr>";
		
		while( $data = mysql_fetch_array($res) )
		{
			$where = ( $data['city'] != "0" ) ? " AND nu.city=".$data['city'] : "";
			$where .= ( $data['gender'] != "0" ) ? " AND nu.gender=".$data['gender'] : "";
			$where .= ( $data['birthday'] != "0000-00-00" ) ? " AND nu.birthday=".$data['birthday'] : "";
			
			$sql_1 = "SELECT COUNT(netUserId) AS nums FROM net_users_client_messg_choosen WHERE msgId='".$data['id']."' ";
			$res1 = mysql_db_query(DB , $sql_1);
			$nums1 = mysql_fetch_array($res1);
			$nums_row1 = $nums1['nums'];
			
			$sql_2 = "SELECT COUNT(net_user_id) AS nums FROM net_users_client_massg_views WHERE 
				massg_id = '".$data['id']."'";
				
			$res2 = mysql_db_query(DB , $sql_2);
			$nums2 = mysql_fetch_array($res2);
			$nums_row2 = $nums2['nums'];
			
			echo "<tr><td colspan='9' height=5></td></tr>";
			echo "<tr><td colspan='9'><hr width='100%' color='#000000' size='1'></td></tr>";
			echo "<tr><td colspan='9' height=5></td></tr>";
			echo "<tr>";
				echo "<td>".stripslashes(htmlspecialchars($data['subject']))."</td>";
				echo "<td width=10></td>";
				echo "<td>".$nums_row1." חברים</td>";
				echo "<td width=10></td>";
				echo "<td>".$nums_row2." חברים</td>";
				echo "<td width=10></td>";
				echo "<td><a href='index.php?main=net_massg_edit&type=net&record_id=".$data['id']."&sesid=".SESID."&unk=".UNK."' class='maintext'>עריכה</a></td>";
				echo "<td width=10></td>";
				echo "<td><a href='index.php?main=net_massg_sendMail&type=net&msg_id=".$data['id']."&sesid=".SESID."&unk=".UNK."' class='maintext'>שלח אימייל</a></td>";
			echo "</tr>";
		}
		
	echo "</table>";
}

function net_massg_edit()
{
	if( $_GET['record_id'] != "" ) 
	{
		$sql = "select * from net_users_client_messg where deleted=0 and id=".$_GET['record_id']." and unk = '".UNK."'";
		$res = mysql_db_query(DB,$sql);
		$data = mysql_fetch_array($res);
		
		$submit_value = "עדכן";
	}
	else
		$submit_value = "שלב הבא";
		

	echo "<table border='0' cellspacing='0' cellpadding='0' class='maintext'>";
		
		echo "<tr>";
			echo "<td><h2 class='maintext' style='font-size:16px;'>שלח/עדכן הודעות ללקוחות המועדון</h2></td>";
		echo "</tr>";
		echo "<tr>";
			echo "<td>";
				echo "<table border='0' cellspacing='0' cellpadding='0' class='maintext'>";
				echo "<form action='index.php' method='post' name='sendSinonForm' onsubmit='return check_mandatory_fields()'>";
				echo "<input type='hidden' name='main' value='net_massg_edit_DB'>";
				echo "<input type='hidden' name='type' value='net'>";
				echo "<input type='hidden' name='record_id' value='".$_GET['record_id']."'>";
				echo "<input type='hidden' name='sesid' value='".SESID."'>";
				echo "<input type='hidden' name='data_arr[unk]' value='".UNK."'>";
				echo "<input type='hidden' name='unk' value='".UNK."'>";
				
					if( $_GET['record_id'] != "" ) 
					{
						echo "<tr>";
							echo "<td>נשלח בתאריך</td>";
							echo "<td width=10></td>";
							echo "<td>".GlobalFunctions::show_dateTime_field($data['in_date'])."</td>";
						echo "</tr>";
					}
					echo "<tr><td colspan=3 height=7></td></tr>";
					echo "<tr>";
						echo "<td>* כותרת</td>";
						echo "<td width=10></td>";
						echo "<td><input type='text' name='data_arr[subject]' value='".stripslashes($data['subject'])."' class='input_style'></td>";
					echo "</tr>";
					echo "<tr><td colspan=3 height=7></td></tr>";
					
					echo "<tr>";
						echo "<td>* תוכן</td>";
						echo "<td width=10></td>";
						echo "<td><textarea name='data_arr[content]' cols='' rows='' class='textarea_style_summary'>".stripslashes($data['content'])."</textarea></td>";
					echo "</tr>";
					echo "<tr><td colspan=3 height=7></td></tr>";
					
					echo "<tr>";
						echo "<td>שם קישור מצורף</td>";
						echo "<td width=10></td>";
						echo "<td><input type='text' name='data_arr[url_name]' value='".stripslashes($data['url_name'])."' class='input_style'></td>";
					echo "</tr>";
					echo "<tr><td colspan=3 height=7></td></tr>";
					echo "<tr>";
						echo "<td>כתובת קישור מצורף</td>";
						echo "<td width=10></td>";
						echo "<td><input type='text' name='data_arr[url_href]' value='".stripslashes($data['url_href'])."' class='input_style'></td>";
					echo "</tr>";
					echo "<tr><td colspan=3 height=7></td></tr>";
					echo "<tr>";
						echo "<td>קישור מוצרף יופיע באימייל?</td>";
						echo "<td width=10></td>";
						echo "<td>";
							$selected0 = ( $data['linkActiveMail'] == 0 ) ? "selected" : "";
							$selected1 = ( $data['linkActiveMail'] == 1 ) ? "selected" : "";
							echo "<select name='data_arr[linkActiveMail]' class='input_style'>";
								echo "<option value=0 ".$selected0.">לא</option>";
								echo "<option value=1 ".$selected1.">כן</option>";
							echo "</select>";
						echo "</td>";
					echo "</tr>";
					echo "<tr><td colspan=3 height=7></td></tr>";
					echo "<tr>";
						echo "<td>פעיל באתר?</td>";
						echo "<td width=10></td>";
						echo "<td>";
							$selected0 = ( $data['status'] == 0 ) ? "selected" : "";
							$selected1 = ( $data['status'] == 1 ) ? "selected" : "";
							echo "<select name='data_arr[status]' class='input_style'>";
								echo "<option value=0 ".$selected0.">כן</option>";
								echo "<option value=1 ".$selected1.">לא</option>";
							echo "</select>";
						echo "</td>";
					echo "</tr>";
					echo "<tr><td colspan=3 height=10></td></tr>";
					
					echo "<tr>";
						echo "<td></td>";
						echo "<td width=10></td>";
						echo "<td align=left><input type='submit' value='".$submit_value."' class='submit_style'></td>";
					echo "</tr>";
					echo "<tr><td colspan=3 height=7></td></tr>";
				echo "</form>";
				echo "</table>";
			echo "</td>";
		echo "</tr>";
	echo "</table>";
	
	$mandatory_fields = array("data_arr[subject]","data_arr[content]");
	
	echo "<script>
				function check_mandatory_fields()
				{
			";
			for($z=0 ; $z<sizeof($mandatory_fields) ; $z++)
			{
				$val = $mandatory_fields[$z];
				//main_form
				echo "
				temp_val = document.getElementById(\"{$val}\");
				if(temp_val.value == \"\")	
				{
					alert(\"אנא מלא את כל שדות החובה\");
					temp_val.focus();   
					return false;\n
				}
					";
			}
			echo "}
			</script>";
}


function net_massg_edit_DB()
{
	$data_arr = $_POST['data_arr'];
	
	$image_settings = array(
					"after_success_goto" => "DO_NOTHING",
					"table_name" => "net_users_client_messg",
	);
	
	
	if( $_POST['record_id'] == "" )	{
		insert_to_db($data_arr, $image_settings);
		
		$new_row = $GLOBALS['mysql_insert_id'];
		
		$sql = "UPDATE net_users_client_messg SET in_date = NOW() WHERE id = '".$new_row."' ";
		$res = mysql_db_query( DB , $sql );
		
		echo "<META HTTP-EQUIV=Refresh CONTENT=\"0; URL=index.php?main=net_massg_edit_step2&msg_id=".$new_row."&type=".$_POST['type']."&unk=".UNK."&sesid=".SESID."\">";
	}
	else	{
		update_db($data_arr, $image_settings);
		
		echo "<script>alert('עודכן בהצלחה');</script>";
		echo "<META HTTP-EQUIV=Refresh CONTENT=\"0; URL=index.php?main=net_massg_list&type=".$_POST['type']."&unk=".UNK."&sesid=".SESID."\">";
	}
	

}


function net_massg_edit_step2()
{
	
	$sql = "select * from net_users_client_messg where deleted=0 and id=".$_GET['msg_id']." and unk = '".UNK."'";
	$res = mysql_db_query(DB,$sql);
	$data = mysql_fetch_array($res);
	
	
	echo "<table border='0' cellspacing='0' cellpadding='0' class='maintext'>";
		
		echo "<tr>";
			echo "<td><h2 class='maintext' style='font-size:16px;'>סינון ל<u>".stripslashes($data['subject'])."</u></h2></td>";
		echo "</tr>";
		echo "<tr>";
			echo "<td>";
				echo "<table border='0' cellspacing='0' cellpadding='0' class='maintext'>";
				echo "<form action='index.php' method='post' name='sendSinonForm'>";
				echo "<input type='hidden' name='main' value='net_massg_edit_DB_step2'>";
				echo "<input type='hidden' name='type' value='net'>";
				echo "<input type='hidden' name='msg_id' value='".$_GET['msg_id']."'>";
				echo "<input type='hidden' name='sesid' value='".SESID."'>";
				echo "<input type='hidden' name='unk' value='".UNK."'>";
				
					echo "<tr><td colspan=3 height=7></td></tr>";
					echo "<tr>";
						echo "<td>כותרת</td>";
						echo "<td width=10></td>";
						echo "<td><b>".stripslashes($data['subject'])."</b></td>";
					echo "</tr>";
					echo "<tr><td colspan=3 height=7></td></tr>";
					
					echo "<tr>";
						echo "<td>תוכן</td>";
						echo "<td width=10></td>";
						echo "<td><b>".nl2br(stripslashes($data['content']))."</b></td>";
					echo "</tr>";
					echo "<tr><td colspan=3 height=7></td></tr>";
					
					echo "<tr>";
						echo "<td>פעיל באתר?</td>";
						echo "<td width=10></td>";
						echo "<td>";
							if( $data['status'] == 0 )
								echo "<span style='color: green;'><b>כן</b></span>";
							else
								echo "<span style='color: red;'><b>לא</b></span>";
						echo "</td>";
					echo "</tr>";
					echo "<tr><td colspan=3 height=5></td></tr>";
					echo "<tr><td colspan=3><hr color='#000000' size=1 width=100%></td></tr>";
					echo "<tr><td colspan=3 height=5></td></tr>";
					
					echo "<tr>";
						echo "<td colspan=3><h2 class='maintext' style='font-size:16px;'>שדות לסינון בסיסי</h2></td>";
					echo "</tr>";
					
					
					echo "<tr>";
						echo "<td>טווח גילאיים</td>";
						echo "<td width=10></td>";
						echo "<td>";
						
							echo "<table border='0' cellspacing='0' cellpadding='0' class='maintext'>";
								echo "<tr>";
									echo "<td>מ-</td>";
									echo "<td width=10></td>";
									echo "<td>";
										echo "<select name='sinonBy_start_age' class='input_style' style='width:100px;'>";
											echo "<option value=''>בחירה</option>";
											for( $i=0 ; $i<=120 ; $i++ )
											{
												echo "<option value='".$i."'>".$i."</option>";
											}
										echo "</select>";
									echo "</td>";
									echo "<td width=30></td>";
									echo "<td>עד-</td>";
									echo "<td width=10></td>";
									echo "<td>";
										echo "<select name='sinonBy_end_age' class='input_style' style='width:100px;'>";
											echo "<option value=''>בחירה</option>";
											for( $i=0 ; $i<=120 ; $i++ )
											{
												echo "<option value='".$i."'>".$i."</option>";
											}
										echo "</select>";
									echo "</td>";
								echo "</tr>";
							echo "</table>";
							
						echo "</td>";
					echo "</tr>";
					echo "<tr><td colspan=3 height=7></td></tr>";
					
					echo "<tr>";
						echo "<td>מין</td>";
						echo "<td width=10></td>";
						echo "<td>";
							echo "<select name='sinonBy_gender' class='input_style'>";
								echo "<option value=''>בחירה</option>";
								echo "<option value='1'>זכר</option>";
								echo "<option value='2'>נקבה</option>";
							echo "</select>";
						echo "</td>";
					echo "</tr>";
					echo "<tr><td colspan=3 height=7></td></tr>";
					
					$sql = "SELECT * FROM cities";
					$res = mysql_db_query(DB,$sql);
					
					echo "<tr>";
						echo "<td>עיר</td>";
						echo "<td width=10></td>";
						echo "<td>";
							echo "<select name='sinonBy_city' class='input_style'>";
								echo "<option value=''>בחירה</option>";
								while( $data_city = mysql_fetch_array($res) )
								{
									echo "<option value='".$data_city['id']."'>".stripslashes($data_city['name'])."</option>";
								}
							echo "</select>";
						echo "</td>";
					echo "</tr>";
					echo "<tr><td colspan=3 height=7></td></tr>";
					
					
					
					$sql = "SELECT fieldName, inputType, id FROM dynamic_client_form WHERE unk = '".UNK."' AND active=0 ORDER BY place";
					$res_fields =	mysql_db_query(DB, $sql);
					
					$count = 0;
					while( $data_fields = mysql_fetch_array($res_fields) )
					{
						if( $count == 0 )
						{
							echo "<tr>";
								echo "<td colspan=3><h2 class='maintext' style='font-size:16px;'>שדות לסינון מתקדם</h2></td>";
							echo "</tr>";
						}
						
						if( $data_fields['inputType'] == "2" || $data_fields['inputType'] == "4" )
						{
							$params = array();
							$params['inputType'] = $data_fields['inputType'];
							$params['class'] = "input_style";
							$params['name'] = "field_".$data_fields['id'];
					
							$params['unk'] = UNK;
							$params['dynamicId'] = $data_fields['id'];
					
							$params['maxlenght'] = $data_fields['maxlenght'];
							$params['style'] = "";
							
							echo "<tr>";
								echo "<td>".stripslashes($data_fields['fieldName']).":</td>";
								echo "<td width=10></td>";
								echo "<td>".ilbizNet::siteInputType($params)."</td>";
							echo "</tr>";
							echo "<tr><td height=\"7\" colspan=3></td></tr>";
						}
						
						$count++;
						
					}
					
					echo "<tr>";
						echo "<td></td>";
						echo "<td width=10></td>";
						echo "<td align=left><input type='submit' value='שליחה' class='submit_style'></td>";
					echo "</tr>";
					
				echo "</form>";
				echo "</table>";
			echo "</td>";
		echo "</tr>";

	echo "</table>";
}


function net_massg_edit_DB_step2()
{
	$moreQRY = "";
	
	if( $_POST['sinonBy_start_age'] != "" )
	{
		$current_year = date("Y");
		$age_from_limit	= $current_year-$_POST['sinonBy_start_age'];
		$date_limit 		= $age_from_limit."-".date("m")."-".date("d")."";
		$moreQRY .= "AND nu.birthday <= '".$date_limit."' ";
	}
	
	if( $_POST['sinonBy_end_age'] != "" )
	{
		$age_to_limit	= date("Y")-$_POST['sinonBy_end_age'];
		$age_to_limit	= $age_to_limit-1;
		$date_limit 		= $age_to_limit."-".date("m")."-".date("d")."";
		$moreQRY .= "AND nu.birthday >= '".$date_limit."' ";
	}
	
	if( $_POST['sinonBy_gender'] != "" )
		$moreQRY .= "AND nu.gender = '".$_POST['sinonBy_gender']."' ";
	
	if( $_POST['sinonBy_city'] != "" )
		$moreQRY .= "AND nu.city = '".$_POST['sinonBy_city']."' ";
	
	
	$sql = "SELECT nu.id FROM net_users as nu , net_users_belong  as nub WHERE 
				nu.deleted=0 AND 
				nub.net_user_id=nu.id AND
				nub.unk = '".UNK."' AND
				nub.status=0 ".$moreQRY;
	$res = mysql_db_query(DB,$sql);
	
	
	$all_users = array();
	$all_users_ex = array();
	while( $data = mysql_fetch_array($res) )
	{
		$user_id = $data['id'];
		$all_users[$user_id] = "1";
	}
	
	
	$sql = "SELECT inputType, id FROM dynamic_client_form WHERE unk = '".UNK."' AND active=0 ORDER BY place";
	$res_fields =	mysql_db_query(DB, $sql);
	
	$count_dynamic=0;
	while( $data_fields = mysql_fetch_array($res_fields) )
	{
		$post_name = "field_".$data_fields['id'];
		
		if( $_POST[$post_name] != "" )
		{
			switch($data_fields['inputType'])
			{
				case "2" :		$values = "valueSelect";			break;
				case "4" :		$values = "valueRadio";			break;
			}
			$sql = "SELECT netUserId FROM dynamic_client_form_users_values WHERE unk = '".UNK."' AND dynamicFormId = '".$data_fields['id']."' AND ".$values." = '".$_POST[$post_name]."'";
			$res5 = mysql_db_query(DB, $sql);
			
			while( $data_fields2 = mysql_fetch_array($res5) )
			{
				if( $data_fields2['netUserId'] != "" )
				{
					$netUserId = $data_fields2['netUserId'];
					$all_users_ex[$netUserId] = 1;
				}
			}
			
			
			$count_dynamic++;
		}
	}
	
	$all_usersNew = array();
	foreach( $all_users as $user_id => $key )
	{
		if( $count_dynamic == "0" )
			$all_usersNew[$user_id] = 1;
		else
		{
			foreach( $all_users_ex as $user_id2 => $key2 )
			{
				if( $user_id == $user_id2 )
					$all_usersNew[$user_id] = 1;
			}
		}
	}
	
	foreach( $all_usersNew as $user_id => $key )
	{
		$sql = "INSERT INTO net_users_client_messg_choosen ( netUserId, msgId ) VALUES ( '".$user_id."' , '".$_POST['msg_id']."' )";
		$res = mysql_db_query(DB,$sql);
	}
	
	echo "<META HTTP-EQUIV=Refresh CONTENT=\"0; URL=index.php?main=net_massg_list&type=".$_POST['type']."&unk=".UNK."&sesid=".SESID."\">";
}


function net_massg_sendMail()
{
	$past_sent = 0;
	$sql = "SELECT date_insert, id FROM net_users_client_messgSentMail WHERE msgId = '".$_GET['msg_id']."' AND unk = '".UNK."' ORDER BY id DESC LIMIT 1";
	$res = mysql_db_query(DB,$sql);
	$data = mysql_fetch_array($res);
	
	$make_start_date =  date( "Y-m-d" , mktime(0, 0, 0, date(m), "1", date(Y)));
	$make_end_date =  date( "Y-m-d" , mktime(0, 0, 0, date(m), "31", date(Y)));
	
	$sql3 = "SELECT COUNT(id) as counts FROM net_users_client_messgSentMail WHERE unk = '".UNK."' AND date_insert >= '".$make_start_date."' AND date_insert <= '".$make_end_date."' ";
	$res3 = mysql_db_query(DB,$sql3);
	$dataCountMails = mysql_fetch_array($res3);
	
	$sql2 = "SELECT netMaxSendMail FROM  user_extra_settings WHERE unk = '".UNK."'";
	$res2 = mysql_db_query(DB,$sql2);
	$data_nmsm = mysql_fetch_array($res2);
	
	if( $dataCountMails['counts'] >= $data_nmsm['netMaxSendMail'] )
	{
		echo "<p class='maintext'>";
			echo "מתחילת החודש שלחת ".$dataCountMails['counts']." אימיילים ללקוחותיך, ההגבלה היא ".$data_nmsm['netMaxSendMail']." שליחות אימיילים בחודש<br>להגדלת השליחות פר חודש, אנא צור קשר עם מחלקת המכירות שלנו";
		echo "</p>";
		$past_sent = 1;
	}
	
	if( $data['id'] != "" && $_GET['past_sent'] != 1 && $past_sent != 1)
	{
		echo "<p class='maintext'>";
			echo "לפי רישומי המערכת, נשלח אימייל לתפוצה הזו בתאריך: ".GlobalFunctions::show_dateTime_field(stripslashes($data['date_insert']))."<br>";
			echo "האם ברצונך לשלוח שוב?<br>";
			echo "<a href='index.php?main=net_massg_sendMail&past_sent=1&type=net&msg_id=".$_GET['msg_id']."&sesid=".SESID."&unk=".UNK."' class='maintext'><b>כן</b></a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a href='index.php?main=net_massg_list&type=net&msg_id=".$$_GET['msg_id']."&sesid=".SESID."&unk=".UNK."' class='maintext'><b>לא</b></a>";
		echo "</p>";
		$past_sent = 1;
	}
	
	
	
	if( $past_sent == 0 || $_GET['past_sent'] == 1 )
	{
		$sql = "SELECT netUserId FROM net_users_client_messg_choosen WHERE msgId='".$_GET['msg_id']."'";
		$res = mysql_db_query(DB,$sql);
		
		$sql = "SELECT name,email,domain FROM users WHERE unk = '".UNK."'";
		$res2 = mysql_db_query(DB, $sql);
		$user_details = mysql_fetch_array($res2);
		
		$sql = "SELECT content,subject,url_name,url_href,linkActiveMail FROM net_users_client_messg WHERE unk = '".UNK."' AND id = '".$_GET['msg_id']."'";
		$res3 = mysql_db_query(DB, $sql);
		$dataMsg = mysql_fetch_array($res3);
		
		$count=0;
		while( $data = mysql_fetch_array($res) )
		{
			$sql = "SELECT nu.email,nu.fname,nu.lname,nu.unick_ses,nu.password FROM net_users AS nu, net_users_belong as ub WHERE 
				nu.email != '' AND 
				nu.id = '".$data['netUserId']."' AND 
				nu.verify=1 AND
				ub.sendMailActive=0 AND
				ub.unk='".UNK."' AND
				ub.net_user_id=nu.id AND
				ub.status=0";
			$resUser = mysql_db_query(DB,$sql);
			$dataUser = mysql_fetch_array($resUser);
			
			$email_allowed = true;
			$email_check = trim($dataUser['email']);
			$email_filter_sql = "SELECT email FROM net_email_filter WHERE email = '$email_check'";
			$email_filter_res = mysql_db_query(DB,$email_filter_sql);
			$email_filter_data = mysql_fetch_array($email_filter_res);
			if($email_filter_data['email'] != ""){
				$email_allowed = false;
			}
			if( GlobalFunctions::validate_email_address($dataUser['email']) && $email_allowed)
			{
				$fromEmail = stripslashes($user_details['email']); 
				$fromTitle = stripslashes($user_details['name']); 
				
				$site_domain = stripslashes($user_details['domain']);
				
				/*
				קבלת הודעה חדשה מהמועדון חברים, לצפיה בהודעה המלאה <a href='http://www.".$site_domain."/index.php?m=NetMess' class='text_link'>לחץ כאן</a>
				<br><br>
				להזכירך, להלן פרטי התחברות למועדון האתר:<br><br>
				מייל להתחברות: ".stripslashes($dataUser['email'])."<br>
				סיסמה: ".stripslashes($dataUser['password'])."<br><br>
				*/
				$content = "
				שלום ".stripslashes($dataUser['fname'])." ".stripslashes($dataUser['lname']).",<br>
				<br>
				".nl2br(stripslashes($dataMsg['content']))."<br><br>
				";
				
				if( $dataMsg['url_name'] != '' && $dataMsg['url_href'] != '' && $dataMsg['linkActiveMail'] == '1' )
				{
					if( eregi("http://",$dataMsg['url_href']) )
						$href= stripslashes($dataMsg['url_href']);
					else
						$href= 'http://'.stripslashes($dataMsg['url_href']);
					
					$content .= "<br>
					<a href='".$href."' class='text_link'>".stripslashes($dataMsg['url_name'])."</a><br>";
				}
				
				$content .= "<br>
				בברכה,<br>
				".stripslashes($user_details['name'])."<br>
				<a href='http://www.".$site_domain."' class='text_link' target='_blank'>".$site_domain."</a>
				<br><br><br>
				<font style='font-size: 10px;'><a href='http://www.".$site_domain."/index.php?m=net_mail_removeChossen&s=".$dataUser['unick_ses']."&tu=".UNK."' class='text_link' target='_blank'>להסרה מרשימת התפוצה לחץ כאן</a></font>
				";
							
							$header_send_to_Client= stripslashes($dataMsg['subject']);
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
									<p class='textt' dir=rtl align=right>".$content."</p>
								</body>
								</html>";
							
							$ClientMail = $dataUser['email'];
							GlobalFunctions::send_emails_with_phpmailer($fromEmail, $fromTitle, $header_send_to_Client, $content_send_to_Client, $content_send_to_Client, $ClientMail, $fromTitle );
				
				$count++;
			}
		}
		
		if( $count == 0 )
		{
			echo "<script>alert('אין חברים שאליהם נשלח אימייל');</script>";
		}
		else
		{
			$sql = "INSERT INTO net_users_client_messgSentMail ( msgId , totalSent , date_insert, unk ) VALUES ( '".$_GET['msg_id']."' , '".$count."' , NOW() , '".UNK."' )";
			$res = mysql_db_query(DB,$sql);
		}
		
		echo "<META HTTP-EQUIV=Refresh CONTENT=\"0; URL=index.php?main=net_massg_list&type=".$_GET['type']."&unk=".UNK."&sesid=".SESID."\">";
	}
	
	
}



function net_mailing()
{
	$sql1 = "select mails_amount, days from net_mailing_settings where unk = '".UNK."'";
	$res1 = mysql_db_query(DB,$sql1);
	$data1 = mysql_fetch_array($res1);
	
	echo "<table border='0' cellspacing='0' cellpadding='0' class='maintext'>";
		if( $data1['mails_amount'] == "0" || $data1['mails_amount'] == "" )
		{
			echo "<tr>";
				echo "<td><b>יש להוסיף מספר מיילים שיישלח ללקוח שנרשם, תוכלו לעדכן זאת בהגדרות</b></td>";
			echo "</tr>";
			echo "<tr><td height=7></td></tr>";
		}
		if( $data1['days'] == "" )
		{
			echo "<tr>";
				echo "<td><b>יש להוסיף את הימים בהם יישלח ההודעה, תוכלו להגדיר זאת בהגדרות</b></td>";
			echo "</tr>";
		}
	echo "</table>";
}



function net_mailing_settings()
{
	$sql = "select id , mailing_name , mailing_default, mails_amount from net_mailing_settings where unk = '".UNK."' AND deleted=0";
	$res = mysql_db_query(DB,$sql);
	
	echo "<table border='0' cellspacing='0' cellpadding='0' class='maintext'>";
		
		echo "<tr>";
			echo "<td><b>שם דיוור האוטומטי</b></td>";
			echo "<td width=10></td>";
			echo "<td><b>ברירת מחדל?</b></td>";
			echo "<td width=10></td>";
			echo "<td><b>הוסף מייל חדש</b></td>";
			echo "<td width=10></td>";
			echo "<td><b>רשימת מיילים</b></td>";
			echo "<td width=10></td>";
			echo "<td><b>מספר מיילים</b></td>";
			echo "<td width=10></td>";
			echo "<td><b>עריכה</b></td>";
			echo "<td width=10></td>";
			echo "<td><b>מחיקה</b></td>";
		echo "</tr>";
		
		while( $data = mysql_fetch_array($res) ) 
		{
			$sqlC = "SELECT id FROM net_mailing_msg_mails WHERE unk = '".UNK."' AND deleted=0 AND mailing_id = '".$data['id']."'";
			$resC = mysql_db_query(DB,$sqlC);
			$numsC = mysql_num_rows($resC);
			
			$defualt_mailing = ( $data['mailing_default'] == "1" ) ? "כן" : "לא";
			
			echo "<tr><td colspan=7 height=7></td></tr>";
			echo "<tr>";
				echo "<td>".stripslashes($data['mailing_name'])."</td>";
				echo "<td width=10></td>";
				echo "<td>".$defualt_mailing."</td>";
				echo "<td width=10></td>";
				echo "<td><a href='index.php?main=net_mailing_msg_edit&type=net_mailing&mailing_id=".$data['id']."&unk=".UNK."&sesid=".SESID."' class='maintext'>הוסף מייל חדש</a></td>";
				echo "<td width=10></td>";
				echo "<td><a href='index.php?main=net_mailing_msg&type=net_mailing&mailing_id=".$data['id']."&unk=".UNK."&sesid=".SESID."' class='maintext'>רשימת מיילים</a></td>";
				echo "<td width=10></td>";
				echo "<td>".$numsC." מתוך ".$data['mails_amount']." כפי שמוגדר במערכת</td>";
				echo "<td width=10></td>";
				echo "<td><a href='index.php?main=net_mailing_settings_edit&type=net_mailing&mailing_id=".$data['id']."&unk=".UNK."&sesid=".SESID."' class='maintext'>עריכה</a></td>";
				echo "<td width=10></td>";
				echo "<td><a href='index.php?main=net_mailing_settings_del&type=net_mailing&mailing_id=".$data['id']."&unk=".UNK."&sesid=".SESID."' class='maintext' onclick='return can_i_del()'>מחיקה</a></td>";
			echo "</tr>";
		}
		
	echo "</table>";
}


function net_mailing_settings_edit()
{
	$sql = "select * from net_mailing_settings where unk = '".UNK."' AND deleted=0 AND id = '".$_GET['mailing_id']."'";
	$res = mysql_db_query(DB,$sql);
	$data = mysql_fetch_array($res);
	
	
	echo "<table border='0' cellspacing='0' cellpadding='0' class='maintext'>";
		
		echo "<tr>";
			echo "<td>";
				echo "<table border='0' cellspacing='0' cellpadding='0' class='maintext'>";
				echo "<form action='index.php' method='post' name='fnmse'>";
				echo "<input type='hidden' name='main' value='net_mailing_settings_edit_DB'>";
				echo "<input type='hidden' name='type' value='net_mailing'>";
				echo "<input type='hidden' name='mailing_id' value='".$_GET['mailing_id']."'>";
				echo "<input type='hidden' name='sesid' value='".SESID."'>";
				echo "<input type='hidden' name='unk' value='".UNK."'>";
					
					
					echo "<tr>";
						echo "<td>שם הדיוור</td>";
						echo "<td width=10></td>";
						echo "<td><input type='text' name='mailing_name' value='".stripslashes($data['mailing_name'])."' class='input_style'></td>";
					echo "</tr>";
					echo "<tr><td colspan=3 height=7></td></tr>";
					
					echo "<tr>";
						echo "<td valign=top>תיאור הדיוור</td>";
						echo "<td width=10></td>";
						echo "<td><textarea name='mailing_desc' class='input_style' rows='' cols='' class='input_style' style='height: 50px;'>".stripslashes($data['mailing_desc'])."</textarea></td>";
					echo "</tr>";
					echo "<tr><td colspan=3 height=7></td></tr>";
					
					echo "<tr>";
						echo "<td>מספר מיילים שיישלח ללקוח</td>";
						echo "<td width=10></td>";
						echo "<td>";
							echo "<select name='mails_amount' class='input_style' style='width:100px;'>";
								echo "<option value=''>בחירה</option>";
								for( $i=0 ; $i<=120 ; $i++ )
								{
									$selected = ( $i == $data['mails_amount'] ) ? "selected" : "";
									echo "<option value='".$i."' ".$selected.">".$i."</option>";
								}
							echo "</select>";
						echo "</td>";
					echo "</tr>";
					echo "<tr><td colspan=3 height=7></td></tr>";
					
					echo "<tr>";
						echo "<td>שעה שהמייל ישלח ללקוח</td>";
						echo "<td width=10></td>";
						echo "<td>";
							echo "<select name='send_hour' class='input_style' style='width:100px;'>";
								echo "<option value=''>בחירה</option>";
								for( $i=0 ; $i<=24 ; $i++ )
								{
									$wi = ( $i > "9" ) ? $i : "0".$i;
									$selected = ( $wi.":00:00" == $data['send_hour'] ) ? "selected" : "";
									echo "<option value='".$wi.":00' ".$selected.">".$wi.":00</option>";
								}
							echo "</select>";
						echo "</td>";
					echo "</tr>";
					echo "<tr><td colspan=3 height=7></td></tr>";
					
					echo "<tr>";
						echo "<td valign=top>ימים בהם ההודעה תישלח</td>";
						echo "<td width=10></td>";
						echo "<td>";
							for( $i=0 ; $i<=6 ; $i++ )
							{
								switch($i)
								{
									case "0" : $dayName = "ראשון";	break;
									case "1" : $dayName = "שני";	break;
									case "2" : $dayName = "שלישי";	break;
									case "3" : $dayName = "רביעי";	break;
									case "4" : $dayName = "חמישי";	break;
									case "5" : $dayName = "שישי";	break;
									case "6" : $dayName = "שבת";	break;
								}
								$checked = ( eregi($i , $data['days'] ) ) ? "checked" : "";
								echo "<input type='checkbox' name='days[]' value='".$i."' ".$checked."> ".$dayName."<br>";
							}
						echo "</td>";
					echo "</tr>";
					echo "<tr><td colspan=3 height=7></td></tr>";
					
					echo "<tr>";
						echo "<td>דיוור ברירת מחדל</td>";
						echo "<td width=10></td>";
						echo "<td>";
							$selected0 = ( $data['mailing_default'] == "0" ) ? "selected" : "";
							$selected1 = ( $data['mailing_default'] == "1" ) ? "selected" : "";
							
							echo "<select name='mailing_default' class='input_style' style='width:100px;'>";
								echo "<option value='0' ".$selected0.">לא</option>";
								echo "<option value='1' ".$selected1.">כן</option>";
							echo "</select>";
						echo "</td>";
					echo "</tr>";
					echo "<tr><td colspan=3 height=7></td></tr>";
					
					$sql = "SELECT id, question_answer_value FROM net_mailing_question_answer WHERE unk = '".UNK."' AND question=0 ";
					$resQa = mysql_db_query(DB,$sql);
					
					echo "<tr>";
						echo "<td></td>";
						echo "<td width=10></td>";
						echo "<td>";
							echo "<select name='mailing_answer' class='input_style' style='width:300px;'>";
								echo "<option value=''>בחר תשובה</option>";
								while( $dataQa = mysql_fetch_array($resQa) )
								{
									echo "<option value=''>---------".stripslashes($dataQa['question_answer_value'])."---------</option>";
									
									$sql2 = "SELECT id, question_answer_value FROM net_mailing_question_answer WHERE unk = '".UNK."' AND question = '".$dataQa['id']."' ";
									$resQa2 = mysql_db_query(DB,$sql2);
									
									while( $dataQa2 = mysql_fetch_array($resQa2) )
									{
										$selected = ( $dataQa2['id'] == $data['mailing_answer'] ) ? "selected" : "";
										
										echo "<option value='".$dataQa2['id']."' ".$selected.">".stripslashes($dataQa2['question_answer_value'])."</option>";
									}
								}
							
							echo "</select>";
						echo "</td>";
					echo "</tr>";
					echo "<tr><td colspan=3 height=7></td></tr>";
					
					echo "<tr>";
						echo "<td></td>";
						echo "<td width=10></td>";
						echo "<td align=left><input type='submit' value='שמירה' class='submit_style'></td>";
					echo "</tr>";
					
				echo "</form>";
				echo "</table>";
			echo "</td>";
		echo "</tr>";

	echo "</table>";
}

function net_mailing_settings_del()
{
	$sql = "UPDATE net_mailing_settings SET deleted=1 WHERE id = '".$_GET['mailing_id']."'";
	$res = mysql_db_query(DB,$sql);
	
	echo "<META HTTP-EQUIV=Refresh CONTENT=\"0; URL=index.php?main=net_mailing_settings&type=".$_GET['type']."&unk=".UNK."&sesid=".SESID."\">";
		exit;
}


function net_mailing_settings_edit_DB()
{
	$daysT = "";
	foreach( $_POST['days'] as $key => $val )
	{
		$daysT .= $val."|";
	}
	
	if( $_POST['mailing_id'] != "" )
	{
		$sql = "UPDATE net_mailing_settings SET mails_amount = '".$_POST['mails_amount']."' , days = '".$daysT."' ,
		mailing_name = '".addslashes($_POST['mailing_name'])."' , mailing_desc = '".addslashes($_POST['mailing_desc'])."' , 
		send_hour = '".$_POST['send_hour']."' , mailing_default = '".$_POST['mailing_default']."' , mailing_answer = '".$_POST['mailing_answer']."'
		WHERE id = '".$_POST['mailing_id']."'";
		$res = mysql_db_query(DB,$sql);
	}
	else
	{
		$sql = "INSERT INTO net_mailing_settings ( unk , mails_amount , days , mailing_name , mailing_desc , send_hour , mailing_default , mailing_answer ) VALUES (
		'".UNK."' , '".$_POST['mails_amount']."' , '".$daysT."' , 
		'".addslashes($_POST['mailing_name'])."' , '".addslashes($_POST['mailing_desc'])."' , '".$_POST['send_hour']."' , 
		'".$_POST['mailing_default']."' , '".$_POST['mailing_answer']."') ";
		$res = mysql_db_query(DB,$sql);
	}
	
	echo "<META HTTP-EQUIV=Refresh CONTENT=\"0; URL=index.php?main=net_mailing_settings&type=".$_POST['type']."&unk=".UNK."&sesid=".SESID."\">";
		exit;
}


function net_mailing_qa_anw()
{
	$sql = "select id , question_answer_value from net_mailing_question_answer where unk = '".UNK."' AND question=0";
	$res = mysql_db_query(DB,$sql);
	
	echo "<table border='0' cellspacing='0' cellpadding='0' class='maintext'>";
		
		echo "<tr>";
			echo "<td><b>שאלה \ תשובה</b></td>";
			echo "<td width=10></td>";
			echo "<td><b>עריכה</b></td>";
			echo "<td width=10></td>";
			echo "<td><b>מחיקה</b></td>";
		echo "</tr>";
		
		while( $data = mysql_fetch_array($res) ) 
		{
			echo "<tr><td colspan=7 height=7></td></tr>";
			echo "<tr>";
				echo "<td><b>".stripslashes($data['question_answer_value'])."</b></td>";
				echo "<td width=10></td>";
				echo "<td><a href='index.php?main=net_mailing_qa_anw_edit&type=net_mailing&qa_id=".$data['id']."&unk=".UNK."&sesid=".SESID."' class='maintext'>עריכה</a></td>";
				echo "<td width=10></td>";
				echo "<td><a href='index.php?main=net_mailing_qa_anw_del&type=net_mailing&qa_id=".$data['id']."&unk=".UNK."&sesid=".SESID."' class='maintext' onclick='aa = confirm(\"האם אתה בטוח למחוק שאלה זאת עם כל התשובות שלה?\"); if(aa == true) return true; else return false;'>מחיקה</a></td>";
			echo "</tr>";
			
			$sql2 = "select id , question_answer_value from net_mailing_question_answer where unk = '".UNK."' AND question='".$data['id']."' ";
			$res2 = mysql_db_query(DB,$sql2);
			
			while( $data2 = mysql_fetch_array($res2) ) 
			{
				echo "<tr><td colspan=7 height=7></td></tr>";
				echo "<tr>";
					echo "<td style='padding-right: 10px;'>".stripslashes($data2['question_answer_value'])."</td>";
					echo "<td width=10></td>";
					echo "<td><a href='index.php?main=net_mailing_qa_anw_edit&type=net_mailing&qa_id=".$data2['id']."&unk=".UNK."&sesid=".SESID."' class='maintext'>עריכה</a></td>";
					echo "<td width=10></td>";
					echo "<td><a href='index.php?main=net_mailing_qa_anw_del&type=net_mailing&qa_id=".$data2['id']."&unk=".UNK."&sesid=".SESID."' class='maintext' onclick='return can_i_del()'>מחיקה</a></td>";
				echo "</tr>";
			}
		}
			
	echo "</table>";
}


function net_mailing_qa_anw_edit()
{
	$sql = "select * from net_mailing_question_answer where unk = '".UNK."' AND id = '".$_GET['qa_id']."'";
	$res = mysql_db_query(DB,$sql);
	$data = mysql_fetch_array($res);
	
	
	echo "<table border='0' cellspacing='0' cellpadding='0' class='maintext'>";
		
		echo "<tr>";
			echo "<td>";
				echo "<table border='0' cellspacing='0' cellpadding='0' class='maintext'>";
				echo "<form action='index.php' method='post' name='fnmseqs'>";
				echo "<input type='hidden' name='main' value='net_mailing_qa_anw_edit_DB'>";
				echo "<input type='hidden' name='type' value='net_mailing'>";
				echo "<input type='hidden' name='qa_id' value='".$_GET['qa_id']."'>";
				echo "<input type='hidden' name='sesid' value='".SESID."'>";
				echo "<input type='hidden' name='unk' value='".UNK."'>";
					
					$sql = "SELECT id, question_answer_value FROM net_mailing_question_answer WHERE unk = '".UNK."' AND question=0";
					$resQa = mysql_db_query(DB,$sql);
					
					echo "<tr>";
						echo "<td>בחר תשובה לשאלה / או שאלה חדשה</td>";
						echo "<td width=10></td>";
						echo "<td>";
							echo "<select name='question' class='input_style' style='width:300px;'>";
							
								echo "<option value='0'>שאלה חדשה</option>";
								
								while( $dataQa = mysql_fetch_array($resQa) )
								{
									$selected = ( $dataQa['id'] == $data['question'] ) ? "selected" : "";
									
									echo "<option value='".$dataQa['id']."' ".$selected.">".stripslashes($dataQa['question_answer_value'])."</option>";
								}
							
							echo "</select>";
						echo "</td>";
					echo "</tr>";
					
					echo "<tr><td colspan=3 height=7></td></tr>";
					
					echo "<tr>";
						echo "<td>טקסט לשאלה \ תשובה</td>";
						echo "<td width=10></td>";
						echo "<td><input type='text' name='question_answer_value' value='".stripslashes($data['question_answer_value'])."' class='input_style'></td>";
					echo "</tr>";
					
					echo "<tr><td colspan=3 height=7></td></tr>";
					
					echo "<tr>";
						echo "<td></td>";
						echo "<td width=10></td>";
						echo "<td align=left><input type='submit' value='שמירה' class='submit_style'></td>";
					echo "</tr>";
					
				echo "</form>";
				echo "</table>";
			echo "</td>";
		echo "</tr>";

	echo "</table>";
}


function net_mailing_qa_anw_edit_DB()
{
	if( $_POST['qa_id'] != "" )
	{
		$sql = "UPDATE net_mailing_question_answer SET question = '".$_POST['question']."' , 
		question_answer_value = '".addslashes($_POST['question_answer_value'])."' WHERE id = '".$_POST['qa_id']."'";
		$res = mysql_db_query(DB,$sql);
	}
	else
	{
		$sql = "INSERT INTO net_mailing_question_answer ( unk , question , question_answer_value ) VALUES (
		'".UNK."' , '".$_POST['question']."' , '".addslashes($_POST['question_answer_value'])."' ) ";
		$res = mysql_db_query(DB,$sql);
	}
	
	echo "<META HTTP-EQUIV=Refresh CONTENT=\"0; URL=index.php?main=net_mailing_qa_anw&type=".$_POST['type']."&unk=".UNK."&sesid=".SESID."\">";
		exit;
}


function net_mailing_qa_anw_del()
{
	$sql = "SELECT question FROM net_mailing_question_answer WHERE id = '".$_GET['qa_id']."' ";
	$resS = mysql_db_query(DB,$sql);
	$dataS = mysql_fetch_array($resS);
	
	if( $dataS['question'] == "0" )
	{
		$sql = "DELETE FROM net_mailing_question_answer WHERE question = '".$_GET['qa_id']."'";
		$res = mysql_db_query(DB,$sql);
		
		$sql = "DELETE FROM net_mailing_question_answer WHERE id = '".$_GET['qa_id']."' LIMIT 1 ";
		$res = mysql_db_query(DB,$sql);
	}
	else
	{
		$sql = "DELETE FROM net_mailing_question_answer WHERE id = '".$_GET['qa_id']."' LIMIT 1 ";
		$res = mysql_db_query(DB,$sql);
	}
	
	echo "<META HTTP-EQUIV=Refresh CONTENT=\"0; URL=index.php?main=net_mailing_qa_anw&type=".$_GET['type']."&unk=".UNK."&sesid=".SESID."\">";
		exit;
}


function net_mailing_msg()
{
	$sql = "select id , mail_number, subject  from net_mailing_msg_mails where unk = '".UNK."' AND deleted=0 AND mailing_id = '".$_GET['mailing_id']."' ORDER BY mail_number ";
	$res = mysql_db_query(DB,$sql);
	
	$sql = "select id , mailing_name from net_mailing_settings where unk = '".UNK."' AND deleted=0 AND id = '".$_GET['mailing_id']."'";
	$resM = mysql_db_query(DB,$sql);
	$dataM = mysql_fetch_array($resM);
	
	echo "<table border='0' cellspacing='0' cellpadding='0' class='maintext'>";
		
		echo "<tr>";
			echo "<td colspan=7>שם הדיוור: <b>".stripslashes($dataM['mailing_name'])."</b></td>";
		echo "</tr>";
		
		echo "<tr><td colspan=7 height=7></td></tr>";
		
		echo "<tr>";
			echo "<td><b>מספר המייל</b></td>";
			echo "<td width=10></td>";
			echo "<td><b>כותרת המייל</b></td>";
			echo "<td width=10></td>";
			echo "<td><b>עריכה</b></td>";
			echo "<td width=10></td>";
			echo "<td><b>מחיקה</b></td>";
		echo "</tr>";
		
		while( $data = mysql_fetch_array($res) ) 
		{
			echo "<tr><td colspan=7 height=7></td></tr>";
			echo "<tr>";
				echo "<td>".$data['mail_number']."</td>";
				echo "<td width=10></td>";
				echo "<td>".stripslashes($data['subject'])."</td>";
				echo "<td width=10></td>";
				echo "<td><a href='index.php?main=net_mailing_msg_edit&type=net_mailing&mail_id=".$data['id']."&mailing_id=".$_GET['mailing_id']."&unk=".UNK."&sesid=".SESID."' class='maintext'>עריכה</a></td>";
				echo "<td width=10></td>";
				echo "<td><a href='index.php?main=net_mailing_msg_del&type=net_mailing&mail_id=".$data['id']."&mailing_id=".$_GET['mailing_id']."&unk=".UNK."&sesid=".SESID."' class='maintext' onclick='return can_i_del();'>מחיקה</a></td>";
			echo "</tr>";
		}
			
	echo "</table>";
}


function net_mailing_msg_edit()
{
	
	$sql = "select * from net_mailing_msg_mails where unk = '".UNK."' AND id = '".$_GET['mail_id']."' AND mailing_id = '".$_GET['mailing_id']."' ";
	$res = mysql_db_query(DB,$sql);
	$data = mysql_fetch_array($res);
	
	$sql = "select id , mailing_name , mails_amount from net_mailing_settings where unk = '".UNK."' AND deleted=0 AND id = '".$_GET['mailing_id']."'";
	$resM = mysql_db_query(DB,$sql);
	$dataM = mysql_fetch_array($resM);
	
	
	echo "<table border='0' cellspacing='0' cellpadding='0' class='maintext'>";
		
		echo "<tr>";
			echo "<td>";
				echo "<table border='0' cellspacing='0' cellpadding='0' class='maintext'>";
				echo "<form action='index.php' method='post' name='fnmseqs'>";
				echo "<input type='hidden' name='main' value='net_mailing_msg_edit_DB'>";
				echo "<input type='hidden' name='type' value='net_mailing'>";
				echo "<input type='hidden' name='mail_id' value='".$_GET['mail_id']."'>";
				echo "<input type='hidden' name='mailing_id' value='".$_GET['mailing_id']."'>";
				echo "<input type='hidden' name='sesid' value='".SESID."'>";
				echo "<input type='hidden' name='unk' value='".UNK."'>";
					
					
					
					echo "<tr>";
						echo "<td>מספר מייל</td>";
						echo "<td width=10></td>";
						echo "<td>";
							echo "<select name='mail_number' class='input_style' style='width:300px;'>";
							
								echo "<option value=''>בחירה</option>";
								
								for( $i=1 ; $i<=$dataM['mails_amount']+1 ; $i++ )
								{
									$selected = ( $i == $data['mail_number'] ) ? "selected" : "" ;
									echo "<option value='".$i."' ".$selected.">".$i."</option>";
								}
							
							echo "</select>";
						echo "</td>";
					echo "</tr>";
					
					echo "<tr><td colspan=3 height=7></td></tr>";
					
					echo "<tr>";
						echo "<td>כותרת</td>";
						echo "<td width=10></td>";
						echo "<td><input type='text' name='subject' value='".stripslashes($data['subject'])."' class='input_style'></td>";
					echo "</tr>";
					echo "<tr><td colspan=3 height=7></td></tr>";
					
					echo "<tr>";
						echo "<td>שם השולח</td>";
						echo "<td width=10></td>";
						echo "<td><input type='text' name='from_name' value='".stripslashes($data['from_name'])."' class='input_style'></td>";
					echo "</tr>";
					echo "<tr><td colspan=3 height=7></td></tr>";
					
					echo "<tr>";
						echo "<td>כתובת אימייל השולח</td>";
						echo "<td width=10></td>";
						echo "<td><input type='text' name='from_email' value='".stripslashes($data['from_email'])."' class='input_style'></td>";
					echo "</tr>";
					echo "<tr><td colspan=3 height=7></td></tr>";
					
					echo "<tr>";
						echo "<td>תקציר</td>";
						echo "<td width=10></td>";
						echo "<td><textarea cols='' rows='' name='summary' class='input_style' style='height: 50px;'>".stripslashes($data['summary'])."</textarea></td>";
					echo "</tr>";
					echo "<tr><td colspan=3 height=7></td></tr>";
					
					echo "<tr>";
						echo "<td>כתובת URL מלאה שבה יופיע המדריך</td>";
						echo "<td width=10></td>";
						echo "<td><input type='text' name='goto_page' value='".stripslashes($data['goto_page'])."' class='input_style'></td>";
					echo "</tr>";
					echo "<tr><td colspan=3 height=7></td></tr>";
					
					echo "<tr>";
						echo "<td colspan=3>תוכן ההודעה:</td>";
					echo "</tr>";
					echo "<tr><td colspan=3 height=7></td></tr>";
					
					echo "<tr>";
						echo "<td colspan=3>";
							
							load_editor_text( "body" , stripcslashes($data['body']) );
							
						echo "</td>";
					echo "</tr>";
					echo "<tr><td colspan=3 height=7></td></tr>";
					
					echo "<tr>";
						echo "<td colspan=3 style='font-size: 11px;'>להטמעת הקישור יש להכניס את הצירוף: #קישור#<br>
						להטמעת שם פרטי יש להכניס את הצירוף: #שםפרטי#<br>
						להטמעת שם משפחה יש להכניס את הצירוף: #שםמשפחה#<br>
						להטמעת אימייל יש להכניס את הצירוף: #אימייל#<br>
						להטמעת סיסמה יש להכניס את הצירוף: #סיסמה#.</td>";
					echo "</tr>";
					echo "<tr><td colspan=3 height=7></td></tr>";
					
					echo "<tr>";
						echo "<td>כותרת למייל תזכורת</td>";
						echo "<td width=10></td>";
						echo "<td><input type='text' name='reminder_subject' value='".stripslashes($data['reminder_subject'])."' class='input_style'></td>";
					echo "</tr>";
					echo "<tr><td colspan=3 height=7></td></tr>";
					
					echo "<tr>";
						echo "<td>כמות הודעות לשליחת מייל תזכורת</td>";
						echo "<td width=10></td>";
						echo "<td>";
							echo "<select name='reminder_total_send' class='input_style' style='width: 100px;'>";
								for( $i=0 ; $i<=10 ; $i++ )
								{
									$selected = ( $i == $data['reminder_total_send'] ) ? "selected" : "";
									echo "<option value='".$i."' ".$selected.">".$i."</option>";
								}
							echo "</select>";
						echo "</td>";
					echo "</tr>";
					echo "<tr><td colspan=3 height=7></td></tr>";
					
					echo "<tr>";
						echo "<td>כל כמה ימים לשלוח הודעת תזכורת</td>";
						echo "<td width=10></td>";
						echo "<td>";
							echo "<select name='reminder_period_day_send' class='input_style' style='width: 100px;'>";
								for( $i=0 ; $i<=10 ; $i++ )
								{
									$selected = ( $i == $data['reminder_period_day_send'] ) ? "selected" : "";
									echo "<option value='".$i."' ".$selected.">".$i."</option>";
								}
							echo "</select>";
						echo "</td>";
					echo "</tr>";
					echo "<tr><td colspan=3 height=7></td></tr>";
					
					echo "<tr>";
						echo "<td></td>";
						echo "<td width=10></td>";
						echo "<td align=left><input type='submit' value='שמירה' class='submit_style'></td>";
					echo "</tr>";
					
				echo "</form>";
				echo "</table>";
			echo "</td>";
		echo "</tr>";

	echo "</table>";
	
}


function net_mailing_msg_edit_DB()
{
	
	if( $_POST['mail_id'] != "" )
	{
		$sql = "UPDATE net_mailing_msg_mails SET 
		mail_number = '".$_POST['mail_number']."' , subject = '".addslashes($_POST['subject'])."' , 
		from_email = '".addslashes($_POST['from_email'])."' , from_name = '".addslashes($_POST['from_name'])."' , 
		summary = '".addslashes($_POST['summary'])."' , body = '".addslashes($_POST['body'])."' , goto_page = '".addslashes($_POST['goto_page'])."' , 
		reminder_subject = '".addslashes($_POST['reminder_subject'])."' , reminder_total_send = '".$_POST['reminder_total_send']."' , 
		reminder_period_day_send = '".$_POST['reminder_period_day_send']."'  WHERE id = '".$_POST['mail_id']."'";
		$res = mysql_db_query(DB,$sql);
	}
	else
	{
		$sql = "INSERT INTO net_mailing_msg_mails ( unk , mailing_id , mail_number , subject , from_email , 
		from_name , summary , body , goto_page , reminder_subject , reminder_total_send , reminder_period_day_send ) VALUES (
		'".UNK."' , '".$_POST['mailing_id']."' , '".$_POST['mail_number']."' , '".addslashes($_POST['subject'])."' , 
		'".addslashes($_POST['from_email'])."' , '".addslashes($_POST['from_name'])."' , '".addslashes($_POST['summary'])."' ,
		'".addslashes($_POST['body'])."' ,'".addslashes($_POST['goto_page'])."' ,'".addslashes($_POST['reminder_subject'])."'
		,'".$_POST['reminder_total_send']."' , '".$_POST['reminder_period_day_send']."' ) ";
		$res = mysql_db_query(DB,$sql);
	}
	
	echo "<META HTTP-EQUIV=Refresh CONTENT=\"0; URL=index.php?main=net_mailing_msg&mailing_id=".$_POST['mailing_id']."&type=".$_POST['type']."&unk=".UNK."&sesid=".SESID."\">";
		exit;
	
}


function net_mailing_msg_del()
{
	$sql = "UPDATE net_mailing_msg_mails SET deleted=1 WHERE id = '".$_GET['mail_id']."' ";
	$res = mysql_db_query(DB,$sql);
	
	
	echo "<META HTTP-EQUIV=Refresh CONTENT=\"0; URL=index.php?main=net_mailing_msg&mailing_id='".$_GET['mailing_id']."'&type=".$_GET['type']."&unk=".UNK."&sesid=".SESID."\">";
		exit;
}


?>