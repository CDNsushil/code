<script type="text/javascript" src="<?php echo base_url('player/flowplayer/flowplayer-3.2.4.min.js');?>"></script>
<?php if (!defined('BASEPATH')) exit('No direct script access allowed');?>
<?php $videoPath = $getVideoDetail->filePath;

$workPromotionMedia = base_url().$getVideoDetail->filePath.$getVideoDetail->fileName;

if($videoPath != ''){ ?>
	<div id='videoFile' class='videoFilework'></div>
	<?php } else{
	echo $getVideoDetail->fileName;
	}?>
<script type="text/javascript" charset="utf-8">
	 function PlayVideo(file, duration){
		$f("videoFile", "<?php echo base_url();?>player/flowplayer/flowplayer-3.2.7.swf", {
			// common clip: these properties are common to each clip in the playlist
			clip: {
				// by default clip lasts 5 seconds
			  scalincg: "fit",
			  autoPlay: false,
			  autoBuffer: true,
			  image:true
			},

			// playlist with four entries
			playlist: [
				{url: file}
			],

			// show playlist buttons in controlbar
			 plugins:  {
				controls: {
					playlist: true,
					// use tube skin with a different background color
				url: '<?php echo base_url();?>player/flowplayer/flowplayer.controls-air-3.2.5.swf',
					backgroundColor: '#aedaff'
				}
			},
			play: {
				label: null,
				replayLabel: playAgain
			}
		});
	}
<?php
	echo 'PlayVideo("'.$workPromotionMedia.'")';
?>
</script>

