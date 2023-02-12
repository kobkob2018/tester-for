<?php

header('Content-Type: text/html; charset=utf-8');


function contantList()	{


	$status = ( $_GET['status'] == "" ) ? $_POST['status'] : $_GET['status'];
	$status = ( $status == "" ) ? "0" : $status;
	
	$sql = "select * from shapiroContactList where status = '".$status."' ";
	$res = mysql_db_query(DB,$sql);
	
	
	echo "<table border=\"0\" cellspacing=\"0\" cellpadding=\"0\" class=\"maintext\" width='100%'>";
	
		echo "<tr><Td height=\"7\" colspan=\"11\"></TD></tr>";
		
		
		$s_status0 = ( $status == "0" ) ? "<b>" : "<a href='index.php?main=contantList&status=0&sesid=".SESID."&unk=".UNK."' class='maintext'>";
		$e_status0 = ( $status == "0" ) ? "</b>" : "</a>";
		$s_status1 = ( $status == "1" ) ? "<b>" : "<a href='index.php?main=contantList&status=1&sesid=".SESID."&unk=".UNK."' class='maintext'>";
		$e_status1 = ( $status == "1" ) ? "</b>" : "</a>";
		$s_status2 = ( $status == "2" ) ? "<b>" : "<a href='index.php?main=contantList&status=2&sesid=".SESID."&unk=".UNK."' class='maintext'>";
		$e_status2 = ( $status == "2" ) ? "</b>" : "</a>";
		$s_status3 = ( $status == "3" ) ? "<b>" : "<a href='index.php?main=contantList&status=3&sesid=".SESID."&unk=".UNK."' class='maintext'>";
		$e_status3 = ( $status == "3" ) ? "</b>" : "</a>";
		$s_status4 = ( $status == "4" ) ? "<b>" : "<a href='index.php?main=contantList&status=4&sesid=".SESID."&unk=".UNK."' class='maintext'>";
		$e_status4 = ( $status == "4" ) ? "</b>" : "</a>";
		
		
		echo "<tr>";
			echo "<td align=\"center\" colspan=\"11\">";
				echo "<table border=\"0\" cellspacing=\"0\" cellpadding=\"0\" class=\"maintext\" width='100%'>";
					echo "<tr>";
						echo "<td>".$s_status0."קונה חדש".$e_status0."</td>";
						echo "<td width=10></td>";
						echo "<td>".$s_status1."נשלח ללקוח".$e_status1."</td>";	
						echo "<td width=10></td>";
						echo "<td>".$s_status2."ממתין לשליחה".$e_status2."</td>";
						echo "<td width=10></td>";
						echo "<td>".$s_status3."חיובים נכשלים".$e_status3."</td>";
						echo "<td width=10></td>";
						echo "<td>".$s_status4."מחוקים".$e_status4."</td>";
					echo "</tr>";
				echo "</table>";
			echo "</td>";
		echo "</tr>";
		
		echo "<tr><Td height=\"10\" colspan=\"11\"></TD></tr>";
		
		echo "<tr>";
			
			echo "<td><b>תאריך</b></td>";
			echo "<td width=10></td>";
			echo "<td><b>שפה</b></td>";
			echo "<td width=10></td>";
			echo "<td><b>חוייב?</b></td>";
			echo "<td width=10></td>";
			echo "<td><b>שם הקונה</b></td>";
			echo "<td width=10></td>";
			echo "<td><b>ארץ</b></td>";
			echo "<td width=10></td>";
			echo "<td><b>כתובת</b></td>";
			echo "<td width=10></td>";
			echo "<td><b>טלפון</b></td>";
			echo "<td width=10></td>";
			echo "<td><b>סטטוס</b></td>";
		echo "</tr>";
		
		while( $data = mysql_fetch_array($res) )
		{
			echo "<tr><Td height=\"10\" colspan=\"11\"></TD></tr>";
			
			echo "<form action=\"index.php\" name=\"formi_".$data['id']."\" method=\"GET\" >";
			echo "<input type=\"hidden\" name=\"main\" value=\"UpdateContact\">";
			echo "<input type=\"hidden\" name=\"unk\" value=\"".UNK."\">";
			echo "<input type=\"hidden\" name=\"sesid\" value=\"".SESID."\">";
			echo "<input type=\"hidden\" name=\"row_id\" value=\"".$data['id']."\">";
			echo "<input type=\"hidden\" name=\"stauts\" value=\"".$status."\">";
			
			echo "<tr>";
				echo "<td>".GlobalFunctions::show_dateTime_field(stripslashes($data['insert_date']))."</td>";
				echo "<td width=10></td>";
				echo "<td><a href='https://secure.ilbiz.co.il/clients/coolsense.net/?lang=".stripslashes($data['langSite'])."' class='maintext' target='_blank'>".stripslashes($data['langSite'])."</a></td>";
				echo "<td width=10></td>";
				
				switch( $data['debited'] ) 
				{
					case "0" :		$debited = "לא ידוע";			break;
					case "1" :		$debited = "<font style='color: green;'>חוייב</font>";			break;
					case "2" :		$debited = "<font style='color: red;'>לא חוייב</font>";			break;
				}
				echo "<td>".$debited."</td>";
				echo "<td width=10></td>";
				
				echo "<td>".stripslashes($data['fname'])."</td>";
				echo "<td width=10></td>";
				echo "<td>".stripslashes($data['country'])."</td>";
				echo "<td width=10></td>";
				echo "<td>".stripslashes($data['address'])."</td>";
				echo "<td width=10></td>";
				echo "<td>".stripslashes($data['phone'])."</td>";
				echo "<td width=10></td>";
				echo "<td>";
				
				$selected0 = ( $status == "0" ) ? "selected" : "";
				$selected1 = ( $status == "1" ) ? "selected" : "";
				$selected2 = ( $status == "2" ) ? "selected" : "";
				$selected3 = ( $status == "3" ) ? "selected" : "";
				$selected4 = ( $status == "4" ) ? "selected" : "";
				
					echo "<select name='newStatus' class='input_style' onchange='formi_".$data['id'].".submit()' style='width: 100px;'>
					
						<option value='0' ".$selected0.">קונה חדש</option>
						<option value='1' ".$selected1.">נשלח ללקוח</option>
						<option value='2' ".$selected2.">ממתין לשליחה</option>
						<option value='3' ".$selected3.">חיובים נכשלים</option>
						<option value='4' ".$selected4.">מחק</option>
						
					</select>
				</td>";
			echo "</tr>";
			
			echo "</form>";
		}
	
	
	echo "</table>";
}


function UpdateContact()
{
	$sql = "UPDATE shapiroContactList SET status = '".$_GET['newStatus']."' WHERE id = '".$_GET['row_id']."' ";
	$res = mysql_db_query(DB,$sql);
	
	echo "<script>window.location.href='index.php?main=contantList&status=".$_GET['status']."&sesid=".SESID."&unk=".UNK."';</script>";
		exit;
}

?>