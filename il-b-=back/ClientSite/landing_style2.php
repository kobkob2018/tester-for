<?
header("Content-type: text/css; charset=windows-1255");

require('/home/ilan123/domains/ilbiz.co.il/public_html/global_func/vars.php');


define('UNK',$_GET['unk']);

// all color on the page
$sql = "select * from user_colors_set where unk = '".UNK."'";
$res_colors = mysql_db_query(DB,$sql);
$data_colors = mysql_fetch_array($res_colors);

$sql = "select domain from users where unk = '".UNK."' and deleted = '0'";
$res_domain = mysql_db_query(DB,$sql);
$data_domain = mysql_fetch_array($res_domain);


$sql = "SELECT * FROM sites_landingPage_settings WHERE id='".$_GET['ld']."' AND unk = '".UNK."' ";
$resSetting = mysql_db_query(DB,$sql);
$dataLDSetting = mysql_fetch_array($resSetting);


define('HTTP_PATH',"http://".$data_domain['domain']);
define('SERVER_PATH',"/home/ilan123/domains/".$data_domain['domain']."/public_html");


if( UNK == "285240640927706447" && ( $_GET['ld'] == "48" || $_GET['ld'] == "49" ) )
{
	$img_g_site_bg_repeat = ( $data_colors['img_g_site_bg_repeat'] == "1" ) ? "background-repeat: no-repeat;" : "";
	$img_g_site_bg = "background: ".$temp_ss." url(".HTTP_PATH."/minisite2_new.jpg) scroll center; background-position: top; ".$img_g_site_bg_repeat;
	$landing_10service = "1";
}
else
{
	$img_g_site_bg = "";
	$abpath_temp_bll_all_site = SERVER_PATH."/new_images/landing/".stripslashes($dataLDSetting['page_bg']);
	if( file_exists($abpath_temp_bll_all_site) && !is_dir($abpath_temp_bll_all_site) )
	{
			switch($dataLDSetting['img_g_site_bg_repeat'])
			{
				case "1" :	$img_g_site_bg_repeat = "background-repeat: no-repeat;";	break;
				case "2" :	$img_g_site_bg_repeat = "background-repeat: repeat-x;";	break;
				case "3" :	$img_g_site_bg_repeat = "background-repeat: repeat-y;";	break;
				case "4" :	$img_g_site_bg_repeat = "background-repeat: no-repeat; background-attachment: fixed";	break;
			}
			$img_g_site_bg = "display: block; background: url(".HTTP_PATH."/new_images/landing/".stripslashes($dataLDSetting['page_bg']).") scroll center ; background-position: top; ".$img_g_site_bg_repeat;
	}
	else
	{
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
			$img_g_site_bg = "display: block; background: ".$temp_ss." url(".HTTP_PATH."/tamplate/".stripslashes($data_colors['img_all_site_bg']).") scroll center ; background-position: top; ".$img_g_site_bg_repeat;
		}
	}
}

$COLORsite_bg_color = ( !empty($data_colors['site_bg_color']) ) ? "background-color:#".$data_colors['site_bg_color'].";" : "";
	



$sql = "SELECT * FROM sites_landingPage_links WHERE deleted=0 AND landing_id='".$_GET['ld']."' AND unk = '".UNK."' ";
$resLDLinks = mysql_db_query(DB,$sql);


echo "body{";
	echo "padding: 0; margin: 0;";
	
  echo "text-align: center; ";
  echo "direction: rtl;";
  echo "overflow-x: hidden;";
  echo "font-family: Tahoma,arial;";
	echo "font-size: 13px;";
	echo "color: #000000;";
	echo $COLORsite_bg_color;
	echo $img_g_site_bg;
echo "}
";


echo "#page";
echo "{";
	echo "padding: 0px; margin: 0px;";
	echo "margin-left: auto; margin-right: auto;";
	if( $landing_10service == "1" )	echo "width: 950px;";	else
	echo "width: 775px;";
	echo "position:relative;";
 echo "direction: rtl;";
echo "}";


