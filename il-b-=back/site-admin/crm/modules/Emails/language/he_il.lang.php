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
 * $Header: /advent/projects/wesat/vtiger_crm/sugarcrm/modules/Emails/language/en_us.lang.php,v 1.17 2005/03/28 06:31:38 rank Exp $
 * Description:  Defines the English language pack for the Account module.
 ********************************************************************************/
 
$mod_strings = Array(
// Mike Crowe Mod --------------------------------------------------------added for general search
'LBL_GENERAL_INFORMATION'=>'מידע כללי',

'LBL_MODULE_NAME'=>'דוא&quot;ל',
'LBL_MODULE_TITLE'=>'דוא&quot;ל: בית',
'LBL_SEARCH_FORM_TITLE'=>'חיפוש דוא&quot;ל',
'LBL_LIST_FORM_TITLE'=>'רשימת דוא&quot;ל',
'LBL_NEW_FORM_TITLE'=>'מעקב דוא&quot;ל',

'LBL_LIST_SUBJECT'=>'נושא',
'LBL_LIST_CONTACT'=>'איש קשר',
'LBL_LIST_RELATED_TO'=>'קשור אל',
'LBL_LIST_DATE'=>'תאריך משלוח',
'LBL_LIST_TIME'=>'שעת משלוח',

'ERR_DELETE_RECORD'=>"A record number must be specified to delete the vtiger_account.",
'LBL_DATE_SENT'=>'תאריך משלוח:',
'LBL_SUBJECT'=>'נושא: ',
'LBL_BODY'=>'גוף ההודעה:',
'LBL_DATE_AND_TIME'=>'תאריך ושעת משלוח:',
'LBL_DATE'=>'תאריך משלוח:',
'LBL_TIME'=>'שעת משלוח:',
'LBL_SUBJECT'=>'נושא:',
'LBL_BODY'=>'גוף ההודעה:',
'LBL_CONTACT_NAME'=>' שם איש הקשר: ',
'LBL_EMAIL'=>'דוא&quot;ל',  
'LBL_COLON'=>':',
'LBL_CHK_MAIL'=>'בדיקת דוא&quot;ל',
'LBL_COMPOSE'=>'חיבור',
'LBL_SETTINGS'=>'הגדרות',
'LBL_EMAIL_FOLDERS'=>'מחיצות דוא&quot;ל',
'LBL_INBOX'=>'דואר נכנס',
'LBL_SENT_MAILS'=>'דואר שנשלח',
'LBL_TRASH'=>'אשפה',
'LBL_JUNK_MAILS'=>'דואר זבל',
'LBL_TO_LEADS'=>'To Leads',
'LBL_TO_CONTACTS'=>'אל אנשי קשר',
'LBL_TO_ACCOUNTS'=>'אל חשבונות',
'LBL_MY_MAILS'=>'המכתבים שלי',
'LBL_QUAL_CONTACT'=>'Qualified Mails (As Contacts)',
'LBL_MAILS'=>'מכתבים',
'LBL_QUALIFY_BUTTON'=>'Qualify',
'LBL_REPLY_BUTTON'=>'משלוח תשובה',
'LBL_FORWARD_BUTTON'=>'העברה הלאה',
'LBL_DOWNLOAD_ATTCH_BUTTON'=>'הורדת מסמכים מצורפים',
'LBL_FROM'=>'מאת :',
'LBL_CC'=>'מכותבים נוספים :',
'LBL_BCC'=>'מכותבים נסתרים :',

'NTC_REMOVE_INVITEE'=>'האם להסיר נמען זה מהמכתב?',
'LBL_INVITEE'=>'נמענים',

// Added Fields
// Contacts-SubPanelViewContactsAndUsers.php
'LBL_BULK_MAILS'=>'Bulk Mails',
'LBL_ATTACHMENT'=>'מסמך מצורף',
'LBL_DESCRIPTION'=>'תיאור',
'LBL_UPLOAD'=>'העלאה',
'LBL_FILE_NAME'=>'שם קובץ',
'LBL_SEND'=>'שליחה',

'LBL_EMAIL_TEMPLATES'=>'תבניות דוא&quot;ל',
'LBL_TEMPLATE_NAME'=>'שם תבנית',
'LBL_DESCRIPTION'=>'תיאור',
'LBL_EMAIL_TEMPLATES_LIST'=>'רשימת תבניות דוא&quot;ל',
'LBL_EMAIL_INFORMATION'=>'מידע דוא&quot;ל',




//for v4 release added
'LBL_NEW_LEAD'=>'New Lead',
'LBL_LEAD_TITLE'=>'Leads',

'LBL_NEW_PRODUCT'=>'מוצר חדש',
'LBL_PRODUCT_TITLE'=>'מוצרים',
'LBL_NEW_CONTACT'=>'איש קשר חדש',
'LBL_CONTACT_TITLE'=>'אנשי קשר',
'LBL_NEW_ACCOUNT'=>'חשבון חדש',
'LBL_ACCOUNT_TITLE'=>'חשבונות',

// Added vtiger_fields after vtiger4 - Beta
'LBL_USER_TITLE'=>'Users',
'LBL_NEW_USER'=>'משתמש חדש',

// Added for 4 GA
'LBL_TOOL_FORM_TITLE'=>'כלי דוא&quot;ל',
//Added for 4GA
'Date & Time Sent'=>'תאריך ושעת המשלוח',
'Sales Enity Module'=>'Sales Enity Module',
'Activtiy Type'=>'סוג פעילות',
'Related To'=>'קשור אל',
'Assigned To'=>'מצוות אל',
'Subject'=>'נושא',
'Attachment'=>'מסמך מצורף',
'Description'=>'תיאור',
'Time Start'=>'שעת התחלה',
'Created Time'=>'שעת יצירה',
'Modified Time'=>'שעת שינוי',

'MESSAGE_CHECK_MAIL_SERVER_NAME'=>'נא לבדוק את שם שרת הדואר...',
'MESSAGE_CHECK_MAIL_ID'=>'Please Check the Email Id of "Assigned To" User...',
'MESSAGE_MAIL_HAS_SENT_TO_USERS'=>'מכתב נשלח למשתמשים הבאים :',
'MESSAGE_MAIL_HAS_SENT_TO_CONTACTS'=>'מכתב נשלח לאנשי הקשר הבאים :',
'MESSAGE_MAIL_ID_IS_INCORRECT'=>'Mail Id is incorrect. Please Check this Mail Id...',
'MESSAGE_ADD_USER_OR_CONTACT'=>'נא להוסיף כל משתמש או איש קשר',
'MESSAGE_MAIL_SENT_SUCCESSFULLY'=>' מכתב/ים נשלח/ו בהצלחה',

// Added for web mail post 4.0.1 release
'LBL_FETCH_WEBMAIL'=>'הורדת דוא&quot;ל מהרשת',
//Added for 4.2 Release -- CustomView
'LBL_ALL'=>'הכל',
'MESSAGE_CONTACT_NOT_WANT_MAIL'=>'איש קשר זה אינו מעוניין לקבל דוא&quot;ל.',
'LBL_WEBMAILS_TITLE'=>'דואר רשת',
'LBL_EMAILS_TITLE'=>'דוא&quot;ל',
'LBL_MAIL_CONNECT_ERROR_INFO'=>'Error connecting mail server!<br> Check in My Accounts->List Mail Server -> List Mail Account',
'LBL_ALLMAILS'=>'כל הדוא&quot;ל',
'LBL_TO_USERS'=>'אל משתמשים',
'LBL_TO'=>'אל:',
'LBL_IN_SUBJECT'=>'בנושא',
'LBL_IN_SENDER'=>'בשם השולח',
'LBL_IN_SUBJECT_OR_SENDER'=>'בנושא או בשם השולח',
'SELECT_EMAIL'=>'Select Email IDs',
'Sender'=>'שם השולח',
'LBL_CONFIGURE_MAIL_SETTINGS'=>'שרת הדואר הנכנס שלך אינו מוגדר.',
'LBL_MAILSELECT_INFO'=>'has the follwoing Email IDs associated.Please Select the Email IDs to which,the mail should be sent',
'LBL_MAILSELECT_INFO1'=>'The following Email ID types are associated to the selected',
'LBL_MAILSELECT_INFO2'=>'Select the Email ID types to which,the email should be sent',
'LBL_MULTIPLE'=>'Multiple',
'LBL_COMPOSE_EMAIL'=>'חיבור מכתב',
);

?>
