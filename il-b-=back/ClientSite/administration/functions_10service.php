<?

function updateCats10Servcats()
{
	
	$view = ( $_GET['c'] == "" ) ? "home" : "cats" ;
	switch( $view )
	{
		case "home" :
			$sql = "SELECT id , cat_name FROM biz_categories WHERE father=0 AND status=1 AND hidden=0 ORDER BY place";
			$t = 1;
		break;
		
		case "cats" :
			$sql = "SELECT id , cat_name FROM biz_categories WHERE father='".$_GET['c']."' AND status=1 AND hidden=0 ORDER BY place";
			$t = 2;
		break;
	}
	$res = mysql_db_query(DB ,$sql );
	
	$sql = "SELECT cat_name FROM biz_categories WHERE id=".$_GET['c']." AND status=1 AND hidden=0";
	$res_father = mysql_db_query(DB ,$sql );
	$data_father = mysql_fetch_array($res_father);
	
	$take=0;
	echo "<table border=0 cellpadding=0 cellspacing=0 class='maintext'>";
	
		echo "<tr>";
			echo "<td align=center><b>שיוך</b></td>";
			echo "<td width=10></td>";
			echo "<td><b>שם הקטגוריה</b></td>";
			echo "<td width=10></td>";
			echo "<td><b>עדכון טקסט</b></td>";
			echo "<td width=10></td>";
			echo "<td><b>האם קיים תוכן?</b></td>";
		echo "</tr>";
		
		while( $data = mysql_fetch_array($res) )
		{
			if( $t == 1 )
				$belong_to = "ראשי";
			else
				$belong_to = stripslashes($data_father['cat_name']);
			
			
			$sqlCheck = "SELECT id , img , cat_name FROM biz_categories WHERE father='".$data['id']."' AND status=1 AND hidden=0 ORDER BY place";
			$resCheck = mysql_db_query(DB,$sqlCheck);
			$num_check = mysql_num_rows($resCheck);
			
			if( $num_check > 0 & !($t >= 2) )
			{
				$cat_a_s = "<a href='index.php?main=updateCats10Servcats&c=".$data['id']."&type=updateCats10Servcats&unk=".UNK."&sesid=".SESID."' class='maintext'>";
				$cat_a_e = "</a>";
			}
			
			$sql= "SELECT content FROM cats_text_10service WHERE cat_id='".$data['id']."'";
			$resCheck = mysql_db_query(DB,$sql);
			$check_content = mysql_fetch_array($resCheck);
			
			$result_cheker = ( !empty($check_content['content']) ) ? "כן" : "לא";
			
			echo "<tr><td colspan=7 height=7></td></td>";
			
			echo "<tr>";
				echo "<td>".$belong_to."</td>";
				echo "<td width=10></td>";
				echo "<td>".$cat_a_s.stripslashes($data['cat_name']).$cat_a_e."</td>";
				echo "<td width=10></td>";
				echo "<td><a href='index.php?main=updateCats10Servcats_edit&type=updateCats10Servcats&f=".$_GET['c']."&c=".$data['id']."&unk=".UNK."&sesid=".SESID."' class='maintext'>עדכון טקסט</a></td>";
				echo "<td width=10></td>";
				echo "<td>".$result_cheker."</td>";
			echo "</tr>";
			
			
			
		}
	echo "</table>";
	
}

function updateCats10Servcats_edit()
{
	global $word;
	
	$sql = "select * from cats_text_10service where cat_id = '".$_GET['c']."'";
	$res = mysql_db_query(DB,$sql);
	$data = mysql_fetch_array($res);
	
	$sql = "SELECT father, cat_name FROM biz_categories WHERE id=".$_GET['c']." AND status=1 AND hidden=0";
	$res = mysql_db_query(DB ,$sql );
	$data_cat = mysql_fetch_array($res);
	
	$sql = "SELECT cat_name FROM biz_categories WHERE id=".$data_cat['father']." AND status=1 AND hidden=0";
	$res = mysql_db_query(DB ,$sql );
	$data_father = mysql_fetch_array($res);
	
	echo "<table border=\"0\" cellspacing=\"0\" cellpadding=\"0\" class=\"maintext\" width='100%'>";
	echo "<form action=\"index.php\" name=\"editorhtml\" method=\"POST\" enctype=\"multipart/form-data\">";
	echo "<input type=\"hidden\" name=\"main\" value=\"updateCats10Servcats_edit_DB\">";
	echo "<input type=\"hidden\" name=\"unk\" value=\"".UNK."\">";
	echo "<input type=\"hidden\" name=\"sesid\" value=\"".SESID."\">";
	echo "<input type=\"hidden\" name=\"cat_id\" value=\"".$_GET['c']."\">";
	echo "<input type=\"hidden\" name=\"f\" value=\"".$_GET['f']."\">";
		
		$father_name = ( $data_father['cat_name'] ) ? "<u>".stripslashes($data_father['cat_name'])."</u> ->  " : "";
		echo "<tr>";
			echo "<td><h2>עדכון ".$father_name."<u>".stripslashes($data_cat['cat_name'])."</u></h2></td>";
		echo "</tr>";
		
		echo "<tr><Td height=\"7\"></TD></tr>";
		
		echo "<tr><td>";
			
			load_editor_text( "content" , stripcslashes($data['content']) );
			
		echo "</td></tr>";
		
		echo "<tr><Td height=\"7\"></TD></tr>";
		
		echo "<tr>";
			echo "<td align=\"center\"><input type=\"submit\" value=\"".$word[LANG]['save']."\" class=\"submit_style\"></td>";
		echo "</tr>";
	
	echo "</form>";
	echo "</table>";
}

function updateCats10Servcats_edit_DB()
{
	$sql = "select * from cats_text_10service where cat_id = '".$_POST['cat_id']."'";
	$res = mysql_db_query(DB,$sql);
	$data = mysql_fetch_array($res);
	
	if( empty($data['cat_id']) )
	{
		$sql = "INSERT INTO cats_text_10service (cat_id,content) VALUES (
			'".$_POST['cat_id']."' , '".addslashes($_POST['content'])."'
		)";
	}
	else
	{
		$sql = "UPDATE cats_text_10service SET content = '".addslashes($_POST['content'])."' WHERE cat_id = '".$_POST['cat_id']."'";
	}
	$res = mysql_db_query(DB,$sql);
	
	echo "<script>window.location.href='index.php?main=updateCats10Servcats&c=".$_POST['f']."&type=updateCats10Servcats&unk=".UNK."&sesid=".SESID."';</script>";
		exit;
}


