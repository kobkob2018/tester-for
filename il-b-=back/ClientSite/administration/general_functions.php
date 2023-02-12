<?php
/* 
* Copyright © 2006 ILbiz. All Rights Reserved
* email:	webmaster@ilbiz.co.il
* 
* the page create lists, textarea content and the color of the content
* the page have all the genral funations that all the pages needed
*/

/**************************************************************************************************/

function get_text_and_Color($content)	{

	echo "<tr>";
		echo "<td valign=\"top\">טקסט</td>";
		echo "<td width=\"10\"></td>";
		echo "<td><textarea cols=\"\" rows=\"\" name=\"content\" class=\"textarea_style\">".stripslashes($content)."</textarea></td>";
	echo "</tr>";
	echo "<tr><td colspan=\"3\" height=\"3\"></td></tr>";
	echo "<tr>";
		echo "<td>&nbsp;</td>";
		echo "<td width=\"10\"></td>";
		echo "<td>";
			echo "<table border='0' cellspacing='0' cellpadding='0' class='maintext_small'>";
				echo "<tr>";
					echo "<td><a href='JavaScript:AddText(\"|דגש|\")' class='maintext_small'>[הפעל הדגשה]</a></td>";
					echo "<td width='5'></td>";
					echo "<td><a href='JavaScript:AddText(\"|סדגש|\")' class='maintext_small'>[הפסק הדגשה]</a></td>";
					echo "<td width='5'></td>";
					echo "<td><a href='JavaScript:AddText(\"|קותחתי|\")' class='maintext_small'>[הפעל קו]</a></td>";
					echo "<td width='5'></td>";
					echo "<td><a href='JavaScript:AddText(\"|סקותחתי|\")' class='maintext_small'>[הפסק קו]</a></td>";
					echo "<td width='5'></td>";
					echo "<td><a href='JavaScript:AddText(\"|נטוי|\")' class='maintext_small'>[הפעל נטוי]</a></td>";
					echo "<td width='5'></td>";
					echo "<td><a href='JavaScript:AddText(\"|סנטוי|\")' class='maintext_small'>[הפסק נטוי]</a></td>";
				echo "</tr>";
			echo "</table>";
		echo "</td>";
	echo "</tr>";
	echo "<tr><td colspan=\"3\" height=\"7\"></td></tr>";

}
/**************************************************************************************************/

