<?php

function get_content($m)	{

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
		case "video" :			echo video();						break;
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
		case "gb" :						echo gb();								break;
		case "insert_gb_response" :		echo insert_gb_response();		break;
		
		
		## --------- N E T 
		case "regNetF" :									echo register_net_form();										break;
		case "regNetF_DB" :								echo register_net_form_DB();								break;
		case "regNetF2" :									echo register_net_form2();									break;
		case "regNetF2_DB" :							echo register_net_form2_DB();								break;
		case "net_mail_verOK" :						echo net_mail_verOK();											break;
		case "regNetF_thx" :							echo register_net_form_thx();								break;
		case "NetMess" :									echo net_messages_list();										break;
		case "NetPass" :									echo net_forget_password();									break;
		case "NetPass_AC" :								echo net_forget_password_AC();							break;
		case "NetPass_VR" :								echo net_forget_password_verify();					break;
		case "NetProfile" :								echo NetProfile();													break;
		case "net_mail_remove" :					echo net_mail_remove();											break;
		case "net_mail_removeChossen" :		echo net_mail_removeChossen();							break;
		
		## --------- E-COM
		case "ecom_form" :						echo ecom_form_step_1();								break;
		case "ecom_form2" :						echo ecom_form_step_2();								break;
		case "add_new_reg_client" :						echo add_new_reg_client();								break;
		case "add_order_to_DB" :						echo add_order_to_DB();								break;
		case "get_thanks_ecom_form" :						echo get_thanks_ecom_form();								break;
		case "get_thanks_paypalJewelry" :						echo get_thanks_paypalJewelry();								break;
		
		## --------- Calendar
		case "calendar_events" :						echo calendar_events();								break;
		
		case "castum_frame" :						echo castum_frame();								break;
	}
}
/***************************************************************************************************/

function get_text_area($type="")	{

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
			$qry = "SELECT * FROM content_pages WHERE deleted=0 AND lib=".$_GET['lib']." AND unk = '".UNK."' ORDER BY id LIMIT 1";
			$res = mysql_db_query( DB , $qry );
			$data = mysql_fetch_array($res);
			$_GET['t'] = $data['id'];
			
		}
	}
	
	echo "<table border=\"0\" cellspacing=\"0\" cellpadding=\"0\" class=\"maintext\">";
		
		// IF HBA and need cats
		if( UNK == "819413848591511341" && $data['hba_active_cats'] == "1" )
		{
			$sql = "SELECT id FROM user_design_page_cat WHERE page_id = '".$type."' AND active=0 AND deleted=0 ORDER BY id LIMIT 1";
			$res = mysql_db_query(DB ,$sql );
			$first_c = mysql_fetch_array($res);
			
			$c = ( $_GET['c'] == "" ) ? $first_c['id'] : $_GET['c'];
			
			$sql = "SELECT id FROM user_design_page WHERE cat = '".$c."' ORDER BY id LIMIT 1";
	    $res2 = mysql_db_query(DB ,$sql );
	    $first_dd = mysql_fetch_array($res2);
			
			$dd = ( $_GET['dd'] == "" ) ? $first_dd['id'] : $_GET['dd'];
			
			echo "<tr>";
				echo "<td>".hba_cat_func($type, $c, $dd )."</td>";
			echo "</tr>";
			
			$sql = "SELECT id, title, content FROM user_design_page WHERE cat = '".$c."' and id = '".$dd."'";
	    $res2 = mysql_db_query(DB ,$sql );
	    $data_pages = mysql_fetch_array($res2);
	    
			$content = string_rplace_func($data_pages['content']);
			echo "<tr><td height=25></td></tr>";
			echo "<tr>";
				echo "<td>".stripslashes($content)."</td>";
			echo "</tr>";
		}
		else
		{
			
			if( isset($_GET['t']) )
			{
				$qry = "SELECT defualt_show_libs_options,active FROM user_text_libs WHERE id = '".$data['lib']."' AND unk = '".UNK."'";
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
									<select name='lib' class='input_style' onchange=\"selectLibForm.submit()\">";
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
								
								$qry = "SELECT name, id FROM content_pages WHERE deleted=0 AND lib=".$myCurrectLib." AND unk = '".UNK."' ORDER BY id";
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
				
				echo "<tr>";
					echo "<td>".stripslashes($content)."</td>";
				echo "</tr>";
		}
		
	echo "</table>";
}
/***************************************************************************************************/

exit;
function contact()
{
	global $word;
	
	$sql = "select * from content_pages where unk = '".UNK."' and type = 'contact' and deleted = '0'";
	$res = mysql_db_query(DB,$sql);
	$data = mysql_fetch_array($res);
	
	$form_arr = array(
		array("hidden","m","insert_contact"),
		array("hidden","data_arr[unk]",UNK),
		array("hidden","record_id",$_REQUEST['row_id']),
		
		array("text","data_arr[name]","",$word[LANG]['1_1_contact_full_name'].":", "class='input_style'","","1"),
		array("text","data_arr[email]","",$word[LANG]['1_1_contact_email'].":", "class='input_style'","","1"),
		array("text","data_arr[phone]","",$word[LANG]['1_1_contact_phone'].":", "class='input_style'","","1"),
		array("text","data_arr[mobile]","",$word[LANG]['1_1_contact_cell'].":", "class='input_style'","","1"),
		array("textarea","data_arr[content]","",$word[LANG]['1_1_contact_text'].":", "class='input_style' style='width: 300px; height: 100px;'"),
		
		array("hidden","data_arr[date_in]",GlobalFunctions::get_timestemp(),$word[LANG]['1_1_contact_date'], "class='input_style'"),
		array("submit","submit",$word[LANG]['1_1_contact_send'], "class='submit_style'")
	);
	
	$more = "class='maintext'";
	
	$get_form = FormCreator::create_form($form_arr,"index.php", $more);
	
	echo "<table border=\"0\" cellspacing=\"0\" cellpadding=\"0\" class=\"maintext\">";
		
		$content = string_rplace_func($data['content']);
		
		echo "<tr>";
			echo "<td>".stripslashes($content)."</td>";
		echo "</tr>";
		echo "<tr><td height=\"10\"></td></tr>";
		echo "<tr>";
			echo "<td>".$get_form."</td>";
		echo "</tr>";
		
	echo "</table>";
}
/***************************************************************************************************/

function insert_contact()	{

global $data_name,$word,$settings;

	$image_settings = array(
		after_success_goto=>"index.php?m=get_thanks&type=get_thx_contact",
		table_name=>"user_contact_forms",
	);
	$data_arr = ($_POST['data_arr'])? $_POST['data_arr'] : $_GET['data_arr'];

$msg2 = "
<table width=\"600\" border=\"0\" cellspacing=\"1\" cellpadding=\"1\" dir=\"".$settings['dir']."\">
  <tr>
    <td style='font-family:arial; font-size: 12px; color: #000000;'>".$word[LANG]['1_1_send_contact_email']."</td>
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
    $headers .= "From: ".$data_arr['name']." <".$data_arr['email'].">\r\n";
    
	mail($data_name['email'],$word[LANG]['1_1_send_contact_subjcet'], $fullmsg, $headers );
	
	insert_to_db($data_arr, $image_settings);
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
	echo "<table border=\"0\" cellspacing=\"0\" cellpadding=\"0\" class=\"maintext\">";
		
		echo "<tr>";
			echo "<td>".$text."</td>";
		echo "</tr>";
		
	echo "</table>";
}
/****************************************************************************************************/
/****************************************************************************************************/
/****************************************************************************************************/

function articels()
{

	global $data_colors,$word,$settings;
	
	$artd = ( $_GET['artd'] != "" ) ? "and id = '".$_GET['artd']."'" : "";
	$art_cat = ( $_GET['cat'] != "" ) ? "and cat = '".$_GET['cat']."'" : "";
	
	$sql = "select * from user_articels where unk = '".UNK."' and status = '0' ".$artd." ".$art_cat." and deleted = '0' order by id desc limit 1";
	$res = mysql_db_query(DB,$sql);
	$data = mysql_fetch_array($res);
	
	$sql_all = "select id,headline from user_articels where unk = '".UNK."' and id != '".$data['id']."' ".$art_cat." and status = '0' and deleted = '0' order by place";
	$res_all = mysql_db_query(DB,$sql_all);
	$data_num_all = mysql_num_rows($res_all);
	
	echo "<table border=\"0\" cellspacing=\"0\" cellpadding=\"0\" class=\"maintext\" width=\"100%\">";
		echo "<form action=\"index.php\" name=\"select_art_form\" method=\"get\">";
		echo "<input type='hidden' name='m' value='ar'>";
		
		echo "<tr>";
			echo "<td>";
				echo "<table border=\"0\" cellspacing=\"0\" cellpadding=\"0\" class=\"maintext\" width=\"100%\">";
					echo "<tr>";
						echo "<td><h1 style=\"font-size:16px;\">".htmlspecialchars(stripslashes($data['headline']))."</h1></td>";
						echo "<td align=\"".$settings['re_align']."\" valign=top width=260>";
						if( $data_num_all > 0 )
						{
								echo "<select name='artd' class='input_style' style=\"width:250px;\" onchange=\"select_art_form.submit()\">";
								echo "<option value=''>".$word[LANG]['1_1_articels_choose_art']."</option>";
								while( $data_all = mysql_fetch_array($res_all) )
								{
									echo "<option value='{$data_all['id']}'>".htmlspecialchars(stripslashes($data_all['headline']))."</option>";
								}
						}
						echo "</td>";
					echo "</tr>";
				echo "</table>";
			echo "</td>";
		echo "</tr>";
		
		echo "</form>";
		
		echo "<tr>";
			echo "<td>";
				$abpath_temp = SERVER_PATH."/articels/".$data['img'];
				if( file_exists($abpath_temp) && !is_dir($abpath_temp) )
					echo "<img src='articels/{$data['img']}' border='0' hspace='20' vspace='10' align='".$settings['re_align']."'>";
				
				$content = string_rplace_func($data['content']);
				
				
				echo "<b>".nl2br(stripslashes($data['summary']))."</b><br><br>
				
				".stripslashes($content)."
			</td>";
		echo "</tr>";
		
		echo "<tr><td height='30'></td></tr>";
		
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
	echo "</table>";
}


