<?

function servise10__cats_list($type="home")
{
	
	switch( $type )
	{
		case "home" :
			$sql = "SELECT id , img , cat_name FROM biz_categories WHERE father=0 AND status=1 AND hidden=0 ORDER BY place";
			$t = "1";
		break;
		
		case "cats" :
			$sql = "SELECT id , img , cat_name FROM biz_categories WHERE father='".isInt($_GET['c'])."' AND status=1 AND hidden=0 ORDER BY place";
			$t = "2";
		break;
	}
	
	$res = mysql_db_query(DB ,$sql );
	
	
	$counter=1;
	$take=0;
	$contents = "";
	echo "<table width=600 border=0 cellpadding=0 cellspacing=0 align=center>";
		
		if( $_GET['c'] == "0" )
		{
			echo ilan_homePage_video_box("colspan=7");
		
			echo "<tr><td height=30></td></tr>";
		}
		
		echo service_suppliers_with_estimates($_GET['c'] , "colspan=7" );
		
		echo "<tr><td height=30></td></tr>";
		
		$res_group_buy = get_group_buy_list_query("1", (int)$_GET['c'] );
		
		echo "<tr>";
			echo "<td align=center colspan=7>";
				echo "<table cellpadding=0 cellspacing=0 border=0>";
					while( $data_group_buy = mysql_fetch_array($res_group_buy) )
					{
						$params_est['cat'] = $data_group_buy['primeryCat'];
						$params_est['subCat'] = $data_group_buy['subCat'];
						$params_est['cat_spec'] = $data_group_buy['cat_spec'];
						$params_est['t'] = $data_group_buy['type'];
						
						$group_buy_str = getGroupBuy_kobia( $data_group_buy , $params_est , "list" );
						
						echo "<tr>";
							echo "<td align=center valign=top background='images/new_blue_registr.jpg' width='555' height='258' style='background-repeat: no-repeat;'>";
								echo "<table border=\"0\" cellspacing=\"0\" cellpadding=\"0\" class=\"maintext\" width=555>";
									echo "<tr>";
										echo "<td align=center valign=top>";
												echo $group_buy_str;
										echo "</td>";
									echo "</tr>";
								echo "</table>";
							echo "</td>";
						echo "</tr>";
						echo "<tr>";
							echo "<td style='padding-right: 13px;'><a href='/index.php?m=g_buy' class='maintext' style='text-decoration: none;'><b>לכל ההנחות החברתיות</b></a></td>";
						echo "</tr>";
						echo "<tr><td height=7></td></tr>";
						
						$count_arr[] = array( "date" => getDateForCounterFormat($data_group_buy['date_time']) , "id" => $data_group_buy['id'] );
						
					}
				echo "</table>";
			echo "</td>";
		echo "</tr>";
		
		echo "<tr><td height=30></td></tr>";
		
		$sql = "SELECT cat_name FROM biz_categories WHERE id = '".isInt($_GET['c'])."' ";
		$res_p = mysql_db_query(DB ,$sql );
		$data_p = mysql_fetch_array($res_p);
		
		echo "<tr>";
			echo "<td colspan=7>";
				echo "<table border=\"0\" cellspacing=\"0\" cellpadding=\"0\" class=\"maintext\" width=600>";
					echo "<tr>";
						echo "<td background='images/topHeadLine.jpg' style='background-repeat : no-repeat; background-position: right;' width=276 height=39 align=right>";
							echo "<table border=\"0\" cellspacing=\"0\" cellpadding=\"0\" class=\"maintext\">";
								echo "<tr>";
									echo "<td style='padding-top: 8px; padding-right: 7px; color: #777777; font-size: 13px;'>השוואת מחירים עבור <b>".stripslashes($data_p['cat_name'])."</b></td>";
								echo "</tr>";
							echo "</table>";
						echo "</td>";
					echo "</tr>";
					
					echo "<tr>";
						echo "<td style='border: 1px solid #dadada; padding: 7px; background-color: #f4f4f4;'><div id='estimateSiteRowDiv'><script type='text/javascript'>ajax_estimateSiteRow2(\"".isInt($_GET['c'])."\" , \"".$_GET['t']."\")</script></div></td>";
					echo "</tr>";
					
				echo "</table>";
			echo "</td>";
		echo "</tr>";
		echo "</tr><tr><td height=15></td></tr>";
		
		
		while( $data = mysql_fetch_array($res) )
		{
			if( $counter%4 == 1 )
			{
				$take++;
				echo "<tr>";
			}
				$sqlCheck = "SELECT id , img , cat_name FROM biz_categories WHERE father='".$data['id']."' AND status=1 AND hidden=0 ORDER BY place";
				$resCheck = mysql_db_query(DB,$sqlCheck);
				$num_check = mysql_num_rows($resCheck);
				
				if( $num_check > 0 )
					$gotoUrl = "index.php?m=subC&c=".$data['id']."&t=".$t;
				else
				{
					$sqlText = "SELECT id FROM content_pages WHERE unk = '".UNK."' AND name = '".stripslashes($data['cat_name'])."' AND deleted=0 order by place LIMIT 1";
					$resText = mysql_db_query(DB,$sqlText);
					$dataText = mysql_fetch_array($resText);
					
					if( $dataText['id'] )
						$gotoUrl = "index.php?m=text&t=".$dataText['id'];
					else
						$gotoUrl = "";
				}
				
					echo "<td valign=top height=100%>";
						$bg = ( $counter%2 == 0 ) ? "f4f4f4" : "f4f4f4";
					
						echo "<table width='133' border='0' bgcolor='#".$bg."' cellpadding='2' cellspacing='2' class='maintext' height='100%'>";
							echo "<tr>";
								echo "<td align=center valign=top height=20><h2 style='padding:0; margin:0; font-size:13px;'><a href='".$gotoUrl."' class='maintext' title='".stripslashes($data['cat_name'])."' style='text-decoration: none;'>".stripslashes($data['cat_name'])."</a></h2></td>";
							echo "</tr>";
							
							$path = "/home/ilan123/domains/mysave.co.il/public_html/images/cats/".$data['img'];
							if( file_exists($path) && !is_dir($path) )
								$getImg = "<a href='".$gotoUrl."' class='maintext' title='".stripslashes($data['cat_name'])."'><img src='http://www.mysave.co.il/images/cats/".$data['img']."' width=120 style='border: 1px solid #cccccc;' border='0' alt='".stripslashes($data['cat_name'])."' /></a>";
							else
								$getImg = "";
							echo "<tr>";
								echo "<td align=center valign=top>".$getImg."</td>";
							echo "</tr>";
							
							
							if( $gotoUrl != "" )
							{
								echo "<tr>";
									echo "<td align=center valign=bottom><a href='".$gotoUrl."' class='maintext' title='".stripslashes($data['cat_name'])."'>בקש הצעת מחיר</a></td>";
								echo "</tr>";
							}
						echo "</table>";
					echo "</td>";
					
			
			if( $counter%4 == 0 )
				echo "</tr><tr><td height=3 colspan=5></td></tr>";
			else
				echo "<td width=8></td>";
			
			
				
				
				if( !empty($data_content['content']) )
				{
					
				}
				
				
			$counter++;
		}
		
		$sql = "SELECT content FROM cats_text_10service WHERE cat_id = '".ifint($_GET['c'])."' LIMIT 1";
		$res_content = mysql_db_query(DB,$sql);
		$data_content = mysql_fetch_array($res_content);
		
		echo "<tr>";
				echo "<td colspan=7 width=600>";
					echo "<table border=0 cellpadding=0 cellspacing=0 align=right class='maintext' width=600>";
						echo "<tr><td height=20></td></tr>";
						echo "<tr>";
							echo "<td>".stripslashes($data_content['content'])."</td>";
						echo "</tr>";
					echo "</table>";
				echo "</td>";
			echo "</tr>";
		
	echo "</table>";
	
	
}


