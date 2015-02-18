<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
if(!empty($competition_entry_details->coverImage) && isset($competition_entry_details->coverImage))
		$mainCoverImage = $competition_entry_details->coverImage;
	else
		$mainCoverImage = '';
$coverImage='';
$defCoverImage=$this->config->item('defaultcompetitonEntryImg73X110');
$coverImage = addThumbFolder($mainCoverImage,$suffix='_s',$thumbFolder ='thumb',$defCoverImage);	
$projectImage = getImage($coverImage,$defCoverImage);	
$this->load->view('competition_entry_header');

?>
	<div class="row">
		<div class="main_project_heading">
			<div class="Main_heading_new fl"><?php if(isset($competition_entry_details->title)) echo html_entity_decode($competition_entry_details->title);?></div>
			</div>
	</div>
	<div class="clear"></div>

<div class="row mt6 position_relative">
<?php echo Modules::run("common/strip");
if($get_num_rows > 0)
{
$competitionId  = $competitionId= $competition_entry_details->competitionId;	
$competitionEntryId = $competition_entry_details->competitionEntryId;	
$isArchive = $competition_entry_details->isArchive;
$isBlocked = $competition_entry_details->isBlocked;
$isExpired = $competition_entry_details->isExpired;
$isPublished = $competition_entry_details->isPublished;
$title = $competition_entry_details->title;
$createdDate = $competition_entry_details->createdDate;
$onelineDescription = $competition_entry_details->onelineDescription;
$tagwords = $competition_entry_details->tagwords;
$deleteCache=$section.'_'.$competitionEntryId.'_'.$userId;

$viewLink = base_url(lang().'/competition/entriesmedia/'.$compUserId.'/'.$competitionEntryId);
$previewLink = base_url(lang().'/competition/preview/'.$compUserId.'/'.$competitionId.'/showcase');
$viewTooltip=$this->lang->line('view');
$previewTooltip=$this->lang->line('preview');

$uniqueId='project'.$competitionEntryId;
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
			<h2>Entries</h2>
				</div>
				<div class="clear"></div>
			   <div class="Cat_wrapper">
					<ul>
						<?php 
						
						$competition_entry_data  = getDataFromTabel($table='CompetitionEntry', $field='title,competitionEntryId',  $whereField=array('userId' => $userId,'isArchive' => $isArchive), '', 'competitionEntryId', 'DESC', $limit=0, $offset=0, $resultInArray=false);
						
						if(!empty($competition_entry_data) && isset($competition_entry_data))
						{
							foreach($competition_entry_data as $competition_entry)
							{
								
								$link=base_url(lang().'/competition/'.$currentMethod.'/'.$competition_entry->competitionEntryId);
								
								if($competitionEntryId==$competition_entry->competitionEntryId)
									{
										$ProjectColor='orange';
									}else{
											$ProjectColor='';
										}	
						?>	
						<li class="width200px oh"> 
							<a class="<?php echo $ProjectColor;?>"  href="<?php echo $link; ?>"><?php echo html_entity_decode(getSubString($competition_entry->title,18));?></a>
						</li>
					<?php } } ?>
					</ul>
				 </div><!--row-end-->
				<div class="seprator_20"></div>
			<!--How to publish popup -->
			<?php 
				$this->load->view('common/howToPublish',array('industryType'=>'CompetitionEntry'));
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
								 
								<!--<div class="published_heading"><?php //echo $this->lang->line('Expires'); ?></div> 
								<div class="published_date "><?php //echo dateFormatView($createdDate); ?></div>-->
								
								 <div class="clear"></div>
								 
								<div class="published_heading"><?php echo $this->lang->line('freeSpace'); ?></div> 
								<div class="published_date">
								
								<?php
									// competition container details
									$containerGetSize=(isset($competition_entry_details->containerSize) && is_numeric($competition_entry_details->containerSize))?$competition_entry_details->containerSize:$this->config->item('defaultContainerSize');
									$containerSize=bytestoMB($containerGetSize,'mb');
									$containerSize=$containerSize.' '.$this->lang->line('mb');
									
									$dirname=$dirEntry;
									$dirSize=getFolderSize($dirname);
									
									$fileMaxSize =($containerGetSize - $dirSize);
									if(!$fileMaxSize > 0){
										$fileMaxSize =0;
									}
									
									$fileMaxSize=bytestoMB($fileMaxSize,'mb');
									
									$remainingSize=$fileMaxSize.' '.$this->lang->line('mb');
									?>
								<?php echo $remainingSize.' '.$this->lang->line('outof').'&nbsp'.$containerSize;?>
									
									
								</div>
								<div class="clear"></div>
									
								</div><!--published_box_wp-->
						</div>
						<div class="seprator_10 row"></div>
						 <div class="row"> <b class="orange_color"><?php echo $this->lang->line('project_logLineDescription'); ?> </b>
							<p><?php echo nl2br(getSubString($onelineDescription, 130));?></p>
							<div class="seprator_13"></div>
							<b class="orange_color"><?php echo $this->lang->line('tagWords'); ?> </b>
							<p><?php echo nl2br(getSubString($tagwords, 130));?></p>
						 </div>
					</div>
					<div class="cell blog_right_wrapper">
					  <div class="blog_link2_wrapper">
						<div class="tds-button-top"> 
							<?php
							if($isArchive=='t'){
								if($isBlocked != 't' && $isExpired != 't'){ ?>
									<a class="formTip" href="javascript:void(0);" title="<?php echo $this->lang->line('restore');?>" onclick="moveFromArchive('','CompetitionEntry','competitionEntryId','<?php echo $competitionEntryId; ?>','isArchive','/competition/entrydeleteditems/','<?php echo $deleteCache ?>','','','','');"><span><div class="restore_btn_icon"></div></span></a>
									<?php
								}
								if($isBlocked == 'f'){ ?>
									<a href="javascript:void(0);" class="formTip ml6 comingSoon"  title="<?php echo $this->lang->line('delete');?>"><span><div class="projectDeleteIcon"></div></span></a> 
									<?php
								}
							}
							else { 
								//if($isPublished=="f") { 
								?>
								<a href="<?php echo base_url(lang().'/competition/competitionentryedit/language1/'.$competitionEntryId);?>" class="ml6 formTip" title="<?php echo $this->lang->line('edit')?>"><span><div class="projectEditIcon"></div></span></a> 
									<?php 
								//}
								?>
								<a id="viewIcon<?php echo $uniqueId;?>" class="formTip ml6 viewIcon" <?php echo $viewDisplay;?> target="_blank" href="<?php echo $viewLink;?>" title="<?php echo $viewTooltip;?>"><span><div class="projectPreviewIcon"></div></span></a>
								<a id="previewIcon<?php echo $uniqueId;?>" class="formTip ml6 previewIcon" <?php echo $previewDisplay;?> target="_blank" href="<?php echo $previewLink;?>" title="<?php echo $previewTooltip;?>"><span><div class="projectPreviewIcon"></div></span></a>
							
							<?php if($isPublished=="t"){ ?>
								<a href="javascript:void(0);" class="formTip ml6" onclick="customAlert('<?php echo $this->lang->line('cannotDeleteCompEntryMsg'); ?>')" title="Delete"><span><div class="projectDeleteIcon"></div></span></a>
							<?php } else { ?>
								<a href="javascript:void(0);" class="formTip ml6" onclick="moveInArchive('','CompetitionEntry','competitionEntryId','<?php echo $competitionEntryId; ?>','isArchive','isPublished','/competition/<?php echo $currentMethod; ?>','<?php echo $deleteCache ?>','','','','')" title="Delete"><span><div class="projectDeleteIcon"></div></span></a>
							<?php } ?>
							
								<?php
							} ?>
						</div>
						<!--icon_edit_blog-->
					  </div>
					<div class="row seprator_30"></div>
					<div class="clear"></div>
					<?php 
						
						
								
						$log_summary  = getDataFromTabel('LogSummary', $field='viewCount,lastViewDate',  $whereField=array('entityId'=>$entityId,'elementId' => $competitionEntryId), '', '', 'ASC', $limit=1, $offset=0, $resultInArray=false);
						if($log_summary)
						{
							$viewCount  = $log_summary[0]->viewCount;
						}else
						{
							$viewCount  = '0';
						}
					?>
					 <div class="blog_link3_wrapper">
							<div class="blog_link3_box">
								<div class="icon_crave2_blog"><?php echo $this->lang->line('votes'); ?></div>
								<div class="blog_link3_point"><?php echo $competition_entry_details->voteCount; ?></div>
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
								$relation = array('getShortLink', 'email','share','show','entityTitle'=> $title, 'shareType'=>$section, 'shareLink'=> $viewLink,'id'=> 'Project'.$competitionId,'entityId'=>$entityId,'elementid'=>$competitionEntryId,'projectType'=>$section,'isPublished'=>$isPublished);
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
						
						if($isArchive=='f' && $isBlocked=='f'){ 
							$sessionMsg='';
							$isFARF=1;
							$isFARF=($isPublished=='t')?1:$isFARF;
							
							$notificationArray = array('entityId'=>$entityId,'projectId'=>$competitionId,'elementId'=>$competitionEntryId,'industryId'=>0,'projectType'=>$section);
	
							if($isPublished=="f") {
								$publisButton=array('isFARF'=>1,'currentStatus'=>$this->lang->line('Publish'),'changeStatus'=>$this->lang->line('hide'),'isPublished'=>'t','isElement'=>0,'tabelName'=>'CompetitionEntry','pulishField'=>'isPublished','field'=>'competitionEntryId','fieldValue'=>$competitionEntryId,'deleteCache'=>$deleteCache, '', '','sessionMsg'=>$sessionMsg,'notificationArray'=>$notificationArray);
								$unpublisButton=array('isFARF'=>$isFARF,'currentStatus'=>$this->lang->line('hide'),'changeStatus'=>$this->lang->line('Publish'),'isPublished'=>'f','isElement'=>0,'tabelName'=>'CompetitionEntry','pulishField'=>'isPublished','field'=>'competitionEntryId','fieldValue'=>$competitionEntryId,'deleteCache'=>$deleteCache, '', '','sessionMsg'=>$sessionMsg,'notificationArray'=>$notificationArray);
								?>
								<!--<div id="PublishButton<?php echo $uniqueId;?>" class="cell fr PublishButton" <?php echo $pDisplay; ?>>
									<?php  $this->load->view('common/publishUnpublish',$publisButton); ?>
								</div>-->
								
								<div id="UnPublishButton<?php echo $uniqueId;?>" class=" cell fr UnPublishButton" <?php echo $upDisplay; ?>>
									<?php $this->load->view('common/publishUnpublish',$unpublisButton);?>
								</div> 
								<?php	
							}
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
					<?php //echo $this->lang->line('noRecord'); ?>	
				</div>
		   </div>
		<?php
	}?>	

</div>

<div class="clear"></div>
<?php
/* End of file media.php */
/* Location: ./application/module/media/view/media.php */
/* Wriiten By Sushil Mishra */
