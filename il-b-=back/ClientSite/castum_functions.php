<?

function castum_homePage__qikong()
{
	require '../include/settings.php';
	require '../include/functions/db_functions.php';

	$boxData=getData__qikong(array(1,2,3,4,5,6,7,8));
	// print_r($boxData[1]);
	
	
	echo "<table cellspacing=0 cellpadding=0>
  	 <tr>
  	 	<td valign=top>
  	 		<!--             6              -->";
			  foreach (array(5,6,7) as $boxType):
					if (count($boxData[$boxType]) > 0) foreach ($boxData[$boxType] as $oneBox):
						echo "<table cellspacing=0 cellpadding=0>
						 <tr>
						 	<td height=28 align=right background=images/title-left.png><span style=font-family:arial;font-weight:600;font-size:12;position:relative;right:6>".$oneBox['headline']."</span></td>
						 </tr>
						 <tr>
						 	<td>
					    	<table cellspacing=0 cellpadding=0>
					    	 <tr>
						  	 	<td bgcolor=#eaeaea width=1>
						  	  </td>
						  	 	<td>
						       <table dir=rtl background=images/box-bg.png cellspacing=0 cellpadding=0 width=189>
						       	<tr>
						       		<td width=14 height=5></td>
					            <td width=143></td>
					            <td width=14></td>
						       	</tr>
						       	<tr>
						       		<td></td>
						        </tr>
						        <tr><td height=5></td></tr>
						        <tr>
						        	<td></td>
						        	<td><a href=".$oneBox['url_lnk']."><img border=0 width=155 src='".$oneBox['hyperlink']."'></a></td>
						        </tr>
						      <tr><td height=4></td></tr>
						        <tr>
						        	<td></td>
					            <td>".$oneBox['summary']."</td>
						        </tr>
						        <tr>
						        	<td></td>
					            <td align=left><a href='".$oneBox['url_lnk']."'>להמשך לחץ כאן</a></td>
						        </tr>
						  	   </table>
						  	  </td>
						  	 	<td bgcolor=#eaeaea width=1>
						  	  </td>
					  	   </tr>
					  	  </table>
					    </td>
						 </tr>
						 <tr>
						 	<td><img src=images/box-bottom-left.png></td>
						</tr>
						<tr><td height=8></td></tr>
					 </table>";
			 endforeach;
			 endforeach;
  	 	echo "</td>
  	 	<td width=16></td>
  	 	<td>";
  	 		
  	 	echo "</td>
  	 </tr>
  </table>";
  
}

function getData__qikong($boxTypes)
{
	$retBoxData=array();
	
	foreach ($boxTypes as $box)
	 switch ($box)
	 {
	 	case 1 : $retBoxData[$box]=getArticle($box,2,'headline,summary,url_lnk'); break; 
	 	case 2 : $retBoxData[$box]=getArticle($box,2,'headline,summary,url_lnk'); break;
	 	case 3 : $retBoxData[$box]=getArticle($box,1,'headline,summary,hyperlink,url_lnk','rand()'); break;
	 	case 4 : $retBoxData[$box]=getArticle($box,1,'headline,summary,hyperlink,url_lnk','rand()'); break;
	 	case 5 : $retBoxData[$box]=getArticle($box,1,'headline,summary,hyperlink,url_lnk','rand()'); break;
	 	case 6 : $retBoxData[$box]=getArticle($box,1,'headline,summary,hyperlink,url_lnk','rand()'); break;
	 	case 7 : $retBoxData[$box]=getArticle($box,1,'headline,summary,hyperlink,url_lnk','rand()'); break;
	 	case 8 : $retBoxData[$box]=getArticle($box,4,'headline,hyperlink,url_lnk'); break;
	 }
 
 return $retBoxData;
}


function top_slice_search_kolnegev()
{
	//!!!CODE_SERACH_ENGING_NOT_DELETE!!!
	
	$str = "<form action='index.php' method='get' name='searchByCats' style='padding:0px; margin:0px;'>";
	$str .= "<input type='hidden' name='m' value='KgBm'>";
	$str .= "<table cellpadding=0 cellspacing=0 border=0 class='maintext'>";
		$str .= "<tr>";
			if( UNK != "192202924562351192" )
			{
				$str .= "<td>";
					if( UNK != "263512086634836547" )
					{
						$str .= "<select name='city' class='input_style' style='width:120px;height: 18px;'>";
							
							$sql = "SELECT id, city_name FROM user_guide_cities WHERE unk = '".UNK."' and deleted=0 ORDER BY city_name";
							$res = mysql_db_query(DB,$sql);
							
							$str .= "<option value=''>בחר עיר</option>";
							while( $data = mysql_fetch_array($res) )
							{
								$selected = ( $data['id'] == ifint($_GET['city']) ) ? "selected" : "";
								$str .= "<option value='".$data['id']."' ".$selected.">".stripslashes($data['city_name'])."</option>";
							}
						$str .= "</select>";
					}
					else
					{
						$str .= "<select name='guide' class='input_style' style='width:120px;height: 18px;'>";
							
							$sql = "SELECT id, guide_name FROM user_guide WHERE unk = '".UNK."' ORDER BY guide_name";
							$res = mysql_db_query(DB,$sql);
							
							$str .= "<option value=''>בחר איזור</option>";
							while( $data = mysql_fetch_array($res) )
							{
								$selected = ( $data['id'] == ifint($_GET['guide']) ) ? "selected" : "";
								$str .= "<option value='".$data['id']."' ".$selected.">".stripslashes($data['guide_name'])."</option>";
							}
						$str .= "</select>";
					}
				$str .= "</td>";
				$str .= "<td width=10></td>";
			}
			$styleB7 = ( UNK == "192202924562351192" ) ? "width:190px; height:22px; font-size: 14px;" : "width:135px; height:18px;";
			$str .= "<td>";
				$str .= "<select name='Scat' id='Scat' onchange='changeCatChain(this)' style='".$styleB7."' class='input_style'>";
					
					$sql = "SELECT id, cat_name FROM user_guide_cats WHERE unk = '".UNK."' AND deleted=0 AND active=0 AND father=0 ORDER BY cat_name";
					$res = mysql_db_query(DB,$sql);
					
					$str .= "<option value=''>סיווג ראשי</option>";
					while( $data = mysql_fetch_array($res) )
					{
						$selected = ( $data['id'] == ifint($_GET['Scat']) ) ? "selected" : "";
						$str .= "<option value='".$data['id']."' ".$selected.">".stripslashes($data['cat_name'])."</option>";
					}
				$str .= "</select>";
			$str .= "</td>";
			$str .= "<td width=10></td>";
			$str .= "<td>";
				$str .= "<select name='STcat' id='STcat' class='input_style' style='".$styleB7."'>";
				
					$sql = "SELECT id, cat_name FROM user_guide_cats WHERE unk = '".UNK."' AND deleted=0 AND active=0 AND father=".ifint($_GET['Scat'])." ORDER BY cat_name";
					$res = mysql_db_query(DB,$sql);
					
					$str .= "<option value=''>סיווג משני</option>";
					if( ifint($_GET['Scat']) != "0" )
					{
						while( $data = mysql_fetch_array($res) )
						{
							$selected = ( $data['id'] == ifint($_GET['STcat']) ) ? "selected" : "";
							$str .= "<option value='".$data['id']."' ".$selected.">".stripslashes($data['cat_name'])."</option>";
						}
					}
				$str .= "</select>";
			$str .= "</td>";
			$str .= "<td width=10></td>";
			$styleSubmitB7 = ( UNK == "192202924562351192" ) ? "width:90px; height:22px; font-size: 14px;" : "width:70px; height:18px;";
			$str .= "<td><input type='submit' class='input_style' value='חפש!' style='".$styleSubmitB7."'></td>";
		$str .= "</tr>";
	$str .= "</table>";
	$str .= "</form>";
	
	if( ifint($_GET['STcat']) != "" && ifint($_GET['STcat']) != "0" )
	{
		$str .= "<script>updateTatCat('".ifint($_GET['Scat'])."')</script>";
	}
	
	return $str;
}

