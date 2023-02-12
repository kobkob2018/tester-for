<?php

function cat_system()
{
	$father = ( $_GET['father'] == "" ) ? "0" : $_GET['father'];
	$domain_type = ( $_GET['domain_type'] == "" ) ? "0" : $_GET['domain_type'];
	
	$sql = "select status,cat_name,id,hidden,googleADSense from biz_categories where father = '".$father."' AND domain_type = '".$domain_type."' and status != '9' order by cat_name";
	$res = mysql_db_query(DB,$sql);
	
	$first_cat = ( $father == "0" ) ? "ראשית" : "משנית";
	if(isset($_POST['set_uniq_phone'])){
		$set_uniq_phone_cat = $_POST['set_uniq_phone'];
		$set_uniq_phone_number = $_POST['set_uniq_phone_number'];
		$set_uniq_phone_number_arr = explode(",",$set_uniq_phone_number);
		$number_ckecked_ok = true;
		foreach($set_uniq_phone_number_arr as $number_check){
			$number_check = trim($number_check);
			$uniq_phone_sql = "SELECT * FROM cat_uniq_phone WHERE cat_id != $set_uniq_phone_cat AND phone LIKE(\"%$number_check%\")";
			$uniq_phone_res = mysql_db_query(DB,$uniq_phone_sql);
			$uniq_phone_data = mysql_fetch_array($uniq_phone_res);
			if(isset($uniq_phone_data['phone']) && $set_uniq_phone_number != ""){
				$number_ckecked_ok = false;
				echo "<h3 style='color:red;'>[$number_check] - המספר שבחרת כבר משוייך לקטגוריה מספר ".$uniq_phone_data['cat_id']."</h3>";
			}
		}
		if(!$number_ckecked_ok){
		}
		else{
			$uniq_phone_sql = "SELECT * FROM cat_uniq_phone WHERE cat_id = $set_uniq_phone_cat";
			$uniq_phone_res = mysql_db_query(DB,$uniq_phone_sql);
			$uniq_phone_data = mysql_fetch_array($uniq_phone_res);
			if(isset($uniq_phone_data['phone'])){
				$uniq_phone_sql = "UPDATE cat_uniq_phone SET phone = '$set_uniq_phone_number' WHERE cat_id = $set_uniq_phone_cat";
				$uniq_phone_res = mysql_db_query(DB,$uniq_phone_sql);
			}
			else{
				$uniq_phone_sql = "INSERT INTO cat_uniq_phone(phone,cat_id) VALUES('$set_uniq_phone_number',$set_uniq_phone_cat)";
				$uniq_phone_res = mysql_db_query(DB,$uniq_phone_sql);
			}
			echo "<h3 style='color:blue;'>המספר עודכן בהצלחה</h3>";
		}
	}
	echo "<table border=\"0\" cellspacing=\"0\" cellpadding=\"0\" class=\"maintext\">";
		echo "<tr>";
			echo "<td colspan='6'><A href=\"?sesid=".SESID."\" class=\"maintext\">חזרה לתפריט הראשי</a></td>";
		echo "</tr>";

		
		
		if(!isset($_GET['cat_id']) && !isset($_GET['father'])){
			echo "<tr><td colspan='6' height='5'></td></tr>";
			echo "<tr>";
				echo "<td colspan='6'><A href=\"?main=cat_system_missfit_cats&sesid=".SESID."\" class=\"maintext\">בדוק אי התאמה של שיוך קטגוריות</a></td>";
			echo "</tr>";			
			echo "<tr><td colspan='6' height='5'></td></tr>";
			echo "<tr>";
				echo "<td colspan='6'><A href=\"?main=cat_phone_display_hours&domain_type=0&cat_id=0&sesid=".SESID."\" class=\"maintext\">הגדר שעות תצוגה לטלפון ברירת מחדל</a></td>";
			echo "</tr>";			
		}
		
		echo "<tr><td colspan='6' height='5'></td></tr>";		
		echo "<tr>
			<td colspan='6'><a href=\"?main=up_in_cat&father=".$father."&domain_type=".$domain_type."&sesid=".SESID."\" class=\"maintext\">הוספת קטגוריה ".$first_cat." חדשה</a></td>
		</tr>";
		echo "<tr><td colspan='6' height='5'></td></tr>";
		echo "<tr>";
			echo "<td colspan='6'><A href=\"?main=cat_system&domain_type=".$domain_type."&sesid=".SESID."\" class=\"maintext\">קטגוריה ראשית</a></td>";
		echo "</tr>";
		/*
		echo "<tr><td colspan='6' height='5'></td></tr>";
		echo "<tr>";
			echo "<td colspan='6'>";
				echo "<b>בחר אתר לעדכון: </b>";
				foreach( estimate_domain_type() AS $key => $val )
				{
					echo "&nbsp;&nbsp;";
					$b_start = ( $key == $domain_type ) ? "<b>"  : "";
					$b_end = ( $key == $domain_type ) ? "</b>"  : "";
					
					echo "<a href='?main=cat_system&domain_type=".$key."&sesid=".SESID."' class='maintext'>".$b_start.$val.$b_end."</a>";
				}
			echo "</td>";
		echo "</tr>";
		*/
		echo "<tr><td colspan='6' height='10'></td></tr>
		<tr>
			<td>מספר</td>
			<td width=10></td>			
			<td>שם הקטגוריה</td>
			<td width=10></td>
		
			<td>פעיל באתר</td>
			<td width=10></td>
			<td>נסתר באתר</td>
			<td width=10></td>
			<td>מכיל פרסומת</td>
			<td width=10></td>			
			<td>ערוך קטגוריה</td>
			<td width=10></td>
			<td>מחיקה</td>
			<td width=30></td>
			<td>שיוך למספר מהמרכזיה
<br/>
(לדוגמה: 722556619)<br/>בלי הספרה 0 בהתחלה ;)</td>
		</tR>
		
		<tr><td colspan='6' height='10'></td></tr>";

		while( $data = mysql_fetch_array($res) )
		{
			echo "<tr>";
				echo "<td>".$data['id']."</td>";
				echo "<td width=10></td>";		
				echo "<td><a href='?main=cat_system&domain_type=".$domain_type."&father=".$data['id']."&sesid=".SESID."' class='maintext'>".htmlspecialchars(stripcslashes($data['cat_name']))."</a></td>";
				echo "<td width=10></td>";
		
				$active_insite = ( $data['status'] == "1" ) ? "פעיל" : "<span style='color:red;'>לא פעיל</span>";
				echo "<td>".$active_insite."</td>";
				echo "<td width=10></td>";
				$hidden_insite = ( $data['hidden'] == "1" ) ? "<span style='color:red;'>נסתר</span>" : "גלוי";
				echo "<td>".$hidden_insite."</td>";
				echo "<td width=10></td>";
				$have_googleADSense = ( $data['googleADSense'] != "" ) ? "<span style='color:red;'>כן</span>" : "";
				echo "<td>".$have_googleADSense."</td>";
				echo "<td width=10></td>";				
				echo "<td><a href='?main=up_in_cat&domain_type=".$domain_type."&cat_id=".$data['id']."&father=".$father."&sesid=".SESID."' class='maintext'>ערוך קטגוריה</a></td>";
				echo "<td width=10></td>";
				echo "<td><a href='?main=del_DB_cat&domain_type=".$domain_type."&cat_id=".$data['id']."&father=".$father."&sesid=".SESID."' class='maintext' onclick='return can_i_del()'><b style='color:red;'>מחיקה</b></a></td>";
				echo "<td width=30></td>";
				$set_uniq_phone_number = "";
				$uniq_phone_sql = "SELECT * FROM cat_uniq_phone WHERE cat_id = ".$data['id'];
				$uniq_phone_res = mysql_db_query(DB,$uniq_phone_sql);
				$uniq_phone_data = mysql_fetch_array($uniq_phone_res);
				if(isset($uniq_phone_data['phone'])){
					$set_uniq_phone_number = $uniq_phone_data['phone'];
				}
				?>
				<td>
					<form action="" method="POST">
						<input type="hidden" name="set_uniq_phone" value="<?php echo $data['id']; ?>"/>
						<input type="text" name="set_uniq_phone_number" value="<?php echo $set_uniq_phone_number; ?>"/>
						<input type="submit" value="שמור מספר"/>
					</form>
				</td>
				<?php 
			echo "</tR>";
			echo "<tr><td colspan='6' height='10'></td></tr>";
		}
	echo "</table>";
}


