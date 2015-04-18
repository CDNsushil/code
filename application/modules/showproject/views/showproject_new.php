<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 
$spSection=$projectType;
$spSection=trim($spSection);
$module=$this->router->fetch_class();
$totalSP=count($showProjects);
$projectTypeSP=array();
$projectType='';
$creativeName='';
$spTypeDropDwon=array();
$spTypeDropDwon['']=$this->lang->line('all');


if($spDropDwon){
	foreach($spDropDwon as $key=>$dd){
		$spTypeDropDwon[$dd->section]=$this->lang->line($dd->section);
	}
}

foreach($showProjects as $key=>$sp){
	if(isset($showProjects[$key-1]) && (($showProjects[$key-1]->entityid==($showProjects[$key]->entityid)) && ($showProjects[$key-1]->elementid==($showProjects[$key]->elementid)) && ($showProjects[$key-1]->title==($showProjects[$key]->title))  ) ){
			continue;
	}
	
	if($projectType != $sp->section){
		$projectType=$sp->section;
	}
	$projectTypeSP[$projectType][]=$sp;
}

$id=0;
$spData=array();
$i=0;

$spTypeDropDwon=array();
$spTypeDropDwon['']=$this->lang->line('all');



foreach($projectTypeSP as $key=>$pt){
	
	$spTypeDropDwon[$key]=$this->lang->line($key);
	$imagetype=$this->config->item($key.'Image');
	
	
	
	foreach($pt as $k=>$sp){
		$section=$sp->section;
		if(empty($spSection) || $sp->section==$spSection){
			$projectTypeName=$spImage=$genreString=$length=$wordCount='';
			
			$projectId=$sp->projectid;
			$elementId=$sp->elementid;
			$entityId=$sp->entityid;
			$craveCount=$sp->craveCount;
			$dvdCount=$sp->dvdCount;
			$videoFileCount=$sp->videoFileCount;
			$ratingAvg=roundRatingValue($sp->ratingAvg);
			
			
			
			
			$spClass=(isset($sp->craveId) && ($sp->craveId > 0))?"admin_cravedALL":'';
			$spFClass=(isset($sp->craveId) && ($sp->craveId > 0))?"cravedALL":'';
			
			$cacheFile=$sp->cachefile;
			if(!empty($cacheFile) && is_file($cacheFile)){
				
				include($cacheFile);
				
				if(isset($ProjectData)){
					$fileData=json_decode($ProjectData, true);
				}
				
				if(isset($fileData) && $fileData && is_array($fileData) && count($fileData) > 0){
					
					if(isset($fileData['projects'][0])){
						$project=$fileData['projects'][0];
					}elseif(isset($fileData['projects'])){
						$project=$fileData['projects'];
					}elseif(isset($fileData[0])){
						$project=$fileData[0];
					}else{
						$project=$fileData;
					}
					
					$projectTypeName=isset($project['projectTypeName'])?$project['projectTypeName']:(isset($project['workType'])?$project['workType']:'');
					
					if($sp->section=='news' || $sp->section=='reviews'){
						$projectTypeName=isset($project['IndustryName'])?$project['IndustryName']:'';
					}
					
					if(($spSection=='photographyNart' && ($elementid != $projectid)) || $spSection=='performancesevents' || $spSection=='launch' || $spSection=='event' ||$spSection=='notification' || $spSection=='work' || $spSection=='product' || $spSection=='blog' ||$spSection=='post' || $spSection=='upcoming'){
					
						$fileName=trim($project['fileName']);
						$filePath=trim($project['filePath']);
						$fpLen=strlen($project['filePath']);
						if($fpLen > 0 && substr($filePath,-1) != '/'){
							$filePath=$filePath.'/';
						}
						$spImage=$filePath.$fileName;
					}
					elseif($spSection=='creatives' || $spSection=='associatedprofessionals'|| $spSection=='enterprises'){
						if(isset($project['stockImgId']) && $project['stockImgId'] > 0){
							$spImage=$project['stockImgPath'].'/'.$project['stockFilename'];					
						}
						else{
							$profileImagePath  = 'media/'.$project['username'].'/profile_image/';
							$spImage=$profileImagePath.$project['profileImageName'];	
						}
					}
					elseif(isset($project['projBaseImgPath']) && !empty($project['projBaseImgPath'])){
						$spImage=trim($project['projBaseImgPath']);
					}elseif(isset($project['imagePath']) && !empty($project['imagePath'])){
						$spImage=trim($project['imagePath']);
					}elseif(empty($spImage)){
						/*******make element image as project image code start******/
						$spImage = getElementImageByType($sp->projectid,$sp->section);
						/*******make element image as project image code end******/
						
					}
				}
			}
			
			if($spSection=='work'){
				$imagetype=$this->config->item($spSection.$sp->work_type.'Image');
			}
			
			elseif(!empty($section) && $section=='event') {
				$fileName = trim($project['fileName']);
				$filePath = trim($project['filePath']);
				//----------make element default event image code start---------//
				$eventImage = $filePath.$fileName;
				if(isset($eventImage) && !empty($eventImage) && file_exists($eventImage)) {
					$spImage = $eventImage;
				} else {
					$getProjectImage = getEventsPrimaryImage($project['EventId'],'.eventId');
					if(!empty($getProjectImage) && file_exists($getProjectImage)){
						$spImage = $getProjectImage;
					}else{
						$spImage = $eventImage;				
					}
				}
				//----------make element default event image code start---------//
			}
			elseif(!empty($section) && $section=='launch') {
				$fileName = trim($project['fileName']);
				$filePath = trim($project['filePath']);
				//----------make element default launch image code start---------//
				$launchImage = $filePath.$fileName;
				if(isset($launchImage) && !empty($launchImage) && file_exists($launchImage)) {
					$spImage = $launchImage;
				} else {
					$getProjectImage = getEventsPrimaryImage($project['LaunchEventId'],'.launchEventId');
					if(!empty($getProjectImage) && file_exists($getProjectImage)){
						$spImage = $getProjectImage;
					}else{
						$spImage = $launchImage;				
					}
				}
				//----------make element default launch image code start---------//
			}
			
			$sp->length=$length;
			$sp->wordCount=$wordCount;
			$sp->sell_option= ucfirst($sp->sell_option);
			
			$ratingImg='images/rating/rating_0'.$ratingAvg.'.png';
			$sp->ratingImg=$ratingImg;
			$sp->type=($sp->section=='news' || $sp->section=='reviews' || $sp->section=='educationMaterial' || $sp->section=='upcoming')?$sp->industry:$sp->type;
			
			/*if(((isset($project['isExternalImageURL']) && $project['isExternalImageURL']=='t') || ((isset($project['isExternal']) && $project['isExternal']=='t')) && (isset($project['filePath']) && $sp->section == 'photographyNart')) ){
				$spImage=trim($project['filePath']);
			}else{
				
				if($sp->section=="photographyNart"){
					$getElementEntityid =  getMasterTableRecord('PaElement');
					$getPojrectImage = getProjectElementImage($project['projId'],$getElementEntityid);	
					
						if(is_array($getPojrectImage)){
							if($getPojrectImage['isExternal']=="t"){
								$spImage = checkExternalImage($getPojrectImage['filePath'],'_s');
							}
						}else{
							if($getPojrectImage){
								$spImage = $getPojrectImage;
							}else{
								$spImage = addThumbFolder($project['projBaseImgPath'],'_s',$imagetype);				
							}
							$spImage = getImage($spImage,$imagetype,1);
						}
				}else{
					$spImage=addThumbFolder($spImage,$suffix='_s',$thumbFolder ='thumb',$defaultThumb=$imagetype);
					$spImage=getImage($spImage,$imagetype);
				}
			}*/
            
            //---------- if project image uploaded --------------// 
            $spImage               =   getProjectCoverImage($projectId,'_m');
			
			$sp->projectCategory='';
			if($sp->categoryid=='product_1'){
				$sp->projectCategory=$this->lang->line('forSale');
			}
			elseif($sp->categoryid=='product_2'){
				$sp->projectCategory=$this->lang->line('wanted');
			}
			elseif($sp->categoryid=='product_3'){
				$sp->projectCategory=$this->lang->line('free');
			}elseif($sp->categoryid=='product_3'){
				$sp->projectCategory=$this->lang->line('free');
			}
			
			$genreStringFlag=false;
			
			if(isset($sp->genre) && !empty($sp->genre)){
				$genreString.=$sp->genre;
				$genreStringFlag=true;
			}
			/*if(isset($sp->subgenre) && !empty($sp->subgenre)){
				if($genreStringFlag){
					$genreString.=',&nbsp;';
				}
				$genreString.=$sp->subgenre;
			}*/
			
			$sp->SPection=$spSection;
			$sp->spImage=$spImage;
			$sp->spClass=$spClass;
			$sp->spFClass=$spFClass;
			$sp->ratingAvg=$ratingAvg;
			$sp->ratingImg=$ratingImg;
			$sp->length=$length;
			$sp->wordCount=$wordCount;
			$sp->projectTypeName=$projectTypeName;
			$sp->genreString=$genreString;
			
			$spData[$i]=$sp;
			$i++;
			
		}
	}
}
?>
<div class="row content_wrap" >
 
   <div class="bg_f3f3f3 fl width100_per  title_head">
      <h1 class=" mb0 textin30 fl pl25">Other Collections</h1>
   </div>
   <div class="m_auto sc_list clearb pt30 pl30 pr30 pb30">
       
        <!--Collection list One-->
        <?php
         $spDataCount=count($spData);
        
         if($spData && is_array($spData) && $spDataCount > 0){
                    
                foreach($spData as $k=>$sp){
                    if($sp->section != 'work'){
                    switch ($sp->section) {
                        case 'filmNvideo':
                            $spBgClass='bg_SRFilm';
                            $sp->creative_area='';
                            $sp->element_type='';
                            $sp->projectCategory='';
                            $sp->wordCount='';
                            $sp->city='';
                            $sp->industry='';
                            $linkId=($sp->elementid == $sp->projectid)?$sp->userid.'/'.$sp->projectid.'/':$sp->userid.'/'.$sp->projectid.'/'.$sp->elementid.'/';
                            $sp->link=base_url(lang().'/mediafrontend/mediagallery/'.$linkId);
                            break;
                        case 'musicNaudio':
                            $spBgClass='bg_SRMusic';
                            $sp->creative_area='';
                            $sp->element_type='';
                            $sp->projectCategory='';
                            $sp->wordCount='';
                            $sp->city='';
                            $sp->industry='';
                            $linkId=($sp->elementid == $sp->projectid)?'aboutalbum/'.$sp->userid.'/'.$sp->projectid.'/':'tracklist/'.$sp->userid.'/'.$sp->projectid.'/'.$sp->elementid.'/';
                            $sp->link=base_url(lang().'/mediafrontend/'.$linkId);
                            break;
                        case 'photographyNart':
                            $spBgClass='bg_SRArt';
                            $sp->creative_area='';
                            $sp->element_type='';
                            $sp->projectCategory='';
                            $sp->wordCount='';
                            $sp->city='';
                            $sp->language='';
                            $sp->industry='';
                            $linkId=($sp->elementid == $sp->projectid)?$sp->userid.'/'.$sp->projectid.'/':$sp->userid.'/'.$sp->projectid.'/'.$sp->elementid.'/';
                            $sp->link=base_url(lang().'/mediafrontend/photoartgallery/'.$linkId);
                            break;
                        case 'writingNpublishing':
                            $spBgClass='bg_SRWriting';
                            $sp->creative_area='';
                            $sp->element_type='';
                            $sp->projectCategory='';
                            $sp->length='';
                            $sp->city='';
                            $sp->industry='';
                            $linkId=($sp->elementid == $sp->projectid)?$sp->userid.'/'.$sp->projectid.'/':$sp->userid.'/'.$sp->projectid.'/'.$sp->elementid.'/';
                            $sp->link=base_url(lang().'/mediafrontend/writinggallery/'.$linkId);
                            break;
                        case 'educationMaterial':
                            $spBgClass='bg_SREducational';
                            $sp->creative_area='';
                            $sp->element_type='';
                            $sp->projectCategory='';
                            $sp->length='';
                            $sp->wordCount='';
                            $sp->city='';
                            $sp->industry='';
                            $linkId=($sp->elementid == $sp->projectid)?$sp->userid.'/'.$sp->projectid.'/':$sp->userid.'/'.$sp->projectid.'/'.$sp->elementid.'/';
                            $sp->link=base_url(lang().'/mediafrontend/educationelement/'.$linkId);
                            break;
                        
                        case 'news':
                            $spBgClass='bg_SRNews';
                            $sp->creative_area='';
                            $sp->element_type='';
                            $sp->projectCategory='';
                            $sp->genreString='';
                            $sp->length='';
                            $sp->wordCount='';
                            $sp->city='';
                            $sp->projectTypeName='';
                            $sp->industry='';
                            $linkId=($sp->elementid == $sp->projectid)?'newscollection/'.$sp->userid.'/'.$sp->projectid.'/':'articledetails/'.$sp->userid.'/'.$sp->projectid.'/'.$sp->elementid.'/';
                            $sp->link=base_url(lang().'/mediafrontend/'.$linkId);
                            break;
                            
                        case 'reviews':
                            $spBgClass='bg_SRNews';
                            $sp->creative_area='';
                            $sp->element_type='';
                            $sp->projectCategory='';
                            $sp->genreString='';
                            $sp->length='';
                            $sp->wordCount='';
                            $sp->city='';
                            $sp->projectTypeName='';
                            $sp->industry='';
                            $linkId=($sp->elementid == $sp->projectid)?'reviewscollection/'.$sp->userid.'/'.$sp->projectid.'/':'reviewsdetails/'.$sp->userid.'/'.$sp->projectid.'/'.$sp->elementid.'/';
                            $sp->link=base_url(lang().'/mediafrontend/'.$linkId);
                            break;
                        case 'product':
                            $spBgClass='bg_SRProduct';
                            $sp->creative_area='';
                            $sp->element_type='';
                            $sp->genreString='';
                            $sp->length='';
                            $sp->wordCount='';
                            $sp->projectTypeName='';
                            $sp->industry='';
                            $linkId=($sp->elementid == $sp->projectid)?$sp->userid.'/'.$sp->projectid.'/':$sp->userid.'/'.$sp->projectid.'/'.$sp->elementid.'/';
                            $sp->link=base_url(lang().'/productshowcase/viewproject/'.$linkId);
                            break;
                        case 'blog':
                            $spBgClass='bg_SRBlogs';
                            $sp->creative_area='';
                            $sp->element_type='';
                            $sp->projectCategory='';
                            $sp->genreString='';
                            $sp->length='';
                            $sp->wordCount='';
                            $sp->city='';
                            $sp->projectTypeName='';
                            $sp->industry='';
                            $linkId=($sp->elementid == $sp->projectid)?$sp->userid.'/'.$sp->projectid.'/':$sp->userid.'/'.$sp->projectid.'/'.$sp->elementid.'/';
                            $sp->link=base_url(lang().'/blogs/frontpost/'.$linkId);
                            break;
                        case 'post':
                            $spBgClass='bg_SRBlogs';
                            $sp->creative_area='';
                            $sp->element_type='';
                            $sp->projectCategory='';
                            $sp->genreString='';
                            $sp->length='';
                            $sp->wordCount='';
                            $sp->city='';
                            $sp->projectTypeName='';
                            $sp->industry='';
                            $linkId=($sp->elementid == $sp->projectid)?$sp->userid.'/'.$sp->projectid.'/':$sp->userid.'/'.$sp->projectid.'/'.$sp->elementid.'/';
                            $sp->link=base_url(lang().'/blogs/frontpost/'.$linkId);
                            break;
                        case 'upcoming':
                            $spBgClass='bg_SRUpcoming';
                            $sp->creative_area='';
                            $sp->element_type='';
                            $sp->projectCategory='';
                            $sp->genreString='';
                            $sp->length='';
                            $sp->wordCount='';
                            $sp->city='';
                            $sp->projectTypeName='';
                            $linkId=$sp->userid.'/'.$sp->projectid;
                            $sp->link=base_url(lang().'/upcomingfrontend/viewproject/'.$linkId);
                            break;
                        case 'event':
                        case 'launch':
                        case 'performancesevents':
                            $spBgClass='bg_SREvent';
                            $sp->creative_area='';
                            $sp->projectCategory='';
                            $sp->genreString='';
                            $sp->length='';
                            $sp->wordCount='';
                            $sp->city='';
                            $sp->projectTypeName='';
                            $sp->industry='';
                            $linkId=$sp->userid.'/'.$sp->projectid;
                            $sp->link=base_url(lang().'/eventfrontend/events/'.$sp->element_type.'/'.$linkId);
                            break;
                        case 'creatives':
                            $spBgClass='bg_SRCreative';
                            $sp->element_type='';
                            $sp->projectCategory='';
                            $sp->genreString='';
                            $sp->length='';
                            $sp->wordCount='';
                            $sp->creation_date='';
                            $sp->city='';
                            $sp->projectTypeName='';
                            $sp->industry='';
                            $linkId=$sp->userid.'/';
                            $sp->link=base_url(lang().'/showcase/index/'.$linkId);
                            break;
                        case 'associatedprofessionals':
                            $spBgClass='bg_SRCreative';
                            $sp->element_type='';
                            $sp->projectCategory='';
                            $sp->genreString='';
                            $sp->length='';
                            $sp->wordCount='';
                            $sp->creation_date='';
                            $sp->city='';
                            $sp->projectTypeName='';
                            $sp->industry='';
                            $linkId=$sp->userid.'/';
                            $sp->link=base_url(lang().'/showcase/index/'.$linkId);
                            break;
                        case 'enterprises':
                            $spBgClass='bg_SRCreative';
                            $sp->element_type='';
                            $sp->projectCategory='';
                            $sp->genreString='';
                            $sp->length='';
                            $sp->wordCount='';
                            $sp->creation_date='';
                            $sp->city='';
                            $sp->projectTypeName='';
                            $sp->industry='';
                            $linkId=$sp->userid.'/';
                            $sp->link=base_url(lang().'/showcase/index/'.$linkId);
                            break;
                        default:
                            $spBgClass='bg_SRFilm';
                    }
                    
                    
                    ?> 
                    <a href="<?php echo $sp->link;?>">
                        <div class=" border_cacaca display_inline_block mb20">
                            <div class="collection_list_box fl ">
                            <span class="table_cell list_img position_relative zindex9" >
                            <img src="<?php echo $sp->spImage;?>" alt=""  /></span>
                            <div class="display_inline width_545 pt5 fr mb50">
                               <h4 class="fs16 font_bold pb14 lineH20"><?php echo getSubString($sp->title,30);?>
                               </h4>
                               <div class="fs12 lineH14">
                                   <?php echo getSubString($sp->online_desctiption,$desLength);?>
                                </div>
                               <div class="bb_fac8b8 pb18 mb15"></div>
                         
                            
                                <div class="pl10">	
                                     <?php if($sp->videoFileCount > 0){ ?>																
                                       <span>
                                       <b class="red pr7 "><?php echo $sp->videoFileCount; ?></b>
                                            <?php echo $this->lang->line($projectType.'_file'); ?>
                                       </span>
                                       <?php  if($sp->videoFileCount > 0 && $sp->dvdCount >0){?>
                                        <span class="pl10 pr10">|</span>
                                       <?php  } ?>
                                   <?php  } ?>
                                   <?php if($sp->dvdCount > 0){ ?>
                                    <span> <b class="red  pr7"><?php echo  $sp->dvdCount; ?></b><?php echo $this->lang->line($projectType.'_physical'); ?></span>
                                   <?php  } ?>
                                </div>
                    
                         
                            </div>
                            <div class="bg_f6f6f6 position_absolute width100_per lb0 pt10 pb9 zindex8 height_31">
                               <div class="width_545 pr18 fr">
                                  <div class="head_list fl pt5">
                                     <div class="icon_view3_blog icon_so"><?php echo $sp->viewCount;?></div>
                                     <div class="icon_crave4_blog icon_so  <?php echo $sp->spFClass?>"><?php echo $sp->craveCount;?></div>
                                     <div class="rating fl pt6">
                                        <img  src="<?php echo ratingImagePath($sp->ratingAvg);?>" />
                                     </div>
                                     <div class="btn_share_icon icon_so"><?php echo $sp->reviewCount;?></div>
                                  </div>
                               
                               </div>
                            </div>
                         </div>
                        </div>
                    </a>
            
            <?php
                    }
                }
            }
        ?>
      </div>
</div>
