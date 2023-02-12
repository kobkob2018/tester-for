<?

require_once('/home/ilan123/domains/ilbiz.co.il/public_html/global_func/vars.php');
require_once('/home/ilan123/domains/ilbiz.co.il/public_html/global_func/classes/class.estimate.statisitc.php');

$estimate_statisitc = new estimate_statisitc;

$params = array();
$params['domain'] = $_GET['sever_host'];
$params['father_cat'] = $_GET['cat'];
$params['sub_cat'] = $_GET['subCat'];
$params['cat_spec'] = $_GET['cat_spec'];
$stat_id = $estimate_statisitc->newEstimateStat($params);


$sql = "SELECT name FROM content_pages WHERE type = '".$_GET['pageId']."' ";
$res = mysql_db_query(DB, $sql);
$dataPage = mysql_fetch_array($res);


$sql = "SELECT choosenClientId FROM estimate_miniSite_defualt_block WHERE type = '".$_GET['pageId']."'";
$res = mysql_db_query(DB, $sql);
$estimate_data = mysql_fetch_array($res);


$take_cat2 = ( $params['sub_cat'] != "0" ) ? $params['sub_cat'] : $params['father_cat'];
$take_cat = ( $take_cat2 != "0" ) ? "bc.id=".$take_cat2." AND" : "";

$sql = "select u.unk FROM 
	users as u,
	user_cat as uc,
	biz_categories as bc ,
	user_extra_settings as us
		WHERE 
			u.id = '".$estimate_data['choosenClientId']."' AND 
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
$users_data = mysql_fetch_array($res_choosenClient);



?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">


<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="he" lang="he">

<head>
	<meta http-equiv="content-type" content="text/html; charset=windows-1255" />
	<title></title>
	
	<style>
		body{
			background-color: #f7f7f7;
			direction: rtl;
			margin:0 ;
		}
		.maintext{
			font-family: arial;
			font-size: 12px;
			color: #000000;
		}
		
		.input_st{
			border: 1px solid #cecece;
			font-family: arial;
			font-size: 12px;
			color: #666666;
			width: 100px;
		}
		
		.send_data{
			border: 1px solid #cecece;
			font-family: arial;
			font-size: 12px;
			color: #666666;
			width: 90px;
		}
		
	</style>
	
	<script>
		function check_form() 
		{
			var str = "";
			var counter = 1;
		
			
			if(document.send_es_form.Fm_name.value =="") {
				str += counter++ + ". שם מלא \n";			
			}
			
			if(document.send_es_form.Fm_phone.value =="") {
				str += counter++ + ". טלפון \n";			
			}
			
			if(!document.send_es_form.taKn.checked) {
				str += counter++ + ". אנא אשרו שקראתם ואתם מאשרים את התקנון \n";			
			}
				
			if(counter > 1) {
				str = ":בכדי להשלים את הפניה, יש למלא את השדות הבאים \n\n" + str;
				alert(str);	
			}
			else {
				document.send_es_form.submit();	
			}
		}
	</script>
</head>

