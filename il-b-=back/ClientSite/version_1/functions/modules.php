<?php
function version_1_scroll_news($height="",$page_type="")
{
	global $data_settings,$data_colors,$word,$data_extra_settings,$m;
	$type = $_GET['t'];
	if($m == "hp" && $type == ""){
		$type = "text";
	}
	$last_leads = array();
	if($type != "text"){
		$data_estimate = get_data_estimate($type);
		
		$qry_cat = ( $data_estimate['subCat'] == "" || $data_estimate['subCat'] == "0" ) ? "ef.cat_f=".$data_estimate['primeryCat'] : "ef.cat_f=".$data_estimate['primeryCat']." AND ef.cat_s=".$data_estimate['subCat'];
		
		$sql = "SELECT ef.note, ef.insert_date, ef.cat_f, ef.cat_s, ef.city, nc.name as newCity
								FROM estimate_form as ef left join newCities as nc on ef.city=nc.id WHERE
									".$qry_cat." AND 
									
									ef.status != '9' AND
									CHAR_LENGTH(ef.note)>10 ORDER BY ef.id DESC LIMIT 6";
		$res = mysql_db_query(DB,$sql);
		while( $lead = mysql_fetch_array($res) ){
			$last_leads[] = $lead;
		}
		
		foreach($last_leads as $key=>$lead){
			$sql = "select cat_name from biz_categories where father = '".$lead['cat_f']."' and id = '".$lead['cat_s']."'";
			$res2 = mysql_db_query(DB,$sql);
			$dataCatS2 = mysql_fetch_array($res2);
			$last_leads[$key]['cat_name'] = $dataCatS2['cat_name'];
		}	
	}
	
	if(count($last_leads) > 0){
		$runews_headline_temp = ( $data_settings['runews_headline'] != "" ) ? $data_settings['runews_headline'] : $word[LANG]['1_3_scroll_news_title'];	
		$bgcolor_headline = ( $page_type == "index" ) ? $data_colors['bg_link'] : $data_colors['conent_bg_color'];
		$bgcolor_text_headline = ( $page_type == "index" ) ? "style='color:#".$style_kol_Color."'" : "";
		$border_color_index = ( $page_type == "index" ) ? "#".$data_colors['border_color']."" : "#000000";	
		$bgcolor_headline_TMP = ( !empty($bgcolor_headline) ) ? "bgcolor='#".$bgcolor_headline."'" : "";
		?>
			<div class='running_news_title'>
				<div class='news_title'>
					<?php echo iconv("UTF-8","windows-1255", "פניות אחרונות"); ?>
				</div>
			</div>
							
			<div class='running_news_content'>
				<div id="marqueecontainer" onMouseover="copyspeed=pausespeed" onMouseout="copyspeed=marqueespeed">
					<div id="vmarquee" style='position: absolute; width:98%;'>
						<?php foreach( $last_leads as $last_lead): ?>	
								<div class='running_news_item'>
									<div class='maintext news_item_title'><b>
										<?php /* echo iconv("UTF-8","windows-1255", "פנייה בנושא"); */ ?>
										
										<?php echo $last_lead['cat_name']; ?>
									</div>
									<div class='maintext news_item_content'>
										<span class="last-lead" style="font-size:14px; line-height:17px; color:black; font-weight:normal;">
													<?php echo nl2br(stripslashes($last_lead['note'])); ?>
										
										<br/>
											<small>
												<b style="color:#888;">
													<?php echo $last_lead['newCity']; ?>
												</b>
												<br/>
												<?php echo show_dateTime_field_estimate($last_lead['insert_date']); ?>
											
											
											</small>
										</span>
										
									</div>
								</div>
						<?php endforeach; ?>
					</div>
				</div>	
				
			</div>
	<?php 
	}
	else{
	
	
		
	$sql = "select * from user_news where deleted = '0' and unk = '".UNK."' ORDER BY id DESC";
	$res = mysql_db_query(DB,$sql);
	$num_rows = mysql_num_rows($res);
	
	$style_kol_hpHeadline = "";
	$style_kol_Color = $data_colors['color_link'];
	?>
	<?php if( $num_rows > 0 ): ?>
		<?php
		$runews_headline_temp = ( $data_settings['runews_headline'] != "" ) ? $data_settings['runews_headline'] : $word[LANG]['1_3_scroll_news_title'];	
		$bgcolor_headline = ( $page_type == "index" ) ? $data_colors['bg_link'] : $data_colors['conent_bg_color'];
		$bgcolor_text_headline = ( $page_type == "index" ) ? "style='color:#".$style_kol_Color."'" : "";
		$border_color_index = ( $page_type == "index" ) ? "#".$data_colors['border_color']."" : "#000000";	
		$bgcolor_headline_TMP = ( !empty($bgcolor_headline) ) ? "bgcolor='#".$bgcolor_headline."'" : "";
		?>
			<div class='running_news_title'>
				<div class='news_title'>
					<?php echo htmlspecialchars(stripslashes($runews_headline_temp)); ?>
				</div>
			</div>
							
			<div class='running_news_content'>
				<div id="marqueecontainer" onMouseover="copyspeed=pausespeed" onMouseout="copyspeed=marqueespeed">
					<div id="vmarquee" style='position: absolute; width:98%;'>
						<?php while( $data_scroll = mysql_fetch_array($res)): ?>	
								<div class='running_news_item'>
									<font class='maintext news_item_title'><b><?php echo htmlspecialchars(stripslashes($data_scroll['headline'])); ?></b><br></font>
									<font class='maintext news_item_content'>
										<?php if($data_scroll['link']): ?>
											<a href='<?php echo htmlspecialchars(stripslashes($data_scroll['link'])); ?>' class='maintext' target='_blank'>
												
										<?php endif; ?>
													<?php echo nl2br(htmlspecialchars(stripslashes($data_scroll['content'])))?>
										<?php if($data_scroll['link']): ?>
												
											</a>
										<?php endif; ?>
									</font>
								</div>
						<?php endwhile; ?>
					</div>
				</div>	
				
			</div>
	<?php endif; ?>
	<?php
	}
}


