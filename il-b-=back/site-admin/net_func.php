<?php

function net_menu()
{
	
	echo "<table border=\"0\" cellspacing=\"0\" cellpadding=\"3\" class=\"maintext\">";
		
		echo "<tr>";
			echo "<td><A href=\"?sesid=".SESID."\" class=\"maintext\">חזרה לתפריט הראשי</a></td>";
		echo "</tr>";
		echo "<tr><td height=\"15\"></td></tr>";
		echo "<tr>";
			echo "<td><A href=\"?main=net_client_banners&type=1&sesid=".SESID."\" class=\"maintext\">מחסן באנרים - הצטרפות לרשת</a></td>";
		echo "</tr>";
		echo "<tr><td height=\"5\"></td></tr>";
		echo "<tr>";
			echo "<td><A href=\"?main=net_client_banners&type=2&sesid=".SESID."\" class=\"maintext\">מחסן באנרים - פרסום</a></td>";
		echo "</tr>";
		echo "<tr><td height=\"5\"></td></tr>";
		echo "<tr>";
			echo "<td><A href=\"?main=net_client_banners&type=3&sesid=".SESID."\" class=\"maintext\">מחסן באנרים - מועדון, דואר נכנס/ארכיון</a></td>";
		echo "</tr>";
		echo "<tr><td height=\"15\"></td></tr>";
		echo "<tr>";
			//echo "<td><A href=\"?main=net_add_site_banners&type=2&sesid=".SESID."\" class=\"maintext\">הוספה לאתרים באנרים מהמחסן</a></td>";
		echo "</tr>";
		echo "<tr><td height=\"5\"></td></tr>";
		
	echo "</table>";
}

function net_client_banners()
{
	$type = ( isset($_GET['type']) ) ? $_GET['type'] : $_POST['type'];
	
	if( $type == "" )
		die('לא מוגדר פרמטר מיקום - יש ללחוץ על הקישור בתפריט');
	
	$sql = "SELECT * FROM net_clients_banners WHERE type='".$type."' AND deleted=0";
	$res = mysql_db_query(DB, $sql);
	
	$status_str = array("0"=>"לא פעיל","1"=>"פעיל");
	
	echo "<table border=\"0\" cellspacing=\"0\" cellpadding=\"3\" class=\"maintext\">";
		
		echo "<tr>
			<td colspan=\"11\"><A href=\"?&sesid=".SESID."\" class=\"maintext\">חזרה לתפריט הראשי</a></td>
		</tr>";
		echo "<tr><td colspan=\"11\" height=\"7\"></td></tr>";
		echo "<tr>
			<td colspan=\"11\"><A href=\"?main=net_menu&sesid=".SESID."\" class=\"maintext\">חזרה לתפריט הרשת</a></td>
		</tr>";
		echo "<tr><td colspan=\"11\" height=\"7\"></td></tr>";
		echo "<tr>
			<td colspan=\"11\"><A href=\"?main=net_client_banners_edit&type=".$type."&sesid=".SESID."\" class=\"maintext\">יצירת באנר חדש</a></td>
		</tr>";
		
		echo "<tr><td colspan=\"11\" height=\"11\"></td></tr>";
		echo "<tr>";
			echo "<td><strong>תאריך הכנסה</strong></td>";
			echo "<td width=\"15\"></td>";
			echo "<td><strong>שם הבאנר</strong></td>";
			echo "<td width=\"15\"></td>";
			echo "<td><strong>תיאור הבאנר</strong></td>";
			echo "<td width=\"15\"></td>";
			echo "<td><strong>צפיות</strong></td>";
			echo "<td width=\"15\"></td>";
			echo "<td><strong>הקלקות</strong></td>";
			echo "<td width=\"15\"></td>";
			echo "<td><strong>הקלקות באחוזים</strong></td>";
			echo "<td width=\"15\"></td>";			
			echo "<td><strong>המרות</strong></td>";
			echo "<td width=\"15\"></td>";	
			echo "<td><strong>המרות באחוזים</strong></td>";
			echo "<td width=\"15\"></td>";	
			echo "<td><strong>סטטוס</strong></td>";
			echo "<td width=\"15\"></td>";				
			echo "<td><strong>עריכה</strong></td>";
			echo "<td width=\"15\"></td>";
			echo "<td><strong>מחיקה</strong></td>";
		echo "</tr>";
		
		
		while( $data = mysql_fetch_array($res) )	
		{
			echo "<tr><Td colspan=\"11\" height=\"5\" height=\"5\"></TD></tr>";
			echo "<tr><Td colspan=\"11\" height=\"5\"></TD></tr>";
			echo "<tr>";
				echo "<td>".GlobalFunctions::show_dateTime_field($data['date_in'])."</td>";
				echo "<td width=\"15\"></td>";
				echo "<td>".stripslashes($data['banner_name'])."</td>";
				echo "<td width=\"15\"></td>";
				echo "<td>".stripslashes($data['banner_desc'])."</td>";
				echo "<td width=\"15\"></td>";
				echo "<td>".stripslashes($data['views'])."</td>";
				echo "<td width=\"15\"></td>";
				echo "<td>".stripslashes($data['clicks'])."</td>";
				echo "<td width=\"15\"></td>";
				echo "<td>".stripslashes(sprintf('%0.2f', $data['clicks']*100/$data['views']))."</td>";
				echo "<td width=\"15\"></td>";				
				echo "<td>".stripslashes($data['convertions'])."</td>";
				echo "<td width=\"15\"></td>";	
				echo "<td>".stripslashes(sprintf('%0.2f', $data['convertions']*100/$data['clicks']))."</td>";
				echo "<td width=\"15\"></td>";	
				echo "<td>".$status_str[$data['status']]."</td>";
				echo "<td width=\"15\"></td>";					
				echo "<td><a href=\"?main=net_client_banners_edit&type=".$type."&record_id=".$data['id']."&sesid=".SESID."\" class=\"maintext\">עריכה</a></td>";
				echo "<td width=\"15\"></td>";
				echo "<td><a href=\"?main=net_client_banners_DEL&type=".$type."&record_id=".$data['id']."&sesid=".SESID."\" class=\"maintext\" onclick=\"return can_i_del();\"><strong style=\"color:red;\">מחיקה</strong></a></td>";
			echo "</tr>";
			echo "<tr><Td colspan=\"11\" height=\"5\"></TD></tr>";
		}
		
	echo "</table>";
}


