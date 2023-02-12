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
 * File Name: upload.php
 * 	This is the "File Uploader" for PHP.
 * 
 * File Authors:
 * 		Frederico Caldeira Knabben (fredck@fckeditor.net)
 */
require('/home/ilan123/domains/ilbiz.co.il/public_html/global_func/global_functions.php');
require('config.php') ;
require('util.php') ;

// This is the function that sends the results of the uploading process.
function SendResults( $errorNumber, $fileUrl = '', $fileName = '', $customMsg = '' )
{
	echo '<script type="text/javascript">' ;
	echo 'window.parent.OnUploadCompleted(' . $errorNumber . ',"' . str_replace( '"', '\\"', $fileUrl ) . '","' . str_replace( '"', '\\"', $fileName ) . '", "' . str_replace( '"', '\\"', $customMsg ) . '") ;' ;
	echo '</script>' ;
	exit ;
}

// Check if this uploader has been enabled.
if ( !$Config['Enabled'] )
	SendResults( '1', '', '', 'This file uploader is disabled. Please check the "editor/filemanager/upload/php/config.php" file' ) ;

// Check if the file has been correctly uploaded.
if ( !isset( $_FILES['NewFile'] ) || is_null( $_FILES['NewFile']['tmp_name'] ) || $_FILES['NewFile']['name'] == '' )
	SendResults( '202' ) ;

// Get the posted file.
$oFile = $_FILES['NewFile'] ;

// Get the uploaded file name extension.
$sFileName = $oFile['name'] ;

// Replace dots in the name with underscores (only one dot can be there... security issue).
if ( $Config['ForceSingleExtension'] )
	$sFileName = preg_replace( '/\\.(?![^.]*$)/', '_', $sFileName ) ;

$sOriginalFileName = $sFileName ;

// Get the extension.
$sExtension = substr( $sFileName, ( strrpos($sFileName, '.') + 1 ) ) ;
$sExtension = strtolower( $sExtension ) ;

// The the file type (from the QueryString, by default 'File').
$sType = isset( $_GET['Type'] ) ? $_GET['Type'] : 'File' ;

// Check if it is an allowed type.
if ( !in_array( $sType, array('File','Image','Flash','Media') ) )
    SendResults( 1, '', '', 'Invalid type specified ' ) ;

// Get the allowed and denied extensions arrays.
$arAllowed	= $Config['AllowedExtensions'][$sType] ;
$arDenied	= $Config['DeniedExtensions'][$sType] ;

// Check if it is an allowed extension.
if ( ( count($arAllowed) > 0 && !in_array( $sExtension, $arAllowed ) ) || ( count($arDenied) > 0 && in_array( $sExtension, $arDenied ) ) )
	SendResults( '202' ) ;

$sErrorNumber	= '0' ;
$sFileUrl		= '' ;

// Initializes the counter used to rename the file, if another one with the same name already exists.
$iCounter = 0 ;

// The the target directory.
if ( isset( $Config['UserFilesAbsolutePath'] ) && strlen( $Config['UserFilesAbsolutePath'] ) > 0 )
	$sServerDir = $Config['UserFilesAbsolutePath'] ;
else 
	$sServerDir = GetRootPath() . $Config["UserFilesPath"] ;

while ( true )
{
	// Compose the file path.
	$sFilePath = $sServerDir . $sFileName ;

	// If a file with that name already exists.
	if ( is_file( $sFilePath ) )
	{
		$iCounter++ ;
		$sFileName = RemoveExtension( $sOriginalFileName ) . '(' . $iCounter . ').' . $sExtension ;
		$sErrorNumber = '201' ;
	}
	else
	{
		//$wrapper = dirname($_SERVER['DOCUMENT_ROOT']) . '/wrap';
		//SendResults( 1, '', '',$wraper . " $sServerDir open" ); 
		//exec($wrapper . escapeshellarg(" $sServerDir open"));
		
		$funcs = new GlobalFunctions;
		
		$new_path =  explode( "/home/ilan123" , $sServerDir );
		$new_path = $new_path[1];
		
		$conn_id = $funcs->chmod_openC();
		
		echo $funcs->chmod_fileC($conn_id, 777, $new_path ) ? '' : 'Error #12445875';
		$funcs->chmod_closeC($conn_id);
		
		move_uploaded_file( $oFile['tmp_name'], $sFilePath ) ;
		
		if ( is_file( $sFilePath ) )
		{
			$oldumask = umask(0) ;
			chmod( $sFilePath, 0644 ) ;
			umask( $oldumask ) ;
		}
		
		
		$conn_id = $funcs->chmod_openC();
		echo $funcs->chmod_fileC($conn_id, 755, $new_path ) ? '' : 'Error #12445875';
		$funcs->chmod_closeC($conn_id);
		
		
		$sFileUrl = $Config["UserFilesPath"] . $sFileName ;
		
		//exec($wrapper . escapeshellarg(" $sServerDir close"));
		//exec($wrapper . escapeshellarg("  $sFilePath close"));
		break ;
	}
}

SendResults( $sErrorNumber, $sFileUrl, $sFileName ) ;
?>
