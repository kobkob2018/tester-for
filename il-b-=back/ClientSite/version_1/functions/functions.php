<?php
function get_content($m)	{
	ob_start();
	switch($m)	{
		
		## --------- Genral
		case "text" :			echo get_text_area($_GET['t']);		break;
		
		## --------- Contacts
		case "contact" :		echo contact();						break;
		case "co" :		echo contact();						break;
		case "insert_contact" :	echo insert_contact();				break;
		case "get_thanks" :		echo get_thanks();					break;
		
		## --------- Articles
		case "articels" : 		echo articels(); 					break;
		case "ar" : 		echo articels(); 					break;
		case "arLi" : 		echo articelsList(); 					break;
		
		## --------- jobs
		case "jobs" : 			echo jobs(); 						break;
		case "jo" : 			echo jobs(); 						break;
		
		## --------- yad2
		case "yad2" : 			echo yad2();						break;
		case "s_yad2" :			echo s_yad2();						break;
		case "ya" : 			echo yad2();						break;
		case "s.ya" :			echo s_yad2();						break;
		
		## --------- sales
		case "sales" :			echo sales();						break;
		case "s_sales" :		echo s_sales();						break;
		case "sa" :			echo sales();						break;
		case "s.sa" :		echo s_sales();					break;
		
		## --------- products
		case "products" :		echo products();					break;
		case "s_products" :		echo s_products();					break;
		case "pr" :		echo products();					break;
		case "s.pr" :		echo s_products();					break;
		
		## --------- gallery
		case "gallery" :		echo gallery();						break;
		case "ga" :		echo gallery();						break;
		
		## --------- video
		case "video" :			echo video();						break;//**
		case "s_video" :		echo s_video();						break;
		case "vi" :			echo video();						break;
		case "s.vi" :		echo s_video();						break;
		
		## --------- search
		case "search" :			echo search();						break;
		
		## --------- NewsLetter
		case "add_mail_1" :		echo add_mail_1();					break;
		
		## --------- HP_CONF
		case "hp" :						echo hp();								break;
		
		## --------- gest book
		case "gb" :						echo gb();								break;//**
		case "insert_gb_response" :		echo insert_gb_response();		break;
		
		
		## --------- N E T 
		case "regNetF" :									echo register_net_form();										break;
		case "regNetF_DB" :								echo register_net_form_DB();								break;
		case "regNetF2" :									echo register_net_form2();									break;
		case "regNetF2_DB" :							echo register_net_form2_DB();								break;
		case "net_mail_verOK" :						echo net_mail_verOK();											break;
		case "regNetF_thx" :							echo register_net_form_thx();								break;
		case "NetMess" : 
			if($_COOKIE['net_user_s'] != ""){
				echo user_cpanel();
			}
			else{
				echo net_messages_list();
			}			
			
			
		
		break;
		case "NetPass" :								echo net_forget_password();									break;
		case "NetPass_AC" :								echo net_forget_password_AC();							break;
		case "NetPass_VR" :								echo net_forget_password_verify();					break;
		case "NetProfile" :								echo NetProfile();													break;
		case "NetLoginForms" :							echo NetLoginForms();													break;
		case "net_mail_remove" :					echo net_mail_remove();											break;
		case "net_mail_removeChossen" :		echo net_mail_removeChossen();							break;

		//user_cpanel
		
		case "getConnectedByLogin" :		echo getConnectedByLogin();		break;
		case "register_to_10service_DB" :		echo register_to_10service_DB();		break;
		
		case "logOut" :		echo logOut();		break;	
		case "user_cpanel" :									if( AUTH_ID == 0 ) echo user_cpanel();									break;
		case "user_cpanel__updateD" :					if( AUTH_ID == 0 ) echo user_cpanel__updateD();	break;
		
		## --------- E-COM
		case "ecom_form" :						echo ecom_form_step_1();								break;
		case "ecom_form2" :						echo ecom_form_step_2();								break;
		case "add_new_reg_client" :						echo add_new_reg_client();								break;
		case "add_order_to_DB" :						echo add_order_to_DB();								break;
		case "get_thanks_ecom_form" :						echo get_thanks_ecom_form();								break;
		case "get_thanks_paypal__ktarim" :						echo get_thanks_paypal__ktarim();								break;
		case "get_thanks_paypal__shangola" :						echo get_thanks_paypal__shangola();								break;
		case "get_thanks_paypalJewelry" :						echo get_thanks_paypalJewelry();								break;
		case "ecom_new_buy_DB" :						echo ecom_new_buy_DB();								break;
		
		## --------- Calendar
		case "calendar_events" :						echo calendar_events();								break;
		
		case "castum_frame" :						echo castum_frame();								break;
		
		
		/*
			10 service site only !
			all the function will be at servise10_fucntions.php
		*/
		case "home" :		echo servise10__cats_list();		break;
		case "subC" :		echo servise10__cats_list("cats");		break;
		
		
		## --------- Castum
		case "KgBm" :									echo kolaNegev_guide_biz();								break;
		case "KgBm_p" :								echo kolaNegev_guide_biz_profile();				break;
		case "KgAdG" :								echo kolaNegev_guideAddNew();							break;
		case "KgAdGU" :								echo kolaNegev_guideAddNew_DB();					break;
		case "KgAdGT" :								echo kolaNegev_guideAddNew_thanks();			break;
		case "Kghp" :									echo kolaNegev_guides_homepage();					break;
		case "startup7_Cform" :				echo startup7_Cform();										break;
		case "startup7_Cform_Reg" :		echo startup7_Cform_Reg();								break;
		case "startup7_Cform_Thx" :		echo startup7_Cform_Thx();								break;
		
		## --------- Castum 2
		case "amuta_fmn__reg" :				echo amuta_fmn__registerForm();						break;
		case "amuta_fmn__regGET" :		echo GET_amuta_fmn__registerForm();				break;
		case "amuta_fmn__regTX" :			echo amuta_fmn__registerFormThanks();			break;
		case "amuta_fmn__thanks" :			echo amuta_fmn__thanks();			break;
		case "einYahav_price_page" :			echo einYahav_price_page();			break;
		case "einYahav_login_page" :			echo einYahav_login_page();			break;
		
		
		## --------- functions_12.php
		case "zoom_gallery" :			echo zoom_gallery();			break;
		
		## --------- functions_14.php
		case "realty" :			echo realty();			break;
		case "work_contract_form" :	
			require_once("/home/ilan123/domains/ilbiz.co.il/public_html/ClientSite/version_1/functions/contract_functions.php"); 
			work_contract_form();	
		break;		
		case "work_contract" :	
			require_once("/home/ilan123/domains/ilbiz.co.il/public_html/ClientSite/version_1/functions/contract_functions.php"); 
			create_contract_pdf();	
		break;
		case "work_contract_find" :	
			require_once("/home/ilan123/domains/ilbiz.co.il/public_html/ClientSite/version_1/functions/contract_functions.php"); 
			work_contract_find();	
		break;
	}
	$text_content = ob_get_clean();
	global $data_name;
	if(isset($data_name['phone_to_show'])){
		$text_content = str_replace("{{cat_phone}}",$data_name['phone_to_show'],$text_content);
	}
	else{
		$text_content = str_replace("{{cat_phone}}","",$text_content);
	}
	echo $text_content;
}
/***************************************************************************************************/

function get_text_area($type="")	{

	global $data_extra_settings;
	
	if( $type != "" )
	{
		$sql = "select * from content_pages where unk = '".UNK."' and type = '".$type."' and deleted = '0'";
		$res = mysql_db_query(DB,$sql);
		$data = mysql_fetch_array($res);
	}
	else
	{
		if( isset($_GET['lib']) )
		{
			$qry = "SELECT * FROM content_pages WHERE deleted=0 AND lib=".ifint($_GET['lib'])." AND unk = '".UNK."' ORDER BY id LIMIT 1";
			$res = mysql_db_query( DB , $qry );
			$data = mysql_fetch_array($res);
			$_GET['t'] = $data['id'];
			
		}
	}
	
	echo "<table border=\"0\" cellspacing=\"0\" cellpadding=\"0\" class=\"maintext main_content_wrap_table\">";
			if( isset($_GET['t']) && $data_extra_settings['estimateSite'] != "1" )
			{
				$qry = "SELECT defualt_show_libs_options,active FROM user_text_libs WHERE id = '".ifint($data['lib'])."' AND unk = '".UNK."'";
				$LibsConf = mysql_db_query( DB , $qry );
				$dataConf = mysql_fetch_array($LibsConf);
				
				if( ($dataConf['defualt_show_libs_options'] == "0" || isset($_GET['la']) == "1" ) && $dataConf['active'] == "1" )
				{
					$myCurrectLib = ( isset($_GET['lib']) ) ? $_GET['lib'] : $data['lib'];
					
					$qry = "SELECT id, lib_name FROM user_text_libs WHERE deleted=0 AND active=1 AND unk = '".UNK."'";
					$LibsList = mysql_db_query( DB , $qry );
					$LibsList_num_rows = mysql_num_rows($LibsList);
					
					
					echo "<tr>";
						echo "<td>";
						
						echo "<table border=\"0\" cellspacing=\"0\" cellpadding=\"0\" class=\"maintext\">";
						echo "<form action='index.php' method='GET' name='selectLibForm'>
						<input type='hidden' name='m' value='text'>
						<input type='hidden' name='t' value=''>
						<input type='hidden' name='la' value='".$_GET['la']."'>";
						
						if( $LibsList_num_rows > 1 )
						{
							echo "<tr>
								<td>
									<select name='lib' class='input_style' onchange=\"selectLibForm.submit()\" style='height: 18px;'>";
										while( $dataLibs = mysql_fetch_array($LibsList) )
										{
											$selected = ( $myCurrectLib == $dataLibs['id'] ) ? "selected" : "";
											
											echo "<option value='".stripslashes($dataLibs['id'])."' ".$selected.">".stripslashes($dataLibs['lib_name'])."</option>";
										}
									echo "</select>
								</td>
							</tr>
							<tr><td height=15></td></tr>";
						}
						
						echo "<tr>
							<td>";
								
								$qry = "SELECT name, id FROM content_pages WHERE deleted=0 AND lib=".ifint($myCurrectLib)." AND unk = '".UNK."' ORDER BY id";
								$contentSubjectList_res = mysql_db_query( DB , $qry );
								$contentSubjectList_nums = mysql_num_rows($contentSubjectList_res);
								
								$counter = 0;
								if( $contentSubjectList_nums > 1 )
								{
									while( $contentSubjectList = mysql_fetch_array($contentSubjectList_res) )
									{
										if( $counter == 0 )
											$new_type = $contentSubjectList['id'];
										
											
										$bStart = ( $_GET['t'] == $contentSubjectList['id'] ) ? "<b>" : "<a href='index.php?m=text&t=".$contentSubjectList['id']."&lib=".$myCurrectLib."&la=".$_GET['la']."' class='maintext'>";
										$bEnd = ( $_GET['t'] == $contentSubjectList['id'] ) ? "</b>" : "</a>";
										
										echo $bStart." ".stripslashes($contentSubjectList['name'])." ".$bEnd." | ";
										$counter++;
									}
								}
							echo "</td>
						</tr>
						
						<tr><td height=20></td></tr>
						
						</form>
						</table>
						</td>";
					echo "</tr>";
				}
				
			}
		
		$content = string_rplace_func($data['content']);
		if(HTTP_S == "https"){
			$domain = $_SERVER['HTTP_HOST'];
			$change_path = $domain."/upload_pics/";
			$change_path_search = "http://".$change_path;
			$change_path_replace = "https://".$change_path;
			$content = str_replace($change_path_search,$change_path_replace,$content);
		}
		$str_content_view = "<tr>";
				$str_content_view .= "<td>".stripslashes($content)."</td>";
		$str_content_view .= "</tr>";
		
		$view_it = 0;
		
				/*
				if( $data_extra_settings['estimateSite'] == "1" )
				{
						echo "<tr>";
							echo "<td>".estimate_site_main_block($type)."</td>";
						echo "</tr>";
				}
				*/
				
				if( $view_it == 0 )
				{
					echo $str_content_view;
				}
				
			
			if( $data['mailing_id'] != "" && $data['mailing_id'] != "0" )
			{
				echo "<tr>";
					echo "<td>";
						echo "<iframe src ='http://www.ilbiz.co.il/newsite/net_system/netMailing.php?unk=".UNK."&amp;mailing_id=".$data['mailing_id']."&amp;td=".$data['id']."' width='480' height='200' id='loginPage2' frameborder=0 scrolling=no allowtransparency='true'></iframe>";
					echo "</td>";
				echo "</tr>";
			}

		
	echo "</table>";
}

/***************************************************************************************************/

function contact($type="")
{
	global $word;
	$_SESSION['user_contact_form'] = "";
	
	/*$_SESSION['user_contact_form']['unk'] = "asc".rand(10000,15000);
	$_SESSION['user_contact_form']['name'] = "ged".rand(15000,20000);
	$_SESSION['user_contact_form']['email'] = "pok".rand(20000,25000);
	$_SESSION['user_contact_form']['phone'] = "ujk".rand(25000,3000);
	$_SESSION['user_contact_form']['mobile'] = "bht".rand(30000,35000);
	$_SESSION['user_contact_form']['content'] = "gdv".rand(40000,45000);
	$_SESSION['user_contact_form']['date_in'] = "cve".rand(45000,50000);
	$_SESSION['user_contact_form']['subject_id'] = "sbd".rand(50000,55000);
	*/
	$_SESSION['user_contact_form']['unk'] = "unk";
	$_SESSION['user_contact_form']['name'] = "name";
	$_SESSION['user_contact_form']['email'] = "email";
	$_SESSION['user_contact_form']['phone'] = "phone";
	$_SESSION['user_contact_form']['mobile'] = "mobile";
	$_SESSION['user_contact_form']['content'] = "content";
	$_SESSION['user_contact_form']['date_in'] = "date_in";
	$_SESSION['user_contact_form']['subject_id'] = "subject_id";
	
	
	$sql_Subs = "SELECT id, subject FROM user_contact_subjects WHERE deleted=0 AND unk = '".UNK."' ";
	$res_Subs = mysql_db_query(DB, $sql_Subs) ;
	$nums_Subs = mysql_num_rows($res_Subs); 
	
	if( $nums_Subs > 0 )
	{
		while( $dataSubs = mysql_fetch_array($res_Subs) )
		{
			$data_id = $dataSubs['id'];
			$subject_idArr[$data_id] = stripslashes($dataSubs['subject']);
		}
		
		$subject_id = array("select","subject_id[]",$subject_idArr,"נושא",$data['subject_id'],$_SESSION['user_contact_form']['subject_id'], "class='input_style' style='height: 18px;'");
	}
	
	$captchaArr = captchaNum1();
		
	$sql = "select * from content_pages where unk = '".UNK."' and type = 'contact' and deleted = '0'";
	$res = mysql_db_query(DB,$sql);
	$data = mysql_fetch_array($res);
	
	$form_arr = array(
		array("hidden","m","insert_contact"),
		array("hidden",$_SESSION['user_contact_form']['unk'],UNK),
		array("hidden","record_id",$_REQUEST['row_id']),
		array("hidden","ra45",md5($captchaArr['random'])),
		
		array("text",$_SESSION['user_contact_form']['name'],"","* ". $word[LANG]['1_1_contact_full_name'].":", "class='input_style' style='height: 18px;'","","1"),
		array("text",$_SESSION['user_contact_form']['email'],"","* ". $word[LANG]['1_1_contact_email'].":", "class='input_style' style='height: 18px;'","","1"),
		array("text",$_SESSION['user_contact_form']['phone'],"","* ".$word[LANG]['1_1_contact_phone'].":", "class='input_style' style='height: 18px;'","","1"),
		//array("text",$_SESSION['user_contact_form']['mobile'],"",$word[LANG]['1_1_contact_cell'].":", "class='input_style' style='height: 18px;'","","1"),
		$subject_id,
		array("textarea",$_SESSION['user_contact_form']['content'],"","* ". $word[LANG]['1_1_contact_text'].":", "class='input_style' style='width: 300px; height: 100px;'"),
		
		array("hidden",$_SESSION['user_contact_form']['date_in'],GlobalFunctions::get_timestemp(),$word[LANG]['1_1_contact_date'], "class='input_style'"),
		
		array("free_row","<img src='data:image/gif;base64,".$captchaArr['img']."' border='0'>","",$word[LANG]['1_1_contact_captcha_img']),
		array("text",'checkcode',"","* ". $word[LANG]['1_1_contact_captcha_checkcode'].":", "class='input_style' style='height: 18px;'","","1"),
		 
		array("submit","submit",$word[LANG]['1_1_contact_send'], "class='submit_style'")
	);
	
	$more = "class='maintext'";
	
	$mandatory_fields = array($_SESSION['user_contact_form']['name'],$_SESSION['user_contact_form']['email'],$_SESSION['user_contact_form']['phone'],$_SESSION['user_contact_form']['content']);
	$get_form = FormCreator::create_form($form_arr,"index.php", $more , $mandatory_fields );
	
	echo "<table border=\"0\" cellspacing=\"0\" cellpadding=\"0\" class=\"maintext\">";
		
		if( $type == "" )
		{
			$content = string_rplace_func($data['content']);
			
			echo "<tr>";
				echo "<td>".stripslashes($content)."</td>";
			echo "</tr>";
			echo "<tr><td height=\"10\"></td></tr>";
		}
		echo "<tr>";
			echo "<td>".$get_form."</td>";
		echo "</tr>";
		
	echo "</table>";
}
/***************************************************************************************************/

function insert_contact()	{

global $data_name,$word,$settings;

	$sql = "select * from user_lead_settings where unk = '".UNK."'";
	$res_lead_settings = mysql_db_query(DB,$sql);
	$user_lead_settings = mysql_fetch_array($res_lead_settings);
	//$data_arr = ($_POST['data_arr'])? $_POST['data_arr'] : $_GET['data_arr'];
	
	$unk = $_SESSION['user_contact_form']['unk'];
	$name = $_SESSION['user_contact_form']['name'];
	$email = $_SESSION['user_contact_form']['email'];
	$phone = $_SESSION['user_contact_form']['phone'];
	$mobile = $_SESSION['user_contact_form']['mobile'];
	$content = $_SESSION['user_contact_form']['content'];
	$date_in = $_SESSION['user_contact_form']['date_in'];
	$subject_id = $_SESSION['user_contact_form']['subject_id'];
	
	$data_arr['unk'] = $_POST["unk"];
	$data_arr['name'] = $_POST["name"];
	$data_arr['email'] = $_POST["email"];
	$data_arr['phone'] = $_POST["phone"];
	$data_arr['mobile'] = $_POST["mobile"];
	$data_arr['content'] = $_POST["content"];
	$data_arr['date_in'] = $_POST["date_in"];
	$data_arr['subject_id'] = $_POST["subject_id"];
	
	if($user_lead_settings['open_mode']>0){
		if($user_lead_settings['leadQry']>0){
			$data_arr['payByPassword'] = '1';
		}
		else{
			if($user_lead_settings['freeSend']>0){
				$data_arr['payByPassword'] = '1';
			}								
		}							
	}

	if( $_POST['ext'] != '1' )
	{
		if (md5(trim($_POST['checkcode'])) != $_POST['ra45'] ) {
			echo "<script>alert('".$word[LANG]['1_1_contact_captcha_worng']."');</script>";
			echo "<script>window.location.href='javascript:history.back(-1)';</script>";
				exit;
		}
	}
	else
	{
		$data_arr['date_in'] = date("Y-m-d H:i:s");
	}
	
	if( $data_arr['date_in'] != "0000-00-00 00:00:00" )
	{
		if( !empty($data_arr['name']) && !empty($data_arr['email']) )
		{
			
			if( UNK == "654462387874498781" || UNK == "663111052427689836" )
				$goto = "http://www.shalevclinic.com/index.php?m=text&t=19821";
			else
				$goto = "index.php?m=get_thanks&type=get_thx_contact";
			
			$image_settings = array(
				"after_success_goto" => $goto,
				"table_name" => "user_contact_forms",
			);
		
		$sql_Subs = "SELECT id, subject FROM user_contact_subjects WHERE deleted=0 AND unk = '".UNK."' AND id = '".$data_arr['subject_id']."' ";
		$res_Subs = mysql_db_query(DB, $sql_Subs) ;
		$dataSubs = mysql_fetch_array($res_Subs);
		
		
		$sql = "select id from users where unk = '".UNK."' AND end_date < NOW() ";
		$res_ENDDate = mysql_db_query(DB,$sql);
		$data_ENDDate = mysql_fetch_array($res_ENDDate);
		
		if( $data_ENDDate['id'] == "" )
		{
			$subDataExist = ( $dataSubs['subject'] != "" ) ? "נושא: ". stripslashes($dataSubs['subject'])."<br>" : "" ;
			
			$msg2 = "
			<table width=\"600\" border=\"0\" cellspacing=\"1\" cellpadding=\"1\" dir=\"".$settings['dir']."\">
			  <tr>
			    <td style='font-family:arial; font-size: 12px; color: #000000;'>קיבלתם הודעה חדשה דרך צור קשר באתרכם,<br>
			    להלן ההודעה שהתקבלה:<br><br>
			    שם מלא: ".$data_arr['name']."<br>
			    דואר אלקטרוני: ".$data_arr['email']."<br>
			    טלפון: ".$data_arr['phone']." ".$data_arr['mobile']."<br><br>
			    ".$subDataExist."
			    הערות ובקשות: ".nl2br($data_arr['content'])."<br><br>
			    האימייל נשלח אוטומטית,<br>
			    יש להכנס למערכת הניהול של האתר ולעדכן את סטטוס הטיפול של ההודעה <br>
			    <a href='http://www.ilbiz.co.il/ClientSite/administration/login.php' style='font-family:arial; font-size: 12px; color: #000000;' target='_blank'><u>למערכת ניהול לחץ כאן</u></a><br><br>
			    בברכה,<br>
			    איי אל ביז קידום עסקים באינטרנט בע''מ</td>
			  </tr>
			</table>";
		}
		else
		{
			$msg2 = "
			<table width=\"600\" border=\"0\" cellspacing=\"1\" cellpadding=\"1\" dir=\"".$settings['dir']."\">
			  <tr>
			    <td style='font-family:arial; font-size: 12px; color: #000000;'>".$word[LANG]['1_1_send_contact_email']."
			    ".$_SERVER[HTTP_HOST]."
			    ".$word[LANG]['1_1_send_contact_email_thanksContent']."</td>
			  </tr>
			</table>";
		}
		
		    $fullmsg='<html dir="'.$settings['dir'].'">
			<head dir="'.$settings['dir'].'">
			<meta http-equiv="Content-Type" content="text/html; charset=windows-1255">
			</head>
			<body>'.$msg2.'</body>
			</html>';
		
		    $headers  = "MIME-Version: 1.0\r\n";
		    $headers .= "Content-type: text/html; charset=windows-1255-1\r\n";
		    $headers .= "From: ".$data_arr['name']." <".$data_arr['email'].">\r\n";
		  
		  
			//mail($data_name['email'],$word[LANG]['1_1_send_contact_subjcet'], $fullmsg, $headers );
			GlobalFunctions::send_emails_with_phpmailer($data_arr['email'], $data_arr['name'], $word[LANG]['1_1_send_contact_subjcet'], $fullmsg, $fullmsg, $data_name['email'], $data_name['email'] );
			
			if( UNK == "654462387874498781" )
			{
				$temp_landing = explode( "landing.php?ld=" , $_SERVER[HTTP_REFERER] );
				if( $temp_landing[1] == '41' )
					$title = "מיגרנה";
				elseif( $temp_landing[1] == '40' )
					$title =  "טחורים";
				elseif( $temp_landing[1] == '55' )
					$title =  "תטא הילינג";
				else
					$title = "רפואה סינית";
				
				$moreD = "נושא: ".stripslashes($dataSubs['subject'])."\n הערות בקשות: ".$data_arr['content'];
				shalev_clinic___arr_to_crm($data_arr['name'] , "" , $data_arr['email'] , $data_arr['phone'] , $title , $moreD );
			}
			if( UNK == "663111052427689836" )
			{
				$moreD = "נושא: ".stripslashes($dataSubs['subject'])."\n הערות בקשות: ".$data_arr['content'];
				shalev_clinic___arr_to_crm($data_arr['name'] , "" , $data_arr['email'] , $data_arr['phone'] , "דיקור סיני" , $moreD );
			}
			/*
			if($data_arr['payByPassword'] == '1'){
					$sql = "UPDATE user_lead_settings SET leadQry = leadQry - 1 WHERE unk = '".UNK."'";
					$res = mysql_db_query(DB,$sql);
			}
			*/
			insert_to_db($data_arr, $image_settings);
		}
	}
}
/***************************************************************************************************/

