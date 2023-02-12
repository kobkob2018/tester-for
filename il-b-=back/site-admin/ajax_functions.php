<?php

header('Content-Type: text/html; charset=windows-1255');  

function select_banner($storge_type , $bannaer_id="" )
{
	$sql = "SELECT banner_name,banner_desc,id FROM net_clients_banners where deleted=0 AND type=".$storge_type." AND status=1";
	$res = mysql_db_query(DB ,$sql);
	
	echo "<table border=\"0\" cellspacing=\"0\" cellpadding=\"3\" class=\"maintext\">";
	
		while( $data = mysql_fetch_array($res) )
		{
			$bgColor = ( $bannaer_id == $data['id'] ) ? "E9D5FF" : "ffffff";
			
			echo "<tr>";
				echo "<td onclick='main(\"".SESID."\",\"select_site\",\"net_banners\",\"&storge_type=".$storge_type."&bannaer_id=".$data['id']."\")' style='cursor : pointer; background-color:#".$bgColor.";' onMouseover='this.style.backgroundColor=\"F4EAFF\";' onMouseout='this.style.backgroundColor=\"".$bgColor."\";'><b>".stripslashes($data['banner_name'])."</b><br>".stripslashes($data['banner_desc'])."</td>";
			echo "</tr>";
			echo "<tr><td height=5></td></tr>";
		}
		
	echo "</table>";
}

