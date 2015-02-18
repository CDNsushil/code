<?php if (!defined('BASEPATH')) exit('No direct script access allowed'); 
$stageNumber = 1;
?>
<!--  content wrap  start end -->
<ul class="TabbedPanelsTabGroup sub_tab">
    <li class="TabbedPanelsTab <?php echo isset($showcaseType1menu)?$showcaseType1menu:'';?>" ><span>Stage <?php echo $stageNumber; $stageNumber = $stageNumber +1;?><?php echo $this->lang->line('stage1ShowcaseType');?></span></li>
    <li class="TabbedPanelsTab <?php echo isset($showcaseType2menu)?$showcaseType2menu:'';?>" ><span>Stage <?php echo $stageNumber; $stageNumber = $stageNumber +1;?><?php echo $this->lang->line('stage2ShowcaseType');?></span></li>
    <?php //if(isset($isEnterprise)) { ?>
    <li class="TabbedPanelsTab <?php echo isset($showcaseType3menu)?$showcaseType3menu:'';?>" ><span>Stage <?php echo $stageNumber; $stageNumber = $stageNumber +1;?><?php echo $this->lang->line('stage3ShowcaseType');?></span></li>
    <?php //} ?>
</ul>
<!-- ================================main tab content  ======================= -->
<?php $this->load->view($subInnerPage); ?>

<!--  content wrap  end --> 
