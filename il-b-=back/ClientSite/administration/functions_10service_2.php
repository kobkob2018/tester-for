<?

function stat_summery_10service()
{
	$sql = "SELECT id FROM users WHERE unk = '".UNK."' ";
	$res = mysql_db_query(DB,$sql);
	$dataUser = mysql_fetch_array( $res );
	
	$UserStatView = new UserStatView(DB);
	
	echo "<table cellpadding=0 cellspacing=0 border=0 class=maintext>";
		echo "<tr>";
			echo "<td colspan=3 style='font-size: 14px;'><b>���������� �����</b></td>";
		echo "</tr>";
		echo "<tr><td colspan=3 height=15></td></tr>";
		echo "<tr>";
			echo "<td>���� ������ ����� ���� ��� </td>";
			echo "<td width=10></td>";
			echo "<td><b>".$UserStatView->countViewPage( $dataUser['id'] , "1"  )."</b></td>";
		echo "</tr>";
		echo "<tr><td colspan=3 height=15></td></tr>";
		
		echo "<tr>";
			echo "<td>���� ����� ��� ������ ���</td>";
			echo "<td width=10></td>";
			echo "<td><b>".$UserStatView->countViewPage( $dataUser['id'] , "2"  )."</b></td>";
		echo "</tr>";
		echo "<tr><td colspan=3 height=15></td></tr>";
		
		echo "<tr>";
			echo "<td>���� ����� ������ ������ �������</td>";
			echo "<td width=10></td>";
			echo "<td><b>".$UserStatView->countViewPage( $dataUser['id'] , "3"  )."</b></td>";
		echo "</tr>";
		echo "<tr><td colspan=3 height=15></td></tr>";
		
		echo "<tr>";
			echo "<td>���� ������ �� ������ ��� �������� ������ ���</td>";
			echo "<td width=10></td>";
			echo "<td><b>".$UserStatView->countViewPage( $dataUser['id'] , "4"  )."</b></td>";
		echo "</tr>";
		echo "<tr><td colspan=3 height=15></td></tr>";
		/*
		echo "<tr>";
			echo "<td>���� ����� ����� ��� ���� �����</td>";
			echo "<td width=10></td>";
			echo "<td><b>".$UserStatView->countViewPage( $dataUser['id'] , "6"  )."</b></td>";
		echo "</tr>";
		*/
		echo "<tr><td colspan=3 height=40></td></tr>";
		
		$sql = "SELECT COUNT(id) AS nums FROM user_contact_forms WHERE 
			unk = '".UNK."' AND
			name LIKE '10SERVICE%'";
		$res_3 = mysql_db_query(DB,$sql);
		$data_3 = mysql_fetch_array($res_3);
		
		echo "<tr>";
			echo "<td colspan=3 style='font-size: 14px;'><b>���������� ����� �������</b></td>";
		echo "</tr>";
		echo "<tr><td colspan=3 height=15></td></tr>";
		echo "<tr>";
			echo "<td>���� ������ ������� ���� ���</td>";
			echo "<td width=10></td>";
			echo "<td><b>".$data_3['nums']."</b></td>";
		echo "</tr>";
		echo "<tr><td colspan=3 height=15></td></tr>";
		
		$sql = "select COUNT(up.id) AS nums from 
					user_products as up where 
						up.unk = '285240640927706447' AND
						up.belongToUser10service = '".$dataUser['id']."'";
		$res_41 = mysql_db_query(DB,$sql);
		$data_41 = mysql_fetch_array($res_41);
		
		$sql = "SELECT COUNT(id) AS nums FROM ilbizPayByCCLog WHERE payToType = '4' AND payGood = '2' AND userId = '".$dataUser['id']."' ";
		$res_4 = mysql_db_query(DB,$sql);
		$data_4 = mysql_fetch_array($res_4);
		
		echo "<tr>";
			echo "<td>���� ������ �� ����� ���� ".$data_41['nums']." ������</td>";
			echo "<td width=10></td>";
			echo "<td><b>".$data_4['nums']."</b></td>";
		echo "</tr>";
		echo "<tr><td colspan=3 height=15></td></tr>";
		
		$sql = "select COUNT(up.id) AS nums from 
					10service_deal_coupon as up where 
						up.user_id = '".$dataUser['id']."'";
		$res_61 = mysql_db_query(DB,$sql);
		$data_61 = mysql_fetch_array($res_61);
		
		$sql = "SELECT COUNT(id) AS nums FROM ilbizPayByCCLog WHERE payToType = '51' AND payGood = '2' AND userId = '".$dataUser['id']."'";
		$res_6 = mysql_db_query(DB,$sql);
		$data_6 = mysql_fetch_array($res_6);
		/*
		echo "<tr>";
			echo "<td>���� ������ �� ��� ����� ���� ".$data_61['nums']." ������</td>";
			echo "<td width=10></td>";
			echo "<td><b>".$data_6['nums']."</b></td>";
		echo "</tr>";
		*/
		echo "<tr><td colspan=3 height=15></td></tr>";
		
	echo "</table>";
}


