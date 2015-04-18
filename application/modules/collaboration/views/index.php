<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

if(isset($collaborationData[0]->coverImage) && !empty($collaborationData[0]->coverImage) ){
	$mainCoverImage = $collaborationData[0]->coverImage;
}
else{
	$mainCoverImage = '';
}
$defCoverImage=$this->config->item('defaultcollaborationImage');
$coverImage = addThumbFolder($mainCoverImage,$suffix='_s',$thumbFolder ='thumb',$defCoverImage);	
$projectImage = getImage($coverImage,$defCoverImage);

$addNewProjectLink="dashboard/collaboration";	
echo $header;
?>
<div class="row">
	<div class="main_project_heading">
		<div class="Main_heading_new fl"><?php if(isset($collaborationData[0]->title)) echo html_entity_decode($collaborationData[0]->title);?></div>
		</div>
</div>
<div class="clear"></div>

<div class="row mt6 position_relative">
	
<?php $this->load->view("common/strip");

if($collaborationData && isset($collaborationData[0])){
	$collaborationData = $collaborationData[0];
	$collaborationId = $collaborationData->collaborationId;
	$isArchive = $collaborationData->isArchive;
	$isBlocked = $collaborationData->isBlocked;
	$isExpired = $collaborationData->isExpired;
	$isPublished = $collaborationData->isPublished;
	$shortDescription = $collaborationData->shortDescription;	
	$tagwords = $collaborationData->tagwords;
	$createDate = $collaborationData->createDate;
	$expiryDateColor=($isExpired=='t')?'red':'';
	$expiryDate = $collaborationData->expiryDate;
	$currentDate = date("Y-m-d H:i:s");
	if(strlen($expiryDate) < 10){
		$expiryDate= dateFormatView(date('Y-m-d',(strtotime($createDate)+(60*60*24*30*6))));
		$collaboration_expiry_date = date('Y-m-d',(strtotime($createDate)+(60*60*24*30*6)));
	}else{
		$collaboration_expiry_date = $expiryDate;
		$expiryDate= dateFormatView($expiryDate);
	}
	
	if($collaboration_expiry_date != '' && $currentDate <= $collaboration_expiry_date) {
		$expiryDateColor = '';
		$expire_label = $this->lang->line('Expires');
	} else {
		$expiryDateColor = 'clr_red';
		$expire_label = $this->lang->line('toolExpired');
	}
	
	$startDate = $collaborationData->startDate;
	$endDate = $collaborationData->endDate;
	$title = $collaborationData->title;
	$deleteCache='collaboration_'.$collaborationId.'_'.$userId;
	//$dueDate = date("d M Y",strtotime($collaborationData->dueDate));
	
	
	$uniqueId='project'.$collaborationId;
	if($isPublished=='t'){
		$rtspDisplay='';
		$rtsupDisplay='style="display: none;"';
		
		$pDisplay='';
		$upDisplay='style="display: none;"';
	}else{
		$rtspDisplay='style="display: none;"';
		$rtsupDisplay='';
		
		$pDisplay='style="display: none;"';
		$upDisplay='';
	}

	?>
    <div class="cell width_200">
		<?php 
			$this->load->view("common/profileImage",array('image'=>$projectImage));
		?>
	   <div class=" cell frm_heading mt85">
			<h2><?php echo $this->lang->line('collaboration'); ?></h2>
				</div>
	   <div class="clear"></div>
	   <div class="Cat_wrapper">
			<ul>
				<?php 
				if(!empty($collaborationList) && isset($collaborationList)){
					foreach($collaborationList as $collaboration_list){
						$link=base_url(lang().'/collaboration/'.$currentMethod.'/'.$collaboration_list->collaborationId);
						if($collaborationId==$collaboration_list->collaborationId){
							$ProjectColor='orange';
						}
						else{
							$ProjectColor='';
						}?>	
						<li class="width200px oh"> 
							<a class="<?php echo $ProjectColor;?>"  href="<?php echo $link; ?>"><?php echo html_entity_decode(getSubString($collaboration_list->title,18));?></a>
						</li>
			<?php } } ?>
			</ul>
		 </div><!--row-end-->
		<div class="seprator_25"></div>
		
		<div class=" cell frm_heading">
			<h2><?php echo $this->lang->line('collaborationAccess'); ?></h2>
		</div>
	   <div class="clear"></div>
	   <div class="Cat_wrapper">
			<ul>
				<?php 
				if(!empty($assignedCollaborationList) && isset($assignedCollaborationList)){
					foreach($assignedCollaborationList as $collaboration_list){
						$link=base_url(lang().'/collaboration/assignedCollaboration/'.$collaboration_list->collaborationId);
						?>	
						<li class="width200px oh"> 
							<a  href="<?php echo $link; ?>"><?php echo html_entity_decode(getSubString($collaboration_list->title,18));?></a>
						</li>
			<?php } } ?>
			</ul>
		 </div><!--row-end-->
	   
	   <div class="seprator_20"></div>
		<!--How to publish popup -->
		<?php 
		
			$this->load->view('common/howToPublish',array('industryType'=>'collaboration'));
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
							<div class="published_date"><?php echo dateFormatView($createDate); ?></div>
							<div class="clear"></div>
							 
							<div class="published_heading"><?php echo $expire_label; ?></div> 
							<div class="published_date <?php echo $expiryDateColor?>"><?php echo $expiryDate; ?></div>
							
							 <div class="clear"></div>
							 
							<div class="published_heading"><?php echo $this->lang->line('freeSpace'); ?></div> 
							<div class="published_date">
							<?php
							// collaboration container details
							 if($collaborationData) { 
								$containerGetSize=(isset($collaborationData->containerSize) && is_numeric($collaborationData->containerSize))?$collaborationData->containerSize:$this->config->item('defaultContainerSize');
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
								echo $collaborationData->IndustryName;
							?>
						</div>
						
						
						
					</div>
					<div class="row">  
						<div class="cell width115px">
							 <b class="orange_color"><?php echo $this->lang->line('start'); ?> </b>
						</div>
						
						<div class="cell width150px">
							<?php echo date("d M Y",strtotime($startDate)); ?>
						</div>
						
						<div class="cell width50px"><b class="orange_color"><?php echo $this->lang->line('end'); ?> </b> </div>
						<div class="cell"> <?php echo date("d M Y",strtotime($endDate)); ?> </div>
					</div>
					
					<div class="row"> 
						 <p>&nbsp;</p>
						 <b class="orange_color">
							 <?php echo $this->lang->line('project_logLineDescription'); ?>
						 </b>
							<p><?php echo nl2br(getSubString($shortDescription, 130));?></p>
							<div class="seprator_13"></div>
							<b class="orange_color">
								<?php echo $this->lang->line('tagWords'); ?>
							</b>
							<p> 
								<?php echo nl2br(getSubString($tagwords, 130));?>
							</p>
							<div class="seprator_13"></div>
					</div>
				
				</div>
				
				<div class="cell blog_right_wrapper">
				  <div class="blog_link2_wrapper">
					<div class="tds-button-top"> 
					<?php
					if($isArchive=='t'){
						if($isBlocked != 't' && $isExpired != 't'){ ?>
							<a class="formTip" href="javascript:void(0);" title="<?php echo $this->lang->line('restore');?>" onclick="moveFromArchive('','collaboration','collaborationId','<?php echo $collaborationId; ?>','isArchive','/collaboration/deleteditems/','<?php echo $deleteCache ?>','','collaborationId','isArchive','isPublished');"><span><div class="restore_btn_icon"></div></span></a>
							<?php
						}
						if($isBlocked == 'f'){ ?>
							<a href="javascript:void(0);" class="formTip ml6 comingSoon"  title="<?php echo $this->lang->line('delete');?>"><span><div class="projectDeleteIcon"></div></span></a> 
							<?php
						}
					}else{ ?>
						<a href="<?php echo base_url(lang().'/collaboration/description/'.$collaborationId);?>" class="ml6 formTip" title="<?php echo $this->lang->line('edit')?>"><span><div class="projectEditIcon"></div></span></a> 
						
							
						<?php if($isPublished != 't'){?>
							<a href="javascript:void(0);" class="formTip ml6" onclick="moveInArchive('','collaboration','collaborationId','<?php echo $collaborationId; ?>','isArchive','isPublished','/collaboration/collaborationlist/','<?php echo $deleteCache ?>','','collaborationId','isArchive','isPublished')" title="Delete"><span><div class="projectDeleteIcon"></div></span></a>
							<?php
						}
						

						
					}?>
					</div>
					<!--icon_edit_blog-->
				  </div>
				<div class="row seprator_30"></div>
				<div class="clear"></div>
				
				<div class="blog_link3_wrapper">
					<div class="blog_link3_box">
						<div class="icon_lastview2_blog"> 
							<?php echo $this->lang->line('project_lastViewed'); ?><br>
							<b><?php echo date('d M Y');?></b>
						</div>
					</div>
				</div>
				</div>	
				
				<div class="row pt15">
					<div class="cell">
						<div class="tds-button-big fl">
							<a href="<?php echo base_url(lang().'/collaboration/todos/'.$collaborationId);?>" onmousedown="mousedown_big_button(this)" onmouseout="mouseout_big_button(this)" onmouseup="mouseup_big_button(this)"><span class=""><?php echo $this->lang->line('manageProject'); ?></span></a>
						</div>
					</div>
					 
					<?php
						if($isArchive !='t' && $isBlocked !='t'){ 
							$sessionMsg='';
							$isFARF=1;
							
							
							$notificationArray = array('entityId'=>$entityId,'projectId'=>$collaborationId,'elementId'=>$collaborationId,'industryId'=>0,'projectType'=>$section);
							
							
							$publisButton=array('isFARF'=>$isFARF,'currentStatus'=>$this->lang->line('Publish'),'changeStatus'=>$this->lang->line('hide'),'isPublished'=>'t','isElement'=>0,'tabelName'=>'Collaboration','pulishField'=>'isPublished','field'=>'collaborationId','fieldValue'=>$collaborationId,'deleteCache'=>$deleteCache,'sessionMsg'=>$sessionMsg,'notificationArray'=>$notificationArray);
							$unpublisButton=array('isFARF'=>$isFARF,'currentStatus'=>$this->lang->line('hide'),'changeStatus'=>$this->lang->line('Publish'),'isPublished'=>'f','isElement'=>0,'tabelName'=>'Collaboration','pulishField'=>'isPublished','field'=>'collaborationId','fieldValue'=>$collaborationId,'deleteCache'=>$deleteCache,'sessionMsg'=>$sessionMsg,'notificationArray'=>$notificationArray);
							
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
				<input type="hidden" name="isProjectPublished<?php echo $collaborationId;?>" id="isProjectPublished<?php echo $collaborationId;?>" value="<?php echo $isPublished;?>"  />
				
				<div class="clear"></div>
			   </div>
				<div class="clear"></div>
		  
		  </div>
		
		<div class="clear"></div>
		</div>
		<div class="shadow_blog_box"></div>
		
		<div class="clear"></div>
	 </div>
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
/* End of file collaboration_list.php */
/* Location: ./application/module/collaboration/view/collaboration_list.php*/
/* Wriiten By Lokendra Meena */
