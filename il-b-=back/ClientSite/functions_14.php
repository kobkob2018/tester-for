<?php

function realty()
{
	$realty_id = (int)$_GET['rid'];
	
	$sql = "SELECT * FROM user_realty WHERE id = '".$realty_id."' ";
	$res = mysql_db_query(DB,$sql);
	$data = mysql_fetch_array($res);
	
	$r_server_path = SERVER_PATH."/realty_image/".$realty_id."/";
	
	echo "<table border=0 cellpadding=0 cellspacing=0 width=100%>";
		echo "<tr>";
			echo "<td>";
				echo "<table border=0 cellpadding=0 cellspacing=0 width=100%>";
					echo "<tr>";
						echo "<td>";
							echo "<table border=0 cellpadding=0 cellspacing=0 width=100% style='border: 1px solid #eee;'>";
								echo "<tr>";
									$img_L = $im."-L";
									foreach (glob($r_server_path."1-L*") as $filename) {
										$ex = explode("/".$realty_id."/" , $filename );
										$exte = substr($ex[1],(strpos($ex[1],".")+1));
									}
									$abpath_temp_unlink = $r_server_path."1-L".".".$exte;
									
									list($th_width, $th_height) = getimagesize($abpath_temp_unlink);
									
									echo "<td valign=top width='".$th_width."'>";
										$img_L = $im."-L";
										foreach (glob($r_server_path."1-L*") as $filename) {
											$ex = explode("/".$realty_id."/" , $filename );
											$exte = substr($ex[1],(strpos($ex[1],".")+1));
										}
										$abpath_temp_unlink = $r_server_path."1-L".".".$exte;
											
										if( file_exists($abpath_temp_unlink) && !is_dir($abpath_temp_unlink) )	{
											echo "<img src=\"realty_image/".$realty_id."/1-L.".$exte."\" rel=\"lightbox\" border=\"0\">";
										}
									echo "</td>";
									echo "<td width=20></td>";
									echo "<td valign=top align=right>";
										echo "<table border=0 cellpadding=0 cellspacing=0>";
											echo "<tr>";
												echo "<td>";
													echo "<h3 style='padding:0; margin:0;'>".stripslashes($data['title'])."</h3><br>";
													echo "<b>מיקום:</b> ".stripslashes($data['location'])."<br>";
													echo "<b>מספר חדרים:</b> ".stripslashes($data['rooms'])." ";
													echo "<b>גודל:</b> ".stripslashes($data['size_by_meter'])." ";
													echo "<b>קומה:</b> ".stripslashes($data['floor'])."<br><br>";
													echo "<b>פרטים נוספים:</b><br> ".nl2br(stripslashes($data['notes']));

												echo "<br><br></td>";
											echo "</tr>";
										echo "</table>";
									echo "</td>";
								echo "</tr>";
							echo "</table>";
						echo "</td>";
					echo "</tr>";
					echo "<tr>";
						echo "<td height=10 bgcolor='#eeeeee'></td>";
					echo "</tr>";
				echo "</table>";
			echo "</td>";
		echo "</tr>";
		echo "</tr><tr><td height=15></td></tr>";
		echo "<tr>";
			echo "<td>";
				echo "<table border='0' cellpadding='0' cellspacing='0' class='maintext' width=100%>";
						$counter = 0;
						
						for($im=1 ; $im<=9 ; $im++ )
						{
							if( $counter%3 == 0 )
								echo "<tr>";
									
									$img_L = $im."-L";
									foreach (glob($r_server_path.$img_L."*") as $filename) {
										$ex = explode("/".$realty_id."/" , $filename );
										$exte = substr($ex[1],(strpos($ex[1],".")+1));
									}
									$abpath_temp_unlink = $r_server_path.$img_L.".".$exte;
										
									if( file_exists($abpath_temp_unlink) && !is_dir($abpath_temp_unlink) )
									{
										echo "<td valign=middle align=center style='border: 1px solid #9D9D9D; background-color: #eeeeee; padding: 3px; margin: 3px;'>";
										
										$img_EX = $im."-EX";
										foreach (glob($r_server_path.$img_EX."*") as $filename) {
											$ex = explode("/".$realty_id."/" , $filename );
											$exte2 = substr($ex[1],(strpos($ex[1],".")+1));
										}
										$abpath_temp_unlink1 = $r_server_path.$img_L.".".$exte2;
										
										$exist_img = ( $counter == 1 ) ? "thumbnail2" : "thumbnail";
										
										echo "<a href=\"realty_image/".$realty_id."/".$img_EX.".".$exte2."\" rel=\"lightbox[page]\"><img src=\"realty_image/".$realty_id."/".$img_L.".".$exte."\" rel=\"lightbox\" border=\"0\"></a>";
										$counter++;
										
										echo "</td>";
									}
									
							
							
							if( $counter%3 == 0 )
								echo "</tr><tr><td colspan=10 height=15></td></tr>";
							else
								echo "<td width=15></td>";
							
						}
				echo "</table>";
			echo "</td>";
		echo "</tr>";
		echo "</tr><tr><td height=15></td></tr>";
		echo "<tr>";
			echo "<td align=center>".stripslashes($data['video_code'])."</td>";
		echo "</tr>";
		
	echo "</table>";
	
}