$abpath_temp1 = SERVER_PATH."/new_images/landing/".$dataLDSetting['topslice_bg'];
if( file_exists($abpath_temp1) && !is_dir($abpath_temp1) )
{
	$temp_test = explode( "." , $dataLDSetting['topslice_bg'] );
	
	if( $temp_test[1] != "swf" )
		$topBack = "background: url(\"".HTTP_PATH."/new_images/landing/".$dataLDSetting['topslice_bg']."\") no-repeat right top;";
	
	$im_size = GetImageSize ($abpath_temp1); 
	$imageWidth = $im_size[0]; 
	$imageHeight = $im_size[1];
	
	$top_bg_width = "width: ".$imageWidth."px;";
	$top_bg_height = "height: ".$imageHeight."px;";
}

echo "#topSliceBack";
echo "{";
	echo "margin-left: auto; margin-right: auto;";
	echo "padding:0px; margin:0px;";
	echo "position:relative;";
	echo "float : center;";
	echo "top: 0px;";
	echo "right: 0px;";
	echo $top_bg_width;
	echo $top_bg_height;
	echo $topBack;
echo "}";



echo "#topSliceText1{";
	echo "position:absolute;";
	echo "float : right;";
	echo "top: ".stripslashes($dataLDSetting['text1_top'])."px;";
	echo "right: ".stripslashes($dataLDSetting['text1_right'])."px;";
	echo "font-family: Tahoma,arial;";
	echo "font-size: ".stripslashes($dataLDSetting['text1_font_size'])."px;";
	echo "color: #".stripslashes($dataLDSetting['text_1_color']).";";
echo "}";

echo "#topSliceText2{";
	echo "position:absolute;";
	echo "float : right;";
	echo "top: ".stripslashes($dataLDSetting['text2_top'])."px;";
	echo "right: ".stripslashes($dataLDSetting['text2_right'])."px;";
	echo "font-family: Tahoma,arial;";
	echo "font-size: ".stripslashes($dataLDSetting['text2_font_size'])."px;";
	echo "color: #".stripslashes($dataLDSetting['text_2_color']).";";
echo "}";


echo "#topSliceText3{";
	echo "position:absolute;";
	echo "float : right;";
	echo "top: ".stripslashes($dataLDSetting['text3_top'])."px;";
	echo "right: ".stripslashes($dataLDSetting['text3_right'])."px;";
	echo "font-family: Tahoma,arial;";
	echo "font-size: ".stripslashes($dataLDSetting['text3_font_size'])."px;";
	echo "color: #".stripslashes($dataLDSetting['text_3_color']).";";
echo "}";


echo "#topSliceLinks{";
	echo "position:absolute;";
	echo "float : right;";
	echo "top: ".stripslashes($dataLDSetting['links_top'])."px;";
	echo "right: ".stripslashes($dataLDSetting['links_right'])."px;";
	echo "font-family: Tahoma,arial;";
	echo "font-size: 13px;";
echo "}";


$defualt_p_link_color = ( !empty($dataLDSetting['defualt_p_link_color']) ) ? $dataLDSetting['defualt_p_link_color'] : "000000";

echo ".landing_link{";
	echo "font-family: Tahoma,arial;";
	echo "font-size: 12px;";
	echo "color: #".$defualt_p_link_color.";";
	echo "text-decoration:none;";
echo "}";

echo "
.landing_link a:link{text-decoration:none;color:#".$defualt_p_link_color.";}
.landing_link a:active{text-decoration:none;color:#".$defualt_p_link_color.";}
.landing_link a:visited{text-decoration:none;color:#".$defualt_p_link_color.";}
.landing_link a:hover{text-decoration:none;color:#".$defualt_p_link_color.";}
";

$defualt_p_text_color = ( !empty($dataLDSetting['defualt_p_text_color']) ) ? $dataLDSetting['defualt_p_text_color'] : "000000";

echo ".landing_text{";
	echo "font-family: Tahoma,arial;";
	echo "font-size: 12px;";
	echo "color: #".$defualt_p_text_color.";";
echo "}";


echo ".input_style{";
	echo "font-family: Tahoma,arial;";
	echo "font-size: 12px;";
	echo "color: #000000;";
	echo "border: 1px solid #000000;";
	echo "width: 300px;";
echo "}";

echo ".submit_style{";
	echo "font-family: Tahoma,arial;";
	echo "font-size: 12px;";
	echo "color: #000000;";
	echo "border: 1px solid #000000;";
echo "}";