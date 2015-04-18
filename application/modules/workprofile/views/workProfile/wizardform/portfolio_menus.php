<?php if (!defined('BASEPATH')) exit('No direct script access allowed'); 
$menuTitle = 'Stage ';
$stageNumber =1;?>
<!--  content wrap  start end -->
<div class="newlanding_container">
	<div class="showcase_wizard">
        <div id="TabbedPanels1" class="TabbedPanels"> 
            <!--  Tab One -->
            <ul class="TabbedPanelsTabGroup">
				<li class="TabbedPanelsTab <?php echo isset($portfolio1menu)?$portfolio1menu:'';?>" ><span><?php echo $menuTitle;?> <?php echo $stageNumber; $stageNumber = $stageNumber +1;?> <?php echo $this->lang->line('step1PortfolioMenu');?></span></li>
				<li class="TabbedPanelsTab <?php echo isset($portfolio2menu)?$portfolio2menu:'';?>" ><span><?php echo $menuTitle;?> <?php echo $stageNumber; $stageNumber = $stageNumber +1;?> <?php echo $this->lang->line('step2PortfolioMenu');?></span></li>
				<li class="TabbedPanelsTab <?php echo isset($portfolio3menu)?$portfolio3menu:'';?>" ><span><?php echo $menuTitle;?> <?php echo $stageNumber; $stageNumber = $stageNumber +1;?> <?php echo $this->lang->line('step3PortfolioMenu');?></span></li>
				<li class="TabbedPanelsTab <?php echo isset($s5menu)?$s5menu:'';?>"><span><?php echo $menuTitle;?> <?php echo $stageNumber; $stageNumber = $stageNumber +1;?><?php echo $this->lang->line('stage5WorkprofileSetup');?></span></li>
			</ul>
			<!-- ================================main tab content  ======================= -->
            <?php
             $this->load->view($innerPage); ?>
        </div>
    </div>
</div>

<!--  content wrap  end --> 
