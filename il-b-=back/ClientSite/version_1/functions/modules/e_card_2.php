<?php
	
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
			<div id="e_card_register_wrap">
				<form name="send_e_card_form" class="e-card-form" id="ecard_form" method="post" action="https://<?php echo $_SERVER['HTTP_HOST']; ?>/ajax.php?version=version_1&main=e_card_register">
					<div class="form-group">
						<label for="usr[full_name]" id="full_name_label"><?php echo e_card_con_text("שם מלא"); ?></label>
						<input type="text" name="usr[full_name]" id="full_name" class="form-input required" data-msg-required="*" value="<?php echo e_card_return_val("full_name"); ?>"  />
					</div>
					<div class="form-group">
						<label for="usr[name]" id="name_label"><?php echo e_card_con_text("שם העסק"); ?></label>
						<input type="text" name="usr[name]" id="name" class="form-input required" data-msg-required="*"  value="<?php echo e_card_return_val("name"); ?>" />
					</div>
					
					<?php echo e_card_city_select_html(); ?>
					<div class="form-group">
						<label for="usr[address]" id="address_label"><?php echo e_card_con_text("כתובת"); ?></label>
						<input type="text" name="usr[address]" id="address" class="form-input required"  value="<?php echo e_card_return_val("address"); ?>"   data-msg-required="*" />
					</div>
					<div class="form-group">
						<label for="usr[phone]" id="phone_label"><?php echo e_card_con_text("טלפון"); ?></label>
						<input type="text" name="usr[phone]" id="phone" class="form-input required"  value="<?php echo e_card_return_val("phone"); ?>"   data-msg-required="*" />
					</div>
					<div class="form-group">
						<label for="usr[email]" id="email_label"><?php echo e_card_con_text("אימייל"); ?></label>
						<input type="text" name="usr[email]" id="email" class="form-input required"  value="<?php echo e_card_return_val("email"); ?>"   data-msg-required="*" />
					</div>
					<div class="form-group">
						<label for="usr[fax]" id="fax_label"><?php echo e_card_con_text("פקס"); ?></label>
						<input type="text" name="usr[fax]" id="fax" class="form-input"  value="<?php echo e_card_return_val("fax"); ?>" />
					</div>
					<div class="form-group">
						<label for="usr[username]" id="username_label"><?php echo e_card_con_text("בחר שם משתמש"); ?></label>
						<input type="text" name="usr[username]" id="username" class="form-input required"  value="<?php echo e_card_return_val("username"); ?>"   data-msg-required="*" />
					</div>
					<div class="form-group">
						<label for="usr[password]" id="password_label"><?php echo e_card_con_text("בחר סיסמה"); ?></label>
						<input type="password" name="usr[password]" id="password" class="form-input required" data-msg-required="*" />
					</div>
					<div class="form-group">
						<label for="usr[password_auth]" id="password_auth_label"><?php echo e_card_con_text("וידוי סיסמה"); ?></label>
						<input type="password" name="usr[password_auth]" id="password_auth" class="form-input required" data-msg-required="*" />
					</div>	
					<div class="form-group">
						<input type="submit"  class="submit-btn"  value="<?php echo e_card_con_text("להרשמה"); ?>" />
					</div>							
				</form>
			</div>
			
		<?php	
		if(isset($_SESSION['e_card_return_params'])){
			//unset($_SESSION['e_card_return_params']);
		}
	}

	function e_card_return_val($param){
		if(isset($_SESSION['e_card_return_params'])){
			if(isset($_SESSION['e_card_return_params'][$param])){
				return $_SESSION['e_card_return_params'][$param];
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
		$sql = "SELECT * FROM e_card_user_pending WHERE user_token = '$e_card_register_token'";
		$res_user = mysql_db_query(DB,$sql);
		$data_user = mysql_fetch_array($res_user);
		$user_params = array(
			'full_name',
			'name',
			'city',
			'address',
			'phone',
			'email',
			'fax',
			'username',
			'password',
		);
		$temp_unk = create_unk();
		$insert_params = "unk,status,insert_date";
		$insert_vals = "'$temp_unk','8',now()";
		foreach($user_params as $p_key){			
			$insert_params .= ",";
			$insert_vals .= ",";
			$insert_val = $data_user[$p_key];
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
		header("location: https://ilbiz.co.il/ClientSite/administration/login.php");
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
		echo $_SERVER['HTTP_REFERER'];
		$error_msg = array();
		$email = $_REQUEST['usr']['email'];
		$username = $_REQUEST['usr']['username'];
		$sql = "SELECT username FROM users WHERE username = '$username'";
		$res_username = mysql_db_query(DB,$sql);
		$data_username = mysql_fetch_array($res_username);
		if($data_username['username'] != ""){
			$error_msg[] = "שם המשתמש שבחרת תפוס";
		}

		$sql = "SELECT email FROM users WHERE email = '$email'";
		$res_email = mysql_db_query(DB,$sql);
		$data_email = mysql_fetch_array($res_email);
		if($data_email['email'] != ""){
			$error_msg[] = "כתובת המייל שבחרת תפוסה";
		}
		$required_params = array(
			'full_name'=>'שם מלא',
			'name'=>'שם עסק',
			'city'=>'עיר',
			'address'=>'כתובת',
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
		}
		if(!empty($missing_params)){
			$error_missing = "נא למלא את הפרטים החסרים: ".implode(",",$missing_params);
			$error_msg[] = $error_missing;
		}		
		if(!empty($error_msg)){
			$_SESSION['e_card_register_messege'] = e_card_con_text(implode("<br/>",$error_msg));
			$_SESSION['e_card_return_params'] = $_REQUEST['usr'];
		}	
		else{
			$user_params = array(
				'full_name',
				'name',
				'city',
				'address',
				'phone',
				'email',
				'fax',
				'username',
				'password',
			);
			$token = "UT_".md5(time());
			$new_user = array(
				'token'=>$token
			);
			$insert_params = "token";
			$insert_vals = "'$token'";
			$update_params = "token = '$token'";
			$data_user = $_REQUEST['usr'];
			foreach($user_params as $p_key){
				$insert_val = $data_user[$p_key];
				$new_user[$p_key] = $insert_val;
				$insert_params .= ",";
				$insert_vals .= ",";
				$update_params .= ",";			
				$insert_params .= "$p_key";
				$insert_vals .= "'$insert_val'";
				$update_params .= "$p_key = '$insert_val'";
				
			}
			$sql = "INSERT INTO e_card_user_pending ($insert_params) values($insert_vals)
					ON DUPLICATE KEY UPDATE ($update_params)				
			";
			$_SESSION['new_e_card_user'] = $new_user;
		}
		
		header("location: ".$_SERVER['HTTP_REFERER']);
	}
	
	
	function e_card_email_auth_messege(){
		
		$new_user = $_SESSION['new_e_card_user'];
		unset($_SESSION['new_e_card_user']);
		print_r($new_user);
		$email = $new_user['email'];
		$token = $new_user['token'];
		echo e_card_con_text("
		מייל נשלח אליך לאישור...
		");
		//html email messege
		ob_start();
		?>
			שלום. הרשמתך ל10card בוצעה בהצלחה.
			לכניסה למערכת הניהול, ליצירת כרטיס לחץ על הלינק הבא:
			<br/>
			<a href="https://<?php echo $_SERVER['HTTP_HOST']; ?>/ajax.php?version=version_1&main=e_card_register&token=<?php echo $token; ?>">כניסה למערכת ניהול</a>
		<?php
		$content_send_to_Client = ob_get_clean();
		$fromEmail = "info@ilbiz.co.il"; 
		$fromTitle = "סיום הרשמה ל10CARD";
		$header = "סיום הרשמה ל10CARD";
		$ClientMail = $email;
		echo $content_send_to_Client;
		echo "---111---";
		require_once('/home/ilan123/domains/ilbiz.co.il/public_html/global_func/global_functions.php');
		echo "---22---";
		GlobalFunctions::send_emails_with_phpmailer($fromEmail, $fromTitle, $header, $content_send_to_Client, $content_send_to_Client, $ClientMail, $fromTitle );
		echo "---33---";
	}

	
	function e_card_city_select_html(){
	ob_start();
	$sql = "SELECT id, name FROM newCities WHERE father=0 ORDER BY place, name";
	$resAll3 = mysql_db_query(DB,$sql);					
	?>
	<div class="form-group">
		<label for="usr[city]" id="usr_city_label">עיר</label>
		<select name='usr[city]' id='city' class="form-group form-select required" data-msg-required="*" >
			<option value=''><?php echo e_card_con_text("בחר לעיר"); ?></option>
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
		return iconv( "UTF-8" ,"windows-1255", $str);
	}
?>