function right_menu_summert_10service_credit()
{
	$creditMoney = new creditMoney;
	
	echo "<table cellpadding=0 cellspacing=0 border=0 class=maintext>";
		echo "<tr>";
			echo "<td bgcolor='#ffffff' style='padding: 7px;'>";
				echo "<table cellpadding=0 cellspacing=0 border=0 class=maintext>";
					echo "<tr>";
						echo "<td>���� �������� ����� ��: ".$creditMoney->get_creditMoney( "users" , UNK , "1" )."</td>";
					echo "</tr>";
					echo "<tr><td height=10></td></tr>";
					echo "<tr>";
						echo "<td><a href='index.php?main=buy_credits&type=credits_10service&unk=".UNK."&sesid=".SESID."' class='maintext'>���� �������</a></td>";
					echo "</tr>";
					echo "<tr><td height=10></td></tr>";
					echo "<tr>";
						echo "<td><a href='index.php?main=about_credits&type=credits_10service&unk=".UNK."&sesid=".SESID."' class='maintext'>�� ���� �������?</a></td>";
					echo "</tr>";
					echo "<tr><td height=10></td></tr>";
					echo "<tr>";
						echo "<td><a href='index.php?main=full_summery_credits&type=credits_10service&unk=".UNK."&sesid=".SESID."' class='maintext'>��� �������</a></td>";
					echo "</tr>";
					echo "<tr><td height=10></td></tr>";
					echo "<tr>";
						echo "<td><a href='index.php?main=advertisers_earn_credit&type=credits_10service&unk=".UNK."&sesid=".SESID."' class='maintext'>������� ��������� �������</a></td>";
					echo "</tr>";
				echo "</table>";
			echo "</td>";
		echo "</tr>";
	echo "</table>";
}


function right_menu_summery_leads()
{
	$sqlQry = "SELECT leadQry , openContactDataPrice FROM user_lead_settings WHERE unk = '".UNK."'";
	$resQry = mysql_db_query(DB,$sqlQry);
	$dataQry = mysql_fetch_array($resQry);
		
	echo "<table cellpadding=0 cellspacing=0 border=0 class=maintext>";
		echo "<tr>";
			echo "<td bgcolor='#ffffff' style='padding: 7px;'>";
				echo "<table cellpadding=0 cellspacing=0 border=0 class=maintext>";
					echo "<tr>";
						echo "<td>���� ������ ����� ��: ".$dataQry['leadQry']."</td>";
					echo "</tr>";
					if( $dataQry['openContactDataPrice'] > "0" )
					{ 
						echo "<tr><td height=10></td></tr>";
						echo "<tr>";
							echo "<td><a href='index.php?main=buy_leads&type=buy_leads&unk=".UNK."&sesid=".SESID."' class='maintext'>���� �����</a></td>";
						echo "</tr>";
					}
				echo "</table>";
			echo "</td>";
		echo "</tr>";
	echo "</table>";
}