function up_in_cat()
{
	
	if($_GET['cat_id'] != "" )	{
		$sql2 = "select * from biz_categories where id = '".$_GET['cat_id']."'";
		$res2 = mysql_db_query(DB,$sql2);
		$data = mysql_fetch_array($res2);
	}
	
	$status[1] = "פעיל";
	$status[2] = "לא פעיל";
	
	$hidden[0] = "לא נסתר";
	$hidden[1] = "נסתר";
	
	$portal_active[0] = "פעיל בפורטל";
	$portal_active[1] = "לא פעיל בפורטל";

	$add_email_to_form[0] = "לא";
	$add_email_to_form[1] = "כן";
	
	$show_whatsapp_button[0] = "לא";
	$show_whatsapp_button[1] = "כן";

	for( $i=1 ; $i<=50 ; $i++ )
	{
		$place[$i] = $i;
	}
	
	if($_GET['father'] != "" )
	{
		
		$sql1 = "select id,cat_name,father from biz_categories where status = '1' AND domain_type = '".$_GET['domain_type']."' AND father=0 order by place,cat_name";
		$res1 = mysql_db_query(DB,$sql1);

		while( $data1 = mysql_fetch_array($res1) )
		{
			$sql2 = "select id,cat_name from biz_categories where father = '".$data1['id']."' and status=1 order by place,cat_name";
			$res2 = mysql_db_query(DB,$sql2);
			
			$cat[$data1['id']] = "==============&nbsp;&nbsp;".htmlspecialchars(stripslashes($data1['cat_name']))."&nbsp;&nbsp;=========";
			
			while( $data2 = mysql_fetch_array($res2) )
			{
				$cat[$data2['id']]	= htmlspecialchars(stripslashes($data2['cat_name']));
			}
			
			
		}
	}
	
	$sql = "SELECT * FROM estimate_sites";
	$res3 = mysql_db_query(DB,$sql);
	$estimate_site_choosen;
	while( $data_estimate_sites = mysql_fetch_array($res3) )
	{
		$sql = "SELECT * FROM biz_cat_choosen_estimate_site WHERE estimate_site_id = '".$data_estimate_sites['estimate_site_id']."' AND cat_id = '".$_GET['cat_id']."'";
		$res4 = mysql_db_query(DB,$sql);
		$data4 =  mysql_fetch_array($res4);
		
		$checked = ( $data4['cat_id'] != "" ) ? "checked" : "";
		$estimate_site_choosen .= "<label><input type='checkbox' name='choosen_estimate_cat[".$data_estimate_sites['estimate_site_id']."]' value='1' ".$checked." >&nbsp;".stripslashes($data_estimate_sites['estimate_name'])."</label><br>";
	}
	
	$goto_main = ( $_GET['cat_id'] ) ? "update_DB_cat" : "new_DB_cat";
	$form_arr = array(
		array("hidden","main",$goto_main),
		array("hidden","record_id",$_GET['cat_id']),
		array("hidden","father",$_GET['father']),
		array("hidden","domain_type",$_GET['domain_type']),
		array("hidden","data_arr[domain_type]",$_GET['domain_type']),
		array("hidden","sesid",SESID),
		
		
		array("text","data_arr[cat_name]",$data['cat_name'],"שם הקטגוריה", "class='input_style'","","1"),
		array("select","cat[]",$cat,"קטגוריה",$data['father'],"data_arr[father]", "class='input_style'"),
		
		array("select","status[]",$status,"סטטוס",$data['status'],"data_arr[status]", "class='input_style'"),
		array("select","hidden[]",$hidden,"נסתר באתרים?",$data['hidden'],"data_arr[hidden]", "class='input_style'"),
		array("select","hidden[]",$portal_active,"פעיל בפורטלים?",$data['portal_active'],"data_arr[portal_active]", "class='input_style'"),
		array("select","add_email_to_form[]",$add_email_to_form,"להוסיף שדה אימייל לטפסים <br/>(שים לב: ניתן להוסיף גם בניהול הטופס) ?",$data['add_email_to_form'],"data_arr[add_email_to_form]", "class='input_style'"),

		array("select","show_whatsapp_button[]",$show_whatsapp_button,"הצג כפתור ווטסאפ?<br/>---------<br/>",$data['show_whatsapp_button'],"data_arr[show_whatsapp_button]", "class='input_style'"),
		
		array("select","place[]",$place,"מיקום",$data['place'],"data_arr[place]", "class='input_style'"),
		array("text","data_arr[cat_phone]",$data['cat_phone'],"טלפון להתקשרות", "class='input_style'","","1"),
		array("text","data_arr[gl_campaign_phone]",$data['gl_campaign_phone'],"טלפון להציג בקמפיין גוגל", "class='input_style'","","1"),
		array("text","data_arr[fb_campaign_phone]",$data['fb_campaign_phone'],"טלפון להציג בקמפיין פייסבוק", "class='input_style'","","1"),
		array("textarea","data_arr[keywords]",$data['keywords'],"מילות חיפוש (הפרדה של פסיק)" , " class='input_style' style='height:110px;'"),
		array("text","data_arr[max_lead_send]",$data['max_lead_send'],"מקסימום לקוחות לשליחת ליד", "class='input_style'","","1"),
		array("textarea","data_arr[summary]",$data['summary'],"תקציר שיופיע במונעי חיפוש" , " class='input_style' style='height:110px;'"),
		array("textarea","data_arr[extra_fields]",$data['extra_fields'],"הוספת שדות נוספים לטופס" , " class='input_style' style='height:110px;'"),
		array("textarea","data_arr[googleADSense]",$data['googleADSense'],"Google ADSense" , " class='input_style' style='height:110px;'"),
		array("new_file_mysave","img",$data['img'],"תמונה", "images/cats", "&table=biz_categories&father=".$_GET['father'].""),
		array("blank",$estimate_site_choosen),
		
		
		array("submit","submit","שמירה", "class='submit_style'")
	);
	
// שדות חובה
$more = "class='maintext'";

echo "<div style='float:right;'><table border=\"0\" cellspacing=\"0\" cellpadding=\"0\" class=\"maintext\">";
		
		echo "<tr>";
			echo "<td><A href=\"?sesid=".SESID."\" class=\"maintext\">חזרה לתפריט הראשי</a></td>";
		echo "</tr>";
		echo "<tr><td height=\"7\"></td></tr>";
		echo "<tr>";
			echo "<td><A href=\"?main=cat_system&domain_type=".$_GET['domain_type']."&father=".$_GET['father']."&sesid=".SESID."\" class=\"maintext\">לתפריט הקטגוריות</a></td>";
		echo "</tr>";
		echo "<tr><td height=\"7\"></td></tr>";
		
		echo "<tr><td colspan='6' height='5'></td></tr>";
		if(isset($_GET['cat_id'])){
			$general_query_str = "";
			foreach($_GET as $key=>$val){
				if($key != "main"){
					$general_query_str.="&$key=$val";
				}
			}
			$cat_hours_query_str = "?main=cat_phone_display_hours".$general_query_str;	
			echo "<tr>";
				echo "<td colspan='6'><A href=\"$cat_hours_query_str\" class=\"maintext\">הגדר שעות תצוגה לטלפון בקטגוריה</a></td>";
			echo "</tr>";				
		}		
		echo "<tr>";
			echo "<td><A href=\"?main=mysaveButtonList&domain_type=".$_GET['domain_type']."&cat_id=".$_GET['cat_id']."&father=".$_GET['father']."&sesid=".SESID."\" class=\"maintext\">ערוך כפתורים</a></td>";
		echo "</tr>";
		echo "<tr><td height=\"11\"></td></tr>";
		
		echo "<tr>";
			echo "<td>".FormCreator::create_form($form_arr,"index.php", $more, "" , "")."</td>";
		echo "</tr>";
		
		
	echo "</table></div>";
	if(isset($_REQUEST['delete_cat_lead_refund_reason'])){
		$reason_id = $_REQUEST['reason_id'];
		$sql = "DELETE FROM cat_lead_refund_reasons WHERE id = ".$_REQUEST['reason_id']."";
		$res = mysql_db_query(DB,$sql);
	}
	if(isset($_REQUEST['add_cat_lead_refund_reason'])){
		$reason_title = $_REQUEST['reason_title'];
		$cat_id = $_REQUEST['cat_id'];
		$sql = "INSERT INTO cat_lead_refund_reasons(cat_id,title) VALUES($cat_id,'$reason_title')";
		$res = mysql_db_query(DB,$sql);
	}	
	$sql = "SELECT * FROM cat_lead_refund_reasons WHERE cat_id = ".$_REQUEST['cat_id']."";

	$res = mysql_db_query(DB,$sql);
	echo "<div style='float:left;margin-right:10px;'>";
		echo "<h3>עריכת סיבות זיכוי לקטגוריה</h3>";
		echo "<table style='border-collapse: collapse;' border='1' cellpadding='5'>";
				echo "
				<tr>
					<th>#</th>
					<th>כותרת</th>
					<th>מחיקה/הוספה</th>
				</tr>
				<tr>
					<th>
						חדש
					</th>
					<th>
						<form action='' method='POST'>
							<input type='hidden' name='add_cat_lead_refund_reason' value='1' />
							<input type='text' name='reason_title' />				
					</th>
					<th>
						<input type='submit' value='הוסף' style='width:100%;' />
						</form>						
					</th>
				</tr>
			";			
			while($reason_data = mysql_fetch_array($res)){
				echo "
				<tr>
					<td>".$reason_data['id']."</td>
					<td>".$reason_data['title']."</td>
					<td>
						<form action='' method='POST'>
							<input type='hidden' name='delete_cat_lead_refund_reason' value='1' />
							<input type='hidden' name='reason_id' value='".$reason_data['id']."' />
							<input type='submit' style='background:#ef9999;' value='מחק' />
						</form>
					</td>
				</tr>
			";
			}
		echo "</table>";
		
	echo "</div>";
	echo "<div style='text-align:right; clear:both;padding-top:20px;'>"; 
		cat_sms_after_ef_edit();
	echo "</div>";
}