function get_thanks()	{

	global $word;
	
	switch($_REQUEST['type'])
	{
		case "get_thx_contact" :			$text = $word[LANG]['1_1_sender_content_text'];			break;
		case "get_thx_gb" :						$text = $word[LANG]['1_1_sender_get_thx_gb'];				break;
		case "ecom_form" :						$text = $word['he']['1_1_sender_ecom_form'];				break;
		default :											$text = $word[LANG]['1_1_sender_content_text'];
	}
	echo "<table border=\"0\" cellspacing=\"0\" cellpadding=\"0\" class=\"maintext\" width=100%>";
		
		echo "<tr>";
			echo "<td style='font-size:15px;' align=center>".$text."</td>";
		echo "</tr>";
		
	echo "</table>";
	
	if( $_REQUEST['type'] == "get_thx_contact" )
	{
		$sql = "SELECT contactThanksPixel, contactThanksUrlRedirect FROM user_extra_settings WHERE unk = '".UNK."' ";
		$res = mysql_db_query(DB,$sql);
		$data = mysql_fetch_array($res);
		
		if( $data['contactThanksPixel'] != "" )
		{
			echo stripslashes($data['contactThanksPixel']);
		}
		
		if( $data['contactThanksUrlRedirect'] != "" )
		{
			echo '<form action="'.stripslashes($data['contactThanksUrlRedirect']).'" name="watting" id="watting" method="post"></form>
			<script>setTimeout("watting.submit()",5000);</script>';
		}
	}
}
/****************************************************************************************************/
/****************************************************************************************************/
/****************************************************************************************************/
 
function articels()
{
	
	global $data_colors,$word,$settings,$data_extra_settings;
	if($data_extra_settings['news_version'] == '1'){
		echo version_1_articels();
		return;
	}
	$artd = ( $_GET['artd'] != "" ) ? "and id = '".ifint($_GET['artd'])."'" : "";
	$art_id = ( $_GET['art_id'] != "" && $artd == "" ) ? "and id = '".ifint($_GET['art_id'])."'" : "";
	$art_cat = ( $_GET['cat'] != "" ) ? "and cat = '".ifint($_GET['cat'])."'" : "";
	
	$sql = "select * from user_articels where unk = '".UNK."' and status = '0' ".$artd." ".$art_id." ".$art_cat." and deleted = '0' order by id desc limit 1";
	$res = mysql_db_query(DB,$sql);
	$data = mysql_fetch_array($res);
	
	$sql_all = "select id,headline from user_articels where unk = '".UNK."' and id != '".ifint($data['id'])."' ".$art_cat." and status = '0' and deleted = '0' order by place";
	$res_all = mysql_db_query(DB,$sql_all);
	$data_num_all = mysql_num_rows($res_all);
	
	
	$sql = "select id,name from user_articels_cat where unk = '".UNK."' and active = '0' and deleted = '0'";
	$resCat = mysql_db_query(DB,$sql);
	$numCat = mysql_num_rows($resCat);
	
	echo "<table border=\"0\" cellspacing=\"0\" cellpadding=\"0\" class=\"maintext\" width=\"100%\">";
		echo "<form action=\"index.php\" name=\"select_art_form\" method=\"get\">";
		echo "<input type='hidden' name='m' value='ar'>";
		
		if( $numCat > 0 )
		{
			echo "<tr>";
				echo "<td>";
					echo "<table border=\"0\" cellspacing=\"0\" cellpadding=\"0\" class=\"maintext\">";
						echo "<tr>";
							echo "<td>";
								
								while( $dataCat = mysql_fetch_array($resCat) )
								{
									$bold_s = ( $dataCat['id']	== $_GET['cat'] ) ? "<b>" : "";
									$bold_e = ( $dataCat['id']	== $_GET['cat'] ) ? "</b>" : "";
									
									echo "<a href='index.php?m=arLi&cat=".$dataCat['id']."' class='maintext'>".$bold_s.GlobalFunctions::kill_strip($dataCat['name']).$bold_e."</a>";
									echo "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
								}
								
								$bold_s2 = ( $_GET['cat']	== "" ) ? "<b>" : "";
								$bold_e2 = ( $_GET['cat']	== "" ) ? "</b>" : "";
								
								echo "<a href='index.php?m=arLi' class='maintext'>".$bold_s2.$word[LANG]['1_1_articels_all_categories'].$bold_e2."</a>";
							echo "</td>";
						echo "</tr>";
					echo "</table>";
				echo "<td>";
			echo "</tr>";
			echo "<tr><td height=15></td></tr>";
		}
		
		echo "<tr>";
			echo "<td>";
				echo "<table border=\"0\" cellspacing=\"0\" cellpadding=\"0\" class=\"maintext\" width=\"100%\">";
					echo "<tr>";
						echo "<td><h1 style=\"font-size:16px;\">".htmlspecialchars(stripslashes($data['headline']))."</h1></td>";
						echo "<td align=\"".$settings['re_align']."\" valign=top width=260>";
						if( $data_num_all > 0 )
						{
								echo "<select name='artd' class='input_style' style=\"width:250px;height: 18px;\" onchange=\"select_art_form.submit()\">";
								echo "<option value=''>".$word[LANG]['1_1_articels_choose_art']."</option>";
								while( $data_all = mysql_fetch_array($res_all) )
								{
									echo "<option value='".$data_all['id']."'>".htmlspecialchars(stripslashes($data_all['headline']))."</option>";
								}
						}
						echo "</td>";
					echo "</tr>";
				echo "</table>";
			echo "</td>";
		echo "</tr>";
		
		echo "</form>";
		?>
		<tr>
			<td>
				<?php $abpath_temp = SERVER_PATH."/articels/".$data['img']; ?>
				<?php if( file_exists($abpath_temp) && !is_dir($abpath_temp) ): ?>
					<img src='articels/<?php echo $data['img']; ?>' border='0' hspace='20' vspace='10' align='<?php echo $settings['re_align']; ?>' />
				<?php endif; ?>
				<?php $content = string_rplace_func($data['content']); ?>
				
				
				<b><?php echo nl2br(stripslashes($data['summary'])); ?></b><br><br>
				
				
			</td>
		</tr>
		<tr>
			<td>
				<?php echo stripslashes($content); ?>
			</td>
		</tr>		
		<tr><td height='30'></td></tr>
		<?php 
		if( !empty($content) )
		{
			echo "<tr>";
				echo "<td class='maintext_small'>";
					echo $word[LANG]['1_1_articels_first_adv'].GlobalFunctions::show_dateTime_field($data['date_in'])."<br>";
					if( $data['date_in'] != $data['date_update'] )
						echo $word[LANG]['1_1_articels_last_update'].GlobalFunctions::show_dateTime_field($data['date_update']);
				echo "</td>";
			echo "</tr>";
		}
		
		if( $data_extra_settings['haveFacebookComments'] == "1" )
		{
			echo "<tr><td height='20'></td></tr>";
			
			echo "<tr>";
				echo "<td>";
					echo FacebookComments("articels");
				echo "</td>";
			echo "</tr>";
		}
	echo "</table>";
}


function articelsList()
{

	global $data_colors,$word,$settings, $data_words, $data_extra_settings;
	
	if($data_extra_settings['news_version'] == '1'){
		echo version_1_articelsList();
		return;
	}	
	$limitCount = ( $_GET['PL'] == "" ) ? "0" : ifint($_GET['PL']);
	$art_cat = ( $_GET['cat'] != "" ) ? "and cat = '".ifint($_GET['cat'])."'" : "";
	$Cat = ( $_GET['cat'] != "" ) ? "&cat=".ifint($_GET['cat']) : "";
	
	
	$sql = "select id,headline,img,summary from user_articels where unk = '".UNK."' ".$art_cat." and status = '0' and deleted = '0' order by id DESC LIMIT ".$limitCount.",10";
	$res = mysql_db_query(DB,$sql);
	
	$sqlAll = "select id from user_articels where unk = '".UNK."' ".$art_cat." and status = '0' and deleted = '0'";
	$resAll = mysql_db_query(DB,$sqlAll);
	$num_all = mysql_num_rows($resAll);
	
	$sql = "select id,name from user_articels_cat where unk = '".UNK."' and active = '0' and deleted = '0'";
	$resCat = mysql_db_query(DB,$sql);
	$numCat = mysql_num_rows($resCat);
	
	
	echo "<table border=\"0\" cellspacing=\"0\" cellpadding=\"0\" class=\"maintext\" width=\"100%\" align=center>";
		
		if( $numCat > 0 )
		{
			echo "<tr>";
				echo "<td>";
					echo "<table border=\"0\" cellspacing=\"0\" cellpadding=\"0\" class=\"maintext\">";
						echo "<tr>";
							echo "<td>";
								
								while( $dataCat = mysql_fetch_array($resCat) )
								{
									$bold_s = ( $dataCat['id']	== $_GET['cat'] ) ? "<b>" : "";
									$bold_e = ( $dataCat['id']	== $_GET['cat'] ) ? "</b>" : "";
									
									echo "<a href='index.php?m=arLi&cat=".$dataCat['id']."' class='maintext'>".$bold_s.GlobalFunctions::kill_strip($dataCat['name']).$bold_e."</a>";
									echo "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
								}
								
								$bold_s2 = ( $_GET['cat']	== "" ) ? "<b>" : "";
								$bold_e2 = ( $_GET['cat']	== "" ) ? "</b>" : "";
								
								echo "<a href='index.php?m=arLi' class='maintext'>".$bold_s2.$word[LANG]['1_1_articels_all_categories'].$bold_e2."</a>";
							echo "</td>";
						echo "</tr>";
					echo "</table>";
				echo "<td>";
			echo "</tr>";
			echo "<tr><td height=15></td></tr>";
		}
		
		$counter_row = 0;
		while( $data = mysql_fetch_array($res) )
		{
			$headline = htmlspecialchars(stripslashes($data['headline']));
			$href = "index.php?m=ar&artd=".$data['id'].$Cat;
			
			$abpath_temp = SERVER_PATH."/articels/".$data['img'];
			if( file_exists($abpath_temp) && !is_dir($abpath_temp) )
			{
				$im_size = GetImageSize ($abpath_temp); 
				$imageWidth = $im_size[0]; 
				$imageheight = $im_size[1]; 
				if( $imageWidth > 138 )
					$imageWidth = "138";
				$img = "<a href='".$href."' title='".$headline."'><img src='articels/".$data['img']."' border='0' hspace='10' width='".$imageWidth."' vspace='0' align='".$settings['align']."' alt='".$headline."'></a>";
			}
			else
				$img = "";
			
			
			if( $counter_row == 0 )
				$borders = "border-bottom: 0px solid #".$data_colors['border_color'].";border-top: 1px solid #".$data_colors['border_color'].";";
			else
				$borders = "border-bottom: 0px solid #".$data_colors['border_color'].";border-top: 0px solid #".$data_colors['border_color'].";";
				
				
			echo "<tr>";
				echo "<td valign=top height=150 style=\"border: 1px solid #".$data_colors['border_color'].";".$borders."\">";
					echo "<table border=0 cellspacing=\"0\" width=100% cellpadding=\"3\" class=\"maintext\" height=150>";	
							echo "<tr>";
								echo "
								<td width=10></td>
								<td valign=top>
									<table border=0 cellspacing=\"0\" width=100% cellpadding=\"0\" class=\"maintext\">
										<tr>
											<td bgcolor=\"#".$data_colors['bg_link']."\"><div id='headline_h2'><a href='".$href."' title='".$headline."' class='maintext' style=\"color:#".$data_colors['color_link']."\"><H2 style=\"color:#".$data_colors['color_link']."\">".$headline."</H2></a></td>
										</tr>
									</table>
								</td>
								<td width=10></td>";
							echo "</tr>";
							echo "<tr><td colspan=3 height=5></td></tr>";
							echo "<tr>";
								echo "<td width=10></td>";
								echo "<Td valign=top>".$img." <a href='".$href."' class='maintext' title='".$headline."' style='text-decoration: none;'>".nl2br(htmlspecialchars(stripslashes($data['summary'])))."</a></td>";
								echo "<td width=10></td>";
							echo "</tr>";
							echo "<tr>";
								echo "<td width=10></td>";
								echo "<td align=\"".$settings['re_align']."\" valign=bottom><a href='".$href."' class=maintext title='".$headline."'>".$word[LANG]['1_1_hp_read_art']."</a></td>";
								echo "<td width=10></td>";
							echo "</tr>";
							echo "<tr><td colspan=3 height=10></td></tr>";
					echo "</table>";
				echo "</td>";
			echo "</tr>";	
			
			$counter_row++;
		}
		
			$temp_word_articels = ( $data_words['id'] == "" ) ? $word[LANG]['1_2_chapter_name_articels'] : stripslashes($data_words['word_articels']);
			
			echo "<tr>";
				echo "<td align=center style=\"border-top: 1px solid #".$data_colors['border_color'].";\">";
					echo "<table align=center border=0 cellspacing=\"0\" width=100% cellpadding=\"3\" class=\"maintext\">";
						echo "<tr>";
							echo "<td align=center>".$word[LANG]['1_1_articels_list_sum']." ".$num_all." ".$temp_word_articels."</td>";
						echo "</tr>";
						
						if( $num_all > 10 )
						{
							echo "<tr>";
								echo "<td align=center>";
								
									$z = 0;
									for($i=0 ; $i < $num_all ; $i++)
									{
										$pz = $z+1;
										
										if($i % 10 == 0)
										{
												if( $i == $_GET['PL'] )
													$classi = "<strong style=\"color:#000000\">".$pz."</strong>&nbsp;&nbsp;";
												else
													$classi = "<a href='index.php?m=arLi&PL=".$i.$Cat."' class='maintext'>".$pz."</a>&nbsp;&nbsp;";
												
												echo $classi;
												
												$z = $z + 1;
										}
									}
								echo "</td>";
							echo "</tr>";
						}
					echo "</table>";
				echo "</td>";
			echo "</tr>";
		
	echo "</table>";
}
/****************************************************************************************************/
/****************************************************************************************************/
/****************************************************************************************************/

function jobs($limit = 0) 
{
	global $data_colors,$word,$settings,$data_extra_settings;
	
	$wher = ( ifint($_GET['Scat']) != "0" ) ? $_GET['Scat'] : "";
	$wher = ( ifint($_GET['STcat']) != "0" ) ? $_GET['STcat'] : $wher;
	$wher = ( ifint($_GET['Sspec']) != "0" ) ? $_GET['Sspec'] : $wher;
	
	$where = ( $wher != "" ) ? " AND uc.cat_id = '".ifint($wher)."' " : "";
	$limit_sql = "";
	if($limit != 0){
		$limit_sql = " LIMIT ".$limit." ";
	}
	$sql = "select uw.* from user_wanted as uw LEFT JOIN user_wanted_cats as uc ON uw.id=uc.wanted_id where uw.unk = '".UNK."' ".$where." and uw.deleted = '0' GROUP BY uw.id order by uw.place".$limit_sql;
	$res = mysql_db_query(DB,$sql);
	
	echo "<table border=\"0\" cellspacing=\"0\" cellpadding=\"0\" class=\"maintext\" width=\"100%\">";
		
		echo "<tr>";
			echo "<td>";
				//echo cats_inner_search_engine_jobs();
				
					$sql = "SELECT bc.id , bc.cat_name  FROM 
					biz_categories as bc , user_wanted_cats as wc , user_wanted as uw WHERE 
						bc.father=0 AND 
						bc.status=1 AND 
						bc.hidden=0 AND
						
						wc.cat_id=bc.id AND
						uw.id=wc.wanted_id  AND
						uw.unk = '".UNK."' AND
						uw.deleted=0
						
						GROUP BY bc.id ORDER BY bc.place";
				$resCat = mysql_db_query(DB,$sql);
				$nums_rows = mysql_num_rows($resCat);
				
				if( $nums_rows > 0 )
				{
					echo "<form action='index.php' name='searchByCats' method='get' style='padding:0; margin:0'>";
					echo "<input type='hidden' name='m' value='jo'>";
								echo "<div style='float:right'>";
								echo "<select name='Scat' id='Scat' onchange='changeCatChain(this)' class='input_style' style='width:150px; height: 22px;'>";
									echo "<option value=''>בחר בנושא</option>";
									
									while( $dataCat = mysql_fetch_array($resCat) )
									{
										$selected = ( $dataCat['id'] == $_GET['Scat'] ) ? "selected" : "";
										echo "<option value='".$dataCat['id']."' ".$selected.">".stripslashes($dataCat['cat_name'])."</option>";
									}
									
								echo "</select>";
							echo "</div>";
							echo "<div style='float:right'>";
								echo "<select name='STcat' id='STcat' onchange='changeSTcatChain(this)' class='input_style' style='display: none; width:150px; height: 22px;'><option value=''>בחר בתחום</option></select>";
							echo "</div>";
							echo "<div style='float:right'>";
								echo "<select name='Sspec' id='Sspec' style='display: none; width:150px; height: 22px;' class='input_style'><option value=''>בחר בהתמחות</option></select>";
							echo "</div>";
							echo "<div style='float:right'>";
								echo "<input type='submit' value='חפש' class='input_style job-search-button'>";
						echo "</div>";
							
					echo "</form>";
					
					if( $_GET['STcat'] != "" && $_GET['STcat'] != "0" )
					{
						echo "<script type='text/javascript'>updateTatCat('".$_GET['Scat']."')</script>";
					}
					
					if( $_GET['Sspec'] != "" && $_GET['Sspec'] != "0" )
					{
						echo "<script type='text/javascript'>updateSpecCat('".$_GET['STcat']."')</script>";
					}
					
				}			
			echo "</td>";
		echo "</tr>";
		
	if( $data_extra_settings['have_jobImgs'] == "1" && false)
	{
		while( $data = mysql_fetch_array($res) )
		{
			echo "<tr>";
				echo "<td background='/tamplate/".$data_extra_settings['jobTopImg']."' style='background-repeat: no-repeat;' width=\"100%\" height=30>
					<table border=\"0\" cellspacing=\"0\" cellpadding=\"0\" width=\"100%\" class=\"maintext\">
						<tr>
							<td width=10></td>
							<td align='".$settings['align']."' style='color:#".$data_extra_settings['jobHeadlineColor']."'>".stripslashes($data['name'])."</td>
							<td align='".$settings['re_align']."' style='color:#".$data_extra_settings['jobHeadlineColor']."'>".GlobalFunctions::show_dateTime_field($data['date_in'])."</td>
							<td width=10></td>
						</tr>
					</table>
				</td>";
			echo "</tr>";
			
			echo "<tr>";
				echo "<td background='/tamplate/".$data_extra_settings['jobMiddleImg']."' style='background-repeat: repeat-y;' height=100>
					<table border=\"0\" cellspacing=\"0\" cellpadding=\"0\" width=\"100%\" height=100>
						<tr><td colspan=\"3\" height=\"5\"></td></tr>
						<tr>
							<td width=\"10\"></td>
							<td valign=top>
								<table border=\"0\" cellspacing=\"0\" cellpadding=\"0\" class=\"maintext\" width=\"100%\" height=100>
									<tr>
										<td valign=top style='color:#".$data_extra_settings['jobTextColor']."'>".nl2br(stripslashes($data['content']))."</td>
									</tr>
									<tr><td height=\"10\"></td></tr>
									<tr>
										<td valign=bottom>
											<table border=\"0\" cellspacing=\"0\" cellpadding=\"0\" class=\"maintext\" width=\"100%\">
													<tr>
														<td align=\"".$settings['align']."\"></td>
														<td width=30></td>
														<td align=\"".$settings['re_align']."\">
															<table border=\"0\" cellspacing=\"0\" cellpadding=\"0\" class=\"maintext\">
																<tr>
																	<td style='color:#".$data_extra_settings['jobTextColor']."'>".stripslashes($data['email'])."</td>
																	<td width=20></td>
																	<td style='color:#".$data_extra_settings['jobTextColor']."'>".stripslashes($data['phone'])."</td>
																</tr>
															</table>
														</td>
													</tr>
											</table>
										</td>
									</tr>
								</table>
							</td>
							<td width=\"10\"></td>
						</tr>
						<tr><td colspan=\"3\" height=\"5\"></td></tr>
					</table>
				</td>";
			echo "</tr>";
			
			echo "<tr>";
				echo "<td background='/tamplate/".$data_extra_settings['jobBottomImg']."' width=100% height=1 style='background-repeat: no-repeat;'></td>";
			echo "</tr>";
			
			echo "<tr><td height=\"15\"></td></tr>";
			
		}
	}
	else
	{
		echo "<tr><td>";
		while( $data = mysql_fetch_array($res) )
		{
			echo "<div class='job'>
					<div class='job-title job-item'>
						<div class='job-type'>
							<b>".$word[LANG]['1_1_jobs_type'].":</b>
						</div>		
						<div class='job-name'>		<u>".stripslashes($data['name'])."</u></div>
					</div>"
					//<div class='job-desc job-item'><b>".$word[LANG]['1_1_jobs_desc'].":</b></div>
					//<div style='clear:both;'></div>
					."<div class='job-content job-item'>".nl2br(stripslashes($data['content']))."</div>
					<div style='clear:both;'></div>
					<div class='job-email job-item'><b>דוא\"ל:</b>".stripslashes($data['email'])."</div>
					<div style='clear:both;'></div>
					<div class='job-phone job-item'><b>טלפון:</b>".stripslashes($data['phone'])."</div>
					<div style='clear:both;'></div>
					<div class='job-date job-item'><b>".$word[LANG]['1_1_jobs_adv_date'].":</b>".GlobalFunctions::show_dateTime_field($data['date_in'])."</div>
					<div style='clear:both;'></div>
					
			</div>";
		}
		echo "</td></tr>";
	}
	
	echo "</table>";
	
	
}
/****************************************************************************************************/
/****************************************************************************************************/
/****************************************************************************************************/

