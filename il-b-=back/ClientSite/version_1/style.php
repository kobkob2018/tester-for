<?
ob_start("ob_gzhandler");

header("Content-type: text/css; charset=windows-1255");

$http_s = "http";
if(isSecure()){
	$http_s = "https";
}
define('HTTP_S',$http_s);
function isSecure() {
  return
    (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off')
    || $_SERVER['SERVER_PORT'] == 443;
}

require_once('/home/ilan123/domains/ilbiz.co.il/public_html/global_func/vars.php');

$abpath_unk_def = $_SERVER['DOCUMENT_ROOT']."/unk_def.php";
if( file_exists($abpath_unk_def) && !is_dir($abpath_unk_def) )
{
	require($abpath_unk_def);
	define('UNK',DEFINE_UNK);
	$from_fomain = 1;
}

if( UNK == "" )
	die("");

echo "---".UNK."---";
// all color on the page
$sql = "select * from user_colors_set where unk = '".UNK."'";
$res_colors = mysql_db_query(DB,$sql);
$data_colors = mysql_fetch_array($res_colors);

$sql = "select * from users where unk = '".UNK."' and deleted = '0' and status = '0'";
$res_name = mysql_db_query(DB,$sql);
$data_name = mysql_fetch_array($res_name);

$sql = "select * from user_extra_settings where unk = '".UNK."'";
$res_extra_settings = mysql_db_query(DB,$sql);
$data_extra_settings = mysql_fetch_array($res_extra_settings);

if( UNK == "570999819807328184" OR UNK == "463855339088509570" OR UNK == "525482657832046717" OR UNK == "711720925699921333" )
	define('HTTP_PATH',HTTP_S."://www.".$data_name['domain']);
else
	define('HTTP_PATH',HTTP_S."://".$data_name['domain']);
define('SERVER_PATH',"/home/ilan123/domains/".$data_name['domain']."/public_html");

	$right_menu_beckground = "";
	$abpath_temp_flash_right_menu = SERVER_PATH."/tamplate/".stripslashes($data_colors['flash_right_menu']);
	if( file_exists($abpath_temp_flash_right_menu) && !is_dir($abpath_temp_flash_right_menu) )
	{
		$flash_right_menu = "
			<noindex><div id=\"LSflash_right_menu\"></div>
				
				<script type=\"text/javascript\">
					swfPlayer(\"/tamplate/".stripslashes($data_colors['flash_right_menu'])."\",\"flash_right_menu\",\"".stripslashes($data_colors['flash_right_menu_width'])."\",\"".stripslashes($data_colors['flash_right_menu_height'])."\",\"#".stripslashes($data_colors['flash_right_menu_color'])."\",\"LSflash_right_menu\");
				</script></noindex>";
	}
	else
	{
		$abpath_temp_right_menu_beckground = SERVER_PATH."/tamplate/".stripslashes($data_colors['right_menu_beckground']);
		if( file_exists($abpath_temp_right_menu_beckground) && !is_dir($abpath_temp_right_menu_beckground) )
		{
			$right_menu_beckground = "background=\"".HTTP_PATH."/tamplate/".stripslashes($data_colors['right_menu_beckground'])."\"";
		}
	}
	
	$img_g_site_bg = "";
	$abpath_temp_bll_all_site = SERVER_PATH."/tamplate/".stripslashes($data_colors['img_all_site_bg']);
	if( file_exists($abpath_temp_bll_all_site) && !is_dir($abpath_temp_bll_all_site) )
	{
		$temp_ss = ( !empty($data_colors['site_bg_color']) ) ? "#".$data_colors['site_bg_color'] : "" ;
		switch($data_colors['img_g_site_bg_repeat'])
		{
			case "1" :	$img_g_site_bg_repeat = "background-repeat: no-repeat;";	break;
			case "2" :	$img_g_site_bg_repeat = "background-repeat: repeat-x;";	break;
			case "3" :	$img_g_site_bg_repeat = "background-repeat: repeat-y;";	break;
			case "4" :	$img_g_site_bg_repeat = "background-repeat: no-repeat; background-attachment: fixed";	break;
		}
		if( UNK == "878912561075371037" )
			$img_g_site_bg = "background: ".$temp_ss." url(".HTTP_S."://www.agam.co.il/tamplate/".stripslashes($data_colors['img_all_site_bg']).") scroll center; background-position: top; ".$img_g_site_bg_repeat;
		else
			$img_g_site_bg = "background: ".$temp_ss." url(".HTTP_PATH."/tamplate/".stripslashes($data_colors['img_all_site_bg']).") scroll center; background-position: top; ".$img_g_site_bg_repeat;
	}
	
	
	if( $data_extra_settings['estimateSite'] == "1" )
	{
		if( $img_g_site_bg == "" && $right_menu_beckground == "" )
		{
			// $img_g_site_bg = "background:  url(".HTTP_PATH."/new_images/defualt_site_background.gif) scroll center; background-position: top; background-repeat: no-repeat;";
		}
		
		$bg_link = ( $data_colors['bg_link'] == "" ) ? "2ea3f2" : $data_colors['bg_link'];
		$color_link = ( $data_colors['color_link'] == "" ) ? "ffffff" : $data_colors['color_link'];
		$site_text_color = ( $data_colors['site_text_color'] == "" ) ? "666666" : $data_colors['site_text_color'];
		$headline_color = ( $data_colors['headline_color'] == "" ) ?"666666" : $data_colors['headline_color'];
	}
	else
	{
		$bg_link = ( $data_colors['bg_link'] == "" ) ? "2ea3f2" : $data_colors['bg_link'];
		$color_link = ( $data_colors['color_link'] == "" ) ? "ffffff" : $data_colors['color_link'];
		$site_text_color = ( $data_colors['site_text_color'] == "" ) ? "666666" : $data_colors['site_text_color'];
		$headline_color = ( $data_colors['headline_color'] == "" ) ?"666666" : $data_colors['headline_color'];
	}
	
	$COLORsite_bg_color = ( !empty($data_colors['site_bg_color']) ) ? "background-color:#".$data_colors['site_bg_color'].";" : "";
	
	
	
	
	
	$str;
	
		$str .= "BODY { ";
		  $str .= "margin:0;";
			$str .= $COLORsite_bg_color;
		  $str .=$img_g_site_bg;
		  $str .= "overflow-x: hidden;";
		$str .= "}";


		$str .= "#menu {";
			$str .= "padding:0px;";
			$str .= "margin:0px;";			
		$str .= "}";

		$str .= "#menu li {";
			$str .= "list-style-type:none;";
			$str .= "width:auto;";
			$str .= "height:100%;";
			$str .= "padding:3px 0;";
			$str .= "clear:both;";
			$str .= "font-family:arial;";
			$str .= "font-size:18px;";
		$str .= "}";
		
		
		$str .= "#menu a, #menu a:visited {";
			$str .= "position:relative;";
			$str .= "display:block;";
			$str .= "width:auto;";
			$str .= "height:100%;";
			
			
			$temp_bg_link = ( $data_name['have_rightMenuButton'] == 0 ) ? "background-color:#".$bg_link.";" : "";
			//$str .= "border:0px solid #".$data_colors['border_color'].";";
			$str .= $temp_bg_link;
			$str .= "color:#".$color_link.";";
			$str .= "padding-left:5px;";
			$str .= "padding-right:5px;";
			$str .= "text-decoration:none;";
			$str .= "padding-top:4px;";
			$str .= "padding-bottom:4px;";
		$str .= "}";
	
if($bg_link != ""){
$str.="
body .navbar-inverse .navbar-inner .nav>li>a:focus,body .navbar-inverse .nav>li>a:hover{color: #".$bg_link.";}
body .navigation-v1 .dropdown-caret {box-shadow: -2px 2px 0px #".$bg_link.";}
body .navigation-v1 .dropdown-caret:hover {background: #".$bg_link." !important;}
body .dropdown-menu>li>a:hover,body .dropdown-menu>li>a:focus{background: #".$bg_link.";}
body .nav > li:hover > a{color: #".$bg_link.";}
body .nav > li:hover > ul > a {color: #".$bg_link.";}
body .navbar-inverse .nav li.dropdown.open>.dropdown-toggle{background: #".$bg_link.";}
body .running_news_title{color: #".$bg_link.";}
body .running_news_content .news_item_title{color: #".$bg_link.";}
";
}
if($data_colors['top_bg_link'] != ""){
	$str .= "
		body div#top-header {background: #".$data_colors['top_bg_link'].";}
	";
}
if($data_colors['top_link_color'] != ""){
	$str .= "
.navbar-inverse .navigation .nav>li>a{color: #".$data_colors['top_link_color'].";}
.navbar-inverse .navigation-v2 .nav li.dropdown>.dropdown-toggle .caret{border-top-color: #".$data_colors['top_link_color']."; border-bottom-color: #".$data_colors['top_link_color'].";}
@media (max-width: 979px){
body .navbar-inverse .nav-collapse .nav>li>a,body .navbar-inverse .nav-collapse .dropdown-menu a{color: #".$data_colors['top_link_color'].";}
}
	";
}
if($data_colors['top_link_hover_color'] != ""){
	$str .= "
		body .navbar-inverse .navbar-inner .navigation-v2 .nav>li>a:focus,body .navbar-inverse .nav>li>a:hover{color: #".$data_colors['top_link_hover_color'].";}
		.navbar-inverse .navigation-v2 .nav li.dropdown.open>.dropdown-toggle .caret{border-top-color: #".$data_colors['top_link_hover_color']."; border-bottom-color: #".$data_colors['top_link_hover_color'].";}
	";
}
		
		$str .= "#menu a span, #menu a:visited span {";
			$str .= "display:none;";
		$str .= "}";
		
		$str .= "#menu a:hover {";
			$temp_bg_link = ( $data_name['have_rightMenuButton'] == 0 ) ? "background-color:#".$color_link.";" : "";
			$temp_color = ( $data_name['have_rightMenuButton'] == 0 ) ? $bg_link : $data_colors['color_link_over'];
			$str .= "color:#".$temp_color.";";
			$str .= $temp_bg_link;
			$str .= "border:0px solid #000;";
			$str .= "text-decoration:none;";
		$str .= "}";
		
		
		
		
		$str .= "#menu2 {";
			$str .= "padding:0px;";
			$str .= "margin:0px;";
		$str .= "}";

		$str .= "#menu2 li {";
			$str .= "list-style-type:none;";
			$str .= "width:auto;";
			$str .= "height:100%;";
			$str .= "padding:3px 0px;";
			$str .= "clear:both;";
			$str .= "font-family:arial;";
			$str .= "font-size:18px;";
		$str .= "}";
		
		
		$str .= "#menu2 a, #menu2 a:visited {";
			$str .= "position:relative;";
			$str .= "display:block;";
			$str .= "width:auto;";
			$str .= "height:100%;";
			
			
			$temp_bg_link = ( $data_name['have_rightMenuButton'] == 0 ) ? "background-color:#".$bg_link.";" : "";
			//$str .= "border:0px solid #".$data_colors['border_color'].";";
			$str .= $temp_bg_link;
			$str .= "color:#".$color_link.";";
			$str .= "padding-left:5px;";
			$str .= "padding-right:5px;";
			$str .= "text-decoration:none;";
			$str .= "padding-top:4px;";
			$str .= "padding-bottom:4px;";
		$str .= "}";
		
		$str .= "#menu2 a span, #menu2 a:visited span {";
			$str .= "display:none;";
		$str .= "}";
		
		$str .= "#menu2 a:hover {";
			$temp_bg_link = ( $data_name['have_rightMenuButton'] == 0 ) ? "background-color:#".$color_link.";" : "";
			$temp_color = ( $data_name['have_rightMenuButton'] == 0 ) ? $bg_link : $data_colors['color_link_over'];
			$str .= "color:#".$temp_color.";";
			$str .= $temp_bg_link;
			$str .= "border:0px solid #000;";
			$str .= "text-decoration:none;";
		$str .= "}";
		
		
		
		
		$str .= "#headline_h2 H2 {";
			$str .= "color: #".$site_text_color.";";
			$str .= "font-family: Arial, Helvetica, sans-serif;";
			$str .= "font-size: 12px;";
			$str .= "text-decoration: none;";
			$str .= "padding:2px;";
			$str .= "margin:0px;";
		$str .= "}";
		
		$str .= ".maintext{";
			$str .= "color: #".$site_text_color.";";
			$str .= "font-family: Arial, Helvetica, sans-serif;";
			$str .= "font-size: 17px; line-height: 24px;";
			$str .= "text-decoration: none;";
		$str .= "}";
		
		$str .= ".centerbar .maintext{";
			$str .= "text-align: justify;";
		$str .= "}";	
		
		$str .= ".maintext a:link {text-decoration:underline;color:#".$site_text_color.";}
		.maintext a:active{text-decoration:none;color:#".$site_text_color.";}
		.maintext a:visited{text-decoration:underline;color:#".$site_text_color.";}
		.maintext a:hover{text-decoration:none;color:#".$site_text_color.";}";
		
		$str .= ".maintext_small{";
			$str .= "color: #".$site_text_color.";";
			$str .= "font-family: Arial, Helvetica, sans-serif;";
			$str .= "font-size: 10px;";
			$str .= "text-decoration: none;";
		$str .= "}";

		$str .= ".rightMemu{";
			$str .= "color: #".$color_link.";";
			$str .= "font-family: Arial, Helvetica, sans-serif;";
			$str .= "font-size: 12px;";
			$str .= "text-decoration: none;";
			$str .= "font-weight: bold;";
		$str .= "}";

		$str .= ".rightMemu a:link {text-decoration:none;color:#".$color_link.";}
		.rightMemu a:active{text-decoration:none;color:#".$data_colors['color_link_over'].";}
		.rightMemu a:visited{text-decoration:none;color:#".$color_link.";}
		.rightMemu a:hover{text-decoration:none;color:#".$data_colors['color_link_over'].";}";
		
		$ecom_tableRightMenucolor = ( !empty($data_colors['color_e_comes_menu_right']) ) ? $data_colors['color_e_comes_menu_right'] : $site_text_color;
		
		$str .= ".ecom_tableRightMenu{";
			$str .= "color: #".$ecom_tableRightMenucolor.";";
			$str .= "font-family: Arial, Helvetica, sans-serif;";
			$str .= "font-size: 12px;";
			$str .= "text-decoration: none;";
			$str .= "font-weight: bold;";
		$str .= "}";

		$str .= ".ecom_tableRightMenu a:link {text-decoration:none;color:#".$ecom_tableRightMenucolor.";}
		.ecom_tableRightMenu a:active{text-decoration:none;color:#".$ecom_tableRightMenucolor.";}
		.ecom_tableRightMenu a:visited{text-decoration:none;color:#".$ecom_tableRightMenucolor.";}
		.ecom_tableRightMenu a:hover{text-decoration:none;color:#".$ecom_tableRightMenucolor.";}";
		
		$str .= ".headline{";
			$str .= "color: #".$headline_color.";";
		$str .= "}";
		
		
		$str .= ".page_headline{";
			$page_headline_color = ( $data_extra_settings['headlineTextarea'] != "" ) ? $data_extra_settings['headlineTextarea'] : "ffffff";
			$str .= "color: #".$page_headline_color.";";
		$str .= "}";
		$str .= "
		.mobile_headline{margin:0px 20px;}
		.mobile_headline .page_headline{color:#".$site_text_color."; font-size:33px;}";
		$str .= ".site_border{";
			if( $data_colors['border_color'] != "" )
				$str .= "border: 1px solid #".$data_colors['border_color'].";";
		$str .= "}";
		
		
		$str .= ".input_style	{
		";
			$border_color = ( $data_colors['border_color'] == "" ) ? "000000" : $data_colors['border_color'];
			$border_color = ( UNK == "962424165194447636" ) ? "000000" : $border_color;
			$str .= "border: 1px solid #".$border_color.";";
		$str .= "}";
		
		$str .= ".submit_style	{";
			$border_color = ( $data_colors['border_color'] == "" ) ? "000000" : $data_colors['border_color'];
			$border_color = ( UNK == "962424165194447636" ) ? "000000" : $border_color;
			$str .= "border: 1px solid #".$border_color.";";
		$str .= "}";
		
		/***** Gallery ***/
		$str .= ".gallerycontainer{";
			$str .= "position: relative;";	//*Add a height attribute and set to largest image's height to prevent overlaying*/
		$str .= "}";
		
		$str .= "img{border:0;}";
		
		$str .= ".thumbnail img{";
			if( $data_colors['border_color'] != "" )
				$str .= "border: 1px solid #".$data_colors['border_color'].";";
			$str .= "margin: 0 5px 5px 0;";
		$str .= "}";
		
		$str .= ".thumbnail:hover{";
			$str .= "background-color: transparent;";
		$str .= "}";
		
		
		$str .= ".thumbnail:hover img{";
			if( $data_colors['border_color'] != "" )
				$str .= "border: 1px solid #".$data_colors['border_color'].";";
		$str .= "}";
			
		$str .= ".thumbnail span{"; /*CSS for enlarged image*/
			$str .= "position: absolute;";
			$galley_back_color = ( $data_colors['galley_back_color'] ) ? $data_colors['galley_back_color'] : $color_link;
			$str .= "background-color: #".$galley_back_color.";";
			$str .= "padding: 10px;";
			$str .= "left: -1000px;";
			$str .= "border: 0px dashed gray;";
			$str .= "visibility: hidden;";
			$str .= "color: black;";
			$str .= "text-decoration: none;";
		$str .= "}";
		
		$str .= ".thumbnail span img{"; /*CSS for enlarged image*/
			$str .= "border-width: 0;";
			$str .= "padding: 10px;";
		$str .= "}";
		
		$str .= ".thumbnail:hover span{"; /*CSS for enlarged image*/
			$str .= "visibility: visible;";
			$str .= "top: 0;";
			$str .= "left: 140px;"; /*position where enlarged image should offset horizontally */
			$str .= "z-index: 50;";
		$str .= "}";
		
		
		
		
		$str .= ".thumbnail2 img{";
			if( $data_colors['border_color'] != "" )
				$str .= "border: 1px solid #".$data_colors['border_color'].";";
			$str .= "margin: 0 5px 5px 0;";
		$str .= "}";
		
		$str .= ".thumbnail2:hover{";
			$str .= "background-color: transparent;";
		$str .= "}";
		
		
		$str .= ".thumbnail2:hover img{";
			if( $data_colors['border_color'] != "" )
				$str .= "border: 1px solid #".$data_colors['border_color'].";";
		$str .= "}";
			
		$str .= ".thumbnail2 span{ ";/*CSS for enlarged image*/
			$str .= "position: absolute;";
			$str .= "background-color: #".$data_colors['conent_bg_color'].";";
			$str .= "padding: 5px;";
			$str .= "left: -1000px;";
			$str .= "border: 0px dashed gray;";
			$str .= "visibility: hidden;";
			$str .= "color: black;";
			$str .= "text-decoration: none;";
		$str .= "}";
		
		$str .= ".thumbnail2 span img{ ";/*CSS for enlarged image*/
			$str .= "border-width: 0;";
			$str .= "padding: 2px;";
			if( $data_colors['border_color'] != "" )
				$str .= "border: 1px solid #".$data_colors['border_color'].";";
		$str .= "}";
		
		$str .= ".thumbnail2:hover span{ ";/*CSS for enlarged image*/
			$str .= "visibility: visible;";
			$str .= "top: 0;";
			$str .= "left: 140px;"; /*position where enlarged image should offset horizontally */
			$str .= "z-index: 50;";
		$str .= "}";
		
		$str .= ".thumbnail2 span{ ";/*CSS for enlarged image*/
			$str .= "visibility: visible;";
			$str .= "top: 0;";
			$str .= "left: 140px;"; /*position where enlarged image should offset horizontally */
			$str .= "z-index: 50;";
		$str .= "}";
		

		
		if( $data_extra_settings['have_scrollNewsImgs'] == "1" )
		{
			$abpath_temp = SERVER_PATH."/tamplate/".stripslashes($data_extra_settings['scrollNewsDupli']);
			if( file_exists($abpath_temp) && !is_dir($abpath_temp) )	{
				$im_size = GetImageSize ($abpath_temp); 
				$imageHeight = $im_size[1];
			}
			if( UNK == "285240640927706447" )
				$height_marqueecontainer = "130";
			else
				$height_marqueecontainer = ( $imageHeight <= 50 ) ? "150" : $imageHeight;
			
			$str .= "#marqueecontainer{";
				$str .= "position: relative;";
				$str .= "width: 100%;"; /*marquee width */
				$str .= "height: ".$height_marqueecontainer."px;"; /*marquee height */
				$str .= "overflow: hidden;";
				$str .= "padding: 0px;";
				$str .= "padding-left: 0px;";
				$str .= "padding-right: 0px;";
			$str .= "}";
		}
		else
		{
			$str .= "#marqueecontainer{";
				$str .= "position: relative;";
				$str .= "width: 100%;"; /*marquee width */
				$str .= "height: 150px;"; /*marquee height */
				$str .= "background-color: #".$data_colors['conent_bg_color'].";";
				$str .= "overflow: hidden;";
				$str .= "padding: 0px;";
				$str .= "padding-left: 0px;";
				$str .= "padding-right: 0px;";
			$str .= "}";
		}
		
		if( $_GET['m'] == "zoom_gallery" )
		{
		
			$str .= ".thumbDemoBack {
				float: left; 
				width: 142px; 
				height: 139px; 
				margin-bottom: 5px; 
				margin-right: 15px;
				background-position: center center;
				background-repeat: no-repeat;
				background-image: url('/zoomFiles/axZm/icons/thumb_back.png');
				overflow: hidden;
			}
			.thumbDemo {
				width: 142px; 
				height: 100px; 
				margin-left: 21px;
				margin-top: 20px;
				background-position: center center;
				background-repeat: no-repeat;
				text-align: center;
			}
			.thumbDemoImg {
				width: 100px;
				height: 100px;
			}
			.thumbDemoLink{
			
			}";
		}
		
		if( $data_name['have_topmenu'] == 1 )
		{
			$str .= "
				.chromestyle{
width: 100%;
font-weight: bold;
font-family: arial;
font-size: 12px;
direction:ltr;
}

.chromestyle:after{ /*Add margin between menu and rest of content in Firefox*/
content: \" \"; 
display: block; 
height: 0; 
clear: both; 
visibility: hidden;
}

.chromestyle ul{
border: 1px solid #".$data_colors['border_color'].";
width: 100%;
background-color: #".$bg_link.";
padding: 4px 0;
margin: 0;
text-align: center; /*set value to \"left\", \"center\", or \"right\"*/
}

.chromestyle ul li{
display: inline;
}

.chromestyle ul li a{
color: #".$color_link.";
padding: 4;
margin: 0;
text-decoration: none;
border-left: 1px solid #".$data_colors['border_color']."; /*THEME CHANGE HERE*/
}

.chromestyle ul li a:hover{
color: #".$bg_link.";
background-color: #".$color_link.";
}


.chromestyle ul li a:after{ /*HTML to indicate drop down link*/
visibility: hidden;
content: \"a\";
}

.chromestyle ul li a[rel]:after{ /*HTML to indicate drop down link*/
visibility: hidden;
content: \"a\";
}


/* ######### Style for Drop Down Menu ######### */

.dropmenudiv{
position:absolute;
top: 0;
border: 1px solid #".$data_colors['border_color']."; /*THEME CHANGE HERE*/
border-bottom-width: 0;
font-family: arial;
font-size: 12px;
line-height:18px;
z-index:100;
background-color: #".$bg_link.";
width: 200px;
visibility: hidden;
filter: progid:DXImageTransform.Microsoft.Shadow(color=#CACACA,direction=135,strength=4); /*Add Shadow in IE. Remove if desired*/
}


.dropmenudiv a{
width: 100%;
display: block;
text-indent: 3px;
border-bottom: 1px solid #".$data_colors['border_color']."; /*THEME CHANGE HERE*/
padding: 2px 0;
text-decoration: none;
font-weight: bold;
color: #".$color_link.";
}

.product_container{	/* Div for each product */
	/*width:154px;*/
	float:left;
	padding:2px;
	height: 100%;
}

.sliding_product img{	/* Float product images */
	float:left;
	margin:2px;
}

.dropmenudiv a:hover{ /*THEME CHANGE HERE*/
color: #".$bg_link.";
background-color: #".$color_link.";
z-index:100px;
}

/****************************************/
/***************************************/
/****************************************/
";
$str .= "
#sddm
{	margin: 0;
	padding: 0;
	z-index: 30}

#sddm li
{	margin: 0;
	padding: 0;
	list-style: none;
	float: right;
	font: bold 11px arial}

#sddm li a
{	display: block;
	margin: 0 1px 0 0;
	padding: 4px 10px;
	width: auto;
	background: #5970B2;
	color: #FFF;
	text-align: center;
	text-decoration: none}

#sddm li a:hover
{	background: #49A3FF}

#sddm div
{	position: absolute;
	visibility: hidden;
	margin: 0;
	padding: 0;
	background: #EAEBD8;
	border: 1px solid #5970B2}

	#sddm div a
	{	position: relative;
		display: block;
		margin: 0;
		padding: 5px 10px;
		width: auto;
		white-space: nowrap;
		text-align: center;
		text-decoration: none;
		background: #EAEBD8;
		color: #2875DE;
		font: 11px arial}

	#sddm div a:hover
	{	background: #49A3FF;
		color: #FFF}

";

/****************************************/
/***************************************/
/****************************************/

$str .= "
#outside{

	}
#navigation-1 {
	padding:1px 0;
	margin:0px;
	list-style:none;
	width:100%;
	height:18px;
	border-top:0px solid #".$data_colors['border_color'].";
	border-bottom:0px solid #".$data_colors['border_color'].";
	font:normal 8pt verdana, arial, helvetica;
}
#navigation-1 li {
	margin:0;
	padding:0;
	display:block;
	float:right;
	position:relative;
	list-type:inside;
	
}
#navigation-1 li a:link, #navigation-1 li a:visited {
	padding:5px;
	display:block;
	text-align:center;
	text-decoration:none;
	background:#".$bg_link.";
	color:#".$color_link.";
	height:13px;
	border-right:1px solid #".$data_colors['border_color'].";
	border-left:1px solid #".$data_colors['border_color'].";
	border-bottom:1px solid #".$data_colors['border_color'].";
}
#navigation-1 li:hover a, #navigation-1 li a:hover, #navigation-1 li a:active {
	padding:5px;
	display:block;
	text-align:center;
	text-decoration:none;
	background:#".$color_link.";
	color:#".$bg_link.";
	height:13px;
	border-left:1px solid #".$data_colors['border_color'].";
}
#navigation-1 li ul.navigation-2 {
	margin:0;
	padding:1px 1px 0;
	list-style:none;
	display:none;
	background:#".$bg_link.";
	position:absolute;
	top:18px;
	border:1px solid #".$data_colors['border_color'].";
	border-top:none;
	direction: ltr;
	right: 0px;
	z-index: 900;
}
#navigation-1 li:hover ul.navigation-2 {
	display:block;
}
#navigation-1 li ul.navigation-2 li {
	clear:right;
}
#navigation-1 li ul.navigation-2 li a:link, #navigation-1 li ul.navigation-2 li a:visited {
	clear:right;
	background:#".$bg_link.";
	color:#".$color_link.";
	padding:4px 0;
	width:200px;
	border:none;
	border-bottom:1px solid #".$data_colors['border_color'].";
	border-left:1px solid #".$data_colors['border_color'].";
	position:relative;
	z-index:1000;
}
#navigation-1 li ul.navigation-2 li:hover a, #navigation-1 li ul.navigation-2 li a:active, #navigation-1 li ul.navigation-2 li a:hover {
	clear:right;
	background:#".$color_link.";
	color:#".$bg_link.";
	padding:4px 0;
	width:200px;
	border:none;
	border-bottom:1px solid #".$data_colors['border_color'].";
	border-left:1px solid #".$data_colors['border_color'].";
	position:relative;
	z-index:1000;
}
#navigation-1 li ul.navigation-2 li a span {
	position:absolute;
	top:0;
	right:128px;
	font-size:12pt;
	color:#".$color_link.";
	z-index:1000;
}
#navigation-1 li ul.navigation-2 li:hover a span, #navigation-1 li ul.navigation-2 li a:hover span {
	position:absolute;
	top:0;
	right:128px;
	font-size:12pt;
	color:#".$color_link.";
	z-index:1000;
}


			";
		}
if($data_colors['open_flash_color'] != ""){
	$str.="
	body div.main-title{
	background-color: #".$data_colors['open_flash_color'].";
	}";
}
echo $str;

if($data_extra_settings['head_free_css'] != ""){
	echo $data_extra_settings['head_free_css'];
}
	
