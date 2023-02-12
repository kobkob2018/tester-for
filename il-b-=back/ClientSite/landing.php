<?php
/* 
* Copyright © 2010 ILbiz. All Rights Reserved
* email:	webmaster@ilbiz.co.il
*
* 
* the landing of the client site
*/

//http://il.php.net/manual/en/ref.errorfunc.php#errorfunc.constants.errorlevels.e-warning

//block specific ip
$userIp = $_SERVER['REMOTE_ADDR'];
$ips_blocked = array(
	'93.173.241.32','62.128.52.102','188.143.232.14','188.143.232.19',
	'188.143.232.13','188.143.232.37'
);
if(in_array($userIp,$ips_blocked)){
	exit("oops... Ist's not you, its us!!! Please try again later.");
}

error_reporting( 0 );

ob_start();

session_start();
if(isset($_GET['clearses'])){
	foreach($_SESSION as $key=>$val){
		echo "ld-".$key.",";
		if($_GET['clearses'] == '1'){
			unset($_SESSION[$key]);
		}
	}
	exit("session is clear");
}
if(isset($_SESSION['gl_source'])){
	if($_SESSION['gl_source']['gclid'] == "kobibodek"){
		//exit("kobibodek");
	}
	$gl_source = $_SESSION['gl_source'];
}
else{
	$gl_source = array(
		'entry_row'=>'0',
		'gclid'=>'0',
		'sites_page_id'=>'0',
		'has_gclid'=>'0',
		'is_mobile'=>'0',
	);
}
if(isset($_GET['gclid'])){
	if($_GET['gclid'] != $gl_source['gclid']){
		$gl_source['gclid'] = $_GET['gclid'];
		$gl_source['has_gclid'] = '1';
		$gl_source['entry_row'] = '0';
	}
}
if(isset($_GET['fblid'])){
	if($_GET['fblid'] != $gl_source['gclid']){
		$gl_source['gclid'] = $_GET['fblid'];
		$gl_source['has_gclid'] = '2';
		$gl_source['entry_row'] = '0';
	}
}
if($browser_is_mobile){
	$gl_source['is_mobile'] = '1';
}
if (strpos($_SERVER['HTTP_USER_AGENT'],'WhatsApp') === false){
	header('Content-Type: text/html; charset=windows-1255');  
}
require_once('/home/ilan123/domains/ilbiz.co.il/public_html/global_func/vars.php');


