<?php



function menu()
{
	echo "<table border=\"0\" cellspacing=\"0\" cellpadding=\"0\" class=\"maintext\">";
		echo "<tr>";
		
			echo "<td width=230 valign=top>";
				echo menu_right_links();
			echo "</td>";
			
			echo "<td width=10></td>";
			
			echo "<td valign=top width=700 align=right><div id='task_homepage'>טוען...<script>tesk_mission(\"".SESID."\")</script></div></td>";
			
		echo "</tr>";
	echo "</table>";
}


function menu_right_links()	{

	echo "<table border=\"0\" cellspacing=\"0\" cellpadding=\"0\" class=\"maintext\" width=230>";
		
		if( AUTH >= 1 )
		{
			echo "<tr>
				<td><b style='font-site: 16px;'>אתרים</b></td>
			</tr>
			<tr><td height=\"5\"></td></tr>";
		}
		if( AUTH >= 3 )
		{
		echo "<tr>
			<td><a href=\"?main=user_profile&sesid=".SESID."\" class=\"maintext\">יצירת אתר חדש</a></td>
		</tr>
		<tr><td height=\"5\"></td></tr>";
		echo "<tr>
			<td><a href=\"?main=global_settings&sesid=".SESID."\" class=\"maintext\">ניהול כללי</a></td>
		</tr>
		<tr><td height=\"5\"></td></tr>";		
		}
		
		if( AUTH >= 1 )
		{
		echo "<tr>
			<td><a href=\"?main=users_list&sesid=".SESID."\" class=\"maintext\">רשימת משתמשים קיימים</a></td>
		</tr>
		<tr><td height=\"5\"></td></tr>";
		}
		
		if( AUTH >= 8 )
		{
		echo "<tr>
			<td><a href=\"?main=change_site_domain&sesid=".SESID."\" class=\"maintext\">החלפת דומיין לאתר</a></td>
		</tr>
		<tr><td height=\"5\"></td></tr>";
		}
		
		if( AUTH >= 9 )
		{
		echo "<tr>
			<td><a href=\"?main=delete_site_domain&sesid=".SESID."\" class=\"maintext\">מחיקת אתר לצמיתות</a></td>
		</tr>
		<tr><td height=\"5\"></td></tr>";
		}
		/*if( AUTH >= 4 )
		{
			echo "<tr>
				<td><a href=\"?main=colors_set_list&sesid=".SESID."\" class=\"maintext\">רשימת סטים של צבעים</a></td>
			</tr>
			<tr><td height=\"5\"></td></tr>";
		}*/
		if( AUTH >= 9 )
		{
			echo "<tr>
				<td><a href=\"?main=owners_list&sesid=".SESID."\" class=\"maintext\">מערכת בעלי אתרים / עובדים</a></td>
			</tr>
			<tr><td height=\"5\"></td></tr>";
		}
		
		if( AUTH >= 8 )
		{
			echo "<tr>
				<td><a href=\"?main=view_contacts&sesid=".SESID."\" class=\"maintext\">מערכת פניות</a></td>
			</tr>
			<tr><td height=\"5\"></td></tr>";
		}
		
		if( AUTH >= 8 )
		{
			echo "<tr>
				<td><a href=\"?main=marketing_partners&sesid=".SESID."\" class=\"maintext\">שיווק שותפים</a></td>
			</tr>
			<tr><td height=\"5\"></td></tr>";
		}
		
		if( AUTH >= 8 )
		{
			echo "<tr>
				<td><a href=\"?main=sn_example_sites&sesid=".SESID."\" class=\"maintext\">עדכון דוגמאות אתרים באתר 69</a></td>
			</tr>
			<tr><td height=\"5\"></td></tr>";
		}
		
		/*if( AUTH >= 8 )
		{
			echo "<tr>
				<td><a href=\"?main=langs_list&sesid=".SESID."\" class=\"maintext\">שפות במערכת</a></td>
			</tr>
			<tr><td height=\"5\"></td></tr>";
		}*/
		
		if( AUTH >= 8 )
		{
			echo "<tr>
				<td><a href=\"helpdesk.php?sesid=".SESID."&main=Request&status=0\" class=\"maintext\">שירות לקוחות</a></td>
			</tr>
			<tr><td height=\"5\"></td></tr>";
		}
		
		/*if( AUTH >= 9 )
		{
			echo "<tr>
				<td><a href=\"?sesid=".SESID."&main=temp_vladi_todo&status=0\" class=\"maintext\">משימות לולדי :]</a></td>
			</tr>
			<tr><td height=\"5\"></td></tr>";
		}*/
		
		if( AUTH >= 8 )
		{
			echo "<tr>
				<td><a href=\"?sesid=".SESID."&main=messagesSinon\" class=\"maintext\">הודעות ללקוחות אתרים</a></td>
			</tr>
			<tr><td height=\"5\"></td></tr>";
		}
		
		if( AUTH >= 9 )
		{
			echo "<tr>
				<td><a href=\"?sesid=".SESID."&main=search_value_at_site\" class=\"maintext\">חיפוש ערך בכל האתרים</a></td>
			</tr>
			<tr><td height=\"5\"></td></tr>";
		}
		
		if( AUTH >= 8 )
		{
			echo "<tr>
				<td><a href=\"?sesid=".SESID."&main=centered_contact\" class=\"maintext\">צור קשר מרוכז באתרים שנבחרו</a></td>
			</tr>
			<tr><td height=\"5\"></td></tr>";
		}
		
		if( AUTH >= 9 )
		{
		echo "<tr>
			<td><a href=\"?main=launch_fee_that_open&sesid=".SESID."\" class=\"maintext\">שגר תשלומים שלא שולמו</a></td>
		</tr>
		<tr><td height=\"5\"></td></tr>";
		}
		
		if( AUTH >= 9 )
		{
		echo "<tr>
			<td><a href=\"?main=ilbizProducts&sesid=".SESID."\" class=\"maintext\">מוצרי החברה</a></td>
		</tr>
		<tr><td height=\"5\"></td></tr>";
		}
		
		if( AUTH >= 8 )
		{
			echo "
			<tr><td height=\"20\"></td></tr>
			<tr>
				<td><b style='font-site: 16px;'>פורטל</b></td>
			</tr>
			<tr><td height=\"5\"></td></tr>";
		}
		
		if( AUTH >= 8 )
		{
			echo "
			<tr>
				<td><a href=\"?main=cat_system&sesid=".SESID."\" class=\"maintext\">מערכת קטגרויות בפורטל</a></td>
			</tr>
			<tr><td height=\"5\"></td></tr>";
		}
		
		if( AUTH >= 8 )
		{
			echo "
			<tr>
				<td><a href=\"?main=RunMassegPortal&sesid=".SESID."\" class=\"maintext\">פרסום במודעות רצות בפורטל</a></td>
			</tr>
			<tr><td height=\"5\"></td></tr>";
		}
		
		if( AUTH >= 8 )
		{
			echo "
			<tr>
				<td><a href=\"?main=PortalBannerSystem&sesid=".SESID."\" class=\"maintext\">רשימת באנרים בפורטל</a></td>
			</tr>
			<tr><td height=\"5\"></td></tr>";
		}
		if( AUTH >= 3 )
		{
			echo "
			<tr><td height=\"20\"></td></tr>
			<tr>
				<td><a href=\"?main=anf&gf=custom_posts_manager&sesid=".SESID."\" class=\"maintext\">מודול כתבות להוספה לדפי תוכן</a></td>
			</tr>
			<tr><td height=\"5\"></td></tr>
			<tr><td height=\"20\"></td></tr>
			";
		}		
		if( AUTH >= 3 )
		{
			echo "
			<tr><td height=\"20\"></td></tr>
			<tr>
				<td><b style='font-site: 16px;'>mySave</b></td>
			</tr>
			<tr><td height=\"5\"></td></tr>";
			echo "<tr>
				<td><a href=\"?main=view_estimate_form_list&sesid=".SESID."\" class=\"maintext\">רשימת הצעות מחיר שהתקבלו mysave</a></td>
			</tr>
			<tr><td height=\"5\"></td></tr>";
			echo "<tr>
				<td><a href=\"?main=customers_outof_leads&sesid=".SESID."\" class=\"maintext\">לקוחות עם 0 לידים</a></td>
			</tr>
			<tr><td height=\"5\"></td></tr>";			
		}
		if( AUTH >= 3 )
		{
			echo "<tr>
				<td><a href=\"?main=view_estimate_form_refund_list&sesid=".SESID."\" class=\"maintext\">בקשות לזיכויים על טופסי צור קשר</a></td>
			</tr>
			<tr><td height=\"5\"></td></tr>";
		}		
		if( AUTH >= 8 )
		{
			echo "<tr>
				<td><a href=\"?main=mysaveGenralLinks&type=1&sesid=".SESID."\" class=\"maintext\">עדכון קישורים עליוניים</a></td>
			</tr>
			<tr><td height=\"5\"></td></tr>";
			echo "<tr>
				<td><a href=\"?main=mysaveGenralLinks&type=2&sesid=".SESID."\" class=\"maintext\">עדכון קישורים רצים לפי קטגוריות</a></td>
			</tr>
			<tr><td height=\"5\"></td></tr>";
			echo "<tr>
				<td><a href=\"?main=createMysaveForm&sesid=".SESID."\" class=\"maintext\">יצירת טופס בקשה להצעת מחיר</a></td>
			</tr>
			<tr><td height=\"5\"></td></tr>";
			echo "<tr>
				<td><a href=\"?main=misscalls_leads_reports&sesid=".SESID."\" class=\"maintext\">שיחות שלא הפכו לליד בטופס</a></td>
			</tr>
			<tr><td height=\"5\"></td></tr>";
			echo "<tr>
				<td><a href=\"?main=anf&gf=current_phone_calls&sesid=".SESID."\" class=\"maintext\">מוניטור שיחות</a></td>
			</tr>
			<tr><td height=\"5\"></td></tr>";
			echo "<tr>
				<td><a href=\"?main=affiliates&sesid=".SESID."\" class=\"maintext\">מערכת שותפים</a></td>
			</tr>
			<tr><td height=\"5\"></td></tr>";			
			/*echo "<tr>
				<td><a href=\"?main=leadsPayments&sesid=".SESID."\" class=\"maintext\"><b>לידים</b> - קבלת ואישור תשלומים</a></td>
			</tr>
			<tr><td height=\"5\"></td></tr>";*/
		}
		if( AUTH >= 9 )
		{
			echo "<tr>
				<td><a href=\"?main=leadsUserGet&sesid=".SESID."\" class=\"maintext\"><b>לידים</b> - מספור קבלת לידים ללקוח</a></td>
			</tr>
			<tr><td height=\"5\"></td></tr>";
			
			echo "<tr>
				<td><a href=\"?main=daily_income_report&sesid=".SESID."\" class=\"maintext\">דוח הכנסות יומיות</a></td>
			</tr>
			<tr><td height=\"5\"></td></tr>";
			echo "<tr>
				<td><a href=\"?main=monthly_income_report&sesid=".SESID."\" class=\"maintext\">דוח הכנסות חודשיות</a></td>
			</tr>
			<tr><td height=\"5\"></td></tr>";			
			echo "<tr>
				<td><a href=\"?main=custom_lead_reports&sesid=".SESID."\" class=\"maintext\">ייצוא דוחות לידים</a></td>
			</tr>
			<tr><td height=\"5\"></td></tr>";			
			echo "<tr>
				<td><a href=\"?main=estimate_stat_list&sesid=".SESID."\" class=\"maintext\"><b>סטטיסטיקה של אתרי השוואות מחיר</b></a></td>
			</tr>
			<tr><td height=\"5\"></td></tr>";
			
			echo "<tr>
				<td><a href=\"?main=estimate_stats_by_groups&sesid=".SESID."\" class=\"maintext\"><b>סטטיסטיקה רוחבית לטפסי הצעות מחיר</b></a></td>
			</tr>
			<tr><td height=\"5\"></td></tr>";
			
			echo "<tr>
				<td><b>חדש</b></td>
			</tr>
			<tr><td height=\"5\"></td></tr>";
			echo "<tr>
				<td><a href=\"?main=estimate_statistics_list&sesid=".SESID."\" class=\"maintext\"><b>סטטיסטיקה של אתרי השוואות מחיר</b></a></td>
			</tr>
			<tr><td height=\"5\"></td></tr>";
		}
		if( AUTH >= 7 )
		{
			echo "<tr>
				<td><a href=\"?main=anf&gf=customer_tracking&sesid=".SESID."\" class=\"maintext\"><b>מעקב לקוחות</b></a></td>
			</tr>
			<tr><td height=\"5\"></td></tr>";
		}
		if( AUTH >= 9 )
		{			
			echo "<tr>
				<td><a href=\"?main=anf&gf=customer_tracking_statistics&sesid=".SESID."\" class=\"maintext\"><b>סטטיסטיקה של מעקב לקוחות</b></a></td>
			</tr>
			<tr><td height=\"5\"></td></tr>";		
			echo "<tr>
				<td><b>מערכת דיוור</b></td>
			</tr>
			<tr><td height=\"5\"></td></tr>";
			echo "<tr>
				<td><a href=\"?main=net_system&scope=net_list&sesid=".SESID."\" class=\"maintext\"><b>מערכת דיוור</b></a></td>
			</tr>
			<tr><td height=\"5\"></td></tr>";		
		}
		
		
		if( AUTH >= 8 )
		{
			echo "
			<tr><td height=\"20\"></td></tr>
			<tr>
				<td><a href=\"?main=net_menu&sesid=".SESID."\" class=\"maintext\"><b style='font-site: 16px;'>רשת אילביז</b></a></td>
			</tr>
			<tr><td height=\"5\"></td></tr>";
		}
		echo "<tr>
				<td><a href='https://ilbiz.co.il/myleads/' target='_BLANK' class='maintext'>מערכת ניהול לידים</a></td>
			</tr>
			<tr><td height=\"5\"></td></tr>";		
		if( AUTH >= 8 )
		{
			echo "
			<tr><td height=\"20\"></td></tr>
			<tr>
				<td><b style='font-site: 16px;'>הנהלת חשבונות</b></td>
			</tr>
			<tr><td height=\"5\"></td></tr>";
			echo "<tr>
				<td><a href=\"?main=bookkiping_end_date&type=domain&sesid=".SESID."\" class=\"maintext\">תאריך תפוגת דומיין של האתרים</a></td>
			</tr>
			<tr><td height=\"5\"></td></tr>";
			echo "<tr>
				<td><a href=\"?main=bookkiping_end_date&type=host&sesid=".SESID."\" class=\"maintext\">תאריך סיום אחסון אתרים</a></td>
			</tr>
			<tr><td height=\"5\"></td></tr>";
			echo "<tr>
				<td><a href=\"?main=bookkiping_end_date&type=dynamic_end_date&sesid=".SESID."\" class=\"maintext\">תאריך סיום חבילות פרסום</a></td>
			</tr>
			<tr><td height=\"5\"></td></tr>";
			
			echo "
			<tr><td height=\"20\"></td></tr>
			<tr>
				<td><b style='font-site: 16px;'>כרטיסי ביקור</b></td>
			</tr>
			<tr><td height=\"5\"></td></tr>";
			echo "<tr>
				<td><a href=\"?main=manage_e_card_icons&sesid=".SESID."\" class=\"maintext\">ניהול אייקונים</a></td>
			</tr>
			<tr><td height=\"5\"></td></tr>
			<tr>
				<td><a href=\"?main=user_e_card_list&sesid=".SESID."\" class=\"maintext\">לקוחות בעלי כרטיס</a></td>
			</tr>
			<tr><td height=\"5\"></td></tr>
			";		 	
		}
	echo "</table>";
}



/********************************************************************************************************/

