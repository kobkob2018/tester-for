<?


function prices_update()
{
	
	$subject_id = ( $_GET['sub'] == "" ) ? "AND subject_id = ''" : "AND subject_id = ".$_GET['sub'];
	$sql = "select * from user_products_cat where unk = '".UNK."' and deleted = '0' and status = '0' ".$subject_id."";
	$rescat = mysql_db_query(DB,$sql);
	
	$sql = "select * from user_products_subject where unk = '".UNK."' and deleted = '0' and active = '0'";
	$res_allcat = mysql_db_query(DB,$sql);
	$data_num_all = mysql_num_rows( $res_allcat );
	
	$onSubmit = ( $_GET['cat'] == "" ) ? "onsubmit='return r=confirm(\"האם אתה בטוח לשנות לכל המוצרים את המחירים?\");alert(r)'" : "";
	echo "<form action='index.php' method='post' name='form_prices_update' ".$onSubmit.">";
	echo "<input type='hidden' name='main' value='prices_update_prosses'>";
	echo "<input type='hidden' name='type' value='".$_GET['type']."'>";
	echo "<input type='hidden' name='cat' value='".$_GET['cat']."'>";
	echo "<input type='hidden' name='sub' value='".$_GET['sub']."'>";
	echo "<input type='hidden' name='unk' value='".UNK."'>";
	echo "<input type='hidden' name='sesid' value='".SESID."'>";
	echo "<table border=\"0\" cellspacing=\"0\" cellpadding=\"0\" class=\"maintext\">";
		echo "<tr>";
			echo "<td><h4>עדכון מחירים</h4></td>";
		echo "</tr>";
		
		echo "<tr>";
			echo "<td>";
				echo "<table border=\"0\" cellspacing=\"0\" cellpadding=\"0\" class=\"maintext\">";
					if( $data_num_all > 0 )
					{
						echo "<tr>";
							echo "<td align=\"right\" valign=top>";
							
								while( $data_all = mysql_fetch_array($res_allcat) )
								{
									$bold_s = ( $data_all['id'] == $_GET['sub']) ? "<b>" : "<A href='index.php?main=prices_update&type=".$_GET['type']."&cat=&sub=".$data_all['id']."&unk=".$_GET['unk']."&sesid=".$_GET['sesid']."' class='maintext'>";
									$bold_e = ( $data_all['id'] == $_GET['sub']) ? "</b>" : "</a>";
									echo $bold_s.stripslashes($data_all['name']).$bold_e;
									echo "&nbsp;&nbsp;&nbsp;";
								}
								
							echo "</td>";
						echo "</tr>";
					}
					
					echo "<tr><td height=10></td></tr>";
					echo "<tr><td>";
					
						while( $data = mysql_fetch_array($rescat) )
						{
							$bold_s = ( $data['id'] == $_GET['cat'] ) ? "<b>" : "<A href='index.php?main=prices_update&type=".$_GET['type']."&cat=".$data['id']."&sub=".$_GET['sub']."&unk=".$_GET['unk']."&sesid=".$_GET['sesid']."' class='maintext'>";
							$bold_e = ( $data['id'] == $_GET['cat'] ) ? "</b>" : "</a>";
							echo $bold_s.stripslashes($data['name']).$bold_e;
							echo "&nbsp;&nbsp;&nbsp;";
						}
						
					echo "</td></tr>";
					echo "<tr><td height=5></td></tr>";
				echo "</table>";
			echo "</td>";
		echo "</tr>";
		
		echo "<tr><td height=30></td></td>";
		
		echo "<tr>";
			echo "<td>עדכון מחירים באחוזים:</td>";
		echo "</tr>";
		
		echo "<tr>";
			echo "<td>
			<input type='radio' name='plus_minus' value='plus'>  עלה מחירים
			<input type='radio' name='plus_minus' value='minus'> הורד מחירים  
			&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
			ב...
			<input type='text' name='price_precent' value='' class='input_style' dir=ltr style='width: 50px;'> %
			</td>";
		echo "</tr>";
			echo "<tr><td height=10></td></td>";
		echo "<tr>";
			echo "<td>
			<input type='radio' name='round_nums' value='yes'>  עגל מחירים
			<input type='radio' name='round_nums' value='no'> אל תעגל מחירים
			&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
			</td>";
		echo "</tr>";
		
		echo "<tr><td height=20></td></td>";
		
		echo "<tr>";
			echo "<td>
			<h4>עדכון בקליק עבור כל המוצרים באתר, חסוך זמן ועדכן בדקה !</h4>
			העדכון הוא לפי אחוזים .<br>
			במידה ותבחרו לעגל מחירים, העיגול יתבצע כדקלמן: <Br>
			עד 0.6 עיגול מטה לא כולל<Br>
			מ 0.6 כולל עיגול כלפי מעלה<Br>
			המחירים שיעודכנו יהיו על הקטגוריה שתבחרו, במידה ולא תבחרו קטגוריה, המחירים יעודכנו לכל המוצרים . <br>
			כל תוכן שהם לא מספרים שהקלדתם בעבר במחיר המוצר, ימחק וישאר המחיר המוצר החדש בלבד .
			</td>";
		echo "</tr>";
		echo "<tr><td height=10></td></td>";
		echo "<tr>";
			echo "<td><input type='submit' value='עדכן!' class='submit_style'></td>";
		echo "</tr>";
		
		
	echo "</table>";
}


function prices_update_prosses()
{
	
	if( $_POST['plus_minus'] == "" )
	{
		echo "<script>alert('יש לבחור את סוג עדכון המחירים');</script>";
		echo "<script>window.location.href='index.php?main=prices_update&type=".$_POST['type']."&cat=".$_POST['cat']."&sub=".$_POST['sub']."&unk=".UNK."&sesid=".SESID."';</script>";
			die;
	}
	if( $_POST['price_precent'] == "" )
	{
		echo "<script>alert('יש למלאות את האחוז העדכון');</script>";
		echo "<script>window.location.href='index.php?main=prices_update&type=".$_POST['type']."&cat=".$_POST['cat']."&sub=".$_POST['sub']."&unk=".UNK."&sesid=".SESID."';</script>";
			die;
	}
	if( $_POST['round_nums'] == "" )
	{
		echo "<script>alert('יש לבחור אפשרות עיגול מחירים');</script>";
		echo "<script>window.location.href='index.php?main=prices_update&type=".$_POST['type']."&cat=".$_POST['cat']."&sub=".$_POST['sub']."&unk=".UNK."&sesid=".SESID."';</script>";
			die;
	}
	if( $_POST['cat'] == "" && $_POST['sub'] != "" )
	{
		echo "<script>alert('זהינו שבחרת נושא, יש לבחור קטגוריה להמשך הפעולה');</script>";
		echo "<script>window.location.href='index.php?main=prices_update&type=".$_POST['type']."&cat=".$_POST['cat']."&sub=".$_POST['sub']."&unk=".UNK."&sesid=".SESID."';</script>";
			die;
	}
	
	
	$cat = ( $_POST['cat'] != "" ) ? "umcb.catId='".$_POST['cat']."' AND " : "";
	$sql = "select up.id, up.price from user_products as up INNER JOIN user_model_cat_belong as umcb ON ".$cat." umcb.model='products' AND umcb.itemId=up.id WHERE up.deleted = 0 and up.unk = '".UNK."' GROUP BY up.id order by up.place";
	$res = mysql_db_query(DB,$sql);
	
	$count = 0;
	while( $data = mysql_fetch_array($res) )
	{
		$product_price = is_number_price($data['price']);
		$temp_price = ( $product_price * $_POST['price_precent'] ) / 100 ;
		
		if( $_POST['plus_minus'] == "minus" )
			$product_price = $product_price - $temp_price;
		else
			$product_price = $product_price + $temp_price;
		
		if( $_POST['round_nums'] == "no" )
			$new_product_price = round($product_price, 2);
		else
			$new_product_price = myround($product_price);
		
		$sqlU = "UPDATE user_products SET price = '".$new_product_price."' WHERE unk = '".UNK."' AND id = '".$data['id']."' LIMIT 1";
		$resU = mysql_db_query(DB,$sqlU);
		$count++;
	}
	
	echo "<script>alert('הפעולה השפיעה על ".$count." מוצרים.');</script>";
	echo "<script>window.location.href='index.php?main=prices_update&type=".$_POST['type']."&cat=".$_POST['cat']."&sub=".$_POST['sub']."&unk=".UNK."&sesid=".SESID."';</script>";
			die;
}



function is_number_price($price)
{
  $text = (string)$price;
  $textlen = strlen($text);
  $new_num = "";
  if ($textlen==0) return 0;
  for ($i=0;$i < $textlen;$i++)
	{
		$ch = ord($text{$i});
		if ( !(($ch<48) || ($ch>57)) ) 
			$new_num = $new_num . $text{$i} ;
		elseif( $ch==46 )
			$new_num = $new_num . $text{$i} ;
  }
  
  return $new_num;
}


function GuideSetCat()
{
	$sql = "delete from user_guide_choosen_biz_cat where biz_id = '".$_POST['biz_id']."'";
	$res_del = mysql_db_query(DB,$sql);
	
	foreach( $_POST['select_cat'] as $val => $key )
	{
		if( $key == "1" )
		{
			$sql = "insert into user_guide_choosen_biz_cat ( biz_id , cat_id ) values ( '".$_POST['biz_id']."' , '".$val."' )";
			$res_insert = mysql_db_query(DB,$sql);
		}
	}
	
	echo "<script>alert('הקטגוריות הוכנסו בהצלחה');</script>";
	echo "<script>window.close();</script>";
		exit;
}

function BannerSetCat()
{
	$sql = "delete from banner_choosen_biz_cat where banner_id = '".$_POST['banner_id']."'";
	$res_del = mysql_db_query(DB,$sql);
	
	foreach( $_POST['select_cat'] as $val => $key )
	{
		if( $key == "1" )
		{
			$sql = "insert into banner_choosen_biz_cat ( banner_id , cat_id ) values ( '".$_POST['banner_id']."' , '".$val."' )";
			$res_insert = mysql_db_query(DB,$sql);
		}
	}
	
	echo "<script>alert('הקטגוריות הוכנסו בהצלחה');</script>";
	echo "<script>window.close();</script>";
		exit;
}


function upload_quide_img( $tempImg , $visual_name , $server_path , $width , $height , $record_id , $pic2="0" , $banner="0" )
{
	$field_name = $_FILES[$tempImg]['name'];
	
	if($_FILES[$tempImg]['type'] == "image/jpeg" || $_FILES[$tempImg]['type'] == "image/gif" || $_FILES[$tempImg]['type'] == "image/pjpeg" || $_FILES[$tempImg]['type'] == "image/png" || $_FILES[$tempImg]['type'] == "application/x-shockwave-flash" )
	{
		$exte = substr($field_name,(strpos($field_name,".")+1));
		
		if( $banner == "0" )
			$name__img = $visual_name.".".$exte;
		else
			$name__img = $record_id."-".$visual_name.".".$exte;
		
		$abpath_name = $server_path.$name__img;
		if( file_exists($abpath_name) && !is_dir($abpath_name) )
			unlink($abpath_name);
		
		GlobalFunctions::upload_file_to_server($tempImg , $name__img , $server_path , array("image" , "shockwave-flash") , array() , "2" , "copy");
		
		if( $banner == "0" )
		resize($name__img, $server_path, $width,$height);
		
		if( $pic2 == "1" )
		{
			$name__img2 = $visual_name."-large.".$exte;
			GlobalFunctions::upload_file_to_server($tempImg , $name__img2 , $server_path , array("image") , array() , "2" , "copy");
			resize($name__img, $server_path, "450","350");
		}
		
		$table_upldate = ( $banner == "0" ) ? "user_guide_business" : "user_banners_guide";
		$sql = "UPDATE ".$table_upldate." SET ".$tempImg." = '".$name__img."' WHERE id = '". $record_id ."' ";
		$res = mysql_db_query(DB,$sql);
	}
}


