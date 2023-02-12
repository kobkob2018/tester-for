<?php
function user_cat_settings()
{
	$sql = "SELECT id,name FROM users WHERE unk = '".$_REQUEST['unk']."'";
	$res = mysql_db_query(DB,$sql);
	$data_id = mysql_fetch_array($res);	
	$sql = "SELECT cat_name FROM biz_categories WHERE id = '".$_REQUEST['catId']."'";
	$res = mysql_db_query(DB,$sql);
	$data_cat = mysql_fetch_array($res);	
	if((!isset($_REQUEST['catId']) || $_REQUEST['catId'] == "") && (!isset($_REQUEST['phone']) || $_REQUEST['phone'] == "")){
		echo "<h3>לא נבחרה קטגוריה</h3>";
		return;
	}
	ob_start();	
	if(isset($_REQUEST['catId'])){
		echo "<div style='float:right; padding:20px;border:1px solid black;margin-left:50px;'>";
			
			if($_REQUEST['catId'] != '0'){
				user_cat_city_settings($data_id);
			}
			else{
				user_city_settings($data_id);
			}
			
		echo "</div>";
		echo "<div style='float:right; padding:20px;border:1px solid black;'>";
			user_cat_api_settings($data_id);
		echo "</div>";
	}
	if(isset($_REQUEST['phone'])){
		echo "<div style='float:right; padding:20px;border:1px solid black;'>";
			user_phone_api_settings($data_id);
		echo "</div>";
		echo "<div style='float:right; padding:20px;border:1px solid black;'>";
			user_phone_leads_refund_reasons($data_id);
		echo "</div>";		
	}	
	$content = ob_get_clean();
	echo "<table class=\"maintext\">";
		echo "<tr>";
			echo "<td colspan=2><a href=\"?main=user_profile&unk=".$_REQUEST['unk']."&record_id=".$_REQUEST['record_id']."&sesid=".SESID."\" class=\"maintext\">חזרה לעדכון</a></td>";
		echo "</tr>";
		echo "<tr>";
			echo "<td colspan=2><a href=\"?main=portal_settings&unk=".$_REQUEST['unk']."&record_id=".$_REQUEST['record_id']."&sesid=".SESID."\" class=\"maintext\">חזרה להגדרות הפורטל</a></td>";
		echo "</tr>";
		echo "<tr>";
			echo "<td colspan=2><h3>".$data_cat['cat_name']."</h3></td>";
		echo "</tr>";
	echo "</table>";
	echo $content;
}

