<?
function customer_tracking(){
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
	
	$dates_sql = " AND tracking_date >= '".$date_from."' AND tracking_date < '".$date_to."' ";
	$cookie_by_ip_sql = "";
	$ip_filter_str = "";
	if(isset($_POST['ip_filter'])){
		if($_POST['ip_filter'] != ""){
			$ip_cookies = array();
			$ip_filter_str = $_POST['ip_filter'];
			$ip_sql = "SELECT distinct cookie FROM customer_tracking WHERE ip = '$ip_filter_str'";		
			$ip_res = mysql_db_query(DB,$ip_sql);
			while($cookie_data = mysql_fetch_array($ip_res)){
				$ip_cookies[] = $cookie_data['cookie'];
			}
			if(!empty($ip_cookies)){
				$cookie_by_ip_in = implode(",",$ip_cookies);
				$cookie_by_ip_sql = " AND cookie IN($cookie_by_ip_in) ";
			}
			
		}
	}
	$filter_relevancy_a = false;
	$filter_relevancy_b = false;
	$filter_relevancy_c = false;
	$filter_relevancy_a_checked = "";
	$filter_relevancy_b_checked = "";
	$filter_relevancy_c_checked = "";
	if(!isset($_POST['relevancy']['helper'])){
		$filter_relevancy_a_checked = "checked";
		$filter_relevancy_b_checked = "checked";
		$filter_relevancy_c_checked = "checked";
		$filter_relevancy_a = true;		
		$filter_relevancy_b = true;
		$filter_relevancy_c = true;
	}
	if(isset($_POST['relevancy']['a'])){
		$filter_relevancy_a = true;
		$filter_relevancy_a_checked = "checked";		
	}
	if(isset($_POST['relevancy']['b'])){
		$filter_relevancy_b = true;
		$filter_relevancy_b_checked = "checked";		
	}
	if(isset($_POST['relevancy']['c'])){
		$filter_relevancy_c = true;
		$filter_relevancy_c_checked = "checked";		
	}	
	$relevancy_a_sql = "";
	$relevancy_b_sql = "";
	$relevancy_c_sql = "";
	$relevancy_d_sql = "";
	if($filter_relevancy_a && $filter_relevancy_b && $filter_relevancy_c){
		$relevancy_d_sql = " AND relevancy LIKE(\"%d%\")";
	}
	else{
		if($filter_relevancy_a){
			$relevancy_a_sql = " AND relevancy LIKE(\"%a%\")";		
		}
		if($filter_relevancy_b){
			$relevancy_b_sql = " AND relevancy LIKE(\"%b%\")";		
		}
		if($filter_relevancy_c){
			$relevancy_c_sql = " AND relevancy LIKE(\"%c%\")";		
		}	
	}
	 
	$sql = "SELECT ct.cat_f,count(distinct ct.cookie) as story_count,cat.cat_name FROM customer_tracking ct LEFT JOIN biz_categories cat ON cat.id = ct.cat_f WHERE ct.submit_track !='0' $relevancy_a_sql $relevancy_b_sql $relevancy_c_sql $relevancy_d_sql $dates_sql $cookie_by_ip_sql GROUP BY ct.cat_f";
	$res = mysql_db_query(DB,$sql);
	$cat_list = array();
	while($data = mysql_fetch_array($res)){
		$cat_list[$data['cat_f']] = $data;
	}
	?>
	<h2>מעקב לקוחות</h2>
	<div><a href="index.php?sesid=<?php echo SESID; ?>">חזרה לתפריט הראשי</a></div>
	<div id="filter_wrap" style="padding: 15px;border: 1px solid black;background: #e6d7d7;margin: 15px 0px;">
		<h3>סינון סיפורים</h3>
		<form method="POST" action="" id="story_filter_form">
			<input type="hidden" name="filter_stories" value="1" />
			<div id="relevancy_filter" style="margin-left: 20px;float:right;background: #e5e5fb;padding: 10px;border: 1px solid blue;"> 
				<b>הצג רק סיפורים שמכילים גלישות בעמודים:</b>
				<input type="hidden" name="relevancy[helper]" value="1" />
				<div class="relevancy-filter-check">
					<input type="checkbox" name="relevancy[a]" value="1" <?php echo $filter_relevancy_a_checked; ?> />
					בתאריך שונה מיום מילוי הטופס
				</div>
				<div class="relevancy-filter-check">
					<input type="checkbox" name="relevancy[b]" value="1" <?php echo $filter_relevancy_b_checked; ?> />
					בקטגוריות פעילות ולא מוסתרות
				</div>	
				<div class="relevancy-filter-check">
					<input type="checkbox" name="relevancy[c]" value="1" <?php echo $filter_relevancy_c_checked; ?> />
					בקטגוריות שונות מן הקטגוריה בטופס שנשלח
				</div>					
			</div>
			<div id="dates_filter" style="margin-left: 20px;float:right;background: #e5e5fb;padding: 10px;border: 1px solid blue;">
				<b>מתאריך<b/>
				<br/>
				<input type="text" name="date_from" value="<?php echo $date_from_str; ?>" />
				<br/>
				<b>עד תאריך<b/>
				<br/>
				<input type="text" name="date_to" value="<?php echo $date_to_str; ?>" />				
			</div>
			<div id="ip_filter" style="margin-left: 20px;float:right;background: #e5e5fb;padding: 10px;border: 1px solid blue;">
				<b>הגיע מIP<b/>
				<br/>
				<input type="text" name="ip_filter" value="<?php echo $ip_filter_str; ?>" />			
			</div>			
			<input type="submit" value="הצג סיפורים" />
		</form>
		<div style='clear:both;'></div>
	</div>
	<div style="clear:both;"></div>
	<div id="customer_tracking_list_wrap">
		
	
		<?php foreach($cat_list as $cat_id=>$data): ?>
				<div id="customer_tracking_cat_stories_<?php echo $cat_id; ?>" class="customer_tracking_cat_stories">
					<a href="javascript://" rel='closed' onclick="open_cat_story_list(this,<?php echo $cat_id; ?>)">
						<?php echo ($data['cat_name'] == "")?"ללא קטגוריה" : $data['cat_name']; ?>: <?php echo $data['story_count']; ?> סיפורים 
					</a>
					<div id="customer_tracking_cat_<?php echo $cat_id; ?>_story_list" class="customer_tracking_cat_story_list" style="display:none">
					
					</div>
				</div>
		<?php endforeach; ?>
	</div>
	<script type="text/javascript">
		function open_cat_story_list(el,cat_id){
			jQuery(function($){
				if($(el).attr("rel") == "closed"){
					$(".customer_tracking_cat_story_list").each(function(){
						$(this).hide().html("");
					});
					$(".customer_tracking_cat_stories a").each(function(){
						$(this).attr("rel","closed");
					});					
					$(el).attr("rel","open");
					$("#customer_tracking_cat_"+cat_id+"_story_list").show().html("loading...");
					var filter_data = $("#story_filter_form").serialize()+"&sesid=<?php echo SESID; ?>&main=anf&gf=customer_tracking&gfunc=get_cat_stories&cat_id="+cat_id;
					$.ajax({
						type: "POST",
						url: "ajax.php",
						data: filter_data
						
					}).done(function(msg){
						$("#customer_tracking_cat_"+cat_id+"_story_list").html(msg);
					});
					
				}
				else{
					$(el).attr("rel","closed");
					$("#customer_tracking_cat_"+cat_id+"_story_list").hide().html("");
				}
			});
		}
		function open_cookie_story_list(el,cookie_id){
			jQuery(function($){
				if($(el).attr("rel") == "closed"){
					$(".customer_tracking_cookie_story_list").each(function(){
						$(this).hide();
					});
					$(".customer_tracking_cookie_story_list .customer_tracking_cookie_story_list_content_holder").each(function(){
						$(this).html("");
					});					
					$(".customer_tracking_cat_story a").each(function(){
						$(this).attr("rel","closed");
					});					
					$(el).attr("rel","open");
					$("#customer_tracking_cookie_"+cookie_id+"_story_list").show();
					$("#customer_tracking_cookie_"+cookie_id+"_story_list .customer_tracking_cookie_story_list_content_holder").html("loading...");
					
					$.ajax({
						type: "POST",
						url: "ajax.php",
						data: { sesid: "<?php echo SESID; ?>" , main: "anf" , gf: "customer_tracking", gfunc: "get_cookie_stories" , cookie_id: cookie_id }
					}).done(function(msg){
						$("#customer_tracking_cookie_"+cookie_id+"_story_list .customer_tracking_cookie_story_list_content_holder").html(msg);
					});
					
				}
				else{
					$(el).attr("rel","closed");
					$("#customer_tracking_cookie_"+cookie_id+"_story_list").hide();
					$("#customer_tracking_cookie_"+cookie_id+"_story_list .customer_tracking_cookie_story_list_content_holder").html("");
				}
			});
		}		
	</script>
	<?php
}