function get_table_list($arr_fields,$goto_func,$back_to,$sql,$table)	{
	
	global $word;
	//$sql = "select * from ".$table." where deleted = '0'";
	$res = mysql_db_query(DB,$sql);
	
	echo "<table border=\"0\" cellspacing=\"0\" cellpadding=\"0\" class=\"maintext\" width=\"580\">";
		
		if( $table == "user_contact_forms" )
		{
			echo "<tr>";
				echo "<td colspan=15>";
					echo "<form action='index.php' name='conatct_search' method='get' style=''padding:0; margin:0;>";
					echo "<input type='hidden' name='main' value='List_View_Rows'>";
					echo "<input type='hidden' name='type' value='contact'>";
					echo "<input type='hidden' name='unk' value='".$_GET['unk']."'>";
					echo "<input type='hidden' name='sesid' value='".$_GET['sesid']."'>";
					echo "<input type='hidden' name='status' value='s'>";
					echo "<table border=\"0\" cellspacing=\"0\" cellpadding=\"0\" class=\"maintext\">";
						echo "<tr>";
							echo "<td>".$word[LANG]['search_from_date'].":</td>";
							echo "<td width='10'></td>";
							echo "<td><input type=text name='sd' value='".$_GET['sd']."' class='input_style' style='width: 80px;'> mm-dd-yyy</td>";
							echo "<td width='30'></td>";
							echo "<td>".$word[LANG]['search_until_date'].":</td>";
							echo "<td width='10'></td>";
							echo "<td><input type=text name='ed' value='".$_GET['ed']."' class='input_style' style='width: 80px;'> mm-dd-yyy</td>";
						echo "</tr>";
						echo "<tr><td colspan=7 height=5></td></tr>";
						echo "<tr>";
							echo "<td>".$word[LANG]['search_free'].":</td>";
							echo "<td width='10'></td>";
							echo "<td colspan=5><input type=text name='val' value='".$_GET['val']."' class='input_style' style='width: 80px;'> ".$word[LANG]['search_free_desc']."</td>";
						echo "</tr>";
						echo "<tr>";
							echo "<td colspan=7>";
								echo "<table border=\"0\" cellspacing=\"0\" cellpadding=\"0\" class=\"maintext\">";
									echo "<tr><td colspan=11 height=5></td></tr>";
									echo "<tr>";
										echo "<td colspan=11>".$word[LANG]['search_status_desc'].":</td>";
									echo "</tr>";
									echo "<tr><td colspan=11 height=5></td></tr>";
									echo "<tr>";
									
										$S = $_GET['s'];
										$checked = ( $S[0] == "1" || $status == "s" ) ? "checked" : "";
										echo "<td><input type='checkbox' name='s[0]' value='1' ".$checked."> ".$word[LANG]['Interested_service']."</td>";
										echo "<td width='3'></td>";
										$checked = ( $S[1] == "1" || $status == "s" ) ? "checked" : "";
										echo "<td><input type='checkbox' name='s[1]' value='1' ".$checked."> ".$word[LANG]['talked_with_him']."</td>";
										echo "<td width='3'></td>";
										$checked = ( $S[5] == "1" || $status == "s" ) ? "checked" : "";
										echo "<td><input type='checkbox' name='s[5]' value='1' ".$checked."> ".$word[LANG]['Waiting_phone']."</td>";
										echo "<td width='3'></td>";
										$checked = ( $S[2] == "1" || $status == "s" ) ? "checked" : "";
										echo "<td><input type='checkbox' name='s[2]' value='1' ".$checked."> ".$word[LANG]['Close_customer']."</td>";
										echo "<td width='3'></td>";
										$checked = ( $S[3] == "1" || $status == "s" ) ? "checked" : "";
										echo "<td><input type='checkbox' name='s[3]' value='1' ".$checked."> ".$word[LANG]['Registered_customers']."</td>";
										echo "<td width='3'></td>";
										$checked = ( $S[4] == "1" || $status == "s" ) ? "checked" : "";
										echo "<td><input type='checkbox' name='s[4]' value='1' ".$checked."> ".$word[LANG]['Not_relevant']."</td>";
										echo "<td width='3'></td>";
										$checked = ( $_GET['deleted'] == "1" || $status == "s" ) ? "checked" : "";
										echo "<td><input type='checkbox' name='deleted' value='1' ".$checked."> ".$word[LANG]['deleted']."</td>";
									echo "</tr>";
									echo "<tr><td colspan=11 height=5></td></tr>";
								echo "</table>";
							echo "</td>";
						echo "</tr>";
						
						echo "<tr>";
							echo "<td colspan=7 align=left><input type='submit' class='submit_style' value='".$word[LANG]['search_submit']."'></td>";
						echo "</tr>";
					echo "</table>";
					echo "</form>";
				echo "</td>";
			echo "</tr>";
			echo "<tr><td height=7 colspan=15></td></td>";
			echo "<tr>";
				echo "<td colspan=15>";
					echo "<table border=\"0\" cellspacing=\"0\" cellpadding=\"0\" class=\"maintext\" width=100%>";
						echo "<tr>";
							$status = ( $_GET['status'] == "" ) ? "0" :  $_GET['status'];
							$temp_status = $status;
							$temp_var = "bols_s_".$temp_status;
							$temp_var2 = "bols_e_".$temp_status;
							$$temp_var = ( $status	== $temp_status  ) ? "<b>" : "";
							$$temp_var2 = ( $status	== $temp_status  ) ? "</b>" : "";
							
							$deleted1s = ( $_GET['deleted']	== "1"  ) ? "<b>" : "";
							$deleted1e = ( $_GET['deleted']	== "1" ) ? "</b>" : "";
							
							echo "<td valign=top><a href='index.php?main=List_View_Rows&type=contact&status=0&unk=".$_GET['unk']."&sesid=".$_GET['sesid']."' class='maintext'>".$bols_s_0.$word[LANG]['Interested_service'].$bols_e_0."</a></td>";
							echo "<td width='15'></td>";
							echo "<td valign=top><a href='index.php?main=List_View_Rows&type=contact&status=1&unk=".$_GET['unk']."&sesid=".$_GET['sesid']."' class='maintext'>".$bols_s_1.$word[LANG]['talked_with_him'].$bols_e_4."</a></td>";
							echo "<td width='15'></td>";
							echo "<td valign=top><a href='index.php?main=List_View_Rows&type=contact&status=5&unk=".$_GET['unk']."&sesid=".$_GET['sesid']."' class='maintext'>".$bols_s_5.$word[LANG]['Waiting_phone'].$bols_e_5."</a></td>";
							echo "<td width='15'></td>";
							echo "<td valign=top><a href='index.php?main=List_View_Rows&type=contact&status=2&unk=".$_GET['unk']."&sesid=".$_GET['sesid']."' class='maintext'>".$bols_s_2.$word[LANG]['Close_customer'].$bols_e_2."</a></td>";
							echo "<td width='15'></td>";
							echo "<td valign=top><a href='index.php?main=List_View_Rows&type=contact&status=3&unk=".$_GET['unk']."&sesid=".$_GET['sesid']."' class='maintext'>".$bols_s_3.$word[LANG]['Registered_customers'].$bols_e_3."</a></td>";
							echo "<td width='15'></td>";
							echo "<td valign=top><a href='index.php?main=List_View_Rows&type=contact&status=4&unk=".$_GET['unk']."&sesid=".$_GET['sesid']."' class='maintext'>".$bols_s_4.$word[LANG]['Not_relevant'].$bols_e_4."</a></td>";
							echo "<td width='15'></td>";
							echo "<td valign=top><a href='index.php?main=List_View_Rows&type=contact&deleted=1&unk=".$_GET['unk']."&sesid=".$_GET['sesid']."' class='maintext'>".$deleted1s.$word[LANG]['deleted'].$deleted1e."</a></td>";
							echo "<td width='40'></td>";
							
							echo "<td valign=top><a href='index.php?main=List_View_Rows&type=contact&status=6&unk=".$_GET['unk']."&sesid=".$_GET['sesid']."' class='maintext'>".$bols_s_4.$word[LANG]['Lead_Refunded'].$bols_e_4."</a></td>";
							echo "<td width='40'></td>";							
							echo "<td align=left><a href='getExcelContact.php?status=".$status."&unk=".$_GET['unk']."&sesid=".$_GET['sesid']."&s[0]=".$S[0]."&s[1]=".$S[1]."&s[5]=".$S[5]."&s[2]=".$S[2]."&s[3]=".$S[3]."&s[4]=".$S[4]."&sd=".$_GET['sd']."&ed=".$_GET['ed']."' target='_blank'><img src='images/Excel_32.png' border=0 alt='יצוא לאקסל' /></a></td>";
						echo "</tr>";
					echo "</table>";
				echo "</td>";
			echo "</tr>";
			
			echo "<tr><td height=5 colspan=15></td></td>";
			
			$sql_Subs = "SELECT id, subject FROM user_contact_subjects WHERE deleted=0 AND unk = '".UNK."' ";
			$res_Subs = mysql_db_query(DB, $sql_Subs) ;
			$nums_Subs = mysql_num_rows($res_Subs); 
			
			if( $nums_Subs > 0 )
			{
				echo "<tr>";
				echo "<td colspan=7 align=right>";
					echo "<table border=\"0\" cellspacing=\"0\" cellpadding=\"0\" class=\"maintext\">";;
						echo "<tr>";
							echo "<td>".$word[LANG]['choose_subject'].":</td>";
						echo "</tr>";
						echo "<tr><td height=5></td></tr>";
						echo "<tr>";
							echo "<td>";
								while( $dataSubs = mysql_fetch_array($res_Subs) )
								{
									$b_s = ( $dataSubs['id'] == $_GET['subject_id'] ) ? "<b>" : "";
									$b_e = ( $dataSubs['id'] == $_GET['subject_id'] ) ? "</b>" : "";
									echo "<a href='index.php?main=List_View_Rows&type=contact&subject_id=".$dataSubs['id']."&status=".$_GET['status']."&unk=".UNK."&sesid=".SESID."&s[0]=".$S[0]."&s[1]=".$S[1]."&s[5]=".$S[5]."&s[2]=".$S[2]."&s[3]=".$S[3]."&s[4]=".$S[4]."&sd=".$_GET['sd']."&ed=".$_GET['ed']."' class='maintext'>".$b_s.stripslashes($dataSubs['subject']).$b_e."</a>&nbsp;&nbsp;&nbsp;";
								}
							echo "</td>";
						echo "</tr>";
						echo "<tr><td height=5></td></tr>";
					echo "</table>";
				echo "</td>";
			echo "</tr>";
			}
					
			echo "<tr><td height=10 colspan=15></td></td>";
			
			$sqlQry = "SELECT leadQry FROM user_lead_settings WHERE unk = '".$_GET['unk']."'";
			$resQry = mysql_db_query(DB,$sqlQry);
			$dataQry = mysql_fetch_array($resQry);
			
			if( $dataQry['leadQry'] != "" )
			{
				echo "<tr>";
					echo "<td colspan=15><b>יתרת הודעות לקבלת פניות ממערכות השוואות מחיר:</b> ".$dataQry['leadQry']." פניות באפשרותך <a href='index.php?main=buy_leads&type=buy_leads&unk=".UNK."&sesid=".SESID."' class='maintext'>לרכוש לידים/פניות</a></td>";
				echo "</tr>";
				echo "<tr><td height=10 colspan=15></td></td>";
			}
			
		}

		if( $table == "user_e_card_forms" )
		{
			echo "<tr>";
				echo "<td colspan=15>";
					echo "<form action='index.php' name='conatct_search' method='get' style=''padding:0; margin:0;>";
					echo "<input type='hidden' name='main' value='List_View_Rows'>";
					echo "<input type='hidden' name='type' value='e_card_forms'>";
					echo "<input type='hidden' name='unk' value='".$_GET['unk']."'>";
					echo "<input type='hidden' name='sesid' value='".$_GET['sesid']."'>";
					echo "<input type='hidden' name='status' value='s'>";
					echo "<table border=\"0\" cellspacing=\"0\" cellpadding=\"0\" class=\"maintext\">";
						echo "<tr>";
							echo "<td>".$word[LANG]['search_from_date'].":</td>";
							echo "<td width='10'></td>";
							echo "<td><input type=text name='sd' value='".$_GET['sd']."' class='input_style' style='width: 80px;'> mm-dd-yyy</td>";
							echo "<td width='30'></td>";
							echo "<td>".$word[LANG]['search_until_date'].":</td>";
							echo "<td width='10'></td>";
							echo "<td><input type=text name='ed' value='".$_GET['ed']."' class='input_style' style='width: 80px;'> mm-dd-yyy</td>";
						echo "</tr>";
						echo "<tr><td colspan=7 height=5></td></tr>";
						echo "<tr>";
							echo "<td>".$word[LANG]['search_free'].":</td>";
							echo "<td width='10'></td>";
							echo "<td colspan=5><input type=text name='val' value='".$_GET['val']."' class='input_style' style='width: 80px;'> ".$word[LANG]['search_free_desc']."</td>";
						echo "</tr>";
						echo "<tr>";
							echo "<td colspan=7>";
								echo "<table border=\"0\" cellspacing=\"0\" cellpadding=\"0\" class=\"maintext\">";
									echo "<tr><td colspan=11 height=5></td></tr>";
									echo "<tr>";
										echo "<td colspan=11>".$word[LANG]['search_status_desc'].":</td>";
									echo "</tr>";
									echo "<tr><td colspan=11 height=5></td></tr>";
									echo "<tr>";
									
										$S = $_GET['s'];
										$checked = ( $S[0] == "1" || $status == "s" ) ? "checked" : "";
										echo "<td><input type='checkbox' name='s[0]' value='1' ".$checked."> ".$word[LANG]['Interested_service']."</td>";
										echo "<td width='3'></td>";
										$checked = ( $S[1] == "1" || $status == "s" ) ? "checked" : "";
										echo "<td><input type='checkbox' name='s[1]' value='1' ".$checked."> ".$word[LANG]['talked_with_him']."</td>";
										echo "<td width='3'></td>";
										$checked = ( $S[5] == "1" || $status == "s" ) ? "checked" : "";
										echo "<td><input type='checkbox' name='s[5]' value='1' ".$checked."> ".$word[LANG]['Waiting_phone']."</td>";
										echo "<td width='3'></td>";
										$checked = ( $S[2] == "1" || $status == "s" ) ? "checked" : "";
										echo "<td><input type='checkbox' name='s[2]' value='1' ".$checked."> ".$word[LANG]['Close_customer']."</td>";
										echo "<td width='3'></td>";
										$checked = ( $S[3] == "1" || $status == "s" ) ? "checked" : "";
										echo "<td><input type='checkbox' name='s[3]' value='1' ".$checked."> ".$word[LANG]['Registered_customers']."</td>";
										echo "<td width='3'></td>";
										$checked = ( $S[4] == "1" || $status == "s" ) ? "checked" : "";
										echo "<td><input type='checkbox' name='s[4]' value='1' ".$checked."> ".$word[LANG]['Not_relevant']."</td>";
										echo "<td width='3'></td>";
										$checked = ( $_GET['deleted'] == "1" || $status == "s" ) ? "checked" : "";
										echo "<td><input type='checkbox' name='deleted' value='1' ".$checked."> ".$word[LANG]['deleted']."</td>";
									echo "</tr>";
									echo "<tr><td colspan=11 height=5></td></tr>";
								echo "</table>";
							echo "</td>";
						echo "</tr>";
						
						echo "<tr>";
							echo "<td colspan=7 align=left><input type='submit' class='submit_style' value='".$word[LANG]['search_submit']."'></td>";
						echo "</tr>";
					echo "</table>";
					echo "</form>";
				echo "</td>";
			echo "</tr>";
			echo "<tr><td height=7 colspan=15></td></td>";
			echo "<tr>";
				echo "<td colspan=15>";
					echo "<table border=\"0\" cellspacing=\"0\" cellpadding=\"0\" class=\"maintext\" width=100%>";
						echo "<tr>";
							$status = ( $_GET['status'] == "" ) ? "0" :  $_GET['status'];
							$temp_status = $status;
							$temp_var = "bols_s_".$temp_status;
							$temp_var2 = "bols_e_".$temp_status;
							$$temp_var = ( $status	== $temp_status  ) ? "<b>" : "";
							$$temp_var2 = ( $status	== $temp_status  ) ? "</b>" : "";
							
							$deleted1s = ( $_GET['deleted']	== "1"  ) ? "<b>" : "";
							$deleted1e = ( $_GET['deleted']	== "1" ) ? "</b>" : "";
							
							echo "<td valign=top><a href='index.php?main=List_View_Rows&type=e_card_forms&status=0&unk=".$_GET['unk']."&sesid=".$_GET['sesid']."' class='maintext'>".$bols_s_0.$word[LANG]['Interested_service'].$bols_e_0."</a></td>";
							echo "<td width='15'></td>";
							echo "<td valign=top><a href='index.php?main=List_View_Rows&type=e_card_forms&status=1&unk=".$_GET['unk']."&sesid=".$_GET['sesid']."' class='maintext'>".$bols_s_1.$word[LANG]['talked_with_him'].$bols_e_4."</a></td>";
							echo "<td width='15'></td>";
							echo "<td valign=top><a href='index.php?main=List_View_Rows&type=e_card_forms&status=5&unk=".$_GET['unk']."&sesid=".$_GET['sesid']."' class='maintext'>".$bols_s_5.$word[LANG]['Waiting_phone'].$bols_e_5."</a></td>";
							echo "<td width='15'></td>";
							echo "<td valign=top><a href='index.php?main=List_View_Rows&type=e_card_forms&status=2&unk=".$_GET['unk']."&sesid=".$_GET['sesid']."' class='maintext'>".$bols_s_2.$word[LANG]['Close_customer'].$bols_e_2."</a></td>";
							echo "<td width='15'></td>";
							echo "<td valign=top><a href='index.php?main=List_View_Rows&type=e_card_forms&status=3&unk=".$_GET['unk']."&sesid=".$_GET['sesid']."' class='maintext'>".$bols_s_3.$word[LANG]['Registered_customers'].$bols_e_3."</a></td>";
							echo "<td width='15'></td>";
							echo "<td valign=top><a href='index.php?main=List_View_Rows&type=e_card_forms&status=4&unk=".$_GET['unk']."&sesid=".$_GET['sesid']."' class='maintext'>".$bols_s_4.$word[LANG]['Not_relevant'].$bols_e_4."</a></td>";
							echo "<td width='15'></td>";
							echo "<td valign=top><a href='index.php?main=List_View_Rows&type=e_card_forms&deleted=1&unk=".$_GET['unk']."&sesid=".$_GET['sesid']."' class='maintext'>".$deleted1s.$word[LANG]['deleted'].$deleted1e."</a></td>";
							echo "<td width='40'></td>";
							
							echo "<td valign=top><a href='index.php?main=List_View_Rows&type=e_card_forms&status=6&unk=".$_GET['unk']."&sesid=".$_GET['sesid']."' class='maintext'>".$bols_s_4.$word[LANG]['Lead_Refunded'].$bols_e_4."</a></td>";
							echo "<td width='40'></td>";							
							echo "<td align=left><a href='getExcelContact.php?status=".$status."&unk=".$_GET['unk']."&sesid=".$_GET['sesid']."&s[0]=".$S[0]."&s[1]=".$S[1]."&s[5]=".$S[5]."&s[2]=".$S[2]."&s[3]=".$S[3]."&s[4]=".$S[4]."&sd=".$_GET['sd']."&ed=".$_GET['ed']."' target='_blank'><img src='images/Excel_32.png' border=0 alt='יצוא לאקסל' /></a></td>";
						echo "</tr>";
					echo "</table>";
				echo "</td>";
			echo "</tr>";
			
			echo "<tr><td height=5 colspan=15></td></td>";
			
			$sql_Subs = "SELECT id, subject FROM user_contact_subjects WHERE deleted=0 AND unk = '".UNK."' ";
			$res_Subs = mysql_db_query(DB, $sql_Subs) ;
			$nums_Subs = mysql_num_rows($res_Subs); 
			
			if( $nums_Subs > 0 )
			{
				echo "<tr>";
				echo "<td colspan=7 align=right>";
					echo "<table border=\"0\" cellspacing=\"0\" cellpadding=\"0\" class=\"maintext\">";;
						echo "<tr>";
							echo "<td>".$word[LANG]['choose_subject'].":</td>";
						echo "</tr>";
						echo "<tr><td height=5></td></tr>";
						echo "<tr>";
							echo "<td>";
								while( $dataSubs = mysql_fetch_array($res_Subs) )
								{
									$b_s = ( $dataSubs['id'] == $_GET['subject_id'] ) ? "<b>" : "";
									$b_e = ( $dataSubs['id'] == $_GET['subject_id'] ) ? "</b>" : "";
									echo "<a href='index.php?main=List_View_Rows&type=contact&subject_id=".$dataSubs['id']."&status=".$_GET['status']."&unk=".UNK."&sesid=".SESID."&s[0]=".$S[0]."&s[1]=".$S[1]."&s[5]=".$S[5]."&s[2]=".$S[2]."&s[3]=".$S[3]."&s[4]=".$S[4]."&sd=".$_GET['sd']."&ed=".$_GET['ed']."' class='maintext'>".$b_s.stripslashes($dataSubs['subject']).$b_e."</a>&nbsp;&nbsp;&nbsp;";
								}
							echo "</td>";
						echo "</tr>";
						echo "<tr><td height=5></td></tr>";
					echo "</table>";
				echo "</td>";
			echo "</tr>";
			}
					
			echo "<tr><td height=10 colspan=15></td></td>";
			
			$sqlQry = "SELECT leadQry FROM user_lead_settings WHERE unk = '".$_GET['unk']."'";
			$resQry = mysql_db_query(DB,$sqlQry);
			$dataQry = mysql_fetch_array($resQry);
			
			if( $dataQry['leadQry'] != "" )
			{
				echo "<tr>";
					echo "<td colspan=15><b>יתרת הודעות לקבלת פניות ממערכות השוואות מחיר:</b> ".$dataQry['leadQry']." פניות באפשרותך <a href='index.php?main=buy_leads&type=buy_leads&unk=".UNK."&sesid=".SESID."' class='maintext'>לרכוש לידים/פניות</a></td>";
				echo "</tr>";
				echo "<tr><td height=10 colspan=15></td></td>";
			}
			
		}
		
		if( $_GET['type'] == "fmnUsers" )
		{
			echo "<tr>";
				echo "<td colspan=15>";
					echo "<table border=\"0\" cellspacing=\"0\" cellpadding=\"0\" class=\"maintext\" width=100%>";
						echo "<tr>";
							echo "<td align=left><a href='getExcelFMNusers.php?unk=".$_GET['unk']."&sesid=".$_GET['sesid']."' target='_blank'><img src='images/Excel_32.png' border=0 alt='יצוא לאקסל' /></a></td>";
						echo "</tr>";
					echo "</table>";
				echo "</td>";
			echo "</tr>";
			echo "<tr><td height=30 colspan=15></td></td>";
			
		}
		$sqluser_set = "SELECT enableRecordingsView FROM user_lead_settings WHERE unk = '".$_GET['unk']."'";
		$resuser_set = mysql_db_query(DB,$sqluser_set);
		$datauser_set = mysql_fetch_array($resuser_set);
		
		if( $_GET['type'] == "update_pages" )
		{
			echo "<tr>";
				echo "<td colspan=15>";
					echo "<table border=\"0\" cellspacing=\"0\" cellpadding=\"0\" class=\"maintext\">";
						echo "<tr>";
							echo "<td>";
								$sql = "select * from user_text_libs where deleted = '0' and unk = '".$_REQUEST['unk']."' ORDER BY lib_name";
								$resLib = mysql_db_query(DB,$sql);
								
								while( $dataLib = mysql_fetch_array($resLib) )
								{
									$bold_s = ( $dataLib['id']	== $_GET['lib'] ) ? "<b>" : "";
									$bold_e = ( $dataLib['id']	== $_GET['lib'] ) ? "</b>" : "";
									
									echo "<a href='index.php?main=List_View_Rows&type=".$_GET['type']."&lib=".$dataLib['id']."&unk=".$_GET['unk']."&sesid=".$_GET['sesid']."' class='maintext'>".$bold_s.GlobalFunctions::kill_strip($dataLib['lib_name']).$bold_e."</a>";
									echo "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
								}
								
								$bold_s2 = ( $_GET['lib']	== "" ) ? "<b>" : "";
								$bold_e2 = ( $_GET['lib']	== "" ) ? "</b>" : "";
								
								echo "<a href='index.php?main=List_View_Rows&type=".$_GET['type']."&unk=".$_GET['unk']."&sesid=".$_GET['sesid']."' class='maintext'>".$bold_s2.$word[LANG]['all_folder'].$bold_e2."</a>";
							echo "</td>";
						echo "</tr>";
					echo "</table>";
				echo "</td>";
			echo "</tr>";
			echo "<tr><td height=30 colspan=15></td></td>";
		}
		if( $_GET['type'] == "video" )
		{
			echo "<tr>";
				echo "<td colspan=15>";
					echo "<table border=\"0\" cellspacing=\"0\" cellpadding=\"0\" class=\"maintext\">";
						echo "<tr>";
							echo "<td>";
								$sql = "select * from user_video_cat where deleted = '0' and active = '0' and unk = '".$_REQUEST['unk']."'";
								$rescat = mysql_db_query(DB,$sql);
								
								while( $dataCat = mysql_fetch_array($rescat) )
								{
									$bold_s = ( $dataCat['id']	== $_GET['cat'] ) ? "<b>" : "";
									$bold_e = ( $dataCat['id']	== $_GET['cat'] ) ? "</b>" : "";
									
									echo "<a href='index.php?main=List_View_Rows&type=".$_GET['type']."&cat=".$dataCat['id']."&unk=".$_GET['unk']."&sesid=".$_GET['sesid']."' class='maintext'>".$bold_s.GlobalFunctions::kill_strip($dataCat['name']).$bold_e."</a>";
									echo "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
								}
								
								$bold_s2 = ( $_GET['cat']	== "" ) ? "<b>" : "";
								$bold_e2 = ( $_GET['cat']	== "" ) ? "</b>" : "";
								
								echo "<a href='index.php?main=List_View_Rows&type=".$_GET['type']."&unk=".$_GET['unk']."&sesid=".$_GET['sesid']."' class='maintext'>".$bold_s2.$word[LANG]['all_cats'].$bold_e2."</a>";
							echo "</td>";
						echo "</tr>";
					echo "</table>";
				echo "</td>";
			echo "</tr>";
			echo "<tr><td height=30 colspan=15></td></td>";
		}
		
		if( $_GET['type'] == "products" )
		{
			$subject_id = ( $_GET['sub'] == "" ) ? "AND subject_id = ''" : "AND subject_id = ".$_GET['sub'];
			$sql = "select * from user_products_cat where unk = '".UNK."' and deleted = '0' and status = '0' ".$subject_id."";
			$rescat = mysql_db_query(DB,$sql);
			
			$sql = "select * from user_products_subject where unk = '".UNK."' and deleted = '0' and active = '0'";
			$res_allcat = mysql_db_query(DB,$sql);
			$data_num_all = mysql_num_rows( $res_allcat );
			
			echo "<tr>";
				echo "<td colspan=15>";
					echo "<table border=\"0\" cellspacing=\"0\" cellpadding=\"0\" class=\"maintext\">";
						if( $data_num_all > 0 )
						{
							echo "<tr>";
								echo "<td align=\"right\" valign=top>";
								
									while( $data_all = mysql_fetch_array($res_allcat) )
									{
										$bold_s = ( $data_all['id'] == $_GET['sub']) ? "<b>" : "<A href='index.php?main=List_View_Rows&type=".$_GET['type']."&cat=".$_GET['cat']."&sub=".$data_all['id']."&unk=".$_GET['unk']."&sesid=".$_GET['sesid']."' class='maintext'>";
										$bold_e = ( $data_all['id'] == $_GET['sub']) ? "</b>" : "</a>";
										echo $bold_s.stripslashes($data_all['name']).$bold_e;
										echo "&nbsp;&nbsp;&nbsp;";
									}
									
								echo "</td>";
							echo "</tr>";
								
										
						}
							echo "<tr><td height=10></td></tr>";
							echo "<tr><td>";
						
								while( $data = mysql_fetch_array($rescat) )
								{
									$bold_s = ( $data['id'] == $_GET['cat'] ) ? "<b>" : "<A href='index.php?main=List_View_Rows&type=".$_GET['type']."&cat=".$data['id']."&sub=".$_GET['sub']."&unk=".$_GET['unk']."&sesid=".$_GET['sesid']."' class='maintext'>";
									$bold_e = ( $data['id'] == $_GET['cat'] ) ? "</b>" : "</a>";
									echo $bold_s.stripslashes($data['name']).$bold_e;
									echo "&nbsp;&nbsp;&nbsp;";
								}
								
							echo "</td></tr>";
						echo "<tr><td height=5></td></tr>";
					echo "</table>";
				echo "</td>";
			echo "</tr>";
			echo "<tr><td height=30 colspan=15></td></td>";
		}
		
		if( $_GET['type'] == "sales" || $_GET['type'] == "wanted" || $_GET['type'] == "guide_business" )
		{
			echo "<tr>";
				echo "<td colspan=15>";
					echo "<form action='index.php' name='sales_search' method='get' style=''padding:0; margin:0;>";
					echo "<input type='hidden' name='main' value='List_View_Rows'>";
					echo "<input type='hidden' name='type' value='".$_GET['type']."'>";
					echo "<input type='hidden' name='unk' value='".$_GET['unk']."'>";
					echo "<input type='hidden' name='sesid' value='".$_GET['sesid']."'>";
					echo "<table border=\"0\" cellspacing=\"0\" cellpadding=\"0\" class=\"maintext\">";
						echo "<tr>";
							echo "<td>פעיל באתר: </td>";
							echo "<td width='10'></td>";
							echo "<td>";
								$select0 = ( $_GET['s_status'] == "0" ) ? "selected" : "";
								$select1 = ( $_GET['s_status'] == "1" ) ? "selected" : "";
								echo "<select name='s_status' class='input_style' style='width: 80px;'>
									<option value=''>הכל</option>
									<option value='0' ".$select0.">כן</option>
									<option value='1' ".$select1.">לא</option>
								</select>
							</td>";
							echo "<td width='10'></td>";
							echo "<td align=left><input type='submit' class='submit_style' value='חפש!'></td>";
						echo "</tr>";
						
					echo "</table>";
					echo "</form>";
				echo "</td>";
			echo "</tr>";
			echo "<tr><td height=7 colspan=15></td></td>";
		}
		
		
		
		echo "<tr>";
			if( is_array($arr_fields) )	{
			foreach( $arr_fields as $val => $key )	{
				echo "<td><strong>".$key."</strong></td>";
				echo "<td width=\"20\"></td>";
			}
			}
			echo "<td><strong>".$word[LANG]['edit']."</strong></td>";
			if( $_GET['type'] != "10service_product" )
			{
			echo "<td width=\"20\"></td>";
			echo "<td><strong>".$word[LANG]['delete']."</strong></td>";
			}
			
			if( $table == "user_contact_forms" ){
				echo "<td width=3></td><td></td>";
				$lead = new leadSys();				
			}
			echo "<td><strong><td>בחר הכל <input type='checkbox' name='selected_rows_helper' class='all_rows_selector' value='0' ></strong></td>";
		echo "</tr>";
		
		echo "<form action='index.php' name='selected_contact_form' method='post'>";
		echo "<input type='hidden' name='main' value='selected_contact_change_status'>";
		echo "<input type='hidden' name='type' value='".$_GET['type']."'>";
		echo "<input type='hidden' name='status' value='".$_GET['status']."'>";
		echo "<input type='hidden' name='unk' value='".UNK."'>";
		echo "<input type='hidden' name='sesid' value='".SESID."'>";
		echo "<tr $opened_state_style><td height=\"3\" colspan=\"20\"></td></tr>";	
		$rowIndex = -1;

		while( $data = mysql_fetch_array($res) )	{
			if( $table == "user_contact_forms" ){
				if($_GET['val'] != ""){
					if(substr( $_GET['val'], 0, 4 ) === "cid:"){
						if($data['phone_lead_id'] == ""){
							continue;
						}
						$did_filter_sql = "SELECT did FROM sites_leads_stat WHERE id = '".$data['phone_lead_id']."'";
						
						$did_filter_res = mysql_db_query(DB,$did_filter_sql);
						$did_info = mysql_fetch_array($did_filter_res);
						$cid_phone = str_replace("cid:","",$_GET['val']);
						$phone_callto = trim($cid_phone);
						if($phone_callto != $did_info['did']){
							continue;
						}
					}								
				}
			}
			$rowIndex++;
			$opened_state_style = "";
			if(isset($data['opened'])){
				if($data['opened']!=0){
					$opened_state_style = " style='background:#C5C5FF;' ";
				}
			}
			
			echo "<tr $opened_state_style><td colspan=\"20\"><hr width=\"100%\" size=\"1\" style='margin-top:0px;' color=\"#b3b3b3\"></td></tr>";
			echo "<tr $opened_state_style><td height=\"3\" colspan=\"20\"></td></tr>";
			
			echo "<tr $opened_state_style>";
				if( is_array($arr_fields) )	{	
					foreach( $arr_fields as $val => $key )	{
						switch($val)	{
							case "date_in" :
								$srttings = "";
								if(isset($data['show_time'])){
									if($data['show_time']!=""){
										$val = 'show_time';
									}
								}								
								$field = GlobalFunctions::show_dateTime_field($data[$val]);

								switch($data['lead_recource'])	{
									case "phone":
										$recording_a = "";
										$recording_a_z = "";
										$sql_phone = "SELECT * FROM sites_leads_stat WHERE id = ".$data['phone_lead_id'];
										$res_phone = mysql_db_query(DB,$sql_phone);
										$phone_lead_data = mysql_fetch_array($res_phone);										
										if($_GET['val'] != "" || $datauser_set['enableRecordingsView']=='1'){
											if(substr( $_GET['val'], 0, 4 ) === "cid:"   || $datauser_set['enableRecordingsView']=='1'){

												
												if($phone_lead_data['recordingfile'] != ""){
													if($phone_lead_data['link_sys_id'] == "0"){
													//	$recording_a_z = "</a>";
													//	$recording_a = "<a target='_blank' href='https://212.143.60.5/index.php?menu=monitoring&action=display_record&id=".$phone_lead_data['uniqueid']."&rawmode=yes' class='maintext'>";
													}
													else{
														$recording_a_z = "</a>";
														$recording_a = "<a target='_blank' href='http://ilbiz.co.il/site-admin/recording_handlers/download.php?filename=".$phone_lead_data['recordingfile']."' class='maintext'>";
													}
												}
											}
										}
										$call_str = "התקבל&nbsp;בשיחת&nbsp;טלפון";
										if($phone_lead_data['answer'] == "ANSWERED"){
											$call_str .= "(".$phone_lead_data['billsec']."שנ')";
										}
										elseif($phone_lead_data['answer'] == "MESSEGE"){
											
											$call_str .= "יש לחזור למספר - ".$phone_lead_data['extra']."";
										}
										else{
											$call_str = "<b style='font-size:16px;color:red;'>שיחה&nbsp;שלא&nbsp;נענתה</b>";
										}
										$field .= "<br/>$recording_a<font color='blue'>$call_str</font>$recording_a_z";	break;
								}
							break;
							
							case "end_date" :
							case "date1" :
								$srttings = "";
								$field = GlobalFunctions::date_fliper($data[$val]);
							break;
							
							case "content" :
								$srttings = "width=\"300\"";
								
								if( strlen($data[$val]) < 100 )
									$field = nl2br(htmlspecialchars(stripslashes($data[$val])));
								else
									$field = strrrchr(nl2br(htmlspecialchars(stripslashes($data[$val]))),"100");
									
							break;
								  
							case "status" :
							case "active" :
								switch($table)	{
									case "user_contact_forms" :
									case "user_e_card_forms" :
										switch($data[$val])	{
											case "0":	$field = $word[LANG]['Interested_service'];	break;
											case "1":	$field = $word[LANG]['talked_with_him'];	break;
											case "2":	$field = $word[LANG]['Close_customer'];	break;
											case "3":	$field = $word[LANG]['Registered_customers'];	break;
											case "4":	$field = $word[LANG]['Not_relevant'];	break;
											case "5":	$field = $word[LANG]['Waiting_phone'];	break;
											case "6":	$field = $word[LANG]['Lead_Refunded'];	break;
										}
									break;
									
									case "user_gb_response" :
										switch($data[$val])	{
											case "0":	$field = $word[LANG]['new_response'];	break;
											case "1":	$field = $word[LANG]['approved_response'];	break;
											case "2":	$field = $word[LANG]['irrelevant_response'];	break;
										}
									break;
									
									case "user_products_cat" :
									case "user_gallery_cat" :
									case "user_video_cat" :
									case "user_articels_cat" :
									case "user_design_page_cat" :
									case "user_images_cat_subject" :
									case "user_products_subject" :
										switch($data[$val])	{
											case "0":	$field = $word[LANG]['yes'];	break;
											case "1":	$field = $word[LANG]['no'];	break;
										}
									break;
								}
							break;
							
							case "lock_edit" :
							case "lock_10service" :
								$srttings = "";
								switch($data[$val])	{
									case "0":	$field = "<font color='red'>לא</font>";	break;
									case "1":	$field = "כן";	break;
								}
							break;
							case "approved_by_admin" :
								$srttings = "";
								switch($data[$val])	{
									case "0":	$field = "<font color='red'>לא</font>";	break;
									case "1":	$field = "כן";	break;
								}
							break;							
							case "phone":
								if($data['payByPassword'] == "1")
								{
									$field = $data[$val];
									//$field = $data[$val]."<br/><b style='color:red;'>".$data['id']."</b>";
									if($data['status'] == '6'){
										$field = $data[$val]."<br/><b style='color:green;'>התקבל זיכוי</b>";
									}
									else{
										$sql_refund = "SELECT * FROM leads_refun_requests WHERE row_id = ".$data['id']." ORDER BY id desc LIMIT 1";
										$res_refund = mysql_db_query(DB,$sql_refund);
										$data_refund = mysql_fetch_array($res_refund);
										if($data_refund['id']!=""){
											$field = $data[$val]."<br/><b style='color:red;'>התקבלה בקשה לזיכוי(".$data_refund['comment'].")</b>";
											if($data_refund['denied'] != '0'){
												$field = $data[$val]."<br/><b style='color:red;'>בקשה לזיכוי נדחתה(".$data_refund['admin_comment'].")</b>";
											}
										}
									}
								}
								else
								{
									$field = substr_replace( $data[$val] , "****" , 4 , 4 );
								}
											
							break;
							
							default :
								$srttings = "";
								$field = nl2br(htmlspecialchars(stripslashes($data[$val])));
									
						}
						echo "<td valign=\"top\" ".$srttings.">".$field."</td>";
						echo "<td width=\"20\"></td>";
					}
				}
				if( $table == "content_pages" )
					echo "<td valign=\"top\"><a href=\"?main=text&type=".$data['id']."&text_id=".$data['id']."&unk=".$_REQUEST['unk']."&sesid=".$_REQUEST['sesid']."\" class=\"mainext\">".$word[LANG]['edit']."</a></td>";
				elseif( $_GET['type'] == "sales" || $_GET['type'] == "wanted" )
					echo "<td valign=\"top\"><a href=\"?main=get_create_form&type=".$_REQUEST['type']."&row_id=".$data['id']."&unk=".$_REQUEST['unk']."&sesid=".$_REQUEST['sesid']."&s_status=".$_REQUEST['s_status']."\" class=\"mainext\">".$word[LANG]['edit']."</a></td>";
				elseif( $_GET['type'] == "einYahav" )
					echo "<td valign=\"top\"><a href=\"?main=get_create_form&type=".$_REQUEST['type']."&sub_type=".$_REQUEST['sub_type']."&row_id=".$data['id']."&unk=".$_REQUEST['unk']."&sesid=".$_REQUEST['sesid']."\" class=\"mainext\">".$word[LANG]['edit']."</a></td>";
				else 
					echo "<td valign=\"top\"><a href=\"?main=get_create_form&type=".$_REQUEST['type']."&row_id=".$data['id']."&unk=".$_REQUEST['unk']."&sesid=".$_REQUEST['sesid']."\" class=\"mainext\">".$word[LANG]['edit']."</a></td>";
				
				if( $_GET['type'] != "10service_product" )
				echo "<td width=\"20\"></td>";
				
				if( $_GET['type'] == "10service_product" )
					echo "";
				elseif( $_GET['type'] == "sales" || $_GET['type'] == "wanted" )
					echo "<td valign=\"top\"><a href=\"?main=DEL_row&table=".$table."&type=".$_REQUEST['type']."&back_to=".$back_to."&row_id=".$data['id']."&unk=".$_REQUEST['unk']."&sesid=".$_REQUEST['sesid']."&s_status=".$_REQUEST['s_status']."\" class=\"mainext\" onclick=\"return can_i_del()\">".$word[LANG]['delete']."</a></td>";
				elseif( $_GET['type'] == "einYahav" )
					echo "<td valign=\"top\"><a href=\"?main=DEL_row&table=".$table."&type=".$_REQUEST['type']."&sub_type=".$_REQUEST['sub_type']."&back_to=".$back_to."&row_id=".$data['id']."&unk=".$_REQUEST['unk']."&sesid=".$_REQUEST['sesid']."\" class=\"mainext\" onclick=\"return can_i_del()\">".$word[LANG]['delete']."</a></td>";
				else
					echo "<td valign=\"top\"><a href=\"?main=DEL_row&table=".$table."&type=".$_REQUEST['type']."&back_to=".$back_to."&row_id=".$data['id']."&unk=".$_REQUEST['unk']."&sesid=".$_REQUEST['sesid']."\" class=\"mainext\" onclick=\"return can_i_del()\">".$word[LANG]['delete']."</a></td>";
				
				if( $table == "user_contact_forms" || $table == "user_e_card_forms" || $table == "content_pages")
					echo "<td width=3></td><td><input type='checkbox' name='selected_rows[]' class='selected_rows' value='".$data['id']."' ></td>";
			echo "</tr>";
			echo "<tr $opened_state_style><td height=\"3\" colspan=\"20\"></td></tr>";			
		}
		echo "
			<script type='text/javascript'>
				jQuery('.all_rows_selector').change(function(){
					if(jQuery(this).attr('checked')){
						select_all_rows();
					}
					else{
						unselect_all_rows();
					}
				});
				function select_all_rows(){
					jQuery('.selected_rows').attr('checked', true);
				}
				function unselect_all_rows(){
					jQuery('.selected_rows').attr('checked', false);
				}
			</script>
		";
		if( $table == "user_contact_forms" || $table == "user_e_card_forms" || $table == "content_pages" )
		{
			echo "<tr><td colspan=15 height=6></td></tr>";
			echo "<tr>";
				echo "<td colspan=15 align=left>סמן את הרשומות לביצוע הפעולה הבאה:<br>";
					echo "<select name='contact_status' class='input_style' style='width: 120px;' onchange='selected_contact_form.submit()'>
						<option>בחירת פעולה</option>
						";
					if($table == "user_contact_forms" || $table == "user_e_card_forms" ){
						echo "
							<option value='1'>לא רלוונטי</option>
						";
					}					
					echo "
						<option value='2'>מחיקה</option>
					";
					echo "
					</select>";
				echo "</td>";
			echo "</tr>";
			echo "<tr><td colspan=15 height='40px'></td></tr>";
			echo "<tr><td colspan=15 height='40px'></td></tr>";
		}
		
	echo "</form>";
	echo "</table>";

}


