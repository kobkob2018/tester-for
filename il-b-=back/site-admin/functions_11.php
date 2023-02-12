<?php

function launch_fee_to_client()
{
	$sql = "SELECT id, name, email FROM users WHERE unk = '".$_REQUEST['unk']."' ";
	$res = mysql_db_query(DB,$sql);
	$dataUser = mysql_fetch_array($res);
	
	$endDate = date("d-m-Y", mktime(0,0,0, date('m')+1 , date('d') , date('Y') ) );
	
	echo "<table border=\"0\" cellspacing=\"0\" cellpadding=\"0\" class=\"maintext\">";
		echo "<tr>";
			echo "<td>";
				echo "<form action='index.php' name='launch_fee_form' method='post' style='padding: 0px; margin: 0px;' >";
				echo "<input type='hidden' name='main' value='launch_fee_to_client_DB'>";
				echo "<input type='hidden' name='unk' value='".$_REQUEST['unk']."'>";
				echo "<input type='hidden' name='sesid' value='".SESID."'>";
				echo "<table border=\"0\" cellspacing=\"0\" cellpadding=\"0\" class=\"maintext\">";
					
					echo "<tr>";
						echo "<td colspan=3>שגר תשלום ללקוח <b>".stripslashes($dataUser['name'])."</b></td>";
					echo "</tr>";
					echo "<tr><td colspan=3 height=7></tr>";
					
					echo "<tr>";
						echo "<td>מחיר כולל מע\"מ</td>";
						echo "<td width=10></td>";
						echo "<td><input type='text' name='price' class='input_style'></td>";
					echo "</tr>";
					echo "<tr><td colspan=3 height=7></tr>";
					echo "<tr>";
						echo "<td valign=top>פירוט התשלום</td>";
						echo "<td width=10></td>";
						echo "<td>";
							echo "<textarea name='details' class='input_style' cols='' rows='' style='height:100px;'></textarea> <br>הפרדה בין תשלום לתשלום תעשה על ידי , (פסיק)<br>לחיצה על אנטר להפרדה רק תשבש את המערכת<br>מוגבל ל 250 תווים";
						echo "</td>";
					echo "</tr>";
					echo "<tr><td colspan=3 height=7></tr>";
					echo "<tr>";
						echo "<td>עד תשלומים</td>";
						echo "<td width=10></td>";
						echo "<td>";
							echo "<select name='tash' class='input_style'>";
								for( $i=1 ; $i<=12 ; $i++ )
									echo "<option value='".$i."'>".$i."</option>";
							echo "</select>";
						echo "</td>";
					echo "</tr>";
					echo "<tr><td colspan=3 height=7></tr>";
					echo "<tr>";
						echo "<td>שליחת הודעה תשלום לאימייל:</td>";
						echo "<td width=10></td>";
						echo "<td><input type='text' name='email_to_send' value='".stripslashes($dataUser['email'])."' class='input_style'></td>";
					echo "</tr>";
					echo "<tr><td colspan=3 height=7></tr>";
					echo "<tr>";
						echo "<td>תאריך אחרון לתשלום</td>";
						echo "<td width=10></td>";
						echo "<td><input type='text' name='until_date' value='".$endDate."' class='input_style'></td>";
					echo "</tr>";
					echo "<tr><td colspan=3 height=7></tr>";
					echo "<tr>";
						echo "<td></td>";
						echo "<td width=10></td>";
						echo "<td align=left><input type='submit' value='שלח!' class='submit_style'></td>";
					echo "</tr>";
				echo "</table>";
				echo "</form>";
			echo "</td>";
		echo "</tr>";
		
		echo "<tr><td colspan=3 height=15></tr>";
		
		$sql = "SELECT lf.*, DATE_FORMAT(lf.until_date,'%d-%m-%Y') as untilDate , pay.payGood FROM ilbiz_launch_fee AS lf LEFT JOIN ilbizPayByCCLog as pay ON lf.order_id = pay.id WHERE unk = '".$_REQUEST['unk']."' ORDER BY lf.id DESC";
		$res = mysql_db_query(DB,$sql);
		
		echo "<tr>";
			echo "<td>";
				echo "<table border=\"0\" cellspacing=\"0\" cellpadding=\"0\" class=\"maintext\">";
					
					echo "<tr>";
						echo "<td colspan=7>היסטורית תשלומים של הלקוח <b>".stripslashes($dataUser['name'])."</b></td>";
					echo "</tr>";
					echo "<tr><td colspan=7 height=7></tr>";
					echo "<tr>";
						echo "<td><b>מחיר כולל מע\"מ</b></td>";
						echo "<td width=10></td>";
						echo "<td><b>פרטים</b></td>";
						echo "<td width=10></td>";
						echo "<td><b>תשלום עד תאריך</b></td>";
						echo "<td width=10></td>";
						echo "<td><b>שולם בהצלחה?</b></td>";
						echo "<td width=10></td>";
						echo "<td></td>";
					echo "</tr>";
					
					while( $data = mysql_fetch_array($res) )
					{
						switch($data['payGood'])
						{
							case "" :
							case "0" : $payGood = "לא בוצע תשלום";	break;
							case "1" : $payGood = "תשלום נכשל";	break;
							case "2" : $payGood = "תשלום בוצע בהצלחה";	break;
						}
						
						$tr_Style = ( $data['deleted'] == "1" ) ? "style='text-decoration:line-through'" : "";
						
						echo "<tr><td colspan=7 height=7></tr>";
						echo "<tr ".$tr_Style.">";
							echo "<td>".$data['price']."</td>";
							echo "<td width=10></td>";
							echo "<td>".stripslashes($data['details'])."</td>";
							echo "<td width=10></td>";
							echo "<td>".$data['untilDate']."</td>";
							echo "<td width=10></td>";
							echo "<td>".$payGood."</td>";
							echo "<td width=10></td>";
							echo "<td>";
								if( $data['payGood'] != "2" )
									echo "<a href='index.php?main=launch_fee_deleted&fee_id=".$data['id']."&unk=".$_GET['unk']."&sesid=".SESID."' class='maintext' onclick=\"return can_i_del()\">מחיקת החוב</a>";
								else
									echo "לא ניתן למחוק תשלום שבוצע";
							echo "</td>";
						echo "</tr>";
					}
				echo "</table>";
			echo "</td>";
		echo "</tr>";
	echo "</table>";
	

	
}


