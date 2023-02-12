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
 * $Header: /advent/projects/wesat/vtiger_crm/sugarcrm/modules/Dashboard/language/en_us.lang.php,v 1.4 2005/01/25 06:01:38 jack Exp $
 * Description:  Defines the English language pack for the Account module.
 * Portions created by SugarCRM are Copyright (C) SugarCRM, Inc.
 * All Rights Reserved.
 * Contributor(s): Dotan Mazor (Hebrew)..
 ********************************************************************************/
 
$mod_strings = Array(
'LBL_SALES_STAGE_FORM_TITLE'=>'תזרים לפי שלב המכירה',
'LBL_SALES_STAGE_FORM_DESC'=>'Shows cumulative opportunity amounts by selected sales stages for selected users where the expected closed date is within the specificed date range.',
'LBL_MONTH_BY_OUTCOME'=>'תזרים לפי חודש לפי התוצאה',
'LBL_MONTH_BY_OUTCOME_DESC'=>'Shows cumulative opportunity amounts by month by outcome for selected users where the expected closed date is within the specificed date range.  Outcome is based on whether the sales stage is Closed Won, Closed Lost or any other value.',
'LBL_LEAD_SOURCE_FORM_TITLE'=>'כל ההזדמנויות לפי סוג הקשר המוביל',
'LBL_LEAD_SOURCE_FORM_DESC'=>'Shows cumulative opportunity amounts by selected lead source for selected users.',
'LBL_LEAD_SOURCE_BY_OUTCOME'=>'כל ההזדמנויות לפי סוג הקשר המוביל לפי התוצאות',
'LBL_LEAD_SOURCE_BY_OUTCOME_DESC'=>'Shows cumulative opportunity amounts by selected lead source by outcome for selected users where the expected closed date is within the specificed date range.  Outcome is based on whether the sales stage is Closed Won, Closed Lost or any other value.',
'LBL_PIPELINE_FORM_TITLE_DESC'=>'Shows cumulative amounts by selected sales stages for your opportunities where the expected closed date is within the specificed date range.',
'LBL_DATE_RANGE'=>'טווח התאריכים הוא',
'LBL_DATE_RANGE_TO'=>'עד',
'ERR_NO_OPPS'=>'יש ליצור הזדמנויות כדי לראות את גרף ההזדמנויות.',
'LBL_TOTAL_PIPELINE'=>'סך כל התזרים הוא ',
'LBL_ALL_OPPORTUNITIES'=>'סך כל ההזדמנויות הוא ',
'LBL_OPP_SIZE'=>'גודל הזדמנות ב ',
'LBL_OPP_SIZE_VALUE'=>'1K',
'NTC_NO_LEGENDS'=>'כלום',
'LBL_LEAD_SOURCE_OTHER'=>'אחר',
'LBL_EDIT'=>'עריכה',
'LBL_REFRESH'=>'ריענון',
'LBL_CREATED_ON'=>'הרצה אחרונה ב ',
'LBL_OPPS_IN_STAGE'=>'הזדמנויות כששלב המכירה הוא',
'LBL_OPPS_IN_LEAD_SOURCE'=>'הזדמנויות כשהמקור המוביל הוא',
'LBL_OPPS_OUTCOME'=>'הזדמנויות כשהתוצאה היא',
'LBL_USERS'=>'משתמשים:',
'LBL_SALES_STAGES'=>'שלבי מכירות',
'LBL_LEAD_SOURCES'=>'מקורות של קשרים מובילים:',
'LBL_DATE_START'=>'תאריך התחלה:',
'LBL_DATE_END'=>'תאריך סיום:',
//Added for 5.0 
'LBL_NO_PERMISSION'=>'Sorry, you don\'t have access to view the Graph for this module',
'LBL_NO_PERMISSION_FIELD'=>'Sorry, you don\'t have access to view the Graph for this module or for the Field',

"leadsource" => "קשרים מובילים לפי מקור",
"leadstatus" => "קשרים מובילים לפי מצב",
"leadindustry" => "קשרים מובילים לפי תעשייה",
"salesbyleadsource" => "Sales by LeadSource",
"salesbyaccount" => "מכירות לפי חשבונות",
"salesbyuser" => "מכירות לפי משתמשים",
"salesbyteam"=>"מכירות לפי קבוצות",
"accountindustry" => "חשבון לפי תעשייה",
"productcategory" => "מוצרים לפי קטגוריה",
"productbyqtyinstock" => "מוצרים לפי כמות במלאי",
"productbypo" => "Products by PurchaseOrder",
"productbyquotes" => "מוצרים לפי הצעות מחיר",
"productbyinvoice" => "מוצרים לפי חשבונית",
"sobyaccounts" => "הזמנות למכירות לפי חשבונות",
"sobystatus" => "הזמנות למכירות לפי מצב",
"pobystatus" => "הזמנות לרכישות לפי מצב",
"quotesbyaccounts" => "הצעות מחיר לפי חשבונות",
"quotesbystage" => "הצעות מחיר לפי שלב",
"invoicebyacnts" => "חשבוניות לפי חשבונות",
"invoicebystatus" => "חשבוניות לפי מצב",
"ticketsbystatus" => "כרטיסי תקלה לפי מצב",
"ticketsbypriority" => "כרטיסי תקלה לפי עדיפות",
"ticketsbycategory" => "כרטיסי תקלה לפי קטגוריה",
"ticketsbyuser"=>"כרטיסי תקלה לפי משתמש",
"ticketsbyteam"=>"כרטיסי תקלה לפי קבוצה",
"ticketsbyproduct"=>"כרטיסי תקלה לפי מוצר",
"contactbycampaign"=>"אנשי קשר לפי מסע פרסום",
"ticketsbyaccount"=>"כרטיסי תקלה לפי חשבון",
"ticketsbycontact"=>"כרטיסי תקלה לפי איש קשר",

'LBL_DASHBRD_HOME'=>'עמוד הבית של הגרפים',
'LBL_HORZ_BAR_CHART'=>'גרף עמודות אופקי',
'LBL_VERT_BAR_CHART'=>'גרף עמודות אנכי',
'LBL_PIE_CHART'=>'גרף עוגה',
'LBL_NO_DATA'=>'אין מידע זמין',
'DashboardHome'=>'DashBoardHome',
'GRIDVIEW'=>'הצגת הרשת',
'NORMALVIEW'=>'תצוגה נורמלית',
'VIEWCHART'=>'הצגת הגרף',
'LBL_DASHBOARD'=>'גרף',
);

?>
