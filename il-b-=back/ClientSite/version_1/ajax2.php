<?

//header('content-type:TEXT/HTML; charset=UTF-8');
####################################
##
##
##	
##
####################################

require('/home/ilan123/domains/ilbiz.co.il/public_html/global_func/vars.php');
require('/home/ilan123/domains/ilbiz.co.il/public_html/global_func/classes/class.estimate.statisitc.php');
require('/home/ilan123/domains/ilbiz.co.il/public_html/global_func/classes/class.estimate_stats.php');

mysql_query("SET NAMES 'utf8'");

switch($_GET['main'])
{
	case "estimateCatExtraFileds" :
		if(!isset($_GET['from_cat'])){
			echo "";
		}
		else{
			$available_cats = false;
			if(isset($_REQUEST['limit_cat_by_cities'])){
				$in_cities = $_REQUEST['limit_cat_by_cities'];
				$available_cats = get_available_cats_for_cities($in_cities);			
			}
			$select_name = "cat_s";
			$sons_class = " select_cat_f_son ";
			if($_GET['cat_level'] == "cat_s"){
				$select_name = "cat_spec";
				$sons_class .= " select_cat_s_son ";				
			}
			if(!isset($_REQUEST['no_city'])){
				get_city_select($_GET['from_cat']);
			}
			$sql = "SELECT id , cat_name FROM biz_categories WHERE status=1 AND hidden=0 AND father= '".ifint($_GET['from_cat'])."' ORDER BY place";
			$res_cats_formi = mysql_db_query(DB , $sql );
			$numbs = mysql_num_rows($res_cats_formi);
		
			if( $numbs > 0 ){ 
			?>
				<div class="form-group cat_tree_ajax_wrap <?php echo $sons_class; ?>" >
					<select id="<?php echo $select_name; ?>" name='<?php echo $select_name; ?>' class='form-select required cat_updater_new'  data-msg-required="<?php echo con_text("אנא בחר תחום"); ?>">
						<option value=''><?php echo con_text("בחר"); ?></option>
						<?php while( $data_specc2 = mysql_fetch_array($res_cats_formi) ): ?>
							<?php if(!$available_cats || isset($available_cats[$data_specc2['id']])): ?>
								<option value='<?php echo  $data_specc2['id'] ; ?>'><?php echo stripslashes($data_specc2['cat_name']); ?></option>
							<?php endif; ?>
						<?php endwhile; ?>
					</select>
				</div>
				<input type="hidden" name="Fm_email_remove_helper" class="Fm_email_remove" value="1" />
			<?php
			}		
			else{								
				$sql = "
					SELECT 
						bc1.extra_fields as extra1, 
						bc2.extra_fields as extra2, 
						bc3.extra_fields as extra3,
						bc1.add_email_to_form as add_email1, 
						bc2.add_email_to_form as add_email2, 
						bc3.add_email_to_form as add_email3						
					FROM biz_categories bc1
					LEFT JOIN biz_categories bc2 ON bc1.father = bc2.id
					LEFT JOIN biz_categories bc3 ON bc2.father = bc3.id
					WHERE bc1.id =  ".$_GET['from_cat']."";
				$res = mysql_db_query(DB, $sql);
				$dataExtraFields = mysql_fetch_array($res);
				$html = "";
				
				if($dataExtraFields['add_email1'] == "1" || $dataExtraFields['add_email2'] == "1" || $dataExtraFields['add_email3'] == "1"){
					$html .= '<div class="form-group Fm_email_temp">
						<input type="text" name="Fm_email" id="Fm_email_temp" class="form-input email_not_validate" placeholder="'.con_text("אימייל").'" data-msg-required="'.con_text("אנא הוסף כתובת מייל").'" data-msg-email="'.con_text("אנא הכנס כתובת אימייל תקינה.").'"/>
					</div>';				
				}
				else{
					$html .= '<input type="hidden" name="Fm_email_remove_helper" class="Fm_email_remove" value="1" />';
				}
				if($dataExtraFields['extra3'] != ""){
					$html .= $dataExtraFields['extra3'];
				}
				if($dataExtraFields['extra2'] != ""){
					$html .= $dataExtraFields['extra2'];
				}
				if($dataExtraFields['extra1'] != ""){
					$html .= $dataExtraFields['extra1'];
				}
				if (strpos($html,"<!--cityTo-->") !== false) {
					$html = str_replace("<!--cityTo-->",fm_to_city_html(),$html);
				}
				if (strpos($html, "<!--passengers-->") !== false) {
					$html = str_replace("<!--passengers-->",fm_passengers_html(),$html);	
				}			
				
								
				echo stripcslashes($html);
			}
		}
	break;
	case "updateBannerPoints" :
		$update_type = "views";
		if($_REQUEST['type'] == "view"){
			$update_type = "views";
		}
		if($_REQUEST['type'] == "click"){
			$update_type = "clicks";
		}
		$banner_id = $_REQUEST['banner_id'];
		$sql = "UPDATE net_clients_banners SET $update_type = $update_type+1 WHERE id=$banner_id";
		$res = mysql_db_query(DB,$sql);
	break;
	
	case "estimateSiteHeight" :
		$final_cat = '0';
		$cat_tree = array('cat_f'=>'0','cat_s'=>'0','cat_spec'=>'0','cat_select_from'=>'cat_f','cat_selected_name'=>false);
		if($_GET['cat'] != '0' && $_GET['cat'] != ''){
			$final_cat = $_GET['cat'];
		}
		if($_GET['subCat'] != '0' && $_GET['subCat'] != ''){
			$final_cat = $_GET['subCat'];
		}		
		if($_GET['cat_spec'] != '0' && $_GET['cat_spec'] != ''){
			$final_cat = $_GET['cat_spec'];
		}
		if($final_cat == '0' && isset($_REQUEST['custom_cat'])){
			$final_cat = $_REQUEST['custom_cat'];
		}
		if($final_cat != '0'){
			$cat_tree['cat_selected_name'] = 'cat_f';
			$cat_tree['cat_select_from'] = 'cat_s';
			$cat_tree['cat_f'] = $final_cat;
			
			$sql = "SELECT father FROM biz_categories WHERE id = '".$final_cat."'";
			$res = mysql_db_query(DB, $sql);
			$cat_data = mysql_fetch_array($res);
			
			if($cat_data['father'] == '0' || $cat_data['father'] == ''){
								
			}
			else{
				$cat_tree['cat_selected_name'] = 'cat_s';
				$cat_tree['cat_select_from'] = 'cat_spec';
				$cat_tree['cat_f'] = $cat_data['father'];
				$cat_tree['cat_s'] = $final_cat;
				
				$father_cat_1 = $cat_data['father'];				
				$sql = "SELECT father FROM biz_categories WHERE id = '".$cat_tree['cat_f']."'";
				$res = mysql_db_query(DB, $sql);
				$cat_data = mysql_fetch_array($res);
				
				if($cat_data['father'] == '0' || $cat_data['father'] == ''){
					
				}
				else{
					$father_cat_2 = $cat_data['father'];
					$cat_tree['cat_spec'] = $final_cat;
					$cat_tree['cat_s'] = $father_cat_1;
					$cat_tree['cat_f'] = $father_cat_2;
					$cat_tree['cat_selected_name'] = 'cat_spec';
					$cat_tree['cat_select_from'] = false;					
				}				
			}
		}
		$custom_cat_title = "";
		if(isset($_REQUEST['custom_cat'])){
			
			if($cat_tree['cat_f']!=0){
				$sql = "SELECT cat_name FROM biz_categories WHERE id = ".$cat_tree['cat_f']."";
				$res = mysql_db_query(DB, $sql);
				$cat_name_data = mysql_fetch_array($res);
				$custom_cat_title .= $cat_name_data['cat_name'];
			}
			if($cat_tree['cat_s']!=0){
				$sql = "SELECT cat_name FROM biz_categories WHERE id = ".$cat_tree['cat_s']."";
				$res = mysql_db_query(DB, $sql);
				$cat_name_data = mysql_fetch_array($res);
				$custom_cat_title .= ", ".$cat_name_data['cat_name'];
			}
			if($cat_tree['cat_spec']!=0){
				$sql = "SELECT cat_name FROM biz_categories WHERE id = ".$cat_tree['cat_spec']."";
				$res = mysql_db_query(DB, $sql);
				$cat_name_data = mysql_fetch_array($res);
				$custom_cat_title .= ", ".$cat_name_data['cat_name'];
			}
			if($custom_cat_title != ""){
				$custom_cat_title = "<h3 style='color:blue;'>$custom_cat_title</h3>";
			}
		}
		
		$estimate_statisitc = new estimate_statisitc;

		$params = array();
		$params['domain'] = $_SERVER[HTTP_HOST];
		$params['father_cat'] = $cat_tree['cat_f'];
		$params['sub_cat'] = $cat_tree['cat_s'];
		$params['cat_spec'] = $cat_tree['cat_spec'];
		if(isset($_REQUEST['page_id'])){
			$params['page_id'] =$_REQUEST['page_id'];
		}
		$stat_id = $estimate_statisitc->newEstimateStat($params);
		
		
		$estimate_stats = new estimate_stats;
		$params_stats = array();
		$params_stats['cat'] = $cat_tree['cat_f'];
		$params_stats['tat_cat'] = $cat_tree['cat_s'];
		$params_stats['spec_cat'] = $cat_tree['cat_spec'];
		$estimate_stats->update("0",$params_stats);
		if(isset($_GET['unk'])){
			$sql = "SELECT cityId,input_remove,cat_remove,cat_add, addEmail FROM estimate_miniSite_defualt_block WHERE type = '".mysql_real_escape_string($_GET['pageId'])."' AND unk = '".mysql_real_escape_string($_GET['unk'])."'";
			$res = mysql_db_query(DB, $sql);
			$estimate_data = mysql_fetch_array($res);
		}
		else{
			$estimate_data = array(
				"input_remove"=>"",
				"cat_remove"=>"",
				"cityId"=>"",
			);
		}

		$remove_inputs = array();
		$add_email = false;
		if($estimate_data['addEmail'] == "1"){
			$add_email = true;
		}
		if($estimate_data['input_remove'] != ""){
			$inputs_to_remove = explode(",",$estimate_data['input_remove']);
			foreach($inputs_to_remove as $i_remove){
				$input_remove = trim($i_remove);
				$remove_inputs[$input_remove] = '1';
			}
		}
		$remove_cats = array();
		if($estimate_data['cat_remove'] != ""){
			$cats_to_remove = explode(",",$estimate_data['cat_remove']);
			foreach($cats_to_remove as $c_remove){
				$cat_remove = trim($c_remove);
				$remove_cats[$cat_remove] = '1';
			}
		}
		$available_cats = false;
		$in_cities = false;
		if(isset($_REQUEST['limit_cat_by_cities'])){
			$in_cities = $_REQUEST['limit_cat_by_cities'];
			$available_cats = get_available_cats_for_cities($in_cities);			
		}
		$use_cat_select_helper = true;
		?>
		<?php echo $custom_cat_title; ?>
		<form name="send_es_form" class="estimate-form" id="estimate_form" method="post" action="javascript:ajax_estimateForm_send()">
			<?php if($in_cities): ?>
				<input type="hidden" name="in_cities" id="in_cities" value='<?php echo $in_cities; ?>' />
			<?php endif; ?>
			<?php if(isset($_GET['bill_free'])): ?>
				<input type="hidden" name="bill_free" id="bill_free" value='<?php echo $_GET['bill_free']; ?>' />
			<?php endif; ?>			
			<?php if(isset($_GET['pageId'])): ?>
				<input type="hidden" name="pageId" id="pageId" value='<?php echo $_GET['pageId']; ?>' />
			<?php endif; ?>
			<?php if(isset($_GET['uniq_track'])): ?>
				<input type="hidden" name="uniq_track" id="uniq_track" value='<?php echo $_GET['uniq_track']; ?>' />
			<?php endif; ?>			
			<?php if(isset($_GET['unk'])): ?>
				<input type="hidden" name="clientUnk" id="clientUnk" value='<?php echo $_GET['unk']; ?>' />
			<?php endif; ?>
			<?php if(isset($_GET['aff_id'])): ?>
				<input type="hidden" name="aff_id" id="aff_id" value='<?php echo $_GET['aff_id']; ?>' />
			<?php endif; ?>
			<?php if(isset($_GET['bann_id'])): ?>
				<input type="hidden" name="bann_id" id="bann_id" value='<?php echo $_GET['bann_id']; ?>' />
			<?php endif; ?>		
			<?php if(isset($_GET['link_uniq'])): ?>
				<input type="hidden" name="link_uniq" id="link_uniq" value='<?php echo $_GET['link_uniq']; ?>' />
			<?php endif; ?>					
			<input type="hidden" name="stat_id" id="stat_id" value='<?php echo $stat_id; ?>' />

				
			

			<?php if($cat_tree['cat_f'] != '0'): ?>
				<input type="hidden" name="cat_f" id="cat_f" value='<?php echo $cat_tree['cat_f']; ?>' />
			<?php endif; ?>
			<?php if($cat_tree['cat_s'] != '0'): ?>
				<input type="hidden" name="cat_s" id="cat_s" value='<?php echo $cat_tree['cat_s']; ?>' />
			<?php endif; ?>	
			<?php if($cat_tree['cat_spec'] != '0'): ?>
				<input type="hidden" name="cat_spec" id="cat_spec" value='<?php echo $cat_tree['cat_spec']; ?>' />
			<?php endif; ?>		
			<?php if($cat_tree['cat_select_from']): ?>
				<?php
					$selected_cat = $cat_tree[$cat_tree['cat_selected_name']];
					$cats_add_id_in = "0";
					if($estimate_data['cat_add'] != ""){
						$cats_add_id_in = $estimate_data['cat_add'];
					}
					
					$sql = "SELECT id , cat_name FROM biz_categories WHERE ((status=1 AND hidden=0) OR id IN(".$cats_add_id_in.")) AND father= '".ifint($selected_cat)."' ORDER BY place";
					$res_cats_formi = mysql_db_query(DB , $sql );
					$numbs = mysql_num_rows($res_cats_formi);
				?>
				<?php if( $numbs > 0 ): ?>
					<?php $use_cat_select_helper = false; ?>
					
					<div class="form-group" id="cat_select_main">
						<select name='<?php echo $cat_tree['cat_select_from']; ?>' id='<?php echo $cat_tree['cat_select_from']; ?>' class='form-select required cat_updater_new'  data-msg-required="<?php echo con_text("אנא בחר שירות"); ?>">
							<option value=''><?php echo con_text("בחר שירות"); ?></option>
							<?php while( $data_specc2 = mysql_fetch_array($res_cats_formi) ): ?>
								<?php if(!isset($remove_cats[$data_specc2['id']])): ?>
									<?php if(!$available_cats || isset($available_cats[$data_specc2['id']])): ?>
										<option value='<?php echo  $data_specc2['id'] ; ?>'><?php echo stripslashes($data_specc2['cat_name']); ?></option>
									<?php endif; ?>
								<?php endif; ?>
							<?php endwhile; ?>

						</select>
					</div>	
				<?php endif; ?>
			<?php endif; ?>
			<?php if($use_cat_select_helper): ?>
			
				<input type="hidden" id="cat_updater_helper" name="cat_updater_helper" rel="<?php echo $cat_tree['cat_selected_name']; ?>" class="cat_updater_helper" /> 
			<?php endif; ?>
			<!-- extra fields go here -->
			<div style = "display:none;" id="cat_tree_select_place"></div>
			<div class="form-group">
				<input type="text" name="Fm_name" id="Fm_name" class="form-input required"  placeholder="<?php echo con_text("שם מלא"); ?>"   data-msg-required="<?php echo con_text("אנא הוסף שם מלא"); ?>" />
			</div>
			<div class="form-group">
				<?php 
				
					$phone_val_str = ""; 
					if(isset($_REQUEST['custom_phone'])){ 
						$phone_val_str = ' value="'.$_REQUEST['custom_phone'].'"';
					}	
				?>
				<input type="text" name="Fm_phone" id="Fm_phone" class="form-input phoneNumber required" placeholder="<?php echo con_text("טלפון"); ?>" data-msg-required="<?php echo con_text("אנא הוסף מספר טלפון"); ?>" data-msg-phoneNumber="<?php echo con_text("אנא הכנס מספר טלפון תקין."); ?>"<?php echo $phone_val_str; ?>/>
			</div>
			<?php if($_REQUEST['pageId'] != "27548"): ?>
				<?php if($add_email): ?>
					<div class="form-group">
						<input type="text" name="Fm_email" id="Fm_email" class="form-input email_not_validate" placeholder="<?php echo con_text("אימייל"); ?>" data-msg-required="<?php echo con_text("אנא הוסף כתובת מייל"); ?>" data-msg-email="<?php echo con_text("אנא הכנס כתובת אימייל תקינה."); ?>"/>
					</div>
				<?php else: ?>
					<input type="hidden" name="Fm_email" id="Fm_email_hidden" value = "no_email" />
				<?php endif; ?>
			<?php else: ?>
				<input type="hidden" name="Fm_email" id="Fm_email" value = "lead_from_phone" />
			<?php endif; ?>
			
			<?php if(!isset($remove_inputs['city'])): ?>
				<?php get_city_select($final_cat); ?>
			<?php else: ?>
				<input  class="no-replace" type="hidden" id="Fm_city" name="Fm_city" value = "1" />
			<?php endif; ?>

			<?php if(!isset($remove_inputs['note'])): ?>
				<div class="form-group textarea" id="Fm_note_wrap">
					<textarea class="form-group form-textarea" name="Fm_note" id="Fm_note" placeholder="<?php echo con_text("הערה/בקשה"); ?>" ></textarea>
				</div>
			<?php else: ?>
				<input type="hidden" name="Fm_note" value = "" id="Fm_note_wrap"/>
			<?php endif; ?>
			
			<div class="form-group form-submit">	
				<?php
					$rel_sending = con_text("שולח...");
					$rel_ready = con_text("שליחה");
					$rel_loading = con_text("הטופס נטען...");
				?>
				<input class="btn-sumbit" type='submit'  rel_loading="<?php echo $rel_loading; ?>" rel_sending="<?php echo $rel_sending; ?>" rel_ready="<?php echo $rel_ready; ?>" value="<?php echo $rel_loading; ?>" id='submitit' disabled />
			</div>	
			
			<div class="estimate_form_footer">
					<?php echo con_text(""); ?>
			</div>
		</form>
	<?php	
	break;
	
	case "e_card_register" :
		require_once('functions/modules/e_card.php');
		e_card_register_ajax_send();
	break;

	case "user_service_offers" :
		require_once('functions/modules/user_service_offers.php');
		get_user_service_offers();
	break;	
	case "in_cities" :
		get_available_cats_for_cities("18");
	break;	
	
}

