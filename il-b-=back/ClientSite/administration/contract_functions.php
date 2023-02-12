<?php

function work_contracts(){
	
	global $data_extra_settings;
	if($data_extra_settings['have_contracts'] != '1'){
		return;
	}
	
	require_once('../../global_func/classes/class.contract_handler.php');
	if(isset($_GET['editor'])){
		ob_start();
		if(!isset($_GET['contract_id']) && $_GET['editor'] != "list"){
			header("Location: index.php?main=work_contracts&editor=list&unk=".UNK."&sesid=".SESID);
			return;
		}
		if($_GET['editor'] != "list"){
			contract_editor_header();
		}
		$func_name = "contract_".$_GET['editor']."_editor";
		$func_name();
		contract_handler::get_utf_8_ob_clean();
	}
	else{
		work_contract_find();
	}
}
function work_contract_find(){
	ob_start();

	?>
	
	<h3>רשימת החוזים שנחתמו באתר</h3>
	<?php if($form_msg != ""): ?>
		<b style="color:red;"><?php echo $form_msg; ?></b>
	<?php endif; ?>
	<h3>חיפוש</h3>
	<form action="?m=work_contracts" method="GET">
		<input type="hidden" name="main" value="work_contracts" />
		<input type="hidden" name="unk" value="<?php echo UNK; ?>" />
		<input type="hidden" name="sesid" value="<?php echo SESID; ?>" />
		<br/>
		<table>
			<tr>
				<td>
					אימייל <br/><input type="text" name="for_email" value="<?php echo $_REQUEST['for_email']; ?>"/> 
				</td>

				<td>
					שם פרטי <br/><input type="text" name="for_firstname"  value="<?php echo iconv("windows-1255","UTF-8", $_REQUEST['for_firstname']); ?>"/> 
				</td>
				
				<td>
					שם משפחה <br/><input type="text" name="for_lastname"  value="<?php echo iconv("windows-1255","UTF-8", $_REQUEST['for_lastname']); ?>"/> 
				</td>
			</tr>
			<tr>
				<td>
					שם חוזה <br/><input type="text" name="title" value="<?php echo iconv("windows-1255","UTF-8", $_REQUEST['title']); ?>"/> 
				</td>			
				<td>
					מתאריך <br/><input type="text" name="date_from" value="<?php echo $_REQUEST['date_from']; ?>"/> 
				</td>
				
				<td>
					עד תאריך <br/><input type="text" name="date_to" value="<?php echo $_REQUEST['date_to']; ?>"/> 
				</td>
			</tr>
			<tr>				
				<td colspan='2'>	
					<?php 
						$order_by_aproved_checked = "";
						if(isset($_GET['order_by_approved'])){
							$order_by_aproved_checked = "checked";
						}
					?>
			
				
				
						
				
					<input type="checkbox" name="order_by_approved" value="1" <?php echo $order_by_aproved_checked; ?> />התחל רשימה ממיילים שלא אושרו 
				</td>
			</tr>
			<tr>
				
				<td>
					<input type="submit" value="חפש"/>
				</td>
			</tr>
		</table>
	</form>
	<?php

	$send_contracts_msg = "";
	
	if(isset($_REQUEST['send_contracts'])){
		
		if(!isset($_REQUEST['send_contract']) || empty($_REQUEST['send_contract'])){
			
			$send_contracts_msg = "לא סומנו חוזים לביצוע הפעולה";
		}
		else{
			if($_REQUEST['sent_to'] == "cancel"){
				foreach($_REQUEST['send_contract'] as $contract_id){
					$sql = "UPDATE contract_apply SET canceled= '1' WHERE unk = '".UNK."' AND id = $contract_id";
					$res = mysql_db_query(DB, $sql);				
				}
				$send_contracts_msg = "החוזים בוטלו בהצלחה";
			}
			else{
				$sql = "SELECT email,name,domain FROM users WHERE unk = '".UNK."'";
				$res = mysql_db_query(DB, $sql);
				$user_details = mysql_fetch_array($res);
				$contracts = array();
				
				foreach($_REQUEST['send_contract'] as $contract_id){
					$sql = "SELECT * FROM contract_apply WHERE unk = '".UNK."' AND id = $contract_id";
					$res = mysql_db_query(DB,$sql);
					$contract = mysql_fetch_array($res);
					if($contract['emails'] != ""){
						$contract['emails_send_to'] = array();
						if($_REQUEST['sent_to'] == "onlyme"){
							$contract['emails_send_to'][] = $user_details['email'];
						}
						else{
							$emails_arr = explode(",",$contract['emails']);
							foreach($emails_arr as $send_to){
								$contract['emails_send_to'][] = $send_to;
							}
						}
						$contracts[] = $contract;
					}
				}
				
				if(empty($contracts)){
					$send_contracts_msg = "לא סומנו חוזים לשליחה";
				}
				else{
					

					$contracts = array();
					$sql = "SELECT email,name,domain FROM users WHERE unk = '".UNK."'";
					//send notification to site owner about contract approval
					$res = mysql_db_query(DB, $sql);
					$user_details = mysql_fetch_array($res);
					$user_email = $user_details['email'];
					$host = $user_details['domain'];
					$fromEmail = "no-reply@".$host; 
					$fromTitle = stripslashes($user_details['name']);
					foreach($_REQUEST['send_contract'] as $contract_apply_id){
						$sql = "SELECT * FROM contract_apply_users WHERE unk = '".UNK."' AND contract_apply_id = $contract_apply_id";
						$res = mysql_db_query(DB,$sql);
						$emails_approved_arr = explode(";",$contract['emails_approved']);
						$emails_approved = array();
						foreach($emails_approved_arr as $email_approved_str){
							$email_approved_arr = explode(":",$email_approved_str);
							$emails_approved[$email_approved_arr[0]] = $email_approved_arr[1];
						}
						$contract_users = array();						
						while($user_data = mysql_fetch_array($res)){
							$approve_key = false;
							if(isset($emails_approved[$user_data['email']])){
								$approve_key = $emails_approved[$user_data['email']];
							}
							$user_data['approve_key'] = $approve_key;
							$contract_users[$user_data['contract_user_id']] = $user_data;
						}
						
						$sql = "SELECT * FROM contract_apply WHERE unk = '".UNK."' AND id = $contract_apply_id";
						$res = mysql_db_query(DB,$sql);
						$contract = mysql_fetch_array($res);
						$contract['users'] = $contract_users;
						$general_page_url = "?m=work_contract_form";
						$landing_id = "";
						if($contract['landing_id'] != ""){
							$general_page_url = "/landing.php?ld=".$contract['landing_id'];
							$landing_id = $contract['landing_id'];
						}						
						$users_title_arr = array();
						foreach($contract_users as $contract_user){
							$users_title_arr[] = $contract_user['firstname']." ".$contract_user['lastname'];
						}
						if($_REQUEST['sent_to'] == "all"){
							foreach($contract_users as $email_user){
								$email_find = $email_user['email']; 
								$approve_key = $email_user['approve_key']; 
								$email_title = "שליחה חוזרת של חוזה: ";
								$email_title.= iconv("windows-1255", "UTF-8", $contract['title']);
								$email_title.= " בין: ";
								$email_title.= iconv("windows-1255", "UTF-8", implode(",",$users_title_arr));
								$email_content = "שלום ";
								$email_content.= iconv("windows-1255", "UTF-8", $email_user['firstname']." ".$email_user['lastname']).".<br/>";
								$contract_file_email = null;
								
								if($contract['pdf_path'] == ""){						
									$enter_url = "https://".$host."/$general_page_url&enter=$approve_key&contract_apply=$contract_apply_id";									
									$email_content.= "לצפייה ועדכון פרטי החוזה: ";
									$email_content.= iconv("windows-1255", "UTF-8", $contract['title']);
									$email_content.= " שנחתם בין: ";
									$email_content.= iconv("windows-1255", "UTF-8", implode(",",$users_title_arr));	
									$email_content.= "<br/>";
									$email_content.= " לחץ על הלינק הבא:  <br/>";
									$email_content.= "<a href = '$enter_url'>לחץ כאן לצפייה ועדכון החוזה</a><br/>";
								}
								else{
									$contract_file_email = array(array($contract['pdf_path']=>"work_contract.pdf"));
									$email_content.= "מצורף קובץ החוזה - ";
									$email_content.= iconv("windows-1255", "UTF-8", $contract['title']);
									$email_content.= " שנחתם בין: ";
									$email_content.= iconv("windows-1255", "UTF-8", implode(",",$users_title_arr));	
									$email_content.= "<br/>";
									if($approve_key && $approve_key != '1'){
										$approve_url = "https://".$host."/$general_page_url&approve=$approve_key&contract_apply=$contract_apply_id";
										$email_content.= "<a href = '$approve_url'>לחץ כאן על מנת לאשר את אמינות החוזה</a><br/>";
									}
								}
								$email_content.= "בברכה,<br/>";
								$email_content.= stripslashes(iconv("windows-1255","UTF-8", $user_details['name']));
								$email_content.= "<br>";
								$email_content.=  $host;
								$header_send_to_Client= iconv("UTF-8", "windows-1255",$email_title);
								$content_send_to_Client = "<html dir=rtl><head><title></title>
															<style type='text/css'>
																.textt{font-family: arial; font-size:12px; color: #000000}
																.text_link{font-family: arial; font-size:12px; color: navy}
															</style></head><body><p class='textt' dir=rtl align=right>". iconv("UTF-8", "windows-1255", $email_content)."</p></body>
															</html>";
								$ClientMail = $email_find;	
								GlobalFunctions::send_emails_with_phpmailer($fromEmail, $fromTitle, $header_send_to_Client, $content_send_to_Client, $content_send_to_Client, $ClientMail, $fromTitle, "","",$contract_file_email);
								
							}
						}
						if($contract['pdf_path'] != ""){
							$email_find = $user_details['email']; 
							$email_title = "שליחת חוזה למנהל האתר: ";
							$email_title.= iconv("windows-1255", "UTF-8", $contract['title']);
							$email_title.= " בין: ";
							$email_title.= iconv("windows-1255", "UTF-8", implode(",",$users_title_arr));
							$email_content = "שלום ";
							$email_content.= iconv("windows-1255", "UTF-8", $user_details['name']).".<br/>";
							$contract_file_email = null;

							$contract_file_email = array(array($contract['pdf_path']=>"work_contract.pdf"));
							$email_content.= "מצורף קובץ החוזה - ";
							$email_content.= iconv("windows-1255", "UTF-8", $contract['title']);
							$email_content.= " שנחתם בין: ";
							$email_content.= iconv("windows-1255", "UTF-8", implode(",",$users_title_arr));	
							$email_content.= "<br/>";
							
							$email_content.= "בברכה,<br/>";
							$email_content.= stripslashes(iconv("windows-1255","UTF-8", $user_details['name']));
							$email_content.= "<br>";
							$email_content.= $host;
							$header_send_to_Client= iconv("UTF-8", "windows-1255",$email_title);
							$content_send_to_Client = "<html dir=rtl><head><title></title>
														<style type='text/css'>
															.textt{font-family: arial; font-size:12px; color: #000000}
															.text_link{font-family: arial; font-size:12px; color: navy}
														</style></head><body><p class='textt' dir=rtl align=right>". iconv("UTF-8", "windows-1255", $email_content)."</p></body>
														</html>";
							$ClientMail = $email_find;	
							GlobalFunctions::send_emails_with_phpmailer($fromEmail, $fromTitle, $header_send_to_Client, $content_send_to_Client, $content_send_to_Client, $ClientMail, $fromTitle, "","",$contract_file_email);
							
						}						
						$send_contracts_msg = "החוזים שביקשת נשלחו בהצלחה";		
						$contracts[] = $contract;
					}
					if(empty($contracts)){
						$send_contracts_msg = "לא סומנו חוזים לשליחה";
					}
				}
			}
		}
	}	
	$email_find = trim($_REQUEST['for_email']);
	$regular_contracts_found = array();
	$canceled_contracts_found = array();
	$emails_sql = "";
	$firstname_sql = "";
	$lastname_sql = "";
	if($email_find != ""){
		$emails_sql = " AND email LIKE(\"%".$email_find."%\") ";
	}
	$firstname_find = trim($_REQUEST['for_firstname']);
	if($firstname_find != ""){
		$firstname_sql = " AND firstname LIKE(\"%".$firstname_find."%\") ";
	}
	$lastname_find = trim($_REQUEST['for_lastname']);
	if($lastname_find != ""){
		$lastname_sql = " AND lastname LIKE(\"%".$lastname_find."%\") ";
	}
	$user_find_where_sql = $emails_sql.$firstname_sql.$lastname_sql;
	$id_in_sql = "";
	if($user_find_where_sql != ""){
		$apply_users_sql = "SELECT distinct(contract_apply_id) FROM contract_apply_users WHERE 1 ".$user_find_where_sql;
		$apply_users_res = mysql_db_query(DB,$apply_users_sql);
		$id_in_arr = array();
		while($apply_users_data = mysql_fetch_array($apply_users_res)){
			$id_in_arr[] = $apply_users_data['contract_apply_id'];
		}
		$id_in_str = implode(",",$id_in_arr);
		$id_in_sql = " AND id IN(".$id_in_str.") ";
	}
	
	$date_from_sql = "";
	if($_REQUEST['date_from']!=""){
		$date_from_str = trim($_REQUEST['date_from']);
		$date_from_arr = explode("-",$date_from_str);
		$date_from_str = $date_from_arr[2]."-".$date_from_arr[1]."-".$date_from_arr[0];
		$date_from_sql = " AND sign_time > '$date_from_str' ";
	}
	$date_to_sql = "";
	if($_REQUEST['date_to']!=""){
		$date_to_str = trim($_REQUEST['date_to']);
		$date_to_arr = explode("-",$date_to_str);
		$date_to_str = $date_to_arr[2]."-".$date_to_arr[1]."-".$date_to_arr[0];
		$date_to_sql = " AND sign_time <= '$date_to_str' ";
	}
	$title_find = trim($_REQUEST['title']);
	if($title_find != ""){
		$title_sql = " AND title LIKE(\"%".$title_find."%\") ";
	}
	$order_by_fully_approved = "";
	if(isset($_GET['order_by_approved'])){
		$order_by_fully_approved = "fully_approved , ";
	}
	$find_sql = "SELECT * FROM contract_apply WHERE unk = '".UNK."' $id_in_sql $date_from_sql $date_to_sql $title_sql ORDER BY $order_by_fully_approved id desc";
	//echo $find_sql;
	$find_res = mysql_db_query(DB,$find_sql);
	while($contract = mysql_fetch_array($find_res)){
		$contract['status_str'] = "עדכון פרטים";
		if($contract['pdf_path'] != ""){
			$contract['status_str'] = "הופק קובץ";
		}
		$users_sql = "SELECT * FROM contract_apply_users WHERE contract_apply_id = ".$contract['id'];
		$users_res = mysql_db_query(DB,$users_sql);
		$contract_users = array();
		$users_by_mails = array();
		while($user_data = mysql_fetch_array($users_res)){
			$contract_users[$user_data['contract_user_id']] = $user_data;
			$users_by_mails[$user_data['email']] = $user_data;
		}
		$usernames_arr = array();
		foreach($contract_users as $contract_user){
			$usernames_arr[] = $contract_user['firstname']." ".$contract_user['lastname'];
		}
		$usernames_str = implode("<br/>",$usernames_arr);
		$contract['usernames'] = $usernames_str;
		$datetime_arr = explode(" ",$contract['sign_time']);
		$date_str_1 = $datetime_arr[0];
		$date_arr = explode("-",$date_str_1);
		$contract['date_str'] = $date_arr[2]."-".$date_arr[1]."-".$date_arr[0];
		if($contract['title'] == ""){
			$contract['title'] = "ללא כותרת";
		}
		else{
			$contract['title'] = iconv("windows-1255", "UTF-8", $contract['title']);
		}
		$contract['emails_approved_list_str'] = "";
		$contract['emails_approved_wait_list_str'] = "";
		$contract['emails_approved_list_arr'] = array();
		$contract['emails_approved_wait_list_arr'] = array();		
		$emails_approved_arr = explode(";",$contract['emails_approved']);
		foreach($emails_approved_arr as $email_approve_str){
			$has_unapproved_mail = false;
			$email_approve_arr = explode(":",$email_approve_str);
			
			if(isset($email_approve_arr[1]) && $email_approve_arr[1] != '1' && $email_approve_arr[0]!=""){
				$has_unapproved_mail = true;
				$contract['emails_approved_wait_list_str'].=$email_approve_arr[0]."<br/>";
				$contract['emails_approved_wait_list_arr'][$email_approve_arr[0]] = $users_by_mails[$email_approve_arr[0]];
			}
			else{
				$contract['emails_approved_list_str'].=$email_approve_arr[0]."<br/>";
				$contract['emails_approved_list_arr'][$email_approve_arr[0]] = $users_by_mails[$email_approve_arr[0]];
			}
		}
		$utf8_vals = array('emails','usernames','emails_approved_list_str','emails_approved_wait_list_str');
		foreach($utf8_vals as $utf8_val){
			$contract[$utf8_val] = iconv("windows-1255","UTF-8", $contract[$utf8_val]);
		}
		if($contract['canceled'] == '1'){
			$canceled_contracts_found[] = $contract;
		}
		else{
			$regular_contracts_found[] = $contract;
		}
	}
	$contracts_found = array();
	foreach($regular_contracts_found as $contract){
		$contracts_found[] = $contract;
	}
	foreach($canceled_contracts_found as $contract){
		$contracts_found[] = $contract;
	}	
	?>
	
	<?php if(empty($contracts_found)): ?>
		<p><b style="color:red;">לא נמצאו חוזים</b></p>
	<?php else: ?>
		<?php if($send_contracts_msg != ""): ?>
			<p><b style="color:green;"><?php echo $send_contracts_msg; ?></b></p>
		<?php endif; ?>
		<b>נמצאו <?php echo count($contracts_found); ?> חוזים: </b>
		<p>סמן את החוזים שברצונך שיילחו אליך למייל</p>
		<form action="?m=work_contracts" method="GET">

			<br/>
			<input type="hidden" name="for_email" value="<?php echo $email_find; ?>" />
			<?php if(isset($_GET['order_by_approved'])): ?>
				<input type="hidden" name="order_by_approved" value="1" />
			<?php endif; ?>
			<input type="hidden" name="send_contracts" value="1" />
			<table border="1" cellspacing="0" cellpadding="12" class="maintext">
				<tr>
					<th>בחירה</th>
					<th>תאריך</th>
					<th>ip</th>
					<th>אימיילים</th>
					<th>שמות</th>
					<th>שלב התקדמות</th>
				</tr>
				
				<?php foreach($contracts_found as $contract): ?>
				<tr>
					<th colspan = 20><?php echo $contract['title']; ?></th>
				</tr>
				<tr>
					<td>
					<?php if($contract['canceled'] == '1'): ?>
						<br/><b style="color:red;">בוטל</b>
					<?php else: ?>
						<input type="checkbox" name="send_contract[]" value="<?php echo $contract['id']; ?>" />
					<?php endif; ?>
					</td>
					
					<td style="white-space: nowrap;"><?php echo $contract['date_str']?></td>
					<td><?php echo $contract['ip']; ?></td>
					<td>
						<table border="1" cellspacing="0" >
							<tr>
								<th>אימייל</th>
								<th>IP אישור/סיבת דחייה</th>
							</tr>
							<tr>
								<th colspan="2">אישרו</th>
							</tr>
							
							<?php foreach($contract['emails_approved_list_arr'] as $email_user): ?>
								<tr>
									<td style="text-align:left;direction:ltr;"><?php echo $email_user['email']; ?></td>
									<td><?php echo $email_user['approve_ip']; ?></td>
								</tr>
							<?php endforeach; ?>
							
							<tr>
								<th colspan="2">לא אישרו</th>
							</tr>
							<?php foreach($contract['emails_approved_wait_list_arr'] as $email_user): ?>
								<tr>
									<td style="text-align:left;direction:ltr;"><?php echo $email_user['email']; ?></td>
									<td><?php echo iconv("windows-1255","UTF-8", $email_user['approve_note']); ?></td>
								</tr>
							<?php endforeach; ?>
						</table>
					</td>
					<td style="min-width:100px;"><?php echo $contract['usernames']; ?></td>
					<td><?php echo $contract['status_str']; ?></td>
				</tr>
					
				<?php endforeach; ?>
			</table>
			<br/>
			<b>שלח את המסומנים</b>: 
			<select name="sent_to">
				<option value="onlyme">שלח רק אליי</option>
				<option value="all">שלח אל כל המעורבים</option>
				<option value="cancel">בטל חוזה</option>
			</select>
			<input type="hidden" name="main" value="work_contracts" />
			<input type="hidden" name="unk" value="<?php echo UNK; ?>" />
			<input type="hidden" name="sesid" value="<?php echo SESID; ?>" />
			<input type="hidden" name="for_name" value="<?php echo $_GET['for_name']; ?>" />
			<input type="hidden" name="for_email" value="<?php echo $_GET['for_email']; ?>" />
			<input type="submit" value="שלח"/>
			<br/>
			<b style="color:red">אל מנהל האתר יישלחו רק חוזים שהקובץ שלהם כבר הופק</b>
		</form>			
	<?php endif; ?>
	
	<?php

	$page_content = ob_get_clean();
	echo iconv("UTF-8", "windows-1255",$page_content);
}

function contract_editor_header(){
	$domain_sql = "SELECT domain FROM users WHERE unk = '".UNK."'";
	$domain_res = mysql_db_query(DB,$domain_sql);
	$domain_data = mysql_fetch_array($domain_res);
	$site_domain = $domain_data['domain'];
	$contract_id = $_GET['contract_id']; 

	$contract_data = contract_handler::get_contract_data($_GET['contract_id']);
	?>
		<h2>ניהול חוזה: <?php echo iconv("windows-1255","UTF-8",$contract_data['title']); ?></h2>
		<table border="0" cellpadding="5">
			<tr>
				<th><a class="editor_list_menu_item" href="?main=work_contracts&editor=list&unk=<?php echo UNK; ?>&sesid=<?php echo SESID ?>">חזרה לרשימה</a></th>
				<th><a class="editor_general_menu_item" href="?main=work_contracts&editor=general&contract_id=<?php echo $contract_id; ?>&unk=<?php echo UNK; ?>&sesid=<?php echo SESID ?>">כללי</a></th>
				<th><a class="editor_fields_menu_item" href="?main=work_contracts&editor=fields&contract_id=<?php echo $contract_id; ?>&unk=<?php echo UNK; ?>&sesid=<?php echo SESID ?>">שדות בחוזה</a></th>
				<th><a class="editor_content_menu_item" href="?main=work_contracts&editor=content&contract_id=<?php echo $contract_id; ?>&unk=<?php echo UNK; ?>&sesid=<?php echo SESID ?>">תוכן</a></th>
				<th><a onclick= "return confirm('האם אתה בטוח שברצונך למחוק את החוזה?')" class="editor_content_menu_item" style="color:red;" href="?main=work_contracts&editor=general&delete_contract=1&contract_id=<?php echo $contract_id; ?>&unk=<?php echo UNK; ?>&sesid=<?php echo SESID ?>">מחיקה</a></th>
			</tr>
			<tr>
				<th colspan="3" style="text-align:right;"><a class="editor_list_menu_item" style="color:blue;" target="_BLANK" href="https://<?php echo $site_domain; ?>/?m=work_contract_form&contract_id=<?php echo $contract_id; ?>">עמוד הטופס של החוזה</a></th>
				
				<th colspan="3"><a class="editor_list_menu_item" style="color:blue;" target="_BLANK" href="https://ilbiz.co.il/work_contract.php?contract=<?php echo $contract_id; ?>">הדמייה של חוזה</a></th>
			</tr>			
			
		</table>
		
		<style type="text/css">
			.maintext a.editor_<?php echo $_GET['editor']; ?>_menu_item{color:gray;text-decoration:none;}
		</style>
	<?php
}
function contract_list_editor(){
	
	if(isset($_REQUEST['create_new_contract'])){
		$contract_title = $_REQUEST['contract_title'];
		$sql = "INSERT INTO contract_design (unk,title) VALUES('".UNK."','".$contract_title."')";
		$res = mysql_db_query(DB,$sql);
		$insert_id = mysql_insert_id();
		header("Location: index.php?main=work_contracts&editor=general&contract_id=".$insert_id."&unk=".UNK."&sesid=".SESID);
	}
	$sql = "SELECT * FROM contract_design WHERE unk = '".UNK."'";
	$res = mysql_db_query(DB,$sql);
	$contract_list = array();
	while($data = mysql_fetch_array($res)){
		$contract_list[] = $data;
	}
	?>
	<h2>ניהול חוזים</h2>
	<div>
	<form action="" method="POST">
		<h2>צור חוזה חדש:</h2>
		<b>כותרת החוזה: </b><input type="text" name="contract_title"/> <input type="submit" name="create_new_contract" value="שמור"/>
	</form>
	</div>
	<h2>רשימת חוזים:</h2>
	<table border = '0'>
		
			<?php foreach($contract_list as $contract): ?>
				<tr>
					<td>
						<a href="?main=work_contracts&editor=general&contract_id=<?php echo $contract['id']; ?>&unk=<?php echo UNK; ?>&sesid=<?php echo SESID ?>"><?php echo iconv("windows-1255","UTF-8",$contract['title']); ?></a>
					</td>
				</tr>
			<?php endforeach; ?>
		
	</table>
	
	
	
	
	<?php
}
function contract_general_editor(){
	
	$domain_sql = "SELECT domain FROM users WHERE unk = '".UNK."'";
	$domain_res = mysql_db_query(DB,$domain_sql);
	$domain_data = mysql_fetch_array($domain_res);
	$site_domain = $domain_data['domain'];
	$time = time();
	$contract_id = $_GET['contract_id'];
	//$site_domain = $domain_for_images_path;
	$path = "/home/ilan123/domains/$site_domain/public_html/user_contract/";				
	$http_path = "http://$site_domain/user_contract/";	
	if(isset($_GET['delete_contract'])){
		$img_sql = "SELECT * FROM contract_design WHERE unk = '".UNK."' AND id = '".$contract_id."'";
		$img_res = mysql_db_query(DB,$img_sql);
		$img_data = mysql_fetch_array($img_res);
		if($img_data['header_img'] != ""){
			unlink($path.$img_data['header_img']);
		}
		if($img_data['footer_img'] != ""){
			unlink($path.$img_data['footer_img']);
		}
		$del_sql = "DELETE FROM contract_design WHERE unk ='".UNK."' AND id='".$contract_id."'";
		$del_res = mysql_db_query(DB,$del_sql);
		$del_sql_2 = "DELETE FROM contract_fields_settings WHERE contract_id='".$contract_id."'"; 
		$del_res_2 = mysql_db_query(DB,$del_sql_2);
		header("Location: index.php?main=work_contracts&editor=list&unk=".UNK."&sesid=".SESID);
	}	
	if(isset($_REQUEST['edit_contract_design'])){
		$contract_id = $_REQUEST['edit_contract_design'];
		$update_arr = array("title","identifier","head_px","foot_px");
		$update_set_sql = "";
		$update_set_i = 0;
		foreach($update_arr as $update_key){
			if($update_set_i != 0){
				$update_set_sql.=",";
			}
			$update_set_sql .= $update_key ." = '".$_REQUEST[$update_key]."'";
			$update_set_i++;
		}
		$sql = "UPDATE contract_design SET $update_set_sql WHERE unk='".UNK."' AND id = ".$contract_id."";
		$res = mysql_db_query(DB,$sql);
		//check if files being uploaded
		if($_FILES)
		{
			

			if(!is_dir($path)){
				$mask=umask(0);
				mkdir($path, 0777);
				umask($mask);
			}

			$field_name = array("header_img"=>"head","footer_img"=>"foot");
			foreach($field_name as $temp_name=>$img_name)
			{
				//$temp_name = $field_name[$temp];
				if ( $_FILES[$temp_name]['name'] != "" ){
					$temp_file_name = $_FILES[$temp_name]['name'];
					
					$file_name_arr = explode(".",$temp_file_name);
					$ext_str = $file_name_arr[(count($file_name_arr) - 1)];
					$ext_str = strtolower($ext_str);
					$file_error = false;
					if($ext_str!="png" && $ext_str!="jpg" && $ext_str!="gif"){
						$file_error = "התמונה שהעלית לא תקינה(ניתן להעלות קבצים עם הסיומות הבאות בלבד: gif,jpg,png)";
					}
					elseif($_FILES[$temp_name]["size"] > 500000){
						$file_error = "התמונה שהעלית גדולה מידיי";
					}
					else{
						
						$sql = "SELECT $temp_name FROM contract_design WHERE id = $contract_id";
						$res = mysql_db_query(DB,$sql);
						$curent_image_data = mysql_fetch_array($res);
						$curent_image = $curent_image_data['header_img'];
						if($curent_image!=""){
							unlink($path.$curent_image);
						}
						

						$upload_image_name = $img_name."_".$contract_id.".$ext_str";
						$up = move_uploaded_file($_FILES[$temp_name]['tmp_name'],$path.$upload_image_name);
						if($up){
							$sql = "UPDATE contract_design SET $temp_name = '$upload_image_name' WHERE id='$contract_id'";
							$res = mysql_db_query(DB,$sql);
						}
					}
				}
			}
		}
		header("Location: index.php?main=work_contracts&editor=general&contract_id=".$_REQUEST['contract_id']."&unk=".UNK."&sesid=".SESID);
	}
	$contract = contract_handler::get_contract_data($_GET['contract_id']);
	if($contract['head_px'] == ""){
		$contract['head_px'] = 45;
	}
	if($contract['foot_px'] == ""){
		$contract['foot_px'] = 40;
	}	
	?>
		<h2>פרטים כללים</h2>
		<form action="" method="POST" enctype="multipart/form-data">
			<input type="hidden" name="edit_contract_design" value="<?php echo $contract['id']; ?>" /> 
			<div style="padding:10px; border:1px solid blue; margin-top:10px;">
				<b>כותרת</b><br/>
				<input type="text" name="title" value="<?php echo iconv("windows-1255","UTF-8",$contract['title']); ?>" /><br/>
				<br/>
				<b>מזהה(לצרכי מערכת,ניתן להשאיר ריק)</b><br/>
				<input type="text" name="identifier" value="<?php echo iconv("windows-1255","UTF-8",$contract['identifier']); ?>" /><br/>
				<h3>מיקום טקסט</h3>
				<b>מרחק מלמעלה</b><br/>
				<input type="text" name="head_px" value="<?php echo iconv("windows-1255","UTF-8",$contract['head_px']); ?>" /><br/>
				<b>מרחק מלמטה</b><br/>
				<input type="text" name="foot_px" value="<?php echo iconv("windows-1255","UTF-8",$contract['foot_px']); ?>" /><br/>
			</div>			
			<div style="padding:10px; border:1px solid blue; margin-top:10px;">
				<b>תמונת ראש</b><br/>
				<?php if($contract['header_img'] != ""): ?>
					<div>
						<img style="max-width:100%;" src ="<?php echo $http_path.$contract['header_img']; ?>?t=<?php echo $time; ?>"/>
						<br/> 
					</div>
				<?php endif; ?>			
				
				<input type="file" name="header_img" /><br/>
				<div style="clear:both;"></div>
			</div>
			<div style="padding:10px; border:1px solid blue; margin-top:10px;">
				<b>תמונת תחתית</b><br/>
				<?php if($contract['footer_img'] != ""): ?>
					<div>
						<img style="max-width:100%;" src ="<?php echo $http_path.$contract['footer_img']; ?>?t=<?php echo $time; ?>"/>
						<br/>
					</div>
				<?php endif; ?>	
				
				<input type="file" name="footer_img" /><br/>
				<div style="clear:both;"></div>
			</div>

			<?php
			
				$save_button_style = "font-size:30px;font-weight:bold;display:block; height:87px;width:200px;border-radius:50px;margin:auto;margin-top:20px;background:#eae4e4;color:#8e7d7d;cursor:pointer;";
				echo "<input type='submit' value='שמירה' class='submit_style' style = '".$save_button_style."'>";
			?>
		</form>
	<?php
}
function contract_fields_editor(){
	if(isset($_POST['fields'])){
		$sql = "DELETE FROM contract_fields_settings WHERE contract_id = '".$_REQUEST['contract_id']."'";
		$res = mysql_db_query(DB,$sql);
		foreach($_POST['fields'] as $field_setting_id=>$field_value){
			$field_value = str_replace("'","&#39;",$field_value);
			$field_value = str_replace('"',"&quot;",$field_value);
			$sql = "INSERT INTO contract_fields_settings(unk,contract_id,field_key,field_val) VALUES('".UNK."','".$_REQUEST['contract_id']."','".$field_setting_id."','".$field_value."')";
			$res = mysql_db_query(DB,$sql);
		}
		header("Location: index.php?main=work_contracts&editor=fields&contract_id=".$_REQUEST['contract_id']."&unk=".UNK."&sesid=".SESID);
	}	
	
	$contract_id = $_GET['contract_id'];
	$contract_data = contract_handler::get_contract_data($contract_id);
	$form_fields_defult = contract_handler::get_defult_fields_arr($contract_id);
	$form_fields = contract_handler::create_fields_arr_from_contract($contract_id);
	echo "<h2>שדות למילוי בחוזה</h2>";
	echo "<form name='edit_content_form' method='post' action=''>";
	echo "<input type='hidden' name='contract_id' value='$contract_id' />";
	echo "<h3>שדות למילוי בחוזה</h3>";
	echo "<div id='' style= 'text-align:right;'>";
		echo "<table id='' border='1' style= 'border-collapse:collapse;text-align:right;min-width:650px;' cellpadding='5'>";

			echo "<tr class='tr_general tr_general_main' style='background:#ffffc9;'>
				<th colspan= '2'>
					פרטים כלליים:
					<br/>
					<a class='fieldsdoor' style='color:blue;font-weight:normal;font-size:12px;' href='javascript://' onclick='return showhide_general(this);' rel='open'><span class='showstr'>הצג</span><span class='hidestr' style='display:none'>הסתר</span> שדות כלליים</a>
				</th>
				<th colspan= '20'> תגית <br/><input type='text' name='fields[general_t_title]' value='".$form_fields['general']['title']."' /></th>
				
			</tr>";
			$last_key= 0;
			echo "<tr class='tr_general'>";
				echo "<th>מיקום</th>";
				echo "<th>כותרת השדה</th>";
				echo "<th>ערך ברירת מחדל</th>";
				echo "<th>שדה חובה</th>";
				echo "<th>סוג השדה</th>";
				echo "<th>אפשר עריכה</th>";
				echo "<th></th>";
			echo "</tr>";			
			foreach($form_fields['general']['fields'] as $key=>$fields_group){
				if(is_numeric($key) && $key > $last_key){
					$last_key = $key;
				}	
				if(isset($fields_group['identifier']) && is_numeric($fields_group['identifier']) && $fields_group['identifier'] > $last_key){
					$last_key = $fields_group['identifier'];
				}				
				echo "<tr class='tr_general tr_general_".$key."'>";
					echo "<td>";
						echo "<input type='text' name='fields[general_field_t_".$key."_i_order]' value='".$fields_group['order']."' style='width:25px;'/>";
						if(!isset($fields_group['identifier'])){
							$fields_group['identifier'] = $key;
						}
						echo "<input type='hidden' name='fields[general_field_t_".$key."_i_identifier]' value='".$fields_group['identifier']."'/>";
					echo "</td>";
					echo "<td><input type='text' name='fields[general_field_t_".$key."_i_title]' value='".$fields_group['title']."' /></td>";
					echo "<td><input type='text' name='fields[general_field_t_".$key."_i_def]' value='".$fields_group['def']."' /></td>";
					echo "<td>".contract_handler::create_field_yesno_select("fields[general_field_t_".$key."_i_required]",$fields_group['required'])."</td>";	
					echo "<td>".contract_handler::create_field_type_select("fields[general_field_t_".$key."_i_type]",$fields_group['type'])."</td>";
					echo "<td>".contract_handler::create_field_yesno_select("fields[general_field_t_".$key."_i_allowedit]",$fields_group['allowedit'])."</td>";	
					echo "<th style='text-align:center;background:#ffd3d3;'><a href='javascript://' title='הסר שדה'  onclick='return remove_general_field(".$key.")' style='color:red;text-decoration:none;display:block;width:20px;'>X</a></th>";
				echo "</tr>";
				
			}
			echo "<tr class='tr_general tr_general_after'></tr>"; 
			echo "<tr class='tr_general' style='background:#eae4e4;'>
						<td colspan= '20' style='text-align:center'>
							<button style='padding: 15px 43px; font-size: 20px;width:100%; background:#ffffc9;' type='button' onclick='return add_general_field(this)' rel='$last_key'>
								הוסף שדה כללי
							</button>
						</td>
					</tr>";			
			
			echo "<tr>
			<th colspan= '2'>משתתפים:</th>
			<th colspan= '20'>תגית <br/><input type='text' name='fields[users_fields_t_title]' value='".$form_fields['users_fields']['title']."' /></th></tr>";
			$last_user = 0;
			foreach($form_fields['users_fields']['users'] as $user_key=>$user_group){
				if($user_key > $last_user){
					$last_user = $user_key;
				}
				
				if(isset($user_group['identifier']) && is_numeric($user_group['identifier']) && $user_group['identifier'] > $last_user){
					$last_user = $user_group['identifier'];
				}
				echo "<tr class='tr_user_".$user_key." tr_user_".$user_key."_main' style='background:#ffffc9;'>
				
				
							<th colspan= '2'>
								<input type='text' style='width:10px;' name='fields[users_t_".$user_key."_uid_identifier]' value='".$user_group['identifier']."' />
								משתתף ".$user_key.": <br/>
								<a class='fieldsdoor' style='color:blue;font-weight:normal;font-size:12px;' href='javascript://' onclick='return showhide_user(this,".$user_key.");' rel='open'><span class='showstr'>הצג</span><span class='hidestr' style='display:none'>הסתר</span> שדות</a>
							</th>
							<th colspan= '2'>
								תפקיד <br/><input type='text' name='fields[users_t_".$user_key."_uid_role_name]' value='".$user_group['role_name']."' /> 
								
							</th>
							<th colspan= '2'>
								מיקום - <input type='text' name='fields[users_t_".$user_key."_uid_order]' value='".$user_group['order']."' style='width:25px;'/> 
							 
							</th>	
							<th style='text-align:center;'><a href='javascript://' title='מחק משתתף' onclick='return remove_user(".$user_key.")' style='color:red;text-decoration:none;display:block;width:20px;'>X</a></th>
						</tr>";				
				
				$last_key = 0;
				echo "<tr class='tr_user_".$user_key."'>";
					echo "<th>מיקום</th>";
					echo "<th>כותרת השדה</th>";
					echo "<th>ערך ברירת מחדל</th>";
					echo "<th>שדה חובה</th>";
					echo "<th>סוג השדה</th>";
					echo "<th>אפשר עריכה</th>";
					echo "<th></th>";
					
				echo "</tr>";				
				foreach($user_group['fields'] as $key=>$fields_group){
					if(is_numeric($key) && $key > $last_key){
						$last_key = $key;
					}
					if(isset($fields_group['identifier']) && is_numeric($fields_group['identifier']) && $fields_group['identifier'] > $last_key){
						$last_key = $fields_group['identifier'];
					}
					echo "<tr class='tr_user_".$user_key." tr_user_".$user_key."_fiealds_".$key."'>";
						echo "<td>";
							echo "<input type='text' name='fields[user_field_t_".$user_key."_uid_".$key."_i_order]' value='".$fields_group['order']."' style='width:25px;'/>";
							if(!isset($fields_group['identifier'])){
								$fields_group['identifier'] = $key;
							}
							echo "<input type='hidden' name='fields[user_field_t_".$user_key."_uid_".$key."_i_identifier]' value='".$fields_group['identifier']."'/>";
							
						echo "</td>";						
						echo "<td><input type='text' name='fields[user_field_t_".$user_key."_uid_".$key."_i_title]' value='".$fields_group['title']."' /></td>";
						echo "<td><input type='text' name='fields[user_field_t_".$user_key."_uid_".$key."_i_def]' value='".$fields_group['def']."' /></td>";
						echo "<td>".contract_handler::create_field_yesno_select("fields[user_field_t_".$user_key."_uid_".$key."_i_required]",$fields_group['required'])."</td>";
						echo "<td>".contract_handler::create_field_type_select("fields[user_field_t_".$user_key."_uid_".$key."_i_type]",$fields_group['type'])."</td>";
						echo "<td>".contract_handler::create_field_yesno_select("fields[user_field_t_".$user_key."_uid_".$key."_i_allowedit]",$fields_group['allowedit'])."</td>";	
						echo "<th style='text-align:center;background:#ffd3d3;'><a href='javascript://' title='הסר שדה'  onclick='return remove_user_field(".$user_key.",".$key.")' style='color:red;text-decoration:none;display:block;width:20px;'>X</a></th>";
					echo "</tr>";
					
				}
				echo "<tr class='tr_user_".$user_key." tr_user_".$user_key."_after'></tr>"; 
				echo "<tr class='tr_user_".$user_key."' style='background:#eae4e4;'>
						<td colspan= '20' style='text-align:center;'>
							<button style='padding: 15px 43px; font-size: 20px;width:100%; background:#fafafa;' type='button' onclick='return add_user_field(this,".$user_key.")' rel='$last_key'>
								הוסף שדה למשתתף ".$user_key."
							</button>
						</td>
					</tr>";
				
			}
			echo "<tr class='tr_add_user' style='background:#eae4e4;'>
						<td colspan= '20' style='text-align:center'>
							<button style='padding: 15px 43px; font-size: 20px;width:100%;background:#ffffc9;' type='button' onclick='return add_user(this)' rel='".$last_user."'>
								הוסף משתתף
							</button>
						</td>
					</tr>";
		echo "</table>";
		$save_button_style = "font-size:30px;font-weight:bold;display:block; height:87px;width:200px;border-radius:50px;margin:auto;margin-top:20px;background:#eae4e4;color:#8e7d7d;cursor:pointer;";
		echo "<input type='submit' value='שמירה' class='submit_style' style = '".$save_button_style."'>";
	echo "</div>";
	echo "</form>";
	//script templates
	echo "<table style='display:none;' id='fields_editor_templates'>";
	
		$key = "fieldkey";
		$user_key = "userkey";
		//general field template
		echo "<tr class='tr_general tr_general_fieldkey tr_general_fieald_fieldkey'>";
			echo "<td>";
				echo "<input type='text' name='fields[general_field_t_".$key."_i_order]' value='10' style='width:25px;'/>";
				echo "<input type='hidden' name='fields[general_field_t_".$key."_i_identifier]' value='".$key."'/>";
			echo "</td>";
			echo "<td><input type='text' name='fields[general_field_t_".$key."_i_title]' value='' /></td>";
			echo "<td><input type='text' name='fields[general_field_t_".$key."_i_def]' value='' /></td>";
			echo "<td>".contract_handler::create_field_yesno_select("fields[general_field_t_".$key."_i_required]",'1')."</td>";	
			echo "<td>".contract_handler::create_field_type_select("fields[general_field_t_".$key."_i_type]",'')."</td>";
			echo "<td>".contract_handler::create_field_yesno_select("fields[general_field_t_".$key."_i_allowedit]",'1')."</td>";	
			echo "<th style='text-align:center;background:#ffd3d3;'><a href='javascript://' title='הסר שדה'  onclick='return remove_general_field(".$key.")' style='color:red;text-decoration:none;display:block;width:20px;'>X</a></th>";			
		echo "</tr>";	
		


		//full user template
		echo "<tr class='tr_user_".$user_key." tr_user_".$user_key."_main tr_user_temp_".$user_key."' style='background:#ffffc9;'>
			<th colspan= '2'>
				<input type='text' style='width:10px;' name='fields[users_t_".$user_key."_uid_identifier]' value='".$user_key."' />
				משתתף ".$user_key.": 
				<br/>
				<a class='fieldsdoor' style='color:blue;font-weight:normal;font-size:12px;' href='javascript://' onclick='return showhide_user(this,".$user_key.");' rel='open'><span class='showstr' style='display:none'>הצג</span><span class='hidestr'>הסתר</span> שדות</a>
			</th>
			<th colspan= '2'>
				תפקיד <br/><input type='text' name='fields[users_t_".$user_key."_uid_role_name]' value='' /> 
			</th>
			<th colspan= '2'>
				מיקום - <input type='text' name='fields[users_t_".$user_key."_uid_order]' value='10'  style='width:25px;'/> 
			 
			</th>
			<th style='text-align:center;'><a href='javascript://' title='מחק משתתף'  onclick='return remove_user(".$user_key.")' style='color:red;text-decoration:none;display:block;width:20px;'>X</a></th>
		</tr>";
		$last_key = 0;
		echo "<tr class='tr_user_".$user_key." tr_user_temp_".$user_key."'>";
			echo "<th>מיקום</th>";
			echo "<th>כותרת השדה</th>";
			echo "<th>ערך ברירת מחדל</th>";
			echo "<th>שדה חובה</th>";
			echo "<th>סוג השדה</th>";
			echo "<th>אפשר עריכה</th>";
			echo "<th></th>";
		echo "</tr>";
		foreach($form_fields_defult['users_fields']['users'][1]['fields'] as $key=>$fields_group){
			if(is_numeric($key) && $key > $last_key){
				$last_key = $key;
			}
			if(is_numeric($fields_group['identifier']) && $fields_group['identifier'] > $last_key){
				$last_key = $fields_group['identifier'];
			}			
			echo "<tr class='tr_user_".$user_key." tr_user_temp_".$user_key."  tr_user_".$user_key."_fiealds_".$key."'>";
				echo "<td>";
					echo "<input type='text' name='fields[user_field_t_".$user_key."_uid_".$key."_i_order]' value='".$fields_group['order']."' style='width:25px;'/>";
					if(!isset($fields_group['identifier'])){
						$fields_group['identifier'] = $key;
					}
					echo "<input type='hidden' name='fields[user_field_t_".$user_key."_uid_".$key."_i_identifier]' value='".$fields_group['identifier']."'/>";
				echo "</td>";
				echo "<td><input type='text' name='fields[user_field_t_".$user_key."_uid_".$key."_i_title]' value='".$fields_group['title']."' /></td>";
				echo "<td><input type='text' name='fields[user_field_t_".$user_key."_uid_".$key."_i_def]' value='".$fields_group['def']."' /></td>";
				echo "<td>".contract_handler::create_field_yesno_select("fields[user_field_t_".$user_key."_uid_".$key."_i_required]",$fields_group['required'])."</td>";
				echo "<td>".contract_handler::create_field_type_select("fields[user_field_t_".$user_key."_uid_".$key."_i_type]",'')."</td>";
				echo "<td>".contract_handler::create_field_yesno_select("fields[user_field_t_".$user_key."_uid_".$key."_i_allowedit]",$fields_group['allowedit'])."</td>";
				echo "<th style='text-align:center;background:#ffd3d3;'><a href='javascript://' title='הסר שדה'  onclick='return remove_user_field(".$user_key.",".$key.")' style='color:red;text-decoration:none;display:block;width:20px;'>X</a></th>";
			echo "</tr>";
					
			
		}
		echo "<tr class='tr_user_".$user_key." tr_user_temp_".$user_key." tr_user_".$user_key."_after'></tr>"; 
		echo "<tr class='tr_user_".$user_key." tr_user_temp_".$user_key." ' style='background:#eae4e4;'>
					<td colspan= '20' style='text-align:center'>
						<button style='padding: 15px 43px; font-size: 20px; width:100%; background:#fafafa;' type='button' onclick='return add_user_field(this,".$user_key.")' rel='$last_key'>
							הוסף שדה למשתתף ".$user_key."
						</button>
					</td>
				</tr>";
		
		//user input template
		$key = "fieldkey";
			echo "<tr class='tr_user_".$user_key." tr_user_userkey_fiealds_fieldkey tr_user_userkey_fieald_fieldkey'>";
				echo "<td>";
					echo "<input type='text' name='fields[user_field_t_".$user_key."_uid_".$key."_i_order]' value='10' style='width:25px;'/>";
					echo "<input type='hidden' name='fields[user_field_t_".$user_key."_uid_".$key."_i_identifier]' value='".$key."'/>";
				echo "</td>";
				echo "<td><input type='text' name='fields[user_field_t_".$user_key."_uid_".$key."_i_title]' value='' /></td>";
				echo "<td><input type='text' name='fields[user_field_t_".$user_key."_uid_".$key."_i_def]' value='' /></td>";
				echo "<td>".contract_handler::create_field_yesno_select("fields[user_field_t_".$user_key."_uid_".$key."_i_required]",'1')."</td>";
				echo "<td>".contract_handler::create_field_type_select("fields[user_field_t_".$user_key."_uid_".$key."_i_type]",'')."</td>";
				echo "<td>".contract_handler::create_field_yesno_select("fields[user_field_t_".$user_key."_uid_".$key."_i_allowedit]",'1')."</td>";				
				echo "<th style='text-align:center;background:#ffd3d3;'><a href='javascript://' title='הסר שדה'  onclick='return remove_user_field(".$user_key.",".$key.")' style='color:red;text-decoration:none;display:block;width:20px;'>X</a></th>";
			echo "</tr>";		
		
	echo "</table>";	
?>
	<script type="text/javascript">
		jQuery(document).ready(
			function($){
				$(".fieldsdoor").each(function(){$(this).click();});
			}
		);
			
		function add_user_field(el_id,user_id){
			jQuery(function($){
				var ftr = $('<div>').append($(".tr_user_userkey_fieald_fieldkey").first().clone()).html(); 
				var find = "userkey";
				var replace = user_id;
				ftr = ftr.replace(new RegExp(find, 'g'), replace);
	
				var lastkey = $(el_id).attr("rel");
				
				var lastkeyint = parseInt(lastkey) + 1;
				
				$(el_id).attr("rel",lastkeyint);
				find = "fieldkey";
				replace = lastkeyint;
				ftr = ftr.replace(new RegExp(find, 'g'), replace);				
				$(ftr).insertBefore(".tr_user_"+user_id+"_after");
			});
		}
		function add_general_field(el_id){
			jQuery(function($){
				var ftr = $('<div>').append($(".tr_general_fieald_fieldkey").first().clone()).html(); 
				var lastkey = $(el_id).attr("rel");
				
				var lastkeyint = parseInt(lastkey) + 1;
				
				$(el_id).attr("rel",lastkeyint);
				find = "fieldkey";
				replace = lastkeyint;
				ftr = ftr.replace(new RegExp(find, 'g'), replace);				
				$(ftr).insertBefore(".tr_general_after");
			});
		}		
		function add_user(el_id){
			jQuery(function($){
				var lastkey = $(el_id).attr("rel");
				var lastkeyint = parseInt(lastkey) + 1;
				$(".tr_user_temp_userkey").each(function(){
					var ftr = $('<div>').append($(this).clone()).html(); 
					$(el_id).attr("rel",lastkeyint);
					var find = "userkey";
					var replace = lastkeyint;		
					ftr = ftr.replace(new RegExp(find, 'g'), replace);	
					$(ftr).insertBefore(".tr_add_user");
					$(".tr_user_"+lastkeyint).find(".fieldsdoor").click();
				});			
			});
		}
		function showhide_user(el_id,uid){
			jQuery(function($){
				if($(el_id).attr("rel") == 'open'){
					$(".tr_user_"+uid).hide();
					$(".tr_user_"+uid+"_main").show();
					$(el_id).attr("rel","closed");
					$(el_id).find(".hidestr").hide();	
					$(el_id).find(".showstr").show();
					$(el_id).css("color","blue");
				}
				else{
					$(".tr_user_"+uid).show();
					$(el_id).attr("rel","open");
					$(el_id).find(".hidestr").show();	
					$(el_id).find(".showstr").hide();
					$(el_id).css("color","red");
				}
			});
		}
		function showhide_general(el_id){
			jQuery(function($){
				if($(el_id).attr("rel") == 'open'){
					$(".tr_general").hide();
					$(".tr_general_main").show();
					$(el_id).attr("rel","closed");
					$(el_id).find(".hidestr").hide();	
					$(el_id).find(".showstr").show();	
					$(el_id).css("color","blue");
				}
				else{
					$(".tr_general").show();
					$(el_id).attr("rel","open");
					$(el_id).find(".hidestr").show();	
					$(el_id).find(".showstr").hide();
					$(el_id).css("color","red");					
				}
			});
		}	
		function remove_user(uid){
			if(!confirm("האם למחוק את המשתתף?")){
				return;
			}
			jQuery(function($){
				$(".tr_user_"+uid).each(function(){$(this).remove()});
			});
		}	
		function remove_user_field(uid,fid){
			if(!confirm("האם למחוק את השדה?")){
				return;
			}
			jQuery(function($){
				$(".tr_user_"+uid+"_fiealds_"+fid).each(function(){$(this).remove()});
			});
		}	
		function remove_general_field(fid){
			if(!confirm("האם למחוק את השדה?")){
				return;
			}
			jQuery(function($){
				$(".tr_general_"+fid).each(function(){$(this).remove()});
			});
		}		
	</script>
	<?php		
}

function contract_content_editor(){
	//error_reporting(E_ALL);
	//ini_set('display_errors', 1);

	if(isset($_REQUEST['edit_contract_content'])){
		$edit_contract_id = $_REQUEST['edit_contract_content'];
		$sql = "UPDATE contract_design SET content='".stripcslashes($_POST['content'])."' WHERE unk = '".UNK."' AND id='".$edit_contract_id."'";
		//echo "<pre>".$sql."</pre>";
		//return;
		$res = mysql_db_query(DB,$sql);
		header("Location: index.php?main=work_contracts&editor=content&contract_id=".$edit_contract_id."&unk=".UNK."&sesid=".SESID);
		return;
	}
	$contract_id = $_GET['contract_id'];
	$form_fields = contract_handler::create_fields_arr_from_contract($contract_id);
	$contract_data = contract_handler::get_contract_data($contract_id);
	
	$page_data = mysql_fetch_array(mysql_db_query(DB,"SELECT * FROM content_pages WHERE id ='28359'"));
	?>
	<h2>תוכן החוזה</h2>
	<table cellpadding='10'>
		<tr>
			<td style='vertical-align:top;'>
				<div style="background:yellow; float:right; color:black; width:210px;" id="contract_fields_wrap">
					<b style="display:block;padding:5px;">שדות להוספה</b>
					<div style="background:white; padding:5px; color:black;height:340px; overflow-y:auto;" id="contract_fields">
						
						<b style="display:block;padding:0px 10px;"><?php echo $form_fields['general']['title']; ?></b>
						<?php foreach($form_fields['general']['fields'] as $field_group): ?>
							<a class='contract_field_a' style="display:block;padding:3px 10px;" href="javascript://" onclick="contract_field_select(this)" rel="{{<?php echo $field_group['title']; ?>}}"><?php echo $field_group['title']; ?></a>
						<?php endforeach; ?>
						<?php foreach($form_fields['users_fields']['users'] as $user_group): ?>
							<b style="display:block;padding:0px 10px;"><?php echo $user_group['role_name']; ?></b>
							<?php foreach($user_group['fields'] as $user_field): ?>
								<a class='contract_field_a' style="display:block;padding:3px 10px;" href="javascript://" onclick="contract_field_select(this)" rel="{{<?php echo $user_field['title']; ?>(<?php echo $user_group['role_name']; ?>)}}"><?php echo $user_field['title']; ?></a>
							<?php endforeach; ?>	
							<a class='contract_field_a' style="display:block;padding:3px 10px;" href="javascript://" onclick="contract_field_select(this)" rel="{{חתימה(<?php echo $user_group['role_name']; ?>)}}">חתימה</a>
						<?php endforeach; ?>
						<a class='contract_field_a' style="display:block;padding:3px 10px;" href="javascript://" onclick="contract_field_select(this)" rel="{{נספח}}">הוסף נספח לחוזה</a>
					</div>
					<style type='text/css'>
						.contract_field_a:hover{background:#ddd;}
						.contract_field_a.selected{background:#9d9;}
					</style>
					<button type="button" onclick="add_field_to_contract();" style="margin:10px; padding:10px;">לחץ כאן להוספת הערך הנבחר</button>
				</div>
			</td>
			<td>
				<form action="" method="POST">
					<input type="hidden" name="edit_contract_content" value="<?php echo $contract_data['id']; ?>" />
					<div style="float:right;">
					
						<?php load_editor_text( "content" ,iconv("windows-1255","UTF-8",stripcslashes($contract_data['content']))); ?>
						<?php
							$save_button_style = "font-size:30px;font-weight:bold;display:block; height:87px;width:200px;border-radius:50px;margin:auto;margin-top:20px;background:#eae4e4;color:#8e7d7d;cursor:pointer;";
							echo "<input type='submit' value='שמירה' class='submit_style' style = '".$save_button_style."'>";
						?>
					</div>
				</form>
			</td>
		</tr>
	</table>
	
	
	
	<script type="text/javascript">
		var editor_instance = CKEDITOR.instances['content'];
		jQuery(function($){
			$(".contract_field_a").dblclick(function(){add_field_to_contract();});
					
		});
		function add_text_to_contract(txt){
			editor_instance.insertHtml(txt);
		}
		function contract_field_select(a_el){
			jQuery(function($){
				$(".contract_field_a").each(function(){$(this).removeClass("selected");});
				$(a_el).addClass("selected");
				
			});
		}
		function add_field_to_contract(){
			jQuery(function($){
				$(".contract_field_a").each(function(){
					if($(this).hasClass("selected")){
						add_text_to_contract($(this).attr("rel"));
					}
				});
				
				
			});			
		}
	</script>
	<?php

}
