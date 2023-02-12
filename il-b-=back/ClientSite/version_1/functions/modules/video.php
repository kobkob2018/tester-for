<?php

/****************************************************************************************************/
/****************************************************************************************************/
/****************************************************************************************************/

function version_1_video()
{
	global $data_extra_settings, $data_colors,$word,$settings;
	if( $data_colors['kobia_type'] == "1" )
	{
		getKobiaDesigner( "video" );
			return "";
	}
	
	$limitcount = ( $_GET['PL'] == "" ) ? $_POST['PL'] : $_GET['PL'];
	$limitcount = ( $limitcount == "" ) ? "0" : ifint($limitcount);
	
	$temp_cat = ( $_GET['cat'] ) ? " and cat='".ifint($_GET['cat'])."'" : "";
	$sql = "select * from user_video where unk = '".UNK."' and deleted = '0' ".$temp_cat." and active = '0' order by id DESC,place  LIMIT ".$limitcount.",21";
	$res = mysql_db_query(DB,$sql);
	
	$sql2 = "select COUNT(id) as num_rows from user_video where unk = '".UNK."' and deleted = '0' ".$temp_cat." and active = '0'";
	$res2 = mysql_db_query(DB,$sql2);
	$data2 = mysql_fetch_array($res2);
	
	
	?>
	
		<?php if( $data_name['have_ProGal_cats'] == 0 ): ?>
			<div class = "article-page-news-menus">
				<?php echo version_1_get_video_cat($_GET['cat']); ?>
			</div>
	
		<?php endif; ?>
		
	<div  id="article_list_page">		
		
		<?php $counter = 0; ?>
		<?php while( $data = mysql_fetch_array($res) ): ?>
					<div class='article'>
			<?php if( $counter%3 == 0 ): ?>
			
			<?php endif; ?>
				<?php
				$abpath_temp = SERVER_PATH."/video/".$data['img'];
				if( file_exists($abpath_temp) && !is_dir($abpath_temp) )
				{
					$im_size = GetImageSize ($abpath_temp); 
					$imageWidth = $im_size[0]; 
					$imageheight = $im_size[1]; 
					$img_src = "<a href=\"index.php?m=s.vi&ud=".$data['id']."&cat=".$_GET['cat']."\" class=\"maintext\" title=\"".htmlspecialchars(stripslashes($data['name']))."\"><img src='video/{$data['img']}' border='0' height=\"{$imageheight}\" width=\"".$imageWidth."\"  border='0' hspace='10' vspace='0' align='".$settings['align']."'></a>";
				}
				else
				{
					$img_src = "";
					$imageWidth = "76%";
				}
				?>



				<div class='art-title' bgcolor="#<?php echo $data_colors['bg_link']; ?>">
					<div class='art-title'>					
						<a href="index.php?m=s.vi&ud=<?php echo $data['id']; ?>&cat=<?php echo $_GET['cat']; ?>" class="maintext" title="<?php echo htmlspecialchars(stripslashes($data['name'])); ?>">
							<h2>
								<?php echo htmlspecialchars(stripslashes($data['name'])); ?>
							</h2>
						</a>
						</div>
					</div>		
					<div class='art-body'>
						<div class='art-image'>					
							<?php echo $img_src; ?>
							<a href='index.php?m=s.vi&ud=<?php echo $data['id']; ?>&cat=<?php echo $_GET['cat']; ?>' class='maintext' title='<?php echo htmlspecialchars(stripslashes($data['name'])); ?>' style='text-decoration: none;'>
								<?php echo nl2br(htmlspecialchars(stripslashes($data['summary']))); ?>
							</a>							
						</div>
			
					</div>
					
				<div class="article_link"><a href='index.php?m=s.vi&ud=<?php echo $data['id']; ?>&cat=<?php echo $_GET['cat']; ?>' class=maintext title='<?php echo htmlspecialchars(stripslashes($data['name'])); ?>'><?php echo $word[LANG]['1_1_video_more_info']; ?></a></div>
							
				<div style="clear:both;"></div>						
				
			<?php $counter++; ?>
			
			<?php if( $counter%3 == 0 ): ?>
			
			
			<?php endif; ?>
			</div>
		<?php endwhile; ?>
</div>
<?php
		$params['limitInPage'] = "21";
		$params['numRows'] = $data2['num_rows'];
		$params['limitcount'] = $limitcount;
		$params['m'] = $_GET['m'];
		$params['cat'] = $_GET['cat'];
		$params['sub'] = $_GET['sub'];
		
		getLimitPagention( $params );
				
			
}