function user_profile()	{

	$owner_id = ( AUTH >= "8" ) ? "" : " and owner_id = '".OID."'"; 
	if($_REQUEST['unk'] != "" )	{
		$sql = "select * from users where deleted = '0' and unk = '".$_REQUEST['unk']."' ".$owner_id."";
		$res = mysql_db_query(DB,$sql);
		$data = mysql_fetch_array($res);
		
		if( $data['id'] != "" )
		{
			$sql_extra_settings = "select * from user_extra_settings where unk = '".$_REQUEST['unk']."'";
			$res_extra_settings = mysql_db_query(DB,$sql_extra_settings);
			$user_extra_settings = mysql_fetch_array($res_extra_settings);
		}
		
		$sql = "select * from user_bookkeeping where unk = '".$_REQUEST['unk']."'";
		$res = mysql_db_query(DB,$sql);
		$data_bookkeeping = mysql_fetch_array($res);
	}
	else
	{
		
	}
	
	$gender[1] = "זכר";
	$gender[2] = "נקבה";
	
	$status[0] = "להציג אתר";
	$status[1] = "לא לציג אתר";
	
	$active_manager[0] = "פעיל";
	$active_manager[1] = "לא פעיל";
	
	$have_homepage[0] = "לא";
	$have_homepage[1] = "כן";
	
	$have_rightmenu[0] = "כן";
	$have_rightmenu[1] = "לא";
	
	$have_topmenu[0] = "לא";
	$have_topmenu[1] = "כן";
		
	$have_headline[0] = "כן";
	$have_headline[1] = "לא";
	
	$have_69[0] = "כן";
	$have_69[1] = "לא";
	
	$have_design[0] = "כן";
	$have_design[1] = "לא";
	
	$have_top_address[0] = "כן";
	$have_top_address[1] = "לא";
	
	$have_add_favi[0] = "לא";
	$have_add_favi[1] = "כן";
	
	
	$have_rightMenuButton[0] = "כן";
	$have_rightMenuButton[1] = "לא";
	
	$have_ProGal_cats[0] = "כן";
	$have_ProGal_cats[1] = "לא";
	
	$have_google_search[1] = "לא";
	$have_google_search[0] = "כן";
	
	
	$have_hp_banners[0] = "לא";
	$have_hp_banners[1] = "כן";
	
	$hp_type[0] = "תבניתי";
	$hp_type[1] = "חופשי";
	
	$have_ecom[0] = "לא";
	$have_ecom[1] = "כן";
	
	$flex_gallery[0] = "לא";
	$flex_gallery[1] = "כן";
	
	$have_extraL_img_gl[0] = "לא";
	$have_extraL_img_gl[1] = "כן";
	
	$have_print[0] = "לא";
	$have_print[1] = "כן";
	
	$flex_galleryType[1] = "גלריה בסיסית";
	$flex_galleryType[2] = "גלריה בסיסית ללא קטגוריות - מידות תמונות מיוחד";
	$flex_galleryType[3] = "גלריה - תמונות בצד + תמונות למעלה עם/ללא קטגוריות";
	$flex_galleryType[4] = "גלריה - תמונה גדולה למעלה, עם/ללא קטגוריות";
	$flex_galleryType[5] = "גלריה - דיפדוף בין תמונות 1 (אלה אברמוב)";
	$flex_galleryType[6] = "גלריה בסיסית עם הגדלת תמונה מגניב";
	
	$have_newsletterForm[0] = "כן";
	$have_newsletterForm[1] = "לא";
	
	
	$have_searchEng[0] = "כן";
	$have_searchEng[1] = "לא";
	
	$have_users_auth[0] = "לא";
	$have_users_auth[1] = "כן";
	
	$have_sales_dates[0] = "כן";
	$have_sales_dates[1] = "לא";
	
	$have_event_board[0] = "לא";
	$have_event_board[1] = "כן";
	
	$advBannerOrder[0] = "למטה";
	$advBannerOrder[1] = "למעלה";
	
	$scrollNewsOrder[0] = "למטה";
	$scrollNewsOrder[1] = "למעלה";
	
	$pr_popUpType2[0] = "נפתח רגיל";
	$pr_popUpType2[1] = "נפתח בפופ-אפ עם כל הפרטים";
	
	$have_ilbiz_net[0] = "לא";
	$have_ilbiz_net[1] = "כן";
	
	$have_ilbiz_adv_net[0] = "לא";
	$have_ilbiz_adv_net[1] = "כן";
	
	$have_side_ilbiz_net[0] = "לא";
	$have_side_ilbiz_net[1] = "כן";
	
	$have_calender_events[0] = "לא";
	$have_calender_events[1] = "כן";
	
	$active_send_email[0] = "לא";
	$active_send_email[1] = "כן";

	$has_ssl[0] = "לא";
	$has_ssl[1] = "כן";	
	$has_ssl[2] = "כן, ואלץ כניסה לעמודי https בלבד!";	
	
	$place_calender_events[0] = "למטה";
	$place_calender_events[1] = "למעלה";
	
	
	
	
	$user_extra__have_topSliceHtml[0] = "רגיל";
	$user_extra__have_topSliceHtml[1] = "בניית HTML (למומחים בלבד)";
	
	$user_extra__have_BottomSliceHtml[0] = "רגיל";
	$user_extra__have_BottomSliceHtml[1] = "בניית HTML (למומחים בלבד)";
	
	$user_extra__have_scrollNewsImgs[0] = "רגיל";
	$user_extra__have_scrollNewsImgs[1] = "מעוצב";
	
	$user_extra__userCanSEO[0] = "ללא קידום עצמי";
	$user_extra__userCanSEO[1] = "עם קידום עצמי";
	
	$user_extra__have_jobImgs[0] = "לא";
	$user_extra__have_jobImgs[1] = "כן";
	
	$user_extra__netMaxSendMail[2] = "2";
	$user_extra__netMaxSendMail[3] = "3";
	$user_extra__netMaxSendMail[4] = "4";
	$user_extra__netMaxSendMail[5] = "5";
	$user_extra__netMaxSendMail[6] = "6";
	$user_extra__netMaxSendMail[7] = "7";
	$user_extra__netMaxSendMail[8] = "8";
	$user_extra__netMaxSendMail[9] = "9";
	
	$user_extra__havaKidomBottomLink[0] = "כן";
	$user_extra__havaKidomBottomLink[1] = "לא";
	
	$user_extra__haveSmsDiscount[0] = "לא";
	$user_extra__haveSmsDiscount[1] = "כן";
	
	$user_extra__estimateSite[0] = "לא";
	$user_extra__estimateSite[1] = "כן";
	
	$user_extra__belongTo10service[0] = "לא";
	$user_extra__belongTo10service[1] = "כן";
	
	$user_extra__have10serviceMinisite[0] = "לא";
	$user_extra__have10serviceMinisite[1] = "כן";
	
	$user_extra__labor_agreement[0] = "לא";
	$user_extra__labor_agreement[1] = "כן";
	
	$user_extra__down_payment[0] = "לא";
	$user_extra__down_payment[1] = "כן";
	
	$user_extra__option_ticket_at_invoice[0] = "לא";
	$user_extra__option_ticket_at_invoice[1] = "כן";
	
	$user_extra__have_site_feature[0] = "לא";
	$user_extra__have_site_feature[1] = "כן";
	
	$user_extra__add_links_to_search_eng[0] = "לא";
	$user_extra__add_links_to_search_eng[1] = "כן";
	
	$user_extra__teaching_client[0] = "לא";
	$user_extra__teaching_client[1] = "כן";
	
	$user_extra__end_site_payment_collection[0] = "לא";
	$user_extra__end_site_payment_collection[1] = "כן";
	
	
	$user_extra__have_noindex[0] = "לא";
	$user_extra__have_noindex[1] = "כן";
	
	$user_extra__have_share_button[0] = "לא";
	$user_extra__have_share_button[1] = "כן";
	
	$user_extra__haveFacebookComments[0] = "לא";
	$user_extra__haveFacebookComments[1] = "כן";
	
	$user_extra__haveFacebookHpActive[0] = "לא";
	$user_extra__haveFacebookHpActive[1] = "כן";
	
	$user_extra__haveLandingPage[0] = "לא";
	$user_extra__haveLandingPage[1] = "כן";
	
	$user_extra__haveMailingNet[0] = "לא";
	$user_extra__haveMailingNet[1] = "כן";
	
	$user_extra__indexSite[0] = "לא";
	$user_extra__indexSite[1] = "כן";
	
	$user_extra__centered_contact[0] = "לא";
	$user_extra__centered_contact[1] = "כן";
	
	$user_extra__domainGoto10serviceMinisite[0] = "לא";
	$user_extra__domainGoto10serviceMinisite[1] = "כן";
	
	$user_extra__dogs4u_chooser_shop[0] = "לא";
	$user_extra__dogs4u_chooser_shop[1] = "כן";
	
	$user_extra__user_adsense_instead_esti_form[0] = "לא";
	$user_extra__user_adsense_instead_esti_form[1] = "כן";
	
	$user_extra__have_realty[0] = "לא";
	$user_extra__have_realty[1] = "כן";

	$user_extra__have_contracts[0] = "לא";
	$user_extra__have_contracts[1] = "כן";
	
	$advertisingPeriod = array(
	    0  => "חיוב ידני",
	    1  => "חודשי",
	    2  => "דו-חודשי",
	    3  => "רבעוני",
	    6  => "חצי שנתי",
	    12 => "שנתי"
	);
	
	
	$server_username['ilan123'] = "אתרי לקוחות";
	$server_username['try'] = "ניסיון";
	
	
	$sql = "SELECT name, id FROM site_type ORDER BY place";
	$res_u_t = mysql_db_query(DB, $sql);
	
	while( $data_u_t = mysql_fetch_array($res_u_t) )
	{
		$t_u_t = $data_u_t['id'];
		$site_type[$t_u_t] = stripslashes($data_u_t['name']);
	}	
	
	
	$sql = "SELECT cat_name, id FROM biz_categories where status=1 AND father=0 ORDER BY cat_name";
	$res_cats = mysql_db_query(DB, $sql);
	
	while( $data_cats = mysql_fetch_array($res_cats) )
	{
		$cat_id = $data_cats['id'];
		$user_extra__estimateSiteCat[$cat_id] = stripslashes($data_cats['cat_name']);
	}	
	
	
	$sql = "SELECT cat_name, id FROM biz_categories where status=1 AND father='".$user_extra_settings['estimateSiteCat']."' ORDER BY cat_name";
	$res_tat_cats = mysql_db_query(DB, $sql);
	
	while( $data_tat_cats = mysql_fetch_array($res_tat_cats) )
	{
		$tat_cat_id = $data_tat_cats['id'];
		$user_extra__estimateSiteTatCat[$tat_cat_id] = stripslashes($data_tat_cats['cat_name']);
	}	
	
	
	
	$sql = "SELECT id, name FROM newCities WHERE father=0";
	$resAllcityarea = mysql_db_query(DB,$sql);
	
	while( $datacityarea = mysql_fetch_array($resAllcityarea) )
	{
		$id = $datacityarea['id'];
		$NEWcity_area[$id] = stripslashes($datacityarea['name']);
		
		$sql = "SELECT id, name FROM newCities WHERE father=".$datacityarea['id']."";
		$resAllcityarea2 = mysql_db_query(DB,$sql);
													
		while( $datacityarea2 = mysql_fetch_array($resAllcityarea2) )
		{
			$id2 = $datacityarea2['id'];
			$NEWcity_area[$id2] = stripslashes($datacityarea2['name']);
		}
	}
	
	
	
	$sql = "SELECT name, id FROM users WHERE site_type = '10' ORDER BY name";
	$res_nisha = mysql_db_query(DB, $sql);
	
	while( $data_nisha = mysql_fetch_array($res_nisha) )
	{
		$nishaD = $data_nisha['id'];
		$user_extra__nisha_sites[$nishaD] = stripslashes($data_nisha['name']);
	}
	
	$nisha_sites_values = implode("@",json_decode($user_extra_settings['nisha_sites']));
	
	
	
	$insert_date = ( $data['insert_date'] == "0000-00-00" || $data['insert_date'] == "" ) ? GlobalFunctions::get_date() : $data['insert_date'] ;
	
	$sql = "select lang_name,id from site_langs";
	$res_lang = mysql_db_query(DB,$sql);

	while( $data_lang = mysql_fetch_array($res_lang) )	{
		$temp_lang_id = $data_lang['id'];
		$lang_id[$temp_lang_id] = $data_lang['lang_name'];
	}
	
	$temp_unk = "";
	if( $_REQUEST['unk'] == "" )	{
		for( $i=1 ; $i<=18 ; $i++ )
			$temp_unk .= rand(0, 9);
	}
	else
		$temp_unk = $_REQUEST['unk'];
	
	
		$city_combo = "<table border=\"0\" cellspacing=\"0\" cellpadding=\"0\" class=\"maintext\">
			<tr>
				<td>עיר</td>
				<td width=\"149\"></td>
				<td>";
					$city_combo .= "<span style=\"behavior:url(options.htc); width:1px;\">";
							$city_combo .= "<select name=\"data_arr[city]\" class=\"input_style\">";
							$city_combo .= "<option value=\"\">בחירת עיר</option>";
								
								$sql = "select id,name from cities order by name";
								$res_city = mysql_db_query(DB,$sql);
								
								while($data_city = mysql_fetch_array($res_city))	{
									$checked_city = ($data['city'] == $data_city['id'])? " selected" : "";
									$city_combo .= "<option value=\"".$data_city['id']."\"".$checked_city.">".stripslashes($data_city['name'])."</option>";
								}
							$city_combo .= "</select>";
						$city_combo .= "</span>
					</td>
				</tr>
			</table>";
	
	
	
	$goto_main = ( $_REQUEST['unk'] ) ? "update_DB_profile" : "new_DB_profile";
	
	
	$user_extra__labor_agreement[0] = "לא";
	$user_extra__labor_agreement[1] = "כן";
	
	$user_extra__down_payment[0] = "לא";
	$user_extra__down_payment[1] = "כן";
	
	$user_extra__option_ticket_at_invoice[0] = "לא";
	$user_extra__option_ticket_at_invoice[1] = "כן";
	
	$user_extra__have_site_feature[0] = "לא";
	$user_extra__have_site_feature[1] = "כן";
	
	$user_extra__add_links_to_search_eng[0] = "לא";
	$user_extra__add_links_to_search_eng[1] = "כן";
	
	$user_extra__teaching_client[0] = "לא";
	$user_extra__teaching_client[1] = "כן";
	
	$user_extra__end_site_payment_collection[0] = "לא";
	$user_extra__end_site_payment_collection[1] = "כן";
	
	
	
	
	
	
	//labor_agreement_file
	if( AUTH >= 8 )
	{
		$new_file_labor_block = "
		<table cellpading=0 cellspacing=0 border=0 class=maintext>
			<tr>
				<td>קובץ הסכם עבודה:</td>
				<td width='165'></td>
				<td><input type='file' name='labor_agreement_file' class='input_style'></td>
				<td width='10'></td>";
				
				$path = "/home/ilan123/domains/ilbiz.co.il/public_html/site-admin/clients/eskemim/".$user_extra_settings['labor_agreement_file'];
				if( is_file($path) )
				{
					$new_file_labor_block .= "<td><a href='clients/eskemim/".$user_extra_settings['labor_agreement_file']."' clas='maintext' target='_blank'>צפה בהסכם</a></td>";
				}
				$new_file_labor_block .= "
			</tr>
		</table>
		";
		
		$new_file_agreement_10service_site = "
		<table cellpading=0 cellspacing=0 border=0 class=maintext>
			<tr>
				<td>קובץ הסכם בנייה לשירות 10:</td>
				<td width='115'></td>
				<td><input type='file' name='agreement_10service_site' class='input_style'></td>
				<td width='10'></td>";
				
				$path = "/home/ilan123/domains/ilbiz.co.il/public_html/site-admin/clients/eskemim/".$user_extra_settings['agreement_10service_site'];
				if( is_file($path) )
				{
					$new_file_agreement_10service_site .= "<td><a href='clients/eskemim/".$user_extra_settings['agreement_10service_site']."' clas='maintext' target='_blank'>צפה בהסכם</a></td>";
				}
				$new_file_agreement_10service_site .= "
			</tr>
		</table>
		";
		
		
		$new_file_agreement_10service_products = "
		<table cellpading=0 cellspacing=0 border=0 class=maintext>
			<tr>
				<td>קובץ הסכם עבודה ללספקי שירות ומוצרים לשירות 10 :</td>
				<td width='5'></td>
				<td><input type='file' name='agreement_10service_products' class='input_style'></td>
				<td width='10'></td>";
				
				$path = "/home/ilan123/domains/ilbiz.co.il/public_html/site-admin/clients/eskemim/".$user_extra_settings['agreement_10service_products'];
				if( is_file($path) )
				{
					$new_file_agreement_10service_products .= "<td><a href='clients/eskemim/".$user_extra_settings['agreement_10service_products']."' clas='maintext' target='_blank'>צפה בהסכם</a></td>";
				}
				$new_file_agreement_10service_products .= "
			</tr>
		</table>
		";
		
		
		
		$more_auth_1 = array("select","labor_agreement[]",$user_extra__labor_agreement,"הסכם עבודה",$user_extra_settings['labor_agreement'],"labor_agreement", "class='input_style'");
		$new_file_labor = array("blank",$new_file_labor_block);
		$new_file_labor2 = array("blank",$new_file_agreement_10service_site);
		$new_file_labor3 = array("blank",$new_file_agreement_10service_products);
		
		$more_auth_2 = array("select","down_payment[]",$user_extra__down_payment,"האם שולמה מקדמה",$user_extra_settings['down_payment'],"down_payment", "class='input_style'");
		$more_auth_3 = array("select","option_ticket_at_invoice[]",$user_extra__option_ticket_at_invoice,"פתיחת תיק לקוח במערכת חשבוניות",$user_extra_settings['option_ticket_at_invoice'],"option_ticket_at_invoice", "class='input_style'");
		$more_auth_4 = array("select","have_site_feature[]",$user_extra__have_site_feature,"איפיון אתר",$user_extra_settings['have_site_feature'],"have_site_feature", "class='input_style'");
		$more_auth_5 = array("select","add_links_to_search_eng[]",$user_extra__add_links_to_search_eng,"הוספת קישור לאתר למנועי חיפוש",$user_extra_settings['add_links_to_search_eng'],"add_links_to_search_eng", "class='input_style'");
		$more_auth_6 = array("select","teaching_client[]",$user_extra__teaching_client,"הדרכת לקוח",$user_extra_settings['teaching_client'],"teaching_client", "class='input_style'");
		$more_auth_7 = array("select","end_site_payment_collection[]",$user_extra__end_site_payment_collection,"סיום גבייה תשלום עבור הקמה",$user_extra_settings['end_site_payment_collection'],"end_site_payment_collection", "class='input_style'");
	}
	else
	{
		$more_auth_1 = array("hidden","labor_agreement",$user_extra_settings['labor_agreement']);
		$more_auth_2 = array("hidden","down_payment",$user_extra_settings['down_payment']);
		$more_auth_3 = array("hidden","option_ticket_at_invoice",$user_extra_settings['option_ticket_at_invoice']);
		$more_auth_4 = array("hidden","have_site_feature",$user_extra_settings['have_site_feature']);
		$more_auth_5 = array("hidden","add_links_to_search_eng",$user_extra_settings['add_links_to_search_eng']);
		$more_auth_6 = array("hidden","teaching_client",$user_extra_settings['teaching_client']);
		$more_auth_7 = array("hidden","end_site_payment_collection",$user_extra_settings['end_site_payment_collection']);
		
	}
	
	if( AUTH >= 9 )
	{
		$sql = "SELECT client_name , id FROM sites_owner WHERE auth < 8 AND deleted=0 AND status=0 AND end_date >= NOW()";
		$res_workers = mysql_db_query(DB,$sql);
		
		while( $data_workers = mysql_fetch_array($res_workers) )
		{
			$id = $data_workers['id'];
			$owner_id[$id] = stripslashes($data_workers['client_name']);
		}
		$owner_id_select = array("select","owner_id[]",$owner_id,"אתר שייך ל...",$data['owner_id'],"data_arr[owner_id]", "class='input_style'");
		
		
		$headline_settings = array("blank","<br><br><b style='font-size:17px;'>אישורי הצגת האתר + מערכת ניהול</b>");
		$status = array("select","status[]",$status,"סטטוס",$data['status'],"data_arr[status]", "class='input_style'");
		$active_manager = array("select","active_manager[]",$active_manager,"מערכת ניהול אתר",$data['active_manager'],"data_arr[active_manager]", "class='input_style'");
		
		$headline_settings2 = array("blank","------------------- מערכת גביה ------------------------------");
		$end_date = array("date","end_date",$data['end_date'],"תאריך סיום אכסון", "class='input_style'");
		$domainEndDate = array("date","domainEndDate",$data_bookkeeping['domainEndDate'],"תאריך סיום דומיין", "class='input_style'");
		$hostPriceMon = array("text","hostPriceMon",$data_bookkeeping['hostPriceMon'],"מחיר אכסון חודשי לא כולל מע\"מ", "class='input_style'");
		$domainPrice = array("text","domainPrice",$data_bookkeeping['domainPrice'],"מחיר לדומיין לא כולל מע\"מ", "class='input_style'");
		
		$advertisingStartDate = array("date", "advertisingStartDate", $data_bookkeeping['advertisingStartDate'], "תאריך תחילת פרסום",  "class='input_style'");
		$advertisingPrice = array("text", "advertisingPrice", $data_bookkeeping['advertisingPrice'], "מחיר פרסום",  "class='input_style'");
		$advertisingPeriod = array("select", "advertisingPeriod[]", $advertisingPeriod, "מחזור תשלום", $data_bookkeeping['advertisingPeriod'], "advertisingPeriod", "class='input_style'");
		$leadPrice = array("text", "leadPrice", $data_bookkeeping['leadPrice'], "מחיר ליד", "class='input_style'");
		$leadPercentOff = array("text", "leadPercentOff", $data_bookkeeping['leadPercentOff'], "אחוז הנחה לליד", "class='input_style'");

		$sendReport_1 = array("hidden", "sendReport", '0', "שליחת דוח חודשי", "class='input_style1' ");
		$check=null;
		if($data_bookkeeping['sendReport']==="1"){
			$check = 'checked';
		}
		$sendReport = array("checkbox", "sendReport","1","שלח דוח אוטומטי חדשי"," class='input_style' ".$check);

		$advReport_1 = array("hidden", "advReport", '0', "דוח מתקדם", "class='input_style1' ");
		$advcheck=null;
		if($data_bookkeeping['advReport']==="1"){
			$advcheck = 'checked';
		}
		$advReport = array("checkbox", "advReport","1","דוח מתקדם"," class='input_style' ".$advcheck);
		
		$haveLandingPage = array("select","haveLandingPage[]",$user_extra__haveLandingPage,"יש דף נחיתה?",$user_extra_settings['haveLandingPage'],"haveLandingPage", "class='input_style'");
		$maxLandingPage = array("text","maxLandingPage",$user_extra_settings['maxLandingPage'],"מקסימום דפי נחיתה", "class='input_style'");
		
		$haveMailingNet = array("select","haveMailingNet[]",$user_extra__haveMailingNet,"יש מערכת דיוור?",$user_extra_settings['haveMailingNet'],"haveMailingNet", "class='input_style'");
		$estimateSite = array("select","estimateSite[]",$user_extra__estimateSite,"אתר השוואות מחיר של אילביז?",$user_extra_settings['estimateSite'],"estimateSite", "class='input_style'");
		$estimateSiteCat = array("select","estimateSiteCat[]",$user_extra__estimateSiteCat,"קטגוריה ראשית של האתר השווואת מחיר",$user_extra_settings['estimateSiteCat'],"estimateSiteCat", "class='input_style'");
		$estimateSiteTatCat = array("select","estimateSiteCat[]",$user_extra__estimateSiteTatCat,"קטגוריה משנית של אתרי השוואת מחירים,<br>יש לעדכן אחרי בחירה של קטגוריה ראשית,<br>שמירה ואז ניתן יהיה לשמור",$user_extra_settings['estimateSiteTatCat'],"estimateSiteTatCat", "class='input_style'");
		
		$estimateTopTitle = array("text","estimateTopTitle",$user_extra_settings['estimateTopTitle'],"אתר השוואת מחירים, כותרת 'השוואת מחירים'<br>לביטול ברירת מחדל הקלד <b>-</b> (מינוס)", "class='input_style'");
		$have10serviceMinisite = array("select","have10serviceMinisite[]",$user_extra__have10serviceMinisite,"הצג מיניסייט מלא באתר שירות-10",$user_extra_settings['have10serviceMinisite'],"have10serviceMinisite", "class='input_style'");
		$domainGoto10serviceMinisite = array("select","domainGoto10serviceMinisite[]",$user_extra__domainGoto10serviceMinisite,"פוינטר למיניסייט פעיל?<br><font style='font-size: 11px;'>(במידה ותבחר כן, לא יראו את האתר תחת הדומיין)</font>",$user_extra_settings['domainGoto10serviceMinisite'],"domainGoto10serviceMinisite", "class='input_style'");
		
		
		$indexSite = array("select","indexSite[]",$user_extra__indexSite,"אתר אינדקס",$user_extra_settings['indexSite'],"indexSite", "class='input_style'");
		
	}
	else
	{
		//$owner_id_select = array("hidden","owner_id",$data['owner_id']);
		$status = array("hidden","status",$data['status']);
		$active_manager = array("hidden","active_manager",$data['active_manager']);
		$end_date = array("date","end_date",$data['end_date'],"תאריך סיום אכסון", "class='input_style' readonly");
		$domainEndDate = array("date","domainEndDate",$data_bookkeeping['domainEndDate'],"תאריך סיום דומיין", "class='input_style' readonly");
		$hostPriceMon = array("hidden","hostPriceMon",$data_bookkeeping['hostPriceMon']);
		$domainPrice = array("hidden","domainPrice",$data_bookkeeping['domainPrice']);
		
		
		$haveLandingPage = array("hidden","haveLandingPage",$user_extra_settings['haveLandingPage']);
		$maxLandingPage = array("hidden","maxLandingPage",$user_extra_settings['maxLandingPage']);
		$haveMailingNet = array("hidden","haveMailingNet",$user_extra_settings['haveMailingNet']);
		$estimateSite = array("hidden","estimateSite",$user_extra_settings['estimateSite']);
		$estimateSiteCat = array("hidden","estimateSiteCat",$user_extra_settings['estimateSiteCat']);
		$estimateSiteTatCat = array("hidden","estimateSiteTatCat",$user_extra_settings['estimateSiteTatCat']);
		$estimateTopTitle = array("hidden","estimateTopTitle",$user_extra_settings['estimateTopTitle']);
		$have10serviceMinisite = array("hidden","have10serviceMinisite",$user_extra_settings['have10serviceMinisite']);
		$domainGoto10serviceMinisite = array("hidden","domainGoto10serviceMinisite",$user_extra_settings['domainGoto10serviceMinisite']);
		$indexSite = array("hidden","indexSite",$user_extra_settings['indexSite']);
	}
	
	
	$owner_id_val = ( OID == "1" ) ? "aaa" : "data_arr[owner_id]";
	$owner_id_key_val = ( $data['id'] == "" ) ? OID : $data['owner_id'];
	$form_arr = array(
		array("hidden","main",$goto_main),
		array("hidden","record_id",$data['id']),
		array("hidden",$owner_id_val,$owner_id_key_val),
		array("hidden","sesid",SESID),
		array("hidden","unk",$_REQUEST['unk']),
		array("hidden","data_arr[unk]",$temp_unk),
		
		
		
		array("blank","<b style='font-size:17px;'>פרטים אישיים</b>"),
		array("text","data_arr[username]",$data['username'],"* שם משתמש", "class='input_style'","","1"),
		array("text","data_arr[password]",$data['password'],"* סיסמא", "class='input_style'","","1"),
		array("text","data_arr[domain]",$data['domain'],"* דומיין", "class='input_style'","","1"),
		array("select","has_ssl[]",$has_ssl,"יש תעודת SSL",$data['has_ssl'],"data_arr[has_ssl]", "class='input_style'"),		
		array("text","data_arr[site_version]",$data['site_version'],"* גרסת אתר", "class='input_style'","","1"),		
		array("text","data_arr[full_name]",$data['full_name'],"* שם מלא", "class='input_style'","","1"),
		array("text","data_arr[name]",$data['name'],"* שם עסק", "class='input_style'","","1"),
		array("blank",$city_combo),
		array("select","city_area[]",$NEWcity_area,"עיר + אזור נחוץ לקבלת לידים",$data['city_area'],"data_arr[city_area]", "class='input_style'"),
		
		array("text","data_arr[address]",$data['address'],"כתובת", "class='input_style'","","1"),
		array("text","data_arr[email]",$data['email'],"* אימייל", "class='input_style'","","1"),
		array("text","data_arr[phone]",$data['phone'],"* טלפון", "class='input_style'","","1"),
		array("text","data_arr[gl_campaign_phone]",$data['gl_campaign_phone'],"טלפון להציג בקמפיין גוגל", "class='input_style'","","1"),
		array("text","data_arr[fb_campaign_phone]",$data['fb_campaign_phone'],"טלפון להציג בקמפיין פייסבוק", "class='input_style'","","1"),
		array("text","data_arr[fax]",$data['fax'],"פקס", "class='input_style'","","1"),
		array("select","gender[]",$gender,"מין",$data['gender'],"data_arr[gender]", "class='input_style'"),
		array("date","birthday",$data['birthday'],"תאריך לידה <font style=\"font-size:9px;\" class=\"maintext_small\">dd-mm-yyyy</font>", "class='input_style'"),
		array("textarea","data_arr[text_for_us]",$data['text_for_us'],"הערות מערכת - משמש את הצוות הבניה.<br> פה ירשמו כל מיני הערות לגבי הלקוח<br> על מנת שבעתיד יהיה ניתן לזהות <br>כל בקשה", "class='input_style' style='height:200px'"),
		array("textarea","data_arr[portal_text]",$data['portal_text'],"מלל קצר שיופיע בפורטל", "class='input_style' style='height:100px'"),
		array("textarea","free_text",$user_extra_settings['free_text'],"מילות מפתח לחיפוש טקסט חופשי", "class='input_style' style='height:100px'"),
		
		array("text","data_arr[recapcha_key]",$data['recapcha_key'],"מפתח קאפצה לחוזים", "class='input_style'","","1"),
		
		array("select","server_username[]",$server_username,"יוזר בשרת - עדיין אינו פעיל",$data['server_username'],"data_arr[server_username]", "class='input_style'"),
		array("select","active_send_email[]",$active_send_email,"שליחת דיוור לאימייל חסומה?",$data['active_send_email'],"data_arr[active_send_email]", "class='input_style'"),
		array("select","site_type[]",$site_type,"סוג אתר",$data['site_type'],"data_arr[site_type]", "class='input_style'"),
		
		$headline_settings,$status,$active_manager,$headline_settings2,$end_date,$domainEndDate,$hostPriceMon,$domainPrice, $advertisingStartDate,$advertisingPrice, $advertisingPeriod, $leadPrice, $leadPercentOff,$sendReport_1, $sendReport,$advReport_1, $advReport,
		array("date","insert_date",$insert_date,"תאריך בנית האתר", "class='input_style' readonly"),
		$more_auth_1,$new_file_labor,$new_file_labor2,$new_file_labor3,$more_auth_2,$more_auth_3,$more_auth_4,$more_auth_5,$more_auth_6,$more_auth_7,
		$owner_id_select,
		
		array("blank","<br><br><b style='font-size:17px;'>הגדרות אתר</b>"),
		array("select","lang_id[]",$lang_id,"שפת מערכת",$data['lang_id'],"data_arr[lang_id]", "class='input_style'"),
		
		
		array("select","have_homepage[]",$have_homepage,"להציג דף בית",$data['have_homepage'],"data_arr[have_homepage]", "class='input_style'"),
		array("select","hp_type[]",$hp_type,"סוג דף הבית",$data['hp_type'],"data_arr[hp_type]", "class='input_style'"),
		array("select","have_topSliceHtml[]",$user_extra__have_topSliceHtml,"סוג סלייס עליון",$user_extra_settings['have_topSliceHtml'],"have_topSliceHtml", "class='input_style'"),
		array("select","have_BottomSliceHtml[]",$user_extra__have_BottomSliceHtml,"סוג סלייס תחתון",$user_extra_settings['have_BottomSliceHtml'],"have_BottomSliceHtml", "class='input_style'"),
		
		array("select","have_topmenu[]",$have_topmenu,"להציג תפריט עליון",$data['have_topmenu'],"data_arr[have_topmenu]", "class='input_style'"),
		array("select","have_headline[]",$have_headline,"להציג כותרות",$data['have_headline'],"data_arr[have_headline]", "class='input_style'"),
		array("select","have_69[]",$have_69,"להציג זכויות ל 69",$data['have_69'],"data_arr[have_69]", "class='input_style'"),
		array("select","have_design[]",$have_design,"להציג זכויות למעצב",$data['have_design'],"data_arr[have_design]", "class='input_style'"),
		array("select","have_top_address[]",$have_top_address,"להציג פרטי התקשרות עליונה (לא מומלץ)",$data['have_top_address'],"data_arr[have_top_address]", "class='input_style'"),
		array("select","have_ProGal_cats[]",$have_ProGal_cats,"להציג קטגוריות במוצרים וגלריות?",$data['have_ProGal_cats'],"data_arr[have_ProGal_cats]", "class='input_style'"),
		array("select","have_hp_banners[]",$have_hp_banners,"באנרים בעמוד הבית?",$data['have_hp_banners'],"data_arr[have_hp_banners]", "class='input_style'"),
		array("select","have_ecom[]",$have_ecom,"חנות וירטואלית?",$data['have_ecom'],"data_arr[have_ecom]", "class='input_style'"),
		array("select","have_print[]",$have_print,"אפשרות הדפסה?",$data['have_print'],"data_arr[have_print]", "class='input_style'"),
		array("select","have_calender_events[]",$have_calender_events,"לוח שנה + אירועים",$data['have_calender_events'],"data_arr[have_calender_events]", "class='input_style'"),
		array("select","havaKidomBottomLink[]",$user_extra__havaKidomBottomLink,"להציג קישור קידום אתרים למטה",$user_extra_settings['havaKidomBottomLink'],"havaKidomBottomLink", "class='input_style'"),
		array("select","have_noindex[]",$user_extra__have_noindex,"הוסף noIndex לאתר בבנייה",$user_extra_settings['have_noindex'],"have_noindex", "class='input_style'"),
		
		
		array("blank","<br><br><b style='font-size:17px;'>הגדרות מיוחדות לILBIZ</b>"),
		array("select","have_ilbiz_net[]",$have_ilbiz_net,"<b>שותף ברשת מועדון אילביז?</b>",$data['have_ilbiz_net'],"data_arr[have_ilbiz_net]", "class='input_style'"),
		array("select","have_ilbiz_adv_net[]",$have_ilbiz_adv_net,"<b>שותף ברשת פרסום אילביז?</b>",$data['have_ilbiz_adv_net'],"data_arr[have_ilbiz_adv_net]", "class='input_style'"),
		array("select","have_side_ilbiz_net[]",$have_side_ilbiz_net,"<b>שותף ברשת + אפשרות לכניסה דרך באנר שיווק שותפים?</b>",$data['have_side_ilbiz_net'],"data_arr[have_side_ilbiz_net]", "class='input_style'"),
		array("blank","<br><br><b style='font-size:17px;'>להוספת דפי נחיתה- שימו לב לפרטים הבאים:</b><br/>
		<b>1:</b> 
		בהגדרות עיצוב - 
		<b>
		גירסת מיניפורטל בעמוד הבית
		</b>
		<br/>&nbsp;&nbsp;&nbsp; 0 - 
		לעמוד נחיתה בתור עמוד בית, ואז חובה להוסיף עמוד נחיתה, <br/>&nbsp;&nbsp;&nbsp;1 - לדף תוכן רגיל או מיניפורטל בתור עמוד בית, תלוי בהגדרה הבאה.<br/>
		</br><b>2:</b> להציג דף בית 
		<br/>
		&nbsp;&nbsp;
		כן - יציג את דף התוכן בתור דף בית,
		&nbsp;&nbsp;
		<br/>
		&nbsp;&nbsp;
		לא - יציג מיניפורטל.
		סוג המיניפורטל שיוצג תלוי בהגדרות שבמערכת ניהול לקוח
		<br/>
		<br/><b>3:</b> אתר אינדקס: צריך להיות ב-לא. אם מוגדר כן, זה למתקדמים ולא יעבוד כצפוי
		"),
		$haveLandingPage,$maxLandingPage,$haveMailingNet,$estimateSite,$estimateSiteCat,$estimateSiteTatCat,$estimateTopTitle,$have10serviceMinisite,$domainGoto10serviceMinisite,
		array("select","belongTo10service[]",$user_extra__belongTo10service,"אתר שייך לאתר שירות-10",$user_extra_settings['belongTo10service'],"belongTo10service", "class='input_style'"),
		array("select","centered_contact[]",$user_extra__centered_contact,"צור קשר מרוכז במערכת ניהול הראשי",$user_extra_settings['centered_contact'],"centered_contact", "class='input_style'"),
		
		
		array("blank","<br><br><b style='font-size:17px;'>תוספות מיוחדות</b>"),
		array("select","netMaxSendMail[]",$user_extra__netMaxSendMail,"מקסימום שליחות מייל בחודש דרך מועדון",$user_extra_settings['netMaxSendMail'],"netMaxSendMail", "class='input_style'"),
		array("select","userCanSEO[]",$user_extra__userCanSEO,"קידום עצמי",$user_extra_settings['userCanSEO'],"userCanSEO", "class='input_style'"),
		array("text","data_arr[max_free_text]",$data['max_free_text'],"מקסימום דפים חופשיים", "class='input_style'","","1"),
		array("textarea","data_arr[googleAnalytics]",$data['googleAnalytics'],"Google Analytics", "dir='ltr' class='input_style' style='height:100px'"),
		array("select","have_users_auth[]",$have_users_auth,"מערכת הרשאות?",$data['have_users_auth'],"data_arr[have_users_auth]", "class='input_style'"),
		array("select","have_sales_dates[]",$have_sales_dates,"לאפשר תצוגת תאריכים במבצעים?",$data['have_sales_dates'],"data_arr[have_sales_dates]", "class='input_style'"),
		array("select","have_event_board[]",$have_event_board,"לוח אירועים פעיל במערכת ניהול",$data['have_event_board'],"data_arr[have_event_board]", "class='input_style'"),
		array("select","pr_popUpType2[]",$pr_popUpType2,"קטלוג מוצרים נפתח בפופ-אפ",$data['pr_popUpType2'],"data_arr[pr_popUpType2]", "class='input_style'"),
		array("select","have_jobImgs[]",$user_extra__have_jobImgs,"דרושים מעוצב",$user_extra_settings['have_jobImgs'],"have_jobImgs", "class='input_style'"),
		array("select","haveSmsDiscount[]",$user_extra__haveSmsDiscount,"בקשה להנחה דרך הודעת sms",$user_extra_settings['haveSmsDiscount'],"haveSmsDiscount", "class='input_style'"),
		array("textarea","contactThanksPixel",$user_extra_settings['contactThanksPixel'],"קוד המרה לדף תודה בטופס צור קשר", "dir='ltr' class='input_style' style='height:100px'"),
		array("text","contactThanksUrlRedirect",$user_extra_settings['contactThanksUrlRedirect'],"הפנייה לאחר 5 שניות מדף תודה בטופס צור קשר", "class='input_style'"),
		array("textarea","remartiking_code",$user_extra_settings['remartiking_code'],"קוד רימרקטינג", "dir='ltr' class='input_style' style='height:100px'"),
		array("select","dogs4u_chooser_shop[]",$user_extra__dogs4u_chooser_shop,"שייך לאתר אוכל לכלבים?",$user_extra_settings['dogs4u_chooser_shop'],"dogs4u_chooser_shop", "class='input_style'"),
		array("select","user_adsense_instead_esti_form[]",$user_extra__user_adsense_instead_esti_form,"פרסומות במקום טופס בשירות 10",$user_extra_settings['user_adsense_instead_esti_form'],"user_adsense_instead_esti_form", "class='input_style'"),
		array("textarea","zopim_script",$user_extra_settings['zopim_script'],"קוד זופים", "dir='ltr' class='input_style' style='height:50px'"),
		$indexSite,
		array("select","nisha_sites[]",$user_extra__nisha_sites,"אתרי נישה",$nisha_sites_values,"nisha_sites[]", "class='input_style' style='height: 80px;' multiple size='4'"),
		array("select","have_realty[]",$user_extra__have_realty,"אתר עם אופציה למערכת תיווך",$user_extra_settings['have_realty'],"have_realty", "class='input_style'"),
		array("select","have_contracts[]",$user_extra__have_contracts	,"יש ניהול חוזים",$user_extra_settings['have_contracts'],"have_contracts", "class='input_style'"),
	
		array("blank","<br><br><b style='font-size:17px;'>רשתות חברתיות</b>"),
		array("select","have_share_button[]",$user_extra__have_share_button,"הוסף כפתור share לרשתות חברתיות",$user_extra_settings['have_share_button'],"have_share_button", "class='input_style'"),
		array("select","haveFacebookComments[]",$user_extra__haveFacebookComments,"תגובות דרך פייסבוק למודולים",$user_extra_settings['haveFacebookComments'],"haveFacebookComments", "class='input_style'"),
		array("select","haveFacebookHpActive[]",$user_extra__haveFacebookHpActive,"מודולים של פייסבוק בעמוד מיני פורטל",$user_extra_settings['haveFacebookHpActive'],"haveFacebookHpActive", "class='input_style'"),
		array("text","facebookPageId",$user_extra_settings['facebookPageId'],"מספר סידורי של דף פייסבוק", "class='input_style'"),
		array("text","wibiyaAnalytics",$user_extra_settings['wibiyaAnalytics'],"סרגל כילים wibiya <br> יש להטמיע רק אם יודעים מה זה", "class='input_style'"),
		
		
		array("blank","<br><br><b style='font-size:17px;'>הגדרות לחלק הימני באתר (תפריט ימני)</b>"),
		array("select","have_rightmenu[]",$have_rightmenu,"להציג תפריט ימני",$data['have_rightmenu'],"data_arr[have_rightmenu]", "class='input_style'"),
		array("select","have_add_favi[]",$have_add_favi,"להציג הפוך לדף הבית ולמועדפים?",$data['have_add_favi'],"data_arr[have_add_favi]", "class='input_style'"),
		array("select","have_rightMenuButton[]",$have_rightMenuButton,"להציג כפתורים בתפריט הימני?",$data['have_rightMenuButton'],"data_arr[have_rightMenuButton]", "class='input_style'"),
		array("select","have_google_search[]",$have_google_search,"להציג תיבת חיפוש גוגל?",$data['have_google_search'],"data_arr[have_google_search]", "class='input_style'"),
		array("select","have_newsletterForm[]",$have_newsletterForm,"טופס ניוזלטר בתפריט",$data['have_newsletterForm'],"data_arr[have_newsletterForm]", "class='input_style'"),
		array("select","have_searchEng[]",$have_searchEng,"תיבת חיפוש מוצגת",$data['have_searchEng'],"data_arr[have_searchEng]", "class='input_style'"),
		array("select","advBannerOrder[]",$advBannerOrder,"באנר ימני יופיע?",$data['advBannerOrder'],"data_arr[advBannerOrder]", "class='input_style'"),
		array("select","scrollNewsOrder[]",$scrollNewsOrder,"חלון מבזקים יופיע?",$data['scrollNewsOrder'],"data_arr[scrollNewsOrder]", "class='input_style'"),
		array("select","have_scrollNewsImgs[]",$user_extra__have_scrollNewsImgs,"עיצוב חלון מבזקים",$user_extra_settings['have_scrollNewsImgs'],"have_scrollNewsImgs", "class='input_style'"),
		array("select","place_calender_events[]",$place_calender_events,"מיקום לוח השנה בתפריט",$data['place_calender_events'],"data_arr[place_calender_events]", "class='input_style'"),
		
		
		
		array("blank","<br><br><b style='font-size:17px;'>הגדרות גלריה</b>"),
		array("select","flex_gallery[]",$flex_gallery,"גלרית פלאש",$data['flex_gallery'],"data_arr[flex_gallery]", "class='input_style'"),
		array("select","have_extraL_img_gl[]",$have_extraL_img_gl,"אפשרות לעלות תמונה ענקית",$data['have_extraL_img_gl'],"data_arr[have_extraL_img_gl]", "class='input_style'"),
		array("select","flex_galleryType[]",$flex_galleryType,"סוג הגלריה",$data['flex_galleryType'],"data_arr[flex_galleryType]", "class='input_style'"),
		
		array("blank","** במידה ובוחרים כן, יש לסמן מידות לתמונה הקטנה והגדולה להלן המידות שיש לכתוב:<br>
		תמונה קטנה: גובה ורוחב: 95<br>
		תמונה גדולה: גובה- 460, רוחב- 550<br>
		***במידה ובוחרים גלריה בסיסית ללא קטגוריות, המידות הן:<br>
		תמונה קטנה: גובה ורוחב: 58<br>
		תמונה גדולה: גובה: 600 רוחב: 320<br>
		
		כמו כן יש לבחור עיצוב בקישור <a href='http://examples.adobe.com/flex2/consulting/styleexplorer/Flex2StyleExplorer.html' target='_blank' class='maintext'>הזה</a> ולהעתיק את הקוד לקישור לשדה: עיצוב CSS גלרית פלקס, יש תחילה לקבל הוראות שימוש מפי"),
		
		array("textarea","data_arr[flex_gallery_css]",$data['flex_gallery_css'],"עיצוב CSS גלרית פלקס", "dir='ltr' class='input_style' style='height:100px'"),
		
		array("text","data_arr[gall_sm_pic_height]",$data['gall_sm_pic_height'],"תמונה קטנה גובה מקסימום", "class='input_style'","","1"),
		array("text","data_arr[gall_sm_pic_width]",$data['gall_sm_pic_width'],"תמונה קטנה רוחב מקסימום", "class='input_style'","","1"),
		
		array("text","data_arr[gall_lr_pic_height]",$data['gall_lr_pic_height'],"תמונה גדולה גובה מקסימום", "class='input_style'","","1"),
		array("text","data_arr[gall_lr_pic_width]",$data['gall_lr_pic_width'],"תמונה גדולה רוחב מקסימום", "class='input_style'","","1"),
		
		
		
		array("submit","submit","שמירה", "class='submit_style'")
	);
	
// שדות חובה
$mandatory_fields = array("data_arr[username]","data_arr[password]","data_arr[full_name]","data_arr[name]","data_arr[email]","data_arr[phone]");
$more = "class='maintext'";

echo "<table border=\"0\" cellspacing=\"0\" cellpadding=\"0\" class=\"maintext\">";
		
		echo "<tr>";
			echo "<td colspan=3><A href=\"?&sesid=".SESID."\" class=\"maintext\">חזרה לתפריט הראשי</a></td>";
		echo "</tr>";
		
		echo "<tr><td height=\"7\" colspan=3></td></tr>";
		echo "<tr>";
			echo "<td colspan=3><A href=\"?main=users_list&sesid=".SESID."\" class=\"maintext\">לרשימת האתרים</a></td>";
		echo "</tr>";
		
		if( $data['have_ilbiz_net'] == "1" && AUTH >= 8 )
		{
			echo "<tr><td colspan=3 height=\"15\"></td></tr>";
			echo "<tr>";
				echo "<td colspan=3><A href=\"?main=users_dynamic_net_form&unk=".$_REQUEST['unk']."&sesid=".SESID."\" class=\"maintext\">הוספת שדות לטופס הרשמה - מועדון לקוחות</a></td>";
			echo "</tr>";
			echo "<tr><td colspan=3 height=\"15\"></td></tr>";
			echo "<tr>";
				echo "<td colspan=3><A onclick='return confirm(\"האם אתה בטוח שברצונך לייצא את כל משתמשי האתר אל מערכת הדיוור של 10service.co.il?\");' href=\"?main=net_system&scope=net_list_import&from_unk=".$_REQUEST['unk']."&sesid=".SESID."\" class=\"maintext\">ייצוא משתמשי דיוור לאתר sherut10.co.il</a></td>";
			echo "</tr>";
		}
		
		if( AUTH >= 3 )
		{
		echo "<tr>";
			echo "<td colspan=3><A href=\"?main=user_lead_settings&unk=".$_REQUEST['unk']."&sesid=".SESID."\" class=\"maintext\">הגדרות לידים</a></td>";
		echo "</tr>";
		
		
		echo "<tr>";
			echo "<td colspan=3><A href=\"?main=manage_user_e_card_icons&unk=".$_REQUEST['unk']."&record_id=".$_REQUEST['record_id']."&sesid=".SESID."\" class=\"maintext\">הגדרות כרטיס 10CARD</a></td>";
		echo "</tr>";
				
		echo "<tr>";
			echo "<td colspan=3><A href=\"?main=portal_settings&unk=".$_REQUEST['unk']."&record_id=".$data['id']."&sesid=".SESID."\" class=\"maintext\">הגדרות פורטל</a></td>";
		echo "</tr>";		
		}
		
		if( AUTH >= 8 )
		{
		echo "<tr><td colspan=3 height=\"15\"></td></tr>";
		echo "<tr>";
			echo "<td colspan=3><A href=\"?main=launch_fee_to_client&unk=".$_REQUEST['unk']."&sesid=".SESID."\" class=\"maintext\" target='_blank'>שגר תשלום</a></td>";
		echo "</tr>";
		}
		
		echo "<tr><td colspan=3 height=\"11\"></td></tr>";
		
		echo "<tr>";
			echo "<td valign=top>".FormCreator::create_form($form_arr,"index.php", $more, $mandatory_fields)."</td>";
			echo "<td width=50></td>";
			echo "<td valign=top>";
				echo "<div id='user_phones_wrap' class='user_phones_wrap_front'>";
					echo "<h2>שיוך מספרי טלפון ללקוח</h2>";
					if(isset($_POST['add_user_phone'])){
						$phone_check_sql = "SELECT * FROM users_phones WHERE phone = '".$_POST['phone']."'";
						$phone_check_res = mysql_db_query(DB,$phone_check_sql);
						$phone_check_data = mysql_fetch_array($phone_check_res);
						if(isset($phone_check_data['unk'])){
							echo "<h5 style='color:green'>מספר זה כבר משוייך ללקוח אחר.</h5>";
							$phone_user_sql = "SELECT id FROM users WHERE unk = '".$phone_check_data['unk']."'";
							$phone_user_res = mysql_db_query(DB,$phone_user_sql);
							$phone_user_data = mysql_fetch_array($phone_user_res);
							$edit_url = "https://ilbiz.co.il/site-admin/index.php?main=user_profile&unk=".$phone_check_data['unk']."&record_id=".$phone_user_data['id']."&sesid=".SESID;
							echo "<a target='blank' href='".$edit_url."'>לחץ כאן לצפייה בלקוח</a>";
						}
						else{
							$add_phone_sql = "INSERT INTO users_phones (
							unk,
							phone,
							campaign_type,
							campaign_name,
							bill_normal,
							misscall_return_sms,
							answeredcall_return_sms,
							misscall_return_sms_txt,
							answeredcall_return_sms_txt) 
							
							values('".$_POST['unk']."', 
							'".$_POST['phone']."', 
							'".$_POST['campaign_type']."', 
							'".$_POST['campaign_name']."', 
							'".$_POST['bill_normal']."', 
							'".$_POST['misscall_return_sms']."', 
							'".$_POST['answeredcall_return_sms']."', 
							'".str_replace("'","''",$_POST['misscall_return_sms_txt'])."', 
							'".str_replace("'","''",$_POST['answeredcall_return_sms_txt'])."')";
							$add_phone_res = mysql_db_query(DB,$add_phone_sql);
							echo "<h5 style='color:green'>המספר נוסף בהצלחה</h5>";
						}
					}
					if(isset($_POST['update_user_phone'])){
						$update_phone_sql = "
							UPDATE users_phones SET
							campaign_type = '".$_POST['campaign_type']."',
							campaign_name = '".$_POST['campaign_name']."',
							bill_normal = '".$_POST['bill_normal']."',
							misscall_return_sms = '".$_POST['misscall_return_sms']."',
							answeredcall_return_sms = '".$_POST['answeredcall_return_sms']."',
							misscall_return_sms_txt = '".str_replace("'","''",$_POST['misscall_return_sms_txt'])."',
							answeredcall_return_sms_txt = '".$_POST['answeredcall_return_sms_txt']."'
							WHERE unk = '".$_POST['unk']."'
							AND id = '".$_POST['update_user_phone']."'
						
						";
						$update_phone_res = mysql_db_query(DB,$update_phone_sql);
						echo "<h5 style='color:green'>המספר עודכן בהצלחה</h5>";
					}
					if(isset($_POST['delete_user_phone'])){
						$delete_phone_sql = "DELETE FROM users_phones WHERE unk = '".$_POST['unk']."' AND phone = '".$_POST['delete_user_phone']."'";
						$delete_phone_res = mysql_db_query(DB,$delete_phone_sql);
						echo "<h5 style='color:red'>המספר נמחק</h5>";
					}					
					echo "<h3><a href='javascript://' onclick='show_user_phones_list()'>הצג רשימת מספרים קיימים ללקוח<a></h3>";
					echo "<div>";
						echo "<form method='post' action='?main=user_profile&unk=".$_REQUEST['unk']."&record_id=".$data['id']."&sesid=".SESID."'>";
							echo "<input type='hidden' name='add_user_phone' value='1' />";
							echo "<b style='font-size:15px;'>הוסף מספר חדש</b>:<br/><input type='text' name='phone' value='' /><br/>";
							echo "שיוך לקמפיין:<br/>
								<select name='campaign_type' />
									<option value='0'>ללא שיוך לקמפיין</option>
									<option value='1'>גוגל</option>
									<option value='2'>פייסבוק</option>
								</select><br/>
							";
							echo "שם קמפיין:<br/><input type='text' name='campaign_name' value='' /><br/><br/>";
							echo "חייב בליד לאחר שיחה:<br/>
								<select name='bill_normal' />
									<option value='1' selected>כן</option>
									<option value='0'>לא</option>
								</select><br/><br/>
							";
							echo "החזר הודעת טקסט בלא מענה:<br/>
								<select name='misscall_return_sms' />
									<option value='0' selected>לא</option>
									<option value='1'>כן</option>
								</select><br/>
							";	
							echo "הודעת טקסט:<br/><textarea name='misscall_return_sms_txt'></textarea><br/><br/>";

							echo "החזר הודעת טקסט <b>אחרי</b> מענה:<br/>
								<select name='answeredcall_return_sms' />
									<option value='0' selected>לא</option>
									<option value='1'>כן</option>
								</select><br/>
							";	
							echo "הודעת טקסט:<br/><textarea name='answeredcall_return_sms_txt'></textarea><br/><br/>";
							
							echo "<input type='hidden' name='unk' value='".$_REQUEST['unk']."' />";
							echo "<input type='submit' value='שלח' />";
						echo "</form>";
					echo "</div>";	
					$phones_sql = "select * from users_phones where unk = '".$_REQUEST['unk']."'";
					$phones_res = mysql_db_query(DB,$phones_sql);					
					
					$has_phones = false;
					echo "<div id='user_phones_table' class='user_phones_table_hidden'>";
					echo "<div style='float:left;'><a href='javascript://' onclick='close_user_phone_list()'>סגור</a></div>";
					echo "<h3 style='clear:both;'>רשימת מספרים קיימים ללקוח</h3>";
					echo "<table cellpadding='5' border='1'>";
					echo "<tr>";
						echo "<td>מספר</td>";
						echo "<td>סוג קמפיין</td>";
						echo "<td>שם קמפיין</td>";
						echo "<td>חיוב שיחה בליד</td>";
						echo "<td>החזר הודעת טקסט בלא מענה</td>";
						echo "<td>הודעת טקסט</td>";
						echo "<td>החזר הודעת טקסט לאחר מענה</td>";
						echo "<td>הודעת טקסט</td>";						
						echo "<td>";
						echo "</td>";
						echo "<td>";
						echo "</td>";						
					echo "</tr>";
					$user_phones_arr = array();
					while($phones_data = mysql_fetch_array($phones_res)){
						$user_phones_arr[$phones_data['id']] = $phones_data;
						$has_phones = true;
						$campaign_str = "ללא קמפיין";
						if($phones_data['campaign_type'] == '1'){
							$campaign_str = "קמפיין גוגל";
						}
						if($phones_data['campaign_type'] == '2'){
							$campaign_str = "קמפיין פייסבוק";
						}
						$bill_str = "כן";
						if($phones_data['bill_normal'] == '0'){
							$bill_str = "לא";
						}
						$misscall_return_sms_str = "לא";
						if($phones_data['misscall_return_sms'] == '1'){
							$misscall_return_sms_str = "כן";
						}
						$answeredcall_return_sms_str = "לא";
						if($phones_data['answeredcall_return_sms'] == '1'){
							$answeredcall_return_sms_str = "כן";
						}						
						echo "<tr>";
							echo "<td>".$phones_data['phone']."</td>";
							echo "<td>".$campaign_str."</td>";
							echo "<td>".$phones_data['campaign_name']."</td>";
							echo "<td>".$bill_str."</td>";
							echo "<td>".$misscall_return_sms_str."</td>";
							echo "<td>".nl2br($phones_data['misscall_return_sms_txt'])."</td>";
							echo "<td>".$answeredcall_return_sms_str."</td>";
							echo "<td>".nl2br($phones_data['answeredcall_return_sms_txt'])."</td>";							
							echo "<td>";
								echo "<a href='javascript://' onclick='open_phone_editor(".$phones_data['id'].")'>ערוך מספר<a/>";
							echo "</td>";
							echo "<td>";
							echo "<form method='post' action='?main=user_profile&unk=".$_REQUEST['unk']."&record_id=".$data['id']."&sesid=".SESID."'>";
								echo "<input type='hidden' name='delete_user_phone' value='".$phones_data['phone']."' />";
								echo "<input type='hidden' name='unk' value='".$_REQUEST['unk']."' />";
								echo "<input type='submit' value='מחק מספר' />";
							echo "</form>";
							echo "</td>";
						echo "</tr>";
					}
					echo "</table></div>";
					?>
					<div style="display:none" id ="user_phone_editors_box">
					<?php 
					foreach($user_phones_arr as $user_phone){
						?>
							
								<div id="user_phone_editor_<?php echo $user_phone['id']; ?>">
									<div style="float:left;"><a href="javascript://" onclick="close_user_phone_editor(<?php echo $user_phone['id']; ?>)">ביטול</a></div>
									<h3 style="clear:both;">עריכת מספר טלפון</h3>
									
									<?php
										echo "<form method='post' action='?main=user_profile&unk=".$_REQUEST['unk']."&record_id=".$data['id']."&sesid=".SESID."'>";
											echo "<input type='hidden' name='update_user_phone' value='".$user_phone['id']."' />";
											echo "מספר:<br/>".$user_phone['phone']."<br/>";
											$campaign_type_selected = array('0'=>'','1'=>'','2'=>'');
											$campaign_type_selected[$user_phone['campaign_type']] = 'selected';
											echo "שיוך לקמפיין:<br/>
												<select name='campaign_type' />
													<option value='0' ".$campaign_type_selected['0'].">ללא שיוך לקמפיין</option>
													<option value='1' ".$campaign_type_selected['1'].">גוגל</option>
													<option value='2' ".$campaign_type_selected['2'].">פייסבוק</option>
												</select><br/>
											";
											echo "שם קמפיין:<br/><input type='text' name='campaign_name' value='".$user_phone['campaign_name']."' /><br/><br/>";
											$bill_normal_selected = array('0'=>'','1'=>'');
											$bill_normal_selected[$user_phone['bill_normal']] = 'selected';
											echo "חייב בליד לאחר שיחה:<br/>
												<select name='bill_normal' />
													<option value='1' ".$bill_normal_selected['1'].">כן</option>
													<option value='0' ".$bill_normal_selected['0'].">לא</option>
												</select><br/><br/>
											";
											$misscall_return_sms_selected = array('0'=>'','1'=>'');
											$misscall_return_sms_selected[$user_phone['misscall_return_sms']] = 'selected';
											echo "החזר הודעת טקסט בלא מענה:<br/>
												<select name='misscall_return_sms' />
													<option value='0' ".$misscall_return_sms_selected['0'].">לא</option>
													<option value='1' ".$misscall_return_sms_selected['1'].">כן</option>
												</select><br/>
											";	
											echo "הודעת טקסט:<br/><textarea name='misscall_return_sms_txt'>".$user_phone['misscall_return_sms_txt']."</textarea><br/><br/>";											

											$answeredcall_return_sms_selected = array('0'=>'','1'=>'');
											$answeredcall_return_sms_selected[$user_phone['answeredcall_return_sms']] = 'selected';
											echo "החזר הודעת טקסט אחרי מענה:<br/>
												<select name='answeredcall_return_sms' />
													<option value='0' ".$answeredcall_return_sms_selected['0'].">לא</option>
													<option value='1' ".$answeredcall_return_sms_selected['1'].">כן</option>
												</select><br/>
											";	
											echo "הודעת טקסט:<br/><textarea name='answeredcall_return_sms_txt'>".$user_phone['answeredcall_return_sms_txt']."</textarea><br/><br/>";											
											
											
											echo "<input type='hidden' name='unk' value='".$_REQUEST['unk']."' />";
											echo "<input type='submit' value='שלח' />";
										echo "</form>";
									?>
								</div>
							
						<?
					}
					?>
					</div>
					<div style="display:none" id="phone_editor_placeholder">
					
					</div>
					<style type="text/css">
						#phone_editor_placeholder{
							position: fixed;
							left: 70px;
							top: 56px;
							background: white;
							padding: 25px;
							border: 1px solid black;
							z-index: 201;
							box-shadow: 5px 7px 6px grey;
						}
						.user_phones_table_float{
							position: fixed;
							left: 100px;
							top: 20px;
							background: white;
							padding: 10px;
							border: 1px solid black;
							z-index: 200;
							box-shadow: 5px 7px 6px grey;
							max-width: 85%;
							max-height: 80%;
							overflow: auto;
						}
						.user_phones_table_hidden{
							display:none;
						}
					</style>
						<script type="text/javascript">
							var user_phones_arr = <?php echo json_encode($user_phones_arr); ?>;
							function open_phone_editor(phone_id){
								jQuery("#user_phone_editor_" + phone_id).appendTo("#phone_editor_placeholder");
								jQuery("#phone_editor_placeholder").show();
								
								alert("under construction..");
							}
							function show_user_phones_list(){
								jQuery("#user_phones_table").addClass("user_phones_table_float");
								jQuery("#user_phones_table").removeClass("user_phones_table_hidden");
							}
							function close_user_phone_editor(phone_id){
								jQuery("#user_phone_editor_" + phone_id).appendTo("#user_phone_editors_box");
								jQuery("#phone_editor_placeholder").hide();
							}
							function close_user_phone_list(){
								jQuery("#user_phones_table").addClass("user_phones_table_hidden");
								jQuery("#user_phones_table").removeClass("user_phones_table_float");
							}
						</script>
					<?php
					if(!$has_phones){
						echo "<h5 style='color:red;'>אין מספרים</h5>";
					}
				echo "</div>";
				
				/*- net_banners start -*/
				$net_banners_list_by_name = array();
				$net_banners_list_by_id = array();
				$net_banners_list_sql = "SELECT id,banner_name FROM net_clients_banners ORDER BY banner_name";
				$net_banners_list_res = mysql_db_query(DB,$net_banners_list_sql);
				while($banners_data = mysql_fetch_array($net_banners_list_res)){
					$banners_data['selected_str'] = "";
					$net_banners_list_by_name[$banners_data['banner_name']] = $banners_data;
					$net_banners_list_by_id[$banners_data['id']] = $banners_data;
				}
				function create_net_clients_banners_select_box($net_banners_list, $selected = '0'){
					echo "<select name='banner_id' />";
						foreach($net_banners_list as $net_banner){
							if($net_banner['id'] == $selected){
								$net_banner['selected_str'] = "selected"; 
							}
							echo "<option value='".$net_banner['id']."' ".$net_banner['selected_str'].">".$net_banner['banner_name']."</option>";
						}
					echo "		
						</select><br/>
					";	
				}
				echo "<div id='user_banners_wrap' class='user_bannert_wrap_front'>";
					echo "<h2>שיוך באנרים מרשת אייל ביז</h2>";
					if(isset($_POST['add_user_banner'])){
						$add_banner_sql = "INSERT INTO net_clients_banner_user (user_id,banner_id) values('".$_POST['user_id']."', '".$_POST['banner_id']."')";
						$add_banner_res = mysql_db_query(DB,$add_banner_sql);
						echo "<h5 style='color:green'>השיוך לבאנר נוסף בהצלחה</h5>";
					}
					if(isset($_POST['update_user_banner'])){
						$update_banner_sql = "
							UPDATE net_clients_banner_user SET
							user_id = '".$_POST['user_id']."',
							banner_id = '".$_POST['banner_id']."'
							WHERE user_id = '".$_POST['user_id']."'
							AND id = '".$_POST['update_user_banner']."'
						
						";
						$update_banner_res = mysql_db_query(DB,$update_banner_sql);
						echo "<h5 style='color:green'>השיוך לבאנר עודכן בהצלחה</h5>";
					}
					if(isset($_POST['delete_user_banner'])){
						$delete_banner_sql = "DELETE FROM net_clients_banner_user WHERE user_id = '".$_POST['user_id']."' AND id = '".$_POST['delete_user_banner']."'";
						$delete_banner_res = mysql_db_query(DB,$delete_banner_sql);
						echo "<h5 style='color:red'>השיוך לבאנר נמחק</h5>";
					}					
					
					echo "<div>";
						echo "<form method='post' action='?main=user_profile&unk=".$_REQUEST['unk']."&record_id=".$data['id']."&sesid=".SESID."'>";
							echo "<input type='hidden' name='add_user_banner' value='1' />";
							echo "<b style='font-size:15px;'>הוסף שיוך חדש</b>:<br/>";
							create_net_clients_banners_select_box($net_banners_list_by_name);
							"<br/>";
							echo "<input type='hidden' name='user_id' value='".$data['id']."' />";
							echo "<input type='submit' value='שלח' />";
						echo "</form>";
					echo "</div>";	
					$banners_sql = "select * from net_clients_banner_user where user_id = '".$data['id']."'";
					$banners_res = mysql_db_query(DB,$banners_sql);					
					
					$has_banners = false;
					echo "<div id='user_banners_table' class='user_banners_table_hidden'>";
					echo "<div style='float:left;'><a href='javascript://' onclick='close_user_banner_list()'>סגור</a></div>";
					echo "<h3 style='clear:both;'>רשימת באנרים משוייכים ללקוח</h3>";
					echo "<table cellpadding='5' border='1'>";
					echo "<tr>";
						echo "<td>מספר הבאנר</td>";
						echo "<td>שם הבאנר</td>";	
						echo "<td>";
						echo "</td>";
						echo "<td>";
						echo "</td>";						
					echo "</tr>";
					$user_banners_arr = array();
					while($user_banner = mysql_fetch_array($banners_res)){
						$user_banners_arr[$user_banner['id']] = $user_banner;
						$has_banners = true;
						
						echo "<tr>";
							echo "<td>".$user_banner['id']."</td>";
							echo "<td>".$net_banners_list_by_id[$user_banner['banner_id']]['banner_name']."</td>";
							echo "<td>";
								echo "<a href='javascript://' onclick='open_banner_editor(".$user_banner['id'].")'>ערוך שיוך<a/>";
							echo "</td>";
							echo "<td>";
							echo "<form method='post' action='?main=user_profile&unk=".$_REQUEST['unk']."&record_id=".$data['id']."&sesid=".SESID."'>";
								echo "<input type='hidden' name='delete_user_banner' value='".$user_banner['id']."' />";
								echo "<input type='hidden' name='user_id' value='".$data['id']."' />";
								echo "<input type='submit' value='מחק שיוך' />";
							echo "</form>";
							echo "</td>";
						echo "</tr>";
					}
					echo "</table></div>";
					?>
					<div style="display:none" id ="user_banner_editors_box">
					<?php 
					foreach($user_banners_arr as $user_banner){
						
						?>
							
								<div id="user_banner_editor_<?php echo $user_banner['id']; ?>">
									<div style="float:left;"><a href="javascript://" onclick="close_user_banner_editor(<?php echo $user_banner['id']; ?>)">ביטול</a></div>
									<h3 style="clear:both;">עריכת שיוך באנר ללקוח</h3>
									<?php
										echo "<form method='post' action='?main=user_profile&unk=".$_REQUEST['unk']."&record_id=".$data['id']."&sesid=".SESID."'>";
											echo "<input type='hidden' name='update_user_banner' value='".$user_banner['id']."' />";
											echo "באנר:<br/>";
											create_net_clients_banners_select_box($net_banners_list_by_name,$user_banner['banner_id']);
											"<br/>";
											echo "<input type='hidden' name='user_id' value='".$data['id']."' />";
											echo "<input type='submit' value='שלח' />";
										echo "</form>";
									?>
								</div>
							
						<?
					}
					?>
					</div>
					<div style="display:none" id="banner_editor_placeholder">
					
					</div>
					<style type="text/css">
						#user_banners_wrap{
							background:#eaeab1;
							border:1px solid black;
							margin:5px;
							padding:5px;
							
						}
						#banner_editor_placeholder{
							position: fixed;
							left: 70px;
							top: 56px;
							background: white;
							padding: 25px;
							border: 1px solid black;
							z-index: 201;
							box-shadow: 5px 7px 6px grey;
						}
						.user_banners_table_float{
							position: fixed;
							left: 100px;
							top: 20px;
							background: white;
							padding: 10px;
							border: 1px solid black;
							z-index: 200;
							box-shadow: 5px 7px 6px grey;
							max-width: 85%;
							max-height: 80%;
							overflow: auto;
						}
						.user_banners_table_hidden{
							display:none;
						}
					</style>
						<script type="text/javascript">
							function open_banner_editor(banner_id){
								jQuery("#user_banner_editor_" + banner_id).appendTo("#banner_editor_placeholder");
								jQuery("#banner_editor_placeholder").show();
							}
							function show_user_banners_list(){
								jQuery("#user_banners_table").addClass("user_banners_table_float");
								jQuery("#user_banners_table").removeClass("user_banners_table_hidden");
							}
							function close_user_banner_editor(banner_id){
								jQuery("#user_banner_editor_" + banner_id).appendTo("#user_banner_editors_box");
								jQuery("#banner_editor_placeholder").hide();
							}
							function close_user_banner_list(){
								jQuery("#user_banners_table").addClass("user_banners_table_hidden");
								jQuery("#user_banners_table").removeClass("user_banners_table_float");
							}
						</script>
					<?php
					if(!$has_banners){
						echo "<h5 style='color:red;'>לא משייכים באנרים</h5>";
					}
					else{
						echo "<h3><a href='javascript://' onclick='show_user_banners_list()'>הצג רשימת שיוכים לבאנר קיימים ללקוח<a></h3>";
					}
				echo "</div>";			
				
				/*- net banners end -*/ 
				echo "<div>";
					userSiteProfileLeftSide();
				echo "</div>";
			echo "</td>";
		echo "</tr>";
		
		
	echo "</table>";
}
/********************************************************************************************************/

