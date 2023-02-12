<?php

function getLimitPagention( $params=array() )
{
	$limitInPage = $params['limitInPage'];
	$numRows = $params['numRows'];
	$limitcount = $params['limitcount'];
	$m = $params['m'];
	$cat = $params['cat'];
	$sub = $params['sub'];
	
	echo "<table align=center border=0 cellspacing=\"0\" width=100% cellpadding=\"3\" class=\"maintext\" style='font-size: 16px;'>";
		
		if( $numRows > $limitInPage )
		{
			echo "<tr>";
				/*if( $limitcount >= $limitInPage )
				{
					echo "<td>דף הקודם</td>";
				}*/
				echo "<td width=20></td>";
				echo "<td align=center>";
				
					$z = 0;
					for($i=0 ; $i < $numRows ; $i++)
					{
						$pz = $z+1;
						
						if($i % $limitInPage == 0)
						{
							$NewCat = ( $cat != "" ) ? "&amp;cat=".$cat : "";
							$NewSub = ( $sub != "" ) ? "&amp;sub=".$sub : "";
							
								if( $i == $limitcount )
									$classi = "<strong>".$pz."</strong>&nbsp;&nbsp;";
								else
									$classi = "<a href='index.php?m=".$m.$NewCat.$NewSub."&amp;PL=".$i."' class='maintext' style='font-size: 15px;'><u>".$pz."</u></a>&nbsp;&nbsp;";
								
								echo $classi;
								
								$z = $z + 1;
								
								if( $z%15 == 0 )
									echo "<br>";
						}
					}
				echo "</td>";
				echo "<td width=20></td>";
				/*if( $limitcount <= $numRows )
				{
					echo "<td>דף הבא</td>";
				}*/
			echo "</tr>";
		}
	echo "</table>";
}


function getLimitPagention2( $params=array() )
{
	$limitInPage = $params['limitInPage'];
	$numRows = $params['numRows'];
	$start = $params['limitcount'];
	$m = $params['m'];
	$cat = $params['cat'];
	$sub = $params['sub'];
	$varsValues = $params['varsValues'];
	$NewCat = ( $cat != "" ) ? "&amp;cat=".$cat : "";
	$NewSub = ( $sub != "" ) ? "&amp;sub=".$sub : "";
	$word_count = ( $params['word_count'] != "" ) ? $params['word_count'] : "רשומות";
	
	$thispage = $PHP_SELF ;
  $num = $numRows; // number of items in list
  $per_page = $limitInPage; // Number of items to show per page
  $showeachside = 5; //  Number of items to show either side of selected page

  if(empty($start))$start=0;  // Current start position

  $max_pages = ceil($num / $per_page); // Number of pages
  $cur = ceil($start / $per_page)+1; // Current page number
  
  if( $numRows > $limitInPage )
	{
	echo '<table width="100%" border="0" align="center" cellpadding="0" cellspacing="0" class="maintext" style="font-size: 15px;">';
		echo '<tr>';
			echo '<td width="99" align="center" valign="middle">';

				if(($start-$per_page) >= 0)
				{
					$next = $start-$per_page;
					$temp = ($next>0?("&amp;PL=").$next:"");
					echo "<a href='index.php?m=".$m.$varsValues.$NewCat.$NewSub.$temp."' class='maintext' style='font-size: 15px;'>הקודם</a>";
				}
	
			echo '</td>';
			echo '<td width="201" align="center" valign="middle">';
				echo "דף מספר ".$cur." מתוך ".$max_pages."<br>( ".$num." ".$word_count." )";
			echo '</td>';
			echo '<td width="100" align="center" valign="middle">';
				
				if($start+$per_page<$num)
				{
					$temp = "&amp;PL=".max(0,$start+$per_page);
					echo "<a href='index.php?m=".$m.$varsValues.$NewCat.$NewSub.$temp."' class='maintext' style='font-size: 15px;'>הבא</a> ";
				}
			echo '</td>';
		echo '</tr>';
		echo '<tr><td colspan="3" align="center" valign="middle">&nbsp;</td></tr>';
		echo '<tr>';
			echo '<td colspan="3" align="center" valign="middle">';
			
				$eitherside = ($showeachside * $per_page);
					if($start+1 > $eitherside)
						print (" .... ");
					
					$pg=1;
					for($y=0;$y<$num;$y+=$per_page)
					{
	   				 if(($y > ($start - $eitherside)) && ($y < ($start + $eitherside)))
	   				 {
	   				 	$temp = ($y>0?("&amp;PL=").$y:"");
	   				 	if( $y == $start)
	   				 		echo "&nbsp;<b>".$pg."</b>&nbsp;";
	   				 	else
								echo "&nbsp;<a class='maintext' style='font-size: 15px;' href='index.php?m=".$m.$varsValues.$NewCat.$NewSub.$temp."'><u>".$pg."</u></a>&nbsp;";
	    			 }
	   				$pg++;
					}
					if(($start+$eitherside)<$num)
						print (" .... ");
			echo '</td>';
		echo '</tr>';
		echo '<tr>';
			echo '<td colspan="3" align="center">';
	   	 for($x=$start;$x<min($num,($start+$per_page)+1);$x++)print($items[$x]."<br>");
			echo '</td>';
		echo '</tr>';
	echo '</table>';
	}
}

