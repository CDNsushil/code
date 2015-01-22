<?php if (!defined('BASEPATH')) exit('No direct script access allowed'); 
$url = base_url()."templates/system/slider"?>
<script type="text/javascript" src="<?php echo $url?>/js/jquery.lightbox-0.5.js"></script>
<link rel="stylesheet" type="text/css" href="<?php echo $url?>/css/jquery.lightbox-0.5.css" media="screen" />
<?php
$entityId = getMasterTableRecord('Work');	 
if(isset($work) && is_array($work) && count($work) > 0){
	
	
	$isAnyItemBlocked=isAnyItemBlocked($work,false);
	$count = 0;
	$i=0;
	foreach($work  as $row)
	{
		$i++;
		$uniqueId='element'.$row['workId'];
		if($row['isPublished']=='t'){
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
		$sliderImages = getProductImages('TDS_workPromotionMedia','workId',$row['workId'], 1, 'isMain');// Defination is on Common controller
		
		//print_r($sliderImages);
		$count++;
		
		if(!empty($sliderImages))
		{
			foreach($sliderImages as $image) $workImage = $image->filePath.$image->fileName;
		}
		else
		{
			$workImage = '';
		}
		
		
		$isBlocked=$row['isBlocked'];
		$redBorder3px=($isBlocked=='t')?'redBorder3px':'';
		$isExpired=$row['isExpired'];
		$expiryDateColor=($isExpired=='t')?'red':'';
		$createDate=$row['workCreateDate'];
		$expiryDate=$row['expiryDate'];
		$currentDate = date("Y-m-d H:i:s");
		if(strlen($expiryDate) < 10){
			 $expiryDate= dateFormatView(date('Y-m-d',(strtotime($row['workCreateDate'])+(60*60*24*30*6))))	;
			 $work_expiry_date = date('Y-m-d',(strtotime($row['workCreateDate'])+(60*60*24*30*6)));
		}else{
			$work_expiry_date = $expiryDate;
			$expiryDate= dateFormatView($expiryDate);
		}
		
		if($work_expiry_date != '' && $currentDate <= $work_expiry_date) {
			$expiryDateColor = '';
			$expire_label = $this->lang->line('toolExpires');
		} else {
			$expiryDateColor = 'clr_red';
			$expire_label = $this->lang->line('toolExpired');
		}
		
		$createDate=dateFormatView($createDate);
		
		$containerSize=(isset($row['containerSize']) && is_numeric($row['containerSize']))?$row['containerSize']:$this->config->item('defaultContainerSize');
		$containerSize=bytestoMB($containerSize,'mb');
		
		$dirname = 'media/'.LoginUserDetails('username').'/work/'.$row['workType'].'/'.$row['workId'].'/';
		$dirSize=bytestoMB(getFolderSize($dirname),'mb');
		$remainingSize=($containerSize-$dirSize);
		if($remainingSize < 0){
			$remainingSize = 0;
		}
		$remainingSize = number_format($remainingSize,2,'.','');
		$remainingSize=$remainingSize.'&nbsp;'.$this->lang->line('mb');
		$containerSize=$containerSize.'&nbsp;'.$this->lang->line('mb');
		
		//Get Counts in work 
		$LogSummarywhere = array(
					'entityId'=>$entityId,
					'elementId'=>$row['workId']
		);
		$resLogSummary = getDataFromTabel('LogSummary', 'craveCount,ratingAvg,viewCount',  $LogSummarywhere, '', $orderBy='', '', 1 );
	
		if($resLogSummary)
		{
			$resLogSummary = $resLogSummary[0];
			$viewCount = $resLogSummary->viewCount;
			$craveCount = $resLogSummary->craveCount;
			$ratingAvg = $resLogSummary->ratingAvg;
		}else
		{
			$viewCount = 0;
			$craveCount = 0;
			$ratingAvg = 0;
		}
		
		$ratingAvg = roundRatingValue($ratingAvg);
		$ratingImg=base_url('images/rating/rating_0'.$ratingAvg.'.png');
		$cravedALL = '';
		$loggedUserId = $userId;
		
		if($loggedUserId > 0){
			
			$where = array(
					'tdsUid'=>$loggedUserId,
					'entityId'=>$entityId,
					'elementId'=>$row['workId']
				);
			$countResult = countResult('LogCrave',$where);
			$cravedALL = ($countResult>0)?'admin_cravedALL':'';
			
		}else
		{
			$cravedALL = '';
		}
		
										
		if($i==1 && ($isArchive=='t' || $isAnyItemBlocked==true)){
			?>
	
			<div class="row">
					<div class=" cell width_200 Cat_wrapper">	&nbsp;	</div>
					<div class="cell width_569 margin_left_16">
					<?php 
						if($isArchive=='t'){
							$this->load->view('common/deletedItemMsg');
						}
						if($isAnyItemBlocked==true){
							$this->load->view('common/illegalMsg');
						}
					?> 
					</div>
			</div>
			<?php
		}?>   
		<div class="row">
			<div class="row">
				<div class=" cell width_200 Cat_wrapper">			
					<?php 
					
					if(strcmp($row['workType'],'offered')==0)
						$defaultImage=$this->config->item('defaultWorkOffered_s');
					else
						$defaultImage=$this->config->item('defaultWorkWanted_s');
						
					
					echo Modules::run("common/imageSlider",$sliderImages,$count,$defaultImage);
					?>				
				</div>
			</div>			  
				
			<div class="cell width_569 margin_left_16">
				
				<div class="row blog_wrapper new_theme_blog_box_gray <?php echo $redBorder3px;?>">
					<div class="blog_box bg-non-color">
						<div class="one_side_small_shadow">
					<table width="100%"  height="100% "border="0" cellspacing="0" cellpadding="0">
					  <tr>
						<td height="97"><img src="<?php echo base_url('images/published_shadow_top.png');?>"/></td>
					  </tr>
					  <tr>
						<td class="publish_shad_mid">&nbsp;</td>
					  </tr>
					  <tr>
						<td height="97"><img src="<?php echo base_url('images/published_shadow_bottom.png');?>"/></td>
					  </tr>
					 </table>
				</div><!--one_side_small_shadow-->
				<div class="cell blog_left_wrapper width_395  pr16">
				
				<div class="row"> <div class="published_box_wp ">
				<div class="published_heading"><?php echo $this->lang->line('FirstSaved');?></div> 
				<div class="published_date"><?php echo $createDate;?></div>
				
				<div class="clear"></div>
				 
				<div class="published_heading"><?php echo $expire_label;?></div> 
				<div class="published_date <?php echo $expiryDateColor?>"><?php echo  $expiryDate;?></div>
				
				<div class="clear"></div>
				 
				<div class="published_heading"><?php echo $this->lang->line('workFreeSpace');?></div> 
				<div class="published_date"> <?php echo $remainingSize.'&nbsp;'.$this->lang->line('outof').'&nbsp'.$containerSize;?> </div>
				<div class="clear"></div>
				<?php if($isBlocked == 'f'){
					if(isset($row['userContainerId']) && $row['userContainerId']>0){
							$projectContainerId = $row['userContainerId'];							
					} else {								
							$projectContainerId ='';
					}
					?>
					<div class="tds-button renew_btn btn_span_hover"> 
						<!--<a onmousedown="mousedown_tds_button(this)" onmouseup="mouseup_tds_button(this)" href="#"><span>Renew</span></a>-->
						<a onmousedown="mousedown_tds_button(this)" onmouseup="mouseup_tds_button(this)" href="<?php echo base_url(lang().'/membershipcart/renewCart/'.$projectContainerId);?>">
							<span class="mr3 pr10">
								<div class="renew_button fr ml20 pr0"></div>
								<div class="Fright ml0"><?php echo $this->lang->line('Renew'); ?></div>
							</span>
						</a>
					</div>
                <?php }?>
                </div><!--published_box_wp--></div>
                    
                <div class="seprator_10 row"></div>
					<div class="row">
						<div class="cell width_100_per"><b class="orange_color">Title</b> <span class="event_organiser_name"><?php echo getSubString($row['workTitle'], 60);?></span></div>
						</div>

					<div class="seprator_10 row"></div>
					<div class="row"> 
						<b class="orange_color"><?php echo $constant['workOneLineDesc'] ?></b>	
						<p><?php echo getSubString($row['workShortDesc'], 67);?></p>
						<div class="seprator_10"></div>
					<b class="orange_color"><?php echo $constant['project_tags'] ?></b>
					<p><?php echo getSubString($row['workTag'], 125);?></p>
					</div>	
				</div>
				
				<div class="cell blog_right_wrapper">
					<div class="blog_link2_wrapper">						
						<div class="tds-button-top modifyBtnWrapper">
							<?php
							$viewLink = base_url(lang().'/workshowcase/works/'.$userId.'/'.$row['workId']);
							$previewLink = base_url(lang().'/workshowcase/preview/'.$userId.'/'.$row['workId']);
							
							if($isArchive=='t'){
								if($isBlocked != 't' && $isExpired != 't'){ ?>
									<a class="formTip" href="javascript:void(0);" title="<?php echo $this->lang->line('restore');?>" onclick="moveFromArchive('','Work','workId','<?php echo $row['workId']; ?>','workArchived','/work/<?php echo $workType;?>/deletedItems/','','','','');"><span><div class="restore_btn_icon"></div></span></a>
									<?php
								}
								if($isBlocked != 't'){ ?>
									<a href="javascript:void(0);" class="formTip ml6" title="<?php echo $this->lang->line('delete');?>" onclick="deleteTabelRow('Work','workId','<?php echo $row['workId'];?>','','','','','',1,'','1','<?php echo $this->lang->line('sureDelMsg') ?>')"><span><div class="projectDeleteIcon"></div></span></a> 
									<?php
								}
							}else{
								
								echo anchor('work/'.$workType.'/'.$row['workId'].'/description', '<span><div class="projectEditIcon"></div></span>');
								$viewTooltip=$this->lang->line('view');
								$previewTooltip=$this->lang->line('preview');
								
								?>
								<a id="viewIcon<?php echo $uniqueId;?>" class="formTip ml6 viewIcon" <?php echo $viewDisplay;?> target="_blank" href="<?php echo $viewLink;?>" title="<?php echo $viewTooltip;?>"><span><div class="projectPreviewIcon"></div></span></a>
								<a id="previewIcon<?php echo $uniqueId;?>" class="formTip ml6 previewIcon" <?php echo $previewDisplay;?> target="_blank" href="<?php echo $previewLink;?>" title="<?php echo $previewTooltip;?>"><span><div class="projectPreviewIcon"></div></span></a>
				
								<a href="javascript:void(0);" class="formTip ml6" title="<?php echo $this->lang->line('delete');?>" onclick="moveInArchive('','Work','workId','<?php echo $row['workId']; ?>','workArchived','isPublished','/work/<?php echo $workType;?>','','','','','')"><span><div class="projectDeleteIcon"></div></span></a> 
							<?php 
							} 
							?>
						</div>
					</div>
					<div class="clear"></div>
					<div class="rating_box_wrapper padding_top10">
						<div class="orgLabel">
							<?php $industryName = getIndustry($row["workIndustryId"]); echo $industryName; ?>
						</div>
					</div>
					<div class="clear"></div>
					<!--rating_box_wrapper-->
					<!--<div class="rating_box_wrapper">
								<img class="fr" src="<?php //echo $ratingImg;?>" />
					</div>-->
					<!--rating_box_wrapper-->
					<div class="blog_link3_wrapper">
						<div class="blog_link3_box">
							<div class="icon_crave2_blog <?php echo $cravedALL;?>"> <?php echo $constant['craves'] ?> </div>
							<div class="blog_link3_point"><?php print($craveCount == '' ? '0' : $craveCount ); ?></div>
						</div>
						<div class="blog_link3_box">
							<div class="icon_view2_blog"> <?php echo $constant['Views'] ?> </div>
							<div class="blog_link3_point"><?php print($viewCount == '' ? '0' : $viewCount ); ?></div>
						</div>
						
						<div class="blog_link3_box">
							<div class="icon_lastview2_blog"> 
								<?php echo $constant['work_lastViewed']?><br/>
								<b><?php echo date('d M Y');?></b>
							</div>
  					   </div>
									
						<?php if($row['workExperiece']!='t' && (@$row['workRemuneration']!='')){ ?>		
						<div class="blog_link3_box">
							<div class="icon_post2_blog lH12"><?php echo $constant['workRemuneration'];?><br/>
								<b> <?php echo (@$row['workRemuneration']!='')?$row['workRemuneration']:'';?></b>
							</div>
						</div>
						<?php 
						}
												
						if(@$row['workExperiece']=='t'){ 
						?>
						<div class="blog_link3_box">
							<div class="icon_post2_blog lH12"><?php echo $constant['workExperience'];?></div>
						</div>
						<?php } ?>
						</div>
					</div>
					<div class="row blog_links_wrapper">
						<div class="fl cell">
							 <?php
								$relation = array('share','entityTitle'=> addslashes($row['workTitle']), 'shareType'=>$this->lang->line('work'), 'shareLink'=> $viewLink, 'id'=> 'work'.$row['workId'],'entityId'=>$entityId,'elementid'=>$row['workId'],'projectType'=>'work','isPublished'=>$row['isPublished']);
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
							
							$notificationArray = array('entityId'=>$entityId,'elementId'=>$row['workId'],'industryId'=>$row['workIndustryId'],'projectType'=>'work','alert_type'=>$row['workType']);							
							
							$publisButton=array('currentStatus'=>$this->lang->line('Publish'),'changeStatus'=>$this->lang->line('hide'),'isPublished'=>'t','isElement'=>1,'tabelName'=>'Work','pulishField'=>'isPublished','field'=>'workId','fieldValue'=>$row['workId'],'deleteCache'=>$this->router->fetch_method(),'notificationArray'=>$notificationArray);
							$unpublisButton=array('currentStatus'=>$this->lang->line('hide'),'changeStatus'=>$this->lang->line('Publish'),'isPublished'=>'f','isElement'=>1,'tabelName'=>'Work','pulishField'=>'isPublished','field'=>'workId','fieldValue'=>$row['workId'],'deleteCache'=>$this->router->fetch_method(),'notificationArray'=>$notificationArray);
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
						
					</div><!--blog_links_wrapper-->
				<div class="clear"></div>
			</div><!--blog_box-->			
		</div><!--width_569-->
				
				<div class="shadow_blog_box"> </div>
			</div>
		</div>
	<?php } ?>
	<div class="clear"></div>
	
	<?php
	/*How to publish popup*/
	if($items_total >  $perPageRecord){
		$publishClass = 'pa ml30';
	}else{
		$publishClass = 'ml30';
	}
	$this->load->view('common/howToPublish',array('industryType'=>'work', 'class'=>$publishClass));
	/*End How to publish popup */
	
	if($items_total >  $perPageRecord){?>	
		<div class="row">
			<div class=" cell width_200 Cat_wrapper">&nbsp;</div>			
			<div class="cell width_569 margin_left_16 pagingWrapper">
				<?php $this->load->view('pagination',array("pagination_links"=>$pagination_links,"items_total"=>$items_total,"items_per_page"=>$items_per_page,"perPageRecord"=>$perPageRecord,"url"=>base_url(lang().'/work/'.$workType),"divId"=>"elementListingAjaxDiv","formId"=>0,"unqueId"=>"full","isShowNumber"=>true,"isShowDD"=>true,"pagingWpaerClass"=>'pagination_wrapper new_page_design new_page_design',"pagingDDDClass"=>'left_site_dropdown m0 new_page_design new_page_design')); ?>
				<div class="clear"></div>
			</div>
		</div>
		<?php
	} 
} 
?>	

