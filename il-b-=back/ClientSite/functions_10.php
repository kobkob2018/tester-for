<?



function products_regular_content($limitOnQry='21',$temp_cat='')
{
	global $data_colors,$data_name,$word,$settings,$data_extra_settings;
	
	$limitcount = ( $_GET['PL'] == "" ) ? $_POST['PL'] : $_GET['PL'];
	$limitcount = ( $limitcount == "" ) ? "0" : ifint($limitcount);
	
	if( $limitOnQry == "3" )
	{
		if( $data_name['site_type'] == "10" )
		{
			$sql = "select up.* from user_extra_settings as uxs, user_products as up
				INNER JOIN user_model_cat_belong as umcb ON umcb.catId='".ifint($temp_cat)."' AND umcb.model='products' AND umcb.itemId=up.id 
				WHERE uxs.unk = up.unk and up.deleted = 0 and up.active = '0' and ( uxs.nisha_sites LIKE '%\"".$data_name['id']."\"%' OR uxs.unk = '".UNK."' ) and up.id != '".ifint($_GET['ud'])."' order by rand() LIMIT ".$limitcount.",".$limitOnQry;
		}
		else
			$sql = "select up.* from user_products as up INNER JOIN user_model_cat_belong as umcb ON umcb.catId='".ifint($temp_cat)."' AND umcb.model='products' AND umcb.itemId=up.id WHERE up.deleted = 0 and up.unk = '".UNK."' and up.active = '0' and up.id != '".ifint($_GET['ud'])."' order by rand() LIMIT ".$limitcount.",".$limitOnQry;
	}
	else	{
		if( $data_name['site_type'] == "10" )
		{
			$sql = "select up.* from user_extra_settings as uxs, user_products as up
				INNER JOIN user_model_cat_belong as umcb ON umcb.catId='".ifint($temp_cat)."' AND umcb.model='products' AND umcb.itemId=up.id 
				WHERE uxs.unk = up.unk and up.deleted = 0 and up.active = '0' and ( uxs.nisha_sites LIKE '%\"".$data_name['id']."\"%' OR uxs.unk = '".UNK."' ) order by up.place LIMIT ".$limitcount.",".$limitOnQry;
		}
		else
			$sql = "select up.* from user_products as up INNER JOIN user_model_cat_belong as umcb ON umcb.catId='".ifint($temp_cat)."' AND umcb.model='products' AND umcb.itemId=up.id WHERE up.deleted = 0 and up.unk = '".UNK."' and up.active = '0' order by up.place LIMIT ".$limitcount.",".$limitOnQry;
	}
	
	$res = mysql_db_query(DB,$sql);
	
	$counter = 0;
	while( $data = mysql_fetch_array($res) )
	{
		if( $data_name['site_type'] == "10" )
		{
			$sql_domain = "SELECT domain FROM users WHERE unk = '".$data['unk']."' ";
			$res_domain = mysql_db_query(DB,$sql_domain);
			$data_domain = mysql_fetch_array($res_domain);
			
			$server_path = "/home/ilan123/domains/".$data_domain['domain']."/public_html";
			$http_path = "http://".$data_domain['domain'];
		}
		else
		{
			$server_path = SERVER_PATH;
			$http_path = HTTP_PATH;
		}
		
		if( $counter%3 == 0 )
		echo "<tr>";
			
			$abpath_temp = $server_path."/products/".$data['img'];
			if( file_exists($abpath_temp) && !is_dir($abpath_temp) )
			{
				$im_size = GetImageSize ($abpath_temp); 
				$imageWidth = $im_size[0]; 
				$imageheight = $im_size[1]; 
				
				//if( $imageheight > "100" )
					//$img_sizes = "height=\"100\"";
				if( $imageWidth > "151" )
					$imageWidth = "151";
				
				$img_src = "<a href=\"index.php?m=s.pr&ud=".$data['id']."&cat=".$_GET['cat']."&sub=".$_GET['sub']."\" class=\"maintext\" title=\"".htmlspecialchars(stripslashes($data['name']))."\"><img src='".$http_path."/products/".$data['img']."' border='0' width=\"".$imageWidth."\" alt=''></a>";
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
					<tr>
						<td width=\"3\">
						<td valign=\"top\">";
						if( $data_name['have_ecom'] == "1" && $data['active_ecom'] == "1" )
						{
							echo "<div class=\"product_container\">
							<div id=\"slidingProduct".$data['id']."\" class=\"sliding_product\">";
						}
						
						
							echo "<table border=\"0\" height=\"269\" cellspacing=\"0\" cellpadding=\"0\" class=\"maintext\">";
						
								echo "<tr>
									<td align=\"".$settings['align']."\" height=26 valign=\"top\" ".$products_top_beck." style='background-repeat: no-repeat;' width=\"156\"><a href=\"index.php?m=s.pr&ud=".$data['id']."&cat=".$_GET['cat']."&sub=".$_GET['sub']."\" class=\"maintext\" title=\"".htmlspecialchars(stripslashes($data['name']))."\"><b>".htmlspecialchars(stripslashes($data['name']))."</b></a></td>
								</tr>";
								
								echo "<tr>";
									echo "<td ".$products_mid_beck." valign=top width=\"156\" align=center>";
										echo "<table border=\"0\" cellspacing=\"0\" height=203 cellpadding=\"0\" class=\"maintext\" align=center>";
										
										
											echo "<tr><td height=\"1\"></td></tr>
											
											<tr>
												<td  valign=\"top\" align=center height=100>{$img_src}</td>
											</tr>
											
											
											
											<tr><td height=\"3\"></td></tr>
											<tr>
												<td align=\"".$settings['align']."\" valign=\"top\" height=50><b>".nl2br(stripslashes(htmlspecialchars($data['summary'])))."</b></td>
											</tr>
											<tr><td height=\"3\"></td></tr>";
											
											if( $data['kobia_msg'] != "" )
											{
												$kobia_msg_style = ( $data['kobia_msg_bg'] != "" ) ? "backgroud-color: #".$data['kobia_msg_bg'].";" : "";
												$kobia_msg_color = ( $data['kobia_msg_color'] != "" ) ? "color: #".$data['kobia_msg_color'].";" : "";
												
												echo "<tr><td height=\"3\"></td></tr>
												<tr>
													<td align=\"center\" valign=\"top\"><font style='padding: 2px; ".$kobia_msg_style.$kobia_msg_color." '>".nl2br(stripslashes(htmlspecialchars($data['kobia_msg'])))."</font></td>
												</tr>
												<tr><td height=\"3\"></td></tr>";
											}
											
											
											if( $data['price'] )
											{
												if(UNK != '806700060391385236' && UNK != '862091780777250501' && UNK != '208757065782826350'){
													echo "<tr>
														<td align=\"center\" valign=\"bottom\">".$word[LANG]['1_1_products_price']." <b>".$data['price']." ".COIN."</b></td>
													</tr>
													<tr><td height=\"3\"></td></tr>";
													
													if( $data_name['have_ecom'] == "1" && $data['active_ecom'] == "1" )
													{
														$abpath_temp = SERVER_PATH."/tamplate/".stripslashes($data_extra_settings['cartAddImg']);
														
														echo "<tr>";
															echo "<td valign=\"bottom\" align=center>
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
											}
										echo "</table>";
									echo "</td>";
								echo "</tr>";
								
								
								echo "<tr>
									<td align=\"center\" ".$products_bot_beck." valign=bottom height=26 width=\"156\" style='background-repeat: no-repeat;'><a href=\"index.php?m=s.pr&ud=".$data['id']."&cat=".$_GET['cat']."&sub=".$_GET['sub']."\" class=\"maintext\" title=\"".htmlspecialchars(stripslashes($data['name']))."\"><b>".$word[LANG]['1_1_products_more_info']."</b></a></td>
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
	
}


function products_regular_content_type2($limitOnQry='21',$temp_cat='',$title='')
{
	global $data_colors,$data_name,$word,$settings,$data_extra_settings;
	
	$limitcount = ( $_GET['PL'] == "" ) ? $_POST['PL'] : $_GET['PL'];
	$limitcount = ( $limitcount == "" ) ? "0" : ifint($limitcount);
	
	if( $limitOnQry == "3" )
	{
		if( $data_name['site_type'] == "10" )
		{
			$sql = "select up.* from user_extra_settings as uxs, user_products as up
				INNER JOIN user_model_cat_belong as umcb ON umcb.catId='".ifint($temp_cat)."' AND umcb.model='products' AND umcb.itemId=up.id 
				WHERE uxs.unk = up.unk and up.deleted = 0 and up.active = '0' and ( uxs.nisha_sites LIKE '%\"".$data_name['id']."\"%' OR uxs.unk = '".UNK."' ) up.id != '".ifint($_GET['ud'])."' order by rand() LIMIT ".$limitcount.",".$limitOnQry;
		}
		else
			$sql = "select up.* from user_products as up INNER JOIN user_model_cat_belong as umcb ON umcb.catId='".ifint($temp_cat)."' AND umcb.model='products' AND umcb.itemId=up.id WHERE up.deleted = 0 and up.unk = '".UNK."' and up.active = '0' and up.id != '".ifint($_GET['ud'])."' order by rand() LIMIT ".$limitcount.",".$limitOnQry;
	}
	else
		if( $data_name['site_type'] == "10" )
		{
			$sql = "select up.* from user_extra_settings as uxs, user_products as up
				INNER JOIN user_model_cat_belong as umcb ON umcb.catId='".ifint($temp_cat)."' AND umcb.model='products' AND umcb.itemId=up.id 
				WHERE uxs.unk = up.unk and up.deleted = 0 and up.active = '0' and ( uxs.nisha_sites LIKE '%\"".$data_name['id']."\"%' OR uxs.unk = '".UNK."' ) order by up.place LIMIT ".$limitcount.",".$limitOnQry;
		}
		else
			$sql = "select up.* from user_products as up INNER JOIN user_model_cat_belong as umcb ON umcb.catId='".ifint($temp_cat)."' AND umcb.model='products' AND umcb.itemId=up.id WHERE up.deleted = 0 and up.unk = '".UNK."' and up.active = '0' order by up.place LIMIT ".$limitcount.",".$limitOnQry;
	
	$res = mysql_db_query(DB,$sql);
	$nums = mysql_num_rows($res);
	
	if( LANG == "he" && $nums > 0 )
		{
		echo "<tr><td height=\"15\"></td></tr><tr>";
			echo "<td><h3>גולשים שהתעניינו ב<U>".$title."</U> התעניינו גם ב:</h3></td>";
		echo "</tr>";
		}
	$counter = 0;
	while( $data = mysql_fetch_array($res) )
	{
		if( $data_name['site_type'] == "10" )
		{
			$sql_domain = "SELECT domain FROM users WHERE unk = '".$data['unk']."' ";
			$res_domain = mysql_db_query(DB,$sql_domain);
			$data_domain = mysql_fetch_array($res_domain);
			
			$server_path = "/home/ilan123/domains/".$data_domain['domain']."/public_html";
			$http_path = "http://".$data_domain['domain'];
		}
		else
		{
			$server_path = SERVER_PATH;
			$http_path = HTTP_PATH;
		}
		
		echo "
		<tr><td height=\"5\"></td></tr>
		<tr><td><hr width=100% size=1 class='site_border'></td></tr>
		<tr><td height=\"5\"></td></tr>
		<tr>";
			
			$abpath_temp = $server_path."/products/".$data['img'];
			if( file_exists($abpath_temp) && !is_dir($abpath_temp) )
			{
				$im_size = GetImageSize ($abpath_temp); 
				$imageWidth = $im_size[0]; 
				$imageheight = $im_size[1]; 
				$img_src = "<a href=\"index.php?m=s.pr&ud=".$data['id']."&cat=".$_GET['cat']."&sub=".$_GET['sub']."\" class=\"maintext\" title=\"".htmlspecialchars(stripslashes($data['name']))."\"><img src='".$http_path."/products/{$data['img']}' border='0' height=\"{$imageheight}\" width=\"".$imageWidth."\"></a>";
			}
			else
			{
				$img_src = "";
				$imageWidth = "76%";
			}
		
			echo "<td valign=\"top\" align=\"center\" width=\"100%\">
				<table border=\"0\" cellspacing=\"0\" cellpadding=\"0\" width=\"100%\">
					<tr><td colspan=\"3\" colspan=3></td></tr>
					<tr>
						<td width=\"3\">
						<td valign=\"top\">";
						/*if( $data_name['have_ecom'] == "1" && $data['active_ecom'] == "1" )
						{
							echo "<div class=\"product_container\" style='display: inline'>
							<div id=\"slidingProduct".$data['id']."\" class=\"sliding_product\">";
						}*/
						
							echo "<table border=\"0\" cellspacing=\"0\" cellpadding=\"0\" class=\"maintext\" width=\"100%\">";
							
								echo "<tr>
									<td align=\"".$settings['align']."\" height=46 valign=\"top\"><a href=\"index.php?m=s.pr&ud=".$data['id']."&cat=".$_GET['cat']."&sub=".$_GET['sub']."\" class=\"maintext\" title=\"".htmlspecialchars(stripslashes($data['name']))."\"><b>".htmlspecialchars(stripslashes($data['name']))."</b></a></td>
								</tr>";
								
								echo "<tr>";
									echo "<td valign=top width=\"100%\">";
										echo "<table border=\"0\" cellspacing=\"0\" cellpadding=\"0\" class=\"maintext\" width=\"100%\">";
											echo "
											<tr>
												<td valign=\"top\" width=150>".$img_src."</td>
												<td width=10></td>
												<td valign=\"top\" height=100%>";
													echo "<table border=\"0\" cellspacing=\"0\" cellpadding=\"0\" class=\"maintext\" height=100% width=\"100%\">";
														echo "<tr>";
															echo "<td valign=\"top\" align=right><b>".nl2br(stripslashes(htmlspecialchars($data['summary'])))."</b></td></td>";
															echo "<td width=10></td>";
															echo "<td valign=\"bottom\" align=left>";
																echo "<table border=\"0\" cellspacing=\"0\" cellpadding=\"0\" class=\"maintext\" width=100>";
																	if( $data['price'] )
																	{
																		echo "<tr>
																			<td valign=\"top\">".$word[LANG]['1_1_products_price']." <b>".$data['price']." ".COIN."</b></td>
																		</tr>
																		<tr><td height=\"3\"></td></tr>";
																		
																		
																		/*if( $data_name['have_ecom'] == "1" && $data['active_ecom'] == "1" )
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
																		}**/
																	}
																	
																	echo "<tr>
																		<td><a href=\"index.php?m=s.pr&ud=".$data['id']."&cat=".$_GET['cat']."&sub=".$_GET['sub']."\" class=\"maintext\" title=\"".htmlspecialchars(stripslashes($data['name']))."\"><b>".$word[LANG]['1_1_products_more_info']."</b></a></td>
																	</tr>";
																echo "</table>";
															echo "</td>";
														echo "</tr>";
													echo "</table>";
												echo "</td>";
											echo "</tr>";
											
										echo "</table>";
									echo "</td>";
								echo "</tr>";
								
							echo "</table>";
							
						/*if( $data_name['have_ecom'] == "1"  && $data['active_ecom'] == "1" )
						{
							echo "</div></div>";
						}*/
						echo "
						</td>
						<td width=\"3\">
					</tr>
					<tr><td colspan=\"3\" height=\"5\"></td></tr>
				</table>
			</td>";
			
			
		$counter++;
		echo "</tr>";
		
		
		
	}
	
}



function cats_inner_search_engine_jobs()
{
	$sql = "SELECT bc.id , bc.cat_name  FROM 
		biz_categories as bc , user_wanted_cats as wc , user_wanted as uw WHERE 
			bc.father=0 AND 
			bc.status=1 AND 
			bc.hidden=0 AND
			
			wc.cat_id=bc.id AND
			uw.id=wc.wanted_id  AND
			uw.unk = '".UNK."' AND
			uw.deleted=0
			
			GROUP BY bc.id ORDER BY bc.place";
	$resCat = mysql_db_query(DB,$sql);
	$nums_rows = mysql_num_rows($resCat);
	
	if( $nums_rows > 0 )
	{
		echo "<form action='index.php' name='searchByCats' method='get' style='padding:0; margin:0'>";
		echo "<input type='hidden' name='m' value='jo'>";
		echo "<table border=\"0\" cellspacing=\"2\" cellpadding=\"0\" class=\"maintext\" width=\"400\">";
			echo "<tr>";
				echo "<td width=150>";
					echo "<select name='Scat' id='Scat' onchange='changeCatChain(this)' class='input_style' style='width:150px; height: 22px;'>";
						echo "<option value=''>בחר בנושא</option>";
						
						while( $dataCat = mysql_fetch_array($resCat) )
						{
							$selected = ( $dataCat['id'] == $_GET['Scat'] ) ? "selected" : "";
							echo "<option value='".$dataCat['id']."' ".$selected.">".stripslashes($dataCat['cat_name'])."</option>";
						}
						
					echo "</select>";
				echo "</td>";
				echo "<td width=10></td>";
				echo "<td width=150>";
					echo "<select name='STcat' id='STcat' onchange='changeSTcatChain(this)' class='input_style' style='display: none; width:150px; height: 22px;'><option value=''>בחר בתחום</option></select>";
				echo "</td>";
				
				echo "<td width=10></td>";
				echo "<td width=150>";
					echo "<select name='Sspec' id='Sspec' style='display: none; width:150px; height: 22px;' class='input_style'><option value=''>בחר בהתמחות</option></select>";
				echo "</td>";
				echo "<tr><td colspan=5 height=5></td></tr>";
				echo "<tr>";
					echo "<td align=left colspan=5><input type='submit' value='חפש' class='input_style' style='width:75px; height: 22px;'></td>";
				echo "</tr>";
			echo "</tr>";
		echo "</table>";
		echo "</form>";
		
		if( $_GET['STcat'] != "" && $_GET['STcat'] != "0" )
		{
			echo "<script type='text/javascript'>updateTatCat('".$_GET['Scat']."')</script>";
		}
		
		if( $_GET['Sspec'] != "" && $_GET['Sspec'] != "0" )
		{
			echo "<script type='text/javascript'>updateSpecCat('".$_GET['STcat']."')</script>";
		}
		
	}
	
}


function index_ajax_product_images()
{
	$sql = "SELECT domain FROM users WHERE unk = '".$_GET['unk']."' ";
	$res = mysql_db_query(DB,$sql);
	$userData = mysql_fetch_array($res);
	
	$sql = "select id, name, img, img2, img3 from user_products where unk = '".$_GET['unk']."' and deleted = '0' and active = '0' and id = '".ifint($_GET['ud'])."' limit 1";
	$res = mysql_db_query(DB,$sql);
	$data = mysql_fetch_array($res);
	
	$server_path = "/home/ilan123/domains/".$userData['domain']."/public_html/product_image/".$data['id']."/";
	
	echo "<table border=\"0\" cellspacing=\"0\" cellpadding=\"0\" class=\"maintext\">";
		echo "<tr><td height=45></td></tr>";
		echo "<tr>";
			echo "<td valign=top width=200 bgcolor='#F0F0F0' align=center style='border: 1px solid #BFBFBF;'>";
				echo "<table border=\"0\" cellspacing=\"0\" cellpadding=\"0\" class=\"maintext\">";
					echo "<tr>";
						echo "<td>";
							$img_params['img1'] = $data['img1'];
							$img_params['img2'] = $data['img2'];
							$img_params['img3'] = $data['img3'];
							$img_params['name'] = htmlspecialchars(stripslashes($data['name']));
							$img_params['ud'] = $_GET['ud'];
							$img_params['domain'] = $userData['domain'];
							
							echo get_products_img_parameters( $_GET['pimg'] , $img_params );
						echo "</td>";
					echo "</tr>";
				echo "</table>";
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
									echo "<a href='javascript:void(0)' onclick='product_images(\"".$_GET['ud']."\" , \"default\" , \"".$_GET['unk']."\" )'><img src='http://".$userData['domain']."/products/".$data['img']."' alt='' border='0' width=75 style='border: 0px solid #000000;'></a>";
								}
								else
								{
									echo "<a href='javascript:void(0)' onclick='product_images(\"".$_GET['ud']."\" , \"".$img."\" , \"".$_GET['unk']."\" )'><img src='http://".$userData['domain']."/product_image/".$data['id']."/".$img_S.".".$exte."' width=75 alt='' border='0' style='border: 0px solid #000000;'></a>";
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
}


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
			echo "<a href='javascript:void(0)' onClick=\"divwin=dhtmlwindow.open('s.prEXimg".$img_name."', 'div', 's.prEXimgDiv".$img_name."', ' ', 'width=".$sPrEX_width."px,height=".$sPrEX_height."px,left=10px,top=10px,resize=0,scrolling=0'); return false\"><img src='".$src.$img2."' border='0' align='left' alt='' width='".$org_width_l."' height='".$org_height_l."' vspace=5 hspace=5></a>";
			
		}
		else
			echo "<img src='".$src.$img2."' border='0' align='left' width='".$org_width_l."' height='".$org_height_l."' vspace=5 hspace=5>";
	}
	else 
		if( file_exists($apth_small) && !is_dir($apth_small) )
			echo "<img src='".$src.$img."' border='0' align='left'>";
	
}



function optimize_textAjImg($utf8 )
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


function ecom_new_buy()
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
			echo "<td><h4 class=\"page_headline\">קופה</h4></td>";
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
						$sql = "select name,price,price_special,makat from user_products where id = '".$data['product_id']."'";
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
						
						if( ( $data['product_id'] == "16088" || $data['product_id'] == "16089" || $data['product_id'] == "16090" || $data['product_id'] == "16091" || $data2['price_special'] > "0" ) && UNK == "625420717714095702" )
							$fmn_tz_ok = "1";
						else
							$fmn_tz_ok = "";
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
		
	if( $num_rows > 0 )
	{
		echo "<tr>";
			echo "<td>";
				echo "<table border=\"0\" cellspacing=\"0\" cellpadding=\"0\" class=\"maintext\">";
					echo "<form action='?' name='step2_ecom_form' method='POST' onsubmit=\"return check_mandatory_fields();\">";
					echo "<input type='hidden' name='m' value='ecom_new_buy_DB'>";
					
						echo "<tr>";
							if( UNK != "567556530384297372" )
								echo "<td colspan='3'>".nl2br(kill_and_strip($D_ecom_settigns['textarea_content']))."</td>";
							else
							{
								echo "<td colspan='3'>
								".nl2br(kill_and_strip($D_ecom_settigns['textarea_content']))."<br>
								* משלוח מהיר ייחויב בנפרד<br><br>
								<b>סליקת כרטיסי האשראי נעשית על שרת מאובטח מאושר על ידי חברת ישראכרט, חשבונית אוטומטית תשלח לכתובת המייל שלכם<br>
								חברת בדים נט מתחייבת לא להעביר את שמכם כתובתכם או כל פרט אחר לשום גורם</b><br><br>
								לנוחיותכם ניתן לשלם טלפונית במספר 1-700-72-3254
								</td>";
							}
						echo "</tr>";
						echo "<tr><td height='10' colspan=3></td></tr>";
						echo "<tr>";
							echo "<td><font color=red>*</font> שם מלא</td>";
							echo "<td width=10></td>";
							echo "<td><input type='text' name='dataArr[full_name]' id='dataArr[full_name]' class='input_style'></td>";
						echo "</tr>";
						echo "<tr><td height='7' colspan=3></td></tr>";
						if( $fmn_tz_ok == "1" )
						{
							echo "<tr>";
								echo "<td><font color=red>*</font> תעודת זהות</td>";
								echo "<td width=10></td>";
								echo "<td><input type='text' name='dataArr[tz]' id='dataArr[tz]' class='input_style'></td>";
							echo "</tr>";
							echo "<tr><td height='7' colspan=3></td></tr>";
						}
						echo "<tr>";
							echo "<td><font color=red>*</font> אימייל</td>";
							echo "<td width=10></td>";
							echo "<td><input type='text' name='dataArr[email]' id='dataArr[email]' class='input_style'></td>";
						echo "</tr>";
						echo "<tr><td height='7' colspan=3></td></tr>";
						echo "<tr>";
							echo "<td><font color=red>*</font> טלפון</td>";
							echo "<td width=10></td>";
							echo "<td><input type='text' name='dataArr[phone]' id='dataArr[phone]' class='input_style'></td>";
						echo "</tr>";
						echo "<tr><td height='7' colspan=3></td></tr>";
						echo "<tr>";
							echo "<td><font color=red>*</font> ישוב</td>";
							echo "<td width=10></td>";
							echo "<td><input type='text' name='dataArr[city]' id='dataArr[city]' class='input_style'></td>";
						echo "</tr>";
						echo "<tr><td height='7' colspan=3></td></tr>";
						echo "<tr>";
							echo "<td><font color=red>*</font> רחוב</td>";
							echo "<td width=10></td>";
							echo "<td><input type='text' name='dataArr[address]' id='dataArr[address]' class='input_style'></td>";
						echo "</tr>";
						echo "<tr><td height='7' colspan=3></td></tr>";
						echo "<tr>";
							echo "<td><font color=red>*</font> מספר בית</td>";
							echo "<td width=10></td>";
							echo "<td>";
								echo "<table border=\"0\" cellspacing=\"0\" cellpadding=\"0\" class=\"maintext\">";
									echo "<tr>";
										echo "<td><input type='text' name='dataArr[buildingNum]' id='dataArr[buildingNum]' class='input_style' style='width: 118px;'></td>";
										echo "<td width=5></td>";
										echo "<td>מספר דירה</td>";
										echo "<td width=5></td>";
										echo "<td><input type='text' name='dataArr[home_num]' id='dataArr[home_num]' class='input_style' style='width: 118px;'></td>";
									echo "</tr>";
								echo "</table>";
							echo "</td>";
						echo "</tr>";
						echo "<tr><td height='7' colspan=3></td></tr>";
						echo "<tr>";
							echo "<td>מיקוד</td>";
							echo "<td width=10></td>";
							echo "<td><input type='text' name='dataArr[zip_code]' id='dataArr[zip_code]' class='input_style'></td>";
						echo "</tr>";
						echo "<tr><td height='7' colspan=3></td></tr>";
						echo "<tr>";
							echo "<td>הערות</td>";
							echo "<td width=10></td>";
							echo "<td><textarea name='dataArr[note]' id='dataArr[note]' cols='' rows='' class='input_style' style='height: 70px;'></textarea></td>";
						echo "</tr>";
						echo "<tr><td height='7' colspan=3></td></tr>";
						if( UNK != "995628678735762902" )
						{
						echo "<tr>";
							echo "<td>".$word[LANG]['1_1_ecom_form_step_2_delivery']."</td>";
							echo "<td width=10></td>";
							echo "<td>";
							$delivery_pay = ( $D_ecom_settigns['delivery_pay'] != "" ) ? $D_ecom_settigns['delivery_pay'] : "0";
							
							if( UNK == "514738259673354081" OR UNK == "567556530384297372" )
							{
								echo "<select name='dataArr[delivery_pay]' id='dataArr[delivery_pay]' class='input_style' style='width:250px; height: 18px;'>
									<option value='".kill_and_strip($D_ecom_settigns['delivery_pay'])."' selected>".$word[LANG]['1_1_ecom_form_step_2_delivery_pay_1'].": ".kill_and_strip($delivery_pay)." ".COIN."</option>
								</select>";
							}
							else
							{
								echo "<select name='dataArr[delivery_pay]' id='dataArr[delivery_pay]' class='input_style' style='width:250px; height: 18px;'>
									<option value=''>".$word[LANG]['1_1_ecom_form_step_2_delivery_choose']."</option>
									<option value='0' selected>".$word[LANG]['1_1_ecom_form_step_2_delivery_pay_0']."</option>
									<option value='".kill_and_strip($D_ecom_settigns['delivery_pay'])."'>".$word[LANG]['1_1_ecom_form_step_2_delivery_pay_1'].": ".kill_and_strip($delivery_pay)." ".COIN."</option>
								</select>";
							}
							
							echo "</td>";
						echo "</tr>";
						echo "<tr><td height='5' colspan=3></td></tr>";
						echo "<tr><td colspan=3><hr width=100% size=1 class=\"maintext\" /></td></td>";
						}
						else
						{
							echo "<input type='hidden' name='dataArr[delivery_pay]' id='dataArr[delivery_pay]' value='0'>";
						}
						
						echo "<tr><td height='5' colspan=3></td></tr>";
						
						//$must_content = ( UNK == "995628678735762902" ) ? "onClick='if( document.step2_ecom_form.content.value == \"\" ) { alert(\"טקסט חופשי הינו שדה חובה\"); return false; }'" : "";
						
						echo "<tr>";
							echo "<td valign=top style='font-size: 11px;'><font color=red>*</font> שדה חובה</td>";
							echo "<td width=10></td>";
							echo "<td align=left></td>";
						echo "</tr>";
						
						echo "<tr>";
							echo "<td valign=top></td>";
							echo "<td width=10></td>";
							echo "<td align=left><input type='submit' value='שליחה' class='submit_style'></td>";
						echo "</tr>";
						
					echo "</form>";
				echo "</table>";
			echo "</td>";
		echo "</tr>";
		echo "<tr><td height='20'></td></tr>";
	}
	else
		echo "<tr><td><b>לא ניתן לשלוח הזמנה ללא מוצרים.</b></td></tr>";
	
	echo "</table>";
	
	if( $fmn_tz_ok == "1" )
		$mandatory_fields = array( "dataArr[full_name]","dataArr[tz]","dataArr[email]","dataArr[phone]","dataArr[city]","dataArr[address]","dataArr[buildingNum]" );
	else
		$mandatory_fields = array( "dataArr[full_name]","dataArr[email]","dataArr[phone]","dataArr[city]","dataArr[address]","dataArr[buildingNum]" );
	
	echo "<script>
		function check_mandatory_fields()
		{
			";
			for($z=0 ; $z<sizeof($mandatory_fields) ; $z++)
			{
				$val = $mandatory_fields[$z];
				
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
				
			echo "}
	</script>";
			
}


function ecom_new_buy_DB()
{
	global $word;
	
	if( !empty($_SESSION['ecom']['unickSES']) )
	{
			$image_settings = array(
				after_success_goto=>"",
				table_name=>"users_ecom_buy",
			);
			
			$data_arr2['unk'] = UNK;
			$data_arr2['unickSES'] = $_SESSION['ecom']['unickSES'];
			
			$data_arr2['full_name'] = $_POST['dataArr']['full_name'];
			$data_arr2['tz'] = $_POST['dataArr']['tz'];
			$data_arr2['email'] = $_POST['dataArr']['email'];
			$data_arr2['phone'] = $_POST['dataArr']['phone'];
			$data_arr2['address'] = $_POST['dataArr']['address'];
			$data_arr2['buildingNum'] = $_POST['dataArr']['buildingNum'];
			$data_arr2['home_num'] = $_POST['dataArr']['home_num'];
			$data_arr2['city'] = $_POST['dataArr']['city'];
			$data_arr2['zip_code'] = $_POST['dataArr']['zip_code'];
			$data_arr2['note'] = $_POST['dataArr']['note'];
			$data_arr2['delivery_pay'] = $_POST['dataArr']['delivery_pay'];
			
			$lastRec = insert_to_db($data_arr2, $image_settings);
			
			$sql = "UPDATE users_ecom_buy SET insert_date = NOW() WHERE unickSES = '".$_SESSION['ecom']['unickSES']."' AND unk = '".UNK."'";
			$res = mysql_db_query( DB, $sql);
			
			
			
			if( UNK == "806700060391385236" )
			{
				$sql2 = "SELECT unk FROM user_extra_settings WHERE dogs4u_chooser_shop = '1'";
				$res2 = mysql_db_query( DB, $sql2);
				
				while( $data2 = mysql_fetch_array($res2) )
				{
					$data_arr3 = $data_arr2;
					$data_arr3['unk'] = $data2['unk'];
					insert_to_db($data_arr3, $image_settings);
					
					$sql = "UPDATE users_ecom_buy SET insert_date = NOW() WHERE unickSES = '".$_SESSION['ecom']['unickSES']."' AND unk = '".$data2['unk']."'";
					$res = mysql_db_query( DB, $sql);
				}
			}
			
			$sql_user = "select id,email,site_type from users where unk = '".UNK."' ";
			$res_user = mysql_db_query(DB,$sql_user);
			$data_user = mysql_fetch_array($res_user);
			
			$fromEmail = "info@ilbiz.co.il"; 
			$fromTitle = "il-biz"; 
			
			if( $data_user['site_type'] == "10" )
			{
				$content = "
				שלום,<br>
				<br>
				הגיע הזמנה חדשה מהאתר <a href='http://".$_SERVER['HTTP_HOST']."' class='textt' target='_blank'><u>".$_SERVER['HTTP_HOST']."</u></a><br>
				על מנת לצפות בפרטי הזמנה, יש לגשת למערכת ניהול ושם לבחור 'הזמנות מחנות אלקטרונית'<br>
				<a href='http://www.ilbiz.co.il/ClientSite/administration/login.php' class='textt' target='_blank'><u>למערכת ניהול לחץ כאן</u></a><br>
				<br>
				<br>
				בברכה,<br>
				מערכת IL-BIZ<BR>
				קידום ושיווק עסקים
				";
			}
			else 
				$content = $word[LANG]['1_1_add_order_to_DB_email_content'];
			
			
			
			$header_send_to_Client= $word[LANG]['1_1_add_order_to_DB_email_headline'];
			$content_send_to_Client = "
				<html dir=rtl>
				<head>
						<title></title>
						<style type='text/css'>
							.textt{font-family: arial; font-size:12px; color: #000000}
						</style>
				</head>
				
				<body>
					<p class='textt' dir=rtl align=right>".$content."</p>
				</body>
				</html>";
			
			if( $data_user['site_type'] == "10" )
			{
				$sql = "SELECT u.email FROM users as u , user_extra_settings as ux , user_ecom_items as ei , user_products as p where u.unk=ux.unk and ( ux.nisha_sites LIKE '%\"".$data_user['id']."\"%' OR ux.unk = '".UNK."' ) and ei.client_unickSes = '".$_SESSION['ecom']['unickSES']."' and ei.product_id = p.id and p.unk = u.unk ";
				$res_nisha = mysql_db_query(DB,$sql);
				
				while( $data_nisha = mysql_fetch_array($res_nisha) )
				{
					//if( GlobalFunctions::validate_email_address($data_nisha['email']) ) // we have a client that use multi email on this filed
					GlobalFunctions::send_emails_with_phpmailer($fromEmail, $fromTitle, $header_send_to_Client, $content_send_to_Client, $content_send_to_Client, $data_nisha['email'], $fromTitle );
				}
				GlobalFunctions::send_emails_with_phpmailer($fromEmail, $fromTitle, $header_send_to_Client, $content_send_to_Client, $content_send_to_Client, "ilan@il-biz.com", $fromTitle );
			}
			else	{
				if( GlobalFunctions::validate_email_address($data_user['email']) )
					GlobalFunctions::send_emails_with_phpmailer($fromEmail, $fromTitle, $header_send_to_Client, $content_send_to_Client, $content_send_to_Client, $data_user['email'], $fromTitle );
			}
			
			
			
			
			// רשימת אתרים לסליקה
			if( UNK != '607189207778116683' AND UNK != '625420717714095702' AND UNK != '531580994544612532' AND UNK != '514738259673354081' AND UNK != '077207507163809959' AND UNK != '244664172114634996')
			{
				$_SESSION['ecom']['unickSES'] = "";
				$_SESSION['ecom']['active'] = "";
			}
			
			
			if( UNK == "625420717714095702" )
				echo "<script type='text/javascript'>window.location.href='index.php?m=get_thanks_ecom_form&from_site=amuta-fmn';</script>";
			elseif( UNK == "531580994544612532" )
				echo "<script type='text/javascript'>window.location.href='index.php?m=get_thanks_ecom_form&from_site=sweets4u.co.il';</script>";
			elseif( UNK == "514738259673354081" )
				echo "<script type='text/javascript'>window.location.href='index.php?m=get_thanks_ecom_form&from_site=womenparadise';</script>";
			elseif( UNK == "607189207778116683" )
				echo "<script type='text/javascript'>window.location.href='index.php?m=get_thanks_paypalJewelry';</script>";
			elseif( UNK == "077207507163809959" )
				echo "<script type='text/javascript'>window.location.href='index.php?m=get_thanks_paypal__ktarim';</script>";
			elseif( UNK == "244664172114634996" )
				echo "<script type='text/javascript'>window.location.href='index.php?m=get_thanks_paypal__shangola';</script>";
			else
				echo "<script type='text/javascript'>window.location.href='index.php?m=get_thanks&type=ecom_form';</script>";
			
			exit;
	}
	else
	{
		echo "<script type='text/javascript'>alert('Error number #*2137*#');</script>";
		echo "<script type='text/javascript'>window.location.href='index.php';</script>";
			exit;
	}
	
}