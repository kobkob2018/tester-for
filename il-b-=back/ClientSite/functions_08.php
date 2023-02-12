<?

function set_PRODUCT_popup($data,$return_div="2")
{
	global $settings, $word, $data_name;
	
	$create_link;
	$create_popup;
	
	// check if the client has popup product;
	if( $data_name['pr_popUpType2'] == "1" )
	{
		
		$abpath_temp = SERVER_PATH."/products/".$data['img2'];
		$abpath_tempt = SERVER_PATH."/products/".$data['img'];
		$abpath_tempEX = SERVER_PATH."/products/".$data['img3'];
		
		if( file_exists($abpath_tempEX) && !is_dir($abpath_tempEX) )
		{
			list($org_width, $org_height) = getimagesize($abpath_tempEX);
			
			$view_img = $data['img3'];
			$sPrEX_width = 680;
			$sPrEX_height = 500;
		}
		elseif( file_exists($abpath_temp) && !is_dir($abpath_temp) )
		{
			list($org_width, $org_height) = getimagesize($abpath_tempEX);
			
			$view_img = $data['img2'];
			$sPrEX_width = 680;
			$sPrEX_height = 500;
		}
		elseif( file_exists($abpath_tempt) && !is_dir($abpath_tempt) )
		{
			list($org_width, $org_height) = getimagesize($abpath_tempt);
			
			$view_img = $data['img'];
			$sPrEX_width = $org_width + 250;
			$sPrEX_height = $org_height + 100;
		}
		else
		{
			$view_img = "";
			$sPrEX_width = 250;
			$sPrEX_height = 200;
		}
		
		// content of the popup
		$create_popup .= "<div id=\"s.prPopUpDiv".$data['id']."\" style=\"display:none\" class=\"maintext\" dir=rtl>";
			$create_popup .= "<table width=\"100%\" align=center class='maintext' dir=rtl>";
				if( $view_img != "" )
				{
					$create_popup .= "<tr>
						<td align=center><img src='products/".$view_img."' border='0'></td>
					</tr>";
				}
				
				$create_popup .= "<tr>
					<td align=center>";
						$create_popup .= "<b>".nl2br(htmlspecialchars(stripslashes($data['summary'])))."</b><br><br>";
				
						if( !empty($data['url_name']) && !empty($data['url_link']) )
							$create_popup .= $word[LANG]['1_1_products_url_link']." <a href='".htmlspecialchars(stripslashes($data['url_link']))."' class='maintext' target='_blank'><b><u>".htmlspecialchars(stripslashes($data['url_name']))."</u></b></a><br>";
						if( $data['price'] )
							$create_popup .= $word[LANG]['1_1_products_price']." <b>".htmlspecialchars(stripslashes($data['price']))." ".COIN."</b><br><br>";
						
						$content = string_rplace_func($data['content']);
						$create_popup .= nl2br(htmlspecialchars(stripslashes($content)))."<br><br>";
						
						if( $data_name['have_ecom'] == "1" && $data['active_ecom'] == "1" )
							$create_popup .= "<a href='javascript:void(0)' onclick=\"addToBasket(".$data['id'].");return false\">".$word[LANG]['1_1_products_add_to_cart']."</a>";
						
					$create_popup .= "</td>
				</tr>
			</table>";
			
		$create_popup .= "</div>";
		
		// link to popup
		$linkNameTemp = str_replace( "'" , "" , htmlspecialchars(stripslashes($data['name'])) );
		$create_link = "<a href=\"javascript:void(0)\" onclick=\"divwin=dhtmlwindow.open('s.prPopUp".$data['id']."', 'div', 's.prPopUpDiv".$data['id']."', '".$linkNameTemp."', 'width=".$sPrEX_width."px,height=".$sPrEX_height."px,left=10px,top=10px,resize=0,scrolling=1'); return false\">";
		
		if( $return_div == "1" )
			echo $create_popup;
		else
			return $create_link;
	}
	else
		if( $return_div == "1" )
			return "";
		else
			return "sp";
}



function generatePassword ($length=8) {
    $password = "";
    $possible = "0123456789bcdfghjkmnpqrstvwxyz"; 
    $i = 0; 
    while ($i < $length) { 
        $char = substr($possible, mt_rand(0, strlen($possible)-1), 1);
            if (!strstr($password, $char)) {
                $password .= $char;
                $i++;
            }
        }
        return $password;
}

function net_forget_password()
{
	global $word;
	
	echo "<table border=\"0\" cellspacing=\"0\" cellpadding=\"0\" class=\"maintext\">";
	echo "<form action='index.php' name='forget_password_form' method='POST'>";
	echo "<input type='hidden' name='m' value='NetPass_AC'>";
		echo "<tr><td height=\"25\"></td></tr>";
		echo "<tr>";
			echo "<td><h3>".$word[LANG]['1_4_net_pass_foreget_headline']."</h3></td>";
		echo "</tr>";
		echo "<tr><td height=\"10\"></td></tr>";
		echo "<tr>";
			echo "<td style='font-size:14px;'>".$word[LANG]['1_4_net_pass_foreget_insert_email']."</td>";
		echo "</tr>";
		echo "<tr><td height=\"7\"></td></tr>";
		echo "<tr>";
			echo "<td><input type='text' name='res_email' class='input_style' dir=ltr style='width: 250px;'>&nbsp;&nbsp;<input type='submit' value='".$word[LANG]['1_4_net_pass_foreget_next']."' class='submit_style'></td>";
		echo "</tr>"; 
		echo "<tr><td height=\"7\"></td></tr>";
		echo "<tr>";
			echo "<td><font style='font-size:12px;'><u>".$word[LANG]['1_4_net_pass_foreget_note']."</u> ".$word[LANG]['1_4_net_pass_foreget_note_text']."</font></td>";
		echo "</tr>";
		echo "<tr>";
			echo "<td><font style='font-size:12px;'>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; ".$word[LANG]['1_4_net_pass_foreget_more_note']."</font></td>";
		echo "</tr>";
	echo "</form>";
	echo "</table>";

}


