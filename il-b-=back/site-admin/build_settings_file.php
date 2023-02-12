<?php



////////////////////////////////////////////////////////////////////
	// Build file
////////////////////////////////////////////////////////////////////


//Create symbolic links

$path = "/home/ilan123/domains/ilbiz.co.il/public_html/ClientSite/";
$path_to_copy = "/home/ilan123/domains/".$data_arr['domain']."/public_html/";

if( is_dir($path_to_copy) )
{
	// unlink default files
	$path_DEL_indexDOThtml = $path_to_copy."index.html";
	$path_DEL_logoDOTjpg = $path_to_copy."logo.jpg";
	
	if( file_exists($path_DEL_logoDOTjpg) )
	{
		// Connect to the FTP
		$conn_id = chmod_open();
		
		// CHMOD each file and echo the results
		echo chmod_file($conn_id, 777, $data_arr['domain'] ) ? '' : 'Error #12445876';
		echo chmod_file($conn_id, 777, $data_arr['domain'].'/public_html' ) ? '' : 'Error #12445877';
		
		// Close the connection
		chmod_close($conn_id);
	
		if( file_exists($path_DEL_indexDOThtml) )
		{
			unlink($path_DEL_indexDOThtml);
		}
			
		unlink($path_DEL_logoDOTjpg);
	}
	else
	{
		// Connect to the FTP
		$conn_id = chmod_open();
		
		// CHMOD each file and echo the results
		echo chmod_file($conn_id, 777, $data_arr['domain'] ) ? '' : 'Error #12445878';
		echo chmod_file($conn_id, 777, $data_arr['domain'].'/public_html' ) ? '' : 'Error #12445879';
		
		// Close the connection
		chmod_close($conn_id);
	}
	
		if(file_exists($path_to_copy.".htaccess") ){
			if ( '' == file_get_contents( $path_to_copy.".htaccess" ) )
			{
				unlink($path_to_copy.".htaccess");
			}
		}
		if( !file_exists($path_to_copy.".htaccess") )
			symlink ( $path.".htaccess_symlink", $path_to_copy.".htaccess" );		
		if( !file_exists($path_to_copy."index.php") )
			symlink ( $path."index.php", $path_to_copy."index.php" );
		if( !file_exists($path_to_copy."functions.php") )
			symlink ( $path."functions.php", $path_to_copy."functions.php" );
		if( !file_exists($path_to_copy."fix_flash.js") )
			symlink ( $path."fix_flash.js", $path_to_copy."fix_flash.js" );
		if( !file_exists($path_to_copy."js.js") )
			symlink ( $path."js.js", $path_to_copy."js.js" );
		if( !file_exists($path_to_copy."strac_func.php") )
			symlink ( $path."strac_func.php", $path_to_copy."strac_func.php" );
		if( !file_exists($path_to_copy."news_scroller.php") )
			symlink ( $path."news_scroller.php", $path_to_copy."news_scroller.php" );
		if( !file_exists($path_to_copy."print.php") )
			symlink ( $path."print.php", $path_to_copy."print.php" );
		if( !file_exists($path_to_copy."style.php") )
			symlink ( $path."style.php", $path_to_copy."style.php" );
		if( !file_exists($path_to_copy."script.php") )
			symlink ( $path."script.php", $path_to_copy."script.php" );
			
		if( !file_exists($path_to_copy."ajax.php") )
			symlink ( $path."ajax.php", $path_to_copy."ajax.php" );
		
		if( !file_exists($path_to_copy."thanksPix.php") )
			symlink ( $path."thanksPix.php", $path_to_copy."thanksPix.php" );

		
				
		if( $_POST['estimateSite'] == 1 )
		{
			
			$estimate_path = "/home/ilan123/domains/ilbiz.co.il/public_html/ClientSite/other/estimate_miniSite/";
			if( !file_exists($path_to_copy."estimate_form.php") )
				symlink ( $estimate_path."estimate_form.php", $path_to_copy."estimate_form.php" );
			
			$estimate_path_images = "/home/ilan123/domains/ilbiz.co.il/public_html/ClientSite/other/estimate_miniSite/images/";
			
			if( !file_exists($path_to_copy."new_images/default_top_form_girl.jpg") )
				symlink ( $estimate_path_images."default_top_form_girl.jpg", $path_to_copy."new_images/default_top_form_girl.jpg" );
			if( !file_exists($path_to_copy."new_images/default_vid_border.jpg") )
				symlink ( $estimate_path_images."default_vid_border.jpg", $path_to_copy."new_images/default_vid_border.jpg" );
			if( !file_exists($path_to_copy."new_images/defualt_top_form_slice.swf") )
				symlink ( $estimate_path_images."defualt_top_form_slice.swf", $path_to_copy."new_images/defualt_top_form_slice.swf" );
			if( !file_exists($path_to_copy."new_images/estimate_box_bottom_border.jpg") )
				symlink ( $estimate_path_images."estimate_box_bottom_border.jpg", $path_to_copy."new_images/estimate_box_bottom_border.jpg" );
			if( !file_exists($path_to_copy."new_images/estimate_box_top_border.jpg") )
				symlink ( $estimate_path_images."estimate_box_top_border.jpg", $path_to_copy."new_images/estimate_box_top_border.jpg" );
			if( !file_exists($path_to_copy."new_images/estimate_box_dup_border.jpg") )
				symlink ( $estimate_path_images."estimate_box_dup_border.jpg", $path_to_copy."new_images/estimate_box_dup_border.jpg" );
			
			if( !file_exists($path_to_copy."new_images/default_net_club_bottom.png") )
				symlink ( $estimate_path_images."default_net_club_bottom.png", $path_to_copy."new_images/default_net_club_bottom.png" );
			if( !file_exists($path_to_copy."new_images/default_net_club_top.png") )
				symlink ( $estimate_path_images."default_net_club_top.png", $path_to_copy."new_images/default_net_club_top.png" );
			if( !file_exists($path_to_copy."new_images/default_scroll_news_bottom.png") )
				symlink ( $estimate_path_images."default_scroll_news_bottom.png", $path_to_copy."new_images/default_scroll_news_bottom.png" );
			if( !file_exists($path_to_copy."new_images/default_scroll_news_top.png") )
				symlink ( $estimate_path_images."default_scroll_news_top.png", $path_to_copy."new_images/default_scroll_news_top.png" );
			
			if( !file_exists($path_to_copy."new_images/defualt_site_background.gif") )
				symlink ( $estimate_path_images."defualt_site_background.gif", $path_to_copy."new_images/defualt_site_background.gif" );
			
			if( !file_exists($path_to_copy."new_images/default_bottom_slice_orange_775_156.swf") )
				symlink ( $estimate_path_images."default_bottom_slice_orange_775_156.swf", $path_to_copy."new_images/default_bottom_slice_orange_775_156.swf" );
			if( !file_exists($path_to_copy."new_images/default_top_slice_orange_775_90.swf") )
				symlink ( $estimate_path_images."default_top_slice_orange_775_90.swf", $path_to_copy."new_images/default_top_slice_orange_775_90.swf" );
			
		
		}
		
		
		
		if( $_POST['haveLandingPage'] == 1 )
		{
			if( !file_exists($path_to_copy."landing.php") )
				symlink ( $path."landing.php", $path_to_copy."landing.php" );
			
			if( !file_exists($path_to_copy."ajax_landing.php") )
				symlink ( $path."ajax_landing.php", $path_to_copy."ajax_landing.php" );
			
			if( !is_dir($path_to_copy."new_images/landing") )
			{
				$path_landing = $path_to_copy."new_images/landing";
				$oldumask = umask(0) ;
				mkdir( $path_landing, 0755 ) ;
				umask( $oldumask ) ;
			}
		}
		
		
		if( !file_exists($path_to_copy."image.php") )
			symlink ( $path."image.php", $path_to_copy."image.php" );
		
		if( !is_dir($path_to_copy."imagecache") )
		{
			$path_landing = $path_to_copy."imagecache";
			$oldumask = umask(0) ;
			mkdir( $path_landing, 0777 ) ;
			umask( $oldumask ) ;
		}
		
		
		$str_gW = "google-site-verification: google062a0838aaaccf3b.html";
		$file_gW = fopen($path_to_copy."google062a0838aaaccf3b.html", "w");
		rewind($file_gW);
		fputs($file_gW, $str_gW);
		fclose($file_gW);
		
	
		$bild_file = "<?php \n";
			$bild_file .= "define('DEFINE_UNK',\"".$data_arr['unk']."\");\n";
		$bild_file .= " ?>";
		
		$file2 = fopen($path_to_copy."unk_def.php", "w");
		rewind($file2);
		fputs($file2, $bild_file);
		fclose($file2);
		
		$file2 = fopen($path_to_copy."unk_def_new.php", "w");
		rewind($file2);
		fputs($file2, $bild_file);
		fclose($file2);	
		if( !is_dir($path_to_copy."articels") )
		{
			$path_articels = $path_to_copy."articels";
			$oldumask = umask(0) ;
			mkdir( $path_articels, 0755 ) ;
			umask( $oldumask ) ;
		}
		
		if( !is_dir($path_to_copy."tamplate") )
		{
			$path_articels = $path_to_copy."tamplate";
			$oldumask = umask(0) ;
			mkdir( $path_articels, 0755 ) ;
			umask( $oldumask ) ;
		}
		if( !is_dir($path_to_copy."gallery") )
		{
			$path_articels = $path_to_copy."gallery";
			$oldumask = umask(0) ;
			mkdir( $path_articels, 0755 ) ;
			umask( $oldumask ) ;
		}
		if( !is_dir($path_to_copy."products") )
		{
			$path_articels = $path_to_copy."products";
			$oldumask = umask(0) ;
			mkdir( $path_articels, 0755 ) ;
			umask( $oldumask ) ;
		}
		if( !is_dir($path_to_copy."sales") )
		{
			$path_articels = $path_to_copy."sales";
			$oldumask = umask(0) ;
			mkdir( $path_articels, 0755 ) ;
			umask( $oldumask ) ;
		}
		if( !is_dir($path_to_copy."upload_pics") )
		{
			$path_articels = $path_to_copy."upload_pics";
			$oldumask = umask(0) ;
			mkdir( $path_articels, 0777 ) ;
			umask( $oldumask ) ;
		}
		if( !is_dir($path_to_copy."yad2") )
		{
			$path_articels = $path_to_copy."yad2";
			$oldumask = umask(0) ;
			mkdir( $path_articels, 0755 ) ;
			umask( $oldumask ) ;
		}
		if( !is_dir($path_to_copy."video") )
		{
			$path_articels = $path_to_copy."video";
			$oldumask = umask(0) ;
			mkdir( $path_articels, 0755 ) ;
			umask( $oldumask ) ;
		}
		if( !is_dir($path_to_copy."new_images") )
		{
			$path_articels = $path_to_copy."new_images";
			$oldumask = umask(0) ;
			mkdir( $path_articels, 0755 ) ;
			umask( $oldumask ) ;
		}
		
		
		// Save the flex Galley id needed
		if( $data_arr['flex_gallery'] == "1" )
		{
			// save the XML file
			if( !file_exists($path_to_copy."create_xml.php") )
			{
				$ss = symlink ( $path."other/create_xml.php", $path_to_copy."create_xml.php" );
			}
			
			
			if( file_exists($path_to_copy."images.swf") )
				unlink($path_to_copy."images.swf");
		
			switch($data_arr['flex_galleryType'])
			{
				case "1" :			$flexGalleryLib = "/home/ilan123/domains/ilbiz.co.il/public_html/net/gallery/images.swf";					break;
				case "2" :			$flexGalleryLib = "/home/ilan123/domains/ilbiz.co.il/public_html/net/outlet/outletcenter.swf";		break;
				case "3" :			$flexGalleryLib = "/home/ilan123/domains/ilbiz.co.il/public_html/net/simple/gallery.swf";					break;
				case "4" :			$flexGalleryLib = "/home/ilan123/domains/ilbiz.co.il/public_html/net/gallery/gallery.swf";					break;
				case "5" :			$flexGalleryLib = "/home/ilan123/domains/ilbiz.co.il/public_html/net/shelf/shelf.swf";					break;
			}
			
			// save the flex gallery file
			if( !file_exists($path_to_copy."images.swf") )
			{
				$ss2 = symlink ( $flexGalleryLib, $path_to_copy."images.swf" );
			}
			
			
			// save lib 'css' for style flex gallery
			if( !is_dir($path_to_copy."css") )
			{
				$path_articels = $path_to_copy."css";
				$oldumask = umask(0) ;
				mkdir( $path_articels, 0755 ) ;
				umask( $oldumask ) ;
			}
			
			
			$css_str = "global {text-align:right;font-family: \"Arial (Hebrew)\";font-size:12pt;font-weight:bold;}
			
			";
			$css_str .= $data_arr['flex_gallery_css'];
			
			$file_css = fopen($path_to_copy."css/style.css", "w");
			rewind($file_css);
			fputs($file_css, $css_str);
			fclose($file_css);
			
		}
		
		
		/*$conn_id = chmod_open();
		
		// CHMOD each file and echo the results
		echo chmod_file($conn_id, 755, $data_arr['domain'] ) ? '' : 'Error #12445874';
		echo chmod_file($conn_id, 755, $data_arr['domain'].'/public_html' ) ? '' : 'Error #12445875';
		
		// Close the connection
		chmod_close($conn_id);*/
		
}
else
{
	die("domain not found: ".$path_to_copy."<br> ERROR #12445844");
}




function chmod_open()
{
   // Use your own FTP info
   $ftp_user_name = 'ilan123';
   $ftp_user_pass = 'agate1';
   $ftp_server = 'il-biz.com';
   $conn_id = ftp_connect($ftp_server) or die("Couldn't connect to $ftp_server");
   $login_result = ftp_login($conn_id, $ftp_user_name, $ftp_user_pass);
   return $conn_id;
}

function chmod_file($conn_id, $permissions, $path)
{
   if (ftp_site($conn_id, 'CHMOD ' . $permissions . ' /domains/' . $path) !== false)
   {
       return TRUE;
   }
   else
   {
       return FALSE;
   }
}

function chmod_close($conn_id)
{
   ftp_close($conn_id);
}

?>  



