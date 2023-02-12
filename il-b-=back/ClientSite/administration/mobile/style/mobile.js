function get_lead_list(){
	jQuery(function($){
		begin_ajax_call_view();
		var search_data = $("#search_leads_form").serialize();
		var url = "?main=lead_list";
		$.ajax({
		  dataType: "json",
		  url: url,
		  data: search_data,
		}).done(function( data ) {
			handel_user(data);
			if(data['success'] != '1'){
				handle_ajax_error(data);
				
			}
			else{
				$("#lead_list_wrap").html("");  
				$.each(data['r_data'], function(i, item) {
					var row_clone = $("#lead_row_mokup").clone();
					row_clone.attr("id","lead_row_"+item['row_id']);
					row_clone.attr("data-row_id",item['row_id']);
					row_clone.find(".date_in").html(item['date_in_str']);
					row_clone.find(".lead_recource").html(item['lead_recource']);
					row_clone.find(".name").html(item['name'].replace("\\",""));
					row_clone.find(".phone").html(item['phone'].toString().replace("\\",""));
					
					row_clone.find(".email").html(item['email'].replace("\\",""));
					try{
						row_clone.find(".content").html(item['content'].split("\\").join(""));
					}
					catch(err) {
					
					}
					row_clone.find(".status").html(item['status_str']).addClass("lead_status_"+item['status']);
					row_clone.find(".mass_edit_id").attr("data-row_id",item['row_id']);
					row_clone.find(".mass_edit_id").change(function(){
						if(this.checked){
							$("#lead_list_wrap").find("#lead_row_"+$(this).attr("data-row_id")).addClass("mass-edit-selected");
						}
						else{
							$("#lead_list_wrap").find("#lead_row_"+$(this).attr("data-row_id")).removeClass("mass-edit-selected");
						}
						if($("#lead_list_wrap").find(".mass_edit_id:checked").length != 0){
							$(".mass_edit_menu_item").show();
						} 
						else{
							$(".mass_edit_menu_item").hide();
						}
					});
					if(item['deleted'] == '1'){
						row_clone.addClass("row-deleted");
					}
					row_clone.find(".go_to_lead").attr('data-row-id',item['row_id']).click(
						function(){
							show_lead_form($(this).attr("data-row-id"));
						}
					);
					if(item['opened'] == '1'){
						row_clone.addClass('opened');
					}
					$("#lead_list_wrap").append(row_clone);
				});
				$("#lead_list_paging_row").val(data['info']['paging_last_row']);
				$("#lead_list_paging_done").val(data['info']['paging_done']);
				switch_screens(data['type'],data['r_data']);
			}
		}).error(function(){
			sudjest_refresh_page();
		});
	});
}

function get_lead_list_page(){
	jQuery(function($){
		if($("#lead_list_paging_loading").val() == '1'){
			return;
		}
		if($("#main_content").attr("data-current_screen") != "lead_list"){
			return;
		}
		if($("#lead_list_paging_done").val() == '1'){
			return;
		}
		$("#lead_list_paging_loading").val("1");
		$("#lead_paging_loading").appendTo("#lead_list_wrap");
		var search_data = $("#search_leads_form").serialize();
		var last_row = $("#lead_list_paging_row").val();
		var url = "?main=lead_list&paging_row="+last_row;
		$.ajax({
		  dataType: "json",
		  url: url,
		  data: search_data,
		}).done(function( data ) {
			handel_user(data);
			$("#lead_list_paging_loading").val("0");
			$("#lead_paging_loading").appendTo("#mokup_main");
			if(data['success'] != '1'){

			}
			else{
				$.each(data['r_data'], function(i, item) {
					var row_clone = $("#lead_row_mokup").clone();
					row_clone.attr("id","lead_row_"+item['row_id']);
					row_clone.attr("data-row_id",item['row_id']);
					row_clone.find(".date_in").html(item['date_in_str']);
					row_clone.find(".name").html(item['name'].replace("\\",""));
					row_clone.find(".phone").html(item['phone'].replace("\\",""));
					row_clone.find(".email").html(item['email'].replace("\\",""));
					try{
						row_clone.find(".content").html(item['content'].split("\\").join(""));
					}
					catch(err) {
					
					}
					row_clone.find(".status").html(item['status_str']);
					row_clone.find(".mass_edit_id").attr("data-row_id",item['row_id']);
					row_clone.find(".mass_edit_id").change(function(){
						if(this.checked){
							$("#lead_list_wrap").find("#lead_row_"+$(this).attr("data-row_id")).addClass("mass-edit-selected");
						}
						else{
							$("#lead_list_wrap").find("#lead_row_"+$(this).attr("data-row_id")).removeClass("mass-edit-selected");
						}
						if($("#lead_list_wrap").find(".mass_edit_id:checked").length != 0){
							$(".mass_edit_menu_item").show();
						} 
						else{
							$(".mass_edit_menu_item").hide();
						}
					});
					if(item['deleted'] == '1'){
						row_clone.addClass("row-deleted");
					}
					row_clone.find(".go_to_lead").attr('data-row-id',item['row_id']).click(
						function(){
							show_lead_form($(this).attr("data-row-id"));
						}
					);
					if(item['opened'] == '1'){
						row_clone.addClass('opened');
					}
					$("#lead_list_wrap").append(row_clone);
				});
				$("#lead_list_paging_row").val(data['info']['paging_last_row']);
				$("#lead_list_paging_done").val(data['info']['paging_done']);
			}
		}).error(function(){
			sudjest_refresh_page();
		});
	});
}

