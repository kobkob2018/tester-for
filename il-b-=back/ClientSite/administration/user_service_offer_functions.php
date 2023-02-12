<?php
$domain_for_images_path = false;
function manage_user_service_offers(){
	global $domain_for_images_path;
	$domain_sql = "SELECT domain FROM users WHERE unk = '".UNK."'";
	$domain_res = mysql_db_query(DB,$domain_sql);
	$domain_data = mysql_fetch_array($domain_res);
	$domain_for_images_path = $domain_data['domain'];
/*	
	echo "<pre style='text-align:left; direction:ltr;'>";
	print_r($_REQUEST); 
	echo "</pre>";
			echo "<div>";
			echo "<a href='index.php?main=manage_user_service_offers&scope=cat&unk=".UNK."&sesid=".SESID."'>חזרה לרשימה</a>";
			echo "</div>";	
*/	
	update_user_service_offers_cats();
	update_user_service_offers_offers();
	if(!isset($_REQUEST['scope'])){
		
		return manage_user_service_offers_cats();
	}	
	else{
		$scope = $_REQUEST['scope'];
		if($scope == "cat"){
			
			return manage_user_service_offers_cats();
		}
		if($scope == "offer"){
			
			return manage_user_service_offers_offers();
		}
		if($scope == "offer_cats"){
			
			return manage_user_service_offer_cat_belong();
		}
		if($scope == "page"){
			
			return manage_user_service_offers_page_cats();
		}	
		
	}	

}

function update_user_service_offers_offers(){
	if(isset($_REQUEST['update_offer'])){
		
		$set_params = array("unk", "name", "summary", "price","price_summary", "url_link", "service_phone", "place");
		
		$offer_name = $_REQUEST['data_arr']['name'];
		if(!isset($_REQUEST['cat_id'])){
			return;
		}
		$cat = $_REQUEST['cat_id'];
		$new_insert = false;
		$insert_id = false;
		$offer_id = false;
		if($_REQUEST['offer_id_edit'] != ""){
			$set_sql = "cat = '".$cat."'";
			foreach($set_params as $set_param){
				if(isset($_REQUEST['data_arr'][$set_param])){
					$param_val = str_replace("'","''",$_REQUEST['data_arr'][$set_param]);
					$set_sql .= ",".$set_param."='".$param_val."'";
				}
			}
			$offer_id = $_REQUEST['offer_id_edit'];
			$sql = "UPDATE user_service_offer SET $set_sql WHERE id = $offer_id";
		}
		else{
			$insert_params_sql = "cat";
			$insert_vals_sql = "'".$cat."'";
			foreach($set_params as $set_param){
				if(isset($_REQUEST['data_arr'][$set_param])){
					$param_val = str_replace("'","''",$_REQUEST['data_arr'][$set_param]);
					$insert_params_sql .= ",".$set_param;
					$insert_vals_sql .= ",'".$param_val."'";
				}
			}
			$sql = "INSERT INTO user_service_offer($insert_params_sql) VALUES($insert_vals_sql)";
			$new_insert = true;			
		}
		
		mysql_db_query(DB,$sql);
		if($new_insert){
			$insert_id = mysql_insert_id();
			$offer_id = $insert_id;
		}
			
		if($_FILES['offer_image']['name'] != ""){
			global $domain_for_images_path;
			$site_domain = $domain_for_images_path;
			$path = "/home/ilan123/domains/$site_domain/public_html/user_service_offers/";				
			$http_path = "http://$site_domain/user_service_offers/";	
			if(!is_dir($path)){
				$mask=umask(0);
				mkdir($path, 0777);
				umask($mask);
			}
		
			$temp_file_name = $_FILES['offer_image']['name'];
			$file_name_arr = explode(".",$temp_file_name);
			$ext_str = $file_name_arr[(count($file_name_arr) - 1)];
			$ext_str = strtolower($ext_str);
			$file_error = false;
			if($ext_str!="png" && $ext_str!="jpg" && $ext_str!="gif"){
				$file_error = "התמונה שהעלית לא תקינה(ניתן להעלות קבצים עם הסיומות הבאות בלבד: gif,jpg,png)";
			}
			elseif($_FILES["offer_image"]["size"] > 500000){
				$file_error = "התמונה שהעלית גדולה מידיי";
			}
			else{
				if(!$insert_id){
					$sql = "SELECT img FROM user_service_offer WHERE id = $offer_id";
					$res = mysql_db_query(DB,$sql);
					$curent_image_data = mysql_fetch_array($res);
					$curent_image = $curent_image_data['img'];
					if($curent_image!=""){
						unlink($path.$curent_image);
					}
				}

				$upload_image_name = UNK."_$offer_id.$ext_str";
				$up = move_uploaded_file($_FILES['offer_image']['tmp_name'],$path.$upload_image_name);
				if($up){
					$sql = "UPDATE user_service_offer SET img = '$upload_image_name' WHERE id='$offer_id'";
					$res = mysql_db_query(DB,$sql);
				}
			}
			if($file_error){
				echo "<script type='text/javascript'>
						alert('".$file_error."');
				</script>
				";
			}
		}
		echo "<script type='text/javascript'>
				alert('המבצע עודכן בהצלחה');
				window.location = 'index.php?main=manage_user_service_offers&scope=offer&offer_id=$offer_id&unk=".UNK."&sesid=".SESID."';
		</script>
		";
	}
	if(isset($_REQUEST['delete_offer'])){
		
		$offer_id = $_REQUEST['offer_id_delete'];
		$sql = "DELETE FROM user_service_offer WHERE id = $offer_id";
		
		mysql_db_query(DB,$sql);
		$cat_id = $_REQUEST['cat_id'];
		echo "<script type='text/javascript'>
				alert('המבצע נמחק');
				window.location = 'index.php?main=manage_user_service_offers&scope=cat&cat_id=$cat_id&unk=".UNK."&sesid=".SESID."';
		</script>
		";
	}
	//return;
	//GlobalFunctions::upload_file_to_server($temp_name , $imgName , $image_settings['server_path'] );
	//resize($imgName, $image_settings['server_path'], $image_settings['thumbnail_width'],$image_settings['thumbnail_height']);
}