function ftpAccount()
{
	$sql = "SELECT domain FROM users WHERE unk = '".UNK."' ";
	$res = mysql_db_query(DB,$sql);
	$userData = mysql_fetch_array($res);
	
	$u_path = "/home/ilan123/domains/".$userData['domain']."/public_html/uploadFiles/";
	
	echo "<table border=\"0\" cellspacing=\"0\" cellpadding=\"0\" class=\"maintext\">";
	
		echo "<tr>";
			echo "<td>";
				echo "<form action='index.php' name='uploadForm' method='post' enctype='multipart/form-data'>";
				echo "<input type='hidden' name='main' value='ftpAccount_upload'>";
				echo "<input type='hidden' name='type' value='ftpAccount'>";
				echo "<input type='hidden' name='unk' value='".UNK."'>";
				echo "<input type='hidden' name='sesid' value='".SESID."'>";
				echo "<table border=\"0\" cellspacing=\"0\" cellpadding=\"0\" class=\"maintext\">";
					
					for( $i=1 ; $i<=10 ; $i++ )
					{
						echo "<tr>";
							echo "<td>קובץ ".$i."</td>";
							echo "<td width=10></td>";
							echo "<td><input type='file' name='ufile".$i."' class='input_style'></td>";
						echo "</tr>";
						echo "<tr><td colspan=3 height=7></td></tr>";
					}
					
					echo "<tr>";
						echo "<td colspan=3 style='font-size: 11px;'>עד משקל של 40 מגה בייט להעלאה אחת<br>משך זמן העלאה תלוי במשקל הקובץ, יש להמתין בסבלנות עד לסיום התהליך</td>";
					echo "</tr>";
					echo "<tr><td colspan=3 height=7></td></tr>";
					echo "<tr>";
						echo "<td colspan=3 align=right><input type='submit' value='שלח' class='submit_style'></td>";
					echo "</tr>";
				echo "</table>";
				echo "</form>";
			echo "</td>";
		echo "</tr>";
		
		echo "<tr><td height=5></td></tr>";
		echo "<tr><td><hr color='#000000' size=1 width='100%'></td></tr>";
		echo "<tr><td height=5></td></tr>";
		
		echo "<tr>";
			echo "<td>";
				echo "<table border=\"0\" cellspacing=\"0\" cellpadding=\"0\" class=\"maintext\">";
					
					echo "<tr>";
						echo "<td>שם הקובץ</td>";
						echo "<td width=10></td>";
						echo "<td>משקל</td>";
						echo "<td width=10></td>";
						echo "<td>קישור לקובץ</td>";
						echo "<td width=10></td>";
						echo "<td>מחיקה</td>";
					echo "</tr>";
					
					if (is_dir($u_path))
					{
    				if ($dh = opendir($u_path))
    				{
       				while (($file = readdir($dh)) !== false)
       				{
       					if( is_file($u_path.$file) )
       					{
       						echo "<tr><td height=7 colspan=9></td></tr>";
	       					echo "<tr>";
										echo "<td><a href='http://".$userData['domain']."/uploadFiles/".$file."' class='maintext'>".$file."</a></td>";
										echo "<td width=10></td>";
										echo "<td>".format_bytes_ftpAccount(filesize($u_path . $file))."</td>";
										echo "<td width=10></td>";
										echo "<td>http://".$userData['domain']."/uploadFiles/".$file."</td>";
										echo "<td width=10></td>";
										echo "<td><a href='index.php?main=ftpAccountDel&type=ftpAccount&file_name=".$file."&unk=".UNK."&sesid=".SESID."' onclick='return can_i_del()' class='maintext'>מחיקה</a></td>";
									echo "</tr>";
								}
       				}
       				closedir($dh);
    				}
					}
					
					
				echo "</table>";
			echo "</td>";
		echo "</tr>";
		
	echo "</table>";
}


function ftpAccount_upload()
{
	$sql = "SELECT domain FROM users WHERE unk = '".UNK."' ";
	$res = mysql_db_query(DB,$sql);
	$userData = mysql_fetch_array($res);
	
	$server_path = "/home/ilan123/domains/".$userData['domain']."/public_html/uploadFiles";
	
	if( !is_dir($server_path) )
	{
		mkdir($server_path);
	}
	
	$allowd_type_arr = array( "image","shockwave-flash","octet-stream","opendocument","msword","compressed","ms-excel","officedocument","pdf","download" );
	
	if($_FILES)
	{
		for( $i=1 ; $i<=10 ; $i++ )
		{
			$temp_name = "ufile".$i;
			if( $_FILES[$temp_name]['tmp_name'] != "" )
			{
				$file_name = $_FILES[$temp_name]['name'];
				$exte = substr($file_name,(strpos($file_name,".")+1));
				
				
				if( !file_exists( $server_path . "/" . $file_name ) )
					GlobalFunctions::upload_file_to_server($temp_name , $file_name , $server_path , $allowd_type_arr , array() , "2" , "copy");
			}
		}
	}
	
	echo "<script>window.location.href='index.php?main=ftpAccount&type=ftpAccount&unk=".UNK."&sesid=".SESID."';</script>";
		exit;
}


function ftpAccountDel()
{
	$sql = "SELECT domain FROM users WHERE unk = '".UNK."' ";
	$res = mysql_db_query(DB,$sql);
	$userData = mysql_fetch_array($res);
	
	$u_path = "/home/ilan123/domains/".$userData['domain']."/public_html/uploadFiles/".$_GET['file_name'];
	
	if( is_file($u_path) && !is_dir($u_path) )
	{
		$del = unlink($u_path);
		echo "<script>alert('הקובץ נמחק בהצלחה')</script>";
	}
	else
		echo "<script>alert('מחיקת הקובץ נכשלה, יש לנסות שוב')</script>";
	
	echo "<script>window.location.href='index.php?main=ftpAccount&type=ftpAccount&unk=".UNK."&sesid=".SESID."';</script>";
		exit;
}


function format_bytes_ftpAccount($size) {
    $units = array(' B', ' KB', ' MB', ' GB', ' TB');
    for ($i = 0; $size >= 1024 && $i < 4; $i++) $size /= 1024;
    return round($size, 2).$units[$i];
}




function LandingPage()
{
	$sql = "SELECT landing_name, id FROM sites_landingPage_settings WHERE deleted=0 AND unk = '".UNK."' ";
	$res = mysql_db_query(DB,$sql);
	
	echo "<table border=\"0\" cellspacing=\"0\" cellpadding=\"0\" class=\"maintext\">";
		
		echo "<tr>";
			echo "<td><b>דף נחיתה</b></td>";
			echo "<td width=10></td>";
			echo "<td><b>עריכה</b></td>";
			echo "<td width=10></td>";
			echo "<td><b>קישור לדף</b></td>";
			echo "<td width=100></td>";
			echo "<td><b>מחיקה</b></td>";
			
		echo "</tr>";
		
		while( $data = mysql_fetch_array($res) )
		{
			echo "<tr><td colspan=5 height=10></td></tr>";
			echo "<tr>";
				echo "<td>".stripslashes($data['landing_name'])."</td>";
				echo "<td width=10></td>";
				echo "<td><a href='index.php?main=LandingPage_edit&type=".$_GET['type']."&landing_id=".$data['id']."&unk=".UNK."&sesid=".SESID."' class='maintext'>עריכה</a></td>";
				echo "<td width=10></td>";
				echo "<td align=center><a href='".HTTP_PATH."/landing.php?ld=".$data['id']."' class='maintext' target='_blank'><img src='images/linkS.png' alt='' border='0'></a></td>";
				echo "<td width=100></td>";
				echo "<td><a href='index.php?main=LandingPage_del&type=".$_GET['type']."&landing_id=".$data['id']."&unk=".UNK."&sesid=".SESID."' class='maintext' onclick='return can_i_del()'>מחיקה</a></td>";
			echo "</tr>";
		}
		
	echo "</table>";
}