function get_buttom_clients_cats( $cat="" , $sub_cat="", $cat_spec="" )
{
	
	$temp_cat2 = ( ifint($cat_spec) != "0" ) ? $cat_spec : $sub_cat;
	$temp_cat = ( ifint($temp_cat2) != "0" ) ? $temp_cat2 : $cat;
	$take_cat = ( ifint($temp_cat) != "" ) ? "uc.cat_id=".ifint($temp_cat)." AND" : "";
	
	$sql = "select u.unk , u.id , u.name FROM 
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
				".$take_cat."
				bc.status=1
		 GROUP BY rand() LIMIT 5";
	$res_choosenClient = mysql_db_query(DB, $sql);
	$numRwos = mysql_num_rows($res_choosenClient);
	
	$UserStatView = new UserStatView(DB);
	
	if( $temp_cat != "" && $numRwos > 0 )
	{	
		echo "<table border='0' cellpadding='0' cellspacing='0' class='maintext' width=100%>";
			echo "<tr>";
				echo "<td>";
					echo "<table border=\"0\" cellspacing=\"0\" cellpadding=\"0\" class=\"maintext\" width=100%>";
						echo "<tr><td height=6 style='background-color: #d9dde0;'></td></tr>";
						echo "<tr>";
							echo "<td height='30' align=right style='background-color: #f4f4f4; color: #2c40a1; border: 1px solid #dadada; font-size: 15px; padding-right: 7px;'>";
								echo "<b>נותני שירות</b>";
							echo "</td>";
						echo "<tr>";
						echo "<tr>";
					echo "</table>";
				echo "</td>";
			echo "</tr>";
			
			$count=0;
			while( $users_data = mysql_fetch_array($res_choosenClient) )
			{
				$sqlText = "SELECT * FROM suppliers_10service WHERE user_id = '".$users_data['id']."' ";
				$resText = mysql_db_query(DB,$sqlText);
				$dataText = mysql_fetch_array($resText);
				
				$sql = "SELECT name FROM cities where id = '".$dataText['city']."' ";
				$resCity = mysql_db_query(DB,$sql);
				$dataCity = mysql_fetch_array($resCity);
				
				if( $dataText['id'] )
				{
					$gotoUrl = "index.php?m=text&t=".$dataText['page_id'];
					
					$bgcolor = ( $count%2 == 0 ) ? "eff0f2" : "f8f6e9";
					echo "<tr style='background-color: #".$bgcolor.";'>";
						echo "<td>";
							echo "<table border='0' cellpadding='0' cellspacing='0' class='maintext' style=' padding: 5px;'>";
								echo "<tr>";
									echo "<td>";
										if( $dataText['status'] == "0" )		echo "<img src='images/amin2.png' border=0 alt='' width=116>";
										else																echo "<img src='images/amin1.png' border=0 alt='' width=116>";
									echo "</td>";
									echo "<td width=10></td>";
									echo "<td valign=top width=230>";
										echo "<table border='0' cellpadding='0' cellspacing='0' class='maintext'>";
											echo "<tr>";
												echo "<td colspan=3><a href='".$gotoUrl."' title='".stripslashes($users_data['name'])."' class='maintext' style='font-size: 15px;'>".stripslashes($users_data['name'])."</a></td>";
											echo "</tr>";
											echo "<tr><td colspan=3 height=5></td></tr>";
											echo "<tr>";
												echo "<td>עיר: </td>";
												echo "<td width=10></td>";
												echo "<td>".stripslashes($dataCity['name'])."</td>";
											echo "</tr>";
											echo "<tr><td colspan=3 height=5></td></tr>";
											echo "<tr>";
												echo "<td>כתובת: </td>";
												echo "<td width=10></td>";
												echo "<td>".stripslashes($dataText['address'])."</td>";
											echo "</tr>";
										echo "</table>";
									echo "</td>";
									
									echo "<td width=30></td>";
									echo "<td valign=top>";
										
										$sqlGB = "SELECT * FROM 10_service_group_buy WHERE user_id = '".$users_data['id']."' AND lock_edit = 1 AND deleted=0 AND date_time>NOW() ".$pro_id." ORDER BY place LIMIT 1";
										$resGB = mysql_db_query(DB,$sqlGB);
										$dataGB = mysql_fetch_array($resGB);
										
										if( $dataGB['id'] != "" )
											echo "<a href='".$gotoUrl."' title='".stripslashes($users_data['name'])."' class='maintext' style='font-size: 15px;'><img src='images/button_22.png' alt='' border='0'></a>";
										
									echo "</td>";
									
								echo "</tr>";
							echo "</table>";
						echo "</td>";
					echo "</tr>";
					echo "<tr><td height=2></td></tr>";
					
					$count++;
					
					$UserStatView->newRow( $users_data['id'] , "1" );
					
				}
			}
				
			
		echo "</table>";
	}
}

function isInt($x)
	{
		return ( is_numeric ( $x ) ? $x :  0 );
	}