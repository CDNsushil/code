<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 
	$seller_currency=LoginUserDetails('seller_currency');
	if($seller_currency==''){
		$isSellerSettings=false;
	}else{
		$isSellerSettings=true;
	}
	$seller_currency=($seller_currency>0)?$seller_currency:0;
	$currencySign=$this->config->item('currency'.$seller_currency);
	$wpSection=array('news','reviews','writingNpublishing');
	$mediaHeader=in_array($industryType,$wpSection)?'wpHeader':'mediaHeader';
	$imagetype=$fileConfig['defaultImage_s'];
	$deleteCache=$industryType.'_'.$projectId.'_'.$userId;
	$projectImage = getImage($imagetype);
	$projName=isset($project['projName'])?$project['projName']:'';
	$this->load->view($mediaHeader,$projName);
	
if(in_array($industryType,$wpSection) || isset($projects[0]['projName'])){
	
	?>
	<div class="row">
		<div class="main_project_heading">
			<div class="Main_heading_new fl"><?php if(isset($projects[0]['projName'])) echo html_entity_decode($projects[0]['projName']);?></div>
			<?php 
			if(in_array($industryType,$wpSection)){
				$sectionId=($indusrtyId > 0)?$indusrtyId:$this->config->item($industryType.'SectionId');
				?>		
					<div class="btn_outer_wrapper fr width_auto pl5 mr14">
						<div class="fr">
							<div class="tds-button-big Fright">
								<?php
								if($industryType == 'writingNpublishing'){ ?>
									<a href="javascript:getUserContainers('<?php echo $sectionId;?>','media/<?php echo $industryType;?>/newProject/projectDescription')"  onmousedown="mousedown_big_button(this)" onmouseout="mouseout_big_button(this)" onmouseup="mouseup_big_button(this)"><span class="two_line"><?php echo $constant['project_newProject']?></span></a> 
									<?php 
								}
								if($isArchive=='t'){?>
									<a href="<?php echo base_url(lang().'/media/'.$industryType.'/');?>" onmousedown="mousedown_big_button(this)" onmouseout="mouseout_big_button(this)" onmouseup="mouseup_big_button(this)"><span class="two_line"><?php echo $constant['index']?></span></a>
									<?php
								}else{ 
									?>
									<a href="<?php echo base_url(lang().'/media/'.$industryType.'/deletedItems');?>" onmousedown="mousedown_big_button(this)" onmouseout="mouseout_big_button(this)" onmouseup="mouseup_big_button(this)"><span class="two_line"><?php echo $constant['project_archive']?></span></a>
									<?php
								}
								?>
							</div>
							
						</div>
						<div class="clear"></div>
					 </div>
				<?php
			 }?>
		 </div>
	</div>
	<div class="clear"></div>
	<?php
}

