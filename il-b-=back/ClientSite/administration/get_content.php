<?php

function get_content($main)	{
	
	switch($main)	{
		
		case "menu" :				AdvProgramAndMessages();		break;
		## TEXT 
		/***	START	****/
		case "text" :					if( eregi( "@ab@" , STRING_AUTH ) || AUTH_ID == 0 )	echo text();					break;
		case "update_text" :			if( eregi( "@ab@" , STRING_AUTH ) || AUTH_ID == 0 )	echo update_text();				break;
		case "getIfream" :		if(  AUTH_ID == 0 )	getIfream();				break;
		case "edit_estimateMiniSiteBlock" :				if(  AUTH_ID == 0 )	edit_estimateMiniSiteBlock();						break;
		case "edit_estimateMiniSiteBlock_DB" :		if(  AUTH_ID == 0 )	edit_estimateMiniSiteBlock_DB();				break;
		case "edit_estimateMiniSiteBlock_contentDB" :		if(  AUTH_ID == 0 )	edit_estimateMiniSiteBlock_contentDB();				break;
		case "duplicateCityiesPages" :							if(  AUTH_ID == 0 )	duplicateCityiesPages();						break;
		case "duplicateCityiesPagesDB" :							if(  AUTH_ID == 0 )	duplicateCityiesPagesDB();						break;
		
		/***	END	****/
		
		
		## Genral 
		/***	START	****/
		case "List_View_Rows" :			echo List_View_Rows();			break;
		case "payments_list" :			echo payments_list();			break;
		case "payment_heshbonit" :			echo payment_heshbonit();			break;
		case "get_create_form" :		echo get_create_form();			break;
		case "update_new_row" :			echo update_new_row();			break;
		case "get_create_form_Multi" :		echo get_create_form_Multi();			break;
		case "update_new_row_Multi" :			echo update_new_row_Multi();			break;
		case "DEL_row" :				echo DEL_row();					break;
		case "del_img_DB_FTP" :			echo del_img_DB_FTP();			break;
		case "funcSetCatForUsers" :			echo funcSetCatForUsers();			break;
		case "SetCatUniversal" :			echo SetCatUniversal();			break;
		case "GuideSetCat" :			echo GuideSetCat();			break;
		case "BannerSetCat" :			echo BannerSetCat();			break;
		case "selected_contact_change_status" :			echo selected_contact_change_status();			break;
		/***	END	****/
		
		
		## Site Settings 
		/***	START	****/
		case "site_settings_form" :		if( AUTH_ID == 0 ) echo site_settings_form();		break;
		case "update_site_settings" :	if( AUTH_ID == 0 ) echo update_site_settings();	break;
		/***	END	****/
		
		
		## Products
		/***	START	****/
		case "prices_update" :			if( AUTH_ID == 0 ) echo prices_update();			break;
		case "prices_update_prosses" :		if( AUTH_ID == 0 ) echo prices_update_prosses();		break;
		/***	END	****/
		
		
		
		## User Profile
		/***	START	****/
		case "update_profile" :
			if( AUTH_ID == 0 || (  UNK == "263512086634836547" && AUTH_ID != 0 ) ) echo update_profile();
		break;
		case "DB_update_profile" :
			if( AUTH_ID == 0 || (  UNK == "263512086634836547" && AUTH_ID != 0 ) ) echo DB_update_profile();
		break;
		/***	END	****/
		
		
		## קישורים נוספים
		/***	START	****/
		case "more_link" :				if( AUTH_ID == 0 ) echo more_link();				break;
		case "update_DB_link" :			if( AUTH_ID == 0 ) echo update_DB_link();			break;
		case "add_DB_link" :			if( AUTH_ID == 0 ) echo add_DB_link();				break;
		case "del_DB_link" :			if( AUTH_ID == 0 ) echo del_DB_link();				break;
		/***	END	****/
		
		## קישורים לתפריט עליון
		/***	START	****/
		case "topMenu_link" :				if( AUTH_ID == 0 ) echo topMenu_link();				break;
		case "update_DB_topMenu_link" :			if( AUTH_ID == 0 ) echo update_DB_topMenu_link();			break;
		case "add_DB_topMenu_link" :			if( AUTH_ID == 0 ) echo add_DB_topMenu_link();				break;
		case "del_DB_topMenu_link" :			if( AUTH_ID == 0 ) echo del_DB_topMenu_link();				break;
		/***	END	****/

		## קישורים לתפריט תחתון
		/***	START	****/
		case "bottomMenu_link" :				if( AUTH_ID == 0 ) echo bottomMenu_link();				break;
		case "update_DB_bottomMenu_link" :			if( AUTH_ID == 0 ) echo update_DB_bottomMenu_link();			break;
		case "add_DB_bottomMenu_link" :			if( AUTH_ID == 0 ) echo add_DB_bottomMenu_link();				break;
		case "del_DB_bottomMenu_link" :			if( AUTH_ID == 0 ) echo del_DB_bottomMenu_link();				break;
		/***	END	****/		
		
		## Gallery
		/***	START	****/
		case "gallery_grid" :			if( eregi( "@ga@" , STRING_AUTH ) || AUTH_ID == 0 )	echo gallery_grid();			break;
		case "edit_picture" :			if( eregi( "@ga@" , STRING_AUTH ) || AUTH_ID == 0 )	echo edit_picture();			break;
		case "add_5_pics" :				if( eregi( "@ga@" , STRING_AUTH ) || AUTH_ID == 0 )	echo add_5_pics();				break;
		case "del_DB_pic" :				if( eregi( "@ga@" , STRING_AUTH ) || AUTH_ID == 0 )	echo del_DB_pic();				break;
		case "add_DB_pic_gellery" :		if( eregi( "@ga@" , STRING_AUTH ) || AUTH_ID == 0 )	echo add_DB_pic_gellery();		break;
		case "update_DB_pic_gellery" :	if( eregi( "@ga@" , STRING_AUTH ) || AUTH_ID == 0 )	echo update_DB_pic_gellery();	break;
		case "add_DB_5_pics_gellery" :	if( eregi( "@ga@" , STRING_AUTH ) || AUTH_ID == 0 )	echo add_DB_5_pics_gellery();	break;
		case "upload_multi_img" :	if( eregi( "@ga@" , STRING_AUTH ) || AUTH_ID == 0 )	echo upload_multi_img();	break;
		/***	END	****/
		
		## HP
		/***	START	****/
		case "homepage" :			if( AUTH_ID == 0 ) echo homepage();			break;
		case "update_hp_conf" :			if( AUTH_ID == 0 ) echo update_hp_conf();			break;
		/***	END	****/
		
		## E-COM
		/***	START	****/
		case "ecom_settings" :			if( AUTH_ID == 0 ) echo ecom_settings();			break;
		case "DB_update_ecom_settings" :			if( AUTH_ID == 0 ) echo DB_update_ecom_settings();			break;
		case "ecomOrders" :			if( AUTH_ID == 0 ) echo ecomOrders();			break;
		case "ecomOrderView" :			if( AUTH_ID == 0 ) echo ecomOrderView();			break;
		case "ecomOrderDel" :			if( AUTH_ID == 0 ) echo ecomOrderDel();			break;
		case "ecomOrder_statusDB" :			if( AUTH_ID == 0 ) echo ecomOrder_statusDB();			break;
		
		case "users_ecom_buy" :			if( AUTH_ID == 0 ) echo users_ecom_buy();			break;
		case "users_ecom_buyView" :			if( AUTH_ID == 0 ) echo users_ecom_buyView();			break;
		case "users_ecom_buyDel" :			if( AUTH_ID == 0 ) echo users_ecom_buyDel();			break;
		case "users_ecom_buy_statusDB" :			if( AUTH_ID == 0 ) echo users_ecom_buy_statusDB();			break;
		/***	END	****/
		
		
		## E-COM
		/***	START	****/
		case "mailinglist" :			if( AUTH_ID == 0 ) echo mailinglist();			break;
		case "mailinglist_del_mail" :			if( AUTH_ID == 0 ) echo mailinglist_del_mail();			break;
		/***	END	****/
		
		
		## AUTH system
		/***	START	****/
		case "site_authList" :			if( AUTH_ID == 0 ) echo site_authList();			break;
		case "site_authForm" :			if( AUTH_ID == 0 ) echo site_authForm();			break;
		case "site_authDEL" :				if( AUTH_ID == 0 ) echo site_authDEL();			break;
		case "site_authDbRequest" :				if( AUTH_ID == 0 ) echo site_authDbRequest();			break;
		/***	END	****/
		
		
		## NET system
		/***	START	****/
		case "net_list" :										if( AUTH_ID == 0 ) echo net_list();										break;
		case "net_user_details" :						if( AUTH_ID == 0 ) echo net_user_details();						break;
		case "net_change_user_status" :			if( AUTH_ID == 0 ) echo net_change_user_status();			break;
		
		case "net_massg_list" :							if( AUTH_ID == 0 ) echo net_massg_list();							break;
		case "net_massg_edit" :							if( AUTH_ID == 0 ) echo net_massg_edit();							break;
		case "net_massg_edit_step2" :				if( AUTH_ID == 0 ) echo net_massg_edit_step2();				break;
		case "net_massg_edit_DB" :					if( AUTH_ID == 0 ) echo net_massg_edit_DB();					break;
		case "net_massg_edit_DB_step2" :		if( AUTH_ID == 0 ) echo net_massg_edit_DB_step2();		break;
		case "net_massg_sendMail" :					if( AUTH_ID == 0 ) echo net_massg_sendMail();					break;
		
		// net mailling
		case "net_mailing_settings" :					if( AUTH_ID == 0 ) echo net_mailing_settings();					break;
		case "net_mailing_settings_del" :			if( AUTH_ID == 0 ) echo net_mailing_settings_del();			break;
		case "net_mailing_settings_edit" :		if( AUTH_ID == 0 ) echo net_mailing_settings_edit();		break;
		case "net_mailing_settings_edit_DB" :	if( AUTH_ID == 0 ) echo net_mailing_settings_edit_DB();	break;
		case "net_mailing" :									if( AUTH_ID == 0 ) echo net_mailing();									break;
		case "net_mailing_msg" :							if( AUTH_ID == 0 ) echo net_mailing_msg();							break;
		case "net_mailing_msg_edit" :					if( AUTH_ID == 0 ) echo net_mailing_msg_edit();					break;
		case "net_mailing_msg_edit_DB" :			if( AUTH_ID == 0 ) echo net_mailing_msg_edit_DB();			break;
		case "net_mailing_msg_del" :					if( AUTH_ID == 0 ) echo net_mailing_msg_del();					break;
		case "net_mailing_qa_anw" :						if( AUTH_ID == 0 ) echo net_mailing_qa_anw();						break;
		case "net_mailing_qa_anw_edit" :			if( AUTH_ID == 0 ) echo net_mailing_qa_anw_edit();			break;
		case "net_mailing_qa_anw_del" :				if( AUTH_ID == 0 ) echo net_mailing_qa_anw_del();				break;
		case "net_mailing_qa_anw_edit_DB" :		if( AUTH_ID == 0 ) echo net_mailing_qa_anw_edit_DB();		break;
		
		case "net_mailing_report" :		if( AUTH_ID == 0 ) echo net_mailing_report();		break;
		
		/***	END	****/
		
		
		
		## Landing page - functions_10.php
		/***	START	****/
		case "LandingPage" :									if( AUTH_ID == 0 ) echo LandingPage();									break;
		case "LandingPage_edit" :							if( AUTH_ID == 0 ) echo LandingPage_edit();							break;
		case "LandingPage_edit_db" :					if( AUTH_ID == 0 ) echo LandingPage_edit_db();					break;
		case "LandingPage_del" :							if( AUTH_ID == 0 ) echo LandingPage_del();							break;
		case "LandingPage_links_del" :				if( AUTH_ID == 0 ) echo LandingPage_links_del();				break;
		case "LandingPage_module_del" :				if( AUTH_ID == 0 ) echo LandingPage_module_del();				break;
		case "LandingPage_module_pList" :			if( AUTH_ID == 0 ) echo LandingPage_module_pList();			break;
		case "LandingPage_module_pList_DB" :	if( AUTH_ID == 0 ) echo LandingPage_module_pList_DB();	break;
		case "LandingPage_module_p" :					if( AUTH_ID == 0 ) echo LandingPage_module_p();					break;
		case "LandingPage_module_p_DB" :			if( AUTH_ID == 0 ) echo LandingPage_module_p_DB();			break;
		case "LandingPage_module_p_del" :			if( AUTH_ID == 0 ) echo LandingPage_module_p_del();			break;
		/***	END	****/
		
		
		
		## calender events
		/***	START	****/
		case "calender_events" :								if( AUTH_ID == 0 ) echo calender_events();								break;
		case "calender_events_edit" :						if( AUTH_ID == 0 ) echo calender_events_edit();						break;
		case "calender_events_edit_DB" :				if( AUTH_ID == 0 ) echo calender_events_edit_DB();				break;
		case "calender_events_del" :						if( AUTH_ID == 0 ) echo calender_events_del();						break;
		case "Update_calendar_headline" :				if( AUTH_ID == 0 ) echo Update_calendar_headline();				break;
		/***	END	****/
		
		
		## 10 service -> functions_10service.php
		/***	START	****/
		case "updateCats10Servcats" :						if( AUTH_ID == 0 ) echo updateCats10Servcats();						break;
		case "updateCats10Servcats_edit" :			if( AUTH_ID == 0 ) echo updateCats10Servcats_edit();			break;
		case "updateCats10Servcats_edit_DB" :		if( AUTH_ID == 0 ) echo updateCats10Servcats_edit_DB();		break;
		
		case "edit_10service_product_images" :					if( AUTH_ID == 0 ) echo edit_10service_product_images();						break;
		case "edit_10service_product_images_Prosses" :	if( AUTH_ID == 0 ) echo edit_10service_product_images_Prosses();		break;
		case "del_product_files" :					if( AUTH_ID == 0 ) echo del_product_files();						break;
		
		case "purchase_tracking_list" :					if( AUTH_ID == 0 ) echo purchase_tracking_list();						break;
		case "purchase_tracking_edit" :					if( AUTH_ID == 0 ) echo purchase_tracking_edit();						break;
		case "purchase_tracking_edit_DB" :			if( AUTH_ID == 0 ) echo purchase_tracking_edit_DB();				break;
		
		case "suppliers_10service_list" :					if( AUTH_ID == 0 ) echo suppliers_10service_list();						break;
		case "suppliers_10service_edit" :					if( AUTH_ID == 0 ) echo suppliers_10service_edit();						break;
		case "suppliers_10service_edit_DB" :			if( AUTH_ID == 0 ) echo suppliers_10service_edit_DB();				break;
		
		case "ten_products_stock" :			if( AUTH_ID == 0 ) echo ten_products_stock();				break;
		case "ten_products_stocke_edit" :			if( AUTH_ID == 0 ) echo ten_products_stocke_edit();				break;
		case "ten_products_stocke_edit_DB" :			if( AUTH_ID == 0 ) echo ten_products_stocke_edit_DB();				break;
		case "ten_products_stock_log" :			if( AUTH_ID == 0 ) echo ten_products_stock_log();				break;
		case "change_product_stock_after" :			if( AUTH_ID == 0 ) echo change_product_stock_after();				break;
		
		
		/***	END	****/
		
		## 10 service -> functions_10service_2.php
		/***	START	****/
		case "stat_summery_10service" :						if( AUTH_ID == 0 ) echo stat_summery_10service();						break;
		
		case "right_menu_summery_leads" :						if( AUTH_ID == 0 ) echo right_menu_summery_leads();						break;
		case "buy_leads" :						if( AUTH_ID == 0 ) echo buy_leads();						break;
		case "buy_leads_goto_yaad" :						if( AUTH_ID == 0 ) echo buy_leads_goto_yaad();						break;
		case "send_lead_refund_request" : if( AUTH_ID == 0 ) echo send_lead_refund_request();						break;
		/***	END	****/
		
		
		## functions_10.php
		/***	START	****/
		case "ftpAccount" :							if( AUTH_ID == 0 ) echo ftpAccount();							break;
		case "ftpAccount_upload" :			if( AUTH_ID == 0 ) echo ftpAccount_upload();			break;
		case "ftpAccountDel" :					if( AUTH_ID == 0 ) echo ftpAccountDel();					break;

		/***	END	****/
		
		
		## functions_11.php
		/***	START	****/
		case "payWithCC" :							if( AUTH_ID == 0 ) echo payWithCC();							break;
		case "payWithCC_1ok" :					if( AUTH_ID == 0 ) echo payWithCC_1ok();					break;
		case "payWithCC_2ok" :					if( AUTH_ID == 0 ) echo payWithCC_2ok();					break;
		case "payWithCC_1er" :					if( AUTH_ID == 0 ) echo payWithCC_1er();					break;
		case "payWithCC_2er" :					if( AUTH_ID == 0 ) echo payWithCC_2er();					break;
		case "group_buy_sent_form" :		if( AUTH_ID == 0 ) echo group_buy_sent_form();		break;
		case "user_portal_cats" :				if( AUTH_ID == 0 ) echo user_portal_cats();				break;
		case "user_portal_cats_DB" :		if( AUTH_ID == 0 ) echo user_portal_cats_DB();		break;
		case "user_portal_newCities" :				if( AUTH_ID == 0 ) echo user_portal_newCities();				break;
		case "user_portal_newCities_DB" :				if( AUTH_ID == 0 ) echo user_portal_newCities_DB();				break;		
		case "link_menu_adv_settings" :		if( AUTH_ID == 0 ) echo link_menu_adv_settings();		break;
		case "link_menu_adv_settings_DB" :		if( AUTH_ID == 0 ) echo link_menu_adv_settings_DB();		break;
		case "link_menu_adv_settings_del" :		if( AUTH_ID == 0 ) echo link_menu_adv_settings_del();		break;
		case "payForLead" :		if( AUTH_ID == 0 ) echo payForLead();		break;
		case "payForLeadByCredit" :		if( AUTH_ID == 0 ) echo payForLeadByCredit();		break;
		case "payWithCredits" :		if( AUTH_ID == 0 ) echo payWithCredits();		break;
		case "open_contact_for_1_credit" :		if( AUTH_ID == 0 ) echo open_contact_for_1_credit();		break;
		case "site_301_redirections" :		if( AUTH_ID == 0 ) echo site_301_redirections();		break;
		case "item_301_redirect" :		if( AUTH_ID == 0 ) echo item_301_redirect();		break;
		/***	END	****/
		
		## functions_10service_2.php
		/***	START	****/
		case "buy_credits" :							echo buy_credits();										break;
		case "buy_credit_goto_yaad" :			echo buy_credit_goto_yaad();					break;
		case "about_credits" :						echo about_credits();									break;
		case "full_summery_credits" :			echo full_summery_credits();					break;
		case "payWithCCforCredit_1ok" :		echo payWithCCforCredit_1ok();				break;
		case "payWithCCforCredit_1er" :		echo payWithCCforCredit_1er();				break;
		case "payWithCCforLeads_1ok" :		echo payWithCCforLeads_1ok();				break;
		case "payWithCCforLeads_1er" :		echo payWithCCforLeads_1er();				break;
		case "advertisers_earn_credit" :		echo advertisers_earn_credit();				break;
		/***	END	****/
		
		
		## functions_14.php
		/***	START	****/
		case "user_realty_img" :							echo user_realty_img();										break;
		case "user_realty_img_Prosses" :			echo user_realty_img_Prosses();						break;
		case "del_user_realty_img" :					echo del_user_realty_img();								break;
		/***	END	****/
		
		## e_card_functions.php
		/***	START	****/
		case "manage_user_e_card" :			
			require_once('e_card_functions.php');
			echo manage_user_e_card();	
		break;
		case "manage_user_e_card_gallery" :			
			require_once('e_card_functions.php');
			echo manage_user_e_card_gallery();	
		break;
		case "manage_user_service_offers" :			
			require_once('user_service_offer_functions.php');
			echo manage_user_service_offers();	
		break;
		case "user_lead_send_hours" :			
			require_once('user_lead_send_hours.php');
			echo user_lead_send_hours();	
		break;				
		case "work_contracts" :			
			require_once('contract_functions.php');
			echo work_contracts();	
		break;		
		case "wanted" :			
			require_once('wanted_functions.php');
			echo wanted_editor();	
		break;		
		
		/***	END	****/		
		
	}
}