function manage_user_service_offers_offers($selected_cat = false){
	global $word;
	global $domain_for_images_path;
	$site_domain = $domain_for_images_path;
	$path = "/home/ilan123/domains/$site_domain/public_html/user_service_offers/";				
	$http_path = "http://$site_domain/user_service_offers/";	
	$sql = "SELECT * FROM user_service_offer_cat WHERE  deleted = '0' and unk = '".UNK."'";
	$cat_result = mysql_db_query(DB,$sql);
	$cat_list = array("0"=>"בחר");
	while( $cat = mysql_fetch_array($cat_result) ){
		$cat_list[$cat['id']] .= $cat['name'];
	}
	if(isset($_REQUEST['offer_id']) && $_REQUEST['offer_id'] != ""){
		$sql = "select * from user_service_offer where deleted = '0' and id=".$_REQUEST['offer_id']." and unk = '".UNK."'";
		$offers_result = mysql_db_query(DB,$sql);
		$offer = mysql_fetch_array($offers_result);
		
		if($offer['img'] != ""){
			echo "<img src='".$http_path.$offer['img']."' style='max-width:300px;'/>להחלפת האייקון העלה תמונה בטופס למטה ושמור";
		}
		$offer_id = $offer['id'];
		$form_arr = array(
			array("hidden","main","manage_user_service_offers"),
			array("hidden","scope","offer"),
			array("hidden","offer_id_edit",$offer['id']),
			array("hidden","offer_id",$offer['id']),
			array("hidden","sesid",SESID),
			array("hidden","data_arr[unk]",UNK),
			array("hidden","unk",UNK),
			array("select","cat_id",$cat_list,$word[LANG]['category_name'],$offer['cat'],"cat_id", "class='input_style''"),
			array("text","data_arr[name]",$offer['name'],$word[LANG]['product_name'], "class='input_style'","","1"),
			array("textarea","data_arr[summary]",$offer['summary'],$word[LANG]['short_details'], "class='textarea_style_summary' style='width: 300px;'  onKeyDown='textCounter(this,document.editorhtml.remLen1,250)' onKeyUp='textCounter(this,document.editorhtml.remLen1,250)'","","1"),
			array("text","data_arr[price]",$offer['price'],"מחיר", "class='input_style'","","1"),
			array("textarea","data_arr[price_summary]",$offer['price_summary'],"טקסט למחיר", "class='textarea_style_summary' style='width: 300px;'  onKeyDown='textCounter(this,document.editorhtml.remLen1,250)' onKeyUp='textCounter(this,document.editorhtml.remLen1,250)'","","1"),
			array("new_file","offer_image",$data['img'],$word[LANG]['picture']),
			array("text","data_arr[url_link]",$offer['url_link'],$word[LANG]['address_link'], "class='input_style'","","1"),
			array("text","data_arr[service_phone]",$offer['service_phone'],$word[LANG]['phone'], "class='input_style'","","1"),
			array("text","data_arr[place]",$offer['place'],$word[LANG]['location'], "class='input_style'"),
			
			array("submit","update_offer",$word[LANG]['submit_form'], "class='submit_style'")
		);
		$more = "class='maintext' border='0'";	
		echo "<h3>ערוך מבצע</h3>";
		echo "<a href='index.php?main=manage_user_service_offers&scope=cat&cat_id=".$offer['cat']."&unk=".UNK."&sesid=".SESID."'>חזרה לקטגוריה</a>";
		echo FormCreator::create_form($form_arr,"index.php", $more, "", "editorhtml");	
		echo "<div>";
		echo "<a href='index.php?main=manage_user_service_offers&scope=offer_cats&offer_id=$offer_id&unk=".UNK."&sesid=".SESID."'>לחץ כאן לשייך את הצעת המחיר לקטגוריות</a>";
		echo "</div>";
		$delete_form_arr = array(
			array("hidden","main","manage_user_service_offers"),
			array("hidden","delete_offer","1"),
			array("hidden","cat_id",$offer['cat']), 
			array("hidden","scope","cat"),
			array("hidden","offer_id_delete",$offer['id']),
			array("hidden","sesid",SESID),
			array("hidden","data_arr[unk]",UNK),
			array("hidden","unk",UNK),
			//array("hidden","table",$table),					
			array("submit","submit","לחץ כאן למחיקת הצעת המחיר", "style='color:red;' onclick=\"return confirm('האם אתה בטוח שברצונך למחוק את הצעת המחיר?');\"")
		);
		echo FormCreator::create_form($delete_form_arr,"index.php", $more, "", "editorhtml");	
	}	
	else{
		$form_arr = array(
			array("hidden","main","manage_user_service_offers"),
			array("hidden","scope","cat"),

			array("hidden","sesid",SESID),
			array("hidden","data_arr[unk]",UNK),
			array("hidden","unk",UNK),
			array("select","cat_id",$cat_list,$word[LANG]['category_name'],$selected_cat,"cat_id", "class='input_style''"),
			array("text","data_arr[name]","",$word[LANG]['product_name'], "class='input_style'","","1"),
			array("textarea","data_arr[summary]","",$word[LANG]['short_details'], "class='textarea_style_summary' style='width: 300px;'","","1"),
			array("textarea","data_arr[price_summary]","","טקסט למחיר", "class='textarea_style_summary' style='width: 300px;'  ","","1"),
			array("text","data_arr[price]","","מחיר", "class='input_style'","","1"),
			array("new_file","offer_image",$data['img'],$word[LANG]['picture']),
			array("text","data_arr[url_link]","",$word[LANG]['address_link'], "class='input_style'","","1"),
			array("text","data_arr[service_phone]","",$word[LANG]['phone'], "class='input_style'","","1"),
			array("text","data_arr[place]","0",$word[LANG]['location'], "class='input_style'"),
			array("submit","update_offer",$word[LANG]['submit_form'], "class='submit_style'")
		);
		if(isset($_REQUEST['cat'])){
			$form_arr[] = array("hidden","cat",$_REQUEST['cat']);
		}
		$more = "class='maintext' border='0'";	
		echo "<h3>הוסף מבצע</h3>";
		echo FormCreator::create_form($form_arr,"index.php", $more, "", "editorhtml");	
		$cat_where = "";
		if($selected_cat){
			$cat_where = " AND cat = $selected_cat ";
		}		
		$sql = "SELECT * FROM user_service_offer WHERE  deleted = '0' ".$cat_where." and unk = '".UNK."'";
		$offers_result = mysql_db_query(DB,$sql);
		echo "<h3>מבצעים</h3>";
		while( $offer = mysql_fetch_array($offers_result) )
		{
			echo "<div>";
			echo "<a style='text-decoration:none;display:block;font-size:17px;margin: 13px 0px;border: 1px outset #c3c3da;box-shadow: 5px -3px 11px -1px #a59696;padding: 4px 10px;' href='index.php?main=manage_user_service_offers&scope=offer&offer_id=".$offer['id']."&unk=".UNK."&sesid=".SESID."'>".$offer['name']."</a>";
			echo "</div>";
		}
		

	}

}