function articelsList()
{

	global $data_colors,$word,$settings, $data_words;
	
	$limitCount = ( $_GET['PL'] == "" ) ? "0" : $_GET['PL'];
	$art_cat = ( $_GET['cat'] != "" ) ? "and cat = '".$_GET['cat']."'" : "";
	$Cat = ( $_GET['cat'] != "" ) ? "&cat=".$_GET['cat'] : "";
	
	
	$sql = "select id,headline,img,summary from user_articels where unk = '".UNK."' ".$art_cat." and status = '0' and deleted = '0' order by place LIMIT ".$limitCount.",10";
	$res = mysql_db_query(DB,$sql);
	
	$sqlAll = "select id from user_articels where unk = '".UNK."' ".$art_cat." and status = '0' and deleted = '0'";
	$resAll = mysql_db_query(DB,$sqlAll);
	$num_all = mysql_num_rows($resAll);
	
	$sql = "select id,name from user_articels_cat where unk = '".UNK."' and active = '0' and deleted = '0'";
	$resCat = mysql_db_query(DB,$sql);
	$numCat = mysql_num_rows($resCat);
	
	
	echo "<table border=\"0\" cellspacing=\"0\" cellpadding=\"0\" class=\"maintext\" width=\"480\" align=center>";
		
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

function jobs()
{
	global $data_colors,$word,$settings,$data_extra_settings;
	
	$sql = "select * from user_wanted where unk = '".UNK."' and deleted = '0' order by place";
	$res = mysql_db_query(DB,$sql);
	
	echo "<table border=\"0\" cellspacing=\"0\" cellpadding=\"0\" class=\"maintext\" width=\"100%\">";

	if( $data_extra_settings['have_jobImgs'] == "1" )
	{
		while( $data = mysql_fetch_array($res) )
		{
			echo "<tr>";
				echo "<td background='/tamplate/".$data_extra_settings['jobTopImg']."' width=\"100%\" height=30>
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
				echo "<td background='/tamplate/".$data_extra_settings['jobMiddleImg']."' height=100>
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
				echo "<td background='/tamplate/".$data_extra_settings['jobBottomImg']."'></td>";
			echo "</tr>";
			
			echo "<tr><td height=\"15\"></td></tr>";
			
		}
	}
	else
	{
		while( $data = mysql_fetch_array($res) )
		{
			echo "<tr>";
				echo "<td>
					<table border=\"0\" cellspacing=\"0\" cellpadding=\"0\" class=\"site_border\" width=\"100%\">
						<tr><td colspan=\"3\" height=\"5\"></td></tr>
						<tr>
							<td width=\"10\"></td>
							<td>
								<table border=\"0\" cellspacing=\"0\" cellpadding=\"0\" class=\"maintext\" width=\"100%\">
									
									<tr>
										<td><b>".$word[LANG]['1_1_jobs_type']."</b></td>
										<td width=10></td>
										<td><u>".stripslashes($data['name'])."</u></td>
									</tr>
									<tr><td colspan=\"3\" height=\"10\"></td></tr>
									<tr>
										<td valign=\"top\"><b>".$word[LANG]['1_1_jobs_desc']."</b></td>
										<td width=10></td>
										<td>".nl2br(stripslashes($data['content']))."</td>
									</tr>
									<tr><td colspan=\"3\" height=\"10\"></td></tr>
									<tr>
										<td><nobr><b>".$word[LANG]['1_1_jobs_adv_date']."</b></nobr></td>
										<td width=10></td>
										<td>
											<table border=\"0\" cellspacing=\"0\" cellpadding=\"0\" class=\"maintext\" width=\"100%\">
													<tr>
														<td align=\"".$settings['align']."\">".GlobalFunctions::show_dateTime_field($data['date_in'])."</td>
														<td width=30></td>
														<td align=\"".$settings['re_align']."\">
															<table border=\"0\" cellspacing=\"0\" cellpadding=\"0\" class=\"maintext\">
																<tr>
																	<td>".stripslashes($data['email'])."</td>
																	<td width=30></td>
																	<td>".stripslashes($data['phone'])."</td>
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
			echo "</tr>
			<tr><td height=\"15\"></td></tr>";
		}
	}
	
	echo "</table>";
	
	
}
/****************************************************************************************************/
/****************************************************************************************************/
/****************************************************************************************************/

function getKobiaDesigner( $type )
{
	global $word,$settings,$data_colors,$data_name,$data_extra_settings;
	
	$items_on_row = "3";
	
	$kobiaColorTitle = ( $data_extra_settings['kobiaColorTitle'] != "" ) ? "style='color: #".$data_extra_settings['kobiaColorTitle']."; text-decoration: none;'" : "";
	$kobiaColorMid = ( $data_extra_settings['kobiaColorMid'] != "" ) ? "style='color: #".$data_extra_settings['kobiaColorMid'].";'" : "";
	$kobiaColorMore = ( $data_extra_settings['kobiaColorMore'] != "" ) ? "style='color: #".$data_extra_settings['kobiaColorMore'].";'" : "";
	
	switch( $type )
	{
		case "yad2" :
			$sql = "select * from user_yad2 where unk = '".UNK."' and deleted = '0' and active = '0' order by place";
			$img_lib = "yad2";
			$link_to_single = "s.ya";
			
			$words_more = "1_1_yad2_more_info";
		break;
		
		case "sales" :
			$sql = "select have_sales_dates from users where unk = '".UNK."'";
			$resUsers = mysql_db_query(DB,$sql);
			$dataUsers = mysql_fetch_array($resUsers);
			$show_end_date = ( $dataUsers['have_sales_dates'] == "0" ) ? " and end_date > '".GlobalFunctions::get_date()."'" : "";
			
			$sql = "select * from user_sales where unk = '".UNK."' ".$show_end_date." and deleted = '0' and status = '0' order by place";
			
			$img_lib = "sales";
			$link_to_single = "s.sa";
			
			$words_more = "1_1_sales_more_info";
		break;
		
		case "products" :
			$subject_id = ( $_GET['sub'] == "" ) ? "AND subject_id = ''" : "AND subject_id = ".$_GET['sub'];
			$sql = "select * from user_products_cat where unk = '".UNK."' and deleted = '0' and status = '0' ".$subject_id." order by id limit 1";
			$res_cat = mysql_db_query(DB,$sql);
			$data_cat = mysql_fetch_array($res_cat);
			
			$temp_cat = ( $_GET['cat'] ) ? $_GET['cat'] : $data_cat['id'];
			$sql = "select * from user_products where unk = '".UNK."' and deleted = '0' and active = '0' and cat = '".$temp_cat."' order by place";
			
			$img_lib = "products";
			$link_to_single = "s.pr";
			
			$words_more = "1_1_products_more_info";
			
			if( $data_name['have_ProGal_cats'] == 0 )
			{
				$extra_tr = "<tr>";
					$extra_tr .= "<td width=\"100%\" colspan=\"10\">".get_products_cat($temp_cat)."</td>";
				$extra_tr .= "</tr>
				<tr><td colspan=\"10\" height=\"20\"></td></tr>";
			}
			
		break;
		
		case "video" :
			$temp_cat = ( $_GET['cat'] ) ? " and cat='".$_GET['cat']."'" : "";
			$sql = "select * from user_video where unk = '".UNK."' and deleted = '0' ".$temp_cat." and active = '0' order by place";
			
			$img_lib = "video";
			$link_to_single = "s.vi&cat=".$_GET['cat']."";
			
			$words_more = "1_1_video_more_info";
			
			if( $data_name['have_ProGal_cats'] == 0 )
			{
				$extra_tr =  "<tr>";
					$extra_tr .=  "<td width=\"100%\" colspan=10>".get_video_cat($_GET['cat'])."</td>";
				$extra_tr .=  "</tr>";
			}
			
		break;
	}
	
	
	$res = mysql_db_query(DB,$sql);
	
	if( $type == "products" )
	{
		if( $data_name['pr_popUpType2'] == "1" )
		{
			$sqlPopUp = "select * from user_products where unk = '".UNK."' and deleted = '0' and active = '0' and cat = '".$temp_cat."' order by place";
			$resPopUp = mysql_db_query(DB,$sqlPopUp);
			
			while( $dataPopUp = mysql_fetch_array($resPopUp) )
			{
				set_PRODUCT_popup($dataPopUp , "1" );
			}
		}
	}
	
	echo "<table border=\"0\" cellspacing=\"0\" cellpadding=\"0\" class=\"maintext\" width=\"100%\">";
		
		echo $extra_tr;
		
		
		$counter = 0;
		while( $data = mysql_fetch_array($res) )
		{
			
			if( $counter%$items_on_row == 0 )
			echo "<tr>";
			
			$abpath_temp = SERVER_PATH."/".$img_lib."/".$data['img'];
				
				
				switch( $type )
				{
					case "yad2" :
						$content_item = "<table border=\"0\" cellspacing=\"0\" cellpadding=\"0\" class=\"maintext\" ".$kobiaColorMid.">";
							$content_item .= "<tr>";
								$content_item .= "<td><p style='padding:0px; margin:0px;'>".nl2br(stripslashes(htmlspecialchars($data['summary'])))."</p></td>";
							$content_item .= "</tr>";
							$content_item .= "<tr><td height=5></td></tr>";
							
							if( $data['price'] != "" )
							{
								$content_item .= "<tr>";
									$content_item .= "<td>".$word[LANG]['1_1_yad2_price']." <b>".stripslashes(htmlspecialchars($data['price']))." ".COIN."</b></td>";
								$content_item .= "</tr>";
								$content_item .= "<tr><td height=5></td></tr>";
							}
						$content_item .= "</table>";
					break;
					
					case "sales" :
						$content_item = "<table border=\"0\" cellspacing=\"0\" cellpadding=\"0\" class=\"maintext\" ".$kobiaColorMid.">";
							$content_item .= "<tr>";
								$content_item .= "<td><p style='padding:0px; margin:0px;'>".nl2br(stripslashes(htmlspecialchars($data['summary'])))."</p></td>";
							$content_item .= "</tr>";
							$content_item .= "<tr><td height=5></td></tr>";
							
							if( $data['price'] != "" )
							{
								$content_item .= "<tr>";
									$content_item .= "<td>".$word[LANG]['1_1_sales_price']." <b style=\"text-decoration: line-through;\">".$data['price']." ".COIN."</b></td>";
								$content_item .= "</tr>";
								$content_item .= "<tr><td height=5></td></tr>";
							}
							if( $data['sale_price'] != "" )
							{
								$content_item .= "<tr>";
									$content_item .= "<td>".$word[LANG]['1_1_sales_price_sale']." <b>".htmlspecialchars(stripslashes($data['sale_price']))." ".COIN."</b></td>";
								$content_item .= "</tr>";
								$content_item .= "<tr><td height=5></td></tr>";
							}
						$content_item .= "</table>";

					break;
					
					case "products" :
						
						if( $data_name['have_ecom'] == "1" && $data['active_ecom'] == "1" )
						{
							$tr_dv_1 = "<div class=\"product_container\" height=\"100%\"><div id=\"slidingProduct".$data['id']."\" class=\"sliding_product\" height=\"100%\">";
							$tr_dv_2 = "</div></div>";
						}
						
						$content_item = "<table border=\"0\" cellspacing=\"0\" cellpadding=\"0\" class=\"maintext\" ".$kobiaColorMid.">";
							$content_item .= "<tr>";
								$content_item .= "<td><p style='padding:0px; margin:0px;'>".nl2br(stripslashes(htmlspecialchars($data['summary'])))."</p></td>";
							$content_item .= "</tr>";
							$content_item .= "<tr><td height=5></td></tr>";
							
							if( $data['price'] != "" )
							{
								$content_item .= "<tr>";
									$content_item .= "<td>".$word[LANG]['1_1_products_price']." <b>".$data['price']." ".COIN."</b></td>";
								$content_item .= "</tr>";
								$content_item .= "<tr><td height=5></td></tr>";
								
								if( $data_name['have_ecom'] == "1" && $data['active_ecom'] == "1" )
								{
									$abpath_tempcartAddImg = SERVER_PATH."/tamplate/".stripslashes($data_extra_settings['cartAddImg']);
									
									$content_item .= "<tr>";
										if( file_exists($abpath_tempcartAddImg) && !is_dir($abpath_tempcartAddImg) )
											$content_item .= "<td><div id='addToBasketButton".$data['id']."'><a href='javascript:void(0)' onclick=\"addToBasket(".$data['id'].");return false\"><img src='/tamplate/".stripslashes($data_extra_settings['cartAddImg'])."' border=0></a></div></td>";
										else
											$content_item .= "<td><div id='addToBasketButton".$data['id']."'><a href='javascript:void(0)' onclick=\"addToBasket(".$data['id'].");return false\" ".$kobiaColorMid.">".$word[LANG]['1_1_products_add_to_cart']."</a></div></td>";
									$content_item .= "</tr>";
								}
							}
							
						$content_item .= "</table>";
						
					break;
					
					case "video" :
						$content_item = "<table border=\"0\" cellspacing=\"0\" cellpadding=\"0\" class=\"maintext\" ".$kobiaColorMid.">";
							$content_item .= "<tr>";
								$content_item .= "<td><p style='padding:0px; margin:0px;'>".nl2br(stripslashes(htmlspecialchars($data['summary'])))."</p></td>";
							$content_item .= "</tr>";
							$content_item .= "<tr><td height=5></td></tr>";
						$content_item .= "</table>";	
					break;
					
				}
				
				
				if( $type == "products" )
				{
					$link_pr_popup = set_PRODUCT_popup($data , "2" );
					if( $link_pr_popup == "sp" )
						$link_pr_popup = "<a href=\"index.php?m=".$link_to_single."&ud=".$data['id']."\" class=\"maintext\" title=\"".htmlspecialchars(stripslashes($data['name']))."\" ".$kobiaColorTitle.">";
				}
				else
					$link_pr_popup = "<a href=\"index.php?m=".$link_to_single."&ud=".$data['id']."\" class=\"maintext\" title=\"".htmlspecialchars(stripslashes($data['name']))."\" ".$kobiaColorTitle.">";
				
				
				if( file_exists($abpath_temp) && !is_dir($abpath_temp) )
				{
					$im_size = GetImageSize ($abpath_temp); 
					$imageWidth = $im_size[0]; 
					$imageheight = $im_size[1]; 
					
					if( $imageWidth > "151" )
						$imageWidth = "151";
					
					$img_src = $link_pr_popup;
						$img_src .= "<img src='".$img_lib."/".$data['img']."' border='0' width=\"".$imageWidth."\"></a>";
				}
				else
					$img_src = "";
					
				echo "<td height=\"100%\">";
					echo $tr_dv_1;
					echo "<table border=\"0\" cellspacing=\"0\" height=\"100%\" cellpadding=\"0\" class=\"maintext\" width=\"171\">";
						
						if( !empty($data_colors['kobia_top']) )
						{
						echo "<tr>";
							echo "<td height=\"".stripslashes($data_colors['kobia_top_height'])."\" background=\"tamplate/".stripslashes($data_colors['kobia_top'])."\"></td>";
						echo "</tr>";
						}
						
						echo "<tr>";
							echo "<td background=\"tamplate/".stripslashes($data_colors['kobia_top_back'])."\" valign=top height=34>";
								echo "<table border=\"0\" cellspacing=\"0\" cellpadding=\"0\" class=\"maintext\" width=\"100%\">";
									echo "<tr>";
										echo "<td width=10></td>";
										echo "<td align=\"center\" valign=\"top\" ".$kobiaColorTitle.">".$link_pr_popup."<h2 style='font-size:14px; padding:0px; margin:0px;' ".$kobiaColorTitle.">".htmlspecialchars(stripslashes($data['name']))."</h2></a></td>";
										echo "<td width=10></td>";
									echo "</tr>";
								echo "</table>";
							echo "</td>";
						echo "</tr>";
						
						
						echo "<tr>";
							echo "<td background=\"tamplate/".stripslashes($data_colors['kobia_back'])."\" valign=top>";
								echo "<table border=\"0\" cellspacing=\"0\" cellpadding=\"0\" class=\"maintext\" width=\"100%\">";
									echo "<tr>";
										echo "<td width=10></td>";
										echo "<td>";
											echo "<table border=\"0\" cellspacing=\"0\" cellpadding=\"0\" class=\"maintext\" width=\"151\">";
												echo "<tr>";
													echo "<td align=center>".$img_src."</td>";
												echo "</tr>";
												echo "<tr><td height=5></td></tr>";
												echo "<tr>";
													echo "<td align=\"".$settings['align']."\" ".$kobiaColorMid.">".$content_item."</td>";
												echo "</tr>";
											echo "</table>";
										echo "</td>";
										echo "<td width=10></td>";
									echo "</tr>";
								echo "</table>";
							echo "</td>";
						echo "</tr>";
						
						
						/*echo "<tr>";
							echo "<td background=\"tamplate/".stripslashes($data_colors['kobia_bottom_back'])."\" height=18>";
								echo "<table border=\"0\" cellspacing=\"0\" cellpadding=\"0\" class=\"maintext\" width=\"100%\">";orMore.">".$word[LANG][$words_more]."</b></a></td>";
										echo "<td width=10></td>";
									echo</table>";
							echo "</td>";
	ac$data_colors['kobia_bottom'])."\"></td>";
						echo "</tr>";*/
						}
						
						
					echo "</table>";
					echo $tr_dv_2;
				echo "</td>";
				
			$counter++;
			if( $counter%$items_on_row == 0 )
			{
			echo "</tr>
			<tr><td height=\"15\"></td></tr>";
			}
			else
				echo "<td width=21></td>";
		}
	echo "</table>";
}