function version_1_article_cats_menu(){
	global $data_colors,$word,$settings, $data_words;
	
	
	$sql = "select id,name from user_articels_cat where unk = '".UNK."' and active = '0' and deleted = '0'";
	$resCat = mysql_db_query(DB,$sql);
	$numCat = mysql_num_rows($resCat);
	global $browser_is_mobile;
	?>
	<?php if( $numCat > 0 ): ?>
	
		<?php if(!$browser_is_mobile): ?>
			<div class="news_categories_links categories_links">
				<?php while( $dataCat = mysql_fetch_array($resCat) ): ?>
					<?php $boldClass = ( $dataCat['id']	== $_GET['cat'] ) ? "selected_cat" : ""; ?>
					<a href='index.php?m=arLi&cat=<?php echo $dataCat['id']; ?>' class='maintext <?php echo $boldClass; ?>'>
						<?php echo GlobalFunctions::kill_strip($dataCat['name']); ?>
					</a>
				<?php endwhile; ?>
				
				<?php $boldClass = ( $dataCat['id']	== $_GET['cat'] ) ? "selected_cat" : ""; ?>
				<a href='index.php?m=arLi' class='maintext <?php echo $boldClass; ?>'><?php echo $word[LANG]['1_1_articels_all_categories']; ?></a>
			</div>
		<?php else: ?>
			<div class="news_categories categories_select module_select">
				<form action="index.php" name="select_cat_form" method="get">
					<input type='hidden' name='m' value='arLi' />
					
					<select name='cat' class='input_style' onchange="select_cat_form.submit()">
						
						<?php while( $dataCat = mysql_fetch_array($resCat) ): ?>
							<?php $selectedClass = ( $dataCat['id']	== $_GET['cat'] ) ? "selected" : ""; ?>
							<option value='<?php echo $dataCat['id']; ?>' <?php echo $selectedClass; ?> class="<?php echo $selectedClass; ?>"><?php echo GlobalFunctions::kill_strip($dataCat['name']); ?></option>
						<?php endwhile; ?>
				<?php $boldClass = ( $dataCat['id']	== $_GET['cat'] ) ? "selected" : ""; ?>
				<option value='index.php?m=arLi' class='maintext <?php echo $boldClass; ?>' <?php echo $boldClass; ?>><?php echo $word[LANG]['1_1_articels_all_categories']; ?></option>
						
					</select>
					
				</form>
			</div>
		<?php endif; ?>
	<?php endif; ?>
	
	<?php
}

