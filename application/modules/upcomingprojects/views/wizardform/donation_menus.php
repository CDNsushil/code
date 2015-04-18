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
    <li class="TabbedPanelsTab <?php echo isset($step1DonationMenu)?$step1DonationMenu:'';?>" >
		<?php if($isEditUpcoming == true) { echo '<a href="'.$baseUrl.'/currency/'.$projId.'">'; } ?>	
			<span><?php echo $menuTitle;?> <?php echo $stageNumber; $stageNumber = $stageNumber +1;?><?php echo $this->lang->line('step1Donation');?></span>
		<?php echo $anchorEnd;?>
	</li>
    <li class="TabbedPanelsTab <?php echo isset($step2DonationMenu)?$step2DonationMenu:'';?>" >
		<?php if($isEditUpcoming == true) { echo '<a href="'.$baseUrl.'/consumptiontax/'.$projId.'">'; } ?>	
			<span><?php echo $menuTitle;?> <?php echo $stageNumber; $stageNumber = $stageNumber +1;?><?php echo $this->lang->line('step2Donation');?></span>
		<?php echo $anchorEnd;?>
	</li>
    <li class="TabbedPanelsTab <?php echo isset($step3DonationMenu)?$step3DonationMenu:'';?>" >
		<?php if($isEditUpcoming == true) { echo '<a href="'.$baseUrl.'/sellerpaypal/'.$projId.'">'; } ?>	
			<span><?php echo $menuTitle;?> <?php echo $stageNumber; $stageNumber = $stageNumber +1;?><?php echo $this->lang->line('step3Donation');?></span>
		<?php echo $anchorEnd;?>
	</li>	
	<li class="TabbedPanelsTab <?php echo isset($step4DonationMenu)?$step4DonationMenu:'';?>" >
		<?php if($isEditUpcoming == true) { echo '<a href="'.$baseUrl.'/sellersetting/'.$projId.'">'; } ?>	
			<span><?php echo $menuTitle;?> <?php echo $stageNumber; $stageNumber = $stageNumber +1;?><?php echo $this->lang->line('step4Donation');?></span>
		<?php echo $anchorEnd;?>
	</li>  
</ul>
<!-- ================================main tab content  ======================= -->
<?php $this->load->view($subInnerPage); ?>

<!--  content wrap  end --> 
