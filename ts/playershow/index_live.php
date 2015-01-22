<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd"> 
<html xmlns="http://www.w3.org/1999/xhtml" lang="en" xml:lang="en">	
	<head> 
	<title>Flow Player</title>         
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" /> 
	<style type="text/css" media="screen"> 
	html, body	{ height:100%; }
	body { margin:0; padding:0; overflow:auto; }   
	#flashContent { display:none; }
	</style> 

	<link rel="stylesheet" type="text/css" href="style.css" />
	<script type="text/javascript" src="flowplayer-3.2.12.min.js"></script>
	<script type="text/javascript">
	
	
		window.onload = function () {
		$f("player", "http://www.toadsquare.com/playershow/flowplayer.commercial-3.2.16.swf", {
			
			key: '#$943a9847a4c436aa438',
			
				plugins: {
					secure: {
						url: "http://www.toadsquare.com/playershow/flowplayer.securestreaming-3.2.8.swf",
						timestampUrl: "http://www.toadsquare.com/playershow/sectimestamp.php"
					},
					audio: {
						url: 'http://www.toadsquare.com/playershow/flowplayer.audio-3.2.9.swf'
					}
				},
				
				 logo: {
						url: 'http://www.toadsquare.com/playershow/logo-tod-square.png',
						fullscreenOnly: false,
						displayTime: 2000
					},
				
				playlist: [
					 {
							 url: "http://www.toadsquare.com/playershow/logo-tod-square.png",
							 scaling: 'orig'
					 },
						
					 {
							 // these two settings will make the first frame visible
							autoPlay: false,
							autoBuffering: true,
							url: "http://www.toadsquare.com/playershow/Finalp.mp4", // /JBshdrAX/project/filmNvideo/14/file/converted/p178e9v786vuvucf1a5uke91s004.mp4
							
					 }
				]
		});
	};
	
	</script>
</head> 
	<body>
		<div style="display:block;width:425px;height:300px;" id="player">
		
		</div>
	</body> 
</html> 
