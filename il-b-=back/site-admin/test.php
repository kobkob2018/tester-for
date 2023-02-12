<?php

$unk = "894455971451717470";
require_once('/home/ilan123/domains/ilbiz.co.il/public_html/global_func/vars.php');

	$sql ="SELECT * FROM net_clients_banners WHERE 1 limit 10";
	$res = mysql_db_query(DB,$sql);
		$banner_detail = mysql_fetch_array($res);
		var_dump($banner_detail);
		
		
		
	
	if( $banner_detail['file_name'] != "" )
	{
		$banner_path = "/home/ilan123/domains/ilbiz.co.il/public_html/ClientSite/site_banners/net_banners/".$banner_detail['file_name']."";
		
		if( file_exists($banner_path) )
		{
			$im_size = GetImageSize ($banner_path); 
			$imageWidth = $im_size[0]; 
			$imageHeight = $im_size[1];
			
			$new_he = $imageHeight+10;
			$height_kobia += $new_he;
			
			$b1 = $banner_detail['id'];
			$cnu = "";
		}
	}		
		
	exit("ttt");
print(phpversion());

	$day_names = array(
		1=>"ראשון",
		2=>"שני",
		3=>"שלישי",
		4=>"רביעי",
		5=>"חמישי",
		6=>"שישי",
		7=>"שבת"		
	);
	$wday = date('w');
	$now_day = $wday+1;
	$now_hour = date('H');
	$now_minute = date('i');	
	?>


	<h4>עכשיו יום <?php echo $day_names[$now_day]; ?> <?php echo $now_hour; ?>:<?php echo $now_minute; ?></h4>