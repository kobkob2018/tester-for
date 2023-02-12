<?

function zoom_gallery()
{
	global $pic_list_array, $zoom, $axZmH;
	
	$subject_id = ( $_GET['sub'] == "" ) ? "AND subject_id = ''" : "AND subject_id = ".ifint($_GET['sub']);
	$sql = "select * from user_gallery_cat where unk = '".UNK."' and deleted = '0' and active = '0' ".$subject_id." limit 1";
	$res = mysql_db_query(DB,$sql);
	$data_cat = mysql_fetch_array($res);
	
	$temp_cat = ( $_GET['cat'] ) ? $_GET['cat'] : $data_cat['id'];
	
	echo "<table border=\"0\" cellspacing=\"0\" cellpadding=\"0\" class=\"maintext\" width=\"100%\">";
		echo "<tr><td height=10></td></tr>";
		echo "<tr>";
			echo "<td width=\"100%\">".get_gallery_cat($temp_cat)."</td>";
		echo "</tr>";
		echo "<tr><td height=10></td></tr>";
		echo "<tr>";
			echo "<td>";
				echo "<DIV style='width: 705px; margin: 0px auto;'>\n";
					echo "<DIV style='float: left; width: 705px; padding: 10px; margin: 5px;'>\n";
							echo "<DIV id='galDiv' style='text-align:right;'>";
							echo zoomThumbs($pic_list_array, $zoom, $axZmH);
							echo "</DIV>";
					echo "</DIV>\n";
				echo "</DIV>\n";
			echo "</td>";
		echo "</tr>";
	echo "</table>";
	
}

/**
  * @param array $pic_list_array Array with images
  * @param array $zoom Configuration array
  * @return onject $axZmH Class instance
  **/	
function zoomThumbs($pic_list_array, $zoom, $axZmH){
	$return = '';
	foreach ($pic_list_array as $k => $v){
		$return .= "<DIV class='thumbDemoBack'>";
			$return .= "<DIV class='thumbDemo' style='background-image:url(".$axZmH->composeFileName($zoom['config']['gallery'].$v,$zoom['config']['galleryFullPicDim'],'_').");'>";
			$return .= "<a class='thumbDemoLink' href=\"/zoomFiles/axZm/zoomLoad.php?zoomLoadAjax=1&zoomID=".$k."&zoomDir=".$_GET['zoomDir']."&example=2\"><img src='".$zoom['config']['icon']."empty.gif' class='thumbDemoImg' border='0'></a>";
			$return .= "</DIV>";
		$return .= "</DIV>";
	}			
	return $return;
}