function edit_10service_product_images()
{
	$sql = "SELECT domain FROM users WHERE unk = '".UNK."' ";
	$res = mysql_db_query(DB,$sql);
	$userData = mysql_fetch_array($res);
	
	$domain = ( $_GET['b1s'] == "1" ) ? "10service.co.il" : $userData['domain'];
	$server_path = "/home/ilan123/domains/".$domain."/public_html/product_image/".$_GET['product_id']."/";
	
	echo "<form action=\"index.php\" name=\"edit_10service_product_images\" method=\"POST\" enctype=\"multipart/form-data\" style='padding:0; margin:0;'>";
	echo "<input type=\"hidden\" name=\"main\" value=\"edit_10service_product_images_Prosses\">";
	echo "<input type=\"hidden\" name=\"unk\" value=\"".UNK."\">";
	echo "<input type=\"hidden\" name=\"sesid\" value=\"".SESID."\">";
	echo "<input type=\"hidden\" name=\"product_id\" value=\"".$_GET['product_id']."\">";
	echo "<input type=\"hidden\" name=\"b1s\" value=\"".$_GET['b1s']."\">";
	
	echo "<table border=\"0\" cellspacing=\"0\" cellpadding=\"0\" class=\"maintext\" width='100%'>";
	
	for( $img=2 ; $img <= 5 ; $img++ )
	{
		$view_file = "";
		$del_files = "";
		if( is_dir($server_path) )
		{
			$img_L = $img."-L";
			foreach (glob($server_path.$img_L."*") as $filename) {
				$explo = explode($_GET['product_id']."/",$filename);
				$exte = substr($explo[1],(strpos($explo[1],".")+1));
			}
			
			$temp_path = $server_path.$img_L.".".$exte;
			if( file_exists($temp_path) && !is_dir($temp_path) )
			{
				$view_file = "<a href='http://".$domain."/product_image/".$_GET['product_id']."/".$img_L.".".$exte."' class='maintext' target='_blank'>צפה בתמונה</a>";
				$del_files = "<a href='index.php?main=del_product_files&pro_id=".$_GET['product_id']."&b1s=".$_GET['b1s']."&img=".$img."&unk=".UNK."&sesid=".SESID."' class='maintext' onclick='return can_i_del()'>מחק תמונה</a>";
			}
			
		}
		
		
		echo "<tr>";
			echo "<td>תמונה מספר ".$img."</td>";
			echo "<td width='10'></td>";
			echo "<td><input type='file' name='product_img_".$img."' class='input_style'></td>";
			
			echo "<td>".$view_file."</td>";
			echo "<td width='10'></td>";
			echo "<td>".$del_files."</td>";
			
		echo "</tr>";
	}
	
	
	echo "<tr>";
		echo "<td></td>";
		echo "<td width='10'></td>";
		echo "<td><input type='submit' value='עדכן' class='submit_style'></td>";
	echo "</tr>";
		
	echo "</table>";
	
	echo "</form>";
}

function edit_10service_product_images_Prosses()
{
	$sql = "SELECT domain FROM users WHERE unk = '".UNK."' ";
	$res = mysql_db_query(DB,$sql);
	$userData = mysql_fetch_array($res);
	
	$domain = ( $_POST['b1s'] == "1" ) ? "10service.co.il" : $userData['domain'];
	$server_path = "/home/ilan123/domains/".$domain."/public_html/product_image/";
	
	if($_FILES)
	{
		GlobalFunctions::create_dir_s("/home/ilan123/domains/".$domain."/public_html/","product_image");
		
		GlobalFunctions::create_dir_s($server_path,$_POST['product_id']);
		
		$server_path .= $_POST['product_id']."/";
		
		for($temp=2 ; $temp<=5 ; $temp++)
		{
			$temp_name = "product_img_".$temp;
			
			$field_name_mame = $_FILES[$temp_name]['name'];
			
			if($_FILES[$temp_name]['type'] == "image/jpeg" || $_FILES[$temp_name]['type'] == "image/gif" || $_FILES[$temp_name]['type'] == "image/pjpeg")
			{
				$exte = substr($field_name_mame,(strpos($field_name_mame,".")+1));
				
				$logo_name_small = $temp."-S.".$exte;
				$logo_name_large = $temp."-L.".$exte;
				$logo_name_ex = $temp."-EX.".$exte;
				
				$abpath_temp_unlink_small = $server_path.$logo_name_small;
				if( file_exists($abpath_temp_unlink_small) && !is_dir($abpath_temp_unlink_small) )
					unlink($abpath_temp_unlink_small);
					
				$abpath_temp_unlink_large = $server_path.$logo_name_large;
				if( file_exists($abpath_temp_unlink_large) && !is_dir($abpath_temp_unlink_large) )
					unlink($abpath_temp_unlink_large);
				
				$abpath_temp_unlink_ex = $server_path.$logo_name_ex;
				if( file_exists($abpath_temp_unlink_ex) && !is_dir($abpath_temp_unlink_ex) )
					unlink($abpath_temp_unlink_ex);
				
				
				GlobalFunctions::upload_file_to_server($temp_name , $logo_name_ex , $server_path , array("image") , array() , "2" , "copy");
				GlobalFunctions::upload_file_to_server($temp_name , $logo_name_large , $server_path , array("image") , array() , "2" , "copy" );
				GlobalFunctions::upload_file_to_server($temp_name , $logo_name_small , $server_path );
				
				resize($logo_name_small, $server_path, "75","50");
				resize($logo_name_large, $server_path, "200","250");
				resize($logo_name_ex, $server_path, "650","500");
				
			}
			
		}
		
	}
	
	
	
	echo "<script>window.close();</script>";
}

function del_product_files()
{
	$sql = "SELECT domain FROM users WHERE unk = '".UNK."' ";
	$res = mysql_db_query(DB,$sql);
	$userData = mysql_fetch_array($res);
	
	$domain = ( $_GET['b1s'] == "1" ) ? "10service.co.il" : $userData['domain'];
	$server_path = "/home/ilan123/domains/".$domain."/public_html/product_image/".$_GET['pro_id']."/";
	
	if( empty($_GET['pro_id']) )
		die('#1');
	if( empty($_GET['delDir']) && empty($_GET['img']) )
		die('#2');
	
	if( is_dir($server_path) )
	{
		if( $_GET['delDir'] == "1" )
			unlink($server_path);
		else
		{
			foreach (glob($server_path.$_GET['img']."-*") as $filename)
			{
				unlink($filename);
			}
		}
	}
	
	echo "<script>window.location.href='index.php?main=edit_10service_product_images&b1s=".$_GET['b1s']."&product_id=".$_GET['pro_id']."&type=&unk=".UNK."&sesid=".SESID."';</script>";
		exit;
}


