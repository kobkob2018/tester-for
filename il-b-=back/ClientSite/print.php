<?php
/* 
* Copyright © 2006 ILbiz. All Rights Reserved
* email:	webmaster@ilbiz.co.il
*
* 
* the index of the client site
*/

ob_start();
session_start();

require_once('/home/ilan123/domains/ilbiz.co.il/public_html/global_func/vars.php');


$m = ( $_GET['m'] == "" ) ? $_POST['m'] : $_GET['m'];
$uu = ( $_GET['unk'] == "" ) ? $_POST['unk'] : $_GET['unk'];

$abpath_unk_def = $_SERVER['DOCUMENT_ROOT']."/unk_def.php";
if( file_exists($abpath_unk_def) && !is_dir($abpath_unk_def) )
{
	require_once($abpath_unk_def);
	define('UNK',DEFINE_UNK);
	$from_fomain = 1;
}
else
{
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

	$sql = "select domain from users where unk = '".UNK."' and deleted = '0'";
	$res_domain = mysql_db_query(DB,$sql);
	$data_domain = mysql_fetch_array($res_domain);
	
	define('HTTP_PATH',"http://".$data_domain['domain']);
	define('SERVER_PATH',"/home/ilan123/domains/".$data_domain['domain']."/public_html");
	
	$http_path = "http://".$data_domain['domain'];
	$server_path = "/home/ilan123/domains/".$data_domain['domain']."/public_html";
	
// LANG select
$sql = "select lang_id from users where unk = '".UNK."' and deleted = '0'";
$res_UserLang = mysql_db_query(DB,$sql);
$data_UserLang = mysql_fetch_array($res_UserLang);

$sql_lang = "select * from site_langs where id = '".$data_UserLang['lang_id']."'";
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

// class
require_once("/home/ilan123/domains/ilbiz.co.il/public_html/global_func/DB.php");
require_once("/home/ilan123/domains/ilbiz.co.il/public_html/global_func/global_functions.php");
require_once("/home/ilan123/domains/ilbiz.co.il/public_html/global_func/forms_creator.php");
require_once("/home/ilan123/domains/ilbiz.co.il/public_html/global_func/images_resize.php");




require_once('functions.php');
require_once('strac_func.php');
require_once("/home/ilan123/domains/ilbiz.co.il/public_html/ClientSite/functions_08.php");
require_once("/home/ilan123/domains/ilbiz.co.il/public_html/ClientSite/functions_09.php");
require_once("/home/ilan123/domains/ilbiz.co.il/public_html/ClientSite/functions_10.php");
require_once("/home/ilan123/domains/ilbiz.co.il/public_html/ClientSite/client_castum_functions.php");
require_once("/home/ilan123/domains/ilbiz.co.il/public_html/ClientSite/client_castum_functions2.php");
require_once("/home/ilan123/domains/ilbiz.co.il/public_html/ClientSite/castum_functions.php");


// for gernral data about the user
$sql = "select * from users where unk = '".UNK."' and deleted = '0' and status = '0'";
$res_name = mysql_db_query(DB,$sql);
$data_name = mysql_fetch_array($res_name);

if( empty($data_name['id']) )
	die("");

if( $data_name['have_print'] == "0" )
	die("");

if( $data_name['have_homepage'] == 1)	// if user have homepage - then go to homepage, else - go to about page
{
	$m = ( $um == "" ) ? "hp" : $um;
	
	if( $data_name['hp_type'] == "1" && $m == "hp" )
		$with_out_RightMenu = 1;
}
else
{
	$m = ( $m == "" ) ? "text" : $m;
	$_GET['t'] = ( $_GET['t'] == "" && $_GET['lib'] == "" ) ? "text" : $_GET['t'];
}

// for settigns about the colors
$sql = "select * from user_site_settings where unk = '".UNK."' and deleted = '0' and status = '0'";
$res_settings = mysql_db_query(DB,$sql);
$data_settings = mysql_fetch_array($res_settings);


// get the name of the pages - empty name => not exits in the list
	
	$sql = "select * from user_words where unk = '".UNK."'";
	$res_words = mysql_db_query(DB,$sql);
	$data_words = mysql_fetch_array($res_words);
	
	$temp_word_hp = $word[LANG]['1_2_chapter_name_hp'];
	
	$temp_word_about = ( $data_words['id'] == "" ) ? $word[LANG]['1_2_chapter_name_about'] : stripslashes($data_words['word_about']);
	$temp_word_articels = ( $data_words['id'] == "" ) ? $word[LANG]['1_2_chapter_name_articels'] : stripslashes($data_words['word_articels']);
	$temp_word_products = ( $data_words['id'] == "" ) ? $word[LANG]['1_2_chapter_name_products'] : stripslashes($data_words['word_products']);
	$temp_word_gallery = ( $data_words['id'] == "" ) ? $word[LANG]['1_2_chapter_name_gallery'] : stripslashes($data_words['word_gallery']);
	$temp_word_yad2 = ( $data_words['id'] == "" ) ? $word[LANG]['1_2_chapter_name_yad2'] : stripslashes($data_words['word_yad2']);
	$temp_word_sales = ( $data_words['id'] == "" ) ? $word[LANG]['1_2_chapter_name_sales'] : stripslashes($data_words['word_sales']);
	$temp_word_video = ( $data_words['id'] == "" ) ? $word[LANG]['1_2_chapter_name_video'] : stripslashes($data_words['word_video']);
	$temp_word_wanted = ( $data_words['id'] == "" ) ? $word[LANG]['1_2_chapter_name_jobs'] : stripslashes($data_words['word_wanted']);
	$temp_word_contact = ( $data_words['id'] == "" ) ? $word[LANG]['1_2_chapter_name_contact'] : stripslashes($data_words['word_contact']);
	$temp_word_gb = ( $data_words['id'] == "" ) ? "" : stripslashes($data_words['word_gb']);
	

$arr_headlines = array(
	'text' => $temp_word_about,
	'articels' => $temp_word_articels,
	'products' => $temp_word_products,
	's_products' => $temp_word_products,
	'gallery' => $temp_word_gallery,
	'yad2' => $temp_word_yad2,
	's_yad2' => $temp_word_yad2,
	'sales' => $temp_word_sales,
	's_sales' => $temp_word_sales,
	'video' => $temp_word_video,
	's_video' => $temp_word_video,
	'jobs' => $temp_word_wanted,
	'gb' => $temp_word_gb,
	'contact' => $temp_word_contact,
	'get_thanks' => $word[LANG]['1_2_get_thanx_headline'],
);

	
	$abpath_temp2 = SERVER_PATH."/tamplate/".stripslashes($data_colors['top_silce_print']);
	
	if( file_exists($abpath_temp2) && !is_dir($abpath_temp2) )
	{
			$im_size = GetImageSize ($abpath_temp2); 
			$imageWidth = $im_size[0]; 
			$imageHeight = $im_size[1];
			
			$img_top_slice = "background=\"".HTTP_PATH."/tamplate/".stripslashes($data_colors['top_silce_print'])."\" width=\"".$imageWidth."\" height=\"".$imageHeight."\"";
	}
	else 
		$img_top_slice = "";
		
	
	###  define coin type in the site  ####
	switch( $data_words['coin_type'] )
	{
		case "0" :			$coin_type = "¤";					break;
		case "1" :			$coin_type = "$";									break;
		case "2" :			$coin_type = "&euro;";						break;
	}
	define('COIN',$coin_type);
?>

 
<html>
<head>
	
	<meta HTTP-EQUIV='Content-Type' CONTENT='text/html; charset=<?=$site_charset ?>'/>
	<title><?echo stripslashes($data_settings['site_title']);?></title>
	

<style type="text/css">
		
		.maintext{color: #000000;font-family: Arial, Helvetica, sans-serif;font-size: 12px;text-decoration: none;}
		.maintext a:link {text-decoration:underline;color:#000000;}
		.maintext a:active{text-decoration:none;color:#000000;}
		.maintext a:visited{text-decoration:underline;color:#000000;}
		.maintext a:hover{text-decoration:none;color:#000000;}
		
		.maintext_small{color: #000000;font-family: Arial, Helvetica, sans-serif;font-size: 10px;text-decoration: none;}

		.headline{color: #000000;font-family: Arial, Helvetica, sans-serif;text-decoration: none;}
		
		.page_headline{color: #000000;font-family: Arial, Helvetica, sans-serif;text-decoration: none;}

		.input_style	{color: #020202;font-family: Arial, Helvetica, sans-serif;font-size: 12px;text-decoration: none;border-left: 1px solid #000000;border-right: 1px solid #000000;border-top: 1px solid #000000;border-bottom: 1px solid #000000;background-color: #ffffff;width: 300px;height: 19px;}
		
		.submit_style	{color: #020202;font-family: Arial, Helvetica, sans-serif;font-size: 12px;text-decoration: none;border-left: 1px solid #000000;border-right: 1px solid #000000;border-top: 1px solid #000000;border-bottom: 1px solid #000000;background-color: #eaeaea;width: 100px;height: 19px;}
</style>

</head>


<body bgcolor="#ffffff" leftmargin="0" topmargin="0" rightmargin="0" bottommargin="0" marginwidth="0" marginheight="0">

<?
echo "<table border=\"0\" cellspacing=\"0\" cellpadding=\"0\" align=\"center\" dir=\"".$settings['dir']."\" width=\"600\">";

	if( !empty($img_top_slice) )
	{
		echo "<tr><td ".$img_top_slice."></td></tr>";
	}
	else
	{
		echo "<tr>
			<td bgcolor=\"#ffffff\">
					<table border=\"0\" cellspacing=\"0\" cellpadding=\"0\">
						<tr><tD height=\"3\" colspan=\"2\"></td></tr>
						<tr>
							<!-- LOGO -->
							<td width=\"150\" align=\"center\">".$img_logo."</td>
							<!-- Slogen and name of the biz -->
							<td>
								<table border=\"0\" cellspacing=\"0\" cellpadding=\"0\">
									<tr>
										<td width=\"35\"></td>
										<td><h1 class=\"headline\">".stripslashes($data_name['name'])."</h1></td>
									</tr>
									<tr>
										<td width=\"35\"></td>
										<td><h4 class=\"headline\">".stripslashes($data_settings['slogen'])."</h4></td>
									</tr>
								</table>
							</td>
						</tr>
						<tr><tD height=\"3\" colspan=\"2\"></td></tr>
					</table>
			</td>
		</tr>";
	}
	?>
	
	
	
	<tr>
		<td>
			<table border="0" cellspacing="0" cellpadding="0">
				<tr>
					<td width="600" valign="top">
						<table border="0" cellspacing="0" cellpadding="0">
							
							<?
								
								if( $data_name['have_headline'] == "0" )
								{
									echo "<tr><td colspan=\"3\" height=\"10\"></td></tr>";
									echo "<tr>";
										echo "<td width=\"35\">";
											foreach( $arr_headlines as $val => $key )	{
												if( $m == $val )
													if( $m == "text" && $_GET['t'] == "text")
														echo "<td valign=\"top\"><h4 class=\"page_headline\">".$key."</h4></td>";
													elseif( $m == "text" && $_GET['t'] != "text")
														echo "";
													else 
														echo "<td valign=\"top\"><h4 class=\"page_headline\">".$key."</h4></td>";
											}
											
											if( $m == "text" && $_GET['t'] != "text")
											{
												$sql_headline_type = "select name,type from content_pages where type = '".$_GET['t']."' and type != 'text' and name != '' and type != 'contact' and deleted = '0' and unk = '".UNK."'";
												$res_headline_type = mysql_db_query(DB,$sql_headline_type);
												$data_headline_type = mysql_fetch_array($res_headline_type);
												
												echo "<td valign=\"top\"><h4 class=\"page_headline\">".stripslashes($data_headline_type['name'])."</h4></td>";
											}
											echo "<td width=\"35\">";
										echo "<tr>";
								}
								else
								{
									echo "<tr><td colspan=\"3\" height=\"10\"></td></tr>";
								}
								?>
							
							<tr>
								<td width="35"></td>
								<td class="maintext" valign="top" width="555">
									<?
									
									echo get_content($m);
									
									?>
								</td>
								<td width="35"></td>
							</tr>
							<tr><td colspan="3" height="10"></td></tr>
						</table>
					</td>
				</tr>
			</table>
		</td>
	</tr>


<?
	echo stripslashes($data_name['googleAnalytics']);
?>

</body>
</html>

<script>
	window.print();
</script>
