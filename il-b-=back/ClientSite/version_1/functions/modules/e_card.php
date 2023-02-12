<?php
	require_once('/home/ilan123/domains/ilbiz.co.il/public_html/global_func/global_functions.php');	
	function e_card_register_form(){
		if(!isset($_SESSION['new_e_card_user'])){
			echo e_card_register_form_html();
		}
		else{
			echo e_card_email_auth_messege();
		}
	}
	
	function e_card_register_form_html(){
		
		$e_card_register_messege = false;
		if(isset($_SESSION['e_card_register_messege'])){
			$e_card_register_messege = $_SESSION['e_card_register_messege'];
			unset($_SESSION['e_card_register_messege']);
		}
		
		if($e_card_register_messege){
			?>
			<div style="color:red;">
				<b><?php echo $e_card_register_messege; ?></b>
			</div>
			<?php
		}
		
		?>
			<script src="https://www.google.com/recaptcha/api.js?hl=he" async defer></script>
			<script type="text/javascript">
				function e_card_register_form_html_after_submit(button_id){
					<?php if($e_card_register_messege || isset($_GET['make_a_card'])): ?>
						jQuery(document).ready(function(){jQuery("#"+button_id).click();});
					<?php else: ?>
						return;
					<?php endif; ?>
				}
			</script>
			<div id="e_card_register_wrap">
				<form name="send_e_card_form" class="e-card-form" id="ecard_form" method="post" action="https://<?php echo $_SERVER['HTTP_HOST']; ?>/ajax.php?version=version_1&main=e_card_register">
					<div class="form-group form-group2">
						<label for="usr[full_name]" id="full_name_label"><?php echo e_card_con_text("שם מלא"); ?></label>
						<input type="text" name="usr[full_name]" id="full_name" class="form-input required" data-msg-required="* יש להוסיף שם מלא" value="<?php echo e_card_return_val("full_name"); ?>"  />
					</div>
					<div class="form-group form-group2">
						<label for="usr[name]" id="name_label"><?php echo e_card_con_text("שם עסק או כינוי"); ?></label>
						<input type="text" name="usr[name]" id="name" class="form-input required" data-msg-required="* נא להוסיף שם עסק"  value="<?php echo e_card_return_val("name"); ?>" />
					</div>
					
					<?php echo e_card_city_select_html(); ?>
					<?php /*
					<div class="form-group form-group2">
						<label for="usr[address]" id="address_label"><?php echo e_card_con_text("כתובת"); ?></label>
						<input type="text" name="usr[address]" id="address" class="form-input required"  value="<?php echo e_card_return_val("address"); ?>"   data-msg-required="* נא להוסיף כתובת" />
					</div>					
					*/ ?>
					<div class="form-group form-group2">
						<label for="usr[phone]" id="phone_label"><?php echo e_card_con_text("טלפון"); ?></label>
						<input type="text" name="usr[phone]" id="phone" class="form-input required"  value="<?php echo e_card_return_val("phone"); ?>"   data-msg-required="* יש להוסיף מספר טלפון" />
					</div>
					<div class="form-group form-group2">
						<label for="usr[email]" id="email_label"><?php echo e_card_con_text("אימייל"); ?></label>
						<input type="text" name="usr[email]" id="email" class="form-input required"  value="<?php echo e_card_return_val("email"); ?>"   data-msg-required="* יש להוסיף כתובת אימייל תקינה" />
					</div>
					<?php /*
					<div class="form-group form-group2">
						<label for="usr[fax]" id="fax_label"><?php echo e_card_con_text("פקס"); ?></label>
						<input type="text" name="usr[fax]" id="fax" class="form-input"  value="<?php echo e_card_return_val("fax"); ?>" />
					</div>
					*/ ?>
					<div class="form-group form-group2">
						<label for="usr[username]" id="username_label"><?php echo e_card_con_text("בחר שם משתמש"); ?></label>
						<input type="text" name="usr[username]" id="username" class="form-input required"  value="<?php echo e_card_return_val("username"); ?>"   data-msg-required="* יש להוסיף שם משתמש" />
					</div>
					<div class="form-group form-group2">
						<label for="usr[password]" id="password_label"><?php echo e_card_con_text("בחר סיסמה"); ?></label>
						<input type="password" name="usr[password]" id="password" class="form-input required" data-msg-required="* נא לבחור סיסמה" />
					</div>
					<div class="form-group form-group2">
						<label for="usr[password_auth]" id="password_auth_label"><?php echo e_card_con_text("וידוי סיסמה"); ?></label>
						<input type="password" name="usr[password_auth]" id="password_auth" class="form-input required" data-msg-required="* רשום כאן את ססמתך שוב" />
					</div>	


					<div class="form-group" style="font-size: 14px; text-align: right;">
						
						<label for="agreement_check" id="agreement_check_label" style="float: right; height: 62px;"></label>
						<div  class="form-group2">
							<div style="float: right; text-align: right; margin-left: 6px;">
								<input type="checkbox" name="agreement_check" id="agreement_check" class="form-input required" data-msg-required="* יש להסכים לתנאים והגבלות" style="width: 20px; height: 20px; margin-top: 1px;"> 
							</div>
							קראתי ואני מסכים ל<a style="font-weight:bold; text-decoration:underline;" href="https://10card.co.il/תנאים-והגבלות/" target="_BLANK">תנאים וההגבלות</a> באתר 10card.co.il
						</div>					
					</div>
					<div class="form-group" style="font-size: 14px; text-align: right;">
						<div style="float:left;min-height:100px;">
							<div class="g-recaptcha" data-sitekey="6LeBiBAaAAAAABaiFk-C83nzdeOMgaOhVyjRCqrx" data-callback="recaptchaCallback"  data-expired-callback="recaptchaExpired"></div>
						</div>
					</div>
					<input type="hidden" id="recap_check" name="recap_check" value='0' />
					<div class="form-group">
						<label id="submit_label"></label>
						<input type="submit"  class="submit-btn"  value="<?php echo e_card_con_text("להרשמה"); ?>" />
					</div>							
				</form>
			</div>
			<script type="">
				jQuery(function($){
					validator = $("#ecard_form").validate({
						errorPlacement: function(error, element) {
						 error.prependTo( element.closest(".form-group"));
					   },				
					});
				});

				
				var recaptchaCallback = 
					 function() {
						jQuery(function($){
							$("#recap_check").val("1");
						});
					 };

				var recaptchaExpired = 
					 function() {
						jQuery(function($){
							$("#recap_check").val("0");
						});
					 };					 
			</script>

			<style type="text/css">
				#ecard_form label.error{
					color: red;
					font-size: 13px;
					width: 100%;
					text-align: left;
					display:block;
				}
			</style>
		<?php	
		if(isset($_SESSION['e_card_return_params'])){
			//unset($_SESSION['e_card_return_params']);
		}
	}

	function e_card_return_val($param){
		if(isset($_SESSION['e_card_return_params'])){
			if(isset($_SESSION['e_card_return_params'][$param])){
				$return_val = $_SESSION['e_card_return_params'][$param];
				unset($_SESSION['e_card_return_params'][$param]);
				$return_val = trim($return_val);
				return $return_val;
			}
		}
		return "";
	}
	function e_card_register_ajax_send(){
		if(isset($_REQUEST['token'])){
			e_card_register_token();
		}	
		else{
			e_card_register_DB();
		}
			
	}
	
	function e_card_register_token(){
		
		$e_card_register_token = $_REQUEST['token'];
		$sql = "SELECT * FROM e_card_user_pending WHERE token = '$e_card_register_token'";
		$res_user = mysql_db_query(DB,$sql);
		$data_user = mysql_fetch_array($res_user);
		if($data_user['token'] == ""){
			exit("הרשמה זו כבר אושרה");
		}
		$user_params = array(
			'full_name',
			'name',
			'city',
			//'address',
			'phone',
			'email',
			//'fax',
			'username',
			'password',
		);
		$temp_unk = create_unk();
		$insert_params = "unk,status,insert_date";
		$insert_vals = "'$temp_unk','8',now()";
		foreach($user_params as $p_key){			
			$insert_params .= ",";
			$insert_vals .= ",";
			$insert_val = str_replace("'","''",$data_user[$p_key]);
			$insert_params .= "$p_key";
			$insert_vals .= "'$insert_val'";
		}
		$sql = "INSERT INTO users ($insert_params) values($insert_vals)";
		$res_user = mysql_db_query(DB,$sql);

		
/*		
		$user_params = array(); // todo e_card table params
		$insert_params = "";
		$insert_vals = "";
		$insert_i = 0;
		foreach($user_params as $p_key=>$p_val){
			if($insert_i != 0){
				$insert_params .= ",";
				$insert_vals .= ",";
			}
			$insert_val = $data_user[$p_key];
			$insert_params .= "$p_key";
			$insert_vals .= "'$insert_val'";
			$insert_i++;
		}
		$sql = "INSERT INTO users ($insert_params) values($insert_vals)";
		$res_user mysql_db_query(DB,$sql);	
*/	
		header("location: https://ilbiz.co.il/mycard/?main=module&c=reg_token&f=autolog&token=$e_card_register_token");
		exit();
	}
	
	function create_unk($last_try_unk = ""){
		for( $i=1 ; $i<=18 ; $i++ ){
			$temp_unk .= rand(0, 9);
		}
		if($last_try_unk == $temp_unk){
			exit("-----");
		}
		$sql = "SELECT unk FROM users WHERE unk = '$temp_unk'";
		$res_unk = mysql_db_query(DB,$sql);
		$data_unk = mysql_fetch_array($res_unk);
		if($data_unk['unk'] == ""){
			return $temp_unk;
		}
		else{
			return create_unk($temp_unk);
		}
	}
	
	function e_card_register_DB(){
		
		$error_msg = array();
		$email = trim($_REQUEST['usr']['email']);
		$username = trim($_REQUEST['usr']['username']);
		$sql = "SELECT username FROM users WHERE username = '$username'";
		$res_username = mysql_db_query(DB,$sql);
		$data_username = mysql_fetch_array($res_username);
		if($data_username['username'] != ""){
			$error_msg[] = "שם המשתמש שבחרת תפוס";
		}

		$sql = "SELECT username FROM e_card_user_pending WHERE username = '$username'";
		$res_username = mysql_db_query(DB,$sql);
		$data_username = mysql_fetch_array($res_username);
		if($data_username['username'] != ""){
			$error_msg[] = "שם המשתמש שבחרת תפוס";
		}

		$sql = "SELECT email FROM users WHERE email = '$email'";
		$res_email = mysql_db_query(DB,$sql);
		$data_email = mysql_fetch_array($res_email);
		if($data_email['email'] != ""){
			$error_msg[] = "כתובת המייל שבחרת תפוסה"
			."<br/><a href='https://ilbiz.co.il/mycard/' title='מערכת ניהול כרטיס ביקור דיגיטלי' target='_blank'>לחץ כאן לניהול הכרטיס</a> <br/>";
		}
		$required_params = array(
			'full_name'=>'שם מלא',
			'name'=>'שם עסק',
			'city'=>'עיר',
			//'address'=>'כתובת',
			'phone'=>'מספר טלפון',
			'email'=>'אימייל',
			'username'=>'שם משתמש',
			'password'=>'סיסמה',
			'password_auth'=>'וידוי סיסמה'
		);
		$missing_params = array();
		foreach($required_params as $key=>$name){
			if($_REQUEST['usr'][$key] == ""){
				$missing_params[] = $name;
			}
			else{
				$trimmed_param = trim($_REQUEST['usr'][$key]);
				if($trimmed_param == ""){
					$missing_params[] = $name;
				}
			}
		}
		
		if(!GlobalFunctions::validate_email_address($email) ){
			$error_msg[] = "כתובת המייל אינה תקינה";
		}
		if(strlen(trim($_REQUEST['usr']['phone'])) < 9){
			$error_msg[] = "מספר הטלפון אינו תקין";
		}		
		if(strlen(trim($_REQUEST['usr']['password'])) < 6){
			$error_msg[] = "סיסמה חייבת להכיל לפחות 6 תוים";
		}
		elseif(trim($_REQUEST['usr']['password']) != trim($_REQUEST['usr']['password_auth'])){
			$error_msg[] = "הסיסמאות אינן תואמות";
		}
		if(!empty($missing_params)){
			$error_missing = "נא למלא את הפרטים החסרים: ".implode(",",$missing_params);
			$error_msg[] = $error_missing;
		}
		else{
			if(!isset($_POST['recap_check']) || $_POST['recap_check']!='1'){
				$error_missing = "אנא וודא\י שפרטיך נכונים";
				$error_msg[] = $error_missing;				
			}
		}
		$user_email_allready_listed = false;
		if(!empty($error_msg)){
			$_SESSION['e_card_register_messege'] = e_card_con_text(implode("<br/><br/>*",$error_msg));
			$_SESSION['e_card_return_params'] = $_REQUEST['usr'];
		}	
		else{
			$user_params = array(
				'full_name',
				'name',
				'city',
				//'address',
				'phone',
				'email',
				//'fax',
				'username',
				'password',
				'ip',
			);
			$token = "UT_".md5(time());
			$new_user = array(
				'token'=>$token
			);
			$new_user_utf8 = array(
				'token'=>$token
			);
			$insert_params = "token,register_time";
			$insert_vals = "'$token',NOW()";
			$update_params = "token = '$token'";
			$data_user = $_REQUEST['usr'];
			$user_ip = $_SERVER['REMOTE_ADDR'];
			$data_user['ip'] = $user_ip;
			foreach($user_params as $p_key){
				$insert_val = str_replace("'","''",trim($data_user[$p_key]));
				$new_user_utf8[$p_key] = $insert_val;
				$insert_val = e_card_con_text_rev($insert_val);
				$new_user[$p_key] = $insert_val;
				$insert_params .= ",";
				$insert_vals .= ",";
				$update_params .= ",";			
				$insert_params .= "$p_key";
				$insert_vals .= "'$insert_val'";
				$update_params .= "$p_key = '$insert_val'";
				
			}
			$email = trim($new_user['email']);
			$sql = "SELECT email FROM e_card_user_pending WHERE email = '$email'";
			$res_email = mysql_db_query(DB,$sql);
			$data_email = mysql_fetch_array($res_email);
			if($data_email['email'] != ""){
				$user_email_allready_listed = true;
				$sql = "UPDATE e_card_user_pending SET $update_params WHERE email = '$email'";
			}
			else{
				$sql = "INSERT INTO e_card_user_pending ($insert_params) values($insert_vals)";
			}
			$res = mysql_db_query(DB,$sql);	
			$_SESSION['new_e_card_user'] = $new_user;
		
		
			$email = trim($new_user['email']);
			$token = $new_user['token'];
			//html email messege
			ob_start();
			?>
			<div style="direction:rtl;">
				שלום 
				<?php echo $new_user_utf8['full_name'];?>
				.
				הרשמתך ל10card בוצעה בהצלחה. <br/>
				לאישור כתובת המייל וסיום ההרשמה, נא ללחוץ על הלינק הבא:
				<br/>
				<a href="https://<?php echo $_SERVER['HTTP_HOST']; ?>/ajax.php?version=version_1&main=e_card_register&token=<?php echo $token; ?>">לחץ כאן לאישור המייל וסיום ההרשמה</a>
				<br/><br/>
				לאחר סיום ההרשמה, תוכל לגשת אל 
				<a href="https://ilbiz.co.il/mycard/">מערכת הניהול ליצירת כרטיס הביקור</a>
				<br/>
			</div>
			<?php
			$content_send_to_Client = ob_get_clean();
			
			ob_start();
			?>
			<div style="direction:rtl;">
				שלום אילן. לקוח חדש נרשם, אלו הפרטים שלו
				<br/>
				
				<?php foreach($required_params as $key=>$name): ?>
					
					<?php if($key != "password" && $key != "password_auth"): ?>
						<br/>
						<?php echo $name;?>: 
						<?php echo $new_user_utf8[$key];?>
					<?php endif; ?> 
				<?php endforeach; ?>
				<br/>
					IP: 
					<?php echo $new_user_utf8['ip'];?>

				<br/>
				<br/>
					זמן הרשמה: 
					<?php echo date("d-m-Y h:i:s");?>

				<br/>			
				
				
				<?php if($user_email_allready_listed): ?>
				 משתמש עם כתובת מייל זו כבר ניסה להרשם בעבר..
				<br/>
				<?php endif; ?>
				בכבוד רב. אילן.
			</div>
			<?php
			$content_send_to_Admin = ob_get_clean();		
			
			
			$fromEmail = "info@10card.co.il"; 
			$fromTitle = "סיום הרשמה ל10CARD";
			$header = "סיום הרשמה ל10CARD";
			$ClientMail = $email;
			require_once('/home/ilan123/domains/ilbiz.co.il/public_html/global_func/class.phpmailer.php');
			GlobalFunctions::send_emails_with_phpmailer($fromEmail, $fromTitle, $header, $content_send_to_Client, $content_send_to_Client, $ClientMail, $fromTitle );		
			
			
			GlobalFunctions::send_emails_with_phpmailer($fromEmail, $fromTitle, $header, $content_send_to_Admin, $content_send_to_Admin, "ilan@il-biz.com", $fromTitle );		
			GlobalFunctions::send_emails_with_phpmailer($fromEmail, $fromTitle, $header, $content_send_to_Admin, $content_send_to_Admin, "yacov.avr@gmail.com", $fromTitle );	
		}
		header("location: ".$_SERVER['HTTP_REFERER']);
	
	}
	
	
	function e_card_email_auth_messege(){
		
		$new_user = $_SESSION['new_e_card_user'];
		unset($_SESSION['new_e_card_user']);
				echo e_card_con_text("<div style='padding:50px 10px;'>
				היידד!!! נרשמת בהצלחה לשירות 10Card.<br/>
				בדוק את תיבת האימייל שלך.<br/>
				שלחנו לך לינק לאישור כתובת המייל.<br/>
				לאחר שתבצע את האישור במייל ייפתח הכרטיס.
				</div>
		");
		?>
			<script type="text/javascript">
				function e_card_register_form_html_after_submit(button_id){
					<?php if($e_card_register_messege): ?>
						return;
					<?php else: ?>
						jQuery(document).ready(function(){jQuery("#"+button_id).click();});
					<?php endif; ?>
				}
			</script>		
		<?php
	}

	
	function e_card_city_select_html(){
	ob_start();
	$sql = "SELECT id, name FROM newCities WHERE father=0 ORDER BY place, name";
	$resAll3 = mysql_db_query(DB,$sql);					
	?>
	<div class="form-group">
		<label for="usr[city]" id="usr_city_label">עיר</label>
		<select name='usr[city]' id='city' class="form-group form-select required" data-msg-required="* נא לבחור עיר" >
			<option value=''><?php echo e_card_con_text("בחר עיר"); ?></option>
			<?php while( $data = mysql_fetch_array($resAll3) ): ?>
			
				<?php if( $data['id'] != "1" ): ?>
					<option value='<?php echo $data['id']; ?>'><b><?php echo stripslashes($data['name']); ?></b></option>
				<?php endif; ?>
				<?php 
					$sql = "SELECT id, name FROM newCities WHERE father=".$data['id']." ORDER BY place, name";
					$resAll4 = mysql_db_query(DB,$sql);
				?>
				<?php while( $data2 = mysql_fetch_array($resAll4) ): ?>
				
					<?php $selected = ( $data2['id'] == e_card_return_val('city') ) ? "selected" : ""; ?>
					<option value='<?php echo $data2['id']; ?>' <?php echo $selected; ?>><?php echo stripslashes($data2['name']); ?></option>
				<?php endwhile; ?>
				<option value=''  disabled>-----------------------</option>
			<?php endwhile; ?>
		</select>
	</div>
	<?php
	return ob_get_clean();
	}
	
	function e_card_con_text($str){
		return $str; //iconv("UTF-8" , "windows-1255", $str);
	}
	function e_card_con_text_rev($str){
		return iconv("windows-1255", "UTF-8" , $str);
	}
?>