function update_user_service_offers_cats(){
	if(isset($_REQUEST['update_cat'])){
		
		$cat_name = str_replace("'","''",$_REQUEST['data_arr']['name']);
		$cat_title = str_replace("'","''",$_REQUEST['data_arr']['title']);
		$custom_html = str_replace("'","''",$_REQUEST['data_arr']['custom_html']);
		$custom_html_title = str_replace("'","''",$_REQUEST['data_arr']['custom_html_title']);
		$unk = $_REQUEST['data_arr']['unk'];
		if($_REQUEST['cat_id_edit'] != ""){
			$cat_id = $_REQUEST['cat_id_edit'];
			$sql = "UPDATE user_service_offer_cat SET name='$cat_name',title='$cat_title',custom_html='$custom_html',custom_html_title='$custom_html_title' WHERE id = $cat_id";
			mysql_db_query(DB,$sql);
		}
		else{
			
			$sql = "INSERT INTO user_service_offer_cat(unk,name,title,custom_html,custom_html_title) VALUES('$unk','$cat_name','$cat_title','$custom_html','$custom_html_title')";
			mysql_db_query(DB,$sql);
			$cat_id = mysql_insert_id();
		}
		
		echo "<script type='text/javascript'>
					alert('הקטגוריה עודכנה בהצלחה');
					window.location = 'index.php?main=manage_user_service_offers&scope=cat&cat_id=$cat_id&unk=".UNK."&sesid=".SESID."';
			</script>
		";
		
	}
	if(isset($_REQUEST['delete_cat'])){
		
		$cat_id = $_REQUEST['cat_id_delete'];
		$move_offers_to = $_REQUEST['move_offers_to'];
		if($move_offers_to == "0"){
			echo "<script type='text/javascript'>
					alert('לפני מחיקה - יש לבחור לאן להעביר את המוצרים ששייכים לקטגוריה.');
					window.location = 'index.php?main=manage_user_service_offers&scope=cat&cat_id=$cat_id&unk=".UNK."&sesid=".SESID."';
			</script>
			";
			exit();
		}
		if($move_offers_to == 'delete'){
			$sql = "DELETE FROM user_service_offer WHERE cat = $cat_id";
			mysql_db_query(DB,$sql);
		}
		else{
			$sql = "UPDATE user_service_offer SET cat = $move_offers_to WHERE cat = $cat_id";
			mysql_db_query(DB,$sql);			
		}
		$sql = "DELETE FROM user_service_offer_cat_belong WHERE cat_id = $cat_id";
		mysql_db_query(DB,$sql);
		$sql = "DELETE FROM user_service_offer_page_cats WHERE cat_id = $cat_id";
		mysql_db_query(DB,$sql);
		$sql = "DELETE FROM user_service_offer_cat WHERE id = $cat_id";
		
		mysql_db_query(DB,$sql);		
		echo "<script type='text/javascript'>
				alert('הקטגוריה נמחקה');
				window.location = 'index.php?main=manage_user_service_offers&scope=cat&unk=".UNK."&sesid=".SESID."';
		</script>
		";
	}	
}
function manage_user_service_offers_cats(){
	global $word;
	global $domain_for_images_path;
	$site_domain = $domain_for_images_path;
	$path = "/home/ilan123/domains/$site_domain/public_html/user_service_offers/";				
	$http_path = "http://$site_domain/user_service_offers/";	

	if(isset($_REQUEST['cat_id']) && $_REQUEST['cat_id'] != ""  && $_REQUEST['cat_id'] != "0"){ 
		$sql = "select * from user_service_offer_cat where deleted = '0' and id=".$_REQUEST['cat_id']." and unk = '".UNK."'";
		$cats_result = mysql_db_query(DB,$sql);
		$cat = mysql_fetch_array($cats_result);
		
		
		$form_arr = array(
			array("hidden","main","manage_user_service_offers"),
			array("hidden","update_cat","1"),
			array("hidden","scope","cat"),
			array("hidden","cat_id_edit",$cat['id']),
			array("hidden","sesid",SESID),
			array("hidden","data_arr[unk]",UNK),
			array("hidden","unk",UNK),
			//array("hidden","table",$table),
			
			array("text","data_arr[name]",$cat['name'],"שם הקטגוריה(לשימוש בניהול)", "class='input_style'","","1"),
			array("text","data_arr[title]",$cat['title'],"כותרת הקטגוריה(כפי שתופיע באתר)", "class='input_style'","","1"),
			array("textarea","data_arr[custom_html]",$cat['custom_html'],"מבנה html של שורה בטבלה", "class='textarea_style_custom_html' style='width: 300px;'","","1"),		
			array("textarea","data_arr[custom_html_title]",$cat['custom_html_title'],"מבנה html של שורת הכותרת בטבלה", "class='textarea_style_custom_html' style='width: 300px;'  ","","1"),		
			
			array("submit","submit",$word[LANG]['submit_form'], "class='submit_style'")
		);
		
			echo "<div>";
			echo "<a href='index.php?main=manage_user_service_offers&scope=cat&unk=".UNK."&sesid=".SESID."'>חזרה לרשימה</a>";
			echo "</div>";		
		$more = "class='maintext' border='0'";	
		echo "<div>קוד להוספת הקטגוריה לאזור הטקסט: 
		
			<input type='text' name='cat_code' value='{{service_offers ".$cat['id']." service_offers}}' style='width:520px; text-align:left; direction:ltr;' />
		</div>";
		echo "<div>קוד להוספת הקטגוריה במצב פתוח: 
		
			<input type='text' name='cat_code' value='{{service_offers open ".$cat['id']." service_offers}}' style='width:520px; text-align:left; direction:ltr;' />
		</div>";				
		echo "<h3>ערוך קטגוריה</h3>";
		echo FormCreator::create_form($form_arr,"index.php", $more, "", "editorhtml");	
			$sql = "SELECT * FROM user_service_offer_cat WHERE  deleted = '0' and unk = '".UNK."'";
			$cat_result = mysql_db_query(DB,$sql);
			$cat_list = array("0"=>"בחר");
			$cat_list['delete'] = "מחיקה לצמיתות";
			while( $cat_i = mysql_fetch_array($cat_result) ){
				if($cat['id']!=$cat_i['id']){
					$cat_list[$cat_i['id']] = $cat_i['name'];
				}
			}
			$delete_form_arr = array(
			array("hidden","main","manage_user_service_offers"),
			array("hidden","delete_cat","1"),
			array("hidden","scope","cat"),
			array("hidden","cat_id_delete",$cat['id']),
			array("hidden","sesid",SESID),
			array("hidden","data_arr[unk]",UNK),
			array("hidden","unk",UNK),
			//array("hidden","table",$table),
			
			array("select","move_offers_to",$cat_list,"לאן להעביר את הצעות המחיר בתוך הקטגוריה","0","move_offers_to", "class='input_style''"),
					
			array("submit","submit","מחק קטגוריה", "class='submit_style' style='background:red;color:white;' onclick=\"return confirm('האם אתה בטוח שברצונך למחוק את הקטגוריה?');\"")
		);
		echo "<h3 style='color:red;'>מחיקת קטגוריה</h3>";
		echo FormCreator::create_form($delete_form_arr,"index.php", $more, "", "editorhtml");	
		
		manage_user_service_offers_offers($cat['id']);
	}	
	else{
		$form_arr = array(
			array("hidden","main","manage_user_service_offers"),
			array("hidden","update_cat","1"),
			array("hidden","scope","cat"),
			array("hidden","cat_id",""),
			array("hidden","sesid",SESID),
			array("hidden","data_arr[unk]",UNK),
			array("hidden","unk",UNK),
			//array("hidden","table",$table),
			
			array("text","data_arr[name]",$cat['name'],"שם הקטגוריה(לשימוש בניהול)", "class='input_style'","","1"),
			array("text","data_arr[title]",$cat['title'],"כותרת הקטגוריה(כפי שתופיע באתר)", "class='input_style'","","1"),
			array("textarea","data_arr[custom_html_title]","","מבנה html של שורת הכותרת בטבלה", "class='textarea_style_custom_html' style='width: 300px;'  onKeyDown='textCounter(this,document.editorhtml.remLen1,250)' onKeyUp='textCounter(this,document.editorhtml.remLen1,250)'","","1"),		

			array("textarea","data_arr[custom_html]","","מבנה html של שורה בטבלה", "class='textarea_style_custom_html' style='width: 300px;'  onKeyDown='textCounter(this,document.editorhtml.remLen1,250)' onKeyUp='textCounter(this,document.editorhtml.remLen1,250)'","","1"),		
					
			array("submit","submit",$word[LANG]['submit_form'], "class='submit_style'")
		);
		$more = "class='maintext' border='0'";	
		echo "<h3>הוסף קטגוריה</h3>";
		echo FormCreator::create_form($form_arr,"index.php", $more, "", "editorhtml");		
		$sql = "SELECT * FROM user_service_offer_cat WHERE  deleted = '0' and unk = '".UNK."'";
		$cats_result = mysql_db_query(DB,$sql);
		echo "<h3>רשימת הקטגוריות</h3>";
		while( $cat = mysql_fetch_array($cats_result) )
		{
			echo "<div style=''>";
			echo "<a style='text-decoration:none;display:block;font-size:17px;margin: 13px 0px;border: 1px outset #c3c3da;box-shadow: 5px -3px 11px -1px #a59696;padding: 4px 10px;' href='index.php?main=manage_user_service_offers&scope=cat&cat_id=".$cat['id']."&unk=".UNK."&sesid=".SESID."'>".$cat['name']."</a>";
			echo "</div>";
		}
		

	}

}

