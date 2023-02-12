<?php

function custom_lead_reports()
{
	if(isset($_POST['export_reports'])){
		return custom_lead_reports_export();
	}
	if(isset($_POST['record_edit'])){
		return custom_lead_reports_DB();
	}
	echo "<h1>ניהול דוחות לידים אוטומטיים</h1>";
	if(isset($_GET['edit_success'])){
		echo "<div style='margin:10px; color:red'><b>הדוח עודכן בהצלחה</b></div>";
	}
	echo "<div style='margin:10px;'><a href=\"?sesid=".SESID."\" >חזרה לתפריט הראשי</a></div>";
	
	if(isset($_GET['record_id'])){
		echo "<div style='margin:10px;'><a href=\"index.php?main=custom_lead_reports&sesid=".SESID."\" >חזרה לרשימת הדוחות</a></div>";
		if($_GET['record_id'] != 'new'){
			$report_sql = "SELECT * FROM custom_lead_report WHERE id = ".$_GET['record_id'];
			$repordt_res = mysql_db_query(DB,$report_sql);
			$report_data = mysql_fetch_array($repordt_res);
			echo "<h2>עריכת דוח: ".$report_data['report_name']."</h2>";
		}
		else{
			echo "<h2>הוספת דוח</h2>";
		}
		echo "<div style='float:right; border:1px solid; padding:20px;'>";
			echo "<form action='index.php?main=custom_lead_reports&sesid=".SESID."' name='custom_lead_reports' method='POST'>";
				echo "<div style='float:left;'><input type='submit' value='שלח' /></div>";
				echo "<input type='hidden' name='record_edit' value='".$_GET['record_id']."' />";
				$sql = "select cat_name,id from biz_categories where father = 0 and status = 1";
				$res_father = mysql_db_query(DB,$sql);
				echo "<div>שם הדוח: <br/><input type='text' name='report_name' value='".$report_data['report_name']."' /></div>";
				echo "<div>שם התיקייה בקובץ להורדה(אותיות באנגלית ומספרים): <br/><input type='text' name='dir_name' value='".$report_data['dir_name']."' /></div>";
				echo "<h4>שיוך לקטגוריות:</h4>";
				echo "<script src=\"options.fiels/htmldb_html_elements.js\" type=\"text/javascript\"></script>";
				$open_father_cats = array();
				$open_tat_cats = array();
				$cat_list = "<table border=\"0\" cellpadding=\"0\" cellspacing=\"0\" width=\"100%\">";
					$cat_list .= "<tr>";
						$cat_list .= "<td style=\"background-color:#cccccc;\">";
						
							$cat_list .= "<ul style=\"list-style:none\" class=\"dhtmlTree\">";
								while( $data_father = mysql_fetch_array($res_father) )
								{
									if($_GET['record_id'] != 'new'){
										$sql = "select cat_id from clr_cat where clr_id = '".$report_data['id']."' and cat_id = '".$data_father['id']."'";
										$res_cat_id = mysql_db_query(DB,$sql);
										$data_cat_id = mysql_fetch_array($res_cat_id);
										
										if( $data_cat_id['cat_id'] == $data_father['id'] )	{
											$selected1 = "checked";
											$checked_cats[] = array('cat_id'=>$data_father['id'],'spaces'=>"",'cat_name'=>$data_father['cat_name']);
										}	else	{
											$selected1 = "";
										}
									}
									else{
										$selected1 = "";
									}
									$cat_list .= "<li><img  id='plus_img_".$data_father['id']."' src=\"options.fiels/plus.jpg\" onclick=\"htmldb_ToggleWithImage(this,'treeCAT".$data_father['id']."')\" class=\"pseudoButtonInactive\" />
									".stripslashes($data_father['cat_name'])."
									<input type=\"checkbox\" name=\"select_cat[".$data_father['id']."]\" value=\"1\" ".$selected1.">
									</li>";
									
									$sql = "select cat_name,id from biz_categories where father = ".$data_father['id']." and status = 1";
									$res_father_cat = mysql_db_query(DB,$sql);
									
									$cat_list .= "<ul id=\"treeCAT".$data_father['id']."\" htmldb:listlevel=\"2\" style=\"padding-right:15px;list-style:none;display:none;\" class=\"dhtmlTree\">";
										while( $data_father_cat = mysql_fetch_array($res_father_cat) )
										{
											if($_GET['record_id'] != 'new'){
												$sql = "select cat_id from clr_cat where clr_id = '".$report_data['id']."' and cat_id = '".$data_father_cat['id']."'";
												$res_cat_id = mysql_db_query(DB,$sql);
												$data_cat_id = mysql_fetch_array($res_cat_id);
												
												if( $data_cat_id['cat_id'] == $data_father_cat['id'] )	{
													$open_father_cats[$data_father['id']] = '1';
													$selected2 = "checked";
													$checked_cats[] = array('cat_id'=>$data_father_cat['id'],'spaces'=>"&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;",'cat_name'=>$data_father_cat['cat_name']);
												}	else	{
													$selected2 = "";
												}
											}
											else{
												$selected2 = "";
											}
											$sql = "select cat_name,id from biz_categories where father = '".$data_father_cat['id']."' and status = '1'";
											$res_father_tat_cat = mysql_db_query(DB,$sql);
											$num_father_tat_cat = mysql_num_rows($res_father_tat_cat);
											
											if( $num_father_tat_cat > 0 )
											{
												$cat_list .= "<li>
												<img id='plus_img_".$data_father_cat['id']."' src=\"options.fiels/plus.jpg\" onclick=\"htmldb_ToggleWithImage(this,'treeF_CAT".$data_father_cat['id']."')\" class=\"pseudoButtonInactive\" />
												".$data_father_cat['cat_name']."
												<input type=\"checkbox\" name=\"select_cat[".$data_father_cat['id']."]\" value=\"1\" ".$selected2."></li>";
												
												$cat_list .= "<ul id=\"treeF_CAT".$data_father_cat['id']."\" htmldb:listlevel=\"3\" style=\"padding-right:15px;list-style:none;display:none;\" class=\"dhtmlTree\">";
												
												while( $data_father_tat_cat = mysql_fetch_array($res_father_tat_cat) )
												{
													if($_GET['record_id'] != 'new'){
														$sql = "select cat_id from clr_cat where clr_id = '".$report_data['id']."' and cat_id = '".$data_father_tat_cat['id']."'";
														$res_cat_id = mysql_db_query(DB,$sql);
														$data_cat_id = mysql_fetch_array($res_cat_id);
														
														if( $data_cat_id['cat_id'] == $data_father_tat_cat['id'] )	{
															$open_tat_cats[$data_father_cat['id']] = '1';
															$open_father_cats[$data_father['id']] = '1';
															$selected3 = "checked";
															$checked_cats[] = array('cat_id'=>$data_father_tat_cat['id'],'spaces'=>"&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;",'cat_name'=>$data_father_tat_cat['cat_name']);
														}	else	{
															$selected3 = "";
														}
													}
													else{
														$selected3 = "";
													}
													$cat_list .= "<li><img src=\"options.fiels/node.jpg\" /><input type=\"checkbox\" name=\"select_cat[".$data_father_tat_cat['id']."]\" value=\"1\" ".$selected3.">".$data_father_tat_cat['cat_name']."</li>";
												}
												$cat_list .= "</ul>";
											}
											else
											{
												$cat_list .= "<li><img src=\"options.fiels/node.jpg\" />
												<input type=\"checkbox\" name=\"select_cat[".$data_father_cat['id']."]\" value=\"1\" ".$selected2.">".$data_father_cat['cat_name']."</li>";
											}
										}
									$cat_list .= "</ul>";
								}
							$cat_list .= "</ul>";
						$cat_list .= "</td>";
					$cat_list .= "</tr>";
				$cat_list .= "</table>";
				echo $cat_list;	
			echo "</form>";
			echo "<script type='text/javascript'>";
				echo "setTimeout(
					function(){";
						foreach($open_father_cats as $cat_id=>$cat){
							echo "
							var open_cat = jQuery('#plus_img_".$cat_id."');
							open_cat.click();
							";
						}
					echo "}
					,500
				);";
				echo "setTimeout(
					function(){";
						foreach($open_tat_cats as $cat_id=>$cat){
							echo "
							var open_cat = jQuery('#plus_img_".$cat_id."');
							open_cat.click();
						";	
						}
					echo "}
					,1000
				);";
			echo "</script>";
		echo "</div>";
		
		echo "<div style='font-size:16px; margin:16px; float:left; border:1px solid; padding:20px;'>";
		echo "<h3>ייצא דוח</h3>";
		echo "<form action='index.php?main=custom_lead_reports&sesid=".SESID."' name='custom_lead_reports' method='POST'>";
			echo "<input type='hidden' name='export_reports' value='".$report_data['id']."' />";
			echo "<div>
				מתאריך: <input type='text' name='date_from' value='' />&nbsp;&nbsp;&nbsp;&nbsp;
				עד תאריך: <input type='text' name='date_to' value='' />&nbsp;&nbsp;&nbsp;&nbsp;
				<input type='submit' value='שלח' />
			</div>";
		echo "</form>"; 
		
		echo "</div>"; 
		echo "<div style='font-size:16px; margin:16px; float:left; border:1px solid; padding:20px;'>";
		echo "<h3>מחיקת דוח</h3>";
		echo "<form action='index.php?main=custom_lead_reports&sesid=".SESID."' name='custom_lead_reports' method='POST'>";
				echo "<input type='hidden' name='record_edit' value='".$_GET['record_id']."' />";
				echo "<input type='hidden' name='record_delete' value='1' />";
				echo "<div style='float:left;'><input type='submit' value='לחץ כאן למחיקת הדוח' onclick = 'return confirm(\"האם אתה בטוח שברצונך למחוק את הדוח?\")'/></div>";
		echo "</form>";
		echo "</div>";
	}
	else{
		
		$report_sql = "SELECT * FROM custom_lead_report";
		$repordt_res = mysql_db_query(DB,$report_sql);
		echo "<div style='float:right;font-family: arial;'>";
			echo "<div style='margin:10px 0px;'><a href='index.php?main=custom_lead_reports&record_id=new&sesid=".SESID."' style='clear: both;float:none;display:block;padding:10px;border: 1px solid black;background: -webkit-linear-gradient(#d0cccc, #fff);text-align: center;text-decoration: none;color: #278411;font-size: 21px;font-family: arial;text-shadow: 1px 3px 4px #9999f9;'>הוסף דוח חדש</a></div>";
			echo "<div style='border:1px solid;'><h4 style='margin: 10px 20px;'>רשימת הדוחות</h4>";
				while($report_data = mysql_fetch_array($repordt_res)){
					echo "<div style='clear:both; float:none;'><a style='clear:both;float:none;display:block;padding:10px;border-top:1px solid black;background: -webkit-linear-gradient(#aaa, #fff);text-align: center;text-decoration: none;color: black;font-size: 18px;font-family: arial;margin-bottom: 15px;border-bottom: 1px solid;' href='index.php?main=custom_lead_reports&record_id=".$report_data['id']."&sesid=".SESID."' >".$report_data['report_name']."</a></div>";
				}
			echo "</div>";
		echo "</div>";
		echo "<div style='background: -webkit-linear-gradient(#d0cccc, #fff);text-decoration: none;color: #278411;font-size: 21px;text-shadow: 1px 3px 4px #9999f9;float:left;border:1px solid;padding:20px;font-family: arial;margin: 10px 20px;'>";
			echo "<h3>ייצוא דוחות</h3>";
			echo "<form action='index.php?main=custom_lead_reports&sesid=".SESID."' name='custom_lead_reports' method='POST'>";
				echo "<input type='hidden' name='export_reports' value='all' />";
				echo "<div>
					מתאריך: <input type='text' name='date_from' value='' />&nbsp;&nbsp;&nbsp;&nbsp;
					עד תאריך: <input type='text' name='date_to' value='' />&nbsp;&nbsp;&nbsp;&nbsp;
					<input type='submit' value='שלח' />
				</div>";
			echo "</form>"; 
		echo "</div>"; 
	}
}