function purchase_tracking_list()
{
	$sql = "SELECT id FROM users WHERE unk = '".UNK."'";
	$res_checkID = mysql_db_query(DB,$sql);
	$data_checkID = mysql_fetch_array($res_checkID);
	
	$site_id_qry = ( $data_checkID['id'] != "793" ) ? "AND site_id = '".$data_checkID['id']."' AND payment_status=2 " : "";
	$sql = "SELECT * FROM purchase_tracking WHERE 1 ".$site_id_qry." ";
	$res = mysql_db_query(DB,$sql);
	
	echo "<form action=\"index.php\" name=\"purchase_tracking_form\" method=\"POST\" style='margin:0; padding:0;'>";
	echo "<table border=\"0\" cellspacing=\"0\" cellpadding=\"0\" class=\"maintext\" width='100%'>";
		
		echo "<tr>";
			echo "<td><b>מספר רכישה</b></td>";
			echo "<td width=10></td>";
			echo "<td><b>תאריך רכישה</b></td>";
			echo "<td width=10></td>";
			
			if( $data_checkID['id'] == "793" )
			{
				echo "<td><b>שם הספק</b></td>";
				echo "<td width=10></td>";
			}
			
			echo "<td><b>שם הרוכש</b></td>";
			echo "<td width=10></td>";
			echo "<td><b>סטטוס תשלום</b></td>";
			echo "<td width=10></td>";
			echo "<td><b>סטטוס מעקב</b></td>";
			echo "<td width=10></td>";
			echo "<td><b>צפיה</b></td>";
		echo "</tr>";
		
		while( $data = mysql_fetch_array($res) )
		{
			if( $data_checkID['id'] == "793" )
			{
				$sql = "SELECT name , domain FROM users WHERE id = '".$data['site_id']."'";
				$res_site = mysql_db_query(DB,$sql);
				$data_site = mysql_fetch_array($res_site);
			}
			
			
			$sql = "SELECT fname,lname FROM  net_users WHERE id = '".$data['client_id']."'";
			$res_user = mysql_db_query(DB,$sql);
			$data_user = mysql_fetch_array($res_user);
			
			switch( $data['payment_status'] )
			{
				case "0":		$payment_status = "<b>ארעה תקלה</b>";																						break;
				case "1":		$payment_status = "<font style='color: red;'><b>תשלום בכרטיס אשראי נכשל</b></font>";					break;
				case "2":		$payment_status = "<font style='color: green;'><b>אישור תשלום דרך כרטיס אשראי</b></font>";			break;
				default: 		$payment_status = "לא ידוע";
			}
			
			switch( $data['purchase_status'] )
			{
				case "0":		$purchase_status = "לא נוצר קשר";						break;
				case "1":		$purchase_status = "הושארה הודעה קולית";		break;
				case "2":		$purchase_status = "הודעה נמסרה ללקוח";			break;
				case "3":		$purchase_status = "המוצר סופק ללקוח";			break;
				default: 		$purchase_status = "לא ידוע";
			}
			
			
			echo "<tr><td colspan='15'><hr size=1 color='#eeeeee' width=100%></td></tr>";
			echo "<tr>";
				echo "<td>".$data['id']."</td>";
				echo "<td width=10></td>";
				echo "<td>".GlobalFunctions::show_dateTime_field($data['purchase_date'])."</td>";
				echo "<td width=10></td>";
				
				if( $data_checkID['id'] == "793" )
				{
					echo "<td><a href='http://".$data_site['domain']."' class='maintext' target='_blank'>".stripslashes($data_site['name'])."</a></td>";
					echo "<td width=10></td>";
				}
				
				echo "<td><a href='index.php?main=net_user_details&type=net&user_id=".$data['client_id']."&unk=".UNK."&sesid=".SESID."' class='maintext' target='_blank'>".stripslashes($data_user['fname'])." ".stripslashes($data_user['lname'])."</a></td>";
				echo "<td width=10></td>";
				echo "<td>".$payment_status."</td>";
				echo "<td width=10></td>";
				echo "<td>".$purchase_status."</td>";
				echo "<td width=10></td>";
				echo "<td><a href='index.php?main=purchase_tracking_edit&type=purchase_tracking&trackId=".$data['id']."&unk=".UNK."&sesid=".SESID."' class='maintext'>צפיה</a></td>";
			echo "</tr>";
			
			
		}
		
	echo "</table>";
	echo "</form>";
}

