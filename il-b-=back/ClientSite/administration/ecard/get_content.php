<?php

function get_content($main)	{

	
	switch($main)	{
		case "module": return init_module_func();
		## Genral 
		default : return null; break; 
		
	}
}

function get_info($main)	{
	switch($main)	{
		## Genral 
		/***	START	****/
		
		case "user_login" : return user_login(); break;
		case "user_logout" : return user_logout(); break;
		case "pay_for_lead" :	return pay_for_lead(); break;
		case "update_lead" :	return update_lead(); break;
		case "delete_lead" :	return delete_lead(); break;
		case "contact_mass_update" :	return contact_mass_update();	break;
		case "lead_list" :  return get_leads(); break;
		case "get_lead" :  return get_lead(); break;
		case "token_test" :  return token_test(); break;
		case "forgot_password" :  return forgot_password(); break;
		
		
		default : return null;
			
		
	}
}


function forgot_password(){
	$return_array = array('type'=>'forgot_password','success'=>'0');
	
	
	
	if(!isset($_POST['email'])){
		$return_array['err_str'] = 'invalid_email';
	}
	elseif($_POST['email'] == ""){
		$return_array['err_str'] = 'invalid_email';
	}
	else{
		$sql = "select username,password,name from users where 
		email = '".$_REQUEST['email']."' and 
		deleted = '0' and 
		active_manager = '0' and 
		status = '0'";
		
		$res = mysql_db_query(DB,$sql);
		$data = mysql_fetch_array($res);
		if(!isset($data['username']) || $data['username'] == ""){
			$return_array['err_str'] = 'invalid_email';
		}
		else{
			$return_array['success'] = '1';
			
			if(isset($_REQUEST['return_screen'])){
				$data_r['return_screen'] = $_REQUEST['return_screen'];
			}
			$fromEmail = "support@ilbiz.co.il"; 
			$fromTitle = "IL-BIZ"; 
			
			$data['name'] = iconv("Windows-1255","UTF-8",$data['name']);
			
			$content = "
			שלום, ".stripslashes($data['name']).",<br><br>
			בהמשך לבקשתך לשחזור סיסמה, להלן פרטיך:<br><br>
			שם משתמש: ".stripslashes($data['username'])."<br>
			סיסמה: ".stripslashes($data['password'])."<br>
			";
			
			$content .= "<br>
			בברכה,<br>
			איי אל ביז קידום עסקים באינטרנט<br>";
			
			$header= "שחזור סיסמה";
			$content = iconv("UTF-8","Windows-1255",$content);
			$header = iconv("UTF-8","Windows-1255",$header);		
			$content_send_to_Client = "
				<html dir=rtl>
				<head>
						<title></title>
						<style>
							.textt{font-family: arial; font-size:12px; color: #000000}
							.text_link{font-family: arial; font-size:12px; color: navy}
						</style>
				</head>
				
				<body>
					<p class='textt' dir=rtl align=right>".$content."</p>
				</body>
				</html>";
			
			$ClientMail = $_REQUEST['email'];
			GlobalFunctions::send_emails_with_phpmailer($fromEmail, $fromTitle, $header, $content_send_to_Client, $content_send_to_Client, $ClientMail, $fromTitle );
			global 	$word;	
			$return_array['messege'] = $word[LANG]['forgot_password_email_sent']; 		
		}		
	}
	return $return_array;
}

function user_login(){
		$return_array = array('type'=>'user_login','success'=>'0');
		
		
		
		if(!isset($_POST['user']) || !isset($_POST['user'])){
			$return_array['err_str'] = 'invalid_user_or_pass';
		}
		elseif($_POST['pass'] == "" && $_POST['pass'] == ""){
			$return_array['err_str'] = 'invalid_user_or_pass';
		}
		else{
			$user_name = str_replace("'","''",$_REQUEST['user']);
			$user_pass = str_replace("'","''",$_REQUEST['pass']);
			
			$_REQUEST['user'] = $user_name;
			$_REQUEST['pass'] = $user_pass;
			$_POST['user'] = $user_name;
			$_POST['pass'] = $user_pass;
			$sql = "select unk from users where 
			username = '".$user_name."' and 
			password = '".$user_pass."' and 
			deleted = '0' and 
			active_manager = '0'";
			
			//mail('yacov.avr@gmail.com','ilan params',$sql);
			
			$res = mysql_db_query(DB,$sql);
			$data = mysql_fetch_array($res);
			if(!isset($data['unk']) || $data['unk'] == ""){
				$return_array['err_str'] = 'invalid_user_or_pass';
			}
			else{
				$return_array['success'] = '1';
				$ss1  = time("H:m:s",1000000000);
				$ss1 = str_replace(":",3,$ss1); 
				$ss2 = $_SERVER[REMOTE_ADDR];
				$ss2 = str_replace(".",3,$ss2); 
				$sesid = "$ss2$ss1";
				
				$sql = "insert into login_trace(user,session_idd,ip) values('".$data['unk']."','".$sesid."','".$_SERVER['REMOTE_ADDR']."')";
				$res = mysql_db_query($db,$sql);
				$data_r = array(
					'unk'=>$data['unk'],
					'sesid'=>$sesid
				);
				$_SESSION['login'] = $data_r;
				if(isset($_REQUEST['return_screen'])){
					$data_r['return_screen'] = $_REQUEST['return_screen'];
				}
				if(isset($_REQUEST['row_id'])){
					$data_r['row_id'] = $_REQUEST['row_id'];
				}			
				$return_array['data'] = $data_r;			
			}		
		}
		return $return_array;
}


function user_logout(){
	unset($_SESSION['login']);
	header("location:".$_SERVER['HTTP_REFERER']);
	exit();
}

function get_user_info($unk){	
	$user_data = array();
	$user_data['unk'] = $unk;
	$user_data['leads_credit'] = '1';
	$user_data['h_refund'] = '1';
	$user_data['leads_limit_type'] = 'no_limit';	
	return $user_data;
}

function get_leads(){
	$status = ( $_REQUEST['status'] == "" ) ? "0" :  $_REQUEST['status'];
	
	$deleted_status = ( $status != "s" && $_REQUEST['deleted'] != "1" ) ? " and status = '".$status."' " :  "";
	$subject_id = ( $_REQUEST['subject_id'] != "" ) ? " and subject_id = '".$_REQUEST['subject_id']."' " :  "";
	if( $status == "s" )
	{
		//print_r($_REQUEST);
		//exit();
		$ex = explode( "/" , $_REQUEST['date_from'] );
		$where = ($_REQUEST['date_from'] != "" ) ? " AND date_in >= '".$ex[2]."-".$ex[1]."-".$ex[0]."' " : "";
		$ex2 = explode( "/" , $_REQUEST['date_to'] );
		$where .= ($_REQUEST['date_to'] != "" ) ? " AND date_in <= '".$ex2[2]."-".$ex2[1]."-".($ex2[0]+1)."' " : "";
		$free_text = ($_REQUEST['free_text'] != "" ) ? iconv("UTF-8","Windows-1255",trim($_REQUEST['free_text'])): "";
		$where .= ($free_text != "" ) ? " AND ( ( name LIKE '%".mysql_r_e_s($free_text)."%' ) OR ( content LIKE '%".mysql_r_e_s($free_text)."%' ) )" : "";
		
		$array_s = $_REQUEST['s'];
		$where_status="";
		if( is_array($array_s) )
		{
			foreach( $array_s as $key => $val )
			{
				$where_status .= " status = '".$key."' OR";
			}
		}
		if( $where_status != "" )
		{
			if(isset($_REQUEST['deleted']) && $_REQUEST['deleted'] == "on"){
				$where .= " AND (".substr( $where_status, 0, -2 ).")";
			}
			else{
				$where .= " AND ((".substr( $where_status, 0, -2 ).") AND deleted = 0)";
			}
		}
		
		
	}
	
	$paging_limit_per_page = 50;
	$paging_limit_start = 0;
	if(isset($_REQUEST['paging_row'])){
		$paging_limit_start = $_REQUEST['paging_row'];
	}
	
	$paging_limit_end = $paging_limit_start + $paging_limit_per_page;
	$paging_last_row = $paging_limit_start;
	$result_count = 0;
	
	$limit_sql = " LIMIT ".$paging_limit_start.", ".$paging_limit_per_page;
	$return_array = array('type'=>'lead_list','success'=>'0','data'=>array());
	$sql = "select * from user_e_card_forms where 1 ".$deleted." and unk = '".UNK."' ".$deleted_status.$where.$subject_id." order by id DESC".$limit_sql;
	$res = mysql_db_query(DB,$sql);
	$status = get_status_list();
	
	while($lead_data = mysql_fetch_array($res)){
		$paging_last_row++;
		$result_count++;
		$return_array['success'] = '1';
		if(!isset($return_array['data'])){
			$return_array['data'] = array();
		}
		$lead = array(
			'row_id'=>$lead_data['id'],
			'date_in'=>$lead_data['date_in'],
			'name'=>iconv("Windows-1255","UTF-8",trim($lead_data['name'])),
			'phone'=>iconv("Windows-1255","UTF-8",trim($lead_data['phone'])),
			'email'=>iconv("Windows-1255","UTF-8",trim($lead_data['email'])),
			'content'=>iconv("Windows-1255","UTF-8",trim(substr($lead_data['content'],0,100)))."...",
			'subject'=>iconv("Windows-1255","UTF-8",trim(substr($lead_data['subject'],0,100)))."...",
			'status'=>$lead_data['status'],
			'status_str'=>$status[$lead_data['status']],
			'opened'=>$lead_data['opened'],
			'deleted'=>$lead_data['deleted'],
			'payByPassword'=>$lead_data['payByPassword'],
			'lead_recource'=>$lead_data['lead_recource'],
			
		);
		//$lead['content'] = substr($lead_data['content'],0,100).'...';
		if(date('Ymd') == date('Ymd', strtotime($lead_data['date_in']))){
			$lead['date_in_str'] = date('H:i',  strtotime($lead['date_in']));
		}
		else{
			$lead['date_in_str'] = date('d/m',  strtotime($lead['date_in']));
		}
		if($lead_data['lead_recource'] == 'phone'){
			$lead['lead_recource']="התקבל טלפונית";
		}
		else{
			$lead['lead_recource']="";
		}
		if($lead['payByPassword'] == '0'){
			$lead['phone'] = substr_replace( $lead['phone'] , "****" , 4 , 4 );
			$lead['email'] = '****@****';
		}
		$return_array['data'][] = $lead;
	}
	if($return_array['success'] == '0'){		
		$return_array['err_str'] = 'empty_list';
		$return_array['info']['paging_done'] = '1';
	}
	else{
		$return_array['info']['paging_last_row'] = $paging_last_row;
		$return_array['info']['paging_done'] = '0';
		if($result_count < $paging_limit_per_page){
			$return_array['info']['paging_done'] = '1';
		}
		else{
			$return_array['info']['paging_done'] = '0';
		}
	}
	return $return_array;
}


function get_lead(){
		$return_array = array('type'=>'lead_form','success'=>'1','data'=>array());
		
		$sql = "select * from user_e_card_forms where id = '".$_REQUEST['row_id']."' and unk = '".UNK."'";
		$res = mysql_db_query(DB,$sql);
		$lead_data = mysql_fetch_array($res);
		if(!isset($lead_data['unk'])){
			$return_array['success'] = '0';
			$return_array['err_str'] = 'empty_result';
		}
		else{
			$lead = array(
				'row_id'=>$lead_data['id'],
				'date_in'=>$lead_data['date_in'],
				'date_in_str'=>date('d/m H:i',  strtotime($lead_data['date_in'])),
				'name'=>iconv("Windows-1255","UTF-8",trim($lead_data['name'])),
				'phone'=>$lead_data['phone'],
				'email'=>iconv("Windows-1255","UTF-8",trim($lead_data['email'])),
				'subject'=>iconv("Windows-1255","UTF-8",trim($lead_data['subject'])),
				'content'=>iconv("Windows-1255","UTF-8",trim($lead_data['content'])),
				'status'=>$lead_data['status'],
				'status_str'=>$status[$lead_data['status']],
				'opened'=>$lead_data['opened'],
				'deleted'=>$lead_data['deleted'],
				'payByPassword'=>$lead_data['payByPassword'],
				'lead_recource'=>$lead_data['lead_recource'],
				'lead_billed'=>$lead_data['lead_billed'],
				'lead_billed_id'=>$lead_data['lead_billed_id'],
				'phone_lead_id'=>$lead_data['phone_lead_id'],
				
			);
			
			if($lead['payByPassword'] == '0'){
				$lead['phone'] = substr_replace( $lead['phone'] , "****" , 4 , 4 );
				$lead['email'] = '****@****';
			}

			$opened_sql = "UPDATE user_e_card_forms SET opened = '1' WHERE unk = '".UNK."' AND id = '". $_REQUEST['row_id']."'";
			$opened_res = mysql_db_query(DB,$opened_sql);
			$return_array['data'] = $lead;				
		}
		return $return_array;
}

function update_lead()	{
	$return_array = array('type'=>'lead_list','success'=>'0','data'=>array());
	if(!isset($_REQUEST['row_id'])){
		$return_array['err_str'] = 'row_not_found';
	}
	else{
		$set_str = "";
		$set_str_i = 0;
		foreach($_POST['data_arr'] as $key=>$val){
			if($set_str_i != 0){
				
				$set_str.=", ";
				
			}
			if($key == "name" || $key == "content" || $key == "subject"){
				$val = iconv("UTF-8","Windows-1255",$val);
			}
			$set_str.= "$key='".mysql_real_escape_string($val)."'";
			$set_str_i++;
		}
		$edit_sql = "UPDATE user_e_card_forms SET $set_str WHERE unk = '".UNK."' AND id = ".$_REQUEST['row_id'];
		$edit_res = mysql_db_query(DB,$edit_sql);
		$return_array['success'] = '1';
	}
	return $return_array;
}



function delete_lead(){
	$return_array = array('type'=>'lead_list','success'=>'0','data'=>array());
	if(!isset($_REQUEST['row_id'])){
		$return_array['err_str'] = 'row_not_found';
	}
	else{
		$sql = "UPDATE user_e_card_forms SET deleted='1' WHERE id = '".$_REQUEST['row_id']."' AND unk = '".UNK."' LIMIT 1";
		$res = mysql_db_query(DB,$sql);
		$effected_rows =  mysql_affected_rows();
		$return_array['success'] = '1';
	}
	return $return_array;
}

function contact_mass_update()
{

	$return_array = array('type'=>'contact_mass_update','success'=>'0','data'=>array());
	if(!isset($_REQUEST['selected_rows'])){
		$return_array['err_str'] = 'empty_list';
	}
	else{
		foreach( $_POST['selected_rows'] as $key => $val )
		{
			switch( $_POST['contact_status'] )
			{
				case "1" :
					$sql = "UPDATE user_e_card_forms SET status = '4' WHERE id = '".$val."' AND unk = '".UNK."' LIMIT 1";
					$res = mysql_db_query(DB,$sql);
				break;
				
				case "2" :
					$sql = "UPDATE user_e_card_forms SET deleted = '1' WHERE id = '".$val."' AND unk = '".UNK."' LIMIT 1";
					$res = mysql_db_query(DB,$sql);
				break;
			}
		}
		$return_array['success'] = '1';
		global $word;
		$return_array['messege'] = $word[LANG]['action_success'];
	}
	return $return_array;
}

function init_module_func()
{
	$file_name = $_GET['c'];
	$func_name = $_GET['f'];	
	if(UNK == "" && $file_name != "reg_token"){
		global $return_info;
		$return_data = json_encode($return_info);
		?>
			<script type="text/javascript">
				window.parent.handle_ajax_error(<?php echo $return_data; ?>);
			</script>
		<?php
		return;
	}

	require_once('ecard/modules/'.$file_name.'.php'); 
	$func_name();
}

?>