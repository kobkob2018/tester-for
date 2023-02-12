<?


function site_authList()
{
	$sql = "SELECT * FROM user_site_auth WHERE deleted=0 AND unk = '".UNK."' ORDER BY id";
	$res = mysql_db_query(DB,$sql);
	
	echo "<table border=\"0\" cellspacing=\"0\" cellpadding=\"0\" class=\"maintext\">";
		
		echo "<tr>";
			echo "<th>תאריך הצטרפות</th>";
			echo "<th width='10'></th>";
			echo "<th>שם מלא</th>";
			echo "<th width='10'></th>";
			echo "<th>שם החברה</th>";
			echo "<th width='10'></th>";
			echo "<th>שם משתמש</th>";
			echo "<th width='10'></th>";
			echo "<th>סיסמה</th>";
			echo "<th width='10'></th>";
			echo "<th>עדכון</th>";
			echo "<th width='10'></th>";
			echo "<th>מחיקה</th>";
		echo "</tr>";
		
		while( $data = mysql_fetch_array($res) )
		{
			echo "<tr><td colspan=13 height=5></td></tr>";
			echo "<tr><td colspan=13><hr width=100% size=1 color=#000000></td></tr>";
			echo "<tr><td colspan=13 height=5></td></tr>";
			
			echo "<tr>";
				echo "<td>".GlobalFunctions::date_fliper(stripslashes($data['insert_date']))."</td>";
				echo "<td width='10'></td>";
				echo "<td>".stripslashes($data['full_name'])."</td>";
				echo "<td width='10'></td>";
				echo "<td>".stripslashes($data['company_name'])."</td>";
				echo "<td width='10'></td>";
				echo "<td>".stripslashes($data['username'])."</td>";
				echo "<td width='10'></td>";
				echo "<td>".stripslashes($data['password'])."</td>";
				echo "<td width='10'></td>";
				echo "<td><a href='?main=site_authForm&type=site_auth&rowID=".$data['id']."&unk=".UNK."&sesid=".SESID."' class='maintext'>עדכון</a></td>";
				echo "<td width='10'></td>";
				echo "<td><a href='?main=site_authDEL&type=site_auth&rowID=".$data['id']."&unk=".UNK."&sesid=".SESID."' class='maintext' onclick='return can_i_del()'>מחיקה</a></td>";
			echo "</tr>";
		}
	echo "</table>";
}


