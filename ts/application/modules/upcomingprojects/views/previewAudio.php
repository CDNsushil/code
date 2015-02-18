<script type="text/javascript" src="<?php echo base_url('player/flowplayer/flowplayer-3.2.4.min.js');?>"></script>
<?php if (!defined('BASEPATH')) exit('No direct script access allowed');?>

<?php
$audioPath = $getAudioDetail->filePath;

$filePath = base_url().$getAudioDetail->filePath.$getAudioDetail->fileName;

if($audioPath == ''){
$url = $getAudioDetail->fileName;

	if (0 !== stripos($url, 'http://')) {
	echo $url;
	}
	else
	{
		$filePath = $url;

		?>
	<div id='videoFile' class='videoFileProduct'></div>
	<?php
	}
} else {
?>
<div id='videoFile' class='videoFileProduct'></div>
<?php }

//echo $filePath;?>

<script type="text/javascript" charset="utf-8">
	 function PlayVideo(file, duration){
		$f("videoFile", "<?php echo base_url();?>player/flowplayer/flowplayer-3.2.7.swf", {
			clip: {
			  scalincg: "fit",
			  autoPlay: false,
			  autoBuffer: true,
			  image:true
			},

			playlist: [
				{url: file}
			],

			 plugins:  {
				controls: {
					playlist: true,
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
	echo 'PlayVideo("'.$filePath.'")';
?>
</script>
