<?php

function get_content($main)	{


	
	switch($main)	{
		## Genral 
		case "buy_leads" :				if( AUTH_ID == 0 ) echo buy_leads_form();			break;
		case "buy_leads_sendto_yaad" :	if( AUTH_ID == 0 ) return buy_leads_sendto_yaad();	break;		
		case "payWithCCforLeads_1ok" : 	if( AUTH_ID == 0 ) echo payWithCCforLeads_1ok();	break;
		case "payWithCCforLeads_1er" : 	if( AUTH_ID == 0 ) echo payWithCCforLeads_1er();	break;
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
		case "refund_lead_request" :	return refund_lead_request(); break;
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
}

function get_user_info($unk){
	//$sql = "select * from users where unk = ".$unk;
	$sql = "select unk, leadQry, freeSend, open_mode,hide_refund from user_lead_settings where unk = '".$unk."'";
	$res = mysql_db_query(DB,$sql);
	$data = mysql_fetch_array($res);
	
	$user_data = array();
	if(isset($data['leadQry'])){
		$user_data['unk'] = $data['unk'];
		$user_data['leads_credit'] = $data['leadQry'];
		$user_data['h_refund'] = $data['hide_refund'];
		$user_data['leads_limit_type'] = 'limit';
		if($data['freeSend']=='1' && $data['open_mode'] == '1'){
			$user_data['leads_limit_type'] = 'no_limit';
		}
	}
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
	$pending_qry = " AND ((send_type != 'pending' OR send_type IS NULL) OR (show_time != '' AND show_time IS NOT NULL)) ";
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
	$sql = "select * from user_contact_forms where 1 ".$deleted.$pending_qry." and unk = '".UNK."' ".$deleted_status.$where.$subject_id." order by id DESC".$limit_sql;
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
			
			$sql = "select * from user_contact_forms where id = '".$_REQUEST['row_id']."' and unk = '".UNK."'";
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
					'refund_72_hour_ok'=>'ok',
				);
				$start = new DateTime($lead_data['date_in']);
				$end = new DateTime();
				$hours = round(($end->format('U') - $start->format('U')) / (60*60));
				if($hours > 73){
					$lead['refund_72_hour_ok'] = 'no';
				}
				if($lead['payByPassword'] == '0'){
					$lead['phone'] = substr_replace( $lead['phone'] , "****" , 4 , 4 );
					$lead['email'] = '****@****';
				}
				else{
					
					$viewd_sql = "UPDATE user_lead_sent SET viewedStatus = '1' WHERE sendToUnk = '".UNK."' AND estimateFormID = '". $data['estimateFormID']."' AND sendBy = '2'";
					$viewd_res = mysql_db_query(DB,$viewd_sql);

				}
				$opened_sql = "UPDATE user_contact_forms SET opened = '1' WHERE unk = '".UNK."' AND id = '". $_REQUEST['row_id']."'";
				$opened_res = mysql_db_query(DB,$opened_sql);
				$return_array['data'] = $lead;				
			}
			return $return_array;
	}