function getKobiaDesigner( $type , $limitFather="" , $order="")
{
	global $word,$settings,$data_colors,$data_name,$data_extra_settings;
	
	$items_on_row = "3";
	
	$kobiaColorTitle = ( $data_extra_settings['kobiaColorTitle'] != "" ) ? "style='color: #".$data_extra_settings['kobiaColorTitle']."; text-decoration: none; font-size:14px; padding:0px; margin:0px;' " : "style='font-size:14px; padding:0px; margin:0px;'";
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
			
			$addLimit = ( $limitFather != "" ) ? "LIMIT ".$limitFather : "";
			$addOrder = ( $order != "" ) ? $order : "place";
			$sql = "select * from user_sales where unk = '".UNK."' ".$show_end_date." and deleted = '0' and status = '0' order by ".$addOrder." " . $addLimit;
			
			$img_lib = "sales";
			$link_to_single = "s.sa";
			
			$words_more = "1_1_sales_more_info";
		break;
		
		case "products" :
			
			$sql = "SELECT id FROM user_products_subject WHERE unk = '".UNK."' and deleted = '0' and active = '0' ORDER BY rand()";
			$res_subject = mysql_db_query(DB,$sql);
			$subject_cat = mysql_fetch_array($res_subject);
			
			if( $_GET['sub'] == "" )	{
				$subject_id = "AND subject_id = '".$subject_cat['id']."'";
				$_GET['sub'] = $subject_cat['id'];
			}
			else
				$subject_id = "AND subject_id = ".ifint($_GET['sub']);
			
			if( $data_name['site_type'] == "10" )	{
				$sql = "select * from user_products_cat where unk = '".UNK."' and deleted = '0' and status = '0' ".$subject_id." order by id limit 1";
				$res_cat = mysql_db_query(DB,$sql);
				$data_cat = mysql_fetch_array($res_cat);
				//echo $sql;
				$temp_cat = ( $_GET['cat'] ) ? (int)$_GET['cat'] : (int)$data_cat['id'];
				
				$sql = "select up.* from user_extra_settings as uxs, user_products as up ";
				//if( $temp_cat != "0" )
				$sql .= "INNER JOIN user_model_cat_belong as umcb ON umcb.catId='".(int)$temp_cat."' AND umcb.model='products' AND umcb.itemId=up.id ";
				$sql .= "WHERE uxs.unk = up.unk and up.deleted = 0 and up.active = '0' and ( uxs.nisha_sites LIKE '%\"".$data_name['id']."\"%' OR uxs.unk = '".UNK."' ) and up.id != '".ifint($_GET['ud'])."' ";
				if( $temp_cat != "0" )	
				$sql .= "order by up.id desc, up.place"; 
				//else $sql .= "order by rand()";
				//echo $sql;
			}
			else
			{
				$sql = "select * from user_products_cat where unk = '".UNK."' and deleted = '0' and status = '0' ".$subject_id." order by id limit 1";
				$res_cat = mysql_db_query(DB,$sql);
				$data_cat = mysql_fetch_array($res_cat);
				
				$temp_cat = ( $_GET['cat'] ) ? $_GET['cat'] : $data_cat['id'];
				$sql = "select up.* from user_products as up INNER JOIN user_model_cat_belong as umcb ON umcb.catId='".ifint($temp_cat)."' AND umcb.model='products' AND umcb.itemId=up.id WHERE up.deleted = 0 and up.unk = '".UNK."' and up.active = '0' order by up.place";
			}
			
			
			$img_lib = "products";
			$link_to_single = "s.pr&amp;cat=".$_GET['cat']."&amp;sub=".$_GET['sub']."";
			
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
			$temp_cat = ( $_GET['cat'] ) ? " and cat='".ifint($_GET['cat'])."'" : "";
			$sql = "select * from user_video where unk = '".UNK."' and deleted = '0' ".$temp_cat." and active = '0' order by id desc, place";
			
			$img_lib = "video";
			$link_to_single = "s.vi&amp;cat=".$_GET['cat']."";
			
			$words_more = "1_1_video_more_info";
			
			if( $data_name['have_ProGal_cats'] == 0 )
			{
				$extra_tr =  "<tr>";
					$extra_tr .=  "<td width=\"100%\" colspan=10>".get_video_cat($_GET['cat'])."</td>";
				$extra_tr .=  "</tr>";
			}
			
		break;
	}
	
	$limitcount = ( $_GET['PL'] == "" ) ? $_POST['PL'] : $_GET['PL'];
	$limitcount = ( $limitcount == "" ) ? "0" : ifint($limitcount);
	
	$res2 = mysql_db_query(DB,$sql);
	$num_rows = mysql_num_rows($res2);
	
	if( $limitFather == "" )
		$res = mysql_db_query(DB, $sql." LIMIT ".$limitcount.",21" );
	else
		$res = mysql_db_query(DB, $sql );
	
	if( $type == "products" )
	{
		if( $data_name['pr_popUpType2'] == "1" )
		{
			$sqlPopUp = "select up.* from user_products as up INNER JOIN user_model_cat_belong as umcb ON umcb.catId='".ifint($temp_cat)."' AND umcb.model='products' AND umcb.itemId=up.id WHERE up.deleted = 0 and up.unk = '".UNK."' and up.active = '0' order by up.place";
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
			
			if( $counter%$items_on_row == 0 )
			echo "<tr valign=top>";
			
			$abpath_temp = $server_path."/".$img_lib."/".$data['img'];
				
				
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
							$tr_dv_1 = "<div class=\"product_container\"><div id=\"slidingProduct".$data['id']."\" class=\"sliding_product\">";
							$tr_dv_2 = "</div></div>";
						}
						
						$content_item = "<table width=\"100%\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\" class=\"maintext\" ".$kobiaColorMid.">";
							$content_item .= "<tr>";
								$content_item .= "<td><p style='padding:0px; margin:0px;'>".nl2br(stripslashes(htmlspecialchars($data['summary'])))."</p></td>";
							$content_item .= "</tr>";
							$content_item .= "<tr><td height=5></td></tr>";
							
							if( $data['kobia_msg'] != "" )
							{
								$kobia_msg_style = ( $data['kobia_msg_bg'] != "" ) ? "background-color: #".$data['kobia_msg_bg'].";" : "";
								$kobia_msg_color = ( $data['kobia_msg_color'] != "" ) ? "color: #".$data['kobia_msg_color'].";" : "";
								
								$content_item .= "<tr>";
									$content_item .= "<td align=center><font style='padding:2px; ".$kobia_msg_style.$kobia_msg_color."'>".nl2br(stripslashes(htmlspecialchars($data['kobia_msg'])))."</font></td>";
								$content_item .= "</tr>";
								$content_item .= "<tr><td height=5></td></tr>";
							}
							
							if( $data['price'] != "" )
							{
								if( UNK == "285240640927706447" )
								{
									if( $data['price_10service'] > 0 )
									{
										$content_item .= "<tr>";
											$content_item .= "<td align=center>";
												$content_item .= "<table width=100% border=\"0\" cellspacing=\"0\" cellpadding=\"0\" class=\"maintext\">";
													$content_item .= "<tr>";
														$content_item .= "<td style='text-decoration:line-through'>מחיר: <b>".$data['price']." ".COIN."</b></td>";
														$content_item .= "<td width=10></td>";
														$content_item .= "<td><u>מחיר 10:</u> <b>".$data['price_10service']." ".COIN."</b></td>";
													$content_item .= "</tr>";
												$content_item .= "</table>";
											$content_item .= "</td>";
										$content_item .= "</tr>";
										$content_item .= "<tr><td height=5></td></tr>";
									}
									
									
									$content_item .= "<tr>";
										$content_item .= "<td align=center>";
											if( $data['remain_stock'] == 1 )
												$content_item .= "נותרה עוד <b>יחידה</b> אחת";
											elseif( $data['remain_stock'] > 1 )
												$content_item .= "נותרו עוד <b>".$data['remain_stock']."</b> יחידות";
											else
												$content_item .= "נותרו עוד <b>".$data['remain_stock']."</b> יחידות";
										$content_item .= "</td>";
									$content_item .= "</tr>";
									$content_item .= "<tr><td height=5></td></tr>";
									
									// check if i have more then 1 same product
									/*$sql = "SELECT id FROM user_ecom_items WHERE product_id = '".$data['id']."' AND unk = '".UNK."' AND client_unickSes = '".$_SESSION['ecom']['unickSES']."' ";
									$res_checker1 = mysql_db_query(DB,$sql);
									$data_checker1 = mysql_num_rows($res_checker1);*/
								}
								else
								{
									$content_item .= "<tr>";
										$content_item .= "<td>".$word[LANG]['1_1_products_price'].": <b>".$data['price']." ".COIN."</b></td>";
									$content_item .= "</tr>";
									$content_item .= "<tr><td height=5></td></tr>";
									
									if( UNK == "625420717714095702" && $data['price_special'] > "0" )
									{
										$content_item .= "<tr>";
											$content_item .= "<td>מחיר לחברי העמותה: <b>".$data['price_special']." ".COIN."</b></td>";
										$content_item .= "</tr>";
										$content_item .= "<tr><td height=5></td></tr>";
									}
									
								//	$data_checker1 = "ok";
								}
								
								
								if( $data_name['have_ecom'] == "1" && $data['active_ecom'] == "1" )
								{
									$abpath_tempcartAddImg = SERVER_PATH."/tamplate/".stripslashes($data_extra_settings['cartAddImg']);
									
									$content_item .= "<tr>";
										if( file_exists($abpath_tempcartAddImg) && !is_dir($abpath_tempcartAddImg) )
											$content_item .= "<td><div id='addToBasketButton".$data['id']."'><a href='javascript:void(0)' onclick=\"addToBasket(".$data['id'].");return false\"><img src='/tamplate/".stripslashes($data_extra_settings['cartAddImg'])."' border=0 alt=''></a></div></td>";
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
						$link_pr_popup = "<a href=\"index.php?m=".$link_to_single."&amp;ud=".$data['id']."\" class=\"maintext\" title=\"".htmlspecialchars(stripslashes($data['name']))."\" ".$kobiaColorTitle.">";
					
					if( $data_name['site_type'] == "10" )
					{
						if( $data['url_link'] != "" )
							$link_pr_popup = "<a href=\"".$data['url_link']."\" target='_blank' class=\"maintext\" title=\"".htmlspecialchars(stripslashes($data['name']))."\" ".$kobiaColorTitle.">";
						else
							$link_pr_popup = "<a href=\"index.php?m=".$link_to_single."&amp;ud=".$data['id']."\" class=\"maintext\" title=\"".htmlspecialchars(stripslashes($data['name']))."\" ".$kobiaColorTitle.">";
					}
				}
				else
					$link_pr_popup = "<a href=\"index.php?m=".$link_to_single."&amp;ud=".$data['id']."\" class=\"maintext\" title=\"".htmlspecialchars(stripslashes($data['name']))."\" ".$kobiaColorTitle.">";
				
				
				if( file_exists($abpath_temp) && !is_dir($abpath_temp) )
				{
					$im_size = GetImageSize ($abpath_temp); 
					$imageWidth = $im_size[0]; 
					$imageheight = $im_size[1]; 
					
					if( $imageWidth > "151" )
						$imageWidth = "151";
					
					$img_src = $link_pr_popup;
						$img_src .= "<img src='".$http_path."/".$img_lib."/".$data['img']."' border='0' width=\"".$imageWidth."\" alt=''></a>";
				}
				else
					$img_src = "";
					
				echo "<td valing='top' height=\"100%\" style='height: 100%;'>";
					echo $tr_dv_1;
					
					echo "<table border=\"0\" cellspacing=\"0\" style=\"height: 100%\" cellpadding=\"0\" class=\"maintext\" width=\"171\">";
						
						if( !empty($data_colors['kobia_top']) )
						{
						echo "<tr>";
							echo "<td height=\"".stripslashes($data_colors['kobia_top_height'])."\"><img src='tamplate/".stripslashes($data_colors['kobia_top'])."' border=0 alt=''></td>";
						echo "</tr>";
						}
						
						echo "<tr>";
							echo "<td background=\"tamplate/".stripslashes($data_colors['kobia_top_back'])."\" valign=top height=34>";
								echo "<table border=\"0\" cellspacing=\"0\" cellpadding=\"0\" class=\"maintext\" width=\"100%\">";
									echo "<tr>";
										echo "<td width=10></td>";
										echo "<td align=\"center\" valign=\"top\" ".$kobiaColorTitle."><h2 ".$kobiaColorTitle.">".$link_pr_popup."".htmlspecialchars(stripslashes($data['name']))."</a></h2></td>";
										echo "<td width=10></td>";
									echo "</tr>";
								echo "</table>";
							echo "</td>";
						echo "</tr>";
						
						
						echo "<tr style='height: 100%;' valign=top>";
							echo "<td background=\"tamplate/".stripslashes($data_colors['kobia_back'])."\" valign=top height=\"100%\">";
								echo "<table border=\"0\" cellspacing=\"0\" cellpadding=\"0\" class=\"maintext\" width=\"100%\" style='height: 100%;'>";
									echo "<tr>";
										echo "<td width=10></td>";
										echo "<td valing='top'>";
											echo "<table border=\"0\" cellspacing=\"0\" cellpadding=\"0\" class=\"maintext\" width=\"151\">";
												echo "<tr>";
													echo "<td align=center valing='top'>".$img_src."</td>";
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
						
						
						echo "<tr>";
							echo "<td background=\"tamplate/".stripslashes($data_colors['kobia_bottom_back'])."\" height=18>";
								echo "<table border=\"0\" cellspacing=\"0\" cellpadding=\"0\" class=\"maintext\" width=\"100%\">";
									echo "<tr>";
										echo "<td width=10></td>";
										echo "<td align='center'>".$link_pr_popup."<b ".$kobiaColorMore.">".$word[LANG][$words_more]."</b></a></td>";
										echo "<td width=10></td>";
									echo "</tr>";
								echo "</table>";
							echo "</td>";
						echo "</tr>";
						
						if( !empty($data_colors['kobia_bottom']) )
						{
						echo "<tr>";
							echo "<td height=\"".stripslashes($data_colors['kobia_bottom_height'])."\" background=\"tamplate/".stripslashes($data_colors['kobia_bottom'])."\"></td>";
						echo "</tr>";
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
		
		echo "<tr>";
			echo "<td align=center colspan=10>";
				$params['limitInPage'] = "21";
				$params['numRows'] = $num_rows;
				$params['limitcount'] = $limitcount;
				$params['m'] = $_GET['m'];
				$params['cat'] = $_GET['cat'];
				$params['sub'] = $_GET['sub'];
				
				getLimitPagention( $params );
				
			echo "<td>";
		echo "</tr>";
		
	echo "</table>";
}


function rightMenu__print_link()
{
	global $word;
	
	$arr_can_print = array( "gallery" , "ga" , "hp" , "contact");
	
	$can_print = FALSE;
	foreach( $arr_can_print as $val )
	{
		if( $val == $m )
		{
			$can_print = FALSE;
			break;
		}
		else
			$can_print = TRUE;
	}
	
	if( $can_print == TRUE )
	{
		echo "<tr>";
			echo "<td width=\"5\">";
			echo "<td align='center' class='rightMemu'>";
				echo "<a href='print.php?".str_replace( "&" , "&amp;" , $_SERVER['argv']['0'])."' class='rightMemu' style='font-size:10px;' target='_blank'>".$word[LANG]['1_2_print_version']."</a>";
			echo "</td>";
			echo "<td width=\"5\">";
		echo "</tr>";
	}
}


function rightMenu__links()
{
	global $img_bg_links,$arr_main_text,$arr_main,$data_words,$data_extra_settings;
	
	$sql_links_list_content = "select name,type,hide_page from content_pages where type != 'text' and name != '' and type != 'contact' and type != 'gb' and deleted = '0' and unk = '".UNK."' ORDER BY place,id";
	$res_links_list_content = mysql_db_query(DB,$sql_links_list_content);
	$num_rows = mysql_num_rows($res_links_list_content);
	
	if( $img_bg_links == "" )
	{
		//if( $num_rows > 0 )
		//{
			echo "<ul id=\"menu\">";
			
				foreach( $arr_main_text as $val => $key )	{
					if( $key != "" )	{
						$tmp_hidde_name = "hidde_about";
						if( $data_words[$tmp_hidde_name] == "0" )
						{
							if( $data_extra_settings['estimateSite'] == "1" )
								echo "<li><a href=\"http://".$_SERVER['HTTP_HOST']."\" title=\"".$key."\">".$key."<span></span></a></li>";
							else
								echo "<li><a href=\"index.php?m=".$val."&amp;t=text\" title=\"".$key."\">".$key."<span></span></a></li>";
						}
					}
				}
				
				while( $data_links_list_content = mysql_fetch_array($res_links_list_content) )
				{
					if( $data_links_list_content['hide_page'] == "0" )
					{
						//if( $data_extra_settings['estimateSite'] == "1" )
						//	$url_href = "/".$data_links_list_content['type']."/".stripslashes($data_links_list_content['name']);
						//else
							$url_href = "index.php?m=text&amp;t=".$data_links_list_content['type'];
						echo "<li><a href=\"".$url_href."\" title=\"".stripslashes($data_links_list_content['name'])."\">".stripslashes($data_links_list_content['name'])."<span></span></a></li>";
					}
				}
				
				foreach( $arr_main as $val => $key )	{
					if( $key != "" )
					{
						$val_or_wanted = ( $val == "jobs" ) ? "wanted" : $val;
						$val_or_wanted_ar = ( $val == "arLi" ) ? "articels" : $val_or_wanted;
						$tmp_hidde_name = "hidde_".$val_or_wanted_ar;
						
						if( $val != "arLi" )
							$newVal = $val{0}.$val{1};
						else
							$newVal = $val;
						
						if( $data_words[$tmp_hidde_name] == "0" )
							echo "<li><a href=\"index.php?m=".$newVal."\" title=\"".$key."\">".$key."<span></span></a></li>";
					}
				}
			echo "</ul>";
		//}
	}
	else
	{
			foreach( $arr_main_text as $val => $key )	{
				if( $key != "" )
				{	
					$tmp_hidde_name = "hidde_about";
					if( $data_words[$tmp_hidde_name] == "0" )
					{
						$RMstr .= "<tr>";
							$RMstr .= "<td width='1'></td>";
							$RMstr .= "<td ".$img_bg_links." width='140' height='31' align='center'><a href=\"index.php?m=".$val."&amp;t=text\" title=\"".$key."\" class=\"rightMemu\">".$key."<span></span></a></td>";
						$RMstr .= "</tr>";
						$RMstr .= "<tr><td colspan='2' height='3'></td></tr>";
					}
				}
			}
			
			while( $data_links_list_content = mysql_fetch_array($res_links_list_content) )
			{
				if( $data_links_list_content['hide_page'] == "0" )
				{
					$RMstr .= "<tr>";
						$RMstr .= "<td width='1'></td>";
						$RMstr .= "<td ".$img_bg_links." width='140' height='31' align='center'><a href=\"index.php?m=text&amp;t=".$data_links_list_content['type']."\" class=\"rightMemu\" title=\"".stripslashes($data_links_list_content['name'])."\">".stripslashes($data_links_list_content['name'])."<span></span></a></td>";
					$RMstr .= "</tr>";
					$RMstr .= "<tr><td colspan='2' height='3'></td></tr>";
				}
			}
													
			foreach( $arr_main as $val => $key )	{
				if( $key != "" )
				{
					$val_or_wanted = ( $val == "jobs" ) ? "wanted" : $val;
					$val_or_wanted_ar = ( $val == "arLi" ) ? "articels" : $val_or_wanted;
					$tmp_hidde_name = "hidde_".$val_or_wanted_ar;
					
					if( $val != "arLi" )
						$newVal = $val{0}.$val{1};
					else
						$newVal = $val;
					
					if( $data_words[$tmp_hidde_name] == "0" )
					{
						$RMstr .= "<tr>";
							$RMstr .= "<td width='1'></td>";
							$RMstr .= "<td ".$img_bg_links." width='140' height='31' align='center'><a href=\"index.php?m=".$newVal."\" title=\"".$key."\" class=\"rightMemu\">".$key."<span></span></a></td>";
						$RMstr .= "</tr>";
						$RMstr .= "<tr><td colspan='2' height='3'></td></tr>";
					}
				}
			}
		
		if( $RMstr != "" )
		{
			echo "<table border=\"0\" cellspacing=\"0\" cellpadding=\"0\" class=\"rightMemu\">";
				echo $RMstr;
			echo "</table>";
		}
	}
}


function rightMenu__db_links()
{
	global $img_bg_links,$word;
	
	$sql_links_list = "select id,name_link,url,link_target from user_more_link where deleted = '0' and unk = '".UNK."' AND father_id=0 ORDER BY place,id";
	$res_links_list = mysql_db_query(DB,$sql_links_list);
	$num_rows = mysql_num_rows($res_links_list);
	
	
	if( $img_bg_links == "" )
	{
		if( $num_rows > 0 )
		{
			echo "<ul id=\"menu2\">";
				while( $data_links_list = mysql_fetch_array($res_links_list) )
				{
					$sql_links_list = "select name_link,url,link_target from user_more_link where deleted = '0' and unk = '".UNK."' AND father_id='".$data_links_list['id']."' ORDER BY place,id";
					$res_links_list_cat = mysql_db_query(DB,$sql_links_list);
					
					$target_link = ( $data_links_list['link_target'] == "0" ) ? "_blank" : "_self";
					echo "<li ><a href=\"".htmlspecialchars(stripslashes($data_links_list['url']))."\" title=\"".htmlspecialchars(stripslashes($data_links_list['name_link']))."\" target=\"".$target_link."\">".htmlspecialchars(stripslashes($data_links_list['name_link']))."<span></span></a></li>";
					
						while( $data_links_list_cat = mysql_fetch_array($res_links_list_cat) )
						{
							$target_link = ( $data_links_list_cat['link_target'] == "0" ) ? "_blank" : "_self";
							echo "<li><a href=\"".htmlspecialchars(stripslashes($data_links_list_cat['url']))."\" title=\"".htmlspecialchars(stripslashes($data_links_list_cat['name_link']))."\" target=\"".$target_link."\">&nbsp;&nbsp;&nbsp;&nbsp;".htmlspecialchars(stripslashes($data_links_list_cat['name_link']))."<span></span></a></li>";
						}
				}
			echo "</ul>";
		}
	}
	else
	{
		if( $num_rows > 0 )
		{
			echo "<table border=\"0\" cellspacing=\"0\" cellpadding=\"0\" class=\"rightMemu\">";
				
				while( $data_links_list = mysql_fetch_array($res_links_list) )
				{
					$sql_links_list = "select name_link,url,link_target from user_more_link where deleted = '0' and unk = '".UNK."' AND father_id='".$data_links_list['id']."' ORDER BY place,id";
					$res_links_list_cat = mysql_db_query(DB,$sql_links_list);
					
					
					$target_link = ( $data_links_list['link_target'] == "0" ) ? "_blank" : "_self";
					echo "<tr>";
						echo "<td width='1'></td>";
						echo "<td ".$img_bg_links." width='140' height='31' align='center'><a href=\"".htmlspecialchars(stripslashes($data_links_list['url']))."\" title=\"\" target=\"".$target_link."\" class=\"rightMemu\">".htmlspecialchars(stripslashes($data_links_list['name_link']))."<span></span></a></td>";
					echo "</tr>";
					echo "<tr><td colspan='2' height='3'></td></tr>";
					
					while( $data_links_list_cat = mysql_fetch_array($res_links_list_cat) )
					{
						$target_link = ( $data_links_list_cat['link_target'] == "0" ) ? "_blank" : "_self";
						echo "<tr>";
							echo "<td width='1'></td>";
							echo "<td ".$img_bg_links." width='140' height='31' align='center'><a href=\"".htmlspecialchars(stripslashes($data_links_list_cat['url']))."\" title=\"\" target=\"".$target_link."\" class=\"rightMemu\">&nbsp;&nbsp;".htmlspecialchars(stripslashes($data_links_list_cat['name_link']))."<span></span></a></td>";
						echo "</tr>";
						echo "<tr><td colspan='2' height='3'></td></tr>";
					}
				}
			
			echo "</table>";
		}
	}
}


function topMenu__chromemenu()
{
	global $width_content,$data_name;
	
	$sql = "select * from user_topMenu_link where unk = '".UNK."' and deleted = '0' and father = '0' order by place, id";
	$res_topmenu = mysql_db_query(DB,$sql);
	$num_topmenu = mysql_num_rows($res_topmenu);
	
	echo "<tr>";
		echo "<td colspan=\"3\">";
			echo "<table border=\"0\" cellspacing=\"0\" cellpadding=\"0\" width=".$width_content.">";
				echo "<tr>";
					echo "<td>";
						if( $data_name['have_rightmenu'] != "0" )
						{
							if( $data_name['have_searchEng'] == "0" )
								echo search_form();
						}
					echo "</td>";
					echo "<td width='5'></td>";
					echo "<td>";
						$str_tat = "";
						
					$Browser = detectBrowser();
					
					if( $Browser['app.Name'] == "msie" && ( $Browser['app.Ver'] == "6.0" || $Browser['app.Ver'] == "6.1" ) )
					{
						if( $num_topmenu > 0 )
						{
							echo "<table border=\"0\" cellspacing=\"0\" cellpadding=\"0\">";
							
								echo "<tr class='ie6_top_menu'><td>";
								$count = 0;
								$arry_to_close = array();
									while( $data_topmenu = mysql_fetch_array($res_topmenu) )
									{
										
										$sql_tat = "select * from user_topMenu_link where unk = '".UNK."' and deleted = '0' and father = '".$data_topmenu['id']."' order by place, id";
										$res_tat = mysql_db_query(DB,$sql_tat);
										$num_TAT = mysql_num_rows($res_tat);
										
										echo '<div style="display: inline">';
											if( $num_TAT > 0 )
											{
												$arry_to_close[] = $data_topmenu['id'];
												echo "<a href=\"javascript:void(0)\" onclick='topMenu_ie6_open_close_tabs(\"topMenu_".$data_topmenu['id']."\")' title=\"".stripslashes($data_tat['name_link'])."\" target=\"_self\" class='ie6_top_menu_link'>".stripslashes($data_topmenu['name_link'])."</a>";
									 		}	
									 		else
									 			echo "<a href=\"".stripslashes($data_topmenu['url'])."\" title=\"".stripslashes($data_tat['name_link'])."\" target=\"_self\" class='ie6_top_menu_link'>".stripslashes($data_topmenu['name_link'])."</a>";
									  echo "</div>";
									  
									}
								echo '</td></tr>';
							echo "</table>";
							
							$sql = "select * from user_topMenu_link where unk = '".UNK."' and deleted = '0' and father = '0' order by place, id";
							$res_topmenu = mysql_db_query(DB,$sql);
							$num_topmenu = mysql_num_rows($res_topmenu);
							
							echo "<table border=\"0\" cellspacing=\"0\" cellpadding=\"0\">";
								echo "<tr class='ie6_top_menu'>";
								$count = 0;
									
									while( $data_topmenu = mysql_fetch_array($res_topmenu) )
									{
										$sql_tat = "select * from user_topMenu_link where unk = '".UNK."' and deleted = '0' and father = '".$data_topmenu['id']."' order by place, id";
										$res_tat = mysql_db_query(DB,$sql_tat);
										$num_TAT = mysql_num_rows($res_tat);
										
										 if( $num_TAT > 0 )
								      {
								      	echo "<td>";
								      	echo "<div id='topMenu_".$data_topmenu['id']."' style='display: none;'>";
								      		echo "<table border=\"0\" cellspacing=\"0\" cellpadding=\"0\">";
								      			echo "<tr class='ie6_top_menu'><td>";
															while( $data_tat = mysql_fetch_array($res_tat) )
															{
																echo "<div style='display: inline;' ><a href=\"".stripslashes($data_tat['url'])."\" title=\"".stripslashes($data_tat['name_link'])."\" target=\"_self\" class='ie6_top_menu_link'>".stripslashes($data_tat['name_link'])."</a></div>";
											        }
									      		echo '</td></tr>';
									       echo '</table>';
									       
									      echo "</div>";
									      
									      echo "</td>";
									    }
									}
								echo '</tr>';
								
							echo '</table>';
							
							
							/*echo '
<script>
		// Copyright 2006-2007 javascript-array.com

var timeout	= 500;
var closetimer	= 0;
var ddmenuitem	= 0;

// open hidden layer
function mopen(id)
{	
	// cancel close timer
	mcancelclosetime();

	// close old layer
	if(ddmenuitem) ddmenuitem.style.visibility = \'hidden\';

	// get new layer and show it
	ddmenuitem = document.getElementById(id);
	ddmenuitem.style.visibility = \'visible\';

}
// close showed layer
function mclose()
{
	if(ddmenuitem) ddmenuitem.style.visibility = \'hidden\';
}

// go close timer
function mclosetime()
{
	closetimer = window.setTimeout(mclose, timeout);
}

// cancel close timer
function mcancelclosetime()
{
	if(closetimer)
	{
		window.clearTimeout(closetimer);
		closetimer = null;
	}
}

// close layer when click-out
document.onclick = mclose; 

	</script>
	<ul id="sddm">';
		while( $data_topmenu = mysql_fetch_array($res_topmenu) )
		{
			$sql_tat = "select * from user_topMenu_link where unk = '".UNK."' and deleted = '0' and father = '".$data_topmenu['id']."'";
			$res_tat = mysql_db_query(DB,$sql_tat);
			$num_TAT = mysql_num_rows($res_tat);
			
			$opend_drop = ( $num_TAT > 0 ) ? " onmouseover=\"mopen('m".$data_topmenu['id']."')\" onmouseout=\"mclosetime()\"" : "";
			echo '<li><a href="'.stripslashes($data_topmenu['url']).'" '.$opend_drop.'>'.stripslashes($data_topmenu['name_link']).'</a>';
        if( $num_TAT > 0 )
        {
	        echo '<div id="m'.$data_topmenu['id'].'" onmouseover="mcancelclosetime()" onmouseout="mclosetime()">';
						while( $data_tat = mysql_fetch_array($res_tat) )
						{
							echo '<a href="'.stripslashes($data_tat['url']).'">'.stripslashes($data_tat['name_link']).'</a>';
		        }
	        echo '</div>';
       	}
   	 echo '</li>';
			
		}
echo '</ul>
<div style="clear:both"></div>';*/
						}
					}
					else
					{
						echo '<div id="outside">';
								echo '<ul id="navigation-1">';
									while( $data_topmenu = mysql_fetch_array($res_topmenu) )
									{
										
										$sql_tat = "select * from user_topMenu_link where unk = '".UNK."' and deleted = '0' and father = '".$data_topmenu['id']."'";
										$res_tat = mysql_db_query(DB,$sql_tat);
										$num_TAT = mysql_num_rows($res_tat);
										
										echo "<li><a href=\"".stripslashes($data_topmenu['url'])."\" title=\"".stripslashes($data_tat['name_link'])."\" target=\"_self\">".stripslashes($data_topmenu['name_link'])."</a>";
								      if( $num_TAT > 0 )
								      {
								      	echo '<ul class="navigation-2">';
													while( $data_tat = mysql_fetch_array($res_tat) )
													{
														echo "<li><a href=\"".stripslashes($data_tat['url'])."\" title=\"".stripslashes($data_tat['name_link'])."\" target=\"_self\">".stripslashes($data_tat['name_link'])."</a></li>";
									        }
									      echo '</ul>';
									    }
									  echo "
									  </li>";
									}
								echo '</ul>';
							echo '</div>';
							
						/*$counter_topmenu = 1;
						while( $data_topmenu = mysql_fetch_array($res_topmenu) )
						{
							
							if( $counter_topmenu == "1" )
							{
								echo "<div class=\"chromestyle\" id=\"chromemenu\">";
									echo "<ul>";
							}
						
							$sql_tat = "select * from user_topMenu_link where unk = '".UNK."' and deleted = '0' and father = '".$data_topmenu['id']."'";
							$res_tat = mysql_db_query(DB,$sql_tat);
							$num_TAT = mysql_num_rows($res_tat);
										
							$rel_tag = ( $num_TAT > 0 ) ? "rel=\"dropmenu".$data_topmenu['id']."\"": "";
							echo "<li><a href=\"".stripslashes($data_topmenu['url'])."\" ".$rel_tag." >".stripslashes($data_topmenu['name_link'])."</a></li>";
							
							$counter_topmenu_tat = 1;
							while( $data_tat = mysql_fetch_array($res_tat) )
							{
								if( $counter_topmenu_tat == "1" )
									$str_tat .= "<div id=\"dropmenu".$data_topmenu['id']."\" class=\"dropmenudiv\">";
								
								$str_tat .= "<a href=\"".stripslashes($data_tat['url'])."\">".stripslashes($data_tat['name_link'])."</a>";
								
								if( $num_TAT == $counter_topmenu_tat )
									$str_tat .= "</div>";
								
								$counter_topmenu_tat++;
							}
							
							if( $num_topmenu == $counter_topmenu )
							{
									echo "</ul>";
								echo "</div>";
								echo $str_tat;
							}
						
							$counter_topmenu++;
						}
						
						echo "<script type=\"text/javascript\">
							cssdropdown.startchrome(\"chromemenu\")
						</script>";*/
					}
					echo "</td>
				</tr>	
			</table>
		</td>
	</tr>";
}


function continer__headline()
{
 global $arr_headlines,$m,$settings;
 
	echo "<tr><td colspan=\"3\" height=\"10\"></td></tr>";
	
	echo "<tr>";
		echo "<td width=\"50\"></td>";
				foreach( $arr_headlines as $val => $key )	{
					if( $m == $val )
						if( $m == "text" && $_GET['t'] == "text")
							echo "<td valign=\"top\" style='padding-".$settings['align'].": 30px;'><h1 class=\"page_headline\">".$key."</h1></td>";
						elseif( $m == "text" && $_GET['t'] != "text")
							echo "";
						else 
							echo "<td valign=\"top\" style='padding-".$settings['align'].": 30px;'><h1 class=\"page_headline\">".$key."</h1></td>";
				}
				
				if( $m == "text" && $_GET['t'] != "text")
				{
					if( isset($_GET['lib']) && $_GET['t'] == "" )
					{
						$qry = "SELECT id FROM content_pages WHERE deleted=0 AND lib=".ifint($_GET['lib'])." AND unk = '".UNK."' ORDER BY id LIMIT 1";
						$res = mysql_db_query( DB , $qry );
						$data = mysql_fetch_array($res);
						$_GET['t'] = $data['id'];
					}
					
					$sql_headline_type = "select name,type from content_pages where type = '".$_GET['t']."' and type != 'text' and name != '' and type != 'contact' and deleted = '0' and unk = '".UNK."' ORDER BY place,id";
					$res_headline_type = mysql_db_query(DB,$sql_headline_type);
					$data_headline_type = mysql_fetch_array($res_headline_type);
					
					echo "<td valign=\"top\" style='padding-".$settings['align'].": 30px;'><h1 class=\"page_headline\">".stripslashes($data_headline_type['name'])."</h1></td>";
				}
		echo "<td width=\"50\"></td>";
	echo "</tr>";
	
}

function gallery_type_6()
{
	global $word;
	$L = ( $_GET['L'] == "") ? "0" : ifint($_GET['L']);
	
	$subject_id = ( $_GET['sub'] == "" ) ? "AND subject_id = ''" : "AND subject_id = ".ifint($_GET['sub']);
	$sql = "select * from user_gallery_cat where unk = '".UNK."' and deleted = '0' and active = '0' ".$subject_id." limit 1";
	$res = mysql_db_query(DB,$sql);
	$data_cat = mysql_fetch_array($res);
	
	
	$temp_cat = ( $_GET['cat'] ) ? ifint($_GET['cat']) : $data_cat['id'];
	$temp_catZero = ( $_GET['cat'] != "" ) ? ifint($_GET['cat']) : "0";
	
	$sql = "select * from user_gallery_images where unk = '".UNK."' and deleted = '0' and cat = '".$temp_cat."' order by place limit ".$L.",12";
	$res = mysql_db_query(DB,$sql);
	
	$sql = "select id from user_gallery_images where unk = '".UNK."' and deleted = '0' and cat = '".$temp_cat."'";
	$res_num = mysql_db_query(DB,$sql);
	$num_rows = mysql_num_rows($res_num);
	
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
				echo "<td width=\"100%\" align=\"center\" style='font-size: 14px;'>";
					echo $word[LANG]['1_1_gallery_total']." ".$num_rows." ".$word[LANG]['1_1_gallery_images']."<bR>";
					
					echo "<table border='0' cellpadding='0' cellspacing='0' class='maintext' style='font-size: 14px;'>
						<tr>";
									$z = 1;
									
									for($i=0 ; $i < $num_rows ; $i++)	 {
										if($i % 12 == 0)	{
										
											$classi = ($i == $L)? "<td valign='top'><b>".$z."</b></td><td width='5'></td><td>|</td><td width='5'></td>" : "<td valign='top'><a title='".$alt_text."' href='index.php?m=gallery&L=".$i."&cat=".$_GET['cat']."&sub=".$_GET['sub']."' class='maintext' style='font-size: 14px;'><u>".$z."</u></a></td><td width='5'></td><td>|</td><td width='5'></td>";
											echo $classi;
									 $z = $z + 1;
										}
									 }
						echo "</tr>
					</table>";
					
				echo "</td>";
			echo "</tr>";
		}
		echo "<tr><td height=10></td></tr>";
		echo "<tr>";
			echo "<td width=\"100%\" align=\"center\">";
				echo "<table border='0' cellpadding='0' cellspacing='0' class='maintext'>";
						$counter = 0;
						while( $data = mysql_fetch_array($res) )
						{
							if( $counter%3 == 0 )
								echo "<tr>";
							
									echo "<td valign=middle align=center style='border: 1px solid #9D9D9D; background-color: #eeeeee; padding: 3px; margin: 3px;'>";
									
										$abpath_temp_unlink = SERVER_PATH."/gallery/".$data['img'];
										$abpath_temp_unlinkl = SERVER_PATH."/gallery/L".$data['img'];
										
										$exist_img = ( $counter == 1 ) ? "thumbnail2" : "thumbnail";
										if( file_exists($abpath_temp_unlink) && !is_dir($abpath_temp_unlink) )
										{
											$content = ( $data['content'] != "" ) ? "title='".nl2br(htmlspecialchars(stripslashes($data['content'])))."'" : "";
											echo "<a href=\"gallery/L".$data['img']."\" rel=\"lightbox[page".$L."]\" ".$content." ><img src=\"gallery/".$data['img']."\" rel=\"lightbox\" border=\"0\"></a>";
										}
									echo "</td>";
							
							$counter++;
							
							if( $counter%3 == 0 )
								echo "</tr><tr><td colspan=10 height=15></td></tr>";
							else
								echo "<td width=15></td>";
							
						}
				echo "</table>";
			echo "</td>";
		echo "</tr>";
		
		
		
	echo "</table>";
	
	
}


function FacebookComments($module)
{
	global $data_extra_settings;
	echo '
	<div id="fb-root"></div><script src="http://connect.facebook.net/en_US/all.js#appId='.$data_extra_settings['facebookPageId'].'&amp;xfbml=1"></script><fb:comments href="'.$_SERVER[HTTP_HOST].$_SERVER[PHP_SELF].'?'.$_SERVER[argv][0].'" num_posts="8" width="500"></fb:comments>
	';
	/*echo "
	<fb:comments xid='".$data_extra_settings['facebookPageId']."' canpost='true' candelete='false'></fb:comments>

	";*/
	
}
?>