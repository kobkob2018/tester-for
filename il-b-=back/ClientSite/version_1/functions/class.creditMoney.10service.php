<?

class creditMoney
{
	public function __construct()	{}
	
	public function get_creditMoney( $user_type , $user_id , $getUnk="0" )
	{
		if( $getUnk == "1" )
		{
			$sql = "SELECT id FROM users WHERE unk = '".$user_id."' ";
			$res = mysql_db_query(DB,$sql);
			$data = mysql_fetch_array($res);
			$user_id = $data['id'];
		}
		
		$sql = "SELECT creditMoney FROM ".$user_type." WHERE id = '".$user_id."' LIMIT 1";
		$res = mysql_db_query(DB,$sql);
		$data = mysql_fetch_array($res);
		
		return $data['creditMoney'];
	}
	
	protected function credit_log( $user_type , $user_id , $credit, $content )
	{
		$sql = "INSERT INTO creditMoney_log ( user_type, user_id, credit, content, in_date ) VALUES (
			'".$user_type."' , '".$user_id."' , '".$credit."' , '".mysql_real_escape_string($content)."' , NOW()
		)";
		$res = mysql_db_query(DB,$sql);
	}
	
	public function change_credit( $user_type , $user_id , $credit, $content )
	{
		$this->credit_log( $user_type , $user_id , $credit, $content );
		
		$get_creditMoney = $this->get_creditMoney($user_type , $user_id);
		$new_credit = $get_creditMoney + $credit;
		
		$sql = "UPDATE ".$user_type." SET creditMoney = '".$new_credit."' WHERE id = '".$user_id."' LIMIT 1";
		$res = mysql_db_query(DB,$sql);
	}
	
	public function credit_log_list( $user_type , $user_id , $getUnk="0" )
	{
		if( $getUnk == "1" )
		{
			$sql = "SELECT id FROM users WHERE unk = '".$user_id."' ";
			$res = mysql_db_query(DB,$sql);
			$data = mysql_fetch_array($res);
			$user_id = $data['id'];
		}
		
		$sql = "SELECT credit, DATE_FORMAT(in_date , '%d-%m-%Y %T' ) AS insert_date , content FROM creditMoney_log WHERE user_type = '".$user_type."' AND user_id = '".$user_id."' ";
		return mysql_db_query(DB,$sql);
	}
	
	
	public function return_user_Unicode( $user_type , $user_id , $getUnk="0" )
	{
		if( $getUnk == "1" )
		{
			$sql = "SELECT id FROM users WHERE unk = '".$user_id."'";
			$res = mysql_db_query(DB,$sql);
			$data = mysql_fetch_array($res);
			$user_id = $data['id'];
		}
		
		$sql = "SELECT uniCode , id FROM 10service_stat_codes_for_user WHERE user_type = '".$user_type."' AND user_id = '".$user_id."' ";
		$res2 = mysql_db_query(DB,$sql);
		$data_uniCode = mysql_fetch_array($res2);
		
		if( $data_uniCode['id'] == "" )
		{
			$uc = $this->create_new_uniCode();
			$sql = "INSERT INTO 10service_stat_codes_for_user ( user_id , user_type , uniCode ) VALUES ( '".$user_id."' , '".$user_type."' , '".$uc."' )";
			$res3 = mysql_db_query(DB,$sql);
			
			return $uc;
		}
		elseif( $data_uniCode['uniCode'] == "" )
		{
			$uc = $this->create_new_uniCode();
			
			$sql = "UPDATE 10service_stat_codes_for_user SET uniCode = '".$uc."' WHERE id = '".$data_uniCode['id']."' ";
			$res3 = mysql_db_query(DB,$sql);
			
			return $uc;
		}
		else
			return $data_uniCode['uniCode'];
	}
	
	public function create_new_uniCode()
	{
		$r1 = rand(1,18);
		switch($r1)
		{
				case "1":$t="a";break;	case "2":$t="b";break;	case "3":$t="c";break;	case "4":$t="d";break;	case "5":$t="e";break;	case "6":$t="f";break;
				case "7":$t="g";break;	case "8":$t="l";break;	case "9":$t="q";break;	case "10":$t="w";break;	case "11":$t="r";break;	case "12":$t="t";break;
				case "13":$t="y";break;	case "14":$t="u";break;	case "15":$t="i";break;	case "16":$t="x";break;	case "17":$t="z";break;	case "18":$t="m";break;
		}
		$r2 = rand(100,999);
		$r3 = rand(1,18);
		switch($r3)
		{
				case "1":$t2="a";break;	case "2":$t2="b";break;	case "3":$t2="c";break;	case "4":$t2="d";break;	case "5":$t2="e";break;	case "6":$t2="f";break;
				case "7":$t2="g";break;	case "8":$t2="l";break;	case "9":$t2="q";break;	case "10":$t2="w";break;	case "11":$t2="r";break;	case "12":$t2="t";break;
				case "13":$t2="y";break;	case "14":$t2="u";break;	case "15":$t2="i";break;	case "16":$t2="x";break;	case "17":$t2="z";break;	case "18":$t2="m";break;
		}
		$r4 = rand(10,99);
		
		$un = $t.$r2.$t2.$r4;
		
		// Check uniqe code
		$sql = "SELECT uniCode FROM 10service_stat_codes_for_user WHERE uniCode = '".$un."' ";
		$check = mysql_db_query(DB,$sql);
		$checkD = mysql_fetch_array($check);
		
		if( $checkD['uniCode'] == $un )
			$this->create_new_uniCode();
		else
			return $un;
	}
	
	public function uniCode_user_data($uniCode)
	{
		$sql = "SELECT user_type, user_id FROM 10service_stat_codes_for_user WHERE uniCode = '".mysql_real_escape_string($uniCode)."' ";
		$res = mysql_db_query(DB,$sql);
		
		return mysql_fetch_array($res);
	}
	
	public function newEnterStat($uniCode)
	{
		if( $uniCode != "" )
		{
			$data = $this->uniCode_user_data( $uniCode );
			
			$sql = "INSERT INTO 10service_stat_for_credits ( user_id , user_type , ip , in_date ) VALUES ( '".$data['user_id']."' ,
			'".$data['user_type']."' , '".$_SERVER[REMOTE_ADDR]."' , NOW() )
			";
			$res2 = mysql_db_query(DB,$sql);
		}
	}
	
	public function viewEntersByUniCode($uniCode , $paid="")
	{
		if( $uniCode != "" )
		{
			$data = $this->uniCode_user_data( $uniCode );
			
			if( $paid != "" )
				$sql = "SELECT COUNT(id) AS nums FROM 10service_stat_for_credits WHERE paid = '".$paid."' AND user_id = '".$data['user_id']."' AND user_type = '".$data['user_type']."' GROUP BY ip, DATE_FORMAT(in_date, '%y-%m-%d')";
			else
				$sql = "SELECT COUNT(id) AS nums FROM 10service_stat_for_credits WHERE user_id = '".$data['user_id']."' AND user_type = '".$data['user_type']."' GROUP BY ip, DATE_FORMAT(in_date, '%y-%m-%d')";
			$res2 = mysql_db_query(DB,$sql);
			$numsr = mysql_num_rows($res2);
			
			return $numsr;
		}
	}
	
	public function updateAllPaidCreditRows( $uniCode )
	{
		if( $uniCode != "" )
		{
			$data = $this->uniCode_user_data( $uniCode );
			
			$sql = "UPDATE 10service_stat_for_credits SET paid = '1' WHERE user_id = '".$data['user_id']."' AND user_type = '".$data['user_type']."' ";
			$res = mysql_db_query(DB,$sql);
		}
	}
	
	public function setCreditBy1000Views()
	{
		$sql = "SELECT u.uniCode , c.user_id , c.user_type FROM 10service_stat_for_credits AS c , 10service_stat_codes_for_user AS u 
		WHERE c.paid = 0 AND u.user_id = c.user_id AND u.user_type = c.user_type GROUP BY u.uniCode";
		$res = mysql_db_query(DB,$sql);
		
		while( $data = mysql_fetch_array($res) )
		{
			$number = $this->viewEntersByUniCode($data['uniCode']);
			
			if( $number > '1000' )
			{
				$tempCredit = ( $number / 100 );
				$addCredit = round($tempCredit, 0 );
				
				$this->change_credit( $data['user_type'] , $data['user_id'] , $addCredit, "המרת ".$number." צפיות ל ".$addCredit." קרדיטים" );
				$this->updateAllPaidCreditRows( $data['uniCode'] );
			}
		}
	}
	
	public function check_last_credit_earned_in_days( $user_type , $user_id, $content )
	{
		$sql = "SELECT in_date FROM creditMoney_log WHERE user_type = '".$user_type."' AND user_id = '".$user_id."' AND content = '".$content."' order by id desc LIMIT 1";
		$res = mysql_db_query(DB,$sql);
		$data = mysql_fetch_array($res);
		
		if( $data['in_date'] != "" )
		{
			$date1 = $data['in_date']; 
			$date2 = date('Y-m-d H:i:s'); 
			
			$diff = abs(strtotime($date2) - strtotime($date1)); 
			
			$years   = floor($diff / (365*60*60*24)); 
			$months  = floor(($diff - $years * 365*60*60*24) / (30*60*60*24)); 
			$days    = floor(($diff - $years * 365*60*60*24 - $months*30*60*60*24)/ (60*60*24));
			
			return $days;
		}
		else
			return '9';
	}
	
	public function getUserIdForm_cookie()
	{
		$sqlUserId = "SELECT id FROM net_users WHERE unick_ses = '".$_COOKIE['net_user_s']."' AND unick_ses != ''";
		$resUserId = mysql_db_query(DB,$sqlUserId );
		$dataUserId = mysql_fetch_array($resUserId);
		
		return $dataUserId['id'];
	}
	
	public function getNewPriceWithMinusCredits( $price , $creditsType='0' , $user_id="" )
	{
		if( $user_id == "" )
			$credits = $this->get_creditMoney( 'net_users' , $this->getUserIdForm_cookie() );
		else
			$credits = $this->get_creditMoney( 'net_users' , $user_id );
		
		$new_priceT = ( $price * 90 ) / 100;
		$new_price = round( $new_priceT );
		
		$check_how_match_cost = $price - $new_price;
		
		if( $check_how_match_cost >= '5' )
		{	
			if( $credits >= $new_price )
			{
				$re_price = $price - $new_price;
				$re_credits = $new_price;
			}
			elseif( $credits > 0 )
			{
				$re_price = $price - $credits;
				$re_credits = $credits;
			}
			else
			{
				$re_price = $price;
				$re_credits = '0';
			}
		}
		elseif( $check_how_match_cost < '5' )
		{
			if( $credits >= $new_price )
			{
				$re_price__TEMP1 = $price - $new_price;
				$re_price__TEMP2 = 5 - $re_price__TEMP1;
				$re_price = $re_price__TEMP1 + $re_price__TEMP2;
				$re_credits = $price - $re_price;
			}
			elseif( $credits > 0 )
			{
				$re_price__TEMP1 = $price - $credits;
				if( $re_price__TEMP1 >= '5' )
				{
					$re_price = $re_price__TEMP1;
					$re_credits = $credits;
				}
				else
				{
					$re_price__TEMP2 = 5 - $re_price__TEMP1;
					$re_price = $re_price__TEMP1 + $re_price__TEMP2;
					$re_credits = $credits + $re_price__TEMP2;
				}
			}
			else
			{
				$re_price = $price;
				$re_credits = '0';
			}
		}
		
		if( $creditsType == '1' )
			return $re_credits;
		else
			return $re_price;
	}
	
	
	public function getUserFullName()
	{
		$user_id = $this->getUserIdForm_cookie();
		$sql = "SELECT fname , lname FROM net_users WHERE id = '".$user_id."' ";
		$res = mysql_db_query(DB,$sql);
		$data = mysql_fetch_array($res);
		
		return stripslashes($data['fname'])." ".stripslashes($data['lname']);
	}
	
	
	public function getUserImage($width="60")
	{
		$user_id = $this->getUserIdForm_cookie();
		$sql = "SELECT user_img FROM net_users WHERE id = '".$user_id."' ";
		$res = mysql_db_query(DB,$sql);
		$data = mysql_fetch_array($res);
		
		$path_user = "/home/ilan123/domains/10service.co.il/public_html/userImg/drgjn/";
		if( is_file( $path_user.$data['user_img'] ) && !(is_dir($path_user.$data['user_img']))  )
		{
			$img = "<img src='http://10service.co.il/image.php?width=".$width."&amp;quality=100&amp;height=".$width."&amp;image=/userImg/drgjn/".$data['user_img']."' alt='' border=''>";
		}
		else
		{
			$img = "<img src='http://10service.co.il/images/user_no_image.png' alt='' border=''>";
		}
		
		return $img;
	}

	
}
