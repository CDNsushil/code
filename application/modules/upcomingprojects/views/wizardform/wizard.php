<?php if (!defined('BASEPATH')) exit('No direct script access allowed'); 
$stageNumber = 1;
// get edit status of upcoming
$isUpcomingEdit = $this->session->userdata('isUpcomingEdit'); 
// set enchor end tag in edit mode
$anchorEnd = '';
$editCls = '';
$isEditUpcoming = false;
if(!empty($isUpcomingEdit) && isset($upcomingRes['projId'])) {
	$isEditUpcoming = true;
	$anchorEnd = '</a>';
	$editCls = 'editWizardTab';
	$projId = $upcomingRes['projId'];
}
// set base url
$baseUrl = base_url_lang('upcomingprojects');
?>
<!--  content wrap  start end -->
<div class="newlanding_container">
    <div class="showcase_wizard">
        <div id="TabbedPanels1" class="TabbedPanels"> 
            <!--  Tab One -->
            <ul class="TabbedPanelsTabGroup tab_space0">
                <li class="TabbedPanelsTab <?php echo isset($s1menu)?$s1menu:'';?>">
					<?php if($isEditUpcoming == true) { echo '<a href="'.$baseUrl.'/donation/'.$projId.'">'; } ?>
						<span>Stage <?php echo $stageNumber; $stageNumber = $stageNumber +1;?><?php echo $this->lang->line('stage1UpcomingSetup');?></span>
					<?php echo $anchorEnd;?>
				</li>
                <li class="TabbedPanelsTab <?php echo isset($s2menu)?$s2menu:'';?>">
					<?php if($isEditUpcoming == true) { echo '<a href="'.$baseUrl.'/titlendescription/'.$projId.'">'; } ?>
						<span>Stage <?php echo $stageNumber; $stageNumber = $stageNumber +1;?><?php echo $this->lang->line('stage2UpcomingSetup');?></span>
					<?php echo $anchorEnd;?>
				</li>
                <li class="TabbedPanelsTab <?php echo isset($s3menu)?$s3menu:'';?>">
					<?php if($isEditUpcoming == true) { echo '<a href="'.$baseUrl.'/mediainformation/'.$projId.'">'; } ?>
						<span>Stage <?php echo $stageNumber; $stageNumber = $stageNumber +1;?><?php echo $this->lang->line('stage3UpcomingSetup');?></span>
					<?php echo $anchorEnd;?>
				</li>
                <li class="TabbedPanelsTab <?php echo isset($s4menu)?$s4menu:'';?>">
					<?php if($isEditUpcoming == true) { echo '<a href="'.$baseUrl.'/creativeteam/'.$projId.'">'; } ?>	
						<span>Stage <?php echo $stageNumber; $stageNumber = $stageNumber +1;?><?php echo $this->lang->line('stage4UpcomingSetup');?></span>
					<?php echo $anchorEnd;?>
				</li>
                <li class="TabbedPanelsTab <?php echo isset($s5menu)?$s5menu:'';?>">
					<?php if($isEditUpcoming == true) { echo '<a href="'.$baseUrl.'/promotionalimages/'.$projId.'">'; } ?>	
						<span>Stage <?php echo $stageNumber; $stageNumber = $stageNumber +1;?><?php echo $this->lang->line('stage5UpcomingSetup');?></span>
					<?php echo $anchorEnd;?>
				</li>
				<li class="TabbedPanelsTab <?php echo isset($s6menu)?$s6menu:'';?>">
					<?php if($isEditUpcoming == true) { echo '<a href="'.$baseUrl.'/previewpublish/'.$projId.'">'; } ?>
						<span>Stage <?php echo $stageNumber; $stageNumber = $stageNumber +1;?><?php echo $this->lang->line('stage6UpcomingSetup');?></span>
					<?php echo $anchorEnd;?>
				</li>
            </ul>
           
            <!-- ================================main tab content  ======================= -->
            <?php
             $this->load->view($innerPage); ?>
        </div>
    </div>
</div>
<!--  content wrap  end --> 