function net_forget_password_AC()
{
	global $word,$settings;
	
	$sql = "SELECT verify, fname, lname, email, password, unick_ses  FROM net_users WHERE email = '".mysql_real_escape_string($_POST['res_email'])."' LIMIT 1";
	$res = mysql_db_query(DB, $sql);
	$Data = mysql_fetch_array($res);
	
	if( $Data['verify'] == "0" )
	{
		echo $word[LANG]['1_4_net_pass_foregetAC_no_active'].",<br>
		<a href='index.php?m=NetPass_VR&us=".stripslashes($Data['unick_ses'])."' class='maintext'>".$word[LANG]['1_4_net_pass_foregetAC_need_click']."</a> ".$word[LANG]['1_4_net_pass_foregetAC_more_text'];
	}
	elseif( $Data['verify'] == "1" )
	{
		echo "<h3>".$word[LANG]['1_4_net_pass_foreget_headline']."</h3>";
		
		$sql = "SELECT name FROM users WHERE unk = '".UNK."'";
		$res = mysql_db_query(DB, $sql);
		$user_details = mysql_fetch_array($res);
	
		$fromEmail = "info@ilbiz.co.il"; 
		$fromTitle = stripslashes($user_details['name']); 
		
		$site_domain = explode( "http://" , HTTP_PATH );
		
		$content = "
		".$word[LANG]['1_4_net_pass_foregetAC_email_hello']." ".stripslashes($Data['fname'])." ".stripslashes($Data['lname']).",<br>
		<br>
		".$word[LANG]['1_4_net_pass_foregetAC_email_fst_txt']."<br>
		<br>
		".$word[LANG]['1_4_net_pass_foregetAC_email']." ".stripslashes($Data['email'])."<br>
		".$word[LANG]['1_4_net_pass_foregetAC_email_pass']." ".stripslashes($Data['password'])."<br><br>
		".$word[LANG]['1_4_net_pass_foregetAC_email_snd_txt']."
		".stripslashes($user_details['name'])."<br>
		<a href='".HTTP_PATH."' class='text_link' target='_blank'>".$site_domain[1]."</a>
		";

				$header_send_to_Client= $word[LANG]['1_4_net_pass_foreget_headline'];
				$content_send_to_Client = "
					<html dir=".$settings['dir'].">
					<head>
							<title></title>
							<style type='text/css'>
								.textt{font-family: arial; font-size:12px; color: #000000}
								.text_link{font-family: arial; font-size:12px; color: navy}
							</style>
					</head>
					
					<body>
						<p class='textt' dir=".$settings['dir']." align=".$settings['align'].">".$content."</p>
					</body>
					</html>";
				
				$ClientMail = stripslashes($Data['email']);
				GlobalFunctions::send_emails_with_phpmailer($fromEmail, $fromTitle, $header_send_to_Client, $content_send_to_Client, $content_send_to_Client, $ClientMail, $fromTitle );

		echo "<p style='font-size:14px;'>".$word[LANG]['1_4_net_pass_foregetAC_sent1']." ".$ClientMail."<br>".$word[LANG]['1_4_net_pass_foregetAC_sent2']."<br><br><a href='index.php' class='maintext' style='font-size:14px;'><u>".$word[LANG]['1_4_net_pass_foregetAC_sent3']."</u></a></p>";
	}
	else
	{
		echo "<h3>".$word[LANG]['1_4_net_pass_foreget_headline']."</h3>";
		echo "<p style='font-size:14px;'>".$word[LANG]['1_4_net_pass_foregetAC_error1']."<br><br><a href='index.php?m=NetPass' class='maintext' style='font-size:14px;'><u>".$word[LANG]['1_4_net_pass_foregetAC_error2']."</u></a></p>";
	}
}


function net_forget_password_verify()
{
	$sql = "SELECT verify, fname, lname, email, password, unick_ses  FROM net_users WHERE unick_ses = '".mysql_r_e_s($_GET['us'])."' LIMIT 1";
	$res = mysql_db_query(DB, $sql);
	$Data = mysql_fetch_array($res);
	
	/*
	// 
	// take the client details
	//
	*/
	$sql = "SELECT name FROM users WHERE unk = '".UNK."'";
	$res = mysql_db_query(DB, $sql);
	$user_details = mysql_fetch_array($res);
	
	
	
	/*
	// 
	// send verifycation mail to the new user
	//
	*/
	$fromEmail = "info@ilbiz.co.il"; 
	$fromTitle = stripslashes($user_details['name']); 
	
	$site_domain = explode( "http://" , HTTP_PATH );
	
	$content = "
	שלום ".stripslashes($Data['fname'])." ".stripslashes($Data['lname']).",<br>
	<br>
	הנך בתהליך שיחזור סיסמה, על מנת שנוכל לזהותך ושלוח לך אימייל עם הסיסמה, יש ללחוץ <a href='http://www.ilbiz.co.il/newsite/net_system/verify_email.php?s=".stripslashes($Data['unick_ses'])."' class='text_link' target='_blank'>כאן</a><BR>
	לאחר מכן יש להכנס שוב לאתר <a href='".HTTP_PATH."' class='text_link' target='_blank'>".stripslashes($user_details['name'])."</a> ולחזור על תהליך השיחזור<br>
	<br>
	תודה על שיתוף הפעולה,<br>
	".stripslashes($user_details['name'])."<br>
	<a href='".HTTP_PATH."' class='text_link' target='_blank'>".$site_domain[1]."</a>
	";
				
				$header_send_to_Client= "הצטרפות למועדון חברים - שיחזור סיסמה";
				$content_send_to_Client = "
					<html dir=rtl>
					<head>
							<title></title>
							<style type='text/css'>
								.textt{font-family: arial; font-size:12px; color: #000000}
								.text_link{font-family: arial; font-size:12px; color: navy}
							</style>
					</head>
					
					<body>
						<p class='textt' dir=rtl align=right>".$content."</p>
					</body>
					</html>";
				
				$ClientMail = stripslashes($Data['email']);
				GlobalFunctions::send_emails_with_phpmailer($fromEmail, $fromTitle, $header_send_to_Client, $content_send_to_Client, $content_send_to_Client, $ClientMail, $fromTitle );
	
	echo "בדקות הקרובות תקבלו אימייל בו אנו נאמת את כתובתכם.<br>לאחר האימות יש ללחוץ <a href='index.php?m=NetPass' class='maintext'>כאן</a>";
}

function register_net_form()
{
	
	global $word;
	
	$sql = "select * from content_pages where unk = '".UNK."' and type = 'net' and deleted = '0'";
	$res = mysql_db_query(DB,$sql);
	$data = mysql_fetch_array($res);
	
	$terms = "<table border=\"0\" cellspacing=\"0\" cellpadding=\"0\" class=\"maintext\">
	<tr><td><input type='checkbox' name='net_TaknonRegS' id='net_TaknonRegS' value='1'></td><td width=5></td><td>אני מסכים/ה <a href='http://www.ilbiz.co.il/newsite/net_system/terms.php' class='maintext' target=_blank>לתנאי השימוש</a> באתר.</td></tr></table>";
	
	if( eregi( "10service.co.il" , $_SERVER[HTTP_HOST] ) )
		$arr_product = array("hidden","productId",$_GET['productId']);
	
	$form_arr = array(
		array("hidden","m","regNetF_DB"),
		array("hidden","data_arr[reg_unk]",UNK),
		array("hidden","record_id",""),
		$arr_product,
		
		array("text","data_arr[fname]","","* ".$word[LANG]['1_1_regNetF_fname'].":", "class='input_style'"),
		array("text","data_arr[lname]","","* ".$word[LANG]['1_1_regNetF_lname'].":", "class='input_style'"),
		array("text","data_arr[email]","","* ".$word[LANG]['1_1_regNetF_email'].":", "class='input_style' dir=ltr"),
		array("password","data_arr[password]","","* ".$word[LANG]['1_1_regNetF_password'].":", "class='input_style'"),
		
		array("blank",$terms),
		
		/*array("date","birthday","",$word[LANG]['1_1_regNetF_birthday'].":", "class='input_style'"),
		array("text","data_arr[mobile]","",$word[LANG]['1_1_regNetF_mobile'].":", "class='input_style'"),
		
		array("select","gender[]",$gender,$word[LANG]['1_1_regNetF_gender'].":","","data_arr[gender]", "class='input_style'"),
		array("select","city[]",$city,$word[LANG]['1_1_regNetF_city'].":","","data_arr[city]", "class='input_style'"),*/
		
		
		array("hidden","data_arr[date_in]",GlobalFunctions::get_timestemp(),"", ""),
		array("submit","submit","המשך...", "class='submit_style'")
	);
	
	$more = "class='maintext'";
	
	$mandatory_fields = array("net_TaknonRegS","data_arr[email]","data_arr[password]","data_arr[fname]","data_arr[lname]");
	
	$get_form = FormCreator::create_form($form_arr,"index.php", $more, $mandatory_fields);
	
	echo "<table border=\"0\" cellspacing=\"0\" cellpadding=\"0\" class=\"maintext\">";
		
		$content = string_rplace_func($data['content']);
		echo "<tr id = 'main_content_top_margin_tr'><td height=25></td></tr>";
		
		if( !eregi( "10service.co.il" , $_SERVER[HTTP_HOST] ) )
			$headline = "טופס הרשמה למועדון חברים - שלב 1 מתוך 2";
		else
			$headline = "טופס הרשמה לחברי שלם פחות - שלב 1 מתוך 2";
		
		echo "<tr id = 'main_content_title_tr'>";
			echo "<td colspan=3><h3>".$headline."</h3></td>";
		echo "</tr>";
		
		echo "<tr>";
			echo "<td>".stripslashes($content)."</td>";
		echo "</tr>";
		echo "<tr><td height=\"10\"></td></tr>";
		echo "<tr>";
			echo "<td>".$get_form."</td>";
		echo "</tr>";
		
	echo "</table>";
}

function register_net_form2()
{
	
	global $word;
	
	$sql = "select * from content_pages where unk = '".UNK."' and type = 'net' and deleted = '0'";
	$res = mysql_db_query(DB,$sql);
	$data = mysql_fetch_array($res);
	
	$sql = "select id,name from cities order by name";
	$res_city = mysql_db_query(DB,$sql);
	
	$sql = "SELECT fieldName, inputType, id, maxlenght, defaultText FROM dynamic_client_form WHERE unk = '".UNK."' AND active=0 AND adminField=0 ORDER BY place";
	$res_fields =	mysql_db_query(DB, $sql);
	
	
	echo "<table border=\"0\" cellspacing=\"0\" cellpadding=\"0\" class=\"maintext\">";
	echo "<form action='index.php' method=POST name='reg2_form' onsubmit>";
	echo "<input type=hidden name='m' value='regNetF2_DB'>";
	echo "<input type=hidden name='usi' value='".$_GET['usi']."'>";
	if( eregi( "10service.co.il" , $_SERVER[HTTP_HOST] ) )
	echo "<input type=hidden name='productId' value='".$_GET['productId']."'>";
		echo "<tr><td height=25></td></tr>";
		
		if( !eregi( "10service.co.il" , $_SERVER[HTTP_HOST] ) )
			$headline = "טופס הרשמה למועדון חברים  - שלב 2 מתוך 2";
		else
			$headline = "טופס הרשמה לחברי שלם פחות - שלב 2 מתוך 2";
		
		echo "<tr>";
			echo "<td colspan=3><h3>".$headline."</h3></td>";
		echo "</tr>";
		
		echo "<tr>";
			echo "<td>".$word[LANG]['1_1_regNetF_birthday'].":</td>";
			echo "<td width=10></td>";
			echo "<td><input type='text' name='birthday' dir=ltr class='input_style'> <span style='font-size:10px;'>dd-mm-yyyy</span></td>";
		echo "</tr>";
		echo "<tr><td height=\"7\" colspan=3></td></tr>";
		
		echo "<tr>";
			echo "<td>".$word[LANG]['1_1_regNetF_mobile'].":</td>";
			echo "<td width=10></td>";
			echo "<td><input type='text' name='data_arr[mobile]' id='data_arr[mobile]' dir=ltr class='input_style'></td>";
		echo "</tr>";
		echo "<tr><td height=\"7\" colspan=3></td></tr>";
		
		echo "<tr>";
			echo "<td>".$word[LANG]['1_1_regNetF_gender'].":</td>";
			echo "<td width=10></td>";
			echo "<td>";
				echo "<select name='data_arr[gender]' class='input_style' style='height: 19px;'>";
					echo "<option value=''>בחירה</option>";
					echo "<option value='1'>זכר</option>";
					echo "<option value='2'>נקבה</option>";
				echo "</select>";
			echo "</td>";
		echo "</tr>";
		echo "<tr><td height=\"7\" colspan=3></td></tr>";
		
		echo "<tr>";
			echo "<td>".$word[LANG]['1_1_regNetF_city'].":</td>";
			echo "<td width=10></td>";
			echo "<td>";
				echo "<select name='data_arr[city]' class='input_style' style='height: 19px;'>";
					echo "<option value=''>בחירה</option>";
					while($data_city = mysql_fetch_array($res_city))
					{
						echo "<option value='".$data_city['id']."'>".stripslashes($data_city['name'])."</option>";
					}
				echo "</select>";
			echo "</td>";
		echo "</tr>";
		echo "<tr><td height=\"7\" colspan=3></td></tr>";
		
		while( $data_fields = mysql_fetch_array($res_fields) )
		{
			$params = array();
			$params['inputType'] = $data_fields['inputType'];
			$params['class'] = "input_style";
			$params['name'] = "field_".$data_fields['id'];
	
			$params['unk'] = UNK;
			$params['dynamicId'] = $data_fields['id'];
	
			$params['maxlenght'] = $data_fields['maxlenght'];
			$params['style'] = "";
			$params['style_textarea'] = "height: 100px;";
			$params['value'] = stripslashes($data_fields['defaultText']);
			
				echo "<tr>";
					echo "<td>".stripslashes($data_fields['fieldName']).":</td>";
					echo "<td width=10></td>";
					echo "<td>".ilbizNet::siteInputType($params)."</td>";
				echo "</tr>";
				echo "<tr><td height=\"7\" colspan=3></td></tr>";
		}
		echo "<tr><td height=\"7\" colspan=3></td></tr>";
		
		$must_content = ( UNK == "995628678735762902" ) ? "onClick='if( document.getElementById(\"data_arr[mobile]\").value == \"\" ) { alert(\"טלפון נייד הינו שדה חובה\"); return false; }'" : "";
		echo "<tr>";
			echo "<td></td>";
			echo "<td width=10></td>";
			echo "<td><input type='submit' value='סיום הרשמה' class='submit_style' ".$must_content."></td>";
		echo "</tr>";
		echo "<tr><td height=\"7\" colspan=3></td></tr>";
	echo "</form>";
	echo "</table>";
}

function register_net_form2_DB()
{
	
	$data_arr = $_POST['data_arr'];
	
	$sql = "SELECT id , email , password FROM net_users WHERE unick_ses = '".$_POST['usi']."' ";
	$res = mysql_db_query(DB,$sql);
	$net_user_idr = mysql_fetch_array($res);
	$_REQUEST['record_id'] = $net_user_idr['id'];
	
	if( $_REQUEST['record_id'] == "" )
	{
		echo "פעולה נכשלה, יש לנסות שוב";
		exit;
	}
	/*
	// 
	// insert the user details to DB
	//
	*/
	$image_settings = array(
		"after_success_goto" => "DO_NOTHING",
		"table_name" => "net_users",
		"flip_date_to_original_format" => array("birthday"),
	);
	
	update_db($data_arr, $image_settings);
	
	
	/*
	//
	//	insert into dynamic fields data
	//
	*/
	
	$sql = "SELECT id FROM dynamic_client_form WHERE unk = '".UNK."' AND active=0 AND adminField=0 ORDER BY place";
	$res_fields =	mysql_db_query(DB, $sql);
	$data__fields = mysql_num_rows($res_fields);
	
	if( $data__fields > 0 )
	{
		$params['unk'] = UNK;
		$params['adminField'] = '3';
		$params['getValues'] = $_POST;
		$params['user_id'] = $net_user_idr['id'];
		ilbizNet::InsertUpdate( $params );
	}
	
	if( eregi( "10service.co.il" , $_SERVER[HTTP_HOST] ) )
	{
		echo "<form action='http://www.ilbiz.co.il/newsite/net_system/login_page.php' name='formi' method='post'>";
		echo "<input type='hidden' name='action' value='enter'>";
		echo "<input type='hidden' name='NetEmail' value='".$net_user_idr['email']."'>";
		echo "<input type='hidden' name='NetPass' value='".$net_user_idr['password']."'>";
		echo "<input type='hidden' name='unk' value='".UNK."'>";
		echo "<input type='hidden' name='f10serv' value='yes'>";
		echo "<input type='hidden' name='productId' value='".$_POST['productId']."'>";
		echo "</form>";
		echo "loading...<script type='text/javascript'>formi.submit()</script>";
	}
	else
		echo "<META HTTP-EQUIV=Refresh CONTENT=\"0; URL=index.php?m=regNetF_thx\">";
	
}

function register_net_form_DB()
{
	$data_arr = $_POST['data_arr'];
	
	/*
	//
	//	check if the mail right
	//
	*/
	if( !GlobalFunctions::validate_email_address($data_arr['email']) )
	{
		echo "<script type='text/javascript'>alert('אימייל לא חוקי');</script>";
		echo "<script type='text/javascript'>window.location.href='javascript:history.go(-1)';</script>";
			exit;
			
	}
	
	$sql = "SELECT email FROM net_users WHERE email = '".$data_arr['email']."'";
	$res = mysql_db_query(DB,$sql);
	$data_email = mysql_fetch_array($res);
	
	if( stripslashes($data_email['email']) == $data_arr['email'] )
	{
		echo "<script type='text/javascript'>alert('לפי רישומנו, כתובת האימייל אותו הקלדת קיים במערכת, באפשרותך לשחזר סיסמה');</script>";
		echo "<script type='text/javascript'>window.location.href='index.php?m=NetPass';</script>";
			exit;
	}
	
	/*
	// 
	// create unick session id for the user
	//
	*/
	$ss1  = time("H:m:s",1000000000);
	$ss2 = $_SERVER[REMOTE_ADDR];
	$sesid = $ss2.$ss1;
	
	$data_arr['unick_ses'] = md5($sesid);
	
	
	/*
	// 
	// insert the user details to DB
	//
	*/
	$image_settings = array(
		"after_success_goto" => "DO_NOTHING",
		"table_name" => "net_users",
		//"flip_date_to_original_format" => array("birthday"),
	);
	
	insert_to_db($data_arr, $image_settings);
	
	$new_user_id = $GLOBALS['mysql_insert_id'];
	
	/*
	// 
	// insert to verify table DB
	//
	*/
	$sql = "INSERT INTO net_users_verify_mails ( net_user_id, goto_domain ) VALUES ( '".$new_user_id."' , '".HTTP_PATH."' )";
	$res = mysql_db_query( DB, $sql );
	
	
	/*
	// 
	// take the client details
	//
	*/
	$sql = "SELECT name FROM users WHERE unk = '".UNK."'";
	$res = mysql_db_query(DB, $sql);
	$user_details = mysql_fetch_array($res);
	
	
	
	/*
	// 
	// send verifycation mail to the new user
	//
	*/
	$fromEmail = "info@ilbiz.co.il"; 
	$fromTitle = stripslashes($user_details['name']); 
	
	$site_domain = explode( "http://" , HTTP_PATH );
	
	$content = "
	שלום ".$data_arr['fname']." ".$data_arr['lname'].",<br>
	<br>
	את/ה קרוב/ה לחיצה אחת מסיום ההרשמה למועדון חברים של <a href='".HTTP_PATH."' class='text_link' target='_blank'>".stripslashes($user_details['name'])."</a><br>
	על מנת לסיים את שלבי ההרשמה יש ללחוץ <a href='http://www.ilbiz.co.il/newsite/net_system/verify_email.php?s=".$data_arr['unick_ses']."' class='text_link' target='_blank'>כאן</a><br>
	<br>
	בברכה,<br>
	".stripslashes($user_details['name'])."<br>
	<a href='".HTTP_PATH."' class='text_link' target='_blank'>".$site_domain[1]."</a>
	";
				
				$header_send_to_Client= "הצטרפות למועדון חברים";
				$content_send_to_Client = "
					<html dir=rtl>
					<head>
							<title></title>
							<style type='text/css'>
								.textt{font-family: arial; font-size:12px; color: #000000}
								.text_link{font-family: arial; font-size:12px; color: navy}
							</style>
					</head>
					
					<body>
						<p class='textt' dir=rtl align=right>".$content."</p>
					</body>
					</html>";
				
				$ClientMail = $data_arr['email'];
				GlobalFunctions::send_emails_with_phpmailer($fromEmail, $fromTitle, $header_send_to_Client, $content_send_to_Client, $content_send_to_Client, $ClientMail, $fromTitle );

		
	/*
	//
	// insert into user belong network sites DB
	//
	*/
	$sql = "INSERT INTO net_users_belong ( net_user_id , unk, join_date ) values ( '".$new_user_id."' , '".UNK."', NOW() ) ";
	$res = mysql_db_query( DB, $sql );
	
	
	/*
	//
	// insert into user system agent and ip - DB
	//
	*/
	$sql = "INSERT INTO net_users_ip ( net_user_id , ip, agent ) values ( '".$new_user_id."' , '".$_SERVER[REMOTE_ADDR]."' , '".$_SERVER[HTTP_USER_AGENT]."' ) ";
	$res = mysql_db_query( DB, $sql );
	
	
	net_user_cookie("save" , $data_arr['unick_ses'] );
	
	if( eregi( "10service.co.il" , $_SERVER[HTTP_HOST] ) )
		echo "<META HTTP-EQUIV=Refresh CONTENT=\"0; URL=index.php?m=regNetF2&usi=".$data_arr['unick_ses']."&productId=".$_POST['productId']."\">";
	elseif( $_POST['quickSave'] == "1" )
	{
		echo "<script type='text/javascript'>window.location.href='javascript:history.go(-1)';</script>";
	}
	else
		echo "<META HTTP-EQUIV=Refresh CONTENT=\"0; URL=index.php?m=regNetF2&usi=".$data_arr['unick_ses']."\">";
	
}

function net_mail_verOK()
{
	echo "<p>&nbsp;</p>הרשמתך הסתיימה בהצלחה,<br>
כעת באפשרותך להתחבר למועדון החברים כאן באתר,<br><br>
גלישה נעימה - צוות אתר...";
}

function net_mail_remove()
{
	$sql = "SELECT id,unick_ses,reg_unk FROM net_users WHERE unick_ses = '".mysql_r_e_s($_POST['s'])."' ORDER BY id DESC LIMIT 1 ";
	$res = mysql_db_query(DB, $sql );
	$user_id = mysql_fetch_array($res);
	
	
	$sql = "SELECT unk,sendMailActive FROM net_users_belong WHERE net_user_id='".$user_id['id']."' AND status=0";
	$res2 = mysql_db_query(DB, $sql );
	
	while( $removeRows = mysql_fetch_array($res2) )
	{
		$sql = "UPDATE net_users_belong SET sendMailActive=0 WHERE net_user_id='".$user_id['id']."' AND unk='".$removeRows['unk']."' LIMIT 1";
		$res3 = mysql_db_query(DB, $sql );
	}
			
	foreach( $_POST['remove_site'] as $key => $val )
	{
		$sql = "UPDATE net_users_belong SET sendMailActive=1 WHERE net_user_id='".$user_id['id']."' AND unk='".$val."' LIMIT 1";
		$res = mysql_db_query(DB, $sql );
	}
	
	echo "<p>&nbsp;</p>ההסרה מרשימת התפוצה בוצעה בהצלחה,<br><br>
גלישה נעימה - צוות אתר...";
}

function net_mail_removeChossen()
{
	
	if( strlen($_GET['s'])  == "32" )
	{
		$sql = "SELECT id,unick_ses,reg_unk FROM net_users WHERE unick_ses = '".mysql_r_e_s($_GET['s'])."' ORDER BY id DESC LIMIT 1 ";
		$res = mysql_db_query(DB, $sql );
		$user_id = mysql_fetch_array($res);
		
		
		if( $user_id['unick_ses'] == $_GET['s'] )
		{
			$sql = "SELECT unk,sendMailActive FROM net_users_belong WHERE net_user_id='".$user_id['id']."' AND status=0";
			$res = mysql_db_query(DB, $sql );
			
			echo "<form action='index.php' method='post' name='checkRemoMai'>";
			echo "<input type='hidden' name='m' value='net_mail_remove'>";
			echo "<input type='hidden' name='s' value='".mysql_r_e_s($_GET['s'])."'>";
			echo "<p>&nbsp;</p>
			<p>אנא בחר את מועדוני החברים שאותם תרצה להסיר את האימייל שלך מרשימת התפוצה שלהם:
			<br><br>";
			
			while( $removeRows = mysql_fetch_array($res) )
			{
				$sql = "SELECT name FROM users WHERE unk = '".$removeRows['unk']."' ";
				$res2 = mysql_db_query(DB, $sql );
				$comp = mysql_fetch_array($res2);
				
				$checked = ( $removeRows['sendMailActive'] == 1 ) ? "checked" : "";
				if( $checked == "" )
				$theUnk_checked = ( $removeRows['unk'] == $_GET['tu'] ) ? "checked" : "";
				echo "<input type='checkbox' name='remove_site[]' value='".$removeRows['unk']."' ".$checked." ".$theUnk_checked.">&nbsp;&nbsp;".stripslashes($comp['name'])."<br>";
			}
				
				echo "<br><input type='submit' value='שלח בקשה' class='submit_style'>";
			echo "</p>";
			echo "</form>";
			
		}
		else
			echo "(פעולה נכשלה (2<br>יש ללחוץ שוב על קישור ההסרה";
	}
	else
		echo "(פעולה נכשלה (1<br>יש ללחוץ שוב על קישור ההסרה";
	
	
}


function register_net_form_thx()
{
	//setcookie("net_user_s" , "123" , time()+60*60*24*30*12 );
	echo "<p>&nbsp;</p>	תודה שנרשמת למועדון חברים...<br>פרטי ההתחברות נשלחו לתיבת הדואר שלך, רק לאחר אישור ההודעה תוכל להתחבר למערכת מועדון החברים כאן באתר<br>";
	
	echo net_user_cookie("view");
}

function net_messages_list()
{
	echo "<iframe src ='http://www.ilbiz.co.il/newsite/net_system/user_massges_page.php?unk=".UNK."&archive=".$_GET['arc']."' width='100%' height='100%' style='height:100vh;' frameborder=0 scrolling=auto allowtransparency='true' name='net_messages_list' id='net_messages_list'></iframe>";
}

function NetProfile()
{
	echo "<iframe src ='http://www.ilbiz.co.il/newsite/net_system/user_profile_page.php?unk=".UNK."' width='100%' height='100%' style='height:100vh;' frameborder=0  scrolling=auto allowtransparency='true'></iframe>";
}

function net_user_cookie($do="view" , $unick_ses="")
{
	
	$request = "http://www.ilbiz.co.il/newsite/net_system/save_ses.php?s=".$unick_ses."&do=".$do;
	
	echo "<iframe src ='".$request."' width='1' frameborder=0 height=1 scrolling=no ></iframe>";
}

function user_calendar($date, $only_not_today="0" )
{
	global $data_colors,$data_name,$word;
	
	echo "<style type='text/css'>";
	if( $data_name['have_calender_events'] == "1" )
		{
			if( $data_colors['stylesheet'] == "" )
			{
			echo "
.calendar_bg{
	background-color:#ffffff; /*צבע רקע כללי ללוח שנה*/
	border: 0px solid #000000; /*צבע מסגרת border: גודלpx solid צבע*/
	color:#000000; /* צבע הכתב בתוך המסגרת */
}

.calendar_month_bg{
	background-color:#ffffff; /*צבע רקע כללי ללוח שנה*/
	color:#000000; /* צבע הכתב בתוך המסגרת */
}

.calendar_week_days{
	background-color:#E6E6E6; /*צבע רקע לתא של הימים לא כולל יום שבת*/
	color:#000000; /* צבע הכתב לתא של הימים לא כולל יום שבת */
}

.calendar_week_days_shabat{
	background-color:#C8C8C8; /*צבע רקע לתא של הימים רק יום שבת*/
	color:#000000; /* צבע הכתב לתא של הימים רק יום שבת */
}

.calendar_month_days_regular{
	background-color:#ffffff; /*צבע רקע לתא של המספרים של החודש לא כולל לא כולל יום של היום*/
	color:#000000; /* צבע הכתב לתא של המספרים של החודש לא כולל יום של היום */
}
.calendar_month_days_regular_today{
	background-color:#ffffff; /*	צבע רקע לתא של המספרים של החודש של היום/הנבחר	*/
	color:#000000; /* צבע הכתב לתא של המספרים של החודש של היום/הנבחר */
	text-decoration: underline; /* אם יהיה קו תחתון none-לא, underline-כן*/
}

.calendar_month_days_regular_event{
	background-color:#707070; /*צבע רקע לתא של המספרים של החודש לא כולל לא כולל יום של היום*/
	color:#ffffff; /* צבע הכתב לתא של המספרים של החודש לא כולל יום של היום */
	text-decoration: none;
}
.calendar_month_days_regular_event a:link{background-color:#707070;color:#ffffff;text-decoration: none;}
.calendar_month_days_regular_event a:hover{background-color:#707070;color:#ffffff;text-decoration: none;}
.calendar_month_days_regular_event a:active{background-color:#707070;color:#ffffff;text-decoration: none;}
.calendar_month_days_regular_event a:visited{background-color:#707070;color:#ffffff;text-decoration: none;}

.calendar_month_days_regular_today_event {
	background-color:#707070; /*	צבע רקע לתא של המספרים של החודש של היום/הנבחר	*/
	color:#ffffff; /* צבע הכתב לתא של המספרים של החודש של היום/הנבחר */
	text-decoration: underline; /* אם יהיה קו תחתון none-לא, underline-כן*/
}
.calendar_month_days_regular_today_event a:link{background-color:#707070;color:#ffffff;text-decoration: underline;}
.calendar_month_days_regular_today_event a:hover{background-color:#707070;color:#ffffff;text-decoration: underline;}
.calendar_month_days_regular_today_event a:active{background-color:#707070;color:#ffffff;text-decoration: underline;}
.calendar_month_days_regular_today_event a:visited{background-color:#707070;color:#ffffff;text-decoration: underline;}
			";
			}
			else
			{
				echo stripslashes($data_colors['stylesheet']);
			}
		}
	echo "</style>";
	//If no parameter is passed use the current date.
	if($date == null)
	{
		$date = getDate();
		
		$day = $date["mday"];
		$month = $date["mon"];
		$year = $date["year"];
	}
	else
	{
		
		$temp=explode("-" , $date);
		$day = $temp["0"];
		$month = $temp["1"];
		$year = $temp["2"];
		
		if( $month{0} == "0" )
			$month = $month{1};
		
	}
	
	if( strlen($month) == "1" )
		$ziro_mon = "0".$month;
	else
		$ziro_mon = $month;
	
	switch($month)
	{
		case "1" : 				$month_name = $word[LANG]['1_4_calander_mon_1'];			break;
		case "2" : 				$month_name = $word[LANG]['1_4_calander_mon_2'];			break;
		case "3" : 				$month_name = $word[LANG]['1_4_calander_mon_3'];				break;
		case "4" : 				$month_name = $word[LANG]['1_4_calander_mon_4'];			break;
		case "5" : 				$month_name = $word[LANG]['1_4_calander_mon_5'];				break;
		case "6" : 				$month_name = $word[LANG]['1_4_calander_mon_6'];				break;
		case "7" : 				$month_name = $word[LANG]['1_4_calander_mon_7'];				break;
		case "8" : 				$month_name = $word[LANG]['1_4_calander_mon_8'];			break;
		case "9" : 				$month_name = $word[LANG]['1_4_calander_mon_9'];			break;
		case "10" : 			$month_name = $word[LANG]['1_4_calander_mon_10'];		break;
		case "11" : 			$month_name = $word[LANG]['1_4_calander_mon_11'];			break;
		case "12" : 			$month_name = $word[LANG]['1_4_calander_mon_12'];			break;
	}
								
	$this_month = getDate(mktime(0, 0, 0, $month, 1, $year));
	$next_month = getDate(mktime(0, 0, 0, $month + 1, 1, $year));
	
	$previos_month = getDate(mktime(0, 0, 0, $month - 1, 1, $year));
	$link_to_next_mon = $next_month['mday']."-".$next_month['mon']."-".$next_month['year'];
	$link_to_previos_mon = $previos_month['mday']."-".$previos_month['mon']."-".$previos_month['year'];
	
	//Find out when this month starts and ends.         
	$first_week_day = $this_month["wday"];
	$days_in_this_month = round(($next_month[0] - $this_month[0]) / (60 * 60 * 24));
	
	
	$sql = "SELECT event_date,event_name FROM user_calender_events WHERE deleted=0 AND status=0 AND unk='".UNK."' AND event_date LIKE '".$year."-".$ziro_mon."%'";
	$res = mysql_db_query(DB, $sql );
	
	$events_Arr = array();
	
	while( $data_event = mysql_fetch_array($res) )
	{
		$event_temp = explode( " " , $data_event['event_date'] );
		$event_temp2 = explode( "-" , $event_temp[0] );
		$event_day = $event_temp2[2];
		
		$events_Arr[$event_day] = stripslashes($data_event['event_name']);
		
	}
	
	$calendar_html = "<div id=\"user_calendar\"><table style=\"font-size:12px;\" class='calendar_bg' border=\"1\" cellspacing=\"2\" cellpadding=\"1\" bordercolor=\"#".stripslashes($data_colors['calendar_borderColor'])."\">";
	
		$calendar_html .= "<tr>";
			$calendar_html .= "<td colspan=\"7\" align=\"center\">";
				$calendar_html .= "<table style=\"font-size:12px;\" class=\"calendar_month_bg\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\" width=100%>";
					$calendar_html .= "<tr>";
						$calendar_html .= "<td align=right><a href='javascript:ajax_calendar(\"".$link_to_previos_mon."\" )' class='calendar_month_bg'>&laquo;</a></td>";
						$calendar_html .= "<td align=center>".$month_name . " " . $year."</td>";
						$calendar_html .= "<td align=left><a href='javascript:ajax_calendar(\"".$link_to_next_mon."\" )' class='calendar_month_bg'>&raquo;</a></td>";
					$calendar_html .= "</tr>";
				$calendar_html .= "</table>";
			$calendar_html .= "</td>";
		$calendar_html .= "</tr>";
		
		$calendar_html .= "<tr>";
		
		$calendar_html .= "<tr>";
			$calendar_html .= "<td align=\"center\" class=\"calendar_week_days\"><b>".$word[LANG]['1_4_calander_day_0']."</b></td>";
			$calendar_html .= "<td align=\"center\" class=\"calendar_week_days\"><b>".$word[LANG]['1_4_calander_day_1']."</b></td>";
			$calendar_html .= "<td align=\"center\" class=\"calendar_week_days\"><b>".$word[LANG]['1_4_calander_day_2']."</b></td>";
			$calendar_html .= "<td align=\"center\" class=\"calendar_week_days\"><b>".$word[LANG]['1_4_calander_day_3']."</b></td>";
			$calendar_html .= "<td align=\"center\" class=\"calendar_week_days\"><b>".$word[LANG]['1_4_calander_day_4']."</b></td>";
			$calendar_html .= "<td align=\"center\" class=\"calendar_week_days\"><b>".$word[LANG]['1_4_calander_day_5']."</b></td>";
			$calendar_html .= "<td align=\"center\" class=\"calendar_week_days_shabat\"><b>".$word[LANG]['1_4_calander_day_6']."</b></td>";
		$calendar_html .= "</tr>";
		
			//Fill the first week of the month with the appropriate number of blanks.       
			for($week_day = 0; $week_day < $first_week_day; $week_day++)
			{
				$calendar_html .= "<td align=center> </td>";   
			}
			
			$week_day = $first_week_day;
			for($day_counter = 1; $day_counter <= $days_in_this_month; $day_counter++)
			{
			  $week_day %= 7;
			  
			  if($week_day == 0)
			     $calendar_html .= "</tr><tr>";
			  
			  if( strlen($day_counter) == "1" )
					$day_counter_by_zero = "0".$day_counter;
				else
					$day_counter_by_zero = $day_counter;
				
			  
			  if($events_Arr[$day_counter_by_zero] != "" )
			  {
			  	
			  	$regularclass = "calendar_month_days_regular_event";
			  	$todayclass = "calendar_month_days_regular_today_event";
			  	$link_a_s = "<a href='index.php?m=calendar_events&d=".$day_counter."&mon=".$ziro_mon."&y=".$year."' title='".$events_Arr[$day_counter_by_zero]."' alt='".$events_Arr[$day_counter_by_zero]."' >";
			  	$link_a_e = "</a>";
			  	
			  }
			  else
			  {
			  	$regularclass = "calendar_month_days_regular";
			  	$todayclass = "calendar_month_days_regular_today";
			  	$link_a_s = "";
			  	$link_a_e = "";
			  }
			  
			  
			  //Do something different for the current day
			  if($day_counter == date('d') && $ziro_mon == date('m') )
			     $calendar_html .= "<td align=\"center\" class=\"".$todayclass."\">".$link_a_s."<b>" . $day_counter ."</b>".$link_a_e."</td>";
			  else
			     $calendar_html .= "<td align=\"center\" class=\"".$regularclass."\">" . $link_a_s .$day_counter . $link_a_e . " </td>";
			  
			  $week_day++;
			}
		
		$calendar_html .= "</tr>";
	$calendar_html .= "</table></div>";
	
	echo $calendar_html;
}

function calendar_events()
{
	global $data_name, $word, $settings;
	
	
	$build_date = ifint($_GET['y'])."-".ifint($_GET['mon'])."-".ifint($_GET['d']);
	if( $build_date == "0-0-0" )
	{
		$build_date = date('Y')."-".date('m')."-".date('d');
	}
	
	$sql = "SELECT event_date,event_name,content,link_name,link_url FROM user_calender_events WHERE deleted=0 AND status=0 AND unk='".UNK."' AND event_date >= '".$build_date."' ORDER BY event_date LIMIT 7";
	$res = mysql_db_query(DB, $sql );
	
	$sql2 = "SELECT title FROM users_calendar_headline WHERE unk = '".UNK."'";
	$res2 = mysql_db_query(DB,$sql2);
	$data_title = mysql_fetch_array($res2);
	
	
	$couner = 0;
	echo "<table class='maintext' border=\"0\" cellspacing=\"0\" cellpadding=\"4\" bordercolor=\"#E6E6E6\" width=100%>";
		
		$title_calendar = ( $data_title['title'] == "" ) ? $word[LANG]['1_4_calander_title'] : stripslashes($data_title['title']);
			echo "<tr>";
				echo "<td align='".$settings['align']."' valign=bottom><h3>".$title_calendar."</h3></td>";
				if( $data_name['have_rightmenu'] != "0" )
				{
				echo "<td align=left>";
					if( $_GET['y'] != "" && $_GET['mon'] != "" && $_GET['d'] != ""  )
						user_calendar(ifint($_GET['d'])."-".ifint($_GET['mon'])."-".ifint($_GET['y']));
					else
						user_calendar();
				echo "</td>";
				}
			echo "</tr>";
			
		while( $data = mysql_fetch_array($res) )
		{
			$date_time = explode( " " , $data['event_date'] );
			$new_date = explode( "-" , $date_time[0] );
			$new_time = explode( ":" , $date_time[1] );
			
			echo "<tr>";
				echo "<td colspan=2><b>".stripslashes($data['event_name'])."</b></td>";
			echo "</tr>";
			
			echo "<tr>";
				echo "<td colspan=2>
					<table class='maintext' border=\"0\" cellspacing=\"0\" cellpadding=\"4\" bordercolor=\"#E6E6E6\" width=100%>
						<tr>
							<td colspan=2> ".nl2br(stripslashes($data['content']))."</td>
						</tr>";
						
						
						
						echo "<tr>
							<td align='".$settings['align']."'>";
								if( $data['link_url'] != "" && $data['link_name'] )
								{
									if( eregi("http://", $data['link_url'] ) )
										$link_url = stripslashes($data['link_url']);
									else
										$link_url = "http://".stripslashes($data['link_url']);
									
									echo "<a href='".$link_url."' class='maintext' target='_blank'>".stripslashes($data['link_name'])."</a>";
								}
							echo "</td>
							<td align='".$settings['re_align']."'>
								<table class='maintext' border=\"0\" cellspacing=\"0\" cellpadding=\"0\">";
									echo "<tr>";
										echo "<td align='".$settings['re_align']."'>".$word[LANG]['1_4_calander_date_time']."</td>";
										echo "<td width=10></td>";
										echo "<td align='".$settings['re_align']."'>".$new_date[2]."-".$new_date[1]."-".$new_date[0]."</td>";
										echo "<td width=10></td>";
										echo "<td align='".$settings['re_align']."'>".$new_time[0].":".$new_time[1]."</td>";
									echo "</tr>
								</table>
							</td>
						</tr>
						
					</table>
				</td>";
			echo "</tr>";
			
			echo "<tr><td colspan=2><hr width=100% color=#E6E6E6 size=1></td></tr>";
			
			$couner++;
		}
		
		if( $couner == "0" )
		{
			echo "<tr>";
				echo "<td colspan=2><b>לא נמצאו תוצאות</b></td>";
			echo "</tr>";
		}
	echo "</table>";
}


function castum_frame()
{
	switch( UNK )
	{
		case "375411241406803999" :
			$full_path="http://develop.ilbiz.co.il/homePage__qikong";
		break;
	}
	
	echo "<p>&nbsp;</p><iframe src='".$full_path."/' frameborder=0 height=890 width=600 scrolling=no></iframe>";
}
?>
