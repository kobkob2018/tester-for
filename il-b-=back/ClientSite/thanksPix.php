<?php

require_once('/home/ilan123/domains/ilbiz.co.il/public_html/global_func/vars.php');

?>
<html>
<head>
	<title></title>
</head>

<body>
<?php if(isset($_GET['useConstant'])): ?>
<!-- Google Code for המרות בדיקה Conversion Page -->
<script type="text/javascript">
/* <![CDATA[ */
var google_conversion_id = 1066965683;
var google_conversion_language = "en";
var google_conversion_format = "3";
var google_conversion_color = "ffffff";
var google_conversion_label = "DkwACLSWt2kQs7Xi_AM";
var google_remarketing_only = false;
/* ]]> */
</script>
<script type="text/javascript" src="//www.googleadservices.com/pagead/conversion.js">
</script>
<noscript>
<div style="display:inline;">
<img height="1" width="1" style="border-style:none;" alt="" src="//www.googleadservices.com/pagead/conversion/1066965683/?label=DkwACLSWt2kQs7Xi_AM&guid=ON&script=0"/>
</div>
</noscript>

<?php else: ?>
<?php
	$sql = "SELECT thanksRedirect , thanksPixel FROM estimate_miniSite_defualt_block WHERE type = '".ifint($_GET['pageId'])."'";
	$res = mysql_db_query(DB, $sql);
	$estimate_data = mysql_fetch_array($res);
	
	if( $estimate_data['thanksPixel'] != "" )
	{
		echo str_replace("´","'",stripslashes($estimate_data['thanksPixel']));
	}
?>
<?php endif; ?>
</body>
</html>
