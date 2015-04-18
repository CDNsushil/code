<?php if (!defined('BASEPATH')) exit('No direct script access allowed');?>
<script type="text/javascript" src="<?php echo base_url('player/flowplayer/flowplayer-3.2.4.min.js')?>"></script>
<?php
if($fileType=='external' || $fileType=='embed' || $fileType==5){
	$file=urldecode($file);
	echo $file;	
}else{ 
	$file=getImage($file);
	?>
	<div id='videoFile' class="width400px height250"></div>
	<script type="text/javascript" charset="utf-8">
		 function playMediaFile(file,fileType, duration){ 
			$f("videoFile", "<?php echo base_url();?>player/flowplayer/flowplayer-3.2.12.swf", {

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
				
				play: {
					label: null,
					replayLabel: "click to play again"
				}
			});
		}
		playMediaFile('<?php echo $file; ?>','<?php echo $fileType; ?>','<?php echo $duration; ?>');
	</script>
	<?php
}

/*     After playlist:
 * 
 * 		And before play:
 * 
 *  Video Plgins 
 * 
 * 
 * 
	 plugins:  {
		controls: {
			playlist: true,
			// use tube skin with a different background color
		url: '<?php echo base_url();?>player/flowplayer/flowplayer.controls-tube-3.2.10.swf', 
			backgroundColor: '#aedaff'
		} 
	},
	* 
*/



/*      Audio Plgins 
 * 
 * 
 * plugins: {
            audio: {
              url: 'http://releases.flowplayer.org/swf/flowplayer.audio-3.2.9.swf',
                onDuration: function(info) {
                   console.log("onDuration " + info);
               }
           }
      },
*/


