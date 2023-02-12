<?php

function user_rightbar_section(){
	?>
		<?php if( $_COOKIE['net_user_s'] == "" || $get_m == 'logOut'): ?>
		<?php 
	global $facebook;
	
	echo "<div class='oldstyle-table'>";
		echo "<div>";
				echo "<table border=\"0\" cellspacing=\"0\" cellpadding=\"0\">";
					echo "<tr>";
						echo "<td width=21><img src='".HTTP_S."://ilbiz.co.il/ClientSite/version_1/style/image/10_icon.jpg' border=0 alt=''></td>";
						echo "<td width=5></td>";
						echo "<td class='headline'><b>התחבר לאיזור האישי</b></td>";
					echo "</tr>";
				echo "</table>";
		echo "</div>";
		
		
		$sql = "SELECT has_ssl FROM users WHERE unk = '".UNK."'";
		$res = mysql_db_query(DB ,$sql );
		$ssl_data = mysql_fetch_array($res);
		$http_s = "http";
		if($ssl_data['has_ssl'] != '0' && $ssl_data['has_ssl'] != ''){
			$http_s = "https";
		}
		echo "<div>";

				echo "<table border=\"0\" cellspacing=\"0\" cellpadding=\"0\" class='maintext' width='100%'>";
					
					//echo "<tr>";
					//	echo "<td colspan=2 style='font-size: 14px;' align=center><b>התחברות בקליק</b></td>";
					//echo "</tr>";
					/*
					echo "<tr><td colspan=2 height=10></td></tr>";
					echo "<tr>";
						//echo "<td align=center colspan=2><a href='http://www.10service.co.il/newsite/index.php?by=google&m=getConnectedByLogin&returnTo=".$_SERVER[REQUEST_URI]."'><img src='http://www.10service.co.il/images/googlelogin.png' border=0 alt=''></a></td>";
						$fb_return_url = urlencode('http://'.$_SERVER[''].$_SERVER[REQUEST_URI]);
						
						 
						echo "<td align=center colspan=2><div id='rightbar_fb_login'><a href='http://www.10service.co.il/newsite/index.php?by=sites_facebook_login&m=getConnectedByLogin&returnToUnk=".UNK."'><img src='".HTTP_S."://ilbiz.co.il/ClientSite/version_1/style/image/facebookLogin.png' border=0 alt=''></a></div></td>";
					echo "</tr>";
					echo "<tr><td colspan=2 height=10></td></tr>";
					echo "<tr>";
						echo "<td colspan=2 style='font-size: 14px;' align=center><b><u>או</u></b></td>";
					echo "</tr>";
					*/
					echo "<tr>";
						echo "<td colspan=2 style='font-size: 14px;' align=center>
							<a href='".$http_s."://".$_SERVER['HTTP_HOST']."/index.php?m=NetLoginForms'>התחבר\הרשם</a>
						</td>";
					echo "</tr>";					
				echo "</table>";

		echo "</div>";
	echo "</div>";	
		?>
		<?php else: ?>
				<?php
				require_once("class.creditMoney.10service.php"); 				
				$hour = date('H');
				if( $hour >= "23" && $hour <= "04" )
				$time_str = "לילה טוב";
				elseif( $hour >= "04" && $hour <= "11" )
				$time_str = "בוקר טוב";
				elseif( $hour >= "12" && $hour <= "15" )
				$time_str = "צהריים טובים";
				elseif( $hour >= "16" && $hour <= "19" )
				$time_str = "אחר הצהריים טובים";
				elseif( $hour >= "20" && $hour <= "22" )
				$time_str = "ערב טוב";

				$creditMoney = new creditMoney;
				$user_id = $creditMoney->getUserIdForm_cookie();
				$get_creditMoney = $creditMoney->get_creditMoney( 'net_users' , $user_id );
				?>
				<div class='user-info'>
					<div class='user-image'>
						<?php echo $creditMoney->getUserImage();?>
					</div>
					<div class='user-name'>
						<b>
							<?php echo $time_str; ?>, <?php echo $creditMoney->getUserFullName(); ?>
						</b>
					</div>
					<div class='user-credits'>
					<?php /*
						<a href='index.php?m=user_cpanel' class='maintext credit-link'>
							קרדיטים: <?php echo $get_creditMoney; ?>
						</a> 
						<img src='http://10service.co.il/images/credit_icon.png' alt='' border=0>
						<br/>
					*/ ?>
						<a href='index.php?m=user_cpanel' class='maintext'>
							<span class="smaller">לחץ כאן לצפייה בפרופיל האישי</span>
						</a> 						
						
					</div>
					<div class='net-user-logout'>
					<?php 
						$sql = "SELECT has_ssl FROM users WHERE unk = '".UNK."'";
						$res = mysql_db_query(DB ,$sql );
						$ssl_data = mysql_fetch_array($res);
						$http_s = "http";
						if($ssl_data['has_ssl'] == '1'){
							$http_s = "https";
						}
						$url = $http_s."://".$_SERVER['HTTP_HOST']."/index.php?m=logOut";
					?>
						<a href='<?php echo $url; ?>'>
							התנתק
						</a> 
					</div>
				</div>		
		
		<?php endif; ?>	
	<?php
}

function register_new_user()
{
	echo "<table border=\"0\" cellspacing=\"0\" cellpadding=\"0\" align=center>";
		echo "<tr>";
			echo "<td><img src='".HTTP_S."://www.10service.co.il/images/main_kobia_205_top.png' alt='' border='0'></td>";
		echo "</tr>";
		echo "<tr>";
			echo "<td style='background-image:url(".HTTP_S."://www.10service.co.il/images/main_kobia_205_dupli.png); background-repeat:repeat-y;'>";
				echo register_to_10service();
			echo "</td>";
		echo "</tr>";
		echo "<tr>";
			echo "<td><img src='".HTTP_S."://www.10service.co.il/images/main_kobia_205_bottom.png' alt='' border='0'></td>";
		echo "</tr>";
	echo "</table>";
}


