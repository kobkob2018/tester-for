<?
   
function users_ecom_buy()
{
	$sql = "SELECT dogs4u_chooser_shop , nisha_sites , site_type FROM users as u , user_extra_settings as ux WHERE u.unk = ux.unk and u.unk = '".UNK."' ";
	$resExtra = mysql_db_query(DB,$sql);
	$dataExtra = mysql_fetch_array($resExtra);
	
	$limitCount = ( $_GET['limit'] == "" ) ? "0" : (int)$_GET['limit'];
	 
	$ex = explode( "-" , $_GET['sd'] );
	$where = ($_GET['sd'] != "" ) ? " AND o.insert_date >= '".$ex[2]."-".$ex[1]."-".$ex[0]."' " : "";
	$ex2 = explode( "-" , $_GET['ed'] );
	
	$where .= ($_GET['ed'] != "" ) ? " AND o.insert_date <= '".$ex2[2]."-".$ex2[1]."-".$ex2[0]."' " : "";
	$where .= ($_GET['prod_val'] != "" ) ? " AND p.name LIKE '%".mysql_real_escape_string($_GET['prod_val'])."%' " : "";
	$where .= ($_GET['val'] != "" ) ? " AND o.full_name LIKE '%".mysql_real_escape_string($_GET['val'])."%' " : "";
	$where .= ($_GET['s_id'] != "" ) ? " AND o.id = '".(int)$_GET['s_id']."' " : "";
	
	if( $dataExtra['dogs4u_chooser_shop'] == "1" )
	{
		$nisha_sites = json_decode($dataExtra['nisha_sites']);
		
		$unk_nisha = "";
		if( is_array($nisha_sites) )
		{
			foreach( $nisha_sites as $key => $val )
			{
				$sql = "SELECT unk FROM users WHERE id = '".(int)$val."' ";
				$resNishaS = mysql_db_query(DB,$sql);
				$dataNishaS = mysql_fetch_array($resNishaS);
				
				$unk_nisha .= "'".$dataNishaS['unk']."',";
			}
		}
		$unk_nisha .= "'".mysql_real_escape_string($_REQUEST['unk'])."'";
		
		//LIMIT ".$limitCount.",50
		$sql = "select o.* FROM users_ecom_buy as o , user_ecom_items as i , user_products as p  WHERE 
			o.unk IN (".$unk_nisha.") AND
			o.unickSES=i.client_unickSes AND
			o.unk=i.unk AND
			i.product_id=p.id AND
			o.deleted = '0' ".$where."
			GROUP BY o.id ORDER BY id DESC ";
		$res = mysql_db_query(DB,$sql);
	}
	elseif( $dataExtra['nisha_sites'] != "" && $dataExtra['site_type'] != '10' )
	{
		$nisha_sites = json_decode($dataExtra['nisha_sites']);
		
		$unk_nisha = "";
		foreach( $nisha_sites as $key => $val )
		{
			$sql = "SELECT unk FROM users WHERE id = '".(int)$val."' ";
			$resNishaS = mysql_db_query(DB,$sql);
			$dataNishaS = mysql_fetch_array($resNishaS);
			
			$unk_nisha .= "'".$dataNishaS['unk']."',";
		}
		$unk_nisha .= "'".mysql_real_escape_string($_REQUEST['unk'])."'";
		
		$sql = "select o.* , p.unk as pro_unk FROM users_ecom_buy as o , user_ecom_items as i , user_products as p  WHERE 
			o.unk IN (".$unk_nisha.") AND
			o.unickSES=i.client_unickSes AND
			o.unk=i.unk AND
			i.product_id=p.id AND
			p.unk = '".mysql_real_escape_string($_REQUEST['unk'])."' and
			o.deleted = '0' ".$where."
			GROUP BY o.id ORDER BY id DESC ";
		$res = mysql_db_query(DB,$sql);
	}
	else
	{
		//LIMIT ".$limitCount.",50
		$sql = "select o.* FROM users_ecom_buy as o , user_ecom_items as i , user_products as p  WHERE 
			o.unk = '".mysql_real_escape_string($_REQUEST['unk'])."' and 
			o.unickSES=i.client_unickSes AND
			o.unk=i.unk AND
			i.product_id=p.id AND
			o.deleted = '0' ".$where."
			GROUP BY o.id ORDER BY id DESC ";
		$res = mysql_db_query(DB,$sql);
	}
	
	//if( $_SERVER[REMOTE_ADDR] == "82.166.72.135" )
		//echo $sql;
	echo "<table border=\"0\" cellspacing=\"0\" cellpadding=\"0\" class=\"maintext\">";
		
		echo "<tr>";
			echo "<td colspan=15>";
				echo "<form action='index.php' name='conatct_search' method='get' style=''padding:0; margin:0;>";
					echo "<input type='hidden' name='main' value='users_ecom_buy'>";
					echo "<input type='hidden' name='type' value='users_ecom_buy'>";
					echo "<input type='hidden' name='unk' value='".UNK."'>";
					echo "<input type='hidden' name='sesid' value='".SESID."'>";
					echo "<table border=\"0\" cellspacing=\"0\" cellpadding=\"0\" class=\"maintext\">";
						echo "<tr>";
							echo "<td>מתאריך (כולל):</td>";
							echo "<td width='10'></td>";
							echo "<td><input type=text name='sd' value='".$_GET['sd']."' class='input_style' style='width: 80px;'> mm-dd-yyy</td>";
							echo "<td width='30'></td>";
							echo "<td>עד לתאריך (לא כולל):</td>";
							echo "<td width='10'></td>";
							echo "<td><input type=text name='ed' value='".$_GET['ed']."' class='input_style' style='width: 80px;'> mm-dd-yyy</td>";
						echo "</tr>";
						echo "<tr><td colspan=7 height=5></td></tr>";
						echo "<tr>";
							echo "<td>שם הקונה:</td>";
							echo "<td width='10'></td>";
							echo "<td><input type=text name='val' value='".$_GET['val']."' class='input_style' style='width: 80px;'></td>";
							echo "<td width='30'></td>";
							echo "<td>שם המוצר</td>";
							echo "<td width='10'></td>";
							echo "<td><input type=text name='prod_val' value='".$_GET['prod_val']."' class='input_style' style='width: 80px;'></td>";
						echo "</tr>";
						echo "<tr><td colspan=7 height=5></td></tr>";
						echo "<tr>";
							echo "<td>מספר הזמנה</td>";
							echo "<td width='10'></td>";
							echo "<td><input type=text name='s_id' value='".$_GET['s_id']."' class='input_style' style='width: 80px;'></td>";
							echo "<td width='30'></td>";
							echo "<td><input type='submit' class='submit_style' value='חפש!' style='width: 80px;'></td>";
							echo "<td width='10'></td>";
							echo "<td align=left><a href='getExcelEcomBuy.php?unk=".$_GET['unk']."&sesid=".$_GET['sesid']."&sd=".$_GET['sd']."&ed=".$_GET['ed']."&prod_val=".$_GET['prod_val']."&s_id=".$_GET['s_id']."&val=".$_GET['val']."' target='_blank'><img src='images/Excel_32.png' border=0 alt='יצוא לאקסל' /></td>";
						echo "</tr>";
					echo "</table>";
					echo "</form>";
			echo "</td>";
		echo "</tr>";
		
		
		echo "<tr>";
			echo "<td><b>מספר הזמנה</b></td>";
			echo "<td width='15'></td>";
			echo "<td></td>";
			echo "<td width='15'></td>";
			echo "<td><b>שם הקונה</b></td>";
			echo "<td width='15'></td>";
			echo "<td><b>התשלום</b></td>";
			echo "<td width='15'></td>";
			echo "<td><b>סטטוס עבודה</b></td>";
			echo "<td width='15'></td>";
			echo "<td><b>קנייה שולמה בהצלחה?</b></td>";
			echo "<td width='15'></td>";
			echo "<td><b>צפייה בהזמנה</b></td>";
			//echo "<td width='15'></td>";
			//echo "<td><b>מחיקה</b></td>";
		echo "</tr>";
		
		while( $data = mysql_fetch_array($res) )
		{
			$total_price_to_pay = 0;
			
			$sql = "select product_id from user_ecom_items where unk = '".$data['unk']."' and status=0 AND client_unickSes = '".$data['unickSES']."' GROUP BY product_id";
			$resItems = mysql_db_query(DB,$sql);
			
			while( $dataItems = mysql_fetch_array($resItems) )
			{
				$sql = "select price,price_special from user_products where id = '".$dataItems['product_id']."'";
				$resPrice = mysql_db_query(DB,$sql);
				$dataPrice = mysql_fetch_array($resPrice);
				
				if( UNK == "625420717714095702" )
				{
					$sql = "SELECT tz FROM users_tz_list WHERE unk = '".UNK."' AND tz = '".trim($data['tz'])."' LIMIT 1";
					$resCheckTz = mysql_db_query(DB,$sql);
					$DataCheckTZ = mysql_fetch_array($resCheckTz);
					
					if( $data['tz'] == $DataCheckTZ['tz'] && $dataPrice['price_special'] > "0" )
						$price = $dataPrice['price_special'];
					else
						$price = $dataPrice['price'];
				}
				else
					$price = $dataPrice['price'];
					
				$sql = "select id from user_ecom_items where unk = '".$data['unk']."' and status=0 AND client_unickSes = '".$data['unickSES']."' and product_id = '".$dataItems['product_id']."'";
				$resQry = mysql_db_query(DB,$sql);
				$qry_nm = mysql_num_rows($resQry);
				
				$total_price_to_pay = $total_price_to_pay + ( $price * $qry_nm );
			}
			
			$work_status = ( $data['status'] == "0" ) ? "פנייה חדשה": "";
			$work_status = ( $data['status'] == "1" ) ? "מחכה לטלפון": $work_status;
			$work_status = ( $data['status'] == "2" ) ? "פנייה בטיפול": $work_status;
			$work_status = ( $data['status'] == "3" ) ? "סגור - מחכה למוצר": $work_status;
			$work_status = ( $data['status'] == "4" ) ? "סגור - קיבל מוצר": $work_status;
			$work_status = ( $data['status'] == "5" ) ? "פנייה מבוטלת": $work_status;
			$work_status = ( $data['status'] == "6" ) ? "לא רלוונטי": $work_status;
			
			if( UNK == "625420717714095702" )
			{
				$work_status = ( $data['status'] == "7" ) ? "דמי חבר - שולם במזומן": $work_status;
				$work_status = ( $data['status'] == "8" ) ? "דמי חבר - שולם באשראי": $work_status;
			}
			
			
			
			$paidS = ( $data['paid'] == "1" ) ? "<font color=green><b>כן</b></font>": "<font color=red><b>לא</b></font>";
			
			echo "<tr><td colspan=13 height='5'></td></tr>";
			echo "<tr><td colspan=13><hr width='100%' color='#b3b3b3' size='1'></td></tr>";
			echo "<tr><td colspan=13 height='5'></td></tr>";
			echo "<tr>";
				if( UNK != "625420717714095702" )
					echo "<td>".$data['id']."</td>";
				else
				{
					$sql = "select id from user_ecom_items where status=0 AND client_unickSes = '".$data['unickSES']."' and ( product_id = '15173' OR product_id = '15174' )";
					$res3 = mysql_db_query(DB,$sql);
					$qry_nm = mysql_num_rows($res3);
					
					if( $qry_nm > 0 )
						echo "<td><li> ".$data['id']."</li></td>";
					else
						echo "<td>".$data['id']."</td>";
				}
				echo "<td width='15'></td>";
				echo "<td>".GlobalFunctions::show_dateTime_field($data['insert_date'])."</td>";
				echo "<td width='15'></td>";
				echo "<td>".GlobalFunctions::kill_strip($data['full_name'])."</td>";
				echo "<td width='15'></td>";
				echo "<td>".$total_price_to_pay."</td>";
				echo "<td width='15'></td>";
				echo "<td>".$work_status."</td>";
				echo "<td width='15'></td>";
				echo "<td>".$paidS."</td>";
				echo "<td width='15'></td>";
				echo "<td><a href='?main=users_ecom_buyView&type=users_ecom_buy&re_id=".$data['id']."&unickSes=".$data['unickSES']."&unk=".$_REQUEST['unk']."&sesid=".$_REQUEST['sesid']."' class='maintext'>צפייה בהזמנה</a></td>";
				//echo "<td width='15'></td>";
				//echo "<td><a href='?main=users_ecom_buyDel&type=users_ecom_buy&row_id=".$data['id']."&unk=".$_REQUEST['unk']."&sesid=".$_REQUEST['sesid']."' class='maintext' onclick=\"return can_i_del()\">מחיקה</a></td>";
			echo "</tr>";
			
		}
		
		
		/*echo "<tr><td colspan=15 height=15></td></tr>";
		echo "<tr>";
			echo "<td colspan=15 align=center>סך הכל הזמנות: ".$num_rows."</td>";
		echo "</tr>";
		echo "<tr><td colspan=15 height=15></td></tr>";
		echo "<tr>";
			echo "<td colspan=15 align=center style=\"border-top: 1px solid #".$data_colors['border_color'].";\">";	
				$params['limitInPage'] = "50";
				$params['numRows'] = $num_rows;
				$params['limitcount'] = $limitCount;
				$params['main'] = $_GET['main'];
				$params['type'] = $_GET['type'];
				
				getLimitPagentionAdmin( $params );
				
			echo "</td>";
		echo "</tr>";
		*/
	echo "</table>";
	
}