function buy_leads()
{
	$sql = "SELECT openContactDataPrice FROM user_lead_settings WHERE unk = '".UNK."' ";
	$res = mysql_db_query(DB,$sql);
	$dataUser = mysql_fetch_array($res);
	
	if( $dataUser['openContactDataPrice'] > "0" )
	{
	echo "<form action='index.php' id='sendto_buy_leads_form' method='post' name='goto_buy_leads' style='padding: 0px; margin: 0px;'>";
	echo "<input type='hidden' name='main' value='buy_leads_goto_yaad'>";
	echo "<input type='hidden' name='type' value='buy_leads'>";
	echo "<input type='hidden' name='unk' value='".UNK."'>";
	echo "<input type='hidden' name='sesid' value='".SESID."'>";
	echo "<table cellpadding=0 cellspacing=0 border=0 class=maintext>";
		echo "<tr>";
			echo "<td>
			���� �� ��� ����: ".$dataUser['openContactDataPrice']." �\"� ���� ��\"�.<br><br>
			��� ���� �� ���� ������ �������� �����: 
			<input type='text' id='num_credit_input' name='num_credit' class='input_style  required digits' style='width: 70px;'  data-msg='��� ��� ���� �����'><br><br>
			</td>";
		echo "</tr>";
	echo "</table>";
		$user_tokens_sql = "SELECT L4digit,full_name,biz_name FROM userCCToken WHERE unk = '".UNK."'";
		$user_tokens_res = mysql_db_query(DB,$user_tokens_sql);
		$user_tokens = false;
		$user_biz_name = "";
		$user_full_name = "";		
		while($user_token_data = mysql_fetch_array($user_tokens_res)){
			if(!$user_tokens){
				$user_tokens = array();
			}
			$user_tokens[] = $user_token_data['L4digit'];
			if($user_token_data['biz_name'] != ""){
				$user_biz_name = $user_token_data['biz_name'];
				$user_full_name = $user_token_data['full_name'];			
			}			
		}
	?>

					<?php if(!$user_tokens): ?>
						<input type='hidden' name='use_token' value='0' />
					<?php else: ?>
						<div class='buy_leads_token_select form-group '>
							<label for='use_token'>��� ����� �����</label><br/>
							<select name='use_token' id='use_token_select' class="form-select use-token input_style">
								<option value='0'>����� ������ ���</option>
								<?php foreach($user_tokens as $key=>$val): ?>
									<option value='<?php echo $val; ?>'><?php echo $val; ?>**** **** **** </option>		
								<?php endforeach; ?>
							</select>
						</div>						
					<?php endif; ?>
					<br/><br/>
						<div class='buy_leads_full_name form-group '>
							<label for='full_name'>�� ���</label><br/>
							<input type='text' id='full_name_input' name='full_name' value='<?php echo $user_full_name; ?>' class='input_style text-input required' data-msg="�� ������ �� ���"><br>
						</div>	
						<br/><br/>
						<div class='buy_leads_biz_name form-group '>
							<label for='biz_name'>�� ���� ������ ��������</label><br/>
							<input type='text' id='biz_name_input' name='biz_name' value='<?php echo $user_biz_name; ?>' class='input_style text-input required' data-msg="�� ������ �� �� ����"><br>
						</div>						
		<br><br>
							<div class="buy-leads-amount" id = "buy_leads_amount_wrap" style="display:none;">
					�� ��� ������: <span id="buy_leads_amount_holder"></span> �"� ���� ��"�.<br>
					</div>
					<br><br>
			<input type='submit' id='buy_leads_submit' class='submit_style' value='���� ����� ����� ������' style='width: 200px;'>			
	</form>
	<script src="mobile/style/bootstrap_2.3.2/jquery.min.js"></script>
	<script src="/ClientSite/administration/mobile/style/bootstrap_2.3.2/jquery.validate.js"></script>
			<script type="text/javascript">
				$("#sendto_buy_leads_form").validate({
				 submitHandler: function(form) {
				   $("#buy_leads_submit").attr("disabled", true).val("��� ����...");
				   form.submit();
				 }
				});
				$("#num_credit_input").keyup(function(){
					var l_num = $(this).val();
					if(!isNaN(parseInt(l_num)) && isFinite(l_num)){
						$("#buy_leads_amount_holder").html(parseInt(l_num)*<?php echo $dataUser['openContactDataPrice']; ?>);
						$("#buy_leads_amount_wrap").show();
					}
					else{
						$("#buy_leads_amount_holder").html("");
						$("#buy_leads_amount_wrap").hide();						
					}
						
				});
				$("#use_token_select").change(function(){
					if($(this).val()!= '0'){
						$("#buy_leads_submit").val("��� �����");
					}
					else{
						$("#buy_leads_submit").val("���� ����� ����� ������");
					}
				});

			</script>
		</div>	
	<?php
	}
}

