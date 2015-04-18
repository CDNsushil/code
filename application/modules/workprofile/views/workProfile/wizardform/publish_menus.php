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
    <li class="TabbedPanelsTab <?php echo isset($publish1Menu)?$publish1Menu:'';?>" >
		<?php if($isEditWorkprofile == true) { echo '<a href="'.$baseUrl.'/previewprofile">'; } ?>
			<span><?php echo $menuTitle;?> <?php echo $stageNumber; $stageNumber = $stageNumber +1;?><?php echo $this->lang->line('step1PublishMenu');?></span>
		<?php echo $anchorEnd;?>
	</li>
    <li class="TabbedPanelsTab <?php echo isset($publish2Menu)?$publish2Menu:'';?>" >
		<?php if($isEditWorkprofile == true) { echo '<a href="'.$baseUrl.'/emaillink">'; } ?>
			<span><?php echo $menuTitle;?> <?php echo $stageNumber; $stageNumber = $stageNumber +1;?><?php echo $this->lang->line('step2PublishMenu');?></span>
		<?php echo $anchorEnd;?>
	</li>
    <li class="TabbedPanelsTab <?php echo isset($publish3Menu)?$publish3Menu:'';?>" >
		<?php if($isEditWorkprofile == true) { echo '<a href="'.$baseUrl.'/addbutton">'; } ?>
			<span><?php echo $menuTitle;?> <?php echo $stageNumber; $stageNumber = $stageNumber +1;?><?php echo $this->lang->line('step3PublishMenu');?></span>
		<?php echo $anchorEnd;?>
	</li>
	<li class="TabbedPanelsTab <?php echo isset($publish4Menu)?$publish4Menu:'';?>" >
		<?php if($isEditWorkprofile == true) { echo '<a href="'.$baseUrl.'/downloadapp">'; } ?>	
			<span><?php echo $menuTitle;?> <?php echo $stageNumber; $stageNumber = $stageNumber +1;?><?php echo $this->lang->line('step4PublishMenu');?></span>
		<?php echo $anchorEnd;?>
	</li>  
</ul>
<!-- ================================main tab content  ======================= -->
<?php $this->load->view($subInnerPage); ?>

<!--  content wrap  end --> 
