<?php


/**************************************************************************************************/
function net_system(){
	define("UNK","022182333801042555");
	$net_func_req = "net_list";
	if(isset($_REQUEST['scope'])){
		$net_func_req = $_REQUEST['scope'];
	}
	switch($net_func_req){
		case "net_list": 
		case "net_user_details": 
		case "net_change_user_status": 	
		case "net_massg_list": 
		case "net_massg_edit": 
		case "net_massg_edit_step2": 
		case "net_xls_import":
		case "net_email_filter_list":		
			print_net_system_header();
		break;		
	}	
	switch($net_func_req){
		case "net_list": return net_list(); break;
		case "net_user_details": return net_user_details();break;
		case "net_change_user_status": return net_change_user_status();break;
		
		case "net_massg_list": return net_massg_list();break;
		case "net_massg_edit": return net_massg_edit();break;
		case "net_massg_edit_step2": return net_massg_edit_step2();break;
		case "net_massg_edit_DB": return net_massg_edit_DB();break;
		case "net_massg_edit_DB_step2": return net_massg_edit_DB_step2();break;
		case "net_massg_sendMail": return net_massg_sendMail();break;
		case "net_list_import": return net_list_import();break;		
		case "net_xls_import": return net_xls_import();break;
		case "net_email_filter_list": return net_email_filter_list(); break;		
	}
}

function print_net_system_header(){
	$top_a_styles = array(
		"net_list"=>"",
		"net_massg_list"=>"",
		"net_massg_edit"=>"",	
		"net_xls_import"=>"",
	);
	if($_REQUEST['scope'] != 'net_massg_edit' || !isset($_GET['record_id'])){
		$top_a_styles[$_REQUEST['scope']] = " style='color:black; font-weight:bold; text-decoration:none;' ";
	}
	echo "<h1>מערכת דיוור</h1>";
	
	echo "<table>";
		echo "<tr>";
			echo "<td>";
				echo "<a href='index.php?sesid=".SESID."' >חזרה לתפריט הראשי</a>";
			echo "</td>";
			echo "<td width='15'></td>";
			echo "<td>";
				echo "<a href='index.php?scope=net_list&main=net_system&sesid=".SESID."' ".$top_a_styles['net_list'].">רשימת המשתמשים</a>";
			echo "</td>";	
			echo "<td width='15'></td>";
			echo "<td>";
				echo "<a href='index.php?scope=net_massg_list&main=net_system&sesid=".SESID."' ".$top_a_styles['net_massg_list'].">רשימת הודעות</a>";
			echo "</td>";
			echo "<td width='15'></td>";			
			echo "<td>";
				echo "<a href='index.php?scope=net_massg_edit&main=net_system&sesid=".SESID."' ".$top_a_styles['net_massg_edit'].">הוספת הודעה</a>";
			echo "</td>";
			echo "<td width='15'></td>";				
			echo "<td>";
				echo "<a href='index.php?scope=net_xls_import&main=net_system&sesid=".SESID."' ".$top_a_styles['net_xls_import'].">ייבוא משתמשים</a>";
			echo "</td>";
			echo "<td width='15'></td>";
			echo "<td>";
				echo "<a href='index.php?scope=net_email_filter_list&main=net_system&sesid=".SESID."' ".$top_a_styles['net_email_filter_list'].">סינון תובעים סדרתיים</a>";
			echo "</td>";	
						
		echo "</tr>";
		
	echo "</table>";
	echo "<div style='height:40px;' ></div>";
}