function launch_fee_to_client_DB()
{
	$untilDate1 = explode("-",$_POST['until_date']);
	$untilDate = $untilDate1[2]."-".$untilDate1[1]."-".$untilDate1[0];
	
	$uniqueSes = md5($_SERVER[REMOTE_ADDR]."-".date('dmyHis'));
	$sql = "INSERT INTO ilbiz_launch_fee ( owner_id , unk , price , tash , details , until_date , email_to_send , uniqueSes ) VALUES (
		'".OID."' , '".$_POST['unk']."' , '".addslashes($_POST['price'])."' , '".addslashes($_POST['tash'])."' , '".addslashes($_POST['details'])."' , 
		'".$untilDate."' , '".addslashes($_POST['email_to_send'])."' , '".$uniqueSes."' )";
	$res = mysql_db_query(DB,$sql);
	
	if( $_POST['email_to_send'] != "" )
	{
		$fullmsg='<html dir="rtl">
			<head dir="rtl">
			<meta http-equiv="Content-Type" content="text/html; charset=windows-1255">
			</head>
			<body>
			שלום רב,<br><br>
			קיבלת הודעת תשלום עבור: '.$_POST['details'].' על סך '.$_POST['price'].' ש"ח כולל מע"מ.<br><br>
			<a href="http://www.ilbiz.co.il/ClientSite/administration/pay.php?uniqueSes='.$uniqueSes.'"><u>לחץ כאן</u></a> בתשלום מיידי בכרטיס אשראי.<br><br>
			בברכה,<br>
			איי אל ביז קידום עסקים באינטרנט בע"מ
			</body>
			</html>';
		
		    $headers  = "MIME-Version: 1.0\r\n";
		    $headers .= "Content-type: text/html; charset=windows-1255-1\r\n";
		    $headers .= "From:ilan@il-biz.com<ilan@il-biz.com>\r\n";
			
			$fromEmail = "ilan@il-biz.com";
			$fromTitle = 'איי אל ביז קידום עסקים באינטרנט בע"מ';
			$header_send_to_Client = "בקשה לתשלום אוטומטי";
			$content_send_to_Client = $fullmsg;
			$ClientMail = $_POST['email_to_send'];
			
			GlobalFunctions::send_emails_with_phpmailer($fromEmail, $fromTitle, $header_send_to_Client, $content_send_to_Client, $content_send_to_Client, $ClientMail, $fromTitle );
			//mail($_POST['email_to_send'],"בקשה לתשלום אוטומטי", $fullmsg, $headers );
	}
	
	echo "<script>window.location.href='index.php?main=launch_fee_to_client&unk=".$_POST['unk']."&sesid=".SESID."';</script>";
		exit;
}

function launch_fee_deleted()
{
	$sql = "UPDATE ilbiz_launch_fee SET deleted=1 WHERE id = '".$_GET['fee_id']."' ";
	$res = mysql_db_query(DB,$sql);
	
	echo "<script>window.location.href='index.php?main=launch_fee_to_client&unk=".$_GET['unk']."&sesid=".SESID."';</script>";
		exit;
}

