<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 
//echo "<pre>";
//print_r($elementsCollection);
$thumbFolder='thumb';
$countElements=@count(@$elementsCollection);
if($elementsCollection && is_array($elementsCollection) && ($countElements > 0)){
	$methodName=$this->router->fetch_method();
	$imagetype=$fileConfig['defaultImage'];
	$projSellstatus=$project['projSellstatus']=='t'?true:false;
	$elementEntityId=getMasterTableRecord($elemetTable);
	foreach($elementsCollection as $key=>$element){
		if($element['elementId']==$elementId){
			
			$dirSize=bytestoMB($element['fileSize']);
			
			$previeLink='media/'.$constant['project_preview'].'/'.$project['projectid'];
			
			if($industryType=='photographyNart'){
				if($element['isExternal']=='t')
				{
					$elementImage=checkExternalImage($element['filePath'],'_b');
				}
				else
				{
					if($projSellstatus){
						$thumbFolder='watermark';
					}
					$thumbImage = addThumbFolder($element['filePath'].$element['fileName'],'_b',$thumbFolder);
					$elementImage=getImage($thumbImage,$imagetype);
				}
			}else{
				$elementImage=getImage($element['imagePath'],$imagetype);
			}
			
			if($element['isExternal']=='t'){
				$fileDirPath='';
			}else{
				$fileDirPath=$element['filePath'].$element['fileName'];
			}
			
			$previousElementId=0;
			$nextElementId =0;
			if($key > 0){
				$previousElementId =$elementsCollection[$key-1]['elementId'];
			}
			if($key < ($countElements-1)){
				$nextElementId =$elementsCollection[$key+1]['elementId'];
			}
			
			$price = isset($element['price'])?$element['price']:0;
			$downloadPrice = isset($element['downloadPrice'])?$element['downloadPrice']:0;
			$perViewPrice = isset($element['perViewPrice'])?$element['perViewPrice']:0;
			
			
			$LogSummarywhere=array(
					'entityId'=>$elementEntityId,
					'elementId'=>$element['elementId']
			);
			
			$resLogSummary=getDataFromTabel('LogSummary', 'craveCount,ratingAvg,viewCount',  $LogSummarywhere, '', $orderBy='', '', 1 );
			if($resLogSummary){
				$resLogSummary=$resLogSummary[0];
				$craveCount=$resLogSummary->craveCount;
				$viewCount = $resLogSummary->viewCount;
				$ratingAvg=$resLogSummary->ratingAvg;
			}else{
				$craveCount=0;
				$viewCount =0;
				$ratingAvg=0;
			}
			
			$ratingAvg=roundRatingValue($ratingAvg);
			$ratingImg='images/rating/rating_0'.$ratingAvg.'.png';
			
			
			$cravedALL='';
			$loggedUserId=isloginUser();
			if($loggedUserId > 0){
				$where=array(
								'tdsUid'=>$loggedUserId,
								'entityId'=>$elementEntityId,
								'elementId'=>$element['elementId']
							);
				$countResult=countResult('LogCrave',$where);
				$cravedALL=($countResult>0)?'cravedALL':'';
			}else{
				$cravedALL='';
			}
			
						
			
			break;
		}
	} 
	//echo "<pre>";
	//print_r($element); die;
	
	$lastline = '';
	?>
	
		<!--box01-->
<div class="row width_451 sub_col_middle global_shadow_light">
            <!--box01 sub01-->
            <div class="bolggradierbg minH294 bdr_ccc pb20">
				
				<div class="audio_player_shadow">
				  <div class="img_grey_bg">
					  <div class="seprator_30"></div>
					  <div class="PA_top_big_img bdr_grey10 ptr" onclick="loadPopupData('popupBoxWp','popup_box',popup_images);">
						  <div class="AI_table">
								<div class="AI_cell"><img class="max_w361_h240 bdr_cecece" src="<?php echo @$elementImage; ?>"></div>
						  </div>
					  </div>
					  <div class="PA_top_big_img_title text_alignC"> <?php echo string_decode($element['title']);?></div>
				  </div>
				</div>
		             
            <div class="">
              <div class="cell pl12 pr10 width_267">
                <div class="industry_type_wrapper font_opensansSBold ">
                   <div class="summery_posted_wrapper bdrt_f15921"> 
					<span class="cell width_90 pl16"><?php echo $project['projectTypeName']; //echo $this->lang->line('Type');?></span>
					<?php 
						if(!empty($project['genre'])){?>
							<span class="cell  pl16"><?php echo $project['genre'];?></span> 
					<?php } ?>
					<div class="clear"></div>
				  </div>
				  <div class="summery_posted_wrapper bdrt_f15921 ">	
					  <?php if(!empty($project['projGenreFree'])){?>				 
						<span class="cell pl16"><?php echo $project['projGenreFree'];//echo getSubString($project['projGenreFree'],30);?></span>
						 <div class="clear"></div>			 				  
					  <?php $lastline = '<div class="bdrt_f15921"></div>'; } ?>
				  </div>
				  <div class="clear"></div>
				  <?php echo $lastline;
							
					//$priceDetails=getDisplayPrice($price,$seller_currency);
					$downloadPriceDetails=getDisplayPrice($downloadPrice,$seller_currency);
					$ppvPriceDetails=getDisplayPrice($perViewPrice,$seller_currency);
					?>
				  <div class="clear"></div>
                </div>
                <!--industry_type_description-->
              </div>
               <div class="cell bdr_non">
                <div class="cell pl10 pt10 lineH27 width140px">
				  <div class="icon_crave4_blog craveDiv<?php echo $elementEntityId.''.$element['elementId']?> <?php echo $cravedALL;?>"><?php echo $constant['project_craved'].'&nbsp;&nbsp;';?><span class="inline"><?php echo $craveCount;?></span></div>
				  
                      <div class="cell pl5 pt10 rateDiv<?php echo $elementEntityId.''.$element['elementId']?>">			 
						   <img  src="<?php echo base_url($ratingImg);?>" />
					  </div>				  
                </div>                
                <div class="clear"></div>
                <div class="width_90 pl10 lineH27">
                  <div class="icon_view3_blog"><?php echo $constant['project_views'].'&nbsp;'.$viewCount;?></div>
                </div>
                <div class="clear"></div>
               
             </div>
             <div class="row mediaInfo"><?php 
               if((@$element['fileHeight']>0) && (@$element['fileHeight']>0)){
               echo @$element['fileHeight'].'&nbsp;x&nbsp;'.@$element['fileWidth'].'&nbsp'.substr(@$element['fileUnit'],0,2);
				}
               ?><span class="display_inline  pl15"><?php echo $dirSize.'&nbsp;'.$this->lang->line('mb');?></span></div>
               </div>
               <div class="clear"></div>   	
            
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
				//majorwork
				$majorwork = $this->config->item('majorwork');
			
				//echo '<pre />';print_r($project);
				
				//if($projSellstatus){//Check if for sell or free
							
					//if this is major project then will pass the projectdetail to show the price button
					//buttons get loaded in any of the button condition is true else the section is not loaded at all
						
						
						$buttonElement = array('price'=>@$element['price'],
						'isPrice'=>$element['isPrice'],
						'quantity'=>@$element['quantity'],
						'elementId'=>$project['projectId'],
						'downloadPrice'=>@$element['downloadPrice'],
						'isDownloadPrice'=>$element['isDownloadPrice'],
						'perViewPrice'=>@$element['perViewPrice'],
						'isPerViewPrice'=>$element['isPerViewPrice'],
						'default'=>$element['default'],
						'fileType'=>$element['fileType'],
						'fileName'=>$element['fileName'],
						'filePath'=>$element['filePath'],
						'mediaId'=>$element['fileId'],
						'mediaElementId'=>$element['elementId'],
						'mediaProjectId'=>$element['projId'],
						'tdsUid'=>$element['tdsUid'],
						'isExternal'=>$element['isExternal'],
						'entityId'=>$elementEntityId,
						'sectionId'=>$sectionId,
						'elementPresent'=>$elementPresent,
						'pieceTextClass'=>''
						);
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
				 	
				$show_price_buttons['globalProjDownloadable'] = $globalProjDownloadable; 
				$show_price_buttons['isGlobalDownload'] = $isGlobalDownload; 
				$show_price_buttons['isGlobalPPV'] = $isGlobalPPV; 	
				$show_price_buttons['globalProjDownloadable'] = $globalProjDownloadable; 
				$show_price_buttons['pieceTitle']=$this->lang->line('imageorpiece'); 	
				$show_price_buttons['buttonElement'] = $buttonElement;			 
				$this->load->view('show_price_buttons',$show_price_buttons);
				
            
              ?>
            </div>
            <div class="blogbottom_sheado"></div>  
            <?php
				if(strlen(trim(@$element['description']))>2){ ?>
						<div class="row pt18">
							<?php echo changeToUrl(nl2br($element['description']));?>
						</div>
					<?php		
				}
			 ?>
            <div class="seprator_20"></div>
            <!--box01 sub04-->
            <div class="row font_opensans mb16">
				
				<div class="tds-button_rate cell Fright"> 		
				   <?php $this->load->view('rating/ratingView',array('elementId'=>$element['elementId'],'entityId'=>$elementEntityId,'ratingAvg'=>$ratingAvg,'ratingClass'=>'width_auto ml5 Fleft','isPublished'=>$element['isPublished']));?>
				</div>
				
               <?php
					if(!($industryType=='news' || $industryType=='reviews')){
						$headingKeyPersonnel=$this->lang->line('mediaProductionTeam');
						$this->load->view('creativeinvolved/keypersonnel_frontend_view',array('elementId'=>$element['elementId'],'entityId'=>$elementEntityId,'heading'=>$headingKeyPersonnel));
						?>
					<?php		
					}
				 $this->load->view('craves/craveView',array('elementId'=>$element['elementId'],'entityId'=>$elementEntityId,'ownerId'=>$element['tdsUid'],'projectType'=>$industryType,'isPublished'=>$element['isPublished'],'furteherDetails'=>'{"projectId":"'.$projectId.'","table":"'.$elemetTable.'","primeryField":"elementId","fieldSet":"elementId as id, imagePath as craveImage, title as craveTitle, description as craveShortDescription, tags as tagwords","cacheFilePath":"'.$cacheFile.'"}'));
			  	 if(!($industryType=='news' || $industryType=='reviews')){ ?>									
					<div class="tds-button01 cell Fright"> 					
					<?php $this->load->view('media/reviewView',array('elementId'=>$element['elementId'],'projectId'=>$project['projectid'],'entityId'=>$elementEntityId,'projName'=>$element['title'],'section' =>'Photography & Art','industryId' =>'4','isPublished'=>$element['isPublished']));	?>					
                   </div>	
				<?php } ?>
              <div class="clear"></div>
            </div>
            <!--box01 sub05-->
           <?php
		$btn=$countElements<=1?'btn':'';
		$lastmethod = ($method!='viewelement')?'photographyart':'viewelement';
		$lastLink = '';
		if($method!='viewelement')
		     $lastLink = 'image';		
		?>
		<div class="row pagination02 font_opensans <?php echo $btn?>">
			<?php 
			if($previousElementId){?>
				<a href="<?php echo base_url(lang().$urlUsername.'/mediafrontend/'.$methodName.'/'.$userId.'/'.$projectId.'/'.$previousElementId.'/'.$lastmethod.'/'.$lastLink);?>" class="cell pre_arrow dash_link_hover"><?php echo $constant['previousELink'];?></a> 
				<?php
			}
			if($nextElementId){ ?>
				<a href="<?php echo base_url(lang().$urlUsername.'/mediafrontend/'.$methodName.'/'.$userId.'/'.$projectId.'/'.$nextElementId.'/'.$lastmethod.'/'.$lastLink);?>" class="cell Fright next_arrow dash_link_hover"><?php echo $constant['nexEtLink'];?></a>
				<?php
			}
			?>
		  <div class="clear"></div>
		</div>
		<!--box01 sub06-->
            <div class="row font_opensans mt15">
				<div class="fl blog_links_wrapper pt0">
					<?php	
						//$url = base_url().uri_string();
						$currentUrl = base_url().uri_string();
						$relation = array('getFrontShortLink', 'email','share','entityTitle'=> $element['title'], 'shareType'=>$constant['project_heading'], 'shareLink'=> $currentUrl,'id'=> $elemetTable.$element['elementId'],'entityId'=>$elementEntityId,'elementid'=>$element['elementId'],'projectType'=>$project['projectType'],'isPublished'=>$project['isPublished'],'viewType'=>'showcase');
						$this->load->view('common/relation_to_share',array('relation'=>$relation));
					?>							  
			   </div> 
				
			  <div class="clear"></div>
			  <div class="seprator_12"></div>  
		      <div class="fr font_size11 lh45 padding_left10 font_opensansSBold"><?php echo $project['projRating'];?></div>	
					<?php if(!empty($project['productionHouse'])) { ?>
					     <div class="row fr">
							<div class="cell font_size11 pl16"><?php echo $constant['gallery'];?>
								<div class="cell padding_left10 font_size11  font_opensansSBold Fright">
									<?php echo $project['productionHouse'];?>
								</div>
							</div>
						</div>
					<?php } ?>	              
             <div class="clear"></div>  
            </div>
          </div>
	  <!--<div class="row mt18"> <img class="" src="<?php //echo base_url();?>images/frontend/ads.png"/> </div>-->
	  <div class="row width470px ma mt20"><?php $this->load->view('common/adv_content_bot'); ?></div>
	<?php
}else{
	?>
		<div class="mt20 b black pl20 pr20"><?php echo $this->lang->line('noRecordFound');?></div>
	<?php
}
?>
<?php echo Modules::run("mediafrontend/getReviewList",$elementEntityId,$element['elementId'],$craveCount,$element['viewCount']); ?>	
