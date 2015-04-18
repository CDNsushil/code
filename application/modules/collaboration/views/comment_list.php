<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
if(isset($commentsData) && count($commentsData) > 0 && !empty($commentsData) ) {
	?>
	
	<div class="row frm_heading">
		<h1 class="">Comments</h1> 
	</div>
	<div class="seprator_15 clear row"></div>
	<?php
	foreach($commentsData as $cd){ 
		$memberName = ($cd->enterprise == 't')?$cd->enterpriseName:$cd->firstName.' '.$cd->lastName;
		
		if(is_numeric($cd->stockImgId) && ($cd->stockImgId > 0) )
		{
			$userImage=$cd->stockImgPath.DIRECTORY_SEPARATOR.$cd->stockFilename;					
		}else{
			$profileImagePath  = 'media/'.$cd->username.'/profile_image/';
			$userImage=$profileImagePath.$cd->profileImageName;	
		}
		
		if(isset($userNavigations) && is_array($userNavigations) && count($userNavigations) > 0 &&(in_arrayr( 'enterprises', $userNavigations, $key='section', $is_object=0 ) || in_arrayr( 'associatedprofessionals', $userNavigations, $key='section', $is_object=0 ) || in_arrayr( 'creatives', $userNavigations, $key='section', $is_object=0 ))){ 
			$userDefaultImage=($cd->enterprise=='t')?$this->config->item('defaultEnterpriseImg_152_210'):($cd->associatedProfessional=='t'?$this->config->item('defaultAssProfImg_152_210'):$this->config->item('defaultCreativeImg_152_210'));
		}else{
			$userDefaultImage=$this->config->item('defaultMemberImg_m');
		}
		
		$userTemplateThumbImage = addThumbFolder($userImage,'_m');	
		$userImage = getImage($userTemplateThumbImage,$userDefaultImage);
	
		?>
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
					    <div class="blog_profile_date"><?php  echo date("d F Y", strtotime($cd->date)); ?></div> -->
					</div>
					
					
					<div class="cell width630px pl20">
					  <div class="row pb10"><b><?php echo $memberName;?></b> posted this message on <?php  echo date("d F Y h:i a", strtotime($cd->date)); ?></div>
					  <div class="blog_profile_title"><?php  echo $cd->title; ?></div>
					  <div class="blog_profile_txt"><?php  echo $cd->description; ?></div>
					  
					   <?php
						if(isset($cd->fileName) && strlen($cd->fileName)>3  && isset($cd->filePath) && strlen($cd->filePath)>3){
							$fpLen=strlen($filePath);
							if($fpLen > 0 && substr($filePath,-1) != DIRECTORY_SEPARATOR){
								$filePath=$filePath.DIRECTORY_SEPARATOR;
							}
							$file=$cd->filePath.$cd->fileName;
							if(is_file($file)){ ?>
								<div class="Fleft pt10">
									<a target="_blank" class="formTip fl dash_link_hover" href="<?php echo base_url($file);?>" title="Download" >
										<span>
											<div id="addCatButton" class="cat_smll_save_icon eduInfoUpdate fl mr2"></div>
											<div class="fl"> <?php echo $cd->rawFileName; ?></div>
										</span>	
									</a>
								</div>
							<?php
							}
						}
					   ?>
					</div>
					<div class="clear"></div>
				</div>
				
			</div>
		</div>
		<div class="clear"></div>
		<div class="row bbg"></div>
		<?php
	}
}?>