function user_advanced_settings()
{
	if($_REQUEST['unk'] != "" )	{
		$owner_id = ( AUTH >= "8" ) ? "" : " and owner_id = '".OID."'"; 
		$sql = "select * from users where deleted = '0' and unk = '".$_REQUEST['unk']."' ".$owner_id."";
		$res = mysql_db_query(DB,$sql);
		$data = mysql_fetch_array($res);
		
		if( $data['id'] != "" )
		{
			$sql_extra_settings = "select * from user_extra_settings where unk = '".$_REQUEST['unk']."'";
			$res_extra_settings = mysql_db_query(DB,$sql_extra_settings);
			$user_extra_settings = mysql_fetch_array($res_extra_settings);
		}
	}
	
	$site_width['775'] = "775";
	$site_width['990'] = "990";
	$site_width['1280'] = "1280";
	
	
	$right_menu_width['150'] = "150";
	$right_menu_width['180'] = "180";
	$right_menu_width['200'] = "200";
	$right_menu_width['230'] = "230";
	$right_menu_width['250'] = "250";
	
	$left_menu_width['150'] = "150";
	$left_menu_width['180'] = "180";
	$left_menu_width['200'] = "200";
	$left_menu_width['220'] = "220";
	$left_menu_width['250'] = "250";
	
	$left_menu_active[0] = "לא";
	$left_menu_active[1] = "כן";
	
	$top_slice_html_up_active[0] = "לא";
	$top_slice_html_up_active[1] = "כן";
	
	$links_menu_more_settings_active[0] = "לא";
	$links_menu_more_settings_active[1] = "כן";
	
	$menu_links_father_place[0] = "כל הקישורים מוצגים יחד - המשוייכים עם רווח מהצד";
	$menu_links_father_place[1] = "המשוייכים נסתרים, בעת לחיצה על הראשי נפתחים המשוייכים עם רווח המצד";
	$menu_links_father_place[2] = "המשוייכים נסתרים, רק שנכנסים לראשי - כל התפריט מתחלף ומופיע רק הנסתרים של הראשי";
	
	
	$form_arr = array(
		array("hidden","main","user_advanced_settings_DB"),
		array("hidden","record_id",$user_extra_settings['id']),
		array("hidden","sesid",SESID),
		array("hidden","unk",$_REQUEST['unk']),
		
		
		array("select","site_width[]",$site_width,"רוחב האתר",$user_extra_settings['site_width'],"data_arr[site_width]", "class='input_style'"),
		
		array("blank","<br><b>ההגדרות הבאות תקפות לרוחב מעל 775</b>"),
		
		array("select","right_menu_width[]",$right_menu_width,"רוחב תפריט ימני",$user_extra_settings['right_menu_width'],"data_arr[right_menu_width]", "class='input_style'"),
		array("select","left_menu_active[]",$left_menu_active,"רוחב שמאלי פעיל?",$user_extra_settings['left_menu_active'],"data_arr[left_menu_active]", "class='input_style'"),
		array("select","left_menu_width[]",$left_menu_width,"רוחב תפריט שמאלי",$user_extra_settings['left_menu_width'],"data_arr[left_menu_width]", "class='input_style'"),
		array("select","top_slice_html_up_active[]",$top_slice_html_up_active,"הגדרות מתקדמות לסלייס עליון?",$user_extra_settings['top_slice_html_up_active'],"data_arr[top_slice_html_up_active]", "class='input_style'"),
		
		array("blank","<br><b>הגדרות לתפריט קישורים</b>"),
		
		array("select","links_menu_more_settings_active[]",$links_menu_more_settings_active,"הגדרות מתקדמות לתפריט קישורים צידי?",$user_extra_settings['links_menu_more_settings_active'],"data_arr[links_menu_more_settings_active]", "class='input_style'"),
		
		array("text","data_arr[links_menu_right_spacing]",$user_extra_settings['links_menu_right_spacing'],"מרווח קישורים מצד ימין", "class='input_style'"),
		array("text","data_arr[links_menu_left_spacing]",$user_extra_settings['links_menu_left_spacing'],"מרווח קישורים מצד שמאל", "class='input_style'"),
		array("text","data_arr[links_menu_bottom_spacing]",$user_extra_settings['links_menu_bottom_spacing'],"מרווח קישורים מלמטה", "class='input_style'"),
		array("select","menu_links_father_place[]",$menu_links_father_place,"אופן תצוגת קישורים המשוייכים לקישור",$user_extra_settings['menu_links_father_place'],"data_arr[menu_links_father_place]", "class='input_style'"),
		
		array("submit","submit","שמירה", "class='submit_style'")
	);
	
// שדות חובה
$more = "class='maintext'";

echo "<table border=\"0\" cellspacing=\"0\" cellpadding=\"0\" class=\"maintext\">";
		
		echo "<tr>";
			echo "<td><A href=\"?&sesid=".SESID."\" class=\"maintext\">חזרה לתפריט הראשי</a></td>";
		echo "</tr>";
		
		echo "<tr><td height=\"7\"></td></tr>";
		echo "<tr>";
			echo "<td><A href=\"?main=update_set_colors&unk=".$_REQUEST['unk']."&record_id=".$data['id']."&sesid=".SESID."\" class=\"maintext\">חזרה לטופס עיצוב יחודי</a></td>";
		echo "</tr>";
		
		echo "<tr><td height=\"11\"></td></tr>";
		
		echo "<tr>";
			echo "<td>".FormCreator::create_form($form_arr,"index.php", $more, $mandatory_fields)."</td>";
		echo "</tr>";
		
		
	echo "</table>";
	
}

function user_advanced_settings_DB()
{
	
	$image_settings = array(
		after_success_goto=>"index.php?main=user_advanced_settings&unk=".$_POST['unk']."&sesid=".SESID,
		table_name=>"user_extra_settings",
	);
	update_db($_POST['data_arr'], $image_settings);
	
}



