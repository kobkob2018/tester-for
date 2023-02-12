<?

function view_contacts()
{
	
	$status = ( empty($_GET['status']) ) ? "0" : $_GET['status'];
	
	$sql = "select * from contacts where status = '".$status."' order by id";
	$res = mysql_db_query(DB, $sql);
	
	
	echo "<table border=\"0\" cellspacing=\"0\" cellpadding=\"0\" class=\"maintext\">";
	
		$s_status_0 = ( $status == "0" ) ? "<b>" : "";
		$e_status_0 = ( $status == "0" ) ? "</b>" : "";
		
		$s_status_1 = ( $status == "1" ) ? "<b>" : "";
		$e_status_1 = ( $status == "1" ) ? "</b>" : "";
		
		$s_status_2 = ( $status == "2" ) ? "<b>" : "";
		$e_status_2 = ( $status == "2" ) ? "</b>" : "";
		
		$s_status_3 = ( $status == "3" ) ? "<b>" : "";
		$e_status_3 = ( $status == "3" ) ? "</b>" : "";
		
		$s_status_4 = ( $status == "4" ) ? "<b>" : "";
		$e_status_4 = ( $status == "4" ) ? "</b>" : "";
		
		$s_status_9 = ( $status == "9" ) ? "<b>" : "";
		$e_status_9 = ( $status == "9" ) ? "</b>" : "";
		
		echo "<tr>";
			echo "<td colspan=20>";
				echo "<table border=\"0\" cellspacing=\"0\" cellpadding=\"0\" class=\"maintext\">";
					echo "<tr>";
						echo "<td><a href='index.php?sesid=".SESID."' class='maintext'>תפריט ראשי</a></td>";
						echo "<td width=70></td>";
						echo "<td><a href='index.php?main=view_contacts&status=0&sesid=".SESID."' class='maintext'>".$s_status_0."פניות חדשות".$e_status_0."</a></td>";
						echo "<td width=20></td>";
						echo "<td><a href='index.php?main=view_contacts&status=1&sesid=".SESID."' class='maintext'>".$s_status_1."פניות בטיפול".$e_status_1."</a></td>";
						echo "<td width=20></td>";
						echo "<td><a href='index.php?main=view_contacts&status=2&sesid=".SESID."' class='maintext'>".$s_status_2."רעיונות לעתיד".$e_status_2."</a></td>";
						echo "<td width=20></td>";
						echo "<td><a href='index.php?main=view_contacts&status=3&sesid=".SESID."' class='maintext'>".$s_status_3."פניות שנענו".$e_status_3."</a></td>";
						echo "<td width=20></td>";
						echo "<td><a href='index.php?main=view_contacts&status=4&sesid=".SESID."' class='maintext'>".$s_status_4."פניות לא רלוונטיות".$e_status_4."</a></td>";
						echo "<td width=20></td>";
						echo "<td><a href='index.php?main=view_contacts&status=9&sesid=".SESID."' class='maintext'>".$s_status_9."פניות מחוקות".$e_status_9."</a></td>";
					echo "</tr>";
				echo "</table>";
			echo "</td>";
		echo "</tr>";
		echo "<tr><td colspan=20 height=15></td><td>";
		echo "<tr>";
			echo "<td><b>תאריך</b></td>";
			echo "<td width=10></td>";
			echo "<td><b>שם מלא</b></td>";
			echo "<td width=10></td>";
			echo "<td><b>מספר טלפון</b></td>";
			echo "<td width=10></td>";
			echo "<td><b>אימייל</b></td>";
			echo "<td width=10></td>";
			echo "<td><b>הערה</b></td>";
			echo "<td width=10></td>";
			echo "<td><b>מקור</b></td>";
			echo "<td width=10></td>";
			echo "<td><b>סטטוס עבודה</b></td>";
		echo "</tr>";
		
		echo "<tr><td colspan=20 height=15></td><td>";
		
		while( $data = mysql_fetch_array($res) )
		{
			switch($data['type'])
			{
				case "1" :			$type_name = " - צור קשר";			break;
				case "2" :			$type_name = " - 2";			break;
				case "3" :			$type_name = " - 3";			break;
				
			}
			
			$new_date = explode("-",$data['insert_date']);
			$thedate = $new_date[2]."-".$new_date[1]."-".$new_date[0];
			
			echo "<form action='?' method='GET' name='change_status_form_".$data['id']."'>";
			echo "<input type='hidden' name='main' value='change_status_for_contact'>";
			echo "<input type='hidden' name='gobeck' value='view_contacts'>";
			echo "<input type='hidden' name='old_status' value='".$status."'>";
			echo "<input type='hidden' name='row_id' value='".$data['id']."'>";
			echo "<input type='hidden' name='table' value='contacts'>";
			echo "<input type='hidden' name='sesid' value='".SESID."'>";
			echo "<tr>";
				echo "<td>".$thedate."</td>";
				echo "<td width=10></td>";
				echo "<td>".stripslashes(htmlspecialchars($data['full_name']))."</td>";
				echo "<td width=10></td>";
				echo "<td>".stripslashes(htmlspecialchars($data['phone']))."</td>";
				echo "<td width=10></td>";
				echo "<td>".stripslashes(htmlspecialchars($data['email']))."</td>";
				echo "<td width=10></td>";
				echo "<td>".nl2br(stripslashes(htmlspecialchars($data['content'])))."</td>";
				echo "<td width=10></td>";
				echo "<td>".$data['fr'].$type_name."</td>";
				echo "<td width=10></td>";
				
					
					$selected_0 = ( $data['status'] == "0" ) ? "selected" : "";
					$selected_1 = ( $data['status'] == "1" ) ? "selected" : "";
					$selected_2 = ( $data['status'] == "2" ) ? "selected" : "";
					$selected_3 = ( $data['status'] == "3" ) ? "selected" : "";
					$selected_4 = ( $data['status'] == "4" ) ? "selected" : "";
					$selected_9 = ( $data['status'] == "9" ) ? "selected" : "";
					
				echo "<td>
					<select name='new_status' class='input_style' style='font-size:11px; width:110px;' onchange='change_status_form_".$data['id'].".submit()'>
						<option value=''>בחירה</option>
						<option value='0' ".$selected_0.">פניות חדשות</option>
						<option value='1' ".$selected_1.">פניות בטיפול</option>
						<option value='2' ".$selected_2.">רעיונות לעתיד</option>
						<option value='3' ".$selected_3.">פניות שנענו</option>
						<option value='4' ".$selected_4.">פניות לא רלוונטיות</option>
						<option value='9' ".$selected_9.">פניות מחוקות</option>
					</select>
				</td>";
			echo "</tr>";
			echo "</form>";
			
			echo "<tr><td colspan=20 height=2></td><td>";
			echo "<tr><td colspan=20><hr width=100% size=1 color=#000000></td><td>";
			echo "<tr><td colspan=20 height=2></td><td>";
		}
		
	echo "</table>"; 
	
}

function view_estimate_form_refund_list()
{
	//pass for phone system server: juzvklcrj
	if(isset($_GET['refund']) && isset($_GET['unk'])){
		if($_GET['refund'] == "0" || $_GET['refund'] == "" || (!isset($_GET['refund_type']))){
			echo "בקשה לא תקינה";
			exit();
		}
		$refund_row = $_GET['refund'];
		$denied = false;
		$cancel_refund = false;
		if(isset($_REQUEST['denied']) && $_REQUEST['denied'] == '1'){
			$checksql = "SELECT status FROM user_contact_forms WHERE id = (SELECT row_id FROM leads_refun_requests WHERE id = ".$_REQUEST['request'].")";
			$checkres = mysql_db_query(DB,$checksql);
			$checkdata = mysql_fetch_array($checkres);
			
			
			if($checkdata['status'] == '6'){
				echo "שגיאה: הליד הזה כבר זוכה <br/>";
				echo "<a href='".$_SERVER['HTTP_REFERER']."' title='go back' >לחץ כאן לחזרה לזיכויים</a>";
				exit("<br/>--");
			}
			$denied = true;
			$refund_sql = "update leads_refun_requests set denied = 1,admin_comment='".$_REQUEST['admin_comment']."' WHERE unk = '" . $_GET['unk'] . "' AND id = ".$_REQUEST['request']."";
			$result = mysql_db_query(DB, $refund_sql);			
		}
		elseif(isset($_REQUEST['cancel_refund']) && $_REQUEST['cancel_refund'] == '1'){
			$cancel_refund = true;
			$refund_sql = "update leads_refun_requests set denied = 1,admin_comment='".$_REQUEST['admin_comment']."' WHERE unk = '" . $_GET['unk'] . "' AND id = ".$_REQUEST['request']."";
			$result = mysql_db_query(DB, $refund_sql);			
			if($_GET['refund_type'] == "phone"){
				$refund_sql = "update user_contact_forms set status = 0 WHERE unk = '" . $_GET['unk'] . "' AND id = ".$refund_row."";
			}
			else{
				$refund_sql = "update user_contact_forms set status = 0 WHERE unk = '" . $_GET['unk'] . "' AND estimateFormID = ".$refund_row."";
			}
			$result = mysql_db_query(DB, $refund_sql);
			$effected_rows =  mysql_affected_rows();
			if($effected_rows > 0){
				$sql = "UPDATE user_lead_settings SET leadQry = leadQry - 1 WHERE unk = '".$_GET['unk']."'";
				$res = mysql_db_query(DB,$sql);
			}
		}
		else{
			if($_GET['refund_type'] == "phone"){
				$refund_sql = "update user_contact_forms set status = 6 WHERE unk = '" . $_GET['unk'] . "' AND id = ".$refund_row."";
			}
			else{
				$refund_sql = "update user_contact_forms set status = 6 WHERE unk = '" . $_GET['unk'] . "' AND estimateFormID = ".$refund_row."";
			}
			$result = mysql_db_query(DB, $refund_sql);
			$effected_rows =  mysql_affected_rows();
			if($effected_rows > 0){
				$sql = "UPDATE user_lead_settings SET leadQry = leadQry + 1 WHERE unk = '".$_GET['unk']."'";
				$res = mysql_db_query(DB,$sql);
			}
		}
		$user_sql = "select name,email from users where 
		unk = '".$_GET['unk']."'";
		
		$user_res = mysql_db_query(DB,$user_sql);
		$user_data = mysql_fetch_array($user_res);
			if($_GET['refund_type'] == "phone"){
				$refund_sql = "SELECT name,phone, status FROM user_contact_forms WHERE unk = '" . $_GET['unk'] . "' AND id = ".$refund_row."";
			}
			else{
				$refund_sql = "SELECT name,phone, status FROM user_contact_forms WHERE unk = '" . $_GET['unk'] . "' AND estimateFormID = ".$refund_row."";
			}		
		$result = mysql_db_query(DB, $refund_sql);
		while( $data = mysql_fetch_array($result) ){
			if($denied){
				echo "התגובה נשלחה ללקוח:"."<br/>".$data['name']."<br>".$data['phone']."<br>";
				
			}
			elseif($cancel_refund){
				echo "הזיכוי בוטל והתגובה נשלחה ללקוח:"."<br/>".$data['name']."<br>".$data['phone']."<br>";
				
			}			
			else{
				echo "ליד זוכה:"."<br/>".$data['name']."<br>".$data['phone']."<br>";			
			}
			$fromEmail = "support@ilbiz.co.il"; 
			$fromTitle = "IL-BIZ"; 
			
			//$data['name'] = iconv("Windows-1255","UTF-8",$data['name']);
			
			$content = "
			שלום, ".stripslashes($user_data['name']).",<br><br>
			בהמשך לבקשתך לזיכוי ליד (".$data['name'].",".$data['phone']."):<br><br> ";
			if(!$denied && !$cancel_refund){
				$content .= "הליד זוכה בהצלחה.";
			}
			else{
				$content .= "הוחלט לא לזכות את הליד.";
				$content .= "<br/><br/> הערות מנהל האתר: <br/>".$_REQUEST['admin_comment'];
			}
			$content .= "<br><br><br>
			בברכה,<br>
			איי אל ביז קידום עסקים באינטרנט<br>";
			
			$header= "זיכוי ליד";
			//$content = iconv("UTF-8","Windows-1255",$content);
			//$header = iconv("UTF-8","Windows-1255",$header);		
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
			
			$ClientMail = $user_data['email'];
			GlobalFunctions::send_emails_with_phpmailer($fromEmail, $fromTitle, $header, $content_send_to_Client, $content_send_to_Client, $ClientMail, $fromTitle );			
		}
		echo "<a href='".$_SERVER['HTTP_REFERER']."' title='go back' >לחץ כאן לחזרה לזיכויים</a>";
		exit;
	}	
	
	
	global $word;
	$refund_reasons = array();
	$refund_reasons_sql = "SELECT * FROM cat_lead_refund_reasons";
	$refund_reasons_res = mysql_db_query(DB,$refund_reasons_sql);
	while($reason = mysql_fetch_array($refund_reasons_res)){
		$refund_reasons[$reason['id']] = $reason['title'];
	}
	$user_refund_reasons = array();
	$refund_reasons_sql = "SELECT * FROM user_phone_leads_refund_reasons";
	$refund_reasons_res = mysql_db_query(DB,$refund_reasons_sql);
	while($reason = mysql_fetch_array($refund_reasons_res)){
		$user_refund_reasons[$reason['id']] = $reason['title'];
	}	

	$status_list = array();
	$status_list[0] = "מתעניין חדש";//$word[LANG]['Interested_service'];
	$status_list[1] = "נוצר קשר";//$word[LANG]['talked_with_him'];
	$status_list[5] = "מחכה לטלפון";//$word[LANG]['Waiting_phone'];
	$status_list[2] = "סגירה עם לקוח";//$word[LANG]['Close_customer'];
	$status_list[3] = "לקוחות רשומים";//$word[LANG]['Registered_customers'];
	$status_list[4] = "לא רלוונטי";//$word[LANG]['Not_relevant'];	
	$status_list[6] = "הליד זוכה";//$word[LANG]['Not_relevant'];		


	$resource_list = array();
	$resource_list['form'] = "טופס";//$word[LANG]['Interested_service'];
	$resource_list['phone'] = "טלפון";//$word[LANG]['talked_with_him'];
	
	$s_dateT = explode( "-", $_GET['s_date'] );
	$e_dateT = explode( "-", $_GET['e_date'] );
	
	$date_from_sql = ( !empty($_GET['s_date']) ) ? " AND refund.request_time >= '".$s_dateT[2]."-".$s_dateT[1]."-".$s_dateT[0]."' " : "";
	$date_to_sql = ( !empty($_GET['e_date']) ) ? " AND refund.request_time <= '".$e_dateT[2]."-".$e_dateT[1]."-".$e_dateT[0]."' " : "";
	$user_name_sql = ( !empty($_GET['user_name']) ) ? " AND (user.full_name LIKE ('%".$_GET['user_name']."%') OR user.name LIKE ('%".$_GET['user_name']."%') ) " : "";
	$where_sql = " WHERE 1 ".$date_from_sql.$date_to_sql.$user_name_sql;
	
	$count_sql = "SELECT COUNT(distinct refund.row_id) as rows_count
			FROM leads_refun_requests refund
			LEFT JOIN user_contact_forms ucf ON refund.row_id = ucf.id
			LEFT JOIN estimate_form ef ON ucf.estimateFormID = ef.id
			LEFT JOIN users user ON ucf.unk = user.unk
		".$where_sql;
			
	$count_res = mysql_db_query(DB, $count_sql);
	$row_count = mysql_fetch_array($count_res);
	$num_rows = $row_count['rows_count'];
	
	$limit_rows = 50;
	$page_id =  ( !empty($_GET['page_id']) ) ? $_GET['page_id'] : '1';
	if($page_id == '0')
		$page_id = '1';
	$limit_row = ($page_id-1)*$limit_rows;
	
	$limit_sql = " LIMIT ".$limit_row.", ".$limit_rows." ";
	$sql = "SELECT 	distinct refund.row_id as row_id 

			FROM leads_refun_requests refund
			LEFT JOIN user_contact_forms ucf ON refund.row_id = ucf.id
			LEFT JOIN estimate_form ef ON ucf.estimateFormID = ef.id
			LEFT JOIN users user ON ucf.unk = user.unk
			LEFT JOIN biz_categories cat_f ON cat_f.id = ef.cat_f
			LEFT JOIN biz_categories cat_s ON cat_s.id = ef.cat_s
			LEFT JOIN biz_categories cat_spec ON cat_spec.id = ef.cat_spec
		 ".$where_sql." ORDER BY refund.id desc ".$limit_sql;
		
		
	$res = mysql_db_query(DB, $sql);			
	$row_ids = array();
	while($row_id_data = mysql_fetch_array($res)){
		$row_ids[] = $row_id_data['row_id'];
	}
	$row_ids_in = implode(",",$row_ids);
	$sql = "SELECT 	user.full_name as user_name, 
					user.unk as user_unk, 
					ucf.estimateFormID as lead_id,
					ucf.lead_recource as lead_recource,
					ucf.phone_lead_id as phone_lead_id,
					ucf.id as ucf_id,
					refund.id as ref_id,
					ucf.status as status,
					ucf.lead_billed as lead_billed,
					ucf.tag as tag,
					refund.reason as reason,
					refund.denied as denied,
					refund.admin_comment as admin_comment,
					refund.request_time as request_time,
					refund.comment as comment,
					cat_f.cat_name as cat_f_name,
					cat_s.cat_name as cat_s_name,
					ucf.name as sender_name,
					ucf.phone as sender_phone,
					ucf.email as sender_email,
					cat_spec.cat_name as cat_spec_name,
					ucf.date_in as send_time,
					ef.note as ef_note

			FROM leads_refun_requests refund
			LEFT JOIN user_contact_forms ucf ON refund.row_id = ucf.id
			LEFT JOIN estimate_form ef ON ucf.estimateFormID = ef.id
			LEFT JOIN users user ON ucf.unk = user.unk
			LEFT JOIN biz_categories cat_f ON cat_f.id = ef.cat_f
			LEFT JOIN biz_categories cat_s ON cat_s.id = ef.cat_s
			LEFT JOIN biz_categories cat_spec ON cat_spec.id = ef.cat_spec
			WHERE refund.row_id IN (".$row_ids_in.") ORDER BY refund.id desc ";
		
		
	$res = mysql_db_query(DB, $sql);	
	$refund_ids = array();
	while( $data = mysql_fetch_array($res)){
		if(!isset($refund_list[$data['ucf_id']])){
			$refund_ids[] = $data['ucf_id'];
			$refund_list[$data['ucf_id']] = $data;
		}
		else{
			if(!isset($refund_list[$data['ucf_id']]['history'])){
				$refund_list[$data['ucf_id']]['history'] = array();
			}
			$refund_list[$data['ucf_id']]['history'][$data['ref_id']] = $data;
		}
	}	
	echo "<table border=\"0\" cellspacing=\"0\" cellpadding=\"0\" class=\"maintext\">";
		echo "<tr>";
			echo "<td colspan=20>";	
				echo "<table border=\"0\" cellspacing=\"0\" cellpadding=\"0\" class=\"maintext\">";
					echo "<tr>";
						echo "<td><a href='index.php?sesid=".SESID."' class='maintext'>חזרה לתפריט ראשי</a></td>";
						echo "<td width=70></td>";
					echo "</tr>";
				echo "</table>";
			echo "</td>";								
		echo "</tr>";
		echo "<tr><td colspan=20 height=15></td><td>";
		echo "<tr><td colspan=20 height=15></td><td>";
		$page_id = ( empty($_GET['page_id']) ) ? "0" : $_GET['page_id'];

		echo "<tr>";
			echo "<td colspan=20>";
				echo "<form action='?' name='searchForm' method='get' style='padding:0; margin:0;'>";
				echo "<input type='hidden' name='main' value='view_estimate_form_refund_list'>";
				echo "<input type='hidden' name='page_id' value='".$page_id."'>";
				echo "<input type='hidden' name='sesid' value='".SESID."'>";
				echo "<table border=\"0\" cellspacing=\"0\" cellpadding=\"0\" class=\"maintext\">";
					echo "<tr>";
						echo "<td>מתאריך</td>";
						echo "<td width=10></td>";
						echo "<td><input type='text' name='s_date' value='".$_GET['s_date']."' class='input_style' style='width: 100px;'> dd-mm-yyyy</td>";
						echo "<td width=30></td>";
						echo "<td>עד לתאריך</td>";
						echo "<td width=10></td>";
						echo "<td><input type='text' name='e_date' value='".$_GET['e_date']."' class='input_style' style='width: 100px;'> (תאריך רצוי + יום) dd-mm-yyyy</td>";
						
						echo "<td width=30></td>";
						echo "<td>שם משתמש: </td>";
						echo "<td><input type='text' name='user_name' value='".$_GET['user_name']."' class='input_style' style='width: 100px;'></td>";
						
						echo "<td width=10></td>";
						echo "<td><input type='submit' value='חפש' class='submit_style'></td>";
					echo "</tr>";
				echo "</table>";
				echo "</form>";
			echo "</td>";
		echo "</tr>";
		echo "<tr><td colspan=20 height=15></td><td>";

		echo "<tr><td colspan=20 height=15></td><td>";
		echo "<tr><td colspan=20 height=15></td><td>";		
		echo "<tr>";
			echo "<td><b>תאריך הבקשה</b></td>";
			echo "<td width=10></td>";
			echo "<td><b>שם משתמש</b></td>";
			echo "<td width=10></td>";
			echo "<td><b>סטטוס</b></td>";
			echo "<td width=10></td>";			
			echo "<td><b>סיבת הבקשה</b></td>";
			echo "<td width=10></td>";
			echo "<td><b>תיוג</b></td>";
			echo "<td width=10></td>";			
			echo "<td><b>הערות</b></td>";
			echo "<td width=10></td>";
			echo "<td><b>קטגוריה</b></td>";
			echo "<td width=10></td>";
			echo "<td><b>פרטי הליד</b></td>";
			echo "<td width=10></td>";
			echo "<td><b>צפייה בליד</b></td>";
			echo "<td width=10></td>";			
			echo "<td><b>זיכוי</b></td>";
		echo "</tr>";
			echo "<tr><td colspan=20 height=2></td></tr>";
			echo "<tr><td colspan=20><hr width=100% size=1 color=#000000></td></tr>";		
				
		foreach($refund_ids as $refund_id)
		{
			$data = $refund_list[$refund_id];
			$tr_style="";
			if($data['status'] == '6'){
				$tr_style = "background:#ffcece;";
			}
			elseif($data['denied'] == '1'){
				$tr_style = "background:#d3ffd3";
			}
			elseif(isset($data['history'])){
				if(!empty($data['history'])){
					$tr_style = "background:#eeeeff";
				}
			}
			$doubled_str = "";
			if($data['lead_billed'] != '1'){
				$tr_style = "background:#7d7d7d";
				$doubled_str = "<b style = 'color:red'>ליד כפול. יש לברר כיצד בוצעה בקשת זיכוי</b><br/>";
			}
			echo "<tr style='$tr_style' >";
				echo "<td>".$data['request_time']."</td>";
				echo "<td width=15></td>";
				echo "<td><a target='_new' href='index.php?main=user_lead_settings&unk=".$data['user_unk']."&sesid=".SESID."' class='maintext'>".$data['user_name']."</a></td>";
				echo "<td width=15></td>";
				echo "<td>".$status_list[$data['status']]."</td>";			
				echo "<td width=15></td>";
				if($data['estimateFormID'] == ''){
					echo "<td><span style='color:red; font-weight:bold;'>".$user_refund_reasons[$data['reason']]."</span></td>";
				}
				else{
					echo "<td><span style='color:red; font-weight:bold;'>".$refund_reasons[$data['reason']]."</span></td>";
				}
				echo "<td width=15></td>";
				$tag_str = "--";
				if($data['tag'] != "0"){
					$tag_sql = "SELECT id, tag_name FROM user_lead_tag WHERE id = '".$data['tag']."'";
					$tag_res = mysql_db_query(DB,$tag_sql);
					while($tag_data = mysql_fetch_array($tag_res)){
						$tag_str = $tag_data['tag_name'];
					}
				}
				echo "<td><span style='color:red; font-weight:bold;'>".$tag_str."</span></td>";
				
				echo "<td width=15></td>";				
				echo "<td>".$data['comment']."</td>";
				echo "<td width=15></td>";
				echo "<td>";
					if($data['lead_recource'] == "phone"){
						$phone_lead_id = $data['phone_lead_id'];
						$phone_lead_sql = "SELECT * FROM sites_leads_stat WHERE id = '".$phone_lead_id."'";
						$phone_lead_res = mysql_db_query(DB, $phone_lead_sql);
						$phone_lead_data =  mysql_fetch_array($phone_lead_res);
						echo "<span style='color:orange;font-weight:bold;'>סטטוס תשובה:</span> ".$phone_lead_data['answer']."<br/>"
							."<span style='color:orange;font-weight:bold;'>הודעת טקסט:</span> ".$phone_lead_data['sms_send']."<br/>"
							."<span style='color:orange;font-weight:bold;'>חיוב בשניות:</span> ".$phone_lead_data['billsec']."<br/>"
							."<span style='color:orange;font-weight:bold;'>מזהה:</span> ".$phone_lead_data['uniqueid']."<br/>";						
					}
					else{
						echo $data['cat_f_name']."<br/>"
						.$data['cat_s_name']."<br/>"
						.$data['cat_spec_name'];
					}
				echo "</td>";
				echo "<td width=15></td>";
				echo "<td>$doubled_str";
					echo "<span style='color:orange;font-weight:bold;'>נשלח ב:</span> ".$data['send_time']."<br/>"
						."<span style='color:orange;font-weight:bold;'>שם:</span> ".$data['sender_name']."<br/>"
						."<span style='color:orange;font-weight:bold;'>טלפון:</span> ".$data['sender_phone']."<br/>"
						."<span style='color:orange;font-weight:bold;'>אימייל:</span> ".$data['sender_email']."<br/>"
						."<span style='color:orange;font-weight:bold;'>הערות:</span> ".$data['ef_note']."<br/>";
				echo "</td>";
				echo "<td width=10></td>";					
				echo "<td>";
				if($data['lead_recource'] == "phone"){
					echo "<b style='color:red;'>ליד טלפוני</b>";
				}
				else{
					echo "<a target='_new' href='index.php?main=send_estimate_form_users_list&estimate_id=".$data['lead_id']."&status=18&sesid=".SESID."' class='maintext'>צפה בליד</a>";
				}
				echo "</td>";
				echo "<td width=20></td>";					
				echo "<td>";
					if(isset($data['history'])){
						ksort($data['history']);
						echo "<b style='color:red;'>הסטורית בקשות:</b><br/>";
						foreach($data['history'] as $history_data){
							echo "<br/>".$history_data['ref_id']."<br/><span style='color:brown;'><b>לקוח:</b>".$history_data['comment']."</span>";
							echo "<br/><span style='color:orange;'><b>מנהל:</b>";
							if($history_data['admin_comment'] == ""){
								echo "-----אין תגובה----";
							}
							else{
								echo $history_data['admin_comment'];
							}
							
							if($history_data['denied'] == '1'){
								echo "(הוחלט לא לזכות)";
							}
							echo "</span>";

						}
							echo "<br/><br/>החלטה נוכחית: <br/>".$data['ref_id']."<br/>";
					}
					if($data['denied'] == '1'){
						echo "<b><span style='color:red;'>הוחלט לא לזכות(".$data['admin_comment'].")</span></b>";
					}
					else{
						if($data['status'] == '6'){
							echo "<h4 style='color:red;'>הליד זוכה</h4>";
						}
						if($data['lead_recource'] == "phone"){
							if($data['status'] != '6'){
								echo "<a href='index.php?main=view_estimate_form_refund_list&unk=".$data['user_unk']."&refund_type=phone&refund=".$data['ucf_id']."&sesid=".SESID."' class='maintext'>לחץ כאן לזיכוי</a><br/><br/>";
							}
							if($phone_lead_data['recordingfile'] != ""){
								if($phone_lead_data['link_sys_id'] == "0"){
									echo "<a target='_blank' href='https://212.143.60.5/index.php?menu=monitoring&action=display_record&id=".$phone_lead_data['uniqueid']."&rawmode=yes' class='maintext'>לחץ כאן להורדת הקלטה</a><br/>";
								}
								else{
									echo "<a target='_blank' href='http://ilbiz.co.il/site-admin/recording_handlers/download.php?filename=".$phone_lead_data['recordingfile']."' class='maintext'>לחץ כאן להורדת הקלטה</a><br/>";
								}
							}
						}
						else{
							if($data['status'] != '6'){
								echo "<a href='index.php?main=view_estimate_form_refund_list&unk=".$data['user_unk']."&refund_type=form&refund=".$data['lead_id']."&sesid=".SESID."' class='maintext'>לחץ כאן לזיכוי</a>";
							}
						}
						$lead_id = $data['lead_id'];
						if($data['lead_recource'] == "phone"){
							$lead_id = $data['ucf_id'];
						}
						if($data['status'] != '6'){
							echo "<form method='POST' action='index.php?main=view_estimate_form_refund_list&unk=".$data['user_unk']."&request=".$data['ref_id']."&refund_type=".$data['lead_recource']."&refund=".$lead_id."&denied=1&sesid=".SESID."' class='maintext'>
								<b>החלט לא לזכות(הוסף הערה)</b>
								<textarea name='admin_comment'></textarea>
								<button type='sumbit'>שלח</button>
							</form>";	
						}
						else{
							echo "<form method='POST' action='index.php?main=view_estimate_form_refund_list&unk=".$data['user_unk']."&request=".$data['ref_id']."&refund_type=".$data['lead_recource']."&refund=".$lead_id."&cancel_refund=1&sesid=".SESID."' class='maintext'>
								<b>בטל זיכוי(הוסף הערה)</b>
								<textarea name='admin_comment'></textarea>
								<button type='sumbit'>שלח</button>
							</form>";							
						}
					}
					/*
					else{
						echo "<span style='color:red;'>הליד זוכה</span>";
					}
					*/
				echo "</td>";
			echo "</tr>";
			echo "<tr><td colspan=20 height=2></td></tr>";
			echo "<tr><td colspan=20><hr width=100% size=1 color=#000000></td></tr>";			
		}
		
		echo "<tr>";
				echo "<td colspan=20 align=center style=\"border-top: 1px solid #".$data_colors['border_color'].";\">";
					echo "<table align=center border=0 cellspacing=\"0\" width=100% cellpadding=\"3\" class=\"maintext\">";
						echo "<tr>";
							echo "<td align=center>סך הכל ".$num_rows." בקשות</td>";
						echo "</tr>";
						
						if( $num_rows > $limit_rows )//$limit_rows $num_rows
						{
							echo "<tr>";
								echo "<td align=center>";
								
									$z = 0;
									
									for($i=1 ; ($i*$limit_rows) < $num_rows ; $i++)
									{
										
										$pz = $z+1;
										

												if( $i == $_GET['page_id'] )
													$classi = "<strong style=\"color:#000000\">".$pz."</strong>&nbsp;&nbsp;";
												else
													$classi = "<a href='index.php?main=view_estimate_form_refund_list&page_id=".$i."&sesid=".SESID."' class='maintext'>".$pz."</a>&nbsp;&nbsp;";
													
												echo $classi;
												
												$z = $z + 1;
												
												if( $z%35 == 0 )
													echo "<br>";
										
										
									}
								echo "</td>";
							echo "</tr>";
						}
					echo "</table>";
				echo "</td>";
			echo "</tr>";		
	echo "</table>";
}




