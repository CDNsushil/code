<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); ?>
<div class="width_451 sub_col_middle global_shadow">
<div class="upcoming_title01 pb5"><?php echo $this->lang->line('introductoryMedia');?></div>
              <div class="seprator_6"></div>
              <?php
               $divSep_10 ='<div class="seprator_10"></div>';
              
						foreach($promoMedias as $media_k=>$upcomingPromoMedia)
						{	
							$mediaType = $upcomingPromoMedia['mediaType'];
							if(@$upcomingPromoMedia['thumbFileId']>0)
							{
								$mediaDetail = getMediaDetail(@$upcomingPromoMedia['thumbFileId']);
								
								if(is_array($mediaDetail) && !empty($mediaDetail))
								{
									$thumbImgPath = @$mediaDetail[0]->filePath;
									$thumbImgName = @$mediaDetail[0]->fileName;
								}else
								{
									$thumbImgPath = 'no';
									$thumbImgName = 'no';
								}
							}	
							else
							{
								$thumbImgPath = 'no';
								$thumbImgName = 'no';
							}						
							if($mediaType==2) {								
								$thumbImage = addThumbFolder(@$thumbImgPath.'/'.@$thumbImgName,'_s');								
								$thumbFinalImg = getImage($thumbImage,$this->config->item('defaultVideoImg'));
								$mediaTypeValue = 'Video';
								$viewText = 'View';
							}
							else if($mediaType==3) {								
								$thumbImage = addThumbFolder(@$thumbImgPath.'/'.@$thumbImgName,'_s');								
								$thumbFinalImg = getImage($thumbImage,$this->config->item('defaultAudioImg'));								
								$mediaTypeValue = 'Audio';
								$viewText = 'Listen';
							}
							else{								
								$thumbImage = addThumbFolder(@$thumbImgPath.'/'.@$thumbImgName,'_s');							
								$thumbFinalImg = getImage($thumbImage,$this->config->item('defaultDocImg'));							
								$mediaTypeValue = 'Text';
								$viewText = 'Read';
							}
							
							?>
							<a href="javascript:void(0);" onclick="openLightBox('popupBoxWp','popup_box','/upcomingfrontend/popupMedia','<?php echo $upcomingPromoMedia['mediaId'];?>','<?php echo $upcomingPromoMedia['mediaType'];?>','<?php echo $mediaEntityId; ?>');">
							<div class="row intro_media_box global_shadow">
							<div class="cell intro_media_thumb">
								<div class="AI_table">
								<div class="AI_cell">
									<img class="max_h144_w144 bdr_cecece" src="<?php echo $thumbFinalImg;?>">
								</div>
								</div>
							</div>
							<div class="cell ml3 width_256">
								<div class="intro_media_title hoverOrange"><?php echo getSubString($upcomingPromoMedia['mediaTitle'],30);?></div>
								<div class="line1"></div>
								<div class="pt5 max_min_h108"><?php echo getSubString($upcomingPromoMedia['mediaDescription'],220);?></div>
								<a class="Fright orange_color gray_clr_hover" href="javascript:void(0);" onclick="openLightBox('popupBoxWp','popup_box','/upcomingfrontend/popupMedia','<?php echo $upcomingPromoMedia['mediaId'];?>','<?php echo $upcomingPromoMedia['mediaType'];?>','<?php echo $mediaEntityId; ?>');"><?php echo $viewText;?></a>
								<!--<a class="Fright orange_color" href="javascript:void(0);" onclick="openLightBox('popupBoxWp','popup_box','/player/getPlayer/','<?php echo $upcomingPromoMedia['mediaId'];?>','<?php echo $upcomingPromoMedia['mediaType'];?>');"><?php echo $viewText;?></a>-->
							</div>
							<div class="clear"></div>						
							<?php
						
							echo '</div></a>';
								if($media_k+1<count($promoMedias)) echo $divSep_10;
						}//End Foreach
				?>
  </div>
<?php echo $divSep_10;?>