function purchase_tracking_edit()
{
	$sql = "SELECT id FROM users WHERE unk = '".UNK."'";
	$res_checkID = mysql_db_query(DB,$sql);
	$data_checkID = mysql_fetch_array($res_checkID);
	
	$site_id_qry = ( $data_checkID['id'] != "793" ) ? "site_id = '".$data_checkID['id']."' AND payment_status=2 AND " : "";
	$sql = "SELECT * FROM purchase_tracking WHERE ".$site_id_qry." id='".$_GET['trackId']."'";
	$res = mysql_db_query(DB,$sql);
	$data = mysql_fetch_array($res);
	
	if( $data['order_cc_id'] > 0 )
	{
		$sql = "SELECT payToType FROM ilbizPayByCCLog WHERE id = '".$data['order_cc_id']."'";
		$res_ccLOG = mysql_db_query(DB,$sql);
		$data_ccLOG = mysql_fetch_array($res_ccLOG);
	}
	
	if( $data_checkID['id'] == "793" )
	{
		$sql = "SELECT name , domain FROM users WHERE id = '".$data['site_id']."'";
		$res_site = mysql_db_query(DB,$sql);
		$data_site = mysql_fetch_array($res_site);
	}
	
	if( $data_ccLOG['payToType'] == "51" )
	{
		$sql = "SELECT headline FROM 10service_deal_coupon WHERE id='".$data['product_id']."'";
		$res_product = mysql_db_query(DB,$sql);
		$data_product = mysql_fetch_array($res_product);
	}
	else
	{
		$sql = "SELECT name FROM user_products WHERE id='".$data['product_id']."'";
		$res_product = mysql_db_query(DB,$sql);
		$data_product = mysql_fetch_array($res_product);
	}
	
	$sql = "SELECT fname,lname FROM  net_users WHERE id = '".$data['client_id']."'";
	$res_user = mysql_db_query(DB,$sql);
	$data_user = mysql_fetch_array($res_user);
	
	switch( $data['payment_status'] )
	{
		case "0":		$payment_status = "<b>ארעה תקלה</b>";																						break;
		case "1":		$payment_status = "<font style='color: red;'><b>תשלום בכרטיס אשראי נכשל</b></font>";					break;
		case "2":		$payment_status = "<font style='color: green;'><b>אישור תשלום דרך כרטיס אשראי</b></font>";			break;
		default: 		$payment_status = "לא ידוע";
	}
	
	
	
	echo "<form action=\"index.php\" name=\"purchase_tracking_form\" method=\"POST\" style='margin:0; padding:0;'>";
	echo "<input type='hidden' name='main' value='purchase_tracking_edit_DB'>";
	echo "<input type='hidden' name='type' value='".$_GET['type']."'>";
	echo "<input type='hidden' name='trackId' value='".$data['id']."'>";
	echo "<input type='hidden' name='unk' value='".UNK."'>";
	echo "<input type='hidden' name='sesid' value='".SESID."'>";
	echo "<table border=\"0\" cellspacing=\"0\" cellpadding=\"0\" class=\"maintext\" width='100%'>";
		
		echo "<tr>";
			echo "<td>מספר רכישה</td>";
			echo "<td width=10></td>";
			echo "<td><b>".$data['id']."</b></td>";
		echo "</tr>";
		echo "<tr><td colspan=3 height=5></td></tr>";
		
		echo "<tr>";
			echo "<td>תאריך רכישה</td>";
			echo "<td width=10></td>";
			echo "<td>".GlobalFunctions::show_dateTime_field($data['purchase_date'])."</td>";
		echo "</tr>";
		echo "<tr><td colspan=3 height=5></td></tr>";
		
		echo "<tr>";
			echo "<td>תאריך סגירה</td>";
			echo "<td width=10></td>";
			echo "<td>";
				if( $data['close_date'] != '' )
					echo GlobalFunctions::show_dateTime_field($data['close_date']);
				else
					echo "לא קיים";
			echo "</td>";
		echo "</tr>";
		echo "<tr><td colspan=3 height=5></td></tr>";
		
		if( $data_checkID['id'] == "793" )
		{
			echo "<tr>";
				echo "<td>שם הספק</td>";
				echo "<td width=10></td>";
				echo "<td><a href='http://".$data_site['domain']."' class='maintext' target='_blank'>".stripslashes($data_site['name'])."</a></td>";
			echo "</tr>";
			echo "<tr><td colspan=3 height=5></td></tr>";
		}
		
		echo "<tr>";
			echo "<td>שם המוצר</td>";
			echo "<td width=10></td>";
			if( $data_ccLOG['payToType'] == "51" )
				echo "<td><a href='index.php?main=get_create_form&type=deal_coupon&row_id=".$data['product_id']."&unk=".UNK."&sesid=".SESID."' class='maintext' target='_blank'>".stripslashes($data_product['headline'])."</a></td>";
			else
				echo "<td><a href='index.php?main=get_create_form&type=products&row_id=".$data['product_id']."&unk=".UNK."&sesid=".SESID."' class='maintext' target='_blank'>".stripslashes($data_product['name'])."</a></td>";
		echo "</tr>";
		echo "<tr><td colspan=3 height=5></td></tr>";
		
		echo "<tr>";
			echo "<td>שם הרוכש</td>";
			echo "<td width=10></td>";
			echo "<td><a href='index.php?main=net_user_details&type=net&user_id=".$data['client_id']."&unk=".UNK."&sesid=".SESID."' class='maintext' target='_blank'>".stripslashes($data_user['fname'])." ".stripslashes($data_user['lname'])."</a></td>";
		echo "</tr>";
		echo "<tr><td colspan=3 height=5></td></tr>";
		
		echo "<tr>";
			echo "<td>סכום התשלום</td>";
			echo "<td width=10></td>";
			echo "<td>".$data['total_amount']." ש\"ח כולל מע\"מ</td>";
		echo "</tr>";
		echo "<tr><td colspan=3 height=5></td></tr>";
		
		echo "<tr>";
			echo "<td>סטטוס תשלום</td>";
			echo "<td width=10></td>";
			echo "<td>".$payment_status."</td>";
		echo "</tr>";
		echo "<tr><td colspan=3 height=5></td></tr>";
		
		
		
		$select_0 = ( $data['purchase_status'] == "0" ) ? "selected" : "";
		$select_1 = ( $data['purchase_status'] == "1" ) ? "selected" : "";
		$select_2 = ( $data['purchase_status'] == "2" ) ? "selected" : "";
		$select_3 = ( $data['purchase_status'] == "3" ) ? "selected" : "";
		
		echo "<tr>";
			echo "<td>סטטוס מעקב</td>";
			echo "<td width=10></td>";
			echo "<td>";
				echo "<select name='NEW_purchase_status' class='input_style'>";
					echo "<option value='0' ".$select_0.">לא נוצר קשר</option>";
					echo "<option value='1' ".$select_1.">הושארה הודעה קולית</option>";
					echo "<option value='2' ".$select_2.">הודעה נמסרה ללקוח</option>";
					echo "<option value='3' ".$select_3.">המוצר סופק ללקוח</option>";
				echo "</select>";
			echo "</td>";
		echo "</tr>";
		echo "<tr><td colspan=3 height=25></td></tr>";
		
		echo "<tr>";
			echo "<td colspan=3><b>לאן לשלוח את המוצר?</b></td>";
		echo "</tr>";
		echo "<tr><td colspan=3 height=10></td></tr>";
		
		echo "<tr>";
			echo "<td>עיר</td>";
			echo "<td width=10></td>";
			echo "<td>".stripslashes($data['city'])."</td>";
		echo "</tr>";
		echo "<tr><td colspan=3 height=5></td></tr>";
		
		echo "<tr>";
			echo "<td>כתובת שליחת המוצר</td>";
			echo "<td width=10></td>";
			echo "<td>".stripslashes($data['address'])."</td>";
		echo "</tr>";
		echo "<tr><td colspan=3 height=5></td></tr>";
		
		echo "<tr>";
			echo "<td>מספר דירה</td>";
			echo "<td width=10></td>";
			echo "<td>".stripslashes($data['home_num'])."</td>";
		echo "</tr>";
		echo "<tr><td colspan=3 height=5></td></tr>";
		
		echo "<tr>";
			echo "<td>מיקוד</td>";
			echo "<td width=10></td>";
			echo "<td>".stripslashes($data['mikud'])."</td>";
		echo "</tr>";
		echo "<tr><td colspan=3 height=5></td></tr>";
		
		echo "<tr>";
			echo "<td>מספר טלפון</td>";
			echo "<td width=10></td>";
			echo "<td>".stripslashes($data['phone_number'])."</td>";
		echo "</tr>";
		echo "<tr><td colspan=3 height=25></td></tr>";
		
		echo "<tr>";
			echo "<td colspan=3><b>פרטי סליקת האשראי</b></td>";
		echo "</tr>";
		echo "<tr><td colspan=3 height=10></td></tr>";
		
		echo "<tr>";
			echo "<td>שם בעל כ\"א</td>";
			echo "<td width=10></td>";
			echo "<td>".stripslashes($data['credit_name'])."</td>";
		echo "</tr>";
		echo "<tr><td colspan=3 height=5></td></tr>";
		
		/*echo "<tr>";
			echo "<td>תעודת זהות</td>";
			echo "<td width=10></td>";
			echo "<td>".stripslashes($data['credit_tz'])."</td>";
		echo "</tr>";
		echo "<tr><td colspan=3 height=5></td></tr>";
		
		echo "<tr>";
			echo "<td>4 ספרות אחרונות כ\"א</td>";
			echo "<td width=10></td>";
			echo "<td>".stripslashes($data['credit_numb4'])."</td>";
		echo "</tr>";
		echo "<tr><td colspan=3 height=5></td></tr>";
		*/
		echo "<tr>";
			echo "<td>אימייל שליחת חשבונית מס</td>";
			echo "<td width=10></td>";
			echo "<td>".stripslashes($data['email'])."</td>";
		echo "</tr>";
		echo "<tr><td colspan=3 height=30></td></tr>";
		
		echo "<tr>";
			echo "<td>הערות לקוח</td>";
			echo "<td width=10></td>";
			echo "<td><textarea name='site_comment' cols='' rows='' class='input_style' style='width: 200px; height: 100px;'>".stripslashes($data['site_comment'])."</textarea></td>";
		echo "</tr>";
		echo "<tr><td colspan=3 height=10></td></tr>";
		
		if( $data_checkID['id'] == "793" )
		{
			echo "<tr>";
				echo "<td>הערות ILBIZ</td>";
				echo "<td width=10></td>";
				echo "<td><textarea name='ilbiz_comment' cols='' rows='' class='input_style' style='width: 200px; height: 100px;'>".stripslashes($data['ilbiz_comment'])."</textarea></td>";
			echo "</tr>";
			echo "<tr><td colspan=3 height=10></td></tr>";
		}
		
		echo "<tr><td colspan=3 height=10></td></tr>";
		
		echo "<tr>";
			echo "<td></td>";
			echo "<td width=10></td>";
			echo "<td><input type='submit' value='שמירה' class='submit_style'></td>";
		echo "</tr>";
		
	echo "</table>";
	echo "</form>";
}

