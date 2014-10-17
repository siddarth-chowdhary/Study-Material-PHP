<?php
/*
To use , we need to give the path to a file
*/

ini_set("display_error","true");
// grab the requested file's name
$file_name = "/var/www/test.docx";    //should be a path

// make sure it's a file before doing anything!
if(is_file($file_name)) {

	/*
		Do any processing you'd like here:
		1.  Increment a counter
		2.  Do something with the DB
		3.  Check user permissions
		4.  Anything you want!

    "exe" => "application/octet-stream",
    "php" => "text/plain"
	*/

	// required for IE
	if(ini_get('zlib.output_compression')) { ini_set('zlib.output_compression', 'Off');	}

	// get the file mime type using the file extension
	switch(strtolower(substr(strrchr($file_name, '.'), 1))) {
		case 'pdf': $mime = 'application/pdf'; break;
		case 'zip': $mime = 'application/zip'; break;
		case 'jpeg':
		case 'jpg': $mime = 'image/jpg'; break;
		case 'csv': $mime = 'application/csv'; break;
		case 'txt': $mime = 'text/plain'; break;
		case 'html':
		case 'htm': $mime = 'text/html'; break;
		case 'png': $mime = 'image/png'; break;
		case 'gif': $mime = 'image/gif'; break;
		case 'docx':		
		case 'doc': $mime = 'application/msword'; break;
		case 'pptx':		
		case 'ppt': $mime = 'application/vnd.ms-powerpoint'; break;
		case 'xlsx':		
		case 'xls': $mime = 'application/vnd.ms-excel'; break;
		default: $mime = 'application/force-download';
	}
	header('Pragma: public'); 	// required
	header('Expires: 0');		// no cache
	header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
	header('Last-Modified: '.gmdate ('D, d M Y H:i:s', filemtime ($file_name)).' GMT');
	header('Cache-Control: private',false);
	header('Content-Type: '.$mime);
	header('Content-Disposition: attachment; filename="'.basename($file_name).'"');
	header('Content-Transfer-Encoding: binary');
	header('Content-Length: '.filesize($file_name));	// provide file size
	header('Connection: close');
	readfile($file_name);		// push it out
	exit();

}?>