function user_cat_city_settings($data_id)
{
	if(isset($_REQUEST['save_cities']) && $_REQUEST['save_cities'] == "1"){
		//remove all previos user_cat_city selections from db, for this user in this cat
		$sql = "DELETE FROM user_cat_city WHERE user_id = ".$data_id['id']." AND cat_id = ".$_REQUEST['catId'];
		$res = mysql_db_query(DB,$sql);		
		//add all new selected
		foreach( $_POST['cities'] as $key => $val )
		{
			$sql = "INSERT INTO user_cat_city ( user_id , city_id, cat_id ) VALUES ( '".$data_id['id']."' , '".$val."', '".$_REQUEST['catId']."' )";
			$resI = mysql_db_query(DB,$sql);
		}		
		//remove all user_cat_city selections for categories that user not belong to them
		$sql = "DELETE FROM user_cat_city WHERE user_id = '".$data_id['id']."' AND cat_id NOT IN(select cat_id from user_cat where user_id = '".$data_id['id']."' )";
		$resD = mysql_db_query(DB,$sql);
		
		echo "<h4 style='color:green'>השינויים נשמרו בהצלחה</h4>";		
	}		
	
		echo "<table class=\"maintext\">";			
			echo "<tr>";
				echo "<td>";
				
				echo "		<h3>הוספת ערים ללקוח בקטגוריה</h3>";
				
					echo "<form action='index.php' name='formi' method='post' style='padding:0; margin:0;'>";
					echo "<input type='hidden' name='main' value='user_cat_settings'>";
					echo "<input type='hidden' name='sesid' value='".SESID."'>";
					echo "<input type='hidden' name='unk' value='".$_REQUEST['unk']."'>";
					echo "<input type='hidden' name='catId' value='".$_REQUEST['catId']."'>";
					echo "<input type='hidden' name='save_cities' value='1'>";
					echo "<table class='maintext'>";

						
						
						echo "<tr>";
							echo "<td></td>";
							echo "<td><input type='submit' value='שמור' class='input_style' style='width:100px;'></td>";
						echo "</tr>";

						$sql = "SELECT id, name FROM newCities WHERE father=0";
						$resCity1 = mysql_db_query(DB, $sql);
						
						echo "<tr>";
							echo "<td colspan=2>";
								echo "<table class='maintext'>";
									
									while( $dataCity1 = mysql_fetch_array($resCity1) )
									{
										$sql = "SELECT city_id FROM user_cat_city WHERE user_id = '".$data_id['id']."' AND city_id = '".$dataCity1['id']."'  AND cat_id = '".$_REQUEST['catId']."' ";
										$resCC1 = mysql_db_query(DB, $sql);
										$dataCC1 = mysql_fetch_array($resCC1);
										
										$checked = ( $dataCC1['city_id'] == $dataCity1['id'] ) ? "checked" : "";
										
										echo "<tr>";
											echo "<td><input type='checkbox' name='cities[]' value='".$dataCity1['id']."' ".$checked."></td>";
											echo "<td width=10></td>";
											echo "<td>".stripslashes($dataCity1['name'])."</td>";
										echo "</tr>";
										
										$sql = "SELECT id, name FROM newCities WHERE father=".$dataCity1['id']."";
										$resCity2 = mysql_db_query(DB, $sql);
										
										while( $dataCity2 = mysql_fetch_array($resCity2) )
										{
											$sql = "SELECT city_id FROM user_cat_city WHERE user_id = '".$data_id['id']."' AND city_id = '".$dataCity2['id']."'  AND cat_id = '".$_REQUEST['catId']."' ";

											$resCC2 = mysql_db_query(DB, $sql);
											$dataCC2 = mysql_fetch_array($resCC2);
																		
											$checked2 = ( $dataCC2['city_id'] == $dataCity2['id'] ) ? "checked" : "";
											
											echo "<tr>";
												echo "<td style='padding-right:20px;'><input type='checkbox' name='cities[]' value='".$dataCity2['id']."' ".$checked2."></td>";
												echo "<td width=10></td>";
												echo "<td >".stripslashes($dataCity2['name'])."</td>";
											echo "</tr>";
										}
									}
								
								echo "</table>";
							echo "</td>";
						echo "</tr>";
						
						
						
					echo "</table>";
					echo "</form>";
				echo "</td>";
				
				
			echo "</tr>";
		echo "</table>";
}