function getLimitPagentionAdmin( $params=array() )
{
	$limitInPage = $params['limitInPage'];
	$numRows = $params['numRows'];
	$limitcount = $params['limitcount'];
	$main = $params['main'];
	$type = $params['type'];
	
	echo "<table align=center border=0 cellspacing=\"0\" width=100% cellpadding=\"3\" class=\"maintext\">";
		
		if( $numRows > $limitInPage )
		{
			echo "<tr>";
				echo "<td align=center>";
				
					$z = 0;
					for($i=0 ; $i < $numRows ; $i++)
					{
						$pz = $z+1;
						
						if($i % $limitInPage == 0)
						{
								if( $i == $limitcount )
									$classi = "<strong style=\"color:#000000\">".$pz."</strong>&nbsp;&nbsp;";
								else
									$classi = "<a href='index.php?main=".$main."&type=".$type."&unk=".UNK."&sesid=".SESID."&limit=".$i."' class='maintext'>".$pz."</a>&nbsp;&nbsp;";
								
								echo $classi;
								
								$z = $z + 1;
						}
					}
				echo "</td>";
			echo "</tr>";
		}
	echo "</table>";
}


function selected_contact_change_status()
{
	
	foreach( $_POST['selected_rows'] as $val => $key )
	{
		$table_name = false;
		if($_REQUEST['type'] == "contact"){
		 $table_name = "user_contact_forms";
		}
		if($_REQUEST['type'] == "e_card_forms"){
		 $table_name = "user_e_card_forms";
		}	
		if($_REQUEST['type'] == "update_pages"){
			$table_name = "content_pages";			
		}		
		switch( $_POST['contact_status'] )
		{
			case "1" :
				$sql = "UPDATE $table_name SET status = '4' WHERE id = '".$key."' LIMIT 1";
				$res = mysql_db_query(DB,$sql);
			break;
			
			case "2" :
				$sql = "UPDATE $table_name SET deleted = '1' WHERE id = '".$key."' LIMIT 1";
				$res = mysql_db_query(DB,$sql);
			break;
		}
	}
	
	echo "<script>window.location.href='index.php?main=List_View_Rows&type=".$_POST['type']."&status=".$_POST['status']."&unk=".UNK."&sesid=".SESID."';</script>";
		exit;
}