function custom_lead_reports_DB(){
	$cat_list = $_POST['select_cat'];
	$clr_id = $_POST['record_edit'];
	$report_name = $_POST['report_name'];
	$dir_name = $_POST['dir_name'];
	if(isset($_POST['record_delete'])){
		$sql = "DELETE FROM clr_cat WHERE clr_id = $clr_id";
		$res = mysql_db_query(DB,$sql);		
		$sql = "DELETE FROM custom_lead_report WHERE id = $clr_id";
		$res = mysql_db_query(DB,$sql);				
	}
	else{
		if($clr_id != "new"){
			$sql = "DELETE FROM clr_cat WHERE clr_id = $clr_id";
			$res = mysql_db_query(DB,$sql);
			$sql = "UPDATE custom_lead_report SET report_name = '$report_name', dir_name = '$dir_name' WHERE id = $clr_id";
			$res = mysql_db_query(DB,$sql);		
		}
		else{
			$sql = "INSERT INTO custom_lead_report(report_name,dir_name) values('$report_name','$dir_name')";
			$res = mysql_db_query(DB,$sql);
			$clr_id = mysql_insert_id();
		}
		$cat_sql_arr = array();
		
		foreach($cat_list as $cat_id=>$cat){
			$cat_sql_arr[] = "($clr_id,$cat_id)";
			
		}
		if(!empty($cat_sql_arr)){
			$cat_sql_vals = implode(",",$cat_sql_arr);
			$sql = "INSERT INTO clr_cat(clr_id,cat_id) values $cat_sql_vals;";

			mysql_db_query(DB,$sql);
		}
	}
	header("location:index.php?main=custom_lead_reports&edit_success=1&sesid=".SESID);	
}

