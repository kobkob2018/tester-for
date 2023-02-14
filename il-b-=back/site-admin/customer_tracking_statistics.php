<?
function customer_tracking_statistics(){
//error_reporting(E_ALL);
//ini_set('display_errors', 1);

	$date_from_str = date('d-m-Y');
	if(isset($_REQUEST['date_from'])){
		$date_from_str = $_REQUEST['date_from'];
	}
	$date_from_arr = explode("-",$date_from_str);
	$date_from = $date_from_arr[2]."-".$date_from_arr[1]."-".$date_from_arr[0];
	$date_to_str = date('d-m-Y');
	if(isset($_REQUEST['date_to'])){
		$date_to_str = $_REQUEST['date_to'];
	}
	$date_to_real =  date('d-m-Y',strtotime($date_to_str." +1 days"));
	$date_to_arr = explode("-",$date_to_real);
	$date_to = $date_to_arr[2]."-".$date_to_arr[1]."-".$date_to_arr[0];
	
	$dates_sql = " tracking_date >= '".$date_from."' AND tracking_date < '".$date_to."' ";
	$filter_campaign_1 = false;
	$filter_campaign_2 = false;

	$filter_campaign_1_checked = "";
	$filter_campaign_2_checked = "";

	if(isset($_REQUEST['campaign']['1'])){
		$filter_campaign_1 = true;
		$filter_campaign_1_checked = "checked";		
	}
	if(isset($_REQUEST['campaign']['2'])){
		$filter_campaign_2 = true;
		$filter_campaign_2_checked = "checked";		
	}
	$campaign_sql = "";
	if($filter_campaign_1 && $filter_campaign_2){
		$campaign_sql = " AND (has_gclid = '1' OR has_gclid = '2')";
	}
	else{
		if($filter_campaign_1){
			$campaign_sql = " AND has_gclid = '1' ";
		}
		if($filter_campaign_2){
			$campaign_sql = " AND has_gclid = '2' ";
		}
	}
	$browser_type = "all";
	$browser_types = array("all"=>array('str'=>'���','checked'=>''),"1"=>array('str'=>'������','checked'=>''),"0"=>array('str'=>'����','checked'=>''));
	if(isset($_REQUEST['browser_type'])){
		$browser_type = $_REQUEST['browser_type'];
		
	}
	$browser_types[$browser_type]['checked'] = "selected";
	$group_by = 'cat_f';
	if(isset($_REQUEST['group_by'])){
		$group_by = $_REQUEST['group_by'];
	}
	$group_by_str = $group_by."_str";
	$sql_group_by = $group_by;
	if($group_by == 'page_data'){
		$group_by_str = "page_str";
		$sql_group_by = " page_id,page_m,page_type,site_id ";
	}
	if($group_by == 'site_id'){
		$group_by_str = "site_str";
	}	
	$group_by_options = array(
		'cat_f'=>array("str"=>'������� �����','parent'=>'0'),
		'cat_s'=>array("str"=>'������� �����','parent'=>'cat_f'),
		'cat_spec'=>array("str"=>'����','parent'=>'cat_s'),
		'tracking_date'=>array("str"=>'���','parent'=>'0'),
		'tracking_hour'=>array("str"=>'���','parent'=>'tracking_date'),
		'site_id'=>array("str"=>'������','parent'=>'0'),
		'page_data'=>array("str"=>'��','parent'=>'0'),
	); 
	foreach($group_by_options as $key=>$option){
		if($group_by == $key){
			$group_by_options[$key]['selected'] = 'selected';
		}
		else{
			$group_by_options[$key]['selected'] = ''; 
		}
	} 
	$group_by_col_name = $group_by_options[$group_by]['str'];
	if($group_by == "page_data"){
		$group_by_col_name = "����";
	}
	if($group_by == "site_id"){
		$group_by_col_name = "���";
	}	
	$add_form_counts = false;
	if($group_by == 'cat_f' || $group_by == 'cat_s' || $group_by == 'cat_spec'){
		$add_form_counts = true;
	}
	$select_sql = "";
	$table_fields = array();
	if(!isset($_REQUEST['cat_f'])){
		$select_sql .= " ,SUM(f_uniq) as sum_f_uniq ";
		$table_fields[] = array("select_as"=>"sum_f_uniq","str"=>"����� �������� ��������","sum"=>'1');
		$table_fields[] = array("select_as"=>"presentage_f_uniq","str"=>"%","sum"=>'0','color'=>'#ece6e6');
		if($add_form_counts){
			$table_fields[] = array("select_as"=>"presentage_f_form_counts","str"=>"%","sum"=>'0','color'=>'#beffbe');
		}
		
	}
	if(!isset($_REQUEST['cat_s'])){
		$select_sql .= " ,SUM(s_uniq) as sum_s_uniq ";
		$table_fields[] = array("select_as"=>"sum_s_uniq","str"=>"����� �������� ��� �������","sum"=>'1');
		$table_fields[] = array("select_as"=>"presentage_s_uniq","str"=>"%","sum"=>'0','color'=>'#ece6e6');
		if($add_form_counts){
			$table_fields[] = array("select_as"=>"presentage_s_form_counts","str"=>"%","sum"=>'0','color'=>'#beffbe');
		}
	}
	if(!isset($_REQUEST['cat_spec'])){
		$select_sql .= " ,SUM(spec_uniq) as sum_spec_uniq ";
		$table_fields[] = array("select_as"=>"sum_spec_uniq","str"=>"����� �������� �����","sum"=>'1');
		$table_fields[] = array("select_as"=>"presentage_spec_uniq","str"=>"%","sum"=>'0','color'=>'#ece6e6');
	}
	if(!isset($_REQUEST['page_data'])){
		$select_sql .= " ,SUM(page_uniq) as sum_page_uniq ";
		$table_fields[] = array("select_as"=>"sum_page_uniq","str"=>"����� �������� �����","sum"=>'1');
		$table_fields[] = array("select_as"=>"presentage_page_uniq","str"=>"%","sum"=>'0','color'=>'#ece6e6');
	}
	$select_sql .= " ,SUM(form_submited) as sum_form_submited ";
	$table_fields[] = array("select_as"=>"sum_form_submited","str"=>"����� ���� ������","sum"=>'1');
	$table_fields[] = array("select_as"=>"presentage_lead_sent","str"=>"%","sum"=>'0','color'=>'#ece6e6');
	
	//$table_fields[] = array("select_as"=>"sum_form_submited_by_forms","str"=>"����� �� �� �����");
	$select_sql .= " ,SUM(customer_send) as sum_customer_send ";
	$table_fields[] = array("select_as"=>"sum_customer_send","str"=>"����� �������","sum"=>'1');
	if($add_form_counts){
	$table_fields[] = array("select_as"=>"form_counts","str"=>"����� ���� ������","sum"=>'1','color'=>'#beffbe');
	$table_fields[] = array("select_as"=>"presentage_forms_sent","str"=>"%","sum"=>'0','color'=>'#ece6e6');
	$table_fields[] = array("select_as"=>"send_counts","str"=>"����� ������","sum"=>'1','color'=>'#beffbe');
	}
	$where_sql = $dates_sql.$campaign_sql;
	$cat_names = array();
	if(isset($_REQUEST['cat_f'])){
		$where_sql .= " AND cat_f = '".$_REQUEST['cat_f']."' ";
		$cat_names[$_REQUEST['cat_f']] = get_cat_name_from_db($_REQUEST['cat_f']);
	}
	if(isset($_REQUEST['cat_s'])){
		$where_sql .= " AND cat_s = '".$_REQUEST['cat_s']."' ";
		$cat_names[$_REQUEST['cat_s']] = get_cat_name_from_db($_REQUEST['cat_s']);		
	}
	if(isset($_REQUEST['cat_spec'])){
		$where_sql .= " AND cat_spec = '".$_REQUEST['cat_spec']."' ";
		$cat_names[$_REQUEST['cat_spec']] = get_cat_name_from_db($_REQUEST['cat_spec']);		
	}
	$page_data = array();
	if(isset($_REQUEST['page_data'])){
		$page_data_arr = explode("_",$_REQUEST['page_data']);
		$page_id = $page_data_arr[0];
		$page_m = $page_data_arr[1];
		$page_type = $page_data_arr[2];
		$site_id = $page_data_arr[3];
		$where_sql .= " AND page_id = '".$page_id."'  AND page_m = '".$page_m."'  AND page_type = '".$page_type."' AND site_id = '".$site_id."' ";
		$page_data = get_page_data_from_db($page_id,$page_m,$page_type,$site_id);
	}
	$site_data = array();
	if(isset($_REQUEST['site_id'])){
		$where_sql .= " AND site_id = '".$_REQUEST['site_id']."' ";
		$site_data = get_site_data_from_db($_REQUEST['site_id']);
	}
	if(isset($_REQUEST['tracking_date'])){
		$where_sql .= " AND tracking_date = '".$_REQUEST['tracking_date']."' ";
	}
	if(isset($_REQUEST['tracking_hour'])){
		$where_sql .= " AND tracking_hour = '".$_REQUEST['tracking_hour']."' ";
	}
	if(isset($_REQUEST['browser_type'])){
		if($_REQUEST['browser_type'] != "all"){
			$where_sql .= " AND is_mobile = '".$_REQUEST['browser_type']."' ";
		}  
	}	

	
	$main_sql = "SELECT ".$sql_group_by." ".$select_sql." FROM customer_tracking WHERE ".$where_sql." GROUP BY ".$sql_group_by." ";
	$main_res = mysql_db_query(DB,$main_sql);
	$statistics_result = array();
	$sum_row = array();
	$result_arr = array();
	while($data_row = mysql_fetch_array($main_res)){
		$result_arr[$data_row[$group_by]] = $data_row;
	}
	if($group_by == 'cat_f' || $group_by == 'cat_s' || $group_by == 'cat_spec'){
		$form_counts = get_form_counts($group_by,$date_from,$date_to,$filter_campaign_1,$filter_campaign_2);
		$send_counts = get_send_counts($group_by,$date_from,$date_to,$filter_campaign_1,$filter_campaign_2);	
		foreach($form_counts as $key=>$counts){
			if(!isset($result_arr[$key])){
				$result_arr[$key] = array($group_by=>$key,'form_counts'=>$counts); 
			}
		}
		foreach($send_counts as $key=>$counts){
			if(!isset($result_arr[$key])){
				$result_arr[$key] = array($group_by=>$key,'send_counts'=>$counts); 
			}
		}		
	}	
	
	foreach($result_arr as $data_row){
		if($group_by == 'cat_f' || $group_by == 'cat_s' || $group_by == 'cat_spec'){
			$data_row[$group_by_str] = get_cat_name_from_db($data_row[$group_by])." [".$data_row[$group_by]."]"; 
			if(isset($form_counts[$data_row[$group_by]])){
				$data_row['form_counts'] = $form_counts[$data_row[$group_by]];
			}
			else{
				$data_row['form_counts'] = 0;
			}
			if(isset($send_counts[$data_row[$group_by]])){
				$data_row['send_counts'] = $send_counts[$data_row[$group_by]];
			}
			else{
				$data_row['send_counts'] = 0;
			}
			if($data_row['form_counts'] == 0){
				$data_row['presentage_forms_sent'] = '0';
			}
			else{
				$data_row['presentage_forms_sent'] = round((int)$data_row["send_counts"]*100/(int)$data_row["form_counts"],2)."%";
			}
		}

		elseif($group_by == 'page_data'){
			$row_page_data = get_page_data_from_db($data_row['page_id'],$data_row['page_m'],$data_row['page_type'],$data_row['site_id']);
			$data_row[$group_by_str] = $row_page_data['site_name']." - ".$row_page_data['type_txt']."<br/>".$row_page_data['page_name']."[".$data_row['page_id']."]";
			$data_row[$group_by] = $data_row['page_id']."_".$data_row['page_m']."_".$data_row['page_type']."_".$data_row['site_id'];
		}
		
		elseif($group_by == 'site_id'){
			$row_site_data = get_site_data_from_db($data_row[$group_by]);
			$data_row[$group_by_str] = $row_site_data['name']."<br/>".$row_site_data['domain'];
		}
		else{
			$data_row[$group_by_str] = $data_row[$group_by];
		}
		if(!isset($data_row['sum_form_submited']) || $data_row['sum_form_submited'] == 0){
			$data_row['presentage_lead_sent'] = '0';
		}
		else{
			$data_row['presentage_lead_sent'] = round((int)$data_row["sum_customer_send"]*100/(int)$data_row["sum_form_submited"],2)."%";
		}
		if(!$add_form_counts){
			$data_row['form_counts'] = $data_row["sum_form_submited"];
			$data_row['send_counts'] = $data_row["sum_customer_send"];
		}
		if(isset($data_row["sum_f_uniq"])){
			if($data_row["sum_form_submited"] == '0'){
				$data_row["presentage_f_uniq"] = '0';
			}
			else{
				$data_row["presentage_f_uniq"] = round((int)$data_row["sum_form_submited"]*100/(int)$data_row["sum_f_uniq"],2)."%";
			}
			if($add_form_counts){
				$presentage_f_form_counts = '0';
				if($data_row["form_counts"] != '0'){
					$presentage_f_form_counts = round((int)$data_row["form_counts"]*100/(int)$data_row["sum_f_uniq"],2)."%";
				}
				$data_row["presentage_f_form_counts"] = $presentage_f_form_counts;			
			}
			
		}
		if(isset($data_row["sum_s_uniq"])){
			if($data_row["sum_form_submited"] == '0'){
				$data_row["presentage_s_uniq"] = '0';
			}
			else{
				$data_row["presentage_s_uniq"] = round((int)$data_row["sum_form_submited"]*100/(int)$data_row["sum_s_uniq"],2)."%";
			}
			if($add_form_counts){
				$presentage_s_form_counts = '0';
				if($data_row["form_counts"] != '0'){
					$presentage_s_form_counts = round((int)$data_row["form_counts"]*100/(int)$data_row["sum_s_uniq"],2)."%";
				}
				$data_row["presentage_s_form_counts"] = $presentage_s_form_counts;			
			}			
		}
		if(isset($data_row["sum_spec_uniq"])){
			if($data_row["sum_form_submited"] == '0'){
				$data_row["presentage_spec_uniq"] = '0';
			}
			else{
				$data_row["presentage_spec_uniq"] = round((int)$data_row["sum_form_submited"]*100/(int)$data_row["sum_spec_uniq"],2)."%";
			}
		}	
		if(isset($data_row["sum_page_uniq"])){
			if($data_row["sum_form_submited"] == '0'){
				$data_row["presentage_page_uniq"] = '0';
			}
			else{
				$data_row["presentage_page_uniq"] = round((int)$data_row["sum_form_submited"]*100/(int)$data_row["sum_page_uniq"],2)."%";
			}
		}
		
		foreach($table_fields as $table_field){
			if(isset($data_row[$table_field['select_as']])){
				if($table_field['sum'] == '1'){
					if(!isset($sum_row[$table_field['select_as']])){
						$sum_row[$table_field['select_as']] = 0;
					}
				
					$sum_row[$table_field['select_as']] += $data_row[$table_field['select_as']]; 
				}
			}
		}
		$statistics_result[$data_row[$group_by]] = $data_row;
	}
	if(isset($sum_row["sum_f_uniq"])){
		if($sum_row["sum_form_submited"] == '0'){
			$sum_row["presentage_f_uniq"] = '0';
		}
		else{
			$sum_row["presentage_f_uniq"] = round((int)$sum_row["sum_form_submited"]*100/(int)$sum_row["sum_f_uniq"],2)."%";
		}
		if($add_form_counts){
			$presentage_f_form_counts = '0';
			if($sum_row["form_counts"] != '0'){
				$sum_presentage_f_form_counts = round((int)$sum_row["form_counts"]*100/(int)$sum_row["sum_f_uniq"],2)."%";
			}
			$sum_row["presentage_f_form_counts"] = $sum_presentage_f_form_counts;			
		}
	}
	if(isset($sum_row["sum_s_uniq"])){
		if($sum_row["sum_form_submited"] == '0'){
			$sum_row["presentage_s_uniq"] = '0';
		}
		else{
			$sum_row["presentage_s_uniq"] = round((int)$sum_row["sum_form_submited"]*100/(int)$sum_row["sum_s_uniq"],2)."%";
		}
		if($add_form_counts){
			$presentage_s_form_counts = '0';
			if($sum_row["form_counts"] != '0'){
				$sum_presentage_s_form_counts = round((int)$sum_row["form_counts"]*100/(int)$sum_row["sum_s_uniq"],2)."%";
			}
			else{
				$sum_presentage_s_form_counts = '0';
			}
			$sum_row["presentage_s_form_counts"] = $sum_presentage_s_form_counts;			
		}		
	}
	if(isset($sum_row["sum_spec_uniq"])){
		if($sum_row["sum_form_submited"] == '0'){
			$sum_row["presentage_spec_uniq"] = '0';
		}
		else{
			$sum_row["presentage_spec_uniq"] = round((int)$sum_row["sum_form_submited"]*100/(int)$sum_row["sum_spec_uniq"],2)."%";
		}
	}	
	if(isset($sum_row["sum_page_uniq"])){
		if($sum_row["sum_form_submited"] == '0'){
			$sum_row["presentage_page_uniq"] = '0';
		}
		else{
			$sum_row["presentage_page_uniq"] = round((int)$sum_row["sum_form_submited"]*100/(int)$sum_row["sum_page_uniq"],2)."%";
		}
	}	
	if($sum_row['sum_form_submited'] == 0){
		$sum_row['presentage_lead_sent'] = '0';
	}
	else{
		$sum_row['presentage_lead_sent'] = round((int)$sum_row["sum_customer_send"]*100/(int)$sum_row["sum_form_submited"],2)."%";
	}
	if($add_form_counts){
		if($sum_row['form_counts'] == 0){
			$sum_row['presentage_forms_sent'] = '0';
		}
		else{
			$sum_row['presentage_forms_sent'] = round((int)$sum_row["send_counts"]*100/(int)$sum_row["form_counts"],2)."%";
		}
	}
	/* 
	echo "<hr/><pre style='text-align:left; direction:ltr;white-space: normal; padding:20px;background:yellow;' >";
	
	//print_r($_POST);  
	echo "<hr/>";
	echo $main_sql; 
	echo "</pre>";
	echo "<hr/>";
	*/
	?>
	<h2>��������� �� ���� ������� ����</h2>
	<div><a href="index.php?sesid=<?php echo SESID; ?>">���� ������ �����</a></div>
	
	<div id="filter_wrap" style="padding: 15px;border: 1px solid black;background: #e6d7d7;margin: 15px 0px;">
		<h3>����� ������</h3>
		<div><a href="http://ilbiz.co.il/site-admin/index.php?main=anf&gf=customer_tracking_statistics&sesid=<?php echo SESID; ?>">����� �����</a></div>
		<form method="POST" action="" id="statistics_filter_form">
			<input type="hidden" name="filter_statistics" value="1" />
			<div id="campaign_filter" style="margin-left: 20px;float:right;background: #e5e5fb;padding: 10px;border: 1px solid blue;"> 
				<b>��� �� ������ ���� �������:</b>
				<input type="hidden" name="campaign[helper]" value="1" />
				<div class="campaign-filter-check">
					<input type="checkbox" name="campaign[1]" value="1" <?php echo $filter_campaign_1_checked; ?> />
					����
					&nbsp;&nbsp;
					<input type="checkbox" name="campaign[2]" value="1" <?php echo $filter_campaign_2_checked; ?> />
					�������
				</div>				
			</div>
			<div id="mobile_filter" style="margin-left: 20px;float:right;background: #e5e5fb;padding: 10px;border: 1px solid blue;"> 
				<b>��� �����:</b>
				
				<div class="mobile-filter-select">
					<select name='browser_type' class='input_style' style='width: 120px;'>
						<?php foreach($browser_types as $key=>$type): ?>
							<option value='<?php echo $key; ?>' <?php echo $type['checked']; ?>><?php echo $type['str']; ?></option>
						<?php endforeach; ?>
					</select>	
				</div>				
			</div>			
			<div id="dates_filter" style="margin-left: 20px;float:right;background: #e5e5fb;padding: 10px;border: 1px solid blue;">
				<b>������</b>
				<br/>
				<input type="text" name="date_from" value="<?php echo $date_from_str; ?>" />				
			</div>
			<div id="dates_filter" style="margin-left: 20px;float:right;background: #e5e5fb;padding: 10px;border: 1px solid blue;">
				<b>�� �����</b>
				<br/>
				<input type="text" name="date_to" value="<?php echo $date_to_str; ?>" />				
			</div>			
			<?php if(isset($_REQUEST['cat_f'])): ?>
				<input type="hidden" id="cat_f_input" name="cat_f" value="<?php echo $_REQUEST['cat_f']; ?>" />
			<?php endif; ?>
			<?php if(isset($_REQUEST['cat_s'])): ?>
				<input type="hidden" id="cat_s_input" name="cat_s" value="<?php echo $_REQUEST['cat_s']; ?>" />
			<?php endif; ?>
			<?php if(isset($_REQUEST['cat_spec'])): ?>
				<input type="hidden" id="cat_spec_input" name="cat_spec" value="<?php echo $_REQUEST['cat_spec']; ?>" />
			<?php endif; ?>
			<?php if(isset($_REQUEST['page_data'])): ?>
				<input type="hidden" id="page_data_input" name="page_data" value="<?php echo $_REQUEST['page_data']; ?>" />
			<?php endif; ?>
			<?php if(isset($_REQUEST['site_id'])): ?>
				<input type="hidden" id="site_id_input" name="site_id" value="<?php echo $_REQUEST['site_id']; ?>" />
			<?php endif; ?>
			<?php if(isset($_REQUEST['tracking_date'])): ?>
				<input type="hidden" id="tracking_date_input" name="tracking_date" value="<?php echo $_REQUEST['tracking_date']; ?>" />
			<?php endif; ?>
			<?php if(isset($_REQUEST['tracking_hour'])): ?>
				<input type="hidden" id="tracking_hour_input" name="tracking_hour" value="<?php echo $_REQUEST['tracking_hour']; ?>" />
			<?php endif; ?>
			<?php if(isset($_REQUEST['is_mobile'])): ?>
				<input type="hidden" id="is_mobile_input" name="is_mobile" value="<?php echo $_REQUEST['is_mobile']; ?>" />
			<?php endif; ?>
			<input type="submit" value="��� ���������" />
			<div style="clear:both;"></div>
			<hr/>
			<div>
				<?php if(isset($_REQUEST['cat_f'])): ?>
					<div class="request_filter" style="margin-left: 20px;float:right;background: #e5e5fb;padding: 10px;border: 1px solid blue;"> 
						<a style="display:block;float:left;color:red;border: 1px solid red;font-family: sans-serif;cursor: pointer;font-size: 11px;margin-right: 15px;font-weight: bold;" onclick="remove_param_from_stats_and_go('cat_f');">��� �����</a>
						<b>�������:</b><br/>
						<?php echo $cat_names[$_REQUEST['cat_f']]; ?>
					</div>
				<?php endif; ?>
				<?php if(isset($_REQUEST['cat_s'])): ?>
					<div class="request_filter" style="margin-left: 20px;float:right;background: #e5e5fb;padding: 10px;border: 1px solid blue;"> 
						<a style="display:block;float:left;color:red;border: 1px solid red;font-family: sans-serif;cursor: pointer;font-size: 11px;margin-right: 15px;font-weight: bold;" onclick="remove_param_from_stats_and_go('cat_s');">��� �����</a>
						<b>�� �������:</b><br/>
						<?php echo $cat_names[$_REQUEST['cat_s']]; ?>
					</div>
				<?php endif; ?>
				<?php if(isset($_REQUEST['cat_spec'])): ?>
					<div class="request_filter" style="margin-left: 20px;float:right;background: #e5e5fb;padding: 10px;border: 1px solid blue;"> 
						<a style="display:block;float:left;color:red;border: 1px solid red;font-family: sans-serif;cursor: pointer;font-size: 11px;margin-right: 15px;font-weight: bold;" onclick="remove_param_from_stats_and_go('cat_spec');">��� �����</a>
						<b>����:</b><br/>
						<?php echo $cat_names[$_REQUEST['cat_spec']]; ?>
					</div>
				<?php endif; ?>
				<?php if(isset($_REQUEST['page_data'])): ?>
					<div class="request_filter" style="margin-left: 20px;float:right;background: #e5e5fb;padding: 10px;border: 1px solid blue;"> 
						<a style="display:block;float:left;color:red;border: 1px solid red;font-family: sans-serif;cursor: pointer;font-size: 11px;margin-right: 15px;font-weight: bold;" onclick="remove_param_from_stats_and_go('page_data');">��� �����</a>
						<b>����:</b><br/>
						<?php echo $page_data['type_txt']."<br/>".$page_data['page_name']; ?>
					</div>
				<?php endif; ?>
				<?php if(isset($_REQUEST['site_id'])): ?>
					<div class="request_filter" style="margin-left: 20px;float:right;background: #e5e5fb;padding: 10px;border: 1px solid blue;"> 
						<a style="display:block;float:left;color:red;border: 1px solid red;font-family: sans-serif;cursor: pointer;font-size: 11px;margin-right: 15px;font-weight: bold;" onclick="remove_param_from_stats_and_go('site_id');">��� �����</a>
						<b>���:</b><br/>
						<?php echo $site_data['name']."<br/>".$site_data['domain']; ?>
					</div>
				<?php endif; ?>
				<?php if(isset($_REQUEST['tracking_date'])): ?>
					<div class="request_filter" style="margin-left: 20px;float:right;background: #e5e5fb;padding: 10px;border: 1px solid blue;"> 
						<a style="display:block;float:left;color:red;border: 1px solid red;font-family: sans-serif;cursor: pointer;font-size: 11px;margin-right: 15px;font-weight: bold;" onclick="remove_param_from_stats_and_go('tracking_date');">��� �����</a>
						<b>�����:</b><br/>
						<?php echo $_REQUEST['tracking_date']; ?>
					</div>
				<?php endif; ?>
				<?php if(isset($_REQUEST['tracking_hour'])): ?>
					<div class="request_filter" style="margin-left: 20px;float:right;background: #e5e5fb;padding: 10px;border: 1px solid blue;"> 
						<a style="display:block;float:left;color:red;border: 1px solid red;font-family: sans-serif;cursor: pointer;font-size: 11px;margin-right: 15px;font-weight: bold;" onclick="remove_param_from_stats_and_go('tracking_hour');">��� �����</a>
						<b>���:</b><br/>
						<?php echo $_REQUEST['tracking_hour'].":XX"; ?>
					</div>
				<?php endif; ?>	
 				
				<div class="request_filter" style="margin-left: 20px;float:right;background: #e5e5fb;padding: 10px;border: 1px solid blue;"> 
					<b>����� ���:</b><br/>
					<?php echo $group_by_options[$group_by]['str']; ?>
					<select name="group_by_helper" id="group_by_helper" onchange="change_group_by(this);">
					<?php foreach ($group_by_options as $op_key=>$option): ?>
						<?php if(!isset($_REQUEST[$op_key])): ?>
							<?php if($option['parent'] == '0' || isset($_REQUEST[$option['parent']])): ?>
								<option value="<?php echo $op_key; ?>" <?php echo $option['selected']; ?>><?php echo $option['str']; ?></option>
							<?php endif; ?>
						<?php endif; ?>
					<?php endforeach; ?>
					</select>
				</div>
				<input type="hidden" name="group_by" id="group_by_input" value="<?php echo $group_by; ?>" />


			</div>
		</form>
		<div style='clear:both;'></div>
	</div>
	<div style="clear:both;"></div>	
	<script type="text/javascript">
		function add_param_to_stats(param_name,param_val){
			jQuery(function($){
				$("#"+param_name+"_input").remove();
				$("#statistics_filter_form").append("<input type='hidden'  id='"+param_name+"_input' name='"+param_name+"' value='"+param_val+"' />");
			});
		}
		function remove_param_from_stats(param_name){
			jQuery(function($){
				$("#"+param_name+"_input").remove();
			});
		}
		function remove_param_from_stats_and_go(param_name){
			jQuery(function($){
				remove_param_from_stats(param_name);
				setTimeout(function(){
					$("#statistics_filter_form").submit();
				},1000);
			});
		}
		function change_stats_param_value(param_name,param_val){
			jQuery(function($){
				$("#"+param_name+"_input").val(param_val);
			});
		}
		function select_new_group_by(row_id,group_by,el_id){
			jQuery(function($){
				change_stats_param_value("group_by",$(el_id).val());
				add_param_to_stats(group_by,row_id);
				setTimeout(function(){
					$("#statistics_filter_form").submit();
				},1000);
			});			
		}
		function change_group_by(el_id){
			jQuery(function($){
				change_stats_param_value("group_by",$(el_id).val());
				setTimeout(function(){
					$("#statistics_filter_form").submit();
				},1000);
			});			
		}
	</script>
	
	<h3>������ ������</h3>
	<table border='1' cellpadding='5'>
		<tr>
			<th style='background:#ece6e6'><?php echo $group_by_col_name; ?></th>
			<?php foreach($table_fields as $table_field): ?> 
				<?php 
					$style="";
					if(isset($table_field['color'])){
						$style = " style='background:".$table_field['color']."' ";
					}
				?>
				<th <?php echo $style; ?>><?php echo $table_field['str']; ?></th>
			<?php endforeach; ?>
			<th>�����</th>
		</tr>
		<tr>
			<td>�� ���</td>
			<?php foreach($table_fields as $table_field): ?>
				<?php 
					$style="";
					if(isset($table_field['color'])){
						$style = " style='background:".$table_field['color']."' ";
					}
				?>
				<td <?php echo $style; ?>><?php echo $sum_row[$table_field['select_as']]; ?></td>
			<?php endforeach; ?>
			<td>
			</td> 
		</tr>		
		<?php foreach($statistics_result as $result_row): ?>
			<tr>
				<td style='background:#ece6e6'><?php echo $result_row[$group_by_str]; ?></td>
				<?php foreach($table_fields as $table_field): ?>
					<?php 
						$style="";
						if(isset($table_field['color'])){
							$style = " style='background:".$table_field['color']."' ";
						}
					?>
					<td <?php echo $style; ?>>
						<?php if(!isset($result_row[$table_field['select_as']])): ?>
							- 
						<?php else: ?>
							<?php echo $result_row[$table_field['select_as']]; ?>
						<?php endif; ?>
					</td>
				<?php endforeach; ?>
				<td>
					<select name="group_by_helper" id="group_by_helper_<?php echo $result_row[$group_by]; ?>" onchange="select_new_group_by('<?php echo $result_row[$group_by]; ?>','<?php echo $group_by; ?>',this);">
						<?php foreach ($group_by_options as $op_key=>$option): ?>
							<?php if(!isset($_REQUEST[$op_key])): ?>
								<?php if($option['parent'] == '0' || isset($_REQUEST[$option['parent']]) || $group_by == $option['parent']): ?>
									<option value="<?php echo $op_key; ?>" <?php echo $option['selected']; ?>><?php echo $option['str']; ?></option>
								<?php endif; ?>
							<?php endif; ?>
						<?php endforeach; ?>
					</select>
				</td>
			</tr>
		<?php endforeach; ?>
	</table>
	<?php
}


