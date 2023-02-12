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
$http_s = "http";
if( (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off')
    || $_SERVER['SERVER_PORT'] == 443){
	$http_s = "https";
}

define('HTTP_PATH',$http_s."://".$data_domain['domain']);
define('SERVER_PATH',"/home/ilan123/domains/".$data_domain['domain']."/public_html");



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
echo "*{padding:0; margin:0;}";
echo "ul li{list-style:none;}";
echo "a{text-decoration:none;}";
echo "body{";
	echo "padding: 0; margin: 0;";
	echo "text-align: center; ";
	echo "direction: rtl;";
	echo "overflow-x: hidden;";
	echo "font-family: Tahoma,Arial;";
	echo "font-size: 15px;";
	echo "color: #000000;";
	echo $img_g_site_bg;
echo "}";
echo "
.datepicker-dropdown{position: absolute; right: auto; background: #f7f7f7; border: 1px solid #aaa;}
.part-wrap{width:100%; overflow-x:auto;}
";

echo ".white_bg{background: url(style/image/white_bg.png);}";
echo ".black_bg{background: url(style/image/black_bg.png);}";
echo "#page, #mobile_page";
echo "{";
	echo "margin-left: auto; margin-right: auto;";
	echo "position:relative;";
echo "}";

echo "#mobile_page";
echo "{";
	echo "display:none;";
	echo "overflow:hidden;";
echo "}";

echo "#topSliceText1{";
	echo "font-size: ".stripslashes($dataLDSetting['text1_font_size'])."px;";
	echo "color: #".stripslashes($dataLDSetting['text_1_color']).";";
echo "}";
echo "#topSliceText2{";
	echo "font-size: ".stripslashes($dataLDSetting['text2_font_size'])."px;";	
	echo "color: #".stripslashes($dataLDSetting['text_2_color']).";";
echo "}";
echo "#topSliceText3{";
	echo "font-size: ".stripslashes($dataLDSetting['text3_font_size'])."px;";	
	echo "color: #".stripslashes($dataLDSetting['text_3_color']).";";
echo "}";

echo "#mobile_page #mobile_topSliceText1{";
	echo "font-size: ".stripslashes($dataLDSetting['mobile_text1_font_size'])."px;";
	echo "color: #".stripslashes($dataLDSetting['mobile_text1_color']).";";
	echo "text-align: ".$mobile_text_align_options[stripslashes($dataLDSetting['mobile_text1_right'])].";";
	echo "margin:12px;";
	
echo "}";
echo "#mobile_page #mobile_topSliceText2{";
	echo "font-size: ".stripslashes($dataLDSetting['mobile_text2_font_size'])."px;";
	echo "color: #".stripslashes($dataLDSetting['mobile_text2_color']).";";
	echo "text-align: ".$mobile_text_align_options[stripslashes($dataLDSetting['mobile_text2_right'])].";";
	echo "margin:12px;";	
echo "}";
echo "#mobile_page #mobile_topSliceText3{";
	echo "font-size: ".stripslashes($dataLDSetting['mobile_text3_font_size'])."px;";	
	echo "color: #".stripslashes($dataLDSetting['mobile_text3_color']).";";
	echo "text-align: ".$mobile_text_align_options[stripslashes($dataLDSetting['mobile_text3_right'])].";";
	echo "margin:12px;";	
echo "}";
echo "#fb_share{";
	echo "margin-top: 20px;";	
	echo "max-width:100%; overflow:auto;";
echo "}";

echo "#mobile_topSliceLinks,#mobile_page .topSliceLinks{";
	echo "display: none;";
echo "}";
echo "#topSliceLinks{";
echo "}";
echo "#top_links_wrap ul li{display: inline-block;}";
echo ".leftfloat{";
	echo "float:left; margin-right:15px;";
echo "}";
echo ".landing-estimate-form{padding:8px; border-radius:5px; border:1px solid #eee;}
.landing-estimate-form .form-group{padding: 0px 15px;}";

echo "
@media (max-width: 979px){ 

	#mobile_estimate_form_wrap{
		//position: fixed;
		//top: 0px;
		height: 100%;
		width:100%;
		text-align:center;
		background: white;
		overflow: auto;
		z-index:1550;
		
	}
	#mobile_estimate_form_wrap #estimate_form_wrap{
		padding-bottom:100px;
	}
	#mobile_estimate_form_open_button_wrap{
		position: fixed;
		bottom: 0px;
		right: 0px;
		width: 100%;
		padding: 6px;
		margin: 0px;
		box-sizing: border-box;
		background: white;
		box-shadow: 1px 1px 12px black;
		z-index:1600;
	}
	#mobile_estimate_form_placeholder{height:100px;}
	#mobile_estimate_form_open_button{
		padding: 0px;
		margin: 0px;	
	}
	#mobile_estimate_form_open_button a{
		width: 100%;
		text-align: center;
		margin: 0px;
		box-sizing: border-box;
		display: block;
		padding: 20px 40px 20px 30px;
		font-size: 20px;
		text-decoration: none;
		background: #2ea3f2 right center no-repeat;
		border-radius: 10px;
		color: black;
		background-image: url(style/image/plus_black.png);
		font-weight: bold;
		border-right: 10px solid transparent;
	}
	#mobile_estimate_form_open_button_wrap.open{
		float: right;
		top: 0;
		bottom: auto;
		width: auto;
		padding: 2px;
		background: black;		
	}
	#mobile_estimate_form_open_button a.open{background-image: url(style/image/x_black.png); padding:21px;}
	#mobile_estimate_form_open_button a.open .mobile_estimate_form_open_button_text{display:none;}
	#mobile_estimate_form_open_button a.open .mobile_estimate_form_open_button_text{    font-size: 17px;}
	#mobile_estimate_form_wrap .estimate-form-content .btn-sumbit{background:#a7a7a7;border: 1px solid #392c2c;}
	#mobile_estimate_form_wrap .estimate-form-img img{max-width:100%;}
}