function custom_lead_reports_export(){
	
	$date_from_arr = explode("-",$_REQUEST['date_from']);
	$date_from = $date_from_arr[2]."-".$date_from_arr[1]."-".$date_from_arr[0];
	
	$date_to_arr = explode("-",$_REQUEST['date_to']);
	$date_to = $date_to_arr[2]."-".$date_to_arr[1]."-".$date_to_arr[0];	
	$report_list = array();
	$where = "";
	if($_REQUEST['export_reports'] != "all"){
		$where = " WHERE id= ".$_REQUEST['export_reports'];
	}
	$sql="SELECT * FROM custom_lead_report".$where;
	$res = mysql_db_query(DB,$sql);
	while($report_data = mysql_fetch_array($res)){
		$report_settings = array('id'=>$report_data['id'],'report_name'=>$report_data['report_name'],'dir_name'=>$report_data['dir_name'],
								'cats'=>array(),'date_from'=>$date_from,'date_to'=>$date_to);
		$cats_sql="SELECT * FROM clr_cat WHERE clr_id = ".$report_data['id'];
		$cats_res = mysql_db_query(DB,$cats_sql);
		while($cat_data = mysql_fetch_array($cats_res)){
			$report_settings['cats'][] = $cat_data['cat_id'];
		}	
		
		
		$report_list[$report_data['id']] = get_report_data($report_settings);
		
	}
	$r_i = 1;
	$maindirname = time();
	foreach($report_list as $report){
		$dirname = $report['settings']['dir_name'];
		$filename = "phones";
		create_report_files($maindirname,$dirname,'phones',$report['phones_arr']);
		create_report_files($maindirname,$dirname,'emails',$report['email_arr']);
		create_report_files($maindirname,$dirname,'leads',$report['leads_arr']);
		$r_i++;
	}
	get_ziped_files($maindirname);	
}

