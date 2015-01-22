<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');?>
<html>
<body style="margin:0px;padding:0px;">
<script type="text/javascript" src="<?php echo base_url('player/flowplayer/flowplayer-3.2.4.min.js')?>"></script>
<?php
	
	//echo '<pre />';print_r($player);die;
	$file = getImage(@$player[0]->filePath.'/'.@$player[0]->fileName);
	$coverImage = getImage(@$player[0]->imagePath);
	$fileType = 2;
	$duration = 5;
	echo "<div id='videoFile' class='width660px height330px'></div>";
	
?>
<script type="text/javascript" charset="utf-8">
		
		 function playMediaFile(file,fileType, duration){ 
				$f("videoFile", "<?php echo base_url();?>player/flowplayer/flowplayer.commercial-3.2.15.swf", {
				 // product key from toadsquare account
				key: '#$d777e0ef81a36136b1b',
				// now we can tweak the logo settings
				logo: {
					url: '<?php echo base_url();?>images/logo-tod-square.png',
					fullscreenOnly: false,
					displayTime: 2000
				},
				// common clip: these properties are common to each clip in the playlist
				clip: { 
					// by default clip lasts 5 seconds
				  scaling: "scale",
				  autoPlay: false,
				  autoBuffer: true,
				  image:true,
				  coverImage:{"url":"<?php echo base_url('images/no_images.png');?>"}
				},
				
				// playlist with four entries
				playlist:  [
				{
					url: file,
					scaling: "scale",
					autoPlay: false,
					autoBuffer: true,
					image:true,
					coverImage:{"url":"<?php echo base_url('images/no_images.png');?>"}
				}	,
				],
				
				play: {
					label: '',
					replayLabel: "play again"
				}
			});
		}
		playMediaFile('<?php echo base_url('media/tLGUCjH4/project/filmNvideo/24/file/converted/p17i8lmggeao81tjahdjsfe1n7d4.mp4'); ?>','<?php echo 'video'; ?>','<?php echo '00:20:00'; ?>');
		
	</script>
</body>
</html>
