<?

function selectBrwoserTitle($data_words, $um, $fromLanding="")
{
	
	global $data_extra_settings, $dataLDSetting;
	
	
	$temp_word_about_title = ( empty($data_words['word_about_title']) ) ? $temp_word_about : stripslashes($data_words['word_about_title']);
	$temp_word_articels_title = ( empty($data_words['word_articels_title']) ) ? $temp_word_articels : stripslashes($data_words['word_articels_title']);
	$temp_word_products_title = ( empty($data_words['word_products_title']) ) ? $temp_word_products : stripslashes($data_words['word_products_title']);
	$temp_word_gallery_title = ( empty($data_words['word_gallery_title']) ) ? $temp_word_gallery : stripslashes($data_words['word_gallery_title']);
	$temp_word_yad2_title = ( empty($data_words['word_yad2_title']) ) ? $temp_word_yad2 : stripslashes($data_words['word_yad2_title']);
	$temp_word_sales_title = ( empty($data_words['word_sales_title']) ) ? $temp_word_sales : stripslashes($data_words['word_sales_title']);
	$temp_word_video_title = ( empty($data_words['word_video_title']) ) ? $temp_word_video : stripslashes($data_words['word_video_title']);
	$temp_word_wanted_title = ( empty($data_words['word_wanted_title']) ) ? $temp_word_wanted : stripslashes($data_words['word_wanted_title']);
	$temp_word_contact_title = ( empty($data_words['word_contact_title']) ) ? $temp_word_contact: stripslashes($data_words['word_contact_title']);
	$temp_word_gb_title = ( empty($data_words['word_gb_title']) ) ? $temp_word_gb : stripslashes($data_words['word_gb_title']);
	
	// select the title of the page
	switch($um)
	{
		case "" :
		case "text" :
			
			$flag = false;
			
			if( UNK == "285240640927706447" )
			{
				$sql = "select * from estimate_miniSite_defualt_block where unk = '".UNK."' and type = '".$_GET['t']."'";
				$res = mysql_db_query(DB,$sql);
				$data_estimate = mysql_fetch_array($res);
				$addMoreTitle = "";
				if( $data_estimate['primeryCat'] != "0" && $data_estimate['subCat'] != "0" )
				{
					
					if( $data_estimate['cat_spec'] != "0" ) 
					{
						$sql = "SELECT cat_name FROM biz_categories WHERE id = '".$data_estimate['cat_spec']."' ";
						$res = mysql_db_query(DB,$sql);
						$data224 = mysql_fetch_array($res);
						
						if( $data224['cat_name'] != '' )
						{
							$addMoreTitle .= stripslashes($data224['cat_name']);
						}
					}
					
					if( $data_estimate['subCat'] != "0" ) 
					{
						$sql = "SELECT cat_name FROM biz_categories WHERE id = '".$data_estimate['subCat']."' ";
						$res = mysql_db_query(DB,$sql);
						$data223 = mysql_fetch_array($res);
						
						if( $data223['cat_name'] != '' )
						{
							$psik = ( $addMoreTitle == "" ) ? "" : ", ";
							$addMoreTitle .= $psik.stripslashes($data223['cat_name']);
						}
					}
					
					if( $data_estimate['primeryCat'] != "0" ) 
					{
						$sql = "SELECT cat_name FROM biz_categories WHERE id = '".$data_estimate['primeryCat']."' ";
						$res = mysql_db_query(DB,$sql);
						$data222 = mysql_fetch_array($res);
						
						if( $data222['cat_name'] != '' )
						{
							$psik = ( $addMoreTitle == "" ) ? "" : ", ";
							$addMoreTitle .= $psik.stripslashes($data222['cat_name']);
						}
					}
					
					
					
					$flag = true;
				}
			}
			
			if( $flag == false )
			{
				switch($_GET['t'])
				{
					case "text" : 			$addMoreTitle = $temp_word_about_title;				break;
					default:
						if( isset($_GET['lib']) && $_GET['t'] == "" )
						{
							$qry = "SELECT id FROM content_pages WHERE deleted=0 AND lib=".ifint($_GET['lib'])." AND unk = '".UNK."' ORDER BY id LIMIT 1";
							$res = mysql_db_query( DB , $qry );
							$data = mysql_fetch_array($res);
							$_GET['t'] = $data['id'];
						}
						
						$sql = "select name,lib from content_pages where unk = '".UNK."' and id = '".ifint($_GET['t'])."' and deleted=0";
						$res = mysql_db_query(DB, $sql);
						$data = mysql_fetch_array($res);
						
						$sql = "select lib_name from user_text_libs where unk = '".UNK."' and id = '".$data['lib']."' and deleted=0";
						$res = mysql_db_query(DB, $sql);
						$dataLib = mysql_fetch_array($res);
						
						$myLib = ( $dataLib['lib_name'] != "" ) ? ", ".stripslashes($dataLib['lib_name']) : "";
						$addMoreTitle = stripslashes($data['name']).$myLib;
				}
			}
		break;
		 
		case "ar" :
		case "articels" :
		case "arLi" :
			$artd = ( $_GET['artd'] != "" ) ? "and id = '".ifint($_GET['artd'])."'" : "";
			$art_id = ( $_GET['art_id'] != "" && $artd == "" ) ? "and id = '".ifint($_GET['art_id'])."'" : "";
			global $blue_title;
			if($artd =="" && $art_id == ""){
				global $temp_word_articels;
				$blue_title = $temp_word_articels;
				$addMoreTitle = $temp_word_articels;
			}
			else{
			$sql = "select headline from user_articels where unk = '".UNK."' and status = '0' ".$art_id." ".$artd." and deleted=0 order by id desc limit 1";
			$res = mysql_db_query(DB, $sql);
			$data = mysql_fetch_array($res);
			$blue_title = stripslashes($data['headline']);
			$addMoreTitle = stripslashes($data['headline']).", ".$temp_word_articels_title;
			}
		break;
		
		case "s_products" :
		case "s.pr" :
			$sql = "select name from user_products where unk = '".UNK."' and id = '".ifint($_GET['ud'])."' and deleted=0";
			$res = mysql_db_query(DB, $sql);
			$data = mysql_fetch_array($res);
			
			$addMoreTitle = stripslashes($data['name']).", ".$temp_word_products_title;
		break;
		case "pr" :
		case "products" :		$addMoreTitle = $temp_word_products_title;				break;
		
		case "ga" :
		case "gallery" :		$addMoreTitle = $temp_word_gallery_title;				break;
		
		case "s_yad2" :
		case "s.ya" :
			$sql = "select name from user_yad2 where unk = '".UNK."' and id = '".ifint($_GET['ud'])."' and deleted=0";
			$res = mysql_db_query(DB, $sql);
			$data = mysql_fetch_array($res);
			
			$addMoreTitle = stripslashes($data['name']).", ".$temp_word_yad2_title;
		break;
		case "ya" :
		case "yad2" :		$addMoreTitle = $temp_word_yad2_title;				break;
		
		
		case "s_sales" :
		case "s.sa" :
			$sql = "select name from user_sales where unk = '".UNK."' and id = '".ifint($_GET['ud'])."' and deleted=0";
			$res = mysql_db_query(DB, $sql);
			$data = mysql_fetch_array($res);
			
			$addMoreTitle = stripslashes($data['name']).", ".$temp_word_sales_title;
		break;
		case "sa" :
		case "sales" :		$addMoreTitle = $temp_word_sales_title;				break;
		
		case "s_video" :
		case "s.vi" :
			$sql = "select name from user_video where unk = '".UNK."' and id = '".ifint($_GET['ud'])."' and deleted=0";
			$res = mysql_db_query(DB, $sql);
			$data = mysql_fetch_array($res);
			
			$addMoreTitle = stripslashes($data['name']).", ".$temp_word_video_title;
		break;
		case "vi" :
		case "video" :		$addMoreTitle = $temp_word_video_title;				break;
		
		case "jo" :
		case "jobs" :		$addMoreTitle = $temp_word_wanted_title;				break;
		
		case "get_thanks" :
		case "co" :
		case "contact" :		$addMoreTitle = $temp_word_contact_title;				break;
		
		case "gb" :		$addMoreTitle = $temp_word_gb_title;				break;
		
		case "search" :
			if( $data_extra_settings['estimateSite'] == "1" )
				$addMoreTitle = "מפת אתר";
		break;
		
		case "home" :
			if( UNK == "285240640927706447" )
				$addMoreTitle = "פורטל השוואת מחירים, אינדקס עסקים, מחירון";
		break;
		
		case "subC" :
			if( UNK == "285240640927706447" )
			{
				$sql = "SELECT cat_name, father FROM biz_categories WHERE id='".isInt($_GET['c'])."' AND status=1 AND hidden=0 ORDER BY place";
				$res = mysql_db_query(DB ,$sql );
				$data = mysql_fetch_array($res);
				
				$addMoreTitle = stripslashes($data['cat_name']);
				
				if( $data['father'] != '0' )
				{
					$sql = "SELECT cat_name, father FROM biz_categories WHERE id='".$data['father']."' AND status=1 AND hidden=0 ORDER BY place";
					$res = mysql_db_query(DB ,$sql );
					$data = mysql_fetch_array($res);
					
					if( $data['cat_name'] != '' )
						$addMoreTitle .= ", ".stripslashes($data['cat_name']);
				}
			}
		break;
	}
	
	if( $fromLanding == "1" )
	{
		$sql = "SELECT landing_name  FROM sites_landingPage_settings  WHERE id = '".$dataLDSetting['id']."' ";
		$res = mysql_db_query(DB ,$sql );
		$data = mysql_fetch_array($res);
		
		if( $data['landing_name'] != '' )
			$addMoreTitle = stripslashes($data['landing_name']);
	}
	
	return $addMoreTitle;
}


