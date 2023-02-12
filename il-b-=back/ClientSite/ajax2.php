<?

session_start();
/*
if(isset($_GET['clearses'])){
	print_r($_SESSION); 
	session_destroy();
	unset($_SESSION['gl_source']);
	unset($_SESSION['estimate_stats_referer']);
	unset($_SESSION['estimate_stats___current_referer']);
	unset($_SESSION['estimate_stats___agent']);	
	exit("session ...is clear");
}
*/
//block specific ip
$userIp = $_SERVER['REMOTE_ADDR'];
if($userIp == '93.173.241.32'){
	exit("oops... Ist's not you, its us!!! Please try again later.");
}
//header('content-type:TEXT/HTML; charset=UTF-8');
####################################
##
##
##	
##
####################################

require('/home/ilan123/domains/ilbiz.co.il/public_html/global_func/vars.php');
require('/home/ilan123/domains/ilbiz.co.il/public_html/global_func/classes/class.estimate.statisitc.php');
require('/home/ilan123/domains/ilbiz.co.il/public_html/global_func/classes/class.estimate_stats.php');

mysql_query("SET NAMES 'utf8'");

switch($_GET['main'])
{
	case "estimateSiteRow" :
		
		
		$sql = "SELECT id, father FROM biz_categories WHERE id = '".ifint($_GET['cat'])."' ";
		$res = mysql_db_query(DB,$sql);
		$data_father = mysql_fetch_array($res);
		
		if( $data_father['father'] == "0" )
		{
			$f_cat = $_GET['cat'];
			$sub_cat = "0";
		}
		else
		{
			$f_cat = $data_father['father'];
			$sub_cat = $_GET['cat'];
		}
		
		$estimate_statisitc = new estimate_statisitc;
		$params = array();
		$params['domain'] = $_SERVER[HTTP_HOST];
		$params['father_cat'] = $f_cat;
		$params['sub_cat'] = $sub_cat;
		$stat_id = $estimate_statisitc->newEstimateStat($params);
		
		
		$estimate_stats = new estimate_stats;
		$params_stats = array();
		$params_stats['cat'] = $_GET['cat'];
		$params_stats['tat_cat'] = $f_cat;
		$params_stats['spec_cat'] = $sub_cat;
		$estimate_stats->update("0",$params_stats);
		
		$sql = "SELECT id, name FROM newCities WHERE father=0 ORDER BY id";
		$resAll = mysql_db_query(DB,$sql);
		
		echo "<form name=\"send_es_form\" method=\"post\" action=\"javascript:ajax_estimateSiteRow_send_data()\">";
		echo "<input type=\"hidden\" name=\"cat_f\" id=\"cat_f\" value='".$f_cat."' />";
		echo "<input type=\"hidden\" name=\"cat_s\" id=\"cat_s\" value='".$sub_cat."' />";
		echo "<input type=\"hidden\" name=\"stat_id\" id=\"stat_id\" value='".$stat_id."' />";
		echo "<input type=\"hidden\" name=\"pageId\" id=\"pageId\" value='".$_GET['pageId']."' />";
		echo "<table align=\"center\" border=\"0\" width=\"100%\" cellpadding=\"1\">";
			echo "<tr>";
				echo "<td valign=\"top\">";
					echo "<table width=\"480\" border=\"0\" class='maintext' cellpadding=0 cellspacing=0>";
						
						echo "<tr>";
							echo "<td>".con_text("שם").":</td><td width=\"2\"></td><td><input type=\"text\" name=\"Fm_name\" id=\"Fm_name\" class=\"input_style\" style='width: 60px;' /></td>";
							echo "<td width=\"2\"></td>";
							echo "<td>".con_text("טלפון").":</td><td width=\"2\"></td><td><input type=\"text\" name=\"Fm_phone\" id=\"Fm_phone\" dir=\"ltr\" class=\"input_style\" style='width: 72px;' /></td>";
							echo "<td width=\"2\"></td>";
							echo "<td>".con_text("אימייל").":</td><td width=\"2\"></td><td><input type=\"text\" name=\"Fm_email\" id=\"Fm_email\" dir=\"ltr\" class=\"input_style\" style='width: 110px;' /></td>";
							echo "<td width=\"2\"></td>";
							echo "<td>".con_text("עיר").":</td><td width=\"2\"></td><td align=left>";
							echo "<select name='Fm_city' id='Fm_city' class=\"input_style\" style='font-size: 10px; width: 104px; height:18px;'>";
								
								while( $data = mysql_fetch_array($resAll) )
								{
									$cityName = ( $data['name'] == "כל הארץ" ) ? con_text("בחר עיר") : $data['name'];
									echo "<option value='".$data['id']."' style='color: #000000;'>".stripslashes($cityName)."</option>";
									
									$sql = "SELECT id, name FROM newCities WHERE father=".ifint($data['id'])." ORDER BY name";
									$resAll2 = mysql_db_query(DB,$sql);
									
									while( $data2 = mysql_fetch_array($resAll2) )
									{
										$selected = ( eregi( stripslashes($data2['name']) , stripslashes($dataPage['name']) ) ) ? "selected" : "";
										echo "<option value='".$data2['id']."' ".$selected.">".stripslashes($data2['name'])."</option>";
									}
									echo "<option value=''>-----------------------</option>";
								}
							echo "</select>";
							echo "</td>";
					echo "</tr>";
					
					echo "<tr><td colspan=3 height=5></td></tr>";
					
					
					$sql = "SELECT id , cat_name FROM biz_categories WHERE status=1 AND hidden=0 AND father= '".ifint($_GET['cat'])."' ORDER BY place";
					$res_cats = mysql_db_query(DB , $sql );
					
					$select_name = ( $_GET['t'] == "2" ) ? "cat_prof" : "new_sub_cat" ;
					$select_name_temp  = ( $_GET['t'] == "2" ) ? "new_sub_cat" : "cat_prof" ;
					
					echo "<input type='hidden' name='".$select_name_temp."' id='".$select_name_temp."' value=''> ";
					
					echo "<tr>";
						echo "<td>".con_text("התמחות").":</td><td width=\"2\"></td><td colspan=5>";
							echo "<select name='".$select_name."' id='".$select_name."' class=\"input_style\" style='width: 166px; height:18px;'>";
								echo "<option value='' >".con_text("בחר התמחות")."</option>";
								
								while( $data_cats = mysql_fetch_array($res_cats) )
								{
									if( $_GET['t'] == "1" )
									{
										$sql = "SELECT id , cat_name FROM biz_categories WHERE status=1 AND hidden=0 AND father= '".ifint($data_cats['id'])."' ORDER BY place";
										$res_cats_child = mysql_db_query(DB , $sql );
										$num_cats_child = mysql_num_rows($res_cats_child);
									
										echo "<option >--------------------------------------</option>";
									}
									
									echo "<option value='C".$data_cats['id']."'>".stripslashes($data_cats['cat_name'])."</option>";
									
									if( $_GET['t'] == "1" )
									{
										if( $num_cats_child > 0 )
										{
											while( $data_cats_child = mysql_fetch_array($res_cats_child) )
											{
												echo "<option value='E".$data_cats['id']."F".$data_cats_child['id']."' >&nbsp;&nbsp;&nbsp;&nbsp;".stripslashes($data_cats_child['cat_name'])."</option>";
											}
										}
									}
								}
								
							echo "</select>";
						echo "</td>";
						echo "<td colspan=8>";
							echo "<table width=100% border=\"0\" class='maintext' cellpadding=0 cellspacing=0>";
								echo "<tr>";
									//echo "<td valign=bottom>".con_text("הערה/בקשה").":</td><td width=\"2\"></td><td><textarea name=\"Fm_note\" class='input_style' style=\"height:40px; width: 150px;\" cols=\"\" rows=\"\"></textarea></td>";
									echo "<td valign=bottom align=\"left\" style='font-size: 10px;'>";
										/*echo "<table border=\"0\" cellpadding=\"0\" cellspacing=\"0\">
											<tr>
												<td><input type='checkbox' name='taKn' id='taKn' value='1' /></td>
												<td width=\"2\"></td>
												<td><a href='javascript:void(0)' onclick=\"window.open('http://www.ilbiz.co.il/taKn.php','mywindow','width=350,height=150')\" class='maintext'>אני קראתי ומאשר את <u>התקנון</u></a></td>
											</tr>
										</table>";*/
										echo con_text("שירות הצעות מחיר בחינם וללא התחייבות");
									echo "</td>";
									echo "<td valign=bottom align=\"left\"><input class=\"submit_style\" type='submit' value=\"שלח בקשה\" style='width:70px;' id='submitit' /></td>";
								echo "</tr>";
							echo "</table>";
						echo "</td>";
					echo "</tr>";
					
					
					
				echo "</table>";
			echo "</form>";
	break;
	
	case "estimateSiteHeight" :
		$estimate_statisitc = new estimate_statisitc;

		$params = array();
		$params['domain'] = $_SERVER[HTTP_HOST];
		$params['father_cat'] = $_GET['cat'];
		$params['sub_cat'] = $_GET['subCat'];
		$params['cat_spec'] = $_GET['cat_spec'];
		$stat_id = $estimate_statisitc->newEstimateStat($params);
		
		
		$estimate_stats = new estimate_stats;
		$params_stats = array();
		$params_stats['cat'] = $_GET['cat'];
		$params_stats['tat_cat'] = $_GET['subCat'];
		$params_stats['spec_cat'] = $_GET['cat_spec'];
		$estimate_stats->update("0",$params_stats);
		
		$sql = "SELECT name,unk FROM content_pages WHERE type = '".mysql_real_escape_string($_GET['pageId'])."' AND unk = '".mysql_real_escape_string($_GET['unk'])."' ";
		$res = mysql_db_query(DB, $sql);
		$dataPage = mysql_fetch_array($res);
		
		$sql = "SELECT choosenClientId , cityId FROM estimate_miniSite_defualt_block WHERE type = '".mysql_real_escape_string($_GET['pageId'])."' AND unk = '".mysql_real_escape_string($_GET['unk'])."'";
		$res = mysql_db_query(DB, $sql);
		$estimate_data = mysql_fetch_array($res);
		
		
		$take_cat2 = ( $params['sub_cat'] != "0" ) ? $params['sub_cat'] : $params['father_cat'];
		$take_cat = ( $take_cat2 != "0" ) ? "bc.id=".$take_cat2." AND" : "";

		$sql = "select u.unk FROM 
			users as u,
			user_cat as uc,
			biz_categories as bc ,
			user_extra_settings as us
				WHERE 
					u.id = '".ifint($estimate_data['choosenClientId'])."' AND 
					us.unk=u.unk AND
					u.deleted=0 AND
					u.status=0 AND
				  u.end_date > NOW() AND
					us.belongTo10service=1 AND
					u.id=uc.user_id AND
					uc.cat_id=bc.id AND
					".$take_cat."
					bc.status=1
			 GROUP BY u.id";
		$res_choosenClient = mysql_db_query(DB, $sql);
		$users_data = mysql_fetch_array($res_choosenClient);


		echo "<form name=\"send_es_form\" method=\"post\" action=\"javascript:ajax_estimateSiteHeight_send_data()\">";
		echo "<input type=\"hidden\" name=\"cat_f\" id=\"cat_f\" value='".$_GET['cat']."' />";
		echo "<input type=\"hidden\" name=\"pageId\" id=\"pageId\" value='".$_GET['pageId']."' />";
		echo "<input type=\"hidden\" name=\"clientUnk\" id=\"clientUnk\" value='".$_GET['unk']."' />";
		
		echo "<input type=\"hidden\" name=\"stat_id\" id=\"stat_id\" value='".$stat_id."' />";
	
				echo "<table border=\"0\" class='maintext' cellpadding=0 cellspacing=0>";
					
					if( $params['sub_cat'] != "0" )
					{
						$take_cat2 = $params['sub_cat'];
						$choose_name = "cat_spec";
						echo "<input type=\"hidden\" name=\"cat_s\" id=\"cat_s\" value='".$_GET['subCat']."' />";
					}
					else
					{
						$take_cat2 = $params['father_cat'];
						$choose_name = "cat_s";
						echo "<input type=\"hidden\" name=\"cat_spec\" id=\"cat_spec\" value='' />";
					}
					
					if( !empty($users_data['unk']) )
					{
						
						
						$take_cat_mi = ( $take_cat2 != "0" ) ? "bc.father=".$take_cat2." AND" : "";
						
						$sql = "select bc.id , bc.cat_name FROM 
											users as u,
											user_cat as uc,
											biz_categories as bc
												WHERE 
													u.id = '".ifint($estimate_data['choosenClientId'])."' AND 
													u.deleted=0 AND
													u.status=0 AND
												  u.end_date > NOW() AND
													u.id=uc.user_id AND
													uc.cat_id=bc.id AND
													".$take_cat_mi."
													bc.status=1
											 GROUP BY bc.id";
						$res_choosenClient2 = mysql_db_query(DB, $sql);
						$numbs = mysql_num_rows($res_choosenClient2);
						
						if( $numbs > 0 )
						{
							echo "<tr>";
								echo "<td>".con_text("התמחות").":</td>";
								echo "<td width=\"2\"></td>";
								echo "<td>";
									echo "<select name='" . $choose_name . "' id='" . $choose_name . "' class='input_style' style='width: 104px; height: 18px;'>";
										echo "<option value=''>".con_text("בחר התמחות")."</option>";
										while( $data_specc = mysql_fetch_array($res_choosenClient2) )
										{
											echo "<option value='". $data_specc['id'] ."'>".stripslashes($data_specc['cat_name'])."</option>";
										}
									echo "</select>";
								echo "</td>";
							echo "</tr>";
							echo "<tr><td colspan=3 height=5></td></tr>";
						}
						else
							echo "<input type=\"hidden\" name=\"cat_spec\" id=\"cat_spec\" value='' />";
					}
					else
					{
						$sql = "SELECT id , cat_name FROM biz_categories WHERE status=1 AND hidden=0 AND father= '".ifint($take_cat2)."' ORDER BY place";
						$res_cats_formi = mysql_db_query(DB , $sql );
						$numbs = mysql_num_rows($res_cats_formi);
						
						if( $numbs > 0 )
						{
							echo "<tr>";
								echo "<td>".con_text("התמחות").":</td>";
								echo "<td width=\"2\"></td>";
								echo "<td>";
									echo "<select name='" . $choose_name . "' id='" . $choose_name . "' class='input_style' style='width: 104px; height: 18px;'>";
										echo "<option value=''>".con_text("בחר התמחות")."</option>";
										while( $data_specc2 = mysql_fetch_array($res_cats_formi) )
										{
											echo "<option value='". $data_specc2['id'] ."'>".stripslashes($data_specc2['cat_name'])."</option>";
										}
									echo "</select>";
								echo "</td>";
							echo "</tr>";
							
							echo "<tr><td colspan=3 height=5></td></tr>";
						}
						else
						{
							echo "<input type=\"hidden\" name=\"cat_s\" id=\"cat_s\" value='".$_GET['subCat']."' />";
							echo "<input type=\"hidden\" name=\"cat_spec\" id=\"cat_spec\" value='".$_GET['cat_spec']."' />";
						}
					}
					
					echo "<tr>";
						echo "<td>".iconv("windows-1255", "UTF-8" , "שם מלא").":</td><td width=\"2\"></td><td><input type=\"text\" name=\"Fm_name\" id=\"Fm_name\" class=\"input_style\" style='width: 104px;' /></td>";
					echo "</tr>";
					echo "<tr><td colspan=3 height=5></td></tr>";
					echo "<tr>";
						echo "<td>".con_text("טלפון").":</td><td width=\"2\"></td><td><input type=\"text\" name=\"Fm_phone\" id=\"Fm_phone\" dir=\"ltr\" class=\"input_style\" style='width: 104px;' /></td>";
					echo "</tr>";
					echo "<tr><td colspan=3 height=5></td></tr>";
					echo "<tr>";
						echo "<td>".con_text("אימייל").":</td><td width=\"2\"></td><td><input type=\"text\" name=\"Fm_email\" id=\"Fm_email\" dir=\"ltr\" class=\"input_style\" style='width: 104px;' /></td>";
					echo "</tr>";
					echo "<tr><td colspan=3 height=5></td></tr>";
					$sql = "SELECT id, name FROM newCities WHERE father=0 ORDER BY id";
					$resAll = mysql_db_query(DB,$sql);
					
					echo "<tr>";
						echo "<td>";
					if( $params['father_cat'] == "31" )	echo con_text("מעיר").":";
							else	echo con_text("עיר").":";
							
						echo "</td><td width=\"2\"></td><td>";
						echo "<select name='Fm_city' id='Fm_city' class=\"input_style\" style='font-size: 10px; width: 104px; height:18px;'>";
							echo "<option value=''>".con_text("בחר מעיר")."</option>";
							while( $data = mysql_fetch_array($resAll) )
							{
								if( $params['father_cat'] == "31" )
								{
									if( $data['id'] != "1" )
										echo "<option value='".$data['id']."' style='color: #000000;'>".stripslashes($data['name'])."</option>";
								}
								else
								{
									$cityName = ( $data['name'] == "כל הארץ" ) ? con_text("בחר מעיר") : $data['name'];
									echo "<option value='".$data['id']."' style='color: #000000;'>".stripslashes($cityName)."</option>";
								}
								
								$sql = "SELECT id, name FROM newCities WHERE father=".$data['id']." ORDER BY name";
								$resAll2 = mysql_db_query(DB,$sql);
								
								while( $data2 = mysql_fetch_array($resAll2) )
								{
									//$selected = ( eregi( stripslashes($data2['name']) , stripslashes($dataPage['name']) ) ) ? "selected" : "";
									$selected = ( $data2['id'] == $estimate_data['cityId'] ) ? "selected" : "";
									echo "<option value='".$data2['id']."' ".$selected.">".stripslashes($data2['name'])."</option>";
								}
								echo "<option value=''>-----------------------</option>";
							}
						echo "</select>";
						echo "</td>";
				echo "</tr>";
				echo "<tr><td colspan=3 height=5></td></tr>";
				
				if( $params['father_cat'] == "31" )
				{
					$sql = "SELECT id, name FROM newCities WHERE father=0 ORDER BY id";
					$resAll3 = mysql_db_query(DB,$sql);
					
					
					echo "<tr>";
						echo "<td>".con_text("לעיר").":</td><td width=\"2\"></td><td>";
						echo "<select name='Fm_to_city' id='Fm_to_city' class=\"input_style\" style='font-size: 10px; width: 104px; height:18px;'>";
							echo "<option value=''>".con_text("בחר לעיר")."</option>";
							while( $data = mysql_fetch_array($resAll3) )
							{
								if( $data['id'] != "1" )
									echo "<option value='".$data['id']."' style='color: #000000;'>".stripslashes($data['name'])."</option>";
								
								$sql = "SELECT id, name FROM newCities WHERE father=".$data['id']." ORDER BY name";
								$resAll4 = mysql_db_query(DB,$sql);
								
								while( $data2 = mysql_fetch_array($resAll4) )
								{
									//$selected = ( eregi( stripslashes($data2['name']) , stripslashes($dataPage['name']) ) ) ? "selected" : "";
									$selected = ( $data2['id'] == $estimate_data['cityId'] ) ? "selected" : "";
									echo "<option value='".$data2['id']."' ".$selected.">".stripslashes($data2['name'])."</option>";
								}
								echo "<option value=''>-----------------------</option>";
							}
						echo "</select>";
						echo "</td>";
					echo "</tr>";
					echo "<tr><td colspan=3 height=5></td></tr>";
					
					echo "<tr>";
						echo "<td>".con_text("מס' נוסעים").":</td><td width=\"2\"></td><td>";
						echo "<select name='Fm_passengers' id='Fm_passengers' class=\"input_style\" style='font-size: 10px; width: 104px;  height:18px;'>";
							echo "<option value=''>".con_text("בחר")."</option>";
							for( $i=1 ; $i<=51 ; $i++ )
							{
								$new_i = ( $i == "51" ) ? "51+" : $i ;
								echo "<option value='".$i."'>".$new_i."</option>";
							}
						echo "</select>";
						echo "</td>";
					echo "</tr>";
					echo "<tr><td colspan=3 height=5></td></tr>";
				}
				echo "<tr>";
					echo "<td>".con_text("הערה/בקשה").":</td><td width=\"2\"></td><td><textarea name=\"Fm_note\" id=\"Fm_note\" class='input_style' style=\"height:50px; width:104px;\" cols=\"\" rows=\"\"></textarea></td>";
				echo "</tr>";
				echo "<tr><td colspan=3 height=2></td></tr>";
				echo "<tr>";
					
					echo "<td></td><td width=\"2\"></td><td><input class=\"submit_style\" type='submit' style='width: 104px;' value=\"".con_text("שלח בקשה")."\" id='submitit' /></td>";
				echo "</tr>";
				
				if( $_GET['unk'] != "684280361691447887" && $_GET['unk'] != "556961905379713557" )
				{
					echo "<tr><td colspan=3 height=2></td></tr>";
					echo "<tr>";
						echo "<td colspan=\"3\" style='font-size: 10px;'>";
							/*echo "<table border=\"0\" cellpadding=\"0\" cellspacing=\"0\">
								<tr>
									<td><input type='checkbox' name='taKn' id='taKn' value='1' /></td>
									<td width=\"2\"></td>
									<td><a href='javascript:void(0)' onclick=\"window.open('http://www.ilbiz.co.il/taKn.php','mywindow','width=350,height=150')\" class='maintext'>אני קראתי ומאשר את <u>התקנון</u></a></td>
								</tr>
							</table>";*/
							echo con_text("שירות הצעות מחיר בחינם וללא התחייבות");
						echo "</td>";
					echo "</tr>";
				}
			echo "</table>";
		echo "</form>";
	break;

	
	case "estimateSiteInsert" :

		if( $_GET['new_sub_cat'] != "" )
		{
			$temp_cat = str_replace( "C" , "" , $_GET['new_sub_cat'] );
			$cat_s = $temp_cat;
			
			if( eregi( "E" , $_GET['new_sub_cat'] ) )
			{
				$temp = explode( "F" , $_GET['new_sub_cat'] );
				$temp_cat = str_replace( "E" , "" , $temp[0] );
				$cat_s = $temp_cat;
				$data_spec = $temp[1];
			}
		}
		else
			$cat_s = $_GET['cat_s'];
		
		
		if( $_GET['cat_prof'] != "" )
		{
			$temp_sub_cat = ""; 
			
			if( eregi( "C" , $_GET['cat_prof'] ) )
			{
				$temp_cat = str_replace( "C" , "" , $_GET['cat_prof'] );
				$data_spec = $temp_cat;
			}
			else
				$data_spec = $_GET['cat_prof'];
		}
		
		$cat_tree = array('cat_f'=>'0','cat_s'=>'0','cat_spec'=>'0');
		$final_cat = '0';
		if(isset($_GET['cat_f']) && $_GET['cat_f'] != '0' && $_GET['cat_f'] != ''){
			$final_cat = $_GET['cat_f'];
		}		
		if(isset($_GET['cat_s']) && $_GET['cat_s'] != '0' && $_GET['cat_s'] != ''){
			$final_cat = $_GET['cat_s'];
		}
		if(isset($cat_s) && $cat_s != '0' && $cat_s != ''){
			$final_cat = $cat_s;
		}		
		if(isset($data_spec) && $data_spec != '0' && $data_spec != ''){
			$final_cat = $data_spec;
		}
		if(isset($_GET['cat_spec']) && $_GET['cat_spec'] != '0' && $_GET['cat_spec'] != ''){
			$final_cat = $_GET['cat_spec'];
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
		$extra_note = "";
		if(isset($_GET['FM_extra'])){
			foreach($_GET['FM_extra'] as $key=>$val){
				$finalval = "";
				$finalvalIndex = 0;
				if(is_array($val)){
					foreach($val as $final){
						if($finalvalIndex != 0){
							$finalval.=", ";
						}
						$finalval.=$final;
						$finalvalIndex++;
					}
				}
				else{
					$finalval = $val;
				}
				$extra_note.= "   *".$key.": ".$finalval."\n";
			}
		}

		if(isset($_SESSION['gl_source'])){
			$gl_source = $_SESSION['gl_source'];
		}
		else{
			$gl_source = array(
				'entry_row'=>'0',
				'gclid'=>'0',
				'sites_page_id'=>'0',
				'has_gclid'=>'0',
				'is_mobile'=>'0',
			);			
		}
		if(isset($_GET['aff_id'])){
			$gclid = 1000+$_GET['aff_id'];
			$gl_source['has_gclid'] = $gclid;
			$gl_source['gclid'] = $gclid;
		}	
		$uniq_track = '0';
		$cookie_block = false;
		if(isset($_GET['uniq_track'])){
			$uniq_track = $_GET['uniq_track'];
		}

		$params = "cat_f=".$cat_tree['cat_f'];
		$params .= "&cat_s=".$cat_tree['cat_s'];
		$params .= "&cat_spec=".$cat_tree['cat_spec'];
		$params .= "&stat_id=".$_GET['stat_id'];
		$params .= "&ajax_write=1";
		$params .= "&json_write=1";
		$params .= "&M=save_form_site";
		$params .= "&Fm_name=".optimize_text($_GET['Fm_name']);
		$params .= "&Fm_phone=".optimize_text($_GET['Fm_phone']);
		$params .= "&Fm_email=".optimize_text($_GET['Fm_email']);
		$params .= "&Fm_city=".optimize_text($_GET['Fm_city']);
		$params .= "&Fm_to_city=".optimize_text($_GET['Fm_to_city']);
		$params .= "&Fm_passengers=".optimize_text($_GET['Fm_passengers']);
		$params .= "&Fm_note=".optimize_text($extra_note.$_GET['Fm_note']);
		$params .= "&taKn=".$_GET['taKn'];
		$params .= "&ref=".optimize_text($_SERVER[HTTP_REFERER]);
		$params .= "&senderIp=".$_SERVER[REMOTE_ADDR]; 
		$params .= "&user_agent=".$_SERVER["HTTP_USER_AGENT"]; 
		$params .= "&campaign_type=".$gl_source["has_gclid"]; 
		$params .= "&is_mobile=".$gl_source["is_mobile"];
		$params .= "&uniq_track=".$uniq_track;		
		
		if(isset($_GET['clientUnk'])){
			$params .= "&clientUnk=".$_GET['clientUnk'];
		}
		if(isset($_GET['bann_id'])){
			$params .= "&bann_id=".$_GET['bann_id'];
		}		
		if(isset($_GET['bill_free'])){
			$params .= "&bill_free=".$_GET['bill_free'];
		}
		if(isset($_GET['link_uniq'])){
			$params .= "&link_uniq=".$_GET['link_uniq'];
		}		
		
		$session_sent_id = $_SERVER[REMOTE_ADDR]."_".$cat_tree['cat_f']."_".$cat_tree['cat_s']."_".$cat_tree['cat_spec']."_".$_GET['Fm_phone']; 
		
		$blockSql = "SELECT block_ips,email_filter from main_settings";
		$blockRes = mysql_db_query(DB,$blockSql);
		$blockData = mysql_fetch_array($blockRes);
		$blockText = $blockData['block_ips'];
		$blockArr = explode(",",$blockText);
		$blockIps = array();
		foreach($blockArr as $blockIp){
			$ip = trim($blockIp);
			$blockIps[$ip] = 1;
		}
		$userIp = $_SERVER[REMOTE_ADDR];
		$is_spam = false;
		if(isset($blockIps[$userIp])){
			$params .= "&is_spam=1"; 
			$is_spam = true;
		}
		foreach($blockIps as $blockIp){
			$findblock = strpos($userIp, $blockIp);
			if($findblock === 0){
				$params .= "&is_spam=ip"; 
				$is_spam = true;
			}
		}
		
		//block phones
		$blockSql = "SELECT text_val from main_settings_kv WHERE param_name = 'phones_spam_block'";
		$blockRes = mysql_db_query(DB,$blockSql);
		$blockData = mysql_fetch_array($blockRes);
		$blockText = $blockData['text_val'];
		$blockArr = explode(",",$blockText);
		$blockPhones = array();
		foreach($blockArr as $blockPhone){
			$phone = trim($blockPhone);
			$blockPhones[$phone] = 1;
		}
		$phone_check = trim($_GET['Fm_phone']);
		if(isset($blockPhones[$phone_check])){
			$params .= "&is_spam=1"; 
			$is_spam = true;			
		}
		
		if(!$is_spam){
			
			$email_filterblockText = $blockData['email_filter'];
			$email_filterblockText = str_replace("\n",",",$email_filterblockText);
			$email_filterblockArr = explode(",",$email_filterblockText);
			$email_filterblock_arr = array();
			foreach($email_filterblockArr as $email_filterblock){
				$email_filter = trim($email_filterblock);
				if($email_filter != ""){
					$email_filterblock_arr[$email_filter] = 1;
				}
			}

			$phone_check = preg_replace("/[^0-9]/", "", $_GET['Fm_phone']);
			$email_check = $_GET['Fm_email'];
			if(isset($email_filterblock_arr[$phone_check])){
				$params .= "&is_spam=phone"; 
				$is_spam = true;				
			}
			elseif($email_check!=""){
				if(isset($email_filterblock_arr[$email_check])){
					$params .= "&is_spam=email"; 
					$is_spam = true;				
				}			
			}

		}	
		if(!$is_spam){
			if($uniq_track!='0' && $uniq_track!=''){
				$cookie_sql = "SELECT cookie FROM customer_tracking WHERE uniq_track = '".$uniq_track."'";
				$cookie_res = mysql_db_query(DB,$cookie_sql);
				$cookie_data = mysql_fetch_array($cookie_res);
				if($cookie_data['cookie']!=''){
					$cookie = $cookie_data['cookie'];
					$cookie_block_sql = "SELECT id,cookie FROM cookie_block WHERE cookie = '".$cookie."'";
					$cookie_block_res = mysql_db_query(DB,$cookie_block_sql);
					$cookie_block_data = mysql_fetch_array($cookie_block_res);
					if($cookie_block_data['cookie']==$cookie){
						$cookie_block = true;
					}
				}
			}
			if($cookie_block){
				$params .= "&is_spam=cookie"; 
				$is_spam = true;	
			}			
		}						
		if(!isset($_SESSION['sent_requests'])){
			$_SESSION['sent_requests'] = array();
		}
		if($_REQUEST['Fm_name'] == "checker_clean" ){
			foreach($_SESSION as $keyses=>$valses){
				unset($_SESSION[$keyses]);
			}
			echo con_text("ניקינו את הסשן בשביל שתוכל להמשיך לבדוק");
			exit();
		}
		
		
		if($_REQUEST['Fm_name'] != "checker" && $_REQUEST['Fm_name'] != "checker_qa" && !$is_spam){
			
			if(isset($_SESSION['sent_requests'])){
				$sent_requests = $_SESSION['sent_requests'];
				if(isset($sent_requests[$session_sent_id])){
					echo con_text("<br>פנייתך נשלחה.<br><br><br>");
					break;
				}
				else{
					$sent_requests[$session_sent_id] = '1';
					$_SESSION['sent_requests'] = $sent_requests;
				}
			}
		}
		else{
			//put debug stuff here!!!
		}

		$ch = curl_init(); 
		curl_setopt( $ch, CURLOPT_URL,"http://www.mysave.co.il/s.php" ); 
		curl_setopt($ch, CURLOPT_HEADER, 0);
		curl_setopt( $ch, CURLOPT_POST, 1 ); 
		curl_setopt( $ch, CURLOPT_POSTFIELDS, $params ); 
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_FOLLOWLOCATION, TRUE);
		$resualt = curl_exec ($ch); 
		curl_close ($ch);		
		$ok = "";
		$result_in_json = false;
		try{ 
			$resualt_arr = json_decode($resualt,true);
			if(isset($resualt_arr['ok'])){
				$result_in_json = true;
				$ok = $resualt_arr['ok'];
			}
		}
		catch(Exception $e){
			
		}
		if(!$result_in_json){
			$ok = $resualt;
		}
		if( $ok == "ok" )
		{
			$sql = "SELECT has_ssl FROM users WHERE domain = '".$_SERVER['HTTP_HOST']."' ";
			$res = mysql_db_query(DB, $sql);
			$dataSSL = mysql_fetch_array($res);			
			$has_ssl = $dataSSL['has_ssl'];
			$sql = "SELECT thanksRedirect , thanksPixel FROM estimate_miniSite_defualt_block WHERE type = '".ifint($_GET['pageId'])."'";
			$res = mysql_db_query(DB, $sql);
			$estimate_data = mysql_fetch_array($res);
			
			$sql = "SELECT unk FROM content_pages WHERE type = '".ifint($_GET['pageId'])."' ";
			$res = mysql_db_query(DB, $sql);
			$dataPage = mysql_fetch_array($res);
			
			
			$contact_form_return_text_on = false;
			$contact_form_return_text = "";
			$cfrto_sql = "SELECT tinyint_val FROM main_settings_kv WHERE param_name = 'contact_form_return_text_on' ";
			$cfrto_res = mysql_db_query(DB, $cfrto_sql);
			$contact_form_return_text_on_data = mysql_fetch_array($cfrto_res);			
			if($contact_form_return_text_on_data['tinyint_val'] == '1'){
				$contact_form_return_text_on = true;
				$cfrt_sql = "SELECT text_val FROM main_settings_kv WHERE param_name = 'contact_form_return_text' ";
				$cfrt_res = mysql_db_query(DB, $cfrt_sql);
				$contact_form_return_text_data = mysql_fetch_array($cfrt_res);
				$contact_form_return_text = $contact_form_return_text_data['text_val'];			
			}
			

				$result_sent = false;
				
				if($result_in_json && $estimate_data['thanksRedirect'] == ""){
					
					if($resualt_arr['estimate_id']!="" && $resualt_arr['sent_to'] != "0" && $resualt_arr['sent_to'] != "" ){
						$sent_to = $resualt_arr['sent_to'];
						if($resualt_arr['sent_to'] >5){
							$sent_to = 5;
						}
						if($contact_form_return_text_on){
							echo $contact_form_return_text;
						}
						else{						
							echo con_text("<br>פנייתך נשלחה ל".$sent_to." נותני שירות<br><br><br>");
							if(isset($_GET['add_wach_link']) && $_GET['add_wach_link'] == '1'){

								if(true){
									echo con_text("<br><a class='aftersend_link' href='index.php?m=user_cpanel&tab=afterSend' title='צפה בנותני השרות'>לחץ כאן לצפייה בנותני השרות </a><br>");
								}
								else{
									if($_COOKIE['net_user_s'] != ""){
										echo con_text("<br><a href='index.php?m=user_cpanel&tab=creditLog' title='צפה בנותני השרות'>לחץ כאן לצפייה בנותני השרות </a><br>");
									}
									else{
										$http_s = "http";
										if($has_ssl != '0' && $has_ssl != ''){
											$http_s = "https";
										}
										$_SESSION['user_cpanel_tab'] = 'creditLog';
										echo con_text("<div id='ajax_login_form_holder'><br><a href='".$http_s."://".$_SERVER['HTTP_HOST']."/index.php?m=NetLoginForms' title='צפה בנותני השרות'>לחץ כאן להתחברות למערכת וצפייה בנותני השרות </a></div><br>");
									}
								}
							}
						}
						$result_sent = true;
						if(!isset($_SESSION['estimate_requests'])){
							$_SESSION['estimate_requests'] = array();
						}
						$_SESSION['estimate_requests'][$resualt_arr['estimate_id']] = '1';
					}
				}
				if(!$result_sent){
					echo con_text("<br>פנייתך התקבלה ותטופל בהקדם - הצעות המחיר בדרך אלייך<br><br><br>");
				}
			
			//use same addwards instead of specific
			echo "<iframe src='thanksPix.php?pageId=0&useConstant=1' height=1 width=1 scrolling=0 frameborder=0></iframe>";

			if( $estimate_data['thanksRedirect'] != "" )
			{
				echo '<form action="'.stripslashes($estimate_data['thanksRedirect']).'" name="watting_redirect_form" id="watting_redirect_form" method="post"></form>';
			}
			if($result_in_json && isset($resualt_arr['estimate_id'])){ 
				$estimateFormId = $resualt_arr['estimate_id'];
				$customer_send = $resualt_arr['sent_to'];
				echo "<input type='hidden' id='tracking_form_id_holder' value='$estimateFormId' />				";
				echo "<input type='hidden' id='tracking_form_customer_send_holder' value='$customer_send' />				";
			}
		}
		else{
			if(!isset($_REQUEST['print_result'])){
				
				$req_sent = "";
				foreach($_REQUEST as $k=>$v){
					$req_sent .= " \n $k - $v , ";
				}
				$messege = "Hi. a form sending error accured: \n";
				$messege.= "params sent: \n".$params."\n\n\n";
				$messege.= "requestr sent: \n".$req_sent."\n\n\n";
				$uip = $_SERVER['REMOTE_ADDR'];
				$messege.= "IP: \n".$uip."\n\n\n";
				$messege.= "result: \n\n".str_replace("<","----",$resualt)."\n\n\n";
				$actual_link = "http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
				
				
				$messege.= "can try again using this link: \n".$actual_link."&print_result=1"."\n\n\n";
				mail('yacov.avr@gmail.com','error while sending form by customer',$messege);
				mail('ilan@il-biz.com','error while sending form by customer',$messege);
			}
		}
		if(isset($_REQUEST['print_result'])){
			echo "result from server: <br><br>";
			echo $resualt;
		}
		
	break;
	
	
	
	
	
	
	case "product_images" :
	$sql = "SELECT domain FROM users WHERE unk = '".$_GET['unk']."' ";
	$res = mysql_db_query(DB,$sql);
	$userData = mysql_fetch_array($res);
	
	$sql = "select id,  img, img2, img3 from user_products where unk = '".$_GET['unk']."' and deleted = '0' and active = '0' and id = '".ifint($_GET['ud'])."' limit 1";
	$res = mysql_db_query(DB,$sql);
	$data = mysql_fetch_array($res);
	
	$server_path = "/home/ilan123/domains/".$userData['domain']."/public_html/product_image/".$data['id']."/";
	
	echo "<table border=\"0\" cellspacing=\"0\" cellpadding=\"0\" class=\"maintext\">";
		echo "<tr><td height=45></td></tr>";
		echo "<tr>";
			echo "<td valign=top width=200 bgcolor='#F0F0F0' align=center style='border: 1px solid #BFBFBF;'>";
			
				$img_params['img1'] = $data['img1'];
				$img_params['img2'] = $data['img2'];
				$img_params['img3'] = $data['img3'];
				$img_params['name'] = htmlspecialchars(stripslashes($data['name']));
				$img_params['ud'] = $_GET['ud'];
				$img_params['domain'] = $userData['domain'];
				
				echo get_products_img_parameters( $_GET['pimg'] , $img_params );
				
			echo "</td>";
		echo "</tr>";
		echo "<tr><td height=10></td></tr>";
		echo "<tr>";
			echo "<td valign=top align=center>";
				echo "<table border=\"0\" cellspacing=\"0\" cellpadding=\"0\" class=\"maintext\">";
				
				$count=0;
				for( $img=2 ; $img <= 5 ; $img++ )
				{
					if( is_dir($server_path) )
					{
						$img_S = $img."-S";
						
						foreach (glob($server_path.$img_S."*") as $filename) {
							$explo = explode($data['id']."/",$filename);
							$exte = substr($explo[1],(strpos($explo[1],".")+1));
						}
						
						$temp_path = $server_path.$img_S.".".$exte;
						
						if( file_exists($temp_path) && !is_dir($temp_path) )
						{
							if( $count % 2 == 0 )
								echo "<tr>";
							
								echo "<td width=80 height=60 bgcolor='#F0F0F0' align=center style='border: 1px solid #BFBFBF;'>";
								
								if( $_GET['pimg'] == $img )
								{
									echo "<a href='javascript:void(0)' onclick='product_images(\"".$_GET['ud']."\" , \"default\" )'><img src='http://".$userData['domain']."/products/".$data['img']."' alt='' border='0' width=75 style='border: 0px solid #000000;'></a>";
								}
								else
								{
									echo "<a href='javascript:void(0)' onclick='product_images(\"".$_GET['ud']."\" , \"".$img."\" )'><img src='http://".$userData['domain']."/product_image/".$data['id']."/".$img_S.".".$exte."' alt='' border='0' style='border: 0px solid #000000;'></a>";
								}
									
								echo "</td>";
								echo "<td width=2></td>";
							
							
							$count++;
							if( $count % 2 == 0 )
							{
								echo "</tr>";
								echo "<tr><td height=2 colspan=10></td></tr>";
							}
							
						}
					}
				}
			echo "</td>";
		echo "</tr>";
	echo "</table>";
	
	break;
	
}

