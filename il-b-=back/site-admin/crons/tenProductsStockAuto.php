<?php
/* 
**	the page will update the product stock
**	the cron will run every day and every hour
*
*/

require('../../global_func/vars.php');
require("/home/ilan123/domains/ilbiz.co.il/public_html/global_func/classes/class.ten_stock.php");

$ten_stock = new ten_stock;

// סריקה של המוצרים עם עדכון אוטומטי
$sql = "SELECT * FROM 10service_auto_products_stock WHERE stock > 0";
$res = mysql_db_query(DB,$sql);

while( $data = mysql_fetch_array($res) )
{
	// סריקה מתי עודכן לאחרונה המוצר הנמצא
	$sql = "SELECT insert_date,id FROM 10service_products_stock_log WHERE product_id = '".$data['product_id']."' and type=0 ORDER BY id DESC LIMIT 1";
	$res2 = mysql_db_query(DB,$sql);
	$data2 = mysql_fetch_array($res2);
	
	// סריקה מתי צריך לעדכן את המוצר
	if( $ten_stock->is_the_time_renewal_period_date($data['renewal_period'] , $data2['insert_date'] ) == "1" )
	{
		// בדיקה האם לעדכן את המוצר או לא - מבחינת המלאי
		$num_to_update = $ten_stock->num_of_stock_for_update($data['product_id']);
		
		$ten_stock->add_to_remain_stock( $data['product_id'] , $num_to_update );
		$ten_stock->remove_to_remain_stock( $data['product_id'] , $num_to_update );
		$ten_stock->insert_stock_log( $data['product_id'] , $num_to_update );
	}
}