<?php
function version_1_hp()
{
	
	//products - L ,articles(OR FREE PAGES) , news - R, galery , video, 
	global $data_colors,$data_words,$settings, $word, $data_extra_settings;
	
	$sql = "select * from user_hp_conf where unk = '".UNK."'";
	$res = mysql_db_query(DB,$sql);
	$data = mysql_fetch_array($res);
	
	$sql = "select have_hp_banners,hp_type,hp_text from users where unk = '".UNK."'";
	$res_have_hp_banners = mysql_db_query(DB,$sql);
	$data_have_hp_banners = mysql_fetch_array($res_have_hp_banners);
	
	
	$style_kol_hpHeadline = "";
	$style_kol_Color = $data_colors['color_link'];
	

	echo "<div id='article_list_page'>";	
		
		if( $data_have_hp_banners['hp_type'] == "0" )
		{
		$abpath_ban1 = SERVER_PATH."/tamplate/".stripslashes($data['adv_banner_1']);
		
		if( $data_have_hp_banners['have_hp_banners'] == "1" && file_exists($abpath_ban1) && !is_dir($abpath_ban1) )
		{
			$style_kol_border = "";
				echo "<div class='hp-banner'>";
			
									$temp_test = explode( "." , $data['adv_banner_1'] );
						
									if( $temp_test[1] == "swf" )
									{
								
										echo "
																		<!--url's used in the movie-->
																		<!--text used in the movie-->
																		<object classid=\"clsid:d27cdb6e-ae6d-11cf-96b8-444553540000\" codebase=\"http://download.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=7,0,0,0\" width='".stripslashes($data['adv_banner_1_width'])."' height='".stripslashes($data['adv_banner_1_height'])."' id=\"Untitled-1\" align=\"middle\">
																		<param name=\"allowScriptAccess\" value=\"sameDomain\" />
																		<param name=\"movie\" value=\"/tamplate/".stripslashes($data['adv_banner_1'])."\"/>
																		<param name=\"quality\" value=\"high\" />
																		<embed src=\"/tamplate/".stripslashes($data['adv_banner_1'])."\" quality=\"high\" name=\"Untitled-1\" align=\"middle\" width='".stripslashes($data['adv_banner_1_width'])."' height='".stripslashes($data['adv_banner_1_height'])."' allowScriptAccess=\"sameDomain\" type=\"application/x-shockwave-flash\" pluginspage=\"http://www.macromedia.com/go/getflashplayer\" />
																		</object>";	
									}
									else
									{
										echo "<img style='width:100%;' src=\"/tamplate/".stripslashes($data['adv_banner_1'])."\" border='0'>";
									}
			echo "</div>";
		}

						
							$temp = explode("-" , $data['right_place'] );
							
							
									if($data_colors['home_portal_free_pages'] == '1' && !isset($_GET['most_popular'])){
										version_1_hp_free_pages($data);
									}
									else{
										version_1_hp_articles($data);
										echo "<div class='half-hp-row'>";
										echo "<div class='half-hp-col'>";
										version_1_hp_video($data);
										echo "</div>";
										echo "<div class='half-hp-col'>";
										version_1_hp_galery($data);
										echo "</div>";
										echo "</div>";
									}
								
								
								

								
							
						
						if( $data_extra_settings['haveFacebookHpActive'] == "1" && $data_extra_settings['facebookHpContent'] != "" )
						{
							
									echo stripslashes($data_extra_settings['facebookHpContent']);
						
						}
						

						$temp = explode("-" , $data['left_place'] );
						

						
			
		}
		elseif( $data_have_hp_banners['hp_type'] == "1" )
		{

				echo "<div>";
						$content = string_rplace_func($data_have_hp_banners['hp_text']);
						echo stripslashes($content);
				echo "</div>";
			
		}
		
	echo "</div>";
			echo "<div class='hp-text'>";
			get_text_area("text");			
	echo "</div>";
	if($data_colors['home_portal_free_pages'] != '1'){
		echo "<div class='hp-jobs'>";
		global $temp_word_wanted;
		echo "<h4 class='well' >".$temp_word_wanted."</h4>";
			echo jobs(4);
		echo "</div>";
	}
}