function new_DB_profile()	{

	$data_arr = ($_POST['data_arr'])? $_POST['data_arr'] : $_GET['data_arr'];
	
	if( $data_arr['username'] == "" )
	{
		echo "<script>alert('לא ניתן לשמור את הרשומה, חסר שם משתמש');</script>";
		echo "<script>window.location.href='javascript:history(-1)';</script>";
			exit;
	}
	if( $data_arr['password'] == "" )
	{
		echo "<script>alert('לא ניתן לשמור את הרשומה, חסר סיסמא');</script>";
		echo "<script>window.location.href='javascript:history(-1)';</script>";
			exit;
	}
	
	if( $data_arr['domain'] == "" )
	{
		$qry = "SELECT username, domain from users where username = '".$data_arr['username']."' ";
		$res = mysql_db_query(DB,$qry);
		$data_check = mysql_fetch_array($res);
		
		if( $data_check['username'] == $data_arr['username'] )
		{
			echo "<script>alert('שם משתמש קיים במערכת');</script>";
			echo "<script>window.location.href='javascript:history.back(-1);'</script>";
				exit;
		}
	}
	else
	{
		$qry = "SELECT username, domain from users where username = '".$data_arr['username']."' OR domain = '".$data_arr['domain']."' ";
		$res = mysql_db_query(DB,$qry);
		$data_check = mysql_fetch_array($res);
		
		if( $data_check['username'] == $data_arr['username'] || ( $data_check['domain'] == $data_arr['domain'] && $data_check['domain'] != '' ) )
		{
			echo "<script>alert('שם משתמש או דומיין קיימים במערכת');</script>";
			echo "<script>window.location.href='javascript:history.back(-1);'</script>";
				exit;
		}
	}
		
	if($data_arr['status'] == "0" &&  $data_arr['domain'] != '' )	{
		include('build_settings_file.php');
	}
	
	
	$sql = "insert into user_site_settings (unk) values ( '".$data_arr['unk']."' )";
	$res = mysql_db_query(DB,$sql);
	
	

	$image_settings = array(
		after_success_goto=>"DO_NOTHING",
		table_name=>"users",
		flip_date_to_original_format=>array("birthday" , "end_date" , "insert_date"),
	);
	insert_to_db($data_arr, $image_settings);
	
	
	$form_arr_user_extra_settings = array(
		have_topSliceHtml => "have_topSliceHtml", 
		have_BottomSliceHtml => "have_BottomSliceHtml",
		have_scrollNewsImgs => "have_scrollNewsImgs",
		userCanSEO => "userCanSEO",
		have_jobImgs => "have_jobImgs",
		netMaxSendMail => "netMaxSendMail",
		havaKidomBottomLink => "havaKidomBottomLink",
		haveSmsDiscount => "haveSmsDiscount",
		estimateSite => "estimateSite",
		estimateSiteCat => "estimateSiteCat",
		estimateSiteTatCat => "estimateSiteTatCat",
		estimateTopTitle => "estimateTopTitle",
		belongTo10service => "belongTo10service",
		have10serviceMinisite => "have10serviceMinisite",
		domainGoto10serviceMinisite => "domainGoto10serviceMinisite",
		
		labor_agreement => "labor_agreement",
		down_payment => "down_payment",
		option_ticket_at_invoice => "option_ticket_at_invoice",
		have_site_feature => "have_site_feature",
		add_links_to_search_eng => "add_links_to_search_eng",
		teaching_client => "teaching_client",
		end_site_payment_collection => "end_site_payment_collection",
		
		have_noindex => "have_noindex",
		have_share_button => "have_share_button",
		haveFacebookComments => "haveFacebookComments",
		haveFacebookHpActive => "haveFacebookHpActive",
		
		wibiyaAnalytics => "wibiyaAnalytics",
		haveLandingPage => "haveLandingPage",
		maxLandingPage => "maxLandingPage",
		haveMailingNet => "haveMailingNet",
		contactThanksPixel => "contactThanksPixel",
		contactThanksUrlRedirect => "contactThanksUrlRedirect",
		facebookPageId => "facebookPageId",
		indexSite => "indexSite",
		centered_contact => "centered_contact",
		remartiking_code => "remartiking_code",
		zopim_script => "zopim_script",
		nisha_sites => "nisha_sites",
		dogs4u_chooser_shop => "dogs4u_chooser_shop",
		user_adsense_instead_esti_form => "user_adsense_instead_esti_form",
		have_realty => "have_realty",
		have_contracts => "have_contracts",
		free_text => "free_text",
	);
	
	
	$counter1 = 1;
		$sql = "update user_extra_settings set ";
		foreach( $form_arr_user_extra_settings as $val => $key )	{
			$with_psik = ( $counter1 == sizeof($form_arr_user_extra_settings) ) ? " " : ", ";
			if( $val == "nisha_sites" )
				$sql .= $val." = '".json_encode($_REQUEST[$key])."'".$with_psik;
			else
				$sql .= $val." = '".$_REQUEST[$key]."'".$with_psik;
			$counter1++;
		}
		$sql .= "where unk = '".$_REQUEST['unk']."' limit 1";
		$res = mysql_db_query(DB,$sql);
	
	
	$sql = "INSERT INTO user_bookkeeping (unk) VALUES ('".$_REQUEST['unk']."') ";
	$res = mysql_db_query(DB,$sql);
	
	$form_arr_user_bookkeeping = array(
		hostPriceMon => "hostPriceMon", 
		domainEndDate => "domainEndDate",
		domainPrice => "domainPrice",
	);
	
	$counter1 = 1;
		$sql = "update user_bookkeeping set ";
		foreach( $form_arr_user_bookkeeping as $val => $key )	{
			$with_psik = ( $counter1 == sizeof($form_arr_user_bookkeeping) ) ? " " : ", ";
			$sql .= $val." = '".$_REQUEST[$key]."'".$with_psik;
			$counter1++;
		}
		$sql .= "where unk = '".$_REQUEST['unk']."' limit 1";
		$res = mysql_db_query(DB,$sql);
	
	
	labor_agreement_file_func();
	
	
	echo "<META HTTP-EQUIV=Refresh CONTENT=\"0; URL=?main=users_list&sesid=".SESID."\">";
}


