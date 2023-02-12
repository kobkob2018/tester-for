<?php
	
	function manage_e_card_icons(){
		$edit_messege = array();
		$update_id = false;
		$icon_new_name = false;
		if(isset($_REQUEST['delete_icon'])){
			if($_REQUEST['delete_icon'] != ""){
				$update_id = $_REQUEST['delete_icon'];
				$path = "/home/ilan123/domains/10card.co.il/public_html/cards/style/icons/";
				$sql = "SELECT icon_image FROM e_card_icons WHERE id = $update_id";
				$res = mysql_db_query(DB,$sql);
				$curent_image_data = mysql_fetch_array($res);
				$curent_image = $curent_image_data['icon_image'];
				if($curent_image!=""){
					unlink($path.$curent_image);
				}
				$sql = "DELETE FROM e_card_icons WHERE id = $update_id";
				$res = mysql_db_query(DB,$sql);
				$edit_messege[] = "האייקון נמחק בהצלחה";
			}
		}
		if(isset($_REQUEST['update_icon'])){
			if($_REQUEST['update_icon'] != ""){
				$update_id = $_REQUEST['update_icon'];
				$icon_name = str_replace("'","''",$_REQUEST['icon_name']);
				$custom_html = str_replace("'","''",$_REQUEST['custom_html']);
				$icon_dependency = str_replace("'","''",$_REQUEST['icon_dependency']);
				$icon_identifier = str_replace("'","''",$_REQUEST['icon_identifier']);
				$icon_order = str_replace("'","''",$_REQUEST['icon_order']);
				$bg_color = str_replace("'","''",$_REQUEST['bg_color']);
				
				$sql = "UPDATE e_card_icons SET icon_name = '$icon_name', custom_html = '$custom_html', icon_dependency = '$icon_dependency', icon_identifier = '$icon_identifier', icon_order = '$icon_order', bg_color = '$bg_color' WHERE id = $update_id";
				
				$res = mysql_db_query(DB,$sql);
				$edit_messege[] = "מאפייני האייקון נשמרו בהצלחה";
			}
		}
		
		if($_REQUEST['insert_icon'] != ""){		
			if(isset($_REQUEST['insert_icon'])){
				$update_id = $_REQUEST['update_icon'];
				$icon_name = str_replace("'","''",$_REQUEST['icon_name']);
				$custom_html = str_replace("'","''",$_REQUEST['custom_html']);
				$icon_dependency = str_replace("'","''",$_REQUEST['icon_dependency']);
				$icon_identifier = str_replace("'","''",$_REQUEST['icon_identifier']);
				$icon_order = str_replace("'","''",$_REQUEST['icon_order']);
				$bg_color = str_replace("'","''",$_REQUEST['bg_color']);
				$sql = "INSERT INTO e_card_icons (icon_name,custom_html,icon_dependency,icon_identifier,icon_order, bg_color) values('$icon_name','$custom_html','$icon_dependency','$icon_identifier','$icon_order','$bg_color')";
				$res = mysql_db_query(DB,$sql);
				$update_id = mysql_insert_id();
				$edit_messege[] = "מאפייני האייקון נשמרו בהצלחה";
			}
		}
		if($_FILES['icon_image']['name'] != "" && $update_id){
			$temp_file_name = $_FILES['icon_image']['name'];
			$file_name_arr = explode(".",$temp_file_name);
			$ext_str = $file_name_arr[(count($file_name_arr) - 1)];
			$ext_str = strtolower($ext_str);
			if($ext_str!="png" && $ext_str!="jpg" && $ext_str!="gif"){
				$edit_messege[] = "האייקון שהעלית לא תקין(ניתן להעלות קבצים עם הסיומות הבאות בלבד: gif,jpg,png)";
				$file_error = true;
			}
			elseif($_FILES["icon_image"]["size"] > 50000){
				$edit_messege[] = "התמונה שהעלית גדולה מידיי";
				$file_error = true;
			}
			else{
				$path = "/home/ilan123/domains/10card.co.il/public_html/cards/style/icons/";
				$sql = "SELECT icon_image FROM e_card_icons WHERE id = $update_id";
				$res = mysql_db_query(DB,$sql);
				$curent_image_data = mysql_fetch_array($res);
				$curent_image = $curent_image_data['icon_image'];
				if($curent_image!=""){
					unlink($path.$curent_image);
				}
				
				
				$upload_icon_name = "icon_".$update_id.".".$ext_str;
				$up = move_uploaded_file($_FILES['icon_image']['tmp_name'],$path.$upload_icon_name);
				if($up){
					$sql = "UPDATE e_card_icons SET icon_image = '$upload_icon_name' WHERE id = $update_id";
					$res = mysql_db_query(DB,$sql);
				}
				$edit_messege[] = "האייקון נשמר בהצלחה";
			}
		}		
	
		$sql = "SELECT * FROM e_card_icons";
		$res = mysql_db_query(DB,$sql);
		$e_icons = array();
		$e_icons_exist = false;
		$selected_dependency_arr_global = array(
			"none"=>array("desc"=>"לא תלוי","selected"=>""),
			"galery"=>array("desc"=>"גלריית תמונות","selected"=>""),
			"phone"=>array("desc"=>"מספר טלפון","selected"=>""),
			"waze_point"=>array("desc"=>"נקודת ציון ווייז","selected"=>""),
			"facebook_page"=>array("desc"=>"כתובת פייסבוק","selected"=>""),
			"address"=>array("desc"=>"כתובת","selected"=>""),
			"email"=>array("desc"=>"אימייל","selected"=>""),
			"user_info"=>array("desc"=>"תקציר","selected"=>""),
			"user_youtube"=>array("desc"=>"כתובת יוטיוב","selected"=>""),
			"twitter"=>array("desc"=>"עמוד טוויטר","selected"=>""),
			"pinterest"=>array("desc"=>"עמוד פינטרסט","selected"=>""),
			"gplus"=>array("desc"=>"עמוד גוגל פלאס","selected"=>""),
			"linkedin"=>array("desc"=>"linkedin","selected"=>""),
			"instagram"=>array("desc"=>"אינסטגראם","selected"=>""),
			"whatsapp"=>array("desc"=>"whatsapp","selected"=>""),			
			"estimate_url"=>array("desc"=>"קישור לטופס לידים","selected"=>""),
			"no_estimate_url"=>array("desc"=>"רק אם אין טופס לידים ויש אימייל","selected"=>""),
			"inactive_icon"=>array("desc"=>"לא פעיל לעולם","selected"=>""),

		);	
		while($icon_data = mysql_fetch_array($res)){
			$e_icons_exist = true;
			$selected_dependency_arr = $selected_dependency_arr_global;
			$selected_dependency_arr[$icon_data['icon_dependency']]['selected'] = "selected";
			$icon_data['dependency_arr'] = $selected_dependency_arr;
			$e_icons[$icon_data['id']] = $icon_data;
		}
		
		
		?>
		
			<h2>ניהול אייקונים ל - 10CARD</h2>
			<div id="edit_messege">
				<b style="color:red;">
					<?php 
						foreach($edit_messege as $messege){
							echo $messege."<br/>";
						} 
					?>
				</b>
			</div>
			<table border="1" style="border-collapse: collapse;" cellpadding="10">				
				<tr>
					<th>מספר</th>
					<th>מיקום</th>
					<th>מזהה</th>
					<th>שם האייקון</th>
					<th>מבנה HTML</th>
					<th>הצגת האייקון תלוייה ב</th>
					<th>תמונה</th>
					<th>העלאת תמונה</th>
					<th></th>
					<th></th>
				</tr>

				<tr>
					<form action="?main=manage_e_card_icons&sesid=<?php echo SESID; ?>" method="post" enctype="multipart/form-data">
						<input type="hidden" name="insert_icon" value="new_icon" />
						<td>חדש</td>
						<td><input type="text" style="width:15px;" name="icon_order" value="" /></td>
						<td><input type="text" style="width:80px;" name="icon_identifier" value="" /></td>
						<td><input type="text" style="width:100px;"  name="icon_name" value="" /></td>
						<td><textarea name="custom_html" ></textarea></td>
						<td>
							<select name="icon_dependency">
								<?php foreach($selected_dependency_arr_global as $icon_dependency_key=>$icon_dependency): ?>
									<option value="<?php echo $icon_dependency_key; ?>" <?php echo $icon_dependency['selected']; ?>><?php echo $icon_dependency['desc']; ?></option>								
								<?php endforeach; ?>
							</select>
						</td>
						<td>
							
						</td>
						<td>
							<input type="file" name="icon_image" />
						</td>
						<td>
							<input type="submit" value="שמור" />
						</td>
						<td>
							
						</td>						
					</form>
				</tr>
				
				<?php foreach($e_icons as $e_key=>$e_icon): ?>
					<tr>
						<form action="?main=manage_e_card_icons&sesid=<?php echo SESID; ?>" method="post" enctype="multipart/form-data">
							<input type="hidden" name="update_icon" value="<?php echo $e_icon['id']; ?>" />
							<td><?php echo $e_icon['id']; ?></td>
							<td><input type="text" style="width:15px;" name="icon_order" value="<?php echo $e_icon['icon_order']; ?>" /></td>
							<td><input type="text" style="width:80px;" name="icon_identifier" value="<?php echo $e_icon['icon_identifier']; ?>" /></td>
							<td><input type="text" style="width:100px;" name="icon_name" value="<?php echo $e_icon['icon_name']; ?>" /></td>
							<td><textarea name="custom_html" ><?php echo $e_icon['custom_html']; ?></textarea></td>
							<td>
								<select name="icon_dependency">
									<?php foreach($e_icon['dependency_arr'] as $icon_dependency_key=>$icon_dependency): ?>
										<option value="<?php echo $icon_dependency_key; ?>" <?php echo $icon_dependency['selected']; ?>><?php echo $icon_dependency['desc']; ?></option>								
									<?php endforeach; ?>
								</select>
							</td>
							<td>
								<img src = "http://10card.co.il/cards/style/icons/<?php echo $e_icon['icon_image']; ?>" width='60' height='60' />
							</td>
							<td>
								<input type="file" name="icon_image" />
								<br/>
								<b>צבע רקע</b>
								<br/>
								<input type="text" name="bg_color" value="<?php echo $e_icon['bg_color']; ?>" />
							</td>
							
							<td>
								<input type="submit" value="שמור" />
							</td>
							<td>
								<a href="?main=manage_e_card_icons&sesid=<?php echo SESID; ?>&delete_icon=<?php echo $e_icon['id']; ?>">מחק אייקון</a>
							</td>						
						</form>
					</tr>			
				<?php endforeach; ?>
			</table>
		<?
		
	}
	
	
	function manage_user_e_card_icons(){
		$e_card_params = array("active","card_identifier","phone","waze_point","facebook_page","address","email","user_info","user_youtube","user_website","twitter","gplus","linkedin","estimate_url","instagram",);
		$user_unk = $_GET['unk'];
		$sql = "select * from user_e_card_settings where unk = '$user_unk'";
		$res = mysql_db_query(DB, $sql);
		$user_data = mysql_fetch_array($res);
		$user_row_id = false;
		$settings_edit_messege = array();
		if($user_data['id'] != ""){
			$user_row_id = $user_data['id'];
		}
		if(isset($_REQUEST['update_settings'])){
			
			if(!$user_row_id){
				if($_REQUEST['active'] == '1'){
					$sql = "INSERT INTO user_e_card_settings(unk) values('$user_unk')";
					$res = mysql_db_query(DB, $sql);
					$user_row_id = mysql_insert_id();
				}
			}
			
			$set_sql = " SET ";
			$set_sql_i = 0;
			foreach($e_card_params as $param){
				
				if(isset($_REQUEST[$param])){
					$val = str_replace("'","''",$_REQUEST[$param]);					
					$val = trim($val);
					if($param == "card_identifier"){
						$val = str_replace(" ","-",$_REQUEST[$param]);
					}					
					if($set_sql_i > 0){
						$set_sql .= ",";
					}
					$set_sql .= "$param = '$val'";
				}
				$set_sql_i++;
			}
			$sql = "UPDATE user_e_card_settings $set_sql WHERE unk = '$user_unk'";
			$res = mysql_db_query(DB,$sql);
			$settings_edit_messege[] = "השינויים נשמרו בהצלחה";
			$sql = "select * from user_e_card_settings where unk = '$user_unk'";
			$res = mysql_db_query(DB, $sql);
			$user_data = mysql_fetch_array($res);			
		}

		$icon_edit_messege = array();
		$update_id = false;
		if(isset($_REQUEST['delete_icon'])){
			if($_REQUEST['delete_icon'] != ""){
				$update_id = $_REQUEST['delete_icon'];
				$sql = "DELETE FROM user_e_card_icons WHERE id = $update_id AND unk = '$user_unk'";
				$res = mysql_db_query(DB,$sql);
				$icon_edit_messege[] = "האייקון נמחק בהצלחה";
			}
		}
		if(isset($_REQUEST['update_icon'])){
			if($_REQUEST['update_icon'] != ""){
				$update_id = $_REQUEST['update_icon'];
				$icon_type = str_replace("'","''",$_REQUEST['icon_type']);
				$icon_order = str_replace("'","''",$_REQUEST['icon_order']);
				$sql = "UPDATE user_e_card_icons SET icon_type = '$icon_type', icon_order = '$icon_order' WHERE id = $update_id AND unk = '$user_unk'";
				$res = mysql_db_query(DB,$sql);
				$icon_edit_messege[] = "מאפייני האייקון נשמרו בהצלחה";
			}
		}
		
		if($_REQUEST['insert_icon'] != ""){		
			if(isset($_REQUEST['insert_icon'])){
				$update_id = $_REQUEST['update_icon'];
				$icon_type = str_replace("'","''",$_REQUEST['icon_type']);
				$icon_order = str_replace("'","''",$_REQUEST['icon_order']);
				
				$sql = "INSERT INTO user_e_card_icons (unk, icon_type,icon_order) values('$user_unk','$icon_type','$icon_order')";
				
				
				$res = mysql_db_query(DB,$sql);
				$update_id = mysql_insert_id();
				$icon_edit_messege[] = "מאפייני האייקון נשמרו בהצלחה";
			}
		}

		$sql = "SELECT * FROM user_e_card_icons WHERE unk = '$user_unk' ORDER BY icon_order";
		$res = mysql_db_query(DB,$sql);
		$user_e_icons = array();
		while($user_icon_data = mysql_fetch_array($res)){
			$user_e_icons[$user_icon_data['id']] = $user_icon_data;
		}
		
		$sql = "SELECT * FROM e_card_icons";
		$res = mysql_db_query(DB,$sql);
		$e_icons = array();
		$e_icons_exist = false;
		while($icon_data = mysql_fetch_array($res)){
			$e_icons_exist = true;
			$e_icons[$icon_data['id']] = $icon_data;
		}		
		
		?>
		<h3>ניהול 10card ללקוח</h3>
		<div>
			<a href="?sesid=<?php echo SESID; ?>" class="maintext">חזרה לתפריט הראשי</a>
			<br/>
			<a href="?main=user_profile&unk=<?php echo $_REQUEST['unk']; ?>&record_id=<?php echo $_REQUEST['record_id']; ?>&sesid=<?php echo SESID; ?>" class="maintext">חזרה לעדכון לקוח</a>
		</div>
		<div id="user_e_card_settings" style="float:right; margin-left:200px;">
			<h3>הגדרות כלליות</h3>
			<div id="settings_edit_messege">
				<b style="color:red;">
					<?php 
						foreach($settings_edit_messege as $messege){
							echo $messege."<br/>";
						} 
					?>
				</b>
			</div>			
			<form action="?main=manage_user_e_card_icons&sesid=<?php echo SESID; ?>&unk=<?php echo $_GET['unk']; ?>" method="post" enctype="multipart/form-data">
				<input type="hidden" name="update_settings" value="1" />
				<table>
					<tr>
						<td>כרטיס פעיל</td>
						<td>
							<?php 
								$active_val_0 = 'selected';
								$active_val_1 = '';
								if($user_row_id){
									if($user_data['active'] == '1'){
										$active_val_0 = '';
										$active_val_1 = 'selected';
									}
								}
							?>
							<select name="active">
								<option value = "0" <?php echo $active_val_0; ?>>לא</option>
								<option value = "1" <?php echo $active_val_1; ?>>כן</option>
							</select>
						</td>
					</tr>
					<tr>
						<td>מזהה כרטיס</td>
						<td>
							<input type="text" name="card_identifier" value="<?php echo $user_data['card_identifier']; ?>" />
						</td>
					</tr>					
					<tr>
						<td>מספר טלפון</td>
						<td>
							<input type="text" name="phone" value="<?php echo $user_data['phone']; ?>" />
						</td>
					</tr>
					<tr>
						<td>נקודת ציון ווייז</td>
						<td>
							<input type="text" name="waze_point" value="<?php echo $user_data['waze_point']; ?>" />
						</td>
					</tr>
					<tr>
						<td>עמוד פייסבוק</td>
						<td>
							<input type="text" name="facebook_page" value="<?php echo $user_data['facebook_page']; ?>" />
						</td>
					</tr>
					<tr>
						<td>כתובת</td>
						<td>
							<input type="text" name="address" value="<?php echo $user_data['address']; ?>" />
						</td>
					</tr>
					<tr>
						<td>אימייל</td>
						<td>
							<input type="text" name="email" value="<?php echo $user_data['email']; ?>" />
						</td>
					</tr>	
					<tr>
						<td>עמוד יוטיוב</td>
						<td>
							<input type="text" name="user_youtube" value="<?php echo $user_data['user_youtube']; ?>" />
						</td>
					</tr>
					<tr>
						<td>אתר אנטרנט</td>
						<td>
							<input type="text" name="user_website" value="<?php echo $user_data['user_website']; ?>" />
						</td>
					</tr>
					
					
					<tr>
						<td>טוויטר</td>
						<td>
							<input type="text" name="twitter" value="<?php echo $user_data['twitter']; ?>" />
						</td>
					</tr>
					<tr>
						<td>גוגל פלוס</td>
						<td>
							<input type="text" name="gplus" value="<?php echo $user_data['gplus']; ?>" />
						</td>
					</tr>
					<tr>
						<td>linkedin</td>
						<td>
							<input type="text" name="linkedin" value="<?php echo $user_data['linkedin']; ?>" />
						</td>
					</tr>
					<tr>
						<td>instagram</td>
						<td>
							<input type="text" name="instagram" value="<?php echo $user_data['instagram']; ?>" />
						</td>
					</tr>
					<tr>
						<td>כתובת עמוד טופס לידים</td>
						<td>
							<input type="text" name="estimate_url" value="<?php echo $user_data['estimate_url']; ?>" />
							שים לב. כתובת זו תחליף את טופס ההודעות הרגיל. רק באפשרות ההנהלה לראות שדה זה.
						</td>
					</tr>
					<tr>
						<td>תקציר</td>
						<td>
							<input type="text" name="user_info" value="<?php echo $user_data['user_info']; ?>" />
						</td>
					</tr>					
					<tr>
						<td></td>
						<td>
							<input type="submit" value="שמור" />
						</td>
					</tr>						
				</table>				
			</form>
		</div>
		<div id="user_e_card_icons" style="float:right;">
			<h3>ניהול אייקונים</h3>
			
			
			
			
			
			<div id="icons_edit_messege">
				<b style="color:red;">
					<?php 
						foreach($icon_edit_messege as $messege){
							echo $messege."<br/>";
						} 
					?>
				</b>
			</div>
			<table border="1" style="border-collapse: collapse;" cellpadding="10">				
				<tr>
					<th></th>
					<th>מיקום</th>
					<th>סוג האייקון</th>
					<th></th>
					<th></th>
				</tr>

				<tr>
					<form action="?main=manage_user_e_card_icons&sesid=<?php echo SESID; ?>&unk=<?php echo $_GET['unk']; ?>" method="post" enctype="multipart/form-data">
						<input type="hidden" name="insert_icon" value="new_icon" />
						<td>חדש</td>
						<td><input type="text" style="width:50px;" name="icon_order" value="" /></td>
						<td>
							<select name="icon_type">
								<option value="">בחר סוג אייקון</option>
								<?php foreach($e_icons as $e_icon): ?>
									<option value="<?php echo $e_icon['id']; ?>"><?php echo $e_icon['icon_name']; ?></option>
								<?php endforeach; ?>
							</select>
						</td>							
						<td>
							<input type="submit" value="שמור" />
						</td>
						<td>
						</td>					
					</form>
				</tr>
				
				<?php foreach($user_e_icons as $user_e_key=>$user_e_icon): ?>
					<tr>
						<form action="?main=manage_user_e_card_icons&sesid=<?php echo SESID; ?>&unk=<?php echo $user_unk; ?>" method="post" enctype="multipart/form-data">
							<input type="hidden" name="update_icon" value="<?php echo $user_e_icon['id']; ?>" />
							<td></td>
							<td><input type="text" style="width:50px;" name="icon_order" value="<?php echo $user_e_icon['icon_order']; ?>" /></td>
							<td>
								<select name="icon_type">
									<option value="">בחר סוג אייקון</option>
									<?php foreach($e_icons as $e_icon): ?>
										<?php 
											$selected = ""; 
											if($e_icon['id'] == $user_e_icon['icon_type']){
												$selected = "selected"; 
											}
										?>
										<option value="<?php echo $e_icon['id']; ?>" <?php echo $selected; ?>><?php echo $e_icon['icon_name']; ?></option>
									<?php endforeach; ?>
								</select>
							</td>							
							<td>
								<input type="submit" value="שמור" />
							</td>
							<td>
								<a href="?main=manage_user_e_card_icons&sesid=<?php echo SESID; ?>&unk=<?php echo $user_unk; ?>&delete_icon=<?php echo $user_e_icon['id']; ?>">מחק אייקון</a>
							</td>						
						</form>
					</tr>			
				<?php endforeach; ?>
			</table>
		</div>
		<?

		
	}
	
	
	function user_e_card_list(){
		$card_updated = false;
		if(isset($_POST['update_e_card_version'])){
			$card_id = $_POST['update_e_card_version'];
			$current_version = $_POST['current_version'];
			$update_to_version = '2';
			if($current_version == '2'){
				$update_to_version = '1';
			}
			$contrct_sql = "update user_e_card_settings SET card_version = '".$update_to_version."' WHERE id = ".$card_id."";
			$contract_res = mysql_db_query(DB,$contrct_sql);
			$card_updated = true;
		}		
		if(isset($_GET['pending'])){
			return user_pending_e_card_list();
		}
		$contrct_sql = "SELECT * FROM contract_design WHERE identifier = 'e_card_open_contract'";
		$contract_res = mysql_db_query(DB,$contrct_sql);
		$contract_data = mysql_fetch_array($contract_res);
		$contract_design_id = $contract_data['id'];
		$contract_design_unk = $contract_data['unk'];		
		$sql = "SELECT * FROM user_e_card_settings ORDER BY id DESC"; 
		$res = mysql_db_query(DB,$sql);
		$users_cards = array();
		$users_count = array(
			'sum'=>0,			
			'active'=>0,
			'not_active'=>0,
			'approved'=>0,
			'not_approved'=>0,
			'active_and_approved'=>0,
			'active_not_approved'=>0,
			'approved_not_active'=>0,
			'not_active_not_approved'=>0,
		);
		while($card_data = mysql_fetch_array($res)){
			if($card_data['unk']== ""){
				continue;
			}
			$user_card = array();
			$user_card['card'] = $card_data;
			$user_sql = "SELECT * FROM users WHERE unk = '".$card_data['unk']."'";
			$user_res = mysql_db_query(DB,$user_sql);
			$user_data = mysql_fetch_array($user_res);
			$user_card['user'] = $user_data;
			$user_card['has_url'] = false;
			if($card_data['card_identifier'] !=""){
				$user_card['has_url'] = true;
				$user_card['url'] = "http://10card.co.il/cards/".$card_data['card_identifier']."/";
			}
			$user_card['active_str'] = "לא <br/>[כרטיס לא פעיל]";
			$card_active = false;
			if($card_data['active'] == '1'){
				$user_card['active_str'] = "כן <br/>[בעל כרטיס פעיל]";
				$card_active = true;
			}
			$sys_user_email = $user_data['email'];
			$apply_sql = "SELECT * FROM contract_apply WHERE contract_id = '$contract_design_id' AND emails LIKE(\"%$sys_user_email%\")";
			
			$apply_res = mysql_db_query(DB,$apply_sql);
			$contract_state = "אין הסכם";
			$contract_state_color = "#ffd9d9";
			$contract_approved = false;
			while($apply_data = mysql_fetch_array($apply_res)){	
				if($apply_data['id']!=""){
					$contract_state_color = "#f1f1ff";
					$contract_state = "בתהליך";
					if($apply_data['fully_approved']=="1"){
						$contract_state_color = "#91ff91";
						$contract_state = "אושר סופית";	
						$contract_approved = true;
					}	
				}				
			}
			$mismatch_color = $contract_state_color;
			if($card_active && !$contract_approved){
				$mismatch_color = "orange";
			}
			if($contract_approved && !$card_active){
				$mismatch_color = "yellow";
			}
			$users_count['sum']++;
			if($card_active){
				$users_count['active']++;
				if($contract_approved){
					$users_count['active_and_approved']++;
				}
				else{
					$users_count['active_not_approved']++;
				}
			}
			else{
				$users_count['not_active']++;
			}
			if($contract_approved){
				$users_count['approved']++;
				if(!$card_active){
					$users_count['approved_not_active']++;
				}
			}
			else{
				$users_count['not_approved']++;
			}
			if(!$contract_approved && !$card_active){
				$users_count['not_active_not_approved']++;
			}
			$user_card['contract_state'] = $contract_state;
			$user_card['contract_state_color'] = $contract_state_color;
			$user_card['mismatch_color'] = $mismatch_color;
			
			$user_card['last_update'] = $card_data['last_update'];
			$user_card['card_version'] = $card_data['card_version'];
			$users_cards[] = $user_card;
		}
		$sql_pending = "SELECT count(id) as pending_users_count FROM e_card_user_pending";
		$res_pending = mysql_db_query(DB,$sql_pending);
		$pending_users_data = mysql_fetch_array($res_pending);
		$pending_users_count = $pending_users_data['pending_users_count'];
		

		
	
		?>
		<?php if($card_updated): ?>
			<h3 style="color:red">הגרסה עודכנה בהצלחה</h3>
		<?php endif; ?>	
		<h3>רשימת לקוחות בעלי כרטיס 10CARD</h3>
		<div>
			<b style="color:blue;line-height:18px; fint-size:16px;">
				<a style="color:blue;line-height:18px; fint-size:16px;" href="?sesid=<?php echo SESID; ?>">חזרה לתפריט הראשי</a>&nbsp;
				<a style="color:blue;line-height:18px; fint-size:16px;" href="?main=user_e_card_list&pending=1&sesid=<?php echo SESID; ?>">עבור לרשימת לקוחות 10CARD בהמתנה (סה"כ <?php echo $pending_users_count; ?>)</a>
			</b>
		</div>

		<div>
			<table border="1" style="border-collapse: collapse;" cellpadding="10">	
				<tr>
					<th>סה"כ לקוחות</th>
					<th>פעילים</th>
					<th>לא פעילים</th>
					<th>עם חוזה</th>
					<th>בלי חוזה</th>
					<th>פעילים עם חוזה</th>
					<th>פעילים ללא חוזה</th>
					<th>לא פעילים עם חוזה</th>
					<th>לא פעילים וללא חוזה</th>
				</tr>
				<tr>
					<td><?php echo $users_count['sum']; ?></td>
					<td><?php echo $users_count['active']; ?></td>
					<td><?php echo $users_count['not_active']; ?></td>
					<td><?php echo $users_count['approved']; ?></td>
					<td><?php echo $users_count['not_approved']; ?></td>
					<td><?php echo $users_count['active_and_approved']; ?></td>
					<td><?php echo $users_count['active_not_approved']; ?></td>
					<td><?php echo $users_count['approved_not_active']; ?></td>
					<td><?php echo $users_count['not_active_not_approved']; ?></td>
				</tr>				
			</table>
		</div>		
		<div>
		
		
		
			<table border="1" style="border-collapse: collapse;" cellpadding="10">	
				<tr>
					<th>שם הלקוח</th>
					<th>כרטיס פעיל</th>
					<th>מצב הסכם</th>
					<th>עדכון אחרון</th>
					<th>תאריך מעבר מרשימת המתנה</th>
					<th>כרטיס</th>
					<th>גרסת כרטיס</th>
					<th>IP</th>
				</tr>
				<?php foreach($users_cards as $user_card): ?>
				<tr style="background:<?php echo $user_card['contract_state_color']; ?>;">
					<td><a target="_blank" href="?main=manage_user_e_card_icons&unk=<?php echo $user_card['user']['unk']; ?>&record_id=<?php echo $user_card['user']['id']; ?>&sesid=<?php echo SESID; ?>"><?php echo $user_card['user']['name']; ?></a></td>
					<td  style="background:<?php echo $user_card['mismatch_color']; ?>;"><?php echo $user_card['active_str']; ?></td>
					<td  style="background:<?php echo $user_card['mismatch_color']; ?>;"><?php echo $user_card['contract_state']; ?></td>
					<td  style="background:<?php echo $user_card['mismatch_color']; ?>;"><?php echo $user_card['last_update']; ?></td>
					<td  style="background:<?php echo $user_card['mismatch_color']; ?>;"><?php echo $user_card['user']['insert_date']; ?></td>
					<td>
						<?php if($user_card['has_url']): ?>
						<a target="_blank" href="<?php echo $user_card['url']; ?>" ><?php echo $user_card['url']; ?></a>
						<?php else: ?>
							כתובת כרטיס לא הוגדרה
						<?php endif; ?>
					</td>
					<td>

						<?php echo $user_card['card_version']; ?>
						<br/>
						<form action="" method="POST">
							<input type="hidden" name="update_e_card_version" value="<?php echo $user_card['card']['id']; ?>" />
							<input type="hidden" name="current_version" value="<?php echo $user_card['card_version']; ?>" />
							<input type="submit" value="החלף גרסה 1/2" />
						</form>
					</td>
					<td><?php echo $user_card['card']['ip']; ?></td>
				</tr>
				<?php endforeach; ?>
			</table>
		</div>
		<?php

	
	}
	function user_pending_e_card_list(){
		$sql = "SELECT * FROM e_card_user_pending ORDER BY id DESC";
		$res = mysql_db_query(DB,$sql);
		$pending_users = array();
		while($pending_user = mysql_fetch_array($res)){
			$pending_users[$pending_user['id']] = $pending_user;
		}
		
		
		?>
		<h3>רשימת לקוחות 10CARD בהמתנה</h3>
		<h5>לקוחות שלא אישרו סופית את כתובת המייל</h5>
		<div>
			<b style="color:blue;line-height:18px; fint-size:16px;">
				<a style="color:blue;line-height:18px; fint-size:16px;" href="?sesid=<?php echo SESID; ?>">חזרה לתפריט הראשי</a>&nbsp;
				<a style="color:blue;line-height:18px; fint-size:16px;" href="?main=user_e_card_list&sesid=<?php echo SESID; ?>">עבור לרשימת משתמשי10CARD פעילים</a>
			</b>
		</div>
		<div>
			<table border="1" style="border-collapse: collapse;" cellpadding="10">	
				<tr>
					<th>#</th>
					<th>שם הלקוח</th>
					<th>שם העסק</th>
					<th>אימייל</th>
					<th>זמן הרשמה</th>
					<th>טלפון</th>
				</tr>
				<?php foreach($pending_users as $pending_user): ?>
				<tr>
					<td><?php echo $pending_user['id']; ?></td>
					<td><?php echo $pending_user['full_name']; ?></td>
					<td><?php echo $pending_user['name']; ?></td>
					<td><?php echo $pending_user['email']; ?></td>
					<?php if($pending_user['register_time'] != ""): ?>
						<td><?php echo $pending_user['register_time']; ?></td>
					<?php else: ?>
						<td>לפני 2019-04-25 </td>
					<?php endif; ?>
					<td><?php echo $pending_user['phone']; ?></td>
				</tr>
				<?php endforeach; ?>
			</table>
		</div>
		<?php		
	}
?>