function version_1_hp_articles($data){
		
	global $data_colors,$data_words,$settings, $word, $data_extra_settings;
	$counter_row = 0; 
	$temp_word_articels = ( $data_words['id'] == "" ) ? $word[LANG]['1_2_chapter_name_articels'] : stripslashes($data_words['word_articels']);

	$cat_sql = "select id,name from user_articels_cat where unk = '".UNK."' and active = '0' and deleted = '0' order by hp_order";

	$cat_res =  mysql_db_query(DB,$cat_sql);
	while( $cat_data = mysql_fetch_array($cat_res)){
		if($counter_row>11){
			continue;
		}
		$sql_arti = "select id,headline,summary,img from user_articels where unk = '".UNK."' and cat = ".$cat_data['id']." and status = '0' and deleted = '0' order by id desc limit 2";
		$res_arti = mysql_db_query(DB,$sql_arti);
		if(mysql_num_rows ($res_arti) > 0){
			?>
			<h4 class='well' ><?php echo $cat_data['name']; ?></h4>
			<?php while( $data_artli = mysql_fetch_array($res_arti)): 	if($counter_row>11){continue;} ?>
				<?php
					$headline = htmlspecialchars(stripslashes($data_artli['headline']));
					$href = "index.php?m=ar&artd=".$data_artli['id'].$Cat;
					
					$abpath_temp = SERVER_PATH."/articels/".$data_artli['img'];
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
							<a href='<?php echo $href; ?>' title='<?php echo $headline; ?>'><img src='articels/<?php echo $data_artli['img']; ?>' border='0' hspace='10' width='<?php echo $imageWidth; ?>' vspace='0' align='<?php echo $settings['align']; ?>' alt='<?php echo $headline; ?>'></a>
				
						<?php endif; ?>

							<a href='<?php echo $href; ?>' class='maintext' title='<?php echo $headline; ?>' style='text-decoration: none;'><?php echo nl2br(htmlspecialchars(stripslashes($data_artli['summary']))); ?></a>
						</div>
					</div>
						
					<div class="article_link"><a href='<?php echo $href; ?>' class=maintext title='<?php echo $headline; ?>'><?php echo $word[LANG]['1_1_hp_read_art']; ?></a></div>
								
					<div style="clear:both;"></div>		
						
				</div>	
				<?php $counter_row++; ?>
			<?php endwhile; ?>
			<?php		
		}
	}

}

function version_1_hp_free_pages($data){
	global $data_colors,$data_words,$settings, $word, $data_extra_settings;
	$temp_word_articels = ( $data_words['id'] == "" ) ? $word[LANG]['1_2_chapter_name_articels'] : stripslashes($data_words['word_articels']);
	
	$sql_pages = "select id, name, summary from content_pages where unk = '".UNK."' and type = id and deleted = '0' and hide_page = '0' ORDER BY place desc, id desc LIMIT 12";
	$res_pages = mysql_db_query(DB,$sql_pages);

		?><?php $counter_row = 0; ?>
			
			<?php /* <h4 class='well' ><?php echo $temp_word_articels; ?></h4> */ ?>
		<?php while( $data_page = mysql_fetch_array($res_pages) ):  ?>
			
		
			<?php
				$img_sql = "SELECT videoPic as img FROM estimate_miniSite_defualt_block WHERE type = ".$data_page['id'];
				$img_res = mysql_db_query(DB,$img_sql);
				$img_data = mysql_fetch_array($img_res);
				$headline = htmlspecialchars(stripslashes($data_page['name']));
				$href = "http://".$_SERVER['HTTP_HOST']."/".str_replace(" ","-",$data_page['name']);
				
				$abpath_temp = SERVER_PATH."/new_images/".$img_data['img'];
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
						<a href='<?php echo $href; ?>' title='<?php echo $headline; ?>'><img src='new_images/<?php echo $img_data['img']; ?>' border='0' hspace='10' width='<?php echo $imageWidth; ?>' vspace='0' align='<?php echo $settings['align']; ?>' alt='<?php echo $headline; ?>'></a>
			
					<?php endif; ?>
	
						<a href='<?php echo $href; ?>' class='maintext' title='<?php echo $headline; ?>' style='text-decoration: none;'><?php echo nl2br(stripslashes(htmlspecialchars($data_page['summary']))); ?></a>
					</div>
				</div>
					
				<div class="article_link"><a href='<?php echo $href; ?>' class=maintext title='<?php echo $headline; ?>'><?php echo $word[LANG]['1_1_hp_read_art']; ?></a></div>
							
				<div style="clear:both;"></div>		
					
			</div>	
			<?php $counter_row++; ?>
		<?php endwhile; ?>
		<?php
}


