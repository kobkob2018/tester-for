<?php

function cat_phone_display_hours()
{
	$general_query_str = "";
	foreach($_GET as $key=>$val){
		if($key != "main"){
			$general_query_str.="&$key=$val";
		}
	}
	$back_to_cat_query_str = "?main=up_in_cat".$general_query_str;
	$stay_here_query_str = "?main=".$_GET['main'].$general_query_str;
	$edit_msg = "";
	$posted_time_groups = false;
	if(isset($_POST['update_cat_time_groups'])){
		$update_result = update_cat_time_groups();
		$posted_time_groups = $update_result['time_groups'];
		$edit_msg = $update_result['edit_msg'];;
	}
	$cat_id = $_GET['cat_id'];
	$cat_name_str = "ברירת מחדל";
	if($cat_id != 0){
		$cat_name_str = "";
		$cat_info_sql = "SELECT cat_name, father FROM biz_categories WHERE id = $cat_id ";
		$cat_info_res = mysql_db_query(DB,$cat_info_sql);
		$cat_info = mysql_fetch_array($cat_info_res);
		$cat_name_str .= $cat_info['cat_name'];
		if($cat_info['father'] != '0'){
			$cat_father_1_id = $cat_info['father'];
			$cat_father_1_info_sql = "SELECT cat_name, father FROM biz_categories WHERE id = $cat_father_1_id ";
			$cat_father_1_info_res = mysql_db_query(DB,$cat_father_1_info_sql);
			$cat_father_1_info = mysql_fetch_array($cat_father_1_info_res);
			$cat_name_str = $cat_father_1_info['cat_name']." > ".$cat_name_str;
			if($cat_father_1_info['father'] != '0'){
				$cat_father_2_id = $cat_father_1_info['father'];
				$cat_father_2_info_sql = "SELECT cat_name, father FROM biz_categories WHERE id = $cat_father_2_id ";
				$cat_father_2_info_res = mysql_db_query(DB,$cat_father_2_info_sql);
				$cat_father_2_info = mysql_fetch_array($cat_father_2_info_res);
				$cat_name_str = $cat_father_2_info['cat_name']." > ".$cat_name_str;
			}
		}
	}
	$cat_time_groups = array();
	$cat_time_groups_sql = "SELECT * FROM cat_phone_display_hours WHERE cat_id = $cat_id";
	$cat_time_groups_res = mysql_db_query(DB,$cat_time_groups_sql);
	$cat_time_groups_data = mysql_fetch_array($cat_time_groups_res);
	$cat_time_groups_display = '0';
	if($cat_time_groups_data['display'] != ""){
		$cat_time_groups_display = $cat_time_groups_data['display'];
		$cat_time_groups = json_decode($cat_time_groups_data['time_groups'],true);
	}
	$time_groups_example = array(

	);
	if(is_array($cat_time_groups)){
		$time_groups_example = $cat_time_groups;
	}
	$json_time_groups = json_encode($time_groups_example);
	$time_groups = json_decode($json_time_groups,true);
	$selected_display = array(
		'0'=>'selected',
		'1'=>''
	);
	$display_mask_display = "block";
	if($cat_time_groups_display == '1'){
		$selected_display['0'] = '';
		$selected_display['1'] = 'selected';
		$display_mask_display = "none";
	}
	?>
		<h3>
		מערכת שעות לקטגוריה <span style="color:blue;"><?php echo $cat_name_str; ?></span>
	</h3>
	<a href="?sesid=<?php echo SESID; ?>" >חזרה לתפריט הראשי</a>
	&nbsp;&nbsp;&nbsp;
	חזרה לעריכת קטגוריה: <a href="<?php echo $back_to_cat_query_str; ?>" ><span style="color:blue;"><?php echo $cat_name_str; ?></span></a>
	
	
	<h4 style="color:red;"><?php echo $edit_msg; ?></h4> 
	<form id="update_time_groups_form" name="update_time_groups" method="POST" action="<?php echo $stay_here_query_str; ?>">
		<input type="hidden" name="update_cat_time_groups" value="1" />

		<div>
			הצג טלפונים לקטגוריה זו לפי 
			<select name="display" id="cat_phone_display_select">
				<option value="0" <?php echo $selected_display['0']; ?>>ברירת המחדל</option>
				<option value="1" <?php echo $selected_display['1']; ?>>מה שמוגדר כאן</option>
			</select>
		</div>
		<hr/>
		<div style="position:relative;">
			<div id="display_mask_display" style="display:<?php echo $display_mask_display; ?>;position: absolute;width: 100%;height: 100%;background: rgba(214, 201, 201, 0.84);"></div>
			<h3>קבוצות הזמן להצגת הטלפון בעמודי הקטגוריה</h3>
			<hr/>
		
				<div id="time_groups_place_holder">
				
				<?php $group_i = 0; foreach($time_groups as $time_group): ?>
					<?php $group_i++; create_time_group($group_i,$time_group['hf'],$time_group['mf'],$time_group['ht'],$time_group['mt'],$time_group['cd']); ?>
				<?php endforeach; $group_i++; ?>
				
			</div>
			<input type="hidden" name="time_group_index" id="time_group_index" value="<?php echo $group_i; ?>" />
			<button type="button" style="float:left;font-size:18px;" onclick="add_time_group();">הוסף קבוצת זמן</button>
			<div style="clear:both;"></div>
		</div>
		<hr/>
		<div style="text-align:center; ?>"><button type="submit" style="padding:30px; font-size:25px;">לחץ כאן לשמירה</button></div>
	</form>
	<div style="display:none;" id="templates_wrap">
		<?php create_time_group("template",8,30,13,30,array(1,2,3,4,5)); ?>
	</div>

	<script type="text/javascript">
		function add_time_group(){
			jQuery(function($){
				var time_group_index = $("#time_group_index").val();
				var new_el = $("#templates_wrap").find(".time_group_template").clone();
				new_el.addClass("time_group_"+time_group_index);
				new_el.removeClass("time_group_template");
				new_el.find(".tg_timeselect").each(function(){
					$(this).attr("name",$(this).attr("data-name")+"["+time_group_index+"]");
				});
				
				new_el.find(".tg_daycheckbox").each(function(){
					$(this).attr("name","active_day["+time_group_index+"][]");
				});				
				
				new_el.appendTo("#time_groups_place_holder");
				$("#time_group_index").val(parseInt(time_group_index)+1);
			});
		}
		function remove_time_group(nidle){
			jQuery(function($){
				var el_id = $(nidle).attr("rel");
				$("#time_groups_place_holder").find("."+el_id).remove();
			});			
		}
		jQuery(function($){
			$("#cat_phone_display_select").change(function(){
				if($(this).val() == '1'){
					$("#display_mask_display").hide();
				}
				else{
					$("#display_mask_display").show();
				}
			});
		});
	</script>
	<?php
	
}

