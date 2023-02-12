<?php
	
	function manage_user_e_card(){
		$e_card_params = array("active","card_identifier","title_1","title_2","phone","waze_point","facebook_page","address","email","user_info","user_youtube","user_website","twitter","gplus","linkedin","instagram","pinterest","gallery_title",);
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
				//if($_REQUEST['active'] == '1'){
					$sql = "INSERT INTO user_e_card_settings(unk) values('$user_unk')";
					$res = mysql_db_query(DB, $sql);
					$user_row_id = mysql_insert_id();
				//}
			}
			
			$set_sql = " SET last_update=now()";
			$set_sql_i = 0;
			foreach($e_card_params as $param){
				
				if(isset($_REQUEST[$param])){
					$val = str_replace("'","''",$_REQUEST[$param]);					
					$val = trim($val);
					if($param == "card_identifier"){
						$val = str_replace(" ","-",$_REQUEST[$param]);
						$sql = "select id from user_e_card_settings where card_identifier = '$val' AND unk != '$user_unk'";
						$res = mysql_db_query(DB, $sql);
						if(mysql_num_rows($res)!=0){
							$settings_edit_messege[] = "מזהה הכרטיס שבחרת כבר תפוס...";	
							continue;
						}												
					}					
					//if($set_sql_i > 0){
						$set_sql .= ",";
					//}
					$set_sql .= "$param = '$val'";
				}
				$set_sql_i++;
			}
			$sql = "UPDATE user_e_card_settings $set_sql WHERE unk = '$user_unk'";
			$res = mysql_db_query(DB,$sql);
			$settings_edit_messege[] = "השינויים נשמרו בהצלחה";			
		}
		
		$path = "/home/ilan123/domains/10card.co.il/public_html/cards/user_image/";		
		$http_path = "http://10card.co.il/cards/user_image/";	
		$bg_path = "/home/ilan123/domains/10card.co.il/public_html/cards/bg_image/";		
		$bg_http_path = "http://10card.co.il/cards/bg_image/";		
		if(isset($_REQUEST['update_user_image'])){
			
			if($_FILES['user_image']['name'] != ""){
				$temp_file_name = $_FILES['user_image']['name'];
				$file_name_arr = explode(".",$temp_file_name);
				$ext_str = $file_name_arr[(count($file_name_arr) - 1)];
				$ext_str = strtolower($ext_str);
				if($ext_str!="png" && $ext_str!="jpg" && $ext_str!="gif"){
					$image_edit_messege[] = "התמונה שהעלית לא תקינה(ניתן להעלות קבצים עם הסיומות הבאות בלבד: gif,jpg,png)";
					$file_error = true;
				}
				elseif($_FILES["user_image"]["size"] > 500000){
					$image_edit_messege[] = "התמונה שהעלית גדולה מידיי";
					$file_error = true;
				}
				else{
					$sql = "SELECT user_image FROM user_e_card_settings WHERE unk = '$user_unk'";
					$res = mysql_db_query(DB,$sql);
					$curent_image_data = mysql_fetch_array($res);
					$curent_image = $curent_image_data['user_image'];
					if($curent_image!=""){
						unlink($path.$curent_image);
					}

					$upload_image_name = "$user_unk.$ext_str";
					$up = move_uploaded_file($_FILES['user_image']['tmp_name'],$path.$upload_image_name);
					if($up){
						$sql = "UPDATE user_e_card_settings SET user_image = '$upload_image_name' WHERE unk='$user_unk'";
						$res = mysql_db_query(DB,$sql);
					}
					$image_edit_messege[] = "התמונה נשמרה בהצלחה";
				}
			}				
		}
		
		if(isset($_REQUEST['update_bg_image'])){
			$sql = "select * from user_e_card_bg_settings where unk = '$user_unk'";
			$res = mysql_db_query(DB, $sql);
			$user_bg_data = mysql_fetch_array($res);
			$user_bg_row_id = false;
			if($user_bg_data['id'] != ""){
				$user_bg_data = $user_bg_data['id'];
			}
			
			if(isset($_REQUEST['update_bg_image'])){
				
				if(!$user_bg_data){
					$sql = "INSERT INTO user_e_card_bg_settings(unk) values('$user_unk')";
					$res = mysql_db_query(DB, $sql);
					$user_bg_data = mysql_insert_id();
				}
				
				$set_sql = " SET ";
				$set_sql_i = 0;
				$e_card_bg_params = array("bg_position","bg_attachment","bg_size","bg_repeat","bg_color");

				foreach($e_card_bg_params as $param){
					
					if(isset($_REQUEST[$param])){
						$val = str_replace("'","''",$_REQUEST[$param]);					
						$val = trim($val);			
						if($set_sql_i > 0){
							$set_sql .= ",";
						}
						$set_sql .= "$param = '$val'";
					}
					$set_sql_i++;
				}
				$sql = "UPDATE user_e_card_bg_settings $set_sql WHERE unk = '$user_unk'";
				$res = mysql_db_query(DB,$sql);
			}			
			if($_FILES['bg_image']['name'] != ""){
				$temp_file_name = $_FILES['bg_image']['name'];
				$file_name_arr = explode(".",$temp_file_name);
				$ext_str = $file_name_arr[(count($file_name_arr) - 1)];
				$ext_str = strtolower($ext_str);
				if($ext_str!="png" && $ext_str!="jpg" && $ext_str!="gif"){
					$bg_image_edit_messege[] = "התמונה שהעלית לא תקינה(ניתן להעלות קבצים עם הסיומות הבאות בלבד: gif,jpg,png)";
					$file_error = true;
				}
				elseif($_FILES["bg_image"]["size"] > 500000){
					$bg_image_edit_messege[] = "התמונה שהעלית גדולה מידיי";
					$file_error = true;
				}
				else{
					$sql = "SELECT bg_image FROM user_e_card_bg_settings WHERE unk = '$user_unk'";
					$res = mysql_db_query(DB,$sql);
					$curent_image_data = mysql_fetch_array($res);
					$curent_image = $curent_image_data['bg_image'];
					if($curent_image!=""){
						unlink($bg_path.$curent_image);
					}

					$upload_image_name = "$user_unk.$ext_str";
					$up = move_uploaded_file($_FILES['bg_image']['tmp_name'],$bg_path.$upload_image_name);
					if($up){
						$sql = "UPDATE user_e_card_bg_settings SET bg_image = '$upload_image_name' WHERE unk='$user_unk'";
						$res = mysql_db_query(DB,$sql);
					}
					$bg_image_edit_messege[] = "התמונה נשמרה בהצלחה";
				}
			}				
		}		
		$sql = "select * from user_e_card_settings where unk = '$user_unk'";
		$res = mysql_db_query(DB, $sql);
		$user_data = mysql_fetch_array($res);
		$user_image_path = false;
		if($user_data['user_image'] != ""){
			$user_image_path = $http_path.$user_data['user_image'];
		}

		$sql = "select * from user_e_card_bg_settings where unk = '$user_unk'";
		$res = mysql_db_query(DB, $sql);
		$user_bg_data = mysql_fetch_array($res);
		$user_bg_path = false;		
		$bg_image_path = false;
		if($user_bg_data['bg_image'] != ""){
			$bg_image_path = $bg_http_path.$user_bg_data['bg_image'];
		}
		$e_card_href = false;
		if($user_data['card_identifier'] != ""){
			$e_card_href = "http://10card.co.il/cards/".$user_data['card_identifier']."/";		
		}
		/*
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
				echo $sql;
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
		*/
		?>
		<h3>ניהול 10card ללקוח</h3>
		<table>
			<tr>
				<tr>
					<td colspan="2">
						<div>
							<b>היי!!! צריך עזרה בעריכת הכרטיס? </b><br/>כנס ל<a target="_blank" style="color:blue;" href="https://www.facebook.com/groups/10card/">עמוד שלנו בפייסבוק</a>, ושם תוכל לשאול שאלות ולמצוא תשובות לכל בעיה:
							<br/>
							<a target="_blank" style="color:blue;" href="https://www.facebook.com/groups/10card/">https://www.facebook.com/groups/10card/</a>
						</div>
					</td>
				</tr>
				<td>
					<div id="user_e_card_settings" style="float:right; margin-left:20px;">
						<h3>הגדרות כלליות</h3>
						
							<br/>
							<b>הכרטיס שלי: </b>
							<?php if($e_card_href): ?>
								<a target="_blank" href="<?php echo $e_card_href; ?>"><?php echo $e_card_href; ?></a>
							<?php else: ?>
								<b style="color:red">אין לך כרטיס עדיין..</b>
							<?php endif; ?>
							<br/><br/>
						
						
						<div id="settings_edit_messege">
							<b style="color:red;">
								<?php 
									foreach($settings_edit_messege as $messege){
										echo $messege."<br/>";
									} 
								?>
							</b>
						</div>			
						<form action="?main=manage_user_e_card&sesid=<?php echo SESID; ?>&unk=<?php echo $_GET['unk']; ?>" method="post">
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
								<tr><td height="10px;" colspan = '2'></td></tr>
								<tr>
									<td>מזהה כרטיס</td>
									<td>
										<input type="text" name="card_identifier" value="<?php echo $user_data['card_identifier']; ?>" style="width:140px" />
										<a href = "javascript://" onclick="open_card_identifier_help();" class="closed" title="מה זה?">
											<img src="images/icons/setup.png" width="20" border="0" alt="" style="float:left;">
										</a>
										<div id="card_identifier_help_wrap" style="display:none; position:absolute; background:#ccc; border:1px solid blue; padding:20px;">
											<h4>מהו מזהה כרטיס?</h4>
											<p>
												מזהה הכרטיס הוא כתובת העמוד שלך באינטרנט, לאחר הדומיין - 10card.co.il<br/><br/>
												<b>לדוגמה</b>, יצרתי כרטיס, ומספר הטלפון שלי הוא 050-08080808",
												ארשום במזהה הכרטיס "050-08080808"</br>
												בהתאם למזהה, גלישה לכרטיס שלו תהייה בכתובת:<br/><br/>
												<b style="color:blue; text-align:left;direction:ltr; text-decoration: underline;float: right;">
												http://10cars.co.il/cards/050-08080808/
												</b>
												<br/><br/><br/>
												<b style="color:red;">
													שים לב:
												</b>
												לשדה המזהה ניתן להשתמש רק באותיות, מספרים וקו אמצעי להפרדה בין מילים
											</p>
											<div>
												<a href = "javascript://" onclick="close_card_identifier_help();" class="closed" title="מה זה?">
												הבנתי
												</a>
											</div>
										</div>
										<script type="text/javascript">
											function open_card_identifier_help(){
												jQuery("#card_identifier_help_wrap").show();
											}
											function close_card_identifier_help(){
												jQuery("#card_identifier_help_wrap").hide();
											}
										</script>
									</td>
								</tr>
								<tr><td height="10px;" colspan = '2'></td></tr>
								<tr>
									<td>כותרת 1</td>
									<td>
										<input type="text" name="title_1" value="<?php echo $user_data['title_1']; ?>" />
									</td>
								</tr>
								<tr><td height="10px;" colspan = '2'></td></tr>
								<tr>
									<td>כותרת 2</td>
									<td>
										<input type="text" name="title_2" value="<?php echo $user_data['title_2']; ?>" />
									</td>
								</tr>
								<tr><td height="10px;" colspan = '2'></td></tr>								
								<tr>
									<td>מספר טלפון</td>
									<td>
										<input type="text" name="phone" value="<?php echo $user_data['phone']; ?>" />
									</td>
								</tr>
								<tr><td height="10px;" colspan = '2'></td></tr>
								<tr>
									<td>נקודת ציון ווייז</td>
									<td>
										<input type="text" name="waze_point" value="<?php echo $user_data['waze_point']; ?>" style="width:140px"/>
										<a href = "javascript://" onclick="open_waze_help();" class="closed" title="מה זה?">
											<img src="images/icons/setup.png" width="20" border="0" alt="" style="float:left;">
										</a>
										<div id="waze_help_wrap" style="display:none; position:absolute; background:#ccc; border:1px solid blue; padding:20px;">
											<h5>נקודת הציון מאפשרת פתיחת הוראות הכוונה ישירות בווייז</h5>
											<h4>קבלת קואורדינטות של מקום</h4>
											<ol>
											  <li>פתח את <a href="https://www.google.co.il/maps" target="_blank">מפות Google&rlm;</a>. אם אתה משתמש ב'מפות' ב<a href="/maps/answer/3031966">מצב Lite&rlm;</a>, סמל של ברק יופיע בתחתית המסך, ולא תוכל לקבל קואורדינטות של מקום.</li>
											  <li>לחץ לחיצה ימנית על מקום או אזור במפה.</li>
											  <li>בחר באפשרות <strong>מה יש כאן?</strong></li>
											  <li>בתחתית המסך, יופיע כרטיס עם הקואורדינטות.</li>
											</ol>
											<div>
												<a href = "javascript://" onclick="close_waze_help();" class="closed" title="מה זה?">
												הבנתי
												</a>
											</div>
										</div>
										<script type="text/javascript">
											function open_waze_help(){
												jQuery("#waze_help_wrap").show();
											}
											function close_waze_help(){
												jQuery("#waze_help_wrap").hide();
											}
										</script>									
									
									</td>
								</tr>
								<tr><td height="10px;" colspan = '2'></td></tr>
								<tr>
									<td>עמוד פייסבוק</td>
									<td>
										<input type="text" name="facebook_page" value="<?php echo $user_data['facebook_page']; ?>" />
									</td>
								</tr>
								<tr><td height="10px;" colspan = '2'></td></tr>
								<tr>
									<td>כתובת</td>
									<td>
										<input type="text" name="address" value="<?php echo $user_data['address']; ?>" />
									</td>
								</tr>
								<tr><td height="10px;" colspan = '2'></td></tr>
								<tr>
									<td>אימייל</td>
									<td>
										<input type="text" name="email" value="<?php echo $user_data['email']; ?>" />
									</td>
								</tr>	
								<tr><td height="10px;" colspan = '2'></td></tr>
								<tr>
									<td>עמוד יוטיוב</td>
									<td>
										<input type="text" name="user_youtube" value="<?php echo $user_data['user_youtube']; ?>" />
									</td>
								</tr>
								<tr><td height="10px;" colspan = '2'></td></tr>
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
									<td>pinterest</td>
									<td>
										<input type="text" name="pinterest" value="<?php echo $user_data['pinterest']; ?>" />
									</td>
								</tr>											
								<tr><td height="10px;" colspan = '2'></td></tr>
								<tr>
									<td>תקציר</td>
									<td>
										<input type="text" name="user_info" value="<?php echo $user_data['user_info']; ?>" />
									</td>
								</tr>
								<tr>
									<td>כותרת לגלריית תמונות</td>
									<td>
										<input type="text" name="gallery_title" value="<?php echo $user_data['gallery_title']; ?>" />
									</td>
								</tr>								
								<tr><td height="10px;" colspan = '2'></td></tr>								
								<tr>
									<td></td>
									<td>
										<input type="submit" value="שמור" />
									</td>
								</tr>						
							</table>				
						</form>
					</div>
				</td>
			
		
				<?php if($user_data['active'] == '1'): ?>
					<td>
						<div style="border:1px solid black; float:right; padding:20px;">
							<h3>תמונה/לוגו לכרטיס</h3>
							<div id="settings_edit_messege">
								<b style="color:red;">
									<?php 
										foreach($image_edit_messege as $messege){
											echo $messege."<br/>";
										} 
									?>
								</b>
							</div>
							<div style="margin-top:20px;">
								<?php if($user_image_path): ?>
									<img src="<?php echo $user_image_path; ?>?t=<?php echo time(); ?>" style="width:220px;" />
								<?php else: ?>						
									עוד לא נבחרה תמונה
								<?php endif; ?>
							</div>
							<form action="?main=manage_user_e_card&sesid=<?php echo SESID; ?>&unk=<?php echo $_GET['unk']; ?>" method="post" enctype="multipart/form-data">
								<input type="hidden" name="update_user_image" value="1" />
								<div style="margin-top:20px;">
									<input type="file" name="user_image" />
								</div>
								<div style="margin-top:20px;">
									<input type="submit" value="שמור" />
								</div>
							</form>		
						</div>		
						<div style="padding:10px 0px; clear:both;">
							<a href = "?main=manage_user_e_card_gallery&sesid=<?php echo SESID; ?>&unk=<?php echo $_GET['unk']; ?>">ניהול גלריית תמונות בכרטיס</a>
						</div>
					</td>
				<?php endif; ?>
			</tr>
			<?php if(false): //bg_image ?>
			<tr>
				<form action="?main=manage_user_e_card&sesid=<?php echo SESID; ?>&unk=<?php echo $_GET['unk']; ?>" method="post" enctype="multipart/form-data">
				<td>
					<div style="border:1px solid black; float:right; padding:20px;">
						<h3>תמונת רקע</h3>
						<div id="settings_edit_messege">
							<b style="color:red;">
								<?php 
									foreach($bg_image_edit_messege as $messege){
										echo $messege."<br/>";
									} 
								?>
							</b>
						</div>
						<div style="margin-top:20px;">
							<?php if($bg_image_path): ?>
								<img src="<?php echo $bg_image_path; ?>?t=<?php echo time(); ?>" style="width:220px;" />
							<?php else: ?>						
								עוד לא נבחרה תמונה
							<?php endif; ?>
						</div>
						
							<input type="hidden" name="update_bg_image" value="1" />
							<div style="margin-top:20px;">
								<input type="file" name="bg_image" />
							</div>

						

						<h3>מאפייניי תמונת רקע</h3>
						<label>bg_position</label><br/>
						<input type="text" name="bg_position" value="<?php echo $user_bg_data['bg_position']; ?>" />
						<br/>
						<label>bg_attachment</label><br/>
						<input type="text" name="bg_attachment" value="<?php echo $user_bg_data['bg_attachment']; ?>" />
						<br/>
						<label>bg_size</label><br/>
						<input type="text" name="bg_size" value="<?php echo $user_bg_data['bg_size']; ?>" />
						<br/>
						<label>waze_point</label><br/>
						<input type="text" name="waze_point" value="<?php echo $user_bg_data['waze_point']; ?>" />
						<br/>
						<label>bg_repeat</label><br/>
						<input type="text" name="bg_repeat" value="<?php echo $user_bg_data['bg_repeat']; ?>" />
						<br/>
						<label>bg_color</label><br/>
						<input type="text" name="bg_color" value="<?php echo $user_bg_data['bg_color']; ?>" />
						<br/>	
						<br/>
						<div style="margin-top:20px;">
							<input type="submit" value="שמור" />
						</div>
					</div>					
				</td>
				</form>
			</tr>
			<?php endif; ?>
		</table>
		<?php /*
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
					<form action="?main=manage_user_e_card&sesid=<?php echo SESID; ?>&unk=<?php echo $_GET['unk']; ?>" method="post" enctype="multipart/form-data">
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
						<form action="?main=manage_user_e_card&sesid=<?php echo SESID; ?>&unk=<?php echo $user_unk; ?>" method="post" enctype="multipart/form-data">
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
								<a href="?main=manage_user_e_card&sesid=<?php echo SESID; ?>&unk=<?php echo $user_unk; ?>&delete_icon=<?php echo $user_e_icon['id']; ?>">מחק אייקון</a>
							</td>						
						</form>
					</tr>			
				<?php endforeach; ?>
			</table>
		</div>
		*/ ?>
		<?

		
	}


	function manage_user_e_card_gallery(){
		$edit_messege = array();
		$update_id = false;
		$user_unk = $_GET['unk'];
		$path = "/home/ilan123/domains/10card.co.il/public_html/cards/gallery/$user_unk/";
		$http_path = "http://10card.co.il/cards/gallery/$user_unk/";
		if(isset($_REQUEST['delete_image'])){
			if($_REQUEST['delete_image'] != ""){
				$update_id = $_REQUEST['delete_image'];
				
				$sql = "SELECT image_image FROM user_e_card_gallery WHERE id = $update_id AND unk = '$user_unk'";
				$res = mysql_db_query(DB,$sql);
				$curent_image_data = mysql_fetch_array($res);
				$curent_image = $curent_image_data['image_image'];
				if($curent_image!=""){
					unlink($path.$curent_image);
				}
				$sql = "DELETE FROM user_e_card_gallery WHERE id = $update_id AND unk = '$user_unk'";
				$res = mysql_db_query(DB,$sql);
				$edit_messege[] = "התמונה נמחקה בהצלחה";
			}
		}
		if(isset($_REQUEST['update_image'])){
			if($_REQUEST['update_image'] != ""){
				$update_id = $_REQUEST['update_image'];
				$image_name = str_replace("'","''",$_REQUEST['image_name']);
				$custom_html = str_replace("'","''",$_REQUEST['custom_html']);
				$image_order = str_replace("'","''",$_REQUEST['image_order']);
				
				$sql = "UPDATE user_e_card_gallery SET image_name = '$image_name', custom_html = '$custom_html', image_order = '$image_order' WHERE id = $update_id AND unk = '$user_unk'";
				$res = mysql_db_query(DB,$sql);
				$edit_messege[] = "מאפייני התמונה נשמרו בהצלחה";
			}
		}
		
		if($_REQUEST['insert_image'] != ""){		
			if(isset($_REQUEST['insert_image'])){
				$update_id = $_REQUEST['update_image'];
				$image_name = str_replace("'","''",$_REQUEST['image_name']);
				$custom_html = str_replace("'","''",$_REQUEST['custom_html']);
				$image_order = str_replace("'","''",$_REQUEST['image_order']);
				
				$sql = "INSERT INTO user_e_card_gallery (unk,image_name,custom_html,image_order) values('$user_unk','$image_name','$custom_html','$image_order')";
				$res = mysql_db_query(DB,$sql);
				$update_id = mysql_insert_id();
				$edit_messege[] = "מאפייני התמונה נשמרו בהצלחה";
			}
		}
		if($_FILES['image_image']['name'] != "" && $update_id){
			$temp_file_name = $_FILES['image_image']['name'];
			$file_name_arr = explode(".",$temp_file_name);
			$ext_str = $file_name_arr[(count($file_name_arr) - 1)];
			$ext_str = strtolower($ext_str);
			if($ext_str!="png" && $ext_str!="jpg" && $ext_str!="gif"){
				$edit_messege[] = "האייקון שהעלית לא תקין(ניתן להעלות קבצים עם הסיומות הבאות בלבד: gif,jpg,png)";
				$file_error = true;
			}
			elseif($_FILES["image_image"]["size"] > 500000){
				$edit_messege[] = "התמונה שהעלית גדולה מידיי";
				$file_error = true;
			}
			else{
				$sql = "SELECT image_image FROM user_e_card_gallery WHERE id = $update_id AND unk = '$user_unk'";
				$res = mysql_db_query(DB,$sql);
				$curent_image_data = mysql_fetch_array($res);
				$curent_image = $curent_image_data['image_image'];
				if($curent_image!=""){
					unlink($path.$curent_image);
				}
				
				if(!is_dir($path)){
					mkdir($path, 0777);
				}
				$upload_image_name = "image_".$update_id.".".$ext_str;
				$up = move_uploaded_file($_FILES['image_image']['tmp_name'],$path.$upload_image_name);
				if($up){
					$sql = "UPDATE user_e_card_gallery SET image_image = '$upload_image_name' WHERE id = $update_id AND unk='$user_unk'";
					$res = mysql_db_query(DB,$sql);
				}
				$edit_messege[] = "התמונה נשמרה בהצלחה";
			}
		}		
	
		$sql = "SELECT * FROM user_e_card_gallery WHERE unk = '$user_unk' ORDER BY image_order";
		$res = mysql_db_query(DB,$sql);
		$e_images = array();
		$e_images_exist = false;

		while($image_data = mysql_fetch_array($res)){
			$e_images_exist = true;
			$image_data['image_path'] = $http_path.$image_data['image_image'];
			$e_images[$image_data['id']] = $image_data;
		}
		
		
		?>
		
			<h2>ניהול גלריית תמונות ל - 10CARD</h2>
			<div style="padding:10px 0px;">
				<a href = "?main=manage_user_e_card&sesid=<?php echo SESID; ?>&unk=<?php echo $_GET['unk']; ?>">חזור לניהול כרטיס</a>
			</div>
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
					<th></th>
					<th>מיקום</th>
					<th>שם התמונה</th>
					<th>תאור קצר</th>
					<th>תמונה</th>
					<th>העלאת תמונה</th>
					<th></th>
					<th></th>
				</tr>

				<tr>
					<form action="?main=manage_user_e_card_gallery&sesid=<?php echo SESID; ?>&unk=<?php echo $user_unk; ?>" method="post" enctype="multipart/form-data">
						<input type="hidden" name="insert_image" value="new_image" />
						<td>חדש</td>
						<td><input type="text" style="width:15px;" name="image_order" value="" /></td>
						<td><input type="text" style="width:100px;"  name="image_name" value="" /></td>
						<td><textarea name="custom_html" ></textarea></td>
						<td>
							
						</td>
						<td>
							<input type="file" name="image_image" />
						</td>
						<td>
							<input type="submit" value="שמור" />
						</td>
						<td>
							
						</td>						
					</form>
				</tr>
				
				<?php foreach($e_images as $e_key=>$e_image): ?>
					<tr>
						<form action="?main=manage_user_e_card_gallery&sesid=<?php echo SESID; ?>&unk=<?php echo $user_unk; ?>" method="post" enctype="multipart/form-data">
							<input type="hidden" name="update_image" value="<?php echo $e_image['id']; ?>" />
							<td></td>
							<td><input type="text" style="width:15px;" name="image_order" value="<?php echo $e_image['image_order']; ?>" /></td>
							<td><input type="text" style="width:100px;" name="image_name" value="<?php echo $e_image['image_name']; ?>" /></td>
							<td><textarea name="custom_html" ><?php echo $e_image['custom_html']; ?></textarea></td>
							<td>
								<img src = "<?php echo $e_image['image_path']; ?>?t=<?php echo time(); ?>" style="width:150px;" />
							</td>
							<td>
								<input type="file" name="image_image" />
							</td>
							<td>
								<input type="submit" value="שמור" />
							</td>
							<td>
								<a href="?main=manage_user_e_card_gallery&sesid=<?php echo SESID; ?>&unk=<?php echo $user_unk; ?>&delete_image=<?php echo $e_image['id']; ?>">מחק תמונה</a>
							</td>						
						</form>
					</tr>			
				<?php endforeach; ?>
			</table>
		<?
		
	}
	
?>