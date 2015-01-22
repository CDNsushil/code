<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 
//echo "<pre>";
//print_r($elementsCollection); fileLength
$lastline = '';
$countElements=@count(@$elementsCollection);
if($elementsCollection && is_array($elementsCollection) && ($countElements > 0)){
	$methodName=$this->router->fetch_method();
	$imagetype=$fileConfig['defaultImage'];
	$projSellstatus=$project['projSellstatus']=='t'?true:false;
	$elementEntityId=getMasterTableRecord($elemetTable);
	foreach($elementsCollection as $key=>$element){
		//echo '<pre />elemtn here';print_r($element);
		
		if($element['elementId']==$elementId){
			
			
			/********Here assign media show code start**********/
			
			$mediImagePath=$element['imagePath'];
			$mediaId= $element['fileId'];  // media file Id
			$elementId=$element['elementId']; //element id
			$projectId=$element['projId']; // project id
			$mediaArray['width']='270'; // width
			$mediaArray['height']='27'; // height
			$elementImagePath=$element['imagePath']; 
			/********Here assign media show code start**********/
			
			$dirSize=bytestoMB($element['fileSize']);
			
			$previeLink='media/'.$constant['project_preview'].'/'.$project['projectid'];
			
			if($industryType=='photographyNart')
			{
				if($element['isExternal']=='t')
				{
					$elementImage=trim($element['filePath']);
				}
				else
				{
					$thumbImage = addThumbFolder($element['filePath'].$element['fileName'],'_b');
					$elementImage = getImage($thumbImage,$imagetype);
				}
			}else
			{				
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
	} ?>
	
		<!--box01-->
		 <div class="row width_451 sub_col_middle global_shadow_light">
            <!--box01 sub01-->
            <div class="bolggradierbg minH294 bdr_ccc pb20">
            <div class="row">
              <!--liquid_box_wrapper-->
              
              <!---<div class="audio_player_shadow"><img width="451" src="<?php echo base_url();?>images/demo_audio_player.png"></div>--->
              
              <div class="audio_player_shadow">
                
              	<div class="audioplayersbg">
					<div class="playerimg_container">
						<div class="AI_table">
						<div class="AI_cell">
							<?php
							$mediImagePath;
							$geMediaImage=addThumbFolder($mediImagePath,$suffix='_s',$thumbFolder ='thumb',$defaultThumb='images/default_thumb/music_audio_s.jpg');
							$geMediaImage=getImage($geMediaImage);
							?>
							 <img src="<?php echo $geMediaImage; ?>" alt="img" class="max_h126_w126">
						</div>
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
						$elementImage = $elementImagePath;	
						$imagetype=$this->config->item('musicNaudioImage_m');
						$thumbImage = addThumbFolder($elementImage,'_m');
						$elementImage = getImage($thumbImage,$imagetype);
						?>
							<div class="mainplayerembedbg Fright mr9 mt22 AI_cell">
								<p class="tac f16 pb5 white"><?php echo $this->lang->line('This_work_is_hosted_on_another_site'); ?> <a class="white underline hoverOrange" target="_blank" href="<?php echo $getSrc; ?>"><?php echo $this->lang->line('Click_here_to_view_the_url'); ?></a></p>
								<img src="<?php echo $elementImage; ?>"  class="max_w84_h84"/>	
							</div>	
						<?php  } ?>
					</div>
					
              </div>
              
              <!--summery_post_description-->
            </div>
            <div class="row">
              <!--liquid_box_wrapper-->
              <div class="cell pl10 pt10 pr10 pb15">
                <h1 class="heading04"><?php echo $element['title'];?></h1>
                <!--industry_type_description-->
              </div>
              <!--summery_post_description-->
              <div class="clear"></div>
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
				  <div class="summery_posted_wrapper bdrt_f15921 heightAuto">	
					  <?php if(!empty($project['projGenreFree'])){?>				 
						<span class="cell pl16"><?php echo $project['projGenreFree'];//echo getSubString($project['projGenreFree'],30);?></span>			 				  
					  <?php $lastline = '<div class="bdrt_f15921"></div>'; } ?>
					    <div class="clear"></div>
				  </div>
				  <div class="clear"></div>
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
               <div class="pl41 font_opensansSBold clr_f1592a font_size11"><?php  if(isset($element['fileLength']) && $element['fileLength']!='00:00:00') echo $element['fileLength'];?><span class="display_inline  pl15"><?php echo $dirSize.'&nbsp;'.$this->lang->line('mb');?></span></div>
                
              </div>
               <div class="clear"></div>   	
            
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
				
				//buttons get loaded in any of the button condition is true else the section is not loaded at all
				$buttonElement = array('price'=>@$element['price'],
				'isPrice'=>$element['isPrice'],
				'quantity'=>$element['quantity'],
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
				$show_price_buttons['pieceTitle']=$this->lang->line('piece'); 
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
				 ?>
              
              <?php $this->load->view('craves/craveView',array('elementId'=>$element['elementId'],'entityId'=>$elementEntityId,'ownerId'=>$element['tdsUid'],'projectType'=>$industryType,'isPublished'=>$element['isPublished'],'furteherDetails'=>'{"projectId":"'.$projectId.'","table":"'.$elemetTable.'","primeryField":"elementId","fieldSet":"elementId as id, imagePath as craveImage, title as craveTitle, description as craveShortDescription, tags as tagwords","cacheFilePath":"'.$cacheFile.'"}'));?>
			  <?php
				if(!($industryType=='news' || $industryType=='reviews')){?>
				
					<div class="tds-button01 cell Fright"> 
					
					<?php $this->load->view('media/reviewView',array('elementId'=>$element['elementId'],'projectId'=>$project['projectid'],'entityId'=>$elementEntityId,'projName'=>$element['title'],'section' =>'Music & Audio','industryId' =>'2','isPublished'=>$element['isPublished']));	?>
					
                   </div>					
					
				<?php		
				}
			  ?>
              <div class="clear"></div>
            </div>
            <!--box01 sub05-->
           <?php
		$btn=$countElements<=1?'btn':'';
		$lastmethod = ($method!='viewelement')?'musicaudio':'viewelement';
		$lastLink = '';
		if($method!='viewelement')
		     $lastLink = 'piece';
		
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
			<div class="fr font_size11 padding_left10 font_opensansSBold pt5"><?php echo $project['projRating'];?></div>		  		 

			<?php if(!empty($element['productionCompany'])) { ?>
			 <div class="row fr">
				 <div class="cell font_size11 pl16"><?php echo $constant['productioNcompany'];?>
				<div class="cell padding_left10 font_size11  font_opensansSBold Fright"><?php echo $element['productionCompany'];?></div>
			</div>
			</div>
			<?php } ?>	

			<div class="clear"></div>			              
            </div>
          </div>
	  <div class="row mt18"><?php $this->load->view('common/adv_content_bot'); ?></div>
	<?php
}else{
	?>
		<div class="mt20 b black pl20 pr20"><?php echo $this->lang->line('noRecordFound');?></div>
	<?php
}
?>
<?php echo Modules::run("mediafrontend/getReviewList",$elementEntityId,$element['elementId'],$craveCount,$element['viewCount']);
// call player for playing audio clip
echo Modules::run("player/commonAudioPlayer");
 ?>	
