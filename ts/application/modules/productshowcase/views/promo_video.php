<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); ?>
<?php //print_r($promo_video);?>
<?php
 if(!empty($promo_video)){?>
          <div class="scroll_box darkGrey_bg global_shadow pt15 pb10 bdr_d2d2d2">
            <div class="clr_white font_size14 pl20"><b>Video</b></div>
				<div class="ml17 mr17 mt11">
					<div class="bdr_whiteAll iframe_container">
						<?php 
						/*$mediaArray['mediaId']=$promo_video[0]['fileId'].'_full';  // media file Id
						$mediaArray['loginUserID']=isLoginUser(); // login user Id
						$mediaArray['entityID']=$promo_video[0]['entityId']; // entity Id
						$mediaArray['elementID']=$promo_video[0]['prodId']; //element id
						$mediaArray['projectID']=$promo_video[0]['prodId']; // project id
						$mediaArray['width']='246'; // width
						$mediaArray['height']='130'; // height*/
						$mediaId= $promo_video[0]['fileId'];  // media file Id
						//$mediaId= 4740; 
						$entityId=$promo_video[0]['entityId']; // entity Id
						$elementId=$promo_video[0]['prodId']; //element id
						$projectId=$promo_video[0]['prodId'];  // project id
						//echo Modules::run("player/getPlayer", $mediaArray);
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
			
					?>
					<iframe src="<?php echo $src; ?>" width="246" height="130" frameborder="0"  webkitAllowFullScreen mozallowfullscreen allowFullScreen scrolling="no"></iframe>
					<div class="clear"></div>
					</div>
				<div class="font_opensansSBold clr_white">
					<div class="font_size13 mt10 mb8"><?php echo getSubString(@$promo_video[0]['mediaTitle'],50); ?></div>
					<div class="line8"></div>
					<div class="font_size11 mt6 mb3"><?php echo changeToUrl(getSubString(@$promo_video[0]['mediaDescription'],150)); ?></div>			
				</div>        
				</div>
		</div>
          
<?php } ?>
