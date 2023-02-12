<?php
/*
* Copyright © 2006 ILbiz. All Rights Reserved
* email:	webmaster@ilbiz.co.il
*
* 
* the page create the form and update the site settings of the client
*/

function site_settings_form()	{
	
	global $word;
	$sql = "select * from user_site_settings where deleted = 0 and status != '9' and unk = '".$_REQUEST['unk']."'";
	$res = mysql_db_query(DB,$sql);
	$data = mysql_fetch_array($res);
	
	// create the form array
	$form_arr = array(
		"slogen" => $word[LANG]['slogen'], 
		"phone_slogen" => $word[LANG]['phone_slogen'], 
		"logo" => $word[LANG]['logo'],
		"mobile_logo" => $word[LANG]['mobile_logo'],
		"site_title" => $word[LANG]['settings_browser_title'],
		"runews_headline" => $word[LANG]['settings_last_update'],
		
		"set_colors" => $word[LANG]['choose_design'],
		"keywords" => $word[LANG]['settings_browser_keywords'],
		"description" => $word[LANG]['settings_browser_description'],
		"editor_type" => "סוג עורך",
		"fly_text" => "טקסט מרחף על תמונות במוצרים וגלריית תמונות",
		"fly_bg" => "רקע לטקסט מרחף על תמונות במוצרים וגלריית תמונות",
		"fly_color" => "צבע הטקסט מרחף על תמונות במוצרים וגלריית תמונות",
	);
	
	
	echo "<form action=\"index.php\" name=\"site_settings_form\" method=\"post\" enctype=\"multipart/form-data\">";
	echo "<input type=\"hidden\" name=\"main\" value=\"update_site_settings\">";
	echo "<input type=\"hidden\" name=\"Ud\" value=\"".$data['id']."\">";
	echo "<input type=\"hidden\" name=\"unk\" value=\"".$_REQUEST['unk']."\">";
	echo "<input type=\"hidden\" name=\"sesid\" value=\"".$_REQUEST['sesid']."\">";
	echo "<table border=\"0\" cellspacing=\"0\" cellpadding=\"0\" class=\"maintext\">";
		
		// foreach for create the form
		foreach( $form_arr as $val => $key )	{
			echo "<tr>";
				echo "<td>".$key."</td>";
				echo "<td width=\"10\"></td>";
				echo "<td>";
					switch($val)	{
						case "logo" :
							$abpath_temp = SERVER_PATH."/tamplate/".$data['logo'];
							
							if( file_exists($abpath_temp) && !is_dir($abpath_temp) )
								$details_img = "&nbsp;&nbsp;<a href=\"".HTTP_PATH."/tamplate/".$data['logo']."\" class=\"maintext_small\" target=\"_blank\">צפה בלוגו</a>&nbsp;&nbsp;|&nbsp;&nbsp;<a href=\"index.php?main=del_img_DB_FTP&table=user_site_settings&field_name=logo&sesid=".$_GET['sesid']."&unk=".$_GET['unk']."&GOTO_type=site_setting&GOTO_main=site_settings_form&path=tamplate/&img=".$data['logo']."\" class=\"maintext_small\">מחק לוגו</a>";
							
							echo "<input type='file' name='".$val."' value='' class='input_style'>".$details_img;
						break;
						case "mobile_logo" :
							$abpath_temp = SERVER_PATH."/tamplate/".$data['mobile_logo'];
							
							if( file_exists($abpath_temp) && !is_dir($abpath_temp) )
								$details_mobile_img = "&nbsp;&nbsp;<a href=\"".HTTP_PATH."/tamplate/".$data['mobile_logo']."\" class=\"maintext_small\" target=\"_blank\">צפה בלוגו</a>&nbsp;&nbsp;|&nbsp;&nbsp;<a href=\"index.php?main=del_img_DB_FTP&table=user_site_settings&field_name=mobile_logo&sesid=".$_GET['sesid']."&unk=".$_GET['unk']."&GOTO_type=site_setting&GOTO_main=site_settings_form&path=tamplate/&img=".$data['mobile_logo']."\" class=\"maintext_small\">מחק לוגו מובייל</a>";
							
							echo "<input type='file' name='".$val."' value='' class='input_style'>".$details_mobile_img;
						break;						
						case "editor_type" :
							$selected0 = ( $data[$val] == "0" ) ? "selected" : "";
							$selected1 = ( $data[$val] == "1" ) ? "selected" : "";
							echo "<select name=\"".$val."\" class=\"input_style\">";
								echo "<option value=\"0\" ".$selected0.">עורך דמוי וורד גרסה 3</option>";
								echo "<option value=\"1\" ".$selected1.">עורך דמוי וורד גרסה 2</option>";
							echo "</select>";
						break;
						
						case "set_colors" :
							$sql = "select id from user_colors_set where deleted = '0' and status = '0' and unk = '{$_REQUEST['unk']}'";
							$res_colors2 = mysql_db_query(DB,$sql);
							$num_row = mysql_num_rows($res_colors2);
							
							if( $num_row > 0 )
								echo $word[LANG]['choose_design_you_cant'];
							else
							{
								$sql = "select id,set_name from user_colors_set where deleted = '0' and status = '0' and unk = ''";
								$res_colors = mysql_db_query(DB,$sql);
								
								echo "<select name=\"".$val."\" class=\"input_style\">";
									echo "<option value=\"\">בחר</option>";
									
									while( $data_colors = mysql_fetch_array($res_colors) )	{
										$selected1 = ( $data['set_colors'] == $data_colors['id'] ) ? "selected" : "";
										echo "<option value=\"".$data_colors['id']."\" ".$selected1.">".stripslashes($data_colors['set_name'])."</option>";
									}
								echo "</select>";
							}
						break;
						
						case "keywords" :
						case "description" :
							echo "<textarea cols=\"\" rows=\"\" name=\"".$val."\" class=\"textarea_style_summary\">".stripslashes($data[$val])."</textarea>";
						break;
						
						default :
							echo "<input type='text' name='".$val."' value='".GlobalFunctions::remove_geresh(stripslashes($data[$val]))."' class='input_style'>";
					}
				echo "</td>";
			echo "</tr>";
			echo "<tr><td colspan=\"3\" height=\"6\"></td></tr>";
		}
		
		echo "<tr>";
			echo "<td>&nbsp;</td>";
			echo "<td width=\"\"></td>";
			echo "<td><input type=\"Submit\" value=\"".$word[LANG]['save']."\" class=\"submit_style\"></td>";
		echo "</tr>";
		
	echo "</table>";
	echo "</form>";
}
/*****************************************************************************************************/

