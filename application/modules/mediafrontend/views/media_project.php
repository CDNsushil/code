<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 
include(APPPATH.'modules/mediafrontend/views/projectdata.php');
if(!$projectDataFlag){
	redirectToNorecord404();
}else{?>	
	<td class="<?php echo $bgColor;?>" valign="top">
		<div class="cell width_476  pr9 pl9 <?php echo $bgColor;?>">
			<div class="seprator_10"></div>
			<?php 
			if(!empty($method) && $elementId > 0 && $elementsCollection){
				
				echo $this->load->view($elementDetailPage,array('project'=>$project,'elementsCollection'=>$elementsCollection,'userInfo'=>$userInfo,'seller_currency'=>$seller_currency,'currencySign'=>$currencySign,'sectionId'=>$sectionId));
			}else{
				echo $this->load->view($projectDetailPage,array('project'=>$project,'userInfo'=>$userInfo,'seller_currency'=>$seller_currency,'currencySign'=>$currencySign,'sectionId'=>$sectionId));
			}?>
			<div class="clear seprator_20"></div>
		</div> <!--cell_width_476-->
	</td>
	<td class="<?php echo $bgColor;?>"  valign="top">
	  <div class="cell width_284 pl10 pr10  <?php echo $bgColor;?>">
		 <div class="mt11"></div>
		 <div onclick="window.location.href='<?php echo $projectUrl;?>'" class="row summery_right_archive_wrapper width_auto ptr <?php echo $dn;?>">
			<?php    
			 if ( ($methodName=='writingpublishing' && $project['projCategory']==6) || ($methodName=='filmvideo' && $project['projCategory']==1) ) { ?>
			 
				  <h1 class="sumRtnew_strip <?php echo $clr_white;?> gray_light_hover"><?php echo $this->lang->line('abtMajorWork');?>
				  
				<?php } else {?>	
				 
					 <h1 class="sumRtnew_strip <?php echo $clr_white;?> gray_light_hover"><?php echo $this->lang->line('aboutCollection'); } ?>
					 
				<div class="Fright mt9 mr20">
					<a onmousedown="mousedown_plus_icon(this)" onmouseup="mouseup_plus_icon(this)" class="ma_plus_icon"></a>
				</div>
			</h1>
		 </div>
		 <?php
			 
			 if(isset($project['elements']) && count($project['elements'])>0){//check if no element is present
				  $elementPresent = 't';
			  }else{
				  $elementPresent = 'f';
			  }
			 
			 $isPublished_array = search_nested_arrays($project['elements'],'isPublished');
			
			 $globalIsPublished = 'f';
			 
			 for($j = 0; $j < count($isPublished_array); $j++)
			 {
				if($isPublished_array[$j]=='t') //to check it there any element is present to get download, then the download button get shown on that basis
				{
					$globalIsPublished = 't';
					break;
				}		   
			 }	
			
			 //if no element is published
			 if( $globalIsPublished == 'f')  $elementPresent = 'f';
			 
			 $isExternal_array = search_nested_arrays($project['elements'],'isExternal');
			
			 $globalProjDownloadable = 'f';
			 
			 for($j = 0; $j < count($isExternal_array); $j++)
			 {
				if($isExternal_array[$j]=='f') //to check it there any element is present to get download, then the download button get shown on that basis
				{
					$globalProjDownloadable = 't';
					break;
				}		   
			 }	
			  //Check if all element are free having no download price button	
			 $isDownloadPrice_array = search_nested_arrays($project['elements'],'isDownloadPrice');
			 $downloadPrice_array = search_nested_arrays($project['elements'],'downloadPrice');
			 $isGlobalDownload = 'f';
			 
			 for($j = 0; $j < count($downloadPrice_array); $j++)
			 {
				if($downloadPrice_array[$j]>0 && $isDownloadPrice_array[$j]=='t') //to check it there any element is present to get download, then the download button get shown on that basis
				{
					$isGlobalDownload = 't';
					break;
				}		   
			 }	
			 
			 //Check if all element are free having no PPV price button
			 $isPerViewPrice_array = search_nested_arrays($project['elements'],'isPerViewPrice');
			 $perViewPrice_array = search_nested_arrays($project['elements'],'perViewPrice');
			 $isGlobalPPV = 'f';
			 
			 for($j = 0; $j < count($downloadPrice_array); $j++)
			 {
				if($perViewPrice_array[$j]>0 && $isPerViewPrice_array[$j]=='t') //to check it there any element is present to get download, then the download button get shown on that basis
				{
					$isGlobalPPV = 't';
					break;
				}		   
			 }
			$priceBtnDetails=array(
				'ownerId'=>$userId,
				'projEntityId'=>$entityId,
				'entityId'=>$entityId,
				'elementId'=>$project['projId'],
				'sectionId'=>$sectionId,
				'projectId'=>$project['projId'],
				'tableName'=>'Project',
				'primeryField'=>'projId',
				'elementTable'=>$elemetTable,
				'elementPrimeryField'=>'projId',
				'fileId'=>0,
				'isElement'=>0,
				'isMajor'=>($project['showPrice']=='f')?true:false,
				'projSellstatus'=>($project['projSellstatus']=='t')?true:false,
				'isprojPrice'=>($project['isprojPrice']=='t')?true:false,
				'projPrice'=>$project['projPrice'],
				'isprojDownloadPrice'=>($project['isprojDownloadPrice']=='t')?true:false,
				'projDownloadPrice'=>$project['projDownloadPrice'],
				'isPrice'=>'',
				'isDownloadPrice'=>'',
				'price'=>'',
				'downloadPrice'=>'',
				'isprojPpvPrice'=>($project['isprojPpvPrice']=='t')?true:false,
				'projPpvPrice'=>$project['projPpvPrice'],
				'isPerViewPrice'=>false,
				'perViewPrice'=>'',
				'fileName'=>'',
				'filePath'=>'',
				'isExternal'=>'',
				'isDefault'=>'',
				'seller_currency'=>$seller_currency,
				'globalProjDownloadable'=>$globalProjDownloadable,
				'elementPresent'=>$elementPresent,
				'isGlobalDownload'=>$isGlobalDownload,
				'isGlobalPPV'=>$isGlobalPPV
		 );
								
		 if($projSellstatus){
						if((@$project['isprojPrice']=='f' && @$project['isprojDownloadPrice']=='f' && @$project['isprojPpvPrice']=='f')){
							$downloadButtonParams['buttonStyle']='big';
							$downloadButtonParams['downloadDetails']=$priceBtnDetails;
							$this->load->view('media_download_button',$priceBtnDetails);
						}
						else{
							
								 $projDownloadPriceDetails=getDisplayPrice($downloadPrice,$seller_currency);
								 $PPVPriceDetails=getDisplayPrice($project['projPpvPrice'],$seller_currency);
							
								 //qunatityFlag will be true if we want to display button according to Quanitty present default it is false
								$qunatityFlag='t';

								//shippingFlag will be true if we want to display button according to shippingFlag present default it is true
								$shippingFlag = 't';

								//Array is passed to give property of price button to get shown on the basisi of those

								$buttonProperty = array('price'=>@$price,
									'priceFlag'=>$project['isprojPrice'],
									'quantity'=>@$project['projQuantity'],
									'elementId'=>$project['projectId'],
									'entityId'=>$entityId,
									'projId'=>$project['projectId'],
									'sectionId'=>$sectionId,
									'shippingFlag'=>$shippingFlag,
									'qunatityFlag'=>$qunatityFlag,
									'seller_currency'=>$seller_currency,
									'buttonClass'=>' ',
									'buttonStyle'=>'big',
									'tdsUid'=>$userId,
									
								);
								
								//Only product button is get displayed
								if($elementPresent=='f')
									$buttonClass = 'productPriceButton ma';
								else
									$buttonClass = 'cell productPriceButton ml20';	
								
								
								//product Bid button start here
								if(isset($project['projSellType']) && $project['projSellType']==2) {
									//Get projects Auction data
									$where = array('projectId'=>$project['projectid'],'entityId'=>$entityId,'elementId'=>$project['elementId']);
									$auctionRes = getDataFromTabel('Auction','*',  $where, '','', '', 1 ); 
									if(is_array($auctionRes) && count($auctionRes)>0) {
										//Get Users bid if exists
										$userBidRes = $this->model_common->getDataFromTabel('AuctionBids', 'bidId,price',  array('auctionId'=>$auctionRes[0]->auctionId,'userId'=>$loggedUserId),'','','','');
										//Set user bid params
										$bidId = (isset($userBidRes[0]->bidId) && $userBidRes[0]->bidId !='') ?$userBidRes[0]->bidId : 0 ;
										$bidPrice = (isset($userBidRes[0]->price) && $userBidRes[0]->price !='') ?$userBidRes[0]->price : 0 ;
										
										//Load bid button
										$this->load->view('auction/bidPriceButton',array('title'=>$project['projName'],'auctionId'=>$auctionRes[0]->auctionId,'minimumBidPrice'=>$auctionRes[0]->minBidPrice,'tdsUid'=>$project['tdsUid'],'section'=>'product','auctioEndDate'=>$auctionRes[0]->endDate,'bidId'=>$bidId,'bidPrice'=>$bidPrice,'currencySign'=>$currencySign));	
									}
								} 	//product Bid button end here	
								else {
									//load product price button
									$buttonProperty['buttonClass'] = $buttonClass;
									$buttonProperty['priceBtnDetails'] = $priceBtnDetails;
									$productButton = Modules::run("common/showPriceButton",$buttonProperty);
								}
							
							  if(!empty($productButton['productButtonPresent']) ||( $downloadPrice > 0 && $project['isprojDownloadPrice']=='t')){
									if(empty($productButton['productButtonPresent'])) $buttonClass = 'productPriceButton ma';
									
									/***********check login user with download************/
									
									if(isLoginUser() == false) // login user Id
										{
											$loginId=0;
										}else
										{
											$loginId=isLoginUser();
										}
										//echo $tdsUid;die;
										$canNotBuy = $this->lang->line('Youcannotbuyfromyourself');
										$functionBuyButton = ($userId == $loginId)?"customAlert('".$canNotBuy."')":'';
										
									/***********check login user with download************/	
								
								if(isset($productButton['view']) && $productButton['view']!='') $height_90 = 'height_90';
								else $height_90 = '';
							  ?>
						<div class="row widthAuto <?php echo $height_90; ?>">
							<?php 	
							
							if(isset($productButton['view'])) echo $productButton['view'];								
							if(!($project['projectType'] == 'news' ||$project['projectType'] == 'reviews' )){			
								$this->load->view('media_download_button',$priceBtnDetails);
							}
						   ?>
						  <div class="clear"></div>
						</div>
						<?php
							
							 }//End if($buttonClass !='0')
							 if($project['isprojPpvPrice'] == 't' && $project['projPpvPrice'] > 0  && $elementPresent=='t'){
								
								/***********check login user with ppv************/
								if(isLoginUser() == false) // login user Id
								{
									$loginId=0;
								}else
								{
									$loginId=isLoginUser();
								}
								//echo $tdsUid;die;
								$canNotBuy = $this->lang->line('Youcannotbuyfromyourself');
								$functionBuyButton = ($userId == $loginId)?"customAlert('".$canNotBuy."')":'';
									
								/***********check login user with ppv************/	
									//Array is passed to give property of download button to get shown on the basisi of those
									$PPVButtonProperty = array(
										'price'=>$project['projPpvPrice'],
										'showFlag'=>$project['isprojPpvPrice'],
										'seller_currency'=>$seller_currency,
										'tdsUid'=>$userId,
										'elementId'=>$project['projectId'],
										'entityId'=>$entityId,
										'projId'=>$project['projectId'],
										'sectionId'=>$sectionId,
										'buttonStyle'=>'big'									
									);
									$PPVButtonProperty['priceBtnDetails'] = $priceBtnDetails;
									$PPVButton = Modules::run("common/showPPVButton",$PPVButtonProperty);
									echo isset($PPVButton['view'])?$PPVButton['view']:'';	
						   }//PPV if end
				
			 }//end Else
		 }
		 else if(!isset($projSellstatus) || $projSellstatus !='t'){
			if($project['projDonations']=='t'){ 
				$donorDetail=array('entityId'=>$entityId,'elementId'=>$project['projId'],'projId'=>$project['projId'],'sectionId'=>$sectionId,'ownerId'=>$userId,'seller_currency'=>$seller_currency);
				$this->load->view("shipping/donate_frontend_view",$donorDetail); 
			}
			if(!($project['projectType'] == 'news' || $project['projectType'] == 'reviews' )){
				$downloadButtonParams['buttonStyle']='big';
				$downloadButtonParams['downloadDetails']=$priceBtnDetails;
				$this->load->view('media_download_button',$priceBtnDetails);
			}
		 }
			
		 if(is_array($project['elements']) && count($project['elements'])>0 && ($methodName=='filmvideo' || $method=='filmvideo')){ 
			$this->load->view('videoGalleryView',array('project'=>$project));
		 }
		 if($methodName=='photographyart'){
			 	$thumbFolder='thumb';
			$redirectUrl = base_url(lang().$urlUsername.'/mediafrontend/'.$this->router->method.'/'.$userId.'/'.$project['projId']);
			$projSellstatus=$project['projSellstatus']=='t'?true:false;
			if($projSellstatus){
				$thumbFolder='watermark';
			}
			$elements_array = search_nested_arrays($project,'elements');
			//echo '<pre />';print_r($elements_array);
			$title_array = search_nested_arrays($project,'title');
			$elementId_array = search_nested_arrays($project,'elementId');
			$isExternal_array = search_nested_arrays($project,'isExternal');
			$isPublished_array = search_nested_arrays($project,'isPublished');	
			$file_path_array = search_nested_arrays($project,'filePath');
			$file_name_array = search_nested_arrays($project,'fileName');
			$img_array=array();
			for($j = 0; $j < count($file_path_array); $j++)
			{
				if($isPublished_array[$j]=='t'){
					if($isExternal_array[$j] =='f')
					{
						//$img_array[$j] = base_url(@$file_path_array[$j].@$file_name_array[$j]);
						$thumbImage_xs = addThumbFolder($file_path_array[$j].$file_name_array[$j],'_xs',$thumbFolder);				
						$thumbImage_l = addThumbFolder($file_path_array[$j].$file_name_array[$j],'_l',$thumbFolder);				
						$thumbImage_m = addThumbFolder($file_path_array[$j].$file_name_array[$j],'_m',$thumbFolder);				
						$thumbImage_orignal = $file_path_array[$j].$file_name_array[$j];
						
						$isFileExist = getMediaImage($thumbImage_xs);
							if($isFileExist!=''){				
								$img_array[$j]['xs'] = getMediaImage($thumbImage_xs);
								$img_array[$j]['m'] = getMediaImage($thumbImage_m);
								$img_array[$j]['l'] = getMediaImage($thumbImage_l);
								$img_array[$j]['org'] = getMediaImage($thumbImage_orignal);
							 }	
						
										
						//$img_array[$j]['xs'] = getImage($thumbImage_xs,$this->config->item('defaultNoMediaImg'));
						//$img_array[$j]['m'] = getImage($thumbImage_m,$this->config->item('defaultNoMediaImg'));
						//$img_array[$j]['l'] = getImage($thumbImage_l,$this->config->item('defaultNoMediaImg'));
						//$img_array[$j]['org'] = getImage($thumbImage_orignal,$this->config->item('defaultNoMediaImg'));
					}
					else	
						//$img_array[$j] = @$file_path_array[$j];	
						
						 if($file_path_array[$j]!=''){
							$img_array[$j]['xs'] = checkExternalImage(@$file_path_array[$j],'_xs');
							$img_array[$j]['m'] = checkExternalImage(@$file_path_array[$j],'_l');
							$img_array[$j]['l'] =checkExternalImage(@$file_path_array[$j],'_m');
							$img_array[$j]['org'] = @$file_path_array[$j];																		
						}	
						
						
				}		   
			}	
			$img_array['img_array'] = $img_array;
			$img_array['title_array'] = $title_array;
			$img_array['elementId'] = $elementId_array;
			$img_array['redirectUrl'] = $redirectUrl;
			
			if (!array_filter($img_array['img_array'])) {
					$showGallery =0; // No Image to show
				}else {
					$showGallery =1;					
					}
			
			$popup_images=$this->load->view('popup_images',$img_array, true);
			?>
			<script>
				var popup_images=<?php echo json_encode($popup_images);?>;
			</script>
		<?php	
			$this->load->view('imageGalleryView',array('project'=>$project,'showGallery'=>$showGallery));
		 }
		 
		 //------load playlist link view start------//
		 if($method=='musicaudio'){
				$this->load->view('myplaylist_link_view',array('userId'=>$userId));
			}
		 //------load playlist link view end--------//
		 
		 if($defaultElementFlag){ 
			$this->load->view('default_element',array('defaultElements'=>$defaultElements,'clr_white'=>$clr_white,'elementId'=>$elementId,'method'=>$method,'methodName'=>$methodName,'sectionBgcolor'=>$sectionBgcolor,'imagetype_xs'=>$imagetype_xs,'elementHeading'=>$elementHeading,'elememtDivHeihgt'=>$elememtDivHeihgt));
		 }
		 if($mainElementFlag){ 
			$this->load->view('main_element',array('mainElements'=>$mainElements,'clr_white'=>$clr_white,'elementId'=>$elementId,'method'=>$method,'methodName'=>$methodName,'sectionBgcolor'=>$sectionBgcolor,'imagetype_xs'=>$imagetype_xs,'elementHeading'=>$elementHeading,'elememtDivHeihgt'=>$elememtDivHeihgt));
		 }
		 if(!($methodName=='news' || $methodName=='reviews')){
			 if(isset($suportLinks) && $suportLinks){
				 $this->load->view('supporting_material',array('suportLinks'=>$suportLinks,'clr_white'=>$clr_white,'methodName'=>$methodName,'sectionBgcolor'=>$sectionBgcolor,'imagetype_xs'=>$imagetype_xs,'elementHeading'=>$elementHeading,'elememtDivHeihgt'=>$elememtDivHeihgt));
				 echo '<div class="seprator_16"></div>';
			 }
			 $tableInfo=array(
								'entityId'=>$entityId,
								'elementId'=>$projectId,
								'tableName'=>array('AddInfoNews','AddInfoInterview','AddInfoReviews'),
								'sections'=>array($this->lang->line('NEWS'),$this->lang->line('INTERVIEWS'),$this->lang->line('externalReviews')),
								'orderBy'=>array('news','interv','review'),
								'sectionBgcolor'=>$sectionBgcolor,
						);
			 echo Modules::run("additionalInfo/additionalInfoList", $tableInfo);
		 }
		 $projLabel = ($methodName=='photographyart')?$this->lang->line('albums'): $this->lang->line('projects'); ?>
		 <div class="row summery_right_archive_wrapper showcase_link_hover">
			<h1 class="sumRtnew_strip <?php echo $clr_white;?>"><?php echo $projLabel;?></h1>
				<?php echo $projectListingData;?> 
		 </div>
		 <div class="clear seprator_10"></div>
			  
		 <div class="ad_box_shadow width250px mb20" id="advert250_250">
			<?php 
			if(is_dir(APPPATH.'modules/advertising') && !empty($advertSectionId)){
				//Manage right side forum advert
				$bannerRhsData =  Modules::run("advertising/getAdvertRecords", array('sectionId'=>$advertSectionId,'advertType'=>'1'));
				if(!empty($bannerRhsData)) {
					$this->load->view('common/advert',array('bannerData'=>$bannerRhsData,'advertType'=>'1','sectionId'=>$advertSectionId));
				} else {
					$this->load->view('common/adv_rhs_forum');
				}
			} else {
				$this->load->view('common/adv_rhs_forum');
			}?> 
			</div> 
	  </div>
	</td>
	<?php
	if(is_dir(APPPATH.'modules/advertising') && !empty($advertSectionId)){ 
		//manage auto advert params and js methods
		$this->load->view('advertising/advertAutoChange',array('bannerType1'=>$bannerType1,'bannerType2'=>$bannerType2,'bannerType3'=>$bannerType3));
	}
}
/* End of file media.php */
/* Location: ./application/module/media/view/media.php */
/* Wriiten By Sushil Mishra */
?>

