<?php

// the file is not work with cron job
// the file will repair all the categoires problam on clentis estimate forms

require('../../global_func/vars.php');
/*
$sql = "SELECT unk,estimateSiteCat FROM user_extra_settings WHERE estimateSiteCat != '0' ";
$res = mysql_db_query(DB,$sql);

while( $data = mysql_fetch_array($res) )
{
	$sql2 = "UPDATE estimate_miniSite_defualt_block SET primeryCat = '".$data['estimateSiteCat']."' WHERE unk = '".$data['unk']."' AND primeryCat != '".$data['estimateSiteCat']."'";
	$res2 = mysql_db_query(DB,$sql2);
	
	$sql3 = "SELECT id, subCat , primeryCat FROM estimate_miniSite_defualt_block WHERE unk = '".$data['unk']."' ";
	$res3 = mysql_db_query(DB,$sql3);
	
	while( $data3 = mysql_fetch_array($res3) )
	{
		$sql4 = "SELECT id, father FROM biz_categories WHERE id = '".$data3['subCat']."' ";
		$res4 = mysql_db_query(DB,$sql4);
		$data4 = mysql_fetch_array($res4);
		
		if( $data4['father'] != $data3['primeryCat'] )
		{
			echo $data4['father']." - ".$data3['primeryCat'] ."<br>";
		//	echo "*<br>";
			$sql5 = "UPDATE estimate_miniSite_defualt_block SET subCat = '0' WHERE unk = '".$data['unk']."' AND id != '".$data3['id']."'";
			//$res5 = mysql_db_query(DB,$sql5);
		}
	}
	
}
*/

$sql6 = "SELECT unk,estimateSiteCat,estimateSiteTatCat FROM user_extra_settings WHERE estimateSiteTatCat != '0' ";
$res6 = mysql_db_query(DB,$sql6);

while( $data6 = mysql_fetch_array($res6) )
{
	$sql7 = "UPDATE estimate_miniSite_defualt_block SET primeryCat = '".$data6['estimateSiteCat']."' , subCat = '".$data6['estimateSiteTatCat']."' WHERE unk = '".$data6['unk']."'";
	$res7 = mysql_db_query(DB,$sql7);
}