function net_client_banners_edit()
{

	$type = ( isset($_GET['type']) ) ? $_GET['type'] : $_POST['type'];
	
	if( $type == "" )
		die('לא מוגדר פרמטר מיקום - יש ללחוץ על הקישור בתפריט');
	
	
	if($_GET['record_id'] != "" )	{
		$sql = "select * from net_clients_banners where deleted = '0' and id = '".$_GET['record_id']."' AND type='".$type."'";
		$res = mysql_db_query(DB,$sql);
		$data = mysql_fetch_array($res);
	}
	if($data['position'] == ""){
		$data['position'] = "0";
	}
	if(isset($_REQUEST['update_banner_cats'])){
		$sql = "DELETE FROM net_clients_banner_cat WHERE banner_id = '".$data['id']."' ";
		$res = mysql_db_query(DB,$sql);
		foreach($_REQUEST['select_cat'] as $cat_id=>$mark){
			$sql = "INSERT INTO net_clients_banner_cat (banner_id,cat_id) VALUES('".$data['id']."',$cat_id)";
			$res = mysql_db_query(DB,$sql);
			
		}
	}	
	$status[1] = "פעיל";
	$status[0] = "לא פעיל";
	
	$abpath_temp = SERVER_PATH_NET_BANNERS."/".$data['file_name'];
	if( file_exists($abpath_temp) && !is_dir($abpath_temp) )
	{
		$view_ban = "<br><A href='".HTTP_PATH_NET_BANNERS."/".$data['file_name']."' class='maintext' target='_blank'><span style=font-size:11px;>צפה בבאנר</span></a>";
		$delete_ban = "<br><A href='?main=net_client_banners_DEL_FTP&file=file_name&type=".$type."&record_id=".$data['id']."&sesid=".SESID."' class='maintext' onclick=\"return can_i_del();\"><span style=font-size:11px;>מחק בבאנר</span></a>";
	}
	$abpath_temp = SERVER_PATH_NET_BANNERS."/".$data['video_name'];
	if( file_exists($abpath_temp) && !is_dir($abpath_temp) )
	{
		$view_vid = "<br><A href='".HTTP_PATH_NET_BANNERS."/".$data['video_name']."' class='maintext' target='_blank'><span style=font-size:11px;>צפה בקובץ הוידאו</span></a>";
		$delete_vid = "<br><A href='?main=net_client_banners_DEL_FTP&file=video_name&type=".$type."&record_id=".$data['id']."&sesid=".SESID."' class='maintext' onclick=\"return can_i_del();\"><span style=font-size:11px;>מחק קובץ וידאו</span></a>";
	}	
	$abpath_temp = SERVER_PATH_NET_BANNERS."/".$data['webm_file_name'];
	if( file_exists($abpath_temp) && !is_dir($abpath_temp) )
	{
		$view_webm_vid = "<br><A href='".HTTP_PATH_NET_BANNERS."/".$data['webm_file_name']."' class='maintext' target='_blank'><span style=font-size:11px;>צפה בקובץ הוידאו</span></a>";
		$delete_webm_vid = "<br><A href='?main=net_client_banners_DEL_FTP&file=webm_file_name&type=".$type."&record_id=".$data['id']."&sesid=".SESID."' class='maintext' onclick=\"return can_i_del();\"><span style=font-size:11px;>מחק קובץ וידאו</span></a>";
	}		
	$form_arr = array(
		array("hidden","main","net_client_banners_edit_DB"),
		array("hidden","record_id",$data['id']),
		array("hidden","sesid",SESID),
		array("hidden","data_arr[type]",$type),
		array("hidden","type",$type),
		
		
		array("text","data_arr[banner_name]",$data['banner_name'],"* שם הבאנר", "class='input_style'"),
		array("text","data_arr[position]",$data['position'],"עדיפות", "class='input_style'"),
		array("textarea","data_arr[banner_desc]",$data['banner_desc'],"* תיאור הבאנר (מה הוא מציג, למי הוא פונה)", "class='input_style' style='height: 150px;'"),
		array("textarea","data_arr[banner_free_html]",$data['banner_free_html'],"טקסט חופשי(להוספת אמבד וידאו ועוד)", "class='input_style' style='height: 150px;'"),
		
		array("text","data_arr[goto_href]",$data['goto_href'],"* לאיזה קישור הבאנר מפנה", "class='input_style'"),
		
		array("file","file_name","","קובץ הבאנר".$view_ban.$delete_ban."", "class='input_style'"),
		array("file","video_name","","קובץ וידאו".$view_vid.$delete_vid."", "class='input_style'"),		
		array("file","webm_file_name","","העלה שוב קובץ וידאו בשביל אייפון".$view_webm_vid.$delete_webm_vid."", "class='input_style'"),		
		
		
		
		
		array("text","data_arr[max_views]",$data['max_views'],"מקסימום צפיות לתצוגה(השאר 0 ללא הגבלה)", "class='input_style'",),
		
		array("text","data_arr[views]",$data['views'],"צפיות", "class='input_style' readonly",),
		array("text","data_arr[clicks]",$data['clicks'],"קליקים", "class='input_style' readonly"),
		array("text","data_arr[convertions]",$data['convertions'],"המרות", "class='input_style' readonly"),
		
		
		array("select","status[]",$status,"סטטוס",$data['status'],"data_arr[status]", "class='input_style''"),
		
		array("submit","submit","שמירה", "class='submit_style'")
	);
	
// שדות חובה
$mandatory_fields = array("data_arr[banner_name]","data_arr[banner_desc]","data_arr[goto_href]");
$more = "class='maintext'";
		echo "
			<div><A href=\"?&sesid=".SESID."\" >חזרה לתפריט הראשי</a></div>
		";
		
		echo "
			<div><A href=\"?main=net_menu&sesid=".SESID."\" >חזרה לתפריט הרשת</a></div>
		";
	
		echo "
			<div><A href=\"?main=net_client_banners&type=".$type."&sesid=".SESID."\" >חזרה לרשימת הבאנרים</a></div>
		";
		
		
echo "<div style='float:right; padding:10px; background:#ffffc8;margin-left:10px;border:1px solid silver;'><h3>עריכת הבאנר</h3><table border=\"0\" cellspacing=\"0\" cellpadding=\"0\" class=\"maintext\">";
		

		
		echo "<tr>";
			echo "<td>".FormCreator::create_form($form_arr,"index.php", $more, $mandatory_fields)."</td>";
		echo "</tr>";
		
		
	echo "</table>";
	echo "</div>";
	echo "<script src=\"options.fiels/htmldb_html_elements.js\" type=\"text/javascript\"></script>";
	echo "<div style='float:right; padding:10px; background:#ffffc8;border:1px solid silver;'><h3>שיוך קטגוריות</h3>";
		$sql = "select cat_name,id from biz_categories where father = 0 and status = 1";
		$res_father = mysql_db_query(DB,$sql);
		echo "<form action='' method='POST'>";
			echo "<input type='hidden' name='update_banner_cats' value='1' />";	
			$cat_list = "<table border=\"0\" cellpadding=\"0\" cellspacing=\"0\" width=\"100%\">";
				$cat_list .= "<tr>";
					$cat_list .= "<td style=\"background-color:#cccccc;\">";
						
						$cat_list .= "<ul style=\"list-style:none\" class=\"dhtmlTree\">";
								$sql = "select cat_id from net_clients_banner_cat where banner_id = '".$data['id']."' and cat_id = '0'";
								$res_cat_id = mysql_db_query(DB,$sql);
								$data_cat_id = mysql_fetch_array($res_cat_id);
								
								if( $data_cat_id['cat_id'] == '0' )	{
									$selected1 = "checked";
								}	else	{
									$selected1 = "";
								}
								$cat_list .= "<li>
								קטגוריה ראשית
								<input type=\"checkbox\" name=\"select_cat[0]\" value=\"1\" ".$selected1.">
								</li>";							
							while( $data_father = mysql_fetch_array($res_father) )
							{
								
								$sql = "select cat_id from net_clients_banner_cat where banner_id = '".$data['id']."' and cat_id = '".$data_father['id']."'";
								$res_cat_id = mysql_db_query(DB,$sql);
								$data_cat_id = mysql_fetch_array($res_cat_id);
								
								if( $data_cat_id['cat_id'] == $data_father['id'] )	{
									$selected1 = "checked";
								}	else	{
									$selected1 = "";
								}
								
								$cat_list .= "<li><img src=\"options.fiels/plus.jpg\" onclick=\"htmldb_ToggleWithImage(this,'treeCAT".$data_father['id']."')\" class=\"pseudoButtonInactive\" />
								".stripslashes($data_father['cat_name'])."
								<input type=\"checkbox\" name=\"select_cat[".$data_father['id']."]\" value=\"1\" ".$selected1.">
								</li>";
								
								$sql = "select cat_name,id from biz_categories where father = ".$data_father['id']." and status = 1";
								$res_father_cat = mysql_db_query(DB,$sql);
								
								$cat_list .= "<ul id=\"treeCAT".$data_father['id']."\" htmldb:listlevel=\"2\" style=\"padding-right:15px;list-style:none;display:none;\" class=\"dhtmlTree\">";
									while( $data_father_cat = mysql_fetch_array($res_father_cat) )
									{
										$sql = "select cat_id from net_clients_banner_cat where banner_id = '".$data['id']."' and cat_id = '".$data_father_cat['id']."'";
										$res_cat_id = mysql_db_query(DB,$sql);
										$data_cat_id = mysql_fetch_array($res_cat_id);
										
										if( $data_cat_id['cat_id'] == $data_father_cat['id'] )	{
											$selected2 = "checked";
										}	else	{
											$selected2 = "";
										}
								
										$sql = "select cat_name,id from biz_categories where father = '".$data_father_cat['id']."' and status = '1'";
										$res_father_tat_cat = mysql_db_query(DB,$sql);
										$num_father_tat_cat = mysql_num_rows($res_father_tat_cat);
										
										if( $num_father_tat_cat > 0 )
										{
											$cat_list .= "<li>
											<img src=\"options.fiels/plus.jpg\" onclick=\"htmldb_ToggleWithImage(this,'treeF_CAT".$data_father_cat['id']."')\" class=\"pseudoButtonInactive\" />
											".$data_father_cat['cat_name']."
											<input type=\"checkbox\" name=\"select_cat[".$data_father_cat['id']."]\" value=\"1\" ".$selected2."></li>";
											
											$cat_list .= "<ul id=\"treeF_CAT".$data_father_cat['id']."\" htmldb:listlevel=\"3\" style=\"padding-right:15px;list-style:none;display:none;\" class=\"dhtmlTree\">";
											
											while( $data_father_tat_cat = mysql_fetch_array($res_father_tat_cat) )
											{
												$sql = "select cat_id from net_clients_banner_cat where banner_id = '".$data['id']."' and cat_id = '".$data_father_tat_cat['id']."'";
												$res_cat_id = mysql_db_query(DB,$sql);
												$data_cat_id = mysql_fetch_array($res_cat_id);
												
												if( $data_cat_id['cat_id'] == $data_father_tat_cat['id'] )	{
													$selected3 = "checked";
												}	else	{
													$selected3 = "";
												}
												
												$cat_list .= "<li><img src=\"options.fiels/node.jpg\" /><input type=\"checkbox\" name=\"select_cat[".$data_father_tat_cat['id']."]\" value=\"1\" ".$selected3.">".$data_father_tat_cat['cat_name']."</li>";
											}
											$cat_list .= "</ul>";
										}
										else
										{
											$cat_list .= "<li><img src=\"options.fiels/node.jpg\" />
											<input type=\"checkbox\" name=\"select_cat[".$data_father_cat['id']."]\" value=\"1\" ".$selected2.">".$data_father_cat['cat_name']."</li>";
										}
									}
								$cat_list .= "</ul>";
							}
						$cat_list .= "</ul>";
					$cat_list .= "</td>";
				$cat_list .= "</tr>";
			$cat_list .= "</table>";
			echo $cat_list;
			echo "<input type='submit' value='עדכן שיוך קטגוריות לבאנר' />";
		echo "</form>";
	echo "</div>";
}


