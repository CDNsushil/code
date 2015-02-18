<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 
$recommendationList= Modules::run("recommendations/index",array('Recommendations.is_show_in_showcase'=>'t','to_userid'=>$to_userid)); 
if($recommendationList && is_array($recommendationList) && count($recommendationList)>0){?>
	<div class="CSEprise_bottom_bg mr9 ml9">
	  <div class="white_horLine ">
		  <div class="Fleft width_165 height_16 mt24"></div>
		  <div class="Fleft width_610">
			<div id="recommendationSlider" class="slider pb3 pt7"> <a class="buttons prev mr2" href="#"></a>
			  <div class="viewport CSEprisebottom_scroll_container">
				<ul class="overview">
				  <?php 
					foreach($recommendationList as $data){
						
						$showcaseUrl = '/showcase/index/'.$data->from_userid;
						$userImage='media/'.$data->username.'/profile_image/'.$data->profileImageName;
						$userImage=(($data->stockImageId>0)?$data->stockImgPath.'/'.$data->stockFilename:$userImage);
						
						$thumbImage = addThumbFolder($userImage,'_s');	
						if($data->enterprise=='t')
							$defaultProfileImage = $this->config->item('defaultEnterpriseImg_s');		
						else if($data->associatedProfessional=='t')
							$defaultProfileImage = $this->config->item('defaultAssoProfImg_s');			
						else
							$defaultProfileImage = $this->config->item('defaultCreativeImg_s');	
								
						$thumbFinalImg = getImage($thumbImage,$defaultProfileImage);
						$writerName=$data->firstName.' '.$data->lastName;
						?>
						<li class="ptr" onclick="gotourl('<?php echo $showcaseUrl;?>')">
							<div class="CSEprise_mem_thumb ml9">
							  <div class="AI_table">
								  <div class="AI_cell proreco_img">
									  <img src="<?php echo $thumbFinalImg;?>" />
								  </div>
							  </div>
							</div>
							<div class="Fright width_425 mr24 clr_444">
							  <div class="CSEprise_memT bdr_Borange clr_Lblack dash_link_hover"><?php echo getSubString($writerName,50);?></div>
							  <div class=" font_opensans font_size13 Fright clr_Lblack"><?php echo get_timestamp('F Y',$data->created_date) ;?></div>
							  <div class="clear"></div>
							  <div class=" font_opensans font_size13 pt5"><?php echo changeToUrl(nl2br(getSubString($data->recommendations,250)));?></div>
							</div>
					   </li>
					   <?php
					}
				  ?>
				 
				 </ul>
			  </div>
			  <a class="buttons next mr2" href="#"></a>
			 </div>
		  </div>
		  <div class="clear"></div>
		 </div>
	</div>
	<?php
}?>
