<?php if (!defined('BASEPATH')) exit('No direct script access allowed'); 
$stageNumber = 1;
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
<div class="newlanding_container">
    <div class="showcase_wizard">
        <div id="TabbedPanels1" class="TabbedPanels"> 
            <!--  Tab One -->
            <ul class="TabbedPanelsTabGroup">
                <li class="TabbedPanelsTab <?php echo isset($s1menu)?$s1menu:'';?>">
					<?php if($isEditWorkprofile == true) { echo '<a href="'.$baseUrl.'/yourdetails">'; } ?>
						<span>Stage <?php echo $stageNumber; $stageNumber = $stageNumber +1;?><?php echo $this->lang->line('stage1WorkprofileSetup');?></span>
					<?php echo $anchorEnd;?>
				</li>
                <li class="TabbedPanelsTab <?php echo isset($s2menu)?$s2menu:'';?>">
					<?php if($isEditWorkprofile == true) { echo '<a href="'.$baseUrl.'/professionsummary">'; } ?>
						<span>Stage <?php echo $stageNumber; $stageNumber = $stageNumber +1;?><?php echo $this->lang->line('stage2WorkprofileSetup');?></span>
					<?php echo $anchorEnd;?>
				</li>
                <li class="TabbedPanelsTab <?php echo isset($s3menu)?$s3menu:'';?>">
					<?php if($isEditWorkprofile == true) { echo '<a href="'.$baseUrl.'/education">'; } ?>
						<span>Stage <?php echo $stageNumber; $stageNumber = $stageNumber +1;?><?php echo $this->lang->line('stage3WorkprofileSetup');?></span>
					<?php echo $anchorEnd;?>
				</li>
                <!--<li class="TabbedPanelsTab <?php //echo isset($s4menu)?$s4menu:'';?>"><span>Stage <?php //echo $stageNumber; $stageNumber = $stageNumber +1;?><?php //echo $this->lang->line('stage4WorkprofileSetup');?></span></li>-->
				<li class="TabbedPanelsTab <?php echo isset($s5menu)?$s5menu:'';?>">
					<?php if($isEditWorkprofile == true) { echo '<a href="'.$baseUrl.'/previewprofile">'; } ?>
						<span>Stage <?php echo $stageNumber; $stageNumber = $stageNumber +1;?><?php echo $this->lang->line('stage5WorkprofileSetup');?></span>
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