function cat_sms_after_ef_edit(){

	if(isset($_REQUEST['delete_cat_sms_after_ef'])){
		$sms_id = $_REQUEST['sms_id'];
		$sql = "DELETE FROM cat_sms_after_ef WHERE id = ".$_REQUEST['sms_id']."";
		$res = mysql_db_query(DB,$sql);
	}
	if(isset($_REQUEST['add_cat_sms_after_ef'])){
		$sms_title = $_REQUEST['sms_title'];
		$sms_link = $_REQUEST['sms_link'];
		$cat_id = $_REQUEST['cat_id'];
		$sql = "INSERT INTO cat_sms_after_ef(cat_id,title,link) VALUES($cat_id,'$sms_title','$sms_link')";
		$res = mysql_db_query(DB,$sql);
	}	
	$cat_sms_list = array();
	$cat_has_sms = false;
	$sql = "SELECT * FROM cat_sms_after_ef WHERE cat_id = ".$_REQUEST['cat_id']."";
	$res = mysql_db_query(DB,$sql);
	while($sms_data = mysql_fetch_array($res)){
		$cat_sms_list[] = $sms_data;
		$cat_has_sms = true;
	}
	echo "<div>";
		echo "<h3>לינק לשליחה לגולש למילא טופס צור קשר בקטגוריה זו</h3>";
		echo "<table style='border-collapse: collapse;' border='1' cellpadding='5'>";
				echo "
				<tr>
					
					<th>כותרת</th>
					<th>כתובת הלינק</th>
					<th>מחיקה/הוספה</th>
				</tr>
				";
				if(!$cat_has_sms){
					echo "
						<tr>
							
							<th>
								<form action='' method='POST'>
									<input type='hidden' name='add_cat_sms_after_ef' value='1' />
									<input type='text' name='sms_title' />				
							</th>
							<th>
									<input type='text' name='sms_link' />				
							</th>							
							<th>
								<input type='submit' value='הוסף' style='width:100%;' />
								</form>						
							</th>
						</tr>
					";
				}
				foreach($cat_sms_list as $sms_data){
					echo "
					<tr>
						
						<td>".$sms_data['title']."</td>
						<td>".$sms_data['link']."</td>
						<td>
							<form action='' method='POST'>
								<input type='hidden' name='delete_cat_sms_after_ef' value='1' />
								<input type='hidden' name='sms_id' value='".$sms_data['id']."' />
								<input type='submit' style='background:#ef9999;' value='מחק' />
							</form>
						</td>
					</tr>
				";
				}
		echo "</table>";	
}