function view_estimate_form_list()
{
	
	$status = ( empty($_GET['status']) ) ? "0" : $_GET['status'];
	$limitcount = ( empty($_GET['limitcount']) ) ? "0" : $_GET['limitcount'];
	
	$s_dateT = explode( "-", $_GET['s_date'] );
	$e_dateT = explode( "-", $_GET['e_date'] );
	
	$s_date = ( !empty($_GET['s_date']) ) ? " AND ef.insert_date >= '".$s_dateT[2]."-".$s_dateT[1]."-".$s_dateT[0]."' " : "";
	$e_date = ( !empty($_GET['e_date']) ) ? " AND ef.insert_date <= '".$e_dateT[2]."-".$e_dateT[1]."-".$e_dateT[0]."' " : "";
	
	$key_ref = ( $_GET['s_ref'] == "mysave" ) ? 'IS NULL' : "LIKE '%".$_GET['s_ref']."%'";
	$s_ref = ( !empty($_GET['s_ref']) ) ? " AND ef.referer ".$key_ref." " : "";
	
	$ip_val = ( !empty($_GET['s_ip']) ) ? trim($_GET['s_ip']) : "";
	$s_ip = ( !empty($_GET['s_ip']) ) ? " AND ef.ip LIKE (".'"%'.$ip_val.'%")' : "";

	$free_val = ( !empty($_GET['s_free']) ) ? trim($_GET['s_free']) : "";
	$s_free = ( !empty($_GET['s_free']) ) ? ' AND (ef.phone LIKE ('.'"%'.$free_val.'%") OR ef.name LIKE ('.'"%'.$free_val.'%") OR ef.email LIKE ('.'"%'.$free_val.'%")) ' : "";
	
	$lead_campaign_sql = "";	
	if(isset($_REQUEST['add_campaign_leads'])){
		$lead_campaign_sql = " AND (0 ";
		if(isset($_REQUEST['add_reg_leads'])){
			$lead_campaign_sql .= " OR ef.campaign_type = '0' ";
		}
		if(isset($_REQUEST['add_gl_leads'])){
			$lead_campaign_sql .= " OR ef.campaign_type = '1' ";
		}		
		if(isset($_REQUEST['add_fb_leads'])){
			$lead_campaign_sql .= " OR ef.campaign_type = '2' ";
		}
		
		$lead_campaign_sql .= ")";
	}	
	if( $status == "18" )
	{
		
		$sql = "select ef.*, nc.name as NewCity from 
			 users_send_estimate_form as uef , estimate_form as ef left join newCities as nc on ef.city=nc.id WHERE 
				ef.id = uef.estimate_id AND
				( uef.user_id = '2084' OR uef.user_id = '2083' ) 
				".$lead_campaign_sql.$s_date.$e_date.$s_ref.$s_ip.$s_free." 
				order by ef.id DESC LIMIT ".$limitcount.",100";
		$res = mysql_db_query(DB, $sql);
		
		$sql2 = "select ef.id, nc.name as NewCity from 
		users_send_estimate_form as uef , estimate_form as ef left join newCities as nc on ef.city=nc.id WHERE 
		ef.id = uef.estimate_id AND
		( uef.user_id = '2084' OR uef.user_id = '2083' ) 
		".$lead_campaign_sql.$s_date.$e_date.$s_ref.$s_ip.$s_free;
		$res2 = mysql_db_query(DB, $sql2);
		$num_rows = mysql_num_rows($res2);
	}
	else
	{
		$ef_status_where = "";
		if($status != "-1"){
			$ef_status_where = " AND ef.status='".$status."' ";
		}
		$sql = "select ef.*, nc.name as NewCity from estimate_form as ef left join newCities as nc on ef.city=nc.id WHERE 1 ".$ef_status_where." ".$lead_campaign_sql.$s_date.$e_date.$s_ref.$s_ip.$s_free." order by ef.id DESC LIMIT ".$limitcount.",100";
		$res = mysql_db_query(DB, $sql);
		
		$sql2 = "select ef.id, nc.name as NewCity from estimate_form as ef left join newCities as nc on ef.city=nc.id WHERE 1 ".$ef_status_where." ".$lead_campaign_sql.$s_date.$e_date.$s_ref.$s_ip.$s_free;
		$res2 = mysql_db_query(DB, $sql2);
		$num_rows = mysql_num_rows($res2);
	}
	
	echo "<table border=\"0\" cellspacing=\"0\" cellpadding=\"0\" class=\"maintext\">";
	
		$s_status_all = ( $status == "-1" ) ? "<b>" : "";
		$e_status_all = ( $status == "-1" ) ? "</b>" : "";
	
		$s_status_0 = ( $status == "0" ) ? "<b>" : "";
		$e_status_0 = ( $status == "0" ) ? "</b>" : "";
		
		$s_status_1 = ( $status == "1" ) ? "<b>" : "";
		$e_status_1 = ( $status == "1" ) ? "</b>" : "";
		
		$s_status_2 = ( $status == "2" ) ? "<b>" : "";
		$e_status_2 = ( $status == "2" ) ? "</b>" : "";
		
		$s_status_3 = ( $status == "3" ) ? "<b>" : "";
		$e_status_3 = ( $status == "3" ) ? "</b>" : "";
		
		$s_status_4 = ( $status == "4" ) ? "<b>" : "";
		$e_status_4 = ( $status == "4" ) ? "</b>" : "";
		
		$s_status_9 = ( $status == "9" ) ? "<b>" : "";
		$e_status_9 = ( $status == "9" ) ? "</b>" : "";
		
		$s_status_18 = ( $status == "18" ) ? "<b>" : "";
		$e_status_18 = ( $status == "18" ) ? "</b>" : "";
		
		echo "<tr>";
			echo "<td colspan=20>";
				echo "<table border=\"0\" cellspacing=\"0\" cellpadding=\"0\" class=\"maintext\">";
					echo "<tr>";
						echo "<td><a href='index.php?sesid=".SESID."' class='maintext'>תפריט ראשי</a></td>";
						echo "<td width=70></td>";
						echo "<td><a href='index.php?main=view_estimate_form_list&status=-1&sesid=".SESID."&s_ref=".$_GET['s_ref']."&s_date=".$_GET['s_date']."&e_date=".$_GET['e_date']."&limitcount=".$limitcount."' class='maintext'>".$s_status_all."כל ההצעות".$e_status_all."</a></td>";
						echo "<td width=20></td>";
						echo "<td><a href='index.php?main=view_estimate_form_list&status=0&sesid=".SESID."&s_ref=".$_GET['s_ref']."&s_date=".$_GET['s_date']."&e_date=".$_GET['e_date']."&limitcount=".$limitcount."' class='maintext'>".$s_status_0."הצעות חדשות".$e_status_0."</a></td>";
						echo "<td width=20></td>";
						echo "<td><a href='index.php?main=view_estimate_form_list&status=1&sesid=".SESID."&s_ref=".$_GET['s_ref']."&s_date=".$_GET['s_date']."&e_date=".$_GET['e_date']."&limitcount=".$limitcount."' class='maintext'>".$s_status_1."הצעות בטיפול".$e_status_1."</a></td>";
						echo "<td width=20></td>";
						echo "<td><a href='index.php?main=view_estimate_form_list&status=2&sesid=".SESID."&s_ref=".$_GET['s_ref']."&s_date=".$_GET['s_date']."&e_date=".$_GET['e_date']."&limitcount=".$limitcount."' class='maintext'>".$s_status_2."הצעות שמחכות".$e_status_2."</a></td>";
						echo "<td width=20></td>";
						echo "<td><a href='index.php?main=view_estimate_form_list&status=3&sesid=".SESID."&s_ref=".$_GET['s_ref']."&s_date=".$_GET['s_date']."&e_date=".$_GET['e_date']."&limitcount=".$limitcount."' class='maintext'>".$s_status_3."הצעות שנשלחו".$e_status_3."</a></td>";
						echo "<td width=20></td>";
						echo "<td><a href='index.php?main=view_estimate_form_list&status=4&sesid=".SESID."&s_ref=".$_GET['s_ref']."&s_date=".$_GET['s_date']."&e_date=".$_GET['e_date']."&limitcount=".$limitcount."' class='maintext'>".$s_status_4."הצעות לא רלוונטיות".$e_status_4."</a></td>";
						echo "<td width=20></td>";
						echo "<td><a href='index.php?main=view_estimate_form_list&status=9&sesid=".SESID."&s_ref=".$_GET['s_ref']."&s_date=".$_GET['s_date']."&e_date=".$_GET['e_date']."&limitcount=".$limitcount."' class='maintext'>".$s_status_9."הצעות מחוקות".$e_status_9."</a></td>";
						echo "<td width=20></td>";
						echo "<td><a href='index.php?main=view_estimate_form_list&status=18&sesid=".SESID."&s_ref=".$_GET['s_ref']."&s_date=".$_GET['s_date']."&e_date=".$_GET['e_date']."&limitcount=".$limitcount."' class='maintext'>".$s_status_18."הצעות שעברו לאסטטיקה ומכה".$e_status_18."</a></td>";
						echo "<td width=20></td>";
						echo "<td><a href='index.php?main=anf&gf=spam_contact_list&sesid=".SESID."' class='maintext'>רשימת הודעות ספאם שהתקבלו </a></td>";
						echo "<td width=20></td>";
						echo "<td><a href='index.php?main=anf&gf=block_list&sesid=".SESID."' class='maintext'>רשימת משתמשים חסומים על ידי קוקי</a></td>";

					echo "</tr>";
				echo "</table>";
			echo "</td>";
		echo "</tr>";
		echo "<tr><td colspan=20 height=15></td><td>";
		
		echo "<tr>";
			echo "<td colspan=20>";
				echo "<form action='?' name='searchForm' method='get' style='padding:0; margin:0;'>";
				echo "<input type='hidden' name='main' value='view_estimate_form_list'>";
				echo "<input type='hidden' name='status' value='".$status."'>";
				echo "<input type='hidden' name='limitcount' value='".$limitcount."'>";
				echo "<input type='hidden' name='sesid' value='".SESID."'>";
				echo "<table border=\"0\" cellspacing=\"0\" cellpadding=\"0\" class=\"maintext\">";
					echo "<tr>";
						echo "<td></td>";
						echo "<td width=10></td>";
						echo "<td valign='top'>מתאריך<br/><input type='text' name='s_date' value='".$_GET['s_date']."' class='input_style' style='width: 100px;'><br/> mm-dd-yyyy</td>";
						echo "<td width=30></td>";
						echo "<td></td>";
						echo "<td width=10></td>";
						echo "<td valign='top'>עד לתאריך<br/><input type='text' name='e_date' value='".$_GET['e_date']."' class='input_style' style='width: 100px;'><br/> (תאריך רצוי + יום) <br/>mm-dd-yyyy</td>";
						echo "<td width=30></td>";
						echo "<td></td>";
						echo "<td width=10></td>";
						echo "<td valign='top'>הגיע מחיפוש ב: <br/><select name='s_ref' class='input_style' style='width: 200px;height: 22px;margin-top: 1px;'>";
							$status_where = "";
							if($status != "-1"){
								$status_where = " AND status='".$status."' ";
							}
							$sql = "SELECT referer FROM estimate_form WHERE 1 ".$status_where." GROUP BY referer";
							$res2 = mysql_db_query(DB,$sql);
							
							$arr=array();
							while( $data2 = mysql_fetch_array($res2) )
							{
								$new_ref = str_replace( "http://" , "", $data2['referer'] );
								$new_ref = str_replace( "https://" , "", $new_ref ); 
								$new_ref = str_replace( "www." , "", $new_ref );
								$new_ref = explode( "/" ,$new_ref );
								$ref = $new_ref[0];
								$arr[$ref] = $ref;
							}
							$seleted = ( $_GET['s_ref'] == "mysave" ) ? "selected": "";
							echo "<option value=''>הכל</option>";
							echo "<option value='mysave' ".$seleted.">mysave.co.il</option>";
							$order_options = array();
							foreach( $arr as $key => $val )
							{
								$sql = "SELECT name FROM users WHERE domain = '".$val."' AND status = '0' AND active_manager = '0' AND end_date > now()";
								$res3 = mysql_db_query(DB,$sql);
								$data3 = mysql_fetch_array($res3);
								if($data3['name'] != ""){
									$seleted = ( $_GET['s_ref'] == $key && $_GET['s_ref'] != "") ? "selected": "";
									$ref_name_strip = stripslashes($data3['name']);
									$order_options[$ref_name_strip] = "<option value='".$key."' ".$seleted .">".$ref_name_strip."</option>";
								}
							}
							ksort($order_options);
							foreach($order_options as $key=>$option){
								echo $option;
							}
						echo "</select></td>";
						echo "<td width=10></td>";
						echo "<td valign='top'>IP<br/><input type='text' name='s_ip' value='".$ip_val."' class='input_style' style='width: 100px;'></td>";
						echo "<td width=10></td>";
						echo "<td valign='top'>חיפוש חפשי(שם,אימייל,טלפון)<br/><input type='text' name='s_free' value='".$free_val."' class='input_style' style='width: 150px;'></td>";

						echo "<td width=30></td>";						
						echo "<td valign='top'>&nbsp;<br/><input type='submit' value='חפש' class='submit_style' style='height: 24px;'></td>";
					echo "</tr>";
					echo "<tr>";
						echo "<td colspan='20'>";
									
								$add_campaign_leads_style = "display:none;";
								$add_campaign_leads_checked = "";
								$add_reg_leads_checked = "checked";
								$add_fb_leads_checked = "checked";
								$add_gl_leads_checked = "checked";
								
								if(isset($_GET['add_campaign_leads'])){
									$add_campaign_leads_style = "display:block;";
									$add_campaign_leads_checked = "checked";
									$add_reg_leads_checked = "";
									$add_fb_leads_checked = "";
									$add_gl_leads_checked = "";
									if(isset($_GET['add_reg_leads'])){
										$add_reg_leads_checked = "checked";
									}
									if(isset($_GET['add_fb_leads'])){
										$add_fb_leads_checked = "checked";
									}
									if(isset($_GET['add_gl_leads'])){
										$add_gl_leads_checked = "checked";
									}
								}				
							?>
							
							
							<br/> 
							<input type="checkbox" id="add_campaign_leads_door" name="add_campaign_leads" value="1" <?php echo $add_campaign_leads_checked; ?>/>הוסף סינון לידים לפי קמפיין:  &nbsp&nbsp&nbsp
							<div id="add_campaign_leads_wrap" style="<?php echo $add_campaign_leads_style; ?>"><br/><b>הצג לידים מסוג: </b>
								<input type="checkbox"  name="add_reg_leads" value="1" <?php echo $add_reg_leads_checked; ?>/> ללא קמפיין &nbsp&nbsp&nbsp
								<input type="checkbox"  name="add_fb_leads" value="1" <?php echo $add_fb_leads_checked; ?>/> מקמפיין פייסבוק &nbsp&nbsp&nbsp
								<input type="checkbox"  name="add_gl_leads" value="1" <?php echo $add_gl_leads_checked; ?>/> מקמפיין גוגל &nbsp&nbsp&nbsp
								
							</div>	
							<br/><br/>
							<script type="text/javascript">
								jQuery(function($){
									$("#add_campaign_leads_door").change(function(){
										console.log("---"+$(this).attr('checked'));
										
										if($(this).attr('checked')){
											$("#add_campaign_leads_wrap").show();
										}
										else{
											$("#add_campaign_leads_wrap").hide();
										}
									});
								});
							</script>
							<?php
						echo "</td>";					
					echo "</tr>";
				echo "</table>";
				echo "</form>";
			echo "</td>";
		echo "</tr>";
		
		echo "<tr><td colspan=20 height=15></td><td></tr>";
		$mobile_sign = "<div style='width: 17px;height: 14px;border-radius:3px;border:2px solid blue;font-size: 13px;-webkit-transform: rotate(31deg);padding-right: 6px;color: blue;font-family: SANS-SERIF;'>m</div>";
		echo "<tr><td colspan=20>
			<div>סימונים:</div>
			<div style='height:20px;float:right;background:#ffb9b9;'>קמפיין גוגל</div>
			<div style='margin-right:40px;height:20px;float:right;background:#ddddff;'>קמפיין פייסבוק</div>
			<div style='margin-right:40px;height:20px;float:right;background:#ddddff;border:2px solid blue'>ליד פייסבוק</div>
			<div style='margin-right:40px;float:right;'>
				<div style='float:right;width: 17px;height: 14px;border-radius:3px;border:2px solid blue;font-size: 13px;-webkit-transform: rotate(31deg);padding-right: 6px;color: blue;font-family: SANS-SERIF;'>m</div>
				השתמשו במובייל
			</div>
			<div style='margin-right:40px;float:right;'>
				<div style='float:right;width: 15px;height: 14px;border-radius:3px;border:2px solid green;font-size: 17px;-webkit-transform: rotate(31deg);padding-right: 6px;color: green;line-height: 14px;'>a<br/><small style='font-size: 11px;line-height: 2px;'>שם השותף</small></div>
				הגיע משותף
			</div>			
			<div style='margin-right:40px;float:right;'>
				<div style='float:right;width: 17px;height: 14px;border-radius:50px;border:2px solid red;font-size: 16px; padding: 6px 12px 6px 6px;color: red;font-family: SANS-SERIF;'>X</div>
				לא נשלח לאף לקוח
			</div>			
			<div style='clear:both;'></div>
			</td><td></tr>";
		echo "<tr><td colspan=20 height=15></td><td></tr>";
		echo "<tr>";
			echo "<td><b>תאריך שליחה</b></td>";
			echo "<td width=10></td>";
			echo "<td><b>שם מלא</b></td>";
			echo "<td width=10></td>";
			echo "<td><b>מספר טלפון</b></td>";
			echo "<td width=10></td>";
			echo "<td><b>אימייל</b></td>";
			echo "<td width=10></td>";
			echo "<td><b>הערה</b></td>";
			echo "<td width=10></td>";
			echo "<td><b>IP</b></td>";
			echo "<td width=10></td>";			
			echo "<td><b>עיר</b></td>";
			echo "<td width=10></td>";
			echo "<td><b>קטגוריה</b></td>";
			echo "<td width=10></td>";
			echo "<td><b>קטגוריה משנית</b></td>";
			echo "<td width=10></td>";
			echo "<td><b>התמחות</b></td>";
			echo "<td width=10></td>";
			echo "<td><b>הגיע מבאנר</b></td>";
			echo "<td width=10></td>";			
			echo "<td><b>סטטוס עבודה</b></td>";
			echo "<td width=10></td>";
			echo "<td><b>שלח</b></td>";
			echo "<td width=10></td>";
			echo "<td></td>";			
		echo "</tr>";
		
		echo "<tr><td colspan=20 height=15></td><td>";
		$affiliate_list = array();
		
		
		$banner_list = array();
		
		while( $data = mysql_fetch_array($res) )
		{
			$sql = "select cat_name from biz_categories where id='".$data['cat_spec']."'";
			$ressc = mysql_db_query(DB,$sql);
			$data_cat_spec = mysql_fetch_array($ressc);
			
			$sql = "select cat_name from biz_categories where id='".$data['cat_f']."'";
			$resf = mysql_db_query(DB,$sql);
			$data_cat_f = mysql_fetch_array($resf);
			
			$sql = "select cat_name from biz_categories where id='".$data['cat_s']."'";
			$ress = mysql_db_query(DB,$sql);
			$data_cat_s = mysql_fetch_array($ress);
			
			$sent_sql = "select id FROM user_contact_forms WHERE estimateFormID = '".$data['id']."' LIMIT 1";
			$sent_res = mysql_db_query(DB,$sent_sql);
			$data_sent = mysql_fetch_array($sent_res);
			$lead_sent = false;
			if($data_sent['id'] != ''){
				$lead_sent = true;
			}
			if($data['form_resource'] == 'fb_leads' && false){
				mysql_db_query(DB,"SET NAMES 'utf8'");
				$fb_sql = "SELECT * FROM fb_leads WHERE id = ".$data['fb_lead_id']."";
				$fb_res = mysql_db_query(DB,$fb_sql);
				$fb_data = mysql_fetch_array($fb_res);
				$data['fb_city'] = $fb_data['city'];
				mysql_db_query(DB,"SET NAMES 'hebrew'");
				echo $data['fb_city']."<br/>";
			}
			$explode_date1 = explode(" " , $data['insert_date']);
			$explode_date2 = explode("-" , $explode_date1[0]);
	
			$explode_date = $explode_date2[2]."-".$explode_date2[1]."-".$explode_date2[0]."<br>".$explode_date1[1];
			$row_style = "";
			$col_style = "";
			
			if($data['form_resource'] == 'fb_leads'){
				$col_style = "background:#ddddff;border:2px solid blue;";
			}
			
			if($data['campaign_type'] == '1'){
				$row_style = "background:#ffb9b9;";
			}
			if($data['campaign_type'] == '2'){
				$row_style = "background:#ddddff;";
			}
			$banner_name = "";
			if($data['banner_id']!='0' && $data['banner_id']!= ''){
				if(!isset($banner_list[$data['banner_id']])){
					$ban_sql = "SELECT * FROM net_clients_banners WHERE id = ".$data['banner_id'];
					$ban_res = mysql_db_query(DB,$ban_sql);
					$ban_data = mysql_fetch_array($ban_res);
					$banner_list[$data['banner_id']] = $ban_data;
				}
				$banner_name = $banner_list[$data['banner_id']]['banner_name'];
			}
			echo "<form action='?' method='GET' name='change_status_form_".$data['id']."'>";
			echo "<input type='hidden' name='main' value='change_status_for_contact'>";
			echo "<input type='hidden' name='gobeck' value='view_estimate_form_list'>";
			echo "<input type='hidden' name='old_status' value='".$data['status']."'>";
			echo "<input type='hidden' name='row_id' value='".$data['id']."'>";
			echo "<input type='hidden' name='s_date' value='".$_GET['s_date']."'>";
			echo "<input type='hidden' name='e_date' value='".$_GET['e_date']."'>";
			echo "<input type='hidden' name='s_ref' value='".$_GET['s_ref']."'>";
			echo "<input type='hidden' name='limitcount' value='".$limitcount."'>";
			echo "<input type='hidden' name='table' value='estimate_form'>";
			echo "<input type='hidden' name='sesid' value='".SESID."'>";
			echo "<tr style='".$row_style."'>";
				echo "<td>".$explode_date."</td>";
				echo "<td width=10></td>";
				echo "<td style='".$col_style."'>".stripslashes(htmlspecialchars($data['name']))."</td>";
				echo "<td width=10></td>";
				echo "<td>".stripslashes(htmlspecialchars($data['phone']))."</td>";
				echo "<td width=10></td>";
				echo "<td>".stripslashes(htmlspecialchars($data['email']))."</td>";
				echo "<td width=10></td>";
				echo "<td>".nl2br(stripslashes(htmlspecialchars($data['note'])))."</td>";
				echo "<td width=10></td>";
				echo "<td>".nl2br(stripslashes(htmlspecialchars($data['ip'])))."</td>";
				echo "<td width=10></td>";				
				$city = ( $data['NewCity'] != "" ) ? $data['NewCity'] : $data['city'];
				echo "<td>".stripslashes($city)."</td>";
				echo "<td width=10></td>";
				echo "<td>".stripslashes(htmlspecialchars($data_cat_f['cat_name']))."</td>";
				echo "<td width=10></td>";
				echo "<td>".stripslashes(htmlspecialchars($data_cat_s['cat_name']))."</td>";
				echo "<td width=10></td>";
				echo "<td>".stripslashes(htmlspecialchars($data_cat_spec['cat_name']))."</td>";
				echo "<td width=10></td>";
				echo "<td><b style='color:red;'>".$banner_name."</b></td>";
				echo "<td width=10></td>";				
				
				
					$selected_0 = ( $data['status'] == "0" ) ? "selected" : "";
					$selected_1 = ( $data['status'] == "1" ) ? "selected" : "";
					$selected_2 = ( $data['status'] == "2" ) ? "selected" : "";
					$selected_3 = ( $data['status'] == "3" ) ? "selected" : "";
					$selected_4 = ( $data['status'] == "4" ) ? "selected" : "";
					$selected_9 = ( $data['status'] == "9" ) ? "selected" : "";
					
				echo "<td>";
					if( $status == "18" )
					{
						switch( $data['status'] )
						{
							case "0" :		echo "הצעות חדשות";		break;
							case "1" :		echo "הצעות בטיפול";		break;
							case "2" :		echo "הצעות שמחכות";		break;
							case "3" :		echo "הצעות שנשלחו";		break;
							case "4" :		echo "הצעות לא רלוונטיות";		break;
							case "9" :		echo "הצעות מחוקות";		break;
						}
					}
					else
					{
						echo "<select name='new_status' class='input_style' style='font-size:11px; width:110px;' onchange='change_status_form_".$data['id'].".submit()'>
							<option value=''>בחירה</option>
							<option value='0' ".$selected_0.">הצעות חדשות</option>
							<option value='1' ".$selected_1.">הצעות בטיפול</option>
							<option value='2' ".$selected_2.">הצעות שמחכות</option>
							<option value='3' ".$selected_3.">הצעות שנשלחו</option>
							<option value='4' ".$selected_4.">הצעות לא רלוונטיות</option>
							<option value='9' ".$selected_9.">הצעות מחוקות</option>
						</select>";
					}
				echo "</td>";
				echo "<td width=10></td>";
				echo "<td><a href='?main=send_estimate_form_users_list&estimate_id=".$data['id']."&s_ref=".$_GET['s_ref']."&s_date=".$_GET['s_date']."&e_date=".$_GET['e_date']."&limitcount=".$limitcount."&status=".$_GET['status']."&sesid=".SESID."' class='maintext'>שלח</a></td>";
				echo "<td width=10></td>";
				$mobile_sign = "";
				if($data['is_mobile']=="1"){
					$mobile_sign = "<div style='width: 17px;height: 14px;border-radius:3px;border:2px solid blue;font-size: 13px;-webkit-transform: rotate(31deg);padding-right: 6px;color: blue;font-family: SANS-SERIF;'>m</div>";
				}

				echo "<td>".$mobile_sign."</td>";
				echo "<td width=10></td>";
				$aff_sign = "";
				if($data['campaign_type']!="0" && $data['campaign_type'] > 999){
					
					$affiliate_id = $data['campaign_type']-1000;
					if(!isset($affiliate_list[$affiliate_id])){
						$afsql = "SELECT * FROM affiliates WHERE id = $affiliate_id";
						$afres = mysql_db_query(DB,$afsql);
						$afdata = mysql_fetch_array($afres);
						$affiliate_list[$affiliate_id] = $afdata;
					}
					$affiliate = $affiliate_list[$affiliate_id];
					$aff_a = "?main=affiliates&sesid=".SESID."&aff_id=".$affiliate_id;
					$aff_sign = "
					
					<div style='float:right;width: 15px;height: 14px;border-radius:3px;border:2px solid green;font-size: 17px;-webkit-transform: rotate(31deg);padding-right: 6px;color: green;line-height: 14px;'>
					<a target='_BLANK' href='".$aff_a."'>
					a<br/><small style='font-size: 11px;line-height: 2px;'>".$affiliate['first_name']." ".$affiliate['last_name']."</small></a></div>";
				}				
				echo "<td style='width:300px;'>".$aff_sign."</td>";
				echo "<td width=10></td>";
				$sent_sign = "";
				if(!$lead_sent){
					$sent_sign = "<div style='width: 17px;height: 14px;border-radius:50px;border:2px solid red;font-size: 16px; padding: 6px 12px 6px 6px;color: red;font-family: SANS-SERIF;'>X</div>";
				}
				
				echo "<td>".$sent_sign."</td>";				
			echo "</tr>";
			echo "</form>";
			
			echo "<tr><td colspan=23 height=2></td><td>";
			echo "<tr><td colspan=23><hr width=100% size=1 color=#000000></td><td>";
			echo "<tr><td colspan=23 height=2></td><td>";
		}
		
		
		echo "<tr>";
				echo "<td colspan=20 align=center style=\"border-top: 1px solid #".$data_colors['border_color'].";\">";
					echo "<table align=center border=0 cellspacing=\"0\" width=100% cellpadding=\"3\" class=\"maintext\">";
						echo "<tr>";
							echo "<td align=center>סך הכל ".$num_rows." לידים</td>";
						echo "</tr>";
						
						if( $num_rows > 100 )
						{
							echo "<tr>";
								echo "<td align=center>";
								
									$z = 0;
									for($i=0 ; $i < $num_rows ; $i++)
									{
										$pz = $z+1;
										
										if($i % 100 == 0)
										{
												if( $i == $_GET['limitcount'] )
													$classi = "<strong style=\"color:#000000\">".$pz."</strong>&nbsp;&nbsp;";
												else
													$classi = "<a href='index.php?main=view_estimate_form_list&status=".$status."&s_ref=".$_GET['s_ref']."&s_date=".$_GET['s_date']."&e_date=".$_GET['e_date']."&limitcount=".$i."&sesid=".SESID."' class='maintext'>".$pz."</a>&nbsp;&nbsp;";
												
												echo $classi;
												
												$z = $z + 1;
												
												if( $z%35 == 0 )
													echo "<br>";
										}
									}
								echo "</td>";
							echo "</tr>";
						}
					echo "</table>";
				echo "</td>";
			echo "</tr>";
			
			
	echo "</table>"; 
	
}