function scroll_news($height="",$page_type="")
{
	global $data_settings,$data_colors,$word,$data_extra_settings;
	
	if( ($data_extra_settings['have_scrollNewsImgs'] == "1" && $page_type == "") || $data_extra_settings['estimateSite'] == "1"  )
	{
		scroll_news_with_img();
	}
	else
	{
		
		$sql = "select * from user_news where deleted = '0' and unk = '".UNK."' ORDER BY id DESC";
		$res = mysql_db_query(DB,$sql);
		$num_rows = mysql_num_rows($res);
		
		$style_kol_hpHeadline = ( UNK == "263512086634836547" ) ? "background: url('/upload_pics/Image/otherImagesCore/dupli_headline_area.jpg'); color: #ff8c25;" : "";
		$style_kol_Color = ( UNK == "263512086634836547" ) ? "ff8c25" : $data_colors['color_link'];
		
		if( $num_rows > 0 )
		{
			$runews_headline_temp = ( $data_settings['runews_headline'] != "" ) ? $data_settings['runews_headline'] : $word[LANG]['1_3_scroll_news_title'];	
			
			$bgcolor_headline = ( $page_type == "index" ) ? $data_colors['bg_link'] : $data_colors['conent_bg_color'];
			$bgcolor_text_headline = ( $page_type == "index" ) ? "style=\"color:#".$style_kol_Color."\"" : "";
			
			$border_color_index = ( $page_type == "index" ) ? "#".$data_colors['border_color']."" : "#000000";
				
				$table_height = ( $height != "" ) ? " height=\"".$height."\"" : "";
				
				$bgcolor_headline_TMP = ( !empty($bgcolor_headline) ) ? "bgcolor=\"#".$bgcolor_headline."\"" : "";
				echo "<tr>
					<td width=\"7\">
					<td height=25 class=\"maintext\" style=\"border-left: 1px solid ".$border_color_index."; border-top: 1px solid ".$border_color_index."; border-right: 1px solid ".$border_color_index."; ".$style_kol_hpHeadline."\" align=\"center\" ".$bgcolor_headline_TMP.">
						<table border=\"0\" cellspacing=\"0\" cellpadding=\"0\" class=\"maintext\">
							<tr><Td height=3></td></tr>
							<tr>
								<td ".$bgcolor_text_headline."><b>".htmlspecialchars(stripslashes($runews_headline_temp))."</b></td>
							</tr>
							<tr><Td height=3></td></tr>
						</table>
					</td>
					<td width=\"7\">
				</tr>";
								
				echo "<tr ".$table_height.">";
					echo "<td width=\"7\">";
					echo "<td>";
						echo "<div style='border: 1px solid ".$border_color_index."' id=\"marqueecontainer\" onMouseover=\"copyspeed=pausespeed\" onMouseout=\"copyspeed=marqueespeed\">
						<div id=\"vmarquee\" style='position: absolute; width:98%;'>
						<table border='0' cellspacing='0' cellpadding='0' class='maintext'>
						<tr>
						<td width=5></td>
						<td>
						";
						
						while( $data_scroll = mysql_fetch_array($res))
						{
							$u_strat = ( $data_scroll['link'] ) ? "<a href='".htmlspecialchars(stripslashes($data_scroll['link']))."' class='maintext' target='_blank'><u>" : "";
							$u_end = ( $data_scroll['link'] ) ? "</u></a>" : "";
							echo "<font class='maintext'><b>".htmlspecialchars(stripslashes($data_scroll['headline']))."</b><br></font>";
							echo "<font class='maintext'>".$u_strat.nl2br(htmlspecialchars(stripslashes($data_scroll['content']))).$u_end."</font><br><br>";
						}
						
						echo "</td></tr></table></div>
						</div>";	
					echo "</td>";
					echo "<td width=\"7\">";
				echo "</tr>";
		}			
	}
}

function scroll_news_with_img()
{
	global $data_extra_settings;
	
	$scrollNewsTop = "/tamplate/".$data_extra_settings['scrollNewsTop'];
	$scrollNewsDupli = "/tamplate/".$data_extra_settings['scrollNewsDupli'];
	$scrollNewsBottom = "/tamplate/".$data_extra_settings['scrollNewsBottom'];
		
	if( $data_extra_settings['estimateSite'] == "1" )
	{
		$scrollNewsTop = ( $scrollNewsTop == "/tamplate/" ) ? "/new_images/default_scroll_news_top.png" : $scrollNewsTop;
		$scrollNewsBottom = ( $scrollNewsBottom == "/tamplate/" ) ? "/new_images/default_scroll_news_bottom.png" : $scrollNewsBottom ;
	}
	
	
	if( $scrollNewsDupli == "/tamplate/" )
		$new_scrollNewsDupli = "bgcolor=#ffffff";
	elseif( $scrollNewsDupli != "" )
		$new_scrollNewsDupli = "background='".stripslashes($scrollNewsDupli)."'";
	else
		$new_scrollNewsDupli = "";
	
	
	$righ_menu_width = $data_extra_settings['right_menu_width'] - $data_extra_settings['links_menu_right_spacing'] - $data_extra_settings['links_menu_left_spacing'];
	$left_menu_width = $data_extra_settings['left_menu_width'] - $data_extra_settings['links_menu_right_spacing'] - $data_extra_settings['links_menu_left_spacing'];
	$righ_menu_width = ( $righ_menu_width != "" ) ? $righ_menu_width : "140";
	$left_menu_width = ( $left_menu_width != "" ) ? $left_menu_width : "140";
	
	
	
	$td_right_space = ( $data_extra_settings['links_menu_right_spacing'] > 0 ) ? "<td width='".$data_extra_settings['links_menu_right_spacing']."'></td>" : "<td width=\"5\"></td>";
	$td_left_space = ( $data_extra_settings['links_menu_left_spacing'] > 0 ) ? "<td width='".$data_extra_settings['links_menu_left_spacing']."'></td>" : "<td width=\"5\"></td>";
	
	
	$sql = "select * from user_news where deleted = '0' and unk = '".UNK."' ORDER BY id DESC";
	$res = mysql_db_query(DB,$sql);
	$num_rows = mysql_num_rows($res);
							
	if( $num_rows > 0 )
	{
		echo "<tr>";
			echo $td_right_space;
			echo "<td><img src='".stripslashes($scrollNewsTop)."' border=0 width=".$righ_menu_width." alt=''></td>";
			echo $td_left_space;
		echo "</tr>";
		
		echo "<tr>";
			echo $td_right_space;
			echo "<td width=".$righ_menu_width.">";
				
				echo "<table border=\"0\" cellspacing=\"0\" cellpadding=\"0\" class=\"maintext\">";
					echo "<tr>";
						echo "<td width=\"7\"></td>";
						echo "<td " . $new_scrollNewsDupli . " >";
							echo "<div id=\"marqueecontainer\" onMouseover=\"copyspeed=pausespeed\" onMouseout=\"copyspeed=marqueespeed\">
							<div id=\"vmarquee\" style='position: absolute; width:98%;'>
							<table border='0' cellspacing='0' cellpadding='0' class='maintext'>
							<tr><td width=6></td><td>
							";
							
								$bgcolor_text_headline = ( $data_extra_settings['scrollNewsHeadlineColor'] != "" ) ? "style=\"color:#".$data_extra_settings['scrollNewsHeadlineColor']."\"" : "";
								
								while( $data_scroll = mysql_fetch_array($res))
								{
									$u_strat = ( $data_scroll['link'] ) ? "<a href='".htmlspecialchars(stripslashes($data_scroll['link']))."' class='maintext' target='_blank'><u>" : "";
									$u_end = ( $data_scroll['link'] ) ? "</u></a>" : "";
									echo "<font class='maintext' ".$bgcolor_text_headline."><b>".htmlspecialchars(stripslashes($data_scroll['headline']))."</b><br></font>";
									echo "<font class='maintext'>".$u_strat.nl2br(htmlspecialchars(stripslashes($data_scroll['content']))).$u_end."</font><br><br>";
								}
															
							echo "</td><td width=6></td></tr></table></div>
							</div>";	
						echo "</td>";
						echo "<td width=\"7\"></td>";
					echo "</tr>";
				echo "</table>";
				
			echo "</td>";
			echo $td_left_space;
		echo "</tr>";
		
		echo "<tr>";
			echo $td_right_space;
			echo "<td><img src='".stripslashes($scrollNewsBottom)."' border=0 width=".$righ_menu_width." alt=''></td>";
			echo $td_left_space;
		echo "</tr>";
	}			
}


function add_mail_1()
{
	$sql = "insert into mailinglist ( unk, email ) values ( '".UNK."' , '".addslashes($_GET['new_mail'])."' )";
	$res = mysql_db_query(DB,$sql);
	
	header("location: index.php");
		exit;
}


function search_form()
{
	global $word;
	
	echo "<form action=\"index.php\" method=\"get\" name=\"search_form\" style='padding:0; margin:0;'>";
	echo "<input type=\"hidden\" name=\"m\" value=\"search\">";
	echo "<table border=\"0\" cellspacing=\"0\" cellpadding=\"0\" class=\"rightMemu\" align=center>";
		echo "<tr>";
			echo "<td width=\"5\"></td>";
			echo "<td><input type=\"text\" name=\"search_val\" class=\"input_style\" style=\"width:80px;\"></td>";
			echo "<td width=\"2\"></td>";
			echo "<td><input type=\"submit\" value=\"".$word[LANG]['1_3_search_submit']."\" class=\"submit_style\" style=\"width:43px;\"></td>";
			echo "<td width=\"1\"></td>";
		echo "</tr>";
	echo "</table>";
	echo "</form>";
}

