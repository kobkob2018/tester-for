<?php 
	header("Access-Control-Allow-Origin: http://www.ilbiz.co.il");
	header("Access-Control-Allow-Origin: http://ilbiz.co.il");
?>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/> 
	<meta content='width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0' name='viewport' />
	<title>מערכת ניהול כרטיס ביקור דיגיטלי</title>
	<link rel="stylesheet" href="ecard/style/bootstrap_2.3.2/bootstrap.min.css" type="text/css">
	<link rel="stylesheet" href="ecard/style/bootstrap_2.3.2/bootstrap.rtl.css" type="text/css">	
	<link rel="stylesheet" href="ecard/style/bootstrap_2.3.2/bootstrap-responsive.min.css" type="text/css">
	<link rel="stylesheet" href="ecard/style/bootstrap_2.3.2/bootstrap-responsive.rtl.css" type="text/css">
	<link rel="stylesheet" href="ecard/style/bootstrap_2.3.2/rtl-xtra.min.css" type="text/css">
	<script src="ecard/style/bootstrap_2.3.2/jquery.min.js"></script>
	<script src="ecard/style/bootstrap_2.3.2/jquery.validate.js"></script>
	<script src="ecard/style/bootstrap_2.3.2/bootstrap.min.js"></script>
	

	
	<link rel="stylesheet" href="ecard/style/bootstrap_2.3.2/bootstrap-datepicker.min.css" type="text/css">	
	<script src="ecard/style/bootstrap_2.3.2/bootstrap-datepicker.min.js"></script>
	<script src="ecard/style/bootstrap_2.3.2/bootstrap-datepicker.he.min.js"></script>		
	<link rel="stylesheet" href="ecard/style/mobile.css?v=1.6" type="text/css" />
	<script src="ecard/style/mobile.js"></script>	