function con_text($str)
{
	return iconv("windows-1255", "UTF-8" , $str);
}

function fm_to_city_html(){
	ob_start();
	$sql = "SELECT id, name FROM newCities WHERE father=0 ORDER BY place, name";
	$resAll3 = mysql_db_query(DB,$sql);					
	?>
	<div class="form-group form-extra">
		<select name='Fm_to_city' id='Fm_to_city' class="form-group form-select  required" data-msg-required="<?php echo con_text("אנא בחר עיר"); ?>" >
			<option value=''><?php echo con_text("בחר לעיר"); ?></option>
			<?php while( $data = mysql_fetch_array($resAll3) ): ?>
			
				<?php if( $data['id'] != "1" ): ?>
					<option value='<?php echo $data['id']; ?>'><b><?php echo stripslashes($data['name']); ?></b></option>
				<?php endif; ?>
				<?php 
					$sql = "SELECT id, name FROM newCities WHERE father=".$data['id']." ORDER BY place, name";
					$resAll4 = mysql_db_query(DB,$sql);
				?>
				<?php while( $data2 = mysql_fetch_array($resAll4) ): ?>
				
					<?php $selected = ( $data2['id'] == $estimate_data['cityId'] ) ? "selected" : ""; ?>
					<option value='<?php echo $data2['id']; ?>' <?php echo $selected; ?>><?php echo stripslashes($data2['name']); ?></option>
				<?php endwhile; ?>
				<option value=''  disabled>-----------------------</option>
			<?php endwhile; ?>
		</select>
	</div>
	<?php
	return ob_get_clean();
}