";
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


$sql = "SELECT * FROM sites_landingPage_links WHERE deleted=0 AND landing_id='".$dataLDSetting['id']."' AND unk = '".UNK."' ORDER BY place";
$resLinks = mysql_db_query(DB,$sql);
$top_links= array();
while( $dataLinks = mysql_fetch_array($resLinks) )
{
	$top_links[$dataLinks['id']] = $dataLinks['link_size'];
}
echo "@media screen and (min-width: ".$imageWidth."px) {";
foreach($top_links as $key=>$val){
	echo "#top_link_".$key."{font-size:".$val."px;}";
}
echo "#topSliceLinks ul li a{";
echo "}";
echo "#topSliceText1{";
	echo "font-size: ".$text1_font_size_px."px;";
echo "}";
echo "#topSliceText2{";
	echo "font-size: ".$text2_font_size_px."px;";
echo "}";
echo "#topSliceText3{";
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
	echo "font-size: 12px;";
	echo "color: #".$defualt_p_text_color.";";
echo "}";


echo ".input_style{";
	echo "font-size: 12px;";
	echo "color: #000000;";
	echo "border: 1px solid #000000;";
	echo "width: 100%;";
	echo "font-size:20px;";
echo "}";
echo ".comb-form .form-group{width:40%; margin:5%; float:right;}
.submit-group{display:block; float:left;}
";


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
	height: 130px;
}
.galery-img img{width:100%;border-radius:5px;}
";

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

echo "
	.bottom-copyright .bottom-copyright-main{float:right; width:45%;}
	.bottom-copyright .bottom-copyright-leftside{float:left;}
	.bottom-copyright .bottom-copyright-leftside .bottom-copyright-item{float:right; margin-right:20px;}
	@media screen and (max-width: 960px) {
		.bottom-copyright .bottom-copyright-main{float:none; width:auto; clear:both;}
		.bottom-copyright .bottom-copyright-leftside{width:300px;margin:auto;float:none;clear:both;}
	}
	@media screen and (max-width: 480px) {
		.bottom-copyright .bottom-copyright-leftside{width:auto;}
		.bottom-copyright .bottom-copyright-leftside .bottom-copyright-item{float:none; margin-left:auto; margin-right:auto; margin-top:10px;}
	}
";