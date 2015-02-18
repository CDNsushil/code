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
<ul class="TabbedPanelsTabGroup  sub_tab tab_space0">
    <li class="TabbedPanelsTab <?php echo isset($communication1menu)?$communication1menu:'';?>" ><span>Step <?php echo $stageNumber; $stageNumber = $stageNumber +1;?><?php echo $this->lang->line('communicationMenu1');?></span></li>
    <li class="TabbedPanelsTab <?php echo isset($communication2menu)?$communication2menu:'';?>" ><span>Step <?php echo $stageNumber; $stageNumber = $stageNumber +1;?><?php echo $this->lang->line('communicationMenu2');?></span></li>
    <li class="TabbedPanelsTab <?php echo isset($communication3menu)?$communication3menu:'';?>" ><span>Step <?php echo $stageNumber; $stageNumber = $stageNumber +1;?><?php echo $this->lang->line('communicationMenu3');?></span></li>
 
  </ul>
<!-- ================================main tab content  ======================= -->
<?php $this->load->view($subInnerPage); ?>

<!--  content wrap  end --> 
