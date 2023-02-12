<?
//block specific ip
$userIp = $_SERVER['REMOTE_ADDR'];

$http_s = "http";
if(isSecure()){
	$http_s = "https";
}
define('HTTP_S',$http_s);
function isSecure() {
  return
    (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off')
    || $_SERVER['SERVER_PORT'] == 443;
}

if($userIp == '93.173.241.32'){
	exit("oops... Ist's not you, its us!!! Please try again later.");
}
if(isset($_GET['splitcity'])){
	include('version_1'.'/splitcity.php');
}
elseif(isset($_GET['version'])){

	include($_GET['version'].'/ajax2.php');

}
else{
	include('ajax2.php');
}
die;


//header('content-type:TEXT/HTML; charset=UTF-8');
####################################
##
##
##	
##
####################################

require_once('/home/ilan123/domains/ilbiz.co.il/public_html/global_func/vars.php');
require_once('/home/ilan123/domains/ilbiz.co.il/public_html/global_func/classes/class.estimate.statisitc.php');

mysql_query("SET NAMES 'utf8'");

switch($_GET['main'])
{
	case "estimateSiteRow" :
		
		
		$sql = "SELECT id, father FROM biz_categories WHERE id = '".ifint($_GET['cat'])."' ";
		$res = mysql_db_query(DB,$sql);
		$data_father = mysql_fetch_array($res);
		
		if( $data_father['father'] == "0" )
		{
			$f_cat = $_GET['cat'];
			$sub_cat = "0";
		}
		else
		{
			$f_cat = $data_father['father'];
			$sub_cat = $_GET['cat'];
		}
		
		$estimate_statisitc = new estimate_statisitc;
		$params = array();
		$params['domain'] = $_SERVER[HTTP_HOST];
		$params['father_cat'] = $f_cat;
		$params['sub_cat'] = $sub_cat;
		$stat_id = $estimate_statisitc->newEstimateStat($params);
		
		$sql = "SELECT id, name FROM newCities WHERE father=0 ORDER BY id";
		$resAll = mysql_db_query(DB,$sql);
		
		echo "<form name=\"send_es_form\" method=\"post\" action=\"javascript:ajax_estimateSiteRow_send_data()\">";
		echo "<input type=\"hidden\" name=\"cat_f\" id=\"cat_f\" value='".$f_cat."' />";
		echo "<input type=\"hidden\" name=\"cat_s\" id=\"cat_s\" value='".$sub_cat."' />";
		echo "<input type=\"hidden\" name=\"stat_id\" id=\"stat_id\" value='".$stat_id."' />";
		echo "<input type=\"hidden\" name=\"pageId\" id=\"pageId\" value='".$_GET['pageId']."' />";
		echo "<table align=\"center\" border=\"0\" width=\"100%\" cellpadding=\"1\">";
			echo "<tr>";
				echo "<td valign=\"top\">";
					echo "<table width=\"480\" border=\"0\" class='maintext' cellpadding=0 cellspacing=0>";
						
						echo "<tr>";
							echo "<td>שם:</td><td width=\"2\"></td><td><input type=\"text\" name=\"Fm_name\" id=\"Fm_name\" class=\"input_style\" style='width: 60px;' /></td>";
							echo "<td width=\"2\"></td>";
							echo "<td>טלפון:</td><td width=\"2\"></td><td><input type=\"text\" name=\"Fm_phone\" id=\"Fm_phone\" dir=\"ltr\" class=\"input_style\" style='width: 72px;' /></td>";
							echo "<td width=\"2\"></td>";
							echo "<td>אימייל:</td><td width=\"2\"></td><td><input type=\"text\" name=\"Fm_email\" id=\"Fm_email\" dir=\"ltr\" class=\"input_style\" style='width: 110px;' /></td>";
							echo "<td width=\"2\"></td>";
							echo "<td>עיר:</td><td width=\"2\"></td><td align=left>";
							echo "<select name='Fm_city' id='Fm_city' class=\"input_style\" style='font-size: 10px; width: 104px; height:18px;'>";
								
								while( $data = mysql_fetch_array($resAll) )
								{
									$cityName = ( $data['name'] == "כל הארץ" ) ? "בחר עיר" : $data['name'];
									echo "<option value='".$data['id']."' style='color: #000000;'>".stripslashes($cityName)."</option>";
									
									$sql = "SELECT id, name FROM newCities WHERE father=".ifint($data['id'])." ORDER BY name";
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
					
					
					$sql = "SELECT id , cat_name FROM biz_categories WHERE status=1 AND hidden=0 AND father= '".ifint($_GET['cat'])."' ORDER BY place";
					$res_cats = mysql_db_query(DB , $sql );
					
					$select_name = ( $_GET['t'] == "2" ) ? "cat_prof" : "new_sub_cat" ;
					$select_name_temp  = ( $_GET['t'] == "2" ) ? "new_sub_cat" : "cat_prof" ;
					
					echo "<input type='hidden' name='".$select_name_temp."' id='".$select_name_temp."' value=''> ";
					
					echo "<tr>";
						echo "<td>התמחות:</td><td width=\"2\"></td><td colspan=5>";
							echo "<select name='".$select_name."' id='".$select_name."' class=\"input_style\" style='width: 166px; height:18px;'>";
								echo "<option value='' >בחר התמחות</option>";
								
								while( $data_cats = mysql_fetch_array($res_cats) )
								{
									if( $_GET['t'] == "1" )
									{
										$sql = "SELECT id , cat_name FROM biz_categories WHERE status=1 AND hidden=0 AND father= '".ifint($data_cats['id'])."' ORDER BY place";
										$res_cats_child = mysql_db_query(DB , $sql );
										$num_cats_child = mysql_num_rows($res_cats_child);
									
										echo "<option >--------------------------------------</option>";
									}
									
									echo "<option value='C".$data_cats['id']."'>".stripslashes($data_cats['cat_name'])."</option>";
									
									if( $_GET['t'] == "1" )
									{
										if( $num_cats_child > 0 )
										{
											while( $data_cats_child = mysql_fetch_array($res_cats_child) )
											{
												echo "<option value='E".$data_cats['id']."F".$data_cats_child['id']."' >&nbsp;&nbsp;&nbsp;&nbsp;".stripslashes($data_cats_child['cat_name'])."</option>";
											}
										}
									}
								}
								
							echo "</select>";
						echo "</td>";
						echo "<td colspan=8>";
							echo "<table width=100% border=\"0\" class='maintext' cellpadding=0 cellspacing=0>";
								echo "<tr>";
									//echo "<td valign=bottom>הערה/בקשה:</td><td width=\"2\"></td><td><textarea name=\"Fm_note\" class='input_style' style=\"height:40px; width: 150px;\" cols=\"\" rows=\"\"></textarea></td>";
									echo "<td valign=bottom align=\"left\" style='font-size: 10px;'>";
										/*echo "<table border=\"0\" cellpadding=\"0\" cellspacing=\"0\">
											<tr>
												<td><input type='checkbox' name='taKn' id='taKn' value='1' /></td>
												<td width=\"2\"></td>
												<td><a href='javascript:void(0)' onclick=\"window.open('http://www.ilbiz.co.il/taKn.php','mywindow','width=350,height=150')\" class='maintext'>אני קראתי ומאשר את <u>התקנון</u></a></td>
											</tr>
										</table>";*/
										echo "שירות הצעות מחיר בחינם וללא התחייבות";
									echo "</td>";
									echo "<td valign=bottom align=\"left\"><input class=\"submit_style\" type='submit' value=\"שלח בקשה\" style='width:70px;' id='submitit' /></td>";
								echo "</tr>";
							echo "</table>";
						echo "</td>";
					echo "</tr>";
					
					
					
				echo "</table>";
			echo "</form>";
	break;
	
	case "estimateSiteHeight" :
		$estimate_statisitc = new estimate_statisitc;

		$params = array();
		$params['domain'] = $_SERVER[HTTP_HOST];
		$params['father_cat'] = $_GET['cat'];
		$params['sub_cat'] = $_GET['subCat'];
		$params['cat_spec'] = $_GET['cat_spec'];
		$stat_id = $estimate_statisitc->newEstimateStat($params);
		
		
		$sql = "SELECT name,unk FROM content_pages WHERE type = '".ifint($_GET['pageId'])."' ";
		$res = mysql_db_query(DB, $sql);
		$dataPage = mysql_fetch_array($res);
		
		
		$sql = "SELECT choosenClientId , cityId FROM estimate_miniSite_defualt_block WHERE type = '".ifint($_GET['pageId'])."'";
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
					u.id = '".ifint($estimate_data['choosenClientId'])."' AND 
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


		echo "<form name=\"send_es_form\" method=\"post\" action=\"javascript:ajax_estimateSiteHeight_send_data()\">";
		echo "<input type=\"hidden\" name=\"cat_f\" id=\"cat_f\" value='".$_GET['cat']."' />";
		echo "<input type=\"hidden\" name=\"pageId\" id=\"pageId\" value='".$_GET['pageId']."' />";
		echo "<input type=\"hidden\" name=\"clientUnk\" id=\"clientUnk\" value='".$users_data['unk']."' />";
		
		echo "<input type=\"hidden\" name=\"stat_id\" id=\"stat_id\" value='".$stat_id."' />";
	
				echo "<table border=\"0\" class='maintext' cellpadding=0 cellspacing=0>";
					
					if( !empty($users_data['unk']) )
					{
						if( $params['sub_cat'] != "0" )
						{
							$take_cat2 = $params['sub_cat'];
							$choose_name = "cat_spec";
							echo "<input type=\"hidden\" name=\"cat_s\" id=\"cat_s\" value='".$_GET['subCat']."' />";
						}
						else
						{
							$take_cat2 = $params['father_cat'];
							$choose_name = "cat_s";
							echo "<input type=\"hidden\" name=\"cat_spec\" id=\"cat_spec\" value='' />";
						}
						
						$take_cat_mi = ( $take_cat2 != "0" ) ? "bc.father=".$take_cat2." AND" : "";
						
						$sql = "select bc.id , bc.cat_name FROM 
											users as u,
											user_cat as uc,
											biz_categories as bc
												WHERE 
													u.id = '".ifint($estimate_data['choosenClientId'])."' AND 
													u.deleted=0 AND
													u.status=0 AND
												  u.end_date > NOW() AND
													u.id=uc.user_id AND
													uc.cat_id=bc.id AND
													".$take_cat_mi."
													bc.status=1
											 GROUP BY bc.id";
						$res_choosenClient2 = mysql_db_query(DB, $sql);
						$numbs = mysql_num_rows($res_choosenClient2);
						
						if( $numbs > 0 )
						{
							echo "<tr>";
								echo "<td>התמחות:</td>";
								echo "<td width=\"2\"></td>";
								echo "<td>";
									echo "<select name='" . $choose_name . "' id='" . $choose_name . "' class='input_style' style='width: 104px;'>";
										echo "<option value=''>בחר התמחות</option>";
										while( $data_specc = mysql_fetch_array($res_choosenClient2) )
										{
											echo "<option value='". $data_specc['id'] ."'>".stripslashes($data_specc['cat_name'])."</option>";
										}
									echo "</select>";
								echo "</td>";
							echo "</tr>";
							echo "<tr><td colspan=3 height=5></td></tr>";
						}
					}
					else
					{
						echo "<input type=\"hidden\" name=\"cat_s\" id=\"cat_s\" value='".$_GET['subCat']."' />";
						echo "<input type=\"hidden\" name=\"cat_spec\" id=\"cat_spec\" value='".$_GET['cat_spec']."' />";
					}
					
					echo "<tr>";
						echo "<td>שם מלא:</td><td width=\"2\"></td><td><input type=\"text\" name=\"Fm_name\" id=\"Fm_name\" class=\"input_style\" style='width: 104px;' /></td>";
					echo "</tr>";
					echo "<tr><td colspan=3 height=5></td></tr>";
					echo "<tr>";
						echo "<td>טלפון:</td><td width=\"2\"></td><td><input type=\"text\" name=\"Fm_phone\" id=\"Fm_phone\" dir=\"ltr\" class=\"input_style\" style='width: 104px;' /></td>";
					echo "</tr>";
					echo "<tr><td colspan=3 height=5></td></tr>";
					echo "<tr>";
						echo "<td>אימייל:</td><td width=\"2\"></td><td><input type=\"text\" name=\"Fm_email\" id=\"Fm_email\" dir=\"ltr\" class=\"input_style\" style='width: 104px;' /></td>";
					echo "</tr>";
					echo "<tr><td colspan=3 height=5></td></tr>";
					$sql = "SELECT id, name FROM newCities WHERE father=0 ORDER BY id";
					$resAll = mysql_db_query(DB,$sql);
					
					echo "<tr>";
						echo "<td>";
					if( $take_cat2 == "31" )	echo "מעיר:";
							else	echo "עיר:";
							
						echo "</td><td width=\"2\"></td><td>";
						echo "<select name='Fm_city' id='Fm_city' class=\"input_style\" style='font-size: 10px; width: 104px; height:18px;'>";
							echo "<option value=''>בחר מעיר</option>";
							while( $data = mysql_fetch_array($resAll) )
							{
								if( $take_cat2 == "31" )
								{
									if( $data['id'] != "1" )
										echo "<option value='".$data['id']."' style='color: #000000;'>".stripslashes($data['name'])."</option>";
								}
								else
								{
									$cityName = ( $data['name'] == "כל הארץ" ) ? "בחר עיר" : $data['name'];
									echo "<option value='".$data['id']."' style='color: #000000;'>".stripslashes($cityName)."</option>";
								}
								
								$sql = "SELECT id, name FROM newCities WHERE father=".$data['id']." ORDER BY name";
								$resAll2 = mysql_db_query(DB,$sql);
								
								while( $data2 = mysql_fetch_array($resAll2) )
								{
									//$selected = ( eregi( stripslashes($data2['name']) , stripslashes($dataPage['name']) ) ) ? "selected" : "";
									$selected = ( $data2['id'] == $estimate_data['cityId'] ) ? "selected" : "";
									echo "<option value='".$data2['id']."' ".$selected.">".stripslashes($data2['name'])."</option>";
								}
								echo "<option value=''>-----------------------</option>";
							}
						echo "</select>";
						echo "</td>";
				echo "</tr>";
				echo "<tr><td colspan=3 height=5></td></tr>";
				
				if( $take_cat2 == "31" )
				{
					$sql = "SELECT id, name FROM newCities WHERE father=0 ORDER BY id";
					$resAll3 = mysql_db_query(DB,$sql);
					
					
					echo "<tr>";
						echo "<td>לעיר:</td><td width=\"2\"></td><td>";
						echo "<select name='Fm_to_city' id='Fm_to_city' class=\"input_style\" style='font-size: 10px; width: 104px; height:18px;'>";
							echo "<option value=''>בחר לעיר</option>";
							while( $data = mysql_fetch_array($resAll3) )
							{
								if( $data['id'] != "1" )
									echo "<option value='".$data['id']."' style='color: #000000;'>".stripslashes($data['name'])."</option>";
								
								$sql = "SELECT id, name FROM newCities WHERE father=".$data['id']." ORDER BY name";
								$resAll4 = mysql_db_query(DB,$sql);
								
								while( $data2 = mysql_fetch_array($resAll4) )
								{
									//$selected = ( eregi( stripslashes($data2['name']) , stripslashes($dataPage['name']) ) ) ? "selected" : "";
									$selected = ( $data2['id'] == $estimate_data['cityId'] ) ? "selected" : "";
									echo "<option value='".$data2['id']."' ".$selected.">".stripslashes($data2['name'])."</option>";
								}
								echo "<option value=''>-----------------------</option>";
							}
						echo "</select>";
						echo "</td>";
					echo "</tr>";
					echo "<tr><td colspan=3 height=5></td></tr>";
					
					echo "<tr>";
						echo "<td>מס' נוסעים:</td><td width=\"2\"></td><td>";
						echo "<select name='Fm_passengers' id='Fm_passengers' class=\"input_style\" style='font-size: 10px; width: 104px;  height:18px;'>";
							echo "<option value=''>בחר</option>";
							for( $i=1 ; $i<=51 ; $i++ )
							{
								$new_i = ( $i == "51" ) ? "51+" : $i ;
								echo "<option value='".$i."'>".$new_i."</option>";
							}
						echo "</select>";
						echo "</td>";
					echo "</tr>";
					echo "<tr><td colspan=3 height=5></td></tr>";
				}
				echo "<tr>";
					echo "<td>הערה/בקשה:</td><td width=\"2\"></td><td><textarea name=\"Fm_note\" id=\"Fm_note\" class='input_style' style=\"height:50px; width:104px;\" cols=\"\" rows=\"\"></textarea></td>";
				echo "</tr>";
				echo "<tr><td colspan=3 height=2></td></tr>";
				echo "<tr>";
					
					echo "<td></td><td width=\"2\"></td><td><input class=\"submit_style\" type='submit' style='width: 104px;' value=\"שלח בקשה\" id='submitit' /></td>";
				echo "</tr>";
				
				if( $dataPage['unk'] != "684280361691447887" )
				{
					echo "<tr><td colspan=3 height=2></td></tr>";
					echo "<tr>";
						echo "<td colspan=\"3\" style='font-size: 10px;'>";
							/*echo "<table border=\"0\" cellpadding=\"0\" cellspacing=\"0\">
								<tr>
									<td><input type='checkbox' name='taKn' id='taKn' value='1' /></td>
									<td width=\"2\"></td>
									<td><a href='javascript:void(0)' onclick=\"window.open('http://www.ilbiz.co.il/taKn.php','mywindow','width=350,height=150')\" class='maintext'>אני קראתי ומאשר את <u>התקנון</u></a></td>
								</tr>
							</table>";*/
							echo "שירות הצעות מחיר בחינם וללא התחייבות";
						echo "</td>";
					echo "</tr>";
				}
			echo "</table>";
		echo "</form>";
	break;
	
	case "estimateSiteInsert" :
		
		
		if( $_GET['new_sub_cat'] != "" )
		{
			$temp_cat = str_replace( "C" , "" , $_GET['new_sub_cat'] );
			$cat_s = $temp_cat;
			
			if( eregi( "E" , $_GET['new_sub_cat'] ) )
			{
				$temp = explode( "F" , $_GET['new_sub_cat'] );
				$temp_cat = str_replace( "E" , "" , $temp[0] );
				$cat_s = $temp_cat;
				$data_spec = $temp[1];
			}
		}
		else
			$cat_s = $_GET['cat_s'];
		
		
		if( $_GET['cat_prof'] != "" )
		{
			$temp_sub_cat = ""; 
			
			if( eregi( "C" , $_GET['cat_prof'] ) )
			{
				$temp_cat = str_replace( "C" , "" , $_GET['cat_prof'] );
				$data_spec = $temp_cat;
			}
			else
				$data_spec = $_GET['cat_prof'];
		}
		
		
		$params = "cat_f=".$_GET['cat_f'];
		$params .= "&cat_s=".$cat_s ;
		$params .= "&cat_spec=".$data_spec;
		$params .= "&stat_id=".$_GET['stat_id'];
		$params .= "&ajax_write=1";
		$params .= "&M=save_form_site";
		$params .= "&Fm_name=".optimize_text($_GET['Fm_name']);
		$params .= "&Fm_phone=".optimize_text($_GET['Fm_phone']);
		$params .= "&Fm_email=".optimize_text($_GET['Fm_email']);
		$params .= "&Fm_city=".optimize_text($_GET['Fm_city']);
		$params .= "&Fm_to_city=".optimize_text($_GET['Fm_to_city']);
		$params .= "&Fm_passengers=".optimize_text($_GET['Fm_passengers']);
		$params .= "&Fm_note=".optimize_text($_GET['Fm_note']);
		$params .= "&clientUnk=".$_GET['clientUnk'];
		$params .= "&taKn=".$_GET['taKn'];
		$params .= "&ref=".optimize_text($_SERVER[HTTP_REFERER]);
		
		$ch = curl_init(); 
		curl_setopt( $ch, CURLOPT_URL,"http://www.mysave.co.il/s.php" ); 
		curl_setopt($ch, CURLOPT_HEADER, 0);
		curl_setopt( $ch, CURLOPT_POST, 1 ); 
		curl_setopt( $ch, CURLOPT_POSTFIELDS, $params ); 
		
		$resualt = curl_exec ($ch); 
		curl_close ($ch); 
		
		if( $resualt == "ok" )
		{
			$sql = "SELECT unk FROM content_pages WHERE type = '".ifint($_GET['pageId'])."' ";
			$res = mysql_db_query(DB, $sql);
			$dataPage = mysql_fetch_array($res);
			
			if( $dataPage['unk'] == "684280361691447887" )
				echo "<br>קבלנו את פנייתך,<br>אחד מנציגנו יחזור אליך בהקדם האפשרי.<br><br>בברכה,<br>צוות GLOBALWORK<br><br>";
			else
				echo "<br>פנייתך התקבלה ותטופל בהקדם - הצעות המחיר בדרך אלייך<br><br><br>";
			
			$sql = "SELECT thanksRedirect , thanksPixel FROM estimate_miniSite_defualt_block WHERE type = '".ifint($_GET['pageId'])."'";
			$res = mysql_db_query(DB, $sql);
			$estimate_data = mysql_fetch_array($res);
			
			if( $estimate_data['thanksPixel'] != "" )
			{
				echo stripslashes($estimate_data['thanksPixel']);
			}
			
			if( $estimate_data['thanksRedirect'] != "" )
			{
				echo '<form action="'.stripslashes($estimate_data['thanksRedirect']).'" name="watting" id="watting" method="post"></form>
				<script>setTimeout("watting.submit()",5000);</script>';
			}
		}
		
	break;
	
	
	
	
	
	
	case "product_images" :
	$sql = "SELECT domain FROM users WHERE unk = '".$_GET['unk']."' ";
	$res = mysql_db_query(DB,$sql);
	$userData = mysql_fetch_array($res);
	
	$sql = "select id,  img, img2, img3 from user_products where unk = '".$_GET['unk']."' and deleted = '0' and active = '0' and id = '".ifint($_GET['ud'])."' limit 1";
	$res = mysql_db_query(DB,$sql);
	$data = mysql_fetch_array($res);
	
	$server_path = "/home/ilan123/domains/".$userData['domain']."/public_html/product_image/".$data['id']."/";
	
	echo "<table border=\"0\" cellspacing=\"0\" cellpadding=\"0\" class=\"maintext\">";
		echo "<tr><td height=45></td></tr>";
		echo "<tr>";
			echo "<td valign=top width=200 bgcolor='#F0F0F0' align=center style='border: 1px solid #BFBFBF;'>";
			
				$img_params['img1'] = $data['img1'];
				$img_params['img2'] = $data['img2'];
				$img_params['img3'] = $data['img3'];
				$img_params['name'] = htmlspecialchars(stripslashes($data['name']));
				$img_params['ud'] = $_GET['ud'];
				$img_params['domain'] = $userData['domain'];
				
				echo get_products_img_parameters( $_GET['pimg'] , $img_params );
				
			echo "</td>";
		echo "</tr>";
		echo "<tr><td height=10></td></tr>";
		echo "<tr>";
			echo "<td valign=top align=center>";
				echo "<table border=\"0\" cellspacing=\"0\" cellpadding=\"0\" class=\"maintext\">";
				
				$count=0;
				for( $img=2 ; $img <= 5 ; $img++ )
				{
					if( is_dir($server_path) )
					{
						$img_S = $img."-S";
						
						foreach (glob($server_path.$img_S."*") as $filename) {
							$explo = explode($data['id']."/",$filename);
							$exte = substr($explo[1],(strpos($explo[1],".")+1));
						}
						
						$temp_path = $server_path.$img_S.".".$exte;
						
						if( file_exists($temp_path) && !is_dir($temp_path) )
						{
							if( $count % 2 == 0 )
								echo "<tr>";
							
								echo "<td width=80 height=60 bgcolor='#F0F0F0' align=center style='border: 1px solid #BFBFBF;'>";
								
								if( $_GET['pimg'] == $img )
								{
									echo "<a href='javascript:void(0)' onclick='product_images(\"".$_GET['ud']."\" , \"default\" )'><img src='http://".$userData['domain']."/products/".$data['img']."' alt='' border='0' width=75 style='border: 0px solid #000000;'></a>";
								}
								else
								{
									echo "<a href='javascript:void(0)' onclick='product_images(\"".$_GET['ud']."\" , \"".$img."\" )'><img src='http://".$userData['domain']."/product_image/".$data['id']."/".$img_S.".".$exte."' alt='' border='0' style='border: 0px solid #000000;'></a>";
								}
									
								echo "</td>";
								echo "<td width=2></td>";
							
							
							$count++;
							if( $count % 2 == 0 )
							{
								echo "</tr>";
								echo "<tr><td height=2 colspan=10></td></tr>";
							}
							
						}
					}
				}
			echo "</td>";
		echo "</tr>";
	echo "</table>";
	
	break;
	
}


function optimize_text($utf8 )
{
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


function get_products_img_parameters($img_name , $img_params=array() )
{
	
	switch( $img_name )
	{
		case "default" :
			$img1 = $img_params['img1'];
			$img2 = $img_params['img2'];
			$img3 = $img_params['img3'];
			
			$apth_small = "/home/ilan123/domains/".$img_params['domain']."/public_html/products/".$img;
			$apth_large = "/home/ilan123/domains/".$img_params['domain']."/public_html/products/".$img2;
			$apth_ex = "/home/ilan123/domains/".$img_params['domain']."/public_html/products/".$img3;
			
			$src = "http://".$img_params['domain']."/products/";
		break;
		
		default :
			$server_path = "/home/ilan123/domains/".$img_params['domain']."/public_html/product_image/".$img_params['ud']."/";
			
			$img_temp = $img_name."-S";
			
			foreach (glob($server_path.$img_temp."*") as $filename) {
				$explo = explode($img_params['ud']."/",$filename);
				$exte = substr($explo[1],(strpos($explo[1],".")+1));
			}
			
			$img1 = $img_name."-S.".$exte;
			$img2 = $img_name."-L.".$exte;
			$img3 = $img_name."-EX.".$exte;
			
			$apth_small = $server_path.$img;
			$apth_large = $server_path.$img2;
			$apth_ex = $server_path.$img3;
			
			$src = "http://".$img_params['domain']."/product_image/".$img_params['ud']."/";
	}
	
	
	if( file_exists($apth_ex) && !is_dir($apth_ex) )
		echo "<div id=\"s.prEXimgDiv".$img_name."\" style=\"display:none\"><img src='".$src.$img3."' border='0'></div>";
	
	list($org_width_l, $org_height_l) = getimagesize($apth_large);
	
	if( file_exists($apth_large) && !is_dir($apth_large) )
	{
		if( file_exists($apth_ex) && !is_dir($apth_ex) )
		{
			list($org_width, $org_height) = getimagesize($apth_ex);
			
			$sPrEX_width = $org_width + 10;
			$sPrEX_height = $org_height + 10;
			//echo "<div align='".$settings['re_align']."' style='padding-".$settings['re_align'].": 18px; width:170px;'><a href='javascript:void(0)' onClick=\"divwin=dhtmlwindow.open('s.prEXimg', 'div', 's.prEXimgDiv', '".$word[LANG]['1_1_products_extra_img']." - ".htmlspecialchars(stripslashes($data['name']))."', 'width=".$sPrEX_width."px,height=".$sPrEX_height."px,left=10px,top=10px,resize=0,scrolling=0'); return false\">".$word[LANG]['1_1_products_extra_img_link']."</a></div>";
			echo "<a href='javascript:void(0)' onClick=\"divwin=dhtmlwindow.open('s.prEXimg".$img_name."', 'div', 's.prEXimgDiv".$img_name."', '', 'width=".$sPrEX_width."px,height=".$sPrEX_height."px,left=10px,top=10px,resize=0,scrolling=0'); return false\"><img src='".$src.$img2."' border='0' align='left' alt='' width='".$org_width_l."' height='".$org_height_l."' vspace=5 hspace=5></a>";
			
		}
		else
			echo "<img src='".$src.$img2."' border='0' align='left' width='".$org_width_l."' height='".$org_height_l."' vspace=5 hspace=5>";
	}
	else 
		if( file_exists($apth_small) && !is_dir($apth_small) )
			echo "<img src='".$src.$img."' border='0' align='left'>";
}


?>
