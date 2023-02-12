<?php

/* 
* Copyright © 2010 ILbiz. All Rights Reserved
* email:	webmaster@ilbiz.co.il
*
* 
* the landing of the client site
*/
//http://il.php.net/manual/en/ref.errorfunc.php#errorfunc.constants.errorlevels.e-warning
	
function get_html_function($function_name){
	ob_start();
	$function_name();
	return ob_get_clean();
}

function put_html_skaleton_v2(){
	global $dataLDSetting;
	$skaleton = trim($dataLDSetting['html_skaleton']);
	if($skaleton != ""){
		echo $skaleton;
		return;
	}
	?>
	<div id="page_wrap">	
		<div id="header">
			<div id="page">				
				<div id="topSliceBack">
					<div id="topSliceText1">{{text_1}}</div>
					<div id="topSliceText2">{{text_2}}</div>
					<div id="topSliceText3">{{text_3}}</div>
				</div>
			</div>

			
			
			<div id="mobile_page">
					{{mobile_top_slice_wrap}}
					<div id="mobile_topSliceBack">
						<div id="mobile_topSliceText1">{{text_1}}</div>
						<div id="mobile_topSliceText2">{{text_2}}</div>
						<div id="mobile_topSliceText3">{{text_3}}</div>
					</div>
			
			</div>
			<div class="estimate-form-and-text">
				<div id="estimate_form_form">
					{{estimate_form}}
				</div>
				<div id="estimate_form_text">
					{{estimate_form_text}}
				</div>
			</div>

			<div class="header-bottom"></div>
		</div>
		<div id="fb_share_wrap">{{fb_share}}</div>
	</div>
	<?php
}

function put_fb_share_v2(){
	?>
	<div id="fb_share">
		<div style='z-index:-9999;'>
			<iframe src="//www.facebook.com/plugins/like.php?href=http://<?php echo $_SERVER[SERVER_NAME].$_SERVER[REQUEST_URI]; ?>&amp;send=false&amp;layout=standard&amp;width=450&amp;show_faces=false&amp;action=like&amp;colorscheme=light&amp;font&amp;height=35" scrolling="no" frameborder="0" style="border:none; overflow:hidden; height:35px;" allowTransparency="true"></iframe>
		</div>			
		<script type="text/javascript">
			var addthis_config = {
				data_track_clickback: true
			}
		</script>		
	</div>
	<?
}

function put_estimate_form_v2(){
	global $dataLDSetting,$estimate_form_data;
	?>
	<div class='landing-estimate-form'>
		<?php
			if(!$estimate_form_data['form_active']){
				$estimate_form_data = estimate_form_html($dataLDSetting['content_type'] , "1"); 
			}
			else{
				if(isset($dataLDSetting['content_type'])){
					$estimate_form_data = estimate_form_html($dataLDSetting['content_type'] , "1"); 
				}
			}
		?>
	</div>	
	<?php		
}

function put_estimate_form_text_v2(){
	global $dataLDSetting;
	if(isset($dataLDSetting['content_page'])){
		echo $dataLDSetting['content_page'];
	}
	$data_estimate = get_data_estimate($dataLDSetting['content_type']);
	?>
	<div class='estimate-form-text'>
		<?php echo stripslashes($data_estimate['content']); ?>
	</div>
	<?php																		
}
function put_search_form_v2(){
	global $word;
	?>
	<div class="right-item well search-form">
		<form action="index.php" method="get" name="search_form" id="search_form">
			<input type="hidden" name="m" value="search" />
				<input type="text" name="search_val" class="search-input" />
				<input type="submit" value="<?php echo $word[LANG]['1_3_search_submit']; ?>" class="search-submit" />
		</form>
	</div>
	<?php
}

function put_contract_form_v2(){
	require_once('/home/ilan123/domains/ilbiz.co.il/public_html/ClientSite/version_1/functions/contract_functions.php');
	require_once("/home/ilan123/domains/ilbiz.co.il/public_html/global_func/class.phpmailer.php");
	global $dataLDSetting;
	work_contract_form($dataLDSetting['add_contract']);
}