function buy_credits()
{
	echo "<form action='index.php' method='post' name='goto_buy_credits_form' style='padding: 0px; margin: 0px;'>";
	echo "<input type='hidden' name='main' value='buy_credit_goto_yaad'>";
	echo "<input type='hidden' name='type' value='credits_10service'>";
	echo "<input type='hidden' name='unk' value='".UNK."'>";
	echo "<input type='hidden' name='sesid' value='".SESID."'>";
	echo "<table cellpadding=0 cellspacing=0 border=0 class=maintext>";
		echo "<tr>";
			echo "<td>
<b><u>��� �������?</u></b><br><br>
���� �������� ��������� ��� ����� ����� �� �������� ������ ����� ������� ����.<br>
����� �������� ( ����� �� ����� �����! ) ����� ���� ���� ������ �������� ����� ��� �� ���  ������ ����� �� ����� ������ ����� ���� ����.<br>
<br>
��� ����� ����� ������ �������� ������� ������ ������� ���������.<br>
<br>
��, ��� ������� �� ����� ����, ���������� - ���, ����� ����� ������ ��� ������� ��� ����� ���� ���.<br>
<br>
��� ������ ��� �������� ������� ������� ��� �� ������� ���� ����� ������.<br>
<br>
<u>������� �������� ����� ���� �� ������� ����� :</u><br>
<ul>
	<li>����� ���� ����� ���</li>
	<li>����� ���� ������ </li>
	<li>����� ����� - ����� �� ������ ����������</li>
	<li>����� ���� ����� ������ �����</li>
</ul>
<u>���� ����� �������� ��� ����� ����� ������� ���� - ��� ���!</u><br>
<ul>
	<li>����� ���� ���� ������ 10</li>
	<li>����� ����� ���� ����� 10 ��������, ���� �������� ������ �� ���  ������.</li>
	<li>����� �� ������ ������ ���� ���� ������  10</li>
	<li>������ ������ ����� ����� �� ��� ������ 10 ������ �� ���� \"������\" ������</li>
</ul>
<br>
���� �� ���� <b>����� ������</b> ������� ����� \"���\" ������� ����
			<br>
			<br>
			��� ���� �� ���� �������� �������� �����: 
			<input type='text' name='num_credit' class='input_style' style='width: 70px;'><br><br>
���� ������: 1 ����� = 1 ���<br>
<br>
���� �� ��� ����� ����� ����� 99 � �����, ����� ���� ���� 99 �������.<br>
<br>
����� ������ �����:<br>
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
700-1,999 ������� �����.........................4% ����<br>
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
2,000-3,999 ������� �����......................9% ����<br>
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
��� 4,000 ������� �����......................... 15% ����<br>
<br>
<b>���� �� � ������� ������ ��\"� </b>
			<br><br>
			<input type='submit' class='submit_style' value='���� ����� �����'>
			</td>";
		echo "</tr>";
	echo "</table>";
}