function top_slice_search_kolnegev_free_text()
{
	global $word;
	//!!!CODE_SERACH_ENGING_2_NOT_DELETE!!!
	
	$str = "<form action=\"index.php\" method=\"get\" name=\"search_form\" style='padding:0; margin:0;'>";
	$str .= "<input type=\"hidden\" name=\"m\" value=\"search\">";
	$str .= "<table border=\"0\" cellspacing=\"0\" cellpadding=\"0\" class=\"rightMemu\" align=center>";
		$str .= "<tr>";
			$str .= "<td><input type=\"text\" name=\"search_val\" class=\"input_style\" style=\"width:386px; height: 30px; font-size: 18px;\"></td>";
			$str .= "<td width=\"2\"></td>";
			$str .= "<td><input type=\"submit\" value=\"".$word[LANG]['1_3_search_submit']."\" class=\"submit_style\" style=\"width:100px;  height: 34px; font-size: 18px;\"></td>";
		$str .= "</tr>";
	$str .= "</table>";
	$str .= "</form>";
	
	return $str;
}



function kolaNegev_guide_biz()
{
	
	$sql = "SELECT domain FROM users WHERE unk = '".UNK."' ";
	$res = mysql_db_query(DB,$sql);
	$userData = mysql_fetch_array($res);
	
	$server_path = "/home/ilan123/domains/".$userData['domain']."/public_html/new_images/";
	
	echo "<table cellpadding=0 cellspacing=0 border=0 class='maintext' width=552>";
		
		
		echo "<tr>";
			echo "<td>";
				echo "<table cellpadding=0 cellspacing=0 border=0 class='maintext'>";
					echo "<tr>";
						
						$banners = guide_banners("inner" , ifint($_GET['guide']) );
						
						$count = 0;
						foreach( $banners as $key => $val )
						{
							
							echo "<td width=171 height=247 style='border: 1px solid #000;'>";
								echo "<table cellpadding=10 cellspacing=0 border=0 class='maintext' align=center>";
									echo "<tr>";
										echo "<td>".$val."</td>";
									echo "</tr>";
								echo "</table>";
							echo "</td>";
							
							$count++ ;
							
							if( $count != 3 )
								echo "<td width=20></td>";
						}
					echo "</tr>";
				echo "</table>";
			echo "</td>";
		echo "</tr>";
		echo "<tr><td height=25></td></tr>";
		echo "<tr>";
			echo "<td>";
				echo "<table cellpadding=0 cellspacing=0 border=0 class='maintext' width=100% height=100%>";
					echo "<tr>";
						echo "<td width=552 valign=top >";
							echo "<table cellpadding=0 cellspacing=0 border=0 class='maintext' width=552 height=100% style='border: 1px solid #000;'>";
								
								$headlines = "";
								if ( ifint($_GET['guide']) != "" && ifint($_GET['guide']) != "0" )
								{
									$sql = "SELECT guide_name FROM user_guide WHERE id = '".ifint($_GET['guide'])."'";
									$res_hh1 = mysql_db_query(DB, $sql);
									$data_hh1 = mysql_fetch_array($res_hh1);
									
									$headlines .= "מדריך ".stripslashes($data_hh1['guide_name']).", ";
								}
								
								if ( ifint($_GET['Scat']) != "" && ifint($_GET['Scat']) != "0" )
								{
									$sql = "SELECT cat_name FROM user_guide_cats WHERE id = '".ifint($_GET['Scat'])."'";
									$res_hh2 = mysql_db_query(DB, $sql);
									$data_hh2 = mysql_fetch_array($res_hh2);
									
									$headlines .= stripslashes($data_hh2['cat_name']).", ";
								}
								
								if ( ifint($_GET['STcat']) != "" && ifint($_GET['STcat']) != "0" )
								{
									$sql = "SELECT cat_name FROM user_guide_cats WHERE id = '".ifint($_GET['STcat'])."'";
									$res_hh3 = mysql_db_query(DB, $sql);
									$data_hh3 = mysql_fetch_array($res_hh3);
									
									$headlines .= stripslashes($data_hh3['cat_name']).", ";
								}
								
								$tempHeadline = indexSite__global_settings("bizIndexCatColor");
								echo "<tr>";
									echo "<td height='24' background='/upload_pics/Image/otherImagesCore/dupli_headline_area.jpg' width='552' style='font-size: 13px; color: #".$tempHeadline."; font-family: arial;' align=right>";
									echo "<b style='padding: 4px;'>".substr($headlines , 0 , -2)."</b></td>";
								echo "</tr>";
								
								if( $_GET['city'] != "" )
								{
									$city_qry = ( ifint($_GET['city']) != "" && ifint($_GET['city']) != "0" ) ? " bcity.city_id = '".ifint($_GET['city'])."' AND bcity.biz_id = b.id AND " : "";
									$table = ", user_guide_choosen_biz_city as bcity";
								}
								
								$guide_qry = ( ifint($_GET['guide']) != "" && ifint($_GET['guide']) != "0" ) ? " b_g.guide_id = '".ifint($_GET['guide'])."' AND" : "";
								$cat_qry2 = ( ifint($_GET['Scat']) != "" && ifint($_GET['Scat']) != "0" ) ? "AND b_c.cat_id = '".ifint($_GET['Scat'])."' " : "";
								$cat_qry = ( ifint($_GET['STcat']) != "" && ifint($_GET['STcat']) != "0" ) ? "AND b_c.cat_id = '".ifint($_GET['STcat'])."' " : $cat_qry2;
								
								$sql = "SELECT b.*
												FROM 
													user_guide_business as b , user_guide_choosen_biz_guide as b_g , user_guide_choosen_biz_cat as b_c ".$table."
												WHERE 
													b.deleted=0 AND
													b.active=0 AND
													b.unk = '".UNK."' AND 
													b.id=b_g.biz_id AND
													".$guide_qry."
													".$city_qry."
													b.id=b_c.biz_id
													".$cat_qry."
												GROUP BY b.id ORDER BY b.premium DESC, b.priority";
								$res_b = mysql_db_query(DB, $sql);
								$nums = mysql_num_rows($res_b);
								
								$count = 0;
								
								echo "<tr>";
									echo "<td valign=top>";
										echo "<table cellpadding=0 cellspacing=0 border=0 class='maintext' width=100%>";
											while( $data_b = mysql_fetch_array($res_b) )
											{
												$premium = ($data_b['premium'] == "1" ) ? " style='background-color:".indexSite__global_settings("bizIndexPremiumBg")."'" : "";
												
												if( file_exists(SERVER_PATH."/upload_pics/Image/otherImagesCore/prem_arrow.png") )
													$headline_arrow = ($data_b['premium'] == "1" ) ? "<img src='/upload_pics/Image/otherImagesCore/prem_arrow.png' alt='' border='0'>" : "";
												
												echo "<tr ".$premium."><td height=5></td></tr>";
												echo "<tr ".$premium.">";
													echo "<td style='padding-right: 7px;'>";
														if( $headline_arrow != "" )
														{
															echo "<table cellpadding=0 cellspacing=0 border=0 class='maintext'>";
																echo "<tr>";
																	echo "<td style='padding-top:9px;'>".$headline_arrow."</td>";
																	echo "<td width=5></td>";
																	echo "<td><b>".stripslashes($data_b['business_name'])."</b></td>";
																echo "</tr>";
															echo "</table>";
														}
														else
															echo "<b>".stripslashes($data_b['business_name'])."</b>";
													echo "</td>";
												echo "</tr>";
												echo "<tr ".$premium."><td height=10></td></tr>";
												echo "<tr>";
													echo "<td valign=top>";
														echo "<table cellpadding=0 cellspacing=0 border=0 class='maintext' width=100%>";
															echo "<tr><td colspan=5 height=10></td></tr>";
															echo "<tr>";
																echo "<td width=10></td>";
																echo "<td valign=top>".nl2br(stripslashes($data_b['summery']))."</td>";
																echo "<td width=30></td>";
																echo "<td valign=top width=250>";
																	
																	
																	$sql = "SELECT g.cat_name, g.id FROM user_guide_cats AS g, user_guide_choosen_biz_cat as cg WHERE
																	g.id = cg.cat_id AND biz_id = '".$data_b['id']."' AND cat_id != '".$_GET['Scat']."' AND cat_id != '".$_GET['STcat']."'";
																	$resCats = mysql_db_query(DB,$sql);
																	
																	$str_cat = "";
																	while( $dataCats = mysql_fetch_array($resCats) )
																		$str_cat .= stripslashes($dataCats['cat_name']) . ", ";
																	
																	if( strlen($str_cat) > 2 )
																	{
																		echo "<b>סיווגים נוספים:</b><br>";
																		echo substr( $str_cat , 0 , -2 );
																	}
																	
																echo "</td>";
																echo "<td width=10></td>";
															echo "</tr>";
														echo "</table>";
													echo "</td>";
												echo "</tr>";
												echo "<tr><td height=10></td></tr>";
												echo "<tr>";
													echo "<td align=left>";
														echo "<table cellpadding=0 cellspacing=0 border=0 class='maintext' class=maintext>";
															echo "<tr>";
																//$path_negev = $server_path.$data_b['id']."/".$data_b['img1'];
																//if( is_file($path_negev) )
																	//echo "<td background='/upload_pics/Image/otherImagesCore/button_orange.jpg' width='89' height=23 style='background-repeat: no-repeat;' align=center><a href='/new_images/".$data_b['id']."/".$data_b['img1']."' class='maintext' target='_blank' style='text-decoration:none;'><b>נגבפון</b></a></td>";
																
																$path_bikor = $server_path.$data_b['id']."/".$data_b['img2'];
																if( is_file($path_bikor) )
																{
																	echo "<td width=10></td>";
																	echo "<td background='/upload_pics/Image/otherImagesCore/button_orange.jpg' width='89' height=23 style='background-repeat: no-repeat;' align=center><a href='/new_images/".$data_b['id']."/".$data_b['img2']."' class='maintext' target='_blank' style='text-decoration:none;'><b>קופון</b></a></td>";
																}
																
																echo "<td width=10></td>";
																echo "<td background='/upload_pics/Image/otherImagesCore/button_orange.jpg' width='89' height=23 style='background-repeat: no-repeat;' align=center><a href='index.php?m=KgBm_p&pid=".$data_b['id']."&guide=".$_GET['guide']."' class='maintext' style='text-decoration:none;'><b>מידע מורחב</b></a></td>";
																
																if( $data_b['website'] != '' )
																{
																	if( eregi( "http://" , $data_b['website'] ) )
																		$website = $data_b['website'];
																	else
																		$website = "http://".$data_b['website'];
																	
																	echo "<td width=10></td>";
																	echo "<td background='/upload_pics/Image/otherImagesCore/button_orange.jpg' width='89' height=23 style='background-repeat: no-repeat;' align=center><a href='".$website."' class='maintext' target='_blank' style='text-decoration:none;'><b>אתר</b></a></td>";
																}
																echo "<td width=10></td>";
															echo "</tr>";
														echo "</table>";
													echo "</td>";
												echo "</tr>";
												echo "<tr><td height=10></td></tr>";
												
												$count++ ;
												
												if( $nums != $count )
												echo "<tr><td><hr width=100% size=1 color=#000000 style='padding:0px; margin:0px;'></td></tr>";
												
												
											}
										echo "</table>";
									echo "</td>";
								echo "</tr>";
								
							echo "</table>";
						echo "</td>";
						
						//echo "<td width=3></td>";
						
						/*echo "<td width=142 valign=top>";
							echo "<table cellpadding=0 cellspacing=0 border=0 class='maintext' width=142 height=100% style='border: 1px solid #000;'>";
								echo "<tr>";
									echo "<td height='24' background='/upload_pics/Image/otherImagesCore/dupli_headline_area.jpg' width='142' style='font-size: 13px; color: #ff8c25; font-family: arial;' align=center>";
									echo "<b style='padding: 4px;'>סיווגים קשורים</b></td>";
								echo "</tr>";
								
								echo "<tr><td height=15></td></tr>";
								
								$sql = "SELECT id, cat_name FROM user_guide_cats WHERE unk = '".UNK."' AND deleted=0 AND active=0 AND father=".ifint($_GET['Scat'])." ORDER BY cat_name";
								$res = mysql_db_query(DB,$sql);
								
								echo "<tr>";
									echo "<td valign=top>";
										echo "<table cellpadding=0 cellspacing=0 border=0 class='maintext' width=100%>";
											while( $data = mysql_fetch_array($res) )
											{
												$choose_Scat = ( ifint($_GET['Scat']) == "0" ) ? $data['id'] : ifint($_GET['Scat']);
												echo "<tr>";
													echo "<td align=center><a href='index.php?m=KgBm&Scat=".$choose_Scat."&STcat=".$data['id']."&guide=".ifint($_GET['guide'])."' class='maintext' style='text-decoration:none;'>".stripslashes($data['cat_name'])."</a></td>";
												echo "</tr>";
												echo "<tr><td height=10></td></tr>";
											}
										echo "</table>";
									echo "</td>";
								echo "</tr>";
								
							echo "</table>";
							
						echo "</td>";*/
					echo "</tr>";
				echo "</table>";
			echo "</td>";
		echo "</tr>";
		
		
	echo "</table>";
}