function centered_contact()
{
	$sql = "SELECT unk FROM user_extra_settings WHERE centered_contact = 1";
	$res = mysql_db_query(DB,$sql);
	$search_sql = "";
	$search_phone = "";
	$search_name = "";
	$search_email = "";
	if(isset($_GET['phone']) && $_GET['phone']!=""){
		$search_sql.= " AND phone LIKE('%".$_GET['phone']."%') ";
		$search_phone = $_GET['phone'];
	}
	if(isset($_GET['name']) && $_GET['name']!=""){
		$search_sql.= " AND name LIKE('%".$_GET['name']."%') ";
		$search_name = $_GET['name'];
	}	
	if(isset($_GET['email'])  && $_GET['email']!=""){
		$search_sql.= " AND email LIKE('%".$_GET['email']."%') ";
		$search_email = $_GET['email'];
	}
	$start_date = date('d-m-Y', strtotime($Date. ' - 2 day'));
	if(isset($_GET['s_date'])  && $_GET['s_date']!=""){
		$start_date = $_GET['s_date'];
	}
	
	$s_date_arr = explode("-",$start_date);
	$s_date = trim($s_date_arr[2])."-".trim($s_date_arr[1])."-".trim($s_date_arr[0]);
	$search_sql.= " AND date_in >='".$s_date."' ";
	$search_s_date = $start_date;

	if(isset($_GET['e_date'])  && $_GET['e_date']!=""){
		$e_date_arr = explode("-",$_GET['e_date']);
		$e_date_day = trim($e_date_arr[0]);
		$e_date_day = $e_date_day+1;
		$e_date = trim($e_date_arr[2])."-".trim($e_date_arr[1])."-".$e_date_day;
		$search_sql.= " AND date_in <='".$e_date."' ";
		$search_e_date = $_GET['e_date'];
	}
	$free_search_val = "";
	if(isset($_GET['free_search_val'])){
		$free_search_val = $_GET['free_search_val'];
		$search_sql.= " AND ( ( name LIKE '%".mysql_r_e_s($_GET['free_search_val'])."%' ) OR ( content LIKE '%".mysql_r_e_s($_GET['free_search_val'])."%' ) )";
	}
	
	$unks = "";
	while( $data = mysql_fetch_array($res) )
		$unks .= "'".$data['unk']."',";
	
	$new_unk = substr( $unks , 0 , -1 );
	
	$status = ( $_GET['status'] == "" ) ? "0" :  $_GET['status'];
	$temp_status = $status;
	$temp_var = "bols_s_".$temp_status;
	$temp_var2 = "bols_e_".$temp_status;
	$$temp_var = ( $status	== $temp_status  ) ? "<b>" : "";
	$$temp_var2 = ( $status	== $temp_status  ) ? "</b>" : "";
	
	$unk_in_sql = " AND unk IN (".$new_unk.") ";
	$centered_filter_remove_checked = "";
	if(isset($_GET['centered_filter_remove'])){
		if($_GET['centered_filter_remove']=='1'){
			$unk_in_sql = "  ";
			$centered_filter_remove_checked = " checked ";
		}
	}
	$status_where_sql = "";
	if($status!='all'){
		
		$status_where_sql.= " AND status = '".$status."' ";
	}	
	$sql = "select * from user_contact_forms where 1 ".$unk_in_sql." AND deleted=0 ".$status_where_sql." ".$search_sql."  order by id DESC";
	
	$res = mysql_db_query(DB,$sql);
	
	echo "<table border=\"0\" cellspacing=\"0\" cellpadding=\"0\" class=\"maintext\">";
		
		echo "<tr>";
			echo "<td colspan=13><A href=\"?&sesid=".SESID."\" class=\"maintext\">חזרה לתפריט הראשי</a></td>";
		echo "</tr>";
		echo "<tr><td height=5 colspan=13></td></tr>";
		echo "<tr>";
			echo "<td colspan=13>";
				echo "<table border=\"0\" cellspacing=\"0\" cellpadding=\"0\" class=\"maintext\">";
					echo "<tr>";
						echo "<td valign=top><a href='index.php?main=centered_contact&status=0&sesid=".$_GET['sesid']."' class='maintext'>".$bols_s_0."מתעניין חדש".$bols_e_0."</a></td>";
						echo "<td width='15'></td>";
						echo "<td valign=top><a href='index.php?main=centered_contact&status=1&sesid=".$_GET['sesid']."' class='maintext'>".$bols_s_1."נוצר קשר".$bols_e_4."</a></td>";
						echo "<td width='15'></td>";
						echo "<td valign=top><a href='index.php?main=centered_contact&status=5&sesid=".$_GET['sesid']."' class='maintext'>".$bols_s_5."מחכה לטלפון".$bols_e_5."</a></td>";
						echo "<td width='15'></td>";
						echo "<td valign=top><a href='index.php?main=centered_contact&status=2&sesid=".$_GET['sesid']."' class='maintext'>".$bols_s_2."סגירה עם לקוח".$bols_e_2."</a></td>";
						echo "<td width='15'></td>";
						echo "<td valign=top><a href='index.php?main=centered_contact&status=3&sesid=".$_GET['sesid']."' class='maintext'>".$bols_s_3."לקוחות רשומים".$bols_e_3."</a></td>";
						echo "<td width='15'></td>";
						echo "<td valign=top><a href='index.php?main=centered_contact&status=4&sesid=".$_GET['sesid']."' class='maintext'>".$bols_s_4."לא רלוונטי".$bols_e_4."</a></td>";
						echo "<td width='15'></td>";
						echo "<td valign=top><a href='index.php?main=centered_contact&status=all&sesid=".$_GET['sesid']."' class='maintext'>".$bols_s_all."הכל".$bols_e_all."</a></td>";						
					echo "</tr>";
				echo "</table>";
			echo "</td>";
		echo "</tr>";
		echo "<tr><td height=5 colspan=13><hr/></td></tr>";


		echo "<tr><td height=5 colspan=13>חיפוש מתקדם</td></tr>";
		echo "<tr>";
			echo "<td colspan=13>";
				echo "<form action='index.php' method='GET'>";
				echo "<input type='hidden' name='main' value='centered_contact' />";
				echo "<input type='hidden' name='sesid' value='".$_GET['sesid']."' />";
				echo "<table border=\"0\" cellspacing=\"0\" cellpadding=\"0\" class=\"maintext\">";
					echo "<tr>";
						echo "<td valign=top>מתאריך: <input name='s_date' type='text' value='".$search_s_date."' /></td>";
						echo "<td width='15'></td>";					
						
						echo "<td valign=top>עד תאריך: <input name='e_date' type='text' value='".$search_e_date."' /></td>";
						echo "<td width='15'></td>";						
						
						echo "<td valign=top>סטטוס: <select name='status'>";
							$searchAll = ( $_GET['status'] == "all" ) ? "selected" : "";
							$search0 = ( $_GET['status'] == "0" ) ? "selected" : "";
							$search1 = ( $_GET['status'] == "1" ) ? "selected" : "";
							$search5 = ( $_GET['status'] == "5" ) ? "selected" : "";
							$search2 = ( $_GET['status'] == "2" ) ? "selected" : "";
							$search3 = ( $_GET['status'] == "3" ) ? "selected" : "";
							$search4 = ( $_GET['status'] == "4" ) ? "selected" : "";
							echo "<option value='all' ".$searchAll.">הכל</option>";
							echo "<option value='0' ".$search0.">מתעניין חדש</option>";
							echo "<option value='1' ".$search1.">נוצר קשר</option>";
							echo "<option value='5' ".$search5.">מחכה לטלפון</option>";
							echo "<option value='2' ".$search2.">סגירה עם לקוח</option>";
							echo "<option value='3' ".$search3.">לקוחות רשומים</option>";
							echo "<option value='4' ".$search4.">לא רלוונטי</option>";
						echo "</select></td>";
						echo "<td width='15'></td>";
						
						
						echo "<td valign=top>טלפון: <input name='phone' type='text' value='".$search_phone."' /></td>";
						echo "<td width='15'></td>";
						echo "<td valign=top>שם: <input name='name' type='text' value='".$search_name."' /></td>";
						echo "<td width='15'></td>";
						echo "<td valign=top>אימייל: <input name='email' type='text' value='".$search_email."' /></td>";
						echo "<td width='15'></td>";
						
						echo "<td valign=bottom><input type='submit' value='חפש' /></td>";
						echo "<td width='15'></td>";						
					echo "</tr>";
					echo "<tr>";				
						echo "<td valign=top>חיפוש חפשי<input name='free_search_val' type='text' value='$free_search_val' /></td>";
						echo "<td width='15'></td>";		
						echo "<td valign=bottom><input name='centered_filter_remove' type='checkbox' value='1' $centered_filter_remove_checked/>בטל סינון לקוחות מסומנים</td>";
					echo "</tr>";
				echo "</table>";
				echo "</form>";
			echo "</td>";
		echo "</tr>";
		echo "<tr><td height=5 colspan=13><hr/></td></tr>";		
		
		
		echo "<tr>";
			echo "<td><b>תאריך שליחה</b></td>";
			echo "<td width=10></td>";
			echo "<td><b>דומיין</b></td>";
			echo "<td width=10></td>";
			echo "<td><b>שם</b></td>";
			echo "<td width=10></td>";
			echo "<td><b>אימייל</b></td>";
			echo "<td width=10></td>";
			echo "<td><b>טלפון</b></td>";

			echo "<td width=10></td>";			
			echo "<td><b>תוכן</b></td>";
			echo "<td width=10></td>";
			echo "<td align=left>העברת נבחרים לסטטוס: ";
					echo "<select id='mass_action_new_status' name='mass_action_new_status' class='input_style' style='width: 100px;'>";
						echo "<option value=''>בחירה</option>";
						echo "<option value='0'>מתעניין חדש</option>";
						echo "<option value='1'>נוצר קשר</option>";
						echo "<option value='5'>מחכה לטלפון</option>";
						echo "<option value='2'>סגירה עם לקוח</option>";
						echo "<option value='3'>לקוחות רשומים</option>";
						echo "<option value='4'>לא רלוונטי</option>";
					echo "</select>";
					echo "<br/><br/><br/>";
					echo " בחר הכל<input type='checkbox' id='selected_all_helper' name='selected_all_helper' value=''>";
					echo "<form action='index.php' id='status_all_selected_form' name='status_all_selected' method='post'>";
						echo "<input type='hidden' name='main' value='centered_contact_DB'>";
						echo "<input type='hidden' name='sesid' value='".SESID."'>";
						echo "<input type='hidden' name='reco_id' value='all_selected'>";
						echo "<input type='hidden' id='mass_action_selected_status' name='new_status' value=''>";
						echo "<input type='hidden' name='status' value='".$_REQUEST['status']."'>";
						
					echo "</form>";					
			echo "</td>";			
		echo "</tr>";

		echo "
		
			<script type='text/javascript'>
				jQuery('#selected_all_helper').change(
					function(){
						if(jQuery(this).attr('checked')){
							jQuery('.mass_action_selected_status').attr('checked', true);
						}
						else{
							jQuery('.mass_action_selected_status').attr('checked', false);
						}
					}
				);
				jQuery('#mass_action_new_status').change(function(){
					if(confirm('האם אתה בטוח שברצונך לשנות סטטוס לכל הנבחרים?')){
						var new_val = jQuery(this).val();
						jQuery('#mass_action_selected_status').val(new_val);
						jQuery('.mass_action_selected_status:checked').each(
							function(){
								var input_clone = jQuery(this).clone();
								jQuery(input_clone).attr('type','hidden');
								input_clone.appendTo('#status_all_selected_form');
								jQuery('#status_all_selected_form').submit();
							}
						);
					}
				});
			</script>
		";
		while( $data = mysql_fetch_array($res) )
		{
			$sql = "SELECT domain,name,full_name FROM users where unk='".$data['unk']."' ";
			$res2 = mysql_db_query(DB,$sql);
			$dataUsers = mysql_fetch_array($res2);
			
			$date_in = explode( " " , $data['date_in'] );
			$date_in2 = explode( "-" , $date_in[0] );
			
			$selected0 = ( $data['status'] == "0" ) ? "selected" : "";
			$selected1 = ( $data['status'] == "1" ) ? "selected" : "";
			$selected5 = ( $data['status'] == "5" ) ? "selected" : "";
			$selected2 = ( $data['status'] == "2" ) ? "selected" : "";
			$selected3 = ( $data['status'] == "3" ) ? "selected" : "";
			$selected4 = ( $data['status'] == "4" ) ? "selected" : "";
			$mark = "";
			$from_form_mark = "";
			$from_form_str = "";
			if($data['markMsg'] == "1"){
				$mark = "style='background: yellow'";
			}
			elseif($data['lead_recource']=="form" && $data['estimateFormID'] == "0"){
				$mark = "style='background: #ddddf9'";
			}
			if($data['lead_recource']=="form" && $data['estimateFormID'] == "0"){
				$from_form_mark = "style='background: yellow'";
				$from_form_str = "<br/>הגיע מטופס צור קשר";
			}
			echo "<tr ".$mark."><td height=5 colspan=13></td></tr>";
			echo "<tr ".$mark."><td colspan=13><hr width=100% size=1 color=#000000></td></tr>";
			echo "<tr ".$mark."><td height=5 colspan=13></td></tr>";
			echo "<tr ".$mark.">";
				echo "<td>".$date_in2[2]."-".$date_in2[1]."-".$date_in2[0]." ".$date_in[1]."</td>";
				echo "<td width=10></td>";
				echo "<td $from_form_mark >";
					echo $dataUsers['domain']."<br/><b>".$dataUsers['name']."</b><br/>".$dataUsers['full_name'];
					echo $from_form_str;
				echo "</td>";
				echo "<td width=10></td>";
				echo "<td>".stripslashes($data['name'])."</td>";
				echo "<td width=10></td>";
				echo "<td>".stripslashes($data['email'])."";
				if($data['lead_recource']!="form"){
					echo "<b style='color:red;'>ליד טלפוני</b>";
				}
				echo "</td><td width=10></td>";
				echo "<td>".stripslashes($data['phone'])."</td>";
				echo "<td width=10></td>";
				echo "<td>";
					echo "<form action='index.php' name='status_".$data['id']."' method='post' style='padding: 0px; margin: 0px;'>";
					echo "<input type='hidden' name='main' value='centered_contact_DB'>";
					echo "<input type='hidden' name='sesid' value='".SESID."'>";
					echo "<input type='hidden' name='reco_id' value='".$data['id']."'>";
					echo "<input type='hidden' name='status' value='".$status."'>";
					
					echo "<table border=\"0\" cellspacing=\"0\" cellpadding=\"0\" class=\"maintext\">";
						echo "<tr>";
							echo "<td><textarea cols='' rows='' name='content' class='input_style' style='width: 250px; height: 100px;'>".stripslashes($data['content'])."</textarea></td>";
							echo "<td width=10></td>";
							echo "<td valign=top height=100%>";
								echo "<table border=\"0\" cellspacing=\"0\" cellpadding=\"0\" class=\"maintext\" height=100%>";
									echo "<tr>";
										echo "<td valign=top>";
											echo "<select name='new_status' class='input_style' style='width: 100px;'>";
												echo "<option value=''>בחירה</option>";
												echo "<option value='0' ".$selected0.">מתעניין חדש</option>";
												echo "<option value='1' ".$selected1.">נוצר קשר</option>";
												echo "<option value='5' ".$selected5.">מחכה לטלפון</option>";
												echo "<option value='2' ".$selected2.">סגירה עם לקוח</option>";
												echo "<option value='3' ".$selected3.">לקוחות רשומים</option>";
												echo "<option value='4' ".$selected4.">לא רלוונטי</option>";
											echo "</select>";
										echo "</td>";
									echo "</tr>";
									echo "<tr><td height=10></td></tr>";
									echo "<tr>";
										$checked = ( $data['markMsg'] == "1" ) ? "checked" : "";
										echo "<td><input type='checkbox' value='1' name='markMsg' ".$checked."> הדגשה</td>";
									echo "</tr>";
									echo "<tr>";
										echo "<td valign=bottom><input type='submit' value='שמור' class='input_style' style='width: 100px;'></td>";
									echo "</tr>";
								echo "</table>";
							echo "</td>";
						echo "</tr>";
						
					echo "</table>";
					
					echo "</form>";
				echo "</td>";
				echo "<td width=10></td>";	
				echo "<td align='left'  ><input type='checkbox' name='selected_rows[]' class='mass_action_selected_status' value='".$data['id']."'></td>";				
							
			echo "</tr>";
		}
		
	echo "</table>";
}



