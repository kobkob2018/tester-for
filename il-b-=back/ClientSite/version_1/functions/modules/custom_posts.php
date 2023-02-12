<?php
	function add_custom_post_cat($details,$block_id){
		$details_arr = explode(" ", $details);
		$post_cat = "0";
		$open_state = "open";
		$style_display = "display:block;";
		foreach($details_arr as $detail_str){
			$detail = trim($detail_str);
			if(is_numeric($detail)){
				$post_cat = $detail;
			}
			elseif($detail == "closed"){
				$open_state = "closed";
				$style_display = "display:none;";
			}
		}
		global $browser_is_mobile;
		if($browser_is_mobile){
			//return add_custom_post_cat_mobile($post_cat,$block_id,$open_state,$style_display);
		}

		$cat_sql = "SELECT * FROM custom_post_cat WHERE id = $post_cat";
		$cat_res = mysql_db_query(DB,$cat_sql);
		$cat_info = mysql_fetch_array($cat_res);
		
		$posts = array();
		$posts_id = array();
		$posts_sql = "SELECT post_id FROM custom_post_cat_belong WHERE cat_id = $post_cat";
		
		$posts_res = mysql_db_query(DB,$posts_sql);
		while($post_i = mysql_fetch_array($posts_res)){
			$posts_id[] = $post_i['post_id'];
		}
		$post_ids_str = implode(",",$posts_id);
		
		$posts_sql = "SELECT * FROM custom_post WHERE id IN($post_ids_str) ORDER BY place desc";
		
		
		$posts_res = mysql_db_query(DB,$posts_sql);
		while($post = mysql_fetch_array($posts_res)){

			$post['domain'] = "ilbiz.co.il";
			$posts[] = $post;
		}
		
		$custom_html_title = '
		
		';
		if($cat_info['custom_html_title'] != ""){
			$custom_html_title = $cat_info['custom_html_title'];
		}
		$custom_html = '
		<!--desktop_only-->
						<div class="custom_post_wrap row-fluid">	
							<div class="span2 socol1">
								{{custom_post_img}}
							</div>
							<div class="span8  socol2">								
								<div class="custom_post_title">
								{{name}}
								</div>

								<div class="custom_post_summary">
								{{summary}}
								</div>
							</div>
							<!-- if url_link -->
							<div class="span2  socol4">
								<div class="custom_post_link">
									<a href="{{url_link}}" title="להמשך קריאה" target="_blank">
										<span class="whitelink nounderline">
										להמשך קריאה
										</span>
									</a>
									
								</div>
							</div>
							<!-- endif -->
						</div>	
		<!--end_desktop_only-->		


		<!--mobile_only-->
						<div class="mobile_custom_post_wrap custom_post_wrap">	
							<div class="custom_post_header">
							
								<div class="custom_post_img">
									{{custom_post_img}}
								</div>
								<div class="custom_post_title">
									{{name}}
								</div>
							</div>						

							<div class="custom_post_summary">
								{{summary}}
							</div>
							
							<!-- if url_link -->
							
								<div class="custom_post_link">
									<a href="{{url_link}}" title="להמשך קריאה" target="_blank">
										<span class="whitelink nounderline">
										להמשך קריאה
										</span>
									</a>
									
								</div>
							
							<!-- endif -->
						</div>	
		<!--end_mobile_only-->		
		';
		if($cat_info['custom_html'] != ""){
			$custom_html = $cat_info['custom_html'];
		}	
		$browser_type_remove = "mobile";
		$browser_is_desktop = true;
		if($browser_is_mobile){
			$browser_type_remove = "desktop";
			$browser_is_desktop = false;
		}				
		$main_html_arr = explode("<!--".$browser_type_remove."_only-->",$custom_html);
		$main_html = "";
		foreach($main_html_arr as $html_part){
			$html_part_arr = explode("<!--end_".$browser_type_remove."_only-->",$html_part);
			if(!isset($html_part_arr[1])){
				$main_html .= $html_part_arr[0];
			}
			else{
				/*
				if(!$browser_is_desktop){
					$main_html .= $html_part_arr[0];
				}
				*/
				$main_html .= $html_part_arr[1];
			}
		}
		$custom_html = $main_html;
		$main_html_arr = explode("<!--".$browser_type_remove."_only-->",$custom_html_title);
		$main_html = "";
		foreach($main_html_arr as $html_part){
			$html_part_arr = explode("<!--end_".$browser_type_remove."_only-->",$html_part);
			if(!isset($html_part_arr[1])){
				$main_html .= $html_part_arr[0];
			}
			else{
				/*
				if(!$browser_is_desktop){
					$main_html .= $html_part_arr[0];
				}
				*/
				$main_html .= $html_part_arr[1];
			}
		}
		$custom_html_title = $main_html;
		?>
		<div class="custom_posts_cat_wrap" id="custom_posts_cat_block_<?php echo $block_id; ?>" rel="<?php echo $open_state; ?>">
		<?php /*
			<a href="javascript://" class='custom_post_cat_door row-fluid' rel="<?php echo $block_id; ?>">
				<div class="custom_post_cat_title span12">
					<?php echo $cat_info['title']; ?>
				</div>
			</a>
		*/ ?>
			<div class="custom_posts_posts_wrap">
				<div class="custom_posts_posts_content" style="<?php echo $style_display; ?>">
					
						<?php echo $custom_html_title; ?>

					<?php foreach($posts as $post): ?>
					
						<?php 
						//echo SERVER_PATH."<br/><br>".HTTP_PATH."<br/><br/>";
							$post_img_name = $post['img'];
							$post_img_url = false;
							$custom_post_img = "";
							if($post_img_name != ""){
								$post_img_path = "/home/ilan123/domains/ilbiz.co.il/public_html/custom_posts/".$post_img_name;
								if(file_exists($post_img_path)){
									$post_img_url = HTTP_S."://".$_SERVER['HTTP_HOST']."/image.php?image=/custom_posts/".$post_img_name."&root=ilbiz.co.il";
									$custom_post_img = '				
										<div class="custom_post_img">
											<img class="post_img" style="max-width:100%;" title="'.$post['name'].'" src="'.$post_img_url.'" />
										</div>';
								}
							}
							$outer_img_url = $post['image_url'];
							if($outer_img_url != ""){
								$custom_post_img = '				
										<div class="custom_post_img">
											<img class="post_img" style="max-width:100%;" title="'.$post['name'].'" src="'.$outer_img_url.'" />
										</div>';
							}
							$post_custom_html_final = "";
							$post_custom_html = $custom_html;
							$post_custom_html_arr = explode("<!-- if",$post_custom_html);
							foreach($post_custom_html_arr as $post_custom_html_part){
								$post_custom_html_part_arr = explode("<!-- endif -->",$post_custom_html_part);
								if(isset($post_custom_html_part_arr[1])){	
									$post_custom_html_part_condition = $post_custom_html_part_arr[0];
									$post_custom_html_part_0 = "";
									$post_custom_html_part_1 = "";
									if(isset($post_custom_html_part_arr[1])){
										$post_custom_html_part_1 = $post_custom_html_part_arr[1];
									}
									$post_custom_html_condition_arr = explode("-->",$post_custom_html_part_condition);
									$post_custom_html_condition = trim($post_custom_html_condition_arr[0]);
									$post_custom_html_condition_str = $post_custom_html_condition_arr[1];
									if($post[$post_custom_html_condition]){
										$post_custom_html_part_0 = $post_custom_html_condition_str;
									}
									$post_custom_html_final.=$post_custom_html_part_0;
									$post_custom_html_final.=$post_custom_html_part_1;
								}
								else{
									$post_custom_html_final.=$post_custom_html_part;
								}
							}
							
							//$post_custom_html_final = $post_custom_html;
							$post['HTTP_S'] = HTTP_S;
							foreach($post as $search=>$replace){
								$post_custom_html_final = str_replace("{{".$search."}}",$replace,$post_custom_html_final);
							}
							$post_custom_html_final = str_replace("{{custom_post_img}}",$custom_post_img,$post_custom_html_final);
							echo $post_custom_html_final;
						?>
					<?php endforeach; ?>
				</div>
			</div>
		</div>
		
		<?php
	}

	
	function add_custom_post_cat_mobile($post_cat,$block_id,$open_state,$style_display){
		return;
		$cat_sql = "SELECT * FROM custom_post_cat WHERE id = $post_cat";
		$cat_res = mysql_db_query(DB,$cat_sql);
		$cat_info = mysql_fetch_array($cat_res);
		
		$posts = array();
		$posts_id = array();
		$posts_sql = "SELECT post_id FROM custom_post_cat_belong WHERE cat_id = $post_cat";
		$posts_res = mysql_db_query(DB,$posts_sql);
		while($post_i = mysql_fetch_array($posts_res)){
			$posts_id[] = $post_i['post_id'];
		}
		$post_ids_str = implode(",",$posts_id);
		
		$posts_sql = "SELECT * FROM custom_post WHERE id IN($post_ids_str) ORDER BY place desc";
		$posts_res = mysql_db_query(DB,$posts_sql);
		while($post = mysql_fetch_array($posts_res)){
			$posts[] = $post;
		}
		?>
		<div class="custom_posts_cat_wrap mobile_custom_posts_cat_wrap" id="custom_posts_cat_block_<?php echo $block_id; ?>" rel="<?php echo $open_state; ?>">
			<?php /*
			<a href="javascript://" class='custom_post_cat_door row-fluid' rel="<?php echo $block_id; ?>">
				<div class="custom_post_cat_title span12">
					<?php echo $cat_info['title']; ?>
				</div>
			</a>
			*/ ?>
			<div class="custom_posts_posts_wrap">
				<div class="custom_posts_posts_content" style="<?php echo $style_display; ?>">
					<?php foreach($posts as $post): ?>
						<div class="custom_post_wrap">	
							
							<div class="custom_post_img custom_post_rightcol">
								<?php 
								//echo SERVER_PATH."<br/><br>".HTTP_PATH."<br/><br/>";
									$post_img_name = $post['img'];
									$post_img_url = false;
									if($post_img_name != ""){
										$post_img_path = SERVER_PATH."/custom_posts/".$post_img_name;
										if(file_exists($post_img_path)){
											$post_img_url = HTTP_PATH."/custom_posts/".$post_img_name;
										}
									}
									
								?>
								<?php if($post_img_url): ?>
									<img class='post_img' style='max-width:100%;' title='<?php echo $post['name']; ?>' src='<?php echo $post_img_url; ?>' />
								<?php endif; ?>
							</div>
							
							<div class="custom_post_leftcol">								
								<div class="custom_post_title">
									<?php echo $post['name']; ?>
								</div>
							</div>
							<div style="clear:both;height:15px;"></div>
							
							<div class="custom_post_link custom_post_leftcol">
								<a href="<?php echo $post['url_link']; ?>" title='להמשך קריאה'>
									<span class="whitelink nounderline">
									להמשך קריאה
									</span>
								</a>
								
							</div>

							
							
							<div style="clear:both;"></div>
							
						</div>
					<?php endforeach; ?>
				</div>
			</div>
		</div>
		
		<?php
	}	

	
	function add_custom1_posts_style(){
		?>
						<style type="text/css">
/* custom_posts */ 

.custom_posts_cat_wrap{
	max-width:750px;
	margin:20px auto;
	margin-bottom:10px;
}
.maintext a.custom_post_cat_door{
    text-decoration: none;
    display: block;
    background: #2ea3f2;
    text-align: center;
    font-size: 31px;
    color: white;
    padding: 14px 0px;
    font-weight: bold;
    border-top-right-radius: 8px;
    border-top-left-radius: 8px;
}
.custom_post_cat_title{}
.custom_posts_posts_wrap{

}
.custom_posts_posts_content{}
.custom_post_wrap{
	padding: 10px;
    border-bottom: 2px solid gray;
	text-align:right;
	box-sizing: border-box;
	
}
.custom_post_wrap_th{
	border-bottom: 2px solid gray;
	padding:10px;
	
}
.custom_post_wrap .socol1{float:right; width:14%; }
.custom_post_wrap .socol2{float:right; width:65%; margin-right:2.5%; }
.custom_post_wrap .socol3{float:right; width:14.5%; margin-right:2.5%;}
.custom_post_wrap .socol4{float:right; width:14%; margin-right:2.5%;}
.custom_post_wrap::after{clear:both;content:'';display:block; } 

.custom_post_wrap_th .scoth:nth-child(1){float:right; width:14%; height:20px; }
.custom_post_wrap_th .scoth:nth-child(2){float:right; width:45%; margin-right:2.5%;padding-left:19px;}
.custom_post_wrap_th .scoth:nth-child(3){float:right; width:14.5%; margin-right:2.5%;}
.custom_post_wrap_th::after{clear:both;content:'';display:block;};


.custom_post_img{}
.custom_post_title{
	font-size: 18px;
    color: #2ea3f2;
    line-height: 18px;
}
.custom_post_summary{
	font-size: 13px;
    line-height: 16px;
	color:#666666;
}
.custom_post_price{
	font-size: 18px;
    color: #2ea3f2;
    line-height: 18px;
}
.custom_post_price_summary{
	font-size: 13px;
    line-height: 16px;
	color:#666666;
}
.custom_post_link{}
.mobile_custom_posts_cat_wrap a .whitelink,.custom_posts_cat_wrap a .whitelink{
  display: block;
    
    padding: 10px;
    white-space: nowrap;
    color: נך;
    text-decoration: underline;
    border-radius: 3px;
    text-align: center;
    font-weight: bold;
}

.custom_post_phone{}


/* custom_posts mobile */

.custom_post_rightcol{float:right; width:40%;}
.custom_post_leftcol{
	float: left;
    margin-right: 16px;
    width: 51%;
    text-align: center;
}
.mobile_custom_posts_cat_wrap .custom_post_title{color:#6b5f5f;}
.mobile_custom_posts_cat_wrap .custom_post_price{
    font-size: 23px;
    line-height: 38px;		
}
.mobile_custom_posts_cat_wrap .custom_post_img img{max-height:100px;}
.custom_posts_cat_wrap a{text-decoration:none !important;}
.custom_post_phone img{vertical-align: middle;}
.custom_post_phone{color:gray;}
.mobile_custom_post_wrap{}
.mobile_custom_post_wrap .custom_post_header{}
.mobile_custom_post_wrap .custom_post_img{
	float: right;
    width: 100px;
    padding: 0px 0px 10px 10px;
}
.mobile_custom_post_wrap .custom_post_title{}
.mobile_custom_post_wrap .custom_post_summary{
	clear: both;
    font-size: 17px;
    line-height: 20px;
}
.mobile_custom_post_wrap .custom_post_link .whitelink{text-align:right;}
						</style>		
		<?php 
	}