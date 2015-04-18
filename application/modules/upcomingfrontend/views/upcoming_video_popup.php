<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); ?>
<?php //echo '<pre />';print_r($promoMedias);echo count($promoMedias);die;
if(@$promoMedias[0]['isExternal'] == 't'){
	$fileType='external';
	$file=urldecode(@$promoMedias[0]['filePath']);
}
else{
	$file = getImage(@$promoMedias[0]['filePath'].@$promoMedias[0]['fileName']);
	$fileType = 2;
	$duration = 5;
}

?>
<div class="poup_bx payperview shadow fs14 p_30">
<div class="close_btn position_absolute " onclick="$(this).parent().trigger('close');" ></div>
    <div class="bg_white width700px">
      <div class="bg_222222 pt20 pb20 pl20 pr20">
      <!--  <div class="AI_table">
          <div class="AI_cell">
			  <?php 
			//	if(@$promoMedias[0]['isExternal'] == 't')
				//	echo $file;
				//else
				 // echo "<div id='videoFile' class='width660px height330px'></div>";
			  ?>
          </div>
        </div> -->
        <?php
			//echo "mediaId=".$mediaId;
			//$mediaId=4166;
			//echo $mediaId = @$promoMedias[0]['fileId'].'_full'; // patter is like mediaId_mediaType mediaType can be clip/ full
			/*$mediaArray['mediaId']=$promoMedias[0]['fileId'].'_full';  // media file Id
			$mediaArray['loginUserID']=isLoginUser(); // login user Id
			$mediaArray['entityID']=$mediaEntityID; // entity Id
			$mediaArray['elementID']=$promoMedias[0]['projId']; //element id
			$mediaArray['projectID']=$promoMedias[0]['projId']; // project id
			$mediaArray['width']='660'; // width
			$mediaArray['height']='300'; // height*/
			$mediaId= $promoMedias[0]['fileId'];  // media file Id
			//$mediaId= 4740; 
			$entityId=$mediaEntityID; // entity Id
			$elementId=$promoMedias[0]['projId']; //element id
			$projectId=$promoMedias[0]['projId']; // project id
			$tableName = getMasterTableName('42');
								
								$mediaTableName= $tableName[0];
										 
								//get media file type 
								$getType = $this->model_common->getDataFromTabelWhereIn($mediaTableName, $field='fileType,isExternal,filePath',  $whereField='fileId', $whereValue=$mediaId, $orderBy='fileId', $order='ASC', $whereNotIn=0);
								if($getType[0]['isExternal']=="t")
								{
									//this section is for external video
									$getMediaUrlData = getMediaUrl($getType[0]['filePath']);
									$getSrc = $getMediaUrlData['getsource'];
									if($getMediaUrlData['embedtype'] == 'iframe')
									{
										 //url is valid 
										 $src = $getSrc;
									}else
									{
										$src = base_url().'en/player/commonPlayerIframe/'.$mediaId.'_full/'.$entityId.'/'.$elementId.'/'.$projectId;
									}  
									  
								}else
								{
									$src = base_url().'en/player/getPlayerIframe/'.$mediaId.'_full/'.$entityId.'/'.$elementId.'/'.$projectId;
								}  
			
			//echo Modules::run("player/getPlayer", $mediaArray); 
        ?>
          <iframe src="<?php echo $src; ?>" width="100%" height="300" frameborder="0"  webkitAllowFullScreen mozallowfullscreen allowFullScreen scrolling="no"></iframe>
								  
								  
      </div>
      <div class="seprator_1"></div>
      <!--text box-->
      <div class="up_partition_shadow pt24">
        <div class="ml60 mr60">
          <div class="up_popup_titlebottom"><?php echo $promoMedias[0]['mediaTitle'];?></div>
          <div class="pt15">
            <p><?php echo changeToUrl($promoMedias[0]['mediaDescription']);?></p>
          </div>
        </div>
      </div>
      <div class="seprator_40"></div>
    </div>
</div>
  
<?php /* if(@$promoMedias[0]['isExternal'] != 't') { ?>
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
		
		$('#close-popup').click(function(){
		$f().stop();
			$(this).parent().trigger('close');
		});
	</script>
<?php
}*/
?>
