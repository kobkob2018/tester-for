<?php
	function autolog(){
		
		if(isset($_REQUEST['token'])){
			
			$e_card_register_token = $_REQUEST['token'];
			$sql = "SELECT username,password FROM e_card_user_pending WHERE token = '".$_REQUEST['token']."'";
			$res = mysql_db_query(DB,$sql);
			$pending_data = mysql_fetch_array($res);
			if($pending_data['username'] != "" && $pending_data['password'] != ""){
				$sql = "SELECT * FROM users WHERE username = '".$pending_data['username']."' AND password = '".$pending_data['password']."'";
				$res = mysql_db_query(DB,$sql);
				$user_data = mysql_fetch_array($res);
				if($user_data['unk'] != ""){
					$user_unk = $user_data['unk'];
					$delete_token_sql = "DELETE FROM e_card_user_pending WHERE token = '$e_card_register_token'";
					$delete_token_res = mysql_db_query(DB,$delete_token_sql); 
					
					$ss1  = time("H:m:s",1000000000);
					$ss1 = str_replace(":",3,$ss1); 
					$ss2 = $_SERVER[REMOTE_ADDR];
					$ss2 = str_replace(".",3,$ss2); 
					$sesid = "$ss2$ss1";
					
					$sql = "insert into login_trace(user,session_idd,ip) values('".$user_unk."','".$sesid."','".$_SERVER['REMOTE_ADDR']."')";
					$res = mysql_db_query(DB,$sql);
					$data_r = array(
						'unk'=>$user_unk,
						'sesid'=>$sesid
					);
					$_SESSION['login'] = $data_r;
					$sql = "select * from user_e_card_settings where unk = '$user_unk'";
					$res = mysql_db_query(DB, $sql);
					$card_data = mysql_fetch_array($res);
					if($card_data['id'] == ""){
						$user_data['phone'] = str_replace("'","",$user_data['phone']);
						$user_data['full_name'] = str_replace("'","",$user_data['full_name']);
						$user_data['name'] = str_replace("'","",$user_data['name']);
						$user_data['email'] = str_replace("'","",$user_data['email']);
						$sql = "INSERT INTO user_e_card_settings(unk,card_identifier,title_1,title_2,phone,email,active) 
																values('$user_unk','".$user_data['phone']."','".$user_data['full_name']."','".$user_data['name']."','".$user_data['phone']."','".$user_data['email']."','0')";
						$res = mysql_db_query(DB, $sql);
						$user_row_id = mysql_insert_id();
					}
				}
			}
			
		}
		header("location: https://ilbiz.co.il/mycard/");
		exit();
	}
	
	function delete_unk(){
		if(isset($_REQUEST['unk'])){
			//453921174967755082
			$e_card_unk = $_REQUEST['unk'];
			$delete_user_sql = "DELETE FROM users WHERE unk = '$e_card_unk'";
			$delete_user_res = mysql_db_query(DB,$delete_user_sql); 
			$delete_user_sql = "DELETE FROM user_e_card_forms WHERE unk = '$e_card_unk'";
			$delete_user_res = mysql_db_query(DB,$delete_user_sql); 	
			$delete_user_sql = "DELETE FROM user_e_card_gallery WHERE unk = '$e_card_unk'";
			$delete_user_res = mysql_db_query(DB,$delete_user_sql);
			$delete_user_sql = "DELETE FROM user_e_card_settings WHERE unk = '$e_card_unk'";
			$delete_user_res = mysql_db_query(DB,$delete_user_sql);		
			exit("user was deleted");
		}
	}
?>