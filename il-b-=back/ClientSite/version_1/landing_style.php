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
.datepicker-dropdown{position:absolute; background:white;}
.part-wrap{width:100%; overflow-x:auto;}
";


echo "#page, #mobile_page";
echo "{";
	echo "padding: 0px 0px; margin: 0px;";
	echo "margin-left: auto; margin-right: auto;";
	if( $landing_10service == "1" )	
		echo "width: 950px;";	
	else{
	//	echo "width: 775px;";
	}
	echo "position:relative;";
	echo "direction: rtl;";
echo "}";

echo "#mobile_page";
echo "{";
	echo "display:none;";
	echo "overflow:hidden;";
echo "}";

$text1_top_px = stripslashes($dataLDSetting['text1_top']);
$text1_right_px = stripslashes($dataLDSetting['text1_right']);
$text1_font_size_px = stripslashes($dataLDSetting['text1_font_size']);

$text2_top_px = stripslashes($dataLDSetting['text2_top']);
$text2_right_px = stripslashes($dataLDSetting['text2_right']);
$text2_font_size_px = stripslashes($dataLDSetting['text2_font_size']);

$text3_top_px = stripslashes($dataLDSetting['text3_top']);
$text3_right_px = stripslashes($dataLDSetting['text3_right']);
$text3_font_size_px = stripslashes($dataLDSetting['text3_font_size']);

$abpath_temp1 = SERVER_PATH."/new_images/landing/".$dataLDSetting['topslice_bg'];
if( file_exists($abpath_temp1) && !is_dir($abpath_temp1) )
{
	$temp_test = explode( "." , $dataLDSetting['topslice_bg'] );
	
	if( $temp_test[1] != "swf" )
		$topBack = "background: url(\"".HTTP_PATH."/new_images/landing/".$dataLDSetting['topslice_bg']."\") no-repeat right top !important;";
	
	$im_size = GetImageSize ($abpath_temp1); 
	$imageWidth = $im_size[0]; 
	$imageHeight = $im_size[1];
	
	
	$proportion = $imageWidth +15;
	$top_bg_height_vw = $imageHeight/$proportion*100;
	$top_bg_width = "max-width: ".$imageWidth."px;";



$sql = "SELECT * FROM sites_landingPage_links WHERE deleted=0 AND landing_id='".$dataLDSetting['id']."' AND unk = '".UNK."' ORDER BY place";
$resLinks = mysql_db_query(DB,$sql);
$top_links= array();
while( $dataLinks = mysql_fetch_array($resLinks) )
{
	$top_links[$dataLinks['id']] = array('px'=>$dataLinks['link_size'],'vw'=>$dataLinks['link_size']*100/$proportion);
}

foreach($top_links as $key=>$val){
	echo "#top_link_".$key."{font-size:".$val['vw']."vw;}";
}
echo ".body-table{width:100%; max-width:".$imageWidth."px;}";

echo "#topSliceBack";
echo "{";
	echo "margin-left: auto; margin-right: auto;";
	echo "padding:0px; margin:0px;";
	echo "position:relative;";
	echo "float : center;";
	echo "top: 0px;";
	echo "right: 0px;";
	echo $top_bg_width;
	echo "height: ".$top_bg_height_vw."vw;";
	echo $topBack;
	echo "background-size: contain;";
echo "}";


echo ".datepicker-dropdown{position: absolute; right: auto; background: #f7f7f7; border: 1px solid #aaa;}";






$text1_top_vw = $text1_top_px/$proportion*100;
$text1_right_vw = $text1_right_px/$proportion*100;
$text1_font_size_vw = $text1_font_size_px/$proportion*100;

$text2_top_vw = $text2_top_px/$proportion*100;
$text2_right_vw = $text2_right_px/$proportion*100;
$text2_font_size_vw = $text2_font_size_px/$proportion*100;

$text3_top_vw = $text3_top_px/$proportion*100;
$text3_right_vw = $text3_right_px/$proportion*100;
$text3_font_size_vw = $text3_font_size_px/$proportion*100;

$links_top_px = stripslashes($dataLDSetting['links_top']);
$links_right_px = stripslashes($dataLDSetting['links_right']);
$links_font_size_px = 15;

$links_top_vw = $links_top_px/$proportion*100;
$links_right_vw = $links_right_px/$proportion*100;
$links_font_size_vw = $links_font_size_px/$proportion*100;


echo "#topSliceText1{";
	echo "position:absolute;";
	echo "float : right;";
	echo "top: ".$text1_top_vw ."vw;";	
	echo "right: ".$text1_right_vw."vw;";
	echo "font-size: ".$text1_font_size_vw."vw;";
	echo "font-family: Tahoma,arial;";

	echo "color: #".stripslashes($dataLDSetting['text_1_color']).";";
echo "}";
echo "#topSliceText2{";
	echo "position:absolute;";
	echo "float : right;";
	echo "top: ".$text2_top_vw ."vw;";	
	echo "right: ".$text2_right_vw."vw;";
	echo "font-size: ".$text2_font_size_vw."vw;";	
	echo "font-family: Tahoma,arial;";

	echo "color: #".stripslashes($dataLDSetting['text_2_color']).";";
echo "}";
echo "#topSliceText3{";
	echo "position:absolute;";
	echo "float : right;";
	echo "top: ".$text3_top_vw ."vw;";	
	echo "right: ".$text3_right_vw."vw;";
	echo "font-size: ".$text3_font_size_vw."vw;";	
	echo "font-family: Tahoma,arial;";

	echo "color: #".stripslashes($dataLDSetting['text_3_color']).";";
echo "}";

}
else{

echo "#topSliceText1{";
	echo "font-size: ".$text1_font_size_px."px;";
	echo "color: #".stripslashes($dataLDSetting['text_1_color']).";";
echo "}";
echo "#topSliceText2{";
	echo "font-size: ".$text2_font_size_px."px;";	
	echo "color: #".stripslashes($dataLDSetting['text_2_color']).";";
echo "}";
echo "#topSliceText3{";
	echo "font-size: ".$text3_font_size_px."px;";	
	echo "color: #".stripslashes($dataLDSetting['text_3_color']).";";
echo "}";
	
}