function customers_outof_leads(){
	$sql = "SELECT u.unk as 'user_unk', u.name AS  'name'
FROM user_lead_settings uls
LEFT JOIN users u ON u.unk = uls.unk
LEFT JOIN user_bookkeeping ub ON ub.unk = uls.unk
WHERE uls.leadQry <1
AND u.active_manager !=  '1'
AND ub.hostPriceMon =0" ; 
	$res = mysql_db_query(DB, $sql);
	//echo $sql;
	while($data = mysql_fetch_array($res)){
		echo "<div><a target='_new' href='index.php?main=user_lead_settings&unk=".$data['user_unk']."&sesid=".SESID."'>".$data['name']."</a></div>";
	}
}


function send_estimate_form_users_list()
{
	if(isset($_GET['block_by_cookie'])){
		if(isset($_GET['relese_block'])){
			$coockie_sql = "DELETE FROM cookie_block WHERE cookie = '".$_GET['cookie']."'";
			$coockie_res = mysql_db_query(DB,$coockie_sql);
			?>
			<script type="text/javascript">
				window.history.back();
			</script>
			<?php
			exit("החסימה הוסרה בהצלחה");
		}
		else{
			$coockie_sql = "SELECT id FROM cookie_block WHERE cookie = '".$_GET['cookie']."'";
			$coockie_res = mysql_db_query(DB,$coockie_sql);
			$coockie_data = mysql_fetch_array($coockie_res);
			if($coockie_data['id'] == ''){
				$coockie_sql = "INSERT INTO cookie_block(cookie,tracking_id,estimate_form_id) VALUES('".$_GET['cookie']."','".$_GET['tracking_id']."','".$_GET['estimate_form_id']."')";  
				$coockie_res = mysql_db_query(DB,$coockie_sql);			
			}
			?>
			<script type="text/javascript">
				window.history.back();
			</script>
			<?php			
			exit("המשתמש נחסם בהצלחה");
		}
	}
	$estimate_id = $_GET['estimate_id'];
	$coockie_sql = "SELECT uniq_track FROM estimate_form WHERE id = ".$estimate_id."";
	$coockie_res = mysql_db_query(DB,$coockie_sql);
	$coockie_data = mysql_fetch_array($coockie_res);
	$cookie_track = $coockie_data['uniq_track'];
	$tracking_id = false;
	$cookie = false;
	if($cookie_track!=''){
		$coockie_sql = "SELECT id,cookie FROM customer_tracking WHERE uniq_track = '".$cookie_track."'";
		$coockie_res = mysql_db_query(DB,$coockie_sql);
		$coockie_data = mysql_fetch_array($coockie_res);
		if($coockie_data['cookie']!=''){
			$cookie = $coockie_data['cookie'];
			$tracking_id = $coockie_data['id'];
		}
	}
	$cookie_blocked = false;
	if($cookie){
		$coockie_sql = "SELECT id FROM cookie_block WHERE cookie = '".$cookie."'";
		$coockie_res = mysql_db_query(DB,$coockie_sql);
		$coockie_data = mysql_fetch_array($coockie_res);
		if($coockie_data['id'] != ''){
			$cookie_blocked = true;			
		}	
	}
	$status = ( empty($_GET['status']) ) ? "18" : $_GET['status'];
	
	$show_status = ( $status != "18" ) ? "ef.status = '".$status."' and" : "";
	$sql = "select ef.*, nc.name as NewCity from estimate_form as ef left join newCities as nc on ef.city=nc.id WHERE ".$show_status." ef.id = '".$_GET['estimate_id']."'";
	$res = mysql_db_query(DB, $sql);
	$data_estimate_form = mysql_fetch_array($res);
	if($data_estimate_form['status'] != $status){
		$status = $data_estimate_form['status'];
	}
	$explode_date1 = explode(" " , $data_estimate_form['insert_date']);
	$explode_date2 = explode("-" , $explode_date1[0]);
	
	$explode_date = $explode_date2[2]."-".$explode_date2[1]."-".$explode_date2[0]." ".$explode_date1[1];
	
	$sql = "select cat_name from biz_categories where id='".$data_estimate_form['cat_f']."'";

	$resf = mysql_db_query(DB,$sql);
	$data_cat_f = mysql_fetch_array($resf);
	
	$take_cat_temp = ( $data_estimate_form['cat_s'] != "0" ) ? $data_estimate_form['cat_s'] : $data_estimate_form['cat_f'];
	$take_cat = ( $data_estimate_form['cat_spec'] != "0" ) ? $data_estimate_form['cat_spec'] : $take_cat_temp;
	
	$sql = "select u.id,u.unk as 'unk', u.full_name,u.name,u.end_date, c.name as city,bc.cat_name, bc.id as cat_id FROM 
		users as u, 
		cities as c, 
		user_cat as uc,
		biz_categories as bc 
			WHERE 
				u.city=c.id AND
				u.deleted=0 AND
				u.status = 0 AND
				u.active_manager = 0 AND 
				u.end_date > NOW() AND 
				u.id=uc.user_id AND
				uc.cat_id=bc.id AND
				bc.id=".$take_cat." AND
				bc.status=1
		 GROUP BY u.id";
	$res = mysql_db_query(DB, $sql);
	
	$sql = "select cat_name from biz_categories where id='".$data_estimate_form['cat_s']."'";
	$ress = mysql_db_query(DB,$sql);
	$data_cat_s22 = mysql_fetch_array($ress);
	
	$sql = "select cat_name from biz_categories where id='".$data_estimate_form['cat_spec']."'";
	$ress = mysql_db_query(DB,$sql);
	$data_cat_s23 = mysql_fetch_array($ress);
	
	$sql = "SELECT mfb.* FROM mysaveFormButton as mfb, mysaveFormButton_clientChoosen as cc WHERE cc.buttonId=mfb.id AND estimatId='".$_GET['estimate_id']."' ORDER BY mfb.place";
	$res_mfb = mysql_db_query(DB, $sql);
	
	$catButtons = "";
	while( $data_mfb = mysql_fetch_array($res_mfb) )
	{
		$catButtonsTEMP .= stripslashes($data_mfb['title']).", ";
	}
	$catButtons = substr( $catButtonsTEMP, 0, -2 );
	
	echo "<table border=\"0\" cellspacing=\"0\" cellpadding=\"0\" class=\"maintext\">";
		echo "<tr>";
			echo "<td colspan=20>";
				echo "<table border=\"0\" cellspacing=\"0\" cellpadding=\"0\" class=\"maintext\">";
					echo "<tr>";
						echo "<td><a href='index.php?sesid=".SESID."' class='maintext'>תפריט ראשי</a></td>";
						echo "<td width=70></td>";
						echo "<td><a href='?main=view_estimate_form_list&status=".$status."&s_ref=".$_GET['s_ref']."&limitcount=".$_GET['limitcount']."&s_date=".$_GET['s_date']."&e_date=".$_GET['e_date']."&sesid=".SESID."' class='maintext'>לרשימת ההבקשות מחיר</a></td>";
						echo "<td width=140></td>";
						
						
						echo "<td width=70></td>";
					echo "</tr>";
				echo "</table>";
			echo "</td>";
		echo "</tr>";
		
		echo "<tr><td colspan=20 height=20></td><td>></tr>";
		echo "<tr>";
			echo "<td><u>סטטוס:</u>";
		
		
			echo "<form action='?' method='GET' name='change_status_form_".$_GET['estimate_id']."'>";
			echo "<input type='hidden' name='main' value='change_status_for_contact'>";
			echo "<input type='hidden' name='gobeck' value='view_estimate_form_list'>";
			echo "<input type='hidden' name='old_status' value='".$status."'>";
			echo "<input type='hidden' name='row_id' value='".$_GET['estimate_id']."'>";
			echo "<input type='hidden' name='table' value='estimate_form'>";
			echo "<input type='hidden' name='sesid' value='".SESID."'>";
			

				
					$selected_0 = ( $status == "0" ) ? "selected" : "";
					$selected_1 = ( $status == "1" ) ? "selected" : "";
					$selected_2 = ( $status == "2" ) ? "selected" : "";
					$selected_3 = ( $status == "3" ) ? "selected" : "";
					$selected_4 = ( $status == "4" ) ? "selected" : "";
					$selected_9 = ( $status == "9" ) ? "selected" : "";
					

					echo "<select name='new_status' class='input_style' style='font-size:11px; width:110px;' onchange='change_status_form_".$_GET['estimate_id'].".submit()'>
						<option value=''>בחירה</option>
						<option value='0' ".$selected_0.">הצעות חדשות</option>
						<option value='1' ".$selected_1.">הצעות בטיפול</option>
						<option value='2' ".$selected_2.">הצעות שמחכות</option>
						<option value='3' ".$selected_3.">הצעות שנשלחו</option>
						<option value='4' ".$selected_4.">הצעות לא רלוונטיות</option>
						<option value='9' ".$selected_9.">הצעות מחוקות</option>
					</select>";

				
				
				
			echo "</form>";
				
			echo "</td>";					
		echo "</tr>";

	
	echo "<form action='?' method='POST' name='send_estimate_to_users_form'>";
	echo "<input type='hidden' name='main' value='send_estimate_to_users_Mechine'>";
	echo "<input type='hidden' name='estimate_id' value='".$_GET['estimate_id']."'>";
	echo "<input type='hidden' name='limitcount' value='".$_GET['limitcount']."'>";
	echo "<input type='hidden' name='s_date' value='".$_GET['s_date']."'>";
	echo "<input type='hidden' name='e_date' value='".$_GET['e_date']."'>";
	echo "<input type='hidden' name='s_ref' value='".$_GET['s_ref']."'>";
	echo "<input type='hidden' name='status' value='".$status."'>";
	echo "<input type='hidden' name='sesid' value='".SESID."'>";
	

		echo "<tr><td colspan=20 height=20></td><td>";
		
		echo "<tr>";
			echo "<td colspan=20>";
				echo "<table border=\"0\" cellspacing=\"0\" cellpadding=\"0\" class=\"maintext\">";
					echo "<tr>";
						echo "<td><u>תאריך:</u> ".$explode_date."</td>";
						echo "<td width=10></td>";
						echo "<td><u>אימייל:</u> ".GlobalFunctions::kill_strip($data_estimate_form['email'])."</td>";
						echo "<td width=10></td>";
						echo "<td><u>קטגוריה ראשית:</u> ".GlobalFunctions::kill_strip($data_cat_f['cat_name'])."</td>";
						echo "<td width=10></td>";
						echo "<td><u>טלפון:</u> ".GlobalFunctions::kill_strip($data_estimate_form['phone'])."</td>";
					echo "</tr>";
					echo "<tr><td colspan=7 height=5></td></tr>";
					echo "<tr>";
						echo "<td><u>שם:</u> ".GlobalFunctions::kill_strip($data_estimate_form['name'])."</td>";
						echo "<td width=10></td>";
						$NewCity = ( $data_estimate_form['NewCity'] != "" ) ? $data_estimate_form['NewCity'] : $data_estimate_form['city'];
						echo "<td><u>עיר:</u> ".GlobalFunctions::kill_strip($NewCity)."</td>";
						echo "<td width=10></td>";
						echo "<td><u>קטגוריה משנית:</u> ".GlobalFunctions::kill_strip($data_cat_s22['cat_name'])."</td>";
						echo "<td width=10></td>";
						echo "<td><u>הערה:</u> ".GlobalFunctions::kill_strip($data_estimate_form['note'])."</td>";						
					echo "</tr>";	
					echo "<tr><td colspan=7 height=5></td></tr>";
					echo "<tr>";
						echo "<td colspan=3><u>כפתורים נבחרים:</u> ".$catButtons." </td>";
						echo "<td width=10></td>";
						echo "<td colspan=6><u>התמחות:</u> ".GlobalFunctions::kill_strip($data_cat_s23['cat_name'])."</td>";
					echo "</tr>";	
					
					if( $data_estimate_form['cat_f'] == "31" || $data_estimate_form['cat_s'] == "31" )
					{
						$sql = "SELECT name FROM newCities WHERE id = '".$data_estimate_form['to_city']."' ";
						$resTocity = mysql_db_query(DB,$sql);
						$dataToCity = mysql_fetch_array($resTocity);
						
						echo "<tr><td colspan=7 height=5></td></tr>";
						echo "<tr>";
							echo "<td colspan=3><u>מספר נוסעים:</u> ".GlobalFunctions::kill_strip($data_estimate_form['passengers'])."</td>";
							echo "<td width=10></td>";
							echo "<td colspan=6><u>לעיר:</u> ".GlobalFunctions::kill_strip($dataToCity['name'])."</td>";
						echo "</tr>";	
					}
					echo "<tr><td colspan=7 height=5></td></tr>";
					if( $data_estimate_form['referer'] )
					{
					echo "<tr>";
						echo "<td><u>הגיע מהעמוד חיצוני:</u></td>";
						echo "<td width=10></td>";
						echo "<td colspan=4><a href='".$data_estimate_form['referer']."' target='_blank' class=\"maintext\">".$data_estimate_form['referer']."</a></td>";
						//echo "<td colspan=1><u>הגיע ממכשיר(בראוזר):</u> ".GlobalFunctions::kill_strip($data_estimate_form['agent'])."</td>";
						
						$mobile_sign = "";
						if($data_estimate_form['is_mobile']=="1"){
							$mobile_sign = "<div style='width: 17px;height: 14px;border-radius:3px;border:2px solid blue;font-size: 13px;-webkit-transform: rotate(31deg);padding-right: 6px;color: blue;font-family: SANS-SERIF;'>m</div>";
						}
						$campaign_sign = "";
						if($data_estimate_form['campaign_type'] == '1'){
							$campaign_sign = "<div style='height:20px;float:right;background:#ffb9b9;'>קמפיין גוגל</div>";
						}						
						if($data_estimate_form['campaign_type'] == '2'){
							$campaign_sign = "<div style='margin-right:40px;height:20px;float:right;background:#ddddff;'>קמפיין פייסבוק</div>";
						}
						echo "<td>".$mobile_sign.$campaign_sign."</td>";
					echo "</tr>";	
					}
					echo "</table>";
			echo "</td>";
		echo "</tr>";
		echo "<tr><td colspan=20 height=10></td><td>";
			
			echo "<br/><br/><a target='_NEW' href='index.php?main=send_estimate_form_users_analysis_form&estimate_id=".$_GET['estimate_id']."&s_ref=".$_GET['s_ref']."&s_date=".$_GET['s_date']."&e_date=".$_GET['e_date']."&limitcount=".$_GET['limitcount']."&status=".$_GET['status']."&sesid=".SESID."' class='maintext_link'><b>לחץ כאן כדי לבחון תוצאות פנייה</b></a>";
		echo "</td><td colspan=20 height=10></td><td>";
		if($cookie){
			if($cookie_blocked){
				echo "<br/><br/><a href='index.php?main=send_estimate_form_users_list&block_by_cookie=1&cookie=".$cookie."&relese_block=1&sesid=".SESID."' class='maintext_link'><b style='color:red'>המשתמש חסום על ידי קוקי. לחץ כאן כדי לשחרר חסימה </b></a>";
			}
			else{
				echo "<br/><br/><a href='index.php?main=send_estimate_form_users_list&block_by_cookie=1&cookie=".$cookie."&tracking_id=".$tracking_id."&estimate_form_id=".$_GET['estimate_id']."&sesid=".SESID."' class='maintext_link'><b>לחץ כאן כדי לחסום משתמש לפי קוקי</b></a>";
			}
		}
		else{
			echo "<br/><br/><b style='color:red'>פנייה זו נוצרה לפני יצירת הקוקי ולכן לא ניתן לחסום את המשתמש</b>";
		}
		echo "</td><tr>";
		
		echo "<tr><td colspan=20 height=10></td><td>";
		echo "<tr>
			<td colspan=20><a href='index.php?main=send_estimate_form_users_edit&estimate_id=".$_GET['estimate_id']."&s_ref=".$_GET['s_ref']."&s_date=".$_GET['s_date']."&e_date=".$_GET['e_date']."&limitcount=".$_GET['limitcount']."&status=".$_GET['status']."&sesid=".SESID."' class='maintext_link'><b>עריכה</b></a></td>
		<td>";
		echo "<tr><td colspan=20 height=10></td><td>";
		
		if( $data_estimate_form['10service_group_product_id'] != "0" )
		{
			echo "<tr><td colspan=20 style='font-size: 15px; color: red;'><b>ליד זה שייך להנחה חברתית</b></td></tr>";
		}
		echo "<tr><td colspan=20 height=10></td><td>";
		
		echo "<tr>";
			echo "<td><b>שם העסק</b></td>";
			echo "<td width=10></td>";
			echo "<td><b>סיום השרות</b></td>";
			echo "<td width=10></td>";
			echo "<td><b>עיר</b></td>";
			echo "<td width=10></td>";
			echo "<td><b>קטגוריה משנית</b></td>";
			echo "<td width=10></td>";
			echo "<td><b>מספר הצעות שנשלחו</b></td>";
			echo "<td width=10></td>";
			echo "<td><b>לידים שנותרו</b></td>";
			echo "<td width=10></td>";
			echo "<td><b>התאמה בעיר</b></td>";
			echo "<td width=10></td>";
			echo "<td><b>התאמה במספר נוסעים</b></td>";
			echo "<td width=10></td>";
			echo "<td><b>שליחה אוטומטית</b></td>";
			echo "<td width=10></td>";	
			echo "<td><b>התאמה סופית</b></td>";
			echo "<td width=10></td>";				
			echo "<td><b>מצב שליחה</b></td>";
			echo "<td width=10></td>";
			echo "<td><b>זמן שליחה</b></td>";
			echo "<td width=10></td>";			
			echo "<td><b>שלח</b></td>";
		echo "</tr>";
		
		echo "<tr><td colspan=20 height=15></td><td>";
		
		$s_date3 = " AND (call_date between  DATE_FORMAT(NOW() ,'%Y-%m-01') AND NOW() ) ";		
		$s_date4 = " AND (date_in between  DATE_FORMAT(NOW() ,'%Y-%m-01') AND NOW() ) ";		
		
		while( $data = mysql_fetch_array($res) )
		{
			
			$sql = "select cat_name from biz_categories where father='".$data['cat_id']."' and id='".$data_estimate_form['cat_s']."'";
			$ress = mysql_db_query(DB,$sql);
			$data_cat_s = mysql_fetch_array($ress);
			
			$stats_total_to_pay = 0;

			// SQL query that get by the user unk - the user contact forms between the date of the date right now -1 , and the the day before a month.
			$sql_check_u1 = "SELECT  distinct unk,phone,email,name,content,date_in FROM user_contact_forms WHERE unk = '" . $data['unk'] . "' ".$s_date4;
			$res_check_u1 = mysql_db_query(DB, $sql_check_u1);
			  
			// SQL query that get the phones call
			$sql_check_u2 = "SELECT distinct sms_send,call_from,answer,call_date,billsec  FROM sites_leads_stat WHERE unk = '".$data['unk']."' ".$s_date3;
			$res_check_u2 = mysql_db_query(DB, $sql_check_u2);
			  
			$phones_u_checker = array(); 
			while ($data_check_u1 = mysql_fetch_assoc($res_check_u1)) {
				if (! isValidPhone($data_check_u1['phone'])) { // phone validation.
					continue; 
				}
				if(in_array($data_check_u1['phone'], $phones_u_checker)){ // Verify uniq phone call 
					continue;
				}
				$phones_u_checker[] = $data_check_u1['phone'];
				$stats_total_to_pay++;
			}
			  
			while ($data_check_u2 = mysql_fetch_assoc($res_check_u2)) {
				if(in_array($data_check_u2['call_from'], $phones_u_checker)){ // Verify uniq phone call 
					continue;
				}
				$phones_u_checker[] = $data_check_u2['call_from'];
				$stats_total_to_pay++;
			}
			
			$sql3 = "select id from users_send_estimate_form where user_id='".$data['id']."' AND estimate_id = '".$_GET['estimate_id']."' ";
			$ress3 = mysql_db_query(DB,$sql3);
			$data_3 = mysql_fetch_array($ress3);
			
			$sql4 = "select l.leadQry,l.autoSendLeadContact from user_lead_settings as l , users as u where u.id = '".$data['id']."' and u.unk = l.unk ";
			$ress4 = mysql_db_query(DB,$sql4);
			$data_4 = mysql_fetch_array($ress4);
			
			$sql_sendtype = "select send_type,show_time,id as ucf_id from user_contact_forms where unk='".$data['unk']."' AND estimateFormID = '".$_GET['estimate_id']."' ";
			$res__sendtype = mysql_db_query(DB,$sql_sendtype);
			$data__sendtype = mysql_fetch_array($res__sendtype);			
			$city_id = $data_estimate_form['city'];
			$cityfit = "0";
			$sql_cityfit = " SELECT user_id FROM user_lead_cities WHERE user_id = '".$data['id']."' AND (city_id = ".$city_id." OR city_id = 1) ";
			$res_cityfit = mysql_db_query(DB, $sql_cityfit);
			$data_cityfit = mysql_fetch_array($res_cityfit);
			if($data_cityfit['user_id'] == $data['id']){
				$cityfit = "1";
			}
			else{
				$cat_ids = array();
				if($data_estimate_form['cat_f'] != ""){
					$cat_ids[] = $data_estimate_form['cat_f'];
				}
				if($data_estimate_form['cat_s'] != ""){
					$cat_ids[] = $data_estimate_form['cat_s'];
				}
				if($data_estimate_form['cat_spec'] != ""){
					$cat_ids[] = $data_estimate_form['cat_spec'];
				}
				$c_i = 0;
				$cIn = implode(",",$cat_ids);	
				$sql_cityfit = " SELECT user_id FROM user_cat_city WHERE user_id = '".$data['id']."' AND (city_id = ".$city_id." OR city_id = 1) AND cat_id IN(".$cIn.")";
				$res_cityfit = mysql_db_query(DB, $sql_cityfit);
				$data_cityfit = mysql_fetch_array($res_cityfit);
				if($data_cityfit['user_id'] == $data['id']){
					$cityfit = "1";
				}				
			}
			$autosendfit = "0";
			if(isset($data_4['autoSendLeadContact'])){
				$autosendfit = $data_4['autoSendLeadContact'];
			}
			$passengersfit = "1";
			if($data_estimate_form['passengers'] != "" && $data_estimate_form['passengers'] != "0"){
				$passengersfit = "0";
				$passengers = $data_estimate_form['passengers'];
				$sql_passengersfit = " SELECT unk FROM user_lead_more WHERE unk = '".$data['unk']."' AND ((from_passenger <= ".$passengers." AND until_passenger >= ".$passengers.") OR until_passenger = 0) ";
				$res_passengersfit = mysql_db_query(DB, $sql_passengersfit);
				$data_passengersfit = mysql_fetch_array($res_passengersfit);
				if($data_passengersfit['unk'] != ""){
					$passengersfit = "1";
				}
			}
			$totalfit = "0";
			if($cityfit && $passengersfit && $autosendfit){
				$totalfit = "1";
			}
			$fit_str = array(
				"0"=>"<span style='color:red'>לא</span>",
				"1"=>"<span style='color:green'>כן</span>",
			);
			echo "<tr>";
				echo "<td><a href='?main=user_profile&unk=".$data['unk']."&record_id=".$data['id']."&sesid=".SESID."' target='_NEW'>".GlobalFunctions::kill_strip($data['full_name'])." - ".GlobalFunctions::kill_strip($data['name'])."</a></td>";
				echo "<td width=10></td>";
				echo "<td>".($data['end_date'])."</td>";
				echo "<td width=10></td>";
				echo "<td>".GlobalFunctions::kill_strip($data['city'])."</td>";
				echo "<td width=10></td>";
				echo "<td>".GlobalFunctions::kill_strip($data_cat_s['cat_name'])."</td>";
				echo "<td width=10></td>";
				echo "<td>".$stats_total_to_pay."</td>";
				echo "<td width=10></td>";
				echo "<td>".$data_4['leadQry']."</td>";
				echo "<td width=10></td>";
								echo "<td>".$fit_str[$cityfit]."</td>";
				echo "<td width=10></td>";
								echo "<td>".$fit_str[$passengersfit]."</td>";
				echo "<td width=10></td>";
								echo "<td>".$fit_str[$autosendfit]."</td>";								
				echo "<td width=10></td>";
								echo "<td><b style='font-size:1.4em;'>".$fit_str[$totalfit]."</b></td>";
				echo "<td width=10></td>";
				$send_type_str = "רגיל";
				if($data__sendtype['send_type'] == "pending"){
					$send_type_str = "<b style='color:red;'>מושהה</b>";
				}
				echo "<td>".$send_type_str."</td>";
				echo "<td width=10></td>";
				echo "<td>".$data__sendtype['show_time']."</td>";
				echo "<td width=10></td>";				
				echo "<td>";
					if( empty($data_3['id']) )
						echo "<input type='checkbox' name='send_to[]' value='".$data['id']."'>";
					else{
						$payByPasswordSql = "SELECT payByPassword FROM user_contact_forms WHERE unk = '".$data['unk']."' AND estimateFormId = '".$_GET['estimate_id']."'";
						$payByPasswordRes = mysql_db_query(DB,$payByPasswordSql);
						$payByPasswordData = mysql_fetch_array($payByPasswordRes);
						
						echo "<font color='green'>נשלח</font>";
						if($payByPasswordData['payByPassword'] == '0'){
							echo "<font color='red'>***מצב כוכביות***</font>";
						}
						echo "<br/><a target='_BLANK' href='index.php?main=sentLeadsAll&sesid=".SESID."&unk=".$data['unk']."&send_refund_request=".$data__sendtype['ucf_id']."'>בקש זיכוי</a>"; 
					}
				echo "</td>";
			echo "</tr>";
			
			
			echo "<tr><td colspan=30 height=2></td><td>";
			echo "<tr><td colspan=30><hr width=100% size=1 color=#000000></td><td>";
			echo "<tr><td colspan=30 height=2></td><td>";
		}
		
		echo "<tr><td colspan=40 height=2></td><td>";
		echo "<tr><td colspan=30><hr width=100% size=1 color=#000000></td><td>";
		echo "<tr><td colspan=30 height=2></td><td>";
		echo "<tr>";
			echo "<td colspan=30 align=right><h3>הגולש בחר לקבל הצעת מחיר מהעסקים הבאים:</h3></td>";
		echo "<tr>";
		
		$sql = "select u.id, u.full_name,u.name,c.name as city,bc.cat_name, bc.id as cat_id FROM 
		users as u, 
		cities as c, 
		user_cat as uc,
		biz_categories as bc,
		mysave_choosen_send_biz as msb
		
			WHERE 
				u.city=c.id AND
				u.deleted=0 AND
				u.id=uc.user_id AND
				uc.cat_id=bc.id AND
				bc.id=".$data_estimate_form['cat_f']." AND
				bc.status=1 AND
				u.unk=msb.bizUnk AND
				msb.estimateId='".$_GET['estimate_id']."'
		 GROUP BY u.id";
	$res = mysql_db_query(DB, $sql);
		
		while( $data = mysql_fetch_array($res) )
		{
			
			$sql = "select cat_name from biz_categories where father='".$data['cat_id']."' and id='".$data_estimate_form['cat_s']."'";
			$ress = mysql_db_query(DB,$sql);
			$data_cat_s = mysql_fetch_array($ress);
			
			$sql2 = "select COUNT(id) as num_rows from users_send_estimate_form where user_id='".$data['id']."'";
			$ress2 = mysql_db_query(DB,$sql2);
			$num_rows = mysql_fetch_array($ress2);
						
			echo "<tr>";
				echo "<td>".GlobalFunctions::kill_strip($data['full_name'])." - ".GlobalFunctions::kill_strip($data['name'])."</td>";
				echo "<td width=10></td>";
				echo "<td>".GlobalFunctions::kill_strip($data['city'])."</td>";
				echo "<td width=10></td>";
				echo "<td>".GlobalFunctions::kill_strip($data_cat_s['cat_name'])."</td>";
				echo "<td width=10></td>";
				echo "<td>".$num_rows['num_rows']."</td>";
				echo "<td width=10></td>";
				echo "<td><input type='checkbox' name='send_to[]' value='".$data['id']."' checked></td>";
			echo "</tr>";
			
			
			echo "<tr><td colspan=20 height=2></td><td>";
			echo "<tr><td colspan=20><hr width=100% size=1 color=#000000></td><td>";
			echo "<tr><td colspan=20 height=2></td><td>";
		}
		
		
		if( $status != "18" )
		{
			echo "<tr>";
				echo "<td colspan=20 align=left><input type='submit' value='שלח למסומנים בלבד' style='submit_style'></td>";
			echo "<tr>";
		}
	
	echo "</form>";
	
	echo "<form action='?' method='post' name='formi_showinmysave'>";
	echo "<input type='hidden' name='main' value='estimate_form_show_in_mysave'>";
	echo "<input type='hidden' name='estimate_id' value='".$_GET['estimate_id']."'>";
	echo "<input type='hidden' name='limitcount' value='".$_GET['limitcount']."'>";
	echo "<input type='hidden' name='s_date' value='".$_GET['s_date']."'>";
	echo "<input type='hidden' name='e_date' value='".$_GET['e_date']."'>";
	echo "<input type='hidden' name='s_ref' value='".$_GET['s_ref']."'>";
	echo "<input type='hidden' name='status' value='".$status."'>";
	echo "<input type='hidden' name='sesid' value='".SESID."'>";
		echo "<tr>";
			$checked = ( $data_estimate_form['show_in_mysave'] == "1" ) ? "checked" : "";
			echo "<td colspan=20 align=right><input type='checkbox' name='show_in_mysave' value='1' ".$checked."> פרסם באתר mysave <input type='submit' value='עדכן פרסום' style='submit_style'></td>";
		echo "<tr>";
	echo "</form>";



	
	echo "</table>"; 
}


