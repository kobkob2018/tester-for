<?php

if( $_SESSION['change_domain']['security_code_for_domain'] == "asd112655asd4223#sdAS324@@@$1122asd%$@@!555g%@!$2211sD$^&@" )
{
	$OldDomain = $_SESSION['change_domain']['old_domain'];
	$NewDomain = $_SESSION['change_domain']['new_domain'];
	$site_unk = $_SESSION['change_domain']['my_unk'];
	
	$orginal_path = "/home/ilan123/domains/".$OldDomain."/public_html/";
	$path_to_copy = "/home/ilan123/domains/".$NewDomain."/public_html/";
	
	$libs_arr = array(
		lib1=> array("articels","articels"),
		lib2=> array("gallery","gallery"),
		lib3=> array("products","products"),
		lib4=> array("sales","sales"),
		lib5=> array("video","video"),
		lib6=> array("yad2","yad2"),
		lib7=> array("tamplate","tamplate"),
		lib8=> array("new_images","new_images"),
	);
	
	
	foreach( $libs_arr as $val => $key )
	{
		$orginal_lib = $key[0];
		$toCopy_lib = $key[1];
		
		// Connect to the FTP
		$conn_id = chmod_open();
		
		// CHMOD each file and echo the results
		echo chmod_file($conn_id, 777, $NewDomain.'/public_html/'.$toCopy_lib ) ? '' : 'Error #12445875';
		
		// Close the connection
		chmod_close($conn_id);
		
		
		if ( $handle = opendir($orginal_path.$orginal_lib.'/') )
		{
			while (false !== ($file = readdir($handle))) {
			
				$path_file = $orginal_path.$orginal_lib."/".$file;
				
				$path_file_to_copy = $path_to_copy.$toCopy_lib."/".$file;
				
				if( eregi( $site_unk , $path_file ) )
				{
					if( is_file($path_file) )
					{
						copy( $path_file , $path_file_to_copy );
						unlink( $path_file );
					}
				}
			}
			closedir($handle);
		}
		
		// Connect to the FTP
		$conn_id = chmod_open();
		
		// CHMOD each file and echo the results
		echo chmod_file($conn_id, 755, $NewDomain.'/public_html/'.$toCopy_lib ) ? '' : 'Error #12445875';
		
		// Close the connection
		chmod_close($conn_id);
	}
	
	
	
	
	/**************************************************************/
	
	
	$orginal_path = "/home/ilan123/domains/".$OldDomain."/public_html/upload_pics";
	$path_to_copy = "/home/ilan123/domains/".$NewDomain."/public_html/upload_pics";
	
	
	// Connect to the FTP
	$conn_id = chmod_open();
	
	// CHMOD each file and echo the results
	echo chmod_file($conn_id, 777, $NewDomain.'/public_html/upload_pics' ) ? '' : 'Error #12445875';
	
	// Close the connection
	chmod_close($conn_id);
	
	
		if ( $handle = opendir($orginal_path.'/') )
		{
			while (false !== ($file = readdir($handle))) {
			
				$path_file = $orginal_path."/".$file;
				$path_file_to_copy = $path_to_copy."/".$file;
				
				
				if( is_dir($path_file) && $file != "." && $file != ".." )
				{
					$oldumask = umask(0) ;
					mkdir( $path_file_to_copy, 0777 ) ;
					umask( $oldumask ) ;
					
					if ( $handle22 = opendir($path_file.'/') )
					{
						while (false !== ($file2 = readdir($handle22))) {
							
							$path_file2 = $path_file."/".$file2;
							$path_file_to_copy2 = $path_file_to_copy."/".$file2;
							
							if( is_dir($path_file2) && $file2 != "." && $file2 != ".." )
							{
									$oldumask = umask(0) ;
									mkdir( $path_file_to_copy2, 0777 ) ;
									umask( $oldumask ) ;
									
									if ( $handle23 = opendir($path_file2.'/') )
									{
										while (false !== ($file3 = readdir($handle23))) {
											
											$path_file3 = $path_file2."/".$file3;
											$path_file_to_copy3 = $path_file_to_copy2."/".$file3;
											
											if( is_file($path_file3) && $file3 != "." && $file3 != ".." )
											{
												copy( $path_file3 , $path_file_to_copy3 );
												unlink( $path_file3 );
											}
										}
										closedir($handle23);
									}
									
									$conn_id = chmod_open();
									echo chmod_file($conn_id, 755, $NewDomain.'/public_html/upload_pics/'.$file.'/'.$file2 ) ? '' : 'Error #12445875';
									chmod_close($conn_id);
						
							}
							
							if( is_file($path_file2) )
							{
								copy( $path_file2 , $path_file_to_copy2 );
								unlink( $path_file2 );
							}
						}
						closedir($handle22);
					}
					
						$conn_id = chmod_open();
						echo chmod_file($conn_id, 755, $NewDomain.'/public_html/upload_pics/'.$file ) ? '' : 'Error #12445875';
						chmod_close($conn_id);
				}
				
				if( is_file($path_file) )
				{
					copy( $path_file , $path_file_to_copy );
					unlink( $path_file );
				}
			}
			closedir($handle);
		}
	
	// Connect to the FTP
	$conn_id = chmod_open();
	
	// CHMOD each file and echo the results
	echo chmod_file($conn_id, 755, $NewDomain.'/public_html/upload_pics' ) ? '' : 'Error #12445875';
	
	// Close the connection
	chmod_close($conn_id);
	
	
	echo "<script>alert('העברה בוצעה בהצלחה');</script>";
	echo "<script>window.location.href='?sesid=".SESID."'</script>";
}
else
{
	echo "<script>alert('#46211-6 התראת אבטחה');</script>";
	echo "<script>window.location.href='?main=change_site_domain&sesid=".SESID."'</script>";
}