function AdvProgramAndMessages()
{
	global $word,$data_extra_settings,$temp_word_contact;
	
	$sql = "select have_homepage,have_topmenu,max_free_text,have_ecom,have_users_auth,have_event_board from users where unk = '".UNK."' and deleted = '0'";
	$res = mysql_db_query(DB,$sql);
	$data_settings = mysql_fetch_array($res);
	
	$sql_extra_settings = "select agreement_10service_site,agreement_10service_products,belongTo10service from user_extra_settings where unk = '".UNK."'";
	$res_extra_settings = mysql_db_query(DB,$sql_extra_settings);
	$data_extra_settings = mysql_fetch_array($res_extra_settings);
	
	echo "<table border=\"0\" cellspacing=\"0\" cellpadding=\"0\" class=\"maintext\" width=580>";
		
		/*if( ( agreement_have_2 == "0") && $data_extra_settings['belongTo10service'] == "1" )
		{
			echo "<tr>";
			
				echo "<td width=580 bgcolor=#B90000 valign=top>";
					echo "<table border=\"0\" cellspacing=\"0\" cellpadding=\"0\" class=\"maintext\">";
						echo "<tr>";
							echo "<td width=5></td>";
							echo "<td>";
								echo "<table border=\"0\" cellspacing=\"0\" cellpadding=\"0\" class=\"maintext\" style='color: white;'>";
									echo "<tr><td height=15></td></tr>";
									echo "<tr>";
										echo "<td>";
											if( agreement_have_2 == "0" )
											{
												echo "כדי לפרסם בחינם דיל קופון ודילים חצי מחיר באתר שירות 10 יש למלא את ההסכם <a href='http://www.il-biz.com/site/agreement_10service_products.pdf' class='maintext' style='color: white;' target='_blank'>קובץ ההסכם</a><br><br>";
												echo "למידע אודות <a href='http://10service.co.il/landing.php?ld=60' class='maintext' style='color: white;' target='_blank'><b>דיל קופון</b></a>";
												echo "&nbsp;&nbsp;&nbsp;|&nbsp;&nbsp;&nbsp;<a href='http://10service.co.il/landing.php?ld=42' class='maintext' style='color: white;' target='_blank'><b>חצי מחיר</b></a><br><br>";
											}
										echo "</td>";
									echo "</tr>";
								echo "</table>";
							echo "</td>";
							echo "<td width=5></td>";
						echo "</tr>";
					echo "</table>";
				echo "</td>";
			echo "</tr>";
		}*/
		
		$sql = "SELECT end_date FROM users WHERE deleted=0 AND status=0 AND unk = '".UNK."'";
		$usersRes = mysql_db_query(DB,$sql);
		$dataUser_expire = mysql_fetch_array($usersRes);
		
		$ex_end = explode("-" , $dataUser_expire['end_date'] );
		
		$DateDiffAry = GetDateDifference(date(m).'/'.date(d).'/'.date(Y) , $ex_end[1].'/'.$ex_end[2].'/'.$ex_end[0] ); 
		
		
		$sql = "SELECT hostPriceMon,domainPrice,domainEndDate FROM user_bookkeeping WHERE unk = '".UNK."'";
		$res = mysql_db_query(DB, $sql);
		$dataPrice = mysql_fetch_array($res);
		
		$ex_endDOMAIN = explode("-" , $dataPrice['domainEndDate'] );
		
		$DateDiffAry_domain = GetDateDifference(date(m).'/'.date(d).'/'.date(Y) , $ex_endDOMAIN[1].'/'.$ex_endDOMAIN[2].'/'.$ex_endDOMAIN[0] ); 
		
		
		if( $DateDiffAry['DaysSince'] <= 30 && $DateDiffAry['DaysSince'] > -30 && $dataPrice['hostPriceMon'] > 0 )
		{
			if( $data_extra_settings['belongTo10service'] == "1" )
			{
				$creditMoney = new creditMoney;
				
				if( $creditMoney->get_creditMoney("users" , UNK , "1") > "0" )
					$add_string_credits = "<li><a href='index.php?main=payWithCredits&payToType=1&unk=".UNK."&sesid=".SESID."' class='maintext' style='color: #ffffff;'>באמצעות קרדיטים</a></li>";
			}
			
		echo "<tr>";
			
			echo "<td width=580 bgcolor=#B90000 valign=top>";
				echo "<table border=\"0\" cellspacing=\"0\" cellpadding=\"0\" class=\"maintext\">";
					echo "<tr>";
						echo "<td width=5></td>";
						echo "<td>";
							echo "<table border=\"0\" cellspacing=\"0\" cellpadding=\"0\" class=\"maintext\" style='color: white;'>";
								echo "<tr><td height=5></td></tr>";
								echo "<tr>";
									
									$month = $dataPrice['hostPriceMon'];
									$totalYear_whitoutMAAM = $dataPrice['hostPriceMon']*12;
									$maam = (MAAM*$totalYear_whitoutMAAM)/100;
									$totalYear = $totalYear_whitoutMAAM + $maam;
									//$nikoiMas = ( $totalYear_whitoutMAAM + $maam ) * 0.02 ;
									//$totalYear_NEW = $totalYear - $nikoiMas;
									
									echo "<td>
בעוד <b dir=ltr>".round($DateDiffAry['DaysSince'])."</b> ימים יפוג תוקף האתר.<br>
<br>
כדי שהמערכת האוטומטית לא תוריד את אתרך מהאינטרנט בתאריך הנ\"ל  יש לבצע תשלום <br>
 <br>
פירוט תשלום :<br>
 <br>
עלות אחסון חודשית ".myround($month)." ₪ + מע\"מ <br>
סה\"כ תשלום <b>".myround($totalYear)." ₪</b> כולל מע\"מ<br>
 <br>
 <br>
ניתן לחדש את אחסון האתר באחת מהדרכים הבאות  :
<ol>

".$add_string_credits."
<li>באמצעות כרטיס אשראי, עד 12 תשלומים ללא רבית והצמדה, <a href='index.php?main=payWithCC&payToType=1&unk=".UNK."&sesid=".SESID."' class='maintext' style='color: #ffffff;'><b>לחץ כאן לטופס סליקה</b></a> <b>*</b> &nbsp;&nbsp; <a href='index.php?main=payWithCC&payToType=1&unk=".UNK."&sesid=".SESID."'><img src='images/paypage_61.gif' border=0></a></li>
<li>צ'ק לכתובת : פארק אופיר 50, באר שבע , מיקוד : 84887 </li>
<li>הפקדה לחשבון בנק ע\"ש איי. אל. ביז קידום עסקים באינטרנט בע\"מ, בנק הפועלים, סניף 160 , מספר חשבון 71732</li>
</ol>
<b>* לאחר התשלום ישלח לאימייל שיצויין בטופס, חשבונית מס קבלה מקורית עם חתימה דגיטלית</b><br><br>

אם שולם באמצעות הפקדת כסף לחשבון הבנק או לחילופין נשלח צ'ק, נא להודיע באמצעות שליחת פנייה <a href='http://www.ilbiz.co.il/helpdesk/index.php?unk=".UNK."&sesid=".SESID."' class='maintext' style='color: #ffffff;' target='_blank'>לשירות לקוחות</a><br><br>
<b>*** עלות החזרת אתר שהורד על ידי המערכת האוטומטית מהאינטרנט  – 250 ₪ + מע\"מ</b>
									</td>";
								echo "</tr>";
								//הפקדה לחשבון בנק ע\"ש IL-BIZ קידום  עסקים באינטרנט, מספר  בנק הפועלים, סניף 594 , מספר חשבון 442214
							echo "</table>";
						echo "</td>";
						echo "<td width=5></td>";
					echo "</tr>";
				echo "</table>";
			echo "</td>";
			// ---------------------------------------------------
			echo "<tr><td height=15></td></tr>";
		}
		
		if( $DateDiffAry_domain['DaysSince'] <= 30 && $DateDiffAry_domain['DaysSince'] > -30 && $dataPrice['domainPrice'] > 0)
		{
			if( $data_extra_settings['belongTo10service'] == "1" )
			{
				$creditMoney = new creditMoney;
				
				if( $creditMoney->get_creditMoney("users" , UNK , "1") > "0" )
					$add_string_credits = "<li><a href='index.php?main=payWithCredits&payToType=2&unk=".UNK."&sesid=".SESID."' class='maintext' style='color: #ffffff;'>באמצעות קרדיטים</a></li>";
			}
		$maam = (MAAM*$dataPrice['domainPrice'])/100;
		$domainYear = $dataPrice['domainPrice'] + $maam;
		
		//$nikoiMas = ( $domainYear ) * 0.02 ;
		//$domainYear_NEW = $domainYear - $nikoiMas;
		
		echo "<tr>";
			
			echo "<td width=580 bgcolor=#B90000 valign=top>";
				echo "<table border=\"0\" cellspacing=\"0\" cellpadding=\"0\" class=\"maintext\">";
					echo "<tr>";
						echo "<td width=5></td>";
						echo "<td>";
							echo "<table border=\"0\" cellspacing=\"0\" cellpadding=\"0\" class=\"maintext\" style='color: white;'>";
								echo "<tr><td height=5></td></tr>";
								echo "<tr>";
									
									
									echo "<td>
בעוד <b dir=ltr>".round($DateDiffAry_domain['DaysSince'])."</b> ימים יפוג תוקף הדומיין.<br>
<br>
פירוט תשלום :<br>
 <br>
עלות דומיין כולל מע\"מ <b>".myround($domainYear)." ₪</b> לשנה
 <br>
 <br>
ניתן לחדש את הדומיין באחת מהדרכים הבאות :
<ol>
".$add_string_credits."
<li>באמצעות כרטיס אשראי, עד 12 תשלומים ללא רבית והצמדה, <a href='index.php?main=payWithCC&payToType=2&unk=".UNK."&sesid=".SESID."' class='maintext' style='color: #ffffff;'><b>לחץ כאן לטופס סליקה</b></a> <b>*</b> &nbsp;&nbsp; <a href='index.php?main=payWithCC&payToType=2&unk=".UNK."&sesid=".SESID."'><img src='images/paypage_61.gif' border=0></a></li>
<li>צ'ק לכתובת : פארק אופיר 50, באר שבע , מיקוד : 84887 </li>
<li>הפקדה לחשבון בנק ע\"ש איי. אל. ביז קידום עסקים באינטרנט בע\"מ, בנק הפועלים, סניף 160 , מספר חשבון 71732</li>
</ol>
אם שולם באמצעות הפקדת כסף לחשבון הבנק או לחילופין נשלח צ'ק, נא להודיע באמצעות שליחת פנייה <a href='http://www.ilbiz.co.il/helpdesk/index.php?unk=".UNK."&sesid=".SESID."' class='maintext' style='color: #ffffff;' target='_blank'>לשירות לקוחות</a><br><br>
<b>* לאחר התשלום ישלח לאימייל שיצויין בטופס, חשבונית מס קבלה מקורית עם חתימה דגיטלית</b><br>
									</td>";
								echo "</tr>";
								
							echo "</table>";
						echo "</td>";
						echo "<td width=5></td>";
					echo "</tr>";
				echo "</table>";
			echo "</td>";
			// ---------------------------------------------------
			echo "<tr><td height=15></td></tr>";
		}


	$sql_Fee = "SELECT lf.*, DATE_FORMAT(lf.until_date,'%d-%m-%Y') as untilDate , pay.payGood FROM ilbiz_launch_fee AS lf LEFT JOIN ilbizPayByCCLog as pay ON lf.order_id = pay.id WHERE unk = '".UNK."' AND deleted=0 ORDER BY lf.id DESC";
	$res_Fee = mysql_db_query(DB,$sql_Fee);
	$num = mysql_num_rows($res_Fee);
	
	if( $num > 0 )
	{
		echo "<tr>";
			
			echo "<td width=580 bgcolor=#B90000 valign=top>";
				echo "<table border=\"0\" cellspacing=\"0\" cellpadding=\"0\" class=\"maintext\">";
					echo "<tr>";
						echo "<td width=5></td>";
						echo "<td>";
							echo "<table border=\"0\" cellspacing=\"0\" cellpadding=\"0\" class=\"maintext\" style='color: white;'>";
								
								$height_15 = 0;
								while( $dataFee = mysql_fetch_array($res_Fee) )
								{
									if( $dataFee['payGood'] != "2" )
									{
										if( $data_extra_settings['belongTo10service'] == "1" )
										{
											$creditMoney = new creditMoney;
											
											if( $creditMoney->get_creditMoney("users" , UNK , "1") > "0" )
												$add_string_credits = "<a href='pay.php?uniqueSes=".$dataFee['uniqueSes']."' class='maintext' style='color: #ffffff;' target='_blank'>ניתן לשלם באמצעות קרדיטים</a><br>";
										}
										
										if( $height_15 == 0 )
										{
											
											echo "<tr><td height=5></td></tr>";
											
											echo "<tr>";
												echo "<td><b>רשימת חובות:</b></td>";
											echo "</tr>";
											echo "<tr><td height=5></td></tr>";
											
										}
										
										$ex_endFee = explode("-" , $dataFee['until_date'] );
										$DateDiffAry_fee = GetDateDifference(date(m).'/'.date(d).'/'.date(Y) , $ex_endFee[1].'/'.$ex_endFee[2].'/'.$ex_endFee[0] ); 
										
										echo "<tr>";
											echo "<td>".stripslashes($dataFee['details']).".<br> עלות: <b>".$dataFee['price']." כולל מע\"מ.</b><br> נותרו עוד <b>".$DateDiffAry_fee['DaysSince']."</b> ימים לתשלום החוב.<br>
											<br>".$add_string_credits."
											ניתן לשלם באמצעות כרטיס אשראי, עד ".$dataFee['tash']." תשלומים ללא רבית והצמדה, <a href='pay.php?uniqueSes=".$dataFee['uniqueSes']."' class='maintext' style='color: #ffffff;' target='_blank'><b>לחץ כאן לתשלום</b></a> &nbsp;&nbsp; <a href='pay.php?uniqueSes=".$dataFee['uniqueSes']."' target='_blank'><img src='images/paypage_61.gif' border=0></a><br>חשבונית מס קבלה תישלח אליכם לכתובת האימייל שתציינו לאחר סיום התשלום.";
										echo "<br><br>
										<b>כתובת עבור העברה בנקאית:</b><br>
											חשבון 71732 , בנק הפועלים, סניף 160, ח.פ 514351097<br><br>
										
											<b>ניתן לשלם באמצעות אפליקצית ביט:</b>  052-5572555<br>
										</td>";
										
										echo "</tr>";
										echo "<tr><td height=5></td></tr>";
										
										
										echo "<tr><td><hr color='#ffffff' size=1 width=100%></td></tr>";
										echo "<tr><td height=5></td></tr>";
										
										$height_15 = 1;
									}
								}
								
							echo "</table>";
						echo "</td>";
						echo "<td width=5></td>";
					echo "</tr>";
				echo "</table>";
			echo "</td>";
			// ---------------------------------------------------
			if( $height_15 == 1 )
			echo "<tr><td height=15></td></tr>";
	}
	
		
if( $_SESSION['endDate_userAcount'] != "21k" )
{
	
		// הודעות מערכת
		$sql = "SELECT massg.* , u.id as user_id FROM usersMessageSinon as massg , users as u , user_extra_settings as uxs WHERE 
			massg.deleted = '0' AND
		  massg.status = '0' AND
		  u.status = '0' AND
			u.deleted = '0' AND
			u.unk = '".UNK."' AND
			u.unk = uxs.unk AND
			
			( massg.send_city = u.city OR massg.send_city = '0' ) AND
			( massg.send_gender = u.gender OR massg.send_gender = '0' )  AND
			( u.birthday <= massg.send_birthday_start OR massg.send_birthday_start = '0000-00-00' )  AND
			( u.birthday <= massg.send_birthday_end OR massg.send_birthday_end = '0000-00-00' ) AND
			( u.insert_date <= massg.date_sent OR u.insert_date = '0000-00-00' ) AND 
				(
					( massg.client_10service = '2' AND uxs.belongTo10service != '1' ) OR
					( massg.client_10service = '1' AND uxs.belongTo10service = '1' ) OR
					( massg.client_10service = '0' )
				)
			ORDER BY massg.id DESC
		";
		$resMassg = mysql_db_query(DB , $sql );
		
		$count = 0;
		$msgStr = "";
		while( $dataMassg = mysql_fetch_array($resMassg) )
		{
			$sql_checkCat = "SELECT cat_id FROM usersMessageSinon_x_cat WHERE sinon_id = '".$dataMassg['id']."' LIMIT 1";
			$res_checkCat = mysql_db_query(DB,$sql_checkCat);
			$data_checkCat = mysql_fetch_array($res_checkCat);
			
			if( $data_checkCat['cat_id'] != "" )	{
				$sql = "SELECT x.cat_id FROM user_cat as c , usersMessageSinon_x_cat as x WHERE 
								x.sinon_id = '".$dataMassg['id']."' AND x.cat_id=c.cat_id AND c.user_id = '".$dataMassg['user_id']."'";
				$res_cat = mysql_db_query(DB,$sql);
				$data_cat2 = mysql_fetch_array($res_cat);
				
				if( $data_cat2['cat_id'] == '' )
					continue;
			}
			
			
			$date_time = GlobalFunctions::show_dateTime_field($dataMassg['date_sent']);
			
			$row_style = "4B8DF1";
			$moreDateScript = "id='line1_".$dataMassg['id']."' onclick='moreDate(\"line1_".$dataMassg['id']."\" , \"line_".$dataMassg['id']."\" )' style='cursor : pointer; background-color: #".$row_style."; color:#ffffff;' onMouseover='this.style.backgroundColor=\"D0E1FB\"; this.style.color=\"000000\";' onMouseout='this.style.backgroundColor=\"".$row_style."\"; this.style.color=\"ffffff\";' ";
			$msgStr .= "<tr ".$moreDateScript.">";
				$msgStr .= "<td width='15'></td>";
				$msgStr .= "<td><img src='images/small_msg_icon.png'></td>";
				$msgStr .= "<td width='10'></td>";
				$msgStr .= "<td width='500' height=20>".stripslashes($dataMassg['subject'])."</td>";
				$msgStr .= "<td>".$date_time."</td>";
				$msgStr .= "<td width='10'></td>";
			$msgStr .= "</tr>";
			
			$msgStr .= "<tr style='display:none' id='line_".$dataMassg['id']."' style='background-color: #4B8DF1;'>";
				$msgStr .= "<td width='15' style='background-color: #4B8DF1;'></td>";
				$msgStr .= "<td colspan=2 style='background-color: #4B8DF1;'></td>";
				$msgStr .= "<td width='535' colspan=3 style='background-color: #4B8DF1;'>
					<table border=\"0\" cellspacing=\"0\" cellpadding=\"0\" class=\"maintext\" width=100% style=' color: #ffffff'>
						<tr><td height=15 colspan=3></td></tr>
						<tr>
							<td width='15'></td>
							<td>".stripslashes($dataMassg['content'])."</td>
							<td width='15'></td>
						</tr>";
						
						if( $dataMassg['href_link_togo'] != "" && $dataMassg['name_link_togo'] != "" )
						{
							if( eregi("http://",$dataMassg['href_link_togo']) )
								$goto = $dataMassg['href_link_togo'];
							else
								$goto = "http://".$dataMassg['href_link_togo'];
							
							$msgStr .= "<tr><td height=10 colspan=3></td></tr>
							<tr>
								<td width='15'></td>
								<td><a href='".$goto."' class='maintext' style='color: #ffffff;' target='_blank'><u>".stripslashes($dataMassg['name_link_togo'])."</u></a></td>
								<td width='15'></td>
							</tr>";
						}
						
						$msgStr .= "<tr><td height=15 colspan=3></td></tr>
						<tr>
							<td width='15'></td>
							<td>
								<table border=\"0\" cellspacing=\"0\" cellpadding=\"0\" class=\"maintext\" width=100% style=' color: #ffffff'>
									<tr>
										<td align=right></td>
										<td align=left width=40 id='line1_".$dataMassg['id']."' onclick='moreDate(\"line1_".$dataMassg['id']."\" , \"line_".$dataMassg['id']."\" )' style='cursor : pointer; color:#ffffff;'><u>סגור</u></td>
									</tr>
								</table>
							</td>
							<td width='15' style='background-color: #4B8DF1;'></td>
						</tr>
						<tr><td height=15 colspan=3></td></tr>
					</table>
				</td>";
			$msgStr .= "</tr>";
			$msgStr .= "<tr><td height=5 colspan=2></td></tr>";
			
			$count++;
		}
		if( $count > 0 )
		{
			echo "<tr>";
				echo "<td width=580 bgcolor=#c7dbfa valign=top>";
					echo "<table border=\"0\" cellspacing=\"0\" cellpadding=\"0\" class=\"maintext\">";
						echo "<tr>";
							echo "<td width=5></td>";
							echo "<td>";
								echo "<table border=\"0\" cellspacing=\"0\" cellpadding=\"0\" class=\"maintext\">";
									echo "<tr><td height=5></td></tr>";
									echo "<tr>";
										echo "<td class='messagesHeadline'>".$word[LANG]['homepage_system_update']."</td>";
									echo "</tr>";
									echo "<tr><td height=10></td></tr>";
									echo "<tr>";
										echo "<td>";
											echo "<table border=\"0\" cellspacing=\"0\" cellpadding=\"0\" class=\"maintext\" width='550'>";
												echo $msgStr;
											echo "</table>";
										echo "</td>";
									echo "</tr>";
									
								echo "</table>";
							echo "</td>";
							echo "<td width=5></td>";
						echo "</tr>";
					echo "</table>";
				echo "</td>";
			echo "</tr>";
		}
		
		
		
		if( $temp_word_contact ||  AUTH_ID == 0 )
		{
			echo "<tr><td height=15></td></tr>";
			echo "<tr>";
				// פניות אחרונות מצור קשר באתרכם
				$pending_qry = " AND ((send_type != 'pending' OR send_type IS NULL) OR (show_time != '' AND show_time IS NOT NULL)) ";
				$sql = "select date_in,show_time, name, id from user_contact_forms where deleted = 0 and unk = '".UNK."' ".$pending_qry." and status = '0' order by id DESC LIMIT 5";
				$resContact = mysql_db_query(DB , $sql );
				
				echo "<td width=580 bgcolor=white valign=top>";
					echo "<table border=\"0\" cellspacing=\"0\" cellpadding=\"0\" class=\"maintext\">";
						echo "<tr>";
							echo "<td width=5></td>";
							echo "<td>";
								echo "<table border=\"0\" cellspacing=\"0\" cellpadding=\"0\" class=\"maintext\">";
									echo "<tr><td height=5></td></tr>";
									echo "<tr>";
										echo "<td class='messagesHeadline'>".$word[LANG]['homepage_last_contact']."</td>";
									echo "</tr>";
									
									echo "<tr><td height=10></td></tr>";
									
									
									echo "<tr>";
										echo "<td>";
											echo "<table border=\"0\" cellspacing=\"0\" cellpadding=\"0\" class=\"maintext\">";
												
												$count = 0;
												while( $dataContact = mysql_fetch_array($resContact) )
												{
													$time_to_show = $dataContact['date_in'];
													if($dataContact['show_time'] != ""){
														$time_to_show = $dataContact['show_time'];
													}
													$ttemp = explode( " " , GlobalFunctions::show_dateTime_field($time_to_show) );
													$date = $ttemp[0];
													$time = $ttemp[1];
													
													echo "<tr>";
														echo "<td>".$word[LANG]['homepage_at_date']." ".$date."</td>";
														echo "<td width=15></td>";
														echo "<td> ".$word[LANG]['homepage_at_time']." ".$time."</td>";
														echo "<td width=20></td>";
														echo "<td>".$word[LANG]['homepage_recive_contact_from']." <a href='index.php?main=get_create_form&type=contact&row_id=".$dataContact['id']."&unk=".UNK."&sesid=".SESID."' class='maintext'><b>".$dataContact['name']."</b></a></td>";
													echo "</tr>";
													echo "<tr><td height=5 colspan=5></td></tr>";
													
													$count++;
												}
												
												if( $count == 0 )
												{
													echo "<tr>";
														echo "<td>".$word[LANG]['homepage_not_recive_contact']."</td>";
													echo "</tr>";
													echo "<tr><td height=5></td></tr>";
												}
											echo "</table>";
										echo "</td>";
									echo "</tr>";
									
								echo "</table>";
							echo "</td>";
							echo "<td width=5></td>";
						echo "</tr>";
					echo "</table>";
				echo "</td>";
			echo "</tr>";
		}
			
		if( $data_extra_settings['belongTo10service'] == "1" && AUTH_ID == 0 )
		{
			echo "<tr><td height=15></td></tr>";
			echo "<tr>";
			
			// פניות אחרונות מהזמנות משירות 10
			$sql = "SELECT id FROM users WHERE unk = '".UNK."'";
			$res_checkID = mysql_db_query(DB,$sql);
			$data_checkID = mysql_fetch_array($res_checkID);
			
			$site_id_qry = ( $data_checkID['id'] != "793" ) ? "AND site_id = '".$data_checkID['id']."' AND payment_status=2 " : "";
			$sql = "SELECT id, purchase_date , credit_name FROM purchase_tracking WHERE 1 ".$site_id_qry." ORDER BY id DESC LIMIT 5";
			$resTrack = mysql_db_query(DB,$sql);
			
			echo "<td width=580 bgcolor=white valign=top>";
				echo "<table border=\"0\" cellspacing=\"0\" cellpadding=\"0\" class=\"maintext\">";
					echo "<tr>";
						echo "<td width=5></td>";
						echo "<td>";
							echo "<table border=\"0\" cellspacing=\"0\" cellpadding=\"0\" class=\"maintext\">";
								echo "<tr><td height=5></td></tr>";
								echo "<tr>";
									echo "<td class='messagesHeadline'>מעקב הזמנות מאתר שירות 10</td>";
								echo "</tr>";
								
								echo "<tr><td height=10></td></tr>";
								
								
								echo "<tr>";
									echo "<td>";
										echo "<table border=\"0\" cellspacing=\"0\" cellpadding=\"0\" class=\"maintext\">";
											
											$count = 0;
											while( $dataTrack = mysql_fetch_array($resTrack) )
											{
												$ttemp = explode( " " , GlobalFunctions::show_dateTime_field($dataTrack['purchase_date']) );
												$date = $ttemp[0];
												$time = $ttemp[1];
												
												echo "<tr>";
													echo "<td>".$word[LANG]['homepage_at_date']." ".$date."</td>";
													echo "<td width=15></td>";
													echo "<td> ".$word[LANG]['homepage_at_time']." ".$time."</td>";
													echo "<td width=20></td>";
													echo "<td>התקבלה הזמנה מ <a href='index.php?main=purchase_tracking_edit&type=purchase_tracking&trackId=".$dataTrack['id']."&unk=".UNK."&sesid=".SESID."' class='maintext'><b>".$dataTrack['credit_name']."</b></a></td>";
												echo "</tr>";
												echo "<tr><td height=5 colspan=5></td></tr>";
												
												$count++;
											}
											
											if( $count == 0 )
											{
												echo "<tr>";
													echo "<td>".$word[LANG]['homepage_not_recive_contact']."</td>";
												echo "</tr>";
												echo "<tr><td height=5></td></tr>";
											}
										echo "</table>";
									echo "</td>";
								echo "</tr>";
								
							echo "</table>";
						echo "</td>";
						echo "<td width=5></td>";
					echo "</tr>";
				echo "</table>";
			echo "</td>";
			echo "</tr>";
		}
		
			// ---------------------------------------------------
			
			/*
			if( $data_settings['have_ecom'] == "1" )
			{
				echo "<tr>";
				// הזמנות אחרונות מהחנות
				$sql = "select * from user_ecom_orders where unk = '".UNK."' and deleted = '0' and status = '0' ORDER BY id DESC LIMIT 5";
				$resContact = mysql_db_query(DB , $sql );
				
				echo "<td width=580 bgcolor=#fad683 valign=top>";
					echo "<table border=\"0\" cellspacing=\"0\" cellpadding=\"0\" class=\"maintext\">";
						echo "<tr>";
							echo "<td width=5></td>";
							echo "<td>";
								echo "<table border=\"0\" cellspacing=\"0\" cellpadding=\"0\" class=\"maintext\">";
									echo "<tr><td height=5></td></tr>";
									echo "<tr>";
										echo "<td class='messagesHeadline'>הזמנות אחרונות מהחנות</td>";
									echo "</tr>";
									
									echo "<tr><td height=10></td></tr>";
									
									
									echo "<tr>";
										echo "<td>";
											echo "<table border=\"0\" cellspacing=\"0\" cellpadding=\"0\" class=\"maintext\">";
												
												$count = 0;
												while( $dataContact = mysql_fetch_array($resContact) )
												{
													$ttemp = explode( " " , GlobalFunctions::show_dateTime_field($dataContact['date_in']) );
													$date = $ttemp[0];
													$time = $ttemp[1];
													
													echo "<tr>";
														echo "<td>בתאריך ".$date."</td>";
														echo "<td width=15></td>";
														echo "<td> בשעה ".$time."</td>";
														echo "<td width=20></td>";
														echo "<td>התקבלה הודעה מ <a href='index.php?main=get_create_form&type=contact&row_id=".$dataContact['id']."&unk=".UNK."&sesid=".SESID."' class='maintext'><b>".$dataContact['name']."</b></a></td>";
													echo "</tr>";
													echo "<tr><td height=5 colspan=5></td></tr>";
													
													$count++;
												}
												
												if( $count == 0 )
												{
													echo "<tr>";
														echo "<td>אין הזמנות שנקנו דרך האתר.</td>";
													echo "</tr>";
													echo "<tr><td height=5></td></tr>";
												}
											echo "</table>";
										echo "</td>";
									echo "</tr>";
									
								echo "</table>";
							echo "</td>";
							echo "<td width=5></td>";
						echo "</tr>";
					echo "</table>";
				echo "</td>";
				// ---------------------------------------------------
		}*/
	echo "</table>";
}
}

