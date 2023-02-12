jQuery(document).ready(function() {
	
	var window_width = 	jQuery(window).width();
	if(window_width > 760){
		jQuery("#centerbar").css({"position":"relative"});	
		jQuery("#leftbar").css({"position":"relative"});		
		jQuery("#rightbar").css({"position":"relative"});	
	
		
		jQuery(window).scroll(function () {
			var window_height = jQuery(window).height();
			var center_ofs = jQuery("#main_content_container").offset().top;	
			var left_ofs = jQuery("#main_content_container").offset().top;	
			var right_ofs = jQuery("#main_content_container").offset().top;
			
			var center_height_min = window_height - center_ofs;
			var main_height = jQuery('#main_content_container').height() + jQuery("#main_content_container").offset().top;
			var center_height = jQuery('#centerbar').height();
			var left_height = jQuery('#leftbar').height();
			var right_height = jQuery('#rightbar').height();
			if(center_height < center_height_min){
				center_height = center_height_min;
			}
			
			
		   var scroll = jQuery(this).scrollTop();
			
			var window_height = jQuery(window).height();

			if((scroll + window_height) > (center_ofs + center_height)){
				
				if(scroll + window_height < main_height){
					var center_topad = (scroll + window_height) - (center_ofs + center_height);
					jQuery('#centerbar').css({"top":center_topad+"px"});
				}
			}
			else{
			jQuery('#centerbar').css({"top":"0px"});
			}

			
			if((scroll + window_height) > (left_ofs + left_height)){
				
				if(scroll + window_height < main_height){
					var left_topad = (scroll + window_height) - (left_ofs + left_height);
					jQuery('#leftbar').css({"top":left_topad+"px"});
				}
			}
			else{
			jQuery('#leftbar').css({"top":"0px"});
			}
			
			if((scroll + window_height) > (right_ofs + right_height)){
				if(scroll + window_height < main_height){
					var right_topad = (scroll + window_height) - (right_ofs + right_height);
					jQuery('#rightbar').css({"top":right_topad+"px"});
				}
			}
			else{
			jQuery('#rightbar').css({"top":"0px"});
			}		
		});
	}
	
});	