function net_client_banners_edit_DB()
{
	
	$type = ( isset($_GET['type']) ) ? $_GET['type'] : $_POST['type'];
	
	if( $type == "" )
		die('לא מוגדר פרמטר מיקום - יש ללחוץ על הקישור בתפריט');
	
	
	$image_settings = array(
		after_success_goto=>"DO_NOTHING",
		table_name=>"net_clients_banners",
	);
	  
	$data_arr = ($_POST['data_arr'])? $_POST['data_arr'] : $_GET['data_arr'];
	if( $_POST['record_id'] == "" )
	{
		insert_to_db($data_arr, $image_settings);
		
		$sql = "update net_clients_banners set date_in = NOW() where id = '".$GLOBALS['mysql_insert_id']."' limit 1";
		$res = mysql_db_query(DB,$sql);
	}
	else
		update_db($data_arr, $image_settings);
	
	
	$res_id = ( $_POST['record_id'] == "" ) ? $GLOBALS['mysql_insert_id'] : $_POST['record_id'];
	
	$field_name = array("file_name","video_name","webm_file_name");
	
	//check if files being uploaded
	if($_FILES)
	{
		for($temp=0 ; $temp<sizeof($field_name) ; $temp++)
		{
			$temp_name = $field_name[$temp];
				
			if ( $_FILES[$temp_name]['name'] != "" )
			{
				$exte = substr($_FILES[$temp_name]['name'],(strpos($_FILES[$temp_name]['name'],".")+1));
				$file_types =  array("image","shockwave-flash","octet-stream");
				switch($temp_name)
				{
					case "file_name" :				
						$file_temp_name__1 = "ban_".$type;	
					break;
					case "video_name" :							
						$file_temp_name__1 = "ban_vid".$type;	
						$file_types =  array("video/mp4");
					break;
					case "webm_file_name" :						
						$file_temp_name__1 = "ban_vid".$type;	
						$file_types =  array("video/mp4");
						$exte = str_replace("mp4","webm",$exte);
					break;
				}
				
				$logo_name2 = $res_id."_".$file_temp_name__1.".".$exte;
				$tempname = $logo_name;
				
				
				$file_type = $_FILES[$temp_name]['type'];
				
				GlobalFunctions::upload_file_to_server($temp_name , $logo_name2 , SERVER_PATH_NET_BANNERS , array("image","shockwave-flash","octet-stream","video/mp4") , "" , "2");
				
				$sql = "UPDATE net_clients_banners SET ".$temp_name." = '".$logo_name2."' WHERE id = '".$res_id."' limit 1";
				$res = mysql_db_query(DB,$sql);
				
			}
		}
	}
	
	
	echo "<META HTTP-EQUIV=Refresh CONTENT=\"0; URL=?main=net_client_banners&type=".$type."&sesid=".SESID."\">";
	
}


