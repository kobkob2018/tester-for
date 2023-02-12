<?php

function affiliates()
{
	if(isset($_REQUEST['aff_id'])){
		return affiliate($_REQUEST['aff_id']);
	}
	$affiliates = array();
	$in_page = "100";
	$page_num = "1";
	if(isset($_REQUEST['page'])){
		$page_num = str_replace("'","",$_REQUEST['page']);
	}
	$limit_from = ($page_num-1)*$in_page;
	$limit_sql = " LIMIT $limit_from,$in_page ";
	$where_sql = "";
	$table_name = "affiliates";
	$search_params_like = array("id"=>"#","email"=>"אימייל","first_name"=>"שם פרטי","last_name"=>"שם משפחה","biz_name"=>"שם העסק","phone"=>"טלפון");
	$searched_params = array();   
	
	
	
	
	$session_search = array();
	if(isset($_SESSION['affiliate_search'])){
		$session_search = $_SESSION['affiliate_search'];
	}
	if(isset($_REQUEST['search'])){
		$session_search = $_REQUEST['search'];
		$_SESSION['affiliate_search'] = $session_search;
	}
	
	
	
	if(isset($_REQUEST['clean_search'])){
		unset($_SESSION['affiliate_search']);
		$session_search = array();
	}
	$current_url = "?main=affiliates&sesid=".SESID."";
		
	foreach($search_params_like as $search_param=>$search_param_str){
		if(isset($session_search[$search_param])){
			if($session_search[$search_param] != ""){
				$searched_param = str_replace("'","''",$session_search[$search_param]);
				$where_sql .= " AND $search_param LIKE ('%$searched_param%') ";
			}
			$searched_params[$search_param] = $session_search[$search_param];
		}
		else{
			$searched_params[$search_param] = "";
		}
	}
	$sql = "SELECT count(id) as aff_count FROM $table_name WHERE 1 $where_sql";
	
	$res = mysql_db_query(DB,$sql);
	$aff_count_data = mysql_fetch_array($res);
	$aff_count = $aff_count_data['aff_count'];
	$sql = "SELECT * FROM $table_name WHERE 1 $where_sql  $limit_sql ";
	$res = mysql_db_query(DB,$sql);
	while($affiliate = mysql_fetch_array($res)){
		$affiliates[$affiliate['id']] = $affiliate;
	}
	?>
	<div style="float:left;"><a href="?sesid=<?php echo SESID; ?>">חזרה לתפריט ראשי</a></div>
	<h3>מערכת שותפים בפיתוח</h3>
	<table border='1' cellpadding='5' style='border-collapse: collapse;'>

		<tr>
			<?php foreach($search_params_like as $param_key=>$param_str): ?>
				<th><?php echo $param_str; ?></th>
			<?php endforeach; ?>
			<th><a href="<?php echo $current_url; ?>&clean_search=1">ניקוי מאפייני חיפוש</a></th>
		</tr>
		<tr>
			<th colspan='30'>
				<a href="<?php echo $current_url; ?>&aff_id=all">לחץ כאן לסיכומי לידים של כל השותפים</a>
			</th>
		</tr>		
		<tr>
			<td colspan='40'>
				<form action='<?php echo $current_url; ?>' method="POST">
			</td>
		</tr>
		
		<tr>
			<?php foreach($search_params_like as $param_key=>$param_str): ?>
				<th><input type='text' name='search[<?php echo $param_key; ?>]' value='<?php echo $searched_params[$param_key]; ?>' /> </th>
			<?php endforeach; ?>
			<th><input type="submit" value="חיפוש" /></th>
		</tr>	
		<tr>
			<td colspan='40'>
				</form>
			</td>
		</tr>		
		<?php foreach($affiliates as $affiliate): ?>
			<tr>
			<?php foreach($search_params_like as $param_key=>$param_str): ?>
				<td>
					<?php echo $affiliate[$param_key]; ?>
				</td>
			<?php endforeach; ?>
				<td><a href='<?php echo $current_url;?>&aff_id=<?php echo $affiliate['id']; ?>'>לחץ כאן לצפייה</a></td>
			</tr>
		<?php endforeach; ?>
	</table>
	
	<div>
		<h5>  נמצאו <?php echo $aff_count; ?> שותפים </h5>
		<?php for($i=0; $i<=$aff_count/$in_page; $i++): $selected_style=($i+1 == $page_num)?"border-color:black;color:black;text-decoration:none;": "" ?>
			
				<a style='display:block; padding: 10px;margin:4px;width: 16px;height: 17px;border:1px solid blue;float:right;<?php echo $selected_style; ?>' href="<?php echo $current_url; ?>&page=<?php echo $i+1 ?>" ><?php echo $i+1 ?></a>
			
		<?php endfor; ?>
	</div>
	<?php
}