function version_1_articles_menu($artid,$art_cat){
	global $data_colors,$word,$settings, $data_words;
	$sql_all = "select id,headline from user_articels where unk = '".UNK."' and id != '".ifint($artid)."' ".$art_cat." and status = '0' and deleted = '0' order by place";
	$res_all = mysql_db_query(DB,$sql_all);
	$data_num_all = mysql_num_rows($res_all);
	?>
	<?php if( $data_num_all > 0 ): ?>
		<div class="article_select module_select">
			<form action="index.php" name="select_art_form" method="get">
				<input type='hidden' name='m' value='ar' />					
				<select name='artd' class='input_style'  onchange="select_art_form.submit()">
					<option value=''><?php echo $word[LANG]['1_1_articels_choose_art']; ?></option>
					<?php while( $data_all = mysql_fetch_array($res_all) ): ?>
						<option value='<?php echo $data_all['id']; ?>'><?php echo htmlspecialchars(stripslashes($data_all['headline'])); ?></option>
					<?php endwhile; ?>
				</select>
				
			</form>
		</div>
	<?php endif; ?>	
<?php	
}

function version_1_articels()
{
	global $data_colors,$word,$settings,$data_extra_settings;
	$artd = ( $_GET['artd'] != "" ) ? "and id = '".ifint($_GET['artd'])."'" : "";
	$art_id = ( $_GET['art_id'] != "" && $artd == "" ) ? "and id = '".ifint($_GET['art_id'])."'" : "";
	$art_cat = ( $_GET['cat'] != "" ) ? "and cat = '".ifint($_GET['cat'])."'" : "";
	
	$sql = "select * from user_articels where unk = '".UNK."' and status = '0' ".$artd." ".$art_id." ".$art_cat." and deleted = '0' order by id desc limit 1";
	$res = mysql_db_query(DB,$sql);
	$data = mysql_fetch_array($res);
	
	
	
	

	?>
	<div class = "article-page-news-menus">
		<?php version_1_articles_menu($data['id'],$art_cat); version_1_article_cats_menu(); ?>
	</div>
	<div id="article_page">

		

		<div class="article_title">
			<h1>
				<?php echo htmlspecialchars(stripslashes($data['headline'])); ?>
			</h1>
		</div>
		<?php $abpath_temp = SERVER_PATH."/articels/".$data['img']; ?>
			
		<?php if( file_exists($abpath_temp) && !is_dir($abpath_temp) ): ?>		
			<div class="article-image article-image-before">
				<img src='articels/<?php echo $data['img']; ?>' border='0'  />
			</div>	
		<?php endif; ?>			
		<div class="article_summary">
			<b><?php echo nl2br(stripslashes($data['summary'])); ?></b>
		</div>
		<?php if( file_exists($abpath_temp) && !is_dir($abpath_temp) ): ?>		
			<div class="article_image article-image-after">
				<img src='articels/<?php echo $data['img']; ?>' border='0'  />
			</div>	
		<?php endif; ?>	
		<?php $content = string_rplace_func($data['content']); ?>	
		<?php if( !empty($content) ): ?>		
			<div class="article_content">		
				<?php echo stripslashes($content); ?>
			</div>		
		
		
			<div class='maintext_small article_details'>
				<?php echo $word[LANG]['1_1_articels_first_adv'].GlobalFunctions::show_dateTime_field($data['date_in']); ?><br>
				<?php if( $data['date_in'] != $data['date_update'] ): ?>
					<?php echo $word[LANG]['1_1_articels_last_update'].GlobalFunctions::show_dateTime_field($data['date_update']); ?>
				<?php endif; ?>
			</div>
		<?php endif; ?>
		
		<?php if( $data_extra_settings['haveFacebookComments'] == "1" ): ?>
			<div class='article_fb_comment'>
				<?php echo FacebookComments("articels"); ?>
			</div>
		<?php endif; ?>
	</div>
<?php
}


