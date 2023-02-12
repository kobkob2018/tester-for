<?php

function estimate_stat_list_check(){
	$sql = "SELECT 
				ses.domain,ses.date,ses.ip,ses.father_cat,ses.sub_cat,ses.sent_from, 
				sx.referrer,sx.estimate_id,sx.city_id
			FROM statistic_estimate_site ses LEFT JOIN statistic_estimate_site_extra sx 
			ON sx.stat_id = ses.id 
			WHERE ses.date >= '".$_GET['start_date']."' 
			AND  ses.date <= '".$_GET['end_date']."' 
			ORDER BY ses.id desc LIMIT 100
			";
			echo $sql;
	$res = mysql_db_query(DB,$sql);
	$biz_cats = array();
	$catSql = "SELECT id,father,cat_name FROM biz_categories WHERE status = 1";
	$catRes = mysql_db_query(DB,$catSql);
	while($cat = mysql_fetch_array($catRes)){
		$biz_cats[$cat['id']] = array('name'=>$cat['cat_name'],'father'=>$cat['father']);
	}
	$i = 0;
	?>
		<table dir='ltr' cellpadding=10 cellspacing=0 border=1 class=maintext bordercolor='#EDEBE9'>
			<tr>
				<th></th>
				<th>א</th>
				<th>ב</th>
				<th></th>
				<th>זמן</th>
				<th>דומיין</th>
				<th>IP</th>
				<th>נשלח מ</th>
				<th>מפנה</th>
				<th>estimate_id</th>
				<th>עיר</th>
			</tr>
			<?php
				while($est_data = mysql_fetch_array($res)){
					?>
					<tr>
					<td><?php echo $i++; ?></td>
						<td dir="rtl"><?php echo $biz_cats[$est_data['father_cat']]['name']; ?>
							[<?php echo $est_data['father_cat']; ?>]
							<br/>
							(
								<?php echo $biz_cats[$biz_cats[$est_data['father_cat']]['father']]['name']; ?>
								[<?php echo $biz_cats[$est_data['father_cat']]['father']; ?>]
							)
						</td>
						<td dir="rtl"><?php echo $biz_cats[$est_data['sub_cat']]['name']; ?>
							[<?php echo $est_data['sub_cat']; ?>]
							<br/>
							(
								<?php echo $biz_cats[$biz_cats[$est_data['sub_cat']]['father']]['name']; ?>
								[<?php echo $biz_cats[$est_data['sub_cat']]['father']; ?>]
							)
						</td>
						<td>
							<?php 
								if($biz_cats[$est_data['sub_cat']]['father'] != $est_data['father_cat']){
									echo "1";
								}
								else{
									echo "0";
								}
								?>
								   -   
							<?php 
								if($biz_cats[$est_data['father_cat']]['father'] != "0"){
									echo "1";
								}
								else{
									echo "0";
								}
								?>								   
						</td>
						<td><?php echo $est_data['date']; ?></td>
						<td><?php echo $est_data['domain']; ?></td>
						<td><?php echo $est_data['ip']; ?></td>
						<td><?php echo $est_data['sent_from']; ?></td>
						<td><?php echo iconv("UTF-8","Windows-1255",urldecode($est_data['referrer'])); ?></td>
						<td><?php echo $est_data['estimate_id']; ?></td>
						<td><?php echo $est_data['city_id']; ?></td>
					</tr>
					<?php
				}
			?>
		</table>
	
	
	<?php
}


