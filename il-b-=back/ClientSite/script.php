<?
if(isset($_GET['version'])){
	include($_GET['version'].'/script.php');
	die;
}


ob_start("ob_gzhandler");

header("Content-type: application/x-javascript; charset=windows-1255");

require_once('/home/ilan123/domains/ilbiz.co.il/public_html/global_func/vars.php');
require_once('strac_func.php');

$abpath_unk_def = $_SERVER['DOCUMENT_ROOT']."/unk_def.php";
if( file_exists($abpath_unk_def) && !is_dir($abpath_unk_def) )
{
	require_once($abpath_unk_def);
	define('UNK',DEFINE_UNK);
	$from_fomain = 1;
}

if( UNK == "" )
	die("");
	
	$sql = "select * from users where unk = '".UNK."' and deleted = '0' and status = '0'";
	$res_name = mysql_db_query(DB,$sql);
	$data_name = mysql_fetch_array($res_name);
	
	$sql = "select * from user_extra_settings where unk = '".UNK."'";
	$res_extra_settings = mysql_db_query(DB,$sql);
	$data_extra_settings = mysql_fetch_array($res_extra_settings);
	
	$sql = "select * from user_words where unk = '".UNK."'";
	$res_words = mysql_db_query(DB,$sql);
	$data_words = mysql_fetch_array($res_words);
	
	switch( $data_words['coin_type'] )
	{
		case "0" :			$coin_type = "₪";					break;
		case "1" :			$coin_type = "$";									break;
		case "2" :			$coin_type = "&euro;";						break;
	}
	define('COIN',$coin_type);

$sql_lang = "select * from site_langs where id = '".ifint($data_UserLang['lang_id'])."'";
$res_lang = mysql_db_query(DB,$sql_lang);
$data_lang = mysql_fetch_array($res_lang);



if( !empty($data_lang['lang']) )
{
	define('LANG',$data_lang['lang']);
	$lang_page_name = $data_lang['lang'];
	
	// LANG settings
	//$site_charset = $data_lang['charset'];
	
	$site_charset = "windows-1255";
	$settings['dir'] = $data_lang['dir'];
	$settings['re_dir'] = $data_lang['re_dir'];
	$settings['align'] = $data_lang['align'];
	$settings['re_align'] = $data_lang['re_align'];
}
else
{
	define('LANG',"he");
	$lang_page_name = "he";
	
	// LANG settings
	//$site_charset = $data_lang['charset'];
	$site_charset = "windows-1255";
	$settings['dir'] = "rtl";
	$settings['re_dir'] = "ltr";
	$settings['align'] = "right";
	$settings['re_align'] = "left";
}

require_once('/home/ilan123/domains/ilbiz.co.il/public_html/lang/lang.'.$lang_page_name.'.php');
	
	
$str;
if( $_GET['m'] == "zoom_gallery" )
{
	$str .= '
		function setColorBox(){
			/*Init colorbox on thumbnails
			Please note the callback: jQuery.fn.axZm(); that have to be 
			trigered after each load of colorbox or a differen "lightbox" implementation 
			*/
			jQuery(".thumbDemoLink").unbind().colorbox({
				initialWidth: 300,
				initialHeight: 300,
				scrolling: false,
				scrollbars: false,
				opacity: 0.95,
				preloadIMG: false,
				preloading: false
			}, function(){
				jQuery.fn.axZm();
				// Needs this var only for demo with changing dirs...
				jQuery.zoomLightbox =  "colorbox";
			});
		}
		
		function setFancyBox(){
			jQuery(".thumbDemoLink").unbind().fancybox({
				padding				: 0,
				overlayShow			: true,
				overlayOpacity		: 0.6,
				zoomSpeedIn			: 0,
				zoomSpeedOut		: 100,
				easingIn			: "swing",
				easingOut			: "swing",
				hideOnContentClick	: false, // Important
				centerOnScroll		: false,
				imageScale			: true,
				autoDimensions		: true,
				callbackOnShow		: function(){
					jQuery.fn.axZm();						
					// Needs this var only for demo with changing dirs...
					jQuery.zoomLightbox =  "fancybox";			
				}
			});	
			
		
		}
		
		jQuery(document).ready(function() {
			setFancyBox();
		});';
	}

	$str .= 'function get_word_txt_totalPrice()';
	$str .= '{';
		$str .= 'return "'.$word[LANG]['1_3_ecom_table_total'].'";';
	$str .= '}';
	$str .= 'function get_word_COIN_type()';
	$str .= '{';
		$str .= 'return "'.COIN.'";';
	$str .= '}';
	$str .= 'function ajax_calendar(mons)';
	$str .= '{
		var url = "index.php?aJx=1&aM=calendar&mons="+mons;
		new Ajax.Updater("user_calendar", url, {asynchronous:true});';
	$str .= '}';