function get_report_data($report_settings){
	$cats_in = implode(",",$report_settings['cats']);


	$city_name_list = array();
	$city_name_sql = "SELECT * FROM newCities WHERE 1";
	$city_name_res = mysql_db_query(DB,$city_name_sql);
	while($city_data = mysql_fetch_array($city_name_res)){
		$city_name_list[$city_data['id']] = $city_data['name'];
	}
	
	$user_id_list = array();
	$users_sql = "SELECT user_id FROM user_cat WHERE cat_id IN($cats_in)";
	$users_res = mysql_db_query(DB,$users_sql);
	while($user_data = mysql_fetch_array($users_res)){
		$user_id_list[$user_data['user_id']] = $user_data['user_id'];
	}	
	$users_sql = "SELECT user_id FROM user_cat_city WHERE cat_id IN($cats_in)";
	$users_res = mysql_db_query(DB,$users_sql);
	while($user_data = mysql_fetch_array($users_res)){
		$user_id_list[$user_data['user_id']] = $user_data['user_id'];
	}	
	$users_in = implode(",",$user_id_list);
	
	$unk_list = array();
	$unk_name = array();
	$unk_sql = "SELECT unk,name FROM users WHERE id IN($users_in)";
	$unk_res = mysql_db_query(DB,$unk_sql);
	while($unk_data = mysql_fetch_array($unk_res)){
		$unk_list[$unk_data['unk']] = "'".$unk_data['unk']."'";
		$unk_name[$unk_data['unk']] = "'".$unk_data['name']."'";
	}	
	$unk_in = implode(",",$unk_list);
	$users_in = implode(",",$user_id_list);	
	$date_from = $report_settings['date_from'];
	
	$date_to = $report_settings['date_to'];
	$clr_id = $report_settings['id'];
	
	$lead_list = array();
	$phone_list = array();
	$email_list = array();
	$leads_sql = "SELECT * FROM estimate_form WHERE (cat_f IN($cats_in) OR cat_s IN($cats_in) OR cat_spec IN($cats_in)) AND insert_date > '$date_from' AND insert_date < '$date_to'";

	$leads_res = mysql_db_query(DB,$leads_sql);
	
	while($lead_data = mysql_fetch_array($leads_res)){
		
		if(!isset($phone_list[$lead_data['phone']])){
			$phone_list[$lead_data['phone']] = array($lead_data['phone']);
			$lead_list['forms'][] = $lead_data;
			
		}
		if(!isset($email_list[$lead_data['email']])){
			$email_list[$lead_data['email']] = array($lead_data['email']);
		}		
	}
	$leads_sql = "SELECT * FROM user_contact_forms WHERE unk IN($unk_in) AND date_in > '$date_from' AND date_in < '$date_to' AND lead_recource != 'form'";
	
	$leads_res = mysql_db_query(DB,$leads_sql);
	while($lead_data = mysql_fetch_array($leads_res)){
			
		if(!isset($phone_list[$lead_data['phone']])){
			$phone_list[$lead_data['phone']] = array($lead_data['phone']);
			$lead_list['phones'][] = $lead_data;
		}
		if(!isset($email_list[$lead_data['email']])){
			$email_list[$lead_data['email']] = array($lead_data['email']);
		}		
	}
	$row_leads_arr = array();
	$row_leads_arr[] = array('רשימת טופסי צור קשר:');
	$row_leads_arr[] =  array('תאריך', 'שם מלא', 'דוא"ל', 'טלפון', 'מקור הליד','שיחה ללקוח', 'תוכן','עיר' );
	foreach($lead_list['forms'] as $lead_data){
		$row_leads_arr[] = array( stripslashes($lead_data['insert_date']) , stripslashes($lead_data['name']) , stripslashes($lead_data['email']) , stripslashes($lead_data['phone']) , 'טופס באתר','', stripslashes(str_replace(",","','",$lead_data['note'])),$city_name_list[$lead_data['city']]);
	}

	$row_leads_arr[] = array("----");
	$row_leads_arr[] = array('רשימת טלפונים שהתקבלו:');
	foreach($lead_list['phones'] as $lead){
		//$row_leads_arr[] = array( stripslashes($lead['date_in']) , stripslashes($lead['name']) , stripslashes($lead['email']) , stripslashes($lead['phone']), $lead['opened_str'] , stripslashes($lead['content']) , 'טופס באתר',$lead['refunded_str'] );
		$sql3 = "SELECT sms_send,call_from,answer,call_date,billsec  FROM sites_leads_stat WHERE id = ".$lead['phone_lead_id']."";
		$res = mysql_db_query(DB, $sql3);
		$call_data = mysql_fetch_assoc($res); 
		$answ = ( $call_data['billsec'] == '0' ) ? "ללא מענה" : "שיחה של ".$call_data['billsec']." שניות";
		$row_leads_arr[] = array( stripslashes($call_data['call_date']) , '' , '' , stripslashes($call_data['call_from']) , 'מערכת טלפונייה' ,stripslashes($unk_name[$lead['unk']]),$answ,'');						
	}

	return array("settings"=>$report_settings,"leads_arr"=>$row_leads_arr,"phones_arr"=>$phone_list,"email_arr"=>$email_list);
}