echo "#mobile_page #topSliceBack";
echo "{";
	echo "background: none;";
echo "}";


$mobile_text1_color = stripslashes($dataLDSetting['mobile_text1_color']);
$mobile_text1_right = stripslashes($dataLDSetting['mobile_text1_right']);
$mobile_text1_font_size = stripslashes($dataLDSetting['mobile_text1_font_size']);


$mobile_text2_color = stripslashes($dataLDSetting['mobile_text2_color']);
$mobile_text2_right = stripslashes($dataLDSetting['mobile_text2_right']);
$mobile_text2_font_size = stripslashes($dataLDSetting['mobile_text2_font_size']);

$mobile_text3_color = stripslashes($dataLDSetting['mobile_text3_color']);
$mobile_text3_right = stripslashes($dataLDSetting['mobile_text3_right']);
$mobile_text3_font_size = stripslashes($dataLDSetting['mobile_text3_font_size']);


$mobile_text1_align = "right";
if($mobile_text1_right == "1"){
	$mobile_text1_align = "center";
} 
elseif($mobile_text1_right == "2"){
	$mobile_text1_align = "left";
}

$mobile_text2_align = "right";
if($mobile_text2_right == "1"){
	$mobile_text2_align = "center";
}
elseif($mobile_text2_right == "2"){
	$mobile_text2_align = "left";
}

$mobile_text3_align = "right";
if($mobile_text3_right == "1"){
	$mobile_text3_align = "center";
}
elseif($mobile_text3_right == "2"){
	$mobile_text3_align = "left";
}

echo "#mobile_page #mobile_topSliceText1{";
	echo "font-size: ".$mobile_text1_font_size."px;";
	echo "color: #".$mobile_text1_color.";";
	echo "text-align: ".$mobile_text1_align.";";
	echo "margin:12px;";
	
echo "}";
echo "#mobile_page #mobile_topSliceText2{";
	echo "font-size: ".$mobile_text2_font_size."px;";
	echo "color: #".$mobile_text2_color.";";
	echo "text-align: ".$mobile_text2_align.";";
	echo "margin:12px;";	
echo "}";
echo "#mobile_page #mobile_topSliceText3{";
	echo "font-size: ".$mobile_text3_font_size."px;";	
	echo "color: #".$mobile_text3_color.";";
	echo "text-align: ".$mobile_text3_align.";";
	echo "margin:12px;";	
echo "}";
echo "#fb_share{";
	echo "margin-top: 20px;";	
echo "}";

echo "#mobile_topSliceLinks{";
	echo "display: none;";
echo "}";
echo "#topSliceLinks{";
	echo "position:absolute;";
	echo "float : right;";
	echo "top: ".$links_top_vw."vw;";
	echo "right: ".$links_right_vw."vw;";
	echo "font-family: Tahoma,arial;";
echo "}";
echo "#topSliceLinks td a{";
	//echo "font-size: ".$links_font_size_vw."vw;";