function update_site_settings()	{

	global $db,$server_path,$logo,$mobile_logo,$logo_name;
	
	$sql = "select id from user_colors_set where deleted = '0' and status = '0' and unk = '{$_REQUEST['unk']}'";
	$res_colors2 = mysql_db_query(DB,$sql);
	$num_row = mysql_num_rows($res_colors2);
	
	if( $num_row > 0 )
	{
		$form_arr2 = array(
			slogen => "slogen", 
			phone_slogen => "phone_slogen", 
			site_title => "site_title",
			runews_headline => "runews_headline",
			keywords => "keywords",
			description => "description",
			editor_type => "editor_type",
			"fly_text" => "fly_text",
			"fly_bg" => "fly_bg",
			"fly_color" => "fly_color",
		);
	}
	else
	{
		$form_arr2 = array(
			slogen => "slogen",
			phone_slogen => "phone_slogen",
			site_title => "site_title",
			runews_headline => "runews_headline",
			set_colors => "set_colors",
			keywords => "keywords",
			description => "description",
			editor_type => "editor_type",
			"fly_text" => "fly_text",
			"fly_bg" => "fly_bg",
			"fly_color" => "fly_color",
		);
	}
	
	
	
	if( $_REQUEST['Ud'] != "" )
	{
		$counter = 1;
		$sql = "update user_site_settings set ";
		foreach( $form_arr2 as $val => $key )	{
			$with_psik = ( $counter == sizeof($form_arr2) ) ? " " : ", ";
			$sql .= $val." = '".GlobalFunctions::add_geresh(addslashes($_REQUEST[$key]))."'".$with_psik;
			
			$counter++;
		}
		$sql .= "where unk = '".$_REQUEST['unk']."' and deleted = '0'";
	}
	else
	{
		$counter = 1;
		$counter2 = 1;
		$sql = "insert into user_site_settings(unk,";
		foreach( $form_arr2 as $val => $key )	{
			$with_psik = ( $counter == sizeof($form_arr2) ) ? ") values( '".$_REQUEST['unk']."' , " : ", ";
			$sql .= $val.$with_psik;
			
			$counter++;
		}	
		foreach( $form_arr2 as $val => $key )	{
			$with_psik = ( $counter2 == sizeof($form_arr2) ) ? ") " : ", ";
			$sql .= "'".$_REQUEST[$key]."'".$with_psik;
			
			$counter2++;
		}
	}
	
	$res = mysql_db_query(DB,$sql);
	
	
	
	
	// details for the logo
	$image_settings['img_leading_name'] = "logos";
	$image_settings['server_path'] = SERVER_PATH."/tamplate/";
	$image_settings['thumbnail_width'] = "500";
	$image_settings['thumbnail_height'] = "500";
	$image_settings['images_structure'] = 1;
	$image_settings['table_name'] = "user_site_settings";
	$image_settings['record_id'] = $_REQUEST['unk'];
	
	$field_name = array("logo","mobile_logo");
	
	//check if files being uploaded
	if($_FILES)
		{
			for($temp=0 ; $temp<sizeof($field_name) ; $temp++){
				
				//get last id
				$image_settings['image_id'] = $_REQUEST['unk']."_".($temp+1);
				
				
				$temp_name = $field_name[$temp];
				$field_name_mame = $_FILES[$temp_name]['name'];
					
					if($_FILES[$temp_name]['type'] == "image/jpeg" || $_FILES[$temp_name]['type'] == "image/gif" || $_FILES[$temp_name]['type'] == "image/png" || $_FILES[$temp_name]['type'] == "image/pjpeg")
					{
						$exte = substr($field_name_mame,(strpos($field_name_mame,".")+1));
						$logo_name2 = $_REQUEST['unk']."-".$temp_name.".".$exte;
						$tempname = $logo_name;
						
						GlobalFunctions::upload_file_to_server($temp_name , $logo_name2 , $image_settings['server_path'] );
						
						
						$sql = "UPDATE user_site_settings SET ".$temp_name." = '".$logo_name2."' WHERE unk = '".$_REQUEST['unk']."'";
						$res = mysql_db_query($db,$sql);
						
						resize($logo_name2, $image_settings['server_path'], $image_settings['thumbnail_width'],$image_settings['thumbnail_height']);
					}
				}
				
		}
	
	echo "<script>alert('השינויים נשמרו במערכת');</script>";
	echo "<script>window.location.href='?main=site_settings_form&unk=".$_REQUEST['unk']."&sesid=".$_REQUEST['sesid']."';</script>";
		exit;
}
/*****************************************************************************************************/
/*****************************************************************************************************/
/*****************************************************************************************************/