function yad2()
{

	global $data_colors,$word,$settings;
	
	if( $data_colors['kobia_type'] == "1" )
	{
		getKobiaDesigner( "yad2" );
			return "";
	}
	
	$limitcount = ( $_GET['PL'] == "" ) ? $_POST['PL'] : $_GET['PL'];
	$limitcount = ( $limitcount == "" ) ? "0" : $limitcount;
	
	$sql = "select * from user_yad2 where unk = '".UNK."' and deleted = '0' and active = '0' order by place LIMIT ".$limitcount.",21";
	$res = mysql_db_query(DB,$sql);
	
	$sql2 = "select COUNT(id) as num_rows from user_yad2 where unk = '".UNK."' and deleted = '0' and active = '0'";
	$res2 = mysql_db_query(DB,$sql2);
	$data2 = mysql_fetch_array($res2);
	$num_rows = $data2['num_rows'];
	
	echo "<table border=\"0\" cellspacing=\"0\" cellpadding=\"0\" class=\"maintext\" width=\"100%\">";
		
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
					$img_src = "<a href=\"index.php?m=s.ya&ud=".$data['id']."\" class=\"maintext\" title=\"".htmlspecialchars(stripslashes($data['name']))."\"><img src='yad2/{$data['img']}' border='0' height=\"{$imageheight}\" width=\"".$imageWidth."\"></a>";
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
										<td align=\"".$settings['align']."\" valign=\"top\"><a href=\"index.php?m=s.ya&ud=".$data['id']."\" class=\"maintext\" title=\"".htmlspecialchars(stripslashes($data['name']))."\"><b>".htmlspecialchars(stripslashes($data['name']))."</b></a></td>
									</tr>
									
									<tr><td colspan=\"3\" height=\"1\"></td></tr>
									
									<tr>
										<td colspan=\"3\" valign=\"top\">{$img_src}</td>
									</tr>";
									
								/*
									
" height=\"5\"></td></tr>
					</table>
				</td>";
				
			$counter++;
			
			if( $counter%3 == 0 )
			{
			echo "</tr>
			<tr><td height=\"15\"></td></tr>";*/
			}
		}
		
		if( $num_rows > 21 )
		{
			echo "<tr>";
				echo "<td align=center colspan=10>";
					echo "<table align=center border=0 cellspacing=\"0\" width=100% cellpadding=\"3\" class=\"maintext\">";
							echo "<tr>";
								echo "<td align=center>";
									$z = 0;
									for($i=0 ; $i < $num_rows ; $i++)
									{
										$pz = $z+1;
										
										if($i % 21 == 0)
										{
												if( $i == $limitcount )
													$classi = "<strong style=\"color:#000000\">".$pz."</strong>&nbsp;&nbsp;";
												else
													$classi = "<a href='index.php?m=".$_GET['m']."&cat=".$_GET['cat']."&sub=".$_GET['sub']."&PL=".$i."' class='maintext'>".$pz."</a>&nbsp;&nbsp;";
												
												echo $classi;
												
												$z = $z + 1;
										}
									}
								echo "</td>";
							echo "</tr>";
						
					echo "</table>";
				echo "</td>";
			echo "</tr>";
		}
		
	echo "</table>";
}


