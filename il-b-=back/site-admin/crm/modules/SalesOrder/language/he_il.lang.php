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
 * $Header$
 * Description:  Defines the English language pack 
 * Portions created by SugarCRM are Copyright (C) SugarCRM, Inc.
 * All Rights Reserved.
 * Contributor(s): Dotan Mazor (Hebrew)..
 ********************************************************************************/
 
$mod_strings = Array(
'LBL_MODULE_NAME'=>'הזמנות למכירות',
'LBL_SO_MODULE_NAME'=>'הזמנה למכירה',
'LBL_RELATED_PRODUCTS'=>'פרטי המוצר',
'LBL_MODULE_TITLE'=>'הזמנות למכירות: בית',
'LBL_SEARCH_FORM_TITLE'=>'Orders Search',
'LBL_LIST_SO_FORM_TITLE'=>'Sales Order List',
'LBL_NEW_FORM_SO_TITLE'=>'New Sales Order',
'LBL_MEMBER_ORG_FORM_TITLE'=>'Member Organizations',

'LBL_LIST_ACCOUNT_NAME'=>'שם החשבון',
'LBL_LIST_CITY'=>'עיר',
'LBL_LIST_WEBSITE'=>'אתר',
'LBL_LIST_STATE'=>'State',
'LBL_LIST_PHONE'=>'טלפון',
'LBL_LIST_EMAIL_ADDRESS'=>'כתובת דוא&quot;ל',
'LBL_LIST_CONTACT_NAME'=>'שם איש הקשר',

//DON'T CONVERT THESE THEY ARE MAPPINGS
'db_name' => 'LBL_LIST_ACCOUNT_NAME',
'db_website' => 'LBL_LIST_WEBSITE',
'db_billing_address_city' => 'LBL_LIST_CITY',

//END DON'T CONVERT

'LBL_ACCOUNT'=>'חשבון:',
'LBL_ACCOUNT_NAME'=>'שם החשבון:',
'LBL_PHONE'=>'טלפון:',
'LBL_WEBSITE'=>'אתר:',
'LBL_FAX'=>'פקס:',
'LBL_TICKER_SYMBOL'=>'סמל מניה:',
'LBL_OTHER_PHONE'=>'טלפון אחר:',
'LBL_ANY_PHONE'=>'כל טלפון:',
'LBL_MEMBER_OF'=>'חבר ב:',
'LBL_EMAIL'=>'דוא&quot;ל:',
'LBL_EMPLOYEES'=>'עובדים:',
'LBL_OTHER_EMAIL_ADDRESS'=>'דוא&quot;ל אחר:',
'LBL_ANY_EMAIL'=>'כל דוא&quot;ל:',
'LBL_OWNERSHIP'=>'בעלות:',
'LBL_RATING'=>'דירוג:',
'LBL_INDUSTRY'=>'תעשיה:',
'LBL_SIC_CODE'=>'SIC Code:',
'LBL_TYPE'=>'סוג:',
'LBL_ANNUAL_REVENUE'=>'מחזור שנתי:',
'LBL_ADDRESS_INFORMATION'=>'מידע הכתובת',
'LBL_Quote_INFORMATION'=>'מידע החשבון',
'LBL_CUSTOM_INFORMATION'=>'מידע מותאם אישית',
'LBL_BILLING_ADDRESS'=>'כתובת לחיוב:',
'LBL_SHIPPING_ADDRESS'=>'כתובת למשלוח:',
'LBL_ANY_ADDRESS'=>'כל כתובת:',
'LBL_CITY'=>'עיר:',
'LBL_STATE'=>'State:',
'LBL_POSTAL_CODE'=>'מיקוד:',
'LBL_COUNTRY'=>'Country:',
'LBL_DESCRIPTION_INFORMATION'=>'מידע מתאר',
'LBL_TERMS_INFORMATION'=>'תנאים',
'LBL_DESCRIPTION'=>'תיאור:',
'NTC_COPY_BILLING_ADDRESS'=>'העתקת כתובת לחיוב לכתובת למשלוח',
'NTC_COPY_SHIPPING_ADDRESS'=>'העתקת כתובת למשלוח לכתובת לחיוב',
'NTC_REMOVE_MEMBER_ORG_CONFIRMATION'=>'Are you sure you want to remove this record as a member organization?',
'LBL_DUPLICATE'=>'אפשרות לחשבונות כפולים',
'MSG_DUPLICATE' => 'Creating this vtiger_account may vtiger_potentialy create a duplicate vtiger_account. You may either select an vtiger_account from the list below or you may click on Create New Account to continue creating a new vtiger_account with the previously entered data.',

'LBL_INVITEE'=>'אנשי קשר',
'ERR_DELETE_RECORD'=>"A record number must be specified to delete the vtiger_account.",

'LBL_SELECT_ACCOUNT'=>'בחירת חשבון',
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
'LBL_NEW_CONTACT'=>'איש קשר חדש',
'LBL_CONTACT_TITLE'=>'אנשי קשר',

//Added vtiger_fields after RC1 - Release
'LBL_ALL'=>'הכל',
'LBL_PROSPECT'=>'בבדיקה',
'LBL_INVESTOR'=>'משקיע',
'LBL_RESELLER'=>'משווק',
'LBL_PARTNER'=>'שותף',

// Added for 4GA
'LBL_TOOL_FORM_TITLE'=>'כלי חשבונות',
//Added for 4GA
'Subject'=>'נושא',
'Quote Name'=>'שם הצעת המחיר',
'Vendor Name'=>'שם הספק',
'Requisition No'=>'מספר הזמנת רכש',
'Tracking Number'=>'מספר מעקב',
'Contact Name'=>'שם איש קשר',
'Due Date'=>'תאריך סיום',
'Carrier'=>'חברת שליחויות',
'Type'=>'סוג',
'Sales Tax'=>'מס מכירות',
'Sales Commission'=>'עמלת מכירות',
'Excise Duty'=>'Excise Duty',
'Total'=>'סך הכל',
'Product Name'=>'שם המוצר',
'Assigned To'=>'מצוות אל',
'Billing Address'=>'כתובת לחיוב',
'Shipping Address'=>'כתובת למשלוח',
'Billing City'=>'עיר לחיוב',
'Billing State'=>'Billing State',
'Billing Code'=>'מיקוד לחיוב',
'Billing Country'=>'Billing Country',
'Billing Po Box'=>'תא דואר לחיוב',
'Shipping Po Box'=>'תא דואר למשלוח',
'Shipping City'=>'עיר למשלוח',
'Shipping State'=>'Shipping State',
'Shipping Code'=>'מיקוד למשלוח',
'Shipping Country'=>'Shipping Country',
'City'=>'עיר',
'State'=>'State',
'Code'=>'קוד',
'Country'=>'מדינה',
'Created Time'=>'זמן יצירה',
'Modified Time'=>'זמן שינוי',
'Description'=>'תיאור',
'Potential Name'=>'שם ההזדמנות',
'Customer No'=>'מספר לקוח',
'Purchase Order'=>'הזמנת רכישה',
'Vendor Terms'=>'תנאי ספק',
'Pending'=>'בהמתנה',
'Account Name'=>'שם חשבון',
'Terms & Conditions'=>'תנאים',
//Quote Info
'LBL_SO_INFORMATION'=>'Sales Order Information',
'LBL_SO'=>'Sales Order:',

 //Added for 5.0 GA
'LBL_SO_FORM_TITLE'=>'מכירות',
'LBL_SUBJECT_TITLE'=>'נושא',
'LBL_VENDOR_NAME_TITLE'=>'שם ספק',
'LBL_TRACKING_NO_TITLE'=>'מספר מעקב:',
'LBL_SO_SEARCH_TITLE'=>'Sales Order Search',
'LBL_QUOTE_NAME_TITLE'=>'שם הצעת מחיר',
'Order Id'=>'מספר הזמנה',
'LBL_MY_TOP_SO'=>'My Top Open Sales Orders',
'Status'=>'מצב',
'SalesOrder'=>'Sales Order',

//Added for existing Picklist Entries

'FedEx'=>'FedEx',
'UPS'=>'UPS',
'USPS'=>'USPS',
'DHL'=>'DHL',
'BlueDart'=>'BlueDart',

'Created'=>'נוצרה',
'Approved'=>'אושרה',
'Delivered'=>'נשלח',
'Cancelled'=>'בוטלה',
);

?>
