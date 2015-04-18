<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed'); ?>
<div id="wrapperL" class="minHeight600px">
	<h1><?php echo $this->lang->line('admin_Manage_newsletter');?></h1>
	<!-- Top Menu Div Start -->
	<div class="box menu">
		<a href="<?php echo site_url(SITE_AREA_SETTINGS.'manage_newsletter');?>"><?php echo $this->lang->line('admin_Manage_newsletter');?></a>|
		<a href="<?php echo site_url(SITE_AREA_SETTINGS.'manage_newsletter/set_newsletter');?>"><?php echo $this->lang->line('add_newsletter');?></a>|
		<a href="<?php echo site_url(SITE_AREA_SETTINGS.'manage_newsletter/compose_mail');?>"><?php echo $this->lang->line('send_newsletter');?></a>
	</div>
	<!-- Top Menu Div End -->
	<!-- Main content Div Start -->
	<div class="box">
		<div class="fl ">
			<div class="cell frm_element_wrapper pl14 fl ">
				<div>
					<?php echo $newsletterContent;?>
				</div><!-- bdr_c9c9c9 -->
				
				
				<input id="userIds" type="hidden" value="" name="userIds[]">
				<div class="tds-button Fright">
					<button class="dash_link_hover" onclick="openLightBox('popupBoxWp','popup_box','admin/settings/manage_newsletter/manage_newsletter_users_grid/<?php echo $messageId;?>')" value="Send" name="submit" type="submit" id="SubmitButton">
						<span><div class="Fleft">Send</div> <div class="send_button"></div></span>
					</button>
				</div>
				<div class="seprator_20"></div>
			</div>
		<div class="clear"></div>
		
	</div>

	<!-- Right side user listing div -->
	<div class="fr receiverList">
		<div class="bdr_f15921 ml12 mr40 pt3 pb3 b  width_165">
			<?php echo $this->lang->line('receiverList');?>
		</div>
		<?php
		if(isset($participantsId) && is_array($participantsId)  && count($participantsId) > 0 ) {	
			for($i=0;$i<count($participantsId);$i++) {
				$getUserShowcaseData= getUserShowcaseDetails($participantsId[$i]);
				if(!empty($getUserShowcaseData->firstName) || !empty($getUserShowcaseData->lastName)) { ?>
					<div class="">
						<div class="fl width_270 ml2 mt10">
							<div class="ml12 mr40 pt3 pb3">
								<div class="fl font_size14 width180px">
									<?php echo $getUserShowcaseData->firstName.' '. $getUserShowcaseData->lastName;?>
								</div>
								<div class="fr font_size12"></div>
								<div class="clear"></div>
							</div>
						</div>
						<div class="clear"></div>
					</div>
				<?php 
				}
			 }
		} else {
			echo '<div class="fl font_size14 ml12  pt3 pb3">No Record found </div>';
		} ?>	
	</div>
	
	<div class="clear"></div>
	</div>
	<!-- Main content Div End -->
<div class="seprator_20"></div>
</div>