function users_ecom_buyView()
{
	$sql = "SELECT dogs4u_chooser_shop , nisha_sites FROM user_extra_settings WHERE unk = '".UNK."' ";
	$resExtra = mysql_db_query(DB,$sql);
	$dataExtra = mysql_fetch_array($resExtra);
	
	
	
	if( $dataExtra['dogs4u_chooser_shop'] == "1" or $dataExtra['nisha_sites'] != "" )
		$sql = "select product_id from user_ecom_items where status=0 AND client_unickSes = '".mysql_real_escape_string($_GET['unickSes'])."' GROUP BY product_id";
	else
		$sql = "select product_id from user_ecom_items where unk = '".mysql_real_escape_string($_REQUEST['unk'])."' and status=0 AND client_unickSes = '".mysql_real_escape_string($_GET['unickSes'])."' GROUP BY product_id";
	$res = mysql_db_query(DB,$sql);
	$num_rows = mysql_num_rows($res);
	
	if( $dataExtra['nisha_sites'] != "" )
		$sql = "select * from users_ecom_buy where deleted = '0' and unickSES = '".mysql_real_escape_string($_GET['unickSes'])."'";
	else
		$sql = "select * from users_ecom_buy where unk = '".mysql_real_escape_string($_REQUEST['unk'])."' and deleted = '0' and unickSES = '".mysql_real_escape_string($_GET['unickSes'])."'";
	$resDetail = mysql_db_query(DB,$sql);
	$dataDetail = mysql_fetch_array($resDetail);
	
	$total_price_to_pay = 0;
	
	echo "<table border=\"0\" cellspacing=\"0\" cellpadding=\"0\" class=\"maintext\">";
		
		if( eregi('index.php' , $_SERVER[SCRIPT_NAME] ) )
		{
			echo "<tr>";
				echo "<td align=right><a href='print.php?".$_SERVER[QUERY_STRING]."' title='הדפסה' target='_blank'><img src='images/print_icon.png' border=0 alt='הדפסה'></a></td>";
			echo "</tr>";
			echo "<tr><td height=10></td></tr>";
		}
		/// E-COM cart details
		echo "<tr>";
			echo "<td>";
				echo "<table border=\"0\" cellspacing=\"0\" cellpadding=\"0\" class=\"maintext\">";
					echo "<tr>";
						echo "<td><b>שם המוצר</b></td>";
						echo "<td width=10></td>";
						echo "<td><b>מס' קטלוגי</b></td>";
						echo "<td width=10></td>";
						echo "<td><b>מחיר ליחידה</b></td>";
						echo "<td width=10></td>";
						echo "<td><b>כמות</b></td>";
					echo "</tr>";
					
					echo "<tr><td colspan=7 height=7></td></td>";
					
					while( $data = mysql_fetch_array($res) )
					{
						$sql = "select unk,name,price,price_special,makat from user_products where id = '".$data['product_id']."'";
						$res2 = mysql_db_query(DB,$sql);
						$data2 = mysql_fetch_array($res2);
						
						$sql = "select id from user_ecom_items where status=0 AND client_unickSes = '".$_GET['unickSes']."' and product_id = '".$data['product_id']."'";
						$res3 = mysql_db_query(DB,$sql);
						$qry_nm = mysql_num_rows($res3);
						
						if( UNK == "625420717714095702" )
						{
							$sql = "SELECT tz FROM users_tz_list WHERE unk = '".UNK."' AND tz = '".trim($dataDetail['tz'])."' LIMIT 1";
							$resCheckTz = mysql_db_query(DB,$sql);
							$DataCheckTZ = mysql_fetch_array($resCheckTz);
							
							if( $dataDetail['tz'] == $DataCheckTZ['tz'] && $data2['price_special'] > "0" )
								$price = $data2['price_special'];
							else
								$price = $data2['price'];
						}
						else
							$price = $data2['price'];
						
						if( $data2['unk'] == $_GET['unk'] )
							$temp_str = "str_1";
						else
							$temp_str = "str_2";
						
						$$temp_str .= "<tr>";
							$$temp_str .= "<td>".GlobalFunctions::kill_strip($data2['name'])."</td>";
							$$temp_str .= "<td width=10></td>";
							$$temp_str .= "<td>".GlobalFunctions::kill_strip($data2['makat'])."</td>";
							$$temp_str .= "<td width=10></td>";
							$$temp_str .= "<td>".GlobalFunctions::kill_strip($price)."</td>";
							$$temp_str .= "<td width=10></td>";
							$$temp_str .= "<td>".$qry_nm."</td>";
						$$temp_str .= "</tr>";
						$$temp_str .= "<tr><td colspan=7 height=5></td></td>";
						
						$total_price_to_pay = $total_price_to_pay + ( $price * $qry_nm );
					}
					
					if( $dataExtra['nisha_sites'] != "" && $str_1 != "" )
						echo "<tr><td colspan=7 height=5></td></td><tr><td colspan=7><u>המוצרים שלי</u></td></td><tr><td colspan=7 height=5></td></td>";
					echo $str_1;
					
					if( $dataExtra['nisha_sites'] != "" && $str_2 != "" )
						echo "<tr><td colspan=7 height=5></td></td><tr><td colspan=7><u>מוצרים שהוזמנו באותה הזמנה מלקוחות אחרים</u></td></td><tr><td colspan=7 height=5></td></td>";
					echo $str_2;
					
					$sum_tot = $dataDetail['delivery_pay'] + $total_price_to_pay;
						echo "<tr><td colspan=7 height=5></td></td>";
						echo "<tr><td colspan=7><hr width='100%' color='#b3b3b3' size='1'></td></tr>";
						echo "<tr><td colspan=7 height=5></td></td>";
						echo "<tr>";
							echo "<td colspan=7>";
								echo "<table border=\"0\" cellspacing=\"0\" cellpadding=\"0\" class=\"maintext\">";
									echo "<tr>";
										echo "<td><b>סך הכל:</b> ".$total_price_to_pay."</td>";
										echo "<td width=30></td>";
										echo "<td><b>דמי משלוח:</b> ".GlobalFunctions::kill_strip($dataDetail['delivery_pay'])."</td>";
									echo "</tr>";
								echo "</table>";
							echo "</td>";
						echo "</tr>";
						echo "<tr><td colspan=7 height=5></td></td>";
					
				echo "</table>";
			echo "</td>";
		echo "</tr>";
		
		echo "<tr><td height=15></td></td>";
		
		echo "<tr>";
			echo "<td><B>מספר הזמנה:</B> ".$dataDetail['id']."</td>";
		echo "</tr>";
		echo "<tr><td height=10></td></td>";
		echo "<tr>";
			echo "<td><B>תאריך שליחה:</B> ".GlobalFunctions::show_dateTime_field($dataDetail['insert_date'])."</td>";
		echo "</tr>";
		echo "<tr><td height=10></td></td>";
		echo "<tr>";
			echo "<td><b>כולל דמי משלוח:</b> ".$sum_tot."</td>";
		echo "</tr>";
		echo "<tr><td height=10></td></td>";
		
		$paidS = ( $dataDetail['paid'] == "1" ) ? "<font color=green>כן</font>": "<font color=red>לא</font>";
		echo "<tr>";
			echo "<td>שולם בהצלחה? <b>".$paidS."</b> </td>";
		echo "</tr>";
		
		if( $dataDetail['note'] != "" )
		{
			echo "<tr><td height=5></td></td>";
			echo "<tr><td><hr width='100%' color='#b3b3b3' size='1'></td></tr>";
			echo "<tr><td height=5></td></td>";
			echo "<tr>";
				echo "<td><b>הערות נוספות:</b><br> ".nl2br(GlobalFunctions::kill_strip($dataDetail['note']))."</td>";
			echo "</tr>";
		}
		
		if( UNK == "038157696328808156" ) 
		{
			$file_name = GlobalFunctions::show_dateTime_field($dataDetail['insert_date']);
			echo "<tr><td height=15></td></td>";
			echo "<tr>";
				echo "<td><a href='http://www.ilbiz.co.il/newsite/net_system/castum/chip.haari/ecomHtmlPage.php?unk=".UNK."&sesid=".SESID."&unickSes=".$_GET['unickSes']."&ecomId=".$dataDetail['id']."' class='maintext' target='_blank'>צפה בעמוד HTML</a><br>
				<a href='http://www.ilbiz.co.il/newsite/net_system/castum/chip.haari/ecomHtmlPage.php?unk=".UNK."&sesid=".SESID."&unickSes=".$_GET['unickSes']."&ecomId=".$dataDetail['id']."&downloadIT=1&createName=".$file_name."' class='maintext' target='_blank'>הורדת עמוד HTML</a></td>";
			echo "</tr>";
		}
		
		echo "<tr><td height=10></td></td>";
		echo "<tr><td><hr width='100%' color='#b3b3b3' size='1'></td></tr>";
		echo "<tr><td height=10></td></td>";
		
		$sql = "SELECT date_in, name, id FROM user_contact_forms WHERE unk = '".$_REQUEST['unk']."' AND ( ( name LIKE '%".$dataDetail['full_name']."%' ) OR ( content LIKE '%".$dataDetail['full_name']."%' ) )";
		$resContact = mysql_db_query(DB,$sql);
		$num_rows = mysql_num_rows($resContact);
		
		if( $num_rows > 0 )
		{
			// contact user details
			echo "<tr>";
				echo "<td><b>רשימת טפסי צור קשר של רלוונטים:</b></td>";
			echo "</tr>";
			echo "<tr><td height=10></td></td>";
			echo "<tr>";
				echo "<td>";
					echo "<table border=\"0\" cellspacing=\"0\" cellpadding=\"0\" class=\"maintext\">";
						while( $dataContact = mysql_fetch_array($resContact) )
						{
							echo "<tr>";
								echo "<td>תאריך פנייה: </td>";
								echo "<td width=10></td>";
								echo "<td>".GlobalFunctions::show_dateTime_field($dataUserDetail['date_in'])."</td>";
								echo "<td width=10></td>";
								echo "<td><a href='index.php?main=get_create_form&type=contact&row_id=".$dataContact['id']."&unk=".UNK."&sesid=".SESID."' target='_blank' class='maintext'>לפרטים המלאים</a></td>";
							echo "</tr>";
						}
					echo "</table>";
				echo "</td>";
			echo "</tr>";
			
			echo "<tr><td height=15></td></td>";
			echo "<tr><td><hr width='100%' color='#b3b3b3' size='1'></td></tr>";
			echo "<tr><td height=15></td></td>";
		}
		
		
		
		/// E-COM user details
		echo "<tr>";
			echo "<td>";
				echo "<table border=\"0\" cellspacing=\"0\" cellpadding=\"0\" class=\"maintext\">";
					echo "<tr>";
						echo "<td><b>שם מלא</b></td>";
						echo "<td width=10></td>";
						echo "<td>".GlobalFunctions::kill_strip($dataDetail['full_name'])."</td>";
					echo "</tr>";
					echo "<tr><td colspan=3 height=4></td></td>";
					
					if( $dataDetail['tz'] != "" )
					{
						echo "<tr>";
							echo "<td><b>תעודת זהות</b></td>";
							echo "<td width=10></td>";
							echo "<td>".GlobalFunctions::kill_strip($dataDetail['tz'])."</td>";
						echo "</tr>";
						echo "<tr><td colspan=3 height=4></td></td>";
					}
					
					echo "<tr>";
						echo "<td><b>אימייל</b></td>";
						echo "<td width=10></td>";
						echo "<td>".GlobalFunctions::kill_strip($dataDetail['email'])."</td>";
					echo "</tr>";
					echo "<tr><td colspan=3 height=4></td></td>";
					echo "<tr>";
						echo "<td><b>טלפון</b></td>";
						echo "<td width=10></td>";
						echo "<td>".GlobalFunctions::kill_strip($dataDetail['phone'])."</td>";
					echo "</tr>";
					echo "<tr><td colspan=3 height=4></td></td>";
					echo "<tr>";
						echo "<td><b>ישוב</b></td>";
						echo "<td width=10></td>";
							echo "<td>".GlobalFunctions::kill_strip($dataDetail['city'])."</td>";
					echo "</tr>";
					echo "<tr><td colspan=3 height=4></td></td>";
					echo "<tr>";
						echo "<td><b>רחוב</b></td>";
						echo "<td width=10></td>";
						echo "<td>".GlobalFunctions::kill_strip($dataDetail['address'])."</td>";
					echo "</tr>";
					echo "<tr><td colspan=3 height=4></td></td>";
					echo "<tr>";
						echo "<td><b>מספר בית</b></td>";
						echo "<td width=10></td>";
						echo "<td>".GlobalFunctions::kill_strip($dataDetail['buildingNum'])."</td>";
					echo "</tr>";
					echo "<tr><td colspan=3 height=4></td></td>";
					echo "<tr>";
						echo "<td><b>מספר דירה</b></td>";
						echo "<td width=10></td>";
						echo "<td>".GlobalFunctions::kill_strip($dataDetail['home_num'])."</td>";
					echo "</tr>";
					echo "<tr><td colspan=3 height=4></td></td>";
					echo "<tr>";
						echo "<td><b>מיקוד</b></td>";
						echo "<td width=10></td>";
						echo "<td>".GlobalFunctions::kill_strip($dataDetail['zip_code'])."</td>";
					echo "</tr>";
					echo "<tr><td colspan=3 height=4></td></td>";
					echo "<tr>";
						echo "<td><b>הערות</b></td>";
						echo "<td width=10></td>";
						echo "<td>".nl2br(GlobalFunctions::kill_strip($dataDetail['note']))."</td>";
					echo "</tr>";
				
				echo "</table>";
			echo "</td>";
		echo "</tr>";
		
		if( $dataDetail['unk'] == UNK )
		{
		echo "<tr><td height=15></td></td>";
		echo "<tr><td><hr width='100%' color='#b3b3b3' size='1'></td></tr>";
		echo "<tr><td height=15></td></td>";
		
		echo "<tr>";
			echo "<td>";
				echo "<table border=\"0\" cellspacing=\"0\" cellpadding=\"0\" class=\"maintext\">";
					echo "<form action='?' name='formi' method='POST'>";
					echo "<input type='hidden' name='main' value='users_ecom_buy_statusDB'>";
					echo "<input type='hidden' name='type' value='users_ecom_buy'>";
					echo "<input type='hidden' name='unk' value='".$_GET['unk']."'>";
					echo "<input type='hidden' name='id' value='".$dataDetail['id']."'>";
					echo "<input type='hidden' name='sesid' value='".$_GET['sesid']."'>";
					echo "<input type='hidden' name='unickSes' value='".$_GET['unickSes']."'>";
					echo "<tr>";
						echo "<td><b>עדכון סטטוס</b></td>";
						echo "<td width='15'></td>";
						echo "<td>";
							
							$selected0 = ( $dataDetail['status'] == "0" ) ? "selected": "";
							$selected1 = ( $dataDetail['status'] == "1" ) ? "selected": "";
							$selected2 = ( $dataDetail['status'] == "2" ) ? "selected": "";
							$selected3 = ( $dataDetail['status'] == "3" ) ? "selected": "";
							$selected4 = ( $dataDetail['status'] == "4" ) ? "selected": "";
							$selected5 = ( $dataDetail['status'] == "5" ) ? "selected": "";
							$selected6 = ( $dataDetail['status'] == "6" ) ? "selected": "";
							
							if( UNK == "625420717714095702" )
							{
								$selected7 = ( $dataDetail['status'] == "7" ) ? "selected": "";
								$selected8 = ( $dataDetail['status'] == "8" ) ? "selected": "";
							}
							
							echo "<select name='new_status' class='input_style' onChange='formi.submit()'>";
								echo "<option value='0' ".$selected0.">פנייה חדשה</option>";
								echo "<option value='1' ".$selected1.">מחכה לטלפון</option>";
								echo "<option value='2' ".$selected2.">פנייה בטיפול</option>";
								echo "<option value='3' ".$selected3.">סגור - מחכה למוצר</option>";
								echo "<option value='4' ".$selected4.">סגור - קיבל מוצר</option>";
								echo "<option value='5' ".$selected5.">פנייה מבוטלת</option>";
								echo "<option value='6' ".$selected6.">לא רלוונטי</option>";
								
								if( UNK == "625420717714095702" )
								{
									echo "<option value='7' ".$selected7.">דמי חבר - שולם במזומן</option>";
									echo "<option value='8' ".$selected8.">דמי חבר - שולם באשראי</option>";
								}
							echo "</select>";
						echo "</td>";
					echo "</tr>";
					echo "</form>";
					
				echo "</table>";
			echo "</td>";
		echo "</tr>";
	}
		
	echo "</table>";
}


