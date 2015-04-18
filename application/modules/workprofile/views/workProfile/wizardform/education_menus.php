<?php if (!defined('BASEPATH')) exit('No direct script access allowed'); 
$menuTitle = 'Step ';
$stageNumber =1;
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
	<li class="TabbedPanelsTab <?php echo isset($education1menu)?$education1menu:'';?>" >
		<?php if($isEditWorkprofile == true) { echo '<a href="'.$baseUrl.'/education">'; } ?>
			<span><?php echo $menuTitle;?> <?php echo $stageNumber; $stageNumber = $stageNumber +1;?> <?php echo $this->lang->line('step1EducationMenu');?></span>
		<?php echo $anchorEnd;?>
	</li>
	<li class="TabbedPanelsTab <?php echo isset($education2menu)?$education2menu:'';?>" >
		<?php if($isEditWorkprofile == true) { echo '<a href="'.$baseUrl.'/employment">'; } ?>	
			<span><?php echo $menuTitle;?> <?php echo $stageNumber; $stageNumber = $stageNumber +1;?> <?php echo $this->lang->line('step2EducationMenu');?></span>
		<?php echo $anchorEnd;?>
	</li>
	<li class="TabbedPanelsTab <?php echo isset($education3menu)?$education3menu:'';?>" >
		<?php if($isEditWorkprofile == true) { echo '<a href="'.$baseUrl.'/refrences">'; } ?>
			<span><?php echo $menuTitle;?> <?php echo $stageNumber; $stageNumber = $stageNumber +1;?> <?php echo $this->lang->line('step3EducationMenu');?></span>
		<?php echo $anchorEnd;?>
	</li>
	<li class="TabbedPanelsTab <?php echo isset($education4menu)?$education4menu:'';?>" >
		<?php if($isEditWorkprofile == true) { echo '<a href="'.$baseUrl.'/achivments">'; } ?>	
			<span><?php echo $menuTitle;?> <?php echo $stageNumber; $stageNumber = $stageNumber +1;?> <?php echo $this->lang->line('step4EducationMenu');?></span>
		<?php echo $anchorEnd;?>
	</li>
</ul>
<!-- ================================main tab content  ======================= -->
<?php $this->load->view($subInnerPage); ?>

<!--  content wrap  end --> 
