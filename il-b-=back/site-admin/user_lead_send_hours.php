<?php

function user_lead_send_hours()
{
	$edit_msg = "";
	$posted_time_groups = false;
	if(isset($_POST['update_user_time_groups'])){
		$update_result = update_user_time_groups();
		$posted_time_groups = $update_result['time_groups'];
		$edit_msg = $update_result['edit_msg'];;
	}
	$unk = $_GET['unk'];
	$user_time_groups = array();
	$user_time_groups_sql = "SELECT * FROM user_lead_send_hours WHERE unk = '$unk'";
	$user_time_groups_res = mysql_db_query(DB,$user_time_groups_sql);
	$user_time_groups_data = mysql_fetch_array($user_time_groups_res);
	$user_time_groups_display = '0';
	if($user_time_groups_data['display'] != ""){
		$user_time_groups_display = $user_time_groups_data['display'];
		$user_time_groups = json_decode($user_time_groups_data['time_groups'],true);
	}
	$time_groups_example = array(

	);
	if(is_array($user_time_groups)){
		$time_groups_example = $user_time_groups;
	}
	$json_time_groups = json_encode($time_groups_example);
	$time_groups = json_decode($json_time_groups,true);
	$selected_display = array(
		'0'=>'selected',
		'1'=>''
	);
	$display_mask_display = "block";
	if($user_time_groups_display == '1'){
		$selected_display['0'] = '';
		$selected_display['1'] = 'selected';
		$display_mask_display = "none";
	}
	$day_names = array(
		1=>"ראשון",
		2=>"שני",
		3=>"שלישי",
		4=>"רביעי",
		5=>"חמישי",
		6=>"שישי",
		7=>"שבת"		
	);
	$wday = date('w');
	$now_day = $wday+1;
	$now_hour = date('H');
	$now_minute = date('i');	
	?>
		<h3>
		מערכת שעות לשליחת לידים
	</h3>

	<h4>עכשיו יום <?php echo $day_names[$now_day]; ?> <?php echo $now_hour; ?>:<?php echo $now_minute; ?></h4>
	
	<h4 style="color:red;"><?php echo $edit_msg; ?></h4> 
	<form id="update_time_groups_form" name="update_time_groups" method="POST" action="">
		<input type="hidden" name="update_user_time_groups" value="1" />

		<div>
			שעות לשליחת לידים
			<select name="display" id="user_lead_send_select">
				<option value="0" <?php echo $selected_display['0']; ?>>תמיד</option>
				<option value="1" <?php echo $selected_display['1']; ?>>לפי מה שמוגדר כאן</option>
			</select>
		</div>
		<hr/>
		<div style="position:relative;">
			<div id="display_mask_display" style="display:<?php echo $display_mask_display; ?>;position: absolute;width: 100%;height: 100%;background: rgba(214, 201, 201, 0.84);"></div>
			<h3>קבוצות הזמן לשליחת לידים</h3>
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
			$("#user_lead_send_select").change(function(){
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

function update_user_time_groups(){
	$result = array(
		"time_groups"=>array(),
		"edit_msg"=>"",
	);
	if(isset($_POST['update_user_time_groups'])){
		$unk = $_GET['unk'];
		$update_type = "insert";
		$check_sql = "SELECT id FROM user_lead_send_hours WHERE unk = '$unk'";
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
			$update_sql = "UPDATE user_lead_send_hours set display = '$display', time_groups = '$json_timegroups' WHERE unk = '$unk'";
		}
		else{
			$update_sql = "INSERT INTO user_lead_send_hours(unk,display,time_groups) VALUES('$unk','$display','$json_timegroups')";
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
				<br/>
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