function LandingPage_edit()
{
	$sql = "SELECT * FROM sites_landingPage_settings WHERE id='".$_GET['landing_id']."' AND unk = '".UNK."' ";
	$resSetting = mysql_db_query(DB,$sql);
	$dataSetting = mysql_fetch_array($resSetting);
	
	$sql = "SELECT * FROM sites_landingPage_links WHERE deleted=0 AND landing_id='".$_GET['landing_id']."' AND unk = '".UNK."' ORDER BY place, id";
	$resLinks = mysql_db_query(DB,$sql);
	
	$sql = "SELECT * FROM sites_landingPage_modules WHERE deleted=0 AND landing_id='".$_GET['landing_id']."' AND unk = '".UNK."' ORDER BY place, id";
	$resModules = mysql_db_query(DB,$sql);
	
	
	echo "<form action='index.php' method='post' name='landingForm' style='margin:0px; padding:0px;' enctype='multipart/form-data' >";
	echo "<input type='hidden' name='main' value='LandingPage_edit_db'>";
	echo "<input type='hidden' name='type' value='".$_GET['type']."'>";
	echo "<input type='hidden' name='unk' value='".UNK."'>";
	echo "<input type='hidden' name='sesid' value='".SESID."'>";
	echo "<input type='hidden' name='landing_id' value='".$_GET['landing_id']."'>";
	echo "<table border=\"0\" cellspacing=\"0\" cellpadding=\"0\" class=\"maintext\">";
		
		echo "<tr>";
			echo "<td><h3>הגדרות כלליות</h3></td>";
		echo "</tr>";
		
		echo "<tr>";
			echo "<td>";
				echo "<table border=\"0\" cellspacing=\"0\" cellpadding=\"0\" class=\"maintext\">";
					
					echo "<tr>";
						echo "<td>שם דף נחיתה</td>";
						echo "<td width=10></td>";
						echo "<td colspan=4><input type='text' name='genralSet[landing_name]' value='".stripslashes($dataSetting['landing_name'])."' class='input_style' style='width: 350px;'></td>";
					echo "</tr>";
					
					echo "<tr><td height=7 colspan=7></td></tr>";
					
					echo "<tr>";
						echo "<td>העברת URL ב 301</td>";
						echo "<td width=10></td>";
						echo "<td colspan=4><input type='text' name='genralSet[goto_url_301]' dir=ltr value='".stripslashes($dataSetting['goto_url_301'])."' class='input_style' style='width: 350px;'></td>";
					echo "</tr>";
					
					echo "<tr><td height=7 colspan=7></td></tr>";
					
					echo "<tr>";
						echo "<td>ID של דף טקסט מקשר לדיוור</td>";
						echo "<td width=10></td>";
						echo "<td colspan=4><input type='text' name='genralSet[mailignList_contentPageID]' value='".stripslashes($dataSetting['mailignList_contentPageID'])."' class='input_style' style='width: 350px;'></td>";
					echo "</tr>";
					
					echo "<tr><td height=7 colspan=7></td></tr>";
					
					echo "<tr>";
						echo "<td>ברירת מחדל?</td>";
						echo "<td width=10></td>";
						echo "<td colspan=4>";
							$selected0 = ( $dataSetting['landing_defualt'] == "0" ) ? "selected" : "";
							$selected1 = ( $dataSetting['landing_defualt'] == "1" ) ? "selected" : "";
							echo "<select name='genralSet[landing_defualt]' class='input_style' style='width: 350px;'>";
								echo "<option value='0' ".$selected0.">לא</option>";
								echo "<option value='1' ".$selected1.">כן - דף נחיתה זה יהיה הדף הראשי</option>";
							echo "</select>";
					echo "</tr>";
					$html_skelaton_fields_display = "display:none;";
					if($dataSetting['use_html_skaleton'] == "1"){
						$html_skelaton_fields_display = "";
					}
					echo "<tr><td height=7 colspan=7></td></tr>";
					echo "<tr>";
						echo "<td>השתמש במבנה HTML ייחודי</td>";
						echo "<td width=10></td>";
						echo "<td colspan=4>";
							$selected0 = ( $dataSetting['use_html_skaleton'] == "0" ) ? "selected" : "";
							$selected1 = ( $dataSetting['use_html_skaleton'] == "1" ) ? "selected" : "";
							echo "<select onchange='show_hide_skelaton_fields(this);' name='genralSet[use_html_skaleton]' class='input_style' style='width: 350px;'>";
								echo "<option value='0' ".$selected0.">לא</option>";
								echo "<option value='1' ".$selected1.">כן</option>";
							echo "</select>";
						echo "</td>";
					echo "</tr>";
					echo "
						<script type='text/javascript'>
							function show_hide_skelaton_fields(el_id){
								jQuery(function($){
									if($(el_id).val() == '1'){
										$('.skelaton_field_display').show();
									}
									else{
										$('.skelaton_field_display').hide();
									}
								});
							}
						</script>
					";
					echo "<tr><td height=7 colspan=7></td></tr>";	
					echo "<tr class='skelaton_field_display' style='".$html_skelaton_fields_display."'><td height=7 colspan=7><hr/>מאפייני עיצוב ייחודי:<hr/></td></tr>";
					echo "<tr class='skelaton_field_display' style='".$html_skelaton_fields_display."'>";
						echo "<td>הוסף עיצוב רספונסיבי</td>";
						echo "<td width=10></td>";
						echo "<td colspan=4>";
							$selected0 = ( $dataSetting['use_bootstrap'] == "0" ) ? "selected" : "";
							$selected1 = ( $dataSetting['use_bootstrap'] == "1" ) ? "selected" : "";
							echo "<select name='genralSet[use_bootstrap]' class='input_style' style='width: 350px;'>";
								echo "<option value='0' ".$selected0.">לא</option>";
								echo "<option value='1' ".$selected1.">כן</option>";
							echo "</select>";
						echo "</td>";
					echo "</tr>";						
					echo "<tr class='skelaton_field_display' style='".$html_skelaton_fields_display."'><td height=7 colspan=7></td></tr>";
					echo "<tr class='skelaton_field_display' style='".$html_skelaton_fields_display."'>";
						echo "<td>הוסף הסכם עבודה</td>";
						echo "<td width=10></td>";
						echo "<td colspan=4>";
							$contracts_sql = "SELECT id,title FROM contract_design WHERE unk = '".UNK."'";
							$contract_res = mysql_db_query(DB,$contracts_sql);
							$contracts = array();
							while($contract = mysql_fetch_array($contract_res)){
								$contract['selected'] = "";
								if($dataSetting['add_contract'] == $contract['id']){
									$contract['selected'] = " selected ";
								}
								$contracts[$contract['id']] = $contract;
							}
							echo "<select name='genralSet[add_contract]' class='input_style' style='width: 350px;'>";
								echo "<option value=''>ללא</option>";
								foreach($contracts as $contract){
									echo "<option value='".$contract['id']."' ".$contract['selected'].">".$contract['title']."</option>";
								}
							echo "</select>";
						echo "</td>";
					echo "</tr>";						
					echo "<tr class='skelaton_field_display' style='".$html_skelaton_fields_display."'><td height=7 colspan=7></td></tr>";						
					
					echo "<tr class='skelaton_field_display' style='".$html_skelaton_fields_display."'>";
						echo "<td>מבנה HTML ייחודי</td>";
						echo "<td width=10></td>";
						echo "<td style='text-align:left;'><textarea style='height:50px; text-align:left;'  name='genralSet[html_skaleton]' class='input_style' style='width: 350px;'>".$dataSetting['html_skaleton']."</textarea></td>";
						echo "<td width=20></td>";
						echo "<td colspan=3>";
						echo "</td>";
					echo "</tr>";					
					echo "<tr class='skelaton_field_display' style=' ".$html_skelaton_fields_display."; '><td height=7 colspan=7></td></tr>";	
					echo "<tr class='skelaton_field_display' style=' ".$html_skelaton_fields_display."; '>";
						echo "<td>עיצוב וסקריפט חופשי</td>";
						echo "<td width=10></td>";
						echo "<td style='text-align:left;'><textarea style='height:50px; text-align:left;'  name='genralSet[head_free_html]' class='input_style' style='width: 350px;'>".$dataSetting['head_free_html']."</textarea></td>";
						echo "<td width=20></td>";
						echo "<td colspan=3>";
						echo "</td>";
					echo "</tr>";					
					echo "<tr class='skelaton_field_display' style=' ".$html_skelaton_fields_display."; '><td height=7 colspan=7><hr/></td></tr>";
					
					echo "<tr>";
						echo "<td>כפתור לייק אחרי מספר בלוקים</td>";
						echo "<td width=10></td>";
						echo "<td style='text-align:left;'><input type='text' name='genralSet[fb_share_pos]' class='input_style' style='width: 350px;' value='".$dataSetting['fb_share_pos']."' /></td>";
						echo "<td width=20></td>";
						echo "<td colspan=3>";
						echo "</td>";
					echo "</tr>";					
					echo "<tr><td height=7 colspan=7></td></tr>";	


					echo "<tr>";
						echo "<td>קוד קהלים FB</td>";
						echo "<td width=10></td>";
						echo "<td style='text-align:left;'><textarea style='height:50px; text-align:left;' name='genralSet[fb_audience_code]' class='input_style' style='width: 350px;'>".$dataSetting['fb_audience_code']."</textarea></td>";
						echo "<td width=20></td>";
						echo "<td colspan=3>";
						echo "</td>";
					echo "</tr>";					
					echo "<tr><td height=7 colspan=7></td></tr>";

					
					echo "<tr>";
						echo "<td>סלייס עליון</td>";
						echo "<td width=10></td>";
						echo "<td><input type='file' name='topslice_bg' class='input_style' style='width: 350px;'></td>";
						echo "<td width=20></td>";
						echo "<td colspan=3>";
						
							$abpath_temp = SERVER_PATH."/new_images/landing/".$dataSetting['topslice_bg'];
							if( file_exists($abpath_temp) && !is_dir($abpath_temp) )
							{
								echo "&nbsp;&nbsp;<a href=\"".HTTP_PATH."/new_images/landing/".$dataSetting['topslice_bg']."\" class=\"maintext_small\" target=\"_blank\">צפיה בקובץ</a>&nbsp;&nbsp;|&nbsp;&nbsp;<a href=\"index.php?main=del_img_DB_FTP&field_name=topslice_bg&table=sites_landingPage_settings&sesid=".SESID."&unk=".UNK."&path=new_images/landing/&img=".$dataSetting['topslice_bg']."\" class=\"maintext_small\" onclick=\"return can_i_del()\">מחיקת הקובץ</a>";
							}
						echo "</td>";
					echo "</tr>";
					
					echo "<tr><td height=7 colspan=7></td></tr>";				
					echo "<tr>";
						echo "<td>לוגו</td>";
						echo "<td width=10></td>";
						echo "<td><input type='file' name='topslice_logo' class='input_style' style='width: 350px;'></td>";
						echo "<td width=20></td>";
						echo "<td colspan=3>";
						
							$abpath_temp = SERVER_PATH."/new_images/landing/".$dataSetting['topslice_logo'];
							if( file_exists($abpath_temp) && !is_dir($abpath_temp) )
							{
								echo "&nbsp;&nbsp;<a href=\"".HTTP_PATH."/new_images/landing/".$dataSetting['topslice_logo']."\" class=\"maintext_small\" target=\"_blank\">צפיה בקובץ</a>&nbsp;&nbsp;|&nbsp;&nbsp;<a href=\"index.php?main=del_img_DB_FTP&field_name=topslice_logo&table=sites_landingPage_settings&sesid=".SESID."&unk=".UNK."&path=new_images/landing/&img=".$dataSetting['topslice_logo']."\" class=\"maintext_small\" onclick=\"return can_i_del()\">מחיקת הקובץ</a>";
							}
						echo "</td>";
					echo "</tr>";					
//topslice_bg_mobile	
				
					echo "<tr><td height=7 colspan=7></td></tr>";
					
					echo "<tr>";
						echo "<td>סוג רגע משתכפל</td>";
						echo "<td width=10></td>";
						echo "<td colspan=6>";
						
							$selected0 = ( $dataSetting['img_g_site_bg_repeat'] == 0 ) ? "selected" : "";
							$selected1 = ( $dataSetting['img_g_site_bg_repeat'] == 1 ) ? "selected" : "";
							$selected2 = ( $dataSetting['img_g_site_bg_repeat'] == 2 ) ? "selected" : "";
							$selected3 = ( $dataSetting['img_g_site_bg_repeat'] == 3 ) ? "selected" : "";
							$selected4 = ( $dataSetting['img_g_site_bg_repeat'] == 4 ) ? "selected" : "";
							echo "<select name=\"genralSet[img_g_site_bg_repeat]\" class=\"input_style\">
								<option value=\"0\" ".$selected0.">כן</option>
								<option value=\"1\" ".$selected1.">לא</option>
								<option value=\"2\" ".$selected2.">משתכפל לרוחב</option>
								<option value=\"3\" ".$selected3.">משתכפל לגובה</option>
								<option value=\"4\" ".$selected4.">לא משתכפל, לא נגלל - נשאר קבוע ברקע</option>
							</select>";
						echo "</td>";
					echo "</tr>";
					
					echo "<tr><td height=7 colspan=7></td></tr>";
					
					echo "<tr>";
						echo "<td>רקע כללי לאתר</td>";
						echo "<td width=10></td>";
						echo "<td><input type='file' name='page_bg' class='input_style' style='width: 350px;'></td>";
						echo "<td width=20></td>";
						echo "<td colspan=3>";
						
							$abpath_temp = SERVER_PATH."/new_images/landing/".$dataSetting['page_bg'];
							if( file_exists($abpath_temp) && !is_dir($abpath_temp) )
							{
								echo "&nbsp;&nbsp;<a href=\"".HTTP_PATH."/new_images/landing/".$dataSetting['page_bg']."\" class=\"maintext_small\" target=\"_blank\">צפיה בקובץ</a>&nbsp;&nbsp;|&nbsp;&nbsp;<a href=\"index.php?main=del_img_DB_FTP&field_name=page_bg&table=sites_landingPage_settings&sesid=".SESID."&unk=".UNK."&path=new_images/landing/&img=".$dataSetting['page_bg']."\" class=\"maintext_small\" onclick=\"return can_i_del()\">מחיקת הקובץ</a>";
							}
						echo "</td>";
					echo "</tr>";
					
					echo "<tr><td height=7 colspan=7></td></tr>";
					
					for( $i = 1 ; $i <= 3 ; $i++ )
					{
						echo "<tr>";
							echo "<td>טקסט ".$i."</td>";
							echo "<td width=10></td>";
							echo "<td><input type='text' name='genralSet[text_".$i."]' value='".stripslashes($dataSetting['text_'.$i])."' class='input_style' style='width: 350px;'></td>";
							echo "<td width=20></td>";
							echo "<td>צבע פונט</td>";
							echo "<td width=10></td>";
							echo "<td><input type='text' name='genralSet[text_".$i."_color]' value='".stripslashes($dataSetting['text_'.$i.'_color'])."' class='input_style' style='width: 60px;'></td>";
						echo "</tr>";
						
						echo "<tr><td height=7 colspan=7></td></tr>";
						
						echo "<tr>";
							echo "<td colspan=7>";
								echo "<table border=\"0\" cellspacing=\"0\" cellpadding=\"0\" class=\"maintext\">";
									echo "<tr>";
										echo "<td>מיקום הטקסט ".$i." מלמעלה בפיקסל</td>";
										echo "<td width=10></td>";
										echo "<td><input type='text' name='genralSet[text".$i."_top]' value='".stripslashes($dataSetting['text'.$i.'_top'])."' class='input_style' style='width: 40px;'></td>";
										echo "<td width=25></td>";
										echo "<td>מיקום הטקסט ".$i." מימין בפיקסל</td>";
										echo "<td width=10></td>";
										echo "<td><input type='text' name='genralSet[text".$i."_right]' value='".stripslashes($dataSetting['text'.$i.'_right'])."' class='input_style' style='width: 40px;'></td>";
										echo "<td width=25></td>";
										echo "<td>גודל טקסט ".$i."</td>";
										echo "<td width=10></td>";
										echo "<td><input type='text' name='genralSet[text".$i."_font_size]' value='".stripslashes($dataSetting['text'.$i.'_font_size'])."' class='input_style' style='width: 40px;'></td>";
									echo "</tr>";
								echo "</table>";
							echo "</td>";
						echo "</tr>";
						
						
						echo "<tr><td height=7 colspan=7></td></tr>";
						
					}
					echo "<tr>";
						echo "<td colspan=7>";
							echo "<table border=\"0\" cellspacing=\"0\" cellpadding=\"0\" class=\"maintext\">";
								echo "<tr>";
									echo "<td>צבע טקסט ברירת מחדל לטקסטים</td>";
									echo "<td width=10></td>";
									echo "<td><input type='text' name='genralSet[defualt_p_text_color]' value='".stripslashes($dataSetting['defualt_p_text_color'])."' class='input_style' style='width: 50px;'></td>";
									echo "<td width=25></td>";
									echo "<td>צבע קישורים ברירת מחדל לטקסטים</td>";
									echo "<td width=10></td>";
									echo "<td><input type='text' name='genralSet[defualt_p_link_color]' value='".stripslashes($dataSetting['defualt_p_link_color'])."' class='input_style' style='width: 50px;'></td>";
								echo "</tr>";
							echo "</table>";
						echo "</td>";
					echo "</tr>";					
					echo "<tr><td height=7 colspan=7><hr/>הגדרות מיקום למובייל</td></tr>";
					echo "<tr><td height=7 colspan=7>(פעיל בתאום עם מנהל האתר)</td></tr>";
					echo "<tr>";
						echo "<td>סלייס עליון למסכים קטנים</td>";
						echo "<td width=10></td>";
						echo "<td><input type='file' name='topslice_bg_mobile' class='input_style' style='width: 350px;'></td>";
						echo "<td width=20></td>";
						echo "<td colspan=3>";
						
							$abpath_temp = SERVER_PATH."/new_images/landing/".$dataSetting['topslice_bg_mobile'];
							if( file_exists($abpath_temp) && !is_dir($abpath_temp) )
							{
								echo "&nbsp;&nbsp;<a href=\"".HTTP_PATH."/new_images/landing/".$dataSetting['topslice_bg_mobile']."\" class=\"maintext_small\" target=\"_blank\">צפיה בקובץ</a>&nbsp;&nbsp;|&nbsp;&nbsp;<a href=\"index.php?main=del_img_DB_FTP&field_name=topslice_bg_mobile&table=sites_landingPage_settings&sesid=".SESID."&unk=".UNK."&path=new_images/landing/&img=".$dataSetting['topslice_bg_mobile']."\" class=\"maintext_small\" onclick=\"return can_i_del()\">מחיקת הקובץ</a>";
							}
						echo "</td>";
					echo "</tr>";
					for( $i = 1 ; $i <= 3 ; $i++ )
					{
						
						
						echo "<tr><td height=7 colspan=7></td></tr>";
						
						echo "<tr>";
							echo "<td colspan=7>";
								echo "<table border=\"0\" cellspacing=\"0\" cellpadding=\"0\" class=\"maintext\">";
									echo "<tr>";
										echo "<td>צבע טקסט ".$i."</td>";
										echo "<td width=10></td>";
										echo "<td><input type='text' name='genralSet[mobile_text".$i."_color]' value='".stripslashes($dataSetting['mobile_text'.$i.'_color'])."' class='input_style' style='width: 40px;'></td>";
										echo "<td width=25></td>";
										echo "<td>מיקום הטקסט ".$i."<br/> 0-ימין<br/> 1- אמצע<br/> 2- שמאל</td>";
										echo "<td width=10></td>";
										echo "<td><input type='text' name='genralSet[mobile_text".$i."_right]' value='".stripslashes($dataSetting['mobile_text'.$i.'_right'])."' class='input_style' style='width: 40px;'></td>";
										echo "<td width=25></td>";
										echo "<td>גודל טקסט ".$i."</td>";
										echo "<td width=10></td>";
										echo "<td><input type='text' name='genralSet[mobile_text".$i."_font_size]' value='".stripslashes($dataSetting['mobile_text'.$i.'_font_size'])."' class='input_style' style='width: 40px;'></td>";
									echo "</tr>";
								echo "</table>";
							echo "</td>";
						echo "</tr>";
						
						
						echo "<tr><td height=7 colspan=7></td></tr>";
						
					}
echo "<tr><td height=7 colspan=7><hr/></td></tr>";					

					
				echo "</table>";
			echo "</td>";
		echo "</tr>";
		
		echo "<tr><td height=10></td></tr>";
		echo "<tr><td><hr size=1 color=#000000 width=100%></td></tr>";
		echo "<tr><td height=10></td></tr>";
		
		echo "<tr>";
			echo "<td><h3>תפריט קישורים</h3></td>";
		echo "</tr>";
		
		echo "<tr>";
			echo "<td>";
				echo "<table border=\"0\" cellspacing=\"0\" cellpadding=\"0\" class=\"maintext\">";
					
					echo "<tr>";
						echo "<td colspan=12>";
							echo "<table border=\"0\" cellspacing=\"0\" cellpadding=\"0\" class=\"maintext\">";
								echo "<tr>";
									echo "<td>מיקום התפריט הקישורים מלמעלה בפיקסל</td>";
									echo "<td width=7></td>";
									echo "<td><input type='text' name='genralSet[links_top]' value='".stripslashes($dataSetting['links_top'])."' class='input_style' style='width: 40px;'></td>";
									echo "<td width=15></td>";
									echo "<td>מיקום התפריט הקישורים מימין בפיקסל</td>";
									echo "<td width=7></td>";
									echo "<td><input type='text' name='genralSet[links_right]' value='".stripslashes($dataSetting['links_right'])."' class='input_style' style='width: 40px;'></td>";
								echo "</tr>";
							echo "</table>";
						echo "</td>";
					echo "</tr>";
					echo "<tr><td height=7 colspan=9></td></tr>";
					echo "<tr>";
						echo "<td colspan=9>הוסף קישור חדש:</td>";
					echo "</tr>";
					echo "<tr><td height=7 colspan=9></td></tr>";
					
					echo "<tr>";
						echo "<td>מיקום</td>";
						echo "<td width=10></td>";
						echo "<td>שם</td>";
						echo "<td width=10></td>";
						echo "<td>כתובת</td>";
						echo "<td width=10></td>";
						echo "<td>פתיחה</td>";
						echo "<td width=10></td>";
						echo "<td>צבע קישור</td>";
						echo "<td width=10></td>";
						echo "<td>גודל קישור</td>";
						echo "<td></td>";
						echo "<td width=10></td>";
						echo "<td></td>";
					echo "</tr>";
					
					echo "<tr>";
						echo "<td><input type='text' name='newLink[place]' value='' class='input_style' style='width: 30px;'></td>";
						echo "<td width=10></td>";
						echo "<td><input type='text' name='newLink[link_name]' value='' class='input_style' style='width: 150px;'></td>";
						echo "<td width=10></td>";
						echo "<td><input type='text' name='newLink[link_url]' value='' class='input_style' style='width: 100px;'></td>";
						echo "<td width=10></td>";
						echo "<td>";
							echo "<select name='newLink[link_target]' class='input_style' style='width: 67px;'>";
								echo "<option value='_self'>בדף</option>";
								echo "<option value='_blank'>בדף חדש</option>";
								echo "<option value='ajax'>לדף נחיתה מהיר</option>";
							echo "</select>";
						echo "</td>";
						echo "<td width=10></td>";
						echo "<td><input type='text' name='newLink[link_color]' value='' class='input_style' style='width: 50px;'></td>";
						echo "<td width=10></td>";
						echo "<td>";
							echo "<select name='newLink[link_size]' class='input_style' style='width: 50px;'>";
											for( $s=11 ; $s <= 30 ; $s++ )
											{
												echo "<option value='".$s."'>".$s."px</option>";
											}
							echo "</select>";
						echo "</td>";
						echo "<td width=10></td>";
						echo "<td><input type='submit' value='הוסף' class='submit_style' style='width: 35px;'></td>";
						echo "<td width=10></td>";
						echo "<td></td>";
					echo "</tr>";
					
					echo "<tr><td height=10 colspan=9></td></tr>";
					echo "<tr>";
						echo "<td colspan=9>רשימת קישורים באתר:</td>";
					echo "</tr>";
					echo "<tr><td height=7 colspan=9></td></tr>";
					
					while( $dataLinks = mysql_fetch_array($resLinks) )
					{
						echo "<tr>";
							echo "<td><input type='text' name='upLink[".$dataLinks['id']."][place]' value='".stripslashes($dataLinks['place'])."' class='input_style' style='width: 30px;'></td>";
							echo "<td width=10></td>";
							echo "<td><input type='text' name='upLink[".$dataLinks['id']."][link_name]' value='".stripslashes($dataLinks['link_name'])."' class='input_style' style='width: 150px;'></td>";
							echo "<td width=10></td>";
							echo "<td><input type='text' name='upLink[".$dataLinks['id']."][link_url]' value='".stripslashes($dataLinks['link_url'])."' class='input_style' style='width: 100px;'></td>";
							echo "<td width=10></td>";
							echo "<td>";
								$selected1 = ( $dataLinks['link_target'] == "_self" ) ? "selected" : "";
								$selected2 = ( $dataLinks['link_target'] == "_blank" ) ? "selected" : "";
								$selected3 = ( $dataLinks['link_target'] == "ajax" ) ? "selected" : "";
								echo "<select name='upLink[".$dataLinks['id']."][link_target]' class='input_style' style='width: 67px;'>";
									echo "<option value='_self' ".$selected1.">בדף</option>";
									echo "<option value='_blank' ".$selected2." >בדף חדש</option>";
									echo "<option value='ajax' ".$selected3." >לדף נחיתה מהיר</option>";
								echo "</select>";
							echo "</td>";
							echo "<td width=10></td>";
							echo "<td><input type='text' name='upLink[".$dataLinks['id']."][link_color]' value='".stripslashes($dataLinks['link_color'])."' class='input_style' style='width: 50px;'></td>";
							echo "<td width=10></td>";
							echo "<td>";
							echo "<select name='upLink[".$dataLinks['id']."][link_size]' class='input_style' style='width: 50px;'>";
											for( $s=11 ; $s <= 30 ; $s++ )
											{
												$selected = ( $s == $dataLinks['link_size'] ) ? "selected" : "";
												echo "<option value='".$s."' ".$selected.">".$s."px</option>";
											}
							echo "</select>";
							echo "</td>";
							echo "<td width=10></td>";
							echo "<td><input type='submit' value='שמור' class='submit_style' style='width: 35px;'></td>";
							echo "<td width=10></td>";
							echo "<td><a href='index.php?main=LandingPage_links_del&type=".$_GET['type']."&landing_id=".$_GET['landing_id']."&link_id=".$dataLinks['id']."&sesid=".SESID."&unk=".UNK."' class='maintext' onclick=\"return can_i_del()\">מחיקה</a></td>";
						echo "</tr>";
						echo "<tr><td height=7 colspan=9></td></tr>";
					}
					
				echo "</table>";
			echo "</td>";
		echo "</tr>";
		
		echo "<tr><td height=10></td></tr>";
		echo "<tr><td><hr size=1 color=#000000 width=100%></td></tr>";
		echo "<tr><td height=10></td></tr>";
		
		echo "<tr>";
			echo "<td><h3>שלבים</h3></td>";
		echo "</tr>";
		
		echo "<tr>";
			echo "<td>";
				echo "<table border=\"0\" cellspacing=\"0\" cellpadding=\"0\" class=\"maintext\">";
					
					echo "<tr>";
						echo "<td>הוסף שלב חדש:</td>";
					echo "</tr>";
					echo "<tr><td height=7</td></tr>";
					
					echo "<tr>";
						echo "<td>";
							echo "<table border=\"0\" cellspacing=\"0\" cellpadding=\"0\" class=\"maintext\">";
							
								echo "<tr>";
									echo "<td>כותרת השלב</td>";
									echo "<td width=10></td>";
									echo "<td><input type='text' name='newModule[module_title]' value='' class='input_style' style='width: 175px;'></td>";
									
									echo "<td width=5></td>";
									
									
									
									echo "<td>צבע הכותרת</td>";
									echo "<td width=10></td>";
									echo "<td><input type='text' name='newModule[title_color]' value='' class='input_style' style='width: 50px;'></td>";
									
									echo "<td width=5></td>";
									
									echo "<td>גודל הכותרת</td>";
									echo "<td width=10></td>";
									echo "<td>";
										echo "<select name='newModule[title_size]' class='input_style' style='width: 50px;'>";
											for( $s=11 ; $s <= 30 ; $s++ )
											{
												echo "<option value='".$s."'>".$s."px</option>";
											}
										echo "</select>";
										
										
									echo "</td>";
									
									echo "<td width=5></td>";
									
									echo "<td>מיקום</td>";
									echo "<td width=10></td>";
									echo "<td><input type='text' name='newModule[place]' value='' class='input_style' style='width: 30px;'></td>";
									
									
									
								echo "</tr>";
								
								echo "<tr><td height=5 colspan=16></td></tr>";
								
								echo "<tr>";
									echo "<td>אייקון לכותרת</td>";
									echo "<td width=10></td>";
									echo "<td><input type='file' name='new_title_icon' value='' class='input_style' style='width: 175px;'></td>";
									
									echo "<td width=5></td>";
									
									echo "<td>צבע רקע</td>";
									echo "<td width=10></td>";
									echo "<td><input type='text' name='newModule[bgColor]' value='' class='input_style' style='width: 50px;'></td>";
									
									echo "<td width=5></td>";
									
									echo "<td>צבע גבול</td>";
									echo "<td width=10></td>";
									echo "<td><input type='text' name='newModule[border_color]' value='' class='input_style' style='width: 50px;'></td>";
									
									echo "<td width=5></td>";
									
									echo "<td colspan=3 align=left>";
										echo "<select name='newModule[visibility_hidden]' class='input_style' style='width: 60px;'>";
											echo "<option value='0'>הצג</option>";
											echo "<option value='1'>הסתר</option>";
										echo "</select>";
									echo "</td>";
								echo "</tr>";
								echo "<tr><td height=5 colspan=16></td></tr>";
								echo "<tr>";
									echo "<td colspan=16 align=left><input type='submit' value='הוסף' class='submit_style' style='width: 35px;'></td>";
								echo "</tr>";
							echo "</table>";
						echo "</td>";
					echo "</tr>";
					
					echo "<tr><td height=10></td></tr>";
					echo "<tr><td><hr size=1 color=#navy width=100%></td></tr>";
					echo "<tr><td height=10></td></tr>";
					
					echo "<tr>";
						echo "<td>רשימת שלבים בדף:</td>";
					echo "</tr>";
					
					echo "<tr><td height=7></td></tr>";
					
					while( $dataModules = mysql_fetch_array($resModules) )
					{
						
						echo "<tr>";
							echo "<td>";
								echo "<table border=\"0\" cellspacing=\"0\" cellpadding=\"0\" class=\"maintext\">";
								
									echo "<tr>";
										echo "<td>כותרת השלב</td>";
										echo "<td width=10></td>";
										echo "<td><input type='text' name='upModule[".$dataModules['id']."][module_title]' value='".stripslashes($dataModules['module_title'])."' class='input_style' style='width: 175px;'></td>";
										
										echo "<td width=5></td>";
										
										
										
										echo "<td>צבע הכותרת</td>";
										echo "<td width=10></td>";
										echo "<td><input type='text' name='upModule[".$dataModules['id']."][title_color]' value='".stripslashes($dataModules['title_color'])."' class='input_style' style='width: 50px;'></td>";
										
										echo "<td width=5></td>";
										
										echo "<td>גודל הכותרת</td>";
										echo "<td width=10></td>";
										echo "<td>";
											echo "<select name='upModule[".$dataModules['id']."][title_size]' class='input_style' style='width: 50px;'>";
												for( $s=11 ; $s <= 30 ; $s++ )
												{
													$selected = ( $dataModules['title_size'] == $s ) ? "selected" : "";
													echo "<option value='".$s."' ".$selected.">".$s."px</option>";
												}
											echo "</select>";
										echo "</td>";
										
										echo "<td width=5></td>";
										
										echo "<td>מיקום</td>";
										echo "<td width=10></td>";
										echo "<td><input type='text' name='upModule[".$dataModules['id']."][place]' value='".stripslashes($dataModules['place'])."' class='input_style' style='width: 30px;'></td>";
										
										
										
									echo "</tr>";
									
									echo "<tr><td height=5 colspan=16></td></tr>";
									
									echo "<tr>";
										echo "<td>אייקון לכותרת</td>";
										echo "<td width=10></td>";
										echo "<td><input type='file' name='new_title_icon_".$dataModules['id']."' value='' class='input_style' style='width: 175px;'></td>";
										
										echo "<td width=5></td>";
										
										echo "<td>צבע רקע</td>";
										echo "<td width=10></td>";
										echo "<td><input type='text' name='upModule[".$dataModules['id']."][bgColor]' value='".stripslashes($dataModules['bgColor'])."' class='input_style' style='width: 50px;'></td>";
										
										echo "<td width=5></td>";
										
										echo "<td>צבע גבול</td>";
										echo "<td width=10></td>";
										echo "<td><input type='text' name='upModule[".$dataModules['id']."][border_color]' value='".stripslashes($dataModules['border_color'])."' class='input_style' style='width: 50px;'></td>";
										
										echo "<td width=5></td>";
										
										$selct1 = ( $dataModules['visibility_hidden'] == "0" ) ? "selected" : "";
										$selct2 = ( $dataModules['visibility_hidden'] == "1" ) ? "selected" : "";
										echo "<td colspan=3 align=left>";
											echo "<select name='upModule[".$dataModules['id']."][visibility_hidden]' class='input_style' style='width: 60px;'>";
												echo "<option value='0' ".$selct1.">הצג</option>";
												echo "<option value='1' ".$selct2.">הסתר</option>";
											echo "</select>";
										echo "</td>";
										
									echo "</tr>";
									echo "<tr><td height=5 colspan=16></td></tr>";
									echo "<tr>";
										echo "<td colspan=16 align=left>";
											echo "<table border=\"0\" cellspacing=\"0\" cellpadding=\"0\" class=\"maintext\">";
												echo "<tr>";
													echo "<td>";
														$abpath_temp2 = SERVER_PATH."/new_images/landing/".$dataModules['title_icon'];
														if( file_exists($abpath_temp2) && !is_dir($abpath_temp2) )
														{
															echo "<a href=\"".HTTP_PATH."/new_images/landing/".$dataModules['title_icon']."\" class=\"maintext_small\" target=\"_blank\">צפיה בקובץ</a>&nbsp;&nbsp;|&nbsp;&nbsp;<a href=\"index.php?main=del_img_DB_FTP&field_name=title_icon&table=sites_landingPage_modules&sesid=".SESID."&unk=".UNK."&path=new_images/landing/&img=".$dataModules['title_icon']."\" class=\"maintext_small\" onclick=\"return can_i_del()\">מחיקת הקובץ</a>";
														}
													echo "</td>";
													echo "<td width=40></td>";
													echo "<td><a href='index.php?main=LandingPage_module_pList&type=".$_GET['type']."&landing_id=".$_GET['landing_id']."&module_id=".$dataModules['id']."&sesid=".SESID."&unk=".UNK."' class='maintext'>עדכון פסקאות</a></td>";
													echo "<td width=40></td>";
													echo "<td><a href='index.php?main=LandingPage_module_del&type=".$_GET['type']."&landing_id=".$_GET['landing_id']."&module_id=".$dataModules['id']."&sesid=".SESID."&unk=".UNK."' class='maintext' onclick=\"return can_i_del()\">מחיקה</a></td>";
													echo "<td width=30></td>";
													echo "<td align=left><input type='submit' value='שמור' class='submit_style' style='width: 60px;'></td>";
												echo "</tr>";
											echo "</table>";
										echo "</td>";
									echo "</tr>";
						
								echo "</table>";
							echo "</td>";
						echo "</tr>";
						
						echo "<tr><td height=15 colspan=16></td></tr>";
						echo "<tr><td><hr size=1 color=navy width=100%></td></tr>";
					}
					
				echo "</table>";
			echo "</td>";
		echo "</tr>";
		
		echo "<tr>";
			echo "<td align=left><input type='submit' value='שמור שינויים' class='submit_style'></td>";
		echo "</tr>";
		
	echo "</table>";
	echo "</form>";
}

