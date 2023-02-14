<?php
/*

class of ILBIZ NET


*/


class leadSys
{
	
	function __construct(){}
	
	
	
	
	
	public function userLeadQryMinus1($unk)
	{
		$sql = "UPDATE user_lead_settings SET leadQry = leadQry - 1 WHERE unk = '".$unk."'";
		$res = mysql_db_query(DB,$sql);
	}
	
	
	
	
	public function sendLeadToUser($unk, $estimateFormID, $sendBy="0",$send_type="send" )
	{
		$table_name = "user_lead_sent";
		if($send_type=="pending"){
			$table_name = "user_lead_sent_pending";
		}
		$sql = "INSERT INTO ".$table_name." ( estimateFormID, sendToUnk, sendBy, date ) values ( '".$estimateFormID."' , '".$unk."', '".$sendBy."', NOW())";
		$res = mysql_db_query(DB,$sql);
	}
	
	
	
	
	
	public function updateViewedLead( $unk, $estimateFormID, $sendBy, $viewedStatus, $transID="" )
	{
		$transID_sql = ( $transID != "" ) ? "AND transID = '".$transID."' " : "";
		$sql = "UPDATE user_lead_sent SET viewedStatus = '".$viewedStatus."' WHERE unk = '".$unk."' AND estimateFormID = '".$estimateFormID."' AND sendBy = '".$sendBy."' ".$transID_sql."";
		$res = mysql_db_query(DB,$sql);
	}
	
	
	
	
	public function updateViewedLeadByID( $viewedStatus, $sentID )
	{
		$sql = "UPDATE user_lead_sent SET viewedStatus = '".$viewedStatus."' WHERE id = '".$sentID."'";
		$res = mysql_db_query(DB,$sql);
	}
	
	
	
	
	
	public function sendLeadSMS($msg, $phone, $sentID,$send_type="send",$sendToUnk = "")
	{
		if($send_type == "pending" && $sendToUnk!=""){
			$msg = str_replace("'","''",$msg);
			$phone = str_replace("'","''",$phone);
			$sentID = str_replace("'","''",$sentID);
			$sql = "INSERT INTO system_pending_sms(sendToUnk, msg, phone, sentID) VALUES('$sendToUnk','$msg', '$phone', '$sentID')";
			$res = mysql_db_query(DB,$sql);
			return;
		}
		$url = "http://www.micropay.co.il/ExtApi/ScheduleSms.php"; 
		
		if( eregi( '����� �������: ' , $http_ref) )
			$param = "?get=1&uid=1565&un=ilbiz&msg=".urlencode($msg)."&charset=iso-8859-8&from=086105157&list=".$phone."&nu=http://mysave.co.il/other/smsLeadsSendStatus.php"; 
		else
			$param = "?get=1&uid=1565&un=ilbiz&msg=".urlencode($msg)."&charset=iso-8859-8&from=086233226&list=".$phone."&nu=http://mysave.co.il/other/smsLeadsSendStatus.php"; 
		
		$trans_id = $this->sendSmsByCurl($url.$param,$sentID);
		
		if( eregi( "OK" , $trans_id ) )
		{
			$trans_xp = explode( " " , $trans_id );
			
			$sql = "UPDATE user_lead_sent SET transID = '".$trans_xp[1]."' WHERE id = '".$sentID."'";
			$res = mysql_db_query(DB,$sql);
		}
		else
			$this->updateViewedLeadByID("3", $sentID);
	}
	
	
	public function sendLeadAPI($api_url,$send_type="send",$sendToUnk = "")
	{
		
		if($send_type == "pending" && $sendToUnk!=""){
			$api_url = str_replace("'","''",$api_url);
			$sql = "INSERT INTO system_pending_api(sendToUnk, api_url) VALUES('$sendToUnk','$api_url')";
			$res = mysql_db_query(DB,$sql);
			return;
		}
		
		$url_arr = explode("?",$api_url);
		$url = $url_arr[0];
		$params = "";
		for($i=1;$i<count($url_arr);$i++){
			if($i!=1){
				$params.="?";
			}
			$params.=$url_arr[$i];
		}
		
		$ch = curl_init(); 
		curl_setopt( $ch, CURLOPT_URL,$url ); 
		curl_setopt($ch, CURLOPT_HEADER, 0);
		curl_setopt( $ch, CURLOPT_POST, 1 ); 
		curl_setopt( $ch, CURLOPT_POSTFIELDS, $params ); 
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_FOLLOWLOCATION, TRUE);
		$resualt = curl_exec ($ch); 
		
