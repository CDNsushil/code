<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 
$craveSection=$projectType;
$craveSection=trim($craveSection);
$startFromWord=strtolower(trim($startFromWord));
$module=$this->router->fetch_class();
$totalCraves=count($craves);
$projectTypeCrave=array();
$projectType='';
$creativeName='';

foreach($craves as $key=>$crave){
	/*if(isset($craves[$key-1]) && (($craves[$key-1]->entityid==($craves[$key]->entityid)) && ($craves[$key-1]->elementid==($craves[$key]->elementid))  ) ){
			continue;
	}*/
	
	if($projectType != $crave->projectType){
		$projectType=$crave->projectType;
	}
	$projectTypeCrave[$projectType][]=$crave;
}
//unset($projectTypeCrave['work']);
$activeAllClass=($craveSection=='' || $craveSection=='all' )?'active':'';
$id=0;
$craveData=array();
$i=0;
$craveTypeDropDwon=array();
$craveTypeDropDwon['']=$this->lang->line('all');

// For New Blank Crave list

//echo "<pre/>";print_r($craveDropDwon);
if($craveDropDwon){

$countDropdown=(isset($allCount) && is_numeric($allCount) && ($allCount > 0))?$allCount:count($craveDropDwon);
$craveTypeString['all']='<li><a class="'.$activeAllClass.'" href="'.base_url(lang()).'/craves/'.$currentMathod.'" > '.$this->lang->line('all').' <span> ('.$countDropdown.')</span></a></li>';
	
	$defultProjectType='';
	foreach($craveDropDwon as $key=>$dd){
		if($defultProjectType!=$dd->projectType){
			$craveTypeCount=1;
			$defultProjectType=$dd->projectType;
		}else{
			$craveTypeCount++;
		}
		$craveTypeDropDwon[$dd->projectType]=$this->lang->line($dd->projectType);
		$activeClass=$dd->projectType==$craveSection?'active':'';
		
		if($cravingMe == $activeheading){
			$craveTypeStr=$this->lang->line('cravingMy'.$dd->projectType);
			
		}else{
			$craveTypeStr=$this->lang->line($dd->projectType);
		}
		
		$craveTypeString[$dd->projectType]='<li><a class="'.$activeClass.'" href="'.base_url(lang()).'/craves/'.$currentMathod.'/'. $dd->projectType.'" > '. $craveTypeStr.' <span>('.$craveTypeCount.')</span></a></li>';
	}
}