function pay_for_lead()
{
	$return_array = array('type'=>'lead_list','success'=>'0','data'=>array());
	if(!isset($_REQUEST['row_id'])){
		$return_array['err_str'] = 'row_not_found';
		return $return_array;
	}
	$sqlQry = "SELECT leadQry FROM user_lead_settings WHERE unk = '".UNK."'";
	$resQry = mysql_db_query(DB,$sqlQry);
	$dataQry = mysql_fetch_array($resQry);
	
	
	if( $dataQry['leadQry'] > "0" )
	{
		$row_sql = "SELECT * FROM user_contact_forms WHERE id = '".$_REQUEST['row_id']."'";
		$row_res = mysql_db_query(DB,$row_sql);
		$row_data = mysql_fetch_array($row_res);


		$bill_array = array(
			"lead_recource" => "form",
			"lead_billed" => "1",
			"lead_billed_id" => "0",
		);		
		if(isset($row_data['phone'])){
			$bill_sql = "SELECT id as billed_id FROM user_contact_forms WHERE phone = '".$row_data['phone']."' AND lead_billed = 1 AND unk = '".$row_data['unk']."' AND date_in > (CAST(DATE_FORMAT(NOW() ,'%Y-%m-01') as DATE)) LIMIT 1";
			$bill_res = mysql_db_query(DB,$bill_sql);	
			$bill_data = mysql_fetch_array($bill_res);
			if(isset($bill_data['billed_id'])){
				$bill_array['lead_billed'] = '0';
				$bill_array['lead_billed_id'] = $bill_data['billed_id'];
			}			
		}		
		
		$sql = "UPDATE user_contact_forms SET payByPassword = '1',lead_billed = '".$bill_array['lead_billed']."',lead_billed_id = '".$bill_array['lead_billed_id']."' WHERE id = '".$_REQUEST['row_id']."'";
		$res = mysql_db_query(DB,$sql);
		$effected_rows =  mysql_affected_rows();
		if($effected_rows > 0){
			if($bill_array['lead_billed'] == '1'){
				$sql = "UPDATE user_lead_settings SET leadQry = leadQry - 1 WHERE unk = '".UNK."'";
				$res = mysql_db_query(DB,$sql);
			}
		}
		$return_array['success'] = '1';
	}
	else
	{
		$return_array['err_str'] = 'out_of_leads';
	}	
	return $return_array;
}
function refund_lead_request(){
	$return_array = array('type'=>'get_lead','success'=>'0','data'=>array());
	if(!isset($_REQUEST['row_id'])){
		$return_array['err_str'] = 'row_not_found';
	}
	else{
		$insert_array = array();
		foreach($_REQUEST as $key=>$val){
			if($key == "comment"){
				$val = iconv("UTF-8","Windows-1255",$val);
			}
			$insert_array[$key] = mysql_real_escape_string($val);
		}
		$insert_sql = "INSERT INTO leads_refun_requests (unk, row_id, reason, comment,request_time) VALUES ('".UNK."',".$insert_array['row_id'].",'".$insert_array['reason']."','".$insert_array['comment']."',NOW())";
		$insert_res = mysql_db_query(DB,$insert_sql);
		$return_array['success'] = '1';
		global $word;
		$return_array['messege'] = $word[LANG]['request_sent'];
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
			if($key == "name" || $key == "content"){
				$val = iconv("UTF-8","Windows-1255",$val);
			}
			$set_str.= "$key='".mysql_real_escape_string($val)."'";
			$set_str_i++;
		}
		$edit_sql = "UPDATE user_contact_forms SET $set_str WHERE unk = '".UNK."' AND id = ".$_REQUEST['row_id'];
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
		$sql = "UPDATE user_contact_forms SET deleted='1' WHERE id = '".$_REQUEST['row_id']."' AND unk = '".UNK."' LIMIT 1";
		$res = mysql_db_query(DB,$sql);
		$effected_rows =  mysql_affected_rows();
		$return_array['success'] = '1';
	}
	return $return_array;
}


