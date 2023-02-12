<?php

function gallery_grid()
{
	global $word;
	
	$sql = "select * from user_gallery_cat where unk = '".$_REQUEST['unk']."' and deleted = '0' and active = '0' limit 1";
	$res = mysql_db_query(DB,$sql);
	$data_cat = mysql_fetch_array($res);
	
	$temp_cat = ( $_GET['cat'] ) ? $_GET['cat'] : $data_cat['id'];
	$temp_cat = ( $_GET['show_with_out_cat'] == "1" ) ? "0" : $temp_cat;
	
	$sql = "select * from user_gallery_images where unk = '".$_REQUEST['unk']."' and cat = '{$temp_cat}' and deleted = '0' order by place, id desc ";
	$res = mysql_db_query(DB,$sql);
	
	$sql2 = "select * from user_gallery_cat where deleted = 0 and unk = '".$_REQUEST['unk']."' order by id";
	$res2 = mysql_db_query(DB,$sql2);
	
	
	echo "<table border=\"0\" cellspacing=\"0\" cellpadding=\"0\">";
		if( UNK != "285240640927706447" )
		{
		echo "<tr>";
			echo "<td width=\"5\">";
			echo "<td>";
				echo "<table border=\"0\" cellspacing=\"0\" cellpadding=\"0\" class=\"maintext\">";
					echo "<tr>";
						echo "<td>";
							echo $word[LANG]['choose_sub_tobic'].":&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
							while( $data2 = mysql_fetch_array($res2))
							{
								$b_s = ( $temp_cat == $data2['id'] ) ? "<b>" : "<a href=\"?main=gallery_grid&type=gallery&cat=".$data2['id']."&unk=".$_REQUEST['unk']."&sesid=".$_REQUEST['sesid']."\" class=\"maintext\"><u>";
								$b_e = ( $temp_cat == $data2['id'] ) ? "</b>" : "</u></a>";
								echo $b_s.htmlspecialchars(stripslashes($data2['name'])).$b_e."&nbsp;&nbsp;&nbsp;";
							}
							
							$b_s = ( $_GET['show_with_out_cat'] == "1" ) ? "<b>" : "<a href=\"?main=gallery_grid&type=gallery&cat=".$data2['id']."&show_with_out_cat=1&unk=".$_REQUEST['unk']."&sesid=".$_REQUEST['sesid']."\" class=\"maintext\"><u>";
							$b_e = ( $_GET['show_with_out_cat'] == "1") ? "</b>" : "</u></a>";
							echo "<br>".$b_s."תמונות ללא שיוך לנושא - לא יופיעו באתר ויש לשייכם לנושא".$b_e."&nbsp;&nbsp;&nbsp;";
							
						echo "</td>";
					echo "</tr>";
				echo "</table>";
			echo "</td>";
			echo "<td width=\"5\">";
		echo "</tr>";
		}
		
		echo "<tr><td height=\"10\"></td></tr>";
		
		echo "<tr>";
			echo "<td width=\"5\">";
			echo "<td>";
				$counter = 0;
				
				echo "<table border=\"0\" cellspacing=\"0\" cellpadding=\"0\">";
				
					while( $data = mysql_fetch_array($res))
					{
						if( $counter%6 == 0 )
						echo "<tr>";
						
							$abpath_temp_unlink = SERVER_PATH."/gallery/".$data['img'];
							
							
							echo "<td height='100%'>";
								echo "<table border=\"0\" cellspacing=\"0\" cellpadding=\"0\">";
									echo "<tr>";
											if( file_exists($abpath_temp_unlink) && !is_dir($abpath_temp_unlink) )
												echo "<td align='center'><a href=\"?main=edit_picture&type=gallery&cat=".$temp_cat."&show_with_out_cat=".$_REQUEST['show_with_out_cat']."&row_id=".$data['id']."&unk=".$_REQUEST['unk']."&sesid=".$_REQUEST['sesid']."\"><img src=\"".HTTP_PATH."/gallery/".$data['img']."\" border=\"0\"></a></td>";
									
									echo "</tr>";
									echo "<tr>";
										echo "<td valign='bottom' align='center'><a href='?main=edit_picture&cat=".$temp_cat."&show_with_out_cat=".$_REQUEST['show_with_out_cat']."&type=gallery&row_id=".$data['id']."&unk=".$_REQUEST['unk']."&sesid=".$_REQUEST['sesid']."' class='maintext'><nobr>".$word[LANG]['edit_image']."</nobr></a></td>";
									echo "</tr>";
									echo "<tr><td height='3'></td></tr>";
									echo "<tr>";
										echo "<td valign='bottom' align='center'><a href='?main=del_DB_pic&cat=".$temp_cat."&show_with_out_cat=".$_REQUEST['show_with_out_cat']."&type=gallery&row_id=".$data['id']."&unk=".$_REQUEST['unk']."&sesid=".$_REQUEST['sesid']."' class='maintext' onclick='can_i_del()'><nobr>".$word[LANG]['delete_image']."</nobr></a></td>";
									echo "</tr>";
									echo "<tr><td height='10'></td></tr>";
								echo "</table>";		
							echo "</td>";
							echo "<td width=\"20\"></td>";
						
						$counter++;
						if( $counter%6 == 0 ){
							echo "</tr>";
							echo "<tr><td height='10' colspan='20'></td></tr>";
						}
						
					
					}
				echo "</table>";
			echo "</td>";
			echo "<td width=\"5\">";
		echo "</tr>";
	echo "</table>";
}