function show_lead_form(row_id,token){
	jQuery(function($){
		var send_data = {'row_id': row_id};
		if(typeof token !== 'undefined'){
			send_data = {'row_id': row_id,'token': token};
		}
		begin_ajax_call_view();
		var url = "?main=get_lead";
		$.ajax({
		  dataType: "json",
		  url: url,
		  data: send_data,
		}).done(function( return_data ) {
			handel_user(return_data);
			if(return_data['success'] == '0'){
				handle_ajax_error(return_data);
			}
			else{
				var item = return_data['r_data'];
				var lead_clone = $("#lead_form_mokup").clone();
				lead_clone.addClass("payByPswd_"+item['payByPassword']);
				lead_clone.attr("id","lead_form_wrap_"+item['row_id']);
				lead_clone.attr("data-row_id",item['row_id']);
				lead_clone.find(".date_in").html(item['date_in_str']);
				lead_clone.find("form.details_form").attr("id","lead_form_"+item['row_id']);
				lead_clone.find(".name").val(item['name'].replace("\\",""));
				lead_clone.find(".phone").val(item['phone'].replace("\\",""));
				lead_clone.find(".email").val(item['email'].replace("\\",""));
				lead_clone.find(".content").html(item['content'].replace("\\",""));
				lead_clone.find(".status-select").val(item['status']); 
				lead_clone.find(".lead-name-holder").html(item['name']);
				lead_clone.find(".lead_form_delete_cancel").click(function(){
					close_delete_lead_button();
				});	
				lead_clone.find(".lead_form_delete").click(function(){
					delete_lead(item['row_id']);
				}); 				
				if(item['payByPassword'] == '1'){
					lead_clone.find(".phone").attr("name","data_arr[phone]").removeAttr("readonly").addClass("phone-active");
					lead_clone.find(".phone-link").attr("href","tel:" + item['phone'].replace("\\","")).removeClass("hidden");
					
					lead_clone.find(".email").attr("name","data_arr[email]").removeAttr("readonly");
					
					lead_clone.find("form.refund_form").attr("id","lead_refund_form_"+item['row_id']);

					lead_clone.find(".refund_request_button_wrap").removeClass("hidden");
					lead_clone.find(".billed_lead_link").attr('data-row-id',item['lead_billed_id']).click(
						function(){
							show_lead_form($(this).attr("data-row-id"));
						}
					);
					
					
					lead_clone.find(".refund_request_button").click(function(){
						if(item['lead_billed_id'] == '0' || item['lead_billed_id'] == ''){
							if(item['refund_72_hour_ok'] == 'ok'){
								lead_clone.find(".refund_lead_form_mask").show();
							}
							else{
								lead_clone.find(".72_hour_lead_alert_mask").show();
							}
						}
						else{
							lead_clone.find(".double_lead_alert_mask").show();
						}
						lead_clone.find(".details_form").hide();
					});
					lead_clone.find(".lead_form_refund_cancel").click(function(){
						lead_clone.find(".refund_lead_form_mask").hide();
						lead_clone.find(".details_form").show();
					});	
					lead_clone.find(".72_hour_lead_alert_cancel").click(function(){
						lead_clone.find(".72_hour_lead_alert_mask").hide();
						lead_clone.find(".details_form").show();
					});
					lead_clone.find(".lead_form_refund_send").click(function(){send_lead_refund_request(item['row_id'])});						
				}				
				else{
					lead_clone.find(".lead_form_buy").click(function(){
						pay_for_lead(item['row_id']);
					}); 
					lead_clone.find(".lead_form_buy_cancel").click(function(){
						close_buy_lead_button();
					});							
				}
				lead_clone.find(".lead_form_send").click(function(){
					lead_form_send(item['row_id']);
				}); 
				$("#get_lead_wrap").html("");
				$("#get_lead_wrap").append(lead_clone);
				switch_screens(return_data['type'],item);
			}
		}).error(function(){
			sudjest_refresh_page();
		});
	});
}

