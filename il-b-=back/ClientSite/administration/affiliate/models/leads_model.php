<?php
  class Leads{
    // we define 3 attributes
    // they are public so that we can access them using $post->author directly
    public $id;
    public $estimate_form_data;
	public $users_send_list;
	public $users_send_summary;
	
    public function __construct($lead) {
		$this->users_send_list = array();
		$this->users_send_summary = array(
			'total_send'=>0,
			'payByPassword_0'=>0,
			'payByPassword_1'=>0,
			'billed'=>0,
			'doubled'=>0,
			'refunded'=>0,
			'total_pay'=>0,
			'total_income'=>0,
		);
		$this->estimate_form_data = $lead;
		$this->id = $lead['id'];
		$db = Db::getInstance();
		$sql = "SELECT * FROM user_contact_forms WHERE estimateFormID = :lead_id";
		$req = $db->prepare($sql);
		$req->execute(array('lead_id'=>$this->id));
		$affiliate_data = User::getLogedInUser();
		foreach($req->fetchAll() as $user_send_lead) {
			$unk_data = $this->affiliate_get_unk_data($user_send_lead['unk']);
			$lead_bill_amount = $unk_data['leadPrice'];
			$pay_amount = 0;
			if(!isset($affiliate_data['lead_pay_type'])){
				$affiliate_data['lead_pay_type'] = "fixed";
			}
			if(!isset($affiliate_data['lead_pay'])){
				$affiliate_data['lead_pay'] = "0";
			}			
			if($affiliate_data['lead_pay_type'] == "fixed"){
				$pay_amount += $affiliate_data['lead_pay'];
			}
			elseif($affiliate_data['lead_pay_type'] == "precent"){
				$precent_pay = $affiliate_data['lead_pay'];
				$pay_amount = $lead_bill_amount*$precent_pay/100;			
			}			
			$this->users_send_summary['total_send']++;
			if($user_send_lead['payByPassword'] == '1'){
				$this->users_send_summary['payByPassword_1']++;
				if($user_send_lead['lead_billed'] == '1'){
					$this->users_send_summary['billed']++;
					$bill_amount = $unk_data['leadPrice'];
					if($user_send_lead['status'] == '6'){
						$this->users_send_summary['refunded']++;
					}
					else{
						$this->users_send_summary['total_pay'] += $pay_amount;
						$this->users_send_summary['total_income'] += $lead_bill_amount;
						
						$user_send_lead['billed_amount'] = $unk_data['leadPrice'];
						$user_send_lead['pay_amount'] = $pay_amount;
					}
				}
				else{
					$this->users_send_summary['doubled']++;
				}
			}
			else{
				$this->users_send_summary['payByPassword_0']++;
			}
			$this->users_send_list[] = $user_send_lead;
			$this->users_send_summary['total_send']++;			
		}
    }

    public static function all($filter){
		$user = User::getLogedInUser();
		$user_id = $user['id'];
		$aff_campaign_id = 1000+$user_id;
		$prepare_arr = array('aff_campaign_id'=>$aff_campaign_id);
		$filter_sql = "";
		if($filter['date_from'] != ""){
			$filter_date_from_obj =  new DateTime($filter['date_from']);
			$filter_date_from = $filter_date_from_obj->format('Y-m-d');
			$filter_sql .= " AND insert_date >= :date_from ";
			$prepare_arr['date_from'] = $filter_date_from;
		}
		if($filter['date_to'] != ""){
			$filter_date_to_obj =  new DateTime($filter['date_to']." +1 day");
			$filter_date_to = $filter_date_to_obj->format('Y-m-d');
			$filter_sql .= " AND insert_date <= :date_to ";
			$prepare_arr['date_to'] = $filter_date_to;
		}
		if($filter['phone'] != ""){
			$filter_sql .= " AND phone LIKE (:phone) ";
			$prepare_arr['phone'] = '%'.$filter['phone'].'%';
		}	
		if($filter['name'] != ""){
			$filter_sql .= " AND name LIKE (:name) ";
			$prepare_arr['name'] = '%'.$filter['name'].'%';
		}	
		if($filter['email'] != ""){
			$filter_sql .= " AND email LIKE (:email) ";
			$prepare_arr['email'] = '%'.$filter['email'].'%';
		}			
		$list = array();
		$db = Db::getInstance();
		$sql = "SELECT * FROM estimate_form WHERE campaign_type = :aff_campaign_id $filter_sql ORDER BY id DESC";
		try{
			$req = $db->prepare($sql);
			$req->execute($prepare_arr);
		}
		catch (Exception $e) {
			echo 'Caught exception: ',  $e->getMessage(), "\n";
		}
		$users_send_totals = array();
		$lead_count = 0;
		// we create a list of Post objects from the database results
		foreach($req->fetchAll() as $lead) {
			$lead_data =  new Leads($lead);
			$lead_count++;
			$users_send_summary = $lead_data->users_send_summary;
			foreach($users_send_summary as $key=>$val){
				if(!isset($users_send_totals[$key])){
					$users_send_totals[$key] = 0;
				}
				$users_send_totals[$key] += $val;
			}			
			$list[] = $lead_data;
			
		}
		return array("list"=>$list,"lead_count"=>$lead_count,"totals_list"=>$users_send_totals);
    }

    public static function find($id) {
      $db = Db::getInstance();
      // we make sure $id is an integer
      $id = intval($id);
      $req = $db->prepare('SELECT * FROM estimate_form WHERE id = :id');
      // the query was prepared, now we replace :id with our actual $id value
      $req->execute(array('id' => $id));
      $lead = $req->fetch();

      return new Leads($lead);
    }
	
	
	public static $affiliates_unk_arr = array();
	private function affiliate_get_unk_data($unk){
		
		if(isset(self::$affiliates_unk_arr[$unk])){
			return self::$affiliates_unk_arr[$unk];
		}
		$unk_data = array();
		$sql = "SELECT * FROM users WHERE unk = '$unk'";
		$res = mysql_db_query(DB,$sql);
		$unk_result = mysql_fetch_array($res);
		$unk_data['user'] = $unk_result;
		$sql = "SELECT leadPrice FROM user_bookkeeping WHERE unk = '$unk'";
		$res = mysql_db_query(DB,$sql);
		$unk_result = mysql_fetch_array($res);
		$unk_data['leadPrice'] = $unk_result['leadPrice'];
		self::$affiliates_unk_arr[$unk] = $unk_data;
		return self::$affiliates_unk_arr[$unk];
	}	
  }
?>