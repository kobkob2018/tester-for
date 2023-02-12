<?php
require_once('../../global_func/vars.php');
$status_list = false;
$utf8_status_list = false;
$refund_reasons = false;

function get_error($error_str){
	$error_list = array(
		'1'=>array('err_id'=>'1','err_str'=>'required_login','messege'=>'יש לבצע כניסה למערכת'),
		'2'=>array('err_id'=>'2','err_str'=>'empty_list','messege'=>'לא נמצאו רשומות'),
		'3'=>array('err_id'=>'3','err_str'=>'row_not_found','messege'=>'לא נמצאה הרשומה'),	
		'4'=>array('err_id'=>'4','err_str'=>'update_failed','messege'=>'העדכון נכשל'),
		'5'=>array('err_id'=>'5','err_str'=>'out_of_leads','messege'=>'לא נותרו לך לידים לפתיחה'),
		'6'=>array('err_id'=>'6','err_str'=>'empty_result','messege'=>'לא נמצאה הרשומה'),
		'7'=>array('err_id'=>'7','err_str'=>'invalid_user_or_pass','messege'=>'שם המשתמש או הסיסמה אינם נכונים'),
		'8'=>array('err_id'=>'8','err_str'=>'invalid_email','messege'=>'כתובת המייל שנשלחה לא נמצאה במערכת'),
		  
	);
	$err_str_list = array();
	foreach($error_list as $key=>$val_arr){
		$err_str_list[$val_arr['err_str']] = $key;
	}
	return $error_list[$err_str_list[$error_str]];
}


//for big admin refund reasons - file- functions.php
function get_refund_reasons($utf8_format = false){
	global $refund_reasons;
	global $word;
	if(!$refund_reasons){
		$refund_reasons = array();
		$sql = "SELECT * FROM cat_lead_refund_reasons WHERE cat_id = '0'";
		$res = mysql_db_query(DB,$sql);
		while($reason = mysql_fetch_array($res)){
			$refund_reasons[$reason['id']] = iconv("Windows-1255","UTF-8",$reason['title']);
		}
		//$refund_reasons[1] = $word[LANG]['invalid_phone'];
		//$refund_reasons[2] = $word[LANG]['no_answer'];
		//$refund_reasons[3] = $word[LANG]['irelevant'];
		//$refund_reasons[4] = $word[LANG]['existing_customer'];
	}
	return $refund_reasons;
}

function get_status_list($utf8_format = false){
	global $status_list;
	global $word;
	if(!$status_list){
		$status_list = array();
		$status_list[0] = $word[LANG]['Interested_service'];
		$status_list[1] = $word[LANG]['talked_with_him'];
		$status_list[5] = $word[LANG]['Waiting_phone'];
		$status_list[2] = $word[LANG]['Close_customer'];
		$status_list[3] = $word[LANG]['Registered_customers'];
		$status_list[4] = $word[LANG]['Not_relevant'];	
		$status_list[6] = $word[LANG]['Lead_Refunded'];	
	}
	
	if(!$utf8_status_list){
		$utf8_status_list = array();
		foreach ($status_list as $key=>$val){
			$utf8_status_list[$key] = iconv("Windows-1255","UTF-8",$val);
		}
	}
	if($utf8_format)
		return $utf8_status_list;
	return $status_list;
}