function LandingPage_edit_db()
{
	
	if( $_POST['landing_id'] == "" )
	{
		$sql = "insert into sites_landingPage_settings ( 
		unk , 
		landing_name , 
		img_g_site_bg_repeat , 
		text_1 , 
		text_1_color , 
		text_2 , 
		text_2_color , 
		text_3 , 
		text_3_color , 
		text1_top, 
		text1_right, 
		text2_top, 
		text2_right , 
		text3_top , 
		text3_right, 
		links_top, 
		links_right , 
		fb_share_pos ,
		defualt_p_text_color, 
		defualt_p_link_color, 
		landing_defualt ,
		use_html_skaleton,
		mailignList_contentPageID ,
		text1_font_size , 
		text2_font_size , 
		text3_font_size , 
		goto_url_301,
		mobile_text1_color, 
		mobile_text1_right , 
		mobile_text2_color, 
		mobile_text2_right,
		mobile_text3_color,
		mobile_text3_right,
		mobile_text1_font_size,
		mobile_text2_font_size,
		mobile_text3_font_size,
		use_bootstrap,
		add_contract,
		head_free_html,
		html_skaleton,
		fb_audience_code
		 ) VALUES (
		 '".UNK."' ,
		 '".addslashes($_POST['genralSet']['landing_name'])."' ,
		 '".addslashes($_POST['genralSet']['img_g_site_bg_repeat'])."',
		 '".addslashes($_POST['genralSet']['text_1'])."' , 
		 '".addslashes($_POST['genralSet']['text_1_color'])."' , 
		 '".addslashes($_POST['genralSet']['text_2'])."' , 
		 '".addslashes($_POST['genralSet']['text_2_color'])."' , 
		'".addslashes($_POST['genralSet']['text_3'])."' , 
		'".addslashes($_POST['genralSet']['text_3_color'])."' ,
		
		'".addslashes($_POST['genralSet']['text1_top'])."' , 
		'".addslashes($_POST['genralSet']['text1_right'])."' ,
		'".addslashes($_POST['genralSet']['text2_top'])."' , 
		'".addslashes($_POST['genralSet']['text2_right'])."' ,
		'".addslashes($_POST['genralSet']['text3_top'])."' , 
		'".addslashes($_POST['genralSet']['text3_right'])."' ,
		'".addslashes($_POST['genralSet']['links_top'])."' , 
		'".addslashes($_POST['genralSet']['links_right'])."' ,
		'".addslashes($_POST['genralSet']['fb_share_pos'])."' ,
		'".addslashes($_POST['genralSet']['defualt_p_text_color'])."' , 
		'".addslashes($_POST['genralSet']['defualt_p_link_color'])."' ,
		'".addslashes($_POST['genralSet']['landing_defualt'])."' ,
		'".addslashes($_POST['genralSet']['use_html_skaleton'])."' ,
		'".addslashes($_POST['genralSet']['mailignList_contentPageID'])."' ,
		'".addslashes($_POST['genralSet']['text1_font_size'])."' , 
		'".addslashes($_POST['genralSet']['text2_font_size'])."' ,
		'".addslashes($_POST['genralSet']['text3_font_size'])."' , 
		'".addslashes($_POST['genralSet']['goto_url_301'])."' ,
		'".addslashes($_POST['genralSet']['mobile_text1_color'])."' , 
		'".addslashes($_POST['genralSet']['mobile_text1_right'])."' ,
		'".addslashes($_POST['genralSet']['mobile_text2_color'])."' , 
		'".addslashes($_POST['genralSet']['mobile_text2_right'])."' ,
		'".addslashes($_POST['genralSet']['mobile_text3_color'])."' , 
		'".addslashes($_POST['genralSet']['mobile_text3_right'])."' ,
		'".addslashes($_POST['genralSet']['mobile_text1_font_size'])."' , 
		'".addslashes($_POST['genralSet']['mobile_text2_font_size'])."' ,
		'".addslashes($_POST['genralSet']['mobile_text3_font_size'])."' ,
		'".addslashes($_POST['genralSet']['use_bootstrap'])."' ,
		'".addslashes($_POST['genralSet']['add_contract'])."' ,
		'".$_POST['genralSet']['head_free_html']."'	 ,
		'".$_POST['genralSet']['html_skaleton']."'	,
		'".$_POST['genralSet']['fb_audience_code']."'	 		
		)";
		
		$res = mysql_db_query(DB,$sql);
		$landing_id = mysql_insert_id();
	}
	else
	{
		$sql = "UPDATE sites_landingPage_settings SET 
		landing_name = '".addslashes($_POST['genralSet']['landing_name'])."' , img_g_site_bg_repeat = '".addslashes($_POST['genralSet']['img_g_site_bg_repeat'])."' ,
		text_1 = '".addslashes($_POST['genralSet']['text_1'])."' , text_1_color = '".addslashes($_POST['genralSet']['text_1_color'])."' , 
		text_2 = '".addslashes($_POST['genralSet']['text_2'])."' , text_2_color = '".addslashes($_POST['genralSet']['text_2_color'])."' , 
		text_3 = '".addslashes($_POST['genralSet']['text_3'])."' , text_3_color = '".addslashes($_POST['genralSet']['text_3_color'])."' ,
		text1_top = '".addslashes($_POST['genralSet']['text1_top'])."' , 
		text1_right = '".addslashes($_POST['genralSet']['text1_right'])."' , 
		text2_top = '".addslashes($_POST['genralSet']['text2_top'])."' , 
		text2_right = '".addslashes($_POST['genralSet']['text2_right'])."' , 
		text3_top = '".addslashes($_POST['genralSet']['text3_top'])."' , 
		text3_right = '".addslashes($_POST['genralSet']['text3_right'])."' ,
		links_top = '".addslashes($_POST['genralSet']['links_top'])."' , 
		links_right = '".addslashes($_POST['genralSet']['links_right'])."' ,
		fb_share_pos = '".addslashes($_POST['genralSet']['fb_share_pos'])."' ,		
		text1_font_size = '".addslashes($_POST['genralSet']['text1_font_size'])."' , 
		text2_font_size = '".addslashes($_POST['genralSet']['text2_font_size'])."' ,
		text3_font_size = '".addslashes($_POST['genralSet']['text3_font_size'])."' ,
		defualt_p_text_color = '".addslashes($_POST['genralSet']['defualt_p_text_color'])."' , defualt_p_link_color = '".addslashes($_POST['genralSet']['defualt_p_link_color'])."' ,
		landing_defualt = '".addslashes($_POST['genralSet']['landing_defualt'])."' ,
		use_html_skaleton = '".addslashes($_POST['genralSet']['use_html_skaleton'])."' ,
		mobile_text1_color = '".addslashes($_POST['genralSet']['mobile_text1_color'])."' , 
		mobile_text1_right = '".addslashes($_POST['genralSet']['mobile_text1_right'])."' , 
		mobile_text2_color = '".addslashes($_POST['genralSet']['mobile_text2_color'])."' , 
		mobile_text2_right = '".addslashes($_POST['genralSet']['mobile_text2_right'])."' , 
		mobile_text3_color = '".addslashes($_POST['genralSet']['mobile_text3_color'])."' , 
		mobile_text3_right = '".addslashes($_POST['genralSet']['mobile_text3_right'])."' ,
		mobile_text1_font_size = '".addslashes($_POST['genralSet']['mobile_text1_font_size'])."' , 
		mobile_text2_font_size = '".addslashes($_POST['genralSet']['mobile_text2_font_size'])."' ,
		mobile_text3_font_size = '".addslashes($_POST['genralSet']['mobile_text3_font_size'])."' ,

		
		mailignList_contentPageID = '".addslashes($_POST['genralSet']['mailignList_contentPageID'])."', 
		goto_url_301 = '".addslashes($_POST['genralSet']['goto_url_301'])."',
		head_free_html =  '".$_POST['genralSet']['head_free_html']."',
		html_skaleton =  '".$_POST['genralSet']['html_skaleton']."' ,
		use_bootstrap = '".addslashes($_POST['genralSet']['use_bootstrap'])."' ,
		add_contract = '".addslashes($_POST['genralSet']['add_contract'])."' ,
		fb_audience_code =  '".$_POST['genralSet']['fb_audience_code']."' 
		WHERE id = '".$_POST['landing_id']."' ";
		$res = mysql_db_query(DB,$sql);
		$landing_id = $_POST['landing_id'];
	}
	
	
	if( $_FILES['topslice_bg']['tmp_name'] != "" )
	{
		$abpath_temp = SERVER_PATH."/new_images/landing";
		$file_name = $_FILES['topslice_bg']['name'];
		$exte = substr($file_name,(strpos($file_name,".")+1));
		$visual_file_name = UNK."-".$landing_id."-topSlice.".$exte;
		
		GlobalFunctions::upload_file_to_server('topslice_bg' , $visual_file_name , $abpath_temp , array( "image","shockwave-flash") , array() , "2" , "copy");
		
		$sql = "UPDATE sites_landingPage_settings SET topslice_bg = '".$visual_file_name."' where id = '".$landing_id."' ";
		$res = mysql_db_query(DB,$sql);
	}

	if( $_FILES['topslice_logo']['tmp_name'] != "" )
	{
		$abpath_temp = SERVER_PATH."/new_images/landing";
		$file_name = $_FILES['topslice_logo']['name'];
		$exte = substr($file_name,(strpos($file_name,".")+1));
		$visual_file_name = UNK."-".$landing_id."-topSlice.".$exte;
		
		GlobalFunctions::upload_file_to_server('topslice_logo' , $visual_file_name , $abpath_temp , array( "image","shockwave-flash") , array() , "2" , "copy");
		
		$sql = "UPDATE sites_landingPage_settings SET topslice_logo = '".$visual_file_name."' where id = '".$landing_id."' ";
		$res = mysql_db_query(DB,$sql);
	}
	
	if( $_FILES['topslice_bg_mobile']['tmp_name'] != "" )
	{
		$abpath_temp = SERVER_PATH."/new_images/landing";
		$file_name = $_FILES['topslice_bg_mobile']['name'];
		$exte = substr($file_name,(strpos($file_name,".")+1));
		$visual_file_name = UNK."-".$landing_id."-topSlice-m.".$exte;
		
		GlobalFunctions::upload_file_to_server('topslice_bg_mobile' , $visual_file_name , $abpath_temp , array( "image","shockwave-flash") , array() , "2" , "copy");
		
		$sql = "UPDATE sites_landingPage_settings SET topslice_bg_mobile = '".$visual_file_name."' where id = '".$landing_id."' ";
		$res = mysql_db_query(DB,$sql);
	}	
	
	
	if( $_FILES['page_bg']['tmp_name'] != "" )
	{
		$abpath_temp = SERVER_PATH."/new_images/landing";
		$file_name = $_FILES['page_bg']['name'];
		$exte = substr($file_name,(strpos($file_name,".")+1));
		$visual_file_name = UNK."-".$landing_id."-page_bg.".$exte;
		
		GlobalFunctions::upload_file_to_server('page_bg' , $visual_file_name , $abpath_temp , array( "image") , array() , "2" , "copy");
		
		$sql = "UPDATE sites_landingPage_settings SET page_bg = '".$visual_file_name."' where id = '".$landing_id."' ";
		$res = mysql_db_query(DB,$sql);
	}
	
	
	if( is_array($_POST['newLink']) )
	{
		if( $_POST['newLink']['link_name'] != "" )
		{
			$sql = "INSERT INTO sites_landingPage_links ( unk , landing_id , link_name , link_url , link_target , link_color, link_size , place ) VALUES (
				'".UNK."' , '".$landing_id."' , 
			'".addslashes($_POST['newLink']['link_name'])."' , '".addslashes($_POST['newLink']['link_url'])."' , 
			'".addslashes($_POST['newLink']['link_target'])."' , '".addslashes($_POST['newLink']['link_color'])."' , '".addslashes($_POST['newLink']['link_size'])."' , 
			'".addslashes($_POST['newLink']['place'])."' )";
			$res = mysql_db_query(DB,$sql);
		}
	}
	
	
	if( is_array($_POST['upLink']) )
	{
		foreach( $_POST['upLink'] as $link_id => $links_value )
		{
			foreach( $links_value as $linkName => $linkValue )
			{
				$sql = "UPDATE sites_landingPage_links SET ".$linkName." = '".addslashes($linkValue)."' WHERE id = '".$link_id."' ";
				$res = mysql_db_query(DB,$sql);
			}
		}
	}
	
	
	if( is_array($_POST['newModule']) )
	{
		if( $_POST['newModule']['module_title'] != "" )
		{
			$sql = "INSERT INTO sites_landingPage_modules ( unk , landing_id , module_title , title_color , title_size , bgColor , border_color , place, visibility_hidden ) VALUES (
				'".UNK."' , '".$landing_id."' , 
			'".addslashes($_POST['newModule']['module_title'])."' , '".addslashes($_POST['newModule']['title_color'])."' , 
			'".addslashes($_POST['newModule']['title_size'])."' , '".addslashes($_POST['newModule']['bgColor'])."' , 
			'".addslashes($_POST['newModule']['border_color'])."',	'".addslashes($_POST['newModule']['place'])."' , 
			'".addslashes($_POST['newModule']['visibility_hidden'])."' )";
			$res = mysql_db_query(DB,$sql);
			$module_id = mysql_insert_id();
			
			if( $_FILES['new_title_icon']['tmp_name'] != "" )
			{
				$abpath_temp = SERVER_PATH."/new_images/landing";
				$file_name = $_FILES['new_title_icon']['name'];
				$exte = substr($file_name,(strpos($file_name,".")+1));
				$visual_file_name = UNK."-".$landing_id."-titleIcon-".$module_id.".".$exte;
				
				GlobalFunctions::upload_file_to_server('new_title_icon' , $visual_file_name , $abpath_temp , array( "image","shockwave-flash") , array() , "2" , "copy");
				
				$sql = "UPDATE sites_landingPage_modules SET title_icon = '".$visual_file_name."' where id = '".$module_id."' ";
				$res = mysql_db_query(DB,$sql);
			}
		}
	}
	
	
	
	if( is_array($_POST['upModule']) )
	{
		foreach( $_POST['upModule'] as $module_id => $module_value )
		{
			foreach( $module_value as $moduleName => $moduleValue )
			{
				$sql = "UPDATE sites_landingPage_modules SET ".$moduleName." = '".addslashes($moduleValue)."' WHERE id = '".$module_id."' ";
				$res = mysql_db_query(DB,$sql);
			}
			
			$fileFielsName = "new_title_icon_". $module_id ;
			if( $_FILES[$fileFielsName]['tmp_name'] != "" )
			{
				$abpath_temp = SERVER_PATH."/new_images/landing";
				$file_name = $_FILES[$fileFielsName]['name'];
				$exte = substr($file_name,(strpos($file_name,".")+1));
				$visual_file_name = UNK."-".$landing_id."-titleIcon-".$module_id.".".$exte;
				
				GlobalFunctions::upload_file_to_server($fileFielsName , $visual_file_name , $abpath_temp , array( "image","shockwave-flash") , array() , "2" , "copy");
				
				$sql = "UPDATE sites_landingPage_modules SET title_icon = '".$visual_file_name."' where id = '".$module_id."' ";
				$res = mysql_db_query(DB,$sql);
			}
			
		}
		
		
	}
	
	
	echo "<script>window.location.href='index.php?main=LandingPage_edit&landing_id=".$landing_id."&type=LandingPage&unk=".UNK."&sesid=".SESID."';</script>";
		exit;
}

