<?php 
// This secure for HTML5 Player

$hash = $_GET['h'];
$streamname = $_GET['v'];
$timestamp = $_GET['t'];
$current = time();
write_log("streamname===".$streamname."=====timestamp===".$timestamp."====current===".$current);

	//if (($current - $timestamp) <= 20) {
	if ($streamname != '') {
	
	$streamname =base64_decode($streamname);
	
	//$streamname = "http://localhost/toadsquare/media/JBshdrAX/workshowcase/Videos/converted/p17j6idv6b1fpn1u42p9j1k1c1svrd.mp4";
	$SERVERNAME=exec("hostname -f");
	$SERVERADDR=exec("hostname -i");
	
	if($SERVERNAME=='k119.server.lu' || $SERVERADDR=='94.242.251.14'){ 
		// Staging K119.server.lu, 94.242.251.14
		$base_url = 'http://staging.toadsquare.com/'; //'10.10.10.5';
	}
	elseif($SERVERNAME == 'L221.server.lu' || $SERVERADDR == '94.242.254.30'){
		//Live L221.server.lu 94.242.254.30
		$base_url = 'http://www.toadsquare.com/'; 
	}
	elseif($SERVERNAME == 'lserver5' || $SERVERADDR == '10.10.10.5'){ 
		//Developement
		$base_url = 'http://115.113.182.141/toadsquare_branch/dev/'; 
	}else{
		$base_url = 'http://localhost/toadsquare/'; 
	}
	
	$streamname = $base_url."media".$streamname;
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
