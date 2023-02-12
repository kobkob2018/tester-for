<?php

function get_content($main)	{
	
	switch($main)	{
		
		## Genral 
		/***	START	****/
		case "menu" : // > 0
			
			if( AUTH > 0 )
				echo menu();												break;
		/***	END	****/
		
		## User Profile 
		/***	START	****/
		case "user_profile" : // > 0
			if( AUTH >= 1 )
				echo user_profile();									break;
				
		case "update_DB_profile" : // > 0
			if( AUTH >= 2 )
				echo update_DB_profile();							break;
				
		case "new_DB_profile" : // > 0
			if( AUTH >= 1 )
				echo new_DB_profile();								break;
				
		case "dell_user" : // > 0
			if( AUTH >= 9 )
				echo dell_user();											break;
		case "add_user_to_delete" : // > 0
			if( AUTH >= 9 )
				echo add_user_to_delete();											break;		
		case "remove_user_to_delete" : // > 0
			if( AUTH >= 9 )
				echo remove_user_to_delete();											break;				
		case "users_list" : // > 0
			if( AUTH >= 1 )
				echo users_list();										break;
		case "users_to_delete_list" : // > 0
			if( AUTH >= 1 )
				echo users_to_delete_list();										break;		
		case "change_site_domain" : // > 0
			if( AUTH >= 8 )
				echo change_site_domain();										break;
		case "global_settings" : // > 0
			if( AUTH >= 8 )
				echo global_settings();										break;	
		case "global_guides" :								
			if( AUTH >= 8 )	{	
				require_once('guides.php');
			}
			break;			
		case "change_site_domain_CONF" : // > 0
			if( AUTH >= 8 )
				echo change_site_domain_CONF();										break;
		/***	END	****/
		
		# Words
		/***	START	****/
		case "site_words" : // >= 1
			if( AUTH >= 2 )
				echo site_words();										break;
		case "update_DB_words" : // >= 1
			if( AUTH >= 2 )
				echo update_DB_words();								break;
		/***	END	****/
		
		# Colore Sets
		/***	START	****/
		case "colors_set_list" : // >= 1
			if( AUTH >= 2 )
				echo colors_set_list();							break;
				
		case "update_set_colors" : // >= 1
			if( AUTH >= 2 )
				echo update_set_colors();						break;
				
		case "update_DB_color_set" : // >= 1
			if( AUTH >= 2 )
				echo update_DB_color_set();					break;
		
		case "del_img_DB_FTP" : // >= 1
			if( AUTH >= 2 )
				echo del_img_DB_FTP();					break;
		
		case "updateCastumHtml" : // >= 1
			if( AUTH >= 2 )
				echo updateCastumHtml();					break;	
		
		case "updateCastumHtml_DB" : // >= 1
			if( AUTH >= 2 )
				echo updateCastumHtml_DB();					break;	
				
		/***	END	****/
		
		# Portal settings
		/***	START	****/
		case "portal_settings" : // >= 2
			if( AUTH >= 2 )
				echo portal_settings();							break;
				
		case "update_DB_portal_set" : // >= 2
			if( AUTH >= 2 )
				echo update_DB_portal_set();				break;
		
		case "delete_DB_portal_set" : // >= 2
			if( AUTH >= 2 )
				echo delete_DB_portal_set();				break;
		/***	END	****/
		
		# Owners update and list
		/***	START	****/
		case "owners_list" : // >= 9
			if( AUTH >= 9 )
				echo owners_list();								break;
				
		case "owners_profile" : // >= 9
			if( AUTH >= 9 )
				echo owners_profile();						break;
				
		case "update_DB_owner" : // >= 9
			if( AUTH >= 9 )
				echo update_DB_owner();						break;
				
		case "new_DB_owner" : // >= 9
			if( AUTH >= 9 )
				echo new_DB_owner();							break;
				
		case "del_DB_owner" : // >= 9
			if( AUTH >= 9 )
				echo del_DB_owner();							break;
		
		case "delete_site_domain" : // >= 9
			if( AUTH >= 9 )
				echo delete_site_domain();							break;
		
		case "delete_site_domain_DB" : // >= 9
			if( AUTH >= 9 )
				echo delete_site_domain_DB();							break;
		
		case "search_value_at_site" : // >= 9
			if( AUTH >= 9 )
				echo search_value_at_site();							break;
		
		case "search_value_at_site_prosses" : // >= 9
			if( AUTH >= 9 )
				echo search_value_at_site_prosses();							break;
		/***	END	****/
		
		
		
		## CAT
		/***	START	****/
		case "cat_system" : // >= 9
			if( AUTH >= 8 )
				echo cat_system();		break;
		case "cat_system_missfit_cats" :								
			if( AUTH >= 8 )	{	
				require_once('cat_system_missfit_cats.php');
				echo cat_system_missfit_cats();	
			}
		break;	
		case "cat_phone_display_hours" :								
			if( AUTH >= 8 )	{	
				require_once('cat_phone_display_hours.php');
				echo cat_phone_display_hours();	
			}
		break;		
		case "up_in_cat" : // >= 9
			if( AUTH >= 8 )
				echo up_in_cat();		break;
		case "update_DB_cat" : // >= 9
			if( AUTH >= 8 )
				echo update_DB_cat();		break;
		case "new_DB_cat" : // >= 9
			if( AUTH >= 8 )
				echo new_DB_cat();		break;
		case "del_DB_cat" : // >= 9
			if( AUTH >= 8 )
				echo del_DB_cat();		break;
		case "del_img_DB_FTP_mysave" : // >= 9
			if( AUTH >= 8 )
				echo del_img_DB_FTP_mysave();		break;
		/***	END	****/
		case "mysaveButtonList" : // >= 9
			if( AUTH >= 8 )
				echo mysaveButtonList();		break;
		/***	END	****/
		case "mysaveButtonEdit" : // >= 9
			if( AUTH >= 8 )
				echo mysaveButtonEdit();		break;
		/***	END	****/
		case "mysaveButtonEditDB" : // >= 9
			if( AUTH >= 8 )
				echo mysaveButtonEditDB();		break;
		/***	END	****/
		
		
		
		## view_contacts
		/***	START	****/
		case "view_contacts" : // >= 9
			if( AUTH >= 3 )
				echo view_contacts();		break;
		case "change_status_for_contact" : // >= 9
			if( AUTH >= 3 )
				echo change_status_for_contact();		break;
		/***	END	****/
		
		## view_contacts
		/***	START	****/
		case "view_estimate_form_list" : // >= 3
			if( AUTH >= 3 )
				echo view_estimate_form_list();		break;
		case "customers_outof_leads" : // >= 3
			if( AUTH >= 3 )
				echo customers_outof_leads();		break;			
		case "view_estimate_form_refund_list" : // >= 3
			if( AUTH >= 3 )
				echo view_estimate_form_refund_list();		break;			
		case "send_estimate_form_users_list" : // >= 9
			if( AUTH >= 3 )
				echo send_estimate_form_users_list();		break;
		case "send_estimate_form_users_edit" : // >= 9
			if( AUTH >= 3 )
				echo send_estimate_form_users_edit();		break;
		case "send_estimate_form_users_analysis_form" : // >= 9
			if( AUTH >= 3 )
				echo send_estimate_form_users_analysis_form();		break;	
		case "send_estimate_form_users_analysis" : // >= 9
			if( AUTH >= 3 )
				echo send_estimate_form_users_analysis();		break;				
		case "send_estimate_form_users_edit_DB" : // >= 9
			if( AUTH >= 3 )
				echo send_estimate_form_users_edit_DB();		break;
		case "send_estimate_to_users_Mechine" : // >= 9
			if( AUTH >= 3 )
				echo send_estimate_to_users_Mechine();		break;
		/***	END	****/
		case "estimate_form_show_in_mysave" : // >= 9
			if( AUTH >= 3 )
				echo estimate_form_show_in_mysave();		break;
		/***	END	****/
		
		
		
		## Marketing Partners
		/***	START	****/
		case "marketing_partners" : // >= 9
			if( AUTH >= 8 )
				echo marketing_partners();		break;
		case "banners_marketing_partners" : // >= 9
			if( AUTH >= 8 )
				echo banners_marketing_partners();		break;
		case "view_bann_MP" : // >= 9
			if( AUTH >= 8 )
				echo view_bann_MP();		break;
		case "update_bann_MP" : // >= 9
			if( AUTH >= 8 )
				echo update_bann_MP();		break;
		case "update_DB_bann_MP" : // >= 9
			if( AUTH >= 8 )
				echo update_DB_bann_MP();		break;
		case "del_bann_MP" : // >= 9
			if( AUTH >= 8 )
				echo del_bann_MP();		break;
		/***	END	****/
		
		
		## Run Masseg Portal   --> view_contacts.php
		/***	START	****/
		case "RunMassegPortal" : // >= 9
			if( AUTH >= 8 )
				echo RunMassegPortal();		break;
		case "UpdateRunMassegPortal" : // >= 9
			if( AUTH >= 8 )
				echo UpdateRunMassegPortal();		break;
		case "UpdateDB_RunMassegPortal" : // >= 9
			if( AUTH >= 8 )
				echo UpdateDB_RunMassegPortal();		break;
		/***	END	****/
		
		
		
		## Portal Banner System   --> view_contacts.php
		/***	START	****/
		case "PortalBannerSystem" : // >= 9
			if( AUTH >= 8 )
				echo PortalBannerSystem();		break;
		case "UPdatePortalBannerSystem" : // >= 9
			if( AUTH >= 8 )
				echo UPdatePortalBannerSystem();		break;
		case "UPdateDB_PortalBannerSystem" : // >= 9
			if( AUTH >= 8 )
				echo UPdateDB_PortalBannerSystem();		break;
		case "Del_DB_PortalBannerSystem" : // >= 9
			if( AUTH >= 8 )
				echo Del_DB_PortalBannerSystem();		break;
		/***	END	****/
		
		## 69   --> functions.php
		/***	START	****/
		case "sn_example_sites" : // >= 9
			if( AUTH >= 8 )
				echo sn_example_sites();		break;
		case "sn_example_sites_DB_update" : // >= 9	
			if( AUTH >= 8 )
				echo sn_example_sites_DB_update();		break;
		/***	END	****/
		
		
		
		## langs func
		/***	START	****/
		case "langs_list" : // >= 9
			if( AUTH >= 9 )
				echo langs_list();		break;
		case "langs_choose_words_zone" : // >= 9
			if( AUTH >= 9 )
				echo langs_choose_words_zone();		break;
		/***	END	****/
		
		
		## TEMP VLADI toDo view_contacts.php
		case "temp_vladi_todo" : // >= 9
			if( AUTH >= 9 )
				echo temp_vladi_todo();		break;
		case "edit_temp_vladi_todo" : // >= 9
			if( AUTH >= 9 )
				echo edit_temp_vladi_todo();		break;
		case "edit_temp_vladi_todo_DB" : // >= 9
			if( AUTH >= 9 )
				echo edit_temp_vladi_todo_DB();		break;
		/***	END	****/
		
		
		## messagesSinon            ->              owners_func.php
		case "messagesSinon" :									if( AUTH >= 8 )				echo messagesSinon();									break;
		case "edit_messagesSinon" : 						if( AUTH >= 8 )				echo edit_messagesSinon();						break;
		case "del_messagesSinon" : 							if( AUTH >= 9 )				echo del_messagesSinon();							break;
		case "edit_messagesSinon_DB" :					if( AUTH >= 8 )				echo edit_messagesSinon_DB();					break;
		case "messagesSinon_send_mail" :				if( AUTH >= 8 )				echo messagesSinon_send_mail();				break;
		/***	END	****/
		
		
		## NET            ->              net_func.php
		case "net_menu" :												if( AUTH >= 8 )	echo net_menu();													break;
		case "net_client_banners" :							if( AUTH >= 8 )	echo net_client_banners();								break;
		case "net_client_banners_edit" :				if( AUTH >= 8 )	echo net_client_banners_edit();						break;
		case "net_client_banners_edit_DB" :			if( AUTH >= 8 )	echo net_client_banners_edit_DB();				break;
		case "net_client_banners_DEL" :					if( AUTH >= 8 )	echo net_client_banners_DEL();						break;
		case "net_client_banners_DEL_FTP" :			if( AUTH >= 8 )	echo net_client_banners_DEL_FTP();				break;
		
		case "net_add_site_banners" :						if( AUTH >= 8 )	echo net_add_site_banners();							break;
		case "net_add_site_banners_DB" :				if( AUTH >= 8 )	echo net_add_site_banners_DB();						break;
		case "net_DELL_site_banners_DB" :				if( AUTH >= 8 )	echo net_DELL_site_banners_DB();					break;
		
		
		case "users_dynamic_net_form" :					if( AUTH >= 8 )	echo users_dynamic_net_form();						break;
		case "net_dynamic_form_edit" :					if( AUTH >= 8 )	echo net_dynamic_form_edit();							break;
		case "net_dynamic_form_edit_DB" :				if( AUTH >= 8 )	echo net_dynamic_form_edit_DB();					break;
		case "net_dynamic_form_options_edit" :	if( AUTH >= 8 )	echo net_dynamic_form_options_edit();			break;
		case "net_dynamic_form_options_edit_DB":if( AUTH >= 8 )	echo net_dynamic_form_options_edit_DB();	break;
		case "net_dynamic_form_options_DELL":		if( AUTH >= 8 )	echo net_dynamic_form_options_DELL();			break;
		case "net_dynamic_form_DELL":						if( AUTH >= 8 )	echo net_dynamic_form_DELL();							break;
		
		
		case "view_calender_style_defualt" :		echo view_calender_style_defualt();												break;
		
		/***	END	****/
		
		
		## MYSAVE 			--->>				mysave_functions
		case "mysaveGenralLinks" :								if( AUTH >= 8 )		echo mysaveGenralLinks();									break;
		case "mysaveGenralLinksEdit" :						if( AUTH >= 8 )		echo mysaveGenralLinksEdit();							break;
		case "mysaveGenralLinksEdit_update_DB" :	if( AUTH >= 8 )		echo mysaveGenralLinksEdit_update_DB();		break;
		case "mysaveGenralLinksEdit_DELL" :				if( AUTH >= 8 )		echo mysaveGenralLinksEdit_DELL();				break;
		
		case "createMysaveForm" :									if( AUTH >= 1 )		echo createMysaveForm();									break;
		case "leadsPayments" :										if( AUTH >= 9 )		echo leadsPayments();											break;
		case "leadsUserGet" :											if( AUTH >= 9 )		echo leadsUserGet();											break;
		case "leadsUserGet_client_csv" :					if( AUTH >= 9 )		echo leadsUserGet_client_csv();						break;
		case "sentLeadsAll" :											if( AUTH >= 8 )		echo sentLeadsAll();											break;
		case "user_lead_settings" :								if( AUTH >= 3 )		echo user_lead_settings();								break;
		case "user_lead_settings_DB" :						if( AUTH >= 3 )		echo user_lead_settings_DB();							break;
		case "user_cat_settings" :						
			if( AUTH >= 3 ){		
				require_once('user_cat_settings.php');
				echo user_cat_settings();	
			
			}
			break;
			
			
		/***	END	****/
		## income_reports 			--->>				bookkipng_functions.php
		case "daily_income_report" :								
			if( AUTH >= 8 )	{	
				require_once('daily_income_reports.php');
				echo daily_income_report();	
			}
			break;
		case "monthly_income_report" :								
			if( AUTH >= 8 )	{	
				require_once('monthly_income_reports.php');
				echo monthly_income_reports();	
			}
			break;			
		## income_reports 			--->>				bookkipng_functions.php
		case "misscalls_leads_reports" :								
			if( AUTH >= 8 )	{	
				require_once('misscalls_leads_reports.php');
				echo misscalls_leads_reports();	
			}
			break;	
		case "affiliates" :								
			if( AUTH >= 8 )	{	
				require_once('affiliates.php');
				echo affiliates();	
			}
			break;				
		## income_reports 			--->>				bookkipng_functions.php
		case "net_system" :								
			if( AUTH >= 8 )	{	
				require_once('net_system.php');
				echo net_system();	
			}
			break;	
		case "private_contacts_imports" :								
			if( AUTH >= 8 )	{	
				require_once('private_contacts_imports.php');
				echo private_contacts_imports();	
			}
			break;			
		case "shabat_system" :								
			if( AUTH >= 8 )	{	
				require_once('shabat_system.php');
				echo shabat_system();	
			}
			break;
		case "custom_lead_reports" :								
			if( AUTH >= 8 )	{	
				require_once('custom_lead_reports.php');
				echo custom_lead_reports();	
			}
			break;			
		## BookKipnig 			--->>				bookkipng_functions.php
		case "bookkiping_end_date" :								if( AUTH >= 8 )		echo bookkiping_end_date();							break;

		## E_CARDS 			--->>				bookkipng_functions.php
		case "manage_e_card_icons" :								if( AUTH >= 8 )		echo manage_e_card_icons();							break;
		case "manage_user_e_card_icons" :								if( AUTH >= 8 )		echo manage_user_e_card_icons();							break;
		case "user_e_card_list" :								if( AUTH >= 8 )		echo user_e_card_list();							break;
		
		/***	END	****/
		
		## Estimate Statistic  -->>    estimate_stat_functions.php
		case "estimate_stat_list" :									if( AUTH >= 9 )		echo estimate_stat_list();						break;
		case "estimate_stats_by_groups" :						if( AUTH >= 9 )		echo estimate_stats_by_groups();					break;
		case "estimate_statistics_list" :									if( AUTH >= 9 )		echo estimate_statistics_list();		break;
		
		
		## functions_11.php
		case "launch_fee_to_client" :								if( AUTH >= 8 )		echo launch_fee_to_client();							break;
		case "launch_fee_to_client_DB" :						if( AUTH >= 8 )		echo launch_fee_to_client_DB();						break;
		case "launch_fee_deleted" :									if( AUTH >= 8 )		echo launch_fee_deleted();								break;
		case "launch_fee_that_open" :								if( AUTH >= 9 )		echo launch_fee_that_open();							break;
		case "user_advanced_settings" :							if( AUTH >= 9 )		echo user_advanced_settings();						break;
		case "user_advanced_settings_DB" :					if( AUTH >= 9 )		echo user_advanced_settings_DB();					break;
		case "centered_contact" :										if( AUTH >= 8 )		echo centered_contact();									break;
		case "centered_contact_DB" :								if( AUTH >= 8 )		echo centered_contact_DB();								break;
		case "ilbizProducts" :											if( AUTH >= 9 )		echo ilbizProducts();											break;
		case "ilbizProducts_edit" :									if( AUTH >= 9 )		echo ilbizProducts_edit();								break;
		case "ilbizProducts_DB" :										if( AUTH >= 9 )		echo ilbizProducts_DB();
		break;
		/***	END	****/
		
		case "anf" : //additional_new_func
			
			if( AUTH >= 3 ){
				$file_name = $_REQUEST['gf']; //get_file
				if(isset($_REQUEST['gfunc'])){
					$func_name = $_REQUEST['gfunc']; //get_function
				}
				else{
					$func_name = $file_name;
				}
				require_once($file_name.'.php');
				$func_name();
			}
		break;		
	}
}

