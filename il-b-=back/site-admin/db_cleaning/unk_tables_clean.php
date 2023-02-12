<?php 
require('../../global_func/vars.php');

function get_unk_list(){
	$sql = "SELECT unk FROM users_to_delete";
	$res = mysql_db_query(DB,$sql);

	$c = 0;
	$unk_list = "";

	while( $data = mysql_fetch_array($res) ){
		if($c!=0){
			$unk_list .= ",";
		}
		$unk_list .= "'".$data['unk']."'";
		$c++;
	}
	return $unk_list;
}

function get_uid_list(){
	$sql = "SELECT user_id FROM users_to_delete";
	$res = mysql_db_query(DB,$sql);

	$c = 0;
	$uid_list = "";

	while( $data = mysql_fetch_array($res) ){
		if($c!=0){
			$uid_list .= ",";
		}
		$uid_list .= $data['user_id'];
		$c++;
	}
	return $uid_list;
}

$unk_list = get_unk_list();


$unk_tables = array(
'10service_deal_coupon'
,'assets_forms_view'
,'asset_data'
,'asset_field'
,'asset_form'
,'content_pages'
,'custom_netanya_users'
,'deleted_adv_menu_links'
,'dynamic_client_form'
,'dynamic_client_form_users_values'
,'dynamic_client_form_values'
,'dynamic_client_form_values_text'
,'estimate_miniSite_defualt_block'
,'helpdesk'
,'ilbiz_launch_fee'
,'leads_phone_billed'
,'leads_refun_requests'
,'marketing_partners'
,'net_mailing_msg_mails'
,'net_mailing_question_answer'
,'net_mailing_queue_users'
,'net_mailing_settings'
,'net_users_client_messg'
,'net_users_client_messgSentMail'
,'sites_landingPage_links'
,'sites_landingPage_modules'
,'sites_landingPage_paragraph'
,'sites_landingPage_settings'
,'sites_leads_check'
,'sites_leads_stat'
,'site_301_redirections'
,'statistic_site_users'
,'users_calendar_headline'
,'users_diary'
,'users_links_menu_settings'
,'users_phones'
,'user_articels'
,'user_articels_cat'
,'user_bookkeeping'
,'user_bottomMenu_link'
,'user_calender_events'
,'user_clients'
,'user_colors_set'
,'user_contact_forms'
,'user_contact_subjects'
,'user_design_page'
,'user_design_page_cat'
,'user_ecom_items'
,'user_ecom_orders'
,'user_ecom_settings'
,'user_extra_settings'
,'user_e_card_forms'
,'user_e_card_gallery'
,'user_e_card_settings'
,'user_gallery_cat'
,'user_gallery_images'
,'user_gb_response'
,'user_hp_conf'
,'user_images_cat_subject'
,'user_lead_more'
,'user_lead_settings'
,'user_lead_tashlom'
,'user_more_link'
,'user_news'
,'user_products'
,'user_products_cat'
,'user_products_subject'
,'user_realty'
,'user_sales'
,'user_site_auth'
,'user_site_auth_belong'
,'user_site_settings'
,'user_text_libs'
,'user_topMenu_link'
,'user_video'
,'user_video_cat'
,'user_words'
,'user_yad2');

$c = 0;
foreach ($unk_tables as $table_name){
	if(true){
		$sql = "DELETE FROM $table_name WHERE unk IN(".$unk_list.")";
		$res = mysql_db_query(DB,$sql);
		$count_arr = mysql_fetch_array($res);
		echo $table_name.":deleted</br><br/>";
	}
	$c++;
}

$sql = "DELETE FROM user_lead_sent WHERE sendToUnk IN(".$unk_list.")";
$res = mysql_db_query(DB,$sql);
$count_arr = mysql_fetch_array($res);
echo "user_lead_sent".":deleted<br/>";

echo "<br/>----------------<br/><br/>";

$uid_tables = array(
	'10service_user_stat_view'
	,'10_service_group_buy'
	
	,'users_send_estimate_form'
	,'user_cat'
	,'user_cat_city'
	,'user_extra_premmissions'
	,'user_leads_limit'
	,'user_leads_limit_demo'
	,'user_lead_cities'
	,'user_lead_rotation'
	,'user_lead_rotation_demo'
	,'user_portal');

$uid_list = get_uid_list();

$c = 0;
foreach ($uid_tables as $table_name){
	if(true){
		$sql = "DELETE FROM $table_name WHERE user_id IN(".$uid_list.")";
		$res = mysql_db_query(DB,$sql);
		$count_arr = mysql_fetch_array($res);
		echo $table_name.":deleted<br/>";
	}
	$c++;
}