function fm_passengers_html(){
	ob_start();
	?>
	<div class="form-group form-extra">
		<select name='Fm_passengers' id='Fm_passengers' class="form-group form-select required" data-msg-required="<?php echo con_text("אנא בחר מספר נוסעים"); ?>">
			<option value=''><?php echo con_text("מס' נוסעים"); ?></option>
			<?php for( $i=1 ; $i<=51 ; $i++ ): ?>
				<?php $new_i = ( $i == "51" ) ? "51+" : $i ; ?>
				<option value='<?php echo $i; ?>'><?php echo $new_i; ?></option>
			<?php endfor; ?>
		</select>
	</div>
	<?php
	return ob_get_clean();
}

function get_city_select($forCat){
	$fromTownTxt = con_text("בחר עיר");
	$extra_field_class = "";
	$aval_cities = false;
	$city_in_sql = "";
	

	$catsSql = "SELECT son.id as son_cat, par1.id as 'parent1',par2.id as 'parent2'   
				FROM biz_categories son 
				LEFT JOIN  biz_categories par1 ON par1.id = son.father
				LEFT JOIN  biz_categories par2 ON par2.id = par1.father
				WHERE son.id = ".$forCat."
			";
	$catsRes = mysql_db_query(DB,$catsSql);
	$catsData = mysql_fetch_array($catsRes);
	
	$allCats = array();
	$allCats[] = $catsData['son_cat'];
	$allCats[] = $catsData['parent1'];
	$allCats[] = $catsData['parent2'];
	$c_i = 0;
	$c_in = "";
	foreach($allCats as $cat){
		
		if($cat == "31"){
			$fromTownTxt = con_text("בחר מעיר");
		}
		if($c_i > 0){
			$c_in .= ",";
		}
		$c_in .= "'".$cat."'";
		$c_i++;
	}
	$remove_unavalable = false;
	$remove_unavalable = true;
	$extra_field_class = " form-extra extra-field ";		
	$aval_cities = array();		
	$sql = "
			SELECT u_cat.user_id,user.city as add_city  
			FROM user_cat u_cat
			INNER JOIN users user ON user.id = u_cat.user_id 
			AND user.end_date >= NOW() 
			AND user.status = '0'
			AND user.deleted=0
			WHERE cat_id = '".$forCat."'
		";
	$resUsers = mysql_db_query(DB,$sql);
	$u_i = 0;
	$u_in = "";
	while($user = mysql_fetch_array($resUsers)){
		
		$aval_cities[$user['add_city']] = '1';
		if($u_i > 0){
			$u_in .= ",";
		}
		$u_in .= "'".$user['user_id']."'";
		$u_i++;
	}

	if($u_in != ""){
		$sql2 = "SELECT DISTINCT city_id FROM user_lead_cities WHERE user_id IN(".$u_in.")";
		
		$res2 = mysql_db_query(DB,$sql2);

		while($city = mysql_fetch_array($res2)){
			$aval_cities[$city['city_id']] = '1';
		}
		if($c_in != ""){
			$sql2 = "SELECT DISTINCT city_id FROM user_cat_city WHERE cat_id IN(".$c_in.") AND user_id IN(".$u_in.")";
			$res2 = mysql_db_query(DB,$sql2);
			while($city = mysql_fetch_array($res2)){
				$aval_cities[$city['city_id']] = '1';
			}
		}
	}
	$c_i = 0;
	$c_in = "";
	if(!isset($aval_cities['1'])){
		foreach($aval_cities as $cityKey=>$city){
			if($c_i > 0){
				$c_in .= ",";
			}
			$c_in .= "'".$cityKey."'";
			$c_i++;
		}
		if($c_in != ""){
			$fathers_sql = "SELECT father  FROM newCities WHERE id IN(".$c_in.")";
			$fathers_res = mysql_db_query(DB,$fathers_sql);
			while( $fathers_data = mysql_fetch_array($fathers_res) ){
				if(!isset($aval_cities[$fathers_data['father']])){
					$aval_cities[$fathers_data['father']] = '0';
				}
			}
			//$city_in_sql = " AND (id IN (".$c_in.") OR id IN(SELECT distinct father FROM newCities WHERE id IN(".$c_in.")))";
		}
	}
	
	$sql = "SELECT id, name FROM newCities WHERE father=0 ORDER BY place,name";
	$resAll = mysql_db_query(DB,$sql);
		//ניתן לקבל שירות בערים הבאות:
	
	// במידה ולא מצאת את שם העיר ברשימה, אין לנו נותן שירות
	?>
		<div class="form-group city-selector <?php echo $extra_field_class; ?>">
			<select name='Fm_city' id='Fm_city' class="form-group form-select required" data-msg-required="<?php echo con_text("אנא בחר עיר"); ?>" >
				<option value=''><?php echo $fromTownTxt; ?></option>
				<option disabled style='color:black;' class='option_helper option_helper_top' value=''><?php echo con_text("ניתן לקבל שירות בערים הבאות:"); ?></option>
				<?php while( $data = mysql_fetch_array($resAll) ): ?>
					<?php
					$option_disabled_str = "";
					if($remove_unavalable && isset($aval_cities[$data['id']]) && !isset($aval_cities['1'])){
						if($aval_cities[$data['id']] == "0"){
							$option_disabled_str = "disabled";
						}
					}
					?>
					<?php if( $params['father_cat'] == "31" ): ?>
					
						<?php if( $data['id'] != "1" ): ?>
							<?php if(isset($aval_cities[$data2['id']]) || isset($aval_cities['1']) || !$remove_unavalable): ?>
								<option class='city-area <?php echo $no_aval_class; ?>' value='<?php echo $data['id']; ?>' ><?php echo stripslashes($data['name']); ?></option>
							<?php endif; ?>
						<?php endif; ?>
					<?php else: ?>
						<?php if( $data['id'] != "1" ): ?>
							<?php if(isset($aval_cities[$data['id']]) || isset($aval_cities['1']) || !$remove_unavalable): ?>
								<?php $cityName = ( $data['name'] == "כל הארץ" ) ? con_text("בחר מעיר") : $data['name']; ?>
								<option class='city-area'  value='<?php echo $data['id']; ?>' <?php echo $option_disabled_str; ?>><?php echo stripslashes($cityName); ?></option>
							<?php endif; ?>
						<?php endif; ?>
					<?php endif; ?>
					<?php 
					$sql = "SELECT id, name FROM newCities WHERE father=".$data['id']." ORDER BY place, name";
					$resAll2 = mysql_db_query(DB,$sql);
					?>
					<? while( $data2 = mysql_fetch_array($resAll2) ): ?>
					
						<?php if(isset($aval_cities[$data2['id']]) || isset($aval_cities['1']) || !$remove_unavalable): ?>
							<?php $selected = ( $data2['id'] == $estimate_data['cityId'] ) ? "selected" : ""; ?>
							<option class='city-city' value='<?php echo $data2['id']; ?>' <?php echo $selected; ?>><?php echo stripslashes($data2['name']); ?></option>
						<?php endif; ?>
					<?php endwhile; ?>
					<option class='seperator' value='' disabled>-----------------------</option>
				<?php endwhile; ?>
				<option disabled style='color:red;' class='option_helper option_helper_bottom' value=''><?php echo con_text("במידה ולא מצאת את שם העיר ברשימה, אין לנו נותן שירות"); ?></option>
			</select>
		</div>
	<?php
}
function get_available_cats_for_cities($in_cities){
	$in_cities = "1,".$in_cities;
	$active_cats = array();
	$user_ids = array(); //all users belong to cities from the list
	/*
			global user_city cats
	*/
	//get all users belong to selected cities
	$sql = "
			SELECT distinct user_id 
			FROM user_lead_cities 
			WHERE city_id IN (".$in_cities.")
		";
	$res = mysql_db_query(DB,$sql);
	
	
	while($data = mysql_fetch_array($res)){
		$user_ids[$data['user_id']] = $data['user_id'];
	}
	$user_ids_in = implode(",",$user_ids);
	//remove users that are not active
	$sql = "SELECT id FROM users WHERE id IN ($user_ids_in) 
		AND end_date < NOW() 
		AND status != '0'
		AND deleted != 0
	";
	$res = mysql_db_query(DB,$sql);
	
	while($data = mysql_fetch_array($res)){
		unset($user_ids[$data['id']]);
	}
	//get all cats for active users
	$user_ids_in = implode(",",$user_ids);
	$sql = "SELECT cat_id FROM user_cat WHERE user_id IN ($user_ids_in)";
	$res = mysql_db_query(DB,$sql);
	while($data = mysql_fetch_array($res)){
		$active_cats[$data['cat_id']] = $data['cat_id'];
	}
	/*
		all categories tree
	*/
	$cat_tree = array();
	$sql = "SELECT id,father FROM biz_categories";
	$res = mysql_db_query(DB,$sql);
	while($cat = mysql_fetch_array($res)){
		if(!isset($cat_tree[$cat['id']])){
			$cat_tree[$cat['id']] = array('id'=>$cat['id'],'children'=>array());
		}
		if(!isset($cat_tree[$cat['father']])){
			$cat_tree[$cat['father']] = array('id'=>$cat['father'],'children'=>array());
		}
		$cat_tree[$cat['father']]['children'][$cat['id']] = $cat['id'];
	}
	/*
		user_cat_city
	*/
	$user_ids_in_cats = array();
	$user_cats = array();
	$sql = "
			SELECT user_id,cat_id 
			FROM user_cat_city 
			WHERE city_id IN (".$in_cities.")
		";
	$res = mysql_db_query(DB,$sql);
	while($data = mysql_fetch_array($res)){
		if(!isset($user_cats[$data['user_id']])){
			$user_ids_in_cats[$data['user_id']] = $data['user_id'];
			$user_cats[$data['user_id']] = array();
		}
		$user_cats[$data['user_id']][$data['cat_id']] = $data['cat_id'];
		//in user_cat_city the father cat is default for all sub cats
		if(isset($cat_tree[$data['cat_id']])){
			if(isset($cat_tree[$data['cat_id']]['children'])){
				if(!empty($cat_tree[$data['cat_id']]['children'])){
					foreach($cat_tree[$data['cat_id']]['children'] as $cat_id){
						//insert sub cats as belong to user
						$user_cats[$data['user_id']][$cat_id] = $cat_id;
						//second generation: in user_cat_city the father cat is default for all sub cats 
						if(isset($cat_tree[$cat_id])){
							if(isset($cat_tree[$cat_id]['children'])){
								if(!empty($cat_tree[$cat_id]['children'])){
									foreach($cat_tree[$cat_id]['children'] as $child_cat_id){
										$user_cats[$data['user_id']][$child_cat_id] = $child_cat_id;
									}
								}
							}
						}
					}
				}
			}
		}
	}
	$user_ids_in = implode(",",$user_ids_in_cats);
	//remove users that are not active
	$sql = "SELECT id FROM users WHERE id IN ($user_ids_in) 
		AND end_date < NOW() 
		AND status != '0'
		AND deleted != 0
	";
	$res = mysql_db_query(DB,$sql);
	while($data = mysql_fetch_array($res)){
		unset($user_ids_in_cats[$data['id']]);
		unset($user_cats[$data['id']]);
	}
	$user_ids_in = implode(",",$user_ids_in_cats);
	$sql = "SELECT cat_id,user_id FROM user_cat WHERE user_id IN ($user_ids_in)";
	$res = mysql_db_query(DB,$sql);
	while($data = mysql_fetch_array($res)){
		if(!isset($active_cats[$data['cat_id']])){
			if(isset($user_cats[$data['user_id']])){
				if(isset($user_cats[$data['user_id']][$data['cat_id']])){
					$active_cats[$data['cat_id']] = $data['cat_id'];
				}
			}
		}
	}
	return $active_cats;
}

?>