<?php

function ecom_form_step_1()
{
	global $word;
	
	$sql = "select product_id from user_ecom_items where unk = '".UNK."' and status=0 AND client_unickSes = '".$_SESSION['ecom']['unickSES']."' GROUP BY product_id";
	$res = mysql_db_query(DB,$sql);
	$num_rows = mysql_num_rows($res);
	  
	$sql = "select textarea_content,delivery_pay from user_ecom_settings where unk = '".UNK."' order by id desc limit 1";
	$res_ecom_settigns = mysql_db_query(DB,$sql);
	$D_ecom_settigns = mysql_fetch_array($res_ecom_settigns);
	
	$total_price_to_pay = 0;
	?>
	<div class='ecom-pay-page'>
		
		<h4 class="page_headline">קופה</h4>
		
		

			<div style='overflow-x:auto;'>
				<table class="maintext">
					<tr>
						<td><b><?php echo $word[LANG]['1_1_ecom_form_step_1_pro_name']; ?></b></td>
						<td width=10></td>
						<td><b><?php echo $word[LANG]['1_1_ecom_form_step_1_catalog_id']; ?></b></td>
						<td width=10></td>
						<td><b><?php echo $word[LANG]['1_3_ecom_table_qry']; ?></b></td>
						<td width=10></td>
						<td><b><?php echo $word[LANG]['1_1_ecom_form_step_1_price_one']; ?></b></td>
					</tr>
					
					<?php while( $data = mysql_fetch_array($res) ): ?>
						<?php
							$sql = "select name,price,price_special,makat from user_products where id = '".$data['product_id']."'";
							$res2 = mysql_db_query(DB,$sql);
							$data2 = mysql_fetch_array($res2);
							
							$sql = "select id from user_ecom_items where unk = '".UNK."' and status=0 AND client_unickSes = '".$_SESSION['ecom']['unickSES']."' and product_id = '".$data['product_id']."'";
							$res3 = mysql_db_query(DB,$sql);
							$qry_nm = mysql_num_rows($res3);
							$total_price_to_pay = $total_price_to_pay + ( $data2['price'] * $qry_nm );
						?>
						<tr><td colspan=7 height=1></td></td>
						<tr><td colspan=7><hr width=100% size=1 class=\"maintext\" /></td></td>
						<tr><td colspan=7 height=1></td></td>
						<tr>
							<td><?php echo kill_and_strip($data2['name']); ?></td>
							<td width=10></td>
							<td><?php echo kill_and_strip($data2['makat']); ?></td>
							<td width=10></td>
							<td><?php echo $qry_nm; ?></td>
							<td width=10></td>
							<td align=left><?php echo kill_and_strip($data2['price']); ?> <?php echo COIN; ?></td>
						</tr>
					<?php endwhile; ?>
					<tr><td height='10' colspan=3></td></tr>
					<tr>
						<td colspan='7' align=left><b><?php echo $word['he']['1_3_ecom_table_total']; ?></b> <?php echo $total_price_to_pay; ?> <?php echo COIN; ?></td>
					</tr>
				</table>
			</div>
			
		
		
	<?php if( $num_rows > 0 ): ?>
	
			<div class='ecom-form'>
				<table border=\"0\" cellspacing=\"0\" cellpadding=\"0\" class=\"maintext\">
					<form action='?' name='step2_ecom_form' method='POST' onsubmit=\"return check_mandatory_fields();\">
					<input type='hidden' name='m' value='ecom_new_buy_DB'>
					
						<tr>
							<?php if( UNK != "567556530384297372" ): ?>
								<td colspan='3'><?php echo nl2br(kill_and_strip($D_ecom_settigns['textarea_content'])); ?></td>
							<?php else: ?>
							
								<td colspan='3'>
								<?php echo nl2br(kill_and_strip($D_ecom_settigns['textarea_content'])); ?><br>
								* משלוח מהיר ייחויב בנפרד<br><br>
								<b>סליקת כרטיסי האשראי נעשית על שרת מאובטח מאושר על ידי חברת ישראכרט, חשבונית אוטומטית תשלח לכתובת המייל שלכם<br>
								חברת בדים נט מתחייבת לא להעביר את שמכם כתובתכם או כל פרט אחר לשום גורם</b><br><br>
								לנוחיותכם ניתן לשלם טלפונית במספר 1-700-72-3254
								</td>
							<?php endif; ?>
						</tr>
						<tr><td height='10' colspan=3></td></tr>
						<tr>
							<td><font color=red>*</font> שם מלא</td>
							<td width=10></td>
							<td><input type='text' name='dataArr[full_name]' id='dataArr[full_name]' class='input_style'></td>
						</tr>
						<tr><td height='7' colspan=3></td></tr>

						<tr>
							<td><font color=red>*</font> אימייל</td>
							<td width=10></td>
							<td><input type='text' name='dataArr[email]' id='dataArr[email]' class='input_style'></td>
						</tr>
						<tr><td height='7' colspan=3></td></tr>
						<tr>
							<td><font color=red>*</font> טלפון</td>
							<td width=10></td>
							<td><input type='text' name='dataArr[phone]' id='dataArr[phone]' class='input_style'></td>
						</tr>
						<tr><td height='7' colspan=3></td></tr>
						<tr>
							<td><font color=red>*</font> ישוב</td>
							<td width=10></td>
							<td><input type='text' name='dataArr[city]' id='dataArr[city]' class='input_style'></td>
						</tr>
						<tr><td height='7' colspan=3></td></tr>
						<tr>
							<td><font color=red>*</font> רחוב</td>
							<td width=10></td>
							<td><input type='text' name='dataArr[address]' id='dataArr[address]' class='input_style'></td>
						</tr>
						<tr><td height='7' colspan=3></td></tr>
						<tr>
							<td><font color=red>*</font> מספר בית</td>
							<td width=10></td>
							<td>
								<table border=\"0\" cellspacing=\"0\" cellpadding=\"0\" class=\"maintext\">
									<tr>
										<td><input type='text' name='dataArr[buildingNum]' id='dataArr[buildingNum]' class='input_style' style='width: 118px;'></td>
										<td width=5></td>
										<td>מספר דירה</td>
										<td width=5></td>
										<td><input type='text' name='dataArr[home_num]' id='dataArr[home_num]' class='input_style' style='width: 118px;'></td>
									</tr>
								</table>
							</td>
						</tr>
						<tr><td height='7' colspan=3></td></tr>
						<tr>
							<td>מיקוד</td>
							<td width=10></td>
							<td><input type='text' name='dataArr[zip_code]' id='dataArr[zip_code]' class='input_style'></td>
						</tr>
						<tr><td height='7' colspan=3></td></tr>
						<tr>
							<td>הערות</td>
							<td width=10></td>
							<td><textarea name='dataArr[note]' id='dataArr[note]' cols='' rows='' class='input_style' style='height: 70px;'></textarea></td>
						</tr>
						<tr><td height='7' colspan=3></td></tr>
						<?php if( UNK != "995628678735762902" ): ?>
						
						<tr>
							<td><?php echo $word[LANG]['1_1_ecom_form_step_2_delivery']; ?></td>
							<td width=10></td>
							<td>
							<?php $delivery_pay = ( $D_ecom_settigns['delivery_pay'] != "" ) ? $D_ecom_settigns['delivery_pay'] : "0"; ?>
							
							<?php if( UNK == "514738259673354081" OR UNK == "567556530384297372" ): ?>
							
								<select name='dataArr[delivery_pay]' id='dataArr[delivery_pay]' class='input_style' style='width:250px; height: 18px;'>
									<option value='<?php echo kill_and_strip($D_ecom_settigns['delivery_pay']); ?>' selected><?php echo $word[LANG]['1_1_ecom_form_step_2_delivery_pay_1']; ?>: <?php echo kill_and_strip($delivery_pay); ?> <?php echo COIN; ?></option>
								</select>
							<?php else: ?>
								<select name='dataArr[delivery_pay]' id='dataArr[delivery_pay]' class='input_style' style='width:250px; height: 18px;'>
									<option value=''><?php echo $word[LANG]['1_1_ecom_form_step_2_delivery_choose']; ?></option>
									<option value='0' selected><?php echo $word[LANG]['1_1_ecom_form_step_2_delivery_pay_0']; ?></option>
									<option value='<?php echo kill_and_strip($D_ecom_settigns['delivery_pay']); ?>'><?php echo $word[LANG]['1_1_ecom_form_step_2_delivery_pay_1']; ?>: <?php echo kill_and_strip($delivery_pay); ?> <?php echo COIN; ?></option>
								</select>
							<?php endif; ?>
							
							</td>
						</tr>
						<tr><td height='5' colspan=3></td></tr>
						<tr><td colspan=3><hr width=100% size=1 class=\"maintext\" /></td></td>
						
						<?php else: ?>
						
							<input type='hidden' name='dataArr[delivery_pay]' id='dataArr[delivery_pay]' value='0'>
						<?php endif; ?>
						
						<tr><td height='5' colspan=3></td></tr>
						
						//$must_content = ( UNK == "995628678735762902" ) ? "onClick='if( document.step2_ecom_form.content.value == \"\" ) { alert(\"טקסט חופשי הינו שדה חובה\"); return false; }'" : "";
						
						<tr>
							<td valign=top style='font-size: 11px;'><font color=red>*</font> שדה חובה</td>
							<td width=10></td>
							<td align=left></td>
						</tr>
						
						<tr>
							<td valign=top></td>
							<td width=10></td>
							<td align=left><input type='submit' value='שליחה' class='submit_style'></td>
						</tr>
						
					</form>
				</table>
			</div>
	
		<?php else: ?>
			<div class='no-products-messege'><b>לא ניתן לשלוח הזמנה ללא מוצרים.</b>
		<?php endif; ?>
	
	

	</div>
<?php
}