function version_1_articelsList()
{

	global $data_colors,$word,$settings, $data_words;
	
	$limitCount = ( $_GET['PL'] == "" ) ? "0" : ifint($_GET['PL']);
	$art_cat = ( $_GET['cat'] != "" ) ? "and cat = '".ifint($_GET['cat'])."'" : "";
	$Cat = ( $_GET['cat'] != "" ) ? "&cat=".ifint($_GET['cat']) : "";
	
	
	$sql = "select id,headline,img,summary from user_articels where unk = '".UNK."' ".$art_cat." and status = '0' and deleted = '0' order by id DESC LIMIT ".$limitCount.",10";
	$res = mysql_db_query(DB,$sql);
	
	$sqlAll = "select id from user_articels where unk = '".UNK."' ".$art_cat." and status = '0' and deleted = '0'";
	$resAll = mysql_db_query(DB,$sqlAll);
	$num_all = mysql_num_rows($resAll);
	

	version_1_article_cats_menu();
	?>
	<div  id="article_list_page">
		

		
		<?php $counter_row = 0; ?>
		<?php while( $data = mysql_fetch_array($res) ): ?>
		<?php
			$headline = htmlspecialchars(stripslashes($data['headline']));
			$href = "index.php?m=ar&artd=".$data['id'].$Cat;
			
			$abpath_temp = SERVER_PATH."/articels/".$data['img'];
		?>

			<?php
			if( $counter_row == 0 )
				$borders = "border-bottom: 0px solid #".$data_colors['border_color'].";border-top: 1px solid #".$data_colors['border_color'].";";
			else
				$borders = "border-bottom: 0px solid #".$data_colors['border_color'].";border-top: 0px solid #".$data_colors['border_color'].";";
			?>
				
			<div class='article'>	
				<div class='art-title' bgcolor="#<?php echo $data_colors['bg_link']; ?>">
					<div class='art-title'><a href='<?php echo $href; ?>' title='<?php echo $headline; ?>' class='maintext' style="color:#<?php echo $data_colors['color_link']; ?>">
					<h2 style="color:#<?php echo $data_colors['bg_link']; ?>"><?php echo $headline; ?></h2></a></div>
				</div>				
						
				<div class='art-body'>
					<div class='art-image'>
					<?php if( file_exists($abpath_temp) && !is_dir($abpath_temp) ): ?>
						<?php
						$im_size = GetImageSize ($abpath_temp); 
						$imageWidth = $im_size[0]; 
						$imageheight = $im_size[1]; 
						if( $imageWidth > 138 )
							$imageWidth = "138";
						?>
						<a href='<?php echo $href; ?>' title='<?php echo $headline; ?>'><img src='articels/<?php echo $data['img']; ?>' border='0' hspace='10' width='<?php echo $imageWidth; ?>' vspace='0' align='<?php echo $settings['align']; ?>' alt='<?php echo $headline; ?>'></a>
			
					<?php endif; ?>
						<a href='<?php echo $href; ?>' class='maintext' title='<?php echo $headline; ?>' style='text-decoration: none;'><?php echo nl2br(htmlspecialchars(stripslashes($data['summary']))); ?></a>
					</div>
				</div>
					
				<div class="article_link"><a href='<?php echo $href; ?>' class=maintext title='<?php echo $headline; ?>'><?php echo $word[LANG]['1_1_hp_read_art']; ?></a></div>
							
				<div style="clear:both;"></div>		
					
			</div>	
			<?php $counter_row++; ?>
		<?php endwhile; ?>
			<?php
				$temp_word_articels = ( $data_words['id'] == "" ) ? $word[LANG]['1_2_chapter_name_articels'] : stripslashes($data_words['word_articels']);
			?>
			<div class="paging">
					<table align=center border=0 cellspacing="0" width=100% cellpadding="3" class="maintext">
						<tr>
							<td align=center><?php echo $word[LANG]['1_1_articels_list_sum']; ?> <?php echo $num_all; ?> <?php echo $temp_word_articels; ?></td>
						</tr>
						
						<?php if( $num_all > 10 ): ?>
						
							<tr>
								<td align=center>
								
									<?php $z = 0; ?>
									<?php for($i=0 ; $i < $num_all ; $i++): ?>
									
										<?php $pz = $z+1; ?>
										
										<?php if($i % 10 == 0): ?>
										
												<?php if( $i == $_GET['PL'] ): ?>
													<strong style="color:#000000"><?php echo $pz; ?></strong>&nbsp;&nbsp;
												<?php else: ?>
													<a href='index.php?m=arLi&PL=<?php echo $i.$Cat; ?>' class='maintext'><?php echo $pz; ?></a>&nbsp;&nbsp;
												
												<?php endif; ?>
												
												<?php $z = $z + 1; ?>
										<?php endif; ?>
									<?php endfor; ?>
								</td>
							</tr>
						<?php endif; ?>
					</table>
				
			</div>
		
	</div>
<?php 
}
?>