function purchase_tracking_edit_DB()
{
	$sql = "SELECT id FROM users WHERE unk = '".UNK."'";
	$res_checkID = mysql_db_query(DB,$sql);
	$data_checkID = mysql_fetch_array($res_checkID);
	
	$site_id_qry = ( $data_checkID['id'] != "793" ) ? "site_id = '".$data_checkID['id']."' AND payment_status=2 AND " : "";
	
	$sql = "UPDATE purchase_tracking SET site_comment = '".addslashes($_POST['site_comment'])."' 
		WHERE ".$site_id_qry ." id = '".$_POST['trackId']."'";
	$res = mysql_db_query(DB,$sql);
	
	if( $data_checkID['id'] == "793" )
	{
		$sql = "UPDATE purchase_tracking SET ilbiz_comment = '".addslashes($_POST['ilbiz_comment'])."' 
			WHERE id = '".$_POST['trackId']."'";
		$res = mysql_db_query(DB,$sql);
	}
	
	
	$sql = "SELECT close_date FROM purchase_tracking WHERE id='".$_POST['trackId']."'";
	$res = mysql_db_query(DB,$sql);
	$data2 = mysql_fetch_array($res);
	
	if( $data2['close_date'] == '' && $_POST['NEW_purchase_status'] == '2' )
	{
		$sql = "UPDATE purchase_tracking SET purchase_status = '".$_POST['NEW_purchase_status']."' , close_date = NOW()
			WHERE id = '".$_POST['trackId']."'";
		$res = mysql_db_query(DB,$sql);
	}
	else
	{
		$sql = "UPDATE purchase_tracking SET purchase_status = '".$_POST['NEW_purchase_status']."' 
			WHERE id = '".$_POST['trackId']."'";
		$res = mysql_db_query(DB,$sql);
	}
	
	echo "<script>window.location.href='index.php?main=purchase_tracking_list&type=purchase_tracking&unk=".UNK."&sesid=".SESID."';</script>";
		exit;
	
}

function suppliers_10service_list()
{
	$sql = "select u.id, u.name FROM 
					users as u,
					user_cat as uc,
					biz_categories as bc ,
					user_extra_settings as us
						WHERE 
							us.unk=u.unk AND
							u.deleted=0 AND
							u.status=0 AND
						  u.end_date > NOW() AND
							us.belongTo10service=1 AND
							u.id=uc.user_id AND
							uc.cat_id=bc.id AND
							bc.status=1
					 GROUP BY u.name";
	$res = mysql_db_query(DB, $sql);
	
	echo "<table border=\"0\" cellspacing=\"0\" cellpadding=\"0\" class=\"maintext\" width='100%'>";
		
		echo "<tr>";
			echo "<td><b>שם הלקוח</b></td>";
			echo "<td width=10></td>";
			echo "<td></td>";
			echo "<td width=10></td>";
			echo "<td><b>עדכון</b></td>";
		echo "</tr>";
		
		while( $data = mysql_fetch_array($res) )
		{
			$sql = "SELECT id FROM suppliers_10service WHERE user_id = '".$data['id']."' ";
			$resExist = mysql_db_query(DB, $sql);
			$dataExist = mysql_fetch_array($resExist);
			
			echo "<tr><td colspan=5 height=7></td></tr>";
			echo "<tr>";
				echo "<td>".stripslashes($data['name'])."</td>";
				echo "<td width=10></td>";
				echo "<td>";
					if( $dataExist == "" )
					{
						echo "<b>לקוח חדש - יש צורך לעדכנו</b>";
					}
				echo "</td>";
				echo "<td width=10></td>";
				echo "<td><a href='index.php?main=suppliers_10service_edit&type=suppliers_10service&tec=".$data['id']."&unk=".UNK."&sesid=".SESID."' class='maintext'>עדכון</a></td>";
			echo "</tr>";
			
		}
		
	echo "</table>";
}

