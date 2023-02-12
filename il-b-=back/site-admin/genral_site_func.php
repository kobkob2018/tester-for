<?php

/*

function colors_set_list()	{

	$sql = "select id,set_name from user_colors_set where deleted = '0' and unk = ''";
	$res = mysql_db_query(DB,$sql);
	
	
	echo "<table border=\"0\" cellspacing=\"0\" cellpadding=\"0\" class=\"maintext\">";
		
		echo "<tr>
			<td colspan=\"20\"><A href=\"?&sesid=".SESID."\" class=\"maintext\">חזרה לתפריט הראשי</a></td>
		</tr>";
		echo "<tr><td colspan=\"20\" height=\"7\"></td></tr>";
		echo "<tr>
			<td colspan=\"20\"><A href=\"?main=update_set_colors&sesid=".SESID."\" class=\"maintext\">יצירת סט חדש</a></td>
		</tr>";
		echo "<tr><td colspan=\"20\" height=\"11\"></td></tr>";
		echo "<tr>";
			echo "<td><strong>ID#</strong></td>";
			echo "<td width=\"10\"></td>";
			echo "<td><strong>שם הסט</strong></td>";
			echo "<td width=\"10\"></td>";
			echo "<td><strong>עדכון</strong></td>";
			//echo "<td width=\"10\"></td>";
			//echo "<td><strong>מחיקה</strong></td>";
		echo "</tr>";
		
		while( $data = mysql_fetch_array($res) )	{
			echo "<tr><Td colspan=\"20\"><hr color=\"#000000\" size=\"1\" width=\"100%\"></TD></tr>";
			echo "<tr>";
				echo "<td>".stripslashes($data['id'])."</td>";
				echo "<td width=\"10\"></td>";
				echo "<td>".stripslashes($data['set_name'])."</td>";
				echo "<td width=\"10\"></td>";
				echo "<td><a href=\"?main=update_set_colors&record_id=".$data['id']."&sesid=".SESID."\" class=\"maintext\">עדכון</a></td>";
			echo "</tr>";
		}
		
	echo "</table>";
}*/
/********************************************************************************************************/