function update_profile()	{
	
	global $word;
	
if( UNK == "263512086634836547" && AUTH_ID != 0 )
{
	$sql = "select ug.* from
		 user_guide_business as ug , user_site_auth as au
		 where 
		 	au.id = '".AUTH_ID."' AND
		 	au.kol_userid = ug.id AND 
		 	ug.unk = '".UNK."'";
	$res = mysql_db_query(DB,$sql);
	$data = mysql_fetch_array($res);
	
	$sql = "SELECT guide_name, id FROM user_guide WHERE unk='".UNK."' ORDER BY guide_name";
	$res_guideId = mysql_db_query(DB,$sql);
			
	$selected_guideId = "";
	while( $data_guideId = mysql_fetch_array($res_guideId) )
	{
		$guideId = $data_guideId['id'];
		$guide_id[$guideId] = stripslashes($data_guideId['guide_name']);
		
		$sql_biz_guide = "SELECT id FROM user_guide_choosen_biz_guide WHERE biz_id = '".$data['id']."' AND guide_id = '".$guideId."' ";
		$res_biz_guide = mysql_db_query(DB, $sql_biz_guide);
		$data_biz_guide = mysql_fetch_array($res_biz_guide);
		
		if( $data_biz_guide['id'] != "" )
			$selected_guideId .= $guideId."@";
	}
	
	$sql = "SELECT city_name, id FROM user_guide_cities WHERE unk='".UNK."' and deleted=0 ORDER BY city_name";
	$res_cities = mysql_db_query(DB,$sql);
	
	$selected_cityId = "";
	while( $data_cities = mysql_fetch_array($res_cities) )
	{
		$cityId = $data_cities['id'];
		$city[$cityId] = stripslashes($data_cities['city_name']);
		
		$sql_biz_city = "SELECT id FROM user_guide_choosen_biz_city WHERE biz_id = '".$data['id']."' AND city_id = '".$cityId."' ";
		$res_biz_city = mysql_db_query(DB, $sql_biz_city);
		$data_biz_city = mysql_fetch_array($res_biz_city);
		
		if( $data_biz_city['id'] != "" )
			$selected_cityId .= $cityId."@";
	}
	
	if( $data['id'] != "" )
	{
		$cats = array("blank" , "<a href='guide_cats.php?unk=".UNK."&sesid=".SESID."&biz_id=".$data['id']."' class='maintext' target='_blank'>קטגוריות</a>");
	}
	
			
			$form_arr = array(
				array("hidden","main","DB_update_profile"),
				array("hidden","type","update_profile"),
				array("hidden","record_id",$data['id']),
				array("hidden","sesid",SESID),
				array("hidden","data_arr[unk]",UNK),
				array("hidden","unk",UNK),
				
				
				array("multi_select","guide_id[]",$guide_id,"שם המדריך",$selected_guideId,"guide_id[]", "class='input_style' style='height: 50px;'"),
				$cats,
				
				array("text","data_arr[business_name]",$data['business_name'],"שם העסק", "class='input_style'"),
				
				array("multi_select","city[]",$city,"עיר",$selected_cityId,"cities[]", "class='input_style' style='height: 50px;'"),
				array("text","data_arr[phone]",$data['phone'],"טלפון", "class='input_style'"),
				array("text","data_arr[email]",$data['email'],"אימייל", "class='input_style'"),
				array("text","data_arr[website]",$data['website'],"אתר אינטרנט", "class='input_style'"),
				
				array("new_file","img1",$data['img1'],"תמונת נגב פון", "new_images/".$data['id'], "&table=user_guide_business&GOTO_type=update_profile&GOTO_main=update_profile"),
				array("new_file","img2",$data['img2'],"תמונת כרטיס ביקור", "new_images/".$data['id'], "&table=user_guide_business&GOTO_type=update_profile&GOTO_main=update_profile"),
				
				array("new_file","logo",$data['logo'],"לוגו", "new_images/".$data['id'], "&table=user_guide_business&GOTO_type=update_profile&GOTO_main=update_profile"),
				
				array("new_file","mobile_logo",$data['mobile_logo'],"לוגו למובייל", "new_images/".$data['id'], "&table=user_guide_business&GOTO_type=update_profile&GOTO_main=update_profile"),
				
				array("new_file","img3",$data['img3'],"תמונה נוספת", "new_images/".$data['id'], "&table=user_guide_business&GOTO_type=update_profile&GOTO_main=update_profile"),
				
				array("textarea","data_arr[summery]",$data['summery'],"שירותי העסק", "class='input_style' style='width: 300px; height: 100px;'"),
				array("textarea","data_arr[description]",$data['description'],"פרופיל", "class='input_style' style='width: 300px; height: 300px;'"),
				array("text","data_arr[video_code]",$data['video_code'],"וידיאו", "class='input_style'"),
				
				
				array("submit","submit",$word[LANG]['submit_form'], "class='submit_style'")
			);
	$more = "class='maintext'";
	
	echo FormCreator::create_form($form_arr,"index.php", $more, $mandatory_fields);
}
else
{
	$sql = "select * from users where deleted = '0' and status = '0' and unk = '".$_REQUEST['unk']."'";
	$res = mysql_db_query(DB,$sql);
	$data = mysql_fetch_array($res);
	
	$gender[1] = $word[LANG]['male'];
	$gender[2] = $word[LANG]['female'];
	
	
	$city_combo = "<table border=\"0\" cellspacing=\"0\" cellpadding=\"0\" class=\"maintext\">
			<tr>
				<td>".$word[LANG]['city']."</td>
				<td width=\"48\"></td>
				<td>";
					$city_combo .= "<span style=\"behavior:url(options.htc); width:1px;\">";
							$city_combo .= "<select name=\"data_arr[city]\" class=\"input_style\">";
							$city_combo .= "<option value=\"\">".$word[LANG]['choose']."</option>";
								
								$sql = "select id,name from cities order by name";
								$res_city = mysql_db_query(DB,$sql);
								
								while($data_city = mysql_fetch_array($res_city))	{
									$checked_city = ($data['city'] == $data_city['id'])? " selected" : "";
									$city_combo .= "<option value=\"".$data_city['id']."\"".$checked_city.">".stripslashes($data_city['name'])."</option>";
								}
							$city_combo .= "</select>";
						$city_combo .= "</span>
					</td>
				</tr>
			</table>";
			
	
	$form_arr = array(
		array("hidden","main","DB_update_profile"),
		array("hidden","type","update_profile"),
		array("hidden","record_id",$data['id']),
		array("hidden","sesid",$_REQUEST['sesid']),
		array("hidden","unk",$_REQUEST['unk']),
		
		array("text","data_arr[full_name]",$data['full_name'],"* " . $word[LANG]['full_name'] , "class='input_style'","","1"),
		array("text","data_arr[name]",$data['name'],"* " . $word[LANG]['business_name'] , "class='input_style'","","1"),
		//array("text","data_arr[city]",$data['city'],"עיר", "class='input_style'","","1"),
		array("blank",$city_combo),
		array("text","data_arr[address]",$data['address'],$word[LANG]['address'], "class='input_style'","","1"),
		array("text","data_arr[email]",$data['email'],"* ".$word[LANG]['email'], "class='input_style'","","1"),
		array("text","data_arr[phone]",$data['phone'],"* ".$word[LANG]['phone'], "class='input_style'","","1"),
		array("text","data_arr[fax]",$data['fax'],$word[LANG]['fax'], "class='input_style'","","1"),
		
		array("select","gender[]",$gender,$word[LANG]['gender'],$data['gender'],"data_arr[gender]", "class='input_style''"),
		
		array("date","birthday",$data['birthday'],"תאריך לידה <font style=\"font-size:9px;\" class=\"maintext_small\">dd-mm-yyyy</font>", "class='input_style'","hidden"),
		array("submit","submit",$word[LANG]['save'], "class='submit_style'")
	);
	
	// שדות חובה
	$mandatory_fields = array("data_arr[full_name]","data_arr[name]","data_arr[email]","data_arr[phone]");
	$more = "class='maintext'";
	
	echo FormCreator::create_form($form_arr,"index.php", $more, $mandatory_fields);
}

}
/*****************************************************************************************************/

