<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

if(isset($competition_data[0]->coverImage) && !empty($competition_data[0]->coverImage) ){
	$mainCoverImage = $competition_data[0]->coverImage;
}
else{
	$mainCoverImage = '';
}
		
$coverImage='';
$defCoverImage=$this->config->item('defaultcompetitonImg73X110');
$coverImage = addThumbFolder($mainCoverImage,$suffix='_s',$thumbFolder ='thumb',$defCoverImage);	
$projectImage = getImage($coverImage,$defCoverImage);
	
$addNewProjectLink="dashboard/competition";	
$this->load->view('competition_header');
?>
<div class="row">
	<div class="main_project_heading">
		<div class="Main_heading_new fl"><?php if(isset($competition_data[0]->title)) echo html_entity_decode($competition_data[0]->title);?></div>
		</div>
</div>
<div class="clear"></div>

<div class="row mt6 position_relative">
	
<?php echo Modules::run("common/strip");

if($competition_data && isset($competition_data[0])){
	$competition_data = $competition_data[0];
	$competitionId = $competition_data->competitionId;
	$isArchive = $competition_data->isArchive;
	$isBlocked = $competition_data->isBlocked;
	$isExpired = $competition_data->isExpired;
	$isPublished = $competition_data->isPublished;
	$onelineDescription = $competition_data->onelineDescription;	
	$tagwords = $competition_data->tagwords;
	$createdDate = $competition_data->createdDate;
	$expiryDateColor=($isExpired=='t')?'red':'';
	$expiryDate = $competition_data->expiryDate;
	$currentDate = date("Y-m-d H:i:s");
	if(strlen($expiryDate) < 10){
		$expiryDate= dateFormatView(date('Y-m-d',(strtotime($createdDate)+(60*60*24*30*6))));
		$competition_expiry_date = date('Y-m-d',(strtotime($createdDate)+(60*60*24*30*6)));
	}else{
		$competition_expiry_date = $expiryDate;
		$expiryDate= dateFormatView($expiryDate);
	}
	
	if($competition_expiry_date != '' && $currentDate <= $competition_expiry_date) {
		$expiryDateColor = '';
		$expire_label = $this->lang->line('Expires');
	} else {
		$expiryDateColor = 'clr_red';
		$expire_label = $this->lang->line('toolExpired');
	}
	
	$submissionStartDate = $competition_data->submissionStartDate;
	$submissionEndDate = $competition_data->submissionEndDate;
	$votingStartDate = $competition_data->votingStartDate;
	$votingEndDate = $competition_data->votingEndDate;
	$title = $competition_data->title;
	$deleteCache=$section.'_'.$competitionId.'_'.$userId;
	//$dueDate = date("d M Y",strtotime($competition_data->dueDate));
	$elemetTable = 'CompetitionPrizes';
	
	$viewLink = base_url(lang().'/competition/showcase/'.$userId.'/'.$competitionId);
	$previewLink = base_url(lang().'/competition/preview/'.$userId.'/'.$competitionId.'/showcase');
	$viewTooltip=$this->lang->line('view');
	$previewTooltip=$this->lang->line('preview');

	$uniqueId='project'.$competitionId;
	if($isPublished=='t'){
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

	?>
    <div class="cell width_200">
		<?php 
			echo Modules::run("common/profileImage",$projectImage);
		?>
		<div class=" cell frm_heading mt85">
			<h2><?php echo $this->lang->line('competitions'); ?></h2>
				</div>
				<div class="clear"></div>
			   <div class="Cat_wrapper">
					<ul>
						<?php 
						$competition_list_data  = getDataFromTabel($table='Competition', $field='title,competitionId', $whereField=array('userId' => $userId,'isArchive' => $isArchive), '', 'competitionId', 'DESC', $limit=0, $offset=0, $resultInArray=false);
						if(!empty($competition_list_data) && isset($competition_list_data)){
							foreach($competition_list_data as $competition_list){
								$link=base_url(lang().'/competition/'.$currentMethod.'/'.$competition_list->competitionId);
								if($competitionId==$competition_list->competitionId){
									$ProjectColor='orange';
								}
								else{
									$ProjectColor='';
								}?>	
								<li class="width200px oh"> 
									<a class="<?php echo $ProjectColor;?>"  href="<?php echo $link; ?>"><?php echo html_entity_decode(getSubString($competition_list->title,18));?></a>
								</li>
					<?php } } ?>
					</ul>
				 </div><!--row-end-->
				<div class="seprator_20"></div>
			<!--How to publish popup -->
			<?php 
			
				$this->load->view('common/howToPublish',array('industryType'=>'Competition'));
			?>
			<!--End How to publish popup -->
			
        </div>
         
          <div class="cell width_569 padding_left16">
			<?php 
				if($isArchive=='t'){
					$this->load->view('common/deletedItemMsg');
				}
				
				if($isBlocked=='t'){
					$this->load->view('common/illegalMsg');
				}
			?>
			<!------Entries details------>
			<div class="row blog_wrapper new_theme_blog_box_gray ">
              <div class="toggle_btn"></div>
              <div class="blog_box bg-non-color">
              		<div class="one_side_small_shadow">
                    		<table width="100%"  height="100% "border="0" cellspacing="0" cellpadding="0">
							  <tr>
								<td height="97"><img  src="<?php echo base_url('images/published_shadow_top.png');?>" /></td>
							  </tr>
							  <tr>
								<td class="publish_shad_mid">&nbsp;</td>
							  </tr>
							  <tr>
								<td height="97"><img   src="<?php echo base_url('images/published_shadow_bottom.png');?>" /></td>
							  </tr>
							</table>
                    </div><!--one_side_small_shadow-->
                    
					<div class="cell blog_left_wrapper width_395  pr16">
						<div class="row">
							<div class="published_box_wp ">
								<div class="published_heading"><?php echo $this->lang->line('first_saved'); ?></div> 
								<div class="published_date"><?php echo dateFormatView($createdDate); ?></div>
								<div class="clear"></div>
								 
								<div class="published_heading"><?php echo $expire_label; ?></div> 
								<div class="published_date <?php echo $expiryDateColor?>"><?php echo $expiryDate; ?></div>
								
								 <div class="clear"></div>
								 
								<div class="published_heading"><?php echo $this->lang->line('freeSpace'); ?></div> 
								<div class="published_date">
								<?php
								// competition container details
								 if($competition_data) { 
									$containerGetSize=(isset($competition_data->containerSize) && is_numeric($competition_data->containerSize))?$competition_data->containerSize:$this->config->item('defaultContainerSize');
									$containerSize=bytestoMB($containerGetSize,'mb');
									$containerSize=$containerSize.' '.$this->lang->line('mb');
									
									$dirname=$dirMedia;
									$dirSize=getFolderSize($dirname);
									
									$fileMaxSize =($containerGetSize - $dirSize);
									if(!$fileMaxSize > 0){
										$fileMaxSize =0;
									}
									
									$fileMaxSize=bytestoMB($fileMaxSize,'mb');
									
									$remainingSize=$fileMaxSize.' '.$this->lang->line('mb');
									?>
								<?php echo $remainingSize.' '.$this->lang->line('outof').'&nbsp'.$containerSize;?>
								<?php } ?>	
								</div>
								<div class="clear"></div>
									
								</div><!--published_box_wp-->
						</div>
						<div class="seprator_10 row"></div>
						 <div class="row"> 
							<div class="cell width115px">
								 <b class="orange_color"><?php echo $this->lang->line('industry_type'); ?> </b>
							</div>
							
							<div class="cell width150px">
								<?php 
									echo $competition_data->IndustryName;
								?>
							</div>
							
							<div class="cell width50px"><b class="orange_color"><?php echo $this->lang->line('competi_total_entries'); ?> </b> </div>
							<div class="cell"> <?php echo $items_total; ?> </div>
							
						</div>
						<div class="row">  
							<div class="cell width115px">
								 <b class="orange_color"><?php echo $this->lang->line('submissions_start'); ?> </b>
							</div>
							
							<div class="cell width150px">
								<?php echo date("d M Y",strtotime($submissionStartDate)); ?>
							</div>
							
							<div class="cell width50px"><b class="orange_color"><?php echo $this->lang->line('submissions_end'); ?> </b> </div>
							<div class="cell"> <?php echo date("d M Y",strtotime($submissionEndDate)); ?> </div>
						</div>
						<div class="row"> 	 
							<div class="cell width115px">
								 <b class="orange_color"><?php echo $this->lang->line('voting_starts'); ?> </b>
							</div>
							
							<div class="cell width150px">
								<?php echo date("d M Y",strtotime($votingStartDate)); ?>
							</div>
							
							<div class="cell width50px"><b class="orange_color"><?php echo $this->lang->line('voting_end'); ?> </b> </div>
							<div class="cell"> <?php echo date("d M Y",strtotime($votingEndDate)); ?> </div>
							
						</div>
						<div class="row"> 
							 <p>&nbsp;</p>
							 <b class="orange_color"><?php echo $this->lang->line('project_logLineDescription'); ?> </b>
								<p><?php echo nl2br(getSubString($onelineDescription, 130));?></p>
								<div class="seprator_13"></div>
								<b class="orange_color"><?php echo $this->lang->line('tagWords'); ?></b>
								<p><?php echo nl2br(getSubString($tagwords, 130));?></p>
								<div class="seprator_13"></div>
							</p>
					</div>
					
					</div>
					<div class="cell blog_right_wrapper">
					  <div class="blog_link2_wrapper">
						<div class="tds-button-top"> 
						<?php
						if($isArchive=='t'){
							if($isBlocked != 't' && $isExpired != 't'){ ?>
								<a class="formTip" href="javascript:void(0);" title="<?php echo $this->lang->line('restore');?>" onclick="moveFromArchive('','Competition','competitionId','<?php echo $competitionId; ?>','isArchive','/competition/competitiondeleteditems/','<?php echo $deleteCache ?>','<?php echo $elemetTable ?>','competitionId','isArchive','isPublished');"><span><div class="restore_btn_icon"></div></span></a>
								<?php
							}
							if($isBlocked == 'f'){ ?>
								<a href="javascript:void(0);" class="formTip ml6 comingSoon"  title="<?php echo $this->lang->line('delete');?>"><span><div class="projectDeleteIcon"></div></span></a> 
								<?php
							}
						}else{ ?>
							<a href="<?php echo base_url(lang().'/competition/description/language1/'.$competitionId);?>" class="ml6 formTip" title="<?php echo $this->lang->line('edit')?>"><span><div class="projectEditIcon"></div></span></a> 
							
							<a id="viewIcon<?php echo $uniqueId;?>" class="formTip ml6 viewIcon" <?php echo $viewDisplay;?> target="_blank" href="<?php echo $viewLink;?>" title="<?php echo $viewTooltip;?>"><span><div class="projectPreviewIcon"></div></span></a>
							<a id="previewIcon<?php echo $uniqueId;?>" class="formTip ml6 previewIcon" <?php echo $previewDisplay;?> target="_blank" href="<?php echo $previewLink;?>" title="<?php echo $previewTooltip;?>"><span><div class="projectPreviewIcon"></div></span></a>
								
							<?php if($isPublished != 't'){?>
								<a href="javascript:void(0);" class="formTip ml6" onclick="moveInArchive('','Competition','competitionId','<?php echo $competitionId; ?>','isArchive','isPublished','/competition/competitionlist/','<?php echo $deleteCache ?>','<?php echo $elemetTable ?>','competitionId','isArchive','isPublished')" title="Delete"><span><div class="projectDeleteIcon"></div></span></a>
								<?php
							}
							

							
						}?>
						</div>
						<!--icon_edit_blog-->
					  </div>
					<div class="row seprator_30"></div>
					<div class="clear"></div>
					<?php 
						
						$log_summary  = getDataFromTabel('LogSummary', $field='craveCount,viewCount,lastViewDate',  $whereField=array('entityId'=>$entityId,'elementId' => $competitionId), '', '', 'ASC', $limit=1, $offset=0, $resultInArray=false);
						if($log_summary)
						{
							$craveCount = $log_summary[0]->craveCount;
							$viewCount  = $log_summary[0]->viewCount;
						}else
						{
							$craveCount = '0';
							$viewCount  = '0';
						}
					?>
					 <div class="blog_link3_wrapper">
							<div class="blog_link3_box">
								<div class="icon_crave2_blog"><?php echo $this->lang->line('craves'); ?></div>
								<div class="blog_link3_point"><?php echo $craveCount; ?></div>
							</div>
							
							<div class="blog_link3_box">
								<div class="icon_view2_blog"><?php echo $this->lang->line('Views'); ?></div>
								<div class="blog_link3_point"><?php echo $viewCount; ?></div>
							</div>
							<div class="blog_link3_box">
								<div class="icon_lastview2_blog"> 
									<?php echo $this->lang->line('project_lastViewed'); ?><br>
									<b><?php echo date('d M Y');?></b>
								</div>
							</div>
						</div>
					</div>
					<div class="row blog_links_wrapper">
						
						<div class="fl cell">
							 <?php
								$relation = array('getShortLink', 'email','share','show','entityTitle'=> $title, 'shareType'=>$section, 'shareLink'=> $viewLink,'id'=> 'Project'.$competitionId,'entityId'=>$entityId,'elementid'=>$competitionId,'projectType'=>$section,'isPublished'=>$isPublished);
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
						 
						<?php
							
							$countPrizes  = countResult('CompetitionPrizes',  $whereField=array('competitionId' => $competitionId));
					
							$seller_currency=LoginUserDetails('seller_currency');
							if($seller_currency==''){
								$isSellerSettings=false;
							}else{
								$isSellerSettings=true;
							}
							
							if($isArchive !='t' && $isBlocked !='t'){ 
								$sessionMsg='';
								$isFARF=0;
							
								if($countPrizes>0){
									$isFARF=1;
								}else{
									$isFARF=0;
									$sessionMsg=$this->lang->line('prizeErrorMessage');
								}
								
								if($isFARF && !$isSellerSettings){
									$isFARF=0;
									$sessionMsg=$this->lang->line('sellerSettingsMsg');
								}
							
								$isFARF=($isPublished=='t')?1:$isFARF;
								
								if($isPublished=='t' && $isFARF==1 && isset($competition_entries_data[0]->competitionEntryId) && is_numeric($competition_entries_data[0]->competitionEntryId) && ($competition_entries_data[0]->competitionEntryId >0)){
									$isFARF=0;
									$sessionMsg=$this->lang->line('cannotUnpublishCompMsg');
								}
								
								
								$notificationArray = array('entityId'=>$entityId,'projectId'=>$competitionId,'elementId'=>$competitionId,'industryId'=>0,'projectType'=>$section);
								
								$publisButton=array('isFARF'=>$isFARF,'currentStatus'=>$this->lang->line('Publish'),'changeStatus'=>$this->lang->line('hide'),'isPublished'=>'t','isElement'=>0,'tabelName'=>'Competition','pulishField'=>'isPublished','field'=>'competitionId','fieldValue'=>$competitionId,'deleteCache'=>$deleteCache, 'elementTable'=>$elemetTable, 'elementField'=>'competitionId','sessionMsg'=>$sessionMsg,'notificationArray'=>$notificationArray);
								$unpublisButton=array('isFARF'=>$isFARF,'currentStatus'=>$this->lang->line('hide'),'changeStatus'=>$this->lang->line('Publish'),'isPublished'=>'f','isElement'=>0,'tabelName'=>'Competition','pulishField'=>'isPublished','field'=>'competitionId','fieldValue'=>$competitionId,'deleteCache'=>$deleteCache, 'elementTable'=>$elemetTable, 'elementField'=>'competitionId','sessionMsg'=>$sessionMsg,'notificationArray'=>$notificationArray);
								
								?>
								<div id="PublishButton<?php echo $uniqueId;?>" class="cell fr PublishButton" <?php echo $pDisplay; ?>>
									<?php  $this->load->view('common/publishUnpublish',$publisButton); ?>
								</div>
								
								<div id="UnPublishButton<?php echo $uniqueId;?>" class=" cell fr UnPublishButton" <?php echo $upDisplay; ?>>
									<?php $this->load->view('common/publishUnpublish',$unpublisButton);?>
								</div> 
								<?php
							}
						?> 
					<input type="hidden" name="isProjectPublished<?php echo $competitionId;?>" id="isProjectPublished<?php echo $competitionId;?>" value="<?php echo $isPublished;?>"  />
					
					<div class="clear"></div>
				   </div>
					<div class="clear"></div>
              </div>
            </div>
			
			<!------Entries details ------>
			
			<div class="shadow_blog_box"></div>
			
			<?php $this->load->view('competition_entries_view'); ?>
			
			
			</div>
			
			
			
          <div class="clear"></div>
		<?php
}
else{
		
		//$constant['project_noRecordFound'];
		?>
          <div class="cell width_200">
            <?php echo Modules::run("common/profileImage",$projectImage);?>
           </div>
           <div class="cell width_488 margin_left_55 pr">
				<div id="showContainer">
					<?php
					if($isArchive=='t'){
						//echo $this->lang->line('noRecord');
					}else{ ?>
						<script>
								AJAX('<?php echo base_url(lang().'/package/getAvailableUserContainer');?>','showContainer','<?php echo $sectionId?>','<?php echo $addNewProjectLink?>','1');
						</script>
					<?php } ?>	
				</div>
		   </div>
		<?php
	}?>	

</div>

<div class="clear"></div>
<?php
/* End of file competition_list.php */
/* Location: ./application/module/competition/view/competition_list.php*/
/* Wriiten By Lokendra Meena */
