<?php
require('/home/ilan123/domains/ilbiz.co.il/public_html/global_func/vars.php');
$cities_sql = "SELECT * FROM newCities ORDER BY father, name";
$cities_res = mysql_db_query(DB,$cities_sql);
$cities_arr = array();
$cities_arr_by_id = array();
while($city = mysql_fetch_array($cities_res)){
	$cities_arr_by_id[$city['id']] = $city;
	$cities_arr[] = $city;
}
?>
<script type="text/javascript">
	function open_div_box(a_el,box_id){
		jQuery(function($){
			if($(a_el).attr("rel") == "closed"){
				$(a_el).attr("rel","open");
				$(".guid-content").hide();
				$("#"+box_id).show();
			}
			else{
				$(a_el).attr("rel","closed");
				$("#"+box_id).hide();
			}
			
		});
	}
</script>
<style type="text/css">
	.guid-content{
		padding:10px;
		background:white;
		border: 1px solid gray;
	}
</style>
<div style="margin-bottom:30px;padding:10px; background:wheat; border:1px solid gray;">
	<h1>מדריכים כלליים לתוספות באתרים</h1>
	<a href="?main=global_settings&sesid=<?php echo SESID; ?>" >חזור לניהול כללי</a>
	<br/>
	<a href="?sesid=<?php echo SESID; ?>" >חזור לתפריט ראשי</a>
	<div id="city_list_wrap">
		<a href="javascript://" onclick="open_div_box(this,'city_list_content')" rel="closed">רשימת הערים במערכת</a>
		<div id="city_list_content" class="guid-content"  style="display:none;">
			<h3>רשימת הערים במערכת בפיתוח</h3>
			<table border="1" cellpadding="3" style="border-collapse: collapse;">
				<tr>
					<th>עיר</th>
					<th>מספר</th>
					<th>אזור</th>
				</tr>
				<?php foreach($cities_arr as $city): ?>
					<tr>
						<td><?php echo $city['name']; ?></td>
						<td><?php echo $city['id']; ?></td>
						<td><?php echo (isset($cities_arr_by_id[$city['father']]))?$cities_arr_by_id[$city['father']]['name']:""; ?></td>
					</tr>
				<?php endforeach; ?>
				
			</table>
		</div>
	</div>
	<div id="landing_pages_wrap">
		<a href="javascript://" onclick="open_div_box(this,'landing_pages_content')" rel="closed">דפי נחיתה</a>
		<div id="landing_pages_content" class="guid-content"  style="display:none;">
			<h2>עמודי נחיתה</h2>
			<h4>אם מגדירים בעדכון שיש עמודי נחיתה, ומוסיפים עמוד נחיתה</h4>
			מה שיקרה זה שעמוד הבית יהיה עמוד נחיתה
			<h4>כדי להמנע מזה יש להכנס להגדרות עיצוב ייחודי</h4>
			ולבחור גירסת מיניפורטל 1</br>
			במקום 0 שזה דך נחיתה בעמוד הבית
			<h4>במערכת ניהול לקוח יש הגדרות לגירסת פורטל.</h4>
			אם לא מגדירים שם כלום, עמוד הבית יהיה עמוד רגיל- עמוד ברירת המחדל
		</div>
	</div>
	
	<div id="design_wrap">
		<a href="javascript://" onclick="open_div_box(this,'design_content')" rel="closed">עיצוב</a>
		<div id="design_content" class="guid-content"  style="display:none;">	
	
	
		<h2>עיצוב</h2>
		
		<h3>הגדרות לגירסאות עיצוביות לאתר לקוח</h3>
		<ul>
			<li>עדכון - גרסת אתר : 1</li>
			<li>עיצוב ייחודי - גירסת מודול חדשות: 1</li>
			<li>עיצוב ייחודי - גירסת מודול מוצרים: 1  --- כולל גם גרסת עמודי נחיתה</li>
			<li>עיצוב ייחודי - גירסת תפריט נגישות: 1</li>
		</ul>
		<h2>הוספת SSL לדומיין:</h2>
		<ul>
			<li>
				גלוש למערכת ניהול של השרת: 
				<br/>
				http://beersheva.biz:2222
				<br/>
				user: ilbiz
				<br/>
				pass: agate1234
			</li>
			<li>list users</li>
			<li>בחר משתמש ilan_123</li>
			<li>בחר את הדומיין הרצוי</li>
			<li>בחר SSL Certificates מתחת לכותרת Advanced features</li>
			<li>בחר באפשרות השנייה: Use the server's shared signed certificate.</li>
			<li>בחר באפשרות השלישית: Free & automatic certificate from Let's Encrypt</li>
			<li>גלול למטה ולחץ save</li>
			<li>לחץ על תמונת הבית בתפריט הראשי ובחר שוב את הדומיין הרצוי</li>
			<li>לחץ על: Domain Setup</li>
			<li>בחר שוב את הדומיין הרצוי (לחץ על שם הדומיין)</li>
			<li>סמן את תיבת הסימון Secure SSL, ולחץ save</li>
			<li>עכשיו אתה אמור להגיע שוב לאותו עמוד כאשר האפשרויות למטה פתוחות לעריכה</li>
			<li>private_html setup for .... - (SSL must be enabled above)</li>
			<li>באפשרויות האלה, בחר את השנייה: <br/> Use a symbolic link from private_html to public_html - allows for same data in http and https</li>
			<li>לחץ save</li>
			<li>המתן 5 דקות וגלוש אל הדומיין שלך עם https:// ובדוק שהכל תקין</li>
			<li>סיימת. יש תעודת SSL לדומיין. </li>
			<li>בהצלחה</li>
		</ul>
	
	
	
		</div>
	</div>
	
	<div id="contracts_wrap">
		<a href="javascript://" onclick="open_div_box(this,'contracts_content')" rel="closed">הסכמי עבודה</a>
		<div id="contracts_content" class="guid-content"  style="display:none;">		
	
	
	
	
	
		<h2>הסכמי עבודה: יצירת אפשרות לאיתור חוזה</h2>
		<p style="color:red;">* שים לב: יצירה של הסכם עבודה חדש וטופס להסכם זה מתבצעת כרגע על ידי צוות הפיתוח</p>
		<ul>
			<li>וודא שגלישה בSSL תקינה בדומיין הרצוי (עיין במדריך יצירת SSL)</li>
			<li>
				גלוש אל כתובת העמוד של איתור חוזים באתר: <br/>
				https://mydomain.co.il?m=work_contract_find
				<p style="color:red;">* יש להחליף את המילים mydomain.co.il בשם הדומיין הרצוי</p>
			</li>
			<li>הגעת אל עמוד איתור חוזים</li>
			<li>העתק את הכתובת הזאת ושים אותה כלינק בכל מקום שתרצה לאפשר גישה ללקוחות לאיתור חוזים</li>
		</ul>
		
		<h2>יצירת הסכם עבודה חדש (מבוצע על ידי צוות פיתוח)</h2>
			<h3>צור את ההסכם עצמו</h3>
			<ul>
				<li>בדוק אילו שדות חופשיים יש להכניס לחוזה</li>
				<li>העתק את הסקיצה של החוזה ששלחו לך והדבק בקובץ טקסט</li>
				<li>שים לב להעלים תגיות font למיניהן וכל דבר שאינו תואם לפורמט של קובצי PDF. אחרת יהיה גיבריש בחוזה</li>
				<li>שנה את כל השדות הרצויים, אלו עם קו תחתון לשמות הפרמטרים עטופים בסוגריים מסולסלים כפולים</li>
				<li>דאג שיישאר הקו התחתון מתחת לפרמטרים הנל (הסתכל בדוגמה שבסיטיפורטל)</li>
				<li>אם יש נספחים לחוזה, שצריכים להמצא מתחת לאזור החתימה האחרונה, כמו למשל העלאת תמונת ת"ז: הוסף אותם בסוף קובץ הטקסט, והפרד מהחלק העליון בעזרת תגית ההערה: <br/>
				<input type="text" style="text-align:left;direction:ltr;" name="stam" value="<!--add_after--> " />
				</li>
				<li>הוסף עמוד במערכת ניהול עמודים באתר הרצוי</li>
				<li>שים כותרת לעמוד</li>
				<li>העתק את תוכן קובץ הטקסט, ובאזור הטקסט של עריכת העמוד, לחץ על מקור והדבק</li>
				<li>שמור</li>
				<li>לפי הדוגמה בסיטי פורטל, הוסף תקציר ומילות מפתח</li>
				<li>בתקציר, במידת הצורך, ערוך את התמונות המשוייכות ואת הגדלים הרצויים. בדרך כלל אין צורך לערוך</li>
				<li>במילות המפתח, ערוך לפי מספר החתימות הרצויות בהסכם, ושדות השמות המשוייכים לכל חתימה</li>
				<li>שמור</li>
				<li>לחץ על לינק ההדמיה לחוזה עבודה בעמוד ובדוק שהכל תקין עד כאן</li>
				<li>העתק מכתובת הURL את מספר העמוד ושמור אותו בצד</li>

			</ul>


			<h3>צור את הטופס לחוזה</h3>
			<ul>
				<li>העתק את עמוד הטוגמה בסיטיפורטל - 	טופס להסכם עבודה</li>
				<li>הדבק לקובץ טקסט</li>
				<li>ערוך את האזור של דוגמת החוזה, שיתאים לחוזה החדש. ניתן להעתיק ולהדביק את החוזה מקובף הטקסט של החוזה עצמו</li>
				<li>הוסף את ההערה באדום - שיש למלא את השדות למטה</li>
				<li>
					ערוך את השדות המוחבאים, כך שייעבדו עם הסכם העבודה שיצרת:
					<ol>
						<li>title: כותרת החוזה שתהיה בניהול ולפעמים בשמות הקבצים הנשלחים ללקוחות</li>
						<li>contract_page: מספר העמוד של ההסכם עצמו(מה שהעתקת ושמרת בצד)</li>
					</ol>
				</li>
				<li>התאם את מספר השדות לחתימה לפי הצורך, שים לב לשמות השדות</li>
				<li>התאם את השדות של העלאת קבצים לפי הצורך, שים לב לשמות השדות</li>
				<li>התאם את שדות הטקסט לפי הצורך, שים לב לשמות השדות</li>
				<li>שמור</li>
				<li>גלוש אל העמוד שיצרת בגלישה מאובטחת(HTTPS)</li>
				<li>העתק את הכתובת URL ושמור בצד</li>
				<li>מלא את הטופס ובדוק שהכל תקין</li>
				<li>הדבק את הלינק שיצרת בצד בכל מקום שתרצה לאפשר מילוי טופס לחוזה</li>
			</ul>
			<h4>בהצלחה</h4>
		



		</div>
	</div>
	
	<div id="api_connect_wrap">
		<a href="javascript://" onclick="open_div_box(this,'api_connect_content')" rel="closed">התחברות לAPI</a>
		<div id="api_connect_content" class="guid-content"  style="display:none;">	




				
				<h3>התחברות לAPI</h3>
				לקוח שמעוניין שנעדכן את המערכת שלו דרך API צריך לקבל את המייל הבא:
				
				שלום אריאל.
		<br/>
				על מנת שנוכל להתממשק לAPI של המערכת ליד מנג'ר, אנא שוחח עם התמיכה של ליד מנג'ר ובקש מהם לסייע לך להמציא לינק לAPI שאליו נתממשק.
		<br/>
				הנ"ל אומר ליצור קמפיין עם שם החברה שלנו, שם ליצור ערוץ חדש לAPI, ולהוציא את הכתובת שסופקה לך.
		<br/>
		על מנת שנוכל לשלוח לך את כל השדות בצורה תקינה, על הAPI לקבל את השדות הבאים:
		<br/>
		מספר טלפון
		<br/>
		-אימייל
		<br/>
		-שם מלא
		<br/>
		*זמן שיחה 
		<br/>
		*סטטוס שיחה
		<br/>
		*הערות
		<br/>
		השדות המסומנים בקו(  -  ) רלוונטים רק ללידים שנוצרו מטופס.
		<br/>
		השדות המסומנים בכוכבית (   *   ) רלוונטים רק ללידים שהגיעו משיחות טלפון.
		<br/>
		בהצלחה ותודה 

		
		
		
		</div>
	</div>
	
	<div id="api_app_wrap">
		<a href="javascript://" onclick="open_div_box(this,'api_app_content')" rel="closed">יישום API</a>
		<div id="api_app_content" class="guid-content"  style="display:none;">			
		
		
				
		<h3>יישום API</h3>
			בהגדרות הפורטל של לקוח ניתן לבחור API לקטגוריות ספציפיות, לכל הקטגוריות, או לטלפונים
			שם זה כבר דיי ברור. שמים את הלינק ששלחו לנו כאשר מחליפים את השדות עם השדות שלנו,
			אלו יוחלפו עי המערכת בערכים הרצויים.
			השדות שאנו יכולים לספק:
			phone,name,email,note,answer,time
			<br/>
			שדות נוספים אפשריים במערכת אך מצריכים בדיקה...
				
		
					<h3>יצירת לינק לאפיליאט בשביל טופס לידים שיירשם ושהליד יופיע אצלו במערכת</h3>
					נכנסים לעמוד שרוצים שהאפיליאט יפנה אליו את הגולשים, מעתיקים את הכתובת, ומוסיפים לה פרמטר: 
					<br/>
					שם הפרמטר:
					aff_id
					<br/>
					ערך הפרמטר:
					מספר האפיליאט. ניתן להכנס במערכת ניהול שותפים ולמצוא את מספר השותף שם
					<br/>
					כדי לדעת איך להוסיף את הפרמטר קרא את המדריך הבא.

					<h3>יצירת לינק עם פרמטרים</h3>
					כדי ליצור לינק עם פרמטר צריך דבר ראשון כתובת של עמוד<br/>
					URL<br/><br/>
			
					לכתובת הזו מוסיפים את הפרמטר.
					<br/>
					לכל פרמטר יש שני חלקים:
					<br/> 
					שם הפרמטר
					<br/>
					ערך הפרמטר
					<br/>
					לדוגמה הפרמטר 
					aff_id
					שמתייחס למספר האפיליאט.
					<br/>
					aff_id 
					הוא שם הפרמטר 
					נניח שמספר האפיליאט הוא 7
		,
					אנחנו בעצם רוצים להגדיר בעמוד שמספר האפיליאט שווה 7
					<br/>	<br/>
					נבנה את הפרמטר בצורה הבאה:
					<br/>
					aff_id=7
					<br/>
					את זה נדביק בסוף הכתובת של העמוד, רק שלפני זה נוסיף את אחד הסימנים הבאים:
					<br/>
					&
					<br/>
					או	
					<br/>
					?
					<br/>	<br/>
					איך נדע איזה מהסימנים לשים?
					<br/>
				
					נבדוק בכתובת אם כבר יש סימן שאלה.
					אם כבר יש סימן שאלה אז נשים את הסימן השני.
					אם אין עדיין סימן שאלה אז נשים סימן שאלה.
					<br/>	<br/>
					החוק הוא שסימן שאלה צריך להיות רק פעם אחת בלבד, ואחריו צריכים להיות רק הסימן השני.
					בהצלחה
					
					הנה כתובות לדוגמה:
					<div style='direction:ltr;text-align:left;'>
						<br/>
						https://כמהעולה.co.il/מחירון-טיפולי-שיניים/?aff_id=7
						<br/>
						https://כמהעולה.co.il/מחירון-טיפולי-שיניים/?more_param=200&aff_id=7
						<br/>
						https://xn--8dbacwhj3a.co.il/מחירון-טיפולי-שיניים/?aff_id=7
						<br/>
						https://xn--8dbacwhj3a.co.il/%D7%9E%D7%97%D7%99%D7%A8%D7%95%D7%9F-%D7%98%D7%99%D7%A4%D7%95%D7%9C%D7%99-%D7%A9%D7%99%D7%A0%D7%99%D7%99%D7%9D/?aff_id=7
						<br/>
				
						<br/>
						https://כמהעולה.co.il/landing.php?ld=538&aff_id=7
						<br/>
						https://כמהעולה.co.il/landing.php?ld=538&more_param=200&aff_id=7
						<br/>
					</div>
					בהצלחה
				


		
		</div>
	</div>
		
		
		
		
		
			
	<div id="fb_leads_wrap">
		<a href="javascript://" onclick="open_div_box(this,'fb_leads_content')" rel="closed">קישור לידים מפייסבוק</a>
		<div id="fb_leads_content" class="guid-content"  style="display:none;">			
		
			<div>
				<div align="center" dir="rtl" style="LINE-HEIGHT: 150%">
					&nbsp;</div>
					<div align="center" dir="rtl" style="LINE-HEIGHT: 150%">
						<span style="font-size:24px;"><strong>קישור לידים מפייסבוק אל המערכת דרך זאפייר</strong></span></div>
							<div align="center" dir="rtl" style="LINE-HEIGHT: 150%">
								&nbsp;</div>
								<div align="center" dir="rtl" style="LINE-HEIGHT: 150%">
									הפעולה מתבצעת דרך אתר זאפייר, ונקראת זאפ.
								</div>
									<div align="center" dir="rtl" style="LINE-HEIGHT: 150%">
										התאור יהיה לקישור חדש, בשביל עריכת קישור קיים, אפשר ללחוץ על zaps, ולבחור את הזאפ הרצוי</div>
									<div dir="rtl" style="LINE-HEIGHT: 150%">
										1: נכנסים לזאפייר - https://zapier.com</div>
									<div dir="rtl" style="LINE-HEIGHT: 150%">
										2: לוחצים על make a zap</div>
									<div dir="rtl" style="LINE-HEIGHT: 150%">
										3: choose a trigger app - בוחרים facebook lead eds, זה עם הלוגו של פייסבוק</div>
									<div dir="rtl" style="LINE-HEIGHT: 150%">
										4:&nbsp;Select Facebook Lead Ads Trigger, בוחרים את האופציה היחידה - new lead ולוחצים על המשך</div>
									<div dir="rtl" style="LINE-HEIGHT: 150%">
										5:&nbsp;Select Facebook Lead Ads Account&nbsp; - מתחברים לחשבון פייסבוק, כאן יש לוודא שאתם מחוברים בפייסבוק לחשבון של אילן שוורץ, לוחצים על כפתור המשך</div>
									<div dir="rtl" style="LINE-HEIGHT: 150%">
										6:&nbsp;Set up Facebook Lead Ads Lead&nbsp; - בוחרים את עמוד הפייסבוק הרצוי, ואז את הקמפיין הרצוי ולוחצים המשך</div>
									<div dir="rtl" style="LINE-HEIGHT: 150%">
										7:&nbsp;Pick A Sample To Set Up Your Zap - אם התחברתם נכון, כאן אמורים לראות אפשרויות של לידים שנשלחו. בוחרים אחת מהאפשרויות, זה יהיה הדוגמית בשביל שימוש בהמשך..</div>
									<div dir="rtl" style="LINE-HEIGHT: 150%">
										לוחצים המשך, עכשיו סיימנו את החלק של הטריגר(מה שמפעיל את הקריאה למערכת שלנו.. העובדה שמישהו היה בפייסבוק ולחץ על הכפתור, ואז פייסבוק שלחו את הפרטים</div>
									<div dir="rtl" style="LINE-HEIGHT: 150%">
										עכשיו אנחנו רוצים שזאפייר ייקח את הפרטים האלו ויישלח אותם אלינו למערכת. זה נקרא action.</div>
									<div dir="rtl" style="LINE-HEIGHT: 150%">
										עכשיו אנחנו בחלק של האקשן.</div>
									<div dir="rtl" style="LINE-HEIGHT: 150%">
										&nbsp;</div>
									<div dir="rtl" style="LINE-HEIGHT: 150%">
										8:&nbsp;Choose an Action App&nbsp;</div>
									<div dir="rtl" style="LINE-HEIGHT: 150%">
										בוחרים אפליקציה שנקראת webhooks, לוגו אדום. לוחצים המשך</div>
									<div dir="rtl" style="LINE-HEIGHT: 150%">
										9:&nbsp;Select Webhooks by Zapier Action - בוחרים POST לוחצים המשך</div>
									<div dir="rtl" style="LINE-HEIGHT: 150%">
										10:&nbsp;Set up Webhooks by Zapier POST -&nbsp;</div>
									<div dir="rtl" style="LINE-HEIGHT: 150%">
										&nbsp;</div>
									<div align="center" dir="rtl" style="LINE-HEIGHT: 150%">
										<strong><span style="font-size:16px;">כאן בוחרים את הערכים ושמות הערכים שיישלחו אלינו למערכת&nbsp;</span></strong></div>
									<div align="center" dir="rtl" style="LINE-HEIGHT: 150%">
										&nbsp;</div>
									<div align="center" dir="rtl" style="LINE-HEIGHT: 150%">
										&nbsp;</div>
									<div dir="rtl">
										<div>
											בזאפייר יש להוסיף את הפרמטרים הבאים:</div>
										<div>
											פרמטרים של זאפייר:</div>
										<div>
											שם הפרמטר מצד שמאל, וערך הפרמטר (צריך לבחור מרשימה) מצד ימין</div>
										<div>
											phone: Phone Number</div>
										<div>
											name: Full Name</div>
										<div>
											add_id: Ad Id</div>
										<div>
											form_id: Form Id</div>
										<div>
											adset_id: Adset Name</div>
										<div>
											campaign_id: Campaign ID</div>
										<div>
											fb_id: ID&nbsp;</div>
										<div>
											adset_name: Adset Name</div>
										<div>
											ad_name: Ad Name</div>
										<div>
											campaign_name: Campaign Name</div>
										<div>
											ex_city: City</div>
										<div>
											&nbsp;</div>
										<div>
											פרמטרים של עיר וקטגוריה:</div>
										<div>
											il_cat: מספר הקטגוריה אצלנו במערכת</div>
										<div>
											il_city: מספר העיר אצלנו במערכת</div>
									</div>
									<p>
										ניתן להוסיף כל פרמטר נוסף מתוך השדות בטופס, שיופיע בהערות, שם הפרמטר צריך להיות באותיות אנגלית ולהתחיל ב:</p>
									<p style="direction: ltr; ">
										ex_&nbsp;&nbsp;</p>
									<p>
										לדוגמה:&nbsp;</p>
									<p style="direction: ltr; ">
										ex_fatherName</p>
									<p style="direction: ltr; ">
										&nbsp;</p>
									<p>
										לוחצים המשך.</p>
									<p>
										&nbsp;</p>
									<p>
										11: צריך לדאוג שהליד מופעל, כי זה לא קורה אוטומטית כמו במערכות אחרות, וזהו. הכל מוכן. בהצלחה</p>
									</div>
											
		
		</div>
	</div>		
		
		
	