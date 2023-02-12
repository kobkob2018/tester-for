<?php
/* 
* Copyright © 2006 ILbiz. All Rights Reserved
* email:	webmaster@ilbiz.co.il
*
* 
* in this page you have all the pages function
*/

function homepage()	{

	global $word;
	
	$sql = "select * from user_hp_conf where unk = '".UNK."'";
	$res = mysql_db_query(DB,$sql);
	$data = mysql_fetch_array($res);
	
	$sql = "select id, have_hp_banners,hp_type,hp_text from users where unk = '".UNK."'";
	$res_settings = mysql_db_query(DB,$sql);
	$data_settings = mysql_fetch_array($res_settings);
	
	$sql = "select userCanSEO , haveFacebookHpActive , facebookHpContent from user_extra_settings where unk = '".UNK."'";
	$res_extra_settings = mysql_db_query(DB,$sql);
	$data_extra_settings = mysql_fetch_array($res_extra_settings);
	
	if( $data_settings['have_hp_banners'] == "1" )
	{
		$formats_arr = array(
			"num1" => array($word[LANG]['hp_seder1_1'] , "" ),
			"num7" => array($word[LANG]['hp_seder2_1'] , "" ),
			"num9" => array($word[LANG]['hp_seder3_1'] , "" )
		);
	}
	else
	{
		$formats_arr = array(
			"num1" => array($word[LANG]['hp_seder1_2'] , "" ),
			"num7" => array($word[LANG]['hp_seder2_2'] , "" ),
			"num9" => array($word[LANG]['hp_seder3_2'] , "" )
		);
	}
	
	echo "<table border=\"0\" cellspacing=\"0\" cellpadding=\"0\" class=\"maintext\" width='100%'>";
	echo "<form action=\"index.php\" name=\"editorhtml\" method=\"POST\" enctype=\"multipart/form-data\">";
	echo "<input type=\"hidden\" name=\"main\" value=\"update_hp_conf\">";
	echo "<input type=\"hidden\" name=\"unk\" value=\"".UNK."\">";
	echo "<input type=\"hidden\" name=\"sesid\" value=\"".SESID."\">";
	
		
		echo "<tr><Td height=\"7\" colspan=\"3\"></TD></tr>";
		

		if( $data_settings['hp_type'] == "0" )
		{
			echo "<input type=\"hidden\" name=\"data_arr[unk]\" value=\"".UNK."\">";
			echo "<input type=\"hidden\" name=\"record_id\" value=\"".$data['id']."\">";
			
			echo "<tr><Td colspan=\"3\">".$word[LANG]['hp_choose_view_option']."</TD></tr>";
			
			echo "<tr><Td height=\"7\" colspan=\"3\"></TD></tr>";
			
			$count = 0;
			foreach( $formats_arr as $val => $key )
			{
				if( $count%2 == 0 )
					echo "<tr>";
					
						echo "<td valign=top width=49%>";
							echo "<table border=\"0\" cellspacing=\"0\" cellpadding=\"0\">";
								echo "<tr>";
									$checked = ( $data['format'] == $val ) ? "checked" : "";
									echo "<td valign=top><input type='radio' name='format' value='".$val."' ".$checked."></td>";
									echo "<td valign=top>";
										echo "<table border=\"0\" cellspacing=\"0\" cellpadding=\"0\" class='maintext'>";
											foreach( $key as $val2 )
											{
												echo "<tr>";
													echo "<td>".$val2."</td>";
												echo "</tr>";
												echo "<tr><td height=5></td></tr>";
											}
										echo "</table>";
									echo "</td>";
								echo "</tr>";
								echo "<tr><td height=10 colsapn=2></td></tr>";
							echo "</table>";
						echo "</td>";
				$count++;
				if( $count%2 == 0 )	
					echo "</tr>";
				else
					echo "<td width=2%></td>";
			}
			
			
			if( $data_settings['have_hp_banners'] == "1" )
			{
				echo "<tr><Td height=\"20\" colspan=\"3\"></TD></tr>";
				
				echo "<tr><Td colspan=\"3\">".$word[LANG]['hp_uploads_banners']."</TD></tr>";
				
				echo "<tr><Td height=\"7\" colspan=\"3\"></TD></tr>";
				
				echo "<tr>";
					echo "<td colspan=3>";
						echo "<table border=\"0\" cellspacing=\"0\" cellpadding=\"0\" class='maintext'>";
							
							echo "<tr>";
							
							$abpath_temp = SERVER_PATH."/tamplate/".$data['adv_banner_1'];
								if( file_exists($abpath_temp) && !is_dir($abpath_temp) )
									$details_img = "&nbsp;&nbsp;<a href=\"".HTTP_PATH."/tamplate/".$data['adv_banner_1']."\" class=\"maintext_small\" target=\"_blank\">".$word[LANG]['view']."</a>
									&nbsp;&nbsp;|&nbsp;&nbsp;<a href=\"index.php?main=del_img_DB_FTP&table=user_hp_conf&GOTO_type=&GOTO_main=homepage&field_name=adv_banner_1&sesid=".SESID."&unk=".UNK."&path=tamplate/&img=".$data['adv_banner_1']."\" class=\"maintext_small\" onclick=\"return can_i_del()\">".$word[LANG]['delete']." </a>";
								
								echo "<td>*".$word[LANG]['hp_banner1']."</td>";
								echo "<td width=10></td>";
								echo "<td><input type='file' name='adv_banner_1' class='input_style'>".$details_img."</td>";
							echo "</tr>";
							echo "<tr><Td height=\"5\" colspan=\"3\"></TD></tr>";
							
							echo "<tr>";
								echo "<td>".$word[LANG]['hp_banner1_width']."</td>";
								echo "<td width=10></td>";
								echo "<td><input type='text' name='adv_banner_1_width' value='".$data['adv_banner_1_width']."' class='input_style'></td>";
							echo "</tr>";
							echo "<tr><Td height=\"5\" colspan=\"3\"></TD></tr>";
							echo "<tr>";
								echo "<td>".$word[LANG]['hp_banner1_height']."</td>";
								echo "<td width=10></td>";
								echo "<td><input type='text' name='adv_banner_1_height' value='".$data['adv_banner_1_height']."' class='input_style'></td>";
							echo "</tr>";
							echo "<tr><Td height=\"20\" colspan=\"3\"></TD></tr>";
							echo "<tr>
								<Td colspan=3>".$word[LANG]['hp_banner2_note']."</td>
							</tr>";
							echo "<tr><Td height=\"2\" colspan=\"3\"></TD></tr>";
							echo "<tr>";
							$abpath_temp = SERVER_PATH."/tamplate/".$data['adv_banner_2'];
								if( file_exists($abpath_temp) && !is_dir($abpath_temp) )
									$details_img2 = "&nbsp;&nbsp;<a href=\"".HTTP_PATH."/tamplate/".$data['adv_banner_2']."\" class=\"maintext_small\" target=\"_blank\">".$word[LANG]['view']."</a>
									&nbsp;&nbsp;|&nbsp;&nbsp;<a href=\"index.php?main=del_img_DB_FTP&table=user_hp_conf&GOTO_type=&GOTO_main=homepage&field_name=adv_banner_2&sesid=".SESID."&unk=".UNK."&path=tamplate/&img=".$data['adv_banner_2']."\" class=\"maintext_small\" onclick=\"return can_i_del()\">".$word[LANG]['delete']." </a>";
								
								echo "<td>**".$word[LANG]['hp_banner2']."</td>";
								echo "<td width=10></td>";
								echo "<td><input type='file' name='adv_banner_2' class='input_style'>".$details_img2."</td>";
							echo "</tr>";
						echo "</table>";
					echo "</td>";
				echo "</tr>";
				echo "<input type='hidden' name='upload_banners' value='1'>";
			}
			
			if( $data_extra_settings['haveFacebookHpActive'] == "1" )
			{
				$arr = facebook_modols();
				
				echo "<tr><Td height=\"20\" colspan=\"3\"></TD></tr>";
				
				echo "<tr>";
					echo "<td colspan=3>";
						echo "<table border=\"0\" cellspacing=\"0\" cellpadding=\"0\" class='maintext'>";
							
							echo "<tr>";
								echo "<td colspan=3>אנא בחר את המודולים אותם תרצה בעמוד הבית:</td>";
							echo "</tr>";
							
							foreach( $arr as $key => $val )
							{
								if( eregi( $val['code'] , $data_extra_settings['facebookHpContent'] ) )
									$checked = "checked";
								else
									$checked = "";
								
								echo "<tr>";
									echo "<td><input type='checkbox' name='facbookC[".$key."]' value='1' ".$checked."></td>";
									echo "<td width=10></td>";
									echo "<td>".$val['name']."</td>";
								echo "</tr>";
							}
						echo "</table>";
					echo "</td>";
				echo "</tr>";
			}
			
		}
		else
		{
			echo "<input type=\"hidden\" name=\"record_id\" value=\"".$data_settings['id']."\">";
			
			load_editor_text( "hp_text" , stripcslashes($data_settings['hp_text']) );
		}
		
		
		echo "<tr><Td height=\"7\" colspan=\"3\"></TD></tr>";
		echo "<tr>";
			echo "<td align=\"center\" colspan=\"3\"><input type=\"submit\" value=\"".$word[LANG]['save']."\" class=\"submit_style\"></td>";
		echo "</tr>";
		
	echo "</form>";
	echo "</table>";
}


function facebook_modols()
{
	return array(
					'like' => array( "name" => "Like Button" , "code" => "<fb:like width=400></fb:like>" ) ,
					'recommend' => array( "name" => "Recommendations" , "code" => "<fb:recommendations width=400 height=250></fb:recommendations>" ) ,
					//'login' => array( "name" => "Login with Faces" , "code" => "<fb:login-button show-faces=true width=400></fb:login-button>" ) ,
					'comments' => array( "name" => "Comments" , "code" => "<fb:comments width=400></fb:comments>" ) ,
					
					'activity' => array( "name" => "Activity Feed" , "code" => "<fb:activity width=400 height=250></fb:activity>" ) ,
					//'like2' => array( "name" => "Like Box" , "code" => "<fb:like-box width=400></fb:like-box>" ) ,
					//'face' => array( "name" => "Facepile" , "code" => "<fb:facepile width=400></fb:facepile>" ) ,
					//'live' => array( "name" => "Live Stream" , "code" => "<fb:live-stream width=400></fb:live-stream>" ) ,
				);
}



function getIfream()
{
	switch( $_GET['domain'] )
	{
		case "develop" :
			$full_path="http://develop.ilbiz.co.il/".$_GET['path'];
		break;
	}
	
	echo "<iframe src='".$full_path."/admin/?unk=".UNK."&sesid=".SESID."' frameborder=0 height=450 width=100% scrolling=auto></iframe>";
}


function update_hp_conf()
{
	switch($_POST['format'])
	{
		case "num1" :
			$data_arr[arti_limit] = "2";
			$data_arr[right_place] = "0-1";
			$data_arr[left_place] = "0-1-2";
		break;
		
		case "num2" :
			$data_arr[arti_limit] = "2";
			$data_arr[right_place] = "0-1";
			$data_arr[left_place] = "";
		break;
		
		case "num3" :
			$data_arr[arti_limit] = "2";
			$data_arr[right_place] = "0-1";
			$data_arr[left_place] = "";
		break;
		
		case "num4" :
			$data_arr[arti_limit] = "2";
			$data_arr[right_place] = "1-0";
			$data_arr[left_place] = "";
		break;
		
		case "num5" :
			$data_arr[arti_limit] = "2";
			$data_arr[right_place] = "1-0";
			$data_arr[left_place] = "";
		break;
		
		case "num6" :
			$data_arr[arti_limit] = "2";
			$data_arr[right_place] = "1-0";
			$data_arr[left_place] = "";
		break;
		
		case "num7" :
			$data_arr[arti_limit] = "3";
			$data_arr[right_place] = "0-1";
			$data_arr[left_place] = "0-1-2-3";
		break;
		
		case "num8" :
			$data_arr[arti_limit] = "3";
			$data_arr[right_place] = "";
			$data_arr[left_place] = "";
		break;
		
		case "num9" :
			$data_arr[arti_limit] = "2";
			$data_arr[right_place] = "0-1";
			$data_arr[left_place] = "0bot";
		break;
	}
	
	
	if( $_POST['record_id'] == "" && $_POST['hp_text'] == "" )
	{
		$data_arr[unk] = $_POST['unk'];
		$data_arr[format] = $_POST['format'];
		$data_arr[adv_banner_1_width] = $_POST['adv_banner_1_width'];
		$data_arr[adv_banner_1_height] = $_POST['adv_banner_1_height'];

		
		$image_settings = array(
			after_success_goto=>"index.php?main=homepage&type=".$_POST['type']."&unk=".$_POST['unk']."&sesid=".$_POST['sesid'],
			table_name=>"user_hp_conf",
		);
		$data_arr = ($_POST['data_arr'])? $_POST['data_arr'] : $_GET['data_arr'];
		insert_to_db($data_arr, $image_settings);
	}
	elseif( $_POST['hp_text'] != "" )
	{
		$data_arr[hp_text] = $_POST['hp_text'];
		
		$image_settings = array(
			after_success_goto=>"index.php?main=homepage&type=".$_POST['type']."&unk=".$_POST['unk']."&sesid=".$_POST['sesid'],
			table_name=>"users",
		);
	//	$data_arr = ($_POST['data_arr'])? $_POST['data_arr'] : $_GET['data_arr'];
		update_db($data_arr, $image_settings);
	}
	else
	{
		$data_arr[unk] = $_POST['unk'];
		$data_arr[format] = $_POST['format'];
		$data_arr[adv_banner_1_width] = $_POST['adv_banner_1_width'];
		$data_arr[adv_banner_1_height] = $_POST['adv_banner_1_height'];
		
		$image_settings = array(
			after_success_goto=>"index.php?main=homepage&type=".$_POST['type']."&unk=".$_POST['unk']."&sesid=".$_POST['sesid'],
			table_name=>"user_hp_conf",
		);
		//$data_arr = ($_POST['data_arr'])? $_POST['data_arr'] : $_GET['data_arr'];
		update_db($data_arr, $image_settings);
	}
	
	if( is_array($_POST['facbookC']) )
	{
		$arr = facebook_modols();
		
		$fb_content = "";
		foreach( $arr as $key => $val )
		{
			if( $_POST['facbookC'][$key] == "1" )
			{
				$fb_content .= $val['code']."<br><br>";
			}
		}
		
		$sql = "UPDATE user_extra_settings SET facebookHpContent = '".$fb_content."' WHERE unk = '".UNK."'";
		$res = mysql_db_query(DB,$sql);
		
	}
	
	
	if( $_POST['upload_banners'] == "1" )
	{
		$field_name = array("adv_banner_1");
		
		//check if files being uploaded
		if($_FILES)
		{
			for($temp=0 ; $temp<sizeof($field_name) ; $temp++)
			{
				$temp_name = $field_name[$temp];
				if ( $_FILES[$temp_name]['name'] != "" )
				{
					$exte = substr($_FILES[$temp_name]['name'],(strpos($_FILES[$temp_name]['name'],".")+1));
					$logo_name2 = $_POST['unk']."-hpBan1Ts.".$exte;
					$tempname = $logo_name;
					
					GlobalFunctions::upload_file_to_server($temp_name , $logo_name2 , SERVER_PATH."/tamplate" );
					
					$sql = "UPDATE user_hp_conf SET adv_banner_1 = '".$logo_name2."' WHERE id = '".$_POST['record_id']."' limit 1";
					$res = mysql_db_query(DB,$sql);
				}
			}
		}
		
		$field_name = array("adv_banner_2");
		
		//check if files being uploaded
		if($_FILES)
		{
			for($temp=0 ; $temp<sizeof($field_name) ; $temp++)
			{
				$temp_name = $field_name[$temp];
				if ( $_FILES[$temp_name]['name'] != "" )
				{
					$exte = substr($_FILES[$temp_name]['name'],(strpos($_FILES[$temp_name]['name'],".")+1));
					$logo_name2 = $_POST['unk']."-hpBan2Rs.".$exte;
					$tempname = $logo_name;
					
					GlobalFunctions::upload_file_to_server($temp_name , $logo_name2 , SERVER_PATH."/tamplate" );
					
					$sql = "UPDATE user_hp_conf SET adv_banner_2 = '".$logo_name2."' WHERE id = '".$_POST['record_id']."' limit 1";
					$res = mysql_db_query(DB,$sql);
				}
			}
		}
	}
		
	
				
}

/**************************************************************************************************/

function text()	{

	global $data_extra_settings,$word;
	
	$sql = "select * from content_pages where unk = '".UNK."' and type = '".$_REQUEST['type']."' and deleted = '0'";
	$res = mysql_db_query(DB,$sql);
	$data = mysql_fetch_array($res);
	
	echo "<table border=\"0\" cellspacing=\"0\" cellpadding=\"0\" class=\"maintext\" width='100%'>";
	echo "<form action=\"index.php\" name=\"editorhtml\" id=\"editorhtml\" method=\"POST\">";
	echo "<input type=\"hidden\" name=\"main\" value=\"update_text\">";
	echo "<input type=\"hidden\" name=\"type\" value=\"".$_REQUEST['type']."\">";
	echo "<input type=\"hidden\" name=\"text_id\" value=\"".$data['id']."\">";
	echo "<input type=\"hidden\" name=\"unk\" value=\"".UNK."\">";
	echo "<input type=\"hidden\" name=\"sesid\" value=\"".SESID."\">";
	
	if( $data_extra_settings['estimateSite'] == "1" )
	{
		echo "<tr>";
			echo "<td><a href='index.php?main=edit_estimateMiniSiteBlock&type=".$_REQUEST['type']."&unk=".UNK."&sesid=".SESID."' class='maintext'><b style='font-size: 14px;'>עדכון פרמטרים בטופס הצעת מחיר</b></a></td>";
			
		echo "</tr>";
		echo "<tr><Td height=\"7\"></TD></tr>";
	
	}

	if(  $_REQUEST['type'] != "contact" && $_REQUEST['type'] != "gb" && $_REQUEST['type'] != "net" )
	{
		$selected_hide_0 = ( $data['hide_page'] == "0" ) ? "selected" : "";
		$selected_hide_1 = ( $data['hide_page'] == "1" ) ? "selected" : "";
		echo "<tr>
			<td>
				<table border=\"0\" cellspacing=\"0\" cellpadding=\"0\" class=\"maintext\">
					<tr>
						<td>".$word[LANG]['updated_page_name']."</td>
						<td width='10'></td>
						<td><input type='text' name='name' value='".stripslashes($data['name'])."' class='input_style'></td>
					</tr>
					<tr><Td height=\"5\" colspan=3></TD></tr>
					<tr>
						<td>".$word[LANG]['location']."</td>
						<td width='10'></td>
						<td>
							<select name='place' class='input_style'>";
								for( $i=0 ; $i<=50 ; $i++ )
								{
									$selected = ( $i == $data['place'] ) ? "selected" : "";
									echo "<option value='".$i."' ".$selected.">".$i."</option>";
								}
							echo "</select>
						</td>
					</tr>
					<tr><Td height=\"5\" colspan=3></TD></tr>
					<tr>
						<td>".$word[LANG]['hidden_page']."</td>
						<td width='10'></td>
						<td>
							<select name='hide_page' class='input_style'>
								<option value='0' ".$selected_hide_0.">".$word[LANG]['no']."</option>
								<option value='1' ".$selected_hide_1.">".$word[LANG]['yes']."</option>
							</select>
						</td>
					</tr>
					<tr><Td height=\"5\" colspan=3></TD></tr>";
					
					if( UNK == "819413848591511341" )
					{
					$selected_hba_active_cats_0 = ( $data['hba_active_cats'] == "0" ) ? "selected" : "";
					$selected_hba_active_cats_1 = ( $data['hba_active_cats'] == "1" ) ? "selected" : "";
					echo "<tr>
						<td>".$word[LANG]['page_with_categories_hba']."</td>
						<td width='10'></td>
						<td>
							<select name='hba_active_cats' class='input_style'>
								<option value='0' ".$selected_hba_active_cats_0.">".$word[LANG]['no']."</option>
								<option value='1' ".$selected_hba_active_cats_1.">".$word[LANG]['yes']."</option>
							</select>
						</td>
					</tr>
					<tr><Td height=\"5\" colspan=3></TD></tr>
					";
					
					}
					else
						echo "<input type='hidden' name='hba_active_cats' value='0'>";
					
					
					$sql = "select * from user_text_libs where deleted = '0' and unk = '".UNK."' ORDER BY lib_name";
					$resLib = mysql_db_query(DB,$sql);			
					
					echo "<tr>
						<td>".$word[LANG]['folder']."</td>
						<td width='10'></td>
						<td>
							<select name='lib' class='input_style'>
								<option value=''>".$word[LANG]['selection']."</option>";
								while( $dataLib = mysql_fetch_array($resLib) )
								{
									$selected = ( $dataLib['id'] == $data['lib'] ) ? "selected" : "";
									echo "<option value='".$dataLib['id']."' ".$selected.">".GlobalFunctions::kill_strip($dataLib['lib_name'])."</option>";
								}
							echo "</select>
						</td>
					</tr>
					<tr><Td height=\"5\" colspan=3></TD></tr>";
				
					if( $data_extra_settings['userCanSEO'] == "1" )
					{
						echo "<tr><td colspan=3 height=5></td></tr>
						<tr>
							<td>".$word[LANG]['keywords_search_eng']."</td>
							<td width='10'></td>
							<td><textarea name='keywords' cols='' rows='' style='height:50px;' class='input_style'>".stripslashes($data['keywords'])."</textarea></td>
						</tr>
						<tr><Td height=\"5\" colspan=3></TD></tr>
						<tr>
							<td>".$word[LANG]['descriptionsearch_eng']."</td>
							<td width='10'></td>
							<td><textarea name='description' cols='' rows='' style='height:50px;' class='input_style'>".stripslashes($data['description'])."</textarea></td>
						</tr>
						<tr><Td height=\"5\" colspan=3></TD></tr>
						<tr>
							<td>קוד קהלים FB</td>
							<td width='10'></td>
							<td><textarea name='fb_audience_code' cols='' rows='' style='height:50px;' class='input_style'>".stripslashes($data['fb_audience_code'])."</textarea></td>
						</tr>
						<tr><Td height=\"5\" colspan=3></TD></tr>
						<tr>
							<td>קוד שאלות ותשובות גוגל</td>
							<td width='10'></td>
							<td><textarea name='gl_faq_code' cols='' rows='' style='height:50px;' class='input_style'>".stripslashes($data['gl_faq_code'])."</textarea></td>
						</tr>
						<tr><Td height=\"5\" colspan=3></TD></tr>";
						
						
						
					}
					echo "
						<tr><Td height=\"5\" colspan=3></TD></tr>
						<tr>
							<td>".$word[LANG]['summary']."</td>
							<td width='10'></td>
							<td><textarea name='summary' cols='' rows='' style='height:50px;' class='input_style'>".stripslashes($data['summary'])."</textarea></td>
						</tr>
						<tr><Td height=\"5\" colspan=3></TD></tr>";					
				echo "</table>
			</td>	
		</tr>";
	}
	
		echo "<tr>";
			echo "<td align=\"center\">";
				
				load_editor_text( "content" , stripcslashes($data['content']) );
				
			echo "</td>";
		echo "</tr>";
		echo "<tr><Td height=\"7\"></TD></tr>";
		
		if( $_REQUEST['type'] != "text" )
		{
			$sql = "SELECT mailing_name , id FROM net_mailing_settings WHERE unk = '".UNK."' AND deleted=0";
			$resMailing = mysql_db_query(DB,$sql);
			$countMailing = mysql_num_rows($resMailing);
			
			if( $countMailing > 0 )
			{
				echo "<tr>";
					echo "<td>";
						echo "<table border=\"0\" cellspacing=\"0\" cellpadding=\"0\" class=\"maintext\">";
							echo "<tr>";
								echo "<td>שיוך לדיוור</td>";
								echo "<td width='10'></td>";
								echo "<td>";
									echo "<select name='mailing_id' class='input_style'>";
										echo "<option value=''>בחר דיוור</option>";
										while( $dataMailing = mysql_fetch_array($resMailing) )
										{
											$selected = ( $dataMailing['id'] == $data['mailing_id'] ) ? "selected" : "";
											echo "<option value='".$dataMailing['id']."' ".$selected." >".stripslashes($dataMailing['mailing_name'])."</option>";
										}
									echo "</select>";
								echo "</td>";
							echo "</tr>";
						echo "</table>";
					echo "</td>";
				echo "</tr>";
				
				echo "<tr><Td height=\"7\"></TD></tr>";
				
				echo "<tr>";
					echo "<td>";
						echo "<table border=\"0\" cellspacing=\"0\" cellpadding=\"0\" class=\"maintext\">";
							echo "<tr>";
								echo "<td>משפט שכנוע לקישור - לאחר התחברות</td>";
								echo "<td width='10'></td>";
								echo "<td><input type='text' name='mailing_text' value='".stripslashes($data['mailing_text'])."' class='input_style'></td>";
							echo "</tr>";
						echo "</table>";
				echo "</tr>";
				echo "<tr><Td height=\"7\"></TD></tr>";
			}
			
			
			echo "<tr>";
				echo "<td>";
					echo "<table border=\"0\" cellspacing=\"0\" cellpadding=\"0\" class=\"maintext\">";
						echo "<tr>";
							echo "<td>העברת קישור לדף הבא ( העברה 301 )</td>";
							echo "<td width='10'></td>";
							echo "<td><input type='text' name='redierct_301' value='".stripslashes($data['redierct_301'])."' class='input_style'></td>";
						echo "</tr>";
					echo "</table>";
			echo "</tr>";
		}
		echo "<tr><Td height=\"7\"></TD></tr>";
		echo "<tr>";
			echo "<td>";
				echo "<table border=\"0\" cellspacing=\"0\" cellpadding=\"0\" class=\"maintext\">";
					echo "<tr>";
						echo "<td>".$word[LANG]['landing_page_add']."</td>";
						echo "<td width='10'></td>";
						echo "<td><input type='text' name='ld_page_add' value='".stripslashes($data['ld_page_add'])."' class='input_style'></td>";
					echo "</tr>";
					echo "<tr><Td height=\"5\" colspan=3></TD></tr>";		
				echo "</table>";
			echo "</td>";
		echo "</tr>";	
		echo "<tr><Td height=\"7\"></TD></tr>";
		echo "<tr>";
			echo "<td>";
				echo "<a href='index.php?main=manage_user_service_offers&scope=page&page_id=".$_REQUEST['text_id']."&unk=".UNK."&sesid=".SESID."'>עריכת קטגוריות הצעות מחיר לעמוד</a>";
			echo "</td>";
		echo "</tr>";	
		echo "<tr><Td height=\"7\"></TD></tr>";		
		echo "<tr>";
			echo "<td align=\"left\"><input type=\"submit\" value=\"".$word[LANG]['save']."\" class=\"submit_style\"></td>";
		echo "</tr>";
	
	echo "</form>";
	echo "</table>";
}
/**************************************************************************************************/

function update_text()	{

	global $word;
	
	if( $_POST['text_id'] )	{
		$sql = "update content_pages set content = '".addslashes($_POST['content'])."' , lib = '".$_POST['lib']."' , place = '".$_POST['place']."' , name = '".addslashes($_POST['name'])."' , ld_page_add = '".addslashes($_POST['ld_page_add'])."' , description = '".addslashes($_POST['description'])."', summary = '".addslashes($_POST['summary'])."', keywords = '".addslashes($_POST['keywords'])."', fb_audience_code = '".addslashes($_POST['fb_audience_code'])."',gl_faq_code = '".addslashes($_POST['gl_faq_code'])."', hide_page = '".$_POST['hide_page']."' , hba_active_cats = '".$_POST['hba_active_cats']."' , mailing_id = '".$_POST['mailing_id']."' , mailing_text = '".addslashes($_POST['mailing_text'])."' , redierct_301 = '".addslashes($_POST['redierct_301'])."' where unk = '".$_POST['unk']."' and id = '".$_POST['text_id']."' and type = '".$_POST['type']."'";
		$res = mysql_db_query(DB,$sql);
	}
	else	{
		if( $_POST['type'] != "text" && $_POST['type'] != "contact" && $_POST['type'] != "gb" && $_POST['type'] != "net" )
		{
			$sql_last_id = "select id from content_pages order by id desc limit 1";
			$res_last_id = mysql_db_query(DB,$sql_last_id);
			$data_last_id = mysql_fetch_array($res_last_id);
			$content_new_id = 1+$data_last_id[id];
		}
		else
		{
			$content_new_id = $_POST['type'];
		}
		
		$sql = "insert into content_pages (lib,content,ld_page_add,keywords,fb_audience_code,gl_faq_code, description,summary,unk,type,name,hba_active_cats,place,mailing_id,mailing_text,redierct_301) values( '".$_POST['lib']."' , '".addslashes($_POST['content'])."' , '".addslashes($_POST['ld_page_add'])."' , '".addslashes($_POST['keywords'])."' , '".addslashes($_POST['fb_audience_code'])."','".addslashes($_POST['gl_faq_code'])."' , '".addslashes($_POST['description'])."', '".addslashes($_POST['summary'])."', '".$_POST['unk']."' , '".$content_new_id."' , '".addslashes($_POST['name'])."' , '".$_POST['hba_active_cats']."' , '".$_POST['place']."' , '".$_POST['mailing_id']."' , '".addslashes($_POST['mailing_text'])."' , '".addslashes($_POST['redierct_301'])."' )";
		$res = mysql_db_query(DB,$sql);
	}
	
	echo "<script>alert('".$word[LANG]['alert_saved_on_system']."');</script>";
	echo "<script>window.location.href='index.php?main=text&type=".$_POST['type']."&unk=".$_POST['unk']."&sesid=".$_POST['sesid']."';</script>";
		exit;
}
/**************************************************************************************************/

