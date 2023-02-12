<?
function customer_tracking_statistics(){
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
	$filter_campaign_1 = false;
	$filter_campaign_2 = false;

	$filter_campaign_1_checked = "";
	$filter_campaign_2_checked = "";
	if(!isset($_REQUEST['campaign']['helper'])){
		$filter_campaign_1_checked = "checked";
		$filter_campaign_2_checked = "checked";

		$filter_campaign_1 = true;		
		$filter_campaign_2 = true;

	}
	if(isset($_REQUEST['campaign']['1'])){
		$filter_campaign_1 = true;
		$filter_campaign_1_checked = "checked";		
	}
	if(isset($_REQUEST['campaign']['2'])){
		$filter_campaign_2 = true;
		$filter_campaign_2_checked = "checked";		
	}
	$campaign_sql = "";
	if($filter_campaign_1 && $filter_campaign_2){
		$campaign_sql = " AND (has_gclid = '1' OR has_gclid = '2')";
	}
	else{
		if($filter_campaign_1){
			$campaign_sql = " AND has_gclid = '1' ";
		}
		if($filter_campaign_2){
			$campaign_sql = " AND has_gclid = '2' ";
		}
	}
	$browser_type = "all";
	$browser_types = array("all"=>array('str'=>'הכל','checked'=>''),"all"=>array('1'=>'מובייל','checked'=>''),"0"=>array('str'=>'מחשב','checked'=>''));
	if(isset($_REQUEST['browser_type'])){
		$browser_type = $_REQUEST['browser_type'];
		
	}
	$browser_types[$browser_type]['checked'] = "checked";
	?>
	<h2>סטטיסטיקה של אתרי השוואות מחיר</h2>
	<div><a href="index.php?sesid=<?php echo SESID; ?>">חזרה לתפריט הראשי</a></div>
	<div id="filter_wrap" style="padding: 15px;border: 1px solid black;background: #e6d7d7;margin: 15px 0px;">
		<h3>סינון סיפורים</h3>
		<form method="POST" action="" id="story_filter_form">
			<input type="hidden" name="filter_stories" value="1" />
			<div id="campaign_filter" style="margin-left: 20px;float:right;background: #e5e5fb;padding: 10px;border: 1px solid blue;"> 
				<b>הצג רק תוצאות שבאו מקמפיין:</b>
				<input type="hidden" name="campaign[helper]" value="1" />
				<div class="campaign-filter-check">
					<input type="checkbox" name="campaign[1]" value="1" <?php echo $filter_campaign_1_checked; ?> />
					גוגל
				</div>
				<div class="campaign-filter-check">
					<input type="checkbox" name="campaign[1]" value="1" <?php echo $filter_campaign_2_checked; ?> />
					פייסבוק
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
			<input type="submit" value="הצג סטטיסטיקה" />
		</form>
		<div style='clear:both;'></div>
	</div>
	<div style="clear:both;"></div>	
	<?php
}