<?

require('../../global_func/vars.php');
require("/home/ilan123/domains/10service.co.il/public_html/newsite/class.creditMoney.10service.php");

?>

<html>
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=windows-1255">
	<title>����� �������</title>
	
	<style>
		p { font-family: arial; font-size: 13px; color: #000000 }
		h1 { font-family: arial; font-size: 18px; color: #000000 }
	</style>
</head>

<body dir=rtl align=right>
	<h1>����� ������� ����� ��� �� ��� ����� ����� �������� ��"�</h1>
	<?
if( $_GET['uniqueSes'] != "" && $_GET['paid'] != "1" && $_GET['try'] != "1" )
{
	// select all the data for the payment
	$sql = "SELECT * FROM ilbiz_launch_fee WHERE uniqueSes = '".$_GET['uniqueSes']."' ";
	$res = mysql_db_query(DB,$sql);
	$data = mysql_fetch_array($res);
	
	// check paid
	$sql = "SELECT payGood FROM ilbizPayByCCLog WHERE id = '".$data['order_id']."' ";
	$res = mysql_db_query(DB,$sql);
	$data_payGood = mysql_fetch_array($res);
	
	if( $data['deleted'] == "1" )
	{
		echo "<p>����� ���� ����.</p>";
	}
	elseif( $data_payGood['payGood'] != "2" )
	{
		// select user id
		$sql = "SELECT id,address,phone,email,city FROM users WHERE unk = '".$data['unk']."' ";
		$res = mysql_db_query(DB,$sql);
		$dataUser = mysql_fetch_array($res);
		
		$sql = "SELECT name FROM cities WHERE id = '".$dataUser['city']."' ";
		$cityRes = mysql_db_query(DB,$sql);
		$dataCity = mysql_fetch_array($cityRes);
		
		
		$total_price = $data['price'];
		
		
		
		$creditMoney = new creditMoney;
		$credits = $creditMoney->get_creditMoney("users" , $data['unk'] , "1");
		
		if( $credits >= $total_price )
		{
			$notar_cr = $credits - $total_price;
			echo "�� �� ".$credits." �������<br>��� ���� ���� ".$total_price." ��<br>��� ���� �� �������� ������ �� ������?<br><br>���� ������ ����� �� ".$notar_cr." �������";
			echo "<br><br><a href='pay.php?credit_pay_100=1&uniqueSes=".$_GET['uniqueSes']."' class='maintext'>��� ��� ����� ������ �� ����� ����</a>";
		}
		elseif( $credits > 0 && $total_price > $credits )
		{
			$notar_cr = $total_price - $credits;
			echo "�� �� ".$credits." �������<br>��� ���� ���� ".$total_price." ��<br>���� �������� �� ���� �� ���� �����<br><br>";
			echo "<a href='pay.php?credit_pay_hel=1&uniqueSes=".$_GET['uniqueSes']."' class='maintext'>��� ��� ������ �� ".$notar_cr." �� ���� ����� �� ��������</a>";
		}
		else
		{
			$sql = "INSERT INTO ilbizPayByCCLog ( sumTotal , payDate , description , payToType , userId , gotoUrlParamter ) VALUES (
			'".$data['price']."' , NOW() , '".$data['details']."' , '3' , '".$dataUser['id']."' , 'uniqueSes=".$_GET['uniqueSes']."' )";
			$res = mysql_db_query(DB,$sql);
			$userIdU = mysql_insert_id();
			
			$sql = "UPDATE ilbiz_launch_fee SET order_id = '".$userIdU."' WHERE id = '".$data['id']."' ";
			$res = mysql_db_query(DB,$sql);
			
			$details = str_replace('"' , "''" , stripslashes($data['details']));
			echo '
				<form name="YaadPay" action="https://icom.yaad.net/cgi-bin/yaadpay/yaadpay.pl" method="post" >
				<INPUT TYPE="hidden" NAME="Masof" value="4500019225" >
				<INPUT TYPE="hidden" NAME="action" value="pay" >
				<INPUT TYPE="hidden" NAME="Amount" value="'.$total_price.'" >
				<INPUT TYPE="hidden" NAME="Order" value="'.$userIdU.'" >
				<INPUT TYPE="hidden" NAME="Info" value ="'.$details.'" >
				<input type="hidden" name="SendHesh" value="true">
				<INPUT TYPE="hidden" NAME="Tash" value="'.$data['tash'].'" >
				<input type="hidden" name="heshDesc" value="'.$details.'">
				<INPUT TYPE="hidden" NAME="MoreData" value="True" >
				<INPUT TYPE="hidden" NAME="street" value="'.$dataUser['address'].'" >
				<INPUT TYPE="hidden" NAME="city" value="'.$dataCity['name'].'" >
				<INPUT TYPE="hidden" NAME="phone" value="'.$dataUser['phone'].'" >
				<INPUT TYPE="hidden" NAME="email" value="'.$dataUser['email'].'" >
				
				</form>
				<p>���� ���� ������...</p>
				
				<script>YaadPay.submit();</script>
			';
		}
		
		
		
		
		if( $_GET['credit_pay_100'] == "1" )
		{
			$creditMoney->change_credit( "users" , $dataUser['id'] , "-".$total_price , $data['details']." |||  ����� � ".$total_price." �� ���� �� ����� ��������" );
			
			$sql = "INSERT INTO ilbizPayByCCLog ( sumTotal , payDate , description , payToType , userId , gotoUrlParamter ) VALUES (
				'".$credits."' , NOW() , '".$data['details']." |||  ����� � ".$total_price." �� ���� �� ����� ��������' , '8' , '".$dataUser['id']."' , 'uniqueSes=".$_GET['uniqueSes']."' )";
			$res = mysql_db_query(DB,$sql);
			$userIdU = mysql_insert_id();
			
			$sql = "UPDATE ilbiz_launch_fee SET order_id = '".$userIdU."' WHERE id = '".$data['id']."' ";
			$res = mysql_db_query(DB,$sql);
			
			$sql = "UPDATE ilbizPayByCCLog SET payGood = '2' WHERE id = '".$userIdU."' limit 1";
			$res = mysql_db_query(DB, $sql);
			
			echo "<p>���� ���� ������ �� ��� ����� ��������<br>
			<br>
			�����,<br>
			��� �� ��� ����� ����� �������� ��\"�</p>";
	
		}
		elseif( $_GET['credit_pay_hel'] == "1" )
		{
			$notar_cr = $total_price - $credits;
			$sql = "INSERT INTO ilbizPayByCCLog ( sumTotal , payDate , description , payToType , userId , gotoUrlParamter ) VALUES (
				'".$notar_cr."' , NOW() , '".$data['details']." ||| ����� � ".$credits." �� ���� �� ����� ��������' , '8' , '".$dataUser['id']."' , 'uniqueSes=".$_GET['uniqueSes']."' )";
			$res = mysql_db_query(DB,$sql);
			$userIdU = mysql_insert_id();
			
			$sql = "UPDATE ilbiz_launch_fee SET order_id = '".$userIdU."' WHERE id = '".$data['id']."' ";
			$res = mysql_db_query(DB,$sql);
			
			$details = str_replace('"' , "''" , stripslashes($data['details']));
			
			echo '
			<form name="YaadPay" action="https://icom.yaad.net/cgi-bin/yaadpay/yaadpay.pl" method="post" >
			<INPUT TYPE="hidden" NAME="Masof" value="4500019225" >
			<INPUT TYPE="hidden" NAME="action" value="pay" >
			<INPUT TYPE="hidden" NAME="Amount" value="'.$notar_cr.'" >
			<INPUT TYPE="hidden" NAME="Order" value="'.$userIdU.'" >
			<INPUT TYPE="hidden" NAME="Info" value ="'.$details.'" >
			<input type="hidden" name="SendHesh" value="true">
			<INPUT TYPE="hidden" NAME="Tash" value="'.$data['tash'].'" >
			<input type="hidden" name="heshDesc" value="'.$details.'">
			<INPUT TYPE="hidden" NAME="MoreData" value="True" >
			<INPUT TYPE="hidden" NAME="street" value="'.$dataUser['address'].'" >
			<INPUT TYPE="hidden" NAME="city" value="'.$dataCity['name'].'" >
			<INPUT TYPE="hidden" NAME="phone" value="'.$dataUser['phone'].'" >
			<INPUT TYPE="hidden" NAME="email" value="'.$dataUser['email'].'" >
			
			</form>
			<p>���� ���� ������...</p>
			
			<script>YaadPay.submit();</script>
			';
			
		}
	}
	else
	{
		echo "<p>������ ���� ����.</p>";
	}
}
elseif( $_GET['paid'] == "1" )
{
	echo "<p>������� �� ���� ���� ������� ������<br>
	������ ��� ������<br>
	<br>
	�����,<br>
	��� �� ��� ����� ����� �������� ��\"�</p>";
}
elseif( $_GET['try'] == "1" )
{
	echo "<p>��� �� ���� �� ������ ����� ����.<br>
	<a href='pay.php?uniqueSes=".$_GET['uniqueSes']."'>��� ���</a> �� ��� ����� ����
	<br><br>
	�����,<br>
	��� �� ��� ����� ����� �������� ��\"�</p>";
}
?>
</body>

</html>