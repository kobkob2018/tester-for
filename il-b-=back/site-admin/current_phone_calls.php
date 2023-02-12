<?
function current_phone_calls($blank = true){

	$params = array("blank"=>$blank);
	
	print_popup_html($params);

}

function get_current_phone_calls_ajax(){
	//for main admin phone list
	$phone_list = array();
	$unk_list_sql = "SELECT unk 
	FROM user_lead_settings
	WHERE show_in_misscalls_table = 1";
	$sql = "SELECT * FROM sites_leads_stat_sent WHERE unk IN(".$unk_list_sql.")";
	
	
	$res = mysql_db_query(DB, $sql);	
	while($phone_data = mysql_fetch_array($res)){
		$phone_data['custom_cat'] = '0';
		$uniq_phone_sql = "SELECT * FROM cat_uniq_phone WHERE phone LIKE (\"%".$phone_data['did']."%\")";
		$uniq_phone_res = mysql_db_query(DB,$uniq_phone_sql);
		$uniq_phone_data = mysql_fetch_array($uniq_phone_res);
		if(isset($uniq_phone_data['cat_id'])){
			$phone_data['custom_cat'] = $uniq_phone_data['cat_id'];
		}
		$call_date = $phone_data['call_date'];
		$call_date_arr = explode(" ",$call_date);
		$call_hour_arr = explode(":",$call_date_arr[1]);
		$phone_data['call_hour'] = $call_hour_arr[0].":".$call_hour_arr[1];
		$phone_list[] = $phone_data;
	}
	?>

	<table id="current_phone_calls_return">
		<?php foreach($phone_list as $phone_data): ?>
			<tr  class="phone_list_row" rel="phone" data_id="<?php echo $phone_data['id']; ?>" >
				<td class="current_call_td_unk hide"><?php echo $phone_data['unk']; ?></td>
				<td class="current_call_td_from"><a target="new" href="https://phone.ilbiz.co.il/?aff_id=18&custom_phone=<?php echo $phone_data['call_from']; ?>&custom_cat=<?php echo $phone_data['custom_cat']; ?>&link_uniq=<?php echo $phone_data['id']; ?>"><?php echo $phone_data['call_from']; ?></a></td>
				<td class="current_call_td_to"><?php echo $phone_data['call_to']; ?></td>
				<td class="current_call_td_did hide"><?php echo $phone_data['did']; ?></td>
				<td class="current_call_td_date hide"><?php echo $phone_data['call_date']; ?></td>
				<td class="current_call_th_hour"><?php echo $phone_data['call_hour']; ?></td>
				<td class="current_call_td_link_sys_id hide"><?php echo $phone_data['link_sys_id']; ?></td>
			</tr>
		<?php endforeach; ?>
		<tr class="phone_list_row" rel="done">

		</tr>
	</table>
	<?php
}	