function estimate_form_show_in_mysave()
{
	$sql = "UPDATE estimate_form SET show_in_mysave = '".$_POST['show_in_mysave']."' WHERE id = '".$_POST['estimate_id']."'";
	$res = mysql_db_query(DB,$sql);
	
	echo "<script>window.location.href='index.php?main=send_estimate_form_users_list&estimate_id=".$_POST['estimate_id']."&s_ref=".$_POST['s_ref']."&s_date=".$_POST['s_date']."&e_date=".$_POST['e_date']."&limitcount=".$_POST['limitcount']."&status=".$_POST['status']."&sesid=".SESID."'</script>";
		exit;
}


function send_estimate_form_users_edit()
{
	$sql = "select * FROM estimate_form WHERE id = '".$_GET['estimate_id']."'";
	$res = mysql_db_query(DB, $sql);
	$data_estimate_form = mysql_fetch_array($res);
	
	$sql = "select id,cat_name from biz_categories where father='0' AND status=1";
	$resf = mysql_db_query(DB,$sql);
	
	$sql = "select id,cat_name from biz_categories where father='".$data_estimate_form['cat_f']."' AND status=1";
	$ress = mysql_db_query(DB,$sql);
	 
	$sql = "SELECT id, name FROM newCities WHERE father=0";
	$resAll = mysql_db_query(DB,$sql);
	
	echo "<form action='index.php' method='post' name='edit_estimate_form'>";
	echo "<input type='hidden' name='main' value='send_estimate_form_users_edit_DB'>";
	echo "<input type='hidden' name='estimate_id' value='".$_GET['estimate_id']."'>";
	echo "<input type='hidden' name='s_ref' value='".$_GET['s_ref']."'>";
	echo "<input type='hidden' name='s_date' value='".$_GET['s_date']."'>";
	echo "<input type='hidden' name='e_date' value='".$_GET['e_date']."'>";
	echo "<input type='hidden' name='limitcount' value='".$_GET['limitcount']."'>";
	echo "<input type='hidden' name='sesid' value='".SESID."'>";
	echo "<table border=\"0\" cellspacing=\"0\" cellpadding=\"0\" class=\"maintext\">";
		echo "<tr><td colspan=3><a href='javascript:history.back(-1)' class='maintext_link'>חוזר אחורה</a></td></tr>";
		echo "<tr><td colspan=3 height=20></td></tr>";
		echo "<tr>";
			echo "<td>קטגוריה ראשית</td>";
			echo "<td width='10'></td>";
			echo "<td>
				<select name='cat_f' class='input_style'>";
					while( $data_cat_f = mysql_fetch_array($resf) )
					{
						$selected = ( $data_cat_f['id'] == $data_estimate_form['cat_f'] ) ? "selected" : "";
						echo "<option value='".$data_cat_f['id']."' ".$selected.">".stripslashes($data_cat_f['cat_name'])."</option>";
					}
				echo "</select>
			</td>";
		echo "</tr>";
		echo "<tr><td colspan=3 height=7></td></tr>";
		echo "<tr>";
			echo "<td>קטגוריה משנית</td>";
			echo "<td width='10'></td>";
			echo "<td>
				<select name='cat_s' class='input_style'>";
					echo "<option value=''>בחר</option>";
					while( $data_cat_s = mysql_fetch_array($ress) )
					{
						$selected = ( $data_cat_s['id'] == $data_estimate_form['cat_s'] ) ? "selected" : "";
						echo "<option value='".$data_cat_s['id']."' ".$selected.">".stripslashes($data_cat_s['cat_name'])."</option>";
					}
				echo "</select>
			</td>";
		echo "</tr>";
		echo "<tr><td colspan=3 height=7></td></tr>";
		echo "<tr>";
			echo "<td>שם השולח</td>";
			echo "<td width='10'></td>";
			echo "<td><input type='text' name='name' value='".stripslashes($data_estimate_form['name'])."' class='input_style'></td>";
		echo "</tr>";
		echo "<tr><td colspan=3 height=7></td></tr>";
		
		echo "<tr>";
			echo "<td>עיר / אזור</td>";
			echo "<td width='10'></td>";
			echo "<td>
				<select name='city' class='input_style'>";
					echo "<option value=''>בחר</option>";
					while( $datac = mysql_fetch_array($resAll) )
					{
						$selected = ( $datac['id'] == $data_estimate_form['city'] ) ? "selected" : "";
						echo "<option value='".$datac['id']."' ".$selected." style='color: #000000;'>".stripslashes($datac['name'])."</option>";
						
						$sql = "SELECT id, name FROM newCities WHERE father=".$datac['id']."";
						$resAll2 = mysql_db_query(DB,$sql);
						
						while( $datac2 = mysql_fetch_array($resAll2) )
						{
							$selected2 = ( $datac2['id'] == $data_estimate_form['city'] ) ? "selected" : "";
							echo "<option value='".$datac2['id']."' ".$selected2.">".stripslashes($datac2['name'])."</option>";
						}
						echo "<option value=''>-----------------------</option>";
					}
				echo "</select>
			</td>";
		echo "</tr>";
		echo "<tr><td colspan=3 height=7></td></tr>";
		
		echo "<tr>";
			echo "<td>אימייל</td>";
			echo "<td width='10'></td>";
			echo "<td><input type='text' name='email' value='".stripslashes($data_estimate_form['email'])."' class='input_style'></td>";
		echo "</tr>";
		echo "<tr><td colspan=3 height=7></td></tr>";
		echo "<tr>";
			echo "<td>טלפון</td>";
			echo "<td width='10'></td>";
			echo "<td><input type='text' name='phone' value='".stripslashes($data_estimate_form['phone'])."' class='input_style'></td>";
		echo "</tr>";
		echo "<tr><td colspan=3 height=7></td></tr>";
		
		if( $data_estimate_form['cat_f'] == "31" || $data_estimate_form['cat_s'] == "31" )
		{
			$sql = "SELECT id, name FROM newCities WHERE father=0";
			$resAllCity = mysql_db_query(DB,$sql);
			
			echo "<tr>";
				echo "<td>ל-עיר \ אזור</td>";
				echo "<td width='10'></td>";
				echo "<td>
					<select name='to_city' class='input_style'>";
						echo "<option value=''>בחר</option>";
						while( $datac4 = mysql_fetch_array($resAllCity) )
						{
							$selected4 = ( $datac4['id'] == $data_estimate_form['to_city'] ) ? "selected" : "";
							echo "<option value='".$datac4['id']."' ".$selected4." style='color: #000000;'>".stripslashes($datac4['name'])."</option>";
							
							$sql = "SELECT id, name FROM newCities WHERE father=".$datac4['id']."";
							$resAll5 = mysql_db_query(DB,$sql);
							
							while( $datac5 = mysql_fetch_array($resAll5) )
							{
								$selected5 = ( $datac5['id'] == $data_estimate_form['to_city'] ) ? "selected" : "";
								echo "<option value='".$datac5['id']."' ".$selected5.">".stripslashes($datac5['name'])."</option>";
							}
							echo "<option value=''>-----------------------</option>";
						}
					echo "</select>
				</td>";
			echo "</tr>";
			echo "<tr><td colspan=3 height=7></td></tr>";
			
			echo "<tr>";
				echo "<td>מספר נוסעים</td>";
				echo "<td width='10'></td>";
				echo "<td>
					<select name='passengers' class='input_style'>";
						echo "<option value=''>בחר</option>";
						for( $i=1 ; $i<=51 ; $i++ )
						{
							$selected = ( $i == $data_estimate_form['passengers'] ) ? "selected" : "";
							$new_i = ( $i == "51" ) ? "51+" : $i ;
							echo "<option value='".$i."' ".$selected.">".$new_i."</option>";
						}
					echo "</select>
				</td>";
			echo "</tr>";
			echo "<tr><td colspan=3 height=7></td></tr>";
		}
		
		
		echo "<tr>";
			echo "<td>הערה</td>";
			echo "<td width='10'></td>";
			echo "<td><textarea name='note' cols='' rows='' class='input_style' style='height: 100px;'>".stripslashes($data_estimate_form['note'])."</textarea></td>";
		echo "</tr>";
		echo "<tr><td colspan=3 height=15></td></tr>";
		
		echo "<tr>";
			echo "<td></td>";
			echo "<td width='10'></td>";
			echo "<td><input type='submit' value='שמירה' class='input_style'></td>";
		echo "</tr>";
	echo "</table>";
	echo "</form>";
}


