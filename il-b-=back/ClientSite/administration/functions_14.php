<?php

function user_realty_img()
{
	$sql = "SELECT domain FROM users WHERE unk = '".UNK."' ";
	$res = mysql_db_query(DB,$sql);
	$userData = mysql_fetch_array($res);
	
	$realty_id = (int)$_GET['realty_id'];
	$server_path = "/home/ilan123/domains/".$userData['domain']."/public_html/realty_image/".$realty_id."/";
	
	echo "<form action=\"index.php\" name=\"user_realty_img_form\" method=\"POST\" enctype=\"multipart/form-data\" style='padding:0; margin:0;'>";
	echo "<input type=\"hidden\" name=\"main\" value=\"user_realty_img_Prosses\">";
	echo "<input type=\"hidden\" name=\"unk\" value=\"".UNK."\">";
	echo "<input type=\"hidden\" name=\"sesid\" value=\"".SESID."\">";
	echo "<input type=\"hidden\" name=\"realty_id\" value=\"".$realty_id."\">";
	echo "<input type=\"hidden\" name=\"type\" value=\"".$_GET['type']."\">";
	
	echo "<table border=\"0\" cellspacing=\"0\" cellpadding=\"0\" class=\"maintext\" width='100%'>";
	
	for( $img=1 ; $img <= 9 ; $img++ )
	{
		$view_file = "";
		$del_files = "";
		if( is_dir($server_path) )
		{
			$img_L = $img."-L";
			foreach (glob($server_path.$img_L."*") as $filename) {
				$explo = explode("/".$realty_id."/",$filename);
				$exte = substr($explo[1],(strpos($explo[1],".")+1));
			}
			
			$temp_path = $server_path.$img_L.".".$exte;
			
			if( file_exists($temp_path) && !is_dir($temp_path) )
			{
				$view_file = "<a href='http://".$userData['domain']."/realty_image/".$realty_id."/".$img_L.".".$exte."' class='maintext' target='_blank'>צפה בתמונה</a>";
				$del_files = "<a href='index.php?main=del_user_realty_img&realty_id=".$realty_id."&type=".$_GET['type']."&img=".$img."&unk=".UNK."&sesid=".SESID."' class='maintext' onclick='return can_i_del()'>מחק תמונה</a>";
			}
			
		}
		
		
		echo "<tr>";
			echo "<td>תמונה מספר ".$img."</td>";
			echo "<td width='10'></td>";
			echo "<td><input type='file' name='realty_img_".$img."' class='input_style'></td>";
			
			echo "<td>".$view_file."</td>";
			echo "<td width='10'></td>";
			echo "<td>".$del_files."</td>";
			
		echo "</tr>";
		
		echo "<tr><td colsapn=6  height=10></td></tr>";
	}
	
	
	echo "<tr>";
		echo "<td></td>";
		echo "<td width='10'></td>";
		echo "<td><input type='submit' value='עדכן' class='submit_style'></td>";
	echo "</tr>";
		
	echo "</table>";
	
	echo "</form>";
}

function user_realty_img_Prosses()
{
	$sql = "SELECT domain FROM users WHERE unk = '".UNK."' ";
	$res = mysql_db_query(DB,$sql);
	$userData = mysql_fetch_array($res);
	
	$realty_id = (int)$_POST['realty_id'];
	
	$server_path = "/home/ilan123/domains/".$userData['domain']."/public_html/realty_image/";
	
	if($_FILES)
	{
		GlobalFunctions::create_dir_s("/home/ilan123/domains/".$userData['domain']."/public_html/","realty_image");
		
		GlobalFunctions::create_dir_s($server_path,$realty_id);
		
		$server_path .= $realty_id."/";
		
		for($temp=1 ; $temp<=9 ; $temp++)
		{
			$temp_name = "realty_img_".$temp;
			
			$field_name_mame = $_FILES[$temp_name]['name'];
			
			if($_FILES[$temp_name]['type'] == "image/jpeg" || $_FILES[$temp_name]['type'] == "image/gif" || $_FILES[$temp_name]['type'] == "image/pjpeg")
			{
				$exte = substr($field_name_mame,(strpos($field_name_mame,".")+1));
				
				$logo_name_small = $temp."-S.".$exte;
				$logo_name_large = $temp."-L.".$exte;
				$logo_name_ex = $temp."-EX.".$exte;
				
				$abpath_temp_unlink_small = $server_path.$logo_name_small;
				if( file_exists($abpath_temp_unlink_small) && !is_dir($abpath_temp_unlink_small) )
					unlink($abpath_temp_unlink_small);
					
				$abpath_temp_unlink_large = $server_path.$logo_name_large;
				if( file_exists($abpath_temp_unlink_large) && !is_dir($abpath_temp_unlink_large) )
					unlink($abpath_temp_unlink_large);
				
				$abpath_temp_unlink_ex = $server_path.$logo_name_ex;
				if( file_exists($abpath_temp_unlink_ex) && !is_dir($abpath_temp_unlink_ex) )
					unlink($abpath_temp_unlink_ex);
				
				
				GlobalFunctions::upload_file_to_server($temp_name , $logo_name_ex , $server_path , array("image") , array() , "2" , "copy");
				GlobalFunctions::upload_file_to_server($temp_name , $logo_name_large , $server_path , array("image") , array() , "2" , "copy" );
				GlobalFunctions::upload_file_to_server($temp_name , $logo_name_small , $server_path );
				
				resize($logo_name_small, $server_path, "75","50");
				resize($logo_name_large, $server_path, "200","115");
				resize($logo_name_ex, $server_path, "650","500");
				
			}
			
		}
		
	}
	
	
	
	echo "<script>window.location.href='index.php?main=user_realty_img&type=".$_POST['type']."&realty_id=".$_POST['realty_id']."&type=&unk=".UNK."&sesid=".SESID."';</script>";
		exit;
}