function manage_user_service_offers_page_cats(){
	$sql = "SELECT id FROM users WHERE unk = '".UNK."'";
	$user_result = mysql_db_query(DB,$sql);
	$user_arr = mysql_fetch_array($user_result);
	$user_id = $user_arr['id'];	

	if(isset($_REQUEST['page_id'])){
		$page_id = $_REQUEST['page_id'];
		if(isset($_POST['save_page_cats'])){
			
			$sql = "DELETE FROM user_service_offer_page_cats WHERE page_id= $page_id AND user_id = ".$user_id;
			$result = mysql_db_query(DB,$sql);
			
			$add_rows_sql = "";
			$add_row_i = 0;
			foreach($_POST['add_cat'] as $cat_id=>$add_cat){
				if($add_row_i!=0){
					$add_rows_sql .= ",";
				}
				$add_rows_sql .= "($page_id,$cat_id,$user_id)";
				$add_row_i++;
			}
			$insert_sql = "INSERT INTO user_service_offer_page_cats(page_id,cat_id,user_id) VALUES $add_rows_sql";
			mysql_db_query(DB,$insert_sql);
			echo "<div style='color:red;'><b>השינויים נשמרו בהצלחה</b></div>";
		}		
		$sql = "SELECT name FROM content_pages WHERE id = $page_id";
		$page_result = mysql_db_query(DB,$sql);
		$name_arr = mysql_fetch_array($page_result);
		$page_name = $name_arr['name'];
		$all_cats = array();
		$page_cats = array();
		
		$sql = "SELECT cat_id FROM user_service_offer_page_cats WHERE page_id= $page_id AND user_id = $user_id";
		$result = mysql_db_query(DB,$sql);
		while($cat = mysql_fetch_array($result)){
			$page_cats[$cat['cat_id']] = true;
		}		
				
		$sql = "SELECT name,id FROM user_service_offer_cat WHERE unk = '".UNK."'";
		$result = mysql_db_query(DB,$sql);
		while($cat = mysql_fetch_array($result)){
			$cat['checked'] = "";
			if(isset($page_cats[$cat['id']])){
				$cat['checked'] = "checked";
			}
			$all_cats[$cat['id']] = $cat;
		}
		
		
		echo "<h3>עריכת קטגוריות הצעות מחיר לעמוד: <a href='index.php?main=text&type=$page_id&text_id=$page_id&unk=".UNK."&sesid=".SESID."'>$page_name</a></h3>";
		echo "<form method='POST' action='index.php?main=manage_user_service_offers&scope=page&page_id=$page_id&unk=".UNK."&sesid=".SESID."'>";
		echo "<input type='hidden' name='save_page_cats' value='1' />";
		foreach($all_cats as $cat){
			echo "<div>";
				echo "<input type='checkbox' name='add_cat[".$cat['id']."]' value='1' ".$cat['checked']." />&nbsp".$cat['name'];
			echo "</div>";	
		}
		echo "<div><br/></div>";
		echo "<input type='submit' name='submit' value='שמור' />";
		echo "</form>";
	}
}