/*
$domain = "milan-il.com";
$site_unk = "037782347340629311";

$orginal_path = "/home/ilan123/domains/ilbiz.co.il/public_html/ClientSite/";
$path_to_copy = "/home/ilan123/domains/".$domain."/public_html/";


$libs_arr = array(
	lib1=> array("articels","articels"),
	lib2=> array("gallery","gallery"),
	lib3=> array("products","products"),
	lib4=> array("sales","sales"),
	lib5=> array("video","video"),
	lib6=> array("yad2","yad2"),
	
	lib7=> array("flash_right_menu","tamplate"),
	lib8=> array("g_site_bg","tamplate"),
	lib9=> array("logos","tamplate"),
	lib10=> array("menu_bg","tamplate"),
	lib11=> array("top_slice","tamplate"),
	lib12=> array("txt_area_bg","tamplate"),
);

foreach( $libs_arr as $val => $key )
{
	$orginal_lib = $key[0];
	$toCopy_lib = $key[1];
	
	if ( $handle = opendir($orginal_path.$orginal_lib.'/') )
	{
		while (false !== ($file = readdir($handle))) {
		
			$path_file = $orginal_path.$orginal_lib."/".$file;
			
			$path_file_to_copy = $path_to_copy.$toCopy_lib."/".$file;
			
			if( eregi( $site_unk , $path_file ) )
			{
				if( is_file($path_file) )
				{
					echo $path_file."<BR>";
					
					copy( $path_file , $path_file_to_copy );
					unlink( $path_file );
				}
			}
		}
		closedir($handle);
	}
}

*/

/*
013837332356467533				panet.ilbiz.co.il
022132268277084743				
030018820700135878				
03030303									try2.ilbiz.co.il
037782347340629311				milan-il.com
065549823129108676				na.beersheva.biz
143383197025128200				india.ilbiz.co.il
157945895869794687				mivtzaim.ilbiz.co.il
215279997191552756				home.ilbiz.co.il
226653612046319953				
245335157887300654				kidum.ilbiz.co.il
266219285069692330				hist-negev.org.il
328173266823780781				viktoria.ilbiz.co.il
357893060973450565				alisa.beersheva.biz
405812248512703156				mazganayad.com
441844631265293564				moti.ilbiz.co.il
545083177592102937				barak.beersheva.biz
585629860654632039				tarbut.org.il
589127476298010148				yahalom.beersheva.biz
593994941467585061				
604662300295779774				eldadmd.ilbiz.co.il
654462387874498781				shalevclinic.com
716420569220485402				host.ilbiz.co.il
720849481925097311				shokolad.beersheva.biz
803644234376904850				horimb7.co.il
828534585231337295				ay.beersheva.biz
889741566932758547				tb7.beersheva.biz
913484113400363944				olympus.beersheva.biz
932205150252587527				soclean.ilbiz.co.il
943562995658652619				event.ilbiz.co.il
982751931183825611				- not yet           tour.beersheva.biz
*/

/*
$domain = "tour.beersheva.biz";
$site_unk = "982751931183825611";

$orginal_path = "/home/ilan123/domains/ilbiz.co.il/public_html/ClientSite/upload_pics/".$site_unk;
$path_to_copy = "/home/ilan123/domains/".$domain."/public_html/upload_pics";



	if ( $handle = opendir($orginal_path.'/') )
	{
		while (false !== ($file = readdir($handle))) {
		
			$path_file = $orginal_path."/".$file;
			$path_file_to_copy = $path_to_copy."/".$file;
			
			
			if( is_dir($path_file) && $file != "." && $file != ".." )
			{
				echo $path_file."***--DIR  ----  ".$path_file_to_copy."<BR>";
				
				$oldumask = umask(0) ;
				mkdir( $path_file_to_copy, 0777 ) ;
				umask( $oldumask ) ;
				
				if ( $handle22 = opendir($path_file.'/') )
				{
					while (false !== ($file2 = readdir($handle22))) {
						
						$path_file2 = $path_file."/".$file2;
						$path_file_to_copy2 = $path_file_to_copy."/".$file2;
						
						if( is_dir($path_file2) && $file2 != "." && $file2 != ".." )
						{
								echo $path_file2."***--DIR ----- ".$path_file_to_copy2."<BR>";
								
								$oldumask = umask(0) ;
								mkdir( $path_file_to_copy2, 0777 ) ;
								umask( $oldumask ) ;
								
								if ( $handle23 = opendir($path_file2.'/') )
								{
									while (false !== ($file3 = readdir($handle23))) {
										
										$path_file3 = $path_file2."/".$file3;
										$path_file_to_copy3 = $path_file_to_copy2."/".$file3;
										
										if( is_file($path_file3) && $file3 != "." && $file3 != ".." )
										{
											echo $path_file3."***--FILE   -----   ".$path_file_to_copy3."<BR>";
											
											copy( $path_file3 , $path_file_to_copy3 );
										}
									}
									closedir($handle23);
								}
						}
						
						if( is_file($path_file2) )
						{
							echo $path_file2."***--FILE   -----   ".$path_file_to_copy2."<BR>";
							
							copy( $path_file2 , $path_file_to_copy2 );
						}
					}
					closedir($handle22);
				}
			}
			
			if( is_file($path_file) )
			{
				echo $path_file."***--FILE   -----   ".$path_file_to_copy."<BR>";
				
				copy( $path_file , $path_file_to_copy );
			}
		}
		closedir($handle);
	}
*/
?>