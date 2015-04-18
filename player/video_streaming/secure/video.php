<?php 

$hash = $_GET['h'];
$streamname = $_GET['v'];
$timestamp = $_GET['t'];
$current = time();
$token = 'sn983pjcnhupclavsnda';
$checkhash = md5($token . '/' . $streamname . $timestamp);

write_log("HASH==".$hash."===checkhash===".$checkhash."=====timestamp===".$timestamp."====current===".$current);

if (($current - $timestamp) <= 20 && ($checkhash == $hash)) {
	
	
	$streamname =base64_decode($streamname);
	
	//$streamname = '../'.$streamname;

	/*$streamname = '../../../media/'.$streamname;
	$fsize = filesize($streamname);

	header('Content-Disposition: attachment; filename="' . $streamname . '"');
	if (strrchr($streamname, '.') == '.mp4') {
	header('Content-Type: video/mp4');
	}else if (strrchr($streamname, '.') == '.mov') {
	header('Content-Type: video/mov');
	} else if (strrchr($streamname, '.') == '.mp3') {
	header('Content-Type: video/mp3');
	} else {
	header('Content-Type: video/x-flv');
	}
	header('Content-Length: ' . $fsize);
	session_cache_limiter('nocache');
	header('Expires: Thu, 19 Nov 1981 08:52:00 GMT');
	header('Last-Modified: ' . gmdate('D, d M Y H:i:s') . ' GMT');
	header('Cache-Control: no-store, no-cache, must-revalidate, post-check=0, pre-check=0');
	header('Pragma: no-cache');*/

	//$streamname = "http://localhost/toadsquare/media/JBshdrAX/workshowcase/Videos/converted/p17j6idv6b1fpn1u42p9j1k1c1svrd.mp4";
	$SERVERNAME=exec("hostname -f");
	$SERVERADDR=exec("hostname -i");
	
	if($SERVERNAME=='k119.server.lu' || $SERVERADDR=='94.242.251.14'){ 
		// Staging K119.server.lu, 94.242.251.14
		$base_url = 'http://staging.toadsquare.com/player/video_streaming/'; //'10.10.10.5';
	}
	elseif($SERVERNAME == 'L221.server.lu' || $SERVERADDR == '94.242.254.30'){
		//Live L221.server.lu 94.242.254.30
		$base_url = 'http://www.toadsquare.com/player/video_streaming/'; 
	}
	elseif($SERVERNAME == 'lserver5.cdnsolutionsgroup.com' || $SERVERADDR == '10.10.10.2'){ 
		//Developement
		$base_url = 'http://cdnsolutionsgroup.com/toadsquare_branch/dev/player/video_streaming/'; 
	}else{
		$base_url = 'http://cdnsolutionsgroup.com/toadsquare_branch/dev/player/video_streaming/'; 
		//$base_url = 'http://localhost/toadsquare/player/video_streaming/'; 
	}
	
	
	
	
	$streamname = $base_url.$streamname;
	
	
	//echo $streamname; die;
	header('Location: '.$streamname);

	/*$file = fopen($streamname, 'rb');
	print(fread($file, $fsize));
	fclose($file);
	exit;*/
} else {
	//print_r($_GET);
	//echo ($current - $timestamp) ."<= 2 && ".$checkhash." == ".$hash;
	header('Location: secure');
}

function write_log($content) {
	$file = fopen("log.txt", 'w+');
	fwrite($file, $content);
	fclose($file);
}
?>