function suppliers_10service_edit()
{

	$sql = "SELECT * FROM suppliers_10service WHERE user_id = '".$_GET['tec']."' ";
	$res = mysql_db_query(DB,$sql);
	$data = mysql_fetch_array($res);
	if(isset($_GET['del_cube_img'])){
		$image_name = $data['cube_image'];
		unlink("/home/ilan123/domains/ilbiz.co.il/public_html/ClientSite/site_banners/cubes/".$image_name);
		$sql = "UPDATE suppliers_10service SET cube_image = ''
				WHERE id = '".$data['id']."' AND user_id = '".$_POST['tec']."' ";
		$res = mysql_db_query(DB,$sql);
		echo "<script>window.location.href='https://ilbiz.co.il/ClientSite/administration/index.php?main=suppliers_10service_edit&type=suppliers_10service&tec=".$_GET['tec']."&unk=".UNK."&sesid=".SESID."';</script>";
			exit;		
	}	
	$sql = "SELECT city,address,name FROM users WHERE id = '".$_GET['tec']."' ";
	$res = mysql_db_query(DB,$sql);
	$dataUsers = mysql_fetch_array($res);
	
	$banners_arr = array();
	//$banners_arr_by_id = array();
	$banners_sql =  "SELECT id, banner_name from net_clients_banners where status = 1 order by banner_name";
	$banners_res = mysql_db_query(DB,$banners_sql);
	while($banner_data = mysql_fetch_array($banners_res)){
		$banner_data['selected'] = "";
		if($data['net_client_banner_id'] === $banner_data['id']){
			$banner_data['selected'] = "selected";
		}
		$banners_arr[] = $banner_data;
	}
	echo "<form action=\"index.php\" name=\"suppliers_10service_form\" method=\"post\" style='margin:0; padding:0;' enctype='multipart/form-data'>";
	echo "<input type='hidden' name='main' value='suppliers_10service_edit_DB'>";
	echo "<input type='hidden' name='type' value='".$_GET['type']."'>";
	echo "<input type='hidden' name='tec' value='".$_GET['tec']."'>";
	echo "<input type='hidden' name='unk' value='".UNK."'>";
	echo "<input type='hidden' name='sesid' value='".SESID."'>";
	echo "<table border=\"0\" cellspacing=\"0\" cellpadding=\"0\" class=\"maintext\" width='100%'>";
		
		echo "<tr>";
			echo "<td>שם העסק</td>";
			echo "<td width=10></td>";
			echo "<td>".stripslashes($dataUsers['name'])."</td>";
		echo "</tr>";
		echo "<tr><td colspan=3 height=10></td></tr>";
		
		
		$select_0 = ( $data['status'] == "0" ) ? "selected" : "";
		$select_1 = ( $data['status'] == "1" ) ? "selected" : "";
		$select_2 = ( $data['status'] == "2" ) ? "selected" : "";
		
		echo "<tr>";
			echo "<td>סטטוס</td>";
			echo "<td width=10></td>";
			echo "<td>";
				echo "<select name='status' class='input_style'>";
					echo "<option value='0' ".$select_0.">בבדיקה</option>";
					echo "<option value='1' ".$select_1.">יצא אמין</option>";
					echo "<option value='2' ".$select_2.">לא פעיל</option>";
				echo "</select>";
			echo "</td>";
		echo "</tr>";
		echo "<tr><td colspan=3 height=10></td></tr>";
		
		echo "<tr>";
			echo "<td>לינק - כולל HTTP</td>";
			echo "<td width=10></td>";
			echo "<td><input type='text' name='url_link' value='".stripslashes($data['url_link'])."' class='input_style'></td>";
		echo "</tr>";
		echo "<tr><td colspan=3 height=10></td></tr>";
		
		echo "<tr>";
			echo "<td>עיר</td>";
			echo "<td width=10></td>";
			echo "<td>";
				echo "<span style=\"behavior:url(options.htc); width:1px;\">";
				
					$value_city_blank = ( $data['city'] == "" || $data['city'] == "0" ) ? $dataUsers['city'] : $data['city'];
					
					echo "<select name=\"city\" class=\"input_style\">";
						echo "<option value=\"\">בחירת עיר</option>";
							
							$sql = "select id,name from cities order by name";
							$res_city = mysql_db_query(DB,$sql);
							
							while($data_city = mysql_fetch_array($res_city))	{
								$checked_city = ( $data_city['id'] == $value_city_blank )? " selected" : "";
								echo "<option value=\"".$data_city['id']."\"".$checked_city.">".stripslashes($data_city['name'])."</option>";
							}
						echo "</select>";
					echo "</span>";
			echo "</td>";
		echo "</tr>";

		echo "<tr><td colspan=3 height=10></td></tr>";
		
		echo "<tr>";
			echo "<td>שיוך באנר</td>";
			echo "<td width=10></td>";
			echo "<td>";
				
				
					
					
				echo "<select name=\"net_client_banner_id\" class=\"input_style\">";
					echo "<option value=\"\">בחירת באנר</option>";
					foreach($banners_arr as $banner_option){
						echo "<option value=\"".$banner_option['id']."\" ".$banner_option['selected'].">".stripslashes($banner_option['banner_name'])."</option>";
					}
					echo "</select>";
					
			echo "</td>";
		echo "</tr>";
		
		
		
		echo "<tr><td colspan=3 height=10></td></tr>";
		
		echo "<tr>";
			echo "<td>ערי שירות</td>";
			echo "<td width=10></td>";
			echo "<td><textarea nums='' cols='' class='input_style' style='height: 50px;' name='more_cities'>".stripslashes($data['more_cities'])."</textarea></td>";
		echo "</tr>";
		echo "<tr><td colspan=3 height=10></td></tr>";
		
		echo "<tr>";
			echo "<td>כתובת</td>";
			echo "<td width=10></td>";
			$address_value_blank = ( $data['address'] == "" ) ? $dataUsers['address'] : $data['address'];
			echo "<td><input type='text' name='address' value='".stripslashes($address_value_blank)."' class='input_style'></td>";
		echo "</tr>";
		echo "<tr><td colspan=3 height=10></td></tr>";
		
		echo "<tr>";
			echo "<td>אימייל</td>";
			echo "<td width=10></td>";
			echo "<td><input type='text' name='email' value='".stripslashes($data['email'])."' class='input_style'></td>";
		echo "</tr>";
		echo "<tr><td colspan=3 height=10></td></tr>";
		
		echo "<tr>";
			echo "<td>טלפון</td>";
			echo "<td width=10></td>";
			echo "<td><input type='text' name='phone' value='".stripslashes($data['phone'])."' class='input_style'></td>";
		echo "</tr>";
		echo "<tr><td colspan=3 height=10></td></tr>";
		
		echo "<tr>";
			echo "<td>טלפון שיופיע באתר</td>";
			echo "<td width=10></td>";
			echo "<td><input type='text' name='public_phone' value='".stripslashes($data['public_phone'])."' class='input_style'></td>";
		echo "</tr>";
		echo "<tr><td colspan=3 height=10></td></tr>";

		echo "<tr>";
			echo "<td>מספר ווטסאפ ליצירת קשר</td>";
			echo "<td width=10></td>";
			echo "<td><input type='text' name='whatsapp_number' value='".stripslashes($data['whatsapp_number'])."' class='input_style'></td>";
		echo "</tr>";
		echo "<tr><td colspan=3 height=10></td></tr>";
		
		echo "<tr>";
			echo "<td>טקסט ווטסאפ ליצירת קשר</td>";
			echo "<td width=10></td>";
			echo "<td><input type='text' name='whatsapp_text' value='".stripslashes($data['whatsapp_text'])."' class='input_style'></td>";
		echo "</tr>";
		echo "<tr><td colspan=3 height=10></td></tr>";
		
		
		echo "<tr>";
			echo "<td>שעות פעילות</td>";
			echo "<td width=10></td>";
			echo "<td><textarea nums='' cols='' class='input_style' style='height: 50px;' name='open_hours'>".stripslashes($data['open_hours'])."</textarea></td>";
		echo "</tr>";
		echo "<tr><td colspan=3 height=10></td></tr>";
		
		
		
		echo "<tr>";
			echo "<td>תמונה לתצוגה</td>";
			echo "<td width=10></td>";
			echo "<td><input type='file' name='cube_image' value='' class='input_style'></td>";
		echo "</tr>";
		
		if($data['cube_image'] != ""){
			$abpath_temp = "/home/ilan123/domains/ilbiz.co.il/public_html/ClientSite/site_banners/cubes/".$data['cube_image'];
			if( file_exists($abpath_temp) && !is_dir($abpath_temp) ){
				echo "<tr>";
					echo "<td><img style='width:150px;' src='https://ilbiz.co.il/ClientSite/site_banners/cubes/".$data['cube_image']."'/></td>";
					echo "<td width=10></td>";
					echo "<td><a href='https://ilbiz.co.il/ClientSite/administration/index.php?main=suppliers_10service_edit&type=suppliers_10service&tec=".$_GET['tec']."&del_cube_img=1&unk=".UNK."&sesid=".SESID."'>מחק</a></td>";
				echo "</tr>";				
			}
		}
		
		echo "<tr><td colspan=3 height=10></td></tr>";
		
		
		$sql = "SELECT name, id FROM content_pages WHERE unk = '".UNK."' AND lib = '1286' AND deleted=0";
		$res = mysql_db_query(DB,$sql);
		
		
		echo "<tr>";
			echo "<td>שיוך לדף טקסט<br><font style='font-size: 11px;'>ליצירת דף חדש,<br>יש להכנס לדפים חופשיים<br>וליצור דף חדש<br>על שם העסק<br>בקטגוריה לקוחות</font></td>";
			echo "<td width=10></td>";
			echo "<td valign=top>";
				echo "<select name='page_id' class='input_style'>";
					echo "<option value=''>בחר שיוך לדף</option>";
					while( $dataArticle = mysql_fetch_array($res) )
					{
						$selected = ( $dataArticle['id'] == $data['page_id'] ) ? "selected" : "";
						echo "<option value='".$dataArticle['id']."' ".$selected.">".stripslashes($dataArticle['name'])."</option>";
					}
				echo "</select>";
			echo "</td>";
		echo "</tr>";
		echo "<tr><td colspan=3 height=10></td></tr>";
		
		echo "<tr>";
			echo "<td></td>";
			echo "<td width=10></td>";
			echo "<td><input type='submit' value='שמירה' class='input_style'></td>";
		echo "</tr>";
		
	echo "</table>";
	echo "</form>";
}

