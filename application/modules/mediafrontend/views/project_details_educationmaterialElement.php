<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 
//echo "<pre>";
//print_r($elementsCollection);
$lastline = '';
$countElements=@count(@$elementsCollection);
if($elementsCollection && is_array($elementsCollection) && ($countElements > 0)){
	$methodName=$this->router->fetch_method();
	$imagetype=$fileConfig['defaultImage'];
	$projSellstatus=$project['projSellstatus']=='t'?true:false;
	$elementEntityId=getMasterTableRecord($elemetTable);
	foreach($elementsCollection as $key=>$element){
		if($element['elementId']==$elementId){
			
			/******Set variable for showing swf player start******/
			$mediImagePath=$element['imagePath'];
			$mediaId=$element['fileId'];  // media file Id
			$elementID=$element['elementId']; //element id
			$projectID=$element['projId']; // project id
			
			/******Set variable for showing swf player start******/
			
			$dirSize=bytestoMB($element['fileSize']);
			
			$previeLink='media/'.$constant['project_preview'].'/'.$project['projectid'];
			
			if($industryType=='photographyNart'){
				
				$thumbImage = addThumbFolder($element['filePath'].$element['fileName'],'_b');
				$elementImage = getImage($thumbImage,$imagetype);
				
			}else{
				
				$thumbImage = addThumbFolder($element['imagePath'],'_b');
				$elementImage = getImage($thumbImage,$imagetype);
				
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
			
			$tempimage=($element['fileType']=='text' || $element['fileType']==4)?$elementImage:(($element['fileType']=='audio' || $element['fileType']==3)?base_url('images/audio_thumb_new.png'):base_url('images/FlowPlayer_2.png'));
			$seprater="";
			
			
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
				$viewCount = 0;
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

	?>
	  <div class="row width_451 sub_col_middle global_shadow_light">
		  
		  <div class="gradientforinfo_mora pr10 pl10 pb10 pt10 bdr_cecece bdr_Bnon">
        
			<div class="row pl16 pr16">             
              <div class="cell pt12 pb7 text_alignC bdrb_e6ac9a width400px">
                <h1 class="heading04"><?php echo $element['title'];?></h1>               
              </div>
              <div class="clear"></div>
            </div>
          <div class="seprator_13"></div>          
                    
          <div class="row">
			 <?php 
			 if(!($element['fileType']=='text' || $element['fileType']==4)){
				if(strcmp($element['fileType'],'audio visual')==0 || strcmp($element['fileType'],'video')==0 || strcmp($element['fileType'],'2')==0){ ?>
			  <div class="FV_top_big_video01">
				  <div class="AI_table">
					<div class="AI_cell">
						<?php 
							
							$mediaId=$element['fileId'];  // media file Id
							//$userId=$element['tdsUid']; // login user Id
							$elementId=$element['elementId']; //element id
							$projectId=$element['projId']; // project id
							$mediaArray['width']='426'; // width
							$mediaArray['height']='298'; // height
							
							//echo '<pre />';print_r($mediaArray);
							//echo Modules::run("player/getPlayer", $mediaArray);					
						?>
						
							  <?php
							/*************Here check exnternal and interter media**************/ 
							
								$tableName = getMasterTableName('42');
								
								$mediaTableName= $tableName[0];
										 
								//get media file type 
								$getType = getDataFromTabel('MediaFile','fileType,isExternal,filePath', 'fileId', $mediaId, 'fileId', 'ASC',1,0,true);
								
								if($getType[0]['isExternal']=="t")
								{
									//get external video src 
									$src =  getExternalMediaSrc($getType[0]['filePath'],$mediaId,$elementEntityId,$elementId,$projectId);
									$getSrc = $src[0];
									$isvalidUrl = ($src[1])?true:false;  
									   
									  
								}else
								{
									$getSrc = base_url().'en/player/getMainPlayerIframe/'.$mediaId.'_full/'.$elementEntityId.'/'.$elementId.'/'.$projectId;
									$isvalidUrl=true;
								}   
							if($isvalidUrl)	{ ?> 
								<iframe src="<?php echo $getSrc; ?>" width="426" height="298" frameborder="0"  webkitAllowFullScreen mozallowfullscreen allowFullScreen scrolling="no"></iframe>
							<?php } else { 
							$elementImage = $mediImagePath;	
							$imagetype=$this->config->item('filmNvideoImage_m');
							$thumbImage = addThumbFolder($elementImage,'_m');
							$elementImage = getImage($thumbImage,$imagetype); ?>	
									<p class="tac f16 pb5 white"><?php echo $this->lang->line('This_work_is_hosted_on_another_site'); ?> <a class="white underline hoverOrange" href="<?php echo $getSrc; ?>"><?php echo $this->lang->line('Click_here_to_view_the_url'); ?></a></p>
									<img src="<?php echo $elementImage; ?>"  class="max_w408_h305"/>
							<?php } ?>  
					</div>
				  </div>
			  </div>    
			 <?php }
			 else if(strcmp($element['fileType'],'audio')==0 || strcmp($element['fileType'],'3')==0){ ?>	
				<!---<div class="row">            
				  <div class="ml26"><img src="<?php echo base_url();?>images/playerbg1.png"></div>             
				</div>  --->
				
				<div class="audio_player_shadow width_449 ml-10">
               <div class="audioplayersbg">
				 <div class="playerimg_container">
					<div class="AI_table">
						<?php
						$mediaId=$element['fileId'];  // media file Id
						//$userId=$element['tdsUid']; // login user Id
						$elementId=$element['elementId']; //element id
						$projectId=$element['projId']; // project id
						$mediImagePath;
						$geMediaImage=addThumbFolder($mediImagePath,$suffix='_s',$thumbFolder ='thumb',$defaultThumb='images/default_thumb/music_audio_s.jpg');
						$geMediaImage=getImage($geMediaImage);
						?>
						<div class="AI_cell"> <img class="max_h126_w126"  src="<?php echo $geMediaImage; ?>"></div>
					 </div>
			    </div>
						<?php
							/*************Here check exnternal and interter media**************/ 
							
								$tableName = getMasterTableName('42');
								
								$mediaTableName= $tableName[0];
										 
								//get media file type 
								$getType = $this->model_common->getDataFromTabelWhereIn($mediaTableName, $field='fileType,isExternal,filePath',  $whereField='fileId', $whereValue=$mediaId, $orderBy='fileId', $order='ASC', $whereNotIn=0);
								if($getType[0]['isExternal']=="t")
								{
									//get external video src 
									$src =  getExternalMediaSrc($getType[0]['filePath'],$mediaId,$elementEntityId,$elementId,$projectId); 
									$getSrc = $src[0];
									$isvalidUrl = ($src[1])?true:false;
									  
								}else
								{
									$getSrc = base_url().'en/player/getMainPlayerIframe/'.$mediaId.'_full/'.$elementEntityId.'/'.$elementId.'/'.$projectId;
									$isvalidUrl=true;
								}   
							?> 
						
						<?php if($isvalidUrl) { ?>
							<div class="mainplayerembedbg Fright mr9 mt22">
								<iframe src="<?php echo $getSrc; ?>" width="279" height="128" frameborder="0"  webkitAllowFullScreen mozallowfullscreen allowFullScreen scrolling="no" <?php if(isset($class_player)) { echo $class_player;} ?>></iframe>
							</div>
						<?php } else { 
							$elementImage = $mediImagePath;	
							$imagetype=$this->config->item('musicNaudioImage_m');
							$thumbImage = addThumbFolder($elementImage,'_m');
							$elementImage = getImage($thumbImage,$imagetype); 	
						?>
							<div class="mainplayerembedbg Fright mr9 mt22 AI_cell">
								<p class="tac f16 pb5 white"><?php echo $this->lang->line('This_work_is_hosted_on_another_site'); ?> <a class="white underline hoverOrange"  href="<?php echo $getSrc; ?>"><?php echo $this->lang->line('Click_here_to_view_the_url'); ?></a></p>
								<img src="<?php echo $elementImage; ?>"  class="max_w84_h84"/>	
							</div>	
						<?php  } ?>
			    
			    
                </div>
                
              </div>
   
			 <?php } ?>
			 
			<div class="seprator_16"></div>
			<div class="info_moralight_gradient shedowdfor_lightbox pb18">
			  
              <div class="cell pl12 pr10 width_250">
                <div class="industry_type_wrapper font_opensansSBold pt25">
                  
                  <div class="summery_posted_wrapper bdrt_f15921 "> 
					<span class="cell width110px pl16"><?php echo $project['IndustryName']; //echo $this->lang->line('Type');?></span>
					<?php if(!empty($project['genre'])){ ?>
							<span class="cell  pl16"><?php echo $project['genre'];?></span> 
					<?php } ?>
					<div class="clear"></div>	 
				  </div>
				  <div class="summery_posted_wrapper bdrt_f15921 heightAuto">	
					  <?php if(!empty($project['projGenreFree'])){ ?>				 
						<span class="cell pl16"><?php echo $project['projGenreFree'];?></span>			 				  
						<div class="clear"></div>
					  <?php $lastline = '<div class="bdrt_f15921"></div>'; } ?>
				  </div>
				  <?php echo $lastline;?>
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
                <div class=" width_90 pl10 lineH27">
                  <div class="icon_view3_blog"><?php echo $constant['project_views'].'&nbsp;'.$viewCount;?></div>
                </div>
                <div class="clear"></div>
               <div class="pl40 font_opensansSBold clr_f1592a font_size11"><?php if(isset($element['fileLength']) && $element['fileLength']!='00:00:00') echo $element['fileLength'];?><span class="display_inline  pl10"><?php echo $dirSize.'&nbsp;'.$this->lang->line('mb');?></span></div>
                
              </div>
               <div class="clear"></div> 
              <?php 
             }
             else { //if file uploaded is of type TEXT ?> 
		          <div class="row">
          	<div class="cell EM_main_thumb width_206">
				<div class="AI_table"><div class="AI_cell"><img class="max_w206_h174" src="<?php echo $project['projectImage'];?>" ></div></div></div>
            <div class="cell width_206 ml15"> 
                	
				<div class="gradient_morawithper shedowdfor_lightbox pb10 bdr_white">
					<div class="font_opensansSBold">
					 
					  <div class="summery_posted_wrapper bdr_non heightAuto pt10">	
						<span class="cell pl16"><?php echo $project['IndustryName']; //echo $this->lang->line('Type');?></span>							
						<div class="clear"></div>	 
					  </div>
					  
					  <div class="summery_posted_wrapper bdrt_f15921 heightAuto">	
						<span class="cell pl16"><?php echo $project['Genre']; //echo $this->lang->line('Type');?></span>							
						<div class="clear"></div>	 
					  </div>
					  
					  <?php if(!empty($project['projGenreFree'])){ ?>
					  <div class="summery_posted_wrapper bdrt_f15921 heightAuto">	
						<span class="cell pl16"><?php echo $project['projGenreFree'];?></span>		
						<div class="clear"></div>	 
					  </div>
					 <?php  } ?>  
						<div class="summery_posted_wrapper height_42 bdrt_f15921">
						<div class="cell pl15 pt5 lineH27 height_auto width140px">
							<div class="icon_crave4_blog craveDiv<?php echo $elementEntityId.''.$project['projectId']?> <?php echo $project['cravedALL'];?>"><?php echo $constant['project_craved'].'&nbsp;&nbsp;';?><span class="inline"><?php echo $project['craveCount'];?></span></div>
							<div class=" cell pl5 pt10 rateDiv<?php echo $elementEntityId.''.$project['projectId']?>">			 
							   <img  src="<?php echo base_url($project['ratingImg']);?>" />
							</div>	
							
						</div>
						<div class="pl15  lineH27">
							<div class="icon_view3_blog"><?php echo $constant['project_views'].'&nbsp;'.$project['viewCount'];?></div>						
						</div>	
						<div class="clear"></div>
						</div>
					<div class="row pl20 pr5">
						<div class="fr fileinfo_len_size"><span><?php  if(isset($element['fileLength']) && $element['fileLength']!='00:00:00') echo $element['fileLength'].'&nbsp;';echo $project['dirSize'].'&nbsp;'.$this->lang->line('mb');?></span></div>
					</div>
			   </div><!-- End font_opensansSBold -->
			 <div class="clear"></div>				
			</div><!-- End EM_view_crave_box -->
            </div><!-- cell width_206 ml15 -->
          
          <?php }?>
             </div>
          <div class="clear"></div>
            <div class="seprator_10"></div>          
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
				//if($projSellstatus){//Check if for sell or free
								
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
				$show_price_buttons['pieceTitle']=$this->lang->line('lesson'); 
				$show_price_buttons['buttonElement'] = $buttonElement; 
				$show_price_buttons['globalProjDownloadable'] = $globalProjDownloadable; 
				$this->load->view('show_price_buttons',$show_price_buttons);
				
				?>
				<div class="clear"></div>
         
            </div>
               
            <div class="seprator_10"></div>
          </div>
	      <div class="audio_player_shadow"></div>
		 <?php
			if(strlen(trim(@$element['description']))>2){ ?>
				<div class="row padding_top18">
				  <?php echo changeToUrl(nl2br($element['description']));?>
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
		    
		  ?>
			
			<?php if(!($industryType=='news' || $industryType=='reviews')){ ?>					
				<div class="tds-button01 cell Fright"> 					
					<?php $this->load->view('media/reviewView',array('elementId'=>$element['elementId'],'projectId'=>$project['projectid'],'entityId'=>$elementEntityId,'projName'=>$element['title'],'section' =>'Educational Material','industryId' =>'10','isPublished'=>$element['isPublished']));	?>					
			   </div>					
			<?php } ?>
		  <div class="clear"></div>
		</div>
		<!--box01 sub05-->
		<?php
		$btn=$countElements<=1?'btn':'';
        $lastmethod = ($method!='viewelement')?'educationmaterial':'viewelement';		
		$lastLink = '';
		if($method!='viewelement') $lastLink = 'lesson';
				
		?>
		<div class="row pagination02 font_opensans <?php echo $btn?>">
			<?php if($previousElementId){ ?>
				<a href="<?php echo base_url(lang().$urlUsername.'/mediafrontend/'.$methodName.'/'.$userId.'/'.$projectId.'/'.$previousElementId.'/'.$lastmethod.'/'.$lastLink);?>" class="cell pre_arrow"><?php echo $constant['previousELink'];?></a> 
			<?php
			}
			if($nextElementId){ ?>
				<a href="<?php echo base_url(lang().$urlUsername.'/mediafrontend/'.$methodName.'/'.$userId.'/'.$projectId.'/'.$nextElementId.'/'.$lastmethod.'/'.$lastLink);?>" class="cell Fright next_arrow"><?php echo $constant['nexEtLink'];?></a>
			<?php }	?>
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
		  <div class="fr font_size11 padding_left10 font_opensansSBold "><?php echo $project['projRating'];?></div>		  		 
			  
			<?php if(!empty($project['productionHouse'])) { ?>
				 <div class="row fr">
					 <div class="cell font_size11 pl16"><?php echo $constant['publisher'];?>
					<div class="cell padding_left10 font_size11  font_opensansSBold Fright"><?php echo $project['productionHouse'];?></div>
				</div>
				</div>
			<?php } ?>	
		  
		  <div class="clear"></div>
		</div>
	  </div>
	  <!--ads-->
	  <div class="row mt18" id="advert468_60"><?php 
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
		}?></div>
	<?php
}else{
	?>
		<div class="mt20 b black pl20 pr20"><?php echo $this->lang->line('noRecordFound');?></div>
	<?php
}
?>
<?php echo Modules::run("mediafrontend/getReviewList",$elementEntityId,$element['elementId'],$craveCount,$element['viewCount']); ?>	