?>
<div class="row mt6 position_relative">
<?php
$this->load->view('common/strip');
	
	
	if(isset($projects[0])){
		
		$project=$projects[0];
		$uniqueId='project'.$project['projId'];
		$isAnyItemBlocked=isAnyItemBlocked($project['elements'],false);
		$isBlocked=$project['isBlocked'];
		$redBorder3px=($isBlocked=='t')?'redBorder3px':'';
		$isExpired=$project['isExpired'];
		$expiryDateColor=($isExpired=='t')?'red':'';
		$createDate=$project['projCreateDate'];
		$expiryDate=$project['expiryDate'];
		$currentDate = date("Y-m-d H:i:s");
		if(strlen($expiryDate) < 10){
			$expiryDate= dateFormatView(date('Y-m-d',(strtotime($project['projCreateDate'])+(60*60*24*30*6))))	;
			$media_expiry_date = date('Y-m-d',(strtotime($project['projCreateDate'])+(60*60*24*30*6)));
		}else{
			$media_expiry_date = $expiryDate;
			$expiryDate= dateFormatView($expiryDate);
		}
		
		if($media_expiry_date != '' && $currentDate <= $media_expiry_date) {
			$expiryDateColor = '';
			$expire_label = $this->lang->line('toolExpires');
		} else {
			$expiryDateColor = 'clr_red';
			$expire_label = $this->lang->line('toolExpired');
		}
		
		$createDate=dateFormatView($createDate);
		
		$containerSize=(isset($project['containerSize']) && is_numeric($project['containerSize']))?$project['containerSize']:$this->config->item('defaultContainerSize');
		$containerSize=bytestoMB($containerSize,'mb');
		
		$dirname=$dirUploadMedia.$industryType.'/'.$projectId.'/';
		$dirSize=bytestoMB(getFolderSize($dirname),'mb');
		$remainingSize=($containerSize-$dirSize);
		if($remainingSize < 0){
			$remainingSize = 0;
		}
		$remainingSize = number_format($remainingSize,2,'.','');
		$reminSize = $remainingSize;
		$remainingSize=$remainingSize.' '.$this->lang->line('mb');
		$UsedSpace=$dirSize.' '.$this->lang->line('mb');
		
		$containerSize=$containerSize.' '.$this->lang->line('mb');
		$projSellstatus=$project['projSellstatus']=='t'?true:false;
		$projSellstatusHeading=$projSellstatus?$constant['project_sales']:$constant['project_free'];
		
		if(isset($project['isExternalImageURL']) && $project['isExternalImageURL']=='t'){
			$projectImage=trim($project['projBaseImgPath']);
		}else{
			
			//----------make element default project image code start---------//
			if(!empty($project['projBaseImgPath'])){
				$projThumbImage = addThumbFolder($project['projBaseImgPath'],'_s',$imagetype);				
				$projectImage = getImage($projThumbImage,$imagetype,1);
			}else{
				$getPojrectImage = getProjectElementImage($project['projId'],$elementEntityId);	
				if(is_array($getPojrectImage)){
					if($getPojrectImage['isExternal']=="t"){
						$getImageUrl =  checkExternalImage($getPojrectImage['filePath'],'_s');
						if(getimagesize($getImageUrl)){
							$projectImage = $getImageUrl;
						}
					}
				}else{
					if($getPojrectImage){
						$projThumbImage = $getPojrectImage;
					}else{
						$projThumbImage = addThumbFolder($project['projBaseImgPath'],'_s',$imagetype);				
					}
					$projectImage = getImage($projThumbImage,$imagetype,1);
				}
			}
			
			//----------make element default project image code start---------//
		}
		
		$sellExpiryDate=$isPurchasedItem=checkDownloadPPVaccess($entityId,$project['projId'],$project['projId']);
		
		if($project['isPublished']=='t'){
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
            <?php $this->load->view('common/profileImage',array('image'=>$projectImage));
			if($projSellstatus){
				$totalSales=getSum('SalesOrderItem',$field='itemValue',array('entityId'=>$entityId,'projId'=>$project['projId']));
				$price=(isset($project['projPrice']) && $project['projPrice'] >0)?$project['projPrice']:0;
				$downloadPrice=(isset($project['projDownloadPrice']) && $project['projDownloadPrice'] >0)?$project['projDownloadPrice']:0;
				$perViewPrice=(isset($project['projPpvPrice']) && $project['projPpvPrice'] >0)?$project['projPpvPrice']:0;
				
				$priceDetails=getDisplayPrice($price,$seller_currency);
				$downloadPriceDetails=getDisplayPrice($downloadPrice,$seller_currency);
				$PpvPriceDetails=getDisplayPrice($perViewPrice,$seller_currency);
				
				$salesLink=base_url(lang().'/cart/sales_information?show_by=project&save=Save&projId='.$project['projId']);
				?>
				<a target="_blank" href="<?php echo $salesLink;?>"><div class="new_project_and_price_wp">
					<span class="orange_color product_left_download_heading gray_clr_hover"><?php echo $this->lang->line('projSalesInformation');?></span>
					<div class="clear"></div>
					<div class="product_left_download_heading bg-non mt5 pb4">
						<span class="fl orange_color gray_clr_hover"><?php echo $constant['project_totalSales'];?></span>
						<span class="fr total_currency">
							<?php
								echo $currencySign.' '.number_format($totalSales,2);
							?>
						</span>
					  <div class="clear"></div>
					</div>
				</div></a>		   
				<?php
			}
			else{?>
				<div class="new_project_and_price_wp">
					<span class="orange_color product_left_download_heading"><?php echo $projSellstatusHeading;?></span>
					<div class="clear"></div>
					<div class="download_description_wp mb16">
						<div class="row">
							<div class="cell"><?php echo $constant['project_downloaded'];?></div>
							<div class="fr "><?php echo $project['dwnCount'];?></div>
						</div><!--row-end-->
						  <?php
						if($projSellstatus){?>
							<?php
							if($industryType == 'filmNvideo'){ ?>
									<div class="row">
										<div class="cell"><?php echo $constant['project_ppv'];?></div>
										<div class="fr "><?php echo $project['ppvCount'];?></div>
									</div><!--row-end-->
								<?php
							}?>
					   
							<div class="row">
								<div class="cell"><?php echo $constant['project_totalshipped'];?></div>
								<div class="fr "><?php echo $project['shippedCount'];?></div>
							</div><!--row-end-->
							<?php
						}else{ ?>
							<div class="row">
								<div class="cell"><?php echo $constant['project_viewed'];?></div>
								<div class="fr "><?php echo $project['viewCount'];?></div>
							</div><!--row-end-->
							
							<?php
						}?>
						
						<div class="clear"></div>
					</div><!--download_description_wp-->
				</div>
					<?php
			}?>
			
         
         <?php	
			if(!($industryType == 'news' || $industryType == 'reviews')){	?>
				<div class=" cell frm_heading mt85">
					<h2><?php echo $constant['projects'];?></h2>
				</div>
				<div class="clear"></div>
			   <div class="Cat_wrapper">
					<ul>
						<?php 
							$where=array('projectType'=>$industryType,'tdsUid'=>$userId,'isArchive'=>$isArchive);
							$userProjects=getDataFromTabel($table='Project', $field='projId,projName', $where, '', 'projLastModifyDate', 'DESC' );
							foreach($userProjects as $pt){
								
								if($projectId==$pt->projId){
									$ProjectColor='orange';
								}else{
									$ProjectColor='';
								}
								if($isArchive=='t'){
									$link=base_url(lang().'/media/'.$industryType.'/deletedItems/'.$pt->projId);
								}else{
									$link=base_url(lang().'/media/'.$industryType.'/'.$pt->projId);
								}
								?>
								<li class="width200px oh"> 
									<a href="<?php echo $link;?>" class="<?php echo $ProjectColor;?>" ><?php echo html_entity_decode(getSubString($pt->projName,18));?></a>
								</li>
								<?
							}
						?>
					</ul>
				 </div><!--row-end-->
				 <?php
			}?>
			<div class="seprator_20"></div>
			<!--How to publish popup -->
			<?php 
				$this->load->view('common/howToPublish',array('industryType'=>$industryType));
			?>
			<!--End How to publish popup -->
        </div>
         
          <div class="cell width_569 padding_left16">
			<?php 
				if($isArchive=='t'){
					$this->load->view('common/deletedItemMsg');
				}
				
				if($isBlocked=='t' || $isAnyItemBlocked==true){
					$this->load->view('common/illegalMsg');
				}
			?>
			<div class="row blog_wrapper new_theme_blog_box_gray <?php echo $redBorder3px;?>">
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
								<div class="published_heading"><?php echo $constant['firstSave'];?></div> 
								<div class="published_date"><?php echo $createDate;?></div>
								
								 <div class="clear"></div>

								<?php if(!($industryType == 'news' || $industryType == 'reviews')){ ?>
									<div class="published_heading"><?php //echo $this->lang->line('Expires');?>
									<?php echo $expire_label;?></div> 
									<div class="published_date <?php echo $expiryDateColor?>"><?php echo  $expiryDate;?></div>
									<div class="clear"></div>
									
									<div class="published_heading"><?php echo $this->lang->line('freeSpace');?></div> 
									<div class="published_date"><?php echo $remainingSize.' '.$this->lang->line('outof').'&nbsp'.$containerSize;?></div>
									<div class="clear"></div>
									
									 <?php
								 }else{?>
									<div class="published_heading"><?php echo $this->lang->line('usedSpace');?></div> 
									<div class="published_date"><?php echo $UsedSpace;?></div>
									<div class="clear"></div>
									<?php
								} 

								if($isBlocked == 'f'){?>
									<?php													
									if($project['userContainerId']>0){
											$projectContainerId = $project['userContainerId'];							
									} else {								
											$projectContainerId ='';
									}
									
									if(!($industryType == 'news' || $industryType == 'reviews')){						
									?>		
										<div class="tds-button renew_btn btn_span_hover">
											<a onmousedown="mousedown_tds_button(this)" onmouseup="mouseup_tds_button(this)" href="<?php echo base_url(lang().'/membershipcart/renewCart/'.$projectContainerId);?>">
												<span class="mr3 pr10">
													<div class="renew_button fr ml20 pr0"></div>
													<div class="Fright ml0"><?php echo $this->lang->line('Renew'); ?></div>
												</span>
											</a>
										</div>
											
											<!--<a onmousedown="mousedown_tds_button(this)" onmouseup="mouseup_tds_button(this)" href="<?php //echo base_url(lang().'/membershipcart/renewCart/'.$projectContainerId);?>"><span>Renew</span></a></div>-->								
										<?php
									} 
								}?>
							</div><!--published_box_wp-->
						</div>
						<div class="seprator_10 row"></div>
						 <div class="row"> <b class="orange_color"><?php echo $this->lang->line('loglineDescription'); ?> </b>
							<p><?php echo nl2br(getSubString($project['projShortDesc'], 130));?></p>
							<div class="seprator_13"></div>
							<b class="orange_color"><?php echo $this->lang->line('tagWords'); ?> </b>
							<p><?php echo nl2br(getSubString($project['projTag'], 130));?></p>
						 </div>
					</div>
					<div class="cell blog_right_wrapper">
					  <div class="blog_link2_wrapper">
						<div class="tds-button-top"> 
							<?php
							if($isArchive=='t'){
								if($isBlocked != 't' && $isExpired != 't'){ ?>
									<a class="formTip" href="javascript:void(0);" title="<?php echo $this->lang->line('restore');?>" onclick="moveFromArchive('','Project','projId','<?php echo $project['projectid']; ?>','isArchive','/media/<?php echo $industryType;?>/deletedItems/','<?php echo $deleteCache ?>','<?php echo $elemetTable ?>','projId','','isPublished');"><span><div class="restore_btn_icon"></div></span></a>
									<?php
								}
								if($isBlocked == 'f'){
									if($isPurchasedItem){
										$elementCannotDelete = $this->lang->line('projectCannotDelete').$sellExpiryDate;
										$deleteFunction="customAlert('".$elementCannotDelete."');";
									}else{
										$sureDelMsg=$this->lang->line('sureDelMsg');
										$deleteFunction="moveMediaProjectInTrash('".$project['projectid']."','".$elemetTable."','".$sectionId."','".$industryType."','".$sureDelMsg."');";
									}
									?>
									<a href="javascript:void(0);" class="formTip ml6" onclick="<?php echo $deleteFunction;?>" title="<?php echo $this->lang->line('delete');?>"><span><div class="projectDeleteIcon"></div></span></a> 
									<?php
								}
							}else{ ?>
								<a href="<?php echo base_url(lang().'/media/'.$industryType.'/editProject/uploadMedia/'.$project['projectid'].'/0');?>" class="formTip" title="<?php echo $this->lang->line('add');?>"   >
									<span><div class="projectAddIcon"></div></span>
								</a>
								<a href="<?php echo base_url(lang().'/media/'.$industryType.'/editProject/projectDescription/'.$project['projectid']);?>" class="ml6 formTip" title="<?php echo $this->lang->line('edit')?>"><span>
								<div class="projectEditIcon"></div>
								</span></a> 
								
								<?php
								$viewLink='mediafrontend/'.$this->config->item($industryType.'Sl').'/'.$userId.'/'.$project['projectid'];
								$viewTooltip=$this->lang->line('view');
								
								$previewTooltip=$this->lang->line('preview');
								$previewLink='mediafrontend/preview/'.$userId.'/'.$project['projectid'].'/'.$this->config->item($industryType.'Sl');
								?>
								
								
								<a id="viewIcon<?php echo $uniqueId;?>" class="formTip ml6 viewIcon" <?php echo $viewDisplay;?> target="_blank" href="<?php echo base_url($viewLink);?>" title="<?php echo $viewTooltip;?>"><span><div class="projectPreviewIcon"></div></span></a>
								<a id="previewIcon<?php echo $uniqueId;?>" class="formTip ml6 previewIcon" <?php echo $previewDisplay;?> target="_blank" href="<?php echo base_url($previewLink);?>" title="<?php echo $previewTooltip;?>"><span><div class="projectPreviewIcon"></div></span></a>
								<?php
								if(!($industryType == 'news' || $industryType == 'reviews')){ ?>
									<a href="javascript:void(0);" class="formTip ml6" title="<?php echo $this->lang->line('delete');?>" onclick="moveInArchive('','Project','projId','<?php echo $project['projectid']; ?>','isArchive','isPublished','/media/<?php echo $industryType;?>','<?php echo $deleteCache ?>','<?php echo $elemetTable ?>','projId','','isPublished')"><span><div class="projectDeleteIcon"></div></span></a> 
									<?php
								}
							}?>
						</div>
						<!--icon_edit_blog-->
					  </div>
					  <div class="clear"></div>
					  <div class="rating_box_wrapper">
						<?php
							$ratingAvg=$project['ratingAvg'];
							$ratingAvg=roundRatingValue($ratingAvg);
							$ratingImg=base_url('images/rating/rating_0'.$ratingAvg.'.png');
						?>
						<img class="fr" src="<?php echo $ratingImg;?>" />
					  </div>
					  <!--rating_box_wrapper-->
					 <div class="clear"></div>
					 <div class="blog_link3_wrapper">
							<div class="blog_link3_box">
								<div class="icon_crave2_blog"><?php echo $constant['project_craved']?></div>
								<div class="blog_link3_point"><?php echo $project['craveCount'];?></div>
							</div>
							<div class="blog_link3_box">
								<div class="icon_post2_blog"><?php echo $constant['project_reviews']?></div>
								<div class="blog_link3_point"><?php echo $project['reviewCount'];?></div>
							</div>
							<div class="blog_link3_box">
								<div class="icon_view2_blog"><?php echo $constant['project_views']?></div>
								<div class="blog_link3_point"><?php echo $project['viewCount'];?></div>
							</div>
							<div class="blog_link3_box">
								<div class="icon_lastview2_blog"> 
									<?php echo $constant['project_lastViewed']?><br/>
									<b><?php echo date('d M Y');?></b>
								</div>
							</div>
						</div>
					</div>
					<div class="row blog_links_wrapper">
					  
					   <!-- Relation to share like short-link, email, share, show START -->
					  <?php
						$currentUrl = base_url(lang().'/mediafrontend/'.$showCaseMethod.'/'.$userId.'/'.$project['projectid']);
						if($industryType=='reviews' || $industryType=='news'){
							$relation = array('getShortLink', 'email','share','entityTitle'=> $project['projName'], 'shareType'=>$constant['project_heading'], 'shareLink'=> $currentUrl,'id'=> 'Project'.$project['projectid'],'entityId'=>$entityId,'elementid'=>$project['projectid'],'projectType'=>$project['projectType'],'isPublished'=>$project['isPublished']);

						}else{
							$relation = array('getShortLink', 'email','share','show','entityTitle'=> $project['projName'], 'shareType'=>$constant['project_heading'], 'shareLink'=> $currentUrl,'id'=> 'Project'.$project['projectid'],'entityId'=>$entityId,'elementid'=>$project['projectid'],'projectType'=>$project['projectType'],'isPublished'=>$project['isPublished']);
						} 
						
						
						?>
						
						<div id="relationToSharePublish<?php echo $uniqueId;?>" class="cell rtsp" <?php echo $rtspDisplay; ?>>
							<?php $relation['isPublished']='t';
							 $this->load->view('common/relation_to_share',array('relation'=>$relation));
							 ?>
						</div>
						
						<div id="relationToShareUnPublish<?php echo $uniqueId;?>" class="cell rtsup" <?php echo $rtsupDisplay; ?>>
							<?php $relation['isPublished']='f';
							 $this->load->view('common/relation_to_share',array('relation'=>$relation));
							 ?>
						</div>
					 <!-- Relation to share like short-link, email, share, show END -->
					  <?php
					 		if($isArchive !='t' && $isBlocked !='t'){ 
								$sessionMsg='';
								$isFARF=0;
								if(strlen($project['projShortDesc']) >= 5 && count($project['elements'])>0){
									$elementCount=count($project['elements']);
									$isFARF=1;
								}else{
									if(strlen($project['projShortDesc']) < 5){
										$sessionMsg=$this->lang->line('requiredDescriptionMsg');
									}
									$isFARF=0;
								}
								
								if($isFARF && $projSellstatus && !$isSellerSettings){
									$isFARF=0;
									$sessionMsg=$this->lang->line('sellerSettingsMsg');
								}
							
								$notificationArray = array('entityId'=>$entityId,'projectId'=>$project['projId'],'elementId'=>$project['projId'],'industryId'=>$project['IndustryId'],'projectType'=>$project['projectType']);
								
								$publisButton=array('isFARF'=>1,'currentStatus'=>$this->lang->line('Publish'),'changeStatus'=>$this->lang->line('hide'),'isPublished'=>'t','tabelName'=>'Project','pulishField'=>'isPublished','field'=>'projId','fieldValue'=>$project['projectid'],'deleteCache'=>$deleteCache, 'elementTable'=>$elemetTable, 'elementField'=>'projId','sessionMsg'=>$sessionMsg,'notificationArray'=>$notificationArray);
								$unpublisButton=array('isFARF'=>$isFARF,'currentStatus'=>$this->lang->line('hide'),'changeStatus'=>$this->lang->line('Publish'),'isPublished'=>'f','tabelName'=>'Project','pulishField'=>'isPublished','field'=>'projId','fieldValue'=>$project['projectid'],'deleteCache'=>$deleteCache, 'elementTable'=>$elemetTable, 'elementField'=>'projId','sessionMsg'=>$sessionMsg,'notificationArray'=>$notificationArray);
								?>
								
								<div id="PublishButton<?php echo $uniqueId;?>" class="cell fr PublishButton" <?php echo $pDisplay; ?>>
									<?php $this->load->view('common/publishUnpublish',$publisButton);?>
								</div>
								
								<div id="UnPublishButton<?php echo $uniqueId;?>" class=" cell fr UnPublishButton" <?php echo $upDisplay; ?>>
									<?php $this->load->view('common/publishUnpublish',$unpublisButton);?>
								</div>
								
								<?php
							}
						?> 
						<input type="hidden" name="isProjectPublished<?php echo $project['projectid'];?>" id="isProjectPublished<?php echo $project['projectid'];?>" value="<?php echo $project['isPublished'];?>"  />
					  
					   <div class="clear"></div>
				   </div>
					<div class="clear"></div>
              </div>
            </div>
			<div class="shadow_blog_box"></div>
			    <div id="mediaElementList">
					<?php 
					$data['project']=$project; 
					$this->load->view('elements', $data);
					?>
				<!--shadow_blog_box-->
				</div>
			</div>
          <div class="clear"></div>
		<?php
	}
	else{
		//$constant['project_noRecordFound'];
		?>
          <div class="cell width_200">
            <?php $this->load->view('common/profileImage',array('image'=>$projectImage));?>
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
						<?php
					}
					?>
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
