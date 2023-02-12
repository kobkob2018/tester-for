<?php

function langs_list()
{
	$sql = "select * from site_langs";
	$res = mysql_db_query(DB,$sql);
	
	echo "<table border=\"0\" cellspacing=\"0\" cellpadding=\"0\" class=\"maintext\">";
		echo "<tr>";
			echo "<td>בחר שפה לעדכון/הוספת מילים</td>";
		echo "</tr>";
		echo "<tr><td height='5'></td></tr>";
		
		while( $data = mysql_fetch_array($res) )
		{
			echo "<tr>";
				echo "<td><a href='?main=langs_choose_words_zone&lang=".$data['id']."&sesid=".SESID."' class='maintext'>".GlobalFunctions::kill_strip($data['lang_name'])."</a></td>";
			echo "</tr>";
			echo "<tr><td height='3'></td></tr>";
		}
	echo "</table>";
}



function langs_choose_words_zone()
{
	
	echo "<table border=\"0\" cellspacing=\"0\" cellpadding=\"0\" class=\"maintext\">";
		echo "<tr>";
			echo "<td>באיזו מערכת תרצה לעדכן/להוסיף מילים</td>";
		echo "</tr>";
		echo "<tr><td height='5'></td></tr>";
		
		echo "<tr>";
			echo "<td><a href='?main=langs_choose_words_zone&sesid=".SESID."' class='maintext'>אתר לקוח</a></td>";
		echo "</tr>";
		echo "<tr><td height='3'></td></tr>";
		
		echo "<tr>";
			echo "<td><a href='?main=langs_choose_words_zone&sesid=".SESID."' class='maintext'>מערכת ניהול של לקוח</a></td>";
		echo "</tr>";
		echo "<tr><td height='3'></td></tr>";
		
	echo "</table>";
	
}
?>