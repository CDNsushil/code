<?php if (!defined('BASEPATH')) exit('No direct script access allowed'); 
$stageNumber = 1;
// get blog edit session value
$isEditBlog = $this->session->userdata('isEditBlog');
if(empty($isEditBlog)) { 
?>
	<!--  content wrap  start end -->
	<ul class="TabbedPanelsTabGroup sub_tab">
		<li class="TabbedPanelsTab <?php echo isset($bCover1menu)?$bCover1menu:'';?>" ><span>Step <?php echo $stageNumber; $stageNumber = $stageNumber +1;?><?php echo $this->lang->line('stage1BlogCover');?></span></li>
		<li class="TabbedPanelsTab <?php echo isset($bCover2menu)?$bCover2menu:'';?>" ><span>Step <?php echo $stageNumber; $stageNumber = $stageNumber +1;?><?php echo $this->lang->line('stage2BlogCover');?></span></li>
		<li class="TabbedPanelsTab <?php echo isset($bCover3menu)?$bCover3menu:'';?>" ><span>Step <?php echo $stageNumber; $stageNumber = $stageNumber +1;?><?php echo $this->lang->line('stage3BlogCover');?></span></li>
		<li class="TabbedPanelsTab <?php echo isset($bCover4menu)?$bCover4menu:'';?>" ><span>Step <?php echo $stageNumber; $stageNumber = $stageNumber +1;?><?php echo $this->lang->line('stage4BlogCover');?></span></li>  
	</ul>
<?php } ?>
<!-- ================================main tab content  ======================= -->
<?php $this->load->view($subInnerPage); ?>

<!--  content wrap  end --> 