function search()
{
	
	global $data_colors,$word,$data_extra_settings;
	$arr_301 = array();
	$sql_301 = $sql = "SELECT module,item_id,redirect_url FROM site_301_redirections WHERE unk = '".UNK."'";
	// AND module = '".$val_arr['module']."' AND item_id = '".$_GET[$val_arr['get_value']]."'
	$res_301 = mysql_db_query(DB,$sql_301);
	while($data_301 = mysql_fetch_array($res_301)){
		$key_301 = "user_".$data_301['module']."_".$data_301['item_id'];
		$arr_301[$key_301] = $data_301['redirect_url'];
	}

	$sql = "select * from user_words where unk = '".UNK."'";
	$res_words = mysql_db_query(DB,$sql);
	$data_words = mysql_fetch_array($res_words);
	
	$temp_word_content_pages = $word[LANG]['1_3_search_text_pages'];
	$temp_word_articels = ( $data_words['id'] == "" ) ? $word[LANG]['1_2_chapter_name_articels'] : stripslashes($data_words['word_articels']);
	$temp_word_sales = ( $data_words['id'] == "" ) ? $word[LANG]['1_2_chapter_name_sales'] : stripslashes($data_words['word_sales']);
	$temp_word_products = ( $data_words['id'] == "" ) ? $word[LANG]['1_2_chapter_name_products'] : stripslashes($data_words['word_products']);
	$temp_word_yad2 = ( $data_words['id'] == "" ) ? $word[LANG]['1_2_chapter_name_yad2'] : stripslashes($data_words['word_yad2']);
	$temp_word_video = ( $data_words['id'] == "" ) ? $word[LANG]['1_2_chapter_name_video'] : stripslashes($data_words['word_video']);
	
	$temp_word_wanted = ( $data_words['id'] == "" ) ? $word[LANG]['1_2_chapter_name_jobs'] : stripslashes($data_words['word_wanted']);
	$temp_word_landing_pages = $word[LANG]['1_2_chapter_name_landing_pages'];
	$temp_word_realty = "נכסים";
	
	if( $data_extra_settings['indexSite'] == 1 )
	{
		$temp_word_guide_business = "רשימת עסקים";
		$temp_word_guide_cats = "רשימת סיווגים";
		
		$arr_search = array(
			"user_guide_business" => array("business_name", "summery", "description", "active"),
			"user_guide_cats" => array("cat_name", "active"),
			
			"content_pages" => array("content"),
			"user_articels" => array("content","summary","headline","status"),
			
			"user_sales" => array("content","name","summary","status","end_date"),
			"user_products" => array("content","name","summary","active"),
			"user_video" => array("content","name","summary","active"),
			"user_yad2" => array("content","name","summary","active"),
			
			"user_wanted" => array("content","name"),
			
			"user_realty" => array("title","location","notes","size_by_meter","rooms"),
		);
	}
	else
	{
		$arr_search = array(
			//"content_pages" => array("content"),
			"content_pages" => array("content"),
			"user_articels" => array("content","summary","headline","status"),
			
			"user_sales" => array("content","name","summary","status","end_date"),
			"user_products" => array("content","name","summary","active"),
			"user_video" => array("content","name","summary","active"),
			"user_yad2" => array("content","name","summary","active"),
			
			"user_wanted" => array("content","name"),
			
			"user_realty" => array("title","location","notes","size_by_meter","rooms"),
		);
	}
	$search_words = explode(" ",$_GET['search_val']);
	$min_search_words_to_find = count($search_words);
	if($min_search_words_to_find > 3){
		$min_search_words_to_find = 3;
	}
	$result_arr = array();
	$count_search = 0;
	foreach( $arr_search as $val => $key )
	{
		if(!isset($result_arr[$val])){
			$result_arr[$val] = array();
		}
		$val2 = $val;
		$key2 = $key;
		foreach($search_words as $search_word){
			$sql = "select * from {$val} where deleted = '0' and unk = '".UNK."' and ( ";
				$counter = 0;
				foreach ( $key as $kkey )
				{
					$or_parametr = ( $counter == 0 ) ? "" : "or";
					switch($kkey)
					{
						case "status" :
						case "active" : $sql .= ") and ( {$kkey} = '0' ";	break;
						
						case "end_date" : $sql .= "and {$kkey} > '".GlobalFunctions::get_date()."' ";	break;
						
						default:
							$sql .= "{$or_parametr} {$kkey} like '%".mysql_real_escape_string($search_word)."%' ";
					}
					$counter++;
				}
			$sql .= ") ";
			$res = mysql_db_query(DB,$sql);
			while( $data = mysql_fetch_array($res)){
				if(!isset($result_arr[$val][$data['id']])){
					$result_arr[$val][$data['id']] = array('found'=>0,'data'=>$data);
				}
				$result_arr[$val][$data['id']]['found'] = $result_arr[$val][$data['id']]['found']+1;
			}
		}
		$num_rows = count($result_arr[$val]);
		//echo $sql."<Br><br>";
		if( $num_rows > 0)
		{
			
			if( $val2 == "content_pages" )
				$val2 = "user_content_pages";
			$temp_headline_exp = explode("user_", $val2);
			$temp_headline = "temp_word_".$temp_headline_exp[1];
			
			if( $$temp_headline != "" )
			{
				$counter = 0 ;
				foreach($result_arr[$val] as $result)
				{
					if($min_search_words_to_find > $result['found']){
						continue;
					}
					$data = $result['data'];
					if($val2 == "user_content_pages"){
						if($data['redierct_301'] != ""){
							continue;
						}
						if($data['type'] == "net" || $data['type'] == "gb"){
							continue;
						}
					}
					else{
						$key_301 = $val."_".$data['id'];
						if(isset($arr_301[$key_301])){
							continue;
						}
					}
					if( $counter == 0 )
						echo "<h3>{$$temp_headline}</h3>";
					
					
					//echo $result['found']." - ";
					switch($val2)
					{
						
						case "user_guide_business" :
							echo "<a href='index.php?m=KgBm_p&pid=".$data['id']."&guide=' class='maintext'><b><u>".nl2br(htmlspecialchars(stripslashes($data['business_name'])))."</u></b></a><br>";
							if( strlen($data['description']) > 0 )
								echo substr(stripslashes(htmlspecialchars($data['description'])) , 0 , 100 )."...";
							else
								echo $data['description'];
							echo "<br><br>";
							$count_search++;
						break;
						
						case "user_guide_cats" :
							if( $data['father'] == "0" )
								echo "<a href='index.php?m=KgBm&guide=&Scat=".$data['id']."&STcat=0' class='maintext'><b><u>".nl2br(htmlspecialchars(stripslashes($data['cat_name'])))."</u></b></a><br>";
							else
								echo "<a href='index.php?m=KgBm&guide=&Scat=".$data['father']."&STcat=".$data['id']."' class='maintext'><b><u>".nl2br(htmlspecialchars(stripslashes($data['cat_name'])))."</u></b></a><br>";
							echo "<br><br>";
							$count_search++;
						break;
						
						
						case "user_content_pages" :
							$page_url = str_replace(" ","-",$data['name']);	
							if( $data['type'] == "text" )
								$data['name'] = ( $data_words['id'] == "" ) ? $word[LANG]['1_2_chapter_name_about'] : stripslashes($data_words['word_about']);
							if($data['name'] == ""){
								continue;
							}
							if($page_url != ""){
								$page_url .="/"; 
							}
							echo "<a href='/".$page_url."' class='maintext'><b><u>".nl2br(htmlspecialchars(stripslashes($data['name'])))."</u></b></a><br>";
							echo "<br><br>";
							$count_search++;
						break;
						
						case "user_articels" :
							echo "<a href='index.php?m=ar&artd=".$data['id']."' class='maintext'><b><u>".nl2br(htmlspecialchars(stripslashes($data['headline'])))."</u></b></a><br>";
							echo nl2br(htmlspecialchars(stripslashes($data['summary'])))."<br><br>";
							$count_search++;
						break;
						
						case "user_sales" :
						case "user_products" :
						case "user_video" :
						case "user_yad2" :
							echo "<a href='index.php?m=s_{$temp_headline_exp[1]}&ud=".$data['id']."' class='maintext'><b><u>".nl2br(htmlspecialchars(stripslashes($data['name'])))."</u></b></a><br>";
							echo nl2br(htmlspecialchars(stripslashes($data['summary'])))."<br><br>";
							$count_search++;
						break;
						
						case "user_wanted" :
							echo "<a href='index.php?m=jo' class='maintext'><b><u>".nl2br(htmlspecialchars(stripslashes($data['name'])))."</u></b></a><br>";
							echo stripslashes($data['content'])."<br><br>";
							$count_search++;
						break;
						
						case "user_realty" :
							echo "<a href='index.php?m=realty&rid=".$data['id']."' class='maintext'><b><u>".nl2br(htmlspecialchars(stripslashes($data['title'])))."</u></b></a><br><br>";
							$count_search++;
						break;
					}	//switch
					$counter++;
				} //	while
				
				echo "<hr width='100%' size='1' color='#{$data_colors['border_color']}'>";
			}	// if
		}	// if
	}	//	foreach
	
	//landig pages
	$landing_ids = array();
	
	$result_arr = array();
	foreach($search_words as $search_word){
		$sql = "select landing_id from sites_landingPage_modules where deleted = '0' AND visibility_hidden = '0' and unk = '".UNK."' and ( module_title like '%".$search_word."%')";
		$res = mysql_db_query(DB,$sql);
		while( $data = mysql_fetch_array($res)){
			if(!isset($result_arr[$data['landing_id']])){
				$result_arr[$data['landing_id']] = array('found'=>0,'data'=>$data);
			}
			$result_arr[$data['landing_id']]['found'] = $result_arr[$data['landing_id']]['found']+1;
		}
	}
	
	foreach($result_arr as $result){
		if($min_search_words_to_find > $result['found']){
			continue;
		}
		$data = $result['data'];
		$landing_ids[$data['landing_id']] = $data['landing_id'];
	}
	
	$result_arr = array();	
	foreach($search_words as $search_word){
		$sql = "select slp.landing_id from sites_landingPage_paragraph slp LEFT JOIN sites_landingPage_modules slm ON slp.module_id = slm.id 
				where slp.deleted = '0' AND  slm.deleted = '0' AND slm.visibility_hidden = '0' and slp.unk = '".UNK."' and ( slp.p_text like '%".$search_word."%')";
		$res = mysql_db_query(DB,$sql);
		while( $data = mysql_fetch_array($res)){
			if(!isset($result_arr[$data['landing_id']])){
				$result_arr[$data['landing_id']] = array('found'=>0,'data'=>$data);
			}
			$result_arr[$data['landing_id']]['found'] = $result_arr[$data['landing_id']]['found']+1;
		}
	}
	foreach($result_arr as $result){
		if($min_search_words_to_find > $result['found']){
			continue;
		} 
		$data = $result['data'];
		$landing_ids[$data['landing_id']] = $data['landing_id'];
	}	
	
	$lending_search_fields = array("landing_name","text_1","text_2");
	foreach($lending_search_fields as $field){
		$result_arr = array();	
		foreach($search_words as $search_word){
			$sql ="select id as landing_id from sites_landingPage_settings where deleted = '0' AND goto_url_301 = '' AND unk = '".UNK."' and ( landing_name like '%".$search_word."%')";
			$res = mysql_db_query(DB,$sql);
			while( $data = mysql_fetch_array($res)){
				if(!isset($result_arr[$data['landing_id']])){
					$result_arr[$data['landing_id']] = array('found'=>0,'data'=>$data);
				}
				$result_arr[$data['landing_id']]['found'] = $result_arr[$data['landing_id']]['found']+1;
			}
		}
				
		foreach($result_arr as $result){
			if($min_search_words_to_find > $result['found']){
				continue;
			}
			$data = $result['data'];
			$landing_ids[$data['landing_id']] = $data['landing_id'];
		}
	}
	
	$landing_in = implode(",",$landing_ids);
	$landing_sql_in = "";
	if($landing_in != ""){
		$landing_sql_in = " or id IN(".$landing_in.") ";
	}
	$sql = "select * from sites_landingPage_settings where deleted = '0' AND goto_url_301 = '' AND unk = '".UNK."' and ( landing_name like '%".$_GET['search_val']."%' ".$landing_sql_in.")";
	
	
	
	$res = mysql_db_query(DB,$sql);
	$num_rows = mysql_num_rows($res);
	$landing_pages_result = array();
	if( $num_rows > 0){	
		while( $data = mysql_fetch_array($res)){
			$landing_pages_result[$data['id']] = $data;
		}
	}
	if($num_rows > 0){
		echo "<h3>".$temp_word_landing_pages."</h3>";
		foreach($landing_pages_result as $landing_id=>$data){
			echo "<a href='landing.php?ld=".$landing_id."' class='maintext'><b><u>".nl2br(htmlspecialchars(stripslashes($data['landing_name'])))."</u></b></a><br><br>";
			$count_search++;
		}
		echo "<hr width='100%' size='1' color='#{$data_colors['border_color']}'>";
	}
	
	//landing pages
	if( $count_search == 0 )
	{
		echo "<p>".$word[LANG]['1_3_search_no_found_result']." <b>".$_GET['search_val']."</b></p>";
	}
	
}


