<?php


function mysaveGenralLinks()
{
	$type = ( $_GET['type'] == "" ) ? $_POST['type'] : $_GET['type'];
	
	$cat = ( $_GET['cat'] != "" ) ? "AND cat='".$_GET['cat']."'" : "";
	$sql = "select id, linkName, linkUrl, status, cat FROM mysaveGenralLinks where type = '".$type."' and deleted = '0' ".$cat." order by place";
	$res = mysql_db_query(DB,$sql);
	
	/*$sql = "SELECT es.estimate_name FROM mysaveGenralLinks_choosen_estimate_site as esc , estimate_sites as es WHERE esc.link_id = '".$data['id']."' AND es.estimate_site_id=esc.estimate_id";
			$res3 = mysql_db_query(DB,$sql );
			$data3 = mysql_fetch_array($res3);
			*/
	
	echo "<table border=\"0\" cellspacing=\"0\" cellpadding=\"0\" class=\"maintext\">";
		echo "<tr>";
			echo "<td colspan='9'><A href=\"?sesid=".SESID."\" class=\"maintext\">חזרה לתפריט הראשי</a></td>";
		echo "</tr>";
		echo "<tr><td colspan='9' height='5'></td></tr>";
		echo "<tr>";
			echo "<td colspan='9'><A href=\"?main=mysaveGenralLinksEdit&type=".$type."&sesid=".SESID."\" class=\"maintext\">הוסף קישור חדש</a></td>";
		echo "</tr>";
		
		if( $type == "2" )
		{
		echo "<tr><td colspan='9' height='15'></td></tr>";
		echo "<tr>
			<td colspan=9>
				<form action='index.php' method='get' name='searchForm' style='margin:0;padding:0;'>
				<input type='hidden' name='main' value='mysaveGenralLinks'>
				<input type='hidden' name='type' value='2'>
				<input type='hidden' name='sesid' value='".SESID."'>
				<table border=\"0\" cellspacing=\"0\" cellpadding=\"0\" class=\"maintext\">
					<tr>
						<td>חיפוש לפי קטגוריה: </td>
						<td width='30'></td>
						<td>";
							echo "<select name='cat' class='input_style' onchange='searchForm.submit()'>";
							$sql1 = "select id,cat_name,father from biz_categories where status = '1' AND father=0 order by place,cat_name";
							$res1 = mysql_db_query(DB,$sql1);
							
							echo "<option value=''>הכל</option>";
							while( $data1 = mysql_fetch_array($res1) )
							{
								$selected = ( $data1['id'] == $_GET['cat'] ) ? "selected" : "";
								echo "<option value='".$data1['id']."' ".$selected.">".htmlspecialchars(stripslashes($data1['cat_name']))."</option>";
							}
							echo "</select>";
						echo "</td>
					</tr>
				</table>
				</form>
			</td>
		</tr>";
		}
		
		echo "<tr><td colspan='9' height='15'></td></tr>
		<tr>
			<td>שם הקישור</td>
			<td width=10></td>
			<td>פעיל באתר</td>
			<td width=10></td>";
			if( $type == 2 )
			{
				echo "<td>קטגוריה</td>
				<td width=10></td>";
			}
			echo "
			<td>עריכה</td>
			<td width=10></td>
			<td>מחיקה</td>
		</tR>
		
		<tr><td colspan='9' height='10'></td></tr>";
		
		while( $data = mysql_fetch_array($res) )
		{
			if( eregi( "http://" , $data['linkUrl'] ) )
				$linkUrl = stripslashes($data['linkUrl']);
			else
				$linkUrl = "http://".stripslashes($data['linkUrl']);
			
			echo "<tr>";
				echo "<td><a href='".$linkUrl."' class='maintext' target='_blank'>".htmlspecialchars(stripcslashes($data['linkName']))."</a></td>";
				echo "<td width=10></td>";
				$active_insite = ( $data['status'] == "1" ) ? "<font color='green'>פעיל</font>" : "<font color='red'>לא פעיל</font>";
				echo "<td>".$active_insite."</td>";
				echo "<td width=10></td>";
				if( $type == 2 )
				{
					$sql = "SELECT cat_name FROM biz_categories where id = '".$data['cat']."'";
					$resCat = mysql_db_query(DB , $sql );
					$dataCat = mysql_fetch_array($resCat);
					
					echo "<td>".stripslashes($dataCat['cat_name'])."</td>";
					echo "<td width=10></td>";
				}
				echo "<td><a href='?main=mysaveGenralLinksEdit&linkID=".$data['id']."&type=".$type."&sesid=".SESID."' class='maintext'>עריכה</a></td>";
				echo "<td width=10></td>";
				echo "<td><a href='?main=mysaveGenralLinksEdit_DELL&linkID=".$data['id']."&type=".$type."&sesid=".SESID."' class='maintext' onclick='return can_i_del()'><b style='color:red;'>מחיקה</b></a></td>";
			echo "</tR>";
			echo "<tr><td colspan='9' height='10'></td></tr>";
		}
	echo "</table>";
}


function mysaveGenralLinksEdit()
{
	
	if($_GET['linkID'] != "" )	{
		$sql2 = "select * from mysaveGenralLinks where deleted = '0' and id = '".$_GET['linkID']."'";
		$res2 = mysql_db_query(DB,$sql2);
		$data = mysql_fetch_array($res2);
	}
	
	$status[1] = "פעיל";
	$status[2] = "לא פעיל";
	
	for( $i=1 ; $i<=10 ; $i++ )
	{
		$place[$i] = $i;
	}
	
	
	if( $_GET['type'] == "2" )
	{
		$sql1 = "select id,cat_name,father from biz_categories where status = '1' AND father=0 order by place,cat_name";
		$res1 = mysql_db_query(DB,$sql1);
		
		while( $data1 = mysql_fetch_array($res1) )
		{
			$cat[$data1['id']] = htmlspecialchars(stripslashes($data1['cat_name']));
		}
	}
	else
		$cat[] = "-------  אין אפשרות לבחור קטגוריה  --------";
	
	
	$sql = "SELECT * FROM estimate_sites";
	$res3 = mysql_db_query(DB,$sql);
	$estimate_site_choosen;
	while( $data_estimate_sites = mysql_fetch_array($res3) )
	{
		$sql = "SELECT * FROM mysaveGenralLinks_choosen_estimate_site WHERE estimate_id = '".$data_estimate_sites['estimate_site_id']."' AND link_id = '".$_GET['linkID']."'";
		$res4 = mysql_db_query(DB,$sql);
		$data4 =  mysql_fetch_array($res4);
		
		$checked = ( $data4['link_id'] != "" ) ? "checked" : "";
		$estimate_site_choosen .= "<label><input type='checkbox' name='choosen_estimate_link[".$data_estimate_sites['estimate_site_id']."]' value='1' ".$checked." >&nbsp;".stripslashes($data_estimate_sites['estimate_name'])."</label><br>";
	}
	
	$form_arr = array(
		array("hidden","main","mysaveGenralLinksEdit_update_DB"),
		array("hidden","record_id",$_GET['linkID']),
		array("hidden","type",$_GET['type']),
		array("hidden","data_arr[type]",$_GET['type']),
		array("hidden","sesid",SESID),
		
		
		array("text","data_arr[linkName]",$data['linkName'],"שם הקישור", "class='input_style'"),
		array("text","data_arr[linkUrl]",$data['linkUrl'],"כתובת הקישור", "class='input_style'"),
		array("select","cat[]",$cat,"קטגוריה",$data['cat'],"data_arr[cat]", "class='input_style'"),
		array("select","status[]",$status,"סטטוס",$data['status'],"data_arr[status]", "class='input_style'"),
		array("select","place[]",$place,"מיקום",$data['place'],"data_arr[place]", "class='input_style'"),
		array("blank",$estimate_site_choosen),
		
		
		array("submit","submit","שמירה", "class='submit_style'")
	);
	
// שדות חובה
$more = "class='maintext'";

echo "<table border=\"0\" cellspacing=\"0\" cellpadding=\"0\" class=\"maintext\">";
		
		echo "<tr>";
			echo "<td><A href=\"?sesid=".SESID."\" class=\"maintext\">חזרה לתפריט הראשי</a></td>";
		echo "</tr>";
		echo "<tr><td height=\"7\"></td></tr>";
		echo "<tr>";
			echo "<td><A href=\"?main=mysaveGenralLinks&type=".$_GET['type']."&sesid=".SESID."\" class=\"maintext\">לתפריט הקישורים</a></td>";
		echo "</tr>";
		
		echo "<tr><td height=\"11\"></td></tr>";
		
		echo "<tr>";
			echo "<td>".FormCreator::create_form($form_arr,"index.php", $more)."</td>";
		echo "</tr>";
		
		
	echo "</table>";
}


function mysaveGenralLinksEdit_update_DB()
{
	
	$image_settings = array(
		after_success_goto=>"GET_ID",
		table_name=>"mysaveGenralLinks",
	);
	$data_arr = ($_POST['data_arr'])? $_POST['data_arr'] : $_GET['data_arr'];
	if( $_POST['record_id'] == "" )
	{
		$recc = insert_to_db($data_arr, $image_settings);
	}
	else
	{
		update_db($data_arr, $image_settings);
		$recc = $_POST['record_id'];
	}
	
	
	$sql = "DELETE FROM mysaveGenralLinks_choosen_estimate_site WHERE link_id = '".$recc."' ";
	$res = mysql_db_query(DB,$sql);
	
	foreach( $_POST['choosen_estimate_link'] AS $key => $val )
	{
		if( $val == "1" )
		{
			$sql = "INSERT INTO mysaveGenralLinks_choosen_estimate_site ( link_id , estimate_id ) VALUES ( '".$recc."' , '".$key."' )";
			$res = mysql_db_query(DB,$sql);
		}
	}
	
	echo "<META HTTP-EQUIV=Refresh CONTENT=\"0; URL=?main=mysaveGenralLinks&type=".$_POST['type']."&sesid=".SESID."\">";
			exit;
}

function mysaveGenralLinksEdit_DELL()
{
	$sql = "update mysaveGenralLinks set deleted = '1' where id = '".$_GET['linkID']."' limit 1";
	$res = mysql_db_query(DB,$sql);
	
	echo "<script>window.location.href='?main=mysaveGenralLinks&type=".$_GET['type']."&sesid=".SESID."';</script>";
		exit;
}


function createMysaveForm()
{
	
	$sql = "select cat_name, id from biz_categories where father = '0' and status = '1' order by place,cat_name";
	$res_father = mysql_db_query(DB, $sql);
	
	$sql = "SELECT id, name FROM newCities WHERE father=0";
	$resAll = mysql_db_query(DB,$sql);
	
	echo "<table class=\"maintext\">";
		echo "<tr>";
			echo "<td><A href=\"?sesid=".SESID."\" class=\"maintext\">חזרה לתפריט הראשי</a></td>";
		echo "</tr>";
		echo "<tr><td height=\"11\"></td></tr>";
		echo "<tr>";
			echo "<td>";
				echo "<form action='javascript:createMysaveForm()' name='formi' method='GET' style='padding:0; margin:0;'>";
				echo "<input type='hidden' name='sesid' value='".SESID."'>";
				echo "<input type='hidden' name='tatcat' value=''>";
				echo "<table class='maintext'>";
					echo "<tr>";
						echo "<td>תחום (חובה)</td>";
						echo "<td>";
							echo "<select name='cat' class='input_style'>";
								echo "<option value=''>בחירה</option>";
								while( $data = mysql_fetch_array($res_father) )
								{
									echo "<option value='".$data['id']."'>".stripslashes($data['cat_name'])."</option>";
								}
							echo "</select>";
						echo "</td>";
					echo "</tr>";
					
					echo "<tr>";
						echo "<td>עיר (אם ריק, אז הבחירה לידי הגולש)</td>";
						echo "<td>";
							echo "<select name='city' class='input_style'>";
								echo "<option value=''>בחירה</option>";
								while( $data = mysql_fetch_array($resAll) )
								{
									echo "<option value='".$data['id']."' style='color: #000000;'>".stripslashes($data['name'])."</option>";
									
									$sql = "SELECT id, name FROM newCities WHERE father=".$data['id']."";
									$resAll2 = mysql_db_query(DB,$sql);
									
									while( $data2 = mysql_fetch_array($resAll2) )
									{
										echo "<option value='".$data2['id']."'>".stripslashes($data2['name'])."</option>";
									}
									echo "<option value=''>-----------------------</option>";
								}
							echo "</select>";
						echo "</td>";
					echo "</tr>";
					
					echo "<tr>";
						echo "<td>צבע טקסט</td>";
						echo "<td><input type='text' name='color' value='000000' class='input_style'></td>";
					echo "</tr>";
					
					echo "<tr>";
						echo "<td></td>";
						echo "<td><input type='submit' value='שלב הבא' class='input_style'></td>";
					echo "</tr>";
				echo "</table>";
				echo "</form>";
			echo "</td>";
		echo "</tr>";
		echo "<tr>";
			echo "<td><div id='formContent'></div></td>";
		echo "</tr>";
		
	echo "</table>";
}

