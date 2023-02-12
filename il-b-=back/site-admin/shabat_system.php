<?php


/**************************************************************************************************/
function shabat_system(){
	$shabat_func_req = "shabat_list";
	if(isset($_REQUEST['scope'])){
		$shabat_func_req = $_REQUEST['scope'];
	}
	switch($shabat_func_req){
		case "shabat_list": 
		case "shabat_xls_import":		
			print_shabat_system_header();
		break;		
	}	
	switch($shabat_func_req){
		case "shabat_list": return shabat_list(); break;
		case "shabat_xls_import": return shabat_xls_import();break;	
	}
}




function print_shabat_system_header(){
	$top_a_styles = array(
		"shabat_list"=>"",
	);
	$top_a_styles[$_REQUEST['scope']] = " style='color:black; font-weight:bold; text-decoration:none;' ";
	echo "<h1>ניהול שעות כניסת ויציאת שבת</h1>";
	
	echo "<table>";
		echo "<tr>";
			echo "<td>";
				echo "<a href='index.php?sesid=".SESID."' >חזרה לתפריט הראשי</a>";
			echo "</td>";
			echo "<td width='15'></td>";
			echo "<td>";
				echo "<a href='index.php?scope=shabat_list&main=shabat_system&sesid=".SESID."' ".$top_a_styles['shabat_list'].">רשימת שבתות</a>";
			echo "</td>";	
			echo "<td width='15'></td>";			
			echo "<td>";
				echo "<a href='index.php?scope=shabat_xls_import&main=shabat_system&sesid=".SESID."' ".$top_a_styles['shabat_xls_import'].">ייבוא שעות כניסת שבת</a>";
			echo "</td>";
			echo "<td width='15'></td>";
		echo "</tr>";		
	echo "</table>";
	echo "<div style='height:40px;' ></div>";
}

function shabat_list()
{
	if(isset($_GET['delete_shabat'])){
		$sql = "DELETE FROM shabat_list WHERE id = ".$_GET['delete_shabat']."";
		$res = mysql_db_query( DB, $sql );		
		echo "<script>alert('הרשומה נמחקה');</script>";
		echo "<META HTTP-EQUIV=Refresh CONTENT=\"0; URL=index.php?scope=shabat_list&main=shabat_system&sesid=".SESID."\">";
		return;
	}	
	$limitCount = ( $_GET['limit'] == "" ) ? "0" : $_GET['limit'];
	
	
	$where = "";
	$sql = "SELECT * FROM shabat_list as s WHERE 1 
		 ".$where." ORDER BY s.start_year,s.start_month,s.start_day";
	$res = mysql_db_query( DB, $sql );
	
	$sql = "SELECT s.id FROM shabat_list as s WHERE 1 
		".$where." ";
	$resAll = mysql_db_query( DB, $sql );
	$num_rows = mysql_num_rows($resAll);
	
	echo "<table border='0' style='font-size:18px;border-collapse: collapse;' cellspacing='0' cellpadding='10' class='maintext'>";
		
		echo "<tr>";
			echo "<th colspan='10'><b>כניסת שבת</b></td>";
			echo "<th colspan='10'><b>יציאת שבת</b></td>";
			echo "<td>מחיקה</td>";
		echo "</tr>";
		

		
		while( $data = mysql_fetch_array($res) )
		{

			echo "<tr>";
				echo "<td>".$data['start_year']."</td>";				
				echo "<td width=1>/</td>";	

				echo "<td>".$data['start_month']."</td>";				
				echo "<td width=1>/</td>";	
				
				echo "<td>".$data['start_day']."</td>";				
				echo "<td width=15></td>";	
				
				echo "<td>".$data['start_minute']."</td>";				
				echo "<td width=1>:</td>";	
				
				echo "<td>".$data['start_hour']."</td>";				
				echo "<td width=30></td>";	
				
				echo "<td>".$data['end_year']."</td>";				
				echo "<td width=1>/</td>";	

				echo "<td>".$data['end_month']."</td>";				
				echo "<td width=1>/</td>";	
				
				echo "<td>".$data['end_day']."</td>";				
				echo "<td width=15></td>";	
				
				echo "<td>".$data['end_minute']."</td>";				
				echo "<td width=1>:</td>";	
				
				echo "<td>".$data['end_hour']."</td>";				
				echo "<td width=1></td>";	
								
				echo "<td><a href='index.php?main=shabat_system&scope=shabat_list&delete_shabat=".$data['id']."&sesid=".SESID."' class='maintext'>מחק</a></td>";
			echo "</tr>";
			
		}
		
		echo "<tr><td colspan=20 height=15></td></tr>";
		echo "<tr>";
			echo "<td colspan=20 align=center>סך הכל שבתות מעודכנות: ".$num_rows."</td>";
		echo "</tr>";
		echo "<tr><td colspan=20 height=15></td></tr>";
		echo "<tr>";
			echo "<td colspan=20 align=center style=\"border-top: 1px solid #".$data_colors['border_color'].";\">";	
				$params['limitInPage'] = "50";
				$params['numRows'] = $num_rows;
				$params['limitcount'] = $limitCount;
				$params['main'] = 'shabat_system';
				$params['scope'] = 'shabat_list';
				echo "<div style='max-width:400px; overflow:auto; padding:10px;'>";
				get_shabat_system_pagention( $params );
				echo "</div>";
			echo "</td>";
		echo "</tr>";
	echo "</table>";	
}
/**************************************************************************************************/

