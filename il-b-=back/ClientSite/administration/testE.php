<?php
/*

DELETE ALL FILES !!!

  function chmodDirectory( $path = '.', $level = 0 ){  
  $ignore = array( 'cgi-bin', '.', '..' ); 
  $dh = @opendir( $path ); 
  while( false !== ( $file = readdir( $dh ) ) ){ // Loop through the directory 
  if( !in_array( $file, $ignore ) ){

          unlink("$path/$file"); // desired permission settings

	}//if in array 
	}//while 
	
	closedir( $dh ); 
	}//function
	
	chmodDirectory("/home/ilan123/domains/smadi.co.il/public_html/gallery/",0);
	
*/