function users_ecom_buyDel()
{

	$image_settings = array(
		after_success_goto=>"index.php?main=users_ecom_buy&type=".$_REQUEST['type']."&unk=".$_REQUEST['unk']."&sesid=".$_REQUEST['sesid'],
		table_name=> "users_ecom_buy",
	);
	
	delete_record($_REQUEST['row_id'], $image_settings);
}

function users_ecom_buy_statusDB()
{
	$sql = "update users_ecom_buy set status = '".$_POST['new_status']."' where id = '".$_POST['id']."' and unickSES = '".$_POST['unickSes']."'";
	$res = mysql_db_query(DB,$sql);
	
	echo "<script>window.location.href='index.php?main=users_ecom_buy&type=users_ecom_buy&unk=".$_POST['unk']."&sesid=".$_POST['sesid']."';</script>";
		exit;
}


function payWithCC()
{
	$sql = "SELECT id,end_date,address,city,email,phone FROM users WHERE deleted=0 AND status=0 AND unk = '".UNK."'";
	$usersRes = mysql_db_query(DB,$sql);
	$dataUser = mysql_fetch_array($usersRes);
	
	$sql = "SELECT name FROM cities WHERE id = '".$dataUser['city']."' ";
	$cityRes = mysql_db_query(DB,$sql);
	$dataCity = mysql_fetch_array($cityRes);
	
	
	$ex_end = explode("-" , $dataUser['end_date'] );
	$DateDiffAry = GetDateDifference(date(m).'/'.date(d).'/'.date(Y) , $ex_end[1].'/'.$ex_end[2].'/'.$ex_end[0] ); 
	
	$sql = "SELECT hostPriceMon,domainPrice,domainEndDate FROM user_bookkeeping WHERE unk = '".UNK."'";
	$res = mysql_db_query(DB, $sql);
	$dataPrice = mysql_fetch_array($res);
	
	$ex_endDOMAIN = explode("-" , $dataPrice['domainEndDate'] );
	$DateDiffAry_domain = GetDateDifference(date(m).'/'.date(d).'/'.date(Y) , $ex_endDOMAIN[1].'/'.$ex_endDOMAIN[2].'/'.$ex_endDOMAIN[0] ); 
	
	$gotoPay = "0";
	
	if( $DateDiffAry['DaysSince'] <= 30 && $DateDiffAry['DaysSince'] > -30 && $dataPrice['hostPriceMon'] > 0 && $_GET['payToType'] == "1" )
	{
		$month = $dataPrice['hostPriceMon'];
		$totalYear_whitoutMAAM = $dataPrice['hostPriceMon']*12;
		$maam = (18*$totalYear_whitoutMAAM)/100;
		$TOTALpriceTemp = $totalYear_whitoutMAAM + $maam;
		$TOTALprice = myround($TOTALpriceTemp);
		$desc = "אחסון שנתי";
		$payToType = "1";
		$Tashlomim = "12";
		
		$gotoPay = "1";
	}
	
	if( $DateDiffAry_domain['DaysSince'] <= 30 && $DateDiffAry_domain['DaysSince'] > -30 && $dataPrice['domainPrice'] > 0 && $_GET['payToType'] == "2")
	{
		$maam = (18*$dataPrice['domainPrice'])/100;
		$TOTALpriceTemp = $dataPrice['domainPrice'] + $maam;
		$TOTALprice = myround($TOTALpriceTemp);
		$desc = "דומיין - תשלום שנתי";
		$payToType = "2";
		$Tashlomim = "1";
		
		$gotoPay = "1";
	}
	
	if( $gotoPay == "1" )
	{
		$sql = "INSERT INTO ilbizPayByCCLog ( sumTotal , payDate , description , payToType , userId , gotoUrlParamter ) VALUES (
			'".$TOTALprice."' , NOW() , '".addslashes($desc)."' , '".$payToType."' , '".$dataUser['id']."' , 'unk=".UNK."&sesid=".SESID."'
		)";
		$res = mysql_db_query(DB,$sql);
		$userIdU = mysql_insert_id();
		
		echo '
		<form name="YaadPay" action="https://icom.yaad.net/cgi-bin/yaadpay/yaadpay.pl" method="post" >
		<INPUT TYPE="hidden" NAME="Masof" value="4500019225" >
		<INPUT TYPE="hidden" NAME="action" value="pay" >
		<INPUT TYPE="hidden" NAME="Amount" value="'.$TOTALprice.'" >
		<INPUT TYPE="hidden" NAME="Order" value="'.$userIdU.'" >
		<INPUT TYPE="hidden" NAME="Info" value ="'.$desc.'" >
		<input type="hidden" name="SendHesh" value="true">
		<INPUT TYPE="hidden" NAME="Tash" value="'.$Tashlomim.'" >
		<input type="hidden" name="heshDesc" value="'.$desc.'">
		<INPUT TYPE="hidden" NAME="street" value="'.$dataUser['address'].'" >
		<INPUT TYPE="hidden" NAME="city" value="'.$dataCity['name'].'" >
		<INPUT TYPE="hidden" NAME="phone" value="'.$dataUser['phone'].'" >
		<INPUT TYPE="hidden" NAME="email" value="'.$dataUser['email'].'" >
		<INPUT TYPE="hidden" NAME="MoreData" value="True" >
		</form>
		<p align=right dir=rtl class=maintext>טוען טופס...</p>
		
		<script>YaadPay.submit();</script>
		';
	}
}


function payWithCredits()
{
	$sql = "SELECT id,end_date,address,city,email,phone FROM users WHERE deleted=0 AND status=0 AND unk = '".UNK."'";
	$usersRes = mysql_db_query(DB,$sql);
	$dataUser = mysql_fetch_array($usersRes);
	
	$sql = "SELECT name FROM cities WHERE id = '".$dataUser['city']."' ";
	$cityRes = mysql_db_query(DB,$sql);
	$dataCity = mysql_fetch_array($cityRes);
	
	
	$ex_end = explode("-" , $dataUser['end_date'] );
	$DateDiffAry = GetDateDifference(date(m).'/'.date(d).'/'.date(Y) , $ex_end[1].'/'.$ex_end[2].'/'.$ex_end[0] ); 
	
	$sql = "SELECT hostPriceMon,domainPrice,domainEndDate FROM user_bookkeeping WHERE unk = '".UNK."'";
	$res = mysql_db_query(DB, $sql);
	$dataPrice = mysql_fetch_array($res);
	
	$ex_endDOMAIN = explode("-" , $dataPrice['domainEndDate'] );
	$DateDiffAry_domain = GetDateDifference(date(m).'/'.date(d).'/'.date(Y) , $ex_endDOMAIN[1].'/'.$ex_endDOMAIN[2].'/'.$ex_endDOMAIN[0] ); 
	
	$gotoPay = "0";
	
	if( $DateDiffAry['DaysSince'] <= 30 && $DateDiffAry['DaysSince'] > -30 && $dataPrice['hostPriceMon'] > 0 && $_GET['payToType'] == "1" )
	{
		$month = $dataPrice['hostPriceMon'];
		$totalYear_whitoutMAAM = $dataPrice['hostPriceMon']*12;
		$maam = (18*$totalYear_whitoutMAAM)/100;
		$TOTALpriceTemp = $totalYear_whitoutMAAM + $maam;
		$TOTALprice = myround($TOTALpriceTemp);
		$desc = "אחסון שנתי";
		$payToType = "1";
		$Tashlomim = "12";
		
	}
	
	if( $DateDiffAry_domain['DaysSince'] <= 30 && $DateDiffAry_domain['DaysSince'] > -30 && $dataPrice['domainPrice'] > 0 && $_GET['payToType'] == "2")
	{
		$maam = (18*$dataPrice['domainPrice'])/100;
		$TOTALpriceTemp = $dataPrice['domainPrice'] + $maam;
		$TOTALprice = myround($TOTALpriceTemp);
		$desc = "דומיין - תשלום שנתי";
		$payToType = "2";
		$Tashlomim = "1";
		
	}
	
	$creditMoney = new creditMoney;
	$credits = $creditMoney->get_creditMoney("users" , UNK , "1");
	
	if( $credits >= $TOTALprice )
	{
		$notar_cr = $credits - $TOTALprice;
		echo "יש לך ".$credits." קרדיטים<br>הנך צריך לשלם ".$TOTALprice." שח<br>האם לנצל את הקרדיטים לכיסוי כל התשלום?<br><br>לאחר התשלום ישארו לך ".$notar_cr." קרדיטים";
		echo "<br><br><a href='index.php?main=payWithCredits&payToType=".$payToType."&pay100=1&unk=".UNK."&sesid=".SESID."' class='maintext'>לחץ כאן להמשך ולחיוב כל הסכום החוב</a>";
	}
	elseif( $credits > 0 && $TOTALprice > $credits )
	{
		$notar_cr = $TOTALprice - $credits;
		echo "יש לך ".$credits." קרדיטים<br>הנך צריך לשלם ".$TOTALprice." שח<br>סכום הקרדיטים לא מכסה את מלאו הסכום<br><br>";
		echo "<a href='index.php?main=payWithCredits&payToType=".$payToType."&payHel=1&unk=".UNK."&sesid=".SESID."' class='maintext'>לחץ כאן לתשלום של ".$notar_cr." שח לאחר ניקוי כל הקרדיטים</a>";
	}
	
	if( $_GET['pay100'] == "1" )
	{
		if( $_GET['payToType'] == "1" )
		{
			$creditMoney->change_credit( "users" , $dataUser['id'] , "-".$TOTALprice , $desc );
			
			$ex_end = explode("-" , $dataUser['end_date'] );
			$new_enddate = date('Y-m-d' , mktime('0', '0', '0', $ex_end[1] , $ex_end[2] , $ex_end[0] + 1 ) );
			
			$sql = "UPDATE users SET end_date = '".$new_enddate."' WHERE id = '".$dataUser['id']."' ";
			$res = mysql_db_query(DB, $sql);
			
			$sql = "SELECT DATE_FORMAT( end_date , '%d/%m/%Y' ) as newEndDate FROM users WHERE unk = '".UNK."' ";
			$res = mysql_db_query( DB , $sql );
			$data344 = mysql_fetch_array($res);
			
			echo "<p align=right dir=rtl class=maintext>
			תשלום באמצעות הקרדיטים בוצע בהצלחה,<br>
			סיום תקופת האכסון האתר עודכן ל: ".$data344['newEndDate'].".
			</p>";
		}
		elseif(  $_GET['payToType'] == "2" )
		{
			$creditMoney->change_credit( "users" , $dataUser['id'] , "-".$TOTALprice , $desc );
			
			$ex_end = explode("-" , $dataPrice['domainEndDate'] );
			$new_enddate = date('Y-m-d' , mktime('0', '0', '0', $ex_end[1] , $ex_end[2] , $ex_end[0] + 1 ) );
			
			$sql = "UPDATE user_bookkeeping SET domainEndDate = '".$new_enddate."' WHERE unk = '".UNK."' ";
			$res = mysql_db_query(DB, $sql);
			
			$sql = "SELECT DATE_FORMAT( domainEndDate , '%d/%m/%Y' ) as newEndDate FROM user_bookkeeping WHERE unk = '".UNK."' ";
			$res = mysql_db_query( DB , $sql );
			$data = mysql_fetch_array($res);
			
			echo "<p align=right dir=rtl class=maintext>
			תשלום באמצעות הקרדיטים בוצע בהצלחה,<br>
			סיום אחזקת דומיין עודכן ל: ".$data['newEndDate'].".
			</p>";
		}
	}
	elseif(  $_GET['payHel'] == "1" )
	{
		$notar_cr = $TOTALprice - $credits;
		
		$new_pay_num = $payToType + 5;
		$sql = "INSERT INTO ilbizPayByCCLog ( sumTotal , payDate , description , payToType , userId , gotoUrlParamter ) VALUES (
			'".$notar_cr."' , NOW() , '".addslashes($desc)." | שימוש ב ".$credits." שח הנחה על חשבון הקרדיטים' , '".$new_pay_num."' , '".$dataUser['id']."' , 'unk=".UNK."&sesid=".SESID."'
		)";
		$res = mysql_db_query(DB,$sql);
		$userIdU = mysql_insert_id();
		
		echo '
		<form name="YaadPay" action="https://icom.yaad.net/cgi-bin/yaadpay/yaadpay.pl" method="post" >
		<INPUT TYPE="hidden" NAME="Masof" value="4500019225" >
		<INPUT TYPE="hidden" NAME="action" value="pay" >
		<INPUT TYPE="hidden" NAME="Amount" value="'.$notar_cr.'" >
		<INPUT TYPE="hidden" NAME="Order" value="'.$userIdU.'" >
		<INPUT TYPE="hidden" NAME="Info" value ="'.$desc.'" >
		<input type="hidden" name="SendHesh" value="true">
		<INPUT TYPE="hidden" NAME="Tash" value="'.$Tashlomim.'" >
		<input type="hidden" name="heshDesc" value="'.$desc.'">
		<INPUT TYPE="hidden" NAME="street" value="'.$dataUser['address'].'" >
		<INPUT TYPE="hidden" NAME="city" value="'.$dataCity['name'].'" >
		<INPUT TYPE="hidden" NAME="phone" value="'.$dataUser['phone'].'" >
		<INPUT TYPE="hidden" NAME="email" value="'.$dataUser['email'].'" >
		<INPUT TYPE="hidden" NAME="MoreData" value="True" >
		</form>
		<p align=right dir=rtl class=maintext>טוען טופס...</p>
		
		<script>YaadPay.submit();</script>
		';
	}
}