function yad2()
{

	global $data_colors,$word,$settings;
	
	if( $data_colors['kobia_type'] == "1" )
	{
		getKobiaDesigner( "yad2" );
			return "";
	}
	
	$limitcount = ( $_GET['PL'] == "" ) ? $_POST['PL'] : $_GET['PL'];
	$limitcount = ( $limitcount == "" ) ? "0" : ifint($limitcount);
	
	$sql = "select * from user_yad2 where unk = '".UNK."' and deleted = '0' and active = '0' order by place LIMIT ".$limitcount.",21";
	$res = mysql_db_query(DB,$sql);
	
	$sql2 = "select COUNT(id) as num_rows from user_yad2 where unk = '".UNK."' and deleted = '0' and active = '0'";
	$res2 = mysql_db_query(DB,$sql2);
	$data2 = mysql_fetch_array($res2);
	
	
	echo "<table border=\"0\" cellspacing=\"0\" cellpadding=\"0\" class=\"maintext\" width=\"100%\">";
		echo "<tr><td colspan=\"3\" height=20></td></tr>";
		$counter = 0;
		while( $data = mysql_fetch_array($res) )
		{
			if( $counter%3 == 0 )
			echo "<tr>";
				
				$abpath_temp = SERVER_PATH."/yad2/".$data['img'];
				if( file_exists($abpath_temp) && !is_dir($abpath_temp) )
				{
					$im_size = GetImageSize ($abpath_temp); 
					$imageWidth = $im_size[0]; 
					$imageheight = $im_size[1]; 
					$img_src = "<a href=\"index.php?m=s.ya&ud=".$data['id']."\" class=\"maintext\" title=\"".htmlspecialchars(stripslashes($data['name']))."\"><img src='yad2/{$data['img']}' border='0' height=\"{$imageheight}\" width=\"".$imageWidth."\" alt='' /></a>";
				}
				else
				{
					$img_src = "";
					$imageWidth = "76%";
				}
				
				echo "<td valign=\"top\" height=\"100%\" align=\"center\" width=\"33%\">
					<table border=\"0\" cellspacing=\"0\" cellpadding=\"0\" class=\"site_border\" height=\"100%\"  width=\"156\">
						<tr><td colspan=\"3\" height=20></td></tr>
						<tr>
							<td width=\"3\">
							<td valign=\"top\" height=\"100%\">
								<table border=\"0\" height=\"100%\" cellspacing=\"0\" cellpadding=\"0\" class=\"maintext\">
									
									<tr>
										<td align=\"".$settings['align']."\" valign=\"top\"><a href=\"index.php?m=s.ya&ud=".$data['id']."\" class=\"maintext\" title=\"".htmlspecialchars(stripslashes($data['name']))."\"><b>".htmlspecialchars(stripslashes($data['name']))."</b></a></td>
									</tr>
									
									<tr><td colspan=\"3\" height=\"1\"></td></tr>
									
									<tr>
										<td colspan=\"3\" valign=\"top\">{$img_src}</td>
									</tr>
									
								
									
									<tr><td colspan=\"3\" height=\"3\"></td></tr>
									<tr>
										<td align=\"".$settings['align']."\"><b>".nl2br(stripslashes(htmlspecialchars($data['summary'])))."</b></td>
									</tr>
									<tr><td colspan=\"3\" height=\"3\"></td></tr>";
									if( $data['price'] != "" )
									{
										echo "<tr>
											<td align=\"center\" valign=\"top\">".$word[LANG]['1_1_yad2_price']." <b>".stripslashes(htmlspecialchars($data['price']))." ".COIN."</b></td>
										</tr>
										<tr><td colspan=\"3\" height=\"3\"></td></tr>";
									}
									echo "<tr>
										<td align=\"center\"><a href=\"index.php?m=s.ya&ud=".$data['id']."\" class=\"maintext\" title=\"".htmlspecialchars(stripslashes($data['name']))."\"><b>".$word[LANG]['1_1_yad2_more_info']."</b></a></td>
									</tr>
									
								</table>
							</td>
							<td width=\"3\">
						</tr>
						<tr><td colspan=\"3\" height=\"5\"></td></tr>
					</table>
				</td>";
				
			$counter++;
			
			if( $counter%3 == 0 )
			{
			echo "</tr>
			<tr><td height=\"15\"></td></tr>";
			}
		}
		
		echo "<tr>";
			echo "<td align=center colspan=10>";
				$params['limitInPage'] = "21";
				$params['numRows'] = $data2['num_rows'];
				$params['limitcount'] = $limitcount;
				$params['m'] = $_GET['m'];
				$params['cat'] = $_GET['cat'];
				$params['sub'] = $_GET['sub'];
				
				getLimitPagention( $params );
				
			echo "<td>";
		echo "</tr>";
		
	echo "</table>";
}


function s_yad2()
{
	global $data_colors,$word,$settings,$temp_word_yad2;

	$sql = "select * from user_yad2 where unk = '".UNK."' and deleted = '0' and active = '0' and id = '".ifint($_GET['ud'])."' limit 1";
	$res = mysql_db_query(DB,$sql);
	$data = mysql_fetch_array($res);

	$content = string_rplace_func($data['content']);
	
	echo "<table border=\"0\" cellspacing=\"0\" cellpadding=\"0\" class=\"maintext\" width=\"100%\">";
		echo "<tr><td colspan=\"3\" height=20></td></tr>";
		echo "<tr>";
			echo "<td><h1 style=\"font-size:16px;\">".htmlspecialchars(stripslashes($data['name']))."</h1></td>";
		echo "</tr>";
		
		echo "<tr>";
			echo "<td><a href='index.php?m=ya'>".$word[LANG]['1_1_general_back_to'].$temp_word_yad2."</a></td>";
		echo "</tr>";
		
		echo "<tr><td height='5'></td></tr>";
				
		echo "<tr>";
			echo "<td valign=\"top\">";
				$abpath_temp = SERVER_PATH."/yad2/".$data['img2'];
				$abpath_tempt = SERVER_PATH."/yad2/".$data['img'];
				if( file_exists($abpath_temp) && !is_dir($abpath_temp) )
					echo "<img src='yad2/{$data['img2']}' border='0' hspace='20' vspace='10' align='".$settings['re_align']."'>";
				else 
					if( file_exists($abpath_tempt) && !is_dir($abpath_tempt) )
						echo "<img src='yad2/{$data['img']}' border='0' hspace='20' vspace='10' align='".$settings['re_align']."'>";
				
				echo "<b>".nl2br(htmlspecialchars(stripslashes($data['summary'])))."</b><br><br>";
				if( $data['price'] != "" )
					echo $word[LANG]['1_1_yad2_price']." <b>".htmlspecialchars(stripslashes($data['price']))." ".COIN."</b><br><br>";
				
				echo nl2br(htmlspecialchars(stripslashes($content)));
				
			echo "</td>";
		echo "</tr>";
		
	echo "</table>";
}
/****************************************************************************************************/
/****************************************************************************************************/
/****************************************************************************************************/

function sales()
{

	global $data_colors,$word,$settings;
	
	if( $data_colors['kobia_type'] == "1" )
	{
		getKobiaDesigner( "sales" );
			return "";
	}
	
	
	$sql = "select have_sales_dates from users where unk = '".UNK."'";
	$resUsers = mysql_db_query(DB,$sql);
	$dataUsers = mysql_fetch_array($resUsers);
	$show_end_date = ( $dataUsers['have_sales_dates'] == "0" ) ? " and end_date > '".GlobalFunctions::get_date()."'" : "";
	
	$limitcount = ( $_GET['PL'] == "" ) ? $_POST['PL'] : $_GET['PL'];
	$limitcount = ( $limitcount == "" ) ? "0" : ifint($limitcount);
	
	$sql = "SELECT indexSite FROM user_extra_settings WHERE unk = '".UNK."' ";
	$res_index = mysql_db_query(DB,$sql);
	$data_index = mysql_fetch_array($res_index);
	
	if( $data_index['indexSite'] == "1" )
	{
		$kolId = ( $_GET['kolId'] != "" ) ? " AND kol_userid = '".$_GET['kolId']."'" : "";
		$sql = "select * from user_sales where unk = '".UNK."' ".$show_end_date." and deleted = '0' and status = '0' ".$kolId." order by place LIMIT ".$limitcount.",21";
	}
	else
		$sql = "select * from user_sales where unk = '".UNK."' ".$show_end_date." and deleted = '0' and status = '0' order by place LIMIT ".$limitcount.",21";
	
	$res = mysql_db_query(DB,$sql);
	
	$sql2 = "select COUNT(id) as num_rows from user_sales where unk = '".UNK."' ".$show_end_date." and deleted = '0' and status = '0'";
	$res2 = mysql_db_query(DB,$sql2);
	$data2 = mysql_fetch_array($res2);
	
	echo "<table border=\"0\" cellspacing=\"0\" cellpadding=\"0\" class=\"maintext\" width=\"100%\">";
		
		$counter = 0;
		while( $data = mysql_fetch_array($res) )
		{
			if( $counter%3 == 0 )
			echo "<tr>";
				
				$abpath_temp = SERVER_PATH."/sales/".$data['img'];
				if( file_exists($abpath_temp) && !is_dir($abpath_temp) )
				{
					$im_size = GetImageSize ($abpath_temp); 
					$imageWidth = $im_size[0]; 
					$imageheight = $im_size[1]; 
					$img_src = "<a href=\"index.php?m=s.sa&ud=".$data['id']."\" class=\"maintext\" title=\"".htmlspecialchars(stripslashes($data['name']))."\"><img src='sales/{$data['img']}' border='0' height=\"{$imageheight}\" width=\"".$imageWidth."\" alt='' /></a>";
				}
				else
				{
					$img_src = "";
					$imageWidth = "76%";
				}
				
				echo "<td valign=\"top\" height=\"100%\" align=\"center\" width=\"33%\">
					<table border=\"0\" cellspacing=\"0\" cellpadding=\"0\" class=\"site_border\" height=\"100%\"  width=\"156\">
						<tr><td colspan=\"3\"></td></tr>
						<tr>
							<td width=\"3\">
							<td valign=\"top\" height=\"100%\">
								<table border=\"0\" height=\"100%\" cellspacing=\"0\" cellpadding=\"0\" class=\"maintext\">
									
									<tr>
										<td align=\"center\" valign=\"top\"><a href=\"index.php?m=s.sa&ud=".$data['id']."\" class=\"maintext\" title=\"".htmlspecialchars(stripslashes($data['name']))."\"><b>".htmlspecialchars(stripslashes($data['name']))."</b></a></td>
									</tr>
									
									<tr><td colspan=\"3\" height=\"1\"></td></tr>
									
									<tr>
										<td colspan=\"3\" valign=\"top\" align=center>{$img_src}</td>
									</tr>
									
								
									
									<tr><td colspan=\"3\" height=\"3\"></td></tr>
									<tr>
										<td align=\"".$settings['align']."\" valign=\"top\"><b>".nl2br(stripslashes(htmlspecialchars($data['summary'])))."</b></td>
									</tr>
									<tr><td colspan=\"3\" height=\"3\"></td></tr>";
									if( $data['price'] != "" )
									{
										echo "<tr>
											<td align=\"center\" valign=\"top\">".$word[LANG]['1_1_sales_price']." <b style=\"text-decoration: line-through;\">".$data['price']." ".COIN."</b></td>
										</tr>
										<tr><td colspan=\"3\" height=\"3\"></td></tr>";
									}
									if( $data['sale_price'] != "" )
									{
										echo "<tr>
											<td align=\"center\" valign=\"top\">".$word[LANG]['1_1_sales_price_sale']." <b>".htmlspecialchars(stripslashes($data['sale_price']))." ".COIN."</b></td>
										</tr>
										<tr><td colspan=\"3\" height=\"3\"></td></tr>";
									}
									echo "<tr>
										<td align=\"center\"><a href=\"index.php?m=s.sa&ud=".$data['id']."\" class=\"maintext\" title=\"".htmlspecialchars(stripslashes($data['name']))."\"><b>".$word[LANG]['1_1_sales_more_info']."</b></a></td>
									</tr>
									
								</table>
							</td>
							<td width=\"3\">
						</tr>
						<tr><td colspan=\"3\" height=\"5\"></td></tr>
					</table>
				</td>";
				
			$counter++;
			
			if( $counter%3 == 0 )
			{
			echo "</tr>
			<tr><td height=\"15\"></td></tr>";
			}
		}
		
		echo "<tr>";
			echo "<td align=center colspan=10>";
				$params['limitInPage'] = "21";
				$params['numRows'] = $data2['num_rows'];
				$params['limitcount'] = $limitcount;
				$params['m'] = $_GET['m'];
				$params['cat'] = $_GET['cat'];
				$params['sub'] = $_GET['sub'];
				
				getLimitPagention( $params );
				
			echo "<td>";
		echo "</tr>";
		
		
	echo "</table>";
}


function s_sales()
{
	global $data_colors,$word,$settings,$data_name, $temp_word_sales;
	
	$sql = "select have_sales_dates from users where unk = '".UNK."'";
	$resUsers = mysql_db_query(DB,$sql);
	$dataUsers = mysql_fetch_array($resUsers);
	$show_end_date = ( $dataUsers['have_sales_dates'] == "0" ) ? " and end_date > '".GlobalFunctions::get_date()."'" : "";
	
	
	$sql = "select * from user_sales where unk = '".UNK."' and deleted = '0' ".$show_end_date." and status = '0' and id = '".ifint($_GET['ud'])."' limit 1";
	$res = mysql_db_query(DB,$sql);
	$data = mysql_fetch_array($res);
	
	$content = string_rplace_func($data['content']);
	
	echo "<table border=\"0\" cellspacing=\"0\" cellpadding=\"0\" class=\"maintext\" width=\"100%\">";
		
		echo "<tr>";
			echo "<td><h1 style=\"font-size: 16px\">".htmlspecialchars(stripslashes($data['name']))."</h1></td>";
		echo "</tr>";
		
		echo "<tr>";
			echo "<td><a href='index.php?m=sa'>".$word[LANG]['1_1_general_back_to'].$temp_word_sales."</a></td>";
		echo "</tr>";
		
		echo "<tr><td height=\"5\"></td></tr>";
		
		echo "<tr>";
			echo "<td valign=\"top\">";
				$abpath_temp = SERVER_PATH."/sales/".$data['img2'];
				$abpath_tempt = SERVER_PATH."/sales/".$data['img'];
				if( file_exists($abpath_temp) && !is_dir($abpath_temp) )
					echo "<img src='sales/{$data['img2']}' border='0' hspace='20' vspace='10' align='".$settings['re_align']."' alt='' />";
				else 
					if( file_exists($abpath_tempt) && !is_dir($abpath_tempt) )
						echo "<img src='sales/{$data['img']}' border='0' hspace='20' vspace='10' align='".$settings['re_align']."' alt='' />";
				
				
				echo "<b>".nl2br(htmlspecialchars(stripslashes($data['summary'])))."</b><br><br>";
				
				if( $data['price'] != "" )
					echo $word[LANG]['1_1_sales_price']." <b style=\"text-decoration: line-through;\">".htmlspecialchars(stripslashes($data['price']))." ".COIN."</b><br>";
				if( $data['sale_price'] != "" )
					echo $word[LANG]['1_1_sales_price_sale']." <b>".htmlspecialchars(stripslashes($data['sale_price']))." ".COIN."</b><br>";
				if( $data['serial_num'] != "" )
					echo $word[LANG]['1_1_sales_makat']." <b>".htmlspecialchars(stripslashes($data['serial_num']))."</b><br><br>";
				
				echo nl2br(htmlspecialchars(stripslashes($content)))."<br><br>";
				if( !empty($data['url_name']) && !empty($data['url_link']) )
					echo $word[LANG]['1_1_sales_url_link']." <a href='".htmlspecialchars(stripslashes($data['url_link']))."' class='maintext' target='_blank'><b><u>".htmlspecialchars(stripslashes($data['url_name']))."</u></b></a><br>";
				if( $data['start_date'] != "" && $dataUsers['have_sales_dates'] == "0" )
					echo $word[LANG]['1_1_sales_start_date']." ".GlobalFunctions::date_fliper($data['start_date'])."<br>";
				if( $data['end_date'] != "" && $dataUsers['have_sales_dates'] == "0" )
					echo $word[LANG]['1_1_sales_end_date']." ".GlobalFunctions::date_fliper($data['end_date'])."<br>";
				
				if( $data_name['have_print'] == "1" )
					echo "<br><a href='print.php?".$_SERVER['argv']['0']."' target='_blank'>".$word[LANG]['1_2_print_version']."</a>";
				
			echo "</td>";
		echo "</tr>";
		
	echo "</table>";
}
/****************************************************************************************************/
/****************************************************************************************************/
/****************************************************************************************************/

function products()
{

	global $data_colors,$data_name,$word,$settings,$data_extra_settings;
	if($data_extra_settings['products_version'] == '1'){	
		echo version_1_products();
		return;
	}	
	if( $data_colors['kobia_type'] == "1" )
	{
		getKobiaDesigner( "products" );
			return "";
	}
	
	$sql = "SELECT id FROM user_products_subject WHERE unk = '".UNK."' and deleted = '0' and active = '0' ORDER BY rand()";
	$res_subject = mysql_db_query(DB,$sql);
	$subject_cat = mysql_fetch_array($res_subject);
	
	if( $_GET['sub'] == "" )	{
		$subject_id = "AND subject_id = '".$subject_cat['id']."'";
		$_GET['sub'] = $subject_cat['id'];
	}
	else
		$subject_id = "AND subject_id = ".ifint($_GET['sub']);
			
	$sql = "select * from user_products_cat where unk = '".UNK."' and deleted = '0' and status = '0' ".$subject_id." order by id limit 1";
	$res_cat = mysql_db_query(DB,$sql);
	$data_cat = mysql_fetch_array($res_cat);
	
	$limitcount = ( $_GET['PL'] == "" ) ? $_POST['PL'] : $_GET['PL'];
	$limitcount = ( $limitcount == "" ) ? "0" : ifint($limitcount);
	
	$temp_cat = ( $_GET['cat'] ) ? $_GET['cat'] : $data_cat['id'];
	
	$sql2 = "select COUNT(up.id) as num_rows from user_products as up INNER JOIN user_model_cat_belong as umcb ON umcb.catId='".ifint($temp_cat)."' AND umcb.model='products' AND umcb.itemId=up.id WHERE up.deleted = 0 and up.unk = '".UNK."' and up.active = '0'";
	$res2 = mysql_db_query(DB,$sql2);
	$data2 = mysql_fetch_array($res2);
	
	echo "<table border=\"0\" cellspacing=\"0\" cellpadding=\"0\" class=\"maintext\" width=\"100%\">";
		echo "<tr><td colspan=\"10\" height=10></td></tr>";
		if( $data_name['have_ProGal_cats'] == 0 )
		{
			echo "<tr>";
				echo "<td width=\"100%\" colspan=\"10\">".get_products_cat($temp_cat)."</td>";
			echo "</tr>";
			echo "<tr><td colspan=\"10\" height=10></td></tr>";
		}
		
		echo products_regular_content('21',$temp_cat);
		
		echo "<tr>";
			echo "<td align=center colspan=10>";
				$params['limitInPage'] = "21";
				$params['numRows'] = $data2['num_rows'];
				$params['limitcount'] = $limitcount;
				$params['m'] = $_GET['m'];
				$params['cat'] = $_GET['cat'];
				$params['sub'] = $_GET['sub'];
				
				getLimitPagention2( $params );
				
			echo "<td>";
		echo "</tr>";
		
		
	echo "</table>";
	
}