function net_client_banners_DEL()
{
	$type = ( isset($_GET['type']) ) ? $_GET['type'] : $_POST['type'];
	
	if( $type == "" )
		die('לא מוגדר פרמטר מיקום - יש ללחוץ על הקישור בתפריט');
	
	
	$sql = "SELECT file_name FROM net_clients_banners WHERE id = '".$_GET['record_id']."' limit 1";
	$res = mysql_db_query(DB,$sql);
	$data = mysql_fetch_array($res);
	
	$abpath_temp = SERVER_PATH_NET_BANNERS."/".$data['file_name'];
		if( file_exists($abpath_temp) && !is_dir($abpath_temp) )
		{
			
			$new_path =  explode( "/home/ilan123" , SERVER_PATH_NET_BANNERS );
			$new_path = $new_path[1];
			
			$funcs = new GlobalFunctions;
			
			$conn_id = $funcs->chmod_openC();
			echo $funcs->chmod_fileC($conn_id, 777, $new_path ) ? '' : 'Error #12445875';
			$funcs->chmod_closeC($conn_id);
			
			unlink($abpath_temp);
			
			$conn_id = $funcs->chmod_openC();
			echo $funcs->chmod_fileC($conn_id, 755, $new_path ) ? '' : 'Error #12445875';
			$funcs->chmod_closeC($conn_id);
		}
	
	$sql = "UPDATE net_clients_banners SET deleted = '1' WHERE id = '".$_GET['record_id']."' limit 1";
	$res = mysql_db_query(DB,$sql);
	
	echo "<META HTTP-EQUIV=Refresh CONTENT=\"0; URL=?main=net_client_banners&type=".$type."&sesid=".SESID."\">";
}