/********************************************************************************************************/

function update_DB_profile()	{

	$data_arr = ($_POST['data_arr'])? $_POST['data_arr'] : $_GET['data_arr'];
	$user_extra_arr = ($_POST['user_extra_arr'])? $_POST['user_extra_arr'] : $_GET['user_extra_arr'];
	
	if( $data_arr['username'] == "" )
	{
		echo "<script>alert('לא ניתן לשמור את הרשומה, חסר שם משתמש');</script>";
		echo "<script>window.location.href='javascript:history(-1)';</script>";
			exit;
	}
	if( $data_arr['password'] == "" )
	{
		echo "<script>alert('לא ניתן לשמור את הרשומה, חסר סיסמא');</script>";
		echo "<script>window.location.href='javascript:history(-1)';</script>";
			exit;
	}
	
	if( $data_arr['domain'] != '' )
	{
		$qry = "SELECT username, domain from users where ( username = '".$data_arr['username']."' OR domain = '".$data_arr['domain']."') AND id != '".$_POST['record_id']."' ";
		$res = mysql_db_query(DB,$qry);
		$data_check = mysql_fetch_array($res);
		
		if( $data_check['username'] == $data_arr['username'] || ( $data_check['domain'] == $data_arr['domain'] && $data_check['domain'] != '' ) )
		{
			echo "<script>alert('שם משתמש או דומיין קיימים במערכת');</script>";
			echo "<script>window.location.href='javascript:history.back(-1);'</script>";
				exit;
		}
	}
	else
	{
		$qry = "SELECT username, domain from users where username = '".$data_arr['username']."' AND id != '".$_POST['record_id']."' ";
		$res = mysql_db_query(DB,$qry);
		$data_check = mysql_fetch_array($res);
		
		if( $data_check['username'] == $data_arr['username'] )
		{
			echo "<script>alert('שם משתמש קיים במערכת');</script>";
			echo "<script>window.location.href='javascript:history.back(-1);'</script>";
				exit;
		}
	}
	
	if($data_arr['status'] == "0" &&  $data_arr['domain'] != '' )	{
		include('build_settings_file.php');
	}
	
	
	$check_sql = "SELECT unk FROM user_extra_settings WHERE unk = '".$_POST['unk']."' ";
	$check_res = mysql_db_query($check_sql);
	$check_unk_extra = mysql_fetch_array($check_res);
	
	if( $check_unk_extra['unk'] != $_POST['unk'] )
	{
		$sql = "insert into user_extra_settings (unk) values ( '".$data_arr['unk']."' )";
		$res = mysql_db_query(DB,$sql);
	}
	
	$_REQUEST['end_date'] = trim($_REQUEST['end_date']);
	$_REQUEST['birthday'] = trim($_REQUEST['birthday']);
	$_REQUEST['insert_date'] = trim($_REQUEST['insert_date']);
	$_POST['end_date'] = trim($_POST['end_date']);
	$_POST['birthday'] = trim($_POST['birthday']);
	$_POST['insert_date'] = trim($_POST['insert_date']);

	$image_settings = array(
		after_success_goto=>"DO_NOTHING",
		table_name=>"users",
		flip_date_to_original_format=>array("birthday" , "end_date" , "insert_date" ),
	);
	update_db($data_arr, $image_settings);
	
	
	$form_arr_user_extra_settings = array(
		have_topSliceHtml => "have_topSliceHtml", 
		have_BottomSliceHtml => "have_BottomSliceHtml",
		have_scrollNewsImgs => "have_scrollNewsImgs",
		userCanSEO => "userCanSEO",
		have_jobImgs => "have_jobImgs",
		netMaxSendMail => "netMaxSendMail",
		havaKidomBottomLink => "havaKidomBottomLink",
		haveSmsDiscount => "haveSmsDiscount",
		estimateSite => "estimateSite",
		estimateSiteCat => "estimateSiteCat",
		estimateSiteTatCat => "estimateSiteTatCat",
		estimateTopTitle => "estimateTopTitle",
		belongTo10service => "belongTo10service",
		have10serviceMinisite => "have10serviceMinisite",
		domainGoto10serviceMinisite => "domainGoto10serviceMinisite",
		
		labor_agreement => "labor_agreement",
		down_payment => "down_payment",
		option_ticket_at_invoice => "option_ticket_at_invoice",
		have_site_feature => "have_site_feature",
		add_links_to_search_eng => "add_links_to_search_eng",
		teaching_client => "teaching_client",
		end_site_payment_collection => "end_site_payment_collection",
		
		have_noindex => "have_noindex",
		have_share_button => "have_share_button",
		haveFacebookComments => "haveFacebookComments",
		haveFacebookHpActive => "haveFacebookHpActive",
		
		wibiyaAnalytics => "wibiyaAnalytics",
		haveLandingPage => "haveLandingPage",
		maxLandingPage => "maxLandingPage",
		haveMailingNet => "haveMailingNet",
		contactThanksPixel => "contactThanksPixel",
		contactThanksUrlRedirect => "contactThanksUrlRedirect",
		facebookPageId => "facebookPageId",
		indexSite => "indexSite",
		centered_contact => "centered_contact",
		remartiking_code => "remartiking_code",
		zopim_script => "zopim_script",
		nisha_sites => "nisha_sites",
		dogs4u_chooser_shop => "dogs4u_chooser_shop",
		user_adsense_instead_esti_form => "user_adsense_instead_esti_form",
		have_realty => "have_realty",
		have_contracts => "have_contracts",
		free_text => "free_text",
	);
	
	$counter1 = 1;
		$sql = "update user_extra_settings set ";
		foreach( $form_arr_user_extra_settings as $val => $key )	{
			$reqval = trim($_REQUEST[$key]);
			$with_psik = ( $counter1 == sizeof($form_arr_user_extra_settings) ) ? " " : ", ";
			if( $val == "nisha_sites" )
				$sql .= $val." = '".json_encode($reqval)."'".$with_psik;
			else
				$sql .= $val." = '".$reqval."'".$with_psik;
			$counter1++;
		}
		$sql .= "where unk = '".$_REQUEST['unk']."' limit 1";
		$res = mysql_db_query(DB,$sql);
	
	
	$check_sql = "SELECT unk FROM user_bookkeeping WHERE unk = '".$_POST['unk']."' ";
	$check_res = mysql_db_query($check_sql);
	$check_unk_bookkeeping = mysql_fetch_array($check_res);
	
	if( $check_unk_bookkeeping['unk'] != $_POST['unk'] )
	{
		$sql = "insert into user_bookkeeping (unk) values ( '".$data_arr['unk']."' )";
		$res = mysql_db_query(DB,$sql);
	}
	
	$form_arr_user_bookkeeping = array(
		hostPriceMon      => "hostPriceMon", 
		domainEndDate     => "domainEndDate",
		domainPrice       => "domainPrice",
	    advertisingStartDate	=> "advertisingStartDate",
	    advertisingPrice  => "advertisingPrice",
	    advertisingPeriod => "advertisingPeriod",
	    leadPrice         => "leadPrice",
	    leadPercentOff    => "leadPercentOff",
	    sendReport        => "sendReport",
		advReport        => "advReport",
	    
	);
	
	$counter1 = 1;
		$sql = "update user_bookkeeping set ";
		foreach( $form_arr_user_bookkeeping as $val => $key )	{
			$with_psik = ( $counter1 == sizeof($form_arr_user_bookkeeping) ) ? " " : ", ";
			$reqval = trim($_REQUEST[$key]);
			switch( $val )
			{
				
				case "domainEndDate" :
				case "advertisingStartDate" :
					if( eregi("-",$reqval))
						$exp = explode( "-" , $reqval );
					elseif( eregi("/",$reqval))
						$exp = explode( "/" , $reqval );
					$sql .= $val." = '".$exp[2]."-".$exp[1]."-".$exp[0]."'".$with_psik;
				break;
				default:	$sql .= $val." = '".$reqval."'".$with_psik;
			}
			$counter1++;
		}
		$sql .= "where unk = '".$_REQUEST['unk']."' limit 1";
		$res = mysql_db_query(DB,$sql);
	
	
	labor_agreement_file_func();
	
	
	echo "<META HTTP-EQUIV=Refresh CONTENT=\"0; URL=?main=users_list&sesid=".SESID."\">";
}
/********************************************************************************************************/