function centered_contact_DB()
{
	if($_POST['reco_id'] == 'all_selected'){
		print_r($_POST);
		$sql_in = implode(", ",$_POST['selected_rows']);
		$sql = "UPDATE user_contact_forms SET status= '".$_POST['new_status']."' WHERE id IN (".$sql_in.") ";
		$res = mysql_db_query(DB,$sql);
		echo "<script>window.location.href='index.php?main=centered_contact&sesid=".SESID."&status=".$_POST['status']."';</script>";
	}
	else{
		$sql = "UPDATE user_contact_forms SET status= '".$_POST['new_status']."' , content = '".mysql_real_escape_string($_POST['content'])."' , markMsg = '".$_POST['markMsg']."' WHERE id = '".$_POST['reco_id']."' ";
		$res = mysql_db_query(DB,$sql);
		
		echo "<script>window.location.href='index.php?main=centered_contact&sesid=".SESID."&status=".$_POST['status']."';</script>";
	}
}


function launch_fee_that_open()
{
	$sql = "SELECT lf.*, DATE_FORMAT(lf.until_date,'%d-%m-%Y') as untilDate , pay.payGood FROM ilbiz_launch_fee AS lf LEFT JOIN ilbizPayByCCLog as pay ON lf.order_id = pay.id WHERE lf.deleted=0 ORDER BY untilDate DESC";
	$res = mysql_db_query(DB,$sql);
	
	echo "<table border=\"0\" cellspacing=\"0\" cellpadding=\"0\" class=\"maintext\">";
		
		echo "<tr>";
			echo "<td colspan=15><A href=\"?&sesid=".SESID."\" class=\"maintext\">חזרה לתפריט הראשי</a></td>";
		echo "</tr>";
		echo "<tr><td height=5 colspan=15></td></tr>";
		
		echo "<tr>";
			echo "<td colspan=7><b>תשלומים פתוחים</b></td>";
		echo "</tr>";
		echo "<tr><td colspan=7 height=7></tr>";
		echo "<tr>";
			echo "<td><b>שם הלקוח</b></td>";
			echo "<td width=30></td>";
			echo "<td><b>מחיר כולל מע\"מ</b></td>";
			echo "<td width=10></td>";
			echo "<td><b>פרטים</b></td>";
			echo "<td width=10></td>";
			echo "<td><b>תשלום עד תאריך</b></td>";
			echo "<td width=10></td>";
			echo "<td><b>שולם בהצלחה?</b></td>";
		echo "</tr>";
		
		$total_0 = 0;
		$total_2 = 0;
		while( $data = mysql_fetch_array($res) )
		{
			$sql2 = "SELECT id , name FROM users WHERE unk = '".$data['unk']."' ";
			$res2 = mysql_db_query(DB,$sql2);
			$dataUsers = mysql_fetch_array($res2);
			
			switch($data['payGood'])
			{
				case "" :
				case "0" : $payGood = "לא בוצע תשלום";	break;
				case "1" : $payGood = "תשלום נכשל";	break;
				case "2" : $payGood = "תשלום בוצע בהצלחה";	break;
			}
			
			$tr_Style = ( $data['deleted'] == "1" ) ? "style='text-decoration:line-through'" : "";
			
			if( $data['payGood'] != "2" )
			{
				echo "<tr><td colspan=7 height=15></tr>";
				echo "<tr ".$tr_Style.">";
					echo "<td><a href='index.php?main=launch_fee_to_client&unk=".$data['unk']."&sesid=".SESID."' class='maintext' target='_blank'>".stripslashes($dataUsers['name'])."</a></td>";
					echo "<td width=30></td>";
					echo "<td>".$data['price']."</td>";
					echo "<td width=10></td>";
					echo "<td>".stripslashes($data['details'])."</td>";
					echo "<td width=10></td>";
					echo "<td>".$data['untilDate']."</td>";
					echo "<td width=10></td>";
					echo "<td>".$payGood."</td>";
				echo "</tr>";
				
				$total_0 = $total_0 + $data['price'];
			}
			else
				$total_2 = $total_2 + $data['price'];
			
		}
		
		echo "<tr>";
			echo "<td colspan=9>";
				echo "<br><br>סך הכל חובות שלא שולמו דרך שגר תשלום: <b>".number_format($total_0)."</b><br><br>";
				echo "סך הכל שולם דרך שגר תשלום: <b>".number_format($total_2)."</b><br>";
			echo "</td>";
		echo "</tr>";
	echo "</table>";
	
}


