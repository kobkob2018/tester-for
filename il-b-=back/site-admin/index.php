<?php
/* 
* Copyright © 2006 ILbiz. All Rights Reserved
* email:	webmaster@ilbiz.co.il
*
*/

//http://il.php.net/manual/en/ref.errorfunc.php#errorfunc.constants.errorlevels.e-warning
//error_reporting(E_ALL);
//ini_set("display_errors", 1);

if(isset($_REQUEST['quickedit'])){
	require('quickedit.php');
	exit();
}
require('../global_func/classes/class.shabat.php');
$shabbat = new Shabbat;
if(false){
	if( $shabbat->isShabbat() == "1" )	{ echo "לא ניתן להכנס למערכת הניהול ביום שבת, אנא חזרו במוצאי השבת";	die; }
	if( $shabbat->isHoliday() == "1" )	{ echo "לא ניתן להכנס למערכת הניהול בחג, אנא חזרו במוצאי החג";	die; }
}
$shabbat->getUpdateAlert();

ob_start();

$sesid = ( !empty($_GET['sesid']) ) ? $_GET['sesid'] : $_POST['sesid'];

define('SESID',$sesid);

if( SESID == "" )	{
	echo "<script>alert('יש להתחבר למערכת')</script>";
	echo "<script>window.location.href='login.php';</script>";
		exit;
}


require('../global_func/vars.php');


// cheake when the session start and end 

	$sql = "select user,date,ip from login_trace where session_idd = '".SESID."'";
	$res = mysql_db_query(DB,$sql);
	$data_login_trace = mysql_fetch_array($res);
	
	if( $data_login_trace['user'] != "" )
	{
		$data_login_trace_temp = explode("-",$data_login_trace['date']);
		$year = $data_login_trace_temp[0];
		$month =$data_login_trace_temp[1];
		
		$data_login_trace_temp2 = explode(" ",$data_login_trace_temp[2]);
		$day = $data_login_trace_temp2[0];
		
		$data_login_trace_temp3 = explode(":",$data_login_trace_temp2[1]);
		$hour = $data_login_trace_temp3[0];
		$minute = $data_login_trace_temp3[1];
		$secound = $data_login_trace_temp3[2];
		
		
		$DB_time1 = mktime($hour+24, $minute, $secound, $month, $day,  $year);
		$DB_time2 = date("YmdHis",$DB_time1);
		
		$expi = mktime(date("H"), date("i"), date("s"), date("m"), date("d"),  date("Y"));
		$page_expi = date("YmdHis",$expi);
		
		// check the date that is -30 min
		if($DB_time2 > $page_expi)	{
			$sql = "update login_trace set date = '".$page_expi."' where session_idd ='".$_REQUEST['sesid']."'";
			$res = mysql_db_query(DB,$sql);
		}
		else	{
			echo "<script>alert('לא נגעת בכילי המערכת במשך 30 דקות, יש להתחבר שוב');</script>";
			echo "<script>window.location.href='login.php'</script>";
			exit;
		}
	}
	else
	{
		echo "<script>alert('יש להתחבר למערכת');</script>";
		echo "<script>window.location.href='login.php'</script>";
	}
	
	if( $data_login_trace['ip'] != $_SERVER['REMOTE_ADDR'] )
	{
		echo "<script>alert('התראת אבטחה מספר 4517 יש ליצור קשר עם ההנהלה, או לנסות להתחבר שנית -- \n ".$data_login_trace['ip'] ."\n". $_SERVER['REMOTE_ADDR']."');</script>";
		echo "<script>window.location.href='login.php'</script>";
		exit;
	}

define('OID',$data_login_trace['user']);

$sql = "select auth,client_name from sites_owner where id = '".OID."'";
$res_auth = mysql_db_query(DB,$sql);
$date_auth = mysql_fetch_array($res_auth);

define('AUTH',$date_auth['auth']);
$client_name = $date_auth['client_name'];

// Class
require("../global_func/DB.php");
require("../global_func/global_functions.php");
require("../global_func/forms_creator.php");
require("../global_func/images_resize.php");
require("../global_func/new_images_resize.php");
require("../global_func/class.phpmailer.php");


require("../global_func/classes/class.ilbiz_net.php");
require("../global_func/classes/class.lead.php");

require("../global_func/classes/class.lead.sys.php");
require('../global_func/classes/class.estimate.statisitc.php');
require('../global_func/classes/class.estimate_stats.php');

include("/home/ilan123/domains/ilbiz.co.il/public_html/ClientSite/administration/fckeditor/fckeditor.php") ;



$main = ( $_REQUEST['main'] == "" ) ? "menu" : $_REQUEST['main'];