function labor_agreement_file_func()
{

	if( $_FILES['labor_agreement_file'] != "" )
	{
		$field_name = array("labor_agreement_file");
		
		for($temp=0 ; $temp<sizeof($field_name) ; $temp++)
		{
			$temp_name = $field_name[$temp];
			if ( $_FILES[$temp_name]['name'] != "" )
			{
				$exte = substr($_FILES[$temp_name]['name'],(strpos($_FILES[$temp_name]['name'],".")+1));
				$logo_name2 = $_POST['unk']."-site.".$exte;
				$tempname = $logo_name;
				
				$path = "/home/ilan123/domains/ilbiz.co.il/public_html/site-admin/clients/eskemim/";
				$up = GlobalFunctions::upload_file_to_server($temp_name , $logo_name2 , $path );
				
				if( $up == true )
				{
					$sql = "UPDATE user_extra_settings SET labor_agreement_file = '".$logo_name2."' WHERE unk = '".$_POST['unk']."' limit 1";
					$res = mysql_db_query(DB,$sql);
				}
			}
		}
	}
	
	
	if( $_FILES['agreement_10service_site'] != "" )
	{
		$field_name = array("agreement_10service_site");
		
		for($temp=0 ; $temp<sizeof($field_name) ; $temp++)
		{
			$temp_name = $field_name[$temp];
			if ( $_FILES[$temp_name]['name'] != "" )
			{
				$exte = substr($_FILES[$temp_name]['name'],(strpos($_FILES[$temp_name]['name'],".")+1));
				$logo_name2 = $_POST['unk']."-10service_site.".$exte;
				$tempname = $logo_name;
				
				$path = "/home/ilan123/domains/ilbiz.co.il/public_html/site-admin/clients/eskemim/";
				$up = GlobalFunctions::upload_file_to_server($temp_name , $logo_name2 , $path );
				
				if( $up == true )
				{
					$sql = "UPDATE user_extra_settings SET agreement_10service_site = '".$logo_name2."' WHERE unk = '".$_POST['unk']."' limit 1";
					$res = mysql_db_query(DB,$sql);
				}
			}
		}
	}
	
	
	if( $_FILES['agreement_10service_products'] != "" )
	{
		$field_name = array("agreement_10service_products");
		
		for($temp=0 ; $temp<sizeof($field_name) ; $temp++)
		{
			$temp_name = $field_name[$temp];
			if ( $_FILES[$temp_name]['name'] != "" )
			{
				$exte = substr($_FILES[$temp_name]['name'],(strpos($_FILES[$temp_name]['name'],".")+1));
				$logo_name2 = $_POST['unk']."-10service_products.".$exte;
				$tempname = $logo_name;
				
				$path = "/home/ilan123/domains/ilbiz.co.il/public_html/site-admin/clients/eskemim/";
				$up = GlobalFunctions::upload_file_to_server($temp_name , $logo_name2 , $path );
				
				if( $up == true )
				{
					$sql = "UPDATE user_extra_settings SET agreement_10service_products = '".$logo_name2."' WHERE unk = '".$_POST['unk']."' limit 1";
					$res = mysql_db_query(DB,$sql);
				}
			}
		}
	}
	
	
}


function dell_user()	{

	$sql = "update users set deleted = '1' where id = '".$_REQUEST['record_id']."' and unk = '".$_REQUEST['unk']."' limit 1";
	$res = mysql_db_query(DB,$sql);
	
	echo "<script>window.location.href='?main=users_list&sesid=".SESID."'</script>";
		exit;
}

function add_user_to_delete()	{
	$sql = "SELECT id,unk FROM users WHERE  unk = '".$_REQUEST['unk']."'";
	$res = mysql_db_query(DB,$sql);
	$data = mysql_fetch_array($res);
	
	$sql_d = "SELECT id,unk FROM users_to_delete WHERE  unk = '".$_REQUEST['unk']."'";
	$res_d = mysql_db_query(DB,$sql_d);
	$data_d = mysql_fetch_array($res_d);	
	
	if(!isset($data_d['unk'])){
		$sql = "INSERT INTO users_to_delete(user_id,unk,level_delete) values('".$data['id']."','".$data['unk']."','0')";
		$res = mysql_db_query(DB,$sql);
	}
	
	echo "<script>alert('המשתמש נוסף לתור מחיקה לצמיתות'); window.location.href='".$_SERVER['HTTP_REFERER']."'</script>";
		exit;
}

function remove_user_to_delete(){
	$sql = "DELETE FROM users_to_delete WHERE unk = '".$_REQUEST['unk']."'";
	$res = mysql_db_query(DB,$sql);
	echo "<script>alert('המשתמש הוסר מתור מחיקה לצמיתות'); window.location.href='".$_SERVER['HTTP_REFERER']."'</script>";
	exit;
}
/********************************************************************************************************/


function portal_settings()	{

	$owner_id = ( AUTH >= "8" ) ? "" : " and owner_id = '".OID."'"; 
	$sql = "select id,portal_active from users where deleted = '0' and unk = '".$_REQUEST['unk']."' ".$owner_id."";
	$res = mysql_db_query(DB,$sql);
	$data = mysql_fetch_array($res);
	
	$sql = "select id from users where unk = '".$_GET['unk']."' and owner_id = '".$owner_id."'";
	$res_user_id = mysql_db_query(DB,$sql);
	$data_user_id = mysql_fetch_array($res_user_id);
	$user_id = $data_user_id['id'];

	$premmission_sql = "select premmission_key ,premmission_val from user_extra_premmissions where user_id = (SELECT id FROM users WHERE unk = '".$_REQUEST['unk']."')";
	$premmission_res = mysql_db_query(DB,$premmission_sql);
	while($premmission_data = mysql_fetch_array($premmission_res)){
		if($premmission_data['premmission_val'] == '1'){
			$data[$premmission_data['premmission_key']] = '1';
		}
	}

	
	$portal_active[0] = "כן";
	$portal_active[1] = "לא";

	$premmissions_active[1] = "כן";
	$premmissions_active[0] = "לא";

	$checked_cats = array();
	
	$sql = "select cat_name,id from biz_categories where father = 0 and status = 1";
	$res_father = mysql_db_query(DB,$sql);
	
	$cat_list = "<table border=\"0\" cellpadding=\"0\" cellspacing=\"0\" width=\"100%\">";
		$cat_list .= "<tr>";
			$cat_list .= "<td style=\"background-color:#cccccc;\">";
			
				$cat_list .= "<ul style=\"list-style:none\" class=\"dhtmlTree\">";
					while( $data_father = mysql_fetch_array($res_father) )
					{
						$father_checked = false;
						$sql = "select cat_id from user_cat where user_id = '".$data['id']."' and cat_id = '".$data_father['id']."'";
						$res_cat_id = mysql_db_query(DB,$sql);
						$data_cat_id = mysql_fetch_array($res_cat_id);
						
						if( $data_cat_id['cat_id'] == $data_father['id'] )	{
							$father_checked = true;
							$selected1 = "checked";
							$checked_cats[] = array('cat_id'=>$data_father['id'],'spaces'=>"",'cat_name'=>$data_father['cat_name'],'check_color'=>'blue');
						}	else	{
							$selected1 = "";
						}
						
						$cat_list .= "<li><img src=\"options.fiels/plus.jpg\" onclick=\"htmldb_ToggleWithImage(this,'treeCAT".$data_father['id']."')\" class=\"pseudoButtonInactive\" />
						".stripslashes($data_father['cat_name'])."
						<input type=\"checkbox\" name=\"select_cat[".$data_father['id']."]\" value=\"1\" ".$selected1.">
						</li>";
						
						$sql = "select cat_name,id from biz_categories where father = ".$data_father['id']." and status = 1";
						$res_father_cat = mysql_db_query(DB,$sql);
						
						$cat_list .= "<ul id=\"treeCAT".$data_father['id']."\" htmldb:listlevel=\"2\" style=\"padding-right:15px;list-style:none;display:none;\" class=\"dhtmlTree\">";
							while( $data_father_cat = mysql_fetch_array($res_father_cat) )
							{
								$father_cat_checked = false;
								$sql = "select cat_id from user_cat where user_id = '".$data['id']."' and cat_id = '".$data_father_cat['id']."'";
								$res_cat_id = mysql_db_query(DB,$sql);
								$data_cat_id = mysql_fetch_array($res_cat_id);
								
								if( $data_cat_id['cat_id'] == $data_father_cat['id'] )	{
									if(!$father_checked){
										$father_checked = true;
										$checked_cats[] = array('cat_id'=>$data_father['id'],'spaces'=>"",'cat_name'=>$data_father['cat_name'],'check_color'=>'red');
									}
									$father_cat_checked = true;
									$selected2 = "checked";
									
									$checked_cats[] = array('cat_id'=>$data_father_cat['id'],'spaces'=>"&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;",'cat_name'=>$data_father_cat['cat_name'],'check_color'=>'blue');
								}	else	{
									$selected2 = "";
								}
						
								$sql = "select cat_name,id from biz_categories where father = '".$data_father_cat['id']."' and status = '1'";
								$res_father_tat_cat = mysql_db_query(DB,$sql);
								$num_father_tat_cat = mysql_num_rows($res_father_tat_cat);
								
								if( $num_father_tat_cat > 0 )
								{
									$cat_list .= "<li>
									<img src=\"options.fiels/plus.jpg\" onclick=\"htmldb_ToggleWithImage(this,'treeF_CAT".$data_father_cat['id']."')\" class=\"pseudoButtonInactive\" />
									".$data_father_cat['cat_name']."
									<input type=\"checkbox\" name=\"select_cat[".$data_father_cat['id']."]\" value=\"1\" ".$selected2."></li>";
									
									$cat_list .= "<ul id=\"treeF_CAT".$data_father_cat['id']."\" htmldb:listlevel=\"3\" style=\"padding-right:15px;list-style:none;display:none;\" class=\"dhtmlTree\">";
									
									while( $data_father_tat_cat = mysql_fetch_array($res_father_tat_cat) )
									{
										$father_tat_cat_checked = false;
										$sql = "select cat_id from user_cat where user_id = '".$data['id']."' and cat_id = '".$data_father_tat_cat['id']."'";
										$res_cat_id = mysql_db_query(DB,$sql);
										$data_cat_id = mysql_fetch_array($res_cat_id);
										
										if( $data_cat_id['cat_id'] == $data_father_tat_cat['id'] )	{
											$father_tat_cat_checked = true;
											if(!$father_checked){
												$checked_cats[] = array('cat_id'=>$data_father['id'],'spaces'=>"",'cat_name'=>$data_father['cat_name'],'check_color'=>'red');
												$father_checked = true;
											}
											if(!$father_cat_checked){
												$father_cat_checked = true;
												$checked_cats[] = array('cat_id'=>$data_father_cat['id'],'spaces'=>"&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;",'cat_name'=>$data_father_cat['cat_name'],'check_color'=>'red');
											}
											$selected3 = "checked";
											$checked_cats[] = array('cat_id'=>$data_father_tat_cat['id'],'spaces'=>"&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;",'cat_name'=>$data_father_tat_cat['cat_name'],'check_color'=>'blue');
										}	else	{
											$selected3 = "";
										}
										
										$cat_list .= "<li><img src=\"options.fiels/node.jpg\" /><input type=\"checkbox\" name=\"select_cat[".$data_father_tat_cat['id']."]\" value=\"1\" ".$selected3.">".$data_father_tat_cat['cat_name']."</li>";
									}
									$cat_list .= "</ul>";
								}
								else
								{
									$cat_list .= "<li><img src=\"options.fiels/node.jpg\" />
									<input type=\"checkbox\" name=\"select_cat[".$data_father_cat['id']."]\" value=\"1\" ".$selected2.">".$data_father_cat['cat_name']."</li>";
								}
							}
						$cat_list .= "</ul>";
					}
				$cat_list .= "</ul>";
			$cat_list .= "</td>";
		$cat_list .= "</tr>";
	$cat_list .= "</table>";
	
	
	
	$sql = "select name,id from portals where status = 0";
	$res_portals = mysql_db_query(DB,$sql);
	
	$portal_list = "<table border=\"0\" cellpadding=\"0\" cellspacing=\"0\" width=\"100%\">";
		$portal_list .= "<tr>";
			$portal_list .= "<td style=\"background-color:#d5d5d5;\">";
			
				$portal_list .= "<ul style=\"list-style:none\">";
					while( $data_portals = mysql_fetch_array($res_portals) )
					{
						$sql = "select portal_id from user_portal where user_id = '".$data['id']."' and portal_id = '".$data_portals['id']."'";
						$res_portal_id = mysql_db_query(DB,$sql);
						$data_portal_id = mysql_fetch_array($res_portal_id);
						
						$selected1 = ( $data_portal_id['portal_id'] == $data_portals['id'] ) ? "checked" : "";
						
						$portal_list .= "<li><input type=\"checkbox\" name=\"select_portal[".$data_portals['id']."]\" value=\"1\" ".$selected1.">".stripslashes($data_portals['name'])."</li>";
						
					}
				$portal_list .= "</ul>";
			$portal_list .= "</td>";
		$portal_list .= "</tr>";
	$portal_list .= "</table>";
	
	$form_arr = array(
		array("hidden","main","update_DB_portal_set"),
		array("hidden","record_id",$data['id']),
		array("hidden","sesid",SESID),
		array("hidden","unk",$_REQUEST['unk']),
		array("hidden","data_arr[unk]",$_REQUEST['unk']),
		
		array("select","portal_active[]",$portal_active,"פעיל בפורטל",$data['portal_active'],"data_arr[portal_active]", "class='input_style'"),

		array("blank",$portal_list),

		
		
		array("blank",$cat_list),
		
		array("select","edit_cats[]",$premmissions_active,"יכול לערוך קטגוריות באתר",$data['edit_cats'],"data_premmissions[edit_cats]", "class='input_style'"),
		array("select","edit_cities[]",$premmissions_active,"יכול לשייך ערים באתר",$data['edit_cities'],"data_premmissions[edit_cities]", "class='input_style'"),

		
		
		array("submit","submit","שמירה", "class='submit_style'")
	);
	
// שדות חובה
$mandatory_fields = array("data_arr[username]","data_arr[password]","data_arr[full_name]","data_arr[name]","data_arr[email]","data_arr[phone]");
$more = "class='maintext'";

echo "<table border=\"0\" cellspacing=\"0\" cellpadding=\"0\" class=\"maintext\">";
		
		echo "<tr>";
			echo "<td colspan=3><A href=\"?&sesid=".SESID."\" class=\"maintext\">חזרה לתפריט הראשי</a></td>";
		echo "</tr>";
		echo "<tr><td colspan=3 height=\"15\"></td></tr>";
		echo "<tr>";
			echo "<td colspan=3><A href=\"?main=user_lead_settings&unk=".$_REQUEST['unk']."&record_id=".$data['id']."&sesid=".SESID."\" class=\"maintext\">הגדרות לידים</a></td>";
		echo "</tr>";		

		echo "<tr>";
			echo "<td colspan=3><A href=\"?main=user_profile&unk=".$_REQUEST['unk']."&record_id=".$data['id']."&sesid=".SESID."\" class=\"maintext\">חזרה לעדכון</a></td>";
		echo "</tr>";		
		echo "<tr>";
			echo "<td colspan=3><A href=\"?main=users_list&sesid=".SESID."\" class=\"maintext\">לרשימת האתרים</a></td>";
		echo "</tr>";
		
		echo "<tr><td colspan=3 height=\"11\"></td></tr>";
		
		echo "<tr>";
			echo "<td valign=top>".FormCreator::create_form($form_arr,"index.php", $more, $mandatory_fields)."</td>";
			echo "<td width=30></td>";
			echo "<td valign=top>קטגוריות של הלקוח<br/>  לחץ להוספת ערים לקטגוריה:<br>
					לחץ להוספת API בעת שליחת ליד:
			<br>";
				echo "<a href=\"?main=user_cat_settings&unk=".$_REQUEST['unk']."&record_id=".$data['id']."&catId=0&sesid=".SESID."\" class=\"maintext\">כל הקטגוריות</a><br>";
				foreach( $checked_cats as $key => $cat )		{
					echo stripslashes($cat['spaces'])."<a href=\"?main=user_cat_settings&unk=".$_REQUEST['unk']."&record_id=".$data['id']."&catId=".$cat['cat_id']."&sesid=".SESID."\" class=\"maintext\"><span style='color:".$cat['check_color'].";'>".stripslashes($cat['cat_name'])."</span></a><br>";
					
				}
				echo "<br><br>";
				echo "<form action='index.php' name='reset_cats' method='post'>";
					echo "<input type='hidden' name='main' value='delete_DB_portal_set'>";
					echo "<input type='hidden' name='sesid' value='".SESID."'>";
					echo "<input type='hidden' name='unk' value='".$_REQUEST['unk']."'>";
					echo "<input type='hidden' name='data_arr[unk]' value='".$_REQUEST['unk']."'>";
					echo "<input type='submit' value='איפוס קטוגריות' class='submit_style' onclick='return confirm(\"האם אתה בטוח? לא ניתן לחזור אחורה\")'>";
				echo "</form>";
				$phones_sql = "select * from users_phones where unk = '".$_REQUEST['unk']."'";
				$phones_res = mysql_db_query(DB,$phones_sql);					
				echo "<h5>מספרי טלפון של הלקוח</h5>";
				$has_phones = false;
				echo "<table cellpadding='5'>";
					echo "<tr>";
						echo "<td><a href=\"?main=user_cat_settings&unk=".$_REQUEST['unk']."&record_id=".$data['id']."&phone=0&sesid=".SESID."\" class=\"maintext\">כל הטלפונים</a></td>";
						echo "<td></td>";
						echo "<td></td>";
					echo "</tr>";
				while($phones_data = mysql_fetch_array($phones_res)){
					$has_phones = true;
					$campaign_str = "ללא קמפיין";
					$bill_str = "כן";
					if($phones_data['bill_normal'] == '0'){
						$bill_str = "לא";
					}
					
					if($phones_data['campaign_type'] == '1'){
						$campaign_str = "קמפיין גוגל";
					}
					if($phones_data['campaign_type'] == '2'){
						$campaign_str = "קמפיין פייסבוק";
					}						
					echo "<tr>";
						echo "<td><a href=\"?main=user_cat_settings&unk=".$_REQUEST['unk']."&record_id=".$data['id']."&phone=".$phones_data['phone']."&sesid=".SESID."\" class=\"maintext\">".$phones_data['phone']."</a></td>";
						echo "<td>".$campaign_str."</td>";
						echo "<td>[".$phones_data['campaign_name']."]</td>";
						echo "<td>חיוב שיחה בליד: ".$bill_str."</td>";
					echo "</tr>";
				}
				echo "</table>";				
			echo "</td>";
		echo "</tr>";
				
	echo "</table>";
}
/********************************************************************************************************/

function delete_DB_portal_set()	{
	$sql = "select id from users where unk = '".$_POST['unk']."'";
	$res_user_id = mysql_db_query(DB,$sql);
	$data_user_id = mysql_fetch_array($res_user_id);
	$user_id = $data_user_id['id'];
	
	$sql = "delete from user_cat where user_id = '".(int)$user_id."'";
	$res_del = mysql_db_query(DB,$sql);

	$sql = "delete from user_extra_premmissions where user_id = '".(int)$user_id."'";
	$res_del = mysql_db_query(DB,$sql);
	
	echo "<script>window.location.href='index.php?main=portal_settings&unk=".$_POST['unk']."&record_id=".$user_id."&sesid=".SESID."';</script>";
	exit;
}


function update_DB_portal_set()	{

	$sql = "select id from users where unk = '".$_POST['unk']."'";
	$res_user_id = mysql_db_query(DB,$sql);
	$data_user_id = mysql_fetch_array($res_user_id);
	$user_id = $data_user_id['id'];
	
	$sql = "delete from user_cat where user_id = '".$user_id."'";
	$res_del = mysql_db_query(DB,$sql);
	
	foreach( $_POST['select_cat'] as $val => $key )
	{
		if( $key == "1" )
		{
			$sql = "insert into user_cat ( user_id , cat_id ) values ( '".$user_id."' , '".$val."' )";
			$res_insert = mysql_db_query(DB,$sql);
		}
	}
	
	$sql = "delete from user_portal where user_id = '".$user_id."'";
	$res_del = mysql_db_query(DB,$sql);
	
	foreach( $_POST['select_portal'] as $val => $key )
	{
		if( $key == "1" )
		{
			$sql = "insert into user_portal ( user_id , portal_id ) values ( '".$user_id."' , '".$val."' )";
			$res_insert = mysql_db_query(DB,$sql);
		}
	}
	foreach( $_POST['data_premmissions'] as $val => $key )
	{
		$sql = "insert into user_extra_premmissions
				(user_id, premmission_key, premmission_val)
				VALUES(".$user_id.",'".$val."',".$key.")
				ON DUPLICATE KEY UPDATE premmission_val = VALUES(premmission_val)";
		$res_insert = mysql_db_query(DB,$sql);
	}	
	
	$image_settings = array(
		after_success_goto=>"?main=users_list&sesid=".SESID."",
		table_name=>"users"
	);
	$data_arr = ($_POST['data_arr'])? $_POST['data_arr'] : $_GET['data_arr'];
	update_db($data_arr, $image_settings);
}
/********************************************************************************************************/