function buy_leads_goto_yaad()
{
	$buy_c = (int)$_POST['num_credit'];
	
	if( $buy_c > 0 )
	{
		$sql = "SELECT id FROM users WHERE unk = '".UNK."' ";
		$res = mysql_db_query(DB,$sql);
		$dataUser = mysql_fetch_array($res);
		
		$sql = "SELECT openContactDataPrice FROM user_lead_settings WHERE unk = '".UNK."' ";
		$res2 = mysql_db_query(DB,$sql);
		$dataUser2 = mysql_fetch_array($res2);
		
		$new_p = $buy_c * $dataUser2['openContactDataPrice'];
		
		$heshbonit_keys = "";
		$heshbonit_vals = "";
		if(isset($_REQUEST['full_name']) && isset($_REQUEST['biz_name'])){
			$heshbonit_keys = ",full_name,biz_name";
			$heshbonit_vals = ",'".$_REQUEST['full_name']."','".$_REQUEST['biz_name']."'";
		}		
		$pro_decs = "����� ".$buy_c." �����";
		$sql = "INSERT INTO ilbizPayByCCLog ( sumTotal , payDate , description , payToType , userId , gotoUrlParamter".$heshbonit_keys." ) VALUES (
			'".$new_p."' , NOW() , '".$pro_decs."' , '9' , '".$dataUser['id']."' , 'unk=".UNK."&sesid=".SESID."'".$heshbonit_vals."
		)";
		$res = mysql_db_query(DB,$sql);
		$userIdU = mysql_insert_id();
		if($_REQUEST['use_token']!='0'){
			$user_tokens_sql = "SELECT * FROM userCCToken WHERE unk = '".UNK."' AND L4digit = '".$_REQUEST['use_token']."'";
			$user_tokens_res = mysql_db_query(DB,$user_tokens_sql);
			$user_token_data = mysql_fetch_array($user_tokens_res);
			$userName_arr = explode(" ",$user_token_data['Fild1']);
			$params = array(
				'Masof'=>'4500019225',
				'action'=>'soft',
				'PassP'=>'Y123pilbiz',
				'Token'=>'True',
				'Order'=>$userIdU,
				'Amount'=>$new_p,
				'Info'=>$pro_decs,
				'UserId'=>$user_token_data['customer_ID_number'],
				'CC'=>$user_token_data['token'],
				'Tmonth'=>$user_token_data['Tmonth'],
				'Tyear'=>$user_token_data['Tyear'],
				'ClientName'=>$_REQUEST['full_name'],
				'ClientLName'=>$_REQUEST['biz_name'],
				'SendHesh'=>'True',
				// 'allowFalse'=>'True',
				
			);
			$postData = '';
			//create name value pairs seperated by &
			foreach($params as $k => $v) 
			{ 
				$postData .= $k . '='.$v.'&'; 
			}
			$postData = rtrim($postData, '&');
		 
			$ch = curl_init();  
		 
			curl_setopt($ch,CURLOPT_URL,"https://icom.yaad.net/cgi-bin/yaadpay/yaadpay.pl");
			curl_setopt($ch,CURLOPT_RETURNTRANSFER,true);
			curl_setopt($ch,CURLOPT_HEADER, false); 
			curl_setopt($ch, CURLOPT_POSTFIELDS, $postData);    
		 
			$output=curl_exec($ch);
		 
			curl_close($ch);
			
			$result_arr = explode("&",$output);
			$result = array();
			foreach($result_arr as $result_val){
				$val_arr = explode("=",$result_val);
				if(isset($val_arr[0]) && isset($val_arr[1])){
					$result[$val_arr[0]] = $val_arr[1];
				}
			}
			if($result['CCode'] == '0'){
				
				$ilbizurl = "http://www.ilbiz.co.il/global_func/yaadPay/ok.php?Id=".$result['Id']."&CCode=".$result['CCode']."&Amount=".$result['Amount']."&ACode=".$result['ACode']."&Order=".$userIdU."&Payments=1&UserId=".$user_token_data['customer_ID_number']."&Hesh=".$result['Hesh']."";
				header( 'location:' . $ilbizurl );
			}
			else{
				$ilbizurl = "http://www.ilbiz.co.il/global_func/yaadPay/error.php?Id=".$result['Id']."&CCode=".$result['CCode']."&Amount=".$result['Amount']."&ACode=".$result['ACode']."&Order=".$userIdU."&Payments=1&UserId=".$user_token_data['customer_ID_number']."&Hesh=".$result['Hesh']."";
				header( 'location:' . $ilbizurl );

			}
			exit();
		}		
		echo '
		<form name="YaadPay" accept-charset="windows-1255"  action="https://icom.yaad.net/cgi-bin/yaadpay/yaadpay.pl" method="post" >
		<INPUT TYPE="hidden" NAME="Masof" value="4500019225" >
		<INPUT TYPE="hidden" NAME="action" value="pay" >
		<INPUT TYPE="hidden" NAME="Amount" value="'.$new_p.'" >
		<INPUT TYPE="hidden" NAME="Order" value="'.$userIdU.'" >
		<INPUT TYPE="hidden" NAME="Info" value ="'.$pro_decs.'" >
		<INPUT TYPE="hidden" NAME="ClientName" value ="'.$_REQUEST['full_name'].'" >
		<INPUT TYPE="hidden" NAME="ClientLName" value ="'.$_REQUEST['biz_name'].'" >		
		<input type="hidden" name="SendHesh" value="true">
		<INPUT TYPE="hidden" NAME="MoreData" value="True" >
		<INPUT TYPE="hidden" NAME="Tash" value="1" >
		<input type="hidden" name="heshDesc" value="'.$pro_decs.'">
		
		</form>
		<p align=right dir=rtl class=maintext>���� ���� ������...</p>
		
		<script>document.YaadPay.submit();</script>';
	}
	
}


