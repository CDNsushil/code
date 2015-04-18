<?php if (!defined('BASEPATH')) exit('No direct script access allowed'); 
// get session value of edit workprofile mode
$isWorkprofileEdit = $this->session->userdata('isWorkprofileEdit');
// set enchor end tag in edit mode
$anchorEnd = '';
$editCls = '';
$isEditWorkprofile = false;
if(!empty($isWorkprofileEdit)) {
	$isEditWorkprofile = true;
	$anchorEnd = '</a>';
	$editCls = 'editWizardTab';
}
// set base url
$baseUrl = base_url(lang().'/workprofile');
?>
	<!--  content wrap  start end -->
	<ul class="TabbedPanelsTabGroup sub_tab">
		<li class="TabbedPanelsTab <?php echo isset($communication1menu)?$communication1menu:'';?>" >
			<?php if($isEditWorkprofile == true) { echo '<a href="'.$baseUrl.'/recommandations">'; } ?>
				<span>A <?php echo $this->lang->line('step1CommunicationMenu');?></span>
			<?php echo $anchorEnd;?>	
		</li>
		<li class="TabbedPanelsTab <?php echo isset($communication2menu)?$communication2menu:'';?>" >
			<?php if($isEditWorkprofile == true) { echo '<a href="'.$baseUrl.'/addcommicationlinks">'; } ?>	
				<span>B <?php echo $this->lang->line('step2CommunicationMenu');?></span>
			<?php echo $anchorEnd;?>	
		</li>
		<li class="TabbedPanelsTab <?php echo isset($communication3menu)?$communication3menu:'';?>" >
			<?php if($isEditWorkprofile == true) { echo '<a href="'.$baseUrl.'/socialmedialinks">'; } ?>
				<span>C <?php echo $this->lang->line('step3CommunicationMenu');?></span>
			<?php echo $anchorEnd;?>	
		</li>
	</ul>
<!-- ================================main tab content  ======================= -->
<?php $this->load->view($subInnerPage1); ?>

<!--  content wrap  end --> 