function edit_picture()
{
	global $word;
	
	$table = "user_gallery_images";
	
	if( $_GET['row_id'] )
	{
		$sql = "select * from {$table} where deleted = '0' and id = '".$_GET['row_id']."' and unk = '".$_REQUEST['unk']."'";
		$res = mysql_db_query(DB,$sql);
		$data = mysql_fetch_array($res);
	}
	
	for( $i=1 ; $i<=50 ; $i++ )
		$place[$i] = $i;
	
		
	if( UNK != '285240640927706447' )
	{
		$sql2 = "select * from user_gallery_cat where deleted = '0' and unk = '".$_REQUEST['unk']."' and active = '0' order by place";
		$res2 = mysql_db_query(DB,$sql2);
		$num_rows2 = mysql_num_rows($res2);
		
		$count_gl = 0;
		while( $data2 = mysql_fetch_array($res2) )
		{
			$temp_id = $data2['id'];
			$cat[$temp_id] .= stripslashes($data2['name']);
			$count_gl++;
		}
	
		if( $count_gl == 0 )
			{
				echo $word[LANG]['least_one_sub_topic'];
					exit;
			}
	}
	else
		$num_rows2 = 2;
	
	$sql = "select gall_sm_pic_height, gall_sm_pic_width, gall_lr_pic_width, gall_lr_pic_height, have_extraL_img_gl FROM users where unk = '".$_REQUEST['unk']."'";
	$res_user = mysql_db_query(DB,$sql);
	$user_settings = mysql_fetch_array($res_user);
	
	$gall_sm_pic_width = ( $user_settings['gall_sm_pic_width'] != "" ) ? $user_settings['gall_sm_pic_width'] : "75";
	$gall_sm_pic_height = ( $user_settings['gall_sm_pic_height'] != "" ) ? $user_settings['gall_sm_pic_height'] : "50";
	
	$gall_lr_pic_width = ( $user_settings['gall_lr_pic_width'] != "" ) ? $user_settings['gall_lr_pic_width'] : "405";
	$gall_lr_pic_height = ( $user_settings['gall_lr_pic_height'] != "" ) ? $user_settings['gall_lr_pic_height'] : "390";
	
	
	if( UNK == "285240640927706447" )
	{
		if( $data['id'] != "" )
			$cats = array("blank","<a href='setCatsUniversal.php?xid=".$data['id']."&xtype=3&unk=".UNK."&sesid=".SESID."' class='maintext' target='_blank'>עדכן קטגוריות</a>");
	
		$sql = "select u.id, u.name FROM 
				users as u,
				user_cat as uc,
				biz_categories as bc ,
				user_extra_settings as us
					WHERE 
						us.unk=u.unk AND
						u.deleted=0 AND
						u.status=0 AND
					  u.end_date > NOW() AND
						us.belongTo10service=1 AND
						u.id=uc.user_id AND
						uc.cat_id=bc.id AND
						bc.status=1
				 GROUP BY u.id";
			$res_choosenClient = mysql_db_query(DB, $sql);
			
			$belongToUser10service = array();
			while( $val_choosenClient = mysql_fetch_array($res_choosenClient) )
			{
				$clientId = $val_choosenClient['id'];
				$belongToUser10service[$clientId] = stripslashes($val_choosenClient['name']);
			}
			
			$belongToUser10service = array("select","belongToUser10service[]",$belongToUser10service,"* שייך ללקוח",$data['belongToUser10service'],"data_arr[belongToUser10service]", "class='input_style'");
			
			$headline = array("text","data_arr[headline]",$data['headline'],$word[LANG]['title'], "class='input_style'");
	}
	else
		$cats = array("select","cat[]",$cat,"* ".$word[LANG]['ass_to_topic'],stripslashes($data['cat']),"data_arr[cat]", "class='input_style'");
	
	$sql = "select belongTo10service from user_extra_settings where unk = '".UNK."'";
	$res_extra = mysql_db_query(DB,$sql);
	$data_extra = mysql_fetch_array($res_extra);
	
	$will_be_display_10service[0] = "לא";
	$will_be_display_10service[1] = "כן";
	
	$will_be_display_10service_Arr = ( $data_extra['belongTo10service'] == "1" ) ? array("select","will_be_display_10service[]",$will_be_display_10service,"יופיע בדף שלי באתר שירות 10",$data['will_be_display_10service'],"data_arr[will_be_display_10service]", "class='input_style'") : "";
	
				
	$goto = ( $_GET['row_id'] ) ? "update_DB_pic_gellery" : "add_DB_pic_gellery";
	
	$img3field_type = ( $user_settings['have_extraL_img_gl'] == "1"  ) ? "new_file3" : "hidden";
	$form_arr = array(
				array("hidden","main","{$goto}"),
				array("hidden","type","gallery"),
				array("hidden","record_id",$_GET['row_id']),
				array("hidden","sesid",$_GET['sesid']),
				array("hidden","data_arr[unk]",$_GET['unk']),
				array("hidden","unk",$_GET['unk']),
				array("hidden","cat",$_GET['cat']),
				array("hidden","show_with_out_cat",$_GET['show_with_out_cat']),
				array("hidden","table",$table),
				
				array("hidden","gall_sm_width",$gall_sm_pic_width),
				array("hidden","gall_sm_height",$gall_sm_pic_height),
				
				array("hidden","gall_lr_width",$gall_lr_pic_width),
				array("hidden","gall_lr_height",$gall_lr_pic_height),
				
				$headline,
				array("new_file","img",$data['img'],"* ".$word[LANG]['picture'], "gallery", "&table=".$table."&GOTO_type=gallery&GOTO_main=gallery_grid"),
				array("new_file2","img2",$data['img2'],"* ".$word[LANG]['large_image'], "gallery", "&table=".$table."&GOTO_type=gallery&GOTO_main=gallery_grid"),
				array($img3field_type,"img3",$data['img3'],$word[LANG]['huge_img'], "gallery", "&table=".$table."&GOTO_type=gallery&GOTO_main=gallery_grid"),
				
				$cats,
				$belongToUser10service ,
				$will_be_display_10service_Arr,
				array("select","place[]",$place,$word[LANG]['pic_place_at_list'],$data['place'],"data_arr[place]", "class='input_style''"),
				array("textarea","data_arr[content]",$data['content'],$word[LANG]['desc_picture'], "class='input_style' style='width: 300px; height: 100px;'"),
				
				array("submit","submit",$word[LANG]['save'], "class='submit_style'")
	);
	if( !$_GET['row_id'] )
		$mandatory_fields = array("img","data_arr[cat]","img2");
	$more = "class='maintext'";
	if( $num_rows2 > 0 )
		echo FormCreator::create_form($form_arr,"index.php", $more, $mandatory_fields);
	else
		echo "<b>".$word[LANG]['least_one_category']."</b>";
}