function get_cat_name_from_db($cat_id){
	$temp_sql = "SELECT cat_name FROM biz_categories WHERE id = '".$cat_id."' ";
	$temp_res = mysql_db_query(DB,$temp_sql);
	$temp_data = mysql_fetch_array($temp_res);
	return $temp_data['cat_name'];
}
$sites_info = array();
function get_site_data_from_db($site_id){
	global $sites_info;
	if(isset($sites_info[$site_id])){
		return $sites_info[$site_id];
	}
	
	$temp_sql = "SELECT * FROM users WHERE id = '".$site_id."' ";
	$temp_res = mysql_db_query(DB,$temp_sql);
	$temp_data = mysql_fetch_array($temp_res);
	$sites_info[$site_id] = $temp_data;
	return $temp_data;
}

function get_page_data_from_db($page_id,$page_m,$page_type,$site_id){
		$page_data = array(
			"page_id"=>$page_id,
			"page_m"=>$page_m,
			"page_type"=>$page_type,
			"site_id"=>$site_id,
		);
		$page_data['type_txt'] = $page_data['page_m']." ";
		$page_data['page_name'] = "";
		if($page_data['page_m']!= "text" && $page_data['page_m']!= "land"){
			$page_data['type_txt'] .= "�� �����";
		}
		if($page_data['page_m']== "hp"){
			$page_data['type_txt'] .= "�� ��� - �����";
		}
		if($page_data['page_type'] == "0"){
			$page_data['type_txt'] .= "�� ����";
		}
		if($page_data['page_type'] == "2" || $page_data['page_m']== "land"){
			$page_data['type_txt'] .= "�� �����";
			$landing_page_sql = "SELECT landing_name FROM sites_landingPage_settings WHERE id = '".$page_data['page_id']."' ";
			$landing_page_res = mysql_db_query(DB,$landing_page_sql);
			$landing_page_data = mysql_fetch_array($landing_page_res);
			$page_data['page_name'] = $landing_page_data['landing_name'];
		}		
		if($page_data['page_m']== "text" && $page_data['page_type'] == "1"){
			$content_page_sql = "SELECT name FROM content_pages WHERE id = '".$page_data['page_id']."' ";
			$content_page_res = mysql_db_query(DB,$content_page_sql);
			$content_page_data = mysql_fetch_array($content_page_res);
			$page_data['page_name'] = $content_page_data['name'];
		}
		$site_data = get_site_data_from_db($site_id);
		$page_data['site_name'] = $site_data['name'];
		return $page_data;
}
	 
