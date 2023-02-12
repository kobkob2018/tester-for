<?php
/* 
* Copyright © 2006 ILbiz. All Rights Reserved
* email:	webmaster@ilbiz.co.il
* 
* its the index, the right menu, function for rigth menu,
* style, scripts and all the function that site required
*/

ob_start();

define('UNK',$_REQUEST['unk']);
define('SESID',$_REQUEST['sesid']);

//check if the user login and if the session its ok
if( UNK == "" || SESID == "" )	{
	echo "<script>alert('יש להתחבר למערכת')</script>";
	echo "<script>window.location.href='login.php';</script>";
		exit;
}


require('../../global_func/vars.php');


// cheake when the session start and end 

	if( $_COOKIE['panelAdmin'] == "provide_insert_to_user_admin" )
	{
		$sql = "select user,date,ip from login_trace where session_idd = '".$_REQUEST['sesid']."'";
		$res = mysql_db_query(DB,$sql);
		$data_login_trace = mysql_fetch_array($res);
	}
	else
	{
		$sql = "select user,date,ip,auth_id from login_trace where session_idd = '".$_REQUEST['sesid']."' and user = '".$_REQUEST['unk']."'";
		$res = mysql_db_query(DB,$sql);
		$data_login_trace = mysql_fetch_array($res);
	}
	
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
	
	if($DB_time2 > $page_expi)	{
		$sql = "update login_trace set date = '".$page_expi."' where session_idd ='".SESID."'";
		$res = mysql_db_query(DB,$sql);
	}
	else	{
		echo "<script>alert('לא נגעת בכילי המערכת במשך 40 דקות, יש להתחבר שוב');</script>";
		echo "<script>window.location.href='login.php'</script>";
		exit;
	}


// Class
require("../../global_func/DB.php");
require("../../global_func/global_functions.php");
require("../../global_func/forms_creator.php");
require("../../global_func/new_images_resize.php");
include("fckeditor/fckeditor.php") ;

// functions
require('get_content.php');
require('general_functions.php');
require('functions.php');
require('site_settings_functions.php');
require('gallery_functions.php');




$main = ( $_REQUEST['main'] == "" ) ? "menu" : $_REQUEST['main'];