function add_5_pics()
{
	$table = "user_gallery_images";
	
	for( $i=1 ; $i<=50 ; $i++ )
		$place[$i] = $i;
	
	
	$sql2 = "select * from user_gallery_cat where deleted = '0' and unk = '".$_REQUEST['unk']."' and active = '0' order by place";
	$res2 = mysql_db_query(DB,$sql2);
	$num_rows2 = mysql_num_rows($res2);
	
	while( $data2 = mysql_fetch_array($res2) )
	{
		$temp_id = $data2['id'];
		$cat[$temp_id] .= $data2['name'];
	}
	
	
	
	$goto = ( $_GET['row_id'] ) ? "update_DB_pic_gellery" : "add_DB_pic_gellery";
	$form_arr = array(
				array("hidden","main","add_DB_5_pics_gellery"),
				array("hidden","type","gallery"),
				array("hidden","sesid",$_GET['sesid']),
				array("hidden","data_arr[unk]",$_GET['unk']),
				array("hidden","unk",$_GET['unk']),
				array("hidden","table",$table),
				
				array("new_file","img_1",$data['img'],"תמונה", "gallery", "&table=".$table."&GOTO_type=gallery&GOTO_main=gallery_grid"),
				array("new_file2","img2_1",$data['img2'],"תמונה גדולה", "gallery", "&table=".$table."&GOTO_type=gallery&GOTO_main=gallery_grid"),
				array("select","cat[]",$cat,"שיוך לקטגוריה",$data['cat'],"data_arr[cat_1]", "class='input_style''"),
				
				array("new_file","img_2",$data['img'],"תמונה", "gallery", "&table=".$table."&GOTO_type=gallery&GOTO_main=gallery_grid"),
				array("new_file2","img2_2",$data['img2'],"תמונה גדולה", "gallery", "&table=".$table."&GOTO_type=gallery&GOTO_main=gallery_grid"),
				array("select","cat[]",$cat,"שיוך לקטגוריה",$data['cat'],"data_arr[cat_2]", "class='input_style''"),
				
				
				array("new_file","img_3",$data['img'],"תמונה", "gallery", "&table=".$table."&GOTO_type=gallery&GOTO_main=gallery_grid"),
				array("new_file2","img2_3",$data['img2'],"תמונה גדולה", "gallery", "&table=".$table."&GOTO_type=gallery&GOTO_main=gallery_grid"),
				array("select","cat[]",$cat,"שיוך לקטגוריה",$data['cat'],"data_arr[cat_3]", "class='input_style''"),
				
				
				array("new_file","img_4",$data['img'],"תמונה", "gallery", "&table=".$table."&GOTO_type=gallery&GOTO_main=gallery_grid"),
				array("new_file2","img2_4",$data['img2'],"תמונה גדולה", "gallery", "&table=".$table."&GOTO_type=gallery&GOTO_main=gallery_grid"),
				array("select","cat[]",$cat,"שיוך לקטגוריה",$data['cat'],"data_arr[cat_4]", "class='input_style''"),
				
				
				array("new_file","img_5",$data['img'],"תמונה", "gallery", "&table=".$table."&GOTO_type=gallery&GOTO_main=gallery_grid"),
				array("new_file2","img2_5",$data['img2'],"תמונה גדולה", "gallery", "&table=".$table."&GOTO_type=gallery&GOTO_main=gallery_grid"),
				array("select","cat[]",$cat,"שיוך לקטגוריה",$data['cat'],"data_arr[cat_5]", "class='input_style''"),
				
				
				array("submit","submit","שלח טופס", "class='submit_style'")
	);
	
	$more = "class='maintext'";
	if( $num_rows2 > 0 )
		echo FormCreator::create_form($form_arr,"index.php", $more, $mandatory_fields);
	else
		echo "<b>יש להכניס קטגוריה תחילה</b>";
}