function kolaNegev_guide_biz_profile()
{
	if( $_SERVER[REMOTE_ADDR] == "93.172.234.29" )
	{
		// עיצוב החדש של דף עסק
		kolaNegev_guide_biz_profile_desige();
		exit;
	}
	$sql = "SELECT * FROM user_guide_business WHERE unk = '".UNK."' AND id = '".ifint($_GET['pid'])."' ";
	$res = mysql_db_query(DB,$sql);
	$data = mysql_fetch_array($res);
	
	$sql = "SELECT domain FROM users WHERE unk = '".UNK."' ";
	$res = mysql_db_query(DB,$sql);
	$userData = mysql_fetch_array($res);
	
	$server_path = "/home/ilan123/domains/".$userData['domain']."/public_html/new_images/";
	
	echo "<table cellpadding=0 cellspacing=0 border=0 class='maintext' width=552>";
		/*echo "<tr>";
			echo "<td>";
			echo "<table cellpadding=0 cellspacing=0 border=0 class='maintext'>";
					echo "<tr>";
						
						$banners = guide_banners("inner" , ifint($_GET['guide']) );
						
						$count = 0;
						foreach( $banners as $key => $val )
						{
							
							echo "<td width=171 height=247 style='border: 1px solid #000;'>";
								echo "<table cellpadding=10 cellspacing=0 border=0 class='maintext' align=center>";
									echo "<tr>";
										echo "<td>".$val."</td>";
									echo "</tr>";
								echo "</table>";
							echo "</td>";
							
							$count++ ;
							
							if( $count != 3 )
								echo "<td width=20></td>";
						}
					echo "</tr>";
				echo "</table>";
			echo "</td>";
		echo "</tr>";
		echo "<tr><td height=10></td></tr>";*/
		echo "<tr>";
			echo "<td><h2>".stripslashes($data['business_name'])."</h2></td>";
		echo "</tr>";
		echo "<tr><td height=10></td></tr>";
		echo "<tr>";
			echo "<td>";
				echo "<table cellpadding=0 cellspacing=0 border=0 class='maintext' width=100%>";
					echo "<tr>";
						echo "<td style='font-size: 14px; font-weight:bold;' align=right valign=top>";
							echo "<font style='font-size: 16px; color: #ff8c25; font-family: arial; font-weight:bold;'>פרטי העסק:</font><br><br>";
							if( !empty($data['phone']) )
								echo "טלפון: ".stripslashes($data['phone'])."<br>";
							if( !empty($data['email']) )
								echo "דואר אלקטרוני: ".stripslashes($data['email'])."<br>";
							if( !empty($data['website']) )
							{
								if( eregi( "http://" , $data['website'] ) )	$website = $data['website'];
								else		$website = "http://".$data['website'];
								
								echo "אתר אינטרנט: <a href='".$website."' class='maintext' target='_blank'>".stripslashes($data['website'])."</a><br>";
							}
							
							$sql = "SELECT c.city_name FROM user_guide_cities AS c , user_guide_choosen_biz_city as c_b WHERE c.unk = '".UNK."' AND c_b.biz_id='".$data['id']."' AND c_b.city_id = c.id";
							$res_Cc = mysql_db_query(DB,$sql);
							$data_Cc = mysql_fetch_array($res_Cc);
							
							if( !empty($data_Cc['city_name']) )
								echo "עיר: ".stripslashes($data_Cc['city_name'])."<br>";
							
						echo "</td>";
						echo "<td align=left valign=top>";
							$path_logo = $server_path.$data['id']."/".$data['logo'];

							if( is_file($path_logo) )
								echo "<img src='/new_images/".$data['id']."/".$data['logo']."' border=0 alt='".stripslashes($data['business_name'])."' title='".stripslashes($data['business_name'])."'>";
						echo "</td>";
					echo "</tr>";
					echo "<tr><td height=20></td></tr>";
					echo "<tr>";
						echo "<td style='font-size: 14px; font-weight:bold;' align=right valign=top>";
							echo "<font style='font-size: 16px; color: #ff8c25; font-family: arial; font-weight:bold;'>שירותי העסק:</font><br>";
							echo nl2br(stripslashes($data['summery']));
						echo "</td>";
						echo "<td align=left valign=top>";
							//echo "<a href='index.php?m=sa&kolId=".$data['id']."'><img src='/upload_pics/Image/otherImagesCore/gotoSales.jpg' border=0 alt=''></a>";
						echo "</td>";
					echo "</tr>";
					echo "<tr><td height=20></td></tr>";
					echo "<tr>";
						echo "<td style='font-size: 14px;' align=right valign=top>";
							echo "<font style='font-size: 16px; color: #ff8c25; font-family: arial; font-weight:bold;'>פרופיל:</font><br>";
							echo nl2br(stripslashes($data['description']));
						echo "</td>";
						echo "<td align=left valign=top style='padding-top: 20px;'>";
							$path_img3 = $server_path.$data['id']."/".$data['img3'];

							if( is_file($path_img3) )
							{
								$exte = substr($data['img3'],(strpos($data['img3'],".")+1));
								$temp = explode("." , $data['img3'] );
								$large_img3 = $temp[0]."-large.".$exte;
								$path_img3_large = $server_path.$data['id']."/".$large_img3;
								
								if( is_file($path_img3_large) )
									echo "<a href='/new_images/".$data['id']."/".$large_img3."' target='_blank'><img src='/new_images/".$data['id']."/".$data['img3']."' border=0 alt=''></a>";
								else
									echo "<img src='/new_images/".$data['id']."/".$data['img3']."' border=0 alt=''>";
							}
						echo "</td>";
					echo "</tr>";
					
				echo "</table>";
			echo "</td>";
		echo "</tr>";
		echo "<tr><td height=20></td></tr>";
		
		if( $data['video_code'] != "" )
			$video_url = str_replace( "&" , "&amp;" , stripslashes($data['video_code']) );
		else
			$video_url = "";
		
		if( $video_url != "" )
		{
			echo "<tr>";
				echo "<td>";
					echo "<table cellpadding=0 cellspacing=0 border=0 class='maintext' width=100%>";
						echo "<tr>";
							echo "<td align=right valign=top>";
								echo "<font style='font-size: 16px; color: #ff8c25; font-family: arial; font-weight:bold;'>וידיאו:</font><br>";
							echo "</td>";
						echo "</tr>";
						echo "<tr><td height=5></td></tr>";
						echo "<tr>";
							echo "<td align=right valign=top>";
							
								echo '<div id="youtubeVid125"></div>';
								echo '<script type="text/javascript">loadSWFwithBase("'.$video_url.'","youtubeVid125","425","344","#","youtubeVid125")</script>';
																
							echo "</td>";
						echo "</tr>";
						
					echo "</table>";
				echo "</td>";
			echo "</tr>";
		}
		
		if( !is_file($path_logo) )
		{
			echo "<tr>";
				echo "<td style='font-size: 14px;'>";
					echo indexSite__global_settings("bizIndexWannaBeOne",stripslashes($data['business_name']));
				echo "</td>";
			echo "</tr>";
		}

	echo "</table>";
}