function ilbizProducts()
{
	$sql = "SELECT * FROM ilbiz_products ORDER BY pro_name";
	$res = mysql_db_query(DB, $sql);
	
	echo "<table border=\"0\" cellspacing=\"0\" cellpadding=\"0\" class=\"maintext\">";
		
		echo "<tr>";
			echo "<td><A href=\"?&sesid=".SESID."\" class=\"maintext\">חזרה לתפריט הראשי</a></td>";
		echo "</tr>";
		
		echo "<tr><td height=\"11\"></td></tr>";
		
		echo "<tr>";
			echo "<td><A href=\"?main=ilbizProducts_edit&sesid=".SESID."\" class=\"maintext\">הוסף מוצר חדש</a></td>";
		echo "</tr>";
		echo "<tr><td height=\"11\"></td></tr>";
		echo "<tr>";
			echo "<td>";
				echo "<table border=\"0\" cellspacing=\"0\" cellpadding=\"0\" class=\"maintext\">";
					echo "<tr>";
						echo "<td><b>שם המוצר</b></td>";
						echo "<td width=10></td>";
						echo "<td><b>תיאור קצר</b></td>";
						echo "<td width=10></td>";
						echo "<td><b>מחיר</b></td>";
						echo "<td width=10></td>";
						echo "<td><b>עדכון</b></td>";
					echo "</tr>";
					
					while( $data = mysql_fetch_array($res) )
					{
						echo "<tr><td colspan=5 height=10></td></tr>";
						
						echo "<tr>";
							echo "<td valign=top>".stripslashes($data['pro_name'])."</td>";
							echo "<td width=10></td>";
							echo "<td valign=top>".stripslashes(nl2br($data['pro_desc']))."</td>";
							echo "<td width=10></td>";
							echo "<td valign=top>".stripslashes($data['price'])."</td>";
							echo "<td width=10></td>";
							echo "<td valign=top><a href='index.php?main=ilbizProducts_edit&record_id=".$data['id']."&sesid=".SESID."' class='maintext'>עדכון</a></td>";
						echo "</tr>";
						
					}
				echo "</table>";
			echo "</td>";
		echo "</tr>";
	echo "</table>";
}


