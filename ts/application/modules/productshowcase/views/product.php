<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 
$workProfileId = !empty($workProfileId) ? $workProfileId : 0;
$currentMethod = $this->router->method;
if(count($currentproductDetail)>0)	{
	$userInfo = showCaseUserDetails($userId);
	
	$seller_currency=$userInfo['seller_currency'];
	$seller_currency=($seller_currency>0)?$seller_currency:0;
	$currencySign=$this->config->item('currency'.$seller_currency);
	
	if($currentproductDetail->catId==1){
		$defaultImage = $this->config->item('defaultProductForSale_m');
		$sectionId=$this->config->item('productsSellSectionId');
	}
	else if($currentproductDetail->catId==3){
		$defaultImage = $this->config->item('defaultProductFree');
		$sectionId=$this->config->item('productClassifiedFreeSectionId');
	}
	else{
		$defaultImage = $this->config->item('defaultProductWanted_m');
		$sectionId=$this->config->item('productsWantedSectionId');
	}

	$thumbImage = addThumbFolder(@$currentproductDetail->filePath.@$currentproductDetail->fileName,'_m');				
	$thumbImg = getImage(@$thumbImage,$defaultImage);
			
	//$thumbImg = getImage(@$currentproductDetail->filePath.'/'.@$currentproductDetail->fileName,$defaultImage); 	

		$LogSummarywhere=array(
			'entityId'=>$productEntityId,
			'elementId'=>$defaultproductId
		);

		$resLogSummary = getDataFromTabel('LogSummary', 'craveCount,ratingAvg,viewCount',  $LogSummarywhere, '', $orderBy='', '', 1 );
		if($resLogSummary){
			$resLogSummary=$resLogSummary[0];
			$craveCount=$resLogSummary->craveCount;
			$ratingAvg=$resLogSummary->ratingAvg;
			$viewCount = $resLogSummary->viewCount;
		}else{
			$craveCount=0;
			$ratingAvg=0;
			$viewCount = 0;
		}
		
		$ratingAvg=roundRatingValue($ratingAvg);
		$ratingImg='images/rating/rating_0'.$ratingAvg.'.png';			
		
		
		$cravedALL='';
		$loggedUserId=isloginUser();
		if($loggedUserId > 0){
			$where = array(
							'tdsUid'=>$loggedUserId,
							'entityId'=>$productEntityId,
							'elementId'=>$defaultproductId
					);
			$countResult=countResult('LogCrave',$where);
			$cravedALL=($countResult>0)?'cravedALL':'';
		}else{
			$cravedALL='';
		}		
				
	//$currentproductDetail->productUrl='www.freeproductgoeshere.com';	
?>

 <!--Middle_column-->
 <td class="bg_DarkBlue" valign="top"> 
	  
        <div class="cell width_476 sub_col_1 pr9 pl9 bg_DarkBlue">
          <div class="seprator_10"></div>			
					 <div class="Work_gredient_box pt13 pl20 pr11 pb20">
						<div class="font_opensansLight font_size26 lineH_32"><?php echo @$currentproductDetail->productTitle;?></div>
						<?php if(!empty($currentproductDetail->productUrl)){ ?>
						<div class="seprator_10"></div>
						<div class="productFrontUrl ptr" onclick="gotourl('<?php echo @$currentproductDetail->productUrl;?>',1);"><a href="javascript:void(0);" class="text_shadow_product clr_f15921"><?php echo @$currentproductDetail->productUrl;?></a></div>
						<?php } ?>
						<div class="seprator_20"></div>
						
						<div class="text_alignC note font_size13 fntclr_Products"><?php echo @$currentproductDetail->productOneLineDesc;?></div>
					   </div>
					 <div class="seprator_7"></div>
					  <!--box-->
					  <?php if(@$currentproductDetail->productDescription!=''){ ?>
					  <div class="Work_gredient_box pt13 pl20 pr11 pb20">
						<div class="clr_black font_size14 NIC"><b><?php echo $this->lang->line('productDescription');?></b></div>
						<div class="clear seprator_10"></div>
						<div class="font_size13 NIC" >
						  <p><?php echo changeToUrl($currentproductDetail->productDescription);?></p>
						</div>
					  </div>
					  <div class="seprator_7"></div>
					 <?php } ?>
		
					<!-- Div for 468x60 advert display -->
					<div class="row width470px ma mt13" id="advert468_60"><?php 
						if(is_dir(APPPATH.'modules/advertising') && !empty($advertSectionId)){
							//Manage left side content bottom advert
							$bannerRhsData =  Modules::run("advertising/getAdvertRecords", array('sectionId'=>$advertSectionId,'advertType'=>'3'));
							if(!empty($bannerRhsData)) {
								$this->load->view('common/advert',array('bannerData'=>$bannerRhsData,'advertType'=>'3','sectionId'=>$advertSectionId));
							} else {
								$this->load->view('common/adv_content_bot'); 
							} 
						} else {
							$this->load->view('common/adv_content_bot');  
						}?>
					</div>
					</div>
					
					<div class="clear"></div>	
					<div class="seprator_10"></div>
					<?php						
					//If Not Free Then Show the Promo images
					   if($currentproductDetail->catId!=3){
						   //LOAD RELATED PROMO IMAGES
						   $promo_images['defaultImage'] = $defaultImage;
						   echo $this->load->view('promo_images',$promo_images);
					   }		   
					?>        
         <!---<div class="seprator_18"></div>-->
         <div class="seprator_18"></div>
         <div class="scroll_box darkGrey_bg pt7 pb7 bdr_d2d2d2">
            <div class="row">                    
                    <div class="fl blog_links_wrapper pt0">
						<?php	
							//$url = base_url().uri_string();
							$currentUrl = base_url().uri_string();								
							$relation = array('getFrontShortLink', 'email','share','entityTitle'=> $currentproductDetail->productTitle, 'shareType'=>$productType, 'shareLink'=> $currentUrl,'id'=> 'Project'.$currentproductDetail->productId,'entityId'=>$productEntityId,'elementid'=>$defaultproductId,'projectType'=>$productType,'isPublished'=>@$currentproductDetail->isPublished,'viewType'=>'showcase');
							$this->load->view('common/relation_to_share',array('relation'=>$relation));
						?>							  
				   </div>   			             
                <div class="tds-button_rate cell Fright"> 
                   <?php //$this->load->view('rating/ratingView',array('elementId'=>$defaultproductId,'entityId'=>$productEntityId,'ratingAvg'=>$ratingAvg,'ratingClass'=>'width_auto ml5 Fleft'));?>
                </div>
                <?php
                 
					$cacheFile = 'cache/product/product_'.$defaultproductId.'_'.@$currentproductDetail->tdsUid.'.php';
					$cacheImg = @$currentproductDetail->filePath.'/'.@$currentproductDetail->fileName;
					$this->load->view('craves/craveView',array('elementId'=>$defaultproductId,'entityId'=>$productEntityId,'ownerId'=>@$currentproductDetail->tdsUid,'isPublished'=>$currentproductDetail->isPublished,'projectType'=>'product','furteherDetails'=>'{"projectId":"'.$defaultproductId.'","table":"Product","primeryField":"productId","imageUrl":"'.$cacheImg.'","fieldSet":"productId as id, productTitle as craveTitle, productOneLineDesc as craveShortDescription, productTagWords as tagwords","cacheFilePath":"'.$cacheFile.'"}'));
					
					if(@$currentproductDetail->catId==1) { 
				?>
					<div class="tds-button01 cell Fright">			
		              <?php $this->load->view('media/reviewView',array('elementId'=>$defaultproductId,'entityId'=>$productEntityId,'projName'=>$currentproductDetail->productTitle,'section' =>'Products','industryId' =>'12','isPublished'=>$currentproductDetail->isPublished));	?>			
                    </div>	
				<?php
					  $productType = $this->lang->line('productforSale_no_s');
					 // $applyButton = $this->lang->line('buy');
					  $applyButton = '';
					} elseif(@$currentproductDetail->catId==2){
						$productType = $this->lang->line('productWanted_no_s');
						$applyButton = $this->lang->line('offerAproduct');
					} else {
						$productType = $this->lang->line('freeproduct_no_s');
						$applyButton = '';
				   }
               ?> 
                <div class="clear"></div>
               </div>     
          </div>
          <div class="clear seprator_18"></div>
          <!--cell_width_476-->
        </div>
        
       <div class="row mt18 ml5"><?php //$this->load->view('common/adv_mid_bot'); ?></div>
      <?php echo Modules::run("mediafrontend/getReviewList",$productEntityId,$defaultproductId,0,0); ?> 
       
      </td>
      <td class="bg_DarkBlue"  valign="top"> 
		<?php if(strcmp($currentMethod,'viewproject')==0){ ?>
		<div class="mt10"></div>   
		<div class="row summery_right_archive_wrapper">
			<h1 class="swp_user_name clr_white "><?php echo $userInfo['userFullName'];?></h1>
			<ul class="swp_user_name_link">
			  <li class="mt9">
				  <?php 
					$method = 'products';
					$shocaseUrl=base_url(lang().'/productshowcase/'.$method.'/'.$currentproductDetail->tdsUid.'/'.$defaultproductId); 
					//$shocaseUrl=base_url(lang().'/productshowcase/'.$method.'/'.$productType.'/'.$currentproductDetail->tdsUid.'/'.$defaultproductId);  ?>

				  <a class="clr_white" href="<?php echo $shocaseUrl;?>"><?php echo $this->lang->line('viewShowcase');?></a>
			  </li>
			</ul>
		 </div>
		<?php } ?>	 
      <div class="clear seprator_10"></div> 
	 <div class="sumRtnew_strip clr_white pl10 height_32"><?php echo $productType ?> </div>
        <!--right_column-->
        <div class="cell width_284 pl10 pr10 sub_col_2 bg_DarkBlue">
          <div class="mt10"></div>
          <!--right btn-->
          <div class="scroll_box darkGrey_bg global_shadow pt15 pb15 bdr_d2d2d2">
            <?php
			$divWidth = 'width_242';
            $imgWidth =" max_w240_h158";			
            ?>
            <div class="Fleft ml20 <?php echo $divWidth;?>">
              <div class="AI_table">
                <div class="AI_cell">
					
					<img border="0" src="<?php echo $thumbImg;?>" class="wp_topimg_thumb  <?php echo $imgWidth; ?> bdr_d2d2d2"></div>
              </div>
            </div>
            <div class="clear"></div>
            <div class="ml20 mr20 mt25">
              <div class="font_opensansSBold clr_white ">
                
                <div class="summery_posted_wrapper bdr_T666666">
					 <span class="cell pl16">
						<?php echo $this->lang->line('advertised');?>
					</span>
					<span class="cell width125px  pl16 orange">
						<?php echo date("d F Y", strtotime(@$currentproductDetail->productExpiryDate));?>
					</span> 
					<div class="clear"></div>	 
				</div>
               <?php if(!empty($currentproductDetail->productCity) || !empty($currentproductDetail->productCountryId)){?>
                 <div class="summery_posted_wrapper bdr_T666666">
					 <span class="cell width220px  pl16">
					 <?php 
					 $comma='';
					 if(!empty($currentproductDetail->productCity) && !empty($currentproductDetail->productCountryId)) $comma = ',&nbsp;&nbsp;';
					 
					 echo @$currentproductDetail->productCity; echo (@$currentproductDetail->productCountryId)? $comma.getCountry(@$currentproductDetail->productCountryId):'';
					 ?>
					 </span>
					 <div class="clear"></div>	 
                 </div>
                <?php } ?>
                 <div class="summery_posted_wrapper bdr_T666666"><span class="cell width220px  pl16"><?php echo getLanguage(@$currentproductDetail->productLang);?></span> 
                 <div class="clear"></div>	 
                 </div>
              
                 <?php if(@$currentproductDetail->productIndustryId>0){ ?>
                 <div class="summery_posted_wrapper bdr_T666666"><span class="cell width220px  pl16"><?php echo getIndustry(@$currentproductDetail->productIndustryId);?></span>                  
                 <div class="clear"></div>	 
                 </div>
                 <?php } 
                 
				 if(!empty($currentproductDetail->productwillingToPay) && (@$currentproductDetail->catId==2)){ ?>
                 <div class="summery_posted_wrapper bdr_T666666"><span class="cell width_100  pl16"><?php echo @$this->lang->line('indicativePrice');?></span> <span class="cell pl16"><?php echo @$currentproductDetail->productwillingToPay;?></span> 
                 <div class="clear"></div>	 
                 </div>
                 <?php } ?>
              
              </div>
              <div class="seprator_10 bdr_T666666 clear"></div>
              
<div class="EM_view_crave_box pl15 pt5 pb5">	
	<div class="cell width_80 height_27 pl36 icon_crave4_blog crave craveDiv<?php echo $productEntityId.''.$defaultproductId?> <?php echo $cravedALL;?>"><?php echo $this->lang->line('craves').'&nbsp;'.$craveCount;?></div>
	<div class="cell"><div class="icon_view3_blog float_none height_27 pl36"> <?php echo $this->lang->line('project_views').'&nbsp;'.$viewCount;?></div></div>
	<div class="clear"></div>
</div>
	 
<?php if(!empty($applyButton)) { ?>
<?php $this->load->view('product_offer_view',array('title'=>@$currentproductDetail->productTitle,'isWorkProfile'=>$workProfileId,'productId'=>$currentproductDetail->productId,'ownerId'=>$currentproductDetail->tdsUid,'btnLabel'=>$applyButton));?>		  

<?php } 
      
      //if current Price is greater then zero
      if(@$currentproductDetail->productPrice>0) $priceFlag='t';  else $priceFlag='f';
	 
	  //qunatityFlag will be true if we want to display button according to Quanitty present default it is false
	  $qunatityFlag='t';
	 
	  //shippingFlag will be true if we want to display button according to shippingFlag present default it is false
	  $shippingFlag = 't';
	  
	  //Array is passed to give property of price button to get shown on the basisi of those
      $buttonProperty = array(
		  'price'=>@$currentproductDetail->productPrice,
		  'priceFlag'=>$priceFlag,
		  'quantity'=>@$currentproductDetail->productQuantity,
		  'elementId'=>$currentproductDetail->productId,
		  'projId'=>$currentproductDetail->productId,
		  'sectionId'=>$sectionId,
		  'entityId'=>$productEntityId,
		  'shippingFlag'=>$shippingFlag,
		  'qunatityFlag'=>$qunatityFlag,
		  'seller_currency'=>$seller_currency,
		  'tdsUid'=>$userId,
		  'buttonClass'=>'position_relative hiddenspace fr pt15',
		  'buttonStyle'=>'big'
      );
      // showPriceButton($buttonProperty);
      
      //product Bid button start here
	if(@$currentproductDetail->catId==1 && $currentproductDetail->productSellType==2) {
		//Get projects Auction data
		$where = array('projectId'=>$currentproductDetail->productId,'entityId'=>$productEntityId,'elementId'=>$currentproductDetail->productId,'isAuctionClosed'=>'f');
		$auctionRes = getDataFromTabel('Auction','*',  $where, '','', '', 1 ); 
		if(is_array($auctionRes) && count($auctionRes)>0) {
			//Get Users bid if exists
			$userBidRes = $this->model_common->getDataFromTabel('AuctionBids', 'bidId,price',  array('auctionId'=>$auctionRes[0]->auctionId,'userId'=>$loggedUserId),'','','','');
			//Set user bid params
			$bidId = (isset($userBidRes[0]->bidId) && $userBidRes[0]->bidId !='') ?$userBidRes[0]->bidId : 0 ;
			$bidPrice = (isset($userBidRes[0]->price) && $userBidRes[0]->price !='') ?$userBidRes[0]->price : 0 ;
			
			//Load bid button
			$this->load->view('auction/bidPriceButton',array('title'=>$currentproductDetail->productTitle,'auctionId'=>$auctionRes[0]->auctionId,'minimumBidPrice'=>$auctionRes[0]->minBidPrice,'tdsUid'=>$currentproductDetail->tdsUid,'section'=>'product','auctioEndDate'=>$auctionRes[0]->endDate,'bidId'=>$bidId,'bidPrice'=>$bidPrice,'currencySign'=>$currencySign));	
		}
	} 	//product Bid button end here	
	else {
		//load product price button
		$productButton = Modules::run("common/showPriceButton",$buttonProperty);
		echo @$productButton['view'];
	}
      
	 ?>
                 <div class="clear"></div>
            </div>
          </div>
         <?php /*
         <!-- PRODUCT PRICES GOES HERE -->
          <div class="seprator_8"></div>
          <?php if(@$currentproductDetail->productPrice>0) { 
			  $priceDetails=getDisplayPrice($currentproductDetail->productPrice,$seller_currency);
			?>       
          <div class="scroll_box darkGrey_bg pt15 bdr_d2d2d2">
			 <?php if(@$currentproductDetail->productPrice>0){
				  if(@$currentproductDetail->productDownloadPrice>0)
				  $adjustProClass="Fleft";
				  else
				  $adjustProClass="margin_auto";
			 ?>
            <div class="position_relative hiddenspace <?php echo $adjustProClass;?>">
              <div class="huge_btn Price_btn_style">Price <br>
                <?php echo $priceDetails['currencySign'].' '.$priceDetails['displayPrice']?>
               </div>
              <?php $this->load->view('shipping/shipping_frontend_view',array('elementId'=>$currentproductDetail->productId,'entityId'=>$productEntityId));?>
            </div> 
            <?php } ?>       
            <div class="clear"></div>  
          </div>
          <?php } ?>
          * */ ?>
          <!--Extract box-->
          <div class="seprator_25"></div>
			<?php 		   
			   //LOAD RELATED product VIDEO
			   echo $this->load->view('promo_video');
		  ?>
		  <div class="seprator_25"></div>
		   <?php 		
			 		
			   $tableInfo = array(
								'entityId'=>$productEntityId,
								'elementId'=>@$defaultproductId,
								'tableName'=>array('AddInfoNews','AddInfoReviews'),
								'sections'=>array($this->lang->line('NEWS'),$this->lang->line('externalReviews')),
								'orderBy'=>array('news','review'),
								'sectionBgcolor'=>'darkGrey_bg',
						);
		
			   echo Modules::run("additionalInfo/additionalInfoList", $tableInfo);				
			   //LOAD ALL product DETAIL
			   echo $this->load->view('all_products');		   
		 ?>
		<div class="clear seprator_20"></div>			  
		
		<!-- Div for 250x250 advert display-->
		 <div class="ad_box_shadow width250px mb20" id="advert250_250"><?php 
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
			<?php if(strcmp($currentMethod,'viewproject')==0){ ?>
			
			<td class="advert_column" valign="top"> 		
				<div class="cell  sub_col_3">
					<!-- Div for 160x600 advert display -->
					<div class="ad_box ml11 mt10 mb10" id="advert160_600"><?php 
						if(is_dir(APPPATH.'modules/advertising') && !empty($advertSectionId)){
							//Manage right side advert
							$bannerRhsData =  Modules::run("advertising/getAdvertRecords", array('sectionId'=>$advertSectionId,'advertType'=>'2'));
							if(!empty($bannerRhsData)) {
								$this->load->view('common/advert',array('bannerData'=>$bannerRhsData,'advertType'=>'2','sectionId'=>$advertSectionId)); 
							} else {
								$this->load->view('common/adv_rhs');
							} 
						} else {
							$this->load->view('common/adv_rhs');
						}?>
					</div>
					<div class="clear"></div>
				</div>
			</td>
			<?php 
			}	
		}
		else {
		redirectToNorecord404();
		}
		?>
        <!--cell_width_284-->
      
 </td>	
<?php 
	if(is_dir(APPPATH.'modules/advertising') && !empty($advertSectionId)){
		//manage auto advert params and js methods
		echo $advertChangeView;
	}
?>        
<script type="text/javascript">
/*tab function*/
	$(document).ready(function(){
			$('#slider1').tinycarousel({ axis: 'y', display: 4, groupStep:1});	
						
			$('#slider5').tinycarousel({ axis: 'y', display: 3});
	
    });
</script>
