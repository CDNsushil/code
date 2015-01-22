<?php if (!defined('BASEPATH')) exit('No direct script access allowed'); 
$stageNumber = 1;
$isBusiness = '';
$tabClass = '';
if(isset($isEnterprise)) {
    $isBusiness = 'Business'; 
    $tabClass = 'tab_space0';
}
?>
<!--  content wrap  start end -->
<div class="newlanding_container">
    <div class="showcase_wizard">
        <div id="TabbedPanels1" class="TabbedPanels"> 
            <!--  Tab One -->
            <ul class="TabbedPanelsTabGroup <?php echo  $tabClass;?>">
                <li class="TabbedPanelsTab <?php echo isset($s1menu)?$s1menu:'';?>" ><span>Stage <?php echo $stageNumber; $stageNumber = $stageNumber +1;?><?php echo $this->lang->line('stage1ShowcaseSetup'.$isBusiness);?></span></li>
                <li class="TabbedPanelsTab <?php echo isset($s2menu)?$s2menu:'';?>" ><span>Stage <?php echo $stageNumber; $stageNumber = $stageNumber +1;?><?php echo $this->lang->line('stage2ShowcaseSetup'.$isBusiness);?></span></li>
                <li class="TabbedPanelsTab <?php echo isset($s3menu)?$s3menu:'';?>"><span>Stage <?php echo $stageNumber; $stageNumber = $stageNumber +1;?><?php echo $this->lang->line('stage3ShowcaseSetup'.$isBusiness);?></span></li>
                <li class="TabbedPanelsTab <?php echo isset($s4menu)?$s4menu:'';?>"><span>Stage <?php echo $stageNumber; $stageNumber = $stageNumber +1;?><?php echo $this->lang->line('stage4ShowcaseSetup'.$isBusiness);?></span></li>
                <li class="TabbedPanelsTab <?php echo isset($s5menu)?$s5menu:'';?>"><span>Stage <?php echo $stageNumber; $stageNumber = $stageNumber +1;?><?php echo $this->lang->line('stage5ShowcaseSetup'.$isBusiness);?></span></li>
            </ul>
           
            <!-- ================================main tab content  ======================= -->
            <?php $this->load->view($innerPage); ?>
        </div>
    </div>
</div>
<!--  content wrap  end --> 