function suppliers_10service_edit_DB()
{
	$sql = "SELECT id FROM suppliers_10service WHERE user_id = '".$_POST['tec']."' ";
	$res = mysql_db_query(DB,$sql);
	$data = mysql_fetch_array($res);
	
	$id_for_image = false;
	
	if( $data['id'] != "" )
	{
		$sql = "UPDATE suppliers_10service SET status = '".$_POST['status']."' , page_id = '".$_POST['page_id']."' ,
		url_link = '".addslashes($_POST['url_link'])."' , city = '".addslashes($_POST['city'])."' , address = '".addslashes($_POST['address'])."' ,
		email = '".addslashes($_POST['email'])."' , phone = '".addslashes($_POST['phone'])."', open_hours = '".addslashes($_POST['open_hours'])."' ,
		public_phone = '".addslashes($_POST['public_phone'])."', whatsapp_number = '".addslashes($_POST['whatsapp_number'])."', whatsapp_text = '".addslashes($_POST['whatsapp_text'])."' ,more_cities = '".addslashes($_POST['more_cities'])."' , net_client_banner_id = '".$_POST['net_client_banner_id']."'
		WHERE id = '".$data['id']."' AND user_id = '".$_POST['tec']."' ";
		$res = mysql_db_query(DB,$sql);
		$id_for_image = $data['id'];
	}
	else
	{
		$sql = "INSERT INTO suppliers_10service ( status , url_link , user_id , city , address, email, phone, open_hours, page_id , more_cities , public_phone , whatsapp_number , whatsapp_text, net_client_banner_id ) 
		VALUES ( '".$_POST['status']."' , '".addslashes($_POST['url_link'])."' , '".$_POST['tec']."' ,
		'".addslashes($_POST['city'])."' ,'".addslashes($_POST['address'])."' ,'".addslashes($_POST['email'])."' ,
		'".addslashes($_POST['phone'])."' ,'".addslashes($_POST['open_hours'])."','".addslashes($_POST['page_id'])."' ,
		'".addslashes($_POST['more_cities'])."','".addslashes($_POST['public_phone'])."','".addslashes($_POST['whatsapp_number'])."','".addslashes($_POST['whatsapp_text'])."', '".$_POST['net_client_banner_id']."' 
		 ) ";
		$res = mysql_db_query(DB,$sql);
		$new_id = mysql_insert_id();
		if($new_id){
			$id_for_image = $new_id;
		}
	}
	
	if ($_FILES['cube_image']['name'] != "" && $id_for_image){
		$image_name = "cube_".$data['id'].".png";
		GlobalFunctions::upload_file_to_server('cube_image' , $image_name, "/home/ilan123/domains/ilbiz.co.il/public_html/ClientSite/site_banners/cubes/");
		$sql = "UPDATE suppliers_10service SET cube_image = '".$image_name."'
				WHERE id = '".$data['id']."' AND user_id = '".$_POST['tec']."' ";
		$res = mysql_db_query(DB,$sql);		
	}
	
	echo "<script>window.location.href='index.php?main=suppliers_10service_list&type=suppliers_10service&unk=".UNK."&sesid=".SESID."';</script>";
		exit;
}


function ten_products_stock()
{
	$sql = "select up.id as pro_id , up.name, up.remain_stock , ps.stock, ps.id as ps_id from 
						user_products as up LEFT JOIN (10service_auto_products_stock as ps) ON up.id = ps.product_id
					WHERE
						up.unk = '".UNK."' AND
						up.deleted = '0'
					 order by up.id DESC";
	$res = mysql_db_query(DB, $sql);
	
	echo "<table border=\"0\" cellspacing=\"0\" cellpadding=\"0\" class=\"maintext\" width='100%'>";
		
		echo "<tr>";
			echo "<td><b>שם המוצר</b></td>";
			echo "<td width=10></td>";
			echo "<td><b>מלאי באוויר</b></td>";
			echo "<td width=10></td>";
			echo "<td><b>מלאי נותר במחסן</b></td>";
			echo "<td width=10></td>";
			echo "<td><b>עדכון</b></td>";
		echo "</tr>";
		
		while( $data = mysql_fetch_array($res) )
		{
			echo "<tr><td colspan=5 height=7></td></tr>";
			echo "<tr>";
				echo "<td>".stripslashes($data['name'])."</td>";
				echo "<td width=10></td>";
				echo "<td>".stripslashes($data['remain_stock'])."</td>";
				echo "<td width=10></td>";
				echo "<td>".stripslashes($data['stock'])."</td>";
				echo "<td width=10></td>";
				echo "<td><a href='index.php?main=ten_products_stocke_edit&type=products&id=".$data['ps_id']."&pro_id=".$data['pro_id']."&unk=".UNK."&sesid=".SESID."' class='maintext'>עדכון</a></td>";
			echo "</tr>";
			
		}
		
	echo "</table>";
	
}

function ten_products_stocke_edit()
{
	$sql = "SELECT * FROM 10service_auto_products_stock WHERE id = '".$_GET['id']."' ";
	$res = mysql_db_query(DB,$sql);
	$data = mysql_fetch_array($res);
	
	echo "<form action=\"index.php\" name=\"stock_10service_form\" method=\"post\" style='margin:0; padding:0;'>";
	echo "<input type='hidden' name='main' value='ten_products_stocke_edit_DB'>";
	echo "<input type='hidden' name='type' value='".$_GET['type']."'>";
	echo "<input type='hidden' name='id' value='".$_GET['id']."'>";
	echo "<input type='hidden' name='pro_id' value='".$_GET['pro_id']."'>";
	echo "<input type='hidden' name='unk' value='".UNK."'>";
	echo "<input type='hidden' name='sesid' value='".SESID."'>";
	echo "<table border=\"0\" cellspacing=\"0\" cellpadding=\"0\" class=\"maintext\" width='100%'>";
		
		echo "<tr>";
			echo "<td>מלאי</td>";
			echo "<td width=10></td>";
			echo "<td><input type='text' name='stock' value='".stripslashes($data['stock'])."' class='input_style'></td>";
		echo "</tr>";
		echo "<tr><td colspan=3 height=10></td></tr>";
		
		echo "<tr>";
			echo "<td>סיום מלאי עד חודש</td>";
			echo "<td width=10></td>";
			echo "<td>";
				$until_date = explode("-" , $data['renewal_until_date']);
				echo "<table border=\"0\" cellspacing=\"0\" cellpadding=\"0\" class=\"maintext\">";
					echo "<tr>";
						echo "<td>";
							echo "<select name='until_m' class='' style='width: 90px;'>";
								echo "<option value=''>חודש</option>";
								for( $m=1 ; $m<=12 ; $m++ )
								{
									$selected = ( $m == $until_date[1] ) ? "selected" : "";
									echo "<option value='".$m."' ".$selected.">".$m."</option>";
								}
							echo "</select>";
						echo "</td>";
						echo "<td width=20></td>";
						echo "<td>";
							echo "<select name='until_y' class='' style='width: 90px;'>";
							echo "<option value=''>שנה</option>";
								for( $y=date('Y') ; $y<=(date("Y")+10) ; $y++ )
								{
									$selected = ( $y == $until_date[0] ) ? "selected" : "";
									echo "<option value='".$y."' ".$selected.">".$y."</option>";
								}
							echo "</select>";
						echo "</td>";
					echo "</tr>";
				echo "</table>";
			echo "</td>";
		echo "</tr>";
		echo "<tr><td colspan=3 height=10></td></tr>";
		
		echo "<tr>";
			echo "<td>מלאי התחדשות (מינימום)</td>";
			echo "<td width=10></td>";
			echo "<td><input type='text' name='min_air_stock' value='".stripslashes($data['min_air_stock'])."' class='input_style'></td>";
		echo "</tr>";
		echo "<tr><td colspan=3 height=10></td></tr>";
		
		$select_0 = ( $data['renewal_period'] == "0" ) ? "selected" : "";
		$select_1 = ( $data['renewal_period'] == "1" ) ? "selected" : "";
		$select_2 = ( $data['renewal_period'] == "2" ) ? "selected" : "";
		
		echo "<tr>";
			echo "<td>תקופת התחדשות</td>";
			echo "<td width=10></td>";
			echo "<td>";
				echo "<select name='renewal_period' class='input_style'>";
					echo "<option value='0' ".$select_0.">אוטומטי - יומי</option>";
					echo "<option value='1' ".$select_1.">שבועי</option>";
					echo "<option value='2' ".$select_2.">חודשי</option>";
				echo "</select>";
			echo "</td>";
		echo "</tr>";
		echo "<tr><td colspan=3 height=10></td></tr>";
		
		echo "<tr>";
			echo "<td></td>";
			echo "<td width=10></td>";
			echo "<td><input type='submit' value='שמירה' class='input_style'></td>";
		echo "</tr>";
	echo "</table>";
	echo "</form>";
	
}

