<?

class UserStatView
{
	public function __construct($db)
	{
		$this->db = $db;
		
	}
	
	/*
		part_type DESC :
			0 - ברירת מחדל - יש תקלה בשליחת הרשומה 
			1 - צפייה בדף הנחיתה של הלקוח בדף כללי - לא נכנסו אליו 
			2 - צפייה בדף לקוח נכנסו לדף שלו 
			3 - צפייה בדף כללי של מוצרים 
			4 - נכנסו לאחד המוצרים של הלקוח 
			5 - צפייה באחד ההנחות חברתיות של הלקוח בדף כללי - רשימת מוצרים 
			6 - דיל קופון 
	*/
	public function newRow( $user_id , $part_type="0" , $x_id="0" )
	{
		$sql = "INSERT INTO 10service_user_stat_view ( user_id , ip , datetime , part_type , x_id ) 
		VALUES ( '".$user_id."' , '".$_SERVER['REMOTE_ADDR']."' , NOW() , '".$part_type."' , '".$x_id."' )";
		mysql_db_query($this->db, $sql);
	}
	
	public function countViewPage( $user_id , $part_type , $x_id="" )
	{
		$qry_x_id = ( $x_id != "" ) ? " AND x_id = '".$x_id."' " : "";
		$sql = "SELECT COUNT(id) AS nums FROM 10service_user_stat_view WHERE user_id = '".$user_id."' AND part_type = '".$part_type."' ".$qry_x_id." ";
		$res = mysql_db_query($this->db, $sql);
		$data = mysql_fetch_array($res);
		
		return $data['nums'];
	}
	
	public function x_id_list_with_count( $user_id , $part_type)
	{
		$sql = "SELECT x_id FROM 10service_user_stat_view WHERE user_id = '".$user_id."' AND part_type = '".$part_type."' GROUP BY x_id";
		$res = mysql_db_query($this->db, $sql);
		
		$arr = array();
		while( $data = mysql_fetch_array($res) )
		{
			$arr[] = array( "x_id" => $data['x_id'] , "count" => $this->countViewPage( $user_id , $part_type , $data['x_id'] ) );
		}
		
		return $arr;
	}
	
}