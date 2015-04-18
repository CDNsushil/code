<?php
    $SERVERNAME=exec("hostname -f");
    $SERVERADDR=exec("hostname -i");
	
	if($SERVERNAME=='k119.server.lu' || $SERVERADDR=='94.242.251.14'){ 
		// Staging K119.server.lu, 94.242.251.14
		$base_url = 'http://staging.toadsquare.com/player/video_streaming'; //'10.10.10.5';
	}
	elseif($SERVERNAME == 'L221.server.lu' || $SERVERADDR == '94.242.254.30'){
		//Live L221.server.lu 94.242.254.30
		$base_url = 'http://www.toadsquare.com/player/video_streaming'; 
	}
	elseif($SERVERNAME == 'lserver5.cdnsolutionsgroup.com' || $SERVERADDR == '10.10.10.2'){ 
		//Developement
		$base_url = 'http://cdnsolutionsgroup.com/toadsquare_branch/dev/player/video_streaming'; 
	}else{
		$base_url = 'http://localhost/toadsquare/player/video_streaming'; 
	}
	

?>


<html><head><style>
	body{
		 margin:0px;
		 padding:0px;
		}
	</style>
<script type="text/javascript" src="http://cdnsolutionsgroup.com/toadsquare_branch/dev/player/flowplayer/flowplayer-3.2.12.js"></script></head><body>
	
	<div id="videoFile" style="width:500px; height:300px;background-color:#444444">
		
		
	</div>
<script type="text/javascript" charset="utf-8">
					
					function playMediaFile(){ 
							
					$f("videoFile", "flowplayer.commercial-3.2.16.swf", {
						
							key: "#$943a9847a4c436aa438",
							
							plugins: {
								secure: {
									url: "flowplayer.securestreaming-3.2.8.swf",
									timestampUrl: "sectimestamp.php"
								}
							},
							
							playlist: [
									
								 {
										 url: "http://cdnsolutionsgroup.com/toadsquare_branch/dev/images/logo-tod-square.png",
										 scaling: "orig"
								 },
									
								 {
										 // these two settings will make the first frame visible
										autoPlay: false,
										autoBuffering: true,
										baseUrl: "<?php echo $base_url; ?>/secure", // /media/
										url: "<?php echo base64_encode('home_new_video.mp4'); ?>", 
										urlResolvers: "secure",
								 }
							]
					});
								}
								playMediaFile();
								</script>
								<div class="ugdv_contextMenu" id="ugdv_myMenu" style="display: none; "><ul id="ugdv_contextMenu"><li id="ugdv_menuItem_google_docs">Open in Google Docs Viewer</li><li id="ugdv_menuItem_new_tab">Open link in new tab</li><li id="ugdv_menuItem_new_window">Open link in new window</li><li id="ugdv_menuItem_new_incognito">Open link in new incognito window</li><li class="ugdv_seperator"></li><li id="ugdv_menuItem_download_file">Download file</li><li id="ugdv_menuItem_copy">Copy link address</li><li id="ugdv_menuItem_editpdf">Edit PDF File on PDFescape.com</li></ul></div><div id="ugdv_jqContextMenu" style="display: none; position: absolute; z-index: 9999; "></div><div style="background-color: rgb(0, 0, 0); position: absolute; opacity: 0.2; z-index: 9998; display: none; "></div></body></html>