function sudjest_refresh_page(){
	system_messege("please refresh page");
}

function handle_ajax_error(data){
	system_messege(data['error']['messege']);
	if(data['login'] == '0'){
		open_login_form();
	}
	else{
		$("#get_data_mask").hide();
	}
}

function system_messege(messege){
	$("#system_massege_text").html(messege);
	$("#system_massege_mask").fadeIn();
	setTimeout(function(){$("#system_massege_mask").fadeOut();},2000);	
}
function send_lead_refund_request(row_id){
	jQuery(function($){
		var send_data = $("#lead_refund_form_"+row_id).serialize();
		begin_ajax_call_view();
		var url = "?main=refund_lead_request&row_id="+row_id;
		$.ajax({
		  dataType: "json",
		  type: 'post',
		  url: url,
		  data: send_data,
		}).done(function( return_data ) {
			handel_user(return_data);
			if(return_data['success'] == '0'){
				handle_ajax_error(return_data);
			}
			else{
				system_messege(return_data['messege']);
				show_lead_form(row_id);
			}
		}).error(function(){
			sudjest_refresh_page();
		});
	});	
}

function lead_form_send(row_id){
	jQuery(function($){
		var send_data = $("#lead_form_"+row_id).serialize();
		begin_ajax_call_view();
		var url = "?main=update_lead&row_id="+row_id;
		$.ajax({
		  dataType: "json",
		  type: 'post',
		  url: url,
		  data: send_data,
		}).done(function( return_data ) {
			handel_user(return_data);
			if(return_data['success'] == '0'){
				handle_ajax_error(return_data);
			}
			else{
				show_lead_form(row_id);
			}
		}).error(function(){
			sudjest_refresh_page();
		});
	});	
}
function delete_lead(row_id){
	jQuery(function($){
		begin_ajax_call_view();
		var url = "?main=delete_lead";
		$.ajax({
		  dataType: "json",
		  type: 'post',
		  url: url,
		  data: {'row_id': row_id},
		}).done(function( return_data ){
			handel_user(return_data);
			if(return_data['success'] == '0'){
				handle_ajax_error(return_data);
			}
			else{
				get_lead_list();
			}
		}).error(function(){
			sudjest_refresh_page();
		});
	});	
}
 
function pay_for_lead(row_id){
	jQuery(function($){
		begin_ajax_call_view();
		var url = "?main=pay_for_lead";
		$.ajax({
		  dataType: "json",
		  type: 'post',
		  url: url,
		  data: {'row_id': row_id},
		}).done(function( return_data ){
			handel_user(return_data);
			if(return_data['success'] == '0'){
				if(return_data['user']['leads_credit'] == '0'){
					handle_ajax_error(return_data);
					setTimeout(function(){$("#leads_credit").click();}, '2000');
				}
				else{
					
					handle_ajax_error(return_data);
					setTimeout(function(){show_lead_form(row_id);}, '2000');
				}
			}
			else{
				show_lead_form(row_id);
			}
		}).error(function(){
			sudjest_refresh_page();
		});
	});	
}

function open_login_form(){
	jQuery(function($){
		if($("#login_form_is_set").val() == "false"){
			$("#login_submit").click(function(){
				begin_ajax_call_view();
				var url = "?main=user_login";
				$.ajax({
				  dataType: "json",
				  type: 'post',
				  url: url,
				  data: {	'user': $("#login_user").val(),
							'pass': $("#login_pass").val(),
							'return_screen': $("#login_return_screen").val(),
							'row_id': $("#login_row_id").val()
						},
				}).done(function( return_data ) {
					handel_user(return_data);
					if(return_data['success'] == '0'){
						handle_ajax_error(return_data);
					}
					else{
						get_lead_list();
					}
				}).error(function(){
					sudjest_refresh_page();
				});				
			});
			$("#forgot_password_link").click(function(){
				$("#login_form_wrap").find(".login-container").hide();
				$("#login_form_wrap").find(".forgot-password-container").show();
				
			});
			$("#fp_cancel").click(function(){
				$("#login_form_wrap").find(".forgot-password-container").hide();
				$("#login_form_wrap").find(".login-container").show();
				
				
			});	

			$("#fp_submit").click(function(){
				begin_ajax_call_view();
				var url = "?main=forgot_password";
				$.ajax({
				  dataType: "json",
				  type: 'post',
				  url: url,
				  data: {	'email': $("#forgot_password_email").val()
						},
				}).done(function( return_data ) {
					handel_user(return_data);
					if(return_data['success'] == '0'){
						handle_ajax_error(return_data);
						
					}
					else{
						system_messege(return_data['messege']);
						$("#login_form_wrap").find(".forgot-password-container").hide();
						$("#login_form_wrap").find(".login-container").show();
						$("#get_data_mask").hide();						
					}
				}).error(function(){
					sudjest_refresh_page();
				});				
			});			
			$("#login_form_is_set").val("true");
		}
		switch_screens("login_form",new Array());
	});
}