function get_form_counts($group_by,$date_from,$date_to,$filter_campaign_1,$filter_campaign_2){
	$dates_sql = " insert_date >= '".$date_from."' AND insert_date < '".$date_to."' ";
	$campaign_sql = "";
	if($filter_campaign_1 && $filter_campaign_2){
		$campaign_sql = " AND (campaign_type = '1' OR campaign_type = '2')";
	}
	else{
		if($filter_campaign_1){
			$campaign_sql = " AND campaign_type = '1' ";
		}
		if($filter_campaign_2){
			$campaign_sql = " AND campaign_type = '2' ";
		}
	}
	$where_sql = $dates_sql.$campaign_sql;
	if(isset($_REQUEST['cat_f'])){
		$where_sql .= " AND cat_f = '".$_REQUEST['cat_f']."' ";
	}
	if(isset($_REQUEST['cat_s'])){
		$where_sql .= " AND cat_s = '".$_REQUEST['cat_s']."' ";	
	}
	if(isset($_REQUEST['cat_spec'])){
		$where_sql .= " AND cat_spec = '".$_REQUEST['cat_spec']."' ";		
	}	
	if(isset($_REQUEST['browser_type'])){
		if($_REQUEST['browser_type'] != "all"){
			$where_sql .= " AND is_mobile = '".$_REQUEST['browser_type']."' ";
		}  
	}
	$forms_sql = "SELECT ".$group_by.", COUNT(id) as lead_count FROM estimate_form WHERE ".$where_sql." GROUP BY ".$group_by."";
	
	$forms_res = mysql_db_query(DB,$forms_sql);
	$result = array();
	while($forms_data = mysql_fetch_array($forms_res)){
		$result[$forms_data[$group_by]] = $forms_data['lead_count'];
	}
	return $result;
}