/**************************************************************************************************/

function DEL_row()	{
	
	if( $_GET['type'] == "sales" || $_GET['type'] == "wanted" )
	{
		$image_settings = array(
			after_success_goto=>"index.php?main=List_View_Rows&type=".$_REQUEST['type']."&unk=".$_REQUEST['unk']."&s_status=".$_REQUEST['s_status']."&sesid=".$_REQUEST['sesid'],
			table_name=> $_REQUEST['table'],
		);
	}
	elseif( $_GET['type'] == "einYahav"  )
	{
		$image_settings = array(
			after_success_goto=>"index.php?main=List_View_Rows&type=".$_REQUEST['type']."&sub_type=".$_REQUEST['sub_type']."&unk=".$_REQUEST['unk']."&sesid=".$_REQUEST['sesid'],
			table_name=> $_REQUEST['table'],
		);
	}
	else
	{
		$image_settings = array(
			after_success_goto=>"index.php?main=List_View_Rows&type=".$_REQUEST['type']."&unk=".$_REQUEST['unk']."&sesid=".$_REQUEST['sesid'],
			table_name=> $_REQUEST['table'],
		);
	}
	
	delete_record($_REQUEST['row_id'], $image_settings);
}

define('ROUND_HALF_DOWN', 1);
define('ROUND_HALF_EVEN', 2);
define('ROUND_HALF_UP', 3);

