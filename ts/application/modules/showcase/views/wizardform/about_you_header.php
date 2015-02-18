<?php if (!defined('BASEPATH')) exit('No direct script access allowed'); 
$stageNumber = 1;
$isBusiness = '';
$tabClass = '';
if(isset($isEnterprise)) {
    $isBusiness = 'Business'; 
    $tabClass = 'sub_tab';
}
?>
<!--  content wrap  start end -->
<ul class="TabbedPanelsTabGroup sub_tab tab_space0 tab_sap5  <?php //echo  $tabClass;?>">
    <li class="TabbedPanelsTab <?php echo isset($aboutYou1menu)?$aboutYou1menu:'';?>" ><span>Stage <?php echo $stageNumber; $stageNumber = $stageNumber +1;?><?php echo $this->lang->line('stage1AboutYou'.$isBusiness);?></span></li>
    <li class="TabbedPanelsTab <?php echo isset($aboutYou2menu)?$aboutYou2menu:'';?>" ><span>Stage <?php echo $stageNumber; $stageNumber = $stageNumber +1;?><?php echo $this->lang->line('stage2AboutYou'.$isBusiness);?></span></li>
    <li class="TabbedPanelsTab <?php echo isset($aboutYou3menu)?$aboutYou3menu:'';?>" ><span>Stage <?php echo $stageNumber; $stageNumber = $stageNumber +1;?><?php echo $this->lang->line('stage3AboutYou'.$isBusiness);?></span></li>
    <?php if(!isset($isFans)) { ?>
        <li class="TabbedPanelsTab <?php echo isset($aboutYou4menu)?$aboutYou4menu:'';?>" ><span>Stage <?php echo $stageNumber; $stageNumber = $stageNumber +1;?><?php echo $this->lang->line('stage4AboutYou'.$isBusiness);?></span></li>
    <?php } ?>
    <li class="TabbedPanelsTab <?php echo isset($aboutYou5menu)?$aboutYou5menu:'';?>" ><span>Stage <?php echo $stageNumber; $stageNumber = $stageNumber +1;?><?php echo $this->lang->line('stage5AboutYou'.$isBusiness);?></span></li>
</ul>
<!-- ================================main tab content  ======================= -->
<?php $this->load->view($subInnerPage); ?>

<!--  content wrap  end --> 