function s_products()
{
	global $data_colors,$data_name,$word,$settings,$data_extra_settings;
	if($data_extra_settings['products_version'] == '1'){	
		echo version_1_s_products();
		return;
	}

	if( $data_name['site_type'] == "10" )
	{
		$sql = "select p.* from user_extra_settings as uxs, user_products as p
		where p.deleted = '0' and p.active = '0' and p.id = '".ifint($_GET['ud'])."' and uxs.unk = p.unk and ( uxs.nisha_sites LIKE '%\"".$data_name['id']."\"%' OR uxs.unk = '".UNK."' ) limit 1";
	}
	else
		$sql = "select * from user_products where unk = '".UNK."' and deleted = '0' and active = '0' and id = '".ifint($_GET['ud'])."' limit 1";
	
	$res = mysql_db_query(DB,$sql);
	$data = mysql_fetch_array($res);
	
	if( $data_name['site_type'] == "10" )
	{
		if( $data['url_link'] != "" )
			echo "<script>window.location.href='".$data['url_link']."';</script>";
	}
	
	$content = string_rplace_func($data['content']);
	
	
	
	
	if( $data_name['site_type'] == "10" )
	{
		$sql_domain = "SELECT domain FROM users WHERE unk = '".$data['unk']."' ";
		$res_domain = mysql_db_query(DB,$sql_domain);
		$data_domain = mysql_fetch_array($res_domain);
		
		$server_path = "/home/ilan123/domains/".$data_domain['domain']."/public_html";
		$http_path = "http://".$data_domain['domain'];
	}
	else
	{
		$server_path = SERVER_PATH;
		$http_path = HTTP_PATH;
	}
	
	$abpath_temp = $server_path."/products/".$data['img2'];
	$abpath_tempt = $server_path."/products/".$data['img'];
	$abpath_tempEX = $server_path."/products/".$data['img3'];
	
	if( file_exists($abpath_tempEX) && !is_dir($abpath_tempEX) )
		echo "<div id=\"s.prEXimgDiv\" style=\"display:none\"><img src='".$http_path."/products/{$data['img3']}' border='0'></div>";
	
	//if( UNK == "567556530384297372" )
	//{
		echo "<table border=\"0\" cellspacing=\"0\" cellpadding=\"0\" class=\"maintext\" width=\"100%\">";
		
		if( $data_name['have_ProGal_cats'] == 0 )
		{
			echo "<tr><td></td></tr>";
			echo "<tr>";
				echo "<td>".get_products_cat($data['cat'])."</td>";
			echo "</tr>";
		}	
		
		echo "<tr><td height=10></td></tr>";
					
		
		echo "<tr>";
			echo "<td align=".$settings['align']."><h2 style=\"padding:0; margin:0;\">".htmlspecialchars(stripslashes($data['name']))."</h2></td>";
		echo "</tr>";
		
		echo "<tr>";
			echo "<td valign=\"top\">";
				echo "<table border=\"0\" cellspacing=\"0\" cellpadding=\"0\" class=\"maintext\" width=100% dir=\"".$settings['dir']."\">";
					echo "<tr>";
					
						echo "<td valign=\"top\" width=250>";
							echo "<table border=\"0\" cellspacing=\"0\" cellpadding=\"0\" class=\"maintext\" width=250>";
								echo "<tr>";
									echo "<td><b>".nl2br(htmlspecialchars(stripslashes($data['summary'])))."</b></td>";
								echo "</tr>";
								
								echo "<tr><td height=20></td></tr>";
								
								if( $data['video_10service'] != "" )
								{
									echo "<tr>";
										echo "<td align=right valign=bottom>";
											echo "<table border=\"0\" cellspacing=\"0\" cellpadding=\"0\" class=\"maintext\" width=243>";
												echo "<tr>";
													echo "<td align=center width=243 height='203'>";
														if( UNK == "671958513343023564" )
														{
															echo '<div align="center"><iframe id="idContent" style="WIDTH: 221px; HEIGHT: 177px" src="'.$data['video_10service'].'" frameborder="0" scrollbars="no" scrolling="no" ></iframe></div>';
														}
														else
														{
															echo '<div id="youtubeVid125"></div>';
															echo '<script type="text/javascript">loadSWFwithBase("'.$data['video_10service'].'","youtubeVid125","221","177","#","youtubeVid125")</script>';
														}
													echo "</td>";
												echo "</tr>";
											echo "</table>";
										echo "</td>";
									echo "</tr>";
									echo "<tr><td height=20></td></tr>";
								}
								
								echo "<tr>";
									echo "<td valign=\"top\">".nl2br(htmlspecialchars(stripslashes($content)))."</td>";
								echo "</tr>";
							echo "</table>";
						echo "</td>";
						
						echo "<td width=10></td>";
						
						echo "<td align=".$settings['re_align']." valign=\"top\">";
							echo "<table border=\"0\" cellspacing=\"1\" cellpadding=\"1\" class=\"maintext\">";
								
								echo "<tr>";
									echo "<td align=center>";
										echo "<div class=\"product_container\"><div id=\"slidingProduct".$data['id']."\" class=\"sliding_product\">";
											
											if( !file_exists(SERVER_PATH."/ajax.php") )
											{
											if( file_exists($abpath_temp) && !is_dir($abpath_temp) )
												if( file_exists($abpath_tempEX) && !is_dir($abpath_tempEX) )
												{
													list($org_width, $org_height) = getimagesize($abpath_tempEX);
													
													$sPrEX_width = $org_width + 10;
													$sPrEX_height = $org_height + 10;
													
													echo "<table border=\"0\" cellspacing=\"0\" cellpadding=\"0\" class=\"maintext\">";
														echo "<tr>";
															echo "<td align=center><a href='javascript:void(0)' onClick=\"divwin=dhtmlwindow.open('s.prEXimg', 'div', 's.prEXimgDiv', '".$word[LANG]['1_1_products_extra_img']." - ".htmlspecialchars(stripslashes($data['name']))."', 'width=".$sPrEX_width."px,height=".$sPrEX_height."px,left=10px,top=10px,resize=0,scrolling=0'); return false\">".$word[LANG]['1_1_products_extra_img_link']."</a></td>";
														echo "</tr>";
														echo "<tr>";
															echo "<td>";
																echo "<a href='javascript:void(0)' onClick=\"divwin=dhtmlwindow.open('s.prEXimg', 'div', 's.prEXimgDiv', '".$word[LANG]['1_1_products_extra_img']." - ".str_replace("'","",htmlspecialchars(stripslashes($data['name'])))."', 'width=".$sPrEX_width."px,height=".$sPrEX_height."px,left=10px,top=10px,resize=0,scrolling=0'); return false\"><img src='".$http_path."/products/{$data['img2']}' border='0' hspace='20' vspace='10' align='".$settings['re_align']."' alt='".$word[LANG]['1_1_products_extra_img_resize']."'></a>";
															echo "</td>";
														echo "</tr>";
													echo "</table>";
												}
												else
												{
													echo "<img src='".$http_path."/products/{$data['img2']}' border='0' hspace='20' vspace='10' align='".$settings['re_align']."'>";
												}	
												elseif( UNK == "038157696328808156" && $data['price'] == "0" )  // chip haari castum model
													echo "<iframe src ='http://www.ilbiz.co.il/newsite/net_system/castum/chip.haari/s.pr.more.img.php?unk=".UNK."&pr=".$data['id']."&sesid=".$_SESSION['ecom']['unickSES']."' width='535' frameborder=0 height=150 scrolling=auto allowtransparency='true'></iframe>";
												else 
													if( file_exists($abpath_tempt) && !is_dir($abpath_tempt) )
													{
														echo "<img src='".$http_path."/products/{$data['img']}' border='0' hspace='20' vspace='10' align='".$settings['re_align']."'>";
														//echo '<div style="position: absolute; right: 0px; top: 0px; display: block; width: 150px; height:90px;"><img width="150" border="0" height="90" alt="" src="http://10service.co.il/soldWaterMark.png"></div>';
													}
											}
											else
											{
											echo "<div id=\"service10ProductImages\"></div>";
											echo "<script type='text/javascript'>product_images(\"".$data['id']."\" , \"default\" , \"".$data['unk']."\")</script>";
											}
										echo "</div></div>";
									echo "</td>";
								echo "</tr>";
								
								echo "<tr><td height=20></td></tr>";
								
								echo "<tr>";
									echo "<td align=center>";
										echo "<table border=\"0\" cellspacing=\"1\" cellpadding=\"1\" class=\"maintext\">";
											
											if( $data['price'] )
											{
												if(UNK != '806700060391385236' && UNK != '862091780777250501' && UNK != '208757065782826350'){
													echo "<tr>";
														echo "<td align='".$settings['align']."'>".$word[LANG]['1_1_products_price'].":</td>";
														echo "<td><b>".htmlspecialchars(stripslashes($data['price']))." ".COIN."</b></td>";
													echo "</tr>";
													echo "<tr><td colspan=3 height=5></td></tr>";
													
													if( UNK == "625420717714095702" && $data['price_special'] > "0" )
													{
														echo "<tr>";
															echo "<td align='".$settings['align']."'>מחיר לחברי העמותה:</td>";
															echo "<td><b>".htmlspecialchars(stripslashes($data['price_special']))." ".COIN."</b></td>";
														echo "</tr>";
														echo "<tr><td colspan=3 height=5></td></tr>";
													}
												}
											}
											if( $data_name['have_ecom'] == "1" && $data['makat'] != "" )
											{
												echo "<tr>";
													echo "<td align='".$settings['align']."'>".$word[LANG]['1_1_products_serial_number'].":</td>";
													echo "<td align=".$settings['align'].">".$data['makat']."</td>";
												echo "</tr>";
												echo "<tr><td colspan=3 height=5></td></tr>";
											}
											
											if( !empty($data['url_name']) && !empty($data['url_link']) && $data_name['site_type'] != "10" )
											{
												echo "<tr>";
													echo "<td align='".$settings['align']."'>".$word[LANG]['1_1_products_url_link']."</td>";
													echo "<td align=".$settings['align']."><a href='".htmlspecialchars(stripslashes($data['url_link']))."' class='maintext' target='_blank'><b><u>".htmlspecialchars(stripslashes($data['url_name']))."</u></b></a></td>";
												echo "</tr>";
												echo "<tr><td colspan=3 height=5></td></tr>";
											}
											
											if( $data['kobia_msg'] != "" )
											{
												$kobia_msg_style = ( $data['kobia_msg_bg'] != "" ) ? "background-color: #".$data['kobia_msg_bg'].";" : "";
												$kobia_msg_color = ( $data['kobia_msg_color'] != "" ) ? "color: #".$data['kobia_msg_color'].";" : "";
												
												echo "<tr>";
													echo "<td align=center colspan=2><font style='padding:2px; ".$kobia_msg_style.$kobia_msg_color."'>".nl2br(stripslashes(htmlspecialchars($data['kobia_msg'])))."</font></td>";
												echo "</tr>";
												echo "<tr><td height=5 colspan=2></td></tr>";
											}
											
											if( $data_name['have_ecom'] == "1" && $data['active_ecom'] == "1" && $data['price'] != "" )
											{
												if(UNK != '806700060391385236' && UNK != '862091780777250501' && UNK != '208757065782826350'){
													$abpath_temp = SERVER_PATH."/tamplate/".stripslashes($data_extra_settings['cartAddImg']);
													echo "<tr>";
														if( file_exists($abpath_temp) && !is_dir($abpath_temp) )
															echo "<td align=center colspan=2><div id='addToBasketButton".$data['id']."'><a href='javascript:void(0)' onclick=\"addToBasket(".$data['id'].");return false\"><img src='/tamplate/".stripslashes($data_extra_settings['cartAddImg'])."' border=0></a></div></td>";
														else
															echo "<td align=center colspan=2><div id='addToBasketButton".$data['id']."'><a href='javascript:void(0)' onclick=\"addToBasket(".$data['id'].");return false\">".$word[LANG]['1_1_products_add_to_cart']."</a></div></td>";
													echo "</tr>";
													echo "<tr><td colspan=3 height=5></td></tr>";
													
													$abpath_temp = SERVER_PATH."/tamplate/".stripslashes($data_extra_settings['cartKopaImg']);
													echo "<tr>";
														if( file_exists($abpath_temp) && !is_dir($abpath_temp) )
															echo "<td align=center colspan=2><a href='index.php?m=ecom_form' class='ecom_tableRightMenu'><img src='/tamplate/".stripslashes($data_extra_settings['cartKopaImg'])."' border=0></a></td>";
														else
															echo "<td align=center colspan=2><b><u><a href='index.php?m=ecom_form' class='ecom_tableRightMenu'>".$word[LANG]['1_3_ecom_table_cart']."</a></u></b></td>";
													echo "</tr>";
													echo "<tr><td colspan=3 height=5></td></tr>";
												}
											}
											
											if( $data_name['have_print'] == "1" )
											{
												echo "<tr>";
													echo "<td align=center colspan=2><a href='print.php?".$_SERVER['argv']['0']."' target='_blank'>".$word[LANG]['1_2_print_version']."</a></td>";
												echo "</tr>";
												echo "<tr><td colspan=3 height=5></td></tr>";
											}
											
										echo "</table>";
									echo "</td>";
								echo "</tr>";
								
							echo "</table>";
						echo "</td>";
						
					echo "</tr>";
				echo "</table>";
			echo "</td>";
		echo "</tr>";
		
		echo "<tr>";
			echo "<td>";
					$subject_id = ( $_GET['sub'] == "" ) ? "AND subject_id = ''" : "AND subject_id = ".ifint($_GET['sub']);
					$sql = "select * from user_products_cat where unk = '".UNK."' and deleted = '0' and status = '0' ".$subject_id." order by id limit 1";
					$res_cat = mysql_db_query(DB,$sql);
					$data_cat = mysql_fetch_array($res_cat);
					
					$temp_cat = ( $_GET['cat'] ) ? $_GET['cat'] : $data_cat['id'];
					
					echo "<table border=\"0\" cellspacing=\"1\" cellpadding=\"1\" class=\"maintext\">";
						
						echo "<tr>";
							echo "<td>";
								echo products_regular_content_type2('3',$temp_cat , htmlspecialchars(stripslashes($data['name'])));
							echo "</td>";
						echo "</tr>";
					echo "</table>";
				
			echo "</td>";
		echo "</tr>";
		
	echo "</table>";
}

function get_products_cat($cat="")
{
	global $word;
	
	$subject_id = ( $_GET['sub'] == "" ) ? "AND subject_id = ''" : "AND subject_id = ".ifint($_GET['sub']);
	$sql = "select * from user_products_cat where unk = '".UNK."' and deleted = '0' and status = '0' ".$subject_id."";
	$res = mysql_db_query(DB,$sql);
	
	$sql = "select * from user_products_subject where unk = '".UNK."' and deleted = '0' and active = '0'";
	$res_all = mysql_db_query(DB,$sql);
	$data_num_all = mysql_num_rows( $res_all );
	
	$str;
	
	$str .= "<table border=\"0\" cellspacing=\"0\" cellpadding=\"0\" class=\"maintext\">";
	
	if( $data_num_all > 0 )
	{
		$str .= "<form action=\"index.php\" name=\"select_subject_form\" method=\"get\">";
		$str .= "<input type='hidden' name='m' value='pr'>";
	
			$str .= "<tr>";
				$str .= "<td align=\"".$settings['re_align']."\" valign=top>";
			
					$str .= "<select name='sub' class='input_style' style=\"width:250px; height: 18px;\" onchange=\"select_subject_form.submit()\">";
					$str .= "<option value=''>".$word[LANG]['1_1_gallery_choose_subject']."</option>";
					while( $data_all = mysql_fetch_array($res_all) )
					{
						$selected = ( $data_all['id'] == $_GET['sub'] ) ? "selected" : "";
						$str .= "<option value='".$data_all['id']."' ".$selected.">".htmlspecialchars(stripslashes($data_all['name']))."</option>";
					}
			
				$str .= "</td>";
			$str .= "</tr>";
			$str .= "</form>";
	}
		$str .= "<tr><td height=5></td></tr>";
		$str .= "<tr><td>";
	
				while( $data = mysql_fetch_array($res) )
				{
					$bold_s = ( $data['id'] == $cat) ? "<A href='index.php?m=products&amp;cat=".$data['id']."&amp;sub=".$_GET['sub']."' class='maintext'><b>" : "<A href='index.php?m=products&amp;cat=".$data['id']."&amp;sub=".$_GET['sub']."' class='maintext'>";
					$bold_e = ( $data['id'] == $cat) ? "</b></a>" : "</a>";
					$str .= $bold_s.stripslashes($data['name']).$bold_e;
					$str .= "&nbsp;&nbsp;&nbsp;";
				}
		$str .= "</td></tr>";
		$str .= "<tr><td height=5></td></tr>";
	$str .= "</table>";
	
	return $str;
}

/****************************************************************************************************/
/****************************************************************************************************/
/****************************************************************************************************/

function gallery()
{

	global $data_colors,$data_name,$word,$settings;
	
	if( $data_name['flex_galleryType'] == "6" )
	{
		gallery_type_6();
			return "";
	}
	
	$L = ( $_GET['L'] == "") ? "0" : ifint($_GET['L']);
	
	$subject_id = ( $_GET['sub'] == "" ) ? "AND subject_id = ''" : "AND subject_id = ".ifint($_GET['sub']);
	$sql = "select * from user_gallery_cat where unk = '".UNK."' and deleted = '0' and active = '0' ".$subject_id." ORDER BY place desc limit 1";
	$res = mysql_db_query(DB,$sql);
	$data_cat = mysql_fetch_array($res);
	
	
	$temp_cat = ( $_GET['cat'] ) ? $_GET['cat'] : $data_cat['id'];
	$temp_catZero = ( $_GET['cat'] != "" ) ? $_GET['cat'] : "0";
	
	$sql = "select * from user_gallery_images where unk = '".UNK."' and deleted = '0' and cat = '".ifint($temp_cat)."' order by place limit ".$L.",12";
	$res = mysql_db_query(DB,$sql);
	
	$sql = "select id from user_gallery_images where unk = '".UNK."' and deleted = '0' and cat = '".ifint($temp_cat)."'";
	$res_num = mysql_db_query(DB,$sql);
	$num_rows = mysql_num_rows($res_num);
	
	
if( UNK == "443187964674794009" )
{
	echo "<table border=\"0\" cellspacing=\"0\" cellpadding=\"0\" class=\"maintext\" width=\"100%\">";
		
		if( $data_name['have_ProGal_cats'] == 0 )
		{
			echo "<tr>";
				echo "<td width=\"100%\">".get_gallery_cat($temp_cat)."</td>";
			echo "</tr>";
		}
		
		echo "<tr>";
			echo "<td>";
					echo "<div id=\"galleryDiv\"></div>";
					echo "
						<script type='text/javascript'>
							var params = new Object();
							params.parentName = \"galleryDiv\";
							params.cat = \"".$temp_cat."\";
							params.unk = \"".UNK."\";
							params.url = \"/create_xml.php\";
							loadGallery(params)
						</script>
					";
			echo "</td>";
		echo "</tr>";
	echo "</table>";
}
elseif( UNK == "438418905102508493" || UNK == "235414525040051953")
{
	echo "<table border=\"0\" cellspacing=\"0\" cellpadding=\"0\" class=\"maintext\" width=\"100%\">";
	
		//if( $data_name['have_ProGal_cats'] == 0 )
		//{
			echo "<tr>";
				echo "<td width=\"100%\">".get_gallery_cat($temp_cat)."</td>";
			echo "</tr>";
		//}
		
		echo "<tr>";
			echo "<td>";
					echo "<div id=\"galleryDiv\"></div>";
					echo "
						<script type='text/javascript'>
							unk = \"".UNK."\";
									url = \"/create_xml.php\";
									cat = \"".$temp_cat."\";
									parentName = \"galleryDiv\";
									loadGallery(unk,url,cat,parentName);
						</script>
					";
			echo "</td>";
		echo "</tr>";
	echo "</table>";
}
elseif( $data_name['flex_gallery'] == "1" )
{
	echo "<table border=\"0\" cellspacing=\"0\" cellpadding=\"0\" class=\"maintext\" width=\"100%\">";
		echo "<tr><td height=10></td></tr>";
		switch( $data_name['flex_galleryType'] )
		{
			case "2" :
				if( $data_name['have_ProGal_cats'] == 0 )
				{
				echo "<tr>";
					echo "<td width=\"100%\">".get_gallery_cat($temp_cat)."</td>";
				echo "</tr>";
				}
				
				echo "<tr>";
					echo "<td>";
							echo "<div id=\"galleryDiv\"></div>";
							echo "
								<script type='text/javascript'>
									var params = new Object();
									params.parentName = \"galleryDiv\";
									params.cat = \"".$temp_cat."\";
									params.unk = \"".UNK."\";
									params.url = \"/create_xml.php\";
									loadGallery(params)
								</script>
							";
					echo "</td>";
				echo "</tr>";
			break;
			
			case "5" :
			case "4" :
				if( $data_name['have_ProGal_cats'] == 0 )
				{
					if( $temp_cat != "0" )
					{
						echo "<tr>";
							echo "<td width=\"100%\"><table border=\"0\" cellspacing=\"0\" cellpadding=\"0\" class=\"maintext\"><tr><td width=15></td><td>".get_gallery_cat($temp_cat)."</td><td width=15></td></tr></table></td>";
						echo "</tr>";
					}
				}
				if( UNK == "328173266823780781" )
				{
					$sql = "select name from user_gallery_cat where unk = '".UNK."' and deleted = '0' AND id='".ifint($_GET['cat'])."'";
					$res = mysql_db_query(DB,$sql);
					$dataCatU = mysql_fetch_array($res);
					
					echo "<tr>
						<td>
							<table border=\"0\" cellspacing=\"0\" cellpadding=\"0\" class=\"maintext\" width=\"100%\">
								<tr>
									<td width=10></td>
									<td style='font-size:14px;'><b>".stripslashes($dataCatU['name'])."</b></td>
									<td width=30></td>
								</tr>
							</table>
						</td>
					</tr>";
				}
				
				echo "<tr>";
					echo "<td height=600>";
							echo "<div id=\"galleryDiv\" style='height: 100%;'></div>";
							echo "
								<script type='text/javascript'>
									unk = \"".UNK."\";
									url = \"/create_xml.php\";
									cat = \"".$temp_cat."\";
									parentName = \"galleryDiv\";
									loadGallery(unk,url,cat,parentName);
								</script>
							";
					echo "</td>";
				echo "</tr>";
				
				if( UNK == "328173266823780781" )
					castum_gallery_traktoron_motza();
				
			break;
				
			default :
				echo "<tr>";
					echo "<td>";
							echo "<div id=\"galleryDiv\"></div>";
							echo "
								<script type='text/javascript'>
									var params = new Object();
									parentName = \"galleryDiv\";
									unk = \"".UNK."\";
									url = \"/create_xml.php\";
									cat = \"".$temp_catZero."\";
									loadFlexGallery(unk,cat,url,parentName);
								</script>
							";
					echo "</td>";
				echo "</tr>";
			
		}
	echo "</table>";
}
else
{
	
	echo "<table border=\"0\" cellspacing=\"0\" cellpadding=\"0\" class=\"maintext\" width=\"100%\">";
		echo "<tr><td height=10></td></tr>";
		if( $data_name['have_ProGal_cats'] == 0 )
		{
			echo "<tr>";
				echo "<td width=\"100%\">".get_gallery_cat($temp_cat)."</td>";
			echo "</tr>";
		}
		
		if( $num_rows > 12 )
		{
			echo "<tr>";
				echo "<td width=\"100%\" align=\"center\">";
					echo $word[LANG]['1_1_gallery_total']." ".$num_rows." ".$word[LANG]['1_1_gallery_images']."<bR>";
					
					echo "<table border='0' cellpadding='0' cellspacing='0' class='maintext'>
						<tr>";
									$z = 1;
									
									for($i=0 ; $i < $num_rows ; $i++)	 {
										if($i % 12 == 0)	{
										
											$classi = ($i == $L)? "<td valign='top'><b>".$z."</b></td><td width='5'></td><td>|</td><td width='5'></td>" : "<td valign='top'><a title='".$alt_text."' href='index.php?m=gallery&L=".$i."&cat=".$_GET['cat']."&sub=".$_GET['sub']."' class='maintext'><u>".$z."</u></a></td><td width='5'></td><td>|</td><td width='5'></td>";
											echo $classi;
									 $z = $z + 1;
										}
									 }
						echo "</tr>
					</table>";
					
				echo "</td>";
			echo "</tr>";
		}
		
		echo "<tr>";
			echo "<td width=\"100%\" align=\"left\">";
				
					echo "<div id=\"gallerycontainer\"   class=\"gallerycontainer\">";
						echo "<div id=\"gallerycontainerMain\"  class=\"gallerycontainer_main\">";
						echo "</div>";
					echo "<div class=\"gallerycontainer_list\">";
						$counter = 1;
						while( $data = mysql_fetch_array($res) )
						{
							
							$abpath_temp_unlink = SERVER_PATH."/gallery/".$data['img'];
							
							$abpath_temp_unlinkl = SERVER_PATH."/gallery/L".$data['img'];
							
							$exist_img = ( $counter == 1 ) ? "gal_thumbnail2" : "gal_thumbnail";
							if( file_exists($abpath_temp_unlink) && !is_dir($abpath_temp_unlink) ){
								?>
								<a rel="fancy_image" href="<?php HTTP_PATH; ?>/gallery/L<?php echo $data['img']; ?>" title="<?php echo nl2br(htmlspecialchars(stripslashes($data['content']))); ?>" id="gallery_item_<?php echo $counter; ?>" class="<?php echo $exist_img; ?> gallery_item">
									<img src="<?php echo HTTP_PATH; ?>/gallery/<?php echo $data['img']; ?>" height="50px" width="60px" border="0" />
										<span class='item-content' style='display:none;'>
											<img src="<?php HTTP_PATH; ?>/gallery/L<?php echo $data['img']; ?>" />
											<br />
											<div align="right" class='rightMenu'>
												<?php echo nl2br(htmlspecialchars(stripslashes($data['content']))); ?>
											</div>
										</span>
									</a>
									
								<div class='gallery_item_mobile'>
									<img src="<?php HTTP_PATH; ?>/gallery/L<?php echo $data['img']; ?>" />
									<br />
									<div align="right" class='rightMenu'>
										<?php echo nl2br(htmlspecialchars(stripslashes($data['content']))); ?>
									</div>
									
								</div>	
								<?php
							}
							
							//if( $counter%2 == 0 )
								//echo "<br>";
							$counter++;
						}
				echo "</div>";
				echo "</div>";
				?>
				<script type="text/javascript" src="http://ilbiz.co.il/ClientSite/version_1/style/fancybox/jquery.fancybox-1.3.4.js"></script>
				<link rel="stylesheet" type="text/css" href="http://ilbiz.co.il/ClientSite/version_1/style/fancybox/jquery.fancybox-1.3.4.css" media="screen" />				
											
				<script type="text/javascript">
					jQuery(function($){
						$(document).ready(function() {
							$("a[rel=fancy_image]").fancybox({
								'transitionIn'		: 'none',
								'transitionOut'		: 'none',
								
							});
						});
					});
				</script>				
				<script type="text/javascript">
					
						jQuery(function($){
							
							var ht1 = $("#gallery_item_1").find(".item-content").html();
							$("#gallerycontainerMain").html(ht1);
							$(".gallery_item").hover(function(){
								var ht = $(this).find(".item-content").html();
								  $("#gallerycontainerMain").html(ht);
							});							
						});
					
				</script>
				<?php 
			echo "</td>";
		echo "</tr>";
		
		if( $num_rows > 12 )
		{
			echo "<tr>";
				echo "<td width=\"100%\" align=\"center\">";
					echo $word[LANG]['1_1_gallery_total']." ".$num_rows." ".$word[LANG]['1_1_gallery_images']."<bR>";
					
					echo "<table border='0' cellpadding='0' cellspacing='0' class='maintext'>
						<tr>";
									$z = 1;
									
									for($i=0 ; $i < $num_rows ; $i++)	 {
										if($i % 12 == 0)	{
										
											$classi = ($i == $L)? "<td valign='top'><b>".$z."</b></td><td width='5'></td><td>|</td><td width='5'></td>" : "<td valign='top'><a title='".$alt_text."' href='index.php?m=gallery&L=".$i."&cat=".$_GET['cat']."&sub=".$_GET['sub']."' class='maintext'><u>".$z."</u></a></td><td width='5'></td><td>|</td><td width='5'></td>";
											echo $classi;
									 $z = $z + 1;
										}
									 }
						echo "</tr>
					</table>";
					
				echo "</td>";
			echo "</tr>";
		}		
		
	echo "</table>";
}
}


