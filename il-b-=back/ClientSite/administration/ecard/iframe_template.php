<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
	<meta name="viewport" content="width=device-width, initial-scale=1.0" />
	<title><?=$word[LANG]['browser_title'];?></title>
	<link rel="stylesheet" href="ecard/style/bootstrap_2.3.2/bootstrap.min.css" type="text/css">
	<link rel="stylesheet" href="ecard/style/bootstrap_2.3.2/bootstrap.rtl.css" type="text/css">	
	<link rel="stylesheet" href="ecard/style/bootstrap_2.3.2/bootstrap-responsive.min.css" type="text/css">
	<link rel="stylesheet" href="ecard/style/bootstrap_2.3.2/bootstrap-responsive.rtl.css" type="text/css">
	<link rel="stylesheet" href="ecard/style/bootstrap_2.3.2/rtl-xtra.min.css" type="text/css">
	<script src="ecard/style/bootstrap_2.3.2/jquery.min.js"></script>
	<script src="ecard/style/bootstrap_2.3.2/jquery.validate.js"></script>
	<script src="ecard/style/bootstrap_2.3.2/bootstrap.min.js"></script>
	

	
	<link rel="stylesheet" href="ecard/style/bootstrap_2.3.2/bootstrap-datepicker.min.css" type="text/css">	
	<script src="ecard/style/bootstrap_2.3.2/bootstrap-datepicker.min.js"></script>
	<script src="ecard/style/bootstrap_2.3.2/bootstrap-datepicker.he.min.js"></script>		
	<link rel="stylesheet" href="ecard/style/mobile.css?v=1.6" type="text/css" />
	<script src="ecard/style/mobile.js"></script>	
</head>
<body onLoad="window.parent.scroll(0,0);">
	<div id='iframe_master' class='container'>
		<?php echo get_content($_REQUEST['main']); ?>
	</div>
</body>


</html>