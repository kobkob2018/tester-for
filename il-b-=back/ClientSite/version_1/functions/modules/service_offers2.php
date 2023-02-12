<?php
	function add_service_offer_cat($offer_cat,$block_id){
		global $browser_is_mobile;
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
		<div class="service_offers_cat_wrap" id="service_offers_cat_block_<?php echo $block_id; ?>" rel="closed">
			<a href="javascript://" class='service_offer_cat_door row-fluid' rel="<?php echo $block_id; ?>">
				<div class="service_offer_cat_title span12">
					<?php echo $cat_info['title']; ?>
				</div>
			</a>
			<div class="service_offers_offers_wrap">
				<div class="service_offers_offers_content" style="display:none;">
					<?php foreach($offers as $offer): ?>
						<div class="service_offer_wrap row-fluid">	
							<div class="span2 socol1">
								<div class="service_offer_img">
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
							</div>
							<div class="span6  socol2">								
								<div class="service_offer_title">
									<?php echo $offer['name']; ?>
								</div>

								<div class="service_offer_summary">
									<?php echo $offer['summary']; ?>
								</div>
							</div>
							<div class="span2  socol3">								
								<div class="service_offer_price">
									<?php echo $offer['price']; ?>
								</div>

								<div class="service_offer_price_summary">
									<?php echo $offer['price_summary']; ?>
								</div>	
							</div>
							<div class="span2  socol4">
								<div class="service_offer_link">
									<a href="<?php echo $offer['url_link']; ?>" title='הזמן עכשיו'>
										order now
									</a>
									
								</div>
								<div class="service_offer_phone">
									<a href="tel:<?php echo $offer['service_phone']; ?>"><img src="<?php echo HTTP_S; ?>://ilbiz.co.il/ClientSite/version_1/style/image/phone.png"  width="23px" alt="" /></a>
								</div>
							</div>
							<?php /*
							<div style="clear:both;"></div>
							*/ ?>
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
						}
					});
				});
			});
		</script>
		<?php
	}
	