function payWithCC_1ok()
{
	$sql = "SELECT DATE_FORMAT( end_date , '%d/%m/%Y' ) as newEndDate FROM users WHERE unk = '".UNK."' ";
	$res = mysql_db_query( DB , $sql );
	$data = mysql_fetch_array($res);
	
	echo "<p align=right dir=rtl class=maintext>
	התשלום בוצע בהצלחה,<br>
	סיום תקופת האכסון האתר עודכן ל: ".$data['newEndDate'].".
	</p>";
}


function payWithCC_2ok()
{
	$sql = "SELECT DATE_FORMAT( domainEndDate , '%d/%m/%Y' ) as newEndDate FROM user_bookkeeping WHERE unk = '".UNK."' ";
	$res = mysql_db_query( DB , $sql );
	$data = mysql_fetch_array($res);
	
	echo "<p align=right dir=rtl class=maintext>
	התשלום בוצע בהצלחה,<br>
	סיום אחזקת דומיין עודכן ל: ".$data['newEndDate'].".
	</p>";
}

function payWithCC_1er()
{
	echo "<p align=right dir=rtl class=maintext>
	התשלום נכשל,<br><br>
	אנא נסה שנית.<br>
	<a href='index.php?main=payWithCC&payToType=1&unk=".UNK."&sesid=".SESID."' class='maintext'>חזרה לטופס</a>
	</p>";
}


function payWithCC_2er()
{
	echo "<p align=right dir=rtl class=maintext>
	התשלום נכשל,<br><br>
	אנא נסה שנית.<br>
	<a href='index.php?main=payWithCC&payToType=2&unk=".UNK."&sesid=".SESID."' class='maintext'>חזרה לטופס</a>
	</p>";
}

function open_contact_for_1_credit()
{
	$creditMoney = new creditMoney;
	$credits = $creditMoney->get_creditMoney("users" , UNK , "1");
	
	$sql = "SELECT id FROM users WHERE unk = '".UNK."' ";
	$res = mysql_db_query(DB,$sql);
	$dataUser = mysql_fetch_array($res);
	
	if( $credits > 0 )
	{
		$creditMoney->change_credit( "users" , $dataUser['id'] , "-1" , "קניית פרטי לקוח" );
		
		$sql = "UPDATE estimate_form SET open_by_credit = '1' WHERE id = '".$_GET['cd']."' ";
		$res = mysql_db_query(DB, $sql);
	}
	
	echo "<script>window.location.href='index.php?main=group_buy_sent_form&type=".$_GET['type']."&unk=".UNK."&sesid=".SESID."';</script>";
		exit;
}

function group_buy_sent_form()
{
	$creditMoney = new creditMoney;
	$credits = $creditMoney->get_creditMoney("users" , UNK , "1");
	
	
	if( UNK == "285240640927706447" )
	{
		$sql = "SELECT gb.product_name , e.id, e.name , e.phone , e.email, e.city , e.note , DATE_FORMAT(e.insert_date,'%d-%m-%Y %H:%i') as in_date FROM 10_service_group_buy as gb , estimate_form as e , users as u WHERE 
			u.id = gb.user_id AND
			e.10service_group_product_id = gb.id
		";
		$res = mysql_db_query(DB,$sql);
	}
	else
	{
		$sql = "SELECT gb.product_name , e.id, e.name , e.phone , e.email, e.city , e.note , e.open_by_credit , DATE_FORMAT(e.insert_date,'%d-%m-%Y %H:%i') as in_date FROM 10_service_group_buy as gb , estimate_form as e , users as u WHERE 
			u.id = gb.user_id AND
			u.unk = '".UNK."' AND
			e.10service_group_product_id = gb.id
		";
		$res = mysql_db_query(DB,$sql);
	}
	
	if( $_SERVER[REMOTE_ADDR] == DEVELOP_IP )
	{
		echo "<table border=0 cellpadding=0 cellspacing=0 class=maintext>";
			
			echo "<tr>";
				echo "<td colspan=7>פתיחת כל פרטי הלקוח עלותה קרדיט אחד</td>";
			echo "</tr>";
			echo "<tr><td colspan=7 height=10></td></tr>";
			if( $credits == "0" )
			{
				echo "<tr>";
					echo "<td colspan=7>למה אני לא רואה את פרטי הלקוחות? יש צורך בקרדיטים, <a href='index.php?main=buy_credits&type=credits_10service&unk=".UNK."&sesid=".SESID."' class='maintext'>לפרטים נוספים</a></td>";
				echo "</tr>";
			}
			echo "<tr><td colspan=7 height=10></td></tr>";
			
			while( $data = mysql_fetch_array($res) )
			{
				$sql2 = "SELECT name FROM newCities WHERE id = '".$data['city']."' "; 
				$res2 = mysql_db_query(DB,$sql2);
				$data2 = mysql_fetch_array($res2);
				
				$phone = substr_replace( $data['phone'] , "****" , 4 , 4 );
				
				$temp_email = explode( "@" , stripslashes($data['email']) );
				$len = strlen($temp_email[0]);
				$spar = "";
				for( $i=0 ; $i<=$len-2 ; $i++ )
					$spar .= "*";
				$email = substr_replace( $temp_email[0] , $spar , 1 , strlen($spar) );
				
				if( UNK == "285240640927706447" )
				{
					$dis_phone = $data['phone'];
					$dis_email = $data['email'];
				}
				else
				{
					$dis_phone = ( $data['open_by_credit'] == "1" ) ? $data['phone'] : $phone;
					$dis_email = ( $data['open_by_credit'] == "1" ) ? $data['email'] : $email."@".$temp_email[1];
				}
				echo "<tr>";
					echo "<td colspan=7><u>".stripslashes($data['product_name'])."</u></td>";
				echo "</tr>";
				echo "<tr><td colspan=7 height=5></td></tr>";
				echo "<tr>";
					echo "<td valign=top>טלפון:</td>";
					echo "<td width=10></td>";
					echo "<td valign=top dir=ltr align=right>".$dis_phone."</td>";
					echo "<td width=30></td>";
					echo "<td valign=top>עיר:</td>";
					echo "<td width=10></td>";
					echo "<td valign=top>".stripslashes($data2['name'])."</td>";
				echo "</tr>";
				echo "<tr><td colspan=7 height=5></td></tr>";
				echo "<tr>";
					echo "<td valign=top>אימייל:</td>";
					echo "<td width=10></td>";
					echo "<td valign=top dir=ltr align=right>".$dis_email."</td>";
					echo "<td width=30></td>";
					echo "<td valign=top>פרטים נוספים:</td>";
					echo "<td width=10></td>";
					echo "<td valign=top>".stripslashes($data['note'])."</td>";
				echo "</tr>";
				echo "<tr><td colspan=7 height=5></td></tr>";
				echo "<tr>";
					echo "<td style='font-size: 12px;' colspan=3>".stripslashes($data['name']).", ".stripslashes($data['in_date'])."</td>";
					echo "<td width=30></td>";
					echo "<td colspan=3>";
						if( $credits > "0" && UNK != "285240640927706447" && $data['open_by_credit'] == "0" )
						{
							echo "<a href='index.php?main=open_contact_for_1_credit&cd=".$data['id']."&type=".$_GET['type']."&unk=".UNK."&sesid=".SESID."' class='maintext'>פתח פרטי קשר בקרדיט אחד בלבד!</a>";
						}
					echo "</td>";
				echo "</tr>";
				echo "<tr><td colspan=7 height=3></td></tr>";
				echo "<tr><td colspan=7><hr width=100% size=1 color=#eeeeee></td></tr>";
				echo "<tr><td colspan=7 height=3></td></tr>";
			}
			
			echo "<tr>";
				echo "<td>";
			echo "</tr>";
			
		echo "</table>";
	}
	else
	{
		echo "<table border=0 cellpadding=0 cellspacing=0 class=maintext>";
		
		while( $data = mysql_fetch_array($res) )
		{
			$sql2 = "SELECT name FROM newCities WHERE id = '".$data['city']."' "; 
			$res2 = mysql_db_query(DB,$sql2);
			$data2 = mysql_fetch_array($res2);
			
			echo "<tr>";
				echo "<td colspan=7><u>".stripslashes($data['product_name'])."</u></td>";
			echo "</tr>";
			echo "<tr><td colspan=7 height=5></td></tr>";
			echo "<tr>";
				echo "<td valign=top>טלפון:</td>";
				echo "<td width=10></td>";
				echo "<td valign=top>".stripslashes($data['phone'])."</td>";
				echo "<td width=30></td>";
				echo "<td valign=top>עיר:</td>";
				echo "<td width=10></td>";
				echo "<td valign=top>".stripslashes($data2['name'])."</td>";
			echo "</tr>";
			echo "<tr><td colspan=7 height=5></td></tr>";
			echo "<tr>";
				echo "<td valign=top>אימייל:</td>";
				echo "<td width=10></td>";
				echo "<td valign=top>".stripslashes($data['email'])."</td>";
				echo "<td width=30></td>";
				echo "<td valign=top>פרטים נוספים:</td>";
				echo "<td width=10></td>";
				echo "<td valign=top>".stripslashes($data['note'])."</td>";
			echo "</tr>";
			echo "<tr><td colspan=7 height=5></td></tr>";
			echo "<tr>";
				echo "<td style='font-size: 12px;' colspan=7>".stripslashes($data['name']).", ".stripslashes($data['in_date'])."</td>";
				
			echo "</tr>";
			echo "<tr><td colspan=7 height=3></td></tr>";
			echo "<tr><td colspan=7><hr width=100% size=1 color=#eeeeee></td></tr>";
			echo "<tr><td colspan=7 height=3></td></tr>";
		}
		
		echo "<tr>";
			echo "<td>";
		echo "</tr>";
		
	echo "</table>";
	}
}