function select_site($storge_type , $bannaer_id)
{
	switch( $storge_type )
	{
		case "1" :			$qry_s = "have_ilbiz_net=1";			break;
		
		case "2" :
		case "3" :			$qry_s = "have_ilbiz_adv_net=1";			break;
	}
	
	$search_nameQ = ( $_GET['search_name'] != "" ) ? " AND name like '%".$_GET['search_name']."%' " : "";
	$search_domainQ = ( $_GET['search_domain'] != "" ) ? " AND domain like '%".$_GET['search_domain']."%' " : "";
	
	$sql = "SELECT name, domain, unk FROM users where deleted=0 AND status=0 AND ".$qry_s.$search_nameQ.$search_domainQ. " ORDER BY id";
	$res = mysql_db_query(DB ,$sql);
	
	echo "<table border=\"0\" cellspacing=\"0\" cellpadding=\"3\" class=\"maintext\">";
	
	echo "<form action='javascript:from_form(\"".SESID."\" , \"net_search_sites\" )' method='get' name='search_site_form'>";
	echo "<input type='hidden' name='storge_type' value='".$storge_type."'>";
	echo "<input type='hidden' name='bannaer_id' value='".$bannaer_id."'>";

	
	echo "<tr><td height=15 colspan=2></td></tr>";
	
			echo "<tr>";
				echo "<td width=10></td>";
				echo "<td>
					<table border=\"0\" cellspacing=\"0\" cellpadding=\"3\" class=\"maintext\">
						<tr>
							<td>חיפוש על פי שם עסק</td>
							<td width=10></td>
							<td><input type='text' name='search_name' value='".$_GET['search_name']."' class='input_style' style='width: 100px; '></td>
							<td width=30></td>
							<td>חיפוש על פי דומיין</td>
							<td width=10></td>
							<td><input type='text' name='search_domain' value='".$_GET['search_domain']."' class='input_style' style='width: 100px; '></td>
							<td width=10></td>
							<td><input type='submit' value='חפש!' class='input_style' style='width: 100px; '></td>
						</tr>
					</table>
				</td>";
			echo "</tr>";
			echo "<tr><td height=5 colspan=2></td></tr>";
			
	echo "</form>";
	
	
	echo "<tr><td height=15 colspan=2></td></tr>";
	
		
	echo "<tr>";
		echo "<td width=10></td>";
		echo "<td>
		<a href='javascript:checkAll()' class='maintext'>בחר הכל</a>
		&nbsp;&nbsp;&nbsp;&nbsp;
		<a href='javascript:checkNone()' class='maintext'>הסר הכל</a>
		</td>";
	echo "</tr>";
	echo "<tr><td height=10 colspan=2></td></tr>";
	
	
	echo "<form action='index.php' method='POST' name='select_sites_banner_form'>";
	echo "<input type='hidden' name='main' value='net_add_site_banners_DB'>";
	echo "<input type='hidden' name='storge_type' value='".$storge_type."'>";
	echo "<input type='hidden' name='bannaer_id' value='".$bannaer_id."'>";
	echo "<input type='hidden' name='sesid' value='".SESID."'>";
	
		while( $data = mysql_fetch_array($res) )
		{
			$sql2 = "SELECT COUNT(unk) as nums FROM net_client_belong_banners WHERE banner_id = '".$bannaer_id."' and unk = ".$data['unk']."";
			$res2 = mysql_db_query( DB , $sql2 );
			$check_green = mysql_fetch_array($res2);
			
			$green_bg = ( $check_green['nums'] == 1 ) ? "style='background-color: #D9D9FF;'" : "";
			
			echo "<tr>";
				echo "<td width=10></td>";
				echo "<td>
				";
					$sql2 = "SELECT COUNT(unk) as nums FROM net_client_belong_banners WHERE banner_id = '".$bannaer_id."' and unk = ".$data['unk']."";
					$res2 = mysql_db_query( DB , $sql2 );
					$check_green = mysql_fetch_array($res2);
					
					$green_bg = ( $check_green['nums'] == 1 ) ? "style='background-color: #D9D9FF;'" : "";
					echo "<table border=\"0\" cellspacing=\"0\" cellpadding=\"3\" class=\"maintext\" width='530'  ".$green_bg.">
						<tr>
							<td><label><input type='checkbox' name='cs[]' value='".$data['unk']."'> <b>".stripslashes($data['name'])."</b><br>".stripslashes($data['domain'])."</label></td>
							<td width=30></td>
							<td align=left>";
							if( $check_green['nums'] == 1 )
								echo "<div id='net_del_belong_banner_".$data['unk']."'><input type='button' value='מחק שיוך באנר'style='width: 100px;' class='input_style' onclick='net_del_belong_banner(\"".$bannaer_id."\" , \"".$data['unk']."\" , \"".SESID."\" )'></div>";
							echo "</td>
						</tr>
					</table>
					
				";
				
				echo "</td>";
				
			echo "</tr>";
			echo "<tr><td height=5 colspan=2></td></tr>";
		}
		
		echo "<tr>";
			echo "<td width=10></td>";
			echo "<td><input type='submit' value='אשר לאתרים המובחרים את הבאנר!' class='input_style' style='width: 200px;'></td>";
		echo "</tr>";
		
		echo "<tr><td height=5 colspan=2></td></tr>";
		
	echo "</form>";
	echo "</table>";
}