function user_lead_settings()
{
	$sql = "SELECT belongTo10service FROM user_extra_settings WHERE unk = '".$_GET['unk']."' ";
	$res2 = mysql_db_query(DB, $sql);
	$dataUser = mysql_fetch_array($res2);
	
	$sql = "select * from user_lead_settings where unk = '".$_GET['unk']."'";
	$res = mysql_db_query(DB, $sql);
	$data = mysql_fetch_array($res);
	
	$lead = new lead();
	$GlobalFunctions = new GlobalFunctions();
	
	echo "<table class=\"maintext\">";
		echo "<tr>";
			echo "<td colspan=2><A href=\"?main=user_profile&unk=".$_GET['unk']."&record_id=".$_GET['record_id']."&sesid=".SESID."\" class=\"maintext\">חזרה לעדכון</a></td>";
		echo "</tr>";
		
		echo "<tr><td height=\"11\" colspan=2></td></tr>";
		echo "<tr>";
			echo "<td width=50% valign=top>";
				echo "<form action='index.php' name='formi' method='post' style='padding:0; margin:0;'>";
				echo "<input type='hidden' name='main' value='user_lead_settings_DB'>";
				echo "<input type='hidden' name='sesid' value='".SESID."'>";
				echo "<input type='hidden' name='unk' value='".$_GET['unk']."'>";
				echo "<table class='maintext'>";
					echo "<tr>";
						echo "<td colspan=2><h3>הגדרות כלליות</h3></td>";
					echo "</tr>";
					echo "<tr>";
						echo "<td colspan=2>
						<p>
							<b>הסבר קצר:</b><br>
							במידה והלקוח משלם מראש - יש לעדכן את יתרת לידים לשליחה - במידה ולא תעודכן לא ישלח ללקוח הודעות<br>
							אין צורך למלאות יתרת לידים לשליחה אם שליחת לידים ללא הגבלה מסומנת בכן<br><br>
							במידה והלקוח לא רוצה לשלם קבוע - הוא יכול לבחור במסלול החד פעמי - יש למלאות מחיר לצפיה בפרטי צור קשר - בשליחת הודעת sms
							וזהו..<br><br>
							במידה והטופס יהיה ריק - הלקוח יקבל הודעות דרך צור קשר ללא שום הגבלה.
							<br><Br>
							הודעות צור קשר מגיעות קודם למערכת לאישור לידים - ואז ללקוח לאחר אישור ובחירת לקוחות לשליחה.
							<Br>
							מערכת הודעות sms שולחת אוטומטית ברגע שהנשלח הטופס למערכת.
						</p>
						</td>";
					echo "</tr>";
					echo "<tr><td height=\"11\" colspan=2></td></tr>";
					echo "<tr>";
						echo "<td>שליחת הודעות sms פעיל?</td>";
						echo "<td>";
							$selected0 = ( $data['havaSms'] == "0" ) ? "selected" : "";
							$selected1 = ( $data['havaSms'] == "1" ) ? "selected" : "";
							echo "<select name='havaSms' class='input_style' style='width:40px;'>
								<option value=0 ".$selected0.">לא</option>
								<option value=1 ".$selected1.">כן</option>
							</select>
						</td>";
					echo "</tr>";
					

					echo "<tr><td height=\"11\" colspan=2></td></tr>";
					echo "<tr>";
						echo "<td>שליחת הודעות צור קשר פעיל?</td>";
						echo "<td>";
							$selected0 = ( $data['haveContact'] == "0" ) ? "selected" : "";
							$selected1 = ( $data['haveContact'] == "1" ) ? "selected" : "";
							echo "<select name='haveContact' class='input_style' style='width:40px;'>
								<option value=0 ".$selected0.">לא</option>
								<option value=1 ".$selected1.">כן</option>
							</select>
						</td>";
					echo "</tr>";
					
					
					echo "<tr><td height=\"11\" colspan=2></td></tr>";
					echo "<tr>";
						echo "<td>מצב פתוח</td>";
						echo "<td>";
							$selected0 = ( $data['open_mode'] == "0" ) ? "selected" : "";
							$selected1 = ( $data['open_mode'] == "1" ) ? "selected" : "";
							echo "<select name='open_mode' class='input_style' style='width:40px;'>
								<option value=0 ".$selected0.">לא</option>
								<option value=1 ".$selected1.">כן</option>
							</select>
						</td>";
					echo "</tr>";
					echo "<tr><td height=\"11\" colspan=2></td></tr>";
					echo "<tr>";
						echo "<td>שליחת לידים ללא הגבלה</td>";
						echo "<td>";
							$selected0 = ( $data['freeSend'] == "0" ) ? "selected" : "";
							$selected1 = ( $data['freeSend'] == "1" ) ? "selected" : "";
							echo "<select name='freeSend' class='input_style' style='width:40px;'>
								<option value=0 ".$selected0.">לא</option>
								<option value=1 ".$selected1.">כן</option>
							</select>
						</td>";
					echo "</tr>";
					echo "<tr>";
						echo "<td>הסתר זיכויים</td>";
						echo "<td>";
							$selected0 = ( $data['hide_refund'] == "0" ) ? "selected" : "";
							$selected1 = ( $data['hide_refund'] == "1" ) ? "selected" : "";
							echo "<select name='hide_refund' class='input_style' style='width:40px;'>
								<option value=0 ".$selected0.">לא</option>
								<option value=1 ".$selected1.">כן</option>
							</select>
						</td>";
					echo "</tr>";
					echo "<tr><td height=\"11\" colspan=2></td></tr>";					
					echo "<tr>";
						echo "<td>יתרת לידים לשליחה</td>";
						echo "<td><input type='text' name='leadQry' value='".$data['leadQry']."' class='input_style' style='width:40px;'></td>";
					echo "</tr>";
					
					echo "<tr><td height=\"5\" colspan=2></td></tr>";
					echo "<tr><td colspan=2><hr width='100%' size=1 color=999999></td></tr>";
					echo "<tr><td height=\"5\" colspan=2></td></tr>";
					
					echo "<tr>";
						echo "<td>מחיר מקסימום לרכישת הודעות ברירת מחדל 30 שח</td>";
						echo "<td><input type='text' name='openContactDataPrice' value='".$data['openContactDataPrice']."' class='input_style' style='width:40px;'></td>";
					echo "</tr>";
					
					echo "<tr><td height=\"5\" colspan=2></td></tr>";
					echo "<tr><td colspan=2><hr width='100%' size=1 color=999999></td></tr>";
					echo "<tr><td height=\"5\" colspan=2></td></tr>";
					
					
					echo "<tr>";
						echo "<td>שליחה אוטומטית של הליד</td>";
						echo "<td>";
							$selected0 = ( $data['autoSendLeadContact'] == "0" ) ? "selected" : "";
							$selected1 = ( $data['autoSendLeadContact'] == "1" ) ? "selected" : "";
							echo "<select name='autoSendLeadContact' class='input_style' style='width:40px;'>
								<option value=0 ".$selected0.">לא</option>
								<option value=1 ".$selected1.">כן</option>
							</select>
						</td>";
					echo "</tr>";
					echo "<tr>";
						echo "<td>עדיפות לשליחת לידים באחוזים</td>";
						echo "<td><input type='text' name='precent_priority' value='".$data['precent_priority']."' class='input_style' style='width:40px;'></td>";
					echo "</tr>";
					
					echo "<tr>";
						echo "<td>שליחת מקסימום לידים בחודש</td>";
						echo "<td><input type='text' name='max_leads_per_month' value='".$data['max_leads_per_month']."' class='input_style' style='width:40px;'></td>";
					echo "</tr>";
					echo "<tr>";
						echo "<td>לאחר הגבלה, העבר לסוף התור, ושלח בכל זאת אם לא קיבלו מספיק ללקוחות</td>";
						echo "<td>";
							$selected0 = ( $data['allow_more_then_max'] == "0" ) ? "selected" : "";
							$selected1 = ( $data['allow_more_then_max'] == "1" ) ? "selected" : "";
							echo "<select name='allow_more_then_max' class='input_style' style='width:40px;'>
								<option value=0 ".$selected0.">לא</option>
								<option value=1 ".$selected1.">כן</option>
							</select>
						</td>";
					echo "</tr>";
					echo "<tr><td height=\"11\" colspan=2></td></tr>";
					echo "<tr><td height=\"11\" colspan=2></td></tr>";
					echo "<tr><td height=\"11\" colspan=2></td></tr>";
					echo "<tr>";
						echo "<td><b style='color:red;'>לקוח שבת</b></td>";
						echo "<td>";
							$selected0 = ( $data['shabat_user'] == "0" ) ? "selected" : "";
							$selected1 = ( $data['shabat_user'] == "1" ) ? "selected" : "";
							echo "<select name='shabat_user' class='input_style' style='width:40px;'>
								<option value=0 ".$selected0.">לא</option>
								<option value=1 ".$selected1.">כן</option>
							</select>
						</td>";
					echo "</tr>";
					
					echo "<tr><td height=\"11\" colspan=2></td></tr>";
					echo "<tr><td height=\"11\" colspan=2></td></tr>";
					echo "<tr><td height=\"11\" colspan=2></td></tr>";
					echo "<tr><td height=\"11\" colspan=2></td></tr>";
					echo "<tr>";
						echo "<td><b style='color:red;'>הצג לקוח בטבלת מספור לידים</b></td>";
						echo "<td>";
							$selected0 = ( $data['show_in_leadsUserGet_table'] == "0" ) ? "selected" : "";
							$selected1 = ( $data['show_in_leadsUserGet_table'] == "1" ) ? "selected" : "";
							echo "<select name='show_in_leadsUserGet_table' class='input_style' style='width:40px;'>
								<option value=0 ".$selected0.">לא</option>
								<option value=1 ".$selected1.">כן</option>
							</select>
						</td>";
					echo "</tr>";
					
					echo "<tr><td height=\"11\" colspan=2></td></tr>";
					echo "<tr><td height=\"11\" colspan=2></td></tr>";
					echo "<tr><td height=\"11\" colspan=2></td></tr>";
					echo "<tr><td height=\"11\" colspan=2></td></tr>";					
					echo "<tr>";
						echo "<td>מחיר לצפיה בפרטי צור קשר</td>";
						echo "<td><input type='text' name='contactPrice' value='".$data['contactPrice']."' class='input_style' style='width:40px;'></td>";
					echo "</tr>";
					echo "<tr>";
						echo "<td>מחיר להודעת sms</td>";
						echo "<td><input type='text' name='smsPrice' value='".$data['smsPrice']."' class='input_style' style='width:40px;'></td>";
					echo "</tr>";					
					if( $dataUser['belongTo10service'] == "1" )
					{
						echo "<tr>";
							echo "<td>מחיר לצפיה בליד בקרדיטים</td>";
							echo "<td><input type='text' name='credit_price' value='".$data['credit_price']."' class='input_style' style='width:40px;'></td>";
						echo "</tr>";
						echo "<tr><td height=\"11\" colspan=2></td></tr>";
					}
					
					
					echo "<tr>";
						echo "<td></td>";
						echo "<td><input type='submit' value='שמור' class='input_style' style='width:100px;'></td>";
					echo "</tr>";
					
					$sql = "SELECT phone, email, nc.name as user_city FROM users AS u left join newCities as nc on u.city_area=nc.id WHERE u.unk = '".$_GET['unk']."'";
					$resVer = mysql_db_query(DB, $sql );
					$dataVer = mysql_fetch_array($resVer);
					
					
					echo "<tr>";
						echo "<td colspan=2>טלפון נייד לשליחת הודעות: <b>".stripslashes($dataVer['phone'])."</b> - שימו לב שהטלפון חייב להיות נייד, 10 מספרים בלבד!! מחוברים ללא מרווחים אחרת ההודעה לא תישלח!!!</td>";
					echo "</tr>";
					
					echo "<tr>";
						echo "<td colspan=2>אימייל לשליחת הודעות: <b>".stripslashes($dataVer['email'])."</b></td>";
					echo "</tr>";
					
					$city_notification = ( $dataVer['user_city'] == "" ) ? "במידה ותרצה שלקוח יקבל יותר לידים - מומלץ ביותר להוסיף לו אזור! :)" : stripslashes($dataVer['user_city']);
					echo "<tr>";
						echo "<td colspan=2>עיר + אזור לסינון: <b>".$city_notification."</b></td>";
					echo "</tr>";
					
					$sql = "SELECT id FROM users WHERE unk = '".$_GET['unk']."'";
					$res = mysql_db_query(DB,$sql);
					$data_id = mysql_fetch_array($res);
					
					$sql = "SELECT id, name FROM newCities WHERE father=0";
					$resCity1 = mysql_db_query(DB, $sql);
					
					echo "<tr>";
						echo "<td colspan=2>";
							echo "<table class='maintext'>";
								
								while( $dataCity1 = mysql_fetch_array($resCity1) )
								{
									$sql = "SELECT city_id FROM user_lead_cities WHERE user_id = '".$data_id['id']."' AND city_id = '".$dataCity1['id']."' ";
									$resCC1 = mysql_db_query(DB, $sql);
									$dataCC1 = mysql_fetch_array($resCC1);
									
									$checked = ( $dataCC1['city_id'] == $dataCity1['id'] ) ? "checked" : "";
									
									echo "<tr>";
										echo "<td><input type='checkbox' name='cities[]' value='".$dataCity1['id']."' ".$checked."></td>";
										echo "<td width=10></td>";
										echo "<td>".stripslashes($dataCity1['name'])."</td>";
									echo "</tr>";
									
									$sql = "SELECT id, name FROM newCities WHERE father=".$dataCity1['id']."";
									$resCity2 = mysql_db_query(DB, $sql);
									
									while( $dataCity2 = mysql_fetch_array($resCity2) )
									{
										$sql = "SELECT city_id FROM user_lead_cities WHERE user_id = '".$data_id['id']."' AND city_id = '".$dataCity2['id']."' ";

										$resCC2 = mysql_db_query(DB, $sql);
										$dataCC2 = mysql_fetch_array($resCC2);
																	
										$checked2 = ( $dataCC2['city_id'] == $dataCity2['id'] ) ? "checked" : "";
										
										echo "<tr>";
											echo "<td style='padding-right:20px;'><input type='checkbox' name='cities[]' value='".$dataCity2['id']."' ".$checked2."></td>";
											echo "<td width=10></td>";
											echo "<td >".stripslashes($dataCity2['name'])."</td>";
										echo "</tr>";
									}
								}
							
							echo "</table>";
						echo "</td>";
					echo "</tr>";
					
					$sql = "SELECT cat_id FROM user_cat WHERE user_id = '".$data_id['id']."' AND cat_id = '31' ";
					$resCatId = mysql_db_query(DB,$sql);
					$dataCatId = mysql_fetch_array($resCatId);
					
					if( $dataCatId['cat_id'] == "31" )
					{
						$sql = "SELECT from_passenger, until_passenger FROM user_lead_more WHERE unk = '".$_GET['unk']."' ";
						$resMore = mysql_db_query(DB,$sql);
						$dataMore = mysql_fetch_array($resMore);
						
						echo "<tr>";
							echo "<td colspan=2>";
								echo "<table class='maintext'>";
									echo "<tr>";
										echo "<td>מספר נוסעים מ-</td>";
										echo "<td width=10></td>";
										echo "<td>";
											echo "<select name='from_passenger' class='input_style' style='width:50px;'>";
												echo "<option value=''>בחר</option>";
												for( $i=1 ; $i<=51 ; $i++ )
												{
													$new_i = ( $i == "51" ) ? "51+" : $i ;
													$selected = ( $dataMore['from_passenger'] == $i ) ? "selected" : "";
													echo "<option value='".$i."' ".$selected.">".$new_i."</option>";
												}
											echo "</select>";
										echo "</td>";
										echo "<td width=20></td>";
										echo "<td>עד-</td>";
										echo "<td width=10></td>";
										echo "<td>";
											echo "<select name='until_passenger' class='input_style' style='width:50px;'>";
												echo "<option value=''>בחר</option>";
												for( $i=1 ; $i<=51 ; $i++ )
												{
													$new_i = ( $i == "51" ) ? "51+" : $i ;
													$selected = ( $dataMore['until_passenger'] == $i ) ? "selected" : "";
													echo "<option value='".$i."' ".$selected.">".$new_i."</option>";
												}
											echo "</select>";
										echo "</td>";
									echo "</tr>";
								echo "</table>";
							echo "</td>";
						echo "</tr>";
					}
					
				echo "</table>";
				echo "</form>";
			echo "</td>";
			
			echo "<td width=50% valign=top>";
				echo "<table class=\"maintext\" cellpadding=5>";
					echo "<tr>";
						echo "<td colspan=4><h3>הודעות אחרונות שנשלחו ללקוח</h3> <a href='index.php?main=sentLeadsAll&sesid=".SESID."&unk=".$_GET['unk']."' class='maintext' target='_blank'>לכל ההודעות</a></td>";
					echo "</tr>";
					
					echo "<tr>";
						echo "<td><b>תאריך ושעה</b></td>";
						echo "<td><b>שם השולח</b></td>";
						echo "<td><b>עיר</b></td>";
						echo "<td><b>נשלח על ידי</b></td>";
						echo "<td><b>נצפה על ידי הלקוח</b></td>";
					echo "</tr>";
					
					$params['sendToUnk'] = $_GET['unk'];
					$params['limit'] = "10";
					
					$res = mysql_db_query(DB, $lead->leadSent($params) );
					while ( $data = mysql_fetch_array($res) )
					{
						$params['id'] = $data['estimateFormID'];
						$res2 = mysql_db_query(DB, $lead->getEstimateDetails( $params ) );
						
						$dataEstimate = mysql_fetch_array($res2);
						
						echo "<tr>";
							echo "<td>".$GlobalFunctions->show_dateTime_field($data['date'])."</td>";
							echo "<td>".$dataEstimate['name']."</td>";
							$NewCity = ( $dataEstimate['NewCity'] != "" ) ? $dataEstimate['NewCity'] : $dataEstimate['city'];
							echo "<td>".$NewCity."</td>";
							echo "<td>".$lead->sendByArr($data['sendBy'])."</td>";
							echo "<td>".$lead->viewedStatusArr($data['viewedStatus'])."</td>";
						echo "</tr>";
					}
					echo "<tr><td height=\"11\" colspan=4></td></tr>";
					echo "<tr>";
						echo "<td colspan=4><h3>תשלומים של הלקוח</h3></td>";
					echo "</tr>";
					
					echo "<tr>";
						echo "<td><b>תאריך בקשת תשלום</b></td>";
						echo "<td><b>סכום</b></td>";
						echo "<td><b>שולם?</b></td>";
						echo "<td colspan=2><b>תאריך תשלום</b></td>";
					echo "</tr>";
					
					$params['unk'] = $_GET['unk'];
					
					$res = mysql_db_query(DB, $lead->tashlomim($params) );
					while ( $data = mysql_fetch_array($res) )
					{
						echo "<form action='javascript:lead__update_user_tashlom( \"".$data['id']."\" , \"".$_GET['unk']."\" , \"".SESID."\" )' method='get' name='form_tashlom_".$data['id']."'>";
						echo "<tr>";
							echo "<td>".$GlobalFunctions->show_dateTime_field($data['insertDate'])."</td>";
							echo "<td>".$data['total']."</td>";
							echo "<td>";
								echo "<select name='new_paid' id='new_paid_".$data['id']."' onchange='form_tashlom_".$data['id'].".submit()' class='input_style' style='width:70px;'>";
									foreach( $lead->paidArr() as $val => $key )
									{
										$selected = ( $val == $data['paid'] ) ? "selected" : "";
										echo "<option value='".$val."' ".$selected.">".$key."</option>";
									}
								echo "</select>";
								echo "</td>";
							echo "<td colspan=2><div id='tashlom_".$data['id']."'>".$GlobalFunctions->show_dateTime_field($data['payDate'])."</div></td>";
						echo "</tr>";
						echo "</form>";
					}
					
					
					echo "<tr><td height=\"11\" colspan=4></td></tr>";
					echo "<tr>";
						echo "<td colspan=4><h3>הוסף תשלום חדש</h3></td>";
					echo "</tr>";
					
					echo "<form action='javascript:lead__new_user_tashlom( \"".$_GET['unk']."\" , \"".SESID."\" )' method='get' name='form_new_tashlom'>";
					echo "<tr>";
						echo "<td>סכום: ";
						echo " <input type='text' name='price' class='input_style' style='width:70px;'></td>";
						echo "<td>שולם?</td>";
						echo "<td>";
							echo "<select name='paid' class='input_style' style='width:70px;'>";
								foreach( $lead->paidArr() as $val => $key )
								{
									echo "<option value='".$val."'>".$key."</option>";
								}
							echo "</select>";
						echo "</td>";
						echo "<td><input type='submit' value='הוסף' class='input_style' style='width:50px;'></td>";
						echo "<td><div id='addNewTashlom'></div></td>";
					echo "</tr>";
					echo "</form>";
					
				echo "</table>";
			echo "</td>";
		echo "</tr>";
	echo "</table>";
}

