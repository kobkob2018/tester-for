<?php

/* 
* Copyright © 2010 ILbiz. All Rights Reserved
* email:	webmaster@ilbiz.co.il
*
* 
* the landing of the client site
*/
//http://il.php.net/manual/en/ref.errorfunc.php#errorfunc.constants.errorlevels.e-warning
	
	error_reporting(0);
	session_start();
	if (strpos($_SERVER['HTTP_USER_AGENT'],'WhatsApp') === false){
		header('Content-Type: text/html; charset=windows-1255');  
	}
	require_once('/home/ilan123/domains/ilbiz.co.il/public_html/global_func/vars.php');
	if(!defined("HTTP_S")){
		define("HTTP_S","http");
	}

	$abpath_unk_def = $_SERVER[DOCUMENT_ROOT]."/unk_def.php";
	if( file_exists($abpath_unk_def) && !is_dir($abpath_unk_def) )
	{
		require($abpath_unk_def);
		define('UNK',DEFINE_UNK);
		$from_fomain = 1;
	}
	else
	{
		$uu = ( $_GET['unk'] == "" ) ? $_POST['unk'] : $_GET['unk'];
		
		define('UNK',$uu);
		
		$sql = "select domain from users where unk = '".UNK."' and deleted = '0'";
		$res_domain = mysql_db_query(DB,$sql);
		$data_domain = mysql_fetch_array($res_domain);
		
		if( $data_domain['domain'] != "" )
		{
			$abpath_unk_def2 = "/home/ilan123/domains/".$data_domain['domain']."/public_html/unk_def.php";
			if( file_exists($abpath_unk_def2) && !is_dir($abpath_unk_def2) )
			{
					header("location:http://".$data_domain['domain']."/index.php?".$_SERVER[QUERY_STRING]);
					exit;
			}
		}
	}

	if( UNK == "" )
		die("");
