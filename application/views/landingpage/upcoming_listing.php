<?php 
if ( ! defined('BASEPATH')) exit('No direct script access allowed');
if(isset($data) && is_array($data) && count($data) > 0){
	$recordDetailUrl = base_url(lang().'/upcomingfrontend/viewproject/'.$data['tdsUid'].'/'.$data['projId'].'/'.$frontendMathod);
	if($data['enterprise']=='t'){
		$userFullName = $data['enterpriseName'];
	}else{
		$userFullName = $data['firstName'].' '.$data['lastName'];
	}
//----------make element default project image code start---------//
	$filePath=trim($data['filePath']);
	$fileName=trim($data['fileName']);
	if(is_dir($filePath) && $fileName !=''){
		$fpLen=strlen($filePath);
		if($fpLen > 0 && substr($filePath,-1) != DIRECTORY_SEPARATOR){
			$filePath=$filePath.DIRECTORY_SEPARATOR;
		}
		$projImage=$filePath.$fileName;
	}else{
		$projImage='';
	}
	
	$thumbImage = addThumbFolder($projImage,'_lp');				
	$thumbFinalImg = getImage($thumbImage,$this->config->item('defaultUpcomingImg_lp'));
	
	$craveCount = is_numeric($data['craveCount'])?$data['craveCount']:0;
	$ratingAvg = is_numeric($data['ratingAvg'])?$data['ratingAvg']:0;
	$viewCount = is_numeric($data['viewCount'])?$data['viewCount']:0;
    $reviewCount = is_numeric($data['reviewCount'])?$data['reviewCount']:0; 
	
	
	if(isset($data['craveId']) && ($data['craveId'] > 0)){
		$cravedALL='cravedALL';
	}else{
		$cravedALL='';
	}
	
	$ratingAvg=roundRatingValue($ratingAvg);
	$ratingImg=base_url().'images/rating/rating_0'.$ratingAvg.'.png';
	$userName = $data['firstName'].' '.$data['lastName'];
	
	 //get user showcase details
	$userInfo   =  showCaseUserDetails($data['tdsUid']);

	//get user first name
	$userFullName = $userInfo['userFullName'];
	$imageSize = '_m';
	if(!empty($userInfo['creative']) || !empty($userInfo['associatedProfessional']) || !empty($userInfo['enterprise'])){ 
		$userDefaultImage = ($userInfo['enterprise']=='t')?$this->config->item('defaultEnterpriseImg'.$imageSize):($userInfo['associatedProfessional']=='t'?$this->config->item('defaultAssProfImg'.$imageSize):$this->config->item('defaultCreativeImg'.$imageSize));
	} else {
		$userDefaultImage = $this->config->item('defaultMemberImg'.$imageSize);
	}

	$userTemplateThumbImage = addThumbFolder($userInfo['userImage'],$imageSize);	
	$userImage = getImage($userTemplateThumbImage,$userDefaultImage);

	//----------make element default project image code start---------//
	
	//-----------get image width by remove absulte path------------//
	
	?>
	<a href="<?php echo $recordDetailUrl;?>"  target="_blank" >
		<div class="cnt_box upcoming_list  bg_fff  ">
			<div class="list_img fl m_auto position_relative">
				<div class="display_table">
					<div class="table_cell"> <img src="<?php echo $thumbFinalImg;?>" alt=""> </div>
				</div>
				<div class="display_table">
					<div class="table_cell"> <img src="<?php echo $userImage;?>" alt=""> </div>
				</div>
				<div class=" clr_fff  opensans_semi fr  pr20 pt10 text_alignR"><?php echo $userName;?></div>
			</div>
			<div class="hover_collection "><span class="display_cell text_alighC  fs20 opens_light">VIEW COLLECTION</span></div>
			<div class="p15 clearbox">
				<h4 class="fs17 pt3 font_bold lineH20"><?php echo getSubString($data['projTitle'],40);?></h4>
				<p><?php echo $data['proShortDesc'];?> </p>
			</div>
			<div class="bg_f6f6f6 fl width100_per c_1">
				<div class="head_list fl">
					<div class="icon_view3_blog icon_so"><?php echo $viewCount;?></div>
					<div class="icon_crave4_blog icon_so"><?php echo $craveCount;?></div>
					<div class="rating fl pt6"> <img  src="<?php echo $ratingImg;?>" /></div>
					<div class="btn_share_icon icon_so"><?php echo $reviewCount; ?></div>
				</div>
			</div>
		</div>
	</a>
    <?php
}  