function user_lead_settings_DB()
{
	
	$sql = "SELECT id FROM user_lead_settings WHERE unk = '".$_POST['unk']."'";
	$res = mysql_db_query(DB,$sql);
	$data_unk = mysql_fetch_array($res);
	
	
	$sql = "SELECT id FROM users WHERE unk = '".$_POST['unk']."'";
	$res = mysql_db_query(DB,$sql);
	$data_id = mysql_fetch_array($res);
	
	
	$form_insert_array = array(
		"unk" => "unk" ,	
		"havaSms" => "havaSms" ,	
		"smsPrice" => "smsPrice" ,
		"haveContact" => "haveContact" ,
		"contactPrice" => "contactPrice" ,
		"freeSend" => "freeSend" ,
		"open_mode" => "open_mode" ,
		"hide_refund" => "hide_refund" ,
		"openContactDataPrice" => "openContactDataPrice" ,
		"precent_priority" => "precent_priority" ,
		"shabat_user" => "shabat_user" ,
		"show_in_leadsUserGet_table" => "show_in_leadsUserGet_table" ,		
		"max_leads_per_month" => "max_leads_per_month" ,
		"allow_more_then_max" => "allow_more_then_max" ,
		"autoSendLeadContact" => "autoSendLeadContact" ,
		"credit_price" => "credit_price" ,
		"leadQry" => "leadQry" );
	
	$form_update_array = array(
		"havaSms" => "havaSms" ,	
		"smsPrice" => "smsPrice" ,
		"haveContact" => "haveContact" ,
		"contactPrice" => "contactPrice" ,
		"freeSend" => "freeSend" ,
		"open_mode" => "open_mode" ,
		"hide_refund" => "hide_refund" ,		
		"openContactDataPrice" => "openContactDataPrice" ,
		"precent_priority" => "precent_priority" ,
		"shabat_user" => "shabat_user" ,
		"show_in_leadsUserGet_table" => "show_in_leadsUserGet_table" ,
		"max_leads_per_month" => "max_leads_per_month" ,
		"allow_more_then_max" => "allow_more_then_max" ,
		"autoSendLeadContact" => "autoSendLeadContact" ,
		"credit_price" => "credit_price" ,
		"leadQry" => "leadQry" );
	
	
	if( empty($data_unk['id']) )
	{
		$sql = "INSERT INTO user_lead_settings ( ";
		foreach( $form_insert_array as $key => $val )
			$sql .= $key.",";
		$sql2 = substr( $sql , 0 , -1 )." ) VALUES ( ";
		foreach( $form_insert_array as $key => $val )
			$sql2 .= "'".addslashes($_POST[$val])."',";
		$sql3 = substr( $sql2 , 0 , -1 )." )";
		$res = mysql_db_query( DB, $sql3 );
	}
	else
	{
		$sql = "UPDATE user_lead_settings SET ";
		foreach( $form_update_array as $key => $val )
			$sql .= $key." = '".addslashes($_POST[$val])."' ,";
		$sql2 = substr( $sql , 0 , -1 )." WHERE unk = '".$_POST['unk']."' AND id = '".$data_unk['id']."'";
		$res = mysql_db_query( DB, $sql2 );
	}
	
	
	$sql = "DELETE FROM user_lead_cities WHERE user_id = '".$data_id['id']."'";
	$resD = mysql_db_query(DB,$sql);
	
	foreach( $_POST['cities'] as $key => $val )
	{
		$sql = "INSERT INTO user_lead_cities ( user_id , city_id ) VALUES ( '".$data_id['id']."' , '".$val."' )";
		$resI = mysql_db_query(DB,$sql);
	}
	
	
	$sql = "SELECT id FROM user_lead_more WHERE unk = '".$_POST['unk']."'";
	$res = mysql_db_query(DB,$sql);
	$data_unk = mysql_fetch_array($res);
	
	if( empty($data_unk['id']) && $_POST['from_passenger'] != "" )
	{
		$sql = "INSERT INTO user_lead_more ( unk , from_passenger, until_passenger ) VALUES ( '".$_POST['unk']."' , '".$_POST['from_passenger']."' , '".$_POST['until_passenger']."' )";
		$res = mysql_db_query(DB,$sql);
	}
	else
	{
		$sql = "UPDATE user_lead_more SET from_passenger = '".$_POST['from_passenger']."' , until_passenger = '".$_POST['until_passenger']."' WHERE unk = '".$_POST['unk']."' ";
		$res = mysql_db_query(DB,$sql);
	}
	
	
	echo "<script>window.location.href='index.php?main=user_lead_settings&unk=".$_POST['unk']."&sesid=".SESID."'</script>";
		exit;
}