ob_start();	
	if( $from_fomain == 1 )
	{
		$sql = "select domain from users where unk = '".UNK."' and deleted = '0'";
		$res_domain = mysql_db_query(DB,$sql);
		$data_domain = mysql_fetch_array($res_domain);
		
		define('HTTP_PATH',HTTP_S."://".$data_domain['domain']);
		define('SERVER_PATH',"/home/ilan123/domains/".$data_domain['domain']."/public_html");
		
		$http_path = HTTP_S."://".$data_domain['domain'];
		$server_path = "/home/ilan123/domains/".$data_domain['domain']."/public_html";
	}
	else
	{
		define('HTTP_PATH',HTTP_S."://www.ilbiz.co.il/ClientSite");
		define('SERVER_PATH',"/home/ilan123/domains/ilbiz.co.il/public_html/ClientSite");
		
		$http_path = HTTP_S."://www.ilbiz.co.il/ClientSite";
		$server_path = "/home/ilan123/domains/ilbiz.co.il/public_html/ClientSite";
	}

	define('LANG',"he");
	// class
	require_once("/home/ilan123/domains/ilbiz.co.il/public_html/global_func/DB.php");
	require_once("/home/ilan123/domains/ilbiz.co.il/public_html/global_func/global_functions.php");
	require_once("/home/ilan123/domains/ilbiz.co.il/public_html/global_func/forms_creator.php");
	require_once('/home/ilan123/domains/ilbiz.co.il/public_html/lang/lang.he.php');
	
	require_once("/home/ilan123/domains/ilbiz.co.il/public_html/ClientSite/version_1/functions/strac_func.php");
	require_once("/home/ilan123/domains/ilbiz.co.il/public_html/ClientSite/version_1/functions/functions.php");
	require_once('client_castum_functions.php');
	require_once("/home/ilan123/domains/ilbiz.co.il/public_html/ClientSite/version_1/functions/functions_12.php");

	// for settigns about the colors
	$sql = "select * from user_site_settings where unk = '".UNK."' and deleted = '0' and status = '0'";
	$res_settings = mysql_db_query(DB,$sql);
	$data_settings = mysql_fetch_array($res_settings);

	$sql = "select * from user_extra_settings where unk = '".UNK."'";
	$res_extra_settings = mysql_db_query(DB,$sql);
	$data_extra_settings = mysql_fetch_array($res_extra_settings);
	
	// for gernral data about the user
	$sql = "select * from users where unk = '".UNK."' and deleted = '0' and status = '0'";
	$res_name = mysql_db_query(DB,$sql);
	$data_name = mysql_fetch_array($res_name);

	if( empty($data_name['id']) )
		die("");

	// all color on the page
	$sql = "select * from user_colors_set where unk = '".UNK."'";
	$res_colors = mysql_db_query(DB,$sql);
	$data_colors = mysql_fetch_array($res_colors);

	$landingId= ( $_GET['ld'] == "" ) ? "" : "id='".$_GET['ld']."' AND ";
	$sql = "SELECT * FROM sites_landingPage_settings WHERE ".$landingId." unk = '".UNK."' ORDER BY landing_defualt DESC , id";
	$resSetting = mysql_db_query(DB,$sql);
	$dataLDSetting = mysql_fetch_array($resSetting);
	if($dataLDSetting['id'] == ""){
		$sql = "SELECT * FROM sites_landingPage_settings WHERE unk = '".UNK."' ORDER BY landing_defualt DESC , id";
		$resSetting = mysql_db_query(DB,$sql);
		$dataLDSetting = mysql_fetch_array($resSetting);	
	}

	$tracking_arr = get_tracking_url_for_landing($dataLDSetting,$gl_source);
	$c_tracking_on = $tracking_arr['c_tracking_on'];
	$tracking_url = $tracking_arr['page'];
	$form_tracking_url = $tracking_arr['form'];
	$tracking_id = $tracking_arr['tracking_id'];
	if( $dataLDSetting['goto_url_301'] != "" )
	{
		header( "HTTP/1.1 301 Moved Permanently" );
		$redirect_url = iconv("windows-1255","UTF-8", $dataLDSetting['goto_url_301']);
		header( "location: ".stripslashes($redirect_url)."" ); 
	}
	$main_settings_sql = "SELECT * FROM main_settings WHERE id = 1";
	$main_settings_res = mysql_db_query(DB,$main_settings_sql);
	$main_settings_data = mysql_fetch_array($main_settings_res);
	$cache_version = "5.2";
	if($main_settings_data['cache_version'] != ""){
		$cache_version =$main_settings_data['cache_version'];
	}	
	$dataLDSetting['show_phone'] = $main_settings_data['show_phone_bar'];
	if($dataLDSetting['use_html_skaleton']){
		require_once("version_2_landing.php");
		$full_content = ob_get_clean();
		$full_content = str_replace("http://",HTTP_S."://",$full_content);
		echo $full_content;		
		exit();
	}
	
	if(isset($_REQUEST['aff_id'])){
		$dataLDSetting['show_phone'] = false;
	}
	$addMoreTitle = selectBrwoserTitle($data_words, $um, "1");
	$site_title = ( $data_settings['site_title'] != "" ) ? stripslashes($data_settings['site_title']) : "";
	$addMoreTitle = ( !empty($addMoreTitle) ) ? $addMoreTitle.", ".$site_title : $site_title;

	if( (UNK == "285240640927706447" && ( $_GET['ld'] == "48" || $_GET['ld'] == "49" ) ) )
		$landing_10service = "1";
	else
		$landing_10service = "0";
			
	
	$abpath_temp2 = SERVER_PATH."/tamplate/".stripslashes($data_colors['top_slice']);
	
	if( file_exists($abpath_temp2) && !is_dir($abpath_temp2) )	{
		$temp_test = explode( "." , $data_colors['top_slice'] );
		
		if( $temp_test[1] == "swf" )
		{
			$swf_top_slice = "
				<div id=\"LStop_slice\"></div>
				
				<script type=\"text/javascript\">
					swfPlayer(\"/tamplate/".stripslashes($data_colors['top_slice'])."\",\"top_slice\",\"775\",\"".stripslashes($data_colors['top_slice_flash_height'])."\",\"#".stripslashes($data_colors['top_slice_flash_color'])."\",\"LStop_slice\");
				</script>";
		}
		else 
		{
			$im_size = GetImageSize ($abpath_temp2); 
			$imageWidth = $im_size[0]; 
			$imageHeight = $im_size[1];
			
			$img_top_slice = "background=\"".HTTP_PATH."/tamplate/".stripslashes($data_colors['top_slice'])."\" width=\"".$imageWidth."\" height=\"".$imageHeight."\"";
		}
	}
	else 
		$img_top_slice = "";
	
	
	$text_area_bg = "";
	
	if( UNK == "091575332773384992" )
	{
		$text_area_bg = "background='".HTTP_PATH."/tamplate/091575332773384992-txtarea.jpg'";
	}
ob_start();	
//echo '<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">';
echo '<!DOCTYPE HTML>';
echo '
<html>
<head>
';
	if (strpos($_SERVER['HTTP_USER_AGENT'],'WhatsApp') !== false){
		echo '<meta HTTP-EQUIV="Content-Type" CONTENT="text/html; charset=UTF-8">';
		$page_title =  iconv("windows-1255","UTF-8", $addMoreTitle); 	
		echo '<meta property="og:title" content="'.$page_title.'" />';	
		echo '<title>'.$page_title.'</title>';		
		echo '</head><body></body></html>';
		exit;
	}
	echo '<meta HTTP-EQUIV="Content-Type" CONTENT="text/html; charset=windows-1255">';
	echo '<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1" />'; 	
	
	
	
		echo '<title>'.$addMoreTitle.'</title>';
		
		$keywords = str_replace("\"" , "" , stripslashes($data_settings['keywords']) );
		$description = str_replace("\"" , "" , stripslashes($data_settings['description']) );
	
	if( $description != "" )
		echo '<META NAME="DESCRIPTION" CONTENT="'.$description.'">';
	
	if( $keywords != "" )
		echo '<META NAME="KEYWORDS" CONTENT="'.$keywords.'">';
?>
<script type="text/javascript" src="http://www.ilbiz.co.il/global_func/prototype.js"></script>
<script type="text/javascript" src="http://www.ilbiz.co.il/ClientSite/js/ajax.js"></script>
<script type="text/javascript" src="http://ilbiz.co.il/ClientSite/version_1/style/bootstrap_2.3.2/jquery.min.js"></script>
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
<script src="http://ilbiz.co.il/ClientSite/version_1/style/js/estimate_form.js?v=<?php echo $cache_version; ?>"></script>
<?php																		

echo '<script src="http://ilbiz.co.il/ClientSite/version_1/style/bootstrap_2.3.2/jquery.validate.js"></script>';
echo '<link rel="stylesheet" type="text/css" media="screen" href="http://ilbiz.co.il/ClientSite/version_1/landing_style.php?unk='.UNK.'&ld='.$dataLDSetting['id'].'">';

echo '<link rel="stylesheet" href="http://ilbiz.co.il/ClientSite/version_1/style/bootstrap_2.3.2/bootstrap-datepicker.min.css" type="text/css">';
echo '<script src="http://ilbiz.co.il/ClientSite/version_1/style/bootstrap_2.3.2/bootstrap-datepicker.min.js"></script>';
echo '<script src="http://ilbiz.co.il/ClientSite/version_1/style/bootstrap_2.3.2/bootstrap-datepicker.he.min.js"></script>';




echo '
<script type="text/javascript" src="http://ilbiz.co.il/ClientSite/other/flash/ver2/swfobject.js"></script>';


if( $data_extra_settings['head_free_code'] != "" )
	{
		echo str_replace("´","'",stripslashes($data_extra_settings['head_free_code']));
	}

//if( file_exists(SERVER_PATH."/favicon.ico") && !is_dir(SERVER_PATH."/favicon.ico") )
//	echo '<link rel="shortcut icon" type="image/x-icon" href="/favicon.ico">';

$Browser = detectBrowser();
?>

<script type="text/javascript" src="https://apis.google.com/js/plusone.js">
  {lang: 'iw'}
</script>

<?php /*
<script type="text/javascript" src="http://www.ilbiz.co.il/ClientSite/js/scriptaculous.js?load=effects,builder"></script>
<script type="text/javascript" src="http://www.ilbiz.co.il/ClientSite/js/lightbox.php?lang=he"></script>
<link rel="stylesheet" href="http://www.ilbiz.co.il/ClientSite/js/lightbox_css.php?lang=he" type="text/css" media="screen">
*/ ?>
				<script type="text/javascript" src="http://ilbiz.co.il/ClientSite/version_1/style/fancybox/jquery.fancybox-1.3.4.js"></script>
				<link rel="stylesheet" type="text/css" href="http://ilbiz.co.il/ClientSite/version_1/style/fancybox/jquery.fancybox-1.3.4.css" media="screen" />				
											
				<script type="text/javascript">
					jQuery(function($){
						$(document).ready(function() {
							$("a[rel=fancy_image]").fancybox({
								'transitionIn'		: 'none',
								'transitionOut'		: 'none',
								
							});
						});
					});
				</script>
	<script type="text/javascript">
  
  function swfPlayer(swfPath, swfName , swfWidth, swfHeight , swfBgcolor , parentName ) 
	{
		
		var flashvars = false; 
		
		if( swfBgcolor.length == 1 )
			var trans = "transparent";
		else
			var trans = "opaque";
		
		var attributes = {};
		attributes.id = parentName;
		
		swfobject.embedSWF(swfPath, parentName, swfWidth, swfHeight, "9.0.0", "http://www.ilbiz.co.il/ClientSite/other/flash/ver2/expressInstall.swf", flashvars, {wmode: trans,bgColor: swfBgcolor,allowScriptAccess: "always"}, attributes);
	}
	
	
	function videoL( uid )
	{
		var url = 'ajax_landing.php?main=video&unk=<?=UNK;?>&uid=' + uid;
		new Ajax.Updater("playing_video" , url, {asynchronous:true});
	}
	
	function videoML( uid )
	{
		var url = 'ajax_landing.php?main=video&ex=1&unk=<?=UNK;?>&uid=' + uid;
		new Ajax.Updater("playing_video2" , url, {asynchronous:true});
	}
	
	function ajax_estimateSiteHeight(cat , subCat , cat_spec , pageId)
	{
		var url = "ajax.php?main=estimateSiteHeight&cat=" + cat + "&subCat=" + subCat + "&cat_spec=" + cat_spec + "&pageId=" + pageId ;
		new Ajax.Updater("estimateSiteHeightDiv" , url, {asynchronous:true});
	}
	
	function ajax_estimateSiteHeight_send_data()
	{
		var Fm_name = document.getElementById("Fm_name");
		var Fm_phone = document.getElementById("Fm_phone");
		var Fm_city = document.getElementById("Fm_city");
		//var taKn = document.getElementById("taKn");
		
		document.getElementById('submitit').disabled=true;
		
		var str = "";
		var counter = 1;
		
		if(Fm_name.value == "" ) {
			str += counter++ + ". שם מלא \n";			
		}
		
		if(Fm_phone.value =="") {
			str += counter++ + ". טלפון \n";			
		}
		
		if(Fm_city.value =="") {
			str += counter++ + ". עיר \n";			
		}
		
		if(ValidateMobilePhone(Fm_phone.value) != true && Fm_phone.value != "" ) {
			str += counter++ + ". " + ValidateMobilePhone(Fm_phone.value);			
		}
		
		/*if(!taKn.checked) {
			str += counter++ + ". אנא אשרו שקראתם ואתם מאשרים את התקנון \n";			
		}*/
		
		if(counter > 1) {
			str = ":בכדי להשלים את הפניה, יש למלא את השדות הבאים \n\n" + str;
			alert(str);	
			document.getElementById('submitit').disabled=false;
		}
		else
		{
			var cat_f = document.getElementById("cat_f").value;
			var cat_s = document.getElementById("cat_s").value;
			var cat_prof = document.getElementById("cat_spec").value;
			var clientUnk = document.getElementById("clientUnk").value;
			var stat_id = document.getElementById("stat_id").value;
			var Fm_name = document.getElementById("Fm_name").value;
			var Fm_phone = document.getElementById("Fm_phone").value;
			var Fm_email = document.getElementById("Fm_email").value;
			var Fm_city = document.getElementById("Fm_city").value;
			var Fm_note = document.getElementById("Fm_note").value;
			//var taKn = document.getElementById("taKn").value;
			var pageId = document.getElementById("pageId").value;
			
			
			var params = "&cat_f=" + cat_f + "&cat_s=" + cat_s + "&cat_prof=" + cat_prof + "&clientUnk=" + clientUnk + "&stat_id=" + stat_id + "&Fm_name=" + Fm_name + 
			"&Fm_phone=" + Fm_phone + "&Fm_email=" + Fm_email + "&Fm_city=" + Fm_city + "&Fm_note=" + Fm_note + "&pageId=" + pageId;
			
			var url = "ajax.php?main=estimateSiteInsert" + params ;
			new Ajax.Updater("estimateSiteHeightDiv" , url, {evalScripts:true});
		}
	
	}
	
	function ValidateMobilePhone(mobile)
  {
     var x = mobile;
     var str = "";
     
     if(isNaN(x)||x.indexOf(" ")!=-1)
     {
        str += "אנא הקלד מספר טלפון המורכב ממספרים בלבד, ללא מקף או סימנים אחרים \n"
        return str; 
     }
     if (x.length < 9 )
     {
         str += "אנא הקלד לפחות 9 ספרות למספר הטלפון \n"
          return str;
     }
     if (x.length > 11 )
     {
         str += "אנא הקלד מקסימום 10 ספרות למספר הטלפון \n"
          return str;
     }
     if (x.charAt(0)!="0")
     {
          str += "מספר הטלפון חייב להתחיל ב 0 \n"
          return str
     }

     return true;
  }
  
  function loadSWFwithBase(swfPath,swfName,swfWidth,swfHeight,swfBgcolor,parentName)
		{
			var flashvars = false; 
			
			if( swfBgcolor.length == 1 )
				var trans = "transparent";
			else
				var trans = "opaque";
			
			var attributes = {};
			attributes.id = parentName;
			
			swfobject.embedSWF(swfPath, swfName, swfWidth, swfHeight, "9.0.0", "http://www.ilbiz.co.il/ClientSite/other/flash/ver2/expressInstall.swf", flashvars, {wmode: trans,bgColor: swfBgcolor,allowScriptAccess: "always"}, attributes);
			
		}
		
	function gotoLanding(landld)
	{
			var url = "ajax_landing.php?main=loadLandingModules&unk=<?=UNK;?>&ld=" + landld ;
			new Ajax.Updater("landingContent" , url, {evalScripts:true});
	}
	</script>
<?
$bodybgcolor = ( UNK != "091575332773384992" && $_GET['ld'] != '251' ) ? "background-color: #ffffff;" : "";
$bodyWidth = ( $landing_10service != "1" ) ? "max-width:1024px;" : "width:950px;  padding-right: 20px;";
?>
<style type="text/css">
	.body-table{
		<?php echo $bodybgcolor; ?>
		<?php /* echo $bodyWidth; */ ?>
	}
	<?php if(!$dataLDSetting['show_phone']): ?>
		.phone-hours{display:none;}
	<?php endif; ?>
</style>
<?php echo $dataLDSetting['head_free_html']; ?>
<?php if( $dataLDSetting['fb_audience_code'] != "" ): ?>
	<?php echo $dataLDSetting['fb_audience_code']; ?>
<?php endif; ?>		
</head>

<body>

<div id="fb-root"></div>
<script type="text/javascript">
  window.fbAsyncInit = function() {FB.init({appId: '', status: true, cookie: true, xfbml: true});};
  (function() {
    var e = document.createElement('script'); e.async = true;
    e.src = document.location.protocol + '//connect.facebook.net/en_US/all.js';
    document.getElementById('fb-root').appendChild(e);
  }());
</script>


<table cellpadding=0 cellspacing=0 border=0 align=center class='body-table'  dir=rtl>
		
		<?
		if( $landing_10service == "1" )
			echo "<tr><td height=175></td></tr>";
		?>
		<tr>
			<td>

				<div id="page">
				
					<div id="topSliceBack">
						<div id="topSliceText1"><?=stripslashes($dataLDSetting['text_1']);?></div>
						<div id="topSliceText2"><?=stripslashes($dataLDSetting['text_2']);?></div>
						<div id="topSliceText3"><?=stripslashes($dataLDSetting['text_3']);?></div>
						<div id="topSliceLinks">
							<table cellpadding=0 cellspacing=0 border=0>
								<tr>
									<?
										$sql = "SELECT * FROM sites_landingPage_links WHERE deleted=0 AND landing_id='".$dataLDSetting['id']."' AND unk = '".UNK."' ORDER BY place";
										$resLinks = mysql_db_query(DB,$sql);
										
										while( $dataLinks = mysql_fetch_array($resLinks) )
										{
											if( $dataLinks['link_target'] == "ajax" )
											{
												$ex_link = explode("?ld=" , $dataLinks['link_url'] );
												$url = "javascript:gotoLanding(\"".$ex_link[1]."\")";
											}
											elseif( eregi( "http://" , $dataLinks['link_url'] ) )
												$url = $dataLinks['link_url'];
											else
												$url = "http://".$dataLinks['link_url'];
											
											$target = ( $dataLinks['link_target'] != "ajax" ) ? "target='".$dataLinks['link_target']."'" : "";
											$a_start = ( $dataLinks['link_url'] != "" ) ? "<a href='".$url."' ".$target." style='color: #".$dataLinks['link_color']."; text-decoration:none;'>" : "";
											$a_end = ( $dataLinks['link_url'] != "" ) ? "</a>" : "";
											
											$link_size = ( $dataLinks['link_url'] != "" ) ? "font-size: ".$dataLinks['link_size']."px;" : "";
											echo "<td id='top_link_".$dataLinks['id']."' style='color: #".$dataLinks['link_color'].";  text-decoration:none;'>".$a_start.stripslashes($dataLinks['link_name']).$a_end."</td>";
											echo "<td width=20></td>";
										}
									?>
								</tr>
							</table>
						</div>
					</div>
				</div>

				
				
				<div id="mobile_page">
						<?php
						$mobile_abpath_temp1 = SERVER_PATH."/new_images/landing/".$dataLDSetting['topslice_bg_mobile'];
						if( file_exists($mobile_abpath_temp1) && !is_dir($mobile_abpath_temp1) )
						{
							$mobile_temp_test = explode( "." , $dataLDSetting['topslice_bg_mobile'] );
							
							if( $mobile_temp_test[1] != "swf" ){
								$mobile_top_img = HTTP_PATH."/new_images/landing/".$dataLDSetting['topslice_bg_mobile'];
								?>
								<div class="mobile_logo">
									<img src="<?php echo $mobile_top_img; ?>" title=""  style="width:100%"/>
								</div>
								<?php
							}
						}
						?>	
				<div style="display:none;" id="negishut_topSliceLinks">
					<table cellpadding=0 cellspacing=0 border=0>
						<tr>
							<?
								$sql = "SELECT * FROM sites_landingPage_links WHERE deleted=0 AND landing_id='".$dataLDSetting['id']."' AND unk = '".UNK."' ORDER BY place";
								$resLinks = mysql_db_query(DB,$sql);
								
								while( $dataLinks = mysql_fetch_array($resLinks) )
								{
									if( $dataLinks['link_target'] == "ajax" )
									{
										$ex_link = explode("?ld=" , $dataLinks['link_url'] );
										$url = "javascript:gotoLanding(\"".$ex_link[1]."\")";
									}
									elseif( eregi( "http://" , $dataLinks['link_url'] ) )
										$url = $dataLinks['link_url'];
									else
										$url = "http://".$dataLinks['link_url'];
									
									$target = ( $dataLinks['link_target'] != "ajax" ) ? "target='".$dataLinks['link_target']."'" : "";
									$a_start = ( $dataLinks['link_url'] != "" ) ? "<a href='".$url."' ".$target." style='color: #".$dataLinks['link_color']."; '>" : "";
									$a_end = ( $dataLinks['link_url'] != "" ) ? "</a>" : "";
									
									$link_size = ( $dataLinks['link_url'] != "" ) ? "font-size: ".$dataLinks['link_size']."px;" : "";
									echo "<td id='negishut_top_link_".$dataLinks['id']."' style='color: #".$dataLinks['link_color'].";  text-decoration:none;'>".$a_start.stripslashes($dataLinks['link_name']).$a_end."</td>";
									echo "<td width=20></td>";
								}
							?>
						</tr>
					</table>
				</div>						
					<div id="mobile_topSliceBack">
						<div id="mobile_topSliceText1"><?=stripslashes($dataLDSetting['text_1']);?></div>
						<div id="mobile_topSliceText2"><?=stripslashes($dataLDSetting['text_2']);?></div>
						<div id="mobile_topSliceText3"><?=stripslashes($dataLDSetting['text_3']);?></div>

					</div>
				
				</div>
				<script type="text/javascript">
					function open_links(){
						jQuery(function($){
							if($("#mobile_open_button").attr("rel")!= "open"){
								$("#mobile_open_button").attr("rel","open");
								$("#mobile_topSliceLinks_list").show();
							}
							else{
								$("#mobile_open_button").attr("rel","close");
								$("#mobile_topSliceLinks_list").hide();								
							}
							
						});
						
					}
				</script>
					<div id="mobile_topSliceLinks">
						<div id="mobile_open_button_wrap">
							<a rel="close" id="mobile_open_button" href="javascript://" onclick="open_links();">
								<div class="smalline"></div>
								<div class="smalline"></div>
								<div class="smalline"></div>
							</a>
						</div>
						
						<div id="mobile_topSliceLinks_list" style="display:none;">

								<?
									$sql = "SELECT * FROM sites_landingPage_links WHERE deleted=0 AND landing_id='".$dataLDSetting['id']."' AND unk = '".UNK."' ORDER BY place";
									$resLinks = mysql_db_query(DB,$sql);
									
									while( $dataLinks = mysql_fetch_array($resLinks) )
									{
										if( $dataLinks['link_target'] == "ajax" )
										{
											$ex_link = explode("?ld=" , $dataLinks['link_url'] );
											$url = "javascript:gotoLanding(\"".$ex_link[1]."\")";
										}
										elseif( eregi( "http://" , $dataLinks['link_url'] ) )
											$url = $dataLinks['link_url'];
										else
											$url = "http://".$dataLinks['link_url'];
										
										$target = ( $dataLinks['link_target'] != "ajax" ) ? "target='".$dataLinks['link_target']."'" : "";
										$a_start = ( $dataLinks['link_url'] != "" ) ? "<a href='".$url."' ".$target." style='color: #".$dataLinks['link_color']."; text-decoration:none;'>" : "";
										$a_end = ( $dataLinks['link_url'] != "" ) ? "</a>" : "";
										
										$link_size = ( $dataLinks['link_url'] != "" ) ? "font-size: ".$dataLinks['link_size']."px;" : "";
										echo "<div class='mobile_topSliceLink' style='color: #".$dataLinks['link_color']."; ".$link_size." text-decoration:none;'>".$a_start.stripslashes($dataLinks['link_name']).$a_end."</div>";
										
									}
								?>
						</div>
					</div>					
			</td>
		</tr>	
		<tr><td height=10 <?php echo $text_area_bg; ?>></td></tr>
		

		<tr>
			<td align=right <?php echo $text_area_bg; ?>>
				<div id="landingContent">
				<?
					$sql = "SELECT * FROM sites_landingPage_modules WHERE unk = '".UNK."' AND landing_id = '".$dataLDSetting['id']."' AND deleted=0 ORDER BY place , id";
					$resModules = mysql_db_query(DB,$sql);
					
					echo "<table border=\"0\" width=100% cellspacing=\"0\" cellpadding=\"0\" class=\"maintext\">";
					$module_index = 0;
					$fb_share_pos = $dataLDSetting['fb_share_pos'];
					$fb_share_ok = false;
					if($fb_share_pos == ""){
						$fb_share_pos = 0;
					}
					if($fb_share_pos == '-1'){
						$fb_share_ok = true;
					}
						while( $dataModules = mysql_fetch_array($resModules) )
						{

							if($module_index == $fb_share_pos){
								if( $landing_10service != "1")
								{
									put_fb_share();
									$fb_share_ok = true;
								}
							}
							$bgColor = ( $dataModules['bgColor'] != "" ) ? "bgcolor='#".$dataModules['bgColor']."' style='padding: 20px;'" : "";
							$fieldset_start = ( $dataModules['border_color'] != "" ) ? "<fieldset id='dims' style='border:1px solid #".$dataModules['border_color']."; padding: 20px;'><legend>" : "";
							$legend_end = ( $dataModules['border_color'] != "" ) ? "</legend>" : "";
							$fieldset_end = ( $dataModules['border_color'] != "" ) ? "</fieldset>" : "";
							
							if( $bgColor == "" && $fieldset_start == "" )
								$style = " style='padding: 20px;'";
							else
								$style = "";
							
							$abpath_temp2 = SERVER_PATH."/new_images/landing/".$dataModules['title_icon'];
							if( file_exists($abpath_temp2) && !is_dir($abpath_temp2) )
								$titeIcon = "<img src=\"".HTTP_PATH."/new_images/landing/".$dataModules['title_icon']."\" border=0 style='padding-left: 20px;'>";
							else
								$titeIcon = "";
							
							$headline_style = "font-family: Tahoma,arial; font-size: ".$dataModules['title_size']."px; color: #".$dataModules['title_color'].";";
							$visibility_hidden_start = ( $dataModules['visibility_hidden'] == "1" ) ? "<a href='javascript:void(0)' onclick='document.getElementById(\"open_mu_".$dataModules['id']."\").style.display=\"\"' style='".$headline_style." outline: none; '>" : "";
							$visibility_hidden_end = ( $dataModules['visibility_hidden'] == "1" ) ? "</a>" : "";
							$hide_module = ( $dataModules['visibility_hidden'] == "1" ) ? "style='display: none;'" : "";
							$hide_module_text = ( $dataModules['visibility_hidden'] == "1" ) ? "<span style='font-size:10px;'> - לפרטים נוספים אנא לחצו על הכותרת</span>" : "";
							
							echo "<tr><td height=5 colspan=3 class='td-padder-ver'></td></tr>";
							echo "<tr>";
								echo "<td width=10 class='td-padder-hor'></td>";
								echo "<td ".$bgColor.$style." align=right ".$padding_headline." >";
									echo $fieldset_start.$visibility_hidden_start.$titeIcon.$visibility_hidden_end."<span style='".$headline_style."'><b>".$visibility_hidden_start.stripslashes($dataModules['module_title']).$visibility_hidden_end."</b>".$hide_module_text."</span>".$legend_end;
									echo "<table border=\"0\" width=100% cellspacing=\"0\" cellpadding=\"0\" class=\"maintext\" ".$hide_module." id='open_mu_".$dataModules['id']."'>";
										echo "<tr>";
											echo "<td>";
												echo "<div class='part-wrap'>";
												echo "<table border=\"0\" width=100% cellspacing=\"0\" cellpadding=\"0\" class=\"maintext\">";
													
													$sql = "SELECT * FROM sites_landingPage_paragraph WHERE unk = '".UNK."' AND landing_id = '".$dataLDSetting['id']."' AND module_id = '".$dataModules['id']."' AND deleted=0 ORDER BY place, id";
													$resParagraph = mysql_db_query(DB,$sql);
													
													while( $dataParagraph = mysql_fetch_array($resParagraph) )
													{
														
														switch( $dataParagraph['module_type'] )
														{
															case "0" :
																echo "<tr><td height=7></td></tr>";
																echo "<tr>";
																	echo "<td>".stripslashes($dataParagraph['p_text'])."</td>";
																echo "</tr>";
																echo "<tr><td height=7></td></tr>";
															break;
															
															case "1" :
																$vidValue = explode( "|" , $dataParagraph['p_text'] );
																
																if( $vidValue[0] != "" ) 
																{

																	echo "<div class='videodiv' ><div class='videoWrapper' >
																			<div id='playing_video' style='border: 1px solid #".$dataModules['title_color'].";'>
																			
																				<script>videoL(\"".$vidValue[0]."\")
																				</script>
																			</div></div>
																		";
																
																	echo "<div><a href='index.php?m=vi' class='landing_link'>צפה בהכל</a></div>";
																	echo "</div>";			
																					
																	echo "<div class='videolist' >";					
																	for( $vid=0 ; $vid<=3 ; $vid++ )
																	{
																		if( $vidValue[$vid] != "" )
																		{
																			$sql = "SELECT id, name, img, summary FROM user_video WHERE unk = '".UNK."' AND deleted=0 AND id = '".$vidValue[$vid]."' ";
																			$resVid = mysql_db_query(DB,$sql);
																			$dataVid = mysql_fetch_array($resVid);
																			
																			$abpath_temp = SERVER_PATH."/video/".$dataVid['img'];
																			
																				echo "<div class='landing_text small-vid'>";
																					if( file_exists($abpath_temp) && !is_dir($abpath_temp) )
																						echo "<img src='video/".$dataVid['img']."' border='0' style='border: 1px solid #".$dataModules['title_color'].";'>";
															
																					
																						
																							echo "<div style='color: #".$dataModules['title_color']."; font-size: 14px;'>".stripslashes($dataVid['name'])."</div>";
																							echo "<div class='landing_link'><a href='javascript:void(0)' onclick='videoL(\"".$dataVid['id']."\")' class='landing_link'>צפה</a></div>";
																				echo "</div>";
																		}
																	}
																	echo "</div>";
																}
															break;
															
															case "2" :
																if( $dataParagraph['p_text'] != "" )
																{
																	echo "<tr><td height=7></td></tr>";
																	echo "<tr>";
																		echo "<td><div class='videoWrapper'><div id='playing_video2' style='border: 1px solid #".$dataModules['title_color'].";'><script>videoML(\"".$dataParagraph['p_text']."\")</script></div></div></td>";
																	echo "</tr>";
																	echo "<tr><td height=7></td></tr>";
																}
															break;
															
															case "3" :
																$imgValue = explode( "|" , $dataParagraph['p_text'] );
																
																if( $imgValue[0] != "" ) 
																{
																echo "<tr><td height=7></td></tr>";
																echo "<tr>";
																	echo "<td align=center>";
																		echo "<div class='galery'>";
																			$counter = 0;
																			for( $img=0 ; $img<=8 ; $img++ )
																			{
																				if( $imgValue[$img] != "" )
																				{
																					$sql = "select * from user_gallery_images where unk = '".UNK."' and deleted = '0' AND id = '".$imgValue[$img]."' ";
																					$resImg = mysql_db_query(DB,$sql);
																					$dataImg = mysql_fetch_array($resImg);
																					
																					//if( $counter%4 == 0 ) 
																						echo "<div class='galery-img'>";
																								$abpath_temp_unlink = SERVER_PATH."/gallery/".$dataImg['img'];
																								$abpath_temp_unlinkl = SERVER_PATH."/gallery/L".$dataImg['img'];
																								
																								$exist_img = ( $counter == 1 ) ? "thumbnail2" : "thumbnail";
																								if( file_exists($abpath_temp_unlink) && !is_dir($abpath_temp_unlink) )
																								{
																									$content = ( $dataImg['content'] != "" ) ? "title='".nl2br(htmlspecialchars(stripslashes($dataImg['content'])))."'" : "";
																									echo "<a href=\"".HTTP_PATH."/gallery/L".$dataImg['img']."\"  rel=\"fancy_image\" ".$content." ><img src=\"".HTTP_PATH."/gallery/".$dataImg['img']."\" rel=\"lightbox\" border=\"0\"></a>";
																								}
																							echo "</div>";
																					
																					$counter++;
																					
																					//if( $counter%4 == 0 )
																						//echo "</tr><tr><td colspan=10 height=15></td></tr>";
																					//else
																						//echo "<td width=15></td>";
																						
																				}
																				
																			}
																			
																		echo "</div>";
																		
																		
																		
																		
																	echo "</td>";
																echo "</tr>";
																echo "<tr><td height=7></td></tr>";
																}
															break;
															
															case "4" :
																if( $dataParagraph['p_text'] == "1" )
																{
																	echo "<tr><td height=7></td></tr>";
																	echo "<tr>";
																		echo "<td align=center>";
																			contact("1");
																		echo "</td>";
																	echo "</tr>";
																	echo "<tr><td height=7></td></tr>";
																}
																elseif( $dataParagraph['p_text'] == "2" )
																{
																	echo "<tr><td height=7></td></tr>";
																	echo "<tr>";
																		echo "<td align=center>";
																			echo "<table border='0' cellpadding='0' cellspacing='0' class='maintext' width=100%>";
																				
																			
																			$sql = "SELECT mailing_id,content FROM content_pages WHERE id = '".$dataLDSetting['mailignList_contentPageID']."' ";
																			$resMailing = mysql_db_query(DB,$sql);
																			$dataMailing = mysql_fetch_array($resMailing);
																			
																			if( $dataMailing['mailing_id'] != "" && $dataMailing['mailing_id'] != "0" )
																			{
																				echo "<tr>";
																					echo "<td valing=top align=right><div class='leftfloat mailing-iframe'>";
																						echo "<iframe src='http://www.ilbiz.co.il/newsite/net_system/netMailing.php?unk=".UNK."&amp;mailing_id=".$dataMailing['mailing_id']."&amp;td=".$dataLDSetting['mailignList_contentPageID']."&mini=1&version=1' width='100%' height='380px' id='loginPage2' frameborder=0 scrolling=no allowtransparency='true'></iframe>";
																					echo "</div>
																					<div class='mailing-content'>".$dataMailing['content']."</div>
																					</td>";
																				echo "</tr>";
																			}
																			echo "</table>";
																		echo "</td>";
																	echo "</tr>";
																	echo "<tr><td height=7></td></tr>";
																}
															break;
															
															case "5" :
																echo "<tr><td height=7></td></tr>";
																echo "<tr>";
																	echo "<td align=center>";
																	
																		put_estimate_form();
																	
																	echo "</td>";
																echo "</tr>";
																echo "<tr><td height=7></td></tr>";
															break;
															
															
															case "6" :
																echo "<tr><td height=20></td></tr>";
																echo "<tr>";
																	echo "<td align=center style='padding-right: 10px;'>";
																		echo "<table border='0' cellpadding='0' cellspacing='0' class='maintext' width=100%>";
																			echo "<tr>";
																				echo "<td>".stripslashes($dataParagraph['p_text'])."</td>";
																			echo "</tr>";
																			echo "<tr><td height=10></td></tr>";
																			echo "<tr>";
																				echo "<td><div style='overflow:hidden;'>";
																					echo '<div style="float:right;"><iframe src="//www.facebook.com/plugins/like.php?href=http%3A%2F%2Fwww.10service.co.il%2Flanding.php%3Fld%3D48&amp;send=false&amp;layout=standard&amp;width=200&amp;show_faces=false&amp;action=like&amp;colorscheme=light&amp;font=tahoma&amp;height=35" scrolling="no" frameborder="0" style="border:none; overflow:hidden; height:35px;" allowTransparency="true"></iframe></div>';
																							
																							echo '<div style="float:right;"><g:plusone size="medium" annotation="inline" width="120" href="http://www.10service.co.il/landing.php?ld=48"></g:plusone></div>';
																						
																				echo "</div></td>";
																			echo "</tr>";
																			
																			$abpath_temp2 = SERVER_PATH."/new_images/landing/".$dataParagraph['contact_bottom_bg'];
																			if( file_exists($abpath_temp2) && !is_dir($abpath_temp2) )
																			{
																				$im_size = GetImageSize ($abpath_temp2); 
																				$imageWidth = $im_size[0]; 
																				$imageHeight = $im_size[1];
																				
																				$contact_bottom_bg = "background:url(".HTTP_PATH."/new_images/landing/".$dataParagraph['contact_bottom_bg'].");";
																			}
																			
																			$_SESSION['user_contact_form'] = "";
	
																			$_SESSION['user_contact_form']['unk'] = "asc".rand(10000,15000);
																			$_SESSION['user_contact_form']['name'] = "ged".rand(15000,20000);
																			$_SESSION['user_contact_form']['email'] = "pok".rand(20000,25000);
																			$_SESSION['user_contact_form']['phone'] = "ujk".rand(25000,3000);
																			$_SESSION['user_contact_form']['content'] = "gdv".rand(40000,45000);
																			$_SESSION['user_contact_form']['date_in'] = "cve".rand(45000,50000);
																			
																			$form_text_color = ( $dataParagraph['text_form_color'] != "" ) ? "style='color: #".$dataParagraph['text_form_color'].";'" : "";
																			
																			// contact
																			echo "<tr>";
																				echo "<td>";
																					echo "<div style='".$contact_bottom_bg."'>";
																							echo "<form action='index.php' method='post' name='formC' style='padding: 0px; margin: 0px;'>";
																							echo "<input type='hidden' name='m' value='insert_contact'>";
																							echo "<input type='hidden' name='ext' value='1'>";
																							echo "<input type='hidden' name='".$_SESSION['user_contact_form']['unk']."' value='".UNK."'>";
																							echo "<input type='hidden' name='".$_SESSION['user_contact_form']['date_in']."' value='".GlobalFunctions::get_timestemp()."'>";
																								echo "<div>";
																											echo "<div class='maintext comb-form' ".$form_text_color.">";
																												echo "<div class='form-group'>";
																													echo "<div class='form-title'>שם מלא </div>";
																													echo "<div class='form-input'><input type='text' name='".$_SESSION['user_contact_form']['name']."' class='input_style'></div>";
																												echo "</div>";
																												echo "<div class='form-group'>";
																													echo "<div class='form-title'>שם העסק</div>";
																													echo "<div class='form-input'><input type='text' name='".$_SESSION['user_contact_form']['content']."' class='input_style'></div>";
																												echo "</div>";
																													echo "<div class='form-group'>";
																														echo "<div class='form-title'>דואר אלקטרוני </div>";
																														echo "<div class='form-title'><input type='text' name='".$_SESSION['user_contact_form']['email']."' class='input_style'></div>";
																													echo "</div>";
																												echo "<div class='form-group'>";
																													echo "<div class='form-title'>טלפון</div>";
																													echo "<div class='form-title'><input type='text' name='".$_SESSION['user_contact_form']['phone']."' class='input_style'></div>";
																												echo "</div>";
																											echo "</div>";
																										
												
																											echo "<div class='submit-group'>";
																											$abpath_temp2 = SERVER_PATH."/new_images/landing/".$dataParagraph['contact_submit_botton'];
																											if( file_exists($abpath_temp2) && !is_dir($abpath_temp2) )
																												echo "<input type='image' src='/new_images/landing/".$dataParagraph['contact_submit_botton']."'>";
																											else
																												echo "<input type='submit' value='שליחה' class='submit_style'>";
																											echo "</div>";
																										echo "</div><div style='clear:both;'></div>";
																								echo "</form>";
																							echo "</div>";	
																				echo "</td>";
																			echo "</tr>";
																			
																		echo "</table>";
																	echo "</td>";
																echo "</tr>";
																echo "<tr><td height=7></td></tr>";
																



																
															break;
														}
														
														
													}
													echo "</div>";
												echo "</table>";
												
											echo "</td>";
										echo "</tr>";
									echo "</table>";
									echo $fieldset_end;
								echo "</td>";
								echo "<td width=10  class='td-padder-hor'></td>";
							echo "</tr>";
							echo "<tr><td height=5 colspan=3 class='td-padder-ver'></td></tr>";
							$module_index++;
						}

						if(!$fb_share_ok){ 
							if( $landing_10service != "1")
							{
								put_fb_share();
								$fb_share_ok = true;
							}
						}
					echo "</table>";
				?>
				</div>
			</td>
		</tr>
		<?
		if( $landing_10service != "1" )
		{
		?>
		<tr><td height=10></td></tr>
		<tr>
			<td>
				<?
					echo "<tr>";
						echo "<td height=\"19\" valign=bottom align=\"center\" ".$COLORmenus_color.">";
							bottom_copyright(true);
						echo "</td>";
					echo "</tr>";
				?>
			</td>
		</tr>
		<?
		}
		?>
</table>
<script src="http://ilbiz.co.il/ClientSite/version_1/style/js/negishut.js"></script>
<link rel="stylesheet" type="text/css" media="screen" href="http://ilbiz.co.il/ClientSite/version_1/style/negishut_style.css" />
<div id="negishut_wrap" class="negishut-wrap" style="display:none" >
	<div id="negishut_door">
		<a href="javascript://" onclick="open_negishut_menu()"><span id="negishut_door_text">נגישות</span></a>
	</div>
	<div id="negishut-content">
		<div id="close_negishut_x">
			<a href="javascript://" onclick="open_negishut_menu()">סגור תפריט נגישות</a>
		</div>
		<div id="negishut-content-inner">
			<h4>תפריט נגישות</h4>
			<ul id="negishut_options">
				<li class="negishut-title">גודל פונט</li>
				<li id="negishut_font_bigger" class="negishut-item">
					<a href="javascript://" onclick="negishut_font_bigger()">הגדל פונט</a>
				</li>
				<li id="negishut_font_smaller" class="negishut-item">
					<a href="javascript://" onclick="negishut_font_smaller()">הקטן פונט</a>
				</li>
				<li class="negishut-title">ניגודיות צבעים</li>
				<li id="negishut_contrast_0" class="negishut-item">
					<a href="javascript://" onclick="negishut_contrast(0)">ניגודיות ברירת מחדל</a>
				</li>
				<li id="negishut_contrast_2" class="negishut-item">
					<a href="javascript://" onclick="negishut_contrast(2)">ניגודיות גבוהה</a>
				</li>
				<li id="negishut_contrast_1" class="negishut-item">
					<a href="javascript://" onclick="negishut_contrast(1)">ניגודיות הפוכה</a>
				</li>
				
				<?php /*
				<li class="negishut-title">קיצורי דרך לאזורי תוכן</li>
				<li id="negishut_goto_main" class="negishut-item">
					<a href="javascript://" onclick="negishut_goto('center_main_content')">עבור לאזור תוכן מרכזי</a>
				</li>	
				<li id="negishut_goto_top_menu" class="negishut-item">
					<a href="javascript://" onclick="negishut_goto('page_fixed_top')">עבור לתפריט עליון</a>
				</li>
				<li id="negishut_goto_top_menu" class="negishut-item">
					<a href="javascript://" onclick="negishut_goto('search_form')">עבור לחיפוש</a>
				</li>	
				<li id="negishut_goto_top_menu" class="negishut-item">
					<a href="javascript://" onclick="negishut_goto('right_nav')">עבור לתפריט משני</a>
				</li>				
				*/ ?>
				<li class="negishut-title">הבהובים ותנועה</li>
				<li id="stop_news_marquee" class="negishut-item">
					<a href="javascript://" onclick="stop_news_marquee()">הפסקת הבהובים ותנועה</a>
				</li>	
				<li id="run_news_marquee" class="negishut-item">
					<a href="javascript://" onclick="run_news_marquee()">הפעלת הבהובים ותנועה</a>
				</li>					
			</ul>
		</div>
	</div>
</div>
<?php if($data_extra_settings['negishut_version'] == '1'): ?>
	<script type="text/javascript">
		var negishut_date = new Date();
		negishut_date.setMonth(negishut_date.getMonth() + 12);
		var negishut_domain = "<?php echo $_SERVER['HTTP_HOST']; ?>";
		show_negishut();
	</script>	
<?php endif; ?>
<?php if(isset($tracking_url)): ?>
	<?php if($c_tracking_on): ?>
		<iframe src="<?php echo $tracking_url; ?>" scrolling="no" frameborder="0" width="1" height="1"></iframe>
	<?php endif; ?>
	<p id="tracking_iframe_holder"></p>
	<script type="text/javascript">
		function tracking_form_send(estimateFormId,customer_send){
			<?php if($c_tracking_on): ?>
				var form_tracking_pixel = '<iframe src="<?php echo $form_tracking_url; ?>&estimateFormId='+estimateFormId+'&c_send='+customer_send+'" scrolling="no" frameborder="0" width="1" height="1"></iframe>'; 
				
				var track_holder = document.createElement('span');
				track_holder.innerHTML = form_tracking_pixel;
				var holder_wrap = document.getElementById("tracking_iframe_holder");
				holder_wrap.appendChild(track_holder);
			<?php else: ?>
				return;
			<?php endif; ?>
		} 
		function tracking_phone_landing_send(){
			<?php if($c_tracking_on): ?>
				var phone_tracking_pixel = '<iframe src="<?php echo $tracking_url; ?>&phone_called=1&is_landing=1" scrolling="no" frameborder="0" width="1" height="1"></iframe>'; 
				
				var track_holder = document.createElement('span');
				track_holder.innerHTML = phone_tracking_pixel;
				var holder_wrap = document.getElementById("tracking_iframe_holder");
				holder_wrap.appendChild(track_holder);
			<?php else: ?>
				return;
			<?php endif; ?>
		}
		<?php if($c_tracking_on): ?>
			jQuery(document).ready(function(){
				jQuery('a[href^="tel:"]').click(function(){
					tracking_phone_landing_send();
				});
			});	
		<?php endif; ?>
	</script>
<?php endif; ?>
<?php

/*
		
*/

/*if( $data_extra_settings['have_share_button'] == "1" &&  $m != 'hp' )
							{
								echo "<tr><td colspan=\"3\" height=\"10\"></td></tr>";
								echo "<tr>";
									echo "<td width=\"35\"></td>";
									echo "<td>";
										echo "<table border=\"0\" width=100% cellspacing=\"0\" cellpadding=\"0\" class=\"maintext\">";
											echo "<tr>";
												echo "<td><div style='z-index:-9999;'><fb:like width=300 show_faces=false></fb:like></div></td>";
												
												echo "<td valign=top width=200>";
													echo '
													<script type="text/javascript">
														var addthis_config = {
														    data_track_clickback: true
														}
													</script>
													';
													echo '<!-- AddThis Button BEGIN -->
														<div class="addthis_toolbox addthis_default_style" style="padding-right: 35px;">
														<a href="http://www.addthis.com/bookmark.php?v=250&amp;username=ilbiz" class="addthis_button_compact"><font class="maintext" >'.$word[LANG]['1_2_facebook_share'].'</font></a>
														<span class="addthis_separator">|</span>
														<a class="addthis_button_facebook"></a>
														<a class="addthis_button_twitter"></a>
														</div>
														<script type="text/javascript" src="http://s7.addthis.com/js/250/addthis_widget.js#username=ilbiz"></script>
														<!-- AddThis Button END -->
													';
											
												echo "</td>";
												
												
											echo "</tr>";
										echo "</table>";
									echo "</td>";
									echo "<td width=\"35\"></td>";
								echo "</tr>";
								echo "<tr><td colspan=\"3\" height=\"10\"></td></tr>";
							}*/
							

if( $data_extra_settings['wibiyaAnalytics'] != '' )
	echo str_replace("´","'",stripslashes($data_extra_settings['wibiyaAnalytics']))."<br><br>";

echo str_replace("´","'",stripslashes($data_name['googleAnalytics']));


if( UNK == "759923718705913766" OR UNK == "358388408164915383" )
{
	echo '
<script type="text/javascript">
/* <![CDATA[ */
var google_conversion_id = 1066965683;
var google_conversion_label = "qVFJCMmAjgQQs7Xi_AM";
var google_custom_params = window.google_tag_params;
var google_remarketing_only = true;
/* ]]> */
</script>
<script type="text/javascript" src="//www.googleadservices.com/pagead/conversion.js">
</script>
<noscript>
<div style="display:inline;">
<img height="1" width="1" style="border-style:none;" alt="" src="//googleads.g.doubleclick.net/pagead/viewthroughconversion/1066965683/?value=0&amp;label=qVFJCMmAjgQQs7Xi_AM&amp;guid=ON&amp;script=0"/>
</div>
</noscript>

	';
}
elseif( UNK == "245335157887300654" )
{
	echo '
<script type="text/javascript">
/* <![CDATA[ */
var google_conversion_id = 1066965683;
var google_conversion_label = "fvEdCNnvjQQQs7Xi_AM";
var google_custom_params = window.google_tag_params;
var google_remarketing_only = true;
/* ]]> */
</script>
<script type="text/javascript" src="//www.googleadservices.com/pagead/conversion.js">
</script>
<noscript>
<div style="display:inline;">
<img height="1" width="1" style="border-style:none;" alt="" src="//googleads.g.doubleclick.net/pagead/viewthroughconversion/1066965683/?value=0&amp;label=fvEdCNnvjQQQs7Xi_AM&amp;guid=ON&amp;script=0"/>
</div>
</noscript>

	';
}
elseif( UNK == "285240640927706447" )
{
	echo '
<script type="text/javascript">
/* <![CDATA[ */
var google_conversion_id = 1066965683;
var google_conversion_label = "wfdGCNHwjQQQs7Xi_AM";
var google_custom_params = window.google_tag_params;
var google_remarketing_only = true;
/* ]]> */
</script>
<script type="text/javascript" src="//www.googleadservices.com/pagead/conversion.js">
</script>
<noscript>
<div style="display:inline;">
<img height="1" width="1" style="border-style:none;" alt="" src="//googleads.g.doubleclick.net/pagead/viewthroughconversion/1066965683/?value=0&amp;label=wfdGCNHwjQQQs7Xi_AM&amp;guid=ON&amp;script=0"/>
</div>
</noscript>

	';
}
elseif( $data_extra_settings['remartiking_code'] != "" )
{
	echo str_replace("´","'",$data_extra_settings['remartiking_code']);
}

if( $data_extra_settings['BottomSliceHtml_landing'] != "" )
{
	echo str_replace("´","'",$data_extra_settings['BottomSliceHtml_landing']);
}
if( $data_extra_settings['zopim_script'] != "" )
{
	//echo str_replace("´","'",stripslashes($data_extra_settings['zopim_script']));
}
	

$sekindo1='0';
switch(UNK)
{
	case "998572324522175458":
	case "806700060391385236":
	case "863507235772108991":
	case "453047531107772083":
	case "161819904213378395":
	case "674784706256987419":
	case "607189207778116683":
	case "888527842412378264":
	case "894455971451717470":
	case "981305223833034141":
	case "784813852097425732":
	case "884042897551598761":
	case "566370582577372512":
	case "889435032031026488":
	case "845834687015254796":
	case "431951038801412517":
	case "003786467652476885":
	case "756693714750704940":
	case "620834264020691407":
	case "440509196461302753":
	case "932937850555019039":
	case "148269631088418367":
	case "706535061133650131":
	case "892416832482956591":
	case "192202924562351192":
	case "331926734886262086":
	case "296346376975876771":
	case "743246710596867492":
	case "424017667314921710":
	case "323722913024005666":
	case "889998787805174082":
	case "673299712092708101":
	case "307685272649486478":
	case "694032551610774879":
	case "196962797940220635":
	case "815989195030807826":
	case "461133119091439884":
	case "870559879246111138":
	case "400924802215918261":
	case "286024565601128888":
	case "577342662741077724":
	case "356346773816936457":
	case "321378956719164777":
	case "154774081706992664":
	case "579483507553497240":
	case "062981130998652729":
	case "551313898565034638":
	//שירות 10, ראשי
	//MY SAVE
	//12free
	//Greenprice
		//echo "<script>site_width = 800;</script>";
		//echo "<script type=\"text/javascript\" src=\"http://www.ilbiz.co.il/newsite/net_system/adsense_side.js\"></script>";
	break;
}

if( $_GET['ld'] == '207' )
{
	echo "<script>site_width = 800;</script>";
	echo "<script type=\"text/javascript\" src=\"rvg_side.js\"></script>";
}


echo "</body>";
echo "</html>";

$full_content = ob_get_clean();
$full_content = str_replace("http://",HTTP_S."://",$full_content);
echo $full_content;
function put_fb_share(){
	
		echo "<tr><td height=5 colspan=3 class='td-padder-ver'></td></tr>";
		echo "<tr>";
		echo "<td width=10 class='td-padder-hor'></td><td>";
		?>
			
			<div id="fb_share">
				<?
				
				
				echo '<div style=\'z-index:-9999;\'><iframe src="//www.facebook.com/plugins/like.php?href=http://'.$_SERVER[SERVER_NAME].$_SERVER[REQUEST_URI].'&amp;send=false&amp;layout=standard&amp;width=450&amp;show_faces=false&amp;action=like&amp;colorscheme=light&amp;font&amp;height=35" scrolling="no" frameborder="0" style="border:none; overflow:hidden; height:35px;" allowTransparency="true"></iframe></div>';
						
							echo '
							<script type="text/javascript">
								var addthis_config = {
									data_track_clickback: true
								}
							</script>';
							

				?>
			</div>
		
		<?
		echo "</td><td width=10 class='td-padder-hor'></td>";
		echo "<tr><td height=5 colspan=3 class='td-padder-ver'></td></tr>";
	echo "</tr>";
}

function put_estimate_form(){
	global $dataLDSetting;
	ob_start();
	$estimate_form_data = estimate_form_html($dataLDSetting['mailignList_contentPageID'] , "1");
	$estimate_form_state = $estimate_form_data['form_on'];
	$estimate_form_print =  ob_get_clean();		
	echo "<div class='leftfloat landing-estimate-form'>";
		echo $estimate_form_print;
	echo "</div>";	
	echo "<div class='estimate-form-text'>";
		echo estimate_site_main_block($dataLDSetting['mailignList_contentPageID'] , "1");
	echo "</div>";	
		//estimate_site_main_block	
}


function put_logo(){
	global $dataLDSetting;
			
	$abpath_temp1 = SERVER_PATH."/new_images/landing/".$dataLDSetting['topslice_logo'];
	if( file_exists($abpath_temp1) && !is_dir($abpath_temp1) )
	{
		?>
				<div class="">
					<img src= "<?php echo HTTP_PATH."/new_images/landing/".$dataLDSetting['topslice_logo']; ?>" title="<?php echo $addMoreTitle; ?>" alt="<?php echo $addMoreTitle; ?>" />
				</div>
	<?php
	}
				
}