function update_DB_cat()
{
	$image_settings = array(
		"after_success_goto" => "?main=cat_system&domain_type=".$_POST['domain_type']."&father=".$_POST['father']."&sesid=".SESID,
		"table_name" => "biz_categories",
	);
	$data_arr = ($_POST['data_arr'])? $_POST['data_arr'] : $_GET['data_arr'];
	
		if($_FILES)
		{
			$field_name = array("img");
			$server_path = "/home/ilan123/domains/mysave.co.il/public_html/images/cats/";
			
			for($temp=0 ; $temp<sizeof($field_name) ; $temp++)
				{
				//get last id
				$image_settings['image_id'] = $_REQUEST['record_id']."_".($temp+1);
				$temp_name = $field_name[$temp];
				
					$field_name_mame = $_FILES[$temp_name]['name'];
					
					if($_FILES[$temp_name]['type'] == "image/jpeg" || $_FILES[$temp_name]['type'] == "image/gif" || $_FILES[$temp_name]['type'] == "image/pjpeg")
					{
					
						$sql = "select ".$temp_name." from biz_categories where ".$temp_name." != '' and id = '".$_REQUEST['record_id']."'";
						$res_unlink = mysql_db_query(DB,$sql);
						$data_unlink = mysql_fetch_array($res_unlink);
						
						$abpath_temp_unlink = $server_path.$data_unlink[$temp_name];
						
						if( file_exists($abpath_temp_unlink) )
							unlink($abpath_temp_unlink);
								
						$exte = substr($field_name_mame,(strpos($field_name_mame,".")+1));
						$logo_name2 = $_REQUEST['record_id'].".".$exte;
						
							
						$tempname = $field_name_mame;
						
						GlobalFunctions::upload_file_to_server($temp_name , $logo_name2 , $server_path );
						
						$sql = "UPDATE biz_categories SET ".$temp_name." = '".$logo_name2."' WHERE id = '".$_REQUEST['record_id']."' limit 1";
						$res = mysql_db_query(DB,$sql);
						
						//resize($logo_name2, $server_path, "100","150");
					}
				}
		}
	
	$sql = "DELETE FROM biz_cat_choosen_estimate_site WHERE cat_id = '".$_REQUEST['record_id']."' ";
	$res = mysql_db_query(DB,$sql);
	
	foreach( $_POST['choosen_estimate_cat'] AS $key => $val )
	{
		if( $val == "1" )
		{
			$sql = "INSERT INTO biz_cat_choosen_estimate_site ( cat_id , estimate_site_id ) VALUES ( '".$_REQUEST['record_id']."' , '".$key."' )";
			$res = mysql_db_query(DB,$sql);
		}
	}
		
	update_db($data_arr, $image_settings);
}


