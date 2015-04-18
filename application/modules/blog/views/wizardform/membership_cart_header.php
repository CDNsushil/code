<?php if (!defined('BASEPATH')) exit('No direct script access allowed'); 
$stageNumber = 1;
// set form url
$absoluteFormUrl =  base_url(lang());
$addSpaceProjectId = $this->session->userdata('addSpaceProjectId');
?>
<!--  content wrap  start end -->
<div class="newlanding_container">
	<div class="wizard_wrap fs14">
		<div class="TabbedPanels " id="TabbedPanels1">
			<!-- ================================main tab content  ======================= -->
			<div class="TabbedPanelsContentGroup main_tab m_auto"> 
				<div class="TabbedPanelsContent  TabbedPanelsContentVisible tab_setting Upload_wrap" style="display: block;">
                  
					<ul class="TabbedPanelsTabGroup second_ul pt20 pb20">
						<li class="TabbedPanelsTab <?php echo isset($membership2menu)?$membership2menu:'';?>"><span>Step <?php echo $stageNumber; $stageNumber = $stageNumber +1;?><?php echo $this->lang->line('showcaseCartStep2');?></span></li>
						<li class="TabbedPanelsTab <?php echo isset($membership3menu)?$membership3menu:'';?>"><span>Step <?php echo $stageNumber; $stageNumber = $stageNumber +1;?><?php echo $this->lang->line('showcaseCartStep3');?></span></li>
						<li class="TabbedPanelsTab <?php echo isset($membership4menu)?$membership4menu:'';?>"><span>Step <?php echo $stageNumber; $stageNumber = $stageNumber +1;?><?php echo $this->lang->line('showcaseCartStep4');?></span></li>
						<li class="TabbedPanelsTab <?php echo isset($membership5menu)?$membership5menu:'';?>"><span>Step <?php echo $stageNumber; $stageNumber = $stageNumber +1;?><?php echo $this->lang->line('showcaseCartStep5');?></span></li>
					</ul>
					<?php $this->load->view($innerPage);?>
				</div>
			</div>
		</div>
	</div>
</div>