function register_to_10service($goto="" , $load_facebook_config='1')
{
	global $facebook;
	
	echo "<form action='index.php' name='RegPageForm' method='POST' style='padding:0; margin:0;' onsubmit='return checkReg_10service()'>";
	echo "<input type='hidden' name='m' value='register_to_10service_DB'>";
	echo "<input type='hidden' name='goto' value='".$goto."'>";
	echo "<div class='oldstyle-table'><table border=\"0\" cellspacing=\"0\" cellpadding=\"0\" class=\"maintext\" dir=\"rtl\" align=\"right\" width='100%' style='padding-right:7px; padding-left:7px;'>";

				echo "<table border=\"0\" cellspacing=\"0\" cellpadding=\"0\">";
					echo "<tr>";
						echo "<td width=21><img src='".HTTP_S."://ilbiz.co.il/ClientSite/version_1/style/image/10_icon.jpg' border=0 alt=''></td>";
						echo "<td width=5></td>";
						echo "<td class='headline'><b>הירשם בחינם</b></td>";
					echo "</tr>";
				echo "</table>";

		

		echo "<div class='form-group'>";
			echo "<div>* שם פרטי</div>";
			
			echo "<div><input type='text' name='data_arr[fname]' id='data_arr[fname]' class='input_style'  ></div>";
		echo "</div>";
		
		echo "<div class='form-group'>";
			echo "<div>* שם משפחה</div>";
			
			echo "<div><input type='text' name='data_arr[lname]' id='data_arr[lname]' class='input_style'  ></div>";
		echo "</div>";
		
		echo "<div class='form-group'>";
			echo "<div>* אימייל</div>";
			
			echo "<div><input type='text' name='data_arr[email]' id='data_arr[email]'class='input_style'  dir='ltr'></div>";
		echo "</div>";
		
		echo "<div class='form-group'>";
			echo "<div>* סיסמה</div>";
			
			echo "<div><input type='password' name='data_arr[password]' id='data_arr[password]'  class='input_style' dir='ltr'></div>";
		echo "</div>";
		
		
		echo "<div class='form-terms'><input type='checkbox' name='terms' id='terms' value='1' checked> אני מסכים/ה <a href='http://www.ilbiz.co.il/newsite/net_system/terms.php' class='maintext' target=_blank>לתנאי השימוש</a> באתר.</div>";
		
		

			
			
		echo "<div class='form-submit'><input type='submit' value='הירשם' class='submit_style'></div>";
		
		
	echo "</div>";
	echo "</form>";
	?>
	<script type="text/javascript">
		function checkReg_10service()
		{
			<?
			$mandatory_fields = array( "data_arr[fname]" , "data_arr[lname]" , "data_arr[email]" , "data_arr[password]" , "terms" );
			for($z=0 ; $z<sizeof($mandatory_fields) ; $z++)
				{
					$val = $mandatory_fields[$z];
					
					if( $val == "terms" )
					{
						echo "
						temp_val = document.getElementById(\"{$val}\");
						if(temp_val.checked != 1)	
						{
							alert(\"עליך לאשר תנאי שימוש\");
							temp_val.focus();   
							return false;\n
						}
						";
					}
					else
					{
						//main_form
						echo "
						temp_val = document.getElementById(\"{$val}\");
						if(temp_val.value == \"\")	
						{
							alert(\"יש להזין תוכן לשדות החובה\");
							temp_val.focus();   
							return false;\n
						}
						";
					}
				}
		?>
		}	
	</script>
	<?php
	//echo "<div class='form-switch go-to-login'>";
	//	echo "<div><a href='javascript://' onclick='rightbar_register_to_login()' class='maintext'>כבר רשום? לחץ כאן לכניסה.</a></div>";
	//echo "</div>";	
}


function register_to_10service_DB()
{
	$data_arr = $_POST['data_arr'];
	
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
	$data_arr['reg_unk'] = UNK;
//setcookie( "net_user_s" , $sesid , time()+60*60*24*30*12 , "/" , "10service.co.il" );
	setcookie( "net_user_s" , $data_arr['unick_ses'] , time()+60*60*24*30*12  , "/" , $_SERVER['HTTP_HOST']);
	
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
	$sql = "UPDATE net_users SET date_in = NOW() WHERE id = ".$new_user_id;
	$res = mysql_db_query( DB, $sql );	
	
	$sql = "INSERT INTO net_users_verify_mails ( net_user_id, goto_domain ) VALUES ( '".$new_user_id."' , 'http://".$_SERVER['HTTP_HOST']."' )";
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
	
	$site_domain = explode( "http://" , $goto_url );
	
	$content = "
	שלום ".$data_arr['fname']." ".$data_arr['lname'].",<br>
	<br>
	את/ה קרוב/ה לחיצה אחת מסיום ההרשמה למועדון לקוחות של <a href='http://".$_SERVER['HTTP_HOST']."' class='text_link' target='_blank'>".stripslashes($user_details['name'])."</a><br>
	על מנת לסיים את שלבי ההרשמה יש ללחוץ <a href='http://www.ilbiz.co.il/newsite/net_system/verify_email.php?s=".$data_arr['unick_ses']."' class='text_link' target='_blank'>כאן</a><br>
	<br>
	בברכה,<br>
	".stripslashes($user_details['name'])."<br>
		".$_SERVER['HTTP_HOST']."
	";
				
				$header_send_to_Client= "הצטרפות למועדון לקוחות";
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
	
	$goto = ( $_POST['goto'] == "" ) ? "" : $_POST['goto'];
	echo "<div style='font-size:17px; color:green;'>הרשמתך בוצעה בהצלחה</div><script>window.location.href='index.php?m=NetMess'</script>";
		
}


function getConnectedByLogin()
{
	
	
	$by = ( $_GET['by'] ) ? $_GET['by'] : $_POST['by'];
	
	switch( $by )
	{
		
		case "il" :
			
			$curlSend = curl_init(); 
			
			curl_setopt($curlSend, CURLOPT_URL, "http://www.ilbiz.co.il/newsite/net_system/loginByPost10service.php"); 
			curl_setopt($curlSend, CURLOPT_RETURNTRANSFER, 1); 
			
			curl_setopt($curlSend, CURLOPT_POST, true );
			curl_setopt($curlSend, CURLOPT_POSTFIELDS, "action=enter&unk=".UNK."&email=".$_POST['NetEmail']."&passw=".encode5t_passw($_POST['NetPass'])."" );
			
			
			$curlResult = curl_exec ($curlSend); 
			curl_close ($curlSend);
			
			if( eregi("ERROR" , $curlResult) )
			{
				$temp = explode("ERROR: " , $curlResult );
				
				echo "<script>alert('".$temp[1]."')</script>";
			}
			else
			{
				if( $_POST['remmberMe'] == "1" )
					setcookie( "net_user_s" , $curlResult , time()+60*60*24*30*12  , "/" , $_SERVER['HTTP_HOST']);
				else
					setcookie( "net_user_s" , $curlResult );
			}
			
			//echo "<script>window.location.href='".$_SERVER['HTTP_REFERER']."';</script>";
			echo "<script>window.location.href='index.php?m=user_cpanel';</script>";
				exit;
		break;
		

	}
	
	
}

function encode5t_passw($str)
{
  for($i=0; $i<5;$i++)
  {
    $str=strrev(base64_encode($str)); //apply base64 first and then reverse the string
  }
  return $str;
}


function NetLoginForms($with_register="1")
{
	?>
		<?php if( $_COOKIE['net_user_s'] == "" || $get_m == 'logOut'): ?>
			<div id='centerbar_register_forms' class='register-forms' class='span12 row-fluid'>
				<div id="centerbar_login"  class='span6' style='padding:10px; border:1px solid blue; margin-bottom:50px;'>
					<?php echo user_10service_login('0'); ?>		
				</div>
				<div id="centerbar_register" class='span6' style='padding:10px; border:1px solid blue; margin-bottom:50px;'>	
					<?php echo register_to_10service( "" , '0' ); ?>
				</div>		
				
			</div>
		<?php endif; ?>
	<?php
}

function user_10service_login($with_register="1")
{
	
	global $facebook;
	
	echo "<div class='oldstyle-table'>";
		echo "<div>";
				echo "<table border=\"0\" cellspacing=\"0\" cellpadding=\"0\">";
					echo "<tr>";
						echo "<td width=21><img src='".HTTP_S."://ilbiz.co.il/ClientSite/version_1/style/image/10_icon.jpg' border=0 alt=''></td>";
						echo "<td width=5></td>";
						echo "<td class='headline'><b>התחבר לאיזור האישי</b></td>";
					echo "</tr>";
				echo "</table>";
		echo "</div>";
		/*
		echo "<div>";

				echo "<table border=\"0\" cellspacing=\"0\" cellpadding=\"0\" class='maintext' width='100%'>";
					
					//echo "<tr>";
					//	echo "<td colspan=2 style='font-size: 14px;' align=center><b>התחברות בקליק</b></td>";
					//echo "</tr>";
					echo "<tr><td colspan=2 height=10></td></tr>";
					echo "<tr>";
						//echo "<td align=center colspan=2><a href='http://www.10service.co.il/newsite/index.php?by=google&m=getConnectedByLogin&returnTo=".$_SERVER[REQUEST_URI]."'><img src='http://www.10service.co.il/images/googlelogin.png' border=0 alt=''></a></td>";
						$fb_return_url = urlencode('http://'.$_SERVER[''].$_SERVER[REQUEST_URI]);
						
						 
						echo "<td align=center colspan=2><div id='rightbar_fb_login'><a href='http://www.10service.co.il/newsite/index.php?by=sites_facebook_login&m=getConnectedByLogin&returnToUnk=".UNK."'><img src='".HTTP_S."://ilbiz.co.il/ClientSite/version_1/style/image/facebookLogin.png' border=0 alt=''></a></div></td>";
					echo "</tr>";
					echo "<tr><td colspan=2 height=10></td></tr>";
					echo "<tr>";
						echo "<td colspan=2 style='font-size: 14px;' align=center><b><u>או</u></b></td>";
					echo "</tr>";
					
				echo "</table>";

		echo "</div>";
		*/ 

		echo "<div class='err_msg'><b style='color: red; font-size: 11px;'>".$error_msg."</b></div>";
		
		
		echo "<form action='index.php' method='post' name='net_login' onsubmit='return checkLogin_10service()'>";
		echo "<input type='hidden' name='m' value='getConnectedByLogin'>";
		echo "<input type='hidden' name='by' value='il'>";
		echo "<div>";
			echo "<div class='form-group'>";
				echo "<div>אימייל</div>";
				
				echo "<div><input type='text' name='NetEmail' class='input_style'  dir='ltr'></div>";
			echo "</div>";
			
			echo "<div class='form-group'>";
				echo "<div>סיסמה</div>";
				
				echo "<div><input type='password' name='NetPass' class='input_style'  dir='ltr'></div>";
			echo "</div>";
			
			echo "<div class='form-group'>";
				echo "<div><label><input type='checkbox' name='remmberMe' value='1' checked> זכור אותי במחשב הזה </label></div>";
			echo "</div>";
			
			
			echo "<div class='form-group'>";
				
				
				echo "<div class='form-submit'><input type='submit' value='התחבר' class='submit_style' style='width: 60px;'></div>";
			echo "</div>";
			//echo "<div class='go-to-register form-switch'><a href='javascript://' onclick='rightbar_login_to_register()' class='maintext'>הרשם עכשיו</a></div>";

		echo "</div>";	
		echo "</form>";
		



		
		
		echo "<div class='forgot-pass'><a href='index.php?m=NetPass' class='maintext'>שכחתי סיסמה</a></div>";
		
		
					
	echo "</div>";
	
}


function logOut()
{
	$sessid = session_id();
	setcookie( "net_user_s" , $sessid , time() - 3600  , "/" , $_SERVER['HTTP_HOST']);
	$http_s = "http";
	if(defined("HTTP_S")){
		$http_s = HTTP_S;
	}
	$url = $http_s."://".$_SERVER['HTTP_HOST']."/index.php?m=NetLoginForms";
	echo "<script>window.location.href='".$url."';</script>";
		exit;
	//echo "<div id='net_user_logout_msg' style='font-size:17px; color:green;'>יצאת מהמערכת.</div>";
}


function user_cpanel()
{
	if(isset($_GET['fbloginOk'])){
		if($_GET['fbloginOk'] == '1'){
		
			$sql = "SELECT * FROM fb_login_hack WHERE temp_sess = '".$_GET['hsess']."' AND user_ip = '".$_SERVER[REMOTE_ADDR]."'";
			$resUser = mysql_db_query(DB,$sql);
			$dataUser = mysql_fetch_array($resUser);
			if($dataUser['unick_ses'] == ""){
				
				echo "<div class='login_error' color='red'>אנא נסה להתחבר דרך פייסבוק שוב פעם</div>";
				c_panel_credit_log();
				return;				
			}
			else{
				$sql = "DELETE FROM fb_login_hack WHERE temp_sess = '".$_GET['hsess']."'";
				$resUser = mysql_db_query(DB,$sql);				
				setcookie( "net_user_s" , $dataUser['unick_ses'] , time()+60*60*24*30*12 , "/" ,  $_SERVER['HTTP_HOST'] );
				echo "<script>window.location.href='/index.php?m=NetMess';</script>";
				return;
			}
		}
		else{
			echo "<div class='login_error' color='red'>אנא נסה להתחבר דרך פייסבוק שוב פעם</div>";
			c_panel_credit_log();
			
			
			
			return;
		}
	}
	elseif(isset($_GET['tab'])){
		if($_GET['tab'] == "afterSend"){
			c_panel_credit_log();
			return;
		}
	}
	
	require_once("class.creditMoney.10service.php"); 
	$creditMoney = new creditMoney;
	
	$UserID = $creditMoney->getUserIdForm_cookie();
	
	$creditMoneyUser = $creditMoney->get_creditMoney( "net_users" , $UserID );
	
	if( $UserID == "" )
		header('location:index.php');
	
	
	$sql = "SELECT fname,lname,city,birthday,gender,email,mobile FROM net_users WHERE id = '".$UserID."' ";
	$resUser = mysql_db_query(DB,$sql);
	$dataUser = mysql_fetch_array($resUser);
	
	$sql = "select id,name from cities order by name";
	$res_city = mysql_db_query(DB,$sql);
	$get_tab = $_GET['tab'];
	$get_m = $_GET['m'];
	if(isset($_SESSION['user_cpanel_tab'])){
		$get_tab = $_SESSION['user_cpanel_tab'];
		$get_m = 'user_cpanel';
		unset($_SESSION['user_cpanel_tab']);
		
	}
	echo "<table border=0 cellpadding=0 cellspacing=0 class='maintext' width=100%>";
		
		echo "<tr>";
			echo "<td>";
				echo "<table border=\"0\" cellspacing=\"0\" cellpadding=\"0\" class=\"maintext\">";
					echo "<tr>";
						
						$index_se = ( $get_tab == "" && $get_m == "user_cpanel") ? "#80a0ba" : "#f8f8f8";
						$index_fff = ( $get_tab == ""  && $get_m == "user_cpanel") ? "color: #ffffff;" : "";
						
						$href_index = ( $_GET['cat'] != "" || $_GET['sub'] != "" ) ? "index.php?m=text&t=".$_GET['t']."" : "javascript:void(0)";
						
						echo "<td id='index_td' style='background-color:".$index_se.";' width='92' height=35 align=center><a href='javascript:void(0)' onclick='user_cpanel_changer_tabs(\"index\")' class='maintext' style=' text-decoration:none;'><b style='font-size: 15px; ".$index_fff."' id='index_td_link'>ראשי</b></a></td>";
						echo "<td width=5></td>";
						
						$updateD_se = ( $get_tab == "updateD" ) ? "#80a0ba" : "#f8f8f8";
						$updateD_fff = ( $get_tab == "updateD" ) ? "color: #ffffff;" : "";
						
						echo "<td id='updateD_td' style='background-color:".$updateD_se.";' width='92' height=35 align=center><a href='javascript:void(0)' onclick='user_cpanel_changer_tabs(\"updateD\")' class='maintext' style=' text-decoration:none;'><b style='font-size: 15px; ".$updateD_fff."' id='updateD_td_link'>עדכון פרטים</b></a></td>";
						echo "<td width=5></td>";
						
						/*$updateI_s_se = ( $get_tab == "updateI" ) ? "#80a0ba" : "#f8f8f8";
						$updateI_s_fff = ( $get_tab == "updateI" ) ? "color: #ffffff;" : "";
						
						echo "<td id='updateI_td' style='background-image:url(\"/images/half_price_kobia_link".$updateI_se.".png\"); background-repeat: no-repeat;' width='92' height=35 align=center><a href='javascript:void(0)' onclick='user_cpanel_changer_tabs(\"updateI\")' class='maintext' style=' text-decoration:none;'><b style='font-size: 15px; ".$updateI_fff."' id='updateI_td_link'>עדכון תמונה</b></a></td>";
						echo "<td width=5></td>";*/
						$mailing_se = ( $get_m == "NetMess" ) ? "#80a0ba" : "#f8f8f8";
						$mailing_fff = ( $get_m == "NetMess" ) ? "color: #ffffff;" : "";						
						echo "<td id='mailing_td' style='background-color:".$mailing_se.";' width='92' height=35 align=center><a href='javascript:void(0)' onclick='user_cpanel_changer_tabs(\"mailing\")' class='maintext' style=' text-decoration:none;'><b style='font-size: 15px; ".$mailing_fff."' id='mailing_td_link'>הודעות</b></a></td>";
						echo "<td width=5></td>";
						$creditLog_se = ( $get_tab == "creditLog" ) ? "#80a0ba" : "#f8f8f8";
						$creditLog_fff = ( $get_tab == "creditLog" ) ? "color: #ffffff;" : "";
						echo "<td id='creditLog_td' style='background-color:".$creditLog_se.";' width='95' height=35 align=center><a href='javascript:void(0)' onclick='user_cpanel_changer_tabs(\"creditLog\")' class='maintext' style=' text-decoration:none;'><b style='font-size: 15px; ".$creditLog_fff."' id='creditLog_td_link'>פניות אחרונות</b></a></td>";
						echo "<td width=5></td>";
					echo "</tr>";
				echo "</table>";
			echo "</td>";
		echo "</tr>";
		
		
		echo "<tr>";
			echo "<td style='border: 1px solid #eeeeee; padding: 10px; padding-top: 30px;' height='400' valign=top>";
			
				// I N D E X
				$index_tab = ( $get_tab == ""  && $get_m == "user_cpanel") ? "" : " style='display: none;'";
				echo "<div id='index' ".$index_tab.">";
					echo "<table border=0 cellpadding=0 cellspacing=0 class='maintext'>";
						echo "<tr>";
							echo "<td valign=top>";
								echo "<table border=0 cellpadding=0 cellspacing=0 class='maintext'>";
									echo "<tr>";
										echo "<td align=center>".$creditMoney->getUserFullName()."</td>";
									echo "</tr>";
									echo "<tr><td height=5></td></tr>";
									echo "<tr>";
										echo "<td align=center>".$creditMoney->getUserImage("200")."</td>";
									echo "</tr>";
								echo "</table>";
							echo "</td>";
							echo "<td width=40></td>";
							echo "<td valign=top>";
								echo "<table border=0 cellpadding=0 cellspacing=0 class='maintext'>";
									/*
									echo "<tr>";
										echo "<td><img src='http://www.10service.co.il/images/credit_icon_large.png' alt='' border=0></td>";
										echo "<td width=20></td>";
										echo "<td style='font-size: 15px;'>מספר הקרדיטים שצברתי: ".$creditMoneyUser."</td>";
										echo "<td width=20></td>";
										echo "<td style='font-size: 15px;'><a href='javascript:user_cpanel_changer_tabs(\"creditLog\")' class='maintext' style='font-size: 15px;'><u>צבור קרדיטים נוספים</u></a></td>";
									echo "</tr>";
								*/
									echo "<tr><td colspan=5 height=20></td></tr>";
									echo "<tr>";
										echo "<td><img src='".HTTP_S."://www.10service.co.il/images/goto_half_price.png' alt='' border=0></td>";
										echo "<td width=20></td>";
										//echo "<td style='font-size: 15px;' colspan=3>צא לקניות: &nbsp;&nbsp;<a href='index.php?m=pr' class='maintext' style='font-size: 15px;'><u>דילים חצי מחיר</u></a> &nbsp;&nbsp;|&nbsp;&nbsp; <a href='index.php?m=deal_coupon' class='maintext' style='font-size: 15px;'><u>דיל קופון</u></a></td>";
										echo "<td style='font-size: 15px;' colspan=3>צא לקניות: &nbsp;&nbsp;<a href='http://www.10service.co.il/index.php?m=pr' class='maintext' style='font-size: 15px;'><u>דילים שווים</u></td>";
									echo "</tr>";
								echo "</table>";
							echo "</td>";
							echo "<td width=40></td>";
							echo "<td valign=top>";
							
							echo "</td>";
						echo "</tr>";
					echo "</table>";
				echo "</div>";
				
				$dispay_updateD = ( $get_tab == "updateD" ) ? "" : " style='display: none;'";
				echo "<div id='updateD' ".$dispay_updateD.">";
											echo "<table border=0 cellpadding=0 cellspacing=0 class='maintext' width=100%>";
												echo "<tr>";
													echo "<td valign=top align=center>";
echo "<form action='index.php' method='post' name='updateD_form' style='padding: 0px; margin: 0px;' onsubmit='return check_update_user_cpanel()'>";
echo "<input type='hidden' name='m' value='user_cpanel__updateD'>";
echo "<table border=0 cellpadding=0 cellspacing=0 class='maintext user-form'>";
	echo "<tr><td>";
		echo "<div class='form-group right-form-group'>";	
			echo "<div class='form-item-label'>שם פרטי</div>";						
			echo "<div class='form-item-input'><input type='text' name='fname' value='".stripslashes($dataUser['fname'])."' class='input_style'></div>";
		echo "</div>";
		echo "<div class='form-group left-form-group'>";	
			echo "<div class='form-item-label'>שם משפחה</div>";						
			echo "<div class='form-item-input'><input type='text' name='lname' value='".stripslashes($dataUser['lname'])."' class='input_style'></div>";
		echo "</div>";
	echo "</td></tr>";
	
	echo "<tr><td height=20></td></tr>";
	
	echo "<tr><td>";
		echo "<div class='form-group right-form-group'>";
			echo "<div class='form-item-label'>תאריך לידה</div>";
			
			echo "<div class='form-item-input'>";
				echo "<table border=0 cellpadding=0 cellspacing=0 class='maintext'>";
					echo "<tr>";
						echo "<td>";
							$temp_birth = explode( "-" , $dataUser['birthday'] );
							echo "<select name='birth_year' class='input_style' style='width: 60px;'>";
								for( $i=date('Y') ; $i>=1940 ; $i-- )
								{
									$selected_y = ( $i == $temp_birth[0] ) ? "selected" : "";
									echo "<option value='".$i."' ".$selected_y.">".$i."</option>";
								}
							echo "</select>";
						echo "</td>";
						echo "<td style='padding-right: 5px; padding-left: 5px;'>/</td>";
						echo "<td>";
							$temp_birth = explode( "-" , $dataUser['birthday'] );
							echo "<select name='birth_mon' class='input_style' style='width: 50px;'>";
								for( $i=1 ; $i<=12 ; $i++ )
								{
									$selected_m = ( $i == $temp_birth[1] ) ? "selected" : "";
									echo "<option value='".$i."' ".$selected_m.">".$i."</option>";
								}
							echo "</select>";
						echo "</td>";
						echo "<td style='padding-right: 5px; padding-left: 5px;'>/</td>";
						echo "<td>";
							$temp_birth = explode( "-" , $dataUser['birthday'] );
							echo "<select name='birth_day' class='input_style' style='width: 50px;'>";
								for( $i=1 ; $i<=31 ; $i++ )
								{
									$selected_d = ( $i == $temp_birth[2] ) ? "selected" : "";
									echo "<option value='".$i."' ".$selected_d.">".$i."</option>";
								}
							echo "</select>";
						echo "</td>";
					echo "</tr>";
				echo "</table>";
			echo "</div>";
			
		echo "</div>";
		echo "<div class='form-group left-form-group'>";						
			
			echo "<div class='form-item-label'>עיר</div>";
			
			echo "<div class='form-item-input'>";
					echo "<select name='city' class='input_style'>";
						echo "<option value=''>בחירה</option>";
						while($data_city = mysql_fetch_array($res_city))
						{
							$selected = ( $dataUser['city'] == $data_city['id'] ) ? "selected" : "";
							echo "<option value='".$data_city['id']."' ".$selected.">".stripslashes($data_city['name'])."</option>";
						}
					echo "</select>";
			echo "</div>";
		echo "</div>";						
	echo "</td></tr>";
	
	echo "<tr><td height=20></td></tr>";
	
	echo "<tr><td>";
		echo "<div class='form-group right-form-group'>";				
			echo "<div class='form-item-label'>מספר טלפון נייד</div>";
			
			echo "<div class='form-item-input'><input type='text' name='mobile' value='".stripslashes($dataUser['mobile'])."' class='input_style'></div>";
			
		echo "</div>";
		echo "<div class='form-group left-form-group'>";						
			
			echo "<div class='form-item-label'>מין</div>";
			
			echo "<div class='form-item-input'>";
				$selected1 = ( $dataUser['gender'] == "1" ) ? "selected" : "";
				$selected2 = ( $dataUser['gender'] == "2" ) ? "selected" : "";
				echo "<select name='gender' class='input_style'>";
					echo "<option value=''>בחירה</option>";
					echo "<option value='1' ".$selected1.">זכר</option>";
					echo "<option value='2' ".$selected2.">נקבה</option>";
				echo "</select>";
			echo "</div>";
		echo "</div>";
	echo "</td></tr>";
	
	echo "<tr><td height=20></td></tr>";
	
	echo "<tr><td>";
		echo "<div class='form-group right-form-group'>";				
			echo "<div class='form-item-label'>סיסמה חדשה</div>";
			
			echo "<div class='form-item-input'><input type='password' name='newPass' value='' class='input_style'></div>";
			
		echo "</div>";
		echo "<div class='form-group left-form-group'>";						
			
			echo "<div class='form-item-label'>אימות סיסמה חדשה</div>";
			
			echo "<div class='form-item-input'><input type='password' name='newPass2' value='' class='input_style'></div>";
		echo "</div>";				
	echo "</td></tr>";
	
	echo "<tr><td height=20></td></tr>";
	
	echo "<tr><td>";

		echo "<div class='form-group full-form-group'>";				
			echo "<input type='submit' value='שמירה' class='submit_style'>";
		echo "</div>";						
	echo "</td></tr>";
	
echo "</table>";
echo "</form>";
													echo "</td>";
												echo "</tr>";
											echo "</table>";
				echo "</div>";	
				$dispay_mailing = ( $get_m == "NetMess" ) ? "" : " style='display: none;'";				
				echo "<div id='mailing' ".$dispay_mailing.">";	
					echo "<iframe src ='".HTTP_S."://www.ilbiz.co.il/newsite/net_system/user_massges_page.php?unk=".UNK."&net_user_s=".$_COOKIE['net_user_s']."&minimize=1&archive=".$_GET['arc']."' width='100%' height='100%' style='height:100vh;' frameborder='0' name='net_messages_list' id='net_messages_list'></iframe>";
				echo "</div>";
				
				$dispay_creditLog = ( $get_tab == "creditLog" ) ? "" : " style='display: none;'";	
				echo "<div id='creditLog' ".$dispay_creditLog.">";
					c_panel_credit_log();
					if(!$found_sent_forms){
						echo "<div class='no-sent-forms'><b>עוד לא שלחת בקשות להצעת מחיר.</b></div>";
					}

				echo "</div>";
				
			echo "</td>";
		echo "</tr>";
		
	echo "</table>";
	?>
	<script type="text/javascript">
		function user_cpanel_changer_tabs(tab)
		{
			if( tab == "index" )
			{
				document.getElementById('index_td').style.backgroundColor =  "#80a0ba";
				document.getElementById('index_td_link').style.color = "#ffffff";
				document.getElementById('index').style.display="";
				
				document.getElementById('updateD_td').style.backgroundColor =  "#f8f8f8";
				document.getElementById('updateD_td_link').style.color = "";
				document.getElementById('updateD').style.display="none";
				
				document.getElementById('creditLog_td').style.backgroundColor =  "#f8f8f8";
				document.getElementById('creditLog_td_link').style.color = "";
				document.getElementById('creditLog').style.display="none";
				
				document.getElementById('mailing_td').style.backgroundColor =  "#f8f8f8";
				document.getElementById('mailing_td_link').style.color = "";
				document.getElementById('mailing').style.display="none";			
			}
			
			if( tab == "updateD" )
			{
				document.getElementById('updateD_td').style.backgroundColor =  "#80a0ba";
				document.getElementById('updateD_td_link').style.color = "#ffffff";
				document.getElementById('updateD').style.display="";
				
				document.getElementById('index_td').style.backgroundColor =  "#f8f8f8";
				document.getElementById('index_td_link').style.color = "";
				document.getElementById('index').style.display="none";
				
				document.getElementById('creditLog_td').style.backgroundColor =  "#f8f8f8";
				document.getElementById('creditLog_td_link').style.color = "";
				document.getElementById('creditLog').style.display="none";

				
				document.getElementById('mailing_td').style.backgroundColor =  "#f8f8f8";
				document.getElementById('mailing_td_link').style.color = "";
				document.getElementById('mailing').style.display="none";			
			}
			
			if( tab == "creditLog" )
			{
				document.getElementById('creditLog_td').style.backgroundColor =  "#80a0ba";
				document.getElementById('creditLog_td_link').style.color = "#ffffff";
				document.getElementById('creditLog').style.display="";
				
				document.getElementById('index_td').style.backgroundColor =  "#f8f8f8";
				document.getElementById('index_td_link').style.color = "";
				document.getElementById('index').style.display="none";
				
				document.getElementById('updateD_td').style.backgroundColor =  "#f8f8f8";
				document.getElementById('updateD_td_link').style.color = "";
				document.getElementById('updateD').style.display="none";
				
				document.getElementById('mailing_td').style.backgroundColor =  "#f8f8f8";
				document.getElementById('mailing_td_link').style.color = "";
				document.getElementById('mailing').style.display="none";		
			}
			if( tab == "mailing" )
			{
				document.getElementById('mailing_td').style.backgroundColor =  "#80a0ba";
				document.getElementById('mailing_td_link').style.color = "#ffffff";
				document.getElementById('mailing').style.display="";
				
				document.getElementById('index_td').style.backgroundColor =  "#f8f8f8";
				document.getElementById('index_td_link').style.color = "";
				document.getElementById('index').style.display="none";
				
				document.getElementById('updateD_td').style.backgroundColor =  "#f8f8f8";
				document.getElementById('updateD_td_link').style.color = "";
				document.getElementById('updateD').style.display="none";

				document.getElementById('creditLog_td').style.backgroundColor =  "#f8f8f8";
				document.getElementById('creditLog_td_link').style.color = "";
				document.getElementById('creditLog').style.display="none";		
			}	
		}	

		function check_update_user_cpanel()
		{
			var fname = document.updateD_form.fname.value;
			var lname = document.updateD_form.lname.value;
			var newPass = document.updateD_form.newPass.value;
			var newPass2 = document.updateD_form.newPass2.value;
			
			var str = "";
			var counter = 1;
			
			if(fname =="") {
				str += counter++ + ". שם פרטי \n";			
			}
			
			if(lname =="") {
				str += counter++ + ". שם משפחה \n";			
			}
			
			if(newPass !="") {
				if( newPass != newPass2 )
				{
					str += counter++ + ". הסיסמאות אינם תואמות \n";	
				}		
			}
			
			if(counter > 1) {
				str = ":בכדי להשלים את העדכון, יש למלא את השדות הבאים \n\n" + str;
				alert(str);	
				return false;
			}
		}

		function getQueryParams(qs) {
			qs = qs.split("+").join(" ");

			var params = {}, tokens,
				re = /[?&]?([^=]+)=([^&]*)/g;

			while (tokens = re.exec(qs)) {
				params[decodeURIComponent(tokens[1])]
					= decodeURIComponent(tokens[2]);
			}

			return params;
		}		
	</script>
	<?php
}


function user_cpanel__updateD()
{
	require_once("class.creditMoney.10service.php"); 
	$creditMoney = new creditMoney;
	$UserID = $creditMoney->getUserIdForm_cookie();
	
	if( $UserID == "" )
		header('location:index.php');
		
	$birthday = $_POST['birth_year']."-".$_POST['birth_mon']."-".$_POST['birth_day'];
	$sql = "UPDATE net_users SET fname = '".mysql_real_escape_string($_POST['fname'])."' , lname = '".mysql_real_escape_string($_POST['lname'])."' , 	
		birthday = '".mysql_real_escape_string($birthday)."' , city = '".mysql_real_escape_string($_POST['city'])."' , 
		gender = '".mysql_real_escape_string($_POST['gender'])."' , mobile = '".mysql_real_escape_string($_POST['mobile'])."' 
	WHERE id = '".$UserID."' ";
	$res = mysql_db_query(DB,$sql);
	
	echo "<script>alert('הפרטים עודכנו בהצלחה');</script>";
	echo "<script>window.location.href='index.php?m=user_cpanel';</script>";
		exit;
}

function c_panel_credit_log(){
	
	$found_sent_forms = false;
	$sqlIn_i = 0;
	$sqlIn = "";
	
	if(isset($_SESSION['estimate_requests'])){
		
		foreach($_SESSION['estimate_requests'] as $key=>$val){
			
			
			if($sqlIn_i != 0){
				$sqlIn .= ",";
			}
			$sqlIn .= $key;
			$sqlIn_i++;
		}
	}
	$have_indication = false;
	$sql_session = "";
	
	if($sqlIn != ""){
		$sql_session =  " ef.id IN(".$sqlIn.") ";
		$have_indication = true;
	}
	$sqlEmail = "";
	$sqlMobile = "";
	if($dataUser['email'] != ""){
		
		if($have_indication){
			$sqlEmail .= " OR ";
		}
		$sqlEmail .= " ef.email = '".$dataUser['email']."' ";
		$have_indication = true;
	}
	if($dataUser['mobile'] != ""){
		if($have_indication){
			$sqlMobile .= " OR ";
		}
		$sqlMobile .= " ef.phone = '".$dataUser['mobile']."' ";
		$have_indication = true;
	}					
	if($have_indication){
			$sql = "SELECT ef.*,bc_1.cat_name as 'cat_1',bc_2.cat_name as 'cat_2',bc_3.cat_name  as 'cat_3' 
					FROM estimate_form ef 
					LEFT JOIN biz_categories bc_1 ON bc_1.id = ef.cat_f
					LEFT JOIN biz_categories bc_2 ON bc_2.id = ef.cat_s
					LEFT JOIN biz_categories bc_3 ON bc_3.id = ef.cat_spec
						
					WHERE ef.insert_date BETWEEN NOW() - INTERVAL 30 DAY AND NOW() AND (".$sql_session.$sqlEmail.$sqlMobile.")  
					ORDER BY ef.id desc LIMIT 5 ";
					
			$res = mysql_db_query(DB, $sql);
			while($est_request = mysql_fetch_array($res)){
				$found_sent_forms = true;
				$idate_d = explode(" ",$est_request['insert_date']);
				$idate_arr = explode("-",$idate_d[0]);
				$idate = $idate_arr[2]."/".$idate_arr[1]."/".$idate_arr[0];
				echo "<br/><br/><b>בקשה להצעת מחיר: </b><br/>";
				echo $idate
				." - ".$est_request['cat_1'].","
				.$est_request['cat_2'].","
				.$est_request['cat_3']."(".$est_request['phone']."  ".$est_request['email'].")<br/>".$est_request['note']."<br/>";
				
					$sql = "
							select 	u.unk , 
									u.id , 
									u.name, 
									supliers.url_link, 
									supliers.status as s_status, 
									supliers.public_phone, 
									supliers.id as s_id, 
									city.name as city_name 
							FROM users as u 
							LEFT JOIN user_extra_settings as us ON us.unk=u.unk	
							LEFT JOIN suppliers_10service as supliers ON supliers.user_id = u.id 
							LEFT JOIN cities as city ON city.id = supliers.city 
							WHERE 	u.unk IN (SELECT unk FROM user_contact_forms WHERE estimateFormID = ".$est_request['id'].") ";
					
				$res_choosenClient = mysql_db_query(DB, $sql);
				$numRwos = mysql_num_rows($res_choosenClient);
					 
				

				
				if($numRwos > 0 )
				{	
						echo "<b>נשלחה לנותני שירות: </b><br/>";
						while( $users_data = mysql_fetch_array($res_choosenClient) )
						{
							?>
								<div class="suplier-cube" style='margin:10px;width:250px; height:300px; overflow:auto; float:right;'>
									<div class="suplier-title">
										<a rel="nofollow" href='<?php echo $users_data['url_link']; ?>' title='<?php echo stripslashes($users_data['name']); ?>' target='_blank' class='suplier-maintext'>
											<?php echo stripslashes($users_data['name']); ?>
										</a>
									</div>
									<div class="suplier-center">
										<div class="amin-img">
											<?php if( $users_data['s_status'] == "0" ): ?>
												<img src='<?php echo HTTP_S; ?>://ilbiz.co.il/ClientSite/version_1/style/image/amin2.png' alt='' />
											<?php else: ?>																
												<img src='<?php echo HTTP_S; ?>://ilbiz.co.il/ClientSite/version_1/style/image/amin1.png' alt='' />
											<?php endif; ?>
										</div>
										<div class="suplier-name">
											<a rel="nofollow" href='<?php echo $users_data['url_link']; ?>' title='<?php echo stripslashes($users_data['name']); ?>' target='_blank' class='suplier-maintext'>
												<?php echo stripslashes($users_data['name']); ?>
											</a>
										</div>							
										<div class="suplier-city">
											<?php echo stripslashes($users_data['city_name']); ?>
										</div>
									</div>
										
									<?php if($users_data['public_phone'] != ""): ?>
									<div class="suplier-phone">
										טלפון: <?php echo stripslashes($users_data['public_phone']); ?>
									</div>
									<?php endif; ?>
									<?php if($users_data['url_link'] != ""): ?>
									<div class="suplier-link">
										<a rel="nofollow" href='<?php echo $users_data['url_link']; ?>' title='<?php echo stripslashes($users_data['name']); ?>' target='_blank' class='suplier-maintext'>
											אתר אינטרנט <?php echo stripslashes($users_data['name']); ?>
										</a>
									</div>	
									<?php endif; ?>

								</div>
							<?php		
						}
						?>
						<div style="clear:both;"></div>
						<?php
				}
				else{
					echo "הבקשה ממתינה לאישור, ותישלח לנותני השירות הרלוונטים.";
				}
			}
	}
}