function get_cat_stories(){ 
	$cat_id = $_REQUEST['cat_id'];
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
	
	$dates_sql = " AND tracking_date >= '".$date_from."' AND tracking_date < '".$date_to."' ";
		
	$cookie_list = array();
	$cookie_in_arr = array();
	$relevancy_sql = "";
	if(isset($_REQUEST['relevancy'])){
		$relevancy_arr = $_REQUEST['relevancy'];
		if(isset($relevancy_arr['a']) && isset($relevancy_arr['b']) && isset($relevancy_arr['c'])){
			unset($relevancy_arr['a']);
			unset($relevancy_arr['b']);
			unset($relevancy_arr['c']);
			$relevancy_arr['d'] = '1';
		}
		foreach($relevancy_arr as $key=>$val){
			if($key!="helper"){
				$relevancy_sql .= "  AND relevancy LIKE(\"%".$key."%\") ";
			}
		}
	}
	$cookie_by_ip_sql = "";
	if(isset($_REQUEST['ip_filter'])){
		if($_REQUEST['ip_filter'] != ""){
			$ip_cookies = array();
			$ip_filter_str = $_REQUEST['ip_filter'];
			$ip_sql = "SELECT distinct cookie FROM customer_tracking WHERE ip = '$ip_filter_str'";		
			$ip_res = mysql_db_query(DB,$ip_sql);
			while($cookie_data = mysql_fetch_array($ip_res)){
				$ip_cookies[] = $cookie_data['cookie'];
			}
			if(!empty($ip_cookies)){
				$cookie_by_ip_in = implode(",",$ip_cookies);
				$cookie_by_ip_sql = " AND cookie IN($cookie_by_ip_in) ";
			}
			
		}
	}	
	$sql = "SELECT cookie FROM customer_tracking WHERE submit_track !='0' AND cat_f = $cat_id $relevancy_sql $cookie_by_ip_sql $dates_sql GROUP BY cookie";
	$res = mysql_db_query(DB,$sql);
	while($cookie_data = mysql_fetch_array($res)){
		$cookie_list[$cookie_data['cookie']] = $cookie_data;
		$cookie_in_arr[] = $cookie_data['cookie'];
	}
	$cookie_in_sql = implode(",",$cookie_in_arr);
	
	$sql = "SELECT cookie,count(id) as page_count FROM customer_tracking WHERE cookie IN(".$cookie_in_sql.") $cookie_by_ip_sql GROUP BY cookie";
	$res = mysql_db_query(DB,$sql);
	while($cookie_data = mysql_fetch_array($res)){
		$cookie_list[$cookie_data['cookie']]['page_count'] = $cookie_data['page_count'];
	}	
	
	//find estimate_form info from submited stories
	$sql = "SELECT ct.cookie,ef.phone,ef.name,ef.id,ef.insert_date FROM customer_tracking ct LEFT JOIN estimate_form ef ON ef.id = ct.estimateFormId WHERE ct.cookie IN(".$cookie_in_sql.") $cookie_by_ip_sql AND ct.estimateFormId!='0'";
	$res = mysql_db_query(DB,$sql);
	while($ef_data = mysql_fetch_array($res)){
		$cookie_list[$ef_data['cookie']]['ef_data'] = $ef_data;
	}
	
	//find call info from phone call related stories
	$sql = "SELECT ct.cookie,cd.call_to,cd.call_from,cd.id,cd.date,cd.answer,cd.recordingfile FROM customer_tracking ct LEFT JOIN sites_leads_stat cd ON cd.id = ct.phone_row WHERE ct.cookie IN(".$cookie_in_sql.") $cookie_by_ip_sql AND ct.phone_track_sure='1'";
	$res = mysql_db_query(DB,$sql);
	while($call_data = mysql_fetch_array($res)){
		$cookie_list[$call_data['cookie']]['call_data'] = $call_data;
	}	
	?>
	<table border="1" cellpadding="3" style="border-collapse: collapse;">
		<tr>
			<th>#</th>
			<th>תאריך</th>
			<th>שם</th>
			<th>טלפון</th>
			<th>עמודים</th>
			<th>קוקי</th>
		</tr>
		<?php $i=0; foreach($cookie_list as $cookie=>$story): $i++; ?>
			<tr class="customer_tracking_cat_story">
				<?php if(isset($story['ef_data'])): ?>
					<td><?php echo $i; ?></td>
					<td><?php echo $story['ef_data']['insert_date']; ?></td>
					<td><a href="javascript://" rel='closed' onclick="open_cookie_story_list(this,'<?php echo $cookie; ?>')"><?php echo $story['ef_data']['name']; ?></a></td>
					<td><?php echo $story['ef_data']['phone']; ?></td>
					<td><?php echo $story['page_count']; ?></td>
					<td><?php echo $cookie; ?></td>
				<?php elseif(isset($story['call_data'])): ?>
					<td><?php echo $i; ?></td>
					<td><?php echo $story['call_data']['date']; ?></td>
					<td>
						<a href="javascript://" rel='closed' onclick="open_cookie_story_list(this,'<?php echo $cookie; ?>')">
							שיחה אל <?php echo $story['call_data']['call_to']; ?>
						</a>	
					</td>
					<td>
						<a target='_blank' href='https://ilbiz.co.il/site-admin/recording_handlers/download.php?filename=<?php echo $story['call_data']['recordingfile']; ?>'>
							<?php echo $story['call_data']['call_from']; ?>
						</a>
					</td>
					<td><?php echo $story['page_count']; ?></td>
					<td><?php echo $cookie; ?></td>				
				<?php else: ?>
					<td><?php echo $i; ?></td>
					<td></td>
					<td></td>
					<td></td>
					<td><?php echo $story['page_count']; ?></td>
					<td><?php echo $cookie; ?></td>				
				<?php endif; ?>
				
			</tr>
			<tr id="customer_tracking_cookie_<?php echo $cookie; ?>_story_list" class="customer_tracking_cookie_story_list" style="display:none">
				<td colspan="20" class="customer_tracking_cookie_story_list_content_holder"></td>
			</tr>
		<?php endforeach; ?>
	</table>
	<?php
}


