<?php
/*

class of ILBIZ NET


*/


class lead
{
	
	function __construct(){}
	
	
	
	
	public function leadSent($params="")
	{
		$sendToUnk = ( $params['sendToUnk'] != "" ) ? " AND sendToUnk = '".$params['sendToUnk']."' " : "";
		$limit = ( $params['limit'] != "" ) ? " limit ".$params['limit']." " : "limit 50";
		$orderBy = ( $params['orderBy'] != "" ) ? " ORDER BY ".$params['orderBy']." " : "ORDER BY id DESC";

		$sql = "SELECT * FROM user_lead_sent WHERE 1 ".$sendToUnk.$orderBy.$limit."";
		return $sql;
	}
	
	
	
	
	public function tashlomim($params="")
	{
		$unk = ( $params['unk'] != "" ) ? " AND unk = '".$params['unk']."' " : "";
		$paid = ( $params['paid'] != "" ) ? " AND paid = '".$params['paid']."' " : "";
		$limit = ( $params['limit'] != "" ) ? " limit ".$params['limit']." " : "";
		$orderBy = ( $params['orderBy'] != "" ) ? " ORDER BY ".$params['orderBy']." " : "ORDER BY id DESC";
		
		$sql = "SELECT * FROM user_lead_tashlom WHERE 1 ".$unk.$paid.$orderBy.$limit."";
		return $sql;
	}
	
	
	
	
	
	public function getEstimateDetails( $params )
	{
		$cat_f = ( $params['cat_f'] != "" ) ? " ef.cat_f = '".$params['cat_f']."' " : "";
		$cat_s = ( $params['cat_s'] != "" ) ? " ef.cat_s = '".$params['cat_s']."' " : "";
		$name = ( $params['name'] != "" ) ? " ef.name = '".$params['name']."' " : "";
		$city = ( $params['city'] != "" ) ? " ef.city = '".$params['city']."' " : "";
		$referer = ( $params['referer'] != "" ) ? " ef.referer = '".$params['referer']."' " : "";
		$id = ( $params['id'] != "" ) ? " ef.id = '".$params['id']."' " : "";
		
		return "select ef.*, nc.name as NewCity from estimate_form as ef left join newCities as nc on ef.city=nc.id WHERE ".$cat_f.$cat_s.$name.$city.$referer.$id."";
	}
	
	
	
	
	
	public function viewedStatusArr($selected="")
	{
		$arr[0] = "אין מידע";
		$arr[1] = "כן";
		$arr[2] = "לא";
		$arr[3] = "לא - עקב תקלה בשליחת הודעה";
		
		if( $selected != "" )	return $arr[$selected];
		else	return $arr;
	}
	
	
	
	
	
	public function sendByArr($selected="")
	{
		$arr[0] = "הודעה בצור קשר";
		$arr[1] = "הודעת sms";
		$arr[2] = "חיוב על צפיה בפרטי צור קשר";
		
		if( $selected != "" )	return $arr[$selected];
		else	return $arr;
	}
	
	
	
	
	public function paidArr($selected="")
	{
		$arr[0] = "לא שולם";
		$arr[1] = "שולם";
		
		if( $selected != "" )	return $arr[$selected];
		else	return $arr;
	}
	
	
} 

?>