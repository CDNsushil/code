<?php if (!defined('BASEPATH')) exit('No direct script access allowed'); 
$stageNumber = 1;
$menuTitle = 'Step';
// get edit status of upcoming
$isUpcomingEdit = $this->session->userdata('isUpcomingEdit'); 
// set enchor end tag in edit mode
$anchorEnd = '';
$isEditUpcoming = false;
if(!empty($isUpcomingEdit) && isset($upcomingRes['projId'])) {
	$isEditUpcoming = true;
	$anchorEnd = '</a>';
	$projId = $upcomingRes['projId'];
}
// set base url
$baseUrl = base_url_lang('upcomingprojects');
?>
<!--  content wrap  start end -->
<ul class="TabbedPanelsTabGroup sub_tab">
    <li class="TabbedPanelsTab <?php echo isset($step1PromotionalMenu)?$step1PromotionalMenu:'';?>" >
		<?php if($isEditUpcoming == true) { echo '<a href="'.$baseUrl.'/promotionalimages/'.$projId.'">'; } ?>
			<span><?php echo $menuTitle;?> <?php echo $stageNumber; $stageNumber = $stageNumber +1;?><?php echo $this->lang->line('step1PromotionalMedia');?></span>
		<?php echo $anchorEnd;?>
	</li>
    <li class="TabbedPanelsTab <?php echo isset($step2PromotionalMenu)?$step2PromotionalMenu:'';?>" >
		<?php if($isEditUpcoming == true) { echo '<a href="'.$baseUrl.'/introductorymedia/'.$projId.'">'; } ?>
			<span><?php echo $menuTitle;?> <?php echo $stageNumber; $stageNumber = $stageNumber +1;?><?php echo $this->lang->line('step2PromotionalMedia');?></span>
		<?php echo $anchorEnd;?>
	</li>
</ul>
<!-- ================================main tab content  ======================= -->
<?php $this->load->view($subInnerPage); ?>

<!--  content wrap  end --> 