$abpath_unk_def = $_SERVER['DOCUMENT_ROOT']."/unk_def.php";
if( file_exists($abpath_unk_def) && !is_dir($abpath_unk_def) )
{
	require_once($abpath_unk_def);
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

$sql = "select * from user_extra_settings where unk = '".UNK."'";
$res_extra_settings = mysql_db_query(DB,$sql);
$data_extra_settings = mysql_fetch_array($res_extra_settings);

	if($data_extra_settings['products_version']== '1'){
		require_once("version_1/functions/modules/header_functions.php");		
		
		if( isset($_GET['testing']) && $_GET['testing'] == "212" )
			require_once('version_1/functions/version_1_landing_testing.php'); 
		else
			require_once('version_1/functions/version_1_landing.php'); 
			
		$full_content = ob_get_clean();
		$full_content = str_replace("http://",HTTP_S."://",$full_content);
		echo $full_content;			
		exit();
		
	}
if( $from_fomain == 1 )
{
	$sql = "select domain from users where unk = '".UNK."' and deleted = '0'";
	$res_domain = mysql_db_query(DB,$sql);
	$data_domain = mysql_fetch_array($res_domain);
	
	define('HTTP_PATH',"http://".$data_domain['domain']);
	define('SERVER_PATH',"/home/ilan123/domains/".$data_domain['domain']."/public_html");
	
	$http_path = "http://".$data_domain['domain'];
	$server_path = "/home/ilan123/domains/".$data_domain['domain']."/public_html";
}
else
{
	define('HTTP_PATH',"http://www.ilbiz.co.il/ClientSite");
	define('SERVER_PATH',"/home/ilan123/domains/ilbiz.co.il/public_html/ClientSite");
	
	$http_path = "http://www.ilbiz.co.il/ClientSite";
	$server_path = "/home/ilan123/domains/ilbiz.co.il/public_html/ClientSite";
}

define('LANG',"he");
// class
require_once("/home/ilan123/domains/ilbiz.co.il/public_html/global_func/DB.php");
require_once("/home/ilan123/domains/ilbiz.co.il/public_html/global_func/global_functions.php");
require_once("/home/ilan123/domains/ilbiz.co.il/public_html/global_func/forms_creator.php");
require_once('/home/ilan123/domains/ilbiz.co.il/public_html/lang/lang.he.php');
require_once('strac_func.php');
require_once('functions.php');
require_once('client_castum_functions.php');
require_once("/home/ilan123/domains/ilbiz.co.il/public_html/ClientSite/functions_12.php");

// for settigns about the colors
$sql = "select * from user_site_settings where unk = '".UNK."' and deleted = '0' and status = '0'";
$res_settings = mysql_db_query(DB,$sql);
$data_settings = mysql_fetch_array($res_settings);



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

$tracking_arr = get_tracking_url_for_landing($dataLDSetting,$gl_source);
$tracking_url = $tracking_arr['page'];
$form_tracking_url = $tracking_arr['form'];
$tracking_id = $tracking_arr['tracking_id'];
	if( $dataLDSetting['goto_url_301'] != "" )
	{
		header( "HTTP/1.1 301 Moved Permanently" );
		$redirect_url = iconv("windows-1255","UTF-8", $dataLDSetting['goto_url_301']);
		header( "location: ".stripslashes($redirect_url)."" );  
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


	
		echo '<title>'.$addMoreTitle.'</title>';
		
		$keywords = str_replace("\"" , "" , stripslashes($data_settings['keywords']) );
		$description = str_replace("\"" , "" , stripslashes($data_settings['description']) );
	
	if( $description != "" )
		echo '<META NAME="DESCRIPTION" CONTENT="'.$description.'">';
	
	if( $keywords != "" )
		echo '<META NAME="KEYWORDS" CONTENT="'.$keywords.'">';


echo '<link rel="stylesheet" type="text/css" media="screen" href="http://ilbiz.co.il/ClientSite/landing_style2.php?unk='.UNK.'&ld='.$dataLDSetting['id'].'">';
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

<script type="text/javascript" src="http://www.ilbiz.co.il/global_func/prototype.js"></script>
<script type="text/javascript" src="http://www.ilbiz.co.il/ClientSite/js/ajax.js"></script>
<script type="text/javascript" src="http://www.ilbiz.co.il/ClientSite/js/scriptaculous.js?load=effects,builder"></script>
<script type="text/javascript" src="http://www.ilbiz.co.il/ClientSite/js/lightbox.php?lang=he"></script>
<link rel="stylesheet" href="http://www.ilbiz.co.il/ClientSite/js/lightbox_css.php?lang=he" type="text/css" media="screen">

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

<?
$bgcolor = ( UNK != "091575332773384992" && $_GET['ld'] != '251' ) ? "bgcolor='#ffffff'" : "";
$body = ( $landing_10service != "1" ) ? "width='775' ".$bgcolor : "width=950 style='padding-right: 20px;'";
?>
<table cellpadding=0 cellspacing=0 border=0 align=center <?=$body;?>  dir=rtl>
		
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
											echo "<td style='color: #".$dataLinks['link_color']."; ".$link_size." text-decoration:none;'>".$a_start.stripslashes($dataLinks['link_name']).$a_end."</td>";
											echo "<td width=20></td>";
										}
									?>
								</tr>
							</table>
						</div>
					</div>
				</div>
			</td>
		</tr>
		
		<tr><td height=10 <?php echo $text_area_bg; ?>></td></tr>
		
		<?
		if( $landing_10service != "1" )
		{
		?>
		<tr>
			<td <?php echo $text_area_bg; ?>>
				<?
				
				
				echo "<table border=\"0\" width=100% cellspacing=\"0\" cellpadding=\"0\" class=\"maintext\">";
					echo "<tr>";
						echo '<td style="padding-left:7px; padding-right: 7px;"><div style=\'z-index:-9999;\'><iframe src="//www.facebook.com/plugins/like.php?href=http://'.$_SERVER[SERVER_NAME].$_SERVER[REQUEST_URI].'&amp;send=false&amp;layout=standard&amp;width=450&amp;show_faces=false&amp;action=like&amp;colorscheme=light&amp;font&amp;height=35" scrolling="no" frameborder="0" style="border:none; overflow:hidden; width:450px; height:35px;" allowTransparency="true"></iframe></td>';
						
						echo "<td valign=top width=200>";
							echo '
							<script type="text/javascript">
								var addthis_config = {
								    data_track_clickback: true
								}
							</script>';
							
							/*echo '<!-- AddThis Button BEGIN -->
								<div class="addthis_toolbox addthis_default_style" style="padding-right: 35px;">
								<a href="http://www.addthis.com/bookmark.php?v=250&amp;username=ilbiz" class="addthis_button_compact"><font class="landing_link" >שתף</font></a>
								<span class="addthis_separator">|</span>
								<a class="addthis_button_facebook"></a>
								<a class="addthis_button_twitter"></a>
								</div>
								<script type="text/javascript" src="http://s7.addthis.com/js/250/addthis_widget.js#username=ilbiz"></script>
								<!-- AddThis Button END -->
							';*/
					
						echo "</td>";
						echo "<td width=10></td>";
						//echo "<td valign=top><g:plusone size='medium'></g:plusone></td>";
						
					echo "</tr>";
				echo "</table>";
				?>
			</td>
		</tr>
		<tr><td height=10 <?php echo $text_area_bg; ?>></td></tr>
		<?
		}
		else
			echo "<tr><td height=10></td></tr>";
		?>
		<tr>
			<td align=right <?php echo $text_area_bg; ?>>
				<div id="landingContent">
				<?
					$sql = "SELECT * FROM sites_landingPage_modules WHERE unk = '".UNK."' AND landing_id = '".$dataLDSetting['id']."' AND deleted=0 ORDER BY place , id";
					$resModules = mysql_db_query(DB,$sql);
					
					echo "<table border=\"0\" width=100% cellspacing=\"0\" cellpadding=\"0\" class=\"maintext\">";
					
						while( $dataModules = mysql_fetch_array($resModules) )
						{
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
							
							echo "<tr><td height=5 colspan=3></td></tr>";
							echo "<tr>";
								echo "<td width=10></td>";
								echo "<td ".$bgColor.$style." align=right ".$padding_headline." >";
									echo $fieldset_start.$visibility_hidden_start.$titeIcon.$visibility_hidden_end."<span style='".$headline_style."'><b>".$visibility_hidden_start.stripslashes($dataModules['module_title']).$visibility_hidden_end."</b>".$hide_module_text."</span>".$legend_end;
									echo "<table border=\"0\" width=100% cellspacing=\"0\" cellpadding=\"0\" class=\"maintext\" ".$hide_module." id='open_mu_".$dataModules['id']."'>";
										echo "<tr>";
											echo "<td>";
												
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
																echo "<tr><td height=7></td></tr>";
																echo "<tr>";
																	echo "<td>";
																		echo "<table border=\"0\" width=100% cellspacing=\"0\" cellpadding=\"0\" class=\"maintext\">";
																			
																			echo "<tr>";
																				echo "<td valign=top>";
																					echo "<table border=\"0\" width=350 cellspacing=\"0\" cellpadding=\"0\" class=\"maintext\">";
																						echo "<tr>";
																							echo "<td><div id='playing_video' style='border: 1px solid #".$dataModules['title_color'].";'><script>videoL(\"".$vidValue[0]."\")</script></div></td>";
																						echo "</tr>";
																						echo "<tr><td height=10></td></tr>";
																						echo "<tr>";
																							echo "<td align=center><a href='index.php?m=vi' class='landing_link'>צפה בהכל</a></td>";
																						echo "</tr>";
																						
																					echo "</table>";
																				echo "</td>";
																				echo "<td width=20></td>";
																				echo "<td valign=top>";
																					echo "<table border=\"0\" width=350 cellspacing=\"0\" cellpadding=\"0\" class=\"maintext\">";
																						
																						for( $vid=0 ; $vid<=3 ; $vid++ )
																						{
																							if( $vidValue[$vid] != "" )
																							{
																								$sql = "SELECT id, name, img, summary FROM user_video WHERE unk = '".UNK."' AND deleted=0 AND id = '".$vidValue[$vid]."' ";
																								$resVid = mysql_db_query(DB,$sql);
																								$dataVid = mysql_fetch_array($resVid);
																								
																								$abpath_temp = SERVER_PATH."/video/".$dataVid['img'];
																								
																								echo "<tr>";
																									echo "<td valign=top>";
																										if( file_exists($abpath_temp) && !is_dir($abpath_temp) )
																											echo "<img src='video/".$dataVid['img']."' border='0' width=\"85\" style='border: 1px solid #".$dataModules['title_color'].";'>";
																									echo "</td>";
																									
																									echo "<td width=20></td>";
																									
																									echo "<td valign=top height=100%>";
																										echo "<table border=\"0\" width=250 height=100% cellspacing=\"0\" cellpadding=\"0\" class='landing_text'>";
																											echo "<tr>";
																												echo "<td style='color: #".$dataModules['title_color']."; font-size: 14px;'>".stripslashes($dataVid['name'])."</td>";
																											echo "</tr>";
																											echo "<tr>";
																												echo "<td>".global_strrrchr(stripslashes($dataVid['summary']) , "100")."</td>";
																											echo "</tr>";
																											echo "<tr>";
																												echo "<td align=left class='landing_link'><a href='javascript:void(0)' onclick='videoL(\"".$dataVid['id']."\")' class='landing_link'>צפה</a></td>";
																											echo "</tr>";
																										echo "</table>";
																									echo "</td>";
																									
																								echo "</tr>";
																								echo "<tr><td height=10></td></tr>";
																							}
																						}
																						
																					echo "</table>";
																				echo "</td>";
																			echo "</tr>";
																			
																		echo "</table>";
																	echo "</td>";
																echo "</tr>";
																echo "<tr><td height=7></td></tr>";
																}
															break;
															
															case "2" :
																if( $dataParagraph['p_text'] != "" )
																{
																	echo "<tr><td height=7></td></tr>";
																	echo "<tr>";
																		echo "<td><div id='playing_video2' style='border: 1px solid #".$dataModules['title_color'].";'><script>videoML(\"".$dataParagraph['p_text']."\")</script></div></td>";
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
																		echo "<table border='0' cellpadding='0' cellspacing='0' class='maintext'>";
																		
																			$counter = 0;
																			for( $img=0 ; $img<=8 ; $img++ )
																			{
																				if( $imgValue[$img] != "" )
																				{
																					$sql = "select * from user_gallery_images where unk = '".UNK."' and deleted = '0' AND id = '".$imgValue[$img]."' ";
																					$resImg = mysql_db_query(DB,$sql);
																					$dataImg = mysql_fetch_array($resImg);
																					
																					if( $counter%4 == 0 )
																						echo "<tr>";
																						
																							echo "<td valign=middle align=center style='border: 1px solid #9D9D9D; background-color: #eeeeee; padding: 3px; margin: 3px;'>";
																							
																								$abpath_temp_unlink = SERVER_PATH."/gallery/".$dataImg['img'];
																								$abpath_temp_unlinkl = SERVER_PATH."/gallery/L".$dataImg['img'];
																								
																								$exist_img = ( $counter == 1 ) ? "thumbnail2" : "thumbnail";
																								if( file_exists($abpath_temp_unlink) && !is_dir($abpath_temp_unlink) )
																								{
																									$content = ( $dataImg['content'] != "" ) ? "title='".nl2br(htmlspecialchars(stripslashes($dataImg['content'])))."'" : "";
																									echo "<a href=\"".HTTP_PATH."/gallery/L".$dataImg['img']."\" rel=\"lightbox[page".$L."]\" ".$content." ><img src=\"".HTTP_PATH."/gallery/".$dataImg['img']."\" rel=\"lightbox\" border=\"0\"></a>";
																								}
																							echo "</td>";
																					
																					$counter++;
																					
																					if( $counter%4 == 0 )
																						echo "</tr><tr><td colspan=10 height=15></td></tr>";
																					else
																						echo "<td width=15></td>";
																						
																				}
																				
																			}
																			
																		echo "</table>";
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
																				
																			
																			$sql = "SELECT mailing_id FROM content_pages WHERE id = '".$dataLDSetting['mailignList_contentPageID']."' ";
																			$resMailing = mysql_db_query(DB,$sql);
																			$dataMailing = mysql_fetch_array($resMailing);
																			
																			if( $dataMailing['mailing_id'] != "" && $dataMailing['mailing_id'] != "0" )
																			{
																				echo "<tr>";
																					echo "<td valing=top align=right>";
																						echo "<iframe src='http://www.ilbiz.co.il/newsite/net_system/netMailing.php?unk=".UNK."&amp;mailing_id=".$dataMailing['mailing_id']."&amp;td=".$dataLDSetting['mailignList_contentPageID']."&mini=1' width='600' height='200' id='loginPage2' frameborder=0 scrolling=no allowtransparency='true'></iframe>";
																					echo "</td>";
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
																		echo estimate_site_main_block($dataLDSetting['mailignList_contentPageID'] , "1");
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
																				echo "<td>";
																					echo "<table border=\"0\" cellspacing=\"0\" cellpadding=\"0\" class=\"maintext\">";
																						echo "<tr>";
																							echo '<td style="padding-left:7px; padding-right: 7px;"><iframe src="//www.facebook.com/plugins/like.php?href=http%3A%2F%2Fwww.10service.co.il%2Flanding.php%3Fld%3D48&amp;send=false&amp;layout=standard&amp;width=200&amp;show_faces=false&amp;action=like&amp;colorscheme=light&amp;font=tahoma&amp;height=35" scrolling="no" frameborder="0" style="border:none; overflow:hidden; width:200px; height:35px;" allowTransparency="true"></iframe></td>';
																							echo "<td width=10></td>";
																							echo '<td valign=top><g:plusone size="medium" annotation="inline" width="120" href="http://www.10service.co.il/landing.php?ld=48"></g:plusone></td>';
																						echo "</tr>";
																					echo "</table>";
																				echo "</td>";
																			echo "</tr>";
																			
																			$abpath_temp2 = SERVER_PATH."/new_images/landing/".$dataParagraph['contact_bottom_bg'];
																			if( file_exists($abpath_temp2) && !is_dir($abpath_temp2) )
																			{
																				$im_size = GetImageSize ($abpath_temp2); 
																				$imageWidth = $im_size[0]; 
																				$imageHeight = $im_size[1];
																				
																				$contact_bottom_bg = "background=\"".HTTP_PATH."/new_images/landing/".$dataParagraph['contact_bottom_bg']."\" width=\"".$imageWidth."\" height=\"".$imageHeight."\"";
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
																				echo "<td ".$contact_bottom_bg." width=\"".$imageWidth."\" height=\"".$imageHeight."\" align=center>";
																					echo "<table border='0' cellpadding='0' cellspacing='0' class='maintext' width=\"".$imageWidth."\" height=\"".$imageHeight."\">";
																						echo "<tr>";
																							echo "<td align=center>";
																							echo "<form action='index.php' method='post' name='formC' style='padding: 0px; margin: 0px;'>";
																							echo "<input type='hidden' name='m' value='insert_contact'>";
																							echo "<input type='hidden' name='ext' value='1'>";
																							echo "<input type='hidden' name='".$_SESSION['user_contact_form']['unk']."' value='".UNK."'>";
																							echo "<input type='hidden' name='".$_SESSION['user_contact_form']['date_in']."' value='".GlobalFunctions::get_timestemp()."'>";
																								echo "<table border='0' cellpadding='0' cellspacing='0' class='maintext'>";
																									echo "<tr>";
																										echo "<td>";
																											echo "<table border='0' cellpadding='0' cellspacing='0' class='maintext' ".$form_text_color.">";
																												echo "<tr>";
																													echo "<td width=30></td>";
																													echo "<td>שם מלא </td>";
																													echo "<td width=10></td>";
																													echo "<td><input type='text' name='".$_SESSION['user_contact_form']['name']."' class='input_style' style='width: 150px;'></td>";
																													echo "<td width=30></td>";
																													echo "<td>שם העסק</td>";
																													echo "<td width=10></td>";
																													echo "<td><input type='text' name='".$_SESSION['user_contact_form']['content']."' class='input_style' style='width: 150px;'></td>";
																												echo "</tr>";
																												echo "<tr><td height=7 colspan=8></td></tr>";
																												echo "<tr>";
																													echo "<td width=30></td>";
																													echo "<td>דואר אלקטרוני </td>";
																													echo "<td width=10></td>";
																													echo "<td><input type='text' name='".$_SESSION['user_contact_form']['email']."' class='input_style' style='width: 150px;'></td>";
																													echo "<td width=30></td>";
																													echo "<td>טלפון</td>";
																													echo "<td width=10></td>";
																													echo "<td><input type='text' name='".$_SESSION['user_contact_form']['phone']."' class='input_style' style='width: 150px;'></td>";
																												echo "</tr>";
																											echo "</table>";
																										echo "</td>";
																										echo "<td width=30></td>";
																										echo "<td align=right width=200>";
																											$abpath_temp2 = SERVER_PATH."/new_images/landing/".$dataParagraph['contact_submit_botton'];
																											if( file_exists($abpath_temp2) && !is_dir($abpath_temp2) )
																												echo "<input type='image' src='/new_images/landing/".$dataParagraph['contact_submit_botton']."'>";
																											else
																												echo "<input type='submit' value='שליחה' class='submit_style'>";
																										echo "</td>";
																									echo "</tr>";
																								echo "</table>";
																								echo "</form>";
																							echo "</td>";
																					echo "</tr>";
																				echo "</table>";	
																				echo "</td>";
																			echo "</tr>";
																			
																		echo "</table>";
																	echo "</td>";
																echo "</tr>";
																echo "<tr><td height=7></td></tr>";
															break;
														}
														
														
													}
													
												echo "</table>";
												
											echo "</td>";
										echo "</tr>";
									echo "</table>";
									echo $fieldset_end;
								echo "</td>";
								echo "<td width=10></td>";
							echo "</tr>";
							echo "<tr><td height=5 colspan=3></td></tr>";
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
<?php if(isset($tracking_url)): ?>
	<iframe src="<?php echo $tracking_url; ?>" scrolling="no" frameborder="0" width="1" height="1"></iframe>
	<p id="tracking_iframe_holder"></p>
	<script type="text/javascript">
		function tracking_form_send(estimateFormId,customer_send){
			var form_tracking_pixel = '<iframe src="<?php echo $form_tracking_url; ?>&estimateFormId='+estimateFormId+'&c_send='+customer_send+'" scrolling="no" frameborder="0" width="1" height="1"></iframe>'; 
			
			var track_holder = document.createElement('span');
			track_holder.innerHTML = form_tracking_pixel;
			var holder_wrap = document.getElementById("tracking_iframe_holder");
			holder_wrap.appendChild(track_holder);
		}
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


	if( $data_extra_settings['zopim_script'] != "" )
	{
		echo str_replace("´","'",stripslashes($data_extra_settings['zopim_script']));
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
		echo "<script>site_width = 800;</script>";
		echo "<script type=\"text/javascript\" src=\"http://www.ilbiz.co.il/newsite/net_system/adsense_side.js\"></script>";
	break;
}

if( $_GET['ld'] == '207' )
{
	echo "<script>site_width = 800;</script>";
	echo "<script type=\"text/javascript\" src=\"rvg_side.js\"></script>";
}


echo "</body>";
echo "</html>";