function new_DB_cat()
{
	$image_settings = array(
		"table_name" => "biz_categories",
		"after_success_goto" => "GET_ID",
	);
	$data_arr = ($_POST['data_arr'])? $_POST['data_arr'] : $_GET['data_arr'];
	
	$mynuewid = insert_to_db($data_arr, $image_settings);
	
	foreach( $_POST['choosen_estimate_cat'] AS $key => $val )
	{
		if( $val == "1" )
		{
			$sql = "INSERT INTO biz_cat_choosen_estimate_site ( cat_id , estimate_site_id ) VALUES ( '".$mynuewid."' , '".$key."' )";
			$res = mysql_db_query(DB,$sql);
		}
	}
	
	echo "<META HTTP-EQUIV=Refresh CONTENT=\"0; URL=?main=cat_system&domain_type=".$_POST['domain_type']."&father=".$_POST['father']."&sesid=".SESID."\">";
			exit;
}

function del_DB_cat()
{
	$sql = "update biz_categories set status = '9' where id = '".$_GET['cat_id']."' and father = '".$_GET['father']."' limit 1";
	$res = mysql_db_query(DB,$sql);
	
	echo "<script>window.location.href='?main=cat_system&domain_type=".$_GET['domain_type']."&father=".$_GET['father']."&sesid=".SESID."';</script>";
		exit;
}