function site_authForm()
{
	if( !empty($_GET['rowID']) )
	{
		$sql = "SELECT * FROM user_site_auth WHERE deleted = '0' AND unk = '".UNK."' and id = '".$_GET['rowID']."'";
		$res = mysql_db_query(DB,$sql);
		$data = mysql_fetch_array($res);
	}	
	
	$sql = "select username from users where unk = '".UNK."'";
	$res_users = mysql_db_query(DB,$sql);
	$data_users = mysql_fetch_array($res_users);
	
	
	$wtc_val_insert_date = ( !empty($data['id']) ) ? $data['insert_date'] : GlobalFunctions::get_date();
	
	$status[0] = "כן";
	$status[1] = "לא";
	
	$username_tmp = str_replace( $data_users['username']."_" , "" , $data['username'] );
	
	
	
	
	$sql = "select * from user_words where unk = '".UNK."'";
	$res_words = mysql_db_query(DB,$sql);
	$data_words = mysql_fetch_array($res_words);
	
	$temp_word_about = ( $data_words['id'] == "" ) ? "פרופיל עסק" : stripslashes($data_words['word_about']);
	$temp_word_articels = ( $data_words['id'] == "" ) ? "כתבות" : stripslashes($data_words['word_articels']);
	$temp_word_products = ( $data_words['id'] == "" ) ? "מוצרים" : stripslashes($data_words['word_products']);
	$temp_word_yad2 = ( $data_words['id'] == "" ) ? "יד 2" : stripslashes($data_words['word_yad2']);
	$temp_word_sales = ( $data_words['id'] == "" ) ? "מבצעים" : stripslashes($data_words['word_sales']);
	$temp_word_video = ( $data_words['id'] == "" ) ? "גלרית וידאו" : stripslashes($data_words['word_video']);
	$temp_word_wanted = ( $data_words['id'] == "" ) ? "דרושים" : stripslashes($data_words['word_wanted']);
	$temp_word_gallery = ( $data_words['id'] == "" ) ? "גלרית תמונות" : stripslashes($data_words['word_gallery']);
	$temp_word_contact = ( $data_words['id'] == "" ) ? "תצוגת טפסי צור קשר" : stripslashes($data_words['word_contact']);
	
	$auth_models_arr = array(
		about => array( "ab" => $temp_word_about ),
		articels => array( "ar" => $temp_word_articels ),
		products => array( "pr" => $temp_word_products ),
		yad2 => array( "ya" => $temp_word_yad2 ),
		sales => array( "sa" => $temp_word_sales ),
		video => array( "vi" => $temp_word_video ),
		wanted => array( "jo" => $temp_word_wanted ),
		gallery => array( "ga" =>	$temp_word_gallery ),
		contact => array( "co" =>	$temp_word_contact ),
	);
	
	
	
	$authModels = "";
	$authModels .= "<table border=\"0\" cellspacing=\"0\" cellpadding=\"0\" class=\"maintext\">";
		$authModels .= "<tr>";
			$authModels .= "<td><b>הרשאות</b></td>";
		$authModels .= "</tr>";
		$authModels .= "<tr><td height=5></td></tr>";
		$authModels .= "<tr>";
			$authModels .= "<td>";
				$authModels .= "<table border=\"0\" cellspacing=\"0\" cellpadding=\"0\" class=\"maintext\">";
					foreach( $auth_models_arr as $modelTMP => $modelsArr )
					{
						foreach( $modelsArr as $modelCode => $modelName )
						{
							if( $modelName != "" )
							{
								$sql = "SELECT COUNT(model) as numsModels FROM user_site_auth_belong WHERE unk='".UNK."' AND auth_id = '".$data['id']."' AND model = '".$modelCode."'";
								$res_CountModels = mysql_db_query(DB, $sql);
								$data_CountModels = mysql_fetch_array($res_CountModels);
								
								$checked = ( $data_CountModels['numsModels'] > 0 ) ? "checked" : "";
								$authModels .= "<tr>";
									$authModels .= "<td><input type='checkbox' name='usersAuth[]' value='".$modelCode."' ".$checked."></td>";
									$authModels .= "<td width=10></td>";
									$authModels .= "<td>".$modelName."</td>";
								$authModels .= "</tr>";
							}
						}
					}
				$authModels .= "</table>";
			$authModels .= "</td>";
		$authModels .= "</tr>";
		$authModels .= "<tr>";
			$authModels .= "<td><b>הערה:</b> המשתמש יוכל לעדכן אך ורק מודולים שסימנתם,
			 כמובן שהוא יוכל לעדכן רק את הרשומות שהוא כתב/העלה<br>לכם יהיה שליטה למחיקה/עדכון רשומות שהמשתמש העלה</td>";
		$authModels .= "</tr>";
	$authModels .= "</table>";
	
	$sql = "SELECT indexSite FROM user_extra_settings WHERE unk = '".UNK."' ";
	$res_index = mysql_db_query(DB,$sql);
	$data_index = mysql_fetch_array($res_index);
	
	if( $data_index['indexSite'] == "1" )
	{
		$sql = "SELECT business_name,id FROM user_guide_business WHERE deleted=0 AND active=0 AND unk = '".UNK."' ORDER BY business_name";
		$res_bizz = mysql_db_query(DB,$sql);
		
		while( $data_biz = mysql_fetch_array($res_bizz) )
		{
			$biz_id = $data_biz['id'];
			$kol_userid[$biz_id] = stripslashes($data_biz['business_name']);
		}
		
		$kol_useridArr = array("select","kol_userid[]",$kol_userid,"ההרשאה הזו שייכת לעסק:",$data['kol_userid'],"data_arr[kol_userid]", "class='input_style'");
	}
	
	$form_arr = array(
				array("hidden","main","site_authDbRequest"),
				array("hidden","type",$_GET['type']),
				array("hidden","record_id",$data['id']),
				array("hidden","sesid",SESID),
				array("hidden","data_arr[unk]",UNK),
				array("hidden","unk",UNK),
				
				array("text","data_arr[username]",$username_tmp,"שם משתמש<br>בתחילת שם המשתמש<br> יופיע <font dir=ltr>\"".$data_users['username']."_\"</div>", "class='input_style'","","1"),
				array("text","data_arr[password]",$data['password'],"סיסמה", "class='input_style'","","1"),
				array("text","data_arr[full_name]",$data['full_name'],"שם מלא (איש קשר)", "class='input_style'","","1"),
				array("text","data_arr[company_name]",$data['company_name'],"שם חברה", "class='input_style'","","1"),
				array("text","data_arr[email]",$data['email'],"אימייל (איש קשר)", "class='input_style'","","1"),
				array("text","data_arr[phone]",$data['phone'],"טלפון (איש קשר)", "class='input_style'","","1"),
				array("text","data_arr[mobile]",$data['mobile'],"נייד (איש קשר)", "class='input_style'","","1"),
				
				array("select","status[]",$status,"פעיל",$data['status'],"data_arr[status]", "class='input_style'"),
				
				array("date","insert_date",$wtc_val_insert_date,"תאריך רישום <font style=\"font-size:9px;\" class=\"maintext_small\">dd-mm-yyyy</font>", "class='input_style'"),
				
				array("blank",$authModels),
				
				$kol_useridArr,
				
				array("submit","submit","שלח טופס", "class='submit_style'")
	);
	
		
// שדות חובה
//$mandatory_fields = array("data_arr[name]","data_arr[email]","data_arr[phone]");
$more = "class='maintext' border='0'";

echo FormCreator::create_form($form_arr,"index.php", $more );

}