foreach($projectTypeCrave as $key=>$craves){
	$activeClass=$key==$craveSection?'active':'';
	$imagetype=$this->config->item($key.'Image');
	
	foreach($craves as $k=>$crave){
		$section=$crave->section;
		$projectTypeName=$craveImage=$genreString=$length=$wordCount='';
		$projectId=$projectid=$crave->projectid;
		$elementId=$elementid=$crave->elementId;
		$entityId=$crave->entityId;
		$craveCount=$crave->craveCount;
		$tdsUid=$crave->tdsUid;
		$ratingAvg=roundRatingValue($crave->ratingAvg);
		$craveClass=($tdsUid==$userId?"admin_cravedALL":'');
		$craveFClass=($tdsUid==$userId?'cravedALL':'');
		$cacheFile=$crave->cachefile;
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
				
				if($elementId != $projectId && (isset($project['elements']))){
					foreach($project['elements'] as $projectkey=>$element){
						if($element['elementId']==$elementId){
							$project=$project['elements'][$projectkey];
							break;
						}
					}
					$length=isset($project['fileLength'])?$project['fileLength']:'';
					$wordCount=isset($project['wordCount'])?$project['wordCount']:'';
				}
				
				if(($crave->section=='photographyNart' && ($elementid != $projectid)) || $crave->section=='performancesevents' || $crave->section=='notification' || $crave->section=='work' || $crave->section=='product' || $crave->section=='blog' ||$crave->section=='post' || $crave->section=='upcoming'){
						$fileName=isset($project['fileName'])?trim($project['fileName']):'';
						$filePath=isset($project['filePath'])?trim($project['filePath']):'';
						$fpLen=strlen($filePath);
						if($fpLen > 0 && substr($filePath,-1) != '/'){
							$filePath=$filePath.'/';
						}
						$craveImage=$filePath.$fileName;
						
						//-----------get enternal image for photo graphy and art section---------//
						if($crave->section=='photographyNart'){
							if($project['isExternal']=="t"){
								$craveImage= checkExternalImage($project['filePath'],'_s');
							}
						}
						
				}
				elseif($crave->section=='event') {
					//----------make element default event image code start---------//
					$eventImage = $project['filePath'].$project['fileName'];
					if(!empty($eventImage) && file_exists($eventImage)) {
						$craveImage = $eventImage;
					} else {
						$getProjectImage = getEventsPrimaryImage($project['EventId'],'.eventId');
						if($getProjectImage){
							$craveImage = $getProjectImage;
						}else{
							$craveImage = $eventImage;				
						}
					}
					//----------make element default event image code start---------//
				}
				elseif($crave->section=='launch') {
					//----------make element default launch image code start---------//
					$launchImage = $project['filePath'].$project['fileName'];
					if(!empty($launchImage) && file_exists($launchImage)) {
						$craveImage=$launchImage;
					} else {
						$getProjectImage = getEventsPrimaryImage($project['LaunchEventId'],'.launchEventId');
						if($getProjectImage){
							$craveImage = $getProjectImage;
						}else{
							$craveImage = $launchImage;				
						}
					}
					//----------make element default launch image code start---------//
				}
				elseif($crave->section=='creatives' || $crave->section=='associatedprofessionals'|| $crave->section=='enterprises'){
						
						if(isset($project['stockImgId']) && $project['stockImgId'] > 0){
							$craveImage=$project['stockImgPath'].'/'.$project['stockFilename'];					
						}
						else{
							$profileImagePath  = 'media/'.$project['username'].'/profile_image/';
							$craveImage=$profileImagePath.$project['profileImageName'];	
						}
						
				}
				elseif(isset($project['projBaseImgPath']) && !empty($project['projBaseImgPath'])){
						$craveImage=trim($project['projBaseImgPath']);
				}elseif(isset($project['imagePath']) && !empty($project['imagePath'])){
						$craveImage=trim($project['imagePath']);
				}elseif($crave->section=='filmNvideo'){
					if(empty($project['imagePath']) && $project['entityId']=='12') {
						$fileName=isset($project['fileName'])?trim($project['fileName']):'';
						$filePath=isset($project['filePath'])?trim($project['filePath']):'';
						$craveImage = getVideoThumbFolder(@$filePath.$fileName,'_xs');		
					}elseif(!empty($project['elements'])){
							foreach($project['elements'] as $elementData){
								if(isset($elementData['isProjectImage']) && $elementData['isProjectImage']=="t"){
								// if image path is not empty
								if(empty($elementData['imagePath'])){
									$craveImage = getVideoThumbFolder(@$elementData['filePath'].$elementData['fileName']);	
								}else{
									$craveImage=trim($elementData['imagePath']);
								}
							}	
						}
					}
				}elseif(!empty($project['elements'])){
							foreach($project['elements'] as $elementData){
								if(isset($elementData['isProjectImage']) && $elementData['isProjectImage']=="t"){
								// if image path is not empty
								if(empty($elementData['imagePath'])){
									// project craved section is filmNvideo
									if($crave->section=='filmNvideo'){
										$craveImage = getVideoThumbFolder(@$elementData['filePath'].$elementData['fileName']);	
									}else{
										
										if($elementData['isExternal']=='t'){
											 $craveImage = checkExternalImage($elementData['filePath'],'_s');
										}else{
											 $craveImage=$elementData['filePath'].$elementData['fileName'];
										}
									}
								}else{
									$craveImage=trim($elementData['imagePath']);
								}
							}	
						}
					}
				
				
			}
		
		}
		
		if($craveSection=='work'){
			$imagetype=$this->config->item($craveSection.$crave->work_type.'Image');
		}
		
		$crave->length=$length;
		$crave->wordCount=$wordCount;
		$crave->sell_option= ucfirst($crave->sell_option);
		 
		$ratingAvg=roundRatingValue($crave->ratingAvg);
		$ratingImg='images/rating/rating_0'.$ratingAvg.'.png';
		$crave->ratingImg=$ratingImg;
		
		
		$crave->type=($crave->section=='news' || $crave->section=='reviews' || $crave->section=='educationMaterial' || $crave->section=='upcoming')?$crave->industry:$crave->type;
		
		if(((isset($project['isExternalImageURL']) && $project['isExternalImageURL']=='t') || ((isset($project['isExternal']) && $project['isExternal']=='t')) && (isset($project['filePath']) && $crave->section=='photographyNart')) ){
				$craveImage=trim($craveImage);
		}
		else{
			$getPojrectImage = $craveImage;
			
			if(is_file($craveImage)){
				   $imageInfo = pathinfo($craveImage);
				   $ImageName=$imageInfo['filename'];
				   $ImageName=$imageInfo['dirname'].'/thumb/'.$ImageName.'_s.'.$imageInfo['extension'];
				   if(is_file($ImageName)){
					   $craveImage=$ImageName;
					}
			  }
			$craveImage=getImage($craveImage,$imagetype);
		
			//----------if section is photographyNart-------//
			if($crave->section=='photographyNart'){
				$craveImage = $getPojrectImage;
				if(is_file($craveImage)){
				   $imageInfo = pathinfo($craveImage);
				   $ImageName=$imageInfo['filename'];
				   $ImageName=$imageInfo['dirname'].'/thumb/'.$ImageName.'_s.'.$imageInfo['extension'];
				   if(is_file($ImageName)){
					   $craveImage=$ImageName;
					}
					$craveImage=getImage($craveImage,$imagetype);	
				}else{
					$craveImage = checkExternalImage($craveImage,'_s');
				}
			}
			
		}
		
		
		$crave->projectCategory='';
		
		if($crave->categoryid=='product_1'){
			$crave->projectCategory=$this->lang->line('forSale');
		}
		elseif($crave->categoryid=='product_2'){
			$crave->projectCategory=$this->lang->line('wanted');
		}
		elseif($crave->categoryid=='product_3'){
			$crave->projectCategory=$this->lang->line('free');
		}elseif($crave->categoryid=='product_3'){
			$crave->projectCategory=$this->lang->line('free');
		}
		
		$genreStringFlag=false;
		
		if(isset($crave->genre) && !empty($crave->genre)){
			$genreString.=$crave->genre;
			$genreStringFlag=true;
		}
		/*if(isset($crave->subgenre) && !empty($crave->subgenre)){
			if($genreStringFlag){
				$genreString.=',&nbsp;';
			}
			$genreString.=$crave->subgenre;
		}*/
		
		$projectTypeName=$crave->industry;
		if($craveSection=='filmNvideo' || $craveSection=='musicNaudio'|| $craveSection=='writingNpublishing' || $craveSection=='photographyNart'){
			$projectTypeName=$crave->type;
		}
		
		
		$crave->craveSection=$craveSection;
		$crave->craveImage=$craveImage;
		$crave->craveClass=$craveClass;
		$crave->craveFClass=$craveFClass;
		$crave->ratingAvg=$ratingAvg;
		$crave->ratingImg=$ratingImg;
		$crave->length=$length;
		$crave->wordCount=$wordCount;
		$crave->projectTypeName=$projectTypeName;
		$crave->genreString=$genreString;
		
		$craveData[$i]=$crave;
		$i++;
		
	}
}
?>
