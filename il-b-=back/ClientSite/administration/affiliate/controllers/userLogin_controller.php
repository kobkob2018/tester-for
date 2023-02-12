<?php
//only for loged out user
   class UserLoginController extends Controller{  
	public function loginSend(){
		$log_in_user = User::logInUser($_REQUEST['user_email'],$_REQUEST['user_pass']);
		if($log_in_user){
			$_SESSION['aff_user'] = $log_in_user['id'];
			$go_to_page = "https://ilbiz.co.il/affiliate/";
			if(isset($_SESSION['last_requested_url'])){
				$go_to_page = $_SESSION['last_requested_url'];
			}
			$this->redirect_to($go_to_page);
			return;
		}
		else{
			$this->err_messeges[] = "שם המשתמש והסיסמה אינם תואמים"; 
		}		
	}

	public function forgotPasswordSend(){
		$data_user = User::checkUserEmailExists($_REQUEST['user_email']);
		if($data_user){
			$email = trim($data_user['email']);
			//html email messege
			ob_start();
				include('views/emailsSend/forgotPasswordEmail.php');
			$content_send_to_Client = ob_get_clean();
			$content_send_to_Client = iconv("UTF-8" , "windows-1255", $content_send_to_Client);
			$fromEmail = "info@ilbiz.co.il"; 
			$fromTitle = iconv("UTF-8" , "windows-1255", "סיסמתך במערכת שיתוף לידים של אילביז");
			$header = iconv("UTF-8" , "windows-1255", "סיסמתך במערכת שיתוף לידים של אילביז");
			$ClientMail = $email;	
			GlobalFunctions::send_emails_with_phpmailer($fromEmail, $fromTitle, $header, $content_send_to_Client, $content_send_to_Client, $ClientMail, $fromTitle );		
			$this->success_messeges[] = "סיסמתך נשלחה אל כתובת המייל"; 
		}
		else{
			$this->err_messeges[] = "כתובת האימייל לא נמצאה במערכת"; 
		}		
	}
	
	public function registerSend(){
		$error_msg = array();
		$email = trim($_REQUEST['usr']['email']);
		$this->form_return_params = $_REQUEST['usr'];
		$data_email = User::checkUserEmailExists($email);
		if($data_email){
			$error_msg[] = "כתובת המייל שבחרת תפוסה"
			."<br/><a href='https://ilbiz.co.il/mycard/' title='מערכת ניהול לידים' target='_blank'>לחץ כאן לכניסה</a> <br/>";
		}
		$required_params = array(
			'first_name'=>'שם פרטי',
			'last_name'=>'שם משפחה',
			'phone'=>'מספר טלפון',
			'email'=>'אימייל',
			'password'=>'סיסמה',
			'password_auth'=>'אימות סיסמה'
		);
		$missing_params = array();
		foreach($required_params as $key=>$name){
			if($_REQUEST['usr'][$key] == ""){
				$missing_params[] = $name;
			}
		}
		
		if(!GlobalFunctions::validate_email_address($email) ){
			$error_msg[] = "כתובת המייל אינה תקינה";
		}
		if(strlen(trim($_REQUEST['usr']['phone'])) < 9){
			$error_msg[] = "מספר הטלפון לא תקין";
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
		if(!empty($error_msg)){
			$this->form_messege = implode("<br/><br/>*",$error_msg);
			$this->form_return_params = $_REQUEST['usr'];
			return;
		}	
		else{
			$user_params = array(
				'first_name',
				'last_name',
				'biz_name',
				'phone',
				'email',
				'password',
			);
			$token = "UT_".md5(time());

			$data_user = $_REQUEST['usr'];
			
			$new_user = User::registerUser($user_params,$data_user,$token);
		}
		
		$email = trim($data_user['email']);
		//html email messege
		ob_start();
			include('views/emailsSend/registerEmail.php');
		$content_send_to_Client = ob_get_clean();
		$content_send_to_Client = iconv("UTF-8" , "windows-1255", $content_send_to_Client);
		$fromEmail = "info@ilbiz.co.il"; 
		$fromTitle = iconv("UTF-8" , "windows-1255", "סיום הרשמה למערכת שיתוף לידים");
		$header = iconv("UTF-8" , "windows-1255", "סיום הרשמה למערכת שיתוף לידים");
		$ClientMail = $email;
		GlobalFunctions::send_emails_with_phpmailer($fromEmail, $fromTitle, $header, $content_send_to_Client, $content_send_to_Client, $ClientMail, $fromTitle );		
		$_SESSION['registered_user'] = $email;
		header("location: ".$_SERVER['HTTP_REFERER']);
		exit();
	}
	
	public function tokenSend(){
		$token = $_GET['token'];
		$user_id = User::getUserIdByToken($token);
		if($user_id){
			$_SESSION['success_messege'] = "הרשמתך הסתיימה בהצלחה";
		}
		else{
			$_SESSION['err_messege'] = "כתובת המייל כבר אושרה"; 
		}
		$this->redirect_to('https://'.$_SERVER['HTTP_HOST'].'/affiliate/userLogin/login/');
		exit();
	}
    public function login(){
		include('views/user/login.php');
    }
    public function register(){
		$registered_user = false;
		if(isset($_SESSION['registered_user'])){
			$registered_user = $_SESSION['registered_user'];
			unset($_SESSION['registered_user']);
		}
		include('views/user/register.php');
    }
    public function forgotPassword(){
      include('views/user/forgotPassword.php');
    }
	
	
  }
?>