function add_DB_5_pics_gellery()
{
	
	for( $i=1 ; $i<=5 ; $i++ )
	{
		$temp_img = "img_".$i;
		$temp_img2 = "img2_".$i;
		$temp_cat = "cat_".$i;
		$img = $$temp_img;
		$img2 = $$temp_img2;
		$data_cat['cat'] = $data_cat[$$temp_cat];
		
		if ( $data_cat['cat'] )
		{
		$image_settings = array(
						//after_success_goto=>"index.php?main=gallery_grid&type=".$_REQUEST['type']."&unk=".$_REQUEST['unk']."&sesid=".$_REQUEST['sesid'],
						table_name=>"user_gallery_images",
						field_name=>array("img","img2"),
						server_path=>SERVER_PATH."/gallery/",
						thumbnail_width=>"75",
						thumbnail_height=>"50",
						large_width=>"405",
						large_height=>"390",
		);
		$data_arr = ($_POST['data_arr'])? $_POST['data_arr'] : $_GET['data_arr'];
		insert_to_db($data_arr, $image_settings);
		}
	}
}



function update_DB_pic_gellery()
{
	$image_settings = array(
					after_success_goto=>"index.php?main=gallery_grid&cat=".$_REQUEST['cat']."&show_with_out_cat=".$_REQUEST['show_with_out_cat']."&type=".$_REQUEST['type']."&unk=".$_REQUEST['unk']."&sesid=".$_REQUEST['sesid'],
					table_name=>"user_gallery_images",
					field_name=>array("img","img2","img3"),
					server_path=>SERVER_PATH."/gallery/",
					thumbnail_width=> $_POST['gall_sm_width'],
					thumbnail_height=> $_POST['gall_sm_height'],
					large_width=> $_POST['gall_lr_width'],
					large_height=> $_POST['gall_lr_height'],
					extra_large_width=>"900",
					extra_large_height=>"900",
					
	);
	$data_arr = ($_POST['data_arr'])? $_POST['data_arr'] : $_GET['data_arr'];
	update_db($data_arr, $image_settings);
}