?>
<html xmlns="http://www.w3.org/1999/xhtml">
<html>
<head>
	<meta HTTP-EQUIV='Content-Type' CONTENT='text/html; charset=windows-1255'/>
	<title>..::  הוספה/עדכון קטגוריות  ::..</title>
	<script src="options.fiels/htmldb_html_elements.js" type="text/javascript"></script>
	<link rel="stylesheet" href="options.fiels/css_1.css" type="text/css" />
	<link rel="stylesheet" href="options.fiels/css_2.css" type="text/css" />	
	
	
	<style>
		BODY	{
			BACKGROUND-COLOR: #eeeeee;
		}
		
		.right_headline	{
			color: #343434;
			font-family: sans-serif;
			font-size: 12px;
			text-decoration: none;
			font-weight: bold;
		}
		
		.right_menu	{
			color: #6b6b6b;
			font-family: sans-serif;
			font-size: 12px;
			text-decoration: none;
		}
		
		.right_menu a:link {text-decoration:none;color:#6b6b6b;}
		.right_menu a:active{text-decoration:underline;color:#000000;}
		.right_menu a:visited{text-decoration:none;color:#6b6b6b;}
		.right_menu a:hover{text-decoration:underline;color:#000000;}
		
		.maintext	{
			color: #000000;
			font-family: sans-serif;
			font-size: 12px;
			text-decoration: none;
		}

		.maintext a:link {text-decoration:underline;color:#000000;}
		.maintext a:active{text-decoration:underline;color:#000000;}
		.maintext a:visited{text-decoration:underline;color:#000000;}
		.maintext a:hover{text-decoration:underline;color:#000000;}
		
		.maintext_small	{
			color: #000000;
			font-family: sans-serif;
			font-size: 10px;
			text-decoration: none;
		}

		.maintext_small a:link {text-decoration:underline;color:#000000;}
		.maintext_small a:active{text-decoration:underline;color:#000000;}
		.maintext_small a:visited{text-decoration:underline;color:#000000;}
		.maintext_small a:hover{text-decoration:underline;color:#000000;}
		
		.headline	{
			color: #000000;
			font-family: sans-serif;
			font-size: 13px;
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
			/**background-color: #eaeaea;*/
			background-color: #ffffff;
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
			background-color: #ffffff;
			width: 450px;
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
			background-color: #ffffff;
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
			background-color: #ffffff;
			width: 100px;
			height: 19px;
		}
</style>
</head>
<script>
	
	function can_i_del()  {
		aa = confirm("?האם את/ה בטוח/ה");
		if(aa == true)
			return true;
		else
			return false;
	}

</script>


<body leftmargin="0" topmargin="5" rightmargin="0" bottommargin="0" marginwidth="0" marginheight="0">

<table border="0" cellspacing="0" cellpadding="0" class="right_menu" dir="rtl" align="center" width='550'>
	<tr>
		<td valign="top">
<?
	$remove_hidden_cats_sql = " and hidden=0 ";
	if(true){
		$remove_hidden_cats_sql = "  ";
	}
	$sql = "select cat_name,id from biz_categories where father = 0 and status = 1 ".$remove_hidden_cats_sql." ORDER BY place";
	$res_father = mysql_db_query(DB,$sql);
	
	$cat_list = "<table border=\"0\" cellpadding=\"0\" cellspacing=\"0\" width=\"550\">";
		$cat_list .= "<tr>";
			$cat_list .= "<td style=\"background-color:#cccccc;\">";
			
				$cat_list .= "<ul style=\"list-style:none\" class=\"dhtmlTree\">";
					while( $data_father = mysql_fetch_array($res_father) )
					{
						
						$sql = "select cat_id from module_cats_belong_10service where x_id = '".$_GET['xid']."' AND x_type = '".$_GET['xtype']."' and cat_id = '".$data_father['id']."'";
						$res_cat_id = mysql_db_query(DB,$sql);
						$data_cat_id = mysql_fetch_array($res_cat_id);
						
						$selected1 = ( $data_cat_id['cat_id'] == $data_father['id'] ) ? "checked" : "";
						
						$cat_list .= "<li><img src=\"options.fiels/plus.jpg\" onclick=\"htmldb_ToggleWithImage(this,'treeCAT".$data_father['id']."')\" class=\"pseudoButtonInactive\" />
						".stripslashes($data_father['cat_name'])."
						<input type=\"checkbox\" name=\"select_cat[".$data_father['id']."]\" value=\"1\" ".$selected1.">
						</li>";
						
						$sql = "select cat_name,id from biz_categories where father = ".$data_father['id']." and status = 1 ".$remove_hidden_cats_sql." ORDER BY place";
						$res_father_cat = mysql_db_query(DB,$sql);
						
						$cat_list .= "<ul id=\"treeCAT".$data_father['id']."\" htmldb:listlevel=\"2\" style=\"padding-right:15px;list-style:none;display:none;\" class=\"dhtmlTree\">";
							while( $data_father_cat = mysql_fetch_array($res_father_cat) )
							{
								$sql = "select cat_id from module_cats_belong_10service where x_id = '".$_GET['xid']."' AND x_type = '".$_GET['xtype']."' and cat_id = '".$data_father_cat['id']."'";
								$res_cat_id = mysql_db_query(DB,$sql);
								$data_cat_id = mysql_fetch_array($res_cat_id);
								
								$selected2 = ( $data_cat_id['cat_id'] == $data_father_cat['id'] ) ? "checked" : "";
						
								$sql = "select cat_name,id from biz_categories where father = '".$data_father_cat['id']."' and status = '1' ".$remove_hidden_cats_sql." ORDER BY place";
								$res_father_tat_cat = mysql_db_query(DB,$sql);
								$num_father_tat_cat = mysql_num_rows($res_father_tat_cat);
								
								if( $num_father_tat_cat > 0 )
								{
									$cat_list .= "<li>
									<img src=\"options.fiels/plus.jpg\" onclick=\"htmldb_ToggleWithImage(this,'treeF_CAT".$data_father_cat['id']."')\" class=\"pseudoButtonInactive\" />
									".$data_father_cat['cat_name']."
									<input type=\"checkbox\" name=\"select_cat[".$data_father_cat['id']."]\" value=\"1\" ".$selected2."></li>";
									
									$cat_list .= "<ul id=\"treeF_CAT".$data_father_cat['id']."\" htmldb:listlevel=\"3\" style=\"padding-right:15px;list-style:none;display:none;\" class=\"dhtmlTree\">";
									while( $data_father_tat_cat = mysql_fetch_array($res_father_tat_cat) )
									{
										$sql = "select cat_id from module_cats_belong_10service where x_id = '".$_GET['xid']."' AND x_type = '".$_GET['xtype']."' and cat_id = '".$data_father_tat_cat['id']."'";
										$res_cat_id = mysql_db_query(DB,$sql);
										$data_cat_id = mysql_fetch_array($res_cat_id);
										
										$selected3 = ( $data_cat_id['cat_id'] == $data_father_tat_cat['id'] ) ? "checked" : "";
										
										$cat_list .= "<li><img src=\"options.fiels/node.jpg\" /><input type=\"checkbox\" name=\"select_cat[".$data_father_tat_cat['id']."]\" value=\"1\" ".$selected3.">".$data_father_tat_cat['cat_name']."</li>";
									}
									$cat_list .= "</ul>";
								}
								else
								{
									$cat_list .= "<li><img src=\"options.fiels/node.jpg\" />
									<input type=\"checkbox\" name=\"select_cat[".$data_father_cat['id']."]\" value=\"1\" ".$selected2.">".$data_father_cat['cat_name']."</li>";
								}
							}
						$cat_list .= "</ul>";
					}
				$cat_list .= "</ul>";
			$cat_list .= "</td>";
		$cat_list .= "</tr>";
	$cat_list .= "</table>";
	
	
	$form_arr = array(
		array("hidden","main","SetCatUniversal"),
		array("hidden","xid",$_GET['xid']),
		array("hidden","xtype",$_GET['xtype']),
		array("hidden","sesid",SESID),
		array("hidden","unk",UNK),
		array("hidden","data_arr[unk]",UNK),
		array("hidden","type",$_GET['type']),
		
		array("blank",$cat_list),
		
		
		
		array("submit","submit","שמירה", "class='submit_style'")
	);
	
// שדות חובה
$more = "class='maintext'";

echo "<table border=\"0\" cellspacing=\"0\" cellpadding=\"0\" class=\"maintext\" width='400'>";
		
		echo "<tr>";
			echo "<td>".FormCreator::create_form($form_arr,"index.php", $more, $mandatory_fields)."</td>";
		echo "</tr>";
		
		
	echo "</table>";
?>
		</td>
	</tr>
</table>

</body>
</html>