function net_client_banners_DEL_FTP()
{
	$type = ( isset($_GET['type']) ) ? $_GET['type'] : $_POST['type'];
	
	if( $type == "" )
		die('לא מוגדר פרמטר מיקום - יש ללחוץ על הקישור בתפריט');
	
	$file = ( isset($_GET['file']) ) ? $_GET['file'] : $_POST['file'];
	if( $file == "" )
		die('לא מוגדר קובץ למחיקה - יש ללחוץ על הקישור בתפריט');
		
	$sql = "SELECT $file FROM net_clients_banners WHERE id = '".$_GET['record_id']."' limit 1";
	$res = mysql_db_query(DB,$sql);
	$data = mysql_fetch_array($res);
		
	$abpath_temp = SERVER_PATH_NET_BANNERS."/".$data[$file];
		if( file_exists($abpath_temp) && !is_dir($abpath_temp) )
		{
			$new_path =  explode( "/home/ilan123" , SERVER_PATH_NET_BANNERS );
			$new_path = $new_path[1];
			
			$funcs = new GlobalFunctions;
			
			$conn_id = $funcs->chmod_openC();
			echo $funcs->chmod_fileC($conn_id, 777, $new_path ) ? '' : 'Error #12445875';
			$funcs->chmod_closeC($conn_id);
			
			unlink($abpath_temp);
			
			$conn_id = $funcs->chmod_openC();
			echo $funcs->chmod_fileC($conn_id, 755, $new_path ) ? '' : 'Error #12445875';
			$funcs->chmod_closeC($conn_id);
		}
	
	
	$sql = "UPDATE net_clients_banners SET $file = '' WHERE id = '".$_GET['record_id']."' limit 1";
	$res = mysql_db_query(DB,$sql);
	
	echo "<META HTTP-EQUIV=Refresh CONTENT=\"0; URL=?main=net_client_banners&type=".$type."&sesid=".SESID."\">";
}


function net_add_site_banners()
{
	echo "<table border=\"0\" cellspacing=\"0\" cellpadding=\"3\" class=\"maintext\">";
	
	
		echo "<tr>
			<td><A href=\"?&sesid=".SESID."\" class=\"maintext\">חזרה לתפריט הראשי</a></td>
		</tr>";
		echo "<tr><td height=\"11\"></td></tr>";
		echo "<tr>
			<td><A href=\"?main=net_menu&sesid=".SESID."\" class=\"maintext\">חזרה לתפריט הרשת</a></td>
		</tr>";
		echo "<tr><td height=\"5\"></td></tr>";
		
		echo "<tr>";
			echo "<td></td>";
		echo "</tr>";
		
		echo "<tr>";
			echo "<td>
אהלן!<br>
במערכת זו תוכל לשייך לכל אתר באנר... זה הולך ככה:<br>
תחילה בוחרים איזה באנר אתה רוצה 1) הרשמה לרשת 2) באנרים פרסומיים<br>
לאחר מכן תקבל את הרשימה של הבאנרים שיש לך מהמחסן... תבחר באנר<br>
לאחר מכן תקבל רשימה של אתרים שמסומן להם בהגדרות \"רשת אילביז\"<br>
יש לך אפשרות להוסיף לכל אתר כמה באנרים שתרצה, וכמובן למחוק באנר.<br>
יש לך ברשימה צבע רקע שזה אומר - לאתר הזה יש כבר באנר שבחרת ובלי צבע... אין לו.<br>
יש לך אפשרות לסנן אתרים לפי דומיין ושם<br>
			</td>";
		echo "</tr>";
		
		echo "<tr>";
			echo "<td>";
				echo "<form action='javascript:from_form(\"".SESID."\" , \"net_banners\" )' method='get' name='sinon_by_banner_form'>";
					echo "<select name='storge_type' class='input_style' onchange='sinon_by_banner_form.submit()'>
						<option value=''>בחירה</option>
						<option value='1'>מחסן באנרים - הצטרפות לרשת </option>
						<option value='2'>מחסן באנרים - פרסום</option>
						<option value='3'>מחסן באנרים - מועדון, דואר נכנס/ארכיון</option>
					</select>";
				echo "</form>";
			echo "</td>";
		echo "</tr>";
		
		echo "<tr>";
			echo "<td><div id='containerDiv'></div></td>";
		echo "</tr>";
	
	
	echo "</table>";
}

function net_add_site_banners_DB()
{
	
		foreach( $_POST['cs'] as $key => $user_unk )
		{
			$sql = "INSERT INTO net_client_belong_banners SET ";
			$sql .= "banner_id = '" . $_POST['bannaer_id'] . "' , unk = '".$user_unk."';"; 
			$res = mysql_db_query(DB, $sql);
		}
	
	
	echo "<script>alert('בוצע');</script>";
	echo "<META HTTP-EQUIV=Refresh CONTENT=\"0; URL=?main=net_menu&sesid=".SESID."\">";
}

function net_DELL_site_banners_DB()
{
	
		foreach( $_POST['cs'] as $key => $user_unk )
		{
			$sql = "DELETE FROM net_client_belong_banners WHERE ";
			$sql .= "banner_id = '" . $_POST['bannaer_id'] . "' , unk = '".$user_unk."';"; 
			//$res = mysql_db_query(DB, $sql);
			echo $sql."<br>";
		}
	
	
	echo "<script>alert('בוצע');</script>";
	//echo "<META HTTP-EQUIV=Refresh CONTENT=\"0; URL=?main=net_menu&sesid=".SESID."\">";
}


