<?php if (!defined('BASEPATH')) exit('No direct script access allowed'); 
$stageNumber = 1;
$addSpaceProjectId = $this->session->userdata('addSpaceProjectId');
// set base url
$baseUrl = formBaseUrl();
// get session value of edit media mode
$isEditMedia = $this->session->userdata('isEditMedia');
// set enchor end tag in edit mode
$anchorEnd = '';
$editCls = '';

$projCategory = (isset($projCategory)) ? $projCategory : '';

if(!empty($isEditMedia) && isset($projectId)) {
	$isEditMedia = true;
	$anchorEnd = '</a>';
}

?>
<!--  content wrap  start end -->
<div class="newlanding_container">
	<div class="wizard_wrap fs14">
		<div class="TabbedPanels " id="TabbedPanels1">
            <?php if(empty($addSpaceProjectId) && empty($isEditMedia)) { ?>
                <ul id="man_haedtab" class="TabbedPanelsTabGroup pt16 mb10 position_relative z_index_3">
					<?php if((strpos($s1menu, 'frist_1') !== false)) { ?>
						<li class="TabbedPanelsTab <?php echo $s1menu = isset($s1menu)?$s1menu:'';?>" ><span> Stage <?php echo $stageNumber; $stageNumber = $stageNumber +1;?><?php echo $this->lang->line('stage1MediaShowcaseSetup');?></span></li>
                    <?php 
					}
                    if((strpos($s1menu, 'frist_1') === false)) {
                        $projSellstatus = (isset($projSellstatus) && $projSellstatus == 'f')?'f':'t';
                        if($projSellstatus =='t'){ ?>
                            <li class="TabbedPanelsTab <?php echo isset($s2menu)?$s2menu:'';?>" ><span>Stage <?php echo $stageNumber; $stageNumber = $stageNumber +1;?><?php echo $this->lang->line('stage2MediaShowcaseSetup');?></span></li>
                            <?php 
                        }
                        ?>
                        <li class="TabbedPanelsTab <?php echo isset($s3menu)?$s3menu:'';?>"><span>Stage <?php echo $stageNumber; $stageNumber = $stageNumber +1;?><?php echo $this->lang->line('stage3MediaShowcaseSetup');?></span></li>
                        <li class="TabbedPanelsTab <?php echo isset($s4menu)?$s4menu:'';?>"><span>Stage <?php echo $stageNumber; $stageNumber = $stageNumber +1;?><?php echo $this->lang->line('stage4MediaShowcaseSetup'.$projCategory);?></span></li>
                        <li class="TabbedPanelsTab <?php echo isset($s5menu)?$s5menu:'';?>"><span>Stage <?php echo $stageNumber; $stageNumber = $stageNumber +1;?><?php echo $this->lang->line('stage5MediaShowcaseSetup'.$projCategory);?></span></li>
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