function user_portal_cats()
{
	$sql = "select id,portal_active from users where deleted = '0' and unk = '".UNK."' ";
	$res = mysql_db_query(DB,$sql);
	$data = mysql_fetch_array($res);
	
	$sql = "select cat_name,id from biz_categories where father = 0 and status = 1 AND id != '1758' AND id != '616' AND id != '1190' AND id != '869' AND id != '903'";
	$res_father = mysql_db_query(DB,$sql);
	
	$cat_list = "<form action='index.php' method='post' name='update_portal_cats'>";
	$cat_list .= "<input type='hidden' name='unk' value='".UNK."'>";
	$cat_list .= "<input type='hidden' name='sesid' value='".SESID."'>";
	$cat_list .= "<input type='hidden' name='main' value='user_portal_cats_DB'>";
	$cat_list .= "<input type='hidden' name='type' value='".$_GET['type']."'>";
	$cat_list .= "<table border=\"0\" cellpadding=\"0\" cellspacing=\"0\" width=\"100%\" class='maintext'>";
		$cat_list .= "<tr>";
			$cat_list .= "<td>להסרת קטגוריות יש לשלוח פנייה לשירות הלקוחות עם רשימת הקטגוריות אותם תרצו להסיר<br><br>";
			
				$cat_list .= "<ul style=\"list-style:none\" class=\"dhtmlTree\">";
					while( $data_father = mysql_fetch_array($res_father) )
					{
						
						$sql = "select cat_id from user_cat where user_id = '".$data['id']."' and cat_id = '".$data_father['id']."'";
						$res_cat_id = mysql_db_query(DB,$sql);
						$data_cat_id = mysql_fetch_array($res_cat_id);
						
						$selected1 = ( $data_cat_id['cat_id'] == $data_father['id'] ) ? "checked" : "";
						
						$cat_list .= "<li><img src=\"options.fiels/plus.jpg\" onclick=\"htmldb_ToggleWithImage(this,'treeCAT".$data_father['id']."')\" class=\"pseudoButtonInactive\" />
						".stripslashes($data_father['cat_name'])."
						<input type=\"checkbox\" name=\"select_cat[".$data_father['id']."]\" value=\"1\" ".$selected1.">
						</li>";
						
						$sql = "select cat_name,id from biz_categories where father = ".$data_father['id']." and status = 1";
						$res_father_cat = mysql_db_query(DB,$sql);
						
						$cat_list .= "<ul id=\"treeCAT".$data_father['id']."\" htmldb:listlevel=\"2\" style=\"padding-right:15px;list-style:none;display:none;\" class=\"dhtmlTree\">";
							while( $data_father_cat = mysql_fetch_array($res_father_cat) )
							{
								$sql = "select cat_id from user_cat where user_id = '".$data['id']."' and cat_id = '".$data_father_cat['id']."'";
								$res_cat_id = mysql_db_query(DB,$sql);
								$data_cat_id = mysql_fetch_array($res_cat_id);
								
								$selected2 = ( $data_cat_id['cat_id'] == $data_father_cat['id'] ) ? "checked" : "";
						
								$sql = "select cat_name,id from biz_categories where father = '".$data_father_cat['id']."' and status = '1'";
								$res_father_tat_cat = mysql_db_query(DB,$sql);
								$num_father_tat_cat = mysql_num_rows($res_father_tat_cat);
								
								if( $num_father_tat_cat > 0 )
								{
									$cat_list .= "<li>
									<img src=\"options.fiels/plus.jpg\" onclick=\"htmldb_ToggleWithImage(this,'treeF_CAT".$data_father_cat['id']."')\" class=\"pseudoButtonInactive\" />
									".$data_father_cat['cat_name']."
									<input type=\"checkbox\" name=\"select_cat[".$data_father_cat['id']."]\" value=\"1\" ".$selected2."></li>";
									
									$cat_list .= "<ul id=\"treeF_CAT".$data_father_cat['id']."\" htmldb:listlevel=\"3\" style=\"padding-right:15px;list-style:none;display:none;\" class=\"dhtmlTree\">";
									while( $data_father_tat_cat = mysql_fetch_array($res_father_tat_cat) )
									{
										$sql = "select cat_id from user_cat where user_id = '".$data['id']."' and cat_id = '".$data_father_tat_cat['id']."'";
										$res_cat_id = mysql_db_query(DB,$sql);
										$data_cat_id = mysql_fetch_array($res_cat_id);
										
										$selected3 = ( $data_cat_id['cat_id'] == $data_father_tat_cat['id'] ) ? "checked" : "";
										
										$cat_list .= "<li><img src=\"options.fiels/node.jpg\" /><input type=\"checkbox\" name=\"select_cat[".$data_father_tat_cat['id']."]\" value=\"1\" ".$selected3.">".$data_father_tat_cat['cat_name']."</li>";
									}
									$cat_list .= "</ul>";
								}
								else
								{
									$cat_list .= "<li><img src=\"options.fiels/node.jpg\" />
									<input type=\"checkbox\" name=\"select_cat[".$data_father_cat['id']."]\" value=\"1\" ".$selected2.">".$data_father_cat['cat_name']."</li>";
								}
							}
						$cat_list .= "</ul>";
					}
				$cat_list .= "</ul>";
			$cat_list .= "</td>";
		$cat_list .= "</tr>";
		$cat_list .= "<tr>";
			$cat_list .= "<td><input type='submit' value='שמירה' class='input_style' style='width: 100px;'></td>";
		$cat_list .= "</tr>";
	$cat_list .= "</table>";
	$cat_list .= "</form>";
	
	echo $cat_list;
}


function user_portal_cats_DB()
{
	$sql = "select id from users where unk = '".UNK."'";
	$res_user_id = mysql_db_query(DB,$sql);
	$data_user_id = mysql_fetch_array($res_user_id);
	$user_id = $data_user_id['id'];
	$catSInStr = "";
	$catSInI = 0;	
	foreach( $_POST['select_cat'] as $val => $key )
	{
		if( $key == "1" )
		{
			if($catSInI!=0){
				$catSInStr .= ",";
			}
			$catSInStr .= $val;
			$catSInI++;
			$sqlCheck = "SELECT * FROM user_cat WHERE user_id = '".$user_id."' AND cat_id = '".$val."' ";
			$resCheck = mysql_db_query(DB,$sqlCheck);
			$dataCheck = mysql_fetch_array($resCheck);
			
			if( $dataCheck['user_id'] == "" )
			{
				$sql = "insert into user_cat ( user_id , cat_id ) values ( '".$user_id."' , '".$val."' )";
				$res_insert = mysql_db_query(DB,$sql);
			}
		}
	}
	if($catSInI != 0){
		$inStr =  " AND cat_id NOT IN (".$catSInStr.") ";
	}
	
	$sqlCheck = "DELETE FROM user_cat WHERE user_id = '".$user_id."' ".$inStr;
	$resCheck = mysql_db_query(DB,$sqlCheck);	
	
	echo "<script>window.location.href='index.php?main=user_portal_cats&type=".$_POST['unk']."&unk=".UNK."&sesid=".SESID."';</script>";
		exit;
}


function user_portal_newCities()
{
	$sql = "select id,portal_active from users where deleted = '0' and unk = '".UNK."' ";
	$res = mysql_db_query(DB,$sql);
	$data = mysql_fetch_array($res);
	
	$sql = "select name,id from newCities where father = 0 ORDER BY place, name";
	$res_father = mysql_db_query(DB,$sql);
	
	$city_list = "<form action='index.php' method='post' name='update_portal_newCities'>";
	$city_list .= "<input type='hidden' name='unk' value='".UNK."'>";
	$city_list .= "<input type='hidden' name='sesid' value='".SESID."'>";
	$city_list .= "<input type='hidden' name='main' value='user_portal_newCities_DB'>";
	$city_list .= "<input type='hidden' name='type' value='".$_GET['type']."'>";
	$city_list .= "<table border=\"0\" cellpadding=\"0\" cellspacing=\"0\" width=\"100%\" class='maintext'>";
		$city_list .= "<tr>";
			$city_list .= "<td>להסרת ערים יש לשלוח פנייה לשירות הלקוחות עם רשימת הקטגוריות אותם תרצו להסיר<br><br>";
			
				$city_list .= "<ul style=\"list-style:none\" class=\"dhtmlTree\">";
					while( $data_father = mysql_fetch_array($res_father) )
					{
						
						$sql = "select city_id from user_lead_cities where user_id = '".$data['id']."' and city_id = '".$data_father['id']."'";
						$res_city_id = mysql_db_query(DB,$sql);
						$data_city_id = mysql_fetch_array($res_city_id);
						
						$selected1 = ( $data_city_id['city_id'] == $data_father['id'] ) ? "checked" : "";
						
						$city_list .= "<li><img src=\"options.fiels/plus.jpg\" onclick=\"htmldb_ToggleWithImage(this,'treeCAT".$data_father['id']."')\" class=\"pseudoButtonInactive\" />
						".stripslashes($data_father['name'])."
						<input type=\"checkbox\" name=\"select_city[".$data_father['id']."]\" value=\"1\" ".$selected1.">
						</li>";
						
						$sql = "select name,id from newCities where father = ".$data_father['id']." ORDER BY place,name";
						$res_father_city = mysql_db_query(DB,$sql);
						
						$city_list .= "<ul id=\"treeCAT".$data_father['id']."\" htmldb:listlevel=\"2\" style=\"padding-right:15px;list-style:none;display:none;\" class=\"dhtmlTree\">";
							while( $data_father_city = mysql_fetch_array($res_father_city) )
							{
								$sql = "select city_id from user_lead_cities where user_id = '".$data['id']."' and city_id = '".$data_father_city['id']."'";
								$res_city_id = mysql_db_query(DB,$sql);
								$data_city_id = mysql_fetch_array($res_city_id);
								
								$selected2 = ( $data_city_id['city_id'] == $data_father_city['id'] ) ? "checked" : "";
						
								
								$city_list .= "<li><img src=\"options.fiels/node.jpg\" />
								<input type=\"checkbox\" name=\"select_city[".$data_father_city['id']."]\" value=\"1\" ".$selected2.">".$data_father_city['name']."</li>";
							
							}
						$city_list .= "</ul>";
					}
					
				$city_list .= "</ul>";
			$city_list .= "</td>";
		$city_list .= "</tr>";
		$city_list .= "<tr>";
			$city_list .= "<td><input type='submit' value='שמירה' class='input_style' style='width: 100px;'></td>";
		$city_list .= "</tr>";
	$city_list .= "</table>";
	$city_list .= "</form>";
	
	echo $city_list;
}


function user_portal_newCities_DB()
{
	$sql = "select id from users where unk = '".UNK."'";
	$res_user_id = mysql_db_query(DB,$sql);
	$data_user_id = mysql_fetch_array($res_user_id);
	$user_id = $data_user_id['id'];	
	$citiesInStr = "";
	$citiesInI = 0;
	foreach( $_POST['select_city'] as $val => $key )
	{

		if( $key == "1" )
		{
			
			if($citiesInI!=0){
				$citiesInStr .= ",";
			}
			$citiesInStr .= $val;
			$citiesInI++;			
			$sqlCheck = "SELECT * FROM user_lead_cities WHERE user_id = '".$user_id."' AND city_id = '".$val."' ";
			$resCheck = mysql_db_query(DB,$sqlCheck);
			$dataCheck = mysql_fetch_array($resCheck);
			
			if( $dataCheck['user_id'] == "" )
			{
				$sql = "insert into user_lead_cities ( user_id , city_id ) values ( '".$user_id."' , '".$val."' )";
				$res_insert = mysql_db_query(DB,$sql);
			}
		}

		
	}
	if($citiesInI != 0){
		$inStr =  " AND city_id NOT IN (".$citiesInStr.") ";
	}
	$sqlCheck = "DELETE FROM user_lead_cities WHERE user_id = '".$user_id."' ".$inStr;
	$resCheck = mysql_db_query(DB,$sqlCheck);
		
	echo "<script>window.location.href='index.php?main=user_portal_newCities&type=".$_POST['unk']."&unk=".UNK."&sesid=".SESID."';</script>";
		exit;
}