function users_dynamic_net_form()
{
	
	$sql = "SELECT * FROM  dynamic_client_form WHERE unk='".$_GET['unk']."' ORDER BY place";
	$res = mysql_db_query(DB, $sql);
	
	echo "<table border=\"0\" cellspacing=\"0\" cellpadding=\"3\" class=\"maintext\">";
		
		echo "<tr>
			<td colspan=\"11\"><A href=\"?&sesid=".SESID."\" class=\"maintext\">חזרה לתפריט הראשי</a></td>
		</tr>";
		echo "<tr><td colspan=\"11\" height=\"7\"></td></tr>";
		echo "<tr>
			<td colspan=\"11\"><A href=\"?main=users_list&sesid=".SESID."\" class=\"maintext\">חזרה לרשימת האתרים</a></td>
		</tr>";
		
		
		echo "<tr><td colspan=\"11\" height=\"15\"></td></tr>";
		echo "<tr>
			<td colspan=\"11\"><A href=\"?main=net_dynamic_form_edit&unk=".$_GET['unk']."&sesid=".SESID."\" class=\"maintext\"><b>הוסף שדה חדש לטופס</b></a></td>
		</tr>";
		
		echo "<tr><td colspan=\"11\" height=\"11\"></td></tr>";
		echo "<tr>";
			echo "<td><strong>שם השדה</strong></td>";
			echo "<td width=\"15\"></td>";
			echo "<td><strong>סוג השדה</strong></td>";
			echo "<td width=\"15\"></td>";
			echo "<td><strong>דוגמה איך זה באתר</strong></td>";
			echo "<td width=\"15\"></td>";
			echo "<td><strong>עריכת ערכים</strong></td>";
			echo "<td width=\"15\"></td>";
			echo "<td><strong>עריכה</strong></td>";
			//echo "<td width=\"15\"></td>";
			//echo "<td><strong>מחיקה</strong></td>";
		echo "</tr>";
		
		
		while( $data = mysql_fetch_array($res) )	
		{
			switch($data['inputType'])
			{
				case "1" :			$inputType = "שדה חופשי (עם הגבלת טקסט)";		break;
				case "2" :			$inputType = "שדה בחירה (ברשימה נפתחת בחירה 1)";			break;
				//case "3" :			$inputType = "שדה בחירה (בסימון V מרובה)";			break;
				case "4" :			$inputType = "שדה בחירה (בסימון עיגול בחירה 1)";			break;
				case "5" :			$inputType = "שדה טקסט (ללא הגבלה)";			break;
			}
			
			echo "<tr><Td colspan=\"11\" height=\"5\" height=\"5\"></TD></tr>";
			echo "<tr><Td colspan=\"11\" height=\"5\"></TD></tr>";
			echo "<tr>";
				echo "<td valign=top>".stripslashes($data['fieldName'])."</td>";
				echo "<td width=\"15\"></td>";
				echo "<td valign=top>".$inputType."</td>";
				echo "<td width=\"15\"></td>";
				echo "<td valign=top>";
				$params = array();
				
					$params['inputType'] = $data['inputType'];
    			$params['class'] = "input_style";
    			$params['name'] = "ex_".$data['id'];
    	
    			$params['unk'] = $_GET['unk'];
    			$params['dynamicId'] = $data['id'];
    	
    			$params['maxlenght'] = $data['maxlenght'];
    			$params['style'] = "width: 140px;";
    			$params['style_textarea'] = "width: 140px; height: 100px;";
    			$params['value'] = stripslashes($data['defaultText']);
    			
    			echo ilbizNet::siteInputType($params);
    			
				echo "</td>";
				echo "<td width=\"15\"></td>";
				echo "<td valign=top>";
					if( $data['inputType'] == "2" || $data['inputType'] == "4" )
					echo "<a href=\"?main=net_dynamic_form_options_edit&rowID=".$data['id']."&unk=".$_GET['unk']."&sesid=".SESID."\" class=\"maintext\">עריכת ערכים</a>";
				echo "</td>";
				echo "<td width=\"15\"></td>";
				echo "<td valign=top><a href=\"?main=net_dynamic_form_edit&rowID=".$data['id']."&unk=".$_GET['unk']."&sesid=".SESID."\" class=\"maintext\">עריכה</a></td>";
				//echo "<td width=\"15\"></td>";
				//echo "<td valign=top><a href=\"?main=net_dynamic_form_DELL&type=".$type."&record_id=".$data['id']."&sesid=".SESID."\" class=\"maintext\" onclick=\"return can_i_del();\"><strong style=\"color:red;\">מחיקה</strong></a></td>";
			echo "</tr>";
			echo "<tr><Td colspan=\"11\" height=\"5\"></TD></tr>";
		}
		
	echo "</table>";
}