function ilbizProducts_edit()
{
	if( !empty($_GET['record_id']) )
	{
		$sql = "SELECT * FROM ilbiz_products WHERE id = '".(int)$_GET['record_id']."' ";
		$res = mysql_db_query(DB,$sql);
		$data = mysql_fetch_array($res);
	}
	
	$monthly['0'] = "לא";
	$monthly['1'] = "כן";
	
	$need_to_check['0'] = "לא";
	$need_to_check['1'] = "כן";
	
	$form_arr = array(
		array("hidden","main","ilbizProducts_DB"),
		array("hidden","record_id",$data['id']),
		array("hidden","sesid",SESID),
		
		array("text","data_arr[pro_name]",$data['pro_name'],"שם המוצר", "class='input_style'"),
		array("textarea","data_arr[pro_desc]",$data['pro_desc'],"תיאור המוצר", "class='input_style' style='height: 100px;'"),
		array("text","data_arr[price]",$data['price'],"מחיר ברירת מחדל (כולל מע\"מ)", "class='input_style'"),
		array("select","monthly[]",$monthly,"חיוב חודשי?",$data['monthly'],"data_arr[monthly]", "class='input_style'"),
		array("select","need_to_check[]",$need_to_check,"מצריך בדיקה סוף-חודשית לגבי המחיר?",$data['need_to_check'],"data_arr[need_to_check]", "class='input_style'"),
		
		array("submit","submit","שמירה", "class='submit_style'")
	);
	
// שדות חובה
$more = "class='maintext'";
$mandatory_fields = array();

	echo "<table border=\"0\" cellspacing=\"0\" cellpadding=\"0\" class=\"maintext\">";
		
		echo "<tr>";
			echo "<td><A href=\"?&sesid=".SESID."\" class=\"maintext\">חזרה לתפריט הראשי</a></td>";
		echo "</tr>";
		
		echo "<tr><td height=\"11\"></td></tr>";
		
		echo "<tr>";
			echo "<td><A href=\"?main=ilbizProducts&sesid=".SESID."\" class=\"maintext\">חזרה לרשימה</a></td>";
		echo "</tr>";
		
		echo "<tr><td height=\"11\"></td></tr>";
		
		echo "<tr>";
			echo "<td>";
				echo FormCreator::create_form($form_arr,"index.php", $more, $mandatory_fields);
			echo "</td>";
		echo "</tr>";
		
	echo "</table>";
}