function users_list()	{
	//send to myleads system 
	if(isset($_GET['send_to_my_leads'])){
		$_SESSION['myleads_login_user'] = $_GET['send_to_my_leads'];
		echo " sending to 'https://ilbiz.co.il/myleads/' with user ".$_GET['send_to_my_leads'];
		$lead_qry = "";
		if(isset($_GET['lead_id'])){
			$lead_qry = "?row_id=".$_GET['lead_id'];
		}
		echo "<script>window.location.href='https://ilbiz.co.il/myleads/".$lead_qry."';</script>";
		return;
	}

	$owner_id = ( AUTH >= "8" ) ? "" : " and u.owner_id = '".OID."'"; 
	
	$status = ( $_GET['status'] == "" ) ? "0" : $_GET['status'];
	
	$status_qry = ( AUTH >= "8" ) ? " and ( u.status = '".$status."' OR u.status = 1 )" : " and ( u.status='0' OR u.status='1' ) "; 
	
	$more_sql = "";
	$more_sql .= ( !empty($_GET['name']) ) ? " AND u.name LIKE '%".mysql_real_escape_string($_GET['name'])."%'" : "";
	$more_sql .= ( !empty($_GET['full_name']) ) ? " AND u.full_name LIKE '%".mysql_real_escape_string($_GET['full_name'])."%'" : "";
	$more_sql .= ( !empty($_GET['username']) ) ? " AND u.username LIKE '%".mysql_real_escape_string($_GET['username'])."%'" : "";
	$more_sql .= ( !empty($_GET['domain']) ) ? " AND u.domain LIKE '%".mysql_real_escape_string($_GET['domain'])."%'" : "";
	
	
	$more_sql .= ( !empty($_GET['adv1_la']) ) ? " AND ux.labor_agreement = '".mysql_real_escape_string($_GET['adv1_la'])."'" : "";
	$more_sql .= ( !empty($_GET['adv1_dp']) ) ? " AND ux.down_payment = '".mysql_real_escape_string($_GET['adv1_dp'])."'" : "";
	$more_sql .= ( !empty($_GET['adv1_tai']) ) ? " AND ux.option_ticket_at_invoice = '".mysql_real_escape_string($_GET['adv1_tai'])."'" : "";
	$more_sql .= ( !empty($_GET['adv1_sf']) ) ? " AND ux.have_site_feature = '".mysql_real_escape_string($_GET['adv1_sf'])."'" : "";
	$more_sql .= ( !empty($_GET['adv1_ltse']) ) ? " AND ux.add_links_to_search_eng = '".mysql_real_escape_string($_GET['adv1_ltse'])."'" : "";
	$more_sql .= ( !empty($_GET['adv1_tc']) ) ? " AND ux.teaching_client = '".mysql_real_escape_string($_GET['adv1_tc'])."'" : "";
	$more_sql .= ( !empty($_GET['adv1_spc']) ) ? " AND ux.end_site_payment_collection = '".mysql_real_escape_string($_GET['adv1_spc'])."'" : "";
	$more_sql .= ( !empty($_GET['adv1_sitetype']) || $_GET['adv1_sitetype'] == "0" ) ? " AND u.site_type = '".mysql_real_escape_string($_GET['adv1_sitetype'])."'" : "";
	if(!(empty($_GET['adv1_sitetype']) || $_GET['adv1_sitetype'] == "0")){
		if((!isset($_GET['show_utype_16'])) || $_GET['show_utype_16'] == "0" ){
			$more_sql .=  " AND u.site_type != '16' ";
		}
	}
	$ecardsql = "select unk FROM user_e_card_settings";
	
	$ecardres = mysql_db_query(DB,$ecardsql);
	$ecard_unk_arr = array();
	while($ecardUnk = mysql_fetch_array($ecardres)){
		$ecard_unk_arr[$ecardUnk['unk']] = $ecardUnk['unk'];
	}
	$deleted_sql .= ( !empty($_GET['adv1_deleted']) ) ? " u.deleted = '".mysql_real_escape_string($_GET['adv1_deleted'])."'" : " u.deleted = '0' ";
	
	$more_sql .= ( !empty($_GET['adv1_owid']) ) ? " AND u.owner_id = '".(int)$_GET['adv1_owid']."'" : "";
	$more_sql .= ( !empty($_GET['ecom']) ) ? " AND u.have_ecom = '".(int)$_GET['ecom']."'" : "";
	
	$more_sql .= ( !empty($_GET['free_text']) ) ? " AND ux.free_text like '%".mysql_real_escape_string($_GET['free_text'])."%'" : "";
	
	$add_delete_col = false;
	if(!empty($_GET['adv1_deleted'])){
		$add_delete_col = true;
	}
	
	$limitcount = ( $_GET['limit'] == "" ) ? "0" : $_GET['limit'];
	$item_id = $limitcount;
	$sql = "select u.id,u.unk,u.username,u.password,u.full_name,u.name,u.status,u.domain 
		from users as u LEFT JOIN user_extra_settings as ux ON u.unk = ux.unk WHERE 
			$deleted_sql ".$status_qry." ".$owner_id.$more_sql." GROUP BY u.unk ORDER BY u.id desc LIMIT ".$limitcount.",100";
	
	$res = mysql_db_query(DB,$sql);
	
	$sql = "select u.id from users as u LEFT JOIN user_extra_settings as ux ON u.unk = ux.unk WHERE u.deleted = '0' ".$status_qry." ".$owner_id.$more_sql."";
	$resAll = mysql_db_query(DB,$sql);
	$num_all = mysql_num_rows($resAll);
	
	
	setcookie("panelAdmin", "provide_insert_to_user_admin", time()+1800 , '/' );


	echo "<table border=\"0\" cellspacing=\"0\" cellpadding=\"3\" class=\"maintext\" bgcolor=\"#cccccc\">";
		
		echo "<tr>
			<td colspan=\"25\"><A href=\"?sesid=".SESID."\" class=\"maintext\">חזרה לתפריט הראשי</a></td>
		</tr>";
		echo "<tr><td colspan=\"25\" height=\"7\"></td></tr>";
		echo "<tr>
			<td colspan=\"25\"><A href=\"?main=user_profile&sesid=".SESID."\" class=\"maintext\">יצירת אתר חדש</a></td>
		</tr>";
		if( AUTH >= "8" )
		{
			echo "<tr>
				<td colspan=\"25\"><A href=\"?main=users_list&status=8&sesid=".SESID."\" class=\"maintext\">אתרים חדשים שהתקבלו</a></td>
			</tr>";
			
			echo "<tr>
				<td colspan=\"25\"><A href=\"?main=users_to_delete_list&sesid=".SESID."\" class=\"maintext\">רשימת אתרים למחיקה</a></td>
			</tr>";			
		}
		echo "<tr><td colspan=\"25\" height=\"11\"></td></tr>";
		echo "<form action='index.php' name='search_sites' method='get' style='padding:0; margin:0;'>";
		echo "<input type='hidden' name='main' value='users_list'>";
		echo "<input type='hidden' name='status' value='".$_GET['status']."'>";
		echo "<input type='hidden' name='limit' value='".$limitcount."'>";
		echo "<input type='hidden' name='sesid' value='".SESID."'>";
		echo "<tr>";
			echo "<td colspan=\"25\"><input type='text' name='free_text' value='".$_GET['free_text']."' class='input_style' style='width:200px;'></td>";
		echo "</tr>";
		echo "<tr><td colspan=\"25\" height=\"7\"></td></tr>";
		echo "<tr>";
			echo "<td><input type='text' name='name' value='".$_GET['name']."' class='input_style' style='width:100px;'></td>";
			echo "<td width=\"15\"></td>";
			echo "<td><input type='text' name='full_name' value='".$_GET['full_name']."' class='input_style' style='width:100px;'></td>";
			echo "<td width=\"15\"></td>";
			echo "<td><input type='text' name='username' value='".$_GET['username']."' class='input_style' style='width:100px;'></td>";
			echo "<td width=\"15\"></td>";
			echo "<td></td>";
			echo "<td width=\"15\"></td>";
			echo "<td><input type='text' name='domain' value='".$_GET['domain']."' class='input_style' style='width:100px;'></td>";
			echo "<td width=\"15\"></td>";
			echo "<td align=right colspan=9><input type='submit' value='סנן' class='submit_style'></td>";
		echo "</tr>";
		
		if( AUTH >= "9" )
		{
			echo "<tr>";
				echo "<td colspan=\"25\"><a href='javascript:void(0)' onclick='open_close_div(\"advance_search_1\")' class='maintext'>סינון מתקדם</td>";
			echo "</tr>";
			
			echo "<tr>";
				echo "<td colspan=\"25\"><a href='javascript:void(0)' onclick='open_close_div(\"advance_search_cats\")' class='maintext'>סינון מתקדם קטגוריות</td>";
			echo "</tr>";
			
			
			$adv1_display = ( !empty($_GET['adv1_la']) || !empty($_GET['adv1_dp']) || !empty($_GET['adv1_tai']) || 	!empty($_GET['adv1_sf']) || !empty($_GET['adv1_ltse']) || !empty($_GET['adv1_tc']) || !empty($_GET['adv1_spc']) ) ? "" : "style='display: none;'";
			echo "<tr>";
				echo "<td colspan=\"25\">";
					echo "<div id='advance_search_1' ".$adv1_display.">";
						echo "<table border=\"0\" cellspacing=\"0\" cellpadding=\"3\" class=\"maintext\">";
							echo "<tr>";
								$selected1 = ( $_GET['adv1_la'] == "1" ) ? "selected" : "";
								$selected0 = ( $_GET['adv1_la'] == "0" ) ? "selected" : "";
								echo "<td>הסכם עבודה</td>";
								echo "<td>
									<select name='adv1_la' id='adv1_la' class='input_style' style='width: 60px;'>
										<option value=''>בחירה</option>
										<option value='1' ".$selected1.">כן</option>
										<option value='0' ".$selected0.">לא</option>
									</select>
								</td>";
								
								echo "<td width='10'></td>";
								
								$selected1 = ( $_GET['adv1_dp'] == "1" ) ? "selected" : "";
								$selected0 = ( $_GET['adv1_dp'] == "0" ) ? "selected" : "";
								echo "<td>האם שולמה מקדמה</td>";
								echo "<td>
									<select name='adv1_dp' id='adv1_dp' class='input_style' style='width: 60px;'>
										<option value=''>בחירה</option>
										<option value='1' ".$selected1.">כן</option>
										<option value='0' ".$selected0.">לא</option>
									</select>
								</td>";
								
								echo "<td width='10'></td>";
								
								$selected1 = ( $_GET['adv1_tai'] == "1" ) ? "selected" : "";
								$selected0 = ( $_GET['adv1_tai'] == "0" ) ? "selected" : "";
								echo "<td>פתיחת תיק לקוח במערכת חשבוניות</td>";
								echo "<td>
									<select name='adv1_tai' id='adv1_tai' class='input_style' style='width: 60px;'>
										<option value=''>בחירה</option>
										<option value='1' ".$selected1.">כן</option>
										<option value='0' ".$selected0.">לא</option>
									</select>
								</td>";
							
								echo "<td width='10'></td>";
								
								$selected1 = ( $_GET['adv1_sf'] == "1" ) ? "selected" : "";
								$selected0 = ( $_GET['adv1_sf'] == "0" ) ? "selected" : "";
								echo "<td>איפיון אתר</td>";
								echo "<td>
									<select name='adv1_sf' id='adv1_sf' class='input_style' style='width: 60px;'>
										<option value=''>בחירה</option>
										<option value='1' ".$selected1.">כן</option>
										<option value='0' ".$selected0.">לא</option>
									</select>
								</td>";
							echo "</tr>";
							
							$selected1 = ( $_GET['adv1_ltse'] == "1" ) ? "selected" : "";
							$selected0 = ( $_GET['adv1_ltse'] == "0" ) ? "selected" : "";
							echo "<tr>";
								echo "<td>הוספת קישור לאתר למנועי חיפוש</td>";
								echo "<td>
									<select name='adv1_ltse' id='adv1_ltse' class='input_style' style='width: 60px;'>
										<option value=''>בחירה</option>
										<option value='1' ".$selected1.">כן</option>
										<option value='0' ".$selected0.">לא</option>
									</select>
								</td>";
								
								echo "<td width='10'></td>";
								
								$selected1 = ( $_GET['adv1_tc'] == "1" ) ? "selected" : "";
								$selected0 = ( $_GET['adv1_tc'] == "0" ) ? "selected" : "";
								echo "<td>הדרכת לקוח</td>";
								echo "<td>
									<select name='adv1_tc' id='adv1_tc' class='input_style' style='width: 60px;'>
										<option value=''>בחירה</option>
										<option value='1' ".$selected1.">כן</option>
										<option value='0' ".$selected0.">לא</option>
									</select>
								</td>";
								
								echo "<td width='10'></td>";
								
								$selected1 = ( $_GET['adv1_spc'] == "1" ) ? "selected" : "";
								$selected0 = ( $_GET['adv1_spc'] == "0" ) ? "selected" : "";
								echo "<td>סיום גבייה תשלום עבור הקמה</td>";
								echo "<td>
									<select name='adv1_spc' id='adv1_spc' class='input_style' style='width: 60px;'>
										<option value=''>בחירה</option>
										<option value='1' ".$selected1.">כן</option>
										<option value='0' ".$selected0.">לא</option>
									</select>
								</td>";
								
								echo "<td width='10'></td>";
								
								$sql = "SELECT id, name FROM site_type ORDER BY place";
								$res_st = mysql_db_query(DB,$sql);
								
								$selected0 = ( $_GET['adv1_sitetype'] == "0" ) ? "selected" : "";
								echo "<td>סוג אתר</td>";
								echo "<td>
									<select name='adv1_sitetype' id='adv1_sitetype' class='input_style' style='width: 110px;'>
										<option value=''>בחירה</option><option value='0' ".$selected0.">ללא שיוך</option>";
										
										while( $data_st = mysql_fetch_array($res_st) )
										{
											$selected1 = ( $_GET['adv1_sitetype'] == $data_st['id'] ) ? "selected" : "";
											echo "<option value='".$data_st['id']."' ".$selected1.">".stripslashes($data_st['name'])."</option>";
										}
									echo "</select>
								</td>";
								
							echo "</tr>";
							
							echo "<tr>";
								$sql = "SELECT client_name , id FROM sites_owner WHERE auth < 8 AND deleted=0 AND status=0 AND end_date >= NOW()";
								$res_st = mysql_db_query(DB,$sql);
								
								echo "<td>שייך למעצב</td>";
								echo "<td>
									<select name='adv1_owid' id='adv1_owid' class='input_style' style='width: 110px;'>
										<option value=''>בחירה</option>";
										
										while( $data_st = mysql_fetch_array($res_st) )
										{
											$selected1 = ( $_GET['adv1_owid'] == $data_st['id'] ) ? "selected" : "";
											echo "<option value='".$data_st['id']."' ".$selected1.">".stripslashes($data_st['client_name'])."</option>";
										}
									echo "</select>
								</td>";
								
								echo "<td width='10'></td>";
								
								$selected1 = ( $_GET['ecom'] == "1" ) ? "selected" : "";
								$selected0 = ( $_GET['ecom'] == "0" ) ? "selected" : "";
								echo "<td>חנות אלקטורנית?</td>";
								echo "<td>
									<select name='ecom' id='ecom' class='input_style' style='width: 60px;'>
										<option value=''>בחירה</option>
										<option value='1' ".$selected1.">כן</option>
										<option value='0' ".$selected0.">לא</option>
									</select>
								</td>";
								
								echo "<td width='10'></td>";
								
								$selected1 = ( $_GET['show_utype_16'] == "1" ) ? "selected" : "";
								$selected0 = ( (!isset($_GET['show_utype_16'])) || $_GET['show_utype_16'] == "0" ) ? "selected" : "";
								echo "<td>הצג לקוחות דיוור</td>";
								echo "<td>
									<select name='show_utype_16' id='show_utype_16' class='input_style' style='width: 60px;'>
										<option value=''>בחירה</option>
										<option value='1' ".$selected1.">כן</option>
										<option value='0' ".$selected0.">לא</option>
									</select>
								</td>";
								
								echo "<td width='10'></td>";
								
								$selected1 = ( $_GET['adv1_deleted'] == "1" ) ? "selected" : "";
								$selected0 = ( $_GET['adv1_deleted'] == "0" ) ? "selected" : "";
								echo "<td>מחוקים</td>";
								echo "<td colspan=7>
									<select name='adv1_deleted' id='adv1_deleted' class='input_style' style='width: 60px;'>
										<option value=''>בחירה</option>
										<option value='1' ".$selected1.">כן</option>
										<option value='0' ".$selected0.">לא</option>
									</select>
								</td>";

								
							echo "</tr>";
							
						echo "</table>";
					echo "</div>";
				echo "</td>";
			echo "</tr>";
		}
		
		echo "</form>";
		
		echo "<tr><Td colspan=\"25\" align=center>";
			pagination( $num_all , "100" );		
		echo "</TD></tr>";
		
		echo "<tr><Td colspan=\"25\" height=\"5\"></TD></tr>";
		
		echo "<tr>";
			echo "<td><strong>מספר לקוח</strong></td>";
			echo "<td width=\"15\"></td>";
			echo "<td><strong>שם העסק</strong></td>";
			echo "<td width=\"15\"></td>";
			echo "<td><strong>שם מלא</strong></td>";
			echo "<td width=\"15\"></td>";
			echo "<td><strong>שם משתמש</strong></td>";
			echo "<td width=\"15\"></td>";
			echo "<td><strong>סיסמא</strong></td>";
			echo "<td width=\"15\"></td>";
			echo "<td><strong>אתר</strong></td>";
			echo "<td width=\"15\"></td>";
						echo "<td><strong>10card</strong></td>";
			echo "<td width=\"15\"></td>";	
			if( AUTH >= 9){
				echo "<td><strong>myleads</strong></td>";
				echo "<td width=\"15\"></td>";
			}	
		
			if( AUTH >= 2 )
			{
			echo "<td><strong>עיצוב יחודי</strong></td>";
			echo "<td width=\"15\"></td>";
			echo "<td><strong>מילים</strong></td>";
			echo "<td width=\"15\"></td>";
			echo "<td><strong>עדכון</strong></td>";
			echo "<td width=\"15\"></td>";
			}
			if( AUTH >= 3 )
			{
			echo "<td><strong>הגדרות פורטל</strong></td>";
			echo "<td width=\"15\"></td>";
			if($add_delete_col){
				echo "<td><strong>מיועד למחיקה</strong></td>";
				echo "<td width=\"15\"></td>";			
			}
			}
			if( AUTH >= 9 && $_GET['status'] == '8' )
				echo "<td><strong>מחיקה</strong></td>";
			
		echo "</tr>";
		
		$count = 0;
		while( $data = mysql_fetch_array($res) )	
		{
			$item_id++;
			$sql2 = "select set_colors from user_site_settings where unk = '".$data['unk']."'";
			$res2 = mysql_db_query(DB,$sql2);
			$data2 = mysql_fetch_array($res2);
			$data2['set_colors'] = ( $data2['set_colors'] == 0 ) ? "" : $data2['set_colors'];
			
			$delete_data = "SELECT id FROM users_to_delete WHERE unk = '".$data['unk']."'";
			$delete_res = mysql_db_query(DB,$delete_data);
			$delete_data = mysql_fetch_array($delete_res);
			if(isset($delete_data['id'])){
				$user_delete_marked = true;
				$user_delete_marked_str = "כן";
			}
			else{
				$user_delete_marked = false;
				$user_delete_marked_str = "לא";
			}
			$e_card_exist_str = 'לא';
			if(isset($ecard_unk_arr[$data['unk']])){
				$e_card_exist_str = 'כן';
			}
			$bg = ( $count%2 == 0 ) ? "eaeaea" : "f7f7f7";
			echo "<tr><Td colspan=\"25\" height=\"5\" height=\"5\"></TD></tr>";
			echo "<tr bgcolor=\"#{$bg}\"><Td colspan=\"25\" height=\"5\"></TD></tr>";
			echo "<tr bgcolor=\"#{$bg}\">";

				echo "<td>[".$item_id."]-".$data['id']."</td>";
				echo "<td width=\"10\"></td>";
				echo "<td>".stripslashes($data['name'])."</td>";
				echo "<td width=\"10\"></td>";
				echo "<td>".stripslashes($data['full_name'])."</td>";
				echo "<td width=\"10\"></td>";
				$current_host = $_SERVER['HTTP_HOST'];
				echo "<td><a href='https://".$current_host."/ClientSite/administration/index.php?main=menu&unk=".$data['unk']."&sesid=".SESID."' class='maintext' target='_blank'>".stripslashes($data['username'])."</a></td>";
				echo "<td width=\"10\"></td>";
				echo "<td>".stripslashes($data['password'])."</td>";
				echo "<td width=\"10\"></td>";
				if( $data['domain'] == '' )
					echo "<td>מערכת ניהול בלבד</td>";
				elseif( $data['status'] == 0 )
					echo "<td><a href=\"http://".$data['domain']."\" target=\"_blank\" class=\"maintext\">".$data['domain']."</td>";
				else
					echo "<td>לא קיים אתר</td>";
				
				echo "<td width=\"10\"></td>";
				
				echo "<td>".$e_card_exist_str."</td>";
				
				echo "<td width=\"10\"></td>";				
				
				if( AUTH >= 9){
					echo "<td><a target='_BLANK' href='https://ilbiz.co.il/site-admin/index.php?main=users_list&sesid=".SESID."&send_to_my_leads=".$data['id']."'>myleads</a></td>";
					echo "<td width=\"15\"></td>";
				}
				if( AUTH >= 2 )
				{
				echo "<td>";
					if( $data['domain'] != '' )
					echo "<a href=\"?main=update_set_colors&record_id=".$data2['set_colors']."&unk=".stripslashes($data['unk'])."&sesid=".SESID."\" class=\"maintext\">עיצוב יחודי</a>";
				echo "</td>";
				echo "<td width=\"10\"></td>";
				echo "<td><a href=\"?main=site_words&unk=".$data['unk']."&sesid=".SESID."\" class=\"maintext\">מילים</a></td>";
				echo "<td width=\"10\"></td>";
				echo "<td><a href=\"?main=user_profile&unk=".$data['unk']."&record_id=".$data['id']."&sesid=".SESID."\" class=\"maintext\">עדכון</a></td>";
				echo "<td width=\"10\"></td>";
				}
				if( AUTH >= 3 )
				{
				echo "<td><a href=\"?main=portal_settings&unk=".$data['unk']."&record_id=".$data['id']."&sesid=".SESID."\" class=\"maintext\">הגדרות פורטל</a></td>";
				echo "<td width=\"10\"></td>";
				if($add_delete_col){
					echo "<td>";
					echo $user_delete_marked_str;
					if(!$user_delete_marked){
						echo "<br/><a onclick='return confirm(\"האם אתה בטוח שברצונך להוסיף אתר זה לתור מחוקים לצמיתות?\")' href=\"?main=add_user_to_delete&unk=".$data['unk']."&sesid=".SESID."\" class=\"maintext\">הוסף לתור</a>";
					}
					echo "</td>";
					echo "<td width=\"10\"></td>";
				}
				}
				if( AUTH >= 9 && $_GET['status'] == '8' )
					echo "<td><a href=\"?main=dell_user&unk=".$data['unk']."&record_id=".$data['id']."&sesid=".SESID."\" class=\"maintext\" onclick=\"return can_i_del();\"><strong style=\"color:red;\">מחיקה</strong></a></td>";
			
			echo "</tr>";
			echo "<tr bgcolor=\"#{$bg}\"><Td colspan=\"25\" height=\"5\"></TD></tr>";
			$count++;
		}
		echo "<tr><Td colspan=\"25\" height=\"5\"></TD></tr>";
		
		echo "<tr><Td colspan=\"25\" align=center>";
			pagination( $num_all , "100" );		
		echo "</TD></tr>";
		
		echo "<tr><Td colspan=\"25\" height=\"5\"></TD></tr>";
	echo "</table>";
}
/********************************************************************************************************/

function users_to_delete_list()	{


	
	$limitcount = ( $_GET['limit'] == "" ) ? "0" : $_GET['limit'];
	$item_id = $limitcount;
	$sql = "select * FROM users_to_delete ORDER BY user_id desc LIMIT ".$limitcount.",100";
	
	$res = mysql_db_query(DB,$sql);
	
	$sql = "select * FROM users_to_delete";
	$resAll = mysql_db_query(DB,$sql);
	$num_all = mysql_num_rows($resAll);
	
	echo "<table border=\"0\" cellspacing=\"0\" cellpadding=\"3\" class=\"maintext\" bgcolor=\"#cccccc\">";
		
		echo "<tr>
			<td colspan=\"12\"><A href=\"?sesid=".SESID."\" class=\"maintext\">חזרה לתפריט הראשי</a></td>
		</tr>";
		echo "<tr><td colspan=\"12\" height=\"7\"></td></tr>";
			echo "<tr>
				<td colspan=\"12\"><A href=\"?main=users_list&sesid=".SESID."\" class=\"maintext\">חזרה לרשימת אתרים</a></td>
			</tr>";	
		echo "<tr><td colspan=\"12\" height=\"11\"></td></tr>";
		echo "<tr><td colspan=\"12\" height=\"11\"><h3>רשימת משתמשים המיועדים למחיקה לצמיתות</h3></td></tr>";
		
		echo "<tr><Td colspan=\"12\" align=center>";
			pagination( $num_all , "100" );		
		echo "</TD></tr>";
		
		echo "<tr><Td colspan=\"20\" height=\"5\"></TD></tr>";
		
		echo "<tr>";
			echo "<td><strong>מספר לקוח</strong></td>";
			echo "<td width=\"15\"></td>";
			echo "<td><strong>שם העסק</strong></td>";
			echo "<td width=\"15\"></td>";
			echo "<td><strong>שם מלא</strong></td>";
			echo "<td width=\"15\"></td>";
			echo "<td><strong>דומיין</strong></td>";
			echo "<td width=\"15\"></td>";
			echo "<td><strong>עדכון</strong></td>";
			echo "<td width=\"15\"></td>";
			echo "<td><strong>הסר מתור מחיקה</strong></td>";
			echo "<td width=\"15\"></td>";			
			
		echo "</tr>";
		
		$count = 0;
		while( $data = mysql_fetch_array($res) )	
		{
			$item_id++;

			$sql_user = "SELECT name,full_name,domain FROM users WHERE id=".$data['user_id']."";
			$res_user = mysql_db_query(DB,$sql_user);
			$data_user = mysql_fetch_array($res_user);
			
			

			$bg = ( $count%2 == 0 ) ? "eaeaea" : "f7f7f7";
			echo "<tr><Td colspan=\"12\" height=\"5\" height=\"5\"></TD></tr>";
			echo "<tr bgcolor=\"#{$bg}\"><Td colspan=\"104\" height=\"5\"></TD></tr>";
			echo "<tr bgcolor=\"#{$bg}\">";

				echo "<td>[".$item_id."]-".$data['user_id']."</td>";
				echo "<td width=\"10\"></td>";
				echo "<td>".$data_user['name']."</td>";
				echo "<td width=\"10\"></td>";
				echo "<td>".$data_user['full_name']."</td>";
				echo "<td width=\"10\"></td>";
				if( $data_user['domain'] == '' )
					echo "<td>אין דומיין</td>";
				else
					echo "<td><a href=\"http://".$data['domain']."\" target=\"_blank\" class=\"maintext\">".$data['domain']."</td>";
				
				
				echo "<td width=\"10\"></td>";
				
				if( AUTH >= 2 )
				{

				echo "<td><a target='_blank' href=\"?main=user_profile&unk=".$data['unk']."&record_id=".$data['id']."&sesid=".SESID."\" class=\"maintext\">עדכון</a></td>";
				echo "<td width=\"10\"></td>";
				}
				
				echo "<td>";

				echo "<br/><a onclick='return confirm(\"האם אתה בטוח שברצונך להסיר אתר זה מתור מחוקים לצמיתות?\")' href=\"?main=remove_user_to_delete&unk=".$data['unk']."&sesid=".SESID."\" class=\"maintext\">הסר מהתור</a>";
				
				echo "</td>";
				echo "<td width=\"10\"></td>";

			
			echo "</tr>";
			echo "<tr bgcolor=\"#{$bg}\"><Td colspan=\"12\" height=\"5\"></TD></tr>";
			$count++;
		}
		echo "<tr><Td colspan=\"12\" height=\"5\"></TD></tr>";
		
		echo "<tr><Td colspan=\"12\" align=center>";
			pagination( $num_all , "100" );		
		echo "</TD></tr>";
		
		echo "<tr><Td colspan=\"12\" height=\"5\"></TD></tr>";
	echo "</table>";
}
/********************************************************************************************************/



function pagination( $total , $limitPerPage )
{
	if( $total > $limitPerPage )
	{
		$z = 0;
		
		for($i=0 ; $i < $total ; $i++)
		{
			$pz = $z+1;
			
			if($i % $limitPerPage == 0)
			{
				if( $i == $_GET['limit'] )
					$classi = "<strong style=\"color:#000000\">".$pz."</strong>&nbsp;&nbsp;";
				else
				{
					if( eregi( "limit=" , $_SERVER[QUERY_STRING] ) )
					{
						$temp2 = explode("&" , $_SERVER[QUERY_STRING] );
						
						$new_query_string = "";
						
						for( $sting=0 ; $sting <= sizeof($temp2) ; $sting++ )
						{
							if( $temp2[$sting] != "" )
							{
								if( eregi("limit=" , $temp2[$sting] ) )
								{
									$temp3 = explode("=" , $temp2[$sting] );
									$new_query_string .= "limit=".$i."&";
								}
								else
									$new_query_string .= $temp2[$sting]."&";
							}
						}
						$new_query_string = substr($new_query_string,0,-1);
					}
					else
						$new_query_string = $_SERVER[QUERY_STRING]."&limit=".$i;
					
					$classi = "<a href='index.php?".$new_query_string."' class='maintext'>".$pz."</a>&nbsp;&nbsp;";
				}
				echo $classi;
											
				$z = $z + 1;
			}
		}
	}
}


