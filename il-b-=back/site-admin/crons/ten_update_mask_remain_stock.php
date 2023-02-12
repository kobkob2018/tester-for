<?php
/* 
**	the page will update the product stock
**	the cron will run every min
*
*/
require('../../global_func/vars.php');

// סריקה של שרצו לקנות
$sql = "SELECT * FROM 10service_mask_remain_products where changed = 0";
$res = mysql_db_query(DB,$sql);

while( $data = mysql_fetch_array($res) )
{
	$t1_indate = explode(" " , $data['buy_time'] );
	$t2_indate = explode("-" , $t1_indate[0] );
	$t3_indate = explode(":" , $t1_indate[1] );
	
	$nowTime = mktime(date("H"),date("i"),date("s"), date("m") , date("d") , date("Y") );
	$new_indate = mktime( $t3_indate[0],$t3_indate[1]+13,$t3_indate[2], $t2_indate[1] , $t2_indate[2] , $t2_indate[0] );
	
	if( $nowTime > $new_indate )
	{
		$sqlCheck = "SELECT remain_stock FROM user_products WHERE id = '".$data['product_id']."' ";
		$resCheck = mysql_db_query(DB,$sqlCheck);
		$dataCheck = mysql_fetch_array($resCheck);
		
		$sql2 = "UPDATE user_products SET mask_remain_stock = '".$dataCheck['remain_stock']."' WHERE id = '".$data['product_id']."' ";
		$res2 = mysql_db_query(DB,$sql2);
		
		$sql3 = "UPDATE 10service_mask_remain_products SET changed = '1' WHERE id = '".$data['id']."' ";
		$res3 = mysql_db_query(DB,$sql3);
	}
}