function del_user_realty_img()
{
	$sql = "SELECT domain FROM users WHERE unk = '".UNK."' ";
	$res = mysql_db_query(DB,$sql);
	$userData = mysql_fetch_array($res);
	
	$realty_id = (int)$_GET['realty_id'];
	$server_path = "/home/ilan123/domains/".$userData['domain']."/public_html/realty_image/".$realty_id."/";
	
	if( !$realty_id > 0 )
		die('#1');
		
	if( is_dir($server_path) )
	{
		//if( $_GET['delDir'] == "1" )
			//unlink($server_path);
		//else
		//{
			foreach (glob($server_path.$_GET['img']."-*") as $filename)
			{
				unlink($filename);
			}
		//}
	}
	
	echo "<script>window.location.href='index.php?main=user_realty_img&type=".$_GET['type']."&realty_id=".$_GET['realty_id']."&type=&unk=".UNK."&sesid=".SESID."';</script>";
		exit;
}

function item_301_redirect(){
	if(UNK == $_REQUEST['unk']){
		if($_REQUEST['update_type'] == "insert"){
			$sql = "INSERT INTO site_301_redirections(unk,module,item_id,redirect_url) 
					VALUES('".$_REQUEST['unk']."','".$_REQUEST['module']."','".$_REQUEST['item_id']."','".$_REQUEST['redirect_url']."')";
		}
		else{
			$sql = "UPDATE site_301_redirections SET redirect_url = '".$_REQUEST['redirect_url']."' 
					 WHERE unk = '".$_REQUEST['unk']."'
					 AND module = '".$_REQUEST['module']."'
					 AND item_id = '".$_REQUEST['item_id']."' 
					";
		}
		$res = mysql_db_query(DB,$sql);
	}
	
	echo "<META HTTP-EQUIV=Refresh CONTENT=\"0; URL=".$_REQUEST['return_url']."\">";
	
}

function site_301_redirections(){
	echo "הטופס בבנייה";
	
}


function payments_list(){
	global $word;
	$sql = "SELECT id FROM users WHERE unk = '".UNK."' ";
	$res = mysql_db_query(DB,$sql);
	$userData = mysql_fetch_array($res);
	$userId = $userData['id'];
	$sql = "SELECT id,sumTotal,payDate,description,trans_id FROM ilbizPayByCCLog WHERE userId = $userId AND 	payGood = '2' ORDER BY payDate desc";
	$res = mysql_db_query(DB,$sql);
	echo "<table border='1' style='border-collapse: collapse;' width='100%' cellpadding='15' borderc>";
		echo "<tr>";
			echo "<th>".$word[LANG]['pay_description']."</th>";
			echo "<th>".$word[LANG]['pay_date']."</th>";
			echo "<th>".$word[LANG]['sum_total']."</th>";
			echo "<th></th>";
		echo "</tr>";
	while($paymentData = mysql_fetch_array($res)){
		echo "<tr>";
			echo "<td>".$paymentData['description']."</td>";
			echo "<td>".$paymentData['payDate']."</td>";
			echo "<td>".$paymentData['sumTotal']."</td>";
			echo "<td><a href=\"?main=payment_heshbonit&trans_id=".$paymentData['id']."&unk=".UNK."&sesid=".SESID."\" class=\"right_menu\">".$word[LANG]['show_heshbonit']."</a></td>";		
		echo "</tr>";
	}
	echo "</table>";
	
	
}

function payment_heshbonit(){
	global $word;
	$sql = "SELECT id FROM users WHERE unk = '".UNK."' ";
	$res = mysql_db_query(DB,$sql);
	$userData = mysql_fetch_array($res);
	$userId = $userData['id'];
	
	$pay_id = $_GET['trans_id'];
	$sql = "SELECT trans_id FROM ilbizPayByCCLog WHERE userId = $userId AND id = $pay_id ";
	echo "
		<script>
			function printContent(el){
				var restorepage = jQuery('body').html();
				var printcontent = jQuery('#' + el).clone();
				jQuery('body').empty().html(printcontent);
				window.print();
				jQuery('body').html(restorepage);
			}
		</script>
	
	";
	
	
	$res = mysql_db_query(DB,$sql);
	$paymentData = mysql_fetch_array($res);
	if(isset($paymentData['trans_id'])){
		$sql = "SELECT yaad_user, yaad_pass FROM main_settings WHERE id = 1";
		$res = mysql_db_query(DB,$sql);
		$data = mysql_fetch_array($res);
		$yaad_user = $data['yaad_user'];
		$yaad_pass = $data['yaad_pass'];
		$trans_id = $paymentData['trans_id'];
		$url = "https://icom.yaad.net/p/";
		$postData = "d=s&action=PrintHesh&TransId=$trans_id&type=HTML&Masof=4500019225&User=$yaad_user&Pass=$yaad_pass&HeshORCopy=True";

		$ch = curl_init();  
	 
		curl_setopt($ch,CURLOPT_URL,$url);
		curl_setopt($ch,CURLOPT_RETURNTRANSFER,true);
		curl_setopt($ch,CURLOPT_HEADER, false); 
		curl_setopt($ch, CURLOPT_POSTFIELDS, $postData);    
	 
		$output=curl_exec($ch);
	 
		curl_close($ch);	
		echo "<button id='print' onclick=\"printContent('heshbonit_to_print');\" >".$word[LANG]['click_here_to_print_heshbonit']."</button>";
		echo "<div id='heshbonit_to_print'>";
			echo(str_replace("<img","<img style='display:none;' ",$output));
		echo "</div>";	
	}
		
	
	
	
}