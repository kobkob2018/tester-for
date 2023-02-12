<?php
	function add_service_offer_cat($details,$block_id){
		$details_arr = explode(" ", $details);
		$offer_cat = "0";
		$open_state = "closed";
		$style_display = "display:none;";
		foreach($details_arr as $detail_str){
			$detail = trim($detail_str);
			if(is_numeric($detail)){
				$offer_cat = $detail;
			}
			elseif($detail == "open"){
				$open_state = "open";
				$style_display = "display:block;";
			}
		}
		global $browser_is_mobile;
		if($browser_is_mobile){
			//return add_service_offer_cat_mobile($offer_cat,$block_id,$open_state,$style_display);
		}

		$cat_sql = "SELECT * FROM user_service_offer_cat WHERE id = $offer_cat";
		$cat_res = mysql_db_query(DB,$cat_sql);
		$cat_info = mysql_fetch_array($cat_res);
		
		$offers = array();
		$offers_id = array();
		$offers_sql = "SELECT offer_id FROM user_service_offer_cat_belong WHERE cat_id = $offer_cat";
		$offers_res = mysql_db_query(DB,$offers_sql);
		while($offer_i = mysql_fetch_array($offers_res)){
			$offers_id[] = $offer_i['offer_id'];
		}
		$offer_ids_str = implode(",",$offers_id);
		
		$offers_sql = "SELECT * FROM user_service_offer WHERE id IN($offer_ids_str) ORDER BY place desc";
		$offers_res = mysql_db_query(DB,$offers_sql);
		while($offer = mysql_fetch_array($offers_res)){
			$domain_sql = "SELECT domain FROM users WHERE unk = '".$offer['unk']."'";
			$domain_res = mysql_db_query(DB,$domain_sql);
			$domain__data = mysql_fetch_array($domain_res);
			if($domain__data['domain']!=""){
				$offer['domain'] = $domain__data['domain'];
			}
			else{
				$offer['domain'] = $_SERVER['HTTP_HOST'];
			}
			$offers[] = $offer;
		}
		
		$custom_html_title = '
		<!--desktop_only-->
					<div class="service_offer_wrap_th row-fluid">	
						<div class="span2 scoth"></div>
						<div class="span6 scoth">הצעה</div>
						<div class="span2 scoth">מחיר</div>
						<div class="span2 scoth"></div>
					</div>	
		<!--end_desktop_only-->
		';
		if($cat_info['custom_html_title'] != ""){
			$custom_html_title = $cat_info['custom_html_title'];
		}
		$custom_html = '
		<!--desktop_only-->
						<div class="service_offer_wrap row-fluid">	
							<div class="span2 socol1">
								{{service_offer_img}}
							</div>
							<div class="span6  socol2">								
								<div class="service_offer_title">
								{{name}}
								</div>

								<div class="service_offer_summary">
								{{summary}}
								</div>
							</div>
							<div class="span2  socol3">								
								<div class="service_offer_price">
									₪{{price}}
								</div>

								<div class="service_offer_price_summary">
								{{price_summary}}
								</div>	
							</div>
							<!-- if url_link -->
							<div class="span2  socol4">
								<div class="service_offer_link">
									<a href="{{url_link}}" title="לנציג">
										<span class="whitelink nounderline">
										לנציג
										</span>
									</a>
									
								</div>
							</div>
							<!-- endif -->
						</div>	
		<!--end_desktop_only-->		


		<!--mobile_only-->
						<div class="service_offer_wrap">	
							
							<div class="service_offer_img service_offer_rightcol">
								{{service_offer_img}}
							</div>
							
							<div class="service_offer_leftcol">								
								<div class="service_offer_title">
								{{name}}
								</div>
							
								<div class="service_offer_price">
									₪{{price}}
								</div>	
							</div>
							<div style="clear:both;height:15px;"></div>
							
							<div class="service_offer_phone service_offer_rightcol">
							<!-- if service_phone -->
								<a href="tel:{{service_phone}}"><img src="{{HTTP_S}}://ilbiz.co.il/ClientSite/version_1/style/image/phone_green.png"  width="30px" alt="" />&nbsp;<b>התקשר</b></a>
							<!-- endif -->	
							</div>
							
							<div class="service_offer_link service_offer_leftcol">
							<!-- if url_link -->
								<a href="{{url_link}}" title="לנציג">
									<span class="whitelink nounderline">
									לנציג
									</span>
								</a>
							<!-- endif -->	
							</div>

							
							
							<div style="clear:both;"></div>
							
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
		<div class="service_offers_cat_wrap" id="service_offers_cat_block_<?php echo $block_id; ?>" rel="<?php echo $open_state; ?>">
			<a href="javascript://" class='service_offer_cat_door row-fluid' rel="<?php echo $block_id; ?>">
				<div class="service_offer_cat_title span12">
					<?php echo $cat_info['title']; ?>
				</div>
			</a>
			<div class="service_offers_offers_wrap">
				<div class="service_offers_offers_content" style="<?php echo $style_display; ?>">
					
						<?php echo $custom_html_title; ?>

					<?php foreach($offers as $offer): ?>
						<?php 
						//echo SERVER_PATH."<br/><br>".HTTP_PATH."<br/><br/>";
							$offer_img_name = $offer['img'];
							$offer_img_url = false;
							$service_offer_img = "";
							if($offer_img_name != ""){
								$o_server_host = $_SERVER['HTTP_HOST'];
								$o_server_path = str_replace($o_server_host,$offer['domain'],SERVER_PATH);
								$o_http_path = str_replace($o_server_host,$offer['domain'],HTTP_PATH);
								$offer_img_path = $o_server_path."/user_service_offers/".$offer_img_name;
								if(file_exists($offer_img_path)){
									$offer_img_url = $o_http_path."/user_service_offers/".$offer_img_name;
									$sp = $_SERVER['HTTP_HOST'];
									$service_offer_img = '				
										<div class="service_offer_img">
											<img class="offer_img" style="max-width:100%;" title="'.$offer['name'].'" src="'.$offer_img_url.'" />
										</div>';
								}
							}
							$offer_custom_html_final = "";
							$offer_custom_html = $custom_html;
							$offer_custom_html_arr = explode("<!-- if",$offer_custom_html);
							foreach($offer_custom_html_arr as $offer_custom_html_part){
								$offer_custom_html_part_arr = explode("<!-- endif -->",$offer_custom_html_part);
								if(isset($offer_custom_html_part_arr[1])){	
									$offer_custom_html_part_condition = $offer_custom_html_part_arr[0];
									$offer_custom_html_part_0 = "";
									$offer_custom_html_part_1 = "";
									if(isset($offer_custom_html_part_arr[1])){
										$offer_custom_html_part_1 = $offer_custom_html_part_arr[1];
									}
									$offer_custom_html_condition_arr = explode("-->",$offer_custom_html_part_condition);
									$offer_custom_html_condition = trim($offer_custom_html_condition_arr[0]);
									$offer_custom_html_condition_str = $offer_custom_html_condition_arr[1];
									if($offer[$offer_custom_html_condition]){
										$offer_custom_html_part_0 = $offer_custom_html_condition_str;
									}
									$offer_custom_html_final.=$offer_custom_html_part_0;
									$offer_custom_html_final.=$offer_custom_html_part_1;
								}
								else{
									$offer_custom_html_final.=$offer_custom_html_part;
								}
							}
							
							//$offer_custom_html_final = $offer_custom_html;
							$offer['HTTP_S'] = HTTP_S;
							foreach($offer as $search=>$replace){
								$offer_custom_html_final = str_replace("{{".$search."}}",$replace,$offer_custom_html_final);
							}
							$offer_custom_html_final = str_replace("{{service_offer_img}}",$service_offer_img,$offer_custom_html_final);
							echo $offer_custom_html_final;
						?>
					<?php endforeach; ?>
				</div>
			</div>
		</div>
		
		<?php
	}

	
	function add_service_offer_cat_mobile($offer_cat,$block_id,$open_state,$style_display){
		$cat_sql = "SELECT * FROM user_service_offer_cat WHERE id = $offer_cat";
		$cat_res = mysql_db_query(DB,$cat_sql);
		$cat_info = mysql_fetch_array($cat_res);
		
		$offers = array();
		$offers_id = array();
		$offers_sql = "SELECT offer_id FROM user_service_offer_cat_belong WHERE cat_id = $offer_cat";
		$offers_res = mysql_db_query(DB,$offers_sql);
		while($offer_i = mysql_fetch_array($offers_res)){
			$offers_id[] = $offer_i['offer_id'];
		}
		$offer_ids_str = implode(",",$offers_id);
		
		$offers_sql = "SELECT * FROM user_service_offer WHERE id IN($offer_ids_str) ORDER BY place desc";
		$offers_res = mysql_db_query(DB,$offers_sql);
		while($offer = mysql_fetch_array($offers_res)){
			$offers[] = $offer;
		}
		?>
		<div class="service_offers_cat_wrap mobile_service_offers_cat_wrap" id="service_offers_cat_block_<?php echo $block_id; ?>" rel="<?php echo $open_state; ?>">
			<a href="javascript://" class='service_offer_cat_door row-fluid' rel="<?php echo $block_id; ?>">
				<div class="service_offer_cat_title span12">
					<?php echo $cat_info['title']; ?>
				</div>
			</a>
			<div class="service_offers_offers_wrap">
				<div class="service_offers_offers_content" style="<?php echo $style_display; ?>">
					<?php foreach($offers as $offer): ?>
						<div class="service_offer_wrap">	
							
							<div class="service_offer_img service_offer_rightcol">
								<?php 
								//echo SERVER_PATH."<br/><br>".HTTP_PATH."<br/><br/>";
									$offer_img_name = $offer['img'];
									$offer_img_url = false;
									if($offer_img_name != ""){
										$offer_img_path = SERVER_PATH."/user_service_offers/".$offer_img_name;
										if(file_exists($offer_img_path)){
											$offer_img_url = HTTP_PATH."/user_service_offers/".$offer_img_name;
										}
									}
									
								?>
								<?php if($offer_img_url): ?>
									<img class='offer_img' style='max-width:100%;' title='<?php echo $offer['name']; ?>' src='<?php echo $offer_img_url; ?>' />
								<?php endif; ?>
							</div>
							
							<div class="service_offer_leftcol">								
								<div class="service_offer_title">
									<?php echo $offer['name']; ?>
								</div>
							
								<div class="service_offer_price">
									₪<?php echo $offer['price']; ?>
								</div>	
							</div>
							<div style="clear:both;height:15px;"></div>
							
							<div class="service_offer_phone service_offer_rightcol">
								<a href="tel:<?php echo $offer['service_phone']; ?>"><img src="<?php echo HTTP_S; ?>://ilbiz.co.il/ClientSite/version_1/style/image/phone_green.png"  width="30px" alt="" />&nbsp;<b>התקשר</b></a>
							</div>
							<div class="service_offer_link service_offer_leftcol">
								<a href="<?php echo $offer['url_link']; ?>" title='לנציג'>
									<span class="whitelink nounderline">
									לנציג
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
	function add_service_offers_js(){
		?>
		<script type="text/javascript">
			jQuery(document).ready(function ($) {
				$(".service_offers_cat_wrap").each(function () {
					$(this).find(".service_offer_cat_door").click(function(){
						var block_num = $(this).attr("rel");

						if($("#service_offers_cat_block_"+block_num).attr("rel") == "open"){
							$("#service_offers_cat_block_"+block_num).attr("rel","closed");
							$("#service_offers_cat_block_"+block_num).find(".service_offers_offers_content").hide();
						}
						else{
							$(".service_offers_cat_wrap").attr("rel","closed");
							$(".service_offers_cat_wrap").find(".service_offers_offers_content").hide();
							$("#service_offers_cat_block_"+block_num).attr("rel","open").find(".service_offers_offers_content").show();
							var toppos = $("#service_offers_cat_block_"+block_num).offset().top - 150;
							console.log("#service_offers_cat_block_"+block_num);
							$("html, body").animate({ scrollTop: toppos }, 600);							
						}
					});
				});
			});
		</script>
		<?php
	}
	
	function add_service_offers_landing_style(){
		?>
						<style type="text/css">
/* service_offers */ 
.service_offers_cat_wrap{
	max-width:750px;
	margin:20px auto;
	margin-bottom:10px;
}
.maintext a.service_offer_cat_door{
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
.service_offer_cat_title{}
.service_offers_offers_wrap{
	border: 5px solid gray;
    border-top: none;
    border-bottom-left-radius: 8px;
    border-bottom-right-radius: 8px;
}
.service_offers_offers_content{}
.service_offer_wrap{
	padding: 10px;
    border-bottom: 2px solid gray;
	text-align:right;
	box-sizing: border-box;
	background: #f7f7f7;
}
.service_offer_wrap_th{
	border-bottom: 2px solid gray;
	padding:10px;
	
}
.service_offer_wrap .socol1{float:right; width:14%; }
.service_offer_wrap .socol2{float:right; width:48%; margin-right:2.5%; }
.service_offer_wrap .socol3{float:right; width:14.5%; margin-right:2.5%;}
.service_offer_wrap .socol4{float:right; width:14%; margin-right:2.5%;}
.service_offer_wrap::after{clear:both;content:'';display:block; } 

.service_offer_wrap_th .scoth:nth-child(1){float:right; width:14%; height:20px; }
.service_offer_wrap_th .scoth:nth-child(2){float:right; width:45%; margin-right:2.5%;padding-left:19px;}
.service_offer_wrap_th .scoth:nth-child(3){float:right; width:14.5%; margin-right:2.5%;}
.service_offer_wrap_th::after{clear:both;content:'';display:block;};


.service_offer_img{}
.service_offer_title{
	font-size: 18px;
    color: #2ea3f2;
    line-height: 18px;
}
.service_offer_summary{
	font-size: 13px;
    line-height: 16px;
	color:#666666;
}
.service_offer_price{
	font-size: 18px;
    color: #2ea3f2;
    line-height: 18px;
}
.service_offer_price_summary{
	font-size: 13px;
    line-height: 16px;
	color:#666666;
}
.service_offer_link{}
.mobile_service_offers_cat_wrap a .whitelink,.service_offers_cat_wrap a .whitelink{
    display: block;
    background: #2ea3f2;
    padding: 10px;
    white-space: nowrap;
    color: white;
    text-decoration: none;
    border-radius: 3px;
    text-align: center;
    font-weight: bold;
}

.service_offer_phone{}


/* service_offers mobile */

.service_offer_rightcol{float:right; width:40%;}
.service_offer_leftcol{
	float: left;
    margin-right: 16px;
    width: 51%;
    text-align: center;
}
.mobile_service_offers_cat_wrap .service_offer_title{color:#6b5f5f;}
.mobile_service_offers_cat_wrap .service_offer_price{
    font-size: 23px;
    line-height: 38px;		
}
.mobile_service_offers_cat_wrap .service_offer_img img{max-height:100px;}
.service_offers_cat_wrap a{text-decoration:none !important;}
.service_offer_phone img{vertical-align: middle;}
.service_offer_phone{color:gray;}
						</style>		
		<?php 
	}