function begin_ajax_call_view(){
	jQuery(function($){
		$("#get_data_mask").show();
	});
}

function switch_screens(new_screen,data){
	jQuery(function($){
		var dataholder = $("#main_content");
		var current_screen = dataholder.attr("data-current_screen");
		$("#get_data_mask").hide();
		$("#"+current_screen+"_wrap").hide();
		$("#"+new_screen+"_wrap").show();
		$("#main_content").attr("data-current_screen",new_screen);	
		$("#get_data_mask").hide();
		$("#top_menu_wrap").find(".menu-item").hide();
		$("#bottom_menu_wrap").find(".menu-item").hide();
		$("#top_menu_wrap").find(".menu-"+new_screen+"-item").show();
		$("#bottom_menu_wrap").find(".menu-"+new_screen+"-item").show();	
		$("#top_menu_wrap").find(".menu-all-item").show();
		$("#bottom_menu_wrap").find(".menu-all-item").show();	
		if(new_screen == "get_lead"){
			if(data['payByPassword'] == '0'){
				$("#top_menu_wrap").find(".menu-buy_lead").show();	
			}
		}
	});
}
function handel_user(return_data){	
	if(typeof(return_data["user"]) != "undefined"){
		var user = return_data["user"];
		if(typeof(user["leads_credit"]) != "undefined" ){
			if(user["leads_limit_type"]!='no_limit'){
				var leads_credit = user["leads_credit"];
				$(".leas_credit_holder").html(leads_credit);
				$("#leads_credit").show();
			}
		}
		if(typeof(user["h_refund"]) != "undefined" ){
			if(user["h_refund"]!='0'){
				$(".refund_request_button").hide();
				$("#search_leads_status_6_wrap").hide();
			}
		}
	}
}
function setup_leads_search_form(){
	
	jQuery(function($){
		$("#search_leads_statuses").find(".search-leads-status").click(function(){
			if($(this).hasClass("search-leads-status-selected")){
				$(this).removeClass("search-leads-status-selected");
				var data_status = $(this).attr("data-status");
				$("#statuses_select_boxes").find("#search_leads_status_"+data_status).prop('checked',false);
			}
			else{
				$(this).addClass("search-leads-status-selected");
				var data_status = $(this).attr("data-status");
				$("#statuses_select_boxes").find("#search_leads_status_"+data_status).prop('checked',true);				
			}
		});
		$("#search_leads_statuses").find(".search-leads-deleted").click(function(){
			if($(this).hasClass("search-leads-deleted-selected")){
				$(this).removeClass("search-leads-deleted-selected");
				$("#statuses_select_boxes").find("#search_leads_deleted").prop('checked',false);
			}
			else{
				$(this).addClass("search-leads-deleted-selected");
				$("#statuses_select_boxes").find("#search_leads_deleted").prop('checked',true);
			}
		});		
		$("#search_list_button").click(function(){
			if($(this).hasClass("active")){
				var current_screen = $(this).attr("data-backto");
				$(this).attr("data-backto","");
				$(this).removeClass("active");
				switch_screens(current_screen,new Array());
			}
			else{
				$(this).addClass("active");
				var current_screen = $("#main_content").attr("data-current_screen");
				$(this).attr("data-backto",current_screen);
				switch_screens('search_leads',new Array());
			}
		});
		$("#search_leads_submit").click(function(){$("#search_list_button").removeClass("active"); get_lead_list(); });
	});	
}