function user_cat_city_settings()
{
	
	$sql = "SELECT id,name FROM users WHERE unk = '".$_REQUEST['unk']."'";
	$res = mysql_db_query(DB,$sql);
	$data_id = mysql_fetch_array($res);	


	if(isset($_REQUEST['save_cities']) && $_REQUEST['save_cities'] == "1"){
		//remove all previos user_cat_city selections from db, for this user in this cat
		$sql = "DELETE FROM user_cat_city WHERE user_id = ".$data_id['id']." AND cat_id = ".$_REQUEST['catId'];
		$res = mysql_db_query(DB,$sql);		
		//add all new selected
		foreach( $_POST['cities'] as $key => $val )
		{
			$sql = "INSERT INTO user_cat_city ( user_id , city_id, cat_id ) VALUES ( '".$data_id['id']."' , '".$val."', '".$_REQUEST['catId']."' )";
			$resI = mysql_db_query(DB,$sql);
		}		
		//remove all user_cat_city selections for categories that user not belong to them
		$sql = "DELETE FROM user_cat_city WHERE user_id = '".$data_id['id']."' AND cat_id NOT IN(select cat_id from user_cat where user_id = '".$data_id['id']."' )";
		$resD = mysql_db_query(DB,$sql);
		
		echo "<h4 style='color:green'>השינויים נשמרו בהצלחה</h4>";		
	}	
	if(!isset($_REQUEST['catId']) || $_REQUEST['catId'] == ""){
		echo "<h3>לא נבחרה קטגוריה</h3>";
		return;
	}
	
	$sql = "SELECT cat_name FROM biz_categories WHERE id = '".$_REQUEST['catId']."'";
	$res = mysql_db_query(DB,$sql);
	$data_cat = mysql_fetch_array($res);	
	
	echo "<table class=\"maintext\">";
		echo "<tr>";
			echo "<td colspan=2><a href=\"?main=user_profile&unk=".$_REQUEST['unk']."&record_id=".$_REQUEST['record_id']."&sesid=".SESID."\" class=\"maintext\">חזרה לעדכון</a></td>";
		echo "</tr>";
		echo "<tr>";
			echo "<td colspan=2><a href=\"?main=portal_settings&unk=".$_REQUEST['unk']."&record_id=".$_REQUEST['record_id']."&sesid=".SESID."\" class=\"maintext\">חזרה להגדרות הפורטל</a></td>";
		echo "</tr>";		
		echo "<tr>";
			echo "<td colspan=2><h3>הוספת ערים ללקוח - ".$data_id['name']." בקטגוריה - ".$data_cat['cat_name']."</h3></td>";
		echo "</tr>";		
		echo "<tr><td height=\"11\" colspan=2></td></tr>";
		echo "<tr>";
			echo "<td width=50% valign=top>";
				echo "<form action='index.php' name='formi' method='post' style='padding:0; margin:0;'>";
				echo "<input type='hidden' name='main' value='user_cat_city_settings'>";
				echo "<input type='hidden' name='sesid' value='".SESID."'>";
				echo "<input type='hidden' name='unk' value='".$_REQUEST['unk']."'>";
				echo "<input type='hidden' name='catId' value='".$_REQUEST['catId']."'>";
				echo "<input type='hidden' name='save_cities' value='1'>";
				echo "<table class='maintext'>";

					
					
					echo "<tr>";
						echo "<td></td>";
						echo "<td><input type='submit' value='שמור' class='input_style' style='width:100px;'></td>";
					echo "</tr>";

					$sql = "SELECT id, name FROM newCities WHERE father=0";
					$resCity1 = mysql_db_query(DB, $sql);
					
					echo "<tr>";
						echo "<td colspan=2>";
							echo "<table class='maintext'>";
								
								while( $dataCity1 = mysql_fetch_array($resCity1) )
								{
									$sql = "SELECT city_id FROM user_cat_city WHERE user_id = '".$data_id['id']."' AND city_id = '".$dataCity1['id']."'  AND cat_id = '".$_REQUEST['catId']."' ";
									$resCC1 = mysql_db_query(DB, $sql);
									$dataCC1 = mysql_fetch_array($resCC1);
									
									$checked = ( $dataCC1['city_id'] == $dataCity1['id'] ) ? "checked" : "";
									
									echo "<tr>";
										echo "<td><input type='checkbox' name='cities[]' value='".$dataCity1['id']."' ".$checked."></td>";
										echo "<td width=10></td>";
										echo "<td>".stripslashes($dataCity1['name'])."</td>";
									echo "</tr>";
									
									$sql = "SELECT id, name FROM newCities WHERE father=".$dataCity1['id']."";
									$resCity2 = mysql_db_query(DB, $sql);
									
									while( $dataCity2 = mysql_fetch_array($resCity2) )
									{
										$sql = "SELECT city_id FROM user_cat_city WHERE user_id = '".$data_id['id']."' AND city_id = '".$dataCity2['id']."'  AND cat_id = '".$_REQUEST['catId']."' ";

										$resCC2 = mysql_db_query(DB, $sql);
										$dataCC2 = mysql_fetch_array($resCC2);
																	
										$checked2 = ( $dataCC2['city_id'] == $dataCity2['id'] ) ? "checked" : "";
										
										echo "<tr>";
											echo "<td style='padding-right:20px;'><input type='checkbox' name='cities[]' value='".$dataCity2['id']."' ".$checked2."></td>";
											echo "<td width=10></td>";
											echo "<td >".stripslashes($dataCity2['name'])."</td>";
										echo "</tr>";
									}
								}
							
							echo "</table>";
						echo "</td>";
					echo "</tr>";
					
					
					
				echo "</table>";
				echo "</form>";
			echo "</td>";
			
			
		echo "</tr>";
	echo "</table>";
}



function leadsPayments()
{
	$lead = new lead();
	$more = new GlobalFunctions();
	
	$paid = ( $_GET['paid'] == "" ) ? "0" : $_GET['paid'];
	
	$params = array();
	$params['paid'] = $paid;
	$params['orderby'] = "id";
	$sql = $lead->tashlomim($params);
	$res = mysql_db_query(DB, $sql);
	
	echo "<table class=\"maintext\" cellpadding=3 cellspacing=3>";
		echo "<tr>";
			echo "<td><A href=\"?sesid=".SESID."\" class=\"maintext\">חזרה לתפריט הראשי</a></td>";
		echo "</tr>";
		echo "<tr><td height=\"11\"></td></tr>";
		echo "<tr>";
			$s_b_1 = ( $paid == "0" ) ? "<b>" : "";
			$e_b_1 = ( $paid == "0" ) ? "</b>" : "";
			$s_b_2 = ( $paid == "1" ) ? "<b>" : "";
			$e_b_2 = ( $paid == "1" ) ? "</b>" : "";
			echo "<td><A href=\"?sesid=".SESID."&main=leadsPayments&paid=0\" class=\"maintext\">".$s_b_1."תשלומים שלא שולמו/לבדיקה".$e_b_1."</a> | <A href=\"?sesid=".SESID."&main=leadsPayments&paid=1\" class=\"maintext\">".$s_b_2."תשלומים ששולמו".$e_b_2."</a></td>";
		echo "</tr>";
		echo "<tr><td height=\"11\"></td></tr>";
		echo "<tr>";
			echo "<th>שם הלקוח</th>";
			echo "<th>תשלום</th>";
			echo "<th>שולם</th>";
			echo "<th>תאריך בקשת תשלום</th>";
			echo "<th>תאריך קבלת תשלום</th>";
		echo "</tr>";
		
		$sum_total=0;
		while( $data = mysql_fetch_array( $res ) )
		{
			$sql2 = "SELECT name FROM users WHERE unk = '".$data['unk']."' ";
			$res2 = mysql_db_query(DB, $sql2);
			$data2 = mysql_fetch_array( $res2 );
			
			echo "<tr>";
				echo "<td><a href='index.php?main=user_lead_settings&unk=".$data['unk']."&sesid=".SESID."' class='maintext' target='_blank'>".stripslashes($data2['name'])."</a></td>";
				echo "<td>".$data['total']."</td>";
				$paidText = ( $data['paid'] == "1" ) ? "<font style='color: green;'>כן</font>" : "<font style='color: red;'>לא</font>";
				echo "<td>".$paidText."</td>";
				echo "<td>".$more->show_dateTime_field($data['insertDate'])."</td>";
				echo "<td>".$more->show_dateTime_field($data['payDate'])."</td>";
			echo "</tr>";
			$sum_total = $data['total'] + $sum_total;
		}
		
		echo "<tr>";
			echo "<td colspan=5>";
				if( $paid == "1" )
					echo "<font style='color: green;'>סך הכל תשלום שהתקבל: <b>".$sum_total."</b></font>";
				else
					echo "<font style='color: red;'>סך הכל תשלום שמחכה להתקבל: <b>".$sum_total."</b></font>";
			echo "</td>";
		echo "</tr>";
		
	echo "</table>";
}