function print_popup_html($params){
	?>
	<style type="text/css">
		#current_calls_interface{
			display: block;
			position: fixed;
			left: 5px;
			bottom: 6px;
			padding: 5px;
			background: pink;
			border: 2px solid gray;
		}
		#current_call_list_table tr td{}
		#current_call_list_table tr td.hide{
			display:none;
		}
		#calls_monitor_content{display:none;}
		#current_call_list_table tr td{
			min-width: 80px;
			height: 22px;
			text-align: right;
			padding: 9px;
			background: #c3f4c0;
		}
		#calls_monitor_content{background: black;}
		
	</style>
	<div id="current_calls_interface">
		<div id="calls_monitor_content">
			<div id="current_calls_ajax_helper" style="display:block;">
				<form action="javascript://" name="current_calls_ajax_helper_form">
					<input type="hidden" id="current_calls_ajax_helper_is_on" value="0" />
				</form>
				<div id="current_calls_ajax_helper_list_placeholder" style = "background:red;">
					
				</div>
			</div>
			<div id="popup_call">
			
			</div>
			<div id="current_call_list">
				<table id="current_call_list_table">
					<tr  class="phone_list_row_header" rel="phone" data_id="<?php echo $phone_data['id']; ?>" >
						<td class="current_call_th_unk hide">unk</td>
						<td class="current_call_th_from">הגיע ממספר</td>
						<td class="current_call_th_to">מספר יעד</td>
						<td class="current_call_th_did hide">מספר חוייג</td>
						<td class="current_call_th_date hide">זמן שיחה</td>
						<td class="current_call_th_hour">זמן</td>
						<td class="current_call_th_link_sys_id hide">מזהה</td>
					</tr>
				</table>
			</div>
		</div>
		<a href="javascript://" id="calls_monitor_key" onclick="start_current_calls_info(this);" data_state="0" data_hovered="0" data_init="0">הפעל מוניטור שיחות</a>
		

	</div>
		<script type="text/javascript">
			
			setInterval(function(){
				get_current_calls_info();
			},20000);
			/*
			setInterval(function(){
				start_current_calls_ui();
			},2000);
			*/
			function start_current_calls_info(){
				jQuery(function($){
					var current_calls_ajax_helper_is_on = $("#current_calls_ajax_helper_is_on").val();
					if(current_calls_ajax_helper_is_on == "0"){	
						$("#current_calls_ajax_helper_is_on").val("1");
						if($("#calls_monitor_key").attr("data_init") == "0"){	
							$("#calls_monitor_key").attr("data_init","1");
							/*
							$("#current_calls_interface").hover(function(){
								$("#calls_monitor_key").attr("data_hovered","2");
								show_calls_monitor();
							});
							*/
							show_calls_monitor();
						}
						$("#calls_monitor_key").html("כבה מוניטור שיחות");
						send_current_calls_ajax_request();	
					
					}
					if(current_calls_ajax_helper_is_on == "1"){
						/*
						$("#current_calls_interface").unbind('hover');
						*/
						$(".phone_list_row").each(function(){
							$(this).remove();
						});
						$("#current_calls_ajax_helper_is_on").val("0");
						$("#calls_monitor_key").html("הפעל מוניטור שיחות");
						$("#calls_monitor_key").attr("data_init","0");
						$("#calls_monitor_key").attr("data_hovered","0");
						$("#calls_monitor_key").attr("data_state","0");
						$("#calls_monitor_content").hide("slow");
					}	
				});
				
			}
			
			function get_current_calls_info(){
				//console.log("wirking");
				//console.log(jQuery("#current_calls_ajax_helper_is_on").val());
				jQuery(function($){
					if($("#current_calls_ajax_helper_is_on").val() == "1"){
						send_current_calls_ajax_request();
					}	
				});					
			}
			
			function send_current_calls_ajax_request(){
				jQuery(function($){
					var filter_data = "&sesid=<?php echo SESID; ?>&main=anf&gf=current_phone_calls&gfunc=get_current_phone_calls_ajax&main_admin=1";
					$.ajax({
						type: "POST",
						url: "ajax.php",
						data: filter_data
						
					}).done(function(msg){
						$("#current_calls_ajax_helper_list_placeholder").append(msg);
						var list_table_new = $("#current_calls_ajax_helper_list_placeholder").find("#current_phone_calls_return");
						var new_alerts = 0;
						$(list_table_new).find(".phone_list_row").each(function(){
							if($(this).attr("rel") == "done"){
								$("#current_calls_ajax_helper_list_placeholder").html("");
							}
							else{
								if($(this).attr("rel") == "phone"){
									var uniqid = $(this).attr("data_id");
									var row_id = "phone_list_row_"+$(this).attr("data_id");
									if($("#"+row_id).length == 0 ){
										$(this).attr("id",row_id);										
										$("#current_call_list_table").append($(this));
										new_alerts++;
									}
								}
							}
						});
						if(new_alerts>0){
							show_calls_monitor();
						}
					});	
				});
			}
			function show_calls_monitor(){
				jQuery(function($){
					if($("#calls_monitor_key").attr("data_state") == "0"){
						$("#calls_monitor_content").show("slow");
						$("#calls_monitor_key").attr("data_state","2");
					}
				});
			}
			function start_current_calls_ui(){
				jQuery(function($){
					if($("#calls_monitor_key").attr("data_hovered") == "0"){
						if($("#calls_monitor_key").attr("data_state") == "1"){
							$("#calls_monitor_key").attr("data_state","0");
							$("#calls_monitor_content").hide("slow");
						}
						if($("#calls_monitor_key").attr("data_state") == "2"){
							$("#calls_monitor_key").attr("data_state","1");
						}						
					}
					$("#calls_monitor_key").attr("data_hovered","0");
				});				
			}
			jQuery( document ).ready(function($) {
				jQuery("#current_calls_interface").appendTo(document.body);
				<?php if($params['blank']): ?>
				alert("blank");
				jQuery("<meta name='viewport' content='width=device-width, initial-scale=1, maximum-scale=1'>").appendTo(document.head);
				
				jQuery("#main_admin_table_1000_px").hide();
				<?php endif; ?>
				
			});
				
			
		</script>
	<?php
}
?>