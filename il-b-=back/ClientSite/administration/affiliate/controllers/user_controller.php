<?php
//only for loged out user
   class UserController extends Controller{
	   
	public function updateSend(){
		$error_msg = array();
		$required_params = array(
			'first_name'=>'שם פרטי',
			'last_name'=>'שם משפחה',
			'phone'=>'מספר טלפון',
		);
		$missing_params = array();
		foreach($required_params as $key=>$name){
			if($_REQUEST['usr'][$key] == ""){
				$missing_params[] = $name;
			}
		}
		
		if(strlen(trim($_REQUEST['usr']['phone'])) < 9){
			$error_msg[] = "מספר הטלפון לא תקין";
		}
		if($_REQUEST['usr']['password'] != "" || $_REQUEST['usr']['password_auth'] != ""){
			if(strlen(trim($_REQUEST['usr']['password'])) < 6){
				$error_msg[] = "סיסמה חייבת להכיל לפחות 6 תוים";
			}
			elseif(trim($_REQUEST['usr']['password']) != trim($_REQUEST['usr']['password_auth'])){
				$error_msg[] = "הסיסמאות אינן תואמות";
			}
		}
		if(!empty($missing_params)){
			$error_missing = "נא למלא את הפרטים החסרים: ".implode(",",$missing_params);
			$error_msg[] = $error_missing;
		}		
		if(!empty($error_msg)){
			$this->form_messege = implode("<br/><br/>*",$error_msg);
			return;
		}	
		else{
			$user_params = array(
				'first_name',
				'last_name',
				'biz_name',
				'phone',
			);

			$data_user = $_REQUEST['usr'];			
			$this->userModel->updateUserDetails($user_params,$data_user);
			if($_REQUEST['usr']['password'] != ""){
				$this->userModel->updateUserDetails(array("password"),$data_user);
			}
			$this->user = $this->userModel->resetUser();
			$this->success_messeges[] = "הפרטים עודכנו בהצלחה";
		}
		
	
		//self::success
	}
    public function logout(){
		unset($_SESSION['aff_user']);
		$this->redirect_to("https://ilbiz.co.il/affiliate/");
    }
	public function details(){
		include('views/user/details.php');
	}
  }
?>