function link_menu_adv_settings()
{
	$start_father = '0';
	$light_vertion = false;
	$start_father_data = false;
	if(isset($_GET['light_vertion'])){
		$light_vertion = true;
	}	
	if(isset($_GET['start_father'])){
		$start_father = $_GET['start_father'];
		if($start_father!='0'){
			$sql = "SELECT * FROM users_links_menu_settings WHERE unk = '".UNK."' ".$andDeleted."  AND id=$start_father ORDER by place,id";
			$res = mysql_db_query(DB,$sql);
			$start_father_data = mysql_fetch_array($res);
		}
	}
	$andDeleted = " AND deleted = 0 ";
	if(isset($_GET['fixDeleted']) || $light_vertion){
		$andDeleted = "";
	}
	// first, check if user have settings
	$sql = "SELECT * FROM users_links_menu_settings WHERE unk = '".UNK."' ".$andDeleted."  AND father=$start_father ORDER by place,id";
	$res = mysql_db_query(DB,$sql);
	$check_num_regular = mysql_num_rows($res);
	
	$sql = "SELECT links_menu_right_spacing , links_menu_left_spacing , right_menu_width , left_menu_width FROM user_extra_settings WHERE unk = '".UNK."' ";
	$resUserSet = mysql_db_query(DB,$sql);
	$dataUserSet = mysql_fetch_array($resUserSet);
	
	$righ_menu_width = $dataUserSet['right_menu_width'] - $dataUserSet['links_menu_right_spacing'] - $dataUserSet['links_menu_left_spacing'];
	$left_menu_width = $dataUserSet['left_menu_width'] - $dataUserSet['links_menu_right_spacing'] - $dataUserSet['links_menu_left_spacing'];
	if(!$light_vertion){
		echo "<br><a href='index.php?main=link_menu_adv_settings&type=".$_REQUEST['type']."&light_vertion=1&start_father=0&unk=".UNK."&sesid=".SESID."'>לאתרים עם קישורים מרובים - לחץ כאן לעריכה קלה</a><br><br>";
	}
	else{
		echo "<br><a href='index.php?main=link_menu_adv_settings&type=".$_REQUEST['type']."&unk=".UNK."&sesid=".SESID."'>חזרה למוד עריכה רגיל</a><br><br>";
	}
	if($start_father_data){
		echo "<div style='padding:10px;border:1px solid gray; background:yellow;'>";
			echo "<h3>עריכת קישור אב: ".$start_father_data['link_name']."</h3>";
			echo "<br><a href='index.php?main=link_menu_adv_settings&type=".$_REQUEST['type']."&light_vertion=1&start_father=0&unk=".UNK."&sesid=".SESID."'>חזור לרשימת קישורים ראשית</a><br><br>";
		echo "</div>";
	}
	
	echo "<form action='index.php' name='link_menu_form' method='post' style='padding:0px; margin:0px;' enctype='multipart/form-data'>";
	if($light_vertion){
		echo "<input type='hidden' name='light_vertion' value='1'>";
	}
	if($start_father != '0'){
		echo "<input type='hidden' name='start_father' value='".$start_father."'>";
	}	
	echo "<input type='hidden' name='main' value='link_menu_adv_settings_DB'>";
	echo "<input type='hidden' name='type' value='".$_GET['type']."'>";
	echo "<input type='hidden' name='unk' value='".UNK."'>";
	echo "<input type='hidden' name='sesid' value='".SESID."'>";
	echo "<table cellpadding=0 cellspacing=0 border=0 class='maintext'>";
		
		
		echo "<tr>";
			echo "<td>הוראות להגדרות העיצוב:<br>
			רוחב של הרקעים והתמונות: <b>".$righ_menu_width."</b> ( הרוחב תלוי ברוחב התפריט + ברווחים שהוגדרו במערכת ניהול )<br>
			גובה משתנה דינמית לפי הגדרת התמונה או הרקע, ברירת מחדל: <b>25</b> פקסיל</td>";
		echo "</tr>";
		echo "<tr><td height=30></td></tr>";
		
		echo "<tr><td>";
		if(!$light_vertion){
			echo "<a href='index.php?main=link_menu_adv_settings&type=".$_POST['type']."&unk=".UNK."&fixDeleted=1&sesid=".SESID."'>תקן קישורים מחוקים</a>";
		}
		echo "</td></tr>";
		// add new link
		echo "<tr>";
			echo "<td style='font-size: 16px;'><b>הוסף כפתור חדש</b></td>";
		echo "</tr>";
		echo "<tr><td height=10></td></tr>";
		echo "<tr>";
			echo "<td>";
				echo print_input_text_link_settings("add_new[0]");
			echo "</td>";
		echo "</tr>";
		
		echo "<tr><td height=30></td></tr>";
		
		
		
		// use defualt link menu
		if( $check_num_regular == "0" )
		{
			echo "<tr>";
				echo "<td style='font-size: 16px;'><b>רשימת קישורים <u>ברירת מחדל</u></b></td>";
			echo "</tr>";
			echo "<tr><td height=10></td></tr>";
		
			echo "<tr>";
				echo "<td>";
					if(isset($_GET['add_links_from_pages'])){
						echo user_defualt_settings();
					}
					else{
						echo "לא קיימים לינקים.<br/>";
						echo "<b>שים לב:</b> במצב כזה, יופיעו אוטומטית לינקים לעמודי האתר. הוסף לינקים ידנית כדי להמנע מהמצב.";
						echo "<a href='index.php?main=link_menu_adv_settings&type=".$_POST['type']."&unk=".UNK."&add_links_from_pages=1&sesid=".SESID."'>";
							echo "לחץ כאן להוספה מהירה של לינקים אל עמודי האתר.";
						echo "</a>";
						echo "<br/><br/><br/><br/>";
					}
				echo "</td>";
			echo "</tr>";
		}
		else
		{
			echo "<tr>";
				echo "<td style='font-size: 16px;'><b>רשימת קישורים</b></td>";
			echo "</tr>";
			echo "<tr><td height=10></td></tr>";
			
			echo "<tr>";
				echo "<td>";
					while( $data = mysql_fetch_array( $res ) )
					{
						$params['data'] = $data;
						
						echo print_input_text_link_settings("up[".$data['id']."]" , $params);
						if($light_vertion && $start_father =='0'){
							echo "<br><a href='index.php?main=link_menu_adv_settings&type=".$_REQUEST['type']."&light_vertion=1&start_father=".$data['id']."&unk=".UNK."&sesid=".SESID."'>פתח תתי קישורים</a><br><br>";
						}
						else{
							echo "<br><a href='javascript:void(0)' onclick='more_links_adv_settings_open(\"open_tat_".$data['id']."\")'>פתח תתי קישורים</a><br><br>";
							
							$sql2 = "SELECT * FROM users_links_menu_settings WHERE unk = '".UNK."' ".$andDeleted." AND father='".$data['id']."' ORDER by place,id";
							$res2 = mysql_db_query(DB,$sql2);
							
							echo "<div id='open_tat_".$data['id']."' style='display: none; background-color: #eeeeee;'>";
							while( $data2 = mysql_fetch_array( $res2 ) )
							{
								$params['data'] = $data2;
								echo "<div style='padding-right:10px;'>";
								echo print_input_text_link_settings("up[".$data2['id']."]" , $params);
								echo "<br><a href='javascript:void(0)' onclick='more_links_adv_settings_open(\"open_tat_".$data2['id']."\")'>פתח תתי קישורים</a><br><br>";
								echo "<br><br></div>";
								
								$sql3 = "SELECT * FROM users_links_menu_settings WHERE unk = '".UNK."' ".$andDeleted." AND father='".$data2['id']."' ORDER by place,id";
								$res3 = mysql_db_query(DB,$sql3);
								
								while( $data3 = mysql_fetch_array( $res3 ) )
								{
									$params['data'] = $data3;
									echo "<div style='padding-right:20px;'>";
									echo print_input_text_link_settings("up[".$data3['id']."]" , $params);
									echo "<br><br></div>";
								}
								
								
							}
							echo "</div>";
						}
					}
				echo "</td>";
			echo "</tr>";
		}
		
		echo "<tr>";
			echo "<td><input type='submit' value='שמור שינויים'></td>";
		echo "</tr>";
		
	echo "</table>";
	echo "</form>";
	
}


function link_menu_adv_settings_DB()
{
	$start_father = '0';
	$light_vertion = false;
	if(isset($_REQUEST['light_vertion'])){
		$light_vertion = true;
	}	
	if(isset($_REQUEST['start_father'])){
		$start_father = $_REQUEST['start_father'];
	}
	$add_new = $_POST['add_new'];
	if( is_array($add_new) )
	{
		foreach( $add_new as $key=> $val )
		{
			if( $val['link_name'] != "" )
			{
				$sql = "INSERT INTO users_links_menu_settings ( unk , father, link_name, link_url, bgcolor, bgOver_color, font_size, font_bold, 
				font_color, font_over, font_underline, hide, place, open_target ) VALUES ( 
				'".UNK."' , '".mysql_r_e_s($val['father'])."' , '".mysql_r_e_s($val['link_name'])."' , '".mysql_r_e_s($val['link_url'])."' , 
				'".mysql_r_e_s($val['bgcolor'])."' , '".mysql_r_e_s($val['bgOver_color'])."' , '".mysql_r_e_s($val['font_size'])."' , '".mysql_r_e_s($val['font_bold'])."' , 
				'".mysql_r_e_s($val['font_color'])."' , '".mysql_r_e_s($val['font_over'])."' , '".mysql_r_e_s($val['font_underline'])."' , '".mysql_r_e_s($val['hide'])."' , 
				'".mysql_r_e_s($val['place'])."' , '".mysql_r_e_s($val['open_target'])."' )";
				$res = mysql_db_query(DB,$sql);
				$record_id = mysql_insert_id();
				
				$files_arr = array(
					"background" => "link_bg" ,
					"icon" => "icon" ,
					"img_link_button" => "img_button" ,
					"img_link_button_hover" => "img_button_over" ,
				);
				
				foreach( $files_arr as $name => $filesN )
				{
					$file_name = "add_new_".$key."_".$name;
					if( $_FILES[$file_name]['tmp_name'] != "" )
					{
						$exte = substr($_FILES[$file_name]['name'],(strpos($_FILES[$file_name]['name'],".")+1));
						$logo_name2 = $filesN."_adv_set_".$record_id.".".$exte;
						
						GlobalFunctions::upload_file_to_server($file_name , $logo_name2 , SERVER_PATH."/tamplate" );
						
						$sql = "UPDATE users_links_menu_settings SET ".$name." = '".$logo_name2."' WHERE id = '".$record_id."' limit 1";
						$res = mysql_db_query(DB,$sql);
					}
				}
			}
		}
	}
	
	$up = $_POST['up'];
	if( is_array($up) )
	{
		foreach( $up as $key=> $val )
		{
			if( $val['link_name'] != "" )
			{
				$sql = "UPDATE users_links_menu_settings SET father = '".mysql_r_e_s($val['father'])."' , link_name = '".mysql_r_e_s($val['link_name'])."' ,
				link_url = '".mysql_r_e_s($val['link_url'])."' , bgcolor = '".mysql_r_e_s($val['bgcolor'])."' , bgOver_color = '".mysql_r_e_s($val['bgOver_color'])."' ,
				font_size = '".mysql_r_e_s($val['font_size'])."' , font_bold = '".mysql_r_e_s($val['font_bold'])."' , 
				font_color = '".mysql_r_e_s($val['font_color'])."' , font_over = '".mysql_r_e_s($val['font_over'])."' , 
				font_underline = '".mysql_r_e_s($val['font_underline'])."' , hide = '".mysql_r_e_s($val['hide'])."' , place = '".mysql_r_e_s($val['place'])."' , 
				open_target = '".mysql_r_e_s($val['open_target'])."' WHERE id = '".$key."'";
				$res = mysql_db_query(DB,$sql);
				$record_id = $key;
				
				$files_arr = array(
					"background" => "link_bg" ,
					"icon" => "icon" ,
					"img_link_button" => "img_button" ,
					"img_link_button_hover" => "img_button_over" ,
				);
				
				foreach( $files_arr as $name => $filesN )
				{
					$file_name = "up_".$record_id."_".$name;
					
					if( $_FILES[$file_name]['tmp_name'] != "" )
					{
						$exte = substr($_FILES[$file_name]['name'],(strpos($_FILES[$file_name]['name'],".")+1));
						$logo_name2 = $filesN."_adv_set_".$record_id.".".$exte;
						
						GlobalFunctions::upload_file_to_server($file_name , $logo_name2 , SERVER_PATH."/tamplate" );
						
						$sql = "UPDATE users_links_menu_settings SET ".$name." = '".$logo_name2."' WHERE id = '".$record_id."' limit 1";
						$res = mysql_db_query(DB,$sql);
					}
				}
			}
		}
	}
	$start_father_url = "";
	$light_vertion_url = "";
	if(isset($_REQUEST['light_vertion'])){
		$light_vertion_url = "&light_vertion=1";
	}	
	if(isset($_REQUEST['start_father'])){
		$start_father_url = "&start_father=".$_REQUEST['start_father'];
	}
	echo "<script>window.location.href='index.php?main=link_menu_adv_settings&type=".$_POST['type'].$light_vertion_url.$start_father_url."&unk=".UNK."&sesid=".SESID."';</script>";
		exit;
}