function generat_css_code()
{
	global $data_colors,$data_name,$data_extra_settings,$right_menu_beckground;

	$img_g_site_bg = "";
	$abpath_temp_bll_all_site = SERVER_PATH."/tamplate/".stripslashes($data_colors['img_all_site_bg']);
	if( file_exists($abpath_temp_bll_all_site) && !is_dir($abpath_temp_bll_all_site) )
	{
		$temp_ss = ( !empty($data_colors['site_bg_color']) ) ? "#".$data_colors['site_bg_color'] : "" ;
		switch($data_colors['img_g_site_bg_repeat'])
		{
			case "1" :	$img_g_site_bg_repeat = "background-repeat: no-repeat;";	break;
			case "2" :	$img_g_site_bg_repeat = "background-repeat: repeat-x;";	break;
			case "3" :	$img_g_site_bg_repeat = "background-repeat: repeat-y;";	break;
		}
		if( UNK == "878912561075371037" )
			$img_g_site_bg = "background: ".$temp_ss." url(http://www.agam.co.il/tamplate/".stripslashes($data_colors['img_all_site_bg']).") scroll center; background-position: top; ".$img_g_site_bg_repeat;
		else
			$img_g_site_bg = "background: ".$temp_ss." url(".HTTP_PATH."/tamplate/".stripslashes($data_colors['img_all_site_bg']).") scroll center; background-position: top; ".$img_g_site_bg_repeat;
	}
	
	
	if( $data_extra_settings['estimateSite'] == "1" )
	{
		if( $img_g_site_bg == "" && $right_menu_beckground == "" )
		{
			$img_g_site_bg = "background:  url(".HTTP_PATH."/new_images/defualt_site_background.gif) scroll center; background-position: top; background-repeat: no-repeat;";
		}
		
		$bg_link = ( $data_colors['bg_link'] == "" ) ? "FFB72A" : $data_colors['bg_link'];
		$color_link = ( $data_colors['color_link'] == "" ) ? "ffffff" : $data_colors['color_link'];
		$site_text_color = ( $data_colors['site_text_color'] == "" ) ? "666666" : $data_colors['site_text_color'];
		$headline_color = ( $data_colors['headline_color'] == "" ) ?"666666" : $data_colors['headline_color'];
	}
	else
	{
		$bg_link = $data_colors['bg_link'];
		$color_link = ( $data_colors['color_link'] == "" ) ? "000000" : $data_colors['color_link'];
		$site_text_color = $data_colors['site_text_color'];
		$headline_color = $data_colors['headline_color'];
	}
	
	$COLORsite_bg_color = ( !empty($data_colors['site_bg_color']) ) ? "background-color:#".$data_colors['site_bg_color'].";" : "";
	
	
	
	
	
	$str;
	$str .= "<style type=\"text/css\">
		
		BODY { 
		  margin:0;
			".$COLORsite_bg_color."
		  ".$img_g_site_bg."
		}

		#menu {";
			$str .= "padding:0px;";
			$str .= "margin:2px;";
			$str .= "width:0;";
		$str .= "}

		#menu li {";
			$str .= "list-style-type:none;";
			$str .= "width:130px;";
			$str .= "height:100%;";
			$str .= "
			padding:3px 0 !important; /*moz width*/
			padding:2px 0; /*IE width*/";
			$str .= "clear:both;";
			$str .= "font-family:arial;";
			$str .= "font-size:12px;";
		$str .= "}
		
		
		#menu a, #menu a:visited {";
			$str .= "position:relative;";
			$str .= "display:block;";
			$str .= "width:130px;";
			$str .= "height:100%;";
			
			$temp_bg_link = ( $data_name['have_rightMenuButton'] == 0 ) ? "background-color:#".$bg_link.";" : "";
			//$str .= "border:0px solid #".$data_colors['border_color'].";";
			$str .= $temp_bg_link;
			$str .= "color:#".$color_link.";";
			$str .= "padding-left:3px;";
			$str .= "padding-right:3px;";
			$str .= "text-decoration:none;";
			$str .= "padding-top:2px;";
			$str .= "padding-bottom:2px;";
		$str .= "}
		
		#menu a span, #menu a:visited span {";
			$str .= "display:none;";
		$str .= "}
		
		#menu a:hover {";
			$temp_bg_link = ( $data_name['have_rightMenuButton'] == 0 ) ? "background-color:#".$color_link.";" : "";
			$temp_color = ( $data_name['have_rightMenuButton'] == 0 ) ? $bg_link : $data_colors['color_link_over'];
			$str .= "color:#".$temp_color.";";
			$str .= $temp_bg_link;
			$str .= "border:0px solid #000;";
			$str .= "text-decoration:none;";
		$str .= "}
		
		
		
		
		#menu2 {";
			$str .= "padding:0px;";
			$str .= "margin:2px;";
			$str .= "width:0;";
		$str .= "}

		#menu2 li {";
			$str .= "list-style-type:none;";
			$str .= "width:130px;";
			$str .= "height:100%;";
			$str .= "
			padding:3px 0 !important; /*moz width*/
			padding:2px 0; /*IE width*/";
			$str .= "clear:both;";
			$str .= "font-family:arial;";
			$str .= "font-size:12px;";
		$str .= "}
		
		
		#menu2 a, #menu2 a:visited {";
			$str .= "position:relative;";
			$str .= "display:block;";
			$str .= "width:130px;";
			$str .= "height:100%;";
			
			$temp_bg_link = ( $data_name['have_rightMenuButton'] == 0 ) ? "background-color:#".$bg_link.";" : "";
			//$str .= "border:0px solid #".$data_colors['border_color'].";";
			$str .= $temp_bg_link;
			$str .= "color:#".$color_link.";";
			$str .= "padding-left:3px;";
			$str .= "padding-right:3px;";
			$str .= "text-decoration:none;";
			$str .= "padding-top:2px;";
			$str .= "padding-bottom:2px;";
		$str .= "}
		
		#menu2 a span, #menu2 a:visited span {";
			$str .= "display:none;";
		$str .= "}
		
		#menu2 a:hover {";
			$temp_bg_link = ( $data_name['have_rightMenuButton'] == 0 ) ? "background-color:#".$color_link.";" : "";
			$temp_color = ( $data_name['have_rightMenuButton'] == 0 ) ? $bg_link : $data_colors['color_link_over'];
			$str .= "color:#".$temp_color.";";
			$str .= $temp_bg_link;
			$str .= "border:0px solid #000;";
			$str .= "text-decoration:none;";
		$str .= "}
		
		
		
		
		#headline_h2 H2 {";
			$str .= "color: #".$site_text_color.";";
			$str .= "font-family: Arial, Helvetica, sans-serif;";
			$str .= "font-size: 12px;";
			$str .= "text-decoration: none;";
			$str .= "padding:2px;";
			$str .= "margin:0px;";
		$str .= "}
		
		.maintext{";
			$str .= "color: #".$site_text_color.";";
			$str .= "font-family: Arial, Helvetica, sans-serif;";
			$str .= "font-size: 12px;";
			$str .= "text-decoration: none;";
		$str .= "}";
		
		$str .= ".maintext a:link {text-decoration:underline;color:#".$site_text_color.";}
		.maintext a:active{text-decoration:none;color:#".$site_text_color.";}
		.maintext a:visited{text-decoration:underline;color:#".$site_text_color.";}
		.maintext a:hover{text-decoration:none;color:#".$site_text_color.";}";

		$str .= "
		
		.maintext_small{";
			$str .= "color: #".$site_text_color.";";
			$str .= "font-family: Arial, Helvetica, sans-serif;";
			$str .= "font-size: 10px;";
			$str .= "text-decoration: none;";
		$str .= "}

		.rightMemu{";
			$str .= "color: #".$color_link.";";
			$str .= "font-family: Arial, Helvetica, sans-serif;";
			$str .= "font-size: 12px;";
			$str .= "text-decoration: none;";
			$str .= "font-weight: bold;";
		$str .= "}";

		$str .= ".rightMemu a:link {text-decoration:none;color:#".$color_link.";}
		.rightMemu a:active{text-decoration:none;color:#".$data_colors['color_link_over'].";}
		.rightMemu a:visited{text-decoration:none;color:#".$color_link.";}
		.rightMemu a:hover{text-decoration:none;color:#".$data_colors['color_link_over'].";}";
		
		$ecom_tableRightMenucolor = ( !empty($data_colors['color_e_comes_menu_right']) ) ? $data_colors['color_e_comes_menu_right'] : $color_link;
		$str .= "
		.ecom_tableRightMenu{";
			$str .= "color: #".$ecom_tableRightMenucolor.";";
			$str .= "font-family: Arial, Helvetica, sans-serif;";
			$str .= "font-size: 12px;";
			$str .= "text-decoration: none;";
			$str .= "font-weight: bold;";
		$str .= "}";

		$str .= ".ecom_tableRightMenu a:link {text-decoration:none;color:#".$ecom_tableRightMenucolor.";}
		.ecom_tableRightMenu a:active{text-decoration:none;color:#".$ecom_tableRightMenucolor.";}
		.ecom_tableRightMenu a:visited{text-decoration:none;color:#".$ecom_tableRightMenucolor.";}
		.ecom_tableRightMenu a:hover{text-decoration:none;color:#".$ecom_tableRightMenucolor.";}";

		$str .= "
		
		.headline{";
			$str .= "color: #".$headline_color.";";
			$str .= "font-family: Arial, Helvetica, sans-serif;";
			$str .= "text-decoration: none;";
		$str .= "}
		
		
		.page_headline{";
			$page_headline_color = ( $data_extra_settings['headlineTextarea'] != "" ) ? $data_extra_settings['headlineTextarea'] : $site_text_color;
			$str .= "color: #".$page_headline_color.";";
			$str .= "font: 17px  arial,sans-serif; font-weight:bold;";
			$str .= "text-decoration: none;";
			$str .= "padding:0px;margin:0px;";
		$str .= "}
			
		.site_border{";
			if( $data_colors['border_color'] != "" )
				$str .= "border: 1px solid #".$data_colors['border_color'].";";
		$str .= "}
		
		
		.input_style	{
		";
			$border_color = ( $data_colors['border_color'] == "" ) ? "000000" : $data_colors['border_color'];
			$border_color = ( UNK == "962424165194447636" ) ? "000000" : $border_color;
			$str .= "border: 1px solid #".$border_color.";";
			$str .= "font-family: Arial, Helvetica, sans-serif;";
			$str .= "font-size: 12px;";
			$str .= "color: #020202;";
			$str .= "width: 300px;";
			$str .= "height: 14px;";
			$str .= "text-decoration: none;";
			$str .= "background-color: #ffffff;";
		$str .= "
		}
		
		.submit_style	{";
			$str .= "color: #020202;";
			$str .= "font-family: Arial, Helvetica, sans-serif;";
			$str .= "font-size: 12px;";
			$str .= "text-decoration: none;";
			$border_color = ( $data_colors['border_color'] == "" ) ? "000000" : $data_colors['border_color'];
			$border_color = ( UNK == "962424165194447636" ) ? "000000" : $border_color;
			$str .= "border: 1px solid #".$border_color.";";
			$str .= "background-color: #eaeaea;";
			$str .= "width: 100px;";
			$str .= "height: 18px;";
		$str .= "}
		
		/***** Gallery ***/
		.gallerycontainer{";
			$str .= "position: relative;";	//*Add a height attribute and set to largest image's height to prevent overlaying*/
		$str .= "}
		
		img{border:0;}
		
		.thumbnail img{";
			if( $data_colors['border_color'] != "" )
				$str .= "border: 1px solid #".$data_colors['border_color'].";";
			$str .= "margin: 0 5px 5px 0;";
		$str .= "}
		
		.thumbnail:hover{";
			$str .= "background-color: transparent;";
		$str .= "}
		
		
		.thumbnail:hover img{";
			if( $data_colors['border_color'] != "" )
				$str .= "border: 1px solid #".$data_colors['border_color'].";";
		$str .= "}
			
		.thumbnail span{"; /*CSS for enlarged image*/
			$str .= "position: absolute;";
			$galley_back_color = ( $data_colors['galley_back_color'] ) ? $data_colors['galley_back_color'] : $color_link;
			$str .= "background-color: #".$galley_back_color.";";
			$str .= "padding: 10px;";
			$str .= "left: -1000px;";
			$str .= "border: 0px dashed gray;";
			$str .= "visibility: hidden;";
			$str .= "color: black;";
			$str .= "text-decoration: none;";
		$str .= "}
		
		.thumbnail span img{"; /*CSS for enlarged image*/
			$str .= "border-width: 0;";
			$str .= "padding: 10px;";
		$str .= "}
		
		.thumbnail:hover span{"; /*CSS for enlarged image*/
			$str .= "visibility: visible;";
			$str .= "top: 0;";
			$str .= "left: 140px;"; /*position where enlarged image should offset horizontally */
			$str .= "z-index: 50;";
		$str .= "}
		
		
		
		
		.thumbnail2 img{";
			if( $data_colors['border_color'] != "" )
				$str .= "border: 1px solid #".$data_colors['border_color'].";";
			$str .= "margin: 0 5px 5px 0;";
		$str .= "}
		
		.thumbnail2:hover{";
			$str .= "background-color: transparent;";
		$str .= "}
		
		
		.thumbnail2:hover img{";
			if( $data_colors['border_color'] != "" )
				$str .= "border: 1px solid #".$data_colors['border_color'].";";
		$str .= "}
			
		.thumbnail2 span{ ";/*CSS for enlarged image*/
			$str .= "position: absolute;";
			$str .= "background-color: #".$data_colors['conent_bg_color'].";";
			$str .= "padding: 5px;";
			$str .= "left: -1000px;";
			$str .= "border: 0px dashed gray;";
			$str .= "visibility: hidden;";
			$str .= "color: black;";
			$str .= "text-decoration: none;";
		$str .= "}
		
		.thumbnail2 span img{ ";/*CSS for enlarged image*/
			$str .= "border-width: 0;";
			$str .= "padding: 2px;";
			if( $data_colors['border_color'] != "" )
				$str .= "border: 1px solid #".$data_colors['border_color'].";";
		$str .= "}
		
		.thumbnail2:hover span{ ";/*CSS for enlarged image*/
			$str .= "visibility: visible;";
			$str .= "top: 0;";
			$str .= "left: 140px;"; /*position where enlarged image should offset horizontally */
			$str .= "z-index: 50;";
		$str .= "}
		
		.thumbnail2 span{ ";/*CSS for enlarged image*/
			$str .= "visibility: visible;";
			$str .= "top: 0;";
			$str .= "left: 140px;"; /*position where enlarged image should offset horizontally */
			$str .= "z-index: 50;";
		$str .= "}
		";
		
		if( UNK == "179082701464956299" || UNK == "950576106799129933" )
		{
			$str .= ".spe_medicartTopslice1 { ";
				$str .= "color: #ffffff;";
				$str .= "font-family: Arial, Helvetica, sans-serif;";
				$str .= "font-size: 14px;";
				$str .= "text-decoration: none;";
				$str .= "font-weight: bold;";
			$str .= "}
			
			.spe_medicartTopslice1 a:link {text-decoration:none;color:#ffffff;}
			.spe_medicartTopslice1 a:active{text-decoration:none;color:#FDBC39;}
			.spe_medicartTopslice1 a:visited{text-decoration:none;color:#ffffff;}
			.spe_medicartTopslice1 a:hover{text-decoration:none;color:#FDBC39;}
			
			.spe_medicartTopslice2 { ";
				$str .= "color: #FF6602;";
				$str .= "font-family: Arial, Helvetica, sans-serif;";
				$str .= "font-size: 14px;";
				$str .= "text-decoration: none;";
				$str .= "font-weight: bold;";
			$str .= "}
			
			.spe_medicartTopslice2 a:link {text-decoration:none;color:#FF6602;}
			.spe_medicartTopslice2 a:active{text-decoration:none;color:#000000;}
			.spe_medicartTopslice2 a:visited{text-decoration:none;color:#FF6602;}
			.spe_medicartTopslice2 a:hover{text-decoration:none;color:#000000;}";
			
		}
		
		if( $data_extra_settings['have_scrollNewsImgs'] == "1" )
		{
			$abpath_temp = SERVER_PATH."/tamplate/".stripslashes($data_extra_settings['scrollNewsDupli']);
			if( file_exists($abpath_temp) && !is_dir($abpath_temp) )	{
				$im_size = GetImageSize ($abpath_temp); 
				$imageHeight = $im_size[1];
			}
			
			$height_marqueecontainer = ( $imageHeight <= 50 ) ? "150" : $imageHeight;
			
			$str .= "#marqueecontainer{";
				$str .= "position: relative;";
				$str .= "width: 140px;"; /*marquee width */
				$str .= "height: ".$height_marqueecontainer."px;"; /*marquee height */
				$str .= "overflow: hidden;";
				$str .= "padding: 0px;";
				$str .= "padding-left: 0px;";
				$str .= "padding-right: 0px;";
			$str .= "}";
		}
		else
		{
			$str .= "#marqueecontainer{";
				$str .= "position: relative;";
				$str .= "width: 140px;"; /*marquee width */
				$str .= "height: 150px;"; /*marquee height */
				$str .= "background-color: #".$data_colors['conent_bg_color'].";";
				$str .= "overflow: hidden;";
				$str .= "padding: 0px;";
				$str .= "padding-left: 0px;";
				$str .= "padding-right: 0px;";
			$str .= "}";
		}
		
		if( $_GET['m'] == "zoom_gallery" )
		{
		
			$str .= ".thumbDemoBack {
				float: left; 
				width: 142px; 
				height: 139px; 
				margin-bottom: 5px; 
				margin-right: 15px;
				background-position: center center;
				background-repeat: no-repeat;
				background-image: url('/zoomFiles/axZm/icons/thumb_back.png');
				overflow: hidden;
			}
			.thumbDemo {
				width: 142px; 
				height: 100px; 
				margin-left: 21px;
				margin-top: 20px;
				background-position: center center;
				background-repeat: no-repeat;
				text-align: center;
			}
			.thumbDemoImg {
				width: 100px;
				height: 100px;
			}
			.thumbDemoLink{
			
			}";
		}
		
		if( $data_name['have_topmenu'] == 1 )
		{
			$str .= "
				.chromestyle{
width: 100%;
font-weight: bold;
font-family: arial;
font-size: 12px;
direction:ltr;
}

.chromestyle:after{ /*Add margin between menu and rest of content in Firefox*/
content: \" \"; 
display: block; 
height: 0; 
clear: both; 
visibility: hidden;
}

.chromestyle ul{
border: 1px solid #".$data_colors['border_color'].";
width: 100%;
background-color: #".$bg_link.";
padding: 4px 0;
margin: 0;
text-align: center; /*set value to \"left\", \"center\", or \"right\"*/
}

.chromestyle ul li{
display: inline;
}

.chromestyle ul li a{
color: #".$color_link.";
padding: 4;
margin: 0;
text-decoration: none;
border-left: 1px solid #".$data_colors['border_color']."; /*THEME CHANGE HERE*/
}

.chromestyle ul li a:hover{
color: #".$bg_link.";
background-color: #".$color_link.";
}


.chromestyle ul li a:after{ /*HTML to indicate drop down link*/
visibility: hidden;
content: \"a\";
}

.chromestyle ul li a[rel]:after{ /*HTML to indicate drop down link*/
visibility: hidden;
content: \"a\";
}


/* ######### Style for Drop Down Menu ######### */

.dropmenudiv{
position:absolute;
top: 0;
border: 1px solid #".$data_colors['border_color']."; /*THEME CHANGE HERE*/
border-bottom-width: 0;
font-family: arial;
font-size: 12px;
line-height:18px;
z-index:100;
background-color: #".$bg_link.";
width: 200px;
visibility: hidden;
filter: progid:DXImageTransform.Microsoft.Shadow(color=#CACACA,direction=135,strength=4); /*Add Shadow in IE. Remove if desired*/
}


.dropmenudiv a{
width: 100%;
display: block;
text-indent: 3px;
border-bottom: 1px solid #".$data_colors['border_color']."; /*THEME CHANGE HERE*/
padding: 2px 0;
text-decoration: none;
font-weight: bold;
color: #".$color_link.";
}

.product_container{	/* Div for each product */
	/*width:154px;*/
	float:left;
	padding:2px;
	height: 100%;
}



.sliding_product img{	/* Float product images */
	float:left;
	margin:2px;
}

.dropmenudiv a:hover{ /*THEME CHANGE HERE*/
color: #".$bg_link.";
background-color: #".$color_link.";
z-index:100px;
}

/****************************************/
/***************************************/
/****************************************/
";
$str .= "
#sddm
{	margin: 0;
	padding: 0;
	z-index: 30}

#sddm li
{	margin: 0;
	padding: 0;
	list-style: none;
	float: right;
	font: bold 11px arial}

#sddm li a
{	display: block;
	margin: 0 1px 0 0;
	padding: 4px 10px;
	width: auto;
	background: #5970B2;
	color: #FFF;
	text-align: center;
	text-decoration: none}

#sddm li a:hover
{	background: #49A3FF}

#sddm div
{	position: absolute;
	visibility: hidden;
	margin: 0;
	padding: 0;
	background: #EAEBD8;
	border: 1px solid #5970B2}

	#sddm div a
	{	position: relative;
		display: block;
		margin: 0;
		padding: 5px 10px;
		width: auto;
		white-space: nowrap;
		text-align: center;
		text-decoration: none;
		background: #EAEBD8;
		color: #2875DE;
		font: 11px arial}

	#sddm div a:hover
	{	background: #49A3FF;
		color: #FFF}

";

/****************************************/
/***************************************/
/****************************************/

$str .= "
#outside{

	}
#navigation-1 {
	padding:1px 0;
	margin:0px;
	list-style:none;
	width:100%;
	height:18px;
	border-top:0px solid #".$data_colors['border_color'].";
	border-bottom:0px solid #".$data_colors['border_color'].";
	font:normal 8pt verdana, arial, helvetica;
}
#navigation-1 li {
	margin:0;
	padding:0;
	display:block;
	float:right;
	position:relative;
	list-type:inside;
	
}
#navigation-1 li a:link, #navigation-1 li a:visited {
	padding:5px;
	display:block;
	text-align:center;
	text-decoration:none;
	background:#".$bg_link.";
	color:#".$color_link.";
	height:13px;
	border-right:1px solid #".$data_colors['border_color'].";
	border-left:1px solid #".$data_colors['border_color'].";
	border-bottom:1px solid #".$data_colors['border_color'].";
}
#navigation-1 li:hover a, #navigation-1 li a:hover, #navigation-1 li a:active {
	padding:5px;
	display:block;
	text-align:center;
	text-decoration:none;
	background:#".$color_link.";
	color:#".$bg_link.";
	height:13px;
	border-left:1px solid #".$data_colors['border_color'].";
}
#navigation-1 li ul.navigation-2 {
	margin:0;
	padding:1px 1px 0;
	list-style:none;
	display:none;
	background:#".$bg_link.";
	position:absolute;
	top:18px;
	border:1px solid #".$data_colors['border_color'].";
	border-top:none;
	direction: ltr;
	right: 0px;
	z-index: 900;
}
#navigation-1 li:hover ul.navigation-2 {
	display:block;
}
#navigation-1 li ul.navigation-2 li {
	clear:right;
}
#navigation-1 li ul.navigation-2 li a:link, #navigation-1 li ul.navigation-2 li a:visited {
	clear:right;
	background:#".$bg_link.";
	color:#".$color_link.";
	padding:4px 0;
	width:200px;
	border:none;
	border-bottom:1px solid #".$data_colors['border_color'].";
	border-left:1px solid #".$data_colors['border_color'].";
	position:relative;
	z-index:1000;
}
#navigation-1 li ul.navigation-2 li:hover a, #navigation-1 li ul.navigation-2 li a:active, #navigation-1 li ul.navigation-2 li a:hover {
	clear:right;
	background:#".$color_link.";
	color:#".$bg_link.";
	padding:4px 0;
	width:200px;
	border:none;
	border-bottom:1px solid #".$data_colors['border_color'].";
	border-left:1px solid #".$data_colors['border_color'].";
	position:relative;
	z-index:1000;
}
#navigation-1 li ul.navigation-2 li a span {
	position:absolute;
	top:0;
	right:128px;
	font-size:12pt;
	color:#".$color_link.";
	z-index:1000;
}
#navigation-1 li ul.navigation-2 li:hover a span, #navigation-1 li ul.navigation-2 li a:hover span {
	position:absolute;
	top:0;
	right:128px;
	font-size:12pt;
	color:#".$color_link.";
	z-index:1000;
}


.ie6_top_menu{
	padding:1px 0;
	margin:0px;
	height:18px;
	border-top:0px solid #".$data_colors['border_color'].";
	border-bottom:0px solid #".$data_colors['border_color'].";
	font:normal 8pt verdana, arial, helvetica;
}

.ie6_top_menu_link {
	padding:5px;
	text-align:center;
	text-decoration:none;
	background:#".$bg_link.";
	color:#".$color_link.";
	height:18px;
	border-right:1px solid #".$data_colors['border_color'].";
	border-left:1px solid #".$data_colors['border_color'].";
	border-bottom:1px solid #".$data_colors['border_color'].";
	line-height: 25px;
}

			";
		}
		
$str .= "</style>";
/*
if( $_SERVER[REMOTE_ADDR] == "89.138.255.149" )
{
	$file2 = @fopen(SERVER_PATH."/style.css", "w");
	@rewind($file2);
	@fputs($file2, $str);
	@fclose($file2);
	
	echo $file2."**";
}*/
	
	//if( $file2 == "" )
		return $str;
	//else
//		return "<LINK REL=\"stylesheet\" TYPE=\"text/css\" HREF=\"style.css\">";
	
	
}

function bottom_copyright($is_landing = false)
{
	global $data_name,$word,$settings,$data_extra_settings;
	
	
	$sql = "select owner_id from users where unk = '".UNK."'";
	$res = mysql_db_query(DB,$sql);
	$data = mysql_fetch_array($res);
	
	$sql = "select company,homesite from sites_owner where id = '".$data['owner_id']."'";
	$res2 = mysql_db_query(DB,$sql);
	$data2 = mysql_fetch_array($res2);
	
	$sql = "
		SELECT us.id FROM users as us,user_portal  WHERE
			us.portal_active=0 AND 
			user_portal.portal_id=2 AND 
			user_portal.user_id=us.id  AND
			us.unk = '".UNK."'";
	$res_beer7 = mysql_db_query(DB,$sql);
	$data_beer7 = mysql_fetch_array($res_beer7);
	
	$sql = "
		SELECT us.id FROM users as us,user_portal  WHERE
			us.portal_active=0 AND 
			user_portal.portal_id=1 AND 
			user_portal.user_id=us.id  AND
			us.unk = '".UNK."'";
	$res_il = mysql_db_query(DB,$sql);
	$data_il = mysql_fetch_array($res_il);
	
	
	echo "<div class='bottom-copyright-wrap'>";
	
		echo "<div class='bottom-copyright row-fluid'>";
			if(!$is_landing){
				echo "<div class='bottom-copyright-item bottom-copyright-main span5'>".$word[LANG]['1_3_copyright']." ".trim(stripslashes($data_name['name']))."</div>";
				echo "<div class='span2'></div>";
				
				if( $data_extra_settings['estimateSite'] == "1")
				{
					echo "<div class='bottom-copyright-leftside row-fluid span5'>";
							echo "<div class='bottom-copyright-item bottom-copyright-sitemap span4'><a href='http://".$_SERVER['HTTP_HOST']."/index.php?m=search' class='headline' style='font-size:10px;' title='מפת אתר'>מפת אתר</a></div>";
							//echo "<div class='bottom-copyright-item bottom-copyright-alt span10'>".trim(stripslashes($data_name['name'])). "</div>";
							echo "<div class='bottom-copyright-item bottom-copyright-sitemap span4'><a href='https://il-biz.co.il/%D7%9C%D7%99%D7%93%D7%99%D7%9D/' class='headline' target='_blank' title='לידים איכותיים'><u>לידים איכותיים</u></a></div>";
							echo "<div class='bottom-copyright-item bottom-copyright-sitemap span4'><a href=\"https://il-biz.co.il/\" class=\"headline\" style=\"font-size:10px;\" target=\"_blank\" title='לידים'><img src='".HTTP_S."://www.ilbiz.co.il/sn/images/il-biz_logo.png' style='height:24px;' alt='לידים' title='לידים' /></a></div>";
							echo "<div style='clear:both'></div>";
					echo "</div>";		
				}
				else
				{
					echo "<table border=\"0\" cellspacing=\"0\" cellpadding=\"0\" class=\"headline\" style=\"font-size:10px;\">";
						echo "<tr>";
							if( UNK == "607189207778116683" )
							{
								echo "<td width=10></td>";
								echo "<td><A href='http://www.paypal.com/' target='_blank' title='PayPal'><img src='http://www.special-jewelry.com/paypalBig.gif' alt='PayPal'></a></td>";
								echo "<td width=10></td>";
							}
							
							if( $data_extra_settings['havaKidomBottomLink'] == "0" )
							echo "<td align='".$settings['align']."'><a href='http://kidum.ilbiz.co.il/' class='headline' target='_blank' title='".$word[LANG]['1_3_copyright_Promotion_ilan']."'><u>".$word[LANG]['1_3_copyright_Promotion_ilan']."</u></a></td>";
							
							if( !empty($data_beer7['id']) )
							{
								echo "<td width=10></td>";
								echo "<td><a href=\"http://www.10service.co.il/landing.php?ld=175\" class=\"headline\" style=\"font-size:10px;\" target=\"_blank\" title='פרסום באינטרנט'><u>פרסום באינטרנט</u></a></td>";
							}

							
							if( $data_name['have_design'] == "0" )
							{
								if( $data['owner_id'] != "1" )
								{
									if( $data2['company'] != "" && $data2['homesite'] != "" )
									{
										echo "<td width=10></td>";
										echo "<td><a href=\"".$data2['homesite']."\" class=\"headline\" style=\"font-size:10px;\" target=\"_blank\"><u>עיצוב ".stripslashes($data2['company'])."</u></a></td>";
									}
								}
									if( LANG == "he" )
									{
									echo "<td width=10></td>";
									echo "<td><a href=\"http://www.10service.co.il//\" class=\"headline\" style=\"font-size:10px;\" target=\"_blank\" title='שירות 10'><u>שירות 10</u></a></td>";
									}
									echo "<td width=10></td>";
									echo "<td><a href=\"http://www.il-biz.co.il/\" class=\"headline\" style=\"font-size:10px;\" target=\"_blank\" title='".$word[LANG]['1_3_copyright_ilbiz_name_alt']."'><u>".$word[LANG]['1_3_copyright_ilbiz_name']."</u></a></td>";
									echo "<td width=2></td>";
									echo "<td><a href=\"http://www.il-biz.com/\" class=\"headline\" style=\"font-size:10px;\" target=\"_blank\" title='".$word[LANG]['1_3_copyright_ilbiz_name_alt']."'><img src='http://www.ilbiz.co.il/sn/images/il-biz_logo.png' height='12' alt='קידום עסקים באינטרנט' title='קידום עסקים באינטרנט' /></a></td>";
									
							}
							
						echo "</tr>";
					echo "</table>";
				}
				echo "<div style='clear:both'></div>";
				echo "</div>";
			}
		echo "</div>";
	echo "</div>";
	
}

function marketing_partners_logout(){
	echo "<div style='display:none'><iframe src ='".HTTP_S."://www.ilbiz.co.il/newsite/net_system/frame_logout.php?unk=".UNK."'></iframe></div>";
}


function marketing_partners($benn_type)
{
	global $data_name;
	
	if($benn_type == "TOallSites" && UNK != "125073680729239348" )
	{
		if( UNK != "731234420128026341" && UNK != "425741939164543282" )
		{
			echo "<div id=\"marketing_partners_TOallSites\"></div>
				
				<script type='text/javascript'>
					swfPlayer(\"http://ilbiz.co.il/ClientSite/site_banners/03030303-1-47.swf\",\"banner_TOallSites\",\"140\",\"350\",\"#\",\"marketing_partners_TOallSites\");
				</script>";
		}
	}
	else
	{
		if( $data_name['have_side_ilbiz_net'] == "1" )
		{
			
			echo "<iframe src ='http://www.ilbiz.co.il/newsite/net_system/banner.php?unk=".UNK."&amp;b1=&amp;cnu=yes_regIT&amp;b2=' width='100%' height='40px' id='loginPage2' frameborder=0 scrolling=no allowtransparency='true'></iframe>";
			/*echo "
			<script type='text/javascript'> 
			
			docHeight = document.getElementById('loginPage2').contentWindow.document.body.scrollHeight;
			document.write(docHeight+'*');
			</script>
			";*/
		}
		else
		{
			$benn_type = "1";
			$sql = "select * from marketing_partners where unk = '".UNK."' and type = '".$benn_type."' and deleted=0 and status=0 order by rand() limit 1";
			$res = mysql_db_query(DB,$sql);
			$data = mysql_fetch_array($res);
			
			
			$abpath_temp = "/home/ilan123/domains/ilbiz.co.il/public_html/ClientSite/site_banners/".stripslashes($data['banner_name']);
			if( file_exists($abpath_temp) && !is_dir($abpath_temp) )	
			{
				$temp_test = explode( "." , $data['banner_name'] );
				
				if( $temp_test[1] == "swf" )
				{
					
					$banner_name = "marketing_partners_".stripslashes($data['banner_name']);
					$banner = "
						<div id=\"".$banner_name."\"></div>
						
						<script type='text/javascript'>
							loadSWFwithBase(\"http://www.ilbiz.co.il/ClientSite/site_banners/".stripslashes($data['banner_name'])."\",\"".$banner_name."\",\"".stripslashes($data['banner_width'])."\",\"".stripslashes($data['banner_height'])."\",\"#".stripslashes($data['banner_color'])."\",\"".$banner_name."\");
						</script>
						";
				}
				else 
				{
					$im_size = GetImageSize ($abpath_temp); 
					$imageWidth = $im_size[0]; 
					$imageHeight = $im_size[1];
					
					if( $imageWidth > 150 )
						$imageWidth = 150;
					
					$banner = "<img src=\"http://ilbiz.co.il/ClientSite/site_banners/".stripslashes($data['banner_name'])."\" border='0' width=\"".$imageWidth."\" alt=''>";
				}
				
				echo "<br>".$banner;
			}
		}
	}
}


function detectBrowser() {
   $browsers = array("msie", "firefox"); //- Add here
   $names = array ("msie" => "msie", "firefox" => "moz"); //- The same
   $nav = "Unknown";
   $sig = strToLower ($_SERVER['HTTP_USER_AGENT']);
   foreach ($browsers as $b) {
       if ( $pos = strpos ($sig, $b) ) {
           $nav = $names[$b];
           break;
       }
   }
   if ($nav == "Unknown") return array ("app.Name" => $nav, "app.Ver" => "?", "app.Sig" => $sig);
   $ver = "";
   for ( ; $pos <= strlen ($sig); $pos ++) {
       if ( (is_numeric($sig[$pos])) || ($sig[$pos]==".") ) {
           $ver .= $sig[$pos];
       }
       else if ($ver) break;
   }
   return array("app.Name" => $nav, "app.Ver" => $ver, "app.Sig" => $sig);
}


function kill_and_strip($string)
{
	return htmlspecialchars(stripslashes($string));
}



function marquee_by_side()
{
	
	$sql = "select * from user_news where deleted = '0' and unk = '".UNK."'";
	$res = mysql_db_query(DB,$sql);
	$num_rows = mysql_num_rows($res);

	if( $num_rows > 0 )
	{
	$nav = detectBrowser();
		//if( $nav['app.Name'] == "moz" )
		//{
			
			echo "<div class=\"dmarquee\"><div><div>";
			while ( $data_scroll = mysql_fetch_array($res) )
			{
				$content = kill_and_strip($data_scroll['content']);
				$content = str_replace( "'" , "&acute;" , $content );
				
				$headline = "<b>".kill_and_strip($data_scroll['headline'])."</b>&nbsp;&nbsp;&nbsp;&nbsp;";
				$headline = str_replace( "'" , "&acute;" , $headline );
				
				$u_strat = ( $data_scroll['link'] ) ? "<a href='".kill_and_strip($data_scroll['link'])."' class='maintext' target='_blank'><u>" : "";
				$u_end = ( $data_scroll['link'] ) ? "</u></a>" : "";
				echo "<font class='maintext'>".$headline.$u_strat.$content.$u_end."</font>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
			}
			echo "</div></div></div>";
	}
}

function add_to_favorite()
{
	global $data_name,$word;
	
	echo "<table border=\"0\" cellspacing=\"0\" cellpadding=\"0\" class=\"rightMemu\">";
		echo "<tr>";
			echo "<td>|</td>";
			echo "<td width=\"3\"></td>";
			echo "<td><a href='javascript:void(0)' class='rightMemu' style='font-size:10px;' onclick=\"this.style.behavior='url(#default#homepage)';this.setHomePage('http://".$data_name['domain']."');\">".$word[LANG]['1_3_gw_change_home_page']."</a></td>";
			echo "<td width=\"3\"></td>";
			echo "<td>|</td>";
			echo "<td width=\"3\"></td>";
			echo "<td><a href='javascript:addIEFavorite()' class='rightMemu' style='font-size:10px;'>".$word[LANG]['1_3_gw_to_favi']."</a></td>";
			echo "<td width=\"3\"></td>";
			echo "<td>|</td>";
		echo "</tr>";
	echo "</table>";
}

function google_search()
{
	global $word,$settings;
	
echo "
<!-- Search Google -->
	<form method=\"get\" action=\"".HTTP_S."://www.google.co.il/custom\" target=\"google_window\" style='padding:0; margin:0;'>
	<input type=\"hidden\" name=\"client\" value=\"pub-5037108574233722\">
	<input type=\"hidden\" name=\"forid\" value=\"1\">
	<input type=\"hidden\" name=\"ie\" value=\"ISO-8859-8-I\">
	<input type=\"hidden\" name=\"oe\" value=\"ISO-8859-8-I\">
	<input type=\"hidden\" name=\"cof\" value=\"GALT:#008000;GL:1;DIV:#336699;VLC:663399;AH:center;BGC:FFFFFF;LBGC:336699;ALC:0000FF;LC:0000FF;T:000000;GFNT:0000FF;GIMP:0000FF;FORID:1\">
	<input type=\"hidden\" name=\"hl\" value=\"iw\">
	
	<table border=\"0\" cellspacing=\"0\" cellpadding=\"0\" align=\"center\">
		<tr>
			<td width=5></td>
			<td nowrap=\"nowrap\" valign=\"top\">
			<label for=\"sbi\" style=\"display: none\">".$word[LANG]['1_3_google_search_insert_sents']."</label>
			<input type=\"text\" name=\"q\" id=\"sbi\" style=\"width:125px;\" class=\"input_style\" maxlength=\"255\" value=\"\">
			<label for=\"sbb\" style=\"display: none\">".$word[LANG]['1_3_google_search_send_form']."</label>
			
			</td>
		</tr>
		<tr><td colspan=2 height=3></td></tr>
		<tr>
			<td width=5></td>
			<td><input type=\"submit\" name=\"sa\" class=\"input_style\" style=\"width:127px; height: 19px;\" value=\"".$word[LANG]['1_3_google_search_submit']."\" dir=\"".$settings['dir']."\" id=\"sbb\"></td>
		</tr>
	</table>
	</form>
<!-- Search Google -->";
}

function ecom_table()
{
	global $word,$data_extra_settings,$settings;
	
	$sql = "select product_id from user_ecom_items where unk = '".UNK."' and status=0 AND client_unickSes = '".$_SESSION['ecom']['unickSES']."' GROUP BY product_id";
	$res = mysql_db_query(DB,$sql);
	$num_rows = mysql_num_rows($res);
	
	$hr_line_color = ( $data_extra_settings['cartLinsColor'] != "" ) ? "color='#".stripslashes($data_extra_settings['cartLinsColor'])."'" : "class='ecom_tableRightMenu'";
	$hr_line = "<hr size=1 width=100% ".$hr_line_color." style='border-style: dotted;'>";
	echo "<table border=\"0\" cellspacing=\"0\" cellpadding=\"0\">";
		echo "<tr><TD height=\"7\" colspan=\"2\"></TD></tr>";
		echo "<tr>";
			echo "<td width='5'></td>";
			echo "<td>";
				echo "<div id=\"shopping_cart\">";
			
					echo "<table border=\"0\" cellspacing=\"0\" cellpadding=\"0\" class=\"ecom_tableRightMenu\" width=140>";
						echo "<tr>";
							echo "<td width=3></td>";
							$abpath_temp = SERVER_PATH."/tamplate/".stripslashes($data_extra_settings['cartHeadlineImg']);
							if( file_exists($abpath_temp) && !is_dir($abpath_temp) )	{
								//$im_size = GetImageSize ($abpath_temp); 
								//$imageHeight = $im_size[1];
								echo "<td><img src='/tamplate/".stripslashes($data_extra_settings['cartHeadlineImg'])."' border=0 alt=''></tD>";
							}
							else
							{
								echo "<td><strong class='ecom_tableRightMenu'>".$word[LANG]['1_3_ecom_table_title']."</strong></tD>";
							}
						echo "</tr>";
					echo "</table>";
					echo "	";
					echo "<table id=\"shopping_cart_items\" class='ecom_tableRightMenu' width=140>";
						echo "<tr>";
							echo "<th>".$word[LANG]['1_3_ecom_table_qry']."</th>";
							echo "<th>".$word[LANG]['1_3_ecom_table_product']."</th>";
							echo "<th>".$word[LANG]['1_3_ecom_table_price']."</th>";
							echo "<th></th>";
						echo "</tr>";
						//echo "<tr><th colspan=4>".$hr_line."</th></tr>";
						$total_price_to_pay = 0;
						while( $data = mysql_fetch_array($res) )
						{
							$sql = "select name,price from user_products where id = '".$data['product_id']."'";
							$res2 = mysql_db_query(DB,$sql);
							$data2 = mysql_fetch_array($res2);
							
							$sql = "select id from user_ecom_items where unk = '".UNK."' and status=0 AND client_unickSes = '".$_SESSION['ecom']['unickSES']."' and product_id = '".$data['product_id']."'";
							$res3 = mysql_db_query(DB,$sql);
							$qry_nm = mysql_num_rows($res3);
							
							echo "<tr id='shopping_cart_items_product".$data['product_id']."'>";
								echo "<th style='font-size:10px;'>".$qry_nm."</th>";
								echo "<th style='font-size:10px;'>".htmlspecialchars(stripslashes($data2['name']))."</th>";
								echo "<th style='font-size:10px;'>".htmlspecialchars(stripslashes($data2['price']))."</th>";
								if( UNK == "038157696328808156" )
									echo "<th style='font-size:10px;'><a href='javascript:void(0)' onclick='removeProductFromBasket(".$data['product_id'].")'>בטל</a></th>";
								else
									echo "<th style='font-size:10px;'><a href='javascript:void(0)' onclick='removeProductFromBasket(".$data['product_id'].")'><img src='http://ilbiz.co.il/ClientSite/other/sym_img/remove.gif' border=0 alt='".$word[LANG]['1_3_ecom_table_del']."'></a></th>";
							echo "</tr>";
							
							
							$total_price_to_pay = $total_price_to_pay + ( $data2['price'] * $qry_nm );
						}
								
					echo "</table>";
					
					echo $hr_line;
					echo "<div id=\"shopping_cart_totalprice\" class='ecom_tableRightMenu' align='".$settings['re_align']."'>".$word[LANG]['1_3_ecom_table_total']." ".$total_price_to_pay." ".COIN."</div>";
					echo $hr_line;
					
			echo "</div>";
			echo "</td>";
		echo "</tr>";
		echo "<tr>";
			echo "<td width=5></td>";
			echo "<td align='".$settings['re_align']."'>";
				$abpath_temp = SERVER_PATH."/tamplate/".stripslashes($data_extra_settings['cartKopaImg']);
				if( file_exists($abpath_temp) && !is_dir($abpath_temp) )	{
					echo "<a href='index.php?m=ecom_form' class='ecom_tableRightMenu'><img src='/tamplate/".stripslashes($data_extra_settings['cartKopaImg'])."' border=0 alt=''></a>";
				}
				else
				{
					echo "<b><u><a href='index.php?m=ecom_form' class='ecom_tableRightMenu'>".$word[LANG]['1_3_ecom_table_cart']."</a></u></b>";
				}
			echo "</td>";
		echo "</tr>";
		echo "<tr><TD height=\"7\" colspan=\"2\"></TD></tr>";
	echo "</table>";
	
	
}


function top_user_address()
{
	global $data_name,$word;
	
	echo "<table border=\"0\" cellspacing=\"0\" cellpadding=\"0\" class=\"maintext\">";
			echo "<tr>";
						echo "<td width=\"5\"></td>";
						if( $data_name['city'] )	{
							$sql = "select name from cities where id = '".$data_name['city']."'";
							$res = mysql_db_query(DB,$sql);
							$data_city = mysql_fetch_array($res);
							
							$adress = ( $data_name['address'] != "" ) ? $word[LANG]['1_3_top_details_address']." ".stripslashes($data_name['address']).","  : $word[LANG]['1_3_top_details_city']." ";
							echo "<td>".$adress." ".stripslashes($data_city['name'])."</td>";
							echo "<td width=\"10\"></td>";
							echo "<td>|</td>";
							echo "<td width=\"10\"></td>";
						}
						if( $data_name['phone_to_show'] )
						{
							echo "<td>".$word[LANG]['1_3_top_details_phone']." ".stripslashes($data_name['phone_to_show'])."</td>";
							echo "<td width=\"10\"></td>";
							echo "<td>|</td>";
							echo "<td width=\"10\"></td>";
						}
						if( $data_name['fax'] )
						{
							echo "<td>".$word[LANG]['1_3_top_details_fax']." ".stripslashes($data_name['fax'])."</td>";
							echo "<td width=\"10\"></td>";
							echo "<td>|</td>";
							echo "<td width=\"10\"></td>";
						}
						if( $data_name['email'] )
							echo "<td>".$word[LANG]['1_3_top_details_email']." ".stripslashes($data_name['email'])."</td>";
					
			echo "</tr>";
	echo "</table>";
}


?>