function LandingPage_module_pList()
{
	$sql = "SELECT landing_name FROM sites_landingPage_settings WHERE id='".$_GET['landing_id']."' AND unk = '".UNK."' ";
	$resSetting = mysql_db_query(DB,$sql);
	$dataSetting = mysql_fetch_array($resSetting);
	
	$sql = "SELECT module_title  FROM sites_landingPage_modules WHERE deleted=0 AND id='".$_GET['module_id']."' AND unk = '".UNK."' ";
	$resModules = mysql_db_query(DB,$sql);
	$dataModules = mysql_fetch_array($resModules);
	
	$sql = "SELECT * FROM sites_landingPage_paragraph WHERE deleted=0 AND landing_id='".$_GET['landing_id']."' AND module_id='".$_GET['module_id']."' AND unk = '".UNK."' ORDER BY place, id";
	$res = mysql_db_query(DB,$sql);
	
	$module_typeArr[0] = "טקסט";
	$module_typeArr[1] = "וידיאו";
	$module_typeArr[2] = "וידיאו מוגדל";
	$module_typeArr[3] = "תמונות";
	$module_typeArr[4] = "טופס התקשרות";
	$module_typeArr[5] = "טופס הצעת מחיר";
	$module_typeArr[6] = "טקסט משולב מקוצר";
	
	echo "<table border=\"0\" cellspacing=\"0\" cellpadding=\"0\" class=\"maintext\">";
	
		echo "<tr>";
			echo "<td colspan=11>דף נחיתה: <b>".stripslashes($dataSetting['landing_name'])."</b> שלב: <b>".stripslashes($dataModules['module_title'])."</b></td>";
		echo "</tr>";
		
		echo "<tr><td colspan=11 height=15></td></tr>";
		echo "<tr>";
			echo "<td><b>מיקום</b></td>";
			echo "<td width=10></td>";
			echo "<td><b>טקסט</b></td>";
			echo "<td width=10></td>";
			echo "<td><b>סוג</b></td>";
			echo "<td width=10></td>";
			echo "<td><b></b></td>";
			echo "<td width=10></td>";
			echo "<td><b>עריכה</b></td>";
			echo "<td width=10></td>";
			echo "<td><b>מחיקה</b></td>";
		echo "</tr>";
		
		echo "<tr><td colspan=11 height=7></td></tr>";
		
		echo "<form action='index.php' method='post' name='formAddP'>";
		echo "<input type='hidden' name='main' value='LandingPage_module_pList_DB'>";
		echo "<input type='hidden' name='type' value='".$_GET['type']."'>";
		echo "<input type='hidden' name='unk' value='".UNK."'>";
		echo "<input type='hidden' name='sesid' value='".SESID."'>";
		echo "<input type='hidden' name='landing_id' value='".$_GET['landing_id']."'>";
		echo "<input type='hidden' name='module_id' value='".$_GET['module_id']."'>";
		
		echo "<tr>";
			echo "<td><input type='text' name='place' class='input_style' style='width: 30px;'></td>";
			echo "<td width=10></td>";
			echo "<td></td>";
			echo "<td width=10></td>";
			echo "<td>";
				echo "<select name='module_type' class='input_style' style='width: 100px;'>";
					foreach( $module_typeArr as $key => $val )
					{
						echo "<option value='".$key."' >".$val."</option>";
					}
				echo "</select>";
			echo "</td>";
			echo "<td width=10></td>";
			echo "<td><input type='submit' value='הוסף' class='submit_style' style='width: 40px;'></td>";
			echo "<td width=10></td>";
			echo "<td></td>";
			echo "<td width=10></td>";
			echo "<td></td>";
		echo "</tr>";
		echo "</form>";
		
		echo "<tr><td colspan=11><hr color=#000000 size=1 width=100%></td></tr>";
		echo "<tr><td colspan=11 height=7></td></tr>";
		
		while( $data = mysql_fetch_array($res) )
		{
			echo "<form action='index.php' method='post' name='formAddP_".$data['id']."'>";
			echo "<input type='hidden' name='main' value='LandingPage_module_pList_DB'>";
			echo "<input type='hidden' name='type' value='".$_GET['type']."'>";
			echo "<input type='hidden' name='unk' value='".UNK."'>";
			echo "<input type='hidden' name='sesid' value='".SESID."'>";
			echo "<input type='hidden' name='landing_id' value='".$_GET['landing_id']."'>";
			echo "<input type='hidden' name='module_id' value='".$_GET['module_id']."'>";
			echo "<input type='hidden' name='p_id' value='".$data['id']."'>";
			
			echo "<tr>";
				echo "<td><input type='text' name='place' value='".stripslashes($data['place'])."' class='input_style' style='width: 30px;'></td>";
				echo "<td width=10></td>";
				echo "<td>";
					if( $data['module_type'] == "0" )
						echo global_strrrchr(strip_tags(stripslashes($data['p_text'])) , "150");
				echo "</td>";
				echo "<td width=10></td>";
				echo "<td>";
					echo "<select name='module_type' class='input_style' style='width: 100px;'>";
						foreach( $module_typeArr as $key => $val )
						{
							$selected = ( $key == $data['module_type'] ) ? "selected" : "";
							echo "<option value='".$key."' ".$selected.">".$val."</option>";
						}
					echo "</select>";
				echo "</td>";
				echo "<td width=10></td>";
				echo "<td><input type='submit' value='שמור' class='submit_style' style='width: 40px;'></td>";
				echo "<td width=10></td>";
				echo "<td><a href='index.php?main=LandingPage_module_p&type=".$_GET['type']."&landing_id=".$data['landing_id']."&module_id=".$data['module_id']."&p_id=".$data['id']."&unk=".UNK."&sesid=".SESID."' class='maintext'>עריכה</a></td>";
				echo "<td width=10></td>";
				echo "<td><a href='index.php?main=LandingPage_module_p_del&type=".$_GET['type']."&landing_id=".$data['landing_id']."&module_id=".$data['module_id']."&p_id=".$data['id']."&unk=".UNK."&sesid=".SESID."' class='maintext' onclick=\"return can_i_del()\">מחיקה</a></td>";
			echo "</tr>";
			echo "<tr><td colspan=11 height=7></td></tr>";
			
			echo "</form>";
		}
		
	echo "</table>";
	
}