function user_defualt_settings()
{
	$sql_links_list_content = "select name,type,hide_page from content_pages where type != 'text' and name != '' and type != 'contact' and type != 'gb' and deleted = '0' and unk = '".UNK."' ORDER BY place,id";
	$res_links_list_content = mysql_db_query(DB,$sql_links_list_content);
	$num_rows = mysql_num_rows($res_links_list_content);
	
	$sql = "select have_homepage,domain from users where unk = '".UNK."' and deleted = '0' and status = '0'";
	$res_users = mysql_db_query(DB,$sql);
	$data_users = mysql_fetch_array($res_users);
	
	$sql = "select * from user_words where unk = '".UNK."'";
	$res_words = mysql_db_query(DB,$sql);
	$data_words = mysql_fetch_array($res_words);
	$temp_word_hp = $word[LANG]['1_2_chapter_name_hp'];
	
	
	$temp_word_about = ( $data_words['id'] == "" ) ? $word[LANG]['1_2_chapter_name_about'] : stripslashes($data_words['word_about']);
	
	if( $data_users['have_homepage'] == 1)
		$arr_main_text = array(	"hp" => $temp_word_hp, "text" => $temp_word_about);
	else
		$arr_main_text = array(	"text" => $temp_word_about);
	
	$temp_word_articels = ( $data_words['id'] == "" ) ? $word[LANG]['1_2_chapter_name_articels'] : stripslashes($data_words['word_articels']);
	$temp_word_products = ( $data_words['id'] == "" ) ? $word[LANG]['1_2_chapter_name_products'] : stripslashes($data_words['word_products']);
	$temp_word_gallery = ( $data_words['id'] == "" ) ? $word[LANG]['1_2_chapter_name_gallery'] : stripslashes($data_words['word_gallery']);
	$temp_word_yad2 = ( $data_words['id'] == "" ) ? $word[LANG]['1_2_chapter_name_yad2'] : stripslashes($data_words['word_yad2']);
	$temp_word_sales = ( $data_words['id'] == "" ) ? $word[LANG]['1_2_chapter_name_sales'] : stripslashes($data_words['word_sales']);
	$temp_word_video = ( $data_words['id'] == "" ) ? $word[LANG]['1_2_chapter_name_video'] : stripslashes($data_words['word_video']);
	$temp_word_wanted = ( $data_words['id'] == "" ) ? $word[LANG]['1_2_chapter_name_jobs'] : stripslashes($data_words['word_wanted']);
	$temp_word_contact = ( $data_words['id'] == "" ) ? $word[LANG]['1_2_chapter_name_contact'] : stripslashes($data_words['word_contact']);
	$temp_word_gb = ( $data_words['id'] == "" ) ? "" : stripslashes($data_words['word_gb']);
	
	$arr_main = array(
		"arLi" => $temp_word_articels,
		"products" => $temp_word_products,
		"gallery" => $temp_word_gallery,
		"yad2" => $temp_word_yad2,
		"sales" => $temp_word_sales,
		"video" => $temp_word_video,
		"jobs" => $temp_word_wanted,
		"gb" => $temp_word_gb,
		"contact" => $temp_word_contact,
	);
		
		$count = 1;
		foreach( $arr_main_text as $val => $key )	{
			if( $key != "" )	{
				$tmp_hidde_name = "hidde_about";
				if( $data_words[$tmp_hidde_name] == "0" )
				{
					if( $data_extra_settings['estimateSite'] == "1" )
						$url = "http://".$data_users['domain'];
					else
						$url = "http://".$data_users['domain']."/index.php?m=".$val."&amp;t=text";
					
					$params['data']['link_name'] = $key;
					$params['data']['link_url'] = $url;
					echo print_input_text_link_settings( "add_new[".$count."]" , $params );
					echo "<br><br>";
					$count++;
				}
			}
		}
		
		while( $data_links_list_content = mysql_fetch_array($res_links_list_content) )
		{
			if( $data_links_list_content['hide_page'] == "0" )
			{
				$url_href = "http://".$data_users['domain']."/index.php?m=text&amp;t=".$data_links_list_content['type'];
				
				$params['data']['link_name'] = $data_links_list_content['name'];
				$params['data']['link_url'] = $url_href;
				echo print_input_text_link_settings( "add_new[".$count."]" , $params );
				echo "<br><br>";
				$count++;
			}
		}
		
		foreach( $arr_main as $val => $key )	{
			if( $key != "" )
			{
				$val_or_wanted = ( $val == "jobs" ) ? "wanted" : $val;
				$val_or_wanted_ar = ( $val == "arLi" ) ? "articels" : $val_or_wanted;
				$tmp_hidde_name = "hidde_".$val_or_wanted_ar;
				
				if( $val != "arLi" )
					$newVal = $val{0}.$val{1};
				else
					$newVal = $val;
				
				if( $data_words[$tmp_hidde_name] == "0" )
				{
					$params['data']['link_name'] = $key;
					$params['data']['link_url'] = "http://".$data_users['domain']."/index.php?m=".$newVal;
					echo print_input_text_link_settings( "add_new[".$count."]" , $params );
					echo "<br><br>";
					$count++;
				}
			}
		}
}


function print_input_text_link_settings( $input_name="" , $params=array() )
{
	$data = $params['data'];
	
	$selected_target1 = ( $data['open_target'] == "_self" ) ? "selected" : "";
	$selected_target2 = ( $data['open_target'] == "_target" ) ? "selected" : "";
	
	$selected_bold1 = ( $data['font_bold'] == "0" ) ? "selected" : "";
	$selected_bold2 = ( $data['font_bold'] == "1" ) ? "selected" : "";
	
	$selected_underline1 = ( $data['font_underline'] == "0" ) ? "selected" : "";
	$selected_underline2 = ( $data['font_underline'] == "1" ) ? "selected" : "";
	
	$selected_hide1 = ( $data['hide'] == "0" ) ? "selected" : "";
	$selected_hide2 = ( $data['hide'] == "1" ) ? "selected" : "";
	
	$deleted_bg = "";
	
	if( $data['deleted'] == "1" ){
		$deleted_bg = ' style="background:red;" ';
	}
	
	$rand_num = rand(0,99999);
	echo "<table cellpadding=0 cellspacing=0 border=0 class='maintext' ".$deleted_bg.">";
	
		echo "<tr>";
			echo "<td>";
				echo "<table cellpadding=0 cellspacing=0 border=0 class='maintext'>";
					echo "<tr>";
						echo "<td>מיקום</td>";
						echo "<td width=10></td>";
						echo "<td><input type='text' name='".$input_name."[place]' value='".stripslashes($data['place'])."' class='input_style' style='width: 30px;'></td>";
						echo "<td width=10></td>";
						echo "<td>שם הקישור</td>";
						echo "<td width=10></td>";
						echo "<td><input type='text' name='".$input_name."[link_name]' value='".stripslashes($data['link_name'])."' class='input_style' style='width: 100px;'></td>";
						echo "<td width=10></td>";
						echo "<td>כתובת</td>";
						echo "<td width=10></td>";
						echo "<td><input type='text' name='".$input_name."[link_url]' value='".stripslashes($data['link_url'])."' dir='ltr' class='input_style' style='width: 150px;'></td>";
						echo "<td width=10></td>";
						echo "<td>יפתח בדף</td>";
						echo "<td width=10></td>";
						echo "<td>";
							echo "<select name='".$input_name."[open_target]' class='input_style' style='width: 50px;'>";
								echo "<option value='_self' ".$selected_target1.">עצמו</option>";
								echo "<option value='_target' ".$selected_target2.">חדש</option>";
							echo "</select>";
						echo "</td>";
					echo "</tr>";
				echo "</table>";
			echo "</td>";
		echo "</tr>";
		
		echo "<tr><td height=10></td></tr>";
		$start_father_url = "";
		$light_vertion_url = "";
		if(isset($_REQUEST['light_vertion'])){
			$light_vertion_url = "&light_vertion=1";
		}	
		if(isset($_REQUEST['start_father'])){
			$start_father_url = "&start_father=".$_REQUEST['start_father'];
		}		
		echo "<tr>";
			echo "<td>";
				echo "<table cellpadding=0 cellspacing=0 border=0 class='maintext' width=100%>";
					echo "<tr>";
						echo "<td align=right><a href='javascript:void(0)' onclick='more_links_adv_settings_open(\"more_settings_".$rand_num."\")' class='maintext'>הגדרות מתקדמות</a></td>";
						if( $data['id'] ){
							echo "<td align=left><a href='index.php?main=link_menu_adv_settings_del&type=".$_GET['type'].$start_father_url.$light_vertion_url."&reco_id=".$data['id']."&unk=".UNK."&sesid=".SESID."' class='maintext'  onclick=\"return can_i_del()\">מחיקת קישור</a></td>";
						}
					echo "</tr>";
				echo "</table>";
			echo "</td>";
		echo "</tr>";
		
		
		echo "<tr>";
			echo "<td id='more_settings_".$rand_num."' style='display: none;'>";
				echo "<table cellpadding=0 cellspacing=0 border=0 class='maintext'>";
					echo "<tr><td height=10></td></tr>";
					echo "<tr>";
						echo "<td>";
							echo "<table cellpadding=0 cellspacing=0 border=0 class='maintext'>";
								echo "<tr>";
									echo "<td>שייך לקישור</td>";
									echo "<td width=10></td>";
									echo "<td>";
										$menu_settings_tree = get_users_links_menu_settings_tree();
										echo "<select name='".$input_name."[father]' class='input_style' style='width: 100px;'>";
											echo "<option value='0'>ראשי</option>";
											



											foreach($menu_settings_tree as $key_fathers=>$data_fathers) 
											{
												if($data['id'] == $key_fathers){
													continue;
												}
												$selected = ( $data_fathers['id'] == $data['father'] ) ? "selected" : "";
												if($input_name == "add_new[0]" && isset($_REQUEST['start_father'])){
													$selected_father = $_REQUEST['start_father'];
													$selected = ( $data_fathers['id'] == $selected_father ) ? "selected" : "";
												}
												echo "<option value='".stripslashes($data_fathers['id'])."' ".$selected.">".stripslashes($data_fathers['link_name'])."</option>";
													

												
												foreach($data_fathers['children'] as $key_fathers2=>$data_fathers2) 
												{
													if($data['id'] == $key_fathers2){
														continue;
													}
													$selected2 = ( $data_fathers2['id'] == $data['father'] ) ? "selected" : "";
													echo "<option value='".stripslashes($data_fathers2['id'])."' ".$selected2."> -> ".stripslashes($data_fathers2['link_name'])."</option>";
												}
											}


											/*
											while( $data_fathers = mysql_fetch_array($res_fathers) ) 
											{
												$selected = ( $data_fathers['id'] == $data['father'] ) ? "selected" : "";
												echo "<option value='".stripslashes($data_fathers['id'])."' ".$selected.">".stripslashes($data_fathers['link_name'])."</option>";
													
												$sql2 = "SELECT id, link_name FROM users_links_menu_settings WHERE deleted=0 AND unk = '".UNK."' AND father='".$data_fathers['id']."' and id != '".$data['id']."' ORDER by place,id";
												$res_fathers2 = mysql_db_query(DB,$sql2);
												
												while( $data_fathers2 = mysql_fetch_array($res_fathers2) ) 
												{
													$selected2 = ( $data_fathers2['id'] == $data['father'] ) ? "selected" : "";
													echo "<option value='".stripslashes($data_fathers2['id'])."' ".$selected2."> -> ".stripslashes($data_fathers2['link_name'])."</option>";
												}
											}
											*/
											
										echo "</select>";
									echo "</td>";
									echo "<td width=10></td>";
									echo "<td>גודל הפונט</td>";
									echo "<td width=10></td>";
									echo "<td>";
										echo "<select name='".$input_name."[font_size]' class='input_style' style='width: 50px;'>";
											for( $i=11 ; $i<=17 ; $i++ )
											{
												$selected = ( $i == $data['font_size'] ) ? "selected" : "";
												echo "<option value='".$i."' ".$selected.">".$i."px</option>";
											}
										echo "</select>";
									echo "</td>";
									echo "<td width=10></td>";
									echo "<td>בולט?</td>";
									echo "<td width=10></td>";
									echo "<td>";
										echo "<select name='".$input_name."[font_bold]' class='input_style' style='width: 40px;'>";
											echo "<option value='0' ".$selected_bold1.">לא</option>";
											echo "<option value='1' ".$selected_bold2.">כן</option>";
										echo "</select>";
									echo "</td>";
									
									echo "<td width=10></td>";
									
									echo "<td>קו תחתון?</td>";
									echo "<td width=10></td>";
									echo "<td>";
										echo "<select name='".$input_name."[font_underline]' class='input_style' style='width: 40px;'>";
											echo "<option value='0' ".$selected_underline1.">לא</option>";
											echo "<option value='1' ".$selected_underline2.">כן</option>";
										echo "</select>";
									echo "</td>";
									
									echo "<td width=10></td>";
									
									echo "<td>פעיל?</td>";
									echo "<td width=10></td>";
									echo "<td>";
										echo "<select name='".$input_name."[hide]' class='input_style' style='width: 40px;'>";
											echo "<option value='0' ".$selected_hide1.">כן</option>";
											echo "<option value='1' ".$selected_hide2.">לא</option>";
										echo "</select>";
									echo "</td>";
									
								echo "</tr>";
							echo "</table>";
							echo "</div>";
						echo "</td>";
					echo "</tr>";
					
					echo "<tr><td height=10></td></tr>";
					
					echo "<tr>";
						echo "<td>";
							echo "<table cellpadding=0 cellspacing=0 border=0 class='maintext'>";
								echo "<tr>";
									echo "<td>רקע כפתור</td>";
									echo "<td width=10></td>";
									echo "<td><input type='text' name='".$input_name."[bgcolor]' value='".stripslashes($data['bgcolor'])."' class='input_style' style='width: 50px;'></td>";
									echo "<td width=10></td>";
									echo "<td>צבע רקע מעבר כפתור</td>";
									echo "<td width=10></td>";
									echo "<td><input type='text' name='".$input_name."[bgOver_color]' value='".stripslashes($data['bgOver_color'])."' class='input_style' style='width: 50px;'></td>";
									echo "<td width=10></td>";
									echo "<td>צבע פונט</td>";
									echo "<td width=10></td>";
									echo "<td><input type='text' name='".$input_name."[font_color]' value='".stripslashes($data['font_color'])."' class='input_style' style='width: 50px;'></td>";
									echo "<td width=10></td>";
									echo "<td>צבע פונט מעבר</td>";
									echo "<td width=10></td>";
									echo "<td><input type='text' name='".$input_name."[font_over]' value='".stripslashes($data['font_over'])."' class='input_style' style='width: 50px;'></td>";
								echo "</tr>";
							echo "</table>";
						echo "</td>";
					echo "</tr>";
					
					$temp_input_name = str_replace( "[" , "_" , $input_name );
					$temp_input_name2 = str_replace( "]" , "_" , $temp_input_name );
					
					
					$path1 = SERVER_PATH."/tamplate/".$data['background'];
					if( file_exists($path1) && !is_dir($path1) )
						$details_img1 = "&nbsp;<a href=\"".HTTP_PATH."/tamplate/".$data['background']."\" class=\"maintext_small\" target=\"_blank\">צפה</a>&nbsp;|&nbsp;<a href=\"index.php?main=del_img_DB_FTP&table=users_links_menu_settings&GOTO_type=link_menu_adv_settings&GOTO_main=link_menu_adv_settings&field_name=background&sesid=".SESID."&unk=".UNK."&path=tamplate/&img=".$data['background']."\" class=\"maintext_small\" onclick=\"return can_i_del()\">מחק</a>";
					
					$path2 = SERVER_PATH."/tamplate/".$data['icon'];
					if( file_exists($path2) && !is_dir($path2) )
						$details_img2 = "&nbsp;<a href=\"".HTTP_PATH."/tamplate/".$data['icon']."\" class=\"maintext_small\" target=\"_blank\">צפה</a>&nbsp;|&nbsp;<a href=\"index.php?main=del_img_DB_FTP&table=users_links_menu_settings&GOTO_type=link_menu_adv_settings&GOTO_main=link_menu_adv_settings&field_name=icon&sesid=".SESID."&unk=".UNK."&path=tamplate/&img=".$data['icon']."\" class=\"maintext_small\" onclick=\"return can_i_del()\">מחק</a>";
					
					$path3 = SERVER_PATH."/tamplate/".$data['img_link_button'];
					if( file_exists($path3) && !is_dir($path3) )
						$details_img3 = "&nbsp;<a href=\"".HTTP_PATH."/tamplate/".$data['img_link_button']."\" class=\"maintext_small\" target=\"_blank\">צפה</a>&nbsp;|&nbsp;<a href=\"index.php?main=del_img_DB_FTP&table=users_links_menu_settings&GOTO_type=link_menu_adv_settings&GOTO_main=link_menu_adv_settings&field_name=img_link_button&sesid=".SESID."&unk=".UNK."&path=tamplate/&img=".$data['img_link_button']."\" class=\"maintext_small\" onclick=\"return can_i_del()\">מחק</a>";
					
					$path4 = SERVER_PATH."/tamplate/".$data['img_link_button_hover'];
					if( file_exists($path4) && !is_dir($path4) )
						$details_img4 = "&nbsp;<a href=\"".HTTP_PATH."/tamplate/".$data['img_link_button_hover']."\" class=\"maintext_small\" target=\"_blank\">צפה</a>&nbsp;|&nbsp;<a href=\"index.php?main=del_img_DB_FTP&table=users_links_menu_settings&GOTO_type=link_menu_adv_settings&GOTO_main=link_menu_adv_settings&field_name=img_link_button_hover&sesid=".SESID."&unk=".UNK."&path=tamplate/&img=".$data['img_link_button_hover']."\" class=\"maintext_small\" onclick=\"return can_i_del()\">מחק</a>";
					
						
					echo "<tr><td height=10></td></tr>";
					echo "<tr>";
						echo "<td>";
							echo "<table cellpadding=0 cellspacing=0 border=0 class='maintext'>";
								echo "<tr>";
									echo "<td>רקע</td>";
									echo "<td width=10></td>";
									echo "<td><input type='file' name='".$temp_input_name2."background' value='' class='input_style' style='width: 200px;'>".$details_img1."</td>";
									echo "<td width=10></td>";
									echo "<td>אייקון</td>";
									echo "<td width=10></td>";
									echo "<td><input type='file' name='".$temp_input_name2."icon' value='' class='input_style' style='width: 200px;'>".$details_img2."</td>";
								echo "</tr>";
							echo "</table>";
						echo "</td>";
					echo "</tr>";
					
					echo "<tr><td height=10></td></tr>";
					echo "<tr>";
						echo "<td>";
							echo "<table cellpadding=0 cellspacing=0 border=0 class='maintext'>";
								echo "<tr>";
									echo "<td>כפתור תמונה</td>";
									echo "<td width=10></td>";
									echo "<td><input type='file' name='".$temp_input_name2."img_link_button' value='' class='input_style' style='width: 180px;'>".$details_img3."</td>";
									echo "<td width=10></td>";
									echo "<td>כפתור תמונה במעבר</td>";
									echo "<td width=10></td>";
									echo "<td><input type='file' name='".$temp_input_name2."img_link_button_hover' value='' class='input_style' style='width: 180px;'>".$details_img4."</td>";
								echo "</tr>";
							echo "</table>";
						echo "</td>";
					echo "</tr>";
				echo "</table>";
			echo "</td>";
		echo "</tr>";
		
	echo "</table>";
}
$links_menu_settings_tree = false;
function get_users_links_menu_settings_tree(){
	
	global $links_menu_settings_tree;
	global $lll,$vvv;
	if($links_menu_settings_tree){
		return $links_menu_settings_tree;
	}

	$links_menu_settings_tree = array();
	$sql = "SELECT id, link_name FROM users_links_menu_settings WHERE deleted=0 AND unk = '".UNK."' AND father=0 ORDER by place,id";
	$res_fathers = mysql_db_query(DB,$sql);
	
	while( $data_fathers = mysql_fetch_array($res_fathers) ) 
	{
		$links_menu_settings_tree[$data_fathers['id']] = $data_fathers;
		$links_menu_settings_tree[$data_fathers['id']]['children']	= array();
		$sql2 = "SELECT id, link_name FROM users_links_menu_settings WHERE deleted=0 AND unk = '".UNK."' AND father='".$data_fathers['id']."' ORDER by place,id";
		$res_fathers2 = mysql_db_query(DB,$sql2);
		
		while( $data_fathers2 = mysql_fetch_array($res_fathers2) ) 
		{
			$links_menu_settings_tree[$data_fathers['id']]['children'][$data_fathers2['id']] = $data_fathers2;
		}
	}
	return $links_menu_settings_tree;
	
}