function add_DB_pic_gellery()
{
	$image_settings = array(
					after_success_goto=>"index.php?main=gallery_grid&cat=".$_REQUEST['cat']."&show_with_out_cat=".$_REQUEST['show_with_out_cat']."&type=".$_REQUEST['type']."&unk=".$_REQUEST['unk']."&sesid=".$_REQUEST['sesid'],
					table_name=>"user_gallery_images",
					field_name=>array("img","img2","img3"),
					server_path=>SERVER_PATH."/gallery/",
					thumbnail_width=> $_POST['gall_sm_width'],
					thumbnail_height=> $_POST['gall_sm_height'],
					large_width=> $_POST['gall_lr_width'],
					large_height=> $_POST['gall_lr_height'],
					extra_large_width=>"900",
					extra_large_height=>"900",
	);
	$data_arr = ($_POST['data_arr'])? $_POST['data_arr'] : $_GET['data_arr'];
	insert_to_db($data_arr, $image_settings);
}


function del_DB_pic()
{
	$sql = "select img,img2,img3 from user_gallery_images where id = '{$_GET['row_id']}' and unk = '".$_REQUEST['unk']."' limit 1";
	$res = mysql_db_query(DB, $sql);
	$data = mysql_fetch_array($res);
	
	$funcs = new GlobalFunctions;
		
	$new_path =  explode( "/home/ilan123" , SERVER_PATH );
	$new_path = $new_path[1];

	$conn_id = $funcs->chmod_openC();
	echo $funcs->chmod_fileC($conn_id, 777, $new_path."/gallery/" ) ? '' : '';
	$funcs->chmod_closeC($conn_id);

	$abpath_temp_unlink = SERVER_PATH."/gallery/".$data['img'];
	if( file_exists($abpath_temp_unlink) && !is_dir($abpath_temp_unlink) )
		unlink($abpath_temp_unlink);
	$abpath_temp_unlink2 = SERVER_PATH."/gallery/".$data['img2'];
	if( file_exists($abpath_temp_unlink2) && !is_dir($abpath_temp_unlink2) )
		unlink($abpath_temp_unlink2);
	$abpath_temp_unlink3 = SERVER_PATH."/gallery/".$data['img3'];
	if( file_exists($abpath_temp_unlink3) && !is_dir($abpath_temp_unlink3) )
		unlink($abpath_temp_unlink3);
	
	$sql = "update user_gallery_images set deleted = '1' where id = '{$_GET['row_id']}' and unk = '".$_REQUEST['unk']."' limit 1";
	$res = mysql_db_query(DB, $sql);
	//echo $sql;
	header("location:?main=gallery_grid&cat=".$_REQUEST['cat']."&show_with_out_cat=".$_REQUEST['show_with_out_cat']."&type=gallery&unk=".$_REQUEST['unk']."&sesid=".$_REQUEST['sesid']."");
		exit;
}