function myround($value, $prec=0, $rounding=1)
{
 list($b, $f) = explode('.', (string) $value);
 $b = (int) $b;
 
 if (($prec - strlen($f)) > 0) {
 	$f *= pow(10, ($prec - strlen($f)));
 }
 
 if (strlen($f) > $prec) {
 	$f1 = (int) substr($f, 0, $prec);
 	$f2 = (int) substr($f, $prec, 1);
 	$f3 = (int) substr($f, $prec-1, 1);
 	
 	if ($rounding === ROUND_HALF_DOWN || ($rounding === ROUND_HALF_EVEN && (($f3 & 1) === 0))) {
 		$f = ($f2 >= 6) ? $f1 + 1 : $f1;
 	} elseif ($rounding === ROUND_HALF_UP || ($rounding === ROUND_HALF_EVEN && (($f3 & 1) === 1))) {
 		$f = ($f2 >= 5) ? $f1 + 1 : $f1;
 	}
 	if ($f === pow(10, $prec)) {
 		++$b;
 		$f = 0;
 		}
 	}
 	
 	$f = sprintf("%0{$prec}d", $f);
 	
 	return (float) ((string) $b . '.' . (string) $f);
 }


/**************************************************************************************************/

function strrrchr($content,$num_of_chars)  {

	$needle = "<now_br_for_summery>";
	$content2 = wordwrap($content, $num_of_chars, $needle);
	// מחזיר אחרי כמה תווים להפסיק את הממשפט 
	return substr($content2,0,strpos($content2,$needle)+0);
}


function funcSetCatForUsers()
{
	
	$sql = "select id from user_wanted where unk = '".$_POST['unk']."' AND id = '".$_POST['wanted_id']."'";
	$res_wanted = mysql_db_query(DB,$sql);
	$data_wanted = mysql_fetch_array($res_wanted);
	$wanted_id = $data_wanted['id'];
	
	$sql = "delete from user_wanted_cats where wanted_id = '".$wanted_id."'";
	$res_del = mysql_db_query(DB,$sql);
	
	foreach( $_POST['select_cat'] as $val => $key )
	{
		if( $key == "1" )
		{
			$sql = "insert into user_wanted_cats ( wanted_id , cat_id ) values ( '".$wanted_id."' , '".$val."' )";
			$res_insert = mysql_db_query(DB,$sql);
		}
	}
	
	echo "<script>alert('הקטגוריות הוכנסו בהצלחה');</script>";
	echo "<script>window.close();</script>";
		exit;
}


function SetCatUniversal()
{
	$sql = "delete from module_cats_belong_10service where x_id = '".$_POST['xid']."' AND x_type = '".$_POST['xtype']."' ";
	$res_del = mysql_db_query(DB,$sql);
	
	foreach( $_POST['select_cat'] as $val => $key )
	{
		if( $key == "1" )
		{
			$sql = "insert into module_cats_belong_10service ( x_id , x_type , cat_id ) values ( '".$_POST['xid']."' ,'".$_POST['xtype']."' , '".$val."' )";
			$res_insert = mysql_db_query(DB,$sql);
		}
	}
	
	echo "<script>alert('הקטגוריות הוכנסו בהצלחה');</script>";
	echo "<script>window.close();</script>";
		exit;
}


function GetDateDifference($StartDateString=NULL, $EndDateString=NULL) { 
  $ReturnArray = array(); 
  
  $SDSplit = explode('/',$StartDateString); 
  $StartDate = mktime(0,0,0,$SDSplit[0],$SDSplit[1],$SDSplit[2]); 
  
  $EDSplit = explode('/',$EndDateString); 
  $EndDate = mktime(0,0,0,$EDSplit[0],$EDSplit[1],$EDSplit[2]); 
  
  $DateDifference = $EndDate-$StartDate; 
  
  $ReturnArray['YearsSince'] = $DateDifference/60/60/24/365; 
  $ReturnArray['MonthsSince'] = $DateDifference/60/60/24/365*12; 
  $ReturnArray['DaysSince'] = $DateDifference/60/60/24; 
  $ReturnArray['HoursSince'] = $DateDifference/60/60; 
  $ReturnArray['MinutesSince'] = $DateDifference/60; 
  $ReturnArray['SecondsSince'] = $DateDifference; 

  $y1 = date("Y", $StartDate); 
  $m1 = date("m", $StartDate); 
  $d1 = date("d", $StartDate); 
  $y2 = date("Y", $EndDate); 
  $m2 = date("m", $EndDate); 
  $d2 = date("d", $EndDate); 
  
  $diff = ''; 
  $diff2 = ''; 
  if (($EndDate - $StartDate)<=0) { 
      // Start date is before or equal to end date! 
      $diff = "0 days"; 
      $diff2 = "Days: 0"; 
  } else { 

      $y = $y2 - $y1; 
      $m = $m2 - $m1; 
      $d = $d2 - $d1; 
      $daysInMonth = date("t",$StartDate); 
      if ($d<0) {$m--;$d=$daysInMonth+$d;} 
      if ($m<0) {$y--;$m=12+$m;} 
      $daysInMonth = date("t",$m2); 
      
      // Nicestring ("1 year, 1 month, and 5 days") 
      if ($y>0) $diff .= $y==1 ? "1 year" : "$y years"; 
      if ($y>0 && $m>0) $diff .= ", "; 
      if ($m>0) $diff .= $m==1? "1 month" : "$m months"; 
      if (($m>0||$y>0) && $d>0) $diff .= ", and "; 
      if ($d>0) $diff .= $d==1 ? "1 day" : "$d days"; 
      
      // Nicestring 2 ("Years: 1, Months: 1, Days: 1") 
      if ($y>0) $diff2 .= $y==1 ? "Years: 1" : "Years: $y"; 
      if ($y>0 && $m>0) $diff2 .= ", "; 
      if ($m>0) $diff2 .= $m==1? "Months: 1" : "Months: $m"; 
      if (($m>0||$y>0) && $d>0) $diff2 .= ", "; 
      if ($d>0) $diff2 .= $d==1 ? "Days: 1" : "Days: $d"; 
      
  } 
  $ReturnArray['NiceString'] = $diff; 
  $ReturnArray['NiceString2'] = $diff2; 
  return $ReturnArray; 
} 


function edit_estimateMiniSiteBlock()
{
	global $temp_word_about,$word;
	

	
	$sql = "select * from content_pages where unk = '".UNK."' and type = '".$_GET['type']."' and deleted = '0'";
	$res = mysql_db_query(DB,$sql);
	$data = mysql_fetch_array($res);
	
	$sql = "select * from estimate_miniSite_defualt_block where unk = '".UNK."' and type = '".$_GET['type']."'";
	$res = mysql_db_query(DB,$sql);
	$data_estimate = mysql_fetch_array($res);
	
	$sql = "select estimateSiteCat,estimateSiteTatCat from user_extra_settings where unk = '".UNK."'";
	$res = mysql_db_query(DB,$sql);
	$data_user = mysql_fetch_array($res);
	
	$selectCurrectCat = ( $data_estimate['primeryCat'] != "" && $data_estimate['primeryCat'] != "0" ) ? $data_estimate['primeryCat'] : $data_user['estimateSiteCat'];
	$selectCurrectTatCat = ( $data_estimate['subCat'] != "" && $data_estimate['subCat'] != "0" ) ? $data_estimate['subCat'] : $data_user['estimateSiteTatCat'];
	
	
	if( $_GET['type'] == "text" )
		$title = $temp_word_about;
	else
		$title = stripslashes($data['name']);
	
	$content_editor = ($data_estimate['content'] != "" ) ? $data_estimate['content'] : defualt_estimate_Minisite($title);
	
	$withOutVideo[0] = "כן";
	$withOutVideo[1] = "לא";
	
	if( $selectCurrectCat == "0" )
	{
		$add_that_not_cat = "<br><font style='color:red;'>שימו לב, אין קטגוריה ראשית</font>";
	}
	
	$sql = "SELECT cat_name, id FROM biz_categories where status=1 AND father='".$selectCurrectCat."' ORDER BY cat_name";
	$res_cats = mysql_db_query(DB, $sql);
	
	while( $data_cats = mysql_fetch_array($res_cats) )
	{
		$cat_id = $data_cats['id'];
		$subCat[$cat_id] = stripslashes($data_cats['cat_name']);
	}	
	
	$count_cats = count($subCat);
	
	if( $count_cats == "0" )
	{
		$add_that_not_cat_count_cats = "<br><font style='color:red;'>שימו לב, אין קטגוריות משניות</font>";
	}
	
	
	
	$sql = "SELECT cat_name, id FROM biz_categories where status=1 AND father='0' ORDER BY cat_name";
	$res_Pcats = mysql_db_query(DB, $sql);
	
	while( $data_Pcats = mysql_fetch_array($res_Pcats) )
	{
		$Pcat_id = $data_Pcats['id'];
		$primeryCat[$Pcat_id] = stripslashes($data_Pcats['cat_name']);
	}	
	
	
	
	$sql = "SELECT cat_name, id FROM biz_categories where status=1 AND father='".$selectCurrectTatCat."' ORDER BY cat_name";
	$res_pro_cats = mysql_db_query(DB, $sql);
	
	while( $data_pro_cats = mysql_fetch_array($res_pro_cats) )
	{
		$spec_cat_id = $data_pro_cats['id'];
		$specCat[$spec_cat_id] = stripslashes($data_pro_cats['cat_name']);
	}	
	
	$count_spec_cats = count($specCat);
	
	if( $count_spec_cats == "0" )
	{
		$add_that_not_spec_cat_count = "<br><font style='color:red;'>שימו לב, אין התמחויות</font>";
	}
	
	
	
	$google_adsense[0] = "נכון, יופיעו בו מודעות גוגל";
	$google_adsense[1] = "טופס פעיל";
	
	if( UNK == "285240640927706447" )
		$google_adsense_arr = array("select","google_adsense[]",$google_adsense,"טופס אינו פעיל כרגע?",$data_estimate['google_adsense'],"data_arr[google_adsense]", "class='input_style'" );
	else
		$google_adsense_arr = array();
	
	$formActive[0] = "כן";
	$formActive[1] = "לא";

	$addEmail[0] = "לא";
	$addEmail[1] = "כן";
	
	$bill_free_arr[0] = "רגיל";
	$bill_free_arr[1] = "ללא חיוב";	
	
	$take_cat_temp = ( $selectCurrectTatCat != "0" ) ? $selectCurrectTatCat : $selectCurrectCat;
	$take_cat = ( $take_cat_temp != "0" ) ? "bc.id=".$take_cat_temp." AND" : "";
	
	$sql = "select u.id, u.name FROM 
		users as u,
		user_cat as uc,
		biz_categories as bc ,
		user_extra_settings as us
			WHERE 
				us.unk=u.unk AND
				u.deleted=0 AND
				u.status=0 AND
			  u.end_date > NOW() AND
				us.belongTo10service=1 AND
				u.id=uc.user_id AND
				uc.cat_id=bc.id AND
				".$take_cat."
				bc.status=1
		 GROUP BY u.id";
	$res_choosenClient = mysql_db_query(DB, $sql);
	
	$choosenClientId = array();
	while( $val_choosenClient = mysql_fetch_array($res_choosenClient) )
	{
		$clientId = $val_choosenClient['id'];
		$choosenClientId[$clientId] = stripslashes($val_choosenClient['name']);
	}
	
	
	$sql = "SELECT id, name FROM newCities WHERE father=0 ORDER BY id";
	$resCity = mysql_db_query(DB,$sql);
	
	while( $dataCity = mysql_fetch_array($resCity) )
	{
		$tempId = $dataCity['id'];
		$cityId[$tempId] = stripslashes($dataCity['name']);
		
		$sql = "SELECT id, name FROM newCities WHERE father=".$dataCity['id']." ORDER BY name";
		$resCity2 = mysql_db_query(DB,$sql);
		
		while( $dataCity2 = mysql_fetch_array($resCity2) )
		{
			$tempId2 = $dataCity2['id'];
			$cityId[$tempId2] = stripslashes($dataCity2['name']);
		}
	}
	
	
	
	if( $data_user['estimateSiteCat'] == "0" )
		$arr_estimateSiteCat = array("select","primeryCat[]",$primeryCat,"בחר קטגוריה ראשית"."<br>שים לב, במידה ומשנים את הקטגוריה הראשית<br>יש צורך בעדכון ואז לבחור קטגוריה משנית",$selectCurrectCat,"data_arr[primeryCat]", "class='input_style'" );
	else
		$arr_estimateSiteCat = array("hidden", "data_arr[primeryCat]", $selectCurrectCat );
	
	if( $data_user['estimateSiteTatCat'] == "0" )
		$arr_estimateSiteTatCat = array("select","subCat[]",$subCat,"בחר קטגוריה משנית".$add_that_not_cat.$add_that_not_cat_count_cats,$selectCurrectTatCat,"data_arr[subCat]", "class='input_style'" );
	else
		$arr_estimateSiteTatCat = array("hidden", "data_arr[subCat]", $selectCurrectTatCat );


	$reset_cats[0] = "לא";
	$reset_cats[1] = "כן";	
	
	$table = "estimate_miniSite_defualt_block";
	$form_arr = array(
		array("hidden","main","edit_estimateMiniSiteBlock_DB"),
		array("hidden","type",$_GET['type']),
		array("hidden","record_id",$data_estimate['id']),
		array("hidden","sesid",SESID),
		array("hidden","data_arr[unk]",UNK),
		array("hidden","data_arr[type]",$_GET['type']),
		array("hidden","unk",UNK),
		array("hidden","table",$table),
		
		
		array("new_file","content_img",$data_estimate['content_img'],"תמונת צד טקסט", "new_images", "&table=".$table."&GOTO_type=".$_GET['type']."&GOTO_main=edit_estimateMiniSiteBlock"),
		array("new_file","top_form_img",$data_estimate['top_form_img'],"תמונה של בחורה מחייכת", "new_images", "&table=".$table."&GOTO_type=".$_GET['type']."&GOTO_main=edit_estimateMiniSiteBlock"),
		array("new_file","mobile_top_form_img",$data_estimate['mobile_top_form_img'],"תמונה של בחורה מחייכת - מובייל", "new_images", "&table=".$table."&GOTO_type=".$_GET['type']."&GOTO_main=edit_estimateMiniSiteBlock"),
		array("new_file","top_banner",$data_estimate['top_banner'],"באנר עליון", "new_images", "&table=".$table."&GOTO_type=".$_GET['type']."&GOTO_main=edit_estimateMiniSiteBlock"),
		array("new_file","text_banner",$data_estimate['text_banner'],"באנר עליון באזור הטקסט", "new_images", "&table=".$table."&GOTO_type=".$_GET['type']."&GOTO_main=edit_estimateMiniSiteBlock"),
		array("text","data_arr[top_banner_href]",stripslashes($data_estimate['top_banner_href']),"לינק לבאנר עליון באזור הטקסט", "class='input_style' style='text-align:left;'"),
		array("text","data_arr[mobile_button_text]",stripslashes($data_estimate['mobile_button_text']),"טקסט לכפתור פתיחת טופס במובייל", "class='input_style'"),
		array("text","data_arr[video_url]",stripslashes($data_estimate['video_url']),"כתובת הוידאו", "class='input_style'"),
		array("select","withOutVideo[]",$withOutVideo,"להציג וידיאו",$data_estimate['withOutVideo'],"data_arr[withOutVideo]", "class='input_style'" ),
		array("new_file","videoPic",$data_estimate['videoPic'],"תמונה במקום וידיאו", "new_images", "&table=".$table."&GOTO_type=".$_GET['type']."&GOTO_main=edit_estimateMiniSiteBlock"),
		
		array("text","data_arr[top_form_headline]",stripslashes($data_estimate['top_form_headline']),"כותרת מעל הטופס", "class='input_style'"),
		
		$arr_estimateSiteCat, $arr_estimateSiteTatCat,
		
		array("select","cat_spec[]",$specCat,"בחר התמחות".$add_that_not_spec_cat_count,$data_estimate['cat_spec'],"data_arr[cat_spec]", "class='input_style'" ),
		array("select","fix_form_reset_cats",$reset_cats,"איפוס קטגוריות לטופס",$reset_cats[0],"fix_form_reset_cats", "class='input_style'" ),		
		$google_adsense_arr,
		array("select","formActive[]",$formActive,"טופס פעיל?",$data_estimate['formActive'],"data_arr[formActive]", "class='input_style'" ),
		
		array("select","bill_free[]",$bill_free_arr,"סוג חיוב",$data_estimate['bill_free'],"data_arr[bill_free]", "class='input_style'" ),
		array("text","data_arr[input_remove]",stripslashes($data_estimate['input_remove']),"הסרת שדות(הפרד בפסיק)", "class='input_style'"),
		array("select","addEmail[]",$addEmail,"הוסף שדה אימייל <br/> שים לב: ניתן להוסיף גם בעריכת קטגוריה",$data_estimate['addEmail'],"data_arr[addEmail]", "class='input_style'" ),
		 
		array("text","data_arr[cat_remove]",stripslashes($data_estimate['cat_remove']),"הסרת קטגוריות(הפרד בפסיק לפי מספר קטגוריה)", "class='input_style'"),
		array("text","data_arr[cat_add]",stripslashes($data_estimate['cat_add']),"הוספת קטגוריות(הפרד בפסיק לפי מספר קטגוריה)", "class='input_style'"),
		
		
		array("select","choosenClientId[]",$choosenClientId,"בחר שיוך דף ללקוח",$data_estimate['choosenClientId'],"data_arr[choosenClientId]", "class='input_style'" ),
		
		array("select","cityId[]",$cityId,"בחר שיוך לעיר",$data_estimate['cityId'],"data_arr[cityId]", "class='input_style'" ),
		
		array("textarea","data_arr[thanksPixel]",stripslashes($data_estimate['thanksPixel']),"קוד המרה בדף תודה לאחר שליחת הטופס", "class='input_style' dir=ltr style='height: 70px;'"),
		array("text","data_arr[thanksRedirect]",stripslashes($data_estimate['thanksRedirect']),"כתובת הפניה שבו יעובר הגולש לאחר 5 שניות בדף תודה", "dir=ltr  class='input_style'"),
		
		array("text","data_arr[service10_title_bakesh]",stripslashes($data_estimate['service10_title_bakesh']),"כותרת לשירות 10, במקום מחפש...", "class='input_style'"),
		array("text","data_arr[service10_title_search]",stripslashes($data_estimate['service10_title_search']),"כותרת לשירות 10, במקום בקש הצעת מחיר ל...", "class='input_style'"),
		
		
		array("submit","submit",$word[LANG]['submit_form'], "class='submit_style'")
	);
	
	$more = "class='maintext' border='0'";
	
	if( $data['id'] == "" )
	{
		echo "<h3 class='maintext'>יש ליצור תחילה את הדף</h3>";
	}
	else
	{
		echo "<table border=\"0\" cellspacing=\"0\" cellpadding=\"0\" class=\"maintext\" width='100%'>";
			
			echo "<tr>";
				echo "<td><h3>עדכון טקסט - <a href='index.php?main=text&type=".$_REQUEST['type']."&text_id=".$_REQUEST['type']."&unk=".UNK."&sesid=".SESID."' class='maintext'><b style='font-size: 14px;'>".$title."</b></a></h3></td>";
			echo "</tr>";
			
			echo "<tr>";
				echo "<td align=right>";
				echo "<form name='edit_content_form' method=post action='index.php'>";
				echo "<input type='hidden' name='main' value='edit_estimateMiniSiteBlock_contentDB'>";
				echo "<input type='hidden' name='type' value='".$_GET['type']."'>";
				echo "<input type='hidden' name='sesid' value='".SESID."'>";
				echo "<input type='hidden' name='unk' value='".UNK."'>";
				echo "<input type='hidden' name='record_id' value='".$data_estimate['id']."'>";
					
					load_editor_text( "content" , stripcslashes($content_editor) );
					
					echo "<input type='submit' value='עדכן טקסט' class='submit_style'>";
				echo "</form>";
				echo "</td>";
			echo "</tr>";
			
			
			
			echo "<tr>";
				echo "<td><h3>עדכון פרמטרים - <u>".$title."</u></h3></td>";
			echo "</tr>";
			
			echo "<tr>";
				echo "<td align=right>";
					echo FormCreator::create_form($form_arr,"index.php", $more, $mandatory_fields, "editorhtml");
				echo "</td>";
			echo "</tr>";
		
			if(isset($_REQUEST['limit_cat_by_cities'])){
				$limit_cat_by_cities = $_REQUEST['limit_cat_by_cities'];
				$limit_cat_by_cities_check = implode(",",$_REQUEST['limit_cat_by_cities_check']);
				$limit_cat_by_cities_sql = "UPDATE estimate_miniSite_defualt_block SET limit_cat_by_cities = '$limit_cat_by_cities', limit_cat_by_cities_check = '$limit_cat_by_cities_check' WHERE id = '".$data_estimate['id']."' ";				
				$limit_cat_by_cities_res = mysql_db_query(DB,$limit_cat_by_cities_sql);
				$data_estimate_sql = "SELECT * FROM estimate_miniSite_defualt_block WHERE id = ".$data_estimate['id']."";
				$data_estimate_res = mysql_db_query(DB,$data_estimate_sql);
				$data_estimate = mysql_fetch_array($data_estimate_res);
			}
			echo "<tr>";
				echo "<td align=right>";
					echo "<hr/>";
					$limit_cat_by_cities_selected = array("0"=>"","1"=>"");
					$limit_cat_by_cities_selected[$data_estimate['limit_cat_by_cities']] = " selected ";
					$limit_cat_by_cities_display = array("0"=>"none","1"=>"block");
					echo "<form action='' method='POST'>";
						echo "<div style='float:left;'>";
							echo "<input type='submit' value='שמור הגבלת קטגוריות לפי הערים המסומנות' />";
						echo "</div>";
						echo "<h3>הגבל בחירת קטגוריות לפי שיוך לערים ";
							echo "<select id='limit_cat_by_cities_select' name='limit_cat_by_cities'>";
								echo "<option value='0' ".$limit_cat_by_cities_selected["0"]." >לא</option>";
								echo "<option value='1' ".$limit_cat_by_cities_selected["1"]." >כן</option>";
							echo "</select>";
						echo "</h3>";
						echo "<div id='limit_cat_by_cities_check' style='display:".$limit_cat_by_cities_display[$data_estimate['limit_cat_by_cities']].";'>";
							$cities = array();
							$newCitiessql = "SELECT * FROM newCities";
							$newCitiesres = mysql_db_query(DB,$newCitiessql);
							$limit_cat_by_cities_check = $data_estimate['limit_cat_by_cities_check'];
							$limit_cat_by_cities_checked = array();
							if($limit_cat_by_cities_check != ""){
								$limit_cat_by_cities_checked = explode(",",$limit_cat_by_cities_check);
							}
							while($newCityData = mysql_fetch_array($newCitiesres)){
								$newCityData['checked'] = "";
								if(in_array($newCityData['id'],$limit_cat_by_cities_checked)){
									$newCityData['checked'] = "checked";
								}
								if($newCityData['father'] == '0'){
									
									if(isset($cities[$newCityData['id']])){
										$newCityData['children'] = $cities[$newCityData['id']]['children'];
										
									}
									else{
										$cities[$newCityData['id']] = array('children'=>array());
									}
									$cities[$newCityData['id']] = $newCityData;
								}
								else{
									if(!isset($cities[$newCityData['father']])){
										$cities[$newCityData['father']] = array('children'=>array());
									}
									$cities[$newCityData['father']]['children'][$newCityData['id']] = $newCityData;
								}
							}
							function citysort_byname($a,$b){
								return $a['name'] > $b['name'];
							}
							function citysort_byplace($a,$b){
								return $a['place'] > $b['place'];
							}							
							usort($cities, "citysort_byname");
							usort($cities, "citysort_byplace");
							//usort($cities, "name");
							//usort($cities, "place");
							
							foreach($cities as $city){
								echo "<div>";
									echo "<input type='checkbox' name='limit_cat_by_cities_check[".$city['id']."]' value='".$city['id']."' ".$city['checked']."/><b>".$city['name']."</b>"; 
								echo "</div>";
								$city_children = $city['children'];
								if(!empty($city_children)){
									usort($city_children, "citysort_byname"); 
									//usort($city_children, "citysort_byplace");
									foreach($city_children as $child_city){
										echo "<div>";
											echo "<input type='checkbox'  name='limit_cat_by_cities_check[".$child_city['id']."]' value='".$child_city['id']."' ".$child_city['checked']."/><span>".$child_city['name']."</span>"; 
										echo "</div>";
									}
								}
							}
							
						echo "</div>";
					echo "</form>";
					echo "
						<script type='text/javascript'>
							jQuery(function($){
								$('#limit_cat_by_cities_select').change(function(){
									if($(this).val() == '1'){
										$('#limit_cat_by_cities_check').show();
									}
									else{
										$('#limit_cat_by_cities_check').hide();
									}
								});
							});
						</script>
					";
				echo "</td>";
			echo "</tr>";
		echo "</table>";
	}

}

