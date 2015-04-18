<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
if(isset($comTmailData) && count($comTmailData) > 0 && !empty($comTmailData) ) {
	foreach($comTmailData as $cd){ 
		
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
		
		$countComments=countResult('CollaborationComments',array('elementId'=>$cd->id,'entityId'=>getMasterTableRecord('tmail_messages')));
		?>
		<div class="row position_relative">	
			<div id="collab-Content-Box" class="form_wrapper">
				<a href="<?php echo base_url(lang().'/collaboration/communicationsDetails/'.$cd->id.'/'.$collaborationId);?>">
					<div class="row pt15 pb10 pr15 pl15 ">
						<div class="cell width_114">
							<div class="blog_profile_img">
								<div class="AI_table">
									<div class="AI_cell C555">
										<img src="<?php echo $userImage;?>" class="review_thumb">
									</div>
								</div>
							</div><!--blog_profile_img -->
							<!--<div class="blog_profile_name"><?php echo $memberName;?></div>
							<div class="blog_profile_date"><?php  echo date("d F Y", strtotime($cd->cdate)); ?></div>-->
						</div>
						
						<div class="cell width630px pl20">
						  <div class="row pb10"><b><?php echo $memberName;?></b> posted this message on <?php  echo date("d F Y h:i a", strtotime($cd->cdate)); ?></div>
						  <div class="blog_profile_title"><?php  echo $cd->subject; ?></div>
						  <div class="blog_profile_txt"><?php  echo $cd->body; ?></div>
						  
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
							if($countComments >=1){ ?>
								<div class="row pt10">
									<div class="icon_comments formTip" title="Comments"><?php echo $countComments;?></div>
								</div>
							<?php }?>
						</div>
						<div class="clear"></div>
					</div>
				</a>
			</div>
		</div>
		<div class="clear"></div>
		<div class="row bbg"></div>
		<?php
	} ?>
	<div class="seprator_25 clear row"></div>
	<div class="row pt3 pl15 pr16">
		<?php 
		if(isset($countTotal) && isset($items_per_page) && $countTotal > $items_per_page) {
			$this->load->view('pagination_multi',array("pagination_links"=>$pagination_links,"items_total"=>$items_total,"items_per_page"=>$items_per_page,"url"=>base_url(lang().'/collaboration/communications/'.$collaborationId.'/2'),"divId"=>"showTmailData","formId"=>"composeForm","unqueId"=>"full","isShowNumber"=>true,"isShowDD"=>true,"pagingWpaerClass"=>'pagination_wrapper')); ?>
		<?php } ?>	
		<div class="clear"></div>
		<div class="seprator_10"></div>
	</div>
	<div class="seprator_25 clear row"></div>
	<?php
}?>

