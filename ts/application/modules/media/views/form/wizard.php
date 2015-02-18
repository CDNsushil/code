<?php if (!defined('BASEPATH')) exit('No direct script access allowed'); 
$stageNumber = 1;
$addSpaceProjectId = $this->session->userdata('addSpaceProjectId');
?>
<!--  content wrap  start end -->
<div class="newlanding_container">
	<div class="wizard_wrap fs14">
		<div class="TabbedPanels " id="TabbedPanels1">
            <?php if(empty($addSpaceProjectId)) { ?>
                <ul id="man_haedtab" class="TabbedPanelsTabGroup pt16 mb10 position_relative z_index_3">
                    <li class="TabbedPanelsTab <?php echo $s1menu = isset($s1menu)?$s1menu:'';?>" ><span> Stage <?php echo $stageNumber; $stageNumber = $stageNumber +1;?><?php echo $this->lang->line('stage1MediaShowcaseSetup');?></span></li>
                    <?php 
                    if((strpos($s1menu, 'frist_1') === false)) {
                        $projSellstatus = (isset($projSellstatus) && $projSellstatus == 'f')?'f':'t';
                        if($projSellstatus =='t'){ ?>
                            <li class="TabbedPanelsTab <?php echo isset($s2menu)?$s2menu:'';?>" ><span>Stage <?php echo $stageNumber; $stageNumber = $stageNumber +1;?><?php echo $this->lang->line('stage2MediaShowcaseSetup');?></span></li>
                            <?php 
                        }
                        ?>
                        <li class="TabbedPanelsTab <?php echo isset($s3menu)?$s3menu:'';?>"><span>Stage <?php echo $stageNumber; $stageNumber = $stageNumber +1;?><?php echo $this->lang->line('stage3MediaShowcaseSetup');?></span></li>
                        <li class="TabbedPanelsTab <?php echo isset($s4menu)?$s4menu:'';?>"><span>Stage <?php echo $stageNumber; $stageNumber = $stageNumber +1;?><?php echo $this->lang->line('stage4MediaShowcaseSetup');?></span></li>
                        <li class="TabbedPanelsTab <?php echo isset($s5menu)?$s5menu:'';?>"><span>Stage <?php echo $stageNumber; $stageNumber = $stageNumber +1;?><?php echo $this->lang->line('stage5MediaShowcaseSetup');?></span></li>
                        <?php
                    }?>
                </ul>
            <?php
            } ?>
			<!-- ================================main tab content  ======================= -->
			<div class="TabbedPanelsContentGroup main_tab m_auto"> 
				<div class="TabbedPanelsContent  TabbedPanelsContentVisible tab_setting Upload_wrap" style="display: block;">
                    <?php $this->load->view($innerPage); ?>
				</div>
			</div>
		</div>
	</div>
</div>
<!--  content wrap  end --> 