function buy_leads_form()
{
	if(UNK == ""){
		global $return_info;
		$return_data = json_encode($return_info);
		?>
			<script type="text/javascript">
				window.parent.handle_ajax_error(<?php echo $return_data; ?>);
			</script>
		<?php
		return;
	}

	$sql = "SELECT openContactDataPrice,leadQry FROM user_lead_settings WHERE unk = '".UNK."' ";
	$res = mysql_db_query(DB,$sql);
	$dataUser = mysql_fetch_array($res);
	
	if( $dataUser['openContactDataPrice'] > "0" )
	{
		$user_tokens_sql = "SELECT L4digit,full_name,biz_name FROM userCCToken WHERE unk = '".UNK."'";
		$user_tokens_res = mysql_db_query(DB,$user_tokens_sql);
		$user_tokens = false;
		$user_biz_name = "";
		$user_full_name = "";
		while($user_token_data = mysql_fetch_array($user_tokens_res)){
			if(!$user_tokens){
				$user_tokens = array();
			}
			$user_tokens[] = $user_token_data['L4digit'];
			if($user_token_data['biz_name'] != ""){
				$user_biz_name = iconv("Windows-1255","UTF-8",$user_token_data['biz_name']);
				$user_full_name = iconv("Windows-1255","UTF-8",$user_token_data['full_name']);		
			}
		}
	?>
		<div class='buy_leads_wrap'>
			<div class='buy_leads_leadQry'>
				<h4>יתרתך: <span id="leadQry"><?php echo $dataUser['leadQry']; ?></span> לידים</h4>
				
			</div>
			
			<h5>לרכישה:</h5>
			<form action='../myleads/' method='post' name='sendto_buy_leads' id='sendto_buy_leads_form'>
				<input type='hidden' name='main' value='buy_leads_sendto_yaad' />
				<input type='hidden' name='type' value='buy_leads' />
				<input type='hidden' name='unk' value='<?php echo UNK; ?>' />
				<input type='hidden' name='sesid' value='<?php echo SESID; ?>' />
				<input type='hidden' name='sessid' value='<?php echo session_id(); ?>' />
				<input type='hidden' name='content_type' value='iframe' />
				<div class='buy_leads_desc'>
					
					אנא מלאו את מספר הלידים שברצונכם לרכוש: <br/>
					<input type='text' id='num_credit_input' name='num_credit' class='input_style text-input qty required digits' data-msg="אנא בחר מספר לידים"><br>
					מחיר כל ליד הינו: <?php echo $dataUser['openContactDataPrice']; ?> ש"ח כולל מע"מ.<br>
					<br>
					<div class="buy-leads-amount" id = "buy_leads_amount_wrap" style="display:none;">
					סך הכל לתשלום: <span id="buy_leads_amount_holder"></span> ש"ח כולל מע"מ.<br>
					</div>
					<?php if(!$user_tokens): ?>
						<input type='hidden' id='use_token_select' name='use_token' value='0' />
					<?php else: ?>
						<div class='buy_leads_token_select form-group '>
							<label for='use_token'>בחר כרטיס אשראי</label>
							<select name='use_token' id='use_token_select' class="form-select use-token input_style">
								<option value='0'>השתמש בכרטיס חדש</option>
								<?php foreach($user_tokens as $key=>$val): ?>
									<option value='<?php echo $val; ?>'><?php echo $val; ?>**** **** **** </option>		
								<?php endforeach; ?>
							</select>
						</div>
					
					<?php endif; ?>
						<div class='buy_leads_full_name form-group '>
							<label for='full_name'>שם מלא</label>
							<input type='text' id='full_name_input' name='full_name' value='<?php echo $user_full_name; ?>' class='input_style text-input required' data-msg="נא להוסיף שם מלא"><br>
						</div>	
						<div class='buy_leads_biz_name form-group '>
							<label for='biz_name'>שם העסק שיופיע בחשבונית</label>
							<input type='text' id='biz_name_input' name='biz_name' value='<?php echo $user_biz_name; ?>' class='input_style text-input required' data-msg="נא להוסיף את שם העסק"><br>
						</div>						
					<input type='submit' id='buy_leads_submit' class='submit_style' value='עבור לטופס תשלום מאובטח' />
				</div>
			</form>
			<script type="text/javascript">
				$("#sendto_buy_leads_form").validate({
				 submitHandler: function(form) {
				   $("#buy_leads_submit").attr("disabled", true).val("אנא המתן...");
				   form.submit();
				 }
				});
				$("#num_credit_input").keyup(function(){
					var l_num = $(this).val();
					if(!isNaN(parseInt(l_num)) && isFinite(l_num)){
						$("#buy_leads_amount_holder").html(parseInt(l_num)*<?php echo $dataUser['openContactDataPrice']; ?>);
						$("#buy_leads_amount_wrap").show();
					}
					else{
						$("#buy_leads_amount_holder").html("");
						$("#buy_leads_amount_wrap").hide();						
					}
						
				});
				$("#use_token_select").change(function(){
					if($(this).val()!= '0'){
						$("#buy_leads_submit").val("בצע רכישה");
					}
					else{
						$("#buy_leads_submit").val("עבור לטופס תשלום מאובטח");
					}
				});
				$('#sendto_buy_leads_form').submit(function () {
					if($(this).valid()) {
						if($("#use_token_select").val() != '0'){
							window.parent.begin_ajax_call_view();
						}
					}
				});
			</script>
		</div>
	<?php 
	}
}