function version_1_hp_video($data){
		global $data_colors,$data_words,$settings, $word, $data_extra_settings;
	$sql_vid = "select * from user_video where unk = '".UNK."' and deleted = '0' and active = '0' order by rand() LIMIT 3";
	
	$res_vid = mysql_db_query(DB,$sql_vid);

		?><?php $counter_row = 0; ?>
			<?php $temp_word_video = ( $data_words['id'] == "" ) ? $word[LANG]['1_2_chapter_name_video'] : stripslashes($data_words['word_video']); ?>	
			<h4 class='well' ><?php echo $temp_word_video; ?></h4>		
		<?php while( $data_vid = mysql_fetch_array($res_vid) ):  ?>
			<?php
				$headline = htmlspecialchars(stripslashes($data_vid['name']));
				$href = "index.php?m=s.vi&ud=".$data_vid['id'];
				
				$abpath_temp = SERVER_PATH."/video/".$data_vid['img'];
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
						<a href='<?php echo $href; ?>' title='<?php echo $headline; ?>'><img src='video/<?php echo $data_vid['img']; ?>' border='0' hspace='10' width='<?php echo $imageWidth; ?>' vspace='0' align='<?php echo $settings['align']; ?>' alt='<?php echo $headline; ?>'></a>
			
					<?php endif; ?>
					
						<a href='<?php echo $href; ?>' class='maintext' title='<?php echo $headline; ?>' style='text-decoration: none;'><?php echo nl2br(stripslashes(htmlspecialchars($data_vid['summary']))); ?></a>
					</div>
				</div>
					
				<div class="article_link"><a href='<?php echo $href; ?>' class=maintext title='<?php echo $headline; ?>'><?php echo $word[LANG]['1_1_hp_read_art']; ?></a></div>
							
				<div style="clear:both;"></div>		
					
			</div>	
			<?php $counter_row++; ?>
		<?php endwhile; ?>
		<?php
}

function version_1_hp_galery($data){
	global $data_colors,$data_words,$settings, $word, $data_extra_settings;
	//   G a l l e r y

	$sql_gallery = "select ugi.* from user_gallery_images as ugi , user_gallery_cat as ugc where ugi.unk = '".UNK."' and ugi.deleted = '0' and ugc.active = 0 and ugc.deleted = 0 and ugc.id = ugi.cat  order by rand() limit 4";
	$res_gallery = mysql_db_query(DB,$sql_gallery);
$temp_word_gallery = ( $data_words['id'] == "" ) ? $word[LANG]['1_2_chapter_name_gallery'] : stripslashes($data_words['word_gallery']);
	
		?>
		<h4 class='well' ><?php echo $temp_word_gallery; ?></h4>
		<?php $counter_row = 0; ?>
		<?php while( $data_gallery = mysql_fetch_array($res_gallery) ):  ?>
			<?php
				$headline = "";
				$href = "index.php?m=gallery&cat=".$data_gallery['cat'];
				
				$abpath_temp = SERVER_PATH."/gallery/L".$data_gallery['img']
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
						<a href='<?php echo $href; ?>' title='<?php echo $headline; ?>'><img src='<?php echo HTTP_PATH."/gallery/L".$data_gallery['img']; ?>' border='0' hspace='10' width='<?php echo $imageWidth; ?>' vspace='0' align='<?php echo $settings['align']; ?>' alt='<?php echo $headline; ?>'></a>
			
					<?php endif; ?>
					
						<a href='<?php echo $href; ?>' class='maintext' title='<?php echo $headline; ?>' style='text-decoration: none;'><?php echo nl2br(stripslashes(htmlspecialchars($data_gallery['content']))); ?></a>
					</div>
				</div>
					
				<div class="article_link"><a href='<?php echo $href; ?>' class=maintext title='<?php echo $headline; ?>'><?php echo $word[LANG]['1_1_hp_read_art']; ?></a></div>
							
				<div style="clear:both;"></div>		
					
			</div>	
			<?php $counter_row++; ?>
		<?php endwhile; ?>
		<?php									
								
}