function links_menu_adv_settings()
{
	$sql = "SELECT links_menu_right_spacing , links_menu_left_spacing,  right_menu_width , left_menu_width , links_menu_bottom_spacing , menu_links_father_place FROM user_extra_settings WHERE unk = '".UNK."' ";
	$resUserSet = mysql_db_query(DB,$sql);
	$dataUserSet = mysql_fetch_array($resUserSet);
	
	$righ_menu_width = $dataUserSet['right_menu_width'] - $dataUserSet['links_menu_right_spacing'] - $dataUserSet['links_menu_left_spacing'];
	$left_menu_width = $dataUserSet['left_menu_width'] - $dataUserSet['links_menu_right_spacing'] - $dataUserSet['links_menu_left_spacing'];
	
	$td_right_space = ( $dataUserSet['links_menu_right_spacing'] > 0 ) ? "<td width='".$dataUserSet['links_menu_right_spacing']."'></td>" : "";
	$td_left_space = ( $dataUserSet['links_menu_left_spacing'] > 0 ) ? "<td width='".$dataUserSet['links_menu_left_spacing']."'></td>" : "";
	$td_bottom_space = ( $dataUserSet['links_menu_bottom_spacing'] > 0 ) ? "<tr><td height='".$dataUserSet['links_menu_bottom_spacing']."' colspan=3></tr>" : "";
	
	
	$sql = "SELECT * FROM users_links_menu_settings WHERE unk = '".UNK."' AND deleted=0 and father='0' and hide=0 ORDER BY place,id";
	$res = mysql_db_query(DB,$sql);
	$nums_row = mysql_num_rows($res);
	
	if( $nums_row > 0 )
	{
	echo "<table cellpadding=0 cellspacing=0 border=0 style='font-family: arial;' width='".$dataUserSet['right_menu_width']."'>";
	
	$stock_links = save_url_stock_to_array();
	
		while( $data = mysql_fetch_array($res) )
		{
			if( $dataUserSet['menu_links_father_place'] == "2"  )
			{
				$id = $data['id'];
				if( check_in_url_stock_arr( $stock_links,$id ) == "1" )
				{
					//set_one_link_with_adv_settings( $data , $righ_menu_width, $left_menu_width, $td_right_space , $td_left_space , $td_bottom_space );
					
					$sql2 = "SELECT * FROM users_links_menu_settings WHERE unk = '".UNK."' AND deleted=0 and father='".$data['id']."' and hide=0 ORDER BY place,id";
					$res2 = mysql_db_query(DB,$sql2);
					
					while( $data2 = mysql_fetch_array($res2) )
					{
						set_one_link_with_adv_settings( $data2 , $righ_menu_width, $left_menu_width, $td_right_space , $td_left_space , $td_bottom_space , "x2" );
						
						$sql3 = "SELECT * FROM users_links_menu_settings WHERE unk = '".UNK."' AND deleted=0 and father='".$data2['id']."' and hide=0 ORDER BY place,id";
						$res3 = mysql_db_query(DB,$sql3);
						
						while( $data3 = mysql_fetch_array($res3) )
						{
							set_one_link_with_adv_settings( $data3 , $righ_menu_width, $left_menu_width, $td_right_space , $td_left_space , $td_bottom_space , "x3" );
						}
					}
				}
			}
			elseif( $dataUserSet['menu_links_father_place'] == "1" || $dataUserSet['menu_links_father_place'] == "0" )
			{
				$sql2 = "SELECT * FROM users_links_menu_settings WHERE unk = '".UNK."' AND deleted=0 and father='".$data['id']."' and hide=0 ORDER BY place,id";
				$res2 = mysql_db_query(DB,$sql2);
				$nums2 = mysql_num_rows($res2);
				
				$data['numss'] = $nums2;
				set_one_link_with_adv_settings( $data , $righ_menu_width, $left_menu_width, $td_right_space , $td_left_space , $td_bottom_space , "x1" );
				
				while( $data2 = mysql_fetch_array($res2) )
				{
					$sql3 = "SELECT * FROM users_links_menu_settings WHERE unk = '".UNK."' AND deleted=0 and father='".$data2['id']."' and hide=0 ORDER BY place,id";
					$res3 = mysql_db_query(DB,$sql3);
					$nums3 = mysql_num_rows($res3);
					
					$data2['numss'] = $nums3;
					set_one_link_with_adv_settings( $data2 , $righ_menu_width, $left_menu_width, $td_right_space , $td_left_space , $td_bottom_space , "x2" , $dataUserSet['menu_links_father_place'] );
					
					while( $data3 = mysql_fetch_array($res3) )
					{
						set_one_link_with_adv_settings( $data3 , $righ_menu_width, $left_menu_width, $td_right_space , $td_left_space , $td_bottom_space , "x3" );
					}
				}
			}
			
		}
		
	echo "</table>";
	}
	
	
}