function s_yad2()
{
	global $data_colors,$word,$settings,$temp_word_yad2;

	$sql = "select * from user_yad2 where unk = '".UNK."' and deleted = '0' and active = '0' and id = '".$_GET['ud']."' limit 1";
	$res = mysql_db_query(DB,$sql);
	$data = mysql_fetch_array($res);

	$content = string_rplace_func($data['content']);
	
	echo "<table border=\"0\" cellspacing=\"0\" cellpadding=\"0\" class=\"maintext\" width=\"100%\">";
		
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
	
	$sql = "select * from user_sales where unk = '".UNK."' ".$show_end_date." and deleted = '0' and status = '0' order by place";
	$res = mysql_db_query(DB,$sql);
	
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
					$img_src = "<a href=\"index.php?m=s.sa&ud=".$data['id']."\" class=\"maintext\" title=\"".htmlspecialchars(stripslashes($data['name']))."\"><img src='sales/{$data['img']}' border='0' height=\"{$imageheight}\" width=\"".$imageWidth."\"></a>";
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
										<td align=\"".$settings['align']."\" valign=\"top\"><a href=\"index.php?m=s.sa&ud=".$data['id']."\" class=\"maintext\" title=\"".htmlspecialchars(stripslashes($data['name']))."\"><b>".htmlspecialchars(stripslashes($data['name']))."</b></a></td>
									</tr>
									
									<tr><td colspan=\"3\" height=\"1\"></td></tr>
									
									<tr>
										<td colspan=\"3\" valign=\"top\">{$img_src}</td>
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
	echo "</table>";
}