function buy_credit_goto_yaad()
{
	$buy_c = (int)$_POST['num_credit'];
	
	if( $buy_c > 0 )
	{
		$sql = "SELECT id FROM users WHERE unk = '".UNK."' ";
		$res = mysql_db_query(DB,$sql);
		$dataUser = mysql_fetch_array($res);
		
		if( $buy_c >= 4000 )
			$pr = 15;
		elseif( $buy_c >= 2000 )
			$pr = 9;
		elseif( $buy_c >= 700 )
			$pr = 4;
		else
			$pr = 0;
		
		$minuss = ( $buy_c * $pr ) / 100;
		$new_p = $buy_c - $minuss;
		
		
		$pro_decs = "����� ".$buy_c." �������";
		$sql = "INSERT INTO ilbizPayByCCLog ( sumTotal , payDate , description , payToType , userId , gotoUrlParamter ) VALUES (
			'".$new_p."' , NOW() , '".$pro_decs."' , '5' , '".$dataUser['id']."' , 'unk=".UNK."&sesid=".SESID."'
		)";
		$res = mysql_db_query(DB,$sql);
		$userIdU = mysql_insert_id();
		
		echo '
		<form name="YaadPay" action="https://icom.yaad.net/cgi-bin/yaadpay/yaadpay.pl" method="post" >
		<INPUT TYPE="hidden" NAME="Masof" value="4500019225" >
		<INPUT TYPE="hidden" NAME="action" value="pay" >
		<INPUT TYPE="hidden" NAME="Amount" value="'.$new_p.'" >
		<INPUT TYPE="hidden" NAME="Order" value="'.$userIdU.'" >
		<INPUT TYPE="hidden" NAME="Info" value ="'.$pro_decs.'" >
		<input type="hidden" name="SendHesh" value="true">
		<INPUT TYPE="hidden" NAME="MoreData" value="True" >
		<INPUT TYPE="hidden" NAME="Tash" value="12" >
		<input type="hidden" name="heshDesc" value="'.$pro_decs.'">
		
		</form>
		<p align=right dir=rtl class=maintext>���� ���� ������...</p>
		
		<script>document.YaadPay.submit();</script>';
	}
	
}


function about_credits()
{
	echo "<table cellpadding=0 cellspacing=0 border=0 class=maintext>";
		echo "<tr>";
			echo "<td>";
echo "<b><u>�� ���� �������</u></b><br>
<br>
����� ���� ���� �� ������ ���� �� ���� ���� ����� 10, ����� ���� ���� ���� �� ������ ����� �����, ����� ����� ����.<br>
<br>
<u>����� ���� ���� ����� �� ����� ����� ������� ������ ������ ������ : </u>
<ul>
	<li>����� ���� ����� ���</li>
	<li>����� ���� ������ </li>
	<li>����� ����� - ����� �� ������ ����������</li>
	<li>����� ���� ����� ������ �����</li>
</ul>
<u>���� ����� �������� ��� ����� ����� ������� ���� - ��� ���!</u>
<ul>
	<li>����� ���� ���� ������ 10</li>
	<li>����� ����� ���� ����� 10 ��������, ���� �������� ������ �� ���  ������.</li>
	<li>����� �� ������ ������ ���� ���� ������  10</li>
	<li>������ ������ ����� ����� �� ��� ������ 10 ������ �� ���� \"������\" ������ </li>
</ul>
 ";
			echo "</td>";
		echo "</tr>";
	echo "</table>";
}