function get_shabat_system_pagention( $params=array() )
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
									$classi = "<a href='index.php?main=".$main."&scope=".$scope."&sesid=".SESID."&limit=".$i."' class='maintext'>".$pz."</a>&nbsp;&nbsp;";
								
								echo $classi;
								
								$z = $z + 1;
						}
					}
				echo "</td>";
			echo "</tr>";
		}
	echo "</table>";
}

function shabat_xls_import(){
	
	if(isset($_SESSION['uploaded_shabats'])){
		if(isset($_GET['cancel_shabats'])){
			unset($_SESSION['uploaded_shabats']);
			echo "<script>alert('העלאת קובץ בוטלה');</script>";
			echo "<META HTTP-EQUIV=Refresh CONTENT=\"0; URL=index.php?scope=shabat_xls_import&main=shabat_system&sesid=".SESID."\">";
			return;
		}
		if(isset($_GET['save_shabats'])){
			$report_array = array();
			$session_shabats = $_SESSION['uploaded_shabats'];
			unset($_SESSION['uploaded_shabats']);
			$shabat_values = "";
			$shabat_i = 0;
			foreach($session_shabats as $new_shabat){
				if($shabat_i != 0){
					$shabat_values.=", ";
				}
				$shabat_values .="(".$new_shabat['start_year'].", ".$new_shabat['start_month'].", ".$new_shabat['start_day'].", ".$new_shabat['start_hour'].", ".$new_shabat['start_minute'].", ".$new_shabat['end_year'].", ".$new_shabat['end_month'].", ".$new_shabat['end_day'].", ".$new_shabat['end_hour'].", ".$new_shabat['end_minute'].")";
				$shabat_i++;	
				
			}
			
			$sql =	"INSERT INTO shabat_list ( start_year, start_month, start_day, start_hour, start_minute, end_year, end_month, end_day, end_hour, end_minute) VALUES ". $shabat_values." 
				ON DUPLICATE KEY UPDATE 
				start_year=VALUES(start_year),start_month=VALUES(start_month),start_day=VALUES(start_day),start_hour=VALUES(start_hour),start_minute=VALUES(start_minute),
				end_year=VALUES(end_year),end_month=VALUES(end_month),end_day=VALUES(end_day),end_hour=VALUES(end_hour),end_minute=VALUES(end_minute)";

			
			$res = mysql_db_query(DB,$sql);
			echo "<script>alert('העלאת שבתות בוצעה');</script>";
			echo "<META HTTP-EQUIV=Refresh CONTENT=\"0; URL=index.php?scope=shabat_list&main=shabat_system&sesid=".SESID."\">";
			return;
		}
		$session_shabats = $_SESSION['uploaded_shabats'];	
		echo "<h3>העלאת שבתות מקובץ</h3>";
		echo "<div style='color:red;font-weight:bold'>במידה והרשימה לא תקינה, בדוק את הקובץ, לחץ על ביטול ונסה להעלות שוב.</div>";
		echo "<table border='0' cellspacing='0' cellpadding='5' class='maintext'>";
		echo "<tr>";
			echo "<td><a style='font-size:18px;' href='index.php?scope=shabat_xls_import&main=shabat_system&cancel_shabats=1&sesid=".SESID."'>לחץ כאן לביטול<a/></td>";
			echo "<td width='15'></td>";
			echo "<td><a style='font-size:18px;' style='' href='index.php?scope=shabat_xls_import&main=shabat_system&save_shabats=1&sesid=".SESID."'>לחץ כאן לאישור ושמירה<a/></td>";
		echo "</tr>";
		echo "<table border='1' cellspacing='0' cellpadding='5' class='maintext'>";
			echo "<tr>";
				echo "<th>שנת כניסה</th>";
				echo "<th>חודש כניסה</th>";
				echo "<th>יום כניסה</th>";
				echo "<th>שעת כניסה</th>";
				echo "<th>דקת כניסה</th>";
				echo "<th>שנת יציאה</th>";
				echo "<th>חודש יציאה</th>";
				echo "<th>יום יציאה</th>";
				echo "<th>שעת יציאה</th>";
				echo "<th>דקת יציאה</th>";
			echo "</tr>";
			foreach($session_shabats as $new_shabat){
				echo "<tr>";
					echo "<td>".$new_shabat['start_year']."</td>";
					echo "<td>".$new_shabat['start_month']."</td>";
					echo "<td>".$new_shabat['start_day']."</td>";
					echo "<td>".$new_shabat['start_hour']."</td>";
					echo "<td>".$new_shabat['start_minute']."</td>";
					echo "<td>".$new_shabat['end_year']."</td>";
					echo "<td>".$new_shabat['end_month']."</td>";
					echo "<td>".$new_shabat['end_day']."</td>";
					echo "<td>".$new_shabat['end_hour']."</td>";
					echo "<td>".$new_shabat['end_minute']."</td>";
				echo "</tr>";
			}
		echo "</table>";
		return;
	}
	
	if(isset($_FILES['xls_file'])){
		$file_content = file_get_contents($_FILES['xls_file']['tmp_name']);
		$line_arr = explode("\n",$file_content);
		$rows_arr = array();
		$shabats_arr = array();
		foreach($line_arr as $line){
			$rows_arr[] = explode(",",$line);
		}

		$row_arr_h = $rows_arr[0];
		foreach($rows_arr as $row_key=>$row){
			if($row_key!=0){
				$shabat_arr = array();
				foreach($row as $col_key=>$col){
					if($row_arr_h[$col_key]!=""){
						$shabat_arr[trim($row_arr_h[$col_key])] = $col;
					}
				}
				$shabats_arr[] = $shabat_arr;
								
			}
		}

		$sesstion_shabats = array();
		foreach($shabats_arr as $shabat){
			if($shabat['start_year'] != ""){
				$sesstion_shabats[] = $shabat;
			}
		}
		$_SESSION['uploaded_shabats'] = $sesstion_shabats;
		echo "<META HTTP-EQUIV=Refresh CONTENT=\"0; URL=index.php?scope=shabat_xls_import&main=shabat_system&sesid=".SESID."\">";
		return;
	}
	echo "<h3>ייבוא שבתות בקובץ אקסל</h3>";
	echo "<form action='index.php?scope=shabat_xls_import&main=shabat_system&sesid=".SESID."' enctype='multipart/form-data' name='conatct_search' method='POST'>";
		echo "<table border='0' cellspacing='0' cellpadding='5' class='maintext'>";
			echo "<tr>";
				echo "<td>העלאת קובץ</td>";
				echo "<td width='10'></td>";
				echo "<td><input type='file' name='xls_file' class='input_style'/></td>";
				echo "<td width='30'></td>";
				echo "<td></td>";
				echo "<td width='10'></td>";
				echo "<td><input type='submit' class='submit_style' value='שלח!' style='width: 80px;'></td>";
			echo "</tr>";
			echo "<tr><td colspan=7 height=5></td></tr>";			
		echo "</table>";					
	echo "</form>";	
}

function net_upload_enco($str)
{
	return iconv( "UTF-8","windows-1255", $str);
}
?>