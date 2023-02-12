<?php

/*
mysql performance tuning
execution plan the way it uses indexes
slow query log
mysql query slow query log
myisum vs innoDB(engin..)

explain (and then the query...) - will explain the proccess of the query.. 
buffuer size, key block size
query cache 
analyze
*/
function estimate_statistics_list(){
	echo "<div><a href=\"?sesid=".SESID."\" >חזרה לתפריט הראשי</a></div>";
	echo "<h3>סטטיסטיקה של אתרי השוואות מחיר</h3>";
	
	
	$search_page_id_val = "";
	if(isset($_GET['search_page_id'])){
		$search_page_id_val = $_GET['search_page_id'];
	}
	?>
		<form action='index.php' name='searchForm' method="GET">
			<input type='hidden' name='main' value='estimate_statistics_list'>
			<input type='hidden' name='sesid' value='<?php echo SESID; ?>'>
			<b>חיפוש עמוד: </b>
			<input type="text" name="search_page_id" value='<?php echo $search_page_id_val; ?>'/>
			<input type="submit" value="חפש" />
			<br/><br/>
		</form>
	<?php
	if(isset($_GET['search_page_id'])){
		?>
		<h3>תוצאות חיפוש</h3>
		<table border='1' cellpadding='5'>
			<tr>
				<th>משתמש</th>
				<th>דומיין</th>
				<th>שם הדף</th>
				<th>מספר הדף</th>
				<th>ID של טופס</th>
				<th>סוג</th>
				<th>צפייה</th>
			</tr>
			<?php
		
			$sql = "SELECT cp.name as page_name,cp.type as page_type ,cp.id as page_id,usr.name as user_name, usr.domain as domain FROM content_pages cp LEFT JOIN users usr ON usr.unk = cp.unk WHERE cp.name LIKE ('%".$_GET['search_page_id']."%')";
			$res = mysql_db_query(DB,$sql);
			?>
		
			<?php while($page = mysql_fetch_array($res)): ?>
				<?php 
					$fsql ="SELECT * FROM estimate_miniSite_defualt_block WHERE type = '".$page['page_type']."'";
					//echo $fsql,"<hr/>";
					$fres = mysql_db_query(DB,$fsql);
					$fdata = mysql_fetch_array($fres);
					$cat_qstr = "";
					if($fdata['primeryCat'] != "" && $fdata['primeryCat'] != "0"){
						$cat_qstr .= "&father_cat=".$fdata['primeryCat'];
					}
					if($fdata['subCat'] != "" && $fdata['subCat'] != "0"){
						$cat_qstr .= "&sub_cat=".$fdata['subCat'];
					}
				?>
				<tr>
					<td><?php echo $page['user_name']; ?></td>
					<td><?php echo $page['domain']; ?></td>
					<td><?php echo $page['page_name']; ?></td>
					<td><?php echo $page['page_id']; ?></td>
					<td><?php echo $page['page_id']; ?></td>
					<td>רגיל</td>
					<td><a href="index.php?main=estimate_statistics_list&sesid=<?php echo SESID; ?>&page_id=<?php echo $page['page_id']; ?><?php echo $cat_qstr; ?>">צפה</a></td>
				</tr>
			<?php endwhile; ?>
			<?php
		
			$sql = "SELECT cp.landing_name as page_name ,cp.id as page_id,cp.mailignList_contentPageID as form_page_id,usr.name as user_name, usr.domain as domain FROM sites_landingPage_settings cp LEFT JOIN users usr ON usr.unk = cp.unk WHERE cp.landing_name LIKE ('%".$_GET['search_page_id']."%')";
			$res = mysql_db_query(DB,$sql);
			
			?>
		
			<?php while($page = mysql_fetch_array($res)): ?>
				<?php 
					$fsql ="SELECT * FROM estimate_miniSite_defualt_block WHERE type = (SELECT type FROM content_pages WHERE id = '".$page['form_page_id']."')";
					$fres = mysql_db_query(DB,$fsql);
					$fdata = mysql_fetch_array($fres);
					$cat_qstr = "";
					if($fdata['primeryCat'] != "" && $fdata['primeryCat'] != "0"){
						$cat_qstr .= "&father_cat=".$fdata['primeryCat'];
					}
					if($fdata['subCat'] != "" && $fdata['subCat'] != "0"){
						$cat_qstr .= "&sub_cat=".$fdata['subCat'];
					}
				?>
				<tr>
					<td><?php echo $page['user_name']; ?></td>
					<td><?php echo $page['domain']; ?></td>
					<td><?php echo $page['page_name']; ?></td>
					<td><?php echo $page['page_id']; ?></td>
					<td><?php echo $page['form_page_id']; ?></td>
					<td>דף נחיתה</td>
					<td><a href="index.php?main=estimate_statistics_list&sesid=<?php echo SESID; ?>&page_id=<?php echo $page['form_page_id']; ?>&ld=<?php echo $page['page_id']; ?><?php echo $cat_qstr; ?>">צפה</a></td>
				</tr>
			<?php endwhile; ?>				
		</table>
		<?php
		return;
	}	
	
	if(isset($_GET['page_id'])){
		$page_name = "";
		$search_page_title = "";
		if(isset($_GET['ld'])){
			$sql = "SELECT landing_name as page_name FROM sites_landingPage_settings WHERE id = ".$_GET['ld']."";

			$res = mysql_db_query(DB,$sql);
			$page = mysql_fetch_array($res);
			$page_name = $page['page_name'];
			$search_page_title = "סטטיסטיקות לדף נחיתה ".$page_name ;
			
		}
		else{
			$sql = "SELECT name as page_name FROM content_pages WHERE id = ".$_GET['page_id']."";
			$res = mysql_db_query(DB,$sql);
			$page = mysql_fetch_array($res);
			$page_name = $page['page_name'];	
			$search_page_title = "סטטיסטיקות לדף ".$page_name ;
		}
		
		
		?>
	
		<h3><?php echo $search_page_title; ?></h3>
		
		<?php
	}
	if(isset($_GET['view_pages'])){
		return estimate_statistics_list_pages();
	}
	$table_sql = array();
	$table_sql['estimate_form'] = array();
	$table_sql['statistics'] = array();

	$start_date_str = date('d-m-Y');
	$end_date_str = date('d-m-Y');

	if( $_GET['start_date'] != "" ) 
	{
		$start_date_str = $_GET['start_date'];
	}
	else{
		$_GET['start_date'] = $start_date_str;
	}
	
	if( $_GET['end_date'] != "" ) 
	{
		$end_date_str = $_GET['end_date'];
	}
	else{
		$_GET['end_date'] = $end_date_str;
	}	

	$exp_start_date = explode("-" , $start_date_str);
	$start_date = $exp_start_date[2]."-".$exp_start_date[1]."-".$exp_start_date[0];
	
	$exp_end_date = explode("-" , $end_date_str);
	$end_date_temp = $exp_end_date[2]."-".$exp_end_date[1]."-".$exp_end_date[0];	
	$end_date = date('Y-m-d', strtotime($end_date_temp. ' + 1 day'));
	
	$table_sql['estimate_form']['start_date'] = " AND insert_date >= '$start_date' ";
	$table_sql['statistics']['start_date'] = " AND date >= '$start_date' ";
	
	$table_sql['estimate_form']['end_date'] = " AND insert_date <= '$end_date' ";
	$table_sql['statistics']['end_date'] = " AND date <= '$end_date' ";
	
	$table_sql['estimate_form']['dates'] = $table_sql['estimate_form']['start_date'].$table_sql['estimate_form']['end_date'];
	$table_sql['statistics']['dates'] = $table_sql['statistics']['start_date'].$table_sql['statistics']['end_date'];
	
	$table_sql['estimate_form']['get_cat'] = "";
	$table_sql['statistics']['get_cat'] = "";	
	if( $_GET['father_cat'] != "" ){
		$get_cat = $_GET['father_cat'];
		$table_sql['estimate_form']['get_father_cat'] .= " AND (cat_f = $get_cat OR cat_s = $get_cat OR cat_spec = $get_cat) ";
		$table_sql['statistics']['get_father_cat'] .= " AND (father_cat = $get_cat OR sub_cat = $get_cat)  ";			
	}
	
	if( $_GET['sub_cat'] != "" ){
		$get_cat = $_GET['sub_cat'];
		$table_sql['estimate_form']['get_sub_cat'] .= " AND (cat_f = $get_cat OR cat_s = $get_cat OR cat_spec = $get_cat) ";
		$table_sql['statistics']['get_sub_cat'] .= " AND (father_cat = $get_cat OR sub_cat = $get_cat)  ";		
	}
	if($get_cat == ""){
		$get_cat = "0";
	}
	$sql = "SELECT cat_name FROM biz_categories WHERE id = $get_cat";
	$res = mysql_db_query(DB, $sql);
	$data = mysql_fetch_array($res);	
	$get_cat_name = $data['cat_name'];
	$table_sql['statistics']['get_cat'] = $table_sql['statistics']['get_father_cat'].$table_sql['statistics']['get_sub_cat'];
	$table_sql['estimate_form']['get_cat'] = $table_sql['estimate_form']['get_father_cat'].$table_sql['estimate_form']['get_sub_cat'];
	$table_sql['estimate_form']['where'] = $table_sql['estimate_form']['dates'].$table_sql['estimate_form']['get_cat'];
	$table_sql['statistics']['where'] = $table_sql['statistics']['dates'].$table_sql['statistics']['get_cat'];
	
	$select_view = 'father_cat';
	$ef_select_view = 'ef.cat_f';
	$select_view_next = 'sub_cat';
	$select_view_name = 'קטגוריה ראשית';
	$select_view_before = "";
	$select_view_before_name = "";
	$view_domains_only = false;
	if( $_GET['father_cat'] != "" ){
		$select_view = 'sub_cat';
		$ef_select_view = 'ef.cat_s';
		$select_view_next = 'domain';
		$select_view_name = 'קטגוריה משנית';
		$select_view_before = "father_cat";
		$select_view_before_name = "קטגוריות ראשיות";

		
	}
	if( $_GET['sub_cat'] != ""){
		
		$select_view = 'domain';
		$ef_select_view = 'ses.domain';
		$select_view_next = 'domain';
		$select_view_name = 'דומיין';
		$select_view_before = "sub_cat";
		$select_view_before_name = "קטגוריות משניות";
		$view_domains_only = true;
	}	
	
	if(isset($_GET['view_domains'])){
		$select_view = 'domain';
		$select_view_name = 'דומיין';
		$ef_select_view = 'ses.domain';
	}
	$has_gclid_sql = "";
	if(isset($_GET['gclid_only'])){
		$has_gclid_sql = " AND has_gclid = '1' ";
	}
	if(isset($_GET['fb_only'])){
		$has_gclid_sql = " AND has_gclid = '2' ";
	}	
	
	$is_mobile_sql = "";
	if(isset($_GET['browser_type'])){
		if($_GET['browser_type'] == "mobile"){
			$is_mobile_sql = " AND is_mobile = '1' ";
		}
		if($_GET['browser_type'] == "desktop"){
			$is_mobile_sql = " AND is_mobile = '0' ";
		}
	}	
	$link_general_url = "index.php?";
	$link_before_url = "index.php?";
	$link_domainsview_url = "index.php?";
	$link_catview_url = "index.php?";
	$get_index = 0;
	$get_index_before = 0;
	$get_index_catview = 0;
	foreach($_GET as $key=>$val){
		if($key != $select_view_before){
				if($get_index_before != 0){
				$link_before_url .="&";
			}
			$link_before_url .="$key=$val";
			$get_index_before++;
		}
		if($key != 'view_domains'){
				if($get_index_catview != 0){
				$link_catview_url .="&";
			}
			$link_catview_url .="$key=$val";
			$get_index_catview++;
		}	
		$link_domainsview_url = $link_catview_url ."&view_domains=1";
		if($get_index != 0){
			$link_general_url .="&";
		}
		$link_general_url .="$key=$val";
		$get_index++;
	}

	$result_view_list = array();
	$result_view_names = array();
	$suming_arr = array();
	$suming_arr['view_name'] = "summing_all";
	$suming_arr['view_name_full']= "סך הכל";
	$suming_arr['father'] = "-";
	$suming_arr['url_link'] = "סך הכל";		
	$suming_arr['unique_views'] = 0;
	$suming_arr['unique_views_sub'] = 0;
	$suming_arr['leads_by_views'] = 0;
	$suming_arr['leads_by_forms'] = 0;
	$suming_arr['views_leads_ratio'] = 0;
	$suming_arr['customer_send'] = 0;
	$suming_arr['leads_send_ratio'] = 0;	
		
	$leads_by_views_list = array();
	$list_select_view = 'father_cat';
	$list_select_cat = $_GET['father_cat'];
	if( $_GET['sub_cat'] != ""){
		$list_select_view = 'sub_cat';
		$list_select_cat = $_GET['sub_cat'];
	}
	$page_id_sql = "";
	if(isset($_GET['page_id'])){
		
		if($_GET['page_id'] != ""){
			$page_id_sql = " AND page_id = '".$_GET['page_id']."' ";
		}
	}
	$sql = "SELECT * FROM statistics_estimate_site where 1" 
		 .$table_sql['statistics']['dates'].$table_sql['statistics']['get_cat'].$has_gclid_sql.$is_mobile_sql.$page_id_sql." 
		 AND $list_select_view = '$list_select_cat' AND  sent_from = 1 ";

	$res_view = mysql_db_query(DB, $sql);
	while($lead_view = mysql_fetch_array($res_view)){
		$lsql = "SELECT * FROM estimate_form WHERE statistic_id = '".$lead_view['id']."'";
		$lres = mysql_db_query(DB,$lsql);
		$ldata = mysql_fetch_array($lres);
		$ldata['statistic'] = $lead_view;
		$ssql = "SELECT * FROM statistics_estimate_site_extra WHERE stat_id = '".$lead_view['id']."'";
		$sres = mysql_db_query(DB,$ssql);		
		$sdata = mysql_fetch_array($sres);
		$ldata['extra'] = $sdata;
		
		$leads_by_views_list[] = $ldata;	
	}
	$leads_by_forms_list = array();
	$list_select_view = 'father_cat';
	$list_select_cat = $_GET['father_cat'];
	if( $_GET['sub_cat'] != ""){
		$list_select_view = 'sub_cat';
		$list_select_cat = $_GET['sub_cat'];
	}



	$sql = "SELECT ef.* as leads FROM estimate_form ef LEFT JOIN statistics_estimate_site ses ON ses.id= ef.statistic_id where 1" 
		 .$table_sql['estimate_form']['dates'].$table_sql['estimate_form']['get_cat'].$has_gclid_sql.$is_mobile_sql.$page_id_sql." 
		 AND (cat_f = '$list_select_cat' OR cat_s = '$list_select_cat' OR cat_spec = '$list_select_cat')";
	


	$res_view = mysql_db_query(DB, $sql);
	while($ldata = mysql_fetch_array($res_view)){
		$ssql = "SELECT * FROM statistics_estimate_site_extra WHERE stat_id = '".$ldata['statistic_id']."'";
		$sres = mysql_db_query(DB,$ssql);		
		$sdata = mysql_fetch_array($sres);
		$ldata['extra'] = $sdata;
		$leads_by_forms_list[] = $ldata;	
	}		
	
	$leads_by_phones_list = array();
	$phones_payd_sql = "SELECT * FROM user_contact_forms WHERE unk IN(SELECT unk FROM users WHERE id IN(SELECT user_id FROM user_cat WHERE cat_id = $list_select_cat)) AND lead_recource = 'phone' AND lead_billed = '1' AND status!='6' AND lead_billed = '1' AND date_in >= '$start_date' AND date_in <= '$end_date'";
	$phones_payd_res = mysql_db_query(DB,$phones_payd_sql);
	while($phones_payd_data = mysql_fetch_array($phones_payd_res)){
		$user_sql = "SELECT name FROM users WHERE unk = '".$phones_payd_data['unk']."'";
		$user_res = mysql_db_query(DB,$user_sql);
		$user_data = mysql_fetch_array($user_res);
		$phones_payd_data['user'] = $user_data;
		$number_sql = "SELECT * FROM sites_leads_stat WHERE id='".$phones_payd_data['phone_lead_id']."'";
		$number_res = mysql_db_query(DB,$number_sql);
		$number_data = mysql_fetch_array($number_res);
		$phones_payd_data['number'] = $number_data;

		$campaign_sql = "SELECT * FROM users_phones WHERE phone='".$number_data['did']."'";
		$campaign_res = mysql_db_query(DB,$campaign_sql);
		$campaign_data = mysql_fetch_array($campaign_res);
		$campaign_arr = array("0"=>"רגיל","1"=>"גוגל","2"=>"FB");
		$campaign_data['main_campaign_str'] = $campaign_arr[$campaign_data['campaign_type']];
		$phones_payd_data['campaign'] = $campaign_data;
		
		$leads_by_phones_list[] = $phones_payd_data;
	}
	$result_arr['phone_lead_paid_count'] = $phones_payd_data['phones_count'];
	
		
	$sql = "SELECT distinct(".$select_view.") as 'result_view' FROM statistics_estimate_site where 1 ".$table_sql['statistics']['where']. " ORDER BY ".$select_view ;
	$res = mysql_db_query(DB, $sql);
	$cat_list = array();
	$cat_list['0'] = array('result_view'=>'0');
	while( $data = mysql_fetch_array($res) ){
		$cat_list[$data['result_view']] = $data;
	}
	if($select_view != 'domain'){
		$sql = "SELECT distinct(cat_f) as 'result_view' FROM estimate_form WHERE 1 " 
				 .$table_sql['estimate_form']['dates'].$table_sql['estimate_form']['get_cat'];
				
		$res = mysql_db_query(DB, $sql);
		while( $data = mysql_fetch_array($res) ){
			if($data['result_view'] != '0' && !isset($cat_list[$data['result_view']]) && $data['result_view']!=$_GET['father_cat'] && $data['result_view']!=$_GET['sub_cat']){
				$cat_list[$data['result_view']] = $data;	
			}			
		}	
	
		$sql = "SELECT distinct(cat_s) as 'result_view' FROM estimate_form WHERE 1 " 
				 .$table_sql['estimate_form']['dates'].$table_sql['estimate_form']['get_cat'];
				
		$res = mysql_db_query(DB, $sql);
		while( $data = mysql_fetch_array($res) ){
			if($data['result_view'] != '0' && !isset($cat_list[$data['result_view']]) && $data['result_view']!=$_GET['father_cat'] && $data['result_view']!=$_GET['sub_cat']){
				$cat_list[$data['result_view']] = $data;	
			}		
		}	
		
		$sql = "SELECT distinct(cat_spec) as 'result_view' FROM estimate_form WHERE 1 " 
				 .$table_sql['estimate_form']['dates'].$table_sql['estimate_form']['get_cat'];
				
		$res = mysql_db_query(DB, $sql);
		while( $data = mysql_fetch_array($res) ){
			if($data['result_view'] != '0' && !isset($cat_list[$data['result_view']]) && $data['result_view']!=$_GET['father_cat'] && $data['result_view']!=$_GET['sub_cat']){
				$sql = "SELECT father FROM biz_categories WHERE id = ".$data['result_view'];
				
				//$cat_list[$data['result_view']] = $data;		
				$res = mysql_db_query(DB, $sql);
				$data_father = mysql_fetch_array($res);
				if($data_father['father'] === $_GET[$select_view_before]){
					$cat_list[$data['result_view']] = $data;	
				}			
			}
		}
	}
	else{
		$sql = "SELECT distinct(domain) as 'result_view' FROM estimate_form ef 

				LEFT JOIN statistics_estimate_site ses ON ses.id = ef.statistic_id WHERE 1 " 
				 .$table_sql['estimate_form']['dates'].$table_sql['estimate_form']['get_cat'];
		$res = mysql_db_query(DB, $sql);
		while( $data = mysql_fetch_array($res) ){
			if($data['result_view'] != '0' && !isset($cat_list[$data['result_view']]) && $data['result_view']!=$_GET['father_cat'] && $data['result_view']!=$_GET['sub_cat']){
				$cat_list[$data['result_view']] = $data;	
			}			
		}		
	}
	foreach( $cat_list as $data){
		
		$result_view = $data['result_view'];
		$result_arr = array();
		
		if( $select_view != "domain" )
		{
			$sql = "SELECT cat_name,father FROM biz_categories WHERE id = $result_view ";
			$res_cat = mysql_db_query(DB, $sql);
			$data_cat = mysql_fetch_array($res_cat);
			if($data_cat['father'] != $get_cat && $result_view!="0"){
				continue;
			}
			$result_arr['view_name'] = $data_cat['cat_name'];
			$result_arr['view_name_full']= $result_arr['view_name']." (".$result_view.")";
			$result_arr['father'] = $data_cat['father'];
			
		}
		else{
			$result_arr['view_name'] = $result_view;
			$result_arr['view_name_full'] = $result_view;
			$result_arr['father'] = '';
		}
		$result_arr['url'] = $link_general_url."&$select_view=$result_view";		
		$link_target = "";

		
		if($select_view == 'domain'){
			$result_arr['url'] = "http://$result_view";
			$link_target = " target='_NEW' ";
		}
		$view_name_full = $result_arr['view_name_full'];
		$url_link = $result_arr['url'];
		$result_arr['url_link'] = "<a href='$url_link' $link_target>$view_name_full</a>";		
		$result_arr['unique_views'] = 0;
		$result_arr['unique_views_sub'] = 0;
		$result_arr['leads_by_views'] = 0;
		$result_arr['leads_by_forms'] = 0;
		$result_arr['views_leads_ratio'] = 0;
		$result_arr['customer_send'] = 0;
		$result_arr['leads_send_ratio'] = 0;

		if($select_view != 'domain'){
			$select_cat = $data['result_view'];
			$moreQry_L = " AND (father_cat = $select_cat OR sub_cat = $select_cat)  ";
		}
		else{
			
		}
		$sql = "SELECT COUNT(distinct ip) as unique_views FROM statistics_estimate_site where 1" 
			 .$table_sql['statistics']['dates'].$table_sql['statistics']['get_father_cat'].$has_gclid_sql.$is_mobile_sql.$page_id_sql." AND $select_view = '$result_view' ";
		$res_view = mysql_db_query(DB, $sql);
		$data_view = mysql_fetch_array($res_view);
		$result_arr['unique_views'] = $data_view['unique_views'];

		$sql = "SELECT COUNT(distinct ip) as unique_views FROM statistics_estimate_site where 1" 
			 .$table_sql['statistics']['dates'].$table_sql['statistics']['get_cat'].$has_gclid_sql.$is_mobile_sql.$page_id_sql." 
			 AND $select_view = '$result_view' GROUP BY $select_view_next";
		$res_view = mysql_db_query(DB, $sql);
		while($data_view = mysql_fetch_array($res_view)){
			$result_arr['unique_views_sub'] += $data_view['unique_views'];
		}


		$sql = "SELECT COUNT(id) as leads FROM statistics_estimate_site where 1" 
			 .$table_sql['statistics']['dates'].$table_sql['statistics']['get_cat'].$has_gclid_sql.$is_mobile_sql.$page_id_sql." 
			 AND $select_view = '$result_view' AND  sent_from = 1 ";

		$res_view = mysql_db_query(DB, $sql);
		$data_view = mysql_fetch_array($res_view);
		$result_arr['leads_by_views'] = $data_view['leads'];

		if($result_view != '0' && $select_view !='domain'){
			$sql = "SELECT COUNT(distinct statistic_id) as leads FROM estimate_form ef LEFT JOIN statistics_estimate_site ses ON ses.id= ef.statistic_id where 1" 
				 .$table_sql['estimate_form']['dates'].$table_sql['estimate_form']['get_cat'].$has_gclid_sql.$is_mobile_sql.$page_id_sql." 
				 AND (cat_f = '$result_view' OR cat_s = '$result_view' OR cat_spec = '$result_view')";
			
			$res_view = mysql_db_query(DB, $sql);
			$data_view = mysql_fetch_array($res_view);		
			$result_arr['leads_by_forms'] = $data_view['leads'];		
		}
		elseif($select_view != "father_cat" && $select_view !='domain'){
			$sql = "SELECT COUNT(distinct ef.statistic_id) as leads FROM estimate_form ef LEFT JOIN statistics_estimate_site ses ON ses.id= ef.statistic_id where 1" 
			 .$table_sql['estimate_form']['dates'].$table_sql['estimate_form']['get_cat'].$has_gclid_sql.$is_mobile_sql.$page_id_sql." 
			 AND father_cat = '0' AND sub_cat = '0' AND sent_from = 1";
			
			 $res_view = mysql_db_query(DB, $sql);
			 $data_view = mysql_fetch_array($res_view);	
			$leads_by_views_temp = $result_arr['leads_by_views'];			 
			$result_arr['leads_by_views_int'] = $data_view['leads'] + $leads_by_views_temp;
			$result_arr['leads_by_views'] = $leads_by_views_temp."+".$data_view['leads']."=".($leads_by_views_temp+$data_view['leads']);
			
		}
		elseif($select_view =='domain'){
			$sql = "SELECT COUNT(distinct ef.statistic_id) as leads FROM estimate_form ef LEFT JOIN statistics_estimate_site ses ON ses.id= ef.statistic_id where 1" 
			 .$table_sql['estimate_form']['dates'].$table_sql['estimate_form']['get_cat'].$has_gclid_sql.$is_mobile_sql.$page_id_sql." 
			 AND domain = '$result_view' AND sent_from = 1";
			$res_view = mysql_db_query(DB, $sql);
			$data_view = mysql_fetch_array($res_view);		
			$result_arr['leads_by_forms'] = $data_view['leads'];			 
		}
		if($result_view != '0' && $select_view !='domain'){
			$phones_payd_sql = "SELECT count(id) as phones_count FROM user_contact_forms WHERE unk IN(SELECT unk FROM users WHERE id IN(SELECT user_id FROM user_cat WHERE cat_id = $result_view)) AND lead_recource = 'phone' AND lead_billed = '1' AND status!='6' AND lead_billed = '1' AND date_in >= '$start_date' AND date_in <= '$end_date'";
			$phones_payd_res = mysql_db_query(DB,$phones_payd_sql);
			$phones_payd_data = mysql_fetch_array($phones_payd_res);
			$result_arr['phone_lead_paid_count'] = $phones_payd_data['phones_count'];
			
			$phones_all_sql = "SELECT count(id) as phones_count FROM user_contact_forms WHERE unk IN(SELECT unk FROM users WHERE id IN(SELECT user_id FROM user_cat WHERE cat_id = $result_view)) AND lead_recource = 'phone' AND lead_billed = '1' AND status!='6' AND lead_billed = '1' AND date_in >= '$start_date' AND date_in <= '$end_date'";
			$phones_all_res = mysql_db_query(DB,$phones_all_sql);
			$phones_all_data = mysql_fetch_array($phones_all_res);
			$result_arr['phone_lead_count'] = $phones_all_data['phones_count'];
		}
		elseif($select_view =='domain'){
			$phones_payd_sql = "SELECT count(id) as phones_count FROM user_contact_forms WHERE unk = (SELECT unk FROM users WHERE domain = '$result_view') AND lead_recource = 'phone' AND lead_billed = '1' AND status!='6' AND lead_billed = '1' AND date_in >= '$start_date' AND date_in <= '$end_date'";
			$phones_payd_res = mysql_db_query(DB,$phones_payd_sql);
			$phones_payd_data = mysql_fetch_array($phones_payd_res);
			$result_arr['phone_lead_paid_count'] = $phones_payd_data['phones_count'];
			
			$phones_all_sql = "SELECT count(id) as phones_count FROM user_contact_forms WHERE unk = (SELECT unk FROM users WHERE domain = '$result_view') AND lead_recource = 'phone' AND lead_billed = '1' AND status!='6' AND lead_billed = '1' AND date_in >= '$start_date' AND date_in <= '$end_date'";
			$phones_all_res = mysql_db_query(DB,$phones_all_sql);
			$phones_all_data = mysql_fetch_array($phones_all_res);
			$result_arr['phone_lead_count'] = $phones_all_data['phones_count'];
		}
		//customer send
		$sql_c_send = "SELECT COUNT(ucf.id) as sent_to FROM user_contact_forms ucf 
			LEFT JOIN estimate_form ef ON ucf.estimateFormID = ef.id 
			LEFT JOIN statistics_estimate_site ses ON ef.statistic_id = ses.id 
			WHERE 1 ".$page_id_sql." "
			.$table_sql['estimate_form']['dates'].$table_sql['estimate_form']['get_cat']
			."  AND $ef_select_view = '$result_view' AND  sent_from = 1 ";		
		
		$res_c_send = mysql_db_query(DB, $sql_c_send);
		$data_c_send = mysql_fetch_array($res_c_send);	
		$result_arr['customer_send'] = $data_c_send['sent_to'];
		
		
	
		$result_arr['views_leads_ratio'] = number_format(($result_arr['leads_by_views'] / $result_arr['unique_views'])*100,3)."%";
		
		$result_arr['leads_send_ratio'] = number_format(($result_arr['customer_send'] / $result_arr['leads_by_forms'])*100,3)."%";

		
		$result_view_list[$result_view] = $result_arr;

			
		$result_view_names[$result_arr['view_name_full']] = $result_view;
		
		if($result_view != '0' || $select_view == "father_cat"){
			
			$suming_arr['leads_by_forms'] += $result_arr['leads_by_forms'];
			$suming_arr['leads_by_views'] += $result_arr['leads_by_views']; 
		}
		else{
			$suming_arr['leads_by_views'] = $result_arr['leads_by_views_int']; 
		}
		$suming_arr['unique_views'] += $result_arr['unique_views']; 
		$suming_arr['unique_views_sub'] += $result_arr['unique_views_sub']; 

		$suming_arr['customer_send'] += $result_arr['customer_send'];		
		
	}
	$suming_arr['views_leads_ratio'] = round(($suming_arr['leads_by_views'] / $suming_arr['unique_views'])*100)."%";
	
	$suming_arr['leads_send_ratio'] = round(($suming_arr['customer_send'] / $suming_arr['leads_by_forms'])*100)."%";
	
	$result_view_list['sum_all'] = $suming_arr;

	$columns_view = array(
		'url_link'=>$select_view_name,
		'unique_views'=>'כניסות ייחודיות',
		'unique_views_sub'=>'כניסות ייחודיות לתת נושא',
		'leads_by_views'=>'לידים מתוך הצפיות',
		'leads_by_forms'=>'לידים על פי טפסים',
		'views_leads_ratio'=>'יחס בין כניסות ללידים',
		'customer_send'=>'שליחות ליד ללקוח',
		'leads_send_ratio'=>'יחס בין לידים לשליחות',
		
		'phone_lead_count'=>'שיחות ללקוחות בקטגוריה',
		'phone_lead_paid_count'=>'שיחות משולמות ללקוחות בקטגוריה',
	);
	$columns_view_count = count($columns_view);
	$columns_view_count_2 = $columns_view_count*2;
	echo "<form action='index.php' name='searchForm' method=get>";
	echo "<input type='hidden' name='main' value='estimate_statistics_list'>";
	echo "<input type='hidden' name='sesid' value='".SESID."'>";
	foreach($_GET as $key=>$val){
		if($key != 'main' && $key != 'sesid' && $key != 'start_date'
			&& $key != 'end_date' && $key != 'gclid_only'   && $key != 'fb_only' && $key != 'browser_type'){
			echo "<input type='hidden' name='$key' value='$val'>";
		}
	}
	

	
	
	echo "<table cellpadding=0 cellspacing=0 class=maintext>";
		echo "<tr>";
			echo "<td>מתאריך</td>";
			echo "<td width=10></td>";
			echo "<td><input type='text' name='start_date' value='".$_GET['start_date']."' class='input_style' style='width: 100px;'></td>";
			echo "<td width=30></td>";
			echo "<td>עד לתאריך</td>";
			echo "<td width=10></td>";
			echo "<td><input type='text' name='end_date' value='".$_GET['end_date']."' class='input_style'  style='width: 100px;' ></td>";
			echo "<td width=30></td>";
			$checked = "";
			if(isset($_GET['gclid_only'])){
				$checked = "checked";
			}
			echo "<td><input type='checkbox' name='gclid_only' value='1' class='' $checked>באו מגוגל</td>";
			echo "<td width=30></td>";
			$checked = "";
			if(isset($_GET['fb_only'])){
				$checked = "checked";
			}
			echo "<td><input type='checkbox' name='fb_only' value='1' class='' $checked>באו מפייסבוק</td>";
			echo "<td width=30></td>";			
			echo "<td>סוג מכשיר</td>";
			echo "<td width=10></td>";
			$browser_all_checked = "selected";
			$browser_desktop_checked = "";
			$browser_mobile_checked = "";
			if(isset($_GET['browser_type'])){
				if($_GET['browser_type'] != "all"){
					$browser_all_checked = "";
				}
				if($_GET['browser_type'] == "selected"){
					$browser_desktop_checked = "selected";
				}
				if($_GET['browser_type'] == "mobile"){
					$browser_mobile_checked = "selected";
				}
			}
			echo "<td>
			
					<select name='browser_type' class='input_style' style='width: 120px;'>
						<option value='all' $browser_all_checked>הכל</option>
						<option value='mobile' $browser_mobile_checked>מובייל</option>
						<option value='desktop' $browser_desktop_checked>מחשב</option>
					</select>			
			
			</td>";
			echo "<td width=30></td>";		
			echo "<td><input type='submit' class='submit_style' value='חפש'></td>";
		echo "</tr>";
	echo "</table>";
	echo "</form>";
	
	echo "<div style='padding:20px 0px;'><a href='$link_before_url'>$select_view_before_name</a>&nbsp;&nbsp;&nbsp;";
	
	if(!$view_domains_only){
		if($select_view == 'domain'){
			echo "<a href='$link_catview_url'>";
		}		
		echo "חלוקה לפי קטגוריות";
		if($select_view == 'domain'){
			echo "</a>";
		}	
	}	
	echo "&nbsp;&nbsp;&nbsp;";
	if($select_view != 'domain'){
		echo "<a href='$link_domainsview_url'>";
	}
	echo "חלוקה לפי דומיין";
	if($select_view != 'domain'){
		echo "</a>";
	}

	if($select_view != 'father_cat'){
		echo "&nbsp;&nbsp;<a href='$link_catview_url&view_pages=1'>";			
			echo "חלוקה לפי עמודים";		
		echo "</a>";
	}		
	echo "</div>";
	if($get_cat_name != ""){
		echo "<div><h2>$get_cat_name</h2></div>";
	}
	?>
	<h3>
		<a href='javascript://' onclick="open_list_view_table(this,'leads_by_views_list')" class="leads_list_table_door" rel="closed">רשימת לידים מצפייה(<?php echo count($leads_by_views_list); ?>)</a>&nbsp;&nbsp;
		<a href='javascript://' onclick="open_list_view_table(this,'leads_by_forms_list')" class="leads_list_table_door" rel="closed">רשימת לידים מטפסים(<?php echo count($leads_by_forms_list); ?>)</a>&nbsp;&nbsp;
		<a href='javascript://' onclick="open_list_view_table(this,'leads_by_phones_list')" class="leads_list_table_door" rel="closed">רשימת טלפונים(<?php echo count($leads_by_phones_list); ?>)</a>
	</h3>
	<style type="text/css">
		a.leads_list_table_door.open{color:gray !important; }
		.leads_list_table{margin:20px;border-collapse:collapse;}
	</style>
	<table border="1" class="leads_list_table" cellpadding="5" style='display:none;' id='leads_by_views_list'>
		<tr>
			<td colspan="10">לידים מצפיות</td>
		</tr>
		<tr>
			<th></th>
			<th>תאריך</th>
			<th>שם מלא</th>
			<th>אימייל</th>
			<th>טלפון</th>
			<th>הערה</th>
			<th>הגיע מעמוד</th>
		</tr>
		<?php $l_i=0; foreach($leads_by_views_list as $lead): $l_i++; ?>
			<tr>
				<td><?php echo $l_i; ?></td>
				<td><?php echo $lead['insert_date']; ?></td>
				<td><?php echo $lead['name']; ?></td>
				<td><?php echo $lead['email']; ?></td>
				<td><?php echo $lead['phone']; ?></td>
				<td><?php echo $lead['note']; ?></td>
				<td><a href="<?php echo $lead['extra']['referrer']; ?>"><?php echo iconv("UTF-8","Windows-1255",urldecode($lead['extra']['referrer'])); ?></a></td>
			</tr>
		<?php endforeach; ?>
	</table>
	<table border="1" class="leads_list_table" cellpadding="5" style='display:none;' id='leads_by_forms_list'>
		<tr>
			<td colspan="10">לידים מטפסים</td>
		</tr>
		<tr>
			<th></th>
			<th>תאריך</th>
			<th>שם מלא</th>
			<th>אימייל</th>
			<th>טלפון</th>
			<th>הערה</th>
			<th>הגיע מעמוד</th>
		</tr>
		<?php  $l_i=0; foreach($leads_by_forms_list as $lead):  $l_i++; ?>
			<tr>
				<td><?php echo $l_i; ?></td>
				<td><?php echo $lead['insert_date']; ?></td>
				<td><?php echo $lead['name']; ?></td>
				<td><?php echo $lead['email']; ?></td>
				<td><?php echo $lead['phone']; ?></td>
				<td><?php echo $lead['note']; ?></td>
				<td><a href="<?php echo $lead['extra']['referrer']; ?>"><?php echo iconv("UTF-8","Windows-1255",urldecode($lead['extra']['referrer'])); ?></a></td>
			</tr>
		<?php endforeach; ?>
	</table>
	<table border="1" class="leads_list_table" cellpadding="5" style='display:none;' id='leads_by_phones_list'>
		<tr>
			<td colspan="10">רשימת טלפונים</td>
		</tr>
		<tr>
			<th></th>
			<th>תאריך</th>
			<th>טלפון</th>
			<th>לקוח</th>
			<th>מספר יעד</th>
			<th>סוג קמפיין</th>
			<th>שם קמפיין</th>
			<th>הפך לליד</th>
		</tr>
		<?php $l_i=0; foreach($leads_by_phones_list as $lead): $l_i++; ?>
			<tr>
				<td><?php echo $l_i; ?></td>
				<td><?php echo $lead['date_in']; ?></td>
				<td><?php echo $lead['phone']; ?></td>
				<td><?php echo $lead['user']['name']; ?></td>
				<td><?php echo $lead['number']['did']; ?></td>
				<td><?php echo $lead['campaign']['main_campaign_str']; ?></td>
				<td><?php echo $lead['campaign']['campaign_name']; ?></td>
				<?php
					$miscall_sql = "SELECT show_in_misscalls_table FROM  user_lead_settings WHERE unk = '".$lead['unk']."'";
					$miscall_res = mysql_db_query(DB,$miscall_sql);
					$miscall_data = mysql_fetch_array($miscall_res);
					if($miscall_data['show_in_misscalls_table'] == '1'){
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
					else{
						$lead['has_ef'] = true;
						$lead['has_ef_str'] = "לקוח לא ברשימה";
						$lead['has_ef_bg'] = "#ffffff";											
					}
				?>
				<td style='background:<?php echo $lead['has_ef_bg']; ?>'><?php echo $lead['has_ef_str']; ?></td>
				
			</tr>
		<?php endforeach; ?>
	</table>	
	<script type="text/javascript">
		function open_list_view_table(el_id,table_id){
			jQuery(function($){
				$(".leads_list_table").hide();
				$(".leads_list_table_door").removeClass("open");
				if($(el_id).attr("rel") == "closed"){
					$("#"+table_id).show();
					$(".leads_list_table_door").attr("rel","closed");
					$(el_id).attr("rel","open");
					$(el_id).addClass("open");
				}
				else{
					$(el_id).attr("rel","closed");
				}
			});
		}
	</script>
	<?php	
	echo "<table cellpadding=0 cellspacing=0 class=maintext>";
		echo "<tr>";
			foreach($columns_view as $key=>$th_headline){
				echo "<th>".$th_headline."</th>";
				echo "<td width=10></td>";
			}
		echo "</tr>";
		foreach($result_view_list as $key=>$result_arr){
			$border = "style='border-bottom: 1px solid #cccccc;'";
			
			
			
			
			echo "<tr><td colspan=$columns_view_count_2 height=5></td></tr>";
			echo "<tr>";
				foreach($columns_view as $key=>$th_headline){
					echo "<td>".$result_arr[$key]."</td>";
					echo "<td width=10></td>";
				}
			echo "</tr>";
			echo "<tr><td $border colspan=$columns_view_count_2 height=5></td></tr>";
		}
			
	echo "</table>";
}


function estimate_statistics_list_pages(){

	$table_sql = array();
	$table_sql['estimate_form'] = array();
	$table_sql['statistics'] = array();

	$start_date_str = date('d-m-Y');
	$end_date_str = date('d-m-Y');

	if( $_GET['start_date'] != "" ) 
	{
		$start_date_str = $_GET['start_date'];
	}
	else{
		$_GET['start_date'] = $start_date_str;
	}
	
	if( $_GET['end_date'] != "" ) 
	{
		$end_date_str = $_GET['end_date'];
	}
	else{
		$_GET['end_date'] = $end_date_str;
	}	

	$exp_start_date = explode("-" , $start_date_str);
	$start_date = $exp_start_date[2]."-".$exp_start_date[1]."-".$exp_start_date[0];
	
	$exp_end_date = explode("-" , $end_date_str);
	$end_date_temp = $exp_end_date[2]."-".$exp_end_date[1]."-".$exp_end_date[0];	
	$end_date = date('Y-m-d', strtotime($end_date_temp. ' + 1 day'));


	if( $_GET['father_cat'] != "" ){
		$get_cat = $_GET['father_cat'];
		$table_sql['estimate_form']['get_father_cat'] .= " AND (cat_f = $get_cat OR cat_s = $get_cat OR cat_spec = $get_cat) ";
		$table_sql['statistics']['get_father_cat'] .= " AND (father_cat = $get_cat OR sub_cat = $get_cat)  ";			
	}
	
	if( $_GET['sub_cat'] != "" ){
		$get_cat = $_GET['sub_cat'];
		$table_sql['estimate_form']['get_sub_cat'] .= " AND (cat_f = $get_cat OR cat_s = $get_cat OR cat_spec = $get_cat) ";
		$table_sql['statistics']['get_sub_cat'] .= " AND (father_cat = $get_cat OR sub_cat = $get_cat)  ";		
	}
	$sql = "SELECT cat_name FROM biz_categories WHERE id = $get_cat";
	$res = mysql_db_query(DB, $sql);
	$data = mysql_fetch_array($res);	
	$get_cat_name = $data['cat_name'];
	
	$sql = "SELECT distinct(referrer) as page FROM statistics_estimate_site ses 
			LEFT JOIN statistics_estimate_site_extra  ex ON ex.stat_id = ses.id 
			WHERE ses.date >= '$start_date' AND ses.date <= '$end_date' ".$table_sql['statistics']['get_father_cat'].$table_sql['statistics']['get_sub_cat'];	
	//echo $sql;
	$res = mysql_db_query(DB, $sql);
	$pages = array();
	$pages_arr = array();
	while( $data = mysql_fetch_array($res) ){
		
		//echo "<br><br><br>---<br><br><br>";
		$page_a = explode("?gclid",$data['page']);
		$page_b = str_replace("http://","",$page_a[0]);
		$page_b = str_replace("https://","",$page_b);
		$page_b = str_replace("www.","",$page_b);
		$page_arr = explode("/",$page_b);
		$page = trim($page_arr[0])."/".trim($page_arr[1]);
		if(isset($page_arr[2])){
			$page .="/";
		}
		$pages_arr[$page] = $page;
	}
	foreach($pages_arr as $page){
		$page_data = array();
		$sql_p = "SELECT count(distinct(ip)) as unique_views FROM statistics_estimate_site ses 
				LEFT JOIN statistics_estimate_site_extra  ex ON ex.stat_id = ses.id 
				WHERE ses.date >= '$start_date' AND ses.date <= '$end_date' ".$table_sql['statistics']['get_father_cat'].$table_sql['statistics']['get_sub_cat']." 
				AND referrer LIKE('%$page%') ";	
		
		$res_p = mysql_db_query(DB, $sql_p);
		
		$data_p = mysql_fetch_array($res_p);	
		
		$page_data['unique_views'] = $data_p['unique_views'];
		
		$sql_p = "SELECT count(distinct(ip)) as leads_by_views FROM statistics_estimate_site ses 
				LEFT JOIN statistics_estimate_site_extra  ex ON ex.stat_id = ses.id 
				WHERE sent_from = 1 AND ses.date >= '$start_date' AND ses.date <= '$end_date' ".$table_sql['statistics']['get_father_cat'].$table_sql['statistics']['get_sub_cat']." 
				AND referrer LIKE('%$page%') ";	
		
		$res_p = mysql_db_query(DB, $sql_p);
		
		$data_p = mysql_fetch_array($res_p);		
		$page_data['leads_by_views'] = $data_p['leads_by_views'];
		
		$url_view = urldecode($page);
		$url_view = iconv("UTF-8","Windows-1255",$url_view);
		if($url_view == "/" || $url_view == ""){
			$url_view = $page;
		}
		$page_data['url_link'] = "<a href='http://$page' style='direction:ltr;'>--$url_view--</a>"; 
		$pages[$page] = $page_data;	
		//echo "++".$page."<br/>";	
	
	}
	echo "<form action='index.php' name='searchForm' method=get>";
	echo "<input type='hidden' name='main' value='estimate_statistics_list'>";
	echo "<input type='hidden' name='sesid' value='".SESID."'>";
	foreach($_GET as $key=>$val){
		if($key != 'main' && $key != 'sesid' && $key != 'start_date' && $key != 'end_date'){
			echo "<input type='hidden' name='$key' value='$val'>";
		}
	}	
	echo "<table cellpadding=0 cellspacing=0 class=maintext>";
		echo "<tr>";
			echo "<td>מתאריך</td>";
			echo "<td width=10></td>";
			echo "<td><input type='text' name='start_date' value='".$_GET['start_date']."' class='input_style' style='width: 100px;'></td>";
			echo "<td width=30></td>";
			echo "<td>עד לתאריך</td>";
			echo "<td width=10></td>";
			echo "<td><input type='text' name='end_date' value='".$_GET['end_date']."' class='input_style'  style='width: 100px;' ></td>";
			echo "<td width=30></td>";
			echo "<td><input type='submit' class='submit_style' value='חפש'></td>";
		echo "</tr>";
	echo "</table>";
	echo "</form>";
	
	echo "<div style='padding:20px 0px;'>&nbsp;&nbsp;&nbsp;";
	$link_catview_url = "index.php?";

	$get_index_catview = 0;
	foreach($_GET as $key=>$val){

		if($key != 'view_domains' && $key != 'view_pages'){
				if($get_index_catview != 0){
				$link_catview_url .="&";
			}
			$link_catview_url .="$key=$val";
			$get_index_catview++;
		}	

	}
	
	echo "<a href='$link_catview_url'>";			
		echo "חלוקה לפי קטגוריות";		
	echo "</a>";

	//echo "<a href='$link_catview_url&view_pages=1'>";			
		echo "&nbsp;&nbsp;"."חלוקה לפי עמודים";		
	//echo "</a>";	
	
	echo "</div>";
	if($get_cat_name != ""){
		echo "<div><h2>$get_cat_name</h2></div>";
	}

	$columns_view = array(
		'url_link'=>'עמוד',
		'unique_views'=>'כניסות ייחודיות',
		'leads_by_views'=>'לידים מתוך הצפיות',
		'views_leads_ratio'=>'יחס בין כניסות ללידים',
	);
	$columns_view_count = count($columns_view);
	$columns_view_count_2 = $columns_view_count*2;	
	echo "<table cellpadding=0 cellspacing=0 class=maintext style='direction:ltr;text-align:left;'>";
		echo "<tr>";
			foreach($columns_view as $key=>$th_headline){
				echo "<th>".$th_headline."</th>";
				echo "<td width=10></td>";
			}
		echo "</tr>";
		
		foreach($pages as $key=>$result_arr){
			
			$border = "style='border-bottom: 1px solid #cccccc;'";
			
			
			
			
			echo "<tr><td colspan=$columns_view_count_2 height=5></td></tr>";
			echo "<tr>";
				foreach($columns_view as $key=>$th_headline){
					echo "<td>".$result_arr[$key]."</td>";
					echo "<td width=10></td>";
				}
			echo "</tr>";
			echo "<tr><td $border colspan=$columns_view_count_2 height=5></td></tr>";
		}
			
	echo "</table>";	
}

