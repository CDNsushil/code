<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
class Welcome extends MX_Controller{
	function __construct(){
		parent::__construct();
	}
function downloadFile($filePath='',$fileName='',$dwnFileName=''){ 
	$filePath='media/JBshdrAX/project/photographyNart/53/file/';
	$fileName='p17nv8n55o18e9uvuvtq1kbd1cj74.jpg';
	$dwnFileName='aaaa%%.jpg';
	$file=$filePath.$fileName;
	if(is_file($file)){
		if($dwnFileName==''){
			$dwnFileName=$fileName;
		}
		$fsize = filesize($file);
		$fileInfo=pathinfo($file);
		$extension=$fileInfo['extension'];
		$extension = strtolower($extension);
		switch($extension) {
			case "pdf":
			$ctype = "application/pdf";
			break;
			case "exe":
			$ctype = "application/octet-stream";
			break;
			case "zip":
			$ctype = "application/zip";
			break;
			case "doc":
			$ctype = "application/msword";
			break;
			case "xls":
			$ctype = "application/vnd.ms-excel";
			break;
			case "ppt":
			$ctype = "application/vnd.ms-powerpoint";
			break;
			case "gif":
			$ctype = "image/gif";
			break;
			case "png":
			$ctype = "image/png";
			break;
			case "jpeg":
			$ctype = "image/jpg";
			break;
			case "jpg":
			$ctype = "image/jpg";
			break;
			case "mp3":
			$ctype = "audio/mp3";
			break;
			case "wav":
			$ctype = "audio/x-wav";
			break;
			case "wma":
			$ctype = "audio/x-wav";
			break;
			case "mpeg":
			$ctype = "video/mpeg";
			break;
			case "mpg":
			$ctype = "video/mpeg";
			break;
			case "mpe":
			$ctype = "video/mpeg";
			break;
			case "mov":
			$ctype = "video/quicktime";
			break;
			case "avi":
			$ctype = "video/x-msvideo";
			break;
			case "src":
			$ctype = "plain/text";
			break;
			default:
			$ctype = "application/force-download";
			break;
		}
		header('Content-Description: File Transfer');
		header('Content-Type: "'.$ctype.'"');
		header('Content-Disposition: attachment; filename="'.basename($dwnFileName).'"');
		header('Expires: 0');
		header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
		header("Content-Transfer-Encoding: binary");
		header('Expires: 0');
		header('Cache-Control: must-revalidate');
		header('Pragma: public');
		header("Content-Length: ".$fsize);
		ob_clean();
		flush();
		readfile(trim($file));
		exit;
		
	}else{
		echo "file not found";
	}
}
}