function createMysaveFinel()
{
	echo "<textarea cols=100 rows=40 dir=ltr>";
	
		echo "<form name=\"send_es_form\" method=\"POST\" action=\"http://www.mysave.co.il/s.php\">";
		echo "<input type=hidden name=\"S\" value='F".$_GET['cat']."S".$_GET['tatcat']."'>";
		echo "<input type=hidden name=\"cat_f\" value='".$_GET['cat']."'>";
		echo "<input type=hidden name=\"cat_s\" value='".$_GET['tatcat']."'>";
		echo "<input type=hidden name=\"M\" value='save_form_site'>";
				
					echo "<table style='font-family: arial; font-size: 12px; color: ".$_GET['color']."'>";
					
						$catIdButton = ( $_GET['tatcat'] != "" ) ? $_GET['tatcat'] : $_GET['cat'];
						$sql = "SELECT id, title FROM mysaveFormButton WHERE catId='".$catIdButton."' AND active=0 ORDER BY place LIMIT 3";
						$resButtons = mysql_db_query( DB, $sql );
						$buttonNums = mysql_num_rows($resButtons);
								
						if( $buttonNums > 0 )
						{
							echo "<tr>";
								echo "<td colspan=3>";
									$counter = 0;
									while( $data = mysql_fetch_array($resButtons) )
									{
										echo "<label><input type='checkbox' name='catButtons[".$data['id']."]' value='1'> ".stripslashes($data['title'])." </label> ";
										$counter++;
									}
								echo "</td>";
							echo "</tr>";
						}
								
						echo "<tr>";
							echo "<td>שם מלא:</td><td width=10></td><td><input type=text name=\"Fm_name\" style='font-family: arial; font-size: 12px; color: 000000; backround-color: #ffffff; border: 1px solid #000000; width: 150px;'></td>";
						echo "</tr>";
						echo "<tr>";
							echo "<td>טלפון:</td><td width=10></td><td><input type=text name=\"Fm_phone\" dir=ltr style='font-family: arial; font-size: 12px; color: 000000; backround-color: #ffffff; border: 1px solid #000000; width: 150px;'></td>";
						echo "</tr>";
						echo "<tr>";
							echo "<td>אימייל:</td><td width=10></td><td><input type=text name=\"Fm_email\" dir=ltr style='font-family: arial; font-size: 12px; color: 000000; backround-color: #ffffff; border: 1px solid #000000; width: 150px;'></td>";
						echo "</tr>";
						
						if( $_GET['city'] == "" )
						{
							$sql = "SELECT id, name FROM newCities WHERE father=0";
							$resAll = mysql_db_query(DB,$sql);
							
							echo "<tr>";
								echo "<td>עיר:</td><td width=10></td><td>";
								echo "<select name='Fm_city' style='font-family: arial; font-size: 12px; color: 000000; backround-color: #ffffff; border: 1px solid #000000; width: 150px;'>";
									
									while( $data = mysql_fetch_array($resAll) )
									{
										echo "<option value='".$data['id']."' style='color: #000000;'>".stripslashes($data['name'])."</option>";
										
										$sql = "SELECT id, name FROM newCities WHERE father=".$data['id']."";
										$resAll2 = mysql_db_query(DB,$sql);
										
										while( $data2 = mysql_fetch_array($resAll2) )
										{
											echo "<option value='".$data2['id']."'>".stripslashes($data2['name'])."</option>";
										}
										echo "<option value=''>-----------------------</option>";
									}
								echo "</select>";
								echo "</td>";
							echo "</tr>";
						}
						else
							echo "<input type='hidden' name='Fm_city' value='".$_GET['city']."'>";
						
						echo "<tr>";
							echo "<td>הערה/בקשה:</td><td width=10></td><td><input type=text name=\"Fm_note\" style='font-family: arial; font-size: 12px; color: 000000; backround-color: #ffffff; border: 1px solid #000000; width: 150px; height:50px;'></td>";
						echo "</tr>";
						
						/*echo "<tr>";
							echo "<td colspan=3>
								<table border=0 cellpadding=0 cellspacing=0>
									<tr>
										<td><input type='checkbox' name='taKn' value='1'></td>
										<td width=2></td>
										<td><a href='javascript:void(0)' onclick=\"window.open('http://www.ilbiz.co.il/taKn.php?fr=s','mywindow','width=350,height=150')\" style='font-family: arial; font-size: 12px; color: ".$_GET['color']."'>אני קראתי ומאשר את <u>התקנון</u></a></td>
									</tr>
								</table>
							</td>";
						echo "</tr>";*/
						echo "<tr>";
							echo "<td colspan=3 align=left><input style='font-family: arial; font-size: 12px; border: 1px solid #000000; width: 70px;' type='submit' value=\"שלח בקשה\"></td>";
						echo "</tr>";
					echo "</table>";
		
	echo "</form>";
	echo "</textarea>";
}