function upload_multi_img()
{
?>
	<!-- The file upload form used as target for the file upload widget -->
    <form id="fileupload" action="uploadImages/server/php/" method="POST" enctype="multipart/form-data">
        <!-- The fileupload-buttonbar contains buttons to add/delete files and start/cancel the upload -->
        <div class="row fileupload-buttonbar">
            <div class="span7">
                <!-- The fileinput-button span is used to style the file input field as button -->
                <span class="btn btn-success fileinput-button">
                    <i class="icon-plus icon-white"></i>
                    <span>הוספת תמונות</span>
                    <input type="file" name="files[]" multiple>
                </span>
                <button type="submit" class="btn btn-primary start">
                    <i class="icon-upload icon-white"></i>
                    <span>עלה כל התמונות</span>
                </button>
                <button type="reset" class="btn btn-warning cancel">
                    <i class="icon-ban-circle icon-white"></i>
                    <span>בטל הוספה</span>
                </button>
            </div>
            <div class="span5">
                <!-- The global progress bar -->
                <div class="progress progress-success progress-striped active fade">
                    <div class="bar" style="width:0%;"></div>
                </div>
            </div>
        </div>
        <!-- The loading indicator is shown during file processing -->
        <div class="fileupload-loading"></div>
        <br>
        <!-- The table listing the files available for upload/download -->
        <table class="table table-striped"><tbody class="files" data-toggle="modal-gallery" data-target="#modal-gallery"></tbody></table>
    </form>
  
  <!-- modal-gallery is the modal dialog used for the image gallery -->
<div id="modal-gallery" class="modal modal-gallery hide fade" data-filter=":odd">
    <div class="modal-header">
        <a class="close" data-dismiss="modal">&times;</a>
        <h3 class="modal-title"></h3>
    </div>
    <div class="modal-body"><div class="modal-image"></div></div>
    <div class="modal-footer">
        <a class="btn modal-download" target="_blank">
            <i class="icon-download"></i>
            <span>Download</span>
        </a>
        <a class="btn btn-success modal-play modal-slideshow" data-slideshow="5000">
            <i class="icon-play icon-white"></i>
            <span>Slideshow</span>
        </a>
        <a class="btn btn-info modal-prev">
            <i class="icon-arrow-left icon-white"></i>
            <span>Previous</span>
        </a>
        <a class="btn btn-primary modal-next">
            <span>Next</span>
            <i class="icon-arrow-right icon-white"></i>
        </a>
    </div>
</div>
<!-- The template to display files available for upload -->
<script id="template-upload" type="text/x-tmpl">
{% for (var i=0, file; file=o.files[i]; i++) { %}
    <tr class="template-upload fade">
        <td class="preview"><span class="fade"></span></td>
        <td class="name"><span>{%=file.name%}</span></td>
        <td class="size"><span>{%=o.formatFileSize(file.size)%}</span></td>
        {% if (file.error) { %}
            <td class="error" colspan="2"><span class="label label-important">{%=locale.fileupload.error%}</span> {%=locale.fileupload.errors[file.error] || file.error%}</td>
        {% } else if (o.files.valid && !i) { %}
            <td>
                <div class="progress progress-success progress-striped active"><div class="bar" style="width:0%;"></div></div>
            </td>
            <td class="start">{% if (!o.options.autoUpload) { %}
                <button class="btn btn-primary">
                    <i class="icon-upload icon-white"></i>
                    <span>{%=locale.fileupload.start%}</span>
                </button>
            {% } %}</td>
        {% } else { %}
            <td colspan="2"></td>
        {% } %}
        <td class="cancel">{% if (!i) { %}
            <button class="btn btn-warning">
                <i class="icon-ban-circle icon-white"></i>
                <span>{%=locale.fileupload.cancel%}</span>
            </button>
        {% } %}</td>
    </tr>
{% } %}
</script>
<!-- The template to display files available for download -->
<script id="template-download" type="text/x-tmpl">
{% for (var i=0, file; file=o.files[i]; i++) { %}
    <tr class="template-download fade">
        {% if (file.error) { %}
            <td></td>
            <td class="name"><span>{%=file.name%}</span></td>
            <td class="size"><span>{%=o.formatFileSize(file.size)%}</span></td>
            <td class="error" colspan="2"><span class="label label-important">{%=locale.fileupload.error%}</span> {%=locale.fileupload.errors[file.error] || file.error%}</td>
        {% } %}
        
    </tr>
{% } %}
</script>
<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.7.2/jquery.min.js"></script>
<!-- The jQuery UI widget factory, can be omitted if jQuery UI is already included -->
<script src="uploadImages/js/vendor/jquery.ui.widget.js"></script>
<!-- The Templates plugin is included to render the upload/download listings -->
<script src="uploadImages/js/tmpl.min.js"></script>
<!-- The Load Image plugin is included for the preview images and image resizing functionality -->
<script src="uploadImages/js/load-image.js"></script>
<!-- The Canvas to Blob plugin is included for image resizing functionality -->
<script src="uploadImages/js/canvas-to-blob.min.js"></script>
<!-- Bootstrap JS and Bootstrap Image Gallery are not required, but included for the demo -->
<script src="//netdna.bootstrapcdn.com/bootstrap/3.0.0/js/bootstrap.min.js"></script>
<script src="uploadImages/js/bootstrap-image-gallery.min.js"></script>
<!-- The Iframe Transport is required for browsers without support for XHR file uploads -->
<script src="uploadImages/js/jquery.fileupload-process.js"></script>
<script src="uploadImages/js/jquery.iframe-transport.js"></script>
<!-- The basic File Upload plugin -->
<script src="uploadImages/js/jquery.fileupload.js"></script>
<!-- The File Upload file processing plugin -->
<script src="uploadImages/js/jquery.fileupload-fp.js"></script>
<!-- The File Upload user interface plugin -->
<script src="uploadImages/js/jquery.fileupload-ui.js"></script>
<!-- The localization script -->
<script src="uploadImages/js/locale.js"></script>
<!-- The main application script -->
<script src="uploadImages/js/main.js"></script>
<!-- The XDomainRequest Transport is included for cross-domain file deletion for IE8+ -->
<!--[if gte IE 8]><script src="uploadImages/js/cors/jquery.xdr-transport.js"></script><![endif]-->
<?
}