function update_set_colors()	{

	$sql = "select * from user_colors_set where deleted = 0 and unk = '".$_REQUEST['unk']."'";
	$res = mysql_db_query(DB,$sql);
	$data = mysql_fetch_array($res);
	
	$sql = "select * from user_extra_settings where unk = '".$_REQUEST['unk']."'";
	$res_extra_settings = mysql_db_query(DB,$sql);
	$user_extra_settings = mysql_fetch_array($res_extra_settings);
	
	
	
	// create the form array
	/*if( $_GET['unk'] == "" )
	{
		$form_arr = array(
			set_name => "שם הסט",
			bg_link => "צבע רקע אזור קישור",
			color_link => "צבע קישור",
			color_link_over => "צבע קישור כשעוברים עליו",
			site_text_color => "צבע טקסט כללי לאתר",
			site_bg_color => "צבע רקע אתר מספר 1",
			conent_bg_color => "צבע רקע תוכן האתר",
			headline_color => "צבע הכותרות",
			menus_color => "צבע רקע של התפריטים",
			border_color_active => "צבע מסגרת פעילה?",
			border_color => "צבע מסגרת",
		);
	}
	
	{*/
		$form_arr = array(
			faviconOn => "FaviIcon - לוגו ליד ה www",
			
			open_flash => "פתיח פלאש",
			open_flash_height => "פתיח פלאש - גובה הפלאש",
			open_flash_width => "פתיח פלאש - רוחב הפלאש",
			open_flash_color => "פתיח פלאש - צבע הפלאש",
		
			top_slice => "סלייס עליון",
			top_slice_flash_height => "סלייס עליון - גובה הפלאש",
			top_slice_flash_color => "סלייס עליון - צבע הפלאש",
			
			img_all_site_bg => "תמונת רקע כללי לאתר",
			img_g_site_bg_repeat => "תמונת רקע כללי לאתר משתכפל?",
			img_all_site_bg_indexHtml => "תמונת רקע כללי לעמוד פתיח",
			img_bg_links => "רקע כפתורים",
			color_link_over => "צבע קישור של כפתור",
			img_bg_txt_area => "תמונת רקע לטקסט",
			img_bg_txt_area_hp => "תמונת רקע לטקסט - עמוד בית",
			
			img_bg_txt_area_bottom => "תמונת רקע לטקסט סלייס תחתון",
			img_bg_txt_area_bottom_height => "רקע סלייס תחתון - גובה הפלאש",
			img_bg_txt_area_bottom_width => "רקע סלייס תחתון - רוחב הפלאש",
			img_bg_txt_area_bottom_color => "רקע סלייס תחתון - צבע הפלאש",
			
			
			flash_right_menu => "תפריט ימני פלאש",
			
			color_e_comes_menu_right => "תפריט ימני - צבע החנות",
			flash_right_menu_height => "תפריט ימני - גובה הפלאש",
			flash_right_menu_width => "תפריט ימני - רוחב הפלאש",
			flash_right_menu_color => "תפריט ימני - צבע הפלאש",
			
			
			
			right_menu_beckground => "תפריט ימני - תמונת רקע",
			
			
			set_name => "שם האתר",
			show_name_in_title => "הצג שם בכותרת",
			home_portal_version => "גירסת מיניפורטל בעמוד הבית",
			home_portal_free_pages => "הצג דפים חופשיים במקום כתבות במיניפורטל",
			top_menu_version => "גירסת תפריט עליון",
			top_bg_link => "צבע רקע תפריט עליון",
			top_link_color => "צבע כפתור תפריט עליון",
			top_link_hover_color => "צבע כפתור תפריט עליון במעבר עכבר",
			bg_link => "צבע רקע כפתורים",
			color_link => "צבע כתב של כפתור",
			site_text_color => "צבע טקסט כללי לאתר",
			site_bg_color => "צבע רקע אתר",
			conent_bg_color => "צבע רקע תוכן האתר",
			headline_color => "צבע כותרות וצבע טקסט בתחתית האתר",
			headlineTextarea => "צבע כותרת פנימית של דף (לא חייב - ברירת מחדל שדה אחד למעלה)",
			menus_color => "צבע רקע של התפריטים",
			border_color_active => "מסגרת חיצונית לאתר",
			border_color => "צבע מסגרות באתר",
			
			galley_back_color => "צבע רקע של תמונות בגלריה",
			
			product_bg_top => "מוצרים - חלק עליון (לא משתכפל) רוחב: 156PX גובה: 46PX",
			product_bg_mid => "מוצרים - חלק אמצעי (משתכפל)",
			product_bg_bottom => "מוצרים - חלק תחתון (לא משתכפל) רוחב: 156PX גובה: 46PX",
			
			products_top_banner => "דף מוצרים: באנר מעל המוצרים",
			
			top_silce_print => "דף להדפסה - סלייס עליון (שחור לבן להדפסה)",
			
			
			kobia_headline => "הגדרות קובייה",
			kobia_type => "קוביה - סוג עיצוב",
			kobia_top => "קוביה - חלק עליון מעל כותרת",
			kobia_top_height => "קוביה - חלק עליון מעל כותרת גובה",
			kobia_top_back => "קוביה - חלק עליון משתכפל כותרת",
			kobia_back => "קוביה - משתכפל לכל הקוביה",
			kobia_bottom_back => "קוביה - חלק תחתון משתכפל",
			kobia_bottom => "קוביה - חלק תחתון מתחת למידע נוסף",
			kobia_bottom_height => "קוביה - חלק תחתון מתחת למידע נוסף גובה",
			kobiaColorTitle => "קוביה - צבע טקסט - כותרת",
			kobiaColorMid => "קוביה - צבע טקסט - טקסט באמצע",
			kobiaColorMore => "קוביה - צבע טקסט - מידע נוסף",
			
			calendar_borderColor => "לוח שנה - צבע של המסגרות",
			stylesheet => "הגדרות צבעים - לוח שנה",
			
			
			topSliceHtml => "סלייס עליון HTML",
			BottomSliceHtml => "סלייס תחתון HTML",
			BottomSliceHtml_landing => " סלייס תחתון HTML בעמודי נחיתה",
			RightSliceHtml => "תפריט ימני הכי למעלה HTML",
			
			
			head_free_code => "Head tag code - ליודעי דבר בלבד!",
			
			head_free_html => "Head tag html - ליודעי דבר בלבד!",
			head_free_css => "Head tag css - ליודעי דבר בלבד!",
			scrollNewsTop => "חלון מבזקים מעוצב - חלק עליון",
			scrollNewsDupli => "חלון מבזקים מעוצב - חלק משתכפל",
			scrollNewsBottom => "חלון מבזקים מעוצב - חלק תחתון",
			scrollNewsHeadlineColor => "חלון מבזקים מעוצב - צבע הכותרת",
			
			cartHeadlineImg => "כותרת עגלת קניות מעוצבת",
			cartKopaImg => "כפתור לקופה מעוצב",
			cartAddImg => "כפתור הוסף לסל מעוצב",
			cartLinsColor => "צבע קו הפרדה בין מוצרים בסל קניות",
			
			jobTopImg => "דרושים מעוצב - חלק עליון",
			jobMiddleImg => "דרושים מעוצב - חלק משתכפל",
			jobBottomImg => "דרושים מעוצב - חלק תחתון",
			jobHeadlineColor => "דרושים מעוצב - צבע הכותרת",
			jobTextColor => "דרושים מעוצב - צבע הטקסט",
			
			netLoignTop => "התחברות למועדון - חלק עליון",
			netLoginMiddle => "התחברות למועדון - חלק משתכפל",
			newLoginBottom => "התחברות למועדון - חלק תחתון",
			netLoginFontColor => "התחברות למועדון - צבע הטקסט",
			netLoginConnect => "התחברות למועדון - כפתור \"התחבר\"",
			//netLoginNewUser => "התחברות למועדון - כפתור \"הירשם עכשיו\"",
			netJoinReasonImg => "התחברות למועדון - תמונה שיכנוע להצטרפות",
			netJoinReasonUrl => "התחברות למועדון - URL לשיכנוע להצטרפות\"",
			news_version => "גירסת מודול חדשות",
			products_version => "גירסת מודול מוצרים",
			negishut_version => "גירסת תפריט נגישות",
			fb_page => "עמוד פייסבוק",
			fb_title => "כותרת לעמוד פייסבוק",
			whatsapp_number => "מספר ווטסאפ",
			whatsapp_text => "טקסט ווטסאפ",
			
		);
//	}
	
	echo "<form action=\"index.php\" name=\"site_settings_form\" method=\"post\" enctype=\"multipart/form-data\">";
	echo "<input type=\"hidden\" name=\"main\" value=\"update_DB_color_set\">";
	echo "<input type=\"hidden\" name=\"record_id\" value=\"".$data['id']."\">";
	echo "<input type=\"hidden\" name=\"user_extra_id\" value=\"".$user_extra_settings['id']."\">";
	echo "<input type=\"hidden\" name=\"sesid\" value=\"".SESID."\">";
	echo "<input type=\"hidden\" name=\"unk\" value=\"".$_GET['unk']."\">";
	echo "<table border=\"0\" cellspacing=\"0\" cellpadding=\"0\" class=\"maintext\">";
		
		echo "<tr>";
			echo "<td colspan=3><A href=\"?&sesid=".SESID."\" class=\"maintext\">חזרה לתפריט הראשי</a></td>";
		echo "</tr>";
		
		if( AUTH >= 9 )
		{
			echo "<tr><td colspan=3 height=\"7\"></td></tr>";
			echo "<tr>";
				echo "<td colspan=3><A href=\"?main=user_advanced_settings&unk=".$_REQUEST['unk']."&record_id=".$data['id']."&sesid=".SESID."\" class=\"maintext\">הגדרות מתקדמות</a></td>";
			echo "</tr>";
		}
		echo "<tr><td height=\"11\"></td></tr>";
		// foreach for create the form
		foreach( $form_arr as $val => $key )	{
			echo "<tr>";
				echo "<td>".$key."</td>";
				echo "<td width=\"10\"></td>";
				echo "<td>";
					switch($val)	{
						case "faviconOn" :
							$abpath_temp = "";
							$details_img = "";
							$abpath_temp = SERVER_PATH."/favicon.ico";
							if( file_exists($abpath_temp) && !is_dir($abpath_temp) )
								$details_img = "&nbsp;&nbsp;<a href=\"".HTTP_PATH."/favicon.ico\" class=\"maintext_small\" target=\"_blank\">צפה</a>
								&nbsp;&nbsp;|&nbsp;&nbsp;<a href=\"index.php?main=del_img_DB_FTP&table=000&field_name=favicon&sesid=".$_GET['sesid']."&unk=".$_GET['unk']."&GOTO_type=&GOTO_main=users_list&img=".$data[$val]."&sesid=".SESID."\" class=\"maintext_small\" onclick=\"return can_i_del()\">מחק </a>";
							
							echo "<input type='file' name='".$val."' value='' class=\"input_style\">".$details_img."&nbsp;&nbsp;&nbsp;&nbsp;|&nbsp;&nbsp;&nbsp;&nbsp;ליצירת אייקון יש לעשותו באתר <a href='http://www.favicon.cc' class='maintext' target='_blank'>www.favicon.cc</a> בלבד!!";
						break;
												
						case "top_slice" :
						case "img_all_site_bg" :
						case "img_all_site_bg_indexHtml" :
						case "img_bg_links" :
						case "img_bg_txt_area" :
						case "img_bg_txt_area_hp" :
						case "img_bg_txt_area_bottom" :
						case "flash_right_menu" :
						case "right_menu_beckground" :
						case "open_flash" :
						case "product_bg_top" :
						case "product_bg_mid" :
						case "product_bg_bottom" :
						case "top_silce_print" :
						case "kobia_top" :
						case "kobia_top_back" :
						case "kobia_back" :
						case "kobia_bottom_back" :
						case "kobia_bottom" :
						
							$abpath_temp = "";
							$details_img = "";
							$abpath_temp = SERVER_PATH."/tamplate/".$data[$val];
							if( file_exists($abpath_temp) && !is_dir($abpath_temp) )
								$details_img = "&nbsp;&nbsp;<a href=\"".HTTP_PATH."/tamplate/".$data[$val]."\" class=\"maintext_small\" target=\"_blank\">צפה</a>
								&nbsp;&nbsp;|&nbsp;&nbsp;<a href=\"index.php?main=del_img_DB_FTP&table=user_colors_set&field_name=".$val."&sesid=".$_GET['sesid']."&unk=".$_GET['unk']."&GOTO_type=&GOTO_main=users_list&img=".$data[$val]."&sesid=".SESID."\" class=\"maintext_small\" onclick=\"return can_i_del()\">מחק </a>";
							
							echo "<input type='file' name='".$val."' value='' class=\"input_style\">".$details_img;
						break;						
						case "scrollNewsTop" :
						case "scrollNewsDupli" :
						case "scrollNewsBottom" :
						case "cartHeadlineImg" :
						case "cartKopaImg" :
						case "cartAddImg" :
						case "jobTopImg" :
						case "jobMiddleImg" :
						case "jobBottomImg" :
						 
						case "netLoignTop" :
						case "netLoginMiddle" :
						case "newLoginBottom" :
						case "netLoginConnect" :
						case "netLoginNewUser" :
						case "netJoinReasonImg" :
						case "products_top_banner" :
							$abpath_temp = "";
							$details_img = "";
							$abpath_temp = SERVER_PATH."/tamplate/".$user_extra_settings[$val];
							if( file_exists($abpath_temp) && !is_dir($abpath_temp) )
								$details_img = "&nbsp;&nbsp;<a href=\"".HTTP_PATH."/tamplate/".$user_extra_settings[$val]."\" class=\"maintext_small\" target=\"_blank\">צפה</a>
								&nbsp;&nbsp;|&nbsp;&nbsp;<a href=\"index.php?main=del_img_DB_FTP&table=user_extra_settings&field_name=".$val."&sesid=".$_GET['sesid']."&unk=".$_GET['unk']."&GOTO_type=&GOTO_main=users_list&img=".$user_extra_settings[$val]."&sesid=".SESID."\" class=\"maintext_small\" onclick=\"return can_i_del()\">מחק </a>";
							
							echo "<input type='file' name='".$val."' value='' class=\"input_style\">".$details_img;
						break;
						
						case "scrollNewsHeadlineColor" :
						case "cartLinsColor" :
						case "jobHeadlineColor" :
						case "jobTextColor" :
						case "netLoginFontColor" :
						case "kobiaColorTitle" :
						case "kobiaColorMid" :
						case "kobiaColorMore" :
						case "headlineTextarea" :
							echo "<input type=\"text\" name=\"".$val."\" value=\"".$user_extra_settings[$val]."\" style=\"background-color: #".stripslashes($user_extra_settings[$val]).";\" class=\"input_style\" maxlength=\"6\">&nbsp;&nbsp;<a href=\"javascript:void(0)\" onclick='javascript:colors(\"".$val."\",\"".$val."\")' class=\"maintext\">בחירת צבע</a>";
						break;
						
						case "netJoinReasonUrl" :
						case "news_version" :
						case "products_version" :
						case "negishut_version" :
						case "fb_title" :
						case "whatsapp_number" : 
						case "whatsapp_text" : 
							echo "<input type=\"text\" name=\"".$val."\" value=\"".$user_extra_settings[$val]."\" class=\"input_style\" maxlength=\"80\">";
						break;
						case "fb_page" :
							echo "<input type=\"text\" name=\"".$val."\" value=\"".$user_extra_settings[$val]."\" class=\"input_style\">";
						break;
						case "topSliceHtml" :
						case "BottomSliceHtml" :
						case "BottomSliceHtml_landing" :
						case "RightSliceHtml" :
							echo "<a href='index.php?main=updateCastumHtml&field=".$val."&table=user_extra_settings&rowID=".$user_extra_settings['id']."&sesid=".SESID."&unk=".$_GET['unk']."' class='maintext' target='_blank'>קישור לעדכון ".$key."</a>";
						break;
						
						
						
						case "top_slice_flash_height" :
						case "flash_right_menu_height" :
						case "set_name" :
						case "top_menu_version" :
						case "home_portal_version" :
						case "open_flash_height" :
						case "open_flash_width" :
						case "kobia_top_height" :
						case "kobia_bottom_height" :
							echo "<input type='text' name='".$val."' value='".GlobalFunctions::remove_geresh(stripslashes($data[$val]))."' class=\"input_style\">";
						break;
						
						case "flash_right_menu_width" :
							echo "<input type='text' name='".$val."' value='".GlobalFunctions::remove_geresh(stripslashes($data[$val]))."' class=\"input_style\"> רוחב מקסימלי: 150 פקסיל";
						break;
						
						case "stylesheet" :
							$stylesheet_calendar = ($data[$val] != "") ? GlobalFunctions::remove_geresh(stripslashes($data[$val])) : "
.calendar_bg{
	background-color:#ffffff; /*צבע רקע כללי ללוח שנה*/
	border: 0px solid #000000; /*צבע מסגרת border: גודלpx solid צבע*/
	color:000000; /* צבע הכתב בתוך המסגרת */
}

.calendar_month_bg{
	background-color:#ffffff; /*צבע רקע כללי ללוח שנה*/
	color:000000; /* צבע הכתב בתוך המסגרת */
}

.calendar_week_days{
	background-color:#E6E6E6; /*צבע רקע לתא של הימים לא כולל יום שבת*/
	color:000000; /* צבע הכתב לתא של הימים לא כולל יום שבת */
}

.calendar_week_days_shabat{
	background-color:#C8C8C8; /*צבע רקע לתא של הימים רק יום שבת*/
	color:000000; /* צבע הכתב לתא של הימים רק יום שבת */
}

.calendar_month_days_regular{
	background-color:#ffffff; /*צבע רקע לתא של המספרים של החודש לא כולל לא כולל יום של היום*/
	color:000000; /* צבע הכתב לתא של המספרים של החודש לא כולל יום של היום */
}
.calendar_month_days_regular_today{
	background-color:#ffffff; /*	צבע רקע לתא של המספרים של החודש של היום/הנבחר	*/
	color:000000; /* צבע הכתב לתא של המספרים של החודש של היום/הנבחר */
	text-decoration: underline; /* אם יהיה קו תחתון none-לא, underline-כן*/
}

.calendar_month_days_regular_event{
	background-color:#707070; /*צבע רקע לתא של המספרים של החודש לא כולל לא כולל יום של היום*/
	color:ffffff; /* צבע הכתב לתא של המספרים של החודש לא כולל יום של היום */
	text-decoration: none;
}
.calendar_month_days_regular_event a:link{background-color:#707070;color:ffffff;text-decoration: none;}
.calendar_month_days_regular_event a:hover{background-color:#707070;color:ffffff;text-decoration: none;}
.calendar_month_days_regular_event a:active{background-color:#707070;color:ffffff;text-decoration: none;}
.calendar_month_days_regular_event a:visited{background-color:#707070;color:ffffff;text-decoration: none;}

.calendar_month_days_regular_today_event {
	background-color:#707070; /*	צבע רקע לתא של המספרים של החודש של היום/הנבחר	*/
	color:ffffff; /* צבע הכתב לתא של המספרים של החודש של היום/הנבחר */
	text-decoration: underline; /* אם יהיה קו תחתון none-לא, underline-כן*/
}
.calendar_month_days_regular_today_event a:link{background-color:#707070;color:ffffff;text-decoration: underline;}
.calendar_month_days_regular_today_event a:hover{background-color:#707070;color:ffffff;text-decoration: underline;}
.calendar_month_days_regular_today_event a:active{background-color:#707070;color:ffffff;text-decoration: underline;}
.calendar_month_days_regular_today_event a:visited{background-color:#707070;color:ffffff;text-decoration: underline;}
";
							
							echo "<textarea name='".$val."' cols='' rows='' class=\"input_style\" style='height: 250px; width:600px;' dir=ltr>".$stylesheet_calendar."</textarea><br><a href='index.php?main=view_calender_style_defualt&sesid=".SESID."' target='_blank' class='maintext'>לצפיה לגרסת הברירת מחדל</a>";
						break;
						
						case "head_free_code" :
						case "head_free_html" :
						case "head_free_css" :
							echo "<textarea name='".$val."' cols='' rows='' class=\"input_style\" style='height: 250px; width:600px;' dir=ltr>".stripslashes($user_extra_settings[$val])."</textarea><br><br>";
						break;
						
						case "kobia_type" :
							$selected0 = ( $data[$val] == 0 ) ? "selected" : "";
							$selected1 = ( $data[$val] == 1 ) ? "selected" : "";
							echo "<select name=\"".$val."\" class=\"input_style\">
								<option value=\"0\" ".$selected0.">רגיל</option>
								<option value=\"1\" ".$selected1.">מעוצב</option>
							</select>";
						break;
						
						case "kobia_headline" :		break;
						
						case "border_color_active" :
							$selected0 = ( $data['border_color_active'] == 0 ) ? "selected" : "";
							$selected1 = ( $data['border_color_active'] == 1 ) ? "selected" : "";
							echo "<select name=\"".$val."\" class=\"input_style\">
								<option value=\"0\" ".$selected0.">פעיל</option>
								<option value=\"1\" ".$selected1.">לא פעיל</option>
							</select>";
						break;
						case "show_name_in_title" :
						case "home_portal_free_pages" :
							$selected0 = ( $data[$val] == 0 ) ? "selected" : "";
							$selected1 = ( $data[$val] == 1 ) ? "selected" : "";
							echo "<select name=\"".$val."\" class=\"input_style\">
								<option value=\"0\" ".$selected0.">לא</option>
								<option value=\"1\" ".$selected1.">כן</option>
							</select>";
						break;						
						case "kobia_type" :
							$selected0 = ( $data['img_g_site_bg_repeat'] == 0 ) ? "selected" : "";
							$selected1 = ( $data['img_g_site_bg_repeat'] == 1 ) ? "selected" : "";
							$selected2 = ( $data['img_g_site_bg_repeat'] == 2 ) ? "selected" : "";
							$selected3 = ( $data['img_g_site_bg_repeat'] == 3 ) ? "selected" : "";
							$selected4 = ( $data['img_g_site_bg_repeat'] == 4 ) ? "selected" : "";
							echo "<select name=\"".$val."\" class=\"input_style\">
								<option value=\"0\" ".$selected0.">כן</option>
								<option value=\"1\" ".$selected1.">לא</option>
								<option value=\"2\" ".$selected2.">משתכפל לרוחב</option>
								<option value=\"3\" ".$selected3.">משתכפל לגובה</option>
								<option value=\"4\" ".$selected4.">לא משתכפל, לא נגלל - נשאר קבוע ברקע</option>
							</select>";
						break;
						
						default :
							echo "<input type=\"text\" name=\"".$val."\" value=\"".$data[$val]."\" style=\"background-color: #".stripslashes($data[$val]).";\" class=\"input_style\" maxlength=\"6\">&nbsp;&nbsp;<a href=\"javascript:void(0)\" onclick='javascript:colors(\"".$val."\",\"".$val."\")' class=\"maintext\">בחירת צבע</a>";
					}
				echo "</td>";
			echo "</tr>";
			
			switch($val)	{
				case "flash_right_menu_color" :
					echo "<tr><td colspan=\"3\" height=\"5\"></td></tr><tr><td colspan=\"3\" align=center><b></u>או</u></b></td></tr><tr><td colspan=\"3\" height=\"5\"></td></tr>";
				break;
				
				case "img_bg_txt_area_bottom_color" :
				case "top_slice_flash_color" :
				case "right_menu_beckground" :
				case "menus_color" :
				case "open_flash_color" :
				case "border_color" :
				case "product_bg_bottom" :
				case "galley_back_color" :
				case "kobiaColorMore" :
				case "stylesheet" :
				case "RightSliceHtml" :
				case "scrollNewsHeadlineColor" :
				case "cartLinsColor" :
				case "jobTextColor" :
				case "faviconOn" :
					echo "<tr><td colspan=\"3\" height=\"40\"></td></tr>";
				break;
				
				case "kobia_headline" :
					echo "<tr><td colspan=\"3\" height=\"40\"></td></tr>";
					echo "<tr><td colspan=\"3\"><h2>".$key."</h2></td></tr>";
					echo "<tr><td colspan=\"3\" height=\"20\"></td></tr>";
				break;
				
				default:
					echo "<tr><td colspan=\"3\" height=\"6\"></td></tr>";
			}
		}
		
		echo "<tr>";
			echo "<td>&nbsp;</td>";
			echo "<td width=\"\"></td>";
			echo "<td><input type=\"Submit\" value=\"שמירת נתונים\" class=\"submit_style\"></td>";
		echo "</tr>";
		
	echo "</table>";
	echo "</form>";
}
/********************************************************************************************************/

function update_DB_color_set()	{

	$form_arr2 = array(
		set_name => "set_name", 
		show_name_in_title => "show_name_in_title",
		open_flash_color => "open_flash_color", 
		open_flash_height => "open_flash_height", 
		open_flash_width => "open_flash_width", 
		
		top_slice_flash_height => "top_slice_flash_height", 
		top_slice_flash_color => "top_slice_flash_color", 
		
		img_g_site_bg_repeat => "img_g_site_bg_repeat",
		home_portal_version => "home_portal_version",
		home_portal_free_pages => "home_portal_free_pages",			
		top_menu_version => "top_menu_version",
		top_bg_link => "top_bg_link",
		top_link_color => "top_link_color",
		top_link_hover_color => "top_link_hover_color",
		bg_link => "bg_link",
		color_link => "color_link",
		color_link_over => "color_link_over",
		
		flash_right_menu_height => "flash_right_menu_height",
		flash_right_menu_width => "flash_right_menu_width",
		flash_right_menu_color => "flash_right_menu_color",
		
		img_bg_txt_area_bottom_height => "img_bg_txt_area_bottom_height",
		img_bg_txt_area_bottom_width => "img_bg_txt_area_bottom_width",
		img_bg_txt_area_bottom_color => "img_bg_txt_area_bottom_color",
		color_e_comes_menu_right => "color_e_comes_menu_right",
		
		
		galley_back_color => "galley_back_color",
		
		calendar_borderColor => "calendar_borderColor",
		stylesheet => "stylesheet",
			
		site_text_color => "site_text_color",
		site_bg_color => "site_bg_color",
		conent_bg_color => "conent_bg_color",
		headline_color => "headline_color",
		menus_color => "menus_color",
		border_color_active => "border_color_active",
		border_color => "border_color",
		unk => "unk",
		
		kobia_type => "kobia_type",
		kobia_top_height => "kobia_top_height",
		kobia_bottom_height => "kobia_bottom_height",
		
	);
	
	$counter1 = 1;
	$counter2 = 1;
	if( $_REQUEST['record_id'] == "" )	{
		$sql = "insert into user_colors_set (";
		foreach( $form_arr2 as $val => $key )	{
			$with_psik = ( $counter1 == sizeof($form_arr2) ) ? " " : ", ";
			$sql .= $key.$with_psik;
			$counter1++;
		}
		$sql .= ") values (";
		foreach( $form_arr2 as $val => $key )	{
			$with_psik = ( $counter2 == sizeof($form_arr2) ) ? " " : ", ";
			$sql .= "'".GlobalFunctions::add_geresh(addslashes($_REQUEST[$val]))."'".$with_psik;
			
			$counter2++;
		}
		$sql .= ")";
		$res = mysql_db_query(DB,$sql);
		
		$row_id = mysql_insert_id();
		
		if( $_POST['unk'] != "" )
		{
			$sql23 = "update user_site_settings set set_colors = '{$row_id}' where unk = '{$_POST['unk']}' limit 1";
			$res23 = mysql_db_query(DB,$sql23);
		}
	}
	else	{
		$sql = "update user_colors_set set ";
		foreach( $form_arr2 as $val => $key )	{
			$with_psik = ( $counter1 == sizeof($form_arr2) ) ? " " : ", ";
			$sql .= $val." = '".GlobalFunctions::add_geresh(addslashes($_REQUEST[$key]))."'".$with_psik;
			
			$counter1++;
		}
		$sql .= "where unk = '".$_REQUEST['unk']."' and deleted = '0' limit 1";
		$res = mysql_db_query(DB,$sql);
		
		$row_id = $_REQUEST['record_id'];
	}
	
	
	$form_arr_user_extra_settings = array(
		scrollNewsHeadlineColor => "scrollNewsHeadlineColor", 
		cartLinsColor => "cartLinsColor", 
		jobHeadlineColor => "jobHeadlineColor", 
		jobTextColor => "jobTextColor", 
		netLoginFontColor => "netLoginFontColor", 
		netJoinReasonUrl => "netJoinReasonUrl", 
		news_version => "news_version",
		products_version => "products_version",
		negishut_version => "negishut_version",
		fb_page => "fb_page",
		fb_title => "fb_title",
		whatsapp_number => "whatsapp_number",
		whatsapp_text => "whatsapp_text",
		kobiaColorTitle => "kobiaColorTitle", 
		kobiaColorMid => "kobiaColorMid", 
		kobiaColorMore => "kobiaColorMore", 
		headlineTextarea => "headlineTextarea", 
		head_free_code => "head_free_code", 
		head_free_html => "head_free_html", 
		head_free_css => "head_free_css", 
	);
	
	
	$counter1 = 1;
	$counter2 = 1;
	if( $_REQUEST['user_extra_id'] == "" )	{
		
		
		$sql = "insert into user_extra_settings (";
		foreach( $form_arr_user_extra_settings as $val => $key )	{
			$with_psik = ( $counter1 == sizeof($form_arr_user_extra_settings) ) ? " , unk  " : ", ";
			$sql .= $key.$with_psik;
			$counter1++;
		}
		$sql .= ") values (";
		foreach( $form_arr_user_extra_settings as $val => $key )	{
			$with_psik = ( $counter2 == sizeof($form_arr_user_extra_settings) ) ? " , '".$_POST['unk']."' " : ", ";
			$sql .= "'".GlobalFunctions::add_geresh(addslashes($_REQUEST[$val]))."'".$with_psik;
			$counter2++;
		}
		$sql .= ")";
		$res = mysql_db_query(DB,$sql);
		
		$user_extra_id = mysql_insert_id();
	}
	else	{
		$sql = "update user_extra_settings set ";
		foreach( $form_arr_user_extra_settings as $val => $key )	{
			$with_psik = ( $counter1 == sizeof($form_arr_user_extra_settings) ) ? " " : ", ";
			$sql .= $val." = '".GlobalFunctions::add_geresh(addslashes($_REQUEST[$key]))."'".$with_psik;
			$counter1++;
		}
		$sql .= "where unk = '".$_REQUEST['unk']."' limit 1";
		$res = mysql_db_query(DB,$sql);
		
		$user_extra_id = $_POST['user_extra_id'];
	}
	
 	
			if( $_POST['unk'] != "" )
			{
				$field_name = array("top_slice","img_all_site_bg","img_all_site_bg_indexHtml","img_bg_links","img_bg_txt_area","img_bg_txt_area_hp","img_bg_txt_area_bottom","flash_right_menu","right_menu_beckground","open_flash","product_bg_top","product_bg_mid","product_bg_bottom","top_silce_print","kobia_top","kobia_top_back","kobia_back","kobia_bottom_back","kobia_bottom","faviconOn");
			
				//check if files being uploaded
				if($_FILES)
				{
					for($temp=0 ; $temp<sizeof($field_name) ; $temp++)
					{
						$temp_name = $field_name[$temp];
							
						if ( $_FILES[$temp_name]['name'] != "" )
						{
										$exte = substr($_FILES[$temp_name]['name'],(strpos($_FILES[$temp_name]['name'],".")+1));
											
										switch($temp_name)
										{
											case "top_slice" :									$file_temp_name__1 = "slice";									break;
											
											case "img_all_site_bg" :						$file_temp_name__1 = "bg";										break;
											case "img_all_site_bg_indexHtml" :	$file_temp_name__1 = "bgIndexHtml";						break;
											case "img_bg_links" :								$file_temp_name__1 = "menu";									break;
											case "img_bg_txt_area" :						$file_temp_name__1 = "txtarea";								break;
											case "img_bg_txt_area_hp" :					$file_temp_name__1 = "txtareaHP";							break;
											case "img_bg_txt_area_bottom" :			$file_temp_name__1 = "txtarea-S-BOT";					break;
											case "flash_right_menu" :						$file_temp_name__1 = "flash_menu";						break;
											case "right_menu_beckground" :			$file_temp_name__1 = "R-M_beck";							break;
											case "open_flash" :									$file_temp_name__1 = "OP_flash";							break;
											case "product_bg_top" :							$file_temp_name__1 = "pro-top";								break;
											case "product_bg_mid" :							$file_temp_name__1 = "pro-mid";								break;
											case "product_bg_bottom" :					$file_temp_name__1 = "pro-bottom";						break;
											case "top_silce_print" :						$file_temp_name__1 = "print-slice";						break;
											
											case "kobia_top" :									$file_temp_name__1 = "kob-to";								break;
											case "kobia_top_back" :							$file_temp_name__1 = "kob-to-bg";							break;
											case "kobia_back" :									$file_temp_name__1 = "kob-bg";								break;
											case "kobia_bottom_back" :					$file_temp_name__1 = "kob-bo-bg";							break;
											case "kobia_bottom" :								$file_temp_name__1 = "kob-bo";								break;
											case "faviconOn" :									$file_temp_name__1 = "";											break;
											
										}
										
										if( $temp_name == "faviconOn" )
											$logo_name2 = "favicon.ico";
										else
											$logo_name2 = $_POST['unk']."-".$file_temp_name__1.".".$exte;
										$tempname = $logo_name;
										
										//@copy($_FILES[$temp_name]['tmp_name'], SERVER_PATH."/tamplate/$logo_name2");
										if( $temp_name == "faviconOn" )
											GlobalFunctions::upload_file_to_server($temp_name , $logo_name2 , SERVER_PATH."" );
										else
											GlobalFunctions::upload_file_to_server($temp_name , $logo_name2 , SERVER_PATH."/tamplate" );
										
										if( $temp_name != "faviconOn" )
										{
											$sql = "UPDATE user_colors_set SET ".$temp_name." = '".$logo_name2."' WHERE id = '".$row_id."' limit 1";
											$res = mysql_db_query(DB,$sql);
										}
										
										if( $temp_name == "top_slice" )
										{
											$sql = "UPDATE user_site_settings SET set_colors = '".$row_id."' WHERE unk = '".$_POST['unk']."' limit 1";
											$res = mysql_db_query(DB,$sql);
										}
						}
					}
				}
			}			
			
			if( $_POST['unk'] != "" )
			{
				$field_name = array("netJoinReasonImg", "netLoignTop","netLoginMiddle","newLoginBottom","netLoginConnect","netLoginNewUser", "jobTopImg","jobMiddleImg","jobBottomImg","scrollNewsTop","scrollNewsDupli","scrollNewsBottom","cartHeadlineImg","cartKopaImg","cartAddImg","products_top_banner");
				
				//check if files being uploaded
				if($_FILES)
				{
					for($temp=0 ; $temp<sizeof($field_name) ; $temp++)
					{
						$temp_name = $field_name[$temp];
						
						if ( $_FILES[$temp_name]['name'] != "" )
						{
										$exte = substr($_FILES[$temp_name]['name'],(strpos($_FILES[$temp_name]['name'],".")+1));
										switch($temp_name)
										{
											case "scrollNewsTop" :							$file_temp_name__1 = "scNeT";										break;
											case "scrollNewsDupli" :						$file_temp_name__1 = "scNeD";										break;
											case "scrollNewsBottom" :						$file_temp_name__1 = "scNeB";										break;
											case "cartHeadlineImg" :						$file_temp_name__1 = "cartT";										break;
											case "cartKopaImg" :								$file_temp_name__1 = "cartKopa";								break;
											case "cartAddImg" :									$file_temp_name__1 = "cartAdd";									break;
											
											case "jobTopImg" :									$file_temp_name__1 = "jobTop";									break;
											case "jobMiddleImg" :								$file_temp_name__1 = "jobMid";									break;
											case "jobBottomImg" :								$file_temp_name__1 = "jobBot";									break;
											
											case "netLoignTop" :								$file_temp_name__1 = "NtLnt";										break;
											case "netLoginMiddle" :							$file_temp_name__1 = "NtLnm";										break;
											case "newLoginBottom" :							$file_temp_name__1 = "NtLnb";										break;
											case "netLoginConnect" :						$file_temp_name__1 = "NtLnc";										break;
											case "netLoginNewUser" :						$file_temp_name__1 = "NtLnnu";									break;
											case "netJoinReasonImg" :						$file_temp_name__1 = "NtJri";										break;
											case "products_top_banner" :				$file_temp_name__1 = "pr-t-banner";							break;
										}
										$logo_name2 = $_POST['unk']."-".$file_temp_name__1.".".$exte;
										$tempname = $logo_name;
										
										GlobalFunctions::upload_file_to_server($temp_name , $logo_name2 , SERVER_PATH."/tamplate" );
										
										$sql = "UPDATE user_extra_settings SET ".$temp_name." = '".$logo_name2."' WHERE id = '".$user_extra_id."' limit 1";
										$res = mysql_db_query(DB,$sql);
						}
					}
				}
			}			
			
	//create_open_flash_index($_POST['unk']);
	
	if( $_POST['unk'] == "" )
		echo "<script>window.location.href='?main=users_list&sesid=".SESID."'</script>";
	else
		echo "<script>window.location.href='?main=update_set_colors&unk=".$_REQUEST['unk']."&record_id=".$_REQUEST['record_id']."&sesid=".SESID."'</script>";
	
		exit;
		
}
/********************************************************************************************************/

function create_open_flash_index($c_unk)
{
	echo "-----";
	exit();
	$sql = "select open_flash,open_flash_height,open_flash_width,open_flash_color,img_all_site_bg_indexHtml from user_colors_set where unk = '".$c_unk."' limit 1";
	$res = mysql_db_query(DB,$sql);
	$data = mysql_fetch_array($res);
	
	$sql2 = "select site_title,keywords,description from user_site_settings where unk = '".$c_unk."' and deleted = '0' and status = '0' limit 1";
	$res2 = mysql_db_query(DB,$sql2);
	$data_settings = mysql_fetch_array($res2);
	
	$img_g_site_bg = "";
	$abpath_temp_bll_all_site = SERVER_PATH."/tamplate/".stripslashes($data['img_all_site_bg_indexHtml']);
	if( file_exists($abpath_temp_bll_all_site) && !is_dir($abpath_temp_bll_all_site) )
	{
		if( UNK == "570999819807328184" )
			$img_g_site_bg = "style=\"background: url(http://www.en.agam.co.il/tamplate/".stripslashes($data['img_all_site_bg_indexHtml']).") scroll center; background-position: top;\" ";
		else
			$img_g_site_bg = "style=\"background: url(".HTTP_PATH."/tamplate/".stripslashes($data['img_all_site_bg_indexHtml']).") scroll center; background-position: top;\" ";
	}
	
	switch($c_unk)
	{
		case "668519061196517398" :	$font_color_bottom="000000" ;	break;
		case "993753893602583048" :	$font_color_bottom="ffffff" ;	break;
		case "585629860654632039" :	$font_color_bottom="000000" ;	break;
		case "853383994120677073" :	$font_color_bottom="000000" ;	break;
		case "318459089654374032" :	$font_color_bottom="000000" ;	break;
		case "731234420128026341" :	$font_color_bottom="ffffff" ;	break;
		case "306072409234976182" :	$font_color_bottom="ffffff" ;	break;
	}
	
	
	
	$path_check = SERVER_PATH."/tamplate/".$data['open_flash'];
	if( file_exists($path_check) && !is_dir($path_check) )
	{
		$build_html;
		
		$temp_unk_to_ella = ( $data['open_flash_color'] == "" ) ? "so.addParam(\"wmode\", \"transparent\");" : "//so.addParam(\"wmode\", \"transparent\");";
		
		$build_html .= "<html>";
		$build_html .= "<head>";
			$build_html .= "<meta http-equiv=\"Content-Type\" content=\"text/html; charset=windows-1255\" />";
			
			if( $c_unk == "381849985170595403")
				$build_html .= "<title>רשת גלידות סורנטו</title>";
			else
				$build_html .= "<title>".stripslashes($data_settings['site_title'])."</title>";
				
			
			$description = str_replace("\"" , "" , stripslashes($data_settings['description']) );
			$keywords = str_replace("\"" , "" , stripslashes($data_settings['keywords']) );
			
			
			if( $description != "" )
				$build_html .=  '<META NAME="DESCRIPTION" CONTENT="'.$description.'">';
			if( $keywords != "" )
				$build_html .=  '<META NAME="KEYWORDS" CONTENT="'.$keywords.'">';
			
			$build_html .= "<script type=\"text/javascript\" src=\"http://ilbiz.co.il/ClientSite/other/flash/swfobject.js\"></script><script type=\"text/javascript\" src=\"http://ilbiz.co.il/ClientSite/other/flash/FABridge.js\"></script>";
			$build_html .= "<script>";
		
				$build_html .= "function loadSWF(swf,name,width,height,bgColor,parentName)
				{
					var so = new SWFObject(swf, name, width, height, \"9\",bgColor);
					".$temp_unk_to_ella."
					//so.useExpressInstall('http://ilbiz.co.il/ClientSite/other/flash/expressinstall.swf');
					so.write(parentName);		
				}";
			$build_html .= "</script>";
		$build_html .= "</head>";
		
		$bgcolor = ( $data['open_flash_color'] != "" ) ? " bgcolor=\"#".stripslashes($data['open_flash_color'])."\"" : "";
		$build_html .= "<body ".$img_g_site_bg." ".$bgcolor." leftmargin=\"0\" topmargin=\"0\" rightmargin=\"0\" bottommargin=\"0\" marginwidth=\"0\" marginheight=\"0\" align=center>";
						
					if( $c_unk == "654462387874498781")
					{
						$build_html .= "<table width=980 align=center><tr><td style='font-family:arial; font-size: 13px; color: #000000;' align=right><b>רפואה סינית – דיקור סיני</b></td></tr></table>";
					}
					if( $c_unk == "381849985170595403")
					{
						$build_html .= "<table width=800 align=center><tr><td style='font-family:arial; font-size: 13px; color: #000000;' align=right><b>רשת גלידות סורנטו</b></td></tr></table>";
					}
					if( $c_unk == "253771008666256497")
					{
						$build_html .= "<table width=770 align=center><tr><td style='font-family:arial; font-size: 13px; color: #000000;' align=right><b>מוסך הגליל, טבריה</b></td></tr></table>";
					}
					
						$build_html .= "<div id=\"LSopen_flash\" align=center></div>
						<script>
							loadSWF(\"/tamplate/".stripslashes($data['open_flash'])."\",\"open_flash\",\"".stripslashes($data['open_flash_width'])."\",\"".stripslashes($data['open_flash_height'])."\",\"#".stripslashes($data['open_flash_color'])."\",\"LSopen_flash\");
						</script>";
						if( $font_color_bottom != "" )
						{
							$build_html .= "<p align=center style='color: #".$font_color_bottom."; font-family: arial; font-size: 10px;'>";
							$build_html .= "<a href='http://kidum.ilbiz.co.il/' style='color: #".$font_color_bottom."; font-family: arial; font-size: 10px;' title='קידום אתרים בגוגל' target='_blank'>קידום אתרים בגוגל</a>";
							$build_html .= "&nbsp;&nbsp;&nbsp;";
							$build_html .= "<a href='http://www.il-biz.com/' style='color: #".$font_color_bottom."; font-family: arial; font-size: 10px;' title='בניית אתרים' target='_blank'>בניית אתרים</a>";
							$build_html .= "</p>";
						}
		$build_html .= "</body>";
		$build_html .= "</html>";
		
		$funcs = new GlobalFunctions;
		
		$new_path =  explode( "/home/ilan123" , SERVER_PATH );
		$new_path = $new_path[1];
		
		$conn_id = $funcs->chmod_openC();
		echo $funcs->chmod_fileC($conn_id, 777, $new_path ) ? '' : 'Error #12445875';
		$funcs->chmod_closeC($conn_id);
		
		$file2 = fopen(SERVER_PATH."/index.html", "w");
		rewind($file2);
		fputs($file2, $build_html);
		fclose($file2);
		chmod(SERVER_PATH."/index.html" , 0777);
		
		$conn_id = $funcs->chmod_openC();
		echo $funcs->chmod_fileC($conn_id, 755, $new_path ) ? '' : 'Error #12445875';
		$funcs->chmod_closeC($conn_id);
		
	}
	elseif( $c_unk == "532055106866759059" )
	{
		
	}
	else
	{
		$path_DEL_index = SERVER_PATH."/index.html";
		if( file_exists($path_DEL_index) && !is_dir($path_DEL_index) )
		{
			$funcs = new GlobalFunctions;
			
			$new_path =  explode( "/home/ilan123" , SERVER_PATH );
			$new_path = $new_path[1];
			
			$conn_id = $funcs->chmod_openC();
			echo $funcs->chmod_fileC($conn_id, 777, $new_path ) ? '' : 'Error #12445875';
			$funcs->chmod_closeC($conn_id);
			
			$a = unlink($path_DEL_index);
			
			$conn_id = $funcs->chmod_openC();
			echo $funcs->chmod_fileC($conn_id, 755, $new_path ) ? '' : 'Error #12445875';
			$funcs->chmod_closeC($conn_id);
			
			
			echo "<script>alert('קובץ הפתיח נמחק');</script>";
		}
	}
}



function dell_color_set()	{

	$sql = "update user_colors_set set deleted = '1' where id = '".$_REQUEST['record_id']."' limit 1";
	$res = mysql_db_query(DB,$sql);
	
	echo "<script>window.location.href='?main=colors_set_list&sesid=".SESID."'</script>";
		exit;
}



function del_img_DB_FTP()	{

	if( $_GET['field_name'] == "favicon" )
	{
		$abpath_temp = SERVER_PATH."/favicon.ico";
		
		if( file_exists($abpath_temp) && !is_dir($abpath_temp) )
		{
			$funcs = new GlobalFunctions;
		
			$new_path =  explode( "/home/ilan123" , SERVER_PATH );
			$new_path = $new_path[1];
			
			$conn_id = $funcs->chmod_openC();
			echo $funcs->chmod_fileC($conn_id, 777, $new_path ) ? '' : 'Error #12445875';
			$funcs->chmod_closeC($conn_id);
			
			unlink($abpath_temp);
			
			$conn_id = $funcs->chmod_openC();
			echo $funcs->chmod_fileC($conn_id, 755, $new_path ) ? '' : 'Error #12445875';
			$funcs->chmod_closeC($conn_id);
			
			echo "<script>alert('הקובץ נמחק בהצלחה');</script>";
		}
		else
			echo "<script>alert('#5545113 לא ניתן למחוק קובץ - הקובץ לא נמצא');</script>";
	}
	else
	{
		$sql = "SELECT id FROM ".$_GET['table']." WHERE unk = '".$_GET['unk']."' and ".$_GET['field_name']." = '".$_GET['img']."' limit 1";
		
		$res_check = mysql_db_query(DB,$sql);
		$data_check = mysql_fetch_array($res_check);
		
		if( $data_check['id'] != "" )
		{
			$abpath_temp = SERVER_PATH."/tamplate/".$_GET['img'];

			if( file_exists($abpath_temp) && !is_dir($abpath_temp) )
			{
				unlink($abpath_temp);
				
				$sql = "UPDATE ".$_GET['table']." SET ".$_GET['field_name']." = '' WHERE unk = '".$_GET['unk']."' and ".$_GET['field_name']." = '".$_GET['img']."' limit 1";
				$res = mysql_db_query(DB,$sql);
				
				echo "<script>alert('הקובץ נמחק בהצלחה');</script>";
			}
			else
				echo "<script>alert('#5545113 לא ניתן למחוק קובץ - הקובץ לא נמצא');</script>";
		}
		else
			echo "<script>alert('#5545112 לא ניתן למחוק קובץ');</script>";
	}
	
	echo "<script>window.location.href='?main=".$_GET['GOTO_main']."&sesid=".SESID."&type=".$_GET['GOTO_type']."'</script>";
		exit;
}

function updateCastumHtml()
{
	$_COOKIE['COOCKIE_domain'] = "";
	$sql = "SELECT domain FROM users WHERE unk = '".$_GET['unk']."' ";
	$res = mysql_db_query(DB , $sql );
	$data_unk = mysql_fetch_array($res);
	$_COOKIE['COOCKIE_domain'] = $data_unk['domain'];
	
	$sql = "SELECT ".$_GET['field']." FROM ".$_GET['table']." WHERE unk = '".$_GET['unk']."' AND id = '".$_GET['rowID']."' ";
	$res = mysql_db_query(DB , $sql );
	$data = mysql_fetch_array($res);
	
	echo "<table border=0 cellspacing=\"0\" cellpadding=\"0\" align=center class='maintext'>";
	echo "<form action='index.php' name='castum_Html_Form' method='POST'>";
	echo "<input type='hidden' name='main' value='updateCastumHtml_DB'>";
	echo "<input type='hidden' name='field' value='".$_GET['field']."'>";
	echo "<input type='hidden' name='table' value='".$_GET['table']."'>";
	echo "<input type='hidden' name='unk' value='".$_GET['unk']."'>";
	echo "<input type='hidden' name='rowID' value='".$_GET['rowID']."'>";
	echo "<input type='hidden' name='sesid' value='".SESID."'>";
	
	switch( $_GET['field'] )
	{
		case "topSliceHtml" : $headline = "סלייס עליון";		break;
		case "BottomSliceHtml" : $headline = "סלייס תחתון";		break;
		case "BottomSliceHtml_landing" : $headline = "סלייס תחתון בעמודי נחיתה";		break;
		case "RightSliceHtml" : $headline = "תפריט ימני הכי למעלה";		break;

		default: 
			$headline = "";
	}
		echo "<tr>";
			echo "<td align=right><b>".$headline."</b></td>";
		echo "</tr>";
		echo "<tr><td height='5'></td></tr>";
		echo "<tr>";
			echo "<td align=right>שימו לב - לא ניתן לעלות בסרגל כלים זה תמונות/פלאשים<br>
			יש באפשרותכם לעלות דרך סרגל כלים בתוך מערכת ניהול של הלקוח לאחר מכן להעתיק את הכתובת URL ולהדביק במקום שצריך כאן<br></b></td>";
		echo "</tr>";
		echo "<tr><td height='5'></td></tr>";
		echo "<tr>";
			echo "<td>";
				$sBasePath = "http://www.ilbiz.co.il/ClientSite/administration/fckeditor/" ;
				
				$oFCKeditor = new FCKeditor('castum_content') ;
				$oFCKeditor->BasePath	= $sBasePath ;
				$oFCKeditor->Width	= "800" ;
				$oFCKeditor->Height	= "400" ;
				
				$oFCKeditor->Value		= stripcslashes($data[$_GET['field']]) ;
				$oFCKeditor->Create() ;
			echo "</td>";
		echo "</tr>";
		echo "<tr><td height='5'></td></tr>";
		echo "<tr>";
			echo "<td align=left><input type='submit' value='שמור' class='submit_style'></td>";
		echo "</tr>";
		
		
	echo "</form>";
	echo "</table>";
	
			
}



function updateCastumHtml_DB()
{
	$sql = "UPDATE ".$_POST['table']." SET ".$_POST['field']." = '".str_replace("'","''",$_POST['castum_content'])."' WHERE unk = '".$_POST['unk']."' AND id = '".$_POST['rowID']."'";
	$res = mysql_db_query(DB , $sql );
	
	echo "<script>alert('הדף התעדכן בהצלחה');</script>";
	echo "<script>window.close();</script>";
	exit;
}
?>