function set_one_link_with_adv_settings( $data , $righ_menu_width="", $left_menu_width="", $td_right_space="" , $td_left_space="" , $td_bottom_space="" , $place_father="" , $menu_links_father_place="" )
{
	$path = SERVER_PATH."/tamplate/";
	
	// Link Style :
	$bold = ( $data['font_bold'] == "1" ) ? "font-weight:bold;" : "";
	$underline = ( $data['font_underline'] == "1" ) ? "text-decoration: underline;" : "text-decoration: none;";
	$font_color = ( $data['font_color'] != "" ) ? "color: #".$data['font_color'].";" : "color: #000000;";
	$font_size = ( $data['font_size'] != "" ) ? "font-size: ".$data['font_size']."px;" : "font-size: 13px;";
	// END Style --
	
	
	// Load Images :
	if( file_exists($path.$data['img_link_button_hover']) && file_exists($path.$data['img_link_button']) && !is_dir($path.$data['img_link_button_hover']) && !is_dir($path.$data['img_link_button']) )
		$img_over = " onmouseover=\"img_link_".$data['id'].".src='/tamplate/".$data['img_link_button_hover']."'\" onmouseout=\"img_link_".$data['id'].".src='/tamplate/".$data['img_link_button']."'\"";
	else		$img_over = "";
	
	
	if( file_exists($path.$data['background']) && !is_dir($path.$data['background']) )
	{
		$im_size = GetImageSize ($path.$data['background']); 
		$imageHeight = $im_size[1];
		
		$background = "background='/tamplate/".$data['background']."'";
	}
	elseif( $data['bgcolor'] != "" )		$background = "bgcolor='#".$data['bgcolor']."'";
	else		$background = "";
	
	if( file_exists($path.$data['icon']) && !is_dir($path.$data['icon']) )
	{
		$im_size = GetImageSize ($path.$data['background']); 
		
		$icon_str = "<td width='".$im_size[0]."'><img src='/tamplate/".$data['icon']."' border='0' alt=''></td>";
	}
	else
		$icon_str = "";
	// END Images --
		
	
	// Script Options :
	if( $data['font_over'] != "" )
	{
		$font_over = "document.getElementById('row_link_".$data['id']."').style.color='#".$data['font_over']."'";
		$font_over_out = "document.getElementById('row_link_".$data['id']."').style.color='#".$data['font_color']."'";
	}
	else
	{
		$font_over = "";			$font_over_out = "";
	}
	
	if( $data['bgOver_color'] != "" )
	{
		$bg_color_over = "document.getElementById('row_".$data['id']."').style.backgroundColor='#".$data['bgOver_color']."';";
		$bg_color_out = "document.getElementById('row_".$data['id']."').style.backgroundColor='#".$data['bgcolor']."';";
	}
	else
	{
		$bg_color_over = "";			$bg_color_out = "";
	}
	// END Script options --
	
	
	$height = ( $imageHeight == "" ) ? "20" : $imageHeight;
	
	if( $data['link_url'] )
	{
		$link_url = $data['link_url'];
		$url_s = "<a href='".$link_url."' target='".$data['open_target']."' id='row_link_".$data['id']."' style='".$font_color.$font_size.$underline.$bold."' ".$img_over.">";
		$url_e = "</a>";
		$onclick = " onclick=\"link_row_".$data['id']."()\"";
		$style_cursor = "style='cursor : pointer;'";
	}
	else
	{
		$url_s = "";			$url_e = "";		$onclick = "";		$style_cursor = "";
	}
	
	$display_hide = ( $place_father == "x3" ) ? "style='display: none;" : "";
	$display_hide = ( $place_father == "x2" && $menu_links_father_place == "1" ) ? "style='display: none;" : "";
	
	if( file_exists($path.$data['img_link_button']) && !is_dir($path.$data['img_link_button']) )
	{
		echo "<tr id='".$place_father.$data['father']."' ".$display_hide.">";
			echo $td_right_space;
			echo "<td style='right-padding: 40px;'>".$url_s."<img src='/tamplate/".$data['img_link_button']."' name='img_link_".$data['id']."' border=0 alt='".stripslashes($data['link_name'])."'>".$url_e."</td>";
			echo $td_left_space;
		echo "</tr>";
	}
	else
	{
		$target_script = ( $data['open_target'] == "_target" ) ? "window.open('".$link_url."')" : "window.location.href='".$link_url."'";
		echo "
		<script>
		function link_row_".$data['id']."()	{
					".$target_script.";
		}";
		
		echo "function link_hover_row_".$data['id']."()	{
			".$font_over."
			".$bg_color_over."
		}";
		
		echo "function link_out_row_".$data['id']."()	{
			".$font_over_out."
			".$bg_color_out."
		}";
		
		echo "
		</script>
		";
		echo "<tr id='".$place_father.$data['id']."' ".$display_hide.">";
			echo $td_right_space;
			echo "<td ".$background." ".$style_cursor." id='row_".$data['id']."' onmouseover='link_hover_row_".$data['id']."()' onmouseout='link_out_row_".$data['id']."()' width='".$righ_menu_width."' height='".$height."' ".$onclick.">";
				echo "<table cellpadding=0 cellspacing=0 border=0 style='font-family: arial;' width='".$righ_menu_width."' height='".$height."'>";
					echo "<tr>";
							echo $icon_str;
							echo "<td align=right style='".$font_color.$font_size.$underline.$bold." padding: 4px;'>".$url_s.stripslashes($data['link_name']).$url_e."</td>";
						echo "</tr>";
				echo "</table>";
			echo "</td>";
			echo $td_left_space;
		echo "</tr>";
		echo $td_bottom_space;
	}
	
	$data = "";
	
}


function save_url_stock_to_array()
{
	$arr = array();
	
	$sql = "SELECT link_url,father FROM users_links_menu_settings WHERE unk = '".UNK."' AND deleted=0";
	$res = mysql_db_query(DB,$sql);
	
	while( $data = mysql_fetch_array($res) )
	{
		$fa = $data['father'];
		$temp_url = explode( "?" , $data['link_url'] );
		
		$arr[$fa][] = $temp_url[1];
	}
	
	return $arr;
}


function check_in_url_stock_arr( $arr , $fa )
{
	$arg = $_SERVER[argv][0];
	
	foreach( $arr[$fa] as $key => $val )
	{
		if( eregi( $val , $arg ) )
			return "1";
	}
	
	return "0";
}



function captchaNum1()
{
	$im = imagecreate(100, 31);
	
	// random colored background and text
	$bg = imagecolorallocate($im, rand(200,255) , rand(200,255), rand(128,255));
	$textcolor = imagecolorallocate($im, 0, 0, rand(0,128));
	
	// write the random 4 digits number at a random locaton (x= 0-20, y=0-20),
	$random=rand(1000,9999);
	imagestring($im, rand(4,8), rand(0,20), rand(0,20), $random , $textcolor);
	
	// write the image to a temporary file , in this case it is 777 chmoded tmp folder in same directory
	// could be a generic /tmp folder
	$filenametemp="/home/ilan123/domains/ilbiz.co.il/public_html/tepm240/gif".time().".gif";
	ImageGIF($im, $filenametemp);
	$ImageData = file_get_contents($filenametemp);
	$ImageDataEnc = base64_encode($ImageData);
	unlink($filenametemp); // delete the file
	
	return array( "random" => $random , "img" => $ImageDataEnc );
}
