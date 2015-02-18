<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 
$craveSection=$projectType;
$craveSection=trim($craveSection);
$startFromWord=strtolower(trim($startFromWord));
$module=$this->router->fetch_class();
$totalCraves=count($craves);
$projectTypeCrave=array();
$projectType='';
$creativeName='';

if($craves && is_array($craves) && count($craves) > 0 )foreach($craves as $key=>$crave){
	if($projectType != $crave->projectType){
		$projectType=$crave->projectType;
	}
	$projectTypeCrave[$projectType][]=$crave;
}

$activeAllClass=($craveSection=='' || $craveSection=='all' )?'active':'';
$id=0;
$craveData=array();
$i=0;



if($projectTypeCrave && is_array($projectTypeCrave) && count($projectTypeCrave) > 0 )foreach($projectTypeCrave as $key=>$craves){
	
	
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
		
		$craveImage=$this->config->item('defaultMemberImg_xxs');
		
		if(!empty($cacheFile) && is_file(@$cacheFile)){
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
				
				if($crave->section=='creatives' || $crave->section=='associatedprofessionals'|| $crave->section=='enterprises'){
						
					if(isset($project['stockImgId']) && $project['stockImgId'] > 0){
						$craveImage=$project['stockImgPath'].'/'.$project['stockFilename'];					
					}
					else{
						$profileImagePath  = 'media/'.$project['username'].'/profile_image/';
						$craveImage=$profileImagePath.$project['profileImageName'];	
					}
				}
				
				
			}
		}
		
		$ratingAvg=roundRatingValue($crave->ratingAvg);
		$ratingImg='images/rating/rating_0'.$ratingAvg.'.png';
		$crave->ratingImg=$ratingImg;
		
		
		
		if(is_file($craveImage)){
			   $imageInfo = pathinfo($craveImage);
			   $ImageName=$imageInfo['filename'];
			   if($crave->isPublished=='t'){
					$ImageName=$imageInfo['dirname'].'/thumb/'.$ImageName.'_s.'.$imageInfo['extension'];
			   }else{
				   $ImageName=$imageInfo['dirname'].'/thumb/'.$ImageName.'_xs.'.$imageInfo['extension'];
			   }
			   if(is_file($ImageName)){
				   $craveImage=$ImageName;
				}
		  }
		
		$imagetype=$this->config->item($crave->section.'Image');
	
		$craveImage=getImage($craveImage,$imagetype);
		
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
		
		$craveData[$i]=$crave;
		$i++;
	}
}
