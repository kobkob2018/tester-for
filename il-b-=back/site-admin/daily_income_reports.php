<?php

function daily_income_report()
{

	
	$date_from_str = date("d-m-Y");
	if(isset($_GET['date_from'])){
		$date_from_str = trim($_GET['date_from']);
	}
	$date_from_arr = explode("-",$date_from_str);
	$date_from_sql = $date_from_arr[2]."-".$date_from_arr[1]."-".$date_from_arr[0];
	$date_to_str = date("d-m-Y");
	if(isset($_GET['date_to'])){
		$date_to_str = trim($_GET['date_to']);
	}
	$cats_sql = "SELECT id,cat_name,father FROM  biz_categories WHERE status !=9 ORDER BY cat_name";	
	
	$cats_res = mysql_db_query(DB, $cats_sql);
							
	$cat_list = array();
	$cat_list_by_name = array();
	$cat_list_names = array();
	while( $cat = mysql_fetch_array($cats_res)){	
		$cat_list_names[$cat['id']] = $cat['cat_name'];
		$cat_list[$cat['father']][$cat['id']] = $cat['cat_name']; 
		$cat_list_by_name[$cat['father']][] = $cat['id'];
	}
	$cat_filter = "0";
	if(isset($_GET['cat_selected'])){
		if(isset($_GET['cat_selected'][0]) && $_GET['cat_selected'][0] != '0'){
			$cat_selected[0] = $_GET['cat_selected'][0];
			$cat_filter = $_GET['cat_selected'][0];
			if(isset($_GET['cat_selected'][1]) && $_GET['cat_selected'][1] != '0'){
				$cat_selected[1] = $_GET['cat_selected'][1];
				$cat_filter = $_GET['cat_selected'][1];
				if(isset($_GET['cat_selected'][2]) && $_GET['cat_selected'][2] != '0'){
					$cat_selected[2] = $_GET['cat_selected'][2];
					$cat_filter = $_GET['cat_selected'][2];
				}
			}
		}
	}
	$user_cat_sql = "";
	if($cat_filter != "0"){
		$user_ids = array();
		
		$user_ids_sql = "SELECT DISTINCT user_id FROM user_cat WHERE cat_id = $cat_filter";
		$user_ids_res = mysql_db_query(DB, $user_ids_sql);		
		while($user_i = mysql_fetch_array($user_ids_res)){
			$user_ids[] = $user_i['user_id'];
		}

		$user_ids_sql = "SELECT DISTINCT user_id FROM user_cat_city WHERE cat_id = $cat_filter";
		$user_ids_res = mysql_db_query(DB, $user_ids_sql);		
		while($user_i = mysql_fetch_array($user_ids_res)){
			$user_ids[] = $user_i['user_id'];
		}
		
		if(empty($user_ids)){
			$user_cat_sql = " AND 0=1 ";
		}
		else{
			$user_ids_in = implode(",",$user_ids);
			$user_cat_sql = " AND user.id IN($user_ids_in) ";
		}
	}
	$date_to_arr = explode("-",$date_to_str);
	$date_to_sql_1 = $date_to_arr[2]."-".$date_to_arr[1]."-".$date_to_arr[0];
	$date_to_sql = date('Y-m-d', strtotime("+1 day", strtotime($date_to_sql_1)));
	$row_date = $date_from_sql;
	$user_name_sql = "";
	if(isset($_GET['user_name'])){
		$user_name_sql = ' AND user.name LIKE ("%'.$_GET['user_name'].'%") ';
	}
	$sql = "SELECT user.unk as unk,user.id as user_id, name, advertisingPrice ,advertisingStartDate,leadPrice,domainEndDate,hostPriceMon,domainPrice,end_date 
			FROM users user LEFT JOIN user_bookkeeping book ON book.unk = user.unk
			WHERE user.end_date > '$date_from_sql' $user_name_sql $user_cat_sql AND active_manager = 0 AND status = 0";	
	
	$income_arr = array();
	$res = mysql_db_query(DB, $sql);
							
	$user_list = array();
	$status_list = array(
		'0'=>array('str'=>'מתעניין חדש','id'=>'0'),
		'5'=>array('str'=>'מחכה לטלפון','id'=>'5'),
		'1'=>array('str'=>'נוצר קשר','id'=>'1'),
		'2'=>array('str'=>'סגירה עם לקוח','id'=>'2'),
		'3'=>array('str'=>'לקוח רשום','id'=>'3'),
		'4'=>array('str'=>'לא רלוונטי','id'=>'4'),
		'6'=>array('str'=>'הליד זוכה','id'=>'6'),
	);	
	$selected_status = "all";
	if(isset($_REQUEST['lead_status'])){
		$selected_status = $_REQUEST['lead_status'];
	}
	while( $user = mysql_fetch_array($res) ){
		if($user['domainPrice'] == ""){
			$user['domainPrice'] = 0;
		}
		if($user['hostPriceMon'] == ""){
			$user['hostPriceMon'] = 0;
		}
		if($user['advertisingPrice'] == ""){
			$user['advertisingPrice'] = 0;
		}
		if($user['leadPrice'] == ""){
			$user['leadPrice'] = 0;
		}		
		$user_static_costs = array(
			
			"domainPrice"=>$user['domainPrice']/365,
			//days in month is 28, 30 or 31
			"hostPriceMon"=>array(28=>$user['hostPriceMon']/28
							,29=>$user['hostPriceMon']/29
							,30=>$user['hostPriceMon']/30
							,31=>$user['hostPriceMon']/31),
							
			"advertisingPrice"=>array(28=>$user['advertisingPrice']/28
				,29=>$user['advertisingPrice']/29
				,30=>$user['advertisingPrice']/30
				,31=>$user['advertisingPrice']/31),
			"leads"=>$user['leadPrice'],
		);
		$user['static_costs'] = $user_static_costs;
		$user['leads_count_total'] = 0;
		$user['deal_closed_count'] = 0;
		$user_list[$user['unk']] = $user;
		
	} 
	
	
	
	$lead_campaign_sql = "";	
	if(isset($_REQUEST['add_campaign_leads'])){
		$lead_campaign_sql = " AND (lead.lead_recource = 'none'";
		if(isset($_REQUEST['add_reg_leads'])){
			$lead_campaign_sql .= " OR ef.campaign_type = '0' OR lead.phone_campaign_type = '0' ";
		}
		if(isset($_REQUEST['add_gl_leads'])){
			$lead_campaign_sql .= " OR ef.campaign_type = '1' OR lead.phone_campaign_type = '1' ";
		}		
		if(isset($_REQUEST['add_fb_leads'])){
			$lead_campaign_sql .= " OR ef.campaign_type = '2' OR lead.phone_campaign_type = '2' ";
		}
		
		$lead_campaign_sql .= ")";
	}
	$lead_status_sql = "";
	if($selected_status != "all" && $selected_status != ""){
		$lead_status_sql = " AND lead.status = $selected_status ";
	}
	$phone_leads_sql = "";
	if(isset($_REQUEST['phone_leads_remove'])){
		$phone_leads_sql = " AND lead.lead_recource = 'form' ";
	}	
	$form_leads_sql = "";
	if(isset($_REQUEST['form_leads_remove'])){
		$form_leads_sql = " AND lead.lead_recource != 'form' ";
	}	
	$lead_cat_sql = "";	
	if(isset($_REQUEST['cat_leads_only'])){
		$lead_cat_sql = " AND (lead.lead_recource != 'form' OR ef.cat_f = $cat_filter OR ef.cat_s = $cat_filter OR  ef.cat_spec = $cat_filter)";
	}
	
	$sql = "SELECT lead.id,user.unk as unk,user.id as user_id,date_in,lead.status as lead_status,ef.ip,lead.phone_campaign_name as phone_campaign_name,payByPassword,payByPassword,estimateFormID,lead_recource,lead_billed,phone_lead_id,cat_f,cat_s,cat_spec,lead.name,lead.phone,ef.campaign_type,lead.phone_campaign_type,lead.tag,tagin.tag_name as tag_name,lead.offer_amount
			FROM user_contact_forms lead 
			LEFT JOIN users user ON user.unk = lead.unk
			LEFT JOIN estimate_form ef ON ef.id = lead.estimateFormID 
			LEFT JOIN user_lead_tag tagin ON lead.tag = tagin.id 
			WHERE user.end_date > '$date_from_sql' $phone_leads_sql $form_leads_sql $lead_cat_sql $lead_status_sql $lead_campaign_sql $user_name_sql AND active_manager = 0 AND user.status = 0 AND lead.date_in > '$date_from_sql' AND lead.date_in < '$date_to_sql' AND lead.lead_billed = 1";	
			
	
	$res = mysql_db_query(DB, $sql);
							
	$lead_list = array();
	$campaign_str = array('0'=>'רגיל','1'=>'גוגל','2'=>'פייסבוק');
	$refunded_leads = array();
	$closed_deal_leads = array();
	while( $lead = mysql_fetch_array($res) ){
		if($lead['lead_recource'] == 'phone'){
			//$lead['campaign_str'] = $campaign_str[$lead['phone_campaign_type']];
			if(isset($_GET['show_leads']) && $lead['phone_lead_id'] != ""){
				$phone_lead_sql = "SELECT * FROM sites_leads_stat WHERE id = '".$lead['phone_lead_id']."' ";
				$phone_lead_res = mysql_db_query(DB,$phone_lead_sql);
				$phone_lead_data = mysql_fetch_array($phone_lead_res);
				$lead['call_info'] = $phone_lead_data;
			}
		}
		else{
			if(isset($campaign_str[$lead['campaign_type']])){
				$lead['campaign_str'] = $campaign_str[$lead['campaign_type']];
			}
			if((int)$lead['campaign_type'] > 999){
				$lead['campaign_str'] = "אפ - ";
				$aff_id = (int)$lead['campaign_type'] - 1000;
				$aff_sql = "SELECT * FROM affiliates WHERE id = '".$aff_id."'";
				$aff_res = mysql_db_query(DB,$aff_sql);
				$aff_data = mysql_fetch_array($aff_res);
				$lead['campaign_str'] .= $aff_data['biz_name'];
				//$lead['campaign_str'] = $aff_sql;
			}
		}
		$lead_date_arr = explode(" ",$lead['date_in']);
		$lead_date = $lead_date_arr[0];
		if($lead['lead_status'] != '6'){
			$lead_list[$lead_date][$lead['unk']][] = $lead;
			if($lead['lead_status'] == '2'){
				$closed_deal_leads[$lead_date][$lead['unk']][] = $lead;
			}
		}
		else{
			$refunded_leads[$lead_date][$lead['unk']][] = $lead;
		}
	
	}

//payByPassword 0 leads only here -----
	$sql = "SELECT lead.id,user.unk as unk,user.id as user_id,date_in,lead.status as lead_status,ef.ip,lead.phone_campaign_name as phone_campaign_name,payByPassword,payByPassword,estimateFormID,lead_recource,lead_billed,phone_lead_id,cat_f,cat_s,cat_spec,lead.name,lead.phone,ef.campaign_type,lead.phone_campaign_type,lead.tag,tagin.tag_name as tag_name
			FROM user_contact_forms lead 
			LEFT JOIN users user ON user.unk = lead.unk
			LEFT JOIN estimate_form ef ON ef.id = lead.estimateFormID 
			LEFT JOIN user_lead_tag tagin ON lead.tag = tagin.id 
			WHERE user.end_date > '$date_from_sql' $phone_leads_sql $form_leads_sql $lead_cat_sql $lead_status_sql $lead_campaign_sql $user_name_sql AND active_manager = 0 AND user.status = 0 AND lead.date_in > '$date_from_sql' AND lead.date_in < '$date_to_sql' AND lead.payByPassword = 0";	
			

	$res = mysql_db_query(DB, $sql);
							
	$payByPassword0_lead_list = array();
	
	while( $lead = mysql_fetch_array($res) ){
		if($lead['lead_recource'] == 'phone'){
			$lead['campaign_str'] = $campaign_str[$lead['phone_campaign_type']];
			if(isset($_GET['show_leads']) && $lead['phone_lead_id'] != ""){
				$phone_lead_sql = "SELECT * FROM sites_leads_stat WHERE id = '".$lead['phone_lead_id']."' ";
				$phone_lead_res = mysql_db_query(DB,$phone_lead_sql);
				$phone_lead_data = mysql_fetch_array($phone_lead_res);
				$lead['call_info'] = $phone_lead_data;
			}
		}
		else{
			$lead['campaign_str'] = $campaign_str[$lead['campaign_type']];
		}
		$lead_date_arr = explode(" ",$lead['date_in']);
		$lead_date = $lead_date_arr[0];
		$payByPassword0_lead_list[$lead_date][$lead['unk']][] = $lead;	
	}
//payByPassword 0 leads only untill here -----	
	//echo "<pre>";
	//print_r($lead_list);
	//echo "</pre>";
	$all_days_income = array(
		"domain"=>0, //domainPrice
		"hosting"=>0, //hostPriceMon
		"advertyzing_global"=>0, //advertisingPrice
		"leads_count"=>0, //leads
		"deal_closed_count"=>0, //leads
		"payByPassword0"=>0,
		"tracking_count"=>0,
		"tracking_cookie_count"=>0,
		"leads"=>0, //leads
		"sum_all"=>0, //leads
	); 
	while($row_date < $date_to_sql){
		$daily_income_arr = array(
			"domain"=>0, //domainPrice
			"hosting"=>0, //hostPriceMon
			"advertyzing_global"=>0, //advertisingPrice
			"leads"=>0, //leads
			"payByPassword0"=>0,
			"tracking_count"=>0,
			"tracking_cookie_count"=>0,			
			"deal_closed_count"=>0,
		); 
		$row_date_arr = explode("-",$row_date);
		$days_in_row_mont = cal_days_in_month ( CAL_GREGORIAN , $row_date_arr[1] , $row_date_arr[0] );
		$tracking_arr = array();
		$tracking_count_sql = "SELECT unk, COUNT( DISTINCT id ) AS tracking_count, COUNT( DISTINCT cookie ) AS tracking_cookie_count FROM customer_tracking WHERE tracking_date =  '$row_date' GROUP BY unk";
		$tracking_count_res = mysql_db_query(DB,$tracking_count_sql);
		while($tracking_count_data = mysql_fetch_array($tracking_count_res)){
			$tracking_arr[$tracking_count_data['unk']] = $tracking_count_data;
		}
		
		foreach($user_list as $key=>$user){
			
			if($user['end_date'] >= $row_date){
				$user_income_row = array();
				$user_income_row['name'] = "<a target='_blank' href='?main=user_profile&unk=".$user['unk']."&record_id=".$user['user_id']."&sesid=".SESID."'>".$user['name']."</a>";
				$user_income_row['user_id'] = $user['user_id'];
				if(isset($lead_list[$row_date][$user['unk']])){
					
					$user_lead_count = count($lead_list[$row_date][$user['unk']]);
					if($user['leadPrice'] != 0 && $user['leadPrice'] != ""){
						$user_lead_daily_outcome = $user_lead_count*$user['leadPrice'];
						$daily_income_arr['leads']+=$user_lead_daily_outcome;
						$user_income_row['leads']=$user_lead_daily_outcome;
					}					
					$user_income_row['leads_count']=$user_lead_count;
					$user_income_row['lead_list'] = $lead_list[$row_date][$user['unk']];
					if(isset($closed_deal_leads[$row_date][$user['unk']])){				
						$user_income_row['closed_deal_leads'] = $closed_deal_leads[$row_date][$user['unk']];
						$user_income_row['deal_closed_count'] = count($user_income_row['closed_deal_leads']);
						$daily_income_arr['deal_closed_count']+=$user_income_row['deal_closed_count'];
						$user_list[$key]['leads_count_total']+=$user_income_row['leads_count_total'];
					}
					else{
						$user_income_row['deal_closed_count'] = 0;
					}
				}
				else{
					$user_income_row['leads_count']=0;		
				}
				if(isset($user['unk'])){
					if(isset($tracking_arr[$user['unk']])){
						
						$tracking_arr_unk = $tracking_arr[$user['unk']];
						if($tracking_arr_unk['tracking_count'] != ''){
							$user_income_row['tracking_count'] = $tracking_arr_unk['tracking_count'];
						}
						if($tracking_arr_unk['tracking_cookie_count'] != ''){
							$user_income_row['tracking_cookie_count'] = $tracking_arr_unk['tracking_cookie_count'];
						}
					}				
				}
				if(!isset($user_income_row['tracking_count'])){
					$user_income_row['tracking_count'] = 0;
				}
				if(!isset($user_income_row['tracking_cookie_count'])){
					$user_income_row['tracking_cookie_count'] = 0;
				}
				$daily_income_arr['leads_count']+=$user_income_row['leads_count'];
				
				
				//payByPassword 0 leads only here -----	
				if(isset($payByPassword0_lead_list[$row_date][$user['unk']])){
					
					$user_payByPassword0_count = count($payByPassword0_lead_list[$row_date][$user['unk']]);					
					$user_income_row['payByPassword0']=$user_payByPassword0_count;
					$user_income_row['payByPassword0_lead_list'] = $payByPassword0_lead_list[$row_date][$user['unk']];
				}
				else{
					$user_income_row['payByPassword0']=0;		
				}
				$daily_income_arr['payByPassword0']+=$user_income_row['payByPassword0'];
				
				$daily_income_arr['tracking_count']+=$user_income_row['tracking_count'];
				$daily_income_arr['tracking_cookie_count']+=$user_income_row['tracking_cookie_count'];		
					
				//payByPassword 0 leads only untill here -----	
				
				
				if(isset($refunded_leads[$row_date][$user['unk']])){				
					$user_income_row['refunded_leads'] = $refunded_leads[$row_date][$user['unk']];
				}
			
				$user_list[$key]['leads_count_total']+=$user_income_row['leads_count'];
				$daily_income_arr['hosting']+=$user['static_costs']['hostPriceMon'][$days_in_row_mont];
				$user_income_row['hosting']=$user['static_costs']['hostPriceMon'][$days_in_row_mont];
				if($user['domainEndDate'] >= $row_date){
					$daily_income_arr['domain']+=$user['static_costs']['domainPrice'];
					$user_income_row['domain']=$user['static_costs']['domainPrice'];
				}
				else{
					$user_income_row['domain']=0;
				}
				if($user['advertisingStartDate'] <= $row_date){
					$daily_income_arr['advertyzing_global']+=$user['static_costs']['advertisingPrice'][$days_in_row_mont];
					$user_income_row['advertyzing_global']=$user['static_costs']['advertisingPrice'][$days_in_row_mont];
				}
				$user_income_row['sum_all'] = 
				
					$user_income_row['hosting']+
					$user_income_row['domain']+ 
					$user_income_row['advertyzing_global']+
					$user_income_row['leads']
					; 
					
				if($user_income_row['sum_all'] != 0 || isset($user_income_row['lead_list']) || $user_income_row['payByPassword0']!='0')
				{
					$daily_income_arr['user'][$user['unk']] = $user_income_row;
				}
			}
		}
		
		$daily_income_arr['sum_all'] = $daily_income_arr['hosting'] + $daily_income_arr['domain'] + $daily_income_arr['advertyzing_global'] + $daily_income_arr['leads'];
		$income_arr[$row_date] = $daily_income_arr;
		$row_date = date('Y-m-d', strtotime("+1 day", strtotime($row_date)));	
		
		$all_days_income['domain']+=$daily_income_arr['domain'];
		$all_days_income['hosting']+=$daily_income_arr['hosting'];
		$all_days_income['advertyzing_global']+=$daily_income_arr['advertyzing_global'];
		$all_days_income['leads_count']+=$daily_income_arr['leads_count'];
		$all_days_income['payByPassword0']+=$daily_income_arr['payByPassword0'];	  			
		$all_days_income['tracking_count']+=$daily_income_arr['tracking_count']; // ----- tracking_count tracking_cookie_count
		$all_days_income['tracking_cookie_count']+=$daily_income_arr['tracking_cookie_count'];
		$all_days_income['deal_closed_count']+=$daily_income_arr['deal_closed_count'];
		$all_days_income['leads']+=$daily_income_arr['leads'];
		$all_days_income['sum_all']+=$daily_income_arr['sum_all'];
		
		
	}
	$all_days_income['sum_all_2'] = $all_days_income['domain']+$all_days_income['hosting']+$all_days_income['advertyzing_global']+$all_days_income['leads'];
	?>
	
	
	<h3>
		דוח הכנסות יומיות
	</h3>
	<a href="?sesid=<?php echo SESID; ?>" >חזרה לתפריט הראשי</a>
	&nbsp;&nbsp;&nbsp;&nbsp;
	<a href="https://ilbiz.co.il/myleads/" target="_BLANK">מערכת ניהול לידים</a>
<!-- sub categories helpers -->
	<div style= "display:none;" id="cat_select_sub_mokups">
		<?php foreach($cat_list_by_name['0'] as $cat_id_f): ?>
			<?php echo  $cat_list['0'][$cat_id_f]; ?>
			<select id="sub_cat_select_<?php echo $cat_id_f; ?>_mokup" class='input_style cat_selected_sub cat_selected_trig'  data-father="0" data-id="<?php echo  $cat_id_f; ?>" style="width:130px;" >
				<option value='0'>בחר קטגוריה</option>
				<?php foreach($cat_list_by_name[$cat_id_f] as $cat_id): ?>
					<option value='<?php echo $cat_id; ?>'><?php echo $cat_list[$cat_id_f][$cat_id]; ?></option>
				<?php endforeach; ?>
			</select>	
			<?php foreach($cat_list_by_name[$cat_id_f] as $cat_id_s): if(!empty($cat_list_by_name[$cat_id_s])): ?>
				<?php echo  $cat_list[$cat_id_f][$cat_id_s]; ?>
				<select id="sub_cat_select_<?php echo $cat_id_s; ?>_mokup" class='input_style cat_selected_sub cat_selected_trig' style="width:130px;" data-father="<?php echo $cat_id_f; ?>"  data-id="<?php echo  $cat_id_s; ?>">
					<option value='0'>בחר קטגוריה</option>
					<?php foreach($cat_list_by_name[$cat_id_s] as $cat_id_spaec): ?>
						<option value='<?php echo $cat_id_spaec; ?>'><?php echo $cat_list[$cat_id_s][$cat_id_spaec]; ?></option>
					<?php endforeach; ?>
				</select>				
			<?php endif;  endforeach; ?>					
		<?php endforeach; ?>
	</div>		
	
	<script type="text/javascript">
		jQuery(document).ready(function($){
			
			$(".cat_selected_trig").each(function(){
				$(this).change(function(){
					var el_id = $(this).attr("data-id");
					update_sub_cat_select(el_id);
				});				
			});
			<?php if(isset($cat_selected[0])): ?>
				trigger_cat_select("0","<?php echo $cat_selected[0]; ?>");
			<?php endif; ?>
			<?php if(isset($cat_selected[1])): ?>
				setTimeout(function(){
					trigger_cat_select("<?php echo $cat_selected[0]; ?>","<?php echo $cat_selected[1]; ?>");
				},300);
			<?php endif; ?>		
			<?php if(isset($cat_selected[2])): ?>
				setTimeout(function(){
					trigger_cat_select("<?php echo $cat_selected[1]; ?>","<?php echo $cat_selected[2]; ?>");
				},600);
			<?php endif; ?>				
		});	

		function trigger_cat_select(cat_id,select_val){
			jQuery(function($){
				jQuery("#sub_cat_select_"+cat_id).val(select_val).trigger('change');
			});
		}
		
		function remove_select_sons(el_id){
			jQuery(function($){
				$("#sub_cat_place_holder").find(".cat_selected_sub").each(function(){
					var father_cat = $(this).attr("data-father");
					if(father_cat == el_id){
						remove_select_sons($(this).attr("data-id"));
						$(this).remove();
					}
				});	
			});			
		}
		
		function update_sub_cat_select(el_id){
			remove_select_sons(el_id);
			jQuery(function($){
					var select_el = $("#sub_cat_select_"+el_id);	
					var selected_cat = select_el.val();
					if($("#sub_cat_select_"+selected_cat+"_mokup").length != "0"){
						var select_parent = select_el.attr("data-father");
						var new_select_mokup = $("#sub_cat_select_"+selected_cat+"_mokup").clone();
						var new_select_sub = new_select_mokup.clone();
						new_select_sub.attr("id","sub_cat_select_"+selected_cat).attr("name","cat_selected[]");
						new_select_sub.appendTo("#sub_cat_place_holder");
						new_select_sub.change(function(){
							update_sub_cat_select($(this).attr("data-id"));
						});
					}
				});
			}
	
	</script>
	
	<div style="padding:20px;">
		<form action="index.php?main=&sesid=<?php echo SESID; ?>" method="GET">
			<input type="hidden" name="main" value="daily_income_report" />
			<input type="hidden" name="sesid" value="<?php echo SESID; ?>" />
			מתאריך <input type="text" name="date_from" value="<?php echo $date_from_str; ?>" />&nbsp&nbsp&nbsp
			עד תאריך  <input type="text" name="date_to" value="<?php echo $date_to_str; ?>" />&nbsp&nbsp&nbsp
			שם לקוח  <input type="text" name="user_name" value="<?php echo $_GET['user_name']; ?>" />&nbsp&nbsp&nbsp
			<br/><br/>
			<?php
				$add_campaign_leads_style = "display:none;";
				$add_campaign_leads_checked = "";
				$add_reg_leads_checked = "checked";
				$add_fb_leads_checked = "checked";
				$add_gl_leads_checked = "checked";
				
				if(isset($_GET['add_campaign_leads'])){
					$add_campaign_leads_style = "display:block;";
					$add_campaign_leads_checked = "checked";
					$add_reg_leads_checked = "";
					$add_fb_leads_checked = "";
					$add_gl_leads_checked = "";
					if(isset($_GET['add_reg_leads'])){
						$add_reg_leads_checked = "checked";
					}
					if(isset($_GET['add_fb_leads'])){
						$add_fb_leads_checked = "checked";
					}
					if(isset($_GET['add_gl_leads'])){
						$add_gl_leads_checked = "checked";
					}
				}				
			?>
			
			
			<br/> 
			<input type="checkbox" id="add_campaign_leads_door" name="add_campaign_leads" value="1" <?php echo $add_campaign_leads_checked; ?>/>הוסף סינון לידים לפי קמפיין:  &nbsp&nbsp&nbsp
			<div id="add_campaign_leads_wrap" style="<?php echo $add_campaign_leads_style; ?>"><br/><b>הוסף לחישוב לידים מסוג: </b>
				<input type="checkbox"  name="add_reg_leads" value="1" <?php echo $add_reg_leads_checked; ?>/> ללא קמפיין &nbsp&nbsp&nbsp
				<input type="checkbox"  name="add_fb_leads" value="1" <?php echo $add_fb_leads_checked; ?>/> מקמפיין פייסבוק &nbsp&nbsp&nbsp
				<input type="checkbox"  name="add_gl_leads" value="1" <?php echo $add_gl_leads_checked; ?>/> מקמפיין גוגל &nbsp&nbsp&nbsp
				
			</div>	
			<br/><br/>
			<script type="text/javascript">
				jQuery(function($){
					$("#add_campaign_leads_door").change(function(){
						console.log("---"+$(this).attr('checked'));
						
						if($(this).attr('checked')){
							$("#add_campaign_leads_wrap").show();
						}
						else{
							$("#add_campaign_leads_wrap").hide();
						}
					});
				});
			</script>
			קטגוריה
			<select id="sub_cat_select_0" name='cat_selected[]' class='input_style cat_selected_f cat_selected_trig' data-id='0' data-father='0' style='width:130px;'>
				<option value='0'>בחר קטגוריה</option>
				<?php foreach($cat_list_by_name['0'] as $cat_id): ?>
					<option value='<?php echo $cat_id; ?>'><?php echo $cat_list['0'][$cat_id]; ?></option>
				<?php endforeach; ?>
			</select>
			<?php
				
				$cat_leads_only_checked = "";
				
				if(isset($_GET['cat_leads_only'])){
					$cat_leads_only_checked = "checked";
				}
				$phone_leads_remove_checked = "";
				$form_leads_remove_checked = "";
				
				if(isset($_GET['phone_leads_remove'])){
					$phone_leads_remove_checked = "checked";
				}
				if(isset($_GET['form_leads_remove'])){
					$form_leads_remove_checked = "checked";
				}				
			?>			
			
			<span id="sub_cat_place_holder">
			
			</span>
			<input type="checkbox"  name="cat_leads_only" value="1" <?php echo $cat_leads_only_checked; ?>/> הוסף רק לידים ששייכים לקטגוריה &nbsp&nbsp&nbsp
			<input type="checkbox"  name="phone_leads_remove" value="1" <?php echo $phone_leads_remove_checked; ?>/> הסר לידים טלפוניים &nbsp&nbsp&nbsp
			<input type="checkbox"  name="form_leads_remove" value="1" <?php echo $form_leads_remove_checked; ?>/> הסר לידים מטפסים &nbsp&nbsp&nbsp
			<br/><br/>
			<?php
				$show_customers_checked = "";
				if(isset($_GET['show_customers'])){
					$show_customers_checked = "checked";
				}
				$show_leads_checked = "";
				if(isset($_GET['show_leads'])){
					$show_leads_checked = "checked";
				}				
			?>
			<input type="checkbox"  name="show_customers" value="1" <?php echo $show_customers_checked; ?>/> הצג פרוט לקוחות &nbsp&nbsp&nbsp
			<input type="checkbox"  name="show_leads" value="1" <?php echo $show_leads_checked; ?>/> הצג פרוט לידים ללקוח &nbsp&nbsp&nbsp
			בחר סטטוס ליד
			<select id="status_select" name="lead_status" class='input_style' style="width:130px;" >
				<?php $selected_str = ($selected_status == "all")? "selected":""; ?> 
				<option value='all' <?php echo $selected_str; ?>>כל הסטטוסים</option>
				<?php foreach($status_list as $status_id=>$status_data): ?>
					<?php $selected_str = ($selected_status ==  $status_data['id'])? "selected":""; ?> 
					<option value='<?php echo $status_id; ?>' <?php echo $selected_str; ?>><?php echo $status_data['str']; ?></option>
				<?php endforeach; ?>
			</select>
			&nbsp&nbsp&nbsp
			<input type="submit" value="הצג" />
		</form>
	</div>
	
	<table border="1" cellpadding="3" style="border-collapse: collapse;">
		<tr>
			<th>יום</th>
			<th>אחסון</th>
			<th>דומיין</th>
			<th>פרסום</th>
			<td>כמות לידים</td>
			<th>לידים</th>
			<th>סגירה עם לקוח</th>
			<th>לידים בכוכביות</th>
			<th>מספר כניסות לעמודים</th>
			<th>מספר גולשים</th>
			<th>סך הכל</th>
		</tr>
		<?php foreach($income_arr as $day=>$day_income_arr): ?>
			<?php $day_arr = explode("-",$day); $day_str = $day_arr[2]."-".$day_arr[1]."-".$day_arr[0]; ?>
			<tr>
				<th><?php echo $day_str; ?></td>
				<td><?php echo number_format ($day_income_arr['hosting'],2); ?></td>
				<td><?php echo number_format ($day_income_arr['domain'],2); ?></td>
				<td><?php echo number_format ($day_income_arr['advertyzing_global'],2); ?></td>
				<td><?php echo $day_income_arr['leads_count']; ?></td>
				<td><?php echo number_format ($day_income_arr['leads'],2); ?></td>
				<td><?php echo $day_income_arr['deal_closed_count']; ?></td>
				<td><?php echo $day_income_arr['payByPassword0']; ?></td>
				<td><?php echo $day_income_arr['tracking_count']; ?></td>
				<td><?php echo $day_income_arr['tracking_cookie_count']; ?></td>
				<td><?php echo number_format ($day_income_arr['sum_all'],2); ?></td>
			</tr>
			
			
		<?php endforeach; ?>
		<tr>
			<th style="color:green">סיכום</td>
			<td style="color:green"><?php echo number_format ($all_days_income['hosting'],2); ?></td>
			<td style="color:green"><?php echo number_format ($all_days_income['domain'],2); ?></td>
			<td style="color:green"><?php echo number_format ($all_days_income['advertyzing_global'],2); ?></td>
			<td style="color:green"><?php echo $all_days_income['leads_count']; ?></td>
			<td style="color:green"><?php echo number_format ($all_days_income['leads'],2); ?></td>
			<td style="color:green"><?php echo $all_days_income['deal_closed_count']; ?></td>
			<td style="color:green"><?php echo $all_days_income['payByPassword0']; ?></td>
			<td style="color:green"><?php echo $all_days_income['tracking_count']; ?></td>
			<td style="color:green"><?php echo $all_days_income['tracking_cookie_count']; ?></td>			
			<td style="color:green">
				<?php echo number_format ($all_days_income['sum_all'],2); ?>
				<br/>
				<small>
					<?php echo number_format ($all_days_income['sum_all_2'],2); ?>
				</small>
			</td>
		</tr>
	</table>

	<?php if(isset($_GET['show_customers'])): ?>
		<h3>פירוט לקוחות ליום</h3>
		<?php foreach($income_arr as $day=>$day_income_arr): ?>
			<?php $day_arr = explode("-",$day); $day_str = $day_arr[2]."-".$day_arr[1]."-".$day_arr[0]; ?>
			<br/><br/>
			<table border="1" cellpadding="3"  style="border-collapse: collapse;">
			<tr>
				<th>יום</th>
				<th>אחסון</th>
				<th>דומיין</th>
				<th>פרסום</th>
				<td>כמות לידים</td>
				<th>לידים</th>
				<th>סגירה עם לקוח</th>
				<th>לידים בכוכביות</th>
				<th>מספר כניסות לעמודים</th>
				<th>מספר גולשים</th>				
				<th>סך הכל</th>
			</tr>
			<tr>
				<td><?php echo $day_str; ?></td>
				<td><?php echo number_format ($day_income_arr['hosting'],2); ?></td>
				<td><?php echo number_format ($day_income_arr['domain'],2); ?></td>
				<td><?php echo number_format ($day_income_arr['advertyzing_global'],2); ?></td>
				<td><?php echo $day_income_arr['leads_count']; ?></td>
				<td><?php echo number_format ($day_income_arr['leads'],2); ?></td>
				<td><?php echo $day_income_arr['deal_closed_count']; ?></td>
				<td><?php echo $day_income_arr['payByPassword0']; ?></td>
				<td><?php echo $day_income_arr['tracking_count']; ?></td>
				<td><?php echo $day_income_arr['tracking_cookie_count']; ?></td>					
				<td><?php echo number_format ($day_income_arr['sum_all'],2); ?></td>
			</tr>
			</table>
			<br/>
			<table border="1" cellpadding="3"  style="border-collapse: collapse;">
			<tr>
			<th>לקוח</th>
			<th>אחסון</th>
			<th>דומיין</th>
			<th>פרסום</th>
			<td>כמות לידים</td>
			<td>סגירה עם לקוח</td>
			<td>לידים בכוכביות</td>
			<th>מספר כניסות לעמודים</th>
			<th>מספר גולשים</th>				
			<td>כמות לידים לכל התקופה</td>
			<td>מחיר ליד</td>
			<th>לידים</th>
			<th>סך הכל</th>
			</tr>
			<?php $add_th = false; ?>
			<?php foreach($day_income_arr['user'] as $unk=>$user_income_arr): ?>
				<?php if($add_th): ?>
					<tr>
						<th>לקוח</th>
						<th>אחסון</th>
						<th>דומיין</th>
						<th>פרסום</th>
						<td>כמות לידים</td>
						<td>סגירה עם לקוח</td>
						<td>לידים בכוכביות</td>
						<th>מספר כניסות לעמודים</th>
						<th>מספר גולשים</th>							
						<td>כמות לידים לכל התקופה</td>
						<td>מחיר ליד</td>
						<th>לידים</th>
						<th>סך הכל</th>
					</tr>
				<?php endif; ?>
				<?php $add_th = false; ?>
				<tr>
					<td><?php echo $user_income_arr['name']; ?></td>
					<td><?php echo number_format ($user_income_arr['hosting'],2); ?></td>
					<td><?php echo number_format ($user_income_arr['domain'],2); ?></td>
					<td><?php echo number_format ($user_income_arr['advertyzing_global'],2); ?></td>
					<td><?php echo $user_income_arr['leads_count']; ?></td>
					<td><?php echo $user_income_arr['deal_closed_count']; ?></td>
					<td><?php echo $user_income_arr['payByPassword0']; ?></td>
					<td><?php echo $user_income_arr['tracking_count']; ?></td>
					<td><?php echo $user_income_arr['tracking_cookie_count']; ?></td>						
					<td><?php echo $user_list[$unk]['leads_count_total']; ?></td>
					<td><?php echo number_format ($user_list[$unk]['leadPrice'],2); ?></td>
					<td><?php echo number_format ($user_income_arr['leads'],2); ?></td>
					<td><?php echo number_format ($user_income_arr['sum_all'],2); ?></td>
				</tr>
				<?php if((isset($user_income_arr['lead_list']) || isset($user_income_arr['refunded_leads']) || isset($user_income_arr['payByPassword0_lead_list'])) && isset($_GET['show_leads'])): ?>
					<?php $add_th = true; ?>
					<tr>
						<td colspan="9">
							<?php
								$call_sector_style = ' style="background:#a6ffde;" ';
								$call_sector_style_red = ' style="background:#ffd1d1;" ';
								$call_sector_style_yellow = ' style="background:#a6d1ff;" '; 
							?>
							<table border="1"  cellpadding="3"  style="margin:10px;border-collapse: collapse;" >
								<tr>
									<th colspan="10">לידים - <?php echo $user_income_arr['name']; ?></th>
									
									<th colspan="3" <?php echo $call_sector_style; ?>>מאפייניי שיחה</th>
									
									<th colspan="3" <?php echo $call_sector_style; ?>>איתור גלישה בעמוד</th>
								</tr>
								<tr>
									<th>שעה</th>
									<th>קטגוריה</th>
									<th>תיוג</th>
									<th>שם</th>
									<th>טלפון</th>
									<th>הגיע מ</th>
									<th>IP</th>
									<th>קמפיין</th>
									<th>סטטוס</th>
									<th>הצעת מחיר</th>
									<th <?php echo $call_sector_style; ?>>סטטוס שיחה</th>
									<th <?php echo $call_sector_style; ?>>זמן שיחה/הקלטה</th>
									<th <?php echo $call_sector_style; ?>>הפך לליד</th>
									
									<th <?php echo $call_sector_style; ?>>עמודים שאותרו</th>
									<th <?php echo $call_sector_style; ?>>מספר פעמים התקשר לפני</th>
									<th <?php echo $call_sector_style; ?>>תווך זמן התאמה לעמוד</th>
								</tr>
								<?php foreach($user_income_arr['lead_list'] as $lead): ?>
									<?php 
										if($lead['lead_recource'] == 'phone'){
											$check_ef_sql = "SELECT id FROM estimate_form WHERE phone = ".$lead['phone']." LIMIT 1";
											$check_ef_res = mysql_db_query(DB,$check_ef_sql);
											$check_ef_data = mysql_fetch_array($check_ef_res);
											$lead['has_ef'] = false;
											$lead['has_ef_str'] = "לא";
											$lead['has_ef_bg'] = "#fbc8c8";
											if($check_ef_data['id'] != ""){
												$lead['has_ef'] = true;
												$lead['has_ef_str'] = "כן";
												$lead['has_ef_bg'] = "#7fcc7f";
											}
											else{
												$check_ef_sql = "SELECT lead_by_phone FROM misscalls_comments WHERE lead_id = ".$lead['id']." LIMIT 1";
												$check_ef_res = mysql_db_query(DB,$check_ef_sql);
												$check_ef_data = mysql_fetch_array($check_ef_res);		
												if($check_ef_data['lead_by_phone'] != ""){
													$lead['has_ef'] = true;
													$lead['has_ef_str'] = $check_ef_data['lead_by_phone'];
													$lead['has_ef_bg'] = "#37ff37";
												}												
											}
										}
									?>
									<tr>
										<td><?php $date_in_arr = explode(" ",$lead['date_in']); echo $date_in_arr[1]; ?>
											<br/>
											<a target='_BLANK' href='https://ilbiz.co.il/site-admin/index.php?main=users_list&sesid=<?php echo SESID; ?>&send_to_my_leads=<?php echo $user_income_arr['user_id']; ?>&lead_id=<?php echo $lead['id']; ?>'>צפה במערכת ניהול הלידים</a>
										</td>
										<td>
											<?php if($lead['cat_f'] != 0 && $lead['cat_f'] != ""): ?>
												<?php echo $cat_list_names[$lead['cat_f']]; ?><br/>
											<?php endif; ?>
											<?php if($lead['cat_s'] != 0 && $lead['cat_s'] != ""): ?>
												&nbsp&nbsp<?php echo $cat_list_names[$lead['cat_s']]; ?><br/>
											<?php endif; ?>	
											<?php if($lead['cat_spec'] != 0 && $lead['cat_spec'] != ""): ?>
												&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp<?php echo $cat_list_names[$lead['cat_spec']]; ?><br/>
											<?php endif; ?>											
										</td>
										<td><?php echo $lead['tag_name']; ?></td>
										<td><a target="_blank" href="?main=send_estimate_form_users_list&estimate_id=<?php echo $lead['estimateFormID']; ?>&sesid=<?php echo SESID; ?>"><?php echo $lead['name']; ?></a></td>
										<td><?php echo $lead['phone']; ?></td>
										<td><?php echo $lead['lead_recource']; ?></td>
										<td><?php echo $lead['ip']; ?></td>
										<td><?php echo $lead['campaign_str']; ?> [<?php echo $lead['phone_campaign_name']; ?>]</td>
										<td><?php echo $status_list[$lead['lead_status']]['str']; ?></td>
										<td><?php echo $lead['offer_amount']; ?></td>
										<?php if(isset($lead['call_info'])): $call_style = ($lead['call_info']['answer'] == "ANSWERED")? $call_sector_style: ($lead['call_info']['answer'] == "MESSEGE")? $call_sector_style_yellow: $call_sector_style_red; ?>
											<td <?php echo $call_style; ?>>
												<?php echo $lead['call_info']['answer']; ?>
												<?php if($lead['call_info']['extra'] != ""): ?>
													<br/>
													<?php echo $lead['call_info']['extra']; ?>
												<?php endif; ?>
											</td>										
											<td <?php echo $call_style; ?>>
												<?php if($lead['call_info']['billsec']!='0'): ?>
													<a target='_blank' href='https://ilbiz.co.il/site-admin/recording_handlers/download.php?filename=<?php echo $lead['call_info']['recordingfile']; ?>'>
												<?php endif; ?>
													<?php echo $lead['call_info']['billsec']; ?>
												<?php if($lead['call_info']['billsec']!='0'): ?>
													</a>
												<?php endif; ?>
	
											</td>
											<td style='background:<?php echo $lead['has_ef_bg']; ?>'><?php echo $lead['has_ef_str']; ?></td>
											<?php if($lead['call_info']['tracking_mach'] != '-3'): ?>
												<td <?php echo $call_style; ?>>
													<?php if($lead['call_info']['tracking_mach'] == '-1'): ?>
														לא נמצאו עמודים
													<?php elseif($lead['call_info']['tracking_mach'] == '-2'): ?>
														לא שיחה ראשונה
													<?php else: ?>
														<?php echo $lead['call_info']['tracking_mach']; ?>
													<?php endif; ?>
												</td>	
												<td <?php echo $call_style; ?>>
													<?php echo $lead['call_info']['times_called']; ?>
												</td>	
												<td <?php echo $call_style; ?>>
													<?php echo $lead['call_info']['track_time_range']; ?>
												</td>
											<?php else: ?>
												<td>-</td>
												<td>-</td>
												<td>-</td> 
											<?php endif; ?>
										<?php endif; ?>
									</tr>									
								<?php endforeach; ?>
								<?php if(isset($user_income_arr['refunded_leads'])): ?>
									<tr>

										<th colspan="5" style='color:red;'>זיכויים</th>
									
									</tr>
									<?php foreach($user_income_arr['refunded_leads'] as $refunded_lead): ?>
										<tr>
											<td><?php echo $refunded_lead['date_in']; ?></td>
											<td>
												<?php if($refunded_lead['cat_f'] != 0 && $refunded_lead['cat_f'] != ""): ?>
													<?php echo $cat_list_names[$refunded_lead['cat_f']]; ?><br/>
												<?php endif; ?>
												<?php if($refunded_lead['cat_s'] != 0 && $refunded_lead['cat_s'] != ""): ?>
													&nbsp&nbsp<?php echo $cat_list_names[$refunded_lead['cat_s']]; ?><br/>
												<?php endif; ?>	
												<?php if($refunded_lead['cat_spec'] != 0 && $refunded_lead['cat_spec'] != ""): ?>
													&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp<?php echo $cat_list_names[$refunded_lead['cat_spec']]; ?><br/>
												<?php endif; ?>											
											</td>
											<td><?php echo $refunded_lead['tag_name']; ?></td>
											<?php
											
											/*
											echo "<a target='_blank' href='https://212.143.60.5/index.php?menu=monitoring&action=display_record&id=".$phone_lead_data['uniqueid']."&rawmode=yes' class='maintext'>לחץ כאן להורדת הקלטה</a><br/>";
											*/
											
											?>
											<td><a target="_blank" href="?main=send_estimate_form_users_list&estimate_id=<?php echo $refunded_lead['estimateFormID']; ?>&sesid=<?php echo SESID; ?>"><?php echo $refunded_lead['name']; ?></a></td>
											<td><?php echo $refunded_lead['phone']; ?></td>
											<td><?php echo $refunded_lead['lead_recource']; ?></td>
											<td><?php echo $refunded_lead['campaign_str']; ?></td>	
											<?php if(isset($refunded_lead['call_info'])): $call_style = ($refunded_lead['call_info']['answer'] == "ANSWERED")? $call_sector_style: ($refunded_lead['call_info']['answer'] == "MESSEGE")? $call_sector_style_yellow: $call_sector_style_red; ?>
												<td <?php echo $call_style; ?>>
													<?php echo $refunded_lead['call_info']['answer']; ?>
												</td>										
												<td <?php echo $call_style; ?>>
													<?php if($refunded_lead['call_info']['billsec']!='0'): ?>
														<a target='_blank' href='https://ilbiz.co.il/site-admin/recording_handlers/download.php?filename=<?php echo $refunded_lead['call_info']['recordingfile']; ?>'>
													<?php endif; ?>
													<?php echo $refunded_lead['call_info']['billsec']; ?>
													<?php if($refunded_lead['call_info']['billsec']!='0'): ?>
														</a>
													<?php endif; ?>													
												</td>
											<?php endif; ?>
										</tr>									
									<?php endforeach; ?>
											
								<?php endif; ?>		




<?php /* payByPassword 0 leads only here ----- */ ?>
								<?php if(isset($user_income_arr['payByPassword0_lead_list'])): ?>
									<tr>

										<th colspan="5" style='color:red;'>כוכביות</th>
									
									</tr>
									<?php foreach($user_income_arr['payByPassword0_lead_list'] as $payByPassword0_lead): ?>
										<tr>
											<td><?php echo $payByPassword0_lead['date_in']; ?></td>
											<td>
												<?php if($payByPassword0_lead['cat_f'] != 0 && $payByPassword0_lead['cat_f'] != ""): ?>
													<?php echo $cat_list_names[$payByPassword0_lead['cat_f']]; ?><br/>
												<?php endif; ?>
												<?php if($payByPassword0_lead['cat_s'] != 0 && $payByPassword0_lead['cat_s'] != ""): ?>
													&nbsp&nbsp<?php echo $cat_list_names[$payByPassword0_lead['cat_s']]; ?><br/>
												<?php endif; ?>	
												<?php if($payByPassword0_lead['cat_spec'] != 0 && $payByPassword0_lead['cat_spec'] != ""): ?>
													&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp<?php echo $cat_list_names[$payByPassword0_lead['cat_spec']]; ?><br/>
												<?php endif; ?>											
											</td>
											<td><?php echo $payByPassword0_lead['tag_name']; ?></td>
											<?php
											
											/*
											echo "<a target='_blank' href='https://212.143.60.5/index.php?menu=monitoring&action=display_record&id=".$phone_lead_data['uniqueid']."&rawmode=yes' class='maintext'>לחץ כאן להורדת הקלטה</a><br/>";
											*/
											
											?>
											<td><a target="_blank" href="?main=send_estimate_form_users_list&estimate_id=<?php echo $payByPassword0_lead['estimateFormID']; ?>&sesid=<?php echo SESID; ?>"><?php echo $payByPassword0_lead['name']; ?></a></td>
											<td><?php echo $payByPassword0_lead['phone']; ?></td>
											<td><?php echo $payByPassword0_lead['lead_recource']; ?></td>
											<td><?php echo $payByPassword0_lead['campaign_str']; ?></td>	
											<?php if(isset($payByPassword0_lead['call_info'])): $call_style = ($payByPassword0_lead['call_info']['answer'] == "ANSWERED")? $call_sector_style: ($payByPassword0_lead['call_info']['answer'] == "MESSEGE")? $call_sector_style_yellow: $call_sector_style_red; ?>
												<td <?php echo $call_style; ?>>
													<?php echo $payByPassword0_lead['call_info']['answer']; ?>
												</td>										
												<td <?php echo $call_style; ?>>
													<?php if($payByPassword0_lead['call_info']['billsec']!='0'): ?>
														<a target='_blank' href='https://ilbiz.co.il/site-admin/recording_handlers/download.php?filename=<?php echo $payByPassword0_lead['call_info']['recordingfile']; ?>'>
													<?php endif; ?>
													<?php echo $payByPassword0_lead['call_info']['billsec']; ?>
													<?php if($payByPassword0_lead['call_info']['billsec']!='0'): ?>
														</a>
													<?php endif; ?>													
												</td>
											<?php endif; ?>
										</tr>									
									<?php endforeach; ?>
											
								<?php endif; ?>	

<?php /* payByPassword 0 leads only untill here ----- */ ?>


								
							</table>
						</td>
					</tr>

				<?php endif; ?>
			
			<?php endforeach; ?>
			
			</table>
			
		<?php endforeach; ?>
	<?php endif; ?>
	
	<?php
	
}