function link_menu_adv_settings_del()
{
	$sql = "SELECT background , icon , img_link_button , img_link_button_hover FROM users_links_menu_settings WHERE id='".$_GET['reco_id']."' AND unk = '".UNK."' ";
	$res = mysql_db_query(DB,$sql);
	$data = mysql_fetch_array($res);
	
	$path1 = SERVER_PATH."/tamplate/".$data['background'];
	if( file_exists($path1) && !is_dir($path1)  )
		unlink($path1);
	
	$path2 = SERVER_PATH."/tamplate/".$data['icon'];
	if( file_exists($path2) && !is_dir($path2) )
		unlink($path2);
	
	$path3 = SERVER_PATH."/tamplate/".$data['img_link_button'];
	if( file_exists($path3) && !is_dir($path3) )
		unlink($path3);
	
	$path4 = SERVER_PATH."/tamplate/".$data['img_link_button_hover'];
	if( file_exists($path4) && !is_dir($path4) )
		unlink($path4);
	
	
	$sql = "SELECT id FROM users_links_menu_settings WHERE father ='".$_GET['reco_id']."' AND unk = '".UNK."' ";
	$res = mysql_db_query(DB,$sql);
	$check_num_regular = mysql_num_rows($res);
	if( $check_num_regular == "0" ){
		$sql = "DELETE FROM users_links_menu_settings WHERE id='".$_GET['reco_id']."' AND unk = '".UNK."' ";
	}
	else{
		$sql = "UPDATE users_links_menu_settings SET deleted=1 , background = '' , icon = '' , img_link_button = '' , img_link_button_hover = '' WHERE id='".$_GET['reco_id']."' AND unk = '".UNK."' ";
	}
	$res = mysql_db_query(DB,$sql);
	$start_father_url = "";
	$light_vertion_url = "";
	if(isset($_REQUEST['light_vertion'])){
		$light_vertion_url = "&light_vertion=1";
	}	
	if(isset($_REQUEST['start_father'])){
		$start_father_url = "&start_father=".$_REQUEST['start_father'];
	}	
	echo "<script>window.location.href='index.php?main=link_menu_adv_settings&type=".$_POST['type'].$start_father_url.$light_vertion_url."&unk=".UNK."&sesid=".SESID."';</script>";
		exit;
}


function payForLead()
{
	$sqlQry = "SELECT leadQry FROM user_lead_settings WHERE unk = '".$_GET['unk']."'";
	$resQry = mysql_db_query(DB,$sqlQry);
	$dataQry = mysql_fetch_array($resQry);
	
	
	if( $dataQry['leadQry'] > "0" )
	{
		$row_sql = "SELECT * FROM user_contact_forms WHERE id = '".$_GET['r_id']."'";
		$row_res = mysql_db_query(DB,$row_sql);
		$row_data = mysql_fetch_array($row_res);


		$bill_array = array(
			"lead_recource" => "form",
			"lead_billed" => "1",
			"lead_billed_id" => "0",
		);		
		if(isset($row_data['phone'])){
			$bill_sql = "SELECT id as billed_id FROM user_contact_forms WHERE phone = '".$row_data['phone']."' AND lead_billed = 1 AND unk = '".$row_data['unk']."' AND date_in > (CAST(DATE_FORMAT(NOW() ,'%Y-%m-01') as DATE)) LIMIT 1";
			$bill_res = mysql_db_query(DB,$bill_sql);	
			$bill_data = mysql_fetch_array($bill_res);
			if(isset($bill_data['billed_id'])){
				$bill_array['lead_billed'] = '0';
				$bill_array['lead_billed_id'] = $bill_data['billed_id'];
			}			
		}
		
		$sql = "UPDATE user_contact_forms SET payByPassword = '1',lead_billed = '".$bill_array['lead_billed']."',lead_billed_id = '".$bill_array['lead_billed_id']."' WHERE id = '".$_GET['r_id']."'";
		$res = mysql_db_query(DB,$sql);
		
		$lead = new leadSys();
		if($bill_array['lead_billed'] == '1'){
			$lead->userLeadQryMinus1($_GET['unk']);
		}
		echo "<script>window.location.href='index.php?main=get_create_form&type=contact&row_id=".$_GET['r_id']."&unk=".$_GET['unk']."&sesid=".$_GET['sesid']."';</script>";
		exit;
	}
	else
	{
		echo "<p class='maintext'>";
			echo "נראה שנגמרו לך יתרת ההודעות/לידים, למילוי היתרה יש לפנות לשירות הלקוחות במספר 03-6449369<br>באפשרותך <a href='index.php?main=buy_leads&type=buy_leads&unk=".UNK."&sesid=".SESID."' class='maintext' style='color: blue;'>לרכוש עכשיו</a>";
			
			
			
		echo "</p>";
	}
	
	
	
}



function payForLeadByCredit()
{
	$sql = "SELECT id FROM users WHERE unk = '".UNK."' ";
	$res3id = mysql_db_query(DB, $sql);
	$dataUserId = mysql_fetch_array($res3id);
	
	$sql = "SELECT credit_price FROM user_lead_settings WHERE unk = '".UNK."' ";
	$res3Cr = mysql_db_query(DB, $sql);
	$dataUserCr = mysql_fetch_array($res3Cr);
	
	$creditMoney = new creditMoney;
	$credits = $creditMoney->get_creditMoney("users" , $dataUserId['id'] );
	
	if( $dataUserCr['credit_price'] > "0" && $credits >= $dataUserCr['credit_price'] )
	{
		$creditMoney->change_credit( "users" , $dataUserId['id'] , "-".$dataUserCr['credit_price'] , "תשלום על פנייה" );
		
		$sql = "UPDATE user_contact_forms SET payByPassword = '1' WHERE id = '".$_GET['r_id']."'";
		$res = mysql_db_query(DB,$sql);
		
		echo "<script>window.location.href='index.php?main=get_create_form&type=contact&row_id=".$_GET['r_id']."&unk=".$_GET['unk']."&sesid=".$_GET['sesid']."';</script>";
		exit;
	}
	else
	{
		echo "<p class='maintext'>";
			echo "נראה שנגמרו לך הקרדיטים";
		echo "</p>";
	}
	
}