echo "<br/>----------------<br/><br/>";
$uid_type_tables = array(
'10service_stat_codes_for_user'
,'10service_stat_for_credits');

$c = 0;
foreach ($uid_type_tables as $table_name){
		$sql = "DELETE FROM $table_name WHERE user_id IN(".$uid_list.") AND user_type = 'users'";
		$res = mysql_db_query(DB,$sql);
		$count_arr = mysql_fetch_array($res);
		echo $table_name.":deleted<br/>";
	$c++;
}

echo "<br/>----------------<br/><br/>";
$unk_tables_with_sub = array(
	'user_guide'=>array(
		'user_guide_choosen_biz_guide'=>'guide_id'
		)
	,'user_guide_cities'=>array(
		'user_guide_choosen_biz_city'=>'city_id'
		)
	,'user_guide_business'=>array(
		'user_guide_choosen_biz_cat'=>'biz_id'
		)	
	,'user_guide_cats'=>array(
		'user_guide_choosen_biz_cat'=>'cat_id'
		)
	,'user_wanted'=>array(
		'user_wanted_cats'=>'wanted_id'
		)	
	,'user_banners_guide'=>array(
		'banner_choosen_biz_cat'=>'banner_id'
		)			
);

foreach ($unk_tables_with_sub as $table_name=>$table_details){
		$sql_sub = "SELECT id FROM $table_name WHERE unk IN(".$unk_list.")";
		$res_sub = mysql_db_query(DB,$sql_sub);
		$c_2 = 0;
		$sub_id_list = "";

		while( $data_sub = mysql_fetch_array($res_sub) ){
			if($c_2!=0){
				$sub_id_list .= ",";
			}
			$sub_id_list .= $data_sub['id'];
			$c_2++;
		}
		$c_2++;
		$count_arr = mysql_fetch_array($res);
		
		foreach($table_details as $table_sub_name=>$table_sub_foreignkey){
			$sql_sub_2 = "DELETE FROM ".$table_sub_name." WHERE ".$table_sub_foreignkey." IN (".$sub_id_list.")";
			
			$res_sub_2 = mysql_db_query(DB,$sql_sub_2);
			$data_sub_2 = mysql_fetch_array($res_sub_2);
			echo "----".$table_sub_name.":deleted<br/>";
		}
		$sql_sub = "DELETE FROM $table_name WHERE unk IN(".$unk_list.")";
		$res_sub = mysql_db_query(DB,$sql_sub);
		echo $table_name.":deleted<br/>";
}



$sql_products = "SELECT id FROM user_products WHERE unk IN(".$unk_list.")";
$res_products = mysql_db_query(DB,$sql_products);
$c_3 = 0;
$product_id_list = "";

while( $data_product = mysql_fetch_array($res_products) ){
	if($c_3!=0){
		$product_id_list .= ",";
	}
	$product_id_list .= $data_product['id'];
	$c_3++;
}
$c_3++;

$product_id_tables = array(
	'10service_auto_products_stock'
	,'10service_products_stock_log'
	,'10service_mask_remain_products'
);

foreach($product_id_tables as $table_name){
		$sql = "delete FROM $table_name WHERE product_id IN(".$product_id_list.")";
		
		
		$res = mysql_db_query(DB,$sql);
		$count_arr = mysql_fetch_array($res);
		echo $table_name.":deleted<br/>";
}

$sql_products = "DELETE FROM user_products WHERE unk IN(".$unk_list.")";
$res_products = mysql_db_query(DB,$sql_products);

echo "<br/>----------------<br/><br/>";
echo "user_products".":deleted<br/>";
echo "<br/>----------------<br/><br/>";

$sql = "DELETE FROM user_model_cat_belong WHERE itemId IN(".$product_id_list.") AND model = 'products'";
$res = mysql_db_query(DB,$sql);
$count_arr = mysql_fetch_array($res);
echo "user_model_cat_belong".":deleted<br/>";

echo "<br/>----------------<br/><br/>";


$user_id_with_type_tables = array(
	'10service_stat_codes_for_user'
	,'10service_stat_for_credits'
);

foreach($user_id_with_type_tables as $table_name){
		$sql = "DELETE FROM $table_name WHERE user_id IN(".$product_id_list.") AND user_type='users'";
		
		
		$res = mysql_db_query(DB,$sql);
		$count_arr = mysql_fetch_array($res);
		echo $table_name.":deleted<br/>";
}