</head>
<body>
	<div id='page_master' class='container'>
		<div id='top_menu_wrap'>
			<div class="logo menu-item menu-all-item to-right" id="logo"> 
				<a href="../mycard/">
					<img src="ecard/style/image/logo-s10.png"  id="logo_img" alt="sherut10" style="height: 49px; padding:5px 0px;" />
				</a>
			</div>
			<div class="menu-item menu-leads_credit-item menu-all-item" id="leads_credit_wrap to-left"> 
				<div id="leads_credit">
					<img src="ecard/style/image/key-icon.png"  alt="Save this lead" style="width: 24px;" />
					<br/>
					<span id="leads_credit_number" class="leas_credit_holder" >&nbsp;</span>
				</div>
			</div>	
			<div class="menu-item to-right" id="buy_leads_leads_no_description"> 
				<div class='menu-item-desc'>
					רכישת <span class="buy_leads_leads_no_holder"></span><span class="leads_no"> לידים</span>
				</div>
			</div>

			<div class="menu-item menu-menu_link-item menu-all-item  to-left" id="menu_link_wrap"> 
				<div id="menu_link" onclick="switch_screens('main_menu');">
					<img src="ecard/style/image/mobile_menu_icon.png"  alt="Save this lead" style="width: 37px;padding-top: 12px;padding-left: 8px;" />
				</div>
			</div>				
			<div class="menu-item menu-buy_lead" id="open_lead_button_wrap to-left"> 
				<img src="ecard/style/image/key-icon.png"  id="open_lead_button" alt="Open this lead" style="width: 49px; padding: 5px;" />
			</div>
			<div class="menu-item menu-get_lead-item_notActive" id="save_lead_button_wrap to-left"> 
				<img src="ecard/style/image/Save-icon.png"  id="save_lead_button" alt="Save this lead" style="width: 49px; padding: 5px;" />
			</div>
	
			
		</div>
		<div id='get_data_mask' class='get-data-mask mask-div'>
			<div class="mask-bg"></div>
			<div class="mask-content">
				<img src="ecard/style/image/loading.gif"  id="gt_data_loadin_gif" alt="Loading" />
			</div>	
		</div>
		<div id='system_massege_mask' class='system-massege-mask mask-div'>
			<div class="mask-bg"></div>
			<div class="mask-content">
				<div id='system_massege_text'></div>
			</div>			
			
		</div>
		
		<div id='mass_irrelevant_form_mask' class='mass-edit-form-mask mask-div'>
			<div class="mask-bg"></div>
			<div class="mask-content">
				<div class='form-group'>
					<h4>האם ברצונך לסמן את הלידים הנבחרים כלא רלוונטים?</h4>
				</div>
				<div class='lead_form_btn form-group'>
					<button type="button" id="mass_irrelevant_cancel_button" class="mass_edit_cancel form-button">ביטול</button>
					<button type="button" id="mass_irrelevant_send_button" class="mass_edit_send form-button">שלח</button>
					
				</div>				
			</div>			
			
		</div>
		<div id='mass_delete_form_mask' class='mass-edit-form-mask mask-div'>
			<div class="mask-bg"></div>
			<div class="mask-content">
				<div class='form-group'>
					<h4>האם ברצונך למחוק את הנבחרים?</h4>
				</div>
				<div class='lead_form_btn form-group'>
					<button type="button" id="mass_delete_cancel_button" class="mass_edit_cancel form-button">ביטול</button>
					<button type="button" id="mass_delete_send_button" class="mass_edit_send form-button">שלח</button>
					
				</div>				
			</div>			
			
		</div>		
		<?php 
			$current_screen = 'main_menu'; 
			$oppenning_row_id = ''; 
			$oppenning_token = '';
			if(isset($_REQUEST['row_id']) && isset($_REQUEST['token'])){
				$current_screen = 'get_lead'; 
				$oppenning_row_id = $_REQUEST['row_id']; 
				$oppenning_token = 	$_REQUEST['token']; 
			}
			$user_loged = '0';
			if(isset($_SESSION['login'])){
				$user_loged = '1';
			}
		?>
		 
		<div id='main_content' data-current_screen='<?php echo $current_screen; ?>' data-get_row='<?php echo $oppenning_row_id; ?>' data-token='<?php echo $oppenning_token; ?>' data-user_loged='<?php echo $user_loged; ?>' >
			<div id='main_menu_wrap' class='main_content_item'>
				<?php if(!$allow_activate): ?>
					<div>
						<b style='color:red'>
							כרטיס זה אינו פעיל
						</b>
						<br/>
						על מנת להפעיל את הכרטיס יש למלא טופס פתיחת כרטיס 10Card.
						<br/>
						<a target="_BLANK" href='<?php echo $open_card_form_link; ?>'>לחצו כאן למלא טופס פתיחת כרטיס 10Card</a>
						<br/>
						<b style='color:red;font-size:18px;'>
							במידה וכבר מילאת אנא בדוק את תיבת המייל שלך, ושם לחץ על הלינק לאישור אמינות החוזה.
						</b>
						<br/><br/>
						<a href=''>לחצו כאן אם כבר אישרתם את אמינות החוזה.</a>
						<br/><br/>
					</div>	
				<?php else: ?>				
				<div class="main-menu-item" id="main_menu_lead_list"> 
					<a class="main-menu-a" href="javascript://" onclick="get_lead_list();"> רשימת הודעות מ10card</a>
				</div>
				<div class="main-menu-item" id="main_menu_edit_card"> 
					<a class="main-menu-a" href="javascript://" onclick="restart_edit_card_iframe();"> עריכת כרטיס 10card</a>
				</div>
				<?php endif; ?>	