function net_list()
{
	
	$limitCount = ( $_GET['limit'] == "" ) ? "0" : $_GET['limit'];
	
	$ex = explode( "-" , $_GET['sd'] );
	$where = ($_GET['sd'] != "" ) ? " AND ub.join_date >= '".$ex[2]."-".$ex[1]."-".$ex[0]."' " : "";
	$ex2 = explode( "-" , $_GET['ed'] );
	$where .= ($_GET['ed'] != "" ) ? " AND ub.join_date <= '".$ex2[2]."-".$ex2[1]."-".$ex2[0]."' " : "";
	
	$where .= ($_GET['val'] != "" ) ? " AND ( ( u.fname LIKE '%".mysql_r_e_s($_GET['val'])."%' ) OR ( u.lname LIKE '%".mysql_r_e_s($_GET['val'])."%' ) )" : "";
	
	
	$sql = "SELECT CONCAT(u.fname, ' ' , u.lname) as full_name,u.email, u.date_in, u.birthday, u.verify, u.city, u.id, ub.status, ub.sendMailActive as 'aproved_mail_send', ub.join_date,ub.first_timer FROM net_users as u , net_users_belong as ub WHERE
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
			echo "<td colspan=20>";
				echo "<form action='index.php' name='conatct_search' method='get' style=''padding:0; margin:0;>";
					echo "<input type='hidden' name='main' value='net_system'>";
					echo "<input type='hidden' name='scope' value='net_list'>";
					
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
						
						
						
					echo "</table>";					
				echo "</form>";
				echo "<div style='height:40px;' ></div>";
			echo "</td>";
		echo "</tr>";
		
		
		echo "<tr>";
			echo "<td><b>תאריך הצטרפות</b></td>";
			echo "<td width=15></td>";
			echo "<td><b>שם מלא</b></td>";
			echo "<td width=15></td>";			
			echo "<td><b>אימייל</b></td>";
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
			echo "<td><b>קיבל מייל עם אפשרות להסרה</b></td>";
			echo "<td width=15></td>";
			echo "<td><b>צפיה פרטים</b></td>";
		echo "</tr>";
		
		while( $data = mysql_fetch_array($res) )
		{
			$sql2 = "SELECT name FROM cities WHERE id = '".$data['city']."' ";
			$res2 = mysql_db_query( DB, $sql2 );
			$data2 = mysql_fetch_array($res2);
			
			echo "<tr><td colspan=20 height=3></td></tr>";
			echo "<tr><td colspan=20><hr width=100% size=1 color=#000000></td></tr>";
			echo "<tr><td colspan=20 height=3></td></tr>";
		
			$mail_verify = ( $data['verify'] == "1" ) ? "<font color='green'>אישר מייל</font>" : "<font color='red'>לא אישר מייל</font>";
			$status_color = ( $data['status'] == "0" ) ? "<font color='green'>מאושר</font>" : "<font color='red'>לא מאושר</font>";
			$send_emails = ( $data['aproved_mail_send'] == "0" ) ? "<font color='green'>מאושר</font>" : "<font color='red'>לא מאושר</font>";
			$first_timer = ( $data['first_timer'] == "1" ) ? "<font color='green'>כן</font>" : "<font color='red'>לא</font>";			
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
				echo "<td>".stripslashes($data['email'])."</td>";				
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
				echo "<td>".$first_timer."</td>";
				echo "<td width=15></td>";					
				echo "<td><a target='_BLANK' href='index.php?main=net_system&scope=net_user_details&user_id=".$data['id']."&sesid=".SESID."' class='maintext'>צפיה פרטים</a></td>";
			echo "</tr>";
			
		}
		
		echo "<tr><td colspan=20 height=15></td></tr>";
		echo "<tr>";
			echo "<td colspan=20 align=center>סך הכל חברים: ".$num_rows."</td>";
		echo "</tr>";
		echo "<tr><td colspan=20 height=15></td></tr>";
		echo "<tr>";
			echo "<td colspan=20 align=center style=\"border-top: 1px solid #".$data_colors['border_color'].";\">";	
				$params['limitInPage'] = "50";
				$params['numRows'] = $num_rows;
				$params['limitcount'] = $limitCount;
				$params['main'] = 'net_system';
				$params['scope'] = 'net_list';
				echo "<div style='max-width:400px; overflow:auto; padding:10px;'>";
				get_net_system_pagention( $params );
				echo "</div>";
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

	$status_color = ( $data['status'] == "0" ) ? "<font color='green'>מאושר</font>" : "<font color='red'>לא מאושר</font>";

	




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
		echo "<tr><td colspan=3 height=7></td></tr>";
		echo "<tr>";
			echo "<td>אישור כניסה למועדון: </td>";
			echo "<td width='10'></td>";
			echo "<td><b>".$status_color."</b></td>";
		echo "</tr>";
		echo "<tr><td colspan=3 height=10></td></tr>";	
	
		echo "<tr><td colspan=3 height=10></td></tr>";
		
	echo "</table>";
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
				echo "<td><a href='index.php?scope=net_massg_edit&main=net_system&record_id=".$data['id']."&sesid=".SESID."&unk=".UNK."' class='maintext'>עריכה</a></td>";
				echo "<td width=10></td>";
				echo "<td><a href='index.php?scope=net_massg_sendMail&main=net_system&msg_id=".$data['id']."&sesid=".SESID."&unk=".UNK."' class='maintext'>שלח אימייל</a></td>";
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
				echo "<input type='hidden' name='scope' value='net_massg_edit_DB'>";
				echo "<input type='hidden' name='main' value='net_system'>";
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
						echo "<td>שליחה לסוג משתמשים</td>";
						echo "<td width=10></td>";
						echo "<td>";
						
							$ftselected0 = ( $data['first_timers_status'] == 0 && isset($data['first_timers_status'])) ? "selected" : "";
							$ftselected1 = ( $data['first_timers_status'] == 1 || (!isset($data['first_timers_status']))) ? "selected" : "";
							echo "<select name='data_arr[first_timers_status]' class='input_style'>";
								echo "<option value=1 ".$ftselected1.">משתמשים ותיקים</option>";
								echo "<option value=0 ".$ftselected0.">משתמשים חדשים</option>"; 
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
		
		echo "<META HTTP-EQUIV=Refresh CONTENT=\"0; URL=index.php?scope=net_massg_edit_step2&msg_id=".$new_row."&main=".$_POST['main']."&unk=".UNK."&sesid=".SESID."\">";
	}
	else	{
		update_db($data_arr, $image_settings);	
		
		echo "<script>alert('עודכן בהצלחה');</script>";
		echo "<META HTTP-EQUIV=Refresh CONTENT=\"0; URL=index.php?scope=net_massg_list&main=net_system&sesid=".SESID."\">";
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
				echo "<input type='hidden' name='scope' value='net_massg_edit_DB_step2'>";
				echo "<input type='hidden' name='main' value='net_system'>";
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
	$msg_id = $_POST['msg_id'];
	$sql = "SELECT first_timers_status FROM net_users_client_messg WHERE id = $msg_id";
	$res = mysql_db_query(DB,$sql);
	$first_timers_status_data = mysql_fetch_array($res); 
	$first_timers_status = $first_timers_status_data['first_timers_status'];
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
	
	
	$sql = "SELECT nu.id,nu.email FROM net_users as nu , net_users_belong  as nub WHERE 
				nu.deleted=0 AND 
				nub.first_timer = '".$first_timers_status."' AND
				nub.net_user_id=nu.id AND
				nub.unk = '".UNK."' AND				
				nub.status=0 ".$moreQRY;
	$res = mysql_db_query(DB,$sql);
	
	
	$all_users = array();
	$all_emails = array();
	$all_users_ex = array();
	while( $data = mysql_fetch_array($res) )
	{
		if(!isset($all_emails[$data['email']])){
			$user_id = $data['id'];
			$all_users[$user_id] = "1";
			$all_emails[$data['email']] = '1';
		}
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
		if($first_timers_status == '0'){
			$sql = "UPDATE net_users_belong SET first_timer = 1 WHERE net_user_id = $user_id";
			$res = mysql_db_query(DB,$sql);
		}
	}
	
	echo "<META HTTP-EQUIV=Refresh CONTENT=\"0; URL=index.php?scope=net_massg_list&main=".$_POST['main']."&unk=".UNK."&sesid=".SESID."\">";
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
			echo "<a href='index.php?scope=net_massg_sendMail&past_sent=1&main=net_system&msg_id=".$_GET['msg_id']."&sesid=".SESID."&unk=".UNK."' class='maintext'><b>כן</b></a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a href='index.php?main=net_massg_list&type=net&msg_id=".$$_GET['msg_id']."&sesid=".SESID."&unk=".UNK."' class='maintext'><b>לא</b></a>";
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
		
		echo "<META HTTP-EQUIV=Refresh CONTENT=\"0; URL=index.php?scope=net_massg_list&main=".$_GET['main']."&unk=".UNK."&sesid=".SESID."\">";
	}
	
	
}


