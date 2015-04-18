<?php if (!defined('BASEPATH')) exit('No direct script access allowed'); 
$stageNumber = 1;
$isBusiness = '';
$tabClass = '';
if(isset($isEnterprise)) {
    $isBusiness = 'Business'; 
    $tabClass = 'tab_space0';
}
// get session value of edit showcase mode
$isShowcaseEdit = $this->session->userdata('isShowcaseEdit');
// set enchor end tag in edit mode
$anchorEnd = '';
$editCls = '';
$isEditShowcase = false;
if(!empty($isShowcaseEdit)) {
	$isEditShowcase = true;
	$anchorEnd = '</a>';
	$editCls = 'editWizardTab';
}
// set base url
$baseUrl = base_url(lang().'/showcase');
?>
<!--  content wrap  start end -->
<div class="newlanding_container">
    <div class="showcase_wizard">
        <div id="TabbedPanels1" class="TabbedPanels <?php echo $editCls;?>"> 
            <!--  Tab One -->
            <ul class="TabbedPanelsTabGroup <?php echo  $tabClass;?>">
                <li class="TabbedPanelsTab <?php echo isset($s1menu)?$s1menu:'';?>" >
					<?php if($isEditShowcase == true) { echo '<a href="'.$baseUrl.'/showcasetype">'; } ?>
						<span>Stage <?php echo $stageNumber; $stageNumber = $stageNumber +1;?><?php echo $this->lang->line('stage1ShowcaseSetup'.$isBusiness);?></span>
					<?php echo $anchorEnd;?>
				</li>
                <li class="TabbedPanelsTab <?php echo isset($s2menu)?$s2menu:'';?>" >
					<?php if($isEditShowcase == true) { echo '<a href="'.$baseUrl.'/aboutyou">'; } ?>
						<span>Stage <?php echo $stageNumber; $stageNumber = $stageNumber +1;?><?php echo $this->lang->line('stage2ShowcaseSetup'.$isBusiness);?></span>
					<?php echo $anchorEnd;?>
				</li>
                <li class="TabbedPanelsTab <?php echo isset($s3menu)?$s3menu:'';?>">
					<?php if($isEditShowcase == true) { echo '<a href="'.$baseUrl.'/yourvideo">'; } ?>
						<span>Stage <?php echo $stageNumber; $stageNumber = $stageNumber +1;?><?php echo $this->lang->line('stage3ShowcaseSetup'.$isBusiness);?></span>
					<?php echo $anchorEnd;?>
				</li>
                <li class="TabbedPanelsTab <?php echo isset($s4menu)?$s4menu:'';?>">
					<?php if($isEditShowcase == true) { echo '<a href="'.$baseUrl.'/communication">'; } ?>
						<span>Stage <?php echo $stageNumber; $stageNumber = $stageNumber +1;?><?php echo $this->lang->line('stage4ShowcaseSetup'.$isBusiness);?></span>
					<?php echo $anchorEnd;?>
				</li>
                <li class="TabbedPanelsTab <?php echo isset($s5menu)?$s5menu:'';?>">
					<?php if($isEditShowcase == true) { echo '<a href="'.$baseUrl.'/publishshowcase">'; } ?>
						<span>Stage <?php echo $stageNumber; $stageNumber = $stageNumber +1;?><?php echo $this->lang->line('stage5ShowcaseSetup'.$isBusiness);?></span>
					<?php echo $anchorEnd;?>
				</li>
            </ul>
           
            <!-- ================================main tab content  ======================= -->
            <?php $this->load->view($innerPage); ?>
        </div>
    </div>
</div>
<!--  content wrap  end --> 
