<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
if(isset($data) && is_object($data) && count($data) > 0){
	$recordDetailUrl = base_url(lang().'/blogs/frontpost/'.$data->custId.'/'.$data->postId);
			
	if($data->enterprise=='t'){
		$userFullName = $data->enterpriseName;
	}else{
		$userFullName = $data->firstName.' '.$data->lastName;
	}
//----------make element default project image code start---------//
	$thumbImage = '';
	$filePath=trim($data->filePath);
	$fileName=trim($data->fileName);
	if(is_dir($filePath) && $fileName !=''){
		$fpLen=strlen($filePath);
		if($fpLen > 0 && substr($filePath,-1) != DIRECTORY_SEPARATOR){
			$filePath=$filePath.DIRECTORY_SEPARATOR;
		}
		$projImage=$filePath.$fileName;
	}else{
		$projImage='';
	}
	$defaultImage=$this->config->item('defaultBlogImg_m');
	$thumbImage = addThumbFolder($projImage,'_b');	
	$thumbFinalImg = getImage($thumbImage,$defaultImage);
	
	$craveCount = is_numeric($data->craveCount)?$data->craveCount:0;
	$ratingAvg = $data->ratingAvg;
    $reviewCount = ($data->reviewCount)?$data->reviewCount:'0';
	$viewCount = is_numeric($data->viewCount)?$data->viewCount:0;
	
	
	if(isset($data->craveId) && ($data->craveId > 0)){
		$cravedALL='cravedALL';
	}else{
		$cravedALL='';
	}
	
	$ratingAvg=roundRatingValue($ratingAvg);
	$ratingImg=base_url().'templates/new_version/images/rating/rating_0'.$ratingAvg.'.png';	
	//----------make element default project image code start---------//
	
	//-----------get image width by remove absulte path------------//
		$getWidth = getImageWidth($thumbFinalImg);
	?>
	<a class="boxLink" href="<?php echo $recordDetailUrl;?>"  target="_blank" >
		<div class="cnt_box  bg_fff  ">
          <h5 class="fs16"><?php echo getSubString($userFullName,40);?></h5>
          <div class="display_table m_auto position_relative">
             <img src="<?php echo $thumbFinalImg;?>" alt="" />
             <div class="hover_collection "><div class="display_table"><span class="display_cell text_alighC  fs20 opens_light">VIEW COLLECTION</span></div></div>
          </div>
          <div class="p15">
             <h4 class="fs17 pt3 font_bold lineH20"> <?php echo getSubString($data->postTitle,40);?></h4>
             <p><?php echo $data->postOneLineDesc;?> 
             </p>
          </div>
          <div class="bg_f6f6f6 fl width100_per c_1">
             <div class="head_list fl">
                <div class="icon_view3_blog icon_so"><?php echo $viewCount;?></div>
                <div class="icon_crave4_blog icon_so"><?php echo $craveCount;?></div>
                <div class="rating fl pt6"><img  src="<?php echo $ratingImg;?>" /></div>
                <div class="btn_share_icon icon_so"><?php echo $reviewCount; ?></div>
             </div>
             <!--<span class="fr"> <b class="red pr7 ">9</b>Video Files </span> -->
          </div>
        </div>
	</a> <?php
}  
