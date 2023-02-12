<?php
function version_1_products()
{
	global $data_colors,$data_name,$word,$settings,$data_extra_settings;

	
	if( $_GET['sub'] == "" )	{
		$sql = "SELECT id FROM user_products_subject WHERE unk = '".UNK."' and deleted = '0' and active = '0' ORDER BY rand()";
		$res_subject = mysql_db_query(DB,$sql);
		$subject_cat = mysql_fetch_array($res_subject);
		$_GET['sub'] = $subject_cat['id'];
	}

	if(!isset($_GET['cat'])){		
		$sql = "select * from user_products_cat where unk = '".UNK."' and deleted = '0' and status = '0'  AND subject_id = ".ifint($_GET['sub'])." order by id limit 1";
		$res_cat = mysql_db_query(DB,$sql);
		$data_cat = mysql_fetch_array($res_cat);
		$_GET['cat'] = $data_cat['id'];
	}
	$temp_cat = $_GET['cat'];
	
	$limitcount = ( $_GET['PL'] == "" ) ? $_POST['PL'] : $_GET['PL'];
	$limitcount = ( $limitcount == "" ) ? "0" : ifint($limitcount);
	

	

	


		
	$per_page = '21';	
	$limitcount = ( $_GET['PL'] == "" ) ? $_POST['PL'] : $_GET['PL'];
	$limitcount = ( $limitcount == "" ) ? "0" : ifint($limitcount);
	$sql = "select up.* from user_products as up INNER JOIN user_model_cat_belong as umcb ON umcb.catId='".ifint($temp_cat)."' AND umcb.model='products' AND umcb.itemId=up.id WHERE up.deleted = 0 and up.unk = '".UNK."' and up.active = '0' order by up.place LIMIT ".$limitcount.",".$per_page;
	$res = mysql_db_query(DB,$sql);
	$counter = 0;
	?>
	<div id="product_list_page" class="product-list-page">
		<?php if( $data_name['have_ProGal_cats'] == 0 ): ?>
			<div class="products-page-menus">	
				<?php echo version_1_get_products_cat($temp_cat); ?>
			</div>
		<?php endif; ?>
		<div id="product_list" class="product-list row-fluid">
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

	$sql2 = "select COUNT(up.id) as num_rows from user_products as up INNER JOIN user_model_cat_belong as umcb ON umcb.catId='".ifint($temp_cat)."' AND umcb.model='products' AND umcb.itemId=up.id WHERE up.deleted = 0 and up.unk = '".UNK."' and up.active = '0'";
	$res2 = mysql_db_query(DB,$sql2);
	$data2 = mysql_fetch_array($res2);
	$numRows = $data2['num_rows'];
	$start = $limitcount;
	$m = $_GET['m'];
	$NewCat = ( $_GET['cat'] != "" ) ? "&cat=".$_GET['cat'] : "";
	$NewSub = ( $_GET['sub'] != "" ) ? "&sub=".$_GET['sub'] : "";
	$showeachside = 5; //  Number of items to show either side of selected page

	if(empty($start))$start=0;  // Current start position

	$max_pages = ceil($numRows / $per_page); // Number of pages
	$cur = ceil($start / $per_page)+1; // Current page number
  ?>
  <?php if( $numRows > $per_page ): ?>
	
	<table width="100%" border="0" align="center" cellpadding="0" cellspacing="0" class="maintext">
		<tr>
			<td width="99" align="center" valign="middle">

				<?php if(($start-$per_page) >= 0): ?>		
					<?php $next = $start-$per_page; $temp = ($next>0?("&amp;PL=").$next:""); ?>
					<a href='index.php?m=<?php echo $m.$NewCat.$NewSub.$temp; ?>' class='maintext'>
						הקודם
					</a>
				<?php endif; ?>
	
			</td>
			<td width="201" align="center" valign="middle">
				דף מספר <?php echo $cur; ?> מתוך <?php echo $max_pages; ?>
				<br>
				(סה"כ <?php echo $numRows; ?>)
			</td>
			<td width="100" align="center" valign="middle">
				
				<?php if($start+$per_page<$numRows): ?>
					<?php $temp = "&amp; PL=".max(0,$start+$per_page); ?>
					<a href='index.php?m=<?php echo $m.$NewCat.$NewSub.$temp; ?>' class='maintext'>
						הבא
					</a>
				<?php endif; ?>
			</td>
		</tr>
		<tr><td colspan="3" align="center" valign="middle">&nbsp;</td></tr>
		<tr>
			<td colspan="3" align="center" valign="middle">
			
				<?php $eitherside = ($showeachside * $per_page); ?>
					<?php if($start+1 > $eitherside): ?>
						&nbsp;....&nbsp;
					<?php endif; ?>
					<?php $pg=1; ?>
					<?php for($y=0;$y<$numRows;$y+=$per_page): ?>
					
						<?php if(($y > ($start - $eitherside)) && ($y < ($start + $eitherside))): ?>
					 
							<?php $temp = ($y>0?("&amp;PL=").$y:""); ?>
							<?php if( $y == $start): ?>
								<b class='page-link'>
									<?php echo $pg ?>
								</b>
							<?php else: ?>
								<a class='maintext page-link' href='index.php?m=<?php echo $m.$NewCat.$NewSub.$temp; ?>'>
									<u>
										<?php echo $pg; ?>
									</u>
								</a>
							<?php endif; ?>
						<?php endif; ?>
						<?php $pg++; ?>
					<?php endfor; ?>
					<?php if(($start+$eitherside)<$numRows): ?>
						&nbsp;....&nbsp;
					<?php endif; ?>
			</td>
		</tr>
	</table>
	<?php endif; ?>

<?
}


function version_1_get_products_cat($cat="")
{
	global $word;
	
	$subject_id = ( $_GET['sub'] == "" ) ? "AND subject_id = ''" : "AND subject_id = ".ifint($_GET['sub']);
	$sql = "select * from user_products_cat where unk = '".UNK."' and deleted = '0' and status = '0' ".$subject_id."";
	$res = mysql_db_query(DB,$sql);
	
	$sql = "select * from user_products_subject where unk = '".UNK."' and deleted = '0' and active = '0'";
	$res_all = mysql_db_query(DB,$sql);
	$data_num_all = mysql_num_rows( $res_all );
	

	?>	
	<?php if( $data_num_all > 0 ): ?>
		<div class="product_subjects categories_select module_select">
			<form action="index.php" name="select_subject_form" method="get">
				<input type='hidden' name='m' value='pr' />
				<select name='sub' class='input_style' onchange="select_subject_form.submit()">
					<option value=''><?php echo $word[LANG]['1_1_gallery_choose_subject']; ?></option>
					<?php while( $data_all = mysql_fetch_array($res_all) ): ?>
					
						<?php $selected = ( $data_all['id'] == $_GET['sub'] ) ? "selected" : ""; ?>
						<option value='<?php echo $data_all['id']; ?>' <?php echo $selected; ?>>
							<?php echo htmlspecialchars(stripslashes($data_all['name'])); ?>
						</option>";
					<?php endwhile; ?>
				</select>
			</form>	
		</div>
	<?php endif; ?>
	<div class="product_categories_links categories_links">
		<?php while( $data = mysql_fetch_array($res) ): ?>
			<?php $cat_href = "index.php?m=products&cat=".$data['id']."&sub=".$_GET['sub']; ?>
			<?php $selectedClass = ( $data['id'] == $cat ) ? "selected_cat" : ""; ?>
			<a href='<?php echo $cat_href; ?>' class='maintext <?php echo $selectedClass; ?>'>
				<?php echo stripslashes($data['name']); ?>
			</a>
		<?php endwhile; ?>
		<div style="clear:both;"></div>
	</div>
	<?php 
}


function version_1_s_products()
{
	global $data_colors,$data_name,$word,$settings,$data_extra_settings;

	if( $data_name['site_type'] == "10" )
	{
		$sql = "select p.* from user_extra_settings as uxs, user_products as p
		where p.deleted = '0' and p.active = '0' and p.id = '".ifint($_GET['ud'])."' and uxs.unk = p.unk and ( uxs.nisha_sites LIKE '%\"".$data_name['id']."\"%' OR uxs.unk = '".UNK."' ) limit 1";
	}
	else
		$sql = "select * from user_products where unk = '".UNK."' and deleted = '0' and active = '0' and id = '".ifint($_GET['ud'])."' limit 1";
	
	$res = mysql_db_query(DB,$sql);
	$data = mysql_fetch_array($res);
	
	if( $data_name['site_type'] == "10" )
	{
		if( $data['url_link'] != "" )
			echo "<script>window.location.href='".$data['url_link']."';</script>";
	}
	
	$content = string_rplace_func($data['content']);
	
	
	
	
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
	
	$abpath_temp = $server_path."/products/".$data['img2'];
	$abpath_tempt = $server_path."/products/".$data['img'];
	$abpath_tempEX = $server_path."/products/".$data['img3'];
	?>
	<div class="product-page">
 		<?php if( file_exists($abpath_tempEX) && !is_dir($abpath_tempEX) ): ?>
			<div id="s.prEXimgDiv" style="display:none">
				<img src='<?php echo $http_path; ?>/products/<?php echo $data['img3']; ?>' />
			</div>
		<?php endif; ?>
		
		<?php if( $data_name['have_ProGal_cats'] == 0 ): ?>
			<div class="products-page-menus">
				<?php version_1_get_products_cat($data['cat']);	?>
			</div>
		<?php endif; ?>	

							

	

		<div class="product_container">
			<div class="product_name" id="slidingProduct<?php echo $data['id']; ?>">
				<h2>
					<?php echo htmlspecialchars(stripslashes($data['name'])); ?>
				</h2>
			</div>
			<div class="forsmallscreen">
				<div class="product_summary" >
					<b>
						<?php echo nl2br(htmlspecialchars(stripslashes($data['summary']))); ?>
					</b>
				</div>	
			</div>			
			<div class="product-left-section">
				<div id="product_images">
					<?php echo varsion_1_product_images($data['unk'],$data['id']); ?>				
				</div>	

				<div style="clear: both;"></div>
				<?php if( $data['price'] ): ?>
					<div class="produc-price-section">
						<div class="produc-price">
							<?php echo htmlspecialchars(stripslashes($data['price']))." ".COIN; ?>
						</div>
					</div>	
				<?php endif; ?>
				<?php if( $data_name['have_ecom'] == "1" && $data['makat'] != "" ): ?>
					<div class="product-makat">
						<span class="makat-title">
							<?php echo $word[LANG]['1_1_products_serial_number']; ?>:
						</span>
						<span class="makat-info">
							<?php echo $data['makat']; ?>
						</span>
					</div>
				<?php endif; ?>


				<?php if( $data_name['have_ecom'] == "1" && $data['active_ecom'] == "1" && $data['price'] != "" ): ?>
				
					<div id='addToBasketButton<?php echo $data['id']; ?>' class="product-add-to-cart-button">
						
							<?php $abpath_temp = SERVER_PATH."/tamplate/".stripslashes($data_extra_settings['cartAddImg']); ?>		
							<?php if( file_exists($abpath_temp) && !is_dir($abpath_temp) ): ?>
								<a href='javascript:void(0)' class='withimage' onclick="addToBasket(<?php echo $data['id']; ?>);return false;">
									<img src='/tamplate/<?php echo stripslashes($data_extra_settings['cartAddImg']); ?>' />
								</a>
							<?php else: ?>
								<a href='javascript:void(0)' onclick="addToBasket(<?php echo $data['id']; ?>);return false;">
									<span class=''><?php echo $word[LANG]['1_1_products_add_to_cart']; ?></span>
								</a>
							<?php endif; ?>
						
					</div>
				<?php endif; ?>
				<?php if( $data_name['have_print'] == "1" ): ?>
				
					<div class="product-print">
						<a href='print.php?<?php echo $_SERVER['argv']['0']; ?>' target='_blank'>
							<?php echo $word[LANG]['1_2_print_version']; ?>
						</a>
					</div>
				<?php endif; ?> 	
				<?php if( !empty($data['url_name']) && !empty($data['url_link']) && $data_name['site_type'] != "10" ): ?>
					
					<div class="product-url-link">
						<div class="url-link-title">
							<?php echo $word[LANG]['1_1_products_url_link']; ?>
						</div>
						<div class="product-url-link-a">
							<a href='<?php echo htmlspecialchars(stripslashes($data['url_link'])); ?>' class='maintext' target='_blank'>
								<?php echo htmlspecialchars(stripslashes($data['url_name'])); ?>		
							</a>
						</div>
					</div>

				<?php endif; ?>				
			</div>


			<div class="forbigscreen">
				<div class="product_summary" >
					<b>
						<?php echo nl2br(htmlspecialchars(stripslashes($data['summary']))); ?>
					</b>
				</div>	
			</div>

			
			<div class="product_text">
				<?php echo nl2br(htmlspecialchars(stripslashes($content))); ?>
			</div>
												

			<?php if( $data['video_10service'] != "" ): ?>
				<div class="product_video">
					<?php if (strpos( $data['video_10service'],"iframe") != false): ?>
					<div class="video-container">
					<?php echo str_replace("\\\"","",$data['video_10service']); ?>
					</div>
					<style type="text/css">
						.video-container {
							position:relative;
							padding-bottom:56.25%;
							padding-top:30px;
							height:0;
							overflow:hidden;
						}

						.video-container iframe, .video-container object, .video-container embed {
							position:absolute;
							top:0;
							left:0;
							width:100%;
							height:100%;
						}					
					</style>
					
					<?php else: ?>
					
					<div id="youtubeVid125" ></div>
					<script type="text/javascript">
						loadSWFwithBase("<?php echo $data['video_10service']; ?>","youtubeVid125","221","177","#","youtubeVid125");
					</script>
					
					<?php endif; ?>
				</div>
				
			<?php endif; ?>			
			

			


			

			
			<?php if( $data['kobia_msg'] != "" ): ?>
				<div class="product-kobia_msg">
					<font>
						<?php echo nl2br(stripslashes(htmlspecialchars($data['kobia_msg']))); ?>
					</font>
				</div>
			<?php endif; ?>
													

		</div>	
	
		
		<?php
		
		$subject_id = ( $_GET['sub'] == "" ) ? "AND subject_id = ''" : "AND subject_id = ".ifint($_GET['sub']);
		$sql = "select * from user_products_cat where unk = '".UNK."' and deleted = '0' and status = '0' ".$subject_id." order by id limit 1";
		$res_cat = mysql_db_query(DB,$sql);
		$data_cat = mysql_fetch_array($res_cat);
		
		$temp_cat = ( $_GET['cat'] ) ? $_GET['cat'] : $data_cat['id'];					
		//echo products_regular_content_type2('3',$temp_cat , htmlspecialchars(stripslashes($data['name'])));								
		$limitOnQry='3';
		
		$title=htmlspecialchars(stripslashes($data['name']));							
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
		

		$counter = 0;
		?>
		<div class="product-list"> 
			<?php if( LANG == "he" && $nums > 0 ): ?>
			
				<h3>גולשים שהתעניינו ב<U><?php echo $title; ?></U> התעניינו גם ב:</h3>
			
			<?php endif; ?>
		
			<?php while( $data = mysql_fetch_array($res) ): ?>
				<?php
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
				$product_href = "index.php?m=s.pr&ud=".$data['id']."&cat=".$_GET['cat']."&sub=".$_GET['sub'];
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

				
				<?php $counter++; ?>
			<?php endwhile; ?>
		</div>
	</div>	
<?php

						
}


function version_1_ecom_table()
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
					echo "<div id=\"shopping_cart_header\" rel='close'>";
						echo "<div class='hidden-cart-part close_cart_button' style='display:none;'><a href='javascript://'>X</a></div>";
						echo "<table border=\"0\" cellspacing=\"0\" cellpadding=\"0\" class=\"ecom_tableRightMenu\" >";
							echo "<tr>";
								echo "<td width=3></td>";
								$abpath_temp = SERVER_PATH."/tamplate/".stripslashes($data_extra_settings['cartHeadlineImg']);
								if( file_exists($abpath_temp) && !is_dir($abpath_temp) )	{
									//$im_size = GetImageSize ($abpath_temp); 
									//$imageHeight = $im_size[1];
									echo "<td><div id='shopping_cart_header_img'><img src='/tamplate/".stripslashes($data_extra_settings['cartHeadlineImg'])."' border=0 alt=''></div></td>";
								}
								else
								{
									echo "<td><strong class='ecom_tableRightMenu'>".$word[LANG]['1_3_ecom_table_title']."</strong></tD>";
								}
							echo "</tr>";
						echo "</table>";
					echo "</div>";	
					echo "	";
					echo "<div id=\"shopping_cart_body\" class='hidden-cart-part'>";
					echo "<div id=\"shopping_cart_items_wrap\">";
					echo "<table id=\"shopping_cart_items\" class='ecom_tableRightMenu'>";
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
					echo "</div>";
					echo $hr_line;
					echo "</div>";	
					
					echo "<div id=\"shopping_cart_totalprice\" class='ecom_tableRightMenu' align='".$settings['re_align']."'>".$word[LANG]['1_3_ecom_table_total']." ".$total_price_to_pay." ".COIN."</div>";
					
			echo "<div class='hidden-cart-part' id='go_to_cart_button' align='".$settings['re_align']."'>";
			echo $hr_line;
				$abpath_temp = SERVER_PATH."/tamplate/".stripslashes($data_extra_settings['cartKopaImg']);
				if( file_exists($abpath_temp) && !is_dir($abpath_temp) )	{
					echo "<a href='index.php?m=ecom_form' class='ecom_tableRightMenu'><img src='/tamplate/".stripslashes($data_extra_settings['cartKopaImg'])."' border=0 alt=''></a>";
				}
				else
				{
					echo "<b><u><a href='index.php?m=ecom_form' class='ecom_tableRightMenu'>".$word[LANG]['1_3_ecom_table_cart']."</a></u></b>";
				}
							
				echo "</div>";	
			echo "</div>";
			echo "</td>";
		echo "</tr>";

		echo "<tr><TD height=\"7\" colspan=\"2\"></TD></tr>";
	echo "</table>";
	
}

