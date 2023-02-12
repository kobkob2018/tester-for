<?php

/* 
* Copyright © 2010 ILbiz. All Rights Reserved
* email:	webmaster@ilbiz.co.il
*
* 
* the landing of the client site
*/
//http://il.php.net/manual/en/ref.errorfunc.php#errorfunc.constants.errorlevels.e-warning
	
	if(!isset($dataLDSetting['content_type'])){
		
		$dataLDSetting['content_type'] = $dataLDSetting['mailignList_contentPageID'];
	}	
	
	$Browser = detectBrowser();
	$browser_is_mobile =  preg_match("/(android|avantgo|blackberry|bolt|boost|cricket|docomo|fone|hiptop|mini|mobi|palm|phone|pie|tablet|up\.browser|up\.link|webos|wos)/i", $_SERVER["HTTP_USER_AGENT"]);
	$addMoreTitle = selectBrwoserTitle($data_words, $um, "1");
	$site_title = ( $data_settings['site_title'] != "" ) ? stripslashes($data_settings['site_title']) : "";
	$addMoreTitle = ( !empty($addMoreTitle) ) ? $addMoreTitle.", ".$site_title : $site_title;
	$keywords = str_replace("\"" , "" , stripslashes($data_settings['keywords']) );
	$description = str_replace("\"" , "" , stripslashes($data_settings['description']) );	
	$estimate_form_data = false;
	if (strpos($_SERVER['HTTP_USER_AGENT'],'WhatsApp') !== false){
		$page_title =  iconv("windows-1255","UTF-8", $addMoreTitle); 	
		echo "<!DOCTYPE HTML><html><head>";
		echo '<meta HTTP-EQUIV="Content-Type" CONTENT="text/html; charset=UTF-8">';		
		echo '<meta property="og:title" content="'.$page_title.'" />';	
		echo '<title>'.$page_title.'</title>';		
		echo '</head><body></body></html>';		
		exit;
	}
	if(isset($_REQUEST['aff_id'])){
		$dataLDSetting['show_phone'] = false;
	}	
	ob_start();
	
	?>	
	<!DOCTYPE HTML>
	<html>
		<head>

			<meta HTTP-EQUIV="Content-Type" CONTENT="text/html; charset=windows-1255">
			<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1" />	
			<title><?php echo $addMoreTitle; ?></title>
			<?php if( $description != "" ): ?>
				<META NAME="DESCRIPTION" CONTENT="<?php echo $description; ?>">
			<?php endif; ?>
			<?php if( $keywords != "" ): ?>
				<META NAME="KEYWORDS" CONTENT="<?php echo $keywords; ?>" >
			<?php endif; ?>
			<?php 
				$http_s = "http";
				if((!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') || $_SERVER['SERVER_PORT'] == 443){
					$http_s = "https";
				}				
			?>
			<script type="text/javascript" src="<?php echo $http_s; ?>://www.ilbiz.co.il/global_func/prototype.js"></script>
			<script type="text/javascript" src="<?php echo $http_s; ?>://ilbiz.co.il/ClientSite/version_1/style/bootstrap_2.3.2/jquery.min.js"></script>
			<script type="text/javascript">

				jQuery.noConflict();
				if (Prototype.BrowserFeatures.ElementExtensions) {
					var disablePrototypeJS = function (method, pluginsToDisable) {
							var handler = function (event) {
								event.target[method] = undefined;
								setTimeout(function () {
									delete event.target[method];
								}, 0);
							};
							pluginsToDisable.each(function (plugin) { 
								jQuery(window).on(method + '.bs.' + plugin, handler);
							});
						},
						pluginsToDisable = ['collapse', 'dropdown', 'modal', 'tooltip', 'popover'];
					disablePrototypeJS('show', pluginsToDisable);
					disablePrototypeJS('hide', pluginsToDisable);
				}
			</script>	
			
			<script src="<?php echo $http_s; ?>://ilbiz.co.il/ClientSite/version_1/style/bootstrap_2.3.2/jquery.validate.js"></script>
			<?php if( $dataLDSetting['use_bootstrap'] != "" &&  $dataLDSetting['use_bootstrap'] != "0" ): ?>
				<link rel="stylesheet" href="<?php echo $http_s; ?>://ilbiz.co.il/ClientSite/version_1/style/bootstrap_2.3.2/bootstrap.min.css" type="text/css">
				<link rel="stylesheet" href="<?php echo $http_s; ?>://ilbiz.co.il/ClientSite/version_1/style/bootstrap_2.3.2/bootstrap.rtl.css" type="text/css">
				
				<link rel="stylesheet" href="<?php echo $http_s; ?>://ilbiz.co.il/ClientSite/version_1/style/bootstrap_2.3.2/bootstrap-responsive.min.css" type="text/css">
				<link rel="stylesheet" href="<?php echo $http_s; ?>://ilbiz.co.il/ClientSite/version_1/style/bootstrap_2.3.2/bootstrap-responsive.rtl.css" type="text/css">
				<link rel="stylesheet" href="<?php echo $http_s; ?>://ilbiz.co.il/ClientSite/version_1/style/bootstrap_2.3.2/rtl-xtra.min.css" type="text/css">
				<script src="<?php echo $http_s; ?>://ilbiz.co.il/ClientSite/version_1/style/bootstrap_2.3.2/bootstrap.min.js"></script>			
			<?php endif; ?>				
			<link rel="stylesheet" type="text/css" media="screen" href="<?php echo $http_s; ?>://ilbiz.co.il/ClientSite/version_1/landing_style_v2.php?unk=<?php echo UNK; ?>&ld=<?php echo $dataLDSetting['id']; ?>&v=<?php echo $cache_version; ?>">
			<link rel="stylesheet" href="<?php echo $http_s; ?>://ilbiz.co.il/ClientSite/version_1/style/bootstrap_2.3.2/bootstrap-datepicker.min.css" type="text/css">
			<script src="<?php echo $http_s; ?>://ilbiz.co.il/ClientSite/version_1/style/bootstrap_2.3.2/bootstrap-datepicker.min.js"></script>
			<script src="<?php echo $http_s; ?>://ilbiz.co.il/ClientSite/version_1/style/bootstrap_2.3.2/bootstrap-datepicker.he.min.js"></script>	
			<script type="text/javascript" src="https://apis.google.com/js/plusone.js">{lang: 'iw'}</script>
			
			<script type="text/javascript" src="<?php echo $http_s; ?>://www.ilbiz.co.il/ClientSite/js/ajax.js"></script>
			<?php /*
			<script type="text/javascript" src="<?php echo $http_s; ?>://www.ilbiz.co.il/ClientSite/js/scriptaculous.js?load=effects,builder"></script>
			<script type="text/javascript" src="<?php echo $http_s; ?>://www.ilbiz.co.il/ClientSite/js/lightbox.php?lang=he"></script>
			<link rel="stylesheet" href="<?php echo $http_s; ?>://www.ilbiz.co.il/ClientSite/js/lightbox_css.php?lang=he" type="text/css" media="screen">
			*/ ?>
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
			<?php if( $data_extra_settings['head_free_code'] != "" ): ?>
				<?php echo str_replace("´","'",stripslashes($data_extra_settings['head_free_code'])); ?>
			<?php endif; ?>
			<script type="text/javascript">
				function videoL( uid )
				{
					var url = 'ajax_landing.php?main=video&unk=<?=UNK;?>&uid=' + uid;
					new Ajax.Updater("playing_video" , url, {asynchronous:true});
				}	
				function videoML( uid )
				{
					var url = 'ajax_landing.php?main=video&ex=1&unk=<?=UNK;?>&uid=' + uid;
					new Ajax.Updater("playing_video2" , url, {asynchronous:true});
				}		
				function gotoLanding(landld)
				{
						var url = "ajax_landing.php?main=loadLandingModules&unk=<?=UNK;?>&ld=" + landld ;
						new Ajax.Updater("landingContent" , url, {evalScripts:true});
				}
			</script>
			<script src="<?php echo $http_s; ?>://ilbiz.co.il/ClientSite/version_1/style/js/estimate_form.js?v=<?php echo $cache_version; ?>"></script>
			<script type="text/javascript">
				
				function open_links(){
					this.scrltop = 0;
					jQuery(function($){
						if($("#mobile_open_button").attr("rel")!= "open"){
							$("#mobile_open_button").attr("rel","open");
							this.scrltop = $("#page_wrap").scrollTop();
							console.log("open");
							console.log(this.scrltop);
							$("#mobile_topSliceLinks_list").show();
						}
						else{
							$("#mobile_open_button").attr("rel","close");
							console.log("close");
							console.log(this.scrltop);
							$("#mobile_topSliceLinks_list").hide();								
						}
						
					});
					
				}
			</script>	
			<?php
				$head_free_html = $dataLDSetting['head_free_html'];
				$mobile_abpath_temp1 = SERVER_PATH."/new_images/landing/".$dataLDSetting['topslice_bg_mobile'];
				if( file_exists($mobile_abpath_temp1) && !is_dir($mobile_abpath_temp1) )
				{
					$mobile_top_slice_url = HTTP_PATH."/new_images/landing/".$dataLDSetting['topslice_bg_mobile'];
					$head_free_html = str_replace("mobile_bg_url",$mobile_top_slice_url,$head_free_html);
				}
				else{
					$head_free_html = str_replace("mobile_bg_url","",$head_free_html);
				}
			?>				
			<?php echo $head_free_html; ?>
			<style type="text/css">
			<?php if(!$dataLDSetting['show_phone']): ?>
				.phone-hours{display:none;}
			<?php endif; ?>
			</style>
			<?php if( $dataLDSetting['fb_audience_code'] != "" ): ?>
				<?php echo $dataLDSetting['fb_audience_code']; ?>
			<?php endif; ?>	
		
			
		</head>

		<body>
		
			<?php
				global $data_name;
				$ld_replace_blocks = array();
				$ld_messege = "";
				if(isset($_GET['ld_messege'])){
					$ld_messege = $_GET['ld_messege'];
					$ld_messege = "<p style='color: red;font-size: 22px;background: #ffc6c6;padding: 10px;'><b>".iconv("UTF-8","windows-1255", $ld_messege)."</b></p>";
				}
				$ld_replace_blocks['ld_messege'] = $ld_messege;					
				$ld_replace_blocks['text_1'] = stripslashes($dataLDSetting['text_1']);
				$ld_replace_blocks['text_2'] = stripslashes($dataLDSetting['text_2']);
				$ld_replace_blocks['text_3'] = stripslashes($dataLDSetting['text_3']);
				$fb_share_pos = $dataLDSetting['fb_share_pos'];
				if($fb_share_pos == '-1'){
					$ld_replace_blocks['fb_share'] = "";
				}
				else{
					$ld_replace_blocks['fb_share'] = get_html_function('put_fb_share_v2');
				}
				$ld_replace_blocks['estimate_form'] = get_html_function('put_estimate_form_v2');
				if($dataLDSetting['add_contract'] != "" && $dataLDSetting['add_contract'] != "0"){
					$ld_replace_blocks['contract_form'] = get_html_function('put_contract_form_v2');
				}
				$ld_replace_blocks['estimate_form_text'] = get_html_function('put_estimate_form_text_v2');
				$ld_replace_blocks['bottom_copyright'] = get_html_function('put_bottom_copyright_ld');
				$ld_replace_blocks['ld_content'] = get_html_function('put_ld_content_ld');
				$ld_replace_blocks['top_links'] = get_html_function('put_top_links_ld');
				$ld_replace_blocks['home_url'] = "http://".$_SERVER['HTTP_HOST'];
				$ld_replace_blocks['logo_url'] = "";
				$ld_replace_blocks['logo'] = "";
				$ld_replace_blocks['logo_wrap'] = "";
				$ld_replace_blocks['nbsp'] = "&nbsp;";
				
				$ld_replace_blocks['top_slice_url'] = "";
				$ld_replace_blocks['top_slice'] = "";
				$ld_replace_blocks['top_slice_wrap'] = "";
				$ld_replace_blocks['mobile_top_slice_url'] = "";
				$ld_replace_blocks['mobile_top_slice'] = "";
				$ld_replace_blocks['mobile_top_slice_wrap'] = "";


				$logo_abpath_temp1 = SERVER_PATH."/new_images/landing/".$dataLDSetting['topslice_logo'];
				if( file_exists($logo_abpath_temp1) && !is_dir($logo_abpath_temp1) )
				{
					
					$logo_url = HTTP_PATH."/new_images/landing/".$dataLDSetting['topslice_logo'];
					$logo = '<img src="'.$logo_url.'" title="'.$addMoreTitle.'" />';
					$logo_wrap = '<div class="site_logo">'.$logo.'</div>';
					$ld_replace_blocks['logo_url'] = $logo_url;
					$ld_replace_blocks['logo'] = $logo;
					$ld_replace_blocks['logo_wrap'] = $logo_wrap;
				}	
				
				$abpath_temp1 = SERVER_PATH."/new_images/landing/".$dataLDSetting['topslice_bg'];
				if( file_exists($abpath_temp1) && !is_dir($abpath_temp1) )
				{
					$top_slice_url = HTTP_PATH."/new_images/landing/".$dataLDSetting['topslice_bg'];
					$top_slice = '<img src="'.$top_slice_url.'" title="'.$addMoreTitle.'" />';
					$top_slice_wrap = '<div class="topslice_logo">'.$top_slice.'</div>';
					$ld_replace_blocks['top_slice_url'] = $top_slice_url;
					$ld_replace_blocks['top_slice'] = $top_slice;
					$ld_replace_blocks['top_slice_wrap'] = $top_slice_wrap;
				}				

				$mobile_abpath_temp1 = SERVER_PATH."/new_images/landing/".$dataLDSetting['topslice_bg_mobile'];
				if( file_exists($mobile_abpath_temp1) && !is_dir($mobile_abpath_temp1) )
				{
					$mobile_top_slice_url = HTTP_PATH."/new_images/landing/".$dataLDSetting['topslice_bg_mobile'];
					$mobile_top_slice = '<img style="width:100%;" src="'.$mobile_top_slice_url.'" title="'.$addMoreTitle.'" />';
					$mobile_top_slice_wrap = '<div class="mobile_logo">'.$mobile_top_slice.'</div>';
					$ld_replace_blocks['mobile_top_slice_url'] = $mobile_top_slice_url;
					$ld_replace_blocks['mobile_top_slice'] = $mobile_top_slice;
					$ld_replace_blocks['mobile_top_slice_wrap'] = $mobile_top_slice_wrap;
				}
				
				$main_html_full = get_html_function('put_html_skaleton_v2');
				if(strpos($main_html_full, '{{e_card_register_form}}') !== false){
					require_once("modules/e_card.php");
					$ld_replace_blocks['e_card_register_form'] = get_html_function('e_card_register_form');					
				}				
				$browser_type_remove = "mobile";
				$browser_is_desktop = true;
				if($browser_is_mobile){
					$browser_type_remove = "desktop";
					$browser_is_desktop = false;
				}				
				$main_html_arr = explode("<!--".$browser_type_remove."_only-->",$main_html_full);
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
				foreach($ld_replace_blocks as $search=>$replace){
					$main_html = str_replace("{{".$search."}}",$replace,$main_html);
				}
				if($_SERVER['HTTP_HOST'] == 'cityportal.ilbiz.co.il' && isset($_SESSION['gl_source'])){
					//unset($_SESSION['gl_source']);
					//var_dump($gl_source);
					//exit();
				}
				global $gl_source;
				$campaign_type = '0';
				if($gl_source['has_gclid'] != '0'){
					$campaign_type = $gl_source['has_gclid'];
				}
							
				if($estimate_form_data['form_data']['cat_spec'] == '0' && $estimate_form_data['form_data']['subCat'] == '0' && $estimate_form_data['form_data']['primeryCat'] == '0'){
					$data_name['phone_to_show'] = $data_name['phone'];
					if($campaign_type == '1'){
						if( $data_name['gl_campaign_phone'] != ""){
							$data_name['phone_to_show'] = $data_name['gl_campaign_phone'];
						}
					}
					if($campaign_type == '2'){
						if( $data_name['fb_campaign_phone'] != ""){
							$data_name['phone_to_show'] = $data_name['fb_campaign_phone'];
						}
					}					
				}
				else{
					$data_name['phone_to_show'] = $estimate_form_data['cat_phone'];
					if($campaign_type == '1'){
						if( $estimate_form_data['gl_campaign_phone'] != ""){
							$data_name['phone_to_show'] = $estimate_form_data['gl_campaign_phone'];
						}
					}
					if($campaign_type == '2'){
						if( $estimate_form_data['fb_campaign_phone'] != ""){
							$data_name['phone_to_show'] = $estimate_form_data['fb_campaign_phone'];
						}
					}					
				}				
				$phone_to_show = $data_name['phone_to_show'];
				$whatsapp_button_html = "";
				
				$main_html = str_replace("{{cat_phone}}",$phone_to_show,$main_html);
			?>			
			
			<div id="fb-root"></div>
			<script type="text/javascript">
			  window.fbAsyncInit = function() {FB.init({appId: '', status: true, cookie: true, xfbml: true});};
			  (function() {
				var e = document.createElement('script'); e.async = true;
				e.src = document.location.protocol + '//connect.facebook.net/en_US/all.js';
				document.getElementById('fb-root').appendChild(e);
			  }());
			</script>

			<?php print($main_html); ?>
		<?php if(isset($tracking_url)): ?>
			<?php if($c_tracking_on): ?>
				<iframe src="<?php echo $tracking_url; ?>" scrolling="no" frameborder="0" width="1" height="1"></iframe>
			<?php endif; ?>
			<p id="tracking_iframe_holder"></p>
			<script type="text/javascript">
				function tracking_form_send(estimateFormId,customer_send){
					<?php if($c_tracking_on): ?>
					var form_tracking_pixel = '<iframe src="<?php echo $form_tracking_url; ?>&estimateFormId='+estimateFormId+'&c_send='+customer_send+'" scrolling="no" frameborder="0" width="1" height="1"></iframe>'; 
					
					var track_holder = document.createElement('span');
					track_holder.innerHTML = form_tracking_pixel;
					var holder_wrap = document.getElementById("tracking_iframe_holder");
					holder_wrap.appendChild(track_holder);
					<?php else: ?>
						return;
					<?php endif; ?>
				}
				function tracking_phone_landing_send(){
					<?php if($c_tracking_on): ?>
						var phone_tracking_pixel = '<iframe src="<?php echo $tracking_url; ?>&phone_called=1&is_landing=1" scrolling="no" frameborder="0" width="1" height="1"></iframe>'; 
						
						var track_holder = document.createElement('span');
						track_holder.innerHTML = phone_tracking_pixel;
						var holder_wrap = document.getElementById("tracking_iframe_holder");
						holder_wrap.appendChild(track_holder);
					<?php else: ?>
						return;
					<?php endif; ?>
				}
				<?php if($c_tracking_on): ?>
					jQuery(document).ready(function(){
						jQuery('a[href^="tel:"]').click(function(){
							tracking_phone_landing_send();
						});
					});	
				<?php endif; ?>
			</script>
		<?php endif; ?>			
			<?php if($data_extra_settings['negishut_version'] == '1'): ?>
				<script src="<?php echo $http_s; ?>://ilbiz.co.il/ClientSite/version_1/style/js/negishut.js"></script>
				<link rel="stylesheet" type="text/css" media="screen" href="<?php echo $http_s; ?>://ilbiz.co.il/ClientSite/version_1/style/negishut_style.css" />
				<div id="negishut_wrap" class="negishut-wrap" style="display:none" >
					<div id="negishut_door">
						<a href="javascript://" onclick="open_negishut_menu()"><span id="negishut_door_text">נגישות</span></a>
					</div>
					<div id="negishut-content">
						<div id="close_negishut_x">
							<a href="javascript://" onclick="open_negishut_menu()">סגור תפריט נגישות</a>
						</div>
						<div id="negishut-content-inner">
							<h4>תפריט נגישות</h4>
							<ul id="negishut_options">
								<li class="negishut-title">גודל פונט</li>
								<li id="negishut_font_bigger" class="negishut-item">
									<a href="javascript://" onclick="negishut_font_bigger()">הגדל פונט</a>
								</li>
								<li id="negishut_font_smaller" class="negishut-item">
									<a href="javascript://" onclick="negishut_font_smaller()">הקטן פונט</a>
								</li>
								<li class="negishut-title">ניגודיות צבעים</li>
								<li id="negishut_contrast_0" class="negishut-item">
									<a href="javascript://" onclick="negishut_contrast(0)">ניגודיות ברירת מחדל</a>
								</li>
								<li id="negishut_contrast_2" class="negishut-item">
									<a href="javascript://" onclick="negishut_contrast(2)">ניגודיות גבוהה</a>
								</li>
								<li id="negishut_contrast_1" class="negishut-item">
									<a href="javascript://" onclick="negishut_contrast(1)">ניגודיות הפוכה</a>
								</li>
								
								<?php /*
								<li class="negishut-title">קיצורי דרך לאזורי תוכן</li>
								<li id="negishut_goto_main" class="negishut-item">
									<a href="javascript://" onclick="negishut_goto('center_main_content')">עבור לאזור תוכן מרכזי</a>
								</li>	
								<li id="negishut_goto_top_menu" class="negishut-item">
									<a href="javascript://" onclick="negishut_goto('page_fixed_top')">עבור לתפריט עליון</a>
								</li>
								<li id="negishut_goto_top_menu" class="negishut-item">
									<a href="javascript://" onclick="negishut_goto('search_form')">עבור לחיפוש</a>
								</li>	
								<li id="negishut_goto_top_menu" class="negishut-item">
									<a href="javascript://" onclick="negishut_goto('right_nav')">עבור לתפריט משני</a>
								</li>				
								*/ ?>
								<li class="negishut-title">הבהובים ותנועה</li>
								<li id="stop_news_marquee" class="negishut-item">
									<a href="javascript://" onclick="stop_news_marquee()">הפסקת הבהובים ותנועה</a>
								</li>	
								<li id="run_news_marquee" class="negishut-item">
									<a href="javascript://" onclick="run_news_marquee()">הפעלת הבהובים ותנועה</a>
								</li>					
							</ul>
						</div>
					</div>
				</div>
				<script type="text/javascript">
					var negishut_date = new Date();
					negishut_date.setMonth(negishut_date.getMonth() + 12);
					var negishut_domain = "<?php echo $_SERVER['HTTP_HOST']; ?>";
					show_negishut();
				</script>	
			<?php endif; ?>

			<?php if( $data_extra_settings['wibiyaAnalytics'] != '' ): ?>
				<?php echo str_replace("´","'",stripslashes($data_extra_settings['wibiyaAnalytics'])); ?>
			<?php endif; ?>
			<?php echo str_replace("´","'",stripslashes($data_name['googleAnalytics'])); ?>

			<?php if( $data_extra_settings['remartiking_code'] != "" ): ?>
				<?php echo str_replace("´","'",$data_extra_settings['remartiking_code']); ?>
			<?php endif; ?>
			<?php if( $data_extra_settings['BottomSliceHtml_landing'] != "" ): ?>
				<?php echo str_replace("´","'",$data_extra_settings['BottomSliceHtml_landing']); ?>
			<?php endif; ?>
		</body>
	</html><?php

	$page_content = ob_get_clean();
	$page_content_arr = explode("{{service_offers",$page_content);
	if(!isset($page_content_arr[1])){
		echo $page_content_arr[0];
		
	}
	else{
		require_once("modules/service_offers.php");
		$offer_block_id = 0;
		foreach($page_content_arr as $page_content_part){
			$page_content_part_arr =  explode("service_offers}}",$page_content_part);
			if(!isset($page_content_part_arr[1])){
				echo $page_content_part_arr[0];
			}
			else{
				$offer_cat_temp = $page_content_part_arr[0];
				$offer_cat = trim($offer_cat_temp);
				add_service_offer_cat($offer_cat,$offer_block_id);
				echo $page_content_part_arr[1]; 
			}
			$offer_block_id++;
		}
		add_service_offers_js();
		add_service_offers_landing_style();
	}	

function put_top_links_ld(){
	global $dataLDSetting;
	?>
	<div class="topSliceLinks">
		<ul class="top-nav nav">
				<?
					$sql = "SELECT * FROM sites_landingPage_links WHERE deleted=0 AND landing_id='".$dataLDSetting['id']."' AND unk = '".UNK."' ORDER BY place";
					$resLinks = mysql_db_query(DB,$sql);
					
					while( $dataLinks = mysql_fetch_array($resLinks) )
					{
						if( $dataLinks['link_target'] == "ajax" )
						{
							$ex_link = explode("?ld=" , $dataLinks['link_url'] );
							$url = "javascript:gotoLanding(\"".$ex_link[1]."\")";
						}
						elseif( eregi( "http://" , $dataLinks['link_url'] ) )
							$url = $dataLinks['link_url'];
						else
							$url = "http://".$dataLinks['link_url'];
						
						$target = ( $dataLinks['link_target'] != "ajax" ) ? "target='".$dataLinks['link_target']."'" : "";
						$a_start = ( $dataLinks['link_url'] != "" ) ? "<a href='".$url."' ".$target." style='color: #".$dataLinks['link_color']."; '>" : "";
						$a_end = ( $dataLinks['link_url'] != "" ) ? "</a>" : "";
						
						$link_size = ( $dataLinks['link_url'] != "" ) ? "font-size: ".$dataLinks['link_size']."px;" : "";
						echo "<li id='top_link_".$dataLinks['id']."' text-decoration:none;'>".$a_start.stripslashes($dataLinks['link_name']).$a_end."</li>";
					}
				?>
		</ul>
	</div>
	<?php
}

function put_bottom_copyright_ld(){
	bottom_copyright(true);
}


function put_ld_content_ld(){
	global $dataLDSetting;
	?>
				<div id="landingContent">
				<?
					$sql = "SELECT * FROM sites_landingPage_modules WHERE unk = '".UNK."' AND landing_id = '".$dataLDSetting['id']."' AND deleted=0 ORDER BY place , id";
					$resModules = mysql_db_query(DB,$sql);
					
					echo "<table border=\"0\" width=100% cellspacing=\"0\" cellpadding=\"0\" class=\"maintext\">";
					$module_index = 0;
						while( $dataModules = mysql_fetch_array($resModules) )
						{
							$bgColor = ( $dataModules['bgColor'] != "" ) ? "bgcolor='#".$dataModules['bgColor']."' style='padding: 20px;'" : "";
							$fieldset_start = ( $dataModules['border_color'] != "" ) ? "<fieldset id='dims' style='border:1px solid #".$dataModules['border_color']."; padding: 20px;'><legend>" : "";
							$legend_end = ( $dataModules['border_color'] != "" ) ? "</legend>" : "";
							$fieldset_end = ( $dataModules['border_color'] != "" ) ? "</fieldset>" : "";
							
							if( $bgColor == "" && $fieldset_start == "" )
								$style = " style='padding: 20px;'";
							else
								$style = "";
							
							$abpath_temp2 = SERVER_PATH."/new_images/landing/".$dataModules['title_icon'];
							if( file_exists($abpath_temp2) && !is_dir($abpath_temp2) )
								$titeIcon = "<img src=\"".HTTP_PATH."/new_images/landing/".$dataModules['title_icon']."\" border=0 style='padding-left: 20px;'>";
							else
								$titeIcon = "";
							
							$headline_style = "font-family: Tahoma,arial; font-size: ".$dataModules['title_size']."px; color: #".$dataModules['title_color'].";";
							$visibility_hidden_start = ( $dataModules['visibility_hidden'] == "1" ) ? "<a href='javascript:void(0)' onclick='document.getElementById(\"open_mu_".$dataModules['id']."\").style.display=\"\"' style='".$headline_style." outline: none; '>" : "";
							$visibility_hidden_end = ( $dataModules['visibility_hidden'] == "1" ) ? "</a>" : "";
							$hide_module = ( $dataModules['visibility_hidden'] == "1" ) ? "style='display: none;'" : "";
							$hide_module_text = ( $dataModules['visibility_hidden'] == "1" ) ? "<span style='font-size:10px;'> - לפרטים נוספים אנא לחצו על הכותרת</span>" : "";
							
							echo "<tr><td height=5 colspan=3 class='td-padder-ver'></td></tr>";
							echo "<tr>";
								echo "<td width=10 class='td-padder-hor'></td>";
								echo "<td ".$bgColor.$style." align=right ".$padding_headline." >";
									echo $fieldset_start.$visibility_hidden_start.$titeIcon.$visibility_hidden_end."<span style='".$headline_style."'><b>".$visibility_hidden_start.stripslashes($dataModules['module_title']).$visibility_hidden_end."</b>".$hide_module_text."</span>".$legend_end;
									echo "<table border=\"0\" width=100% cellspacing=\"0\" cellpadding=\"0\" class=\"maintext\" ".$hide_module." id='open_mu_".$dataModules['id']."'>";
										echo "<tr>";
											echo "<td>";
												echo "<div class='part-wrap'>";
												echo "<table border=\"0\" width=100% cellspacing=\"0\" cellpadding=\"0\" class=\"maintext\">";
													
													$sql = "SELECT * FROM sites_landingPage_paragraph WHERE unk = '".UNK."' AND landing_id = '".$dataLDSetting['id']."' AND module_id = '".$dataModules['id']."' AND deleted=0 ORDER BY place, id";
													$resParagraph = mysql_db_query(DB,$sql);
													
													while( $dataParagraph = mysql_fetch_array($resParagraph) )
													{
														
														switch( $dataParagraph['module_type'] )
														{
															case "0" :
																echo "<tr><td height=7></td></tr>";
																echo "<tr>";
																	echo "<td>".stripslashes($dataParagraph['p_text'])."</td>";
																echo "</tr>";
																echo "<tr><td height=7></td></tr>";
															break;
															
															case "1" :
																$vidValue = explode( "|" , $dataParagraph['p_text'] );
																
																if( $vidValue[0] != "" ) 
																{

																	echo "<div class='videodiv' ><div class='videoWrapper' >
																			<div id='playing_video' style='border: 1px solid #".$dataModules['title_color'].";'>
																			
																				<script>videoL(\"".$vidValue[0]."\")
																				</script>
																			</div></div>
																		";
																
																	echo "<div><a href='index.php?m=vi' class='landing_link'>צפה בהכל</a></div>";
																	echo "</div>";			
																					
																	echo "<div class='videolist' >";					
																	for( $vid=0 ; $vid<=3 ; $vid++ )
																	{
																		if( $vidValue[$vid] != "" )
																		{
																			$sql = "SELECT id, name, img, summary FROM user_video WHERE unk = '".UNK."' AND deleted=0 AND id = '".$vidValue[$vid]."' ";
																			$resVid = mysql_db_query(DB,$sql);
																			$dataVid = mysql_fetch_array($resVid);
																			
																			$abpath_temp = SERVER_PATH."/video/".$dataVid['img'];
																			
																				echo "<div class='landing_text small-vid'>";
																					if( file_exists($abpath_temp) && !is_dir($abpath_temp) )
																						echo "<img src='video/".$dataVid['img']."' border='0' style='border: 1px solid #".$dataModules['title_color'].";'>";
															
																					
																						
																							echo "<div style='color: #".$dataModules['title_color']."; font-size: 14px;'>".stripslashes($dataVid['name'])."</div>";
																							echo "<div class='landing_link'><a href='javascript:void(0)' onclick='videoL(\"".$dataVid['id']."\")' class='landing_link'>צפה</a></div>";
																				echo "</div>";
																		}
																	}
																	echo "</div>";
																}
															break;
															
															case "2" :
																if( $dataParagraph['p_text'] != "" )
																{
																	echo "<tr><td height=7></td></tr>";
																	echo "<tr>";
																		echo "<td><div class='videoWrapper'><div id='playing_video2' style='border: 1px solid #".$dataModules['title_color'].";'><script>videoML(\"".$dataParagraph['p_text']."\")</script></div></div></td>";
																	echo "</tr>";
																	echo "<tr><td height=7></td></tr>";
																}
															break;
															
															case "3" :
																$imgValue = explode( "|" , $dataParagraph['p_text'] );
																
																if( $imgValue[0] != "" ) 
																{
																echo "<tr><td height=7></td></tr>";
																echo "<tr>";
																	echo "<td align=center>";
																		echo "<div class='galery'>";
																			$counter = 0;
																			for( $img=0 ; $img<=8 ; $img++ )
																			{
																				if( $imgValue[$img] != "" )
																				{
																					$sql = "select * from user_gallery_images where unk = '".UNK."' and deleted = '0' AND id = '".$imgValue[$img]."' ";
																					$resImg = mysql_db_query(DB,$sql);
																					$dataImg = mysql_fetch_array($resImg);
																					
																					//if( $counter%4 == 0 ) 
																						echo "<div class='galery-img'>";
																								$abpath_temp_unlink = SERVER_PATH."/gallery/".$dataImg['img'];
																								$abpath_temp_unlinkl = SERVER_PATH."/gallery/L".$dataImg['img'];
																								
																								$exist_img = ( $counter == 1 ) ? "thumbnail2" : "thumbnail";
																								if( file_exists($abpath_temp_unlink) && !is_dir($abpath_temp_unlink) )
																								{
																									$content = ( $dataImg['content'] != "" ) ? "title='".nl2br(htmlspecialchars(stripslashes($dataImg['content'])))."'" : "";
																									echo "<a href=\"".HTTP_PATH."/gallery/L".$dataImg['img']."\"  rel=\"fancy_image\" ".$content." ><img src=\"".HTTP_PATH."/gallery/".$dataImg['img']."\" rel=\"lightbox\" border=\"0\"></a>";
																								}
																							echo "</div>";
																					
																					$counter++;
																					
																					//if( $counter%4 == 0 )
																						//echo "</tr><tr><td colspan=10 height=15></td></tr>";
																					//else
																						//echo "<td width=15></td>";
																						
																				}
																				
																			}
																			
																		echo "</div>";
																	echo "</td>";
																echo "</tr>";
																echo "<tr><td height=7></td></tr>";
																}
															break;
															
															case "4" :
																if( $dataParagraph['p_text'] == "1" )
																{
																	echo "<tr><td height=7></td></tr>";
																	echo "<tr>";
																		echo "<td align=center>";
																			contact("1");
																		echo "</td>";
																	echo "</tr>";
																	echo "<tr><td height=7></td></tr>";
																}
																elseif( $dataParagraph['p_text'] == "2" )
																{
																	echo "<tr><td height=7></td></tr>";
																	echo "<tr>";
																		echo "<td align=center>";
																			echo "<table border='0' cellpadding='0' cellspacing='0' class='maintext' width=100%>";
																				
																			
																			$sql = "SELECT mailing_id,content FROM content_pages WHERE id = '".$dataLDSetting['mailignList_contentPageID']."' ";
																			$resMailing = mysql_db_query(DB,$sql);
																			$dataMailing = mysql_fetch_array($resMailing);
																			
																			if( $dataMailing['mailing_id'] != "" && $dataMailing['mailing_id'] != "0" )
																			{
																				if(isset($_GET['test'])){
																					echo "-----".$dataMailing['mailing_id']."----";
																					
																				}
																				echo "<tr>";
																					echo "<td valing=top align=right><div class='leftfloat mailing-iframe'>";
																						echo "<iframe src='http://www.ilbiz.co.il/newsite/net_system/netMailing.php?unk=".UNK."&amp;mailing_id=".$dataMailing['mailing_id']."&amp;td=".$dataLDSetting['mailignList_contentPageID']."&mini=1&version=1' width='100%' height='380px' id='loginPage2' frameborder=0 scrolling=no allowtransparency='true'></iframe>";
																					echo "</div>
																					<div class='mailing-content'>".$dataMailing['content']."</div>
																					</td>";
																				echo "</tr>";
																			}
																			echo "</table>";
																		echo "</td>";
																	echo "</tr>";
																	echo "<tr><td height=7></td></tr>";
																}
															break;
															
															case "5" :
																echo "<tr><td height=7></td></tr>";
																echo "<tr>";
																	echo "<td align=center>";
																		put_estimate_form();
																	echo "</td>";
																echo "</tr>";
																echo "<tr><td height=7></td></tr>";
															break;
															
															
															case "6" :
																echo "<tr><td height=20></td></tr>";
																echo "<tr>";
																	echo "<td align=center style='padding-right: 10px;'>";
																		echo "<table border='0' cellpadding='0' cellspacing='0' class='maintext' width=100%>";
																			echo "<tr>";
																				echo "<td>".stripslashes($dataParagraph['p_text'])."</td>";
																			echo "</tr>";
																			echo "<tr><td height=10></td></tr>";
																			echo "<tr>";
																				echo "<td><div style='overflow:hidden;'>";
																					echo '<div style="float:right;"><iframe src="//www.facebook.com/plugins/like.php?href=http%3A%2F%2Fwww.10service.co.il%2Flanding.php%3Fld%3D48&amp;send=false&amp;layout=standard&amp;width=200&amp;show_faces=false&amp;action=like&amp;colorscheme=light&amp;font=tahoma&amp;height=35" scrolling="no" frameborder="0" style="border:none; overflow:hidden; height:35px;" allowTransparency="true"></iframe></div>';
																							
																							echo '<div style="float:right;"><g:plusone size="medium" annotation="inline" width="120" href="http://www.10service.co.il/landing.php?ld=48"></g:plusone></div>';
																						
																				echo "</div></td>";
																			echo "</tr>";
																			
																			$abpath_temp2 = SERVER_PATH."/new_images/landing/".$dataParagraph['contact_bottom_bg'];
																			if( file_exists($abpath_temp2) && !is_dir($abpath_temp2) )
																			{
																				$im_size = GetImageSize ($abpath_temp2); 
																				$imageWidth = $im_size[0]; 
																				$imageHeight = $im_size[1];
																				
																				$contact_bottom_bg = "background:url(".HTTP_PATH."/new_images/landing/".$dataParagraph['contact_bottom_bg'].");";
																			}
																			
																			$_SESSION['user_contact_form'] = "";
	
																			$_SESSION['user_contact_form']['unk'] = "asc".rand(10000,15000);
																			$_SESSION['user_contact_form']['name'] = "ged".rand(15000,20000);
																			$_SESSION['user_contact_form']['email'] = "pok".rand(20000,25000);
																			$_SESSION['user_contact_form']['phone'] = "ujk".rand(25000,3000);
																			$_SESSION['user_contact_form']['content'] = "gdv".rand(40000,45000);
																			$_SESSION['user_contact_form']['date_in'] = "cve".rand(45000,50000);
																			
																			$form_text_color = ( $dataParagraph['text_form_color'] != "" ) ? "style='color: #".$dataParagraph['text_form_color'].";'" : "";
																			
																			// contact
																			echo "<tr>";
																				echo "<td>";
																					echo "<div style='".$contact_bottom_bg."'>";
																							echo "<form action='index.php' method='post' name='formC' style='padding: 0px; margin: 0px;'>";
																							echo "<input type='hidden' name='m' value='insert_contact'>";
																							echo "<input type='hidden' name='ext' value='1'>";
																							echo "<input type='hidden' name='".$_SESSION['user_contact_form']['unk']."' value='".UNK."'>";
																							echo "<input type='hidden' name='".$_SESSION['user_contact_form']['date_in']."' value='".GlobalFunctions::get_timestemp()."'>";
																								echo "<div>";
																											echo "<div class='maintext comb-form' ".$form_text_color.">";
																												echo "<div class='form-group'>";
																													echo "<div class='form-title'>שם מלא </div>";
																													echo "<div class='form-input'><input type='text' name='".$_SESSION['user_contact_form']['name']."' class='input_style'></div>";
																												echo "</div>";
																												echo "<div class='form-group'>";
																													echo "<div class='form-title'>שם העסק</div>";
																													echo "<div class='form-input'><input type='text' name='".$_SESSION['user_contact_form']['content']."' class='input_style'></div>";
																												echo "</div>";
																													echo "<div class='form-group'>";
																														echo "<div class='form-title'>דואר אלקטרוני </div>";
																														echo "<div class='form-title'><input type='text' name='".$_SESSION['user_contact_form']['email']."' class='input_style'></div>";
																													echo "</div>";
																												echo "<div class='form-group'>";
																													echo "<div class='form-title'>טלפון</div>";
																													echo "<div class='form-title'><input type='text' name='".$_SESSION['user_contact_form']['phone']."' class='input_style'></div>";
																												echo "</div>";
																											echo "</div>";
																										
												
																											echo "<div class='submit-group'>";
																											$abpath_temp2 = SERVER_PATH."/new_images/landing/".$dataParagraph['contact_submit_botton'];
																											if( file_exists($abpath_temp2) && !is_dir($abpath_temp2) )
																												echo "<input type='image' src='/new_images/landing/".$dataParagraph['contact_submit_botton']."'>";
																											else
																												echo "<input type='submit' value='שליחה' class='submit_style'>";
																											echo "</div>";
																										echo "</div><div style='clear:both;'></div>";
																								echo "</form>";
																							echo "</div>";	
																				echo "</td>";
																			echo "</tr>";
																			
																		echo "</table>";
																	echo "</td>";
																echo "</tr>";
																echo "<tr><td height=7></td></tr>";
																



																
															break;
														}
														
														
													}
													echo "</div>";
												echo "</table>";
												
											echo "</td>";
										echo "</tr>";
									echo "</table>";
									echo $fieldset_end;
								echo "</td>";
								echo "<td width=10  class='td-padder-hor'></td>";
							echo "</tr>";
							echo "<tr><td height=5 colspan=3 class='td-padder-ver'></td></tr>";
							$module_index++;
						}
					echo "</table>";
				?>
				</div>	
	<?php				
	
}