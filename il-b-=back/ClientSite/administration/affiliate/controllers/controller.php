<?php
  class Controller {
	public $use_models = array("user");
	public $add_models = array();
	public $user = false;
	public $userModel = null;
	public $err_messeges = array(); 
	public $success_messeges = array(); 
	public $session_err_messege = false; 
	public $session_success_messege = false; 
	public $form_return_params = array();
	public $form_messege = false;
    public function __construct() {
		foreach($this->use_models as $add_model){
			require_once('models/'.$add_model.'_model.php');
		}
		foreach($this->add_models as $add_model){
			require_once('models/'.$add_model.'_model.php');
		}
		$this->user = User::getLogedInUser();
		$this->userModel = User::getInstance();
    }
	public function print_layout($action){
		if(!$this->user && get_class($this) != 'UserLoginController'){			
			$this->redirect_to('https://'.$_SERVER['HTTP_HOST'].'/affiliate/userLogin/login/');
		}
		elseif($this->user && get_class($this) == 'UserLoginController'){			
			$this->redirect_to('https://'.$_SERVER['HTTP_HOST'].'/affiliate/');
		}
		else{
			if(isset($_SESSION['success_messege'])){
				$this->session_success_messege = $_SESSION['success_messege'];
				unset($_SESSION['success_messege']);
			}
			if(isset($_SESSION['err_messege'])){
				$this->session_err_messege = $_SESSION['err_messege'];
				unset($_SESSION['err_messege']);
			}			
			if(isset($_REQUEST['sendAction'])){
				$method_name = $_REQUEST['sendAction'];
				if(method_exists($this,$method_name)){
					$this->$method_name();
				}
			}
			include('views/layout.php');
		}
	}
	public function redirect_to($url){
		if(get_class($this) != 'UserLoginController'){
			$base_url = ( isset($_SERVER['HTTPS']) && $_SERVER['HTTPS']=='on' ? 'https' : 'http' ) . '://' .  $_SERVER['HTTP_HOST'];
			$current_url = $base_url . $_SERVER["REQUEST_URI"];
		}
		else{
			$current_url = "https://ilbiz.co.il/affiliate/";
		}
		$_SESSION['last_requested_url'] = $current_url;
		header('Location: '.$url);
	}
	
	function form_return_val($param){
		if(isset($this->form_return_params[$param])){ 
			return $this->form_return_params[$param];
		}
		
		return "";
	}
  }
?>