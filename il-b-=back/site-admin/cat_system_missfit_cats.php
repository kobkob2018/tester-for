<?php

function cat_system_missfit_cats()
{
	echo "<h3>אי התאמה בין קטגוריות משוייכות ללקוח אך לא פעילות</h3>";
	echo "<a href='?sesid=".SESID."' >חזרה לתפריט הראשי</a><br/>";
	echo "<a href='?main=cat_system&sesid=".SESID."' >חזרה למערכת קטגוריות בפורטל</a><br/>";
	
	$users_sql = "SELECT id,full_name FROM users WHERE end_date > now() AND active_manager = 0 AND status = 0";
	$users_res = mysql_db_query(DB,$users_sql);
	$user_ids = array();
	$active_users = array();
	while($user_data = mysql_fetch_array($users_res)){
		$user_ids[$user_data['id']] = $user_data['id'];
		$active_users[$user_data['id']] = $user_data;
	}
	$users_in_sql = implode(",",$user_ids);
	$active_users_cat_sql = "SELECT user_id,cat_id cat_id FROM user_cat WHERE user_id IN($users_in_sql)";
	$active_users_cat_res = mysql_db_query(DB,$active_users_cat_sql);
	$active_users_cat_ids = array();
	$cats_users = array();
	while($active_users_cat_data = mysql_fetch_array($active_users_cat_res)){
		$active_users_cat_ids[$active_users_cat_data['cat_id']] = $active_users_cat_data['cat_id'];
		if(!isset($cats_users[$active_users_cat_data['cat_id']])){
			$cats_users[$active_users_cat_data['cat_id']] = array();
		}
		$cats_users[$active_users_cat_data['cat_id']][$active_users_cat_data['user_id']] = $active_users[$active_users_cat_data['user_id']];
	}
	$active_users_cat_in_sql = implode(",",$active_users_cat_ids);
	$cats_sql = "SELECT id,status,hidden,googleADSense FROM biz_categories";
	$cats_res = mysql_db_query(DB,$cats_sql);
	$active_cats =array();
	$hidden_cats = array();
	$all_cats = array();
	while($cat_data = mysql_fetch_array($cats_res)){
		$all_cats[$cat_data['id']] = $cat_data;
		if($cat_data['status'] != '1' || $cat_data['hidden'] == '1' || $cat_data['googleADSense'] != ""){
			$hidden_cats[$cat_data['id']] = $cat_data['id'];
		}
		else{
			$active_cats[$cat_data['id']] = $cat_data['id'];
		}
	}
	$missing_cats_with_active_users = array();
	$hidden_cats_with_active_users = array();
	foreach($active_users_cat_ids as $active_users_cat_id){
		if(isset($hidden_cats[$active_users_cat_id])){
			//echo $active_users_cat_id.",<br/>";
			$hidden_cats_with_active_users[$active_users_cat_id] = $active_users_cat_id;
		}
		else{
			if(!isset($active_cats[$active_users_cat_id])){
				//echo $active_users_cat_id.",<br/>";
				$missing_cats_with_active_users[$active_users_cat_id] = $active_users_cat_id;
			}
		}
	}
	//echo implode(",",$hidden_cats_with_active_users);
	foreach($hidden_cats_with_active_users as $key=>$cat){
		$cat_tree = get_cat_tree($key);
		echo "<div style='text-align:right; direction:rtl;'>";
		echo "<br/><br/>";
		if(isset($cat_tree['father_tree'])){
			if(isset($cat_tree['father_tree']['father_tree'])){
				
				echo $cat_tree['father_tree']['father_tree']['cat_name'];
				echo " -> ";
			}
			echo $cat_tree['father_tree']['cat_name'];
			echo " -> ";
		}
		echo $cat_tree['cat_name'];
		echo "<br/>לקוחות משוייכים: ";
		foreach($cats_users[$key] as $uid=>$cat_user){
			echo $cat_user['full_name'].", ";
		}
		echo "<hr/>";
		echo "</div>";
		
	}	
	
}

function get_cat_tree($cat_id){
	$sql = "SELECT cat_name,father FROM biz_categories WHERE id = $cat_id";
	$res = mysql_db_query(DB,$sql);
	$cat_data = mysql_fetch_array($res);
	if($cat_data['father'] != '0'){
		$cat_data['father_tree'] = get_cat_tree($cat_data['father']);
	}
	return $cat_data;
}