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
require('mobile/administration.lang.'.$cookie_lang.'.php');
if(isset($_REQUEST['unk']) && isset($_REQUEST['sesid'])){
	$_SESSION['login'] = array('unk'=>$_REQUEST['unk'],'sesid'=>$_REQUEST['sesid']);
}

require("../../global_func/global_functions.php");
require("../../global_func/class.phpmailer.php");
require_once('mobile/global_func.php');
if(isset($_REQUEST['main'])){
	require_once('mobile/get_info.php');
}

else{
	require_once('mobile/main_template.php');	
}

exit();