function custom_lead_report_html($report_arr){
	
	$td_count = 0;
	foreach($report_arr as $arr){
		if(count($arr) > $td_count){
			$td_count = count($arr);
		}
	}
	
	echo "<table border='1'>";
		foreach($report_arr as $arr){
			echo "<tr>";
			$arr_count = 0;
			foreach($arr as $td){
				echo "<td>".$td."</td>";
				$arr_count++;
			}
			$td_left = $td_count - $arr_count;
			if($td_left > 0){
				echo "<td colspan='".$td_left."'></td>";
			}
			echo "</tr>";
		}
	echo "</table>";
}

function create_report_files($maindirname,$dirname,$filename,$data){

	if(!is_dir("clr_files/".$maindirname."/")){
		$old = umask(0);
		mkdir("clr_files/".$maindirname, 0777);
		umask($old);
	}
	$old = umask(0);
	mkdir("clr_files/".$maindirname."/".$dirname, 0777);
	umask($old);
	$fp = fopen("clr_files/".$maindirname."/".$dirname."/".$filename.".csv", "w") or die("Unable to open file!");
	// Loop data and write to file pointer
	foreach ($data as $line){
		fputcsv($fp, $line);
	}
	fclose($fp);
	return;
}


function get_ziped_files($maindirname){
	
	$the_folder = 'clr_files/'.$maindirname."/";
	//exit($the_folder);
	$zip_file_name = $the_folder.time().'_reports.zip';


	$download_file= true;	
	$za = new FlxZipArchive;
	$res = $za->open($zip_file_name, ZipArchive::CREATE);
	if($res === TRUE) 
	{
		$za->addDir($the_folder, basename($the_folder));
		$za->close();
	}
	else  { echo 'Could not create a zip archive';}


	ob_get_clean();
	header("Pragma: public");
	header("Expires: 0");
	header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
	header("Cache-Control: private", false);
	header("Content-Type: application/zip");
	header("Content-Disposition: attachment; filename=reports.zip;" );
	header("Content-Transfer-Encoding: binary");
	header("Content-Length: " . filesize($zip_file_name));
	readfile($zip_file_name);

	deleteDirectory($the_folder);	
}