function user_city_settings($data_id)
{
	if(isset($_REQUEST['save_cities']) && $_REQUEST['save_cities'] == "1"){
		//remove all previos user_cat_city selections from db, for this user in this cat
		$sql = "DELETE FROM user_lead_cities WHERE user_id = ".$data_id['id'];
		$res = mysql_db_query(DB,$sql);		
		//add all new selected
		foreach( $_POST['cities'] as $key => $val )
		{
			$sql = "INSERT INTO user_lead_cities ( user_id , city_id) VALUES ( '".$data_id['id']."' , '".$val."')";
			$resI = mysql_db_query(DB,$sql);
		}		
		
		echo "<h4 style='color:green'>השינויים נשמרו בהצלחה</h4>";		
	}		
	
		echo "<table class=\"maintext\">";			
			echo "<tr>";
				echo "<td>";
				
				echo "<h3>בחירת ערים של הלקוח לכל הקטגוריות</h3>";
				
					echo "<form action='index.php' name='formi' method='post' style='padding:0; margin:0;'>";
					echo "<input type='hidden' name='main' value='user_cat_settings'>";
					echo "<input type='hidden' name='sesid' value='".SESID."'>";
					echo "<input type='hidden' name='unk' value='".$_REQUEST['unk']."'>";
					echo "<input type='hidden' name='catId' value='".$_REQUEST['catId']."'>";
					echo "<input type='hidden' name='save_cities' value='1'>";
					echo "<table class='maintext'>";

						
						
						echo "<tr>";
							echo "<td></td>";
							echo "<td><input type='submit' value='שמור' class='input_style' style='width:100px;'></td>";
						echo "</tr>";

						$sql = "SELECT id, name FROM newCities WHERE father=0";
						$resCity1 = mysql_db_query(DB, $sql);
						
						echo "<tr>";
							echo "<td colspan=2>";
								echo "<table class='maintext'>";
									
									while( $dataCity1 = mysql_fetch_array($resCity1) )
									{
										$sql = "SELECT city_id FROM user_lead_cities WHERE user_id = '".$data_id['id']."' AND city_id = '".$dataCity1['id']."'";
										$resCC1 = mysql_db_query(DB, $sql);
										$dataCC1 = mysql_fetch_array($resCC1);
										
										$checked = ( $dataCC1['city_id'] == $dataCity1['id'] ) ? "checked" : "";
										
										echo "<tr>";
											echo "<td><input type='checkbox' name='cities[]' value='".$dataCity1['id']."' ".$checked."></td>";
											echo "<td width=10></td>";
											echo "<td>".stripslashes($dataCity1['name'])."</td>";
										echo "</tr>";
										
										$sql = "SELECT id, name FROM newCities WHERE father=".$dataCity1['id']."";
										$resCity2 = mysql_db_query(DB, $sql);
										
										while( $dataCity2 = mysql_fetch_array($resCity2) )
										{
											$sql = "SELECT city_id FROM user_lead_cities WHERE user_id = '".$data_id['id']."' AND city_id = '".$dataCity2['id']."'";

											$resCC2 = mysql_db_query(DB, $sql);
											$dataCC2 = mysql_fetch_array($resCC2);
																		
											$checked2 = ( $dataCC2['city_id'] == $dataCity2['id'] ) ? "checked" : "";
											
											echo "<tr>";
												echo "<td style='padding-right:20px;'><input type='checkbox' name='cities[]' value='".$dataCity2['id']."' ".$checked2."></td>";
												echo "<td width=10></td>";
												echo "<td >".stripslashes($dataCity2['name'])."</td>";
											echo "</tr>";
										}
									}
								
								echo "</table>";
							echo "</td>";
						echo "</tr>";
						
						
						
					echo "</table>";
					echo "</form>";
				echo "</td>";
				
				
			echo "</tr>";
		echo "</table>";
}

