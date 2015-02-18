<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 
// echo "<pre>";
//print_r($project);
//echo "ERAT---------".$element['ratingAvg'];
$countElements=@count(@$elementsCollection);
if($elementsCollection && is_array($elementsCollection) && ($countElements > 0)){
	$methodName=$this->router->fetch_method();
	$imagetype=$fileConfig['defaultImage'];
	$projSellstatus=$project['projSellstatus']=='t'?true:false;
	$elementEntityId=getMasterTableRecord($elemetTable);
	foreach($elementsCollection as $key=>$element)
	{		
		if($element['elementId']==$elementId)
		{			
			$dirSize = bytestoMB($element['fileSize']);
			/******Set variable for showing swf player start******/
			
			$mediaId=$element['fileId'];  // media file Id
			$elementID=$element['elementId']; //element id
			$projectID=$element['projId']; // project id
			
			/******Set variable for showing swf player start******/
			
			$previeLink = 'media/'.$constant['project_preview'].'/'.$project['projectid'];
		
			if($industryType == 'photographyNart')
			{
				$thumbImage = addThumbFolder($element['filePath'].$element['fileName'],'_m');
				$elementImage = getImage($thumbImage,$imagetype);
			}
			else
			{
				$thumbImage = addThumbFolder($element['imagePath'],'_m');
				$elementImage = getImage($thumbImage,$imagetype);
			}
			
			if($element['isExternal']=='t')
			{
				$fileDirPath='';
			}
			else
			{
				$fileDirPath=$element['filePath'].$element['fileName'];
			}
			
			$previousElementId=0;
			$nextElementId =0;
			
			if($key > 0)
			{
				$previousElementId =$elementsCollection[$key-1]['elementId'];
			}
			
			if($key < ($countElements-1))
			{
				$nextElementId =$elementsCollection[$key+1]['elementId'];
			}
			
			$price = isset($element['price'])?$element['price']:0;
			$downloadPrice = isset($element['downloadPrice'])?$element['downloadPrice']:0;
			$perViewPrice = isset($element['perViewPrice'])?$element['perViewPrice']:0;
			
			$LogSummarywhere=array(
				'entityId'=>$elementEntityId,
				'elementId'=>$element['elementId']
			);
			
			$resLogSummary = getDataFromTabel('LogSummary', 'craveCount,ratingAvg,viewCount',  $LogSummarywhere, '', $orderBy='', '', 1 );
			if($resLogSummary)
			{
				$resLogSummary = $resLogSummary[0];
				$craveCount = $resLogSummary->craveCount;
				$viewCount = $resLogSummary->viewCount;
				$ratingAvg = $resLogSummary->ratingAvg;
			}
			else
			{
				$craveCount = 0;
				$viewCount = 0;
				$ratingAvg = 0;
			}
			
			$ratingAvg = roundRatingValue($ratingAvg);
			$ratingImg = 'images/rating/rating_0'.$ratingAvg.'.png';
			
			$cravedALL = '';
			$loggedUserId = isloginUser();
			if($loggedUserId > 0){
				$where = array(
								'tdsUid'=>$loggedUserId,
								'entityId'=>$elementEntityId,
								'elementId'=>$element['elementId']
						);							
				$countResult=countResult('LogCrave',$where);
				$cravedALL=($countResult>0)?'cravedALL':'';
			}
			else
			{
				$cravedALL='';
			}				
			break;
		}
	}	
?>
<div class="bg_Lgrey mr2">
	<div class="seprator_14"></div>
	<div class="wp_title_new_box global_shadow">
	  <div class="row">
		<div class="seprator_13"></div>
		<h1 class="heading04 text_alignC ml14 mr14"><?php echo $element['title'];?></h1>
		<div class="seprator_13"></div>
		<div class="Fleft ml30 wp_topimg_thumb w107_h160"> <div class="AI_table"><div class="AI_cell"><img border="0" class="max_w107_h160" src="<?php echo @$elementImage;?>"></div></div> </div>
		<!--liquid_box_wrapper-->
		<div class="cell summery_post2_description">
		  <div class="industry_type_wrapper font_opensansSBold pt0">
			  <?php 
			
			  if(($industryType=='news' || $industryType=='reviews')){ ?>
			   <div class="summery_posted_wrapper bdrt_f15921">				
				<span class="cell pl16 orange">
				 <?php 
				 $dateFormat = 'd F Y';
				 echo $releaseDate = get_timestamp($dateFormat,$element['createdDate']);
				 ?>
				 </span>
				 <div class="clear"></div>
			  </div>
			  
			  <?php /*
			   <div class="summery_posted_wrapper bdrt_f15921 ">
				  <span class="cell width125px pl16"><?php echo $producedInCountry = getSubString($project['countryName'],20);?></span>
				  <span class="cell  pl16"><?php echo $language = getSubString($project['Language_local'],20);?></span>
			  </div>
			  */ 
				
				$elementProjectType = $element['IndustryKey'];
				if($element['entityId']>0){
				$reviewGivenToUserId = getUserIdUsingGivenId($element['entityId'],$element['projectElementId']);
				$element['link']=getFrontEndLink($element['entityId'],$element['projectElementId']);
			}else	$element['link']='#';
					
			if($element['link']=='#') {$gotoRelatedLink = '';$gotoRelatedLinkClass='';}
			else {$gotoRelatedLink = 'onclick="gotourl(\''.$element['link'].'\',1);"'; $gotoRelatedLinkClass='ptr orange';}	
			?>
			
			  <div class="summery_posted_wrapper bdrt_f15921 <?php echo $gotoRelatedLinkClass;?>" <?php echo $gotoRelatedLink;?>> 
					<span class="cell pl16"><?php echo $element['articleSubject']; //echo $this->lang->line('Type');?></span>
					<div class="clear"></div>
			 </div>
			 <?php } 
			 
			 if(!($industryType=='news' || $industryType=='reviews')){ ?>
			  <div class="summery_posted_wrapper bdrt_f15921"> 
					<span class="cell width125px pl16"><?php echo $project['projectTypeName']; //echo $this->lang->line('Type');?></span>
					<?php 
						if(!empty($project['genre'])) { ?>
							<span class="cell  pl16"><?php echo $project['genre'];?></span> 
					<?php } ?>
					  <div class="clear"></div>
			 </div>
				
			<?php if(!empty($project['projGenreFree'])){ ?>
			  <div class="summery_posted_wrapper bdrt_f15921 heightAuto">	
			    <span class="cell pl16"><?php echo $project['projGenreFree'];?></span>	
			      <div class="clear"></div>		 
			  </div>
			 <?php } 
				}
			 ?>
			
			<div class="summery_posted_wrapper pt10 bdrt_f15921">
			  <div class="cell width_90 padding_left16 lineH27">
				<div class="icon_view3_blog"><?php echo $constant['project_views'].'&nbsp;'.$viewCount;?></div>
			  </div>
			  <div class="cell padding_left16 lineH27 ">
				<div class="icon_crave4_blog craveDiv<?php echo $elementEntityId.''.$element['elementId']?> <?php echo $cravedALL;?>"><?php echo $constant['project_craved'].'&nbsp;&nbsp;';?><span class="inline"><?php echo $craveCount;?></span></div>
			  </div>
			  
			   <div class=" cell padding_left16 pt10 rateDiv<?php echo $elementEntityId.''.$element['elementId']?>">			 
				<img  src="<?php echo base_url($ratingImg);?>" />
			   </div>
			  
			    <div class="clear"></div>
			</div>
			<?php
			
			if($industryType=='news') $pieceTitle = $this->lang->line('article');
			else if($industryType=='reviews') $pieceTitle = $this->lang->line('review');
			else $pieceTitle = $this->lang->line('piece');
				
			if(!($industryType=='news' || $industryType=='reviews')) {?>
				<div class="summery_posted_wrapper bdr_non">
					<div class="fr">
					<?php
					if(@$element['wordCount'] > 0){?> 
						<span class="cell pl16 font_opensansSBold clr_f1592a font_size11"><?php echo $element['wordCount'].'&nbsp;'.$this->lang->line('words');?></span>
						<?php
					}?>
					<span class="cell pl16 font_opensansSBold clr_f1592a font_size11"><?php echo $dirSize.'&nbsp;'.$this->lang->line('mb');?></span>
					</div>
					  <div class="clear"></div>
				</div>
				<?php		
			}?>
		  </div>
		  <!--industry_type_description-->
		</div>
		<!--summery_post_description-->
		<div class="clear"></div>
		<div class="seprator_24"></div>
	  </div>
	  <div class="clear"></div>
	</div>
	<div class="blogbottom_sheado"></div>  
	 
	<div class="clear"></div>
            <div class="seprator_10"></div>          
          <div class="mr10 ml10">
          <?php
				
	    //majorwork
		$majorwork = $this->config->item('majorwork');
	    //if($projSellstatus){ //Check if for sell or free
	
			//if this is major project then will pass the projectdetail to show the price button
					if(isset($project['projCategory']) && isset($majorwork[$project['projectType']]) && $project['projCategory']==$majorwork[$project['projectType']]){
					//buttons get loaded in any of the button condition is true else the section is not loaded at all
						$buttonElement = array('price'=>@$project['projPrice'],
						'isPrice'=>$project['isprojPrice'],
						'quantity'=>@$project['projQuantity'],
						'elementId'=>$project['projectId'],
						'downloadPrice'=>@$project['projDownloadPrice'],
						'isDownloadPrice'=>$project['isprojDownloadPrice'],
						'perViewPrice'=>@$project['projPpvPrice'],
						'isPerViewPrice'=>$project['isprojPpvPrice'],
						'default'=>$element['default'],
						'fileType'=>$element['fileType'],
						'fileName'=>$element['fileName'],
						'filePath'=>$element['filePath'],
						'mediaId'=>$element['fileId'],
						'mediaElementId'=>$element['elementId'],
						'mediaProjectId'=>$element['projId'],
						'entityId'=>$elementEntityId,
						'sectionId'=>$sectionId,
						'tdsUid'=>$element['tdsUid'],
						'isExternal'=>$element['isExternal'],
						'article'=>(isset($element['article'])&&$element['article']!='')?$element['article']:'',
						'title'=>(isset($element['title'])&&$element['title']!='')?$element['title']:'',
						'pieceTextClass'=>''
						);	
					}
					else
					{
					//buttons get loaded in any of the button condition is true else the section is not loaded at all
					$buttonElement = array('price'=>isset($element['price'])?$element['price']:0,
					'isPrice'=>isset($element['isPrice'])?$element['isPrice']:'f',
					'quantity'=>isset($element['quantity'])?$element['quantity']:0,
					'elementId'=>$project['projectId'],
					'downloadPrice'=>isset($element['downloadPrice'])?$element['downloadPrice']:0,
					'isDownloadPrice'=>isset($element['isDownloadPrice'])?$element['isDownloadPrice']:'f',
					'perViewPrice'=>isset($element['perViewPrice'])?$element['perViewPrice']:0,
					'isPerViewPrice'=>isset($element['isPerViewPrice'])?$element['isPerViewPrice']:'f',
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
					'article'=>(isset($element['article'])&&$element['article']!='')?$element['article']:'',
					'title'=>(isset($element['title'])&&$element['title']!='')?$element['title']:'',
					'pieceTextClass'=>'clr_white'
					);
				}
				
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
					if($downloadPrice_array[$j]=='f' && $isDownloadPrice_array[$j]=='t') //to check it there any element is present to get download, then the download button get shown on that basis
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
					if($downloadPrice_array[$j]=='f' && $isDownloadPrice_array[$j]=='t') //to check it there any element is present to get download, then the download button get shown on that basis
					{
						$isGlobalPPV = 't';
						break;
					}		   
				 }
				 		
				$show_price_buttons['globalProjDownloadable'] = $globalProjDownloadable; 
				$show_price_buttons['isGlobalDownload'] = $isGlobalDownload; 
				$show_price_buttons['isGlobalPPV'] = $isGlobalPPV; 
				$show_price_buttons['globalProjDownloadable'] = $globalProjDownloadable; 
				$show_price_buttons['pieceTitle']=$pieceTitle; 
				$show_price_buttons['buttonElement'] = $buttonElement; 
				$this->load->view('show_price_buttons',$show_price_buttons);
			
				?>
				
				<div class="clear"></div>
				</div>
				<div class="seprator_10"></div>         
            </div>    
	<!--box01-->
	  <div class="row sub_col_middle global_shadow_light FV_shade_above_title">
		<?php
			if(strlen(trim(@$element['description']))>2 || strlen(trim(@$show_price_buttons['buttonElement']['article']))>2){ ?>
				<div class="row padding_top18">
				  <?php
				  
				  	if(($industryType=='news' || $industryType=='reviews')) {
				  	   if($industryType=='reviews' ){
						   
						   if($element['isExternal']=='t' && $element['fileId'] > 0){
								echo changeToUrl(nl2br($element['description']));
							}else{
								echo changeToUrl(nl2br($show_price_buttons['buttonElement']['article']));
							}
						}else {
								echo changeToUrl(nl2br($element['description']));	
							}	
						} else {
							echo changeToUrl(nl2br($element['description'])); 
						} ?>
					 
				</div>
				<?php		
			}
		 ?>
		<div class="seprator_34"></div>
		<!--box01 sub04-->
		<div class="row font_opensans mb16">
			
		<div class="tds-button_rate cell Fright"> 
		  <?php $this->load->view('rating/ratingView',array('elementId'=>$element['elementId'],'entityId'=>$elementEntityId,'ratingAvg'=>$ratingAvg,'ratingClass'=>'width_auto ml5 Fleft','isPublished'=>$element['isPublished']));?>
		</div>	
			
		 <?php
			if(!($industryType=='news' || $industryType=='reviews')){
				$headingKeyPersonnel=$this->lang->line('mediaProductionTeam');
				$this->load->view('creativeinvolved/keypersonnel_frontend_view',array('elementId'=>$element['elementId'],'entityId'=>$elementEntityId,'heading'=>$headingKeyPersonnel));
					
			}
		   $this->load->view('craves/craveView',array('elementId'=>$element['elementId'],'entityId'=>$elementEntityId,'ownerId'=>$element['tdsUid'],'projectType'=>$industryType,'isPublished'=>$element['isPublished'],'furteherDetails'=>'{"projectId":"'.$projectId.'","table":"'.$elemetTable.'","primeryField":"elementId","fieldSet":"elementId as id, imagePath as craveImage, title as craveTitle, description as craveShortDescription, tags as tagwords","cacheFilePath":"'.$cacheFile.'"}'));
				if(!($industryType=='news' || $industryType=='reviews')){ ?>
				
					<div class="tds-button01 cell Fright"> 
					
					<?php $this->load->view('media/reviewView',array('elementId'=>$element['elementId'],'projectId'=>$project['projectid'],'entityId'=>$elementEntityId,'projName'=>$element['title'],'section' =>'Writing & Publishingo','industryId' =>'3','isPublished'=>$element['isPublished']));	?>
					
                   </div>					
                   
				<?php		
				}
			  ?>
		  <div class="clear"></div>
		</div>
		<!--box01 sub05-->
		<?php
		$btn=$countElements<=1?'btn':'';
		$lastmethod = ($method!='viewelement')? $method:'viewelement';
		
		if($industryType =="educationMaterial") {						
			$lastLink = 'lesson';
		} else if($industryType =="photographyNart"){
			$lastLink = 'image';
		} else {
			$lastLink = 'piece';
		} ?>
