<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
$count=0;
$countResult=(isset($countResult) && $countResult >0)?$countResult:0;
$deleteCache=$industryType.'_'.$projectId.'_'.$userId; 
	$formAttributes = array(
		'name'=>'mediaList',
		'id'=>'mediaList'
	);	
	$project=isset($projects[0])?$projects[0]:false;
 	$count=0;
	$imagetype=$fileConfig['defaultImage_xs'];
	if(isset($projectElements)){
		$project['elements']=$projectElements;
	}
	//echo '<pre />';print_r($project['elements']);
	
	if(isset($project['elements'])){
		$seller_currency=LoginUserDetails('seller_currency');
		$seller_currency=($seller_currency>0)?$seller_currency:0;
		$currencySign=$this->config->item('currency'.$seller_currency);
		$sectionId=$this->config->item($industryType.'SectionId');
		$count=count($project['elements']);
		foreach($project['elements'] as $k=>$element){
			$uniqueId='element'.$element['elementId'];
			$isBlocked=$project['isBlocked'];
			$isElementBlocked=$element['isBlocked'];
			$redBorder3px=($isBlocked == 't' || $isElementBlocked == 't')?'redBorder3px':'';
			
			if($industryType=='photographyNart'){
				
				if($element['isExternal']=='t'){
					
					$finalElementImage =  checkExternalImage($element['filePath'],'_xs');
			
				}else{
					$finalElementImage=$element['filePath'].$element['fileName'];
				}
									
			}else{
				$finalElementImage=$element['imagePath'];
			}
			
			/*$elementThumbImage = addThumbFolder(@$finalElementImage,'_xs');				
			$elementImage = getImage(@$elementThumbImage,$imagetype);*/
			
			if($industryType=='filmNvideo'){
				if(empty($element['imagePath'])){	
				$thumbImage = getVideoThumbFolder(@$element['filePath'].$element['fileName'],'_xs');	
				$elementImage=getImage($thumbImage,$imagetype);	
				}else{
					$elementThumbImage = addThumbFolder(@$finalElementImage,'_xs');				
					$elementImage = getImage(@$elementThumbImage,$imagetype);
				}
			}else{
				
					$elementThumbImage = addThumbFolder(@$finalElementImage,'_xs');				
					$elementImage = getImage(@$elementThumbImage,$imagetype);
					
					if($element['isExternal']=='t' && $industryType=='photographyNart'){
						$elementImage = $finalElementImage;
					}
				
			}
			
			if($element['isExternal']=='t'){
				$fileDirPath='';
			}else{
				$fileDirPath=$element['filePath'].$element['fileName'];
				if(!is_file($fileDirPath)){
					$fileDirPath='';
				}
			}
			$convsrsionFlag=false;
			$isconverted=true;
			//$sessionMsg=$this->lang->line('mediaCheckBeforePublishMsg');
			$sessionMsg=$this->lang->line($project['projectType'].'CheckBeforePublishMsg');
			$convsrsionFileType=$this->config->item('convsrsionFileType');
			if($element['isExternal']=='f' && in_array($element['fileType'],$convsrsionFileType)){
				$convsrsionFlag=true;
				if($element['jobStsatus'] == 'DONE'){
					$conversionStatusClass='icon_filesent';
					$conversionStatusToolTip=$this->lang->line('Converted');
				}elseif($element['jobStsatus'] == 'FAILS'){
					$isconverted=false;
					$conversionStatusClass='icon_filetransfer';
					$conversionStatusToolTip=$this->lang->line('conversionFailed');
					$sessionMsg=$this->lang->line('conversionFailedPublishMsg');
				}else{
					$isconverted=false;
					$conversionStatusClass='icon_inprocess';
					$conversionStatusToolTip=$this->lang->line('converting');
					$sessionMsg=$this->lang->line('conversionProgressPublishMsg');
				}
			}
			
			if((isset($element['default']) && $element['default'] == 't') ||  ($element['isExternal'] == 't')){
				$isPurchasedItem=false;
			}else{
				$sellExpiryDate=$isPurchasedItem=checkDownloadPPVaccess($elementEntityId,$element['elementId'],$element['projId']);
			}
			
			if($element['isPublished']=='t'){
				$viewDisplay='';
				$previewDisplay='style="display: none;"';
				
				$rtspDisplay='';
				$rtsupDisplay='style="display: none;"';
				
				$pDisplay='';
				$upDisplay='style="display: none;"';
			}else{
				$viewDisplay='style="display: none;"';
				$previewDisplay='';
				
				$rtspDisplay='style="display: none;"';
				$rtsupDisplay='';
				
				$pDisplay='style="display: none;"';
				$upDisplay='';
			}
			
			// echo Modules::run("common/profileImage",$elementImage);?>
			<div id="row<?php echo $element['elementId'];?>">
			 <div class="row blog_wrapper new_theme_second_gray new_theme_bdr <?php echo $redBorder3px;?>">
			  <div class="blog_box new_theme_second_gray pt4 pb3">
				<div class="cell blog_left_wrapper width_100_per">
				 <div class="orange_color new_theme_sub_heading row"><?php echo $element['title'];?></div>
					<?php 
					if($isBlocked != 't' && $isElementBlocked != 't'){ ?> 
						<div class="new_theme_small_btn_wp ">
							<div class="tds-button-top"> 
								 <?php 
								 if($isArchive=='f' && $isBlocked == 'f' && $isElementBlocked == 'f'){ 
									$viewLink='mediafrontend/'.$this->config->item($industryType.'Sl').'/'.$userId.'/'.$element['projId'].'/'.$element['elementId'];
									$viewTooltip=$this->lang->line('view');
									
									$previewTooltip=$this->lang->line('preview');
									$previewLink='mediafrontend/preview/'.$userId.'/'.$element['projId'].'/'.$element['elementId'].'/'.$this->config->item($industryType.'Sl');
									 
									 ?> 
									<a href="<?php echo base_url(lang().'/media/'.$industryType.'/editProject/uploadMedia/'.$element['projId'].'/'.$element['elementId']);?>" class="formTip" title="<?php echo $this->lang->line('edit')?>"><span><div class="projectEditIcon"></div></span></a>
									<a id="viewIcon<?php echo $uniqueId;?>" class="formTip ml6 viewIcon" <?php echo $viewDisplay;?> target="_blank" href="<?php echo base_url($viewLink);?>" title="<?php echo $viewTooltip;?>"><span><div class="projectPreviewIcon"></div></span></a>
									<a id="previewIcon<?php echo $uniqueId;?>" class="formTip ml6 previewIcon" <?php echo $previewDisplay;?> target="_blank" href="<?php echo base_url($previewLink);?>" title="<?php echo $previewTooltip;?>"><span><div class="projectPreviewIcon"></div></span></a>
									<?php 
								  }
								  if($isPurchasedItem){
									 $elementCannotDelete = $this->lang->line('elementCannotDelete').$sellExpiryDate;
									 $deleteFunction="customAlert('".$elementCannotDelete."');";
								  }else{
									  $deleteFunction="moveMediaElementInTrash('".$element['projId']."','".$elemetTable."','".$element['elementId']."','".$sectionId."','".$this->lang->line('sureDelMsg')."');";
								  }
								  ?> 
								  <a href="javascript:void(0);" class="formTip ml6" onclick="<?php echo $deleteFunction;?>" title="<?php echo $this->lang->line('delete');?>"><span><div class="projectDeleteIcon"></div></span></a> 
							 </div>
						 </div><!--new_theme_small_btn_wp-->
						 <?php
					}?>
				
				<div class="clear"></div>
				<div class="fl width_106  mr9">
					 <div class="user_pic_wp_new_theme">
						<img  src="<?php echo $elementImage;?>" class="max_w_79 max_h_59 user_new_theme_pic"/>
			  
					</div><!--user_pic_wp_new_theme-->
				</div>
				
				<div class="fl width_422">
					<div class="width_139 crave_seprator mr13">
						<div class="new_crave_icon_box">
						</div><!--new_crave_icon_box-->
						
						<div class="fl width_56 ml5"><?php echo $constant['project_craved']?></div>
						 <div class="fl width_30 ml5"><b><?php echo $element['craveCount'];?></b></div>
						 
						 <div class="clear seprator_15"></div>
						 <div class="new_review_icon_box">
						</div><!--new_crave_icon_box-->
						
						<div class="fl width_56 ml5 mt2"><?php echo $constant['project_reviews']?></div>
						 <div class="fl width_30 ml5 mt2"><b><?php echo $element['reviewCount'];?></b></div>
					</div>
					
					
					<div class="width_141 crave_seprator2">
						<div class="new_views_icon_box">
						</div><!--new_crave_icon_box-->
						
						<div class="fl width_56 ml5"><?php echo $constant['project_views']?></div>
						 <div class="fl width_30 ml5"><b><?php echo $element['viewCount'];?></b></div>
						 
						 <div class="clear seprator_15"></div>
						 <div class="new_lastview_wp ml2 mt2"> <?php echo $constant['project_lastViewed']?>
						 <div class="seprator_5"></div>
									<b><?php echo date('d M Y');?></b> 
						</div>
						
					   
						
					</div>
					
					<div class="width_126 crave_seprator bg-non ">
						
						<span class="width_106 mt2 fl"><?php echo $constant['project_downloaded'];?></span>
						 <span class="width_20 mt2 fl"><b><?php echo $element['dwnCount'];?></b></span>
						  <div class="clear seprator_15"></div>
						  
						<?php 
						if((@$element['default'] != 't') &&  (@$element['isPerViewPrice'] == 't') && (@$project['projSellstatus']=='t')){ ?>
						  <span class="width_106 mt4 fl"><?php echo $constant['project_ppv'];?></span>
						  <span class="width_20 fl mt4"><b><?php echo $element['ppvCount'];?></b></span>
							<?php
						}?>
						 
					  
					  
					</div>
					
				   
				</div><!--width_422-->
			   
			<div class="row">
					<div class="new_theme_rating_box_wrapper mt10 mr7 cell">
						<?php
							$ratingAvg=$element['ratingAvg'];
							$ratingAvg=roundRatingValue($ratingAvg);
							$ratingImg=base_url('images/rating/rating_0'.$ratingAvg.'.png');
						?>
						<img src="<?php echo $ratingImg;?>" />
					 </div>
					
				  <div class="fl blog_links_wrapper pt0 ml12 cell">
				  
					  <?php
					  
						$currentUrl = base_url(lang().'/mediafrontend/'.$showCaseMethod.'/'.$userId.'/'.$element['projId'].'/'.$element['elementId'].'/viewelement');
						if($industryType=='reviews' || $industryType=='news'){
							$relation = array('getShortLink', 'share','entityTitle'=> $element['title'], 'shareType'=>$constant['project_heading'], 'shareLink'=> $currentUrl,'id'=> $elemetTable.$element['elementId'],'entityId'=>$elementEntityId,'elementid'=>$element['elementId'],'projectType'=>$project['projectType'],'isPublished'=>$element['isPublished']);

						}else{
							$relation = array('getShortLink', 'share','show','entityTitle'=> $element['title'], 'shareType'=>$constant['project_heading'], 'shareLink'=> $currentUrl,'id'=> $elemetTable.$element['elementId'],'entityId'=>$elementEntityId,'elementid'=>$element['elementId'],'projectType'=>$project['projectType'],'isPublished'=>$element['isPublished']);
						} 
						
						
						?>
						
						<div id="relationToSharePublish<?php echo $uniqueId;?>" class="row rtsp" <?php echo $rtspDisplay; ?> >
							<?php $relation['isPublished']='t';
							 $this->load->view('common/relation_to_share',array('relation'=>$relation));
							 ?>
						</div>
						
						<div id="relationToShareUnPublish<?php echo $uniqueId;?>" class="row rtsup" <?php echo $rtsupDisplay; ?>>
							<?php $relation['isPublished']='f';
							 $this->load->view('common/relation_to_share',array('relation'=>$relation));
							 ?>
						</div>
						
					 
					  
				  </div>
				  
				  <div class="new_theme_rating_box_wrapper mt8 mr7 cell">
						<?php
							if($convsrsionFlag){ ?>
								<div class="fl mr30 formTip <?php echo $conversionStatusClass;?>" title="<?php echo $conversionStatusToolTip;?>"> </div>											
								<?
							}
						?>
					 </div>
					<?php
					if($isElementBlocked=='f' && $isBlocked=='f'){ 	
						$isFARF=0;
						if(($project['isPublished']=='t') && $isconverted){
							$isFARF=1;
						}else{
							$isFARF=0;
						}
						
						if($project['projectType']=='news' ||$project['projectType']=='reviews'){
							if(strcmp($element['IndustryKey'],'educationalmaterial')==0){
								$notificationProjectType =  'educationalMaterial';
							}
							else {
								$notificationProjectType =  str_replace('&', 'N',$element['IndustryKey']);
							}
						}
						else {
							$notificationProjectType = $project['projectType'];
						}
						
						$notificationArray = array('entityId'=>$elementEntityId,'projectId'=>$element['projId'],'elementId'=>$element['elementId'],'industryId'=>isset($element['industryId'])?$element['industryId']:$project['IndustryId'],'projectType'=>$notificationProjectType,'alert_type'=>'element');
							
						if($project['projectType']=='reviews'){
							
							$notificationArray['yourReviews'] = array('entityId'=>$element['entityId'],'projectId'=>$element['projectId'],'elementId'=>$element['projectElementId'],'industryId'=>$element['industryId'],'reviewBy'=>$element['userId'],'projectType'=>'yourReviews','alert_type'=>'element');
						}
						
						if($isArchive=='f' && $isBlocked=='f'){ 
							$publisButton=array('isFARF'=>1,'currentStatus'=>$this->lang->line('Publish'),'changeStatus'=>$this->lang->line('hide'),'isPublished'=>'t','tabelName'=>$elemetTable,'pulishField'=>'isPublished','field'=>'elementId','fieldValue'=>$element['elementId'],'projectId'=>$element['projId'],'deleteCache'=>$deleteCache, 'elementTable'=>'', 'elementField'=>'','sessionMsg'=>$sessionMsg,'isElement'=>1,'notificationArray'=>$notificationArray);
							$unpublisButton=array('isFARF'=>$isFARF,'currentStatus'=>$this->lang->line('hide'),'changeStatus'=>$this->lang->line('Publish'),'isPublished'=>'f','tabelName'=>$elemetTable,'pulishField'=>'isPublished','field'=>'elementId','fieldValue'=>$element['elementId'],'projectId'=>$element['projId'],'deleteCache'=>$deleteCache, 'elementTable'=>'', 'elementField'=>'','sessionMsg'=>$sessionMsg,'isElement'=>1,'notificationArray'=>$notificationArray);
							?>
							
							<div id="PublishButton<?php echo $uniqueId;?>" class="cell fr PublishButton" <?php echo $pDisplay; ?>>
								<?php  $this->load->view('common/publishUnpublish',$publisButton); ?>
							</div>
							
							<div id="UnPublishButton<?php echo $uniqueId;?>" class=" cell fr UnPublishButton" <?php echo $upDisplay; ?>>
								<?php $this->load->view('common/publishUnpublish',$unpublisButton);?>
							</div>
							<?php
						}
					}	
					?>
			</div><!--row-->
			   
			   
				</div>
				
				<div class="clear"></div>
			  </div>
			  <!--blog_box-->
			</div>
			 <div class="shadow_blog_box"> </div>
			</div>
	
			<?php
		  }
		  
			if($items_total >  $perPageRecord){
				?>
				 <div class="row">
					<div class="cell width_569  pagingWrapper">
						<?php 
						$pagingnationData=array("pagination_links"=>$pagination_links,"items_total"=>$items_total,"items_per_page"=>$items_per_page,"perPageRecord"=>$perPageRecord,"url"=>base_url(lang().'/media/'.$industryType.'/'.$element['projId']),"divId"=>"mediaElementList","formId"=>0,"unqueId"=>"full","isShowNumber"=>true,"isShowDD"=>true,"pagingWpaerClass"=>'pagination_wrapper new_page_design new_page_design',"pagingDDDClass"=>'left_site_dropdown m0 new_page_design new_page_design');
						
						$this->load->view('pagination',$pagingnationData); ?>
					</div>
					<div class="clear"></div>
				</div>
				<?php
			}
		}
	  ?>




<div class="clear"></div>
<div class="clear seprator_10"></div>
<?php
/* End of file filmNvideoElements.php */
/* Location: ./application/module/media/view/filmNvideoElements.php */
/* Wriiten By Sushil Mishra */
?>