function tasks___addNewTask($id="")
{
	
	if( !empty($id) )
	{
		$sql = "SELECT * FROM workers_task WHERE id = '".$id."' ";
		$res = mysql_db_query(DB, $sql);
		$data = mysql_fetch_array($res);
		
	}
	
	$sql = "SELECT client_name , id FROM sites_owner WHERE ilbiz_worker=1 AND deleted=0 AND status=0 AND end_date >= NOW() ORDER BY client_name";
	$resOwner = mysql_db_query(DB, $sql);
	
	echo "<form action='javascript:addnewtaskDb()' method='post' name='addNewMission' id='addNewMission'>";
	echo "<input type='hidden' name='sesid' id='sesid' value='".SESID."'>";
	echo "<input type='hidden' name='main' id='main' value='addNewTaskDB'>";
	echo "<input type='hidden' name='recored_id' id='recored_id' value='".$id."'>";
	echo "<table border=\"0\" cellspacing=\"0\" cellpadding=\"0\" class=\"maintext\" width='700'>";
		echo "<tr><td colspan=7 height=15></td></tr>";			
		echo "<tr>";
			echo "<td>נושא:</td>";
			echo "<td width='10'></td>";
			echo "<td colspan=5><input type='text' name='subject' id='subject' value='".stripslashes($data['subject'])."' class='input_style' style='width:550px;'></td>";
		echo "</tr>";
		echo "<tr><td colspan=7 height=7></td></tr>";
		echo "<tr>";
		echo "<td>לטיפול:</td>";
			echo "<td width='10'></td>";
			echo "<td colspan=5>";
				while( $dataOwner = mysql_fetch_array($resOwner) )
				{
					if( !empty($id) )
					{
						$sql = "SELECT COUNT(owner_id) AS nums FROM workers_task_owners_choosen WHERE task_id = '".$id."' AND owner_id = '".$dataOwner['id']."' ";
						$reschoosen = mysql_db_query(DB,$sql);
						$datachoosen = mysql_fetch_array($reschoosen);
						
					}
					$checked = ( $datachoosen['nums'] > 0  ) ? "checked" : "";
					echo "<label><input type='checkbox' class='task_ownerCheck' name='task_owners[".$dataOwner['id']."]' value='1' ".$checked."> ".stripslashes($dataOwner['client_name'])."</label>&nbsp;&nbsp;";
				}
			echo "</td>";
		echo "</tr>";
		echo "<tr><td colspan=7 height=7></td></tr>";
		echo "<tr>";
		echo "<td>אחראי משימה:</td>";
			echo "<td width='10'></td>";
			echo "<td colspan=5>";
				$sql_ow = "SELECT client_name , id FROM sites_owner WHERE ilbiz_worker=1 AND deleted=0 AND status=0 AND end_date >= NOW() ORDER BY client_name";
				$resOwner_ow = mysql_db_query(DB, $sql_ow);
				while( $dataOwner = mysql_fetch_array($resOwner_ow) )
				{
					if( !empty($id) )
					{
						$sql = "SELECT COUNT(owner_id) AS nums FROM workers_task_owners_choosen WHERE task_id = '".$id."' AND owner_id = '".$dataOwner['id']."' ";
						$reschoosen = mysql_db_query(DB,$sql);
						$datachoosen = mysql_fetch_array($reschoosen);
						
					}
					$checked = ( $datachoosen['nums'] > 0  ) ? "checked" : "";
					echo "<label><input type='radio' class='reciverRadio' name='task_reciver_owner' value='".$dataOwner['id']."'> ".stripslashes($dataOwner['client_name'])."</label>&nbsp;&nbsp;";
				}
			echo "</td>";
		echo "</tr>";
		echo "<tr><td colspan=7 height=7></td></tr>";		
		echo "<tr>";
			echo "<td valign=top>תיאור המשימה:</td>";
			echo "<td width='10'></td>";
			echo "<td colspan=5><textarea name='content' style='width:550px; height: 120px; ' id='content' class='textarea_style' cols='' rows=''>".stripslashes($data['content'])."</textarea></td>";
		echo "</tr>";
		echo "<tr><td colspan=7 height=7></td></tr>";
		echo "<tr>";
			echo "<td>תאריך סיום מיועד:</td>";
			echo "<td width='10'></td>";
			$deadline_temp2 = explode(" " , $data['deadline_date'] );
			$deadline_temp = explode("-" , $deadline_temp2[0] );
			$deadline_date = $deadline_temp[2]."-".$deadline_temp[1]."-".$deadline_temp[0];
			echo "<td><input type='text' value='".$deadline_date."' name='deadline_date' id='deadline_date' style='width:200px;' class='input_style'></td>";
			echo "<td width='21'></td>";
			echo "<td>קישור חופשי:</td>";
			echo "<td width='10'></td>";
			echo "<td><input type='text' name='free_link' id='free_link' value='".stripslashes($data['free_link'])."' style='width:200px;' class='input_style'></td>";
		echo "</tr>";
		echo "<tr><td colspan=7 height=7></td></tr>";
		echo "<tr>";
			echo "<td colspan=7 align=center>";
			
				$onclick = ( !empty($id) ) ? "task_edit_data(\"title_".$id."\" , \"TaskMoreData_".$id."\" , \"".SESID."\" , \"".$id."\")" : "addNew_tesk_mission_Close(\"".SESID."\")";
				echo "<input type='button' onclick='".$onclick."' value='ביטול' class='submit_style'>";
				echo "<input type='submit' value='שמירה' class='submit_style'>
			</td>";
		echo "</tr>";
		
		
	echo "</table>";
	echo "</form>";
}