function get_gallery_cat($cat="")
{
	global $word;
	
	$subject_id = ( $_GET['sub'] == "" ) ? "AND subject_id = '0'" : "AND subject_id = ".ifint($_GET['sub']);
	$sql = "select * from user_gallery_cat where unk = '".UNK."' and deleted = '0' and active = '0' ".$subject_id." ORDER BY place ";
	$res = mysql_db_query(DB,$sql);
	
	
	$sql = "select * from user_images_cat_subject where unk = '".UNK."' and deleted = '0' and active = '0'";
	$res_all = mysql_db_query(DB,$sql);
	$data_num_all = mysql_num_rows( $res_all );
	
	$gotoGalleeyZoomom = ( UNK == "463632676397782499" ) ? "zoom_gallery" : "ga";
	$str;
	
	$zaafan_font_color = ( UNK == "463632676397782499" ) ? "style='color: #000000;'" : "";
	$str .= "<table border=\"0\" cellspacing=\"0\" cellpadding=\"0\" class=\"maintext\" ".$zaafan_font_color.">";
	
	if( $data_num_all > 0 )
	{
		$str .= "<form action=\"index.php\" name=\"select_subject_form\" method=\"get\">";
		$str .= "<input type='hidden' name='m' value='".$gotoGalleeyZoomom."'>";
	
			$str .= "<tr>";
				$str .= "<td align=\"".$settings['re_align']."\" valign=top>";
			
					$str .= "<select name='sub' class='input_style' style=\"width:250px; height: 18px;\" onchange=\"select_subject_form.submit()\">";
					$str .= "<option value=''>".$word[LANG]['1_1_gallery_choose_subject']."</option>";
					while( $data_all = mysql_fetch_array($res_all) )
					{
						$selected = ( $data_all['id'] == $_GET['sub'] ) ? "selected" : "";
						$str .= "<option value='".$data_all['id']."' ".$selected.">".htmlspecialchars(stripslashes($data_all['name']))."</option>";
					}
			
				$str .= "</td>";
			$str .= "</tr>";
			$str .= "</form>";
	}
		$str .= "<tr><td height=5></td></tr>";
		$str .= "<tr><td>";
	
				while( $data = mysql_fetch_array($res) )
				{
					$bold_s = ( $data['id'] == $cat) ? "<b>" : "<A href='index.php?m=".$gotoGalleeyZoomom."&cat=".$data['id']."&sub=".$_GET['sub']."' ".$zaafan_font_color." class='maintext'>";
					$bold_e = ( $data['id'] == $cat) ? "</b>" : "</A>";
					$str .= $bold_s.stripslashes($data['name']).$bold_e;
					$str .= "&nbsp; &nbsp;";
				}
		$str .= "</td></tr>";
		$str .= "<tr><td height=5></td></tr>";
	$str .= "</table>";
	
	return $str;
}

/****************************************************************************************************/
/****************************************************************************************************/
/****************************************************************************************************/

function video()
{
	global $data_extra_settings, $data_colors,$word,$settings;
	if($data_extra_settings['products_version'] == '1'){	
		echo version_1_video();
		return;
	}	
	if( $data_colors['kobia_type'] == "1" )
	{
		getKobiaDesigner( "video" );
			return "";
	}
	
	$limitcount = ( $_GET['PL'] == "" ) ? $_POST['PL'] : $_GET['PL'];
	$limitcount = ( $limitcount == "" ) ? "0" : ifint($limitcount);
	
	$temp_cat = ( $_GET['cat'] ) ? " and cat='".ifint($_GET['cat'])."'" : "";
	$sql = "select * from user_video where unk = '".UNK."' and deleted = '0' ".$temp_cat." and active = '0' order by id DESC,place  LIMIT ".$limitcount.",21";
	$res = mysql_db_query(DB,$sql);
	
	$sql2 = "select COUNT(id) as num_rows from user_video where unk = '".UNK."' and deleted = '0' ".$temp_cat." and active = '0'";
	$res2 = mysql_db_query(DB,$sql2);
	$data2 = mysql_fetch_array($res2);
	
	echo "<table border=\"0\" cellspacing=\"0\" cellpadding=\"0\" class=\"maintext\" width=\"100%\">";
		
		if( $data_name['have_ProGal_cats'] == 0 )
		{
			echo "<tr>";
				echo "<td width=\"100%\" colspan=10>".get_video_cat($_GET['cat'])."</td>";
			echo "</tr>";
		}
		
		$counter = 0;
		while( $data = mysql_fetch_array($res) )
		{
			if( $counter%3 == 0 )
			echo "<tr>";
				
				$abpath_temp = SERVER_PATH."/video/".$data['img'];
				if( file_exists($abpath_temp) && !is_dir($abpath_temp) )
				{
					$im_size = GetImageSize ($abpath_temp); 
					$imageWidth = $im_size[0]; 
					$imageheight = $im_size[1]; 
					$img_src = "<a href=\"index.php?m=s.vi&ud=".$data['id']."&cat=".$_GET['cat']."\" class=\"maintext\" title=\"".htmlspecialchars(stripslashes($data['name']))."\"><img src='video/{$data['img']}' border='0' height=\"{$imageheight}\" width=\"".$imageWidth."\"></a>";
				}
				else
				{
					$img_src = "";
					$imageWidth = "76%";
				}
				
				echo "<td valign=\"top\" height=\"100%\" align=\"center\" width=\"33%\">
					<table border=\"0\" cellspacing=\"0\" cellpadding=\"0\" class=\"site_border\" height=\"100%\"  width=\"156\">
						<tr><td colspan=\"3\"></td></tr>
						<tr>
							<td width=\"3\">
							<td valign=\"top\" height=\"100%\">
								<table border=\"0\" height=\"100%\" cellspacing=\"0\" cellpadding=\"0\" class=\"maintext\">
									
									<tr>
										<td align=\"".$settings['align']."\" valign=\"top\"><a href=\"index.php?m=s.vi&ud=".$data['id']."&cat=".$_GET['cat']."\" class=\"maintext\" title=\"".htmlspecialchars(stripslashes($data['name']))."\"><b>".htmlspecialchars(stripslashes($data['name']))."</b></a></td>
									</tr>
									
									<tr><td colspan=\"3\" height=\"1\"></td></tr>
									
									<tr>
										<td colspan=\"3\" valign=\"top\">{$img_src}</td>
									</tr>
									
								
									
									<tr><td colspan=\"3\" height=\"3\"></td></tr>
									<tr>
										<td align=\"".$settings['align']."\" valign=\"top\"><b>".nl2br(stripslashes(htmlspecialchars($data['summary'])))."</b></td>
									</tr>
									<tr><td colspan=\"3\" height=\"3\"></td></tr>
									<tr>
										<td align=\"center\"><a href=\"index.php?m=s.vi&ud=".$data['id']."&cat=".$_GET['cat']."\" class=\"maintext\" title=\"".htmlspecialchars(stripslashes($data['name']))."\"><b>".$word[LANG]['1_1_video_more_info']."</b></a></td>
									</tr>
									
								</table>
							</td>
							<td width=\"3\">
						</tr>
						<tr><td colspan=\"3\" height=\"5\"></td></tr>
					</table>
				</td>";
				
			$counter++;
			
			if( $counter%3 == 0 )
			{
			echo "</tr>
			<tr><td height=\"15\"></td></tr>";
			}
		}
		
		echo "<tr>";
			echo "<td align=center colspan=10>";
				$params['limitInPage'] = "21";
				$params['numRows'] = $data2['num_rows'];
				$params['limitcount'] = $limitcount;
				$params['m'] = $_GET['m'];
				$params['cat'] = $_GET['cat'];
				$params['sub'] = $_GET['sub'];
				
				getLimitPagention( $params );
				
			echo "<td>";
		echo "</tr>";
		
	echo "</table>";
}


function s_video()
{
	global $data_extra_settings,$data_colors, $word, $temp_word_video;
	if($data_extra_settings['products_version'] == '1'){	
		echo version_1_s_video();
		return;
	}	
	$sql = "select * from user_video where unk = '".UNK."' and deleted = '0' and active = '0' and id = '".ifint($_GET['ud'])."' limit 1";
	$res = mysql_db_query(DB,$sql);
	$data = mysql_fetch_array($res);
	
	$content = string_rplace_func($data['content']);
		
	echo "<table border=\"0\" cellspacing=\"0\" cellpadding=\"0\" class=\"maintext\" width=\"100%\">";
		
		if( $data_name['have_ProGal_cats'] == 0 )
		{
			echo "<tr>";
				echo "<td width=\"100%\" colspan=10>".get_video_cat()."</td>";
			echo "</tr>";
		}
		
		echo "<tr>";
			echo "<td><h1 style=\"font-size:16px\">".htmlspecialchars(stripslashes($data['name']))."</h4></td>";
		echo "</tr>";
		
		echo "<tr>";
			echo "<td><a href='index.php?m=vi'>".$word[LANG]['1_1_general_back_to'].$temp_word_video."</a></td>";
		echo "</tr>";
		
		echo "<tr><td height=\"5\"></td></tr>";
		
		echo "<tr>";
			echo "<td valign=\"top\">";
				if( $data['video_flash'] )
					echo "<p align=center>".stripslashes($data['video_flash'])."</p>";
				elseif( $data['video_url'] )
					echo "<p align=center><embed src=\"{$data['video_url']}\" loop=\"0\" autostart=\"true\" width=320 height=240></embad></p>";
				
				
				echo "<b>".nl2br(htmlspecialchars(stripslashes($data['summary'])))."</b><br><br><br>
				".nl2br(htmlspecialchars(stripslashes($content)))."<br><br>";
				
				if( $data['url_link_href'] != "" && $data['url_link_name'] != "" )
					echo "<a href='".$data['url_link_href'] ."' class='maintext_link'>".$data['url_link_name']."</a>";
				
			echo "</td>";
		echo "</tr>";
		
	echo "</table>";
}


function get_video_cat($cat="")
{
	$sql = "select * from user_video_cat where unk = '".UNK."' and deleted = '0' and active = '0'";
	$res = mysql_db_query(DB,$sql);
	
	echo "<p class='maintext'>";
				while( $data = mysql_fetch_array($res) )
				{
					$bold_s = ( $data['id'] == $cat) ? "<b>" : "<A href='index.php?m=vi&cat=".$data['id']."' class='maintext'>";
					$bold_e = ( $data['id'] == $cat) ? "</b>" : "</a>";
					echo $bold_s.stripslashes($data['name']).$bold_e;
					echo "&nbsp;&nbsp;&nbsp;";
				}
	echo "</p>";
	
}

/********************************************************************************/
/********************************   home page    ********************************/
/********************************************************************************/

