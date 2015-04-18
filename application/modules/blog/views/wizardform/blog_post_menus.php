<?php if (!defined('BASEPATH')) exit('No direct script access allowed'); 
$stageNumber = 1;
$menuTitle = 'Step';
$subMenuClass = 'sub_tab';
// get post session value
$isAddPost = $this->session->userdata('isAddPost'); 
if(!empty($isAddPost)) { 
	$menuTitle = 'Stage';
	$subMenuClass = '';
}
?>
<!--  content wrap  start end -->
<ul class="TabbedPanelsTabGroup <?php echo $subMenuClass ;?>">
    <li class="TabbedPanelsTab <?php echo isset($bPost1menu)?$bPost1menu:'';?>" ><span><?php echo $menuTitle;?> <?php echo $stageNumber; $stageNumber = $stageNumber +1;?><?php echo $this->lang->line('stage1BlogPost');?></span></li>
    <li class="TabbedPanelsTab <?php echo isset($bPost2menu)?$bPost2menu:'';?>" ><span><?php echo $menuTitle;?> <?php echo $stageNumber; $stageNumber = $stageNumber +1;?><?php echo $this->lang->line('stage2BlogPost');?></span></li>
    <li class="TabbedPanelsTab <?php echo isset($bPost3menu)?$bPost3menu:'';?>" ><span><?php echo $menuTitle;?> <?php echo $stageNumber; $stageNumber = $stageNumber +1;?><?php echo $this->lang->line('stage3BlogPost');?></span></li>
	<li class="TabbedPanelsTab <?php echo isset($bPost4menu)?$bPost4menu:'';?>" ><span><?php echo $menuTitle;?> <?php echo $stageNumber; $stageNumber = $stageNumber +1;?><?php echo $this->lang->line('stage4BlogPost');?></span></li>  
	<?php if(!empty($isAddPost)) { ?>
		<li class="TabbedPanelsTab <?php echo isset($bPost5menu)?$bPost5menu:'';?>" ><span><?php echo $menuTitle;?> <?php echo $stageNumber; $stageNumber = $stageNumber +1;?><?php echo $this->lang->line('stage5BlogPost');?></span></li>  
	<?php } ?>
</ul>
<!-- ================================main tab content  ======================= -->
<?php $this->load->view($subInnerPage); ?>

<!--  content wrap  end --> 