<body>
<?
if( $_GET['mode'] == "thanks" )
{
	echo "<p class=maintext align=center>פנייתך התקבלה ותטופל בהקדם - הצעות המחיר בדרך אלייך</p>";
}
else
{
	echo "<form name=\"send_es_form\" method=\"post\" action=\"http://www.mysave.co.il/s.php\" onsubmit='return check_form()'>";
	echo "<input type=\"hidden\" name=\"cat_f\" value='".$_GET['cat']."' />";
	echo "<input type=\"hidden\" name=\"cat_s\" value='".$_GET['subCat']."' />";
	echo "<input type=\"hidden\" name=\"cat_spec\" value='".$_GET['cat_spec']."' />";

	if( !empty($users_data['unk']) )
		echo "<input type=\"hidden\" name=\"clientUnk\" value='".$users_data['unk']."' />";
	
	echo "<input type=\"hidden\" name=\"stat_id\" value='".$stat_id."' />";
	echo "<input type=\"hidden\" name=\"estimateGoto\" value='".$_GET['sever_host']."/estimate_form.php?mode=thanks' />";
	echo "<input type=\"hidden\" name=\"M\" value='save_form_site' />";
	
	echo "<table align=\"center\" border=\"0\" width=\"100%\" cellpadding=\"1\">";
		echo "<tr>";
			echo "<td valign=\"top\">";
				echo "<table width=\"175\" border=\"0\" class='maintext' cellpadding=0 cellspacing=0>";
				
					echo "<tr>";
						echo "<td>שם מלא:</td><td width=\"2\"></td><td><input type=\"text\" name=\"Fm_name\" class=\"input_st\" /></td>";
					echo "</tr>";
					echo "<tr><td colspan=3 height=5></td></tr>";
					echo "<tr>";
						echo "<td>טלפון:</td><td width=\"2\"></td><td><input type=\"text\" name=\"Fm_phone\" dir=\"ltr\" class=\"input_st\" /></td>";
					echo "</tr>";
					echo "<tr><td colspan=3 height=5></td></tr>";
					echo "<tr>";
						echo "<td>אימייל:</td><td width=\"2\"></td><td><input type=\"text\" name=\"Fm_email\" dir=\"ltr\" class=\"input_st\" /></td>";
					echo "</tr>";
					echo "<tr><td colspan=3 height=5></td></tr>";
					$sql = "SELECT id, name FROM newCities WHERE father=0 ORDER BY id";
					$resAll = mysql_db_query(DB,$sql);
					
					echo "<tr>";
						echo "<td>עיר:</td><td width=\"2\"></td><td>";
						echo "<select name='Fm_city' class=\"input_st\" style='font-size: 10px; width: 104px;'>";
							
							while( $data = mysql_fetch_array($resAll) )
							{
								echo "<option value='".$data['id']."' style='color: #000000;'>".stripslashes($data['name'])."</option>";
								
								$sql = "SELECT id, name FROM newCities WHERE father=".$data['id']." ORDER BY name";
								$resAll2 = mysql_db_query(DB,$sql);
								
								while( $data2 = mysql_fetch_array($resAll2) )
								{
									$selected = ( eregi( stripslashes($data2['name']) , stripslashes($dataPage['name']) ) ) ? "selected" : "";
									echo "<option value='".$data2['id']."' ".$selected.">".stripslashes($data2['name'])."</option>";
								}
								echo "<option value=''>-----------------------</option>";
							}
						echo "</select>";
						echo "</td>";
				echo "</tr>";
				echo "<tr><td colspan=3 height=5></td></tr>";
				echo "<tr>";
					echo "<td>הערה/בקשה:</td><td width=\"2\"></td><td><textarea name=\"Fm_note\" class='input_st' style=\"height:50px;\" cols=\"\" rows=\"\"></textarea></td>";
				echo "</tr>";
				echo "<tr>";
					echo "<td colspan=\"3\">
						<table border=\"0\" cellpadding=\"0\" cellspacing=\"0\">
							<tr>
								<td><input type='checkbox' name='taKn' value='1' /></td>
								<td width=\"2\"></td>
								<td><a href='javascript:void(0)' onclick=\"window.open('http://www.ilbiz.co.il/taKn.php','mywindow','width=350,height=150')\" class='maintext'>אני קראתי ומאשר את <u>התקנון</u></a></td>
							</tr>
						</table>
					</td>";
				echo "</tr>";
				echo "<tr><td colspan=3 height=2></td></tr>";
				echo "<tr>";
					echo "<td colspan=\"3\" align=\"left\"><input class=\"send_data\" type='button' value=\"שלח בקשה\" onclick=\"check_form()\" /></td>";
				echo "</tr>";
			echo "</table>";
		echo "</form>";
}
	?>
</body>

</html>
