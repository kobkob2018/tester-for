<?php

/* 
* Copyright © 2006 ILbiz. All Rights Reserved
* email:	webmaster@ilbiz.co.il
* 
* its the index, the right menu, function for rigth menu,
* style, scripts and all the function that site required
*/


ob_start();
if(isset($_REQUEST['sessid'])){
	session_id ($_REQUEST['sessid']);
}
session_start();
/*
error_reporting(E_ALL);
ini_set('display_errors', 1);
*/
error_reporting(0);
ini_set('display_errors', 0);

$cookie_lang = (isset($_COOKIE['managerLang']) && $_COOKIE['managerLang'] != "" ) ? $_COOKIE['managerLang']: "he";
define('LANG',$cookie_lang);
require('ecard/administration.lang.'.$cookie_lang.'.php');
if(isset($_REQUEST['unk']) && isset($_REQUEST['sesid'])){
	$_SESSION['login'] = array('unk'=>$_REQUEST['unk'],'sesid'=>$_REQUEST['sesid']);
}
require_once('../../global_func/vars.php');
require_once('ecard/global_func.php');
require("../../global_func/global_functions.php");
require("../../global_func/class.phpmailer.php");

if(isset($_REQUEST['main'])){
	require_once('ecard/get_info.php');
}

else{
	if(isset($_SESSION['login']) &&($_REQUEST['unk'] == "" || $_REQUEST['sesid'] == "")){
		$session_login = $_SESSION['login'];
	}	
		$user_unk = $session_login['unk'];;
		$sql = "select * from user_e_card_settings where unk = '$user_unk'";
		$res = mysql_db_query(DB, $sql);
		$user_data = mysql_fetch_array($res);
		$user_row_id = false;
		$settings_edit_messege = array();
		$card_is_active = false;
		$allow_activate = false;
		$open_card_form_link = "https://10card.co.il/landing.php?ld=473";
		if($user_data['id'] != ""){
			$user_row_id = $user_data['id'];
			if($user_data['active'] == '1'){
				$card_is_active = true;
				$allow_activate = true;
			}
		}
		//allow activate without contract
		$allow_activate = true;		
		//if contract is required for activation(old versions..)
		if(!$allow_activate){
			$sys_user_sql = "SELECT * FROM users WHERE unk = '".$user_unk."'";
			$sys_user_res = mysql_db_query(DB,$sys_user_sql);
			$sys_user_data = mysql_fetch_array($sys_user_res);
			$sys_user_email = $sys_user_data['email'];
			$contrct_sql = "SELECT * FROM contract_design WHERE identifier = 'e_card_open_contract'";
			$contract_res = mysql_db_query(DB,$contrct_sql);
			$contract_data = mysql_fetch_array($contract_res);
			$contract_design_id = $contract_data['id'];
			$contract_design_unk = $contract_data['unk'];
			$apply_sql = "SELECT * FROM contract_apply WHERE contract_id = '$contract_design_id' AND fully_approved = '1' AND emails LIKE(\"%$sys_user_email%\")";
			$apply_res = mysql_db_query(DB,$apply_sql);
			$apply_data = mysql_fetch_array($apply_res);
			if($apply_data['id']!=""){
				$allow_activate = true;
			}
		}	
	require_once('ecard/main_template.php');	
}

exit();