function List_View_Rows()	{

	global $word;
	
	$table = "user_".$_REQUEST['type'];
	$back_to = $_REQUEST['type'];
	$goto_func = $_REQUEST['type'];
	
	switch($_REQUEST['type'])	{
		case "articels" :
			$sql = "select * from ".$table." where deleted = 0 and unk = '".UNK."' ".AUTH_QUERY_STR." order by id desc";//place
			$arr_fields = array(
				date_in => $word[LANG]['date_insert'],
				headline => $word[LANG]['title'],
				summary => $word[LANG]['summary'],
			);
		break;
		
		case "articels_cat" :
			$table = "user_articels_cat";
			$sql = "select * from ".$table." where deleted = 0 and unk = '".UNK."' ".AUTH_QUERY_STR." order by id";
			$arr_fields = array(
				name => $word[LANG]['category_name'],
				active => $word[LANG]['active'],
			);
			
		break;
		
		case "sales" :
			$sql = "select have_sales_dates from users where unk = '".UNK."'";
			$resUsers = mysql_db_query(DB,$sql);
			$dataUsers = mysql_fetch_array($resUsers);
			
			$status = ( $_GET['s_status'] == "" ) ? "" : "AND status='".$_GET['s_status']."' ";
			$sql = "select * from ".$table." where deleted = 0 and unk = '".UNK."' ".AUTH_QUERY_STR." ".$status." order by place";
			
			if( $dataUsers['have_sales_dates'] == "0" )
			{
				$arr_fields = array(
					name => $word[LANG]['offer_name'],
					content => $word[LANG]['detail'],
					end_date => $word[LANG]['end_date'],
				);
			}
			else
			{
				$arr_fields = array(
					name => $word[LANG]['offer_name'],
					content => $word[LANG]['detail'],
				);
			}
		break;
		
		case "wanted" :
			$status = ( $_GET['s_status'] == "" ) ? "" : "AND status='".$_GET['s_status']."' ";
			
			$sql = "select * from ".$table." where deleted = 0 and unk = '".UNK."' ".AUTH_QUERY_STR." ".$status." order by place";
			$arr_fields = array(
				date_in => $word[LANG]['date_insert'],
				content => $word[LANG]['details_on_job'],
				approved_by_admin => "מאושר?",
			);
		break;
		
		case "video" :
			$cat = ( $_REQUEST['cat'] == "" ) ? "" :  " and cat = '".$_REQUEST['cat']."'";
			$sql = "select * from ".$table." where deleted = 0 and unk = '".UNK."' ".$cat." ".AUTH_QUERY_STR." order by id desc, place";
			$arr_fields = array(
				name => $word[LANG]['name_video'],
				content => $word[LANG]['detail'],
			);
		break;
		
		case "yad2" :
			$sql = "select * from ".$table." where deleted = 0 and unk = '".UNK."' ".AUTH_QUERY_STR." order by place";
			$arr_fields = array(
				name => $word[LANG]['product_name'],
				content => $word[LANG]['detail'],
			);
		break;
		
		case "products" :
			$cat = ( $_GET['cat'] != "" ) ? "umcb.catId='".$_GET['cat']."' AND " : "";
			
			if( UNK == "285240640927706447" )
			{
				$sql = "select up.* from 
					user_products as up where 
						up.unk = '".UNK."' AND
						up.deleted = '0'
					 order by up.id DESC";
				
				$arr_fields = array(
					name => $word[LANG]['product_name'],
					content => $word[LANG]['detail'],
					lock_10service => "נעול?",
				);
			}
			else
			{
				$sql = "select up.* from ".$table." as up LEFT JOIN user_model_cat_belong as umcb ON umcb.model='products' AND umcb.itemId=up.id WHERE ".$cat."  up.deleted = 0 and up.unk = '".UNK."' ".AUTH_QUERY_STR." GROUP BY up.id order by up.place";
				
				$arr_fields = array(
					name => $word[LANG]['product_name'],
					content => $word[LANG]['detail'],
					
				);
			}
			
		break;
		
		case "10service_product" :
			$sql = "SELECT id FROM users WHERE unk = '".UNK."' ";
			$resId = mysql_db_query(DB,$sql);
			$dataId = mysql_fetch_array($resId);
			
				$sql = "select up.* from 
					user_products as up where 
						up.unk = '285240640927706447' AND
						up.belongToUser10service = '".$dataId['id']."' AND
						up.deleted = '0'
					 order by up.id DESC";
			
			$arr_fields = array(
				name => $word[LANG]['product_name'],
				content => $word[LANG]['detail'],
			);
		break;
		
		case "deal_coupon" :
			$sql = "SELECT id FROM users WHERE unk = '".UNK."' ";
			$resId = mysql_db_query(DB,$sql);
			$dataId = mysql_fetch_array($resId);
			
			if( UNK == "285240640927706447" )
			{
				$sql = "select up.* from 
					10service_deal_coupon as up where 
						up.deleted = '0'
					 order by up.id DESC";
			}
			else
			{
				$sql = "select up.* from 
					10service_deal_coupon as up where 
						up.user_id = '".$dataId['id']."' AND
						up.deleted = '0'
					 order by up.id DESC";
			}
			$arr_fields = array(
				headline => "שם המוצר",
				summery => "תקציר",
				in_stock => "במלאי",
				bought => "נמכרו",
			);
			$table = "10service_deal_coupon";
		break;
		
		case "products_cat" :
			$sql = "select * from user_products_cat where deleted = 0 and unk = '".UNK."' ".AUTH_QUERY_STR." order by id";
			$arr_fields = array(
				name => $word[LANG]['category_name'],
				status => $word[LANG]['active'],
			);
			$table = "user_products_cat";
		break;
		
		case "products_subject" :
			$sql = "select * from user_products_subject where deleted = 0 and unk = '".UNK."' ".AUTH_QUERY_STR." order by id";
			$arr_fields = array(
				name => $word[LANG]['topic_name'],
				active => $word[LANG]['active'],
			);
			$table = "user_products_subject";
		break;
		
		case "gallery_cat" :
			$sql = "select * from user_gallery_cat where deleted = 0 and unk = '".UNK."' ".AUTH_QUERY_STR." order by id";
			$arr_fields = array(
				name => $word[LANG]['category_name'],
				active => $word[LANG]['active'],
				place => $word[LANG]['place'],
			);
			$table = "user_gallery_cat";
		break;
		
		case "gallery_subject" :
			$sql = "select * from user_images_cat_subject where deleted = 0 and unk = '".UNK."' ".AUTH_QUERY_STR." order by id";
			$arr_fields = array(
				name => $word[LANG]['topic_name'],
				active => $word[LANG]['active'],
			);
			$table = "user_images_cat_subject";
		break;
		
		
		case "video_cat" :
			$sql = "select * from user_video_cat where deleted = 0 and unk = '".UNK."' ".AUTH_QUERY_STR." order by id";
			$arr_fields = array(
				name => $word[LANG]['category_name'],
				active => $word[LANG]['active'],
				hp_order => $word[LANG]['location'],
			);
			$table = "user_video_cat";
		break;
		
		case "contact" :
			$status = ( $_REQUEST['status'] == "" ) ? "0" :  $_REQUEST['status'];
			$deleted = ( $_REQUEST['deleted'] == "1" ) ? "AND deleted = 1" :  "AND deleted = 0";
			$deleted_status = ( $status != "s" && $_REQUEST['deleted'] != "1" ) ? " and status = '".$status."' " :  "";
			$subject_id = ( $_GET['subject_id'] != "" ) ? " and subject_id = '".$_GET['subject_id']."' " :  "";
			
			$pending_qry = " AND ((send_type != 'pending' OR send_type IS NULL) OR (show_time != '' AND show_time IS NOT NULL)) ";
			if( $status == "s" )
			{
				$ex = explode( "-" , $_GET['sd'] );
				$where = ($_GET['sd'] != "" ) ? " AND date_in >= '".$ex[2]."-".$ex[1]."-".$ex[0]."' " : "";
				$ex2 = explode( "-" , $_GET['ed'] );
				$where .= ($_GET['ed'] != "" ) ? " AND date_in <= '".$ex2[2]."-".$ex2[1]."-".$ex2[0]."' " : "";
				if($_GET['val'] != ""){
					if(substr( $_GET['val'], 0, 4 ) === "cid:"){
						
					}
					else{
						$where .= ($_GET['val'] != "" ) ? " AND ( ( name LIKE '%".mysql_r_e_s($_GET['val'])."%' ) OR ( content LIKE '%".mysql_r_e_s($_GET['val'])."%' ) )" : "";
					}								
				}
				//$where .= ($_GET['val'] != "" ) ? " AND ( ( name LIKE '%".mysql_r_e_s($_GET['val'])."%' ) OR ( content LIKE '%".mysql_r_e_s($_GET['val'])."%' ) )" : "";
				
				$array_s = $_GET['s'];
				$where_status="";
				if( is_array($array_s) )
				{
					
					foreach( $array_s as $key => $val )
					{
						$where_status .= ($array_s[$key] == "1" ) ? " status = '".$key."' OR" : "";
					}
				}
				if( $where_status != "" )
				{
					$where .= " AND (".substr( $where_status, 0, -2 ).")";
				}
				
				
			}
			
			$page = 0;
			if(isset($_REQUEST['page'])){
				if(is_numeric($_REQUEST['page'])){
					$page = $_REQUEST['page'];
				}
			}
			//13:10:32
			$paging_size = 20;
			$count_sql = "select count(id) as count_lines from user_contact_forms where 1 ".$deleted.$pending_qry." and unk = '".UNK."' ".$deleted_status.$where.$subject_id;
			$count_res = mysql_db_query(DB,$count_sql);
			$count_data = mysql_fetch_array($count_res);
			$paging_html = "";
			$last_page_html = "";
			$next_page_html = "";
			$get_params = "?main=".$_GET['main'];
			foreach($_GET as $key=>$val){
				if($key!="main" && $key!="page"){
					$get_params .= "&$key=$val";
				}
			}
			$paging_link = "index.php".$get_params;
			if($page != 0){

				$last_page = $page-1;
				$last_page_link = $paging_link."&page=".$last_page;
				$last_page_html = "<a href='".$last_page_link."'><< עמוד קודם </a>";
			}
			if($count_data['count_lines']> $paging_size){
				$paging_size = 200;
				$next_page = $page+1;	
				$page_limit = $page*$paging_size;
				$limit_sql = " LIMIT $page_limit, $paging_size ";
				$next_page_limit = $page_limit + $paging_size;
				if($count_data['count_lines'] > $next_page_limit){
					$next_page_link = $paging_link."&page=".$next_page;
					$next_page_html = "<a href='".$next_page_link."'>עמוד הבא >></a>";
				}
			}
			if($next_page_html || $last_page_html){
				$paging_html = "<div style='font-size:18px;margin-bottom:10px;'>".$last_page_html."&nbsp;&nbsp;".$next_page_html."</div>";
			}
			echo $paging_html;
			
			$sql = "select * from user_contact_forms where 1 ".$deleted.$pending_qry." and unk = '".UNK."' ".$deleted_status.$where.$subject_id." order by id DESC".$limit_sql;
			$arr_fields = array(
				date_in => $word[LANG]['date_contact'],
				name => $word[LANG]['full_name'],
				phone => $word[LANG]['phone'],
				status => $word[LANG]['status'],				
			);

			$table = "user_contact_forms";
		break;

		case "e_card_forms" :
			$status = ( $_REQUEST['status'] == "" ) ? "0" :  $_REQUEST['status'];
			$deleted = ( $_REQUEST['deleted'] == "1" ) ? "AND deleted = 1" :  "AND deleted = 0";
			$deleted_status = ( $status != "s" && $_REQUEST['deleted'] != "1" ) ? " and status = '".$status."' " :  "";
			$subject_id = "";//( $_GET['subject_id'] != "" ) ? " and subject_id = '".$_GET['subject_id']."' " :  "";
			
			
			if( $status == "s" )
			{
				$ex = explode( "-" , $_GET['sd'] );
				$where = ($_GET['sd'] != "" ) ? " AND date_in >= '".$ex[2]."-".$ex[1]."-".$ex[0]."' " : "";
				$ex2 = explode( "-" , $_GET['ed'] );
				$where .= ($_GET['ed'] != "" ) ? " AND date_in <= '".$ex2[2]."-".$ex2[1]."-".$ex2[0]."' " : "";
				
				$where .= ($_GET['val'] != "" ) ? " AND ( ( name LIKE '%".mysql_r_e_s($_GET['val'])."%' ) OR ( content LIKE '%".mysql_r_e_s($_GET['val'])."%' ) )" : "";
				
				$array_s = $_GET['s'];
				$where_status="";
				if( is_array($array_s) )
				{
					
					foreach( $array_s as $key => $val )
					{
						$where_status .= ($array_s[$key] == "1" ) ? " status = '".$key."' OR" : "";
					}
				}
				if( $where_status != "" )
				{
					$where .= " AND (".substr( $where_status, 0, -2 ).")";
				}
				
				
			}
			
			$sql = "select * from user_e_card_forms where 1 ".$deleted." and unk = '".UNK."' ".$deleted_status.$where.$subject_id." order by id DESC";
			
			$arr_fields = array(
				date_in => $word[LANG]['date_contact'],
				name => $word[LANG]['full_name'],
				phone => $word[LANG]['phone'],
				subject => $word[LANG]['subject'],
				status => $word[LANG]['status'],				
			);
			$table = "user_e_card_forms";
		break;
		
		case "contact_subjects" :
			$sql = "select * from user_contact_subjects where deleted = 0 and unk = '".UNK."' order by id desc";
			$arr_fields = array(
				subject => $word[LANG]['subject'],
			);
			$table = "user_contact_subjects";
		break;
		
		case "gb" :
			$sql = "select * from user_gb_response where deleted = 0 and unk = '".UNK."' order by id desc";
			$arr_fields = array(
				date_in => $word[LANG]['date_contact'],
				name => $word[LANG]['full_name'],
				headline => $word[LANG]['title'],
				status => $word[LANG]['status'],
			);
			$table = "user_gb_response";
		break;
		
		case "news" :
			$sql = "select * from user_news where deleted = 0 and unk = '".UNK."' order by id desc";
			$arr_fields = array(
				headline => $word[LANG]['title'],
				content => $word[LANG]['content'],
			);
			$table = "user_news";
		break;
		
		case "update_pages" :
			$sinon_lib = ( $_GET['lib'] != "" ) ? "AND lib = '".$_GET['lib']."'" : "";
			
			$sql = "select * from content_pages where deleted = 0 ".$sinon_lib." and type != 'text' and type != 'contact' and type != 'gb' and unk = '".UNK."' order by place,id";
			$arr_fields = array(
				place => $word[LANG]['location'],
				name => $word[LANG]['page_name']
			);
			$table = "content_pages";
		break;
		
		
		case "design_page" :
			$sinon_cat = ( $_GET['cat'] != "" ) ? "AND cat = '".$_GET['cat']."'" : "";
			
			$sql = "select * from user_design_page where deleted = 0 ".$sinon_cat." and unk = '".UNK."' order by id";
			$arr_fields = array(
				title => $word[LANG]['page_name'],
			);
			$table = "user_design_page";
		break;
		
		case "design_page_cat" :
			$sql = "select * from user_design_page_cat where deleted = 0 and unk = '".UNK."' order by id";
			$arr_fields = array(
				cat_name => $word[LANG]['category_name'],
				active => $word[LANG]['active'],
			);
			$table = "user_design_page_cat";
		break;
		
		
		case "myClients" :
			$sql = "select * from user_clients where unk = '".UNK."' and deleted = '0' order by id desc";
			$arr_fields = array(
				full_name => $word[LANG]['full_name'],
				email => $word[LANG]['email'],
				phone => $word[LANG]['phone'],
				city => $word[LANG]['city'],
			);
			$table = "user_clients";
		break;
		
		case "text_libs" :
			
			$sql = "select * from user_text_libs where unk = '".UNK."' and deleted = '0' order by id";
			$arr_fields = array(
				lib_name => $word[LANG]['name_folder'],
			);
			$table = "user_text_libs";
		break;
		
		
		
		
		
		case "guide" :
			
			$sql = "select * from user_guide where unk = '".UNK."' order by guide_name";
			$arr_fields = array(
				guide_name => "שם המדריך",
			);
			$table = "user_guide";
		break;
		
		case "guide_business" :
			$where = ($_GET['s_status'] != "" ) ? " AND active = '".$_GET['s_status']."' " : "";
			
			$sql = "select gb.* , g.guide_name from user_guide_business as gb , user_guide as g , user_guide_choosen_biz_guide as gbg where gb.unk = '".UNK."' and gb.deleted = '0' and gbg.guide_id=g.id AND gbg.biz_id=gb.id ".$where." GROUP BY gb.id ORDER BY business_name";
			
			$arr_fields = array(
				guide_name => "שם המדריך",
				business_name => "שם העסק",
			);
			$table = "user_guide_business";
		break;
		
		case "guide_cats" :
			
			$sql = "select * from user_guide_cats where unk = '".UNK."' and deleted = '0' order by cat_name";
			
			$arr_fields = array(
				cat_name => "שם הקטגוריה",
			);
			$table = "user_guide_cats";
		break;
		
		case "guide_cities" :
			
			$sql = "select * from user_guide_cities where unk = '".UNK."' and deleted = '0' order by city_name";
			
			$arr_fields = array(
				city_name => "שם העיר",
			);
			$table = "user_guide_cities";
		break;
		
		
		case "banners_guide" :
			$sql = "select * from user_banners_guide where unk = '".UNK."' and deleted = '0' order by banner_name";
			
			$arr_fields = array(
				banner_name => "שם הבאנר",
				views => "צפיות",
			);
			$table = "user_banners_guide";
		break;
		
		
		case "fmnUsers" :
			if( UNK == "625420717714095702" )
			{
				$sql = "select * from custom_netanya_users where deleted = '0' and unk = '".UNK."' order by id DESC";
				
				$arr_fields = array(
					insert_date => "תאריך הרשמה",
					fname => "שם פרטי",
					lname => "שם משפחה",
					mobile => "סללורי",
					email => "אימייל",
					city => "עיר",
				);
				$table = "custom_netanya_users";
			}
		break;
		
		case "usresTZ" :
			if( UNK == "625420717714095702" )
			{
				$sql = "select * from users_tz_list where deleted = '0' and unk = '".UNK."' order by id DESC";
				
				$arr_fields = array(
					first_name => "שם פרטי",
					last_name => "שם משפחה",
					tz => "תעודת זהות",
				);
				$table = "users_tz_list";
			}
		break;
		
		
		
		case "einYahav" :
			if( UNK == "559357400644528143" )
			{
				$sub_type = ( $_REQUEST['sub_type'] == "" || $_REQUEST['sub_type'] == "0" ) ? "0" : "1";
				$sql = "select a.id, a.date1, a.price, p.pro_name , s.size_name FROM 
					einYahav_adv as a , einYahav_size as s , einYahav_products  as p WHERE type='".(int)$sub_type."' AND
					a.pro_id = p.id and a.size_id = s.id and a.deleted=0 and s.deleted=0 AND a.unk = '".UNK."' GROUP BY a.id order by a.id DESC";
				
				$arr_fields = array(
					pro_name => "שם המוצר",
					date1 => "תאריך",
					price => "מחיר",
					size_name => "גודל",
				);
				$table = "einYahav_adv";
			}
		break;
		
		
		case "einYahav_products" :
			if( UNK == "559357400644528143" )
			{
				$sql = "select * from einYahav_products where unk = '".UNK."' order by pro_name";
				
				$arr_fields = array(
					pro_name => "שם המוצר",
					place => "מיקום",
				);
				$table = "einYahav_products";
			}
		break;
		
		case "einYahav_sizes" :
			if( UNK == "559357400644528143" )
			{
				$sql = "select * from einYahav_size where unk = '".UNK."' and deleted = 0 order by size_name";
				
				$arr_fields = array(
					size_name => "גודל",
					place => "מיקום",
				);
				$table = "einYahav_size";
			}
		break;
		
		case "realty" :
			$sql = "select * from user_realty where unk = '".UNK."' and deleted = 0 order by place , id desc";
		
			$arr_fields = array(
				title => "שם הנכס",
				location => "מיקום הנכס",
			);
			$table = "user_realty";
		break;
		
		case "group_buy" :
			$table = "10_service_group_buy";
		if( UNK != "285240640927706447" )
		{
			$sql = "SELECT id FROM users WHERE unk = '".UNK."' ";
			$resId = mysql_db_query(DB,$sql);
			$dataId = mysql_fetch_array($resId);
			
			$sql = "select * from 
				10_service_group_buy where 
					user_id = '".$dataId['id']."' AND
					deleted = '0'
				 order by id DESC";
			
			$arr_fields = array(
				product_name => $word[LANG]['product_name'],
				product_desc => $word[LANG]['detail'],
			);
		}
		else
		{
			$sql = "select * from 10_service_group_buy where deleted = '0' order by id DESC";
		
			$arr_fields = array(
					product_name => $word[LANG]['product_name'],
					product_desc => $word[LANG]['detail'],
					lock_edit => "נעול?",
				);
		}
		break;
		
	}
	
	
	echo get_table_list($arr_fields,$goto_func,$back_to,$sql,$table);
}
/**************************************************************************************************/

