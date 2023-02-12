<?

//header('content-type:TEXT/HTML; charset=UTF-8');
####################################
##
##
##	
##
####################################

require('/home/ilan123/domains/ilbiz.co.il/public_html/global_func/vars.php');
require('/home/ilan123/domains/ilbiz.co.il/public_html/global_func/classes/class.estimate.statisitc.php');
require('/home/ilan123/domains/ilbiz.co.il/public_html/global_func/classes/class.estimate_stats.php');


if(isset($_GET['copyfrom']) && isset($_GET['copyto'])){
	$sql = "SELECT * FROM user_lead_cities WHERE city_id = ".$_GET['copyfrom'];
	
	$resAll = mysql_db_query(DB,$sql);
	$i=0;
	$insertStr = "INSERT INTO user_lead_cities (user_id,city_id) values ";
	while($data = mysql_fetch_array($resAll)){
		if($i != 0)
			$insertStr.=",";
		$insertStr .= "(".$data['user_id'].",".$_GET['copyto'].")";
		$i++;
	}
	$insertStr .= ";";
	echo $insertStr;
}