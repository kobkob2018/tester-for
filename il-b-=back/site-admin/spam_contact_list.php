<?php

function spam_contact_list(){
	echo "<h1>רשימת הודעות ספאם שהתקבלו</h1>";
echo "<A href=\"?main=view_estimate_form_list&sesid=".SESID."\" >חזרה לרשימת הצעות מחיר שהתקבלו mysave</a> &nbsp;&nbsp;&nbsp;";	
echo "<A href=\"?sesid=".SESID."\" >חזרה לתפריט הראשי</a>";
	
	
	$where_sql = "";
	
	
	$count_sql = "SELECT COUNT(id) as rows_count FROM estimate_form_spam".$where_sql;
			
	$count_res = mysql_db_query(DB, $count_sql);
	$row_count = mysql_fetch_array($count_res);
	$num_rows = $row_count['rows_count'];
	$limit_rows = 50;
	$page_id =  ( !empty($_GET['page_id']) ) ? $_GET['page_id'] : '1';
	if($page_id == '0')
		$page_id = '1';
	$limit_row = ($page_id-1)*$limit_rows;
	
	$limit_sql = " LIMIT ".$limit_row.", ".$limit_rows." ";
	$sql = "SELECT * FROM estimate_form_spam ".$where_sql." ORDER BY id desc ".$limit_sql;	

	$res = mysql_db_query(DB, $sql);
	echo "<div>סך הכל ".$num_rows." בקשות</div>";
	echo "<table border='1' cellpadding='5' style='border-collapse:collapse;'>";
		echo "<tr>";
			echo "<td><b>תאריך שליחה</b></td>";
			echo "<td><b>שם מלא</b></td>";			
			echo "<td><b>מספר טלפון</b></td>";			
			echo "<td><b>אימייל</b></td>";			
			echo "<td><b>הערה</b></td>";			
			echo "<td><b>IP</b></td>";		
			echo "<td><b>קטגוריה</b></td>";			
			echo "<td><b>קטגוריה משנית</b></td>";			
			echo "<td><b>התמחות</b></td>";
			echo "<td><b>סוג ספאם</b></td>";
		echo "</tr>";
	
	while($spam_lead_data = mysql_fetch_array($res)){
		$sql = "select cat_name from biz_categories where id='".$spam_lead_data['cat_spec']."'";
		$ressc = mysql_db_query(DB,$sql);
		$data_cat_spec = mysql_fetch_array($ressc);
		
		$sql = "select cat_name from biz_categories where id='".$spam_lead_data['cat_f']."'";
		$resf = mysql_db_query(DB,$sql);
		$data_cat_f = mysql_fetch_array($resf);
		
		$sql = "select cat_name from biz_categories where id='".$spam_lead_data['cat_s']."'";
		$ress = mysql_db_query(DB,$sql);
		$data_cat_s = mysql_fetch_array($ress);
		$explode_date1 = explode(" " , $spam_lead_data['insert_date']);
		$explode_date2 = explode("-" , $explode_date1[0]);

		$explode_date = $explode_date2[2]."-".$explode_date2[1]."-".$explode_date2[0]."<br>".$explode_date1[1];
		echo "<tr>";
		echo "<td>".$explode_date."</td>";
		echo "<td>".$spam_lead_data['name']."</td>";	
		echo "<td>".$spam_lead_data['phone']."</td>";
		echo "<td>".$spam_lead_data['email']."</td>";
		echo "<td>".$spam_lead_data['note']."</td>";
		echo "<td>".$spam_lead_data['ip']."</td>";
		echo "<td>".$data_cat_f['cat_name']."</td>";
		echo "<td>".$data_cat_s['cat_name']."</td>";
		echo "<td>".$data_cat_spec['cat_name']."</td>";
		echo "<td>".$spam_lead_data['block_type']."</td>";
		echo "</tr>";
	}
	echo "</table>";
	
	

						
	if( $num_rows > $limit_rows ){//$limit_rows $num_rows
		echo "<div><table border='1' cellpadding='5' style='border-collapse:collapse;'><tr>";		
			$z = 0;	
			
			for($i=1 ; ($i*$limit_rows) < $num_rows ; $i++)
			{				
				$pz = $z+1;			
						if( $i == $_GET['page_id'] )
							$classi = "<td><strong style='display:block;padding:10px;color:#000000;'>".$pz."</strong></td>";
						else
							$classi = "<td><a style='display:block;padding:10px;' href='index.php?main=anf&gf=spam_contact_list&page_id=".$i."&sesid=".SESID."' class='maintext'>".$pz."</a></td>";			
						echo $classi;		
						$z = $z + 1;		
						if( $z%35 == 0 )
							echo "<br>";
			}
		echo "</tr></table></div>";
	}		 
}