if( $_REQUEST['unk'] != "" )
{
	$sql = "select domain from users where deleted = 0 and unk = '".$_REQUEST['unk']."'";
	$res = mysql_db_query(DB,$sql);
	$data_domain = mysql_fetch_array($res);
	
	define('HTTP_PATH',"http://".$data_domain['domain']);
	define('SERVER_PATH',"/home/ilan123/domains/".$data_domain['domain']."/public_html");
}

define('HTTP_PATH_BANNERS',"http://ilbiz.co.il/newsite/images/up");
define('SERVER_PATH_BANNERS',"/home/ilan123/domains/ilbiz.co.il/public_html/newsite/images/up");

define('HTTP_PATH_NET_BANNERS',"http://ilbiz.co.il/ClientSite/site_banners/net_banners");
define('SERVER_PATH_NET_BANNERS',"/home/ilan123/domains/ilbiz.co.il/public_html/ClientSite/site_banners/net_banners");

// functions
require('get_content.php');
require('functions.php');

require('genral_site_func.php');
require('owners_func.php');
require('net_func.php');
require('langs_func.php');
require('cat_functions.php');
require('view_contacts.php');
require('mysave_functions.php');
require('bookkipng_functions.php');
require('estimate_stat_functions.php');
require('estimate_stat_functions_new.php');
require('functions_11.php');
require('e_card_functions.php');