function site_authDbRequest()
{
	$sql = "select username from users where unk = '".UNK."'";
	$res_users = mysql_db_query(DB,$sql);
	$data_users = mysql_fetch_array($res_users);
	
	
	if( !eregi($data_users['username'] , $_POST['data_arr']['username'] ) )
	{
		$_POST['data_arr']['username'] = $data_users['username']."_".$_POST['data_arr']['username'];
	}
	
	
	$image_settings = array(
		after_success_goto=>"",
		table_name=>"user_site_auth",
		flip_date_to_original_format=>array("insert_date"),
	);
	
	$data_arr = ($_POST['data_arr'])? $_POST['data_arr'] : $_GET['data_arr'];
	
	if( empty($_POST['record_id']) )
	{
		insert_to_db($data_arr, $image_settings);
		$record_id = $GLOBALS['mysql_insert_id'];
	}
	else
	{
		update_db($data_arr, $image_settings);
		$record_id = $_POST['record_id'];
	}
	
	
	if( is_array($_POST['usersAuth']) )
	{
		$sqlDel = "DELETE FROM user_site_auth_belong WHERE unk = '".UNK."'";
		$resDel = mysql_db_query(DB,$sqlDel);
		
		foreach( $_POST['usersAuth'] as $key => $modelCode )
		{
			$sql = "INSERT INTO user_site_auth_belong ( unk, auth_id, model ) values ( '".UNK."' , '".$record_id."' , '".$modelCode."') ";
			$res = mysql_db_query(DB,$sql);
		}
	}
	
	echo "<META HTTP-EQUIV=Refresh CONTENT=\"0; URL=index.php?main=site_authList&type=site_auth&unk=".UNK."&sesid=".SESID."\">";
		exit;
}


function site_authDEL()
{
	$sql = "UPDATE user_site_auth SET deleted=1 WHERE unk='".UNK."' AND id = '".$_GET['rowID']."'";
	$res = mysql_db_query(DB,$sql);
	
	echo "<META HTTP-EQUIV=Refresh CONTENT=\"0; URL=index.php?main=site_authList&type=site_auth&unk=".UNK."&sesid=".SESID."\">";
		exit;
}

?>