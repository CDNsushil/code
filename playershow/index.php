<?php 
//$serverPath = "http://localhost/toadsquare";
//$serverPath = "http://115.113.182.141/toadsquare_branch/dev";
//$serverPath = "http://www.toadsquare.com";
//$serverPath = "http://staging.toadsquare.com";


	$server_addr = exec("hostname -i");
		
	if($server_addr=='94.242.251.14'){
		$serverPath = "http://staging.toadsquare.com";
	}
	elseif($server_addr == '94.242.254.30'){
		$serverPath = "http://www.toadsquare.com";
	}
	elseif($server_addr == '10.10.10.2'){
		$serverPath = "http://115.113.182.141/toadsquare_branch/dev";
	}else{
		$serverPath = "http://localhost/toadsquare";
	}

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd"> 
<html xmlns="http://www.w3.org/1999/xhtml" lang="en" xml:lang="en">	
	<head> 
	<title>Html 5 Player Testing</title>         
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" /> 
	<link type="text/css" href="<?php echo $serverPath; ?>/player/html5_video_player/video-js.css" rel="stylesheet" media="all" />
	<script type="text/javascript" src="<?php echo $serverPath; ?>/player/html5_video_player/video.js"></script>
</head> 
	<body>
		<script>
		_V_.options.flash.swf = "<?php echo $serverPath; ?>/player/html5_video_player/video-js.swf";
		</script> 
	    <video id="launch_video"   width="500" height="340" class="video-js vjs-default-skin html5_header_video" controls preload="none" 
		poster="<?php echo $serverPath; ?>/images/logo-tod-square.png"	data-setup="{}" >
		<source src="<?php echo $serverPath.'/playershow/Finalp.mp4'; ?>" type="video/mp4">
		<p>Video Playback Not Supported</p>
		</video> 
	</body> 
</html> 


<h1>File Location</h1>
<a href="<?php echo $serverPath.'/playershow/Finalp.mp4'; ?>"><?php echo $serverPath.'/playershow/Finalp.mp4'; ?></a>