function s_sales()
{
	global $data_colors,$word,$settings,$data_name, $temp_word_sales;
	
	$sql = "select have_sales_dates from users where unk = '".UNK."'";
	$resUsers = mysql_db_query(DB,$sql);
	$dataUsers = mysql_fetch_array($resUsers);
	$show_end_date = ( $dataUsers['have_sales_dates'] == "0" ) ? " and end_date > '".GlobalFunctions::get_date()."'" : "";
	
	
	$sql = "select * from user_sales where unk = '".UNK."' and deleted = '0' ".$show_end_date." and status = '0' and id = '".$_GET['ud']."' limit 1";
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
					echo "<img src='sales/{$data['img2']}' border='0' hspace='20' vspace='10' align='".$settings['re_align']."'>";
				else 
					if( file_exists($abpath_tempt) && !is_dir($abpath_tempt) )
						echo "<img src='sales/{$data['img']}' border='0' hspace='20' vspace='10' align='".$settings['re_align']."'>";
				
				
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
	
	if( $data_colors['kobia_type'] == "1" )
	{
		getKobiaDesigner( "products" );
			return "";
	}
	
	$subject_id = ( $_GET['sub'] == "" ) ? "AND subject_id = ''" : "AND subject_id = ".$_GET['sub'];
	$sql = "select * from user_products_cat where unk = '".UNK."' and deleted = '0' and status = '0' ".$subject_id." order by id limit 1";
	$res_cat = mysql_db_query(DB,$sql);
	$data_cat = mysql_fetch_array($res_cat);
	
	
	$temp_cat = ( $_GET['cat'] ) ? $_GET['cat'] : $data_cat['id'];
	$sql = "select * from user_products where unk = '".UNK."' and deleted = '0' and active = '0' and cat = '".$temp_cat."' order by place";
	$res = mysql_db_query(DB,$sql);
	
	echo "<table border=\"0\" cellspacing=\"0\" cellpadding=\"0\" class=\"maintext\" width=\"100%\">";
		
		if( $data_name['have_ProGal_cats'] == 0 )
		{
			echo "<tr>";
				echo "<td width=\"100%\" colspan=\"10\">".get_products_cat($temp_cat)."</td>";
			echo "</tr>";
			echo "<tr><td colspan=\"10\" height=10></td></tr>";
		}
		
		$counter = 0;
		while( $data = mysql_fetch_array($res) )
		{
			if( $counter%3 == 0 )
			echo "<tr>";
				
				$abpath_temp = SERVER_PATH."/products/".$data['img'];
				if( file_exists($abpath_temp) && !is_dir($abpath_temp) )
				{
					$im_size = GetImageSize ($abpath_temp); 
					$imageWidth = $im_size[0]; 
					$imageheight = $im_size[1]; 
					$img_src = "<a href=\"index.php?m=s.pr&ud=".$data['id']."\" class=\"maintext\" title=\"".htmlspecialchars(stripslashes($data['name']))."\"><img src='products/{$data['img']}' border='0' height=\"{$imageheight}\" width=\"".$imageWidth."\"></a>";
				}
				else
				{
					$img_src = "";
					$imageWidth = "76%";
				}
			
			
			$products_top_beck = "";
			$abpath_products_top_beck = SERVER_PATH."/tamplate/".stripslashes($data_colors['product_bg_top']);
			if( file_exists($abpath_products_top_beck) && !is_dir($abpath_products_top_beck) )
				$products_top_beck = "background=\"".HTTP_PATH."/tamplate/".stripslashes($data_colors['product_bg_top'])."\"";
			
			$products_mid_beck = "";
			$abpath_products_mid_beck = SERVER_PATH."/tamplate/".stripslashes($data_colors['product_bg_mid']);
			if( file_exists($abpath_products_mid_beck) && !is_dir($abpath_products_mid_beck) )
				$products_mid_beck = "background=\"".HTTP_PATH."/tamplate/".stripslashes($data_colors['product_bg_mid'])."\"";
			
			$products_bot_beck = "";
			$abpath_products_bot_beck = SERVER_PATH."/tamplate/".stripslashes($data_colors['product_bg_bottom']);
			if( file_exists($abpath_products_bot_beck) && !is_dir($abpath_products_bot_beck) )
				$products_bot_beck = "background=\"".HTTP_PATH."/tamplate/".stripslashes($data_colors['product_bg_bottom'])."\"";
			
				
			$class_exist = ( $products_top_beck == "" ) ? " class=\"site_border\"" : "";
				
				echo "<td valign=\"top\" height=\"100%\" align=\"center\" width=\"33%\">
					<table border=\"0\" cellspacing=\"0\" cellpadding=\"0\" ".$class_exist." height=\"100%\" width=\"156\">
						
						<tr><td colspan=\"3\"></td></tr>
						<tr>
							<td width=\"3\">
							<td valign=\"top\" height=\"100%\">";
							if( $data_name['have_ecom'] == "1" && $data['active_ecom'] == "1" )
							{
								echo "<div class=\"product_container\">
								<div id=\"slidingProduct".$data['id']."\" class=\"sliding_product\">";
							}
							
							
								echo "<table border=\"0\" height=\"100%\" cellspacing=\"0\" cellpadding=\"0\" class=\"maintext\">";
							
									echo "<tr>
										<td align=\"".$settings['align']."\" height=46 valign=\"top\" ".$products_top_beck." style='background-repeat: no-repeat;' width=\"156\"><a href=\"index.php?m=s.pr&ud=".$data['id']."\" class=\"maintext\" title=\"".htmlspecialchars(stripslashes($data['name']))."\"><b>".htmlspecialchars(stripslashes($data['name']))."</b></a></td>
									</tr>";
									
									echo "<tr>";
										echo "<td ".$products_mid_beck." valign=top width=\"156\">";
											echo "<table border=\"0\" cellspacing=\"0\" cellpadding=\"0\" class=\"maintext\">";
											
											
												echo "<tr><td height=\"1\"></td></tr>
												
												<tr>
													<td  valign=\"top\">{$img_src}</td>
												</tr>
												
												
												
												<tr><td height=\"3\"></td></tr>
												<tr>
													<td align=\"".$settings['align']."\" valign=\"top\"><b>".nl2br(stripslashes(htmlspecialchars($data['summary'])))."</b></td>
												</tr>
												<tr><td height=\"3\"></td></tr>";
												if( $data['price'] )
												{
													echo "<tr>
														<td align=\"center\" valign=\"top\">".$word[LANG]['1_1_products_price']." <b>".$data['price']." ".COIN."</b></td>
													</tr>
													<tr><td height=\"3\"></td></tr>";
													
													
													if( $data_name['have_ecom'] == "1" && $data['active_ecom'] == "1" )
													{
														$abpath_temp = SERVER_PATH."/tamplate/".stripslashes($data_extra_settings['cartAddImg']);
														
														echo "<tr>";
															echo "<td valign=\"top\" align=center>
																<table border=\"0\" cellspacing=\"0\" cellpadding=\"0\" class=\"maintext\"><tr><td>";
															if( file_exists($abpath_temp) && !is_dir($abpath_temp) )
																echo "<div id='addToBasketButton".$data['id']."' align=center><a href='javascript:void(0)' onclick=\"addToBasket(".$data['id'].");return false\"><img src='/tamplate/".stripslashes($data_extra_settings['cartAddImg'])."' border=0></a></div>";
															else
																echo "<div id='addToBasketButton".$data['id']."'><a href='javascript:void(0)' onclick=\"addToBasket(".$data['id'].");return false\">".$word[LANG]['1_1_products_add_to_cart']."</a></div>";
															echo "</td></tr></table></td>";
														echo "</tr>";
														echo "<tr><td height=\"3\"></td></tr>";
													}
												}
											echo "</table>";
										echo "</td>";
									echo "</tr>";
									
									
									echo "<tr>
										<td align=\"center\" ".$products_bot_beck." height=46 width=\"156\" style='background-repeat: no-repeat;'><a href=\"index.php?m=s.pr&ud=".$data['id']."\" class=\"maintext\" title=\"".htmlspecialchars(stripslashes($data['name']))."\"><b>".$word[LANG]['1_1_products_more_info']."</b></a></td>
									</tr>
									
								</table>";
								if( $data_name['have_ecom'] == "1"  && $data['active_ecom'] == "1" )
									{
									echo "</div></div>";
									}
							echo "</td>
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
	echo "</table>";
	
}


function s_products()
{
	global $data_colors,$data_name,$word,$settings,$data_extra_settings;
	
	$sql = "select * from user_products where unk = '".UNK."' and deleted = '0' and active = '0' and id = '".$_GET['ud']."' limit 1";
	$res = mysql_db_query(DB,$sql);
	$data = mysql_fetch_array($res);
	
	$content = string_rplace_func($data['content']);
	
	$abpath_temp = SERVER_PATH."/products/".$data['img2'];
	$abpath_tempt = SERVER_PATH."/products/".$data['img'];
	$abpath_tempEX = SERVER_PATH."/products/".$data['img3'];
	
	
	if( file_exists($abpath_tempEX) && !is_dir($abpath_tempEX) )
		echo "<div id=\"s.prEXimgDiv\" style=\"display:none\"><img src='products/{$data['img3']}' border='0'></div>";
	
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
			echo "<td align=".$settings['align']."><h1 style=\"font-size:16px;\">".htmlspecialchars(stripslashes($data['name']))."</h1></td>";
		echo "</tr>";
		
		
		echo "<tr>";
			echo "<td valign=\"top\">";
				
				
				
							
				
				echo "<div class=\"product_container\"><div id=\"slidingProduct".$data['id']."\" class=\"sliding_product\">";
				if( file_exists($abpath_temp) && !is_dir($abpath_temp) )
					if( file_exists($abpath_tempEX) && !is_dir($abpath_tempEX) )
					{
						list($org_width, $org_height) = getimagesize($abpath_tempEX);
						
						$sPrEX_width = $org_width + 10;
						$sPrEX_height = $org_height + 10;
						/*echo "<table border=\"0\" cellspacing=\"0\" cellpadding=\"0\" class=\"maintext\">";
							echo "<tr>";
								echo "<td colspan=2><a href='javascript:void(0)' onClick=\"divwin=dhtmlwindow.open('s.prEXimg', 'div', 's.prEXimgDiv', 'תמונה מוגדלת - ".htmlspecialchars(stripslashes($data['name']))."', 'width=".$sPrEX_width."px,height=".$sPrEX_height."px,left=10px,top=10px,resize=0,scrolling=0'); return false\"><img src='products/{$data['img2']}' border='0' hspace='20' vspace='10' align='".$settings['re_align']."' alt='הגדל תמונה'></a></td>";
							echo "</tr>";
							echo "<tr>";
								echo "<td width=12></td>";
								echo "<td><a href='javascript:void(0)' onClick=\"divwin=dhtmlwindow.open('s.prEXimg', 'div', 's.prEXimgDiv', 'תמונה מוגדלת - ".htmlspecialchars(stripslashes($data['name']))."', 'width=".$sPrEX_width."px,height=".$sPrEX_height."px,left=10px,top=10px,resize=0,scrolling=0'); return false\">להגדלת תמונה לחץ כאן</a></td>";
							echo "</tr>";
						echo "</table>";*/
						echo "<div align='".$settings['re_align']."' style='padding-".$settings['re_align'].": 18px; '><a href='javascript:void(0)' onClick=\"divwin=dhtmlwindow.open('s.prEXimg', 'div', 's.prEXimgDiv', '".$word[LANG]['1_1_products_extra_img']." - ".htmlspecialchars(stripslashes($data['name']))."', 'width=".$sPrEX_width."px,height=".$sPrEX_height."px,left=10px,top=10px,resize=0,scrolling=0'); return false\">".$word[LANG]['1_1_products_extra_img_link']."</a></div>";
						echo "<a href='javascript:void(0)' onClick=\"divwin=dhtmlwindow.open('s.prEXimg', 'div', 's.prEXimgDiv', '".$word[LANG]['1_1_products_extra_img']." - ".str_replace("'","",htmlspecialchars(stripslashes($data['name'])))."', 'width=".$sPrEX_width."px,height=".$sPrEX_height."px,left=10px,top=10px,resize=0,scrolling=0'); return false\"><img src='products/{$data['img2']}' border='0' hspace='20' vspace='10' align='".$settings['re_align']."' alt='".$word[LANG]['1_1_products_extra_img_resize']."'></a>";
						
					}
					else
						echo "<img src='products/{$data['img2']}' border='0' hspace='20' vspace='10' align='".$settings['re_align']."'>";
				elseif( UNK == "038157696328808156" && $data['price'] == "0" )  // chip haari castum model
					echo "<iframe src ='http://www.ilbiz.co.il/newsite/net_system/castum/chip.haari/s.pr.more.img.php?unk=".UNK."&pr=".$data['id']."&sesid=".$_SESSION['ecom']['unickSES']."' width='535' frameborder=0 height=150 scrolling=auto allowtransparency='true'></iframe>";
				else 
					if( file_exists($abpath_tempt) && !is_dir($abpath_tempt) )
						echo "<img src='products/{$data['img']}' border='0' hspace='20' vspace='10' align='".$settings['re_align']."'>";
				echo "</div></div>";
				
				/*$abpath_temp = SERVER_PATH."/tamplate/".stripslashes($data_extra_settings['cartAddImg']);
				if( $data_name['have_ecom'] == "1" && $data['active_ecom'] == "1" && $data['price'] != "" )
					if( file_exists($abpath_temp) && !is_dir($abpath_temp) )
						echo "<div id='addToBasketButton".$data['id']."'><a href='javascript:void(0)' onclick=\"addToBasket(".$data['id'].");return false\"><img src='/tamplate/".stripslashes($data_extra_settings['cartAddImg'])."' border=0></a></div>";
					else
						echo "<div id='addToBasketButton".$data['id']."'><a href='javascript:void(0)' onclick=\"addToBasket(".$data['id'].");return false\">".$word[LANG]['1_1_products_add_to_cart']."</a></div>";
				*/
				
				echo "<b>".nl2br(htmlspecialchars(stripslashes($data['summary'])))."</b><br><br>";
				
				if( !empty($data['url_name']) && !empty($data['url_link']) )
					echo $word[LANG]['1_1_products_url_link']." <a href='".htmlspecialchars(stripslashes($data['url_link']))."' class='maintext' target='_blank'><b><u>".htmlspecialchars(stripslashes($data['url_name']))."</u></b></a><br>";
				if( $data['price'] )
					echo $word[LANG]['1_1_products_price']." <b>".htmlspecialchars(stripslashes($data['price']))." ".COIN."</b><br><br>";
				
				echo nl2br(htmlspecialchars(stripslashes($content)))."<br><br>";
				
				if( $data_name['have_ecom'] == "1" && $data['makat'] != "" )
					echo $word[LANG]['1_1_products_serial_number'].": ".$data['makat']."<br>";
				
				
				$abpath_temp = SERVER_PATH."/tamplate/".stripslashes($data_extra_settings['cartAddImg']);
				if( $data_name['have_ecom'] == "1" && $data['active_ecom'] == "1" && $data['price'] != "" )
				{
					if( file_exists($abpath_temp) && !is_dir($abpath_temp) )
						echo "<div id='addToBasketButton".$data['id']."'><a href='javascript:void(0)' onclick=\"addToBasket(".$data['id'].");return false\"><img src='/tamplate/".stripslashes($data_extra_settings['cartAddImg'])."' border=0></a></div>";
					else
						echo "<div id='addToBasketButton".$data['id']."'><a href='javascript:void(0)' onclick=\"addToBasket(".$data['id'].");return false\">".$word[LANG]['1_1_products_add_to_cart']."</a></div>";
					echo "<br>";
					$abpath_temp = SERVER_PATH."/tamplate/".stripslashes($data_extra_settings['cartKopaImg']);
					if( file_exists($abpath_temp) && !is_dir($abpath_temp) )	{
						echo "<a href='index.php?m=ecom_form' class='ecom_tableRightMenu'><img src='/tamplate/".stripslashes($data_extra_settings['cartKopaImg'])."' border=0></a>";
					}
					else
					{
						echo "<b><u><a href='index.php?m=ecom_form' class='ecom_tableRightMenu'>".$word[LANG]['1_3_ecom_table_cart']."</a></u></b>";
					}
				}
				
				if( $data_name['have_print'] == "1" )
					echo "<br><a href='print.php?".$_SERVER['argv']['0']."' target='_blank'>".$word[LANG]['1_2_print_version']."</a>";
				
				
			echo "</td>";
		echo "</tr>";
		
	echo "</table>";
}

function get_products_cat($cat="")
{
	global $word;
	
	$subject_id = ( $_GET['sub'] == "" ) ? "AND subject_id = ''" : "AND subject_id = ".$_GET['sub'];
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
			
					$str .= "<select name='sub' class='input_style' style=\"width:250px;\" onchange=\"select_subject_form.submit()\">";
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
					$bold_s = ( $data['id'] == $cat) ? "<A href='index.php?m=products&cat=".$data['id']."&sub=".$_GET['sub']."' class='maintext'><b>" : "<A href='index.php?m=products&cat=".$data['id']."&sub=".$_GET['sub']."' class='maintext'>";
					$bold_e = ( $data['id'] == $cat) ? "</b></a>" : "</a>";
					$str .= $bold_s.$data['name'].$bold_e;
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
	
	$L = ( $_GET['L'] == "") ? "0" : $_GET['L'];
	
	$subject_id = ( $_GET['sub'] == "" ) ? "AND subject_id = ''" : "AND subject_id = ".$_GET['sub'];
	$sql = "select * from user_gallery_cat where unk = '".UNK."' and deleted = '0' and active = '0' ".$subject_id." limit 1";
	$res = mysql_db_query(DB,$sql);
	$data_cat = mysql_fetch_array($res);
	
	
	$temp_cat = ( $_GET['cat'] ) ? $_GET['cat'] : $data_cat['id'];
	$temp_catZero = ( $_GET['cat'] != "" ) ? $_GET['cat'] : "0";
	
	$sql = "select * from user_gallery_images where unk = '".UNK."' and deleted = '0' and cat = '".$temp_cat."' order by place limit ".$L.",12";
	$res = mysql_db_query(DB,$sql);
	
	$sql = "select id from user_gallery_images where unk = '".UNK."' and deleted = '0' and cat = '".$temp_cat."'";
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
						<script>
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
						<script>
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
								<script>
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
					$sql = "select name from user_gallery_cat where unk = '".UNK."' and deleted = '0' AND id='".$_GET['cat']."'";
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
								<script>
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
				{
					echo "<tr>
						<td>
							<table border=\"0\" cellspacing=\"0\" cellpadding=\"0\" class=\"maintext\" width=\"100%\">
								<tr>
									<td width=10></td>
									<td style='font-size:14px;'>
<b>במקום מגוון אטרקציות, ניתן להזמין : טיולי טרקטורונים, טיולי ג'יפים, טיולי רכיבה על סוסים, קיאקים ורפטינג ומגוון עיסויים.<br>
באיזור מקומות בילוי לזוגות, משפחות וחיי לילה תוססים.</b>
									</td>
									<td width=30></td>
								</tr>
							</table>
						</td>
					</tr>";
				}
				
			break;
				
			default :
				echo "<tr>";
					echo "<td>";
							echo "<div id=\"galleryDiv\"></div>";
							echo "
								<script>
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
				
					echo "<div class=\"gallerycontainer\">";
						$counter = 1;
						while( $data = mysql_fetch_array($res) )
						{
							$abpath_temp_unlink = SERVER_PATH."/gallery/".$data['img'];
							
							$abpath_temp_unlinkl = SERVER_PATH."/gallery/L".$data['img'];
							
							$exist_img = ( $counter == 1 ) ? "thumbnail2" : "thumbnail";
							if( file_exists($abpath_temp_unlink) && !is_dir($abpath_temp_unlink) )
								echo "<a class=\"{$exist_img}\" href=\"javascript:void(0)\"><img src=\"".HTTP_PATH."/gallery/".$data['img']."\" height=\"50px\" width=\"60px\" border=\"0\" /><span><img src=\"".HTTP_PATH."/gallery/L".$data['img']."\" /><br /><div align=\"right\" class='rightMenu'>".nl2br(htmlspecialchars(stripslashes($data['content'])))."</div></span></a>";
							
							if( $counter%2 == 0 )
								echo "<br>";
							$counter++;
						}
				echo "</div>";
				
			echo "</td>";
		echo "</tr>";
		
		
		
	echo "</table>";
}
}