function del_img_DB_FTP_mysave()	{

	$sql = "select id from ".$_GET['table']." where ".$_GET['field_name']." = '".$_GET['img']."'";
	$res = mysql_db_query(DB,$sql);
	$data = mysql_fetch_array($res);
	$num_rows = mysql_num_rows($res);
	
	if( $num_rows == 1 )	{
		$abpath_temp_unlink = "/home/ilan123/domains/mysave.co.il/public_html/".$_GET['path'].$_GET['img'];
		if( file_exists($abpath_temp_unlink) && !is_dir($abpath_temp_unlink) )
		{
			unlink($abpath_temp_unlink);
			
			$sql2 = "update ".$_GET['table']." set ".$_GET['field_name']." = '' where id = '".$data['id']."' limit 1";
			$res = mysql_db_query(DB,$sql2);
			
			echo "<script>alert('התמונה נמחקה בהצלחה');</script>";
		}
		else 
			echo "<script>alert('התמונה לא נמחקה, אנא נסה שנית. טעות מספר 1303370');</script>";
	}
	else	{
		echo "<script>alert('התמונה לא נמחקה, אנא נסה שנית. טעות מספר 1303389');</script>";
	}
	
	echo "<script>window.location.href='index.php?main=cat_system&domain_type=".$_GET['domain_type']."&father=".$_GET['father']."&sesid=".SESID."';</script>";
		exit;
}