function LandingPage_module_p()
{
	
	$sql = "SELECT landing_name FROM sites_landingPage_settings WHERE id='".$_GET['landing_id']."' AND unk = '".UNK."' ";
	$resSetting = mysql_db_query(DB,$sql);
	$dataSetting = mysql_fetch_array($resSetting);
	
	$sql = "SELECT module_title  FROM sites_landingPage_modules WHERE deleted=0 AND id='".$_GET['module_id']."' AND unk = '".UNK."' ";
	$resModules = mysql_db_query(DB,$sql);
	$dataModules = mysql_fetch_array($resModules);
	
	$sql = "SELECT * FROM sites_landingPage_paragraph WHERE deleted=0 AND landing_id='".$_GET['landing_id']."' AND module_id='".$_GET['module_id']."' AND id = '".$_GET['p_id']."' AND unk = '".UNK."' ";
	$res = mysql_db_query(DB,$sql);
	$data = mysql_fetch_array($res);
	
	$module_typeArr[0] = "טקסט";
	$module_typeArr[1] = "וידיאו";
	$module_typeArr[2] = "וידיאו מוגדל";
	$module_typeArr[3] = "תמונות";
	$module_typeArr[4] = "טופס התקשרות";
	$module_typeArr[5] = "טופס הצעת מחיר";
	$module_typeArr[6] = "טקסט משולב מקוצר";
	
	echo "<form action='index.php' method='post' name='formAddP' enctype='multipart/form-data'>";
	echo "<input type='hidden' name='main' value='LandingPage_module_p_DB'>";
	echo "<input type='hidden' name='type' value='".$_GET['type']."'>";
	echo "<input type='hidden' name='unk' value='".UNK."'>";
	echo "<input type='hidden' name='sesid' value='".SESID."'>";
	echo "<input type='hidden' name='landing_id' value='".$_GET['landing_id']."'>";
	echo "<input type='hidden' name='module_id' value='".$_GET['module_id']."'>";
	echo "<input type='hidden' name='p_id' value='".$_GET['p_id']."'>";
	
	echo "<table border=\"0\" cellspacing=\"0\" cellpadding=\"0\" class=\"maintext\">";
	
		echo "<tr>";
			echo "<td>דף נחיתה: <b>".stripslashes($dataSetting['landing_name'])."</b> שלב: <b>".stripslashes($dataModules['module_title'])."</b></td>";
		echo "</tr>";
		
		echo "<tr><td height=15></td></tr>";
		
		switch( $data['module_type'] )
		{
			case "0" :
			
				echo "<tr>";
					echo "<td>";
						
						load_editor_text( "p_text" , stripcslashes($data['p_text']) );
						
					echo "</td>";
				echo "</tr>";
				echo "<tr><td height=10></td></tr>";
				echo "<tr>";
					echo "<td><input type='submit' class='submit_style' value='שמור'></td>";
				echo "</tr>";
				
			break;
			
			case "1" :
				echo "<tr>";
					echo "<td>אנא בחר וידיאו מרשימת גלרית הוידיאו</td>";
				echo "</tr>";
				echo "<tr><td height=10></td></tr>";
				
				for( $i=1 ; $i<=3 ; $i++ )
				{
					$sql = "SELECT id, name FROM user_video WHERE unk = '".UNK."' AND deleted=0";
					$resVid = mysql_db_query(DB,$sql);
					
					$vidValue = explode( "|" , $data['p_text'] );
					$vidNum = $i - 1;
					echo "<tr>";
						echo "<td>";
							echo "<select name='vid_".$i."' class='input_style'>";
								while( $dataVid = mysql_fetch_array($resVid) )
								{
									$selected = ( $dataVid['id'] == $vidValue[$vidNum] ) ? "selected" : "";
									echo "<option value='".$dataVid['id']."' ".$selected.">".stripslashes($dataVid['name'])."</option>";
								}
							echo "</select>";
						echo "</td>";
					echo "</tr>";
					echo "<tr><td height=10></td></tr>";
				}
				
				echo "<tr>";
					echo "<td><input type='submit' class='submit_style' value='שמור'></td>";
				echo "</tr>";
				
			break;
			
			case "2" :
				echo "<tr>";
					echo "<td>אנא בחר וידיאו מרשימת גלרית הוידיאו</td>";
				echo "</tr>";
				echo "<tr><td height=10></td></tr>";
				
				$sql = "SELECT id, name FROM user_video WHERE unk = '".UNK."' AND deleted=0";
				$resVid = mysql_db_query(DB,$sql);
					
				echo "<tr>";
					echo "<td>";
						echo "<select name='vid' class='input_style'>";
							while( $dataVid = mysql_fetch_array($resVid) )
							{
								$selected = ( $dataVid['id'] == $data['p_text'] ) ? "selected" : "";
								echo "<option value='".$dataVid['id']."' ".$selected.">".stripslashes($dataVid['name'])."</option>";
							}
						echo "</select>";
					echo "</td>";
				echo "</tr>";
				echo "<tr><td height=10></td></tr>";
				
				
				echo "<tr>";
					echo "<td><input type='submit' class='submit_style' value='שמור'></td>";
				echo "</tr>";
				
			break;
			
			case "3" :
				echo "<tr>";
					echo "<td>אנא בחר תמונות מרשימת גלרית התמונות</td>";
				echo "</tr>";
				echo "<tr><td height=10></td></tr>";
				
				for( $i=1 ; $i<=8 ; $i++ )
				{
					$sql = "select * from user_gallery_images where unk = '".UNK."' and deleted = '0' order by place, id desc ";
					$resImg = mysql_db_query(DB,$sql);
					
					$imgValue = explode( "|" , $data['p_text'] );
					$imgNum = $i - 1;
					echo "<tr>";
						echo "<td>";
							echo "<select name='img_".$i."' class='input_style'>";
								while( $dataImg = mysql_fetch_array($resImg) )
								{
									$selected = ( $dataImg['id'] == $imgValue[$imgNum] ) ? "selected" : "";
									echo "<option value='".$dataImg['id']."' ".$selected.">".stripslashes($dataImg['content'])."</option>";
								}
							echo "</select>";
						echo "</td>";
					echo "</tr>";
					echo "<tr><td height=10></td></tr>";
				}
				
				echo "<tr>";
					echo "<td><input type='submit' class='submit_style' value='שמור'></td>";
				echo "</tr>";
			break;
			
			case "4" :
				echo "<tr>";
					echo "<td>אנא בחר סוג טופס:</td>";
				echo "</tr>";
				echo "<tr><td height=10></td></tr>";
				
				$selected1 = ( $data['p_text'] == "1" ) ? "selected" : "";
				$selected2 = ( $data['p_text'] == "2" ) ? "selected" : "";
				
				echo "<tr>";
					echo "<td>";
						echo "<select name='FormType' class='input_style'>";
							echo "<option value='1' ".$selected1.">טופס צור קשר</option>";
							echo "<option value='2' ".$selected2.">טופס למערכת דיוור</option>";
						echo "</select>";
					echo "</td>";
				echo "</tr>";
				echo "<tr><td height=10></td></tr>";
				
				
				echo "<tr>";
					echo "<td><input type='submit' class='submit_style' value='שמור'></td>";
				echo "</tr>";
				
			break;
			
			case "5" :
				echo "<tr>";
					echo "<td>יש צורך לעדכן את טופס \"עדכון פרמטרים בטופס הצעת מחיר\" של דף הנקרא \"דף נחיתה - מערכת דיוור, נסתר!!\"</td>";
				echo "</tr>";
			break;
			
			case "6" :
				echo "<tr>";
					echo "<td>";
						
						load_editor_text( "p_text" , stripcslashes($data['p_text']) );
						
					echo "</td>";
				echo "</tr>";
				echo "<tr><td height=10></td></tr>";
				echo "<tr><td>קוד לוידיאו בגודל, רוחב: גובה:</td>";
				echo "<tr><td height=10></td></tr>";
				echo "<tr>";
					echo "<td><textarea name='vid_code' cols='' rows='' class='input_style' style='width: 300px; height: 100px;'>".$data['vid_code']."</textarea></td>";
				echo "</tr>";
				echo "<tr><td height=10></td></tr>";
				
				$abpath_temp2 = SERVER_PATH."/new_images/landing/".$data['side_img'];
				if( file_exists($abpath_temp2) && !is_dir($abpath_temp2) )
				{
					$side_img = "<a href=\"".HTTP_PATH."/new_images/landing/".$data['side_img']."\" class=\"maintext_small\" target=\"_blank\">צפיה בקובץ</a>&nbsp;&nbsp;|&nbsp;&nbsp;<a href=\"index.php?main=del_img_DB_FTP&field_name=side_img&table=sites_landingPage_paragraph&sesid=".SESID."&unk=".UNK."&path=new_images/landing/&img=".$data['side_img']."\" class=\"maintext_small\" onclick=\"return can_i_del()\">מחיקת הקובץ</a>";
				}
				echo "<tr><td>תמונה לצד הטקסט</td>";
				echo "<tr><td height=10></td></tr>";
				echo "<tr>";
					echo "<td><input type='file' name='side_img' class='input_style'> ".$side_img."</td>";
				echo "</tr>";
				echo "<tr><td height=10></td></tr>";
				
				$abpath_temp2 = SERVER_PATH."/new_images/landing/".$data['contact_side_img'];
				if( file_exists($abpath_temp2) && !is_dir($abpath_temp2) )
				{
					$contact_side_img = "<a href=\"".HTTP_PATH."/new_images/landing/".$data['contact_side_img']."\" class=\"maintext_small\" target=\"_blank\">צפיה בקובץ</a>&nbsp;&nbsp;|&nbsp;&nbsp;<a href=\"index.php?main=del_img_DB_FTP&field_name=contact_side_img&table=sites_landingPage_paragraph&sesid=".SESID."&unk=".UNK."&path=new_images/landing/&img=".$data['contact_side_img']."\" class=\"maintext_small\" onclick=\"return can_i_del()\">מחיקת הקובץ</a>";
				}
				echo "<tr><td>תמונה לצד הטופס</td>";
				echo "<tr><td height=10></td></tr>";
				echo "<tr>";
					echo "<td><input type='file' name='contact_side_img' class='input_style'> ".$contact_side_img."</td>";
				echo "</tr>";
				echo "<tr><td height=10></td></tr>";
				
				$abpath_temp2 = SERVER_PATH."/new_images/landing/".$data['contact_bottom_bg'];
				if( file_exists($abpath_temp2) && !is_dir($abpath_temp2) )
				{
					$contact_bottom_bg = "<a href=\"".HTTP_PATH."/new_images/landing/".$data['contact_bottom_bg']."\" class=\"maintext_small\" target=\"_blank\">צפיה בקובץ</a>&nbsp;&nbsp;|&nbsp;&nbsp;<a href=\"index.php?main=del_img_DB_FTP&field_name=contact_bottom_bg&table=sites_landingPage_paragraph&sesid=".SESID."&unk=".UNK."&path=new_images/landing/&img=".$data['contact_bottom_bg']."\" class=\"maintext_small\" onclick=\"return can_i_del()\">מחיקת הקובץ</a>";
				}
				echo "<tr><td>רקע לטופס</td>";
				echo "<tr><td height=10></td></tr>";
				echo "<tr>";
					echo "<td><input type='file' name='contact_bottom_bg' class='input_style'> ".$contact_bottom_bg."</td>";
				echo "</tr>";
				echo "<tr><td height=10></td></tr>";
				
				$abpath_temp2 = SERVER_PATH."/new_images/landing/".$data['contact_submit_botton'];
				if( file_exists($abpath_temp2) && !is_dir($abpath_temp2) )
				{
					$contact_submit_botton = "<a href=\"".HTTP_PATH."/new_images/landing/".$data['contact_submit_botton']."\" class=\"maintext_small\" target=\"_blank\">צפיה בקובץ</a>&nbsp;&nbsp;|&nbsp;&nbsp;<a href=\"index.php?main=del_img_DB_FTP&field_name=contact_submit_botton&table=sites_landingPage_paragraph&sesid=".SESID."&unk=".UNK."&path=new_images/landing/&img=".$data['contact_submit_botton']."\" class=\"maintext_small\" onclick=\"return can_i_del()\">מחיקת הקובץ</a>";
				}
				echo "<tr><td>כפתור לטופס</td>";
				echo "<tr><td height=10></td></tr>";
				echo "<tr>";
					echo "<td><input type='file' name='contact_submit_botton' class='input_style'> ".$contact_submit_botton."</td>";
				echo "</tr>";
				echo "<tr><td height=10></td></tr>";
				echo "<tr><td>צבע טקסט של אזור הטופס</td>";
				echo "<tr><td height=10></td></tr>";
				echo "<tr>";
					echo "<td><input type='text' name='text_form_color' value='".$data['text_form_color']."' class='input_style'></td>";
				echo "</tr>";
				echo "<tr><td height=10></td></tr>";
				echo "<tr>";
					echo "<td><input type='submit' class='submit_style' value='שמור'></td>";
				echo "</tr>";
			break;
		}
		
		
		
		
	echo "</table>";
	echo "</form>";
	
}