function net_list_import(){
	$import_from_unk = $_REQUEST['from_unk'];
	$sql = "SELECT * FROM net_users_belong WHERE unk = '$import_from_unk'";
	$users_res = mysql_db_query(DB,$sql);
	$user_ids = array();
	$existing_users_count = 0;
	$new_users_count = 0;
	$total_users_count = 0;
	while($net_user = mysql_fetch_array($users_res)){
		$check_sql = "SELECT net_user_id FROM net_users_belong WHERE unk = '".UNK."' AND net_user_id = ".$net_user['net_user_id'];
		$check_res = mysql_db_query(DB,$check_sql);
		$check_data = mysql_fetch_array($check_res);
		if(!isset($check_data['net_user_id'])){
			$insert_sql = "INSERT INTO net_users_belong(net_user_id,unk,status,sendMailActive,join_date,first_timer)
				values(".$net_user['net_user_id'].",'".UNK."',".$net_user['status'].",".$net_user['sendMailActive'].",NOW(),0)";
			$insert_res = mysql_db_query(DB,$insert_sql);
			$new_users_count++;
		}
		else{
			$existing_users_count++;
		}
		$total_users_count++;
	}
	echo "<script>alert('".$new_users_count." חברים הועברו בהצלחה \\n ".$existing_users_count." חברים כבר היו קיימים \\n  סך הכל ".$total_users_count." חברים');</script>";
	echo "<META HTTP-EQUIV=Refresh CONTENT=\"0; URL=index.php?scope=net_list&main=".$_GET['main']."&sesid=".SESID."\">";
}


