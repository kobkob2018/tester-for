	
	var current_selected_cat = 0;
	var category_select_name = "";	
	var validator = 0;
	function validatePhone(phone) {
		
		if (phone.length > 8) {
			return true;
		}
		else {
			return false;
		}
	}
	function etsimate_form_handler(){
		jQuery(function($){
			validator = $("#estimate_form").validate({
				errorPlacement: function(error, element) {
					error.insertBefore(element);
				},
				messages: {
					required: "*",
				}				
			});
			jQuery.validator.addMethod("phoneNumber", function (phone_number, element) {
				return this.optional(element) || validatePhone(phone_number);
			});			
			var select_trigers = false;
			$("#estimate_form").find(".cat_updater_new").each(function(){
				select_trigers = true;
				$(this).removeClass("cat_updater_new");
				$(this).change(function () {
					$("#estimate_form").validate().resetForm();
					setup_estimate_form_extra_fields($(this).attr("name"));					
				});
			});	
			$("#estimate_form").find(".cat_updater_helper").each(function(){
					setup_estimate_form_extra_fields($(this).attr("rel"));
			});
			if(select_trigers){
				$("#estimate_form").find("#submitit").each(function(){
					$(this).attr("disabled", false);
					$(this).attr("value",$(this).attr("rel_ready"));
				});
			}
			
		});								
		
	}	
	
	function setup_estimate_form_extra_fields(cat_input_id){
		jQuery(function($){
			$("#estimate_form").find(".extra-field").each(function(){
				$(this).remove();
			});	
				
			
			$("#estimate_form").find(".select_"+cat_input_id+"_son").each(function(){
				$(this).remove();
			});					
			
			if($("#"+cat_input_id).length != 0){
				
				$("#estimate_form").find("#submitit").each(function(){
					$(this).attr("disabled", true);
					$(this).attr("value",$(this).attr("rel_loading"));
				});
				var cat_val = $("#"+cat_input_id).val();
				$('body').append("<div style='display:block;' id='estimate_extra_fields_helper'><div/>");
				var params = "&from_cat="+cat_val+"&cat_level="+cat_input_id;
				if($("#estimate_form").find("#Fm_city").hasClass("no-replace")){
					params += "&no_city=1";
				}
				var url = "ajax.php?main=estimateCatExtraFileds&version=version_1" + params ;
				new Ajax.Updater("estimate_extra_fields_helper" , url, {
					asynchronous:true,
					onComplete:function(a_oRequest){

						$("#estimate_extra_fields_helper").find(".cat_tree_ajax_wrap").each(function(){
							//$("#estimate_form").append($(this));
							$(this).insertBefore( "#estimate_form #cat_tree_select_place" );
							$(this).find(".cat_updater_new").each(function(){
								$(this).removeClass("cat_updater_new");
								$(this).change(function(){
									$("#estimate_form").validate().resetForm();
									setup_estimate_form_extra_fields($(this).attr("name"));
								}); 
							});
							
						});
						$("#estimate_extra_fields_helper").find(".form-extra").each(function(){
							//$("#estimate_form").append($(this));
							$(this).insertBefore( "#estimate_form #Fm_note_wrap" );
							$(this).addClass("extra-field");
							
						});
						
						$("#estimate_extra_fields_helper").remove();
						$('.estimate-date').each(function(){
							$(this).datepicker({format: 'dd/mm/yyyy',autoclose:true,language: 'he',isRTL: false,todayHighlight: true});
						});
						$("#estimate_form").find("#submitit").each(function(){
							$(this).attr("disabled", false);
							$(this).attr("value",$(this).attr("rel_ready"));
						});	
					},
				});	
			}
		});
	}
	
	function ajax_estimateForm_send()
	{
		jQuery("#estimate_form [name='temp_name']").remove();
		var queryArray = jQuery("#estimate_form").serializeArray();
		jQuery.each( queryArray, function( i, field ) {
		  //can manipulate values here
		});
		jQuery("#estimate_form").find("#submitit").each(function(){
			jQuery(this).attr("disabled", true);
			jQuery(this).attr("value",jQuery(this).attr("rel_sending"));
		});		
		var queryString = jQuery.param(queryArray);
		console.log(queryString);
		var url = "ajax.php?main=estimateSiteInsert&add_wach_link=1&" + queryString ;
		
		new Ajax.Updater("estimateSiteHeightDiv" , url, {evalScripts:true});
	}
	
	function open_mobile_estimate_form(el){
		if(jQuery(el).attr('rel') == 'closed'){
			jQuery(el).removeClass('closed').addClass('open').attr('rel','open');
			jQuery("#mobile_estimate_form_open_button_wrap").removeClass('closed').addClass('open');
			jQuery('#mobile_estimate_form_wrap').show();
		}
		else{
			jQuery(el).removeClass('open').addClass('closed').attr('rel','closed');
			jQuery("#mobile_estimate_form_open_button_wrap").removeClass('open').addClass('closed');
			jQuery('#mobile_estimate_form_wrap').hide();			
		}
		
		
	}