function LandingPage_module_p_DB()
{
	$sql = "SELECT * FROM sites_landingPage_paragraph WHERE deleted=0 AND landing_id='".$_POST['landing_id']."' AND module_id='".$_POST['module_id']."' AND id = '".$_POST['p_id']."' AND unk = '".UNK."' ";
	$resA = mysql_db_query(DB,$sql);
	$data = mysql_fetch_array($resA);
	
	switch( $data['module_type'] )
	{
		case "0" :
			$sql = "UPDATE sites_landingPage_paragraph SET p_text = '".addslashes($_POST['p_text'])."' WHERE id = '".$_POST['p_id']."' ";
			$res = mysql_db_query(DB,$sql);
		break;
		
		case "1":
			$vid_value = $_POST['vid_1']."|".$_POST['vid_2']."|".$_POST['vid_3'];
			$sql = "UPDATE sites_landingPage_paragraph SET p_text = '".$vid_value."' WHERE id = '".$_POST['p_id']."' ";
			$res = mysql_db_query(DB,$sql);
		break;
		
		case "2":
			$sql = "UPDATE sites_landingPage_paragraph SET p_text = '".$_POST['vid']."' WHERE id = '".$_POST['p_id']."' ";
			$res = mysql_db_query(DB,$sql);
		break;
		
		case "3":
			$vid_value = $_POST['img_1']."|".$_POST['img_2']."|".$_POST['img_3']."|".$_POST['img_4']."|".$_POST['img_5']."|".$_POST['img_6']."|".$_POST['img_7']."|".$_POST['img_8']."|".$_POST['img_9'];
			$sql = "UPDATE sites_landingPage_paragraph SET p_text = '".$vid_value."' WHERE id = '".$_POST['p_id']."' ";
			$res = mysql_db_query(DB,$sql);
		break;
		
		case "4":
			$sql = "UPDATE sites_landingPage_paragraph SET p_text = '".$_POST['FormType']."' WHERE id = '".$_POST['p_id']."' ";
			$res = mysql_db_query(DB,$sql);
		break;
		
		case "6":
			$sql = "UPDATE sites_landingPage_paragraph SET p_text = '".addslashes($_POST['p_text'])."' , vid_code = '".addslashes($_POST['vid_code'])."' , text_form_color = '".addslashes($_POST['text_form_color'])."'  WHERE id = '".$_POST['p_id']."' ";
			$res = mysql_db_query(DB,$sql);
			
			$fileFielsName = "side_img";
			if( $_FILES[$fileFielsName]['tmp_name'] != "" )
			{
				$abpath_temp = SERVER_PATH."/new_images/landing";
				$file_name = $_FILES[$fileFielsName]['name'];
				$exte = substr($file_name,(strpos($file_name,".")+1));
				$visual_file_name = UNK."-".$_POST['landing_id']."-side_img-".$_POST['module_id'].".".$exte;
				
				GlobalFunctions::upload_file_to_server($fileFielsName , $visual_file_name , $abpath_temp , array( "image","shockwave-flash") , array() , "2" , "copy");
				
				$sql = "UPDATE sites_landingPage_paragraph SET side_img = '".$visual_file_name."' where id = '".$_POST['p_id']."' ";
				$res = mysql_db_query(DB,$sql);
			}
			
			$fileFielsName = "contact_side_img";
			if( $_FILES[$fileFielsName]['tmp_name'] != "" )
			{
				$abpath_temp = SERVER_PATH."/new_images/landing";
				$file_name = $_FILES[$fileFielsName]['name'];
				$exte = substr($file_name,(strpos($file_name,".")+1));
				$visual_file_name = UNK."-".$_POST['landing_id']."-contact_side_img-".$_POST['module_id'].".".$exte;
				
				GlobalFunctions::upload_file_to_server($fileFielsName , $visual_file_name , $abpath_temp , array( "image","shockwave-flash") , array() , "2" , "copy");
				
				$sql = "UPDATE sites_landingPage_paragraph SET contact_side_img = '".$visual_file_name."' where id = '".$_POST['p_id']."' ";
				$res = mysql_db_query(DB,$sql);
			}
			
			$fileFielsName = "contact_submit_botton";
			if( $_FILES[$fileFielsName]['tmp_name'] != "" )
			{
				$abpath_temp = SERVER_PATH."/new_images/landing";
				$file_name = $_FILES[$fileFielsName]['name'];
				$exte = substr($file_name,(strpos($file_name,".")+1));
				$visual_file_name = UNK."-".$_POST['landing_id']."-contact_submit_botton-".$_POST['module_id'].".".$exte;
				
				GlobalFunctions::upload_file_to_server($fileFielsName , $visual_file_name , $abpath_temp , array( "image","shockwave-flash") , array() , "2" , "copy");
				
				$sql = "UPDATE sites_landingPage_paragraph SET contact_submit_botton = '".$visual_file_name."' where id = '".$_POST['p_id']."' ";
				$res = mysql_db_query(DB,$sql);
			}
			
			$fileFielsName = "contact_bottom_bg";
			if( $_FILES[$fileFielsName]['tmp_name'] != "" )
			{
				$abpath_temp = SERVER_PATH."/new_images/landing";
				$file_name = $_FILES[$fileFielsName]['name'];
				$exte = substr($file_name,(strpos($file_name,".")+1));
				$visual_file_name = UNK."-".$_POST['landing_id']."-contact_bottom_bg-".$_POST['module_id'].".".$exte;
				
				GlobalFunctions::upload_file_to_server($fileFielsName , $visual_file_name , $abpath_temp , array( "image","shockwave-flash") , array() , "2" , "copy");
				
				$sql = "UPDATE sites_landingPage_paragraph SET contact_bottom_bg = '".$visual_file_name."' where id = '".$_POST['p_id']."' ";
				$res = mysql_db_query(DB,$sql);
			}
		break;
		
		
	}
	
	echo "<script>window.location.href='index.php?main=LandingPage_module_pList&landing_id=".$_POST['landing_id']."&module_id=".$_POST['module_id']."&type=LandingPage&unk=".UNK."&sesid=".SESID."';</script>";
		exit;
}

