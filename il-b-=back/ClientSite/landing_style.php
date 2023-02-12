<?
ob_start();

header("Content-type: text/css; charset=windows-1255");
//require('/home/ilan123/domains/ilbiz.co.il/public_html/global_func/vars.php');


/*
define('UNK',$_GET['unk']);

// all color on the page
$sql = "select * from user_colors_set where unk = '".UNK."'";
$res_colors = mysql_db_query(DB,$sql);
$data_colors = mysql_fetch_array($res_colors);

$sql = "select domain from users where unk = '".UNK."' and deleted = '0'";
$res_domain = mysql_db_query(DB,$sql);
$data_domain = mysql_fetch_array($res_domain);

define('HTTP_PATH',"http://".$data_domain['domain']);
define('SERVER_PATH',"/home/ilan123/domains/".$data_domain['domain']."/public_html");



$img_g_site_bg = "";
$abpath_temp_bll_all_site = SERVER_PATH."/tamplate/".stripslashes($data_colors['img_all_site_bg']);
if( file_exists($abpath_temp_bll_all_site) && !is_dir($abpath_temp_bll_all_site) )
{
	$temp_ss = ( !empty($data_colors['site_bg_color']) ) ? "#".$data_colors['site_bg_color'] : "" ;
	$img_g_site_bg_repeat = ( $data_colors['img_g_site_bg_repeat'] == "1" ) ? "background-repeat: no-repeat;" : "";
	$img_g_site_bg = "background: ".$temp_ss." url(".HTTP_PATH."/tamplate/".stripslashes($data_colors['img_all_site_bg']).") scroll center; background-position: top; ".$img_g_site_bg_repeat;
}

$COLORsite_bg_color = ( !empty($data_colors['site_bg_color']) ) ? "background-color:#".$data_colors['site_bg_color'].";" : "";
	


$sql = "SELECT * FROM sites_landingPage_settings WHERE id='".$_GET['ld']."' AND unk = '".UNK."' ";
$resSetting = mysql_db_query(DB,$sql);
$dataLDSetting = mysql_fetch_array($resSetting);

$sql = "SELECT * FROM sites_landingPage_links WHERE deleted=0 AND landing_id='".$_GET['ld']."' AND unk = '".UNK."' ";
$resLDLinks = mysql_db_query(DB,$sql);

*/
//echo ".test{}
//";
//echo "body{";
/*	echo "padding: 0px; margin: 0px;";
	echo "margin-left: auto; margin-right: auto;";
	
	echo "width: 775px;";
  echo "text-align: center;";
  echo "direction: rtl;";
  
  echo "font-family: arial;";
	echo "font-size: 13px;";
	echo "color: #000000;";
	echo $COLORsite_bg_color;
	echo $img_g_site_bg;*/
	//echo "background-color:#000000;";
//echo "}
//";
/*
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
	echo "position:absolute;";
	echo "float : right;";
	echo "top: 0px;";
	echo "right: 0px;";
	echo $top_bg_width;
	echo $top_bg_height;
	echo $topBack;
echo "}";
*/

