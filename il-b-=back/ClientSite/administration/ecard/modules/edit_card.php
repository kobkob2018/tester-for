<?php
//to delete user with card : https://ilbiz.co.il/mycard/?main=module&c=reg_token&f=delete_unk&unk=<user-unk>
	function edit_card_form(){
		manage_user_e_card("settings");
	}

	function edit_card_logo(){
		manage_user_e_card("logo");
	}
	
	function edit_card_gallery(){
		return  manage_user_e_card_gallery();
	}
	
	function manage_user_e_card($tab_select){
		$e_card_params = array(
		"active",
		"card_identifier",
		"title_1",
		"title_2",
		"phone",
		"waze_point",
		"facebook_page",
		"address",
		"email",
		"user_info",
		"user_youtube",
		"user_website",
		"whatsapp",
		"twitter",
		"instagram",
		"gplus",
		"linkedin",
		"pinterest",
		"gallery_title",
		);
		$user_unk = UNK;
		$sql = "select * from user_e_card_settings where unk = '$user_unk'";
		$res = mysql_db_query(DB, $sql);
		$user_data = mysql_fetch_array($res);
		$user_row_id = false;
		$settings_edit_messege = array();
		$card_is_active = false;
		$allow_activate = false;
		$open_card_form_link = "https://10card.co.il/landing.php?ld=473";
		if($user_data['id'] != ""){
			$user_row_id = $user_data['id'];
			if($user_data['active'] == '1'){
				$card_is_active = true;
				$allow_activate = true;
			}
		}
		//allow activate without contract
		$allow_activate = true;		
		//if contract is required for activation(old versions..)
		if(!$allow_activate){
			$sys_user_sql = "SELECT * FROM users WHERE unk = '".UNK."'";
			$sys_user_res = mysql_db_query(DB,$sys_user_sql);
			$sys_user_data = mysql_fetch_array($sys_user_res);
			$sys_user_email = $sys_user_data['email'];
			$contrct_sql = "SELECT * FROM contract_design WHERE identifier = 'e_card_open_contract'";
			$contract_res = mysql_db_query(DB,$contrct_sql);
			$contract_data = mysql_fetch_array($contract_res);
			$contract_design_id = $contract_data['id'];
			$contract_design_unk = $contract_data['unk'];
			$apply_sql = "SELECT * FROM contract_apply WHERE unk = '$contract_design_unk' AND fully_approved = '1' AND emails LIKE(\"%$sys_user_email%\")";
			$apply_res = mysql_db_query(DB,$apply_sql);
			$apply_data = mysql_fetch_array($apply_res);
			if($apply_data['id']!=""){
				$allow_activate = true;
			}
		}			
		//if(UNK != '503081597769396720'){
			//$allow_activate = true;
		//}		
		if(isset($_REQUEST['update_settings'])){
			$user_ip_sql = "";
			if (!empty($_SERVER['REMOTE_ADDR'])) {
				$user_ip = $_SERVER['REMOTE_ADDR'];
				$user_ip_sql = ",ip='$user_ip'";
			}			
			if(!$user_row_id){
				if($_REQUEST['active'] == '1'){
					$sql = "INSERT INTO user_e_card_settings(unk,active) values('$user_unk','0')";
					$res = mysql_db_query(DB, $sql);
					$user_row_id = mysql_insert_id();
				}
			}

			$set_sql = " SET last_update=now() $user_ip_sql";
			$set_sql_i = 0;
			foreach($e_card_params as $param){
				
				if(isset($_REQUEST[$param])){

					$val = str_replace("'","''",$_REQUEST[$param]);					
					$val = trim($val);					
					$val = iconv("UTF-8","Windows-1255",$val);
					if($param == 'active'){
						if($val == '1'){
							if(!$allow_activate){
								$settings_edit_messege[] = "על מנת להפעיל את הכרטיס עליך לחתום על הסכם פתיחת כרטיס 10card";	
								$val = '0';
							}
						}		
					}					
					if($param == "card_identifier"){
						$val = str_replace(" ","-",$val);
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
				
				if($ext_str!="png" && $ext_str!="jpg" && $ext_str!="gif" && $ext_str!="jpeg"){
					$image_edit_messege[] = "התמונה שהעלית לא תקינה(ניתן להעלות קבצים עם הסיומות הבאות בלבד: gif,jpg,png)";
					$file_error = true;
				}
				
				else{
					$image_to_big = false;
					if($_FILES["user_image"]["size"] > 500000){
						$image_to_big = true;
						//$file_error = true;
					}
					$sql = "SELECT user_image FROM user_e_card_settings WHERE unk = '$user_unk'";
					$res = mysql_db_query(DB,$sql);
					$curent_image_data = mysql_fetch_array($res);
					$curent_image = $curent_image_data['user_image'];
					if($curent_image!=""){
						unlink($path.$curent_image);
					}

					$upload_image_name = "$user_unk.$ext_str";
					$up = move_uploaded_file($_FILES['user_image']['tmp_name'],$path.$upload_image_name);
					if($image_to_big){												
						require_once("../../global_func/global_functions.php");
						require_once("../../global_func/new_images_resize.php");
						$image_edit_messege[] = "הקטנו לך את התמונה שתתאים לגודל הכרטיס";
						resize($upload_image_name, $path, 360, 110);
					}
					if($up){
						$sql = "UPDATE user_e_card_settings SET user_image = '$upload_image_name' WHERE unk='$user_unk'";
						$res = mysql_db_query(DB,$sql);
					}
					$image_edit_messege[] = "התמונה נשמרה בהצלחה";
				}
			}				
		}
		if(isset($_REQUEST['rotate_user_image'])){
			$sql = "SELECT user_image FROM user_e_card_settings WHERE unk = '$user_unk'";
			$res = mysql_db_query(DB,$sql);
			$curent_image_data = mysql_fetch_array($res);
			$curent_image = $curent_image_data['user_image'];
			$path.$curent_image;
			image_rotation($path.$curent_image,$_REQUEST['rotate_user_image']);	
			$image_edit_messege[] = "סיבוב תמונה בוצע בהצלחה";
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
				if($ext_str!="png" && $ext_str!="jpg" && $ext_str!="gif" && $ext_str!="jpeg"){
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
		foreach($user_data as $key=>$val){
			$user_data[$key] = iconv("Windows-1255","UTF-8",$val);
			
		}
		
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
		$f_name = "edit_card_form";
		if($tab_select == "logo"){
			$f_name = "edit_card_logo";
		}
		$current_url = "/mycard/?main=module&c=edit_card&f=$f_name&content_type=iframe&sessid=".$_GET['sessid'];
		$browser_is_mobile =  preg_match("/(android|avantgo|blackberry|bolt|boost|cricket|docomo|fone|hiptop|mini|mobi|palm|phone|pie|tablet|up\.browser|up\.link|webos|wos)/i", $_SERVER["HTTP_USER_AGENT"]);
		$browser_is_mobile_css_class = "";
		if($browser_is_mobile){
			$browser_is_mobile_css_class = "on-mobile";
		}
		?>
		
		<div id="card_edit_wrap" class="card_edit_wrap <?php echo $browser_is_mobile_css_class; ?>">
			<div id="card_edit_all">
				<?php print_edit_card_menu($tab_select); ?>
				<h3>ניהול 10card שלי</h3>
				<?php if(!$allow_activate): ?>
					<div>
						<b style='color:red'>
							כרטיס זה אינו פעיל
						</b>
						<br/>
						על מנת להפעיל את הכרטיס יש למלא טופס פתיחת כרטיס 10Card.
						<br/>
						<a href='<?php echo $open_card_form_link; ?>'>לחצו כאן למלא טופס פתיחת כרטיס 10Card</a>
						<br/>
						<b style='color:red;font-size:18px;'>
							במידה וכבר מילאת אנא בדוק את תיבת המייל שלך, ושם לחץ על הלינק לאישור אמינות החוזה.
						</b>
						<br/><br/>
						<a href=''>לחצו כאן אם כבר אישרתם את אמינות החוזה.</a>
						<br/><br/>
					</div>	
				<?php endif; ?>					
				<a href = "javascript://" onclick="open_card_example_help();" class="closed" title="כרטיס דוגמה">
					<img src="ecard/style/image/qmark.png" border="0" alt="" style="width: 33px;">
					כרטיס דוגמה
				</a> | 
				<a target="_BLANK" href="https://10card.co.il/%D7%A2%D7%96%D7%A8%D7%94-%D7%9E%D7%93%D7%A8%D7%99%D7%9B%D7%99%D7%9D-%D7%95%D7%94%D7%95%D7%93%D7%A2%D7%95%D7%AA/" title="דף עזרה ומדריכים">דף עזרה ומדריכים</a>
				<div id="card_example_help_wrap" style="display:none; position:absolute; background:#ccc; border:1px solid blue; padding:20px;">
					<div style="position:relative;">
						<a style="position:absolute; display:block; left:0px; top:0px; font-size:17px; border:1px solid blue;" href = "javascript://" onclick="close_card_example_help();" class="closed" title="סגור">
						סגור
						</a>
					</div>
					<?php if($user_data['card_version'] == '2'): ?>
						<img src="ecard/style/image/example_card_2.png?v=1.2" border="0" alt="" style="">
					<?php else: ?>
						<img src="ecard/style/image/example_card_1.png?v=1.2" border="0" alt="" style="">
					<?php endif; ?>
				</div>
				<script type="text/javascript">
					function open_card_example_help(){
						jQuery("#card_example_help_wrap").show();
					}
					function close_card_example_help(){
						jQuery("#card_example_help_wrap").hide();
					}
				</script>
				<?php if($browser_is_mobile): ?>
				<style type="text/css">
					#user_e_card_settings_fields_table tr{display:block;}
					#user_e_card_settings_fields_table tr td{display:block;}
				</style>
				<?php endif; ?>
				<?php if($tab_select == "settings"): ?>
					<div id="card_settings">
					
						<div id="user_e_card_settings" style="padding-right:10px;">
							<h3>הגדרות כלליות</h3>
							<?php if($e_card_href && $allow_activate): ?>
								<br/>
								<b>הכרטיס שלי: </b>
									<a style="text-align:left; direction:ltr;" target="_blank" href="<?php echo $e_card_href; ?>"><?php echo $e_card_href; ?></a>
								<br/><br/>
							<?php endif; ?>
													
							<div id="settings_edit_messege">
								<b style="color:red;">
									<?php 
										foreach($settings_edit_messege as $messege){
											echo $messege."<br/>";
										} 
									?>
								</b>				
							</div>		
							<form action="<?php echo $current_url; ?>" method="post">
								<input type="hidden" name="update_settings" value="1" />
								<table style="margin:auto;" id="user_e_card_settings_fields_table">
									<tr>
										<?php if($allow_activate): ?>
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
									

										<?php endif; ?>
									</tr>
									<tr><td height="10px;" colspan = '2'></td></tr>
									<tr>
										<td>מזהה כרטיס</td>
										<td>
											<input type="text" name="card_identifier" value="<?php echo $user_data['card_identifier']; ?>" style="width:170px" />
											<a href = "javascript://" onclick="open_card_identifier_help();" class="closed" title="מה זה?">
												<img src="ecard/style/image/qmark.png" border="0" alt="" style="float:left;width: 33px;">
											</a>
											<div id="card_identifier_help_wrap" style="display:none; position:absolute; background:#ccc; border:1px solid blue; padding:20px;">
												<h4>מהו מזהה כרטיס?</h4>
												<p> 
													מזהה הכרטיס הוא כתובת העמוד שלך באינטרנט, לאחר הדומיין - 10card.co.il<br/><br/>
													<b>לדוגמה</b>, יצרתי כרטיס, ומספר הטלפון שלי הוא 050-08080808", 
													ארשום במזהה הכרטיס "050-08080808"</br>
													בהתאם למזהה, גלישה לכרטיס שלי תהייה בכתובת:<br/><br/>
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
											<textarea name="title_2"><?php echo $user_data['title_2']; ?></textarea>
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
											<input type="text" name="waze_point" value="<?php echo $user_data['waze_point']; ?>" style="width:170px" />
										
											<a href = "javascript://" onclick="open_waze_help();" class="closed" title="מה זה?">
												<img src="ecard/style/image/qmark.png" border="0" alt="" style="float:left;width: 33px;">
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
									
									<tr><td height="10px;" colspan = '2'></td></tr>
					
									<tr>
										<td>טוויטר</td>
										<td>
											<input type="text" name="twitter" value="<?php echo $user_data['twitter']; ?>" />
										</td>
									</tr>
									<tr>
										<td>פינטרסט</td>
										<td>
											<input type="text" name="pinterest" value="<?php echo $user_data['pinterest']; ?>" />
										</td>
									</tr>									
									<tr><td height="10px;" colspan = '2'></td></tr>
									<tr>
										<td>גוגל פלוס</td>
										<td>
											<input type="text" name="gplus" value="<?php echo $user_data['gplus']; ?>" />
										</td>
									</tr>
									<tr>
										<td>
											מספר טלפון ווטסאפ קידומת מדינה +
לדוגמא 9720522222222+
										</td>
										<td>
											<input type="text" name="whatsapp" value="<?php echo $user_data['whatsapp']; ?>" />
										</td>
									</tr>									
									<tr><td height="10px;" colspan = '2'></td></tr>
									<tr>
										<td>linkedin</td>
										<td>
											<input type="text" name="linkedin" value="<?php echo $user_data['linkedin']; ?>" />
										</td>
									</tr>
									<tr><td height="10px;" colspan = '2'></td></tr>
									<tr>
										<td>instagram</td>
										<td>
											<input type="text" name="instagram" value="<?php echo $user_data['instagram']; ?>" />
										</td>
									</tr>



									
									
									<tr><td height="10px;" colspan = '2'></td></tr>
									<tr>
										<td>תקציר</td>
										<td>
											<textarea style="height:120px;" name="user_info" ><?php echo $user_data['user_info']; ?></textarea>
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
											<input style="width:205px;" type="submit" value="שמור" />
										</td>
									</tr>						
								</table>				
							</form>
						</div>
					</div>
				<?php endif; ?>
				
				<?php if($user_data['active'] == '1' && $tab_select == "logo"): ?>
					<div id="card_image_edit_wrap">
						<div>
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
									<table class="user-image-table">
										<tr>
											<td>
												<form action="<?php echo $current_url; ?>" method="post">
													<input type="hidden" name="rotate_user_image" value="r" />
													<div  class="image-rotate-button image-rotate-button-right">
														<input type="submit" value="" title="סובב ימינה" />
													</div>
												</form>	
											</td>
											<td>
												<div>
												<img src="<?php echo $user_image_path; ?>?t=<?php echo time(); ?>" style="width:220px;" />
												</div>
											</td>
											<td>
												<form action="<?php echo $current_url; ?>" method="post">
													<input type="hidden" name="rotate_user_image" value="l" />
													<div class="image-rotate-button image-rotate-button-left">
														<input type="submit" value="" title="סובב ימינה" />
													</div>
												</form>
											</td>
										</tr>
									</table>
								<?php else: ?>						
									עוד לא נבחרה תמונה
								<?php endif; ?>
							</div>
							<form action="<?php echo $current_url; ?>" method="post" enctype="multipart/form-data">
								<input type="hidden" name="update_user_image" value="1" />
								<div style="margin-top:20px;">
									<input type="file" name="user_image" accept="image/*"/>
								</div>
								<div style="margin-top:20px;">
									<input type="submit" value="שמור" />
								</div>
							</form>		
						</div>		
					</div>
				<?php endif; ?>
			</div>

		</div>
		<?php

		
	}


	function manage_user_e_card_gallery(){
		$edit_messege = array();
		$update_id = false;
		$user_unk = UNK;
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
				$image_name = iconv("UTF-8","Windows-1255",$_REQUEST['image_name']);
				$custom_html = iconv("UTF-8","Windows-1255",$_REQUEST['custom_html']);
			

				$image_name = str_replace("'","''",$image_name);
				$custom_html = str_replace("'","''",$custom_html);
				
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
			if($ext_str!="png" && $ext_str!="jpg" && $ext_str!="gif" && $ext_str!="jpeg"){
				$edit_messege[] = "האייקון שהעלית לא תקין(ניתן להעלות קבצים עם הסיומות הבאות בלבד: gif,jpg,png)";
				$file_error = true;
			}
			elseif($_FILES["image_image"]["size"] > 3000000){
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
			$image_data['image_name'] = iconv("Windows-1255","UTF-8",$image_data['image_name']);
			$image_data['custom_html'] = iconv("Windows-1255","UTF-8",$image_data['custom_html']);
			$e_images[$image_data['id']] = $image_data;
		}
		
		$current_url = "/mycard/?main=module&c=edit_card&f=edit_card_gallery&content_type=iframe&sessid=".$_GET['sessid'];
		?>
		<div id="card_edit_wrap">
		<?php print_edit_card_menu("gallery"); ?>
		
			<h2>ניהול גלריית תמונות ל - 10CARD</h2>
			<div id="edit_messege">
				<b style="color:red;">
					<?php 
						foreach($edit_messege as $messege){
							echo $messege."<br/>";
						} 
					?>
				</b>
			</div>
			<div id="e_card_gallery_edit_wrap">
				<div class="e_card_gallery_image" onclick = "edit_gallery_image('new')">
					<div style="border:1px solid black; font-size:20px; padding: 12px; width:80%; margin:auto;"><b>הוסף תמונה חדשה</b></div>
				</div>
				<div class="e_card_gallery_image_editor" id="e_card_gallery_image_new_editor" style="display:none;">
				
						<div style="text-align:right;">
							<a style = "font-size:20px;" class="return-to-list" href="javascript://" onclick="return_to_gallery_list()"> <-חזרה לרשימה</a>
						</div>
						<br/><br/>
					<form action="<?php echo $current_url; ?>" method="post" enctype="multipart/form-data">
						<input type="hidden" name="insert_image" value="new_image" />
						
						מיקום: <input type="text" style="width:160px; font-size:15px;" name="image_order" value="<?php echo $e_image['image_order']; ?>" />
						<br/>
						כותרת: <input type="text" style="width:160px; font-size:15px;" name="image_name" value="<?php echo $e_image['image_name']; ?>" />
						<br/>
						<input type="hidden" name="custom_html"  value="<?php echo $e_image['custom_html']; ?>">
						
						<img src = "<?php echo $e_image['image_path']; ?>?t=<?php echo time(); ?>" style="max-width:95vw;" />
						<br/>
						
						<input type="file" name="image_image" />
						
						<br/>
						<input style="width:80%; font-size:15px;" type="submit" value="שמור" />
						</br><br/>
						<a class="return-to-list" href="javascript://" onclick="return_to_gallery_list()">חזרה לרשימה</a>
					</form>
				</div>
		
				<?php foreach($e_images as $e_key=>$e_image): ?>
					<div class="e_card_gallery_image" onclick = "edit_gallery_image('<?php echo $e_key; ?>')">
						<img src = "<?php echo $e_image['image_path']; ?>?t=<?php echo time(); ?>" style="max-width:80%; max-height:200px;" />
						<br/>
						<span class="e_card_gallery_image_name"> <?php echo $e_image['image_name']; ?></span>
					</div>
					<div class="e_card_gallery_image_editor" id="e_card_gallery_image_<?php echo $e_key; ?>_editor" style="display:none;">
						<div style="text-align:right;">
							<a style = "font-size:20px;" class="return-to-list" href="javascript://" onclick="return_to_gallery_list()"> <-חזרה לרשימה</a>
						</div>
						<br/><br/>
						<form action="<?php echo $current_url; ?>" method="post" enctype="multipart/form-data">
							<input type="hidden" name="update_image" value="<?php echo $e_image['id']; ?>" />
							
							מיקום: <input type="text" style="width:160px; font-size:15px;" name="image_order" value="<?php echo $e_image['image_order']; ?>" />
							<br/>
							כותרת: <input type="text" style="width:160px; font-size:15px;" name="image_name" value="<?php echo $e_image['image_name']; ?>" />
							<br/>
							<input type="hidden" name="custom_html"  value="<?php echo $e_image['custom_html']; ?>">
							
							<img src = "<?php echo $e_image['image_path']; ?>?t=<?php echo time(); ?>" style="max-width:80%;" />
							<br/>
							<br/>
							<input type="file" name="image_image" />
							
							<br/>
							<input style="width:80%; font-size:15px;" type="submit" value="שמור" />
							<br/>
							<br/><br/>
							<a style = "font-size:20px;" class="delete-gallery-image" href="<?php echo $current_url; ?>&delete_image=<?php echo $e_image['id']; ?>" onclick="return confirm('למחוק תמונה?')">מחק תמונה</a>
							</br>
							
						</form>
					</div>			
				<?php endforeach; ?>
			</div>
			</div>
			<script type="text/javascript">
				function return_to_gallery_list(){
					jQuery("#e_card_gallery_edit_wrap").find(".e_card_gallery_image").each(function(){
						jQuery(this).show();
					});	
					jQuery("#e_card_gallery_edit_wrap").find(".e_card_gallery_image_editor").each(function(){
						jQuery(this).hide();
					});						
				}
				
				function edit_gallery_image(editor_id){
					jQuery("#e_card_gallery_edit_wrap").find(".e_card_gallery_image").each(function(){
						jQuery(this).hide();
					});	
					jQuery("#e_card_gallery_image_"+editor_id+"_editor").show();									
				}
				
			</script>
		<?
		
	}
	
	function print_edit_card_menu($selected_tab){
		$selected_tabs = array("settings"=>"","logo"=>"","gallery"=>"");
		$selected_tabs[$selected_tab] = "selected";
	?>
	<table id="e_card_tabs">
		<tr>
			<td>
				<a class="e-card-tab <?php echo $selected_tabs['settings']; ?>" href="/mycard/?main=module&c=edit_card&f=edit_card_form&content_type=iframe&sessid=<?php echo $_GET['sessid']; ?>">הגדרות ראשי</a>
			</td>
			
			<td>
				<a class="e-card-tab <?php echo $selected_tabs['logo']; ?>" href="/mycard/?main=module&c=edit_card&f=edit_card_logo&content_type=iframe&sessid=<?php echo $_GET['sessid']; ?>">תמונה\לוגו</a>
			</td>
			<td>
				<a class="e-card-tab <?php echo $selected_tabs['gallery']; ?>" href="/mycard/?main=module&c=edit_card&f=edit_card_gallery&content_type=iframe&sessid=<?php echo $_GET['sessid']; ?>">גלריית תמונות</a>
			</td>
		</tr>
	</table>
	<?php
	}
	
	
	function image_rotation($filename,$direction){
		
        /* Check if the image is rotated,
         * and if it's rotates. Fix it!
         */
        // $filename = __DIR__ . '/'.$this->location .'/'. $this->name . '.' . $this->mime;

		switch ($direction){
			case 'l':
			 // Need to rotate 180 deg
				  $degrees = 90;
				  break ;

			case 'r':
			  // Need to rotate 90 deg clockwise
				  $degrees = -90;
				  break ;
		}

		if (preg_match("/jpg|jpeg/", pathinfo($filename, PATHINFO_EXTENSION))){
			$image_source = imagecreatefromjpeg($filename);
			$rotate = imagerotate($image_source, $degrees, 0);
			imagejpeg($rotate, $filename, 100);

		}
		if (preg_match("/png/", pathinfo($filename, PATHINFO_EXTENSION))){
		   $image_source = imagecreatefrompng($filename);
		   $rotate = imagerotate($image_source, $degrees, 0);
		   imagepng($rotate, $filename, 100);
		}
		if (preg_match("/gif/", pathinfo($filename, PATHINFO_EXTENSION))){
		   $image_source = imagecreatefromgif($filename);
		   $rotate = imagerotate($image_source, $degrees, 0);
		   imagepng($rotate, $filename, 100);
		}

		imagedestroy($image_source); //free up the memory
		imagedestroy($rotate);  //free up the memory       
	}
?>