function LandingPage_module_pList_DB()
{
	if( $_POST['p_id'] != "" )
	{
		$sql = "UPDATE sites_landingPage_paragraph SET place = '".$_POST['place']."' , module_type = '".$_POST['module_type']."' WHERE id = '".$_POST['p_id']."'";
		$res = mysql_db_query(DB,$sql);
	}
	else
	{
		$sql = "INSERT INTO sites_landingPage_paragraph ( unk , landing_id , module_id , place , module_type ) VALUES ( 
			'".UNK."' , '".$_POST['landing_id']."' , '".$_POST['module_id']."' , '".$_POST['place']."' , '".$_POST['module_type']."' )";
		$res = mysql_db_query(DB,$sql);
	}
	
	echo "<script>window.location.href='index.php?main=LandingPage_module_pList&module_id=".$_POST['module_id']."&landing_id=".$_POST['landing_id']."&type=LandingPage&unk=".UNK."&sesid=".SESID."';</script>";
		exit;
}

function LandingPage_del()
{
	$sql = "UPDATE sites_landingPage_settings SET deleted=1 WHERE id = '".$_GET['landing_id']."' AND unk='".UNK."' ";
	$res = mysql_db_query(DB,$sql);
	
	echo "<script>window.location.href='index.php?main=LandingPage&type=LandingPage&unk=".UNK."&sesid=".SESID."';</script>";
		exit;
}

function LandingPage_links_del()
{
	$sql = "UPDATE sites_landingPage_links SET deleted=1 WHERE id = '".$_GET['link_id']."' AND unk='".UNK."' ";
	$res = mysql_db_query(DB,$sql);
	
	
	echo "<script>window.location.href='index.php?main=LandingPage_edit&landing_id=".$_GET['landing_id']."&type=LandingPage&unk=".UNK."&sesid=".SESID."';</script>";
		exit;
}

function LandingPage_module_del()
{
	$sql = "UPDATE sites_landingPage_modules SET deleted=1 WHERE id = '".$_GET['module_id']."' AND unk='".UNK."' ";
	$res = mysql_db_query(DB,$sql);
	
	
	echo "<script>window.location.href='index.php?main=LandingPage_edit&landing_id=".$_GET['landing_id']."&type=LandingPage&unk=".UNK."&sesid=".SESID."';</script>";
		exit;
}


function LandingPage_module_p_del()
{
	$sql = "UPDATE sites_landingPage_paragraph SET deleted=1 WHERE id = '".$_GET['p_id']."' AND unk='".UNK."' ";
	$res = mysql_db_query(DB,$sql);
	
	
	echo "<script>window.location.href='index.php?main=LandingPage_module_pList&landing_id=".$_GET['landing_id']."&module_id=".$_GET['module_id']."&type=LandingPage&unk=".UNK."&sesid=".SESID."';</script>";
		exit;
}