function site_words()	{


	$sql = "select * from user_words where unk = '".$_REQUEST['unk']."'";
	$res = mysql_db_query(DB,$sql);
	$data = mysql_fetch_array($res);
	
	$temp_word_about = ( $data['id'] == "" ) ? "פרופיל עסק" : $data['word_about'];
	$temp_word_articels = ( $data['id'] == "" ) ? "כתבות" : $data['word_articels'];
	$temp_word_products = ( $data['id'] == "" ) ? "מוצרים" : $data['word_products'];
	$temp_word_gallery = ( $data['id'] == "" ) ? "גלרית תמונות" : $data['word_gallery'];
	$temp_word_yad2 = ( $data['id'] == "" ) ? "יד 2" : $data['word_yad2'];
	$temp_word_sales = ( $data['id'] == "" ) ? "מבצעים" : $data['word_sales'];
	$temp_word_video = ( $data['id'] == "" ) ? "גלרית וידאו" : $data['word_video'];
	$temp_word_wanted = ( $data['id'] == "" ) ? "דרושים" : $data['word_wanted'];
	$temp_word_contact = ( $data['id'] == "" ) ? "צור קשר" : $data['word_contact'];
	$temp_word_gb = ( $data['id'] == "" ) ? "" : $data['word_gb'];
	
	
	$hidde_about[0] = "לא";
	$hidde_about[1] = "כן";
	
	$hidde_articels[0] = "לא";
	$hidde_articels[1] = "כן";
	
	$hidde_products[0] = "לא";
	$hidde_products[1] = "כן";
	
	$hidde_gallery[0] = "לא";
	$hidde_gallery[1] = "כן";
	
	$hidde_yad2[0] = "לא";
	$hidde_yad2[1] = "כן";
	
	$hidde_sales[0] = "לא";
	$hidde_sales[1] = "כן";
	
	$hidde_video[0] = "לא";
	$hidde_video[1] = "כן";
	
	$hidde_wanted[0] = "לא";
	$hidde_wanted[1] = "כן";
	
	$hidde_contact[0] = "לא";
	$hidde_contact[1] = "כן";
	
	$hidde_gb[0] = "לא";
	$hidde_gb[1] = "כן";
	
	
	
	$portal_active_about[0] = "כן";
	$portal_active_about[1] = "לא";
	
	$portal_active_articels[0] = "כן";
	$portal_active_articels[1] = "לא";
	
	$portal_active_products[0] = "כן";
	$portal_active_products[1] = "לא";
	
	$portal_active_gallery[0] = "כן";
	$portal_active_gallery[1] = "לא";
	
	$portal_active_yad2[0] = "כן";
	$portal_active_yad2[1] = "לא";
	
	$portal_active_sales[0] = "כן";
	$portal_active_sales[1] = "לא";
	
	$portal_active_video[0] = "כן";
	$portal_active_video[1] = "לא";
	
	$portal_active_wanted[0] = "כן";
	$portal_active_wanted[1] = "לא";
		
	$portal_active_gb[0] = "כן";
	$portal_active_gb[1] = "לא";
	
	
	$coin_type[0] = "שקל (₪)";
	$coin_type[1] = "דולר ($)";
	$coin_type[2] = "יורו (&euro;)";
	
	
	$height = "<table border=\"0\" cellspacing=\"0\" cellpadding=\"0\"><tr><td height=2></td></tr></table>";
	
	$form_arr = array(
		array("hidden","main","update_DB_words"),
		array("hidden","record_id",$data['id']),
		array("hidden","sesid",SESID),
		array("hidden","unk",$_REQUEST['unk']),
		array("hidden","data_arr[unk]",$_REQUEST['unk']),
		
		array("text","data_arr[word_about]",$temp_word_about,"פרופיל עסק <span style=font-size:11px;>(שינוי שם הכפתור)</span>", "class='input_style'","","1"),
		array("select","hidde_about[]",$hidde_about,"להסתיר פרק?",$data['hidde_about'],"data_arr[hidde_about]", "class='input_style'"),
		array("select","portal_active_about[]",$portal_active_about,"פעיל בפורטל?",$data['portal_active_about'],"data_arr[portal_active_about]", "class='input_style'"),
		array("text","data_arr[word_about_title]",$data['word_about_title'],"פרופיל עסק <span style=font-size:11px;>(שינוי כותרת למעלה בדפדפן)</span>", "class='input_style'","","1"),
		
		
		array("blank",$height),
		array("text","data_arr[word_articels]",$temp_word_articels,"כתבות <span style=font-size:11px;>(שינוי שם הכפתור)</span>", "class='input_style'","","1"),
		array("select","hidde_articels[]",$hidde_articels,"להסתיר פרק?",$data['hidde_articels'],"data_arr[hidde_articels]", "class='input_style'"),
		array("select","portal_active_articels[]",$portal_active_articels,"פעיל בפורטל?",$data['portal_active_articels'],"data_arr[portal_active_articels]", "class='input_style'"),
		array("text","data_arr[word_articels_title]",$data['word_articels_title'],"כתבות <span style=font-size:11px;>(שינוי כותרת למעלה בדפדפן)</span>", "class='input_style'","","1"),
		
		array("blank",$height),
		array("text","data_arr[word_products]",$temp_word_products,"מוצרים <span style=font-size:11px;>(שינוי שם הכפתור)</span>", "class='input_style'","","1"),
		array("select","hidde_products[]",$hidde_products,"להסתיר פרק?",$data['hidde_products'],"data_arr[hidde_products]", "class='input_style'"),
		array("select","portal_active_products[]",$portal_active_products,"פעיל בפורטל?",$data['portal_active_products'],"data_arr[portal_active_products]", "class='input_style'"),
		array("text","data_arr[word_products_title]",$data['word_products_title'],"מוצרים <span style=font-size:11px;>(שינוי כותרת למעלה בדפדפן)</span>", "class='input_style'","","1"),
		
		array("blank",$height),
		array("text","data_arr[word_gallery]",$temp_word_gallery,"גלרית תמונות <span style=font-size:11px;>(שינוי שם הכפתור)</span>", "class='input_style'","","1"),
		array("select","hidde_gallery[]",$hidde_gallery,"להסתיר פרק?",$data['hidde_gallery'],"data_arr[hidde_gallery]", "class='input_style'"),
		array("select","portal_active_gallery[]",$portal_active_gallery,"פעיל בפורטל?",$data['portal_active_gallery'],"data_arr[portal_active_gallery]", "class='input_style'"),
		array("text","data_arr[word_gallery_title]",$data['word_gallery_title'],"גלרית תמונות <span style=font-size:11px;>(שינוי כותרת למעלה בדפדפן)</span>", "class='input_style'","","1"),
		
		array("blank",$height),
		array("text","data_arr[word_yad2]",$temp_word_yad2,"יד 2 <span style=font-size:11px;>(שינוי שם הכפתור)</span>", "class='input_style'","","1"),
		array("select","hidde_yad2[]",$hidde_yad2,"להסתיר פרק?",$data['hidde_yad2'],"data_arr[hidde_yad2]", "class='input_style'"),
		array("select","portal_active_yad2[]",$portal_active_yad2,"פעיל בפורטל?",$data['portal_active_yad2'],"data_arr[portal_active_yad2]", "class='input_style'"),
		array("text","data_arr[word_yad2_title]",$data['word_yad2_title'],"יד 2 <span style=font-size:11px;>(שינוי כותרת למעלה בדפדפן)</span>", "class='input_style'","","1"),
		
		array("blank",$height),
		array("text","data_arr[word_sales]",$temp_word_sales,"מבצעים <span style=font-size:11px;>(שינוי שם הכפתור)</span>", "class='input_style'","","1"),
		array("select","hidde_sales[]",$hidde_sales,"להסתיר פרק?",$data['hidde_sales'],"data_arr[hidde_sales]", "class='input_style'"),
		array("select","portal_active_sales[]",$portal_active_sales,"פעיל בפורטל?",$data['portal_active_sales'],"data_arr[portal_active_sales]", "class='input_style'"),
		array("text","data_arr[word_sales_title]",$data['word_sales_title'],"מבצעים <span style=font-size:11px;>(שינוי כותרת למעלה בדפדפן)</span>", "class='input_style'","","1"),
		
		array("blank",$height),
		array("text","data_arr[word_video]",$temp_word_video,"גלרית וידאו <span style=font-size:11px;>(שינוי שם הכפתור)</span>", "class='input_style'","","1"),
		array("select","hidde_video[]",$hidde_video,"להסתיר פרק?",$data['hidde_video'],"data_arr[hidde_video]", "class='input_style'"),
		array("select","portal_active_video[]",$portal_active_video,"פעיל בפורטל?",$data['portal_active_video'],"data_arr[portal_active_video]", "class='input_style'"),
		array("text","data_arr[word_video_title]",$data['word_video_title'],"גלרית וידאו <span style=font-size:11px;>(שינוי כותרת למעלה בדפדפן)</span>", "class='input_style'","","1"),
		
		array("blank",$height),
		array("text","data_arr[word_wanted]",$temp_word_wanted,"דרושים <span style=font-size:11px;>(שינוי שם הכפתור)</span>", "class='input_style'","","1"),
		array("select","hidde_wanted[]",$hidde_wanted,"להסתיר פרק?",$data['hidde_wanted'],"data_arr[hidde_wanted]", "class='input_style'"),
		array("select","portal_active_wanted[]",$portal_active_wanted,"פעיל בפורטל?",$data['portal_active_wanted'],"data_arr[portal_active_wanted]", "class='input_style'"),
		array("text","data_arr[word_wanted_title]",$data['word_wanted_title'],"דרושים <span style=font-size:11px;>(שינוי כותרת למעלה בדפדפן)</span>", "class='input_style'","","1"),
		
		array("blank",$height),
		array("text","data_arr[word_contact]",$temp_word_contact,"צור קשר <span style=font-size:11px;>(שינוי שם הכפתור)</span>", "class='input_style'","","1"),
		array("select","hidde_contact[]",$hidde_contact,"להסתיר פרק?",$data['hidde_contact'],"data_arr[hidde_contact]", "class='input_style'"),
		array("text","data_arr[word_contact_title]",$data['word_contact_title'],"צור קשר <span style=font-size:11px;>(שינוי כותרת למעלה בדפדפן)</span>", "class='input_style'","","1"),
		
		array("blank",$height),
		array("text","data_arr[word_gb]",$temp_word_gb,"ספר אורחים <span style=font-size:11px;>(שינוי שם הכפתור)</span>", "class='input_style'","","1"),
		array("select","hidde_gb[]",$hidde_gb,"להסתיר פרק?",$data['hidde_gb'],"data_arr[hidde_gb]", "class='input_style'"),
		array("select","portal_active_gb[]",$portal_active_gb,"פעיל בפורטל?",$data['portal_active_gb'],"data_arr[portal_active_gb]", "class='input_style'"),
		array("text","data_arr[word_gb_title]",$data['word_gb_title'],"ספר אורחים <span style=font-size:11px;>(שינוי כותרת למעלה בדפדפן)</span>", "class='input_style'","","1"),
		
		array("blank",$height),
		
		array("select","coin_type[]",$coin_type,"סוג מטבע",$data['coin_type'],"data_arr[coin_type]", "class='input_style'"),
		
		
		array("submit","submit","שמירה", "class='submit_style'")
	);

$more = "class='maintext'";

	echo "<table border=\"0\" cellspacing=\"0\" cellpadding=\"0\" class=\"maintext\">";
		
		echo "<tr>";
			echo "<td><A href=\"?&sesid=".SESID."\" class=\"maintext\">חזרה לתפריט הראשי</a></td>";
		echo "</tr>";
		echo "<tr><td height=\"7\"></td></tr>";
		echo "<tr>";
			echo "<td><A href=\"?main=users_list&sesid=".SESID."\" class=\"maintext\">לרשימת האתרים</a></td>";
		echo "</tr>";
		
		echo "<tr><td height=\"11\"></td></tr>";
		
		echo "<tr>";
			echo "<td>
			<u><b>הערות חשובות:</b></u>
				<ul>
					<li>השארת שדה הכיתוב ריק (שם הכפתור)  -> <b>מחיקת הפרק!</b></li>
					<li>הסתרת פרק - הכפתור לא יוצג בתפריט באתר, אך יהיה ניתן לעדכן הנ\"ל באמצעות מערכת עדכון אתר</li>
					<li>במידה ותשאירו את כותרת הדפדפן ריק, שם הכפתור יופיע כברירת מחדל</li>
				</ul>
			</td>";
		echo "</tr>";
		
		echo "<tr><td height=\"5\"></td></tr>";
		echo "<tr>";
			echo "<td>".FormCreator::create_form($form_arr,"index.php", $more)."</td>";
		echo "</tr>";
		
		
	echo "</table>";
}
/********************************************************************************************************/

function update_DB_words()	{

	if( $_REQUEST['record_id'] == "" )	{
		$image_settings = array(
			after_success_goto=>"?main=users_list&sesid=".SESID."",
			table_name=>"user_words",
		);
		$data_arr = ($_POST['data_arr'])? $_POST['data_arr'] : $_GET['data_arr'];
		insert_to_db($data_arr, $image_settings);
	}
	else	{
		$image_settings = array(
			after_success_goto=>"?main=users_list&sesid=".SESID."",
			table_name=>"user_words",
		);
		$data_arr = ($_POST['data_arr'])? $_POST['data_arr'] : $_GET['data_arr'];
		update_db($data_arr, $image_settings);
	}
}




function marketing_partners()
{
	
	$sql = "select id,unk,username,name,full_name,domain from users where deleted = '0' and status = '0'";
	$res = mysql_db_query(DB,$sql);

	echo "<table border=\"0\" cellspacing=\"0\" cellpadding=\"3\" class=\"maintext\" bgcolor=\"#cccccc\">";
		
		echo "<tr>
			<td colspan=\"20\"><A href=\"?sesid=".SESID."\" class=\"maintext\">חזרה לתפריט הראשי</a></td>
		</tr>";

		echo "<tr><td colspan=\"20\" height=\"11\"></td></tr>";
		echo "<tr>";
			echo "<td><strong>שם העסק</strong></td>";
			echo "<td width=\"15\"></td>";
			echo "<td><strong>שם מלא</strong></td>";
			echo "<td width=\"15\"></td>";
			echo "<td><strong>שם משתמש</strong></td>";
			echo "<td width=\"15\"></td>";
			echo "<td><strong>אתר</strong></td>";
			echo "<td width=\"15\"></td>";
			echo "<td><strong>באנרים</strong></td>";
			echo "<td width=\"15\"></td>";
			echo "<td><strong>התאמה</strong></td>";
		echo "</tr>";
		
		$count = 0;
		while( $data = mysql_fetch_array($res) )	
		{
			$bg = ( $count%2 == 0 ) ? "eaeaea" : "f7f7f7";
			echo "<tr><Td colspan=\"20\" height=\"5\" height=\"5\"></TD></tr>";
			echo "<tr bgcolor=\"#{$bg}\"><Td colspan=\"20\" height=\"5\"></TD></tr>";
			echo "<tr bgcolor=\"#{$bg}\">";
				echo "<td>".stripslashes($data['name'])."</td>";
				echo "<td width=\"10\"></td>";
				echo "<td>".stripslashes($data['full_name'])."</td>";
				echo "<td width=\"10\"></td>";
				echo "<td>".stripslashes($data['username'])."</td>";
				echo "<td width=\"10\"></td>";
				if( $data['status'] == 0 )
					echo "<td><a href=\"http://".$data['domain']."\" target=\"_blank\" class=\"maintext\">לאתר</td>";
				else
					echo "<td>לא קיים אתר</td>";
				
				echo "<td width=\"10\"></td>";
				echo "<td><a href=\"?main=banners_marketing_partners&unk=".stripslashes($data['unk'])."&sesid=".SESID."\" class=\"maintext\">באנרים</a></td>";
				echo "<td width=\"10\"></td>";
				echo "<td>התאמה</td>";
			echo "</tr>";
			echo "<tr bgcolor=\"#{$bg}\"><Td colspan=\"20\" height=\"5\"></TD></tr>";
			$count++;
		}
		echo "<tr><Td colspan=\"20\" height=\"5\" height=\"5\"></TD></tr>";
		
	echo "</table>";
}


function banners_marketing_partners()
{
	$sql = "select * from marketing_partners_bann_type";
	$res = mysql_db_query(DB,$sql);

	echo "<table border=\"0\" cellspacing=\"0\" cellpadding=\"3\" class=\"maintext\">";
		
		echo "<tr>
			<td colspan=\"20\"><A href=\"?sesid=".SESID."\" class=\"maintext\">חזרה לתפריט הראשי</a></td>
		</tr>";
		
		echo "<tr><Td colspan=\"20\" height=\"5\"></TD></tr>";
		
		echo "<tr>
			<td colspan=\"20\"><A href=\"?main=marketing_partners&sesid=".SESID."\" class=\"maintext\">חזרה שיווק שותפים</a></td>
		</tr>";
		
		echo "<tr><td colspan=\"20\" height=\"11\"></td></tr>";
		echo "<tr>";
			echo "<td><strong>באנר</strong></td>";
			echo "<td width=\"15\"></td>";
			echo "<td><strong>תיאור</strong></td>";
			echo "<td width=\"15\"></td>";
			echo "<td><strong>הצג</strong></td>";
		echo "</tr>";
		
		while( $data = mysql_fetch_array($res) )	
		{
			echo "<tr><Td colspan=\"20\" height=\"5\" height=\"5\"></TD></tr>";
			echo "<tr><Td colspan=\"20\" height=\"5\"></TD></tr>";
			echo "<tr>";
				echo "<td>".stripslashes($data['name'])."</td>";
				echo "<td width=\"10\"></td>";
				echo "<td>".stripslashes($data['desc'])."</td>";
				echo "<td width=\"10\"></td>";
				echo "<td><a href=\"?main=view_bann_MP&banner_type=".$data['id']."&unk=".$_GET['unk']."&sesid=".SESID."\" class=\"maintext\">הצג</a></td>";
			echo "</tr>";
			echo "<tr><Td colspan=\"20\" height=\"5\"></TD></tr>";
		}
		
	echo "</table>";
}


function view_bann_MP()
{
	$sql = "select * from marketing_partners where deleted=0 and type = '".$_GET['banner_type']."' and unk = '".$_GET['unk']."'";
	$res = mysql_db_query(DB,$sql);


	echo "<table border=\"0\" cellspacing=\"0\" cellpadding=\"3\" class=\"maintext\">";
		
		echo "<tr>
			<td colspan=\"20\"><A href=\"?sesid=".SESID."\" class=\"maintext\">חזרה לתפריט הראשי</a></td>
		</tr>";
		
		echo "<tr><Td colspan=\"20\" height=\"5\"></TD></tr>";
		
		echo "<tr>
			<td colspan=\"20\"><A href=\"?main=marketing_partners&sesid=".SESID."\" class=\"maintext\">חזרה שיווק שותפים</a></td>
		</tr>";
		
		echo "<tr><Td colspan=\"20\" height=\"5\"></TD></tr>";
		
		echo "<tr>
			<td colspan=\"20\"><A href=\"?main=banners_marketing_partners&unk=".$_GET['unk']."&sesid=".SESID."\" class=\"maintext\">חזרה שיווק שותפים - מיקומים</a></td>
		</tr>";
		
		
		echo "<tr><Td colspan=\"20\" height=\"5\"></TD></tr>";
		
		echo "<tr>
			<td colspan=\"20\"><A href=\"?main=update_bann_MP&unk=".$_GET['unk']."&sesid=".SESID."\" class=\"maintext\"><b>הוספת באנר חדש</b></a></td>
		</tr>";
		
		echo "<tr><td colspan=\"20\" height=\"11\"></td></tr>";
		echo "<tr>";
			echo "<td><strong>מספר באנר</strong></td>";
			echo "<td width=\"15\"></td>";
			echo "<td><strong>קליקים</strong></td>";
			echo "<td width=\"15\"></td>";
			echo "<td><strong>צפיה</strong></td>";
			echo "<td width=\"15\"></td>";
			echo "<td><strong>סטטוס</strong></td>";
			echo "<td width=\"15\"></td>";
			echo "<td><strong>צפה</strong></td>";
			echo "<td width=\"15\"></td>";
			echo "<td><strong>עדכן</strong></td>";
			echo "<td width=\"15\"></td>";
			echo "<td><strong>מחק</strong></td>";
		echo "</tr>";
		
		while( $data = mysql_fetch_array($res) )	
		{
			switch($data['status'])
				{
					case "0" :				$status = "פעיל";							break;
					case "1" :				$status = "לא פעיל";							break;
				}
			
			$abpath_temp = "/home/ilan123/domains/ilbiz.co.il/public_html/ClientSite/site_banners/".$data['banner_name'];
			if( file_exists($abpath_temp) && !is_dir($abpath_temp) )
				$ban_cv = "<a href=\"http://www.ilbiz.co.il/ClientSite/site_banners/".$data['banner_name']."\" class=\"maintext\" target='_blank'>צפה</a>";
			
			echo "<tr><Td colspan=\"20\" height=\"5\"></TD></tr>";
			echo "<tr>";
				echo "<td>".$data['id']."</td>";
				echo "<td width=\"15\"></td>";
				echo "<td>".$data['clicks']."</td>";
				echo "<td width=\"15\"></td>";
				echo "<td>".$data['views']."</td>";
				echo "<td width=\"15\"></td>";
				echo "<td>".$status."</td>";
				echo "<td width=\"15\"></td>";
				echo "<td>".$ban_cv."</td>";
				echo "<td width=\"15\"></td>";
				echo "<td><a href=\"?main=update_bann_MP&banner_type=".$data['type']."&bann_id=".$data['id']."&unk=".$_GET['unk']."&sesid=".SESID."\" class=\"maintext\">עדכן</a></td>";
				echo "<td width=\"15\"></td>";
				echo "<td><a href=\"?main=del_bann_MP&banner_type=".$data['type']."&bann_id=".$data['id']."&del_type=4451864&unk=".$_GET['unk']."&sesid=".SESID."\" class=\"maintext\" onclick=\"return can_i_del()\">מחק</a></td>";
			echo "</tr>";
			echo "<tr><Td colspan=\"20\" height=\"5\"></TD></tr>";
		}
	echo "</table>";
}


function update_bann_MP()
{
	
	$sql = "select * from marketing_partners where deleted=0 and unk = '".$_GET['unk']."' and id = '".$_GET['bann_id']."'";
	$res = mysql_db_query(DB,$sql);
	$data = mysql_fetch_array($res);
	
	
		$form_arr = array(
			type => "מיקום הבאנר",
			
			banner_name => "באנר",
			banner_height => "באנר - גובה",
			banner_width => "באנר - רוחב",
			banner_color => "באנר - צבע הפלאש",
			
			status => "סטטוס",
		);
//	}
	
	echo "<form action=\"index.php\" name=\"update_bann_MP_form\" method=\"post\" enctype=\"multipart/form-data\">";
	echo "<input type=\"hidden\" name=\"main\" value=\"update_DB_bann_MP\">";
	echo "<input type=\"hidden\" name=\"record_id\" value=\"".$data['id']."\">";
	echo "<input type=\"hidden\" name=\"sesid\" value=\"".SESID."\">";
	echo "<input type=\"hidden\" name=\"unk\" value=\"".$_GET['unk']."\">";
	echo "<input type=\"hidden\" name=\"type\" value=\"".$_GET['banner_type']."\">";
	echo "<table border=\"0\" cellspacing=\"0\" cellpadding=\"0\" class=\"maintext\">";
		
		// foreach for create the form
		foreach( $form_arr as $val => $key )	{
			echo "<tr>";
				echo "<td>".$key."</td>";
				echo "<td width=\"10\"></td>";
				echo "<td>";
					switch($val)	{
						
						case "banner_name" :
							$abpath_temp = "/home/ilan123/domains/ilbiz.co.il/public_html/ClientSite/site_banners/".$data['banner_name'];
							if( file_exists($abpath_temp) && !is_dir($abpath_temp) )
								$details_img = "&nbsp;&nbsp;<a href=\"http://www.ilbiz.co.il/ClientSite/site_banners/".$data['banner_name']."\" class=\"maintext_small\" target=\"_blank\">צפה</a>
								&nbsp;&nbsp;|&nbsp;&nbsp;<a href=\"index.php?main=del_bann_MP&banner_type=".$data['type']."&bann_id=".$data['id']."&del_type=44512&unk=".$_GET['unk']."&sesid=".SESID."\" class=\"maintext_small\" onclick=\"return can_i_del()\">מחק </a>";
							
							echo "<input type='file' name='".$val."' value='' class=\"input_style\">".$details_img;
						break;
						
						case "banner_height" :
						case "banner_width" :
							echo "<input type='text' name='".$val."' value='".GlobalFunctions::remove_geresh(stripslashes($data[$val]))."' class=\"input_style\">";
						break;
						
						case "type" :
							$sql_type = "select * from marketing_partners_bann_type";
							$res_type = mysql_db_query(DB,$sql_type);
							echo "<select name='".$val."' class=\"input_style\">";
								while( $data_type = mysql_fetch_array($res_type) )
								{
									$selected = ( $data_type['id'] == $data['type'] ) ? "selected" : "";
									echo "<option value='".$data_type['id']."' ".$selected.">".stripslashes($data_type['name'])."</option>";
								}
							echo "</select>";
						break;
						
						case "status" :
							echo "<select name='".$val."' class=\"input_style\">";
									$selected0 = ( $data['status'] == "0" ) ? "selected" : "";
									$selected1 = ( $data['status'] == "1" ) ? "selected" : "";
								echo "<option value='0' ".$selected0.">פעיל</option>";
								echo "<option value='1' ".$selected1.">לא פעיל</option>";
							echo "</select>";
						break;
						
						
						default :
							echo "<input type=\"text\" name=\"".$val."\" value=\"".$data[$val]."\" style=\"background-color: #".stripslashes($data[$val]).";\" class=\"input_style\" maxlength=\"6\">&nbsp;&nbsp;<a href=\"#\" onclick='javascript:colors(\"".$val."\",\"".$val."\")' class=\"maintext\">בחירת צבע</a>";
					}
				echo "</td>";
			echo "</tr>";
			
			
			echo "<tr><td colspan=\"3\" height=\"6\"></td></tr>";
			
		}
		
		echo "<tr>";
			echo "<td>&nbsp;</td>";
			echo "<td width=\"\"></td>";
			echo "<td><input type=\"Submit\" value=\"שמירת נתונים\" class=\"submit_style\"></td>";
		echo "</tr>";
		
	echo "</table>";
	echo "</form>";
}