function send_estimate_form_users_analysis()
{
	$leads = new leadSys();	
	$return_info = $leads->get_estimate_form_users_info();
	$selected_cat = $return_info['selected_cat'];
	$city_name = $return_info['city_name'];	
	$cat_name = $return_info['cat_name'];	
	$users_analysis_arr = $return_info['users_analysis_arr'];
	$final_users_send_list = $return_info['final_users_send_list'];
	$analysis_params = array(
		0 => array('param_name'=>'user_link','param_str'=>'שם הלקוח'),
		1 => array('param_name'=>'category_fit','param_str'=>'מתאים לקטגוריה'),
		2 => array('param_name'=>'city_fit','param_str'=>'מתאים לעיר'),
		3 => array('param_name'=>'is_shabat_user','param_str'=>'לקוח שבת'),
		4 => array('param_name'=>'passengers_fit','param_str'=>'מתאים במספר הנוסעים'),
		5 => array('param_name'=>'autoSendLeadContact','param_str'=>'שליחה אוטומטית'),
		6 => array('param_name'=>'open_mode','param_str'=>'מוגדר במצב פתוח'),
		7 => array('param_name'=>'leadQry','param_str'=>'נותרו לידים'),
		8 => array('param_name'=>'freeSend','param_str'=>'שליחה חופשית'),
		9 => array('param_name'=>'open_mode_final','param_str'=>'שליחה במצב פתוח'),
		10 => array('param_name'=>'havaSms','param_str'=>'שליחת SMS'),
		11 => array('param_name'=>'haveContact','param_str'=>'שליחת אימייל'),
		12 => array('param_name'=>'send_final','param_str'=>'נשלח סופית'),
	);
	$analysis_params[] = array('param_name'=>'order','param_str'=>'מיקום בעדיפות');
	$analysis_params[] = array('param_name'=>'got_in_priority','param_str'=>'נכנס בעדיפות');	
	$analysis_params[] = array('param_name'=>'max_leads_per_month','param_str'=>'מקסימום לידים לחודש');
	$analysis_params[] = array('param_name'=>'current_preiod_max_leads','param_str'=>'מקסימום לידים תקופתי');
	$analysis_params[] = array('param_name'=>'month_leads_registered','param_str'=>'לידים רשומים לחודש');
	$analysis_params[] = array('param_name'=>'spares','param_str'=>'ספיירים מחודש קודם');
	$analysis_params[] = array('param_name'=>'spares_recived','param_str'=>'ספיירים שהוחזרו');
	$analysis_params[] = array('param_name'=>'deserve_lead','param_str'=>'ראוי לקבל');
	$analysis_params[] = array('param_name'=>'push_to_end','param_str'=>'נדחף לסוף התור');	

/* ----- extra alanysis ----- */
	$inSql = "";
	$inSql_i = 0;
	$userIdsByUnk = array();
	foreach($users_analysis_arr as $uid=>$user){
		$userIdsByUnk[$user['unk']] = $uid;
		if($inSql_i != 0){
			$inSql .= ", ";
		}
		$inSql .= $user['unk'];
		$inSql_i++;		
	} 
	
	$analysis_params[] = array('param_name'=>'past_3month','param_str'=>'לידים ב3 חודשים');
	$analysis_params[] = array('param_name'=>'past_3days','param_str'=>'לידים ב3 ימים');
	$sql = "SELECT unk,COUNT(estimateFormID) as 'sentCount' FROM user_contact_forms WHERE unk IN(".$inSql.") 
	AND date_in >= last_day(now()) + interval 1 day - interval 3 month 
	AND estimateFormID != '0' 
	GROUP BY unk
	";
	$res = mysql_db_query(DB, $sql);
	while( $data = mysql_fetch_array($res) )
	{
		$users_analysis_arr[$userIdsByUnk[$data['unk']]]['past_3month'] =$data['sentCount'];
	}
	$sql = "SELECT unk,COUNT(estimateFormID) as 'sentCount' FROM user_contact_forms WHERE unk IN(".$inSql.") 
	AND date_in >= ( CURDATE() - INTERVAL 3 DAY ) 
	AND estimateFormID != '0' 
	GROUP BY unk
	";
	$res = mysql_db_query(DB, $sql);
	while( $data = mysql_fetch_array($res) )
	{
		$users_analysis_arr[$userIdsByUnk[$data['unk']]]['past_3days'] =$data['sentCount'];
	}	
/* ----- extra alanysis ----- */	
	


/* ----- display for analysis only ----- */	

	
	?>
	<h3>ניתוח שליחת פנייה ללקוחות</h3>
	
	<h5>הפרמטרים הבאים נשלחו</h5>
	<table border=1>
		<tr>
			<th>קטגוריה ראשית</th>
			<th>קטגוריה משנית</th>
			<th>תחום</th>
			<th>עיר</th>
			<th>מספר נוסעים</th>
			<th>לעיר</th>
		</tr>
		<tr>
			<td><?php echo htmlspecialchars($cat_name[$_POST['cat_f']]) ?></td> 
			<td><?php echo htmlspecialchars($cat_name[$_POST['cat_s']]) ?></td> 
			<td><?php echo htmlspecialchars($cat_name[$_POST['cat_spec']]) ?></td> 	
			<td><?php echo htmlspecialchars($city_name[$_POST['Fm_city']]) ?></td> 
			<td><?php echo htmlspecialchars($_POST['Fm_passengers']) ?></td> 
			<td><?php echo htmlspecialchars($city_name[$_POST['Fm_to_city']]); ?> </td>
		
		</tr>
	</table>
	<style type="text/css">
		.hor-span{
			font-family: sans-serif;
			width: 15px;
			-webkit-transform: rotate(-90deg);
			display: block;
			background: #ffffb1;
			border: 1px solid #e6b8b8;
			font-size: 11px;
		}
	</style>	
	<h5>התאמת לקוחות</h5>
	<table border='1'>
		<tr>
			<?php foreach($analysis_params as $param): ?>
				<?php if($param['param_name'] != 'user_link'): ?>
					<th valign="bottom">
						<?php foreach(str_split($param['param_str']) as $char): ?>
							<?php if($char == " "): ?>
								<br/>
							<?php else: ?>
								<span  class="hor-span"><?php echo $char; ?></span>
							<?php endif; ?>
						<?php endforeach; ?>
					</th>
				<?php else: ?>
					<th><?php echo $param['param_str']; ?></th>
				<?php endif; ?>	
			<?php endforeach; ?>
		<tr>
		<?php foreach($users_analysis_arr as $user): ?>
		
			<tr>
				<?php foreach($analysis_params as $param): ?>
					<td>
						<?php if($user[$param['param_name']] === true): ?>
							<b style="color:#24ec24;">כן</b>
						<?php elseif($user[$param['param_name']] === false): ?>
							<?php if($param['param_name'] != 'passengers_fit' || $user['city_fit']): ?>
								<b style="color:red;">לא</b>
							<?php endif; ?>	
						<?php else: ?>
							<?php echo $user[$param['param_name']]; ?>
						<?php endif; ?>
					</td>
				<?php endforeach; ?>
			<tr>
		<?php endforeach; ?>
	</table>




	
	<?php	
	
	$sql = "select id,unk , full_name, name,deleted,status,end_date 
			FROM users  
			WHERE id IN(
				SELECT user_id FROM user_cat WHERE cat_id = '".$selected_cat."'
			) 
			AND (
					end_date < NOW() 
				OR 	status != '0'
				OR 	deleted != 0
			)";
	$res = mysql_db_query(DB, $sql);	
	
	?>
	<h5>לקוחות פוטנציאליים נוספים: </h5>
	<table border=1>
		<tr>
			<th>שם הלקוח</th>
			<th>מחוק</th>
			<th>סטטוס פעיל</th>
			<th>תוקף</th>
		</tr>
		<?php $users_i=0; while( $user = mysql_fetch_array($res) ): $users_i++; ?>
			<tr>
				<td><a href='?main=user_profile&unk=<?php echo $user['unk']; ?>&record_id=<?php echo $user['user_id']; ?>&sesid=<?php echo SESID; ?>' target='_blank' ><?php echo $user['name']; ?></a></td>
				<td><?php echo ($user['deleted'] != 0)? "כן":"לא"; ?></td>
				<td><?php echo ($user['status'] == 0)? "כן":"לא"; ?></td>
				<td><?php echo $user['end_date']; ?></td>
			</tr>
		<?php endwhile; ?>
		<?php if(!$users_i): ?>
			<tr>
				<td colspan='4'>לא נמצאו לקוחות נוספים</td>
			</tr>
		<?php endif; ?>
	</table>
	<br/><br/><br/><br/>

<?php
}