function kolaNegev_guide_biz_profile_desige()
{
	$sql = "SELECT * FROM user_guide_business WHERE unk = '".UNK."' AND id = '".ifint($_GET['pid'])."' ";
	$res = mysql_db_query(DB,$sql);
	$data = mysql_fetch_array($res);
	
	$sql = "SELECT domain FROM users WHERE unk = '".UNK."' ";
	$res = mysql_db_query(DB,$sql);
	$userData = mysql_fetch_array($res);
	
	$server_path = "/home/ilan123/domains/".$userData['domain']."/public_html/new_images/";
	
	$sql = "SELECT c.city_name FROM user_guide_cities AS c , user_guide_choosen_biz_city as c_b WHERE c.unk = '".UNK."' AND c_b.biz_id='".$data['id']."' AND c_b.city_id = c.id";
	$res_Cc = mysql_db_query(DB,$sql);
	$data_Cc = mysql_fetch_array($res_Cc);
	
	$style_border_No_bottom = "style='border: 1px solid #d2d5da; border-bottom: 0px;'";
	$style_border_No_bottom_right = "style='border: 1px solid #d2d5da; border-bottom: 0px; border-right: 0px;'";
	$style_border = "style='border: 1px solid #d2d5da;'";
	$style_border_No_right = "style='border: 1px solid #d2d5da; border-right: 0px;'";
	echo "<table cellpadding=0 cellspacing=0 border=0 class='maintext' width=552>";
		
		echo "<tr>";
			echo "<td>";
				echo "<table cellpadding=0 cellspacing=0 border=0 class='maintext'>";
					
					echo "<tr>";
						echo "<td>";
							echo "<table cellpadding=0 cellspacing=0 border=0 class='maintext'>";
								echo "<tr>";
									echo "<td colspan='2' height='5' bgcolor='#dde2e6' ".$style_border_No_bottom."></td>";
								echo "</td>";
								echo "<tr>";
									echo "<td colspan=2 bgcolor='#f4f4f4' ".$style_border_No_bottom." align=center><h2 style='padding: 2px; margin: 0px;'>".stripslashes($data['business_name'])."</h2></td>";
								echo "</td>";
								
								if( !empty($data['phone']) )
								{
									echo "<tr>";
										echo "<td width=150 ".$style_border_No_bottom." bgcolor='#f4f4f4'>טלפון</td>";
										echo "<td ".$style_border_No_bottom_right.">".stripslashes($data['phone'])."</td>";
									echo "</td>";
								}
								if( !empty($data['email']) )
								{
									echo "<tr>";
										echo "<td width=150 ".$style_border_No_bottom." bgcolor='#f4f4f4'>דואר אלקטרוני:</td>";
										echo "<td ".$style_border_No_bottom_right.">".stripslashes($data['email'])."</td>";
									echo "</td>";
								}
								if( !empty($data['website']) )
								{
									if( eregi( "http://" , $data['website'] ) )	$website = $data['website'];
									else		$website = "http://".$data['website'];
									
									echo "<tr>";
										echo "<td width=150 ".$style_border_No_bottom." bgcolor='#f4f4f4'>אתר אינטרנט</td>";
										echo "<td ".$style_border_No_bottom_right."><a href='".$website."' class='maintext' target='_blank'>".stripslashes($data['website'])."</a></td>";
									echo "</td>";
								}
								
								if( !empty($data_Cc['city_name']) )
								{
									echo "<tr>";
										echo "<td width=150 ".$style_border." bgcolor='#f4f4f4'>עיר</td>";
										echo "<td ".$style_border_No_right.">".stripslashes($data_Cc['city_name'])."</td>";
									echo "</td>";
								}
								
							echo "</table>";
						echo "</td>";
					echo "</td>";
					echo "<tr><td height=15></td></tr>";
					echo "<tr>";
						echo "<td>";
						
						echo "</td>";
					echo "</td>";
					echo "<tr><td height=15></td></tr>";
					echo "<tr>";
						echo "<td>";
						
						echo "</td>";
					echo "</td>";
					echo "<tr><td height=15></td></tr>";
					echo "<tr>";
						echo "<td>";
						
						echo "</td>";
					echo "</td>";
					
				echo "</table>";
			echo "</td>";
			echo "<td width=20></td>";
			
			echo "<td>";
			
			echo "</td>";
			
		echo "</tr>";
		
		
		
		
		
		
		echo "<tr>";
			echo "<td><h2>".stripslashes($data['business_name'])."</h2></td>";
		echo "</tr>";
		echo "<tr><td height=10></td></tr>";
		echo "<tr>";
			echo "<td>";
				echo "<table cellpadding=0 cellspacing=0 border=0 class='maintext' width=100%>";
					echo "<tr>";
						echo "<td style='font-size: 14px; font-weight:bold;' align=right valign=top>";
							echo "<font style='font-size: 16px; color: #ff8c25; font-family: arial; font-weight:bold;'>פרטי העסק:</font><br><br>";
							if( !empty($data['phone']) )
								echo "טלפון: ".stripslashes($data['phone'])."<br>";
							if( !empty($data['email']) )
								echo "דואר אלקטרוני: ".stripslashes($data['email'])."<br>";
							if( !empty($data['website']) )
							{
								if( eregi( "http://" , $data['website'] ) )	$website = $data['website'];
								else		$website = "http://".$data['website'];
								
								echo "אתר אינטרנט: <a href='".$website."' class='maintext' target='_blank'>".stripslashes($data['website'])."</a><br>";
							}
							
							$sql = "SELECT c.city_name FROM user_guide_cities AS c , user_guide_choosen_biz_city as c_b WHERE c.unk = '".UNK."' AND c_b.biz_id='".$data['id']."' AND c_b.city_id = c.id";
							$res_Cc = mysql_db_query(DB,$sql);
							$data_Cc = mysql_fetch_array($res_Cc);
							
							if( !empty($data_Cc['city_name']) )
								echo "עיר: ".stripslashes($data_Cc['city_name'])."<br>";
							
						echo "</td>";
						echo "<td align=left valign=top>";
							$path_logo = $server_path.$data['id']."/".$data['logo'];

							if( is_file($path_logo) )
								echo "<img src='/new_images/".$data['id']."/".$data['logo']."' border=0 alt='".stripslashes($data['business_name'])."' title='".stripslashes($data['business_name'])."'>";
						echo "</td>";
					echo "</tr>";
					echo "<tr><td height=20></td></tr>";
					echo "<tr>";
						echo "<td style='font-size: 14px; font-weight:bold;' align=right valign=top>";
							echo "<font style='font-size: 16px; color: #ff8c25; font-family: arial; font-weight:bold;'>שירותי העסק:</font><br>";
							echo nl2br(stripslashes($data['summery']));
						echo "</td>";
						echo "<td align=left valign=top>";
							//echo "<a href='index.php?m=sa&kolId=".$data['id']."'><img src='/upload_pics/Image/otherImagesCore/gotoSales.jpg' border=0 alt=''></a>";
						echo "</td>";
					echo "</tr>";
					echo "<tr><td height=20></td></tr>";
					echo "<tr>";
						echo "<td style='font-size: 14px;' align=right valign=top>";
							echo "<font style='font-size: 16px; color: #ff8c25; font-family: arial; font-weight:bold;'>פרופיל:</font><br>";
							echo nl2br(stripslashes($data['description']));
						echo "</td>";
						echo "<td align=left valign=top style='padding-top: 20px;'>";
							$path_img3 = $server_path.$data['id']."/".$data['img3'];

							if( is_file($path_img3) )
							{
								$exte = substr($data['img3'],(strpos($data['img3'],".")+1));
								$temp = explode("." , $data['img3'] );
								$large_img3 = $temp[0]."-large.".$exte;
								$path_img3_large = $server_path.$data['id']."/".$large_img3;
								
								if( is_file($path_img3_large) )
									echo "<a href='/new_images/".$data['id']."/".$large_img3."' target='_blank'><img src='/new_images/".$data['id']."/".$data['img3']."' border=0 alt=''></a>";
								else
									echo "<img src='/new_images/".$data['id']."/".$data['img3']."' border=0 alt=''>";
							}
						echo "</td>";
					echo "</tr>";
					
				echo "</table>";
			echo "</td>";
		echo "</tr>";
		echo "<tr><td height=20></td></tr>";
		
		if( $data['video_code'] != "" )
			$video_url = str_replace( "&" , "&amp;" , stripslashes($data['video_code']) );
		else
			$video_url = "";
		
		if( $video_url != "" )
		{
			echo "<tr>";
				echo "<td>";
					echo "<table cellpadding=0 cellspacing=0 border=0 class='maintext' width=100%>";
						echo "<tr>";
							echo "<td align=right valign=top>";
								echo "<font style='font-size: 16px; color: #ff8c25; font-family: arial; font-weight:bold;'>וידיאו:</font><br>";
							echo "</td>";
						echo "</tr>";
						echo "<tr><td height=5></td></tr>";
						echo "<tr>";
							echo "<td align=right valign=top>";
							
								echo '<div id="youtubeVid125"></div>';
								echo '<script type="text/javascript">loadSWFwithBase("'.$video_url.'","youtubeVid125","425","344","#","youtubeVid125")</script>';
																
							echo "</td>";
						echo "</tr>";
						
					echo "</table>";
				echo "</td>";
			echo "</tr>";
		}
		
		if( !is_file($path_logo) )
		{
			echo "<tr>";
				echo "<td style='font-size: 14px;'>";
					echo indexSite__global_settings("bizIndexWannaBeOne",stripslashes($data['business_name']));
				echo "</td>";
			echo "</tr>";
		}

	echo "</table>";
}


