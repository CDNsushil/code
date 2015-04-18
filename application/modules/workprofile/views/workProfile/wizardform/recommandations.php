<?php if (!defined('BASEPATH')) exit('No direct script access allowed'); 

// set base url
$baseUrl = base_url(lang().'/workprofile/');
// set modify button
$manageRecButton   =   array(
	'name'        =>  'recommandationBtn',
	'id'          =>  'recommandationBtn',
	'content'     =>  $this->lang->line('manageRecommandation'),
	'class'       =>  'fr  back_click_1 bg_F0F0F0',
	'type'        =>  'button',
);
?>
<div class="TabbedPanelsContent wizard_wrap tab_setting width635 m_auto clearb">
	<div class="c_1">
	   <ul class="form_img mt25">
			<li>
				<h4 class="red fs20  bb_aeaeae"> <?php echo $this->lang->line('addRecommandation')?> </h4>
				<p>
					<?php echo $this->lang->line('recommandationContentNote');?>
				</p>
			</li>
						 
			<li>
				<p>
					<a href="<?php echo base_url(lang().'/showcase/managerecommendations'); ?>" target="_blank">
						<?php echo form_button($manageRecButton); ?>
					</a>
				</p>
			</li>
	   </ul>
	   <ul class="pt20 clearb">
			<li class="icon_2"><?php echo $this->lang->line('recommandationFooterNote');?> </li>
		</ul>
	</div>
 
    <!-- Form buttons -->
   <?php 
	// set back url
	$data['backPage'] = '/workprofile/personalinterests';
	// set next form name
	$data['isNextstep'] = 1;
	$data['nextPage'] = '/workprofile/addcommicationlinks';
	$this->load->view('workProfile/wizardform/common_buttons',$data);
	?>	
</div>
