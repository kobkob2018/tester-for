<?
function block_list(){	 
	$sql = "SELECT blck.id as block_id,blck.cookie,blck.note,ef.name,ef.phone FROM cookie_block blck LEFT JOIN estimate_form ef ON blck.estimate_form_id = ef.id ";
	//echo $sql;
	$res = mysql_db_query(DB,$sql);
	$block_list = array();
	while($data = mysql_fetch_array($res)){
		$count_sql = "SELECT count(distinct estimateFormId) as story_count FROM customer_tracking WHERE cookie = '".$data['cookie']."'" ;
		$count_res = mysql_db_query(DB,$count_sql);
		$count_data = mysql_fetch_array($count_res);
		$data['story_count'] = $count_data['story_count'];
		$block_list[$data['block_id']] = $data;

	}
	?>
	<h2>רשימת לקוחות חסומים על ידי קוקי</h2>
	<div><a href="index.php?sesid=<?php echo SESID; ?>">חזרה לתפריט הראשי</a></div>
	<div id="cookie_block_list_wrap">
		
		<table border="1" cellpadding="3" style="border-collapse: collapse;">
			<tr>
				<th>#</th>
				<th>שם לקוח</th>
				<th>טלפון</th>
				<th>מספר טפסים</th>
				<th>קוקי</th>
				<th>ביטול החסימה</th>
			</tr>	
			<?php foreach($block_list as $block_id=>$data): ?>
				<tr class="cookie_block_user">
					<td><?php echo $block_id; ?></td>
					<td><?php echo $data['name']; ?></td>
					<td><?php echo $data['phone']; ?></td>
					<td><a href="javascript://" rel='closed' onclick="open_cookie_block_story_list(this,'<?php echo $data['cookie']; ?>')"><?php echo $data['story_count']; ?> טפסים</a></td>
					<td><?php echo $data['cookie']; ?></td>
					<td>
						<a href='index.php?main=send_estimate_form_users_list&block_by_cookie=1&cookie=<?php echo $data['cookie']; ?>&relese_block=1&sesid=<?php echo SESID; ?>' >
							לחץ כאן לביטול החסימה
						</a>
					</td> 
				</tr>
				<tr id="cookie_block_<?php echo $data['cookie']; ?>_story_list" class="cookie_block_story_list" style="display:none">
					<td colspan="20" class="cookie_block_story_list_content_holder"></td>
				</tr>
			<?php endforeach; ?>
		</table>
	</div>
	<script type="text/javascript">
		function open_cookie_block_story_list(el,cookie_id){
			jQuery(function($){
				if($(el).attr("rel") == "closed"){
					$(".cookie_block_story_list").each(function(){
						$(this).hide();
					});
					$(".cookie_block_story_list .cookie_block_story_list_content_holder").each(function(){
						$(this).html("");
					});					
					$(".cookie_block_user a").each(function(){
						$(this).attr("rel","closed");
					});					
					$(el).attr("rel","open");
					$("#cookie_block_"+cookie_id+"_story_list").show();
					$("#cookie_block_"+cookie_id+"_story_list .cookie_block_story_list_content_holder").html("loading...");
					
					$.ajax({
						type: "POST",
						url: "ajax.php",
						data: { sesid: "<?php echo SESID; ?>" , main: "anf" , gf: "block_list", gfunc: "get_cookie_stories" , cookie_id: cookie_id }
					}).done(function(msg){
						$("#cookie_block_"+cookie_id+"_story_list .cookie_block_story_list_content_holder").html(msg);
					});
					
				}
				else{
					$(el).attr("rel","closed");
					$("#cookie_block_"+cookie_id+"_story_list").hide();
					$("#cookie_block_"+cookie_id+"_story_list .ccookie_block_story_list_content_holder").html("");
				}
			});
		}		
	</script>
	<?php
}
$cat_name_list = array();
function get_cookie_stories(){

	global $cat_name_list;
	$cookie_id = $_REQUEST['cookie_id'];
	$sql = "SELECT distinct estimateFormId FROM customer_tracking WHERE cookie ='$cookie_id'";
	$res = $res = mysql_db_query(DB,$sql);
	$estimate_form_ids = array();
	while($data = mysql_fetch_array($res)){
		if($data['estimateFormId']!= ''){
			$estimate_form_ids[] = $data['estimateFormId'];
		}
	}
	$form_id_in = implode(",",$estimate_form_ids); 
	$sql = "SELECT * FROM estimate_form WHERE id IN($form_id_in)";
	$res = mysql_db_query(DB,$sql);
	$form_list = array();
	while($form_data = mysql_fetch_array($res)){
		$cats_tofind = array($form_data['cat_f'],$form_data['cat_s'],$form_data['cat_spec']);
		foreach($cats_tofind as $cat_id){
			if(!isset($cat_name_list[$cat]) && $cat_id!='0' && $cat_id!=''){ 
				$cat_sql = "SELECT cat_name FROM biz_categories WHERE id  = $cat_id";
				$cat_res = mysql_db_query(DB,$cat_sql);
				$cat_data = mysql_fetch_array($cat_res);
				$cat_name_list[$cat_id] = $cat_data['cat_name'];
			}
		}
		
		$form_list[$form_data['id']] = $form_data;
	}
	?>
	<table border="1" cellpadding="3" style="border-collapse: collapse;background:#e6f0f1;">
		<tr>
			<th>#</th>
			<th>תאריך</th>
			<th>שם</th>
			<th>טלפון</th>
			<th>אימייל</th>
			<th>הערות</th>
			<th>קטגוריה 1</th>
			<th>2</th>
			<th>3</th>
			<th>צפה בטופס</th>
		</tr>
		<?php $i=0; foreach($form_list as $form_id=>$form_data): $i++; ?>
			<tr class="cookie_block_form">
				<td><?php echo $i; ?></td>
				<td><?php echo $form_data['insert_date']; ?></td>
				<td><?php echo $form_data['name']; ?></td>
				<td><?php echo $form_data['phone']; ?></td>
				<td><?php echo $form_data['emsil']; ?></td>
				<td><?php echo $form_data['note']; ?></td>
				<td><?php echo $cat_name_list[$form_data['cat_f']]; ?></td>
				<td><?php echo $cat_name_list[$form_data['cat_s']]; ?></td>
				<td><?php echo $cat_name_list[$form_data['cat_spec']]; ?></td>
				<td><a target="_NEW" href="index.php?main=send_estimate_form_users_list&estimate_id=<?php echo $form_id; ?>&limitcount=0&status=<?php echo $form_data['status']; ?>&sesid=<?php echo SESID; ?>" >לחץ כאן לצפייה</a></td>
				
			</tr>
		<?php endforeach; ?>
	</table>
	<?php
	
}