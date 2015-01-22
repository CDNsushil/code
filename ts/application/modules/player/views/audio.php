<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');?>
<html>
<body style="margin:0px;padding:0px;">
<script type="text/javascript" src="<?php echo base_url('player/flowplayer/flowplayer-3.2.4.min.js')?>"></script>
<?php
	
	//echo '<pre />';print_r($player);die;
	$file = getImage(@$player[0]->filePath.'/'.@$player[0]->fileName);
	$coverImage = getImage(@$player[0]->imagePath);
	$fileType = 'video';
	$duration = 5;
	echo "<div id='videoFile' class='width660px height330px'></div>";
	
?>
<script type="text/javascript" charset="utf-8">
		 function playMediaFile(file,fileType, duration){ 
			$f("videoFile", "<?php echo base_url();?>player/flowplayer/flowplayer-3.2.12.swf", {

				// common clip: these properties are common to each clip in the playlist
				clip: { 
					// by default clip lasts 5 seconds
				  scaling: "orig",
				  autoPlay: false,
				  autoBuffer: true,
				  image:true,
				 coverImage:{"url":"<?php echo base_url('images/no_images.png');?>"}
				},
				
				// playlist with four entries
				playlist: [
				{
					url: file,
					scaling: "orig",
					autoPlay: false,
					autoBuffer: true,
					image:true,
					coverImage:{"url":"<?php echo base_url('images/no_images.png');?>"}
				}	,
				],
				
				play: {
					label: null,
					replayLabel: "click to play again"
				}
			});
		}
		playMediaFile('<?php echo base_url().'media/S1oIKjkC/project/musicNaudio/30/file/p17ics0njr512re01u721k7j72j4.MP3'; ?>','<?php echo 'video'; ?>','<?php echo '00:20:00'; ?>');
	</script>
</body>
</html>
