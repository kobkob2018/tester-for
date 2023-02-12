<?php

require_once('../../global_func/vars.php');

$return_info = array();
//auto login from email by token in lead row
if(isset($_REQUEST['row_id']) && isset($_REQUEST['token'])){
	
	$sql = "select unk from user_contact_forms where 
			id = '".$_REQUEST['row_id']."' and 
			auth_token = '".$_REQUEST['token']."'";
	$res = mysql_db_query(DB,$sql);
	
	$data = mysql_fetch_array($res);
	if(isset($data['unk']) && $data['unk'] != ""){
		$_REQUEST['unk'] = $data['unk'];
		$_REQUEST['sesid'] = session_id();
		$return_info['current_screen'] = 'get_lead';
		$return_info['row_id'] = $_REQUEST['row_id'];
		//remove token
		$sql = "update user_contact_forms SET auth_token  = '' where 
				id = '".$_REQUEST['row_id']."' and 
				auth_token = '".$_REQUEST['token']."'";
		$res = mysql_db_query(DB,$sql);		
	}
		
}

if(isset($_SESSION['login']) &&($_REQUEST['unk'] == "" || $_REQUEST['sesid'] == "")){
	$session_login = $_SESSION['login'];
	$_REQUEST['unk'] = $session_login['unk'];
	$_REQUEST['sesid'] = $session_login['sesid'];
}


if(!isset($_REQUEST['unk']) || !isset($_REQUEST['sesid']) || $_REQUEST['unk'] == "" || $_REQUEST['sesid'] == "" )	{
	$return_info['login'] = '0';
	define('UNK',"");
	define('SESID',"");
}
else{
	$_SESSION['login'] = array('unk'=>$_REQUEST['unk'],'sesid'=>$_REQUEST['sesid']);
	$return_info['login'] = '1';
	define('UNK',$_REQUEST['unk']);
	define('SESID',$_REQUEST['sesid']);
}

require_once("../../global_func/global_functions.php");
require_once("../../global_func/forms_creator.php");
require_once('mobile/get_content.php');	
	
$main = ( $_REQUEST['main'] == "" ) ? "menu" : $_REQUEST['main'];

$return_info['type'] = $main;
if($return_info['login'] == '1' || $main == 'user_login' ||  $main == 'forgot_password' ){
	$return_data = get_info($main);
	if(isset($return_data['success'])){
		$return_info['success'] = $return_data['success'];
	}
	if(isset($return_data['err_str'])){
		$return_info['error'] = get_error($return_data['err_str']);
	}	
	if(isset($return_data['data'])){
		$return_info['r_data'] = $return_data['data'];
	}
	if(isset($return_data['messege'])){
		$return_info['messege'] = $return_data['messege'];
	}
	if(isset($return_data['info'])){
		$return_info['info'] = $return_data['info'];
	}
}
else{
	$return_info['success'] = '0';
	$return_info['error'] = get_error('required_login');
}


if($return_info['login'] == '1'){
	$return_info['user'] = get_user_info(UNK);
}
elseif($main == 'user_login' && $return_info['success'] == '1' && isset($return_info['r_data']['unk'])){
	$return_info['user'] = get_user_info($return_info['r_data']['unk']);
}
if(isset($_REQUEST['content_type']) && $_REQUEST['content_type'] == 'iframe'){
	require_once('mobile/iframe_template.php');	
}
else{
	echo json_encode($return_info);
}