function mysaveButtonList()
{
	$sql = "SELECT * FROM mysaveFormButton WHERE catId='".$_GET['cat_id']."' ORDER BY place";
	$res = mysql_db_query(DB, $sql);
	
	$sql1 = "select cat_name from biz_categories where id = '".$_GET['cat_id']."'";
	$cat_nameRes = mysql_db_query(DB,$sql1);
	$cat_nameData = mysql_fetch_array($cat_nameRes);
	$cat_name = stripslashes($cat_nameData['cat_name']);
	
	echo "<table border=\"0\" cellspacing=\"0\" cellpadding=\"0\" class=\"maintext\">";
		echo "<tr>";
			echo "<td colspan='6'><A href=\"?sesid=".SESID."\" class=\"maintext\">חזרה לתפריט הראשי</a></td>";
		echo "</tr>";
		echo "<tr><td colspan='6' height='5'></td></tr>";
		echo "<tr>
			<td colspan='6'><a href=\"?main=up_in_cat&domain_type=".$_GET['domain_type']."&cat_id=".$_GET['cat_id']."&father=".$_GET['father']."&sesid=".SESID."\" class=\"maintext\">לטופס עדכון קטגוריה ".$cat_name."</a></td>
		</tr>";
		echo "<tr><td colspan='6' height='5'></td></tr>";
		echo "<tr>";
			echo "<td colspan='6'><A href=\"?main=cat_system&domain_type=".$_GET['domain_type']."&father=".$_GET['father']."&sesid=".SESID."\" class=\"maintext\">לרשימת קטגוריות</a></td>";
		echo "</tr>";
		
		echo "<tr><td colspan='6' height='5'></td></tr>";
		echo "<tr>";
			echo "<td colspan='6'><A href=\"?main=mysaveButtonEdit&domain_type=".$_GET['domain_type']."&cat_id=".$_GET['cat_id']."&father=".$_GET['father']."&sesid=".SESID."\" class=\"maintext\">הוסף כפתור חדש</a></td>";
		echo "</tr>";
		
		echo "<tr><td colspan='6' height='10'></td></tr>
		<tr>
			<td>שם הקטגוריה</td>
			<td width=10></td>
			<td>שם הכפתור</td>
			<td width=10></td>
			<td>ערוך כפתור</td>
			<td width=10></td>
			<td>פעיל באתר?</td>
		</tR>
		
		<tr><td colspan='6' height='10'></td></tr>";
		
		while( $data = mysql_fetch_array($res) )
		{
			echo "<tr>";
				echo "<td>".$cat_name."</a></td>";
				echo "<td width=10></td>";
				echo "<td>".stripslashes($data['title'])."</td>";
				echo "<td width=10></td>";
				echo "<td><a href='?main=mysaveButtonEdit&domain_type=".$_GET['domain_type']."&button_id=".$data['id']."&cat_id=".$_GET['cat_id']."&father=".$_GET['father']."&sesid=".SESID."' class='maintext'>ערוך כפתור</a></td>";
				echo "<td width=10></td>";
				$active_insite = ( $data['active'] == "0" ) ? "<font style='color:green;'>פעיל</font>" : "<font style='color:red;'>לא פעיל</font>";
				echo "<td>".$active_insite."</td>";
			echo "</tR>";
			echo "<tr><td colspan='6' height='10'></td></tr>";
		}
	echo "</table>";
}

