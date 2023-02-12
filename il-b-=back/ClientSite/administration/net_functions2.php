<?

function net_mailing_report()
{
	
	$m_t = ( $_GET['m_t'] == "" ) ? "1" : $_GET['m_t'];
	
	switch( $m_t )
	{
		case "1" :
		
			$sql = "select id , mailing_name from net_mailing_settings where unk = '".UNK."' AND deleted=0 ORDER BY id desc ";
			$res = mysql_db_query(DB,$sql);
			
			echo "<table border='0' cellspacing='0' cellpadding='0' class='maintext'>";
				
				echo "<tr>";
					echo "<td><b>דיוור</b></td>";
					echo "<td width=10></td>";
					echo "<td></td>";
				echo "</tr>";
				
				while( $data = mysql_fetch_array($res) ) 
				{
					echo "<tr><td colspan=7 height=7></td></tr>";
					echo "<tr>";
						echo "<td>".stripslashes($data['mailing_name'])."</td>";
						echo "<td width=10></td>";
						echo "<td><a href='index.php?main=net_mailing_report&type=net_mailing&m_t=2&mailing_id=".$data['id']."&unk=".UNK."&sesid=".SESID."' class='maintext'>למעקב אחר דיוור זה</a></td>";
					echo "</tr>";
				}
					
			echo "</table>";
		break;
		
		case "2" :
			$sql = "select id , mail_number, subject  from net_mailing_msg_mails where unk = '".UNK."' AND deleted=0 AND mailing_id = '".$_GET['mailing_id']."' ORDER BY mail_number ";
			$res = mysql_db_query(DB,$sql);
			
			$sql = "select mailing_name from net_mailing_settings where unk = '".UNK."' AND deleted=0 AND id = '".$_GET['mailing_id']."'";
			$resM = mysql_db_query(DB,$sql);
			$dataM = mysql_fetch_array($resM);
			
			echo "<table border='0' cellspacing='0' cellpadding='0' class='maintext'>";
				
				echo "<tr>";
					echo "<td colspan=9>שם הדיוור: <b>".stripslashes($dataM['mailing_name'])."</b></td>";
				echo "</tr>";
				
				echo "<tr><td colspan=9 height=7></td></tr>";
				
				echo "<tr>";
					echo "<td><b>מספר המייל</b></td>";
					echo "<td width=10></td>";
					echo "<td><b>כותרת המייל</b></td>";
					echo "<td width=10></td>";
					echo "<td><b>נשלח לאנשים שונים</b></td>";
					echo "<td width=10></td>";
					echo "<td><b>מייל נצפה -  משוער</b></td>";
					echo "<td width=10></td>";
					echo "<td><b>דף אינטרנט נצפה</b></td>";
				echo "</tr>";
				
				while( $data = mysql_fetch_array($res) ) 
				{
					$sql = "SELECT COUNT(distinct user_id) as num1 FROM net_mailing_users_received_msg WHERE mail_id = '".$data['id']."' AND mailing_id = '".$_GET['mailing_id']."' ";
					$res1 = mysql_db_query(DB,$sql);
					$data1 = mysql_fetch_array($res1);
					
					$sql = "SELECT COUNT(distinct user_id) as num2 FROM net_mailing_users_received_msg WHERE mail_id = '".$data['id']."' AND mailing_id = '".$_GET['mailing_id']."' AND see_mail = 1 ";
					$res2 = mysql_db_query(DB,$sql);
					$data2 = mysql_fetch_array($res2);
					
					$sql = "SELECT COUNT(distinct user_id) as num3 FROM net_mailing_users_received_msg WHERE mail_id = '".$data['id']."' AND mailing_id = '".$_GET['mailing_id']."' AND view_url = 1 ";
					$res3 = mysql_db_query(DB,$sql);
					$data3 = mysql_fetch_array($res3);
					
					echo "<tr><td colspan=9 height=2></td></tr>";
					echo "<tr><td colspan=9><hr width=100% size=1 color=#000000></td></tr>";
					echo "<tr><td colspan=9 height=2></td></tr>";
					echo "<tr>";
						echo "<td>".$data['mail_number']."</td>";
						echo "<td width=10></td>";
						echo "<td>".stripslashes($data['subject'])."</td>";
						echo "<td width=10></td>";
						echo "<td><a href='index.php?main=net_mailing_report&type=net_mailing&m_t=3&m_t2=1&mailing_id=".$_GET['mailing_id']."&mail_id=".$data['id']."&unk=".UNK."&sesid=".SESID."' class='maintext'>".$data1['num1']."</a></td>";
						echo "<td width=10></td>";
						echo "<td><a href='index.php?main=net_mailing_report&type=net_mailing&m_t=3&m_t2=2&mailing_id=".$_GET['mailing_id']."&mail_id=".$data['id']."&unk=".UNK."&sesid=".SESID."' class='maintext'>".$data2['num2']."</td></td>";
						echo "<td width=10></td>";
						echo "<td><a href='index.php?main=net_mailing_report&type=net_mailing&m_t=3&m_t2=3&mailing_id=".$_GET['mailing_id']."&mail_id=".$data['id']."&unk=".UNK."&sesid=".SESID."' class='maintext'>".$data3['num3']."</td></td>";
					echo "</tr>";
				}
				
			echo "</table>";
		break;
		
		case "3" :
			$sql = "select mailing_name from net_mailing_settings where unk = '".UNK."' AND deleted=0 AND id = '".$_GET['mailing_id']."'";
			$resM = mysql_db_query(DB,$sql);
			$dataM = mysql_fetch_array($resM);
			
			$sql = "select subject from net_mailing_msg_mails where unk = '".UNK."' AND deleted=0 AND mailing_id = '".$_GET['mailing_id']."' AND id = '".$_GET['mail_id']."' ";
			$resM2 = mysql_db_query(DB,$sql);
			$dataM2 = mysql_fetch_array($resM2);
			
			switch( $_GET['m_t2'] )
			{
				case "1" :
					$sql = "SELECT u.fname , u.lname , u.email , u.mobile	, DATE_FORMAT(msg.date_send, '%d-%m-%Y') AS sendDate FROM net_mailing_users_received_msg AS msg , net_users AS u WHERE 
						msg.mail_id = '".$_GET['mail_id']."' AND msg.mailing_id = '".$_GET['mailing_id']."' AND
						u.id = msg.user_id
						GROUP BY msg.user_id ORDER BY msg.date_send DESC";
					$res = mysql_db_query(DB,$sql);
				break;
				
				case "2" :
					$sql = "SELECT u.fname , u.lname , u.email , u.mobile	, DATE_FORMAT(msg.date_send, '%d-%m-%Y') AS sendDate FROM net_mailing_users_received_msg AS msg , net_users AS u WHERE 
						msg.mail_id = '".$_GET['mail_id']."' AND msg.mailing_id = '".$_GET['mailing_id']."' AND
						u.id = msg.user_id AND msg.see_mail = 1
						GROUP BY msg.user_id ORDER BY msg.date_send DESC";
					$res = mysql_db_query(DB,$sql);
				break;
				
				case "3" :
					$sql = "SELECT u.fname , u.lname , u.email , u.mobile	, DATE_FORMAT(msg.date_send, '%d-%m-%Y') AS sendDate FROM net_mailing_users_received_msg AS msg , net_users AS u WHERE 
						msg.mail_id = '".$_GET['mail_id']."' AND msg.mailing_id = '".$_GET['mailing_id']."' AND
						u.id = msg.user_id AND msg.view_url = 1
						GROUP BY msg.user_id ORDER BY msg.date_send DESC";
					$res = mysql_db_query(DB,$sql);
				break;
			}
			
			
			echo "<table border='0' cellspacing='0' cellpadding='0' class='maintext'>";
				
				echo "<tr>";
					echo "<td colspan=7>שם הדיוור: <b>".stripslashes($dataM['mailing_name'])."</b> - ".stripslashes($dataM2['subject'])."</td>";
				echo "</tr>";
				
				echo "<tr><td colspan=7 height=7></td></tr>";
				
				echo "<tr>";
					echo "<td><b>שם מלא</b></td>";
					echo "<td width=10></td>";
					echo "<td><b>אימייל</b></td>";
					echo "<td width=10></td>";
					echo "<td><b>פלאפון</b></td>";
					echo "<td width=10></td>";
					echo "<td><b>תאריך שליחה</b></td>";
				echo "</tr>";
				
				while( $data = mysql_fetch_array($res) ) 
				{
					echo "<tr><td colspan=7 height=7></td></tr>";
					
					echo "<tr>";
						echo "<td>".stripslashes($data['fname'])." ".stripslashes($data['lname'])."</td>";
						echo "<td width=10></td>";
						echo "<td>".stripslashes($data['email'])."</td>";
						echo "<td width=10></td>";
						echo "<td>".stripslashes($data['mobile'])."</td>";
						echo "<td width=10></td>";
						echo "<td>".stripslashes($data['sendDate'])."</td>";
					echo "</tr>";
				}
					
			echo "</table>";
		break;
	}
}