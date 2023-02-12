<?php
/*********************************************************************************
 * The contents of this file are subject to the SugarCRM Public License Version 1.1.2
 * ("License"); You may not use this file except in compliance with the
 * License. You may obtain a copy of the License at http://www.sugarcrm.com/SPL
 * Software distributed under the License is distributed on an  "AS IS"  basis,
 * WITHOUT WARRANTY OF ANY KIND, either express or implied. See the License for
 * the specific language governing rights and limitations under the License.
 * The Original Code is:  SugarCRM Open Source
 * The Initial Developer of the Original Code is SugarCRM, Inc.
 * Portions created by SugarCRM are Copyright (C) SugarCRM, Inc.;
 * All Rights Reserved.
 * Contributor(s): ______________________________________.
 ********************************************************************************/
/*********************************************************************************
 * $Header: /advent/projects/wesat/vtiger_crm/sugarcrm/modules/Contacts/language/en_us.lang.php,v 1.14 2005/03/24 17:47:43 rank Exp $
 * Description:  Defines the English language pack
 * Portions created by SugarCRM are Copyright (C) SugarCRM, Inc.
 * All Rights Reserved.
 * Contributor(s): Dotan Mazor (Hebrew)..
 ********************************************************************************/

$mod_strings = Array(
// Mike Crowe Mod --------------------------------------------------------Added for general search
'LBL_GENERAL_INFORMATION'=>'מידע כללי',
'LBL_MODULE_NAME'=>'אנשי קשר',
'LBL_INVITEE'=>'דוחות ישירים',
'LBL_MODULE_TITLE'=>'אנשי קשר: בית',
'LBL_SEARCH_FORM_TITLE'=>'חיפוש אנשי קשר',
'LBL_LIST_FORM_TITLE'=>'רשימת אנשי קשר',
'LBL_NEW_FORM_TITLE'=>'איש קשר חדש',
'LBL_CONTACT_OPP_FORM_TITLE'=>'איש קשר-הזדמנות:',
'LBL_CONTACT'=>'איש קשר:',

'LBL_LIST_NAME'=>'שם',
'LBL_LIST_LAST_NAME'=>'שם משפחה',
'LBL_LIST_FIRST_NAME'=>'שם פרטי',
'LBL_LIST_CONTACT_NAME'=>'שם איש קשר',
'LBL_LIST_TITLE'=>'תפקיד',
'LBL_LIST_ACCOUNT_NAME'=>'שם חשבון',
'LBL_LIST_EMAIL_ADDRESS'=>'דוא&quot;ל',
'LBL_LIST_PHONE'=>'טלפון',
'LBL_LIST_CONTACT_ROLE'=>'תפקיד',

//DON'T CONVERT THESE THEY ARE MAPPINGS
'db_last_name' => 'LBL_LIST_LAST_NAME',
'db_first_name' => 'LBL_LIST_FIRST_NAME',
'db_title' => 'LBL_LIST_TITLE',
'db_email1' => 'LBL_LIST_EMAIL_ADDRESS',
'db_email2' => 'LBL_LIST_EMAIL_ADDRESS',
//END DON'T CONVERT
	
'LBL_EXISTING_CONTACT' => 'נעשה שימוש באיש קשר קיים',
'LBL_CREATED_CONTACT' => 'נוצר איש קשר חדש',
'LBL_EXISTING_ACCOUNT' => 'נעשה שימוש בחשבון קיים',
'LBL_CREATED_ACCOUNT' => 'נוצר חשבון חדש',
'LBL_CREATED_CALL' => 'נוצרה שיחת טלפון חדשה',
'LBL_CREATED_MEETING' => 'נוצרה פגישה חדשה',
'LBL_ADDMORE_BUSINESSCARD' =>'נוצר כרטיס ביקור חדש',
'LBL_ADD_BUSINESSCARD' => 'הוספת כרטיס ביקור',

'LBL_BUSINESSCARD' => 'כרטיס ביקור',

'LBL_NAME'=>'שם:',
'LBL_CONTACT_NAME'=>'שם איש קשר:',
'LBL_CONTACT_INFORMATION'=>'מידע איש קשר',
'LBL_CUSTOM_INFORMATION'=>'מידע מותאם אישית',
'LBL_FIRST_NAME'=>'שם פרטי:',
'LBL_OFFICE_PHONE'=>'טלפון במשרד:',
'LBL_ACCOUNT_NAME'=>'שם חשבון:',
'LBL_ANY_PHONE'=>'כל טלפון:',
'LBL_PHONE'=>'טלפון:',
'LBL_LAST_NAME'=>'שם משפחה:',
'LBL_MOBILE_PHONE'=>'נייד:',
'LBL_HOME_PHONE'=>'בית:',
'LBL_LEAD_SOURCE'=>'מקור הקשר:',
'LBL_OTHER_PHONE'=>'טלפון אחר:',
'LBL_FAX_PHONE'=>'פקס:',
'LBL_TITLE'=>'תפקיד:',
'LBL_DEPARTMENT'=>'מחלקה:',
'LBL_BIRTHDATE'=>'יום הולדת:',
'LBL_EMAIL_ADDRESS'=>'דוא&quot;ל:',
'LBL_OTHER_EMAIL_ADDRESS'=>'דוא&quot;ל אחר:',
'LBL_ANY_EMAIL'=>'כל דוא&quot;ל',
'LBL_REPORTS_TO'=>'מדווח אל:',
'LBL_ASSISTANT'=>'עוזר:',
'LBL_YAHOO_ID'=>'Yahoo! ID:',
'LBL_ASSISTANT_PHONE'=>'טלפון עוזר:',
'LBL_DO_NOT_CALL'=>'לא להתקשר:',
'LBL_EMAIL_OPT_OUT'=>'לא לשלוח דוא&quot;ל:',
'LBL_PRIMARY_ADDRESS'=>'כתובת עיקרית:',
'LBL_ALTERNATE_ADDRESS'=>'כתובת נוספת:',
'LBL_ANY_ADDRESS'=>'כל כתובת:',
'LBL_CITY'=>'עיר:',
'LBL_STATE'=>'State:',
'LBL_POSTAL_CODE'=>'מיקוד:',
'LBL_COUNTRY'=>'Country:',
'LBL_DESCRIPTION_INFORMATION'=>'מידע תיאור',
'LBL_IMAGE_INFORMATION'=>'מידע תמונה של איש קשר:',
'LBL_ADDRESS_INFORMATION'=>'מידע כתובת',
'LBL_DESCRIPTION'=>'תיאור:',
'LBL_CONTACT_ROLE'=>'תפקיד:',
'LBL_OPP_NAME'=>'שם הזדמנות:',
'LBL_DUPLICATE'=>'ייתכן ויש אנשי קשר כפולים',
'MSG_DUPLICATE' => 'Creating this contact may vtiger_potentialy create a duplicate contact. You may either select a contact from the list below or you may click on Create New Contact to continue creating a new contact with the previously entered data.',

'LNK_NEW_APPOINTMENT' => 'פגישה חדשה',
'LBL_ADD_BUSINESSCARD' => 'הוספת כרטיס ביקור',
'NTC_DELETE_CONFIRMATION'=>'האם למחוק רשומה זו?',
'NTC_REMOVE_CONFIRMATION'=>'Are you sure you want to remove this contact from this case?',
'NTC_REMOVE_DIRECT_REPORT_CONFIRMATION'=>'Are you sure you want to remove this record as a direct vtiger_report?',
'ERR_DELETE_RECORD'=>"en_us A record number must be specified to delete the contact.",
'NTC_COPY_PRIMARY_ADDRESS'=>'העתקת כתובת ראשית לכתובת חלופית',
'NTC_COPY_ALTERNATE_ADDRESS'=>'העתקת כתובת חלופית לכתובת ראשית',

'LBL_SELECT_CONTACT'=>'בחירת איש קשר',
//Added for search heading
'LBL_GENERAL_INFORMATION'=>'מידע כללי',



//for v4 release added
'LBL_NEW_POTENTIAL'=>'הזדמנות חדשה',
'LBL_POTENTIAL_TITLE'=>'הזדמנויות',

'LBL_NEW_TASK'=>'משימה חדשה',
'LBL_TASK_TITLE'=>'משימות',
'LBL_NEW_CALL'=>'שיחת טלפון חדשה',
'LBL_CALL_TITLE'=>'שיחות טלפון',
'LBL_NEW_MEETING'=>'פגישה חדשה',
'LBL_MEETING_TITLE'=>'פגישות',
'LBL_NEW_EMAIL'=>'דוא&quot;ל חדש',
'LBL_EMAIL_TITLE'=>'דוא&quot;ל',
'LBL_NEW_NOTE'=>'הערה חדשה',
'LBL_NOTE_TITLE'=>'הערות',

// Added for 4GA
'LBL_TOOL_FORM_TITLE'=>'כלים לאנשי קשר',

'Salutation'=>'תואר',
'First Name'=>'שם פרטי',
'Office Phone'=>'טלפון במשרד',
'Last Name'=>'שם משפחה',
'Mobile'=>'נייד',
'Account Name'=>'שם חשבון',
'Home Phone'=>'טלפון בבית',
'Lead Source'=>'מקור הקשר',
'Phone'=>'טלפון',
'Title'=>'תפקיד',
'Fax'=>'פקס',
'Department'=>'מחלקה',
'Birthdate'=>'יום הולדת',
'Email'=>'דוא&quot;ל',
'Reports To'=>'מדווח ל',
'Assistant'=>'עוזר',
'Yahoo Id'=>'Yahoo Id',
'Assistant Phone'=>'טלפון של עוזר',
'Do Not Call'=>'לא להתקשר',
'Email Opt Out'=>'לא לשלוח דוא&quot;ל',
'Assigned To'=>'מצוות אל',
'Campaign Source'=>'מקור מסע פרסום',
'Reference' =>'הפנייה',
'Created Time'=>'זמן יצירה',
'Modified Time'=>'זמן שינוי',
'Mailing Street'=>'רחוב למשלוח דואר',
'Other Street'=>'רחוב אחר',
'Mailing City'=>'עיר למשלוח דואר',
'Mailing State'=>'Mailing State',
'Mailing Zip'=>'מיקוד למשלוח דואר',
'Mailing Country'=>'Mailing Country',
'Mailing Po Box'=>'תא דואר למשלוח דואר',
'Other Po Box'=>'תא דואר אחר',
'Other City'=>'עיר אחרת',
'Other State'=>'Other State',
'Other Zip'=>'מיקוד אחר',
'Other Country'=>'Other Country',
'Contact Image'=>'תמונת איש קשר',
'Description'=>'תיאור',

// Added vtiger_fields for Add Business Card
'LBL_NEW_CONTACT'=>'איש קשר חדש',
'LBL_NEW_ACCOUNT'=>'חשבון חדש',
'LBL_NOTE_SUBJECT'=>'נושא ההערה:',
'LBL_NOTE'=>'הערה:',
'LBL_WEBSITE'=>'אתר:',
'LBL_NEW_APPOINTMENT'=>'פגישה חדשה',
'LBL_SUBJECT'=>'נושא:',
'LBL_START_DATE'=>'תאריך התחלה:',
'LBL_START_TIME'=>'זמן התחלה:',

//Added vtiger_field after 4_0_1
'Portal User'=>'משתמש פורטל',
'LBL_CUSTOMER_PORTAL_INFORMATION'=>'מידע פורטל לקוח',
'Support Start Date'=>'תאריך תחילת תמיכה',
'Support End Date'=>'תאריך סיום תמיכה',
//Added for 4.2 Release -- CustomView
'Name'=>'שם',
'LBL_ALL'=>'הכל',
'LBL_MAXIMUM_LIMIT_ERROR'=>'הקובץ שנבחר אינו עומד במגבלת הגודל שנבחרה. ניתן לנסות שנית, עם קובץ הקטן מ 800000 בתים',
'LBL_UPLOAD_ERROR'=>'בעיות עם העלאת הקובץ. נא לנסות שוב.',
'LBL_IMAGE_ERROR'=>'הקובץ שנבחר אינו מהסוגים המוכרים (.gif/.jpg/.png)',
'LBL_INVALID_IMAGE'=>'קובץ פגום או ללא מידע',

//Added after 5Alpha5
'Notify Owner'=>'הודעה לבעלים',

//Added for Picklist Values
'--None--'=>'--ללא--',

'Mr.'=>'מר',
'Ms.'=>'עלמה',
'Mrs.'=>'גברת',
'Dr.'=>'דוקטור',
'Prof.'=>'פרופסור',

'Cold Call'=>'שיחת טלפון',
'Existing Customer'=>'לקוח קיים',
'Self Generated'=>'נוצר מעצמו',
'Employee'=>'עובד',
'Partner'=>'שותף',
'Public Relations'=>'יחצנות',
'Direct Mail'=>'דיוור ישיר',
'Conference'=>'ועידה',
'Trade Show'=>'כנס',
'Web Site'=>'אתר',
'Word of mouth'=>'מפה לאוזן',
'Other'=>'אחר',
'User List'=>'רשימת משתמשים',

);

?>
