<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
$fileFlag=false;
if($fileDetails){
	if($fileDetails->isExternal=='t'){
		$file=trim($fileDetails->filePath);
		if($file!=''){
			$file=html_entity_decode($file);
			$file=stripslashes($file);
			if(strstr($file, 'src=')){
				$fileArr=explode('src="',$file);
				if(isset($fileArr[1])){
					$fileArr=explode('"',$fileArr[1]);
					if(isset($fileArr[0])){
						$fileFlag=true;
						$fileSrc=$fileArr[0];
						$iframe='<iframe width="660" height="330" src="'.$fileSrc.'" frameborder="0" allowfullscreen></iframe>';
					}
				}	
			}
		}
	}else{
		$filePath=trim($fileDetails->filePath);
		$fileName=trim($fileDetails->fileName);
		$file=$filePath.$fileName;
		$file=getConvertedFile($file,$convertedExt='.mp4',$convertDir ='converted')
		if($file){
			$fileFlag=true;
		}
	}
}
if(!$fileFlag){
	echo $this->lang->line('streamingNotFound');
}elseif($fileDetails->isExternal=='t'){
	echo $iframe;
}else{
	$coverImage = '';
	$fileType = 2;
	$duration = 5;
	echo "<div id='videoFile' class='width660px height330px'></div>";
	?>
	<script type="text/javascript" src="<?php echo base_url('player/flowplayer/flowplayer-3.2.4.min.js')?>"></script>
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
				  coverImage:{"url":"<?php echo $coverImage;?>"}
				},
				
				// playlist with four entries
				playlist:  [
				{
					url: file,
					scaling: "scale",
					autoPlay: false,
					autoBuffer: true,
					image:true,
					coverImage:{"url":"<?php echo $coverImage;?>"}
				}	,
				],
				
				play: {
					label: '',
					replayLabel: "play again"
				}
			});
		}
		playMediaFile('<?php echo $file; ?>','<?php echo $fileType; ?>','<?php echo $duration; ?>');
	</script>
	<?php
}
