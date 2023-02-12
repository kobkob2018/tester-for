<?php 
/* 
* Copyright © 2006 ILbiz. All Rights Reserved
* email:	webmaster@ilbiz.co.il
* 
* this page you can see all the color that we give to the client choose
*/


// field name => "form name"
$arr_color = array(
	bg_link => "site_settings_form",
	top_bg_link => "site_settings_form",
	top_link_color => "site_settings_form",
	top_link_hover_color => "site_settings_form",
	color_link => "site_settings_form",
	color_link_over => "site_settings_form",
	site_text_color => "site_settings_form",
	site_bg_color => "site_settings_form",
	conent_bg_color => "site_settings_form",
	border_color => "site_settings_form",
	menus_color => "site_settings_form",
	headline_color => "site_settings_form",
	top_slice_flash_color => "site_settings_form",
	flash_right_menu_color => "site_settings_form",
	open_flash_color => "site_settings_form",
	galley_back_color => "site_settings_form",
	color_e_comes_menu_right => "site_settings_form",
	calendar_borderColor => "site_settings_form",
	jobHeadlineColor => "site_settings_form",
	jobTextColor => "site_settings_form",
	kobiaColorTitle => "site_settings_form",
	kobiaColorMid => "site_settings_form",
	kobiaColorMore => "site_settings_form",
	page_headline_color => "site_settings_form",
	
						
	color => "text_update_form",
	
	banner_color => "update_bann_MP_form",
	
	scrollNewsHeadlineColor => "site_settings_form",
	cartLinsColor => "site_settings_form",
	netLoginFontColor => "site_settings_form",
);

foreach( $arr_color as $val => $key )	{
	if( $val == $_REQUEST['name'] )	{
		$valu = $val;
		$form = $key;
	}
}

?>
<HTML>
<HEAD>
<TITLE>Colors</TITLE>
<STYLE TYPE="text/css">
<!--
A:hover { color:#FF0000; ; text-decoration: underline}
A:link { color:#333399; }
.whiteText { ; }
-->
</STYLE>
<meta charset="visual">
    <script type="text/javascript" language="JavaScript">
    <!--
    function color(color)
    {
       	window.opener.document.<?echo $form;?>.<?echo $valu;?>.value=color;
    	window.close();
    }
    // -->
    </script>
</head>
<body marginwidth=0 leftmargin="0" text="#FFFFFF" link="#FFFFFF" vlink="#FFFFFF" alink="#FFFFFF">
<center>
<script language="JavaScript">
clr=new Array('00','20','40','60','80','a0','c0','ff');
for (i=0;i<8;i++) { 
document.write("<table border=1 cellpadding=8 cellspacing=0 bordercolor=#000000>");
for (j=0;j<8;j++) {
document.write("<tr>");
for (k=0;k<8;k++) {
document.write('<td bgcolor="#'+clr[i]+clr[j]+clr[k]+'">');
document.write('<tt><a href="JavaScript:color(\''+clr[i]+clr[j]+clr[k]+'\')"><font color="#'+clr[7-i]+clr[7-j]+clr[7-k]+'"> ');
document.write(clr[i]+clr[j]+clr[k]+' </font></a></tt></td>'); }
document.write("</tr>"); }
document.write("</table><br>"); }
// end -->
</script>
</center>
</BODY></HTML>