if( isset($_GET['withouthtml']) && $_GET['withouthtml'] == '1' )
{
	echo get_content($main);
}
function hebdt($datetime_str){
	$date = new DateTime($datetime_str);
	return $date->format('d-m-Y H:i:s');
}
?>
<!DOCTYPE html>
<html>
<head>
	<?
	if( $_GET['main'] == "portal_settings" || $_GET['main'] == "edit_messagesSinon" )	{
		echo "<script src=\"options.fiels/htmldb_html_elements.js\" type=\"text/javascript\"></script>
		<link rel=\"stylesheet\" href=\"options.fiels/css_1.css\" type=\"text/css\" />
		<link rel=\"stylesheet\" href=\"options.fiels/css_2.css\" type=\"text/css\" />";
	}
	?>
	<meta HTTP-EQUIV='Content-Type' CONTENT='text/html; charset=windows-1255'/>
	<title>מערכת ניהול אתרים</title>
	
	<script type="text/javascript" src="script.js"></script>
	<script src="/global_func/prototype.js" type="text/javascript"></script>
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.7.2/jquery.min.js"></script>
	
	<?php if( $_GET['main'] == "user_profile" ): ?>
		<script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.8.21/jquery-ui.min.js"></script>
		<link href="/global_func/scripts/jQuery-Tagit-master/css/tagit.css" rel="stylesheet" type="text/css"/>
		<link href="http://ajax.googleapis.com/ajax/libs/jqueryui/1.8.21/themes/base/jquery-ui.css" rel="stylesheet" type="text/css"/>
		<script src="/global_func/scripts/jQuery-Tagit-master/js/jquery.ba-outside-events.min.js"></script>
		<script src="/global_func/scripts/jQuery-Tagit-master/js/tagit.js"></script>
		<script src="/global_func/scripts/jQuery-Tagit-master/js/autogrowinput.js"></script>
		
		
		
		<script src="http://html5demos.com/h5utils.js"></script>

	<?php endif; ?>
	
	<script>
	 var $j = jQuery.noConflict();
   
		(function($) {
			$(function() {
		   	<?php if( $_GET['main'] == "user_profile" ): ?>
					$('#editOnClick > ul').tagit({
						select:true,
						triggerKeys:['comma', 'enter', 'semicolon', 'tab'],	
						tagSource:[<?php
							$sql = "SELECT id, pro_name FROM ilbiz_products ORDER BY pro_name";
							$res_pro = mysql_db_query(DB, $sql);
							
							$pro = "";
							while( $data_pro = mysql_fetch_array($res_pro) )	{
								$gresh = str_replace("'" , "`" , $data_pro['pro_name']);
								$pro .= "{value: ".$data_pro['id'].",label: '".stripslashes($gresh)."'},";
							}
							echo substr($pro,0,-1);?>],
						editOnClick:true
						
					});
					
					
					$('ul.tagit').focusin(function () {
						if (!$('ul.tagit').hasClass('selected')) {
							$('ul.tagit').addClass('selected');
						}
					})
					
					.focusout(function (event) {
						$(this).removeClass('selected');
					});
					
					$('#show_user_ilbiz_products').click(function () {
						var select = $('ul.tagit').parent('div').find('select');
						var children = "";
						
						children += "<table cellpadding=0 cellspacing=0 border=0>";
						
							children += "</tr>";
								children += "<th width=200>שירות \ מוצר</th>";
								children += "<th width=20></th>";
								children += "<th width=50>מחיר</th>";
								children += "<th width=20></th>";
								children += "<th width=60>חיוב חודשי</th>";
								children += "<th width=20></th>";
								children += "<th width=110>מצריך בדיקה חודשית</th>";
							children += "</tr>";
							children += "<tr><td colspan=7 height=10></td></tr>";
						children += "</table>";
						
						select.children().each(function () {
							var pro_id = $(this).val()
							var pro_name = $(this).text();
							
							$.ajax({
								type: "GET",
								url: "ajax.php",
								data: { sesid: "<?php echo SESID; ?>" , main: "load_user_ilbiz_products" , unk: "<?php echo $_GET['unk']; ?>", pid: pro_id , prodName: pro_name }
								}).done(function( msg ) {
									$('#productSelected').append(msg);
								});
							});
							
						
						
						$('#productSelected').html(children);
					})
					
					
					
					
				<?php endif; ?>
			});
			
		})(jQuery);
		
		
	</script>
	<style>
		.border1{
			border : 1px solid #000000;
		}
		
		.maintext	{
			color: #000000;
			font-family: sans-serif;
			font-size: 12px;
			text-decoration: none;
		}

		.maintext a:link {text-decoration:underline;color:navy;}
		.maintext a:active{text-decoration:underline;color:#800000;}
		.maintext a:visited{text-decoration:underline;color:navy;}
		.maintext a:hover{text-decoration:underline;color:#800000;}
		
		.maintextBold	{
			color: #000000;
			font-family: sans-serif;
			font-size: 12px;
			text-decoration: none;
			font-weight:bold;
		}
		
		.tesk_subject_tr_close	{
			color: #000000;
			font-family: sans-serif;
			font-size: 12px;
			text-decoration: none;
			border: 0px solid #666666;
			padding: 2px;
			background-color: #a8c8d5;
		}
		
		.tesk_subject_tr_open	{
			border: 1px solid #666666;
			border-bottom: 0px solid #666666;
			padding: 2px;
			background-color: #a8c8d5;
		}
		.tesk_subject_tr_open_edit	{
			border: 1px solid #666666;
			border-bottom: 0px solid #666666;
			padding: 2px;
			background-color: #a8c8d5;
		}
		.tesk_content_tr	{
			color: #000000;
			font-family: sans-serif;
			font-size: 12px;
			text-decoration: none;
			border: 1px solid #666666;
			border-top: 0px solid #666666;
			background-color: #e9e9e9;
		}
		

		.headline	{
			color: #000000;
			font-family: sans-serif;
			font-size: 14px;
			text-decoration: none;
			font-weight: bold;
		}
		
		.input_style	{
			color: #000000;
			font-family: sans-serif;
			font-size: 12px;
			text-decoration: none;
			border-bottom: 1px solid #666666;
			border-top: 1px solid #666666;
			border-right: 1px solid #666666;
			border-left: 1px solid #666666;
			background-color: #eaeaea;
			width: 300px;
			height: 19px;
		}
		
		.textarea_style	{
			color: #000000;
			font-family: sans-serif;
			font-size: 12px;
			text-decoration: none;
			border-bottom: 1px solid #666666;
			border-top: 1px solid #666666;
			border-right: 1px solid #666666;
			border-left: 1px solid #666666;
			background-color: #eaeaea;
			width: 300px;
			height: 250px;
		}
		
		.textarea_style_summary	{
			color: #000000;
			font-family: sans-serif;
			font-size: 12px;
			text-decoration: none;
			border-bottom: 1px solid #666666;
			border-top: 1px solid #666666;
			border-right: 1px solid #666666;
			border-left: 1px solid #666666;
			background-color: #eaeaea;
			width: 450px;
			height: 100px;
		}
		
		.submit_style	{
			color: #000000;
			font-family: sans-serif;
			font-size: 12px;
			text-decoration: none;
			border-bottom: 1px solid #666666;
			border-top: 1px solid #666666;
			border-right: 1px solid #666666;
			border-left: 1px solid #666666;
			background-color: #eaeaea;
			width: 100px;
			height: 19px;
		}
		
		.inputStyleNew	{
			font-family: sans-serif;
			font-size: 12px;
			background-color: #ffffff;
			border: 1px solid #cccccc;
			-webkit-border-radius: 3px;
			-moz-border-radius: 3px;
			border-radius: 3px;
		}
		.inputStyleNew:focus {
			border-color: rgba(82, 168, 236, 0.8);
			outline: 0;
			outline: thin dotted \9;
			/* IE6-9 */
		
			-webkit-box-shadow: inset 0 1px 1px rgba(0, 0, 0, .075), 0 0 8px rgba(82, 168, 236, .6);
			-moz-box-shadow: inset 0 1px 1px rgba(0, 0, 0, .075), 0 0 8px rgba(82, 168, 236, .6);
			box-shadow: inset 0 1px 1px rgba(0, 0, 0, .075), 0 0 8px rgba(82, 168, 236, .6);
		}
		
		
		UL.tagit {
			margin-left: 0px;
			float: left;
			background-color: #ffffff;
			border: 1px solid #cccccc;
			-webkit-border-radius: 3px;
			-moz-border-radius: 3px;
			border-radius: 3px;
			-webkit-box-shadow: inset 0 1px 1px rgba(0, 0, 0, 0.075);
			-moz-box-shadow: inset 0 1px 1px rgba(0, 0, 0, 0.075);
			box-shadow: inset 0 1px 1px rgba(0, 0, 0, 0.075);
			-webkit-transition: border linear 0.2s, box-shadow linear 0.2s;
			-moz-transition: border linear 0.2s, box-shadow linear 0.2s;
			-ms-transition: border linear 0.2s, box-shadow linear 0.2s;
			-o-transition: border linear 0.2s, box-shadow linear 0.2s;
			transition: border linear 0.2s, box-shadow linear 0.2s;
		}
		
		UL.tagit.selected {
			border-color: rgba(82, 168, 236, 0.8);
			outline: 0;
			outline: thin dotted \9;
			/* IE6-9 */
		
			-webkit-box-shadow: inset 0 1px 1px rgba(0, 0, 0, .075), 0 0 8px rgba(82, 168, 236, .6);
			-moz-box-shadow: inset 0 1px 1px rgba(0, 0, 0, .075), 0 0 8px rgba(82, 168, 236, .6);
			box-shadow: inset 0 1px 1px rgba(0, 0, 0, .075), 0 0 8px rgba(82, 168, 236, .6);
		}
		
		DIV.example {
		    margin-top: 30px;
		}
		
		UL.tagit {
		    float: none;
		}
		
		
	</style>

</head>

<body leftmargin="0" topmargin="10" rightmargin="0" bottommargin="0" marginwidth="0" marginheight="0">

<?php 
	if(isset($_REQUEST['unk'])){
		$user_sql = "SELECT * FROM users WHERE unk = '".$_REQUEST['unk']."'";
		$user_res = mysql_db_query(DB,$user_sql);
		$user_data = mysql_fetch_array($user_res);
		$user_name = $user_data['name'];
		$user_full_name = $user_data['full_name']; 
		$user_email = $user_data['email']; 
		$user_phone = $user_data['phone']; 
		$user_domain = $user_data['domain']; 
		?>
		<div id="user_info_cube" style="position:fixed; left:0px; width:200px; background:#f5f1f1; padding:5px; text-align:right;direction:rtl;">
			
			עבודה על לקוח: <br/>
			<?php echo $user_name; ?><br/>
			<?php echo $user_full_name; ?><br/>
			<?php echo $user_email; ?><br/>
			<?php echo $user_phone; ?><br/>
			<?php echo $user_domain; ?><br/>
			<a href='javascript://' onclick="close_user_info_cube();">סגור<a/>
		</div>
		<div id="user_info_cube_opener" style="display:none; position:fixed; left:0px; width:10px; background:#f5f1f1; padding:5px; text-align:right;direction:rtl;">
			<a href='javascript://' onclick="open_user_info_cube();">i<a/>
		</div>		
		<script type="text/javascript">
			function close_user_info_cube(){
				jQuery(function($){
					$("#user_info_cube").hide();
					$("#user_info_cube_opener").show();
				});
			}
			function open_user_info_cube(){
				jQuery(function($){
					$("#user_info_cube").show();
					$("#user_info_cube_opener").hide();
				});
			}			
		</script>
		<?php
	}
?>
<table border="0" cellspacing="0" cellpadding="0" align="center" dir="rtl" width="1000" id="main_admin_table_1000_px">
	<tr>
		<td>
			<table border="0" cellspacing="0" cellpadding="0">
				<tr>
					<td style="background:yellow; padding:3px;text-align:center;"><?echo $client_name;?></td>
				</tr>
				<tr>
					<td class="headline"><?echo get_headline($main);?></td>
				</tr>
				<tr><td height="15"></td></tr>
				<tr>
					<td><?echo get_content($main);?></td>
				</tr>
			</table>
		</td>
	</tr>
</table>

</body>
</html>