function update_cat_time_groups(){
	$result = array(
		"time_groups"=>array(),
		"edit_msg"=>"",
	);
	if(isset($_POST['update_cat_time_groups'])){
		$update_cat_id = $_GET['cat_id'];
		$update_type = "insert";
		$check_sql = "SELECT id FROM cat_phone_display_hours WHERE cat_id = $update_cat_id";
		$check_res = mysql_db_query(DB,$check_sql);
		$check_data = mysql_fetch_array($check_res);
		if($check_data['id'] != ""){
			$update_type = "update";
		}
		$time_groups = array();
		$hour_minute_params = array(
			"hf"=>"hour_from",
			"mf"=>"minute_from",
			"ht"=>"hour_to",
			"mt"=>"minute_to",
		);
		foreach($hour_minute_params as $param_key=>$param_name){
			foreach($_POST[$param_name] as $group_id=>$param_val){
				if(!isset($time_groups[$group_id])){
					$time_groups[$group_id] = array();
				}
				$time_groups[$group_id][$param_key] = $param_val;
			}
		}

		foreach($_POST['active_day'] as $group_id=>$days_vals){
			if(!isset($time_groups[$group_id])){
				$time_groups[$group_id] = array();
			}
			if(!isset($time_groups[$group_id]['cd'])){
				$time_groups[$group_id]['cd'] = array();
			}
			foreach($days_vals as $checked_day){
				$time_groups[$group_id]['cd'][] = $checked_day;
			}
		}
		$json_timegroups = json_encode($time_groups);
		$display = $_POST['display'];
		if($update_type == "update"){
			$update_sql = "UPDATE cat_phone_display_hours set display = '$display', time_groups = '$json_timegroups' WHERE cat_id = $update_cat_id";
		}
		else{
			$update_sql = "INSERT INTO cat_phone_display_hours(cat_id,display,time_groups) VALUES($update_cat_id,'$display','$json_timegroups')";
		}
		$update_res = mysql_db_query(DB,$update_sql);
		$result['time_groups'] = $time_groups;
		$result['edit_msg'] = "קבוצות הזמן נשמרו בהצלחה";
	}
	return $result;
}