function guide_banners( $location , $location_id = "0" , $display="")
{
	$location_idQ = ( $location_id != "0" ) ? "AND location_id = '".$location_id."' " : "";
	$location_idQ2 = ( $location == "inner" ) ? "ORDER BY RAND() LIMIT 3 " : "ORDER BY RAND() LIMIT 1";
	
	$cat_qry2 = ( ifint($_GET['Scat']) != "" && ifint($_GET['Scat']) != "0" ) ? "AND bc.cat_id = '".ifint($_GET['Scat'])."' " : "";
	$cat_qry = ( ifint($_GET['STcat']) != "" && ifint($_GET['STcat']) != "0" ) ? "AND bc.cat_id = '".ifint($_GET['STcat'])."' " : $cat_qry2;
	
	if( $location == "up" )
	{
		$sql = "SELECT id, img1 , views, web_url FROM user_banners_guide WHERE unk = '".UNK."' AND deleted=0 AND location = '".$location."' ".$location_idQ." ".$location_idQ2."";
	}
	else
	{
		if( $cat_qry == "" )
		{
			$sql = "SELECT id, img1 , views, web_url FROM user_banners_guide WHERE unk = '".UNK."' AND deleted=0 AND location = '".$location."' ".$location_idQ." ".$location_idQ2."";
		}
		else
		{
			$sql = "SELECT id, img1 , views, web_url FROM user_banners_guide as ub , banner_choosen_biz_cat as bc  WHERE
			ub.unk = '".UNK."' AND deleted=0 AND
				bc.banner_id = ub.id
				".$cat_qry." AND
		 	location = '".$location."' ".$location_idQ." ".$location_idQ2."";
		}
	}
	
	$res = mysql_db_query(DB,$sql);
	
	$banner_arr = array();
	
	while( $data = mysql_fetch_array($res) )
	{
		$abpath_temp = SERVER_PATH."/new_images/banners/".$data['img1'];
		if( file_exists($abpath_temp) && !is_dir($abpath_temp) )
		{
			$im_size = GetImageSize($abpath_temp); 
			$imageWidth = $im_size[0]; 

			if( $location == "up" )
				$imageHeight = "90";
			else
				$imageHeight = $im_size[1];
			
			if( eregi(".swf" , $data['img1'] ) )
			{
				$code = "<div id=\"guide_banner_".$data['id']."\"></div>";
				$code .= "<script type=\"text/javascript\">";
					$code .= "swfPlayer(\"/new_images/banners/".stripslashes($data['img1'])."\",\"guide_banner_".$data['id']."\",\"".$imageWidth."\",\"".$imageHeight."\",\"#\",\"guide_banner_".$data['id']."\");";
				$code .= "</script>";
			}
			else
			{
				if( eregi("http://" , $data['web_url'] ) )	$a_T = $data['web_url'];
				else	$a_T = "http://".$data['web_url'];
				
				$a_start = ( $data['web_url'] != "" ) ? "<a href='".$a_T."' target='_blank'>" : "";
				$a_end = ( $data['web_url'] != "" ) ? "</a>" : "";
				$code = $a_start."<img src='/new_images/banners/".$data['img1']."' border=0 alt=0 width='".$imageWidth."' height='".$imageHeight."'>".$a_end;
			}
			
			$views = $data['views'] + 1;
			$sql = "UPDATE user_banners_guide SET views = '".$views."' WHERE id = '".$data['id']."'";
			$res2 = mysql_db_query(DB,$sql);
			
			$banner_arr[] = $code;
		}
	}
	
	if( $display == "view" )
		echo $code;
	else
		return $banner_arr;
}