		curl_close ($ch);
		
	}	
	
	
	public function sendSmsByCurl($url_params,$sentID)
	{
		$curlSend = curl_init(); 
		
		curl_setopt($curlSend, CURLOPT_URL, $url_params); 
		curl_setopt($curlSend, CURLOPT_RETURNTRANSFER, 1); 
		
		$curlResult = curl_exec ($curlSend); 
		curl_close ($curlSend); 
		
		if (isset($curlResult) ) 
			return $curlResult; 
		else 
			return 0; 
	}
	
	
	
	public function cheackLeadSentToContact($unk)
	{
		//$sql = "SELECT * FROM user_lead_settings WHERE unk = '".$unk."' ";
		$sql = "SELECT l.* FROM user_lead_settings as l , users as u WHERE l.unk = '".$unk."' and u.unk = l.unk and u.end_date >= NOW() and u.status = '0'";
		$res = mysql_db_query(DB,$sql);
		$data = mysql_fetch_array($res);
		
		if( empty($data['id']) )
			return 1;
		else
		{
			if( $data['freeSend'] == 1 && $data['haveContact'] == 1 )
				return 2;
			elseif( $data['haveContact'] == 1 && $data['leadQry'] > 0 && $data['contactPrice'] > 0 && $data['havaSms'] == 0 )
				return 3;
			elseif( $data['haveContact'] == 1 && $data['leadQry'] > 0 && $data['contactPrice'] > 0 && $data['havaSms'] == 1 && $data['smsPrice'] > 0  )
				return 4;
			elseif( $data['haveContact'] == 1 && $data['leadQry'] > 0 && $data['contactPrice'] > 0 && $data['havaSms'] == 1  )
				return 5;
			elseif( $data['openContactDataPrice'] > 0 )
				return 6;
			else
				return 0;
		}
	}
	
	
	
	public function cheackLeadSendToSms($unk)
	{
		//$sql = "SELECT * FROM user_lead_settings WHERE unk = '".$unk."' ";
		$sql = "SELECT l.* FROM user_lead_settings as l , users as u WHERE l.unk = '".$unk."' and u.unk = l.unk and u.end_date >= NOW() and u.status = '0'";
		$res = mysql_db_query(DB,$sql);
		$data = mysql_fetch_array($res);
		
		if( empty($data['id']) )
			return 0;
		else
		{
			if( $data['freeSend'] == '1' && $data['havaSms'] == '1' )
				return 1;
			elseif( $data['leadQry'] > '0' && $data['havaSms'] == '1' && $data['smsPrice'] > '0' )
				return 2;
			elseif( $data['havaSms'] == '1' && $data['smsPrice'] == '0' )
				return 3;
			else
				return 0;
		}
		return 0;
	}
	
	
	
	
	public function sendSmsAction($unk, $estimateId, $arr=array(), $from="����� ������ 10 " )
	{
		if( $this->cheackLeadSendToSms($unk) > 0 )
		{
			$sql = "select phone FROM users WHERE unk = '".$unk."' ";
			$res2 = mysql_db_query(DB,$sql);
			$data_phone = mysql_fetch_array($res2);
			
			$new_phone = str_replace( "-" , "" , $data_phone['phone'] );
			
			if( strlen($arr['phone']) >= "9" && $arr['name'] != "" )
			{
				switch($this->cheackLeadSendToSms($unk))
				{
					case "1" : 
						$this->sendLeadToUser($unk, $estimateId , "1" );
						$snt_id = mysql_insert_id();
						$msgcity =  ( $arr['city'] != "" ) ? $arr['city'].", " : "";
						$this->sendLeadSMS($from.$arr['name'].", ".$msgcity.$arr['phone'] , $new_phone , $snt_id);
						
						return 1;
					break;
					
					case "2" :
						$this->sendLeadToUser($unk, $estimateId , "1" );
						$snt_id = mysql_insert_id();
						$msgcity =  ( $arr['city'] != "" ) ? $arr['city'].", " : "";
						$this->sendLeadSMS($from.$arr['name'].", ".$msgcity.$arr['phone'] , $new_phone , $snt_id);
						$this->userLeadQryMinus1($unk);
						
						return 1;
					break;
					
					case "3" :
						$this->sendLeadToUser($unk, $estimateId , "1" );
						$snt_id = mysql_insert_id();
						$msgcity =  ( $arr['city'] != "" ) ? $arr['city'].", " : "";
						$phone = substr_replace( $arr['phone'] , "****" , 4 , 4 );
						$this->sendLeadSMS($from.$arr['name'].", ".$msgcity.$phone , $new_phone , $snt_id);
						return 1;
					break;
				}
			}
		}
		
		return 0;
	}
	
	public function splitstring($string,$len) 
	{
		for($i=0;$i<ceil(strlen($string)/$len);$i++)
		   $rtnarr[$i]=substr($string, $len*$i, $len); 
		
		return($rtnarr[0]);
	}
	
	public function sendContact( $user_id , $estimate_id , $estimate_data_array )
	{
		
		$sql_user = "select unk,email from users where id = '".$user_id."' ";
		$res_user = mysql_db_query(DB,$sql_user);
		$data_user = mysql_fetch_array($res_user);
		
		if ( $this->cheackLeadSentToContact( $data_user['unk'] ) > 0 )
		{
			switch( $data_user['unk'] )
			{

					$sql = "select id,cat_name from biz_categories where id='".$estimate_data_array['cat_f']."'";
					$res_cat_f = mysql_db_query(DB,$sql);
					$data_cat_f = mysql_fetch_array($res_cat_f);
					
					$sql = "select id,cat_name from biz_categories where id='".$estimate_data_array['cat_s']."'";
					$res_cat_s = mysql_db_query(DB,$sql);
					$data_cat_s = mysql_fetch_array($res_cat_s);
					
					$sql = "select id,cat_name from biz_categories where id='".$estimate_data_array['cat_spec']."'";
					$res_cat_spec = mysql_db_query(DB,$sql);
					$data_cat_spec = mysql_fetch_array($res_cat_spec);
					
					$sql = "select ef.*, nc.name as NewCity from estimate_form as ef left join newCities as nc on ef.city=nc.id WHERE ef.id = '".$estimate_id."'";
					$res = mysql_db_query(DB, $sql);
					$data_estimate_form = mysql_fetch_array($res);
					
					
					//if( $estimate_data_array['referer'] != "" )		{
						$fromEmail = "info@10service.co.il"; 
						$fromTitle = "10Service.co.il"; 
					/*}
					else
					{
						$fromEmail = "info@mysave.co.il"; 
						$fromTitle = "MySave.co.il"; 
					}*/
					
					$content = "
							����,<br>
							<br>
							���� ���� ����� ���� ����� <a href='http://www.".$fromTitle."' class='textt' target='_blank'><u>".$fromTitle."</u></a><br><br>
							����: ".stripslashes($data_cat_f['cat_name'])."<br>
							�����: ".stripslashes($data_cat_s['cat_name'])."<br>
							������: ".stripslashes($data_cat_spec['cat_name'])."<br>
							��: ".stripslashes($data_estimate_form['name'])."<br>";
							
							if( $this->cheackLeadSentToContact($data_user['unk']) == 6 )
							{
								$phone = substr_replace( $data_estimate_form['phone'] , "****" , 4 , 4 );
								$content .= "�����: <font dir=ltr>".stripslashes($phone)."</font><br>";
							}
							else
								$content .= "�����: ".stripslashes($data_estimate_form['phone'])."<br>";
							
							if( $this->cheackLeadSentToContact($data_user['unk']) == 6 )
							{
								if( $data_estimate_form['email'] != "" )
								{
									$temp_email = explode( "@" , stripslashes($data_estimate_form['email']) );
									$len = strlen($temp_email[0]);
									$spar = "";
									for( $i=0 ; $i<=$len-2 ; $i++ )
										$spar .= "*";
									$email = substr_replace( $temp_email[0] , $spar , 1 , strlen($spar) );
									
									$len2 = strlen($temp_email[1]);
									$spar1 = "";
									for( $j=0 ; $j<=$len2 ; $j++ )
										$spar1 .= "*";
									$email2 = substr_replace( $temp_email[1] , $spar1 , 1 , strlen($spar1) );
									
									$content .= "������: <font dir=ltr>".$email."@".$email2."</font><br>";
								}
							}
							else
								$content .= "������: ".stripslashes($data_estimate_form['email'])."<br>";
							
							$content .= "���: ".stripslashes($data_estimate_form['NewCity'])."<br>
							�����/�����: <br>".stripslashes($data_estimate_form['note'])."<br><br>
							
							�� ��� ����� ������ ������ �� ����� ������ �����, �� ����� �������� '����� ���� ��� ���'<br>
							<a href='http://www.ilbiz.co.il/ClientSite/administration/login.php' class='textt' target='_blank'><u>������ ����� ��� ���</u></a><br>
							<br>
							<br>
							�����,<br>
							����� IL-BIZ<BR>
							����� ����� ��������
						";
					
						$header_send_to_Client= "���� ���� ����� ���� ����";
						$content_send_to_Client = "
							<html dir=rtl>
							<head>
									<title></title>
									<style>
										.textt{font-family: arial; font-size:12px; color: #000000}
									</style>
							</head>
							
							<body>
								<p class='textt' dir=rtl align=right>".$content."</p>
							</body>
							</html>";
					
					$ClientMail = $data_user['email'];
					GlobalFunctions::send_emails_with_phpmailer($fromEmail, $fromTitle, $header_send_to_Client, $content_send_to_Client, $content_send_to_Client, $ClientMail, $fromTitle );
		
					// insert new row to user contact system
					$data_arr['unk'] = $data_user['unk'];
					
					$sql = "select cat_name from biz_categories where id='".$estimate_data_array['cat_f']."'";
					$resf = mysql_db_query(DB,$sql);
					$data_cat_f = mysql_fetch_array($resf);
				
					$sql = "select cat_name from biz_categories where father='".$estimate_data_array['cat_f']."' and id='".$estimate_data_array['cat_s']."'";
					$ress = mysql_db_query(DB,$sql);
					$data_cat_s22 = mysql_fetch_array($ress);
					$data_cat_s22 = ( $data_cat_s22['cat_name'] != "" ) ? ", ".GlobalFunctions::kill_strip($data_cat_s22['cat_name']) : "";
					
					$sql = "select cat_name from biz_categories where father='".$estimate_data_array['cat_s']."' and id='".$estimate_data_array['cat_spec']."'";
					$ress3 = mysql_db_query(DB,$sql);
					$data_cat_s33 = mysql_fetch_array($ress3);
					$data_cat_s33 = ( $data_cat_s33['cat_name'] != "" ) ? ", ".GlobalFunctions::kill_strip($data_cat_s33['cat_name']) : "";
					
					
					$sql = "SELECT mfb.* FROM mysaveFormButton as mfb, mysaveFormButton_clientChoosen as cc WHERE cc.buttonId=mfb.id AND estimatId='".$estimate_id."' ORDER BY mfb.place";
					$res_mfb = mysql_db_query(DB, $sql);
					
					$catButtons = "";
					while( $data_mfb = mysql_fetch_array($res_mfb) )
					{
						$catButtonsTEMP .= stripslashes($data_mfb['title']).", ";
					}
					$catButtons = substr( $catButtonsTEMP, 0, -2 );
					
					$fromSite = "10service: ";

					$city = ( $estimate_data_array['NewCity'] != "" ) ? $estimate_data_array['NewCity'] : $estimate_data_array['city'];
					$NEW_Content_note = "���: ".GlobalFunctions::kill_strip($city)."\n";
					
					if( $estimate_data_array['to_city'] != "" )
						$NEW_Content_note .= "����: ".GlobalFunctions::kill_strip($estimate_data_array['to_city'])."\n";
					if( $estimate_data_array['passengers'] != "" )
						$NEW_Content_note .= "���� ������: ".GlobalFunctions::kill_strip($estimate_data_array['passengers'])."\n";
					
					$NEW_Content_note .= "���� �������: ".GlobalFunctions::kill_strip($data_cat_f['cat_name']).$data_cat_s22.$data_cat_s33."\n";
					$NEW_Content_note .= GlobalFunctions::kill_strip($catButtons)."\n\n";
					
					$NEW_Content_note .= GlobalFunctions::kill_strip($estimate_data_array['note']);
					
					$data_arr['name'] = $fromSite."(".GlobalFunctions::kill_strip($estimate_data_array['name']).")";
					$data_arr['email'] = GlobalFunctions::kill_strip($estimate_data_array['email']);
					$data_arr['phone'] = GlobalFunctions::kill_strip($estimate_data_array['phone']);
					$data_arr['content'] = $NEW_Content_note;
					$data_arr['date_in'] = GlobalFunctions::get_timestemp();
					$data_arr['estimateFormID'] = $estimate_id;
					
					$image_settings = array(
						after_success_goto=>"",
						table_name=>"user_contact_forms",
					);
			
					insert_to_db($data_arr, $image_settings);
					
					// add new row to count how match forms sent to this user
					$sql = "insert into users_send_estimate_form ( user_id, estimate_id ) values ( '".$user_id."' , '".$estimate_id."' )";
					$res = mysql_db_query(DB,$sql);
						
					switch($this->cheackLeadSentToContact( $data_user['unk'] ))
					{
						case "1" :
						case "2" :
						case "4" :
							$this->sendLeadToUser($data_user['unk'], $estimate_id);
						break;
						
						case "3" :
						case "5" :
							$this->sendLeadToUser($data_user['unk'], $estimate_id);
							//$this->userLeadQryMinus1($data_user['unk']);
						break;
						
						case "6" :
							$this->sendLeadToUser($data_user['unk'], $estimate_id , "2" );
						break;
					}
			
			
			if( $estimate_data_array['statistic_id'] != "" )
			{
				$estimate_statisitc = new estimate_statisitc;
				$estimate_statisitc->UpdateEstimateSendToClient( $estimate_data_array['statistic_id'] , $estimate_id );
			}
		}
	}
	
	public function curl_send_mysave_external_lead( $url , $params )
	{
		$ch = curl_init();
		
		curl_setopt($ch, CURLOPT_URL, $url );
		curl_setopt($ch, CURLOPT_HEADER, 0);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_POST, 1); 
		curl_setopt($ch, CURLOPT_POSTFIELDS, $params );
		$res = curl_exec($ch);
		curl_close($ch);
		
		return $res;
	}
	
	public function estetica_reutrn_cat_id($cat_array)
	{
		$array = array(
			"102" => "����� ����" ,
			"110" => "����� ���" ,
			"111" => "������� ���� �����" ,
			"114" => "���� ���" ,
			"115" => "����� ������" ,
			"116" => "����� ������" ,
			"117" => "������ �������" ,
			"118" => "����� ����" ,
			"119" => "���� ��� �����" ,
			"120" => "����� �������" ,
			"121" => "����� ����" ,
			"123" => "����� ��" ,
			"126" => "����� ��� ������" ,
			"131" => "���� ���" ,
			"132" => "����� ���" ,
			"134" => "����� ���" ,
			"135" => "���� ���� ������" ,
			"139" => "���� ������� ������" ,
			
			"141" => "����� ������" ,
			"142" => "����� �������" ,
			"143" => "����� ������" ,
			
			"158" => "������ ����" ,
			"159" => "����� ������" ,
			"163" => "����� �����" ,
			"165" => "����� ������� ������ �������" ,
			"169" => "������" ,
			"171" => "���� ������" ,
			"182" => "���� ����" ,
			"196" => "����� ���" ,
			
		);
		
		foreach( $array as $id => $val )
		{
			if( in_array( $val , $cat_array ) )
			{
				$return = $id;
				break;
			}
		}
		
		if( empty($return) )
			$return = 0;
		
		return $return;
	}
	
	public function add_user_contact_form($user_data,$estimate_data_array,$estimate_id,$open_mode = false,$send_type="send"){
		$NEW_Content_note = "���: ".GlobalFunctions::kill_strip($estimate_data_array['city'])."\n";
			
		if( $estimate_data_array['to_city'] != "" )
			$NEW_Content_note .= "����: ".GlobalFunctions::kill_strip($estimate_data_array['to_city'])."\n";
		if( $estimate_data_array['passengers'] != "" )
			$NEW_Content_note .= "���� ������: ".GlobalFunctions::kill_strip($estimate_data_array['passengers'])."\n";
		
		$NEW_Content_cats = $estimate_data_array['cat_f_name'];
		if($NEW_Content_cats != "" && $estimate_data_array['cat_s_name']){
			$NEW_Content_cats .= ", ";
		}
		$NEW_Content_cats .= $estimate_data_array['cat_s_name'];
		if($NEW_Content_cats != "" && $estimate_data_array['cat_spec_name']){
			$NEW_Content_cats .= ", ";
		}
		$NEW_Content_cats .= $estimate_data_array['cat_spec_name'];
		
		$NEW_Content_note .= "���� �������: ".$NEW_Content_cats."\n";
		$NEW_Content_note .= GlobalFunctions::kill_strip($catButtons)."\n\n";
		
		$NEW_Content_note .= GlobalFunctions::kill_strip($estimate_data_array['note']);
		$auth_token = sha1(UNK.(time()));
		$data_arr['auth_token'] = $auth_token;
		
		$data_arr['unk'] = $user_data['unk'];
		$data_arr['name'] = $estimate_data_array['from_service']."(".GlobalFunctions::kill_strip($estimate_data_array['name']).")";
		$data_arr['email'] = GlobalFunctions::kill_strip($estimate_data_array['email']);
		$data_arr['phone'] = GlobalFunctions::kill_strip($estimate_data_array['phone']);
		$data_arr['content'] = $NEW_Content_note;
		$data_arr['date_in'] = GlobalFunctions::get_timestemp();
		$data_arr['estimateFormID'] = $estimate_id;
		$data_arr['send_type'] = $send_type; 
		$bill_array = array(
			"lead_recource" => "",
			"lead_billed" => "",
			"lead_billed_id" => "",
			"phone_str" => "",
		);
		foreach($bill_array as $key=>$val){
			if(isset($estimate_data_array[$key])){
				$data_arr[$key] = $estimate_data_array[$key];
			}
		}		
		if($open_mode){
			$data_arr['payByPassword'] = '1';
		}
						
		$image_settings = array(
			after_success_goto=>"",
			table_name=>"user_contact_forms",
		);

		insert_to_db($data_arr, $image_settings);
		$row_id = mysql_insert_id();
		// add new row to count how match forms sent to this user
		$sql = "insert into users_send_estimate_form ( user_id, estimate_id ) values ( '".$user_data['id']."' , '".$estimate_id."' )";
		
		$res = mysql_db_query(DB,$sql);
		
		if( $estimate_data_array['statistic_id'] != "" )
		{
			$estimate_statisitc = new estimate_statisitc;
			$estimate_statisitc->UpdateEstimateSendToClient( $estimate_data_array['statistic_id'] , $estimate_id );
		}	
		return array('row_id'=>$row_id,'token'=>$auth_token);
	}

	public function send_contact_to_user_email($user_data,$estimate_data_array,$open_mode = false,$insert_array=false,$send_type="send"){
		$sendToUnk = $user_data['unk'];
		$ClientMail = $user_data['email'];
		$fromEmail = "info@10service.co.il"; 
		$fromTitle = "10Service.co.il";
		$leads_settings_sql = "SELECT * FROM user_lead_settings WHERE unk = '$sendToUnk'";
		$leads_settings_res = mysql_db_query(DB,$leads_settings_sql);
		$leads_settings = mysql_fetch_array($leads_settings_res);
		$content = "
			����,<br>
			<br>
			���� ���� ����� ���� ����� <a href='http://www.".$fromTitle."' class='textt' target='_blank'><u>".$fromTitle."</u></a><br><br>
			����: ".stripslashes($estimate_data_array['cat_f_name'])."<br>
			�����: ".stripslashes($estimate_data_array['cat_s_name'])."<br>
			������: ".stripslashes($estimate_data_array['cat_spec_name'])."<br>
			��: ".stripslashes($estimate_data_array['name'])."<br>";
			
		if(!$open_mode)
		{
			$phone = substr_replace(stripslashes($estimate_data_array['phone']) , "****" , 4 , 4);
			$content .= "�����: <font dir=ltr>".stripslashes($phone)."</font><br>";
		}
		else
			$content .= "�����: ".stripslashes($estimate_data_array['phone'])."<br>";
		
		if(!$open_mode)
		{
			$content .= "������: <font dir=ltr>***@****</font><br>";
			
		}
		else{
			$content .= "������: ".stripslashes($estimate_data_array['email'])."<br>";
		}
		
		if(!$open_mode){
			if($leads_settings['freeSend'] == '0' && $leads_settings['open_mode'] == '1' && $leads_settings['autoSendLeadContact'] == '1'){
				$content .= "<br/><div style='color:red;'>
					<b>��� ��.</b><br/>
					����� �� ������ �������� ������ �������� �� ����� ������.
					<br/>
					��� ��� ������ �������.
				</div>";
			}
		}
		$mobile_link = "";
		
		if($insert_array){
			
		
			
			$mobile_link = "
						<a href='https://ilbiz.co.il/myleads/?row_id=".$insert_array['row_id']."&token=".$insert_array['token']."' class='textt' target='_blank'><u>��� ��� ������ ������ ������ ������ ������</u></a><br>
				<br>
				<br>
			";
		}
		else{
			$mobile_link = "
						<a href='https://ilbiz.co.il/myleads/' class='textt' target='_blank'><u>��� ��� ������ ������ ������ ������ ������</u></a><br>
				<br>
				<br>
			";	 		
		}
		/*
		$content .= "���: ".stripslashes($estimate_data_array['city'])."<br>
			�����/�����: <br>".stripslashes($estimate_data_array['note'])."<br><br>
			
			�� ��� ����� ������ ������ �� ����� ������ �����, �� ����� �������� '����� ���� ��� ���'<br>
			<a href='http://www.ilbiz.co.il/ClientSite/administration/index.php?row_id=".$insert_array['row_id']."&token=".$insert_array['token']."' class='textt' target='_blank'><u>������ ����� ��� ���</u></a><br>
			<br>
			<br>
			".$mobile_link."
			�����,<br>
			����� IL-BIZ<BR>
			����� ����� ��������
		";
		*/
		
		$content .= "���: ".stripslashes($estimate_data_array['city'])."<br>
					�����/�����: <br>".stripslashes($estimate_data_array['note'])."<br><br>
					

					<br>
					".$mobile_link."
					�����,<br>
					����� IL-BIZ<BR>
					����� ����� ��������
		";		

		$content_send_to_Client = "
			<html dir=rtl>
			<head>
					<title></title>
					<style>
						.textt{font-family: arial; font-size:12px; color: #000000}
					</style>
			</head>
			
			<body style='direction: rtl; text-align: right;'>
				<p class='textt' dir=rtl align=right>".$content."</p>
			</body>
			</html>";
		$header_send_to_Client= "���� ���� ����� ���� ����";					
		if($send_type == "pending"){
			$fromEmail = str_replace("'","''",$fromEmail);
			$fromTitle = str_replace("'","''",$fromTitle);
			$header_send_to_Client = str_replace("'","''",$header_send_to_Client);
			$content_send_to_Client = str_replace("'","''",$content_send_to_Client);
			$ClientMail = str_replace("'","''",$ClientMail);
			$sql = "INSERT INTO system_pending_email 
							(sendToUnk,fromEmail, fromTitle, header_send_to_Client, content_send_to_Client, ClientMail)
					VALUES	('$sendToUnk','$fromEmail', '$fromTitle', '$header_send_to_Client', '$content_send_to_Client', '$ClientMail')
					";
			$res = mysql_db_query(DB,$sql);
		}
		else{
			GlobalFunctions::send_emails_with_phpmailer($fromEmail, $fromTitle, $header_send_to_Client, $content_send_to_Client, $content_send_to_Client, $ClientMail, $fromTitle );		
		}
	}
	
	public function get_estimate_form_users_info()
	{
		require_once('/home/ilan123/domains/ilbiz.co.il/public_html/global_func/classes/class.shabat.php');
		$shabbat = new Shabbat;
		$is_shabat =  $shabbat->isShabbat();
		$return_info = array();
		/*
		1 - find all users fit to category
		2 - collect id's for 'IN' SQL for all other queries
		3 - find all customers IN sql that fit city
		4 - check passengers
		5 - check other json limitations	
		*/	
		$cat_tree = array('cat_f'=>'0','cat_s'=>'0','cat_spec'=>'0');
		$final_cat = '0';
		if(isset($_POST['cat_f']) && $_POST['cat_f'] != '0' && $_POST['cat_f'] != ''){
			$final_cat = $_POST['cat_f'];
		}		
		if(isset($_POST['cat_s']) && $_POST['cat_s'] != '0' && $_POST['cat_s'] != ''){
			$final_cat = $_POST['cat_s'];
		}
		if(isset($_POST['cat_spec']) && $_POST['cat_spec'] != '0' && $_POST['cat_spec'] != ''){
			$final_cat = $_POST['cat_spec'];
		}
		
		if($final_cat != '0'){
			$cat_tree['cat_f'] = $final_cat;
			
			$sql = "SELECT father FROM biz_categories WHERE id = '".$final_cat."'";
			$res = mysql_db_query(DB, $sql);
			$cat_data = mysql_fetch_array($res);
			
			if($cat_data['father'] == '0' || $cat_data['father'] == ''){
								
			}
			else{
				$cat_tree['cat_f'] = $cat_data['father'];
				$cat_tree['cat_s'] = $final_cat;
				
				$father_cat_1 = $cat_data['father'];				
				$sql = "SELECT father FROM biz_categories WHERE id = '".$cat_tree['cat_f']."'";
				$res = mysql_db_query(DB, $sql);
				$cat_data = mysql_fetch_array($res);
				
				if($cat_data['father'] == '0' || $cat_data['father'] == ''){
					
				}
				else{
					$father_cat_2 = $cat_data['father'];
					$cat_tree['cat_spec'] = $final_cat;
					$cat_tree['cat_s'] = $father_cat_1;
					$cat_tree['cat_f'] = $father_cat_2;				
				}				
			}
		}
		$return_info['selected_cat'] = $final_cat;
		$return_info['cat_tree'] = $cat_tree;
		
		
		//get cat names and ids
		$cat_name = array();
		$cat_father = array();
		$cat_names_sql = "	SELECT id,cat_name,father FROM biz_categories 
							WHERE id IN (
								'".$cat_tree['cat_f']."', 
								'".$cat_tree['cat_s']."', 
								'".$cat_tree['cat_spec']
							."')";
							
		$cat_names_res = mysql_db_query(DB,$cat_names_sql);

		while($cat_names_data = mysql_fetch_array($cat_names_res)){
			$cat_name[$cat_names_data['id']] = $cat_names_data['cat_name'];
			$cat_father[$cat_names_data['id']] = $cat_names_data['father'];
		}


		$return_info['cat_name'] = $cat_name;
		//get cities names
		if( $_POST['Fm_city'] != "" && $_POST['Fm_city'] != "0" )
		{	
			$city_name = array();
			$to_city_id = "";
			if( $_POST['Fm_to_city'] != "" && $_POST['Fm_to_city'] != "0" ){
				$to_city_id = " ,'".$_POST['Fm_to_city']."'";
			}
			$cities_sql = "	SELECT id,name FROM newCities 
							WHERE id IN (
								'".$_POST['Fm_city']."
								'".$to_city_id."
							) ";
			$cities_res = mysql_db_query(DB,$cities_sql);
			while($cities_data = mysql_fetch_array($cities_res)){
				$city_name[$cities_data['id']] = $cities_data['name'];
			}				
		}
		$return_info['city_name'] = $city_name;
		$sql = "SELECT 
					user.id as 'u_id',
					user.unk, 
					user.domain, 
					user.name , 
					user.phone, 
					user.email ,
					u_l_s.* 
				FROM users user
				LEFT JOIN user_lead_settings u_l_s ON u_l_s.unk = user.unk 
				WHERE user.id IN(
					SELECT user_id FROM user_cat WHERE cat_id = '".$final_cat."'
				) 
				AND user.end_date >= NOW() 
				AND user.status = '0'
				AND user.deleted=0";
				//echo "<br/><br/>".$sql."<br/><br/>";
		$res = mysql_db_query(DB, $sql);
		$sent_user_count = 0;
		$users_in_category = array();
		$inSql = "";
		$inSql_i = 0;
		while( $data = mysql_fetch_array($res) )
		{	$data['id'] = $data['u_id'];
			$users_in_category[$data['u_id']] = $data;
			if($inSql_i != 0){
				$inSql .= ", ";
			}
			$inSql .= $data['u_id'];
			$inSql_i++;
		}
		$sql = "SELECT user_id FROM user_lead_cities WHERE user_id IN(".$inSql.") AND (city_id = ".$_POST['Fm_city']." OR city_id = 1) " ;
		$res = mysql_db_query(DB, $sql);
		
		$users_in_city = array();	

		while( $data = mysql_fetch_array($res) )
		{	
			$users_in_city[$data['user_id']] = '1';

		}
		
		
		//see if there are customers that belong to city at specific category
		$c_i = 0;
		$cIn = "";	
		foreach($cat_name as $cat_id=>$name){
			if($c_i!= 0){
				$cIn.=', ';
			}
			$cIn.=$cat_id;
			$c_i++;
		}
		
		$sql = "SELECT user_id FROM user_cat_city WHERE user_id IN(".$inSql.") AND (city_id = ".$_POST['Fm_city']." OR city_id = 1) AND cat_id IN(".$cIn.")" ;
		$res = mysql_db_query(DB, $sql);
		while( $data = mysql_fetch_array($res) )
		{	
			$users_in_city[$data['user_id']] = '2';
		}
		$inSql = "";
		$inSql_i = 0;
		foreach($users_in_city as $user_id=>$u){
			$user = $users_in_category[$user_id]; 
			if($inSql_i != 0){
				$inSql .= ", ";
			}
			$inSql .= $user['unk'];
			$inSql_i++;		
		}
		$unfit_users_passengers = array();
		if( $_POST['Fm_passengers'] != "" )
		{
			//find all un-fit users for passengers number and remove them from array
			$sql = "SELECT * FROM user_lead_more WHERE unk IN(".$inSql.") AND ((from_passenger > ".$_POST['Fm_passengers']." OR until_passenger < ".$_POST['Fm_passengers'].") AND until_passenger != 0) " ;
			$res = mysql_db_query(DB, $sql);		
			while( $data = mysql_fetch_array($res) ){	
				$unfit_users_passengers[$data['unk']] = '1';
			}
		}
		$passengers_users = array();
		foreach($users_in_city as $user_id=>$u){
			$user = $users_in_category[$user_id]; 
			if(!isset($unfit_users_passengers[$user['unk']])){
				$passengers_users[$user_id] = '1';
			}
		}
			
		$users_analysis_arr = array();
		$fit_users = array();
		foreach($users_in_category as $user){
			$analyzed_user = array();
			$analyzed_user['send_final'] = true;
			$analyzed_user['unk'] = $user['unk'];
			$analyzed_user['user_link'] = "<a href='?main=user_profile&unk=".$user['unk']."&record_id=".$user['user_id']."&sesid=".SESID."' target='_NEW' >".$user['name']."</a>";
			$analyzed_user['category_fit'] = true;
			$analyzed_user['city_fit'] = false;
			if(isset($users_in_city[$user['u_id']])){
				$analyzed_user['city_fit'] = true;
			}
			else{
				$analyzed_user['send_final'] = false;
			}
			$analyzed_user['passengers_fit'] = false;
			if(isset($passengers_users[$user['u_id']])){
				$analyzed_user['passengers_fit'] = true;
			}
			else{
				$analyzed_user['send_final'] = false;
			}
			$analyzed_user['is_shabat_user'] = false;
			if($user['shabat_user'] == '1'){
				$analyzed_user['is_shabat_user'] = true;
				if($is_shabat == '1'){
					$analyzed_user['send_final'] = false;
				}
			}			
			$analyzed_user['autoSendLeadContact'] = false;
			if($user['autoSendLeadContact'] == '1'){
				$analyzed_user['autoSendLeadContact'] = true;
			}
			else{
				$analyzed_user['send_final'] = false;
			}		
			$analyzed_user['open_mode'] = false;
			if($user['open_mode'] == '1'){
				$analyzed_user['open_mode'] = true;
			}
			$analyzed_user['leadQry'] = $user['leadQry'];
			$analyzed_user['freeSend'] = false;
			if($user['freeSend'] == '1'){
				$analyzed_user['freeSend'] = true;
			}		
			$analyzed_user['havaSms'] = false;
			if($user['havaSms'] == '1'){
				$analyzed_user['havaSms'] = true;
			}
			$analyzed_user['haveContact'] = false;
			if($user['haveContact'] == '1'){
				$analyzed_user['haveContact'] = true;
			}
			$open_mode_final = false;
			if($user['open_mode']>0){ 
				if($user['leadQry']>0){
					$open_mode_final = true;
				}
				else{
					if($user['freeSend']>0){
						$open_mode_final = true;
					}								
				}							
			}		
			$analyzed_user['open_mode_final'] = $open_mode_final;
			$users_analysis_arr[$user['u_id']] = $analyzed_user;
			if($analyzed_user['send_final'] == true){
				$fit_users[$user['u_id']] = '1';
			}
		}

		/* ------ start rotation between users here ----- */
		/* ------ order users by priority and take the first x ----- */

		
		$inSql = "";
		$inSql_i = 0;
		foreach($fit_users as $uid=>$user){
			if($inSql_i != 0){
				$inSql .= ", ";
			}
			$inSql .= $uid;
			$inSql_i++;		
		}	
		$sql = "SELECT 
					*,
					IF(last_update < CAST( DATE_FORMAT( NOW( ) ,  '%Y-%m-01' ) AS DATE ), 1, 0) as reset_user 
				FROM user_lead_rotation WHERE user_id IN(".$inSql.") 
				ORDER BY user_order";
		if(isset($_REQUEST['update_demo_rotation_db'])){
			$sql = str_replace('user_lead_rotation','user_lead_rotation_demo',$sql);
		}		
		$res = mysql_db_query(DB, $sql);
		$order_users_table = array();
		$reset_users = array();
		$users_by_priority_1 = array();
		while( $data = mysql_fetch_array($res) )
		{
			$order_users_table[$data['user_id']] = '1';
			if($data['reset_user'] == '1'){
				$reset_users[$data['user_id']] = '1';
				$users_by_priority_1[] = $data['user_id'];
			}
		}
		$insert_users = array();
		foreach($fit_users as $uid=>$user){
			if(!isset($order_users_table[$uid])){
				$insert_users[$uid] = '1';
				$users_by_priority_1[] = $uid;
			}	
		}
		$update_users = array();
		foreach($order_users_table as $uid=>$user){
			if(!isset($reset_users[$uid])){
				$users_by_priority_1[] = $uid;
				$update_users[$uid] = '1';
			}	
		}

		foreach($users_by_priority_1 as $order=>$user_id){
			$users_analysis_arr[$user_id]['order'] = $order;
			$users_analysis_arr[$user_id]['got_in_priority'] = false;
		}
		
		$max_users_to_send = 100;
		$max_leads_sql = "	SELECT cf.max_lead_send as 'max_f',cs.max_lead_send as 'max_s',cspec.max_lead_send as 'max_spec' 
							FROM biz_categories cspec 
							LEFT JOIN biz_categories cs ON cspec.father = cs.id 
							LEFT JOIN biz_categories cf ON cs.father = cf.id 						
							WHERE cspec.id = ".$final_cat."";
					
		$max_leads_res = mysql_db_query(DB, $max_leads_sql);
		$data = mysql_fetch_array($max_leads_res);					
		if($data['max_f'] != "" && $data['max_f'] != "0"){
			$max_users_to_send = $data['max_f'];
		}
		if($data['max_s'] != "" && $data['max_s'] != "0"){
			$max_users_to_send = $data['max_s'];
		}
		if($data['max_spec'] != "" && $data['max_spec'] != "0"){
			$max_users_to_send = $data['max_spec'];
		}
		
		$max_days_in_month=date('t');
		$max_hours_in_month=$max_days_in_month * 24;
		$current_day_of_month=date('j');
		$current_hour_of_day = date('H');	
		$current_hour_of_month = (($current_day_of_month - 1)*24) +  $current_hour_of_day + 1;

		$users_by_priority_2 = array();
		$users_by_end_priority = array();
		$limit_users = array();
		

		
		foreach($users_by_priority_1 as $uid){
			$user = $users_in_category[$uid];
			if($user['max_leads_per_month'] == "" || $user['max_leads_per_month'] == "0"){
				$users_by_priority_2[] = $uid;
				continue;
			}
			$max_leads_per_month_update = $user['max_leads_per_month'];
			$users_analysis_arr[$uid]['max_leads_per_month'] = $user['max_leads_per_month'];
			
			
			$sql = "SELECT *,
					IF(last_update < CAST( DATE_FORMAT( NOW( ) ,  '%Y-%m-01' ) AS DATE ), 1, 0) as reset_user 
					FROM user_leads_limit WHERE user_id = ".$uid."";
			if(isset($_REQUEST['update_demo_rotation_db'])){
				$sql = str_replace('user_leads_limit','user_leads_limit_demo',$sql);
			}				
			$res = mysql_db_query(DB, $sql);
			$data = mysql_fetch_array($res);
			$user_limit_update = $data;
			$user_limit_update['original_data'] = $data;
			$user_limit_update['last_update'] = " NOW() ";
			if(!isset($data['user_id'])){
				$sql = "INSERT INTO user_leads_limit(user_id,last_update,month_limit,month_recived,spares,spares_recived)
						VALUES(".$uid.",NOW(),".$max_leads_per_month_update.",0,0,0)";		
				if(isset($_REQUEST['update_demo_rotation_db'])){
					$sql = str_replace('user_leads_limit','user_leads_limit_demo',$sql);
				}		
				$res = mysql_db_query(DB, $sql);
				$user_limit_update['status'] = 'new';
				$user_limit_update['month_limit'] = $max_leads_per_month_update;
				$user_limit_update['month_recived'] = '1';
				$user_limit_update['spares'] = '0';
				$user_limit_update['spares_recived'] = '0';
				$limit_users[$uid] = $user_limit_update;
				$users_by_priority_2[] = $uid;
				$users_analysis_arr[$uid]['deserve_lead'] = true;			
				continue;
			}

			$users_analysis_arr[$uid]['month_leads_registered'] = $data['month_recived'];	
			$users_analysis_arr[$uid]['spares'] = $data['spares'];
			$users_analysis_arr[$uid]['spares_recived'] = $data['spares_recived'];	
			$users_analysis_arr[$uid]['deserve_lead'] = false;
			//new,reset_with_spares,reset
			if($data['reset_user'] == '1'){
				$last_month_spares = $user_limit_update['month_limit'] - $data['month_recived'];
				$update_spares = $last_month_spares;
				$user_limit_update['month_limit'] = $max_leads_per_month_update;
				if($data['spares'] != "" && $data['spares'] != "0"){
					$update_spares += $data['spares'];
					$user_limit_update['status'] = 'reset_with_spares';
					
				}
				else{
					$user_limit_update['status'] = 'reset';
				}
				if($update_spares > 0){
					$user_limit_update['spares_recived'] += 1;
					$user_limit_update['spares'] = $update_spares - 1;
					$user_limit_update['month_recived'] = '0';
				}
				else{
					$user_limit_update['spares_recived'] = '0';
					$user_limit_update['spares'] = '0';
					$user_limit_update['month_recived'] = '1';
				}
				$limit_users[$uid] = $user_limit_update;
				$users_by_priority_2[] = $uid;
				$users_analysis_arr[$uid]['spares'] = $update_spares;
				$users_analysis_arr[$uid]['month_leads_registered'] = '0';
				$users_analysis_arr[$uid]['deserve_lead'] = true;
				continue;			
			}
			
			
			
			if($data['spares'] != "" && $data['spares'] != "0"){
				$user_limit_update['status'] = 'use_spare';
				$user_limit_update['spares'] = $user_limit_update['spares'] - 1;
				$user_limit_update['spares_recived'] = $user_limit_update['spares_recived'] + 1;
				$limit_users[$uid] = $user_limit_update;
				$users_analysis_arr[$uid]['deserve_lead'] = true;
				$users_by_priority_2[] = $uid;
				
				continue;			
			}
			
			$user_limit_update['status'] = 'update';
			$user_limit_update['month_recived'] += 1;
			//user suppose to get X leads by now. x = $current_preiod_max_leads
			$hour_preiod_per_lead = $max_hours_in_month/$user_limit_update['month_limit'];
			$current_preiod_max_leads = intval($current_hour_of_month/$hour_preiod_per_lead)+1;
			$users_analysis_arr[$uid]['current_preiod_max_leads'] = $current_preiod_max_leads;
			//todo: check if user is limited leads per month
			if($current_preiod_max_leads > $data['month_recived']){
				$limit_users[$uid] = $user_limit_update;
				$users_analysis_arr[$uid]['deserve_lead'] = true;
				$users_by_priority_2[] = $uid;
				continue;	
			}
			else{
				//check if limit is final or push user to end of line
				if($user['allow_more_then_max'] == '1'){
					$limit_users[$uid] = $user_limit_update;
					$users_by_end_priority[] = $uid;
					$users_analysis_arr[$uid]['push_to_end'] = true;
					continue;
				}
			}
		}
		$users_by_priority_final = array();
		$users_by_priority_pending = array();
		foreach($users_by_priority_2 as $uid){
			$users_by_priority_pending[] = $uid;
		}
		foreach($users_by_end_priority as $uid){
			$users_by_priority_pending[] = $uid;
		}		
		$users_by_hours_send = array();
		$users_by_hours_pending = array();
		foreach($users_by_priority_pending as $uid){
			$user_unk = $users_in_category[$uid]['unk'];
			$user_lead_send_hours_sql = "SELECT * FROM user_lead_send_hours WHERE unk = '$user_unk'";
			$user_lead_send_hours_res = mysql_db_query(DB,$user_lead_send_hours_sql);
			$user_lead_send_hours_data = mysql_fetch_array($user_lead_send_hours_res);
			$user_send_lead_type = "send";
			if($user_lead_send_hours_data['display'] == "1"){
				$time_groups = json_decode($user_lead_send_hours_data['time_groups'],true);
				$wday = date('w');
				$now_day = $wday+1;
				$hour = date('H');
				$minute = date('i');
				$fit_time_found = false;
				foreach($time_groups as $time_group){
					if($fit_time_found){
						continue;
					}
					if(in_array($now_day,$time_group['cd'])){
						$time_off = false;
						if($hour < $time_group['hf']){
							$time_off = true;
						}
						elseif($hour == $time_group['hf']){
							if($minute < $time_group['mf']){
								$time_off = true;
							}
						}
						if(!$time_off){
							if($hour > $time_group['ht']){
								$time_off = true;
							}
							elseif($hour == $time_group['ht']){
								if($minute > $time_group['mt']){
									$time_off = true;
								}									
							}
						}
						if(!$time_off){
							$fit_time_found = true;
						}
					}
				}
				if(!$fit_time_found){
					$user_send_lead_type = "pending";
				}				
			}

			if($user_send_lead_type == "send"){
				$users_by_hours_send[] = array("uid"=>$uid,"send_type"=>$user_send_lead_type);
			}
			else{
				$users_by_hours_pending[] = array("uid"=>$uid,"send_type"=>$user_send_lead_type);
			}
		}
		$users_send_open_mode = array();
		$users_send_close_mode = array();
		
		foreach($users_by_hours_send as $user_send){
			if($users_analysis_arr[$user_send['uid']]['open_mode_final']){
				$users_send_open_mode[] = $user_send;
			}
			else{
				$users_send_close_mode[] = $user_send;
			}
		}
		foreach($users_by_hours_pending as $user_send){
			if($users_analysis_arr[$user_send['uid']]['open_mode_final']){
				$users_send_open_mode[] = $user_send;
			}
			else{
				$users_send_close_mode[] = $user_send;
			}
		}

		
		foreach($users_send_open_mode as $user_send){
			$users_by_priority_final[] = $user_send;
		}
		foreach($users_send_close_mode as $user_send){
			$users_by_priority_final[] = $user_send;
		}		
		$update_sqls = array();
		$final_users_send_list = array();
		for($i = 0; $i < $max_users_to_send && $i < count($users_by_priority_final) ; $i++){
			$user_send = $users_by_priority_final[$i];
			$uid = $user_send['uid'];
			$users_analysis_arr[$uid]['got_in_priority'] = true;
			$users_analysis_arr[$uid]['send_type'] = $user_send['send_type'];
			$final_users_send_list[$uid] = $users_in_category[$uid];
			if(isset($limit_users[$uid])){
				$limit_user = $limit_users[$uid];
				$sql = "UPDATE user_leads_limit SET 
				last_update = ".$limit_user['last_update'].", 
				month_limit = ".$limit_user['month_limit'].", 
				month_recived = ".$limit_user['month_recived'].", 
				spares = ".$limit_user['spares'].", 
				spares_recived = ".$limit_user['spares_recived']."
				WHERE user_id =  ".$uid."";
				$update_sqls[] = $sql;
			}
		}
		
		foreach($insert_users as $uid=>$u){
			$user = $users_in_category[$uid];
			$leads_recived = "0";
			$user_order = "0";
			if($users_analysis_arr[$uid]['got_in_priority']){
				$order_points_per_lead = 100;
				if($user['precent_priority'] != "" && $user['precent_priority'] != "0"){
					$order_points_per_lead = 100 - $user['precent_priority'];
				}
				$leads_recived = "1";
				$user_order = $order_points_per_lead;
			}
			$sql = "INSERT INTO user_lead_rotation(user_id,	last_update,leads_recived,user_order) VALUES(".$uid.",NOW(),".$leads_recived.",".$user_order.")";
			$update_sqls[] = $sql;
		}


		foreach($reset_users as $uid=>$u){
			if(!$users_analysis_arr[$uid]['got_in_priority']){
				continue;
			}
			$user = $users_in_category[$uid];		
			$order_points_per_lead = 100;
			if($user['precent_priority'] != "" && $user['precent_priority'] != "0"){
				$order_points_per_lead = 100 - $user['precent_priority'];
			}
			$leads_recived = "1";
			$user_order = $order_points_per_lead;
			
			$sql = "UPDATE user_lead_rotation SET last_update = NOW(), leads_recived = ".$leads_recived.",user_order = ".$user_order." WHERE user_id = ".$uid."";
			$update_sqls[] = $sql;
		}

		foreach($update_users as $uid=>$u){
			if(!$users_analysis_arr[$uid]['got_in_priority']){
				continue;
			}
			$user = $users_in_category[$uid];		
			$order_points_per_lead = 100;
			if($user['precent_priority'] != "" && $user['precent_priority'] != "0"){
				$order_points_per_lead = 100 - $user['precent_priority'];
			}
			$leads_recived = "leads_recived + 1";
			$user_order = " user_order + ".$order_points_per_lead." ";
			
			$sql = "UPDATE user_lead_rotation SET last_update = NOW(), leads_recived = ".$leads_recived.",user_order = ".$user_order." WHERE user_id = ".$uid."";
			$update_sqls[] = $sql;
		}	
		
		
		foreach($update_sqls as $sql){
			if(isset($_REQUEST['update_demo_rotation_db'])){
				$sql = str_replace('user_lead_rotation','user_lead_rotation_demo',$sql);
				$sql = str_replace('user_leads_limit','user_leads_limit_demo',$sql);
			}
			
			$res = mysql_db_query(DB, $sql);	
		}
		
		$return_info['users_analysis_arr'] = $users_analysis_arr;
		$return_info['final_users_send_list'] = $final_users_send_list;
		return $return_info;
	}	
	
} 

?>