/************************************************************************************************/

function get_headline($main)	{
	switch($main)	{
		
		# Genral 
		/***	START	****/
		case "menu" :								echo "תפריט ראשי";											break;
		/***	END	****/

		# User Profile 
		/***	START	****/
		case "user_profile" :				echo "הוספה / עדכון פרטי אתר ולקוח";		break;
		case "users_list" :					echo "רשימת אתרים במערכת";							break;
		/***	END	****/

		# Words
		/***	START	****/
		case "site_words" :					echo "רשימת מילים לאתר";								break;
		case "change_site_domain" :	echo "החלפת דומיין לאתר";								break;
		/***	END	****/

		# Colore Sets
		/***	START	****/
		case "colors_set_list" :		echo "רשימת סטים של צבעים";							break;
		case "update_set_colors" :	echo "ניהול צבעים ועיצובי אתר";					break;
		/***	END	****/
		
		# CAT
		/***	START	****/
		case "cat_system" :			echo "תפריט קטגוריות";				break;
		case "up_in_cat" :			echo "הוספה/עדכון קטגוריה";			break;
		/***	END	****/
		
		# view_contacts
		/***	START	****/
		case "view_contacts" :			echo "מערכת פניות";				break;
		/***	END	****/
		
		
		# Marketing Partners
		/***	START	****/
		case "marketing_partners" :			echo "שיווק שותפים";				break;
		case "banners_marketing_partners" :			echo "שיווק שותפים - מיקומים";				break;
		case "view_bann_MP" :						echo "שיווק שותפים - באנרים";				break;
		case "update_bann_MP" :						echo "שיווק שותפים - באנרים - הוספה/עדכון באנר";				break;
		/***	END	****/
		
		
		
		# Run Masseg Portal
		/***	START	****/
		case "RunMassegPortal" :			echo "פרסום במודעות רצות בפורטל";				break;
		case "UpdateRunMassegPortal" :			echo "פרסום במודעות רצות בפורטל - עדכון מודעה";				break;
		/***	END	****/
		
		# 69
		/***	START	****/
		case "sn_example_sites" :			echo "עדכון דוגמאות לאתרים באתר 69";				break;

		/***	END	****/
		
		
		# MY SAVE
		/***	START	****/
		case "view_estimate_form_list" :			echo "רשימת הצעות מחיר שהתקבלו מכלל אתרי השוואות מחיר ";				break;
		case "customers_outof_leads" :			echo "לקוחות עם 0 לידים ";				break;		
		case "view_estimate_form_refund_list" :			echo "רשימת בקשות לזיכוי על לידים";				break;		
		case "send_estimate_form_users_list" :			echo "רשימת לקוחות המתאימים לפי קטגוריה להצעת המחיר";				break;

		/***	END	****/
		
		
		# LANGS func
		/***	START	****/
		case "langs_list" :			echo "שפות במערכת";				break;
		case "langs_choose_words_zone" :			echo "שפות במערכת - איזור עדכון המילים";				break;
		/***	END	****/
		
		
		# Net
		/***	START	****/
		case "users_dynamic_net_form" :						echo "שדות דינמיים של דף הרשמה, מועדון. רשימת השדות למילוי בטופס";				break;
		case "net_dynamic_form_edit" :						echo "הוספה / עריכה של שדה בטופס דינמי";				break;
		
		/***	END	****/
		
	}
}

function estimate_domain_type()
{
	return array( "0" => "mysave.co.il" , "1" => "12free.co.il", "2" => "greenprice" );
}
?>