function mass_irrelevant_send(contact_status){
	jQuery(function($){
		if(contact_status == '1'){
			$("#mass_irrelevant_form_mask").hide();
		}
		if(contact_status == '2'){
			$("#mass_delete_form_mask").hide();
		}		
		if($("#lead_list_wrap").find(".mass_edit_id:checked").length != 0){
			var selected_rows = new Array();
			$("#lead_list_wrap").find(".mass_edit_id:checked").each(function(){
				selected_rows.push($(this).attr("data-row_id"));
			});
			begin_ajax_call_view();
			var url = "?main=contact_mass_update";
			$.ajax({
			  dataType: "json",
			  type: 'post',
			  url: url,
			  data: {'contact_status': contact_status,'selected_rows': selected_rows},
			}).done(function( return_data ){
				handel_user(return_data);
				if(return_data['success'] == '0'){
					handle_ajax_error(return_data);
				}
				else{
					system_messege(return_data['messege']);
					get_lead_list();
				}
			}).error(function(){
				sudjest_refresh_page();
			});
		} 
		
	});	
}
var buy_iframe_height_set = false;
function setup_buy_leads(){
	jQuery(function($){
		$("#leads_credit").click(function(){
			restart_buy_leads_iframe();
		}); 
		
	});	
}

function restart_buy_leads_iframe(){
	switch_screens('buy_leads',new Array());
	if(!buy_iframe_height_set){
		$("#buy_leads_iframe").height($(window).height()-222);
		buy_iframe_height_set = true;
	}
	//document.location = "/myleads/?main=buy_leads&content_type=iframe&sessid="+$("#sessid_holder").val();
	$("#buy_leads_iframe").attr('src', "/myleads/?main=buy_leads&content_type=iframe&sessid="+$("#sessid_holder").val());
}

function handle_buy_leads_error(messege){
	system_messege(messege);
	setTimeout(function(){restart_buy_leads_iframe();},'2000');
}

function handle_buy_leads_success(messege){
	system_messege(messege);
	setTimeout(function(){get_lead_list();},'2000');
	
}

function handle_buy_leads_description(leads_no,amount){
	$("#buy_leads_leads_no_description").show();
	$("#buy_leads_amount_description").show();
	$("#buy_leads_amount_description").find(".buy_leads_amount_holder").html(amount);
	$("#buy_leads_leads_no_description").find(".buy_leads_leads_no_holder").html(leads_no);
}

function open_buy_lead_button(){
	jQuery(function($){
		$("#get_lead_wrap").find(".buy_lead_form_mask").show(); 
	});	
}
function close_buy_lead_button(){
	jQuery(function($){
		$("#get_lead_wrap").find(".buy_lead_form_mask").hide(); 
	});	
}

function open_delete_lead_button(){
	jQuery(function($){
		$("#get_lead_wrap").find(".delete_lead_form_mask").show(); 
	});	
}
function close_delete_lead_button(){
	jQuery(function($){
		$("#get_lead_wrap").find(".delete_lead_form_mask").hide(); 
	});	
}

function click_save_lead_button(){
	jQuery(function($){
		$("#get_lead_wrap").find(".lead_form_send").click(); 
	});	
}




jQuery(function($){
	$(document).ready(function(){
		
		var start_screen = $("#main_content").attr("data-current_screen");
		$("#back_to_list_button").click(function(){get_lead_list();});
		if(start_screen == 'lead_list'){
			get_lead_list();
		}
		else{
			if(start_screen == 'get_lead'){
				var oppenning_row_id = $("#main_content").attr("data-get_row");
				var token = $("#main_content").attr("data-token");
				show_lead_form(oppenning_row_id,token);
			}
		}
		$("#open_lead_button").click(function(){open_buy_lead_button();});
		$("#delete_lead_button").click(function(){open_delete_lead_button();});
		$("#save_lead_button").click(function(){click_save_lead_button();});
		$("#mass_irrelevant_leads_button").click(function(){$("#mass_irrelevant_form_mask").show();});
		$("#mass_irrelevant_cancel_button").click(function(){$("#mass_irrelevant_form_mask").hide();});
		$("#mass_delete_leads_button").click(function(){$("#mass_delete_form_mask").show();});
		$("#mass_delete_cancel_button").click(function(){$("#mass_delete_form_mask").hide();});
		$("#mass_irrelevant_send_button").click(function(){mass_irrelevant_send("1");});
		$("#mass_delete_send_button").click(function(){mass_irrelevant_send("2");});		
		setup_leads_search_form();
		setup_buy_leads();
		$('.date-input').each(function(){
			$(this).datepicker({format: 'dd/mm/yyyy',autoclose:true,language: 'he',isRTL: false,todayHighlight: true});
		}); 
		$('.date-cleaner').click(function(){
			var element_id = $(this).attr("for");
			$("#"+element_id).val("");
		}); 
		$(window).on("scroll", function() {
			
			var scrollHeight = $(document).height();
			var scrollPosition = $(window).scrollTop();
			if ((scrollHeight - scrollPosition) < 1000) {
				get_lead_list_page();
			}
		});		
	});
});