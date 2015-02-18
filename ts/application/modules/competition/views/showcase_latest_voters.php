<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); ?>
	
	<div class="row summery_right_archive_wrapper width_auto position_relative mt20">
		<h1 class="sumRtnew_strip01"><?php echo $this->lang->line('competition_latest_voters'); ?></h1>
	</div>
	
	<div class="scroll_box_competition height80 p5 widht_275">
		<div class="row recent_box_wrapper01">
		  <div class="row">
		<?php
			if(!empty($votes))
			{
			foreach($votes as $votesList)
			{
				
			/**********get user image************/		
			$creative=$votesList->creative;
			$associatedProfessional=$votesList->associatedProfessional;
			$enterprise=$votesList->enterprise;
				
			$userDefaultImage=($creative=='t')?$this->config->item('defaultCreativeImg_xxs'):(($associatedProfessional=='t')?$this->config->item('defaultAssProfImg_xxs'):(($enterprise=='t')?$this->config->item('defaultEnterpriseImg_xxs'):''));						
			$userImage="media/".$votesList->username."/profile_image/".$votesList->image;
			$userImage=addThumbFolder($userImage,$suffix='_xxs',$thumbFolder ='thumb',$userDefaultImage);  	
			$userImage=getImage($userImage,$userDefaultImage);	
			
		?>
			
			<div class="cell height75 mt3 ml15">
				<div class="fl recent_thumb_PApage">
				  <div class="AI_table">
					<div class="AI_cell"> 
						<img src="<?php echo $userImage ?>" class="bdr_cecece max_w68_h68"> 
					</div>
				  </div>
				</div>
			</div>
		<?php } } ?>	
		  </div>
		  <div class="clear"></div>
		</div>
	</div>
			
		