function version_1_hp_products($data){
		global $m, $data_colors,$data_words,$settings, $word, $data_extra_settings;
	if($m != "hp"){
		return;
	}
	$pro_limit = "4";
	/*
	$sql = "select * from user_products_cat where unk = '".UNK."' and deleted = '0' and status = '0' order by rand() limit 1";
	$res_cat = mysql_db_query(DB,$sql);
	$data_cat = mysql_fetch_array($res_cat);
	*/
	
	//$sql = "select up.id, up.img, up.name, up.summary, up.price from user_products as up INNER JOIN user_model_cat_belong as umcb ON umcb.catId='".ifint($data_cat['id'])."' AND umcb.model='products' AND umcb.itemId=up.id WHERE up.deleted = 0 and up.unk = '".UNK."' and up.active = '0' order by rand() LIMIT ".$pro_limit;
	$sql = "select up.id, up.img, up.name, up.summary, up.price from user_products as up WHERE up.deleted = 0 and up.unk = '".UNK."' and up.active = '0' order by rand() LIMIT ".$pro_limit;
	$res = mysql_db_query(DB,$sql);
	$temp_word_products = ( $data_words['id'] == "" ) ? $word[LANG]['1_2_chapter_name_products'] : stripslashes($data_words['word_products']);
	
	$counter = 0;
	?>
	<div id="product_list_page" class="product-list-page">
		<div id="product_list" class="product-list row-fluid">
		<?php if(mysql_num_rows ($res) != 0): ?>
			<h4 class='well' ><?php echo $temp_word_products; ?></h4>
		<?php endif; ?>	
			<?php while( $data = mysql_fetch_array($res) ): ?>
				<?php
					$product_href = "index.php?m=s.pr&ud=".$data['id']."&cat=".$_GET['cat']."&sub=".$_GET['sub'];
					$server_path = SERVER_PATH;
					$http_path = HTTP_PATH;			
					$abpath_temp = $server_path."/products/".$data['img'];
					$product_img = false;
					if( file_exists($abpath_temp) && !is_dir($abpath_temp) )
					{
						$product_img = $http_path."/products/".$data['img'];
						
					}
				?>			
				<div id="slidingProduct<?php echo $data['id']; ?>" class="sliding_product	">
					<div class="product-name">
						<a href="<?php echo $product_href; ?>" title="<?php echo htmlspecialchars(stripslashes($data['name'])); ?>">
							<?php echo htmlspecialchars(stripslashes($data['name'])); ?>
						</a>
					</div>
					<a class="product-list-img"  href="<?php echo $product_href; ?>" title="<?php echo htmlspecialchars(stripslashes($data['name'])); ?>">
						<?php if($product_img): ?>
							<img src='<?php echo $product_img; ?>' alt='' />
						<?php endif; ?>
					</a>
					<div class='produc-summary'>
						<?php echo nl2br(stripslashes(htmlspecialchars($data['summary']))); ?>							
					</div>	
					<div class='produc-price-section'>
						<?php if( $data['price'] ): ?>
							<?php /* echo $word[LANG]['1_1_products_price']; */ ?> 
							<div class='produc-price'>
								<?php echo COIN.$data['price']; ?>
							</div>
							<?php if( $data_name['have_ecom'] == "1" && $data['active_ecom'] == "1" ): ?>
								<div id='addToBasketButton<?php echo $data['id']; ?>' class="add-to-cart-button"><a href='javascript:void(0)' onclick="addToBasket(<?php echo $data['id']; ?>);return false;"><?php echo $word[LANG]['1_1_products_add_to_cart']; ?></a></div>
							<?php endif; ?>
						<?php endif; ?>
					</div>
					<a class="more-info" href="<?php echo $product_href; ?>"  title="<?php echo htmlspecialchars(stripslashes($data['name'])); ?>">
						<b><?php echo $word[LANG]['1_1_products_more_info']; ?></b>
					</a>
				</div>						
			<?php endwhile; ?>
		</div>
	</div>	
			
			


<?php

}

