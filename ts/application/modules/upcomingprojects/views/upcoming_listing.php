<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 
$url = base_url()."templates/system/slider"?>
<script type="text/javascript" src="<?php echo $url?>/js/jquery.lightbox-0.5.js"></script>
<link rel="stylesheet" type="text/css" href="<?php echo $url?>/css/jquery.lightbox-0.5.css" media="screen" />
<?php
$count = 0;
$entityId = getMasterTableRecord('UpcomingProject');	
if(isset($recodrSetUpcomingProejct) && is_array($recodrSetUpcomingProejct) && count($recodrSetUpcomingProejct) > 0){
	$isAnyItemBlocked=isAnyItemBlocked($recodrSetUpcomingProejct,false);
	$i=0;
	foreach($recodrSetUpcomingProejct as $record){
		$i++;
		$uniqueId='element'.$record['projId'];
		$isBlocked=$record['isBlocked'];
		$redBorder3px=($isBlocked=='t')?'redBorder3px':'';
		$isExpired=$record['isExpired'];
		$expiryDateColor=($isExpired=='t')?'red':'';
		$createDate=$record['projCreateDate'];
		$expiryDate=$record['expiryDate'];
		$currentDate = date("Y-m-d H:i:s");
		if(strlen($expiryDate) < 10){
			$expiryDate = dateFormatView(date('Y-m-d',(strtotime($record['projCreateDate'])+(60*60*24*30*6))));
			$upcoming_expiry_date = date('Y-m-d',(strtotime($record['projCreateDate'])+(60*60*24*30*6)));
		}else{
			$upcoming_expiry_date = $expiryDate;
			$expiryDate= dateFormatView($expiryDate);
		}
		
		if($upcoming_expiry_date != '' && $currentDate <= $upcoming_expiry_date) {
			$expiryDateColor = '';
			$expire_label = $this->lang->line('Expires');
		} else {
			$expiryDateColor = 'clr_red';
			$expire_label = $this->lang->line('toolExpired');
		}
		
		$createDate=dateFormatView($createDate);
		
		$containerSize=(isset($record['containerSize']) && is_numeric($record['containerSize']))?$record['containerSize']:$this->config->item('defaultContainerSize');
		$containerSize=bytestoMB($containerSize,'mb');
		
		$dir = '/upcomingProjects';
		$dirname='media/'.LoginUserDetails('username').$dir.'/'.$record['projId'].'/';
		$dirSize=bytestoMB(getFolderSize($dirname),'mb');
		$remainingSize=($containerSize-$dirSize);
		if($remainingSize < 0){
			$remainingSize = 0;
		}
		$remainingSize = number_format($remainingSize,2,'.','');
		$remainingSize=$remainingSize.'&nbsp;'.$this->lang->line('mb');
		$containerSize=$containerSize.'&nbsp;'.$this->lang->line('mb');
					
		$count++;
		$sliderImages = getProductImages('TDS_UpcomingProjectMedia','projId',$record['projId'], 1, 'isMain');// Defination is on Common controller
		$defaultImage = $this->config->item('defaultUpcomingImg_s');
		$whereClause = array('projId' =>$record['projId']);
		$promoImages = array('entityId'=>$entityId,'mediaTableName'=>'TDS_UpcomingProjectMedia','defaultImage'=>$defaultImage,'showImageOfNum'=>1,'whereClause'=>$whereClause);
		//$popup_images=Modules::run("promo_material/popupimage",$promoImages);
		//echo '<pre />'; print_r($sliderImages);
		
		//Get Counts in upcoming project
		$LogSummarywhere = array(
					'entityId'=>$entityId,
					'elementId'=>$record['projId']
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
		$loggedUserId = $record['tdsUid'];
		if($loggedUserId > 0){
			$where = array(
						'tdsUid'=>$loggedUserId,
						'entityId'=>$entityId,
						'elementId'=>$record['projId']
					);
			$countResult = countResult('LogCrave',$where);
			$cravedALL = ($countResult>0)?'admin_cravedALL':'';
		}else
		{
			$cravedALL = '';
		}
		
		if($record['isPublished']=='t'){
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
		}
		?>  
		
		<div class="row">
			<div class=" cell width_200 Cat_wrapper" >
				<?php 				
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
							
							<div class="row"> 
							<div class="published_box_wp ">
                    		<div class="published_heading"><?php echo $this->lang->line('FirstSaved');?></div> 
                            <div class="published_date"><?php echo $createDate;?></div>
                            <div class="clear"></div>
                             
                            <div class="published_heading">
							<?php echo $expire_label;?></div> 
                           <div class="published_date <?php echo $expiryDateColor?>"><?php echo  $expiryDate;?></div>
                           <div class="clear"></div>
                             
                            <div class="published_heading"><?php echo $this->lang->line('freeSpace')?></div> 
                            <div class="published_date"><?php echo $remainingSize.'&nbsp;'.$this->lang->line('outof').'&nbsp'.$containerSize;?></div>
                            <div class="clear"></div>
                            <?php if($isBlocked == 'f'){
							if(isset($record['userContainerId']) && $record['userContainerId']>0){
									$projectContainerId = $record['userContainerId'];							
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
                    </div><!--published_box_wp-->
                    </div>
                    
                    <div class="seprator_5"></div>
                            
                            <div class="row"> 
							<b class="orange_color"><?php echo $this->lang->line('title')?></b>
							<span class="event_organiser_name">
								<?php echo getSubString($record['projTitle'],40); ?>
							</span>
							<div class="seprator_10"></div>
							
							<b class="orange_color"><?php echo $this->lang->line('releasedDate')?></b>
							<span class="event_organiser_name">
								<?php $workPostedDate = date("F Y", strtotime($record['projReleaseDate']));echo $workPostedDate; ?>
							</span>
							<div class="seprator_10"></div>
								<b class="orange_color"><?php echo $this->lang->line('project_logLineDescription')?></b>
								<p><?php echo getSubString($record['proShortDesc'],67);?></p>								
								<div class="seprator_10"></div>
								<b class="orange_color"><?php echo $this->lang->line('tagWords')?></b>
								<p><?php echo getSubString($record['projTag'],125);?></p>
							</div>
							<?php 
							/*
							Cleint changes 7 aug 2012
							<div class="row">
								<div class="cell padding_top10"> 
									<b class="orange_color"><?php echo $label['Location']?>:</b>
									<?php if($record['projStreet'] != '') { echo $record['projStreet'].', ';}?>	<?php if($record['projCity'] != '') { echo $record['projCity'];}?> , 
									<?php if($record['projCountry'] != '') { echo getCountry($record['projCountry']); }?>
									<?php if($record['projZip'] != '') { echo $record['projZip'] ;}?>
								</div>
							</div>
							*/ 
							?>
						</div>
				<div class="cell blog_right_wrapper">
					<div class="blog_link2_wrapper">
						<div class="post_text"></div>
						<div class="tds-button-top modifyBtnWrapper">
							
							<?php
							if($isArchive=='t'){
								if($isBlocked != 't' && $isExpired != 't'){ ?>
									 <a class="formTip" href="javascript:void(0);" title="<?php echo $this->lang->line('restore');?>" onclick="moveFromArchive('','UpcomingProject','projId','<?php echo $record['projId']; ?>','projArchived','/upcomingprojects/deletedItems','','','','');"><span><div class="restore_btn_icon"></div></span></a>
									<?php
								}
								if($isBlocked != 't'){ ?>
									<a href="javascript:void(0);" class="formTip ml6" title="<?php echo $this->lang->line('delete');?>" onclick="deleteTabelRow('UpcomingProject','projId','<?php echo $record['projId'];?>','','','','','',1,'','1','<?php echo $this->lang->line('sureDelMsg') ?>')"><span><div class="projectDeleteIcon"></div></span></a> 
									<?php
								}
							}else{ 
								echo anchor('upcomingprojects/newupcomingprojects/'.$record['projId'], '<span><div class="projectEditIcon"></div></span>',array('class'=>'formTip','title'=>$label['edit']));
								
								$viewLink='upcomingfrontend/upcoming/'.$userId.'/'.$record['projId'];
								$viewTooltip=$this->lang->line('view');
								
								$previewTooltip=$this->lang->line('preview');
								$previewLink = 'upcomingfrontend/preview/'.$userId.'/'.$record['projId'];
								?>
								<a id="viewIcon<?php echo $uniqueId;?>" class="formTip ml6 viewIcon" <?php echo $viewDisplay;?> target="_blank" href="<?php echo base_url($viewLink);?>" title="<?php echo $viewTooltip;?>"><span><div class="projectPreviewIcon"></div></span></a>
								<a id="previewIcon<?php echo $uniqueId;?>" class="formTip ml6 previewIcon" <?php echo $previewDisplay;?> target="_blank" href="<?php echo base_url($previewLink);?>" title="<?php echo $previewTooltip;?>"><span><div class="projectPreviewIcon"></div></span></a>
				
								<a href="javascript:void(0);" class="formTip ml6" title="<?php echo $this->lang->line('delete');?>" onclick="moveInArchive('','UpcomingProject','projId','<?php echo $record['projId']; ?>','projArchived','isPublished','/upcomingprojects/index','','','','','')"><span><div class="projectDeleteIcon"></div></span></a> 
								<?php
							}
						?>
						</div>
					</div>
					<div class="clear"></div>
					<div class="rating_box_wrapper padding_top10">
							<div class="orgLabel">
							<?php 							
								if(isset($record["projUpType"]) && $record["projUpType"]!='')
								{
									if($record["projUpType"]==1) echo $this->lang->line('EducationalMaterial');
									if($record["projUpType"]==2) echo $this->lang->line('perOrEvent');
									if($record["projUpType"]==3) echo $this->lang->line('mediaProject');
								}							
							?>
							</div>
						</div>
					<div class="clear"></div>					
					<!--rating_box_wrapper-->
					<div class="rating_box_wrapper">
						<img class="fr" src="<?php echo $ratingImg;?>" />
					</div>
					<!--rating_box_wrapper-->
					 <div class="clear"></div>
					  
					<div class="blog_link3_wrapper">						
						<div class="blog_link3_box">
							<div class="icon_crave2_blog <?php echo $cravedALL;?>"> <?php echo $label['craves'] ?> </div>
							<div class="blog_link3_point"><?php print($craveCount == '' ? '0' : $craveCount ); ?><?php //print($row['workCraveCount'] == '' ? '0' : $row['workCraveCount'] ); ?></div>
						</div>
						<div class="blog_link3_box">
							<div class="icon_view2_blog"> <?php echo $label['Views'] ?> </div>
							<div class="blog_link3_point"><?php print($viewCount == '' ? '0' : $viewCount ); ?><?php //print($row['workViewCount'] == '' ? '0' : $row['workViewCount'] );?></div>
						</div>
						
						<div class="blog_link3_box">
							<div class="icon_lastview2_blog"> 
								<?php echo $label['Lastview'] ;?><br/>
								<b><?php echo date('d M Y');?></b>
							</div>
						</div>								
						</div>					
				</div>
				
				<div class="row blog_links_wrapper">								
				
				<div class="fl  pt0 cell">
					 <?php				
						$currentUrl = base_url(lang().'/upcomingfrontend/upcoming/'.$userId.'/'.$record['projId']);					
						 $relation = array('email','share','getShortLink','show','entityTitle'=> addslashes($record['projTitle']), 'shareType'=>$this->lang->line('upcomingProject'), 'shareLink'=> $currentUrl, 'id'=> 'upcomingProject'.$record['projId'],'entityId'=>$entityId,'elementid'=>$record['projId'],'projectType'=>'upcoming','isPublished'=>$record['isPublished']);
						
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
						
						$notificationArray = array('entityId'=>$entityId,'elementId'=>$record['projId'],'industryId'=>$record['projIndustry'],'projectType'=>$record['IndustryName']);
						
						$publisButton=array('currentStatus'=>$this->lang->line('Publish'),'changeStatus'=>$this->lang->line('hide'),'isPublished'=>'t','isElement'=>1,'tabelName'=>'UpcomingProject','pulishField'=>'isPublished','projModifiedDate' => date("Y-m-d H:i:s"),'field'=>'projId','fieldValue'=>$record['projId'],'deleteCache'=>$this->router->fetch_method(),'notificationArray'=>$notificationArray);
						$unpublisButton=array('currentStatus'=>$this->lang->line('hide'),'changeStatus'=>$this->lang->line('Publish'),'isPublished'=>'f','isElement'=>1,'tabelName'=>'UpcomingProject','pulishField'=>'isPublished','projModifiedDate' => date("Y-m-d H:i:s"),'field'=>'projId','fieldValue'=>$record['projId'],'deleteCache'=>$this->router->fetch_method(),'notificationArray'=>$notificationArray);
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
		</div>
		<div class="shadow_blog_box"> </div>
		</div><!--width_569-->
		
		<?php 
	}?>
	
	<div class="clear"></div>
	<?php
	
	/*How to publish popup*/
	if(isset($items_total) && isset($perPageRecord) && $items_total >  $perPageRecord){
		$publishClass = 'pa ml30';
	}else{
		$publishClass = 'ml30';
	}
	$this->load->view('common/howToPublish',array('industryType'=>'upcoming', 'class'=>$publishClass));
	/*End How to publish popup */
	
	if(isset($items_total) && isset($perPageRecord) && $items_total >  $perPageRecord){
		?>
		<div class="row">
			<div class=" cell width_200 Cat_wrapper">&nbsp;</div>
			<div class="cell width_569 margin_left_16 pagingWrapper">
				<?php $this->load->view('pagination',array("pagination_links"=>$pagination_links,"items_total"=>$items_total,"items_per_page"=>$items_per_page,"perPageRecord"=>$perPageRecord,"url"=>base_url(lang().'/upcomingprojects/index'),"divId"=>"elementListingAjaxDiv","formId"=>0,"unqueId"=>"full","isShowNumber"=>true,"isShowDD"=>true,"pagingWpaerClass"=>'pagination_wrapper new_page_design new_page_design',"pagingDDDClass"=>'left_site_dropdown m0 new_page_design new_page_design')); ?>
				<div class="clear"></div>
			</div>
		</div>
		<?php
	}  	
		
}
