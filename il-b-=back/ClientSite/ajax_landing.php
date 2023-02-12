<?

//header('content-type:TEXT/HTML; charset=UTF-8');
####################################
##
##
##	
##
####################################
error_reporting( 0 );
ob_start();
session_start();

require_once('/home/ilan123/domains/ilbiz.co.il/public_html/global_func/vars.php');
require_once('/home/ilan123/domains/ilbiz.co.il/public_html/global_func/classes/class.estimate.statisitc.php');

define('LANG',"he");
require_once("/home/ilan123/domains/ilbiz.co.il/public_html/global_func/DB.php");
require_once("/home/ilan123/domains/ilbiz.co.il/public_html/global_func/global_functions.php");
require_once("/home/ilan123/domains/ilbiz.co.il/public_html/global_func/forms_creator.php");
require_once('/home/ilan123/domains/ilbiz.co.il/public_html/lang/lang.he.php');
require_once('strac_func.php');
require_once('functions.php');
require_once('client_castum_functions.php');

mysql_query("SET NAMES 'utf8'");


switch($_GET['main'])
{
	case "video" :
		
		$sql = "SELECT video_flash , video_url FROM user_video WHERE unk = '".$_GET['unk']."' AND deleted=0 AND id = '".$_GET['uid']."' ";
		$resVid = mysql_db_query(DB,$sql);
		$dataVid = mysql_fetch_array($resVid);
		
		if( $dataVid['video_flash'] )
			echo changeWidthHieghtVid(stripslashes($dataVid['video_flash']));
		elseif( $dataVid['video_url'] )
			echo "<embed src=\"".$dataVid['video_url']."\" loop=\"0\" autostart=\"true\" width=350 height=221></embad>";
		
	break;
	
	
	case "loadLandingModules" :
		
		$landingId= ( $_GET['ld'] == "" ) ? "" : "id='".$_GET['ld']."' AND ";
		$sql = "SELECT * FROM sites_landingPage_settings WHERE ".$landingId." unk = '".$_GET['unk']."' ORDER BY landing_defualt DESC , id";
		$resSetting = mysql_db_query(DB,$sql);
		$dataLDSetting = mysql_fetch_array($resSetting);

		$sql = "SELECT * FROM sites_landingPage_modules WHERE unk = '".$_GET['unk']."' AND landing_id = '".$_GET['ld']."' AND deleted=0 ORDER BY place , id";
		$resModules = mysql_db_query(DB,$sql);
		
		echo "<table border=\"0\" width=100% cellspacing=\"0\" cellpadding=\"0\" class=\"maintext\">";
		
			while( $dataModules = mysql_fetch_array($resModules) )
			{
				$bgColor = ( $dataModules['bgColor'] != "" ) ? "bgcolor='#".$dataModules['bgColor']."' style='padding: 20px;'" : "";
				$fieldset_start = ( $dataModules['border_color'] != "" ) ? "<fieldset id='dims' style='border:1px solid #".$dataModules['border_color']."; padding: 20px;'><legend>" : "";
				$legend_end = ( $dataModules['border_color'] != "" ) ? "</legend>" : "";
				$fieldset_end = ( $dataModules['border_color'] != "" ) ? "</fieldset>" : "";
				
				if( $bgColor == "" && $fieldset_start == "" )
					$style = " style='padding: 20px;'";
				else
					$style = "";
				
				$abpath_temp2 = SERVER_PATH."/new_images/landing/".$dataModules['title_icon'];
				if( file_exists($abpath_temp2) && !is_dir($abpath_temp2) )
					$titeIcon = "<img src=\"".HTTP_PATH."/new_images/landing/".$dataModules['title_icon']."\" border=0 style='padding-left: 20px;'>";
				else
					$titeIcon = "";
				
				$headline_style = "font-family: Tahoma,arial; font-size: ".$dataModules['title_size']."px; color: #".$dataModules['title_color'].";";
				$visibility_hidden_start = ( $dataModules['visibility_hidden'] == "1" ) ? "<a href='javascript:void(0)' onclick='document.getElementById(\"open_mu_".$dataModules['id']."\").style.display=\"\"' style='".$headline_style." outline: none; '>" : "";
				$visibility_hidden_end = ( $dataModules['visibility_hidden'] == "1" ) ? "</a>" : "";
				$hide_module = ( $dataModules['visibility_hidden'] == "1" ) ? "style='display: none;'" : "";
				$hide_module_text = ( $dataModules['visibility_hidden'] == "1" ) ? "<span style='font-size:10px;'> - לפרטים נוספים אנא לחצו על הכותרת</span>" : "";
				
				echo "<tr><td height=5 colspan=3></td></tr>";
				echo "<tr>";
					echo "<td width=10></td>";
					echo "<td ".$bgColor.$style." align=right >";
						echo $fieldset_start.$visibility_hidden_start.$titeIcon.$visibility_hidden_end."<span style='".$headline_style."'><b>".$visibility_hidden_start.stripslashes($dataModules['module_title']).$visibility_hidden_end."</b>".$hide_module_text."</span>".$legend_end;
						echo "<table border=\"0\" width=100% cellspacing=\"0\" cellpadding=\"0\" class=\"maintext\" ".$hide_module." id='open_mu_".$dataModules['id']."'>";
							echo "<tr>";
								echo "<td>";
									
									echo "<table border=\"0\" width=100% cellspacing=\"0\" cellpadding=\"0\" class=\"maintext\">";
										
										$sql = "SELECT * FROM sites_landingPage_paragraph WHERE unk = '".$_GET['unk']."' AND landing_id = '".$_GET['ld']."' AND module_id = '".$dataModules['id']."' AND deleted=0 ORDER BY place, id";
										$resParagraph = mysql_db_query(DB,$sql);
										
										while( $dataParagraph = mysql_fetch_array($resParagraph) )
										{
											switch( $dataParagraph['module_type'] )
											{
												case "0" :
													echo "<tr><td height=7></td></tr>";
													echo "<tr>";
														echo "<td>".stripslashes($dataParagraph['p_text'])."</td>";
													echo "</tr>";
													echo "<tr><td height=7></td></tr>";
												break;
												
												case "1" :
													$vidValue = explode( "|" , $dataParagraph['p_text'] );
													
													if( $vidValue[0] != "" ) 
													{
													echo "<tr><td height=7></td></tr>";
													echo "<tr>";
														echo "<td>";
															echo "<table border=\"0\" width=100% cellspacing=\"0\" cellpadding=\"0\" class=\"maintext\">";
																
																echo "<tr>";
																	echo "<td valign=top>";
																		echo "<table border=\"0\" width=350 cellspacing=\"0\" cellpadding=\"0\" class=\"maintext\">";
																			echo "<tr>";
																				echo "<td><div id='playing_video' style='border: 1px solid #".$dataModules['title_color'].";'><script>videoL(\"".$vidValue[0]."\")</script></div></td>";
																			echo "</tr>";
																			echo "<tr><td height=10></td></tr>";
																			echo "<tr>";
																				echo "<td align=center><a href='index.php?m=vi' class='landing_link'>צפה בהכל</a></td>";
																			echo "</tr>";
																			
																		echo "</table>";
																	echo "</td>";
																	echo "<td width=20></td>";
																	echo "<td valign=top>";
																		echo "<table border=\"0\" width=350 cellspacing=\"0\" cellpadding=\"0\" class=\"maintext\">";
																			
																			for( $vid=0 ; $vid<=3 ; $vid++ )
																			{
																				if( $vidValue[$vid] != "" )
																				{
																					$sql = "SELECT id, name, img, summary FROM user_video WHERE unk = '".$_GET['unk']."' AND deleted=0 AND id = '".$vidValue[$vid]."' ";
																					$resVid = mysql_db_query(DB,$sql);
																					$dataVid = mysql_fetch_array($resVid);
																					
																					$abpath_temp = SERVER_PATH."/video/".$dataVid['img'];
																					
																					echo "<tr>";
																						echo "<td valign=top>";
																							if( file_exists($abpath_temp) && !is_dir($abpath_temp) )
																								echo "<img src='video/".$dataVid['img']."' border='0' width=\"85\" style='border: 1px solid #".$dataModules['title_color'].";'>";
																						echo "</td>";
																						
																						echo "<td width=20></td>";
																						
																						echo "<td valign=top height=100%>";
																							echo "<table border=\"0\" width=250 height=100% cellspacing=\"0\" cellpadding=\"0\" class='landing_text'>";
																								echo "<tr>";
																									echo "<td style='color: #".$dataModules['title_color']."; font-size: 14px;'>".stripslashes($dataVid['name'])."</td>";
																								echo "</tr>";
																								echo "<tr>";
																									echo "<td>".global_strrrchr(stripslashes($dataVid['summary']) , "100")."</td>";
																								echo "</tr>";
																								echo "<tr>";
																									echo "<td align=left class='landing_link'><a href='javascript:void(0)' onclick='videoL(\"".$dataVid['id']."\")' class='landing_link'>צפה</a></td>";
																								echo "</tr>";
																							echo "</table>";
																						echo "</td>";
																						
																					echo "</tr>";
																					echo "<tr><td height=10></td></tr>";
																				}
																			}
																			
																		echo "</table>";
																	echo "</td>";
																echo "</tr>";
																
															echo "</table>";
														echo "</td>";
													echo "</tr>";
													echo "<tr><td height=7></td></tr>";
													}
												break;
												
												case "2" :
													if( $dataParagraph['p_text'] != "" )
													{
														echo "<tr><td height=7></td></tr>";
														echo "<tr>";
															echo "<td><div id='playing_video2' style='border: 1px solid #".$dataModules['title_color'].";'><script>videoML(\"".$dataParagraph['p_text']."\")</script></div></td>";
														echo "</tr>";
														echo "<tr><td height=7></td></tr>";
													}
												break;
												
												case "3" :
													$imgValue = explode( "|" , $dataParagraph['p_text'] );
													
													if( $imgValue[0] != "" ) 
													{
													echo "<tr><td height=7></td></tr>";
													echo "<tr>";
														echo "<td align=center>";
															echo "<table border='0' cellpadding='0' cellspacing='0' class='maintext'>";
															
																$counter = 0;
																for( $img=0 ; $img<=8 ; $img++ )
																{
																	if( $imgValue[$img] != "" )
																	{
																		$sql = "select * from user_gallery_images where unk = '".$_GET['unk']."' and deleted = '0' AND id = '".$imgValue[$img]."' ";
																		$resImg = mysql_db_query(DB,$sql);
																		$dataImg = mysql_fetch_array($resImg);
																		
																		if( $counter%4 == 0 )
																			echo "<tr>";
																			
																				echo "<td valign=middle align=center style='border: 1px solid #9D9D9D; background-color: #eeeeee; padding: 3px; margin: 3px;'>";
																				
																					$abpath_temp_unlink = SERVER_PATH."/gallery/".$dataImg['img'];
																					$abpath_temp_unlinkl = SERVER_PATH."/gallery/L".$dataImg['img'];
																					
																					$exist_img = ( $counter == 1 ) ? "thumbnail2" : "thumbnail";
																					if( file_exists($abpath_temp_unlink) && !is_dir($abpath_temp_unlink) )
																					{
																						$content = ( $dataImg['content'] != "" ) ? "title='".nl2br(htmlspecialchars(stripslashes($dataImg['content'])))."'" : "";
																						echo "<a href=\"".HTTP_PATH."/gallery/L".$dataImg['img']."\" rel=\"lightbox[page".$L."]\" ".$content." ><img src=\"".HTTP_PATH."/gallery/".$dataImg['img']."\" rel=\"lightbox\" border=\"0\"></a>";
																					}
																				echo "</td>";
																		
																		$counter++;
																		
																		if( $counter%4 == 0 )
																			echo "</tr><tr><td colspan=10 height=15></td></tr>";
																		else
																			echo "<td width=15></td>";
																			
																	}
																	
																}
																
															echo "</table>";
														echo "</td>";
													echo "</tr>";
													echo "<tr><td height=7></td></tr>";
													}
												break;
												
												case "4" :
													if( $dataParagraph['p_text'] == "1" )
													{
														echo "<tr><td height=7></td></tr>";
														echo "<tr>";
															echo "<td align=center>";
																optimize_text(contact("1"));
															echo "</td>";
														echo "</tr>";
														echo "<tr><td height=7></td></tr>";
													}
													elseif( $dataParagraph['p_text'] == "2" )
													{
														echo "<tr><td height=7></td></tr>";
														echo "<tr>";
															echo "<td align=center>";
																echo "<table border='0' cellpadding='0' cellspacing='0' class='maintext' width=100%>";
																	
																
																$sql = "SELECT mailing_id FROM content_pages WHERE id = '".$dataLDSetting['mailignList_contentPageID']."' ";
																$resMailing = mysql_db_query(DB,$sql);
																$dataMailing = mysql_fetch_array($resMailing);
																
																if( $dataMailing['mailing_id'] != "" && $dataMailing['mailing_id'] != "0" )
																{
																	echo "<tr>";
																		echo "<td valing=top align=right>";
																			echo "<iframe src='http://www.ilbiz.co.il/newsite/net_system/netMailing.php?unk=".$_GET['unk']."&amp;mailing_id=".$dataMailing['mailing_id']."&amp;td=".$dataLDSetting['mailignList_contentPageID']."&mini=1' width='600' height='200' id='loginPage2' frameborder=0 scrolling=no allowtransparency='true'></iframe>";
																		echo "</td>";
																	echo "</tr>";
																}
																echo "</table>";
															echo "</td>";
														echo "</tr>";
														echo "<tr><td height=7></td></tr>";
													}
												break;
												
												case "5" :
													echo "<tr><td height=7></td></tr>";
													echo "<tr>";
														echo "<td align=center>";
															echo estimate_site_main_block($dataLDSetting['mailignList_contentPageID'] , "1");
														echo "</td>";
													echo "</tr>";
													echo "<tr><td height=7></td></tr>";
												break;
												
												case "6" :
																echo "<tr><td height=20></td></tr>";
																echo "<tr>";
																	echo "<td align=center style='padding-right: 10px;'>";
																		echo "<table border='0' cellpadding='0' cellspacing='0' class='maintext' width=100%>";
																			echo "<tr>";
																				echo "<td>".stripslashes($dataParagraph['p_text'])."</td>";
																			echo "</tr>";
																			echo "<tr><td height=10></td></tr>";
																			echo "<tr>";
																				echo "<td>";
																					echo "<table border=\"0\" cellspacing=\"0\" cellpadding=\"0\" class=\"maintext\">";
																						echo "<tr>";
																							echo '<td style="padding-left:7px; padding-right: 7px;"><iframe src="//www.facebook.com/plugins/like.php?href=http%3A%2F%2Fwww.10service.co.il%2Flanding.php%3Fld%3D48&amp;send=false&amp;layout=standard&amp;width=200&amp;show_faces=false&amp;action=like&amp;colorscheme=light&amp;font=tahoma&amp;height=35" scrolling="no" frameborder="0" style="border:none; overflow:hidden; width:200px; height:35px;" allowTransparency="true"></iframe></td>';
																							echo "<td width=10></td>";
																							echo "<script>gapi.plusone.go();</script>";
																							echo '<td valign=top><g:plusone size="medium" annotation="inline" width="120" href="http://www.10service.co.il/landing.php?ld=48"></g:plusone></td>';
																						echo "</tr>";
																					echo "</table>";
																				echo "</td>";
																			echo "</tr>";
																			$abpath_temp2 = $_SERVER['DOCUMENT_ROOT']."/new_images/landing/".$dataParagraph['contact_bottom_bg'];
																			if( file_exists($abpath_temp2) && !is_dir($abpath_temp2) )
																			{
																				$im_size = GetImageSize ($abpath_temp2); 
																				$imageWidth = $im_size[0]; 
																				$imageHeight = $im_size[1];
																				
																				$contact_bottom_bg = "background=\"/new_images/landing/".$dataParagraph['contact_bottom_bg']."\" width=\"".$imageWidth."\" height=\"".$imageHeight."\"";
																			}
																			
																			$_SESSION['user_contact_form'] = "";
	
																			$_SESSION['user_contact_form']['unk'] = "asc".rand(10000,15000);
																			$_SESSION['user_contact_form']['name'] = "ged".rand(15000,20000);
																			$_SESSION['user_contact_form']['email'] = "pok".rand(20000,25000);
																			$_SESSION['user_contact_form']['phone'] = "ujk".rand(25000,3000);
																			$_SESSION['user_contact_form']['content'] = "gdv".rand(40000,45000);
																			$_SESSION['user_contact_form']['date_in'] = "cve".rand(45000,50000);
																			
																			$form_text_color = ( $dataParagraph['text_form_color'] != "" ) ? "style='color: #".$dataParagraph['text_form_color'].";'" : "";
																			
																			// contact
																			echo "<tr>";
																				echo "<td ".$contact_bottom_bg." width=\"".$imageWidth."\" height=\"".$imageHeight."\" align=center>";
																					echo "<table border='0' cellpadding='0' cellspacing='0' class='maintext' width=\"".$imageWidth."\" height=\"".$imageHeight."\">";
																						echo "<tr>";
																							echo "<td align=center>";
																							echo "<form action='index.php' method='post' name='formC' style='padding: 0px; margin: 0px;'>";
																							echo "<input type='hidden' name='m' value='insert_contact'>";
																							echo "<input type='hidden' name='".$_SESSION['user_contact_form']['unk']."' value='".$_GET['unk']."'>";
																							echo "<input type='hidden' name='".$_SESSION['user_contact_form']['date_in']."' value='".GlobalFunctions::get_timestemp()."'>";
																								echo "<table border='0' cellpadding='0' cellspacing='0' class='maintext'>";
																									echo "<tr>";
																										echo "<td>";
																											echo "<table border='0' cellpadding='0' cellspacing='0' class='maintext' ".$form_text_color.">";
																												echo "<tr>";
																													echo "<td width=30></td>";
																													echo "<td>שם מלא </td>";
																													echo "<td width=10></td>";
																													echo "<td><input type='text' name='".$_SESSION['user_contact_form']['name']."' class='input_style' style='width: 150px;'></td>";
																													echo "<td width=30></td>";
																													echo "<td>שם העסק</td>";
																													echo "<td width=10></td>";
																													echo "<td><input type='text' name='".$_SESSION['user_contact_form']['content']."' class='input_style' style='width: 150px;'></td>";
																												echo "</tr>";
																												echo "<tr><td height=7 colspan=8></td></tr>";
																												echo "<tr>";
																													echo "<td width=30></td>";
																													echo "<td>דואר אלקטרוני </td>";
																													echo "<td width=10></td>";
																													echo "<td><input type='text' name='".$_SESSION['user_contact_form']['email']."' class='input_style' style='width: 150px;'></td>";
																													echo "<td width=30></td>";
																													echo "<td>טלפון</td>";
																													echo "<td width=10></td>";
																													echo "<td><input type='text' name='".$_SESSION['user_contact_form']['phone']."' class='input_style' style='width: 150px;'></td>";
																												echo "</tr>";
																											echo "</table>";
																										echo "</td>";
																										echo "<td width=30></td>";
																										echo "<td align=right width=200>";
																											$abpath_temp2 = $_SERVER['DOCUMENT_ROOT']."/new_images/landing/".$dataParagraph['contact_submit_botton'];
																											if( file_exists($abpath_temp2) && !is_dir($abpath_temp2) )
																												echo "<input type='image' src='/new_images/landing/".$dataParagraph['contact_submit_botton']."'>";
																											else
																												echo "<input type='submit' value='שליחה' class='submit_style'>";
																										echo "</td>";
																									echo "</tr>";
																								echo "</table>";
																								echo "</form>";
																							echo "</td>";
																					echo "</tr>";
																				echo "</table>";	
																				echo "</td>";
																			echo "</tr>";
																			
																		echo "</table>";
																	echo "</td>";
																echo "</tr>";
																echo "<tr><td height=7></td></tr>";
															break;
												
											}
											
											
										}
										
									echo "</table>";
									
								echo "</td>";
							echo "</tr>";
						echo "</table>";
						echo $fieldset_end;
					echo "</td>";
					echo "<td width=10></td>";
				echo "</tr>";
				echo "<tr><td height=5 colspan=3></td></tr>";
			}
		
		echo "</table>";
		
	break;
	
	
}


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


function changeWidthHieghtVid( $string )
{
	if( $_GET['ex'] == "1" )
	{
		$new_width = "720";
		$new_height = "430";
	}
	else
	{
		$new_width = "350";
		$new_height = "221";
	}
	
	$search_for_width = explode( 'width="' , $string );
	$search_for_width2 = explode( '"' , $search_for_width[1] );
	$oldWidth = $search_for_width2[0];
	
	$search_for_height = explode( 'height="' , $string );
	$search_for_height2 = explode( '"' , $search_for_height[1] );
	$oldheight = $search_for_height2[0];
	
	$new_string = str_replace( 'width="'.$oldWidth.'"' , 'width="'.$new_width.'"' , $string );
	$new_string = str_replace( 'height="'.$oldheight.'"' , 'height="'.$new_height.'"' , $new_string );
	
	return $new_string;
}