function net_dynamic_form_edit()
{
	if( $_GET['rowID'] != "" )
	{
		$sql = "SELECT * FROM dynamic_client_form WHERE unk = '".$_GET['unk']."' AND id = '".$_GET['rowID']."' ";
		$res = mysql_db_query( DB , $sql );
		$data = mysql_fetch_array($res);
	}
	
	
	echo "<table border=\"0\" cellspacing=\"0\" cellpadding=\"3\" class=\"maintext\">";
	echo "<form action=? name='net_dynamic_form_editFORM' method=POST>";
	echo "<input type='hidden' name='main' value='net_dynamic_form_edit_DB'>";
	echo "<input type='hidden' name='unk' value='".$_GET['unk']."'>";
	echo "<input type='hidden' name='sesid' value='".SESID."'>";
	echo "<input type='hidden' name='rowID' value='".$_GET['rowID']."'>";
	
		echo "<tr><td colspan=\"11\" height=\"7\"></td></tr>";
		echo "<tr>
			<td colspan=\"11\"><A href=\"?main=users_list&sesid=".SESID."\" class=\"maintext\">חזרה לרשימת האתרים</a></td>
		</tr>";
		echo "<tr><td colspan=\"11\" height=\"7\"></td></tr>";
		echo "<tr>
			<td colspan=\"11\"><A href=\"?main=users_dynamic_net_form&unk=".$_GET['unk']."&sesid=".SESID."\" class=\"maintext\">חזרה לרשימת השדות</a></td>
		</tr>";
		
		echo "<tr><td colspan=\"11\" height=\"11\"></td></tr>";
		
		echo "<tr>";
			echo "<td>שם השדה</td>";
			echo "<td width=10></td>";
			echo "<td><input type='text' name='fieldName' value='".stripslashes($data['fieldName'])."' class='input_style' style='width: 200px;'></td>";
		echo "</tr>";
		
		echo "<tr><td colspan=\"11\" height=\"7\"></td></tr>";
		
		echo "<tr>";
			echo "<td>סוג השדה</td>";
			echo "<td width=10></td>";
			echo "<td>";
				$selected1 = ( $data['inputType'] == "1" ) ? "selected" : "";
				$selected2 = ( $data['inputType'] == "2" ) ? "selected" : "";
				$selected4 = ( $data['inputType'] == "4" ) ? "selected" : "";
				$selected5 = ( $data['inputType'] == "5" ) ? "selected" : "";
				
				echo "<select name='inputType' class='input_style' style='width: 200px;'>
					<option value=''>בחירה</option>
					<option value='1' ".$selected1.">טקסט, מוגבל</option>
					<option value='2' ".$selected2.">שדה בחירה select</option>
					<option value='4' ".$selected4.">שדה בחירה radio</option>
					<option value='5' ".$selected5.">טקסט מורחב</option>
				</select>
			</td>";
		echo "</tr>";
		
		echo "<tr><td colspan=\"11\" height=\"7\"></td></tr>";
		
		echo "<tr>";
			echo "<td>מיקום בטופס</td>";
			echo "<td width=10></td>";
			echo "<td><input type='text' name='place' value='".stripslashes($data['place'])."' class='input_style' style='width: 200px;'></td>";
		echo "</tr>";
		
		echo "<tr><td colspan=\"11\" height=\"7\"></td></tr>";
		
		echo "<tr>";
			echo "<td>פעיל?</td>";
			echo "<td width=10></td>";
			echo "<td>";
				$selected1 = ( $data['active'] == "0" ) ? "selected" : "";
				$selected2 = ( $data['active'] == "1" ) ? "selected" : "";
				
				echo "<select name='active' class='input_style' style='width: 200px;'>
					<option value=''>בחירה</option>
					<option value='0' ".$selected1.">פעיל</option>
					<option value='1' ".$selected2.">לא פעיל</option>
				</select>
			</td>";
		echo "</tr>";
		
		echo "<tr><td colspan=\"11\" height=\"7\"></td></tr>";
		
		echo "<tr>";
			echo "<td>שדה למערכת ניהול בלבד?</td>";
			echo "<td width=10></td>";
			echo "<td>";
				$selected1 = ( $data['adminField'] == "0" ) ? "selected" : "";
				$selected2 = ( $data['adminField'] == "1" ) ? "selected" : "";
				
				echo "<select name='adminField' class='input_style' style='width: 200px;'>
					<option value=''>בחירה</option>
					<option value='0' ".$selected1.">לא</option>
					<option value='1' ".$selected2.">כן, יראו את השדה רק במערכת ניהול</option>
				</select>
			</td>";
		echo "</tr>";
		
		/*if( $_GET['rowID'] != "" )
		{
		echo "<tr>";
			echo "<td>טקסט ברירת מחדל</td>";
			echo "<td width=10></td>";
			echo "<td><input type='text' name='data_arr[fieldName]' value='".stripslashes($data['fieldName'])."' class='input_style' style='width: 200px;'></td>";
		echo "</tr>";
		}
		else
		{
			echo "<tr><td colspan=3>ניתן לעריכה רק לאחר הוספת השדה</td></tr>";
		}*/
		echo "<tr><td colspan=\"11\" height=\"7\"></td></tr>";
		
	
		echo "<tr>";
			echo "<td></td>";
			echo "<td width=10></td>";
			echo "<td><input type='submit' value='שמירה' class='submit_style'></td>";
		echo "</tr>";
	
	echo "</form>";
	echo "</table>";
	
	
}

function net_dynamic_form_edit_DB()
{
	
	if( $_POST['rowID'] == "" )
	{
		$sql = "INSERT INTO dynamic_client_form ( unk, fieldName, inputType, place, active , adminField ) VALUES (
			'".$_POST['unk']."' , '".addslashes($_POST['fieldName'])."' , '".$_POST['inputType']."' , '".$_POST['place']."' , '".$_POST['active']."' , '".$_POST['adminField']."' )";
		$res = mysql_db_query(DB,$sql);
	}
	else
	{
		$sql = "UPDATE dynamic_client_form SET 
			fieldName = '".addslashes($_POST['fieldName'])."' , 
			inputType = '".$_POST['inputType']."' , 
			place = '".$_POST['place']."' ,
			active = '".$_POST['active']."' ,
			adminField = '".$_POST['adminField']."' WHERE id = '".$_POST['rowID']."' AND unk = '".$_POST['unk']."'";
		$res = mysql_db_query(DB,$sql);
	}
	
	echo "<script>window.location.href='index.php?main=users_dynamic_net_form&unk=".$_POST['unk']."&sesid=".SESID."';</script>";
		exit;
}

function net_dynamic_form_DELL()
{
	
}