function user_cat_api_settings($data_id)
{
	if(isset($_REQUEST['save_apis']) && $_REQUEST['save_apis'] == "1"){
		//remove all previos user_cat_city selections from db, for this user in this cat
		$sql = "DELETE FROM user_cat_api WHERE user_id = ".$data_id['id']." AND cat_id = ".$_REQUEST['catId'];
		$res = mysql_db_query(DB,$sql);		
		//add all new selected
		foreach( $_POST['apis'] as $key => $val )
		{
			$val = str_replace("'","''",$val);
			if($val!=""){
				$sql = "INSERT INTO user_cat_api ( user_id , api , cat_id ) VALUES ( '".$data_id['id']."' , '".$val."', '".$_REQUEST['catId']."' )";
				$resI = mysql_db_query(DB,$sql);
			}
		}		
		//remove all user_cat_api selections for categories that user not belong to them
		$sql = "DELETE FROM user_cat_api WHERE user_id = '".$data_id['id']."' AND cat_id NOT IN(0,select cat_id from user_cat where user_id = '".$data_id['id']."' )";
		$resD = mysql_db_query(DB,$sql);
		
		echo "<h4 style='color:green'>השינויים נשמרו בהצלחה</h4>";		
	}	
	$user_cat_apis = array();
	$max_api_id = 0;
	$sql = "SELECT * FROM user_cat_api WHERE user_id = ".$data_id['id']." AND cat_id = ".$_REQUEST['catId']."";
	$res = mysql_db_query(DB, $sql);
	while($api_data = mysql_fetch_array($res)){
		$api_data['api'] = str_replace("'","&quot;",$api_data['api']);
		$user_cat_apis[$api_data['id']] = $api_data;
		if($max_api_id < $api_data['id']){
			$max_api_id = $api_data['id'];
		}
	}					
	$api_params = array(
		"category"=>"שם הקטגוריה",				
		"name" => "שם מלא" , 
		"city" => "עיר" ,
		"to_city" => "לעיר (בהסעות)",
		"passengers" => "מספר נוסעים" , 
		"email" => "אימייל" , 
		"phone" => "טלפון" , 
		"note" => "הערות(כולל שדות מיוחדים)" , 
		"referer" => "עמוד הפנייה, כתובת URL" ,
		"statistic_id" => "מספר סטטיסטי של צפייה בעמוד" ,
		"cat_f" => "מספר קטגוריית אב" , 
		"cat_s" => "מספר קטגויית בת" , 
		"cat_spec" => "מספר קטגוריית התמחות" ,
		"cat_f_name" => "שם קטגוריית אב" , 
		"cat_s_name" => "שם קטגוריית בת" , 
		"cat_spec_name" => "שם קטגוריית התמחות" ,		
	);		
	echo "		<h3>הוספת API בעת שליחת ליד ללקוח בקטגוריה</h3>";
	echo "<a href='javascript://' onClick='open_api_param_list(this);' class='api_param_list_door closed'><span class='open_str'>סגור</span><span class='closed_str'>הצג אפשרויות להחלפה אוטומטית</span></a>";
	echo "
		<script type='text/javascript'>
			function open_api_param_list(el_id){
				jQuery(function($){
					if($(el_id).hasClass('closed')){
						$(el_id).removeClass('closed').addClass('open');
						$('#api_param_list').show();
					}
					else{
						$(el_id).removeClass('open').addClass('closed');
						$('#api_param_list').hide();
					}
				});
			}
		</script>
		<style type='text/css'>
			.api_param_list_door.closed .open_str{display:none;}
			.api_param_list_door.open .closed_str{display:none;}
		</style>
	";
	echo "<div id='api_param_list' style='display:none;padding-bottom:10px;'>";
		echo "<h5>שדות להחלפה אוטומטית(יש לשים בתוך סוגריים מסולסליםת דוגמה: {note}  ):</h5>";
		echo "<table border='1' style='border-collapse:collapse;'>";
			echo "<tr>";
				echo "<th>שם השדה</th>";
				echo "<th>מה לשים</th>";
			echo "</tr>";
		
			foreach($api_params as $param=>$param_name){
				echo "<tr>";
					echo "<th>$param_name</th>";
					echo "<th>{".$param."}</th>";
				echo "</tr>";			
			}
		echo "</table>";
	echo "</div>";
		echo "<form action='index.php' name='formi' method='post' style='padding:0; margin:0;'>";
		echo "<input type='hidden' name='main' value='user_cat_settings'>";
		echo "<input type='hidden' name='sesid' value='".SESID."'>";
		echo "<input type='hidden' name='unk' value='".$_REQUEST['unk']."'>";
		echo "<input type='hidden' name='catId' value='".$_REQUEST['catId']."'>";
		echo "<input type='hidden' name='save_apis' value='1'>";
		echo "<table cellpadding='7' border='1' id='apis_table' style='border-collapse: collapse;'>";
			echo "<tr class='user_cat_api' id='user_cat_api_".$key."'>";
				echo "<th class='api_text'>";
					echo "כתובת הAPI";
				echo "</th>";
				echo "<th class='api_delete'>";
					echo "הסרה";
				echo "</th>";				
			echo "</tr>";
			echo "<tr><td>";
				echo "<a href='javascript://' onClick='api_add();' id='add_api_a'>לחץ כאן להוספת API</a>";
			echo "</td><td></td></tr>";				
			foreach($user_cat_apis as $key=>$user_cat_api){
				echo "<tr class='user_cat_api' id='user_cat_api_".$key."'>";
					echo "<td class='api_text'>";
						echo "<input type='text' name='apis[]' value='".$user_cat_api['api']."' />";
					echo "</td>";
					echo "<td class='api_delete'>";
						echo "<a href='javascript://' onClick='api_delete(".$key.");' >הסר</a>";
					echo "</td>";				
				echo "</tr>";
			}

		echo "</table>";
		echo "<div>";
			echo "<input type='submit' id='apis_submit' value='לחץ כאן לשמירה' />";
		echo "</div>";	
		echo "</form>";

		echo "<table id='api_mockup_table' style='display:none;'>";
			echo "<tr class='user_cat_api' id='user_cat_api_{{max_api_id}}'>";
				echo "<td class='api_text'>";
					echo "<input type='text' name='apis[]' />";
				echo "</td>";
				echo "<td class='api_delete'>";
					echo "<a href='javascript://' onClick='api_delete({{max_api_id}});' >הסר</a>";
				echo "</td>";
			echo "</tr>";
		echo "</table>";
	
		echo "
			<script type='text/javascript'>
				var max_api_id = ".$max_api_id.";
				function api_delete(api_key){
					jQuery(function($){
						$('#user_cat_api_'+api_key).remove();
					});
				}
				function api_add(){
					jQuery(function($){
						max_api_id++;
						var api_html = $('#api_mockup_table').html().replace('{{max_api_id}}',max_api_id).replace('{{max_api_id}}',max_api_id);
						$('#apis_table').append(api_html);
					});
				}
			</script>
			<style type='text/css'>
				#add_api_a{
					display: block;
					background: gray;
					padding: 10px;
					border: 5px outset #efd1d1;
					margin-top: 5px;
					color: white;
					text-decoration: none;
					border-radius: 10px;
					box-shadow: 4px 4px 6px #443737;
					font-size: 20px;
					text-align: center;	
					text-shadow: 1px 1px 1px black;		
				}
				#apis_submit{
					display: block;
					background: #9fa098;
					padding: 10px;
					border: 5px outset #7f7c7c;
					margin-top: 5px;
					color: #231212;
					text-decoration: none;
					border-radius: 10px;
					box-shadow: 4px 4px 6px #b79191;
					font-size: 20px;
					text-align: center;
					margin: 20px auto;
					text-shadow: 1px 1px 1px white;					
				}
				#apis_submit:hover{
					background: #a4a99e;
					border: 5px outset #7f7c7c;
					color: #261515;
					box-shadow: 4px 4px 12px #b99393;
					font-size: 21px;
				}				
				.api_text{width:400px;}
				.api_text input{
					width: 395px;
					padding: 6px;
					border-radius: 5px;
					border-color: #826b6b;
					direction:ltr;
					text-align:left;
				}
			</style>
		";
}