function hp()
{
	global $data_colors,$data_words,$settings, $word, $data_extra_settings;
	if($data_colors['home_portal_version'] == '1'){
		require_once('/home/ilan123/domains/ilbiz.co.il/public_html/ClientSite/version_1/functions/modules/hp.php');	
		return version_1_hp();
	}
	
	
	$sql = "select * from user_hp_conf where unk = '".UNK."'";
	$res = mysql_db_query(DB,$sql);
	$data = mysql_fetch_array($res);
	
	$sql = "select have_hp_banners,hp_type,hp_text from users where unk = '".UNK."'";
	$res_have_hp_banners = mysql_db_query(DB,$sql);
	$data_have_hp_banners = mysql_fetch_array($res_have_hp_banners);
	
	$sql = "select adv_banner_2,adv_banner_1,adv_banner_1_width,adv_banner_1_height from user_hp_conf where unk = '".UNK."'";
	$res_adv_banner = mysql_db_query(DB,$sql);
	$data_adv_banner = mysql_fetch_array($res_adv_banner);
	
	$style_kol_hpHeadline = ( UNK == "263512086634836547" ) ? "background: url('/upload_pics/Image/otherImagesCore/dupli_headline_area.jpg'); color: #ff8c25;" : "";
	$style_kol_Color = ( UNK == "263512086634836547" ) ? "ff8c25" : $data_colors['color_link'];
	
	echo "<table border=\"0\" cellspacing=\"0\" cellpadding=\"0\" class=\"maintext\">";
	
		if( UNK == "921238110257449030" )
		{
			echo "<tr><td colspan=3 align=center><iframe src=\"http://search.tropi-tours.co.il/\" width=\"428\" height=\"245\" scrolling=no frameborder=0 marginheight=0 marginwidth=0></iframe></td></tr>";
		}
		
		
		if( $data_have_hp_banners['hp_type'] == "0" )
		{
		$abpath_ban1 = SERVER_PATH."/tamplate/".stripslashes($data_adv_banner['adv_banner_1']);
		
		if( $data_have_hp_banners['have_hp_banners'] == "1" && file_exists($abpath_ban1) && !is_dir($abpath_ban1) )
		{
			$style_kol_border = ( UNK == "263512086634836547" ) ? "style='border: 1px solid #".$data_colors['border_color'].";'" : "";
			
			echo "<tr>";
				echo "<td colspan=3 align=right >";
					echo "<table border=\"0\" cellspacing=\"0\" cellpadding=\"0\" class=\"maintext\" align=center width=\"570\" ".$style_kol_border."> ";
						if( UNK == "263512086634836547" )
						{
								echo "<tr>";
									echo "
									<Td>
										<table border=0 cellspacing=\"0\" width=100% cellpadding=\"0\" class=\"maintext\">
											<tr>
												<td height=25 align=\"center\" bgcolor=\"#".$data_colors['bg_link']."\" style=\"".$style_kol_hpHeadline."\">
													<table border=\"0\" cellspacing=\"0\" cellpadding=\"0\" class=\"maintext\" >
														<tr><td height=3></td></tr>
														<tr>
															<td style=\"color:#".$style_kol_Color."\"><b>בחר מדריך</b></td>
														</tr>
														<tr><td height=3></td></tr>
													</table>
												</td>
											</tr>
										</table>
									</td>
									";
								echo "</tr>";
								
								echo "<tr>";
									echo "<td align=center>";
									
											echo "
												<object classid=\"clsid:d27cdb6e-ae6d-11cf-96b8-444553540000\" codebase=\"http://download.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=7,0,0,0\" width='570' height='210' id=\"Untitled-1\" align=\"middle\">
												<param name=\"allowScriptAccess\" value=\"sameDomain\" />
												<param name=\"movie\" value=\"carousel.swf\"/>
												<param name=\"quality\" value=\"high\" />
												<embed src=\"carousel.swf\" quality=\"high\" name=\"Untitled-1\" align=\"middle\" width='570' height='210' allowScriptAccess=\"sameDomain\" type=\"application/x-shockwave-flash\" pluginspage=\"http://www.macromedia.com/go/getflashplayer\" />
												</object>";	
									echo "</td>";
								echo "</tr>";
						}
						else
						{
							echo "<tr>";
								echo "<td align=center>";
									$temp_test = explode( "." , $data_adv_banner['adv_banner_1'] );
						
									if( $temp_test[1] == "swf" )
									{
								
										echo "
																		<!--url's used in the movie-->
																		<!--text used in the movie-->
																		<object classid=\"clsid:d27cdb6e-ae6d-11cf-96b8-444553540000\" codebase=\"http://download.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=7,0,0,0\" width='".stripslashes($data_adv_banner['adv_banner_1_width'])."' height='".stripslashes($data_adv_banner['adv_banner_1_height'])."' id=\"Untitled-1\" align=\"middle\">
																		<param name=\"allowScriptAccess\" value=\"sameDomain\" />
																		<param name=\"movie\" value=\"/tamplate/".stripslashes($data_adv_banner['adv_banner_1'])."\"/>
																		<param name=\"quality\" value=\"high\" />
																		<embed src=\"/tamplate/".stripslashes($data_adv_banner['adv_banner_1'])."\" quality=\"high\" name=\"Untitled-1\" align=\"middle\" width='".stripslashes($data_adv_banner['adv_banner_1_width'])."' height='".stripslashes($data_adv_banner['adv_banner_1_height'])."' allowScriptAccess=\"sameDomain\" type=\"application/x-shockwave-flash\" pluginspage=\"http://www.macromedia.com/go/getflashplayer\" />
																		</object>";	
									}
									else
									{
										echo "<img src=\"/tamplate/".stripslashes($data_adv_banner['adv_banner_1'])."\" border='0'>";
									}
								echo "</td>";
							echo "</tr>";
						}
					echo "</table>";
				echo "</td>";
			echo "</tr>";
			}
						
			echo "<tR>";
				echo "<td valign=\"top\" width=\"450\">
					<table border=\"0\" cellspacing=\"0\" cellpadding=\"0\" class=\"maintext\">";
		
						for( $oi=0 ; $oi<=1 ; $oi++ )
						{
							$temp = explode("-" , $data['right_place'] );
							
							switch($temp[$oi])
							{
								// * * * * * * * * * *  Articels * * * * * * * * * * * * *
								case "0" :
									$sql_arti = "select id,headline,summary,img from user_articels where unk = '".UNK."' and status = '0' and deleted = '0' order by id desc limit ".$data['arti_limit'];
									$res_arti = mysql_db_query(DB,$sql_arti);
									
									$temp_word_articels = ( $data_words['id'] == "" ) ? $word[LANG]['1_2_chapter_name_articels'] : stripslashes($data_words['word_articels']);
									
									//echo "<tR><td style=\"font-size:16px;\"><b>".$temp_word_articels."</b></td></tr>";
									echo "<tr><td height=\"5\"></td></tr>";
									while( $data_arti = mysql_fetch_array($res_arti) )
									{
									
									echo "<tR>";
										echo "<td valign=top height=178 style=\"border: 1px solid #".$data_colors['border_color'].";border-bottom: 0px solid #".$data_colors['border_color'].";border-left: 1px solid #".$data_colors['border_color'].";\">";
											echo "<table border=0 cellspacing=\"0\" width=100% cellpadding=\"0\" class=\"maintext\">";
												
													$abpath_temp = SERVER_PATH."/articels/".$data_arti['img'];
													if( file_exists($abpath_temp) && !is_dir($abpath_temp) )
													{
														$im_size = GetImageSize ($abpath_temp); 
														$imageWidth = $im_size[0]; 
														$imageheight = $im_size[1]; 
														if( $imageWidth > 138 )
															$imageWidth = "138";
														$img = "<a href='index.php?m=ar&artd=".$data_arti['id']."' class=\"maintext\" title=\"".htmlspecialchars(stripslashes($data_arti['headline']))."\"><img src='articels/{$data_arti['img']}' border='0' hspace='10' width='".$imageWidth."' vspace='0' align='".$settings['align']."'></a>";
													}
													else
														$img = "";
														
													echo "<tr>";
														echo "
														<Td colspan=3>
															<table border=0 cellspacing=\"0\" width=100% cellpadding=\"0\" class=\"maintext\">
																<tr>
																	<td height=25 align=\"center\" bgcolor=\"#".$data_colors['bg_link']."\" style=\"".$style_kol_hpHeadline."\">
																		<table border=\"0\" cellspacing=\"0\" cellpadding=\"0\" class=\"maintext\" >
																			<tr><td height=3></td></tr>
																			<tr>
																				<td style=\"color:#".$style_kol_Color."\"><a href='index.php?m=ar&artd=".$data_arti['id']."' class=\"maintext\" style=\"color:#".$style_kol_Color."\" title=\"".htmlspecialchars(stripslashes($data_arti['headline']))."\"><b>".htmlspecialchars(stripslashes($data_arti['headline']))."</b></a></td>
																			</tr>
																			<tr><td height=3></td></tr>
																		</table>
																	</td>
																</tr>
															</table>
														</td>
														";
													echo "</tr>";
													echo "<tr><td height=\"5\" colspan=3></td></tr>";
													echo "<tr>";
														echo "<td width=10></td>";
														echo "<Td>".$img." ".nl2br(htmlspecialchars(stripslashes($data_arti['summary'])))."</td>";
														echo "<td width=10></td>";
													echo "</tr>";
													echo "<tr>";
														echo "<td width=10></td>";
														echo "<td align=\"".$settings['re_align']."\"><a href='index.php?m=ar&artd=".$data_arti['id']."' class=\"maintext\" title=\"".htmlspecialchars(stripslashes($data_arti['headline']))."\">".$word[LANG]['1_1_hp_read_art']."</a></td>";
														echo "<td width=10></td>";
													echo "</tr>";
											echo "</table>";
										echo "</td>";
									echo "</tR>";	
									}
									
									if( UNK == "096007254104704872" || UNK == "263512086634836547" )
										castum_negev_chamber_hp_jobs();
									
								break;
								
								// * * * * * * * * * *  Video AND Gallery * * * * * * * * * * * * *
								case "1" :
									$sql_vid = "select * from user_video where unk = '".UNK."' and deleted = '0' and active = '0' order by rand()";
									$res_vid = mysql_db_query(DB,$sql_vid);
									$data_vid = mysql_fetch_array($res_vid);
									
									$abpath_temp = SERVER_PATH."/video/".$data_vid['img'];
									
									if( file_exists($abpath_temp) && !is_dir($abpath_temp) )
									{
										$im_size = GetImageSize ($abpath_temp); 
										$imageWidth = $im_size[0]; 
										$imageheight = $im_size[1]; 
										$img_src = "<a href=\"index.php?m=s.vi&ud=".$data_vid['id']."\" class=\"maintext\" title=\"".htmlspecialchars(stripslashes($data_vid['name']))."\"><img src='video/{$data_vid['img']}' border='0' width=\"".$imageWidth."\"></a>";
									}
									else
										$img_src = "";
								
									echo "<tR>";
									//   v i d e o
										echo "<td style=\"border-left: 1px solid #".$data_colors['border_color'].";\">";
											echo "<table height=250 border=0 cellspacing=\"0\" cellpadding=\"0\" class=\"maintext\" width=100%>";
												echo "<tr>";
													echo "<td style=\"border: 1px solid #".$data_colors['border_color'].";\" width=\"50%\" valign=top>
														<table border=\"0\" height=\"100%\" width=\"100%\" align=\"center\" cellspacing=\"0\" cellpadding=\"0\" class=\"maintext\">";
															$temp_word_video = ( $data_words['id'] == "" ) ? $word[LANG]['1_2_chapter_name_video'] : stripslashes($data_words['word_video']);
															
															echo "<tr>
																<td height=25 align=\"center\" style=\"border-bottom: 1px solid #".$data_colors['border_color']."; ".$style_kol_hpHeadline."\" bgcolor=\"#".$data_colors['bg_link']."\">
																	<table border=\"0\" cellspacing=\"0\" cellpadding=\"0\" class=\"maintext\">
																		<tr><Td height=3></td></tr>
																		<tr>
																			<td style=\"color:#".$style_kol_Color.";\"><b>".htmlspecialchars($temp_word_video)."</b></td>
																		</tr>
																		<tr><Td height=3></td></tr>
																	</table>
																</td>
															</tr>";
															echo "<tr>
																<td>
																	<table border=\"0\" width=\"150\" align=\"center\" cellspacing=\"0\" cellpadding=\"0\" class=\"maintext\">
																		<tr>
																			<td align=\"".$settings['align']."\" valign=\"top\"><a href=\"index.php?m=s.vi&ud=".$data_vid['id']."\" class=\"maintext\" title=\"".htmlspecialchars(stripslashes($data_vid['name']))."\"><b>".htmlspecialchars(stripslashes($data_vid['name']))."</b></a></td>
																		</tr>
																		<tr><td colspan=\"3\" height=\"1\"></td></tr>
																		<tr>
																			<td colspan=\"3\" valign=\"top\">{$img_src}</td>
																		</tr>
																		<tr><td colspan=\"3\" height=\"3\"></td></tr>
																		<tr>
																			<td align=\"".$settings['align']."\" valign=\"top\">".nl2br(stripslashes(htmlspecialchars($data_vid['summary'])))."</td>
																		</tr>
																		<tr><td colspan=\"3\" height=\"3\"></td></tr>
																		<tr>
																			<td align=\"center\"><a href=\"index.php?m=s.vi&ud=".$data_vid['id']."\" class=\"maintext\" title=\"".htmlspecialchars(stripslashes($data_vid['name']))."\"><b>".$word[LANG]['1_1_video_more_info']."</b></a></td>
																		</tr>
																	</table>
																</td>
															</tr>";
															echo "
															
														</table>";
													echo "</td>";
													
										//   G a l l e r y
											
													$sql_gallery = "select ugi.* from user_gallery_images as ugi , user_gallery_cat as ugc where ugi.unk = '".UNK."' and ugi.deleted = '0' and ugc.active = 0 and ugc.deleted = 0 and ugc.id = ugi.cat  order by rand() limit 1";
													$res_gallery = mysql_db_query(DB,$sql_gallery);
													$data_gallery = mysql_fetch_array($res_gallery);
													
													$abpath_temp_gallery = SERVER_PATH."/gallery/L".$data_gallery['img'];
													if( file_exists($abpath_temp_gallery) && !is_dir($abpath_temp_gallery) )
													{
														$im_size = GetImageSize ($abpath_temp_gallery); 
														$imageWidth = $im_size[0]; 
														$imageheight = $im_size[1];
														if( $imageWidth > "170" )
															$imageWidth = "170";
														$img_src = "<a class=\"{$exist_img}\" href=\"index.php?m=gallery&cat=".$data_gallery['cat']."\"><img src=\"".HTTP_PATH."/gallery/L".$data_gallery['img']."\" width=\"215\" border=\"0\" /></a>";
													}
													else
														$img_src = "";
													echo "<td style=\"border: 1px solid #".$data_colors['border_color']."; border-left: 0px solid #".$data_colors['border_color']."; border-right: 0px solid #".$data_colors['border_color'].";\" width=\"50%\" align=".$settings['re_align']." valign=top>
														<table border=\"0\" height=\"100%\" align=".$settings['re_align']." cellspacing=\"0\" width=\"100%\" cellpadding=\"0\" class=\"maintext\">";
															$temp_word_gallery = ( $data_words['id'] == "" ) ? $word[LANG]['1_2_chapter_name_gallery'] : stripslashes($data_words['word_gallery']);
															
															echo "<tr>
																<td height=25 align=\"center\" style=\"border-bottom: 1px solid #".$data_colors['border_color']."; ".$style_kol_hpHeadline."\" bgcolor=\"#".$data_colors['bg_link']."\">
																	<table border=\"0\" cellspacing=\"0\" cellpadding=\"0\" class=\"maintext\">
																		<tr><Td height=3></td></tr>
																		<tr>
																			<td style=\"color:#".$style_kol_Color."\"><b>".htmlspecialchars($temp_word_gallery)."</b></td>
																		</tr>
																		<tr><Td height=3></td></tr>
																	</table>
																</td>
															</tr>";
															echo "
															<tr>
																<td colspan=\"3\" valign=\"top\">{$img_src}</td>
															</tr>
															<tr><td colspan=\"3\" height=\"3\"></td></tr>
															<tr>
																<td align=\"".$settings['align']."\" valign=\"top\">".nl2br(stripslashes(htmlspecialchars($data_gallery['content'])))."</td>
															</tr>
															<tr><td colspan=\"3\" height=\"3\"></td></tr>
															<tr>
																<td align=\"center\"><a href=\"index.php?m=gallery&cat=".$data_gallery['cat']."\" class=\"maintext\"><b>".$word[LANG]['1_1_hp_more_imgs']."</b></a></td>
															</tr>
															
														</table>";
													echo "</td>";
													
												echo "</tr>";
											echo "</table>";
										echo "</td>";
									echo "</tR>";	
								break;
							}
						}
						
						if( $data_extra_settings['haveFacebookHpActive'] == "1" && $data_extra_settings['facebookHpContent'] != "" )
						{
							echo "<tr>";
								echo "<td><br><br>";
									echo stripslashes($data_extra_settings['facebookHpContent']);
								echo "</td>";
							echo "</tr>";
						}
						
					echo "</table>
				</td>
				
				<td width='15'></td>";
				
				echo "<td valign=top width=\"140\" height='100%'>
					<table border=\"0\" cellspacing=\"0\" cellpadding=\"0\" class=\"maintext\">";
						echo "<tr><td height=\"5\"></td></tr>";
						
						$temp = explode("-" , $data['left_place'] );
						
						for( $oi=0 ; $oi<=3 ; $oi++ )
						{
							
							switch($temp[$oi])
							{
								// * * * * * * * * * *  News * * * * * * * * * * * * *
								case "0" :
									echo "<tR>";
										echo "<td valign=top align=\"right\">
											<table border=\"0\" cellspacing=\"0\" cellpadding=\"0\" class=\"maintext\" width=\"140\">";
										echo scroll_news("","index");
										echo "</table>
										</td>";
									echo "</tR>";
								break;
								
								case "0bot" :
									echo "<tR>";
										echo "<td valign=bottom align=\"right\">
											<table border=\"0\" cellspacing=\"0\" cellpadding=\"0\" class=\"maintext\">";
										echo scroll_news("","index");
										echo "</table>
										</td>";
									echo "</tR>";
								break;
								
								// * * * * * * * * * *  Sales * * * * * * * * * * * * *
								case "1" :
									$abpath_ban2 = SERVER_PATH."/tamplate/".stripslashes($data_adv_banner['adv_banner_2']);
									
									$banner_is_online = "0";
									if( $data_have_hp_banners['have_hp_banners'] == "1" && file_exists($abpath_ban2) && !is_dir($abpath_ban2) )
									{
										echo "<tR>";
											echo "<td height=177 valign=top width=\"138\" style=\"border: 1px solid #".$data_colors['border_color'].";border-bottom: 0px solid #".$data_colors['border_color'].";border-top: 0px solid #".$data_colors['border_color'].";\" align=\"".$settings['re_align']."\">";
													
														$temp_test = explode( "." , $data_adv_banner['adv_banner_2'] );
														
														if( $temp_test[1] == "swf" )
														{
															echo "
																	<!--url's used in the movie-->
																	<!--text used in the movie-->
																	<object classid=\"clsid:d27cdb6e-ae6d-11cf-96b8-444553540000\" codebase=\"http://download.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=7,0,0,0\" width=\"138\" height=\"177\" id=\"Untitled-1\" align=\"middle\">
																	<param name=\"allowScriptAccess\" value=\"sameDomain\" />
																	<param name=\"movie\" value=\"/tamplate/".stripslashes($data_adv_banner['adv_banner_2'])."\"/>
																	<param name=\"quality\" value=\"high\" />
																	<embed src=\"/tamplate/".stripslashes($data_adv_banner['adv_banner_2'])."\" quality=\"high\" width=\"138\" height=\"177\" name=\"Untitled-1\" align=\"middle\" allowScriptAccess=\"sameDomain\" type=\"application/x-shockwave-flash\" pluginspage=\"http://www.macromedia.com/go/getflashplayer\" />
																	</object>";	
														}
														else
														{
															echo "<img src=\"/tamplate/".stripslashes($data_adv_banner['adv_banner_2'])."\" border='0' width=\"138\" height=\"177\">";
														}
											echo "</td>";
										echo "</tR>";	
										
										$banner_is_online = "1";
									}
									if( $banner_is_online == "0" || UNK == "096007254104704872" )
									{
										if( UNK == "096007254104704872" )
											$sales_limit = "3";
										else
											$sales_limit = "1";
										
										$sql = "select have_sales_dates from users where unk = '".UNK."'";
										$resUsers = mysql_db_query(DB,$sql);
										$dataUsers = mysql_fetch_array($resUsers);
										
										$show_end_date = ( $dataUsers['have_sales_dates'] == "0" ) ? " and end_date > '".GlobalFunctions::get_date()."'" : "";
										$sql_sales = "select * from user_sales where unk = '".UNK."' ".$show_end_date." and deleted = '0' and status = '0' order by rand() limit ".$sales_limit;
										$res_sales = mysql_db_query(DB,$sql_sales);
										
										
										while( $data_sales = mysql_fetch_array($res_sales) )
										{
										$abpath_temp = SERVER_PATH."/sales/".$data_sales['img'];
										if( file_exists($abpath_temp) && !is_dir($abpath_temp) )
										{
											$im_size = GetImageSize ($abpath_temp); 
											$imageWidth = $im_size[0]; 
											$imageheight = $im_size[1]; 
											if( $imageWidth > 110 )
												$imageWidth = "110";
											$img_src = "<a href=\"index.php?m=s.sa&ud=".$data_sales['id']."\" class=\"maintext\" title=\"".htmlspecialchars(stripslashes($data_sales['name']))."\"><img src='sales/{$data_sales['img']}' border='0' width=\"".$imageWidth."\"></a>";
										}
										else
										{
											$img_src = "";
											$imageWidth = "76%";
										}
										
										echo "<tr>";
											echo "<td height=177 valign=top width=\"140\" style=\"border: 1px solid #".$data_colors['border_color'].";border-bottom: 0px solid #".$data_colors['border_color'].";border-top: 0px solid #".$data_colors['border_color'].";\" align=\"".$settings['re_align']."\">";
												echo "<table border=\"0\" height=100% width=\"140\" cellspacing=\"0\" cellpadding=\"0\" class=\"maintext\">";
													$temp_word_sales = ( $data_words['id'] == "" ) ? $word[LANG]['1_2_chapter_name_sales'] : stripslashes($data_words['word_sales']);
													
													echo "<tr>
														<td colspan=3 height=25 align=\"center\" style=\"border-bottom: 1px solid #".$data_colors['border_color']."; ".$style_kol_hpHeadline."\" bgcolor=\"#".$data_colors['bg_link']."\">
															<table border=\"0\" cellspacing=\"0\" cellpadding=\"0\" class=\"maintext\" >
																<tr><td height=3></td></tr>
																<tr>
																	<td style=\"color:#".$style_kol_Color."\"><b>".htmlspecialchars($temp_word_sales)."</b></td>
																</tr>
																<tr><td height=3></td></tr>
															</table>
														</td>
													</tr>";
													echo "<tr>
														<td width=4></td>
														<td align=\"".$settings['align']."\" valign=\"top\" height=\"20\"><a href=\"index.php?m=s.sa&ud=".$data_sales['id']."\" class=\"maintext\" title=\"".htmlspecialchars(stripslashes($data_sales['name']))."\"><b>".htmlspecialchars(stripslashes($data_sales['name']))."</b></a></td>
														<td width=4></td>
													</tr>
													<tr><td colspan=\"3\" height=\"1\"></td></tr>
													<tr>
														<td colspan=\"3\" valign=\"top\" align=\"center\" height=\"70\">{$img_src}</td>
													</tr>
													<tr><td colspan=\"3\" height=\"3\"></td></tr>
													<tr>
														<td width=4></td>
														<td align=\"".$settings['align']."\">".nl2br(stripslashes(htmlspecialchars($data_sales['summary'])))."</td>
														<td width=4></td>
													</tr>
													<tr><td colspan=\"3\" height=\"3\"></td></tr>";
													if( $data_sales['sale_price'] )
														$price = "<span style='font-size: 10px;'>".$word[LANG]['1_1_sales_price_sale']." <b>".stripslashes(htmlspecialchars($data_sales['sale_price']))."</b></span>";
													elseif( $data_sales['price'] )
														$price = $word[LANG]['1_1_sales_price']." <b>".stripslashes(htmlspecialchars($data_sales['price']))."</b>";
													else
														$price = "";
													
													echo "<tr><td colspan=\"3\" height=\"3\"></td></tr>
													<tr>
														<td width=4></td>
														<td valign=\"bottom\">
															<table border=\"0\" cellspacing=\"0\" cellpadding=\"0\" width=100% class=\"maintext\" style='font-size:11px;'>
																<tr>
																	<td width=2></td>
																	<td align=".$settings['align'].">".$price."</td>
																	<td align=".$settings['re_align']."><a href=\"index.php?m=s.sa&ud=".$data_sales['id']."\" class=\"maintext\" title=\"".htmlspecialchars(stripslashes($data_sales['name']))."\">".$word[LANG]['1_1_yad2_more_info']."</a></td>
																	<td width=2></td>
																</tr>
															</table>
														</td>
														<td width=4></td>
													</tr>
												</table>";
											echo "</td>";
										echo "</tR>";	
										
										}
									}
								break;
								
								// * * * * * * * * * *  Products * * * * * * * * * * * * *
								case "2" :
									
									$pro_limit = "1";
									
									$sql = "select * from user_products_cat where unk = '".UNK."' and deleted = '0' and status = '0' order by rand() limit 1";
									$res_cat = mysql_db_query(DB,$sql);
									$data_cat = mysql_fetch_array($res_cat);
									
									
									//$sql = "select up.id, up.img, up.name, up.summary, up.price from user_products as up , user_model_cat_belong as umcb, user_products_cat as upc WHERE up.deleted = 0 and up.unk = '".UNK."' and up.active = '0' and umcb.catId='".ifint($data_cat['id'])."' AND umcb.model='products' AND umcb.itemId=up.id AND upc.id = umcb.catId AND upc.delete=0 AND u order by rand() LIMIT ".$pro_limit;
									$sql = "select up.id, up.img, up.name, up.summary, up.price from user_products as up INNER JOIN user_model_cat_belong as umcb ON umcb.catId='".ifint($data_cat['id'])."' AND umcb.model='products' AND umcb.itemId=up.id WHERE up.deleted = 0 and up.unk = '".UNK."' and up.active = '0' order by rand() LIMIT ".$pro_limit;
									//$sql = "select up.id, up.img, up.name, up.summary, up.price from user_products as up, user_products_cat as upc where up.unk = '".UNK."' AND up.unk=upc.unk AND up.deleted = '0' and up.active = '0' and upc.deleted=0 and upc.status = 0 order by rand() LIMIT ".$pro_limit;
									$res = mysql_db_query(DB,$sql);
									
									while( $data = mysql_fetch_array($res) )
									{
										echo "<tR>";
											echo "<td height=250 valign=top width=\"138\" style=\"border: 1px solid #".$data_colors['border_color'].";\" align=\"".$settings['re_align']."\">";
											
											$abpath_temp = SERVER_PATH."/products/".$data['img'];
												if( file_exists($abpath_temp) && !is_dir($abpath_temp) )
												{
													$im_size = GetImageSize ($abpath_temp); 
													$imageWidth = $im_size[0]; 
													$imageheight = $im_size[1]; 
													if( $imageWidth > 110 )
														$imageWidth = "110";
													$img_src = "<a href=\"index.php?m=s.pr&ud=".$data['id']."\" class=\"maintext\" title=\"".htmlspecialchars(stripslashes($data['name']))."\"><img src='products/{$data['img']}' border='0' width=\"".$imageWidth."\"></a>";
												}
												else
												{
													$img_src = "";
													$imageWidth = "76%";
												}
											
											echo "<table border=\"0\" height=\"100%\" width=\"138\" cellspacing=\"0\" cellpadding=\"0\" class=\"maintext\">";
												$temp_word_products = ( $data_words['id'] == "" ) ? $word[LANG]['1_2_chapter_name_products'] : stripslashes($data_words['word_products']);
												
												echo "<tr>
													<td height=25 align=\"center\" style=\"border-bottom: 1px solid #".$data_colors['border_color'].";\" bgcolor=\"#".$data_colors['bg_link']."\">
														<table border=\"0\" cellspacing=\"0\" cellpadding=\"0\" class=\"maintext\">
															<tr><Td height=3></td></tr>
															<tr>
																<td style=\"color:#".$data_colors['color_link']."\"><b>".htmlspecialchars($temp_word_products)."</b></td>
															</tr>
															<tr><Td height=3></td></tr>
														</table>
													</td>
												</tr>";
												echo "<tr>
													<td align=\"".$settings['align']."\" valign=\"top\" height=\"20\"><a href=\"index.php?m=s.pr&ud=".$data['id']."\" class=\"maintext\" title=\"".htmlspecialchars(stripslashes($data['name']))."\"><b>".htmlspecialchars(stripslashes($data['name']))."</b></a></td>
												</tr>
												<tr><td colspan=\"3\" height=\"1\"></td></tr>
												<tr>
													<td colspan=\"3\" valign=\"top\" align=\"center\" height=\"70\">{$img_src}</td>
												</tr>
												<tr><td colspan=\"3\" height=\"3\"></td></tr>
												<tr>
													<td align=\"".$settings['align']."\" valign=\"top\">".nl2br(stripslashes(htmlspecialchars($data['summary'])))."</td>
												</tr>
												<tr><td colspan=\"3\" height=\"3\"></td></tr>";
												if( $data['price'] )
													$price = $word[LANG]['1_1_sales_price'].": <b>".$data['price']."</b>";
												else
													$price = "";
												echo "<tr><td colspan=\"3\" height=\"3\"></td></tr>
												<tr>
													<td valign=\"bottom\">
														<table border=\"0\" cellspacing=\"0\" cellpadding=\"0\" width=100% class=\"maintext\" style='font-size:11px;'>
															<tr>
																<td width=2></td>
																<td align=".$settings['align'].">".$price."</td>
																<td align=".$settings['re_align']."><a href=\"index.php?m=s.pr&ud=".$data['id']."\" class=\"maintext\" title=\"".htmlspecialchars(stripslashes($data['name']))."\">".$word[LANG]['1_1_yad2_more_info']."</a></td>
																<td width=2></td>
															</tr>
														</table>
													</td>
												</tr>
											</table>";
										echo "</td>";
									echo "</tR>";	
									}
								break;
								
								
								// * * * * * * * * * *  YAD 2 * * * * * * * * * * * * *
								case "3" :
								echo "";
									echo "<tR>";
										echo "<td height=250 valign=top width=\"138\" style=\"border: 1px solid #".$data_colors['border_color'].";\" align=\"".$settings['re_align']."\">";
											
											$sql = "select * from user_yad2 where unk = '".UNK."' and deleted = '0' and active = '0' order by rand() limit 1";
											$res = mysql_db_query(DB,$sql);
											$data = mysql_fetch_array($res);
											
											$abpath_temp = SERVER_PATH."/yad2/".$data['img'];
												if( file_exists($abpath_temp) && !is_dir($abpath_temp) )
												{
													$im_size = GetImageSize ($abpath_temp); 
													$imageWidth = $im_size[0]; 
													$imageheight = $im_size[1]; 
													if( $imageWidth > 110 )
														$imageWidth = "110";
													$img_src = "<a href=\"index.php?m=s.ya&ud=".$data['id']."\" class=\"maintext\" title=\"".htmlspecialchars(stripslashes($data['name']))."\"><img src='yad2/{$data['img']}' border='0' width=\"".$imageWidth."\"></a>";
												}
												else
												{
													$img_src = "";
													$imageWidth = "76%";
												}
											
											echo "<table border=\"0\" height=\"100%\" width=\"138\" cellspacing=\"0\" cellpadding=\"0\" class=\"maintext\">";
												$temp_word_yad2 = ( $data_words['id'] == "" ) ? $word[LANG]['1_2_chapter_name_yad2'] : stripslashes($data_words['word_yad2']);
												
												echo "<tr>
													<td height=25 align=\"center\" style=\"border-bottom: 1px solid #".$data_colors['border_color'].";\" bgcolor=\"#".$data_colors['bg_link']."\">
														<table border=\"0\" cellspacing=\"0\" cellpadding=\"0\" class=\"maintext\">
															<tr><Td height=3></td></tr>
															<tr>
																<td style=\"color:#".$data_colors['color_link']."\"><b>".htmlspecialchars($temp_word_yad2)."</b></td>
															</tr>
															<tr><Td height=3></td></tr>
														</table>
													</td>
												</tr>";
												echo "<tr>
													<td align=\"".$settings['align']."\" valign=\"top\" height=\"20\"><a href=\"index.php?m=s.ya&ud=".$data['id']."\" class=\"maintext\" title=\"".htmlspecialchars(stripslashes($data['name']))."\"><b>".htmlspecialchars(stripslashes($data['name']))."</b></a></td>
												</tr>
												<tr><td colspan=\"3\" height=\"1\"></td></tr>
												<tr>
													<td colspan=\"3\" valign=\"top\" align=\"center\" height=\"70\">".$img_src."</td>
												</tr>
												<tr><td colspan=\"3\" height=\"3\"></td></tr>
												<tr>
													<td align=\"".$settings['align']."\" valign=\"top\">".nl2br(stripslashes(htmlspecialchars($data['summary'])))."</td>
												</tr>
												<tr><td colspan=\"3\" height=\"3\"></td></tr>";
												if( $data['price'] )
													$price = $word[LANG]['1_1_sales_price'].": <b>".$data['price']."</b>";
												else
													$price = "";
												echo "<tr><td colspan=\"3\" height=\"3\"></td></tr>
												<tr>
													<td valign=\"bottom\">
														<table border=\"0\" cellspacing=\"0\" cellpadding=\"0\" width=100% class=\"maintext\" style='font-size:11px;'>
															<tr>
																<td width=2></td>
																<td align=".$settings['align'].">".$price."</td>
																<td align=".$settings['re_align']."><a href=\"index.php?m=s.ya&ud=".$data['id']."\" class=\"maintext\" title=\"".htmlspecialchars(stripslashes($data['name']))."\">".$word[LANG]['1_1_yad2_more_info']."</a></td>
																<td width=2></td>
															</tr>
														</table>
													</td>
												</tr>
											</table>";
										echo "</td>";
									echo "</tR>";	
								break;
							}
						}
						
						
						
						if( UNK == "263512086634836547" )
						{
							echo "<tR>";
								echo "<td  valign=top width=\"140\" style=\"border: 1px solid #".$data_colors['border_color'].";\" align=\"".$settings['re_align']."\">";
									
									$sql = "SELECT business_name, id, description , img2 FROM user_guide_business WHERE img2 != '' AND unk = '".UNK."' ORDER BY RAND() LIMIT 1";
									$res = mysql_db_query(DB,$sql);
									$data = mysql_fetch_array($res);
									
									$abpath_temp = SERVER_PATH."/new_images/".$data['id']."/".$data['img2'];
										if( file_exists($abpath_temp) && !is_dir($abpath_temp) )
										{
											$im_size = GetImageSize ($abpath_temp); 
											$imageWidth = $im_size[0]; 
											$imageheight = $im_size[1]; 
											if( $imageWidth > 132 )
												$imageWidth = "132";
											$img_src = "<img src='new_images/".$data['id']."/{$data['img2']}' border='0' width=\"".$imageWidth."\"></a>";
										}
										else
										{
											$img_src = "";
											$imageWidth = "76%";
										}
									
									echo "<table border=\"0\" width=\"140\" cellspacing=\"0\" cellpadding=\"0\" class=\"maintext\">";
										
										echo "<tr>
											<td colspan=3 height=25 align=\"center\" style=\"border-bottom: 1px solid #".$data_colors['border_color']."; ".$style_kol_hpHeadline."\" bgcolor=\"#".$data_colors['bg_link']."\">
												<table border=\"0\" cellspacing=\"0\" cellpadding=\"0\" class=\"maintext\">
													<tr><Td height=3></td></tr>
													<tr>
														<td style=\"color:#".$style_kol_Color."\"><b>עסקים שהצטרפו</b></td>
													</tr>
													<tr><Td height=3></td></tr>
												</table>
											</td>
										</tr>";
										echo "
										<tr><td colspan=\"3\" height=\"3\"></td></tr>
										<tr>
											<td width=4></td>
											<td align=\"".$settings['align']."\" valign=\"top\"><b>".stripslashes(htmlspecialchars($data['business_name']))."</b></td>
											<td width=4></td>
										</tr>
										<tr><td colspan=\"3\" height=\"3\"></td></tr>
										<tr>
											<td width=4></td>
											<td align=\"center\" valign=\"top\">".$img_src."</td>
											<td width=4></td>
										</tr>
										<tr><td colspan=\"3\" height=\"10\"></td></tr>
										<tr>
											<td width=4></td>
											<td align=\"".$settings['align']."\" valign=\"top\">";
											if( strlen($data['description']) > 0 )
												echo substr(stripslashes(htmlspecialchars($data['description'])) , 0 , 100 )."...";
											else
												echo $data['description'];
											echo "</td>
											<td width=4></td>
										</tr>
										";
										
										echo "<tr><td colspan=\"3\" height=\"3\"></td></tr>
										<tr>
											<td width=4></td>
											<td valign=\"bottom\">
												<table border=\"0\" cellspacing=\"0\" cellpadding=\"0\" width=100% class=\"maintext\" style='font-size:11px;'>
													<tr>
														<td align=".$settings['re_align']."><a href=\"index.php?m=KgBm_p&pid=".$data['id']."\" class=\"maintext\" title=\"\">להמשך...</a></td>
														<td width=2></td>
													</tr>
												</table>
											</td>
											<td width=4></td>
										</tr>
									</table>";
								echo "</td>";
							echo "</tR>";	
							
							
							
							
							echo "<tR>";
								echo "<td  valign=top width=\"140\" style=\"border: 1px solid #".$data_colors['border_color'].";\" align=\"".$settings['re_align']."\">";
									
									$sql = "SELECT guide_name, id, description , url_page , guide_img FROM user_guide WHERE unk = '".UNK."' AND url_page != '' ORDER BY RAND() LIMIT 1";
									$res = mysql_db_query(DB,$sql);
									$data = mysql_fetch_array($res);
									
									$abpath_temp = SERVER_PATH."/new_images/".$data['guide_img'];
										if( file_exists($abpath_temp) && !is_dir($abpath_temp) )
										{
											$im_size = GetImageSize ($abpath_temp); 
											$imageWidth = $im_size[0]; 
											$imageheight = $im_size[1]; 
											if( $imageWidth > 132 )
												$imageWidth = "132";
											$img_src = "<img src='new_images/{$data['guide_img']}' border='0' width=\"".$imageWidth."\">";
										}
										else
										{
											$img_src = "";
											$imageWidth = "76%";
										}
									
									echo "<table border=\"0\" width=\"140\" cellspacing=\"0\" cellpadding=\"0\" class=\"maintext\">";
										
										echo "<tr>
											<td colspan=3 height=25 align=\"center\" style=\"border-bottom: 1px solid #".$data_colors['border_color']."; ".$style_kol_hpHeadline."\" bgcolor=\"#".$data_colors['bg_link']."\">
												<table border=\"0\" cellspacing=\"0\" cellpadding=\"0\" class=\"maintext\">
													<tr><Td height=3></td></tr>
													<tr>
														<td style=\"color:#".$style_kol_Color."\"><b>מדריכים</b></td>
													</tr>
													<tr><Td height=3></td></tr>
												</table>
											</td>
										</tr>";
										echo "
										<tr><td colspan=\"3\" height=\"3\"></td></tr>
										<tr>
											<td width=4></td>
											<td align=\"".$settings['align']."\" valign=\"top\"><b>".stripslashes(htmlspecialchars($data['guide_name']))."</b></td>
											<td width=4></td>
										</tr>
										
										<tr><td colspan=\"3\" height=\"10\"></td></tr>
										<tr>
											<td width=4></td>
											<td align=\"center\" valign=\"top\">".$img_src."</td>
											<td width=4></td>
										</tr>
										
										<tr><td colspan=\"3\" height=\"10\"></td></tr>
										<tr>
											<td width=4></td>
											<td align=\"".$settings['align']."\" valign=\"top\">";
											if( strlen($data['description']) > 0 )
												echo substr(stripslashes(htmlspecialchars($data['description'])) , 0 , 150 )."...";
											else
												echo $data['description'];
											echo "</td>
											<td width=4></td>
										</tr>
										";
										
										if( eregi( "http://" , $data['url_page'] ) )
											$url_page = $data['url_page'];
										else
											$url_page = "http://".$data['url_page'];
										
										echo "<tr><td colspan=\"3\" height=\"3\"></td></tr>
										<tr>
											<td width=4></td>
											<td valign=\"bottom\">
												<table border=\"0\" cellspacing=\"0\" cellpadding=\"0\" width=100% class=\"maintext\" style='font-size:11px;'>
													<tr>
														<td align=".$settings['re_align']."><a href=\"".$url_page."\" class=\"maintext\" title=\"".stripslashes(htmlspecialchars($data['guide_name']))."\">להמשך...</a></td>
														<td width=2></td>
													</tr>
												</table>
											</td>
											<td width=4></td>
										</tr>
									</table>";
								echo "</td>";
							echo "</tR>";	
						}
						
						
						
					echo "</table>
				</td>";
			echo "</tR>";
		}
		elseif( $data_have_hp_banners['hp_type'] == "1" )
		{
			echo "<tr>";
				echo "<td>";
						$content = string_rplace_func($data_have_hp_banners['hp_text']);
						echo stripslashes($content);
				echo "</td>";
			echo "</tr>";
		}
	echo "</table>";
}


