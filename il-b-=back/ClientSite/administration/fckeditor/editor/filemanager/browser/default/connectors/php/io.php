<?php 
/*
 * FCKeditor - The text editor for internet
 * Copyright (C) 2003-2006 Frederico Caldeira Knabben
 * 
 * Licensed under the terms of the GNU Lesser General Public License:
 * 		http://www.opensource.org/licenses/lgpl-license.php
 * 
 * For further information visit:
 * 		http://www.fckeditor.net/
 * 
 * "Support Open Source software. What about a donation today?"
 * 
 * File Name: io.php
 * 	This is the File Manager Connector for ASP.
 * 
 * File Authors:
 * 		Frederico Caldeira Knabben (fredck@fckeditor.net)
 */

function GetUrlFromPath( $resourceType, $folderPath )
{
	if ( $resourceType == '' )
		return RemoveFromEnd( $GLOBALS["UserFilesPath"], '/' ) . $folderPath ;
	else
		return $GLOBALS["UserFilesPath"] . $resourceType . $folderPath ;
}

function RemoveExtension( $fileName )
{
	return substr( $fileName, 0, strrpos( $fileName, '.' ) ) ;
}

function ServerMapFolder( $resourceType, $folderPath )
{
	// Get the resource type directory.
	$sResourceTypePath = $GLOBALS["UserFilesDirectory"] . $resourceType . '/' ;

	// Ensure that the directory exists.
	CreateServerFolder( $sResourceTypePath ) ;

	// Return the resource type directory combined with the required path.
	return $sResourceTypePath . RemoveFromStart( $folderPath, '/' ) ;
}

function GetParentFolder( $folderPath )
{
	$sPattern = "-[/\\\\][^/\\\\]+[/\\\\]?$-" ;
	return preg_replace( $sPattern, '', $folderPath ) ;
}

function CreateServerFolder( $folderPath )
{
  $check_heb_name = find_hebrew_charecters($folderPath);
    if($check_heb_name)
    {
        unset($folderPath);
    }
    
	$sParent = GetParentFolder( $folderPath ) ;

	//$wrapper = dirname($_SERVER['DOCUMENT_ROOT']) . '/wrap';
	//exec($wrapper . escapeshellarg(" $sParent open"));
	// Check if the parent exists, or create it.
	if ( !file_exists( $sParent ) )
	{
		$sErrorMsg = CreateServerFolder( $sParent ) ;
		if ( $sErrorMsg != '' )
			return $sErrorMsg ;
	}

	if ( !file_exists( $folderPath ) )
	{
		// Turn off all error reporting.
		//error_reporting( 0 ) ;
		// Enable error tracking to catch the error.
		ini_set( 'track_errors', '1' ) ;
		
		$funcs = new GlobalFunctions;
		
		$new_path =  explode( "/home/ilan123" , $folderPath );
		$new_path = $new_path[1];
		
		$new_path2 =  explode( "/" , $new_path ,-2);
		
		$new_path = implode( "/" , $new_path2);
		
		$conn_id = $funcs->chmod_openC();
		echo $funcs->chmod_fileC($conn_id, 777, $new_path ) ? '' : 'Error #12445875';
		$funcs->chmod_closeC($conn_id);
		
		
		// To create the folder with 0777 permissions, we need to set umask to zero.
		$oldumask = umask(0) ;
		mkdir( $folderPath, 0755 ) ;
		umask( $oldumask ) ;
		
			$conn_id = $funcs->chmod_openC();
		echo $funcs->chmod_fileC($conn_id, 755, $new_path ) ? '' : 'Error #12445875';
		$funcs->chmod_closeC($conn_id);
		
		$sErrorMsg = $php_errormsg ;
		
		// Restore the configurations.
		ini_restore( 'track_errors' ) ;
		ini_restore( 'error_reporting' ) ;
		
		//exec($wrapper . escapeshellarg(" $folderPath close"));
		//exec($wrapper . escapeshellarg(" $sParent close"));

		return $sErrorMsg ;
	}
	else {
		//exec($wrapper . escapeshellarg(" $sParent close"));
		return '' ;
	}
}

function GetRootPath()
{
	$sRealPath = realpath( './' ) ;

	$sSelfPath = $_SERVER['PHP_SELF'] ;
	$sSelfPath = substr( $sSelfPath, 0, strrpos( $sSelfPath, '/' ) ) ;

	return substr( $sRealPath, 0, strlen( $sRealPath ) - strlen( $sSelfPath ) ) ;
}
?>