function estimate_stat_view_all()
{
	$start_date = ( $_GET['start_date'] == "" ) ? date('Y-m-d') : $_GET['start_date'];
	if(!isset($_GET['start_date'])){
		$_GET['start_date'] = date("Y-m-d",strtotime("today"));
	}
	if(!isset($_GET['end_date'])){
		$_GET['end_date'] = date("Y-m-d",strtotime("tomorrow"));
	}	
	
	$end_date = "AND date <= '".$_GET['end_date']."'";
	$start_date =  "AND date >= '".$_GET['start_date']."'";
	
	echo "<table cellpadding=0 cellspacing=0 class=maintext>";
		echo "<tr>";
			echo "<td colspan=11><h3>רשימת תצוגות טופס</h3></td>";
		echo "</tr>";
		
		echo "<tr>";
			echo "<td colspan=11>".$back_to_list."</td>";
		echo "</tr>";
		
		echo "<tr>";
			echo "<td colspan=11>";
				echo "<form action='index.php' name='searchForm' method=get>";
				echo "<input type='hidden' name='main' value='estimate_stat_view_all'>";
				echo "<input type='hidden' name='sesid' value='".SESID."'>";
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
						echo "<td>ip</td>";
						echo "<td width=10></td>";
						echo "<td><input type='text' name='ip' value='".$_GET['ip']."' class='input_style'  style='width: 100px;' ></td>";

						echo "<td width=30></td>";
						echo "<td><input type='submit' class='submit_style' value='חפש'></td>";
					echo "</tr>";
				echo "</table>";
				echo "</form>";
			echo "</td>";
		echo "</tr>";
	echo "</table>";
}
function estimate_stat_list()
{
	if(isset($_GET['checker'])){
		return estimate_stat_view_all();
	}
	$start_date = ( $_GET['start_date'] == "" ) ? date('Y-m-d') : $_GET['start_date'];
	
	if( $_GET['end_date'] != "" ) 
	{
		$exp_end_date = explode("-" , $_GET['end_date']);
		$temp_date = date("Y-m-d" , mktime( 0, 0, 0, $exp_end_date[1] , $exp_end_date[2]+1 , $exp_end_date[0] ) );
	}
	
	$end_date = ( $_GET['end_date'] == "" ) ? "" : "AND date <= '".$temp_date."'";
	
	
	if( $_GET['sub_cat'] != "" )
	{
		$select_view = "domain";
		$more_qry = "AND sub_cat = '".$_GET['sub_cat']."' AND father_cat = '".$_GET['father_cat']."' ";
		$th_headline = "דומיין";
		$back_to_list = "<a href='index.php?main=estimate_stat_list&father_cat=".$_GET['father_cat']."&sesid=".SESID."' class='maintext'>לקטגוריות משניות</a>";
	}
	elseif( $_GET['father_cat'] != "" )
	{
		$select_view = "sub_cat";
		$more_qry = "AND father_cat = '".$_GET['father_cat']."' ";
		$th_headline = "קטגוריה משנית";
		$back_to_list = "<a href='index.php?main=estimate_stat_list&sesid=".SESID."' class='maintext'>לקטגוריות הראשיות</a>";
	}
	else
	{
		$select_view = "father_cat";
		$more_qry = "";
		$th_headline = "קטגוריה ראשית";
		$back_to_list = "";
	}
	
	$sql = "SELECT DATE_FORMAT(date,'%d-%m-%Y') as new_date, ".$select_view."  FROM statistic_estimate_site where date >= '".$start_date."' ".$end_date." ".$more_qry." GROUP BY ".$select_view."";
	$res = mysql_db_query(DB, $sql);
	
	echo "<table cellpadding=0 cellspacing=0 class=maintext>";
		echo "<tr>";
			echo "<td colspan=11><h3>סטטיסטיקה של אתרי השוואות מחיר</h3></td>";
		echo "</tr>";
		
		echo "<tr>";
			echo "<td colspan=11>".$back_to_list."</td>";
		echo "</tr>";
		
		echo "<tr>";
			echo "<td colspan=11>";
				echo "<form action='index.php' name='searchForm' method=get>";
				echo "<input type='hidden' name='main' value='estimate_stat_list'>";
				echo "<input type='hidden' name='sesid' value='".SESID."'>";
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
			echo "</td>";
		echo "</tr>";
		
		echo "<tr>";
			echo "<th>".$th_headline."</th>";
			echo "<td width=10></td>";
			echo "<th>כניסות יחודיות</th>";
			echo "<td width=10></td>";
			echo "<th>לידים</th>";
			echo "<td width=10></td>";
			echo "<th>יחס בין כניסות ללידים</th>";
			echo "<td width=10></td>";
			echo "<th>שליחות ליד ללקוח</th>";
			echo "<td width=10></td>";
			echo "<th>יחס בין לידים לשליחות</th>";
		echo "</tr>";
			
		$sum_view = 0;
		$sum_leads = 0;
		$sum_estimate = 0;
		
		while( $data = mysql_fetch_array($res) )
		{
			$exp_date = explode( "-" , $data['new_date'] );
			$new_ex_date = $exp_date[2]."-".$exp_date[1]."-".$exp_date[0];
			
			if( $_GET['sub_cat'] != "" )
			{
				$urlLink = "http://".$data['domain'];
				$moreQry_L = " AND father_cat = '".$_GET['father_cat']."'";
			}
			elseif( $_GET['father_cat'] != "" )
			{
				$urlLink = "index.php?main=estimate_stat_list&start_date=".$_GET['start_date']."&end_date=".$_GET['end_date']."&sub_cat=".$data['sub_cat']."&father_cat=".$_GET['father_cat']."&sesid=".SESID."";
				$moreQry_L = " AND father_cat = '".$_GET['father_cat']."' ";
				$cat_qry = "father = '".$_GET['father_cat']."' and id = '".$data['sub_cat']."' ";
			}
			else
			{
				$urlLink = "index.php?main=estimate_stat_list&start_date=".$_GET['start_date']."&end_date=".$_GET['end_date']."&father_cat=".$data['father_cat']."&sesid=".SESID."";
				$moreQry_L = "";
				$cat_qry = "id = '".$data['father_cat']."'";
			}
			
			if( $select_view != "domain" )
			{
				$sql = "SELECT cat_name FROM biz_categories WHERE ".$cat_qry." ";
				$res_cat = mysql_db_query(DB, $sql);
				$data_cat = mysql_fetch_array($res_cat);
			}
			
			if( $_GET['sub_cat'] != "" )
			{
				$linkName = stripslashes($data['domain']);
			}
			elseif( $_GET['father_cat'] != "" )
			{
				$linkName = stripslashes($data_cat['cat_name']);
			}
			else
			{
				$linkName = stripslashes($data_cat['cat_name']);
			}
			
			if( $select_view != "domain" )
			{
				$sql = "SELECT cat_name FROM biz_categories WHERE ".$cat_qry." ";
				$res_cat = mysql_db_query(DB, $sql);
				$data_cat = mysql_fetch_array($res_cat);
			}
			
			$sql = "SELECT COUNT(distinct ip) as unique_views FROM statistic_estimate_site where
				 date >= '".$new_ex_date."' AND 
				 ".$select_view." = '".$data[$select_view]."' ".$moreQry_L."
				 GROUP BY ".$select_view."";
			$res_view = mysql_db_query(DB, $sql);
			$data_view = mysql_fetch_array($res_view);
			
			$sql = "SELECT COUNT(distinct ip) as leads FROM statistic_estimate_site where
				 date >= '".$new_ex_date."' AND 
				 sent_from = 1 AND
				 ".$select_view." = '".$data[$select_view]."' ".$moreQry_L."
				 GROUP BY ".$select_view."";
			$res_leads = mysql_db_query(DB, $sql);
			$data_leads = mysql_fetch_array($res_leads);
			
			$sql = "SELECT COUNT(distinct ip) as estimate FROM statistic_estimate_site as t1 , statistic_estimate_site_extra as t2 where
				 t1.date >= '".$new_ex_date."' AND 
				 t1.sent_from = 1 AND
				 t1.".$select_view." = '".$data[$select_view]."' ".$moreQry_L." AND
				 t1.id=t2.stat_id AND
				 t2.estimate_id IS NOT NULL
				 GROUP BY t1.".$select_view."";
			$res_estimate = mysql_db_query(DB, $sql);
			$data_estimate = mysql_fetch_array($res_estimate);
			
			$precent = ($data_leads['leads'] / $data_view['unique_views'])*100;
			$precent_estimate = ($data_estimate['estimate'] / $data_leads['leads'])*100;
			
			$border = "style='border-bottom: 1px solid #cccccc;'";
			
			
			
			
			echo "<tr><td colspan=11 height=5></td></tr>";
			echo "<tr>";
				echo "<td ".$border."><a href='".$urlLink."' class='maintext' >&nbsp;".$linkName."</a></td>";
				echo "<td ".$border." width=10>&nbsp;</td>";
				echo "<td ".$border." style='border-bottom: 1px solid #cccccc;' align=center>&nbsp;".$data_view['unique_views']."</td>";
				echo "<td ".$border." width=10>&nbsp;</td>";
				echo "<td ".$border." align=center>&nbsp;".$data_leads['leads']."</td>";
				echo "<td ".$border." width=10>&nbsp;</td>";
				echo "<td ".$border." align=center>&nbsp;".round($precent,2)."%</td>";
				echo "<td ".$border." width=10>&nbsp;</td>";
				echo "<td ".$border." align=center>&nbsp;".$data_estimate['estimate']."</td>";
				echo "<td ".$border." width=10>&nbsp;</td>";
				echo "<td ".$border." align=center>&nbsp;".round($precent_estimate,2)."%</td>";
			echo "</tr>";
			
			$sum_view = $sum_view + $data_view['unique_views'];
			$sum_leads = $sum_leads + $data_leads['leads'];
			$sum_estimate = $sum_estimate + $data_estimate['estimate'];
		}
		
		$precent_all = ($sum_leads / $sum_view)*100;
		$precent_all_estimate = ($sum_estimate / $sum_leads)*100;
		
		echo "<tr>";
			echo "<td></td>";
			echo "<td width=10></td>";
			echo "<td align=center>".$sum_view."</td>";
			echo "<td width=10></td>";
			echo "<td align=center>".$sum_leads."</td>";
			echo "<td width=10></td>";
			echo "<td align=center>".round($precent_all,2)."%</td>";
			echo "<td width=10></td>";
			echo "<td align=center>".$sum_estimate."</td>";
			echo "<td width=10></td>";
			echo "<td align=center>".round($precent_all_estimate,2)."%</td>";
		echo "</tr>";
	
	
	echo "</table>";
}