function varsion_1_product_images($unk,$pid)
{
	$sql = "SELECT domain FROM users WHERE unk = '".$unk."' ";
	$res = mysql_db_query(DB,$sql);
	$userData = mysql_fetch_array($res);
	
	$sql = "select id, name, img, img2, img3 from user_products where unk = '".$unk."' and deleted = '0' and active = '0' and id = '".ifint($pid)."' limit 1";
	$res = mysql_db_query(DB,$sql);
	$data = mysql_fetch_array($res);
	$server_path = "/home/ilan123/domains/".$userData['domain']."/public_html/product_image/".$data['id']."/";
	

				$img_S = $data['img1'];
				$img_L = $data['img2'];
				$img_XL = $data['img3'];
				$temp_path = "/home/ilan123/domains/".$userData['domain']."/public_html/products/".$img_S;
				$temp_path_L = "/home/ilan123/domains/".$userData['domain']."/public_html/products/".$img_L;
				$temp_path_XL = "/home/ilan123/domains/".$userData['domain']."/public_html/products/".$img_XL;
				
				$big_path = $img_S;
				if( file_exists($temp_path_XL) && !is_dir($temp_path_XL) ){
					$big_path = $img_XL;
				}
				elseif( file_exists($temp_path_L) && !is_dir($temp_path_L) ){
					$big_path = $img_L;
				}
				
				$small_path = $img_XL;
				if( file_exists($temp_path_S) && !is_dir($temp_path_S) ){
					$small_path = $img_S;
				}
				elseif( file_exists($temp_path_L) && !is_dir($temp_path_L) ){
					$small_path = $img_L;
				}							
				$src = "http://".$userData['domain']."/products/";

				echo "<a class='first' rel='fancy_image' href='".$src."/".$big_path."' title=''><img class='' alt='' src='".$src."/".$small_path."' /></a>";

							

				
				$count=0;
				for( $img=2 ; $img <= 5 ; $img++ )
				{
					if( is_dir($server_path) )
					{
						$img_S = $img."-S";
						$img_L = $img."-L";
						$img_EX = $img."-EX";
						foreach (glob($server_path.$img_S."*") as $filename) {
							$explo = explode($data['id']."/",$filename);
							$exte = substr($explo[1],(strpos($explo[1],".")+1));
						}
						
						$temp_path = $server_path.$img_S.".".$exte;
						$temp_path_L = $server_path.$img_L.".".$exte;
						$temp_path_EX = $server_path.$img_EX.".".$exte;
						if( file_exists($temp_path) && !is_dir($temp_path) )
						{
							$big_path = $img_S;
							if( file_exists($temp_path_EX) && !is_dir($temp_path_EX) ){
								$big_path = $img_EX;
							}
							elseif( file_exists($temp_path_L) && !is_dir($temp_path_L) ){
								$big_path = $img_L;
							}							
				
							echo "<a rel='fancy_image' href='http://".$userData['domain']."/product_image/".$data['id']."/".$big_path.".".$exte."' title=''><img class='' alt='' src='http://".$userData['domain']."/product_image/".$data['id']."/".$img_S.".".$exte."' /></a>";
						
							
							$count++;
							
							
						}
					}
				}

	
	
	?>
	
		
				
	<script type="text/javascript" src="http://ilbiz.co.il/ClientSite/version_1/style/fancybox/jquery.fancybox-1.3.4.js"></script>
	<link rel="stylesheet" type="text/css" href="http://ilbiz.co.il/ClientSite/version_1/style/fancybox/jquery.fancybox-1.3.4.css" media="screen" />				
								
	<script type="text/javascript">
		jQuery(function($){
			$(document).ready(function() {
				$("a[rel=fancy_image]").fancybox({
					'transitionIn'		: 'none',
					'transitionOut'		: 'none',
					
				});
			});
		});
	</script>
	<?php
	
}