function get_gallery_cat($cat="")
{
	global $word;
	
	$subject_id = ( $_GET['sub'] == "" ) ? "AND subject_id = '0'" : "AND subject_id = ".$_GET['sub'];
	$sql = "select * from user_gallery_cat where unk = '".UNK."' and deleted = '0' and active = '0' ".$subject_id;
	$res = mysql_db_query(DB,$sql);
	
	
	$sql = "select * from user_images_cat_subject where unk = '".UNK."' and deleted = '0' and active = '0'";
	$res_all = mysql_db_query(DB,$sql);
	$data_num_all = mysql_num_rows( $res_all );
	
	$str;
	
	$str .= "<table border=\"0\" cellspacing=\"0\" cellpadding=\"0\" class=\"maintext\">";
	
	if( $data_num_all > 0 )
	{
		$str .= "<form action=\"index.php\" name=\"select_subject_form\" method=\"get\">";
		$str .= "<input type='hidden' name='m' value='ga'>";
	
			$str .= "<tr>";
				$str .= "<td align=\"".$settings['re_align']."\" valign=top>";
			
					$str .= "<select name='sub' class='input_style' style=\"width:250px;\" onchange=\"select_subject_form.submit()\">";
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
					$bold_s = ( $data['id'] == $cat) ? "<b>" : "<A href='index.php?m=gallery&cat=".$data['id']."&sub=".$_GET['sub']."' class='maintext'>";
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

	global $data_colors,$word,$settings;
	
	if( $data_colors['kobia_type'] == "1" )
	{
		getKobiaDesigner( "video" );
			return "";
	}
	
	$temp_cat = ( $_GET['cat'] ) ? " and cat='".$_GET['cat']."'" : "";
	$sql = "select * from user_video where unk = '".UNK."' and deleted = '0' ".$temp_cat." and active = '0' order by place";
	$res = mysql_db_query(DB,$sql);
	
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
	echo "</table>";
}


function s_video()
{
	global $data_colors, $word, $temp_word_video;
	
	$sql = "select * from user_video where unk = '".UNK."' and deleted = '0' and active = '0' and id = '".$_GET['ud']."' limit 1";
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
				".nl2br(htmlspecialchars(stripslashes($content)))."<br><br>
			</td>";
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
	global $data_colors,$data_words,$settings, $word;
	
	$sql = "select * from user_hp_conf where unk = '".UNK."'";
	$res = mysql_db_query(DB,$sql);
	$data = mysql_fetch_array($res);
	
	$sql = "select have_hp_banners,hp_type,hp_text from users where unk = '".UNK."'";
	$res_have_hp_banners = mysql_db_query(DB,$sql);
	$data_have_hp_banners = mysql_fetch_array($res_have_hp_banners);
	
	$sql = "select adv_banner_2,adv_banner_1,adv_banner_1_width,adv_banner_1_height from user_hp_conf where unk = '".UNK."'";
	$res_adv_banner = mysql_db_query(DB,$sql);
	$data_adv_banner = mysql_fetch_array($res_adv_banner);
	
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
			echo "<tr>";
				echo "<td colspan=3 align=center>";
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
									/*	echo "<tR>";
											echo "<td height=177 valign=top width=\"138\" style=\"border: 1px solid #".$data_colors['border_color'].";border-bottom: 0px solid #".$data_colors['border_color'].";border-top: 0px solid #".$data_colors['border_color'].";\" align=\"left\">";
													
														
											echo "</td>";
										echo "</tR>";	*/
			}
						
			echo "<tR>";
				echo "<td valign=\"top\" width=\"430\">
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
														<td width=10></td>
														<Td>
															<table border=0 cellspacing=\"0\" width=100% cellpadding=\"0\" class=\"maintext\">
																
																<tr>
																	<td height=25 align=\"center\" bgcolor=\"#".$data_colors['bg_link']."\">
																		<table border=\"0\" cellspacing=\"0\" cellpadding=\"0\" class=\"maintext\" >
																			<tr><td height=3></td></tr>
																			<tr>
																				<td style=\"color:#".$data_colors['color_link']."\"><a href='index.php?m=ar&artd=".$data_arti['id']."' class=\"maintext\" style=\"color:#".$data_colors['color_link']."\" title=\"".htmlspecialchars(stripslashes($data_arti['headline']))."\"><b>".htmlspecialchars(stripslashes($data_arti['headline']))."</b></a></td>
																			</tr>
																			<tr><td height=5></td></tr>
																		</table>
																	</td>
																</tr>
																
															</table>
														</td>
														<td width=10></td>";
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
									
									
									
									
									
									if( UNK == "096007254104704872" )
									{
										$sql_jobs = "select * from user_wanted where unk = '".UNK."' and deleted = '0' order by id desc LIMIT 2";
										$res_jobs = mysql_db_query(DB,$sql_jobs);
										
										$temp_word_jobs = ( $data_words['id'] == "" ) ? $word[LANG]['1_2_chapter_name_jobs'] : stripslashes($data_words['word_wanted']);
										
										//echo "<tR><td style=\"font-size:16px;\"><b>".$temp_word_articels."</b></td></tr>";
										
										while( $data_jobs = mysql_fetch_array($res_jobs) )
										{
										
										echo "<tR>";
											echo "<td valign=top height=158 style=\"border: 1px solid #".$data_colors['border_color'].";border-bottom: 0px solid #".$data_colors['border_color'].";border-left: 1px solid #".$data_colors['border_color'].";\">";
												echo "<table border=\"0\" cellspacing=\"0\" cellpadding=\"0\" class=\"maintext\" width=\"100%\">";
													echo "<tr>";
														echo "
														<td width=10></td>
														<Td colspan=5>
															<table border=0 cellspacing=\"0\" width=100% cellpadding=\"0\" class=\"maintext\">
																
																<tr>
																	<td height=25 align=\"center\" bgcolor=\"#".$data_colors['bg_link']."\">
																		<table border=\"0\" cellspacing=\"0\" cellpadding=\"0\" class=\"maintext\">
																			<tr><td height=3></td></tr>
																			<tr>
																				<td style=\"color:#".$data_colors['color_link']."\"><a href='index.php?m=jo' class=\"maintext\" style=\"color:#".$data_colors['color_link']."\" title=\"".$temp_word_jobs."\"><b>".$temp_word_jobs."</b></a></td>
																			</tr>
																			<tr><td height=5></td></tr>
																		</table>
																	</td>
																</tr>
																
															</table>
														</td>
														<td width=10></td>";
													echo "</tr>";
													echo "<tr><td colspan=\"5\" height=\"10\"></td></tr>
													<tr>
														<td width=10></td>
														<td><b>".$word[LANG]['1_1_jobs_type']."</b></td>
														<td width=10></td>
														<td><u>".stripslashes($data_jobs['name'])."</u></td>
														<td width=10></td>
													</tr>
													<tr><td colspan=\"5\" height=\"10\"></td></tr>
													<tr>
														<td width=10></td>
														<td valign=\"top\"><b>".$word[LANG]['1_1_jobs_desc']."</b></td>
														<td width=10></td>
														<td>".nl2br(stripslashes($data_jobs['content']))."</td>
														<td width=10></td>
													</tr>
													<tr><td colspan=\"5\" height=\"10\"></td></tr>
													<tr>
														<td width=10></td>
														<td><nobr><b>".$word[LANG]['1_1_jobs_adv_date']."</b></nobr></td>
														<td width=10></td>
														<td align=\"".$settings['align']."\">".GlobalFunctions::show_dateTime_field($data_jobs['date_in'])."</td>
														<td width=10></td>
													</tr>
													<tr><td colspan=\"5\" height=\"10\"></td></tr>
													<tr>
														<td width=10></td>
														<td colspan=3 align=\"".$settings['re_align']."\">
															<table border=\"0\" cellspacing=\"0\" cellpadding=\"0\" class=\"maintext\">
																				<tr>
																					<td align=\"".$settings['re_align']."\">".stripslashes($data_jobs['phone'])."</td>
																					<td width=30></td>
																					<td align=\"".$settings['re_align']."\">".stripslashes($data_jobs['email'])."</td>
																				</tr>
															</table>
														</td>
														<td width=10></td>
													</tr>
																	
												</table>";
									
											echo "</td>";
										echo "</tR>";	
										}
									}
									
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
													echo "<td style=\"border: 1px solid #".$data_colors['border_color'].";\" width=\"50%\">
														<table border=\"0\" height=\"100%\" width=\"100%\" align=\"center\" cellspacing=\"0\" cellpadding=\"0\" class=\"maintext\">";
															$temp_word_video = ( $data_words['id'] == "" ) ? $word[LANG]['1_2_chapter_name_video'] : stripslashes($data_words['word_video']);
															
															
															echo "<tr>
																<td height=25 align=\"center\" style=\"border-bottom: 1px solid #".$data_colors['border_color'].";\" bgcolor=\"#".$data_colors['bg_link']."\">
																	<table border=\"0\" cellspacing=\"0\" cellpadding=\"0\" class=\"maintext\">
																		<tr><Td height=3></td></tr>
																		<tr>
																			<td style=\"color:#".$data_colors['color_link']."\"><b>".htmlspecialchars($temp_word_video)."</b></td>
																		</tr>
																		<tr><Td height=10></td></tr>
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
													echo "<td style=\"border: 1px solid #".$data_colors['border_color']."; border-left: 0px solid #".$data_colors['border_color']."; border-right: 0px solid #".$data_colors['border_color'].";\" width=\"50%\" align=".$settings['re_align'].">
														<table border=\"0\" height=\"100%\" align=".$settings['re_align']." cellspacing=\"0\" width=\"100%\" cellpadding=\"0\" class=\"maintext\">";
															$temp_word_gallery = ( $data_words['id'] == "" ) ? $word[LANG]['1_2_chapter_name_gallery'] : stripslashes($data_words['word_gallery']);
															
															echo "<tr>
																<td height=25 align=\"center\" style=\"border-bottom: 1px solid #".$data_colors['border_color'].";\" bgcolor=\"#".$data_colors['bg_link']."\">
																	<table border=\"0\" cellspacing=\"0\" cellpadding=\"0\" class=\"maintext\">
																		<tr><Td height=3></td></tr>
																		<tr>
																			<td style=\"color:#".$data_colors['color_link']."\"><b>".htmlspecialchars($temp_word_gallery)."</b></td>
																		</tr>
																		<tr><Td height=10></td></tr>
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
					echo "</table>
				</td>
				
				<td width='15'></td>";
				
				echo "<td valign=top width=\"150\" height='100%'>
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
										echo "<td valign=top align=\"".$settings['re_align']."\">
											<table border=\"0\" cellspacing=\"0\" cellpadding=\"0\" class=\"maintext\">";
										echo scroll_news("","index");
										echo "</table>
										</td>";
									echo "</tR>";
								break;
								
								case "0bot" :
									echo "<tR>";
										echo "<td valign=bottom align=\"".$settings['re_align']."\">
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
										
										echo "<tR>";
											echo "<td height=177 valign=top width=\"138\" style=\"border: 1px solid #".$data_colors['border_color'].";border-bottom: 0px solid #".$data_colors['border_color'].";border-top: 0px solid #".$data_colors['border_color'].";\" align=\"".$settings['re_align']."\">";
												echo "<table border=\"0\" height=100% width=\"138\" cellspacing=\"0\" cellpadding=\"0\" class=\"maintext\">";
													$temp_word_sales = ( $data_words['id'] == "" ) ? $word[LANG]['1_2_chapter_name_sales'] : stripslashes($data_words['word_sales']);
													
													echo "<tr>
														<td height=25 align=\"center\" style=\"border-bottom: 1px solid #".$data_colors['border_color'].";\" bgcolor=\"#".$data_colors['bg_link']."\">
															<table border=\"0\" cellspacing=\"0\" cellpadding=\"0\" class=\"maintext\" >
																<tr><Td height=3></td></tr>
																<tr>
																	<td style=\"color:#".$data_colors['color_link']."\"><b>".htmlspecialchars($temp_word_sales)."</b></td>
																</tr>
																<tr><Td height=10></td></tr>
															</table>
														</td>
													</tr>";
													echo "<tr>
														<td align=\"".$settings['align']."\" valign=\"top\" height=\"20\"><a href=\"index.php?m=s.sa&ud=".$data_sales['id']."\" class=\"maintext\" title=\"".htmlspecialchars(stripslashes($data_sales['name']))."\"><b>".htmlspecialchars(stripslashes($data_sales['name']))."</b></a></td>
													</tr>
													<tr><td colspan=\"3\" height=\"1\"></td></tr>
													<tr>
														<td colspan=\"3\" valign=\"top\" align=\"center\" height=\"70\">{$img_src}</td>
													</tr>
													<tr><td colspan=\"3\" height=\"3\"></td></tr>
													<tr>
														<td align=\"".$settings['align']."\">".nl2br(stripslashes(htmlspecialchars($data_sales['summary'])))."</td>
													</tr>
													<tr><td colspan=\"3\" height=\"3\"></td></tr>";
													if( $data_sales['sale_price'] )
														$price = "<span style='font-size: 10px;'>מחיר מבצע: <b>".stripslashes(htmlspecialchars($data_sales['sale_price']))."</b></span>";
													elseif( $data_sales['price'] )
														$price = "מחיר: <b>".stripslashes(htmlspecialchars($data_sales['price']))."</b>";
													else
														$price = "";
													
													echo "<tr><td colspan=\"3\" height=\"3\"></td></tr>
													<tr>
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
									
									$sql = "select up.* from user_products as up, user_products_cat as upc where up.unk = '".UNK."' and up.deleted = '0' and up.active = '0' and upc.deleted=0 and upc.status = 0 order by rand() LIMIT ".$pro_limit;
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
															<tr><Td height=10></td></tr>
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
															<tr><Td height=10></td></tr>
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
													$price = "מחיר: <b>".$data['price']."</b>";
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
	global $word;
	
	$sql = "select * from content_pages where unk = '".UNK."' and type = 'gb' and deleted = '0'";
	$res = mysql_db_query(DB,$sql);
	$data = mysql_fetch_array($res);
	
	$sec_check = generatePassword(8);
	
	$img_antiSpam = "<table border=\"0\" cellspacing=\"0\" cellpadding=\"0\" class=\"maintext\">
		<tr>
			<td>קוד אבטחה</td>
			<td width=33></td>
			<td><input type='text' name='contact_sec' class='input_style' style='width: 129px;' dir=ltr></td>
			<td width=20></td>
			<td><img src='http://www.ilbiz.co.il/ClientSite/text2jpg.php?word=".$sec_check."' alt='' /></td>
		</tr>
	</table>
		
	
	";
	
	
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
	
	
	$qry = "select * from user_gb_response where deleted=0 and status=1 and unk='".UNK."' order by id";
	$res_response = mysql_db_query(DB, $qry);
	$num_rows = mysql_num_rows($res_response);
	
	echo "<table border=\"0\" cellspacing=\"0\" cellpadding=\"0\" class=\"maintext\">";
		echo "<tr>";
			echo "<td>".stripslashes($content)."</td>";
		echo "</tr>";
		
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
		echo "<script>alert('קוד אבטחה שגוי');</script>";
		echo "<script>window.location.href='javascript:history.back(-1);'</script>";
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
							
							
							$myRand = rand( 0 , 100 );
							$new_code = "
							<div id=ls".$myRand."></div>
							<script type=\"text/javascript\">
								loadSWF(\"".$srcTagVal."\",\"n".$myRand."\",\"".$widthTagVal."\",\"".$heightTagVal."\",\"#\",\"ls".$myRand."\");
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
	global $word,$data_colors;
	
	$joinUs_form_arr = array(
			array("hidden","m","add_new_reg_client"),
			array("hidden","record_id",""),
			array("hidden","joinUs_arr[unk]",UNK),
			
			array("text","joinUs_arr[full_name]",$_POST['joinUs_arr']['full_name'],"* ".$word[LANG]['1_1_ecom_form_step_1_name'], "class='input_style' style='width: 150px;'","","1"),
			array("text","joinUs_arr[email]",$_POST['joinUs_arr']['email'],"* ".$word[LANG]['1_1_ecom_form_step_1_email'], "class='input_style' style='width: 150px;'","","1"),
			array("password","joinUs_arr[password]","","* ".$word[LANG]['1_1_ecom_form_step_1_password'], "class='input_style' style='width: 150px;'","","1"),

			array("text","joinUs_arr[phone]",$_POST['joinUs_arr']['phone'],$word[LANG]['1_1_ecom_form_step_1_phone'], "class='input_style' style='width: 150px;'","","1"),
			array("text","joinUs_arr[mobile]",$_POST['joinUs_arr']['mobile'],$word[LANG]['1_1_ecom_form_step_1_cell'], "class='input_style' style='width: 150px;'","","1"),
			array("text","joinUs_arr[city]",$_POST['joinUs_arr']['city'],$word[LANG]['1_1_ecom_form_step_1_city'], "class='input_style' style='width: 150px;'","","1"),
			array("text","joinUs_arr[address]",$_POST['joinUs_arr']['address'],$word[LANG]['1_1_ecom_form_step_1_address'], "class='input_style' style='width: 150px;'","","1"),
			
			array("submit","submit",$word[LANG]['1_1_ecom_form_step_1_next_step'], "class='submit_style'")
		);
		
		
		$register_form_arr = array(
			array("hidden","m","add_new_reg_client"),
			array("hidden","record_id",""),
			array("hidden","table","user_clients"),
			
			array("text","reg_arr[email]",$_POST['reg_arr']['email'],$word[LANG]['1_1_ecom_form_step_1_email'], "class='input_style' style='width: 150px;'","","1"),
			array("password","reg_arr[password]",$data['password'],$word[LANG]['1_1_ecom_form_step_1_password'], "class='input_style' style='width: 150px;'","","1"),
			
			array("submit","submit",$word[LANG]['1_1_ecom_form_step_1_next_step'], "class='submit_style'")
		);
		
		
				// שדות חובה
$mandatory_fields_joinUs_arr = array("joinUs_arr[email]","joinUs_arr[password]","joinUs_arr[full_name]");
$more = "class='maintext' border='0'";


$sql = "select product_id from user_ecom_items where unk = '".UNK."' and status=0 AND client_unickSes = '".$_SESSION['ecom']['unickSES']."' GROUP BY product_id";
$res = mysql_db_query(DB,$sql);
$num_rows = mysql_num_rows($res);

$total_price_to_pay = 0;

	echo "<table border=\"0\" cellspacing=\"0\" cellpadding=\"0\" class=\"maintext\">";
		
		echo "<tr>";
			echo "<td><h4 class=\"page_headline\">".$word['he']['1_1_ecom_form_step_1_headline']."</h4></td>";
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
					
						/// E-COM cart special details
					echo "<tr><td height='10'></td></tr>";
					echo "<tr>";
						echo "<td colspan=7 align=left><b>".$word['he']['1_3_ecom_table_total']."</b> ".$total_price_to_pay." ".COIN."</td>";
					echo "</tr>";
				echo "</table>";
			echo "</td>";
		echo "</tr>";
		
		echo "<tr><td height='10'></td></tr>";
		echo "<tr><td><hr width=100% size=1 class=\"maintext\" /></td></td>";
		echo "<tr><td height='10'></td></tr>";
		
		/// clents reg
		echo "<tr>";
			echo "<td>";
				echo "<table border=\"0\" cellspacing=\"0\" cellpadding=\"0\" class=\"maintext\">";
					echo "<tr>";
						echo "<td valign=top>";
							echo "<table border=\"0\" cellspacing=\"0\" cellpadding=\"0\" class=\"maintext\">";
								echo "<tr>";
									echo "<td><b>".$word['he']['1_1_ecom_form_step_1_new_user']."</b></td>";
								echo "</tr>";
								echo "<tr><td height=7></td></td>";
							echo "</table>";
						echo "</td>";
						echo "<td width=30 height=100% align=center><table border=\"0\" cellspacing=\"0\" cellpadding=\"0\" height=100%><tr><td align=center width=1 bgcolor=#".$data_colors['site_text_color']."></td></tr></table></td>";
						echo "<td valign=top>";
							echo "<table border=\"0\" cellspacing=\"0\" cellpadding=\"0\" class=\"maintext\">";
								echo "<tr>";
									echo "<td><b>".$word['he']['1_1_ecom_form_step_1_reg_user']."</b></td>";
								echo "</tr>";
								echo "<tr><td height=7></td></td>";
							echo "</table>";
						echo "</td>";
					echo "</tr>";
					echo "<tr>";
						echo "<td valign=top>";
							echo FormCreator::create_form($joinUs_form_arr,"index.php", $more, $mandatory_fields_joinUs_arr);
						echo "</td>";
						echo "<td width=30 height=100% align=center><table border=\"0\" cellspacing=\"0\" cellpadding=\"0\" height=100%><tr><td align=center width=1 bgcolor=#".$data_colors['site_text_color']."></td></tr></table></td>";
						echo "<td valign=top>";
							echo FormCreator::create_form($register_form_arr,"index.php", $more);
						echo "</td>";
					echo "</tr>";
				echo "</table>";
			echo "</td>";
		echo "</tr>";
		
	echo "</table>";
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
					echo "<tr>";
						echo "<td>".$word[LANG]['1_1_ecom_form_step_2_delivery']."</td>";
						echo "<td width=10></td>";
						echo "<td>";
						$delivery_pay = ( $D_ecom_settigns['delivery_pay'] != "" ) ? $D_ecom_settigns['delivery_pay'] : "0";
						
						if( UNK == "514738259673354081" )
						{
							echo "<select name='delivery_pay' class='input_style' style='width:250px;'>
								<option value='".kill_and_strip($D_ecom_settigns['delivery_pay'])."' selected>".$word[LANG]['1_1_ecom_form_step_2_delivery_pay_1'].": ".kill_and_strip($delivery_pay)." ".COIN."</option>
							</select>";
						}
						else
						{
							echo "<select name='delivery_pay' class='input_style' style='width:250px;'>
								<option value=''>".$word[LANG]['1_1_ecom_form_step_2_delivery_choose']."</option>
								<option value='0' selected>".$word[LANG]['1_1_ecom_form_step_2_delivery_pay_0']."</option>
								<option value='".kill_and_strip($D_ecom_settigns['delivery_pay'])."'>".$word[LANG]['1_1_ecom_form_step_2_delivery_pay_1'].": ".kill_and_strip($delivery_pay)." ".COIN."</option>
							</select>";
						}
						
						echo "</td>";
					echo "</tr>";
					echo "<tr><td height='5' colspan=3></td></tr>";
					echo "<tr><td colspan=3><hr width=100% size=1 class=\"maintext\" /></td></td>";
					echo "<tr><td height='5' colspan=3></td></tr>";
					echo "<tr>";
						echo "<td colspan='3'>".nl2br(kill_and_strip($D_ecom_settigns['textarea_content']))."</td>";
					echo "</tr>";
					echo "<tr><td height='10' colspan=3></td></tr>";
					echo "<tr>";
						echo "<td valign=top>".$word[LANG]['1_1_ecom_form_step_2_free_text']."</td>";
						echo "<td width=10></td>";
						echo "<td><textarea cols='' rows='' name='content' class='input_style' style='height:100px; width:250px;'></textarea></td>";
					echo "</tr>";
					echo "<tr><td height='5' colspan=3></td></tr>";
					echo "<tr>";
						echo "<td valign=top></td>";
						echo "<td width=10></td>";
						echo "<td align=left><input type='submit' value='לשלב הבא' class='submit_style'></td>";
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
		if( !empty($_POST['client_id']) )
		{
			$image_settings = array(
				after_success_goto=>"",
				table_name=>"user_ecom_orders",
			);
			
			$data_arr2['unk'] = UNK;
			$data_arr2['client_unickSes'] = $_SESSION['ecom']['unickSES'];
			$data_arr2['client_id'] = $_POST['client_id'];
			$data_arr2['content'] = $_POST['content'];
			$data_arr2['delivery_pay'] = $_POST['delivery_pay'];
			
			insert_to_db($data_arr2, $image_settings);
			
			$sql = "UPDATE user_ecom_orders SET insert_date = NOW() WHERE client_id = '".$data_arr2['client_id']."' AND client_unickSes = '".$data_arr2['client_unickSes']."' AND unk = '".UNK."'";
			$res = mysql_db_query( DB, $sql);
			
			if( UNK != "514738259673354081" AND UNK != '607189207778116683')
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
			}
			
			
			
			if( UNK == "514738259673354081" )
				echo "<script>window.location.href='index.php?m=get_thanks_ecom_form';</script>";
			elseif( UNK == "607189207778116683" )
				echo "<script>window.location.href='index.php?m=get_thanks_paypalJewelry';</script>";
			else
				echo "<script>window.location.href='index.php?m=get_thanks&type=ecom_form';</script>";
			
			exit;
		}
		else
		{
			echo "<script>alert('Error number 2136');</script>";
			echo "<script>window.location.href='index.php?m=ecom_form';</script>";
				exit;
		}
	}
	else
	{
		echo "<script>alert('Error number #*2137*#');</script>";
		echo "<script>window.location.href='index.php';</script>";
			exit;
	}
	
}

