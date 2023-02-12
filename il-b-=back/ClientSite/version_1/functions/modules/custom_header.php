<?php

/* 
* Copyright © 2010 ILbiz. All Rights Reserved
* email:	webmaster@ilbiz.co.il
*
* 
* the landing of the client site
*/
//http://il.php.net/manual/en/ref.errorfunc.php#errorfunc.constants.errorlevels.e-warning
	
?>
			<?php
				$ld_replace_blocks = array();
				$ld_messege = "";
				if(isset($_SESSION['ld_messege'])){
					$ld_messege = "<p style='color: red;font-size: 22px;background: #ffc6c6;padding: 10px;'><b>".$_SESSION['ld_messege']."</b></p>";
					unset($_SESSION['ld_messege']);
				}
				$ld_replace_blocks['ld_messege'] = $ld_messege;				
				$ld_replace_blocks['site_name'] = stripslashes($data_name['name']);
				$ld_replace_blocks['site_slogen'] = str_replace('"','&quot',stripslashes($data_settings['slogen']));
				$ld_replace_blocks['site_phone'] = stripslashes($data_name['phone_to_show']);
				$ld_replace_blocks['fb_share'] = get_html_function('put_fb_share_v2');
				$ld_replace_blocks['top_menu'] = get_html_function('get_topMenu_html');
				$ld_replace_blocks['right_menu'] = get_right_menu_html();
				$ld_replace_blocks['estimate_form'] = get_html_function('put_estimate_form_v2');
				$ld_replace_blocks['estimate_form_text'] = get_html_function('put_estimate_form_text_v2');
				$ld_replace_blocks['search_form'] = get_html_function('put_search_form_v2');
				
				$ld_replace_blocks['top_bg_style'] = $top_bg_style;
				$ld_replace_blocks['img_top_slice_style'] = $img_top_slice_style;
				$ld_replace_blocks['home_url'] = "http://".$_SERVER['HTTP_HOST'];
				$ld_replace_blocks['img_logo'] = $img_logo;
				$ld_replace_blocks['site_logo'] = $site_logo;
				$ld_replace_blocks['site_logo_url'] = $site_logo_url;
				$ld_replace_blocks['logo_url'] = "";
				$ld_replace_blocks['logo'] = "";
				$ld_replace_blocks['logo_wrap'] = "";
				
				$ld_replace_blocks['img_mobile_logo'] = $img_mobile_logo;
				$ld_replace_blocks['site_mobile_logo'] = $site_mobile_logo;
				$ld_replace_blocks['site_mobile_logo_url'] = $site_mobile_logo_url;			
				
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
				$main_html = "";
				$main_html_all = stripslashes($custom_header);
				$main_html_all = str_replace("http://",HTTP_S."://",$main_html_all);
				$main_html_parts = explode("<!--nice_header-->",$main_html_all);
				if(isset($main_html_parts[0])){
					$main_html .= $main_html_parts[0];
				}
				if(isset($main_html_parts[1]) && $no_nice_header){
					$main_html .= $main_html_parts[1];
				}
				if(isset($main_html_parts[2])){
					$main_html .= $main_html_parts[2];
				}

				$main_html_full = $main_html;
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
				$phone_to_show = $data_name['phone_to_show'];
				$main_html = str_replace("{{cat_phone}}",$phone_to_show,$main_html);				
			?>			
			


			<?php print($main_html); 