function get_create_form()	{

	global $word;
	
	$table = "user_".$_REQUEST['type'];
	$back_to = $_REQUEST['type'];
	$goto_func = $_REQUEST['type'];
	
	
	
	switch($_REQUEST['type'])	{
		case "articels" :
			$sql = "select * from ".$table." where deleted = '0' and id = '".$_REQUEST['row_id']."' and unk = '".UNK."' ".AUTH_QUERY_STR."";
			$res = mysql_db_query(DB,$sql);
			$data = mysql_fetch_array($res);
			
			if( $_REQUEST['row_id'] )
				$smart_link = "<a href='editor.php?type=articels&unk=".UNK."&row_id=".$_REQUEST['row_id']."&sesid=".SESID."' class='maintext' target='_blank'>".$word[LANG]['click_update_content']."</a>";
			
			$status[0] = $word[LANG]['yes'];
			$status[1] = $word[LANG]['no'];
			
			$wtc_datetime = ( $_REQUEST['row_id'] ) ? "datetime_id" : "hidden";
			$wtc_datetime_name = ( $_REQUEST['row_id'] ) ? "not_active2" : "data_arr[date_in]";
			$wtc_val_datetime = ( $_REQUEST['row_id'] ) ? $data['date_in'] : GlobalFunctions::get_timestemp();
			
			$sql2 = "select * from ".$table."_cat where deleted = '0' and unk = '".UNK."' and active = '0'";
			$res2 = mysql_db_query(DB,$sql2);
			
			$count_pro = 0;
				while( $data2 = mysql_fetch_array($res2) )
				{
					$temp_id = $data2['id'];
					$cat[$temp_id] .= $data2['name'];
					$count_pro++;
				}
				
				
			$myPlace = ( $data['place'] == "0" ) ? $data['id'] : $data['place'];
			
			if( UNK == "285240640927706447" )
			{
				if( $data['id'] != "" )
					$cats = array("blank","<a href='setCatsUniversal.php?xid=".$data['id']."&xtype=1&unk=".UNK."&sesid=".SESID."' class='maintext' target='_blank'>עדכן קטגוריות</a>");
			}
			else
			{
				$cats = array("select","cat[]",$cat,$word[LANG]['assing_cats'],$data['cat'],"data_arr[cat]", "class='input_style''" , $word[LANG]['least_one_category']);
			}
			
			$form_arr = array(
				array("hidden","main","update_new_row"),
				array("hidden","type","articels"),
				array("hidden","record_id",$_REQUEST['row_id']),
				array("hidden","sesid",SESID),
				array("hidden","data_arr[unk]",UNK),
				array("hidden","data_arr[auth_id]",AUTH_ID),
				array("hidden","unk",UNK),
				array("hidden","table",$table),
				array("hidden","data_arr[date_update]",GlobalFunctions::get_timestemp()),
				
				array($wtc_datetime,$wtc_datetime_name,$wtc_val_datetime,$word[LANG]['insert_date'], "class='input_style' readonly","","hidden"),
				array($wtc_datetime,"not_active",$data['date_update'],$word[LANG]['update_date'], "class='input_style' readonly","","hidden"),
				$cats,
				array("text","data_arr[headline]",$data['headline'],$word[LANG]['title'], "class='input_style'","","1"),
				array("new_file","img",$data['img'],$word[LANG]['picture'], "articels", "&table=".$table."&GOTO_type=articels&GOTO_main=List_View_Rows"),
				array("textarea","data_arr[summary]",$data['summary'],$word[LANG]['summary'], "class='textarea_style_summary'","","1"),
				array("select","status[]",$status,$word[LANG]['Displayed_site'],$data['status'],"data_arr[status]", "class='input_style''"),
				array("text","data_arr[place]",$myPlace,$word[LANG]['location'], "class='input_style'"),
				
				
				array("blank",$smart_link),
				
				array("date","insert_date",$data['insert_date'],$word[LANG]['date_insert'], "class='input_style'","hidden"),
				array("submit","submit",$word[LANG]['submit_form'], "class='submit_style' name=\"B1\" onClick=\"sampleSave();\"")
			);
		break;
		
		case "sales" :
			
			$sql = "select * from ".$table." where deleted = '0' and id = '".$_REQUEST['row_id']."' and unk = '".UNK."' ".AUTH_QUERY_STR."";
			$res = mysql_db_query(DB,$sql);
			$data = mysql_fetch_array($res);
			
			$sql = "select have_sales_dates from users where unk = '".UNK."'";
			$resUsers = mysql_db_query(DB,$sql);
			$dataUsers = mysql_fetch_array($resUsers);
			
			$wtc_val_end_date = ( $_REQUEST['row_id'] ) ? $data['end_date'] : GlobalFunctions::get_date();
			$wtc_val_start_date = ( $_REQUEST['row_id'] ) ? $data['start_date'] : GlobalFunctions::get_date();
			
			$wtc_dates = ( $dataUsers['have_sales_dates'] == "0" ) ? "date" : "not_active";
			$wtc_dates_start_txt = ( $dataUsers['have_sales_dates'] == "0" ) ? $word[LANG]['started_operation']." <font style=\"font-size:9px;\" class=\"maintext_small\">dd-mm-yyyy</font>" : "";
			$wtc_dates_end_txt = ( $dataUsers['have_sales_dates'] == "0" ) ? $word[LANG]['end_operation']." <font style=\"font-size:9px;\" class=\"maintext_small\">dd-mm-yyyy</font>" : "";
			
			$status[0] = $word[LANG]['yes'];
			$status[1] = $word[LANG]['no'];
			
			$myPlace = ( $data['place'] == "0" ) ? $data['id'] : $data['place'];
			
			$sql = "SELECT indexSite FROM user_extra_settings WHERE unk = '".UNK."' ";
			$res_index = mysql_db_query(DB,$sql);
			$data_index = mysql_fetch_array($res_index);
				
			if( $data_index['indexSite'] == "1" )
			{
				if( AUTH_QUERY_STR == "" )
					$status_Arr = array("select","status[]",$status,$word[LANG]['Displayed_site'],$data['status'],"data_arr[status]", "class='input_style'");
				else
					$status_Arr =array("hidden","data_arr[status]",'1');
				
				$sql = "SELECT kol_userid FROM user_site_auth WHERE id = '".AUTH_ID."' ";
				$res_userd = mysql_db_query(DB,$sql);
				$data_userd = mysql_fetch_array($res_userd);
				
				if( $data_userd['kol_userid'] != "" )
					$kol_userid_Arr = array("hidden","data_arr[kol_userid]",$data_userd['kol_userid']);
			}
			
			$authId = ( $data['auth_id'] != "0" && $data['auth_id'] != "" ) ? $data['auth_id'] : AUTH_ID;
			$form_arr = array(
				array("hidden","main","update_new_row"),
				array("hidden","type","sales"),
				array("hidden","record_id",$_REQUEST['row_id']),
				array("hidden","s_status",$_REQUEST['s_status']),
				array("hidden","sesid",SESID),
				array("hidden","data_arr[unk]",UNK),
				array("hidden","data_arr[auth_id]",$authId),
				array("hidden","unk",UNK),
				array("hidden","table",$table),
				$kol_userid_Arr,
				
				array("text","data_arr[name]",$data['name'],$word[LANG]['offer_name'], "class='input_style'","","1"),
				array("text","data_arr[serial_num]",$data['serial_num'],$word[LANG]['model'], "class='input_style'","","1"),
				array("text","data_arr[price]",$data['price'],$word[LANG]['regular_price'], "class='input_style'","","1"),
				array("text","data_arr[sale_price]",$data['sale_price'],$word[LANG]['operation_price'], "class='input_style'","","1"),
				array("new_file","img",$data['img'],$word[LANG]['picture'], "sales", "&table=".$table."&GOTO_type=sales&GOTO_main=List_View_Rows"),
				array("new_file2","img2",$data['img2'],$word[LANG]['large_image'] , "sales", "&table=".$table."&GOTO_type=sales&GOTO_main=List_View_Rows"),
				
				$status_Arr,
				
				array("text","data_arr[place]",$myPlace,$word[LANG]['location'], "class='input_style'"),
				
				array("blank",$text_editor),
				array("textarea","data_arr[summary]",$data['summary'],$word[LANG]['short_details'], "class='textarea_style_summary'","","1"),
				array("textarea","data_arr[content]",$data['content'],$word[LANG]['more_detail'], "class='textarea_style'","","1"),
				
				array("text","data_arr[url_link]",$data['url_link'],$word[LANG]['address_link'], "class='input_style'","","1"),
				array("text","data_arr[url_name]",$data['url_name'],$word[LANG]['link_name'], "class='input_style'","","1"),
				
				
				array($wtc_dates,"start_date",$wtc_val_start_date,$wtc_dates_start_txt, "class='input_style'"),
				array($wtc_dates,"end_date",$wtc_val_end_date,$wtc_dates_end_txt, "class='input_style'"),
				array("submit","submit",$word[LANG]['submit_form'], "class='submit_style'")
			);
		break;
		
		case "wanted" :
			
			$sql = "select * from ".$table." where deleted = '0' and id = '".$_REQUEST['row_id']."' and unk = '".UNK."' ".AUTH_QUERY_STR."";
			$res = mysql_db_query(DB,$sql);
			$data = mysql_fetch_array($res);
			
			
			$wtc_datetime = ( $_REQUEST['row_id'] ) ? "datetime_id" : "hidden";
			$wtc_datetime_name = ( $_REQUEST['row_id'] ) ? "not_active2" : "data_arr[date_in]";
			$wtc_val_datetime = ( $_REQUEST['row_id'] ) ? $data['date_in'] : GlobalFunctions::get_timestemp();
			
			
			if( $_REQUEST['row_id'] )
				$categories_select = "<a href='setCats.php?type=".$_REQUEST['type']."&sesid=".SESID."&unk=".UNK."&wid=".$_REQUEST['row_id']."' target='_blank'>".$word[LANG]['job_cat_appear_portal']."</a>";
			
			$myPlace = ( $data['place'] == "0" ) ? $data['id'] : $data['place'];
			
			$status[0] = $word[LANG]['yes'];
			$status[1] = $word[LANG]['no'];
			
			$sql = "SELECT indexSite FROM user_extra_settings WHERE unk = '".UNK."' ";
			$res_index = mysql_db_query(DB,$sql);
			$data_index = mysql_fetch_array($res_index);
			
			if( $data_index['indexSite'] == "1" )
			{
				if( AUTH_QUERY_STR == "" )
					$status_Arr = array("select","status[]",$status,$word[LANG]['Displayed_site'],$data['status'],"data_arr[status]", "class='input_style'");
				else
					$status_Arr =array("hidden","data_arr[status]",'1');
				
				$sql = "SELECT kol_userid FROM user_site_auth WHERE id = '".AUTH_ID."' ";
				$res_userd = mysql_db_query(DB,$sql);
				$data_userd = mysql_fetch_array($res_userd);
				
				if( $data_userd['kol_userid'] != "" )
					$kol_userid_Arr = array("hidden","data_arr[kol_userid]",$data_userd['kol_userid']);
			}
			
			$authId = ( $data['auth_id'] != "0" && $data['auth_id'] != "" ) ? $data['auth_id'] : AUTH_ID;
			$approved_by_admin[0] = "לא";
			$approved_by_admin[1] = "כן";
			if(!isset($data['approved_by_admin'])){
				$data['approved_by_admin'] = '1';
			}

			
			$sql = "SELECT * FROM user_wanted_filters_groups WHERE unk = '".UNK."' order by name";
			$res = mysql_db_query(DB,$sql);
			$filters_groups = array();
			$filters_groups_arr = array();
			while($group_row = mysql_fetch_array($res)){
				$filters_groups[] = $group_row;
				$filters_groups_arr[$group_row['id']] = array();
			}
			$sql = "SELECT * FROM user_wanted_filters WHERE unk = '".UNK."' order by name";
			$res = mysql_db_query(DB,$sql);
			while($filter_row = mysql_fetch_array($res)){
				if(!isset($filters_groups_arr[$filter_row['group_id']])){
					$filters_groups_arr[0][] = $filter_row;
				}
				else{
					$filters_groups_arr[$filter_row['group_id']][] = $filter_row;
				}
			}			
			$filter_field_input = array("hidden","data_none","");
			foreach($filters_groups as $filters_group){
				$filter_field = array();
				$filter_field['field_name'] = $filters_group['name'];
				$filter_field['values'] = array();
				foreach($filters_groups_arr[$filters_group['id']] as $filter){
					$filter_field['values'][$filter['id']] = $filter['name'];
				}
				$filter_field_input = array("select","data_arr[filter]",$filter_field['values'],$filter_field['field_name'],$data['filter'],"data_arr[filter]", "class='input_style'");
			}
	
			$created_by_title = "מנהל האתר";
			if($data['created_by_net_user']!='0'){
				$created_by_title = "גולש ממועדון לקוחות";
			}
			
			$form_arr = array(
				array("hidden","main","update_new_row"),
				array("hidden","type","wanted"),
				array("hidden","record_id",$_REQUEST['row_id']),
				array("hidden","sesid",SESID),
				array("hidden","data_arr[unk]",UNK),
				array("hidden","data_arr[auth_id]",$authId),
				array("hidden","unk",UNK),
				array("hidden","table",$table),
				$kol_userid_Arr,
				
				array($wtc_datetime,$wtc_datetime_name,$wtc_val_datetime,"תאריך העלת מודעה", "class='input_style' readonly","","hidden"),
				array("text","data_arr[name]",$data['name'],"סוג המשרה", "class='input_style'","","1"),
				array("text","data_arr[email]",$data['email'],$word[LANG]['email'], "class='input_style'","","1"),
				
				array("text","data_arr[phone]",$data['phone'],$word[LANG]['phone'], "class='input_style'","","1"),
				array("text","data_arr[site]",$data['site'],"אתר", "class='input_style'","","1"),
				array("select","data_arr[approved_by_admin]",$approved_by_admin,"מאושר",$data['approved_by_admin'],"data_arr[approved_by_admin]", "class='input_style'"),
				array("select","data_arr[filter]",$filter_field['values'],$filter_field['field_name'],$data['filter'],"data_arr[filter]", "class='input_style'"),
				array("text","data_arr[place]",$myPlace,$word[LANG]['location'], "class='input_style'"),
				array("text","created_by",$created_by_title,"נוצר על ידי","class='input_style' readonly"),
				
				$status_Arr,
				
				array( "blank" , $categories_select ),
				
				array("textarea","data_arr[content]",$data['content'],$word[LANG]['detail'], "class='textarea_style'","","1"),
				
				array("submit","submit",$word[LANG]['submit_form'], "class='submit_style'")
			);
		break;
		
		case "video" :
			
			$sql = "select * from ".$table." where deleted = '0' and id = '".$_REQUEST['row_id']."' and unk = '".UNK."' ".AUTH_QUERY_STR."";
			$res = mysql_db_query(DB,$sql);
			$data = mysql_fetch_array($res);
			
			$active[0] = $word[LANG]['yes'];
			$active[1] = $word[LANG]['no'];
			
			$wtc_datetime = ( $_REQUEST['row_id'] ) ? "datetime_id" : "hidden";
			$wtc_datetime_name = ( $_REQUEST['row_id'] ) ? "not_active2" : "data_arr[date_in]";
			$wtc_val_datetime = ( $_REQUEST['row_id'] ) ? $data['date_in'] : GlobalFunctions::get_timestemp();
			
			$sql2 = "select * from user_video_cat where deleted = '0' and unk = '".UNK."' and active = '0' order by id";
			$res2 = mysql_db_query(DB,$sql2);
			
			$count_cats = 0;
			while( $data2 = mysql_fetch_array($res2) )
			{
				$temp_id = $data2['id'];
				$cat[$temp_id] .= $data2['name'];
				$count_cats++;
			}
			if( $count_cats == 0 )
			{
				echo $word[LANG]['least_one_category'];
					exit;
			}
			
			$sql = "select belongTo10service from user_extra_settings where unk = '".UNK."'";
			$res_extra = mysql_db_query(DB,$sql);
			$data_extra = mysql_fetch_array($res_extra);
			
			$will_be_display_10service[0] = "לא";
			$will_be_display_10service[1] = "כן";
			
			$will_be_display_10service_Arr = ( $data_extra['belongTo10service'] == "1" ) ? array("select","will_be_display_10service[]",$will_be_display_10service,"יופיע בדף שלי באתר שירות 10",$data['will_be_display_10service'],"data_arr[will_be_display_10service]", "class='input_style'") : "";
			
			
			$myPlace = ( $data['place'] == "0" ) ? $data['id'] : $data['place'];
			
			$form_arr = array(
				array("hidden","main","update_new_row"),
				array("hidden","type","video"),
				array("hidden","record_id",$_REQUEST['row_id']),
				array("hidden","sesid",SESID),
				array("hidden","data_arr[unk]",UNK),
				array("hidden","data_arr[auth_id]",AUTH_ID),
				array("hidden","unk",UNK),
				array("hidden","table",$table),
				
				
				array($wtc_datetime,$wtc_datetime_name,$wtc_val_datetime,$word[LANG]['date_vid_created'], "class='input_style' readonly","","hidden"),
				array("text","data_arr[name]",$data['name'],$word[LANG]['vid_name'], "class='input_style'","","1"),
				array("select","cat[]",$cat,"* ".$word[LANG]['assing_cats'],$data['cat'],"data_arr[cat]", "class='input_style''"),
				array("text","data_arr[video_url]",$data['video_url'],$word[LANG]['vid_address'], "class='input_style'","","1"),
				array("textarea","data_arr[video_flash]",$data['video_flash'],$word[LANG]['code_flash_img'], "class='textarea_style_summary'","","1"),
				array("new_file","img",$data['img'],$word[LANG]['picture'], "video", "&table=".$table."&GOTO_type=video&GOTO_main=List_View_Rows"),
				array("select","active[]",$active,$word[LANG]['Displayed_site'],$data['active'],"data_arr[active]", "class='input_style''"),
				
				array("text","data_arr[place]",$myPlace,$word[LANG]['location'], "class='input_style'"),
				$will_be_display_10service_Arr,
				array("textarea","data_arr[summary]",$data['summary'],$word[LANG]['short_details'], "class='textarea_style_summary'","","1"),
				array("textarea","data_arr[content]",$data['content'],$word[LANG]['more_detail'], "class='textarea_style'","","1"),
				
				array("text","data_arr[url_link_href]",$data['url_link_href'],$word[LANG]['address_link'], "class='input_style'","","1"),
				array("text","data_arr[url_link_name]",$data['url_link_name'],$word[LANG]['link_name'], "class='input_style'","","1"),
				
				array("submit","submit",$word[LANG]['submit_form'], "class='submit_style'")
			);
			
		break;
		
		case "yad2" :
		
			$sql = "select * from ".$table." where deleted = '0' and id = '".$_REQUEST['row_id']."' and unk = '".UNK."' ".AUTH_QUERY_STR."";
			$res = mysql_db_query(DB,$sql);
			$data = mysql_fetch_array($res);
			
			
			$wtc_datetime = ( $_REQUEST['row_id'] ) ? "datetime_id" : "hidden";
			$wtc_datetime_name = ( $_REQUEST['row_id'] ) ? "not_active2" : "data_arr[date_in]";
			$wtc_val_datetime = ( $_REQUEST['row_id'] ) ? $data['date_in'] : GlobalFunctions::get_timestemp();
			
			$active[0] = $word[LANG]['yes'];
			$active[1] = $word[LANG]['no'];
			
			$myPlace = ( $data['place'] == "0" ) ? $data['id'] : $data['place'];
			
			$form_arr = array(
				array("hidden","main","update_new_row"),
				array("hidden","type","yad2"),
				array("hidden","record_id",$_REQUEST['row_id']),
				array("hidden","sesid",SESID),
				array("hidden","data_arr[unk]",UNK),
				array("hidden","data_arr[auth_id]",AUTH_ID),
				array("hidden","unk",UNK),
				array("hidden","table",$table),
				
				array($wtc_datetime,$wtc_datetime_name,$wtc_val_datetime,"תאריך העלת המוצר", "class='input_style' readonly","","hidden"),
				array("text","data_arr[name]",$data['name'],$word[LANG]['product_name'], "class='input_style'","","1"),
				array("text","data_arr[price]",$data['price'],"מחיר", "class='input_style'","","1"),
				array("new_file","img",$data['img'],$word[LANG]['picture'], "yad2", "&table=".$table."&GOTO_type=yad2&GOTO_main=List_View_Rows"),
				array("new_file2","img2",$data['img2'],$word[LANG]['large_image'] , "yad2", "&table=".$table."&GOTO_type=yad2&GOTO_main=List_View_Rows"),
				array("select","active[]",$active,$word[LANG]['Displayed_site'],$data['active'],"data_arr[active]", "class='input_style''"),
				array("text","data_arr[place]",$myPlace,$word[LANG]['location'], "class='input_style'"),
				
				array("textarea","data_arr[summary]",$data['summary'],$word[LANG]['short_details'], "class='textarea_style_summary'","","1"),
				array("textarea","data_arr[content]",$data['content'],$word[LANG]['more_detail'], "class='textarea_style'","","1"),
				
				array("submit","submit",$word[LANG]['submit_form'], "class='submit_style'")
			);
		break;
		
		case "products" :
		
			$sql = "select * from ".$table." where deleted = '0' and id = '".$_REQUEST['row_id']."' and unk = '".UNK."' ".AUTH_QUERY_STR."";
			$res = mysql_db_query(DB,$sql);
			$data = mysql_fetch_array($res);
			
			$sql2 = "select * from user_products_cat where deleted = '0' and unk = '".UNK."' and status = '0'";
			$res2 = mysql_db_query(DB,$sql2);
			
			
			$sql = "select have_ecom from users where deleted = '0' and unk = '".UNK."' and status = '0'";
			$res_ecom = mysql_db_query(DB,$sql);
			$data_ecom = mysql_fetch_array($res_ecom);
			
			$sql = "select nisha_sites from user_extra_settings where unk = '".UNK."'";
			$res_extraUser = mysql_db_query(DB,$sql);
			$data_extraUser = mysql_fetch_array($res_extraUser);
			
			
			$count_pro = 0;
			while( $data2 = mysql_fetch_array($res2) )
			{
				$temp_id = $data2['id'];
				$cat[$temp_id] .= $data2['name'];
				$count_pro++;
			}
			
			
			if( UNK != "285240640927706447" )
			{
				if( $count_pro == 0 )
				{
					echo $word[LANG]['least_one_sub_topic'];
						exit;
				}
			}
			
			
			$wtc_datetime = ( $_REQUEST['row_id'] ) ? "datetime_id" : "hidden";
			$wtc_datetime_name = ( $_REQUEST['row_id'] ) ? "not_active2" : "data_arr[date_in]";
			$wtc_val_datetime = ( $_REQUEST['row_id'] ) ? $data['date_in'] : GlobalFunctions::get_timestemp();
			
			$wtc_wcom_acitve_product = ( $data_ecom['have_ecom'] == "1" ) ? "select" : "hidden";
			$wtc_ecom_makay_product = ( $data_ecom['have_ecom'] == "1" ) ? "text" : "hidden";
			
			
			$active[0] = $word[LANG]['yes'];
			$active[1] = $word[LANG]['no'];
			
			$active_ecom[0] = "לא להציג";
			$active_ecom[1] = "להציג";
			
			$blank_cat_prod = "<b><u>האתר שלי:</u></b><br>";
			$blank_cat_prod .= products_multi_choosen(UNK);
			if( $data_extraUser['nisha_sites'] != "" )
			{
				$nisha_sites = json_decode($data_extraUser['nisha_sites']);
				
				foreach( $nisha_sites as $key => $val )
				{
					$sql = "SELECT name , unk FROM users WHERE id = '".(int)$val."' ";
					$resNishaS = mysql_db_query(DB,$sql);
					$dataNishaS = mysql_fetch_array($resNishaS);
					
					$blank_cat_prod .= "<br><br><b><u>אתר נישה: ".stripslashes($dataNishaS['name'])."</u></b><br>";
					$blank_cat_prod .= products_multi_choosen($dataNishaS['unk']);
				}
			}
			
			
			$blank_cat_prod2 = "<table class='maintext'><tr><td valign=top>שיוך לקטגוריות מרובות</td><td width=10></td><td>".$blank_cat_prod."</td></tr></table>";
			
			
			// Use to kupons sms - 	S T A R T
			$sql = "select haveSmsDiscount from user_extra_settings where unk = '".UNK."'";
			$res = mysql_db_query(DB,$sql);
			$data_smsDiscount = mysql_fetch_array($res);
			if( $data_smsDiscount['haveSmsDiscount'] == "1" )
			{
				$sql = "SELECT sms_content FROM products_kupons WHERE module_name = 'pr' AND item_id = '".$_REQUEST['row_id']."' ";
				$res = mysql_db_query(DB,$sql);
				$sms_content = mysql_fetch_array($res);
				
				$smsDiscount = array("text" , "smsDiscount" , $sms_content['sms_content'] , $word[LANG]['smsDiscount'] , "class='input_style'"  );
			}
			// Use to kupons sms - 	E N D
			
			
			
			// 10 Servise options	-  S T A R T
			if( UNK == "285240640927706447" )
			{
				for( $i=0 ; $i <= 100 ; $i++ )
				{
					$remain_stock[$i] = $i;
				}
				$price_10service = array("text","data_arr[price_10service]",$data['price_10service'],"* מחיר שירות 10", "class='input_style'");
				
				$remain_stock = array("select","remain_stock[]",$remain_stock,"* מלאי שנותר",$data['remain_stock'],"data_arr[remain_stock]", "class='input_style' DISABLED");
				
				
				$sql = "select u.id, u.name FROM 
					users as u,
					user_cat as uc,
					biz_categories as bc ,
					user_extra_settings as us
						WHERE 
							us.unk=u.unk AND
							u.deleted=0 AND
							u.status=0 AND
						  u.end_date > NOW() AND
							us.belongTo10service=1 AND
							u.id=uc.user_id AND
							uc.cat_id=bc.id AND
							bc.status=1
					 GROUP BY u.id";
				$res_choosenClient = mysql_db_query(DB, $sql);
				
				$belongToUser10service = array();
				while( $val_choosenClient = mysql_fetch_array($res_choosenClient) )
				{
					$clientId = $val_choosenClient['id'];
					$belongToUser10service[$clientId] = stripslashes($val_choosenClient['name']);
				}
				
				$belongToUser10service = array("select","belongToUser10service[]",$belongToUser10service,"* שייך ללקוח",$data['belongToUser10service'],"data_arr[belongToUser10service]", "class='input_style'");
				
				
				$wtc_val_start_date = ( $data['auto_date_10service'] != "0000-00-00" && $data['auto_date_10service'] != "" ) ? $data['auto_date_10service'] : GlobalFunctions::get_date();
				
				$auto_date_10service = array("date","auto_date_10service",$wtc_val_start_date,"תאריך אוטומטי <br><font style=\"font-size:9px;\" class=\"maintext_small\">dd-mm-yyyy</font>", "class='input_style'");
				
				if( $data['id'] != "" )
					$array_blank_cat = array("blank","<a href='setCatsUniversal.php?xid=".$data['id']."&xtype=2&unk=".UNK."&sesid=".SESID."' class='maintext' target='_blank'>עדכן קטגוריות</a>");
				
				
				$lock_10serviceArr[0] = "לא";
				$lock_10serviceArr[1] = "כן";
				
				$service10_biz_pro[0] = "לא";
				$service10_biz_pro[1] = "כן";
				
				$lock_10service = array("select","lock_10service[]",$lock_10serviceArr,"לנעול לעריכת לקוח?",$data['lock_10service'],"data_arr[lock_10service]", "class='input_style'");
				$service_biz_pro = array("select","10service_biz_pro[]",$service10_biz_pro,"מוצר לעסקים",$data['10service_biz_pro'],"data_arr[10service_biz_pro]", "class='input_style'");
			}
			else
			{
				$array_blank_cat = array("blank",$blank_cat_prod2);
			}
			// 10 Servise options	-  E N D
			
			$video_10service = array("text","data_arr[video_10service]",$data['video_10service'],"כתובת וידיאו", "class='input_style'");
			
				if( $data['id'] != "" )
					$array_multi_img_up = array("blank","<a href='index.php?main=edit_10service_product_images&product_id=".$data['id']."&unk=".UNK."&sesid=".SESID."' class='maintext' target='_blank'>עלה 4 תמונות נוספות למוצר</a>");
			
			
			if( UNK == "625420717714095702" )
				$price_special = array("text","data_arr[price_special]",$data['price_special'],"מחיר לחברי העמותה", "class='input_style'","","1");
			else
				$price_special = "";
				
				
			
			$sql = "select belongTo10service from user_extra_settings where unk = '".UNK."'";
			$res_extra = mysql_db_query(DB,$sql);
			$data_extra = mysql_fetch_array($res_extra);
			
			$will_be_display_10service[0] = "לא";
			$will_be_display_10service[1] = "כן";
			
			$will_be_display_10service_Arr = ( $data_extra['belongTo10service'] == "1" ) ? array("select","will_be_display_10service[]",$will_be_display_10service,"יופיע בדף שלי באתר שירות 10",$data['will_be_display_10service'],"data_arr[will_be_display_10service]", "class='input_style'") : "";
			
			$myPlace = ( $data['place'] == "0" ) ? $data['id'] : $data['place'];
			
			$form_arr = array(
				array("hidden","main","update_new_row"),
				array("hidden","type","products"),
				array("hidden","record_id",$_REQUEST['row_id']),
				array("hidden","sesid",SESID),
				array("hidden","data_arr[unk]",UNK),
				array("hidden","data_arr[auth_id]",AUTH_ID),
				array("hidden","unk",UNK),
				array("hidden","table",$table),
				
				array($wtc_datetime,$wtc_datetime_name,$wtc_val_datetime,"תאריך העלת המוצר", "class='input_style' readonly","","hidden"),
				$auto_date_10service,
				$array_blank_cat,
				$belongToUser10service,$lock_10service,$service_biz_pro,
				
				array("text","data_arr[name]",$data['name'],$word[LANG]['product_name'], "class='input_style'","","1"),
				array("text","data_arr[price]",$data['price'],"מחיר", "class='input_style'","","1"),
				$price_special,
				$price_10service,
				array($wtc_wcom_acitve_product,"active_ecom[]",$active_ecom,"להציג בחנות/יש במלאי",$data['active_ecom'],"data_arr[active_ecom]", "class='input_style''"),
				$remain_stock,
				array($wtc_ecom_makay_product,"data_arr[makat]",$data['makat'],"מס' קטלוגי", "class='input_style'","","1"),
				
				array("new_file","img",$data['img'],$word[LANG]['picture'], "products", "&table=".$table."&GOTO_type=products&GOTO_main=List_View_Rows"),
				array("new_file2","img2",$data['img2'],$word[LANG]['large_image'] , "products", "&table=".$table."&GOTO_type=products&GOTO_main=List_View_Rows"),
				array("new_file3","img3",$data['img3'],"תמונה ענקית", "products", "&table=".$table."&GOTO_type=products&GOTO_main=List_View_Rows"),
				$array_multi_img_up,
				$video_10service,
				array("select","active[]",$active,$word[LANG]['Displayed_site'],$data['active'],"data_arr[active]", "class='input_style''"),
				array("text","data_arr[place]",$myPlace,$word[LANG]['location'], "class='input_style'"),
				$will_be_display_10service_Arr,
					
					
				array("textarea","data_arr[summary]",$data['summary'],$word[LANG]['short_details'], "class='textarea_style_summary' style='width: 300px;'  onKeyDown='textCounter(this,document.editorhtml.remLen1,250)' onKeyUp='textCounter(this,document.editorhtml.remLen1,250)'","","1"),
				array("text","remLen1","250","הגבלת תווים של פירוט קצר", "class='input_style' size='3' maxlength='3' readonly style='border: 0px;' "),
				array("textarea","data_arr[content]",$data['content'],$word[LANG]['more_detail'], "class='textarea_style' style='width: 300px;'","","1"),
				
				array("text","data_arr[url_name]",$data['url_name'],$word[LANG]['link_name'], "class='input_style'","","1"),
				array("text","data_arr[url_link]",$data['url_link'],$word[LANG]['address_link'], "class='input_style'","","1"),
				
				$smsDiscount,
				
				array("text","data_arr[kobia_msg]",$data['kobia_msg'],"טקסט ברשימת מוצרים", "class='input_style'","","1"),
				array("text","data_arr[kobia_msg_bg]",$data['kobia_msg_bg'],"טקסט ברשימת מוצרים - צבע רקע", "class='input_style'","","1"),
				array("text","data_arr[kobia_msg_color]",$data['kobia_msg_color'],"טקסט ברשימת מוצרים - צבע טקסט", "class='input_style'","","1"),
				
				
				array("submit","submit",$word[LANG]['submit_form'], "class='submit_style'")
			);
		break;
		
		
		case "10service_product" :
			$sql = "SELECT id FROM users WHERE unk = '".UNK."'";
			$res = mysql_db_query(DB,$sql);
			$myId = mysql_fetch_array($res);
			
			$sql = "select * from user_products where deleted = '0' and id = '".$_REQUEST['row_id']."' and unk = '285240640927706447' AND belongToUser10service = '".$myId['id']."' ".AUTH_QUERY_STR."";
			$res = mysql_db_query(DB,$sql);
			$data = mysql_fetch_array($res);
			
			
			$wtc_datetime = ( $_REQUEST['row_id'] ) ? "datetime_id" : "hidden";
			$wtc_datetime_name = ( $_REQUEST['row_id'] ) ? "not_active2" : "data_arr[date_in]";
			$wtc_val_datetime = ( $_REQUEST['row_id'] ) ? $data['date_in'] : GlobalFunctions::get_timestemp();
			
			$wtc_wcom_acitve_product = ( $data_ecom['have_ecom'] == "1" ) ? "select" : "hidden";
			$wtc_ecom_makay_product = ( $data_ecom['have_ecom'] == "1" ) ? "text" : "hidden";
			
			
			$active[0] = $word[LANG]['yes'];
			$active[1] = $word[LANG]['no'];
			
			$active_ecom[0] = "לא להציג";
			$active_ecom[1] = "להציג";
			
			$readonly = ( $data['lock_10service'] == "1" ) ? "readonly" : "";
			$disabled = ( $data['lock_10service'] == "1" ) ? "DISABLED" : "";
			
			for( $i=0 ; $i <= 100 ; $i++ )
			{
				$remain_stock[$i] = $i;
			}
			$price_10service = array("text","data_arr[price_10service]",$data['price_10service'],"* מחיר שירות 10", "class='input_style' ".$readonly);
			
			$remain_stock = array("select","remain_stock[]",$remain_stock,"* מלאי שנותר",$data['remain_stock'],"data_arr[remain_stock]", "class='input_style' DISABLED");
				
				
			$wtc_val_start_date = ( $data['auto_date_10service'] != "0000-00-00" && $data['auto_date_10service'] != "" ) ? $data['auto_date_10service'] : GlobalFunctions::get_date();
			
			$auto_date_10service = array("date","auto_date_10service",$wtc_val_start_date,"תאריך אוטומטי <br><font style=\"font-size:9px;\" class=\"maintext_small\">dd-mm-yyyy</font>", "class='input_style'");
				
			if( $data['id'] != "" && $data['lock_10service'] != "1" )
				$array_blank_cat = array("blank","<a href='setCatsUniversal.php?xid=".$data['id']."&xtype=2&b1s=1&unk=".UNK."&sesid=".SESID."' class='maintext' target='_blank'>עדכן קטגוריות</a>");
			
			
			$video_10service = array("text","data_arr[video_10service]",$data['video_10service'],"כתובת וידיאו", "class='input_style' ".$readonly);
			
			if( $data['id'] != "" && $data['lock_10service'] != "1" )
				$array_multi_img_up = array("blank","<a href='index.php?main=edit_10service_product_images&product_id=".$data['id']."&b1s=1&unk=".UNK."&sesid=".SESID."' class='maintext' target='_blank'>עלה 4 תמונות נוספות למוצר</a>");
			
			if( $data['lock_10service'] != "1" )
				$img_big = array("new_file3_10service","img3",$data['img3'],"תמונה ענקית", "products", "&table=".$table."&GOTO_type=products&GOTO_main=List_View_Rows");
			
			
			$myPlace = ( $data['place'] == "0" ) ? $data['id'] : $data['place'];
			
			if( !$_REQUEST['row_id'] )
				$some_Text = "ניתן להוסיף מוצר לשירות 10 מחיר 10 בתהליך הבא:<br>תחילה יש למלאות את הטופס ואז ללחוץ 'שלח טופס'<br>לאחר מכן יש להכנס 'לעדכון' 
				של המוצר שהוספתם - שם להכניס קטגוריות תחת הקישור 'קטגוריות' ולהוסיף 4 תמונות נוספות בקישור המתווסף'<br><Br>";
			
			if( $data['lock_10service'] != "1" )
			{
				$form_arr = array(
					array("hidden","main","update_new_row"),
					array("hidden","type","10service_product"),
					array("hidden","record_id",$_REQUEST['row_id']),
					array("hidden","sesid",SESID),
					array("hidden","data_arr[unk]",UNK),
					array("hidden","data_arr[auth_id]",AUTH_ID),
					array("hidden","unk",UNK),
					array("hidden","table","user_products"),
					
					array( "blank" , $some_Text ),
					array($wtc_datetime,$wtc_datetime_name,$wtc_val_datetime,"תאריך העלת המוצר", "class='input_style' readonly","","hidden"),
					$auto_date_10service,
					$array_blank_cat,
					
					array("text","data_arr[name]",stripslashes($data['name']),$word[LANG]['product_name'], "class='input_style' ".$readonly."","","1"),
					array("text","data_arr[price]",$data['price'],"מחיר", "class='input_style' ".$readonly."","","1"),
					$price_10service,
					array($wtc_wcom_acitve_product,"active_ecom[]",$active_ecom,"להציג בחנות/יש במלאי",$data['active_ecom'],"data_arr[active_ecom]", "class='input_style'  ".$disabled.""),
					$remain_stock,
					array($wtc_ecom_makay_product,"data_arr[makat]",$data['makat'],"מס' קטלוגי", "class='input_style' ".$readonly."","","1"),
					
					$img_big,
					
					$array_multi_img_up,
					$video_10service,
					array("select","active[]",$active,$word[LANG]['Displayed_site'],$data['active'],"data_arr[active]", "class='input_style' ".$disabled.""),
					array("text","data_arr[place]",$myPlace,$word[LANG]['location'], "class='input_style' ".$readonly.""),
					
					
					array("textarea","data_arr[summary]",$data['summary'],$word[LANG]['short_details'], "class='textarea_style_summary' ".$readonly."  onKeyDown='textCounter(this,document.editorhtml.remLen1,250)' onKeyUp='textCounter(this,document.editorhtml.remLen1,250)'","","1"),
					array("text","remLen1","250","הגבלת תווים של פירוט קצר", "class='input_style' size='3' maxlength='3' readonly style='border: 0px;' "),
				
					array("textarea","data_arr[content]",$data['content'],$word[LANG]['more_detail'], "class='textarea_style' ".$readonly."","","1"),
					
					array("text","data_arr[url_link]",$data['url_link'],$word[LANG]['address_link'], "class='input_style' ".$readonly."","","1"),
					array("text","data_arr[url_name]",$data['url_name'],$word[LANG]['link_name'], "class='input_style' ".$readonly."","","1"),
					
					
					array("submit","submit",$word[LANG]['submit_form'], "class='submit_style'")
				);
			}
			else
			{
				$ss = "
				<b>תאריך העלת המוצר :</b> ".$wtc_val_datetime."<br><br>
				<b>תאריך אוטומטי :</b> ".$wtc_val_start_date."<br><br>
				<b>".$word[LANG]['product_name']." :</b> ".stripslashes($data['name'])."<Br><br>
				<b>מחיר :</b> ".stripslashes($data['price'])."<Br><br>
				<b>מחיר שירות 10 :</b> ".stripslashes($data['price_10service'])."<Br><br>
				<b>".$word[LANG]['short_details']." :</b> ".nl2br(stripslashes($data['summary']))."<Br><br>
				<b>".$word[LANG]['more_detail']." :</b> ".nl2br(stripslashes($data['content']))."<Br><br>
				";
				$form_arr = array(
					array( "blank" , $ss ),
					array("submit","submit",$word[LANG]['submit_form'], "style='visibility:hidden;'")
				);
			}
		break;
		
		
		case "deal_coupon" :
			
			
			if( UNK == "285240640927706447" )
			{
				$sql = "select * from 10service_deal_coupon where deleted = '0' and id = '".$_REQUEST['row_id']."' ".AUTH_QUERY_STR."";
			}
			else
			{
				$sql = "SELECT id FROM users WHERE unk = '".UNK."'";
				$res = mysql_db_query(DB,$sql);
				$myId = mysql_fetch_array($res);
				
				$sql = "select * from 10service_deal_coupon where deleted = '0' and id = '".$_REQUEST['row_id']."' and user_id = '".$myId['id']."' ".AUTH_QUERY_STR."";
			}
			$res = mysql_db_query(DB,$sql);
			$data = mysql_fetch_array($res);
			
			
			$sql = "SELECT name FROM users WHERE id = '".$data['user_id']."'";
			$res34 = mysql_db_query(DB,$sql);
			$dataUserClient = mysql_fetch_array($res34);
			
			
			$wtc_datetime = ( $_REQUEST['row_id'] ) ? "datetime_id" : "hidden";
			$wtc_datetime_name = ( $_REQUEST['row_id'] ) ? "not_active2" : "data_arr[insert_date]";
			$wtc_val_datetime = ( $_REQUEST['row_id'] ) ? $data['insert_date'] : GlobalFunctions::get_timestemp();
			
			$video_url = array("text","data_arr[video_url]",$data['video_url'],"כתובת וידיאו", "class='input_style' ".$readonly);
			
			$active[0] = $word[LANG]['yes'];
			$active[1] = $word[LANG]['no'];
			
			$readonly = ( $data['lock_10service'] == "1" ) ? "readonly" : "";
			$disabled = ( $data['lock_10service'] == "1" ) ? "DISABLED" : "";
			
			for( $i=0 ; $i <= 100 ; $i++ )
			{
				$in_stock[$i] = $i;
			}
			$new_price = array("text","data_arr[new_price]",$data['new_price'],"מחיר סופי לאחר הנחה", "class='input_style' ".$readonly);
			$old_price = array("text","data_arr[old_price]",$data['old_price'],"מחיר רגיל", "class='input_style' ".$readonly);
			
			$in_stock = array("select","in_stock[]",$in_stock,"* מלאי שנותר",$data['in_stock'],"data_arr[in_stock]", "class='input_style' ".$disabled."");
			
			if( $_REQUEST['row_id'] )
			$bought = array("text","bought2222",$data['bought'],"קופונים שנמכרו", "class='input_style' size='4' readonly");
			
			if( $data['id'] != "" )
				$array_blank_cat = array("blank","<a href='setCatsUniversal.php?xid=".$data['id']."&xtype=4&b1s=1&unk=".UNK."&sesid=".SESID."' class='maintext' target='_blank'>עדכן קטגוריות</a>");
			
			if( $data['lock_10service'] != "1" )
			{
				$img1 = array("new_file_deal_coupon","img1",$data['img1'],"תמונה 1", "deal_coupon", "&table=".$table."&GOTO_type=deal_coupon&GOTO_main=List_View_Rows");
				$img2 = array("new_file_deal_coupon","img2",$data['img2'],"תמונה 2", "deal_coupon", "&table=".$table."&GOTO_type=deal_coupon&GOTO_main=List_View_Rows");
				$img3 = array("new_file_deal_coupon","img3",$data['img3'],"תמונה 3", "deal_coupon", "&table=".$table."&GOTO_type=deal_coupon&GOTO_main=List_View_Rows");
			}
			
			echo '
			<script type="text/javascript">
					$(document).ready(function() {
						$("#until_date").datetimepicker({dateFormat: \'dd-mm-yy\' });
					});
			</script>
			';
		
			$stra = explode(" ",$data['until_date']);
			$new_date = explode("-",$stra[0]);
			$thedate = $new_date[2]."-".$new_date[1]."-".$new_date[0]." ".$stra[1];
			
			if( UNK == "285240640927706447" )
			{
				$lock_10serviceArr[0] = "לא";
				$lock_10serviceArr[1] = "כן";
				
				$lock_10service = array("select","lock_10service[]",$lock_10serviceArr,"לנעול לעריכת לקוח?",$data['lock_10service'],"data_arr[lock_10service]", "class='input_style'");
				
				$userIdMy = $data['user_id'];
				$user_id_list[$userIdMy] = stripslashes($dataUserClient['name']);
				$user_id = array("select","user_id[]",$user_id_list,"שייך ללקוח:",$data['user_id'],"data_arr[user_id]", "class='input_style' DISABLED");
				$coupon_price = array("text","data_arr[coupon_price]",$data['coupon_price'],"מחיר הקופון", "class='input_style' ");
			}
			else
			{
				$lock_10service = "";
				$user_id = "";
				$coupon_price = "";
			}
			
			
			
			if( $data['lock_10service'] != "1" || UNK == "285240640927706447" )
			{
				$form_arr = array(
					array("hidden","main","update_new_row"),
					array("hidden","type","deal_coupon"),
					array("hidden","record_id",$_REQUEST['row_id']),
					array("hidden","sesid",SESID),
					array("hidden","data_arr[unk]",UNK),
					array("hidden","data_arr[auth_id]",AUTH_ID),
					array("hidden","unk",UNK),
					array("hidden","table","10service_deal_coupon"),
					
					array( "blank" , $some_Text ),
					array($wtc_datetime,$wtc_datetime_name,$wtc_val_datetime,"תאריך העלת המוצר", "class='input_style' readonly","","hidden"),
					$array_blank_cat,
					
					array("text","data_arr[headline]",stripslashes($data['headline']),"שם המוצר", "class='input_style' ".$readonly."","","1"),
					$user_id,$coupon_price,$new_price,$old_price,
					$in_stock,
					$bought,
					$img1,$img2,$img3,
					
					$video_url,$lock_10service,
					array("select","active[]",$active,$word[LANG]['Displayed_site'],$data['active'],"data_arr[active]", "class='input_style' ".$disabled.""),
					
					array("textarea","data_arr[summery]",$data['summery'],$word[LANG]['short_details'], "class='textarea_style_summary' ".$readonly."  onKeyDown='textCounter(this,document.editorhtml.remLen1,250)' onKeyUp='textCounter(this,document.editorhtml.remLen1,250)'","","1"),
					array("text","remLen1","250","הגבלת תווים של פירוט קצר", "class='input_style' size='3' maxlength='3' readonly style='border: 0px;' "),
					
					array("text","until_date",$thedate,"תאריך ושעה הפסקת מכירת הקופון באתר", "class='input_style' dir=ltr"),
					
					array("textarea","data_arr[content]",$data['content'],$word[LANG]['more_detail'], "class='textarea_style' ".$readonly."","","1"),
					
					
					
					array("submit","submit",$word[LANG]['submit_form'], "class='submit_style'")
				);
			}
			else
			{
				$ss = "
				<b>תאריך העלת המוצר :</b> ".$wtc_val_datetime."<br><br>
				<b>שם המוצר :</b> ".stripslashes($data['headline'])."<Br><br>
				<b>מחיר רגיל :</b> ".stripslashes($data['old_price'])."<Br><br>
				<b>מחיר המוצר עם קופון :</b> ".stripslashes($data['new_price'])."<Br><br>
				<b>מחיר הקופון :</b> ".stripslashes($data['coupon_price'])."<Br><br>
				
				<b>מלאי :</b> ".nl2br(stripslashes($data['in_stock']))."<Br><br>
				<b>נמכרו :</b> ".nl2br(stripslashes($data['bought']))."<Br><br>
				
				<b>תקציר :</b> ".nl2br(stripslashes($data['summary']))."<Br><br>
				<b>תיאור :</b> ".nl2br(stripslashes($data['content']))."<Br><br>
				";
				$form_arr = array(
					array( "blank" , $ss ),
					array("submit","submit",$word[LANG]['submit_form'], "style='visibility:hidden;'")
				);
			}
		break;
		
		
		
		
		case "products_cat" :
		
			$sql = "select * from user_products_cat where deleted = '0' and id = '".$_REQUEST['row_id']."' and unk = '".UNK."' ".AUTH_QUERY_STR."";
			$res = mysql_db_query(DB,$sql);
			$data = mysql_fetch_array($res);
			
			$status[0] = $word[LANG]['yes'];
			$status[1] = $word[LANG]['no'];
			
			$sql2 = "select * from user_products_subject where deleted = '0' and unk = '".UNK."' and active = '0'";
			$res2 = mysql_db_query(DB,$sql2);
			
			$count_pro = 0;
			while( $data2 = mysql_fetch_array($res2) )
			{
				$temp_id = $data2['id'];
				$subject_id[$temp_id] .= $data2['name'];
				$count_pro++;
			}
			
			$form_arr = array(
				array("hidden","main","update_new_row"),
				array("hidden","type","products_cat"),
				array("hidden","record_id",$_REQUEST['row_id']),
				array("hidden","sesid",SESID),
				array("hidden","data_arr[unk]",UNK),
				array("hidden","unk",UNK),
				array("hidden","table",$table),
				
				array("text","data_arr[name]",$data['name'],$word[LANG]['category_name'], "class='input_style'","","1"),
				array("select","subject_id[]",$subject_id,"שיוך לנושא",$data['subject_id'],"data_arr[subject_id]", "class='input_style''" , "יש להכניס נושא אחד לפחות"),
				array("select","status[]",$status,$word[LANG]['Displayed_site'],$data['status'],"data_arr[status]", "class='input_style''"),
				
				array("submit","submit",$word[LANG]['submit_form'], "class='submit_style'")
			);
		break;
		
		case "products_subject" :
		
			$sql = "select * from user_products_subject where deleted = '0' and id = '".$_REQUEST['row_id']."' and unk = '".UNK."' ".AUTH_QUERY_STR."";
			$res = mysql_db_query(DB,$sql);
			$data = mysql_fetch_array($res);
			
			$active[0] = $word[LANG]['yes'];
			$active[1] = $word[LANG]['no'];
			
			$form_arr = array(
				array("hidden","main","update_new_row"),
				array("hidden","type","products_subject"),
				array("hidden","record_id",$_REQUEST['row_id']),
				array("hidden","sesid",SESID),
				array("hidden","data_arr[unk]",UNK),
				array("hidden","unk",UNK),
				array("hidden","table","user_products_subject"),
				
				array("text","data_arr[name]",$data['name'],$word[LANG]['topic_name'], "class='input_style'","","1"),
				array("select","active[]",$active,$word[LANG]['Displayed_site'],$data['active'],"data_arr[active]", "class='input_style''"),
				
				array("submit","submit",$word[LANG]['submit_form'], "class='submit_style'")
			);
		break;
		
		case "gallery_cat" :
		
			$sql = "select * from user_gallery_cat where deleted = '0' and id = '".$_REQUEST['row_id']."' and unk = '".UNK."' ".AUTH_QUERY_STR."";
			$res = mysql_db_query(DB,$sql);
			$data = mysql_fetch_array($res);
			
			$active[0] = $word[LANG]['yes'];
			$active[1] = $word[LANG]['no'];
			
			
			$sql2 = "select * from user_images_cat_subject where deleted = '0' and unk = '".UNK."' and active = '0'";
			$res2 = mysql_db_query(DB,$sql2);
			
			$count_pro = 0;
			while( $data2 = mysql_fetch_array($res2) )
			{
				$temp_id = $data2['id'];
				$subject_id[$temp_id] .= $data2['name'];
				$count_pro++;
			}
			
			
			
			
			$form_arr = array(
				array("hidden","main","update_new_row"),
				array("hidden","type","gallery_cat"),
				array("hidden","record_id",$_REQUEST['row_id']),
				array("hidden","sesid",SESID),
				array("hidden","data_arr[unk]",UNK),
				array("hidden","unk",UNK),
				array("hidden","table","user_gallery_cat"),
				
				array("text","data_arr[name]",$data['name'],$word[LANG]['category_name'], "class='input_style'","","1"),
				array("text","data_arr[place]",$data['place'],$word[LANG]['place'], "class='input_style'","","1"),
				array("select","subject_id[]",$subject_id,$word[LANG]['Affiliation_topic'],$data['subject_id'],"data_arr[subject_id]", "class='input_style'" , $word[LANG]['least_one_topic']),
				array("select","active[]",$active,$word[LANG]['Displayed_site'],$data['active'],"data_arr[active]", "class='input_style''"),
				
				array("submit","submit",$word[LANG]['submit_form'], "class='submit_style'")
			);
		break;
		
		
		case "gallery_subject" :
		
			$sql = "select * from user_images_cat_subject where deleted = '0' and id = '".$_REQUEST['row_id']."' and unk = '".UNK."' ".AUTH_QUERY_STR."";
			$res = mysql_db_query(DB,$sql);
			$data = mysql_fetch_array($res);
			
			$active[0] = $word[LANG]['yes'];
			$active[1] = $word[LANG]['no'];
			
			$form_arr = array(
				array("hidden","main","update_new_row"),
				array("hidden","type","gallery_subject"),
				array("hidden","record_id",$_REQUEST['row_id']),
				array("hidden","sesid",SESID),
				array("hidden","data_arr[unk]",UNK),
				array("hidden","unk",UNK),
				array("hidden","table","user_images_cat_subject"),
				
				array("text","data_arr[name]",$data['name'],$word[LANG]['topic_name'], "class='input_style'","","1"),
				array("select","active[]",$active,$word[LANG]['Displayed_site'],$data['active'],"data_arr[active]", "class='input_style''"),
				
				array("submit","submit",$word[LANG]['submit_form'], "class='submit_style'")
			);
		break;
		
		
		case "articels_cat" :
		case "video_cat" :
			
			$sql = "select * from user_".$_REQUEST['type']." where deleted = '0' and id = '".$_REQUEST['row_id']."' and unk = '".UNK."' ".AUTH_QUERY_STR."";
			$res = mysql_db_query(DB,$sql);
			$data = mysql_fetch_array($res);
			
			$active[0] = $word[LANG]['yes'];
			$active[1] = $word[LANG]['no'];
			
			$form_arr = array(
				array("hidden","main","update_new_row"),
				array("hidden","type",$_REQUEST['type']),
				array("hidden","record_id",$_REQUEST['row_id']),
				array("hidden","sesid",SESID),
				array("hidden","data_arr[unk]",UNK),
				array("hidden","unk",UNK),
				array("hidden","table","user_".$_REQUEST['type']),
				
				array("text","data_arr[name]",$data['name'],$word[LANG]['category_name'], "class='input_style'","","1"),
				array("text","data_arr[hp_order]",$data['hp_order'],$word[LANG]['location'], "class='input_style'","","1"),
				array("select","active[]",$active,$word[LANG]['Displayed_site'],$data['active'],"data_arr[active]", "class='input_style''"),
				
				array("submit","submit",$word[LANG]['submit_form'], "class='submit_style'")
			);
		break;
		
		case "contact" :
			$table = "user_contact_forms";
			
			$sql = "select * from ".$table." where id = '".$_REQUEST['row_id']."' and unk = '".UNK."'";
			$res = mysql_db_query(DB,$sql);
			$data = mysql_fetch_array($res);
			
			$wtc_datetime = ( $_REQUEST['row_id'] ) ? "datetime_id" : "";
			$wtc_datetime_name = ( $_REQUEST['row_id'] ) ? "not_active2" : "";
			$wtc_val_datetime = ( $_REQUEST['row_id'] ) ? $data['date_in'] : "";
			
			$status[0] = $word[LANG]['Interested_service'];
			$status[1] = $word[LANG]['talked_with_him'];
			$status[5] = $word[LANG]['Waiting_phone'];
			$status[2] = $word[LANG]['Close_customer'];
			$status[3] = $word[LANG]['Registered_customers'];
			$status[4] = $word[LANG]['Not_relevant'];
			
			$lead = new leadSys();
			
			$hiddenMain = array("hidden","main","update_new_row");
			$hidden_type = array("hidden","type","contact");
			$hidden_id = array("hidden","record_id",$_REQUEST['row_id']);
			$hidden_sesid = array("hidden","sesid",SESID);
			$hidden_unk = array("hidden","data_arr[unk]",UNK);
			$hidden_unk2 = array("hidden","unk",UNK);
			$hidden_table = array("hidden","table",$table);
			
			$text_datetime_id = array($wtc_datetime,$wtc_datetime_name,$wtc_val_datetime,$word[LANG]['sending_date'], "class='input_style' readonly","","hidden");
			if($data['status'] != '6'){
				$select_status = array("select","status[]",$status,$word[LANG]['status'],$data['status'],"data_arr[status]", "class='input_style'");
			}
			else{
				$select_status = array("hidden","data_arr[status]",$data['status'],$word[LANG]['status']."(ליד זה קיבל זיכוי)", "class='input_style'");
			}
			$text_name = array("text","data_arr[name]",$data['name'],$word[LANG]['full_name'], "class='input_style'");


			$sql = "SELECT credit_price,hide_refund FROM user_lead_settings WHERE unk = '".UNK."' ";
			$res3Cr = mysql_db_query(DB, $sql);
			$dataUserCr = mysql_fetch_array($res3Cr); 	
			
			//after 2016-06-01 leads will be seen only when opened by password. untill then, all new open mode leads will get value(payByPassword) 1
			if((new DateTime() < new DateTime("2016-09-01 12:00:00")) && ($lead->cheackLeadSentToContact(UNK) != 6 || ( !eregi("mysave", $data['name']) && !eregi("10service", $data['name']) && !eregi("uri4u", $data['name']) )) )
			{
				$lead->updateViewedLead(UNK, $data['estimateFormID'], "0", "1");
				$text_email = array("text","data_arr[email]",$data['email'],$word[LANG]['e_mail'], "class='input_style'");
				$text_phone = array("text","data_arr[phone]",$data['phone'],$word[LANG]['phone'], "class='input_style'","","1");
				$text_mobile = array("text","data_arr[mobile]",$data['mobile'],$word[LANG]['Cell'], "class='input_style'","","1");
			}
			else
			{
				$sql = "SELECT credit_price,hide_refund FROM user_lead_settings WHERE unk = '".$_GET['unk']."' ";
				$res3Cr = mysql_db_query(DB, $sql);
				$dataUserCr = mysql_fetch_array($res3Cr); 
				
				if( $data['payByPassword'] == "1" )
				{
					$text_email = array("text","data_arr[email]",$data['email'],$word[LANG]['e_mail'], "class='input_style'");
					$text_phone = array("text","data_arr[phone]",$data['phone'],$word[LANG]['phone'], "class='input_style'","","1");
					$text_mobile = array("text","data_arr[mobile]",$data['mobile'],$word[LANG]['Cell'], "class='input_style'","","1");
					$lead->updateViewedLead(UNK, $data['estimateFormID'], "2", "1");
				}
				else
				{
					$sql = "SELECT belongTo10service FROM user_extra_settings WHERE unk = '".$_GET['unk']."' ";
					$res210s = mysql_db_query(DB, $sql);
					$dataUser10s = mysql_fetch_array($res210s);
					$creditMoney = new creditMoney;
					$credits = $creditMoney->get_creditMoney( "users" , $_GET['unk'] , "1" );
					
					$phone = substr_replace( $data['phone'] , "****" , 4 , 4 );
					
					$temp_email = explode( "@" , stripslashes($data['email']) );
					$len = strlen($temp_email[0]);
					$spar = "";
					for( $i=0 ; $i<=$len-2 ; $i++ )
						$spar .= "*";
					$email = substr_replace( $temp_email[0] , $spar , 1 , strlen($spar) );
					
					$len2 = strlen($temp_email[1]);
					$spar1 = "";
					for( $j=0 ; $j<=$len2 ; $j++ )
						$spar1 .= "*";
					$email1 = substr_replace( $temp_email[1] , $spar1 , 1 , strlen($spar1) );
					
					if( $dataUser10s['belongTo10service'] == "1" && $dataUserCr['credit_price'] > "0" && $credits >= $dataUserCr['credit_price'] )
					{
						$str_buy_by_credit = "<br>לפתיחת התוכן בשימוש ".$dataUserCr['credit_price']." קרדיטים <a href='index.php?main=payForLeadByCredit&type=contact&r_id=".$data['id']."&unk=".$_GET['unk']."&sesid=".$_GET['sesid']."' class='maintext_link' onclick='return can_view_contact_2()'>לחץ כאן</a>";
					}
					
					$add_email_text = ( $data['email'] == "" ) ? "" : "דואר אלקטרוני: <b>".$email."@".$email1."</b>";
					$add_phone_text = ( $data['phone'] == "" ) ? "" : "טלפון: <font dir=ltr><b>".$phone."</b></font>";
					$add_mobile_text = ( $data['mobile'] == "" ) ? "" : "סלולארי: <font dir=ltr><b>".$phone."</b></font>";
					
					$text_email = array("blank", $add_email_text);
					$text_phone = array("blank", $add_phone_text);
					$text_mobile = array("blank", $add_mobile_text);
					
					if( $data['email'] != "" || $data['phone'] != "" || $data['mobile'] != "" )
					{
						$moore_text_for_payment = array("blank", "<br>על מנת לצפות בתוכן השדה יש <a href='index.php?main=payForLead&type=contact&r_id=".$data['id']."&unk=".$_GET['unk']."&sesid=".$_GET['sesid']."' class='maintext_link' onclick='return can_view_contact()'>ללחוץ כאן</a>");
						if( $str_buy_by_credit != "" )
							$moore_text_for_payment2 = array("blank", $str_buy_by_credit);
					}
					
				}

				
			}
			
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
				
				$subject_id = array("select","subject_id[]",$subject_idArr,$word[LANG]['subject'],$data['subject_id'],"data_arr[subject_id]", "class='input_style'");
			}
			
			$text_content = array("textarea","data_arr[content]",$data['content'],$word[LANG]['comments_requests'], "class='input_style' style='width: 300px; height: 100px;'");
			
			
			$form_arr = array(
				$hiddenMain, $hidden_type, $hidden_id, 
				$hidden_sesid, $hidden_unk,$hidden_unk2 , $hidden_table, $text_datetime_id, 
				$select_status, $text_name, $text_email, $text_phone, $text_mobile, $moore_text_for_payment,$moore_text_for_payment2, $subject_id, $text_content,
				
				array("submit","submit",$word[LANG]['submit_form'], "class='submit_style'")
			);
			
			$sql = "UPDATE ".$table." SET opened = 1 where id = '".$_REQUEST['row_id']."' and unk = '".UNK."'";
			$res = mysql_db_query(DB,$sql);	
			$lead_made_by_phone_alert = "";
			if($data['lead_recource'] == "phone"){
				$call_sql = "SELECT * FROM sites_leads_stat WHERE id = '".$data['phone_lead_id']."'";
				$call_res = mysql_db_query(DB,$call_sql);
				$call_data = mysql_fetch_array($call_res);
				$call_sec = "";
				if($call_data['answer'] == "ANSWERED"){
					$call_sec = "(".$call_data['billsec']."שנ')";
				}
				$lead_made_by_phone_alert .= "<h4 style='color:red;'>התקבל בשיחת טלפון".$call_sec."</h4>";
			}
			if($data['status'] == '6'){
				$lead_made_by_phone_alert .= "<h4 style='color:red;'>ליד זה זוכה</h4>";
			}			
			if( $data['payByPassword'] == "1" && $dataUserCr['hide_refund'] != '1')
			{
				
				$refund_request_form = "
					<a href= 'javascript://' id='open_refun_form_button'>לשליחת בקשה לזיכוי על הליד לחץ כאן</a>
					
					<div id='refund_lead_form_mask' style='display:none;'>	";
					
					if($data['lead_billed_id'] != "0" && $data['lead_billed_id'] != "" && $data['lead_billed_id'] != "-1"){
						$refund_request_form .= "<h4>ליד כפול: ליד זה לא חויב, ולכן לא ניתן לזיכוי </h4>
						<a href= 'index.php?main=get_create_form&type=contact&row_id=".$data['lead_billed_id']."&unk=".UNK."&sesid=".SESID."' id='billed_lead_link'>לחץ כאן לצפייה בליד שחוייב</a>
						";
					}
					elseif($data['lead_billed_id'] == "-1"){
						$refund_request_form .= "<h4>ליד זה לא חוייב, ולכן לא ניתן לזיכוי.</h4>";
					}					
					elseif($data['status'] == '6'){
						$refund_request_form .= "<h4>ליד זה כבר זוכה</h4>";
					}
					else{
						$start = new DateTime($data['date_in']);
						
						$end = new DateTime();
						$hours = round(($end->format('U') - $start->format('U')) / (60*60));
						//echo $hours;
						
						if($hours < 75){
							$refund_request_form .= "	
							<br/><b style='color:red'>".$word[LANG]['72_hour_note']."</b>
							<form action='index.php' class='refund_form'>
								<div class='lead_form_item form-group'>
									<h4>בקשה לזיכוי ליד: <br/><span class='lead-refund-name lead-name-holder'></span></h4>
								</div>
								
								<label for='reason'>סיבה</label>					
								<div class='lead_form_item form-group '>
									<input type='hidden' name='unk' value='".UNK."' />
									<input type='hidden' name='sesid' value='".SESID."' />
									<input type='hidden' name='main' value='send_lead_refund_request'>
									<input type='hidden' name='row_id' value='".$_GET['row_id']."'>
									<select name='reason' class='form-select reason-select input_style'>";
										$refund_reasons = array();
										$refund_reasons[1] = $word[LANG]['invalid_phone'];
										$refund_reasons[2] = $word[LANG]['no_answer'];
										//$refund_reasons[3] = $word[LANG]['irelevant'];
										//$refund_reasons[4] = $word[LANG]['existing_customer'];
										
										foreach($refund_reasons as $key=>$val){
											$refund_request_form .= "<option value='".$key."'>".$val."</option>";
										}
									$refund_request_form .= "</select>
								</div>
<br/>								
								<label for='reason'>נא לכתוב את סיבת בקשת זיכוי הליד </label>					
								<div class='lead_form_item form-group '>
										<textarea name='comment' class='input_style textarea refund-comment' style='height:60px;'></textarea>
								</div>
								<br/>
								<div class='lead_form_btn form-group'>
									<button type='button'  id='close_refun_form_button'  class='lead_form_refund_cancel form-button'>ביטול</button>
									<button type='submit' class='lead_form_refund_send form-button'>שלח</button>
									
								
								</div>	
								
							</form>	
							
							";
							
						}
						else{
							$refund_request_form .= "<b style='color:red'>הסתיים תוקף הזיכוי על הליד.</b>";
						}
					}

						$refund_request_form .= "
					</div>				
					<script type='text/javascript'>".'
						$("#open_refun_form_button").click(function(){$("#refund_lead_form_mask").show()});
						$("#close_refun_form_button").click(function(){$("#refund_lead_form_mask").hide()});
						'."
					</script>
				";
			}
		break;


		case "e_card_forms" :
			$table = "user_e_card_forms";
			
			$sql = "select * from ".$table." where id = '".$_REQUEST['row_id']."' and unk = '".UNK."'";
			$res = mysql_db_query(DB,$sql);
			$data = mysql_fetch_array($res);
			
			$wtc_datetime = ( $_REQUEST['row_id'] ) ? "datetime_id" : "";
			$wtc_datetime_name = ( $_REQUEST['row_id'] ) ? "not_active2" : "";
			$wtc_val_datetime = ( $_REQUEST['row_id'] ) ? $data['date_in'] : "";
			
			$status[0] = $word[LANG]['Interested_service'];
			$status[1] = $word[LANG]['talked_with_him'];
			$status[5] = $word[LANG]['Waiting_phone'];
			$status[2] = $word[LANG]['Close_customer'];
			$status[3] = $word[LANG]['Registered_customers'];
			$status[4] = $word[LANG]['Not_relevant'];
			
			
			$hiddenMain = array("hidden","main","update_new_row");
			$hidden_type = array("hidden","type","e_card_forms");
			$hidden_id = array("hidden","record_id",$_REQUEST['row_id']);
			$hidden_sesid = array("hidden","sesid",SESID);
			$hidden_unk = array("hidden","data_arr[unk]",UNK);
			$hidden_unk2 = array("hidden","unk",UNK);
			$hidden_table = array("hidden","table",$table);
			
			$text_datetime_id = array($wtc_datetime,$wtc_datetime_name,$wtc_val_datetime,$word[LANG]['sending_date'], "class='input_style' readonly","","hidden");
			if($data['status'] != '6'){
				$select_status = array("select","status[]",$status,$word[LANG]['status'],$data['status'],"data_arr[status]", "class='input_style'");
			}
			else{
				$select_status = array("hidden","data_arr[status]",$data['status'],$word[LANG]['status']."(ליד זה קיבל זיכוי)", "class='input_style'");
			}
			$text_name = array("text","data_arr[name]",$data['name'],$word[LANG]['full_name'], "class='input_style'");
			$text_subject = array("text","data_arr[subject]",$data['subject'],$word[LANG]['subject'], "class='input_style'");			
			if( $data['payByPassword'] == "1" )
			{
				$text_email = array("text","data_arr[email]",$data['email'],$word[LANG]['e_mail'], "class='input_style'");
				$text_phone = array("text","data_arr[phone]",$data['phone'],$word[LANG]['phone'], "class='input_style'","","1");
				
			}
			else
			{
				$phone = substr_replace( $data['phone'] , "****" , 4 , 4 );
				
				$temp_email = explode( "@" , stripslashes($data['email']) );
				$len = strlen($temp_email[0]);
				$spar = "";
				for( $i=0 ; $i<=$len-2 ; $i++ )
					$spar .= "*";
				$email = substr_replace( $temp_email[0] , $spar , 1 , strlen($spar) );
				
				$len2 = strlen($temp_email[1]);
				$spar1 = "";
				for( $j=0 ; $j<=$len2 ; $j++ )
					$spar1 .= "*";
				$email1 = substr_replace( $temp_email[1] , $spar1 , 1 , strlen($spar1) );
				
				
				$add_email_text = ( $data['email'] == "" ) ? "" : "דואר אלקטרוני: <b>".$email."@".$email1."</b>";
				$add_phone_text = ( $data['phone'] == "" ) ? "" : "טלפון: <font dir=ltr><b>".$phone."</b></font>";
									
				$text_email = array("blank", $add_email_text);
				$text_phone = array("blank", $add_phone_text);
				
				if( $data['email'] != "" || $data['phone'] != "" || $data['mobile'] != "" )
				{
					$moore_text_for_payment = array("blank", "<br>על מנת לצפות בתוכן השדה יש <a href='index.php?main=payForLead&type=e_card_forms&r_id=".$data['id']."&unk=".$_GET['unk']."&sesid=".$_GET['sesid']."' class='maintext_link' onclick='return can_view_contact()'>ללחוץ כאן</a>");
					if( $str_buy_by_credit != "" )
						$moore_text_for_payment2 = array("blank", $str_buy_by_credit);
				}
				
			}

				
			

			
			$text_content = array("textarea","data_arr[content]",$data['content'],$word[LANG]['comments_requests'], "class='input_style' style='width: 300px; height: 100px;'");
			
			
			$form_arr = array(
				$hiddenMain, $hidden_type, $hidden_id, 
				$hidden_sesid, $hidden_unk,$hidden_unk2 , $hidden_table, $text_datetime_id, 
				$select_status, $text_name, $text_email, $text_phone,$text_subject, $moore_text_for_payment,$moore_text_for_payment2, $subject_id, $text_content,
				
				array("submit","submit",$word[LANG]['submit_form'], "class='submit_style'")
			);
			
			$sql = "UPDATE ".$table." SET opened = 1 where id = '".$_REQUEST['row_id']."' and unk = '".UNK."'";
			$res = mysql_db_query(DB,$sql);	
			$lead_made_by_phone_alert = "";
			if($data['lead_recource'] == "phone"){
				$call_sql = "SELECT * FROM sites_leads_stat WHERE id = '".$data['phone_lead_id']."'";
				$call_res = mysql_db_query(DB,$call_sql);
				$call_data = mysql_fetch_array($call_res);
				$call_sec = "";
				if($call_data['answer'] == "ANSWERED"){
					$call_sec = "(".$call_data['billsec']."שנ')";
				}
				$lead_made_by_phone_alert .= "<h4 style='color:red;'>התקבל בשיחת טלפון".$call_sec."</h4>";
			}
		

				
					
	
			
		break;		
		
		case "contact_subjects" :
			$table = "user_contact_subjects";
			
			$sql = "select * from ".$table." where deleted = '0' and id = '".$_REQUEST['row_id']."' and unk = '".UNK."'";
			$res = mysql_db_query(DB,$sql);
			$data = mysql_fetch_array($res);
			
			$form_arr = array(
				array("hidden","main","update_new_row"),
				array("hidden","type","contact_subjects"),
				array("hidden","record_id",$_REQUEST['row_id']),
				array("hidden","sesid",SESID),
				array("hidden","data_arr[unk]",UNK),
				array("hidden","unk",UNK),
				array("hidden","table",$table),
				
				array("text","data_arr[subject]",$data['subject'],$word[LANG]['subject'], "class='input_style'","","1"),
				
				array("submit","submit",$word[LANG]['submit_form'], "class='submit_style'")
			);
		break;
		
		
		case "gb" :
			$table = "user_gb_response";
			
			$sql = "select * from ".$table." where deleted = '0' and id = '".$_REQUEST['row_id']."' and unk = '".UNK."'";
			$res = mysql_db_query(DB,$sql);
			$data = mysql_fetch_array($res);
			
			$wtc_datetime = ( $_REQUEST['row_id'] ) ? "datetime_id" : "";
			$wtc_datetime_name = ( $_REQUEST['row_id'] ) ? "not_active2" : "";
			$wtc_val_datetime = ( $_REQUEST['row_id'] ) ? $data['date_in'] : "";
			
			$status[0] = $word[LANG]['new_response'];
			$status[1] = $word[LANG]['approved_response'];
			$status[2] = $word[LANG]['irrelevant_response'];
			
			
			$form_arr = array(
				array("hidden","main","update_new_row"),
				array("hidden","type","gb"),
				array("hidden","record_id",$_REQUEST['row_id']),
				array("hidden","sesid",SESID),
				array("hidden","data_arr[unk]",UNK),
				array("hidden","unk",UNK),
				array("hidden","table",$table),
				
				array($wtc_datetime,$wtc_datetime_name,$wtc_val_datetime,$word[LANG]['sending_date'], "class='input_style' readonly","","hidden"),
				
				array("select","status[]",$status,$word[LANG]['status'],$data['status'],"data_arr[status]", "class='input_style''"),
				
				array("text","data_arr[name]",$data['name'],$word[LANG]['full_name'], "class='input_style'","","1"),
				array("text","data_arr[email]",$data['email'],$word[LANG]['e_mail'], "class='input_style'","","1"),
				array("text","data_arr[headline]",$data['headline'],$word[LANG]['title'], "class='input_style'","","1"),
				array("textarea","data_arr[content]",$data['content'],$word[LANG]['content'], "class='input_style' style='width: 300px; height: 100px;'"),
				
				array("submit","submit",$word[LANG]['submit_form'], "class='submit_style'")
			);
		break;
		
		case "news" :
			$table = "user_news";
			
			$sql = "select * from ".$table." where deleted = '0' and id = '".$_REQUEST['row_id']."' and unk = '".UNK."'";
			$res = mysql_db_query(DB,$sql);
			$data = mysql_fetch_array($res);
			
			$url_img_inpterpool = ( UNK == "932085872939085012" ) ? "text" : "hidden";
			
			$form_arr = array(
				array("hidden","main","update_new_row"),
				array("hidden","type","news"),
				array("hidden","record_id",$_REQUEST['row_id']),
				array("hidden","sesid",SESID),
				array("hidden","data_arr[unk]",UNK),
				array("hidden","unk",UNK),
				array("hidden","table",$table),
				
				
				array("text","data_arr[headline]",$data['headline'],$word[LANG]['title'], "class='input_style'","","1"),
				array("text","data_arr[link]",$data['link'],$word[LANG]['link'], "class='input_style'","","1"),
				array("textarea","data_arr[content]",$data['content'],$word[LANG]['content'], "class='input_style' style='width: 300px; height: 100px;'"),
				array($url_img_inpterpool,"data_arr[url_img]",$data['url_img'],"כתובת URL תמונה", "class='input_style'"),
				
				array("submit","submit",$word[LANG]['submit_form'], "class='submit_style'")
			);
		break;
		
		case "update_pages" :
			$table = "update_pages";
			
			$sql = "select * from ".$table." where deleted = '0' and id = '".$_REQUEST['row_id']."' and unk = '".UNK."'";
			$res = mysql_db_query(DB,$sql);
			$data = mysql_fetch_array($res);
			
			$text_editor = "<div id=\"eweContainer\" unselectable=\"on\"></div>";
			
			
			$form_arr = array(
				array("hidden","main","update_new_row"),
				array("hidden","type","news"),
				array("hidden","record_id",$_REQUEST['row_id']),
				array("hidden","sesid",SESID),
				array("hidden","data_arr[unk]",UNK),
				array("hidden","unk",UNK),
				array("hidden","table",$table),
				
				array("blank",$text_editor),
				
				array("submit","submit",$word[LANG]['submit_form'], "class='submit_style'")
			);
		break;
		
		case "myClients" :
			$table = "user_clients";
			
			$sql = "select * from ".$table." where deleted = '0' and id = '".$_REQUEST['row_id']."' and unk = '".UNK."'";
			$res = mysql_db_query(DB,$sql);
			$data = mysql_fetch_array($res);
			
			$form_arr = array(
				array("hidden","main","update_new_row"),
				array("hidden","type",$_REQUEST['type']),
				array("hidden","record_id",$_REQUEST['row_id']),
				array("hidden","sesid",SESID),
				array("hidden","data_arr[unk]",UNK),
				array("hidden","unk",UNK),
				array("hidden","table",$table),
				
				array("text","data_arr[full_name]",$data['full_name'],$word[LANG]['full_name'], "class='input_style'","","1"),
				array("text","data_arr[email]",$data['email'],$word[LANG]['email'], "class='input_style'","","1"),
				array("text","data_arr[password]",$data['password'],"סיסמה", "class='input_style'"),
				array("text","data_arr[phone]",$data['phone'],$word[LANG]['phone'], "class='input_style'"),
				array("text","data_arr[mobile]",$data['mobile'],"נייד", "class='input_style'"),
				array("text","data_arr[city]",$data['city'],$word[LANG]['city'], "class='input_style'"),
				array("text","data_arr[address]",$data['address'],"רחוב", "class='input_style'"),
				
				array("textarea","data_arr[system_note]",$data['system_note'],"הערות מערכת", "class='input_style' style='width: 300px; height: 100px;'"),
				
				array("submit","submit",$word[LANG]['submit_form'], "class='submit_style'")
			);
		break;
		
		case "text_libs" :
			$table = "user_text_libs";
			
			$sql = "select * from ".$table." where deleted = '0' and id = '".$_REQUEST['row_id']."' and unk = '".UNK."'";
			$res = mysql_db_query(DB,$sql);
			$data = mysql_fetch_array($res);
			
			$defualt_show_libs_options[0] = $word[LANG]['presentation_folder_list_select_1'];
			$defualt_show_libs_options[1] = $word[LANG]['presentation_folder_list_select_2'];
			
			$active[1] = $word[LANG]['yes'];
			$active[0] = $word[LANG]['no'];
			
			$form_arr = array(
				array("hidden","main","update_new_row"),
				array("hidden","type",$_REQUEST['type']),
				array("hidden","record_id",$_REQUEST['row_id']),
				array("hidden","sesid",SESID),
				array("hidden","data_arr[unk]",UNK),
				array("hidden","unk",UNK),
				array("hidden","table",$table),
				
				array("text","data_arr[lib_name]",$data['lib_name'],$word[LANG]['name_folder'], "class='input_style'","","1"),
				array("select","defualt_show_libs_options[]",$defualt_show_libs_options,$word[LANG]['presentation_folder_list'],$data['defualt_show_libs_options'],"data_arr[defualt_show_libs_options]", "class='input_style'"),
				array("select","active[]",$active,$word[LANG]['active'],$data['active'],"data_arr[active]", "class='input_style'"),
				
				
				array("submit","submit",$word[LANG]['submit_form'], "class='submit_style'")
			);
		break;
		
		case "design_page" :
		
			$sql = "select * from user_design_page where deleted = '0' and id = '".$_REQUEST['row_id']."' and unk = '".UNK."' ".AUTH_QUERY_STR."";
			$res = mysql_db_query(DB,$sql);
			$data = mysql_fetch_array($res);
			
			$sql2 = "select * from user_design_page_cat where deleted = '0' and unk = '".UNK."' and active = '0'";
			$res2 = mysql_db_query(DB,$sql2);
			
			$count_pro = 0;
				while( $data2 = mysql_fetch_array($res2) )
				{
					$temp_id = $data2['id'];
					$cat[$temp_id] .= $data2['cat_name'];
					$count_pro++;
				}
				
			if( $_REQUEST['row_id'] )
				$smart_link = "<a href='editor.php?type=design_page&unk=".UNK."&row_id=".$_REQUEST['row_id']."&sesid=".SESID."' class='maintext' target='_blank'>".$word[LANG]['click_update_content']."</a>";
			
			$form_arr = array(
				array("hidden","main","update_new_row"),
				array("hidden","type","design_page"),
				array("hidden","record_id",$_REQUEST['row_id']),
				array("hidden","sesid",SESID),
				array("hidden","data_arr[unk]",UNK),
				array("hidden","unk",UNK),
				array("hidden","table","user_design_page"),
				
				array("text","data_arr[title]",$data['title'],$word[LANG]['page_name'], "class='input_style'","","1"),
				array("select","cat[]",$cat,$word[LANG]['assing_cats'],$data['cat'],"data_arr[cat]", "class='input_style''" , $word[LANG]['least_one_category']),
				
				array( "blank",$smart_link ),
				
				array("submit","submit",$word[LANG]['submit_form'], "class='submit_style'")
			);
		break;
		
		case "design_page_cat" :
		
			$sql = "select * from user_design_page_cat where deleted = '0' and id = '".$_REQUEST['row_id']."' and unk = '".UNK."' ".AUTH_QUERY_STR."";
			$res = mysql_db_query(DB,$sql);
			$data = mysql_fetch_array($res);
			
			$sql2 = "select * from content_pages where deleted = '0' and unk = '".UNK."' and hba_active_cats = '1'";
			$res2 = mysql_db_query(DB,$sql2);
			
			$count_pro = 0;
				while( $data2 = mysql_fetch_array($res2) )
				{
					$temp_id = $data2['id'];
					$page_id[$temp_id] .= $data2['name'];
					$count_pro++;
				}
				
			if( $_REQUEST['row_id'] )
				$smart_link = "<a href='editor.php?type=design_page&unk=".UNK."&row_id=".$_REQUEST['row_id']."&sesid=".SESID."' class='maintext' target='_blank'>".$word[LANG]['click_update_content']."</a>";
			
			$active[0] = $word[LANG]['yes'];
			$active[1] = $word[LANG]['no'];
			
			$form_arr = array(
				array("hidden","main","update_new_row"),
				array("hidden","type","design_page_cat"),
				array("hidden","record_id",$_REQUEST['row_id']),
				array("hidden","sesid",SESID),
				array("hidden","data_arr[unk]",UNK),
				array("hidden","unk",UNK),
				array("hidden","table","user_design_page_cat"),
				
				array("text","data_arr[cat_name]",$data['cat_name'],$word[LANG]['page_name'], "class='input_style'","","1"),
				array("select","page_id[]",$page_id,"שיוך לדף",$data['page_id'],"data_arr[page_id]", "class='input_style''" , $word[LANG]['least_one_category']),
				array("new_file","img1",$data['img1'],$word[LANG]['picture'], "new_images", "&table=".$table."&GOTO_type=design_page_cat&GOTO_main=List_View_Rows"),
				array("select","active[]",$active,$word[LANG]['Displayed_site'],$data['active'],"data_arr[active]", "class='input_style''"),
				
				array("submit","submit",$word[LANG]['submit_form'], "class='submit_style'")
			);
		break;
		
		
		
		
		
		
		
		
		
		
		
		
		case "guide" :
			$sql = "select * from user_guide where id = '".$_REQUEST['row_id']."' and unk = '".UNK."'";
			$res = mysql_db_query(DB,$sql);
			$data = mysql_fetch_array($res);
			
			
			$form_arr = array(
				array("hidden","main","update_new_row"),
				array("hidden","type","guide"),
				array("hidden","record_id",$_REQUEST['row_id']),
				array("hidden","sesid",SESID),
				array("hidden","data_arr[unk]",UNK),
				array("hidden","unk",UNK),
				array("hidden","table","user_guide"),
				
				array("text","data_arr[guide_name]",$data['guide_name'],"שם המדריך", "class='input_style'"),
				
				array("new_file","guide_img",$data['guide_img'],"תמונה 1", "new_images", "&table=".$table."&GOTO_type=guide&GOTO_main=List_View_Rows"),
				array("new_file","guide_img2",$data['guide_img2'],"תמונה 2", "new_images", "&table=".$table."&GOTO_type=guide&GOTO_main=List_View_Rows"),
				
				array("text","data_arr[guide_im2_link]",$data['guide_im2_link'],"קישור למידע נוסף לתמונה השניה", "class='input_style'"),
				
				array("textarea","data_arr[description]",$data['description'],"תיאור", "class='input_style' style='width: 300px; height: 300px;'"),
				array("text","data_arr[url_page]",$data['url_page'],"קישור למדריך (דף חופשי)", "class='input_style'"),
				
				array("submit","submit",$word[LANG]['submit_form'], "class='submit_style'")
			);
		break;
		
		case "guide_business" :
			$sql = "select * from user_guide_business where id = '".$_REQUEST['row_id']."' and unk = '".UNK."'";
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
			
			for( $i=0 ; $i<=99 ; $i++ )
			{
				$priority[$i] = $i;
			}
			
			$premium[0] = "לא";
			$premium[1] = "כן";
			
			$active[0] = "פעיל";
			$active[1] = "לא פעיל";
			
			if( $data['id'] != "" )
			{
				$cats = array("blank" , "<a href='guide_cats.php?unk=".UNK."&sesid=".SESID."&biz_id=".$data['id']."' class='maintext' target='_blank'>קטגוריות</a>");
			}
			
			
			$form_arr = array(
				array("hidden","main","update_new_row"),
				array("hidden","type","guide_business"),
				array("hidden","record_id",$_REQUEST['row_id']),
				array("hidden","sesid",SESID),
				array("hidden","data_arr[unk]",UNK),
				array("hidden","unk",UNK),
				array("hidden","table","user_guide_business"),
				
				
				array("multi_select","guide_id[]",$guide_id,"שם המדריך",$selected_guideId,"guide_id[]", "class='input_style' style='height: 50px;'"),
				$cats,
				array("select","priority[]",$priority,"עדיפות",$data['priority'],"data_arr[priority]", "class='input_style'"),
				array("select","premium[]",$premium,"פרימיום",$data['premium'],"data_arr[premium]", "class='input_style'"),
				
				array("text","data_arr[business_name]",$data['business_name'],"שם העסק", "class='input_style'"),
				
				array("multi_select","city[]",$city,"עיר",$selected_cityId,"cities[]", "class='input_style' style='height: 50px;'"),
				array("text","data_arr[phone]",$data['phone'],"טלפון", "class='input_style'"),
				array("text","data_arr[email]",$data['email'],"אימייל", "class='input_style'"),
				array("text","data_arr[website]",$data['website'],"אתר אינטרנט", "class='input_style'"),
				array("select","active[]",$active,"פעיל",$data['active'],"data_arr[active]", "class='input_style'"),
				
				array("new_file","img1",$data['img1'],"תמונת נגב פון", "new_images/".$data['id'], "&table=".$table."&GOTO_type=guide_business&GOTO_main=List_View_Rows"),
				array("new_file","img2",$data['img2'],"תמונת כרטיס ביקור", "new_images/".$data['id'], "&table=".$table."&GOTO_type=guide_business&GOTO_main=List_View_Rows"),
				
				array("new_file","logo",$data['logo'],"לוגו", "new_images/".$data['id'], "&table=".$table."&GOTO_type=guide_business&GOTO_main=List_View_Rows"),
				
				array("new_file","img3",$data['img3'],"תמונה נוספת", "new_images/".$data['id'], "&table=".$table."&GOTO_type=guide_business&GOTO_main=List_View_Rows"),
				
				array("textarea","data_arr[summery]",$data['summery'],"שירותי העסק", "class='input_style' style='width: 300px; height: 100px;'"),
				array("textarea","data_arr[description]",$data['description'],"פרופיל", "class='input_style' style='width: 300px; height: 300px;'"),
				array("text","data_arr[video_code]",$data['video_code'],"וידיאו", "class='input_style'"),
				
				
				array("submit","submit",$word[LANG]['submit_form'], "class='submit_style'")
			);
		break;
		
		
		
		case "guide_cats" :
			$sql = "select * from user_guide_cats where id = '".$_REQUEST['row_id']."' and unk = '".UNK."'";
			$res = mysql_db_query(DB,$sql);
			$data = mysql_fetch_array($res);
			
			$sql = "SELECT id, cat_name FROM user_guide_cats WHERE deleted=0 AND active=0 AND father=0 AND unk = '".UNK."' ORDER BY cat_name";
			$res_cat = mysql_db_query(DB,$sql);
			
			$father[] = "ראשית";
			while( $data_cat = mysql_fetch_array($res_cat) )
			{
				$father_id = $data_cat['id'];
				$father[$father_id] = stripslashes($data_cat['cat_name']);
			}
			
			$form_arr = array(
				array("hidden","main","update_new_row"),
				array("hidden","type","guide_cats"),
				array("hidden","record_id",$_REQUEST['row_id']),
				array("hidden","sesid",SESID),
				array("hidden","data_arr[unk]",UNK),
				array("hidden","unk",UNK),
				array("hidden","table","user_guide_cats"),
				
				array("text","data_arr[cat_name]",$data['cat_name'],"שם הקטגוריה", "class='input_style'"),
				
				array("select","father[]",$father,"קטגוריה ראשית",$data['father'],"data_arr[father]", "class='input_style'"),
				
				array("submit","submit",$word[LANG]['submit_form'], "class='submit_style'")
			);
		break;
		
		
		case "guide_cities" :
			$sql = "select * from user_guide_cities where id = '".$_REQUEST['row_id']."' and unk = '".UNK."'";
			$res = mysql_db_query(DB,$sql);
			$data = mysql_fetch_array($res);
			
			
			$form_arr = array(
				array("hidden","main","update_new_row"),
				array("hidden","type","guide_cities"),
				array("hidden","record_id",$_REQUEST['row_id']),
				array("hidden","sesid",SESID),
				array("hidden","data_arr[unk]",UNK),
				array("hidden","unk",UNK),
				array("hidden","table","user_guide_cities"),
				
				array("text","data_arr[city_name]",$data['city_name'],"שם העיר", "class='input_style'"),
				
				array("submit","submit",$word[LANG]['submit_form'], "class='submit_style'")
			);
		break;
		
		
		case "banners_guide" :
			$sql = "select * from user_banners_guide where id = '".$_REQUEST['row_id']."' and unk = '".UNK."'";
			$res = mysql_db_query(DB,$sql);
			$data = mysql_fetch_array($res);
			
			
			$sql = "SELECT guide_name, id FROM user_guide WHERE unk='".UNK."' ORDER BY guide_name";
			$res_guideId = mysql_db_query(DB,$sql);
			
			$selected_guideId = "";
			while( $data_guideId = mysql_fetch_array($res_guideId) )
			{
				$guideId = $data_guideId['id'];
				$guide_id[$guideId] = stripslashes($data_guideId['guide_name']);
			}
			
			if( $data['id'] != "" )
			{
				$cats = array("blank" , "<a href='negev_banner_cats.php?unk=".UNK."&sesid=".SESID."&banner_id=".$data['id']."' class='maintext' target='_blank'>קטגוריות</a>");
			}
			
			$active[0] = "פעיל";
			$active[1] = "לא פעיל";
			
			$location['up'] = "למעלה";
			$location['bottom'] = "למטה";
			$location['inner'] = "פנימי";
			
			$form_arr = array(
				array("hidden","main","update_new_row"),
				array("hidden","type","banners_guide"),
				array("hidden","record_id",$_REQUEST['row_id']),
				array("hidden","sesid",SESID),
				array("hidden","data_arr[unk]",UNK),
				array("hidden","unk",UNK),
				array("hidden","table","user_banners_guide"),
				
				array("text","data_arr[banner_name]",$data['banner_name'],"שם הבאנר", "class='input_style'"),
				$cats,
				array("textarea","data_arr[description]",$data['description'],"תיאור הבאנר", "class='input_style' style='width: 300px; height: 100px;'"),
				
				array("new_file","img1",$data['img1'],"קובץ", "new_images/banners", "&table=".$table."&GOTO_type=banners_guide&GOTO_main=List_View_Rows"),
				
				array("text","data_arr[web_url]",$data['web_url'],"קישור של הבאנר", "class='input_style'"),
				array("select","active[]",$active,"פעיל",$data['active'],"data_arr[active]", "class='input_style'"),
				
				array("text","data_arr[views]",$data['views'],"צפיות", "class='input_style' readonly"),
				
				array("select","location[]",$location,"מיקום",$data['location'],"data_arr[location]", "class='input_style'"),
				array("select","location_id[]",$guide_id,"בחר מדריך במקרה והמיקום פנימי",$data['location_id'],"data_arr[location_id]", "class='input_style'"),
				
				array("blank" , "
				<b>גדלים של באנרים :</b><br>
				גודל באנר עליון: גובה: 90 פקסיל, רוחב: דינמי<br>
				גודל באנר תחתון: דינמי<br>
				גודל באנרים פנימיים: גובה: 240 פקסיל, רוחב: 165 פקסיל<br>
				* המערכת מזהה אוטומטית את גדלי הבאנר
				"),
				
				array("submit","submit",$word[LANG]['submit_form'], "class='submit_style'")
			);
		break;
		
		case "fmnUsers" :
			$sql = "select * from custom_netanya_users where id = '".$_REQUEST['row_id']."' AND unk = '".UNK."'";
			$res = mysql_db_query(DB,$sql);
			$data = mysql_fetch_array($res);
			
			
			$ngo_type[1] = "חבר עמותה";
			$ngo_type[2] = "חבר עמותה צעיר";
			
			$check1[0] = "לא";
			$check1[1] = "כן";
			
			$check2[0] = "לא";
			$check2[1] = "כן";
			
			$check3[0] = "לא";
			$check3[1] = "כן";
			
			$check4[0] = "לא";
			$check4[1] = "כן";
			
			
			$form_arr = array(
				array("hidden","main","update_new_row"),
				array("hidden","type","fmnUsers"),
				array("hidden","record_id",$_REQUEST['row_id']),
				array("hidden","sesid",SESID),
				array("hidden","data_arr[unk]",UNK),
				array("hidden","unk",UNK),
				array("hidden","table","custom_netanya_users"),
				
				array("text","data_arr[fname]",$data['fname'],"שם פרטי", "class='input_style'"),
				array("text","data_arr[lname]",$data['lname'],"שם משפחה", "class='input_style'"),
				array("text","data_arr[tz]",$data['tz'],"תעודת זהות", "class='input_style'"),
				
				array("date","birthday",$data['birthday'],"תאריך לידה", "class='input_style'"),
				array("text","data_arr[email]",$data['email'],"אימייל", "class='input_style'"),
				array("text","data_arr[mobile]",$data['mobile'],"סלולרי", "class='input_style'"),
				array("text","data_arr[address]",$data['address'],"כתובת", "class='input_style'"),
				array("text","data_arr[city]",$data['city'],"עיר", "class='input_style'"),
				array("text","data_arr[zip]",$data['zip'],"מיקוד", "class='input_style'"),
				array("text","data_arr[ngo_price]",$data['ngo_price'],"תרומה חד פעמית על סך", "class='input_style'"),
				array("select","ngo_type[]",$ngo_type,"סוג חברות לעמותה",$data['ngo_type'],"data_arr[ngo_type]", "class='input_style'"),
				
				
				array("select","check1[]",$check1,"אישור קבלת מידע שוטף באימייל בנושאי העמותה",$data['check1'],"data_arr[check1]", "class='input_style'"),
				array("select","check2[]",$check2,"בעל מנוי?",$data['check2'],"data_arr[check2]", "class='input_style'"),
				array("select","check3[]",$check3,"תרכוש מנוי גם בעונה הבאה",$data['check3'],"data_arr[check3]", "class='input_style'"),
				array("select","check4[]",$check4,"מעוניין לקחת חלק פעיל בעמותה",$data['check4'],"data_arr[check4]", "class='input_style'"),
				
				
				array("submit","submit",$word[LANG]['submit_form'], "class='submit_style'")
			);
		break;
		
		case "usresTZ" :
			$sql = "select * from users_tz_list where id = '".$_REQUEST['row_id']."' AND unk = '".UNK."'";
			$res = mysql_db_query(DB,$sql);
			$data = mysql_fetch_array($res);
			
			
			$form_arr = array(
				array("hidden","main","update_new_row"),
				array("hidden","type","usresTZ"),
				array("hidden","record_id",$_REQUEST['row_id']),
				array("hidden","sesid",SESID),
				array("hidden","data_arr[unk]",UNK),
				array("hidden","unk",UNK),
				array("hidden","table","users_tz_list"),
				
				array("text","data_arr[first_name]",$data['first_name'],"שם פרטי", "class='input_style'"),
				array("text","data_arr[last_name]",$data['last_name'],"שם משפחה", "class='input_style'"),
				array("text","data_arr[tz]",$data['tz'],"תעודת זהות", "class='input_style'"),
				
				array("submit","submit",$word[LANG]['submit_form'], "class='submit_style'")
			);
		break;
		
		
		
		
		case "einYahav" :
			$sql = "select * from einYahav_adv where id = '".$_REQUEST['row_id']."' and unk = '".UNK."' ";
			$res = mysql_db_query(DB,$sql);
			$data = mysql_fetch_array($res);
			
			$sql = "SELECT pro_name, id FROM einYahav_products WHERE unk='".UNK."' ORDER BY pro_name";
			$res_pro_id = mysql_db_query(DB,$sql);
			
			while( $data_pro_id = mysql_fetch_array($res_pro_id) )
			{
				$pro___id = $data_pro_id['id'];
				$pro_id[$pro___id] = stripslashes($data_pro_id['pro_name']);
			}
			
			
			$sql = "SELECT size_name, id FROM einYahav_size WHERE unk='".UNK."' and deleted = 0 ORDER BY size_name";
			$res_size_id = mysql_db_query(DB,$sql);
			
			while( $data_size_id = mysql_fetch_array($res_size_id) )
			{
				$size___id = $data_size_id['id'];
				$size_id[$size___id] = stripslashes($data_size_id['size_name']);
			}
			
			echo '
			<script type="text/javascript">
					$(document).ready(function() {
						$("#date1").datepicker({dateFormat: \'dd-mm-yy\' });;
					});
			</script>
			';
			
			$newDateTemp = explode("-", $data['date1'] );
			$data1 = $newDateTemp[2]."-".$newDateTemp[1]."-".$newDateTemp[0];
			$sub_type = ( $_REQUEST['sub_type'] == "" || $_REQUEST['sub_type'] == "0" ) ? "0" : "1";
			
			$form_arr = array(
				array("hidden","main","update_new_row"),
				array("hidden","type","einYahav"),
				array("hidden","record_id",$_REQUEST['row_id']),
				array("hidden","sesid",SESID),
				array("hidden","data_arr[unk]",UNK),
				array("hidden","data_arr[type]",$sub_type),
				array("hidden","unk",UNK),
				array("hidden","table","einYahav_adv"),
				
				array("select","pro_id[]",$pro_id,"שם המוצר",$data['pro_id'],"data_arr[pro_id]", "class='input_style'"),
				array("select","size_id[]",$size_id,"גודל",$data['size_id'],"data_arr[size_id]", "class='input_style'"),
				array("text","date1",$data1,"תאריך", "class='input_style'"),
				array("text","data_arr[price]",$data['price'],"מחיר", "class='input_style'"),
				
				array("submit","submit",$word[LANG]['submit_form'], "class='submit_style'")
			);
		break;
		
		case "einYahav_products" :
			$sql = "select * from einYahav_products where id = '".$_REQUEST['row_id']."' and unk = '".UNK."' ";
			$res = mysql_db_query(DB,$sql);
			$data = mysql_fetch_array($res);
			
			
			$form_arr = array(
				array("hidden","main","update_new_row"),
				array("hidden","type","einYahav_products"),
				array("hidden","record_id",$_REQUEST['row_id']),
				array("hidden","sesid",SESID),
				array("hidden","data_arr[unk]",UNK),
				array("hidden","unk",UNK),
				array("hidden","table","einYahav_products"),
				
				array("text","data_arr[pro_name]",$data['pro_name'],"שם המוצר", "class='input_style'"),
				array("text","data_arr[place]",$data['place'],"מיקום", "class='input_style'"),
				
				array("submit","submit",$word[LANG]['submit_form'], "class='submit_style'")
			);
		break;
		
		case "einYahav_sizes" :
			$sql = "select * from einYahav_size where id = '".$_REQUEST['row_id']."' and deleted = 0 AND unk = '".UNK."' ";
			$res = mysql_db_query(DB,$sql);
			$data = mysql_fetch_array($res);
			
			
			$form_arr = array(
				array("hidden","main","update_new_row"),
				array("hidden","type","einYahav_sizes"),
				array("hidden","record_id",$_REQUEST['row_id']),
				array("hidden","sesid",SESID),
				array("hidden","data_arr[unk]",UNK),
				array("hidden","unk",UNK),
				array("hidden","table","einYahav_size"),
				
				array("text","data_arr[size_name]",$data['size_name'],"גודל", "class='input_style'"),
				array("text","data_arr[place]",$data['place'],"מיקום", "class='input_style'"),
				
				array("submit","submit",$word[LANG]['submit_form'], "class='submit_style'")
			);
		break;
		
		case "group_buy" :
			$sql = "select * from 10_service_group_buy where id = '".$_REQUEST['row_id']."' ";
			$res = mysql_db_query(DB,$sql);
			$data = mysql_fetch_array($res);
			
			if( $data['lock_edit'] == "1" && UNK != "285240640927706447" )
			{
				$form_arr = array(array("submit","submit",$word[LANG]['submit_form'], "class='submit_style' style='display: none;'"));
				
				echo "<table border=0 cellpadding=0 cellspacing=0 class='maintext'>";
					echo "<tr>";
						echo "<td>שם המוצר</td>";
						echo "<td width=10></td>";
						echo "<td>".stripslashes($data['product_name'])."</td>";
					echo "</tr>";
					echo "<tr><td colspan=3 height=5></td></tr>";
					echo "<tr>";
						echo "<td valign=top>תיאור המוצר</td>";
						echo "<td width=10></td>";
						echo "<td>".nl2br(stripslashes($data['product_desc']))."</td>";
					echo "</tr>";
					echo "<tr><td colspan=3 height=5></td></tr>";
					echo "<tr>";
						echo "<td>מחיר</td>";
						echo "<td width=10></td>";
						echo "<td>".stripslashes($data['price'])."</td>";
					echo "</tr>";
					echo "<tr><td colspan=3 height=5></td></tr>";
					echo "<tr>";
						echo "<td>אחוזי הנחה</td>";
						echo "<td width=10></td>";
						echo "<td>".stripslashes($data['discount'])."</td>";
					echo "</tr>";
					echo "<tr><td colspan=3 height=5></td></tr>";
					echo "<tr>";
						echo "<td>תאריך ושעה סיום</td>";
						echo "<td width=10></td>";
						echo "<td>".stripslashes($data['product_name'])."</td>";
					echo "</tr>";
					echo "<tr><td colspan=3 height=5></td></tr>";
					echo "<tr>";
						echo "<td>כמות אנשים מנימלית</td>";
						echo "<td width=10></td>";
						echo "<td>".stripslashes($data['min_people'])."</td>";
					echo "</tr>";
					echo "<tr><td colspan=3 height=5></td></tr>";
					echo "<tr>";
						echo "<td valign=top>תמונה</td>";
						echo "<td width=10></td>";
						echo "<td>";
							$path = "/home/ilan123/domains/10service.co.il/public_html/images/group_buy/";
							if( is_file( $path.$data['img'] ) )
								echo "<img src='http://www.10service.co.il/image.php?width=100&amp;height=100&amp;image=/images/group_buy/".$data['img']."' alt='' />";
							else
								echo "לא נמצאה תמונה";
						echo "</td>";
					echo "</tr>";
					echo "<tr><td colspan=3 height=5></td></tr>";
				echo "</table>";
			}
			else
			{
				$lock_edit[0] = "לא";
				$lock_edit[1] = "כן";
				
				$sql = "select u.id, u.name FROM 
				users as u,
				user_cat as uc,
				biz_categories as bc ,
				user_extra_settings as us
					WHERE 
						us.unk=u.unk AND
						u.deleted=0 AND
						u.status=0 AND
					  u.end_date > NOW() AND
						us.belongTo10service=1 AND
						u.id=uc.user_id AND
						uc.cat_id=bc.id AND
						bc.status=1
				 GROUP BY u.id";
				$res_choosenClient = mysql_db_query(DB, $sql);
				
				$user_id = array();
				while( $val_choosenClient = mysql_fetch_array($res_choosenClient) )
				{
					$clientId = $val_choosenClient['id'];
					$user_id_arr[$clientId] = stripslashes($val_choosenClient['name']);
				}
				
				if( UNK == "285240640927706447" )
				{
					$user_id = array("select","user_id[]",$user_id_arr,"שייך ללקוח",$data['user_id'],"data_arr[user_id]", "class='input_style'");
					$lock_edit_a = array("select","lock_edit[]",$lock_edit,"נעילה לעריכת הלקוח",$data['lock_edit'],"data_arr[lock_edit]", "class='input_style'");
					$up_img = array("new_file","img",$data['img'],"תמונה", "images/group_buy", "&table=10_service_group_buy&GOTO_type=group_buy&GOTO_main=List_View_Rows");
				}
				else
				{
					$up_img = array("new_file_group_buy","img",$data['img'],"תמונה", "images/group_buy", "&table=10_service_group_buy&GOTO_type=group_buy&GOTO_main=List_View_Rows");
				}
				
				echo '
					<script type="text/javascript">
							$(document).ready(function() {
								$("#date_time").datetimepicker({dateFormat: \'dd-mm-yy\' });
							});
					</script>
					';
				
				$stra = explode(" ",$data['date_time']);
				$new_date = explode("-",$stra[0]);
				$thedate = $new_date[2]."-".$new_date[1]."-".$new_date[0]." ".$stra[1];
				
				$wtc_datetime = ( $_REQUEST['row_id'] ) ? "datetime_id" : "hidden";
				$wtc_datetime_name = ( $_REQUEST['row_id'] ) ? "not_active2" : "data_arr[date_in]";
				$wtc_val_datetime = ( $_REQUEST['row_id'] ) ? $data['date_in'] : GlobalFunctions::get_timestemp();
				
				
				$form_arr = array(
					array("hidden","main","update_new_row"),
					array("hidden","type",$_REQUEST['type']),
					array("hidden","record_id",$_REQUEST['row_id']),
					array("hidden","sesid",SESID),
					array("hidden","unk",UNK),
					array("hidden","table","10_service_group_buy"),
					
					array($wtc_datetime,$wtc_datetime_name,$wtc_val_datetime,"תאריך העלת המוצר", "class='input_style' readonly","","hidden"),
					$user_id,$lock_edit_a,
					array("text","data_arr[product_name]",stripslashes($data['product_name']),"שם המוצר", "class='input_style'"),
					array("textarea","data_arr[product_desc]",stripslashes($data['product_desc']),"תיאור המוצר", "class='input_style' style='width: 300px; height: 100px;' onKeyDown='textCounter(this,document.editorhtml.remLen1,170)' onKeyUp='textCounter(this,document.editorhtml.remLen1,170)'"),
					array("text","remLen1","170","הגבלת תווים של תיאור המוצר", "class='input_style' size='3' maxlength='3' readonly style='border: 0px;'"),
					array("text","data_arr[price]",$data['price'],"מחיר מקורי", "class='input_style'"),
					array("text","data_arr[discount]",$data['discount'],"אחוזי הנחה", "class='input_style'"),
					array("text","date_time",$thedate,"תאריך ושעה סיום", "class='input_style' dir=ltr"),
					array("text","data_arr[min_people]",$data['min_people'],"כמות אנשים מנימלית", "class='input_style'"),
					array("text","data_arr[place]",$data['place'],"מיקום", "class='input_style'"),
					$up_img,
					
					array("submit","submit",$word[LANG]['submit_form'], "class='submit_style'")
				);
			}
		break;
		
		
		
		case "realty" :
			$sql = "select * from user_realty where id = '".(int)$_REQUEST['row_id']."' AND unk = '".UNK."'";
			$res = mysql_db_query(DB,$sql);
			$data = mysql_fetch_array($res);
			
			if( (int)$_REQUEST['row_id'] > 0 )
				$add_images = "<a href='index.php?main=user_realty_img&type=realty&realty_id=".(int)$_REQUEST['row_id']."&unk=".UNK."&sesid=".SESID."' class='maintext_link'>הוסף תמונות</a>";
			else
				$add_images = "ניתן לעלות תמונה לאחר הוספת הנכס";
			
			$form_arr = array(
				array("hidden","main","update_new_row"),
				array("hidden","type","realty"),
				array("hidden","record_id",$_REQUEST['row_id']),
				array("hidden","sesid",SESID),
				array("hidden","data_arr[unk]",UNK),
				array("hidden","unk",UNK),
				array("hidden","table","user_realty"),
				
				array("text","data_arr[title]",$data['title'],"כותרת", "class='input_style'"),
				array('blank', $add_images),
				array("text","data_arr[location]",$data['location'],"מיקום", "class='input_style'"),
				array("text","data_arr[rooms]",$data['rooms'],"מספר חדרים", "class='input_style'"),
				
				array("text","data_arr[size_by_meter]",$data['size_by_meter'],"גודל", "class='input_style'"),
				array("text","data_arr[floor]",$data['floor'],"קומה", "class='input_style'"),
				array("textarea","data_arr[notes]",stripslashes($data['notes']),"פרטים נוספים", "class='input_style' style='width: 300px; height: 100px;'"),
				array("textarea","data_arr[video_code]",stripslashes($data['video_code']),"קוד וידיאו", "class='input_style' style='width: 300px; height: 100px;'"),
				array("text","data_arr[place]",$data['place'],"מיקום ברשימה", "class='input_style'"),
				
				array("submit","submit",$word[LANG]['submit_form'], "class='submit_style'")
			);
		break;
		
		
		
	}
	
// שדות חובה
//$mandatory_fields = array("data_arr[name]","data_arr[email]","data_arr[phone]");
$more = "class='maintext' border='0'";
if($lead_made_by_phone_alert){
	echo $lead_made_by_phone_alert;
}
echo FormCreator::create_form($form_arr,"index.php", $more, $mandatory_fields, "editorhtml");
if($refund_request_form){
	echo $refund_request_form;
}

	if($_REQUEST['type'] == 'articels' || $_REQUEST['type'] == 'products'  || $_REQUEST['type'] == 'video'){
		
		$sql = "SELECT * FROM site_301_redirections WHERE unk = '".UNK."' AND module = '".$_REQUEST['type']."' AND item_id = '".$_REQUEST['row_id']."'";
		
		$res = mysql_db_query(DB, $sql);
		$update_type = "insert";
		$redirect_url = "";
		if(mysql_num_rows($res)>0){
			$redirect_data = mysql_fetch_array($res);
			$update_type = "update";
			$redirect_url = $redirect_data['redirect_url'];
		}

		echo "<div id='item_identification'>";
		echo "מספר קטלוגי של הפריט: ".$_REQUEST['row_id'];
		echo "<br/><br/></div>";
		echo "<div id='item_301_redirect_form'>";
			echo "<form action='index.php' name='item_301_redirect_form' method='post' style='padding:0px; margin:0px;'>";
			echo "<input type='hidden' name='main' value='item_301_redirect' />";
			echo "<input type='hidden' name='type' value='item_301_redirect' />";
			echo "<input type='hidden' name='update_type' value='".$update_type."' />";
			echo "<input type='hidden' name='unk' value='".UNK."' />";
			echo "<input type='hidden' name='sesid' value='".SESID."' />";
			echo "<input type='hidden' name='item_id' value='".$_REQUEST['row_id']."' />";
			echo "<input type='hidden' name='module' value='".$_REQUEST['type']."' />";
			
			echo "<input type='hidden' name='return_url' value='http://www.ilbiz.co.il/ClientSite/administration/index.php?".$_SERVER['QUERY_STRING']."' />";
			echo "<table cellpadding=0 cellspacing=0 border=0 class='maintext' />";
				echo "<tr>";
					echo "<td colspan='2'>הפניית 301: <br/><br/> </td>";
				echo "</tr>";
				echo "<tr>";
					echo "<td><input type='text' name='redirect_url' value='".$redirect_url."' class='input_style' />  </td>";
					echo "<td><input type='submit' value='שמור הפנייה'></td>";
				echo "</tr>";				
			echo "</table>";
			echo "</form>";
		echo "</div>";		
	}
}
/**************************************************************************************************/

function update_new_row()	{

	
	switch($_REQUEST['type'])	{
		case "design_page_cat" :
			if( $_REQUEST['record_id'] == "" )	{
				$image_settings = array(
					"after_success_goto" => "index.php?main=List_View_Rows&type=".$_REQUEST['type']."&unk=".UNK."&sesid=".SESID,
					"table_name" => "user_design_page_cat",
					"field_name" => array("img1"),
					"server_path" => SERVER_PATH."/new_images/",
					"thumbnail_width" => "76",
					"thumbnail_height" =>"76",
				);
				$data_arr = ($_POST['data_arr'])? $_POST['data_arr'] : $_GET['data_arr'];
				insert_to_db($data_arr, $image_settings);
			}
			else	{
				$image_settings = array(
					"after_success_goto" => "index.php?main=List_View_Rows&type=".$_REQUEST['type']."&unk=".UNK."&sesid=".SESID,
					"table_name" => "user_design_page_cat",
					"field_name" => array("img1"),
					"server_path" => SERVER_PATH."/new_images/",
					"thumbnail_width" => "76",
					"thumbnail_height" =>"76",
				);
				$data_arr = ($_POST['data_arr'])? $_POST['data_arr'] : $_GET['data_arr'];
				update_db($data_arr, $image_settings);
			}
		break;
		
		case "sales" :
			if( $_REQUEST['record_id'] == "" )	{
				$image_settings = array(
					"after_success_goto" => "DO_NOTHING",
					"table_name" => $_REQUEST['table'],
					"flip_date_to_original_format" => array("end_date","start_date"),
					"field_name" => array("img","img2"),
					"server_path" => SERVER_PATH."/".$_REQUEST['type']."/",
					"thumbnail_width" => "150",
					"thumbnail_height" =>"220",
					"large_width" => "200",
					"large_height" => "250",
				);
				$data_arr = ($_POST['data_arr'])? $_POST['data_arr'] : $_GET['data_arr'];
				insert_to_db($data_arr, $image_settings);
			}
			else	{
				$image_settings = array(
					"after_success_goto" => "index.php?main=List_View_Rows&type=".$_REQUEST['type']."&s_status=".$_REQUEST['s_status']."&unk=".UNK."&sesid=".SESID,
					"table_name" => $_REQUEST['table'],
					"flip_date_to_original_format" => array("end_date","start_date"),
					"field_name" => array("img","img2"),
					"server_path" => SERVER_PATH."/".$_REQUEST['type']."/",
					"thumbnail_width" => "150",
					"thumbnail_height" =>"220",
					"large_width" => "200",
					"large_height" => "250",
				);
				$data_arr = ($_POST['data_arr'])? $_POST['data_arr'] : $_GET['data_arr'];
				update_db($data_arr, $image_settings);
			}
		break;
		
		case "articels" :
			if( $_REQUEST['record_id'] == "" )	{
				$image_settings = array(
					"server_path" => SERVER_PATH."/".$_REQUEST['type']."/",
					"thumbnail_width" => "200",
					"thumbnail_height" =>"220",
					"after_success_goto" => "DO_NOTHING",
					"field_name" => array("img"),
					"table_name" => $_REQUEST['table'],
				);
				$data_arr = ($_POST['data_arr'])? $_POST['data_arr'] : $_GET['data_arr'];
				insert_to_db($data_arr, $image_settings);
			}
			else	{
				$goto = ( $_REQUEST['from_editor'] == 1 ) ? "CLOSE" : "index.php?main=List_View_Rows&type=".$_REQUEST['type']."&unk=".UNK."&sesid=".SESID;
			
				$image_settings = array(
					"server_path" => SERVER_PATH."/".$_REQUEST['type']."/",
					"thumbnail_width" => "200",
					"thumbnail_height" =>"220",
					"after_success_goto" =>  $goto,
					"field_name" => array("img"),
					"table_name" =>  $_REQUEST['table'],
					"status" => "log",
				);
				$data_arr = ($_POST['data_arr'])? $_POST['data_arr'] : $_GET['data_arr'];
				update_db($data_arr, $image_settings);
			}
		break;
		
		case "video" :
			if( $_REQUEST['record_id'] == "" )	{
				$image_settings = array(
					"server_path" => SERVER_PATH."/".$_REQUEST['type']."/",
					"thumbnail_width" => "150",
					"thumbnail_height" =>"220",
					"after_success_goto" => "DO_NOTHING",
					"field_name" => array("img"),
					"field_name_video" => array("video"),
					"table_name" => $_REQUEST['table'],
				);
				$data_arr = ($_POST['data_arr'])? $_POST['data_arr'] : $_GET['data_arr'];
				insert_to_db($data_arr, $image_settings);
			}
			else	{
				$image_settings = array(
					"server_path" => SERVER_PATH."/".$_REQUEST['type']."/",
					"thumbnail_width" => "150",
					"thumbnail_height" => "220",
					"after_success_goto" => "index.php?main=List_View_Rows&type=".$_REQUEST['type']."&unk=".UNK."&sesid=".SESID,
					"field_name" => array("img"),
					"field_name_video" => array("video"),
					"table_name" => $_REQUEST['table'],
				);
				$data_arr = ($_POST['data_arr'])? $_POST['data_arr'] : $_GET['data_arr'];
				update_db($data_arr, $image_settings);
			}
		break;
		
		
		case "products" :
			$auto_date_10service = ( UNK == "285240640927706447" ) ? array("auto_date_10service") : array();
			
			if( $_REQUEST['record_id'] == "" )	{
				
				$image_settings = array(
					"server_path" => SERVER_PATH."/".$_REQUEST['type']."/",
					"thumbnail_width" => "150",
					"thumbnail_height" => "220",
					"large_width" => "200",
					"large_height" => "250",
					"extra_large_width" => "650",
					"extra_large_height" => "500",
					"after_success_goto" => "GET_ID",
					"field_name" => array("img","img2","img3"),
					"flip_date_to_original_format" => $auto_date_10service,
					"table_name" => $_REQUEST['table'],
				);
				$data_arr = ($_POST['data_arr'])? $_POST['data_arr'] : $_GET['data_arr'];
				$mysql_insert_id = insert_to_db($data_arr, $image_settings);
				
				if( is_array( $_POST['multiCats'] ) )
				{
					foreach( $_POST['multiCats'] as $key => $val )
					{
						$sql = "INSERT INTO user_model_cat_belong ( model , itemId, catId ) VALUES ( 'products' , '".$mysql_insert_id."' , '".$key."' )";
						$res = mysql_db_query(DB,$sql);
					}
				}
				
				// Use to kupons sms - 	S T A R T
				$sql = "select haveSmsDiscount from user_extra_settings where unk = '".UNK."'";
				$res = mysql_db_query(DB,$sql);
				$data_smsDiscount = mysql_fetch_array($res);
				if( $data_smsDiscount['haveSmsDiscount'] == "1" )
				{
					$sql = "INSERT INTO products_kupons (sms_content, module_name, item_id ) VALUES (
						'".addslashes($_POST['smsDiscount'])."' , 'pr' , '".$mysql_insert_id."' )";
					$res = mysql_db_query(DB,$sql);
				}
				// Use to kupons sms - 	E N D
				
			}
			else	{
				$image_settings = array(
					"server_path" => SERVER_PATH."/".$_REQUEST['type']."/",
					"thumbnail_width" => "150",
					"thumbnail_height" => "220",
					"large_width" => "200",
					"large_height" => "250",
					"extra_large_width" => "650",
					"extra_large_height" => "500",
					"after_success_goto" => "DO_NOTHING",
					"field_name" => array("img","img2","img3"),
					"flip_date_to_original_format" => $auto_date_10service,
					"table_name" => $_REQUEST['table'],
				);
				$data_arr = ($_POST['data_arr'])? $_POST['data_arr'] : $_GET['data_arr'];
				update_db($data_arr, $image_settings);
				
				$sql = "DELETE FROM user_model_cat_belong WHERE model = 'products' AND itemId = '".$_REQUEST['record_id']."'";
				$res = mysql_db_query(DB,$sql);
				
				if( is_array( $_POST['multiCats'] ) )
				{
					foreach( $_POST['multiCats'] as $key => $val )
					{
						$sql = "INSERT INTO user_model_cat_belong ( model , itemId, catId ) VALUES ( 'products' , '".$_REQUEST['record_id']."' , '".$key."' )";
						$res = mysql_db_query(DB,$sql);
					}
				}
				
				// Use to kupons sms - 	S T A R T
				$sql = "select haveSmsDiscount from user_extra_settings where unk = '".UNK."'";
				$res = mysql_db_query(DB,$sql);
				$data_smsDiscount = mysql_fetch_array($res);
				if( $data_smsDiscount['haveSmsDiscount'] == "1" )
				{
					$sql = "SELECT id FROM products_kupons WHERE module_name='pr' AND item_id = '".$_REQUEST['record_id']."' ";
					$res = mysql_db_query(DB,$sql);
					$smsDiscount = mysql_fetch_array($res);
					
					if( empty($smsDiscount) )
					{
						$sql = "INSERT INTO products_kupons (sms_content, module_name, item_id ) VALUES (
							'".addslashes($_POST['smsDiscount'])."' , 'pr' , '".$_REQUEST['record_id']."' )";
					}
					else
					{
						$sql = "UPDATE products_kupons SET sms_content = '".addslashes($_POST['smsDiscount'])."' WHERE module_name='pr' AND item_id = '".$_REQUEST['record_id']."'";
					}
					$res = mysql_db_query(DB,$sql);
				}
				// Use to kupons sms - 	E N D
				
			}
		break;
		
		
		case "10service_product" :
		
			if( $_REQUEST['record_id'] == "" )	{
				
				$image_settings = array(
					"server_path" => "/home/ilan123/domains/10service.co.il/public_html/products/",
					"thumbnail_width" => "650",
					"thumbnail_height" => "500",
					"after_success_goto" => "GET_ID",
					"field_name" => array("img3"),
					"flip_date_to_original_format" => array("auto_date_10service"),
					"table_name" => "user_products",
					"changeFor10service" => "yes",
				);
				$data_arr = ($_POST['data_arr'])? $_POST['data_arr'] : $_GET['data_arr'];
				
				$sql = "SELECT id FROM users WHERE unk = '".UNK."' ";
				$resId = mysql_db_query(DB, $sql );
				$dataId = mysql_fetch_array($resId);
				
				$data_arr['unk'] = "285240640927706447";
				$data_arr['belongToUser10service'] = $dataId['id'];
				$mysql_insert_id = insert_to_db($data_arr, $image_settings);
			}
			else	{
				$image_settings = array(
					"server_path" => "/home/ilan123/domains/10service.co.il/public_html/products/",
					"thumbnail_width" => "650",
					"thumbnail_height" => "500",
					"after_success_goto" => "DO_NOTHING",
					"field_name" => array("img3"),
					"flip_date_to_original_format" => array("auto_date_10service"),
					"table_name" => "user_products",
					"changeFor10service" => "yes",
				);
				$data_arr = ($_POST['data_arr'])? $_POST['data_arr'] : $_GET['data_arr'];
				
				$sql = "SELECT id FROM users WHERE unk = '".UNK."' ";
				$resId = mysql_db_query(DB, $sql );
				$dataId = mysql_fetch_array($resId);
				
				$data_arr['unk'] = "285240640927706447";
				$data_arr['belongToUser10service'] = $dataId['id'];
				update_db($data_arr, $image_settings);
			}
		break;
		
		
		case "deal_coupon" :
		
			if( $_REQUEST['record_id'] == "" )	{
				
				$image_settings = array(
					"server_path" => "/home/ilan123/domains/10service.co.il/public_html/deal_coupon/",
					"thumbnail_width" => "650",
					"thumbnail_height" => "500",
					"large_width" => "650",
					"large_height" => "500",
					"extra_large_width" => "650",
					"extra_large_height" => "500",
					"after_success_goto" => "GET_ID",
					"field_name" => array("img1","img2","img3"),
					"flip_datetime_to_original_format" => array("until_date"),
					"table_name" => "10service_deal_coupon",
					"changeFor10service" => "yes",
				);
				$data_arr = ($_POST['data_arr'])? $_POST['data_arr'] : $_GET['data_arr'];
				
				$sql = "SELECT id FROM users WHERE unk = '".UNK."' ";
				$resId = mysql_db_query(DB, $sql );
				$dataId = mysql_fetch_array($resId);
				
				$data_arr['unk'] = "285240640927706447";
				if( UNK != "285240640927706447" )
					$data_arr['user_id'] = $dataId['id'];
				$mysql_insert_id = insert_to_db($data_arr, $image_settings);
			}
			else	{
				$image_settings = array(
					"server_path" => "/home/ilan123/domains/10service.co.il/public_html/deal_coupon/",
					"thumbnail_width" => "650",
					"thumbnail_height" => "500",
					"large_width" => "650",
					"large_height" => "500",
					"extra_large_width" => "650",
					"extra_large_height" => "500",
					"after_success_goto" => "GET_ID",
					"field_name" => array("img1","img2","img3"),
					"flip_datetime_to_original_format" => array("until_date"),
					"table_name" => "10service_deal_coupon",
					"changeFor10service" => "yes",
				);
				$data_arr = ($_POST['data_arr'])? $_POST['data_arr'] : $_GET['data_arr'];
				
				$sql = "SELECT id FROM users WHERE unk = '".UNK."' ";
				$resId = mysql_db_query(DB, $sql );
				$dataId = mysql_fetch_array($resId);
				
				$data_arr['unk'] = "285240640927706447";
				if( UNK != "285240640927706447" )
					$data_arr['user_id'] = $dataId['id'];
				update_db($data_arr, $image_settings);
			}
		break;
		
		case "yad2" :
			if( $_REQUEST['record_id'] == "" )	{
				$image_settings = array(
					"server_path"=> SERVER_PATH."/".$_REQUEST['type']."/",
					"thumbnail_width"=> "150",
					"thumbnail_height"=> "220",
					"large_width"=> "200",
					"large_height" => "250",
					"after_success_goto" => "DO_NOTHING",
					"field_name" => array("img","img2"),
					"table_name" => $_REQUEST['table'],
				);
				$data_arr = ($_POST['data_arr'])? $_POST['data_arr'] : $_GET['data_arr'];
				insert_to_db($data_arr, $image_settings);
			}
			else	{
				$image_settings = array(
					"server_path" => SERVER_PATH."/".$_REQUEST['type']."/",
					"thumbnail_width" => "150",
					"thumbnail_height" => "220",
					"large_width" => "200",
					"large_height" => "250",
					"after_success_goto" => "index.php?main=List_View_Rows&type=".$_REQUEST['type']."&unk=".UNK."&sesid=".SESID,
					"field_name" => array("img","img2"),
					"table_name" => $_REQUEST['table'],
				);
				$data_arr = ($_POST['data_arr'])? $_POST['data_arr'] : $_GET['data_arr'];
				update_db($data_arr, $image_settings);
			}
		break;
		
		case "wanted" :
			if( $_REQUEST['record_id'] == "" )	{
				
				$image_settings = array(
					"after_success_goto" => "DO_NOTHING",
					"table_name" => $_REQUEST['table'],
				);
				$data_arr = ($_POST['data_arr'])? $_POST['data_arr'] : $_GET['data_arr'];
				insert_to_db($data_arr, $image_settings);
			}
			else	{
				$image_settings = array(
					"after_success_goto" => "index.php?main=List_View_Rows&type=".$_REQUEST['type']."&s_status=".$_REQUEST['s_status']."&unk=".UNK."&sesid=".SESID,
					"table_name" => $_REQUEST['table'],
				);
				$data_arr = ($_POST['data_arr'])? $_POST['data_arr'] : $_GET['data_arr'];
				update_db($data_arr, $image_settings);
			}
		break;
		
		
		case "guide" :
			if( $_REQUEST['record_id'] == "" )	{
				$image_settings = array(
					"server_path"=> SERVER_PATH."/new_images/",
					"thumbnail_width"=> "250",
					"thumbnail_height"=> "250",
					"large_width"=> "250",
					"large_height" => "250",
					"after_success_goto" => "DO_NOTHING",
					"field_name" => array("guide_img","guide_img2"),
					"table_name" => $_REQUEST['table'],
				);
				$data_arr = ($_POST['data_arr'])? $_POST['data_arr'] : $_GET['data_arr'];
				insert_to_db($data_arr, $image_settings);
			}
			else	{
				$image_settings = array(
					"server_path" => SERVER_PATH."/new_images/",
					"thumbnail_width" => "250",
					"thumbnail_height" => "250",
					"large_width" => "250",
					"large_height" => "250",
					"after_success_goto" => "index.php?main=List_View_Rows&type=".$_REQUEST['type']."&unk=".UNK."&sesid=".SESID,
					"field_name" => array("guide_img","guide_img2"),
					"table_name" => $_REQUEST['table'],
				);
				$data_arr = ($_POST['data_arr'])? $_POST['data_arr'] : $_GET['data_arr'];
				update_db($data_arr, $image_settings);
			}
		break;
		
		
		case "guide_business" :
			
			$image_settings = array(
				"after_success_goto" => "DO_NOTHING",
				"table_name" => $_REQUEST['table'],
			);
			$data_arr = ($_POST['data_arr'])? $_POST['data_arr'] : $_GET['data_arr'];
			
			
			if( $_REQUEST['record_id'] == "" )
			{
				insert_to_db($data_arr, $image_settings);
				$record_id = mysql_insert_id();
			}
			else
			{
				update_db($data_arr, $image_settings);
				$record_id = $_POST['record_id'];
			}
			
			
			
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
			//exit;
		break;
		
		
		case "banners_guide" :
			
			$image_settings = array(
				"after_success_goto" => "DO_NOTHING",
				"table_name" => $_REQUEST['table'],
			);
			$data_arr = ($_POST['data_arr'])? $_POST['data_arr'] : $_GET['data_arr'];
			
			
			if( $_REQUEST['record_id'] == "" )
			{
				insert_to_db($data_arr, $image_settings);
				$record_id = mysql_insert_id();
			}
			else
			{
				update_db($data_arr, $image_settings);
				$record_id = $_POST['record_id'];
			}
			
			
			$sql = "SELECT domain FROM users WHERE unk = '".UNK."' ";
			$res = mysql_db_query(DB,$sql);
			$userData = mysql_fetch_array($res);
			
			$server_path = "/home/ilan123/domains/".$userData['domain']."/public_html/new_images/";
			
			if($_FILES)
			{
				GlobalFunctions::create_dir_s($server_path,'banners');
				
				$server_path .= "banners/";
				
				upload_quide_img( "img1" , "banner" , $server_path , "" , "" , $record_id , "0" , "1" );
			}
			
		break;
		
		
		case "einYahav" :
				
			$image_settings = array(
				"after_success_goto" => "DO_NOTHING",
				"table_name" => $_REQUEST['table'],
				"flip_date_to_original_format" => array("date1"),
			);
			
			$data_arr = ($_POST['data_arr'])? $_POST['data_arr'] : $_GET['data_arr'];
			
			if( $_REQUEST['record_id'] == "" )
				insert_to_db($data_arr, $image_settings);
			else
				update_db($data_arr, $image_settings);
			
			echo "<script>alert('עודכן בהצלחה');</script>";
			echo "<script>window.location.href='index.php?main=get_create_form&type=".$_REQUEST['type']."&s_status=".$_REQUEST['s_status']."&unk=".UNK."&sesid=".SESID."';</script>";
		break;
		
		
		case "group_buy" :
			if( $_REQUEST['record_id'] == "" )	{
				$image_settings = array(
					"server_path" => "/home/ilan123/domains/10service.co.il/public_html/images/group_buy/",
					"thumbnail_width" => "650",
					"thumbnail_height" => "500",
					"after_success_goto" => "GET_ID",
					"field_name" => array("img"),
					"flip_datetime_to_original_format" => array("date_time"),
					"table_name" => "10_service_group_buy",
					"changeFor10service" => "yes",
				);
				$data_arr = ($_POST['data_arr'])? $_POST['data_arr'] : $_GET['data_arr'];
				
				$sql = "SELECT id FROM users WHERE unk = '".UNK."' ";
				$resId = mysql_db_query(DB, $sql );
				$dataId = mysql_fetch_array($resId);
				
				$data_arr['unk'] = "285240640927706447";
				if( UNK != "285240640927706447" )
					$data_arr['user_id'] = $dataId['id'];
				$mysql_insert_id = insert_to_db($data_arr, $image_settings);
			}
			else	{
				$image_settings = array(
					"server_path" => "/home/ilan123/domains/10service.co.il/public_html/images/group_buy/",
					"thumbnail_width" => "650",
					"thumbnail_height" => "500",
					"after_success_goto" => "DO_NOTHING",
					"field_name" => array("img"),
					"flip_datetime_to_original_format" => array("date_time"),
					"table_name" => "10_service_group_buy",
					"changeFor10service" => "yes",
				);
				$data_arr = ($_POST['data_arr'])? $_POST['data_arr'] : $_GET['data_arr'];
				
				$sql = "SELECT id FROM users WHERE unk = '".UNK."' ";
				$resId = mysql_db_query(DB, $sql );
				$dataId = mysql_fetch_array($resId);
				
				$data_arr['unk'] = "285240640927706447";
				if( UNK != "285240640927706447" )
					$data_arr['user_id'] = $dataId['id'];
				update_db($data_arr, $image_settings);
			}
		break;
		
		
		default:
			if( $_REQUEST['record_id'] == "" )	{
				
				$image_settings = array(
					"after_success_goto" => "index.php?main=List_View_Rows&type=".$_REQUEST['type']."&unk=".UNK."&sesid=".SESID,
					"table_name" => $_REQUEST['table'],
				);
				$data_arr = ($_POST['data_arr'])? $_POST['data_arr'] : $_GET['data_arr'];
				insert_to_db($data_arr, $image_settings);
			}
			else	{
				$image_settings = array(
					"after_success_goto" => "index.php?main=List_View_Rows&type=".$_REQUEST['type']."&unk=".UNK."&sesid=".SESID,
					"table_name" => $_REQUEST['table'],
				);
				$data_arr = ($_POST['data_arr'])? $_POST['data_arr'] : $_GET['data_arr'];
				update_db($data_arr, $image_settings);
			}
	}
	
		if( $data_arr['place'] == "" || $data_arr['place'] == "0" )
		{
					$myNewRecored = $GLOBALS['mysql_insert_id'];
					$sql = "UPDATE ".$_REQUEST['table']." SET place = '".$myNewRecored."' WHERE id = '".$myNewRecored."' ";
					$res = mysql_db_query(DB , $sql);
		}
		
		if( $_REQUEST['type'] == "sales" || $_REQUEST['type'] == "wanted" )
			echo "<META HTTP-EQUIV=Refresh CONTENT=\"0; URL=index.php?main=List_View_Rows&type=".$_REQUEST['type']."&unk=".UNK."&sesid=".SESID."&s_status=".$_REQUEST['s_status']."\">";
		else
			echo "<META HTTP-EQUIV=Refresh CONTENT=\"0; URL=index.php?main=List_View_Rows&type=".$_REQUEST['type']."&unk=".UNK."&sesid=".SESID."\">";
					exit;
}

function products_multi_choosen($unk)
{
	$sql = "select * from user_products_subject where unk = '".$unk."' and deleted = '0' and active = '0'";
	$res_allcat = mysql_db_query(DB,$sql);
	$data_num_all = mysql_num_rows( $res_allcat );
	
	$blank_cat_prod = "";
	$blank_cat_prod2 = "";
	if( $data_num_all > 0 )
	{
		while( $data_all = mysql_fetch_array($res_allcat) )
		{
			$sql2 = "select * from user_products_cat where unk = '".$unk."' and deleted = '0' and status = '0' AND subject_id='".$data_all['id']."'";
			$rescat = mysql_db_query(DB,$sql2);
			
			$blank_cat_prod .= "<b>".stripslashes($data_all['name']).":</b>";
			$blank_cat_prod .= "&nbsp;&nbsp;&nbsp;";
			
			while( $datacat = mysql_fetch_array($rescat) )
			{
				$sql = "SELECT catId FROM user_model_cat_belong WHERE itemId = '".$_REQUEST['row_id']."' AND model = 'products' AND catId = '".$datacat['id']."' ";
				$rescatbelong = mysql_db_query(DB,$sql);
				$datacatbelong = mysql_fetch_array($rescatbelong);
				
				$checked = ( $datacatbelong['catId'] == $datacat['id'] ) ? "checked" : "";
				$blank_cat_prod .= "<label><input type='checkbox' name='multiCats[".$datacat['id']."]' value='1' ".$checked.">".stripslashes($datacat['name'])."</label>&nbsp;&nbsp;&nbsp;";
			}
			$blank_cat_prod .= "<br>";
		}
	}
	else
	{
		$sql = "select * from user_products_cat where unk = '".$unk."' and deleted = '0' and status = '0'";
		$rescat = mysql_db_query(DB,$sql);
		
		while( $datacat = mysql_fetch_array($rescat) )
		{
			$sql = "SELECT catId FROM user_model_cat_belong WHERE itemId = '".$_REQUEST['row_id']."' AND model = 'products' AND catId = '".$datacat['id']."' ";
			$rescatbelong = mysql_db_query(DB,$sql);
			$datacatbelong = mysql_fetch_array($rescatbelong);
			
			$checked = ( $datacatbelong['catId'] == $datacat['id'] ) ? "checked" : "";
			
			$blank_cat_prod .= "<label><input type='checkbox' name='multiCats[".$datacat['id']."]' value='1' ".$checked.">".stripslashes($datacat['name'])."</label>&nbsp;&nbsp;&nbsp;";
		}
	}
	
	return $blank_cat_prod;
}

function get_create_form_Multi()
{
	global $word;
	
	$table = "user_".$_REQUEST['type'];
	$back_to = $_REQUEST['type'];
	$goto_func = $_REQUEST['type'];
	
	$loop = "10";
	
	switch($_REQUEST['type'])	{
		
		case "usresTZ" :
			
			echo "<form action='index.php' name='form_multi' method='post' style='padding: 0px; margin: 0px;'>";
			echo "<input type='hidden' name='main' value='update_new_row_Multi'>";
			echo "<input type='hidden' name='type' value='".$_REQUEST['type']."'>";
			echo "<input type='hidden' name='record_id' value='".$_REQUEST['record_id']."'>";
			echo "<input type='hidden' name='unk' value='".UNK."'>";
			echo "<input type='hidden' name='data_arr[unk]' value='".UNK."'>";
			echo "<input type='hidden' name='sesid' value='".SESID."'>";
			echo "<input type='hidden' name='table' value='users_tz_list'>";
			echo "<input type='hidden' name='loop' value='".$loop."'>";
			
			echo "<table border=\"0\" cellspacing=\"0\" cellpadding=\"0\" class=\"maintext\">";
				for( $i=1 ; $i<=$loop ; $i++ )
				{
					echo "<tr>";
						echo "<td>שם פרטי</td>";
						echo "<td width='10'></td>";
						echo "<td><input type='text' name='data_arr_".$i."[first_name]' class='input_style'></td>";
					echo "</tr>";
					echo "<tr><td colspan=3 height=7></td></tr>";
					echo "<tr>";
						echo "<td>שם משפחה</td>";
						echo "<td width='10'></td>";
						echo "<td><input type='text' name='data_arr_".$i."[last_name]' class='input_style'></td>";
					echo "</tr>";
					echo "<tr><td colspan=3 height=7></td></tr>";
					echo "<tr>";
						echo "<td>תעודת זהות</td>";
						echo "<td width='10'></td>";
						echo "<td><input type='text' name='data_arr_".$i."[tz]' class='input_style'></td>";
					echo "</tr>";
					echo "<tr><td colspan=3 height=2></td></tr>";
					echo "<tr><td colspan=3><hr width=100% size=1 color=#dfdfdf></td></tr>";
					echo "<tr><td colspan=3 height=2></td></tr>";
				}
				echo "<tr>";
					echo "<td></td>";
					echo "<td width='10'></td>";
					echo "<td><input type='submit' value='".$word[LANG]['submit_form']."' class='submit_style'></td>";
				echo "</tr>";
			echo "</table>";
			echo "</form>";
			
		break;
	}
	
}

function update_new_row_Multi()
{
	switch($_REQUEST['type'])	{
		case "" : break;
		
		default:
			if( $_REQUEST['record_id'] == "" )	{
				
				$image_settings = array(
					"after_success_goto" => "DO_NOTHING",
					"table_name" => $_REQUEST['table'],
				);
				
				for( $i=1 ; $i<=$_POST['loop'] ; $i++ )
				{
					$tempData_arr = "data_arr_".$i;
					$data_arr2 = ($_POST[$tempData_arr])? $_POST[$tempData_arr] : $_GET[$tempData_arr];
					
					if( $data_arr2['tz'] != "" )
					{
						$data_arr = ($_POST['data_arr'])? $_POST['data_arr'] : $_GET['data_arr'];
						$arr_merge = array_merge($data_arr , $data_arr2);
						print_R($arr_merge);
						insert_to_db($arr_merge, $image_settings);
					}
				}
			}
			
	}
	
	echo "<META HTTP-EQUIV=Refresh CONTENT=\"0; URL=index.php?main=List_View_Rows&type=".$_REQUEST['type']."&unk=".UNK."&sesid=".SESID."\">";
		exit;
}
/**************************************************************************************************/
/**************************************************************************************************/
/**************************************************************************************************/

function more_link()	{

	global $db,$word;
	$sql = "select * from user_more_link where unk = '".UNK."' and deleted = '0' ORDER BY place,id";
	$res = mysql_db_query($db,$sql);
	
	$sql = "SELECT name_link, id FROM user_more_link WHERE unk = '".UNK."' AND deleted=0 AND father_id=0 ORDER BY place,id";
	$res_CATS = mysql_db_query(DB, $sql);
	
	echo "<table border=\"0\" cellspacing=\"0\" cellpadding=\"0\" class=\"maintext\">";
	
		echo "<tr>";
			echo "<td colspan=\"13\"><strong>".$word[LANG]['links_add_new_link']."</strong></td>";
		echo "</tr>";
		
		echo "<tr>";
			echo "<td><u>".$word[LANG]['location']."</u></td>";
			echo "<td width=\"10\"></td>";
			echo "<td><u>".$word[LANG]['link_name']."</u></td>";
			echo "<td width=\"10\"></td>";
			echo "<td><u>".$word[LANG]['links_link_url']."</u></td>";
			echo "<td width=\"10\"></td>";
			echo "<td><u>".$word[LANG]['links_opening_target']."</u></td>";
			echo "<td width=\"10\"></td>";
			echo "<td><u>".$word[LANG]['cat']."</u></td>";
			echo "<td width=\"10\"></td>";
			echo "<td></td>";
			echo "<td width=\"10\"></td>";
			echo "<td></td>";
		echo "</tr>";
		echo "<tr><Td height=\"5\" colspan=\"13\"></TD></tr>";
		
		echo "<form action=\"index.php\" name=\"update_link_new_form\" method=\"post\">";
		echo "<input type=\"hidden\" name=\"main\" value=\"add_DB_link\">";
		echo "<input type=\"hidden\" name=\"type\" value=\"".$_REQUEST['type']."\">";
		echo "<input type=\"hidden\" name=\"unk\" value=\"".UNK."\">";
		echo "<input type=\"hidden\" name=\"sesid\" value=\"".SESID."\">";
		
		echo "<tr>";
			echo "<td><input type='text' name='place' value='' class='input_style' style='width:30px;'></td>";
			echo "<td width=\"10\"></td>";
			echo "<td><input type='text' name='name_link' value='' class='input_style' style='width:100px;'></td>";
			echo "<td width=\"10\"></td>";
			echo "<td><input type='text' dir='ltr' name='url' value='' class='input_style' style='width:150px;'></td>";
			echo "<td width=\"10\"></td>";
			echo "<td>
				<select name='link_target' class='input_style' style='width:80px;'>
						<option value='0'>".$word[LANG]['links_new_page']."</option>
						<option value='1'>".$word[LANG]['links_self_page']."</option>
					</select>
			</td>";
			echo "<td width=\"10\"></td>";
			echo "<td>
				<select name='father_id' class='input_style' style='width:120px;'>";
					echo "<option value='0'>".$word[LANG]['primary']."</option>";
					while( $data_CATS = mysql_fetch_array($res_CATS) )
					{
						echo "<option value='".$data_CATS['id']."'>".stripslashes($data_CATS['name_link'])."</option>";
					}
				echo "</select>
			</td>";
			echo "<td width=\"10\"></td>";
			echo "<td><input type=\"submit\" value=\"".$word[LANG]['save']."\" class=\"submit_style\" style='width:40px;'></td>";
			echo "<td width=\"10\"></td>";
			echo "<td></td>";
		echo "</tr>";
		
		echo "</form>";
		
		echo "<tr><Td height=\"20\" colspan=\"13\"></TD></tr>";
		
		
		echo "<tr>";
			echo "<td colspan=\"13\"><strong>".$word[LANG]['links_update_links']."</strong></td>";
		echo "</tr>";
		
		echo "<tr>";
			echo "<td><u>".$word[LANG]['location']."</u></td>";
			echo "<td width=\"10\"></td>";
			echo "<td><u>".$word[LANG]['link_name']."</u></td>";
			echo "<td width=\"10\"></td>";
			echo "<td><u>".$word[LANG]['links_link_url']."</u></td>";
			echo "<td width=\"10\"></td>";
			echo "<td><u>".$word[LANG]['links_opening_target']."</u></td>";
			echo "<td width=\"10\"></td>";
			echo "<td><u>".$word[LANG]['cat']."</u></td>";
			echo "<td width=\"10\"></td>";
			echo "<td></td>";
			echo "<td width=\"10\"></td>";
			echo "<td></td>";
		echo "</tr>";
		
		while( $data = mysql_fetch_array($res) )	{
			
			$sql = "SELECT name_link, id FROM user_more_link WHERE unk = '".UNK."' AND deleted=0 AND father_id=0 ORDER BY place,id";
			$res_CATS = mysql_db_query(DB, $sql);
			
			echo "<tr><Td height=\"5\" colspan=\"13\"></TD></tr>";
			
			echo "<form action=\"index.php\" name=\"update_link_".$data['id']."_form\" method=\"post\">";
			echo "<input type=\"hidden\" name=\"main\" value=\"update_DB_link\">";
			echo "<input type=\"hidden\" name=\"type\" value=\"".$_REQUEST['type']."\">";
			echo "<input type=\"hidden\" name=\"link_id\" value=\"".$data['id']."\">";
			echo "<input type=\"hidden\" name=\"unk\" value=\"".UNK."\">";
			echo "<input type=\"hidden\" name=\"sesid\" value=\"".SESID."\">";
			
			echo "<tr>";
				echo "<td><input type='text' name='place' value='".remove_geresh_sssss(stripslashes($data['place']))."' class='input_style' style='width:30px;'></td>";
				echo "<td width=\"10\"></td>";
				echo "<td><input type='text' name='name_link' value='".remove_geresh_sssss(stripslashes($data['name_link']))."' class='input_style' style='width:100px;'></td>";
				echo "<td width=\"10\"></td>";
				echo "<td><input type='text' dir='ltr' name='url' value='".stripslashes($data['url'])."' class='input_style' style='width:150px;'></td>";
				echo "<td width=\"10\"></td>";
				echo "<td>";
					$selected0 = ( $data['link_target'] == "0" ) ? "selected" : "";
					$selected1 = ( $data['link_target'] == "1" ) ? "selected" : "";
					echo "<select name='link_target' class='input_style' style='width:80px;'>";
						echo "<option value='0' ".$selected0.">".$word[LANG]['links_new_page']."</option>";
						echo "<option value='1' ".$selected1.">".$word[LANG]['links_self_page']."</option>";
					echo "</select>";
				echo "</td>";
				echo "<td width=\"10\"></td>";
				echo "<td>";
					$selected0 = ( $data['link_target'] == "0" ) ? "selected" : "";
					$selected1 = ( $data['link_target'] == "1" ) ? "selected" : "";
					echo "<select name='father_id' class='input_style' style='width:120px;'>";
						echo "<option value='0'>".$word[LANG]['primary']."</option>";
						while( $data_CATS = mysql_fetch_array($res_CATS) )
						{
							$seleted = ( $data['father_id'] == $data_CATS['id'] ) ? "selected" : "";
							echo "<option value='".$data_CATS['id']."' ".$seleted.">".stripslashes($data_CATS['name_link'])."</option>";
						}
					echo "</select>";
				echo "</td>";
				echo "<td width=\"10\"></td>";
				echo "<td><input type=\"submit\" value=\"".$word[LANG]['save']."\" class=\"submit_style\" style='width:40px;'></td>";
				echo "<td width=\"10\"></td>";
				echo "<td><a href=\"?main=del_DB_link&type=".$_REQUEST['type']."&link_id=".$data['id']."&unk=".UNK."&sesid=".SESID."\" class=\"maintext\" onclick=\"return can_i_del()\"><img src='images/remove.gif' border=0></a></td>";
			echo "</tr>";
			
			echo "</form>";
		}
	
	echo "</table>";
}

/**************************************************************************************************/

function add_DB_link()	{

	global $db;
	
	$new_name = add_geresh_sssss(addslashes($_REQUEST['name_link']));
	$sql = "insert into user_more_link (unk,name_link,url,link_target,father_id,place) values ( '".UNK."' , '".$new_name."' , '".$_REQUEST['url']."' , '".$_POST['link_target']."' , '".$_POST['father_id']."', '".$_POST['place']."')";
	$res = mysql_db_query($db,$sql);
	
	echo "<script>window.location.href='index.php?main=more_link&type=".$_REQUEST['type']."&unk=".UNK."&sesid=".SESID."';</script>";
		exit;
}
/**************************************************************************************************/

function update_DB_link()	{

	global $db;
	
	$new_name = add_geresh_sssss(addslashes($_REQUEST['name_link']));
	$sql = "update user_more_link set name_link = '".$new_name."' , url = '".$_REQUEST['url']."', father_id = '".$_REQUEST['father_id']."' , place = '".$_REQUEST['place']."', link_target = '".$_POST['link_target']."' where id = '".$_REQUEST['link_id']."' limit 1";
	$res = mysql_db_query($db,$sql);
	
	echo "<script>window.location.href='index.php?main=more_link&type=".$_REQUEST['type']."&unk=".UNK."&sesid=".SESID."';</script>";
		exit;
}
/**************************************************************************************************/

function del_DB_link()	{

	global $db;
	
	$sql = "update user_more_link set deleted = '1' where id = '".$_REQUEST['link_id']."' limit 1";
	$res = mysql_db_query($db,$sql);
	
	echo "<script>window.location.href='index.php?main=more_link&type=".$_REQUEST['type']."&unk=".UNK."&sesid=".SESID."';</script>";
		exit;
}

/**************************************************************************************************/
/**************************************************************************************************/
/**************************************************************************************************/

function topMenu_link()	{

	global $db,$word;
	
	
	echo "<table border=\"0\" cellspacing=\"0\" cellpadding=\"0\" class=\"maintext\">";
	
		echo "<tr>";
			echo "<td colspan=\"10\"><strong>הוספת קישור חדש</strong></td>";
		echo "</tr>";
		
		echo "<tr>";
			echo "<td><u>".$word[LANG]['location']."</u></td>";
			echo "<td width=\"10\"></td>";
			echo "<td><u>".$word[LANG]['link_name']."</u></td>";
			echo "<td width=\"10\"></td>";
			echo "<td><u>כתובת הקישור</u></td>";
			echo "<td width=\"10\"></td>";
			echo "<td>קטגוריה</td>";
			echo "<td width=\"10\"></td>";
			echo "<td></td>";
		echo "</tr>";
		echo "<tr><Td height=\"5\"></TD></tr>";
		
		echo "<form action=\"index.php\" name=\"update_topMenu_link_new_form\" method=\"POST\">";
		echo "<input type=\"hidden\" name=\"main\" value=\"add_DB_topMenu_link\">";
		echo "<input type=\"hidden\" name=\"type\" value=\"".$_REQUEST['type']."\">";
		echo "<input type=\"hidden\" name=\"unk\" value=\"".UNK."\">";
		echo "<input type=\"hidden\" name=\"sesid\" value=\"".SESID."\">";
		
		echo "<tr>";
			echo "<td><input type='text' name='place' value='' class='input_style' style='width:30px;'></td>";
			echo "<td width=\"10\"></td>";
			echo "<td><input type='text' name='name_link' value='' class='input_style' style='width:130px;'></td>";
			echo "<td width=\"10\"></td>";
			echo "<td><input type='text' dir='ltr' name='url' value='' class='input_style' style='width:200px;'></td>";
			echo "<td width=\"10\"></td>";
			echo "<td>";
				echo "<select name='father' class='input_style' style='width:120px;'>";
					echo "<option value='0'>ראשי</option>";
					
					$sql_father = "select name_link,id from user_topMenu_link where unk = '".UNK."' and deleted = '0' and father = '0' order by name_link";
					$res_father = mysql_db_query($db,$sql_father);
					
					while( $data_father = mysql_fetch_array($res_father) )
					{
						echo "<option value='".stripslashes($data_father['id'])."'>".stripslashes($data_father['name_link'])."</option>";
					}
					
				echo "</select>";
			echo "</td>";
			echo "<td width=\"10\"></td>";
			echo "<td><input type=\"submit\" value=\"הוספה\" class=\"submit_style\" style='width:50px;'></td>";
		echo "</tr>";
		
		echo "</form>";
		
		echo "<tr><Td height=\"20\"></TD></tr>";
		
		
		echo "<tr>";
			echo "<td colspan=\"10\"><strong>עדכון קישורים</strong></td>";
		echo "</tr>";
		
		echo "<tr>";
			echo "<td><u>".$word[LANG]['location']."</u></td>";
			echo "<td width=\"10\"></td>";
			echo "<td><u>".$word[LANG]['link_name']."</u></td>";
			echo "<td width=\"10\"></td>";
			echo "<td><u>כתובת הקישור</u></td>";
			echo "<td width=\"10\"></td>";
			echo "<td><u>קטגוריה</u></td>";
			echo "<td width=\"10\"></td>";
			echo "<td></td>";
			echo "<td width=\"10\"></td>";
			echo "<td></td>";
		echo "</tr>";
		
		$sql = "select * from user_topMenu_link where unk = '".UNK."' and deleted = '0' and father = '0' ORDER BY place, id";
		$res = mysql_db_query($db,$sql);
		
		while( $data = mysql_fetch_array($res) )	{
			echo "<tr><Td height=\"5\" colspan=\"10\"></TD></tr>";
			
			echo "<form action=\"index.php\" name=\"update_link_".$data['id']."_form\" method=\"POST\">";
			echo "<input type=\"hidden\" name=\"main\" value=\"update_DB_topMenu_link\">";
			echo "<input type=\"hidden\" name=\"type\" value=\"".$_REQUEST['type']."\">";
			echo "<input type=\"hidden\" name=\"link_id\" value=\"".$data['id']."\">";
			echo "<input type=\"hidden\" name=\"unk\" value=\"".UNK."\">";
			echo "<input type=\"hidden\" name=\"sesid\" value=\"".SESID."\">";
			
			echo "<tr>";
				echo "<td><input type='text' name='place' value='".remove_geresh_sssss(stripslashes($data['place']))."' class='input_style' style='width:30px;'></td>";
				echo "<td width=\"10\"></td>";
				echo "<td><input type='text' name='name_link' value='".remove_geresh_sssss(stripslashes($data['name_link']))."' class='input_style' style='width:130px;'></td>";
				echo "<td width=\"10\"></td>";
				echo "<td><input type='text' dir='ltr' name='url' value='".stripslashes($data['url'])."' class='input_style' style='width:200px;'></td>";
				echo "<td width=\"10\"></td>";
				echo "<td>";
					echo "<select name='father' class='input_style' style='width:120px;'>";
						$sql_father = "select name_link,id from user_topMenu_link where unk = '".UNK."' and deleted = '0' and father = '0' order by name_link";
						$res_father = mysql_db_query($db,$sql_father);
						$selected_0 = ( $data['father'] == "0" ) ? "selected" : "";
						echo "<option value='0' ".$selected_0.">ראשי</option>";
						while( $data_father = mysql_fetch_array($res_father) )
						{
							$selected = ( $data['id'] == $data_father['father'] ) ? "selected" : "";
							echo "<option value='".stripslashes($data_father['id'])."' ".$selected.">".stripslashes($data_father['name_link'])."</option>";
						}
				echo "</td>";
				echo "<td width=\"10\"></td>";
				echo "<td><input type=\"submit\" value=\"עדכון\" class=\"submit_style\" style='width:50px;'></td>";
				echo "<td width=\"10\"></td>";
				echo "<td><a href=\"?main=del_DB_topMenu_link&type=".$_REQUEST['type']."&link_id=".$data['id']."&unk=".UNK."&sesid=".SESID."\" class=\"maintext\" onclick=\"return can_i_del()\">מחיקה</a></td>";
			echo "</tr>";
			
			echo "</form>";
			
			$sql_tat = "select * from user_topMenu_link where unk = '".UNK."' and deleted = '0' and father = '".$data['id']."' ORDER BY place, id";
			$res_tat = mysql_db_query($db,$sql_tat);
			
			while( $data_tat = mysql_fetch_array($res_tat) )	{
				echo "<tr><Td height=\"5\" colspan=\"10\"></TD></tr>";
				
				echo "<form action=\"index.php\" name=\"update_link_".$data_tat['id']."_form\" method=\"POST\">";
				echo "<input type=\"hidden\" name=\"main\" value=\"update_DB_topMenu_link\">";
				echo "<input type=\"hidden\" name=\"type\" value=\"".$_REQUEST['type']."\">";
				echo "<input type=\"hidden\" name=\"link_id\" value=\"".$data_tat['id']."\">";
				echo "<input type=\"hidden\" name=\"unk\" value=\"".UNK."\">";
				echo "<input type=\"hidden\" name=\"sesid\" value=\"".SESID."\">";
				
				echo "<tr>";
					echo "<td><input type='text' name='place' value='".remove_geresh_sssss(stripslashes($data_tat['place']))."' class='input_style' style='width:30px;'></td>";
				echo "<td width=\"10\"></td>";
					echo "<td><input type='text' name='name_link' value='".remove_geresh_sssss(stripslashes($data_tat['name_link']))."' class='input_style' style='width:130px;'></td>";
					echo "<td width=\"10\"></td>";
					echo "<td><input type='text' dir='ltr' name='url' value='".stripslashes($data_tat['url'])."' class='input_style' style='width:200px;'></td>";
					echo "<td width=\"10\"></td>";
					echo "<td>";
						echo "<select name='father' class='input_style' style='width:120px;'>";
							$sql_father = "select name_link,id from user_topMenu_link where unk = '".UNK."' and deleted = '0' and father = '0' order by name_link";
							$res_father = mysql_db_query($db,$sql_father);
							$selected_0 = ( $data['father'] == "0" ) ? "selected" : "";
							echo "<option value='0' ".$selected_0.">ראשי</option>";
							while( $data_father = mysql_fetch_array($res_father) )
							{
								$selected = ( $data_tat['father'] == $data_father['id'] ) ? "selected" : "";
								echo "<option value='".stripslashes($data_father['id'])."' ".$selected.">".stripslashes($data_father['name_link'])."</option>";
							}
					echo "</td>";
					echo "<td width=\"10\"></td>";
					echo "<td><input type=\"submit\" value=\"עדכון\" class=\"submit_style\" style='width:50px;'></td>";
					echo "<td width=\"10\"></td>";
					echo "<td><a href=\"?main=del_DB_topMenu_link&type=".$_REQUEST['type']."&link_id=".$data_tat['id']."&unk=".UNK."&sesid=".SESID."\" class=\"maintext\" onclick=\"return can_i_del()\">מחיקה</a></td>";
				echo "</tr>";
				
				echo "</form>";
			}
		}
	
	echo "</table>";
}

/**************************************************************************************************/

function add_DB_topMenu_link()	{

	global $db;
	
	$new_name = add_geresh_sssss(addslashes($_POST['name_link']));
	$sql = "insert into user_topMenu_link (unk,name_link,url,father,place) values ( '".$_POST['unk']."' , '".$new_name."' , '".$_POST['url']."' , '".$_POST['father']."' , '".$_POST['place']."' )";
	$res = mysql_db_query($db,$sql);
	
	echo "<script>window.location.href='index.php?main=topMenu_link&type=".$_POST['type']."&unk=".$_POST['unk']."&sesid=".$_POST['sesid']."';</script>";
		exit;
}
/**************************************************************************************************/

function update_DB_topMenu_link()	{

	global $db;
	
	$new_name = add_geresh_sssss(addslashes($_POST['name_link']));
	$sql = "update user_topMenu_link set name_link = '".$new_name."' , url = '".$_POST['url']."' , father = '".$_POST['father']."', place = '".$_POST['place']."' where id = '".$_POST['link_id']."' limit 1";
	$res = mysql_db_query($db,$sql);
	
	echo "<script>window.location.href='index.php?main=topMenu_link&type=".$_POST['type']."&unk=".$_POST['unk']."&sesid=".$_POST['sesid']."';</script>";
		exit;
}
/**************************************************************************************************/

function del_DB_topMenu_link()	{

	global $db;
	
	$sql = "update user_topMenu_link set deleted = '1' where id = '".$_GET['link_id']."' limit 1";
	$res = mysql_db_query($db,$sql);
	
	echo "<script>window.location.href='index.php?main=topMenu_link&type=".$_GET['type']."&unk=".UNK."&sesid=".SESID."';</script>";
		exit;
}


/**************************************************************************************************/
/**************************************************************************************************/
/**************************************************************************************************/

function bottomMenu_link()	{

	global $db,$word;
	
	
	echo "<table border=\"0\" cellspacing=\"0\" cellpadding=\"0\" class=\"maintext\">";
	
		echo "<tr>";
			echo "<td colspan=\"10\"><strong>הוספת קישור חדש</strong></td>";
		echo "</tr>";
		
		echo "<tr>";
			echo "<td><u>".$word[LANG]['location']."</u></td>";
			echo "<td width=\"10\"></td>";
			echo "<td><u>".$word[LANG]['link_name']."</u></td>";
			echo "<td width=\"10\"></td>";
			echo "<td><u>כתובת הקישור</u></td>";
			echo "<td width=\"10\"></td>";
			echo "<td>קטגוריה</td>";
			echo "<td width=\"10\"></td>";			
			echo "<td></td>";
		echo "</tr>";
		echo "<tr><Td height=\"5\"></TD></tr>";
		
		echo "<form action=\"index.php\" name=\"update_bottomMenu_link_new_form\" method=\"POST\">";
		echo "<input type=\"hidden\" name=\"main\" value=\"add_DB_bottomMenu_link\">";
		echo "<input type=\"hidden\" name=\"type\" value=\"".$_REQUEST['type']."\">";
		echo "<input type=\"hidden\" name=\"unk\" value=\"".UNK."\">";
		echo "<input type=\"hidden\" name=\"sesid\" value=\"".SESID."\">";
		
		echo "<tr>";
			echo "<td><input type='text' name='place' value='' class='input_style' style='width:30px;'></td>";
			echo "<td width=\"10\"></td>";
			echo "<td><input type='text' name='name_link' value='' class='input_style' style='width:130px;'></td>";
			echo "<td width=\"10\"></td>";
			echo "<td><input type='text' dir='ltr' name='url' value='' class='input_style' style='width:200px;'></td>";
			echo "<td width=\"10\"></td>";
			echo "<td>";
				echo "<select name='father' class='input_style' style='width:120px;'>";
					echo "<option value='0'>ראשי</option>";
					
					$sql_father = "select name_link,id from user_bottomMenu_link where unk = '".UNK."' and deleted = '0' and father = '0' order by name_link";
					$res_father = mysql_db_query($db,$sql_father);
					
					while( $data_father = mysql_fetch_array($res_father) )
					{
						echo "<option value='".stripslashes($data_father['id'])."'>".stripslashes($data_father['name_link'])."</option>";
					}
					
				echo "</select>";
			echo "</td>";
			echo "<td width=\"10\"></td>";
			echo "<td><input type=\"submit\" value=\"הוספה\" class=\"submit_style\" style='width:50px;'></td>";
		echo "</tr>";
		
		echo "</form>";
		
		echo "<tr><Td height=\"20\"></TD></tr>";
		
		
		echo "<tr>";
			echo "<td colspan=\"10\"><strong>עדכון קישורים</strong></td>";
		echo "</tr>";
		
		echo "<tr>";
			echo "<td><u>".$word[LANG]['location']."</u></td>";
			echo "<td width=\"10\"></td>";
			echo "<td><u>".$word[LANG]['link_name']."</u></td>";
			echo "<td width=\"10\"></td>";
			echo "<td><u>כתובת הקישור</u></td>";
			echo "<td width=\"10\"></td>";
			echo "<td><u>קטגוריה</u></td>";
			echo "<td width=\"10\"></td>";
			echo "<td>מספר עמודות</td>";			
			echo "<td width=\"10\"></td>";
			echo "<td></td>";
			echo "<td width=\"10\"></td>";
			echo "<td></td>";
		echo "</tr>";
		
		$sql = "select * from user_bottomMenu_link where unk = '".UNK."' and deleted = '0' and father = '0' ORDER BY place, id";
		$res = mysql_db_query($db,$sql);
		
		while( $data = mysql_fetch_array($res) )	{
			echo "<tr><Td height=\"5\" colspan=\"10\"></TD></tr>";
			
			echo "<form action=\"index.php\" name=\"update_link_".$data['id']."_form\" method=\"POST\">";
			echo "<input type=\"hidden\" name=\"main\" value=\"update_DB_bottomMenu_link\">";
			echo "<input type=\"hidden\" name=\"type\" value=\"".$_REQUEST['type']."\">";
			echo "<input type=\"hidden\" name=\"link_id\" value=\"".$data['id']."\">";
			echo "<input type=\"hidden\" name=\"unk\" value=\"".UNK."\">";
			echo "<input type=\"hidden\" name=\"sesid\" value=\"".SESID."\">";
			
			echo "<tr>";
				echo "<td><input type='text' name='place' value='".remove_geresh_sssss(stripslashes($data['place']))."' class='input_style' style='width:30px;'></td>";
				echo "<td width=\"10\"></td>";
				echo "<td><input type='text' name='name_link' value='".remove_geresh_sssss(stripslashes($data['name_link']))."' class='input_style' style='width:130px;'></td>";
				echo "<td width=\"10\"></td>";
				echo "<td><input type='text' dir='ltr' name='url' value='".stripslashes($data['url'])."' class='input_style' style='width:200px;'></td>";
				echo "<td width=\"10\"></td>";
				echo "<td>";
					echo "<select name='father' class='input_style' style='width:120px;'>";
						$sql_father = "select name_link,id from user_bottomMenu_link where unk = '".UNK."' and deleted = '0' and father = '0' order by name_link";
						$res_father = mysql_db_query($db,$sql_father);
						$selected_0 = ( $data['father'] == "0" ) ? "selected" : "";
						echo "<option value='0' ".$selected_0.">ראשי</option>";
						while( $data_father = mysql_fetch_array($res_father) )
						{
							$selected = ( $data['id'] == $data_father['father'] ) ? "selected" : "";
							echo "<option value='".stripslashes($data_father['id'])."' ".$selected.">".stripslashes($data_father['name_link'])."</option>";
						}
				echo "</td>";
				echo "<td width=\"10\"></td>";
				echo "<td><input type='text' dir='ltr' name='columns' value='".stripslashes($data['columns'])."' class='input_style' style='width:15px;'></td>";
				echo "<td width=\"10\"></td>";				
				echo "<td><input type=\"submit\" value=\"עדכון\" class=\"submit_style\" style='width:50px;'></td>";
				echo "<td width=\"10\"></td>";
				echo "<td><a href=\"?main=del_DB_bottomMenu_link&type=".$_REQUEST['type']."&link_id=".$data['id']."&unk=".UNK."&sesid=".SESID."\" class=\"maintext\" onclick=\"return can_i_del()\">מחיקה</a></td>";
			echo "</tr>";
			
			echo "</form>";
			
			$sql_tat = "select * from user_bottomMenu_link where unk = '".UNK."' and deleted = '0' and father = '".$data['id']."' ORDER BY place, id";
			$res_tat = mysql_db_query($db,$sql_tat);
			
			while( $data_tat = mysql_fetch_array($res_tat) )	{
				echo "<tr><Td height=\"5\" colspan=\"10\"></TD></tr>";
				
				echo "<form action=\"index.php\" name=\"update_link_".$data_tat['id']."_form\" method=\"POST\">";
				echo "<input type=\"hidden\" name=\"main\" value=\"update_DB_bottomMenu_link\">";
				echo "<input type=\"hidden\" name=\"type\" value=\"".$_REQUEST['type']."\">";
				echo "<input type=\"hidden\" name=\"link_id\" value=\"".$data_tat['id']."\">";
				echo "<input type=\"hidden\" name=\"unk\" value=\"".UNK."\">";
				echo "<input type=\"hidden\" name=\"sesid\" value=\"".SESID."\">";
				
				echo "<tr>";
					echo "<td><input type='text' name='place' value='".remove_geresh_sssss(stripslashes($data_tat['place']))."' class='input_style' style='width:30px;'></td>";
				echo "<td width=\"10\"></td>";
					echo "<td><input type='text' name='name_link' value='".remove_geresh_sssss(stripslashes($data_tat['name_link']))."' class='input_style' style='width:130px;'></td>";
					echo "<td width=\"10\"></td>";
					echo "<td><input type='text' dir='ltr' name='url' value='".stripslashes($data_tat['url'])."' class='input_style' style='width:200px;'></td>";
					echo "<td width=\"10\"></td>";
					echo "<td>";
						echo "<select name='father' class='input_style' style='width:120px;'>";
							$sql_father = "select name_link,id from user_bottomMenu_link where unk = '".UNK."' and deleted = '0' and father = '0' order by name_link";
							$res_father = mysql_db_query($db,$sql_father);
							$selected_0 = ( $data['father'] == "0" ) ? "selected" : "";
							echo "<option value='0' ".$selected_0.">ראשי</option>";
							while( $data_father = mysql_fetch_array($res_father) )
							{
								$selected = ( $data_tat['father'] == $data_father['id'] ) ? "selected" : "";
								echo "<option value='".stripslashes($data_father['id'])."' ".$selected.">".stripslashes($data_father['name_link'])."</option>";
							}
					echo "</td>";
					
					echo "<td width=\"10\"></td>";
					echo "<td></td>";
					echo "<td width=\"10\"></td>";					
					echo "<td><input type=\"submit\" value=\"עדכון\" class=\"submit_style\" style='width:50px;'></td>";
					echo "<td width=\"10\"></td>";
					echo "<td><a href=\"?main=del_DB_bottomMenu_link&type=".$_REQUEST['type']."&link_id=".$data_tat['id']."&unk=".UNK."&sesid=".SESID."\" class=\"maintext\" onclick=\"return can_i_del()\">מחיקה</a></td>";
				echo "</tr>";
				
				echo "</form>";
			}
		}
	
	echo "</table>";
}

/**************************************************************************************************/

function add_DB_bottomMenu_link()	{

	global $db;
	
	$new_name = add_geresh_sssss(addslashes($_POST['name_link']));
	$sql = "insert into user_bottomMenu_link (unk,name_link,url,father,place) values ( '".$_POST['unk']."' , '".$new_name."' , '".$_POST['url']."' , '".$_POST['father']."' , '".$_POST['place']."' )";
	$res = mysql_db_query($db,$sql);
	
	echo "<script>window.location.href='index.php?main=bottomMenu_link&type=".$_POST['type']."&unk=".$_POST['unk']."&sesid=".$_POST['sesid']."';</script>";
		exit;
}
/**************************************************************************************************/

function update_DB_bottomMenu_link()	{

	global $db;
	
	$new_name = add_geresh_sssss(addslashes($_POST['name_link']));
	$sql = "update user_bottomMenu_link set name_link = '".$new_name."' , url = '".$_POST['url']."' , father = '".$_POST['father']."', place = '".$_POST['place']."', columns = '".$_POST['columns']."' where id = '".$_POST['link_id']."' limit 1";
	$res = mysql_db_query($db,$sql);
	
	echo "<script>window.location.href='index.php?main=bottomMenu_link&type=".$_POST['type']."&unk=".$_POST['unk']."&sesid=".$_POST['sesid']."';</script>";
		exit;
}
/**************************************************************************************************/

function del_DB_bottomMenu_link()	{

	global $db;
	
	$sql = "update user_bottomMenu_link set deleted = '1' where id = '".$_GET['link_id']."' limit 1";
	$res = mysql_db_query($db,$sql);
	
	echo "<script>window.location.href='index.php?main=bottomMenu_link&type=".$_GET['type']."&unk=".UNK."&sesid=".SESID."';</script>";
		exit;
}

/**************************************************************************************************/
/**************************************************************************************************/
/**************************************************************************************************/

function del_img_DB_FTP()	{

	global $word;
	
	if( eregi( "new_images/" , $_GET['path'] ) )
	{
		$tid = explode( "/", $_GET['path'] );
		if( $tid[1] != "landing" && $tid[1] != "banners" )
			$IdI = ( $tid[1] != "" ) ? "AND id = '".$tid[1]."'" : "";
	}
	
	$sql = "select id from ".$_GET['table']." where ".$_GET['field_name']." = '".$_GET['img']."' and unk = '".UNK."' ".$IdI;
	$res = mysql_db_query(DB,$sql);
	$data = mysql_fetch_array($res);
	$num_rows = mysql_num_rows($res);
	
	if( $num_rows == 1 )	{
		$abpath_temp_unlink = SERVER_PATH."/".$_GET['path'].$_GET['img'];
		if( file_exists($abpath_temp_unlink) && !is_dir($abpath_temp_unlink) )
		{
			unlink($abpath_temp_unlink);
		
			$sql2 = "update ".$_GET['table']." set ".$_GET['field_name']." = '' where unk = '".UNK."' and id = '".$data['id']."' limit 1";
			$res = mysql_db_query(DB,$sql2);
			
			echo "<script>alert('התמונה נמחקה בהצלחה');</script>";
		}
		else 
			echo "<script>alert('התמונה לא נמחקה, אנא נסה שנית. טעות מספר 1301170');</script>";
	}
	else	{
		echo "<script>alert('התמונה לא נמחקה, אנא נסה שנית. טעות מספר 1301189');</script>";
	}
	
	echo "<script>window.location.href='index.php?main=".$_GET['GOTO_main']."&type=".$_GET['GOTO_type']."&unk=".UNK."&sesid=".SESID."';</script>";
		exit;
}
/**************************************************************************************************/

function remove_geresh_sssss($with_geresh)  {
	$no_geresh = str_replace("'","&acute;",$with_geresh);
return $no_geresh;
}
/****************************************************************************************/
function add_geresh_sssss($with_geresh)  {
	$no_geresh1 = str_replace("´","'",$with_geresh);
	$no_geresh = str_replace("&acute;","'",$with_geresh);
return $no_geresh;
}

function send_lead_refund_request(){
	if(!isset($_REQUEST['row_id'])){
		return;
	}
	else{
		$insert_array = array();
		foreach($_REQUEST as $key=>$val){
			if($key == "comment"){
				//$val = iconv("UTF-8","Windows-1255",$val);
			}
			$insert_array[$key] = mysql_real_escape_string($val);
		}
		$insert_sql = "INSERT INTO leads_refun_requests (unk, row_id, reason, comment,request_time) VALUES ('".UNK."','".$insert_array['row_id']."','".$insert_array['reason']."','".$insert_array['comment']."',NOW())";
		$insert_res = mysql_db_query(DB,$insert_sql);
		$return_array['success'] = '1';
		echo "הבקשה לזיכוי נשלחה בהצלחה";
	}
	
}

?>