function net_email_filter_list(){
	
	if(isset($_GET['email_remove'])){
		$sql = "DELETE FROM net_email_filter WHERE id=".$_GET['email_remove']."";
		$res = mysql_db_query(DB,$sql);
		echo "<script>alert('כתובת המייל הוסרה מרשימת הסינון');</script>";
		echo "<META HTTP-EQUIV=Refresh CONTENT=\"0; URL=index.php?scope=net_email_filter_list&main=net_system&sesid=".SESID."\">";
		return;
	}


	if(isset($_FILES['xls_file_import'])){
		$file_content = file_get_contents($_FILES['xls_file_import']['tmp_name']);
		$line_arr = explode("\n",$file_content);
		$rows_arr = array();
		$emils_arr = array();
		foreach($line_arr as $line){
			$rows_arr[] = explode("\t",$line);
		}
		foreach($rows_arr as $row_key=>$row){
			foreach($row as $col_key=>$col){
				$email = trim($col);
				if($email!=""){
					$emils_arr[] = $email;
				}
			}
		}
		$add_i = 0;
		$email_val_sql = "";
		foreach($emils_arr as $email){		
			if($add_i != 0){
				$email_val_sql.=",";
			}
			$email_val_sql.="('$email')";
			$add_i++;	
		}
		if($add_i != 0){
			$sql = "INSERT IGNORE INTO net_email_filter (email) VALUES $email_val_sql";
			$res = mysql_db_query(DB,$sql);
		}
		echo "<script>alert('כתובות המייל נוספו בהצלחה');</script>";
		echo "<META HTTP-EQUIV=Refresh CONTENT=\"0; URL=index.php?scope=net_email_filter_list&main=net_system&sesid=".SESID."\">";
		return;		
	}



	
	if(isset($_POST['emails_to_add'])){
		$emails_to_add_arr = explode(",",$_POST['emails_to_add']);
		$add_i = 0;
		$email_val_sql = "";
		foreach($emails_to_add_arr as $email_to_add){
			$email = trim($email_to_add);
			if($email != ""){
				if($add_i != 0){
					$email_val_sql.=",";
				}
				
				$email_val_sql.="('$email')";
				$add_i++;
			}
		}
		$sql = "INSERT IGNORE INTO net_email_filter (email) VALUES $email_val_sql";
		$res = mysql_db_query(DB,$sql);
		echo "<script>alert('כתובות המייל נוספו בהצלחה');</script>";
		echo "<META HTTP-EQUIV=Refresh CONTENT=\"0; URL=index.php?scope=net_email_filter_list&main=net_system&sesid=".SESID."\">";
		return;
	}	
	echo "<h3>רשימת תובעים סדרתיים</h3>";
	echo "
		<style type='text/css'>
			a.open{color:red;}
		</style>
		<script type='text/javascript'>
			function open_wrap(wrap_id,a_el){
				jQuery(function($){
					if($(a_el).hasClass('closed')){
						$(a_el).removeClass('closed');
						$(a_el).addClass('open');
						$('#'+wrap_id).show();
					}
					else{
						$(a_el).removeClass('open');
						$(a_el).addClass('closed');
						$('#'+wrap_id).hide();						
					}
				});
			}
		</script>
	";
	echo "<div><a href='javascript://' class='closed' onclick='open_wrap(\"mf_import_wrap\",this);'>ייבוא רשימת מיילים לסינון מקובץ אקסל</a></div>";
	echo "<div style='display:none;' id='mf_import_wrap'>";
		echo "<h3>ייבוא רשימת מיילים לסינון מקובץ אקסל</h3>";
		echo "<form action='index.php?scope=net_email_filter_list&main=net_system&sesid=".SESID."' enctype='multipart/form-data' name='conatct_search' method='POST'>";
			echo "<table border='0' cellspacing='0' cellpadding='5' class='maintext'>";
				echo "<tr>";
					echo "<td>העלאת קובץ</td>";
					echo "<td width='10'></td>";
					echo "<td><input type='file' name='xls_file_import' class='input_style'/></td>";
					echo "<td width='30'></td>";
					echo "<td></td>";
					echo "<td width='10'></td>";
					echo "<td><input type='submit' class='submit_style' value='שלח!' style='width: 80px;'></td>";
				echo "</tr>";
				echo "<tr><td colspan=7 height=5></td></tr>";			
			echo "</table>";					
		echo "</form>";	
	echo "</div><hr/>";
	echo "<div><a href='javascript://' class='closed' onclick='open_wrap(\"mf_addone_wrap\",this);'>הוספת כתובות מייל ידנית</a></div>";
	echo "<div style='display:none;' id='mf_addone_wrap'>";
		echo "<h3>הוספת כתובות מייל</h3>";
		echo "<form action='index.php?scope=net_email_filter_list&main=net_system&sesid=".SESID."' name='conatct_search' method='POST'>";
			echo "<table border='0' cellspacing='0' cellpadding='5' class='maintext'>";
				echo "<tr>";
					echo "<td>כתובות מייל(מופרד בפסיקים)</td>";
					echo "<td width='10'></td>";
					echo "<td><textarea style='text-align:left;direction:ltr;width: 300px; height: 153px;' name='emails_to_add' class='input_style'></textarea></td>";
					echo "<td width='30'></td>";
					echo "<td></td>";
					echo "<td width='10'></td>";
					echo "<td><input type='submit' class='submit_style' value='שלח!' style='width: 80px;'></td>";
				echo "</tr>";
				echo "<tr><td colspan=7 height=5></td></tr>";			
			echo "</table>";					
		echo "</form>";	
	echo "</div><hr/>";	
	echo "<h3>רשימת כתובות מייל לסינון</h3>";
	$email_sql = "SELECT * FROM net_email_filter WHERE 1";
	$email_res = mysql_db_query(DB,$email_sql);
	while($email_data = mysql_fetch_array($email_res)){
		echo "<div style='text-align:left;float:right; padding:5px; margin:5px; width:165px; height:38px; overflow:auto; border:1px solid black;'>";
			echo $email_data['email'];
			echo "<br/>";
			echo "<a href='index.php?scope=net_email_filter_list&main=net_system&email_remove=".$email_data['id']."&sesid=".SESID."' onclick = 'return confirm(\"האם אתה בטוח שברצונך להסיר אימייל זה מרשימת הסינון?\")'>לחץ כאן להסרה</a>";
		echo "</div>";
	}
}

