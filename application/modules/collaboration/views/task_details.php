<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
	if(isset($header) ){
		echo $header;
	}
	
	$memberName = ($taskData->enterprise == 't')?$taskData->enterpriseName:$taskData->firstName.' '.$taskData->lastName;
	$memberName = ($taskData->memberId == 0)?'All Mebers':$memberName;
	
	if(is_numeric($taskData->stockImgId) && ($taskData->stockImgId > 0) )
	{
		$userImage=$taskData->stockImgPath.DIRECTORY_SEPARATOR.$taskData->stockFilename;					
	}else{
		$profileImagePath  = 'media/'.$taskData->username.'/profile_image/';
		$userImage=$profileImagePath.$taskData->profileImageName;	
	}
	
	if(isset($userNavigations) && is_array($userNavigations) && count($userNavigations) > 0 &&(in_arrayr( 'enterprises', $userNavigations, $key='section', $is_object=0 ) || in_arrayr( 'associatedprofessionals', $userNavigations, $key='section', $is_object=0 ) || in_arrayr( 'creatives', $userNavigations, $key='section', $is_object=0 ))){ 
		$userDefaultImage=($taskData->enterprise=='t')?$this->config->item('defaultEnterpriseImg_152_210'):($taskData->associatedProfessional=='t'?$this->config->item('defaultAssProfImg_152_210'):$this->config->item('defaultCreativeImg_152_210'));
	}else{
		$userDefaultImage=$this->config->item('defaultMemberImg_m');
	}
	
	$userTemplateThumbImage = addThumbFolder($userImage,'_m');	
	$userImage = getImage($userTemplateThumbImage,$userDefaultImage);
?>
<div class="seprator_5 clear row"></div>
<div class="row ">
	<div class="cell frm_heading"> <h1 class="">To - Do Item</h1> </div>
	<div class="cell  fr pr20 f18 pt13 ">
		<a class="dash_link_hover" href="<?php echo base_url(lang().'/collaboration/todos/'.$collaborationId);?>" >
			<div class="icon_back">Back</div>
		</a>
	</div>
</div>
<div class="seprator_15 clear row"></div>		
<div class="row form_wrapper">
	<div class="row position_relative">	
		
		<div id="collab-Content-Box" class="form_wrapper">
			
			<div class="row pt15 pb15 pr10 pl10">
				
				<div class="cell width_114">
				   <div class="blog_profile_img">
						<div class="AI_table">
							<div class="AI_cell C555">
								<img src="<?php echo $userImage;?>" class="review_thumb">
							</div>
						</div>
				   </div>
					<!--<div class="comment_profile_name"><?php echo $memberName;?></div>
					<div class="blog_profile_date"><?php  echo date("d F Y", strtotime($taskData->startDate)); ?></div> -->
				</div>
					
					
				
				
				<div class="cell width630px pl20">
				  <div class="row pb10"><b><?php echo $memberName;?></b> posted this message on <?php  echo date("d F Y h:i a", strtotime($taskData->startDate)); ?></div>
				  <div class="blog_profile_title"><?php  echo $taskData->title; ?></div>
				  <div class="blog_profile_txt"><?php  echo $taskData->description; ?></div>
				</div>
				<div class="clear"></div>
		    </div>
			
			<div class="row bbg"></div>
			<div class="seprator_25 clear row"></div>
			
			<?php
			if(isset($commentList) ){
				echo $commentList;
			}
			
			if(isset($commentForm) ){ 
				echo $commentForm;
			}
			?>
			
			
		</div>
		
	</div>
</div>