function con_text($str)
{
	return iconv("windows-1255", "UTF-8" , $str);
}
/*
function optimize_text($utf8 )
{
  $windows1255 = "";
  $chars = preg_split("//",$utf8);
  for ($i=1; $i<count($chars)-1; $i++) {
      $prefix = ord($chars[$i]);
      $suffix = ord($chars[$i+1]);
      //print ("<p>$prefix $suffix");
      if ($prefix==215) {
          $windows1255 .= chr($suffix+80);
          $i++;
      }
      elseif ($prefix==214) {
          $windows1255 .= chr($suffix+16);
          $i++;
      }
      else {
          $windows1255 .= $chars[$i];
      }
  }
  return $windows1255;
}

*/
/*
function get_products_img_parameters($img_name , $img_params=array() )
{
	
	switch( $img_name )
	{
		case "default" :
			$img1 = $img_params['img1'];
			$img2 = $img_params['img2'];
			$img3 = $img_params['img3'];
			
			$apth_small = "/home/ilan123/domains/".$img_params['domain']."/public_html/products/".$img;
			$apth_large = "/home/ilan123/domains/".$img_params['domain']."/public_html/products/".$img2;
			$apth_ex = "/home/ilan123/domains/".$img_params['domain']."/public_html/products/".$img3;
			
			$src = "http://".$img_params['domain']."/products/";
		break;
		
		default :
			$server_path = "/home/ilan123/domains/".$img_params['domain']."/public_html/product_image/".$img_params['ud']."/";
			
			$img_temp = $img_name."-S";
			
			foreach (glob($server_path.$img_temp."*") as $filename) {
				$explo = explode($img_params['ud']."/",$filename);
				$exte = substr($explo[1],(strpos($explo[1],".")+1));
			}
			
			$img1 = $img_name."-S.".$exte;
			$img2 = $img_name."-L.".$exte;
			$img3 = $img_name."-EX.".$exte;
			
			$apth_small = $server_path.$img;
			$apth_large = $server_path.$img2;
			$apth_ex = $server_path.$img3;
			
			$src = "http://".$img_params['domain']."/product_image/".$img_params['ud']."/";
	}
	
	
	if( file_exists($apth_ex) && !is_dir($apth_ex) )
		echo "<div id=\"s.prEXimgDiv".$img_name."\" style=\"display:none\"><img src='".$src.$img3."' border='0'></div>";
	
	list($org_width_l, $org_height_l) = getimagesize($apth_large);
	
	if( file_exists($apth_large) && !is_dir($apth_large) )
	{
		if( file_exists($apth_ex) && !is_dir($apth_ex) )
		{
			list($org_width, $org_height) = getimagesize($apth_ex);
			
			$sPrEX_width = $org_width + 10;
			$sPrEX_height = $org_height + 10;
			//echo "<div align='".$settings['re_align']."' style='padding-".$settings['re_align'].": 18px; width:170px;'><a href='javascript:void(0)' onClick=\"divwin=dhtmlwindow.open('s.prEXimg', 'div', 's.prEXimgDiv', '".$word[LANG]['1_1_products_extra_img']." - ".htmlspecialchars(stripslashes($data['name']))."', 'width=".$sPrEX_width."px,height=".$sPrEX_height."px,left=10px,top=10px,resize=0,scrolling=0'); return false\">".$word[LANG]['1_1_products_extra_img_link']."</a></div>";
			echo "<a href='javascript:void(0)' onClick=\"divwin=dhtmlwindow.open('s.prEXimg".$img_name."', 'div', 's.prEXimgDiv".$img_name."', '', 'width=".$sPrEX_width."px,height=".$sPrEX_height."px,left=10px,top=10px,resize=0,scrolling=0'); return false\"><img src='".$src.$img2."' border='0' align='left' alt='' width='".$org_width_l."' height='".$org_height_l."' vspace=5 hspace=5></a>";
			
		}
		else
			echo "<img src='".$src.$img2."' border='0' align='left' width='".$org_width_l."' height='".$org_height_l."' vspace=5 hspace=5>";
	}
	else 
		if( file_exists($apth_small) && !is_dir($apth_small) )
			echo "<img src='".$src.$img."' border='0' align='left'>";
}
*/