function half_price_products($pcat = "",$scat = "",$speccat = "",$user_id="")
{
	
	//todo!!!
	$selected_cat = $speccat;
	if($selected_cat == "" || $selected_cat == "0"){
		$selected_cat = $scat;
	}
	if($selected_cat == "" || $selected_cat == "0"){
		$selected_cat = $pcat;
	}
	if($selected_cat == "" || $selected_cat == "0"){
		return;
	}	
	global $data_colors,$data_name,$word,$settings,$data_extra_settings;

	
	$x_type = "2";
	

	$orderBy_qry = "ORDER BY up.id DESC";	

	$sold_qry = "up.mask_remain_stock > 0 AND ";
	
	
	
	
	$sql = "select up.* , mc.cat_id from 
		user_products as up , module_cats_belong_10service as mc where 
			up.lock_10service = 1 AND "
			//."up.unk = '".UNK."' AND "
			." up.active = '0' AND " 
			." up.deleted = '0' AND
			up.auto_date_10service <= NOW() AND 
			".$sold_qry."
			mc.x_id=up.id AND
			mc.x_type='".$x_type."'
			
			and mc.cat_id = '".$selected_cat."' 
		
			GROUP BY up.id ".$orderBy_qry." LIMIT 4";
	
	$res = mysql_db_query(DB,$sql);
	
		

		

		$counter = 0;
		if(!(mysql_num_rows($res) > 0)){
			return;
		}
		?>
		<div class="sidebar-products">
			<h4>דילים בשירות 10</h4>
		<?php 
		
		while( $data = mysql_fetch_array($res) )
		{
			//echo "<pre>";
			//	print_r($data);
			//echo "</pre>";
			//exit();
			$http_s = "http";
			if(defined("HTTP_S")){
				$http_s = HTTP_S;
			}
			$server_path = "/home/ilan123/domains/10service.co.il/public_html";
			$http_path = $http_s."://www.10service.co.il";			
			
			$product_href = "http://www.10service.co.il/index.php?m=s_products&ud=".$data['id'];
			$img_data = $data['img'];
			if($img_data == ""){
				$$img_data = $data['img2'];
			}
			if($img_data == ""){
				$img_data = $data['img3'];
			}			
			$abpath_temp = $server_path."/products/".$img_data;
			$img = "";
			if( file_exists($abpath_temp) && !is_dir($abpath_temp) )
			{
				$im_size = GetImageSize ($abpath_temp); 
				$imageWidth = $im_size[0]; 
				$imageheight = $im_size[1]; 
				//$img = "<img src='".$http_path."/image.php?width=228&height=228&image=/products/EX".$data['img']."' border='0' height=\"{$imageheight}\" width=\"".$imageWidth."\">";
				$img_src = "<a class='hp-product-image' rel='nofollow' target='_blank' href=\"".$product_href."\" class=\"maintext\" title=\"".htmlspecialchars(stripslashes($data['name']))."\"><img src='".$http_path."/image.php?width=228&height=228&image=/products/".$img_data."' border='0'></a>";
			}
			else
			{
				$img_src = "";
				$imageWidth = "150";
			}
			
			$sql = "SELECT name FROM users WHERE id = '".$data['belongToUser10service']."' ";
			$res_user = mysql_db_query(DB,$sql);
			$data_user = mysql_fetch_array($res_user);
			
			
			
				
					$params['title'] = $data['name'];
					$params['mask_remain_stock'] = $data['mask_remain_stock'];
					$params['id'] = $data['id'];
					$params['price'] = $data['price'];
					$params['price_10service'] = $data['price_10service'];
					$params['img'] = $data['img3'];
					$params['belongToUser10service'] = $data['belongToUser10service'];
					$params['video_10service'] = $data['video_10service'];
					$params['summary'] = $data['summary'];
					$params['content'] = $data['content'];
					$params['url_name'] = $data['url_name'];
					$params['url_link'] = $data['url_link'];
					$params['word_count'] = "דילים";
?>

					

				<div id="hpProduct<?php echo $data['id']; ?>" class="sliding_product	">
					<div class="product-name">
						<a  target='_blank'  rel='nofollow'  href="<?php echo $product_href; ?>" title="<?php echo htmlspecialchars(stripslashes($data['name'])); ?>">
							<?php echo htmlspecialchars(stripslashes($data['name'])); ?>
						</a>
					</div>
					
							<?php echo $img_src; ?>
					
					<div class='produc-summary'>
						<?php echo nl2br(stripslashes(htmlspecialchars($data['summary']))); ?>							
					</div>	
					<div class='produc-price-section'>
						<div class='produc-price'>
							<?php if( $data['price'] ): ?>
								<div class='produc-price-old'>
									<?php echo COIN.$data['price']; ?>
								</div>
							<?php endif; ?>
							<?php if( $data['price_10service'] ): ?>
								<div class='produc-price-10'>
									<?php echo COIN.$data['price_10service']; ?>
								</div>
							<?php endif; ?>			
<div style="clear:both;"></div>							
						</div>
						
					</div>
					<a  target='_blank'  rel='nofollow'  class="more-info" href="<?php echo $product_href; ?>"  title="<?php echo htmlspecialchars(stripslashes($data['name'])); ?>">
						<b><?php echo $word[LANG]['1_1_products_more_info']; ?></b>
					</a>
				</div>						



					
 <?php

			$counter++;
		}
		?> 
		</div>
		<?php
}