function DB_update_profile()	{

if( UNK == "263512086634836547" && AUTH_ID != 0 )
{
			$image_settings = array(
				"after_success_goto" => "DO_NOTHING",
				"table_name" => "user_guide_business",
			);
			$data_arr = ($_POST['data_arr'])? $_POST['data_arr'] : $_GET['data_arr'];
			
			update_db($data_arr, $image_settings);
			$record_id = $_POST['record_id'];
			
			
			$sql = "SELECT domain FROM users WHERE unk = '".UNK."' ";
			$res = mysql_db_query(DB,$sql);
			$userData = mysql_fetch_array($res);
			
			$server_path = "/home/ilan123/domains/".$userData['domain']."/public_html/new_images/";
			
			if($_FILES)
			{
				GlobalFunctions::create_dir_s($server_path,$record_id);
				
				$server_path .= $record_id."/";
				
				upload_quide_img( "img1" , "negev" , $server_path , "600" , "600" , $record_id );
				upload_quide_img( "img2" , "bikor" , $server_path , "600" , "600" , $record_id );
				upload_quide_img( "logo" , "logo" , $server_path , "250" , "250" , $record_id );
				upload_quide_img( "mobile_logo" , "mobile_logo" , $server_path , "250" , "250" , $record_id );				
				upload_quide_img( "img3" , "img3" , $server_path , "200" , "170" , $record_id , "1" );
			}
			
			
			$sql = "delete from user_guide_choosen_biz_guide where biz_id = '".$record_id."'";
			$res_del = mysql_db_query(DB,$sql);
			
			foreach( $_POST['guide_id'] as $val => $key )
			{
				$sql = "insert into user_guide_choosen_biz_guide ( biz_id , guide_id ) values ( '".$record_id."' , '".$key."' )";
				$res_insert = mysql_db_query(DB,$sql);
			}
			
			$sql = "delete from user_guide_choosen_biz_city where biz_id = '".$record_id."'";
			$res_del = mysql_db_query(DB,$sql);
			
			foreach( $_POST['cities'] as $val => $key )
			{
				$sql = "insert into user_guide_choosen_biz_city ( biz_id , city_id ) values ( '".$record_id."' , '".$key."' )";
				$res_insert2 = mysql_db_query(DB,$sql);
			}
	echo "<META HTTP-EQUIV=Refresh CONTENT=\"0; URL=index.php?main=update_profile&type=update_profile&unk=".UNK."&sesid=".SESID."\">";
	exit;
}
else
{
	$image_settings = array(
		after_success_goto=>"index.php?main=update_profile&type=update_profile&unk=".$_REQUEST['unk']."&sesid=".$_REQUEST['sesid'],
		table_name=>"users",
		flip_date_to_original_format=>array("birthday"),
	);
	$data_arr = ($_POST['data_arr'])? $_POST['data_arr'] : $_GET['data_arr'];
	update_db($data_arr, $image_settings);
}

}


function ecom_settings()
{
	global $word;
	
	$sql = "SELECT belongTo10service FROM user_extra_settings WHERE unk = '".$_REQUEST['unk']."' ";
	$resUsers = mysql_db_query(DB,$sql);
	$dataUsers = mysql_fetch_array($resUsers);
	
	
	$sql = "select * from user_ecom_settings where unk = '".$_REQUEST['unk']."' order by id desc limit 1";
	$res = mysql_db_query(DB,$sql);
	$data = mysql_fetch_array($res);
	
	
	if( $dataUsers['belongTo10service'] == "1" )
	{
		$doDelivery_10service[0] = "לא";
		$doDelivery_10service[1] = "כן";
		$doDelivery_10service_arr = array("select","doDelivery_10service[]",$doDelivery_10service,"האם יינתן משלוחים עד הבית לקוני שירות 10 מחיר 10",$data['doDelivery_10service'],"data_arr[doDelivery_10service]", "class='input_style'");
		
		$pay_delivery_10service_arr = array("text","data_arr[pay_delivery_10service]",$data['pay_delivery_10service'],"מחיר משלוח לקוני שירות 10 מחיר 10", "class='input_style'");
		
	}
	
	
	$form_arr = array(
		array("hidden","main","DB_update_ecom_settings"),
		array("hidden","type",$_POST['type']),
		array("hidden","record_id",$data['id']),
		array("hidden","sesid",$_REQUEST['sesid']),
		array("hidden","unk",$_REQUEST['unk']),
		array("hidden","data_arr[unk]",$_REQUEST['unk']),
		
		array("textarea","data_arr[textarea_content]",$data['textarea_content'],"טקסט מיוחד בטופס שליחת המוצרים בקופה", "class='input_style' style='height: 150px;'","","1"),
		array("text","data_arr[delivery_pay]",$data['delivery_pay'],"* מחיר שליחה במידה וקיים (0 במידה ולא קיים)", "class='input_style'","","1"),
		$doDelivery_10service_arr,$pay_delivery_10service_arr,
		
		array("submit","submit","שמירה", "class='submit_style'")
	);
	
// שדות חובה
$mandatory_fields = array("data_arr[delivery_pay]");
$more = "class='maintext'";

echo FormCreator::create_form($form_arr,"index.php", $more, $mandatory_fields);
}


function DB_update_ecom_settings()
{
	$image_settings = array(
		after_success_goto=>"index.php?main=ecom_settings&type=ecom_settings&unk=".$_POST['unk']."&sesid=".$_POST['sesid'],
		table_name=>"user_ecom_settings",
	);
	$data_arr = ($_POST['data_arr'])? $_POST['data_arr'] : $_GET['data_arr'];
	if( empty($_POST['record_id']) )
		insert_to_db($data_arr, $image_settings);
	else
		update_db($data_arr, $image_settings);
}

function mailinglist()
{
	$sql = "select * from mailinglist where unk = '".$_REQUEST['unk']."'";
	$res = mysql_db_query(DB,$sql);
	
	echo "<table border=\"0\" cellspacing=\"0\" cellpadding=\"0\" class=\"maintext\">";
		echo "<tr>";
			echo "<td><b>אימייל</b></td>";
			echo "<td width='10'></td>";
			echo "<td><b>מחיקה</b></td>";
		echo "</tr>";
		
		while( $data = mysql_fetch_array($res) )
		{
			echo "<tr><td height='4'></td></tr>";
			echo "<tr>";
				echo "<td>".GlobalFunctions::kill_strip($data['email'])."</td>";
				echo "<td width='10'></td>";
				echo "<td><a href='index.php?main=mailinglist_del_mail&re_id=".$data['id']."&type=mailinglist&unk=".$_REQUEST['unk']."&sesid=".$_REQUEST['sesid']."' class='maintext' onclick=\"return can_i_del()\">מחיקה</a></td>";
			echo "</tr>";
		}
	echo "</table>";
}


function mailinglist_del_mail()
{
	$sql = "delete from mailinglist where id = '".$_GET['re_id']."' and unk = '".$_GET['unk']."'";
	$res = mysql_db_query(DB,$sql);
	
	echo "<script>window.location.href='index.php?main=mailinglist&type=mailinglist&unk=".$_GET['unk']."&sesid=".$_GET['sesid']."';</script>";
		exit;
}


