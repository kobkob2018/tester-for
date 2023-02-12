<?php
$domain_for_images_path = false;
define('HTTP_PATH','https://ilbiz.co.il');
define('SERVER_PATH','/home/ilan123/domains/ilbiz.co.il/public_html');
define("LANG","he");
function custom_posts_manager(){
	global $domain_for_images_path;
	$domain_for_images_path = "ilbiz.co.il";

	update_custom_posts_cats();
	update_custom_posts_posts();
	?>
	<h2>מודול כתבות להוספה לדפי תוכן</h2>
	<div>
		<a href="index.php?sesid=<?php echo SESID; ?>" class="maintext2">חזרה לתפריט הראשי</a>
	</div>
	<?php
	if(!isset($_REQUEST['scope'])){
		
		return manage_custom_posts_cats();
	}	
	else{
		$scope = $_REQUEST['scope'];
		if($scope == "cat"){
			
			return manage_custom_posts_cats();
		}
		if($scope == "post"){
			
			return manage_custom_posts_posts();
		}
		if($scope == "post_cats"){
			
			return manage_custom_post_cat_belong();
		}
		if($scope == "page"){
			
			return manage_custom_posts_page_cats();
		}	
		
	}	

}

function update_custom_posts_posts(){
	if(isset($_REQUEST['update_post'])){
		
		$set_params = array("name", "summary", "content", "url_link","image_url", "place");
		
		$post_name = $_REQUEST['data_arr']['name'];
		if(!isset($_REQUEST['cat_id'])){
			return;
		}
		$cat = $_REQUEST['cat_id'];
		$new_insert = false;
		$insert_id = false;
		$post_id = false;
		if($_REQUEST['post_id_edit'] != ""){
			$set_sql = "cat = '".$cat."'";
			foreach($set_params as $set_param){
				if(isset($_REQUEST['data_arr'][$set_param])){
					$param_val = str_replace("'","''",$_REQUEST['data_arr'][$set_param]);
					$set_sql .= ",".$set_param."='".$param_val."'";
				}
			}
			$post_id = $_REQUEST['post_id_edit'];
			$sql = "UPDATE custom_post SET $set_sql WHERE id = $post_id";
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
			$sql = "INSERT INTO custom_post($insert_params_sql) VALUES($insert_vals_sql)";
			$new_insert = true;			
		}
		
		mysql_db_query(DB,$sql);
		if($new_insert){
			$insert_id = mysql_insert_id();
			$post_id = $insert_id;
		}
			
		if($_FILES['post_image']['name'] != ""){
			global $domain_for_images_path;
			$site_domain = $domain_for_images_path;
			$path = "/home/ilan123/domains/$site_domain/public_html/custom_posts/";				
			$http_path = "http://$site_domain/custom_posts/";	
			if(!is_dir($path)){
				$mask=umask(0);
				mkdir($path, 0777);
				umask($mask);
			}
		
			$temp_file_name = $_FILES['post_image']['name'];
			$file_name_arr = explode(".",$temp_file_name);
			$ext_str = $file_name_arr[(count($file_name_arr) - 1)];
			$ext_str = strtolower($ext_str);
			$file_error = false;
			if($ext_str!="png" && $ext_str!="jpg" && $ext_str!="gif"){
				$file_error = "התמונה שהעלית לא תקינה(ניתן להעלות קבצים עם הסיומות הבאות בלבד: gif,jpg,png)";
			}
			elseif($_FILES["post_image"]["size"] > 500000){
				$file_error = "התמונה שהעלית גדולה מידיי";
			}
			else{
				if(!$insert_id){
					$sql = "SELECT img FROM custom_post WHERE id = $post_id";
					$res = mysql_db_query(DB,$sql);
					$curent_image_data = mysql_fetch_array($res);
					$curent_image = $curent_image_data['img'];
					if($curent_image!=""){
						unlink($path.$curent_image);
					}
				}

				$upload_image_name = "post_$post_id.$ext_str";
				$up = move_uploaded_file($_FILES['post_image']['tmp_name'],$path.$upload_image_name);
				if($up){
					$sql = "UPDATE custom_post SET img = '$upload_image_name' WHERE id='$post_id'";
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
				alert('הכתבה עודכנה בהצלחה');
				window.location = 'index.php?main=anf&gf=custom_posts_manager&scope=post&post_id=$post_id&sesid=".SESID."';
		</script>
		";
	}
	if(isset($_REQUEST['delete_post'])){
		
		$post_id = $_REQUEST['post_id_delete'];
		$sql = "DELETE FROM custom_post WHERE id = $post_id";
		
		mysql_db_query(DB,$sql);
		$cat_id = $_REQUEST['cat_id'];
		echo "<script type='text/javascript'>
				alert('הכתבה נמחקה');
				window.location = 'index.php?main=anf&gf=custom_posts_manager&scope=cat&cat_id=$cat_id&sesid=".SESID."';
		</script>
		";
	}
	//return;
	//GlobalFunctions::upload_file_to_server($temp_name , $imgName , $image_settings['server_path'] );
	//resize($imgName, $image_settings['server_path'], $image_settings['thumbnail_width'],$image_settings['thumbnail_height']);
}

function manage_custom_posts_posts($selected_cat = false){
	global $domain_for_images_path;
	$site_domain = $domain_for_images_path;
	$path = "/home/ilan123/domains/$site_domain/public_html/custom_posts/";				
	$http_path = "http://$site_domain/custom_posts/";	
	$sql = "SELECT * FROM custom_post_cat WHERE  deleted = '0' ";
	$cat_result = mysql_db_query(DB,$sql);
	$cat_list = array();
	while( $cat = mysql_fetch_array($cat_result) ){
		$cat_list[$cat['id']] = $cat['name'];
	}
	if(isset($_REQUEST['post_id']) && $_REQUEST['post_id'] != ""){
		$sql = "select * from custom_post where deleted = '0' and id=".$_REQUEST['post_id']."";
		$posts_result = mysql_db_query(DB,$sql);
		$post = mysql_fetch_array($posts_result);
		
		if($post['img'] != ""){
			echo "<img src='".$http_path.$post['img']."' style='max-width:300px;'/>להחלפת האייקון העלה תמונה בטופס למטה ושמור";
		}
		$post_id = $post['id'];
		$form_arr = array(
			array("hidden","main","anf"),
			array("hidden","gf","custom_posts_manager"),
			array("hidden","scope","post"),
			array("hidden","post_id_edit",$post['id']),
			array("hidden","post_id",$post['id']),
			array("hidden","sesid",SESID),
			array("select","cat_id",$cat_list,"שם הקטגוריה",$post['cat'],"cat_id", "class='input_style''"),
			array("text","data_arr[name]",$post['name'],"כותרת", "class='input_style'","","1"),
			array("textarea","data_arr[summary]",$post['summary'],"תיאור קצר", "class='textarea_style_summary' style='width: 300px;'  onKeyDown='textCounter(this,document.editorhtml.remLen1,250)' onKeyUp='textCounter(this,document.editorhtml.remLen1,250)'","","1"),
			array("textarea","data_arr[content]",$post['content'],"תוכן", "class='textarea_style_summary' style='width: 300px;'  onKeyDown='textCounter(this,document.editorhtml.remLen1,250)' onKeyUp='textCounter(this,document.editorhtml.remLen1,250)'","","1"),
			array("new_file","post_image","","תמונה"),
			array("text","data_arr[url_link]",$post['url_link'],"לינק - כתובת", "class='input_style'","","1"),
			array("text","data_arr[image_url]",$post['image_url'],"כתובת תמונה - באתר אחר", "class='input_style'","","1"),
			array("text","data_arr[place]",$post['place'],"מיקום", "class='input_style'"),			
			array("submit","update_post","שליחה", "class='submit_style'")
		);
		$more = "class='maintext' border='0'";	
		echo "<h3>ערוך כתבה</h3>";
		echo "<a href='index.php?main=anf&gf=custom_posts_manager&scope=cat&cat_id=".$post['cat']."&sesid=".SESID."'>חזרה לקטגוריה</a>";
		echo FormCreator::create_form($form_arr,"index.php", $more, "", "editorhtml");	
		echo "<div>";
		echo "<a href='index.php?main=anf&gf=custom_posts_manager&scope=post_cats&post_id=$post_id&&sesid=".SESID."'>לחץ כאן לשייך את הכתבה לקטגוריות</a>";
		echo "</div>";
		$delete_form_arr = array(
			array("hidden","main","anf"),
			array("hidden","gf","custom_posts_manager"),
			array("hidden","delete_post","1"),
			array("hidden","cat_id",$post['cat']), 
			array("hidden","scope","cat"),
			array("hidden","post_id_delete",$post['id']),
			array("hidden","sesid",SESID),
			//array("hidden","table",$table),					
			array("submit","submit","לחץ כאן למחיקת הכתבה", "style='color:red;' onclick=\"return confirm('האם אתה בטוח שברצונך למחוק את הכתבה?');\"")
		);
		echo FormCreator::create_form($delete_form_arr,"index.php", $more, "", "editorhtml");	
	}	
	else{
		$form_arr = array(
			array("hidden","main","anf"),
			array("hidden","gf","custom_posts_manager"),
			array("hidden","scope","cat"),

			array("hidden","sesid",SESID),
			array("select","cat_id",$cat_list,"שם הקטגוריה",$selected_cat,"cat_id", "class='input_style''"),
			array("text","data_arr[name]","","כותרת", "class='input_style'","","1"),
			array("textarea","data_arr[summary]","","תיאור קצר", "class='textarea_style_summary' style='width: 300px;'","","1"),
			array("textarea","data_arr[content]","","תוכן", "class='textarea_style_summary' style='width: 300px;'  ","","1"),
			array("new_file","post_image","","תמונה"),
			array("text","data_arr[url_link]","","לינק כתובת", "class='input_style'","","1"),
			array("text","data_arr[image_url]","","כתובת תמונה באתר אחר (מומלץ לשים רק כתובות מאובטחות)", "class='input_style'","","1"),
			array("text","data_arr[place]","0","מיקום", "class='input_style'"),
			array("submit","update_post","שליחה", "class='submit_style'")
		);
		if(isset($_REQUEST['cat'])){
			$form_arr[] = array("hidden","cat",$_REQUEST['cat']);
		}
		$more = "class='maintext' border='0'";	
		echo "<h3>הוסף כתבה</h3>";
		echo FormCreator::create_form($form_arr,"index.php", $more, "", "editorhtml");	
		$cat_where = "";
		if($selected_cat){
			$cat_where = " AND cat = $selected_cat ";
		}		
		$sql = "SELECT * FROM custom_post WHERE  deleted = '0' ".$cat_where." ";
		$posts_result = mysql_db_query(DB,$sql);
		echo "<h3>כתבות</h3>";
		while( $post = mysql_fetch_array($posts_result) )
		{
			echo "<div>";
			echo "<a style='text-decoration:none;display:block;font-size:17px;margin: 13px 0px;border: 1px outset #c3c3da;box-shadow: 5px -3px 11px -1px #a59696;padding: 4px 10px;' href='index.php?main=anf&gf=custom_posts_manager&scope=post&post_id=".$post['id']."&sesid=".SESID."'>".$post['name']."</a>";
			echo "</div>";
		}
		

	}

}

function update_custom_posts_cats(){
	if(isset($_REQUEST['update_cat'])){
		
		$cat_name = str_replace("'","''",$_REQUEST['data_arr']['name']);
		$cat_title = str_replace("'","''",$_REQUEST['data_arr']['title']);
		$custom_html = str_replace("'","''",$_REQUEST['data_arr']['custom_html']);
		$custom_html_title = str_replace("'","''",$_REQUEST['data_arr']['custom_html_title']);
		if($_REQUEST['cat_id_edit'] != ""){
			$cat_id = $_REQUEST['cat_id_edit'];
			$sql = "UPDATE custom_post_cat SET name='$cat_name',title='$cat_title',custom_html='$custom_html',custom_html_title='$custom_html_title' WHERE id = $cat_id";
			mysql_db_query(DB,$sql);
		}
		else{
			
			$sql = "INSERT INTO custom_post_cat(name,title,custom_html,custom_html_title) VALUES('$cat_name','$cat_title','$custom_html','$custom_html_title')";
			mysql_db_query(DB,$sql);
			$cat_id = mysql_insert_id();
		}
		
		echo "<script type='text/javascript'>
					alert('הקטגוריה עודכנה בהצלחה');
					window.location = 'index.php?main=anf&gf=custom_posts_manager&scope=cat&cat_id=$cat_id&sesid=".SESID."';
			</script>
		";
		
	}
	if(isset($_REQUEST['delete_cat'])){
		
		$cat_id = $_REQUEST['cat_id_delete'];
		$move_posts_to = $_REQUEST['move_posts_to'];
		if($move_posts_to == "0"){
			echo "<script type='text/javascript'>
					alert('לפני מחיקה - יש לבחור לאן להעביר את המוצרים ששייכים לקטגוריה.');
					window.location = 'index.php?main=anf&gf=custom_posts_manager&scope=cat&cat_id=$cat_id&sesid=".SESID."';
			</script>
			";
			exit();
		}
		if($move_posts_to == 'delete'){
			$sql = "DELETE FROM custom_post WHERE cat = $cat_id";
			mysql_db_query(DB,$sql);
		}
		else{
			$sql = "UPDATE custom_post SET cat = $move_posts_to WHERE cat = $cat_id";
			mysql_db_query(DB,$sql);			
		}
		$sql = "DELETE FROM custom_post_cat_belong WHERE cat_id = $cat_id";
		mysql_db_query(DB,$sql);
		$sql = "DELETE FROM custom_post_page_cats WHERE cat_id = $cat_id";
		mysql_db_query(DB,$sql);
		$sql = "DELETE FROM custom_post_cat WHERE id = $cat_id";
		
		mysql_db_query(DB,$sql);		
		echo "<script type='text/javascript'>
				alert('הקטגוריה נמחקה');
				window.location = 'index.php?main=anf&gf=custom_posts_manager&scope=cat&sesid=".SESID."';
		</script>
		";
	}	
}
function manage_custom_posts_cats(){
	global $domain_for_images_path;
	$site_domain = $domain_for_images_path;
	$path = "/home/ilan123/domains/$site_domain/public_html/custom_posts/";				
	$http_path = "http://$site_domain/custom_posts/";	

	if(isset($_REQUEST['cat_id']) && $_REQUEST['cat_id'] != ""  && $_REQUEST['cat_id'] != "0"){ 
		$sql = "select * from custom_post_cat where deleted = '0' and id=".$_REQUEST['cat_id']."";
		$cats_result = mysql_db_query(DB,$sql);
		$cat = mysql_fetch_array($cats_result);
		
		
		$form_arr = array(
			array("hidden","main","anf"),
			array("hidden","gf","custom_posts_manager"),
			array("hidden","update_cat","1"),
			array("hidden","scope","cat"),
			array("hidden","cat_id_edit",$cat['id']),
			array("hidden","sesid",SESID),
			//array("hidden","table",$table),
			
			array("text","data_arr[name]",$cat['name'],"שם הקטגוריה(לשימוש בניהול)", "class='input_style'","","1"),
			array("text","data_arr[title]",$cat['title'],"כותרת הקטגוריה(כפי שתופיע באתר)", "class='input_style'","","1"),
			array("textarea","data_arr[custom_html]",$cat['custom_html'],"מבנה html של שורה בטבלה", "class='textarea_style_custom_html' style='width: 300px;'","","1"),		
			array("textarea","data_arr[custom_html_title]",$cat['custom_html_title'],"מבנה html של שורת הכותרת בטבלה", "class='textarea_style_custom_html' style='width: 300px;'  ","","1"),		
			
			array("submit","submit","שליחה", "class='submit_style'")
		);
		
			echo "<div>";
			echo "<a href='index.php?main=anf&gf=custom_posts_manager&scope=cat&sesid=".SESID."'>חזרה לרשימה</a>";
			echo "</div>";		
		$more = "class='maintext' border='0'";	
		echo "<div>קוד להוספת הקטגוריה לאזור הטקסט: 
		
			<input type='text' name='cat_code' value='{{custom_posts ".$cat['id']." custom_posts}}' style='width:210px; text-align:left; direction:ltr;' />
		</div>";
		/*
		echo "<div>קוד להוספת הקטגוריה במצב פתוח: 
		
			<input type='text' name='cat_code' value='{{custom_posts open ".$cat['id']." custom_posts}}' style='width:520px; text-align:left; direction:ltr;' />
		</div>";
*/		
		echo "<h3>ערוך קטגוריה</h3>";
		echo FormCreator::create_form($form_arr,"index.php", $more, "", "editorhtml");	
			$sql = "SELECT * FROM custom_post_cat WHERE  deleted = '0'";
			$cat_result = mysql_db_query(DB,$sql);
			$cat_list = array();
			$cat_list['delete'] = "מחיקה לצמיתות";
			while( $cat_i = mysql_fetch_array($cat_result) ){
				if($cat['id']!=$cat_i['id']){
					$cat_list[$cat_i['id']] = $cat_i['name'];
				}
			}
			$delete_form_arr = array(
			array("hidden","main","anf"),
			array("hidden","gf","custom_posts_manager"),
			array("hidden","delete_cat","1"),
			array("hidden","scope","cat"),
			array("hidden","cat_id_delete",$cat['id']),
			array("hidden","sesid",SESID),
			//array("hidden","table",$table),
			
			array("select","move_posts_to",$cat_list,"לאן להעביר את הכתבות בתוך הקטגוריה","0","move_posts_to", "class='input_style''"),
					
			array("submit","submit","שליחה", "class='submit_style' onclick=\"return confirm('האם אתה בטוח שברצונך למחוק את הקטגוריה?');\"")
		);
		echo "<h3 style='color:red;'>מחיקת קטגוריה</h3>";
		echo FormCreator::create_form($delete_form_arr,"index.php", $more, "", "editorhtml");	
		
		manage_custom_posts_posts($cat['id']);
	}	
	else{
		$form_arr = array(
			array("hidden","main","anf"),
			array("hidden","gf","custom_posts_manager"),
			array("hidden","update_cat","1"),
			array("hidden","scope","cat"),
			array("hidden","cat_id",""),
			array("hidden","sesid",SESID),
			//array("hidden","table",$table),
			
			array("text","data_arr[name]","","שם הקטגוריה(לשימוש בניהול)", "class='input_style'","","1"),
			array("text","data_arr[title]","","כותרת הקטגוריה(כפי שתופיע באתר)", "class='input_style'","","1"),
			array("textarea","data_arr[custom_html_title]","","מבנה html של שורת הכותרת בטבלה", "class='textarea_style_custom_html' style='width: 300px;'  onKeyDown='textCounter(this,document.editorhtml.remLen1,250)' onKeyUp='textCounter(this,document.editorhtml.remLen1,250)'","","1"),		

			array("textarea","data_arr[custom_html]","","מבנה html של שורה בטבלה", "class='textarea_style_custom_html' style='width: 300px;'  onKeyDown='textCounter(this,document.editorhtml.remLen1,250)' onKeyUp='textCounter(this,document.editorhtml.remLen1,250)'","","1"),		
					
			array("submit","submit","שליחה", "class='submit_style'")
		);
		$more = "class='maintext' border='0'";	
		echo "<h3>הוסף קטגוריה</h3>";
		echo FormCreator::create_form($form_arr,"index.php", $more, "", "editorhtml");		
		$sql = "SELECT * FROM custom_post_cat WHERE  deleted = '0'";
		$cats_result = mysql_db_query(DB,$sql);
		echo "<h3>רשימת הקטגוריות</h3>";
		while( $cat = mysql_fetch_array($cats_result) )
		{
			echo "<div style=''>";
			echo "<a style='text-decoration:none;display:block;font-size:17px;margin: 13px 0px;border: 1px outset #c3c3da;box-shadow: 5px -3px 11px -1px #a59696;padding: 4px 10px;' href='index.php?main=anf&gf=custom_posts_manager&scope=cat&cat_id=".$cat['id']."&sesid=".SESID."'>".$cat['name']."</a>";
			echo "</div>";
		}
		

	}

}

function manage_custom_post_cat_belong(){

	if(isset($_REQUEST['post_id'])){
		$post_id = $_REQUEST['post_id'];
		if(isset($_POST['save_post_cats'])){
			
			$sql = "DELETE FROM custom_post_cat_belong WHERE post_id= $post_id";
			$result = mysql_db_query(DB,$sql);
			
			$add_rows_sql = "";
			$add_row_i = 0;
			foreach($_POST['add_cat'] as $cat_id=>$add_cat){
				if($add_row_i!=0){
					$add_rows_sql .= ",";
				}
				$add_rows_sql .= "($post_id,$cat_id)";
				$add_row_i++;
			}
			$insert_sql = "INSERT INTO custom_post_cat_belong(post_id,cat_id) VALUES $add_rows_sql";
			mysql_db_query(DB,$insert_sql);
			echo "<div style='color:red;'><b>השינויים נשמרו בהצלחה</b></div>";
		}		
		$sql = "SELECT name FROM custom_post WHERE id = $post_id";
		$post_result = mysql_db_query(DB,$sql);
		$name_arr = mysql_fetch_array($post_result);
		$post_name = $name_arr['name'];
		$all_cats = array();
		$post_cats = array();
		
		$sql = "SELECT cat_id FROM custom_post_cat_belong WHERE post_id= $post_id";
		$result = mysql_db_query(DB,$sql);
		while($cat = mysql_fetch_array($result)){
			$post_cats[$cat['cat_id']] = true;
		}		
				
		$sql = "SELECT name,id FROM custom_post_cat WHERE 1";
		$result = mysql_db_query(DB,$sql);
		while($cat = mysql_fetch_array($result)){
			$cat['checked'] = "";
			if(isset($post_cats[$cat['id']])){
				$cat['checked'] = "checked";
			}
			$all_cats[$cat['id']] = $cat;
		}
		
		
		echo "<h3>עריכת קטגוריות לכתבה: <a href='index.php?main=anf&gf=custom_posts_manager&scope=post&post_id=$post_id&sesid=".SESID."'>$post_name</a></h3>";
		echo "<form method='POST' action='index.php?main=anf&gf=custom_posts_manager&scope=post_cats&post_id=$post_id&sesid=".SESID."'>";
		echo "<input type='hidden' name='save_post_cats' value='1' />";
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
