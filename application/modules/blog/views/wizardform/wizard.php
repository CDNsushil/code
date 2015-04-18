<?php if (!defined('BASEPATH')) exit('No direct script access allowed'); 
$stageNumber = 1;
// get post session value
$isAddPost = $this->session->userdata('isAddPost'); 
$blogWrapcls = 'blog_wrap';
if(!empty($isAddPost)) {
	$blogWrapcls = '';
}
?>
<!--  content wrap  start end -->
<div class="newlanding_container">
    <div class="<?php echo $blogWrapcls;?>">
        <div id="TabbedPanels1" class="TabbedPanels"> 
			<?php if(empty($isAddPost)) { ?>
				<!--  Tab One -->
				<ul class="TabbedPanelsTabGroup">           
					<li class="TabbedPanelsTab <?php echo isset($b1menu)?$b1menu:'';?>" ><span>Stage <?php echo $stageNumber; $stageNumber = $stageNumber +1;?><?php echo $this->lang->line('stage1BlogSetup');?></span></li>
					<li class="TabbedPanelsTab <?php echo isset($b2menu)?$b2menu:'';?>" ><span>Stage <?php echo $stageNumber; $stageNumber = $stageNumber +1;?><?php echo $this->lang->line('stage2BlogSetup');?></span></li>
					<li class="TabbedPanelsTab <?php echo isset($b3menu)?$b3menu:'';?>"><span>Stage <?php echo $stageNumber; $stageNumber = $stageNumber +1;?><?php echo $this->lang->line('stage3BlogSetup');?></span></li>
					<li class="TabbedPanelsTab <?php echo isset($b4menu)?$b4menu:'';?>"><span>Stage <?php echo $stageNumber; $stageNumber = $stageNumber +1;?><?php echo $this->lang->line('stage4BlogSetup');?></span></li>
				</ul>
           <?php } ?>
            <!-- ================================main tab content  ======================= -->
            <?php $this->load->view($innerPage); ?>
        </div>
    </div>
</div>
<!--  content wrap  end --> 
