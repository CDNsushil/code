<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');?>
<?php $url = base_url()."templates/system/slider"?>
<script type="text/javascript" src="<?php echo $url?>/js/jquery.lightbox-0.5.js"></script>
<link rel="stylesheet" type="text/css" href="<?php echo $url?>/css/jquery.lightbox-0.5.css" media="screen" />
<?php

	if($products)
	{
		$seller_currency=LoginUserDetails('seller_currency');
		if($seller_currency==''){
			$isSellerSettings=false;
		}else{
			$isSellerSettings=true;
		}
		$seller_currency=($seller_currency>0)?$seller_currency:0;
		$currencySign=$this->config->item('currency'.$seller_currency);
		$count=0;
		$entityId = getMasterTableRecord('Product');	 
		$i=0;
		$isAnyItemBlocked=isAnyItemBlocked($products,false);
		
		foreach($products as $key=>$product)
		{
			$i++;
			$uniqueId='element'.$product['productId'];
			if($product['isPublished']=='t'){
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
			$isBlocked=$product['isBlocked'];
			$redBorder3px=($isBlocked=='t')?'redBorder3px':'';
			$isExpired=$product['isExpired'];
			$expiryDateColor=($isExpired=='t')?'red':'';
			$createDate=$product['productDateCreated'];
			$currentDate = date("Y-m-d H:i:s");
			$expiryDate=$product['expiryDate'];
			
			if(strlen($expiryDate) < 10){
				 $expiryDate= dateFormatView(date('Y-m-d',(strtotime($product['productDateCreated'])+(60*60*24*30*6))))	;
				 $product_expiry_date = date('Y-m-d',(strtotime($product['productDateCreated'])+(60*60*24*30*6)));
			}else{
				$product_expiry_date = $expiryDate;
				$expiryDate= dateFormatView($expiryDate);
				
			}
			
			if($product_expiry_date != '' && $currentDate <= $product_expiry_date) {
				$expiryDateColor = '';
				$expire_label = $this->lang->line('toolExpires');
			} else {
				$expiryDateColor = 'clr_red';
				$expire_label = $this->lang->line('toolExpired');
			}
			
			$createDate=dateFormatView($createDate);
			
			$containerSize=(isset($product['containerSize']) && is_numeric($product['containerSize']))?$product['containerSize']:$this->config->item('defaultContainerSize');
			$containerSize=bytestoMB($containerSize,'mb');
			
			$dirname = 'media/'.LoginUserDetails('username').'/product/'.$productType.'/'.$product['productId'].'/';
			$dirSize=bytestoMB(getFolderSize($dirname),'mb');
			$remainingSize=($containerSize-$dirSize);
			if($remainingSize < 0){
				$remainingSize = 0;
			}
			$remainingSize = number_format($remainingSize,2,'.','');
			$remainingSize=$remainingSize.'&nbsp;'.$this->lang->line('mb');
			$containerSize=$containerSize.'&nbsp;'.$this->lang->line('mb');
			
			$count++;
			$previeLink = 'product/'.$label['project_preview'].'/'.$product['productId'];
			
			$sliderImages = getProductImages('ProductPromotionMedia','prodId',$product['productId'],1, 'isMain');
			
			if(!empty($sliderImages)){
				foreach($sliderImages as $image){
					if($catId == 3)	$product['productImage'] = $image->filePath.$image->fileName;
					else $product['productImage'] = $image->filePath.$image->fileName;					
				}
			}			
						
		if(isset($product['productDateCreated']) && $product['productDateCreated'] != '') $FirstSaved = date("l, d F Y", strtotime($product['productDateCreated']));			
		$ExpiryDate = date('l, d F  Y',(strtotime($product['productExpiryDate'])));
		
		//Get Counts in work 
		$LogSummarywhere = array(
					'entityId'=>$entityId,
					'elementId'=>$product['productId']
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
		//$loggedUserId = $product['tdsUid'];
		$loggedUserId = isloginUser();;
		if($loggedUserId > 0){
			$where = array(
					'tdsUid'=>$loggedUserId,
					'entityId'=>$entityId,
					'elementId'=>$product['productId']
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
		
		<div class="blog_box_wrapper">
			<div class=" cell width_200 Cat_wrapper">
			<?php 
			//$defaultImage='images/product_stock_image.gif';
					
			if((strcmp($productType,'sell')==0 )){
				$alertType='sale';
				$defaultImage = $this->config->item('defaultProductForSale_s');
			}
			else if((strcmp($productType,'freeStuff')==0)){
				$alertType='free';
				$defaultImage = $this->config->item('defaultProductFree');
			}
			else{
				$alertType='wanted';
				$defaultImage = $this->config->item('defaultProductWanted_s');
			}
				
			echo Modules::run("common/imageSlider",$sliderImages,$count,$defaultImage);
			?>
			</div><!-- End Cat_wrapper -->
				
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
							 
							<div class="published_heading"><?php echo $expire_label;?></div> 
							<div class="published_date <?php echo $expiryDateColor;?>"><?php echo  $expiryDate;?></div>
							
							 <div class="clear"></div>
							 
							<div class="published_heading"><?php echo $this->lang->line('freeSpace')?></div> 
							<div class="published_date"><?php echo $remainingSize.'&nbsp;'.$this->lang->line('outof').'&nbsp'.$containerSize;?></div>
							<div class="clear"></div>
							
							<?php if($isBlocked == 'f'){
								if(isset($product['userContainerId']) && $product['userContainerId']>0){
									$projectContainerId = $product['userContainerId'];							
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
				  <div class="seprator_10 row"></div>
							
							
							<div class="row">
								<div class="cell width_100_per">
									<b class="orange_color">Title</b> <span class="event_organiser_name"><?php echo getSubString($product['productTitle'], 67);?></span></div>
								</div>
		
							<div class="seprator_10 row"></div>
							<?php if($catId==3) { ?>
							<div class="row">
								<div class="cell width_100_per">
									<b class="orange_color"><?php echo $this->lang->line('url');?></b> <span class="event_organiser_name">
									<?php 
									//echo '<pre />';print_r($product);die;
									if(@$product['productUrl']!="")
										echo getSubString($product['productUrl'],67);
									else echo '--';
									?>
									</span>
								</div>
							</div>	
							<div class="seprator_10 row"></div>						
							<?php } ?>
							<div class="row"> <b class="orange_color"><?php echo $this->lang->line('project_logLineDescription')?></b>	
								<p><?php echo getSubString($product['productOneLineDesc'], 67);?></p>
								<div class="seprator_10"></div>
							<b class="orange_color"><?php echo $this->lang->line('tagWords')?></b>
							<p><?php echo getSubString($product['productTagWords'], 125);?></p>
							</div>						
						
				</div>
				<div class="cell blog_right_wrapper">
					<div class="blog_link2_wrapper">
						<div class="post_text"></div>
						<div class="tds-button-top modifyBtnWrapper">							
						<?php
							$viewLink = base_url(lang().'/productshowcase/products/'.$userId.'/'.$product['productId']);
							$previewLink = base_url(lang().'/productshowcase/preview/'.$userId.'/'.$product['productId']);
								
							if($isArchive=='t'){
								if($isBlocked != 't' && $isExpired != 't'){ ?>
								 <a class="formTip" href="javascript:void(0);" title="<?php echo $this->lang->line('restore');?>" onclick="moveFromArchive('','Product','productId','<?php echo $product['productId']; ?>','productArchived','/product/<?php echo $productType;?>/deletedItems/','','','','');"><span><div class="restore_btn_icon"></div></span></a>
								
								<!--<a class="formTip" href="javascript:void(0);" title="<?php //echo $this->lang->line('unArchive');?>" onclick="moveFromArchive('','Product','productId','<?php //echo $product['productId']; ?>','productArchived','/product/<?php //echo $productType;?>/deletedItems/','','','','');"><span><div class="blogUnArchiveIcon"></div></span></a>-->
								<?php
								}
								if($isBlocked != 't'){ ?>
									<a href="javascript:void(0);" class="formTip ml6" title="<?php echo $this->lang->line('delete');?>" onclick="deleteTabelRow('Product','productId','<?php echo $product['productId'];?>','','','','','',1,'','1','<?php echo $this->lang->line('sureDelMsg') ?>')"><span><div class="projectDeleteIcon"></div></span></a> 
									<?php
								}
							}else{ 
							
								$editArr = array('title'=>$label['edit'],'class'=>"formTip");
								echo anchor('product/'.$productType.'/'.$product['productId'].'/description', '<span><div class="projectEditIcon"></div></span>',$editArr);

								
								$viewTooltip=$this->lang->line('view');
								$previewTooltip=$this->lang->line('preview');
								
								?>
								<a id="viewIcon<?php echo $uniqueId;?>" class="formTip ml6 viewIcon" <?php echo $viewDisplay;?> target="_blank" href="<?php echo $viewLink;?>" title="<?php echo $viewTooltip;?>"><span><div class="projectPreviewIcon"></div></span></a>
								<a id="previewIcon<?php echo $uniqueId;?>" class="formTip ml6 previewIcon" <?php echo $previewDisplay;?> target="_blank" href="<?php echo $previewLink;?>" title="<?php echo $previewTooltip;?>"><span><div class="projectPreviewIcon"></div></span></a>

								<a href="javascript:void(0);" class="formTip ml6" title="<?php echo $this->lang->line('delete');?>" onclick="moveInArchive('','Product','productId','<?php echo $product['productId']; ?>','productArchived','isPublished','/product/<?php echo $productType;?>','','','','','')"><span><div class="projectDeleteIcon"></div></span></a> 
								<?php
							}
					?>
						</div>
						</div>
						<div class="clear"></div>
					<div class="rating_box_wrapper padding_top10">
						<div class="orgLabel">
						<?php 
						$industryName=getIndustry($product["productIndustryId"]);
						echo $industryName;
						?>
						</div>
					</div>
					<div class="clear"></div>
					<!--rating_box_wrapper-->
					<!--<div class="rating_box_wrapper">
					<img class="fr" src="<?php //echo $ratingImg;?>" />
					</div>
					<div class="clear"></div>-->
					<!--rating_box_wrapper-->			
					<div class="blog_link3_wrapper">
						<div class="blog_link3_box">
							<div class="icon_crave2_blog <?php echo $cravedALL;?>"> Craves </div>
							<div class="blog_link3_point"><?php print($craveCount == '' ? '0' : $craveCount ); ?></div>
						</div>
						<div class="blog_link3_box">
							<div class="icon_view2_blog"> Views </div>
							<div class="blog_link3_point"><?php print($viewCount == '' ? '0' : $viewCount ); ?></div>
						</div>
						
						<div class="blog_link3_box">
							<div class="icon_lastview2_blog"> 
								<?php echo $label['project_lastViewed'] ;?><br/>
								<b><?php echo date('d M Y');?></b>
							</div>
						<?php if($catId !=3){?>
						<div class="blog_link3_box">
							<div class="icon_post2_blog lH12"><?php echo $label['project_price'] ;?><br>
								<b><?php
								//echo '$catId:'.$catId;
								if((strcmp($productType,'sell')==0))
								{
									$priceDetails=getDisplayPrice($product['productPrice'],$seller_currency);								
									echo $priceDetails['currencySign'].' '.$priceDetails['displayPrice'];
								}
								if((strcmp($productType,'wanted')==0 ))
								{
									echo isset($product['productwillingToPay'])? $product['productwillingToPay']:0;
								}
									?></b>
							</div>							
						</div>
						<?php } ?>
						</div>
						
					</div>
									
  
				</div>
				
				
				<div class="row blog_links_wrapper">
					<div class="fl cell">
						 <?php
							$relation = array('share','entityTitle'=> addslashes($product['productTitle']), 'shareType'=>$this->lang->line('product'), 'shareLink'=> $viewLink, 'id'=> 'work'.$product['productId'],'entityId'=>$entityId,'elementid'=>$product['productId'],'projectType'=>'product','isPublished'=>$product['isPublished']);
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
					<!--Start Div for showing bid list button-->
					<div class="fl cell">
						<div class="row rtsp">
							<?php 
							//Get projects Auction data
							$where = array('projectId'=>$product['productId'],'entityId'=>$entityId,'elementId'=>$product['productId']);
							$auctionRes = getDataFromTabel('Auction','*',  $where, '','', '', 1 ); 
							if(is_array($auctionRes) && count($auctionRes)>0) {
								$this->load->view('auction/bidListButton',array('auctionId'=>$auctionRes[0]->auctionId,'projectTitle'=>$product['productTitle']));
							}
							?>
						</div>				
					</div>
					<!--End Div for showing bid list button-->
					<?php
					if($isArchive=='f' && $isBlocked=='f'){ 
						
						
						$sessionMsg='';
						$isFARF=1;
						
						if($productType == 'sell' && $isFARF){
							if(!$isSellerSettings){
								$isFARF=0;
								$sessionMsg=$this->lang->line('sellerSettingsMsg');
								
							}elseif( (!is_numeric($product['productPrice']) || ! ($product['productPrice'] >0)) && ($product['productSellType'] !=2) ){
								$isFARF=0;
								$sessionMsg=$this->lang->line('sellproductMsg');
							}else{
								$countShipping=countResult($table='ProjectShipping',array('entityId'=>$entityId,'elementId'=>$product['productId']),'', 1);
								if(!($countShipping >=1)){
									$isFARF=0;
									$sessionMsg=$this->lang->line('sellproductShippingMsg');
								}
							}
						}
						
						
						
						if($isFARF && $productType == 'sell' && ( !is_numeric($product['productPrice']) || ! ($product['productPrice'] >0) )  && ($product['productSellType'] !=2)){
							$isFARF=0;
							$sessionMsg=$this->lang->line('sellproductMsg');
						}
						
						$notificationArray = array('entityId'=>$entityId,'elementId'=>$product['productId'],'industryId'=>$product['productIndustryId'],'projectType'=>'product','alert_type'=>$alertType);
						
						$publisButton = array('isFARF'=>1,'currentStatus'=>$this->lang->line('Publish'),'changeStatus'=>$this->lang->line('hide'),'isPublished'=>'t','isElement'=>1,'tabelName'=>'Product','pulishField'=>'isPublished','field'=>'productId','fieldValue'=>$product['productId'],'deleteCache'=>$this->router->fetch_method(), 'elementTable'=>'', 'elementField'=>'','sessionMsg'=>$sessionMsg,'notificationArray'=>$notificationArray);
						$unpublisButton = array('isFARF'=>$isFARF,'currentStatus'=>$this->lang->line('hide'),'changeStatus'=>$this->lang->line('Publish'),'isPublished'=>'f','isElement'=>1,'tabelName'=>'Product','pulishField'=>'isPublished','field'=>'productId','fieldValue'=>$product['productId'],'deleteCache'=>$this->router->fetch_method(), 'elementTable'=>'', 'elementField'=>'','sessionMsg'=>$sessionMsg,'notificationArray'=>$notificationArray);
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
				<div class="clear"></div>

			</div><!--blog_box-->
			
		</div>
		<div class="shadow_blog_box"> </div>
		</div><!--width_569-->
		
			
		</div>
		<?php 
		}
		/*How to publish popup*/	
		?>
		<div class="clear"></div>
		<?php if($productType=='sell'){
			if($items_total >  $perPageRecord){
				$publishClass = 'pa ml30';
			}else{
				$publishClass = 'ml30';
			}
			$this->load->view('common/howToPublish',array('industryType'=>'product', 'class'=>$publishClass));
		}else{
			$this->load->view('common/howToPublish',array('industryType'=>'product', 'class'=>'pa ml30 mt-64'));
		}
		/*End How to publish popup */
		if($items_total >  $perPageRecord){
			?>
			<div class="row">
				<div class=" cell width_200 Cat_wrapper">&nbsp;</div>
				<div class="cell width_569 margin_left_16 pagingWrapper">
					<?php 
					$this->load->view('pagination',array("pagination_links"=>$pagination_links,"items_total"=>$items_total,"items_per_page"=>$items_per_page,"perPageRecord"=>$perPageRecord,"url"=>base_url(lang().'/product/'.$productType),"divId"=>"elementListingAjaxDiv","formId"=>0,"unqueId"=>"full","isShowNumber"=>true,"isShowDD"=>true,"pagingWpaerClass"=>'pagination_wrapper new_page_design new_page_design',"pagingDDDClass"=>'left_site_dropdown m0 new_page_design new_page_design')); ?>
					<div class="clear"></div>
				</div>
			</div>
			<?php
		}
	} 
