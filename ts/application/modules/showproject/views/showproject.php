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
			
			if(((isset($project['isExternalImageURL']) && $project['isExternalImageURL']=='t') || ((isset($project['isExternal']) && $project['isExternal']=='t')) && (isset($project['filePath']) && $sp->section == 'photographyNart')) ){
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
			}
			
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
<td valign="top" class=" shade_white_body" >
	<div class="crave_page_top mt6">
		  <?php /*<div class="Fright mr17">
			<div class="search_box_wrapper">
			
					$formAttributes = array(
						'name'=>'SPearchForm',
						'id'=>'SPearchForm',
					);
					echo form_open($this->uri->uri_string(),$formAttributes);
					
					?>
					<input name="showProjectsSearch" id="showProjectsSearch" type="text" class="search_text_box" value="<?php if(empty($showProjectsSearch)){ echo $this->lang->line('keywordSearch');} else echo $showProjectsSearch;?>" placeholder="<?php echo $this->lang->line('keywordSearch');?>" onclick="placeHoderHideShow(this,'<?php echo $this->lang->line('keywordSearch');?>','hide')" onblur="placeHoderHideShow(this,'<?php echo $this->lang->line('keywordSearch');?>','show')">
					<div class="search_btn height28"> <input type="image" src="<?php echo base_url();?>images/btn_search_box.png" name="searchSP" value="searchSP" ></div>
				   <?php 
				   
				echo form_close(); 
				
			</div>
		</div>*/?>
	   
	   <div class="Fright mr5">
			<?php
				$splistUrl=base_url('showproject/index/'.$userId);
				if(is_array($spTypeDropDwon) && count($spTypeDropDwon) > 0){
					ksort($spTypeDropDwon);
					echo form_dropdown('projType', $spTypeDropDwon, $spSection,'id="projType" class="main_SELECT width265px dn" onchange="goTolink(this,\''.$splistUrl.'\')"');
				}
		   ?>
		</div>
		<div class="clear"></div>
	</div>
	<div class="p10 bg_white mt10 ml10 mr10">
		<?php
		 $spDataCount=count($spData);
		
		 if($spData && is_array($spData) && $spDataCount > 0){?>
			<div id="pagingContent">
				<?php
					
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
							$sp->link=base_url(lang().'/mediafrontend/searchresult/'.$linkId.'filmvideo');
							break;
						case 'musicNaudio':
							$spBgClass='bg_SRMusic';
							$sp->creative_area='';
							$sp->element_type='';
							$sp->projectCategory='';
							$sp->wordCount='';
							$sp->city='';
							$sp->industry='';
							$linkId=($sp->elementid == $sp->projectid)?$sp->userid.'/'.$sp->projectid.'/':$sp->userid.'/'.$sp->projectid.'/'.$sp->elementid.'/';
							$sp->link=base_url(lang().'/mediafrontend/searchresult/'.$linkId.'musicaudio');
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
							$sp->link=base_url(lang().'/mediafrontend/searchresult/'.$linkId.'photographyart');
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
							$sp->link=base_url(lang().'/mediafrontend/searchresult/'.$linkId.'writingpublishing');
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
							$sp->link=base_url(lang().'/mediafrontend/searchresult/'.$linkId.'educationmaterial');
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
							$linkId=($sp->elementid == $sp->projectid)?$sp->userid.'/'.$sp->projectid.'/':$sp->userid.'/'.$sp->projectid.'/'.$sp->elementid.'/';
							$sp->link=base_url(lang().'/mediafrontend/searchresult/'.$linkId.'news');
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
							$linkId=($sp->elementid == $sp->projectid)?$sp->userid.'/'.$sp->projectid.'/':$sp->userid.'/'.$sp->projectid.'/'.$sp->elementid.'/';
							$sp->link=base_url(lang().'/mediafrontend/searchresult/'.$linkId.'reviews');
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
					<div class="all_list_item">
						<?php
							$this->load->view('result',array('sp'=>$sp,'spBgClass'=>$spBgClass));
						?>
					</div>
					<?php
				  }
				}?>
			</div>
			<div class="clear"></div>
			<?php
			if($spDataCount >  $this->lang->line('perPageRecord')){?>
				 <div class="row mt3">
							<?php
							$this->load->view('pagination_view',array('totalRecord'=>$spDataCount,'record_num'=>$this->lang->line('perPageRecord')));
							?>
				</div>
				<?php
			}
		}else{
			$this->load->view('common/no_search_found_full');
		}?>

		<div class="seprator_10"></div>
		 <div class="clear"></div>
	</div>
	 <div class="clear"></div>

	<?php //$this->load->view('common/adv_728_90'); ?>
	<div id="advert728_90">
		<?php 
		if(is_dir(APPPATH.'modules/advertising') && !empty($advertSectionId)) {
			//Manage right side advert
			$bannerRhsData =  Modules::run("advertising/getAdvertRecords", array('sectionId'=>$advertSectionId,'advertType'=>'5'));
			if(!empty($bannerRhsData)) {
				$this->load->view('common/advert',array('bannerData'=>$bannerRhsData,'advertType'=>'5','sectionId'=>$advertSectionId)); 
			} else { 
				$this->load->view('common/adv_728_90');
			} 
		} else {
			$this->load->view('common/adv_728_90');
		}?> 	
	</div>
	<div class="clear"></div>
	<div class="seprator_10"></div>
</td>
