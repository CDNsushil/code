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
		<li class="TabbedPanelsTab <?php echo isset($personal1menu)?$personal1menu:'';?>" >
			<?php if($isEditWorkprofile == true) { echo '<a href="'.$baseUrl.'/personaldetails">'; } ?>
				<span>A <?php echo $this->lang->line('step1PersonalMenu');?></span>
			<?php echo $anchorEnd;?>	
		</li>
		<li class="TabbedPanelsTab <?php echo isset($personal2menu)?$personal2menu:'';?>" >
			<?php if($isEditWorkprofile == true) { echo '<a href="'.$baseUrl.'/personalinterests">'; } ?>
				<span>B <?php echo $this->lang->line('step2PersonalMenu');?></span>
			<?php echo $anchorEnd;?>
		</li>
	</ul>
<!-- ================================main tab content  ======================= -->
<?php $this->load->view($subInnerPage1); ?>

<!--  content wrap  end --> 