function manage_user_service_offer_cat_belong(){
	$sql = "SELECT id FROM users WHERE unk = '".UNK."'";
	$user_result = mysql_db_query(DB,$sql);
	$user_arr = mysql_fetch_array($user_result);
	$user_id = $user_arr['id'];	

	if(isset($_REQUEST['offer_id'])){
		$offer_id = $_REQUEST['offer_id'];
		if(isset($_POST['save_offer_cats'])){
			
			$sql = "DELETE FROM user_service_offer_cat_belong WHERE offer_id= $offer_id AND user_id = $user_id";
			$result = mysql_db_query(DB,$sql);
			
			$add_rows_sql = "";
			$add_row_i = 0;
			foreach($_POST['add_cat'] as $cat_id=>$add_cat){
				if($add_row_i!=0){
					$add_rows_sql .= ",";
				}
				$add_rows_sql .= "($offer_id,$cat_id,$user_id)";
				$add_row_i++;
			}
			$insert_sql = "INSERT INTO user_service_offer_cat_belong(offer_id,cat_id,user_id) VALUES $add_rows_sql";
			mysql_db_query(DB,$insert_sql);
			echo "<div style='color:red;'><b>השינויים נשמרו בהצלחה</b></div>";
		}		
		$sql = "SELECT name FROM user_service_offer WHERE id = $offer_id";
		$offer_result = mysql_db_query(DB,$sql);
		$name_arr = mysql_fetch_array($offer_result);
		$offer_name = $name_arr['name'];
		$all_cats = array();
		$offer_cats = array();
		
		$sql = "SELECT cat_id FROM user_service_offer_cat_belong WHERE offer_id= $offer_id AND user_id = $user_id";
		$result = mysql_db_query(DB,$sql);
		while($cat = mysql_fetch_array($result)){
			$offer_cats[$cat['cat_id']] = true;
		}		
				
		$sql = "SELECT name,id FROM user_service_offer_cat WHERE unk = '".UNK."'";
		$result = mysql_db_query(DB,$sql);
		while($cat = mysql_fetch_array($result)){
			$cat['checked'] = "";
			if(isset($offer_cats[$cat['id']])){
				$cat['checked'] = "checked";
			}
			$all_cats[$cat['id']] = $cat;
		}
		
		
		echo "<h3>עריכת קטגוריות להצעת מחיר: <a href='index.php?main=manage_user_service_offers&scope=offer&offer_id=$offer_id&unk=".UNK."&sesid=".SESID."'>$offer_name</a></h3>";
		echo "<form method='POST' action='index.php?main=manage_user_service_offers&scope=offer_cats&offer_id=$offer_id&unk=".UNK."&sesid=".SESID."'>";
		echo "<input type='hidden' name='save_offer_cats' value='1' />";
		foreach($all_cats as $cat){
			echo "<div>";
				echo "<input type='checkbox' name='add_cat[".$cat['id']."]' value='1' ".$cat['checked']." />&nbsp".$cat['name'];
			echo "</div>";	
		}
		echo "<div><br/></div>";
		echo "<input type='submit' name='submit' value='שמור' />";
		echo "</form>";
	}
}
