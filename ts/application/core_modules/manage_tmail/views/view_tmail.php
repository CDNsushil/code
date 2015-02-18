<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed'); ?>
<div id="wrapperL" class="minHeight600px">
	<h1><?php echo $this->lang->line('tmailManager');?></h1>
	<!-- Top Menu Div Start -->
	<div class="box menu">
			<a href="<?php echo site_url(SITE_AREA_SETTINGS.'manage_tmail');?>">Home </a>|
			<a href="<?php echo site_url(SITE_AREA_SETTINGS.'manage_tmail/compose_tmail');?>"><?php echo $this->lang->line('composeTmail');?></a>
	</div>
	<!-- Top Menu Div End -->
	<!-- Main content Div Start -->
	<div class="box">
	<div class="fl width_582">
	<div class="cell frm_element_wrapper pl14 fl width_582">
		<div class="bdr_c9c9c9">
			<div class="tmailtop_gradient minH60 bdr_e2e2e2 mt1 ml1 mr1">	
				<div class="font_size14 clr_444 ml15 mr15 mt7">
					<div class="fl width_400">
						<?php echo !empty($subject)?$subject:'&nbsp;';?>
					</div>
					<span class=" display_inline fr font_size11 mt3">
						<?php echo dateFormatView($sentDate,'d M Y') ?> 
					</span>													
					<div class="clear"></div>
					<div class="dashbdrstrip"></div>
				</div>			
				<div class="clear"></div>
			</div> <!-- tmailtop_gradient minH60 -->
						
			<div id="show_hide">  												
				<div class="seprator_14"></div>
					<div class="minHeight200px pl16 pr15 clr_444 msgBody">
							<?php echo !empty($msgBody)?$msgBody:'&nbsp;';?>
							<div class="seprator_20"></div>											
						<div class="clear"></div>
					</div>
				</div>  <!-- Show Hide -->
				<div class="tmailtop_gradient mH20 bdr_e2e2e2 mt1 ml1 mr1 "></div>
			</div><!-- bdr_c9c9c9 -->
			
			<div class="seprator_20"></div>
			<div class="tds-button fr"><button onClick="history.go(-1);" onmousedown="mousedown_tds_button(this)" onmouseup="mouseup_tds_button(this)" class="cancel dash_link_hover" type="button" id="cancelButton"><span><div class="fl">Cancel</div> <div class="icon-form-cancel-btn"></div></span></button></div>
			<div id="resend" class="tds-button Fright mr5 mb5"> 
				<a href="<?php echo site_url(SITE_AREA_SETTINGS.'manage_tmail/compose_tmail/'.$messageId);?>"><span><div class="Fleft">Resend</div> <div class="icon-save-btn"></div> </span></a>
			</div>
			
		</div>
		<div class="clear"></div>
	</div>

	<!-- Right side user listing div -->
	<div class="fr width210px">
		<div class="bdr_f15921 ml12 mr40 pt3 pb3 b  width_165">
			<?php echo $this->lang->line('receiverList');?>
		</div>
		<?php
		if(isset($participantsId) && is_array($participantsId)  && count($participantsId) > 0 ){	
		for($i=0;$i<count($participantsId);$i++){
			$getUserShowcaseData= getUserShowcaseDetails($participantsId[$i]);
			if(!empty($getUserShowcaseData->firstName) || !empty($getUserShowcaseData->lastName)){
		?>
			<div class="">
				<div class="fl width_270 ml2 mt10">
					<div class="ml12 mr40 pt3 pb3">
						<div class="fl font_size14 width250px">
							<?php echo $getUserShowcaseData->firstName.' '. $getUserShowcaseData->lastName;?>
						</div>
						<div class="fr font_size12"></div>
						<div class="clear"></div>
					</div>
				</div>
				<div class="clear"></div>
			</div>
		<?php } } } ?>	
	</div>
	<div class="clear"></div>
	</div>
	<!-- Main content Div End -->
<div class="seprator_20"></div>
</div>