if( $data_name['flex_gallery'] == "1" )
{
	switch( $data_name['flex_galleryType'] )
	{
		case "2" :
			$str .=  "
				function loadGallery(params){
					var flashvars = {}
					flashvars.unk = params.unk
					flashvars.url = params.url
					flashvars.cat = params.cat
					
					var attributes = {};
					attributes.id = params.parentName;
					
					swfobject.embedSWF(\"images.swf\", params.parentName, \"600\", \"600\", \"9.0.0\", \"http://www.ilbiz.co.il/ClientSite/other/flash/ver2/expressInstall.swf\", flashvars, {wmode: \"transparent\",allowScriptAccess: \"always\"}, attributes);
				}";
		break;
		
		case "5" :
		case "4" :
			switch(UNK)
			{
				case "235414525040051953" :
				case "438418905102508493" : 	$choosen_swf_name = "shelf.swf";			break;
				
				default:
					$choosen_swf_name = "images.swf";
			}
			$str .= "
				function loadGallery(unk,url,cat,parentName){
					var flashvars = {}
					flashvars.unk = unk
					flashvars.url = url
					flashvars.cat = cat
					
					var attributes = {};
					attributes.id = parentName;
					
					swfobject.embedSWF(\"".$choosen_swf_name."\", parentName, \"600\", \"600\", \"9.0.0\", \"http://www.ilbiz.co.il/ClientSite/other/flash/ver2/expressInstall.swf\", flashvars, {wmode: \"transparent\",allowScriptAccess: \"always\"}, attributes);
				}";
		break;
		
		default :
			$str .= "
				function loadFlexGallery(unk,cat,url,parentName){
					var flashvars = {}
					flashvars.unk = unk
					flashvars.url = url
					flashvars.cat = cat
					
					var attributes = {};
					attributes.id = parentName;
					
					swfobject.embedSWF(\"images.swf\", parentName, \"600\", \"600\", \"9.0.0\", \"http://www.ilbiz.co.il/ClientSite/other/flash/ver2/expressInstall.swf\", flashvars, {wmode: \"transparent\",allowScriptAccess: \"always\"}, attributes);
				}";
	}
}

if( UNK == "932085872939085012" )
{
		$str .= "
				function loadHPnews(unk,url,parentName){
					var flashvars = {}
					flashvars.unk = unk
					flashvars.url = url
					
					var attributes = {};
					attributes.id = parentName;
					
					swfobject.embedSWF(\"/upload_pics/news.swf\", parentName, \"501\", \"315\", \"9.0.0\", \"http://www.ilbiz.co.il/ClientSite/other/flash/ver2/expressInstall.swf\", flashvars, {wmode: \"transparent\",allowScriptAccess: \"always\"}, attributes);
				}";
}

	
	$str .= ' function addIEFavorite() 
		{
		   if (window.external) 
			 {
		      external.AddFavorite(location.href, window.document.title)
		      }
		   else 
			 {
		      alert("Oops, your browser doesn\'t support this feature.\n" +
		      "If you are using Netscape Navigator, click Bookmarks\n" +
		      "and then Add Bookmark to add this site to your favorites.");
		      }
		}';
		
		
		$str .= ' function loadSWFwithBase(swfPath,swfName,swfWidth,swfHeight,swfBgcolor,parentName)
		{
			var flashvars = false; 
			
			if( swfBgcolor.length == 1 )
				var trans = "transparent";
			else
				var trans = "opaque";
			
			var attributes = {};
			attributes.id = parentName;
			
			swfobject.embedSWF(swfPath, swfName, swfWidth, swfHeight, "9.0.0", "http://www.ilbiz.co.il/ClientSite/other/flash/ver2/expressInstall.swf", flashvars, {wmode: trans,bgColor: swfBgcolor,allowScriptAccess: "always"}, attributes);
			
		}';
		
		$str .= ' function added_to_cart()
		{
			return "'.$word[LANG]['1_2_ecom_added_to_cart'].'";
		}';
		
		$str .= ' function AfterAddedToCart()
		{';
			$abpath_temp = SERVER_PATH."/tamplate/".stripslashes($data_extra_settings['cartAddImg']);
			if( file_exists($abpath_temp) && !is_dir($abpath_temp) )	{
				$str .= "return \"<img src='/tamplate/".stripslashes($data_extra_settings['cartAddImg'])."' border=\"0\" alt=\"\" />\"";
			}
			else
			{
				$str .= "return \"".$word[LANG]['1_1_products_add_to_cart']."\"";
			}
		$str .= "}";
		
		
		$str .= ' function product_images(uid , pimg , cunk )
		{
			cunk = cunk || "'.UNK.'";
			var url = "index.php?m=ajax.product_images&unk=" + cunk + "&ud=" + uid + "&pimg=" + pimg;
			new Ajax.Updater("service10ProductImages" , url, {asynchronous:true});
		}';
		
		
		$str .= ' function ajax_estimateSiteRow(cat , tt)
		{
			var url = "ajax.php?main=estimateSiteRow&cat=" + cat + "&t=" + tt;
			new Ajax.Updater("estimateSiteRowDiv" , url, {asynchronous:true});
		}';

	$refer = $_SERVER['HTTP_REFERER'];	
	$str .= 'function ajax_estimateSiteRow_send_data()
	{
	var Fm_name = document.getElementById("Fm_name");
	var Fm_phone = document.getElementById("Fm_phone");
	//var taKn = document.getElementById("taKn");
	
	document.getElementById(\'submitit\').disabled=true;
	
	var str = "";
	var counter = 1;
	
	if(Fm_name.value =="") {
		str += counter++ + ". שם מלא \n";			
	}
	
	if(Fm_phone.value =="") {
		str += counter++ + ". טלפון \n";			
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
		document.getElementById(\'submitit\').disabled=false;
	}
	else
	{
		
		var cat_f = document.getElementById("cat_f").value;
		var cat_s = document.getElementById("cat_s").value;
		var cat_prof = document.getElementById("cat_prof").value;
		var new_sub_cat = document.getElementById("new_sub_cat").value;
		var stat_id = document.getElementById("stat_id").value;
		var Fm_name = document.getElementById("Fm_name").value;
		var Fm_phone = document.getElementById("Fm_phone").value;
		var Fm_email = document.getElementById("Fm_email").value;
		var Fm_city = document.getElementById("Fm_city").value;
		//var taKn = document.getElementById("taKn").value;
		var pageId = document.getElementById("pageId").value;

		
		
		var params = "&cat_f=" + cat_f + "&cat_s=" + cat_s + "&cat_prof=" + cat_prof + "&new_sub_cat=" + new_sub_cat + "&stat_id=" + stat_id + "&Fm_name=" + Fm_name + 
		"&Fm_phone=" + Fm_phone + "&Fm_email=" + Fm_email + "&Fm_city=" + Fm_city + "&pageId=" + pageId + "&func=ajax_estimateSiteRow_send_data&referrer='.$refer.'";
		
		
		var url = "ajax.php?main=estimateSiteInsert" + params ;
		new Ajax.Updater("estimateSiteRowDiv" , url, {evalScripts:true});
	}

}

function ajax_estimateSiteHeight(cat , subCat , cat_spec , pageId)
{
	var url = "ajax.php?main=estimateSiteHeight&cat=" + cat + "&subCat=" + subCat + "&cat_spec=" + cat_spec + "&pageId=" + pageId + "&unk=" + '.UNK.' ;
	new Ajax.Updater("estimateSiteHeightDiv" , url, {asynchronous:true});
}

function ajax_estimateSiteHeight_send_data()
{
	var cat_f = document.getElementById("cat_f").value;
	var cat_s = document.getElementById("cat_s").value;
	
	var Fm_name = document.getElementById("Fm_name");
	var Fm_phone = document.getElementById("Fm_phone");
	var Fm_to_city = document.getElementById("Fm_to_city");
	var Fm_city = document.getElementById("Fm_city");
	var Fm_passengers = document.getElementById("Fm_passengers");
	//var taKn = document.getElementById("taKn");
	
	var str = "";
	var counter = 1;
	
	if(Fm_name.value == "" ) {
		str += counter++ + ". שם מלא \n";			
	}
	
	if(Fm_phone.value =="") {
		str += counter++ + ". טלפון \n";			
	}
	
	
	
	if( cat_f == "31" || cat_s == "31" )
	{
		if(Fm_city.value =="") {
			str += counter++ + ". מעיר \n";			
		}
		
		if(Fm_to_city.value =="") {
			str += counter++ + ". לעיר \n";			
		}
		
		if(Fm_passengers.value =="") {
			str += counter++ + ". מספר נוסעים \n";			
		}
	}
	else
	{
		if(Fm_city.value =="") {
			str += counter++ + ". עיר \n";			
		}
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
		document.getElementById(\'submitit\').disabled=false;
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
		if( cat_f == "31" || cat_s == "31" )
		{
			var Fm_passengers = document.getElementById("Fm_passengers").value;
			var Fm_to_city = document.getElementById("Fm_to_city").value;
		}
		
		if( cat_f == "31" || cat_s == "31" )
		{
			var params = "&cat_f=" + cat_f + "&cat_s=" + cat_s + "&cat_prof=" + cat_prof + "&clientUnk=" + clientUnk + "&stat_id=" + stat_id + "&Fm_name=" + Fm_name + 
				"&Fm_phone=" + Fm_phone + "&Fm_email=" + Fm_email + "&Fm_city=" + Fm_city + "&Fm_to_city=" + Fm_to_city + "&Fm_passengers=" + Fm_passengers + "&Fm_note=" + Fm_note + "&pageId=" + pageId;
		}
		else
		{
			var params = "&cat_f=" + cat_f + "&cat_s=" + cat_s + "&cat_prof=" + cat_prof + "&clientUnk=" + clientUnk + "&stat_id=" + stat_id + "&Fm_name=" + Fm_name + 
			"&Fm_phone=" + Fm_phone + "&Fm_email=" + Fm_email + "&Fm_city=" + Fm_city + "&Fm_note=" + Fm_note + "&pageId=" + pageId+"&func=ajax_estimateSiteRow_send_data&referrer='.$refer.'";
		}
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
	
	function calcHeight()
	{
	  //find the height of the internal page
	  var the_height = document.getElementById(\'net_messages_list\').contentWindow.document.body.scrollHeight;
	
	  //change the height of the iframe
	  document.getElementById(\'net_messages_list\').height=the_height;
	}
	';
	
	$Browser = detectBrowser();
	
	if( $Browser['app.Name'] == "msie" && ( $Browser['app.Ver'] == "6.0" || $Browser['app.Ver'] == "6.1" ) )
	{
		echo "function topMenu_ie6_open_close_tabs( open_tab_id )
		{";
			
			$sql = "select id from user_topMenu_link where unk = '".UNK."' and deleted = '0' and father = '0' order by id";
			$res_topmenu = mysql_db_query(DB,$sql);
			$num_topmenu = mysql_num_rows($res_topmenu);
			
			if( $num_topmenu > 0 )
			{
				while( $data_topmenu = mysql_fetch_array($res_topmenu) )
				{
					$sql_tat = "select id from user_topMenu_link where unk = '".UNK."' and deleted = '0' and father = '".$data_topmenu['id']."'";
					$res_tat = mysql_db_query(DB,$sql_tat);
					$num_TAT = mysql_num_rows($res_tat);
					
					if( $num_TAT > 0 )
						echo 'document.getElementById("topMenu_'.$data_topmenu['id'].'").style.display="none";';
				}
			}
			
			
			echo 'document.getElementById(open_tab_id).style.display="";';
			
			
		echo "}";
	}
	
	
	
echo $str;

?>



function rightbar_login_to_register(){
	document.getElementById('rightbar_login').style.display =  "none";
	document.getElementById('rightbar_register').style.display =  "block";
}

function rightbar_register_to_login(){
	document.getElementById('rightbar_register').style.display =  "none";
	document.getElementById('rightbar_login').style.display =  "block";
}