function net_dynamic_form_options_edit()
{
	$sql = "SELECT clientTextValue, id, place FROM dynamic_client_form_values WHERE unk = '".$_GET['unk']."' AND dynamicId = '".$_GET['rowID']."' ORDER BY place ";
	$res = mysql_db_query(DB,$sql);
	
	
	echo "<table border=\"0\" cellspacing=\"0\" cellpadding=\"3\" class=\"maintext\">";
	
		echo "<tr><td colspan=\"7\" height=\"7\"></td></tr>";
		echo "<tr>
			<td colspan=\"7\"><A href=\"?main=users_list&sesid=".SESID."\" class=\"maintext\">חזרה לרשימת האתרים</a></td>
		</tr>";
		echo "<tr><td colspan=\"7\" height=\"7\"></td></tr>";
		echo "<tr>
			<td colspan=\"7\"><A href=\"?main=users_dynamic_net_form&unk=".$_GET['unk']."&sesid=".SESID."\" class=\"maintext\">חזרה לרשימת השדות</a></td>
		</tr>";
		
		echo "<tr><td colspan=\"7\" height=\"11\"></td></tr>";
			
		echo "<tr>";
			echo "<td colspan=7><b>הוספת אופציה חדשה</b></td>";
		echo "</tr>";
		
		echo "<tr><td colspan=\"7\" height=\"7\"></td></tr>";
		
		echo "<form action=? name='net_dynamic_form_options_editFORM' method=GET>";
			echo "<input type='hidden' name='main' value='net_dynamic_form_options_edit_DB'>";
			echo "<input type='hidden' name='unk' value='".$_GET['unk']."'>";
			echo "<input type='hidden' name='sesid' value='".SESID."'>";
			echo "<input type='hidden' name='rowID' value='".$_GET['rowID']."'>";
			
			echo "<tr>";
				echo "<td><input type='text' name='clientTextValue' value='' class='input_style'></td>";
				echo "<td width='10'></td>";
				echo "<td><input type='text' name='place' value='' class='input_style' style='width: 35px;'></td>";
				echo "<td width='10'></td>";
				echo "<td><input type='submit' value='הוסף' class='submit_style'></td>";
				echo "<td width='10'></td>";
				echo "<td></td>";
			echo "</tr>";
			
			echo "</form>";
		
		echo "<tr><td colspan=\"7\" height=\"7\"></td></tr>";
			
		echo "<tr>";
			echo "<td><b>שם האופציה</b></td>";
			echo "<td width='10'></td>";
			echo "<td><b>מיקום</b></td>";
			echo "<td width='10'></td>";
			echo "<td></td>";
			echo "<td width='10'></td>";
			echo "<td></td>";
		echo "</tr>";
		
		
		
		while( $data = mysql_fetch_array($res) )
		{
			echo "<tr><td colspan=\"7\" height=\"5\"></td></tr>";
			
			echo "<form action=? name='net_dynamic_form_options_editFORM' method=GET>";
			echo "<input type='hidden' name='main' value='net_dynamic_form_options_edit_DB'>";
			echo "<input type='hidden' name='unk' value='".$_GET['unk']."'>";
			echo "<input type='hidden' name='sesid' value='".SESID."'>";
			echo "<input type='hidden' name='rowID' value='".$_GET['rowID']."'>";
			echo "<input type='hidden' name='optionID' value='".$data['id']."'>";
			
			echo "<tr>";
				echo "<td><input type='text' name='clientTextValue' value='".stripslashes($data['clientTextValue'])."' class='input_style'></td>";
				echo "<td width='10'></td>";
				echo "<td><input type='text' name='place' value='".stripslashes($data['place'])."' class='input_style' style='width: 35px;'></td>";
				echo "<td width='10'></td>";
				echo "<td><input type='submit' value='עדכן' class='submit_style'></td>";
				echo "<td width='10'></td>";
				echo "<td><a href=\"?main=net_dynamic_form_options_DELL&rowID=".$_GET['rowID']."&optionID=".$data['id']."&unk=".$_GET['unk']."&sesid=".SESID."\" class=\"maintext\" onclick=\"return can_i_del();\"><strong style=\"color:red;\">מחיקה</strong></a></td>";
			echo "</tr>";
			
			echo "</form>";
		}
		
	
	echo "</table>";
}


function net_dynamic_form_options_edit_DB()
{
	if( $_GET['optionID'] == "" )
	{
		$sql = "INSERT INTO dynamic_client_form_values ( unk, dynamicId, clientTextValue, place ) VALUES (
			'".$_GET['unk']."' , '".$_GET['rowID']."' , '".addslashes($_GET['clientTextValue'])."' , '".addslashes($_GET['place'])."' )";
		$res = mysql_db_query(DB,$sql);
	}
	else
	{
		$sql = "UPDATE dynamic_client_form_values SET clientTextValue = '".addslashes($_GET['clientTextValue'])."' , place = '".addslashes($_GET['place'])."' 
		WHERE dynamicId = '".$_GET['rowID']."' AND unk = '".$_GET['unk']."' AND id = '".$_GET['optionID']."' ";
		$res = mysql_db_query(DB,$sql);
	}
	
	echo "<script>window.location.href='index.php?main=net_dynamic_form_options_edit&rowID=".$_GET['rowID']."&unk=".$_GET['unk']."&sesid=".SESID."';</script>";
		exit;
}


function net_dynamic_form_options_DELL()
{
	$sql = "DELETE FROM dynamic_client_form_values WHERE dynamicId = '".$_GET['rowID']."' AND id = '".$_GET['optionID']."' AND unk = '".$_GET['unk']."' LIMIT 1";
	$res = mysql_db_query(DB,$sql);
	
	echo "<script>window.location.href='index.php?main=net_dynamic_form_options_edit&rowID=".$_GET['rowID']."&unk=".$_GET['unk']."&sesid=".SESID."';</script>";
		exit;
}


?>