function defualt_estimate_Minisite($myTranclateWord, $with_city=0)
{
	$withCity = ( $with_city == 1 ) ? " בcityName" : "";
	$str = "
שירות 10 הינו אתר השוואת מחירים למען הגולשים ובחינם.<br>
<br><br>";
$str .= "HERE_IS_IMG_NOT_FOR_DELETE";
$str .= "מחפשים חברת <b>".$myTranclateWord.$withCity."</b> מקצועית ואמינה ? מהיום אין צורך להשקיע זמן מיותר בחיפוש ארוך ומייגע ולערוך השוואת מחירים לבד !<br>
<br>
שירות 10 בחר עבורכם ארבע נותני שירות אמינים ומובילים בתחום <b>".$myTranclateWord.$withCity."</b>.<br>
<br>
משאירים את הפרטים כאן באתר וחברות <b>".$myTranclateWord.$withCity."</b> מובילות יחזרו אליכם עם הצעות מחיר אטרקטיביות<br>
<br>
לכם נשאר רק לבחור חברה מתאימה ל <b>".$myTranclateWord.$withCity."</b> וליהנות מקלות, שירות איכותי ומהיר במחיר הטוב ביותר 
";
	
	return $str;
}

function edit_estimateMiniSiteBlock_contentDB()
{
	if( $_POST['record_id'] == "" )
	{
		$sql = "INSERT INTO estimate_miniSite_defualt_block ( content, type, unk ) VALUES (
		 '".addslashes($_POST['content'])."' , '".$_POST['type']."' , '".UNK."' ) ";
	}
	else
	{
		$sql = "UPDATE estimate_miniSite_defualt_block SET content = '".addslashes($_POST['content'])."' WHERE unk = '".UNK."' AND type='".$_POST['type']."' ";
	}
	$res = mysql_db_query(DB,$sql);
	
	echo "<META HTTP-EQUIV=Refresh CONTENT=\"0; URL=index.php?main=edit_estimateMiniSiteBlock&type=".$_POST['type']."&unk=".UNK."&sesid=".SESID."\">";
			exit;
}