function tasks___addNewTaskDB()
{
	$deadline_date = freeBirthday($_POST['deadline_date']);
	$sql = "INSERT INTO workers_task ( subject , content , free_link , insert_date , deadline_date , sender_owner,reciver_owner ) VALUES ( 
		'".addslashes(utf8_to_windows1255($_POST['subject']))."' , '".addslashes(utf8_to_windows1255($_POST['content']))."' , 
		'".addslashes(utf8_to_windows1255($_POST['free_link']))."' , NOW() , 
		'".addslashes($deadline_date)."' , '".WORKERID."','".$_POST['task_reciver_owner']."' )";
	$res = mysql_db_query(DB,$sql);
	$task_id = mysql_insert_id();
	
	if( is_array($_POST['task_owners']) )
	{
		foreach( $_POST['task_owners'] as $key => $val ) 
		{
			$sql = "INSERT INTO workers_task_owners_choosen ( task_id , owner_id ) VALUES ( '".$task_id."' , '".$key."' )";
			$res = mysql_db_query(DB,$sql);
		}
	}
	
	echo "<script>showTaskesList(\"".SESID."\" , \"0\" )</script>";
	exit;
}

function tasks___editTaskDB()
{
	$deadline_date = freeBirthday($_POST['deadline_date']);
	
	$sql = "UPDATE workers_task SET subject = '".addslashes(utf8_to_windows1255($_POST['subject']))."' , 
	content = '".addslashes(utf8_to_windows1255($_POST['content']))."' ,
	free_link = '".addslashes(utf8_to_windows1255($_POST['free_link']))."' ,
	deadline_date = '".addslashes($deadline_date)."' WHERE
	id = '".$_POST['recored_id']."'";
	$res = mysql_db_query(DB,$sql);
	$task_id = $_POST['recored_id'];
	
	if( is_array($_POST['task_owners']) )
	{
		$sql = "DELETE FROM workers_task_owners_choosen WHERE task_id = '".$task_id."'";
		$res = mysql_db_query(DB,$sql);
		$data = mysql_fetch_array($res);
		
		foreach( $_POST['task_owners'] as $key => $val ) 
		{
			$sql = "INSERT INTO workers_task_owners_choosen ( task_id , owner_id ) VALUES ( '".$task_id."' , '".$key."' )";
			$res = mysql_db_query(DB,$sql);
		}
	}
	
	echo "<script>showTaskesList(\"".SESID."\" , \"0\" )</script>";
	exit;
}