function ten_products_stocke_edit_DB()
{
	$renewal_until_date = $_POST['until_y']."-".$_POST['until_m']."-28";
	if( $_POST['id'] == "" )
	{
		$sql = "INSERT INTO 10service_auto_products_stock (product_id,stock,renewal_until_date,min_air_stock,renewal_period)
		 VALUES ('".$_POST['pro_id']."' , '".$_POST['stock']."' , '".$renewal_until_date."' , '".$_POST['min_air_stock']."' , '".$_POST['renewal_period']."')";
	}
	else
	{
		$sql = "UPDATE 10service_auto_products_stock SET stock = '".$_POST['stock']."' , 
		renewal_until_date = '".$renewal_until_date."' , min_air_stock = '".$_POST['min_air_stock']."' , renewal_period = '".$_POST['renewal_period']."' 
		WHERE id = '".$_POST['id']."' AND product_id = '".$_POST['pro_id']."'";
	}
	$res = mysql_db_query(DB,$sql);
	
	echo "<script>window.location.href='index.php?main=ten_products_stock&type=products&unk=".UNK."&sesid=".SESID."';</script>";
		exit;
}



function ten_products_stock_log()
{
	
	$sql = "select * , DATE_FORMAT(insert_date, '%d/%m/%Y %H:%i') as InDate from 10service_products_stock_log ORDER BY id DESC";
	$res = mysql_db_query(DB, $sql);
	
	echo "<table border=\"0\" cellspacing=\"0\" cellpadding=\"0\" class=\"maintext\" width='100%'>";
		
		echo "<tr>";
			echo "<td><b>שם המוצר</b></td>";
			echo "<td width=10></td>";
			echo "<td><b>מעקב הזמנה</b></td>";
			echo "<td width=10></td>";
			echo "<td><b>הוספה / הורדה</b></td>";
			echo "<td width=10></td>";
			echo "<td><b>תאריך שינוי</b></td>";
			echo "<td width=10></td>";
			echo "<td><b></b></td>";
		echo "</tr>";
		
		while( $data = mysql_fetch_array($res) )
		{
			$sql = "SELECT name FROM user_products WHERE id = '".$data['product_id']."' ";
			$resName = mysql_db_query(DB,$sql);
			$dataProdcut = mysql_fetch_array($resName);
			
			$sql = "SELECT payment_status FROM purchase_tracking WHERE id = '".$data['track_id']."' ";
			$resTrack = mysql_db_query(DB,$sql);
			$dataTrack = mysql_fetch_array($resTrack);
			
			switch( $dataTrack['payment_status'])
			{
				case "0":		$tr = "background-color: red; color: #ffffff;";				break;
				case "1":		$tr = "background-color: red; color: #ffffff;";				break;
				case "2":		$tr = "background-color: green; color: #ffffff;";			break;
				default: 		$tr = "background-color: #666666; color: #ffffff;";
			}
			if( $data['erased'] == "1" )
				$tr2 = "text-decoration:line-through;";
			else
				$tr2 = "";
			
			echo "<tr><td colspan=7 height=7></td></tr>";
			echo "<tr style='".$tr.$tr2."'>";
				echo "<td><a href='index.php?main=get_create_form&type=products&row_id=".$data['product_id']."&unk=".UNK."&sesid=".SESID."' class='maintext' style='color:#ffffff;' target='_blank'>".stripslashes($dataProdcut['name'])."</a></td>";
				echo "<td width=10></td>";
				echo "<td>";
					if( $data['type'] == "1" )
						echo "<a href='index.php?main=purchase_tracking_edit&type=purchase_tracking&trackId=".$data['track_id']."&unk=".UNK."&sesid=".SESID."' class='maintext' style='color:#ffffff;' target='_blank'>מעקב הזמנה</a>";
				echo "</td>";
				echo "<td width=10></td>";
				echo "<td>";
					if( $data['type'] == "0" )	echo "הוספה של : ".$data['stock_number'];	
					else		echo "הורדה של : ".$data['stock_number'];
				echo "</td>";
				echo "<td width=10></td>";
				echo "<td>".stripslashes($data['InDate'])."</td>";
				echo "<td width=10></td>";
				echo "<td>";
					if( $dataTrack['payment_status'] != "2" && $data['type'] == "1" && $data['erased'] == "0" )
						echo "<a href='index.php?main=change_product_stock_after&type=".$_GET['type']."&log_id=".$data['id']."&pro_id=".$data['product_id']."&unk=".UNK."&sesid=".SESID."' style='color:#ffffff;' class='maintext'>בטל שינוי מלאי</a>";
				echo "</td>";
			echo "</tr>";
		}
		
	echo "</table>";
	
}

function change_product_stock_after()
{
	$sql = "UPDATE 10service_products_stock_log SET erased = 1 WHERE id = '".$_GET['log_id']."' ";
	$res = mysql_db_query(DB,$sql);
	
	$sql = "UPDATE user_products SET remain_stock = remain_stock + 1 WHERE id = '".$_GET['pro_id']."' ";
	$res = mysql_db_query(DB,$sql);
	
	$sql = "INSERT INTO 10service_products_stock_log ( product_id , type, stock_number , insert_date )
	VALUES ( '".$_GET['pro_id']."' , '0' , '1' , NOW() )";
	$res = mysql_db_query(DB,$sql);
	
	echo "<script>window.location.href='index.php?main=ten_products_stock_log&type=products&unk=".UNK."&sesid=".SESID."';</script>";
		exit;
}