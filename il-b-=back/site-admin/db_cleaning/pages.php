<?php

require('../../global_func/vars.php');


	$sql = "SELECT * FROM users WHERE unk NOT IN(SELECT unk FROM users_to_delete)";
	$res = mysql_db_query(DB,$sql);

	$c = 0;
	$unk_list = "";

	while( $data = mysql_fetch_array($res) ){
		echo "<h4>".$data['domain']."(<small>".$data['name']."</small>)"."</h4>";
		$pages_sql = "SELECT id,type,name FROM content_pages WHERE unk = '".$data['unk']."' AND deleted !='1'";
		$pages_res = mysql_db_query(DB,$pages_sql);
		while( $page_data = mysql_fetch_array($pages_res) ){
			if($page_data['type'] == 'text'){
				
				echo "<b style='color:blue;'>�� ����";
			}
			
			echo $page_data['name'];
			if($page_data['type'] == 'text'){
				echo "</b>";
			}
			if($page_data['name'] == '' && $page_data['type'] !='text'){
				echo "<b style='color:red;'>".$page_data['type']."</b>";
			}
			echo "<br/>";
		}
	}



exit();