<?php
		$curlSend = curl_init(); 
		
		curl_setopt($curlSend, CURLOPT_URL, "https://ilbiz.co.il/site-admin/crons/test.php?name=omykobkob&phone=12314444123"); 
		curl_setopt($curlSend, CURLOPT_RETURNTRANSFER, 1); 
		
		$curlResult = curl_exec ($curlSend); 
		curl_close ($curlSend); 
		var_dump($curlResult);
		
?>