function leadsUserGet()
{
	if(isset($_GET['user_test'])){
		echo leadsUserGet_test();
		return;
	}
	$clientName = ( $_GET['clientName'] != "" ) ? "u.name LIKE '%".$_GET['clientName']."%' AND " : "";
	
	$defualt_s_date = ( isset($_GET['s_date']) && $_GET['s_date'] != "" ) ? $_GET['s_date'] : date('01-m-Y');
	$defualt_e_date = ( isset($_GET['e_date']) && $_GET['e_date'] != "" ) ? $_GET['e_date'] : date('d-m-Y');
	
	$ex_s = explode("-",$defualt_s_date);
	$s_date = ( $defualt_s_date != "" ) ? "AND sent.date_in >= '".$ex_s[2]."-".$ex_s[1]."-".$ex_s[0]."' " : "";
	$ex_e = explode("-",$defualt_e_date);
	$e_date = ( $defualt_e_date != "" ) ? "AND sent.date_in <= '".$ex_e[2]."-".$ex_e[1]."-".$ex_e[0]."' " : "";
	
	$s_date2 = ( $defualt_s_date != "" ) ? "AND date >= '".$ex_s[2]."-".$ex_s[1]."-".$ex_s[0]."' " : "";
	$e_date2 = ( $defualt_e_date != "" ) ? "AND date <= '".$ex_e[2]."-".$ex_e[1]."-".$ex_e[0]."' " : "";
	
	$sql = "SELECT uls.* , u.name AS clientName
		FROM user_lead_settings AS uls , user_contact_forms AS sent , users AS u WHERE 
			uls.unk=u.unk AND
			uls.show_in_leadsUserGet_table = '1' AND 
			".$clientName."
			uls.unk=sent.unk
			".$s_date.$e_date ."
			GROUP BY uls.unk
	";
	
	$res = mysql_db_query(DB,$sql);
	$more = new GlobalFunctions();
	$sum_total_leads = 0;
	$sum_total_leads_to_pay = 0;
	
	
	echo "<table class=\"maintext\" cellpadding=0 cellspacing=0>";
		echo "<tr>";
			echo "<td><A href=\"?sesid=".SESID."\" class=\"maintext\">חזרה לתפריט הראשי</a></td>";
		echo "</tr>";
		echo "<tr><td colspan=6 height=10></td></tr>";
		echo "<tr>";
			echo "<td colspan=6>";
				echo "<form action='index.php' name='serachForm' method='get' style='padding:0;margin:0'>";
				echo "<input type='hidden' name='sesid' value='".SESID."'>";
				echo "<input type='hidden' name='main' value='leadsUserGet'>";
				echo "<table class=\"maintext\" cellpadding=0 cellspacing=0>";
					echo "<tr>";
						echo "<td>שם לקוח</td>";
						echo "<td width=10></td>";
						echo "<td><input type='text' name='clientName' value='".$_GET['clientName']."' class='input_style' style='width: 100px;' /></td>";
						echo "<td width=40></td>";
						echo "<td>מספור לידים בין התאריך</td>";
						echo "<td width=10></td>";
						echo "<td><input type='text' name='s_date' value='".$defualt_s_date."' class='input_style' style='width: 100px;' /></td>";
						echo "<td width=20></td>";
						echo "<td>לתאריך</td>";
						echo "<td width=10></td>";
						echo "<td><input type='text' name='e_date' value='".$defualt_e_date."' class='input_style' style='width: 100px;' /></td>";
						echo "<td width=40></td>";
						echo "<td><input type='submit' value='חפש!' class='submit_style'></td>";
					echo "</tr>";
				echo "</table>";
				echo "</form>";
			echo "</td>";
		echo "</tr>";
		echo "<tr><td colspan=6 height=20></td></tr>";
		echo "<tr>";
			echo "<th>שם הלקוח</th>";
			echo "<th>הודעות SMS</th>";
			echo "<th>הודעות צור קשר</th>";
			echo "<th>שליחה חופשית</th>";
			echo "<th>יתרת הודעות</th>";
			echo "<th>מספור לידים בין התאריכים</th>";
		echo "</tr>";
		echo "<tr bgcolor='#000000'><td colspan=6 height=1></td></tr>";
		$sum_leads=0;
		$counter=0;
		
		$s_date2 = ( $defualt_s_date != "" ) ? "AND date >= '".$ex_s[2]."-".$ex_s[1]."-".$ex_s[0]."' " : "";
		$e_date2 = ( $defualt_e_date != "" ) ? "AND date <= '".$ex_e[2]."-".$ex_e[1]."-".$ex_e[0]."' " : "";
		
		$s_date3 = ( $defualt_s_date != "" ) ? "AND call_date >= '".$ex_s[2]."-".$ex_s[1]."-".$ex_s[0]."' " : "";
		$e_date3 = ( $defualt_e_date != "" ) ? "AND call_date <= '".$ex_e[2]."-".$ex_e[1]."-".$ex_e[0]."' " : "";
		
		$s_date4 = ( $defualt_s_date != "" ) ? "AND date_in >= '".$ex_s[2]."-".$ex_s[1]."-".$ex_s[0]."' " : "";
		$e_date4 = ( $defualt_e_date != "" ) ? "AND date_in <= '".$ex_e[2]."-".$ex_e[1]."-".$ex_e[0]."' " : "";
		

		
		while( $data = mysql_fetch_array( $res ) )
		{
			$total_form_leads = 0;
			
			$total_form_leads_paybypswd = 0;
			$total_form_leads_paybypswd_closed = 0;
			
			$total_form_leads_billed = 0;
			$total_form_leads_doubled = 0;
			$total_form_leads_refunded = 0;

			$total_phone_leads = 0;
			$total_phone_leads_paybypswd = 0;
			$total_phone_leads_paybypswd_closed = 0;
			$total_phone_leads_billed = 0;
			$total_phone_leads_doubled = 0;
			$total_phone_leads_refunded = 0;
			
			$total_to_pay = 0;
			$form_leads_arr = array();
			$phone_leads_arr = array();
			$phone_leads_id_arr = array();
			$sql_check_u1 = "SELECT  * FROM user_contact_forms WHERE unk = '" . $data['unk'] . "' ".$s_date4.$e_date4;
			$res_check_u1 = mysql_db_query(DB, $sql_check_u1);			
			while ($data_check_u1 = mysql_fetch_assoc($res_check_u1)) {
				if ($data_check_u1['lead_recource'] == 'form') {
					$form_leads_arr[] = $data_check_u1;
				}
				else{
					$phone_leads_id_arr[] = $data_check_u1['phone_lead_id'];
					$phone_leads_arr[] = $data_check_u1;
				}
			}
			foreach($form_leads_arr as $form_lead){
				$total_form_leads++;
				if($form_lead['payByPassword'] == '1'){
					$total_form_leads_paybypswd++;
				}
				else{
					$total_form_leads_paybypswd_closed++;
				}
				if($form_lead['lead_billed'] == '1'){
					$total_form_leads_billed++;
				}
				else{
					if($form_lead['lead_billed_id'] != '' && $form_lead['lead_billed_id'] != '0'){
						
						$total_form_leads_doubled++;
					}
					elseif($form_lead['payByPassword'] == "1" && $form_lead['estimateFormID'] == "0"){
						$total_form_leads_billed++;
					}
				}
				if($form_lead['status'] == '6'){
					$total_form_leads_refunded++;
				}				
			}
			$total_form_leads_to_pay = $total_form_leads_billed - $total_form_leads_refunded;
			foreach($phone_leads_arr as $phone_lead){
				$total_phone_leads++;
				if($phone_lead['payByPassword'] == '1'){
					$total_phone_leads_paybypswd++;
				}
				else{
					$total_phone_leads_paybypswd_closed++;
				}
				if($phone_lead['lead_billed'] == '1'){
					$total_phone_leads_billed++;
				}
				else{
					if($phone_lead['lead_billed_id'] != '' && $phone_lead['lead_billed_id'] != '0'){
						$total_phone_leads_doubled++;
					}
				}
				if($phone_lead['status'] == '6'){
					$total_phone_leads_refunded++;
				}				
			}			
			$total_phone_leads_to_pay = $total_phone_leads_billed - $total_phone_leads_refunded;
	
			
			$sum_total_leads = $sum_total_leads + $total_form_leads + $total_phone_leads;
			$sum_total_leads_to_pay = $sum_total_leads_to_pay + $total_form_leads_to_pay + $total_phone_leads_to_pay;
			

			
			$havaSms = ( $data['havaSms'] == "1" ) ? "כן" : "לא";
			$haveContact = ( $data['haveContact'] == "1" ) ? "כן" : "לא";
			$freeSend = ( $data['freeSend'] == "1" ) ? "כן" : "לא";
			
			$bgcolor = ( $counter%2 == 0 ) ? "F9F9F9" : "F3F3F3";
			echo "<tr bgcolor='#".$bgcolor."'><td colspan=6 height=3></td></tr>";
			echo "<tr bgcolor='#".$bgcolor."' onmouseover='style.backgroundColor=\"#BBBBFF\"' onmouseout='style.backgroundColor=\"#".$bgcolor."\"'>";
				echo "<td><a href='index.php?main=user_lead_settings&unk=".$data['unk']."&sesid=".SESID."' class='maintext' target='_blank'>".stripslashes($data['clientName'])."</a></td>";
				echo "<td align=center>".$havaSms."</td>";
				echo "<td align=center>".$haveContact."</td>";
				echo "<td align=center>".$freeSend."</td>";
				echo "<td align=center>".$data['leadQry']."</td>";
				echo "<td>";
					echo "<table border='1' cellpadding=5 cellspacing=0 width=100% aligh=right>";
						
						echo "<tr>";
							echo "<td>";
								echo "מקור הלידים";
							echo "</td>";
							echo "<td>";
								echo "נשלחו";
							echo "</td>";						
							echo "<td>";
								echo "פתוחים";
							echo "</td>";								
							echo "<td>";
								echo "סגורים";
							echo "</td>";	
	
							echo "<td>";
								echo "חוייבו";
							echo "</td>";
							echo "<td>";
								echo "כפולים";
							echo "</td>";							
							echo "<td>";
								echo "זוכו";
							echo "</td>";
							echo "<td>";
								echo 'סה"כ לתשלום';
							echo "</td>";							
						echo "</tr>";						
						

						echo "<tr>";
						
							echo "<td>";
								echo "טופס";
							echo "</td>";
												
						
							echo "<td>";
								
								echo $total_form_leads;
							echo "</td>";
						
						
							echo "<td>";
								echo $total_form_leads_paybypswd;
							echo "</td>";
											

						
							echo "<td>";
								echo $total_form_leads_paybypswd_closed;
							echo "</td>";
						

						
							echo "<td>";
								echo $total_form_leads_billed;
							echo "</td>";
						

						
							echo "<td>";	
								echo $total_form_leads_doubled;
							echo "</td>";
						

						
							echo "<td>";
								echo $total_form_leads_refunded;
							echo "</td>";
						
							echo "<td>";
								echo $total_form_leads_to_pay;
							echo "</td>";
						
						echo "</tr>";
						echo "<tr>";
						
							echo "<td>";
								echo "טלפון";
							echo "</td>";
												
						
							echo "<td>";
								
								echo $total_phone_leads;
							echo "</td>";
						
						
							echo "<td>";
								echo $total_phone_leads_paybypswd;
							echo "</td>";
											

						
							echo "<td>";
								echo $total_phone_leads_paybypswd_closed;
							echo "</td>";
						

						
							echo "<td>";
								echo $total_phone_leads_billed;
							echo "</td>";
						

						
							echo "<td>";	
								echo $total_phone_leads_doubled;
							echo "</td>";
						

						
							echo "<td>";
								echo $total_phone_leads_refunded;
							echo "</td>";
						
							echo "<td>";
								echo $total_phone_leads_to_pay;
							echo "</td>";
						
						echo "</tr>";

						echo "<tr><td colspan='8'>";
							echo "סך הכל לתשלום: ";
							echo "<a href='index.php?withouthtml=1&sesid=".SESID."&unk_to_see=".$data['unk']."&main=leadsUserGet_client_csv&s_date=".$defualt_s_date."&e_date=".$defualt_e_date."'>";
								echo $total_form_leads_to_pay+$total_phone_leads_to_pay;
							echo "</a>";
							if(isset($_GET['test'])){
							echo "<br/>";
							echo "<a target='_blank' href='index.php?test=1&withouthtml=1&sesid=".SESID."&unk_to_see=".$data['unk']."&main=leadsUserGet_client_csv&s_date=".$defualt_s_date."&e_date=".$defualt_e_date."'>";
								echo "----";
							echo "</a>";
							echo "<br/>"; 
							echo "<a target='_blank' href='index.php?user_test=1&sesid=".SESID."&unk=".$data['unk']."&main=leadsUserGet&s_date=".$defualt_s_date."&e_date=".$defualt_e_date."'>";
								echo "see report";
							echo "</a>";							
							}
						echo "</td></tr>";
					echo "</table>";
				echo "</td>";
			echo "</tr>";
			echo "<tr bgcolor='#".$bgcolor."'><td colspan=6 height=3></td></tr>";
			echo "<tr bgcolor='#000000'><td colspan=6 height=1></td></tr>";
			$sum_leads = $stats_totalU + $sum_leads;
			$sum_leads_pay = $stats_total_to_pay + $sum_leads_pay;
			$counter++;
		}

		echo "<tr>";
			echo "<td colspan=5>";
				echo "<font style='color: green;'>סך הכל מחזור לידים: <b>".$sum_total_leads."</b></font>";
			echo "</td>";
		echo "</tr>";
		
		echo "<tr>";
			echo "<td colspan=5>";
				echo "<font style='color: green;'>סך הכל לידים לתשלום: <b>".$sum_total_leads_to_pay."</b></font>";
			echo "</td>";
		echo "</tr>";
		
	echo "</table>";
}