function create_time_group($group_id,$hour_from,$minute_from,$hour_to,$minute_to,$checked_days){
	?>
		<div class="time_group_<?php echo $group_id; ?>">
			משעה:  
			<select name="minute_from[<?php echo $group_id; ?>]" data-name="minute_from" class="minute_from tg_timeselect">
				<?php create_time_select_options(0,59,$minute_from); ?>
			</select> :
			<select name="hour_from[<?php echo $group_id; ?>]" data-name="hour_from" class="hour_from tg_timeselect">
				<?php create_time_select_options(0,24,$hour_from); ?>
			</select>
			&nbsp;&nbsp;&nbsp;
			עד שעה:  
			<select name="minute_to[<?php echo $group_id; ?>]" data-name="minute_to" class="minute_to tg_timeselect">
				<?php create_time_select_options(0,59,$minute_to); ?>
			</select> :
			<select name="hour_to[<?php echo $group_id; ?>]" data-name="hour_to" class="hour_to tg_timeselect">
				<?php create_time_select_options(0,24,$hour_to); ?>
			</select>			
			&nbsp;&nbsp;&nbsp;
			
			<div class="active_days" style="display:inline;">
				ימי פעילות:
				<?php create_active_days_checkboxes($group_id,$checked_days); ?>
			</div>
			<button type="button" onclick="remove_time_group(this);" rel="time_group_<?php echo $group_id; ?>">הסר קבוצה</button>
			<hr/>
			
		</div>	
	<?php
}

function create_time_select_options($from_num,$to_num,$selected_val){
	for($i=$from_num;$i<=$to_num;$i++){
		$num_str  = $i;
		if($num_str < 10){
			$num_str = "0".$i;
		}
		$selected_str = "";
		if($selected_val == $i){
			$selected_str = "selected";
		}
		?>
		<option value="<?php echo $num_str; ?>" <?php echo $selected_str; ?>><?php echo $num_str; ?></option>
		<?php
	}
}

function create_active_days_checkboxes($group_id,$checked_days){
	$days_options = array(
		1=>array("checked"=>"","day_str"=>"ראשון"),
		2=>array("checked"=>"","day_str"=>"שני"),
		3=>array("checked"=>"","day_str"=>"שלישי"),
		4=>array("checked"=>"","day_str"=>"רביעי"),
		5=>array("checked"=>"","day_str"=>"חמישי"),
		6=>array("checked"=>"","day_str"=>"שישי"),
		7=>array("checked"=>"","day_str"=>"שבת"),
	);
	foreach($days_options as $key=>$day){
		if(in_array($key,$checked_days)){
			$days_options[$key]["checked"] = "checked";
		}
	}
	?>
	<?php foreach($days_options as $key=>$day): ?>
		<input class="day_option_<?php echo $key; ?> tg_daycheckbox" type="checkbox" name="active_day[<?php echo $group_id; ?>][]" value="<?php echo $key; ?>" <?php echo $day['checked']; ?>><?php echo $day['day_str']; ?>&nbsp;
	<?php endforeach; ?>
	<?php
}