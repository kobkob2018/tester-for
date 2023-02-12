<?php
error_reporting(E_ALL);
ini_set("display_errors", 1);

require('../global_func/vars.php');
require("../global_func/DB.php");


$unk = $_GET['unk'];
$product_id = (int)$_GET['pid'];

$sql = "SELECT price , monthly , need_to_check FROM ilbiz_products WHERE id = '".$product_id."' ";
$res = mysql_db_query(DB,$sql);
$data_default = mysql_fetch_array($res , MYSQL_ASSOC);

if( $unk != "" )	{
	$sql = "SELECT p.price , p.monthly , p.need_to_check FROM	users_ilbiz_products as p 
						INNER JOIN users as u ON u.id = p.user_id WHERE 
						product_id = '".$product_id."' and u.unk = '".mysql_real_escape_string($unk)."'";
	$res = mysql_db_query(DB,$sql);
	$data = mysql_fetch_array($res , MYSQL_ASSOC );
}

if( $data['price'] != '' )
	echo json_encode($data);
else
	echo json_encode($data_default);