function leadsUserGet_test()
{

	$defualt_s_date = ( isset($_GET['s_date']) && $_GET['s_date'] != "" ) ? $_GET['s_date'] : date('01-m-Y');
	$defualt_e_date = ( isset($_GET['e_date']) && $_GET['e_date'] != "" ) ? $_GET['e_date'] : date('d-m-Y');
	
	
	
	$ex_s = explode("-",$defualt_s_date);
	$ex_e = explode("-",$defualt_e_date);
	
	$ex_start = $ex_s[2]."-".$ex_s[1]."-".$ex_s[0];
	$ex_end = $ex_e[2]."-".$ex_e[1]."-".$ex_e[0];
	$s_date = ( $defualt_s_date != "" ) ? "AND sent.date_in >= '".$ex_start."' " : "";
	
	$e_date = ( $defualt_e_date != "" ) ? "AND sent.date_in <= '".$ex_e[2]."-".$ex_e[1]."-".$ex_e[0]."' " : "";
	
	
	
	
	$s_date2 = ( $defualt_s_date != "" ) ? "AND date >= '".$ex_start."' " : "";
	$e_date2 = ( $defualt_e_date != "" ) ? "AND date <= '".$ex_end."' " : "";
	
	$s_date3 = ( $defualt_s_date != "" ) ? "AND call_date >= '".$ex_start."' " : "";
	$e_date3 = ( $defualt_e_date != "" ) ? "AND call_date <= '".$ex_end."' " : "";
	
	$s_date4 = ( $defualt_s_date != "" ) ? "AND date_in >= '".$ex_start."' " : "";
	$e_date4 = ( $defualt_e_date != "" ) ? "AND date_in <= '".$ex_end."' " : "";

	$total_form_leads = 0;
	
	$total_form_leads_paybypswd = 0;
	$total_form_leads_paybypswd_closed = 0;
	
	$total_form_leads_billed = 0;
	$total_form_leads_doubled = 0;
	$total_form_leads_refunded = 0;

	$total_phone_leads = 0;
	$total_phone_leads_paybypswd = 0;
	$total_phone_leads_paybypswd_closed = 0;
	$total_phone_leads_billed = 0;
	$total_phone_leads_doubled = 0;
	$total_phone_leads_refunded = 0;
	
	$total_to_pay = 0;
	$form_leads_arr = array();
	$phone_leads_arr = array();
	//$phone_leads_id_arr = array();
	$sql_check_u1 = "SELECT  * FROM user_contact_forms WHERE unk = '" . $_GET['unk'] . "' ".$s_date4.$e_date4;
	$res_check_u1 = mysql_db_query(DB, $sql_check_u1);		
	$stat_ids = array();
	while ($data_check_u1 = mysql_fetch_assoc($res_check_u1)) {
		if ($data_check_u1['lead_recource'] == 'form') {
			$form_leads_arr[] = $data_check_u1;
		}
		else{
			//$phone_leads_id_arr[] = $data_check_u1['phone_lead_id'];
			$phone_leads_arr[] = $data_check_u1;
			//$stat_ids[$data_check_u1['phone_lead_id']] = '1';
		}
	}
	
/*	
  // SQL query that get the phones call
  $sql_stats = "SELECT id,sms_send,call_from,answer,call_date,billsec  FROM sites_leads_stat WHERE unk = '".$_GET['unk']."' AND `call_date` >= '".$ex_start."' AND `call_date` <= '".$ex_end."'";
  $res_stats = mysql_db_query(DB, $sql_stats);
  $stsat_ilist = array();
  while ($data_stats = mysql_fetch_assoc($res_stats)) {	
	echo "-";
	$stsat_ilist[$data_stats['id']] = '1';
	if(!isset($stat_ids[$data_stats['id']])){
		echo "<br/>".$data_stats['id']."<br>";
	}
  }	
  echo "<br/>";
  foreach($stat_ids as $skey=>$st){
	  echo "-";
	  if(!isset($stsat_ilist[$skey])){
		  echo "<br/>".$skey."<br>";
	  }
  }
  
*/  
	$phones_uniq = array();
	foreach($form_leads_arr as $form_lead){

		$lead_doubled = false;
		if(isset($phones_uniq[$form_lead['phone']])){
			$lead_doubled = true;
		}
		else{
			$phones_uniq[$form_lead['phone']] = $form_lead['id'];
		}
		$total_form_leads++;
		if($form_lead['payByPassword'] == '1'){
			$total_form_leads_paybypswd++;
		}
		else{
			$total_form_leads_paybypswd_closed++;
		}
		if($form_lead['lead_billed'] == '1'){
			$total_form_leads_billed++;
			if($lead_doubled){
				echo "-.-".$form_lead['phone']."----".$phones_uniq[$form_lead['phone']]."----".$form_lead['id']."<br/>";
				$total_form_leads_billed--;
				$total_form_leads_doubled++;
			}
		}
		else{
			if($form_lead['lead_billed_id'] != '' && $form_lead['lead_billed_id'] != '0'){
				if(!$lead_doubled){
					echo "+++".$form_lead['phone']."<br/>";
					$total_form_leads_billed++;
					$total_form_leads_doubled--;
				}
				$total_form_leads_doubled++;
			}
			elseif($form_lead['payByPassword'] == "1" && $form_lead['estimateFormID'] == "0"){
				$total_form_leads_billed++;
				if($lead_doubled){
					echo "-_-".$form_lead['phone']."----".$phones_uniq[$form_lead['phone']]."<br/>";
					$total_form_leads_billed--;
					$total_form_leads_doubled++;
				}
			}
		}
		if($form_lead['status'] == '6'){
			$total_form_leads_refunded++;
		}				
	}
	
	$total_form_leads_to_pay = $total_form_leads_billed - $total_form_leads_refunded;
	
	foreach($phone_leads_arr as $phone_lead){
		
		
		
		$lead_doubled = false;
		if(isset($phones_uniq[$phone_lead['phone']])){
			$lead_doubled = true;
		}
		else{
			$phones_uniq[$phone_lead['phone']] = $phone_lead['id'];
		}
		$phones_uniq[$phone_lead['phone']] = '1';		
		$total_phone_leads++;
		if($phone_lead['payByPassword'] == '1'){
			$total_phone_leads_paybypswd++;
		}
		else{
			$total_phone_leads_paybypswd_closed++;
		}
		if($phone_lead['lead_billed'] == '1'){
			$total_phone_leads_billed++;
				if($lead_doubled){
					echo "-_1_-".$phone_lead['phone']."----".$phones_uniq[$phone_lead['phone']]."<br/>";
					$total_phone_leads_billed--;
					$total_phone_leads_doubled++;
				}
 			
		}
		else{
			if($phone_lead['lead_billed_id'] != '' && $phone_lead['lead_billed_id'] != '0'){
				$total_phone_leads_doubled++;
					if(!$lead_doubled){
					echo "+++".$phone_lead['phone']."<br/>";
					$total_phone_leads_billed++;
					$total_phone_leads_doubled--;
				}
			}
		}
		if($phone_lead['status'] == '6'){
			$total_phone_leads_refunded++;
		}				
	}	
			$total_phone_leads_to_pay = $total_phone_leads_billed - $total_phone_leads_refunded;
	
			
			$sum_total_leads = $total_form_leads + $total_phone_leads;
			$sum_total_leads_to_pay = $total_form_leads_to_pay + $total_phone_leads_to_pay;
			

			
			$havaSms = ( $data['havaSms'] == "1" ) ? "כן" : "לא";
			$haveContact = ( $data['haveContact'] == "1" ) ? "כן" : "לא";
			$freeSend = ( $data['freeSend'] == "1" ) ? "כן" : "לא";
			
			$bgcolor = ( $counter%2 == 0 ) ? "F9F9F9" : "F3F3F3";	
	echo "<table border='1' cellpadding=5 cellspacing=0 width=100% aligh=right>";
		
		echo "<tr>";
			echo "<td>";
				echo "מקור הלידים";
			echo "</td>";
			echo "<td>";
				echo "נשלחו";
			echo "</td>";						
			echo "<td>";
				echo "פתוחים";
			echo "</td>";								
			echo "<td>";
				echo "סגורים";
			echo "</td>";	

			echo "<td>";
				echo "חוייבו";
			echo "</td>";
			echo "<td>";
				echo "כפולים";
			echo "</td>";							
			echo "<td>";
				echo "זוכו";
			echo "</td>";
			echo "<td>";
				echo 'סה"כ לתשלום';
			echo "</td>";							
		echo "</tr>";						
		

		echo "<tr>";
		
			echo "<td>";
				echo "טופס";
			echo "</td>";
								
		
			echo "<td>";
				
				echo $total_form_leads;
			echo "</td>";
		
		
			echo "<td>";
				echo $total_form_leads_paybypswd;
			echo "</td>";
							

		
			echo "<td>";
				echo $total_form_leads_paybypswd_closed;
			echo "</td>";
		

		
			echo "<td>";
				echo $total_form_leads_billed;
			echo "</td>";
		

		
			echo "<td>";	
				echo $total_form_leads_doubled;
			echo "</td>";
		

		
			echo "<td>";
				echo $total_form_leads_refunded;
			echo "</td>";
		
			echo "<td>";
				echo $total_form_leads_to_pay;
			echo "</td>";
		
		echo "</tr>";
		echo "<tr>";
		
			echo "<td>";
				echo "טלפון";
			echo "</td>";
								
		
			echo "<td>";
				
				echo $total_phone_leads;
			echo "</td>";
		
		
			echo "<td>";
				echo $total_phone_leads_paybypswd;
			echo "</td>";
							

		
			echo "<td>";
				echo $total_phone_leads_paybypswd_closed;
			echo "</td>";
		

		
			echo "<td>";
				echo $total_phone_leads_billed;
			echo "</td>";
		

		
			echo "<td>";	
				echo $total_phone_leads_doubled;
			echo "</td>";
		

		
			echo "<td>";
				echo $total_phone_leads_refunded;
			echo "</td>";
		
			echo "<td>";
				echo $total_phone_leads_to_pay;
			echo "</td>";
		
		echo "</tr>";

		echo "<tr><td colspan='8'>";
			echo "סך הכל לתשלום: ";
			echo "<a href='index.php?withouthtml=1&sesid=".SESID."&unk_to_see=".$data['unk']."&main=leadsUserGet_client_csv&s_date=".$defualt_s_date."&e_date=".$defualt_e_date."'>";
				echo $total_form_leads_to_pay+$total_phone_leads_to_pay;
			echo "</a>";
			if(isset($_GET['test'])){
			echo "<br/>";
			echo "<a target='_blank' href='index.php?test=1&withouthtml=1&sesid=".SESID."&unk_to_see=".$data['unk']."&main=leadsUserGet_client_csv&s_date=".$defualt_s_date."&e_date=".$defualt_e_date."'>";
				echo "----";
			echo "</a>";							
			}
		echo "</td></tr>";
	echo "</table>";
}




