<?php

function spam_contact_list(){
	$where_sql = "";
	
	
	$count_sql = "SELECT COUNT(id) as rows_count FROM estimate_form_spam".$where_sql;
			
	$count_res = mysql_db_query(DB, $count_sql);
	$row_count = mysql_fetch_array($count_res);
	$num_rows = $row_count['rows_count'];
	$limit_rows = 3;
	$page_id =  ( !empty($_GET['page_id']) ) ? $_GET['page_id'] : '1';
	if($page_id == '0')
		$page_id = '1';
	$limit_row = ($page_id-1)*$limit_rows;
	
	$limit_sql = " LIMIT ".$limit_row.", ".$limit_rows." ";
	$sql = "SELECT * FROM estimate_form_spam ".$where_sql." ORDER BY id desc ".$limit_sql;	

	$res = mysql_db_query(DB, $sql);

	echo "<table border='1' cellpadding='5' style='border-collapse:collapse;'>";
	while($spam_lead_data = mysql_fetch_array($res)){
		echo "<tr>";
		echo "<td>".$spam_lead_data['phone']."</td>";	
		echo "<td>".$spam_lead_data['email']."</td>";
		echo "<td>".$spam_lead_data['name']."</td>";
		echo "</tr>";
	}
	echo "</table>";
	
	echo "<div>סך הכל ".$num_rows." בקשות</div>";

						
	if( $num_rows > $limit_rows ){//$limit_rows $num_rows
		echo "<div>";		
			$z = 0;			
			for($i=1 ; ($i*$limit_rows) < $num_rows ; $i++)
			{				
				$pz = $z+1;			
						if( $i == $_GET['page_id'] )
							$classi = "<strong style=\"color:#000000\">".$pz."</strong>&nbsp;&nbsp;";
						else
							$classi = "<a href='index.php?main=anf&gf=spam_contact_list&page_id=".$i."&sesid=".SESID."' class='maintext'>".$pz."</a>&nbsp;&nbsp;";			
						echo $classi;		
						$z = $z + 1;		
						if( $z%35 == 0 )
							echo "<br>";
			}
		echo "</div>";
	}		 
}