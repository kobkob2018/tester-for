<?php


/**************************************************************************************************/
function private_contacts_imports(){
	if(!isset($_GET['test'])){
	//exit("UNDER CONTRUCTION!!!");
	}
	if(!isset($_REQUEST['unk'])){
		echo "לא הוגדר מזהה לקוח";
		echo "<br/><a href='index.php?sesid=".SESID."' >חזרה לתפריט הראשי</a>";
		
		return;
	}
	define("UNK",$_REQUEST['unk']);
	$imp_func_req = "imp_list";
	if(isset($_REQUEST['scope'])){
		$imp_func_req = $_REQUEST['scope'];
	}
	switch($imp_func_req){
		case "imp_list":		
			print_imp_system_header();
		break;		
	}	
	switch($imp_func_req){
		case "imp_list": return imp_list(); break;		
	}
}

function print_imp_system_header(){
	$imp_func_req = "imp_list";
	if(isset($_REQUEST['scope'])){
		$imp_func_req = $_REQUEST['scope'];
	}	
	$top_a_styles = array(
		"imp_list"=>"",
	);
	
	$top_a_styles[$imp_func_req] = " style='color:black; font-weight:bold; text-decoration:none;' ";
	

	echo "<h1>ייבוא מספרי טלפון ששייכים ללקוח</h1>";
	
	echo "<table>";
		echo "<tr>";
			echo "<td>";
				echo "<a href='index.php?sesid=".SESID."' >חזרה לתפריט הראשי</a>";
			echo "</td>";
			echo "<td width='15'></td>";
			echo "<td>";
				echo "<a href='index.php?scope=imp_list&main=private_contacts_imports&sesid=".SESID."&unk=".UNK."' ".$top_a_styles['imp_list'].">רשימת טלפונים מהלקוח</a>";
			echo "</td>";	
			echo "<td width='15'></td>";	
		echo "</tr>";
		
	echo "</table>";
	echo "<div style='height:40px;' ></div>";
}