function gb()
{
	global $word,$data_extra_settings;
	
	$sql = "select * from content_pages where unk = '".UNK."' and type = 'gb' and deleted = '0'";
	$res = mysql_db_query(DB,$sql);
	$data = mysql_fetch_array($res);
	
	$sec_check = generatePassword(8);
	
	$img_antiSpam = "<table border=\"0\" cellspacing=\"0\" cellpadding=\"0\" class=\"maintext\">
		<tr>
			<td>".$word[LANG]['1_1_gb_security_code']."</td>
			<td width=33></td>
			<td><input type='text' name='contact_sec' class='input_style' style='width: 129px;' dir=ltr></td>
			<td width=20></td>
			<td><img src='http://www.ilbiz.co.il/ClientSite/text2jpg.php?word=".$sec_check."' alt='' /></td>
		</tr>
	</table>";
	
	
	$form_arr = array(
		array("hidden","m","insert_gb_response"),
		array("hidden","data_arr[unk]",UNK),
		array("hidden","record_id",$_REQUEST['row_id']),
		array("hidden","sec_check",sha1($sec_check), ""),
		
		array("text","data_arr[name]","",$word[LANG]['1_1_gb_form_name'], "class='input_style'","","1"),
		array("text","data_arr[email]","",$word[LANG]['1_1_gb_form_email'], "class='input_style'","","1"),
		array("text","data_arr[headline]","",$word[LANG]['1_1_gb_form_title'], "class='input_style'","","1"),
		
		array("textarea","data_arr[content]","",$word[LANG]['1_1_gb_form_text'], "class='input_style' style='width: 300px; height: 100px;'"),
		
		array("blank", $img_antiSpam ),
		array("hidden","data_arr[date_in]",GlobalFunctions::get_timestemp(),$word[LANG]['1_1_gb_form_date'], ""),
		

		array("submit","submit",$word[LANG]['1_1_gb_form_send_form'], "class='submit_style'")
	);
	
	$more = "class='maintext'";
	
	$get_form = FormCreator::create_form($form_arr,"index.php", $more);
	$content = string_rplace_func($data['content']);
	
	$limitcount = ( $_GET['PL'] == "" ) ? $_POST['PL'] : $_GET['PL'];
	$limitcount = ( $limitcount == "" ) ? "0" : ifint($limitcount);
	
	$qry = "select * from user_gb_response where deleted=0 and status=1 and unk='".UNK."' order by id DESC LIMIT ".$limitcount.",10";
	$res_response = mysql_db_query(DB, $qry);
	$num_rows = mysql_num_rows($res_response);
	
	$qry2 = "select COUNT(id) AS num_rows from user_gb_response where deleted=0 and status=1 and unk='".UNK."'";
	$res2 = mysql_db_query(DB, $qry2);
	$data2 = mysql_fetch_array($res2);
	
	
	
	echo "<table border=\"0\" cellspacing=\"0\" cellpadding=\"0\" class=\"maintext\">";
		echo "<tr>";
			echo "<td>".stripslashes($content)."</td>";
		echo "</tr>";
		
		echo "<tr><td height=\"10\"></td></tr>";
		echo "<tr><td><hr width='100%' class='maintext' size='3'></td></tr>";
		echo "<tr><td height=\"10\"></td></tr>";
		
		if( $data_extra_settings['haveFacebookComments'] == "1" )
		{
			echo "<tr>";
				echo "<td>";
					echo FacebookComments("gb");
				echo "</td>";
			echo "</tr>";
		}
		
		echo "<tr><td height=\"10\"></td></tr>";
		echo "<tr><td><hr width='100%' class='maintext' size='3'></td></tr>";
		echo "<tr><td height=\"10\"></td></tr>";
		
		$counter = 1;
		
		while( $data_response = mysql_fetch_array($res_response) )
		{
			echo "<tr>";
				echo "<td>";
					echo "<table border=\"0\" cellspacing=\"0\" cellpadding=\"0\" class=\"maintext\">";
						echo "<tr>";
							echo "<td><b>".htmlspecialchars(stripslashes($data_response['headline']))."</b></td>";
						echo "</tr>";
						echo "<tr><td height=\"7\"></td></tr>";
						echo "<tr>";
							echo "<td>".nl2br(htmlspecialchars(stripslashes($data_response['content'])))."</td>";
						echo "</tr>";
						echo "<tr><td height=\"10\"></td></tr>";
						echo "<tr>";
							echo "<td>";
								echo "<table border=\"0\" cellspacing=\"0\" cellpadding=\"0\" class=\"maintext\">";
									echo "<tr>";
										$email_start = ( $data_response['email'] != "" ) ? "<a href='mailto:".htmlspecialchars(stripslashes($data_response['email']))."' class='maintext'><u>": "";
										$email_end = ( $data_response['email'] != "" ) ? "</u></a>": "";
										echo "<td>".$email_start.htmlspecialchars(stripslashes($data_response['name'])).$email_end."</td>";
										echo "<td width='10'></td>";
										echo "<td>".GlobalFunctions::show_dateTime_field($data_response['date_in'])."</td>";
									echo "</tr>";
								echo "</table>";
							echo "</td>";
						echo "</tr>";
					echo "</table>";
				echo "</td>";
			echo "</tr>";
			
			if( $num_rows != $counter )
			{
				echo "<tr><td height=\"10\"></td></tr>";
				echo "<tr><td><hr width='100%' class='maintext' size='1'></td></tr>";
				echo "<tr><td height=\"10\"></td></tr>";
			}
			
			$counter++;
		}
		
		echo "<tr>";
			echo "<td align=center>";
				$params['limitInPage'] = "10";
				$params['numRows'] = $data2['num_rows'];
				$params['limitcount'] = $limitcount;
				$params['m'] = $_GET['m'];
				
				getLimitPagention( $params );
				
			echo "<td>";
		echo "</tr>";
		
		
		echo "<tr><td height=\"10\"></td></tr>";
		echo "<tr><td><hr width='100%' class='maintext' size='3'></td></tr>";
		echo "<tr><td height=\"10\"></td></tr>";
		
		
		echo "<tr>";
			echo "<td><b>".$word[LANG]['1_1_gb_form_send_response']."</b></td>";
		echo "</tr>";
		echo "<tr><td height=\"10\"></td></tr>";
		echo "<tr>";
			echo "<td>".$get_form."</td>";
		echo "</tr>";
	echo "</table>";
}


function insert_gb_response()	{

global $data_name,$word,$settings;
	
	$flagCheck = false;
	if( $_POST['sec_check'] == sha1($_POST['contact_sec']) )
	{
		$flagCheck = true;
		
		if( $flagCheck == true )
		{
			$image_settings = array(
				after_success_goto=>"index.php?m=get_thanks&type=get_thx_gb",
				table_name=>"user_gb_response",
			);
			$data_arr = ($_POST['data_arr'])? $_POST['data_arr'] : $_GET['data_arr'];
		
			$msg2 = "
			<table width=\"600\" border=\"0\" cellspacing=\"1\" cellpadding=\"1\" dir=\"".$settings['dir']."\">
			  <tr>
			    <td style='font-family:arial; font-size: 12px; color: #000000;'>".$word[LANG]['1_1_gb_send_mail_massg']."</td>
			  </tr>
			  <tr>
			  	<td style='font-family:arial; font-size: 12px; color: #000000;'>".$_SERVER['HTTP_HOST']."</td>
			  </tr>
			</table>";
		
		
		    $fullmsg='<html dir="'.$settings['dir'].'">
			<head dir="'.$settings['dir'].'">
			<meta http-equiv="Content-Type" content="text/html; charset=windows-1255">
			</head>
			<body>'.$msg2.'</body>
			</html>';
		
		    $headers  = "MIME-Version: 1.0\r\n";
		    $headers .= "Content-type: text/html; charset=windows-1255-1\r\n";
		    $headers .= "From: ".$word[LANG]['1_1_gb_send_mail_mail_sender']."\r\n";
		    
			mail($data_name['email'],$word[LANG]['1_1_gb_send_mail_subject'], $fullmsg, $headers );
			
			insert_to_db($data_arr, $image_settings);
		}
	}
	else
	{
		echo "<script type='text/javascript'>alert('".$word[LANG]['1_1_gb_security_code_incorrect']."');</script>";
		echo "<script type='text/javascript'>window.location.href='javascript:history.back(-1);'</script>";
			exit;
	}
}