function kolaNegev_guideAddNew()
{
	
	$sql = "SELECT guide_name, id FROM user_guide WHERE unk='".UNK."' ORDER BY guide_name";
	$res_guideId = mysql_db_query(DB,$sql);
	
	$selected_guideId = "";
	while( $data_guideId = mysql_fetch_array($res_guideId) )
	{
		$guideId = $data_guideId['id'];
		$guide_id[$guideId] = stripslashes($data_guideId['guide_name']);			
	}
	
	
	$sql = "SELECT city_name, id FROM user_guide_cities WHERE unk='".UNK."' and deleted=0 ORDER BY city_name";
	$res_cities = mysql_db_query(DB,$sql);
	
	$selected_cityId = "";
	while( $data_cities = mysql_fetch_array($res_cities) )
	{
		$cityId = $data_cities['id'];
		$city[$cityId] = stripslashes($data_cities['city_name']);
	}
	
	if( $data['id'] != "" )
	{
		$cats = array("blank" , "<a href='guide_cats.php?unk=".UNK."&sesid=".SESID."&biz_id=".$data['id']."' class='maintext' target='_blank'>קטגוריות</a>");
	}
	
	
	$form_arr = array(
		array("hidden","m","KgAdGU"),
		array("hidden","data_arr[unk]",UNK),
		array("hidden","data_arr[active]","1"),
		
		array("select","guide_id[]",$guide_id,"שם המדריך","","guide_id[]", "class='input_style' style='height: 18px;'"),
		$cats,
		
		array("text","data_arr[business_name]","","* שם העסק", "class='input_style'"),
		
		array("select","city[]",$city,"עיר","","cities[]", "class='input_style' style='height: 18px;'"),
		
		array("text","data_arr[phone]","","* טלפון", "class='input_style'"),
		array("text","data_arr[email]","","אימייל", "class='input_style'"),
		array("text","data_arr[website]","","אתר אינטרנט", "class='input_style'"),
		
		array("textarea","data_arr[summery]","","שירותי העסק", "class='input_style' style='width: 300px; height: 100px;'"),
		array("textarea","data_arr[description]","","פרופיל", "class='input_style' style='width: 300px; height: 300px;'"),
		
		array("submit","submit","שליחה", "class='submit_style'")
	);
	
	// שדות חובה
	$mandatory_fields = array("data_arr[business_name]","data_arr[phone]");
	$more = "class='maintext' border='0'";
	
	echo "<table cellpadding=0 cellspacing=0 border=0 class='maintext' width=100%>";
		echo "<tr>";
			echo "<td>";
				echo "<h2>הוספת עסק למדריך</h2>";
			echo "</td>";
		echo "</tr>";
		echo "<tr>";
			echo "<td>";
				echo "<p style='padding:0 margin:0; font-size: 11px;'>* שדות חובה</p>";
			echo "</td>";
		echo "</tr>";
		echo "<tr>";
			echo "<td>";
				echo FormCreator::create_form($form_arr,"index.php", $more, $mandatory_fields, "editorhtml");
			echo "</td>";
		echo "</tr>";
	echo "</table>";

}

function kolaNegev_guideAddNew_DB()
{
	$image_settings = array(
		"after_success_goto" => "DO_NOTHING",
		"table_name" => "user_guide_business",
	);
	$data_arr = ($_POST['data_arr'])? $_POST['data_arr'] : $_GET['data_arr'];
	
	insert_to_db($data_arr, $image_settings);
	$record_id = mysql_insert_id();
		
	foreach( $_POST['guide_id'] as $val => $key )
	{
		$sql = "insert into user_guide_choosen_biz_guide ( biz_id , guide_id ) values ( '".$record_id."' , '".$key."' )";
		$res_insert = mysql_db_query(DB,$sql);
	}
	
	foreach( $_POST['cities'] as $val => $key )
	{
		$sql = "insert into user_guide_choosen_biz_city ( biz_id , city_id ) values ( '".$record_id."' , '".$key."' )";
		$res_insert2 = mysql_db_query(DB,$sql);
	}
	
	echo "<script>window.location.href='index.php?m=KgAdGT';</script>";
		exit;
}


function kolaNegev_guideAddNew_thanks()
{
	echo "<p>".indexSite__global_settings("thanksAddBiz")."</p>";
}