function update_DB_bann_MP()
{
	$form_arr2 = array(
		type => "type",
		banner_height => "banner_height",
		banner_width => "banner_width",
		banner_color => "banner_color",
		status => "status",
		unk => "unk",
	);
	
	$counter1 = 1;
	$counter2 = 1;
	if( $_REQUEST['record_id'] == "" )	{
		$sql = "insert into marketing_partners (";
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
	}
	else	{
		$sql = "update marketing_partners set ";
		foreach( $form_arr2 as $val => $key )	{
			if( $key != "unk" )
			{
				$with_psik = ( $counter1 == (sizeof($form_arr2)-1) ) ? " " : ", ";
				$sql .= $val." = '".GlobalFunctions::add_geresh(addslashes($_REQUEST[$key]))."'".$with_psik;
				
				$counter1++;
			}
		}
		$sql .= "where unk = '".$_REQUEST['unk']."' and id = '".$_REQUEST['record_id']."' limit 1";
		$res = mysql_db_query(DB,$sql);
		
		$row_id = $_REQUEST['record_id'];
	}
	
	$field_name = array("banner_name");
	
				//check if files being uploaded
				if($_FILES)
					{
						for($temp=0 ; $temp<sizeof($field_name) ; $temp++)
							{
							$temp_name = $field_name[$temp];
							
								if ( $_FILES[$temp_name]['name'] != "" )
								{
									$exte = substr($_FILES[$temp_name]['name'],(strpos($_FILES[$temp_name]['name'],".")+1));
									$logo_name2 = $_POST['unk']."-".$_POST['type']."-".$row_id.".".$exte;
									$tempname = $logo_name;
									
									$pth_temo = "/home/ilan123/domains/ilbiz.co.il/public_html/ClientSite/site_banners/".$logo_name2;
									
										@copy($_FILES[$temp_name]['tmp_name'], $pth_temo);
										
										$sql = "UPDATE marketing_partners SET banner_name = '".$logo_name2."' WHERE id = '".$row_id."' limit 1";
										$res = mysql_db_query(DB,$sql);
								}
							}
					}
	
	echo "<script>window.location.href='?main=view_bann_MP&banner_type=".$_POST['type']."&unk=".$_POST['unk']."&sesid=".SESID."'</script>";
		exit;
}


function del_bann_MP()
{
	$del_type = $_GET['del_type'];
	
	$sql = "SELECT id, banner_name FROM marketing_partners WHERE unk = '".$_GET['unk']."' and id = '".$_GET['bann_id']."' limit 1";
	$res_check = mysql_db_query(DB,$sql);
	$data_check = mysql_fetch_array($res_check);
	
	switch($del_type)
	{
		case "44512" :
			if( $data_check['id'] != "" )
			{
				$abpath_temp = "/home/ilan123/domains/ilbiz.co.il/public_html/ClientSite/site_banners/".$data_check['banner_name'];
				
				if( file_exists($abpath_temp) && !is_dir($abpath_temp) )
				{
					unlink($abpath_temp);
					
					$sql = "UPDATE marketing_partners SET banner_name = '' WHERE unk = '".$_GET['unk']."' and id = '".$_GET['bann_id']."' limit 1";
					$res = mysql_db_query(DB,$sql);
					
					echo "<script>alert('הקובץ נמחק בהצלחה');</script>";
				}
				else
					echo "<script>alert('#5545133 לא ניתן למחוק קובץ - הקובץ לא נמצא');</script>";
			}
			else
				echo "<script>alert('#5545132 לא ניתן למחוק קובץ');</script>";
		break;
		
		case "4451864" :
			if( $data_check['id'] != "" )
			{
				$abpath_temp = "/home/ilan123/domains/ilbiz.co.il/public_html/ClientSite/site_banners/".$data_check['banner_name'];
				
				if( file_exists($abpath_temp) && !is_dir($abpath_temp) )
				{
					unlink($abpath_temp);
					
					$sql = "UPDATE marketing_partners SET banner_name = '' WHERE unk = '".$_GET['unk']."' and id = '".$_GET['bann_id']."' limit 1";
					$res = mysql_db_query(DB,$sql);
				}
			}
			
			$sql = "UPDATE marketing_partners SET deleted = '1' WHERE unk = '".$_GET['unk']."' and id = '".$_GET['bann_id']."' limit 1";
			$res = mysql_db_query(DB,$sql);
		break;
	}
	
	echo "<script>window.location.href='?main=view_bann_MP&banner_type=".$_GET['banner_type']."&unk=".$_GET['unk']."&sesid=".SESID."'</script>";
		exit;
}



function change_site_domain()
{
	
	//change_site_domain_CONF
	
	echo "<table class='maintext'>";
	echo "<form action='?' method='POST' name='change_site_domain_form'>";
	echo "<input type='hidden' name='main' value='change_site_domain_CONF'>";
	echo "<input type='hidden' name='sesid' value='".SESID."'>";
		echo "<tr>
			<td colspan=\"3\"><A href=\"?sesid=".SESID."\" class=\"maintext\">חזרה לתפריט הראשי</a></td>
		</tr>";
		
		echo "<tr><Td colspan=\"3\" height=\"5\"></TD></tr>";
		
		echo "<tr>";
			echo "<td colspan=3>
			* המערכת מחליפה באופן אוטומטי את הדומיין של האתר<br>
			* פעולה זו יכולה להמשך כמה שעות<br>
			* חייב שהדומיין הישן יהיה מוגדר באתר שבו רוצים להעביר את הדומיין<br>
			* חייב שהדומיין החדש יהיה מוגדר במערכת ומאושר על ידי אילן
			</td>";
		echo "</tr>";
		
		echo "<tr>";
			echo "<td>דומיין ישן</td>";
			echo "<td width='10'></td>";
			echo "<td><input type='text' name='old_domain' class='input_style'></td>";
		echo "</tr>";
		echo "<tr><td colspan=3 height='5'></td></tr>";
		echo "<tr>";
			echo "<td>דומיין חדש</td>";
			echo "<td width='10'></td>";
			echo "<td><input type='text' name='new_domain' class='input_style'></td>";
		echo "</tr>";
		echo "<tr><td colspan=3 height='5'></td></tr>";
		echo "<tr>";
			echo "<td></td>";
			echo "<td width='10'></td>";
			echo "<td><input type='submit' value='שלח' class='input_style'></td>";
		echo "</tr>";
		
	echo "</form>";
	echo "</table>";
}

function change_site_domain_CONF()
{
	$old_domain = trim($_POST['old_domain']);
	$new_domain = trim($_POST['new_domain']);
	
	$error_1 = true;
	$error_2 = true;
	$error_3 = true;
	$error_4 = true;
	$error_5 = true;
	
	
	// Errors
	$owner_id = ( AUTH == "9" ) ? "" : " and owner_id = '".OID."'"; 
	$qry = "SELECT id,unk from users where domain = '".$old_domain."' ".$owner_id."";
	$res = mysql_db_query(DB,$qry);
	$num_rows_oid = mysql_num_rows($res);
	
	// המערכת מחפשת האם הבעל האתרים - יש לו באמת את האתר הנל
	if( $num_rows_oid == "0" )
	{
		$error_1 = false;
		echo "<script>alert('#46211-4 התראת אבטחה');</script>";
		echo "<script>window.location.href='?main=change_site_domain&sesid=".SESID."'</script>";
	}
	
	$qry = "SELECT id from users where domain = '".$old_domain."' ";
	$res = mysql_db_query(DB,$qry);
	$num_rows_oldDomain = mysql_num_rows($res);
	
	// על מנת שלא יהיו 2 ID
	if( $num_rows_oldDomain > "1" )
	{
		$error_2 = false;
		echo "<script>alert('#46211-1 דומיין ישן - המערכת מצאה יותר מדומיין זהה אחד');</script>";
		echo "<script>window.location.href='?main=change_site_domain&sesid=".SESID."'</script>";
	}
	
	// על מנת שיהיה ID ריק
	if( $num_rows_oldDomain == "0" )
	{
		$error_3 = false;
		echo "<script>alert('#46211-2 דומיין ישן - לא נמצא');</script>";
		echo "<script>window.location.href='?main=change_site_domain&sesid=".SESID."'</script>";
	}
	
	$qry = "SELECT id from users where domain = '".$new_domain."' ";
	$res = mysql_db_query(DB,$qry);
	$num_rows_newDomain = mysql_num_rows($res);
	
	// על מנת לא לדרוס אתר קיים
	if( $num_rows_newDomain > "0" )
	{
		$error_4 = false;
		echo "<script>alert('#46211-3 דומיין חדש - המערכת מצאה דומיין זהה');</script>";
		echo "<script>window.location.href='?main=change_site_domain&sesid=".SESID."'</script>";
	}
	
	
	
	$path_to_copy = "/home/ilan123/domains/".$new_domain."/public_html/";
	
	if( !is_dir($path_to_copy) )
	{
		$error_5 = false;
		echo "<script>alert('#46211-5 דומיין חדש - יש ליצור תחילה במערכת דומיין (ליצור קשר עם אילן)');</script>";
		echo "<script>window.location.href='?main=change_site_domain&sesid=".SESID."'</script>";
	}
	
	
	// הפעולה מעתיקה את קבצי האתר לספרית דומיין החדשה
	if( $error_1 == true && $error_2 == true && $error_3 == true && $error_4 == true && $error_5 == true )
	{
		$qry = "SELECT id,unk from users where domain = '".$old_domain."' ".$owner_id."";
		$res = mysql_db_query(DB,$qry);
		$data = mysql_fetch_array($res);
		
		
		// שלב ראשון המערכת מקימה את בסיס האתר - מקימה את הקבצים
		$data_arr['domain'] = $new_domain;
		$data_arr['unk'] = $data['unk'];
		
		include('build_settings_file.php');
		
		
		$_SESSION['change_domain']['security_code_for_domain'] = "asd112655asd4223#sdAS324@@@$1122asd%$@@!555g%@!$2211sD$^&@";
		$_SESSION['change_domain']['my_unk'] = $data['unk'];
		$_SESSION['change_domain']['new_domain'] = $new_domain;
		$_SESSION['change_domain']['old_domain'] = $old_domain;
		
		
		include('CONFIG_change_site_domain.php');
		
		$qry = "UPDATE users set domain = '".$new_domain."' where domain = '".$old_domain."' ".$owner_id."";
		$res = mysql_db_query(DB,$qry);
	}
}

function sn_example_sites()
{
	$sql = "select content from sn_example_sites where id ='1'";
	$res = mysql_db_query(DB,$sql);
	$data = mysql_fetch_array($res);
	
	echo "
	<form action='?' name='sn_example_sites_form' method='POST'>
	<input type='hidden' name='main' value='sn_example_sites_DB_update'>
	<input type='hidden' name='sesid' value='".SESID."'>
	<table class='maintext' width='700'>
		<tr>
			<td>תוכן:<br><br></td>
		</tr>
		<tr>
			<td>";
$sBasePath = $_SERVER['PHP_SELF'] ;
//$sBasePath = substr( $sBasePath, 0, strpos( $sBasePath, "_samples" ) ) ;
$sBasePath = "http://www.ilbiz.co.il/ClientSite/administration/fckeditor/" ;

$oFCKeditor = new FCKeditor('content') ;
$oFCKeditor->BasePath	= $sBasePath ;
$oFCKeditor->Value		= stripcslashes($data['content']) ;
$oFCKeditor->Create() ;
			echo "</td>
		</tr>
		<tr>
			<td><input type='submit' value='שלח'></td>
		</tr>
	</table>
	</form>";
}

function sn_example_sites_DB_update()
{
	
	$sql = "update sn_example_sites set content = '".addslashes($_POST['content'])."' where id = '1'";
	$res = mysql_db_query(DB,$sql);
	
	echo "<script>window.location.href='?sesid=".SESID."';</script>";
		exit;
}

function view_calender_style_defualt()
{
	echo "<p align=left dir=ltr>
		.calendar_bg{<br>
			background-color:#ffffff; /*צבע רקע כללי ללוח שנה*/<br>
			border: 0px solid #000000; /*צבע מסגרת border: גודלpx solid צבע*/<br>
			color:000000; /* צבע הכתב בתוך המסגרת */<br>
		}<br>
		<br>
		.calendar_month_bg{<br>
			background-color:#ffffff; /*צבע רקע כללי ללוח שנה*/<br>
			color:000000; /* צבע הכתב בתוך המסגרת */<br>
		}<br>
		<br>
		.calendar_week_days{<br>
			background-color:#E6E6E6; /*צבע רקע לתא של הימים לא כולל יום שבת*/<br>
			color:000000; /* צבע הכתב לתא של הימים לא כולל יום שבת */<br>
		}<br>
		<br>
		.calendar_week_days_shabat{<br>
			background-color:#C8C8C8; /*צבע רקע לתא של הימים רק יום שבת*/<br>
			color:000000; /* צבע הכתב לתא של הימים רק יום שבת */<br>
		}<br>
		<br>
		.calendar_month_days_regular{<br>
			background-color:#ffffff; /*צבע רקע לתא של המספרים של החודש לא כולל לא כולל יום של היום*/<br>
			color:000000; /* צבע הכתב לתא של המספרים של החודש לא כולל יום של היום */<br>
		}<br>
		.calendar_month_days_regular_today{<br>
			background-color:#ffffff; /*	צבע רקע לתא של המספרים של החודש של היום/הנבחר	*/<br>
			color:000000; /* צבע הכתב לתא של המספרים של החודש של היום/הנבחר */<br>
			text-decoration: underline; /* אם יהיה קו תחתון none-לא, underline-כן*/<br>
		}<br>
		<br>
		.calendar_month_days_regular_event{<br>
			background-color:#707070; /*צבע רקע לתא של המספרים של החודש לא כולל לא כולל יום של היום*/<br>
			color:ffffff; /* צבע הכתב לתא של המספרים של החודש לא כולל יום של היום */<br>
			text-decoration: none;<br>
		}<br>
		.calendar_month_days_regular_event a:link{background-color:#707070;color:ffffff;text-decoration: none;}<br>
		.calendar_month_days_regular_event a:hover{background-color:#707070;color:ffffff;text-decoration: none;}<br>
		.calendar_month_days_regular_event a:active{background-color:#707070;color:ffffff;text-decoration: none;}<br>
		.calendar_month_days_regular_event a:visited{background-color:#707070;color:ffffff;text-decoration: none;}<br>
		<br>
		.calendar_month_days_regular_today_event {<br>
			background-color:#707070; /*	צבע רקע לתא של המספרים של החודש של היום/הנבחר	*/<br>
			color:ffffff; /* צבע הכתב לתא של המספרים של החודש של היום/הנבחר */<br>
			text-decoration: underline; /* אם יהיה קו תחתון none-לא, underline-כן*/<br>
		}<br>
		.calendar_month_days_regular_today_event a:link{background-color:#707070;color:ffffff;text-decoration: underline;}<br>
		.calendar_month_days_regular_today_event a:hover{background-color:#707070;color:ffffff;text-decoration: underline;}<br>
		.calendar_month_days_regular_today_event a:active{background-color:#707070;color:ffffff;text-decoration: underline;}<br>
		.calendar_month_days_regular_today_event a:visited{background-color:#707070;color:ffffff;text-decoration: underline;}<br>
	</p>";
}

function global_settings()	{
	
	/*
	HOW TO  ----- add parameters to main settigs:
	insert rows to main_settings_kv
	*select title(will eppear as field name on admin)
	*select val_type of the options:
		1-text
		2-shortvarchar (varchar 20)
		3-varchar (varchar 150)
		4-tinyint
		5-int
	*select param_name.
	*go to admin in main_settings and you will see the field and can edit the value
	*/
	$update_messege = "";
	if(isset($_GET['update_cache'])){
		$cache_sql = "update main_settings SET cache_version = cache_version+1 WHERE 1";
		$cache_res = mysql_db_query(DB,$cache_sql);
		$update_messege = "<h4 style='color:red;'>המטמון חודש</h4>";
	}
	if(isset($_POST['update_global_settings'])){
		$show_phone_bar = $_POST['show_phone_bar'];
		$block_ips = trim($_POST['block_ips']);
		$yaad_user = trim($_POST['yaad_user']);
		$yaad_pass = trim($_POST['yaad_pass']);
		$email_filter = trim($_POST['email_filter']);
		$c_tracking_on = $_POST['c_tracking_on'];
		$whatsapp_on = $_POST['whatsapp_on'];
		
		$qry = "UPDATE main_settings SET show_phone_bar = '".$show_phone_bar."', c_tracking_on = '".$c_tracking_on."',block_ips = '".$block_ips."',whatsapp_on = '".$whatsapp_on."',email_filter = '".$email_filter."' WHERE 1";
		$res = mysql_db_query(DB,$qry);	
		$qry = "UPDATE main_settings SET yaad_user = '".$yaad_user."',yaad_pass = '".$yaad_pass."' WHERE 1";
		$res = mysql_db_query(DB,$qry);
		
		
		foreach($_REQUEST['kv'] as $kv_param_type=>$kv_data){
			foreach($kv_data as $kv_param_name=>$kv_val){
				$sql = "UPDATE main_settings_kv SET ".$kv_param_type."_val = '".$kv_val."' WHERE param_name = '".$kv_param_name."'";
				$res = mysql_db_query(DB,$sql);
			}
		}
		$update_messege = "<h4 style='color:red;'>ההגדרות נשמרו</h4>";
		
	}
	//change_global_settings
		$qry = "SELECT * from main_settings";
		$res = mysql_db_query(DB,$qry);
		$data = mysql_fetch_array($res);
	
		$kv_settings = array();
		$kv_sql = "SELECT * FROM main_settings_kv";
		$kv_res = mysql_db_query(DB,$kv_sql);
		while($kv_data = mysql_fetch_array($kv_res)){
			$kv_settings[$kv_data['param_name']] = $kv_data;
		}
	
	echo "<table class='maintext'>";
	echo "<form action='?' method='POST' name='change_global_settings'>";
	echo "<input type='hidden' name='main' value='global_settings'>";
	echo "<input type='hidden' name='update_global_settings' value='1'>";
	echo "<input type='hidden' name='sesid' value='".SESID."'>";
		echo "<tr>
			<td colspan=\"3\"><A href=\"?sesid=".SESID."\" class=\"maintext\">חזרה לתפריט הראשי</a></td>
		</tr>";
		echo "<tr>
			<td colspan=\"3\"><A href=\"?main=global_guides&sesid=".SESID."\" class=\"maintext\">מדריכים</a></td>
		</tr>";		
		echo "<tr><Td colspan=\"3\" height=\"5\">";
			echo $update_messege;
		
		echo "</TD></tr>";
		
		echo "<tr>";
			echo "<td colspan=3>
			<h3>
			הגדרות כלליות
			</h3>
			</td>";
		echo "</tr>";
		echo "<tr>";
			echo "<td>גרסת מטמון נוכחית</td>";
			echo "<td width='10'></td>";
				echo "<td>
					".$data['cache_version']."
					&nbsp;&nbsp;&nbsp;
					<a href='?main=global_settings&sesid=".SESID."&update_cache=1'>לחץ כאן לחידוש המטמון</a>
				</td>";
		echo "</tr>";
		echo "<tr><td colspan=3 height='5'></td></tr>";

		
		echo "<tr>";
			echo "<td>הצג טלפונים באתרים</td>";
			echo "<td width='10'></td>";
				$selected2 = ( $data['show_phone_bar'] == "2" ) ? "selected" : "";
				$selected1 = ( $data['show_phone_bar'] == "1" ) ? "selected" : "";
				$selected0 = ( $data['show_phone_bar'] == "0" ) ? "selected" : "";
				echo "<td>
					<select name='show_phone_bar' id='show_phone_bar' class='input_style' style='width: 160px;'>
						<option value=''>בחירה</option>
						<option value='0' ".$selected0.">לא להציג</option>
						<option value='1' ".$selected1.">להציג לפי טלפון הלקוח</option>						
						<option value='2' ".$selected2.">להציג לפי הטלפון בקטגוריה</option>
					</select>
				</td>";
		echo "</tr>";
		echo "<tr><td colspan=3 height='5'></td></tr>";
		echo "<tr>";
			echo "<td>הפעל מעקב לקוחות</td>";
			echo "<td width='10'></td>";
				$selected_no = ( $data['c_tracking_on'] == "0" ) ? "selected" : "";
				$selected_yes = ( $data['c_tracking_on'] == "1" ) ? "selected" : "";
				echo "<td>
					<select name='c_tracking_on' id='c_tracking_on' class='input_style' style='width: 160px;'>
						<option value=''>בחירה</option>
						<option value='0' ".$selected_no.">לא</option>
						<option value='1' ".$selected_yes.">כן</option>						
					</select>
				</td>";
		echo "</tr>";
		echo "<tr>";
			echo "<td>הפעל כפתור ווטסאפ</td>";
			echo "<td width='10'></td>";
				$selected_no = ( $data['whatsapp_on'] == "0" ) ? "selected" : "";
				$selected_yes = ( $data['whatsapp_on'] == "1" ) ? "selected" : "";
				echo "<td>
					<select name='whatsapp_on' id='whatsapp_on' class='input_style' style='width: 160px;'>
						<option value=''>בחירה</option>
						<option value='0' ".$selected_no.">לא</option>
						<option value='1' ".$selected_yes.">כן</option>						
					</select>
				</td>";
		echo "</tr>";		
		echo "<tr><td colspan=3 height='5'></td></tr>";		
		echo "<tr>";
			echo "<td>חסימת כתובות אייפי</td>";
			echo "<td width='10'></td>";
			echo "<td><textarea name='block_ips' class='input_style'  style='text-align:left;direction:ltr;height:200px;'>".$data['block_ips']."</textarea></td>";
		echo "</tr>";
		echo "<tr><td colspan=3 height='5'></td></tr>";
		echo "<tr>";
			echo "<td>סינון אימייל לתובעים סדרתיים במערכת שליחת הודעות(מופרד בפסיק)</td>";
			echo "<td width='10'></td>";
			echo "<td><textarea name='email_filter' class='input_style' style='text-align:left;direction:ltr;height:200px;'>".$data['email_filter']."</textarea></td>";
		echo "</tr>";		
		echo "<tr><td colspan=3 height='5'></td></tr>";
		echo "<tr>";
			echo "<td>שם משתמש ביעד שריג</td>";
			echo "<td width='10'></td>";
			echo "<td><input type='text' name='yaad_user' class='input_style' value='".$data['yaad_user']."'  style='text-align:left;direction:ltr;' /></td>";
		echo "</tr>";
		echo "<tr><td colspan=3 height='5'></td></tr>";
		echo "<tr>";
			echo "<td>סיסמה ביעד שריג</td>";
			echo "<td width='10'></td>";
			echo "<td><input type='text' name='yaad_pass' class='input_style' value='".$data['yaad_pass']."'  style='text-align:left;direction:ltr;'/></td>";
		echo "</tr>";
		echo "<tr><td colspan=3 height='5'></td></tr>";
		foreach($kv_settings as $kv_name=>$kv_data){
			echo "<tr><td colspan=3 height='5'></td></tr>";
			echo "<tr>";
				echo "<td>".$kv_data['title']."</td>";
				echo "<td width='10'></td>";
				if($kv_data['val_type'] == 'text'){
					echo "<td><textarea name='kv[".$kv_data['val_type']."][".$kv_data['param_name']."]' class='input_style' style='text-align:left;direction:ltr;height:200px;'>".$kv_data[$kv_data['val_type']."_val"]."</textarea></td>";
				}
				elseif($kv_data['val_type'] == 'tinyint'){
					$kv_val_arr = array('0'=>array('str'=>"לא",'selected'=>"selected"),'1'=>array('str'=>"כן",'selected'=>""));
					if($kv_data['tinyint_val'] == '1'){
						$kv_val_arr['0']['selected'] = "";
						$kv_val_arr['1']['selected'] = "selected";
					}
					echo "<td>
						<select name='kv[".$kv_data['val_type']."][".$kv_data['param_name']."]' id='".$kv_data['param_name']."' class='input_style' style='width: 160px;'>
							<option value='0' ".$kv_val_arr['0']['selected'].">לא</option>
							<option value='1' ".$kv_val_arr['1']['selected'].">כן</option>						
						</select>
					</td>";
				}				
				else{
					echo "<td><input type='text' name='kv[".$kv_data['val_type']."][".$kv_data['param_name']."]' class='input_style' value='".$kv_data[$kv_data['val_type']."_val"]."'  style='text-align:left;direction:ltr;'/></td>";
				}
			echo "</tr>";
		}
		
		echo "<tr><td colspan=3 height='5'></td></tr>";		
		echo "<tr>";
			echo "<td></td>";
			echo "<td width='10'></td>";
			echo "<td><input type='submit' value='שלח' class='input_style'></td>";
		echo "</tr>";
		
	echo "</form>";
	echo "</table>";	
}