function ecomOrders()
{
	
	$limitCount = ( $_GET['limit'] == "" ) ? "0" : $_GET['limit'];
	 
	$ex = explode( "-" , $_GET['sd'] );
	$where = ($_GET['sd'] != "" ) ? " AND o.insert_date >= '".$ex[2]."-".$ex[1]."-".$ex[0]."' " : "";
	$ex2 = explode( "-" , $_GET['ed'] );
	$where .= ($_GET['ed'] != "" ) ? " AND o.insert_date <= '".$ex2[2]."-".$ex2[1]."-".$ex2[0]."' " : "";
	
	$where .= ($_GET['prod_val'] != "" ) ? " AND p.name LIKE '%".$_GET['prod_val']."%' " : "";
	
	$where .= ($_GET['s_id'] != "" ) ? " AND o.id = '".$_GET['s_id']."' " : "";
	
	 
	//LIMIT ".$limitCount.",50
	$sql = "select o.* FROM user_ecom_orders as o , user_ecom_items as i , user_products as p  WHERE 
		o.unk = '".$_REQUEST['unk']."' and 
		o.client_unickSes=i.client_unickSes AND
		o.unk=i.unk AND
		i.product_id=p.id AND
		o.deleted = '0' ".$where."
		GROUP BY o.id ORDER BY id DESC ";
	$res = mysql_db_query(DB,$sql);
	
	
	echo "<table border=\"0\" cellspacing=\"0\" cellpadding=\"0\" class=\"maintext\">";
		
		echo "<tr>";
			echo "<td colspan=15>";
				echo "<form action='index.php' name='conatct_search' method='get' style=''padding:0; margin:0;>";
					echo "<input type='hidden' name='main' value='ecomOrders'>";
					echo "<input type='hidden' name='type' value='ecomOrders'>";
					echo "<input type='hidden' name='unk' value='".UNK."'>";
					echo "<input type='hidden' name='sesid' value='".SESID."'>";
					echo "<table border=\"0\" cellspacing=\"0\" cellpadding=\"0\" class=\"maintext\">";
						echo "<tr>";
							echo "<td>מתאריך (כולל):</td>";
							echo "<td width='10'></td>";
							echo "<td><input type=text name='sd' value='".$_GET['sd']."' class='input_style' style='width: 80px;'> mm-dd-yyy</td>";
							echo "<td width='30'></td>";
							echo "<td>עד לתאריך (לא כולל):</td>";
							echo "<td width='10'></td>";
							echo "<td><input type=text name='ed' value='".$_GET['ed']."' class='input_style' style='width: 80px;'> mm-dd-yyy</td>";
						echo "</tr>";
						echo "<tr><td colspan=7 height=5></td></tr>";
						echo "<tr>";
							echo "<td>שם הקונה:</td>";
							echo "<td width='10'></td>";
							echo "<td><input type=text name='val' value='".$_GET['val']."' class='input_style' style='width: 80px;'></td>";
							echo "<td width='30'></td>";
							echo "<td>שם המוצר</td>";
							echo "<td width='10'></td>";
							echo "<td><input type=text name='prod_val' value='".$_GET['prod_val']."' class='input_style' style='width: 80px;'></td>";
						echo "</tr>";
						echo "<tr><td colspan=7 height=5></td></tr>";
						echo "<tr>";
							echo "<td>מספר הזמנה</td>";
							echo "<td width='10'></td>";
							echo "<td><input type=text name='s_id' value='".$_GET['s_id']."' class='input_style' style='width: 80px;'></td>";
							echo "<td width='30'></td>";
							echo "<td><input type='submit' class='submit_style' value='חפש!' style='width: 80px;'></td>";
							echo "<td width='10'></td>";
							echo "<td align=left><a href='getExcelEcomOrders.php?unk=".$_GET['unk']."&sesid=".$_GET['sesid']."&sd=".$_GET['sd']."&ed=".$_GET['ed']."&prod_val=".$_GET['prod_val']."&s_id=".$_GET['s_id']."' target='_blank'><img src='images/Excel_32.png' border=0 alt='יצוא לאקסל' /></td>";
						echo "</tr>";
					echo "</table>";
					echo "</form>";
			echo "</td>";
		echo "</tr>";
		
		
		echo "<tr>";
			echo "<td>מספר הזמנה</td>";
			echo "<td width='15'></td>";
			echo "<td></td>";
			echo "<td width='15'></td>";
			echo "<td><b>שם הקונה</b></td>";
			echo "<td width='15'></td>";
			echo "<td><b>התשלום</b></td>";
			echo "<td width='15'></td>";
			echo "<td><b>סטטוס עבודה</b></td>";
			echo "<td width='15'></td>";
			echo "<td><b>צפייה בהזמנה</b></td>";
			echo "<td width='15'></td>";
			echo "<td><b>מחיקה</b></td>";
		echo "</tr>";
		
		while( $data = mysql_fetch_array($res) )
		{
			$total_price_to_pay = 0;
			
			if( $data['netEcomSyncId'] != "0" )
			{
				$sql = "SELECT userSes from net_ecomCards_users_belong WHERE id = '".$data['netEcomSyncId']."' AND ecomSes = '".$data['client_unickSes']."' ";
				$resCleint = mysql_db_query(DB,$sql);
				$dataCleint2 = mysql_fetch_array($resCleint);
				
				$sql = "select id,CONCAT( fname, ' ' , lname) AS full_name from net_users where unick_ses = '".$dataCleint2['userSes']."'";
				$resCleint = mysql_db_query(DB,$sql);
				$dataCleint = mysql_fetch_array($resCleint);
			}
			else
			{
				$sql = "select id,full_name from user_clients where unk = '".$_REQUEST['unk']."' and id = '".$data['client_id']."'";
				$resCleint = mysql_db_query(DB,$sql);
				$dataCleint = mysql_fetch_array($resCleint);
			}
			
			$sql = "select product_id from user_ecom_items where unk = '".$_REQUEST['unk']."' and status=0 AND client_unickSes = '".$data['client_unickSes']."' GROUP BY product_id";
			$resItems = mysql_db_query(DB,$sql);
			
			while( $dataItems = mysql_fetch_array($resItems) )
			{
				$sql = "select price from user_products where id = '".$dataItems['product_id']."'";
				$resPrice = mysql_db_query(DB,$sql);
				$dataPrice = mysql_fetch_array($resPrice);
				
				$sql = "select id from user_ecom_items where unk = '".$_REQUEST['unk']."' and status=0 AND client_unickSes = '".$data['client_unickSes']."' and product_id = '".$dataItems['product_id']."'";
				$resQry = mysql_db_query(DB,$sql);
				$qry_nm = mysql_num_rows($resQry);
				
				$total_price_to_pay = $total_price_to_pay + ( $dataPrice['price'] * $qry_nm );
			}
			
			$whereName = ($_GET['val'] != "" ) ? " AND ( ( u.fname LIKE '%".mysql_r_e_s($_GET['val'])."%' ) OR ( u.lname LIKE '%".mysql_r_e_s($_GET['val'])."%' ) )" : "";
			
			
			if( $_GET['val'] == "" OR eregi( $_GET['val'] , $dataCleint['full_name'] )  )
			{
			
			$work_status = ( $data['status'] == "0" ) ? "פנייה חדשה": "";
			$work_status = ( $data['status'] == "1" ) ? "מחכה לטלפון": $work_status;
			$work_status = ( $data['status'] == "2" ) ? "פנייה בטיפול": $work_status;
			$work_status = ( $data['status'] == "3" ) ? "סגור - מחכה למוצר": $work_status;
			$work_status = ( $data['status'] == "4" ) ? "סגור - קיבל מוצר": $work_status;
			$work_status = ( $data['status'] == "5" ) ? "פנייה מבוטלת": $work_status;
			$work_status = ( $data['status'] == "6" ) ? "לא רלוונטי": $work_status;
			
			echo "<tr><td colspan=13 height='5'></td></tr>";
			echo "<tr><td colspan=13><hr width='100%' color='#b3b3b3' size='1'></td></tr>";
			echo "<tr><td colspan=13 height='5'></td></tr>";
			echo "<tr>";
				echo "<td>".$data['id']."</td>";
				echo "<td width='15'></td>";
				echo "<td>".GlobalFunctions::show_dateTime_field($data['insert_date'])."</td>";
				echo "<td width='15'></td>";
				if( $data['netEcomSyncId'] != "0" ) 
					echo "<td><a href='index.php?main=net_user_details&type=net&user_id=".$dataCleint['id']."&unk=".$_REQUEST['unk']."&sesid=".$_REQUEST['sesid']."' class='maintext' target='_blank'>".GlobalFunctions::kill_strip($dataCleint['full_name'])."</a></td>";
				else
					echo "<td><a href='index.php?main=get_create_form&type=myClients&row_id=".$dataCleint['id']."&unk=".$_REQUEST['unk']."&sesid=".$_REQUEST['sesid']."' class='maintext' target='_blank'>".GlobalFunctions::kill_strip($dataCleint['full_name'])."</a></td>";
				echo "<td width='15'></td>";
				echo "<td>".$total_price_to_pay."</td>";
				echo "<td width='15'></td>";
				echo "<td>".$work_status."</td>";
				echo "<td width='15'></td>";
				echo "<td><a href='?main=ecomOrderView&type=ecomOrders&re_id=".$data['id']."&unickSes=".$data['client_unickSes']."&unk=".$_REQUEST['unk']."&sesid=".$_REQUEST['sesid']."' class='maintext'>צפייה בהזמנה</a></td>";
				echo "<td width='15'></td>";
				echo "<td><a href='?main=ecomOrderDel&table=user_ecom_orders&type=ecomOrders&row_id=".$data['id']."&unk=".$_REQUEST['unk']."&sesid=".$_REQUEST['sesid']."' class='maintext' onclick=\"return can_i_del()\">מחיקה</a></td>";
			echo "</tr>";
			}
		}
		
		
		/*echo "<tr><td colspan=15 height=15></td></tr>";
		echo "<tr>";
			echo "<td colspan=15 align=center>סך הכל הזמנות: ".$num_rows."</td>";
		echo "</tr>";
		echo "<tr><td colspan=15 height=15></td></tr>";
		echo "<tr>";
			echo "<td colspan=15 align=center style=\"border-top: 1px solid #".$data_colors['border_color'].";\">";	
				$params['limitInPage'] = "50";
				$params['numRows'] = $num_rows;
				$params['limitcount'] = $limitCount;
				$params['main'] = $_GET['main'];
				$params['type'] = $_GET['type'];
				
				getLimitPagentionAdmin( $params );
				
			echo "</td>";
		echo "</tr>";
		*/
	echo "</table>";
}