function tasks___AddTaskesDiscassion()
{
	$sql = "INSERT INTO workers_task_discassion ( task_id , owner_id , content , insert_date ) VALUES ( 
		'".$_POST['task_id']."' , '".WORKERID."' , 
		'".addslashes(utf8_to_windows1255($_POST['add_discassion']))."' , NOW() )";
	$res = mysql_db_query(DB,$sql);
	$discassion_id = mysql_insert_id();
	
	if( is_array($_POST['task_owners']) )
	{
		foreach( $_POST['task_owners'] as $key => $val ) 
		{
			$sql = "SELECT view FROM workers_task_owners_choosen WHERE task_id = '".$_POST['task_id']."' AND owner_id='".$key."'";
			$res = mysql_db_query(DB,$sql);
			$data = mysql_fetch_array($res);
			
			if( $data['view'] == 1 )
			{
				$sql = "UPDATE workers_task_owners_choosen SET view=0 WHERE task_id = '".$_POST['task_id']."' AND owner_id='".$key."'";
				$res = mysql_db_query(DB,$sql);
			}
			else
			{
				$sql = "INSERT INTO workers_task_owners_choosen ( task_id , owner_id ) VALUES ( '".$_POST['task_id']."' , '".$key."' )";
				$res = mysql_db_query(DB,$sql);
			}
			
			$sql = "INSERT INTO workers_task_discassion_owners_choosen ( discasstion_id , owner_id ) VALUES ( '".$discassion_id."' , '".$key."' )";
			$res = mysql_db_query(DB,$sql);
		}
	}
	
	echo "<script>showDiscassionList(\"".SESID."\" , \"".$_POST['task_id']."\" )</script>";
	exit;
}

function tasks___showTaskesHoursList()
{
	$sql = "SELECT * FROM workers_task_price WHERE task_id = '".$_GET['task_id']."' AND deleted=0 ORDER BY id";
	$res = mysql_db_query(DB,$sql);
	
	echo "<table border=\"0\" cellspacing=\"0\" cellpadding=\"0\" class=\"maintext\">";
		while( $data = mysql_fetch_array($res) )
		{
			$sql = "SELECT client_name FROM sites_owner WHERE id = '".$data['owner_id']."' AND ilbiz_worker=1 ORDER BY client_name";
			$resWorker = mysql_db_query(DB, $sql);
			$dataWorker = mysql_fetch_array($resWorker);
			
			echo "<tr>";
				echo "<td>עובד: ".stripslashes($dataWorker['client_name'])."</td>";
				echo "<td width=10></td>";
				if( $data['hours'] > 0 )
					echo "<td>שעות עבודה: ".$data['hours']."</td><td width=10></td>";
				if( $data['price'] > 0 )
					echo "<td>מחיר: ".$data['price']."</td><td width=10></td>";
				if( $data['note'] != '' )
					echo "<td>הערות: ".stripslashes($data['note'])."</td>";
				echo "<td width=10></td>";
				if( $data['owner_id'] == WORKERID )
					echo "<td><a href='javascript:DELTaskesHours(\"".SESID."\" , \"".$_GET['task_id']."\" , \"".$data['id']."\")' title='מחיקה' onclick='return can_i_del()'><img src='images/small_delete_icon.png' alt='מחיקה' border=0></a></td>";
			echo "</tr>";
			echo "<tr><td colspan=9 height=7></td></tr>";
		}
	echo "</table>";
}