function indexSite__global_settings($settingValue , $more="")
{
	switch($settingValue)
	{
		case "headTitle1" :		switch(UNK)		{		// כותרת title
				case "263512086634836547" :		 $ret = "קול הנגב  ";	break;
				case "071512107783122948" :		 $ret = "פורטל ההסעות  ";	break;
				case "161819904213378395" :		 $ret = "פורטל רופאי השיניים  ";	break;
				case "892416832482956591" :		 $ret = "פורטל לאן יוצאים לאכול  ";	break;
				case "192202924562351192" :		 $ret = "פורטל באר שבע  ";	break;
				case "506993621038532664" :		 $ret = "פורטל באר שבע  ";	break;
				case "932937850555019039" :		 $ret = "פורטל התיירות  ";	break;
				case "356346773816936457" :		 $ret = "שכונת נווה זאב  ";	break;
				case "577342662741077724" :		 $ret = "פסק דין  ";	break;
		}		break;
		
		case "headTitleAdd" :		switch(UNK)		{		// כותרת title
				case "263512086634836547" :		 $ret = "הוסף עסק למדריך  ";	break;
				case "071512107783122948" :		 $ret = "הוסף עסק  ";	break;
				case "161819904213378395" :		 $ret = "הוסף עסק  ";	break;
				case "892416832482956591" :		 $ret = "הוסף עסק  ";	break;
				case "192202924562351192" :		 $ret = "הוסף עסק  ";	break;
				case "506993621038532664" :		 $ret = "הוסף עסק  ";	break;
				case "932937850555019039" :		 $ret = "הוסף עסק  ";	break;
				case "356346773816936457" :		 $ret = "הוסף עסק  ";	break;
				case "577342662741077724" :		 $ret = "הוסף עסק  ";	break;
		}		break;
		
		case "headTitleHP" :		switch(UNK)		{		// כותרת title
				case "071512107783122948" :		 $ret = "פורטל הסעות ישראל,אוטובוסים לטיולים,מיניבוסים לאירועים,מבצעי הסעות";	break;
				case "161819904213378395" :		 $ret = "פורטל רופאי שיניים,אינדקס מרפאות שיניים,מבצעים טיפולי שיניים,שיקום הפה";	break;
				case "892416832482956591" :		 $ret = "פורטל לאן יוצאים לאכול בישראל ?";	break;
				case "192202924562351192" :		 $ret = "באר שבע עסקים, אינדקס עסקים, מבצעים ודרושים   ";	break;
				case "506993621038532664" :		 $ret = "פורטל הובלות ישראל,מבצעים,אינדקס חברות הובלה,מחירון   ";	break;
				case "932937850555019039" :		 $ret = "פורטל התיירות של ישראל   ";	break;
				case "356346773816936457" :		 $ret = "שכונת נווה זאב   ";	break;
				case "577342662741077724" :		 $ret = "פסק דין   ";	break;
		}		break;
		
		case "indexHomepageBottomLinks" :		switch(UNK)		{		// קישורים למטה בעמוד בית מיוחד לאינדקסים
				case "071512107783122948" :		 
					$ret = "<a href='http://www.egged.co.il/' class='maintext' style='text-decoration: none; color: #01567d;' target='_blank'>אגד</a> אוטובוסים";
					$ret .= "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
					$ret .= "אוטובוסים <a href='http://www.metropoline.com/' class='maintext' style='text-decoration: none; color: #01567d;' target='_blank'>מטרופולין</a>";
					$ret .= "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
					$ret .= "אוטובוס <a href='http://www.kavim-t.co.il/home/' class='maintext' style='text-decoration: none; color: #01567d;' target='_blank'>קווים</a>";
					$ret .= "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
					$ret .= "<a href='http://www.dan.co.il/' class='maintext' style='text-decoration: none; color: #01567d;' target='_blank'>דן</a> הסעות";
					$ret .= "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
				break;
		}		break;
		
		case "QueryHomepageBizWithGuideId" :		switch(UNK)		{		// שאילתא בעמוד הבית, הבוחרת עסקים עם מדריך בלבד, יש למלאות מספר עיקבי של הרשומה
				case "071512107783122948" :		 	$ret = "b_g.guide_id = '9' AND";		break;
				case "161819904213378395" :		 	$ret = "b_g.guide_id = '10' AND";		break;
				case "892416832482956591" :		 	$ret = "b_g.guide_id = '11' AND";		break;
				case "192202924562351192" :		 	$ret = "b_g.guide_id = '12' AND";		break;
				case "506993621038532664" :		 	$ret = "b_g.guide_id = '13' AND";		break;
				case "932937850555019039" :		 	$ret = "b_g.guide_id = '14' AND";		break;
				case "356346773816936457" :		 	$ret = "b_g.guide_id = '16' AND";		break;
				case "577342662741077724" :		 	$ret = "b_g.guide_id = '17' AND";		break;
		}		break;
		
		case "bizIndexCatColor" :		switch(UNK)		{		// צבע פונט כותרת של הקטגוריה ברשימת עסקים
				case "263512086634836547" :		 	$ret = "ff8c25";		break;
				case "071512107783122948" :		 	$ret = "000000";		break;
				case "161819904213378395" :		 	$ret = "000000";		break;
				case "892416832482956591" :		 	$ret = "000000";		break;
				case "192202924562351192" :		 	$ret = "000000";		break;
				case "506993621038532664" :		 	$ret = "000000";		break;
				case "932937850555019039" :		 	$ret = "000000";		break;
				case "356346773816936457" :
				case "577342662741077724" :		 	$ret = "000000";		break;
		}		break;
		
		
		case "bizIndexPremiumBg" :		switch(UNK)		{		// רשימת עסקים צבע רקע של עסקי פרימיום
				case "263512086634836547" :		 	$ret = "yellow";		break;
				case "071512107783122948" :		 	$ret = "#def2fd";		break;
				case "161819904213378395" :		 	$ret = "#ffe7c9";		break;
				case "892416832482956591" :		 	$ret = "#ffe7c9";		break;
				case "192202924562351192" :		 	$ret = "#ffe7c9";		break;
				case "506993621038532664" :		 	$ret = "#ffe7c9";		break;
				case "932937850555019039" :		 	$ret = "#ffe7c9";		break;
				case "577342662741077724" :
				case "356346773816936457" :		 	$ret = "#ffe7c9";		break;
		}		break;
		
		
		case "bizIndexWannaBeOne" :		switch(UNK)		{		// דף עסק, מתחת לטקסט יופיע טקסט הבא שמשווק את מוצר האינדקס - שיצטרפו לאנידקס 
				case "263512086634836547" :
					$ret = "<b>אם אתה בעל העסק ".$more."  וברצונך לשדרג את דף האינטרנט הנ\"ל על ידי הוספה של תמונת כרטיס ביקור, לוגו, פלייר פרסומי וסרטון וידאו, <a href='/index.php?m=co' class='maintext' style='font-size: 14px; color: #01567d;'>צור קשר</a></b>";
					$ret .= "<br><br>";
					$ret .= "דוגמא לכרטיס עסק משודרג : <a href='/index.php?m=KgBm_p&pid=100&guide=2' class='maintext' style='font-size: 14px; color: #01567d;' target='_blank'>לחץ כאן</a>";
				break;
				case "071512107783122948" :
					$ret = "<b>אם אתה בעל חברת ההסעות ".$more."  וברצונך לשדרג את דף האינטרנט הנ\"ל על ידי הוספה של תמונת כרטיס ביקור, לוגו, פלייר פרסומי וסרטון וידאו, <a href='/index.php?m=co' class='maintext' style='font-size: 14px; color: #01567d;'>צור קשר</a></b>";
					$ret .= "<br><br>";
					$ret .= "דוגמא לכרטיס עסק משודרג : <a href='/index.php?m=KgBm_p&pid=1220&guide=' class='maintext' style='font-size: 14px; color: #01567d;' target='_blank'>לחץ כאן</a>";
				break;
				case "161819904213378395" :
					$ret = "<b>אם אתה בעל מרפאת השיניים ".$more."  וברצונך לשדרג את דף האינטרנט הנ\"ל על ידי הוספה של תמונת כרטיס ביקור, לוגו, פלייר פרסומי וסרטון וידאו, <a href='/index.php?m=co' class='maintext' style='font-size: 14px; color: #01567d;'>צור קשר</a></b>";
					$ret .= "<br><br>";
					//$ret .= "דוגמא לכרטיס עסק משודרג : <a href='http://www.אוטובוסים.net/index.php?m=KgBm_p&pid=1220&guide=' class='maintext' style='font-size: 14px; color: #01567d;' target='_blank'>לחץ כאן</a>";
				break;
				case "892416832482956591" :
					$ret = "<b>אם אתה בעל העסק ".$more."  וברצונך לשדרג את דף האינטרנט הנ\"ל על ידי הוספה של תמונת כרטיס ביקור, לוגו, פלייר פרסומי וסרטון וידאו, <a href='/index.php?m=co' class='maintext' style='font-size: 14px; color: #01567d;'>צור קשר</a></b>";
					$ret .= "<br><br>";
					//$ret .= "דוגמא לכרטיס עסק משודרג : <a href='http://www.אוטובוסים.net/index.php?m=KgBm_p&pid=1220&guide=' class='maintext' style='font-size: 14px; color: #01567d;' target='_blank'>לחץ כאן</a>";
				break;
				case "192202924562351192" :
					$ret = "<b>אם אתה בעל העסק ".$more."  וברצונך לשדרג את דף האינטרנט הנ\"ל על ידי הוספה של תמונת כרטיס ביקור, לוגו, פלייר פרסומי וסרטון וידאו, <a href='/index.php?m=co' class='maintext' style='font-size: 14px; color: #01567d;'>צור קשר</a></b>";
					$ret .= "<br><br>";
					//$ret .= "דוגמא לכרטיס עסק משודרג : <a href='http://www.אוטובוסים.net/index.php?m=KgBm_p&pid=1220&guide=' class='maintext' style='font-size: 14px; color: #01567d;' target='_blank'>לחץ כאן</a>";
				break;
				case "506993621038532664" :
					$ret = "<b>אם אתה בעל העסק ".$more."  וברצונך לשדרג את דף האינטרנט הנ\"ל על ידי הוספה של תמונת כרטיס ביקור, לוגו, פלייר פרסומי וסרטון וידאו, <a href='/index.php?m=co' class='maintext' style='font-size: 14px; color: #01567d;'>צור קשר</a></b>";
					$ret .= "<br><br>";
					//$ret .= "דוגמא לכרטיס עסק משודרג : <a href='http://www.אוטובוסים.net/index.php?m=KgBm_p&pid=1220&guide=' class='maintext' style='font-size: 14px; color: #01567d;' target='_blank'>לחץ כאן</a>";
				break;
				case "932937850555019039" :
					$ret = "<b>אם אתה בעל העסק ".$more."  וברצונך לשדרג את דף האינטרנט הנ\"ל על ידי הוספה של תמונת כרטיס ביקור, לוגו, פלייר פרסומי וסרטון וידאו, <a href='/index.php?m=co' class='maintext' style='font-size: 14px; color: #01567d;'>צור קשר</a></b>";
					$ret .= "<br><br>";
					//$ret .= "דוגמא לכרטיס עסק משודרג : <a href='http://www.אוטובוסים.net/index.php?m=KgBm_p&pid=1220&guide=' class='maintext' style='font-size: 14px; color: #01567d;' target='_blank'>לחץ כאן</a>";
				break;
				
				case "356346773816936457" :
					$ret = "<b>אם אתה בעל העסק ".$more."  וברצונך לשדרג את דף האינטרנט הנ\"ל על ידי הוספה של תמונת כרטיס ביקור, לוגו, פלייר פרסומי וסרטון וידאו, <a href='/index.php?m=co' class='maintext' style='font-size: 14px; color: #01567d;'>צור קשר</a></b>";
					$ret .= "<br><br>";
					//$ret .= "דוגמא לכרטיס עסק משודרג : <a href='http://www.אוטובוסים.net/index.php?m=KgBm_p&pid=1220&guide=' class='maintext' style='font-size: 14px; color: #01567d;' target='_blank'>לחץ כאן</a>";
				break;
				
				case "577342662741077724" :
					$ret = "";
					//$ret .= "דוגמא לכרטיס עסק משודרג : <a href='http://www.אוטובוסים.net/index.php?m=KgBm_p&pid=1220&guide=' class='maintext' style='font-size: 14px; color: #01567d;' target='_blank'>לחץ כאן</a>";
				break;
		}		break;
		
		
		case "thanksAddBiz" :		switch(UNK)		{		// דף תודה לטופס הוסף עסק
				case "263512086634836547" :		 	$ret = "רשומתך התקבלה בהצלחה,<br>אנו ניצור עימך קשר עד 5 ימי עבודה<br><br>בברכה,<br>צוות קול הנגב - מדריך טלפונים ועסקים";		break;
				case "071512107783122948" :		 	$ret = "רשומתך התקבלה בהצלחה,<br>אנו ניצור עימך קשר עד 5 ימי עבודה<br><br>בברכה,<br>צוות פורטל ההסעות";		break;
				case "161819904213378395" :		 	$ret = "רשומתך התקבלה בהצלחה,<br>אנו ניצור עימך קשר עד 5 ימי עבודה<br><br>בברכה,<br>צוות פורטל רופאי השיניים";		break;
				case "892416832482956591" :		 	$ret = "רשומתך התקבלה בהצלחה,<br>אנו ניצור עימך קשר עד 5 ימי עבודה<br><br>בברכה,<br>צוות פורטל לאן יוצאים לאכול";		break;
				case "192202924562351192" :		 	$ret = "רשומתך התקבלה בהצלחה,<br>אנו ניצור עימך קשר עד 5 ימי עבודה<br><br>בברכה,<br>צוות פורטל באר שבע";		break;
				case "506993621038532664" :		 	$ret = "רשומתך התקבלה בהצלחה,<br>אנו ניצור עימך קשר עד 5 ימי עבודה<br><br>בברכה,<br>צוות פורטל הובלות";		break;
				case "932937850555019039" :		 	$ret = "רשומתך התקבלה בהצלחה,<br>אנו ניצור עימך קשר עד 5 ימי עבודה<br><br>בברכה,<br>צוות פורטל התיירות";		break;
				case "356346773816936457" :		 	$ret = "רשומתך התקבלה בהצלחה,<br>אנו ניצור עימך קשר עד 5 ימי עבודה<br><br>בברכה,<br>צוות אתר שכונת נווה זאב";		break;
				case "577342662741077724" :		 	$ret = "רשומתך התקבלה בהצלחה,<br>אנו ניצור עימך קשר עד 5 ימי עבודה<br><br>בברכה,<br>צוות פסק דין";		break;
				
		}		break;
		
		
		// Images:
		//	prem_arrow.png
		// words : מבצעים - דרושים
		// מערכת אינקדס, מערכת הצעות מחיר, מערכת הרשאות
		// catScript.php לדומיין
		/*
<div style="margin-left: auto; margin-right: auto; width: 775px; height: 253px; position: relative;">  <object align="middle" width="775" height="253" wmode="Transparent" id="Untitled-1" codebase="http://download.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=7,0,0,0" classid="clsid:d27cdb6e-ae6d-11cf-96b8-444553540000">
<param value="sameDomain" name="allowScriptAccess" />
<param value="Transparent" name="wmode" />
<param value="/tamplate/932937850555019039-slice.swf" name="movie" />
<param value="high" name="quality" /> 																	<embed align="middle" width="775" height="253" wmode="Transparent" pluginspage="http://www.macromedia.com/go/getflashplayer" type="application/x-shockwave-flash" allowscriptaccess="sameDomain" name="Untitled-1" quality="high" src="/tamplate/932937850555019039-slice.swf"></embed> 																	</object>
<div style="position: absolute; right: 210px; top: 130px; display: block;">!!!CODE_SERACH_ENGING_2_NOT_DELETE!!!</div>
<div style="position: absolute; right: 210px; top: 190px; display: block;"> !!!CODE_SERACH_ENGING_NOT_DELETE!!! </div>
</div>
		*/
		
	}
	
	if( $ret )
		return $ret;
}


