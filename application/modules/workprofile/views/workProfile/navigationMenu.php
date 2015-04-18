<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); ?>
<?php

$location2 = $this->uri->segment(2);
$location3 = $this->uri->segment(3);

if($location3 =='addMoreSocialLinks' || $location3 =='addMoreReferencesRecommendations' || $location3 =='addMoreEmpHistory' || $location2 =='addMoreReferencesRecommendations' || $location2 =='addMoreSocialLinks' || $location2 =='addMoreEmpHistory'){
	//Menu for All Forms ?>
		<div class="frm_btn_wrapper">
			<?php if($location3=='addMoreEmpHistory'){
				$location = 'workprofile/empHistoryListing';
			} if($location3 == 'addMoreReferencesRecommendations') {
				$location = 'workprofile/referencesRecommendations';
			} if($location3 == 'addMoreSocialLinks') {
				$location = 'workprofile/showSocialMediaLinks';
			}?>
			<div class="tds-button-big Fleft"><?php echo anchor($location,'<span>'.$label['indexPage'].'</span>',array('onmousedown'=>'mousedown_big_button(this)', 'onmouseup'=>'mouseup_big_button(this)','onmouseover'=>'mouseover_big_button(this)'));?></div>
		</div>
		<div class="row line1"></div>
<?php }

if($location3=='empHistoryListing' || $location3 == 'referencesRecommendations' || $location3 == 'socialMedia' || $location3 =='workProfileForm'){
	// Menu for all Listing Pages?>
	<div class="row line1 mr10 width_435 mt-8"></div>
	<div class="row mr10 pb3 width420px">
		<div class="cell ml275 pr mt-25">
			<a href="<?php echo base_url(lang().'/workprofile/workshowcase');?>">
				<div class="wp_black_eventcircle font_opensansSBold font_size12 clr_white fl mr10 wp_orange_circle_hover">
					<div class="portfolio_index_icon mt5 ml22"></div>
					<div class="font_opensansSBold font_size13 text_alignC mt-5"><?php echo $this->lang->line('portfolioIndex');?></div>
				</div> 
			</a>
		</div>	
	</div>	

	<div class="Fright btn_outer_wrapper mr10 pb3 width_395">
	<!--<div class="frm_btn_wrapper mr5">-->
	<div class="ml5"></div>
			<?php if($location3=='empHistoryListing' || $location3=='addMoreEmpHistory' || $location3 == 'referencesRecommendations' || $location3 == 'addMoreReferencesRecommendations' || $location3 == 'socialMedia' || $location3 == 'addMoreSocialLinks'){?>
				<div class="tds-button-big Fleft"><?php echo anchor('workprofile/workProfileForm','<span class="two_line">'.$label['personalBrDetails'].'</span>',array('onmousedown'=>'mousedown_big_button(this)', 'onmouseup'=>'mouseup_big_button(this)','onmouseover'=>'mouseover_big_button(this)'));?></div>
			<?php }
				if($location3!='empHistoryListing' &&  $location3!='addMoreEmpHistory' ){?>
				<div class="tds-button-big Fleft"><?php echo anchor('workprofile/empHistoryListing','<span class="two_line">'.$label['empBRHistory'].'</span>',array('onmousedown'=>'mousedown_big_button(this)', 'onmouseup'=>'mouseup_big_button(this)','onmouseover'=>'mouseover_big_button(this)'));?></div>
			<?php } ?>
			<?php if($location3 != 'referencesRecommendations' && $location3 != 'addMoreReferencesRecommendations') {?>
				<div class="tds-button-big Fleft"><?php echo anchor('workprofile/referencesRecommendations','<span>'.$label['referencesBRRecommendations'].'</span>',array('onmousedown'=>'mousedown_big_button(this)', 'onmouseup'=>'mouseup_big_button(this)','onmouseover'=>'mouseover_big_button(this)'));?></div>
			<?php }?>
			<?php if($location3 != 'socialMedia' && $location3 != 'socialMedia') {?>				
				<div class="tds-button-big Fleft"><?php echo anchor('workprofile/socialMedia/'.$workProfileId,'<span class="two_line">'.$label['socialBRMediaLink'].'</span>',array('onmousedown'=>'mousedown_big_button(this)', 'onmouseup'=>'mouseup_big_button(this)','onmouseover'=>'mouseover_big_button(this)'));?></div>
			<?php }?>
			<div class="tds-button-big Fleft"><?php echo anchor('workprofile', '<span>'.$label['indexPage'].'</span>',array('onmousedown'=>'mousedown_big_button(this)', 'onmouseup'=>'mouseup_big_button(this)','onmouseover'=>'mouseover_big_button(this)'));?></div>
	</div>
	<!--<div class="row line1 mr10"></div>-->
	<div class="row seprator_5"></div>
<?php }

if($location2=='workprofile' && ($location3=='' || $location3=='workprofile')){
	// Menu for the Main page?>

<!--<div class="cell mt5 ml12">
		
		<div class="tds-button-big">
			<?php //echo anchor('workprofile/workshowcase','<span>'.$label['portfolio'].'</span>',array('onmousedown'=>'mousedown_big_button(this)', 'onmouseup'=>'mouseup_big_button(this)','onmouseover'=>'mouseover_big_button(this)'));?>
		
		</div>
	
</div>-->
<div class="row line1 mr10 width_435"></div>
<?php }?>

