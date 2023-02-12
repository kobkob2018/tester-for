<?php
  class User extends Model{
    // we define 3 attributes
    // they are public so that we can access them using $post->author directly
	private static $instance = NULL;
    public $loged_in_user = false;
	
    public function __construct(){
		if(isset($_SESSION['aff_user'])){
			$db = Db::getInstance();
			$user_id = $_SESSION['aff_user'];
			$sql = "SELECT * FROM affiliates WHERE id = :uid";
			$req = $db->prepare($sql);
			$req->execute(array('uid'=>$user_id));
			$user_data = $req->fetch();
			$sql = "SELECT * FROM affiliates_kv WHERE aff_id = :uid";
			$req = $db->prepare($sql);
			$req->execute(array('uid'=>$user_id));
			foreach($req->fetchAll() as $user_kv) {
				$user_data[$user_kv['param_key']] = $user_kv['param_val'];
			}			
			$this->loged_in_user = $user_data; 
		}
    }
    public function resetUser(){
		$db = Db::getInstance();
		$user_id = $this->loged_in_user['id'];
		$sql = "SELECT * FROM affiliates WHERE id = :uid";
		$req = $db->prepare($sql);
		$req->execute(array('uid'=>$user_id));
		$user_data = $req->fetch();	
		$sql = "SELECT * FROM affiliates_kv WHERE aff_id = :uid";
		$req = $db->prepare($sql);
		$req->execute(array('uid'=>$user_id));
		foreach($req->fetchAll() as $user_kv) {
			$user_data[$user_kv['param_key']] = $user_kv['param_val'];
		}
		$this->loged_in_user = $user_data; 
		return $this->loged_in_user;
    }	
	private function log_in_user($email,$password){
		$db = Db::getInstance();
		$sql = "SELECT id FROM affiliates WHERE email = :email AND password = :password AND token=''";
		$req = $db->prepare($sql);
		$req->execute(array('email'=>$email,'password'=>wigt($password)));
		$user_data = $req->fetch();
		return $user_data;
	}
    public static function getInstance() {
      if (!isset(self::$instance)) {
		self::$instance = new User();
      }
      return self::$instance;
    }
    public static function getLogedInUser() {
		$user = self::getInstance();
		return $user->loged_in_user;
    }
	
	public static function logInUser($email,$password) {
		$user = self::getInstance();
		return $user->log_in_user($email,$password);
    }
	
	public static function registerUser($user_params,$data_user,$token){
		$new_user = array(
			'token'=>$token
		);
		$insert_params = "token";
		$insert_vals = "'$token'";
		foreach($user_params as $p_key){
			$insert_val = str_replace("'","''",trim($data_user[$p_key]));
			$insert_val = iconv( "UTF-8","windows-1255",$insert_val);
			$new_user[$p_key] = $insert_val;
			$insert_params .= ",";
			$insert_vals .= ",";	
			$insert_params .= "$p_key";
			$insert_vals .= "'$insert_val'";
			
		}
		
		$sql = "INSERT INTO affiliates ($insert_params) values($insert_vals)";
		$db = Db::getInstance();
		$req = $db->prepare($sql);
		$req->execute();
		return $new_user;
    }
	
	public static function getUserIdByToken($token){
		$db = Db::getInstance();
		$sql = "SELECT email FROM affiliates WHERE token = :token";
		$req = $db->prepare($sql);
		$req->execute(array('token'=>$token));
		$email_data = $req->fetch();
		if($email_data){
			$sql = "UPDATE affiliates SET token = '' WHERE email = :email";
			$req = $db->prepare($sql);
			$req->execute(array('email'=>$email_data['email']));
		}
		return $email_data;
	}
	public static function checkUserEmailExists($email){
		
		$db = Db::getInstance();
		$sql = "SELECT email,password,first_name,last_name FROM affiliates WHERE email = '$email'";
		$req = $db->query($sql);
		$user = $req->fetch();
		if(!isset($user['email'])){
			return false;
		}
		else{
			return $user;
		}
    }	
	public function updateUserDetails($user_params,$data_user){
		$update_params_arr = array();
		$update_prepere_arr = array('uid'=>$this->loged_in_user['id']);
		foreach($user_params as $p_key){
			$insert_val = str_replace("'","''",trim($data_user[$p_key]));
			$insert_val = iconv( "UTF-8","windows-1255",$insert_val);
			$new_user[$p_key] = $insert_val;
			$update_params_arr[] = "$p_key = :$p_key";
			$update_prepere_arr[$p_key] = $insert_val;
		}
		$update_params = implode(",",$update_params_arr);
		
		$sql = "update affiliates set $update_params WHERE id = :uid";		
		$db = Db::getInstance();
		$req = $db->prepare($sql);
		$req->execute($update_prepere_arr);
		return $new_user;
    }
  }
?>