function send_estimate_form_users_analysis_form()
{
	$sql = "select * FROM estimate_form WHERE id = '".$_GET['estimate_id']."'";
	$res = mysql_db_query(DB, $sql);
	$data_estimate_form = mysql_fetch_array($res);
	

	
	$sql = "select id,cat_name from biz_categories where father='".$data_estimate_form['cat_f']."' AND status=1";
	$ress = mysql_db_query(DB,$sql);
	 
	$sql = "SELECT id, name FROM newCities WHERE father=0";
	$resAll = mysql_db_query(DB,$sql);
		
	
	echo "<form action='index.php' target='_NEW' method='post' name='edit_estimate_form'>";
	echo "<input type='hidden' name='main' value='send_estimate_form_users_analysis'>";

	echo "<input type='hidden' name='sesid' value='".SESID."'>";
	echo "<table border=\"0\" cellspacing=\"0\" cellpadding=\"0\" class=\"maintext\">";
		echo "<tr><td colspan=3><a href='javascript:history.back(-1)' class='maintext_link'>חוזר אחורה</a></td></tr>";
		echo "<tr><td colspan=3 height=20></td></tr>";
		echo "<tr>";
			echo "<td>קטגוריה ראשית</td>";
			echo "<td width='10'></td>";
			echo "<td>";
				if($data_estimate_form['cat_f'] != '0'){
					$sql = "select id,cat_name from biz_categories where father=(SELECT father FROM biz_categories WHERE id = '".$data_estimate_form['cat_f']."') AND status=1";
					$resf = mysql_db_query(DB,$sql);
					echo "<select name='cat_f' class='input_style'>";
						while( $data_cat_f = mysql_fetch_array($resf) )
						{
							$selected = ( $data_cat_f['id'] == $data_estimate_form['cat_f'] ) ? "selected" : "";
							echo "<option value='".$data_cat_f['id']."' ".$selected.">".stripslashes($data_cat_f['cat_name'])."</option>";
						}
					echo "</select>";
				}
				else{
					echo "<input type='hidden' name='cat_f' value='0' />";
					echo "אין קטגוריה ראשית";
				}
			echo "</td>";
		echo "</tr>";
		echo "<tr><td colspan=3 height=7></td></tr>";
		echo "<tr>";
			echo "<td>קטגוריה משנית</td>";
			echo "<td width='10'></td>";
			echo "<td>";
				if($data_estimate_form['cat_s'] != '0'){
					$sql = "select id,cat_name from biz_categories where father=(SELECT father FROM biz_categories WHERE id = '".$data_estimate_form['cat_s']."') AND status=1";
					$ress = mysql_db_query(DB,$sql);
					echo "<select name='cat_s' class='input_style'>";
						while( $data_cat_s = mysql_fetch_array($ress) )
						{
							$selected = ( $data_cat_s['id'] == $data_estimate_form['cat_s'] ) ? "selected" : "";
							echo "<option value='".$data_cat_s['id']."' ".$selected.">".stripslashes($data_cat_s['cat_name'])."</option>";
						}
					echo "</select>";
				}
				else{
					echo "<input type='hidden' name='cat_s' value='0' />";
					echo "אין קטגוריה משנית";
				}
			echo "</td>";
		echo "</tr>";



		echo "<tr><td colspan=3 height=7></td></tr>";
		echo "<tr>";
			echo "<td>תחום</td>";
			echo "<td width='10'></td>";
			echo "<td>";
				if($data_estimate_form['cat_spec'] != '0'){
					$sql = "select id,cat_name from biz_categories where father=(SELECT father FROM biz_categories WHERE id = '".$data_estimate_form['cat_spec']."') AND status=1";
					$resspec = mysql_db_query(DB,$sql);
					echo "<select name='cat_spec' class='input_style'>";
						while( $data_cat_spec = mysql_fetch_array($resspec) )
						{
							$selected = ( $data_cat_spec['id'] == $data_estimate_form['cat_spec'] ) ? "selected" : "";
							echo "<option value='".$data_cat_spec['id']."' ".$selected.">".stripslashes($data_cat_spec['cat_name'])."</option>";
						}
					echo "</select>";
				}
				else{
					echo "<input type='hidden' name='cat_spec' value='0' />";
					echo "לא נבחר תחום";
				}
			echo "</td>";
		echo "</tr>";



		
		echo "<tr><td colspan=3 height=7></td></tr>";

		echo "<tr><td colspan=3 height=7></td></tr>";
		
		echo "<tr>";
			echo "<td>עיר / אזור</td>";
			echo "<td width='10'></td>";
			echo "<td>
				<select name='Fm_city' class='input_style'>";
					echo "<option value=''>בחר</option>";
					while( $datac = mysql_fetch_array($resAll) )
					{
						$selected = ( $datac['id'] == $data_estimate_form['city'] ) ? "selected" : "";
						echo "<option value='".$datac['id']."' ".$selected." style='color: #000000;'>".stripslashes($datac['name'])."</option>";
						
						$sql = "SELECT id, name FROM newCities WHERE father=".$datac['id']."";
						$resAll2 = mysql_db_query(DB,$sql);
						
						while( $datac2 = mysql_fetch_array($resAll2) )
						{
							$selected2 = ( $datac2['id'] == $data_estimate_form['city'] ) ? "selected" : "";
							echo "<option value='".$datac2['id']."' ".$selected2.">".stripslashes($datac2['name'])."</option>";
						}
						echo "<option value=''>-----------------------</option>";
					}
				echo "</select>
			</td>";
		echo "</tr>";
		echo "<tr><td colspan=3 height=7></td></tr>";
		

		
		if( $data_estimate_form['cat_f'] == "31" || $data_estimate_form['cat_s'] == "31" )
		{
			$sql = "SELECT id, name FROM newCities WHERE father=0";
			$resAllCity = mysql_db_query(DB,$sql);
			
			echo "<tr>";
				echo "<td>ל-עיר \ אזור</td>";
				echo "<td width='10'></td>";
				echo "<td>
					<select name='Fm_to_city' class='input_style'>";
						echo "<option value=''>בחר</option>";
						while( $datac4 = mysql_fetch_array($resAllCity) )
						{
							$selected4 = ( $datac4['id'] == $data_estimate_form['to_city'] ) ? "selected" : "";
							echo "<option value='".$datac4['id']."' ".$selected4." style='color: #000000;'>".stripslashes($datac4['name'])."</option>";
							
							$sql = "SELECT id, name FROM newCities WHERE father=".$datac4['id']."";
							$resAll5 = mysql_db_query(DB,$sql);
							
							while( $datac5 = mysql_fetch_array($resAll5) )
							{
								$selected5 = ( $datac5['id'] == $data_estimate_form['to_city'] ) ? "selected" : "";
								echo "<option value='".$datac5['id']."' ".$selected5.">".stripslashes($datac5['name'])."</option>";
							}
							echo "<option value=''>-----------------------</option>";
						}
					echo "</select>
				</td>";
			echo "</tr>";
			echo "<tr><td colspan=3 height=7></td></tr>";
			
			echo "<tr>";
				echo "<td>מספר נוסעים</td>";
				echo "<td width='10'></td>";
				echo "<td>
					<select name='Fm_passengers' class='input_style'>";
						echo "<option value=''>בחר</option>";
						for( $i=1 ; $i<=51 ; $i++ )
						{
							$selected = ( $i == $data_estimate_form['passengers'] ) ? "selected" : "";
							$new_i = ( $i == "51" ) ? "51+" : $i ;
							echo "<option value='".$i."' ".$selected.">".$new_i."</option>";
						}
					echo "</select>
				</td>";
			echo "</tr>";
			echo "<tr><td colspan=3 height=7></td></tr>";
		}

		echo "<tr><td colspan=3 height=15></td></tr>";
		
		echo "<tr>";
			echo "<td></td>";
			echo "<td width='10'></td>";
			echo "<td><input type='submit' value='בדוק למי היתה נשלחת הקריאה' class='input_style'></td>";
		echo "</tr>";
		
		echo "<input type='hidden' name='update_demo_rotation_db' value = '1' />";
		
	echo "</table>";
	echo "</form>";
}



function send_estimate_form_users_edit_DB()
{
	$sql = "UPDATE estimate_form SET 
		cat_f = '".addslashes($_POST['cat_f'])."', cat_s = '".addslashes($_POST['cat_s'])."', name = '".addslashes($_POST['name'])."', 
		city = '".addslashes($_POST['city'])."', email = '".addslashes($_POST['email'])."', phone = '".addslashes($_POST['phone'])."', 
		note = '".addslashes($_POST['note'])."' ,
		to_city = '".addslashes($_POST['to_city'])."' , passengers = '".addslashes($_POST['passengers'])."' WHERE id = '".$_POST['estimate_id']."'
	";
	$res = mysql_db_query(DB,$sql);
	
	echo "<script>window.location.href='index.php?main=send_estimate_form_users_list&estimate_id=".$_POST['estimate_id']."&cat_f=".$_POST['cat_f']."&cat_s=".$_POST['cat_s']."&name=".$_POST['name']."&city=".$_POST['city']."&email=".$_POST['email']."&phone=".$_POST['phone']."&note=".$_POST['note']."&sesid=".SESID."';</script>";
		exit;
}