function string_rplace_func($content)
{
	$content = str_replace( "<table" , "<table class=maintext" , $content );
	$content = str_replace( "<tbody" , "<tbody class=maintext" , $content );
	
	$content = str_replace( "http://www.ilbiz.co.il/ClientSite/upload_pics/" , "/ClientSite/upload_pics/" , $content );
	$content = str_replace( "http://ilbiz.co.il/ClientSite/upload_pics/" , "/ClientSite/upload_pics/" , $content );
	$content = str_replace( "/ClientSite/upload_pics/" , "http://ilbiz.co.il/ClientSite/upload_pics/" , $content );
	
	$content = str_replace( "http://ilbiz.co.il/ClientSite/administration/fckeditor/editor/images" , "/ClientSite/administration/fckeditor/editor/images" , $content );
	$content = str_replace( "http://www.ilbiz.co.il/ClientSite/administration/fckeditor/editor/images" , "/ClientSite/administration/fckeditor/editor/images" , $content );
	$content = str_replace( "/ClientSite/administration/fckeditor/editor/images" , "http://ilbiz.co.il/ClientSite/administration/fckeditor/editor/images" , $content );
	
	
				$start_ind=0;
				
				
					$temp_embed_count = explode( "<embed" , $content );
					
					for( $i=0 ; $i<=sizeof($temp_embed_count) ; $i++ )
					{
						$start_embed = stripos($content,"<embed",$start_ind);
						$end_embed=strpos($content,">",$start_embed);
						$one_embed=substr($content,$start_embed,$end_embed - $start_embed);
						
						$typeTagVal=getTagVal(stripslashes($one_embed),"type");
						
						if ( $typeTagVal == "application/x-shockwave-flash" ) 
						{
							$srcTagVal=getTagVal(stripslashes($one_embed),"src");
							$widthTagVal=getTagVal(stripslashes($one_embed),"width");
							$heightTagVal=getTagVal(stripslashes($one_embed),"height");
							
							if( eregi( "http://".$_SERVER[HTTP_HOST] , $srcTagVal ) )
							{
								$new_src = str_replace( "http://".$_SERVER[HTTP_HOST] , "" ,$srcTagVal  );
								$srcTagVal= $new_src;
							}
							elseif( eregi( "www." , $_SERVER[HTTP_HOST] ) )
							{
								$newHost = str_replace( "www." , "" ,$_SERVER[HTTP_HOST]  );
								$new_src = str_replace( "http://".$newHost , "" ,$srcTagVal  );
								$srcTagVal= $new_src;
							}
							
							
							$myRand = rand( 0 , 100 );
							$new_code = "
							<div id=ls".$myRand."></div>
							<script type=\"text/javascript\">
								swfPlayer(\"".$srcTagVal."\",\"n".$myRand."\",\"".$widthTagVal."\",\"".$heightTagVal."\",\"#\",\"ls".$myRand."\");
							</script>
							";
							
							$content = str_replace( $one_embed."></embed>" , $new_code , $content );
						}
					}
				

	return $content;
}


function getTagVal($htmlCode,$tagName)
 {
 	$searchTag=" " . $tagName . "=";
 	
	if ( stripos($htmlCode,$searchTag) === false ) return "";
	
  $start_src=stripos($htmlCode,$searchTag) + strlen($searchTag) + 1;
  
  if ( strpos($htmlCode,"\"",$start_src) === false )  return "";					 
  
	$end_src=strpos($htmlCode,"\"",$start_src);
	
	return substr($htmlCode,$start_src,$end_src - $start_src);
 }

function ecom_form_step_1()
{
	global $word;
	
	$sql = "select product_id from user_ecom_items where unk = '".UNK."' and status=0 AND client_unickSes = '".$_SESSION['ecom']['unickSES']."' GROUP BY product_id";
	$res = mysql_db_query(DB,$sql);
	$num_rows = mysql_num_rows($res);
	  
	$sql = "select textarea_content,delivery_pay from user_ecom_settings where unk = '".UNK."' order by id desc limit 1";
	$res_ecom_settigns = mysql_db_query(DB,$sql);
	$D_ecom_settigns = mysql_fetch_array($res_ecom_settigns);
	
	$total_price_to_pay = 0;
	?>
	<div class='ecom-pay-page' style="padding:4px; border:1px solid #eee;">
		
		<h4 class="page_headline">קופה</h4>
		
		

			<div style='overflow-x:auto;'>
				<table class="maintext" width="100%">
					<tr>
						<td><?php echo $word[LANG]['1_1_ecom_form_step_1_pro_name']; ?></td>
						<td width=10></td>
						<td><?php echo $word[LANG]['1_1_ecom_form_step_1_catalog_id']; ?></td>
						<td width=10></td>
						<td><?php echo $word[LANG]['1_3_ecom_table_qry']; ?></td>
						<td width=10></td>
						<td><?php echo $word[LANG]['1_1_ecom_form_step_1_price_one']; ?></td>
					</tr>
					
					<?php while( $data = mysql_fetch_array($res) ): ?>
						<?php
							$sql = "select name,price,price_special,makat from user_products where id = '".$data['product_id']."'";
							$res2 = mysql_db_query(DB,$sql);
							$data2 = mysql_fetch_array($res2);
							
							$sql = "select id from user_ecom_items where unk = '".UNK."' and status=0 AND client_unickSes = '".$_SESSION['ecom']['unickSES']."' and product_id = '".$data['product_id']."'";
							$res3 = mysql_db_query(DB,$sql);
							$qry_nm = mysql_num_rows($res3);
							$total_price_to_pay = $total_price_to_pay + ( $data2['price'] * $qry_nm );
						?>
						<tr><td colspan=7 height=1></td></td>
						<tr><td colspan=7><hr width=100% size=1 class=\"maintext\" /></td></td>
						<tr><td colspan=7 height=1></td></td>
						<tr>
							<td><?php echo kill_and_strip($data2['name']); ?></td>
							<td width=10></td>
							<td><?php echo kill_and_strip($data2['makat']); ?></td>
							<td width=10></td>
							<td><?php echo $qry_nm; ?></td>
							<td width=10></td>
							<td><?php echo kill_and_strip($data2['price']); ?> <?php echo COIN; ?></td>
						</tr>
					<?php endwhile; ?>
					<tr><td height='10' colspan=3></td></tr>
					<tr>
						<td colspan='7' align=left><b><?php echo $word['he']['1_3_ecom_table_total']; ?></b> <?php echo $total_price_to_pay; ?> <?php echo COIN; ?></td>
					</tr>
				</table>
			</div>
			
		
			<hr/>
	<?php if( $num_rows > 0 ): ?>
	
			<div class='ecom-form'>
				<table border="0" cellspacing="0" cellpadding="0" class="maintext" style="margin:auto;">
					<form action='?' name='step2_ecom_form' method='POST' onsubmit=\"return check_mandatory_fields();\">
					<input type='hidden' name='m' value='ecom_new_buy_DB'>
					
						<tr>
							<?php if( UNK != "567556530384297372" ): ?>
								<td colspan='3'><?php echo nl2br(kill_and_strip($D_ecom_settigns['textarea_content'])); ?></td>
							<?php else: ?>
							
								<td colspan='3'>
								<?php echo nl2br(kill_and_strip($D_ecom_settigns['textarea_content'])); ?><br>
								* משלוח מהיר ייחויב בנפרד<br><br>
								<b>סליקת כרטיסי האשראי נעשית על שרת מאובטח מאושר על ידי חברת ישראכרט, חשבונית אוטומטית תשלח לכתובת המייל שלכם<br>
								חברת בדים נט מתחייבת לא להעביר את שמכם כתובתכם או כל פרט אחר לשום גורם</b><br><br>
								לנוחיותכם ניתן לשלם טלפונית במספר 1-700-72-3254
								</td>
							<?php endif; ?>
						</tr>
						<tr><td height='10' colspan=3></td></tr>
						<tr>
							<td><font color=red>*</font> שם מלא</td>
							<td width=10></td>
							<td><input type='text' name='dataArr[full_name]' id='dataArr[full_name]' class='input_style'></td>
						</tr>
						<tr><td height='7' colspan=3></td></tr>

						<tr>
							<td><font color=red>*</font> אימייל</td>
							<td width=10></td>
							<td><input type='text' name='dataArr[email]' id='dataArr[email]' class='input_style'></td>
						</tr>
						<tr><td height='7' colspan=3></td></tr>
						<tr>
							<td><font color=red>*</font> טלפון</td>
							<td width=10></td>
							<td><input type='text' name='dataArr[phone]' id='dataArr[phone]' class='input_style'></td>
						</tr>
						<tr><td height='7' colspan=3></td></tr>
						<tr>
							<td><font color=red>*</font> ישוב</td>
							<td width=10></td>
							<td><input type='text' name='dataArr[city]' id='dataArr[city]' class='input_style'></td>
						</tr>
						<tr><td height='7' colspan=3></td></tr>
						<tr>
							<td><font color=red>*</font> רחוב</td>
							<td width=10></td>
							<td><input type='text' name='dataArr[address]' id='dataArr[address]' class='input_style'></td>
						</tr>
						<tr><td height='7' colspan=3></td></tr>
						<tr>
							<td><font color=red>*</font> מספר בית</td>
							<td width=10></td>
							<td>
								<table class="maintext">
									<tr>
										<td><input type='text' name='dataArr[buildingNum]' id='dataArr[buildingNum]' class='input_style' style='width: 50px;'></td>
										<td width=5></td>
										<td>מספר דירה</td>
										<td width=5></td>
										<td><input type='text' name='dataArr[home_num]' id='dataArr[home_num]' class='input_style' style='width: 50px;'></td>
									</tr>
								</table>
							</td>
						</tr>
						<tr><td height='7' colspan=3></td></tr>
						<tr>
							<td>מיקוד</td>
							<td width=10></td>
							<td><input type='text' name='dataArr[zip_code]' id='dataArr[zip_code]' class='input_style'></td>
						</tr>
						<tr><td height='7' colspan=3></td></tr>
						<tr>
							<td>הערות</td>
							<td width=10></td>
							<td><textarea name='dataArr[note]' id='dataArr[note]' cols='' rows='' class='input_style' style='height: 70px;'></textarea></td>
						</tr>
						<tr><td height='7' colspan=3></td></tr>
						<?php if( UNK != "995628678735762902" ): ?>
						
						<tr>
							<td><?php echo $word[LANG]['1_1_ecom_form_step_2_delivery']; ?></td>
							<td width=10></td>
							<td>
							<?php $delivery_pay = ( $D_ecom_settigns['delivery_pay'] != "" ) ? $D_ecom_settigns['delivery_pay'] : "0"; ?>
							
							<?php if( UNK == "514738259673354081" OR UNK == "567556530384297372" ): ?>
							
								<select name='dataArr[delivery_pay]' id='dataArr[delivery_pay]' class='input_style' style='width:250px; height: 18px;'>
									<option value='<?php echo kill_and_strip($D_ecom_settigns['delivery_pay']); ?>' selected><?php echo $word[LANG]['1_1_ecom_form_step_2_delivery_pay_1']; ?>: <?php echo kill_and_strip($delivery_pay); ?> <?php echo COIN; ?></option>
								</select>
							<?php else: ?>
								<select name='dataArr[delivery_pay]' id='dataArr[delivery_pay]' class='input_style' style='width:250px; height: 18px;'>
									<option value=''><?php echo $word[LANG]['1_1_ecom_form_step_2_delivery_choose']; ?></option>
									<option value='0' selected><?php echo $word[LANG]['1_1_ecom_form_step_2_delivery_pay_0']; ?></option>
									<option value='<?php echo kill_and_strip($D_ecom_settigns['delivery_pay']); ?>'><?php echo $word[LANG]['1_1_ecom_form_step_2_delivery_pay_1']; ?>: <?php echo kill_and_strip($delivery_pay); ?> <?php echo COIN; ?></option>
								</select>
							<?php endif; ?>
							
							</td>
						</tr>
						<tr><td height='5' colspan=3></td></tr>
						<tr><td colspan=3><hr width=100% size=1 class=\"maintext\" /></td></td>
						
						<?php else: ?>
						
							<input type='hidden' name='dataArr[delivery_pay]' id='dataArr[delivery_pay]' value='0'>
						<?php endif; ?>
						
						<tr><td height='5' colspan=3></td></tr>
						
						
						<tr>
							<td valign=top style='font-size: 11px;'><font color=red>*</font> שדה חובה</td>
							<td width=10></td>
							<td align=left></td>
						</tr>
						
						<tr>
							<td valign=top></td>
							<td width=10></td>
							<td align=left><input type='submit' value='שליחה' class='submit_style' style='display:block; padding:5px; width:200px; '></td>
						</tr>
						<tr><td height='5' colspan=3></td></tr>
						<tr><td height='5' colspan=3></td></tr>
						<tr><td height='5' colspan=3></td></tr>
					</form>
				</table>
			</div>
	
		<?php else: ?>
			<div class='no-products-messege'><b>לא ניתן לשלוח הזמנה ללא מוצרים.</b></div>
		<?php endif; ?>
	
		<script>
			function check_mandatory_fields()
			{
				<?php $mandatory_fields = array( "dataArr[full_name]","dataArr[email]","dataArr[phone]","dataArr[city]","dataArr[address]","dataArr[buildingNum]" ); ?>
				<?php for($z=0 ; $z<sizeof($mandatory_fields) ; $z++): ?>
				
					<?php $val = $mandatory_fields[$z]; ?>
					
					
					
					temp_val = document.getElementById("<?php echo $val; ?>");
					if(temp_val.value == "")	
					{
						alert("יש להזין תוכן לשדות החובה");
						temp_val.focus();
						return false;
					}
					
					
				<?php endfor; ?>
					
			}
		</script>	

	</div>
<?php
exit();
}


function ecom_form_step_2()
{
	global $word;
	
	$sql = "select product_id from user_ecom_items where unk = '".UNK."' and status=0 AND client_unickSes = '".$_SESSION['ecom']['unickSES']."' GROUP BY product_id";
	$res = mysql_db_query(DB,$sql);
	$num_rows = mysql_num_rows($res);
	  
	$sql = "select textarea_content,delivery_pay from user_ecom_settings where unk = '".UNK."' order by id desc limit 1";
	$res_ecom_settigns = mysql_db_query(DB,$sql);
	$D_ecom_settigns = mysql_fetch_array($res_ecom_settigns);
	
	$total_price_to_pay = 0;
	echo "<table border=\"0\" cellspacing=\"0\" cellpadding=\"0\" class=\"maintext\">";
		
		echo "<tr>";
			echo "<td><h4 class=\"page_headline\">".$word[LANG]['1_1_ecom_form_step_2_headline']."</h4></td>";
		echo "</tr>";
		
		/// E-COM cart details
		echo "<tr>";
			echo "<td>";
				echo "<table border=\"0\" cellspacing=\"0\" cellpadding=\"0\" class=\"maintext\">";
					echo "<tr>";
						echo "<td><b>".$word[LANG]['1_1_ecom_form_step_1_pro_name']."</b></td>";
						echo "<td width=10></td>";
						echo "<td><b>".$word[LANG]['1_1_ecom_form_step_1_catalog_id']."</b></td>";
						echo "<td width=10></td>";
						echo "<td><b>".$word[LANG]['1_3_ecom_table_qry']."</b></td>";
						echo "<td width=10></td>";
						echo "<td><b>".$word[LANG]['1_1_ecom_form_step_1_price_one']."</b></td>";
					echo "</tr>";
					
					while( $data = mysql_fetch_array($res) )
					{
						$sql = "select name,price,makat from user_products where id = '".$data['product_id']."'";
						$res2 = mysql_db_query(DB,$sql);
						$data2 = mysql_fetch_array($res2);
						
						$sql = "select id from user_ecom_items where unk = '".UNK."' and status=0 AND client_unickSes = '".$_SESSION['ecom']['unickSES']."' and product_id = '".$data['product_id']."'";
						$res3 = mysql_db_query(DB,$sql);
						$qry_nm = mysql_num_rows($res3);
						
						echo "<tr><td colspan=7 height=1></td></td>";
						echo "<tr><td colspan=7><hr width=100% size=1 class=\"maintext\" /></td></td>";
						echo "<tr><td colspan=7 height=1></td></td>";
						echo "<tr>";
							echo "<td>".kill_and_strip($data2['name'])."</td>";
							echo "<td width=10></td>";
							echo "<td>".kill_and_strip($data2['makat'])."</td>";
							echo "<td width=10></td>";
							echo "<td>".$qry_nm."</td>";
							echo "<td width=10></td>";
							echo "<td align=left>".kill_and_strip($data2['price'])." ".COIN."</td>";
						echo "</tr>";
						$total_price_to_pay = $total_price_to_pay + ( $data2['price'] * $qry_nm );
					}
					echo "<tr><td height='10' colspan=3></td></tr>";
					echo "<tr>";
						echo "<td colspan='7' align=left><b>".$word['he']['1_3_ecom_table_total']."</b> ".$total_price_to_pay." ".COIN."</td>";
					echo "</tr>";
				echo "</table>";
			echo "</td>";
		echo "</tr>";
		
		echo "<tr><td height='10'></td></tr>";
		
		/// E-COM cart special details
		
		echo "<tr>";
			echo "<td>";
				echo "<table border=\"0\" cellspacing=\"0\" cellpadding=\"0\" class=\"maintext\">";
					echo "<form action='?' name='step2_ecom_form' method='POST'>";
					echo "<input type='hidden' name='m' value='add_order_to_DB'>";
					echo "<input type='hidden' name='client_id' value='".$_POST['client_id']."'>";
					echo "<input type='hidden' name='netEcomSyncId' value='".$_POST['netEcomSyncId']."'>";
					echo "<input type='hidden' name='EcomSes_net' value='".$_POST['EcomSes_net']."'>";
					
					if( UNK != "995628678735762902" )
					{
					echo "<tr>";
						echo "<td>".$word[LANG]['1_1_ecom_form_step_2_delivery']."</td>";
						echo "<td width=10></td>";
						echo "<td>";
						$delivery_pay = ( $D_ecom_settigns['delivery_pay'] != "" ) ? $D_ecom_settigns['delivery_pay'] : "0";
						
						if( UNK == "514738259673354081" OR UNK == "567556530384297372" )
						{
							echo "<select name='delivery_pay' class='input_style' style='width:250px; height: 18px;'>
								<option value='".kill_and_strip($D_ecom_settigns['delivery_pay'])."' selected>".$word[LANG]['1_1_ecom_form_step_2_delivery_pay_1'].": ".kill_and_strip($delivery_pay)." ".COIN."</option>
							</select>";
						}
						else
						{
							echo "<select name='delivery_pay' class='input_style' style='width:250px; height: 18px;'>
								<option value=''>".$word[LANG]['1_1_ecom_form_step_2_delivery_choose']."</option>
								<option value='0' selected>".$word[LANG]['1_1_ecom_form_step_2_delivery_pay_0']."</option>
								<option value='".kill_and_strip($D_ecom_settigns['delivery_pay'])."'>".$word[LANG]['1_1_ecom_form_step_2_delivery_pay_1'].": ".kill_and_strip($delivery_pay)." ".COIN."</option>
							</select>";
						}
						
						echo "</td>";
					echo "</tr>";
					echo "<tr><td height='5' colspan=3></td></tr>";
					echo "<tr><td colspan=3><hr width=100% size=1 class=\"maintext\" /></td></td>";
					}
					else
					{
						echo "<input type='hidden' name='delivery_pay' value='0'>";
					}
					
					echo "<tr><td height='5' colspan=3></td></tr>";
					echo "<tr>";
						if( UNK != "567556530384297372" )
							echo "<td colspan='3'>".nl2br(kill_and_strip($D_ecom_settigns['textarea_content']))."</td>";
						else
						{
							echo "<td colspan='3'>
							".nl2br(kill_and_strip($D_ecom_settigns['textarea_content']))."<br>
							* משלוח מהיר ייחויב בנפרד<br><br>
							<b>סליקת כרטיסי האשראי נעשית על שרת מאובטח מאושר על ידי חברת ישראכרט, חשבונית אוטומטית תשלח לכתובת המייל שלכם<br>
							חברת בדים נט מתחייבת לא להעביר את שמכם כתובתכם או כל פרט אחר לשום גורם</b><br><br>
							לנוחיותכם ניתן לשלם טלפונית במספר 1-700-72-3254
							</td>";
						}
					echo "</tr>";
					echo "<tr><td height='10' colspan=3></td></tr>";
					echo "<tr>";
						echo "<td valign=top>".$word[LANG]['1_1_ecom_form_step_2_free_text']."</td>";
						echo "<td width=10></td>";
						echo "<td><textarea cols='' rows='' name='content' class='input_style' style='height:100px; width:250px;'></textarea></td>";
					echo "</tr>";
					echo "<tr><td height='5' colspan=3></td></tr>";
					
					$must_content = ( UNK == "995628678735762902" ) ? "onClick='if( document.step2_ecom_form.content.value == \"\" ) { alert(\"טקסט חופשי הינו שדה חובה\"); return false; }'" : "";
					
					echo "<tr>";
						echo "<td valign=top></td>";
						echo "<td width=10></td>";
						echo "<td align=left><input type='submit' value='".$word[LANG]['1_1_ecom_form_step_1_next_step']."' class='submit_style' ".$must_content."></td>";
					echo "</tr>";
					echo "</form>";
				echo "</table>";
			echo "</td>";
		echo "</tr>";
		echo "<tr><td height='20'></td></tr>";
	
	echo "</table>";
}


function add_order_to_DB()
{
	global $word;
	
	if( !empty($_SESSION['ecom']['unickSES']) )
	{
		if( !empty($_POST['client_id']) || !empty($_POST['netEcomSyncId']) )
		{
			$image_settings = array(
				after_success_goto=>"",
				table_name=>"user_ecom_orders",
			);
			
			$data_arr2['unk'] = UNK;
			if( $_POST['EcomSes_net'] == "" )
				$data_arr2['client_unickSes'] = $_SESSION['ecom']['unickSES'];
			else
				$data_arr2['client_unickSes'] = $_POST['EcomSes_net'];
			
			$data_arr2['client_id'] = $_POST['client_id'];
			$data_arr2['netEcomSyncId'] = $_POST['netEcomSyncId'];
			$data_arr2['content'] = $_POST['content'];
			$data_arr2['delivery_pay'] = $_POST['delivery_pay'];
			
			insert_to_db($data_arr2, $image_settings);
			
			if( UNK == "806700060391385236" )
			{
				$data_arr3 = $data_arr2;
				$data_arr3['client_id'] = '1';
				insert_to_db($data_arr3, $image_settings);
			}
			
			
			if( $data_arr2['netEcomSyncId'] != "" )
				$sql = "UPDATE user_ecom_orders SET insert_date = NOW() WHERE netEcomSyncId = '".$data_arr2['netEcomSyncId']."' AND client_unickSes = '".$data_arr2['client_unickSes']."' AND unk = '".UNK."'";
			else
				$sql = "UPDATE user_ecom_orders SET insert_date = NOW() WHERE client_id = '".$data_arr2['client_id']."' AND client_unickSes = '".$data_arr2['client_unickSes']."' AND unk = '".UNK."'";
			$res = mysql_db_query( DB, $sql);
			
			// 
			if( UNK != '607189207778116683' AND UNK != '625420717714095702' AND UNK != '077207507163809959' AND UNK != '244664172114634996' )
			{
				$_SESSION['ecom']['unickSES'] = "";
				$_SESSION['ecom']['active'] = "";
			}
			
			$sql_user = "select id,email from users where unk = '".UNK."' ";
			$res_user = mysql_db_query(DB,$sql_user);
			$data_user = mysql_fetch_array($res_user);
			
			if( GlobalFunctions::validate_email_address($data_user['email']) )
			{
				
				$fromEmail = "info@ilbiz.co.il"; 
				$fromTitle = "il-biz"; 
				
				$content = $word[LANG]['1_1_add_order_to_DB_email_content'];
				
				$header_send_to_Client= $word[LANG]['1_1_add_order_to_DB_email_headline'];
				$content_send_to_Client = "
					<html dir=rtl>
					<head>
							<title></title>
							<style type='text/css'>
								.textt{font-family: arial; font-size:12px; color: #000000}
							</style>
					</head>
					
					<body>
						<p class='textt' dir=rtl align=right>".$content."</p>
					</body>
					</html>";
				
				$ClientMail = $data_user['email'];
				GlobalFunctions::send_emails_with_phpmailer($fromEmail, $fromTitle, $header_send_to_Client, $content_send_to_Client, $content_send_to_Client, $ClientMail, $fromTitle );
			}
			
			if( UNK == "625420717714095702" )
				echo "<script type='text/javascript'>window.location.href='index.php?m=get_thanks_ecom_form&from_site=amuta-fmn';</script>";
			elseif( UNK == "607189207778116683" )
				echo "<script type='text/javascript'>window.location.href='index.php?m=get_thanks_paypalJewelry';</script>";
			elseif( UNK == "077207507163809959" )
				echo "<script type='text/javascript'>window.location.href='index.php?m=get_thanks_paypal__ktarim';</script>";
			elseif( UNK == "244664172114634996" )
				echo "<script type='text/javascript'>window.location.href='index.php?m=get_thanks_paypal__shangola';</script>";
			else
				echo "<script type='text/javascript'>window.location.href='index.php?m=get_thanks&type=ecom_form';</script>";
			
			exit;
		}
		else
		{
			echo "<script type='text/javascript'>alert('Error number 2136');</script>";
			echo "<script type='text/javascript'>window.location.href='index.php?m=ecom_form';</script>";
				exit;
		}
	}
	else
	{
		echo "<script type='text/javascript'>alert('Error number #*2137*#');</script>";
		echo "<script type='text/javascript'>window.location.href='index.php';</script>";
			exit;
	}
	
}

function get_thanks_ecom_form()
{
	global $word;
	
	echo "
	<form action='https://secure.ilbiz.co.il/clients/".$_GET['from_site']."/' method='POST' name='formi_gotossl'>
	<input type='hidden' name='unickSES' value='".$_SESSION['ecom']['unickSES']."'>
	<input type='hidden' name='active' value='".$_SESSION['ecom']['active']."'>
	</form>
	<p dir=rtl align=right>טוען...</p>
	<script>document.formi_gotossl.submit();</script>
	";
	
		$_SESSION['ecom']['unickSES'] = "";
		$_SESSION['ecom']['active'] = "";
}


function add_new_reg_client()
{
	global $word;
	
	if( is_array($_POST['reg_arr']) )
	{
		if( !empty($_POST['reg_arr']['email']) && !empty($_POST['reg_arr']['password']) )
		{
			$sql = "select id,email,password,unk from user_clients WHERE unk='".UNK."' AND email = '".$_POST['reg_arr']['email']."' AND password = '".$_POST['reg_arr']['password']."' AND deleted=0";
			$res = mysql_db_query(DB, $sql);
			$client_details = mysql_fetch_array($res);
			
			$client_id = $client_details['id'];
			
			if( !($client_details['unk'] == UNK && !empty($client_id) && $client_details['email'] == $_POST['reg_arr']['email'] && $client_details['password'] == $_POST['reg_arr']['password'] )  )
			{
				
				echo "<script type='text/javascript'>alert('".$word[LANG]['1_1_add_new_reg_client_detailsNot']."');</script>";
				send_form_data_TO_back("ecom_form");
					exit;
			}
		}
		else
		{
			echo "<script type='text/javascript'>alert('".$word[LANG]['1_1_add_new_reg_client_most_email']."');</script>";
			send_form_data_TO_back("ecom_form");
				exit;
		}
	}
	elseif( is_array($_POST['joinUs_arr']) )
	{
		$sql = "select email from user_clients WHERE unk='".UNK."' AND email = '".$_POST['joinUs_arr']['email']."' AND deleted=0";
		$res = mysql_db_query(DB, $sql);
		$client_details_c = mysql_fetch_array($res);
		
		if( !empty($client_details_c['email'] ) )
		{
			echo "<script type='text/javascript'>alert('".$word[LANG]['1_1_add_new_reg_client_duplicate_email']."');</script>";
			send_form_data_TO_back("ecom_form");
				exit;
		}
		
		if( !GlobalFunctions::validate_email_address($_POST['joinUs_arr']['email']) )
		{
			echo "<script type='text/javascript'>alert('".$word[LANG]['1_1_add_new_reg_client_email_not_good']."');</script>";
			send_form_data_TO_back("ecom_form");
				exit;
		}
		
			$image_settings = array(
				after_success_goto=>"",
				table_name=>"user_clients",
			);
			$data_arr = ($_POST['joinUs_arr'])? $_POST['joinUs_arr'] : $_GET['joinUs_arr'];
			
			insert_to_db($data_arr, $image_settings);
			
			
			$sql = "select id from user_clients WHERE unk='".UNK."' AND email = '".$_POST['joinUs_arr']['email']."' AND password = '".$_POST['joinUs_arr']['password']."' AND deleted=0";
			$res = mysql_db_query(DB, $sql);
			$client_details = mysql_fetch_array($res);
			
			$client_id = $client_details['id'];
	}
	else
	{
		echo "<script type='text/javascript'>alert('Error number 2124');</script>";
		echo "<script type='text/javascript'>window.location.href='index.php?m=ecom_form';</script>";
			exit;
	}
	
	echo "<form action='index.php' method='post' name='formi' id='formi'>";
	echo "<input type='hidden' name='m' value='ecom_form2'>";
	echo "<input type='hidden' name='client_id' value='".$client_id."'>";
	echo "</form>";
	echo "<script>document.getElementById('formi').submit()</script>";
}


function send_form_data_TO_back($to_where)
{
	echo "<form action='?' name='formi' id='formi' method='POST'>";
		echo "<input type='hidden' name='m' value='ecom_form'>";
		foreach( $_POST as $val => $key )
		{
			if( $val != "m" && $val != "submit" )
				if( is_array($key) )
					foreach( $key as $val_key => $key_key )
						echo "<input type='hidden' name='".$val."[".$val_key."]' value='".$key_key."'>";
				else
					echo "<input type='hidden' name='".$val."' value='".$key."'>";
		}
	echo "</form>";
	echo "<script>document.getElementById('formi').submit()</script>";
}
?>