function buy_leads_sendto_yaad()
{
	$_SESSION['yaad_return_type'] = "mobile_leads";
	$buy_c = (int)$_POST['num_credit'];

	
	if( $buy_c > 0 )
	{
		$sql = "SELECT id,name,email FROM users WHERE unk = '".UNK."' ";
		$res = mysql_db_query(DB,$sql);
		$dataUser = mysql_fetch_array($res);
		
		$sql = "SELECT openContactDataPrice FROM user_lead_settings WHERE unk = '".UNK."' ";
		$res2 = mysql_db_query(DB,$sql);
		$dataUser2 = mysql_fetch_array($res2);
		
		$new_p = $buy_c * $dataUser2['openContactDataPrice'];
		
		$gotoUrlParamter = 'myleads_moblie&sessid='.session_id();
		$pro_decs = "קניית ".$buy_c." לידים";
		$pro_decs_insert = iconv("UTF-8","Windows-1255",$pro_decs);
		$dataUserName = iconv("Windows-1255","UTF-8",$dataUser['name']);
		$heshbonit_keys = "";
		$heshbonit_vals = "";
		if(isset($_REQUEST['full_name']) && isset($_REQUEST['biz_name'])){
			$heshbonit_keys = ",full_name,biz_name";
			
			$full_name = iconv("UTF-8","Windows-1255",$_REQUEST['full_name']);
			$biz_name = iconv("UTF-8","Windows-1255",$_REQUEST['biz_name']);
			$heshbonit_vals = ",'".$full_name."','".$biz_name."'";
		}
		$sql = "INSERT INTO ilbizPayByCCLog ( sumTotal , payDate , description , payToType , userId , gotoUrlParamter".$heshbonit_keys." ) VALUES (
			'".$new_p."' , NOW() , '".$pro_decs_insert."' , '9' , '".$dataUser['id']."' , '".$gotoUrlParamter."'".$heshbonit_vals."
		)";
		
		$res = mysql_db_query(DB,$sql);
		$userIdU = mysql_insert_id();
		// old masof: 4500019225 new: 4500237126
		
		if($_REQUEST['use_token']!='0'){
			$user_tokens_sql = "SELECT * FROM userCCToken WHERE unk = '".UNK."' AND L4digit = '".$_REQUEST['use_token']."'";
			$user_tokens_res = mysql_db_query(DB,$user_tokens_sql);
			$user_token_data = mysql_fetch_array($user_tokens_res);
			$userName_arr = explode(" ",$user_token_data['Fild1']);
			$params = array(
				'Masof'=>'4500019225',
				'action'=>'soft',
				'PassP'=>'Y123pilbiz',
				'Token'=>'True',
				'Order'=>$userIdU,
				'Amount'=>$new_p,
				'Info'=>$pro_decs,
				'UserId'=>$user_token_data['customer_ID_number'],
				'CC'=>$user_token_data['token'],
				'Tmonth'=>$user_token_data['Tmonth'],
				'Tyear'=>$user_token_data['Tyear'],
				'ClientName'=>$_REQUEST['full_name'],
				'ClientLName'=>$_REQUEST['biz_name'],
				'SendHesh'=>'True',
				'UTF8'=>'True',
				//'ClientName'=>$userName_arr[0],
				//'ClientLName'=>$userName_arr[0],
				// 'allowFalse'=>'True',
				
			);
			$postData = '';
			//create name value pairs seperated by &
			foreach($params as $k => $v) 
			{ 
				$postData .= $k . '='.$v.'&'; 
			}
			$postData = rtrim($postData, '&');
		 
			$ch = curl_init();  
		 
			curl_setopt($ch,CURLOPT_URL,"https://icom.yaad.net/cgi-bin/yaadpay/yaadpay.pl");
			curl_setopt($ch,CURLOPT_RETURNTRANSFER,true);
			curl_setopt($ch,CURLOPT_HEADER, false); 
			curl_setopt($ch, CURLOPT_POSTFIELDS, $postData);    
		 
			$output=curl_exec($ch);
		 
			curl_close($ch);
			
			$result_arr = explode("&",$output);
			$result = array();
			foreach($result_arr as $result_val){
				$val_arr = explode("=",$result_val);
				if(isset($val_arr[0]) && isset($val_arr[1])){
					$result[$val_arr[0]] = $val_arr[1];
				}
			}
			if($result['CCode'] == '0'){
				
				$ilbizurl = "http://www.ilbiz.co.il/global_func/yaadPay/ok.php?Id=".$result['Id']."&CCode=".$result['CCode']."&Amount=".$result['Amount']."&ACode=".$result['ACode']."&Order=".$userIdU."&Payments=1&UserId=".$user_token_data['customer_ID_number']."&Hesh=".$result['Hesh']."";
				header( 'location:' . $ilbizurl );
			}
			else{
				payWithCCforLeads_1er();

			}
		}
		else{
		
			echo '
			<form name="YaadPay"  accept-charset="windows-1255" action="https://icom.yaad.net/cgi-bin/yaadpay/yaadpay.pl" method="post" >
			<INPUT TYPE="hidden" NAME="Masof" value="4500019225" >
			<INPUT TYPE="hidden" NAME="action" value="pay" >
			<INPUT TYPE="hidden" NAME="Amount" value="'.$new_p.'" >
			<INPUT TYPE="hidden" NAME="Order" value="'.$userIdU.'" >
			<INPUT TYPE="hidden" NAME="Info" value ="'.$pro_decs.'" >
			<INPUT TYPE="hidden" NAME="ClientName" value ="'.$_REQUEST['full_name'].'" >
			<INPUT TYPE="hidden" NAME="ClientLName" value ="'.$_REQUEST['biz_name'].'" >
			<INPUT TYPE="hidden" NAME="Tash" value="1" >
			<INPUT TYPE="hidden" NAME="MoreData" value="True" >
			<INPUT TYPE="hidden" NAME="SendHesh" value="True" >
			
			<input type="hidden" name="email" value="'.$dataUser['email'].'">
			</form>
			<p align=right dir=rtl class=maintext>טוען טופס מאובטח...</p>
			
			<script>
				window.parent.handle_buy_leads_description('.$buy_c.','.$new_p.');
				document.YaadPay.submit();
			</script>';
		}
	}
	
}

function payWithCCforLeads_1ok(){
	global $word;
	?>
		<script type="text/javascript">
			window.parent.handle_buy_leads_success("<?php echo $word[LANG]['action_success']; ?>");
		</script>
	<?php 
}

function payWithCCforLeads_1er(){
	global $word;
	?>
		<script type="text/javascript">
			window.parent.handle_buy_leads_error("<?php echo $word[LANG]['buy_leads_global_error']; ?>");
		</script>
	<?php	
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
					$sql = "UPDATE user_contact_forms SET status = '4' WHERE id = '".$val."' AND unk = '".UNK."' LIMIT 1";
					$res = mysql_db_query(DB,$sql);
				break;
				
				case "2" :
					$sql = "UPDATE user_contact_forms SET deleted = '1' WHERE id = '".$val."' AND unk = '".UNK."' LIMIT 1";
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

?>