function ecomOrderView()
{
	$sql = "select product_id from user_ecom_items where unk = '".$_REQUEST['unk']."' and status=0 AND client_unickSes = '".$_GET['unickSes']."' GROUP BY product_id";
	$res = mysql_db_query(DB,$sql);
	$num_rows = mysql_num_rows($res);
	
	$sql = "select * from user_ecom_orders where unk = '".$_REQUEST['unk']."' and deleted = '0' and client_unickSes = '".$_GET['unickSes']."'";
	$resDetail = mysql_db_query(DB,$sql);
	$dataDetail = mysql_fetch_array($resDetail);
	
	$total_price_to_pay = 0;
	
	echo "<table border=\"0\" cellspacing=\"0\" cellpadding=\"0\" class=\"maintext\">";
		
		/// E-COM cart details
		echo "<tr>";
			echo "<td>";
				echo "<table border=\"0\" cellspacing=\"0\" cellpadding=\"0\" class=\"maintext\">";
					echo "<tr>";
						echo "<td><b>שם המוצר</b></td>";
						echo "<td width=10></td>";
						echo "<td><b>מס' קטלוגי</b></td>";
						echo "<td width=10></td>";
						echo "<td><b>מחיר ליחידה</b></td>";
						echo "<td width=10></td>";
						echo "<td><b>כמות</b></td>";
					echo "</tr>";
					
					echo "<tr><td colspan=7 height=7></td></td>";
					
					while( $data = mysql_fetch_array($res) )
					{
						$sql = "select name,price,makat from user_products where id = '".$data['product_id']."'";
						$res2 = mysql_db_query(DB,$sql);
						$data2 = mysql_fetch_array($res2);
						
						$sql = "select id from user_ecom_items where unk = '".$_REQUEST['unk']."' and status=0 AND client_unickSes = '".$_GET['unickSes']."' and product_id = '".$data['product_id']."'";
						$res3 = mysql_db_query(DB,$sql);
						$qry_nm = mysql_num_rows($res3);
						
						
						echo "<tr>";
							echo "<td>".GlobalFunctions::kill_strip($data2['name'])."</td>";
							echo "<td width=10></td>";
							echo "<td>".GlobalFunctions::kill_strip($data2['makat'])."</td>";
							echo "<td width=10></td>";
							echo "<td>".GlobalFunctions::kill_strip($data2['price'])."</td>";
							echo "<td width=10></td>";
							echo "<td>".$qry_nm."</td>";
						echo "</tr>";
						echo "<tr><td colspan=7 height=5></td></td>";
						$total_price_to_pay = $total_price_to_pay + ( $data2['price'] * $qry_nm );
					}
					$sum_tot = $dataDetail['delivery_pay'] + $total_price_to_pay;
						echo "<tr><td colspan=7 height=5></td></td>";
						echo "<tr><td colspan=7><hr width='100%' color='#b3b3b3' size='1'></td></tr>";
						echo "<tr><td colspan=7 height=5></td></td>";
						echo "<tr>";
							echo "<td colspan=7>";
								echo "<table border=\"0\" cellspacing=\"0\" cellpadding=\"0\" class=\"maintext\">";
									echo "<tr>";
										echo "<td><b>סך הכל:</b> ".$total_price_to_pay."</td>";
										echo "<td width=30></td>";
										echo "<td><b>דמי משלוח:</b> ".GlobalFunctions::kill_strip($dataDetail['delivery_pay'])."</td>";
									echo "</tr>";
								echo "</table>";
							echo "</td>";
						echo "</tr>";
						echo "<tr><td colspan=7 height=5></td></td>";
					
				echo "</table>";
			echo "</td>";
		echo "</tr>";
		
		echo "<tr><td height=15></td></td>";
		
		echo "<tr>";
			echo "<td><B>מספר הזמנה:</B> ".$dataDetail['id']."</td>";
		echo "</tr>";
		echo "<tr><td height=10></td></td>";
		echo "<tr>";
			echo "<td><B>תאריך שליחה:</B> ".GlobalFunctions::show_dateTime_field($dataDetail['insert_date'])."</td>";
		echo "</tr>";
		echo "<tr><td height=10></td></td>";
		echo "<tr>";
			echo "<td><b>כולל דמי משלוח:</b> ".$sum_tot."</td>";
		echo "</tr>";
		
		if( $dataDetail['content'] != "" )
		{
			echo "<tr><td height=5></td></td>";
			echo "<tr><td><hr width='100%' color='#b3b3b3' size='1'></td></tr>";
			echo "<tr><td height=5></td></td>";
			echo "<tr>";
				echo "<td><b>הערות נוספות:</b><br> ".nl2br(GlobalFunctions::kill_strip($dataDetail['content']))."</td>";
			echo "</tr>";
		}
		
		if( UNK == "038157696328808156" ) 
		{
			$file_name = GlobalFunctions::show_dateTime_field($dataDetail['insert_date']);
			echo "<tr><td height=15></td></td>";
			echo "<tr>";
				echo "<td><a href='http://www.ilbiz.co.il/newsite/net_system/castum/chip.haari/ecomHtmlPage.php?unk=".UNK."&sesid=".SESID."&unickSes=".$_GET['unickSes']."&ecomId=".$dataDetail['id']."' class='maintext' target='_blank'>צפה בעמוד HTML</a><br>
				<a href='http://www.ilbiz.co.il/newsite/net_system/castum/chip.haari/ecomHtmlPage.php?unk=".UNK."&sesid=".SESID."&unickSes=".$_GET['unickSes']."&ecomId=".$dataDetail['id']."&downloadIT=1&createName=".$file_name."' class='maintext' target='_blank'>הורדת עמוד HTML</a></td>";
			echo "</tr>";
		}
		
		echo "<tr><td height=10></td></td>";
		echo "<tr><td><hr width='100%' color='#b3b3b3' size='1'></td></tr>";
		echo "<tr><td height=10></td></td>";
		
		if( $dataDetail['netEcomSyncId'] != "0" )
		{
			$sql = "SELECT userSes from net_ecomCards_users_belong WHERE id = '".$dataDetail['netEcomSyncId']."' AND ecomSes = '".$dataDetail['client_unickSes']."' ";
			$resCleint = mysql_db_query(DB,$sql);
			$dataCleint2 = mysql_fetch_array($resCleint);
			
			$sql = "select *,CONCAT( fname, ' ' , lname) AS full_name from net_users where unick_ses = '".$dataCleint2['userSes']."'";
			$resCleint = mysql_db_query(DB,$sql);
			$dataUserDetail = mysql_fetch_array($resCleint);
		}
		else
		{
			
			$sql = "select * from user_clients where unk = '".$_REQUEST['unk']."' and id = '".$dataDetail['client_id']."'";
			$resUserDetail = mysql_db_query(DB,$sql);
			$dataUserDetail = mysql_fetch_array($resUserDetail);
		}
		
		$sql = "SELECT date_in, name, id FROM user_contact_forms WHERE unk = '".$_REQUEST['unk']."' AND ( ( name LIKE '%".$dataUserDetail['full_name']."%' ) OR ( content LIKE '%".$dataUserDetail['full_name']."%' ) )";
		$resContact = mysql_db_query(DB,$sql);
		$num_rows = mysql_num_rows($resContact);
		
		if( $num_rows > 0 )
		{
			// contact user details
			echo "<tr>";
				echo "<td><b>רשימת טפסי צור קשר של רלוונטים:</b></td>";
			echo "</tr>";
			echo "<tr><td height=10></td></td>";
			echo "<tr>";
				echo "<td>";
					echo "<table border=\"0\" cellspacing=\"0\" cellpadding=\"0\" class=\"maintext\">";
						while( $dataContact = mysql_fetch_array($resContact) )
						{
							echo "<tr>";
								echo "<td>תאריך פנייה: </td>";
								echo "<td width=10></td>";
								echo "<td>".GlobalFunctions::show_dateTime_field($dataUserDetail['date_in'])."</td>";
								echo "<td width=10></td>";
								echo "<td><a href='index.php?main=get_create_form&type=contact&row_id=".$dataContact['id']."&unk=".UNK."&sesid=".SESID."' target='_blank' class='maintext'>לפרטים המלאים</a></td>";
							echo "</tr>";
						}
					echo "</table>";
				echo "</td>";
			echo "</tr>";
			
			echo "<tr><td height=15></td></td>";
			echo "<tr><td><hr width='100%' color='#b3b3b3' size='1'></td></tr>";
			echo "<tr><td height=15></td></td>";
		}
		
		
		
		/// E-COM user details
		echo "<tr>";
			echo "<td>";
				echo "<table border=\"0\" cellspacing=\"0\" cellpadding=\"0\" class=\"maintext\">";
					echo "<tr>";
						echo "<td><b>שם מלא</b></td>";
						echo "<td width=10></td>";
						echo "<td>".GlobalFunctions::kill_strip($dataUserDetail['full_name'])."</td>";
					echo "</tr>";
					echo "<tr><td colspan=3 height=4></td></td>";
					echo "<tr>";
						echo "<td><b>אימייל</b></td>";
						echo "<td width=10></td>";
						echo "<td>".GlobalFunctions::kill_strip($dataUserDetail['email'])."</td>";
					echo "</tr>";
					echo "<tr><td colspan=3 height=4></td></td>";
					echo "<tr>";
						echo "<td><b>טלפון</b></td>";
						echo "<td width=10></td>";
						echo "<td>".GlobalFunctions::kill_strip($dataUserDetail['phone'])."</td>";
					echo "</tr>";
					echo "<tr><td colspan=3 height=4></td></td>";
					echo "<tr>";
						echo "<td><b>נייד</b></td>";
						echo "<td width=10></td>";
						echo "<td>".GlobalFunctions::kill_strip($dataUserDetail['mobile'])."</td>";
					echo "</tr>";
					echo "<tr><td colspan=3 height=4></td></td>";
					echo "<tr>";
						echo "<td><b>עיר</b></td>";
						echo "<td width=10></td>";
						if( $dataDetail['netEcomSyncId'] != "0" )
						{
							$sql = "SELECT name FROM cities WHERE id = '".$dataUserDetail['city']."'";
							$res = mysql_db_query(DB, $sql );
							$dataCity = mysql_fetch_array($res);
							
							echo "<td>".GlobalFunctions::kill_strip($dataCity['name'])."</td>";
						}
						else
							echo "<td>".GlobalFunctions::kill_strip($dataUserDetail['city'])."</td>";
					echo "</tr>";
					echo "<tr><td colspan=3 height=4></td></td>";
					echo "<tr>";
						echo "<td><b>רחוב</b></td>";
						echo "<td width=10></td>";
						echo "<td>".GlobalFunctions::kill_strip($dataUserDetail['address'])."</td>";
					echo "</tr>";
					echo "<tr><td colspan=3 height=4></td></td>";
					echo "<tr>";
						echo "<td colspan=3>";
							if( $dataDetail['netEcomSyncId'] != "0"  ) 
								echo "<a href='index.php?main=net_user_details&type=net&user_id=".$dataUserDetail['id']."&unk=".$_REQUEST['unk']."&sesid=".$_REQUEST['sesid']."' class='maintext' target='_blank'>צפייה בכרטיס חבר</a>";
							else
								echo "<a href='index.php?main=get_create_form&type=myClients&row_id=".$dataUserDetail['id']."&unk=".$_REQUEST['unk']."&sesid=".$_REQUEST['sesid']."' class='maintext' target='_blank'>עדכון פרטים</a>";
						echo "</td>";
					echo "</tr>";
				echo "</table>";
			echo "</td>";
		echo "</tr>";
		
		echo "<tr><td height=15></td></td>";
		echo "<tr><td><hr width='100%' color='#b3b3b3' size='1'></td></tr>";
		echo "<tr><td height=15></td></td>";
		
		echo "<tr>";
			echo "<td>";
				echo "<table border=\"0\" cellspacing=\"0\" cellpadding=\"0\" class=\"maintext\">";
					echo "<form action='?' name='formi' method='POST'>";
					echo "<input type='hidden' name='main' value='ecomOrder_statusDB'>";
					echo "<input type='hidden' name='type' value='ecomOrders'>";
					echo "<input type='hidden' name='unk' value='".$_GET['unk']."'>";
					echo "<input type='hidden' name='id' value='".$dataDetail['id']."'>";
					echo "<input type='hidden' name='sesid' value='".$_GET['sesid']."'>";
					echo "<input type='hidden' name='unickSes' value='".$_GET['unickSes']."'>";
					echo "<tr>";
						echo "<td><b>עדכון סטטוס</b></td>";
						echo "<td width='15'></td>";
						echo "<td>";
							
							$selected0 = ( $dataDetail['status'] == "0" ) ? "selected": "";
							$selected1 = ( $dataDetail['status'] == "1" ) ? "selected": "";
							$selected2 = ( $dataDetail['status'] == "2" ) ? "selected": "";
							$selected3 = ( $dataDetail['status'] == "3" ) ? "selected": "";
							$selected4 = ( $dataDetail['status'] == "4" ) ? "selected": "";
							$selected5 = ( $dataDetail['status'] == "5" ) ? "selected": "";
							$selected6 = ( $dataDetail['status'] == "6" ) ? "selected": "";
							
							echo "<select name='new_status' class='input_style' onChange='formi.submit()'>";
								echo "<option value='0' ".$selected0.">פנייה חדשה</option>";
								echo "<option value='1' ".$selected1.">מחכה לטלפון</option>";
								echo "<option value='2' ".$selected2.">פנייה בטיפול</option>";
								echo "<option value='3' ".$selected3.">סגור - מחכה למוצר</option>";
								echo "<option value='4' ".$selected4.">סגור - קיבל מוצר</option>";
								echo "<option value='5' ".$selected5.">פנייה מבוטלת</option>";
								echo "<option value='6' ".$selected6.">לא רלוונטי</option>";
							echo "</select>";
						echo "</td>";
					echo "</tr>";
					echo "</form>";
					
				echo "</table>";
			echo "</td>";
		echo "</tr>";
		
	echo "</table>";
}