function tasks___showDiscassionList()
{
	$sql = "SELECT * FROM workers_task_discassion WHERE task_id = '".$_GET['task_id']."' ORDER BY id";
	$res = mysql_db_query(DB,$sql);
	
	echo "<table border=\"0\" cellspacing=\"0\" cellpadding=\"0\" class=\"maintext\">";
		while( $data = mysql_fetch_array($res) )
		{
			$sql = "SELECT owner_id FROM workers_task_discassion_owners_choosen WHERE discasstion_id = '".$data['id']."'";
			$res_discassion_owners = mysql_db_query(DB, $sql);
			$n_o = "";
			while( $dataWorker = mysql_fetch_array($res_discassion_owners) )
			{
				$sql = "SELECT client_name FROM sites_owner WHERE id = '".$dataWorker['owner_id']."' AND ilbiz_worker=1 ORDER BY client_name";
				$resWorker = mysql_db_query(DB, $sql);
				$dataWorker = mysql_fetch_array($resWorker);
				
				$n_o .= stripslashes($dataWorker['client_name']) . ", ";
			}
			$n_o = substr( $n_o , 0 , -2 );
			
			$sql = "SELECT client_name FROM sites_owner WHERE id = '".$data['owner_id']."' AND ilbiz_worker=1 ";
			$resWorker = mysql_db_query(DB, $sql);
			$dataWorker = mysql_fetch_array($resWorker);
			
			
			echo "<tr>";
				echo "<td>לכבוד: <b>".$n_o."</b></td>";
			echo "</tr>";
			echo "<tr><td height=7></td></tr>";
			echo "<tr>";
				echo "<td>".nl2br(stripslashes($data['content']))."</td>";
			echo "</tr>";
			echo "<tr><td height=7></td></tr>";
			echo "<tr>";
				echo "<td>מאת: <b>".stripslashes($dataWorker['client_name'])."</b></td>";
			echo "</tr>";
			echo "<tr><td height=5></td></tr>";
			echo "<tr><td><hr size=1 color=#a8c8d5 width=100%></td></tr>";
			echo "<tr><td height=5></td></tr>";
		}
	echo "</table>";
}


function tasks___AddTaskesHours()
{
	$sql = "INSERT INTO workers_task_price ( task_id , owner_id , price , hours , note ) VALUES ( 
		'".$_POST['task_id']."' , '".WORKERID."' , 
		'".$_POST['add_price']."' , '".$_POST['add_hours']."' , '".addslashes(utf8_to_windows1255($_POST['add_note']))."')";
	$res = mysql_db_query(DB,$sql);
	
	echo "<script>showTaskesHoursList(\"".SESID."\" , \"".$_POST['task_id']."\" )</script>";
	exit;
}


function freeBirthday($value)
{
	$values = array('.' , '/' , '-' , ':');
	
	foreach($values as $dotsh )
	{
		$explode = explode($dotsh, $value);
		
		if( strlen($explode[0]) < 5 )
		{
			if( $explode[0] < "32" )
			{
				if( strlen($explode[2]) > 2 )
					$year = $explode[2];
				else
  				if( $explode[2] < "10" )
  					$year = "20".$explode[2];
  				else
  					$year = "20".$explode[2];
  			$date = $year."-".$explode[1]."-".$explode[0]; 
    	}
    	else
    	{
    		$date = $explode[0]."-".$explode[1]."-".$explode[2]; 
    	}
    }
  }
  return $date;
}


function utf8_to_windows1255($utf8) {
    $windows1255 = "";
    $chars = preg_split("//",$utf8);
    for ($i=1; $i<count($chars)-1; $i++) {
        $prefix = ord($chars[$i]);
        $suffix = ord($chars[$i+1]);
        //print ("<p>$prefix $suffix");
        if ($prefix==215) {
            $windows1255 .= chr($suffix+80);
            $i++;
        }
        elseif ($prefix==214) {
            $windows1255 .= chr($suffix+16);
            $i++;
        }
        else {
            $windows1255 .= $chars[$i];
        }
    }
    return $windows1255;
} 

?>