function send_estimate_to_users_Mechine()
{
	
	if( is_array($_POST['send_to']) )
	{
		$estimateId = $_POST['estimate_id'];
		$sql = "select ef.*, nc.name as NewCity from estimate_form as ef left join newCities as nc on ef.city=nc.id WHERE ef.id = '".$_POST['estimate_id']."'";
		$res = mysql_db_query(DB, $sql);
		$data_estimate_form = mysql_fetch_array($res);
		
		$leads = new leadSys();
		
		foreach( $_POST['send_to'] as $user_id )
		{
			$sql_user = "select unk,email,phone from users where id = '".$user_id."' ";
			$res_user = mysql_db_query(DB,$sql_user);
			$data_user = mysql_fetch_array($res_user);
			
			$settings_sql = "SELECT l.* FROM user_lead_settings as l , users as u WHERE l.unk = '".$data_user['unk']."' and u.unk = l.unk and u.end_date >= NOW() and u.status = '0'";
			$settings_res = mysql_db_query(DB,$settings_sql);
			$settings_data = mysql_fetch_array($settings_res);	

			$open_mode = false;
			if($settings_data['open_mode']>0){ //replace this
				if($settings_data['leadQry']>0){
					$open_mode = true;
				}
				else{
					if($settings_data['freeSend']>0){
						$open_mode = true;
					}								
				}							
			}	
			$remove_old_conditions = false; //($data_user['unk'] != "206591791726322603" && $data_user['unk'] != "206591791726322603");
			if ( $leads->cheackLeadSentToContact( $data_user['unk'] ) > 0 || $remove_old_conditions )
			{
				
				switch( $data_user['unk'] )
				{
					case "206591791726322603" : // maka
						
						$url = "http://www.mysave.co.il/sendExternalLead.php";
						$params = "unk=206591791726322603&";
						$params .= "name=".stripslashes(urlencode($data_estimate_form['name']))."&";
						$params .= "phone=".stripslashes(urlencode($data_estimate_form['phone']))."&";
						$params .= "email=".stripslashes(urlencode($data_estimate_form['email']))."&";
						$params .= "note=".stripslashes(urlencode($data_estimate_form['note']));
						
						$send_lead = curl_send_mysave_external_lead( $url , $params );
						
						if( $send_lead == "ok" )
						{
							// add new row to count how match forms sent to this user
							$sql = "insert into users_send_estimate_form ( user_id, estimate_id ) values ( '".$user_id."' , '".$_POST['estimate_id']."' )";
							$res = mysql_db_query(DB,$sql);
							
							// update the estimate form to sent status
							$sql = "update estimate_form set status = '3' where id = '".$_POST['estimate_id']."'";
							$res = mysql_db_query(DB,$sql);
						}
					break;
					
					case "693114573074799519" :	// estetica
											
						$sql = "select id,cat_name from biz_categories where id='".$data_estimate_form['cat_f']."'";
						$res_cat_f = mysql_db_query(DB,$sql);
						$data_cat_f = mysql_fetch_array($res_cat_f);
						
						$sql = "select id,cat_name from biz_categories where id='".$data_estimate_form['cat_s']."'";
						$res_cat_s = mysql_db_query(DB,$sql);
						$data_cat_s = mysql_fetch_array($res_cat_s);
						
						$sql = "select id,cat_name from biz_categories where id='".$data_estimate_form['cat_spec']."'";
						$res_cat_spec = mysql_db_query(DB,$sql);
						$data_cat_spec = mysql_fetch_array($res_cat_spec);
						
						
						$cat_arr = array( stripslashes($data_cat_f['cat_name']) , stripslashes($data_cat_s['cat_name']) , stripslashes($data_cat_spec['cat_name']) );
						
						
						$treatments = estetica_reutrn_cat_id($cat_arr);
						
						$url = "http://www.mysave.co.il/sendExternalLead.php";
						$params = "unk=693114573074799519&";
						$params .= "treatments=".$treatments."&";
						$params .= "name=".stripslashes(urlencode($data_estimate_form['name']))."&";
						$params .= "phone=".stripslashes(urlencode($data_estimate_form['phone']))."&";
						$params .= "email=".stripslashes(urlencode($data_estimate_form['email']))."&";
						$params .= "note=".stripslashes(urlencode($data_estimate_form['note']));
						
						$send_lead = curl_send_mysave_external_lead( $url , $params );
						
						if( $send_lead == "ok" )
						{
							// add new row to count how match forms sent to this user
							$sql = "insert into users_send_estimate_form ( user_id, estimate_id ) values ( '".$user_id."' , '".$_POST['estimate_id']."' )";
							$res = mysql_db_query(DB,$sql);
							
							// update the estimate form to sent status
							$sql = "update estimate_form set status = '3' where id = '".$_POST['estimate_id']."'";
							$res = mysql_db_query(DB,$sql);
						}
					break;
					
					
					default:
						$sql = "select id,cat_name from biz_categories where id='".$data_estimate_form['cat_f']."'";
						$res_cat_f = mysql_db_query(DB,$sql);
						$data_cat_f = mysql_fetch_array($res_cat_f);
						
						$sql = "select id,cat_name from biz_categories where id='".$data_estimate_form['cat_s']."'";
						$res_cat_s = mysql_db_query(DB,$sql);
						$data_cat_s = mysql_fetch_array($res_cat_s);
						
						$sql = "select id,cat_name from biz_categories where id='".$data_estimate_form['cat_spec']."'";
						$res_cat_spec = mysql_db_query(DB,$sql);
						$data_cat_spec = mysql_fetch_array($res_cat_spec);
						
						$fromEmail = "info@10service.co.il"; 
						$fromTitle = "10Service.co.il"; 
						$phone = $data_estimate_form['phone'];
						if(!$open_mode){
							$phone = substr_replace( $estimate_data_array['phone'] , "****" , 4 , 4 );
						}
						$content = "
							שלום,<br>
							<br>
							קבלת בקשה להצעת מחיר מהאתר <a href='http://www.10Service.co.il' class='textt' target='_blank'><u>10Service.co.il</u></a><br><br>
							תחום: ".stripslashes($data_cat_f['cat_name'])."<br>
							שירות: ".stripslashes($data_cat_s['cat_name'])."<br>
							התמחות: ".stripslashes($data_cat_spec['cat_name'])."<br>
							שם: ".stripslashes($data_estimate_form['name'])."<br>
							טלפון: ".stripslashes($phone)."<br>
							אימייל: ".stripslashes($data_estimate_form['email'])."<br>
							עיר: ".stripslashes($data_estimate_form['NewCity'])."<br>
							הערות/בקשות: <br>".nl2br(stripslashes($data_estimate_form['note']))."<br><br>
							
							על מנת לצפות בפרטים נוספים יש להכנס למערכת ניהול, שם לבחור בקטגוריה 'תצוגת טפסי צור קשר'<br>
							<a href='http://www.ilbiz.co.il/ClientSite/administration/login.php' class='textt' target='_blank'><u>למערכת ניהול לחץ כאן</u></a><br>
							<br>
							<br>
							בברכה,<br>
							מערכת IL-BIZ<BR>
							קידום עסקים באינטרנט
						";
						
						$header_send_to_Client= "קבלת טופס לקבלת הצעת מחיר";
						$content_send_to_Client = "
							<html dir=rtl>
							<head>
									<title></title>
									<style>
										.textt{font-family: arial; font-size:12px; color: #000000}
									</style>
							</head>
							
							<body>
								<p class='textt' dir=rtl align=right>".$content."</p>
							</body>
							</html>";
					
						$ClientMail = $data_user['email'];
						GlobalFunctions::send_emails_with_phpmailer($fromEmail, $fromTitle, $header_send_to_Client, $content_send_to_Client, $content_send_to_Client, $ClientMail, $fromTitle );
						if($settings_data['havaSms']){ //send sms - close or open
							$leads->sendLeadToUser($data_user['unk'], $estimateId , "1","send" ); //add sendby '1' $send_type = "send" not "pending"
							$snt_id = mysql_insert_id();
							
							$msgcity =  ( $data_estimate_form['city'] != "" ) ? $data_estimate_form['city'].", " : "";
							$user_phone = str_replace( "-" , "" , $data_user['phone'] );
							$phone_num = $data_estimate_form['phone'];
							if(!$open_mode){
								$phone_num = substr_replace( $data_estimate_form['phone'] , "****" , 4 , 4 );
							}
							$leads->sendLeadSMS("10service: ".$data_estimate_form['name'].", ".$msgcity.$phone_num , $user_phone , $snt_id,"send",$data_user['unk']);
						}		
						// insert new row to user contact system
						$data_arr['unk'] = $data_user['unk'];
				
						$sql = "select cat_name from biz_categories where id='".$data_estimate_form['cat_f']."'";
						$resf = mysql_db_query(DB,$sql);
						$data_cat_f = mysql_fetch_array($resf);
				
						$sql = "select cat_name from biz_categories where father='".$data_estimate_form['cat_f']."' and id='".$data_estimate_form['cat_s']."'";
						$ress = mysql_db_query(DB,$sql);
						$data_cat_s22 = mysql_fetch_array($ress);
						$data_cat_s22 = ( $data_cat_s22['cat_name'] != "" ) ? ", ".GlobalFunctions::kill_strip($data_cat_s22['cat_name']) : "";
						
						$sql = "select cat_name from biz_categories where father='".$data_estimate_form['cat_s']."' and id='".$data_estimate_form['cat_spec']."'";
						$ress3 = mysql_db_query(DB,$sql);
						$data_cat_s33 = mysql_fetch_array($ress3);
						$data_cat_s33 = ( $data_cat_s33['cat_name'] != "" ) ? ", ".GlobalFunctions::kill_strip($data_cat_s33['cat_name']) : "";
						
						
						$sql = "SELECT mfb.* FROM mysaveFormButton as mfb, mysaveFormButton_clientChoosen as cc WHERE cc.buttonId=mfb.id AND estimatId='".$_POST['estimate_id']."' ORDER BY mfb.place";
						$res_mfb = mysql_db_query(DB, $sql);
						
						$catButtons = "";
						while( $data_mfb = mysql_fetch_array($res_mfb) )
						{
							$catButtonsTEMP .= stripslashes($data_mfb['title']).", ";
						}
						$catButtons = substr( $catButtonsTEMP, 0, -2 );
						
						if( $data_estimate_form['referer'] != "" )
						{
							if( eregi( 'uri4u.co.il' , $data_estimate_form['referer'] ) )
								$fromSite = "uri4u: ";
							else
								$fromSite = "10service: ";
						}
						else
							$fromSite = "mysave: ";
						
						$sql = "SELECT name FROM newCities WHERE id = '".$data_estimate_form['to_city']."' ";
						$resC2 = mysql_db_query(DB,$sql);
						$data_C2 = mysql_fetch_array($resC2);
						
						$city = ( $data_estimate_form['NewCity'] != "" ) ? $data_estimate_form['NewCity'] : $data_estimate_form['city'];
						$NEW_Content_note = "עיר: ".GlobalFunctions::kill_strip($city)."\n";
						
						if( $data_estimate_form['to_city'] != "" )
							$NEW_Content_note .= "לעיר: ".GlobalFunctions::kill_strip($data_C2['name'])."\n";
						if( $data_estimate_form['passengers'] != "" )
							$NEW_Content_note .= "מספר נוסעים: ".GlobalFunctions::kill_strip($data_estimate_form['passengers'])."\n";
							
						
						$NEW_Content_note .= "לקוח מתעניין: ".GlobalFunctions::kill_strip($data_cat_f['cat_name']).$data_cat_s22.$data_cat_s33."\n";
						$NEW_Content_note .= GlobalFunctions::kill_strip($catButtons)."\n\n";
						
						//$NEW_Content_note .= "שם: ".GlobalFunctions::kill_strip($data_estimate_form['name'])."\n";
						$NEW_Content_note .= GlobalFunctions::kill_strip($data_estimate_form['note']);
						
						$data_arr['name'] = $fromSite."(".GlobalFunctions::kill_strip($data_estimate_form['name']).")";
						$data_arr['email'] = GlobalFunctions::kill_strip($data_estimate_form['email']);
						$data_arr['phone'] = GlobalFunctions::kill_strip($data_estimate_form['phone']);
						$data_arr['content'] = $NEW_Content_note;
						$data_arr['date_in'] = GlobalFunctions::get_timestemp();
						$data_arr['estimateFormID'] = $_POST['estimate_id'];
						$bill_array = array(
							"lead_recource" => "form",
							"lead_billed" => "0",
							"lead_billed_id" => "0",
						);
						
						$billing_done = false;
						
						if($open_mode){	
							$bill_array['lead_billed'] = '1';
							$bill_sql = "SELECT id as billed_id FROM user_contact_forms WHERE phone = '".$data_arr['phone']."' AND lead_billed = 1 AND unk = '".$data_arr['unk']."' AND date_in > (CAST(DATE_FORMAT(NOW() ,'%Y-%m-01') as DATE)) LIMIT 1";
							$bill_res = mysql_db_query(DB,$bill_sql);	
							$bill_data = mysql_fetch_array($bill_res);
							if(isset($bill_data['billed_id'])){
								$bill_array['lead_billed'] = '0';
								$bill_array['lead_billed_id'] = $bill_data['billed_id'];
							}		
							else{
								$leads->userLeadQryMinus1($data_user['unk']); //remove one lead
								$billing_done = true;
							}
							$leads->sendLeadToUser($data_user['unk'], $estimateId , "2" ); //add sendby '2'
							$data_arr['payByPassword'] = '1';
						}
						foreach($bill_array as $key=>$val){
							$data_arr[$key] = $val;
						}						
						$image_settings = array(
							after_success_goto=>"",
							table_name=>"user_contact_forms",
						);
				
						insert_to_db($data_arr, $image_settings);
						
						// add new row to count how match forms sent to this user
						$sql = "insert into users_send_estimate_form ( user_id, estimate_id ) values ( '".$user_id."' , '".$_POST['estimate_id']."' )";
						$res = mysql_db_query(DB,$sql);
						
						// update the estimate form to sent status
						$sql = "update estimate_form set status = '3' where id = '".$_POST['estimate_id']."'";
						$res = mysql_db_query(DB,$sql);
						
						switch($leads->cheackLeadSentToContact( $data_user['unk'] ))
						{
							case "1" :
							case "2" :
							case "4" :
								$leads->sendLeadToUser($data_user['unk'], $_POST['estimate_id']);
							break;
							
							case "3" :
							case "5" :
								$leads->sendLeadToUser($data_user['unk'], $_POST['estimate_id']);
								if(!$billing_done){
									$leads->userLeadQryMinus1($data_user['unk']);
								}
							break;
							
							case "6" :
								$leads->sendLeadToUser($data_user['unk'], $_POST['estimate_id'] , "2" );
							break;
						}
					}
					
					$estimate_stats = new estimate_stats;
					$params_stats = array();
					$params_stats['cat'] = $data_estimate_form['cat_f'];
					$params_stats['tat_cat'] = $data_estimate_form['cat_s'];
					$params_stats['spec_cat'] = $data_estimate_form['cat_spec'];
					$params_stats['client_unk'] = $data_user['unk'];
					$estimate_stats->update("3",$params_stats);
			}
			
			if( $data_estimate_form['statistic_id'] != "" )
			{
				$estimate_statisitc = new estimate_statisitc;
				$estimate_statisitc->UpdateEstimateSendToClient( $data_estimate_form['statistic_id'] , $_POST['estimate_id'] );
			}
		}
		echo "<script>alert('נשלח בהצלחה')</script>";
		echo "<script>window.location.href='index.php?main=view_estimate_form_list&status=".$status."&s_ref=".$_POST['s_ref']."&limitcount=".$_POST['limitcount']."&s_date=".$_POST['s_date']."&e_date=".$_POST['e_date']."&sesid=".SESID."';</script>";
			exit;
	}
	else
	{
		echo "<script>alert('יש לבחור לקוחות שאליהם ישלח הצעת מחיר')</script>";
		echo "<script>window.location.href='javascript:history.back(-1)';</script>";
			exit;
	}
}


function change_status_for_contact()
{
	$sql = "update ".$_GET['table']." set status='".$_GET['new_status']."' where id = '".$_GET['row_id']."'";
	$res = mysql_db_query(DB ,$sql);
	
	echo "<script>window.location.href='?main=".$_GET['gobeck']."&status=".$_GET['old_status']."&sesid=".SESID."'</script>";
		exit;
}


function curl_send_mysave_external_lead( $url , $params )
{
	$ch = curl_init();
	
	curl_setopt($ch, CURLOPT_URL, $url );
	curl_setopt($ch, CURLOPT_HEADER, 0);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	curl_setopt($ch, CURLOPT_POST, 1); 
	curl_setopt($ch, CURLOPT_POSTFIELDS, $params );
	$res = curl_exec($ch);
	curl_close($ch);
	
	return $res;
}

function estetica_reutrn_cat_id($cat_array)
{
	$array = array(
		"102" => "שאיבת שומן" ,
		"110" => "מתיחת בטן" ,
		"111" => "ניתוחים לאחר הרזיה" ,
		"114" => "הזעת יתר" ,
		"115" => "מתיחת זרועות" ,
		"116" => "מתיחת ירכיים" ,
		"117" => "ניתוחי עפעפיים" ,
		"118" => "מתיחת פנים" ,
		"119" => "הרמת מצח וגבות" ,
		"120" => "הצמדת אוזניים" ,
		"121" => "עיצוב סנטר" ,
		"123" => "ניתוח אף" ,
		"126" => "הקטנת חזה לגברים" ,
		"131" => "הרמת חזה" ,
		"132" => "הקטנת חזה" ,
		"134" => "הגדלת חזה" ,
		"135" => "הסרת שיער בלייזר" ,
		"139" => "הסרת משקפיים בלייזר" ,
		
		"141" => "הלבנת שיניים" ,
		"142" => "שתלים דנטליים" ,
		"143" => "ציפוי שיניים" ,
		
		"158" => "פילינג עמוק" ,
		"159" => "עיבוי שפתיים" ,
		"163" => "מילוי קמטים" ,
		"165" => "טיפול בורידים בולטים ברגליים" ,
		"169" => "בוטוקס" ,
		"171" => "הצרת היקפים" ,
		"182" => "המסת שומן" ,
		"196" => "שיקום הפה" ,
		
	);
	
	foreach( $array as $id => $val )
	{
		if( in_array( $val , $cat_array ) )
		{
			$return = $id;
			break;
		}
	}
	
	if( empty($return) )
		$return = 0;
	
	return $return;
}
 

function RunMassegPortal()
{
	
	$status = ( empty($_GET['status']) ) ? "0" : $_GET['status'];
	
	$sql = "select * from portal_pay_massg where status = '".$status."' order by id";
	$res = mysql_db_query(DB, $sql);
	
	echo "<table border=\"0\" cellspacing=\"0\" cellpadding=\"0\" class=\"maintext\">";
	
		$s_status_0 = ( $status == "0" ) ? "<b>" : "";
		$e_status_0 = ( $status == "0" ) ? "</b>" : "";
		
		$s_status_1 = ( $status == "1" ) ? "<b>" : "";
		$e_status_1 = ( $status == "1" ) ? "</b>" : "";
		
		$s_status_2 = ( $status == "2" ) ? "<b>" : "";
		$e_status_2 = ( $status == "2" ) ? "</b>" : "";
		
		$s_status_3 = ( $status == "3" ) ? "<b>" : "";
		$e_status_3 = ( $status == "3" ) ? "</b>" : "";
		
		$s_status_4 = ( $status == "4" ) ? "<b>" : "";
		$e_status_4 = ( $status == "4" ) ? "</b>" : "";
		
		$s_status_9 = ( $status == "9" ) ? "<b>" : "";
		$e_status_9 = ( $status == "9" ) ? "</b>" : "";
		
		echo "<tr>";
			echo "<td colspan=20>";
				echo "<table border=\"0\" cellspacing=\"0\" cellpadding=\"0\" class=\"maintext\">";
					echo "<tr>";
						echo "<td><a href='index.php?sesid=".SESID."' class='maintext'>תפריט ראשי</a></td>";
						echo "<td width=70></td>";
						echo "<td><a href='index.php?main=RunMassegPortal&status=0&sesid=".SESID."' class='maintext'>".$s_status_0."מודעות חדשות".$e_status_0."</a></td>";
						echo "<td width=20></td>";
						echo "<td><a href='index.php?main=RunMassegPortal&status=1&sesid=".SESID."' class='maintext'>".$s_status_1."מודעות באתר".$e_status_1."</a></td>";
						echo "<td width=20></td>";
						echo "<td><a href='index.php?main=RunMassegPortal&status=2&sesid=".SESID."' class='maintext'>".$s_status_2."מודעות שעבר התוקף שלהם".$e_status_2."</a></td>";
						echo "<td width=20></td>";
						echo "<td><a href='index.php?main=RunMassegPortal&status=3&sesid=".SESID."' class='maintext'>".$s_status_3."מודעות שנסגרו".$e_status_3."</a></td>";
						echo "<td width=20></td>";
						echo "<td><a href='index.php?main=RunMassegPortal&status=4&sesid=".SESID."' class='maintext'>".$s_status_4."מודעות לא רלוונטיות".$e_status_4."</a></td>";
						echo "<td width=20></td>";
						echo "<td><a href='index.php?main=RunMassegPortal&status=9&sesid=".SESID."' class='maintext'>".$s_status_9."מודעות מחוקות".$e_status_9."</a></td>";
					echo "</tr>";
				echo "</table>";
			echo "</td>";
		echo "</tr>";
		echo "<tr><td colspan=20 height=15></td><td>";
		echo "<tr>";
			echo "<td><b>מספר מודעה</b></td>";
			echo "<td width=10></td>";
			echo "<td><b>תאריך שליחת המודעה</b></td>";
			echo "<td width=10></td>";
			echo "<td><b>שם מלא</b></td>";
			echo "<td width=10></td>";
			echo "<td><b>מספר טלפון</b></td>";
			echo "<td width=10></td>";
			echo "<td><b>אימייל</b></td>";
			echo "<td width=10></td>";
			echo "<td><b>המודעה</b></td>";
			echo "<td width=10></td>";
			echo "<td><b>פורטל</b></td>";
			echo "<td width=10></td>";
			echo "<td><b>תאריך פג תוקף</b></td>";
			echo "<td width=10></td>";
			echo "<td><b>סטטוס עבודה</b></td>";
		echo "</tr>";
		
		echo "<tr><td colspan=20 height=15></td><td>";
		
		while( $data = mysql_fetch_array($res) )
		{
			$new_date = explode("-",$data['insert_date']);
			$thedate = $new_date[2]."-".$new_date[1]."-".$new_date[0];
			
			$new_date = explode("-",$data['end_date']);
			$end_date = $new_date[2]."-".$new_date[1]."-".$new_date[0];
			
			$sql = "select name from portals where id = '".$data['PortalID']."'";
			$res_portal = mysql_db_query(DB, $sql);
			$from_portal = mysql_fetch_array($res_portal);
			
			echo "<tr>";
				echo "<td>".$data['id']."</td>";
				echo "<td width=10></td>";
				echo "<td>".$thedate."</td>";
				echo "<td width=10></td>";
				echo "<td>".stripslashes(htmlspecialchars($data['full_name']))."</td>";
				echo "<td width=10></td>";
				echo "<td>".stripslashes(htmlspecialchars($data['phone']))."</td>";
				echo "<td width=10></td>";
				echo "<td>".stripslashes(htmlspecialchars($data['email']))."</td>";
				echo "<td width=10></td>";
				echo "<td><a href='".stripslashes(htmlspecialchars($data['url_link']))."' class='maintext'>".stripslashes(htmlspecialchars($data['headline']))."</A></td>";
				echo "<td width=10></td>";
				echo "<td>".stripslashes(htmlspecialchars($from_portal['name']))."</td>";
				echo "<td width=10></td>";
				echo "<td>".$end_date."</td>";
				echo "<td width=10></td>";
				echo "<td><a href='?main=UpdateRunMassegPortal&massgID=".$data['id']."&sesid=".SESID."' class='maintext'>עדכון מודעה</a></td>";
			echo "</tr>";
			
			echo "<tr><td colspan=20 height=2></td><td>";
			echo "<tr><td colspan=20><hr width=100% size=1 color=#000000></td><td>";
			echo "<tr><td colspan=20 height=2></td><td>";
		}
		
	echo "</table>"; 
	
}



function UpdateRunMassegPortal()
{
	
	$sql = "select * from portal_pay_massg where id='".$_GET['massgID']."'";
	$res = mysql_db_query(DB, $sql);
	$data = mysql_fetch_array($res);
	
	$status[0] = "מודעות חדשות";
	$status[1] = "מודעות באתר";
	$status[2] = "מודעות שעבר התוקף שלהם";
	$status[3] = "מודעות שנסגרו";
	$status[4] = "מודעות לא רלוונטיות";
	$status[9] = "מודעות מחוקות";
	
	$form_arr = array(
		array("hidden","main","UpdateDB_RunMassegPortal"),
		array("hidden","record_id",$data['id']),
		array("hidden","sesid",SESID),
		
		
		array("select","status[]",$status,"סטטוס",$data['status'],"data_arr[status]", "class='input_style''"),
		
		array("blank","<b style='font-size:17px;'>פרטים אישיים</b>"),
		array("text","data_arr[full_name]",$data['full_name'],"שם מלא", "class='input_style'","","1"),
		array("text","data_arr[phone]",$data['phone'],"טלפון", "class='input_style'","","1"),
		array("text","data_arr[email]",$data['email'],"אימייל", "class='input_style'","","1"),
		array("date","insert_date",$data['insert_date'],"תאריך שליחת מודעה", "class='input_style'",""),
		
		
		array("blank","<b style='font-size:17px;'>פרטיי ההודעה</b>"),
		
		array("text","data_arr[headline]",$data['headline'],"כותרת", "class='input_style'","","1"),
		array("text","data_arr[url_link]",$data['url_link'],"קישור", "class='input_style'","","1"),
		array("date","end_date",$data['end_date'],"תאריך סיום פרסום", "class='input_style'",""),
		
		array("submit","submit","שמירה", "class='submit_style'")
	);
	
// שדות חובה
$mandatory_fields = array("data_arr[username]","data_arr[password]","data_arr[full_name]","data_arr[name]","data_arr[email]","data_arr[phone]");
$more = "class='maintext'";

echo "<table border=\"0\" cellspacing=\"0\" cellpadding=\"0\" class=\"maintext\">";
		
		echo "<tr>";
			echo "<td><A href=\"?sesid=".SESID."\" class=\"maintext\">חזרה לתפריט הראשי</a></td>";
		echo "</tr>";
		echo "<tr><td height=\"7\"></td></tr>";
		echo "<tr>";
			echo "<td><A href=\"?main=RunMassegPortal&sesid=".SESID."\" class=\"maintext\">חזרה לרשימה המודעות</a></td>";
		echo "</tr>";
		
		echo "<tr><td height=\"11\"></td></tr>";
		
		echo "<tr>";
			echo "<td>".FormCreator::create_form($form_arr,"index.php", $more, $mandatory_fields)."</td>";
		echo "</tr>";
		
		
	echo "</table>";
}



function UpdateDB_RunMassegPortal()
{
	
	$image_settings = array(
		after_success_goto=>"?main=RunMassegPortal&sesid=".SESID."",
		table_name=>"portal_pay_massg",
		flip_date_to_original_format=>array("insert_date" , "end_date"),
	);
	$data_arr = ($_POST['data_arr'])? $_POST['data_arr'] : $_GET['data_arr'];
	update_db($data_arr, $image_settings);
	
	
}












function PortalBannerSystem()
{
	$sql = "select * from portal_banners where status != '9' order by id";
	$res = mysql_db_query(DB, $sql);
	
	echo "<table border=\"0\" cellspacing=\"0\" cellpadding=\"0\" class=\"maintext\">";
	
		echo "<tr>";
			echo "<td colspan=20>";
				echo "<table border=\"0\" cellspacing=\"0\" cellpadding=\"0\" class=\"maintext\">";
					echo "<tr>";
						echo "<td><a href='index.php?sesid=".SESID."' class='maintext'>תפריט ראשי</a></td>";
						echo "<td width=70></td>";
						echo "<td><a href='index.php?main=UPdatePortalBannerSystem&sesid=".SESID."' class='maintext'>הוסף באנר חדש</a></td>";
					echo "</tr>";
				echo "</table>";
			echo "</td>";
		echo "</tr>";
		echo "<tr><td colspan=20 height=15></td><td>";
		echo "<tr>";
			echo "<td><b>מספר באנר</b></td>";
			echo "<td width=10></td>";
			echo "<td><b>פורטל</b></td>";
			echo "<td width=10></td>";
			echo "<td><b>תאריך תחילת קמפיין</b></td>";
			echo "<td width=10></td>";
			echo "<td><b>תאריך סוף קמפיין</b></td>";
			echo "<td width=10></td>";
			echo "<td><b>כותרת</b></td>";
			echo "<td width=10></td>";
			echo "<td><b>מיקום</b></td>";
			echo "<td width=10></td>";
			echo "<td><b>עדכון</b></td>";
			echo "<td width=10></td>";
			echo "<td><b>מחיקה</b></td>";
		echo "</tr>";
		
		echo "<tr><td colspan=20 height=15></td><td>";
		
		while( $data = mysql_fetch_array($res) )
		{
			$new_date = explode("-",$data['start_date']);
			$start_date = $new_date[2]."-".$new_date[1]."-".$new_date[0];
			
			$new_date = explode("-",$data['end_date']);
			$end_date = $new_date[2]."-".$new_date[1]."-".$new_date[0];
			
			$sql = "select name from portals where id = '".$data['portal_id']."'";
			$res_portal = mysql_db_query(DB, $sql);
			$from_portal = mysql_fetch_array($res_portal);
			
			$sql = "select location_name from  portal_banners_locations where id = '".$data['location_id']."'";
			$res_portal = mysql_db_query(DB, $sql);
			$location_id = mysql_fetch_array($res_portal);
			
			echo "<tr>";
				echo "<td>".$data['id']."</td>";
				echo "<td width=10></td>";
				echo "<td>".stripslashes(htmlspecialchars($from_portal['name']))."</td>";
				echo "<td width=10></td>";
				echo "<td>".$start_date."</td>";
				echo "<td width=10></td>";
				echo "<td>".$end_date."</td>";
				echo "<td width=10></td>";
				echo "<td>".stripslashes(htmlspecialchars($data['headline']))."</td>";
				echo "<td width=10></td>";
				echo "<td>".stripslashes(htmlspecialchars($location_id['location_name']))."</td>";
				echo "<td width=10></td>";
				echo "<td><a href='?main=UPdatePortalBannerSystem&bannerID=".$data['id']."&sesid=".SESID."' class='maintext'>עדכון</a></td>";
				echo "<td width=10></td>";
				echo "<td><a href='?main=Del_DB_PortalBannerSystem&bannerID=".$data['id']."&sesid=".SESID."' class='maintext' onclick='return can_i_del()'>מחיקה</a></td>";
			echo "</tr>";
			
			echo "<tr><td colspan=20 height=2></td><td>";
			echo "<tr><td colspan=20><hr width=100% size=1 color=#000000></td><td>";
			echo "<tr><td colspan=20 height=2></td><td>";
		}
		
	echo "</table>"; 
	
}



function UPdatePortalBannerSystem()
{
	if( !empty($_GET['bannerID']) )
	{
		$sql = "select * from portal_banners where id='".$_GET['bannerID']."'";
		$res = mysql_db_query(DB, $sql);
		$data = mysql_fetch_array($res);
	}
	
	$status[0] = "פעיל";
	$status[1] = "לא פעיל";
	
	$sql = "select name from portals";
	$res_portal = mysql_db_query(DB, $sql);
	$portal_id[] = "";
	while( $data_portal = mysql_fetch_array($res_portal) )
		$portal_id[] = $data_portal['name'];
	
	
	$sql2 = "select location_name from portal_banners_locations  where deleted=0 ";
	$res_location = mysql_db_query(DB, $sql2);
	$location_id[] = "";
	while( $data_location = mysql_fetch_array($res_location) )
		$location_id[] = $data_location['location_name'];
	
	$abpath_temp = SERVER_PATH_BANNERS."/".$data['img_name'];
	if( file_exists($abpath_temp) && !is_dir($abpath_temp) )
		$details_img = "&nbsp;&nbsp;<a href=\"".HTTP_PATH_BANNERS."/".$data['img_name']."\" class=\"maintext_small\" target=\"_blank\">צפה</a>";
		//&nbsp;&nbsp;|&nbsp;&nbsp;<a href=\"index.php?main=del_img_DB_FTP&table=portal_banners&field_name=img_name&sesid=".$_GET['sesid']."&unk=".$_GET['unk']."&GOTO_type=&GOTO_main=PortalBannerSystem&img=".$data['img_name']."&sesid=".SESID."\" class=\"maintext_small\" onclick=\"return can_i_del()\">מחק </a>";

	
	$form_arr = array(
		array("hidden","main","UPdateDB_PortalBannerSystem"),
		array("hidden","record_id",$data['id']),
		array("hidden","sesid",SESID),
		array("hidden","bannerID",$_GET['bannerID']),
		
		array("blank","<b style='font-size:17px;'>הגדרות</b>"),
		array("select","status[]",$status,"סטטוס",$data['status'],"data_arr[status]", "class='input_style''"),
		array("select","portal_id[]",$portal_id,"פורטל",$data['portal_id'],"data_arr[portal_id]", "class='input_style''"),
		array("select","location_id[]",$location_id,"מיקום",$data['location_id'],"data_arr[location_id]", "class='input_style''"),
		array("date","start_date",$data['start_date'],"תאריך תחילת פרסום", "class='input_style'",""),
		array("date","end_date",$data['end_date'],"תאריך סיום פרסום", "class='input_style'",""),
		array("text","data_arr222[clicks]",$data['clicks'],"קליקים", "class='input_style'","","1"),
		array("text","data_arr222[views]",$data['views'],"צפיה", "class='input_style'","","1"),
		
		
		array("blank","<br><br><b style='font-size:17px;'>הגדרות תצוגה</b>"),
		array("text","data_arr[width]",$data['width'],"רוחב", "class='input_style'","","1"),
		array("text","data_arr[height]",$data['height'],"גובה", "class='input_style'","","1"),
		array("text","data_arr[headline]",$data['headline'],"כותרת", "class='input_style'","","1"),
		array("text","data_arr[content]",$data['content'],"תוכן", "class='input_style'","","1"),
		array("text","data_arr[url_link]",$data['url_link'],"קישור", "class='input_style'","","1"),
		
		
		array("blank","<br><br><b style='font-size:17px;'>בפלאש או בתמונה</b>"),
		array("file","img_name",$data['img_name'],"באנר ".$details_img."", "class='input_style'","","1"),
		array("text","data_arr[flash_color]",$data['flash_color'],"צבע פלאש", "class='input_style'","","1"),
		
		
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
			echo "<td><A href=\"?main=PortalBannerSystem&sesid=".SESID."\" class=\"maintext\">חזרה לרשימה הבאנרים</a></td>";
		echo "</tr>";
		
		echo "<tr><td height=\"11\"></td></tr>";
		
		if( !$_GET['bannerID'] )
		{
			echo "<tr><td>במקרה ורצונך לעלות קטע פלאש/תמונה כבאנר - דבר ראשון יש ליצור רשומה ורק לאחר מכן לעלות את הקובץ</td></tr>";
			echo "<tr><td height=\"11\"></td></tr>";
		}
		echo "<tr>";
			echo "<td>".FormCreator::create_form($form_arr,"index.php", $more)."</td>";
		echo "</tr>";
		
		
	echo "</table>";
}


function Del_DB_PortalBannerSystem()
{
	$sql = "update portal_banners set status=9 where id ='".$_GET['bannerID']."'";
	$res = mysql_db_query(DB,$sql);
	
	echo "<script>window.location.href='?main=PortalBannerSystem&sesid=".SESID."'</script>";
		exit;
}



function UPdateDB_PortalBannerSystem()
{
	$image_settings = array(
		after_success_goto=>"?main=PortalBannerSystem&sesid=".SESID."",
		table_name=>"portal_banners",
		flip_date_to_original_format=>array("start_date" , "end_date"),
	);
	$data_arr = ($_POST['data_arr'])? $_POST['data_arr'] : $_GET['data_arr'];
	
	
	if( !empty($_POST['bannerID']) )
	{
			$field_name = array("img_name");
				
				//check if files being uploaded
				if($_FILES)
				{
					for($temp=0 ; $temp<sizeof($field_name) ; $temp++)
					{
						$temp_name = $field_name[$temp];
							
						if ( $_FILES[$temp_name]['name'] != "" )
						{
										$exte = substr($_FILES[$temp_name]['name'],(strpos($_FILES[$temp_name]['name'],".")+1));
										
										$logo_name2 = $_POST['bannerID']."-PORTALbn".$data_arr['location_id'].".".$exte;
										$tempname = $logo_name;
										
										@copy($_FILES[$temp_name]['tmp_name'], SERVER_PATH_BANNERS."/$logo_name2");
										
										$sql = "UPDATE portal_banners SET ".$temp_name." = '".$logo_name2."' WHERE id = '".$_POST['bannerID']."' limit 1";
										$res = mysql_db_query(DB,$sql);
						}
					}
				}
	}
	
	
	if( !empty($_POST['bannerID']) )
		update_db($data_arr, $image_settings);
	else
		insert_to_db($data_arr, $image_settings);
}



/*******************************************************************************************************************/
/*******************************************************************************************************************/

function temp_vladi_todo()
{
	$status = ( empty($_GET['status']) ) ? "0" : $_GET['status'];
	
	$sql = "select * from temp_vladi_todo where status = '".$status."' order by id";
	$res = mysql_db_query(DB, $sql);
	
	
	echo "<table border=\"0\" cellspacing=\"0\" cellpadding=\"0\" class=\"maintext\">";
	
		$s_status_0 = ( $status == "0" ) ? "<b>" : "";
		$e_status_0 = ( $status == "0" ) ? "</b>" : "";
		
		$s_status_1 = ( $status == "1" ) ? "<b>" : "";
		$e_status_1 = ( $status == "1" ) ? "</b>" : "";
		
		$s_status_2 = ( $status == "2" ) ? "<b>" : "";
		$e_status_2 = ( $status == "2" ) ? "</b>" : "";
		
		$s_status_3 = ( $status == "3" ) ? "<b>" : "";
		$e_status_3 = ( $status == "3" ) ? "</b>" : "";
		
		$s_status_4 = ( $status == "4" ) ? "<b>" : "";
		$e_status_4 = ( $status == "4" ) ? "</b>" : "";
		
		$s_status_5 = ( $status == "5" ) ? "<b>" : "";
		$e_status_5 = ( $status == "5" ) ? "</b>" : "";
		
		$s_status_6 = ( $status == "6" ) ? "<b>" : "";
		$e_status_6 = ( $status == "6" ) ? "</b>" : "";
		
		echo "<tr>";
			echo "<td colspan=20>";
				echo "<table border=\"0\" cellspacing=\"0\" cellpadding=\"0\" class=\"maintext\">";
					echo "<tr>";
						echo "<td><a href='index.php?sesid=".SESID."' class='maintext'>תפריט ראשי</a></td>";
						echo "<td width=70></td>";
						echo "<td><a href='index.php?main=edit_temp_vladi_todo&status=".$status."&sesid=".SESID."' class='maintext'>הוסף משימה חדש</a></td>";
						echo "<td width=50></td>";
						echo "<td><a href='index.php?main=temp_vladi_todo&status=0&sesid=".SESID."' class='maintext'>".$s_status_0."עדיפות 1".$e_status_0."</a></td>";
						echo "<td width=20></td>";
						echo "<td><a href='index.php?main=temp_vladi_todo&status=1&sesid=".SESID."' class='maintext'>".$s_status_1."עדיפות 2".$e_status_1."</a></td>";
						echo "<td width=20></td>";
						echo "<td><a href='index.php?main=temp_vladi_todo&status=2&sesid=".SESID."' class='maintext'>".$s_status_2."עדיפות 3".$e_status_2."</a></td>";
						echo "<td width=20></td>";
						echo "<td><a href='index.php?main=temp_vladi_todo&status=6&sesid=".SESID."' class='maintext'>".$s_status_6."בעבודה".$e_status_6."</a></td>";
						echo "<td width=20></td>";
						echo "<td><a href='index.php?main=temp_vladi_todo&status=3&sesid=".SESID."' class='maintext'>".$s_status_3."בוצע מחכה לאישור".$e_status_3."</a></td>";
						echo "<td width=20></td>";
						echo "<td><a href='index.php?main=temp_vladi_todo&status=4&sesid=".SESID."' class='maintext'>".$s_status_4."בוצע ונסגר".$e_status_4."</a></td>";
						echo "<td width=20></td>";
						echo "<td><a href='index.php?main=temp_vladi_todo&status=5&sesid=".SESID."' class='maintext'>".$s_status_5."יבוצע בעתיד".$e_status_5."</a></td>";
					echo "</tr>";
				echo "</table>";
			echo "</td>";
		echo "</tr>";
		echo "<tr><td colspan=20 height=15></td><td>";
		echo "<tr>";
			echo "<td><b>ID</b></td>";
			echo "<td width=10></td>";
			echo "<td><b>תאריך פתיחה</b></td>";
			echo "<td width=10></td>";
			echo "<td><b>יבוצע עד לתאריך</b></td>";
			echo "<td width=10></td>";
			echo "<td><b>נושא</b></td>";
			echo "<td width=10></td>";
			echo "<td><b>פרוייקט</b></td>";
			echo "<td width=10></td>";
			echo "<td><b>פרטים נוספים</b></td>";
			echo "<td width=10></td>";
			echo "<td><b>סטטוס עבודה</b></td>";
		echo "</tr>";
		
		echo "<tr><td colspan=20 height=15></td><td>";
		
		while( $data = mysql_fetch_array($res) )
		{
			$new_date = explode("-",$data['insert_date']);
			$insert_date = $new_date[2]."-".$new_date[1]."-".$new_date[0];
			
			$new_date = explode("-",$data['needed_date']);
			$needed_date = $new_date[2]."-".$new_date[1]."-".$new_date[0];
			
			$system[0] = "אתר של לקוח";
			$system[1] = "מערכת ניהול של לקוח administration";
			$system[2] = "Mysave";
			$system[3] = "פורטל באר שבע";
			$system[4] = "פורטל ישראל";
			$system[5] = "מערכת ניהול site-admin";
			
			echo "<form action='?' method='GET' name='change_status_form_".$data['id']."_toVladi'>";
			echo "<input type='hidden' name='main' value='change_status_for_contact'>";
			echo "<input type='hidden' name='gobeck' value='temp_vladi_todo'>";
			echo "<input type='hidden' name='old_status' value='".$status."'>";
			echo "<input type='hidden' name='row_id' value='".$data['id']."'>";
			echo "<input type='hidden' name='table' value='temp_vladi_todo'>";
			echo "<input type='hidden' name='sesid' value='".SESID."'>";
			echo "<tr>";
				echo "<td>".$data['id']."</td>";
				echo "<td width=10></td>";
				echo "<td>".$insert_date."</td>";
				echo "<td width=10></td>";
				echo "<td>".$needed_date."</td>";
				echo "<td width=10></td>";
				echo "<td>".stripslashes(htmlspecialchars($data['subject']))."</td>";
				echo "<td width=10></td>";
				$temp_system = $data['system'];
				echo "<td>".$system[$temp_system]."</td>";
				echo "<td width=10></td>";
				echo "<td><a href='?main=edit_temp_vladi_todo&status=".$status."&sesid=".SESID."&row_id=".$data['id']."' class='maintext'>פרטים נוספים</a></td>";
				echo "<td width=10></td>";
				
					$selected_0 = ( $data['status'] == "0" ) ? "selected" : "";
					$selected_1 = ( $data['status'] == "1" ) ? "selected" : "";
					$selected_2 = ( $data['status'] == "2" ) ? "selected" : "";
					$selected_3 = ( $data['status'] == "3" ) ? "selected" : "";
					$selected_4 = ( $data['status'] == "4" ) ? "selected" : "";
					$selected_5 = ( $data['status'] == "5" ) ? "selected" : "";
					$selected_6 = ( $data['status'] == "6" ) ? "selected" : "";
					
				echo "<td>
					<select name='new_status' class='input_style' style='font-size:11px; width:110px;' onchange='change_status_form_".$data['id']."_toVladi.submit()'>
						<option value=''>בחירה</option>
						<option value='0' ".$selected_0.">עדיפות 1</option>
						<option value='1' ".$selected_1.">עדיפות 2</option>
						<option value='2' ".$selected_2.">עדיפות 3</option>
						<option value='6' ".$selected_6.">בעבודה</option>
						<option value='3' ".$selected_3.">בוצע מחכה לאישור</option>
						<option value='4' ".$selected_4.">בוצע ונסגר</option>
						<option value='5' ".$selected_5.">יבוצע בעתיד</option>
					</select>
				</td>";
			echo "</tr>";
			echo "</form>";
			
			echo "<tr><td colspan=20 height=2></td><td>";
			echo "<tr><td colspan=20><hr width=100% size=1 color=#000000></td><td>";
			echo "<tr><td colspan=20 height=2></td><td>";
		}
		
	echo "</table>"; 
}


function edit_temp_vladi_todo()
{
	if($_GET['row_id'] != "" )	{
		$sql = "select * from temp_vladi_todo where id = '".$_GET['row_id']."'";
		$res = mysql_db_query(DB,$sql);
		$data = mysql_fetch_array($res);
	}
	
	$status[0] = "עדיפות 1";
	$status[1] = "עדיפות 2";
	$status[2] = "עדיפות 3";
	$status[6] = "בעבודה";
	$status[3] = "בוצע מחכה לאישור";
	$status[4] = "בוצע ונסגר";
	$status[5] = "יבוצע בעתיד";
	
	$system[0] = "אתר של לקוח";
	$system[1] = "מערכת ניהול של לקוח administration";
	$system[2] = "Mysave";
	$system[3] = "פורטל באר שבע";
	$system[4] = "פורטל ישראל";
	$system[5] = "מערכת ניהול site-admin";
	
	$form_arr = array(
		array("hidden","main","edit_temp_vladi_todo_DB"),
		array("hidden","record_id",$data['id']),
		array("hidden","sesid",SESID),
		array("hidden","status",$_GET['status']),
		
		array("blank","<b style='font-size:17px;'>פרטים אישיים</b>"),
		array("text","data_arr[subject]",$data['subject'],"נושא", "class='input_style'","","1"),
		array("select","system[]",$system,"פרוייקט",$data['system'],"data_arr[system]", "class='input_style''"),
		array("text","data_arr[dir_link]",$data['dir_link'],"קישור עם הבעיה", "class='input_style'","","1"),
		array("textarea","data_arr[problem_desc]",$data['problem_desc'],"הסבר על הבעיה/שדרוג", "class='input_style' style='height:100px'"),
		
		array("text","data_arr[user_username]",$data['user_username'],"שם משתמש של הלקוח הבעייתי", "class='input_style'","","1"),
		array("text","data_arr[user_password]",$data['user_password'],"סיסמה של הלקוח הבעייתי", "class='input_style'","","1"),
		
		array("select","status[]",$status,"סטטוס",$data['status'],"data_arr[status]", "class='input_style''"),
		
		array("date","insert_date",$data['insert_date'],"תאריך התחלה <font style=\"font-size:9px;\" class=\"maintext_small\">dd-mm-yyyy</font>", "class='input_style'"),
		array("date","end_date",$data['end_date'],"תאריך סיום (ימולא שזה יבוצע) <font style=\"font-size:9px;\" class=\"maintext_small\">dd-mm-yyyy</font>", "class='input_style'"),
		array("date","needed_date",$data['needed_date'],"יבוצע עד לתאריך <font style=\"font-size:9px;\" class=\"maintext_small\">dd-mm-yyyy</font>", "class='input_style'"),
		
		
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
			echo "<td><A href=\"?main=temp_vladi_todo&status=".$_GET['status']."&sesid=".SESID."\" class=\"maintext\">לרשימת המשימות</a></td>";
		echo "</tr>";
		
		echo "<tr><td height=\"11\"></td></tr>";
		
		echo "<tr>";
			echo "<td>".FormCreator::create_form($form_arr,"index.php", $more)."</td>";
		echo "</tr>";
		
	echo "</table>";
}

function edit_temp_vladi_todo_DB()
{
	$data_arr = ($_POST['data_arr'])? $_POST['data_arr'] : $_GET['data_arr'];
	
	$image_settings = array(
		after_success_goto=>"?main=temp_vladi_todo&status=".$_POST['status']."&sesid=".SESID."",
		table_name=>"temp_vladi_todo",
		flip_date_to_original_format=>array("insert_date" , "end_date" , "needed_date"),
	);
	
	if( $_POST['record_id'] )
		update_db($data_arr, $image_settings);
	else
		insert_to_db($data_arr, $image_settings);
}

?>