function headline()	{

	global $word;
	
	$sql = "select * from user_words where unk = '".UNK."'";
	$res = mysql_db_query(DB,$sql);
	$data_words = mysql_fetch_array($res);
	
	
	$temp_word_articels = ( $data_words['id'] == "" ) ? $word[LANG]['1_2_chapter_name_articels'] : stripslashes($data_words['word_articels']);
	$temp_word_products = ( $data_words['id'] == "" ) ? $word[LANG]['1_2_chapter_name_products'] : stripslashes($data_words['word_products']);

	$temp_word_gallery = ( $data_words['id'] == "" ) ? $word[LANG]['1_2_chapter_name_gallery'] : stripslashes($data_words['word_gallery']);
//	edit_picture
	
	$temp_word_yad2 = ( $data_words['id'] == "" ) ? $word[LANG]['1_2_chapter_name_yad2'] : stripslashes($data_words['word_yad2']);
	
	$temp_word_sales = ( $data_words['id'] == "" ) ? $word[LANG]['1_2_chapter_name_sales'] : stripslashes($data_words['word_sales']);
	$temp_word_video = ( $data_words['id'] == "" ) ? $word[LANG]['1_2_chapter_name_video'] : stripslashes($data_words['word_video']);
	$temp_word_wanted = ( $data_words['id'] == "" ) ? $word[LANG]['1_2_chapter_name_jobs'] : stripslashes($data_words['word_wanted']);
	$temp_word_contact = ( $data_words['id'] == "" ) ? $word[LANG]['1_2_chapter_name_contact'] : stripslashes($data_words['word_contact']);
	$temp_word_gb = ( $data_words['id'] == "" ) ? "" : stripslashes($data_words['word_gb']);
	
	$temp_word_news = $word[LANG]['headlines_news'];
	
	$temp_word_update = $word[LANG]['headlines_pages'];
	$temp_word_text = $word[LANG]['headlines_pages'];
	
	$temp_word_myClients = $word[LANG]['headheadlines_registedines_pages'];
	
	/*text -> taxt
	$temp_word_about = ( $data_words['id'] == "" ) ? $word[LANG]['1_2_chapter_name_about'] : stripslashes($data_words['word_about']);
	*/
	
	
	// select the title of the page
	switch($_REQUEST['main'])
	{
		case "List_View_Rows" :
			
			$temp_type = explode("_" , $_REQUEST['type'] );
			
			$temp_var = "temp_word_".$temp_type[0];
			$addMoreTitle = $word[LANG]['headlines_list']. " " . $$temp_var;
			
			if( !empty( $temp_type[1] ) )
			{
				switch($temp_type[1])
				{
					case "cat" :		 if( $temp_type[0] == "gallery" || $temp_type[0] == "products" ) $addMoreTitle .= " / ". $word[LANG]['subtopic_list'];	else	$addMoreTitle .= " / " . $word[LANG]['categories_list'];			break;
					case "subject" :		 $addMoreTitle .= " / " . $word[LANG]['topic_list'];			break;
					case "libs" :		 $addMoreTitle .= " / ". $word[LANG]['folder_list'] ;			break;
				}
			}
		break;
		
		
		case "get_create_form" :
			
			$temp_type = explode("_" , $_REQUEST['type'] );
			
			$temp_var = "temp_word_".$temp_type[0];
			$addMoreTitle =  $word[LANG]['headlines_list']. " " . $$temp_var;
			
			$update_add = ( $_REQUEST['row_id'] == "" ) ? $word[LANG]['headlines_add'] : $word[LANG]['edit'];
			if( !empty( $temp_type[1] ) )
			{
				switch($temp_type[1])
				{
					case "cat" :		 if( $temp_type[0] == "gallery" || $temp_type[0] == "products" )	$addMoreTitle .= " / ".$word[LANG]['subtopic_list']." / ".$update_add." ".$word[LANG]['sub_topic'];	else  $addMoreTitle .= " / ".$word[LANG]['categories_list']." / ".$update_add." ".$word[LANG]['cat'];			break;
					case "subject" :		 $addMoreTitle .= " / ".$word[LANG]['topic_list']."  / ".$update_add." " . $word[LANG]['subject'];			break;
				}
			}
			else
				$addMoreTitle .= " / ". $update_add . " " . $$temp_var;
		break;
		
		case "gallery_grid" :
			
			$temp_type = explode("_" , $_REQUEST['type'] );
			
			$temp_var = "temp_word_".$temp_type[0];
			$addMoreTitle =  $word[LANG]['headlines_list']. " " . $$temp_var;
			
		break;
		
		
		case "edit_picture" :
			
			$temp_type = explode("_" , $_REQUEST['type'] );
			$update_add = ( $_REQUEST['row_id'] == "" ) ?  $word[LANG]['headlines_add'] : $word[LANG]['edit'];
			
			$temp_var = "temp_word_".$temp_type[0];
			$addMoreTitle =  $word[LANG]['headlines_list']. " " . $$temp_var . " / " . $update_add . " " . $word[LANG]['picture'];
			
		break;
		
		case "calender_events" :					$addMoreTitle = $word[LANG]['headlines_site_calender'];						break;
		case "calender_events_edit" :
			$addMoreTitle = $word[LANG]['headlines_site_calender']. " / ";
			if( $_REQUEST['event_id'] )
				$addMoreTitle .= $word[LANG]['edit'];
			else
				$addMoreTitle .=  $word[LANG]['headlines_add'];
		break;
		
	}
	
	
	return $addMoreTitle;
	
}
?>