class FlxZipArchive extends ZipArchive {
    /** Add a Dir with Files and Subdirs to the archive;;;;; @param string $location Real Location;;;;  @param string $name Name in Archive;;; @author Nicolas Heimann;;;; @access private  **/

    public function addDir($location, $name) {
        $this->addEmptyDir($name);

        $this->addDirDo($location, $name);
     } // EO addDir;

    /**  Add Files & Dirs to archive;;;; @param string $location Real Location;  @param string $name Name in Archive;;;;;; @author Nicolas Heimann
     * @access private   **/
    private function addDirDo($location, $name) {
        $name .= '/';
        $location .= '/';

        // Read all Files in Dir
        $dir = opendir ($location);
        while ($file = readdir($dir))
        {
            if ($file == '.' || $file == '..') continue;
            // Rekursiv, If dir: FlxZipArchive::addDir(), else ::File();
            $do = (filetype( $location . $file) == 'dir') ? 'addDir' : 'addFile';
            $this->$do($location . $file, $name . $file);
        }
    } // EO addDirDo();
}

function deleteDirectory($dirPath) {
    if (is_dir($dirPath)) {
        $objects = scandir($dirPath);
        foreach ($objects as $object) {
            if ($object != "." && $object !="..") {
                if (filetype($dirPath . DIRECTORY_SEPARATOR . $object) == "dir") {
                    deleteDirectory($dirPath . DIRECTORY_SEPARATOR . $object);
                } else {
                    unlink($dirPath . DIRECTORY_SEPARATOR . $object);
                }
            }
        }
    reset($objects);
    rmdir($dirPath);
    }
}