
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
	<head>
		<meta HTTP-EQUIV="Content-Type" CONTENT="text/html; charset=windows-1255">
				
				<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1" />
	
	

<script type="text/javascript" src="http://www.ilbiz.co.il/global_func/prototype.js"></script>
<script src="http://ilbiz.co.il/ClientSite/version_1/style/bootstrap_2.3.2/jquery.min.js"></script>



		<link rel="stylesheet" href="http://ilbiz.co.il/ClientSite/version_1/style/bootstrap_2.3.2/bootstrap.min.css" type="text/css">
	<link rel="stylesheet" type="text/css" media="screen" href="http://ilbiz.co.il/ClientSite/version_1/landing_style.php?unk=706519427333827826&ld=373">
</head>


<body>



	
	<script src="http://ilbiz.co.il/ClientSite/version_1/style/bootstrap_2.3.2/jquery.validate.js"></script>
	<script src="http://ilbiz.co.il/ClientSite/version_1/style/bootstrap_2.3.2/bootstrap.min.js"></script>
	

	
	<link rel="stylesheet" href="http://ilbiz.co.il/ClientSite/version_1/style/bootstrap_2.3.2/bootstrap-datepicker.min.css" type="text/css">	
	<script src="http://ilbiz.co.il/ClientSite/version_1/style/bootstrap_2.3.2/bootstrap-datepicker.min.js"></script>
	<script src="http://ilbiz.co.il/ClientSite/version_1/style/bootstrap_2.3.2/bootstrap-datepicker.he.min.js"></script>	
	
			
	
	<script type="text/javascript">

	jQuery.noConflict();
	if (Prototype.BrowserFeatures.ElementExtensions) {
		var disablePrototypeJS = function (method, pluginsToDisable) {
				var handler = function (event) {
					event.target[method] = undefined;
					setTimeout(function () {
						delete event.target[method];
					}, 0);
				};
				pluginsToDisable.each(function (plugin) { 
					jQuery(window).on(method + '.bs.' + plugin, handler);
				});
			},
			pluginsToDisable = ['collapse', 'dropdown', 'modal', 'tooltip', 'popover'];
		disablePrototypeJS('show', pluginsToDisable);
		disablePrototypeJS('hide', pluginsToDisable);
	}





	</script>

	
	<div  id='checking'><form action='#'>
<input type='text' id='dpcheck' name='check' class='check' placeholder='  ' >
																	</form></div>
<script type='text/javascript'>
jQuery('#dpcheck').datepicker({format: 'dd/mm/yyyy',autoclose:true,language: 'he',isRTL: false,todayHighlight: true}); 
</script>				
	</body>
</html>