function edit_estimateMiniSiteBlock_DB()
{
	if( UNK == "285240640927706447" )
	{
		if( $_REQUEST['record_id'] == "" )
		{
			$image_settings = array(
				"server_path" => SERVER_PATH."/new_images/",
				"after_success_goto" => "GET_ID",
				"table_name" => $_REQUEST['table'],
			);
			
				$data_arr = ($_POST['data_arr'])? $_POST['data_arr'] : $_GET['data_arr'];
				$mysql_insert_id = insert_to_db($data_arr, $image_settings);
			
		}
		else	{
			$image_settings = array(
				"server_path" => SERVER_PATH."/new_images/",
				"after_success_goto" => "DO_NOTHING",
				"table_name" => $_REQUEST['table'],
			);
			
				$data_arr = ($_POST['data_arr'])? $_POST['data_arr'] : $_GET['data_arr'];
				update_db($data_arr, $image_settings);
				
				$mysql_insert_id = $_REQUEST['record_id'];
		}
	}
	else
	{
		if( $_REQUEST['record_id'] == "" )
		{
			$image_settings = array(
				"server_path" => SERVER_PATH."/new_images/",
				"thumbnail_width" => "100",
				"thumbnail_height" => "75",
				"large_width" => "160",
				"large_height" => "180",
				"after_success_goto" => "GET_ID",
				"field_name" => array("content_img"),
				"table_name" => $_REQUEST['table'],
			);
			
				$data_arr = ($_POST['data_arr'])? $_POST['data_arr'] : $_GET['data_arr'];
				$mysql_insert_id = insert_to_db($data_arr, $image_settings);
			
		}
		else	{
			$image_settings = array(
				"server_path" => SERVER_PATH."/new_images/",
				"thumbnail_width" => "100",
				"thumbnail_height" => "75",
				"large_width" => "160",
				"large_height" => "180",
				"after_success_goto" => "DO_NOTHING",
				"field_name" => array("content_img"),
				"table_name" => $_REQUEST['table'],
			);
			
				$data_arr = ($_POST['data_arr'])? $_POST['data_arr'] : $_GET['data_arr'];
				if($_POST['fix_form_reset_cats'] == '1'){
					$data_arr['primeryCat'] = "";
					$data_arr['subCat'] = "";
					$data_arr['cat_spec'] = "";
					
				}
				update_db($data_arr, $image_settings);
				
				$mysql_insert_id = $_REQUEST['record_id'];
		}
	}
	
	
		$temp_name = "top_banner";
		if( $_FILES[$temp_name]['name'] )
		{
			//get last id
			$image_settings['image_id'] = $mysql_insert_id."_".($temp+1);
		
			$field_name_mame = $_FILES[$temp_name]['name'];
			
			
			$sql = "select ".$temp_name." from ".$_REQUEST['table']." where ".$temp_name." != '' and unk = '".$_REQUEST['unk']."' and id = '".$mysql_insert_id."'";
			$res_unlink = mysql_db_query(DB,$sql);
			$data_unlink = mysql_fetch_array($res_unlink);
				
			$abpath_temp_unlink = SERVER_PATH."/new_images/".$data_unlink[$temp_name];
				
			if( file_exists($abpath_temp_unlink) && !is_dir($abpath_temp_unlink) )
				unlink($abpath_temp_unlink);
			
			$exte = substr($field_name_mame,(strpos($field_name_mame,".")+1));
			
			$logo_name2 = "TB".$_REQUEST['unk']."-".$mysql_insert_id.".".$exte;
			
			$tempname = $field_name_mame;
			
			GlobalFunctions::upload_file_to_server($temp_name , $logo_name2 , SERVER_PATH."/new_images/" );
			
			$sql = "UPDATE ".$_REQUEST['table']." SET ".$temp_name." = '".$logo_name2."' WHERE unk = '".$_REQUEST['unk']."' and id = '".$mysql_insert_id."' limit 1";
			
			$res = mysql_db_query(DB,$sql);
		}

		$temp_name = "text_banner";
		if( $_FILES[$temp_name]['name'] )
		{
			//get last id
			$image_settings['image_id'] = $mysql_insert_id."_".($temp+1);
		
			$field_name_mame = $_FILES[$temp_name]['name'];
			
			
			$sql = "select ".$temp_name." from ".$_REQUEST['table']." where ".$temp_name." != '' and unk = '".$_REQUEST['unk']."' and id = '".$mysql_insert_id."'";
			
			$res_unlink = mysql_db_query(DB,$sql);
			$data_unlink = mysql_fetch_array($res_unlink);
				
			$abpath_temp_unlink = SERVER_PATH."/new_images/".$data_unlink[$temp_name];
				
			if( file_exists($abpath_temp_unlink) && !is_dir($abpath_temp_unlink) )
				unlink($abpath_temp_unlink);
			
			$exte = substr($field_name_mame,(strpos($field_name_mame,".")+1));
			
			$logo_name2 = "TTB".$_REQUEST['unk']."-".$mysql_insert_id.".".$exte;
			
			$tempname = $field_name_mame;
			
			GlobalFunctions::upload_file_to_server($temp_name , $logo_name2 , SERVER_PATH."/new_images/" );
			
			$sql = "UPDATE ".$_REQUEST['table']." SET ".$temp_name." = '".$logo_name2."' WHERE unk = '".$_REQUEST['unk']."' and id = '".$mysql_insert_id."' limit 1";
			$res = mysql_db_query(DB,$sql);
		}
		
		if( UNK == "285240640927706447" )
		{
			$temp_name = "content_img";
			if( $_FILES[$temp_name]['name'] )
			{
				//get last id
				$image_settings['image_id'] = $mysql_insert_id."_".($temp+1);
			
				$field_name_mame = $_FILES[$temp_name]['name'];
				
				
				$sql = "select ".$temp_name." from ".$_REQUEST['table']." where ".$temp_name." != '' and unk = '".$_REQUEST['unk']."' and id = '".$mysql_insert_id."'";
				$res_unlink = mysql_db_query(DB,$sql);
				$data_unlink = mysql_fetch_array($res_unlink);
					
				$abpath_temp_unlink = SERVER_PATH."/new_images/".$data_unlink[$temp_name];
					
					if( file_exists($abpath_temp_unlink) && !is_dir($abpath_temp_unlink) )
						unlink($abpath_temp_unlink);
					
					$exte = substr($field_name_mame,(strpos($field_name_mame,".")+1));
					
					$logo_name2 = "CI".$_REQUEST['unk']."-".$mysql_insert_id.".".$exte;
					
					$tempname = $field_name_mame;
					
					GlobalFunctions::upload_file_to_server($temp_name , $logo_name2 , SERVER_PATH."/new_images/" );
					
					$sql = "UPDATE ".$_REQUEST['table']." SET ".$temp_name." = '".$logo_name2."' WHERE unk = '".$_REQUEST['unk']."' and id = '".$mysql_insert_id."' limit 1";
					$res = mysql_db_query(DB,$sql);
			}
		}
			
		$temp_name = "top_form_img";
		if( $_FILES[$temp_name]['name'] )
		{
			//get last id
			$image_settings['image_id'] = $mysql_insert_id."_".($temp+1);
		
			$field_name_mame = $_FILES[$temp_name]['name'];
			
			
			$sql = "select ".$temp_name." from ".$_REQUEST['table']." where ".$temp_name." != '' and unk = '".$_REQUEST['unk']."' and id = '".$mysql_insert_id."'";
			$res_unlink = mysql_db_query(DB,$sql);
			$data_unlink = mysql_fetch_array($res_unlink);
				
			$abpath_temp_unlink = SERVER_PATH."/new_images/".$data_unlink[$temp_name];
				
				if( file_exists($abpath_temp_unlink) && !is_dir($abpath_temp_unlink) )
					unlink($abpath_temp_unlink);
				
				$exte = substr($field_name_mame,(strpos($field_name_mame,".")+1));
				
				$logo_name2 = "TF".$_REQUEST['unk']."-".$mysql_insert_id.".".$exte;
				
				$tempname = $field_name_mame;
				
				GlobalFunctions::upload_file_to_server($temp_name , $logo_name2 , SERVER_PATH."/new_images/" );
				
				$sql = "UPDATE ".$_REQUEST['table']." SET ".$temp_name." = '".$logo_name2."' WHERE unk = '".$_REQUEST['unk']."' and id = '".$mysql_insert_id."' limit 1";
				$res = mysql_db_query(DB,$sql);
		}

		$temp_name = "mobile_top_form_img";
		if( $_FILES[$temp_name]['name'] )
		{
			//get last id
			$image_settings['image_id'] = $mysql_insert_id."_".($temp+1);
		
			$field_name_mame = $_FILES[$temp_name]['name'];
			
			
			$sql = "select ".$temp_name." from ".$_REQUEST['table']." where ".$temp_name." != '' and unk = '".$_REQUEST['unk']."' and id = '".$mysql_insert_id."'";
			$res_unlink = mysql_db_query(DB,$sql);
			$data_unlink = mysql_fetch_array($res_unlink);
				
			$abpath_temp_unlink = SERVER_PATH."/new_images/".$data_unlink[$temp_name];
				
				if( file_exists($abpath_temp_unlink) && !is_dir($abpath_temp_unlink) )
					unlink($abpath_temp_unlink);
				
				$exte = substr($field_name_mame,(strpos($field_name_mame,".")+1));
				
				$logo_name2 = "TFM".$_REQUEST['unk']."-".$mysql_insert_id.".".$exte;
				
				$tempname = $field_name_mame;
				
				GlobalFunctions::upload_file_to_server($temp_name , $logo_name2 , SERVER_PATH."/new_images/" );
				
				$sql = "UPDATE ".$_REQUEST['table']." SET ".$temp_name." = '".$logo_name2."' WHERE unk = '".$_REQUEST['unk']."' and id = '".$mysql_insert_id."' limit 1";
				$res = mysql_db_query(DB,$sql);
		}		
		
		$temp_name = "videoPic";
		if( $_FILES[$temp_name]['name'] )
		{
			//get last id
			$image_settings['image_id'] = $mysql_insert_id."_".($temp+1);
		
			$field_name_mame = $_FILES[$temp_name]['name'];
			
			
			$sql = "select ".$temp_name." from ".$_REQUEST['table']." where ".$temp_name." != '' and unk = '".$_REQUEST['unk']."' and id = '".$mysql_insert_id."'";
			$res_unlink = mysql_db_query(DB,$sql);
			$data_unlink = mysql_fetch_array($res_unlink);
				
			$abpath_temp_unlink = SERVER_PATH."/new_images/".$data_unlink[$temp_name];
				
				if( file_exists($abpath_temp_unlink) && !is_dir($abpath_temp_unlink) )
					unlink($abpath_temp_unlink);
				
				$exte = substr($field_name_mame,(strpos($field_name_mame,".")+1));
				
				$logo_name2 = "VP".$_REQUEST['unk']."-".$mysql_insert_id.".".$exte;
				
				$tempname = $field_name_mame;
				
				GlobalFunctions::upload_file_to_server($temp_name , $logo_name2 , SERVER_PATH."/new_images/" );
				
				if( $_REQUEST['unk'] != "285240640927706447" )
					resize($logo_name2,  SERVER_PATH."/new_images/", "221","177");
				
				$sql = "UPDATE ".$_REQUEST['table']." SET ".$temp_name." = '".$logo_name2."' WHERE unk = '".$_REQUEST['unk']."' and id = '".$mysql_insert_id."' limit 1";
				$res = mysql_db_query(DB,$sql);
			}
		echo "<META HTTP-EQUIV=Refresh CONTENT=\"0; URL=index.php?main=edit_estimateMiniSiteBlock&type=".$_REQUEST['type']."&unk=".UNK."&sesid=".SESID."\">";
			exit;
}


function duplicateCityiesPages()
{
	global $temp_word_about,$word;
	
	
	$sql = "select * from content_pages where unk = '".UNK."' and type = 'text' and deleted = '0'";
	$res = mysql_db_query(DB,$sql);
	$data = mysql_fetch_array($res);
	
	$sql = "select estimateSiteCat from user_extra_settings where unk = '".UNK."'";
	$res = mysql_db_query(DB,$sql);
	$data_user = mysql_fetch_array($res);
	
	$title = $temp_word_about;
	
	
	if( $data_user['estimateSiteCat'] == "0" )
	{
		$add_that_not_cat = "<br><font style='color:red;'>שימו לב, אין קטגוריה ראשית</font>";
	}
	
	$sql = "SELECT cat_name, id FROM biz_categories where status=1 AND father='".$data_user['estimateSiteCat']."' ORDER BY cat_name";
	$res_cats = mysql_db_query(DB, $sql);
	
	while( $data_cats = mysql_fetch_array($res_cats) )
	{
		$cat_id = $data_cats['id'];
		$subCat[$cat_id] = stripslashes($data_cats['cat_name']);
	}	
	
	$count_cats = count($subCat);
	
	if( $count_cats == "0" )
	{
		$add_that_not_cat_count_cats = "<br><font style='color:red;'>שימו לב, אין קטגוריות משניות</font>";
	}
	
	
	echo "<form name='edit_content_form' method=post action='index.php'>";
	echo "<input type='hidden' name='main' value='duplicateCityiesPagesDB'>";
	echo "<input type='hidden' name='type' value='".$_GET['type']."'>";
	echo "<input type='hidden' name='sesid' value='".SESID."'>";
	echo "<input type='hidden' name='unk' value='".UNK."'>";
	echo "<input type='hidden' name='record_id' value='".$data_estimate['id']."'>";
	
	echo "<table border=\"0\" cellspacing=\"0\" cellpadding=\"0\" class=\"maintext\" width='100%'>";
		
		echo "<tr>";
			echo "<td colspan=3><h3>שכפול ערים</h3></td>";
		echo "</tr>";
		
		echo "<tr>";
			echo "<td align=right colspan=3>";
			
				load_editor_text( "content" , defualt_estimate_Minisite($title, "1") );
				
			echo "</td>";
		echo "</tr>";
		echo "<tr><td colspan=3 height=10></td></tr>";
		echo "<tr>";
			echo "<td>צמד מילים לקידום</td>";
			echo "<td width=10></td>";
			echo "<td><input type='text' name='name' class='input_style' value='".$title."'></td>";
		echo "</tr>";
		echo "<tr><td colspan=3 height=10></td></tr>";
		echo "<tr>";
			echo "<td>בחר קטגוריה משנית</td>";
			echo "<td width=10></td>";
			echo "<td>";
				if( $add_that_not_cat_count_cats == "" && $add_that_not_cat == "" )
				{
					echo "<select name='subCat' class='input_style'>";
						echo "<option value=''>ללא קטגוריה משנית</option>";
						foreach( $subCat as $key => $val )
						{
							echo "<option value='".$key."'>".$val."</option>";
						}
					echo "</select>";
				}
				else
				{
					echo $add_that_not_cat_count_cats;
					echo $add_that_not_cat;
				}
			echo "</td>";
		echo "</tr>";
		echo "<tr><td colspan=3 height=10></td></tr>";
		echo "<tr>";
			echo "<td valign=top colspan=3>בחר אזורים וערים ליצירה</td>";
		echo "</tr>";
		echo "<tr>";
			echo "<td colspan=3>";
				$sql = "SELECT id,name FROM newCities WHERE father=0 AND id!=1 ORDER by name";
				$res = mysql_db_query(DB,$sql);
				
				while( $data = mysql_fetch_array($res) )
				{
					echo "<input type='checkbox' name='createCities[]' value='".$data['id']."' checked> <b>".stripslashes($data['name'])."</b>:";
					
					$sql = "SELECT id,name FROM newCities WHERE father='".$data['id']."' ORDER by name";
					$res2 = mysql_db_query(DB,$sql);
					
					
					while( $data2 = mysql_fetch_array($res2) )
					{
						echo "<input type='checkbox' name='createCities[]' value='".$data2['id']."' checked> ".stripslashes($data2['name'])."";
					}
					echo "<br>";
				}
				
			echo "</td>";
		echo "</tr>";
		echo "<tr><td colspan=3 height=10></td></tr>";
		
		echo "<tr>";
			echo "<td>meta Description</td>";
			echo "<td width=10></td>";
			echo "<td><textarea name='description' cols='' rows='' class='input_style' style='height: 75px;'>".$title." בcityName</textarea></td>";
		echo "</tr>";
		echo "<tr><td colspan=3 height=10></td></tr>";
		echo "<tr>";
			echo "<td>meta Keywords</td>";
			echo "<td width=10></td>";
			echo "<td><textarea name='keywords' cols='' rows='' class='input_style' style='height: 75px;'>".$title." בcityName</textarea></td>";
		echo "</tr>";
		echo "<tr><td colspan=3 height=10></td></tr>";
		echo "<tr>";
			echo "<td colspan=3><input type='submit' value='שכפל ערים' class='submit_style'></td>";
		echo "</tr>";
		
	echo "</table>";
	echo "</form>";
	
	
}

function duplicateCityiesPagesDB()
{
	if( is_array( $_POST['createCities'] ) )
	{
		foreach( $_POST['createCities'] as $key => $city_id )
		{
			$sql = "SELECT name, father FROM newCities WHERE id='".$city_id."'";
			$res2 = mysql_db_query(DB,$sql);
			$cityData = mysql_fetch_array($res2);
			$cityName = stripslashes($cityData['name']);
			
			$new_content = str_replace("cityName" , $cityName , $_POST['content'] );
			$new_description = str_replace("cityName" , $cityName , $_POST['description'] );
			$new_keywords = str_replace("cityName" , $cityName , $_POST['keywords'] );
			
			if( $cityData['father'] == 0 )
			{
				$sql = "INSERT INTO user_text_libs ( lib_name , active, unk ) VALUES ( 
					'".addslashes($_POST['name']." ב".$cityData['name'])."' , '1' , '".UNK."' 
				)";
				$res = mysql_db_query(DB,$sql);
				$mylib = mysql_insert_id();
			}
			else
			{
				$sql = "SELECT name, father FROM newCities WHERE id='".$cityData['father']."'";
				$res4 = mysql_db_query(DB,$sql);
				$cityData4 = mysql_fetch_array($res4);
				$cityName4 = stripslashes($cityData4['name']);
				
				$sql = "SELECT id FROM user_text_libs WHERE unk = '".UNK."' AND deleted=0 AND lib_name = '".$_POST['name']." ב".$cityName4."' ";
				$res3 = mysql_db_query(DB,$sql);
				$Data3 = mysql_fetch_array($res3);
				$mylib = $Data3['id'];
			}
			
			$sql_last_id = "select id from content_pages order by id desc limit 1";
			$res_last_id = mysql_db_query(DB,$sql_last_id);
			$data_last_id = mysql_fetch_array($res_last_id);
			$content_new_id = 1+$data_last_id[id];
			
			$sql = "INSERT INTO content_pages( lib , keywords, description , unk, type, name , hide_page ) VALUES ( 
				'".$mylib."' , '".addslashes($new_description)."' , '".addslashes($new_keywords)."' , 
				'".UNK."' , '".$content_new_id."' , '".addslashes($_POST['name']." ב".$cityName)."' , '1'
			)";
			$res = mysql_db_query(DB,$sql);
			$myid = mysql_insert_id();
			
			$sql = "INSERT INTO estimate_miniSite_defualt_block ( content , unk, type, subCat ) VALUES ( 
				'".addslashes($new_content)."' , 
				'".UNK."' , '".$myid."' , '".$_POST['subCat'].")'
			)";
			$res = mysql_db_query(DB,$sql);
		}
	}
	
	echo "<script>window.location.href='index.php?main=List_View_Rows&type=update_pages&unk=".UNK."&sesid=".SESID."';</script>";
	exit;
	
}


function change_premition_for_upload_pics()
{
	$arr_folders = array();
	
	if( fileperms(SERVER_PATH."/upload_pics") != "16895" )
		$arr_folders[] = "upload_pics";
	
	if( fileperms(SERVER_PATH."/upload_pics/Image") != "16895" )
		$arr_folders[] = "upload_pics/Image";
	
	if( fileperms(SERVER_PATH."/upload_pics/Flash") != "16895" )
		$arr_folders[] = "upload_pics/Flash";
		
	if( fileperms(SERVER_PATH."/upload_pics/File") != "16895" )
		$arr_folders[] = "upload_pics/File";
	
	if( sizeof($arr_folders) > 0 )
	{
		$ftp_user_name = 'ilan123';
		$ftp_user_pass = 'agate1';
		$ftp_server = 'il-biz.com';
		$conn_id = ftp_connect($ftp_server) or die("Couldn't connect to $ftp_server");
		$login_result = ftp_login($conn_id, $ftp_user_name, $ftp_user_pass);
		
		$sql = "SELECT domain FROM users WHERE unk = '".UNK."' ";
		$res = mysql_db_query(DB,$sql);
		$dataDomain = mysql_fetch_array($res);
		
		foreach( $arr_folders as $key => $val )
		{
			if( $val != "" )
			{
				if (ftp_site($conn_id, 'CHMOD 777 /domains/'.$dataDomain['domain'].'/public_html/' . $val) === false)
					chmod(SERVER_PATH."/".$val , 0777);
			}
		}
		
		ftp_close($conn_id);
	}
	
}

?>