function get_thanks_ecom_form()
{
	echo "<table border=\"0\" cellspacing=\"0\" cellpadding=\"0\" class=\"maintext\">
	<form action='https://secure.ilbiz.co.il/clients/womenparadise/' method='POST' name='formi_gotossl'>
	<input type='hidden' name='unickSES' value='".$_SESSION['ecom']['unickSES']."'>
	<input type='hidden' name='active' value='".$_SESSION['ecom']['active']."'>
		<tr>
			<td><br>
באפשרותך לשלם דרך האתר בסליקה מאובטחת<br><br>
<input type='submit' value='לשלב הבא' class='submit_style'><br>
</td>
		</tr>
	</form>
	</table>";
	
		$_SESSION['ecom']['unickSES'] = "";
		$_SESSION['ecom']['active'] = "";
}


function get_thanks_paypalJewelry()
{
	$sql = "select product_id from user_ecom_items where unk = '".UNK."' and status=0 AND client_unickSes = '".$_SESSION['ecom']['unickSES']."' GROUP BY product_id";
	$res = mysql_db_query(DB,$sql);
	$num_rows = mysql_num_rows($res);
	
	echo '
	<form action="https://www.paypal.com/cgi-bin/webscr" method="post"> 
  <input type="hidden" name="cmd" value="_cart"> 
  <input type="hidden" name="upload" value="1"> 
  <input type="hidden" name="business" value="ilan@il-biz.com"> 
  ';
  
  $count = 1;
	while( $data = mysql_fetch_array($res) )
	{
		
		$sql = "select name,price,makat from user_products where id = '".$data['product_id']."'";
		$res2 = mysql_db_query(DB,$sql);
		$data2 = mysql_fetch_array($res2);
		
		$sql = "select id from user_ecom_items where unk = '".UNK."' and status=0 AND client_unickSes = '".$_SESSION['ecom']['unickSES']."' and product_id = '".$data['product_id']."'";
		$res3 = mysql_db_query(DB,$sql);
		$qry_nm = mysql_num_rows($res3);
		
		echo '
			<input type="hidden" name="item_name_'.$count.'" value="'.kill_and_strip($data2['name']).'"> 
			<input type="hidden" name="amount_'.$count.'" value="'.kill_and_strip($data2['price']).'.00"> 
			<input type="hidden" name="quantity_'.$count.'" value="'.$qry_nm.'"> 
		';
		
		$count++;
	}
  
  echo '
  Thank You!<br>
	your request will be answered shortly!<br><br>
  You have an option to pay with paypay<br><br>
  <input type="submit" value="Pay with PayPal" class="submit_style"> 
</form>
	';
	
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
				echo "<script>alert('".$word[LANG]['1_1_add_new_reg_client_detailsNot']."');</script>";
				send_form_data_TO_back("ecom_form");
					exit;
			}
		}
		else
		{
			echo "<script>alert('".$word[LANG]['1_1_add_new_reg_client_most_email']."');</script>";
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
			echo "<script>alert('".$word[LANG]['1_1_add_new_reg_client_duplicate_email']."');</script>";
			send_form_data_TO_back("ecom_form");
				exit;
		}
		
		if( !GlobalFunctions::validate_email_address($_POST['joinUs_arr']['email']) )
		{
			echo "<script>alert('".$word[LANG]['1_1_add_new_reg_client_email_not_good']."');</script>";
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
		echo "<script>alert('Error number 2124');</script>";
		echo "<script>window.location.href='index.php?m=ecom_form';</script>";
			exit;
	}
	
	
	echo "<form action='?' name='formi' method='POST'>";
		echo "<input type='hidden' name='m' value='ecom_form2'>";
		echo "<input type='hidden' name='client_id' value='".$client_id."'>";
	echo "<form>";
	echo "<script>formi.submit()</script>";
}


function send_form_data_TO_back($to_where)
{
	echo "<form action='?' name='formi' method='POST'>";
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
	echo "<form>";
	echo "<script>formi.submit()</script>";
}
?>