function ilbizProducts_DB()
{
	$arr = array(
		after_success_goto=>"index.php?main=ilbizProducts&sesid=".SESID,
		table_name=>"ilbiz_products",
	);
	if( !empty($_POST['record_id']) )
		update_db($_POST['data_arr'], $arr);
	else
		insert_to_db($_POST['data_arr'], $arr);
}


function userSiteProfileLeftSide()
{
	$sql = "SELECT id, pro_name FROM ilbiz_products ORDER BY pro_name";
	$res_pro = mysql_db_query(DB, $sql);
	
	echo "<table cellpadding=0 cellspacing=0 border=0>";
		echo "<tr>";
			echo "<td>אנא כתוב את מוצרי הלקוח: (<b>עדיין לא פעיל</b>)<td>";
		echo "</tr>";
		echo "<tr>";
			echo "<td>";
				echo "<div id='editOnClick'>";
		       echo "<ul></ul>";
		    echo"</div>";
			echo "<td>";
		echo "</tr>";
		
		echo "<tr>";
			echo "<td>";
			echo "<a href='javascript:;' id='show_user_ilbiz_products'>עדכן לקבלת נתונים על המוצרים</a>";
				echo "<div id='productSelected'></div>";
			echo "</td>";
		echo "</tr>";
	echo "</table>";
	
}