function leadsUserGet_client_csv()
{
	$defualt_s_date = ( isset($_GET['s_date']) && $_GET['s_date'] != "" ) ? $_GET['s_date'] : date('1-m-Y');
	$defualt_e_date = ( isset($_GET['e_date']) && $_GET['e_date'] != "" ) ? $_GET['e_date'] : date('d-m-Y');
	
	$ex_s = explode("-",$defualt_s_date);
	$s_date = ( $defualt_s_date != "" ) ? $ex_s[2]."-".$ex_s[1]."-".$ex_s[0] : "";
	$ex_e = explode("-",$defualt_e_date);
	$e_date = ( $defualt_e_date != "" ) ? $ex_e[2]."-".$ex_e[1]."-".$ex_e[0] : "";
	
	
	$unk = $_GET['unk_to_see'];
  $leadCounter=0;
  $row_leads_arr = array();

  // SQL query that get by the user unk - the user contact forms between the date of the date right now -1 , and the the day before a month.
  $sql2 = "SELECT  distinct unk,phone,email,name,content,status,payByPassword, lead_recource,date_in FROM user_contact_forms WHERE unk = '" . $unk . "' AND date_in >= '".$s_date."' AND date_in <= '".$e_date."'";
  $result = mysql_db_query(DB, $sql2);
  
  // SQL query that get the phones call
  $sql3 = "SELECT distinct sms_send,call_from,answer,call_date,billsec  FROM sites_leads_stat WHERE unk = '".$unk."' AND `call_date` >= '".$s_date."' AND `call_date` <= '".$e_date."'";
  $res = mysql_db_query(DB, $sql3);
  $phones_refunded = array();
  $refund_total = 0;
  $leads_doubled = array();
  $leadCounter_all = 0;
  $leads_doubled_counter = 0;
  $row_leads_arr[] = array('רשימת טופסי צור קשר:');
  $row_leads_arr[] = array('תאריך', 'שם מלא', 'דוא"ל', 'טלפון', 'תוכן','פתוח' , 'מקור הליד','קיבל זיכוי' );
  $phones = array(); 
  while ($data = mysql_fetch_assoc($result)) {
	  if($data['status'] == '6'){
		  $phones_refunded[$data['phone']] = '1';
		  $refund_total++;
	  }
	  if($data['lead_recource'] != 'form'){
		  continue;
	  }
      if (! isValidPhone($data['phone'])) { // phone validation.
         // continue; 
      }
	  $leadCounter_all++;
	  if($data['payByPassword'] == '1'){
		$leadCounter_opened++;
	  }
	  else{
		 $leadCounter_closed++;
	  }
      if(in_array($data['phone'], $phones)){ // Verify uniq phone call 
          $leads_doubled_counter++;
		  $leads_doubled[] = $data;
		  continue;
      }
      $phones[] = $data['phone'];
	  $refunded = "לא";
	  if(isset($phones_refunded[$data['phone']])){
		  $refunded = "כן";
	  }
      $row_leads_arr[] = array( stripslashes($data['date_in']) , stripslashes($data['name']) , stripslashes($data['email']) , stripslashes($data['phone']) , stripslashes($data['content']),$data['payByPassword'] , 'טופס באתר',$refunded );
      if($data['payByPassword'] == '1'){
		$leadCounter++;
	  }
  }
  $row_leads_arr[] = array("----");
  $phones_doubled = array();
  $row_leads_arr[] = array('רשימת טלפונים שהתקבלו:');
  while ($data = mysql_fetch_assoc($res)) {
      $leadCounter_all++;
	  $leadCounter_opened++;
	  if(in_array($data['call_from'], $phones) ){ // Verify uniq phone call 
		 $leads_doubled_counter++;
		$phones_doubled[] = $data;
          continue;
      }
	  $refunded = "לא";
	  if(isset($phones_refunded[$data['call_from']])){
		  $refunded = "כן";
	  }
      $answ = ( $data['billsec'] == '0' ) ? "ללא מענה" : "שיחה של ".$data['billsec']." שניות";
      $row_leads_arr[] = array( stripslashes($data['call_date']) , '' , '' , stripslashes($data['call_from'])  , $answ , 'מערכת טלפונייה',$refunded );
      $phones[] = $data['call_from'];
      $leadCounter++;
  }
  $row_leads_arr[] = array("----");
  $row_leads_arr[] = array('כפילויות בטפסים');
  foreach($leads_doubled as $data){
	  $row_leads_arr[] = array( stripslashes($data['date_in']) , stripslashes($data['name']) , stripslashes($data['email']) , stripslashes($data['phone']) , stripslashes($data['content']) , 'טופס באתר',$refunded );
  }
  $row_leads_arr[] = array("----");
  $row_leads_arr[] = array('כפילויות טלפונים');
  foreach($phones_doubled as $data){
	 $row_leads_arr[] = array( stripslashes($data['call_date']) , '' , '' , stripslashes($data['call_from'])  , $answ , 'מערכת טלפונייה',$refunded );
  }
$row_leads_arr[] = array("----");  
  $row_leads_arr[] = array('סך הכל פניות' , $leadCounter_all );
  $row_leads_arr[] = array('פתוחות' , $leadCounter_opened );
  $row_leads_arr[] = array('סגורות' , $leadCounter_closed );
  $row_leads_arr[] = array('לידים כפולים' , $leads_doubled_counter );
  $row_leads_arr[] = array('פניות שחויבו' , $leadCounter );
  $row_leads_arr[] = array('סך הכל זיכויים' , $refund_total );
  $row_leads_arr[] = array('סך הכל לחיוב' , ($leadCounter - $refund_total) );
  if(isset($_GET['test'])){
	echo "<table border=1 style='direction:rtl; text-align:right; border-collapse: collapse;'>";
	$max_cols = 0;
	foreach($row_leads_arr as $row){
		$cols_count = count($row);
		if($cols_count > $max_cols){
			$max_cols = $cols_count;
		}
	}
	foreach($row_leads_arr as $row){
		echo "<tr>";
			$col_count = 0;
			foreach($row as $col){
				echo "<td>".$col."</td>";
				$col_count ++;
			}
			$col_left = $max_cols - $col_count;
			if($col_left > 0){
				echo "<td colspan='".$col_left."'></td>";
			}
		echo "</tr>";
	}
	echo "</table>";
	 exit();
  }
  array_to_csv_download($row_leads_arr);
  die;
}