function startup7_Cform()
{
	$form_arr = array(
		array("hidden","m","startup7_Cform_Reg"),
		
		array("blank","<font color='red'>שדות חובה:</font>"),
		array("text","first_name","","<font color='red'>*</font> שם פרטי:", "class='input_style' style='height: 18px;'"),
		array("text","last_name","","<font color='red'>*</font> שם משפחה:", "class='input_style' style='height: 18px;'"),
		array("text","tz","","<font color='red'>*</font> תעודת זהות:", "class='input_style' style='height: 18px;'"),
		array("text","mobile","","<font color='red'>*</font> טלפון נייד:", "class='input_style' style='height: 18px;'"),
		array("text","email","","<font color='red'>*</font> אימייל:", "class='input_style' style='height: 18px;'"),
		
		array("blank","<br>"),
		
		array("text","address","","כתובת:", "class='input_style' style='height: 18px;'"),
		array("text","birthday","","תאריך לידה:", "class='input_style' style='height: 18px;'"),
		array("text","army_date","","תאריך שחרור מהצבא/שרות לאומי:", "class='input_style' style='height: 18px;'"),
		array("text","birth_country","","ארץ לידה:", "class='input_style' style='height: 18px;'"),
		array("text","alia_date","","תאריך עליה:", "class='input_style' style='height: 18px;'"),
		
		array("blank","<br>"),

		array("blank","
		<input type='checkbox' name='check_1' value='1'> מחפש/ת עבודה<br>
		<input type='checkbox' name='check_2' value='1'> רוצה להתחיל ללמוד<br>
		<input type='checkbox' name='check_3' value='1'> מעוניין/ת במידע על מעורבות חברתית והתנדבות<br>
		<input type='checkbox' name='check_4' value='1'> * מעוניין/ת להשתתף בהרצאה על זכויות חיילים משוחררים
		<br>
		* ההרצאה תתקיים ב-14/9 בין השעות 18:30 – 19:15 בכיתה של מרכז הצעירים
		
		"),
		
		array("hidden","date_send",GlobalFunctions::get_timestemp_viewIt(), "class='input_style'"),
		array("submit","submit","שלח טופס", "class='submit_style'")
	);
	
	$more = "class='maintext'";
	
	$mandatory_fields = array("first_name","last_name","tz","mobile","email");
	$get_form = FormCreator::create_form($form_arr,"index.php", $more , $mandatory_fields );
	
	echo "<table border=\"0\" cellspacing=\"0\" cellpadding=\"0\" class=\"maintext\" width=100%>";
		
		echo "<tr>";
			echo "<td align=center><h2 style='padding:0; margin:0'>טופס הרשמה לאירוע העשור של סטארט אפ</h2></td>";
		echo "</tr>";
		echo "<tr><td height=5></td></tr>";
		echo "<tr>";
			echo "<td align=center><h3 style='padding:0; margin:0'>יריד תעסוקה והשכלה לצעירים וכנס משתחררים</h4></td>";
		echo "</tr>";
		echo "<tr><td height=5></td></tr>";
		echo "<tr>";
			echo "<td align=center><h3 style='padding:0; margin:0'>יום שלישי, 14.09.2010<br>
מרכז הצעירים, הרצל 12, באר שבע,  החל מהשעה  18:00</h4></td>";
		echo "</tr>";
		echo "<tr><td height=5></td></tr>";
		echo "<tr>";
			echo "<td align=center><h3 style='padding:0; margin:0'>הגרלות לנרשמים באתר!</h4></td>";
		echo "</tr>";
		echo "<tr><td height=15></td></tr>";
		echo "<tr>";
			echo "<td>".$get_form."</td>";
		echo "</tr>";
		
	echo "</table>";
}

function startup7_Cform_Reg()
{
	$header_send_to_Client= "טופס הרשמה לאירועי העשור - ".$_POST['first_name']. " ".$_POST['last_name'];
	$content_send_to_Client = "
		<html dir=rtl>
		<head>
				<title></title>
				<style>
					.textt{font-family: arial; font-size:12px; color: #000000}
				</style>
		</head>
		
		<body>
			<p class='textt' dir=rtl align=right>
				שם פרטי: <u>".$_POST['first_name']."</u><br>
				שם משפחה: <u>".$_POST['last_name']."</u><br>
				תעודת זהות: <u>".$_POST['tz']."</u><br>
				טלפון נייד: <u>".$_POST['mobile']."</u><br>
				אימייל: <u>".$_POST['email']."</u><br>
				<br>
				כתובת: <u>".$_POST['address']."</u><br>
				תאריך לידה: <u>".$_POST['birthday']."</u><br>
				תאריך שחרור מהצבא/שרות לאומי: <u>".$_POST['army_date']."</u><br>
				ארץ לידה: <u>".$_POST['birth_country']."</u><br>
				תאריך עליה: <u>".$_POST['alia_date']."</u><br>
				<br>
				מחפש/ת עבודה - ";
				if( $_POST['check_1'] == "1" )
					$content_send_to_Client .= "<u>כן</u>";
				$content_send_to_Client .= "
				<br>רוצה להתחיל ללמוד - ";
				if( $_POST['check_2'] == "1" )
					$content_send_to_Client .= "<u>כן</u>";
				$content_send_to_Client .= "
				<br>מעוניין במידע על מעורבות חברתית והתנדבות - ";
				if( $_POST['check_3'] == "1" )
					$content_send_to_Client .= "<u>כן</u>";
				$content_send_to_Client .= "
				<br>מעוניין להשתתף בהרצאה על זכויות חיילים משוחררים - ";
				if( $_POST['check_4'] == "1" )
					$content_send_to_Client .= "<u>כן</u>";
					
				$content_send_to_Client .= "
				
			</p>
		</body>
		</html>";
	
		$fromEmail = "info@ilbiz.co.il"; 
		$fromTitle = "startup7.org.il"; 
		
		$ClientMail = "startup.asor@gmail.com";
		GlobalFunctions::send_emails_with_phpmailer($fromEmail, $fromTitle, $header_send_to_Client, $content_send_to_Client, $content_send_to_Client, $ClientMail, $fromTitle );
		
	echo "<script>window.location.href='index.php?m=startup7_Cform_Thx';</script>";
}

function startup7_Cform_Thx()
{
	echo "<p>נתראה באירוע!<br>
	<br>
	בברכה,<BR>
	צוות סטארט אפ</p>";
}
?>