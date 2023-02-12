<?php

function misscalls_leads_reports()
{
	$edit_msg = "";
	global $client_name;
	if(isset($_REQUEST['edit_misscall_comment'])){
		global $data_login_trace;
		
		$comment = str_replace("'","''",$_REQUEST['comment']);
		$lead_id = $_REQUEST['edit_misscall_comment'];
		$check_sql = "SELECT * FROM misscalls_comments WHERE lead_id = $lead_id";
		$check_res = mysql_db_query(DB,$check_sql);
		$check_data = mysql_fetch_array($check_res);
		if($check_data['lead_id'] == ""){
			$update_sql = "INSERT INTO misscalls_comments(unk,lead_id,comment,last_comment_by_user,lead_by_phone,mark_color) values('".$_REQUEST['lead_unk']."',$lead_id,'".$comment."','".$data_login_trace['user']."','".$_REQUEST['lead_by_phone']."','".$_REQUEST['mark_color']."')";
		}
		else{
			$update_sql = "UPDATE misscalls_comments SET comment = '".$comment."',last_comment_by_user = '".$data_login_trace['user']."',lead_by_phone='".$_REQUEST['lead_by_phone']."',mark_color = '".$_REQUEST['mark_color']."'  WHERE lead_id = $lead_id";
		}
		$update_res = mysql_db_query(DB,$update_sql);
		$edit_msg = "ההערה עודכנה בהצלחה";
	}
	$date_from_str = date("d-m-Y", strtotime( date( "Y-m-d", strtotime( date("Y-m-d") ) ) . "-1 day" ) );
	if(isset($_GET['date_from'])){
		$date_from_str = trim($_GET['date_from']);
	}
	$date_from_arr = explode("-",$date_from_str);
	$date_from_sql = $date_from_arr[2]."-".$date_from_arr[1]."-".$date_from_arr[0];
	$date_to_str = date("d-m-Y");
	if(isset($_GET['date_to'])){
		$date_to_str = trim($_GET['date_to']);
	}

	$date_to_arr = explode("-",$date_to_str);
	$date_to_sql_1 = $date_to_arr[2]."-".$date_to_arr[1]."-".$date_to_arr[0];
	$date_to_sql = date('Y-m-d', strtotime("+1 day", strtotime($date_to_sql_1)));
	
	$user_name_sql = "";
	if(isset($_GET['user_name']) && $_GET['user_name'] != ""){
		$user_select_sql = ' AND user.name LIKE ("%'.$_GET['user_name'].'%") ';
	}
	else{
		$user_select_sql = " AND uls.show_in_misscalls_table = '1' ";
	}
	$users_arr = array();
	$unk_in_sql = "'-1'";
	$users_sql = "SELECT user.name,user.unk as unk FROM  user_lead_settings uls LEFT JOIN users user ON user.unk = uls.unk WHERE 1 $user_select_sql";
	$users_res = mysql_db_query(DB, $users_sql);
	while($user_data = mysql_fetch_array($users_res)){
		$unk = $user_data['unk'];
		$users_arr[$unk] = $user_data;
		$unk_in_sql .= ",'$unk'"; 
	}
	$leads_sql = "SELECT * FROM user_contact_forms WHERE unk IN($unk_in_sql) AND date_in >= '$date_from_sql' AND date_in <= '$date_to_sql' AND lead_recource = 'phone'";
	
	$leads_res = mysql_db_query(DB, $leads_sql);
	$owners_list = array();
	$answerd_count = 0;
	$noanswer_count = 0;
	$doubled_answerd_count = 0;
	$doubled_noanswer_count = 0;	
	$unk_check = 0;
	while($lead_data = mysql_fetch_array($leads_res)){
		
		$unk = $lead_data['unk'];
		if(!isset($users_arr[$unk]['checked_phones'])){
			$users_arr[$unk]['checked_phones'] = array();
			
		}
		$check_phone = $lead_data['phone'];
		if(isset($users_arr[$unk]['checked_phones'][$check_phone])){
			continue;
		}
		$date_in = $lead_data['date_in'];
		$lead_date_from = date("Y-m-d", strtotime( date( "Y-m-d", strtotime( $date_in ) ) . "-3 day" ) );
		$lead_date_to = date("Y-m-d", strtotime( date( "Y-m-d", strtotime( $date_in ) ) . "+3 day" ) );
		if(!isset($users_arr[$unk]['leads'])){
			$users_arr[$unk]['leads'] = array();	
		}		
		$check_lead_sql = " SELECT unk FROM user_contact_forms WHERE phone = '$check_phone' AND date_in > '$lead_date_from' AND date_in < '$lead_date_to' AND lead_recource = 'form' LIMIT 1";

		$check_lead_res = mysql_db_query(DB, $check_lead_sql);
		$check_lead_data = mysql_fetch_array($check_lead_res);
		if($check_lead_data['unk'] != ""){
			$users_arr[$unk]['checked_phones'][$lead_data['phone']] = $lead_data['phone'];
			if(isset($users_arr[$unk]['leads'][$lead_data['phone']])){
				unset($users_arr[$unk]['leads'][$lead_data['phone']]);
			}
			continue;
		}
		$phone_sql = "SELECT * FROM sites_leads_stat WHERE id = ".$lead_data['phone_lead_id']."";
		$phone_res = mysql_db_query(DB,$phone_sql);
		$phone_data = mysql_fetch_array($phone_res);
		
		$comment_sql = "SELECT * FROM misscalls_comments WHERE lead_id = ".$lead_data['id']."";
		
		$comment_res = mysql_db_query(DB,$comment_sql);
		$comment_data = mysql_fetch_array($comment_res);
		$lead_data['comment'] = $comment_data['comment'];
		$lead_data['lead_by_phone'] = $comment_data['lead_by_phone'];
		$lead_data['mark_color'] = $comment_data['mark_color'];
		$lead_data['last_comment_by_user'] = $comment_data['last_comment_by_user'];
		if($lead_data['last_comment_by_user'] != "" && $lead_data['last_comment_by_user']!='0'){
			$owners_list[] = $lead_data['last_comment_by_user'];
		}
		$lead_data['phone_data'] = $phone_data;
		if($phone_data['answer'] == "ANSWERED"){
			$answerd_count++;
		}
		else{
			$noanswer_count++;
		}
		if($lead_data['id'] == "265730"){
			$unk_check = $unk;
		}
		$lead_data['appears'] = 1;
		$lead_data['appears_arr'] = array();
		if(isset($users_arr[$unk]['leads'][$lead_data['phone']])){
			if($phone_data['answer'] == "ANSWERED"){
				$doubled_answerd_count++;
			}
			else{
				$doubled_noanswer_count++;
			}			
			
			$appears = $users_arr[$unk]['leads'][$lead_data['phone']]['appears'];
			$appears_arr = array($users_arr[$unk]['leads'][$lead_data['phone']]);
			
			foreach($users_arr[$unk]['leads'][$lead_data['phone']]['appears_arr'] as $app_key=>$appear){
				$appears_arr[$app_key] = $appear;
			}
			$lead_data['appears'] = $appears+1;
			$lead_data['appears_arr'] = $appears_arr;

		}
		$users_arr[$unk]['leads'][$lead_data['phone']] = $lead_data;
	}

	$owners_list_in_sql = implode(",",$owners_list);
	$owners_sql = "SELECT id,client_name FROM sites_owner WHERE id IN($owners_list_in_sql)";
	$owners_res = mysql_db_query(DB,$owners_sql);
	$owners_names = array();
	while($owner_data = mysql_fetch_array($owners_res)){
		$owners_names[$owner_data['id']] = $owner_data['client_name'];
	}
	$owners_colors = array(
		'1'=>'#e7e7ff',
		'9'=>'#acffac',
		'27'=>'#f5f5a7',
	);
	$campaign_names = array(
		'0'=>'רגיל',
		'1'=>'גוגל',
		'2'=>'פייסבוק'
	);
	$campaign_colors = array(
		'0'=>'white',
		'1'=>'#ffdfdf',
		'2'=>'#c5c5ec'
	);	
	add_curent_calls_monitor();
	?>
	
	
	<h3>
		טלפונים שלא הפכו ללידים
	</h3>
	<a href="?sesid=<?php echo SESID; ?>" >חזרה לתפריט הראשי</a>
	<h4 style="color:red;"><?php echo $edit_msg; ?></h4> 
	
	<div style="padding:20px;">
		<form action="index.php" method="GET">
			<input type="hidden" name="main" value="misscalls_leads_reports" />
			<input type="hidden" name="sesid" value="<?php echo SESID; ?>" />
			מתאריך <input type="text" name="date_from" value="<?php echo $date_from_str; ?>" />&nbsp&nbsp&nbsp
			עד תאריך  <input type="text" name="date_to" value="<?php echo $date_to_str; ?>" />&nbsp&nbsp&nbsp
			שם לקוח  <input type="text" name="user_name" value="<?php echo $_GET['user_name']; ?>" />&nbsp&nbsp&nbsp
			<br/><br/>
			<input type="submit" value="הצג" />
		</form>
	</div>
	<div>
		סימוני משתמשים(הערה אחרונה על-ידי): 
		<?php 
			foreach($owners_names as $owner_id=>$owner_name){
				if(isset($owners_colors[$owner_id])){
					?>
						<span style="background:<?php echo $owners_colors[$owner_id]; ?>"><?php echo $owner_name; ?></span>
					<?php
				}
			}
		?>
	</div>
	<div>
		<br/>
		&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<b>שיחות שנענו:</b><?php echo $answerd_count; ?>&nbsp;&nbsp;&nbsp;&nbsp;<span style="background:yellow;">כפילויות לאותו מספר: <?php echo $doubled_answerd_count; ?></span>
		
		&nbsp;&nbsp;&nbsp;
		<input type="checkbox" onchange="showhideanweredorno(this,'lead_tr_answered');" checked /> הצג
		<br/>
		<b>שיחות שלא נענו:</b><?php echo $noanswer_count; ?>&nbsp;&nbsp;&nbsp;&nbsp;<span style="background:yellow;">כפילויות לאותו מספר: <?php echo $doubled_noanswer_count; ?></span>
		&nbsp;&nbsp;&nbsp;
		<input type="checkbox" onchange="showhideanweredorno(this,'lead_tr_noanswer');" checked /> הצג
		<br/>
	</div>
	<script type="text/javascript">
		function showhideanweredorno(el_id,class_id){
			jQuery(function($){
				if($(el_id).is(':checked')){
					$("."+class_id).show();
				}
				else{
					$("."+class_id).hide();
				}
			});
		}
	</script>
	<table border="1" cellpadding="10" style="border-collapse: collapse;">
		<tr>
			<th>תאריך</th>
			<th>טלפון</th>
			<th>מצב שיחה</th>
			<th>לינק להקלטה</th>
			<th>קמפיין</th>
			<th>שם קמפיין</th>
			<th>הערה</th>
		</tr>
		<?php foreach($users_arr as $unk=>$user): ?>
			
			<tr>
				<th colspan="7"><?php echo "<a target='_blank' href='?main=user_profile&unk=".$user['unk']."&record_id=".$user['user_id']."&sesid=".SESID."'>".$user['name']."</a>"; ?></th>
			</tr>

			<?php if(isset($user['leads']) && !empty($user['leads'])): ?>
				<?php foreach($user['leads'] as $lead): ?>
					<?php 

						$mark = $lead['mark_color'];
						if($mark == ""){
							if($lead['last_comment_by_user']!="" && $lead['last_comment_by_user']!="0" ){
								if(isset($owners_colors[$lead['last_comment_by_user']])){
									$mark = "style='background:".$owners_colors[$lead['last_comment_by_user']].";'";
									
								}
							}
						}
						else{
							$mark = "style='background:".$mark.";'";
						}
						$answer_class = "noanswer";
						if($lead['phone_data']['answer'] == "ANSWERED"){
							$answer_class = "answered";
						}
					?>
					<tr <?php echo $mark; ?> id="misscall_comment_tr_<?php echo $lead['id']; ?>" class="lead_tr_<?php echo $answer_class; ?>">
						<td>
						`	<?php echo $lead['date_in']; ?>
							<br/>
							זמן שיחה בשניות: 
							<?php echo $lead['phone_data']['billsec']; ?>
						</td>
						<td><?php echo $lead['phone']; ?></td>
						<td><?php echo $lead['phone_data']['answer']; ?></td>
						<td>
							<?php
								if($lead['phone_data']['recordingfile']!=""){
									echo "<a target='_blank' href='http://ilbiz.co.il/site-admin/recording_handlers/download.php?filename=".$lead['phone_data']['recordingfile']."' class='maintext'>לחץ כאן להורדת הקלטה</a><br/>"; 
								}
							?>
						</td> 
						<td style="background:<?php echo $campaign_colors[$lead['phone_campaign_type']]; ?>"><?php echo $campaign_names[$lead['phone_campaign_type']]; ?></td>
						<td style="background:<?php echo $campaign_colors[$lead['phone_campaign_type']]; ?>"><?php echo $lead['phone_campaign_name']; ?></td>
						<td>
							<form action="" method="POST" id="misscall_comment_form_<?php echo $lead['id']; ?>" >
								<input type="hidden" name="edit_misscall_comment" value="<?php echo $lead['id']; ?>" />
								<input type="hidden" name="lead_unk" value="<?php echo $lead['unk']; ?>" />
								<textarea name="comment" style="width:250px; height:35px;"><?php echo $lead['comment']; ?></textarea>
								

								<br/>
								הפך לליד עם טלפון: </br>
								<input type='text' name='lead_by_phone' value='<?php echo $lead['lead_by_phone']; ?>'/>
								<?php 
									$color_options = array("#ffd55b"=>"","#f59cff"=>"","#ffff63"=>"","#92e7f1"=>"","#00e8b4"=>"","#ff4949"=>"");
									$defult_color_selected = "checked";
									if(isset($color_options[$lead['mark_color']])){
										$color_options[$lead['mark_color']] = "checked";
										$defult_color_selected = "";
									}
								?>
								<br/>
								סימון בצבע: <br/>
								<div style="display:inline-block; padding:2px;">
									
								</div>
								<?php foreach($color_options as $color=>$selected): ?>
									<div style="display:inline-block;background:<?php echo $color; ?>; padding:2px;">
										<input type="radio" name="mark_color" value="<?php echo $color; ?>" <?php echo $selected; ?> />
									</div>
										
								<?php endforeach; ?>
								<br/>
								<input type="radio" name="mark_color" value="" />לפי המשתמש
								<input type="radio" name="mark_color" value="none"  <?php echo $defult_color_selected; ?> />ללא צבע
								
								<br/><br/>
								<button type="button" style="width:250px;"  onclick="quickedit_misscall_comment(<?php echo $lead['id']; ?>);">שמור</button>
								<br/>
								הערה אחרונה: 
								<span class='last_comment_by_name'>
									<?php if($lead['last_comment_by_user']!="" && $lead['last_comment_by_user']!="0" ): ?>
										<?php echo $owners_names[$lead['last_comment_by_user']]; ?>
										<br/>
									<?php endif; ?>	
								</span>									
							</form>
						</td>
					</tr>
					<?php if(!empty($lead['appears_arr'])): ?>
						<?php foreach($lead['appears_arr'] as $appear): ?>
							<tr style="background:yellow;" id="misscall_comment_tr_<?php echo $appear['id']; ?>"  class="lead_tr_<?php echo $answer_class; ?>">
								<td>שיחה נוספת: <br/><?php echo $appear['date_in']; ?> 
									<br/>
									זמן שיחה בשניות: 
									<?php echo $lead['phone_data']['billsec']; ?>	
								</td>
								<td><?php echo $appear['phone']; ?></td>
								<td><?php echo $appear['phone_data']['answer']; ?></td>
								<td>
									<?php
										if($appear['phone_data']['recordingfile']!=""){
											echo "<a target='_blank' href='http://ilbiz.co.il/site-admin/recording_handlers/download.php?filename=".$appear['phone_data']['recordingfile']."' class='maintext'>לחץ כאן להורדת הקלטה</a><br/>"; 
										}
									?>
								</td> 
								<td><?php echo $campaign_names[$appear['phone_campaign_type']]; ?></td>
								<td><?php echo $appear['phone_campaign_name']; ?></td>
								<td></td>
							</tr>							
						
						<?php endforeach; ?> 
					<?php endif; ?>
				<?php endforeach; ?>
			<?php endif; ?>
			
		<?php endforeach; ?>
	</table>
	<div id="quickedit_done_msg" style="position: fixed; top: 42px; background: #ffa500b5; right: 36%; padding: 40px; font-size: 30px; font-family: SANS-SERIF; border-radius: 10px; color:green; display:none;">
		<div>
			ההערה נשמרה בהצלחה
		</div>
	</div>
	<div id="quickedit_send_msg"  style="position: fixed; top: 42px; background: #ff000038; right: 36%; padding: 40px; font-size: 30px; font-family: SANS-SERIF; border-radius: 10px; color:red; display:none;">
		<div>
			שולח
		</div>
	</div>
	<div id="quickedit_err_msg"  style="position: fixed; top: 42px; background: #ff000038; right: 36%; padding: 40px; font-size: 30px; font-family: SANS-SERIF; border-radius: 10px; color:red; display:none;">
		<div class="msg">
			
		</div>
	</div>	
	<form action="" method="POST" id="quickedit_helper_form">
		<input type="hidden" name="quickedit" value="1" />
		<input type="hidden" name="controller" value="misscalls_leads_reports" />
		<input type="hidden" name="func" value="edit_misscall_comment" />
		<?php foreach($_GET as $get_key=>$get_val): ?>
			<input type="hidden" name="<?php echo $get_key; ?>" value="<?php echo $get_val; ?>" />
		<?php endforeach; ?>
	</form>	
	<script type="text/javascript">
		function quickedit_misscall_comment(lead_id){
			jQuery(function($){
				$("#quickedit_send_msg").show();
				var thisform = $("#misscall_comment_form_"+lead_id);
				var params = thisform.serialize()+"&"+$("#quickedit_helper_form").serialize();
				$.ajax({
				  type: "POST",
				  dataType: "json",
				  url: "index.php",
				  data: params,
				  success: function(return_data){
					$("#quickedit_send_msg").hide();
					if(return_data['success'] == '1'){	  
						var comment_data = return_data['data'];
						thisform.find('textarea[name="comment"]').html(comment_data['comment']);
						thisform.find('input[name="lead_by_phone"]').val(comment_data['lead_by_phone']);
						thisform.find('.last_comment_by_name').html(comment_data['owner_name']);				
						$("#misscall_comment_tr_"+lead_id).css("background",comment_data['mark_color']);
						$("#quickedit_done_msg").show();
						setTimeout(function(){$("#quickedit_done_msg").hide()},2000);
					}
					else{
						
						$("#quickedit_err_msg").show();
						$("#quickedit_err_msg").find(".msg").html(return_data['err_msg']);
						setTimeout(function(){$("#quickedit_err_msg").hide()},2000);
						
					}
				  }
				});
			});
		}
	</script>
	<?php
	
}
function edit_misscall_comment(){
	global $data_login_trace;
	
	$comment = str_replace("'","''",$_REQUEST['comment']);
	$comment = iconv("UTF-8","Windows-1255",$comment);
	$lead_id = $_REQUEST['edit_misscall_comment'];
	$check_sql = "SELECT * FROM misscalls_comments WHERE lead_id = $lead_id";
	$check_res = mysql_db_query(DB,$check_sql);
	$check_data = mysql_fetch_array($check_res);
	if($check_data['lead_id'] == ""){
		$update_sql = "INSERT INTO misscalls_comments(unk,lead_id,comment,last_comment_by_user,lead_by_phone,mark_color) values('".$_REQUEST['lead_unk']."',$lead_id,'".$comment."','".$data_login_trace['user']."','".$_REQUEST['lead_by_phone']."','".$_REQUEST['mark_color']."')";
	
	}
	else{
		$update_sql = "UPDATE misscalls_comments SET comment = '".$comment."',last_comment_by_user = '".$data_login_trace['user']."',lead_by_phone='".$_REQUEST['lead_by_phone']."', mark_color = '".$_REQUEST['mark_color']."' WHERE lead_id = $lead_id";
	}
	$update_res = mysql_db_query(DB,$update_sql);
	$sql = "SELECT * FROM misscalls_comments WHERE lead_id = $lead_id";
	$res = mysql_db_query(DB,$sql);
	$data = mysql_fetch_array($res);
	$owners_colors = array(
		'1'=>'#e7e7ff',
		'9'=>'#acffac',
		'27'=>'#f5f5a7',
	);
	if($data['mark_color'] == ""){
		$data['mark_color'] = $owners_colors[$data['last_comment_by_user']];
	}
	$last_comment_by_user = $data['last_comment_by_user'];
	$owner_sql = "SELECT id,client_name FROM sites_owner WHERE id = $last_comment_by_user";
	$owner_res = mysql_db_query(DB,$owner_sql);
	$owner_data = mysql_fetch_array($owner_res);	
	$owner_name = $owner_data['client_name'];
	$data['owner_name'] = $owner_name;
	$edit_msg = "ההערה עודכנה בהצלחה";
	$return_data = array("data"=>$data,"msg"=>"ההערה עודכנה בהצלחה");
	
	return $return_data;
}

function add_curent_calls_monitor(){
	require_once('current_phone_calls.php');
	current_phone_calls(false);
}