function version_1_s_video()
{
	global $data_extra_settings,$data_colors, $word, $temp_word_video;
	$sql = "select * from user_video where unk = '".UNK."' and deleted = '0' and active = '0' and id = '".ifint($_GET['ud'])."' limit 1";
	$res = mysql_db_query(DB,$sql);
	$data = mysql_fetch_array($res);
	
	$content = string_rplace_func($data['content']);
		
	echo "<table border=\"0\" cellspacing=\"0\" cellpadding=\"0\" class=\"maintext\" width=\"100%\">";
		
		if( $data_name['have_ProGal_cats'] == 0 )
		{
			echo "<tr>";
				echo "<td width=\"100%\" colspan=10>".version_1_get_video_cat()."</td>";
			echo "</tr>";
		}
		
		echo "<tr>";
			echo "<td><h1 style=\"font-size:16px\">".htmlspecialchars(stripslashes($data['name']))."</h4></td>";
		echo "</tr>";
		
		echo "<tr>";
			echo "<td><a href='index.php?m=vi'>".$word[LANG]['1_1_general_back_to'].$temp_word_video."</a></td>";
		echo "</tr>";
		
		echo "<tr><td height=\"5\"></td></tr>";
		
		echo "<tr>";
			echo "<td valign=\"top\">";
				if( $data['video_flash'] )
					echo "<div class='videoWrapper'><p align=center>".stripslashes($data['video_flash'])."</p></div>";
				elseif( $data['video_url'] )
					echo "<p align=center>
						<div class='videoWrapper'>
							<embed src=\"{$data['video_url']}\" loop=\"0\" autostart=\"true\"></embad>
						</div>
					
					</p>";
				
				
				echo "<b>".nl2br(htmlspecialchars(stripslashes($data['summary'])))."</b><br><br><br>
				".nl2br(htmlspecialchars(stripslashes($content)))."<br><br>";
				
				if( $data['url_link_href'] != "" && $data['url_link_name'] != "" )
					echo "<a href='".$data['url_link_href'] ."' class='maintext_link'>".$data['url_link_name']."</a>";
				
			echo "</td>";
		echo "</tr>";
		
	echo "</table>";
}


function version_1_get_video_cat($cat="")
{
	$sql = "select * from user_video_cat where unk = '".UNK."' and deleted = '0' and active = '0'";
	$res = mysql_db_query(DB,$sql);
	global $browser_is_mobile;
	if($cat == "" && isset($_GET['cat'])){
		$cat = $_GET['cat'];
	}
	?>
	
	<?php if(!$browser_is_mobile): ?>
		<div class="news_categories_links categories_links">
			<?php while( $data = mysql_fetch_array($res) ): ?>
				<?php $boldClass = ( $data['id']	== $cat ) ? "selected_cat" : ""; ?>
					<a href='index.php?m=vi&cat=<?php echo $data['id']; ?>' class='maintext <?php echo $boldClass; ?>'>
						<?php echo GlobalFunctions::kill_strip($data['name']); ?>
					</a>
			<?php endwhile; ?>
		</div>
	<?php else: ?>
			<div class="news_categories categories_select module_select">
				<form action="index.php" name="select_cat_form" method="get">
					<input type='hidden' name='m' value='vi' />
					
					<select name='cat' class='input_style' onchange="select_cat_form.submit()">
						
						<?php while( $dataCat = mysql_fetch_array($res) ): ?>
							<?php $selectedClass = ( $dataCat['id']	== $cat ) ? "selected" : ""; ?>
							<option value='<?php echo $dataCat['id']; ?>' <?php echo $selectedClass; ?> class="<?php echo $selectedClass; ?>"><?php echo GlobalFunctions::kill_strip($dataCat['name']); ?></option>
						<?php endwhile; ?>
				<?php $boldClass = ( $dataCat['id']	== $_GET['cat'] ) ? "selected" : ""; ?>
				<option value='' class='maintext <?php echo $boldClass; ?>' <?php echo $boldClass; ?>>הצג הכל</option>
						
					</select>
					
				</form>
			</div>		
	<?php endif; ?>
	<?php
}