function get_send_counts($group_by,$date_from,$date_to,$filter_campaign_1,$filter_campaign_2){
	$dates_sql = " date_in >= '".$date_from."' AND date_in < '".$date_to."' ";
	$campaign_sql = "";
	if($filter_campaign_1 && $filter_campaign_2){
		$campaign_sql = " AND (campaign_type = '1' OR campaign_type = '2')";
	}
	else{
		if($filter_campaign_1){
			$campaign_sql = " AND campaign_type = '1' ";
		}
		if($filter_campaign_2){
			$campaign_sql = " AND campaign_type = '2' ";
		}
	}
	$where_sql = $dates_sql.$campaign_sql;
	if(isset($_REQUEST['cat_f'])){
		$where_sql .= " AND ef.cat_f = '".$_REQUEST['cat_f']."' ";
	}
	if(isset($_REQUEST['cat_s'])){
		$where_sql .= " AND ef.cat_s = '".$_REQUEST['cat_s']."' ";	
	}
	if(isset($_REQUEST['cat_spec'])){
		$where_sql .= " AND ef.cat_spec = '".$_REQUEST['cat_spec']."' ";		
	}	
	if(isset($_REQUEST['browser_type'])){
		if($_REQUEST['browser_type'] != "all"){
			$where_sql .= " AND ef.is_mobile = '".$_REQUEST['browser_type']."' ";
		}  
	}
	$forms_sql = "SELECT ".$group_by.", COUNT(ucf.id) as send_count FROM user_contact_forms ucf LEFT JOIN estimate_form ef ON ef.id = ucf.estimateFormID WHERE ".$where_sql." GROUP BY ".$group_by."";
	//echo "<hr/>".$forms_sql."<hr/>";
	$forms_res = mysql_db_query(DB,$forms_sql);
	$result = array();
	while($forms_data = mysql_fetch_array($forms_res)){
		$result[$forms_data[$group_by]] = $forms_data['send_count'];
	}
	return $result;
}