function imp_list(){
	
	if(isset($_GET['imp_remove'])){
		$sql = "DELETE FROM private_contacts_imports WHERE id=".$_GET['imp_remove']."";
		$res = mysql_db_query(DB,$sql);
		echo "<script>alert('מספר הטלפון הוסר מהרשימה');</script>";
		echo "<META HTTP-EQUIV=Refresh CONTENT=\"0; URL=index.php?scope=imp_list&main=private_contacts_imports&sesid=".SESID."&unk=".UNK."\">";
		return;
	}


	if(isset($_FILES['xls_file_import'])){
		$file_content = file_get_contents($_FILES['xls_file_import']['tmp_name']);
		$line_arr = explode("\n",$file_content);
		$rows_arr = array();
		$phones_arr = array();
		foreach($line_arr as $line){
			$rows_arr[] = explode("\t",$line);
		}
		foreach($rows_arr as $row_key=>$row){
			foreach($row as $col_key=>$col){
				$phone = trim($col);
				if($phone!=""){
					$phones_arr[] = $phone;
				}
			}
		}
		$add_i = 0;
		$phone_val_sql = "";
		$unk = UNK;
		$date_str = "now()";
		if($_REQUEST['update_time']!= ""){
			$date_arr = explode("-",$_REQUEST['update_time']);
			$date_str = "'".$date_arr[2]."-".$date_arr[1]."-".$date_arr[0]." 00:00:00'";
		}			
		foreach($phones_arr as $phone){	
			if($_REQUEST['pass_existing'] == '1'){
				$pass_sql = "SELECT phone FROM user_contact_forms WHERE unk = '".UNK."' AND phone = '$phone'";
				$pass_res = mysql_db_query(DB,$pass_sql);
				$pass_data = mysql_fetch_array($pass_res);
				if($pass_data['phone'] != ""){
					$pass_i++;
					continue;
				}
			}		
			if($add_i != 0){
				$phone_val_sql.=",";
			}
			$phone_val_sql.="('$unk','$phone',	$date_str)";
			$add_i++;	
		}
		if($add_i != 0){
			
			$sql = "INSERT IGNORE private_contacts_imports (unk,phone,update_time) VALUES $phone_val_sql";
			if($_REQUEST['force_date'] == '1'){
				$sql = "INSERT INTO private_contacts_imports (unk,phone,update_time) VALUES $phone_val_sql ON DUPLICATE KEY UPDATE update_time=VALUES(update_time)";
			}
			$res = mysql_db_query(DB,$sql);
		}
		$pass_alert = "";
		
		if($pass_i>0){ 
			$pass_alert = ". ".$pass_i." מספרי טלפון לא נשמרו כי היו קיימים בטפסים";
		}
		echo "<script>alert('מספרי הטלפון נוספו בהצלחה $pass_alert');</script>";
		echo "<META HTTP-EQUIV=Refresh CONTENT=\"0; URL=index.php?scope=imp_list&main=private_contacts_imports&sesid=".SESID."&unk=".UNK."\">";
		return;		
	}



	
	if(isset($_POST['phones_to_add'])){
		$phones_to_add_arr = explode(",",$_POST['phones_to_add']);
		$add_i = 0;
		$phone_val_sql = "";
		$unk = UNK;
		$date_str = "now()";
		if($_REQUEST['update_time']!= ""){
			$date_arr = explode("-",$_REQUEST['update_time']);
			$date_str = "'".$date_arr[2]."-".$date_arr[1]."-".$date_arr[0]." 00:00:00'";	
		}			
		$pass_i = 0;
		foreach($phones_to_add_arr as $phone_to_add){
			$phone = trim($phone_to_add);
			if($_REQUEST['pass_existing'] == '1'){
				$pass_sql = "SELECT phone FROM user_contact_forms WHERE unk = '".UNK."' AND phone = '$phone'";
				$pass_res = mysql_db_query(DB,$pass_sql);
				$pass_data = mysql_fetch_array($pass_res);
				if($pass_data['phone'] != ""){
					$pass_i++;
					continue;
				}
			}
			if($phone != ""){
				if($add_i != 0){
					$phone_val_sql.=",";
				}
				
				$phone_val_sql.="('$unk','$phone',$date_str)";
				$add_i++;
			}
		}		
		if($add_i != 0){
			$sql = "INSERT IGNORE INTO private_contacts_imports (unk,phone,update_time) VALUES $phone_val_sql";
			if($_REQUEST['force_date'] == '1'){
				$sql = "INSERT INTO private_contacts_imports (unk,phone,update_time) VALUES $phone_val_sql ON DUPLICATE KEY UPDATE update_time=VALUES(update_time)";
			}
			$res = mysql_db_query(DB,$sql);
		}
		$pass_alert = "";
		
		if($pass_i>0){
			$pass_alert = ". ".$pass_i." מספרי טלפון לא נשמרו כי היו קיימים בטפסים";
		}
		echo "<script>alert('מספרי הטלפון נוספו בהצלחה $pass_alert');</script>";
		echo "<META HTTP-EQUIV=Refresh CONTENT=\"0; URL=index.php?scope=imp_list&main=private_contacts_imports&sesid=".SESID."&unk=".UNK."\">";
		return;
	}	
	echo "<h3>רשימת מספרי הטלפון של הלקוח</h3>";
	echo "
		<style type='text/css'>
			a.open{color:red;}
		</style>
		<script type='text/javascript'>
			function open_wrap(wrap_id,a_el){
				jQuery(function($){
					if($(a_el).hasClass('closed')){
						$(a_el).removeClass('closed');
						$(a_el).addClass('open');
						$('#'+wrap_id).show();
					}
					else{
						$(a_el).removeClass('open');
						$(a_el).addClass('closed');
						$('#'+wrap_id).hide();						
					}
				});
			}
		</script>
	";
	echo "<div><a href='javascript://' class='closed' onclick='open_wrap(\"imp_import_wrap\",this);'>ייבוא רשימת טלפונים מקובץ אקסל</a></div>";
	echo "<div style='display:none;' id='imp_import_wrap'>";
		echo "<h3>ייבוא רשימת טלפונים מקובץ אקסל</h3>";
		echo "<form action='index.php?scope=imp_list&main=private_contacts_imports&sesid=".SESID."&unk=".UNK."' enctype='multipart/form-data' name='conatct_search' method='POST'>";
			echo "<table border='0' cellspacing='0' cellpadding='5' class='maintext'>";
				echo "<tr>";
					echo "<td></td>";
					echo "<td width='10'></td>";
					echo "<td>קובץ csv שמכיל מספרי טלפון בלבד, ללא כותרות</td>";
					echo "<td width='30'></td>";
					echo "<td>תאריך עדכון (דוגמה: 01-01-1970)<br/>השאר את השדה ריק כדי לעדכן את התאריך לעכשיו</td>";
					echo "<td width='30'></td>";
					echo "<td>החלף תאריך לטלפונים קיימים</td>";
					echo "<td width='30'></td>";
					echo "<td>מה לעשות עם טלפונים שקיימים בטפסי צור קשר?</td>";
					echo "<td width='30'></td>";						
					echo "<td></td>";
				echo "</tr>";
				echo "<tr>";
					echo "<td>העלאת קובץ</td>";
					echo "<td width='10'></td>";
					echo "<td><input type='file' name='xls_file_import' class='input_style'/></td>";
					echo "<td width='30'></td>";
					echo "<td><input type='text' style='width:160px;' name='update_time' class='input_style'/></td>";
					echo "<td width='30'></td>";
					echo "<td>
						<select name='force_date' class='input_style' style='width:60px;'>
							<option value='0' selected>לא</option>
							<option value='1'>כן</option>
						</select>
					</td>";
					echo "<td width='30'></td>";
					echo "<td>
						<select name='pass_existing' class='input_style' style='width:60px;'>
							<option value='1' selected>דלג</option>
							<option value='0'>הוסף בכל זאת</option>
						</select>
					</td>";					
					echo "<td width='30'></td>";
					echo "<td><input type='submit' class='submit_style' value='שלח!' style='width: 80px;'></td>";
				echo "</tr>";
				echo "<tr><td colspan=7 height=5></td></tr>";			
			echo "</table>";					
		echo "</form>";	
	echo "</div><hr/>";
	echo "<div><a href='javascript://' class='closed' onclick='open_wrap(\"imp_addone_wrap\",this);'>הוספת טלפונים ידנית</a></div>";
	echo "<div style='display:none;' id='imp_addone_wrap'>";
		echo "<h3>הוספת טלפונים ידנית</h3>";
		echo "<form action='index.php?scope=imp_list&main=private_contacts_imports&sesid=".SESID."&unk=".UNK."' name='conatct_search' method='POST'>";
			echo "<table border='0' cellspacing='0' cellpadding='5' class='maintext'>";
				echo "<tr>";
					echo "<td></td>";
					echo "<td width='10'></td>";
					echo "<td>רשימת מספרים</td>";
					echo "<td width='30'></td>";
					echo "<td>תאריך עדכון(דוגמה: 01-01-1970)<br/>השאר את השדה ריק כדי לעדכן את התאריך לעכשיו</td>";
					echo "<td width='30'></td>";
					echo "<td>החלף תאריך לטלפונים קיימים</td>";
					echo "<td width='30'></td>";
					echo "<td>מה לעשות עם טלפונים שקיימים בטפסי צור קשר?</td>";
					echo "<td width='30'></td>";
					echo "<td></td>";
				echo "</tr>";				
				echo "<tr>";
					echo "<td>מספרי טלפון(מופרד בפסיקים)</td>";
					echo "<td width='10'></td>";
					echo "<td><textarea style='text-align:left;direction:ltr;width: 300px; height: 153px;' name='phones_to_add' class='input_style'></textarea></td>";
					echo "<td width='30'></td>";
					echo "<td><input type='text' style='width:160px;' name='update_time' class='input_style'/></td>";
					echo "<td width='30'></td>";
					echo "<td>
						<select name='force_date' class='input_style' style='width:60px;'>
							<option value='0' selected>לא</option>
							<option value='1'>כן</option>
						</select>
					</td>";
					echo "<td width='30'></td>";
					echo "<td>
						<select name='pass_existing' class='input_style' style='width:60px;'>
							<option value='1' selected>דלג</option>
							<option value='0'>הוסף בכל זאת</option>
						</select>
					</td>";					
					echo "<td width='30'></td>";
					echo "<td><input type='submit' class='submit_style' value='שלח!' style='width: 80px;'></td>";
				echo "</tr>";
				echo "<tr><td colspan=7 height=5></td></tr>";			
			echo "</table>";					
		echo "</form>";	
	echo "</div><hr/>";	
	echo "<h3>רשימת הטלפונים של הלקוח</h3>";
	$phone_sql = "SELECT * FROM private_contacts_imports WHERE unk = '".UNK."' ORDER BY phone";
	$phone_res = mysql_db_query(DB,$phone_sql);
	while($phone_data = mysql_fetch_array($phone_res)){
		echo "<div style='float:right; padding:5px; margin:5px; width:165px; height:68px; overflow:auto; border:1px solid black;'>";
			echo "<span style='font-weight:bold;'>". $phone_data['phone']. "</span>";
			echo "<br/>";
			$update_time_arr = explode(" ",$phone_data['update_time']);
			$update_time_date_arr = explode("-",$update_time_arr[0]);
			$update_time_time = $update_time_arr[1];
			$update_time_date = $update_time_date_arr[2]."-".$update_time_date_arr[1]."-".$update_time_date_arr[0];
			echo $update_time_time." ".$update_time_date;
			echo "<br/>";
			echo "<a href='index.php?scope=imp_list&main=private_contacts_imports&imp_remove=".$phone_data['id']."&sesid=".SESID."&unk=".UNK."' onclick = 'return confirm(\"האם אתה בטוח שברצונך להסיר מספר זה מהרשימה?\")'>לחץ כאן להסרה</a>";
		echo "</div>";
	}
}

function get_imp_system_pagention( $params=array() )
{
	$limitInPage = $params['limitInPage'];
	$numRows = $params['numRows'];
	$limitcount = $params['limitcount'];
	$main = $params['main'];
	$scope = $params['scope'];
	
	echo "<table align=center border=0 cellspacing=\"0\" width=100% cellpadding=\"3\" class=\"maintext\">";
		
		if( $numRows > $limitInPage )
		{
			echo "<tr>";
				echo "<td align=center>";
				
					$z = 0;
					for($i=0 ; $i < $numRows ; $i++)
					{
						$pz = $z+1;
						
						if($i % $limitInPage == 0)
						{
								if( $i == $limitcount )
									$classi = "<strong style=\"color:#000000\">".$pz."</strong>&nbsp;&nbsp;";
								else
									$classi = "<a href='index.php?main=".$main."&scope=".$scope."&sesid=".SESID."&unk=".UNK."&limit=".$i."' class='maintext'>".$pz."</a>&nbsp;&nbsp;";
								
								echo $classi;
								
								$z = $z + 1;
						}
					}
				echo "</td>";
			echo "</tr>";
		}
	echo "</table>";
}


function imp_upload_enco($str)
{
	return iconv( "UTF-8","windows-1255", $str);
}
?>