<?php /*				
				<div class="main-menu-item" id="main_menu_myleads_link"> 
					<a class="main-menu-a" href="../myleads/">הלידים שלי</a>
				</div>
*/ ?>				
				<div class="main-menu-item" id="main_menu_logout"> 
					<a class="main-menu-a" href="../mycard/?main=user_logout" style="color:red;">יציאה מהמערכת</a>
				</div>
				<?php /*
				<div class="help-center"> 
				
					<b>צריך עזרה?</b> <a target="_blank" style="color:blue;" href="https://www.facebook.com/groups/10card/">כנס לפורום שאלות ותשובות בפייסבוק</a>
				
				</div>
				*/ ?>
				<div class="main-menu-bottom-links">
					<div style="clear:both;"></div>
					<h3>10card כרטיס דיגיטלי בחינם באדיבות ובחסות :</h3>
					<div class="main-menu-bottom-item" id="main_menu_kama_link"> 
						<a class="main-menu-bottom-a" target="_blank" href="http://כמהעולה.co.il" title="כמהעולה.co.il"><img src="https://10card.co.il/cards/style/sys_icons/kama_logo.png" alt="כמהעולה.co.il" />
							<?php /*
							<br/><br/>
							<small style="font-size: 15px; line-height: 15px;">אתר המחירונים המומלצים של ישראל</small>
							*/ ?>
						</a>
					</div>					
				
					<div class="main-menu-bottom-item" id="main_menu_sherut10_link"> 
						<a class="main-menu-bottom-a" target="_blank" href="https://sherut10.co.il/" title="שירותלקוחות.org.il"><img src="https://10card.co.il/cards/style/sys_icons/sherut10_logo.png" alt="שירותלקוחות.org.il" />
							<?php /*
							<br/><br/>
							<small style="font-size: 15px; line-height: 15px;">אתר הצעות מחיר בקליק מבעלי מקצוע מומלצים</small>
							*/ ?>
						</a>
					</div>
					<div class="main-menu-bottom-item" id="main_menu_10card_link"> 
						<br/>
						<a class="main-menu-bottom-a" target="_blank" href="https://il-biz.com" title="il-biz.com">
							<img src="https://10card.co.il/cards/style/sys_icons/il-biz_logo.jpg" alt="il-biz.com" />
							<br/>
							<b>קידום עסקים באינטרנט</b>
						</a>
						<div style="clear:both;"></div>
					</div>		
					<div style="clear:both;"></div>
				</div>
			</div>
			<div id='lead_list_wrap' class='main_content_item'>
				
			</div>
			<div id='edit_card_wrap' class='main_content_item'>
				<iframe src="" id="edit_card_iframe" style="margin:auto;min-width:90%;width:100%;"></iframe>
			</div>			
			<div id='get_lead_wrap' class='main_content_item'>
			
			</div>
			<div id='search_leads_wrap' class='main_content_item'>
				<div id="search_leads">
					<div id="search_leads_form_wrap">
						<form action="javascript://" name="search_leads_form" id="search_leads_form">	
							<div style="display:none;" id="statuses_select_boxes">
								<input type="hidden" name = "status" value="s" />
								<input type="checkbox" name = "s[0]" id="search_leads_status_0" checked="1" />
								<input type="checkbox" name = "s[1]" id="search_leads_status_1" />
								<input type="checkbox" name = "s[2]" id="search_leads_status_2" />
								<input type="checkbox" name = "s[3]" id="search_leads_status_3" />
								<input type="checkbox" name = "s[4]" id="search_leads_status_4" />
								<input type="checkbox" name = "s[5]" id="search_leads_status_5" />
								<input type="checkbox" name = "deleted" id="search_leads_deleted" />
								<button type="button" class="search-leads-deleted">חפש במחוקים	</button>
							</div>
							<h3 class="search-leads-title">הצג לידים</h3>
							<div id="search_leads_statuses" class='form-group' >
								<button type="button" class="search-leads-status search-leads-status-selected" data-status="0" >מתעניין חדש</button>					
								<button type="button" class="search-leads-status" data-status="1" >נוצר קשר</button>
								<button type="button" class="search-leads-status" data-status="5" >מחכה לטלפון</button>
								<button type="button" class="search-leads-status" data-status="2" >סגירה עם לקוח</button>
								<button type="button" class="search-leads-status" data-status="3" >לקוח רשום</button>
								<button type="button" class="search-leads-status" data-status="4" >לא רלוונטי</button>
								
								
							</div>
							<div id="search_leads_deleted_wrap" class='form-group' >
								<input type="checkbox" name = "deleted" id="search_leads_deleted" /> חפש במחוקים	
							</div>
							<div id="search_leads_status_6_wrap" class='form-group' >
								<input type="checkbox" name = "s[6]" id="search_leads_status_6" /> חפש בזיכויים
							</div>							
							<div id="search_leads_date_from" class='form-group' >
								<label for="date_from">מתאריך</label>
								<input type="text"  id="leads_search_date_from" name="date_from" value="" class="input_style text-input date-input"  readonly/>	
								<a href="javascript://" id="leads_search_date_from_clean" for="leads_search_date_from" class="date-cleaner">&nbsp;&nbsp;X</a>						
							</div>
							<div id="search_leads_date_to" class='form-group' >
								<label for="date_from">עד תאריך</label>
								<input type="text"  id="leads_search_date_to" name="date_to" value="" class="input_style text-input date-input"  readonly/>							
								<a href="javascript://" id="leads_search_date_to_clean" for="leads_search_date_to" class="date-cleaner">&nbsp;&nbsp;X</a>
							</div>	
							<div id="search_leads_free_text" class='form-group' >
								<label for="date_from">חיפוש חופשי</label>
								<input type="text"  id="leads_search_free_text" name="free_text" value="" class="input_style text-input" />							
							</div>

							<div id="search_leads_submit_wrap" class='form-group' >
								<button type="button" id="search_leads_submit">חפש</button>
							</div>
						</form>
					</div>
				</div>
			</div>			
			<div id='login_form_wrap' class='main_content_item'>
				<div class="dialog">
					<div class="login-container">
						<form>
							<input type="hidden" id="login_return_screen" name="return_screen" value="" />
							<input type="hidden" id="login_row_id" name="row_id" value="" />
							<input type="hidden" id="login_form_is_set" name="form_is_set" value="false" />
							<div class="form-group login-title">
								<h4>כניסה לחשבון</h4>
							</div>						
							<div class="form-group">
								<input type="text" name="user" id="login_user" class="text-input required user-name" placeholder="שם משתמש">
							</div>
							<div class="form-group">
								<input type="password" name="pass" id="login_pass"  class="text-input required password" placeholder="סיסמה">
							</div>
							<div class="form-group">
								<input type="button" name="login" id="login_submit" class="required btn-login form-button" class="login loginmodal-submit" value="שלח">
							</div>
							
						</form>
						
						<div class="login-help">
							<a href="javascript://" id="forgot_password_link">שכחתי סיסמא</a>
						</div>
						
					</div>
					<div class="forgot-password-container" style="display:none;">
						<form>
							<div class="form-group login-title">
								<h4>שחזור סיסמא</h4>
							</div>	
							<h5>אנא הכנס את כתובת האימייל שלך</h5>
							<div class="form-group">
								<input type="text" name="email" id="forgot_password_email" class="text-input required email" placeholder="אימייל">
							</div>
							<div class="form-group fp-button-wrap">
								<input type="button" name="fp_send" id="fp_submit" class="btn-login form-button" class="login loginmodal-submit" value="שלח">
							</div>
							<div class="form-group fp-button-wrap">
								<input type="button" name="fp_cancel" id="fp_cancel" class="btn-cancel form-button" class="login loginmodal-submit" value="ביטול">
							</div>							
						</form>

						
					</div>					
				</div>
			</div>			
		</div>
		<div id="bottom_menu_wrap">
			<div class="menu-item  menu-get_lead-item menu-buy_leads-item back-to-list to-right" id="back_to_list_button_wrap"> 
				<img src="ecard/style/image/List-icon.png"  id="back_to_list_button" alt="Back to list" style="width: 49px; padding: 5px;" />
			</div>	
			<div class="menu-item  menu-lead_list-item menu-search_leads-item search-list to-left" id="search_list_button_wrap"> 
				<img src="ecard/style/image/Search-icon.png"  id="search_list_button" alt="Search" style="width: 49px; padding: 5px;" />
			</div>
			<div class="menu-item menu-all-item to-right" id="refresh_button"> 
				<a href="../mycard/" title="רענן">
					<img src="ecard/style/image/Refresh-icon.png"  id="refresh_img" alt="refresh" style="width: 50px; padding: 4px 0px;" />
				</a>	
			</div>	
			<div class="menu-item  menu-get_lead-item delete-lead to-left" id="delete_lead_button_wrap"> 
				<img src="ecard/style/image/Delete-icon.png"  id="delete_lead_button" alt="Delete this lead" style="width: 49px; padding: 5px;" />
			</div>			
			<div class="menu-item mass_edit_menu_item to-left" id="mass_irrelevant_leads_button_wrap"> 
				<img src="ecard/style/image/Irrelevant-icon.png"  id="mass_irrelevant_leads_button" alt="Mark as irrelevant" style="width: 49px; padding: 5px;" />
			</div>		
			<div class="menu-item mass_edit_menu_item to-left" id="mass_delete_leads_button_wrap"> 
				<img src="ecard/style/image/Delete-icon.png"  id="mass_delete_leads_button" alt="Delete this leads" style="width: 49px; padding: 5px;" />
			</div>	
			<div class="menu-item to-left" id="buy_leads_amount_description"> 
				<div class='menu-item-desc'>
					סה"כ לתשלום: <span class="buy_leads_amount_holder"></span><span class="coin">ש"ח</span>
				</div>
			</div>			
		</div>			
	</div>

	<div style='display:none;' id='mokup_main'>
		<div id="lead_paging_loading" class='lead-row'>
			<img src="ecard/style/image/loading.gif"  id="gt_data_loadin_gif" alt="Loading" />
		</div>
		<div id='lead_row_mokup' class='lead-row'>
			<div class='lead_item mass_edit'><input type="checkbox" class='mass_edit_id' name='mass_edit[]' /></div>
			
			<div class="go_to_lead">
					<div class='lead_item date_in'></div>
					<div class='lead_item status'></div><div class='lead_item lead_recource'></div> <br/>				
					<div class='lead_item name'></div><br/>
					<div class='lead_item phone'></div>
					
					<div class='lead_item email'></div><br/>
					<div class='lead_item subject'></div>
			</div>
			
		<div class="clear"></div>
		</div>
		<form id="data_helper_form">
			<input type="hidden" id="sessid_holder" name="sessid" value="<?php echo session_id(); ?>" />
			<input type="hidden" id="lead_list_paging_row" name="lead_list_paging_row" value="0" />
			<input type="hidden" id="lead_list_paging_done" name="lead_list_paging_done" value="1" />
			<input type="hidden" id="lead_list_paging_loading" name="lead_list_paging_loading" value="0" />
		</form>
		<div id='lead_form_mokup' class='lead-form'>
			
			<div class='refund_lead_form_mask' style="display:none;">	
				<form action="javascript://" class="refund_form">
					<div class='lead_form_item form-group'>
						<h4>בקשה לזיכוי ליד: <br/><span class="lead-refund-name lead-name-holder"></span></h4>
					</div>
					<label for="reason">סיבה</label>					
					<div class='lead_form_item form-group '>

						<select name='reason' class="form-select reason-select input_style">
							<?php foreach(get_refund_reasons() as $key=>$val): ?>
								<option value='<?php echo $key; ?>'><?php echo $val; ?></option>		
							<?php endforeach; ?>
						</select>
					</div>	
					<label for="reason">הערות</label>					
					<div class='lead_form_item form-group '>
							<textarea name="comment" class="input_style textarea refund-comment"></textarea>
					</div>					
					<div class='lead_form_btn form-group'>
						<button type="button" class="lead_form_refund_cancel form-button">ביטול</button>
						<button type="button" class="lead_form_refund_send form-button">שלח</button>
						
					</div>	
				</form>							
			</div>	
			
			<div class='double_lead_alert_mask' style="display:none;">	
				
					<div class='lead_form_item form-group'>
						<h4>ליד כפול: ליד זה לא חויב, ולכן לא ניתן לזיכוי</h4>
						<a href= 'javascript://' class='billed_lead_link'>לחץ כאן לצפייה בליד שחוייב</a>
					</div>
												
			</div>
			
			<form action="javascript://" class="details_form">
			
				<div class='buy_lead_form_mask lead_form_mask'>	
					<div class='lead_form_item form-group'>
						<h4>האם ברצונך לפתוח פנייה זו ולהשתמש ביתרת ההודעות?<br/><span class="lead-name-holder"></span></h4>
					</div>
					<div class='lead_form_btn form-group'>
						<button type="button" class="lead_form_buy_cancel form-button">ביטול</button>
						<button type="button" class="lead_form_buy form-button">פתח</button>
						
					</div>							
				</div>
				<div class='delete_lead_form_mask lead_form_mask'>	
					<div class='lead_form_item form-group'>
						<h4>האם ברצונך למחוק פנייה זו?<br/><span class="lead-name-holder"></span></h4>
					</div>
					<div class='lead_form_btn form-group'>
						<button type="button" class="lead_form_delete_cancel form-button">ביטול</button>
						<button type="button" class="lead_form_delete form-button">מחק</button>
					</div>							
				</div>				
				<div class="lead-form-content">
					<div class='lead_form_item form-group date_in'>
					
					</div>
					<div class='lead_form_item form-group status'>
						<label for="data_arr[status]">סטטוס</label>
						<select name='data_arr[status]' class="form-select status-select input_style">
							<?php foreach(get_status_list() as $key=>$val): ?>
								<option value='<?php echo $key; ?>'><?php echo $val; ?></option>		
							<?php endforeach; ?>
						</select>
					</div>				
					<div class='lead_form_item form-group'>
						<label for="data_arr[name]">שם</label>
						<input type="text" name="data_arr[name]" value="" class="input_style text-input name" />
					</div>
					<div class='lead_form_item form-group'>
						<label for="data_arr[phone]">טלפון</label>
						<input type="text" name="nodata[phone]" value="" class="input_style text-input phone" readonly />
						<a class="hidden phone-link"  href=""><img class="phone-link-img" src="ecard/style/image/Phone-icon.png" /></a>	
					</div>				
					<div class='lead_form_item form-group'>
						<label for="data_arr[email]">אימייל</label>
						<input type="text" name="nodata[email]" value="" class="input_style text-input email" readonly  />
					</div>	
					<div class='lead_form_item form-group'>
						<label for="data_arr[subject]">נושא</label>
						<input type="text" name="data_arr[subject]" value="" class="input_style text-input subject"/>
					</div>						
					<div class='lead_form_item form-group'>
						<label for="data_arr[content]">הודעה</label>
						<textarea name="data_arr[content]" class="input_style textarea content"></textarea>
					</div>	
					<div class='lead_form_btn form-group'>
						<label for="lead_form_send"></label>
						<button type="button" class="lead_form_send form-button">שמור</button>
					</div>
					<div class='refund_request_button_wrap form-group hidden'>
						*<a href="javascript://" class="refund_request_button">לבקשת זיכוי על הליד לחץ כאן</a>
					</div>						
				</div>		
			</form>			
		</div>		
	</div>
	
</body>


</html>