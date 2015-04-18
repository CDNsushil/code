<?php if (!defined('BASEPATH')) exit('No direct script access allowed'); 
$stageNumber = 1;
$menuTitle = 'Step';
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
<ul class="TabbedPanelsTabGroup sub_tab  tab_space0">
    <li class="TabbedPanelsTab <?php echo isset($step1SummaryMenu)?$step1SummaryMenu:'';?>" >
		<?php if($isEditWorkprofile == true) { echo '<a href="'.$baseUrl.'/professionsummary">'; } ?>
			<span><?php echo $menuTitle;?> <?php echo $stageNumber; $stageNumber = $stageNumber +1;?><?php echo $this->lang->line('step1SummaryMenu');?></span>
		<?php echo $anchorEnd;?>
	</li>
   
    <li class="TabbedPanelsTab <?php echo isset($step2SummaryMenu)?$step2SummaryMenu:'';?>" >
		<?php if($isEditWorkprofile == true) { echo '<a href="'.$baseUrl.'/skills">'; } ?>
			<span><?php echo $menuTitle;?> <?php echo $stageNumber; $stageNumber = $stageNumber +1;?><?php echo $this->lang->line('step2SummaryMenu');?></span>
		<?php echo $anchorEnd;?>
	</li>
   
    <li class="TabbedPanelsTab <?php echo isset($step3SummaryMenu)?$step3SummaryMenu:'';?>" >
		<?php if($isEditWorkprofile == true) { echo '<a href="'.$baseUrl.'/typeofworksort">'; } ?>
			<span><?php echo $menuTitle;?> <?php echo $stageNumber; $stageNumber = $stageNumber +1;?><?php echo $this->lang->line('step3SummaryMenu');?></span>
		<?php echo $anchorEnd;?>
	</li>
	
	<li class="TabbedPanelsTab <?php echo isset($step4SummaryMenu)?$step4SummaryMenu:'';?>" >
		<?php if($isEditWorkprofile == true) { echo '<a href="'.$baseUrl.'/worklocation">'; } ?>
			<span><?php echo $menuTitle;?> <?php echo $stageNumber; $stageNumber = $stageNumber +1;?><?php echo $this->lang->line('step4SummaryMenu');?></span>
		<?php echo $anchorEnd;?>
	</li>  
</ul>
<!-- ================================main tab content  ======================= -->
<?php $this->load->view($subInnerPage); ?>

<!--  content wrap  end --> 