function get_cookie_stories(){
	$cookie_id = $_REQUEST['cookie_id'];
	$sql = "SELECT * FROM customer_tracking WHERE cookie ='$cookie_id'";
	$res = mysql_db_query(DB,$sql);
	$page_list = array();
	while($page_data = mysql_fetch_array($res)){
		
		$page_data['type_txt'] = "דף תוכן";
		$page_data['page_name'] = "";
		$page_data['page_link'] = "";
		$site_sql = "SELECT domain,name,full_name FROM users WHERE id = '".$page_data['site_id']."'";
		$site_res = mysql_db_query(DB,$site_sql);
		$site_data = mysql_fetch_array($site_res);
		$site_url = "http://".$site_data['domain'];
		$page_data['domain'] = $site_data['domain'];
		$page_data['site_name'] = $site_data['name'];
		$page_data['site_full_name'] = $site_data['full_name'];
		$page_data['site_data'] = $site_data;
		$page_data['site_url'] = $site_url;
		$page_data['site_link'] = "<a target='_BLANK' href='".$site_url."'>".$page_data['site_name']."</a>";
		if($page_data['page_m']!= "text" && $page_data['page_m']!= "land"){
			$page_data['type_txt'] = "דף מערכת";
		}
		if($page_data['page_m']== "hp"){
			$page_data['type_txt'] = "דף בית - פורטל";
		}
		if($page_data['page_type'] == "0"){
			$page_data['type_txt'] = "דף הבית";
		}
		if($page_data['page_type'] == "2" || $page_data['page_m']== "land"){
			$page_data['type_txt'] = "דף נחיתה";
			$landing_page_sql = "SELECT landing_name FROM sites_landingPage_settings WHERE id = '".$page_data['page_id']."' ";
			$landing_page_res = mysql_db_query(DB,$landing_page_sql);
			$landing_page_data = mysql_fetch_array($landing_page_res);
			$page_data['page_name'] = $landing_page_data['landing_name'];
			$page_data['page_link'] = "<a target='_BLANK' href='".$site_url."/landing.php?ld=".$page_data['page_id']."' >".$page_data['page_name']."</a>";
		}		
		if($page_data['page_m']== "text" && $page_data['page_type'] == "1"){
			$content_page_sql = "SELECT name FROM content_pages WHERE id = '".$page_data['page_id']."' ";
			$content_page_res = mysql_db_query(DB,$content_page_sql);
			$content_page_data = mysql_fetch_array($content_page_res);
			$page_data['page_name'] = $content_page_data['name'];
			$page_link_str = str_replace(" ","-",$page_data['page_name']);
			$page_data['page_link'] = "<a target='_BLANK' href='".$site_url."/".$page_link_str."/' >".$page_data['page_name']."</a>";
		}
		if($page_data['page_link'] == ""){
			$page_data['page_link'] = $page_data['page_m'];
		}
		$cats_id_in = "'".$page_data['cat_f']."',"."'".$page_data['cat_s']."',"."'".$page_data['cat_spec']."'";
		$cats_sql = "SELECT id,cat_name FROM biz_categories WHERE id IN($cats_id_in) AND id != '0'";
		$cats_res = mysql_db_query(DB,$cats_sql);
		$cats_names_arr = array();
		while($cat_data = mysql_fetch_array($cats_res)){
			$cats_names_arr[$cat_data['id']] = $cat_data['cat_name'];
		}
		$page_data['cat_f_str'] = (isset($cats_names_arr[$page_data['cat_f']]))?$cats_names_arr[$page_data['cat_f']]:"";
		$page_data['cat_s_str'] = (isset($cats_names_arr[$page_data['cat_s']]))?$cats_names_arr[$page_data['cat_s']]:"";
		$page_data['cat_spec_str'] = (isset($cats_names_arr[$page_data['cat_spec']]))?$cats_names_arr[$page_data['cat_spec']]:"";
		$page_data['cat_names_arr'] = $cats_names_arr;
		$time_arr = explode(" ",$page_data['tracking_time']);
		$p_date = $time_arr[0];
		$p_time = $time_arr[1];
		$p_date_arr = explode("-",$p_date);
		$page_data['tracking_date_str'] = $p_date_arr[2]."-".$p_date_arr[1]."-".$p_date_arr[0];
		$page_data['tracking_time_str'] = $p_time;
		$tr_form_style = "";
		if($page_data['form_submited'] == '1'){
			$tr_form_style = "background:#8eea8e;";
		}
		elseif($page_data['phone_track_sure'] == '1'){
			$tr_form_style = "background:#ee8a8e;";
		}
		$page_data['tr_form_style'] = $tr_form_style;
		$page_data['mobile_type'] = "מחשב";
		if($page_data['is_mobile'] == '1'){
			$page_data['mobile_type'] = "נייד";
		}
		$page_data['has_form'] = "לא";
		$page_data['form_cats_str'] = "";
		$page_data['city_str'] = "";
		if($page_data['form_submited'] == '1'){
			$page_data['has_form'] = "כן";
			if($page_data['estimateFormId'] != '' && $page_data['estimateFormId'] != '0'){
				$efsql = "SELECT * FROM estimate_form WHERE id = '".$page_data['estimateFormId']."'";
				$efres = mysql_db_query(DB,$efsql);
				$efdata = mysql_fetch_array($efres);
				$cats_id_in = "'".$efdata['cat_f']."',"."'".$efdata['cat_s']."',"."'".$efdata['cat_spec']."'";
				$cats_sql = "SELECT id,cat_name FROM biz_categories WHERE id IN($cats_id_in) AND id != '0'";
				$cats_res = mysql_db_query(DB,$cats_sql);
				while($cat_data = mysql_fetch_array($cats_res)){
					$cats_names_arr[$cat_data['id']] = $cat_data['cat_name'];
					if($page_data['form_cats_str']!=""){
						$page_data['form_cats_str'].=",";
					}
					$page_data['form_cats_str'] .=$cat_data['cat_name'];
				}
				$city_sql = "SELECT name FROM newCities WHERE id = ".$efdata['city'];
				$city_res = mysql_db_query(DB,$city_sql);
				$city_data = mysql_fetch_array($city_res);
				$page_data['city_str'] = $city_data['name'];
			}
		}
		if($page_data['phone_track_sure'] == '1'){
			$call_sql = "SELECT * FROM sites_leads_stat WHERE id = ".$page_data['phone_row']." ";
			$call_res = mysql_db_query(DB,$call_sql);
			$call_data = mysql_fetch_array($call_res);
			$page_data['has_form'] = "בוצעה שיחה אל ".$call_data['call_to']; 
		}			
		$page_list[$page_data['id']] = $page_data;
	}
	//print_r($page_list);

	?>
	<table border="1" cellpadding="3" style="border-collapse: collapse;background:#e6f0f1;">
		<tr>
			<th>#</th>
			<th>תאריך</th>
			<th>שעה</th>
			<th>אתר</th>
			<th>סוג עמוד</th>
			<th>שם עמוד</th>
			<th>קטגוריה 1</th>
			<th>2</th>
			<th>3</th>
			<th>קטגוריה בטופס</th>
			<th>עיר</th>
			<th>חיפוש</th>
			<th>ip</th>
			<th>קמפיין</th>
			<th>סוג מכשיר</th>
			<th>יש טופס</th>
			<th>מספר טופס</th>
			<th>שליחה ללקוחות</th>
		</tr>
		<?php $i=0; foreach($page_list as $page_id=>$page_data): $i++; ?>
			<tr class="customer_tracking_page_story" style="<?php echo $page_data['tr_form_style']; ?>">
				<td><?php echo $i; ?></td>
				<td><?php echo $page_data['tracking_date_str']; ?></td>
				<td><?php echo $page_data['tracking_time_str']; ?></td>
				<td><?php echo $page_data['site_link']; ?></td>
				<td><?php echo $page_data['type_txt']; ?></td>
				<td><?php echo $page_data['page_link']; ?></td>
				<td><?php echo $page_data['cat_f_str']; ?></td>
				<td><?php echo $page_data['cat_s_str']; ?></td>
				<td><?php echo $page_data['cat_spec_str']; ?></td>
				<td><?php echo $page_data['form_cats_str']; ?></td>
				<td><?php echo $page_data['city_str']; ?></td>
				<td><?php echo $page_data['s_term']; ?></td>
				<td><?php echo $page_data['ip']; ?></td>
				<td><?php echo $page_data['has_gclid']; ?></td>
				<td><?php echo $page_data['mobile_type']; ?></td>
				<td><?php echo $page_data['has_form']; ?></td>
				<td><a href="index.php?main=send_estimate_form_users_list&estimate_id=<?php echo $page_data['estimateFormId']; ?>&sesid=<?php echo SESID ?>" target="new"><?php echo $page_data['estimateFormId']; ?></a></td>
				<td><?php echo $page_data['customer_send']; ?></td>
			</tr>
		<?php endforeach; ?>
	</table>
	<?php
	
}