echo "}";
echo ".leftfloat{";
	echo "float:left; margin-right:15px;";
echo "}";
echo ".landing-estimate-form{padding:8px; border-radius:5px; border:1px solid #eee;}
.landing-estimate-form .form-group{padding: 0px 15px;}";
echo ".landing-estimate-form input,.landing-estimate-form select,.landing-estimate-form textarea {width:100%; font-size:18px;     margin: 6px 0px;box-sizing: border-box;}
.mailing-iframe iframe table{width:100% !important;}
.mailing-iframe iframe input{width:100% !important;}";
echo "#mobile_topSliceLinks{";
	echo "margin:15px;text-align: right;";
echo "}";
echo ".smalline{";
	echo "width:30px;height:5px; border-bottom:3px solid blue;";
echo "}";
echo "#mobile_topSliceLinks_list{";
	echo "padding-top:15px;";
echo "}";

echo ".mobile_topSliceLink{";
	echo "    
	text-align: right;
    padding: 6px;
    border-top: 1px solid #ddd;";
echo "}";

echo ".mobile_topSliceLink{";
	echo "    
	
    padding: 6px;
    border-top: 1px solid #ddd;";
echo "}";



echo "@media screen and (min-width: ".$imageWidth."px) {";
foreach($top_links as $key=>$val){
	echo "#top_link_".$key."{font-size:".$val['px']."px;}";
}
echo "#topSliceBack{";
	echo "height: ".$imageHeight."px;";

echo "}";  
echo "#topSliceLinks{";
	echo "top: ".$links_top_px."px;";
	echo "right: ".$links_right_px."px;";
	//echo "font-size: ".$links_font_size_px."px;";
echo "}"; 
echo "#topSliceLinks td a{";
	//echo "font-size: ".$links_font_size_px."px;";
echo "}";
echo "#topSliceText1{";
	echo "top: ".$text1_top_px ."px;";
	echo "right: ".$text1_right_px."px;";
	echo "font-size: ".$text1_font_size_px."px;";
echo "}";
echo "#topSliceText2{";
	echo "top: ".$text2_top_px ."px;";
	echo "right: ".$text2_right_px."px;";
	echo "font-size: ".$text2_font_size_px."px;";
echo "}";
echo "#topSliceText3{";
	echo "top: ".$text3_top_px ."px;";
	echo "right: ".$text3_right_px."px;";
	echo "font-size: ".$text3_font_size_px."px;";
echo "}";
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
	echo "width: 100%;";
	echo "font-size:20px;";
echo "}";
echo ".comb-form .form-group{width:40%; margin:5%; float:right;}
.submit-group{display:block; float:left;}
";
echo ".submit_style{";
	echo "font-family: Tahoma,arial;";
	echo "font-size: 12px;";
	echo "color: #000000;";
	echo "border: 1px solid #000000;";
echo "}";

echo ".videoWrapper {
	position: relative;
	padding-bottom: 56.25%; /* 16:9 */
	padding-top: 25px;
	height: 0;
	max-width: 775px;
    margin: auto;
}
.videoWrapper iframe {
	position: absolute;
	top: 0;
	left: 0;
	width: 100%;
	height: 100%;
	
}
.videodiv{
	width:72%;
	float:right;
}
.videolist{
	width:27%;
	float:left;
}
.videolist img{
	display: block;
    float: right;
    width: 50%;
	margin-left:12px;
}
.videolist .landing_link{
    text-align: left;
    padding-bottom: 12px;
	margin-bottom: 12px;
	clear: both;
	border-bottom:1px solid ".$dataLDSetting['defualt_p_text_color']."
}

.galery-img{
    width: 22%;
    float: right;
    margin-left: 3%;
    margin-top: 2%;
	
}
.galery-img img{width:100%;border-radius:5px;}
";
echo "table td,fieldset, {border-radius:5px;}";
echo "@media screen and (max-width: 550px) {";
echo ".input_style{";
	echo "width: 100% !important;";
echo "}";
echo ".leftfloat{";
	echo "width:100%;";
echo "}";
echo ".leftfloat img{";
	echo "width:100%;";
echo "}";
echo "#page";
echo "{";
	echo "display:none;";
echo "}";
echo "#mobile_page,#mobile_topSliceLinks";
echo "{";
	echo "display:block;";
echo "}";
echo ".videodiv{
	width:auto;
	float:none;
}
.videolist{
	width:auto;
	float:none;
}
.galery-img{
    width: 45%;
    float: right;
    margin-left: 5%;
    margin-top: 4%;
	
}";
echo "}";