function estimate_stats_by_groups()
{
	$where = "";
	$history = ( isset($_GET['history']) && $_GET['history'] != "" ) ? $_GET['history'] : "";
	$default_history = array();
	
	if( isset($_GET['filter_s_date']) && $_GET['filter_s_date'] != "" )
		$_GET['filter_s_date'] = $_GET['filter_s_date'];
	else
	{
		$_GET['filter_s_date'] = date('01-m-Y');
		$default_history[] = "filter_s_date";
	}
	
	if( isset($_GET['filter_e_date']) && $_GET['filter_e_date'] != "" )
		$_GET['filter_e_date'] = $_GET['filter_e_date'];
	else
	{
		$_GET['filter_e_date'] = date('d-m-Y');
		$default_history[] = "filter_e_date";
	}
	
	$exp_history = explode("|" , $_GET['history'] );
	for( $i=0 ; $i < sizeof($exp_history) ; $i++ )
	{
		$exp_history_p = explode("--" , $exp_history[$i] );
		$param_n = $exp_history_p[0];
		$_GET[$param_n] = $exp_history_p[1];
	}
	
	
	foreach( $_GET as $k => $v )
	{
		if( strpos($k, "filter_" ) !== false )
		{
			switch($k)
			{
				case "filter_s_date" :
					$date_s = ( isset($_GET[$k]) && $_GET[$k] != "" ) ? explode( "-" , $v ) : "";
					if( strlen($date_s[0]) == 2  )
						$v = ( isset($_GET[$k]) && $_GET[$k] != "" ) ? $date_s[2]."-".$date_s[1]."-".$date_s[0] : "";
					
					$filter_remove = str_replace("filter_s_" , "" , $k );
					$where .= " AND ".mysql_real_escape_string($filter_remove) . " >= '" . mysql_real_escape_string($v) . "'";
				break;
				
				case "filter_e_date" :
					$date_s = ( isset($_GET[$k]) && $_GET[$k] != "" ) ? explode( "-" , $v ) : "";
					if( strlen($date_s[0]) == 2  )
						$v = ( isset($_GET[$k]) && $_GET[$k] != "" ) ? $date_s[2]."-".$date_s[1]."-".$date_s[0] : "";
					
					$filter_remove = str_replace("filter_e_" , "" , $k );
					$where .= " AND ".mysql_real_escape_string($filter_remove) . " <= '" . mysql_real_escape_string($v) . "'";
				break;
				
				default :
					$filter_remove = str_replace("filter_" , "" , $k );
					$where .= " AND ".mysql_real_escape_string($filter_remove) . " = '" . mysql_real_escape_string($v) . "'";
			}
			
			if( !in_array($k , $default_history) )
				$history .= "|".$k."--".$v;
		}
	}
	
	
	$group_by = ( isset($_GET['group']) && $_GET['group'] != "" ) ? $_GET['group'] : "date";
	
	$group_by_arr = array(
		'date' => "תאריך",
		'hour' => "שעה",
		'cat' => "קטגוריה",
		'tat_cat' => "קטגוריה משנית",
		'spec_cat' => "התמחות",
		'domain' => "דומיין",
		'url_page' => "דף",
		'referrer_domain' => "הגיע מדומיין",
		'referrer_full_url' => "הגיע מדף",
		'receive_type' => "סוג ליד",
		'mobile_source' => "תצוגה מ",
		'client_unk' => "לקוח",
		'auto_send' => "ליד נשלח אוטומטית",
	);
	
	$receive_type_arr[0] = "ליד דרך טופס";
	$receive_type_arr[1] = "ליד טלפוני";
	
	$mobile_source_arr[0] = "לא ידוע";
	$mobile_source_arr[1] = "נייד";
	$mobile_source_arr[2] = "שולחן עבודה";
	
	$auto_send_arr[0] = "לא נשלח אוטומטי";
	$auto_send_arr[1] = "נשלח אוטומטי";
	
	$border_c = "666666";
	
	$sql = "SELECT 
								SUM(page_view) AS page_num , SUM(leads) AS leads_num , SUM(client_received) AS client_received_num ,
								SUM(u_leads) AS u_leads_num , SUM(u_client_received) AS u_client_received_num , ".mysql_real_escape_string($group_by)." 
					FROM estimate_stats
					WHERE 1
								".$where."
					GROUP BY ".mysql_real_escape_string($group_by)."
					ORDER BY ".mysql_real_escape_string($group_by)." 
					";
	$res = mysql_db_query(DB, $sql);
	
	echo "<table cellpadding=10 cellspacing=0 border=0 class=maintext bordercolor='#EDEBE9'>";
		echo "<tr>";
			echo "<td colspan=11><h3>סטטיסטיקה - טפסי השוואת מחירים רוחבי</h3></td>";
		echo "</tr>";
		
		echo "<tr>";
			echo "<td colspan=11><a href='index.php?sesid=".SESID."'>חזרה לתפריט הראשי</a></td>";
		echo "</tr>";
		
		echo "<tr>";
			echo "<td colspan=11>";
				echo "<form action='index.php' method='get' name=''>";
				echo "<input type='hidden' name='main' value='estimate_stats_by_groups'>";
				echo "<input type='hidden' name='sesid' value='".SESID."'>";
				echo "<table cellpadding=10 cellspacing=0 border=0 class=maintext>";
					echo "<tr>";
						echo "<td>תאריך התחלת דוח</td>";
						echo "<td with=10></td>";
						echo "<td><input type='text' name='filter_s_date' value='".$_GET['filter_s_date']."' class='input_style' style='width: 120px;'></td>";
						
						echo "<td width=30></td>";
						
						echo "<td>תאריך סיום דוח</td>";
						echo "<td with=10></td>";
						echo "<td><input type='text' name='filter_e_date' value='".$_GET['filter_e_date']."' class='input_style' style='width: 120px;'></td>";
						
						echo "<td width=30></td>";
						
						echo "<td><input type='submit' value='חפש' class='input_style' style='width: 100px;'></td>";
						
					echo "</tr>";
				echo "</table>";
				echo "</form>";
			echo "</td>";
		echo "</tr>";
		
		echo "<tr>";
			echo "<td><b>חיתוך לפי ".$group_by_arr[$group_by]."</b></td>";
			echo "<td style='border-left: 1px solid #".$border_c."; border-right: 1px solid #".$border_c.";'><b>תצוגות טופס</b></td>";
			echo "<td><b>כמות לידים כפולים<br>(% מצפיות)</b></td>";
			echo "<td style='border-left: 1px solid #".$border_c.";'><b>כמות לידים כפולים<br>שנשלחו ללקוח<br>(% מצפיות)</b></td>";
			echo "<td><b>כמות לידים יחודיים<br>(% מצפיות)</b></td>";
			echo "<td style='border-left: 1px solid #".$border_c.";'><b>כמות לידים יחודיים<br>שנשלחו ללקוח<br>(% מצפיות)</b></td>";
			echo "<td><b>אחוז שליחת<br>לידים יחודיים</b></td>";
			echo "<td><b>חיתוך לפי</b></td>";
		echo "</tr>";
		
		$count = 0;
		while( $data = mysql_fetch_array($res) )
		{
			$group_var_name = "";
			$data_group_by = $data[$group_by];
			switch($group_by)
			{
				case "cat" :		
				case "tat_cat" :
				case "spec_cat" :
					$sqlP = "SELECT cat_name FROM biz_categories WHERE id = '".$data_group_by."' ";
					$resP = mysql_db_query(DB, $sqlP);
					$dataP = mysql_fetch_array($resP);
					
					$group_var_name = $dataP['cat_name'];
				break;
				
				case "receive_type" :	
					$group_var_name = $receive_type_arr[$data_group_by];
				break;
				
				case "mobile_source" :		
					$group_var_name = $mobile_source_arr[$data_group_by];
				break;
				
				case "client_unk" :		
					$sqlP = "SELECT name FROM users WHERE unk = '".$data_group_by."' ";
					$resP = mysql_db_query(DB, $sqlP);
					$dataP = mysql_fetch_array($resP);
					
					$group_var_name = $dataP['name'];
				break;
				
				case "auto_send" :		
					$group_var_name = $auto_send_arr[$data_group_by];
				break;
			}
			
			$pec1 = ( $data['page_num'] > 0 ) ? number_format(($data['leads_num'] / $data['page_num']) * 100) ."%" : "0%";
			$pec2 = ( $data['page_num'] > 0 ) ? number_format(($data['client_received_num'] / $data['page_num']) * 100)."%" : "0%";
			$pec_u1 = ( $data['page_num'] > 0 ) ? number_format(($data['u_leads_num'] / $data['page_num']) * 100) ."%" : "0%";
			$pec_u2 = ( $data['page_num'] > 0 ) ? number_format(($data['u_client_received_num'] / $data['page_num']) * 100)."%" : "0%";
			$pec3 = ( $data['u_leads_num'] > 0 ) ? number_format(($data['u_client_received_num'] / $data['u_leads_num']) * 100)."%" : "0%";
			
			$bg = ( $count%2 == 0 ) ? "f7f7f7" : "f2f2f2";
			
			$show_group_var_name = ( $group_var_name != "" ) ? $group_var_name : $data_group_by;
			
			echo "<tr bgcolor=\"#{$bg}\">";
				echo "<td>".$show_group_var_name."</td>";
				echo "<td style='border-left: 1px solid #".$border_c."; border-right: 1px solid #".$border_c.";'>".number_format($data['page_num'])."</td>";
				echo "<td>".number_format($data['leads_num'])." (".$pec1.")</td>";
				echo "<td style='border-left: 1px solid #".$border_c.";'>".number_format($data['client_received_num'])." (".$pec2.")</td>";
				echo "<td>".number_format($data['u_leads_num'])." (".$pec_u1.")</td>";
				echo "<td style='border-left: 1px solid #".$border_c.";'>".number_format($data['u_client_received_num'])." (".$pec_u2.")</td>";
				echo "<td>".$pec3."</td>";
				echo "<td>";
					echo "<form action='index.php' name='formi_".$count."' method='get' onchange='formi_".$count.".submit()'>";
					echo "<input type='hidden' name='main' value='estimate_stats_by_groups'>";
					echo "<input type='hidden' name='sesid' value='".SESID."'>";
					echo "<input type='hidden' name='history' value='".$history."'>";
					if( $group_by == "date" )
					{
						echo "<input type='hidden' name='filter_s_date' value='".$data[$group_by]."'>";
						echo "<input type='hidden' name='filter_e_date' value='".$data[$group_by]."'>";
					}
					else
						echo "<input type='hidden' name='filter_".$group_by."' value='".$data[$group_by]."'>";
						
						
						echo "<select name='group' class='input_style' style='width: 120px;'>";
							echo "<option value=''>חתוך לפי</option>";
							foreach( $group_by_arr as $k => $v )
							{
								echo "<option value='".$k."'>".$v."</option>";
							}
						echo "</select>";
					echo "</form>";
				echo "</td>";
			echo "</tr>";
			
			$count++;
		}
		
		
	echo "</table>";
}