function user_phone_api_settings($data_id)
{
	if(isset($_REQUEST['save_apis']) && $_REQUEST['save_apis'] == "1"){
		//remove all previos user_cat_city selections from db, for this user in this cat
		$sql = "DELETE FROM user_phone_api WHERE user_id = ".$data_id['id']." AND phone = ".$_REQUEST['phone'];
		$res = mysql_db_query(DB,$sql);		
		//add all new selected
		foreach( $_POST['apis'] as $key => $val )
		{
			$val = str_replace("'","''",$val);
			if($val!=""){
				$sql = "INSERT INTO user_phone_api ( user_id , api , phone ) VALUES ( '".$data_id['id']."' , '".$val."', '".$_REQUEST['phone']."' )";
				$resI = mysql_db_query(DB,$sql);
			}
		}		
		//remove all user_phone_api selections for categories that user not belong to them
		$sql = "DELETE FROM user_phone_api WHERE user_id = '".$data_id['id']."' AND phone NOT IN(0,select phone from users_phones where unk = '".$_REQUEST['unk']."' )";
		$resD = mysql_db_query(DB,$sql);
		
		echo "<h4 style='color:green'>השינויים נשמרו בהצלחה</h4>";		
	}	
	$user_cat_apis = array();
	$max_api_id = 0;
	$sql = "SELECT * FROM user_phone_api WHERE user_id = ".$data_id['id']." AND phone = ".$_REQUEST['phone']."";
	$res = mysql_db_query(DB, $sql);
	while($api_data = mysql_fetch_array($res)){
		$api_data['api'] = str_replace("'","&quot;",$api_data['api']);
		$user_cat_apis[$api_data['id']] = $api_data;
		if($max_api_id < $api_data['id']){
			$max_api_id = $api_data['id'];
		}
	}					
	$phone_str = $_REQUEST['phone'];
	if($_REQUEST['phone'] == '0'){
		$phone_str = "(כל הטלפונים)";
	}
	echo "		<h3>הוספת API לאחר התקשרות ללקוח בטלפון $phone_str</h3>";
	
		echo "<form action='index.php' name='formi' method='post' style='padding:0; margin:0;'>";
		echo "<input type='hidden' name='main' value='user_cat_settings'>";
		echo "<input type='hidden' name='sesid' value='".SESID."'>";
		echo "<input type='hidden' name='unk' value='".$_REQUEST['unk']."'>";
		echo "<input type='hidden' name='phone' value='".$_REQUEST['phone']."'>";
		echo "<input type='hidden' name='save_apis' value='1'>";
		echo "<table cellpadding='7' border='1' id='apis_table' style='border-collapse: collapse;'>";
			echo "<tr class='user_cat_api' id='user_cat_api_".$key."'>";
				echo "<th class='api_text'>";
					echo "כתובת הAPI";
				echo "</th>";
				echo "<th class='api_delete'>";
					echo "הסרה";
				echo "</th>";				
			echo "</tr>";
			echo "<tr><td>";
				echo "<a href='javascript://' onClick='api_add();' id='add_api_a'>לחץ כאן להוספת API</a>";
			echo "</td><td></td></tr>";				
			foreach($user_cat_apis as $key=>$user_cat_api){
				echo "<tr class='user_cat_api' id='user_cat_api_".$key."'>";
					echo "<td class='api_text'>";
						echo "<input type='text' name='apis[]' value='".$user_cat_api['api']."' />";
					echo "</td>";
					echo "<td class='api_delete'>";
						echo "<a href='javascript://' onClick='api_delete(".$key.");' >הסר</a>";
					echo "</td>";				
				echo "</tr>";
			}

		echo "</table>";
		echo "<div>";
			echo "<input type='submit' id='apis_submit' value='לחץ כאן לשמירה' />";
		echo "</div>";	
		echo "</form>";

		echo "<table id='api_mockup_table' style='display:none;'>";
			echo "<tr class='user_cat_api' id='user_cat_api_{{max_api_id}}'>";
				echo "<td class='api_text'>";
					echo "<input type='text' name='apis[]' />";
				echo "</td>";
				echo "<td class='api_delete'>";
					echo "<a href='javascript://' onClick='api_delete({{max_api_id}});' >הסר</a>";
				echo "</td>";
			echo "</tr>";
		echo "</table>";
	
		echo "
			<script type='text/javascript'>
				var max_api_id = ".$max_api_id.";
				function api_delete(api_key){
					jQuery(function($){
						$('#user_cat_api_'+api_key).remove();
					});
				}
				function api_add(){
					jQuery(function($){
						max_api_id++;
						var api_html = $('#api_mockup_table').html().replace('{{max_api_id}}',max_api_id).replace('{{max_api_id}}',max_api_id);
						$('#apis_table').append(api_html);
					});
				}
			</script>
			<style type='text/css'>
				#add_api_a{
					display: block;
					background: gray;
					padding: 10px;
					border: 5px outset #efd1d1;
					margin-top: 5px;
					color: white;
					text-decoration: none;
					border-radius: 10px;
					box-shadow: 4px 4px 6px #443737;
					font-size: 20px;
					text-align: center;	
					text-shadow: 1px 1px 1px black;		
				}
				#apis_submit{
					display: block;
					background: #9fa098;
					padding: 10px;
					border: 5px outset #7f7c7c;
					margin-top: 5px;
					color: #231212;
					text-decoration: none;
					border-radius: 10px;
					box-shadow: 4px 4px 6px #b79191;
					font-size: 20px;
					text-align: center;
					margin: 20px auto;
					text-shadow: 1px 1px 1px white;					
				}
				#apis_submit:hover{
					background: #a4a99e;
					border: 5px outset #7f7c7c;
					color: #261515;
					box-shadow: 4px 4px 12px #b99393;
					font-size: 21px;
				}				
				.api_text{width:400px;}
				.api_text input{
					width: 395px;
					padding: 6px;
					border-radius: 5px;
					border-color: #826b6b;
					direction:ltr;
					text-align:left;
				}
			</style>
		";
}
function user_phone_leads_refund_reasons($data_id){
	$user_id = $data_id['id'];
	if(isset($_REQUEST['delete_user_phone_lead_refund_reason'])){
		$reason_id = $_REQUEST['reason_id'];
		$sql = "DELETE FROM user_phone_leads_refund_reasons WHERE id = ".$_REQUEST['reason_id']."";
		$res = mysql_db_query(DB,$sql);
	}
	if(isset($_REQUEST['add_user_phone_lead_refund_reason'])){
		$reason_title = $_REQUEST['reason_title'];
		
		$sql = "INSERT INTO user_phone_leads_refund_reasons(user_id,title) VALUES($user_id,'$reason_title')";
		$res = mysql_db_query(DB,$sql);
	}	
	$sql = "SELECT * FROM user_phone_leads_refund_reasons WHERE user_id = ".$user_id."";

	$res = mysql_db_query(DB,$sql);
	echo "<div style='float:left;'>";
		echo "<div>";
			echo "<h3>עריכת סיבות זיכוי ללידים טלפוניים(לכל מספרי הטלפון של הלקוח)</h3>";
			echo "<table style='border-collapse: collapse;' border='1' cellpadding='5'>";
					echo "
					<tr>
						<th>#</th>
						<th>כותרת</th>
						<th>מחיקה/הוספה</th>
					</tr>
					<tr>
						<th>
							חדש
						</th>
						<th>
							<form action='' method='POST'>
								<input type='hidden' name='add_user_phone_lead_refund_reason' value='1' />
								<input type='text' name='reason_title' />				
						</th>
						<th>
							<input type='submit' value='הוסף' style='width:100%;' />
							</form>						
						</th>
					</tr>
				";			
				while($reason_data = mysql_fetch_array($res)){
					echo "
					<tr>
						<td>".$reason_data['id']."</td>
						<td>".$reason_data['title']."</td>
						<td>
							<form action='' method='POST'>
								<input type='hidden' name='delete_user_phone_lead_refund_reason' value='1' />
								<input type='hidden' name='reason_id' value='".$reason_data['id']."' />
								<input type='submit' style='background:#ef9999;' value='מחק' />
							</form>
						</td>
					</tr>
				";
				}
			echo "</table>";
		echo "</div>";		
		global_phone_leads_refund_reasons();
	echo "</div>";	
	
	
}
function global_phone_leads_refund_reasons(){
	$user_id = '0';
	if(isset($_REQUEST['delete_global_phone_lead_refund_reason'])){
		$reason_id = $_REQUEST['reason_id'];
		$sql = "DELETE FROM user_phone_leads_refund_reasons WHERE id = ".$_REQUEST['reason_id']."";
		$res = mysql_db_query(DB,$sql);
	}
	if(isset($_REQUEST['add_global_phone_lead_refund_reason'])){
		$reason_title = $_REQUEST['reason_title'];
		
		$sql = "INSERT INTO user_phone_leads_refund_reasons(user_id,title) VALUES($user_id,'$reason_title')";
		$res = mysql_db_query(DB,$sql);
	}	
	$sql = "SELECT * FROM user_phone_leads_refund_reasons WHERE user_id = ".$user_id."";

	$res = mysql_db_query(DB,$sql);
	echo "<div style='margin-top:20px;'>";
		echo "<h3 onclick='show_all_customers_refund_reasons()'><span id='show_all_customers_refund_reasons_chere'>לחץ כאן ל- </span>עריכת סיבות זיכוי ללידים טלפוניים(לכל הלקוחות)</h3>";
		echo "<table style='border-collapse: collapse; display:none;' border='1' cellpadding='5' id='all_customers_refund_reasons_table'>";
				echo "
				<tr>
					<th>#</th>
					<th>כותרת</th>
					<th>מחיקה/הוספה</th>
				</tr>
				<tr>
					<th>
						חדש
					</th>
					<th>
						<form action='' method='POST'>
							<input type='hidden' name='add_global_phone_lead_refund_reason' value='1' />
							<input type='text' name='reason_title' />				
					</th>
					<th>
						<input type='submit' value='הוסף' style='width:100%;' />
						</form>						
					</th>
				</tr>
			";			
			while($reason_data = mysql_fetch_array($res)){
				echo "
				<tr>
					<td>".$reason_data['id']."</td>
					<td>".$reason_data['title']."</td>
					<td>
						<form action='' method='POST'>
							<input type='hidden' name='delete_global_phone_lead_refund_reason' value='1' />
							<input type='hidden' name='reason_id' value='".$reason_data['id']."' />
							<input type='submit' style='background:#ef9999;' value='מחק' />
						</form>
					</td>
				</tr>
			";
			}
		echo "</table>";
	echo "</div>";	
	echo "
		<script type='text/javascript'>
			function show_all_customers_refund_reasons(){
				var constr = 'שים לב. אזור עריכה זה משפיע על סיבות הזיכוי של כל הלקוחות ולא רק של הלקוח הנוכחי. בשביל לערוך סיבות לזיכוי בשביל הלקוח הנוכחי בלבד, השתמש בטופס שמעל אזור זה. האם ברצונך לערוך סיבות זיכוי לכל הלקוחות?';
				if(confirm(constr)){
					jQuery('#all_customers_refund_reasons_table').show();
					jQuery('#show_all_customers_refund_reasons_chere').hide();
					
				}
			}
		</script>
	";
	
}
?>