<div class="row pagination02 font_opensans <?php echo $btn?>">			

 <?php if($lastmethod=='writingpublishing')
	       $newsReviewSectionBg='';
			
	//	if ( ($industryType=='news') || ($industryType=='reviews') )
		//{
		  if($lastmethod!='viewelement')
		  {		
				  if($lastmethod!='writingpublishing')
				  {
						if($previousElementId){?>
							<a href="<?php echo base_url(lang().$urlUsername.'/mediafrontend/'.$methodName.'/'.$userId.'/'.$projectId.'/'.$previousElementId.'/'.$lastmethod.'/'.$newsReviewSectionBg.'/'.$lastLink);?>" class="cell pre_arrow dash_link_hover"><?php echo $constant['previousELink'];?></a> 
							<?php
						 }
						if($nextElementId){ ?>
							<a href="<?php echo base_url(lang().$urlUsername.'/mediafrontend/'.$methodName.'/'.$userId.'/'.$projectId.'/'.$nextElementId.'/'.$lastmethod.'/'.$newsReviewSectionBg.'/'.$lastLink);?>" class="cell Fright next_arrow dash_link_hover"><?php echo $constant['nexEtLink'];?></a>
							<?php
						 }
						 
					}
					  else if($lastmethod=='writingpublishing')
					  {
							  
						if($previousElementId){?>
							<a href="<?php echo base_url(lang().$urlUsername.'/mediafrontend/'.$methodName.'/'.$userId.'/'.$projectId.'/'.$previousElementId.'/'.$lastmethod.'/'.$lastLink);?>" class="cell pre_arrow dash_link_hover"><?php echo $constant['previousELink'];?></a> 
						  <?php }
						  
						if($nextElementId){ ?>
							<a href="<?php echo base_url(lang().$urlUsername.'/mediafrontend/'.$methodName.'/'.$userId.'/'.$projectId.'/'.$nextElementId.'/'.$lastmethod.'/'.$lastLink);?>" class="cell Fright next_arrow dash_link_hover"><?php echo $constant['nexEtLink'];?></a>
						 <?php  }							  							  
							  
					 }		 	
			
			 } else {				 
				 
				 if($previousElementId){ ?>
				  <a href="<?php echo base_url(lang().$urlUsername.'/mediafrontend/'.$methodName.'/'.$userId.'/'.$projectId.'/'.$previousElementId.'/'.$lastmethod.'/');?>" class="cell pre_arrow dash_link_hover"><?php echo $constant['previousELink'];?></a> 
				<?php  }				
				if($nextElementId){ ?>
					<a href="<?php echo base_url(lang().$urlUsername.'/mediafrontend/'.$methodName.'/'.$userId.'/'.$projectId.'/'.$nextElementId.'/'.$lastmethod.'/');?>" class="cell Fright next_arrow dash_link_hover"><?php echo $constant['nexEtLink'];?></a>
				 <?php }
						 
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
		  		                  
          <?php if(!empty($element['productionCompany'])) { ?>   
			  <div class="row fr">
				 <div class="cell font_size11 pl16"><?php echo $constant['publisher'];?>				
				 <div class="cell padding_left10 font_size11  font_opensansSBold Fright">
					 <?php echo $element['productionCompany'];?>
				 </div>
				</div>
			 </div>
		 <?php } ?>
		     
		  <div class="clear"></div>
		</div>
	  </div>
	  <!--ads-->
	  <div class="row width470px ma mt20" id="advert468_60"> <?php 
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
	<?php
}else{
	?>
		<div class="mt20 b black pl20 pr20"><?php echo $this->lang->line('noRecordFound');?></div>
	<?php
}
?>
<?php echo Modules::run("mediafrontend/getReviewList",$elementEntityId,$element['elementId'],$craveCount,$element['viewCount']); ?>	
