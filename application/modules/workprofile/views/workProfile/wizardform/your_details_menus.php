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
<ul class="TabbedPanelsTabGroup sub_tab">
    <li class="TabbedPanelsTab <?php echo isset($step1DetailsMenu)?$step1DetailsMenu:'';?>" >
		<?php if($isEditWorkprofile == true) { echo '<a href="'.$baseUrl.'/yourdetails">'; } ?>
			<span><?php echo $menuTitle;?> <?php echo $stageNumber; $stageNumber = $stageNumber +1;?><?php echo $this->lang->line('step1DetailsMenu');?></span>
		<?php echo $anchorEnd;?>
	</li>
    <li class="TabbedPanelsTab <?php echo isset($step2DetailsMenu)?$step2DetailsMenu:'';?>" >
		<?php if($isEditWorkprofile == true) { echo '<a href="'.$baseUrl.'/contactdetails">'; } ?>
			<span><?php echo $menuTitle;?> <?php echo $stageNumber; $stageNumber = $stageNumber +1;?><?php echo $this->lang->line('step2DetailsMenu');?></span>
		<?php echo $anchorEnd;?>
	</li>
    <li class="TabbedPanelsTab <?php echo isset($step3DetailsMenu)?$step3DetailsMenu:'';?>" ><span>
		<?php if($isEditWorkprofile == true) { echo '<a href="'.$baseUrl.'/personaldetails">'; } ?>
			<?php echo $menuTitle;?> <?php echo $stageNumber; $stageNumber = $stageNumber +1;?><?php echo $this->lang->line('step3DetailsMenu');?></span>
		<?php echo $anchorEnd;?>
	</li>
	<li class="TabbedPanelsTab <?php echo isset($step4DetailsMenu)?$step4DetailsMenu:'';?>" >
		<?php if($isEditWorkprofile == true) { echo '<a href="'.$baseUrl.'/recommandations">'; } ?>
			<span><?php echo $menuTitle;?> <?php echo $stageNumber; $stageNumber = $stageNumber +1;?><?php echo $this->lang->line('step4DetailsMenu');?></span>
		<?php echo $anchorEnd;?>
	</li>  
</ul>
<!-- ================================main tab content  ======================= -->
<?php $this->load->view($subInnerPage); ?>

<!--  content wrap  end --> 
