<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 
	$imagetype = $fileConfig['defaultImage_m'];
	$imagetype_xs=$fileConfig['defaultImage_xs'];
	$imagetype_s=$fileConfig['defaultImage_s'];
	$methodName=$this->router->fetch_method();
	$sectionId=$this->config->item($industryType.'SectionId');
	$elementEntityId=getMasterTableRecord($elemetTable);
	$clr_white='';
	$ProjectColor='';
	$sectionBgcolor='rightBoxBG';
	if($methodName=='filmvideo' || $method=='filmvideo'){
		$bgColor='fv_content_bg';
		$ProjectColor=$clr_white='clr_white';
		$projectDetailPage='project_details_filmvideo';
		$elementDetailPage='project_details_filmvideoElement';
	}elseif($methodName=='musicaudio'|| $method=='musicaudio'){
		$bgColor='lightBLue_bg';
		$projectDetailPage='project_details_musicaudio';
		$elementDetailPage='project_details_musicaudioElement';
	}elseif($methodName=='photographyart' || $method=='photographyart'){
		$bgColor='lightGreen_bg';
		$projectDetailPage='project_details_photographyart';
		$elementDetailPage='project_details_photographyartElement';
	}elseif($methodName=='educationmaterial' || $method=='educationmaterial'){
		$projectDetailPage='project_details_educationmaterial';
		$elementDetailPage='project_details_educationmaterialElement';
		$bgColor='bg_EMpage';
	}elseif($methodName=='writingpublishing' || $method=='writingpublishing'){
		$bgColor='wp_content_bg';
		$ProjectColor=$clr_white='clr_white';
		$projectDetailPage='project_details';
		$elementDetailPage='view_elements';
	 }elseif($method=='news' || $methodName=='news' || $methodName=='reviews' || $method=='reviews'){
		$bgColor='wp_content_bg';
		$ProjectColor=$clr_white='clr_white';
		$projectDetailPage='project_details';
		$elementDetailPage='view_elements';	
	}else{
		$projectDetailPage='project_details';
		$elementDetailPage='view_elements';
		$bgColor='right_panel_Darkgray_bg';
	}
	$elementsCollection=false;
	$projectDataFlag=true;
	
	if(isset($projects[0])){
		$project=$projects[0];
		
		if((isset($project['isPublished']) && $project['isPublished']=='t') || ($checkPublished==false))
		{
			$project['projectId'] = $projectId;
			$project['methodName'] = $methodName;
			$projSellstatus = $project['projSellstatus']=='t'?true:false;
			$continerSize = $project['containerSize'];
			$continerSize = $continerSize>0?(number_format(($continerSize/(1024*1024)),2)):50;
			
			$dirname = $dirUploadMedia.$industryType.'/'.$projectId.'/file/';
			$dirSize = bytestoMB(getFolderSize($dirname),'mb');
			$project['dirSize'] = $dirSize;			
			
			$projSellstatus = $project['projSellstatus']=='t'?true:false;
			$projSellstatusHeading = $projSellstatus?$constant['project_sales']:$constant['project_free'];
			$previeLink = 'media/'.$constant['project_preview'].'/'.$project['projectid'];
			if(@$project['isExternalImageURL']=='t'){
				$projectImage = trim($project['projBaseImgPath']);
			}else{
				
				//------element image as a project image code start------//
				//---------- if project image uploaded --------------// 
				if($project['projBaseImgPath']!="") {
					$thumbImage = addThumbFolder($project['projBaseImgPath'],'_b','thumb',$imagetype);	
					$projectImage = getImage($thumbImage,$imagetype,1);
				}else {
					//---------- if project image not uploaded --------------// 
					$isSetImage=false;
						//for industry is filmNVideo
						if($industryType=='filmNvideo'){
							foreach($project['elements'] as $elementData){
								if(isset($elementData['isProjectImage']) && $elementData['isProjectImage']=="t"){
									// if image path is not empty
									if(empty($elementData['imagePath'])){
										$thumbImage = getVideoThumbFolder(@$elementData['filePath'].$elementData['fileName'],'_b','thumb',$imagetype);	
										$projectImage = getImage($thumbImage,$imagetype,1);
										$isSetImage=true;
									}else{
										$thumbImage = addThumbFolder(@$elementData['imagePath'],'_b','thumb',$imagetype);		
										$projectImage = getImage($thumbImage,$imagetype,1);
										$isSetImage=true;
									}
								}
							}
						}else{
							//for industry is not filmNVideo
							foreach($project['elements'] as $elementData){
								if(isset($elementData['isProjectImage']) && $elementData['isProjectImage']=="t"){
									if($industryType=='photographyNart'){
										if($elementData['isExternal']=="t"){
											$projectImage=checkExternalImage($elementData['filePath'],'_b');
										}else{
											$thumbImage = addThumbFolder($elementData['filePath'].$elementData['fileName'],'_b','thumb',$imagetype);
											$projectImage = getImage($thumbImage,$imagetype,1);
										}
										$isSetImage=true;
										
									}else{	
									$thumbImage = addThumbFolder(@$elementData['imagePath'],'_b','thumb',$imagetype);		
									$projectImage = getImage($thumbImage,$imagetype,1);
									$isSetImage=true;
									}
								}
							}
						}
						//if project image not set and not make default image then
						if(!$isSetImage) {
							$thumbImage = addThumbFolder($project['projBaseImgPath'],'_b','thumb',$imagetype);	
							$projectImage = getImage($thumbImage,$imagetype,1);
						}
				}
				//------element image as a project image code end------//
				
			}
			$project['projectImage'] = $projectImage;
			$project['genre'] = $project['Genre'];
			$majorProject = $project['showPrice']=='f'?true:false;
			$elementHeading = $project['category'];
			$elememtDivHeihgt = 'height75';
			$project['projRating']=$project['otpion'];			
			$LogSummarywhere=array(
				'entityId'=>$entityId,
				'elementId'=>$projectId
			);
			$resLogSummary=getDataFromTabel('LogSummary', 'craveCount,ratingAvg,viewCount',  $LogSummarywhere, '', $orderBy='', '', 1 );
			if($resLogSummary){
				$resLogSummary = $resLogSummary[0];
				$craveCount = $resLogSummary->craveCount;
				$viewCount = $resLogSummary->viewCount;
				$ratingAvg = $resLogSummary->ratingAvg;
			}else{
				$craveCount = 0;
				$ratingAvg = 0;
				$viewCount = 0;
			}
			$project['viewCount'] = $viewCount;
			$project['craveCount'] = $craveCount;
			$ratingAvg = roundRatingValue($ratingAvg);
			$project['ratingAvg'] = $ratingAvg;
			$ratingImg = 'images/rating/rating_0'.$ratingAvg.'.png';
			$project['ratingImg'] = $ratingImg;			
			$cravedALL='';
			if($loggedUserId > 0){
				$where=array(
								'tdsUid'=>$loggedUserId,
								'entityId'=>$entityId,
								'elementId'=>$projectId
						);
				$countResult=countResult('LogCrave',$where);
				$cravedALL=($countResult>0)?'cravedALL':'';
			}else{
				$cravedALL='';
			}
			$project['cravedALL']=$cravedALL;
			$defaultElementFlag=false;
			$mainElementFlag=false;
			$isCurrentElementDefault=false;
			$isCurrentElementMain=false;
			$mainElementcount=0;
			$price = $project['projPrice'];
			$downloadPrice = $project['projDownloadPrice'];
			$perViewPrice = $project['projPpvPrice'];
			$dn='dn';
			
			if(is_array($project['elements']) && count($project['elements'])>0){
				$key1=0;
				$key2=0;
				foreach($project['elements'] as $k=>$element){
					if($element['isPublished']=='t' || ($checkPublished==false)){
						if($element['default']=='t'){
							
							if(!empty($method) && $elementId > 0 && ($elementId==$element['elementId'])){
								
								$isCurrentElementDefault=true;
								$dn='';
							}
							$defaultElementFlag=true;
							$defaultElements[$key1]=$element;
							$key1++;
						}else{
							if(!empty($method) && $elementId > 0 && ($elementId==$element['elementId'])){
								$isCurrentElementMain=true;
								$dn='';
							}
							$mainElementFlag=true;
							$mainElements[$key2]=$element;
							$mainElementcount++;
							$key2++;
						}
					}
				}
				if($isCurrentElementDefault){
					$elementsCollection=$defaultElements;
				}
				if($isCurrentElementMain){
					$elementsCollection=$mainElements;
				}
				if($mainElementcount > 1 || $methodName=='news' || $methodName=='reviews' || !$majorProject){
					if($methodName=='news'){
						$elementHeading=$this->lang->line('articles');
					}elseif($methodName=='reviews'){
						$elementHeading=$this->lang->line('reviews');
					}else{
						$elementHeading=$this->lang->line('pieces');
					}
					$elememtDivHeihgt='';
				}
			}
			if($industryType=='writingNpublishing' || $industryType=='news' || $industryType=='reviews'){
				$where=array(
								'tdsUid'=>$userId
						);
				if($checkPublished==true){
					$where['isPublished']='t';
				}
				$whereinValue=array('writingNpublishing','news','reviews');
				$orderBy= "projectType ASC, projLastModifyDate DESC";
				$projectListing=getDataFromTabelWhereWhereIn('Project', 'projId,projName,projectType,isPublished',  $where, 'projectType', $whereinValue, $orderBy);
			}
			else{
				$where=array('projectType'=>$industryType,'tdsUid'=>$userId);
				if($checkPublished==true){
					$where['isPublished']='t';
				}
				$projectListing=getDataFromTabel($table='Project', $field='projId,projectType,projName', $where, '', 'projLastModifyDate', 'DESC' );
			}
			$projectListingData='';
			$projectListingCount=0;
			$previousProjectId=0;
			$nextProjectId=0;
			$nextProjectIdFlag=false;
			$ProjectKeyFlag=false;
			$projectKey=0;
			if($projectListing){
				$projectListingData.='<ul class="sraw_new">';
				foreach($projectListing as $key=>$pt){
						$projectListingCount++;
						if($pt->projectType=='news' || $pt->projectType=='reviews'){
							$projName=$this->lang->line($pt->projectType).'&nbsp;'.$this->lang->line('collection');
							$functionName=trim(strtolower($pt->projectType));
						}else{
							$projName=$pt->projName;
							$functionName=trim(strtolower(str_replace('N','',$pt->projectType)));
						}
						$projectListing[$key]->projectType=$functionName;
						if($projectId==$pt->projId){
							$ProjectColor='highlight';
							$projectKey=$key;
							$project['projectKey']=$projectKey;
							$ProjectKeyFlag=true;
						}else{
							$ProjectColor=$clr_white=($methodName=='filmvideo'||$method=='filmvideo'||$methodName=='writingpublishing'||$method=='writingpublishing'||$methodName=='news'||$method=='news'||$methodName=='reviews'||$method=='reviews')?'clr_white':'';
						}
						if(($nextProjectIdFlag==false) && ($ProjectKeyFlag==true) && ($key > $projectKey)){
							$nextProjectIdFlag=true;
							$nextProjectId=$pt->projId;
							$nextProjectType=$projectListing[$key]->projectType;
						}
						if($ProjectKeyFlag==false){
							$previousProjectId=$pt->projId;
							$previousProjectType=$projectListing[$key]->projectType;
						}
						$projName=getSubString($projName,35);
						$projectType = ($pt->projectType == 'news' || $pt->projectType == 'reviews')?'writingpublishing':$pt->projectType;
						$projectListingData.='<li class="sraw_new"><a class="'.$ProjectColor.'" href="'.base_url(lang().$urlUsername.'/mediafrontend/'.$projectType.'/'.$userId.'/'.$pt->projId.'/'.$functionName).'">'.$projName.'</a></li>';
				}
				$projectListingData.='</ul>';
			}
			$project['projectListingCount']=$projectListingCount;
			if($previousProjectId > 0){
				$project['previousProjectId']=$previousProjectId;
				$project['previousProjectType']=$previousProjectType;
			}
			if($nextProjectId>0){
				$project['nextProjectId']=$nextProjectId;
				$project['nextProjectType']=$nextProjectType;
			}
			$projectUrl=base_url(lang().$urlUsername.'/mediafrontend/'.$methodName.'/'.$userId.'/'.$projectId);
			if(!isset($userInfo)){
				$userInfo =showCaseUserDetails($userId);
			}
			$seller_currency=$userInfo['seller_currency'];
			$seller_currency=($seller_currency>0)?$seller_currency:0;
			$currencySign=$this->config->item('currency'.$seller_currency);
	}else{
		$projectDataFlag=false;
	}
}
else{
	$projectDataFlag=false;
}
if($elementId > 0 && $elementsCollection==false){
	$projectDataFlag=false;
}
?>
<script type="text/javascript">
	$(document).ready(function(){
		$('.playAudioIcon').click(function(){
			var playclass=$(this).attr('class');
			$('.playAudioIcon').each(function(index){
					var inputClass =$(this).attr('class').replace('status_bar_play_btn_hover', 'status_bar_play_btn');
					$(this).attr('class',inputClass);
			});
			if((playclass.indexOf("status_bar_play_btn_hover") >= 0)){
				playclass = playclass.replace('status_bar_play_btn_hover', 'status_bar_play_btn');
			}
			else {
				playclass = playclass.replace('status_bar_play_btn', 'status_bar_play_btn_hover');
			}
			$(this).attr('class',playclass);
		});
	});
</script>
