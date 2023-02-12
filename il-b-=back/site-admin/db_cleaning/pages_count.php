<?php

require('../../global_func/vars.php');


	$sql = "SELECT * FROM users WHERE unk NOT IN(SELECT unk FROM users_to_delete)";
	$res = mysql_db_query(DB,$sql);

	$c = 0;
	$unk_list = "";

	while( $data = mysql_fetch_array($res) ){
		if($data['domain'] == ""){
			continue;
		}
		echo "<h4>".$data['domain'];
		$pages_sql = "SELECT id,type,name FROM content_pages WHERE unk = '".$data['unk']."' AND deleted ='1'";
		$pages_res = mysql_db_query(DB,$pages_sql);
		$counter = 0;
		while( $page_data = mysql_fetch_array($pages_res) ){
			$counter++;
			/*
			if($page_data['type'] == 'text'){
				
				echo "<b style='color:blue;'>דף הבית";
			}
			
			echo $page_data['name'];
			if($page_data['type'] == 'text'){
				echo "</b>";
			}
			if($page_data['name'] == '' && $page_data['type'] !='text'){
				echo "<b style='color:red;'>".$page_data['type']."</b>";
			}
			echo "<br/>";
			*/
			
		}
		echo ":".$counter."<br/>"."</h4>";;
	}



exit();