function leadsUserGet_old()
{
	$clientName = ( $_GET['clientName'] != "" ) ? "u.name LIKE '%".$_GET['clientName']."%' AND " : "";
	
	$defualt_s_date = ( isset($_GET['s_date']) && $_GET['s_date'] != "" ) ? $_GET['s_date'] : date('01-m-Y');
	$defualt_e_date = ( isset($_GET['e_date']) && $_GET['e_date'] != "" ) ? $_GET['e_date'] : date('d-m-Y');
	
	$ex_s = explode("-",$defualt_s_date);
	$s_date = ( $defualt_s_date != "" ) ? "AND sent.date >= '".$ex_s[2]."-".$ex_s[1]."-".$ex_s[0]."' " : "";
	$ex_e = explode("-",$defualt_e_date);
	$e_date = ( $defualt_e_date != "" ) ? "AND sent.date <= '".$ex_e[2]."-".$ex_e[1]."-".$ex_e[0]."' " : "";
	
	$s_date2 = ( $defualt_s_date != "" ) ? "AND date >= '".$ex_s[2]."-".$ex_s[1]."-".$ex_s[0]."' " : "";
	$e_date2 = ( $defualt_e_date != "" ) ? "AND date <= '".$ex_e[2]."-".$ex_e[1]."-".$ex_e[0]."' " : "";
	
	$sql = "SELECT uls.* , u.name AS clientName
		FROM user_lead_settings AS uls , user_lead_sent AS sent , users AS u WHERE 
			uls.unk=u.unk AND
			".$clientName."
			uls.unk=sent.sendToUnk
			".$s_date.$e_date ."
			GROUP BY uls.unk
	";
	/*
	$page_limit = 50;
	$page = (isset($_GET['page']))?$_GET['page']: 1; 
	$page_limit_qry = " LIMIT ".(($page - 1)*$page_limit).",".($page*$page_limit)." ";
	
	$res = mysql_db_query(DB,$sql);	

	$total_paging = mysql_num_rows($res);
	
	$page_sql = $sql.$page_limit_qry;
	$res = mysql_db_query(DB,$page_sql);		
*/	
	$res = mysql_db_query(DB,$sql);
	$more = new GlobalFunctions();
	$lead = new lead();
	
	
	echo "<table class=\"maintext\" cellpadding=0 cellspacing=0>";
		echo "<tr>";
			echo "<td><A href=\"?sesid=".SESID."\" class=\"maintext\">חזרה לתפריט הראשי</a></td>";
		echo "</tr>";
		echo "<tr><td colspan=6 height=10></td></tr>";
		echo "<tr>";
			echo "<td colspan=6>";
				echo "<form action='index.php' name='serachForm' method='get' style='padding:0;margin:0'>";
				echo "<input type='hidden' name='sesid' value='".SESID."'>";
				echo "<input type='hidden' name='main' value='leadsUserGet'>";
				echo "<table class=\"maintext\" cellpadding=0 cellspacing=0>";
					echo "<tr>";
						echo "<td>שם לקוח</td>";
						echo "<td width=10></td>";
						echo "<td><input type='text' name='clientName' value='".$_GET['clientName']."' class='input_style' style='width: 100px;' /></td>";
						echo "<td width=40></td>";
						echo "<td>מספור לידים בין התאריך</td>";
						echo "<td width=10></td>";
						echo "<td><input type='text' name='s_date' value='".$defualt_s_date."' class='input_style' style='width: 100px;' /></td>";
						echo "<td width=20></td>";
						echo "<td>לתאריך</td>";
						echo "<td width=10></td>";
						echo "<td><input type='text' name='e_date' value='".$defualt_e_date."' class='input_style' style='width: 100px;' /></td>";
						echo "<td width=40></td>";
						echo "<td><input type='submit' value='חפש!' class='submit_style'></td>";
					echo "</tr>";
				echo "</table>";
				echo "</form>";
			echo "</td>";
		echo "</tr>";
		echo "<tr><td colspan=6 height=20></td></tr>";
		echo "<tr>";
			echo "<th>שם הלקוח</th>";
			echo "<th>הודעות SMS</th>";
			echo "<th>הודעות צור קשר</th>";
			echo "<th>שליחה חופשית</th>";
			echo "<th>יתרת הודעות</th>";
			echo "<th>מספור לידים בין התאריכים</th>";
		echo "</tr>";
		echo "<tr bgcolor='#000000'><td colspan=6 height=1></td></tr>";
		$sum_leads=0;
		$counter=0;
		
		$s_date2 = ( $defualt_s_date != "" ) ? "AND date >= '".$ex_s[2]."-".$ex_s[1]."-".$ex_s[0]."' " : "";
		$e_date2 = ( $defualt_e_date != "" ) ? "AND date <= '".$ex_e[2]."-".$ex_e[1]."-".$ex_e[0]."' " : "";
		
		$s_date3 = ( $defualt_s_date != "" ) ? "AND call_date >= '".$ex_s[2]."-".$ex_s[1]."-".$ex_s[0]."' " : "";
		$e_date3 = ( $defualt_e_date != "" ) ? "AND call_date <= '".$ex_e[2]."-".$ex_e[1]."-".$ex_e[0]."' " : "";
		
		$s_date4 = ( $defualt_s_date != "" ) ? "AND date_in >= '".$ex_s[2]."-".$ex_s[1]."-".$ex_s[0]."' " : "";
		$e_date4 = ( $defualt_e_date != "" ) ? "AND date_in <= '".$ex_e[2]."-".$ex_e[1]."-".$ex_e[0]."' " : "";
		

		
		while( $data = mysql_fetch_array( $res ) )
		{
      $stats_total_to_pay = 0;

      // SQL query that get by the user unk - the user contact forms between the date of the date right now -1 , and the the day before a month.
      $sql_check_u1 = "SELECT  distinct unk,phone,email,name,content,date_in,status,lead_recource FROM user_contact_forms WHERE unk = '" . $data['unk'] . "' ".$s_date4.$e_date4;
      $res_check_u1 = mysql_db_query(DB, $sql_check_u1);
      
      // SQL query that get the phones call
      $sql_check_u2 = "SELECT distinct sms_send,call_from,answer,call_date,billsec  FROM sites_leads_stat WHERE unk = '".$data['unk']."' ".$s_date3.$e_date3;
      $res_check_u2 = mysql_db_query(DB, $sql_check_u2);
      $leads_refunded = 0;
	  $leads_doubled = 0;
      $phones_u_checker = array(); 
      while ($data_check_u1 = mysql_fetch_assoc($res_check_u1)) {
          if ($data_check_u1['lead_recource'] != 'form') { 
              continue; 
          }	
		  if ($data_check_u1['status'] == '6') { 
             $leads_refunded ++;
          }			  
		
          if (! isValidPhone($data_check_u1['phone'])) { // phone validation.
              continue; 
          }
          if(in_array($data_check_u1['phone'], $phones_u_checker)){ // Verify uniq phone call 
			$leads_doubled++;
			continue;
          }
          $phones_u_checker[] = $data_check_u1['phone'];
          $stats_total_to_pay++;
      }
      
      while ($data_check_u2 = mysql_fetch_assoc($res_check_u2)) {
          if(in_array($data_check_u2['call_from'], $phones_u_checker)){ // Verify uniq phone call 
            $leads_doubled++;
			continue;
          }
          $phones_u_checker[] = $data_check_u2['call_from'];
          $stats_total_to_pay++;
      }
			
			
			
			$sql3 = "SELECT id FROM user_lead_sent WHERE sendToUnk = '".$data['unk']."' ".$s_date2.$e_date2." GROUP BY estimateFormID";
			$res3 = mysql_db_query(DB,$sql3);
			
			$stats_totalU=0;
			while(  $data3 = mysql_fetch_array( $res3 ) )
				$stats_totalU++;
			
			$sql2 = "SELECT sendBy,viewedStatus FROM user_lead_sent WHERE sendToUnk = '".$data['unk']."' ".$s_date2.$e_date2." GROUP BY estimateFormID,sendBy";
			$res2 = mysql_db_query(DB,$sql2);
			
			$sql_phone = "SELECT COUNT(id) as n FROM sites_leads_stat WHERE unk = '".$data['unk']."' ".$s_date3.$e_date3." GROUP BY unk";
			$res_phone = mysql_db_query(DB,$sql_phone);
			$data_phone = mysql_fetch_array( $res_phone );
			$count_data_phone = (int)$data_phone['n'];
			
			$stats_totalU = $stats_totalU + $count_data_phone;
			
			$stats_sms=0;
			$stats_contact=0;
			$stats_contact_payed=0;
			$stats_viewd_1_sms=0;
			$stats_viewd_0_sms=0;
			$stats_viewd_1_contact=0;
			$stats_viewd_0_contact=0;
			$stats_viewd_1_payed=0;
			$stats_viewd_0_payed=0;
			
			while( $data2 = mysql_fetch_array( $res2 ) )
			{
				switch( $data2['sendBy'] )
				{
					case "1" :
						$stats_sms++;
						if( $data2['viewedStatus'] == "1" )					$stats_viewd_1_sms++;
						elseif( $data2['viewedStatus'] == "0" )			$stats_viewd_0_sms++;
					break;
					
					case "0" :
						$stats_contact++;
						if( $data2['viewedStatus'] == "1" )					$stats_viewd_1_contact++;
						elseif( $data2['viewedStatus'] == "0" )			$stats_viewd_0_contact++;
					break;
					
					case "2" :
						$stats_contact_payed++;
						if( $data2['viewedStatus'] == "1" )					$stats_viewd_1_payed++;
						elseif( $data2['viewedStatus'] == "0" )			$stats_viewd_0_payed++;
					break;
				}
			}
			
			$havaSms = ( $data['havaSms'] == "1" ) ? "כן" : "לא";
			$haveContact = ( $data['haveContact'] == "1" ) ? "כן" : "לא";
			$freeSend = ( $data['freeSend'] == "1" ) ? "כן" : "לא";
			
			$bgcolor = ( $counter%2 == 0 ) ? "F9F9F9" : "F3F3F3";
			echo "<tr bgcolor='#".$bgcolor."'><td colspan=6 height=3></td></tr>";
			echo "<tr bgcolor='#".$bgcolor."' onmouseover='style.backgroundColor=\"#BBBBFF\"' onmouseout='style.backgroundColor=\"#".$bgcolor."\"'>";
				echo "<td><a href='index.php?main=user_lead_settings&unk=".$data['unk']."&sesid=".SESID."' class='maintext' target='_blank'>".stripslashes($data['clientName'])."</a></td>";
				echo "<td align=center>".$havaSms."</td>";
				echo "<td align=center>".$haveContact."</td>";
				echo "<td align=center>".$freeSend."</td>";
				echo "<td align=center>".$data['leadQry']."</td>";
				echo "<td>";
					echo "<table class=\"maintext\" cellpadding=0 cellspacing=0 width=100% aligh=right>";
						echo "<tr>";
							echo "<td>הודעות: <b>".$stats_sms."</b></td>";
							echo "<td width=7></td>";
							echo "<td style='font-size:11px;'>נצפו:</td>";
							echo "<td width=3></td>";
							echo "<td style='font-size:11px;'>".$stats_viewd_1_sms."</td>";
							echo "<td width=7></td>";
							echo "<td style='font-size:11px;'>אין מידע:</td>";
							echo "<td width=3></td>";
							echo "<td style='font-size:11px;'>".$stats_viewd_0_sms."</td>";
						echo "</tr>";
						echo "<tr>";
							echo "<td>צור קשר: <b>".$stats_contact."</b></td>";
							echo "<td width=7></td>";
							echo "<td style='font-size:11px;'>נצפו:</td>";
							echo "<td width=3></td>";
							echo "<td style='font-size:11px;'>".$stats_viewd_1_contact."</td>";
							echo "<td width=7></td>";
							echo "<td style='font-size:11px;'>אין מידע:</td>";
							echo "<td width=3></td>";
							echo "<td style='font-size:11px;'>".$stats_viewd_0_contact."</td>";
						echo "</tr>";
						echo "<tr>";
							echo "<td>חיוב על צפיה: <b>".$stats_contact_payed."</b></td>";
							echo "<td width=7></td>";
							echo "<td style='font-size:11px;'>נצפו:</td>";
							echo "<td width=3></td>";
							echo "<td style='font-size:11px;'>".$stats_viewd_1_payed."</td>";
							echo "<td width=7></td>";
							echo "<td style='font-size:11px;'>אין מידע:</td>";
							echo "<td width=3></td>";
							echo "<td style='font-size:11px;'>".$stats_viewd_0_payed."</td>";
						echo "</tr>";
						echo "<tr>";
							echo "<td>טלפונים: <b>".$count_data_phone."</b></td>";
							echo "<td width=7></td>";
							echo "<td style='font-size:11px;'></td>";
							echo "<td width=3></td>";
							echo "<td style='font-size:11px;'></td>";
							echo "<td width=7></td>";
							echo "<td style='font-size:11px;'></td>";
							echo "<td width=3></td>";
							echo "<td style='font-size:11px;'></td>";
						echo "</tr>";
						echo "<tr>";
							echo "<td colspan=9 align=right style='font-size:11px;'>סך הכל: ".$stats_totalU."</td>";
						echo "</tr>";
						echo "<tr>";
							echo "<td colspan=9 align=right style='font-size:11px;'>לידים כפולים: ".$leads_doubled."</td>";
						echo "</tr>";						 
						echo "<tr>";
							echo "<td colspan=9 align=right style='font-size:11px;'>סך הכל לחיוב: <a href='index.php?withouthtml=1&sesid=".SESID."&unk_to_see=".$data['unk']."&main=leadsUserGet_client_csv&s_date=".$defualt_s_date."&e_date=".$defualt_e_date."'>".$stats_total_to_pay."</a></td>";
						echo "</tr>";
						echo "<tr>";
							echo "<td colspan=9 align=right style='font-size:11px;'>זיכויים: ".$leads_refunded."</td>";
						echo "</tr>";	
						
						echo "<tr>";
							echo "<td colspan=9 align=right style='font-size:11px;'>חיוב לאחר זיכוי: ".($stats_total_to_pay - $leads_refunded)."</td>";
						echo "</tr>";	

						
					echo "</table>";
				echo "</td>";
			echo "</tr>";
			echo "<tr bgcolor='#".$bgcolor."'><td colspan=6 height=3></td></tr>";
			echo "<tr bgcolor='#000000'><td colspan=6 height=1></td></tr>";
			$sum_leads = $stats_totalU + $sum_leads;
			$sum_leads_pay = $stats_total_to_pay + $sum_leads_pay;
			$counter++;
		}
		
		echo "<tr>";
			echo "<td colspan=5>";
				echo "<font style='color: green;'>סך הכל מחזור לידים: <b>".$sum_leads."</b></font>";
			echo "</td>";
		echo "</tr>";
		
		echo "<tr>";
			echo "<td colspan=5>";
				echo "<font style='color: green;'>סך הכל לידים לתשלום: <b>".$sum_leads_pay."</b></font>";
			echo "</td>";
		echo "</tr>";
		
	echo "</table>";
}


function sentLeadsAll()
{
	$lead = new lead();
	$GlobalFunctions= new GlobalFunctions();
	
	
	echo "<table class=\"maintext\" cellpadding=5>";
		echo "<tr>";
			echo "<td colspan=4><h3>הודעות שנשלחו ללקוח</h3></td>";
		echo "</tr>";
		
		echo "<tr>";
			echo "<td><b>תאריך ושעה</b></td>";
			echo "<td><b>שם השולח</b></td>";
			echo "<td><b>עיר</b></td>";
			echo "<td><b>נשלח על ידי</b></td>";
			echo "<td><b>נצפה על ידי הלקוח</b></td>";
			echo "<td></td>";
		echo "</tr>";
		
		$params['sendToUnk'] = $_GET['unk'];
		$params['limit'] = "10000";
		
		$res = mysql_db_query(DB, $lead->leadSent($params) );
		while ( $data = mysql_fetch_array($res) )
		{
			$params['id'] = $data['estimateFormID'];
			$res2 = mysql_db_query(DB, $lead->getEstimateDetails( $params ) );
			$dataEstimate = mysql_fetch_array($res2);
			
			echo "<tr>";
				echo "<td>".$GlobalFunctions->show_dateTime_field($data['date'])."</td>";
				echo "<td>".$dataEstimate['name']."</td>";
				$NewCity = ( $dataEstimate['NewCity'] != "" ) ? $dataEstimate['NewCity'] : $dataEstimate['city'];
				echo "<td>".$NewCity."</td>";
				echo "<td>".$lead->sendByArr($data['sendBy'])."</td>";
				echo "<td>".$lead->viewedStatusArr($data['viewedStatus'])."</td>";

			echo "</tr>";
		}
	
	echo "</table>";
}

if( !function_exists("isValidPhone") )
{
	function isValidPhone($phone)
	{
		$phone = trim($phone);
		if (0 === strpos($phone, '972')) {
		   $phone = preg_replace('/972/', '0', $phone, 1);
		}
	    $pattern = '/^(0)+([0-9])/';
	    if (preg_match($pattern, $phone) && (strlen($phone) > 5)) {
	        return true;
	    } else {
	        return false;
	    }
	}
}

function array_to_csv_download($data, $filename = "export.csv", $delimiter=";") {
    // open raw memory as file so no temp files needed, you might run out of memory though
    $f = fopen('php://memory', 'w'); 
    // loop over the input array
    
    foreach ($data as $line) fputcsv($f, $line);
    
    // reset the file pointer to the start of the file
    fseek($f, 0);
    // tell the browser it's going to be a csv file
    header('Content-Type: application/csv');
    // tell the browser we want to save it instead of displaying it
    header('Content-Disposition: attachment; filename="'.$filename.'";');
    // make php send the generated csv lines to the browser
    fpassthru($f);
}
?>