function affiliate($aff_id){
	$current_url = "?main=affiliates&sesid=".SESID;
	$current_aff_url = $current_url."&aff_id=$aff_id";
	if(isset($_REQUEST['reset_filter'])){
		if(isset($_SESSION['aff_leads_filter'])){
			unset($_SESSION['aff_leads_filter']);
		}
		echo "<script>window.location.href='".$current_aff_url."';</script>";
	}	
	if($aff_id != "all"){
		$edit_affiliate_msg = "";
		if(isset($_REQUEST['edit_affiliate'])){
			$aff_params = array();
			$aff_params_update_arr = array();
			foreach($_REQUEST['aff'] as $key=>$val){
				$aff_params[str_replace("'","",$key)] = str_replace("'","''",$val);
			}
			foreach($aff_params as $key=>$val){
				$aff_params_update_arr[] = "$key='$val'";
			}
			$aff_update_sql = implode(",",$aff_params_update_arr);
			$sql = "UPDATE affiliates SET $aff_update_sql WHERE id = $aff_id";
			$res = mysql_db_query(DB,$sql);
			$aff_kv_params =array();
			foreach($_REQUEST['aff_kv'] as $key=>$val){
				$aff_kv_params[str_replace("'","",$key)] = str_replace("'","''",$val);
			}
			$aff_kv_params_insert_arr = array();
			foreach($aff_kv_params as $key=>$val){
				$aff_kv_params_insert_arr[] = "($aff_id,'$key','$val')";
			}
			$aff_kv_params_insert = implode(",",$aff_kv_params_insert_arr);
			$sql = "INSERT INTO affiliates_kv(aff_id,param_key,param_val) VALUES $aff_kv_params_insert  ON DUPLICATE KEY UPDATE param_val=VALUES(param_val)";
			$res = mysql_db_query(DB,$sql);
			$edit_affiliate_msg = "הנתונים נשמרו בהצלחה";
		}
		
		$affiliate = false;
		$sql = "SELECT * FROM affiliates WHERE id = $aff_id"; 
		$res = mysql_db_query(DB,$sql);
		$affiliate_data = mysql_fetch_array($res);
		if(isset($affiliate_data['id'])){
			$affiliate = $affiliate_data;
			$sql = "SELECT * FROM affiliates_kv WHERE aff_id = $aff_id"; 
			$res = mysql_db_query(DB,$sql);
			while($affiliate_kv = mysql_fetch_array($res)){
				$affiliate[$affiliate_kv['param_key']] = $affiliate_kv['param_val'];
			}
		}
		$active_options = array('0'=>array('str'=>'לא','selected'=>''),'1'=>array('str'=>'כן','selected'=>''));
		$active_options[$affiliate['active']]['selected'] = 'selected';
		$pay_type_options = array('fixed'=>array('str'=>'קבוע','selected'=>''),'precent'=>array('str'=>'אחוזים','selected'=>''));
		if(isset($affiliate['lead_pay_type'])){
			if(isset($pay_type_options[$affiliate['lead_pay_type']])){
				$pay_type_options[$affiliate['lead_pay_type']]['selected'] = 'selected';
			}
		}
		$edit_params = array("email"=>"אימייל","first_name"=>"שם פרטי","last_name"=>"שם משפחה","biz_name"=>"שם העסק","phone"=>"טלפון");
	}

	$date = new DateTime();
	$month_first_day = $date->format('01-m-Y');
	$today = $date->format('d-m-Y');
	$filter = array(
		"date_from"=>$month_first_day,
		"date_to"=>$today,
		"date_from_str"=>"",
		"date_to_str"=>"",
		"phone"=>"",
		"name"=>"",
		"email"=>"",
	);
	if(isset($_REQUEST['leads_filter'])){
		$_SESSION['aff_leads_filter'] = $_REQUEST['leads_filter'];
		$filter = $_REQUEST['leads_filter'];
	}
	elseif(isset($_SESSION['aff_leads_filter'])){
		$filter = $_SESSION['aff_leads_filter'];
	}
	$leads_data = get_affiliate_leads($filter,$aff_id);
	$leads = $leads_data['list'];
	$leads_totals =$leads_data['totals_list'];
	$page_num =  $leads_data['page_num'];
	$in_page = $leads_data['in_page'];
	$lead_count = $leads_data['lead_count'];
	$affiliates_list = $leads_data['affiliates'];
	if(isset($_REQUEST['edit_affiliate_cats'])){
		$insert_vals_arr = array();
		foreach($_REQUEST['select_cat'] as $cat_id=>$checked){
			$insert_vals_arr[] = "(".$affiliate['id'].",$cat_id)";
		}
		$insert_vals = implode(",",$insert_vals_arr);
		$insert_sql = "INSERT INTO affiliate_cat(affiliate_id,cat_id) VALUES".$insert_vals;
		$clean_sql = "DELETE FROM affiliate_cat WHERE affiliate_id = ".$affiliate['id']."";
		mysql_db_query(DB,$clean_sql);
		mysql_db_query(DB,$insert_sql);
		$edit_affiliate_msg .= "הקטגוריות נשמרו לשותף";
	}	
	?>
	<div style="float:left;"><a href="?sesid=<?php echo SESID; ?>">חזרה לתפריט ראשי</a></div>
	<h3 style="min-width:500px;"><a href="<?php echo $current_url; ?>"> מערכת שותפים</a></h3>
	<?php if($affiliate): ?>
		<h5><?php echo $affiliate['first_name']; ?> <?php echo $affiliate['last_name']; ?> <?php echo $affiliate['email']; ?></h5>
		<div style="direction: ltr;">
			<b>לינק לדוגמה:</b> 
			<a href="https://כמהעולה.co.il/מחירון-ביטוח-בריאות/?aff_id=<?php echo $affiliate['id']; ?>" target="_BLANK">https://כמהעולה.co.il/מחירון-ביטוח-בריאות/?aff_id=<?php echo $affiliate['id']; ?></a>
			<br/>
			<b>עמוד נחיתה:</b> 
			<a href="https://כמהעולה.co.il/landing.php?ld=546&aff_id=<?php echo $affiliate['id']; ?>" target="_BLANK">https://כמהעולה.co.il/landing.php?ld=546&aff_id=<?php echo $affiliate['id']; ?></a>
			<br/>			
		</div>
		<div id="affiliate_form" style="padding:10px; background:#ffffe7;border:3px outset black;">
			<h3 style="color:green;"><?php echo $edit_affiliate_msg; ?></h3>
			<form action="<?php echo $current_aff_url; ?>" method="POST">
				<input type="hidden" name="edit_affiliate" value="1" />
				<table border='1' cellpadding='5' style='border-collapse: collapse;'>
					<tr>
						<?php foreach($edit_params as $key=>$str): ?>
							<th><?php echo $str; ?></th>
						<?php endforeach; ?>		
					</tr>
					<tr>
						<?php foreach($edit_params as $key=>$str): ?>
							<td><input type="text" name="aff[<?php echo $key; ?>]" value="<?php echo $affiliate[$key]; ?>" /></td>
						<?php endforeach; ?>		
					</tr>
								
				</table>
				<table border='1' cellpadding='5' style='border-collapse: collapse; margin:10px auto;'>
					<tr>
						<th>פעיל</th>
						<th>סוג תשלום</th>
						<th>סכום לתשלום</th>
					</tr>
					<tr>
						<td>
							<select name="aff[active]">
								<?php foreach($active_options as $key=>$option): ?>
									<option value="<?php echo $key; ?>" <?php echo $option['selected']; ?>><?php echo $option['str']; ?></option>
								<?php endforeach; ?>
							</select>
						</td>
						<td>
							<select name="aff_kv[lead_pay_type]">
								<?php foreach($pay_type_options as $key=>$option): ?>
									<option value="<?php echo $key; ?>" <?php echo $option['selected']; ?>><?php echo $option['str']; ?></option>
								<?php endforeach; ?>
							</select>
						</td>	
						<td>
							<input type="text" name="aff_kv[lead_pay]" value="<?php echo $affiliate['lead_pay']; ?>" />
						</td>				
					</tr>						
				</table>	
				<input type="submit" value="שמור שותף" style="width:100%; height:30px;" />
			</form>
		</div>
		<a id="affiliate_form_door" href="javascript://" onclick="door_affiliate_form(this);" class="open"><span class="closed_door">הצג טופס</span><span class="opened_door">סגור טופס</span></a>
		<div id="affiliate_cats_wrap">
			<h3>שיוך קטגוריות לשותף</h3>
			<div id="affiliate_cats" style="display:none;padding:10px; background:#ffffe7;border:3px outset black;">
				
				<form action="<?php echo $current_aff_url; ?>" method="POST">
					<input type="hidden" name="edit_affiliate_cats" value="1" />
	<?php	

	$checked_cats = array();
	
	$sql = "select cat_name,id from biz_categories where father = 0 and status = 1";
	$res_father = mysql_db_query(DB,$sql);
	$cat_list = "<script src='options.fiels/htmldb_html_elements.js' type='text/javascript'></script>";
	$cat_list .= "<table border=\"0\" cellpadding=\"0\" cellspacing=\"0\" width=\"100%\">";
		$cat_list .= "<tr>";
			$cat_list .= "<td style=\"background-color:#cccccc;\">";
			
				$cat_list .= "<ul style=\"list-style:none\" class=\"dhtmlTree\">";
					while( $data_father = mysql_fetch_array($res_father) )
					{
						
						$sql = "select cat_id from affiliate_cat where affiliate_id = '".$affiliate['id']."' and cat_id = '".$data_father['id']."'";
						$res_cat_id = mysql_db_query(DB,$sql);
						$data_cat_id = mysql_fetch_array($res_cat_id);
						
						if( $data_cat_id['cat_id'] == $data_father['id'] )	{
							$selected1 = "checked";
							$checked_cats[] = array('cat_id'=>$data_father['id'],'spaces'=>"",'cat_name'=>$data_father['cat_name']);
						}	else	{
							$selected1 = "";
						}
						
						$cat_list .= "<li><img src=\"options.fiels/plus.jpg\" onclick=\"htmldb_ToggleWithImage(this,'treeCAT".$data_father['id']."')\" class=\"pseudoButtonInactive\" />
						".stripslashes($data_father['cat_name'])."
						<input type=\"checkbox\" name=\"select_cat[".$data_father['id']."]\" value=\"1\" ".$selected1.">
						</li>";
						
						$sql = "select cat_name,id from biz_categories where father = ".$data_father['id']." and status = 1";
						$res_father_cat = mysql_db_query(DB,$sql);
						
						$cat_list .= "<ul id=\"treeCAT".$data_father['id']."\" htmldb:listlevel=\"2\" style=\"padding-right:15px;list-style:none;display:none;\" class=\"dhtmlTree\">";
							while( $data_father_cat = mysql_fetch_array($res_father_cat) )
							{
								$sql = "select cat_id from affiliate_cat where affiliate_id = '".$affiliate['id']."' and cat_id = '".$data_father_cat['id']."'";
								$res_cat_id = mysql_db_query(DB,$sql);
								$data_cat_id = mysql_fetch_array($res_cat_id);
								
								if( $data_cat_id['cat_id'] == $data_father_cat['id'] )	{
									$selected2 = "checked";
									$checked_cats[] = array('cat_id'=>$data_father_cat['id'],'spaces'=>"&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;",'cat_name'=>$data_father_cat['cat_name']);
								}	else	{
									$selected2 = "";
								}
						
								$sql = "select cat_name,id from biz_categories where father = '".$data_father_cat['id']."' and status = '1'";
								$res_father_tat_cat = mysql_db_query(DB,$sql);
								$num_father_tat_cat = mysql_num_rows($res_father_tat_cat);
								
								if( $num_father_tat_cat > 0 )
								{
									$cat_list .= "<li>
									<img src=\"options.fiels/plus.jpg\" onclick=\"htmldb_ToggleWithImage(this,'treeF_CAT".$data_father_cat['id']."')\" class=\"pseudoButtonInactive\" />
									".$data_father_cat['cat_name']."
									<input type=\"checkbox\" name=\"select_cat[".$data_father_cat['id']."]\" value=\"1\" ".$selected2."></li>";
									
									$cat_list .= "<ul id=\"treeF_CAT".$data_father_cat['id']."\" htmldb:listlevel=\"3\" style=\"padding-right:15px;list-style:none;display:none;\" class=\"dhtmlTree\">";
									
									while( $data_father_tat_cat = mysql_fetch_array($res_father_tat_cat) )
									{
										$sql = "select cat_id from affiliate_cat where affiliate_id = '".$affiliate['id']."' and cat_id = '".$data_father_tat_cat['id']."'";
										$res_cat_id = mysql_db_query(DB,$sql);
										$data_cat_id = mysql_fetch_array($res_cat_id);
										
										if( $data_cat_id['cat_id'] == $data_father_tat_cat['id'] )	{
											$selected3 = "checked";
											$checked_cats[] = array('cat_id'=>$data_father_tat_cat['id'],'spaces'=>"&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;",'cat_name'=>$data_father_tat_cat['cat_name']);
										}	else	{
											$selected3 = "";
										}
										
										$cat_list .= "<li><img src=\"options.fiels/node.jpg\" /><input type=\"checkbox\" name=\"select_cat[".$data_father_tat_cat['id']."]\" value=\"1\" ".$selected3.">".$data_father_tat_cat['cat_name']."</li>";
									}
									$cat_list .= "</ul>";
								}
								else
								{
									$cat_list .= "<li><img src=\"options.fiels/node.jpg\" />
									<input type=\"checkbox\" name=\"select_cat[".$data_father_cat['id']."]\" value=\"1\" ".$selected2.">".$data_father_cat['cat_name']."</li>";
								}
							}
						$cat_list .= "</ul>";
					}
				$cat_list .= "</ul>";
			$cat_list .= "</td>";
		$cat_list .= "</tr>";
	$cat_list .= "</table>";
	echo $cat_list;
	?>
					<input type="submit" value="שמור קטגוריות" style="width:100%; height:30px;" />
				</form>
			</div>
			<a id="affiliate_cats_door" href="javascript://" onclick="door_affiliate_cats(this);" class="closed"><span class="closed_door">הצג קטגוריות</span><span class="opened_door">סגור קטגוריות</span></a>
		</div>			
		<style type="text/css">
			#affiliate_form_door.open .closed_door{display:none;}
			#affiliate_form_door.closed .opened_door{display:none;}
			#affiliate_cats_door.open .closed_door{display:none;}
			#affiliate_cats_door.closed .opened_door{display:none;}			
		</style>
		<script type="text/javascript">
			function door_affiliate_form(el_id){
				jQuery(function($){
					if($(el_id).hasClass("open")){
						$(el_id).removeClass("open").addClass("closed");
						$("#affiliate_form").hide();
					}
					else{
						$(el_id).removeClass("closed").addClass("open");
						$("#affiliate_form").show();
					}
				});
			}
			function door_affiliate_cats(el_id){
				jQuery(function($){
					if($(el_id).hasClass("open")){
						$(el_id).removeClass("open").addClass("closed");
						$("#affiliate_cats").hide();
					}
					else{
						$(el_id).removeClass("closed").addClass("open");
						$("#affiliate_cats").show();
					}
				});
			}
		</script>
		<h3>הלידים של <?php echo $affiliate['first_name']; ?> <?php echo $affiliate['last_name']; ?></h3>
	<?php endif; ?>
	

<hr/>
<div class="filter-form-wrap">
	<div class="beck-link">
		<a href="<?php echo $current_aff_url; ?>&reset_filter=1">איפוס הגדרות סינון</a>
	</div>
	<h4>סינון לידים</h4>
	<div id="responsive-tables">
		<form class="filter-form table-form" action="" method="POST">
			<table border='1' cellpadding='5' style='border-collapse: collapse;' class="col-md-12 table-bordered table-striped table-condensed cf">
				<thead class="cf">
					<tr>
						<th>מתאריך</th>
						<th>עד תאריך</th>
						<th>טלפון</th>
					</tr>
				</thead>
				<tbody>
					<tr class="form-group">
						<td data-title="מתאריך"><input type="text" name="leads_filter[date_from]" class="form-input datepicker-input" value="<?php echo $filter['date_from']; ?>" /></td>
						<td data-title="עד תאריך"><input type="text" name="leads_filter[date_to]" class="form-input datepicker-input" value="<?php echo $filter['date_to']; ?>" /></td>
						<td data-title="טלפון"><input type="text" name="leads_filter[phone]" class="form-input" value="<?php echo $filter['phone']; ?>" /></td>
					</tr>
				</tbody>
				<thead class="cf">
					<tr>
						<th>שם</th>
						<th>אימייל</th>
						<th>שליחה</th>
					</tr>
				</thead>
				<tbody>					
					<tr class="form-group">
						<td data-title="שם"><input type="text" name="leads_filter[name]" class="form-input" value="<?php echo $filter['name']; ?>" /></td>
						<td data-title="אימייל"><input type="text" name="leads_filter[email]" class="form-input" value="<?php echo $filter['email']; ?>" /></td>
						<td data-title=""><input style="width:100%;" type="submit" value="סינון" /></td>
					</tr>				
				</tbody>
			</table>
		</form>
	</div>
</div>

<?php if($_GET['aff_id'] == 'all'): ?>
	<div class="aff_totals-list">
		<h4>סיכום לידים לשותף</h4>
		<div id="responsive-tables">
			<table  border='1' cellpadding='5' style='border-collapse: collapse;' class="col-md-12 table-bordered table-striped table-condensed cf">
				<tbody>
				
					<?php $i=0; foreach($leads_data['affiliate_totals'] as $aff_id=>$affiliate_totals): $affiliate = $affiliates_list[$aff_id]; ?>
						<?php if($i%10 == 0): $i=0; ?>
							</tbody>
							<thead class="cf">
								<tr>
									<th>שותף</th>
									<th class="numeric odd-td">שליחה ללקוחות</th>
									<th class="numeric">פתוח</th>
									<th class="numeric odd-td">סגור</th>
									<th class="numeric">חוייבו</th>
									<th class="numeric">הכנסה מלקוחות</th>
									<th class="numeric odd-td">כפולים</th>
									<th class="numeric">הוחזרו</th>
									<th>סגירה עם לקוח</th>
									<th class="numeric odd-td">סה"כ לתשלום</th>
								</tr>
							</thead>
							<tbody>	
				
						<?php endif; $i++; ?>
						<tr>
							<td class="" data-title="שותף">
								<a target="_NEW" href="<?php echo $current_url;?>&aff_id=<?php echo $aff_id; ?>">
									<?php echo $affiliate['first_name']; ?> <?php echo $affiliate['last_name']; ?>
								</a>
							</td>
							<td class="odd-td" data-title="שליחה ללקוחות"><?php echo $affiliate_totals['total_send']; ?></td>
							<td class="" data-title="פתוח"><?php echo $affiliate_totals['payByPassword_1']; ?></td>
							<td class="odd-td" data-title="סגור" class="numeric"><?php echo $affiliate_totals['payByPassword_0']; ?></td>
							<td class="" data-title="חוייבו" class="numeric"><?php echo $affiliate_totals['billed']; ?></td>
							<td class="" data-title="הכנסות" class="numeric"><?php echo $affiliate_totals['total_income']; ?></td>
							<td class="odd-td" data-title="כפולים %" class="numeric"><?php echo $affiliate_totals['doubled']; ?></td>
							<td class="" data-title="הוחזרו" class="numeric"><?php echo $affiliate_totals['refunded']; ?></td>
							<td class="" data-title="סגירה עם לקוח" class="numeric"><?php echo $affiliate_totals['customer_closed']; ?></td>
							<td class="odd-td" data-title="סה&quot;כ לתשלום" class="numeric"><?php echo $affiliate_totals['total_pay']; ?></td>
						</tr>	
						
					<?php endforeach; ?>
				</tbody>
			</table>
			
		</div>
	</div>	
<?php endif; ?>








<div class="leads-list">
	<h4>תוצאות חיפוש</h4>
	<div id="responsive-tables">
		<table  border='1' cellpadding='5' style='border-collapse: collapse;' class="col-md-12 table-bordered table-striped table-condensed cf">
			<tbody>
			
				<?php $i=0; foreach($leads as $lead): $sent_data=$lead['users_send_summary']; $data=$lead['estimate_form_data']; ?>
					<?php if($i%10 == 0): $i=0; ?>
						</tbody>
						<thead class="cf">
							<tr>
								<th>שם</th>
								<th>טלפון</th>
								<th>זמן שליחה</th>
								<?php if($aff_id == "all"): ?>
									<th>שותף</th>
								<?php endif; ?>
								<th class="numeric odd-td">שליחה ללקוחות</th>
								<th class="numeric">פתוח</th>
								<th class="numeric odd-td">סגור</th>
								<th class="numeric">חוייבו</th>
								<th class="numeric">הכנסה מלקוחות</th>
								<th class="numeric odd-td">כפולים</th>
								<th class="numeric">הוחזרו</th>
								<th class="numeric">סגירה עם לקוח</th>
								<th class="numeric odd-td">סה"כ לתשלום</th>
								<th>צפייה בליד</th>
							</tr>
						</thead>
						<tbody>	



        			<tr style="color:red;">
						<td class="" data-title="<?php echo $data['phone']; ?>"  class="responsive-hide">סה"כ <?php echo $lead_count; ?> לידים</td>
						<td class="" data-title="<?php echo ($data['name']); ?>" class=""></td>
						<td class="" data-title="" style="direction:ltr;" class="responsive-full-row"></td>
						<?php if($aff_id == "all"): $affiliate = $affiliates_list[$lead['aff_id']]; ?>
							<td class="" data-title="שותף">
							</td>
						<?php endif; ?>
						<td class="odd-td" data-title="שליחה ללקוחות"><?php echo $leads_totals['total_send']; ?></td>
        				<td class="" data-title="פתוח"><?php echo $leads_totals['payByPassword_1']; ?></td>
        				<td class="odd-td" data-title="סגור" class="numeric"><?php echo $leads_totals['payByPassword_0']; ?></td>
        				<td class="" data-title="חוייבו" class="numeric"><?php echo $leads_totals['billed']; ?></td>
						<td class="" data-title="הכנסות" class="numeric"><?php echo $leads_totals['total_income']; ?></td>
        				<td class="odd-td" data-title="כפולים %" class="numeric"><?php echo $leads_totals['doubled']; ?></td>
        				<td class="" data-title="הוחזרו" class="numeric"><?php echo $leads_totals['refunded']; ?></td>
						<td class="" data-title="הוחזרו" class="numeric"><?php echo $leads_totals['customer_closed']; ?></td>
        				<td class="odd-td" data-title="סה&quot;כ לתשלום" class="numeric"><?php echo $leads_totals['total_pay']; ?></td>
						<td class="" data-title="צפייה בליד" class="numeric"></td>
        			</tr>



			
					<?php endif; $i++; ?>
        			<tr>
						<td class="" data-title="<?php echo $data['phone']; ?>"  class="responsive-hide"><?php echo ($data['name']); ?></td>
						<td class="" data-title="<?php echo ($data['name']); ?>" class=""><?php echo $data['phone']; ?></td>
						<td class="" data-title="" style="direction:ltr;" class="responsive-full-row"><?php echo hebdt($data['insert_date']); ?></td>
						<?php if($aff_id == "all"): $affiliate = $affiliates_list[$lead['aff_id']]; ?>
							<td class="" data-title="שותף">
								<a target="_NEW" href="<?php echo $current_url;?>&aff_id=<?php echo $lead['aff_id']; ?>">
									<?php echo $affiliate['first_name']; ?> <?php echo $affiliate['last_name']; ?>
								</a>
							</td>
						<?php endif; ?>
						<td class="odd-td" data-title="שליחה ללקוחות"><?php echo $sent_data['total_send']; ?></td>
        				<td class="" data-title="פתוח"><?php echo $sent_data['payByPassword_1']; ?></td>
        				<td class="odd-td" data-title="סגור" class="numeric"><?php echo $sent_data['payByPassword_0']; ?></td>
        				<td class="" data-title="חוייבו" class="numeric"><?php echo $sent_data['billed']; ?></td>
						<td class="" data-title="הכנסות" class="numeric"><?php echo $sent_data['total_income']; ?></td>
        				<td class="odd-td" data-title="כפולים %" class="numeric"><?php echo $sent_data['doubled']; ?></td>
        				<td class="" data-title="הוחזרו" class="numeric"><?php echo $sent_data['refunded']; ?></td>
						<td class="" data-title="הוחזרו" class="numeric"><?php echo $sent_data['customer_closed']; ?></td>
        				<td class="odd-td" data-title="סה&quot;כ לתשלום" class="numeric"><?php echo $sent_data['total_pay']; ?></td>
						<td class="" data-title="צפייה בליד" class="numeric"><a target="_NEW" href='?main=send_estimate_form_users_list&estimate_id=<?php echo $lead['id']; ?>&s_ref=&s_date=&e_date=&limitcount=0&sesid=<?php echo SESID; ?>'>לחץ לצפייה</a></td>
        			</tr>	
					
				<?php endforeach; ?>
			</tbody>
		</table>
		
	</div>
</div>	
<div>
	<h5>  נמצאו <?php echo $lead_count; ?> לידים </h5>
	<?php for($i=0; $i<=$lead_count/$in_page; $i++): $selected_style=($i+1 == $page_num)?"border-color:black;color:black;text-decoration:none;": "" ?>
		
			<a style='display:block; padding: 10px;margin:4px;width: 16px;height: 17px;border:1px solid blue;float:right;<?php echo $selected_style; ?>' href="<?php echo $current_aff_url; ?>&page=<?php echo $i+1 ?>" ><?php echo $i+1 ?></a>
		
	<?php endfor; ?>
</div>
<style type="text/css">
	.table-striped .odd-td{background:#dbdbff;}
</style>
	
	<?php
}

function get_affiliate_leads($filter,$aff_id){
	$aff_campaign_id = 1000+$aff_id;
	$aff_campaign_where = "campaign_type = $aff_campaign_id";
	if($aff_id == "all"){
		$aff_campaign_where = "campaign_type > 999";
	}
	$in_page = "50";
	$page_num = "1";
	if(isset($_REQUEST['page'])){
		$page_num = str_replace("'","",$_REQUEST['page']);
	}
	$limit_from = ($page_num-1)*$in_page;
	//$limit_sql = " LIMIT $limit_from,$in_page ";	
	
	$limit_sql = ""; //cancel limit in pagination bcose need to sum total pay for all leads 
	
	$filter_sql = "";
	if($filter['date_from'] != ""){
		$filter_date_from_obj =  new DateTime($filter['date_from']);
		$filter_date_from = $filter_date_from_obj->format('Y-m-d');
		$filter_sql .= " AND insert_date >= '$filter_date_from' ";
	}
	if($filter['date_to'] != ""){
		$filter_date_to_obj =  new DateTime($filter['date_to']." +1 day");
		$filter_date_to = $filter_date_to_obj->format('Y-m-d');
		$filter_sql .= " AND insert_date <= '$filter_date_to' ";
	}
	if($filter['phone'] != ""){
		$filter_sql .= " AND phone LIKE ('%".$filter['phone']."%') ";
	}	
	if($filter['name'] != ""){
		$filter_sql .= " AND name LIKE ('%".$filter['name']."%') ";
	}	
	if($filter['email'] != ""){
		$filter_sql .= " AND email LIKE ('%".$filter['email']."%') ";
	}			
	$list = array();

	$sql = "SELECT count(id) as lead_count FROM estimate_form WHERE $aff_campaign_where $filter_sql";
	$res = mysql_db_query(DB,$sql);
	// we create a list of Post objects from the database results
	$lead_count_data = mysql_fetch_array($res);
	$lead_count = $lead_count_data['lead_count'];
	
	$sql = "SELECT * FROM estimate_form WHERE $aff_campaign_where $filter_sql $limit_sql ORDER BY id desc";
	$res = mysql_db_query(DB,$sql);
	// we create a list of Post objects from the database results
	$aff_ids = array();
	$affiliates = array();
	$affiliate_totals = array();
	$i = 0;
	$users_send_totals = array();
	while($lead = mysql_fetch_array($res)){
		$i++;
		$lead_data =  get_affiliate_lead_data($lead);
		$aff_id = $lead['campaign_type']-1000;
		$affiliate_data = get_affiliate_data($aff_id);
		if(!isset($affiliates[$aff_id])){
			$affiliates[$aff_id] = $affiliate_data;
		}
		if(!isset($affiliate_totals[$aff_id])){
			$affiliate_totals[$aff_id] = array();
		}		
		$lead_data['aff_id'] =  $aff_id;
		if($i>$limit_from && $i<=($limit_from+$in_page)){
			$list[] = $lead_data;
		}
		$users_send_summary = $lead_data['users_send_summary'];
		foreach($users_send_summary as $key=>$val){
			if(!isset($users_send_totals[$key])){
				$users_send_totals[$key] = 0;
			}
			$users_send_totals[$key] += $val;
			if(!isset($affiliate_totals[$aff_id][$key])){
				$affiliate_totals[$aff_id][$key] = 0;
			}
			$affiliate_totals[$aff_id][$key] += $val;						
		}
	}

	
	foreach($aff_ids as $aff_id){
		$affiliates[$aff_id] = get_affiliate_data($aff_id);
	}

	return array("list"=>$list,"page_num"=>$page_num,"in_page"=>$in_page,"lead_count"=>$lead_count,"totals_list"=>$users_send_totals,"affiliates"=>$affiliates,'affiliate_totals'=>$affiliate_totals);
}

function get_affiliate_lead_data($lead) {
	$data = array();
	$data['users_send_list'] = array();
	$data['users_send_summary'] = array(
		'total_send'=>0,
		'payByPassword_0'=>0,
		'payByPassword_1'=>0,
		'billed'=>0,
		'doubled'=>0,
		'refunded'=>0,
		'total_income'=>0,
		'customer_closed'=>0,
		'total_pay'=>0,
	);
	$data['estimate_form_data'] = $lead;
	$data['id'] = $lead['id'];
	$lead_id = $data['id'];
	$aff_id = $lead['campaign_type']-1000;
	$affiliate_data = get_affiliate_data($aff_id);
	$sql = "SELECT * FROM user_contact_forms WHERE estimateFormID = $lead_id ";
	$res = mysql_db_query(DB,$sql);
	while($user_send_lead = mysql_fetch_array($res)){
		$unk_data = affiliate_get_unk_data($user_send_lead['unk']);
		$lead_bill_amount = $unk_data['leadPrice'];
		$pay_amount = 0;
		if($affiliate_data['lead_pay_type'] == "fixed"){
			$pay_amount += $affiliate_data['lead_pay'];
		}
		elseif($affiliate_data['lead_pay_type'] == "precent"){
			$precent_pay = $affiliate_data['lead_pay'];
			$pay_amount = $lead_bill_amount*$precent_pay/100;			
		}
		$user_send_lead['billed_amount'] = 0;
		$user_send_lead['pay_amount'] = 0;
		
		$data['users_send_summary']['total_send']++;
		if($user_send_lead['status'] == '2'){
			$data['users_send_summary']['customer_closed']++;
		}		
		if($user_send_lead['payByPassword'] == '1'){
			$data['users_send_summary']['payByPassword_1']++;
			if($user_send_lead['lead_billed'] == '1'){
				$data['users_send_summary']['billed']++;
				
				$bill_amount = $unk_data['leadPrice'];
				if($user_send_lead['status'] == '6'){
					$data['users_send_summary']['refunded']++;
				}
				else{
					$data['users_send_summary']['total_pay'] += $pay_amount;
					$data['users_send_summary']['total_income'] += $lead_bill_amount;
					
					$user_send_lead['billed_amount'] = $unk_data['leadPrice'];
					$user_send_lead['pay_amount'] = $pay_amount;
				}
			}
			else{
				$data['users_send_summary']['doubled']++;
			}
		}
		else{
			$data['users_send_summary']['payByPassword_0']++;
		}
		$data['users_send_list'][] = $user_send_lead;
		$data['users_send_summary']['total_send']++;			
	}
	return $data;
}

$affiliates_unk_arr = array();
function affiliate_get_unk_data($unk){
	if(isset($affiliates_unk_arr[$unk])){
		return $affiliates_unk_arr[$unk];
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
	$affiliates_unk_arr[$unk] = $unk_data;
	return $affiliates_unk_arr[$unk];
}

$affiliates_arr = array();
function get_affiliate_data($aff_id){
	global $affiliates_arr;
	if(isset($affiliates_arr[$aff_id])){
		return $affiliates_arr[$aff_id];
	}
	$sql = "SELECT * FROM affiliates WHERE id = $aff_id";
	$res = mysql_db_query(DB,$sql);
	$aff_data = mysql_fetch_array($res);
	$sql = "SELECT * FROM affiliates_kv WHERE aff_id = $aff_id";
	$res = mysql_db_query(DB,$sql);
	while($aff_kv_result = mysql_fetch_array($res)){
		$aff_data[$aff_kv_result['param_key']] = $aff_kv_result['param_val'];
	}
	$affiliates_arr[$aff_if] = $aff_data;
	return $affiliates_arr[$aff_if];
}