function full_summery_credits()
{
	$creditMoney = new creditMoney;
	
	$res = $creditMoney->credit_log_list( "users" , UNK , "1" );
	
	echo "<table cellpadding=0 cellspacing=0 border=0 class=maintext>";
		echo "<tr>";
			echo "<td><b>����� �����</b></td>";
			echo "<td width=10></td>";
			echo "<td><b>�������</b></td>";
			echo "<td width=10></td>";
			echo "<td><b>����</b></td>";
		echo "</tr>";
		
		while( $data = mysql_fetch_array($res) )
		{
			echo "<tr><td colspan=5 height=8></td></tr>";
			echo "<tr>";
				echo "<td>".$data['insert_date']."</td>";
				echo "<td width=10></td>";
				echo "<td dir=ltr align=center>".$data['credit']."</td>";
				echo "<td width=10></td>";
				echo "<td>".stripslashes($data['content'])."</td>";
			echo "</tr>";
			
		}
		echo "<tr><td colspan=5 height=8><hr width=100% size=1 color=#eeeeee></td></tr>";
		
		echo "<tr>";
			echo "<td colspan=5>����: ".$creditMoney->get_creditMoney( "users" , UNK , "1" )."</td>";
		echo "</tr>";
	echo "</table>";
}

function payWithCCforCredit_1ok()
{
	echo "�������� ������ ���� ������ ������";
}

function payWithCCforCredit_1er()
{
	echo "�����<br>��� ��� ����� ��� ������� ��� ������ ���� ������";
}

function payWithCCforLeads_1ok()
{
	echo "���� ������ ����� �� ������ ������";
}

function payWithCCforLeads_1er()
{
	echo "�����<br>��� ��� ����� ��� �����, ��� ������ ���� ������";
}

function advertisers_earn_credit()
{
	$creditMoney = new creditMoney;
	
	$Unicode = $creditMoney->return_user_Unicode( "users" , UNK , "1" );
	
	$sqlPageUser = "SELECT cp.type FROM content_pages AS cp , users AS u WHERE cp.unk = '285240640927706447' AND cp.name = u.name AND u.unk = '".UNK."' ";
	$resPageUser = mysql_db_query( DB , $sqlPageUser );
	$dataPageUser = mysql_fetch_array($resPageUser);
	
	
	echo "<table cellpadding=0 cellspacing=0 border=0 class=maintext>";
		echo "<tr>";
			echo "<td>";
				echo "������� ���������, ��� �����?<br><br>������� �� �������� �����, ������ 1,000 ������ ��������� 10 �������<br>
				<br>
				����� ��� ����� �� ��� ����� 10<br>
				<a href='http://www.10service.co.il/?cuf=".$Unicode."' class='maintext' target='_blank'>www.10service.co.il/?cuf=".$Unicode."</a><br><br>";
				
				if( $dataPageUser['type'] != "" )
				{
					echo "����� ��� ���� ��� ���� ����� 10<br>
					<a href='http://www.10service.co.il/index.php?m=text&t=".$dataPageUser['type']."&cuf=".$Unicode."' class='maintext' target='_blank'>www.10service.co.il/index.php?m=text&t=".$dataPageUser['type']."&cuf=".$Unicode."</a><br><br><br>
					";
				}
				echo "�� �� ����� ���� ���� ����� 10: <b>".$creditMoney->viewEntersByUniCode($Unicode)."</b><br>";
			echo "</td>";
		echo "</tr>";
	echo "</table>";
	
	$creditMoney->viewEntersByUniCode($Unicode);
}

