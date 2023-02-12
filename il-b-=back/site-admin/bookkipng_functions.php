<?php

function bookkiping_end_date()
{
	
	$year = ( $_GET['year'] == "" ) ? date('Y') : $_GET['year'];
	$mon = ( $_GET['mon'] == "" ) ? date('m') : $_GET['mon'];
	
	if( $_GET['type'] == "host" )
	{
		$sql = "SELECT u.name, u.unk, u.id, u.domain, u.end_date, u.active_manager, u.status, ub.hostPriceMon FROM users AS u LEFT JOIN user_bookkeeping AS ub 
		ON 
			u.unk=ub.unk
		WHERE
		 deleted=0 AND
		 end_date LIKE '".$year."-".$mon."-%'
		GROUP BY 
			u.unk
		";
	}
	elseif( $_GET['type'] == "dynamic_end_date" )
	{
		$sql = "SELECT u.name, u.unk, u.id, u.domain, u.active_manager, u.status, ub.advertisingStartDate, ub.advertisingPeriod , ub.advertisingPrice , ub.advertisingStartDate + INTERVAL ub.advertisingPeriod MONTH AS new_date , 12 * (YEAR(ub.advertisingStartDate) - ".(int)$year.") + (MONTH(ub.advertisingStartDate) - ".(int)$mon.") AS months FROM users AS u , user_bookkeeping AS ub 
		 WHERE
			u.unk=ub.unk AND ub.advertisingStartDate + INTERVAL ub.advertisingPeriod MONTH AND

		 	deleted=0 

		 GROUP BY u.unk
	having months % ub.advertisingPeriod = 0
		";
	}
	elseif( $_GET['type'] == "domain" )
	{
		$sql = "SELECT u.name, u.unk, u.id, u.domain, u.active_manager, u.status, ub.domainEndDate, ub.domainPrice FROM users AS u , user_bookkeeping AS ub 
		 WHERE
			u.unk=ub.unk AND
			ub.domainEndDate LIKE '".$year."-".$mon."-%' AND
		 	deleted=0 
		 GROUP BY 
			u.unk
		";
	}
	
	$res = mysql_db_query(DB,$sql);
	
	echo "<table border=\"0\" cellspacing=\"0\" cellpadding=\"3\" class=\"maintext\">";
		
		echo "<tr>
			<td colspan=\"20\"><A href=\"?sesid=".SESID."\" class=\"maintext\">חזרה לתפריט הראשי</a></td>
		</tr>";
		echo "<tr><td colspan=\"20\" height=\"11\"></td></tr>";
		
		echo "<tr>";
			echo "<td colspan=\"20\">
				<form action='index.php' method='get' name='formi' style='padding:0;margin:0;'>
				<input type='hidden' name='main' value='bookkiping_end_date'>
				<input type='hidden' name='type' value='".$_GET['type']."'>
				<input type='hidden' name='sesid' value='".SESID."'>
				בחר שנה: 
				<select name='year' class='input_style' style='width: 70px;>";
					for( $i=2005 ; $i<=(date('Y')+2) ; $i++ )
					{
						$selected = ( $i == $year ) ? "selected" : "";
						echo "<option value='".$i."' ".$selected.">".$i."</option>";
					}
				echo "</select>
				בחר חודש: 
				<select name='mon' class='input_style' style='width: 70px;>";
					for( $i=0 ; $i<=12 ; $i++ )
					{
						if( $i < 10 )
							$newi = "0".$i;
						else
							$newi = $i;
						$selected = ( $i == $mon ) ? "selected" : "";
						echo "<option value='".$newi."' ".$selected.">".$i."</option>";
					}
				echo "</select>
				<input type='submit' value='חפש' class='submit_style'>
				</form>
			</td>";
		echo "</tr>";
		
		echo "<tr><td colspan=\"20\" height=\"11\"></td></tr>";
		echo "<tr>";
			echo "<td><strong>שם הלקוח</strong></td>";
			echo "<td width=\"15\"></td>";
			echo "<td><strong>דומיין</strong></td>";
			echo "<td width=\"15\"></td>";
			echo "<td><strong>תאריך סיום</strong></td>";
			echo "<td width=\"15\"></td>";
			echo "<td><strong>מחיר</strong></td>";
			echo "<td width=\"15\"></td>";
			echo "<td><strong>אתר פעיל?</strong></td>";
			echo "<td width=\"15\"></td>";
			echo "<td><strong>מערכת ניהול פעילה?</strong></td>";
		echo "</tr>";
		
		while( $data = mysql_fetch_array($res) )	
		{
			$status = ( $data['status'] == "0" ) ? "פעיל" : "לא פעיל";
			$active_manager = ( $data['active_manager'] == "0" ) ? "פעיל" : "לא פעיל";
			
			switch( $_GET['type'] )
			{
				case "host" :
					$field_name_end_date = "end_date";
					$price = "hostPriceMon";
				break;
				
				case "domain" :
					$field_name_end_date = "domainEndDate";
					$price = "domainPrice";
				break;
				
				case "dynamic_end_date" :
					$field_name_end_date = "advertisingStartDate";
					$price = "advertisingPrice";
				break;
			}
			$ex_date = explode( "-" , $data[$field_name_end_date] );
			
			echo "<tr><Td colspan=\"20\" height=\"5\"></TD></tr>";
			echo "<tr>";
				echo "<td><a href='http://www.ilbiz.co.il/site-admin/index.php?main=user_profile&unk=".$data['unk']."&record_id=".$data['id']."&sesid=".SESID."' class='maintext_link' target='_blank'>".stripslashes($data['name'])."</a></td>";
				echo "<td width=\"15\"></td>";
				echo "<td><a href='http://".$data['domain']."' class='maintext_link' target='_blank'>".$data['domain']."</a></td>";
				echo "<td width=\"15\"></td>";
				echo "<td>".$ex_date[2]."-".$ex_date[1]."-".$ex_date[0];
					if( $_GET['type'] == "dynamic_end_date" )
					{
						$new_end_date = explode( "-" , $data['new_date'] );
						echo " חידוש כל ".$data['advertisingPeriod']." חודשים";
					}
						
				echo "</td>";
				echo "<td width=\"15\"></td>";
				echo "<td>".$data[$price]."</td>";
				echo "<td width=\"15\"></td>";
				echo "<td>".$status."</td>";
				echo "<td width=\"15\"></td>";
				echo "<td>".$active_manager."</td>";
			echo "</tr>";
			echo "<tr><Td colspan=\"20\" height=\"5\"></TD></tr>";
		}
	echo "</table>";
}
?>