function get_net_system_pagention( $params=array() )
{
	$limitInPage = $params['limitInPage'];
	$numRows = $params['numRows'];
	$limitcount = $params['limitcount'];
	$main = $params['main'];
	$scope = $params['scope'];
	
	echo "<table align=center border=0 cellspacing=\"0\" width=100% cellpadding=\"3\" class=\"maintext\">";
		
		if( $numRows > $limitInPage )
		{
			echo "<tr>";
				echo "<td align=center>";
				
					$z = 0;
					for($i=0 ; $i < $numRows ; $i++)
					{
						$pz = $z+1;
						
						if($i % $limitInPage == 0)
						{
								if( $i == $limitcount )
									$classi = "<strong style=\"color:#000000\">".$pz."</strong>&nbsp;&nbsp;";
								else
									$classi = "<a href='index.php?main=".$main."&scope=".$scope."&sesid=".SESID."&limit=".$i."' class='maintext'>".$pz."</a>&nbsp;&nbsp;";
								
								echo $classi;
								
								$z = $z + 1;
						}
					}
				echo "</td>";
			echo "</tr>";
		}
	echo "</table>";
}

function net_xls_import(){
	if(isset($_SESSION['uploaded_users'])){
		if(isset($_GET['cancel_users'])){
			unset($_SESSION['uploaded_users']);
			echo "<script>alert('העלאת קובץ בוטלה');</script>";
			echo "<META HTTP-EQUIV=Refresh CONTENT=\"0; URL=index.php?scope=net_xls_import&main=net_system&sesid=".SESID."\">";
			return;
		}
		if(isset($_GET['save_users'])){
			$report_array = array();
			$session_users = $_SESSION['uploaded_users'];
			unset($_SESSION['uploaded_users']);
			foreach($session_users as $new_user){
				$email = $new_user['Email'];
				$user_report_array = array('email'=>$email,'exists'=>'חדש','belong'=>'חדש','reg_unk'=>UNK);
				$name = $new_user['Full_name'];
				$name_arr = explode(" ",$name);
				$fname = $name_arr[0];
				$lname = "";
				if(isset($name_arr[1])){
					$lname.= $name_arr[1];
				}
				if(isset($name_arr[2])){
					$lname.= " ".$name_arr[2];
				}
				if(isset($name_arr[3])){
					$lname.= " ".$name_arr[3];
				}
				$city = $new_user['City'];
				$mobile = $new_user['Mobile'];
				$birthday = $new_user['Birthday'];
				//check if email exists
				$sql = "SELECT * FROM net_users WHERE email='$email'";
				$res = mysql_db_query(DB,$sql);
				$id_data = mysql_fetch_array($res);
				$user_id = false;
				$user_exists = false;
				$user_belong = false;
				if(isset($id_data['id'])){
					$user_id = $id_data['id'];
					$user_exists = true;
				}
				else{
					$ss1  = time("H:m:s",1000000000);
					$ss2 = $email;
					$sesid = $ss2.$ss1;
					
					$unick_ses = md5($sesid);
					$sql = "INSERT INTO net_users(reg_unk,fname,lname,birthday,city,email,mobile,date_in,verify,unick_ses) 
							VALUES('".UNK."','$fname','$lname','$birthday','$city','$email','$mobile',now(),1,'$unick_ses')";
					$res = mysql_db_query(DB,$sql);
					$user_id = mysql_insert_id();
				}
				if($user_exists){
					$sql = "SELECT unk FROM net_users_belong WHERE net_user_id='$user_id' AND unk = '".UNK."'";
					$res = mysql_db_query(DB,$sql);
					$unk_data = mysql_fetch_array($res);
					if(isset($unk_data['unk'])){
						$user_belong = true;
					}
					$user_report_array['exists']='רשום';
					$user_report_array['reg_unk'] = $id_data['reg_unk'];
				}
				if(!$user_belong){
					$net_user_id = $user_id;
					$unk = UNK;
					$status = '0';
					$sendMailActive = '0';
					$first_timer = '0';
					if($user_exists){
						$belong_sql = "SELECT * FROM net_users_belong WHERE net_user_id='$user_id' AND unk = '".$id_data['reg_unk']."'";
						$belong_res = mysql_db_query(DB,$belong_sql);
						$belong_data = mysql_fetch_array($belong_res);
						if(isset($belong_data['unk'])){
							$status = $belong_data['status'];
							$sendMailActive = $belong_data['sendMailActive'];
						}
					}
					$reg_sql = "INSERT INTO net_users_belong(net_user_id,unk,status,sendMailActive,join_date,first_timer) VALUES('$net_user_id','$unk','$status','$sendMailActive',now(),'$first_timer')";
					$reg_res = mysql_db_query(DB,$reg_sql);
					$reg_data = mysql_fetch_array($reg_res);
				}
				else{
					$user_report_array['belong'] = 'היה משוייך';
				}
				$report_array[] = $user_report_array;
			}
			
			echo "<h3>הייבוא בוצע בהצלחה</h3>";
			echo "<table border='1' cellspacing='0' cellpadding='5' class='maintext'>";
				echo "<tr>";
					echo "<th>אימייל</th>";
					echo "<th>משתמש קיים\חדש</th>";
					echo "<th>משתמש משוייך\חדש</th>";
					echo "<th>UNK הרשמה</th>";
				echo "</tr>";
				
				foreach($report_array as $user_import){
					echo "<tr>";
						echo "<td>".$user_import['email']."</td>";
						echo "<td>".$user_import['exists']."</td>";
						echo "<td>".$user_import['belong']."</td>";
						echo "<td>".$user_import['reg_unk']."</td>";
					echo "</tr>";
				}	
			echo "</table>";
			
			return;
		}
		$session_users = $_SESSION['uploaded_users'];
		$city_sql = "SELECT * FROM cities";
		$city_res = mysql_db_query(DB,$city_sql);
		$city_names = array();
		while($city_data = mysql_fetch_array($city_res)){
			$city_names[$city_data['id']] = $city_data['name'];
		}		
		echo "<h3>העלאת משתמשים מקובץ</h3>";
		echo "<div style='color:red;font-weight:bold'>במידה והרשימה לא תקינה, בדוק את הקובץ, לחץ על ביטול ונסה להעלות שוב.</div>";
		echo "<table border='0' cellspacing='0' cellpadding='5' class='maintext'>";
		echo "<tr>";
			echo "<td><a style='font-size:18px;' href='index.php?scope=net_xls_import&main=net_system&cancel_users=1&sesid=".SESID."'>לחץ כאן לביטול<a/></td>";
			echo "<td width='15'></td>";
			echo "<td><a style='font-size:18px;' style='' href='index.php?scope=net_xls_import&main=net_system&save_users=1&sesid=".SESID."'>לחץ כאן לאישור ושמירה<a/></td>";
		echo "</tr>";
		echo "<table border='1' cellspacing='0' cellpadding='5' class='maintext'>";
			echo "<tr>";
				echo "<th>שם מלא</th>";
				echo "<th>יום הולדת</th>";
				echo "<th>עיר</th>";
				echo "<th>אימייל</th>";
				echo "<th>מובייל</th>";
			echo "</tr>";
			foreach($session_users as $new_user){
				$city_name = "";
				if($new_user['City'] != "" && $new_user['City'] != "-1"){
					$city_name = $city_names[$new_user['City']];
				}
				if($new_user['City'] == "-1"){
					$city_name = "<span style='color:red;'>שם העיר לא נקלט</span>";
				}
				echo "<tr>";
					echo "<td>".$new_user['Full_name']."</td>";
					echo "<td>".$new_user['Birthday']."</td>";
					echo "<td>".$city_name."</td>";
					echo "<td>".$new_user['Email']."</td>";
					echo "<td>".$new_user['Mobile']."</td>";
				echo "</tr>";
			}
		echo "</table>";
		
		return;
	}
	
	if(isset($_FILES['xls_file'])){
		$file_content = file_get_contents($_FILES['xls_file']['tmp_name']);
		$line_arr = explode("\n",$file_content);
		$rows_arr = array();
		$users_arr = array();
		foreach($line_arr as $line){
			$rows_arr[] = explode("\t",$line);
		}
		$row_arr_h = $rows_arr[0];
		foreach($rows_arr as $row_key=>$row){
			if($row_key!=0){
				$user_arr = array();
				foreach($row as $col_key=>$col){
					if($row_arr_h[$col_key]!=""){
						$user_arr[$row_arr_h[$col_key]] = $col;
					}
				}
				$users_arr[] = $user_arr;
			}
		}
		$city_sql = "SELECT * FROM cities";
		$city_res = mysql_db_query(DB,$city_sql);
		$city_by_name = array();
		while($city_data = mysql_fetch_array($city_res)){
			$city_by_name[$city_data['name']] = $city_data['id'];
		}		
		$sesstion_users = array();
		foreach($users_arr as $user){
			$user_city = "";
			if($user['City'] != ""){
				$city_name = net_upload_enco($user['City']);
				if(isset($city_by_name[$city_name])){
					$user_city = $city_by_name[$city_name];
				}
				else{
					$user_city = '-1';
					echo $user['City'].$city_name.$user['Email'];
					
				}
			}
			if($user['Email'] != ""){
				$session_user = array(
					'Full_name'=>net_upload_enco($user['Full name']),
					'Birthday'=>net_upload_enco($user['Birthday']),
					'City'=>$user_city,
					'Email'=>net_upload_enco($user['Email']),
					'Mobile'=>net_upload_enco($user['Mobile']),
				);
				$sesstion_users[] = $session_user;
			}
		}
		$_SESSION['uploaded_users'] = $sesstion_users;
		echo "<META HTTP-EQUIV=Refresh CONTENT=\"0; URL=index.php?scope=net_xls_import&main=net_system&sesid=".SESID."\">";
		return;
	}
	echo "<h3>ייבוא משתמשים בקובץ אקסל</h3>";
	echo "<form action='index.php?scope=net_xls_import&main=net_system&sesid=".SESID."' enctype='multipart/form-data' name='conatct_search' method='POST'>";
		echo "<table border='0' cellspacing='0' cellpadding='5' class='maintext'>";
			echo "<tr>";
				echo "<td>העלאת קובץ</td>";
				echo "<td width='10'></td>";
				echo "<td><input type='file' name='xls_file' class='input_style'/></td>";
				echo "<td width='30'></td>";
				echo "<td></td>";
				echo "<td width='10'></td>";
				echo "<td><input type='submit' class='submit_style' value='שלח!' style='width: 80px;'></td>";
			echo "</tr>";
			echo "<tr><td colspan=7 height=5></td></tr>";			
		echo "</table>";					
	echo "</form>";	
}

function net_upload_enco($str)
{
	return iconv( "UTF-8","windows-1255", $str);
}
?>