function ecomOrderDel()
{

	$image_settings = array(
		after_success_goto=>"index.php?main=ecomOrders&type=".$_REQUEST['type']."&unk=".$_REQUEST['unk']."&sesid=".$_REQUEST['sesid'],
		table_name=>$_REQUEST['table'],
	);
	
	delete_record($_REQUEST['row_id'], $image_settings);
}

function ecomOrder_statusDB()
{
	$sql = "update user_ecom_orders set status = '".$_POST['new_status']."' where id = '".$_POST['id']."' and client_unickSes = '".$_POST['unickSes']."'";
	$res = mysql_db_query(DB,$sql);
	
	echo "<script>window.location.href='index.php?main=ecomOrders&type=ecomOrders&unk=".$_POST['unk']."&sesid=".$_POST['sesid']."';</script>";
		exit;
}

function load_editor_file()
{
	$sql = "select editor_type from user_site_settings where deleted = 0 and status != '9' and unk = '".UNK."'";
	$res = mysql_db_query(DB,$sql);
	$data = mysql_fetch_array($res);
	
	if( $data['editor_type'] == "1" )
		include("fckeditor/fckeditor.php") ;
	else
		include_once "ckeditor362/ckeditor.php";
}


function load_editor_text( $name , $value )
{
	$sql = "select editor_type from user_site_settings where deleted = 0 and status != '9' and unk = '".UNK."'";
	$res = mysql_db_query(DB,$sql);
	$data = mysql_fetch_array($res);
	
	if( $data['editor_type'] == "1" )
	{
		$sBasePath = $_SERVER['PHP_SELF'] ;
		//$sBasePath = substr( $sBasePath, 0, strpos( $sBasePath, "_samples" ) ) ;
		$sBasePath = "http://www.ilbiz.co.il/ClientSite/administration/fckeditor/" ;
		
		$oFCKeditor = new FCKeditor($name) ;
		$oFCKeditor->BasePath	= $sBasePath ;
		$oFCKeditor->Value		= $value ;
		$oFCKeditor->Config['AutoDetectLanguage']	= false ;
		$oFCKeditor->Config['DefaultLanguage']		= LANG ;
		$oFCKeditor->Create() ;
	}
	else
	{
		$CKEditor = new CKEditor();
			
		$CKEditor->basePath = '/ClientSite/administration/ckeditor362/';
		$CKEditor->config['width'] = 600;
		$CKEditor->config['language'] = 'he';
		
		// Change default textarea attributes.
		$CKEditor->config['filebrowserBrowseUrl'] = '/ClientSite/administration/kcfinder/browse.php?type=File';
		$CKEditor->config['filebrowserImageBrowseUrl'] = '/ClientSite/administration/kcfinder/browse.php?type=Image';
		$CKEditor->config['filebrowserFlashBrowseUrl'] = '/ClientSite/administration/kcfinder/browse.php?type=Flash';
		$CKEditor->config['filebrowserUploadUrl'] = '/ClientSite/administration/kcfinder/core/upload.php?type=File';
		$CKEditor->config['filebrowserImageUploadUrl'] = '/ClientSite/administration/kcfinder/upload.php?type=Image';
		$CKEditor->config['filebrowserFlashUploadUrl'] = '/ClientSite/administration/kcfinder/upload.php?type=Flash';
		
		// Create the first instance.
		$CKEditor->editor( $name , $value );
	}
}