function mysaveButtonEdit()
{
	
	if($_GET['button_id'] != "" )	{
		$sql2 = "select * from mysaveFormButton where id = '".$_GET['button_id']."'";
		$res2 = mysql_db_query(DB,$sql2);
		$data = mysql_fetch_array($res2);
	}
	
	$sql1 = "select cat_name from biz_categories where id = '".$_GET['cat_id']."'";
	$cat_nameRes = mysql_db_query(DB,$sql1);
	$cat_nameData = mysql_fetch_array($cat_nameRes);
	$cat_name = stripslashes($cat_nameData['cat_name']);
	
	$active[0] = "פעיל";
	$active[1] = "לא פעיל";
	
	for( $i=1 ; $i<=5 ; $i++ )
	{
		$place[$i] = $i;
	}
	
	
	$form_arr = array(
		array("hidden","main","mysaveButtonEditDB"),
		array("hidden","record_id",$_GET['button_id']),
		array("hidden","cat_id",$_GET['cat_id']),
		array("hidden","domain_type",$_GET['domain_type']),
		array("hidden","data_arr[catId]",$_GET['cat_id']),
		array("hidden","father",$_GET['father']),
		array("hidden","sesid",SESID),
		
		
		array("text","data_arr[title]",$data['title'],"שם הכפתור", "class='input_style'"),
		array("select","active[]",$active,"סטטוס",$data['active'],"data_arr[active]", "class='input_style'"),
		array("select","place[]",$place,"מיקום",$data['place'],"data_arr[place]", "class='input_style'"),
		
		array("submit","submit","שמירה", "class='submit_style'")
	);
	
// שדות חובה
$more = "class='maintext'";

echo "<table border=\"0\" cellspacing=\"0\" cellpadding=\"0\" class=\"maintext\">";
		
		echo "<tr>";
			echo "<td><A href=\"?sesid=".SESID."\" class=\"maintext\">חזרה לתפריט הראשי</a></td>";
		echo "</tr>";
		echo "<tr><td colspan='6' height='5'></td></tr>";
		echo "<tr>
			<td colspan='6'><a href=\"?main=up_in_cat&domain_type=".$_GET['domain_type']."&cat_id=".$_GET['cat_id']."&father=".$_GET['father']."&sesid=".SESID."\" class=\"maintext\">לטופס עדכון קטגוריה ".$cat_name."</a></td>
		</tr>";
		echo "<tr><td colspan='6' height='5'></td></tr>";
		echo "<tr>";
			echo "<td colspan='6'><A href=\"?main=cat_system&domain_type=".$_GET['domain_type']."&father=".$_GET['father']."&sesid=".SESID."\" class=\"maintext\">לרשימת קטגוריות</a></td>";
		echo "</tr>";
		
		echo "<tr><td colspan='6' height='5'></td></tr>";
		echo "<tr>";
			echo "<td colspan='6'><A href=\"?main=mysaveButtonList&domain_type=".$_GET['domain_type']."&cat_id=".$_GET['cat_id']."&father=".$_GET['father']."&sesid=".SESID."\" class=\"maintext\">לרשימת הכפתורים של הקטגוריה ".$cat_name."</a></td>";
		echo "</tr>";
		
		echo "<tr>";
			echo "<td>".FormCreator::create_form($form_arr,"index.php", $more, "" , "")."</td>";
		echo "</tr>";
		
		
	echo "</table>";
}

function mysaveButtonEditDB()
{
	$image_settings = array(
		"after_success_goto" => "?main=mysaveButtonList&domain_type=".$_POST['domain_type']."&cat_id=".$_POST['cat_id']."&father=".$_POST['father']."&sesid=".SESID,
		"table_name" => "mysaveFormButton",
	);
	$data_arr = ($_POST['data_arr'])? $_POST['data_arr'] : $_GET['data_arr'];
	
	if( $_POST['record_id'] )
		update_db($data_arr, $image_settings);
	else
		insert_to_db($data_arr, $image_settings);
}
?>