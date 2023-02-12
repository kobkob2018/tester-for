<?php
class contract_handler{
	
	public static function get_defult_fields_arr(){
		$form_fields_defult = array(
			"general"=>array(
				"title"=>"כללי",
				"fields"=>array(
					"1"=>array(
						"identifier"=>"1",
						"order"=>"10",
						"title"=>"הערות",
						"required"=>"1",
						"allowedit"=>"1",
						"type"=>"text",
						"def"=>"",
					),
				),
			),
			"users_fields"=>array(
				"title"=>"משתתפים",
				"users"=>array(
					"1"=>array(
						"identifier"=>"1",
						"order"=>"1",
						"role_name"=>"צד א",
						"fields"=>array(
							"1"=>array(
								"identifier"=>"firstname",
								"order"=>"0",
								"title"=>"שם פרטי",
								"required"=>"1",
								"allowedit"=>"1",
								"type"=>"text",
								"def"=>"",
							),
							"2"=>array(
								"identifier"=>"lastname",
								"order"=>"1",
								"title"=>"שם משפחה",
								"required"=>"1",
								"allowedit"=>"1",
								"type"=>"text",
								"def"=>"",
							),	
							"3"=>array(
								"identifier"=>"email",
								"order"=>"2",
								"title"=>"אימייל",
								"required"=>"1",
								"allowedit"=>"1",
								"type"=>"email",
								"def"=>"",
							),							
						),
					),
					"2"=>array(
						"identifier"=>"2",
						"order"=>"2",
						"role_name"=>"צד ב",
						"fields"=>array(
							"1"=>array(
								"identifier"=>"firstname",
								"order"=>"0",
								"title"=>"שם פרטי",
								"required"=>"1",
								"allowedit"=>"1",
								"type"=>"text",
								"def"=>"",
							),
							"2"=>array(
								"identifier"=>"lastname",
								"order"=>"1",
								"title"=>"שם משפחה",
								"required"=>"1",
								"allowedit"=>"1",
								"type"=>"text",
								"def"=>"",
							),	
							"3"=>array(
								"identifier"=>"email",
								"order"=>"2",
								"title"=>"אימייל",
								"required"=>"1",
								"allowedit"=>"1",
								"type"=>"email",
								"def"=>"",
							),							
						),
					),					
				),
			),
		);	
		return $form_fields_defult;
	}
	public static function create_fields_arr_from_settings($fields){
		foreach($fields as $field_setting_id=>$field_value){
			
			//$field_value = iconv("UTF-8","windows-1255",$field_value);	
			$field_type_arr = explode("_t_",$field_setting_id);
			$field_type = $field_type_arr[0];
			if($field_type == 'general'){
				$fields_arr['general'][$field_type_arr[1]] = $field_value;
			}
			if($field_type == 'general_field'){
				$field_id_arr = explode("_i_",$field_type_arr[1]);
				$field_id = $field_id_arr[0];
				$field_name = $field_id_arr[1];
				$fields_arr['general']['fields'][$field_id][$field_name] = $field_value;
			}
			if($field_type == 'users_fields'){
				$fields_arr['users_fields'][$field_type_arr[1]] = $field_value;
			}
			if($field_type == 'users'){
				$uid_arr = explode("_uid_",$field_type_arr[1]);
				$uid = $uid_arr[0];
				$fields_arr['users_fields']['users'][$uid][$uid_arr[1]] = $field_value;
			}
			if($field_type == 'user_field'){
				$uid_arr = explode("_uid_",$field_type_arr[1]);
				$uid = $uid_arr[0];
				$field_identifier_arr = explode("_i_",$uid_arr[1]);
				$field_identifier = $field_identifier_arr[0];
				$field_name = $field_identifier_arr[1];
				$fields_arr['users_fields']['users'][$uid]['fields'][$field_identifier][$field_name] = $field_value;
			}			
		}
		
		ksort($fields_arr['general']['fields']);
		usort($fields_arr['general']['fields'], create_function('$a,$b', 'return $a["order"] - $b["order"];'));
		ksort($fields_arr['users_fields']['users']);
		usort($fields_arr['users_fields']['users'], create_function('$a,$b', 'return $a["order"] - $b["order"];'));
		foreach($fields_arr['users_fields']['users'] as $key=>$user_arr){
			
			ksort($fields_arr['users_fields']['users'][$key]['fields']);
			usort($fields_arr['users_fields']['users'][$key]['fields'], create_function('$a,$b', 'return $a["order"] - $b["order"];'));
		}
		return $fields_arr;
	}
	public static function get_utf_8_ob_clean(){
		$page_content = ob_get_clean();
		echo iconv("UTF-8", "windows-1255",$page_content);
	}
	public static function get_contract_data($contract_id,$format=""){
		$sql = "SELECT * FROM contract_design WHERE id = $contract_id";
		$res = mysql_db_query(DB,$sql);
		$data = mysql_fetch_array($res);
		$format_fields = array('title','content');
		if($format!=""){
			foreach($format_fields as $key){
				$data[$key] = iconv( "windows-1255",$format,$data[$key]);
			}
		}
		return $data;		
	}
	public static function create_fields_arr_from_contract($contract_id){
		$sql = "SELECT * FROM contract_fields_settings WHERE contract_id = $contract_id";
		$res = mysql_db_query(DB,$sql);
		while($data = mysql_fetch_array($res)){
			$fields_settings_arr[$data['field_key']] = iconv( "windows-1255","UTF-8",$data['field_val']);
		}
		if(!empty($fields_settings_arr)){
			$form_fields = self::create_fields_arr_from_settings($fields_settings_arr);
		}
		else{
			$form_fields = self::get_defult_fields_arr();
		}
		return $form_fields;
	}
	public static function create_field_type_select($field_name,$field_val="text"){	
		$values = array(
			"text"=>"טקסט",
			"email"=>"אימייל",
			"textarea"=>"תיבת טקסט",
			"file"=>"תמונה",
		);
		$html = "<select name='".$field_name."'>";
		foreach($values as $key=>$name){
			$selected = ($key == $field_val)? "selected":"";
			$html .= "<option value='".$key."' ".$selected.">".$name."</option>";
		}		
		$html .= "</select>";
		return $html;
	}
	public static function create_field_yesno_select($field_name,$field_val="1"){	
		$values = array(
			"1"=>"כן",
			"0"=>"לא",
		);
		$html = "<select name='".$field_name."'>";
		foreach($values as $key=>$name){
			$selected = ($key == $field_val)? "selected":"";
			$html .= "<option value='".$key."' ".$selected.">".$name."</option>";
		}		
		$html .= "</select>";
		return $html;
	}	
}