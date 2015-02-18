<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); ?>

	<div class="row summery_right_archive_wrapper width_auto position_relative">
		<h1 class="sumRtnew_strip01"><?php echo $this->lang->line('competition_current_places'); ?></h1>
		<div class="seprator_15"></div>	
	</div>
	<div>
	
	<div class="colap_leftSide"> <span class="Fleft"><?php echo $this->lang->line('competition_current_places'); ?></span>
		<div class="clear"></div>
	</div>
	<div id="eventCollectionToggle" class="PElistingtoggle">
	  <div class="scroll_box_competition global_shadow bdr_non mb2 ">
		<div id="currentPlacingSlider" class="slider"> <a class="buttons prev disable" href="#"></a>
		  <div class="viewport scroll_container02" style="">
			<ul class="overview" style="height: 240px; top: 0px; "> 
			<?php
				if($getCurrentPlacing)
				{
				foreach($getCurrentPlacing as $getCurrentPlacingList)
				{	
					// show competition entry cover image
					if(!empty($getCurrentPlacingList->coverImage) && isset($getCurrentPlacingList->coverImage))
							$mainCoverImage = $getCurrentPlacingList->coverImage;
						else
							$mainCoverImage = '';
					$coverImage='';
					$defCoverImage=$this->config->item('defaultcompetitonEntryImg73X110');
					$coverImage = addThumbFolder($mainCoverImage);	
					$entryCoverImage = getImage($coverImage,$defCoverImage);
				?>	
				
				<li style="">
					<div class="row recent_box_wrapper01">
					  <div class="row">
						<div class="cell recent_thumb_PApage thumb_absolute01">
						  <div class="AI_table">
							<div class="AI_cell"> <a href="javascript:void(0)"><img src="<?php echo $entryCoverImage; ?>" class="bdr_cecece max_w68_h68"> </a></div>
						  </div>
						</div>
						<div class="cell ml71 width_197">
						  <div class="recent_two_line01 pl10 height_42 mw186px ptr"><a href="javascript:void(0)" class=" dash_link_hover"><?php echo $getCurrentPlacingList->title; ?></a></div>
						  <div class="SMA_blog_status_bar"><div class="mt7"><span class="blogS_view_btn Fright "><?php echo $getCurrentPlacingList->craveCount; ?></span><span class="blogS_crave_btn Fright width_20 craveDiv9158 "><span class="inline"><?php echo $getCurrentPlacingList->viewCount; ?></span></span> </div></div>
						  <div class="clear"></div>
						</div>
					  </div>
					  <div class="clear"></div>
					</div>
				  </li>
				<?php } } ?>
				
			 </ul>
		  </div>
		  <a class="buttons next disable" href="#"></a> </div>
	  </div>
	</div>
			
